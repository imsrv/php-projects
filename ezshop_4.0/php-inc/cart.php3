<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
	// Get contents of users cart
	$query = "Select * from cart where merchant_id = $merchant_id and session = '$session'";
	$select2 = mysql($database,$query);
	$row=0;
	$rows=mysql_numrows($select2);
	if($rows == 0){
?>

<center><h2>Your shopping cart is empty</h2></center>

<?
	} else {
	if($action != "Print Invoice") {
	include("topnavbar.php3");
	}
?>
<? EchoFormVars(); ?>
<center>
      <? 
	  if($action == "Invoice"){ include("pre_invoice.php3");}
	  if($action == "Print Invoice"){ include("invoice.php3");} ?>
      <table border="0" cellpadding="0" cellspacing="0" width="95%">
        <tr>
        <th valign="top" align="center" colspan="4" bgcolor="<? print($hdr2_bgcolor)?>">&nbsp;</th>
        </tr>
        <tr>
          <th valign="top" align="center" bgcolor="<? print($hdr2_bgcolor)?>">Description</th>
          <th valign="top" align="center" bgcolor="<? print($hdr2_bgcolor)?>">Quantity </th>
          <th valign="top" align="center" bgcolor="<? print($hdr2_bgcolor)?>">Price</th>
          <th valign="top" align="right" bgcolor="<? print($hdr2_bgcolor)?>">Extended</th>
        </tr>
	<?
	$total_shipping = 0.00;
	while($row<$rows){
	$item = mysql_result($select2,$row,"item_id");
	$order_quantity = mysql_result($select2,$row,"quantity");
	$cart_quantity += $order_quantity;
	// Get value for item
	$query = "Select * from $table where $item_label = $item";
	$select3 = mysql($database,$query);
	echo mysql_error();
	$price = mysql_result($select3,"0","price") + 25;
	$unit = mysql_result($select3,"0","unit");
	$qunit = mysql_result($select3,"0","quantity");
	$extended = $price * $order_quantity;

	$total_shipping += ShippingCost($shipto_pcode,$shipto_province,$order_quantity,$unit,$qunit);
	$cart_total += $extended;
	$description = BuildDescription($description_label,$item);

	if($bgcolor == "$bdy_bgcolor"){
		$bgcolor = "$hdr2_bgcolor";
	}else{
		$bgcolor = "$bdy2_bgcolor";
	}		
	?>
        <tr>
          <td valign="top" align="left" bgcolor="<? print($bgcolor) ?>"><input type="hidden" name="item_id[]" value="<? echo $item ?>"><? echo $description ?></td>
          <td valign="top" align="center" bgcolor="<? print($bgcolor) ?>"><? if($action == "Print Invoice" || $action == "Invoice"){ print($order_quantity) ;}else{?><input type="text" name="quantity[]" size="2" value="<? echo $order_quantity; ?>"><? } ?></td>
          <td align="center" valign="top" bgcolor="<? print($bgcolor) ?>">$<? printf("%.2f",$price); ?></td>
          <td align="right" valign="top" bgcolor="<? print($bgcolor) ?>">$<? printf("%.2f",$extended); ?></td>
        </tr>
<?
	$row++;
} // endwhile cart contents
 ?>
        <tr align="center">
          <th valign="middle" align="right" colspan="4" bgcolor="<? print($hdr2_bgcolor)?>">Sub Total: $<? printf("%.2f",$cart_total); ?> </th>
        </tr>
<? if($action == "Invoice" || $action == "Print Invoice"){ ?>
        <tr align="center">
          <td valign="top" align="right" colspan="3" bgcolor="<? print($bdy2_bgcolor)?>">
	<? 
	$country = strtoupper($shipto_country);
	if($shipto_country != "USA"){
		echo "Shipping costs not calculated..";
	}else{
		echo "Shipping via UPS to ";
		print($shipto_province.",");
		print($shipto_country);
	}
	 ?><br>
	</td>
          <td align="right" valign="top" bgcolor="<? print($bdy2_bgcolor)?>">
		$<? 
		printf("%.2f",$total_shipping);
		 ?>

	<input type="hidden" name="ship_cost" value="<? print($total_shipping)?>"></td>

        </tr>
        <tr align="center">
          <td valign="middle" align="right" colspan="3" bgcolor="<? print($bdy2_bgcolor)?>">Tax
	<? $tax_rate = TaxRate($shipto_pcode,$shipto_province); print($tax_rate."%"); ?> </td>
          <td align="right" valign="middle" bgcolor="<? print($bdy2_bgcolor)?>">$<? $tax = ($cart_total+$shipping)*$tax_rate; printf("%.2f",$tax); ?>
	<input type="hidden" name="tax" value="<? print($tax)?>"></td>
        </tr>
        <tr>
          <td valign="middle" align="right" colspan="3" bgcolor="<? print($bdy2_bgcolor)?>">Bank Charge (using 3%) </td>
          <td align="right" valign="middle" bgcolor="<? print($bdy2_bgcolor)?>">$<? $surcharge = ($cart_total+$tax+$shipping)*.03; printf("%.2f",$surcharge); ?>
	<input type="hidden" name="credit_surcharge" value="<? print($surcharge)?>"></td>
        </tr>
        <tr align="center">
          <td valign="middle" align="right" colspan="3" bgcolor="<? print($bdy2_bgcolor)?>">Total (in US Dollars)</td>
          <td align="right" valign="middle" bgcolor="<? print($bdy2_bgcolor)?>">$<? printf("%.2f",$cart_total+$tax+$total_shipping+$surcharge); ?></td>
        </tr>
<? } //endif action invoice or print invoice ?>
        <tr align="center">
          <td colspan="4" align="center" bgcolor="<? print($hdr2_bgcolor)?>">&nbsp; </td>
        </tr>
        <tr align="center">
          <td colspan="4" align="center" bgcolor="<? print($hdr2_bgcolor)?>">
	<?
	if($action == "View Cart" || $action == "Update Cart"){ ?>
		<input type="submit" value="Update Cart" name="action">&nbsp; 
		<input type="submit" value="Empty Cart" name="action">
	<? }else if($action == "Invoice") { ?>
		<input type="submit" value="Print Invoice" name="action">&nbsp; 
		<? if($pay_method != "Fax/Mail"){ ?>
			<input type="submit" value="Submit Order On Line" name="action">
		<? }else{ echo "To submit this order on-line, please change your payment method... ";} ?>
	<? }else {
		print("Please Print This Invoice and Fax it to $merchant_fax<br>\n");
		if($shipping == "0.00"){
			print("** Note ** Your shipping charges could not be calculated... We will contact you via E-Mail with the final shipping charges before your order is shipped.<br>\n");
		}
	}	
	?>
<br>
<br>
         </td>
        </tr>
      </table>
</center>
</form>
<? } ?>
