<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// Here we will query the database and add up the
// total # of items in thier basket, and thier value.

$query = "Select item_id,quantity from cart where merchant_id = $merchant_id and session = '$session'";
$select = mysql($database,$query);
$row=0;
$rows=mysql_numrows($select);
$cart_items = 0;
$total = 0.00;
while($row<$rows){
	$cart_item_id = mysql_result($select,$row,"item_id");
	$cart_quantity = mysql_result($select,$row,"quantity");
	// Get value for item
	$query = "Select price from $table where $item_label = $cart_item_id";
	$select2 = mysql($database,$query);
	echo mysql_error();
	$cart_items += $cart_quantity;
	$whsl_price = mysql_result($select2,"0","price");
	$price = 25+$whsl_price;
	$total += $price * $cart_quantity;
	$row++;
}
?>
<center>

<table border="1" cellpadding="1" cellspacing="0" width="600" bordercolor="#008000"
bordercolorlight="#808000" bordercolordark="#000080" height="30" align="center">
  <tr>
    <td width="456" bgcolor="#FFFFFF" align="center" height="11">
<?
// check to see if $items is present
// if so, display basket & checkout buttons
if(isset($cart_items)){
?>
You have <? echo $cart_items; ?> items in your basket with a value of $<? echo $total ?>.<br>
<?
  }else{
	print("Your Basket is currently Empty.<br>\n");
  }
?>

<?
$query = "SELECT DISTINCT session FROM cart";
$select = mysql($database,$query);
$sessions = mysql_numrows($select) - 1;
if($sessions > 0){
echo "There are $sessions other shoppers On-Line at this time!<br>";
}
?>
</td>
 <td width="128" bgcolor="#FFFFFF" align="center" valign="top" height="11">
  <small>
   <font color="#800000">
    <p>Powered by EasyShop<br>
    Session: <? echo $session;?><br>
    <? if(isset($PHP_AUTH_USER)){ echo "User: $PHP_AUTH_USER<br>";}
    ?>
   </font></small>
 </td>
 </tr>
</table>
</center>
<?
if(isset($debug) && $debug == "On"){
echo "Debug is $debug<br>";
echo $message;
echo " - Message<br>";
echo $upass;
echo " - upass from database<br>";
echo $PHP_AUTH_USER;
echo " - php auth user<br>";
echo $PHP_AUTH_PW;
echo " - php auth pw<br>";
error_reporting(111);
echo "Values submitted via POST method:<br>";
while ( list( $key, $val ) = each($HTTP_POST_VARS) ) {
   echo "$key => $val<br>";
}
}
?>      
