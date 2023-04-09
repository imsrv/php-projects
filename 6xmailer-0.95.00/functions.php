<?php
// =============================================================================
//	6XMailer - A PHP POP3 mail reader.
//	Copyright (C) 2001  6XGate Systems, Inc.
//	
//	This program is free software; you can redistribute it and/or
//	modify it under the terms of the GNU General Public License
//	as published by the Free Software Foundation; either version 2
//	of the License, or (at your option) any later version.
//	
//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.
//	
//	You should have received a copy of the GNU General Public License
//	along with this program; if not, write to the Free Software
//	Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
// ==============================================================================

// Functions
// ---------

// This function replaces all src="cid:***" with a php script that will retreive
// the data
function replaceCIDsrc ($htmltext, &$msgnum) {
	$htmltext = stripslashes ($htmltext);
	$lowertext = strtolower ($htmltext);
	$newstring = "";
	$didchange = false;
	$lastpos = 0;
	do {
		$changing = false;
		$tagpos = strpos ($lowertext, "<img", $lastpos);
		if (is_int ($tagpos)) {
			$tagendpos = strpos ($lowertext, ">", $tagpos);
			if (is_int ($tagendpos)) {
				$tagstring = substr ($lowertext, $tagpos, $tagendpos - $tagpos + 1);
				$attribpos = strpos ($tagstring, "cid:");
				if (is_int ($attribpos)) {
					$attribpos = strpos ($lowertext, "cid:", $tagpos);
					$whathappened = substr_replace ($htmltext, "getpartbyid.php?MSG=" . $msgnum . "&CID=", $attribpos, 4);
					if (is_string ($whathappened)) $htmltext = $whathappened;
					$changing = true;
					$didchange = true;
				}
				$lastpos = $tagendpos + 1;
			}
			$changing = true;
		}
	} while ($changing);

	$lastpos = 0;
	do {
		$changing = false;
		$tagpos = strpos ($lowertext, "<applet", $lastpos);
		if (is_int ($tagpos)) {
			$tagendpos = strpos ($lowertext, ">", $tagpos);
			if (is_int ($tagendpos)) {
				$tagstring = substr ($lowertext, $tagpos, $tagendpos - $tagpos + 1);
				$attribpos = strpos ($tagstring, "cid:");
				if (is_int ($attribpos)) {
					$attribpos = strpos ($lowertext, "cid:", $tagpos);
					$whathappened = substr_replace ($htmltext, "getpartbyid.php?MSG=" . $msgnum . "&CID=", $attribpos, 4);
					if (is_string ($whathappened)) $htmltext = $whathappened;
					$changing = true;
					$didchange = true;
				}
				$lastpos = $tagendpos + 1;
			}
			$changing = true;
		}
	} while ($changing);

	$lastpos = 0;
	do {
		$changing = false;
		$tagpos = strpos ($lowertext, "<object", $lastpos);
		if (is_int ($tagpos)) {
			$tagendpos = strpos ($lowertext, ">", $tagpos);
			if (is_int ($tagendpos)) {
				$tagstring = substr ($lowertext, $tagpos, $tagendpos - $tagpos + 1);
				$attribpos = strpos ($tagstring, "cid:");
				if (is_int ($attribpos)) {
					$attribpos = strpos ($lowertext, "cid:", $tagpos);
					$whathappened = substr_replace ($htmltext, "getpartbyid.php?MSG=" . $msgnum . "&CID=", $attribpos, 4);
					if (is_string ($whathappened)) $htmltext = $whathappened;
					$changing = true;
					$didchange = true;
				}
				$lastpos = $tagendpos + 1;
			}
			$changing = true;
		}
	} while ($changing);

	$lastpos = 0;	
	do {
		$changing = false;
		$tagpos = strpos ($lowertext, "<link", $lastpos);
		if (is_int ($tagpos)) {
			$tagendpos = strpos ($lowertext, ">", $tagpos);
			if (is_int ($tagendpos)) {
				$tagstring = substr ($lowertext, $tagpos, $tagendpos - $tagpos + 1);
				$attribpos = strpos ($tagstring, "cid:");
				if (is_int ($attribpos)) {
					$attribpos = strpos ($lowertext, "cid:", $tagpos);
					$whathappened = substr_replace ($htmltext, "getpartbyid.php?MSG=" . $msgnum . "&CID=", $attribpos, 4);
					if (is_string ($whathappened)) $htmltext = $whathappened;
					$changing = true;
					$didchange = true;
				}
				$lastpos = $tagendpos + 1;
			}
			$changing = true;
		}
	} while ($changing);

	return $htmltext;
}

// Creates a MIME string from a the given structure (function by cleong@organic.com)
function get_mime_type (&$structure){ 
	$primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"); 
	if ($structure->subtype){ 
		return strtolower ($primary_mime_type[(int) $structure->type] . '/' . $structure->subtype); 
	}
	return "TEXT/PLAIN"; 
} 

