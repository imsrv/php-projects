<?
/***************************************************************************
 *                                   en.php
 *                            -------------------
 *   begin                : Tuesday', Aug 15', 2002
 *   copyright            : ('C) 2002 Bugada Andrea
 *   email                : phpATM@free.fr
 *
 *   $Id: en.php, v1.10 2002/08/28 23:53:50 bugada Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License', or
 *   ('at your option) any later version.
 *
 ***************************************************************************/

$headerpage="include/header.htm";    // The optional header file (can absent)
$footerpage="include/footer.htm";    // The footer file (must present!)
$infopage="include/info.htm";        // The optional info file (can absent)

$charsetencoding="";                 // The encoding for national symbols (i.e. for cyryllic  must be "windows-1251")
$uploadcentercaption="PHP Advanced Transfer Manager";
$uploadcentermessage="phpATM";

$mess=array(
"0" => "",
"1" => "January",
"2" => "February",
"3" => "March",
"4" => "April",
"5" => "May",
"6" => "June",
"7" => "July",
"8" => "August",
"9" => "September",
"10" => "October",
"11" => "November",
"12" => "December",
"13" => "Today",
"14" => "Yesterday",
"15" => "Filename",
"16" => "Rating",
"17" => "Size",
"18" => "Uploaded",
"19" => "Owner",
"20" => "Upload File",
"21" => "Local File",
"22" => "File Description",
"23" => "Download",
"24" => "Order",
"25" => "Home",
"26" => "File",
"27" => "Print",
"28" => "Close",
"29" => "Go back",
"30" => "This file has been removed",
"31" => "Unable to open file",
"32" => "Go back",
"33" => "Error uploading file !",
"34" => "You must select a file",
"35" => "Back",
"36" => "The file",
"37" => "has successfully been uploaded",
"38" => "File with name",
"39" => "already exists",
"40" => "The file has successfully been uploaded",
"41" => "Language has succesfully choosen",
"42" => "Welcome to PHP Advanced Transfer Manager",
"43" => "Total Space Used",
"44" => "Show files for all days",
"45" => "Invalid ZIP archive!",
"46" => "Archive contents:",
"47" => "Date/Time",
"48" => "Directory",
"49" => "It is prohibited to upload file with name %s!",
"50" => "exceeds maximum allowed size",
"51" => "Information",
"52" => "Select Skin",
"53" => "Skin",
"54" => "Welcome",
"55" => "Current time",
"56" => "User",
"57" => "Username",
"58" => "Register",
"59" => "Registration",
"60" => "Sunday",
"61" => "Monday",
"62" => "Tuesday",
"63" => "Wednesday",
"64" => "Thursday",
"65" => "Fiday",
"66" => "Saturday",
"67" => "Send",
"68" => "Mail file",
"69" => "File has been mailed to %s address.",
"70" => "File uploaded by user: %s",
"71" => "Login",
"72" => "Logout",
"73" => "Enter",
"74" => "Anonymous",
"75" => "Normal User",
"76" => "Power User",
"77" => "Administrator",
"78" => "Private zone",
"79" => "Public zone",
"80" => "You entered invalid account name or password.",
"81" => "My profile",
"82" => "View/edit my profile",
"83" => "Password",
"84" => "Select language",
"85" => "Select timezone",
"86" => "Your current time",
"88" => "Please, enter valid e-mail address.",
"89" => "Be sure that your e-mail address active, because your personal activation code will be sent to your e-mail.",
"90" => "File uploaded: ",
"91" => "Please, enter your e-mail address, that you typed during registration.",
"92" => "File size: ",
"93" => "Please, write down your name and password",
"94" => "Registration is necessary. Please, register.",
"95" => "Registration is not necessary. You can register if you wish add your name to all your uploaded files. Nobody other can use your name to upload their files.",

"96" => "Skin selected.",
"97" => "Refresh",
"98" => "Please, enter your login name and password",
"99" => "Still not registered? - Register here!",
"100" => "Forgotten your password?",
"101" => "Please, go %s back %s and try again.",
"102" => "You succesfully logged out.",
"103" => "User name is invalid. The name must be not longer than 12 symbols and can consists of latin symbols and digits only. Name can also contain '-', '_', and space symbols inside.",
"104" => "The '%s' you picked has been taken.",
"105" => "Confirm password",
"106" => "Passwords do not match.",
"107" => "The format of entered e-mail address is invalid.",
"108" => "Thank you for registering. Please do not forget your password as it has been encrypted in our database and we cannot retrieve it for you. However, should you forget your password we provide an easy to use script to generate and email a new, random, password.",
"109" => "You can %s enter to Upload Center here. %s",
"110" => "Your activation code has been e-mailed to you. You must activate your account within 2 days or account will be automatically removed.",
"111" => "you don't have permission to download this file",
"112" => "Activate account",
"113" => "Please, activate your account",
"114" => "Activation code",
"115" => "Your account now is active.",
"116" => "Please %s enter here %s.",
"117" => "The entered account name or activation code is invalid.",
"118" => "Account already active.",
"119" => "I wish to receive to my e-mail everyday digest of uploaded files.",
"120" => "Change your password.",
"121" => "Your old password",
"122" => "The entered account name does not exists.",
"123" => "The entered e-mail address is not valid.",
"124" => "Your new password has been sent to your e-mail.",
"125" => "can not execute, object not found",
"126" => "Customize your account settings",
"127" => "Apply",
"128" => "Your profile saved.",
"129" => "Your password changed.",
"130" => "You typed invalid previous password.",
"131" => "You must specify your new password.",
"132" => "Configuration",
"133" => "Upload",
"134" => "Language & timezone",
"135" => "Account statistics",
"136" => "Your account has been created:",
"137" => "User management",
"138" => "Viewer (view only)",
"139" => "Uploader (upload only)",
"140" => "Account '%s' changed successfully",
"141" => "Latest",
"142" => "All",
"143" => "New e-mail address takes effect after confirmation. Confirmation code has been e-mailed to your new mail address. See instructions inside the letter.",
"144" => "",
"145" => "Please, confirm your new e-mail address.",
"146" => "Confirmation code",
"147" => "Confirm",
"148" => "Nothing to confirm.",
"149" => "The entered account name or confirmation code is invalid.",
"150" => "Your new e-mail address '%s' confirmed.",
"151" => "Files uploaded",
"152" => "Files downloaded",
"153" => "Files e-mailed",
"154" => "Account created",
"155" => "Last access time",
"156" => "Status",
"157" => "Active status",
"158" => "Receive digest",
"159" => "e-mail",
"160" => "Total:",
"161" => "account(s)",
"162" => "Delete account",
"163" => "Shown %s account(s) of %s",
"164" => "Configure Upload Center",
"165" => "Edit files",
"166" => "Edit file",
"167" => "File %s has been changed succesfully",
"168" => "Save",
"169" => "Delete",
"170" => "Delete files",
"171" => "Mirror",
"172" => "Yes",
"173" => "No",
"174" => "Active",
"175" => "Inactive",
"176" => "Unautorized",
"177" => "Sorry, but server could not execute the mail program.",
"178" => "Your registration failed. Please, try again later.",
"179" => "Please, try again later.",
"180" => "file succesfully deleted",
"181" => "you don't have permission to delete this file",
"182" => "directory succesfully deleted",
"183" => "you don't have permission to delete this directory",
"184" => "directory succesfully created",
"185" => "you don't have permission to create a directory",
"186" => "Create new directory",
"187" => "Directory name",
"188" => "Make dir",
"189" => "directory already exists, please choose another name",
"190" => "you must specify a directory name",
"191" => "Modify",
"192" => "Filename",
"193" => "Modify file / directory details",
"194" => "object renamed successfully.",
"195" => "you don't have permission to rename that object",
"196" => "The root path is not correct. Check the settings",
"197" => "Order by",
"198" => "rename failed, file already exists",
"199" => "Last uploads",
"200" => "Top downloads",
"201" => "rename failed, name not allowed",

//
// New strings introduced in version 1.02
//
"202" => "The url you provided is not valid",
"203" => "File http address",
"204" => "Upload file by http address",

//
// New strings introduced in version 1.10
//
"205" => "Always stay logged",
"206" => "Can't execute: name not allowed",
"207" => "IP address blocked",
"208" => "Your IP address has been blocked by Administration!",
"209" => "To obtain more infos contact the Administrator"
);

