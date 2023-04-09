<?
/********************************************************
    save_colors.MySQL.inc
    
    (C)Copyright 2002 Ryo Chijiiwa
    This file is part of IlohaMail, released under GPL

	PURPOSE:
		Save colors (in $my_colors) to MySQL back-end
	PRE-CONDITIONS:
		"include/session_auth.inc"
                $dataID 
                $my_colors
		
********************************************************/

include_once("../include/array2sql.inc");
include_once("../conf/mysqlrc.inc");

$iOpened = false;

$backend_table = $mysql_colors;
$backend_array = $my_colors;
$backend_operation = "UPDATE";
$backend_dataID = $session_dataID;

include("../include/backend.MySQL.inc");

?>