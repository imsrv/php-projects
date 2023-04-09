<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// Add Cart Item to cart
// This requires the following variables to be present:
// $item_id - the unique identifier of users database, as an array
// $session - unique session identifier
// $quantity - how many of item_id to put into the cart
			
$item_row=0;
$item_rows=count($item_id);
while($item_row<$item_rows){
$query = "Select quantity from cart where session='$session' and item_id = $item_id[$item_row]";
$result = mysql($database,$query);
$rows = mysql_numrows($result);
if($rows > 0){
	$old_quantity = mysql_result($result,0,"quantity");
	$new_quantity = $quantity[$item_row] + $old_quantity;
	$create_time = time();
	$query = "Update cart set ";
	$query .= "quantity=$new_quantity,";
	$query .= "create_time=$create_time ";
	$query .= "where session='$session' and item_id=$item_id[$item_row]";
	$update = mysql($database,$query);
}else{
	$create_time = time();
	$query = "Insert into cart ";
	$query .= "(session,merchant_id,item_id,quantity,create_time) ";
	$query .= "values ";
	$query .= "('$session',$merchant_id,$item_id[$item_row],$quantity[$item_row],$create_time)";
	$insert = mysql($database,$query);
}
// Empty old cart items.
// This is where the clean up of the cart table happens
// Each time the cart is updated, we will clean up old sessions. 
// The value here is to delete stuff older than one day
// change the value of 86400 to whatever time limit you want on cart items
$exp_time = (time() - 86400);
$query = "Delete from basket where create_time < $exp_time";
$delete = mysql($database,$query);
$item_row++;
}
?>