<?
/********************************************************
	include/session_close.inc
	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for include/session_close.backend.inc

********************************************************/

	include("../conf/conf.inc");
	include("../include/session_close.".$backend.".inc");

?>