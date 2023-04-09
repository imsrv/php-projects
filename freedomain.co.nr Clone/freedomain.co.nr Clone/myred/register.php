<?php
#### Name of this file: register.php 
#### Does all the register stuff - from checking availibility to writing into the database and sending mails

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// If no "do" is specified, go to the main page of this script
if (!$do) {
	$do = "main";
	}
###########################################################
#### The activation part - check code against database                              ####
###########################################################

if ($do == 'activate') {
$domainname = $_GET["domainname"];
$code = $_GET["code"];
// check, if activation code and hostname match
mysql_query("UPDATE $redir_table SET active='on' WHERE host='$domainname' AND acticode='$code'");
if(mysql_affected_rows() != 1) {
	$outputmsg = "$text_75";
	}
else {
	$outputmsg = "$text_76";
	}
// Print out the template
$text_74 = "$text_74 $domainname";
$template = new MyredTemplate("html/$theme/activate.html");
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
$template->assign("text_74", $text_74);
$template->assign("outputmsg", $outputmsg);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;

}
##########################################
####  Check, if the domain name fullfills all needs ####
##########################################
if ($do == 'check') {
$domainname = $_POST["domainname"];	
$domainname = strtolower($domainname);
$outputmsg = check_domain($domainname);

// If checkdomain gives something back, we have an error and go to the main register site showing the error
	if ($outputmsg) {
		$do = "main";
	}

// Check, if domain name is already taken
// Only do so, when the checks before go ok. So, if $outputmsg is empty, we can check the available domains
	else {
	$tld_query = mysql_query("SELECT * FROM $domain_table ORDER BY domain ASC");
	$outputmsg = $text_16;
	while ($tlds = mysql_fetch_array($tld_query)) {	
		$checkname = "$domainname.$tlds[0]";
		$checkdom=mysql_num_rows(mysql_query("select * from $redir_table where host='$checkname'"));
		if($checkdom!="0") {
			$outputmsg.="www.$checkname $text_21 [<a href=\"whois.php?do=check&domainname=$checkname\">$text_7</a>]<br><br>";
		}
		else {
			$outputmsg.="<a href=\"register.php?do=register2&domainname=$domainname&ext=$tlds[0]\"><b>www.$checkname</b></a> $text_22  <a href=\"register.php?do=register2&domainname=$domainname&ext=$tlds[0]\">$text_23</a><br><br>";
		}
		$do ="main";
	}
	}
}

###########################################################
#### Now, let's do the last check                                                ####
###########################################################

