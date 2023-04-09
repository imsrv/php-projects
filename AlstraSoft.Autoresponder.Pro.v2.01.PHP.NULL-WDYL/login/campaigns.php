<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/campaings");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_campaings", "campaings.tpl");
	$template->set_var("USER_NAME", $name);

	$query="SELECT * 
			FROM users
			WHERE users_id= '$UserID'";
	$db->query($query);
	$db->next_record();
	$query="SELECT * 
			FROM users
			WHERE users_general_id= '".$db->f("users_general_id")."'";
	$db->query($query);
	$max_a=$db->nf();
	$template->set_file("campaigns_row", "campaign_row.tpl");

	while ($db->next_record())
	{
		$template->set_var("name",$db->f("users_username"));
		$template->set_var("id",$db->f("users_id"));
		$template->parse("CAMPAIGNS_LIST","campaigns_row",true);
	}
	
	$query="SELECT * 
			FROM users
			WHERE users_id= '$UserID'";
	$db->query($query);
	$db->next_record();
	if ($db->f("users_accounttype_id")==0)
	{
		$query="select * from settings where settings_name='freeaccount_nr_autoresponse_messages'";
	}
	else
	{
		$query="select * from settings where settings_name='paidaccount_nr_autoresponse_messages'";
	}

	$db->query($query);
	$db->next_record();

	if ($db->f("settings_value")>$max_a)
	{
		$template->set_var("dis","");
		$template->set_var("why","");
	}
	else
	{
		$template->set_var("dis","disabled");
		$template->set_var("why","You have reached the maximum number of campaigns (".$db->f("settings_value").").");
	}
	

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_campaings");
	//$template->p("output");			
	require("template_make.php");
?>
