<?php
/*	eCorrei 1.2.5 - Create script
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

	if (empty($action)) $action = "";
	if ($action == "send") {
		if (get_magic_quotes_gpc()) {
			$to = stripslashes($to);
			$cc = stripslashes($cc);
			$bcc = stripslashes($bcc);
			$subject = stripslashes($subject);
			$body = stripslashes($body);
		}
		$to = trim($to);
		$cc = trim($cc);
		$bcc = trim($bcc);
		$subject = trim($subject);
		$cansend = 1;
		$err_string = "";
		if (empty($to) or empty($body)) {
			$err_string = $lang->err_allfields;
		}

		list($grp, $adr) = get_addresses();

		list($to_addr, $mailto) = parse_addresses($to, $grp, $adr);
		if (empty($to_addr)) { 
			$err_string = $lang->err_invalid_email;
		}
		list($cc_addr, $mailcc) = parse_addresses($cc, $grp, $adr);
		if (!empty($cc) && empty($cc_addr)) {
			$err_string = $lang->err_invalid_email;
		}
		list($bcc_addr, $mailbcc) = parse_addresses($bcc, $grp, $adr);	
		if (!empty($bcc) && empty($bcc_addr)) {
			$err_string = $lang->err_invalid_email;
		}
		
		if (empty($err_string)) {
			if (!empty($cfg->msgsignature)) {
				$body .= $cfg->msgsignature;
			}

			list($name, $email, $signature) = get_options();
			$from = "\"$name\" <$email>";

			$regs = array();
	
			$header = "From: $from\n";
			if (!eregi("__none__", $domains[$usr_domainnr]->outmailserver)) {
				$header .= "To: $to_addr\n";
			}
			if (!empty($cc_addr)) {
				$header .= "CC: $cc_addr\n";
			}
			if (!empty($bcc_addr)) {
				$header .= "BCC: $bcc_addr\n";
			}
			if (!eregi("__none__", $domains[$usr_domainnr]->outmailserver)) {
				$header .= "Subject: $subject\n";
			}
			if ($priority == "high") {
				$header .= "X-Priority: 1\n";
			}
			
			if (count($usr_attach)) {
				/* Create new array */
				$upfiles = array();
				for ($c=0;$c<sizeof($usr_attach);$c++) {
					if (file_exists($usr_attach[$c]->filepath)) {
						$n = sizeof($upfiles);
						$upfiles[$n]->filepath = $usr_attach[$c]->filepath;
						$upfiles[$n]->filename = $usr_attach[$c]->filename;
						$upfiles[$n]->mime = $usr_attach[$c]->mime;
						$upfiles[$n]->size = $usr_attach[$c]->size;
					}
				}
			}
			$usr_attach = array();
			session_unregister("usr_attach");

			if (count($upfiles)) {
				/* Attachments */
				$boundary = uniqueid();
				$header .= "MIME-Version: 1.0\nContent-Type: multipart/mixed;\n\tboundary=\"$boundary\"\n";
				$mbody = "This is a multi-part message in MIME format.\n\n--$boundary\n";
				$mbody .= "Content-Type: text/plain;\n\tcharset=\"$lang->charset\"\nContent-Transfer-Encoding: quoted-printable\n\n";
				$mbody .= imap_8bit($body);
				for ($c=0;$c<sizeof($upfiles);$c++) {
					$tmpbody = "\n--$boundary\n";
		
					if (eregi("([^ ]*)/([^ ]*)", $upfiles[$c]->mime, $regs)) {
						$main_mime = $regs[1];
						$sub_mime = $regs[2];
					}
					$tmpbody .= "Content-Type: $main_mime/$sub_mime;\n\tname=\"" . $upfiles[$c]->filename . "\"\n";
					$inf = fopen($upfiles[$c]->filepath, "r");
					$msgbody = fread($inf, filesize($upfiles[$c]->filepath));
					fclose($inf);
					if (invmimetype($main_mime) > 2) {
						$tmpbody .= "Content-Transfer-Encoding: base64\n";
						$msgbody = imap_binary($msgbody);
					}
					elseif (invmimetype($main_mime) == 0) {
						$tmpbody .= "Content-Transfer-Encoding: quoted-printable\n";
						$msgbody = imap_8bit($msgbody);
					}
					$tmpbody .= "Content-Disposition: attachment;\n\tfilename=\"" . $upfiles[$c]->filename . "\"\n\n";
					$tmpbody .= $msgbody;
					$mbody .= $tmpbody;
					/* Delete file */
					@unlink($upfiles[$c]->filepath);
				}
				$mbody .= "\n--$boundary--\n";
			}
			else {
				$mbody = $body;
			}
			$header .= "X-Mailer: eCorrei/" . VERSION . " (http://ecorrei.sf.net/)\n";
			if (!empty($cfg->showhost)) {
				$header .= "X-eCorrei-Host: $cfg->hostname\n\n";
			}	

			if (!eregi("__none__", $domains[$usr_domainnr]->outmailserver)) {
				/* Send using SMTP */

				$smtp = new SMTP;
				$connect = $smtp->connect($domains[$usr_domainnr]->outmailserver, $domains[$usr_domainnr]->outmailport);
				if ($connect != 4) {
					error($lang->err_mail_failed);
				}
				$mail = $smtp->maildata($email, $mailto, $mailcc, $mailbcc, $header . $mbody);
				if ($mail != 6) {
					error($lang->err_mail_failed);
				}
				$smtp->close();
			}
			else {
				/* Send using mail() */
				$res = mail($to, $subject, $mbody, trim($header));
				if (!$res) {
					error($lang->err_mail_failed);
				}	
			}

			redirect("inbox.php");
		}
	}
	elseif ($action == "attach") {
		if (is_uploaded_file($att_file)) {
			if (get_magic_quotes_gpc()) {
				$att_file_name = stripslashes($att_file_name);
			}
			session_register("usr_attach");
			$add = 1;
			$err_string = "";
			// Check total size
			$total = $att_file_size;
			for ($x=0;$x<sizeof($usr_attach);$x++) {
				$total += $usr_attach[$x]->size;
				if ($usr_attach[$x]->size == $att_file_size && $usr_attach[$x]->filename == $att_file_name && $usr_attach[$x]->mime == $att_file_type) {
					// The same?
					$err_string = $lang->err_already_included;
					$add = 0;
				}
			}
			if ($total > $cfg->maxmailsize) {
				$err_string = $lang->err_mail_size_exceeded;
				$add = 0;
			}
			$total = 0;
			if ($add) {
				// Move file, add to array
				$uni = uniqueid();
				move_uploaded_file($att_file, $cfg->tmpdir . $uni . $att_file_name);
				$num = sizeof($usr_attach);
				$usr_attach[$num]->filepath = $cfg->tmpdir . $uni . $att_file_name;
				$usr_attach[$num]->filename = $att_file_name;
				$usr_attach[$num]->mime = $att_file_type;
				$usr_attach[$num]->size = $att_file_size;
			}
		}
	}
	elseif ($action == "delete") {
		session_register("usr_attach");
		if ($deletenr >= 0 && $deletenr < sizeof($usr_attach)) {
			// Unlink file
			@unlink($usr_attach[$deletenr]->filepath);
			// Delete file from array
			$tmp = array();
			for ($x=0;$x<sizeof($usr_attach);$x++) {
				if ($x != $deletenr) {
					$tmp[] = $usr_attach[$x];
				}
			}
			$usr_attach = $tmp;
		}
	}
	else {
		session_register("usr_attach");
		// Delete attachment array
		if (isset($usr_attach)) {
			for ($x=0;$x<sizeof($usr_attach);$x++) {
				if (file_exists($usr_attach[$x]->filepath)) {
					@unlink($usr_attach[$x]->filepath);
				}
			}
		}
		$usr_attach = array();
	}
	
	list($name, $email, $signature) = get_options();
	$toolbar = $btn_send . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
	$head = "<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\nfunction addSig() {\n\tdocument.mail.body.value=document.mail.body.value+'\\r\\n" . addcslashes($signature, "\n\r\t\'\"") . "';\n}\n\n";
	$head .= "function openContacts() {\n\twindow.open('contacts.php?action=contactwin','contacts','width=525,height=125,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes');\n}\n\n";
	$head .= "function attachFile() {\n\tif (document.mail.att_file.value) {\n\t\tdocument.mail.action.value='attach';\n\t\tdocument.mail.submit();\n\t}\n}\n\n";
	$head .= "function checkForm() {\n\tif (document.mail.att_file.value) {\n\t\talert('" . addslashes($lang->err_attach_first) . "');\n\t\treturn false;\n\t}\n\telse if (emptystr(document.mail.to.value) || emptystr(document.mail.body.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
	$head .= "function deleteFile(file) {\n\tif (document.mail.att_file.value) {\n\t\tdocument.mail.att_file.value='';\n\t}\n\tdocument.mail.action.value='delete';\n\tdocument.mail.deletenr.value=file;\n\tdocument.mail.submit();\n}\n\n";
	$head .= "//-->\n</script>"; 
	print_header($lang->create, $toolbar, "<form method=\"post\" action=\"create.php\" name=\"mail\" enctype=\"multipart/form-data\" onsubmit=\"return(checkForm())\">\n<input type=\"hidden\" name=\"action\" value=\"send\"><input type=\"hidden\" name=\"deletenr\" value=\"\">", $head);

	$new_from = "\"" . htmlspecialchars($name) . "\" <" . htmlspecialchars($email) . ">";

	if ($msg) {
		// Login and get message
		if (!eregi("^([0-9]*)$", $msg)) {
			error($lang->err_no_msg_specified);
		}
		$mbox = @imap_open("{" . $connectstring . "}INBOX", $usr_username . $usr_append, $usr_password);
		if (!$mbox) {
			redirect("index.php?action=auth_failed");
		}
		$tmpa = array();
		$dec = array();
		$hinfo = imap_headerinfo($mbox, imap_msgno($mbox, $msg));
		$tmpa = $hinfo->from;
		for ($x=0;$x<sizeof($tmpa);$x++) {
			$dec = imap_mime_header_decode($tmpa[$x]->personal);
			$pers = $dec[0]->text;
			$em = $tmpa[$x]->mailbox . "@" . $tmpa[$x]->host;
			if (!empty($pers)) {
				$pers = "\"$pers\" ";
			}
			else {
				$pers = "";
			}
			if ($x == 0) {
				$reply_to = $pers . "<" . $em . ">";
			}
			if ((sizeof($tmpa) - 1) == $x) {
				$from .= $pers . "<" . $em . ">";
			}
			else {
				$from .= $pers . "<" . $em . ">, ";
			}		
		} 
		$tmpa = $hinfo->to;
		for ($x=0;$x<sizeof($tmpa);$x++) {
			$dec = imap_mime_header_decode($tmpa[$x]->personal);
			$pers = $dec[0]->text;
			$em = $tmpa[$x]->mailbox . "@" . $tmpa[$x]->host;
			if (!empty($pers)) {
				$pers = "\"$pers\" ";
			}
			else {
				$pers = "";
			}
			$msg_to .= $pers . "<" . $em . ">";
			if ((sizeof($tmpa) - 1) != $x) {
				$msg_to .= ", ";
			}
		}
		$tmpa = imap_mime_header_decode($hinfo->Subject);
		$subject = $tmpa[0]->text;
		$udate = $hinfo->udate;
		$date = $lang->days[date("w", $udate)] . " " . date("j", $udate) . " " . $lang->months[date("n", $udate) - 1] . " " . date("Y H:i:s", $udate);
		$struct = imap_fetchstructure($mbox, $msg, FT_UID);
		// Parse structure
		$parts = $struct->parts;
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
								$html_entity = 1;
							}
							elseif (eregi("plain", $sparts[$c]->subtype)) {
								// Plain text
								$part_needed = ($x + 1) . "." . ($c + 1);
								$part_encoding = $sparts[$c]->encoding;
							}
						}
						elseif ($action == "forward") {
							// Get it, add to array
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
								$fname = $sparts[$c]->description;
							}
							if (empty($fname)) {
								$fname = $lang->unknown;
							}					
							$mime = mimetype($sparts[$c]->type) . "/" . strtolower($sparts[$c]->subtype);
							$body = imap_fetchbody($mbox, $msg, ($x + 1) . "." . ($c + 1), FT_UID);
							switch ($sparts[$c]->encoding) {
								case 4:
									$body = imap_qprint($body);
									break;
								case 3:
									$body = imap_base64($body);
									break;
								default:
									break;
							}
							$uni = uniqueid();
							$outf = fopen($cfg->tmpdir . $uni . $fname, "w");
							fwrite($outf, $body);
							fclose($outf);
							$ua = sizeof($usr_attach);
							$usr_attach[$ua]->filepath = $cfg->tmpdir . $uni . $fname;
							$usr_attach[$ua]->filename = $fname;
							$usr_attach[$ua]->mime = $mime;
							$usr_attach[$ua]->size = $sparts[$c]->bytes;
							$mime = "";
							$body = "";
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
							$html_entity = 1;
						}
						elseif (eregi("plain", $parts[$x]->subtype)) {
							// Plain text
							$part_needed = ($x + 1);
							$part_encoding = $parts[$x]->encoding;
						}					
					}
					elseif ($action == "forward") {
						// Get it, add to array
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
						if (empty($fname)) {
							$fname = $lang->unknown;
						}					
						$mime = mimetype($parts[$x]->type) . "/" . strtolower($parts[$x]->subtype);
						$body = imap_fetchbody($mbox, $msg, ($x + 1), FT_UID);
						switch ($parts[$x]->encoding) {
							case 4:
								$body = imap_qprint($body);
								break;
							case 3:
								$body = imap_base64($body);
								break;
							default:
								break;
						}
						$uni = uniqueid();
						$outf = fopen($cfg->tmpdir . $uni . $fname, "w");
						fwrite($outf, $body);
						fclose($outf);
						$ua = sizeof($usr_attach);
						$usr_attach[$ua]->filepath = $cfg->tmpdir . $uni . $fname;						     $usr_attach[$ua]->filename = $fname;
						$usr_attach[$ua]->mime = $mime;
						$usr_attach[$ua]->size = filesize($cfg->tmpdir . $uni . $fname);
						$mime = "";
						$body = "";
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
				$html_entity = 1;
			}
			else {
				$part_needed = "body";
				$part_encoding = $struct->encoding;
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
				break;
			default:
				break;
		}
		if ($html_entity) {
			$body = html2text($body);
		}
		imap_close($mbox);
		$head = "-- $lang->create_original_msg --\n";
		$head .= "$lang->from: $from\n$lang->to: $msg_to\n$lang->date: $date\n$lang->subject: $subject\n\n";
	}
	if ($action == "reply" && !empty($msg)) {
		if (substr(strtoupper(trim($subject)), 0, 3) != "RE:") {
			$subject = "Re: " . $subject;
		}
		$to = $reply_to;
		$body = "> " . $body;
		$body = eregi_replace("\n", "\n> ", $body);	
		$body = $head . $body;
	}
	elseif ($action == "forward" && $msg) {
		if (substr(strtoupper(trim($subject)), 0, 3) != "FW:") {
			$subject = "Fw: " . $subject;
		}
		$reply_to = "";
		$body = $head . $body;
	}
	if (empty($to)) $to = "";
	if (empty($cc)) $cc = "";
	if (empty($bcc)) $bcc = "";
	if (empty($subject)) $subject = "";
	if (empty($body)) $body = "";
	if (empty($priority)) $priority = "";
	if (get_magic_quotes_gpc()) {
		$to = stripslashes($to);
		$cc = stripslashes($cc);
		$bcc = stripslashes($bcc);
		$subject = stripslashes($subject);
		$body = stripslashes($body);
	}
	$grp = array();
	$add = array();
	$display_add = 0;
	list($grp, $add) = get_addresses();
	if (count($grp) && count($add)) {
		$display_add = 1;
	}
