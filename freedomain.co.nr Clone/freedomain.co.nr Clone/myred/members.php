<?php
#### Name of this file: members.php 
#### Does all the members stuff - changing passwords, domain data, personal data, stats

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// Get the host and password in case user logs in
$logindomain = $_POST["logindomain"];
$loginpass = $_POST["loginpass"];
if($loginpass) {
	$loginpass = md5($loginpass);
	}

// $hostname ist the variable containing who the user is.
// the following is just needed when user logs in, because otherwise $hostname would be empty at the first attempt to login, and an almost blank page would be the result
if (!$hostname) {
	$hostname = $logindomain;
	}

// Secure area - check for cookies
$myred14 = $_COOKIE["myred14"];

if($myred14) {
// ----- if cookie exists -----
	$authenticated=verify_auth($myred14);
	if($authenticated==0) {
		$do = "login";
		$error1 = "$text_101";
		}
	}
else {
	$login=login_user($logindomain,$loginpass);
	if($login==0) {
		$do = "login";
		if($logindomain || $loginpass) {
			$error1 = "$text_84";
			}
		}
	}
 
// if user has logged in, the script carries on here....
$cookie_var = split(":", $myred14);

// this variable contains who the user is logged in as!
if($cookie_var[0]!="") {
	$hostname = $cookie_var[0];
}

// If no "do" is specified, go to the login page
if (!$do) {
	$do = "main";
	}

#########################
#### The stats section        ####
#########################
if ($do == 'stats') {
// Look, if stats are enabled
$status_stats = mysql_query("SELECT stats FROM $redir_table WHERE host='$hostname'") or die  ("mysql_error");
$status_stats = mysql_fetch_array($status_stats);

// If stats are "off", tell user this status
if ($status_stats[0] == "off" || $status_stats[0] == "") {

$template = new MyredTemplate("html/$theme/stats1.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_199", $text_199);
$template->assign("text_200", $text_200);
$template->assign("hostname", $hostname);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
// else stats are on, lets continue...

// Lets see, if there are any stats...
$stats_check = mysql_query("SELECT * FROM $visitor_table WHERE host='$hostname'");
// if there are no stats, tell user this
if (mysql_num_rows($stats_check) ==0) {
$text_200 = $text_405;
$template = new MyredTemplate("html/$theme/stats1.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_199", $text_199);
$template->assign("text_200", $text_200);
$template->assign("hostname", $hostname);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
else {
// Get total hits out of $redir_table
$hits = mysql_query("SELECT counter FROM $redir_table WHERE host='$hostname'") or die  ("mysql_error");
$hits = mysql_fetch_array($hits);

// Get the average daily hits for the last seven days...
$sql = "SELECT count(*) as cnt, DAYNAME(date) as dnr, TO_DAYS(date) as tdr FROM $visitor_table WHERE host='$hostname' AND date >= DATE_SUB( CURRENT_DATE, INTERVAL 6 day ) GROUP BY dnr,tdr ORDER BY tdr DESC LIMIT 0,6"; 
$result = mysql_query($sql);
$i = 0;
while ($row = mysql_fetch_array($result)) {
	$weekday[$i] = replace_dayname($row[dnr]);
	$count[$i] = $row[cnt];
	if ($count[$i] == "") {
		$count[$i] = 0;
		}
	$weekdays .="$weekday[$i]<br>";
	$weekdayhits .= "$count[$i]<br>";
}

// The operating systems stats
$sql = "SELECT * FROM $visitor_table WHERE host='$hostname'"; 
$overall = mysql_num_rows(mysql_query ($sql)); 

$sql = "SELECT count(agent) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%win%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$win = $row["cnt"];
} 

$sql = "SELECT count(agent) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%mac%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$mac = $row["cnt"];
} 

$sql = "SELECT count(agent) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%linux%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$linux = $row["cnt"];
} 

$sql = "SELECT count(agent) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%unix%' OR agent 
LIKE '%SunOS%' OR agent LIKE '%FreeBSD%' OR 
agent LIKE '%IRIX%' OR agent LIKE '%HP-UX%' OR agent LIKE '%OSF%' OR 
agent LIKE '%AIX%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$unix = $row["cnt"];
} 

