<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;
	
	// verificam daca parolele coincid
	if ($password != $confirm_password)
		error_page("Passwords do not match!");

	// verificam daca parola veche e buna	
	$query = "SELECT users_password 
				FROM users 
				WHERE users_id = '$UserID' ";
	$db->query($query);
	$db->next_record();

	if (md5($old_password) != $db->f("users_password"))
		error_page("Incorrect old password");

	$md5password = md5($password);

	$query = "UPDATE users 
				SET users_password = '$md5password'
				WHERE users_id = $UserID ";
	$db->query($query);

	redirect("account_editsettings.php");
?>