<?php
/* Nullified by WDYL-WTN */
	require("include/globals.php");
	require("include/db_mysql.php");
	require("include/template.php");
	require("include/functions.php");
	require("include/validation.php");
		
	$db = new DB_Sql;

	if (!isset($id))
		error_page("Unknown ID");

	AssumeIsNotEmpty($id, "Unknown ID");
	AssumeIsString($id, "Unknown ID");

	// cautam daca avem un subscriber cu md5(id) dat
	$query = "UPDATE subscribers 
				SET subscribers_active = '0'
				WHERE md5(subscribers_id) = '$id' ";
	$db->query($query);

	if (mysql_affected_rows($db->link_id()) == 0)
		error_page("Unknown ID");
	
	$template = new Template("templates/unsubscription_done");
	$template->set_file("tpl_unsubscription_done", "unsubscription_done.tpl");

	$template->parse("output", "tpl_unsubscription_done");
	$template->p("output");
?>