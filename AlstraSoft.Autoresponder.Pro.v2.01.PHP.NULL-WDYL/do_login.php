<?php
/* Nullified by WDYL-WTN */
	require("include/globals.php");
	require("include/db_mysql.php");
	require("include/template.php");
	require("include/functions.php");
	require("include/validation.php");
	
	// verificam daca userul si parola sunt valide
	// vin "username" si "password"
	
	$db = new DB_Sql;

	// obtinem variabilele de login
//	$username = str_replace("'", "''", $username);
	AssumeIsNotEmpty($username, "You must specify an username");

	$md5password = md5($password);

	$query = "SELECT * 
				FROM users
				WHERE users_username = '$username' AND users_password = '$md5password'";
	$db->query($query);
	
	if ($db->num_rows() == 0)
	{
		// utilizator invalid
		// redirectare catre formularul de login
		redirect("signin.php");
	}
	else
	{
		// utilizator valid
		// incepem o sesiune si inregistram variabile de sesiune
		session_start();
		$db->next_record();

		session_register("UserID");
		$UserID = $db->f("users_id");
		
		// redirectare catre pagina principala (de lucru)
		redirect("login/controlpanel.php");
	}
?>