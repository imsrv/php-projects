<?
/********************************************************
	include/session_auth.inc
	
	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for session_auth.backend.inc

********************************************************/

include_once("../conf/conf.inc");

$sa_backend = $backend;
include("../conf/mysqlrc.inc");
if ($sa_backend == "MySQL"){
	if ((!isset($mysql_sessions)) || (empty($mysql_sessions))) $sa_backend = "FS";
}

include("../include/session_auth.".$sa_backend.".inc");

?>