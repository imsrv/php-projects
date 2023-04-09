<?php 
/* Nullified by WDYL-WTN */
	$template->set_file("template_main", "../login/templates/main.htm");
	$template->set_var("sitename",$SiteName);
	$query="select * from users where users_id='$UserID'";
	$db->query($query);
	$db->next_record();

	$template->set_var("campaign","");
	$template->set_var("path","");
	$template->parse("main","template_main");
	$template->p("main");
?>