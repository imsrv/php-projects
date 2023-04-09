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
		$POPDomain = $HTTP_SESSION_VARS['POPDomain'];
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
<html><head><title>Delete Message</title>
<link rel="STYLESHEET" type="text/css" href="<?php echo "themes/" . $Theme . "/";?>send.css"></head>
<body>
<?php
	if ($HTTP_POST_VARS['Delete']) {
		$pop = imap_open($Mailbox, $Username, $Password);
		imap_delete($pop, $HTTP_POST_VARS['MSG'], 0);
		imap_expunge($pop);
		imap_close($pop, CL_EXPUNGE);
?>
<table border="0" cellspacing="10" cellpadding="0" align="center"><tr><td align="center" valign="top">
<form action="list.php" target="List">
	<p align="center"><?php echo $MISC_Deleted;?></p>
	<p align="center"><input type="submit" value="<?php echo $BUTTON_OK;?>"></p>
</form>
</td></tr></table>
<?php
	} else {
?>
<script language="JavaScript" type="text/javascript">
<!--
window.top.frames['Message'].location='<?php echo $AboutFile;?>';
//-->
</script>
<table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
<TR><td colspan="2" align="center" valign="bottom"><?php echo $MISC_AskDelete;?></td></TR>
<TR><td width="50%" align="right" valign="top">
	<form action="delete.php" method="post" target="List">
		<input type="hidden" name="MSG" value="<?php echo $HTTP_POST_VARS['MSG'];?>">
		<input type="hidden" name="Delete" value="OK">
		<input type="submit" value="<?php echo $BUTTON_Yes;?>">
	</form>
</td><td width="50%" align="left" valign="top">
	<form action="list.php" target="List">
		<input type="submit" value="<?php echo $BUTTON_No;?>">
	</form>
</td></TR>
</table>
<?php } ?></body></html>

<?php } else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
