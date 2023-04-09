<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// This section adds or removes items from the cart.
// If the user puts a 0 in the quantity field, the item is removed from the 
// cart table.
$row=0;
$rows = count($item_id);
while($row < $rows){
	if($quantity[$row]==0){
		// remove item from basket
		$query = "Delete from cart where item_id = $item_id[$row]";
		$delete = mysql($database,$query);
	}else{
		// Update Quantity for item
		$create_time = time();
		$query = "Update cart set ";
		$query .= "quantity=$quantity[$row],";
		$query .= "create_time=$create_time ";
		$query .= "where session='$session' and item_id=$item_id[$row]";
		$update = mysql($database,$query);
	}
	$row++;
}
?>