<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
if($PHP_AUTH_PW == "" || $PHP_AUTH_USER == ""){
	Header("WWW-authenticate: basic realm=\"$realm.$session\"");
	Header("HTTP/1.0 401 Unauthorized");
	exit;
}else{
	$query = "Select * from cart_user where user_id='$PHP_AUTH_USER'";
	$select = mysql($database,$query);
	$rows = mysql_numrows($select);
	if($rows < 1){
		$message="That username is invalid... Please try again, or use the Send Password button.<br>\n";
		$login="False";
	} else {
		$upass = mysql_result($select,0,"upass");

		if($PHP_AUTH_PW == $upass){
			$login="True";
			
		}else{
			Header("WWW-authenticate: basic realm=\"$realm.$session\"");
			Header("HTTP/1.0 401 Unauthorized");
			$login ="False";
			$message = "Username/Password invalid!";
			echo $message;
			exit;
		}
	}
}

?>
