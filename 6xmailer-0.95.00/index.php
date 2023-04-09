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
<html><head>
<title><?php echo $MailSystemTitle;?></title>
<link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#008080" vlink="#008080" alink="#00FFFF">
<!--Title Bar s-->
<h1><?php echo $MailSystemTitle;?></h1>
<!--Title Bar e-->

<!--Login Form s-->
<form action="interface.php" method="post">
<table border="0" cellspacing="0" cellpadding="2" align="center">
<tr class="FormField">
	<td width="50%" align="left" valign="middle" nowrap><?php echo $PROMPT_Username;?></td>
	<td width="50%" align="right" valign="middle" nowrap><input type="text" name="PWC" size="21"></td>
</tr>
<tr><td></td><td></td></tr>
<?php if (!$POPHostname) { ?>
<tr class="FormField">
	<td width="50%" align="left" valign="middle" nowrap><?php echo $PROMPT_Domain;?></td>
	<td width="50%" align="right" valign="middle"><input type="text" name="DOM" size="21"></td>
</tr>
<tr><td></td><td></td></tr>
<?php } ?>
<tr class="FormField">
	<td width="50%" align="left" valign="middle" nowrap><?php echo $PROMPT_Password;?></td>
	<td width="50%" align="right" valign="middle"><input type="password" name="USN" size="21"></td>
</tr>
<tr><td></td><td></td></tr>
<?php if (!$POPHostname) { ?>
<tr class="FormField">
	<td width="50%" align="left" valign="middle" nowrap><?php echo $PROMPT_Server;?></td>
	<td width="50%" align="right" valign="middle"><input type="text" name="POP" size="21"></td>
</tr>
<tr><td></td><td></td></tr>
<?php } ?>
<tr><td></td><td class="FormField"><input type="submit" value="<?php echohtml ($BUTTON_Login);?>">&nbsp;<input type="reset" value="<?php echohtml ($BUTTON_Clear);?>"></td></tr>
</table>
</form>
<!--Login Form e-->
<?php if ($DemoMode) { ?>
<hr>
<p><?php echo $MISC_DemoWarning; ?></p>
<hr>
<?php } ?>
<hr>
<?php if (!$POPHostname) { ?>
<p><b><?php echo $MISC_SideNote; ?>:</b><?php echo $PM_EMail; ?></p>
<?php } ?>
<p><b><?php echo $MISC_SideNote; ?>:</b><?php echo $PM_Netscape; ?></p>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" align="center" valign="bottom"></td>
</tr>
<tr>
	<td width="50%" align="left" valign="top">
		Developed by 6XGate Systems, Inc. Copyright 2001
	</td>
	<td width="50%" align="right" valign="top">
		<a href="http://www.microsoft.com/windows/ie/default.htm"><img src="images/getielogo.gif" width="88" height="31" alt="Get Microsoft Interner Explorer" border="0" hspace="0" vspace="0"></a>&nbsp;
		<a href="http://home.netscape.com"><img src="images/netscape_now_anim.gif" width="90" height="30" hspace="0" vspace="0" border="0" alt="Choose Netscape Now"></a>&nbsp;
		<A href="http://validator.w3.org/"><IMG alt="Valid HTML 4.0!" border="0" height="31" src="images/vh40.gif" width="88" hspace="0" vspace="0"></A>&nbsp;
		<A href="http://jigsaw.w3.org/css-validator"><IMG alt="Valid CSS!" src="images/vcss.gif" hspace="0" vspace="0" border="0" width="88" height="31"></A>
	</td>
</tr>
</table>
</body></html>
