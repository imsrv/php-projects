<?php
/* Nullified by WDYL-WTN */

	// intoarce denumirea fisierului pt imagini thumbnail ale template-urilor noi
	function GetDefaultThumbnailFilename()
	{
		$db = new DB_Sql;
		
		$query = "SELECT settings_value 
					FROM settings
					WHERE settings_name = 'default_thumbnail_filename' ";
		$db->query($query);

		if ($db->num_rows() == 0)
			$result = "";
		else
		{
			$db->next_record();
			$result = $db->f("settings_value");
		}

		return $result;
	}

	// intoarce directorul in care se afla imaginile
	function GetThumbnailDir()
	{
		$db = new DB_Sql;
		
		$query = "SELECT settings_value 
					FROM settings
					WHERE settings_name = 'thumbnail_dir' ";
		$db->query($query);

		if ($db->num_rows() == 0)
			$result = "";
		else
		{
			$db->next_record();
			$result = $db->f("settings_value");
		}

		return $result;
	}

	// genereaza un nume pt fisierul thumbnail asociat template-ului dat
	function GetThumbnailFilename4Template($template_id)
	{
		return "img" . $template_id . ".jpg";
	}

?>