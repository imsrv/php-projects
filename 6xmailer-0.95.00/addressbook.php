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

// If the interface is in demo mode, then do not display the address book
if ($DemoMode) {
	echo "<HTML><HEAD><TITLE></TITLE></HEAD><BODY>" . $ERROR_DemoMode . "</BODY></HTML>";
	exit ();
}

// Start the session and make sure that the UserID has been set
session_start ();
if (session_is_registered ("UID")) {

	$UID = $HTTP_SESSION_VARS['UID'];

	// Create the SQL connection string
	$QLString = $QLHostname;
	if ($QLPort) $QLString .= ":" . $QLPort;
	if ($QLSocket) $QLString .= ":/" . $QLSocket;

	// Connect to the mySQL server
	$QLHandle = mysql_pconnect ($QLString, $QLUsername, $QLPassword);

	// Did we connect?
	if (!$QLHandle) {
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title>" . $ERROR_SQLErr . "</title></head><body><p>" . $ERROR_SQLConnect . "</p></body></html>";
		exit ();
	}
?>	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
	<html><head>
		<title>Address Book</title>
		<link rel="STYLESHEET" type="text/css" href="<?php echo "themes/" . $Theme;?>/addressbook.css">
		<script language="JavaScript" type="text/javascript">
		<!--
			function SetEMail (Email) {
				if (window.top.frames['Message'].location.href.indexOf ('send.php') <= 0) {
					return true;
				}
				if (window.top.frames['Message'].document.forms['sendform']) {
					window.top.frames['Message'].document.forms['sendform'].TO.value = Email;
					return false;
				}
				return false;
			}

			function StatSendTo () {
				window.status = '<?php echo $STATBAR_SendTo;?>';
				return true;			
			}

			function StatAdd () {
				window.status = '<?php echo $STATBAR_AddAddress;?>';
				return true;			
			}

			function StatEdit () {
				window.status = '<?php echo $STATBAR_EditAddress;?>';
				return true;			
			}

			function StatRemove () {
				window.status = '<?php echo $STATBAR_DeleteAddress;?>';
				return true;			
			}

			function StatBlank () {
				window.status = '';
				return true;			
			}
		//-->
		</script>
	</head>
	<body>
<?php
	// What is the action
	switch ($HTTP_POST_VARS['action']) {
		// ================================================
		case 'edt':		// Edit the entry
		// ================================================
			// If the it is ready to be saved and the e-mail address is present update or add the entry
			if ($HTTP_POST_VARS['SaveIt'] and $HTTP_POST_VARS['EMAIL']) {
				// If a EntryID is present then update the entry, otherwise add it
				if ($HTTP_POST_VARS['EID']) {
					$results = mysql_query ("UPDATE " . $QLDatabase . ".addressbook SET Display='" . $HTTP_POST_VARS['NAME'] . "',  E_Mail='" . $HTTP_POST_VARS['EMAIL'] . "',  Phone='" . $HTTP_POST_VARS['PHONE'] . "' WHERE EID='" . $HTTP_POST_VARS['EID'] . "'");
					if (!$results) {
						echo "<p>ERROR: " . mysql_error () . "</p></body></html>";
						exit ();
					}
					// Show a message confirming the action
					echo "<form action=\"addressbook.php\" method=\"post\"><P>" . $MISC_Contact_Updated . "</P><input type=\"submit\" value=\"" . $BUTTON_OK . "\"></form>";
				 } else { 
					$results = mysql_query ("INSERT INTO " . $QLDatabase . ".addressbook (UID, Display, E_Mail, Phone) VALUES ('" . $UID . "', '" . $HTTP_POST_VARS['NAME'] . "', '" . $HTTP_POST_VARS['EMAIL'] . "', '" . $HTTP_POST_VARS['PHONE'] . "')");
					if (!$results) {
						echo "<p>ERROR: " . mysql_error () . "</p></body></html>";
						exit ();
					}
					// Show a message confirming the action
					echo "<form action=\"addressbook.php\" method=\"post\"><P>" . $MISC_Contact_Add . "</P><input type=\"submit\" value=\"" . $BUTTON_OK . "\"></form>";
				}
			} else {
				// If an Entry ID is present, load existing data into the form
				if ($HTTP_POST_VARS['EID']) {

					// Get the data
					$results = mysql_query ("SELECT * FROM " . $QLDatabase . ".addressbook WHERE (EID=" . $HTTP_POST_VARS['EID'] . ")", $QLHandle);
					if (!$results) {
						echo "<p>ERROR: " . mysql_error () . "</p></body></html>";
						exit ();
					}

					// Store it in variables
					$UNAME = mysql_result($results, $i, "Display");
					$UEMAIL = mysql_result($results, $i, "E_Mail");
					$UPHONE = mysql_result($results, $i, "Phone");

				}?>
				<form action="addressbook.php" method="post">
				<table>
				<tr>
					<td><?php echo $HEAD_Name; ?>: </td>
					<td><input type="text" name="NAME" value="<?php echo $UNAME; ?>" size="50" maxlength="50"></td>
				</tr>
				<tr>
					<td><?php echo $HEAD_EMail; ?>: (<?php echo $HEAD_Required; ?>)</td>
					<td><input type="text" name="EMAIL" value="<?php echo $UEMAIL; ?>" size="50" maxlength="100"></td>
				</tr>
				<tr>
					<td><?php echo $HEAD_PhoneNumber; ?>: </td>
					<td><input type="text" name="PHONE" size="14" value="<?php echo $UPHONE; ?>" maxlength="14"></td>
				</tr>
				</table>
				<input type="hidden" name="<?php echo $BUTTON_Save; ?>" value="OK">
				<input type="hidden" name="action" value="edt">
				<input type="hidden" name="EID" value="<?php echo $HTTP_POST_VARS['EID']; ?>">
				<input type="submit" value="<?php echo $BUTTON_Save; ?>">
				</form>
				<form action="addressbook.php"><input type="submit" value="<?php echo $BUTTON_Cancel; ?>"></form><?php
			}
			break;
		// =================================================
		case 'del':		// Delete the entry
		// =================================================
			if ($HTTP_POST_VARS['delete']) {
				$results = mysql_query ("DELETE FROM " . $QLDatabase . ".addressbook where EID='" . $HTTP_POST_VARS['EID'] . "'", $QLHandle);
				if ($results) {
					echo "<p>" . $MISC_Contact_Deleted . "</p><form action=\"addressbook.php\" method=\"post\"><input type=\"submit\" value=\"" . $BUTTON_OK . "\"></form>";
				} else {
					echo "<p>ERROR: " . mysql_error () . "</p></body></html>";
					exit ();
				}
			} else { ?>
				<p><?php echo $MISC_Contact_AskDelete;?></p>
				<table>
					<tr>
						<td>
							<form action="addressbook.php" method="post" target="List">
								<input type="hidden" name="EID" value="<?php echo $HTTP_POST_VARS['EID']; ?>">
								<input type="hidden" name="action" value="del">
								<input type="hidden" name="delete" value="ok">	
								<input type="submit" value="<?php echo $BUTTON_Yes; ?>">
							</form>
						</td>
						<td>
							<form action="addressbook.php" method="post" target="List">
								<input type="submit" value="<?php echo $BUTTON_No; ?>">
							</form>
						</td>
					</tr>
				</table><?php
			}
			break;
		// ====================================================
		default:		// Show the address book
		// ====================================================?>
	<form action="addressbook.php" method="post" target="List">
		<input type="hidden" name="action" value="edt">
		<input type="submit" value="<?php echo $BUTTON_ContactAdd; ?>" title="<?php echo $STATBAR_AddAddress; ?>" onMouseOver="return StatAdd ();" onMouseOut="return StatBlank();">
	</form>

	<table width="100%" cellspacing="0" cellpadding="0" class="Entry">
		<tr>
			<th width="100%" colspan="3"></th>
			<th></th>
		</tr>
		<tr>
			<th align="left"><?php echo $HEAD_Name; ?></th>
			<th align="left"><?php echo $HEAD_EMail; ?></th>
			<th align="left"><?php echo $HEAD_PhoneNumber; ?></th>
			<th align="left"><?php echo $HEAD_Actions; ?></th>
		</tr><?php
		// Retrieve the address book
		$results = mysql_query ("SELECT * FROM " . $QLDatabase . ".addressbook WHERE (UID=" . $UID . ")", $QLHandle);
		// If an error occures, display it
		if (!$results) {
			echo "<tr><td colspan=\"4\">ERROR: " . mysql_error () . "</td></tr></table></body></html>";
			exit ();
		}
		// Get the number of rows return
		$Rows = mysql_num_rows ($results);

		// List the entries
		for ($i = 0; $i < $Rows; $i++) {
			$UNAME = htmlentities (mysql_result($results, $i, "Display"));
			$UEMAIL = htmlentities (mysql_result($results, $i, "E_Mail"));
			$UPHONE = htmlentities (mysql_result($results, $i, "Phone"));
			$EID = mysql_result($results, $i, "EID");
			
			// If the phone number and name entry are empty then use a non-breaking space
			if (!$UPHONE) $UPHONE = "&nbsp;";
			if (!$UNAME) $UNAME = "&nbsp;";
			?>
			<tr>
				<td><?php echo $UNAME; ?></td>
				<td><?php echo $UEMAIL; ?></td>
				<td><?php echo $UPHONE; ?></td>
				<td align="right" valign="middle">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>			
							<td nowrap>
								<form action="send.php" method="post" name="SendTo" id="SendTo" target="Message" onSubmit="return SetEMail ('<?php echo $UEMAIL;?>');">
									<input type="hidden" name="TO" value="<?php echo $UEMAIL;?>">
									<input type="submit" value="<?php echo $BUTTON_SendTo; ?>" title="<?php echo $STATBAR_SendTo; ?>" onMouseOver="return StatSendTo ();" onMouseOut="return StatBlank();">
								</form>
							</td>
							<td nowrap>
								<form action="addressbook.php" method="post" target="List">
									<input type="hidden" name="action" value="edt">
									<input type="hidden" name="EID" value="<?php echo $EID; ?>">
									<input type="submit" value="<?php echo $BUTTON_Edit; ?>" title="<?php echo $STATBAR_EditAddress; ?>" onMouseOver="return StatEdit ();" onMouseOut="return StatBlank();">
								</form>
							</td>
							<td nowrap>
								<form action="addressbook.php" method="post"" target="List">
									<input type="hidden" name="action" value="del">
									<input type="hidden" name="EID" value="<?php $EID; ?>">
									<input type="submit" value="<?php echo $BUTTON_Delete; ?>" title="<?php echo $STATBAR_DeleteAddress; ?>" onMouseOver="return StatRemove ();" onMouseOut="return StatBlank();">
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr><?php
		} ?>
		<tr>
			<th width="100%" colspan="3" align="right"><?php echo $MISC_Entries . ":"; ?></th>
			<th align="left"><?php echo $Rows;?></th>
		</tr>
	</table>
	<form action="addressbook.php" method="post" target="List">
		<input type="hidden" name="action" value="edt">
		<input type="submit" value="<?php echo $BUTTON_ContactAdd; ?>" title="<?php echo $STATBAR_AddAddress; ?>" onMouseOver="return StatAdd ();" onMouseOut="return StatBlank();">
	</form><?php
	}?>
	</body>
	</html><?php
} else {?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML><HEAD><TITLE><?php echo $ERROR_SessionErr; ?></TITLE><link href="<?php echo "themes/" . $Theme;?>/main.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" title="The main style sheet"></HEAD>
	<BODY><H1><?php echo $ERROR_SessionErr; ?></H1><p><?php echo $ERROR_NoSession; ?></p></BODY></HTML><?php
} ?>