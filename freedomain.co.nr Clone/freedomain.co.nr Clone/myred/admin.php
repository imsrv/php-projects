<?php
#### Name of this file: admin.php 
#### This is the administration area of the redirection scripts

include("include/vars.php");
include("include/mysql.php");
include("language/$language");
require("include/functions.php");

// Check, if setup or upgrade files exist
if (file_exists("setup.php") || file_exists("upgrade.php")) {
	echo "<b>Security alert:</b> immediatly delete setup.php and upgrade.php before you start running your service!";
	exit;
}

#############################################################
#### This is a set of functions to authenticate and login the admin     ####
#############################################################

// Checks, if given admin name and password fit to the ones stored in the mysqlDB
function login_admin($user_name, $pass_word) {
global $options_table;
// form our sql query
$result = mysql_query("SELECT * FROM $options_table WHERE username='$user_name'") or die (mysql_error());

if(!$result || mysql_num_rows($result)!=1) {
// no user is found
	$success = 0;
	return $success;
	}

$row = mysql_fetch_array($result);
if (($row["username"] == $user_name) AND ($row["password"] == $pass_word) AND ($user_name != "")) { 

 // User has been authenticated, send a cookie
	$user_id = $row["username"];
 
	 SetCookie("myredadm", "$user_id:$pass_word", time()+7200); // expires two hours from now
	$success = 1; 
	}
else {
	$success = 0; 
	}
return $success; 
} 

// Check, if cookie is valid
function verify_admin($cookie) {
global $options_table;

// Split the cookie up into host and md5(password) 
$auth = explode(":", $cookie);
// Form our query
$query = mysql_query("SELECT * FROM $options_table WHERE username = '$auth[0]'"); 
$row = mysql_fetch_array($query); 
 
if (($row["username"] == $auth[0]) AND ($row["password"] == $auth[1]) AND ($auth[0] != "")) {
	$success = 1;
	}
else {
	$success = 0; 
	}
return $success; 
}
##################### End of cookie functions ########################

// first check what do do
$do = $_GET["do"];

// Get the host and password in case user logs in
$adm_user = $_POST["adm_user"];
$adm_pass = $_POST["adm_pass"];
if($adm_pass) {
	$adm_pass = md5($adm_pass);
	}

// Secure area - check for cookies
$myredadm = $_COOKIE["myredadm"];

if($myredadm) {
// ----- if cookie exists -----
	$authenticated = verify_admin($myredadm);
	if($authenticated==0) {
		$do = "login";
		$error1 = "$text_101";
		}
	}
else {
	$login=login_admin($adm_user,$adm_pass);
	if($login==0) {
		$do = "login";
		if($adm_user || $adm_pass) {
			$error1 = "$text_373";
			}
		}
	}
// if admin has logged in, the script carries on here....
$cookie_var = split(":", $myredadm);
if($cookie_var[0]!="") {
	$adminusername = $cookie_var[0];
}

// If no "do" is specified, go to the login page
if (!$do) {
	$do = "main";
	}

##################################
#### The password changing itself       ####
##################################
if ($do == 'dopassword') {
// Get the 2 password variables
$passwd1 = $_POST["passwd1"];
$passwd2 = $_POST["passwd2"];
if (!$passwd1 && !$passwd2) {
	$do = "password";
	}
else {
if(ereg("[^a-zA-Z0-9]",$passwd1)) {
		$error1 = "$text_123";
		}
if ($passwd1 != $passwd2) {
	$error1 ="$text_122";
	}
}
if ($error1) {
	$do = "password";
	}
else {
$passwd1 = md5($passwd1);
// Write the new password into the mysql table
mysql_query("UPDATE $options_table SET password='$passwd1' WHERE username='$adminusername'") or die ("mysql_error");

// Delete the cookie
SetCookie("myredadm", "$user_id:$encryptedpassword", time()-7200);

// Show a success screen
$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_244);
$template->assign("message", $text_115);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;

	}
}

