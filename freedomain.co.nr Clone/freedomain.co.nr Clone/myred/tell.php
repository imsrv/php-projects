<?php
#### Name of this file: tell.php 
#### A simple "tell a friend" script

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
if ($do == 'tell') {
// get all variables
$sendername = $_POST["sendername"];
$sendermail = $_POST["sendermail"];
$friendname = $_POST["friendname"];
$friendmail = $_POST["friendmail"];

if (verify_email($sendermail) == "0") {
	$error2 = "$text_39";
	}
if (verify_email($friendmail) == "0") {
	$error4 = "$text_39";
	}
if (!$sendername) {
	$error1 = "$text_187";
	}
if (!$friendname) {
	$error3 = "$text_187";
	}
if ($error1 || $error2 || $error4 || $error4) {
	$do = "main";
	}
else {
// Send the mail
$subject = "$text_190 $friendname";
$body = "$text_176 $friendname,\n\n$text_178 http://www.$maindomain\n$text_179\n\n$text_180\n$sendername";
mail($friendmail,$subject,$body,"From: $sendermail\nReply-To: $sendermail");

// Show a thanks page
$template = new MyredTemplate("html/$theme/tell2.html");
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
$template->assign("text_188", $text_188);
$template->assign("text_189", $text_189);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
}

###########################
#### The tell a friend  form     ####
###########################
if ($do == 'main') {
$template = new MyredTemplate("html/$theme/tell1.html");
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
$template->assign("text_175", $text_175);
$template->assign("text_176", $text_176);
$template->assign("text_177", $text_177);
$template->assign("text_178", $text_178);
$template->assign("text_179", $text_179);
$template->assign("text_180", $text_180);
$template->assign("text_181", $text_181);
$template->assign("text_182", $text_182);
$template->assign("text_183", $text_183);
$template->assign("text_184", $text_184);
$template->assign("text_185", $text_185);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("sendername", $sendername);
$template->assign("sendermail", $sendermail);
$template->assign("friendname", $friendname);
$template->assign("friendmail", $friendmail);
$template->assign("maindomain", $maindomain);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>