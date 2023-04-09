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
if (session_is_registered ('DisName') and session_is_registered ("UID")) {
$UID = $HTTP_SESSION_VARS['UID']
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>User Settings</title>
<link href="<?php echo "themes/" . $Theme;?>/send.css" rel="stylesheet" type="text/css">
</head>
<body topmargin=0 leftmargin=0>
<?php
if ($HTTP_POST_VARS ['DNM']) {
	$HTTP_SESSION_VARS['DisName'] = $HTTP_POST_VARS ['DNM'];
	$HTTP_SESSION_VARS['Signature'] = $HTTP_POST_VARS ['SIGN'];
	$QLHandle = mysql_pconnect ($QLString, $QLUsername, $QLPassword);
	if (!$QLHandle) {
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title>" . $ERROR_SQLErr . "</title></head><body><p>" . $ERROR_SQLConnect . "</p></body></html>";
		exit ();
	}
	$results = mysql_query ("UPDATE " . $QLDatabase . ".userdata SET DisplayName='" . $HTTP_POST_VARS ['DNM'] . "', Signature='" . addcslashes (stripcslashes ($HTTP_POST_VARS ['SIGN']), "\0..\377") . "' WHERE (UID='" . $UID . "')");
	if (!$results) {
	 	echo "<p>ERROR: " . mysql_error () . "</p></body></html>";
		exit ();
	}
?><p>Settings Saved</p><?php
} else { ?>
	<form action="settings.php" method="post">
		<P><?php echo $HEAD_DisName; ?>: <input type="text" name="DNM" value="<?php echo $HTTP_SESSION_VARS['DisName']; ?>" maxlength="50"></P>
		<p><?php echo $HEAD_Signature; ?>: <textarea cols="40" rows="5" name="SIGN"><?php echo htmlentities (stripcslashes ($HTTP_SESSION_VARS['Signature'])); ?></textarea></p>
		<p><input type="submit" value="<?php echo $BUTTON_Save; ?>"></p>
	</form>
<?php } ?>
</body>
</html>


<?php

} else { ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML>

<?php } ?>
