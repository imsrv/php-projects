<?php
#### Name of this file: password.php 
#### Sends the user's password to his email address in case he forgot it

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

#####################################
#### Go check input and send password    ####
#####################################
if ($do == 'send') {
$passdomain = $_POST["passdomain"];
// Check the input for correctness
if(!$passdomain) {
	$error1 = "$text_105";
	$do = "main";
	}
else {
// Look, wether domain name exists
$query = mysql_query("SELECT * FROM $redir_table WHERE host='$passdomain'");
	$num_rows = mysql_num_rows($query);
// if no result is found, send user back - the result has to be "1 result found"
    	if ($num_rows != 1) {
		$error1 = "$text_106";
		$do = "main";
		}
	else {
	$query=mysql_fetch_array($query);
// Because of the md5() hash used, we must generate a random new password which we send to the user
	$password = randomstring(12);
	$encr_password = md5($password);
// Insert this new encrypted password into the table
	mysql_query("UPDATE $redir_table SET passwd='$encr_password' WHERE host='$passdomain'") or die ("mysql_error");
// Get the users email address
	$email = $query[email];
// Send the mail
	$subject = "$text_107 $passdomain";
	$body = "$text_108 $passdomain\n$text_109 $password";
	mail($email,$subject,$body,"From: $adminmail\nReply-To: $adminmail");
// Show success screen
$template = new MyredTemplate("html/$theme/password2.html");
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
$template->assign("text_110", $text_110);
$template->assign("text_111", $text_111);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
		}
	}
}

#########################
#### The main screen     ####
#########################
if ($do == 'main') {
$template = new MyredTemplate("html/$theme/password1.html");
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
$template->assign("text_80", $text_80);
$template->assign("text_102", $text_102);
$template->assign("text_103", $text_103);
$template->assign("text_104", $text_104);
$template->assign("error1", $error1);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>
