<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
//
// Submit Order Code
// Included in Head.php3
//
// Purpose: Extracts user info, cart info and checks
// to see if the fields are filled out.
// If not, takes user back to form to encourage them to fill it out.
//

// Select the Users Bill To information
$query = "Select * from billto where user_id = '$PHP_AUTH_USER'";
$select = mysql($database,$query);
$billto_fname=mysql_result($select,0,"fname");
$billto_lname=mysql_result($select,0,"lname");
$billto_addr1=mysql_result($select,0,"addr1");
$billto_addr2=mysql_result($select,0,"addr2");
$billto_city=mysql_result($select,0,"city");
$billto_province=mysql_result($select,0,"province");
$billto_country=mysql_result($select,0,"country");
$billto_pcode=mysql_result($select,0,"pcode");
$billto_phone=mysql_result($select,0,"phone");
$billto_fax=mysql_result($select,0,"fax");
$billto_email=mysql_result($select,0,"email");

// Select the users Ship To Information
$query = "Select * from shipto where user_id = '$PHP_AUTH_USER'";
$select = mysql($database,$query);
$shipto_fname=mysql_result($select,0,"fname");
$shipto_lname=mysql_result($select,0,"lname");
$shipto_addr1=mysql_result($select,0,"addr1");
$shipto_addr2=mysql_result($select,0,"addr2");
$shipto_city=mysql_result($select,0,"city");
$shipto_province=mysql_result($select,0,"province");
$shipto_country=mysql_result($select,0,"country");
$shipto_pcode=mysql_result($select,0,"pcode");
$shipto_phone=mysql_result($select,0,"phone");
$shipto_fax=mysql_result($select,0,"fax");
$shipto_email=mysql_result($select,0,"email");
$shipto_method=mysql_result($select,0,"method");

//Select the users Payment information
$query = "Select * from payment where user_id = '$PHP_AUTH_USER'";
$select = mysql($database,$query);
$card_number=mysql_result($select,0,"card_number");
$card_name=mysql_result($select,0,"card_name");
$exp_month=mysql_result($select,0,"exp_month");
$exp_year=mysql_result($select,0,"exp_year");
$pay_method=mysql_result($select,0,"pay_method");
$order_date = time();

// Check to see if the forms were filled out correctly.
if($billto_fname == ""){
	$message = "Please fill out the Bill To Information";
	$prev_action = $action;
	$action = "Edit Bill To Info";
	$update = "False";
}else if($shipto_fname == ""){
	$message = "Please fill out the Ship To Information";
	$prev_action = $action;
	$action = "Edit Ship To Info";
	$update = "False";
}else if($pay_method == ""){
	$message = "Please fill out the Payment Information";
	$prev_action = $action;
	$action = "Edit Payment Info";
	$update = "False";
}else{
	// If the required data is present, go ahead and build the order
	// first, enter user info into the order_completed table
	$query = "Insert into order_completed 
	(session,merchant_id,user_id,billto_lname,billto_fname,
	billto_addr1,billto_addr2,billto_city,billto_country,
	billto_pcode,billto_phone,billto_fax,billto_email,
	shipto_fname,shipto_lname,shipto_addr1,shipto_addr2,
	shipto_city,shipto_province,shipto_country,shipto_pcode,
	shipto_phone,shipto_fax,shipto_email,shipto_method,
	card_number,card_name,exp_month,exp_year,pay_method,order_date,
	ship_cost,tax,credit_surcharge) 
	values 
	('$session',$merchant_id,'$PHP_AUTH_USER','$billto_lname',
	'$billto_fname','$billto_addr1','$billto_addr2','$billto_city',
	'$billto_country','$billto_pcode','$billto_phone','$billto_fax',
	'$billto_email','$shipto_fname','$shipto_lname','$shipto_addr1',
	'$shipto_addr2','$shipto_city','$shipto_province',
	'$shipto_country','$shipto_pcode','$shipto_phone','$shipto_fax',
	'$shipto_email','$shipto_method','$card_number','$card_name',$exp_month,
	$exp_year,'$pay_method',$order_date,$ship_cost,$tax,$credit_surcharge)";
	$insert = mysql($database,$query);
	print(mysql_error());

	// Get the invoice number set by the above insert
	$query = "Select invoice_num from order_completed where user_id = '$PHP_AUTH_USER' and session = '$session' order by invoice_num desc limit 1";
	$select = mysql($database,$query);
	$invoice_num = mysql_result($select,0,"invoice_num");
	print(mysql_error());

	// Next, loop through cart to find items for this session
	$query = "Select * from cart where session = '$session'";
	$select = mysql($database,$query);
	$rows = mysql_numrows($select);
	$row=0;

	While($row<$rows){
		$item_id = mysql_result($select,$row,"item_id");
		$quantity = mysql_result($select,$row,"quantity");
		$description = BuildDescription($description_label,$item_id);

		// Get value for item
		$query = "Select * from $table where $item_label = $item_id";
		$select3 = mysql($database,$query);
		echo mysql_error();
		$price = mysql_result($select3,"0","price") + 25;

		// For each item, make an entry in the order_cart
		$query = "Insert into order_cart (invoice_num,merchant_id,item_id,quantity,description,price) ";
		$query .= "values ($invoice_num,$merchant_id,'$item_id',$quantity,'$description',$price)";
		$insert = mysql($database,$query);
		print(mysql_error());
		$row++;
	}

	// Delete the contents of the Session cart.
	$query = "Delete from cart where session = '$session' and merchant_id = $merchant_id";
	$delete = mysql($database,$query);
	// Make up a new session ID
	$session = uniqid($remote_host);
}
?>