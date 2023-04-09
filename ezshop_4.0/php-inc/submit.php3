<html>
<head>
<title>Invoice Generator</title>
</head>
<body>
<p>Now Generating order and emailing...</p>
<p><script language="php">
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// extract merchant info:
$date = date("D M d, Y",time());
$query = "Select * from merchant where merchant_id = $merchant_id";
$select = mysql($database,$query);
$merchant_name = mysql_result($select,0,"company");
$merchant_address = nl2br(mysql_result($select,0,"address"));
$merchant_postal_code = mysql_result($select,0,"postal_code");
$merchant_city = mysql_result($select,0,"city");
$merchant_province = mysql_result($select,0,"province");
$merchant_country = mysql_result($select,0,"country");
$merchant_phone = mysql_result($select,0,"sales_phone");
$merchant_fax = mysql_result($select,0,"sales_fax");
$merchant_email = mysql_result($select,0,"sales_email");
$merchant = "$merchant_name\n";
$merchant .= "Telephone: $merchant_phone\n";
$merchant .= "Fax: $merchant_fax\n";
$merchant .= "E-Mail: $merchant_email\n";
$merchant .= "$merchant_address\n";
$merchant .= "$merchant_city, $merchant_province";
$merchant .= "$merchant_country, $merchant_postal_code\n";
$merchant .= "Invoice # $invoice_num\n";
$merchant .= "Date: $date";
$query = "Select * from order_completed where user_id='$PHP_AUTH_USER' and invoice_num = $invoice_num";
$select = mysql($database,$query);
print(mysql_error());
$billto_fname=mysql_result($select,0,"billto_fname");
$billto_lname=mysql_result($select,0,"billto_lname");
$billto_addr1=mysql_result($select,0,"billto_addr1");
$billto_addr2=mysql_result($select,0,"billto_addr2");
$billto_city=mysql_result($select,0,"billto_city");
$billto_province=mysql_result($select,0,"billto_province");
$billto_country=mysql_result($select,0,"billto_country");
$billto_pcode=mysql_result($select,0,"billto_pcode");
$billto_phone=mysql_result($select,0,"billto_phone");
$billto_fax=mysql_result($select,0,"billto_fax");
$billto_email=mysql_result($select,0,"billto_email");
$shipto_fname=mysql_result($select,0,"shipto_fname");
$shipto_lname=mysql_result($select,0,"shipto_lname");
$shipto_addr1=mysql_result($select,0,"shipto_addr1");
$shipto_addr2=mysql_result($select,0,"shipto_addr2");
$shipto_city=mysql_result($select,0,"shipto_city");
$shipto_province=mysql_result($select,0,"shipto_province");
$shipto_country=mysql_result($select,0,"shipto_country");
$shipto_pcode=mysql_result($select,0,"shipto_pcode");
$shipto_phone=mysql_result($select,0,"shipto_phone");
$shipto_fax=mysql_result($select,0,"shipto_fax");
$shipto_email=mysql_result($select,0,"shipto_email");
$card_number=mysql_result($select,0,"card_number");
$card_name=mysql_result($select,0,"card_name");
$exp_month=mysql_result($select,0,"exp_month");
$exp_year=mysql_result($select,0,"exp_year");
$pay_method=mysql_result($select,0,"pay_method");
$ship_cost=mysql_result($select,0,"ship_cost");
$tax=mysql_result($select,0,"tax");
$credit_surcharge=mysql_result($select,0,"credit_surcharge");

$billto = "\n\n---------------------{Bill To}------------------\n";
$billto .= "Name: $billto_fname $billto_lname\n";
$billto .= "Address: $billto_addr1\n";
$billto .= "Address2: $billto_addr2\n";
$billto .= "City: $billto_city\n";
$billto .= "State/Province: $billto_province\n";
$billto .= "Zip/Postal Code: $billto_pcode\n";
$billto .= "Country: $billto_country\n";
$billto .= "Email: $billto_email\n";
$billto .= "Telephone: $billto_phone\n";
$billto .= "Fax: $billto_fax\n";

