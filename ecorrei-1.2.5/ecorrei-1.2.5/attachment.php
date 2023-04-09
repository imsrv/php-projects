<?php
/*	eCorrei 1.2.5 - Attachment script
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
	session_cache_limiter("public");
	$bypasscheck = 0;
	require("main.php");

	if (!eregi("^([0-9]*)$", $msg) or !eregi("([0-9\.]*)", $part)) {
		exit();
	}

	$mbox = @imap_open("{" . $connectstring . "}INBOX", $usr_username . $usr_append, $usr_password);
	if (!$mbox) {
		redirect("index.php?action=auth_failed");
	}
	
	$tmpa = array();
	$ret = array();
	if (eregi("([0-9\.]*)\.([0-9\.]*)", $part, $ret)) {
		$pone = ($ret[1] - 1);
		$ptwo = ($ret[2] - 1);
	}
	else {
		$pone = ($part - 1);
	}
	$dpara = array();
	$struct = imap_fetchstructure($mbox, $msg, FT_UID);
	$body = imap_fetchbody($mbox, $msg, $part, FT_UID);
	imap_close($mbox);	
	$tmpa = $struct->parts;
	
	if ($ptwo) {
		$tmpa = $tmpa[$pone]->parts;
		$obj = $tmpa[$ptwo];
	}
	else {
		$obj = $tmpa[$pone];
	}
	$dpara = $obj->dparameters;
	for ($v=0;$v<sizeof($dpara);$v++) {
		if (eregi("filename", $dpara[$v]->attribute)) {
			$fname = $dpara[$v]->value;
		}
	}
	if (empty($fname)) {
		$para = $obj->parameters;
		for ($v=0;$v<sizeof($para);$v++) {
			if (eregi("name", $para[$v]->attribute)) {
				$fname = $para[$v]->value;
			}
		}
	}
	if (empty($fname)) {
		$disp = $obj->description;
	}
	if (empty($fname)) {
		$fname = $lang->unknown;
	}	

	$mime_type = mimetype($obj->type) . "/" . strtolower($obj->subtype);
	if ($mime_type == "message/rfc822") {
		$mime_type = "text/plain";
	}
	header("Content-Type: " . $mime_type);
	header("Content-Disposition: attachment; filename=$fname");


	switch ($obj->encoding) {
		case 4:
			$body = imap_qprint($body);
			break;
		case 3:
			$body = imap_base64($body);
			break;
		default:
			break;
	}

	print $body;	
?>
