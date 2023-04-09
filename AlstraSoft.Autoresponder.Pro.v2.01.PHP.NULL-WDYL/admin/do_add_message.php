<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/thumbnail_functions.php");

	$db = new DB_Sql;

	// obtinem datele despre noul mesaj:	$subject $disabled $body $interval
	if (isset($type) && $type == "html")
		$type = 1;
	else
		$type = 0;

	AssumeIsNotEmpty($subject, "Subject must not be empty");
	AssumeIsString($subject, "Subject is not a valid string");
	AssumeIsString($body, "Body is not a valid string");

	// adaugam mesajul
	$query = "INSERT INTO newslettertemplates 
				(newslettertemplates_subject, newslettertemplates_body, newslettertemplates_type)
				VALUES
				('$subject', '$body', '$type')";
	$db->query($query);

	// obtinem id-ul template-ului acum inserat
	$new_template_id = mysql_insert_id($db->link_id());

	// ** THUMBNAIL
	// daca exista imagine cu numele default
	// atunci setam aceasta imagine ca thumbnail al template-ului proaspat adaugat
	$default_thumbnail_filename = GetDefaultThumbnailFilename();
	$thumbnail_dir = GetThumbnailDir();

	if (file_exists($thumbnail_dir . $default_thumbnail_filename))
	{
		// generam un nume de thumbnail pt template-ul proaspat adaugat
		$thumbnail_filename = GetThumbnailFilename4Template($new_template_id);

		// redenumim fisierul cu thumbnail-ul default in numele de thumbnail generat mai sus
		rename($thumbnail_dir . $default_thumbnail_filename, 
				$thumbnail_dir . $thumbnail_filename);

		$query = "UPDATE newslettertemplates 
					SET newslettertemplates_thumbnail_filename = '$thumbnail_filename' 
					WHERE newslettertemplates_id = '$new_template_id' ";
		$db->query($query);
	}

	redirect("newsletter_templates.php");
?>