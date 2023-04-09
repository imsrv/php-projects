<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("../admin/include/thumbnail_functions.php");
	
	session_register("UserID");

	$template = new Template("templates/newsletters_edit");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	if (! isset($selected))
		$selected = "";
		
	// cream pagina din template
	$template->set_file("tpl_newsletters_edit", "newsletters_edit.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de newsletters ale utilizatorului logat
	$query = "SELECT * 
				FROM messages
				WHERE 
					messages_user_id = '$UserID' AND
					messages_template_id IS NOT NULL
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

		FillFromTemplate();
		$template->parse("MESSAGE_ADD_EDIT", "tpl_message_add");
	}
	else
	{
		// ** avem mesaje

		$template->set_file("tpl_message_menu", "message_menu.tpl");
		$template->parse("MESSAGE_MENU", "tpl_message_menu");

		$template->set_file("tpl_row_message", "row_message.tpl");

		// cream lista de mesaje
		$i = 1;

		while ($db->next_record())
		{
			$template->set_var("MESSAGE_SUBJECT", $db->f("messages_subject"));
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
			FillFromTemplate();
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

			FillFromTemplate();
			$template->parse("MESSAGE_ADD_EDIT", "tpl_message_add");
		}		
	}

	// setam id-ul template-ului din care este editat newsletter-ul
	// punem id=0 in cazul cand nu este editat din nici un template
	if (isset($usetemplate))
		$template->set_var("TEMPLATE_ID", $usetemplate);
	else
		$template->set_var("TEMPLATE_ID", "0");

	// ** obtinem lista de template-uri pt newsletters
	if ($type == "html")
		$template_type = 1;
	else
		$template_type = 0;

	$query = "SELECT * 
				FROM newslettertemplates
				WHERE newslettertemplates_type = '$template_type'
				ORDER BY newslettertemplates_id ";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		// nu avem nici un template de newsletter disponibil
		$template->set_file("tpl_row_notemplates", "row_notemplates.tpl");
		$template->parse("NEWSLETTER_TEMPLATES_LIST", "tpl_row_notemplates");
	}
	else
	{
		$template->set_file("tpl_row_newsletter_template", "row_newsletter_template.tpl");
		$i = 1;

		while ($db->next_record())
		{
			// adaugam in URL-ul paginii curente o variabila: from_template
			$url_vars = "from_template=" . $db->f("newslettertemplates_id");
			if (isset($type) && $type != "") 
				$url_vars .= "&type=$type";
			if (isset($selected) && $selected != "") 
				$url_vars .= "&selected=$selected";

			$template->set_var("TEMPLATE_NDO", $i++);
			$template->set_var("TEMPLATE_SUBJECT", $db->f("newslettertemplates_subject"));
			$template->set_var("URL_VARS", $url_vars);
			
			$thumbnail_filename = $db->f("newslettertemplates_thumbnail_filename");
			if ($thumbnail_filename != "")
			{
				$template->set_file("tpl_thumbnail", "thumbnail.tpl");
				$template->set_var("THUMBNAIL_PATH", GetThumbnailDir() . $thumbnail_filename);
				$template->parse("TEMPLATE_THUMBNAIL", "tpl_thumbnail");
			}
			else
			{
				$template->set_file("tpl_no_thumbnail", "no_thumbnail.tpl");
				$template->parse("TEMPLATE_THUMBNAIL", "tpl_no_thumbnail");
			}

			$template->parse("NEWSLETTER_TEMPLATES_LIST", "tpl_row_newsletter_template", true);
		}
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_newsletters_edit");
	require("template_make.php");
?>

<?php

	function FillFromTemplate()
	{
		global $template;
		global $from_template;
		$db = new DB_Sql;

		// daca avem vreun template specificat 
		// il incarcam in campurile subject si body ale mesajului editat (sau nou)
		if (isset($from_template))
		{
			$query = "SELECT * 
						FROM newslettertemplates 
						WHERE newslettertemplates_id = '$from_template' ";
			$db->query($query);

			if ($db->num_rows() != 1)
				error_page("invalid template id");
			$db->next_record();

			$template->set_var("SUBJECT", $db->f("newslettertemplates_subject"));
			$template->set_var("BODY", $db->f("newslettertemplates_body"));
		}
	}

?>