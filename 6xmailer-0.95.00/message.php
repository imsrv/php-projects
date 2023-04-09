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

session_register('IsAttach');
session_register('MessageText');
session_register('MessageHTML');
session_register('From');
session_register('Subject');
session_register('Time');
session_register('MsgNum');

$Username = $HTTP_SESSION_VARS['Username'];
$Password = $HTTP_SESSION_VARS['Password'];
$mnum = $HTTP_GET_VARS['MSG'];

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


	$pop = imap_open ($Mailbox, $Username, $Password, OP_READONLY);
	$mnum = $HTTP_GET_VARS['MSG'];
	$headers = imap_headerinfo ($pop, $mnum);
	$text = get_part ($pop, $mnum, "TEXT/PLAIN");

	if (is_attach($pop, $mnum)) {$HTTP_SESSION_VARS['IsAttach'] = true;} else {$HTTP_SESSION_VARS['IsAttach'] = false;}
	$HTTP_SESSION_VARS['MsgNum'] = $mnum;
	$HTTP_SESSION_VARS['From'] = $headers->fromaddress;
	$HTTP_SESSION_VARS['Subject'] = htmlentities ($headers->subject);
	$HTTP_SESSION_VARS['Time'] = $headers->date;
	$HTTP_SESSION_VARS['MessageText'] = get_part ($pop, $mnum, "text/plain");
	$mtext = get_part ($pop, $mnum, "text/html");
	if ($mtext) {
		$HTTP_SESSION_VARS['MessageHTML'] = replaceCIDsrc ($mtext, $mnum);
	} else {
		$mtext = get_part ($pop, $mnum, "text/plain");
		if ($mtext) {
			$HTTP_SESSION_VARS['MessageHTML'] = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><HTML><HEAD><TITLE>Plain Text Message</TITLE></HEAD><BODY leftmargin=3 topmargin=3><pre>" . nl2br (htmlentities ( $mtext)) . "</pre></BODY></HTML>";
		} else {
			$HTTP_SESSION_VARS['MessageHTML'] = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><HEAD><TITLE>MAIL ERROR</TITLE></HEAD><BODY leftmargin=3 topmargin=3><P>" . $MISC_NoMIME . "</P></BODY></html>";
		}
	}


	imap_close($pop)

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Message</title>
<link href="<?php echo "themes/" . $Theme;?>/message.css" rel="stylesheet" type="text/css">
</head>
<frameset rows="<?php echo $HeaderSize;?>,<?php echo $ActionsSize;?>,*" framespacing="0" frameborder="0" style="border-color: ThreedShadow ThreedHighlight ThreedHighlight ThreedShadow; margin: 0; padding: 0; border-width: 1px; border-style: solid;">
    <frame src="header.php" name="headers" id="headers" frameborder="0" scrolling="No" noresize marginwidth="0" marginheight="0" style="border: 0px none; margin: 0px; padding: 0px;">
    <frame src="msgact.php" name="actions" id="actions" frameborder="0" scrolling="No" noresize marginwidth="0" marginheight="0" style="border: 0px none; margin: 0px; padding: 0px;">
    <frame src="msg.php" name="msg" id="msg" frameborder="0" scrolling="Yes" noresize marginwidth="0" marginheight="0" style="border: 0px none; margin: 0px; padding: 0px;">
</frameset>
</html>

<?php } else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
