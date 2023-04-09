<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/thumbnail_functions.php");

	// PARAMETRI:
	$DEFAULT_THUMBNAIL_FILENAME = GetDefaultThumbnailFilename();
	$THUMBNAIL_DIR = GetThumbnailDir();

	$template = new Template("templates/newsletter_templates");
	$db = new DB_Sql;

	// implicit mesajul este plain text
	if (! isset($type))
		$type = "";

	if (! isset($selected))
		$selected = "";		
	
	// cream pagina din template
	$template->set_file("tpl_newsletter_templates", "newsletter_templates.tpl");

	// obtinem lista de template-uri
	$sort_order = GetTemplateSortOrder();
	$template->set_var("SORT_ORDER", $sort_order == "asc" ? "sort descending" : "sort ascending");

	$query = "SELECT * 
				FROM newslettertemplates
				ORDER BY newslettertemplates_subject $sort_order ";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		// ** nu avem nici un template

		$template->set_file("tpl_row_nomessages", "row_nomessages.tpl");
		$template->parse("MESSAGE_LIST", "tpl_row_nomessages");

		$template->set_var("MESSAGE_MENU", "");

		// afisam formul de adaugare a unui mesaj nou
		// este plain text sau html?
		if ($type == "html")
			$template->set_file("tpl_message_add", "message_add_html.tpl");
		else
			$template->set_file("tpl_message_add", "message_add_text.tpl");

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
			$template->set_var("SUBJECT", $db->f("newslettertemplates_subject"));
			$template->set_var("MESSAGE_ID", $db->f("newslettertemplates_id"));

			// selectam in lista de mesaje mesajul editat
			// daca nu avem mesaj de editat, selectam primul mesaj din lista
			if (($selected == "" && $i == 1) || ($selected != "" && intval($selected) == $db->f("newslettertemplates_id")))
				$template->set_var("SELECTED", "checked");
			else
				$template->set_var("SELECTED", "");

			$template->parse("MESSAGE_LIST", "tpl_row_message", true);
			$i++;
		}

		// determinam daca avem mesaj de editat sau nu
		if ($selected != "")
		{
			// ** AVEM MESAJ DE EDITAT -> afisam form de editare

			// completam campurile din form cu datele despre mesajul editat
			$query = "SELECT * 
						FROM newslettertemplates
						WHERE newslettertemplates_id = '$selected'";
			$db->query($query);

			if ($db->num_rows() != 1)
			{
				error_page("Invalid template ID");
			}
			else
			{
				$db->next_record();
				$isMessageHtml = $db->f("newslettertemplates_type");

				// este plain text sau html? 
				if ($type == "html" || ($type != "text" && $isMessageHtml))
					$template->set_file("tpl_message_edit", "message_edit_html.tpl");
				else
					$template->set_file("tpl_message_edit", "message_edit_text.tpl");

				$template->set_var("SUBJECT", $db->f("newslettertemplates_subject"));
				$template->set_var("BODY", $db->f("newslettertemplates_body"));
				$template->set_var("MESSAGE_ID", $selected);
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

	// ** THUMBNAIL
	// afisam form-ul pt upload-ul de imagini thumbnail ale template-urilor
	$template->set_file("tpl_thumbnail_form", "thumbnail_form.tpl");
	$template->set_file("tpl_thumbnail_image", "thumbnail_image.tpl");
	$template->set_file("tpl_no_thumbnail_image", "no_thumbnail_image.tpl");
	$template->set_file("tpl_overwrite_warning", "overwrite_warning.tpl");
	$template->parse("THUMBNAIL_FORM", "tpl_thumbnail_form");

	$template->set_var("SELECTED", $selected);
	$template->set_var("TYPE", $type);

	// daca avem vreun template selectat si daca are imagine
	// afisam imaginea
	$thumbnail_filename = "";

	if ($selected != "")
	{
		// determinam denumirea fisierului imagine
		$query = "SELECT newslettertemplates_thumbnail_filename
					FROM newslettertemplates
					WHERE newslettertemplates_id = '$selected' ";
		$db->query($query);

		if ($db->num_rows() == 1)
		{
			$db->next_record();
			$thumbnail_filename = $db->f("newslettertemplates_thumbnail_filename");
		}
	}
	else
	{
		// fisierul thumbnail implicit pt template-urile noi (in curs de adaugare)
		// daca exista un asemenea fisier
		if (file_exists($THUMBNAIL_DIR . $DEFAULT_THUMBNAIL_FILENAME))
			$thumbnail_filename = $DEFAULT_THUMBNAIL_FILENAME;
	}

	if ($thumbnail_filename != "")
	{
		// avem imagine thumbnail
		$template->set_var("THUMBNAIL_IMAGE_PATH", "show_thumbnail.php?filename=$thumbnail_filename");
		$template->parse("OVERWRITE_WARNING", "tpl_overwrite_warning");
		$template->parse("THUMBNAIL_IMAGE", "tpl_thumbnail_image");
	}
	else
	{
		// nu avem imagine thumbnail
		$template->parse("THUMBNAIL_IMAGE", "tpl_no_thumbnail_image");
	}

	// crearea output-ului propriu-zis
	$template->parse("output", "tpl_newsletter_templates");
	$template->p("output");			
?>

<?php

	function GetTemplateSortOrder()
	{
		$db = new DB_Sql;
		$query = "SELECT settings_value	
					FROM settings
					WHERE settings_name = 'template_sort_order' ";
		$db->query($query);
		$result = "";

		if ($db->next_record())
			$result = $db->f("settings_value");

		return $result;
	}

?>