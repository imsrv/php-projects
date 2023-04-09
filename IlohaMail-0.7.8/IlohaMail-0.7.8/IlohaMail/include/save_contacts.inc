<?
/********************************************************
	include/save_contacts.inc
	
	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for save_contacts.backend.inc

********************************************************/

include_once("../conf/conf.inc");

$scon_backend = $backend;
if ($scon_backend =="MySQL"){
	include_once("../conf/mysqlrc.inc");
	if ((!isset($mysql_contacts)) || (empty($mysql_contacts))) $scon_backend = "FS";
}

include("../include/save_contacts.".$scon_backend.".inc");

?>