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
$today = getdate();

if ($_GET['del'])
{
  $id = (int)$_GET['del'];
  mysql_query("DELETE FROM epay_transactions WHERE id={$id}");
  unset($_GET['del']);
}
elseif ($_GET['edit'])
{
  $id = (int)$_GET['edit'];
  $_GET['id'] = $id;
  require("admin/g_trans.php");
  if ($_fpr_err) exit;
  unset($_GET['edit']);
}

switch ($_GET['source'])
{
case 'd':
  if (!$_GET['dday']) $_GET['dday'] = $today['mday'];
  if (!$_GET['dmonth']) $_GET['dmonth'] = $today['mon'];
  if (!$_GET['dyear']) $_GET['dyear'] = $today['year'];
  $date1 = mktime(0, 0, 0, $_GET['dmonth'], $_GET['dday'], $_GET['dyear']);
  $date2 = mktime(0, 0, 0, $_GET['dmonth'], $_GET['dday'] + 1, $_GET['dyear']);
  $period = date("d F Y", $date1);
  break;
case 'm':
  if (!$_GET['mmonth']) $_GET['mmonth'] = $today['mon'];
  if (!$_GET['myear']) $_GET['myear'] = $today['year'];
  $date1 = mktime(0, 0, 0, $_GET['mmonth'], 1, $_GET['myear']);
  $date2 = mktime(0, 0, 0, $_GET['mmonth'] + 1, 1, $_GET['myear']);
  $period = date("F Y", $date1);
  break;
case 'y':
  if (!$_GET['yyear']) $_GET['yyear'] = $today['year'];
  $date1 = mktime(0, 0, 0, 1, 1, $_GET['yyear']);
  $date2 = mktime(0, 0, 0, 1, 1, $_GET['yyear'] + 1);
  $period = date("Y", $date1);
  break;
}
?>
<FONT size=+1>Transactions for: <?=$period?></font>
<BR>
<TABLE class=design cellspacing=0 width=100%>
<TR><TH>Date
	<TH>User
	<TH>Description
	<TH>Amount
	<TH>Via
	<TH>Fees
  
<?
$qr1 = mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE ((paidby>10 AND paidby<98) OR (paidto>10 AND paidto<98)) AND UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2 ORDER BY trdate");
list($total) = mysql_fetch_row($qr1);

function getimplode()
{
  global $_GET;
  reset($_GET);
  while (list($k,$v) = each($_GET))
    $r[] = urlencode($k)."=".urlencode($v);
  return implode("&", $r);
}
$link = getimplode();

$limit = (int)$_GET['from'].",".$max_elements;
$qr1 = mysql_query("SELECT * FROM epay_transactions WHERE ((paidby>10 AND paidby<98) OR (paidto>10 AND paidto<98)) AND UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2 ORDER BY trdate LIMIT $limit");
while ($a = mysql_fetch_object($qr1))
{
  if ($a->paidby < 100)
  {
    $qr2 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidto"));
    $via = $tr_sources[$a->paidby];
  }
  else
  {
    $qr2 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidby"));
    $via = $tr_sources[$a->paidto];
    $a->amount = -$a->amount;
  }
?>
<TR><TD>
	<?=prdate($a->trdate)?>
	<TD>
	<a href=# onClick="window.open('right.php?a=user&id=<?=$qr2->username?>&<?=$id?>','epay','width=500,height=500,toolbar=no'); return false;"><?=$qr2->username?></a>
	<TD>
	<?=htmlspecialchars($a->comment)?>
	<TD>
	<?=prsumm($a->amount, 1)?>
	<a href="right.php?<?=$link?>&edit=<?=$a->id?>">Edit</a>
	<a href="right.php?<?=$link?>&del=<?=$a->id?>"<?=$del_confirm?>>Del</a>
	<TD>
	<?=$via?>
	<TD>
	<?=prsumm($a->fees, 1)?>
<?
}
if (!$total)
  echo "<TR><TD colspan=6>No Transactions Reported For The Specified Date.";
?>

</TD>
</TABLE>
<BR>

<?
if ($total)
{
  while ($a = each($_GET))
    if ($a[0] != 'from')
      $request[] = "$a[0]=$a[1]";
  $request = implode("&", $request);
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