<?php
#### Name of this file: contact.php 
#### Mailform for contacting the site admin.

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// If no "do" is specified, go to the main page
if (!$do) {
	$do = "main";
	}

###############################
#### The mail sending              ####
###############################
if ($do == 'dosendmail') {
// get all variables
$sendermail = $_POST["sendermail"];
$message = $_POST["message"];
$message = stripslashes($message);

if (verify_email($sendermail) == "0") {
	$error1 = "$text_39";
	}
if (!$message) {
	$error2 = "$text_160";
	}
if ($error1 || $error2) {
	$do = "main";
	}
else {
// Send the mail
$subject = "$text_165 $pagetitle";
mail($adminmail,$subject,$message,"From: $sendermail\nReply-To: $sendermail");

// Show a successpage
$template = new MyredTemplate("html/$theme/contact2.html");
$template->assign("text_1", $text_1);
$template->assign("text_2", $text_2);
$template->assign("text_3", $text_3);
$template->assign("text_4", $text_4);
$template->assign("text_5", $text_5);
$template->assign("text_6", $text_6);
$template->assign("text_7", $text_7);
$template->assign("text_8", $text_8);
$template->assign("text_9", $text_9);
$template->assign("text_10", $text_10);
$template->assign("text_11", $text_11);
$template->assign("text_12", $text_12);
$template->assign("text_163", $text_163);
$template->assign("text_164", $text_164);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
}

###########################
#### The contact form        ####
###########################
if ($do == 'main') {
$template = new MyredTemplate("html/$theme/contact1.html");
$template->assign("text_1", $text_1);
$template->assign("text_2", $text_2);
$template->assign("text_3", $text_3);
$template->assign("text_4", $text_4);
$template->assign("text_5", $text_5);
$template->assign("text_6", $text_6);
$template->assign("text_7", $text_7);
$template->assign("text_8", $text_8);
$template->assign("text_9", $text_9);
$template->assign("text_10", $text_10);
$template->assign("text_11", $text_11);
$template->assign("text_12", $text_12);
$template->assign("text_35", $text_35);
$template->assign("text_157", $text_157);
$template->assign("text_158", $text_158);
$template->assign("text_159", $text_159);
$template->assign("text_163", $text_163);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("sendermail", $sendermail);
$template->assign("message", $message);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>