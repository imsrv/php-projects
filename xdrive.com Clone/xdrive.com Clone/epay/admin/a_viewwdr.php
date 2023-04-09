<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
$pending = ((int)$_GET['t'] ? 1 : 0);
while ($a = each($_GET))
  if ($a[0] != 'from')
    $request[] = "$a[0]=$a[1]";
$request = implode("&", $request);

if ($_POST['confirm'])
{
  mysql_query("UPDATE epay_transactions SET pending=0,orderno='".addslashes($_POST['on'.$_POST['confirm']])."' WHERE id=".(int)$_POST['confirm']);
  echo $reload_left;
}
elseif ($_GET['del'])
{
  mysql_query("DELETE FROM epay_transactions WHERE id=".(int)$_GET['del']);
  echo $reload_left;
}
?>

<FONT size=+1>Withdrawals <?=($pending ? "(pending)" : "(archived)")?></font>
<BR>
<TABLE class=design cellspacing=0 width=100%>
<FORM method=post name=form1>
<INPUT type=hidden name=confirm>
<TR><TH>Date
	<TH>User
	<TH>Amount
	<TH>Via
	<TH>Fees
	<TH>To pay
	<TH>Order No
  <? if ($pending) echo "<TH>&nbsp;"; ?>
  
<?
$qr1 = mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE (paidto>10 AND paidto<100) AND pending=$pending");
list($total) = mysql_fetch_row($qr1);

$limit = (int)$_GET['from'].",".$max_elements;
$qr1 = mysql_query("SELECT * FROM epay_transactions WHERE (paidto>10 AND paidto<100) AND pending=$pending ORDER BY trdate DESC LIMIT $limit");
while ($a = mysql_fetch_object($qr1))
{
  $qr2 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidby"));
  $via = $tr_sources[$a->paidto];
?>
<TR><TD>
	<?=prdate($a->trdate)?>
	<TD>
	<a href=right.php?a=user&id=<?=$qr2->username?>&<?=$id?>><?=$qr2->username?></a>
	<TD>
	<?=prsumm($a->amount)?>
	<TD>
	<?=$via?>
	<TD>
	<?=prsumm($a->fees)?>
	<TD>
	<?=prsumm($a->amount - $a->fees)?>
	<TD>
    <?=( $pending ? "<input type=text name=on$a->id>" : ($a->orderno ? htmlspecialchars($a->orderno) : "&nbsp;") )?>
  <?=( $pending ? "<TD><a href=# onClick=\"form1.confirm.value=$a->id; form1.submit(); return false;\">Confirm</a> <a href=right.php?a=viewwdr&del=$a->id&$id>Delete</a>" : "" )?>
<?
  echo "<tr><td colspan=",($pending ? 8 : 7),"><small>",nl2br(htmlspecialchars($a->addinfo)),"</small>";
}
if (!$total)
  echo "<TR><TD colspan=8>No Withdrawals Reported.";
?>

</TD>
</FORM>
</TABLE>
<BR>

<?
if ($total)
{
  for ($i = 0; $i < $total; $i += $max_elements)
  {
    $x1 = $i + 1;
    $x2 = $i + $max_elements;
    if ($x2 > $total) $x2 = $total;
    if ($_GET['from'] == $i)
      echo "<b>$x1-$x2</b> ";
    else
      echo "<a href=right.php?$request&from=$i style='color: #CCCCCC;'>$x1-$x2</a> ";
  }
}
?>