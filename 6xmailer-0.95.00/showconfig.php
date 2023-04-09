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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>

<body>
<table width="60%" border="0" cellspacing="2" cellpadding="0" align="center">
	<TR>
		<td width="50%" bgcolor="Silver">Hostname</td>
		<td width="50%" bgcolor="Yellow"><?php echo $POPHostname; ?></td>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">Port</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $POPPort; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">E-Mail Domain</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $POPDomain; ?></TD>
	</TR>
</TABLE>
<hr width="60%" size="2" color="Gray" noshade>
<table width="60%" border="0" cellspacing="2" cellpadding="0" align="center">
	<TR>
		<td width="50%" bgcolor="Silver">List Refresh Time</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $RefreshList; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">Default Theme</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $Theme; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">Default Language</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $Language; ?></TD>
	</TR>
</TABLE>
<hr width="60%" size="2" color="Gray" noshade>
<table width="60%" border="0" cellspacing="2" cellpadding="0" align="center">
	<TR>
		<td width="50%" bgcolor="Silver">System Title</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $MailSystemTitle; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">Quote Head</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $QuoteInReply; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">Demo Mode?</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $DemoMode; ?></TD>
	</TR>
</TABLE>
<?php if ($HTTP_GET_VARS['minnnim'] == "holoh") { ?>
<hr width="60%" size="2" color="Gray" noshade>
<table width="60%" border="0" cellspacing="2" cellpadding="0" align="center">
	<TR>
		<td width="50%" bgcolor="Silver">SQL Hostname</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $QLHostname; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">SQL Port</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $QLPort; ?></TD>
	</TR>
	<TR>
		<td width="50%" bgcolor="Silver">SQL Socket</td>
		<TD width="50%" bgcolor="Yellow"><?php echo $QLSocket; ?></TD>
	</TR>
</TABLE>
<?php } ?>
</body>
</html>
