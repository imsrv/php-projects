<?php
/* Nullified by WDYL-WTN */
	require("include/template.php");
	require("include/globals.php");
	require("include/functions.php");
	

	if (isset($affiliate))
	{
		$template = new Template("templates/signin");
		$template->set_file("tpl_signup", "signin_aff.tpl");
		$template->set_var("AFFILIATE_ID", $affiliate);
	}
	else
	{
		$template = new Template("templates/signup");
		$template->set_file("tpl_signup", "signup.tpl");
		$template->set_var("AFFILIATE_ID", "");
	}
	if (isset($payer_email))
	{
		$template->set_var("paid", "1");
	}
	else
	{
		$template->set_var("paid", "0");
	}
	$template->parse("content", "tpl_signup");
	
	$template->set_file("template_main", "../../login/templates/main.htm");
	$template->set_var("sitename",$SiteName);

	$template->set_var("campaign","");
	$template->set_var("path","");
	$template->parse("main","template_main");
	$template->p("main");
?>