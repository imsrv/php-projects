<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;
	
	AssumeIsNotEmpty($name, "You must specify a name");
	AssumeIsNotEmpty($email, "You must specify an e-mail address");
	AssumeIsEmailAddress($email, "E-mail address you specified is not a valid e-mail address");

	$query = "UPDATE users 
				SET 
					users_name = '$name',
					users_email = '$email'
				WHERE users_id = $UserID ";
	$db->query($query);

	redirect("account_editsettings.php");
?>