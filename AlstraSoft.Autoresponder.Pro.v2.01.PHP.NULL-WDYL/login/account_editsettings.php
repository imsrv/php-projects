<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/account_editsettings");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_account_editsettings", "account_editsettings.tpl");
	$template->set_var("USER_NAME", $name);
	
	// setam numele si adresa de email in form
	$template->set_var("NAME", $db->f("users_name"));
	$template->set_var("EMAIL", $db->f("users_email"));

	// crearea output-ului propriu-zis
	//$template->parse("output", "tpl_account_editsettings");
	$template->parse("content", "tpl_account_editsettings");
	//$template->p("output");			
	require("template_make.php");
?>
