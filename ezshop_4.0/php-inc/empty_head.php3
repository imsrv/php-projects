<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
// The section will be executed when the user clicks on the Empty Cart button.
// The file delete.php3 will be displayed when the cart is emptied. Put your 
// own special message to the user there.
$query = "Delete from cart where session = '$session' and merchant_id = $merchant_id";
$delete = mysql($database,$query);
$PHP_AUTH_USER = "";
$PHP_AUTH_PW = "";
$session = "";
$login = "";
$checkout = "";
$secure = "";
SetCookies(0);
?>
