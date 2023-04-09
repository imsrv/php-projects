<?
/********************************************************
	include/icl.inc
	
	(C)Ryo Chijiiwa <Ryo@IlohaMail.org> 2002 

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		IlohaMail Client Library.  Load imap.inc or pop3.inc

********************************************************/

if (!isset($port)) $port = 143;

if ($port==143){
    $ICL_CAPABILITY["folders"] = true;
    $ICL_CAPABILITY["search"] = true;
    $ICL_CAPABILITY["radar"] = true;
	include("../include/imap.inc");
}else if ($port==110){
    $ICL_CAPABILITY["folders"] = false;
    $ICL_CAPABILITY["search"] = false;
    $ICL_CAPABILITY["radar"] = false;
	include("../include/pop3.inc");
}

?>