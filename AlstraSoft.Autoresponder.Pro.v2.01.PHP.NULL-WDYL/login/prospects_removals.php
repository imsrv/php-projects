<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/prospects_removals");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_prospects_removals", "prospects_removals.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de subscrisi care au facut unsubscribe
	$template->set_file("tpl_subscriber_row", "subscriber_row.tpl");

	$query = "SELECT * FROM subscribers
				WHERE 
					subscribers_user_id = '$UserID' AND
					subscribers_active = 0
				ORDER BY subscribers_name";
	$db->query($query);

	$template->set_var("SUBSCRIBERS_NUMBER", $db->num_rows());

	if ($db->num_rows() == 0)
	{
		$template->set_file("tpl_row_none", "row_none.tpl");
		$template->parse("SUBSCRIBER_LIST", "tpl_row_none");
		$template->set_var("LIST_MENU", "");
	}
	else
	{
		while ($db->next_record())
		{
			$join_date = $db->f("subscribers_join_date");
			$join_date = Date::fromMysqlDatetime($join_date);
			$join_date = $join_date->toString(FMT_DATEUS);

			$template->set_var("SUBSCRIBER_ID", $db->f("subscribers_id"));
			$template->set_var("NAME", $db->f("subscribers_name"));
			$template->set_var("EMAIL", $db->f("subscribers_email"));
			$template->set_var("DATE", $join_date);
			$template->parse("SUBSCRIBER_LIST", "tpl_subscriber_row", true);
		}

		// afisam meniu referitor la lista de subscrisi
		$template->set_file("tpl_list_menu", "list_menu.tpl");
		$template->parse("LIST_MENU", "tpl_list_menu");
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_prospects_removals");
	require("template_make.php");
?>