$sql = "SELECT count(agent) as cnt FROM $visitor_table WHERE host='$hostname' AND (agent LIKE '%spider%' OR 
agent LIKE '%bot%') AND agent NOT LIKE '%MSIE%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$craw = $row["cnt"];
} 
$total = ($win + $mac + $linux + $unix + $craw); 
$other = ($overall - $total); 
$winper = percentcalc($win, $overall);
$macper = percentcalc($mac, $overall);
$linuxper = percentcalc($linux, $overall);
$unixper = percentcalc($unix, $overall);
$crawper = percentcalc($craw, $overall);
$otherper = percentcalc($other, $overall);
// Just for proof of correctness :-)
$overallper = percentcalc($overall, $overall);


// The browser stats
$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%MSIE%' AND agent 
NOT LIKE '%Opera%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$ms = $row["cnt"];
} 

$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%Mozilla%' AND agent 
NOT LIKE '%MSIE%' AND agent NOT LIKE '%Opera%' AND agent NOT LIKE '%iCab%' AND agent NOT LIKE '%Konqueror%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$ns = $row["cnt"];
} 

$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%Opera%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$opera = $row["cnt"];
}

$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%iCab%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$icab = $row["cnt"];
} 

$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%Lynx%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$lynx = $row["cnt"];
} 

$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND agent LIKE '%Konqueror%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$konq = $row["cnt"];
} 

$sql = "SELECT count(ip) as cnt FROM $visitor_table WHERE host='$hostname' AND (agent LIKE '%spider%' OR agent 
LIKE '%bot%') AND agent NOT LIKE '%MSIE%'"; 
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$bots = $row["cnt"];
} 

$total = ($ms + $ns + $opera + $icab + $lynx + $konq + $bots); 
$browserother = ($overall - $total);
$msper = percentcalc($ms, $overall);
$nsper = percentcalc($ns, $overall);
$operaper = percentcalc($opera, $overall);
$icabper = percentcalc($icab, $overall);
$lynxper = percentcalc($lynx, $overall);
$konqper = percentcalc($konq, $overall);
$botsper = percentcalc($bots, $overall);
$browserotherper = percentcalc($browserother, $overall);

// The last 20 visitors
$sql = "SELECT ip FROM $visitor_table WHERE host='$hostname' ORDER BY timestamp DESC LIMIT 0, 20";
$result = mysql_query ($sql); 
while ($row = mysql_fetch_array($result)) { 
	$lastvisitors .= "$row[0]<br>";
	}

// The top 20 referer
$sql = "SELECT COUNT(ref) AS CNT,ref FROM $visitor_table WHERE host='$hostname' GROUP BY ref ORDER BY CNT DESC LIMIT 0, 20";
$result = mysql_query($sql) or die (mysql_error()); 
while ($row = mysql_fetch_array($result)) { 
	$refererhits .= "$row[CNT]<br>";
	if ($row[ref] == "none") {
		$referers .= "$text_238<br>";
		}
	else {
		$rest = $row[ref];
		if (strlen($row[ref]) > 35) {
			$rest = substr("$row[ref]", 0, 34);
			$rest .= "...";
			}
		$referers .= "<a href=\"$row[ref]\" target=\"_blank\">$rest</a><br>";
		}
	} 



$template = new MyredTemplate("html/$theme/stats2.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_199", $text_199);
$template->assign("text_201", $text_201);
$template->assign("text_202", $text_202);
$template->assign("text_203", $text_203);
$template->assign("text_204", $text_204);
$template->assign("text_205", $text_205);
$template->assign("text_206", $text_206);
$template->assign("text_207", $text_207);
$template->assign("text_208", $text_208);
$template->assign("text_217", $text_217);
$template->assign("text_218", $text_218);
$template->assign("text_219", $text_219);
$template->assign("text_220", $text_220);
$template->assign("text_221", $text_221);
$template->assign("text_222", $text_222);
$template->assign("text_223", $text_223);
$template->assign("text_224", $text_224);
$template->assign("text_225", $text_225);
$template->assign("text_226", $text_226);
$template->assign("text_227", $text_227);
$template->assign("text_228", $text_228);
$template->assign("text_229", $text_229);
$template->assign("text_230", $text_230);
$template->assign("text_231", $text_231);
$template->assign("text_232", $text_232);
$template->assign("text_233", $text_233);
$template->assign("text_234", $text_234);
$template->assign("text_235", $text_235);
$template->assign("text_236", $text_236);
$template->assign("text_237", $text_237);
$template->assign("hostname", $hostname);
$template->assign("keepstats", $keepstats);
$template->assign("hits", $hits[0]);
$template->assign("weekdays", $weekdays);
$template->assign("weekdayhits", $weekdayhits);
$template->assign("winper", $winper);
$template->assign("macper", $macper);
$template->assign("linuxper", $linuxper);
$template->assign("unixper", $unixper);
$template->assign("crawper", $crawper);
$template->assign("otherper", $otherper);
$template->assign("msper", $msper);
$template->assign("nsper", $nsper);
$template->assign("operaper", $operaper);
$template->assign("icabper", $icabper);
$template->assign("lynxper", $lynxper);
$template->assign("konqper", $konqper);
$template->assign("botsper", $botsper);
$template->assign("browserotherper", $browserotherper);
$template->assign("overallper", $overallper);
$template->assign("weekdayhits", $weekdayhits);
$template->assign("lastvisitors", $lastvisitors);
$template->assign("refererhits", $refererhits);
$template->assign("referers", $referers);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}