if ($do == 'register4') {
// Check again - just for security - the last time.
// I know, that the code gets big, but it's more readable I think.
$domainname = $_GET["domainname"];
$ext = $_GET["ext"];
$domainname = strtolower($domainname);

// If checkdomain gives something back, we have an error and go to the main register site showing the error
$outputmsg = check_domain($domainname);

// And again - check for availibility. Also check the Extension. Someone could try to give a fake url for registering one domain twice.
$outputmsg = check_domain2($domainname, $ext);

// If check_domain or check_domain2 give something back, we have an error and go to the main register site showing the error
// Should I write that he's a bloody bastard? ;-)
if ($outputmsg) {
	$do = "main";
}
// Seems, as if the user didn't try to hack the scripts the easy way, so let's go on checking if he manipultes the <hidden> fields
else {
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$targeturl = $_POST["targeturl"];

if(!$fname || strlen($fname) > 25) {
	$error1 = "$text_37";
	}
if(!$lname || strlen($name) > 25) {
	$error2 = "$text_38";
	}
if(!$email || !verify_email($email) || strlen($email) > 100) {
	$error3 = "$text_39";
	}
$metatags = spider($targeturl);
if(!$metatags) {
	$error4 = "$text_40";
	}
$forbiddenstatus = check_forbidden($targeturl);
if($forbiddenstatus == 1) {
	$error4 = "$text_216";
	}

// If any error occured --> send user back and show him what he did wrong
	if ($error1 || $error2 || $error3 || $error4) {
		$do = "register2";
		}
// Else continue with registration
	else {
// Check the last formfields he filled in
$targettitle = $_POST["targettitle"];
$category = $_POST["category"];
$targetrobot = $_POST["targetrobot"];
$targetrevisit = $_POST["targetrevisit"];
$targetdescription = $_POST["targetdescription"];
$targetkeywords = $_POST["targetkeywords"];
$terms = $_POST["terms"];
if(!$targettitle || strlen($targettitle) > 100) {
	$error11 = "$text_56";
	}
if(!$category) {
	$error12 = "$text_57";
	}
if($terms!="on") {
	$error13 = "$text_58";
	}
// If any error occured --> send user back and show him what he did wrong
	if ($error11 || $error12 || $error13) {
		$do = "register3";
		}
	else {
// Take everything and write it into the database
// Generate a random password
	$password = randomstring(12);
	$encr_password = md5($password);
// Generate a random activation code
	srand ((double)microtime()*1000000);
	$activationcode = rand(1000, 9999);
	$date = time();
	$ip = getenv("REMOTE_ADDR");
// add slashes to prevent from destroying the database - is this necessary? don't know...
$lname = addslashes($lname);
$fname = addslashes($fname);
$email = addslashes($email);
$targeturl = addslashes($targeturl);
$targettitle = addslashes($targettitle);
$targetdescription = addslashes($targetdescription);
$targetkeywords = addslashes($targetkeywords);
$targetrobot = addslashes($targetrobot);
$targetrevisit = addslashes($targetrevisit);
$category = addslashes($category);
$date = time();

	mysql_query("INSERT INTO $redir_table (host, name, vname, passwd, email, url, title, descr, keyw, counter, robots, news, revisit, time, ip, cat, lasttime, stats, mail, adtype, acticode, active) VALUES ('$domainname.$ext', '$lname', '$fname', '$encr_password', '$email', '$targeturl', '$targettitle', '$targetdescription', '$targetkeywords', '0', '$targetrobot', 'on', '$targetrevisit', '$date', '$ip','$category','$date', 'off', 'off', 'on', '$activationcode', 'off')") or die (mysql_error()); 

// What to do now? If Admin has set "autoapprove" to on, we send an email to the new user containing his domain name, password, activation code and instructions
$lname = stripslashes($lname);
$fname = stripslashes($fname);
$password = stripslashes($password);
$email = stripslashes($email);
$targeturl = stripslashes($targeturl);
	if($autoappr == "on") {
	$message = "$text_61 $domainname.$ext\n$text_62 $password\n\n$text_59$domainname.$ext&code=$activationcode$text_59a";
	mail($email,$text_60,$message,"From: $adminmail\nReply-To: $adminmail");
// Also send a mail to the admin if mailtoadmin is set to "on"
	if ($mailtoadmin == "on") {
	$message = "$text_66 $domainname.$ext\n$text_67 $fname $lname\n$text_68 $email\n$text_69 $ip\n$text_70 $targeturl";
	mail($adminmail,$text_65,$message,"From: $adminmail\nReply-To: $adminmail");
		}
	$outputmsg = "$text_64";
 		}
// If autoapprove is set to "off", send user an email telling him, that account has to be checked by admin.
	else {
	$message = "$text_61 $domainname.$ext\n$text_62 $password\n\n$text_71";
	mail($email,$text_60,$message,"From: $adminmail\nReply-To: $adminmail");
// Also send a mail to the admin if mailtoadmin is set to "on"
	if ($mailtoadmin == "on") {
	$message = "$text_66 $domainname.$ext\n$text_67 $fname $lname\n$text_68 $email\n$text_69 $ip\n$text_70 $targeturl$text_72";
	mail($adminmail,$text_65,$message,"From: $adminmail\nReply-To: $adminmail");
		}
	$outputmsg = "$text_73";
		}
// Print out the template
$text_33 = "$text_33 $domainname.$ext";
$template = new MyredTemplate("html/$theme/register4.html");
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
$template->assign("text_33", $text_33);
$template->assign("text_63", $text_63);
$template->assign("outputmsg", $outputmsg);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
	}
	}
}

###########################################################
#### Now, let's check the personal data and target url                   ####
###########################################################

if ($do == 'register3') {
// Check again - just for security
$domainname = $_GET["domainname"];
$ext = $_GET["ext"];
$domainname = strtolower($domainname);

// If checkdomain gives something back, we have an error and go to the main register site showing the error
$outputmsg = check_domain($domainname);

// And again - check for availibility. Also check the Extension. Someone could try to give a fake url for registering one domain twice.
$outputmsg = check_domain2($domainname, $ext);

// If check_domain or check_domain2 give something back, we have an error and go to the main register site showing the error
if ($outputmsg) {
	$do = "main";
}
// Seems, as if the user didn't try to hack the scripts, so let's go on checking what he filled into the form
else {
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$targeturl = $_POST["targeturl"];

if(!$fname || strlen($fname) > 25) {
	$error1 = "$text_37";
	}
if(!$lname || strlen($name) > 25) {
	$error2 = "$text_38";
	}
if(!$email || !verify_email($email) || strlen($email) > 100) {
	$error3 = "$text_39";
	}
if($multiple == "off") {
	if(mysql_num_rows(mysql_query("SELECT * from $redir_table WHERE email='$email'")) > 0) {
		$error3 = "$text_77";
		}
	}
$metatags = spider($targeturl);
if(!$metatags) {
	$error4 = "$text_40";
	}
$forbiddenstatus = check_forbidden($targeturl);
if($forbiddenstatus == 1) {
	$error4 = "$text_216";
	}

// If any error occured --> send user back and show him what he did wrong
	if ($error1 || $error2 || $error3 || $error4) {
		$do = "register2";
		}
// Else continue with registration
	else {
// list of categories
$cat_query = mysql_query("SELECT * FROM $category_table ORDER BY category ASC");
while ($cats = mysql_fetch_array($cat_query)) {
	$cats[0] = stripslashes($cats[0]);
	$categories .= "<option>$cats[0]</option>";
	}
if(!$targettitle) {
	$targettitle = $metatags[0];
	}
if(!$targetdescription) {
	$targetdescription = $metatags[1];
	}
if(!$targetkeywords) {
	$targetkeywords = $metatags[2];
	}
$targetrevisit = $metatags[3];
if (!$targetrevisit) {
	$targetrevisit = "10 days";
	}
$text_33 = "$text_33 $domainname.$ext";
$template = new MyredTemplate("html/$theme/register3.html");
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
$template->assign("text_33", $text_33);
$template->assign("text_35", $text_35);
$template->assign("text_41", $text_41);
$template->assign("text_42", $text_42);
$template->assign("text_43", $text_43);
$template->assign("text_45", $text_45);
$template->assign("text_44", $text_44);
$template->assign("text_46", $text_46);
$template->assign("text_47", $text_47);
$template->assign("text_48", $text_48);
$template->assign("text_49", $text_49);
$template->assign("text_50", $text_50);
$template->assign("text_51", $text_51);
$template->assign("text_52", $text_52);
$template->assign("text_53", $text_53);
$template->assign("text_54", $text_54);
$template->assign("text_55", $text_55);
$template->assign("error11", $error11);
$template->assign("error12", $error12);
$template->assign("error13", $error13);
$template->assign("categories", $categories);
$template->assign("domainname", $domainname);
$template->assign("targettitle", $targettitle);
$template->assign("targetdescription", $targetdescription);
$template->assign("targetkeywords", $targetkeywords);
$template->assign("targetrevisit", $targetrevisit);
$template->assign("targetrobot", $targetrobot);
$template->assign("category", $category);
$template->assign("fname", $fname);
$template->assign("lname", $lname);
$template->assign("email", $email);
$template->assign("targeturl", $targeturl);
$template->assign("ext", $ext);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
		}
	}
}

###########################################################
#### Every check has been successful, so lets go and register the name ####
###########################################################

if ($do == 'register2') {
// Check again - just for security
$domainname = $_GET["domainname"];
$ext = $_GET["ext"];
$domainname = strtolower($domainname);

// If checkdomain gives something back, we have an error and go to the main register site showing the error
$outputmsg = check_domain($domainname);
// And again - check for availibility. Also check the Extension. Someone could try to give a fake url for registering one domain twice.
$outputmsg = check_domain2($domainname, $ext);

// If check_domain or check_domain2 give something back, we have an error and go to the main register site showing the error
	if ($outputmsg) {
		$do = "main";
	}
// Else, no errors have occured, and we may continue registering. Let's start with the personal data and target url.
else {
$text_33 = "$text_33 $domainname.$ext";
$template = new MyredTemplate("html/$theme/register2.html");
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
$template->assign("text_25", $text_25);
$template->assign("text_26", $text_26);
$template->assign("text_27", $text_27);
$template->assign("text_28", $text_28);
$template->assign("text_29", $text_29);
$template->assign("text_30", $text_30);
$template->assign("text_31", $text_31);
$template->assign("text_32", $text_32);
$template->assign("text_33", $text_33);
$template->assign("text_34", $text_34);
$template->assign("text_35", $text_35);
$template->assign("text_36", $text_36);
$template->assign("text_42", $text_42);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("domainname", $domainname);
$template->assign("fname", $fname);
$template->assign("lname", $lname);
$template->assign("email", $email);
$template->assign("targeturl", $targeturl);
$template->assign("ext", $ext);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}

#####################################
#### The main screen with the check form ####
#####################################
if ($do == 'main') {
$template = new MyredTemplate("html/$theme/register1.html");
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
$template->assign("text_13", $text_13);
$template->assign("text_14", $text_14);
$template->assign("text_15", $text_15);
$template->assign("domainname", $domainname);
$template->assign("outputmsg", $outputmsg);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>