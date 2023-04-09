<?
/********************************************************
	include/save_colors.inc
	
	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for save_colors.backend.inc

********************************************************/

include_once("../conf/conf.inc");

$sc_backend = $backend;
if ($sc_backend == "MySQL"){
    include_once("../conf/mysqlrc.inc");
	if ((!isset($mysql_colors)) || (empty($mysql_colors))) $sc_backend = "FS";
}

include("../include/save_colors.".$sc_backend.".inc");

?>