?>
<tr>
	<td width="100%" bgcolor="<?php echo $cfg->darkbarcolor ?>"><div align="center"><table border=0 bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="0" cellpadding="2" width="98%">
<?php
	if ($display_add) {
?>
	<tr>
		<td width="30%" align="left">&nbsp;</td>
		<td width="70%" align="left"><div align="right"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><a href="javascript:openContacts();" class="light"><?php echo $lang->contacts ?></a></font></div></td>
	</tr>
<?php
	}
?>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->from ?></font></td>
		<td width="70%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><b><?php echo htmlspecialchars($new_from); ?></b></font></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->to ?></font></td>
		<td width="70%" align="left"><input type="text" name="to" value="<?php echo htmlspecialchars($to) ?>" size="35" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->cc ?></font></td>
		<td width="70%" align="left"><input type="text" name="cc" value="<?php echo htmlspecialchars($cc); ?>" size="35" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->bcc ?></font></td>
		<td width="70%" align="left"><input type="text" name="bcc" value="<?php echo htmlspecialchars($bcc); ?>" size="35" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->subject ?></font></td>
		<td width="70%" align="left"><input type="text" name="subject" value="<?php echo htmlspecialchars($subject); ?>" size="35" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->attachments ?></font></td>
		<td width="70%" align="left"><input type="file" name="att_file" size="40" class="att_box">&nbsp;<input type="button" size="40" class="att_btn" onclick="attachFile();" value="<?php echo $lang->create_attach ?>">
