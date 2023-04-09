<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$on_style = "bgcolor='#FFFFFF'";
$off_style = "bgcolor='#C0C0C0'";
$link=EchoLinkVars();
?>

<center>
<table border="0" cellpadding="0" cellspacing="0" width="95%" height="35">
  <tr>
    <td width="20%" align="center" <? if($action == "View Cart" || $action == "Update Cart"){echo $on_style;}else{echo $off_style;}?>>
	<center>View Cart</center>
	</td>
	<td width="80%" align="center" <? if($action == "Invoice" || $action == "Edit Bill To Info" || $action == "Edit Ship To Info" || $action == "Edit Payment Info"){echo $on_style;}else{echo $off_style;}?>>
	<center>Invoice</center>
	</td>
  </tr>
</table>
</center>
