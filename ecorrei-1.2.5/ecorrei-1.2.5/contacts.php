<?php
/*	eCorrei 1.2.5 - Address Book script
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
	switch ($action) {
		default:
			// Display the contacts
			$groups = array();
			$addr = array();
			list($groups, $addr) = get_addresses();
			
			$toolbar = $btn_create . $btn_add . $btn_newgrp . $btn_delete_form . $btn_inbox . $btn_options . $btn_logout;
			$head = "<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n\n";
			$head .= "function checkForm() {\n\tvar x;\n\tvar select=false;\n\tfor (x=0;x<document.contacts.length;x++) {\n\t\tif (document.contacts.elements[x].name == 'addr[]' || document.contacts.elements[x].name == 'grp[]') {\n\t\t\tif (document.contacts.elements[x].checked) {\n\t\t\t\tselect=true;\n\t\t\t}\n\t\t}\n\t}\n\tif (!select) {\n\t\talert('" . addslashes($lang->err_select_group_contact) . "');\n\t}\n\telse {\n\t\tselect = confirm('" . addslashes($lang->contacts_confirm_delete) . "');\n\t}\n\treturn select;\n}\n\n";
			$head .= "//-->\n</script>";
			print_header($lang->contacts, $toolbar, "<form method=\"post\" name=\"contacts\" action=\"contacts.php?action=delete\" onsubmit=\"return(checkForm())\"><input type=\"hidden\" name=\"action\" value=\"delete\">", $head);
			
			print "<tr>\n";
			print " <td bgcolor=\"$cfg->darkbarcolor\" align=\"left\">\n";
			print " <font face=\"Verdana, Arial\" class=\"text\" size=2>\n";
			print " &nbsp;$lang->contacts_infostring1 <b>" . count($groups) . "</b> ";
			if (count($groups) == 1) {
				print "$lang->contacts_infostring2 ";
			}
			else {
				print "$lang->contacts_infostring3 ";
			}
			print "$lang->contacts_infostring4 <b>" . count($addr) . "</b> ";
			if (count($addr) == 1) {
				print "$lang->contacts_infostring5 ";
			}
			else {
				print "$lang->contacts_infostring6 ";
			}
			print "$lang->contacts_infostring7:</font></td>\n";
			print "</tr>\n";
			print "<tr>\n";
			print " <td bgcolor=\"$cfg->windowbgcolor\"><font size=1>&nbsp;</font></td>\n";
			print "</tr>\n";

			sort($groups);
			if (count($groups)) {
				for ($i=0;$i<sizeof($groups);$i++) {
					$grpmembers = array();
					print "<tr bgcolor=\"$cfg->darkbarcolor\">\n";
					print " <td align=\"left\">&nbsp;<input type=\"checkbox\" name=\"grp[]\" value=\"" . htmlspecialchars($groups[$i]) . "\">&nbsp;<a href=\"contacts.php?action=grp_details&group=" . urlencode($groups[$i]) . "\"><img src=\"" . $cfg->imgdir . "folder_open.png\" alt=\"$lang->contacts_group\" width=\"16\" height=\"16\" border=\"0\"></a> <font face=\"Verdana, Arial\" size=\"4\" class=\"afolder\"><b><a href=\"contacts.php?action=grp_details&group=" . urlencode($groups[$i]) . "\" class=\"dark\">" . htmlspecialchars($groups[$i]) . "</a></b></font></td>\n";
					print "</tr>\n";
					for ($n=0;$n<sizeof($addr);$n++) {
						list($a, $e, $fld) = explode("|", $addr[$n]);
						if ($fld == $groups[$i]) {
							$grpmembers[] = $addr[$n];
						}
					}
					sort($grpmembers);
					if (count($grpmembers)) {
						print "<tr>\n";
						print " <td>\n";
						print " <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\">\n";
						for ($n=0;$n<sizeof($grpmembers);$n++) {
							if ($n % 2) {
								$clr = $cfg->inbxnew;
							}
							else {
								$clr = $cfg->inbxnormal;
							}
							list($name, $email) = explode("|", $grpmembers[$n]);
							print " <tr bgcolor=\"$clr\">\n";
							print " 	<td width=\"5%\" align=\"left\">&nbsp;</td>\n";
							print " 	<td width=\"5%\" align=\"left\"><input type=\"checkbox\" name=\"addr[]\" value=\"" . htmlspecialchars($email)  ."\"></td>\n";
							print " 	<td width=\"30%\" align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\"><a href=\"contacts.php?action=details&email=" . urlencode($email) . "\">" . htmlspecialchars($name) . "</a></font></td>\n";
							print " 	<td width=\"40%\" align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\"><a href=\"contacts.php?action=details&email=" . urlencode($email) . "\">" . htmlspecialchars($email) . "</a></font></td>\n";
							print " 	<td width=\"20%\" align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\"><a href=\"create.php?to=" . urlencode("\"$name\" <$email>") . "\">$lang->contacts_send_mail</a></font></td>\n";
							print " </tr>\n";
						}
						print " </table>\n";
						print " </td>\n";
						print "</tr>\n";
					}
					else {
						print "<tr bgcolor=\"$cfg->inbxnormal\">\n";
						print " <td><table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\">\n";
						print " <tr bgcolor=\"$cfg->inbxnormal\">\n";
						print " 	<td width=\"5%\" align=\"left\">&nbsp;</td>\n";
						print " 	<td width=\"5%\" align=\"left\">&nbsp;</td>\n";
						print " 	<td width=\"30%\" align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\"><i>$lang->contacts_no_contacts</i></font></td>\n";
						print " 	<td width=\"45%\" align=\"left\">&nbsp;</td>\n";
						print " 	<td width=\"20%\" align=\"left\">&nbsp;</td>\n";
						print " </tr></table></td>\n";
					}						
				}
			}
			else {
				print "<tr bgcolor=\"$cfg->inbxnormal\">\n";
				print " <td align=\"left\"><font face=\"Verdana, Arial\" class=\"text\" size=\"2\">&nbsp;<i>$lang->contacts_no_groups</i></font></td>\n";
				print "</tr>\n";
			}	
			print "<tr bgcolor=\"$cfg->darkbarcolor\">\n";
			print " <td>&nbsp;</td>\n";
			print "</tr>\n";
			print_footer("</form>");
			break;
		case "contactwin":
			$grp = array();
			$add = array();
			$display_add = 0;
			$seladdr = "";
			list($grp, $add) = get_addresses();
			if (count($grp) && count($add)) {
				sort($grp);
				for ($t=0;$t<sizeof($grp);$t++) {
					$grpmem = array();
					for ($i=0;$i<sizeof($add);$i++) {
						list($n, $e, $g) = explode("|", $add[$i]);
						if ($g == $grp[$t]) {
							$grpmem[] = "\"" . $n . "\" <" . $e . ">";
						}
					}
					if (count($grpmem)) {
						$seladdr .= "<option value=\"" . htmlspecialchars($grp[$t]) . "\">" . htmlspecialchars($grp[$t]) . "</option>\n";
						sort($grpmem);
						for ($p=0;$p<sizeof($grpmem);$p++) {
							$seladdr .= "<option value=\"" . htmlspecialchars($grpmem[$p]) . "\">&nbsp;&nbsp;" . htmlspecialchars($grpmem[$p]) . "</option>\n";
						}
					}
				}
			}
			else {
				exit();
			}
			$head = "<script language=\"JavaScript\">\n<!--\n";
			$head .= "function insertAddr(field) {\n\tvar pre=\"\";\n\tif (parent.opener.document.mail.elements[field].value) {\n\t\tpre=\", \";\n\t}\n\tparent.opener.document.mail.elements[field].value=parent.opener.document.mail.elements[field].value+pre+document.addr.seladdr[document.addr.seladdr.selectedIndex].value;\n}\n\n";
			$head .= "//-->\n</script>"; 
			print_miniheader($lang->contacts, "<form name=\"addr\">", $head);

			print "<tr>\n";
			print " <td bgcolor=\"$cfg->windowbgcolor\" width=\"100%\">\n";
			print " <div align=\"center\"><table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"95%\">\n";
			print " <tr>\n";
			print " 	<td valign=\"top\">\n";
			print " 	<div align=\"center\"><select name=\"seladdr\" class=\"selbox\">$seladdr</select>";
			print " 	</div></td>\n";
			print " </tr>\n";
			print " <tr>\n";
			print " 	<td valign=\"top\">\n";
			print " 	<div align=\"center\">\n";
			print " 	<input type=\"button\" onclick=\"insertAddr('to')\" value=\"$lang->contacts_add_to $lang->to\" class=\"button\">&nbsp;\n";
			print " 	<input type=\"button\" onclick=\"insertAddr('cc')\" value=\"$lang->contacts_add_to $lang->cc\" class=\"button\">&nbsp;\n";
			print " 	<input type=\"button\" onclick=\"insertAddr('bcc')\" value=\"$lang->contacts_add_to $lang->bcc\" class=\"button\">&nbsp;\n";
			print " 	</div></td>\n";
			print " </tr>\n";
			print " </table></div></td>\n";
			print "</tr>\n";
			print "<tr>\n";
			print " <td height=\"10\" bgcolor=\"$cfg->darkbarcolor\"><font size=1>&nbsp;</font></td>\n";
			print "</tr>\n";

			print_minifooter("</form>");
			break;
		case "details":
			// Display details
			if (empty($email)) {
				exit();
			}
			$groups = array();
			$addr = array();
			$found = 0;
			list($groups, $addr) = get_addresses();
			for ($r=0;$r<sizeof($addr);$r++) {
				list($fname, $femail, $fgroup) = explode("|", $addr[$r]);
				if ($femail == $email) {
					$found = 1;
					$lname = $fname;
					$lemail = $femail;
					$lgroup = $fgroup; 
				}
			}
			if (!$found) {
				error($lang->err_invalid_email_group);
			}
			$toolbar = $btn_create . $btn_add . $btn_newgrp . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
			$head = "<script language=\"JavaScript\">\n<!--\n";
			$head .= "function checkForm() {\n\tif (emptystr(document.details.name.value) || emptystr(document.details.email.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
			$head .= "//-->\n</script>"; 
			print_header(htmlspecialchars($lname) . " - $lang->contacts", $toolbar, "<form name=\"details\" onsubmit=\"return(checkForm())\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"change\">", $head);
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%"><div align="center">
	<table border="0" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="4" cellpadding="2" width="98%">
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_name ?></font></td>
		<td width="70%" align="left"><input type="text" name="name" value="<?php echo htmlspecialchars($lname); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_email ?></font></td>
		<td width="70%" align="left"><input type="text" name="email" value="<?php echo htmlspecialchars($lemail); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_group ?></font></td>
		<td width="70%" align="left"><select name="group" class="selbox">
<?php
	for ($k=0;$k<sizeof($groups);$k++) {
		if ($groups[$k] == $lgroup) {
			print " 		<option value=\"" . htmlspecialchars($groups[$k]) . "\" selected>" . htmlspecialchars($groups[$k]) . "</option>\n";
		}
		else {	
			print " 		<option value=\"" . htmlspecialchars($groups[$k]) . "\">" . htmlspecialchars($groups[$k]) . "</option>\n";
		}
	}
?>
		</select>
		</td>
	</tr>
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%" align="left">
		<input type="hidden" name="old_email" value="<?php echo htmlspecialchars($lemail); ?>">
		<input type="submit" value="<?php echo $lang->btn_change ?>" class="button"></td>
	</tr>
	</table></div> 
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
			print_footer("</form>");
			break;
		case "change":
			if (get_magic_quotes_gpc()) {
				$old_email = stripslashes($old_email);
				$email = stripslashes($email);
				$name = stripslashes($name);
				$group = stripslashes($group);
			}
			$email = trim($email);
			$name = trim($name);
			$group = trim($group);
			if (empty($email) or empty($name) or empty($group)) {
				error($lang->err_allfields);
			}
			if (!validate_email($email)) {
				error($lang->err_invalid_email);
			}
			if (validate_name($name)) {
				error($lang->err_invalid_name);
			}
			$grp = array();
			$add = array();
			list($grp, $add) = get_addresses();
			// Build new array
			for ($t=0;$t<sizeof($add);$t++) {
				list($na, $em, $gr) = explode("|", $add[$t]);
				if ($em == $old_email) {
					$add[$t] = $name . "|" . $email . "|" . $group;
				}

			}
			$addrdata = implode("\n", $add);
			update_file("Addresses", $addrdata);

			redirect("contacts.php");
			break;
		case "grp_details":
			// Display details
			if (get_magic_quotes_gpc()) {
				$group = stripslashes($group);
			}
			if (empty($group)) {
				exit();
			}
			$groups = array();
			$addr = array();
			$found = 0;
			list($groups, $addr) = get_addresses();
			for ($r=0;$r<sizeof($groups);$r++) {
				if ($group == $groups[$r]) {
					$found = 1;
				}
			}
			if (!$found) {
				error($lang->err_group_not_found);
			}
			$toolbar = $btn_create . $btn_add . $btn_newgrp . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
			$head = "<script language=\"JavaScript\">\n<!--\n";
			$head .= "function checkForm() {\n\tif (emptystr(document.details.group.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
			$head .= "//-->\n</script>";
			print_header(htmlspecialchars($group) . " - $lang->contacts", $toolbar, "<form method=\"post\" name=\"details\" onsubmit=\"return(checkForm())\"><input type=\"hidden\" name=\"action\" value=\"change_grp\"><input type=\"hidden\" name=\"old_group\" value=\"$group\">", $head);
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%"><div align="center">
	<table border="0" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="4" cellpadding="2" width="98%">
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_group ?></font></td>
		<td width="70%" align="left"><input type="text" name="group" size="50" class="textbox" value="<?php echo htmlspecialchars($group); ?>"></td>
	</tr>
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%" align="left"><input type="submit" value="<?php echo $lang->btn_change ?>" class="button"></td>
	</tr>
	</table></div>
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
			print_footer("</form>");

			break;
		case "change_grp":
			if (get_magic_quotes_gpc()) {
				$old_group = stripslashes($old_group);
				$group = stripslashes($group);
			}
			$group = trim($group);
			if (empty($group)) {
				error($lang->err_allfields);
			}
			if (validate_group($group)) {
				error($lang->err_invalid_group);
			}
			$grp = array();
			$add = array();
			list($grp, $add) = get_addresses();

			// Check if group name already exists
			for ($y=0;$y<sizeof($grp);$y++) {
				if (strtolower($group) == strtolower($grp[$y]) && $old_group != $grp[$y]) {
					error($lang->err_group_exists);
				}
			}

			// Change group in groups array
			$groups = array();
			for ($y=0;$y<sizeof($grp);$y++) {
				if ($grp[$y] == $old_group) {
					$groups[] = $group;
				}
				else {
					$groups[] = $grp[$y];
				}
			}
			// Change group in addresses array
			$addresses = array();
			for ($t=0;$t<sizeof($add);$t++) {
				list($name, $email, $g) = explode("|", $add[$t]);
				if ($g == $old_group) {
					$addresses[] = "$name|$email|$group";
				}
				else {
					$addresses[] = $add[$t];
				}
			}
			update_file("Groups", implode("\n", $groups));
			update_file("Addresses", implode("\n", $addresses));

			redirect("contacts.php");
			break;
		case "add":
			$grp = array();
			$add = array();
			if (empty($name)) $name = "";
			if (empty($email)) $email = "";
			list($grp, $add) = get_addresses();
			if (!count($grp)) {
				error($lang->err_create_group_first);
			}
			if (empty($name) && eregi("([-\._a-z0-9]*)@([a-z0-9-]*)\.([-\.a-z0-9]*)", $email, $reg)) {
				$name = $reg[1];
			}
			$toolbar = $btn_create . $btn_newgrp . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
			$head = "<script language=\"JavaScript\">\n<!--\n";
			$head .= "function checkForm() {\n\tif (emptystr(document.add.name.value) || emptystr(document.add.email.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
			$head .= "//-->\n</script>";
			print_header("$lang->contacts_add - $lang->contacts", $toolbar, "<form method=\"post\" name=\"add\" onsubmit=\"return(checkForm())\"><input type=\"hidden\" name=\"action\" value=\"add_contact\">", $head);
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%"><div align="center">
	<table border="0" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="4" cellpadding="2" width="98%">
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_name ?></font></td>
		<td width="70%" align="left"><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_email ?></font></td>
		<td width="70%" align="left"><input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_group ?></font></td>
		<td width="70%" align="left"><select name="group" class="selbox">
<?php
	sort($grp);
	for ($k=0;$k<sizeof($grp);$k++) {
		print " 		<option value=\"" . htmlspecialchars($grp[$k]) . "\">" . htmlspecialchars($grp[$k]) . "</option>\n";
	}
?>
		</select>
		</td>
	</tr>
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%" align="left"><input type="submit" value="<?php echo $lang->btn_add ?>" class="button"></td>
	</tr>
	</table></div>
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
			print_footer("</form>");

			break;
		case "vcard":
			if (!eregi("^([0-9]*)$", $msg) or !eregi("([0-9\.]*)", $part)) {
				exit();
			}
			$grp = array();
			$add = array();
			list($grp, $add) = get_addresses();
			if (!count($grp)) {
				error($lang->err_create_group_first);
			}
			// Get VCard
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
			$vcard = imap_fetchbody($mbox, $msg, $part, FT_UID);
			imap_close($mbox);
			$tmpa = $struct->parts;

			if ($ptwo) {
				$tmpa = $tmpa[$pone]->parts;
				$obj = $tmpa[$ptwo];
			}
			else {
				$obj = $tmpa[$pone];
			}
			switch ($obj->encoding) {
				case 4:
					$vcard = imap_qprint($vcard);
					break;
				case 3:
					$vcard = imap_base64($vcard);
					break;
				default:
					break;
			}
			list($name, $email) = decode_vcard($vcard);
			$toolbar = $btn_create . $btn_add . $btn_newgrp . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
			$head = "<script language=\"JavaScript\">\n<!--\n";
			$head .= "function checkForm() {\n\tif (emptystr(document.add.name.value) || emptystr(document.add.email.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
			$head .= "//-->\n</script>";
			print_header("$lang->contacts_add - $lang->contacts", $toolbar, "<form method=\"post\" name=\"add\" onsubmit=\"return(checkForm())\"><input type=\"hidden\" name=\"action\" value=\"add_contact\">", $head);
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%"><div align="center">
	<table border="0" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="4" cellpadding="2" width="98%">
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_name ?></font></td>
		<td width="70%" align="left"><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_email ?></font></td>
		<td width="70%" align="left"><input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_group ?></font></td>
		<td width="70%" align="left"><select name="group" class="selbox">
<?php
	sort($grp);
	for ($k=0;$k<sizeof($grp);$k++) {
		print " 		<option value=\"" . htmlspecialchars($grp[$k]) . "\">" . htmlspecialchars($grp[$k]) . "</option>\n";
	}
?>
		</select>
		</td>
	</tr>
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%" align="left"><input type="submit" value="<?php echo $lang->btn_add ?>" class="button"></td>
	</tr>
	</table></div> 
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
			print_footer("</form>");
			
			break;
		case "add_contact":
			if (get_magic_quotes_gpc()) {
				$email = stripslashes($email);
				$name = stripslashes($name);
				$group = stripslashes($group);
			}
			$email = trim($email);
			$name = trim($name);
			$group = trim($group);
			if (empty($email) or empty($name) or empty($group)) {
				error($lang->err_allfields);
			}
			if (!validate_email($email)) {
				error($lang->err_invalid_email);
			}
			if (validate_name($name)) {
				error($lang->err_invalid_name);
			}
			$grp = array();
			$add = array();
			list($grp, $add) = get_addresses();
			for ($v=0;$v<sizeof($add);$v++) {
				list($n, $e, $g) = explode("|", $add[$v]);
				if (strtolower($e) == strtolower($email)) {
					error($lang->err_email_exists);
				}
			}
			$add[] = $name . "|" . $email . "|" . $group;
			update_file("Addresses", implode("\n", $add));

			redirect("contacts.php");
			break;
		case "newgrp":
			$toolbar = $btn_create . $btn_add . $btn_inbox . $btn_options . $btn_contacts . $btn_logout;
			$head = "<script language=\"JavaScript\">\n<!--\n";
			$head .= "function checkForm() {\n\tif (emptystr(document.add.group.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
			$head .= "//-->\n</script>"; 
			print_header("$lang->contacts_new_group - $lang->contacts", $toolbar, "<form method=\"post\" name=\"add\" onsubmit=\"return(checkForm())\"><input type=\"hidden\" name=\"action\" value=\"newgroup\">", $head);
?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%"><div align="center">
	<table border="0" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="4" cellpadding="2" width="98%">
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->contacts_group ?></font></td>
		<td width="70%" align="left"><input type="text" name="group" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%" align="left"><input type="submit" value="<?php echo $lang->btn_add ?>" class="button"></td>
	</tr>
	</table></div> 
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
			print_footer("</form>");
			
			break;
		case "newgroup":
			if (get_magic_quotes_gpc()) {
				$group = stripslashes($group);
			}
			$group = trim($group);
			if (empty($group)) {
				error($lang->err_allfields);
			}
			if (validate_group($group)) {
				error($lang->err_invalid_group);
			}
			$grp = array();
			$add = array();
			list($grp, $add) = get_addresses();
			for ($l=0;$l<sizeof($grp);$l++) {
				if (strtolower($group) == strtolower($grp[$l])) {
					error($lang->err_group_exists);
				}
			}
			$grp[] = $group;
			update_file("Groups", implode("\n", $grp));


			redirect("contacts.php");
			break;
		case "delete":
			if (!count($grp) && !count($addr)) {
				error($lang->err_select_group_contact);
			}
			$groups = array();
			$addresses = array();
			$newgrps = array();
			$newaddr = array();
			$newaddr2 = array();
			list($groups, $addresses) = get_addresses();
			if (count($addr)) {
				for ($y=0;$y<sizeof($addresses);$y++) {
					$afound = 0;
					list($n, $e) = explode("|", $addresses[$y]);
					for ($z=0;$z<sizeof($addr);$z++) {
						if ($e == $addr[$z]) {
							$afound = 1;
						}
					}
					if (!$afound) {
						$newaddr[] = $addresses[$y];
					}
				}
			}
			else {
				$newaddr = $addresses;
			}
			if (count($grp)) {
				$magic = 0;
				if (get_magic_quotes_gpc()) {
					$magic = 1;
				}
				for ($i=0;$i<sizeof($grp);$i++) {
					// Check if group exists
					if ($magic) {
						$gr = stripslashes($grp[$i]);
					}
					else {
						$gr = $grp[$i];
					} 
					$grpfound = 0; 
					for ($q=0;$q<sizeof($groups);$q++) {
						if ($groups[$q] == $gr) {
							$grpfound = 1;
						}
					}
					if (!$grpfound) {
						error($lang->err_group_not_found);
					}
				}
				// Build new array
				for ($r=0;$r<sizeof($groups);$r++) {
					$grpfound = 0;
					for ($p=0;$p<sizeof($grp);$p++) {
						if ($magic) {
							$gr = stripslashes($grp[$p]);
						}
						else {
							$gr = $grp[$p];
						} 
						if ($groups[$r] == $gr) {
							$grpfound = 1;
						}
					}
					if (!$grpfound) {
						$newgrps[] = $groups[$r];
					}
				}
				// Delete addresses in group
				for ($i=0;$i<sizeof($newaddr);$i++) {
					$adfound = 0;
					list($n, $e, $g) = explode("|", $newaddr[$i]);
					for ($t=0;$t<sizeof($grp);$t++) {
						if ($magic) {
							$gr = stripslashes($grp[$t]);
						}
						else {
							$gr = $grp[$t];
						} 
						if ($g == $gr) {
							$adfound = 1;
						}
					}
					if (!$adfound) {
						$newaddr2[] = $newaddr[$i];
					}
				}
			}
			else {
				$newaddr2 = $newaddr;
				$newgrps = $groups;
			}
			update_file("Groups", implode("\n", $newgrps));
			update_file("Addresses", implode("\n", $newaddr2));
	
			redirect("contacts.php");
	} 
	exit();
?>
