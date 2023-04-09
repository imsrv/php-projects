<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/thumbnail_functions.php");
	
	$db = new DB_Sql;

	// determinam ce buton a fost apasat
	if (isset($btn_select) && $btn_select != "" && 
		isset($messageid) && $messageid != "")
	{
		// ** SELECT message ** 
		redirect("newsletter_templates.php?selected=$messageid");
	}
	else
	if (isset($btn_remove) && $btn_remove != "" && 
		isset($messageid) && $messageid != "")
	{
		// ** REMOVE message ** 
		// stergem imaginea thumbnail asociata
		$query = "SELECT newslettertemplates_thumbnail_filename
					FROM newslettertemplates
					WHERE newslettertemplates_id = '$messageid' ";
		$db->query($query);

		if ($db->num_rows() == 1)
		{
			$db->next_record();

			$thumbnail_filename = $db->f("newslettertemplates_thumbnail_filename");
			$thumbnail_dir = GetThumbnailDir();
			
			if ($thumbnail_filename != "")
				unlink($thumbnail_dir . $thumbnail_filename);
		}

		$query = "DELETE FROM newslettertemplates 
					WHERE 
						newslettertemplates_id = '$messageid'";
		$db->query($query);

		redirect("newsletter_templates.php");
	}

	redirect("newsletter_templates.php");
?>
