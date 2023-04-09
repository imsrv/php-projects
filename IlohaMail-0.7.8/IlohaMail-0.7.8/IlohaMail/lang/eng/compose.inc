<?
/********************************************************
	lang/eng/compose.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$composeHStrings=array(
	0=>"Subject",
	1=>"From",
	2=>"To",
	3=>"CC",
	4=>"BCC",
	5=>"Date"
);

$composeStrings=array(
	0=>"Compose Message",
	1=>"Send Message",
	2=>"Upload",
	3=>"Attach signature",
	4=>"Attach",
	5=>"Show contacts",
	6=>"Hide contacts",
	7=>"Message body:",
	8=>"Add",
	9=>"On %d, %s wrote:\n",
	10=>"--- Original Message ---\n",
	11=>"Close Window"
);

$composeErrors=array(
	0=>"The subject field is empty. Please enter a subject or click \"".$composeStrings[1]."\" again to send.",
	1=>"The \"from\" field is empty.  Please enter your email address.",
	2=>"The \"To\" field is empty.  Please specify the destination address.",
	3=>"Upload failed",
	4=>"No files received.",
    5=>"For spam prevention reasons, you may only send to %1 people (%2 total per session) every %3 seconds."
);
?>