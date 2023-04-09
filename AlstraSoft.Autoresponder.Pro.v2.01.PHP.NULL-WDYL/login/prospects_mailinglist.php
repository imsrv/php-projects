<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/prospects_mailinglist");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_prospects_mailinglist", "prospects_mailinglist.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de subscrisi activi
	$template->set_file("tpl_subscriber_row", "subscriber_row.tpl");
	$template->set_file("tpl_status_active", "status_active.tpl");
	$template->set_file("tpl_status_inactive", "status_inactive.tpl");

	$querySelect = "SELECT * FROM subscribers
					WHERE 
						subscribers_user_id = '$UserID' ";
	$queryOrder = "ORDER BY subscribers_name";

	// daca avem un search, atunci adaugam conditii in query
	if ( (isset($mm_start) && $mm_start != "") ||
		 (isset($dd_start) && $dd_start != "") ||
		 (isset($yyyy_start) && $yyyy_start != "") )
		$isStartDate = true;
	else
		$isStartDate = false;

	if ( (isset($mm_end) && $mm_end != "") ||
		 (isset($dd_end) && $dd_end != "") ||
		 (isset($yyyy_end) && $yyyy_end != "") )
		$isEndDate = true;
	else
		$isEndDate = false;
		 
	if ( isset($subscriber_name) && $subscriber_name != "")
		$isName = true;
	else
		$isName = false;
	
	if (isset($subscriber_email) && $subscriber_email != "")
		$isEmail = true;
	else
		$isEmail = false;

	if ($isStartDate || $isEndDate || $isName || $isEmail)
	{
		// avem un search
		$isSearch = true;

		if ($isStartDate)
		{
			// avem specificata o data de inceput
			AssumeIsNumber($yyyy_start, "Invalid Year Value");
			AssumeIsWithinRange($mm_start, "Invalid Month Value", 1, 12);
			AssumeIsWithinRange($dd_start, "Invalid Day Value", 1, 31);

			$start_date = $yyyy_start . "-" . 
						  $mm_start . "-" .
						  $dd_start . " " . "00:00:00";
			if (! Date::isMysqlDatetimeValid($start_date))
				error_page("Invalid Date");

			$querySelect .= "AND subscribers_join_date >= '$start_date' ";
		}

		if ($isEndDate)
		{
			// avem specificata o data de sfarsitf
			AssumeIsNumber($yyyy_end, "Invalid Year Value");
			AssumeIsWithinRange($mm_end, "Invalid Month Value", 1, 12);
			AssumeIsWithinRange($dd_end, "Invalid Day Value", 1, 31);

			$end_date = $yyyy_end . "-" . 
						$mm_end . "-" .
						$dd_end . " " . "23:59:59";
			if (! Date::isMysqlDatetimeValid($end_date))
				error_page("Invalid Date");

			$querySelect .= "AND subscribers_join_date <= '$end_date' ";
		}

		if ($isName)
		{
			// avem specificat un nume
			AssumeIsString($subscriber_name, "Name Is Not A Valid String Value");
//			$subscriber_name = str_replace("'", "''", $subscriber_name);

			$querySelect .= "AND subscribers_name LIKE '%$subscriber_name%' ";
		}

		if ($isEmail)
		{
			// avem specificat un email
			AssumeIsString($subscriber_email, "E-mail Is Not A Valid String Value");
//			$subscriber_email = str_replace("'", "''", $subscriber_email);

			$querySelect .= "AND subscribers_email LIKE '%$subscriber_email%' ";
		}
	}
	else
		$isSearch = false;

	// query-ul final
	$query = $querySelect . $queryOrder;
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

			$status = $db->f("subscribers_active");
			if ($status == 1)
				$template->parse("STATUS", "tpl_status_active");
			else
				$template->parse("STATUS", "tpl_status_inactive");
	
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

	// daca e rezultatul unui search, punem si link la "Show entire list"
	if ($isSearch)
	{
		$template->set_file("tpl_show_entire_list", "show_entire_list.tpl");
		$template->parse("SHOW_ENTIRE_LIST", "tpl_show_entire_list");
	}
	else
	{
		$template->set_var("SHOW_ENTIRE_LIST", "");
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_prospects_mailinglist");
	require("template_make.php");
?>
