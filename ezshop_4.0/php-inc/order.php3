<p align="center"><big>The following items have been<br> added to your Shopping Cart:</big></p>

<p align="left">
<script language="php">
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
reset($item_id);
reset($quantity);
$item_row=0;
$item_rows=count($item_id);
while($item_row<$item_rows){
	if($quantity[$item_row] > 0){
		$description = BuildDescription($description_label,$item_id[$item_row]);
		echo "$quantity[$item_row] of Item ID: $item_id[$item_row] - <b>$description</b><br>\n";
	}
	$item_row++;
}
</script>
</p>
<br>
