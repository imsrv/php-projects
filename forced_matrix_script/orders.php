<? 
/*
Logicodes.com (c) 2003 http://www.logicodes.com
License for one domain only, you may purchase re-sell rights
by contacting us at www.logicodes.com
CopyRight 2003 under Commonwealth Act 1967 violations will
result in $10,000 fine and.or 2 years imprisonment.
Enjoy our script, created by: Logicodes.com 
 */
include("functions.php"); 
db_connect();

$affid=$refid;

$admin=db_result_to_array("select defurl, affdir, paypaladdr, adminpath, testmode from admininfo");
$returnurl=$admin[0][0]."/".$admin[0][1]."paymentpaypal.php";
$returnurl=str_replace("///", "/", $returnurl);
$returnurl=str_replace("//", "/", $returnurl);
$returnurl="http://".$returnurl;
$paypaladdr=$admin[0][2];

$testmode=$admin[0][4];

$adminpath=$admin[0][3];
//require_once($adminpath."connection.php");

//mysql_select_db($database_sm);
$query_progs = "SELECT programs.* FROM programs, aff_payments where aff_payments.programid=programs.id";
$progs = mysql_query($query_progs);
$row_progs = mysql_fetch_assoc($progs);
$totalRows_progs = mysql_num_rows($progs);

//checking if we are in the test mode
if ($testmode) $paymenturl="http://www.eliteweaver.co.uk/testing/ipntest.php";
else $paymenturl="https://www.paypal.com/cgi-bin/webscr";

