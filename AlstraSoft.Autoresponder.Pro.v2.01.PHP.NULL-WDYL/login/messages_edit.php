<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/messages_edit");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_messages_edit", "messages_edit.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de mesage ale utilizatorului logat
	$query = "SELECT * 
				FROM messages
				WHERE 
					messages_user_id = '$UserID' AND
					messages_template_id IS NULL
				ORDER BY messages_interval, messages_subject";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		// ** nu avem nici un mesaj

		$template->set_file("tpl_row_nomessages", "row_nomessages.tpl");
		$template->parse("MESSAGE_LIST", "tpl_row_nomessages");

		$template->set_var("MESSAGE_MENU", "");

		// afisam formul de adaugare a unui mesaj nou
		// este plain text sau html?
		if (isset($type) && $type == "html")
			$template->set_file("tpl_message_add", "message_add_html.tpl");
		else
			$template->set_file("tpl_message_add", "message_add_text.tpl");

		$template->parse("MESSAGE_ADD_EDIT", "tpl_message_add");
	}
	else
	{
		// ** avem mesaje

		if (! isset($selected))
			$selected = "";
		
		$template->set_file("tpl_message_menu", "message_menu.tpl");
		$template->parse("MESSAGE_MENU", "tpl_message_menu");

		$template->set_file("tpl_row_message", "row_message.tpl");

		// cream lista de mesaje
		$i = 1;

		while ($db->next_record())
		{
			$template->set_var("SUBJECT", $db->f("messages_subject"));
			$template->set_var("MESSAGE_ID", $db->f("messages_id"));

			if (($interval = $db->f("messages_interval")) == 0)
				$template->set_var("INTERVAL", "instant");
			else
				$template->set_var("INTERVAL", "day ".$interval);

			// afisam imagine cu "stop" daca mesajul e disabled
			if ($db->f("messages_disabled") == 1)
			{
				$template->set_file("tpl_disabled_icon", "disabled_icon.tpl");
				$template->parse("STATUS", "tpl_disabled_icon");
			}
			else
				$template->set_var("STATUS", "");

			// selectam in lista de mesaje mesajul editat
			// daca nu avem mesaj de editat, selectam primul mesaj din lista
			if (($selected == "" && $i == 1) || ($selected != "" && intval($selected) == $db->f("messages_id")))
				$template->set_var("SELECTED", "checked");
			else
				$template->set_var("SELECTED", "");

			$template->parse("MESSAGE_LIST", "tpl_row_message", true);
			$i++;
		}

		// implicit mesajul este plain text
		if (! isset($type))
			$type = "";

		// determinam daca avem mesaj de editat sau nu
		if ($selected != "")
		{
			// ** AVEM MESAJ DE EDITAT -> afisam form de editare

			// completam campurile din form cu datele despre mesajul editat
			$query = "SELECT * 
						FROM messages
						WHERE messages_id = '$selected'";
			$db->query($query);

			if ($db->num_rows() != 1)
			{
				error_page("Invalid message ID");
			}
			else
			{
				$db->next_record();
				$isMessageHtml = $db->f("messages_type");

				// este plain text sau html? 
				if ($type == "html" || ($type != "text" && $isMessageHtml))
					$template->set_file("tpl_message_edit", "message_edit_html.tpl");
				else
					$template->set_file("tpl_message_edit", "message_edit_text.tpl");

				$template->set_var("SUBJECT", $db->f("messages_subject"));
				$template->set_var("BODY", $db->f("messages_body"));
				$template->set_var("INTERVAL", $db->f("messages_interval"));
				$template->set_var("MESSAGE_ID", $selected);

				if ($db->f("messages_disabled") == 1)
					$template->set_var("DISABLED", "checked");
				else
					$template->set_var("DISABLED", "");
			}
			
			$template->set_var("SELECTED", $selected);
			$template->parse("MESSAGE_ADD_EDIT", "tpl_message_edit");
		}
		else
		{
			// NU AVEM MESAJ DE EDITAT -> afisam form de adaugare de mesaj nou

			// este plain text sau html?
			if ($type == "html")
				$template->set_file("tpl_message_add", "message_add_html.tpl");
			else
				$template->set_file("tpl_message_add", "message_add_text.tpl");

			$template->parse("MESSAGE_ADD_EDIT", "tpl_message_add");
		}		
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_messages_edit");
	//$template->p("output");			
	require("template_make.php");
?>