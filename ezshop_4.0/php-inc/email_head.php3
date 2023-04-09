<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$query = "Select user_id,upass from cart_user where email = '$email'";
$result = mysql($database,$query);
echo mysql_error();
$user_id = mysql_result($result,0,"user_id");
$upass = mysql_result($result,0,"upass");
$message = "Your EZShop account information is as follows:\n";
$message .= "Username: $user_id\n";
$message .= "Password: $upass\n";
$message .= "You may now log in and complete your order!";
$headers = "From: \"EZShop Account Mailer\"\n";
if($user_id != ""){
	mail($email,"Your EZShop Account Information",$message,$headers);
	$empass = "True";
}else{
	$empass = "False";
}
?>