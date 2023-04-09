<?
/********************************************************
	include/save_prefs.inc
	
	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for save_prefs.backend.inc

********************************************************/

include_once("../conf/conf.inc");

$sp_backend = $backend;
if ($sp_backend == "MySQL"){
    include_once("../conf/mysqlrc.inc");
	if ((!isset($mysql_prefs)) || (empty($mysql_prefs))) $sp_backend = "FS";
}

include("../include/save_prefs.".$sp_backend.".inc");

?>
