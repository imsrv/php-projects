<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/prospects_htmlform");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_prospects_htmlform", "prospects_htmlform.tpl");
	$template->set_var("USER_NAME", $name);

	// generarea HTML Form-ului
	$template->set_file("tpl_html_form", "html_form.tpl");
	$template->set_var("USER_ID", $UserID);
	$template->set_var("SELFPATH", $SelfPath);
	$template->parse("HTMLFORM", "tpl_html_form");

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_prospects_htmlform");
	require("template_make.php");
?>
