<?php
/*	eCorrei 1.2.5 - Index script
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
	$bypasscheck = 1;
	require("main.php");

	if (empty($action)) $action = "";
	$mylang = "";
	if ($action == "logout" or $action == "auth_failed" or $action == "wronglogin") {
		session_register("usr_attach");
		if (isset($usr_attach) && count($usr_attach)) {
			// Delete attachment array
			for ($x=0;$x<sizeof($usr_attach);$x++) {
				if (file_exists($usr_attach[$x]->filepath)) {
					@unlink($usr_attach[$x]->filepath);
				}
			}
			$usr_attach = array();
		}
		$mylang = $usr_langcode;
		session_destroy();
	}
	elseif (!empty($usr_username) && !empty($usr_encpasswd) && isset($usr_domainnr) && !empty($usr_accessmethod) && !empty($usr_inmailport) && !empty($usr_inmailserver) && !empty($usr_langcode)) {
		// Try to login with given data
		redirect("inbox.php");
	}
	else {
		session_unregister("usr_langcode");
	}

	print_header($lang->login, "<td>&nbsp;</td>", "<form action=\"inbox.php\" name=\"login\" method=\"post\">", "<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n\nfunction changeLang() {\n\tif (!document.login.username.value && !document.login.password.value) {\n\t\tdocument.location.href=\"index.php?language=\"+document.login.language[document.login.language.selectedIndex].value;\n\t}\n}\n//-->\n</script>");


?>
<tr>
	<td bgcolor="<?php echo $cfg->darkbarcolor ?>" align="left">
	<font face="Verdana, Arial" class="text" size="2">
	&nbsp;<?php echo $lang->login_please_login ?></font></td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->windowbgcolor ?>" align="left">
<?php
	if ($action == "logout") {
		print "<p><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FF0000\">&nbsp;<b>$lang->login_msg_been_logged_out</b></font></p>\n";
	}
	elseif ($action == "wronglogin") {
		print "<p><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FF0000\">&nbsp;<b>$lang->login_msg_invalid_login</b></font></p>\n";
	}		
	elseif ($action == "auth_failed") {
		print "<p><font face=\"Verdana, Arial\" size=\"2\" class=\"text\" color=\"#FF0000\">&nbsp;<b>$lang->login_msg_wrongpass</b></font></p>\n";
	}		

?>
	<div align="center">
	<input value="login" name="action" type="hidden">
	<table border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td align="left" valign="top"><font face="Verdana, Arial" size=2 class="text"><b><?php echo $lang->login_username ?></b></font></td>
		<td valign="top" align="left"><input name="username" size="30" type="text" class="indexform"></td>
	</tr>
	<tr>
		<td align="left" valign="top"><font face="Verdana, Arial" size=2 class="text"><b><?php echo $lang->login_password ?></b></font></td>
		<td valign="top" align="left"><input name="password" type="password" size="30" class="indexform"></td>
	</tr>
	<tr>
		<td align="left" valign="top"><font face="Verdana, Arial" size=2 class="text"><b><?php echo $lang->login_domain ?></b></font></td>
		<td valign="top" align="left"><select name="domainnr" class="indexform">
<?php
	for ($d=0;$d<sizeof($domains);$d++) {
		print " 	<option value=\"" . $d . "\">" . $domains[$d]->name . "</option>\n";
	}
?>
		</select>
		</td> 
	</tr>
	<tr>
		<td align="left" valign="top"><font face="Verdana, Arial" size=2 class="text"><b><?php echo $lang->login_language ?></b></font></td>
		<td valign="top" align="left">
		<select name="language" class="indexform" onchange="changeLang()">
<?php
	for ($l=0;$l<sizeof($languages);$l++) {
		print " 	<option ";
		if ($languages[$l]->code == $mylang or $languages[$l]->code == $usr_langcode) {
			print "selected ";
		}
		print "value=\"" . $l . "\">" . $languages[$l]->name . "</option>\n";
	}
?>
		</select> 
		</td> 
	</tr>
	<tr>
		<td valign="top">&nbsp;</td>
		<td valign="top" align="left"><input type="submit" value="<?php echo $lang->login ?>" class="button"> <input type="reset" value="<?php echo $lang->btn_reset ?>" class="button"></td>
	</tr>
	</table>   
	</div>
	</td>
</tr>
<tr>
	<td height="10" bgcolor="<?php echo $cfg->darkbarcolor ?>"><font size=1>&nbsp;</font></td>
</tr>
<?php
	print_footer("<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\ndocument.login.username.focus();\n//-->\n</script>\n</form>");
?>
