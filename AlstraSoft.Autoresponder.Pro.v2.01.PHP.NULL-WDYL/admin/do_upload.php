<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/thumbnail_functions.php");
	
	$db = new DB_Sql;

	if (! isset($selected))
		$selected = "";
	
	if ($imagefile_name != "")
	{
		if ($selected != "")
			$dest_imagefile_name = GetThumbnailFilename4Template($selected);
		else
			$dest_imagefile_name = GetDefaultThumbnailFilename();

		if (! copy("$imagefile", GetThumbnailDir() . "$dest_imagefile_name"))
			error_page("Couldn't copy file.");

		if ($selected != "")
		{
			// inregistram in baza de date informatiile despre imagine
			$query = "UPDATE newslettertemplates
						SET newslettertemplates_thumbnail_filename = '$dest_imagefile_name' 
						WHERE newslettertemplates_id = '$selected' ";
			$db->query($query);
		}
	} 
	else 
	{
		error_page("No input file specified.");
	}

	$UrlParams = "";
	if ($selected != "")
		$UrlParams .= "?selected=$selected";
	if ($type != "")
		$UrlParams .= "&type=$type";		

	redirect("newsletter_templates.php$UrlParams");
?>