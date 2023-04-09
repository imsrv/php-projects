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

session_start();
if (session_is_registered('Username') and session_is_registered('Password')) {

$Username = $HTTP_SESSION_VARS['Username'];
$Password = $HTTP_SESSION_VARS['Password'];

if (!$POPHostname) {
	if (session_is_registered('POPHostname')) {
		$POPHostname = $HTTP_SESSION_VARS['POPHostname'];

		$Mailbox = "{" . $POPHostname . "/pop3:" . $POPPort . "}INBOX";
	} else {?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
		<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML><?php
		exit ();
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Messages List</title>
<meta http-equiv="REFRESH" content="<?php echohtml($RefreshList);?>; url=list.php">
<link href="<?php echo "themes/" . $Theme;?>/list.css" rel="stylesheet" type="text/css">
</head>
<body><?php
$pop = imap_open($Mailbox, $Username, $Password, OP_READONLY);

?><table width="100%" cellspacing="0" cellpadding="0" class="MList">
<!--Header s-->
<tr><th align="center" valign="middle"><img src="<?php echo "themes/" . $Theme; ?>/images/attachment.gif" width="14" height="14" alt="@" border="0" hspace="0" vspace="0"></th><th><?php echohtml ($HEAD_From);?></th><th><?php echohtml ($HEAD_Subject);?></th><th><?php echohtml ($HEAD_When);?></th></tr>
<!--Header e-->
<?php 
$mnum = imap_num_msg($pop);
if ($mnum) {
	for ($i = 1; $i < $mnum + 1; $i++) {
		$headers = imap_headerinfo($pop, $i)
?>
<TR>
	<td width="14" align="center" valign="middle" nowrap><?php if (is_attach ($pop, $i)) { ?><A HREF="message.php?MSG=<?php echohtml ($i);?>" target="Message"><img src="<?php echo "themes/" . $Theme; ?>/images/attachment.gif" width="14" height="14" alt="@" border="0" hspace="0" vspace="0"></A><?php } ?></td>
	<td nowrap><A HREF="message.php?MSG=<?php echohtml ($i);?>" target="Message"><?php echohtml ($headers->fromaddress);?></A></td>
	<td nowrap><A HREF="message.php?MSG=<?php echohtml ($i);?>" target="Message"><?php echohtml ($headers->subject);?></a></td>
	<td nowrap><A HREF="message.php?MSG=<?php echohtml ($i);?>" target="Message"><?php echohtml ($headers->date);?></a></td>
</TR>
<?php }} else {?>
<TR>
	<td nowrap>&nbsp;</td>
	<td align="center" valign="middle" nowrap><?php echohtml ($MISC_NoMessage);?></td>
	<td nowrap>&nbsp;</td>
</TR>
<?php } ?>
</TABLE>
<?php imap_close($pop);?>
</body>
</html>

<?php } else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
