<?php
/*	eCorrei 1.2.5 - Inbox script
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

	if (empty($action)) $action = "";
	if ($action == "login") {
		$bypasscheck = 1;
		require("main.php");
		// Check all fields
		$usr_username = trim($username);
		$usr_password = trim($password);
		$usr_domainnr = trim($domainnr);
		if (get_magic_quotes_gpc()) {
			$usr_username = stripslashes($username);
			$usr_password = stripslashes($password);
			$usr_domainnr = stripslashes($domainnr);
		}
		if (empty($usr_username) or empty($usr_password)) {
			error("Please fill in all the fields.");
		}
		$usr_encpasswd = encrypt($usr_password);
		$usr_accessmethod = $domains[$usr_domainnr]->accessmethod;
		$usr_inmailport = $domains[$usr_domainnr]->inmailport;
		$usr_inmailserver = $domains[$usr_domainnr]->inmailserver;
		$usr_append = $domains[$usr_domainnr]->append;
		$usr_langcode = $languages[$language]->code;

		$connectstring = $usr_inmailserver . "/" . $usr_accessmethod . ":" . $usr_inmailport;
	}
	else {
		$bypasscheck = 0;
		require("main.php");
	}

	if (empty($sort)) { $sort = $cfg->default_sort; }
	if (!isset($direction)) { $direction = $cfg->default_direction; }

	// Open connection
	$mbox = @imap_open("{" . $connectstring . "}INBOX", $usr_username . $usr_append, $usr_password);
	if (!$mbox) {
		redirect("index.php?action=auth_failed");
	}

	$num_msg = imap_num_msg($mbox);
	$mailinfo = imap_mailboxmsginfo($mbox);
	$newmsg = $mailinfo->Unread;
	$second_bar = "$lang->inbox_infostring1 <b>$num_msg</b> ";
	if ($num_msg == 1) {
		$second_bar .= "$lang->inbox_infostring3 ";
	}
	else {
		$second_bar .= "$lang->inbox_infostring2 ";
	}
	if (strtolower($usr_accessmethod) == "imap") {
		$second_bar .= "(<b>$newmsg</b> $lang->inbox_infostring4) ";
	}
	$second_bar .= "($lang->inbox_infostring5 " . convsize($mailinfo->Size) . "):";

	list($muser, $e, $s, $timezone) = get_options();
	$title = "$muser's $lang->inbox";

	$toolbar = $btn_create . $btn_delete_form . $btn_refresh . $btn_options . $btn_contacts . $btn_logout;

	$head = "<meta http-equiv=\"Refresh\" content=\"" . $cfg->refreshtime . ";URL=" . $cfg->protocol . "://" . $cfg->hostname . $cfg->ecorreidir . "inbox.php?sort=$sort&direction=$direction\">\n";
	$head .= "<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n\n";
	$head .= "function checkForm() {\n\tvar x;\n\tvar select=false;\n\tfor (x=0;x<document.mbox.length;x++) {\n\t\tif (document.mbox.elements[x].name == 'msg[]') {\n\t\t\tif (document.mbox.elements[x].checked) {\n\t\t\t\tselect=true;\n\t\t\t}\n\t\t}\n\t}\n\tif (!select) {\n\t\talert('" . addslashes($lang->err_select_msg) . "');\n\t}\n\telse {\n\t\tselect = confirm('" . addslashes($lang->inbox_confirm_delete) . "');\n\t}\n\treturn select;\n}\n\n";
	$head .= "function invertSelection() {\n\tvar x;\n\tfor (x=0;x<document.mbox.length;x++) {\n\t\tif (document.mbox.elements[x].name = 'msg[]') {\n\t\t\tdocument.mbox.elements[x].checked = !document.mbox.elements[x].checked;\n\t\t}\n\t}\n}\n\n";
	$head .= "//-->\n</script>";
	print_header($title, $toolbar, "<form method=\"post\" name=\"mbox\" action=\"delete.php\" onsubmit=\"return(checkForm())\">", $head);
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" align="left">
	<font face="Verdana, Arial" class="text" size="2">
	&nbsp;<?php echo $second_bar ?></font></td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size="1">&nbsp;</font></td>
</tr>
<tr>
	<td>
	<table border="0" cellspacing="1" cellpadding="2" width="100%">
	<tr>
		<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="7%">
		&nbsp;</td>
<?php
	if ($direction) {
		$newdirection = 0;
		$imgstring = "&nbsp;<img src=\"". $cfg->imgdir . "arrow_down.png\" alt=\"$lang->inbox_sort_high_to_low\">";
	}
	else {
		$newdirection = 1;
		$imgstring = "&nbsp;<img src=\"". $cfg->imgdir . "arrow_up.png\" alt=\"$lang->inbox_sort_low_to_high\">";
	}

	print " 	<td bgcolor=\"$cfg->darkbarcolor\" align=\"left\" width=\"25%\">\n";
	print " 	<font face=\"Verdana, Arial\" size=\"2\" class=\"text\"><b><a href=\"inbox.php?sort=" . SORTFROM . "&direction=$newdirection\" class=\"light\">$lang->from</a>";
	if ($sort == SORTFROM) {
		print $imgstring;
	}
	print "</b></font></td>\n";
	print " 	<td bgcolor=\"$cfg->darkbarcolor\" align=\"left\" width=\"43%\">\n";
	print " 	<font face=\"Verdana, Arial\" size=\"2\" class=\"text\"><b><a href=\"inbox.php?sort=" . SORTSUBJECT . "&direction=$newdirection\" class=\"light\">$lang->subject</a>";
	if ($sort == SORTSUBJECT) {
		print $imgstring;
	}
	print "</b></font></td>\n";
	print " 	<td bgcolor=\"$cfg->darkbarcolor\" align=\"left\" width=\"15%\">\n";
	print " 	<font face=\"Verdana, Arial\" size=\"2\" class=\"text\"><b><a href=\"inbox.php?sort=" . SORTARRIVAL . "&direction=$newdirection\" class=\"light\">$lang->date</a>";
	if ($sort == SORTARRIVAL) {
		print $imgstring;
	}
	print "</b></font></td>\n";
	print " 	<td bgcolor=\"$cfg->darkbarcolor\" align=\"left\" width=\"10%\">\n";
	print " 	<font face=\"Verdana, Arial\" size=\"2\" class=\"text\"><b><a href=\"inbox.php?sort=" . SORTSIZE . "&direction=$newdirection\" class=\"light\">$lang->size</a>";
	if ($sort == SORTSIZE) {
		print $imgstring;
	}
	print "</b></font></td>\n";
	print " </tr>\n";

	$tmpa = array();
	$regs = array();

	if ($num_msg == 0) {
		print " <tr bgcolor=\"$cfg->inbxnormal\">\n";
		print " 	<td align=\"left\">&nbsp;</td>\n";
		print " 	<td align=\"left\">&nbsp;</td>\n";
		print " 	<td align=\"left\"><font face=\"Verdana, Arial\" class=\"text\"><i>$lang->inbox_no_messages</i></font></td>\n";
		print " 	<td align=\"left\">&nbsp;</td>\n";
		print " 	<td align=\"left\">&nbsp;</td>\n";
		print " </tr>\n";
	}
	else {
		$cdate = time() - date("Z") + (60 * $timezone);
		$daymonth = date("j", $cdate);
		$month = date("m", $cdate);
		$year = date("Y", $cdate);
		$sorted_msg = array();
		$sorted_msg = imap_sort($mbox, $sort, $direction, SE_UID);
		for ($x=0;$x<sizeof($sorted_msg);$x++) {
			$uid = $sorted_msg[$x];
			$new = 0;
			$mtype = "";
			$stype = "";
			$conttype = "";
			$priority = "";
			$hinfo = imap_headerinfo($mbox, imap_msgno($mbox, $uid));
			$tmpa = $hinfo->from;
			$from = $tmpa[0]->personal;
			if (empty($from)) {
				$from = $tmpa[0]->mailbox . "@" . $tmpa[0]->host;
			}
			$tmpa = imap_mime_header_decode($from);
			$from = $tmpa[0]->text;
			$tmpa = imap_mime_header_decode($hinfo->Subject);
			$subject = "";
			if (count($tmpa)) $subject = $tmpa[0]->text;
			$udate = $hinfo->udate - date("Z") + (60 * $timezone);
			if ($daymonth == date("j", $udate) && $month == date("m", $udate) && $year == date("Y", $udate)) {
				$date = date("H:i:s", $udate);
			}
			else {
				$date = date($lang->date_fmt, $udate);
			}
			// Don't want to use imap_fetchstructure() because it's slow...
			$head = imap_fetchheader($mbox, $uid, FT_UID);
			$fetch_over = imap_fetch_overview($mbox, $uid, FT_UID);
			$size = convsize($fetch_over[0]->size);
			$conttype = getheadervalue("Content-Type:", $head);
			if (!empty($conttype) && eregi("([^/]*)/([^ ;\n\t]*)", $conttype, $regs)) {
				$mtype = $regs[1];
				$stype = $regs[2];
			}
			$priority = getheadervalue("X-Priority:", $head);
			if (empty($subject)) {
				$subject = $lang->none;
			}
			$from = htmlspecialchars($from);
			$subject = htmlspecialchars($subject);
			$date = htmlspecialchars($date);
			if (strtolower($usr_accessmethod) == "imap") {
				if ($hinfo->Unseen == "U" or $hinfo->Recent == "N") {
					$new = 1;
				}
			}
			if ($new) {
				$clr = $cfg->inbxnew;
			}
			else {
				$clr = $cfg->inbxnormal;
			}
			print " <tr bgcolor=\"$clr\">\n";
			print " 	<td align=\"left\"><input type=\"checkbox\" name=\"msg[]\" value=$uid>";
			if (invmimetype($mtype) && strtolower($stype) != "alternative" && !empty($mtype) && !empty($stype)) { 
				print "<img src=\"" . $cfg->imgdir . "paperclip.png\" alt=\"$lang->attachment\"> ";
			}
			if ($priority == 1) {
				print " <img src=\"" . $cfg->imgdir . "priority.png\" alt=\"$lang->high_priority\">";
			}
			print "</td>\n";
			print " 	<td align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\"><a href=\"message.php?msg=$uid\">$from</a></font></td>\n";
			print " 	<td align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\"><a href=\"message.php?msg=$uid\">$subject</a></font></td>\n";
			print " 	<td align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\">$date</font></td>\n";
			print " 	<td align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\">$size</font></td>\n";
			print " </tr>\n";
		}
	}
	imap_close($mbox);
?>
	<tr bgcolor="<?php echo $cfg->darkbarcolor ?>">
		<td>&nbsp;</td>
		<td><font face="Verdana, Arial" class="text" size="2"><a href="javascript:invertSelection();" class="light"><?php echo $lang->inbox_invert_selection ?></a></font></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</table>	
	</td>
</tr>
<?php
	print_footer("</form>");
?>