//
// Send file e-mail configuration
//
$sendfile_email_subject = 'Requested file';
$sendfile_email_body = '
Here the file you requested by mail

';
$sendfile_email_end = 'Regards,';

//
// Digest e-mail configuration
//
$digest_email_subject = "Everyday digest";

//
// Confirm new e-mail configuration
//
$confirm_email_subject = 'Confirm new e-mail';
$confirm_email_body = 'Dear %s,

Because your security is importance to us, your new e-mail address will need to be confirmed upon receipt.

Your personal confirmation code is: %s

Activating e-mail address is simple:
1. Visit us at %s and we will guide you through the process
2. Enter your account name and confirmation code.
3. Click on the \'Confirm\' button.

';
$confirm_email_end = 'Regards,';

//
// Send password e-mail configuration
//
$chpass_email_subject = 'New password';
$chpass_email_body = 'Dear user,

Your new password is %s

';
$chpass_email_end = 'Regards,';

//
// Confirm registration e-mail configuration
//
$register_email_subject = 'Confirm registration';
$register_email_body = 'Dear %s,

Thank You for registration.

Because your security is importance to us, your account will need to be activated upon receipt.

Your personal activation code is: %s
(please note: this is not your password)

Activating Your account is simple:
1. Visit us at %s and we will guide you through the process
2. Enter your account name and activation code.
3. Click on the \'Activate account\' button.

';
$register_email_end = 'Regards,';
?>
