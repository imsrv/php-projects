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

	header ("Content-Type: " . $HTTP_GET_VARS['MIM'] . "; name=\"". $HTTP_GET_VARS['FLN'] ."\"");
	header ("Content-Disposition: ; filename=\"". $HTTP_GET_VARS['FLN'] ."\"");

	$text = imap_fetchbody($pop, $HTTP_GET_VARS['MSG'], $HTTP_GET_VARS['PRT']); 

	if ($HTTP_GET_VARS['ENC'] == 3) {
		echo imap_base64 ($text);
	} else if ($HTTP_GET_VARS['ENC'] == 4) {
		echo imap_qprint ($text);
	} else {
		echo $text;
	}

	imap_close ($pop);

} else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>