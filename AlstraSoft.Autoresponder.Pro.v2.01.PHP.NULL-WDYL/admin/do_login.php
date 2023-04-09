<?php
/* Nullified by WDYL-WTN */
	require("../include/globals.php");
	require("../include/db_mysql.php");
	require("../include/template.php");
	require("../include/functions.php");
	require("../include/validation.php");
	
	$db = new DB_Sql;

	// obtinem variabilele de login
	if (! isset($password))
		$password = "";

	$md5password = md5($password);

	$query = "SELECT * 
				FROM settings
				WHERE settings_name = 'administrator_password' AND settings_value = '$md5password'";
	$db->query($query);
	
	if ($db->num_rows() != 1)
	{
		// utilizator invalid
		// redirectare catre formularul de login
		redirect("index.php");
	}
	else
	{
		// utilizator valid
		// incepem o sesiune si inregistram variabile de sesiune
		session_start();
		$db->next_record();

		session_register("Administrator");
		$Administrator = true;
		
		// redirectare catre pagina principala (de lucru)
		redirect("main.php");
	}
?>