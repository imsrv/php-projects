<?php
/*	eCorrei 1.2.5 - Check script
	A webbased E-mail solution
	Page: http://ecorrei.sourceforge.net/
	Date: 2 February 2002
	Author: Jeroen Vreuls
	Copyright (C) 2000-2002 Jeroen Vreuls
		
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
	or see http://www.fsf.org/copyleft/gpl.html
*/

	// This file will check your PHP environment

	$pass = 0;
	print "<html>\n<head>\n<title>Checking your environment...</title>\n</head>\n<body bgcolor=\"#FFFFFF\" link=\"#0000FF\">\n";
	print "<h1>Checking environment...</h1>\n";
	print "<table border=\"0\" width=\"500\">\n";

	// Check PHP version
	print "<tr>\n";
	print "<td width=\"400\">Checking PHP version...</td>\n";
	list($major, $minor, $rev) = explode(".", phpversion());
	if ($major >= 4 && (($minor == 0 && $rev >= 3) or ($minor >= 1 && $rev >= 0))) {
		print "<td width=\"100\"><font color=\"#008040\">Passed</font></td>\n";
		$pass++;
	}
	else {
		print "<td width=\"100\"><font color=\"#FF0000\">Failed</font></td>\n";
	}
	print "</tr>\n";

	// Check IMAP extension
	print "<tr>\n";
	print "<td width=\"400\">Checking IMAP extension...</td>\n";
	if (extension_loaded("imap")) {
		print "<td width=\"100\"><font color=\"#008040\">Passed</font></td>\n";
		$pass++;
	}
	else {
		print "<td width=\"100\"><font color=\"#FF0000\">Failed</font></td>\n";
	}
	print "</tr>\n";

	// Result
	print "</table>\n";
	if ($pass == 2) {
		print "<p><font color=\"#008040\">Your PHP environment is ready for eCorrei.</font></p>\n";
	}
	else {
		print "<p><font color=\"#FF0000\">Your PHP environment is not ready for eCorrei.</font></p>\n";
	} 

	print "</body>\n<html>\n";
?>
