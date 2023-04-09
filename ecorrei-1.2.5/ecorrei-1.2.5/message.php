<?php
/*	eCorrei 1.2.5 - Message script
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
	$bypasscheck = 0;
	require("main.php");

	if (!eregi("^([0-9]*)$", $msg)) {
		error($lang->err_no_msg_specified);
	}
	if (empty($viewheader)) $viewheader = 0;
	list($n, $own_email, $s, $timezone) = get_options();
	$mbox = @imap_open("{" . $connectstring . "}INBOX", $usr_username . $usr_append, $usr_password);
	if (!$mbox) {
		redirect("index.php?action=auth_failed");
	}

	$tmpa = array();
	$dec = array();
	$hinfo = imap_headerinfo($mbox, imap_msgno($mbox, $msg));
	$tmpa = $hinfo->from;
	$from = "";
	for ($x=0;$x<sizeof($tmpa);$x++) {
		$dec = imap_mime_header_decode($tmpa[$x]->personal);
		$pers = $dec[0]->text;
		$em = $tmpa[$x]->mailbox . "@" . $tmpa[$x]->host;
		$from .= htmlspecialchars($pers) . " &lt;" . htmlspecialchars($em) . "&gt; <a href=\"contacts.php?action=add&name=" . urlencode($pers) . "&email=" . urlencode($em) . "\" class=\"light\">($lang->message_add_to_contacts)</a> ";
		if ((sizeof($tmpa) - 1) != $x) {
			$from .= ", ";
		}
	}
	$tmpa = $hinfo->to;
	$to = "";
	for ($x=0;$x<sizeof($tmpa);$x++) {
		$dec = imap_mime_header_decode($tmpa[$x]->personal);
		$pers = $dec[0]->text;
		$em = $tmpa[$x]->mailbox . "@" . $tmpa[$x]->host;
		if (strtolower($em) == strtolower($own_email)) {
			$to .= htmlspecialchars($pers) . " &lt;" . htmlspecialchars($em) . "&gt;";
		}
		else {
			$to .= htmlspecialchars($pers) . " &lt;" . htmlspecialchars($em) . "&gt; <a href=\"contacts.php?action=add&name=" . urlencode($pers) . "&email=" . urlencode($em) . "\" class=\"light\">($lang->message_add_to_contacts)</a>";
		}
		if ((sizeof($tmpa) - 1) != $x) {
			$to .= ", ";
		}
	}
	$tmpa = imap_mime_header_decode($hinfo->Subject);
	$subject = "";
	if (count($tmpa)) $subject = $tmpa[0]->text;
	$udate = $hinfo->udate - date("Z") + (60 * $timezone);
	$date = $lang->days[date("w", $udate)] . " " . date("j", $udate) . " " . $lang->months[date("n", $udate) - 1] . " " . date("Y H:i:s", $udate);
	$struct = imap_fetchstructure($mbox, $msg, FT_UID);
	if (empty($subject)) {
			$subject = $lang->none;
	}
	$subject = htmlspecialchars($subject);
	$date = htmlspecialchars($date);

	if ($viewheader == 1) {
		$header = imap_fetchheader($mbox, $msg, FT_UID);
	}

	// Parse structure
	$html_entity = 0;
	$attachments = array();
	$parts = array();
	if (isset($struct->parts)) $parts = $struct->parts;
	if ($struct->type) {
		for ($x=0;$x<sizeof($parts);$x++) {
			$type = $parts[$x]->type;
			if ($type == 1) {
				// Multipart in multipart
				$sparts = $parts[$x]->parts;
				for ($c=0;$c<sizeof($sparts);$c++) {
					if (!$sparts[$c]->type && empty($sparts[$c]->disposition)) {
						if (eregi("html", $sparts[$c]->subtype)) {
							// HTML message
							$part_needed = ($x + 1) . "." . ($c + 1);
							$part_encoding = $sparts[$c]->encoding;
							$tmp = $sparts[$c]->parameters;
							for ($v=0;$v<sizeof($tmp);$v++) {
								if (strtolower($tmp[$v]->attribute) == strtolower("charset")) {
									$part_charset = $tmp[$v]->value;
								}
							}
							$html_entity = 1;
						}
						elseif (eregi("plain", $sparts[$c]->subtype)) {
							// Plain text
							$part_needed = ($x + 1) . "." . ($c + 1);
							$part_encoding = $sparts[$c]->encoding;
							$tmp = $sparts[$c]->parameters;
							for ($v=0;$v<sizeof($tmp);$v++) {
								if (strtolower($tmp[$v]->attribute) == strtolower("charset")) {
									$part_charset = $tmp[$v]->value;
								}
							}
						}
					}
					else {
						$dpara = $sparts[$c]->dparameters;
						for ($v=0;$v<sizeof($dpara);$v++) {
							if (eregi("filename", $dpara[$v]->attribute)) {
								$fname = $dpara[$v]->value;
							}
						}
						if (empty($fname)) {
							$para = $sparts[$c]->parameters;
							for ($v=0;$v<sizeof($para);$v++) {
								if (eregi("name", $para[$v]->attribute)) {
									$fname = $para[$v]->value;
								}
							}
						}
						if (empty($fname)) {
							$disp = $sparts[$c]->description;
						}
						$an = sizeof($attachments);
						$attachments[$an]->id = $sparts[$c]->id;
						$attachments[$an]->part = ($x + 1) . "." . ($c + 1);
						$attachments[$an]->filename = $fname;
						$attachments[$an]->size = $sparts[$c]->bytes;
						$attachments[$an]->mime = mimetype($sparts[$c]->type) . "/" . strtolower($sparts[$c]->subtype);
						$fname = "";
					}
				}
			}
			else {
				if (!$parts[$x]->type && empty($parts[$x]->disposition)) {
					if (eregi("html", $parts[$x]->subtype)) {
						// HTML message
						$part_needed = ($x + 1);
						$part_encoding = $parts[$x]->encoding;
						$tmp = $parts[$x]->parameters;
						for ($v=0;$v<sizeof($tmp);$v++) {
							if (strtolower($tmp[$v]->attribute) == strtolower("charset")) {
								$part_charset = $tmp[$v]->value;
							}
						}
						$html_entity = 1;
					}
					elseif (eregi("plain", $parts[$x]->subtype)) {
						// Plain text
						$part_needed = ($x + 1);
						$part_encoding = $parts[$x]->encoding;
						$tmp = $parts[$x]->parameters;
						for ($v=0;$v<sizeof($tmp);$v++) {
							if (strtolower($tmp[$v]->attribute) == strtolower("charset")) {
								$part_charset = $tmp[$v]->value;
							}
						}
					}
				}
				else {
					$dpara = $parts[$x]->dparameters;
					for ($v=0;$v<sizeof($dpara);$v++) {
						if (eregi("filename", $dpara[$v]->attribute)) {
							$fname = $dpara[$v]->value;
						}
					}
					if (empty($fname)) {
						$para = $parts[$x]->parameters;
						for ($v=0;$v<sizeof($para);$v++) {
							if (eregi("name", $para[$v]->attribute)) {
								$fname = $para[$v]->value;
							}
						}
					}
					if (empty($fname)) {
						$fname = $parts[$x]->description;
					}
					$an = sizeof($attachments);
					$attachments[$an]->id = $parts[$x]->id;
					$attachments[$an]->part = ($x + 1);
					$attachments[$an]->filename = $fname;
					$attachments[$an]->size = $parts[$x]->bytes;
					$attachments[$an]->mime = mimetype($parts[$x]->type) . "/" . strtolower($parts[$x]->subtype);
					$fname = "";
				}			
			}
		}
	}
	else {
		// Not multipart
		if (eregi("html", $struct->subtype)) {
			// HTML message
			$part_needed = "body";
			$part_encoding = $struct->encoding;
			$tmp = $struct->parameters;
			for ($v=0;$v<sizeof($tmp);$v++) {
				if (strtolower($tmp[$v]->attribute) == strtolower("charset")) {
					$part_charset = $tmp[$v]->value;
				}
			}
			$html_entity = 1;
		}
		else {
			$part_needed = "body";
			$part_encoding = $struct->encoding;
			$tmp = $struct->parameters;
			for ($v=0;$v<sizeof($tmp);$v++) {
				if (strtolower($tmp[$v]->attribute) == strtolower("charset")) {
					$part_charset = $tmp[$v]->value;
				}
			}
		}
	}  
	// Get part
	if ($part_needed == "body") {
		$body = imap_body($mbox, $msg, FT_UID);
	}
	else {
		$body = imap_fetchbody($mbox, $msg, $part_needed, FT_UID);
	}
	switch ($part_encoding) {
		case 4:
			$body = imap_qprint($body);
			break;
		case 3:
			$body = imap_base64($body);
	}
	if (strtolower($part_charset) == strtolower("utf-8")) {
		$body = utf8_decode(trim($body));
	}
	if ($html_entity) {
		$body = parse_html($body);
		// Check for inline images
		if (sizeof($attachments) != 0) {
			for ($c=0;$c<sizeof($attachments);$c++) {
				$id = $attachments[$c]->id;
				$part = $attachments[$c]->part;
				if (!empty($id)) {
					// Will get better...
					$id = eregi_replace("<([^>]*)>", "\\1", $id);
					$id = str_replace("$", "\\$", $id);
					$body = eregi_replace("src=(['\"])cid:" . $id . "(['\"])", "src=\\1attachment.php?msg=$msg&part=$part\\2", $body);
					$body = eregi_replace("background=(['\"])cid:" . $id . "(['\"])", "background=\\1attachment.php?msg=$msg&part=$part\\2", $body);
					$body = eregi_replace("src=cid:" . $id, "src=\"attachment.php?msg=$msg&part=$part\"", $body);
					$body = eregi_replace("background=cid:" . $id, "background=\"attachment.php?msg=$msg&part=$part\"", $body);
				}
			}
		}	
	}
	else {
		$body = parse_text($body);
	}

	imap_close($mbox);
	$toolbar = $btn_create . $btn_reply . $btn_forward . $btn_delete . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
	print_header("$subject - $lang->message", $toolbar, "", "");
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%">
	<div align="center">
	<table border="0" width="98%" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="0" cellpadding="2">
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><?php echo $lang->from ?></font></td>
		<td width="70%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><b><?php echo $from; ?></b></font></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><?php echo $lang->to ?></font></td>
		<td width="70%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><b><?php echo $to; ?></b></font></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><?php echo $lang->subject ?></font></td>
		<td width="70%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><b><?php echo $subject; ?></b></font></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><?php echo $lang->date ?></font></td>
		<td width="70%" valign="top" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><b><?php echo $date; ?></b></font></td>
	</tr>
<?php 
	if (sizeof($attachments) != 0) {
		print " <tr>\n";
		print " 	<td width=\"30%\" valign=\"top\" align=\"left\"><font face=\"Verdana, Arial\" size=2 class=\"text\" color=\"#FFFFFF\">$lang->attachments</font></td>\n";
		print " 	<td width=\"70%\" valign=\"top\" align=\"left\"><font face=\"Verdana, Arial\" size=2 class=\"text\" color=\"#FFFFFF\"><b>\n";
		for ($at=0;$at<sizeof($attachments);$at++) {
			$file = $attachments[$at]->filename;
			$part = $attachments[$at]->part;
			$size = $attachments[$at]->size;
			if (empty($file)) {
				$file = $lang->unknown;
			} 
			print " 	<a href=\"attachment.php?msg=$msg&part=$part\"><img src=\"" . $cfg->imgdir . "attachment.png\" width=\"16\" height=\"15\" border=\"0\"></a>\n";
			print " 	<a href=\"attachment.php?msg=$msg&part=$part\" class=\"light\"> $file (" . convsize($size) . ")</a> ";
			if ($attachments[$at]->mime == "text/x-vcard") {
				// VCard
				print " 	<a href=\"contacts.php?action=vcard&msg=$msg&part=$part\" class=\"light\">($lang->message_import_in_contacts)</a> ";
			}
			print "<br>\n";
		}
		print " 	</td>\n";
		print " </tr>\n";
	}	

	
	print " <tr>\n";
	print " 	<td colspan=\"2\">\n";
	print " 	<div align=\"right\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\"><a class=\"light\" href=\"message.php?msg=$msg&viewheader=";
	if ($viewheader == 1) {
		print "0\">$lang->message_hide_header";
	}
	else {
		print "1\">$lang->message_view_header";
	}
	print "</a></font></div>\n";
	print " 	</td>\n";
	print " </tr>\n";

	if ($viewheader == 1) {
		$header = eregi_replace("\t", "    ", nl2br(htmlspecialchars($header)));
		$header = eregi_replace("  ", "&nbsp;&nbsp;", $header);
		print " <tr>\n";
		print " 	<td colspan=\"2\" align=\"left\">\n";
		print " 	<font face=\"Courier New\" size=\"2\" class=\"msgtext\" color=\"#FFFFFF\">$header</font>\n";
		print " 	</td>\n";
		print " </tr>\n";
	}
?>
	</table>
	</div>
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<tr>
	<td bgcolor="<?php echo $cfg->windowbgcolor ?>"><div align="center"><table border="0" bgcolor="<?php echo $cfg->msgbgcolor ?>" width="98%" cellpadding=4 cellspacing=0><tr><td align="left">
<?php
	if (!$html_entity) {
		print "<font face=\"Courier New\" size=\"2\" class=\"msgtext\">\n";
	}
	print $body;
	if (!$html_entity) {
		print "</font>\n";
	}
?>	
	</td></tr></table></div></td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
	print_footer("");
?>
