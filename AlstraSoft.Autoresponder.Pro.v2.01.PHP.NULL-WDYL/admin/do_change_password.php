<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$db = new DB_Sql;
	
	// verificam daca parolele coincid
	if ($password != $confirm_password)
		error_page("Passwords do not match!");

	// verificam daca parola veche e buna	
	$query = "SELECT settings_value
				FROM settings 
				WHERE settings_name = 'administrator_password' ";
	$db->query($query);

	if ($db->num_rows() != 1)
		error_page("Cannot find old password :)");

	$db->next_record();

	if (md5($old_password) != $db->f("settings_value"))
		error_page("Incorrect old password");

	$md5password = md5($password);

	$query = "UPDATE settings 
				SET settings_value = '$md5password'
				WHERE settings_name = 'administrator_password' ";
	$db->query($query);

	redirect("edit_settings.php");
?>