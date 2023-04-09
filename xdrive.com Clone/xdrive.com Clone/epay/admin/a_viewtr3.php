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
$max_elements = 1000;

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
switch ($_GET['what'])
{
case '+':
  $where = "paidto<100";
  break;
case '-':
  $where = "paidby<100";
  break;
default:
  $where = "(paidby<100 OR paidto<100)";
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
default:
  $date1 = mktime(0, 0, 0, 1, 1, 2000);
  $date2 = mktime(0, 0, 0, 12, 31, 2020);
}

if ($_GET['u']) $uid = (int)$_GET['u'];
$whu = ($uid ? "AND (paidby=$uid OR paidto=$uid)" : "");
?>
<font size=+1>Transactions for: <?=$period?></font>
<br>

<TABLE class=design cellspacing=0 width=100%>
<tr>
  <th>Date
  <th>Paid By
  <th>Paid To
  <th>Description
  <th>Amount
  
<?
if($where)$where = "$where AND";
$qr1 = mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE $where UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2 $whu ORDER BY trdate");
list($total) = mysql_fetch_row($qr1);
$tx = 0;

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
$qr1 = mysql_query("SELECT * FROM epay_transactions WHERE $where UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2 $whu ORDER BY trdate LIMIT $limit");
while ($a = mysql_fetch_object($qr1))
{
  if ($a->paidby < 100)
  {
    $qr2 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidto"));
    $qr3 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidby"));
    //$via = $tr_sources[$a->paidby];
    $a->amount = -$a->amount;
  }
  else
  {
    $qr2 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidby"));
    $qr3 = mysql_fetch_object(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidto"));
    //$via = $tr_sources[$a->paidto];
  }
  if ($a->fees > 0 || ($a->paidby != 1 && $a->paidto != 1))
  {
    $aa->comment = "Fee for ".$a->comment;
    $aa->amount = $a->fees;
  	$tx += $aa->amount;
  }
  $tx += $a->amount;
?>
<tr>
  <td>
    <?=prdate($a->trdate)?>
  <td>
    <a href=# onclick="window.open('right.php?a=user&id=<?=$qr2->username?>&<?=$id?>','epay','height=500,width=500,toolbar=no'); return false;"><?=$qr2->username?></a>
  <td>
    <a href=# onclick="window.open('right.php?a=user&id=<?=$qr3->username?>&<?=$id?>','epay','height=500,width=500,toolbar=no'); return false;"><?=$qr3->username?></a>
  <td>
    <?=htmlspecialchars($a->comment)?>
  <td>
    <?=prsumm($a->amount, 1)?>
	  <a href="right.php?<?=$link?>&edit=<?=$a->id?>">Edit</a>
	  <a href="right.php?<?=$link?>&del=<?=$a->id?>" <?=$del_confirm?>>Del</a>
<?
	if($aa->comment){
?>
<tr>
  <td>
    <?=prdate($a->trdate)?>
  <td>
    <a href=# onclick="window.open('right.php?a=user&id=<?=$qr2->username?>&<?=$id?>','epay','height=500,width=500,toolbar=no'); return false;"><?=$qr2->username?></a>
  <td>
    <a href=# onclick="window.open('right.php?a=user&id=<?=$qr3->username?>&<?=$id?>','epay','height=500,width=500,toolbar=no'); return false;"><?=$qr3->username?></a>
  <td>
    <?=htmlspecialchars($aa->comment)?>
  <td>
    <?=prsumm($aa->amount, 1)?>
	  <a href="right.php?<?=$link?>&edit=<?=$a->id?>">Edit</a>
	  <a href="right.php?<?=$link?>&del=<?=$a->id?>" <?=$del_confirm?>>Del</a>
<?
	}
}
if (!$total)
  echo "<tr><td colspan=6>No transactions for the specified date.";
//echo "<tr><td>&nbsp;<td>&nbsp;<td align=right>Total:<td>",prsumm($tx, 1);
?>

</td>
</table>
<br>

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
