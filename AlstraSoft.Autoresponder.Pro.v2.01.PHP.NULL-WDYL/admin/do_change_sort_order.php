<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$db = new DB_Sql;

	// gasim ordinea de sortare curenta
	$query = "SELECT settings_value
				FROM settings
				WHERE settings_name = 'template_sort_order' ";
	$db->query($query);

	if ($db->next_record())
	{
		$sort_order = $db->f("settings_value");
		$new_sort_order = ($sort_order == "asc" ? "desc" : "asc");
		
		// schimbam ordinea de sortare in complementara
		$query = "UPDATE settings
					SET settings_value = '$new_sort_order'
					WHERE settings_name = 'template_sort_order' ";
		$db->query($query);
	}

	redirect("newsletter_templates.php");
?>
