<?
// ************************************************************
// * Cedric email reader, lecture des emails d'une boite IMAP.*
// * Function library for IMAP email reading.                 *
// * Realisation : Cedric AUGUSTIN <cedric@isoca.com>         *
// * Web : www.isoca.com                                      *
// * Version : 0.4                                            *
// * Date : Septembre 2001                                    *
// ************************************************************

// This job is licenced under GPL Licence.


/*
This page is included on each page
-> uncode the login string including the server name, user name, the password and the path to the ini file.
-> include the ini file with the current user setting or default setting.
-> include library file with email function.
-> include the translation page according to the user lang (cer_skin).
*/

$param = imap_base64($login);
parse_str($param);

@include($emailreader_ini);
@include('lib/'.$server_type.'.inc.php');
@include('skin/emailreaderskin_'.$lang.'.php');


/*
if(include($emailreader_ini) && include('lib/'.$server_type.'.inc.php') && include('skin/emailreaderskin_'.$lang.'.php')){
    // everything ok
} else {
    header("Location: emailreadererror.php?pagename=$SCRIPT_NAME&error_message=$php_errormsg");
    exit;
};
*/
?>