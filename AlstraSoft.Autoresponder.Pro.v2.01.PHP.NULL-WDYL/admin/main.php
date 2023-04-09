<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/main");
	$db = new DB_Sql;
	
	// cream pagina din template
	$template->set_file("tpl_main", "main.tpl");

	// crearea output-ului propriu-zis
	$template->parse("output", "tpl_main");
	$template->p("output");			
?>
