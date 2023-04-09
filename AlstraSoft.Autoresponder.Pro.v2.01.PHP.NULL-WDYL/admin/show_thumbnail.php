<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/thumbnail_functions.php");

	if (! isset($filename))
		exit();
	
	// $filename nu trebuie sa contina simbolul "/" sau "\"
	if (strstr($filename, "/") != false)
		exit("hack attempt");
	if (strstr($filename, "\\") != false)
		exit("hack attempt");

	$path_to_file = GetThumbnailDir() . $filename;

//	header ("Cache-Control: no-store, no-cache, must-revalidate");
//	header ("Content-Type: image/jpeg"); 
	header ("Content-Length: " . filesize($path_to_file));
	readfile ($path_to_file); 
?>