?>
<? include ('header.php'); 
if ($row_progs)
{
?>
<table width="500" cellspacing="0" cellpadding="0" align=center>
  <tr bgcolor="#A6A4ED">

    <td colspan=3 align=center><font color="#FFFFFF">Programs:</font></td>

  </tr>
  <tr bgcolor="#A6A4ED">
    <td width="15%"><font color="#FFFFFF">&nbsp;</font></td>
    <td width="15%"><font color="#FFFFFF">Name</font></td>
    <td width="34%"><font color="#FFFFFF">Price</font></td>
  </tr>
  <?php do { ?>
  <? $i++ ?>
  <tr bgcolor="<? echo (round($i/2) == ($i/2) ? "#f1f1f1" : ""); ?>">
    <td>
	<?/*echo "<form action=\"http://www.eliteweaver.co.uk/testing/ipntest.php\" method=\"post\">

<input type=\"hidden\" name=\"cmd\" value=\"_xclick-subscriptions\">
<input type=\"hidden\" name=\"business\" value=\"$paypaladdr\">
<input type=\"hidden\" name=\"item_name\" value=\"".$row_progs['title']."\">
<input type=\"hidden\" name=\"currency_code\" value=\"USD\">
<input type=\"hidden\" name=\"ammount\" value=\"".number_format($row_progs['price'],2)."\">
<input type=\"hidden\" name=\"a1\" value=\"2\">
<input type=\"hidden\" name=\"p1\" value=\"1\">
<input type=\"hidden\" name=\"t1\" value=\"M\">
<input type=\"hidden\" name=\"a3\" value=\"7.95\">
<input type=\"hidden\" name=\"p3\" value=\"1\">
<input type=\"hidden\" name=\"t3\" value=\"M\">
<input type=\"hidden\" name=\"return\" value=\"$returnurl\">
<input type=\"hidden\" name=\"cancel_return\" value=\"\">
<input type=\"hidden\" name=\"item_number\" value=\"".$row_progs['id']."\">
<input type=\"hidden\" name=\"src\" value=\"1\">
<input type=\"hidden\" name=\"sra\" value=\"1\">
<input type=\"hidden\" name=\"no_shipping\" value=\"1\">
<input type=\"hidden\" name=\"no_note\" value=\"1\">
<input type=\"image\" src=\"https://www.paypal.com/images/x-click-but24.gif\" border=\"0\" name=\"submit\" alt=\"Make payments with PayPal - it's fast, free and secure!\">

</form>";*/

$affitem_num=db_result_to_array("select id from aff_payments where programid='".$row_progs['id']."'");
		   ?>
	<a href="<?echo $paymenturl?>?cmd=_xclick&business=<?echo $paypaladdr?>&no_note=1&return=<?echo $returnurl?>&notify_url=<?echo "yes"?>&amount=$<?echo number_format($row_progs['price'],2)?>&item_number=<?php echo $affitem_num[0][0]; ?>&item_name=<?php echo $row_progs['title']; ?>"><img src='https://www.paypal.com/images/x-click-but5.gif' border='0' width=72 height=25  alt='Make payments with PayPal - it's fast, free and secure!'></a></td>
    <td><?php echo $row_progs['title']; ?></td>
    <td>$<?php echo number_format($row_progs['price'],2); ?></td>
  </tr>
  <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
  <tr bgcolor="#A6A4ED">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table><br><br>
<?
}
$query_progs = "SELECT * FROM aff_payments where programid=0 and subscrid=0";
$progs = mysql_query($query_progs) or die(mysql_error());
$row_progs = mysql_fetch_assoc($progs);
$totalRows_progs = mysql_num_rows($progs);
if ($row_progs)
{?>

<table width="500" cellspacing="0" cellpadding="0" align=center>
  <tr bgcolor="#A6A4ED">
    <td colspan=3 align=center><font color="#FFFFFF">Products:</font></td>
  </tr>
  <tr bgcolor="#A6A4ED">
    <td width="15%"><font color="#FFFFFF">&nbsp;</font></td>
    <td width="15%"><font color="#FFFFFF">Name</font></td>
    <td width="34%"><font color="#FFFFFF">Price</font></td>
  </tr>
  <?php do { ?>
  <? $i++; 
  ?>
  <tr bgcolor="<? echo (round($i/2) == ($i/2) ? "#f1f1f1" : ""); ?>">
    <td>

	<a href="<?echo $paymenturl?>?cmd=_xclick&business=<?echo $paypaladdr?>&no_note=1&return=<?echo $returnurl?>&notify_url=yes&amount=$<?echo number_format($row_progs['price'],2)?>&item_number=<?php echo $row_progs['id']; ?>&item_name=<?php echo $row_progs['name']; ?>"><img src='https://www.paypal.com/images/x-click-but5.gif' border='0' width=72 height=25  alt='Make payments with PayPal - it's fast, free and secure!'></a></td>
    <td><?php echo $row_progs['name']; ?></td>
    <td>$<?php echo number_format($row_progs['price'],2); ?></td>
  </tr>
  <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
  <tr bgcolor="#A6A4ED">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table><br><br>

<?
}
$query_progs = "SELECT subscribtions.* FROM subscribtions, aff_payments where aff_payments.subscrid=subscribtions.id";
$progs = mysql_query($query_progs) or die(mysql_error());
$row_progs = mysql_fetch_assoc($progs);
$totalRows_progs = mysql_num_rows($progs);
if ($row_progs)
{
?>
<table width="500" cellspacing="0" cellpadding="0" align=center>
  <tr bgcolor="#A6A4ED">
    <td colspan=3 align=center><font color="#FFFFFF">Subscribtions:</font></td>
  </tr>
  <tr bgcolor="#A6A4ED">
    <td width="15%"><font color="#FFFFFF">&nbsp;</font></td>
    <td width="15%"><font color="#FFFFFF">Name</font></td>
    <td width="34%"><font color="#FFFFFF">Sign up Fee</font></td>
  </tr>
  <?php do { ?>
  <? $i++; 

$affitem_num=db_result_to_array("select id from aff_payments where subscrid='".$row_progs['id']."'");
  
  ?>
  <tr bgcolor="<? echo (round($i/2) == ($i/2) ? "#f1f1f1" : ""); ?>">
    <td>

	<a href="<?echo $paymenturl?>?cmd=_xclick-subscriptions&business=<?echo $paypaladdr?>&no_note=1&return=&notify_url=<?echo $returnurl?>&a1=$<?echo number_format($row_progs['signupfee'],2)?>&p1=1&t1=D&a3=<?echo number_format($row_progs['reoccuringfee'],2)?>&p3=<?echo $row_progs['duration']?>&t3=D&item_number=<?php echo $affitem_num[0][0]; ?>a<?echo $affid?>&item_name=<?php echo $row_progs['name']; ?>&sra=1&src=1&currency_code=USD"><img src='https://www.paypal.com/images/x-click-but5.gif' border='0' width=72 height=25  alt='Make payments with PayPal - it's fast, free and secure!'></a></td>
    <td><?php echo $row_progs['name']; ?></td>
    <td>$<?php echo number_format($row_progs['signupfee'],2); ?></td>
  </tr>
  <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
  <tr bgcolor="#A6A4ED">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table><br><br>
<?
}
 include ('footer.php'); ?>
<?php
mysql_free_result($progs);
?>