$shipto ="\n\n---------------------{Ship To}-------------------\n";
$shipto .="Name: $shipto_fname $shipto_lname\n";
$shipto .="Address: $shipto_addr1\n";
$shipto .="Address2: $shipto_addr2\n";
$shipto .="City: $shipto_city\n";
$shipto .="State/Province: $shipto_province\n";
$shipto .="Zip/Postal Code: $shipto_pcode\n";
$shipto .="Country: $shipto_country\n";
$shipto .="Email: $shipto_email\n";
$shipto .="Telephone: $shipto_phone\n";
$shipto .="Fax: $shipto_fax\n";
$payment = "\n\n--------------{Payment Information}------------\n";
$payment .= "Payment Information suppressed to protect purchaser... \nPlease log in to the secure server \nto retrieve payment information.\n";

$order = "\n\n------------------{Order Details}----------------\n";
$query = "Select * from order_cart where invoice_num = $invoice_num and merchant_id = $merchant_id";
$select = mysql($database,$query);
echo mysql_error();
$row=0;
$rows=mysql_numrows($select);
$order .= "ID\tQuan\tPrice\tExt\tDesc\n";

while($row < $rows){
	$item_id = mysql_result($select,$row,"item_id");
	$quantity = mysql_result($select,$row,"quantity");
	$price = mysql_result($select,$row,"price");
	$extended = 1.11;
	$extended = $price * $quantity;
	$description = mysql_result($select,$row,"description");
	$order .= "$item_id\t$quantity\t$price\t$extended\t$description\n";
	$total += $extended;
	$row++;
}
$order .= "\n\nShipping: $".$ship_cost."\n";
$order .= "Tax: $".$tax."\n";
$order .= "Bank Fee: $".$credit_surcharge."\n";
$total = $total+$ship_cost+$credit_surcharge+$tax;
$order .= "\n\nTotal: $".$total." US Dollars\n";

if($shipping == "0.00"){
	$order .= "\n\n** Note ** Your shipping charges could not be calculated... \nWe will contact you via E-Mail with the final shipping charges before your order is shipped.\n";
}

// mail(to,subject,message,headers)
$to = "\"$merchant_name\" <$merchant_email>";
$subject = "You have recieved a new order from $billto_fname $billto_lname";
$message = "You have recieved a new order. \n";
$message .= "Please visit \nhttps://www.discoveryweb.com/wine-master/winesource/admin/invoice.html?invoice_num=$invoice_num \n";
$message .= "to retrieve your order. \nA copy of the order has been provided below\n";
$message .= "--------------------{Invoice Details}-----------------\n";
$message .= $merchant.$billto.$shipto.$payment.$order;
$message .= "--------------<Thank You for choosing EasyShop!>------\n";
$headers = "From: \"EZShop On Line Shopping System\" <info@eyekon.com>";

mail($to,$subject,$message,$headers);

$to = "\"$billto_fname $billto_lname\" <$billto_email>";
$subject = "Thank you for your order!";
$message = "Below is a copy of the order you placed with $merchant_name. \n";
$message .= "Your order will be processed and sent as soon as possible\n";
$message .= "--------------------{Invoice Details}-----------------\n";
$message .= $merchant.$billto.$shipto.$payment.$order;
$message .= "---------------------{Thank You!}------------------\n";
$headers = "From: \"EZShop On Line Shopping System\" <info@eyekon.com>";

mail($to,$subject,$message,$headers);
print("The following order has been sent to $merchant_name:");
print("<pre>$message</pre>");
</script></p>

<p>Thank you for your order! A copy of this order has been emailed to you at <? print($billto_email) ?>.
<p>Please visit our other fine web sites at:
<ul>
	<li><a href="http://www.wine-master.com">http://www.wine-master.com</a>
	<li><a href="http://www.smokintoad.com">http://www.smokintoad.com</a>
</ul>
or <a href="http://www.wine-master.com/winesource">click here</a> to go back to the home page.
</body>
</html>
