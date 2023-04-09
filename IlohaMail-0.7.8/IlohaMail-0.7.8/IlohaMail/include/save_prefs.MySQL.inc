<?
/********************************************************
    save_prefs.MySQL.inc
    
    (C)Copyright 2002 Ryo Chijiiwa
    This file is part of IlohaMail, released under GPL

	PURPOSE:
		Save prefs (in $my_prefs) to MySQL back-end
	PRE-CONDITIONS:
		"include/session_auth.inc"
                $session_dataID 
                $my_prefs
		
********************************************************/

include_once("../include/array2sql.inc");
include_once("../conf/mysqlrc.inc");

$iOpened = false;

$backend_table = $mysql_prefs;
$backend_array = $my_prefs;
$backend_operation = "UPDATE";
$backend_dataID = $session_dataID;
$backend_where = "";

$prefs_summary = trim(chop(implode("", $my_prefs)));

if (($backend_dataID > 0) && (strlen($prefs_summary) > 10)){
	$error = "";
	include("../include/backend.MySQL.inc");
	if (!empty($error)) echo "<p><font color=\"red\">$error</font>";
}else{
	echo "Query not done due to invalid parameters:<br>\n";
	echo "dataID: $dataID <br>\n";
	echo "array: ".implode(",", $my_prefs)."<br>\n";
}
?>
