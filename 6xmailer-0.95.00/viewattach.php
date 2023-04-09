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

	$pop = imap_open ($Mailbox, $Username, $Password, OP_READONLY);
	$mnum = $HTTP_POST_VARS['MSG'];
	$headers = imap_headerinfo ($pop, $mnum);
	$text = imap_body ($pop, $mnum);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML>
		<HEAD>
			<TITLE>Attachments</TITLE>
			<link rel="STYLESHEET" type="text/css" href="<?php echo "themes/" . $Theme;?>/plaintext.css">
		</HEAD>
	<BODY>
	<p><A href="msg.php?MSG=<?php echohtml ($mnum);?>"><?php echohtml ($MISC_BackToMsg)?></A></p>
	<HR>
	<?php echo_part_data($pop, $mnum);?>
	</BODY>
</HTML>
<?php

	imap_close ($pop);

} else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
