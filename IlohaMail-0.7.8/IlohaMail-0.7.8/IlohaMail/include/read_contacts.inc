<?
/********************************************************
	include/read_contacts.inc
	
	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for read_contacts.backend.inc

********************************************************/

include_once("../conf/conf.inc");

$rc_backend = $backend;
if ($rc_backend =="MySQL"){
	include_once("../conf/mysqlrc.inc");
	if ((!isset($mysql_contacts)) || (empty($mysql_contacts))) $rc_backend = "FS";
}

if (empty($sort_field)) $sort_field = "grp,name";
if (empty($sort_order)) $sort_order = "ASC";

include("../include/read_contacts.".$rc_backend.".inc");

?>