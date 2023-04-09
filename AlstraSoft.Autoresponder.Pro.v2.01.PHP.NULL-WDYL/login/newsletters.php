<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/newsletters");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_newsletters", "newsletters.tpl");
	$template->set_var("USER_NAME", $name);

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_newsletters");
	require("template_make.php");
?>
