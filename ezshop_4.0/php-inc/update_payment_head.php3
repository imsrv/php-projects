<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$query = "Select user_id from payment where user_id = '$PHP_AUTH_USER'";
$select = mysql($database,$query);
$rows = mysql_numrows($select);
if($rows == 0){
	$query = "Insert into payment ";
	$query .= "(user_id,pay_method,card_number,exp_month,exp_year,card_name) ";
	$query .= "values ";
	$query .= "('$PHP_AUTH_USER','$pay_method','$card_number',$exp_month,$exp_year,'$card_name')";
	$insert = mysql($database,$query);
	echo mysql_error();
}else{
	$query = "Update payment set ";
	$query .= "pay_method = '$pay_method',";
	$query .= "card_number = '$card_number',";
	$query .= "exp_month = $exp_month,";
	$query .= "exp_year = $exp_year, ";
	$query .= "card_name = '$card_name' ";
	$query .= "where user_id = '$PHP_AUTH_USER'";
	$update = mysql($database,$query);
	echo mysql_error();
}

if(isset($prev_action)){
	$action = $prev_action;
}else{
	$action = "Invoice";
}
?>