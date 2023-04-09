<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// obtinem datele despre noul subscris:	$email, $name
	AssumeIsNotEmpty($name, "Name of prospect must not be empty");
	AssumeIsString($name, "Name of prospect is not a valid string");
	AssumeIsNotEmpty($email, "E-mail of prospect must not be empty");
	AssumeIsString($email, "E-mail of prospect is not a valid string");
//	$name = str_replace("'", "''", $name);
//	$email = str_replace("'", "''", $email);

	$came_from = $HTTP_REFERER;
//	$came_from = str_replace("'", "''", $came_from);

	// adaugam subscrisul
	$query = "INSERT INTO subscribers (
				subscribers_user_id, 
				subscribers_name, 
				subscribers_email,
				subscribers_trouble_mailing,
				subscribers_active,
				subscribers_came_from,
				subscribers_join_date
				) VALUES (
				'$UserID', 
				'$name', 
				'$email', 
				'0', 
				'1', 
				'$came_from',
				NOW())";

	$db->query($query);

	redirect("prospects_active.php");
?>