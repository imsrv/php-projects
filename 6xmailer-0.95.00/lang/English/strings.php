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

// =======================================================================================
// Language: English
// This language file contains string for the selected language.
// This file may be edited or duplicated and edited to suit the needs of the administrator
// =======================================================================================

// Titles
// -----------------------------------
// The titles used for the mail pages.

$TITLE_Interface = "Mail System Interface";

// Login Prompt Texts
// ----------------------------------------------------------
// These are used to label the login forms and message boxes.

$PROMPT_Username = "Username";
$PROMPT_Password = "Password";
$PROMPT_Server = "POP Server";
$PROMPT_Domain = "Your E-Mail Address";
$PM_EMail = "If your username is your e-mail address, you do not have to enter an e-mail address.";
$PM_Netscape = "If you are using a version of Netscape Navigator before 6, then you will probably not be able to use this mail, please upgrade at <a href=http://www.netscape.com>http://www.netscape.com</a>";

// Buttons
// ---------------------------------------
// These are used to label varius buttons.

$BUTTON_OK = "OK";
$BUTTON_Cancel = "Cancel";
$BUTTON_Login = "Login";
$BUTTON_Clear = "Clear";
$BUTTON_ComposeMessage = "Compose Message";
$BUTTON_CheckMail = "Check Mail";
$BUTTON_AddressBook = "Address Book";
$BUTTON_About = "About";
$BUTTON_Reply = "Reply";
$BUTTON_Forward = "Forward";
$BUTTON_Delete = "Delete";
$BUTTON_Source = "Source";
$BUTTON_Attachments = "Attachments";
$BUTTON_Yes = "Yes";
$BUTTON_No = "No";
$BUTTON_Send = "Send";
$BUTTON_Edit = "Edit";
$BUTTON_ContactAdd = "Add a New Contact";
$BUTTON_Save = "Save";
$BUTTON_SendTo = "Send To";
$BUTTON_Settings = "User Settings";

// Icons
// -------------------------------
// These are labels for the icons.

$ICON_Inbox = "Inbox";
$ICON_Help = "Help";
$ICON_Logout = "Logout";

// Headers
// ---------------------------------------------------------
// These are message, frame, e-mail forms, and list headers.

$HEAD_Folders = "Mailer";
$HEAD_To = "To";
$HEAD_From = "From";
$HEAD_Subject = "Subject";
$HEAD_When = "Received";
$HEAD_Attachment = "Attachment";
$HEAD_Name = "Name";
$HEAD_EMail = "E-Mail";
$HEAD_PhoneNumber = "Phone";
$HEAD_Required = "required";
$HEAD_Actions = "Actions";
$HEAD_DisName = "Display Name";
$HEAD_Signature = "Signature";

// Status Bar
// ------------------------------------------------------------------
// These are text displayed on the browsers status bar when the mouse
// rolls over a button or link

$STATBAR_Reply = "Reply to this message";
$STATBAR_Delete = "Delete this message";
$STATBAR_Forward = "Forward this message to someone";
$STATBAR_Source = "View the source data of this message";
$STATBAR_Attachments = "List this messages attachments";
$STATBAR_ComposeMessage = "Send a new message";
$STATBAR_CheckMail = "Refresh the inbox to show new mail";
$STATBAR_AddressBook = "Display the addresss book";
$STATBAR_About = "Display information about this version of 6XMailer";
$STATBAR_SendTo = "Send an e-mail to this person";
$STATBAR_AddAddress = "Add a new person";
$STATBAR_EditAddress = "Edit this persons information";
$STATBAR_DeleteAddress = "Delete this person";
$STATBAR_Send = "Send this message";
$STATBAR_Settings = "Change your settings";

// Error Message
// --------------------------------------------------------------
// These are error messages displayed in case of a malfunction of
// user mistake.
$ERROR_AtLogin = "Login Error";
$ERROR_NoDom = "You forgot to supply the domain of your e-mail, the part after the @ in the field labled @.";
$ERROR_NoServer = "You forgot to give the hostname of your POP3 server.";
$ERROR_DemoMode = "Sorry but this function has been disabled because this interface is in demo mode.";
$ERROR_LoginList = "The following error occured while trying to log on to the pop server:";
$ERROR_NoDomain = "The POPHostname varible has been set, but the POPDomain varible is empty.";
$ERROR_NoSession = "If you received this message, make sure cookies are enabled on your browser.";
$ERROR_SessionErr = "Session Error";
$ERROR_SQLErr = "SQL Error";
$ERROR_AddUser = "Error adding new user.";
$ERROR_SQLConnect = "Could not connect to SQL server.";

// Misc
// -------------------------------
// Other sets of important labels.

$MISC_SideNote = "NOTE";
$MISC_AddressBook = "from Address Book";
$MISC_NoMessage = "No Messages";
$MISC_NoMIME = "This message is cannot be displayed because it does not have the supported MIME formats.";
$MISC_Sent = "Message was sent to the SMTP server...";
$MISC_Deleted = "Message Deleted";
$MISC_AskDelete = "Are you sure you wish to delete this message?";
$MISC_BackToMsg = "Return to your message";
$MISC_DemoWarning = "<b>NOTE:</b> This mailer is in demo mode and will not send any mail, only check mail.  The address book and per-user settings features are also disabled in this mode.";
$MISC_Contact_Add = "Contact Added.";
$MISC_Contact_Updated = "Contact Updated.";
$MISC_Contact_Deleted = "The entry has been delete.";
$MISC_Contact_AskDelete = "Are you sure you want to delete this entry?";
$MISC_Entries = "Number of entries";

?>