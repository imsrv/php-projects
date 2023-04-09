<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
if($create_account != ""){
	if($new_email == "" || $new_user_id == "" || $new_upass == ""){
		$message = "Please ensure all fields are filled out.";
		$login="False";
		$create_account="False";
	}else{
		$query = "Insert into cart_user (user_id,upass,email) ";
		$query .= "values ('$new_user_id','$new_upass','$new_email')";
		$insert = mysql($database,$query);
		if($insert == 0){
			$message = "<p><b><br>That user name is already taken.<br>Please choose a different User ID</b></p>";
			$login= "False";
			$create_account= "False";
		}else{
			$login="True";
			$create_account="True";
		}
	}
}
?>