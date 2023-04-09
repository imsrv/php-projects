<?php
/*	eCorrei 1.2.5 - Main script
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
	define("VERSION", "1.2.5");
	require("config.php");
	set_magic_quotes_runtime(0);

	// Temp dir
	if (empty($cfg->tmpdir)) {
		$cfg->tmpdir = ini_get("upload_tmp_dir");
		if (empty($cfg->tmpdir)) {
			die("<p><font color=\"#FF0000\"><b>Please set 'upload_tmp_dir' in php.ini or set \$cfg->tmpdir in config.php!</b></font</p>");
		}
		$cfg->tmpdir .= "/";
	}

	// Don't cache pages
	header("Cache-Control: no-cache");
	header("Cache-Control: no-store");
	header("Pragma: no-cache");

	// Define global vars
	session_start();
	session_register("usr_username", "usr_encpasswd", "usr_domainnr", "usr_accessmethod", "usr_inmailport", "usr_inmailserver", "usr_append", "usr_langcode");
	if (!$bypasscheck) {
		if (empty($usr_username) or empty($usr_encpasswd) or !isset($usr_domainnr) or empty($usr_accessmethod) or empty($usr_inmailport) or empty($usr_inmailserver) or !isset($usr_append) or empty($usr_langcode)) {
			redirect("index.php?action=wronglogin");
		}
		$usr_password = decrypt($usr_encpasswd);
		$connectstring = $usr_inmailserver . "/" . $usr_accessmethod . ":" . $usr_inmailport;
	}

	// Load language file
	if (isset($language) && !isset($usr_langcode)) {
		if ($language >= count($languages) or $language < 0) {
			$usr_langcode = $cfg->default_lang;
		}
		else {
			$usr_langcode = $languages[$language]->code;
		}
	}
	elseif (!isset($language) && !isset($usr_langcode) && !empty($HTTP_ACCEPT_LANGUAGE)) {
		// Get language with browser settings
		$reg = array();
		$arr = explode(",", $HTTP_ACCEPT_LANGUAGE);
		for ($x=sizeof($arr)-1;$x>=0;$x--) {
			if (eregi("^([-a-z0-9]*)", trim($arr[$x]), $reg)) {
				$lng = $reg[1];
			}
			// Search in languages array
			$found = 0;
			$y = 0;
			while (!$found && $y < sizeof($languages)) {
				$found = (strtolower($lng) == strtolower($languages[$y]->code));
				$y++;
			}
			if ($found) $usr_langcode = $lng;
		}
	}
	elseif (!isset($usr_langcode)) {
		$usr_langcode = $cfg->default_lang;
	}
	if ($usr_langcode != "en") {
		// Load English first, so all strings are available
		require($cfg->langdir . "lang.en.php");
	}
	require($cfg->langdir . "lang." . $usr_langcode . ".php");

	if (empty($msg)) $msg = 0;
	$btn_create = "<td align=\"center\"><a href=\"create.php\"><img src=\"" . $cfg->imgdir . "btn_create.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->create\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->create</font></td>\n";
	$btn_refresh = "<td align=\"center\"><a href=\"inbox.php\"><img src=\"" . $cfg->imgdir . "btn_refresh.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->refresh\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->refresh</font></td>\n";
	$btn_inbox = "<td align=\"center\"><a href=\"inbox.php\"><img src=\"" . $cfg->imgdir . "btn_inbox.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->inbox\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->inbox</font></td>\n";
	$btn_reply = "<td align=\"center\"><a href=\"create.php?action=reply&msg=$msg\"><img src=\"" . $cfg->imgdir . "btn_reply.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->reply\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->reply</font></td>\n";
	$btn_forward = "<td align=\"center\"><a href=\"create.php?action=forward&msg=$msg\"><img src=\"" . $cfg->imgdir . "btn_forward.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->forward\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->forward</font></td>\n";
	$btn_delete = "<td align=\"center\"><a href=\"delete.php?msg=$msg\" onclick=\"return (confirm('" . addslashes($lang->message_confirm_delete) . "'));\"><img src=\"" . $cfg->imgdir . "btn_delete.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->delete\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->delete</font></td>\n";
	$btn_send = "<td align=\"center\"><input type=\"image\" src=\"" . $cfg->imgdir . "btn_send.png\" alt=\"$lang->send\" border=\"0\"><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->send</font></td>\n";
	$btn_logout = "<td align=\"center\"><a href=\"index.php?action=logout\"><img src=\"" . $cfg->imgdir . "btn_logout.png\" width=\"50\" height=\"45\" border=\"0\" alt=\"$lang->logout\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->logout</font></td>\n";
	$btn_delete_form = "<td align=\"center\"><input type=\"image\" src=\"" . $cfg->imgdir . "btn_delete.png\" alt=\"$lang->delete\" border=\"0\"><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->delete</font></td>\n";
	$btn_options = "<td align=\"center\"><a href=\"options.php\"><img src=\"" . $cfg->imgdir . "btn_options.png\" width=\"50\" height=\"45\" alt=\"$lang->options\" border=\"0\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->options</font></td>\n";
	$btn_contacts = "<td align=\"center\"><a href=\"contacts.php\"><img src=\"" . $cfg->imgdir . "btn_contacts.png\" width=\"50\" height=\"45\" alt=\"$lang->contacts\" border=\"0\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->contacts</font></td>\n";
	$btn_newgrp = "<td align=\"center\"><a href=\"contacts.php?action=newgrp\"><img src=\"" . $cfg->imgdir . "btn_newgrp.png\" width=\"50\" height=\"45\" alt=\"$lang->contacts_new_group\" border=\"0\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->contacts_new_group</font></td>\n";
	$btn_add = "<td align=\"center\"><a href=\"contacts.php?action=add\"><img src=\"" . $cfg->imgdir . "btn_add.png\" width=\"50\" height=\"45\" alt=\"$lang->contacts_add\" border=\"0\"></a><br><font size=\"1\" class=\"footer\" face=\"Verdana, Arial\">$lang->contacts_add</font></td>\n";

	// Functions & subs
	function print_header($title, $toolbar, $form, $head) {
		global $cfg, $headersent, $lang;
		$headersent = 1;
		print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
		print "<html>\n";
		print "<head>\n";
		print "<script language=\"JavaScript\" type=\"text/javascript\" src=\"" . $cfg->imgdir . "main.js\"></script>\n";
		print "$head\n";
		print "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
		print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$lang->charset\">\n";
		print "<link rel=\"stylesheet\" href=\"" . $cfg->imgdir . "style.css\" type=\"text/css\">\n";
		print "<title>$title - eCorrei</title>\n";
		print "</head>\n";
		print "<body bgcolor=\"$cfg->bgcolor\" link=\"#0000FF\">\n";
		print "$cfg->htmlpre";
		print "<div align=\"center\">\n";
		print "$form\n";
		print "<table width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
		print "<tr>\n";
		print " <td bgcolor=\"$cfg->titlebarcolor\" height=\"20\" width=\"100%\" align=\"left\">\n";
		print " <font face=\"Verdana, Arial\" size=\"2\" class=\"caption\" color=\"$cfg->titlebartxtcolor\"><b>&nbsp; $title - eCorrei</b></font></td>\n";
		print "</tr>\n";
		print "<tr>\n";
		print " <td bgcolor=\"$cfg->windowbgcolor\" height=\"25\" width=\"100%\">\n";
		print " <div align=\"center\">\n";
		print " <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\">\n";
		print " <tr>\n";
		print " $toolbar\n";
		print " </tr>\n";
		print " </table>\n";
		print " </div>\n";
		print " </td>\n";
		print "</tr>\n";
	}

	function print_miniheader($title, $form, $head) {
		global $cfg, $headersent, $lang;
		$headersent = 1;
		print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
		print "<html>\n";
		print "<head>\n";
		print "<script language=\"JavaScript\" type=\"text/javascript\" src=\"" . $cfg->imgdir . "main.js\"></script>\n";
		print "$head\n";
		print "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
		print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$lang->charset\">\n";
		print "<link rel=\"stylesheet\" href=\"" . $cfg->imgdir . "style.css\" type=\"text/css\">\n";
		print "<title>$title - eCorrei</title>\n";
		print "</head>\n";
		print "<body bgcolor=\"$cfg->bgcolor\" link=\"#0000FF\">\n";
		print "<div align=\"center\">\n";
		print "$form\n";
		print "<table width=\"98%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
		print "<tr>\n";
		print " <td bgcolor=\"$cfg->titlebarcolor\" height=\"20\" width=\"100%\" align=\"left\">\n";
		print " <font face=\"Verdana, Arial\" size=\"2\" class=\"caption\" color=\"$cfg->titlebartxtcolor\"><b>&nbsp; $title - eCorrei</b></font><td>\n";
		print "</tr>\n";
	}

	function print_footer($form) {
		global $cfg;
		print "</table>\n";
		print "$form</div>\n";
		print "$cfg->htmlfooter\n";
		print "<div align=\"center\">\n";
		print "<hr width=\"80%\" size=\"1\">\n";
		print "<font face=\"Verdana\" class=\"footer\" size=\"2\">\n";
		print "<a href=\"http://ecorrei.sourceforge.net/\" target=\"_blank\">eCorrei " . VERSION . "</a> - &copy; 2000-2002 Jeroen Vreuls.\n";
		print "</font></div>\n";
		print "</body></html>\n";
	}

	function print_minifooter($form) {
		print "</tr>\n";
		print "</table>\n";
		print "$form</div>\n";
		print "</body></html>\n";
	}

	// Encrypts a password in a trivial encoding
	function encrypt($text) {
		$outp = "";
		for ($x=0;$x<strlen($text);$x++) {
			$nr = ord($text[$x]);
			if ($nr < 128) {
				$nr += 128;
			}
			elseif ($nr > 127) {
				$nr -= 128;
			}
			$nr = 255 - $nr;
			$outp .= sprintf("%02x", $nr);
		}
		return $outp;
	}

	function decrypt($text) {
		$outp = "";
		for ($x=0;$x<(strlen($text)/2);$x++) {
			$nr = hexdec($text[$x * 2] . $text[($x * 2) + 1]);
			$nr = 255 - $nr;
			if ($nr < 128) {
				$nr += 128;
			}
			elseif ($nr > 127) {
				$nr -= 128;
			}
			$outp .= chr($nr);
		}
		return $outp;
	}

	// SMTP class
	class SMTP {
		var $fp = 0;

		function connect($hostname, $port) {
			$this->fp = fsockopen($hostname, $port);
			if (!$this->fp) {
				return 1;
			}
			else {
				$line = fgets($this->fp,1024);
				if (substr($line,0,3) != "220") {
					fclose($this->fp);
					return 2;
				}
				fputs($this->fp,"HELO $hostname\r\n");
				$line = fgets($this->fp, 1024);
				if (substr($line,0,3) != "250") {
					fclose($this->fp);
					return 3;
				}
				return 4;
			}
		}
		function maildata($mailfrom, $mailto, $mailcc, $mailbcc, $maildata) {
			fputs($this->fp, "MAIL FROM: <$mailfrom>\r\n");
			$line = fgets($this->fp, 1024);
			if (substr($line,0,3) != "250") {
				fclose($this->fp);
				return 1;
			}

			if (count($mailto)) {
				for ($c=0;$c<sizeof($mailto);$c++) {
					fputs($this->fp, "RCPT TO: <" . $mailto[$c] . ">\r\n");

					$line = fgets($this->fp, 1024);
					if (substr($line,0,3) != "250") {
						fclose($this->fp);
						return 2;
					}
				}
			}
			if (count($mailcc)) {
				for ($c=0;$c<sizeof($mailcc);$c++) {
					fputs($this->fp, "RCPT TO: <" . $mailcc[$c] . ">\r\n");

					$line = fgets($this->fp, 1024);
					if (substr($line,0,3) != "250") {
						fclose($this->fp);
						return 2;
					}
				}
			}
			if (count($mailbcc)) {
				for ($c=0;$c<sizeof($mailbcc);$c++) {
					fputs($this->fp, "RCPT TO: <" . $mailbcc[$c] . ">\r\n");

					$line = fgets($this->fp, 1024);
					if (substr($line,0,3) != "250") {
						fclose($this->fp);
						return 2;
					}
				}
			}

			fputs($this->fp, "DATA\r\n");
			$line = fgets($this->fp, 1024);
			if (substr($line,0,3) != "354") {
				fclose($this->fp);
				return 3;
			}

			fputs($this->fp, $maildata);
			fputs($this->fp, "\r\n.\r\n");

			$line = fgets($this->fp, 1024);
			if (substr($line,0,3) != "250") {
				fclose($this->fp);
				return 4;
			}
			return 6;
		}
		function close() {
			fputs($this->fp, "QUIT\r\n");

			$line = fgets($this->fp, 1024);
			if (substr($line,0,3) != "221") {
				fclose($this->fp);
				return 1;
			}
			fclose($this->fp);
		}
	}

	// Converts bytes to MB or kB
	function convsize ($size) {
		if ($size > 1048576) {
			// Convert to MB
			return sprintf("%.1f MB", $size / 1048576);
		}
		else {
			// Convert to kB
			return sprintf("%.1f kB", $size / 1024);
		}
	}

	function mimetype ($mime) {
		switch ($mime) {
			case 6:
				return "video";
				break;
			case 5:
				return "image";
				break;
			case 4:
				return "audio";
				break;
			case 3:
				return "application";
				break;
			case 2:
				return "message";
				break;
			default:
				return "text";
				break;
		}
	}

	function invmimetype ($type) {
		switch (strtolower($type)) {
			case "video":
				return 6;
				break;
			case "image":
				return 5;
				break;
			case "audio":
				return 4;
				break;
			case "application":
				return 3;
				break;
			case "message":
				return 2;
				break;
			case "multipart": 
				return 1;
				break;
			case "text":
				return 0;
				break;
			default:
				return 3;
				break;
		}
	}

	// Displays error and exits
	function error($err) {
		global $headersent, $cfg, $lang, $btn_logout;
		if (!$headersent) {
			print_header($lang->error, $btn_logout, "", "");
		}
		print "<tr>\n";
		print " <td bgcolor=\"$cfg->darkbarcolor\" width=\"100%\">\n";
		print " <font face=\"Verdana, Arial\" size=\"2\">&nbsp;$err</font>\n";
		print " </td>\n";
		print "</tr>\n";
		print_footer("");
		exit();
	}

	// Retrieve name, email, signature and timezone from settings file
	function get_options() {
		global $cfg, $usr_username, $usr_append, $usr_inmailserver, $usr_domainnr, $domains;
		$data = array();
		$realemail = "";
		$realname = "";
		$signature = "";
		$timezone = $cfg->default_timezone;
		if (file_exists($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver)) {
			$data = file($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver);
			$regs = array();
			for ($x=0;$x<sizeof($data);$x++) {
				$line = trim($data[$x]);
				if (ereg("^Real Name: (.*)", $line, $regs)) {
					$realname = urldecode($regs[1]);
				}
				elseif (ereg("^Real Email: (.*)", $line, $regs)) {
					$realemail = urldecode($regs[1]);
				}
				elseif (ereg("^Signature: (.*)", $line, $regs)) {
					$signature = urldecode($regs[1]);
				}
				elseif (ereg("^Timezone: (.*)", $line, $regs)) {
					$timezone = urldecode($regs[1]);
				}
			}
		}
		else {
			// Create file
			$realname = ucfirst($usr_username);
			$outf = fopen($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver, "w");
			flock($outf, 2);
			fwrite($outf, "Real Name: " . urlencode($realname) . "\n");
			fwrite($outf, "Real Email: " . urlencode($usr_username . "@" . $domains[$usr_domainnr]->name) . "\n");
			flock($outf, 3);
			fclose($outf);
		}
		return array($realname, $realemail, $signature, $timezone);
	}

	// Gets the group and addresses from settings file
	function get_addresses() {
		global $cfg, $usr_username, $usr_append, $usr_inmailserver, $lang;
		$data = array();
		$groups = array();
		$addr = array();
		$regs = array();
		$grpdata = "";
		$addrdata = "";
		if (file_exists($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver)) {
			$data = file($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver);
		}
		else {
			error($lang->err_datafile_not_found);
		}
		// Parse file
		for ($c=0;$c<sizeof($data);$c++) {
			$line = trim($data[$c]);
			if (eregi("^Groups: (.*)", $line, $regs)) {
				$grpdata = urldecode($regs[1]);
			}
			elseif (eregi("^Addresses: (.*)", $line, $regs)) {
				$addrdata = urldecode($regs[1]);
			}
		}
		if ($grpdata) { $groups = explode("\n", $grpdata); }
		if ($addrdata) { $addr = explode("\n", $addrdata); }
		return array($groups, $addr);
	}

	// Updates a given directive in the settings file
	function update_file($directive, $update) {
		global $cfg, $usr_username, $usr_append, $usr_inmailserver, $lang;
		$update = urlencode($update);
		// Open file
		$data = array();
		$dirfound = 0;
		if (file_exists($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver)) {
			$data = file($cfg->userpath . $usr_username .  $usr_append . "@" . $usr_inmailserver);
		}
		else {
			error($lang->err_datafile_not_found);
		}
		$cnt = "";
		for ($m=0;$m<sizeof($data);$m++) {
			if (ereg("^" . $directive . ":", trim($data[$m]))) {
				$cnt .= $directive . ": " . $update . "\n";
				$dirfound = 1;
			}
			else {
				$cnt .= $data[$m];
			}
		}
		if (!$dirfound) {
			$cnt .= $directive . ": " . $update . "\n";
		}
		if (strlen($cnt) > $cfg->maxfilesize) {
			error($lang->err_file_too_big);
		}
		$outf = fopen($cfg->userpath . $usr_username . $usr_append . "@" . $usr_inmailserver, "w");
		flock($outf, 2);
		fwrite($outf, $cnt);
		flock($outf, 3);
		fclose($outf);
	}

	// Decodes a VCard. I don't know if this complies with the standards...
	function decode_vcard($vcard) {
		$is_vcard = 0;
		$lines = explode("\n", $vcard);
		for ($x=0;$x<sizeof($lines);$x++) {
			$line = trim($lines[$x]);
			if (eregi("begin:vcard", $line) or eregi("end:vcard", $line)) {
				$is_vcard++;
			}
			elseif (eregi("fn:(.*)", $line, $reg)) {
				$fn = $reg[1];
			}
			elseif (eregi("email;pref;internet:(.*)", $line, $reg)) {
				$email = $reg[1];
			}
		}
		if ($is_vcard == 2) {
			return array($fn, $email);
		}
		else {
			return false;
		}
	}

	// Gets a value from a given header string
	function getheadervalue($fieldname, $header) {
		$header = eregi_replace("\t", " ", $header);
		$results = array();
		$resu = "";
		if (eregi("$fieldname (.*)", $header, $results)) {
			$fieldval = $results[1];
			for ($b=0;$b<=strlen($fieldval);$b++) {
				$curr = substr($fieldval, $b, 1);
				$next = substr($fieldval, $b + 1, 1);
				if ($curr == "\n" && $next != " ") {
					break;
				}
				if ($curr == "\t") { $curr = " "; }
				if ($curr == "\n") { $curr = ""; }
				$resu .= $curr;
			}
		}
		$resu = eregi_replace("\([^\)]*\)", "", $resu);
		return $resu;
	}

	// Gets the name and email from a given e-mailaddress
	function convert_email($email) {
		$resu = array();
		if (eregi("\"([^\"]*)\" <([^>]*)>", $email, $resu)) {
			$n = $resu[1];
			$e = $resu[2];
		}
		elseif (eregi("([^ ]*) <([^>]*)>", $email, $resu)) {
			$n = $resu[1];
			$e = $resu[2];
		}
		elseif (eregi("<([^>]*)>", $email, $resu)) {
			$e = $resu[1];
		}
		elseif (eregi("(.*@.*\..*)", $email, $resu)) {
			$e = $resu[1];
		}
		return array($n, $e);
	}

	// Parse body so it can be used as text
	function parse_text($text) {
		$text = eregi_replace("\"", "&quot;", $text);
		$text = eregi_replace("'", "&#039;", $text);
		$text = eregi_replace("<", "&lt;", $text);
		$text = eregi_replace(">", "&gt;", $text);

		$text = eregi_replace("([:; \(\n])(([-&\._a-z0-9]*)@([\.a-z0-9-]*)\.([-a-z0-9]+))", "\\1<a href=\"create.php?to=\\2\">\\2</a>", $text);
		$text = eregi_replace("([[:alnum:]]+)://([a-z0-9/=?%\$@#&_\.-]*)", "<a href=\"\\1://\\2\" target=\"_blank\">\\1://\\2</a>", $text);
		$text = eregi_replace("([^[:alnum:]\"/])(www\.)([a-z0-9/=?\$@%#&_\.-]*)", "\\1<a href=\"http://\\2\\3\" target=\"_blank\" target=\"_new\">\\2\\3</a>", $text);
		$text = eregi_replace("([^[:alnum:]\"/>])(ftp\.)([a-z0-9/=?\$@%#&_\.-]*)", "\\1<a href=\"ftp://\\2\\3\" target=\"_blank\" target=\"_new\">\\2\\3</a>", $text);

		$text = eregi_replace("\t", "	 ", $text);
		$text = eregi_replace("  ", "&nbsp;&nbsp;", $text);
		return nl2br($text);
	}

	// Parse body so it can be used as HTML
	function parse_html($text) {
		$text = eregi_replace("<a ([^>]*)>", "<a target=\"_blank\" \\1>", $text);
		return $text;
	}

	// Converts HTML to plain text
	function html2text($html) {
		$html = eregi_replace("\r", "", $html);
		$html = eregi_replace("\n", " ", $html);
		$html = eregi_replace("\t", " ", $html);
		$html = eregi_replace("[ ]([ ]*)", " ", $html);
		$html = eregi_replace("<br([^>]*)>", "\n", $html);
		$html = eregi_replace("<p([^>]*)>", "\n\n", $html);
		$html = eregi_replace("</div([^>]*)>", "\n", $html);
		$html = eregi_replace("(&nbsp;)", " ", $html);
		return strip_tags($html);
	}

	// Generates unique string
	function uniqueid() {
		return md5(uniqid(rand()));
	}

	// Validates a given e-mailaddress
	function validate_email($email) {
		return eregi("^([-&\._a-z0-9]*)@([a-z0-9-]*)\.([-\.a-z0-9]*)$", $email);
	}

	// Validates a name
	function validate_name($name) {
		return eregi("[|\r\n\x22]", $name);
	}

	// Validates a group
	function validate_group($group) {
		return eregi("[|\r\n,;]", $group);
	}

	// Splits addresses by ; or ,
	function split_addresses($addr) {
		$part = 0;
		$ad = array();
		for ($n=0;$n<strlen($addr);$n++) {
			$char = $addr[$n];
			if ($char == "," or $char == ";") {
				// Next address
				$part++;
			}
			else {
				$ad[$part] .= $char;
			}
		}
		return $ad;
	}

	// Checks a string for valid e-mailaddresses, groups or names
	function parse_addresses($addr, $groups, $addresses) {
		$part = 0;
		$quote = 0;
		$ad = array();
		$ad[0] = "";
		for ($n=0;$n<strlen($addr);$n++) {
			$char = $addr[$n];
			if ($char == "\"" or $char == "'") {
				$quote = !$quote;
			}
			if (($char == "," or $char == ";") and !$quote) {
				/* Next address */
				$part++;
				$ad[$part] = "";
			}
			else {
				$ad[$part] .= $char;
			}
		}

		$emailarr = array();
		$adr = "";

		$to_addr = "";
		for ($x=0;$x<sizeof($ad);$x++) {
			$ca = trim($ad[$x]);
			if (!empty($ca)) {
				/* Search in groups */
				$found = 0;
				$y = 0;
				while (!$found && $y < sizeof($groups)) {
					$found = (strtolower($groups[$y]) == strtolower($ca));
					$y++;
				}
				if ($found) {
					/* Include addresses from group */
					for ($v=0;$v<sizeof($addresses);$v++) {
						list($n, $e, $g) = explode("|", $addresses[$v]);
						if ($g == $groups[$y - 1]) {
							$to_addr .= "\"" . $n . "\" <" . $e . ">, ";
							$emailarr[] = $e;
						}
					}
					continue;
				}
				/* Search in names */
				$found = 0;
				$y = 0;
				while (!$found && $y < sizeof($addresses)) {
					list($n) = explode("|", $addresses[$y]);
					$found = (strtolower($n) == strtolower($ca));
					$y++;
				}
				if ($found) {
					list($n, $e) = explode("|", $addresses[$y - 1]);
					$to_addr .= "\"" . $n . "\" <" . $e . ">, ";
					$emailarr[] = $e;
					continue;
				}
				/* Normal address, include if valid */
				list($n, $e) = convert_email($ca);
				if (empty($e)) return array("", array());
				if (empty($n)) {
					$to_addr .= "<" . $e . ">, ";
				}
				else {
					$to_addr .= "\"" . $n . "\" <" . $e . ">, ";
				}
				$emailarr[] = $e;
			}
		}
		/* Strip last comma */
		$to_addr = substr($to_addr, 0, -2);
		return array($to_addr, $emailarr);
	}

	// Redirects and exits
	function redirect($url) {
		global $cfg;
		header("Location: " . $cfg->protocol . "://" . $cfg->hostname . $cfg->ecorreidir . $url);
		exit();
	}
?>