// Finds a particular part of a message with a given MIME type and
// returns its text (function by cleong@organic.com)
function get_part (&$stream, &$msg_number, $mime_type, $structure = false, $part_number = false){ 
	if (!$structure){ 
		$structure = imap_fetchstructure($stream, $msg_number); 
	} 
	if($structure){ 
		if(strtolower ($mime_type) == get_mime_type($structure)){ 
			if(!$part_number){ 
				$part_number = "1"; 
			} 
			if ($structure->ifdisposition) {
				if (strtolower ($structure->disposition) == "attachment") return false;
			}
			$text = imap_fetchbody($stream, $msg_number, $part_number); 
			if($structure->encoding == 3){ 
				return imap_base64($text); 
			} else if($structure->encoding == 4) { 
				return imap_qprint($text); 
			} else { 
				return $text; 
			} 
		} 
		if($structure->type == 1) /* multipart */ { 
			while(list($index, $sub_structure) = each($structure->parts)) { 
				if($part_number) { 
					$prefix = $part_number . '.'; 
				} 
				$data = get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
				if($data) { 
					return $data; 
				} 
			} 
		} 
	} 
	return false; 
}

function get_encoding (&$structure) {
	$encode_types = array ("7bit", "8bit", "binary", "base64", "quoted-printable", "none");
	return $encode_types[(int) $structure->encoding];
}

// Finds a particular part of a message with a given content-id
// returns its text (our modified version of the function above by cleong@organic.com)
function get_cid_part (&$stream, &$msg_number, $msgcid, $structure = false, $part_number = false) {
	if (!$structure) {
		$structure = imap_fetchstructure($stream, $msg_number);
	}
	if ($structure) {
		if ($msgcid == $structure->id) {
			if(!$part_number) {
				$part_number = "1"; 
			}
			$data = imap_fetchbody ($stream, $msg_number, $part_number);
			if($structure->encoding == 3){ 
				$data = imap_base64($data); 
			} else if($structure->encoding == 4) { 
				$data = imap_qprint($data); 
			} 
			$text = array ($data, get_mime_type ($structure), get_encoding ($structure));
			return $text; 
		}
		if ($structure->type == 1) /* multipart */ {
			while (list ($index, $sub_structure) = each ($structure->parts)) {
				if ($part_number) {
					$prefix = $part_number . '.';
				}
				$data = get_cid_part ($stream, $msg_number, $msgcid, $sub_structure, $prefix . ($index + 1));
				if ($data) {
					return $data;
				}
			}
		}
	}
	return false;
}

// Finds out if there is an attachment
function is_attach (&$stream, &$msg_number, $structure = false, $part_number = false) {
	if (!$structure) {
		$structure = imap_fetchstructure($stream, $msg_number);
	}
	if ($structure) {
		if ($structure->type != 1) /* multipart */ {
			if (strtoupper ($structure->disposition) == "ATTACHMENT") {
				return true;
			}
		} else {
			while (list ($index, $sub_structure) = each ($structure->parts)) {
				if ($part_number) {
					$prefix = $part_number . '.';
				}
				if (is_attach ($stream, $msg_number, $sub_structure, $prefix . ($index + 1))) {
					return true;
				}
			}
		}
	}
	return false;
}

// Echos a list of attachments in a message
function echo_part_data (&$stream, &$msg_number, $structure = false, $part_number = false) {
	if (!$structure) {
		$structure = imap_fetchstructure($stream, $msg_number);
	}
	if ($structure) {
		if ($structure->type != 1) /* multipart */ {
			if (strtoupper ($structure->disposition) == "ATTACHMENT") {
				if ($structure->ifdparameters) {
					while (list ($Name, $Disposition) = each ($structure->dparameters)) {
						if (strtoupper ($Disposition->attribute) == "FILENAME") {
							$filename = $Disposition->value;
						}
					}
				}
				if ($structure->ifparameters) {
					while (list ($Name, $Disposition) = each ($structure->parameters)) {
						if (strtoupper ($Disposition->attribute) == "NAME") {
							if (!is_string($filename)) {
								$filename = $Disposition->value;
							}
						}
					}
				}
				if (!is_string($filename)) {
					$filename = "untitled." . strtolower($structure->subtype);
				}
				$geturl = "getattach.php?MSG=" . urlencode (htmlentities($msg_number)) . "&PRT=" . urlencode (htmlentities($part_number)) . "&FLN=" . urlencode (htmlentities ($filename)) . "&ENC=" . urlencode (htmlentities($structure->encoding)) . "&MIM=" . urlencode (htmlentities(strtolower (get_mime_type ($structure))));
				echo "<P><A HREF=\"" . $geturl . "\">" . $filename . "</A></P>";
			}
		} else {
			while (list ($index, $sub_structure) = each ($structure->parts)) {
				if ($part_number) {
					$prefix = $part_number . '.';
				}
				echo_part_data ($stream, $msg_number, $sub_structure, $prefix . ($index + 1));
			}
		}
	}
	return true;
}

// Echos text with HTML entities
function echohtml ($string) {
	echo htmlentities($string);
}

session_cache_limiter ("nocache");

// Sets the defaults for any missing settings.
if (!$Theme) $Theme = "default";
if (!$Language) $Language = "English";
if (!$RefreshList) $RefreshList = "600";
if (!$MailSystemTitle) $MailSystemTitle = "PHP Web Mailer";
if (!$QuoteInReply) $QuoteInReply = "----Original Message----";
if (!$POPPort) $POPPort = "110";
if (!$QLPort) $QLPort = "3306";
if (!$QLHostname) $QLHostname = "localhost";
if (!$QLDatabase) $QLDatabase = "6xmailer_data";

// Special values/variables
// ------------------------
$Mailbox = "{" . $POPHostname . "/pop3:" . $POPPort . "}INBOX";
$AboutFile = "lang/" . $Language . "/about.php";

// The version numbering.
$MajorVersion = "00";
$MinorVersion = "95";
$BuildVersion = "00";
?>