<?php
	if (!empty($err_string)) {
		print " 	<font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FF0000\"><b>$err_string</b></font>\n";
	}
	/* Display attachments */
	if (count($usr_attach)) {
		print " 	<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"500\">\n";
		print " 	<tr>\n";
		print " 		<td width=\"75\">&nbsp;</td>\n";
		print " 		<td width=\"350\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\"><b>$lang->filename</b></font></td>\n";
		print " 		<td width=\"75\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\"><b>$lang->size</b></font></td>\n";
		print " 	</tr>\n";
		$total = 0;
		for ($a=0;$a<sizeof($usr_attach);$a++) {
			// Count total
			$total += $usr_attach[$a]->size;
			print " 	<tr>\n";
			print " 		<td width=\"75\"><input type=\"button\" class=\"datt_btn\" value=\"$lang->delete\" onclick=\"deleteFile($a)\"></td>\n";
			print " 		<td width=\"350\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\">" . htmlspecialchars($usr_attach[$a]->filename) . "</font></td>\n";
			print " 		<td width=\"75\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\">" . convsize($usr_attach[$a]->size) . "</font></td>\n";
			print " 	</tr>\n";
		}
		print " 	<tr>\n";
		print " 		<td width=\"75\">&nbsp;</td>\n";
		print " 		<td width=\"350\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\"><b>$lang->total</b></font></td>\n";
		print " 		<td width=\"75\"><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\">" . convsize($total) . "</font></td>\n";
		print " 	</tr>\n";
		print " 	</table>\n";
	}

?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><input type="checkbox" name="priority" value="high"<?php if ($priority == "high") print " checked"; ?>>
		<?php echo $lang->high_priority ?></font></td>
		<td width="70%" align="left"><div align="right"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF">
<?php
	if (trim($signature) != "") {
		print " 	<a href=\"javascript:addSig()\" class=\"light\">$lang->create_add_sig</a></font></div></td>\n";
	}
	else {
		print " 	&nbsp;</font></div></td>\n";
	}
?>
	</tr>
	</table></div></td>
</tr>
	<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>">
	<font size=1>&nbsp;</font></td>
</tr>
<tr>
	<td bgcolor="<?php echo $cfg->windowbgcolor ?>" width="100%">
	<div align="center"><textarea name="body" rows="25" cols="75" class="textarea"><?php echo htmlspecialchars($body); ?></textarea></div>
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
	print_footer("</form>");
?>
