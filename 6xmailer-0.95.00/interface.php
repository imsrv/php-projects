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

// Include required functons, configuration, theme, and language
require("config.php");
require ("functions.php");
require ("lang/" . $Language . "/strings.php");
require ("themes/" . $Theme . "/theme.php");

// Start a session and register the new variables
session_start();
session_register('Username');
session_register('Password');
session_register('UID');
session_register('POPEMail');
session_register('DisName');
session_register('Signature');

// Set the username and password variables
$HTTP_SESSION_VARS['Username'] = $HTTP_POST_VARS['PWC'];
$HTTP_SESSION_VARS['Password'] = $HTTP_POST_VARS['USN'];
$Username = $HTTP_SESSION_VARS['Username'];
$Password = $HTTP_SESSION_VARS['Password'];

// If the POP hostname is not set then make sure that the user supplied on.
if (!$POPHostname) {
	if (!$HTTP_POST_VARS['POP']) {
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title></title></head><body><p>" . $ERROR_NoServer . "</p></body></html>";
		exit ();
	}

	// Register the variables for the POP hostname and domain.
	session_register('POPHostname');
	
	// Set the session variables and create the mailbox name.
	$HTTP_SESSION_VARS['POPHostname'] = $HTTP_POST_VARS['POP'];
	if ($HTTP_POST_VARS['DOM']) {
		$HTTP_SESSION_VARS['POPEMail'] = $HTTP_POST_VARS['DOM'];
	} else {
		$HTTP_SESSION_VARS['POPEMail'] = $HTTP_POST_VARS['PWC'];
	}
	$POPHostname = $HTTP_SESSION_VARS['POPHostname'];
	$Mailbox = "{" . $POPHostname . "/pop3:" . $POPPort . "}INBOX";
} else {
	$HTTP_SESSION_VARS['POPEMail'] = $Username . "@" . $POPDomain;
}

$POPEMail = $HTTP_SESSION_VARS['POPEMail'];

// Open the mailbox
@$pop = imap_open ($Mailbox, $Username, $Password, OP_READONLY);

// See if a connection was made
if ($pop) {

	// Do not create or look for a user entry when in demo mode
	if (!$DemoMode) {
		// Create the SQL connection string
		$QLString = $QLHostname;
		if ($QLPort) $QLString .= ":" . $QLPort;
		if ($QLSocket) $QLString .= ":/" . $QLSocket;

		// Connect to the mySQL server
		$QLHandle = mysql_pconnect ($QLString, $QLUsername, $QLPassword);

		// If no handle was returned then you couldn't connect to the server.
		if (!$QLHandle) {
			echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title>" . $ERROR_SQLErr . "</title></head><body><p>" . $ERROR_SQLConnect . "</p></body></html>";
		}

		// Retrieve the use's information from the database
		$query = mysql_query ("SELECT Username FROM " . $QLDatabase . ".userdata WHERE (Username = \"" . $POPEMail . "\")", $QLHandle);
		// If no results come up, then the user needs to be added to the database.
		if (mysql_num_rows ($query) == 0) {
			mysql_query ("INSERT INTO " . $QLDatabase . ".userdata (Username, DisplayName) VALUES (\"" . $POPEMail . "\",\"" . $POPEMail . "\")", $QLHandle);
			// If an error occurs when adding the user, then don't.
			if (mysql_errno ()) {
				echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title>" . $ERROR_SQLErr . "</title></head><body><p>" . $ERROR_AddUser . "</p><p>" . mysql_error () . "</p></body></html>";
				exit ();
			}
		}
		// Now retrieve the new data.
		$query = mysql_query ("SELECT * FROM " . $QLDatabase . ".userdata WHERE (Username = \"" . $POPEMail . "\")", $QLHandle);
		// If no results are returned then and error occured.
		if (mysql_num_rows ($query) == 0) {
			echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title>" . $ERROR_SQLErr . "</title></head><body><p>" . $ERROR_AddUser . "</p><p>" . mysql_error . "</p></body></html>";
			exit ();
		}

		// Store the User ID in the session
		$UID = mysql_result ($query, 0, "UID");
		$HTTP_SESSION_VARS['UID'] = $UID;
		$DisName = mysql_result ($query, 0, "DisplayName");
		$HTTP_SESSION_VARS['DisName'] = $DisName;
		$Signature = mysql_result ($query, 0, "Signature");
		$HTTP_SESSION_VARS['Signature'] = $Signature;
	}?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
	<html>
	<head>
	<title><?php echo $MailSystemTitle . " - " . $TITLE_Interface;?></title>
	<link rel="STYLESHEET" type="text/css" href="<?php echo "themes/" . $Theme;?>/frames.css">
	</head>
	<!-- frames -->
	<frameset rows="<?php echo $ToolbarSize;?>,*">
	    <frame src="title.php" name="Title Bar" id="Title Bar" scrolling="No" noresize marginwidth="0" marginheight="0">
	    <frameset cols="<?php echo $FolderListWidth;?>,*">
	        <frame src="folders.php" name="Folders" id="Folders" scrolling="No" noresize marginwidth="0" marginheight="0">
	        <frameset rows="<?php echo $DefaultPreviewSize;?>,*">
	            <frame src="list.php" name="List" id="List" scrolling="Auto" marginwidth="0" marginheight="0">
	            <frame src="<?php echo $AboutFile;?>" name="Message" id="Message" scrolling="Auto" marginwidth="0" marginheight="0">
	        </frameset>
	    </frameset>
		<noframes>
			<p>Odd browsers...</p>
		</noframes>
	</frameset>
	</html><?php
// If POP connection wasn't made.
} else { ?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<title><?php echo $ERROR_AtLogin; ?></title>
	<link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet">
	</head>
	<body>
	<h1><?php echo $ERROR_AtLogin; ?></h1>
	<p><?php echo $ERROR_LoginList; ?></p><?php
	$imaperrors = imap_errors ();
	$acount = count ($imaperrors);
	for ($i = 0; $i < $acount; $i++) {?>
		<p><?php echohtml ($imaperrors[$i]);?></p><?php
	} ?>
</body>
</html><?php
} 

@imap_close ($pop); ?>
