<?
/********************************************************
	include/as_update.inc
	
	(C)2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for as_update.backend.inc
        Update session table with latest send operation.

********************************************************/

include_once("../conf/conf.inc");

if ($backend=="MySQL"){
    include("../include/as_update.MySQL.inc");
}else if ($backen=="FS"){
    //no anti-spam for FS backend
}

?>