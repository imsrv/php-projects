<?php
/*	eCorrei 1.2.5 - Options script
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

	/* Timezones */
	$timezones = array(
		"-720" => "Dateline",
		"-660" => "Samoa",
		"-600" => "Hawaiian",
		"-540" => "Alaskan",
		"-480" => "Pacific",
		"-420" => "Mountain",
		"-360" => "Central",
		"-300" => "Eastern",
		"-240" => "Atlantic",
		"-210" => "Newfoundland",
		"-180" => "Brasilia, Buenos Aires",
		"-120" => "Mid-Atlantic",
		"-60" => "Azores",
		"0" => "Greenwich Main Time",
		"60" => "Western Europe",
		"120" => "Eastern Europe",
		"180" => "Russia, Saudi Arabia",
		"210" => "Iran",
		"240" => "Arabian",
		"300" => "West Asia",
		"330" => "India",
		"360" => "Central Asia",
		"420" => "Bangkok, Hanoi, Jakarta",
		"480" => "China, Singapore, Taiwan, Australia (WT)",
		"540" => "Korea, Japan",
		"570" => "Australia (CT)",
		"600" => "Australia (ET)",
		"660" => "Central Pacific",
		"720" => "Fiji, New Zealand");

	if (empty($action)) $action = "";
	if ($action == "change_options") {
		if (get_magic_quotes_gpc()) {
			$realname = stripslashes($realname);
			$realemail = stripslashes($realemail);
			$signature = stripslashes($signature);
		}
		$realname = trim($realname);
		$signature = trim($signature);
		if ($cfg->allowfromchange) {
			$realemail = trim($realemail);
			if (empty($realname) or empty($realemail)) error($lang->err_allfields);
			if (!validate_email($realemail)) error($lang->err_invalid_email);
		}
		elseif (empty($realname)) error($lang->err_allfields);

		if (!eregi("([0-9]*)", $timezone)) exit();

		update_file("Real Name", $realname);
		if ($cfg->allowfromchange) update_file("Real Email", $realemail);
		update_file("Signature", $signature);
		update_file("Timezone", $timezone);
			
		redirect("inbox.php");
	}
	else {
		list($name, $email, $signature, $timezone) = get_options();
		
		$head = "<script language=\"JavaScript\">\n<!--\n";
		$head .= "function checkForm() {\n\tif (emptystr(document.options.realname.value) || emptystr(document.options.realemail.value)) {\n\t\talert('" . addslashes($lang->err_allfields) . "');\n\t\treturn false;\n\t}\n\treturn true;\n}\n\n";
		$head .= "//-->\n</script>"; 
		print_header($lang->options, $btn_create . $btn_inbox . $btn_contacts . $btn_logout, "<form method=\"post\" name=\"options\" onsubmit=\"return(checkForm())\"><input type=\"hidden\" name=\"action\" value=\"change_options\">", $head);

?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" width="100%">
	<div align="center">
	<table border="0" width="98%" bgcolor="<?php echo $cfg->darkbarcolor ?>" cellspacing="0" cellpadding="2">
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->options_name ?></font></td>
		<td width="70%" align="left"><input type="text" name="realname" value="<?php echo htmlspecialchars($name); ?>" size="50" class="textbox"></td>
	</tr>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->options_email ?></font></td>
<?php
	print " 		<td width=\"70%\" align=\"left\">";
	if ($cfg->allowfromchange) {
		print "<input type=\"text\" name=\"realemail\" value=\"". htmlspecialchars($email) . "\" size=\"50\" class=\"textbox\">";
	}
	else {
		print "<font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FFFFFF\"><b>" . htmlspecialchars($email) . "</b></font>";
	}
	print "</td>\n";
?>
	</tr>
	<tr>
		<td width="30%" align="left"><font face="Verdana, Arial" size="2" class="text" color="#FFFFFF"><?php echo $lang->options_timezone ?></font></td>
		<td width="70%" align="left">
		<select name="timezone" class="selbox">
<?php
	while (list($key, $value) = each($timezones)) {
		$h = intval($key / 60);
		$m = abs($key - (intval($h) * 60));

		$td = sprintf("%02d:%02d", $h, $m);
		print " 	<option value=\"$key\"";
		if ($timezone == $key) print " selected";
		print ">(GMT $td) " . htmlspecialchars($value) . "</option>\n";
	} 
?>
		</select>
		</td>
	</tr>
	<tr>
		<td width="30%" valign="top" align="left"><font face="Verdana, Arial" size=2 class="text" color="#FFFFFF"><?php echo $lang->options_signature ?></font></td>
		<td width="70%" align="left"><textarea name="signature" cols="50" rows="5" class="sigbox"><?php echo htmlspecialchars($signature); ?></textarea></td>
	</tr>
	<tr>
		<td width="30%" align="left">&nbsp;</td>
		<td width="70%" align="left"><input type="submit" value="<?php echo $lang->btn_change ?>" class="button"></td>
	</tr>
	</table>
	</div>
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php 
		print_footer("</form>");
	}
?>
