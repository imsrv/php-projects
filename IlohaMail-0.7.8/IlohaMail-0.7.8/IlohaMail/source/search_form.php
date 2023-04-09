<?
/////////////////////////////////////////////////////////
//	
//	source/search_form.php
//
//	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//	
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	PURPOSE:
		Search form.  This file is a shell for lang/[lang]/search.inc where the actual search
		form code is.  Actual search request is processed by source/main.php
	PRE-CONDITIONS:
		$user - Session ID

********************************************************/

include("../include/super2global.inc");
include("../include/nocache.inc");
include("../include/header_main.inc");
include("../include/icl.inc");


	$userName=$loginID;
	
	include("../lang/".$my_prefs["lang"]."search.inc");
	
?>
</body></html>