##################################
#### The password changing screen    ####
##################################
if ($do == 'password') {

// Simply print the changing screen
$template = new MyredTemplate("html/$theme/admin/password1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_35", $text_35);
$template->assign("text_114", $text_114);
$template->assign("text_119", $text_119);
$template->assign("text_120", $text_120);
$template->assign("text_374", $text_374);
$template->assign("error1", $error1);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The category deletion itself           ####
##################################
if ($do == 'docatdel') {
// Get the category names
$catname = $_POST["catname"];
$targetcat = $_POST["targetcat"];
// First change all member categories
mysql_query("UPDATE $redir_table SET cat='$targetcat' WHERE cat='$catname'") or die (mysql_error());
// Then delete the category
mysql_query("DELETE FROM $category_table WHERE category='$catname'") or die (mysql_error());
// And show a success
$message = "<b>$catname</b> $text_403 <b>$targetcat</b>";
$do = "catdel";
}

##################################
#### The category deletion part 2         ####
##################################
if ($do == 'catdel2') {
// Get the category name
$catname = $_GET[catname];
// get the possible target categories
$catquery = mysql_query("SELECT category FROM $category_table WHERE category NOT LIKE '$catname' ORDER BY category ASC") or die (mysql_error());
while ($cats = mysql_fetch_array($catquery)) {
	$cats[0] = stripslashes($cats[0]);
	$cat_listbox .= "<option>$cats[0]</option>";
	}
$template = new MyredTemplate("html/$theme/admin/catdel2.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_400", $text_400);
$template->assign("text_401", $text_401);
$template->assign("text_402", $text_402);
$template->assign("catname", $catname);
$template->assign("cat_listbox", $cat_listbox);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The category deletion screen        ####
##################################
if ($do == 'catdel') {
// Get all the currently used categories for showing it on the screen
$catquery = mysql_query("SELECT * FROM $category_table ORDER BY category ASC") or die (mysql_error());
if (mysql_num_rows($catquery) <1) {
	$catlist = "$text_388";
	}
else {
	while($cat=mysql_fetch_array($catquery,MYSQL_ASSOC)) {
		$cat1 = $cat[category];
		$num_members = mysql_query("SELECT * FROM $redir_table where cat='$cat1'") or die (mysql_error());
		$num_members = mysql_num_rows($num_members);
		$catlist .= "<b>$cat[category]</b> $num_members $text_404 ( <a href=\"admin.php?do=catdel2&catname=$cat[category]\">$text_399</a> )<br>";
		}
	}
$template = new MyredTemplate("html/$theme/admin/catdel1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_390", $text_390);
$template->assign("message", $message);
$template->assign("catlist", $catlist);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
##################################
#### The category edit             itself      ####
##################################
if ($do == 'docatedit') {
// Get all variables....
$catname = $_POST["catname"];
$con_advtype = $_POST["con_advtype"];
$con_adurl = $_POST["con_adurl"];
$con_height = $_POST["con_height"];
$con_width = $_POST["con_width"];

// ...and check them
if (!$con_adurl && $con_advtype!="adfree") {
	$error2 = "$text_392";
	}
if (!is_numeric($con_height) && $con_advtype!="adfree") {
	$error3 = "$text_393";
	}
if (!is_numeric($con_width) && $con_advtype=="popup") {
	$error4 = "$text_393";
	}
if ($error2 || $error3 ||$error4) {
	$do = "catedit";
	}
else {
// No error found, lets put the data into the database
$con_adurl = addslashes($con_adurl);
mysql_query("UPDATE $category_table SET advtype='$con_advtype', adurl='$con_adurl', height='$con_height', width='$con_width' WHERE category='$catname'") or die (mysql_error());
$message = "$text_398";
$catname ="";
$do = "catedit";
	}
}

##################################
#### The categories edit screen             ####
##################################
if ($do == 'catedit') {
// Get the category name
if (!$catname) {
	$catname = $_GET["catname"];
	}
// if no category name is given, show all
if (!$catname) {
// Get all the currently used categories for showing it on the screen
$catquery = mysql_query("SELECT * FROM $category_table ORDER BY category ASC") or die (mysql_error());
if (mysql_num_rows($catquery) <1) {
	$catlist = "$text_388";
	}
else {
	while($cat=mysql_fetch_array($catquery,MYSQL_ASSOC)) {
		$catlist .= "<b>$cat[category]</b> <font size=\"1\">($cat[advtype] - $cat[adurl] - $cat[height] x $cat[width] - <a href=\"admin.php?do=catedit&catname=$cat[category]\">$text_255</a>)</font><br>";
		}
	}

$template = new MyredTemplate("html/$theme/admin/catedit1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_390", $text_390);
$template->assign("message", $message);
$template->assign("catlist", $catlist);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
// Else lets get the data from the given category
else {
$cateditquery = mysql_query("SELECT * FROM $category_table WHERE category='$catname'") or die (mysql_error());
$cat  = mysql_fetch_array($cateditquery);
$advtype_listbox = "<option value=\"popup\"";
if ($cat[advtype] == "popup") {
	$advtype_listbox .= " selected";
	}
$advtype_listbox .= ">$text_380</option>
<option value=\"upperframe\"";
if ($cat[advtype] == "upperframe") {
	$advtype_listbox .= " selected";
	}
$advtype_listbox .= ">$text_381</option>
<option value=\"lowerframe\"";
if ($cat[advtype] == "lowerframe") {
	$advtype_listbox .= " selected";
	}
$advtype_listbox .= ">$text_382</option>
<option value=\"adfree\"";
if ($cat[advtype] == "adfree") {
	$advtype_listbox .= " selected";
	}
$advtype_listbox .= ">$text_391</option>";

if(!$con_adurl) {
	$con_adurl = stripslashes($cat[adurl]);
	}
if(!$con_height) {
	$con_height = $cat[height];
	}
if(!$con_width) {
	$con_width = $cat[width];
	}

$template = new MyredTemplate("html/$theme/admin/catedit2.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_383", $text_383);
$template->assign("text_384", $text_384);
$template->assign("text_385", $text_385);
$template->assign("text_386", $text_386);
$template->assign("text_387", $text_387);
$template->assign("text_396", $text_396);
$template->assign("text_397", $text_397);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("catname", $catname);
$template->assign("advtype_listbox", $advtype_listbox);
$template->assign("con_adurl", $con_adurl);
$template->assign("con_height", $con_height);
$template->assign("con_width", $con_width);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}


##################################
#### The categories addtition itself      ####
##################################
if ($do == 'docatadd') {
// Get all variables....
$con_catadd = $_POST["con_catadd"];
$con_advtype = $_POST["con_advtype"];
$con_adurl = $_POST["con_adurl"];
$con_height = $_POST["con_height"];
$con_width = $_POST["con_width"];

// ...and check them
if (!$con_catadd) {
	$error1 = "$text_392";
	}
if (!$con_adurl && $con_advtype!="adfree") {
	$error2 = "$text_392";
	}
if (!is_numeric($con_height) && $con_advtype!="adfree") {
	$error3 = "$text_393";
	}
if (!is_numeric($con_width) && $con_advtype=="popup") {
	$error4 = "$text_393";
	}
if(mysql_num_rows(mysql_query("SELECT * from $category_table WHERE category='$con_catadd'")) > 0) {
	$error1 = "$text_395";
	}
if ($error1 || $error2 || $error3 ||$error4) {
	$do = "catadd";
	}
else {
// No error found, lets put the data into the database
$con_adurl = addslashes($con_adurl);
mysql_query("INSERT INTO $category_table (category, advtype, adurl, height, width) VALUES ('$con_catadd', '$con_advtype', '$con_adurl', '$con_height', '$con_width')") or die (mysql_error());
$message = "$text_394";
$con_catadd = "";
$con_advtype = "";
$con_adurl = "";
$con_height = "";
$con_width = "";
$do = "catadd";
	}
}

##################################
#### The categories addtition screen    ####
##################################
if ($do == 'catadd') {
// Get all the currently used categories for showing it on the screen
$catquery = mysql_query("SELECT * FROM $category_table ORDER BY category ASC") or die (mysql_error());
if (mysql_num_rows($catquery) <1) {
	$catlist = "$text_388";
	}
else {
	while($cat=mysql_fetch_array($catquery,MYSQL_ASSOC)) {
		$catlist .= "<b>$cat[category]</b> <font size=\"1\">($cat[advtype] - $cat[adurl] - $cat[height] x $cat[width] - <a href=\"admin.php?do=catedit&catname=$cat[category]\">$text_255</a>)</font><br>";
		}
	}

$template = new MyredTemplate("html/$theme/admin/catadd1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_380", $text_380);
$template->assign("text_381", $text_381);
$template->assign("text_382", $text_382);
$template->assign("text_383", $text_383);
$template->assign("text_384", $text_384);
$template->assign("text_385", $text_385);
$template->assign("text_386", $text_386);
$template->assign("text_387", $text_387);
$template->assign("text_388", $text_388);
$template->assign("text_389", $text_389);
$template->assign("text_390", $text_390);
$template->assign("text_391", $text_391);
$template->assign("text_396", $text_396);
$template->assign("message", $message);
$template->assign("catlist", $catlist);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("con_catadd", $con_catadd);
$template->assign("con_adurl", $con_adurl);
$template->assign("con_height", $con_height);
$template->assign("con_width", $con_width);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The domain deletion itself           ####
##################################
if ($do == 'dodomdel') {
// Get all variables needed
$domain = $_GET["domain"];
$action = $_GET["action"];
if ($action == "domain") {
	mysql_query("DELETE FROM $domain_table WHERE domain='$domain'") or die (mysql_error());
	$message = "$text_378 <b>$domain</b>";
	}
if ($action == "members") {
	mysql_query("DELETE FROM $domain_table WHERE domain='$domain'") or die (mysql_error());
	mysql_query("DELETE FROM $redir_table WHERE host LIKE '%$domain'") or die (mysql_error());
	$count_deleted = mysql_affected_rows();
	$message = "$text_378 <b>$domain</b><br>$text_379 <b>$count_deleted</b>";
	}
$do = "domdel";
}

##################################
#### The domain deletion screen           ####
##################################
if ($do == 'domdel') {
// Get all the currently used domains for showing it on the screen
$domquery = mysql_query("SELECT * FROM $domain_table ORDER BY domain ASC") or die (mysql_error());
if (mysql_num_rows($domquery) <1) {
	$domlist = "$text_366";
	}
else {
	while($dom=mysql_fetch_array($domquery,MYSQL_ASSOC)) {
		$domlist .= "<b>$dom[domain]</b> <a href=\"admin.php?do=dodomdel&domain=$dom[domain]&action=domain\">$text_376</a> - <a href=\"admin.php?do=dodomdel&domain=$dom[domain]&action=members\">$text_377</a><br>";
		}
	}

$template = new MyredTemplate("html/$theme/admin/domdel1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_375", $text_375);
$template->assign("message", $message);
$template->assign("domlist", $domlist);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The domain addition itself           ####
##################################
if ($do == 'dodomadd') {
// Get the domain name posted
$newdom = $_POST["con_domadd"];
if (!$newdom) {
	$message = "$text_367";
	}
// Check for duplicates
$domquery = mysql_query("SELECT * FROM $domain_table") or die (mysql_error());
while($dom=mysql_fetch_array($domquery,MYSQL_ASSOC)) {
	if ($newdom == $dom[domain]) {
		$message = "$text_368";
		}
	}
if ($message) {
	$do = "domadd";
	}
else {
// No error found, lets insert the new tld
mysql_query("INSERT into $domain_table (domain) VALUES ('$newdom')") or die (mysql_error());
$message = "$text_369";
$do = "domadd";
	}
}

##################################
#### The domain addition screen           ####
##################################
if ($do == 'domadd') {
// Get all the currently used domains for showing it on the screen
$domquery = mysql_query("SELECT * FROM $domain_table ORDER BY domain ASC") or die (mysql_error());
if (mysql_num_rows($domquery) <1) {
	$domlist = "$text_366";
	}
else {
	while($dom=mysql_fetch_array($domquery,MYSQL_ASSOC)) {
		$domlist .= "$dom[domain]<br>";
		}
	}

$template = new MyredTemplate("html/$theme/admin/domadd1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_365", $text_365);
$template->assign("domlist", $domlist);
$template->assign("message", $message);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The pruning itself                            ####
##################################
if ($do == 'doprune') {
// Get all variables needed
$dowhat = $_POST["dowhat"];
$days = $_POST["days"];
$days1 = $days*86400;
$timepoint = time()-$days1;

if ($dowhat == "warn") {
	$query = mysql_query("SELECT * FROM $redir_table WHERE lasttime<$timepoint") or die (mysql_error());
	while($row=mysql_fetch_array($query,MYSQL_ASSOC)) {
	$subject = "$text_161 $row[host]";
	$body = "$text_360 $row[host] $text_361 $days $text_358$text_362";
	mail($row[email],$subject,$body,"From: $adminmail\nReply-To: $adminmail");
	$affected_accounts = mysql_num_rows($query);
		}
	}
if ($dowhat == "delete") {
	$query = mysql_query("DELETE FROM $redir_table WHERE lasttime<$timepoint") or die (mysql_error());
	$affected_accounts = mysql_affected_rows();
	}
if ($dowhat == "maildelete") {
	$query = mysql_query("SELECT * FROM $redir_table WHERE lasttime<$timepoint") or die (mysql_error());
	while($row=mysql_fetch_array($query,MYSQL_ASSOC)) {
	$subject = "$text_161 $row[host]";
	$body = "$text_360 $row[host] $text_361 $days $text_358$text_363";
	mail($row[email],$subject,$body,"From: $adminmail\nReply-To: $adminmail");
	mysql_query("DELETE FROM $redir_table WHERE host='$row[host]'") or die (mysql_error());
	$affected_accounts = mysql_num_rows($query);
		}
	}
if(!$affected_accounts) {
	$affected_accounts = 0;
	}
// Show a success screen
$message = "$text_364 <b>$affected_accounts</b>";
$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_248);
$template->assign("message", $message);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The prune form screen                    ####
##################################
if ($do == 'prune') {
$template = new MyredTemplate("html/$theme/admin/prune1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_304", $text_304);
$template->assign("text_354", $text_354);
$template->assign("text_355", $text_355);
$template->assign("text_356", $text_356);
$template->assign("text_357", $text_357);
$template->assign("text_358", $text_358);
$template->assign("text_359", $text_359);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The word censors saving              ####
##################################
if ($do == 'docensors') {
$con_reserved = $_POST["con_reserved"];
$con_forbidden = $_POST["con_forbidden"];
if (!$con_reserved) {
	$error1 = "$text_353";
	}
if (!$con_forbidden) {
	$error2 = "$text_353";
	}
if ($error1 || $error2) {
	$do = "censors";
	}
else {
mysql_query("UPDATE $options_table SET reserved='$con_reserved', forbidden='$con_forbidden' WHERE username='$adminusername'") or die ("mysql_error");

// Show a success screen
$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_243);
$template->assign("message", $text_294);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
	}
}

##################################
#### The word censors form screen      ####
##################################
if ($do == 'censors') {
$template = new MyredTemplate("html/$theme/admin/censors1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_285", $text_285);
$template->assign("text_286", $text_286);
$template->assign("text_348", $text_348);
$template->assign("text_349", $text_349);
$template->assign("text_350", $text_350);
$template->assign("text_351", $text_351);
$template->assign("text_352", $text_352);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("reserved", $reserved);
$template->assign("forbidden", $forbidden);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The reject part                                  ####
##################################
if ($do == 'doreject') {
$host = $_GET["host"];
$query = mysql_fetch_array(mysql_query("SELECT email FROM $redir_table WHERE host='$host'"));
$emailaddress = stripslashes($query[0]);

// Send an email to the user and tell him, that he has been rejected
$subject = "$text_161 $host";
$body = "$text_345";
mail($emailaddress,$subject,$body,"From: $adminmail\nReply-To: $adminmail");

// Do the deletion of the domain name
mysql_query("DELETE FROM $redir_table WHERE host='$host'") or die (mysql_error());

$message = "<b>$host</b> $text_346";
$do = "approve";
}

##################################
#### The approve part                             ####
##################################
if ($do == 'doapprove') {
$host = $_GET["host"];
mysql_query("UPDATE $redir_table SET active='on' WHERE host='$host'") or die (mysql_error());
$query = mysql_fetch_array(mysql_query("SELECT email FROM $redir_table WHERE host='$host'"));
$emailaddress = stripslashes($query[0]);

// Send an email to the user and tell him, that he has been accepted
$subject = "$text_161 $host";
$body = "$text_343";
mail($emailaddress,$subject,$body,"From: $adminmail\nReply-To: $adminmail");
$message = "<b>$host</b> $text_344";
$do = "approve";
}
##################################
#### The approve list screen                  ####
##################################
if ($do == 'approve') {
// Lets get all members that hav active set to "off"
$result = mysql_query("SELECT * FROM $redir_table WHERE active='off' ORDER BY time ASC");
if (mysql_num_rows($result) > 0) {
while($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
	$registered = date($dateformat, $row[time]);
	$memberlist .= "<b>$row[host]</b> ($text_132 $registered) (<a href=\"admin.php?do=doapprove&host=$row[host]\">$text_327</a> - <a href=\"admin.php?do=doreject&host=$row[host]\">$text_342</a> - <a href=\"admin.php?do=edit&host=$row[host]\">$text_324</a>)<br>";
	$memberlist .= "$text_88 <a href=\"$row[url]\">$row[url]</a><br>";
	$memberlist .= "$text_68 <a href=\"mailto:$row[email]\">$row[email]</a><br>";
	$memberlist .= "<font size=\"1\"><i>$text_341</i> $row[title]<br>";
	$memberlist .= "<i>$text_45</i> $row[descr]<br>";
	$memberlist .= "<i>$text_46</i> $row[keyw]</font><br><br>";
	}
}
else {
	$memberlist = "$text_347";
}
if (!$message) {
	$message = "<b>$text_340</b>";
	}
$template = new MyredTemplate("html/$theme/admin/approve.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("message", $message);
$template->assign("memberlist", $memberlist);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The members list                              ####
##################################
if ($do == 'list') {
// This is the variable for the mysql-query (where to start the query)
$start = $_GET["start"];
if(empty($start) || $start<0) {
	$start=0;
}
// get the number of members
$result = mysql_query("SELECT * FROM $redir_table");
$num_members = mysql_num_rows($result);
// The number of accounts to show per page
$listperpage = 50;

// the page-forward and backward links, and the pages to click on
$back = $start-$listperpage; 
$linkback = "<a href=\"admin.php?do=list&start=$back\"><b>$text_193</b></a>";
if($back < 0) { 
	$back = 0;
	$linkback = "$text_193"; 
	}
$forward = $start+$listperpage;
$linkforward = "<a href=\"admin.php?do=list&start=$forward\"><b>$text_194</b></a>";
if($forward >= $num_members) {
	$linkforward = "$text_194";
	}
// The  navigation menu
$menu = "<b>$num_members</b> $text_339</div><br><div align=\"right\">$text_198 $linkback || $linkforward</div>";

if($num_members > 0) {
// if members are found, loop for them
$result1=mysql_query("SELECT * FROM $redir_table ORDER BY counter DESC LIMIT $start, $listperpage") or die (mysql_error());

while($rowmembers=mysql_fetch_array($result1,MYSQL_ASSOC)) {
// strip the C escape-slashes
$rowmembers[host] = stripslashes($rowmembers[host]);
	if ($rowmembers[active] == "on") {
		$memberslist .= "<a href=\"http://www.$rowmembers[host]\" target=\"_blank\"><b>$rowmembers[host]</b></a>";
		}
	else {
		$memberslist .= "$rowmembers[host] (<b>$text_326</b> - <a href=\"admin.php?do=doapprove&host=$rowmembers[host]\">$text_327</a> - <a href=\"admin.php?do=doreject&host=$rowmembers[host]\">$text_342</a>)";
		}		
		$memberslist .= " (<a href=\"admin.php?do=edit&host=$rowmembers[host]\">$text_324</a> - <a href=\"admin.php?do=delete&host=$rowmembers[host]\">$text_325</a>)<br>";
	}
} // End members found

else {
// no members found
	$menu = "";
	$memberslist = "$text_338";
}
// Print out the list
$template = new MyredTemplate("html/$theme/admin/list.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("menu", $menu);
$template->assign("memberslist", $memberslist);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The members search itself              ####
##################################
if ($do == 'dosearch') {
// Get all variables
$searchwhere = $_POST["searchwhere"];
$keyword = $_POST["keyword"];
if (!$keyword) {
	$error1 =  "$text_313";
	$do = "search";
	}
else {
$searchresult = mysql_query("SELECT * FROM $redir_table WHERE $searchwhere LIKE '%$keyword%'");
if (mysql_num_rows($searchresult) < 1) {
	$error1 = "$text_322 <b>$keyword</b>";
	$do = "search";
	}
else {
// We've got one or more matches, lets list them
	while($rowmembers=mysql_fetch_array($searchresult)) {
	$rowmembers[host] = stripslashes($rowmembers[host]);
	if ($rowmembers[active] == "on") {
		$searchlist .= "<a href=\"http://www.$rowmembers[host]\" target=\"_blank\"><b>$rowmembers[host]</b></a>";
		}
	else {
		$searchlist .= "$rowmembers[host] (<b>$text_326</b> - <a href=\"admin.php?do=doapprove&host=$rowmembers[host]\">$text_327</a>)";
		}		
		$searchlist .= " (<a href=\"admin.php?do=edit&host=$rowmembers[host]\">$text_324</a> - <a href=\"admin.php?do=delete&host=$rowmembers[host]\">$text_325</a>)<br>";
	}
// Print out the searchresult
$template = new MyredTemplate("html/$theme/admin/search2.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_323", $text_323);
$template->assign("keyword", $keyword);
$template->assign("searchlist", $searchlist);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
}
}

##################################
#### The search form screen                   ####
##################################
if ($do == 'search') {
$template = new MyredTemplate("html/$theme/admin/search1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_311", $text_311);
$template->assign("text_312", $text_312);
$template->assign("text_314", $text_314);
$template->assign("text_315", $text_315);
$template->assign("text_316", $text_316);
$template->assign("text_317", $text_317);
$template->assign("text_318", $text_318);
$template->assign("text_319", $text_319);
$template->assign("text_320", $text_320);
$template->assign("text_321", $text_321);
$template->assign("error1", $error1);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The saving of member edit             ####
##################################
if ($do == 'doedit') {
// Get all post variables and check for correctness
$host = $_POST["host"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$passwd1 = $_POST["passwd1"];
$passwd2 = $_POST["passwd2"];
$targeturl = $_POST["targeturl"];
$targettitle = $_POST["targettitle"];
$targetdescription = $_POST["targetdescription"];
$targetkeywords = $_POST["targetkeywords"];
$targetrevisit = $_POST["targetrevisit"];
$category = $_POST["category"];
$targetrobot = $_POST["targetrobot"];
$stats = $_POST["stats"];
$ads = $_POST["ads"];
$active = $_POST["active"];
$counter = $_POST["counter"];
$news = $_POST["news"];

if(!$fname || strlen($fname) > 25) {
	$error1 = "$text_37";
	}
if(!$lname || strlen($name) > 25) {
	$error2 = "$text_38";
	}
if(!$email || !verify_email($email) || strlen($email) > 100) {
	$error3 = "$text_39";
	}
if ($passwd1) {
	if(ereg("[^a-zA-Z0-9]",$passwd1)) {
		$error4 = "$text_123";
		}
	} 
if ($passwd1 != $passwd2) {
	$error4 ="$text_122";
	}
$metatags = spider($targeturl);
if(!$metatags || strlen($targeturl) > 100) {
	$error5 = "$text_40";
	}
if(!$targettitle || strlen($targettitle) > 100) {
	$error6 = "$text_56";
	}
if(!$category) {
	$error7 = "$text_57";
	}
if (!is_numeric($counter)) {
	$error8 ="$text_337";
	}
// If any error occured --> send admin (you :-)) back and show him what he did wrong
	if ($error1 || $error2 || $error3 || $error4 || $error5 || $error6 || $error7 || $error8) {
		$do = "edit";
		}
else {
// Everything seems to be ok, lets go and save the values
$lname = addslashes($lname);
$fname = addslashes($fname);
$email = addslashes($email);
$targeturl = addslashes($targeturl);
$targettitle = addslashes($targettitle);
$targetdescription = addslashes($targetdescription);
$targetkeywords = addslashes($targetkeywords);
$targetrevisit = addslashes($targetrevisit);
$category = addslashes($category);
$targetrobot = addslashes($targetrobot);
if ($passwd1!="") {
	// Encrypt $passwd1
	$passwd1 = md5($passwd1);
	$password_save = "passwd='$passwd1',";
	}
mysql_query("UPDATE $redir_table SET name='$lname',vname='$fname',email='$email',$password_save url='$targeturl',title='$targettitle',descr='$targetdescription',keyw='$targetkeywords',robots='$targetrobot',revisit='$targetrevisit',cat='$category', adtype='$ads', active='$active', stats='$stats', counter='$counter', news='$news' WHERE host='$host'") or die ("mysql_error");

// Show a success screen
$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_324);
$template->assign("message", $text_294);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
}

##################################
#### The member edit screen                  ####
##################################
if ($do == 'edit') {
$host = $_GET["host"];
if (!$host) {
	$host = $_POST["host"];
	}
$memberdata = mysql_query("SELECT * FROM $redir_table WHERE host='$host'");
$check = mysql_num_rows($memberdata);
if(!$host || $check <> 1) {
$template = new MyredTemplate("html/$theme/admin/gen_error.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_324);
$template->assign("message", $text_330);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
// Get all the data from the members account
while ($summary = mysql_fetch_array($memberdata)) {
$lname = stripslashes($summary[name]);
$fname = stripslashes($summary[vname]);
$email = stripslashes($summary[email]);
$targeturl = stripslashes($summary[url]);
$targettitle = stripslashes($summary[title]);
$targetdescription = stripslashes($summary[descr]);
$targetkeywords = stripslashes($summary[keyw]);
$targetrevisit = stripslashes($summary[revisit]);
$category = stripslashes($summary[cat]);
$targetrobot = stripslashes($summary[robots]);
$stats = $summary[stats];
$ads = $summary[adtype];
$active = $summary[active];
$counter = $summary[counter];
$news = $summary[news];
$date=$summary[time];
$visitortime=$summary[lasttime];
$registerdate = date($dateformat, $date);
$lastdate = date($dateformat, $visitortime);
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
// See, if stats are on or off
$stats_listbox = "<option value=\"on\"";
if ($stats == "on") {
	$stats_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$stats_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}
// See, if ads are on or off
$ads_listbox = "<option value=\"on\"";
if ($ads == "on") {
	$ads_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$ads_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}
// See, if the domain is active
$active_listbox = "<option value=\"on\"";
if ($active == "on") {
	$active_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$active_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}
// Check, if newsletter is active
$news_listbox = "<option value=\"on\"";
if ($news == "on") {
	$news_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$news_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}
$template = new MyredTemplate("html/$theme/admin/edit1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_8", $text_8);
$template->assign("text_26", $text_26);
$template->assign("text_27", $text_27);
$template->assign("text_28", $text_28);
$template->assign("text_29", $text_29);
$template->assign("text_31", $text_31);
$template->assign("text_35", $text_35);
$template->assign("text_42", $text_42);
$template->assign("text_43", $text_43);
$template->assign("text_44", $text_44);
$template->assign("text_45", $text_45);
$template->assign("text_46", $text_46);
$template->assign("text_48", $text_48);
$template->assign("text_50", $text_50);
$template->assign("text_52", $text_52);
$template->assign("text_114", $text_114);
$template->assign("text_117", $text_117);
$template->assign("text_119", $text_119);
$template->assign("text_120", $text_120);
$template->assign("text_132", $text_132);
$template->assign("text_133", $text_133);
$template->assign("text_135", $text_135);
$template->assign("text_324", $text_324);
$template->assign("text_332", $text_332);
$template->assign("text_333", $text_333);
$template->assign("text_334", $text_334);
$template->assign("text_335", $text_335);
$template->assign("text_336", $text_336);
$template->assign("registerdate", $registerdate);
$template->assign("lastdate", $lastdate);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("error5", $error5);
$template->assign("error6", $error6);
$template->assign("error7", $error7);
$template->assign("error8", $error8);
$template->assign("fname", $fname);
$template->assign("lname", $lname);
$template->assign("email", $email);
$template->assign("targeturl", $targeturl);
$template->assign("targettitle", $targettitle);
$template->assign("targetdescription", $targetdescription);
$template->assign("targetkeywords", $targetkeywords);
$template->assign("targetrevisit", $targetrevisit);
$template->assign("targetrobot", $targetrobot);
$template->assign("categories", $categories);
$template->assign("stats_listbox", $stats_listbox);
$template->assign("ads_listbox", $ads_listbox);
$template->assign("active_listbox", $active_listbox);
$template->assign("counter", $counter);
$template->assign("news_listbox", $news_listbox);
$template->assign("host", $host);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}


##################################
#### The account deletion itself            ####
##################################
if ($do == 'dodelete') {
$host = $_GET["host"];
$check = mysql_num_rows(mysql_query("SELECT * FROM $redir_table WHERE host='$host'"));
if(!$host || $check <> 1) {
$template = new MyredTemplate("html/$theme/admin/gen_error.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_325);
$template->assign("message", $text_330);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
// Do the deletion
mysql_query("DELETE FROM $redir_table WHERE host='$host'") or die (mysql_error());
// also delete the stats belonging to this hostname
mysql_query("DELETE FROM $visitor_table WHERE host='$host'") or die (mysql_error());

$message = "<b>$host</b> $text_331";

$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_325);
$template->assign("message", $message);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The delete question screen            ####
##################################
if ($do == 'delete') {
$host = $_GET["host"];
if(!$host) {
$template = new MyredTemplate("html/$theme/admin/gen_error.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $text_325);
$template->assign("message", $text_330);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
$delete_do = "<a href=\"admin.php?do=dodelete&host=$host\">$text_329</a>";
$template = new MyredTemplate("html/$theme/admin/delete1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_325", $text_325);
$template->assign("text_328", $text_328);
$template->assign("delete_do", $delete_do);
$template->assign("host", $host);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The mass email part                     ####
##################################
if ($do == 'domail') {
// Fetch all post variables
$who = $_POST["who"];
$status = $_POST["status"];
$mailsubject = $_POST["mailsubject"];
$mailbody = $_POST["mailbody"];
$mailbody = stripslashes($mailbody);
$mailsubject = stripslashes($mailsubject);
if (empty($mailsubject)) {
	$error1 = "$text_306";
		}
if (empty($mailbody)) {
	$error2 = "$text_307";
		}
if ($error1 || $error2) {
	$do = "mail";
	}
// If no error occured, lets do the mail part
else {
// Form our sql-query out of the post data
// Part 1
if ($who == "news") {
	$part1 = "WHERE news='on'";
	}
else {
	$part1 = "WHERE (news='on' OR news='off')";
	}
// Part2
if ($status == "on") {
	$part2 = "AND active='on'";
	}
elseif ($status == "off") {
	$part2 = "AND active='off'";
	}
else {
	$part2 = "";
	}
// The query itself
$sql = "SELECT DISTINCT email FROM $redir_table $part1 $part2";
$getaddress = mysql_query($sql);
while($emailarray=mysql_fetch_array($getaddress)) {
		$email=stripslashes($emailarray[0]);
	   	mail($email,$mailsubject,$mailbody,"From: $adminmail\nReply-To: $adminmail");
	}
// Count the number of mails
$totalnum = mysql_num_rows($getaddress);

// Print a success screen
$header = "$text_242";
$message = "$text_308 $totalnum";
$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $header);
$template->assign("message", $message);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
}

##################################
#### The email form screen                    ####
##################################
if ($do == 'mail') {
$template = new MyredTemplate("html/$theme/admin/mail1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_295", $text_295);
$template->assign("text_296", $text_296);
$template->assign("text_297", $text_297);
$template->assign("text_298", $text_298);
$template->assign("text_299", $text_299);
$template->assign("text_300", $text_300);
$template->assign("text_301", $text_301);
$template->assign("text_302", $text_302);
$template->assign("text_303", $text_303);
$template->assign("text_304", $text_304);
$template->assign("text_305", $text_305);
$template->assign("mailsubject", $mailsubject);
$template->assign("mailbody", $mailbody);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
##################################
#### The configuration saving screen  ####
##################################
if ($do == 'doconfig') {
// Lets get all the post data...
$con_startpage = $_POST["con_startpage"];
$con_pagetitle = $_POST["con_pagetitle"];
$con_adminmail = $_POST["con_adminmail"];
$con_domainip = $_POST["con_domainip"];
$con_maindomain = $_POST["con_maindomain"];
$con_language = $_POST["con_language"];
$con_multiple = $_POST["con_multiple"];
$con_minlength = $_POST["con_minlength"];
$con_maxlength = $_POST["con_maxlength"];
$con_autoappr = $_POST["con_autoappr"];
$con_mailtoadmin = $_POST["con_mailtoadmin"];
$con_theme = $_POST["con_theme"];

// ...and proove it
if (empty($con_startpage)) {
	$error1 = "$text_289";
	}
if (empty($con_pagetitle)) {
	$error2 = "$text_289";
	}
if(!$con_adminmail || !verify_email($con_adminmail)) {
	$error3 = "$text_291";
	}
if (empty($con_maindomain)) {
	$error4 = "$text_292";
	}
if (!is_numeric($con_minlength) || !is_numeric($con_maxlength) || empty($con_minlength) || empty($con_maxlength) || ($con_maxlength-$con_minlength) < 1) {
	$error5 = "$text_293";
	}
if ($error1 || $error2 || $error3 || $error4 || $error5) {
	$do = "config";
}
// Else write everything into the database
else {
mysql_query("UPDATE $options_table SET home='$con_startpage', sitetitle='$con_pagetitle', adminemail='$con_adminmail', domainip='$con_domainip', maindomain='$con_maindomain', language='$con_language', multiple='$con_multiple', minlength='$con_minlength', maxlength='$con_maxlength', autoappr='$con_autoappr', mailtoadmin='$con_mailtoadmin', theme='$con_theme' WHERE username='$adminusername'") or die ("mysql_error");

// Print a success screen
$header = "$text_241";
$message = "$text_294";
$template = new MyredTemplate("html/$theme/admin/gen_success.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("header", $header);
$template->assign("message", $message);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}
}

##################################
#### The configuration screen              ####
##################################
if ($do == 'config') {

// Get the available languages
$handle = opendir("language");
while ($file = readdir($handle)) {
	if (!(($file==".") || ($file==".."))) {
		$lang_listbox .= "<option value=\"$file\"";
		if ($file == $language) {
			$lang_listbox .= " selected";
			}
		$file1 = str_replace(".php", "", $file);
		$lang_listbox .= ">$file1</option>";
		 }
	}
closedir($handle);

// See, if multiple is on or off
$multiple_listbox = "<option value=\"on\"";
if ($multiple == "on") {
	$multiple_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$multiple_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}
// See, if autoapprove is on or off
$autoappr_listbox = "<option value=\"on\"";
if ($autoappr == "on") {
	$autoappr_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$autoappr_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}
// See, if mail to admin is on or off
$mailtoadmin_listbox = "<option value=\"on\"";
if ($mailtoadmin == "on") {
	$mailtoadmin_listbox .= " selected>$text_277</option><option value=\"off\">$text_278</option>";
	}
else {
	$mailtoadmin_listbox .= ">$text_277</option><option value=\"off\" selected>$text_278</option>";
}

// Get the available themes
$handle = opendir("html");
while ($file = readdir($handle)) {
	if (!(($file==".") || ($file==".."))) {
		$theme_listbox .= "<option value=\"$file\"";
		if ($file == $theme) {
			$theme_listbox .= " selected";
			}
		$theme_listbox .= ">$file</option>";
		 }
	}
closedir($handle);

// Print the config main screen
$template = new MyredTemplate("html/$theme/admin/config1.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_264", $text_264);
$template->assign("text_265", $text_265);
$template->assign("text_266", $text_266);
$template->assign("text_267", $text_267);
$template->assign("text_268", $text_268);
$template->assign("text_269", $text_269);
$template->assign("text_270", $text_270);
$template->assign("text_271", $text_271);
$template->assign("text_272", $text_272);
$template->assign("text_273", $text_273);
$template->assign("text_274", $text_274);
$template->assign("text_275", $text_275);
$template->assign("text_276", $text_276);
$template->assign("text_279", $text_279);
$template->assign("text_280", $text_280);
$template->assign("text_281", $text_281);
$template->assign("text_282", $text_282);
$template->assign("text_283", $text_283);
$template->assign("text_284", $text_284);
$template->assign("text_285", $text_285);
$template->assign("text_286", $text_286);
$template->assign("text_287", $text_287);
$template->assign("text_288", $text_288);
$template->assign("text_309", $text_309);
$template->assign("text_310", $text_310);
$template->assign("error1", $error1);
$template->assign("error2", $error2);
$template->assign("error3", $error3);
$template->assign("error4", $error4);
$template->assign("error5", $error5);
$template->assign("startpage", $startpage);
$template->assign("pagetitle", $pagetitle);
$template->assign("adminmail", $adminmail);
$template->assign("domainip", $domainip);
$template->assign("maindomain", $maindomain);
$template->assign("lang_listbox", $lang_listbox);
$template->assign("multiple_listbox", $multiple_listbox);
$template->assign("minlength", $minlength);
$template->assign("maxlength", $maxlength);
$template->assign("autoappr_listbox", $autoappr_listbox);
$template->assign("mailtoadmin_listbox", $mailtoadmin_listbox);
$template->assign("theme_listbox", $theme_listbox);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The administration main screen     ####
##################################
if ($do == 'main') {
// Lets get all data for the summary page...
$totalmembers = mysql_fetch_array(mysql_query("SELECT count(*) FROM $redir_table"));
$inactivemembers = mysql_fetch_array(mysql_query("SELECT count(*) FROM $redir_table WHERE active='off'"));
$hits_total = 0;
$hits_query = mysql_query("SELECT counter FROM $redir_table") or die (mysql_error());
while ($hits_array = mysql_fetch_array($hits_query)) {
	$hits_total += $hits_array[0];
	}

$template = new MyredTemplate("html/$theme/admin/main.html");
$template->assign("text_95", $text_95);
$template->assign("text_239", $text_239);
$template->assign("text_240", $text_240);
$template->assign("text_241", $text_241);
$template->assign("text_242", $text_242);
$template->assign("text_243", $text_243);
$template->assign("text_244", $text_244);
$template->assign("text_245", $text_245);
$template->assign("text_246", $text_246);
$template->assign("text_247", $text_247);
$template->assign("text_248", $text_248);
$template->assign("text_249", $text_249);
$template->assign("text_250", $text_250);
$template->assign("text_251", $text_251);
$template->assign("text_252", $text_252);
$template->assign("text_253", $text_253);
$template->assign("text_254", $text_254);
$template->assign("text_255", $text_255);
$template->assign("text_256", $text_256);
$template->assign("text_260", $text_260);
$template->assign("text_257", $text_257);
$template->assign("text_258", $text_258);
$template->assign("text_259", $text_259);
$template->assign("text_261", $text_261);
$template->assign("text_262", $text_262);
$template->assign("text_263", $text_263);
$template->assign("totalmembers", $totalmembers[0]);
$template->assign("inactivemembers", $inactivemembers[0]);
$template->assign("release", $release);
$template->assign("hits_total", $hits_total);
$template->assign("title", $pagetitle);
$template->myred_print() or die($template->error);
exit;
}

##################################
#### The logout part                       ####
##################################
if ($do == 'logout') {
// Delete cookie
SetCookie("myredadm", "$user_id:$encryptedpassword", time()-7200);
$do = "login";
}

##################################
#### The login screen                     ####
##################################
if ($do == 'login') {
$template = new MyredTemplate("html/$theme/admin/login.html");
$template->assign("text_370", $text_370);
$template->assign("text_371", $text_371);
$template->assign("text_372", $text_372);
$template->assign("error1", $error1);
$template->myred_print() or die($template->error);
exit;
}
?>