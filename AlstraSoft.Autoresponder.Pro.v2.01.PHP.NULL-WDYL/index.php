<?php
/* Nullified by WDYL-WTN */
	require("include/globals.php");
	require("include/template.php");
	require("include/db_mysql.php");
	
	$template = new Template("templates");
	$db = new DB_Sql;
	
	
	// cream pagina din template
	$template->set_file("tpl", "index.htm");

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl");
	require("template_make.php");


?>