<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/messages_broadcast");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_messages_broadcast", "messages_broadcast.tpl");
	$template->set_var("USER_NAME", $name);

	// implicit mesajul este plain text
	if (! isset($type))
		$type = "";

	// este plain text sau html? 
	if ($type == "html")
		$template->set_file("tpl_message", "message_html.tpl");
	else
		$template->set_file("tpl_message", "message_text.tpl");

	// completam campurile necesare
	$template->set_file("tpl_option", "option.tpl");
	$today = getdate();

	// populam lista de zile
	for ($i = 1; $i <= 31; $i++)
	{
		$template->set_var("VALUE", $i);
		$template->set_var("DESCRIPTION", $i);

		if ($i == $today['mday'])
			$template->set_var("SELECTED", "selected");
		else
			$template->set_var("SELECTED", "");

		$template->parse("DAY_LIST", "tpl_option", true);
	}
	
	// populam lista de luni ale anului
	$months = array("1" => "January", 
					"2" => "February",
					"3" => "March",
					"4" => "April",
					"5" => "May",
					"6" => "June",
					"7" => "July",
					"8" => "August",
					"9" => "September",
					"10" => "October",
					"11" => "November",
					"12" => "December");

	for ($i = 1; $i <= 12; $i++)
	{
		$template->set_var("VALUE", $i);
		$template->set_var("DESCRIPTION", $months[$i]);

		if ($i == $today['mon'])
			$template->set_var("SELECTED", "selected");
		else
			$template->set_var("SELECTED", "");

		$template->parse("MONTH_LIST", "tpl_option", true);
	}

	// populam lista de ani	
	for ($i = $today['year']; $i <= $today['year']+1; $i++)
	{
		$template->set_var("VALUE", $i);
		$template->set_var("DESCRIPTION", $i);

		if ($i == $today['year'])
			$template->set_var("SELECTED", "selected");
		else
			$template->set_var("SELECTED", "");

		$template->parse("YEAR_LIST", "tpl_option", true);
	}
	
	// populam lista de ore
	for ($i = 0; $i <= 23; $i++)
	{
		$template->set_var("VALUE", $i);
		$template->set_var("DESCRIPTION", $i < 10 ? "0".$i : $i);

		if ($i == 12)
			$template->set_var("SELECTED", "selected");
		else
			$template->set_var("SELECTED", "");

		$template->parse("HOUR_LIST", "tpl_option", true);
	}

	// populam lista de minute
	for ($i = 0; $i <= 59; $i += 5)
	{
		$template->set_var("VALUE", $i);
		$template->set_var("DESCRIPTION", $i < 10 ? "0".$i : $i);

		if ($i == 0)
			$template->set_var("SELECTED", "selected");
		else
			$template->set_var("SELECTED", "");

		$template->parse("MINUTE_LIST", "tpl_option", true);
	}

	// editarea mesajului e gata
	$template->parse("MESSAGE", "tpl_message");

	// -------------------------------------------------------------------
	// afisam Broadcast History
	$query = "SELECT *
				FROM broadcastmessages, subscribers
				WHERE 
					broadcastmessages_subscriber_id = subscribers_id AND
					broadcastmessages_sent = 1 AND
					broadcastmessages_user_id = '$UserID' ";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		// nu avem nimic in history
		$template->set_var("BROADCAST_HISTORY", "none");
		$template->set_var("CLEAR_HISTORY", "");
	}
	else
	{
		$template->set_file("tpl_clear_history", "clear_history.tpl");
		$template->parse("CLEAR_HISTORY", "tpl_clear_history");

		$template->set_file("tpl_broadcast_row", "broadcast_row.tpl");

		while ($db->next_record())
		{
			// data broadcast-ului
			$date = $db->f("broadcastmessages_delivery_date");
			$date = Date::fromMysqlDatetime($date);
			$template->set_var("DATE", $date->toString(FMT_DATETIME_US));

			// email-ul spre care s-a trimis mesaj
			$template->set_var("EMAIL", $db->f("subscribers_email"));

			// subject-ul email-ului trimis
			$template->set_var("SUBJECT", $db->f("broadcastmessages_subject"));

			$template->parse("BROADCAST_HISTORY", "tpl_broadcast_row", true);
		}
	}

	// -----------------------------------------------------------------------
	// afisam Future Broadcasts
	$query = "SELECT *
				FROM broadcastmessages, subscribers
				WHERE 
					broadcastmessages_subscriber_id = subscribers_id AND
					broadcastmessages_sent = 0 AND
					broadcastmessages_user_id = '$UserID' 
				ORDER BY broadcastmessages_delivery_date DESC ";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		// nu avem nimic planificat
		$template->set_var("FUTURE_BROADCASTS", "none");
	}
	else
	{
		$template->set_file("tpl_broadcast_row", "broadcast_row.tpl");

		while ($db->next_record())
		{
			// data broadcast-ului
			$date = $db->f("broadcastmessages_delivery_date");
			$date = Date::fromMysqlDatetime($date);
			$template->set_var("DATE", $date->toString(FMT_DATETIME_US));

			// email-ul spre care s-a trimis mesaj
			$template->set_var("EMAIL", $db->f("subscribers_email"));

			// subject-ul email-ului trimis
			$template->set_var("SUBJECT", $db->f("broadcastmessages_subject"));

			$template->parse("FUTURE_BROADCASTS", "tpl_broadcast_row", true);
		}
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_messages_broadcast");
	//$template->p("output");			
	require("template_make.php");
?>
