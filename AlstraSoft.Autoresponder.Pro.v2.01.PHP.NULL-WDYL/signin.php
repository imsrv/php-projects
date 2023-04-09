<?php
/* Nullified by WDYL-WTN */
	require("include/template.php");
	require("include/globals.php");
	
	$template = new Template("templates/signin");
	$template->set_file("tpl_signin", "signin.tpl");
	$template->parse("content", "tpl_signin");
	
	$template->set_file("template_main", "../../login/templates/main.htm");
	$template->set_var("sitename",$SiteName);

	$template->set_var("campaign","");
	$template->set_var("path","");
	$template->parse("main","template_main");
	$template->p("main");
?>