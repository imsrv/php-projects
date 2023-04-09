<?php
#### Name of this file: whois.php 
#### Does all the whois queries and outouts the domain holders data. Let's also send mails to the domain holder.

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// If no "do" is specified, go to the login page
if (!$do) {
	$do = "main";
	}

###############################
#### The mail sending              ####
###############################
if ($do == 'dosendmail') {
// get all variables
$domainname = $_GET["domainname"];	
$domainname = strtolower($domainname);
$sendermail = $_POST["sendermail"];
$message = $_POST["message"];
$message = stripslashes($message);
// Check wether domain name exists
$query = mysql_query("SELECT * FROM $redir_table WHERE host='$domainname'") or die (mysql_error());
if (mysql_num_rows($query) != 1) {
	$error0 = "$text_105";
	}
if (verify_email($sendermail) == "0") {
	$error1 = "$text_39";
	}
if (!$message) {
	$error2 = "$text_160";
	}
if ($error0 || $error1 || $error2) {
	$do = "sendmail";
	}
else {
$query = mysql_fetch_array($query);
$targetmail = stripslashes($query[email]);
// And send the mail
$subject = "$text_161 $domainname";
mail($targetmail,$subject,$message,"From: $sendermail\nReply-To: $sendermail");
$outputmsg = "$text_162 <b>$domainname</b>";
$do = "main";
}
}

###############################
#### The screen with the mail form  ####
###############################
if ($do == 'sendmail') {
// Get the domain name
$domainname = $_GET["domainname"];	
$domainname = strtolower($domainname);

// show the mail template
$template = new MyredTemplate("html/$theme/whois3.html");
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
$template->assign("text_156", $text_156);
$template->assign("text_157", $text_157);
$template->assign("text_158", $text_158);
$template->assign("text_159", $text_159);
$template->assign("error0", $error0);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("sendermail", $sendermail);
$template->assign("message", $message);
$template->assign("domainname", $domainname);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

############################
#### The whois check screen  ####
############################
if ($do == 'check') {
// Get the post information
$domainname = $_POST["domainname"];
if (!$domainname) {
	$domainname = $_GET["domainname"];
	}
$domainname = strtolower($domainname);
// Check, if field is empty
if (!$domainname) {
	$outputmsg = "$text_144";
	$do = "main";
	}
// Check, if domain is free - this case is "yes"
elseif (mysql_num_rows(mysql_query("SELECT * FROM $redir_table WHERE host='$domainname'")) < 1) {
	$outputmsg = "<b>$domainname</b> $text_145";
	$do = "main";
	}
// Domain name is reserved, show output
else {
$query = mysql_query("SELECT * FROM $redir_table WHERE host='$domainname'") or die (mysql_error());
while ($summary = mysql_fetch_array($query)) {
$targeturl = stripslashes($summary[url]);
$lname = stripslashes($summary[name]);
$fname = stripslashes($summary[vname]);
$hits = $summary[counter];
$status = $summary[active];
$date=$summary[time];
}
$domainname_u = strtoupper($domainname);
$date = date($dateformat, $date);
if ($status == 'on') {
	$status = "$text_97";
	}
else {
	$status = "$text_98";
	}
// Show whois result
$template = new MyredTemplate("html/$theme/whois2.html");
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
$template->assign("text_141", $text_141);
$template->assign("text_142", $text_142);
$template->assign("text_143", $text_143);
$template->assign("text_146", $text_146);
$template->assign("text_147", $text_147);
$template->assign("text_148", $text_148);
$template->assign("text_149", $text_149);
$template->assign("text_150", $text_150);
$template->assign("text_151", $text_151);
$template->assign("text_152", $text_152);
$template->assign("text_153", $text_153);
$template->assign("text_154", $text_154);
$template->assign("text_155", $text_155);
$template->assign("domainname", $domainname );
$template->assign("domainname_u", $domainname_u);
$template->assign("targeturl", $targeturl );
$template->assign("lname", $lname);
$template->assign("fname", $fname);
$template->assign("hits", $hits);
$template->assign("status", $status);
$template->assign("date", $date);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}

###########################
#### The whois main screen  ####
###########################
if ($do == 'main') {
$template = new MyredTemplate("html/$theme/whois1.html");
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
$template->assign("text_141", $text_141);
$template->assign("text_142", $text_142);
$template->assign("text_143", $text_143);
$template->assign("outputmsg", $outputmsg);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>