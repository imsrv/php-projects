<?php 
include("prepend.php");
include(DOCROOT . "sendcard_setup.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>sendcard properties</title>
<script LANGUAGE="JavaScript" type="text/javascript"">
<!--
// (C) Nannette Thacker http://www.shiningstar.net
function confirmSubmit()
{
var agree=confirm("Are you sure you want to continue?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#ffffff">


<?php
if( !isset($action) ) {
	$action = "";
}

if ( isset($plugin_file) ) {
	include("plugins/" . urldecode($plugin_file) );
}

switch ($action) {

case "install":

if ( $plugin_set_variables == 1 && !isset($plugin_variables_set) ) {
	echo("<form action=\"mod_plugins.php\" method=\"post\">\n\n");
	plugin_set_variables();
	echo("<input type=\"hidden\" name=\"action\" value=\"install\">\n
<input type=\"hidden\" name=\"plugin_file\" value=\"$plugin_file\">\n
<input type=\"submit\" name=\"plugin_variables_set\" value=\"Submit\">\n</form>");

} else {
$filename = DOCROOT . "sendcard.php";
if(!$file = fopen($filename, "r") ) {
echo("Cannot Open File");
} elseif (!$datafile = fread ($file, filesize ($filename) ) ) {
echo ("Cannot read file sendcard on line 23");
}else {
fclose ($file);

// We loop through the array of new code (if present) replacing them each time.
$array_num = count($plugin_original_code);
for($i = 0; $i < $array_num; $i++){

// Insert the code below the placeholder, remembering to replace the placeholder :-)
$datafile = str_replace($plugin_original_code[$i], $plugin_original_code[$i] . "\n" . $plugin_replacement_code[$i], $datafile);

}

$file = fopen($filename, "w");
fwrite ($file, $datafile);
fclose ($file);
echo($plugin_installed_msg);

// Update the variable in the plugin file.
$filename = "plugins/" . $plugin_file;
$file = fopen($filename, "r");
$datafile = fread($file, filesize($filename) );
fclose ($file);

$datafile = str_replace('$plugin_installed = 0;', '$plugin_installed = 1;', $datafile);

$file = fopen($filename, "w");
fwrite ($file, $datafile);
fclose ($file);

}// End if

}// End else	

break;


case "uninstall":

$filename = DOCROOT . "sendcard.php";
if(!$file = fopen($filename, "r") ) {
echo("Cannot Open File");
} elseif (!$datafile = fread ($file, filesize ($filename) ) ) {
echo ("Cannot read file sendcard on line 59");
}else {
fclose ($file);

// $datafile = str_replace($plugin_replacement_code, $plugin_original_code, $datafile);
$datafile = ereg_replace("\/\*\*\*([ \t]+)BEGIN $plugin_name([ \t]+)\*\*\*\/(.+\n)\/\*\*\*([ \t]+)END $plugin_name([ \t]+)\*\*\*\/", "", $datafile);

$file = fopen($filename, "w");
fwrite ($file, $datafile);
fclose ($file);
echo($plugin_uninstalled_msg);

// Update the variable in the plugin file.
$filename = "plugins/" . $plugin_file;
$file = fopen($filename, "r");
$datafile = fread($file, filesize($filename) );
fclose ($file);

$datafile = str_replace('$plugin_installed = 1;', '$plugin_installed = 0;', $datafile);

$file = fopen($filename, "w");
fwrite ($file, $datafile);
fclose ($file);
}

break;
default:
$file_directory = opendir("plugins/");
while($filename = readdir($file_directory)) {
	if ($filename != "." && $filename != ".." && $filename != "." && $filename != ".htaccess") {
	     include("plugins/" . $filename);

	if ($plugin_installed == 1) {
     echo("<p>$plugin_name - <a href=\"mod_plugins.php?action=uninstall&plugin_file=" . urlencode($filename) . "\" onclick=\"return confirmSubmit()\">Uninstall</a> \n");
	} else {
     echo("<p>$plugin_name - <a href=\"mod_plugins.php?action=install&plugin_file=" . urlencode($filename) . "\">Install</a> \n");
	}

	if ($plugin_edit != "" || $plugin_edit != 0) {
	     echo("<a href=\"mod_plugins.php?action=edit&file=" . urlencode($filename) . "\">Edit</a> \n");
	}
	echo("<a href=\"plugins/$filename?action=help\" target=\"_blank\">Help</a><br> \n");
	echo($plugin_description);
	}

}// End while
closedir($file_directory);

} // End switch
?>