###########################################################
#### The logout screen                                                                                    ####
###########################################################
if ($do == 'logout') {
// Delete cookie
 SetCookie("myred14", "$user_id:$encryptedpassword", time()-7200);

// Print template
$template = new MyredTemplate("html/$theme/logout.html");
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
$template->assign("text_95", $text_95);
$template->assign("text_100", $text_100);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

#########################################
#### The options changing                                     ####
#########################################

if ($do == 'dooptions') {
// Check input
$newsletter = $_POST["newsletter"];

if ($newsletter != 'on' && $newsletter != 'off') {
	$error1 = "$text_138";
	$do = "options";
	}
else {
// Write new value of "news" into database
mysql_query("UPDATE $redir_table SET news='$newsletter' WHERE host='$hostname'") or die ("mysql_error");

// Show success template
$template = new MyredTemplate("html/$theme/options2.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_115", $text_115);
$template->assign("text_131", $text_131);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}
#########################################
#### The options screen                                          ####
#########################################

if ($do == 'options') {
//Get the current newsletter status
$newsstatus= mysql_fetch_array(mysql_query("SELECT news FROM $redir_table WHERE host='$hostname'")) or die (mysql_error());


// Show the options template
$template = new MyredTemplate("html/$theme/options1.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_35", $text_35);
$template->assign("text_42", $text_42);
$template->assign("text_114", $text_114);
$template->assign("text_131", $text_131);
$template->assign("text_135", $text_135);
$template->assign("text_136", $text_136);
$template->assign("text_137", $text_137);
$template->assign("text_139", $text_139);
$template->assign("text_140", $text_140);
$template->assign("newsstatus", $newsstatus[0]);
$template->assign("error1", $error1);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

#########################################
#### The domain deletion screen                          ####
#########################################

if ($do == 'delete') {
// Show deletion screen with warning
$template = new MyredTemplate("html/$theme/delete1.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_125", $text_125);
$template->assign("text_126", $text_126);
$template->assign("text_127", $text_127);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

#########################################
#### The domain deletion itself                             ####
#########################################

if ($do == 'dodelete') {
//do the deletion of the domain data
mysql_query("DELETE FROM $redir_table WHERE host='$hostname'") or die (mysql_error());
// the deletion of the stats
mysql_query("DELETE FROM $visitor_table WHERE host='$hostname'") or die (mysql_error());

// Log user off
 SetCookie("myred14", "$user_id:$encryptedpassword", time()-7200);

// Show a success template
$template = new MyredTemplate("html/$theme/delete2.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_125", $text_125);
$template->assign("text_128", $text_128);
$template->assign("text_129", $text_129);
$template->assign("text_130", $text_130);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

#########################################
#### Change personal data                                     ####
#########################################

if ($do == 'changepersonal') {
// Get all post variables and check for correctness
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$passwd1 = $_POST["passwd1"];
$passwd2 = $_POST["passwd2"];

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
	if(mysql_num_rows(mysql_query("SELECT * from $redir_table WHERE email='$email' AND host NOT LIKE '$hostname'")) > 0) {
		$error3 = "$text_77";
		}
	}
if ($passwd1) {
	if(ereg("[^a-zA-Z0-9]",$passwd1)) {
		$error4 = "$text_123";
		}
	} 
if ($passwd1 != $passwd2) {
	$error4 ="$text_122";
	}
// If any error occured --> send user back and show him what he did wrong
	if ($error1 || $error2 || $error3 || $error4) {
		$do = "personal";
		}
	else {
$lname = addslashes($lname);
$fname = addslashes($fname);
$email = addslashes($email);
	if ($passwd1!="") {
		// Encrypt $passwd1
		$passwd1 = md5($passwd1);
		// Delete the cookie and force user to login again using the new password...
		 SetCookie("myred14", "$user_id:$encryptedpassword", time()-7200);
		mysql_query("UPDATE $redir_table SET name='$lname',vname='$fname',email='$email',passwd='$passwd1' WHERE host='$hostname'") or die ("mysql_error");
		}
	else {
		mysql_query("UPDATE $redir_table SET name='$lname',vname='$fname',email='$email' WHERE host='$hostname'") or die ("mysql_error");
		}

// Show success template
$template = new MyredTemplate("html/$theme/personal2.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_115", $text_115);
$template->assign("text_116", $text_116);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}
#########################################
#### The personal data changes screen               ####
#########################################

if ($do == 'personal') {
// Get all personal nformation concerning $hostname out of mySQL...
$query = mysql_query("SELECT * FROM $redir_table WHERE host='$hostname'") or die (mysql_error());
while ($summary = mysql_fetch_array($query)) {
$lname = stripslashes($summary[name]);
$fname = stripslashes($summary[vname]);
$email = stripslashes($summary[email]);
}

// Print template
$template = new MyredTemplate("html/$theme/personal1.html");
$template->assign("text_26", $text_26);
$template->assign("text_27", $text_27);
$template->assign("text_28", $text_28);
$template->assign("text_29", $text_29);
$template->assign("text_35", $text_35);
$template->assign("text_42", $text_42);
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_114", $text_114);
$template->assign("text_116", $text_116);
$template->assign("text_117", $text_117);
$template->assign("text_118", $text_118);
$template->assign("text_119", $text_119);
$template->assign("text_120", $text_120);
$template->assign("text_121", $text_121);
$template->assign("fname", $fname);
$template->assign("lname", $lname);
$template->assign("email", $email);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

#########################################
#### Change the domain settings                          ####
#########################################

if ($do == 'changedomain') {
// Get all post variables and check for correctness
$targeturl = $_POST["targeturl"];
$targettitle = $_POST["targettitle"];
$targetdescription = $_POST["targetdescription"];
$targetkeywords = $_POST["targetkeywords"];
$targetrevisit = $_POST["targetrevisit"];
$category = $_POST["category"];
$targetrobot = $_POST["targetrobot"];

$metatags = spider($targeturl);
if(!$metatags) {
	$error10 = "$text_40";
	}
if(!$targettitle || strlen($targettitle) > 100) {
	$error11 = "$text_56";
	}
if(!$category) {
	$error12 = "$text_57";
	}
$forbiddenstatus = check_forbidden($targeturl);
if($forbiddenstatus == 1) {
	$error10 = "$text_216";
	}
// If any error occured --> send user back and show him what he did wrong
	if ($error10 || $error11 || $error12) {
		$do = "domain";
		}
	else {
// add slashes to prevent from destroying the database - is this necessary? don't know...
$targeturl = addslashes($targeturl);
$targettitle = addslashes($targettitle);
$targetdescription = addslashes($targetdescription);
$targetkeywords = addslashes($targetkeywords);
$targetrevisit = addslashes($targetrevisit);
$category = addslashes($category);
$targetrobot = addslashes($targetrobot);

mysql_query("UPDATE $redir_table SET url='$targeturl',title='$targettitle',descr='$targetdescription',keyw='$targetkeywords',robots='$targetrobot',revisit='$targetrevisit',cat='$category' WHERE host='$hostname'") or die ("mysql_error");

// Show success template
$template = new MyredTemplate("html/$theme/domain2.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_113", $text_113);
$template->assign("text_115", $text_115);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}
#########################################
#### The domain changes screen                          ####
#########################################

if ($do == 'domain') {
// Get all domain information concerning $hostname out of mySQL...
$query = mysql_query("SELECT * FROM $redir_table WHERE host='$hostname'") or die (mysql_error());
while ($summary = mysql_fetch_array($query)) {
$targeturl = stripslashes($summary[url]);
$targettitle = stripslashes($summary[title]);
$targetdescription = stripslashes($summary[descr]);
$targetkeywords = stripslashes($summary[keyw]);
$targetrevisit = stripslashes($summary[revisit]);
$category = stripslashes($summary[cat]);
$targetrobot = stripslashes($summary[robots]);
}
// list of categories
$cat_query = mysql_query("SELECT * FROM $category_table ORDER BY category ASC");
while ($cats = mysql_fetch_array($cat_query)) {
	$cats[0] = stripslashes($cats[0]);
	$categories .= "<option";
	if ( $cats[0] == $category) {
		$categories .= " selected";
		}	
	$categories .= ">$cats[0]</option>";
	}

// Print template
$template = new MyredTemplate("html/$theme/domain1.html");
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_113", $text_113);
$template->assign("text_43", $text_43);
$template->assign("text_31", $text_31);
$template->assign("text_32", $text_32);
$template->assign("text_35", $text_35);
$template->assign("text_42", $text_42);
$template->assign("text_44", $text_44);
$template->assign("text_45", $text_45);
$template->assign("text_46", $text_46);
$template->assign("text_47", $text_47);
$template->assign("text_48", $text_48);
$template->assign("text_49", $text_49);
$template->assign("text_50", $text_50);
$template->assign("text_51", $text_51);
$template->assign("text_52", $text_52);
$template->assign("text_53", $text_53);
$template->assign("text_114", $text_114);
$template->assign("error10", $error10);
$template->assign("error11", $error11);
$template->assign("error12", $error12);
$template->assign("targeturl", $targeturl);
$template->assign("targettitle", $targettitle);
$template->assign("targetdescription", $targetdescription);
$template->assign("targetkeywords", $targetkeywords);
$template->assign("targetrevisit", $targetrevisit);
$template->assign("targetrobot", $targetrobot);
$template->assign("categories", $categories);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
#########################################
#### The main screen of the members area          ####
#########################################

if ($do == 'main') {
// Get all information for the summary page
$query = mysql_query("SELECT * FROM $redir_table WHERE host='$hostname'") or die (mysql_error());
while ($summary = mysql_fetch_array($query)) {
$title = stripslashes($summary[title]);
$url = $summary[url];
$hits = $summary[counter];
$status = $summary[active];
$ads = $summary[adtype];
$date=$summary[time];
$visitortime=$summary[lasttime];
	}
$date = date($dateformat, $date);
$visitortime = date($dateformat, $visitortime);

$domainname = "<a href=\"http://$hostname\" target=\"_blank\">$hostname</a>";
if($status == 'on') {
	$status = "$text_97";
	}
else {
	$status = "$text_98";
	}
$redirectsto = "<a href=\"$url\" target=\"_blank\">$title</a>";


$template = new MyredTemplate("html/$theme/member_main.html");
$template->assign("text_85", $text_85);
$template->assign("text_86", $text_86);
$template->assign("text_87", $text_87);
$template->assign("text_88", $text_88);
$template->assign("text_89", $text_89);
$template->assign("text_90", $text_90);
$template->assign("text_91", $text_91);
$template->assign("text_92", $text_92);
$template->assign("text_93", $text_93);
$template->assign("text_94", $text_94);
$template->assign("text_95", $text_95);
$template->assign("text_96", $text_96);
$template->assign("text_112", $text_112);
$template->assign("text_124", $text_124);
$template->assign("text_132", $text_132);
$template->assign("text_133", $text_133);
$template->assign("text_134", $text_134);
$template->assign("domainname", $domainname);
$template->assign("status", $status);
$template->assign("redirectsto", $redirectsto);
$template->assign("hits", $hits);
$template->assign("ads", $ads);
$template->assign("date", $date);
$template->assign("visitortime", $visitortime);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

#########################
#### The login screen     ####
#########################
if ($do == 'login') {
$template = new MyredTemplate("html/$theme/login.html");
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
$template->assign("text_78", $text_78);
$template->assign("text_79", $text_79);
$template->assign("text_80", $text_80);
$template->assign("text_81", $text_81);
$template->assign("text_82", $text_82);
$template->assign("text_82", $text_82);
$template->assign("text_83", $text_83);
$template->assign("logindomain", $logindomain);
$template->assign("error1", $error1);
$template->assign("startpage", $startpage);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
?>