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

require("config.php");
require ("functions.php");
require ("lang/" . $Language . "/strings.php");
require ("themes/" . $Theme . "/theme.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Tool Bar</title>
<link href="<?php echo "themes/" . $Theme;?>/tbar.css" rel="stylesheet" type="text/css"></head>
<body>
<table cellspacing="0" cellpadding="0" class="TBar"><TR>
	<td align="left" valign="middle">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Button">
			<tr>
				<td align="right" valign="middle"><A HREF="send.php" target="Message" onMouseOver="window.status = '<?php echo $STATBAR_ComposeMessage;?>'; return true;" onMouseOut="window.status = ''; return true;"><img src="<?php echo "themes/" . $Theme;?>/images/toolbar/new.gif" width="16" height="16" alt="*" border="0" hspace="0" vspace="0"></A></td>
				<td align="left" valign="middle"><A HREF="send.php" target="Message" onMouseOver="window.status = '<?php echo $STATBAR_ComposeMessage;?>'; return true;" onMouseOut="window.status = ''; return true;"><?php echo $BUTTON_ComposeMessage;?></A></td>
			</tr>
		</table>
	</td>
	<td align="left" valign="middle">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Button">
			<tr>
				<td align="right" valign="middle"><A HREF="list.php" target="List" onMouseOver="window.status = '<?php echo $STATBAR_CheckMail;?>'; return true;" onMouseOut="window.status = ''; return true;"><img src="<?php echo "themes/" . $Theme;?>/images/toolbar/check.gif" width="16" height="16" alt="*" border="0" hspace="0" vspace="0" align="middle"></A></td>
				<td align="left" valign="middle"><A HREF="list.php" target="List" onMouseOver="window.status = '<?php echo $STATBAR_CheckMail;?>'; return true;" onMouseOut="window.status = ''; return true;"><?php echo $BUTTON_CheckMail;?></A></td>
			</tr>
		</table>
	</td>
	<td align="left" valign="middle">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Button">
			<tr>
				<td align="right" valign="middle"><A HREF="addressbook.php" target="List" onMouseOver="window.status = '<?php echo $STATBAR_AddressBook;?>'; return true;" onMouseOut="window.status = ''; return true;"><img src="<?php echo "themes/" . $Theme;?>/images/toolbar/addressbook.gif" width="16" height="16" alt="*" border="0" hspace="0" vspace="0" align="middle"></A></td>
				<td align="left" valign="middle"><A HREF="addressbook.php" target="List" onMouseOver="window.status = '<?php echo $STATBAR_AddressBook;?>'; return true;" onMouseOut="window.status = ''; return true;"><?php echo $BUTTON_AddressBook;?></A></td>
			</tr>
		</table>
	</td>
	<td align="left" valign="middle">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Button">
			<tr>
				<td align="right" valign="middle"><A HREF="<?php echo $AboutFile;?>" target="Message" onMouseOver="window.status = '<?php echo $STATBAR_About;?>'; return true;" onMouseOut="window.status = ''; return true;"><img src="<?php echo "themes/" . $Theme;?>/images/toolbar/about.gif" width="16" height="16" alt="*" border="0" hspace="0" vspace="0" align="middle"></A></td>
				<td align="left" valign="middle"><A HREF="<?php echo $AboutFile;?>" target="Message" onMouseOver="window.status = '<?php echo $STATBAR_About;?>'; return true;" onMouseOut="window.status = ''; return true;"><?php echo $BUTTON_About;?></A></td>
			</tr>
		</table>
	</td>
	<td align="left" valign="middle">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Button">
			<tr>
				<td align="right" valign="middle"><A HREF="settings.php" target="Message" onMouseOver="window.status = '<?php echo $STATBAR_Settings;?>'; return true;" onMouseOut="window.status = ''; return true;"><img src="<?php echo "themes/" . $Theme;?>/images/toolbar/settings.gif" width="16" height="16" alt="*" border="0" hspace="0" vspace="0" align="middle"></A></td>
				<td align="left" valign="middle"><A HREF="settings.php" target="Message" onMouseOver="window.status = '<?php echo $STATBAR_Settings;?>'; return true;" onMouseOut="window.status = ''; return true;"><?php echo $BUTTON_Settings;?></A></td>
			</tr>
		</table>
	</td>
</TR></TABLE>
</body></html>

