<?php

///////////////////////////////////
// mAd - Advert Rotation Manager //
///////////////////////////////////
// Version 0.5                  //
// 29 Jan 05                     //
///////////////////////////////////
// Created by Ian Bennett        //
// ian at ianbennett dot net     //
// w3 dot ianbennett dot net     //
///////////////////////////////////


// INSTALL DATA
$install = array(
	'folders' => array(
		'config'
	),
	'files' => array(
		'index.php',
		'include.php',
		'out.php',
		'stats.php',
		'config/config.php',
		'config/stats.php',
		'config/stats_login.php',
		'config/stats_private.php',
		'config/stats_public.php',
		'config/stats_publicentry.php',
		'config/stats_vars.php',
		'config/user.php'
	),
	'tables' => array(
		'mad'
	),
	'fields' => array(
		"`ad_id` INT( 5 ) NOT NULL AUTO_INCREMENT ,
`ad_name` VARCHAR( 255 ) DEFAULT 'Title' NOT NULL ,
`ad_url` VARCHAR( 255 ) DEFAULT 'URL' NOT NULL ,
`ad_link` VARCHAR( 255 ) DEFAULT 'Link' NOT NULL ,
`ad_views` INT( 20 ) DEFAULT 0 NOT NULL ,
`ad_clicks` INT( 20 ) DEFAULT 0 NOT NULL ,
`ad_pass` VARCHAR( 255 ) NULL ,
`ad_time` INT( 10 ) DEFAULT 0 NOT NULL ,
`ad_current` INT( 1 ) DEFAULT 0 NOT NULL ,
`ad_type` VARCHAR( 10 ) NULL ,
PRIMARY KEY ( `ad_id` )"
	),
);

$update = array(
	'folders' => array(
	),
	'files' => array(
		'index.php',
		'include.php',
		'stats.php',
		'out.php',
		'config/stats.php',
		'config/stats_login.php',
		'config/stats_private.php',
		'config/stats_public.php'
	),
	'tables' => array(
	),
	'fields' => array(
	),
);


// Language
$lang = array(
	'success'	=>	'<span style="color: green">Success!</span>',
	'failure'	=>	'<span style="color: red">FAILED</span>',
	'skipped'	=>	'<span style="color: orange"><i>Skipped</i></span>'
);



// Functions
function make_folder($folder, $create) {
	global $lang;
	if ($create == 1) {
		if (is_dir($folder)) {
			return $lang['skipped'];
			break;
		}
		else return (mkdir($folder)) ? $lang['success'] : $lang['failure'];
	}
	else return $lang['skipped'];
}

function make_file($content, $filename, $create) {
	global $lang;
	if ($create == 1) {
		if (file_exists($filename)) {
			if (!unlink($filename)) {
				return $lang['failed'];
				break;
			}
		}
		$active = fopen($filename, 'w');
		if ($active  === FALSE) $fail = 1;
		else {
			if (fwrite($active, $content) === FALSE) $fail = 1;
			else fclose($active);
		}
		return ($fail === 1) ? $lang['failure'] : $lang['success'];
	}
	else return $lang['skipped'];
}

function make_table($host, $user, $pass, $db, $table, $fields, $create) {
	global $lang;
	if ($create == 1) {
		$active = mysql_connect($host, $user, $pass);
		if ($active === FALSE) $fail = 1;
		else {
			$field_list = '';
			$count = count($fields);
			//for ($i = 1; $i <= $count; $i++) $field_list .= $fields[$i] . ($i === $count) ? NULL : ', ';
			if (mysql_select_db($db) === FALSE) $fail = 1;
			elseif (mysql_query("CREATE TABLE $table ( $fields )") === FALSE) $fail = 1;
		}
		return ($fail === 1) ? $lang['failure'] : $lang['success'];
	}
	else return $lang['skipped'];
}

function get_content() {
	$content = ob_get_contents();
	$content = str_replace(
		'{start_php}',
		'<?php',
		$content
	);
	ob_clean();
	return $content;
}


// Get the install path
$parts = explode('/', $_SERVER['SCRIPT_NAME']);
$install_file = '';
for ($j = 0; $parts[$j + 1]; $j++) {
	$install_file .= $parts[$j]; 
	if ($parts[$j + 2]) $install_file .= '/';
}
$install_path = "http://" . $_SERVER['HTTP_HOST'] . $install_file;
$PHP_SELF = $_SERVER['SCRIPT_NAME'];



// INDEX.PHP
ob_start();
?>
{start_php}
///////////////////////////////////
// mAd - Advert Rotation Manager //
///////////////////////////////////
// Version 0.5                   //
// 30 Jan 05                     //
// index.php                     //
///////////////////////////////////
// Created by Ian Bennett        //
// ian at ianbennett dot net     //
// w3 dot ianbennett dot net     //
///////////////////////////////////
// This program is provided      //
// under the agreement that it   //
// is used only for the display  //
// of rotating image links on a  //
// website.                      //
///////////////////////////////////
// It may be used to gain profit //
// by using it as a tool to      //
// display advertisements.       //
///////////////////////////////////
// It must not be repackaged or  //
// provided under another name;  //
// displayed as being by another //
// person, or sold for profit.   //
///////////////////////////////////
// You also agree not to hold    //
// Ian Bennett responsible for   //
// any problems which occur as a //
// result of using mAd.          //
///////////////////////////////////
// Any bugs, comments or         //
// suggestions, go to my forum @ //
// http://www.w00ty.com/forum    //
///////////////////////////////////
foreach ($_POST as $key => $val) $$key = $val;
foreach ($_GET as $key => $val) if (!$$key) $$key = $val;
$mad_version = 0.5;
$current_time = time();
session_start();
if ($act == "logout") {
	unset($_SESSION);
	session_destroy();
}
if (!$_SESSION['user']) {
	require "config/user.php";
	if ((md5($input_user) == $config_user) && (md5($input_pass) == $config_pass)) {
		$_SESSION['user'] = $input_user;
		header("Location: $PHP_SELF");
		exit();
	}
	else {
		$content = <<<HTML
<h3>Login to mAd</h3>
<form action="$PHP_SELF" method="post">
<input type="text" name="input_user" style="width: 10%">&nbsp;Username
<br />
<input type="password" name="input_pass" style="width: 10%">&nbsp;Password
<br />
<input type="submit" value="Login" style="width: 10%">
</form>
<br />
<a href="http://www.w00ty.com/forum/viewforum.php?f=2">m Web Dev Forum</a>
<br /><br />
<!-- mAd announcements and notices of outdated software.
     This does NOT do anything malicious such as record data.
     It shows information relevant to your version of mAd only. -->
<iframe src="http://www.w00ty.com/mad/remote.php?v=$mad_version" frameborder="0"></iframe>
HTML;
	}
}
elseif ($_SESSION['user']) {
	require "config/config.php";
	function doSQL($sql_query,$refresh) {
		require "config/config.php";
		unset($error);
		if (!@$sql_connect = mysql_connect("$config_sqlhost", "$config_sqluser", "$config_sqlpass")) {
			$error = "couldn't login to SQL [ " . mysql_error() . " ]";
		}
		else {
			if (!@mysql_select_db("$config_sqldb")) {
				$error = "couldn't select database [ " . mysql_error() . " ]";
			}
			else {
				if ($sql_result = @mysql_query($sql_query)) {
					if ($refresh == 1) {
						header("Location: $PHP_SELF?result=success");
						exit();
					}
				}
				else {
					$error = "couldn't run SQL query [ " . mysql_error() . " ]";
				}
			}
		}
		if ($error && ($refresh == 1)) {
			header("Location: $PHP_SELF?result=fail&error=$error&query=$sql_query");
			exit();
		}
	return $sql_result;
	}
	function getFile($file) {
		return str_replace("
","",implode("",file($file)));
	}
	if ($act == "add") {
		$add_name = addslashes($add_name);
		$add_url = addslashes($add_url);
		$add_pass ? $add_pass = '"' . md5($add_pass) . '"' : $add_pass = 'null';
		$sql_query = <<<SQL
INSERT INTO $config_sqltable VALUES ( "", "$add_name", "$add_url", "$add_link", 0, 0, $add_pass, $current_time, 0, "$add_type" )
SQL;
		doSQL($sql_query,1);
	}
	elseif ($act == "edit") {
		$edit_name = addslashes($edit_name);
		$edit_url = addslashes($edit_url);
		if ($edit_editpass == "yes") {
			$edit_pass ? $edit_pass = ', ad_pass="' . md5($edit_pass) . '"' : $edit_pass = ', ad_pass=null';
		}
		else {
			unset($edit_pass);
		}
		$sql_query = <<<SQL
UPDATE $config_sqltable SET ad_name="$edit_name", ad_url="$edit_url", ad_link="$edit_link", ad_type="$edit_type"$edit_pass WHERE ad_id=$id
SQL;
		doSQL($sql_query,1);
	}
	elseif ($act == "delete") {
		$sql_query = "DELETE FROM $config_sqltable WHERE ad_id=$id";
		doSQL($sql_query,1);
	}
	elseif ($act == "options") {
		if (!$options_statprotect) {
			$options_statprotect = "no";
		}
		if (($options_select != "time") && ($options_select != "math") && ($options_select != "rand") && ($options_select != "rotate")) {
			$options_select = $config_select;
		}
		$config_contents = <<<TXT
{start_php}
\$config_sqlhost = "$config_sqlhost";
\$config_sqldb = "$config_sqldb";
\$config_sqltable = "$config_sqltable";
\$config_sqluser = "$config_sqluser";
\$config_sqlpass = "$config_sqlpass";
\$config_path = "$config_path";
\$config_skin = "$options_skin";
\$config_iframeskin = "$options_iframeskin";
\$config_flashskin = "$options_flashskin";
\$config_statprotect = "$options_statprotect";
\$config_select = "$options_select";
?>
TXT;
		$config_contents = str_replace("
","
",$config_contents);
		if (@fwrite(@fopen("config/config.php","w"),$config_contents)) {
			header("Location: $PHP_SELF?result=success");
			exit();
		}
		else {
			$error = "couldn't edit options [ " . php_error() . " ]";
			header("Location: $PHP_SELF?result=fail&error=$error");
			exit();
		}
	}
	elseif ($act == "stats") {
		if ($id == "public") {
			$temp_files = array("public","publicentry");
			$temp_content = array($stats_public,$stats_publicentry);
		}
		elseif ($id == "private") {
			$temp_files = array("login","private");
			$temp_content = array($stats_login,$stats_private);
		}
		elseif ($id == "vars") {
			$temp_files[0] = "vars";
			$temp_content[0] = $stats_vars;
		}
		for ($i=0;$temp_files[$i];$i++) {
			if (!@fwrite(@fopen("config/stats_" . $temp_files[$i] . ".php","w"),stripslashes($temp_content[$i]))) {
				$error = "couldn't edit skin [ " . php_error() . " ]";
				header("Location: $PHP_SELF?result=fail&error=$error");
				exit();
			}
		}
		header("Location: $PHP_SELF?result=success");
		exit();
	}
	else {
		if ($result == "success") {
			$result = "Action was successfully carried out.";
		}
		elseif ($result == "fail") {
			$result = "Action failed, " . $error . "<br /><br />" . $query;
		}
		elseif ($result) {
			unset($result);
		}
		$sql_query = <<<SQL
SELECT ad_id, ad_name, ad_url, ad_link, ad_pass, ad_type FROM $config_sqltable
SQL;
		$sql_result = doSQL($sql_query,0);
		while ($row = @mysql_fetch_row($sql_result)) {
			list($row_id,$row_name,$row_url,$row_link,$row_pass,$row_type) = $row;
			$row_namesl = addslashes($row_name);
			if ($row_pass) {
				$row_pass = "<br />Password exists";
			}
			if ($row_type == "iframe") {
				$content_adlist .= <<<HTML
<tr><td>$row_id</td><td>$row_name</td><td>I-frame at<br /><a href="$row_url">$row_url</a></td><td><a href="#edit" onClick="getDetails($row_id,'$row_namesl','$row_url','$row_link',1)">Edit</a>
<br />
<a href="$PHP_SELF?act=delete&id=$row_id">Remove</a>$row_pass
</td></tr>
HTML;
			}
			elseif ($row_type == "flash") {
				$content_adlist .= <<<HTML
<tr><td>$row_id</td><td>$row_name</td><td>Shockwave Flash<br /><a href="$row_url">$row_url</a></td><td><a href="#edit" onClick="getDetails($row_id,'$row_namesl','$row_url','$row_link',2)">Edit</a>
<br />
<a href="$PHP_SELF?act=delete&id=$row_id">Remove</a>$row_pass
</td></tr>
HTML;
			}
			else {
				$content_adlist .= <<<HTML
<tr><td>$row_id</td><td>$row_name</td><td><a href="$row_link"><img src="$row_url" title="$row_name"></a></td><td><a href="#edit" onClick="getDetails($row_id,'$row_namesl','$row_url','$row_link',0)">Edit</a>
<br />
<a href="$PHP_SELF?act=delete&id=$row_id">Remove</a>$row_pass
</td></tr>
HTML;
			}
		}
		if ($row_id) {
			$content_adlist = <<<HTML
<tr class="title"><td>ID</td><td>Title</td><td>Banner Preview</td><td>Function</td></tr>
$content_adlist
HTML;
		}
		else {
			$content_adlist = <<<HTML
<tr><td>No ads currently</td></tr>
HTML;
		}
		$options_config_skin = htmlspecialchars(stripslashes($config_skin));
		$options_config_iframeskin = htmlspecialchars(stripslashes($config_iframeskin));
		$options_config_flashskin = htmlspecialchars(stripslashes($config_flashskin));
		if ($config_statprotect == "yes") {
			$temp_statprotect = " CHECKED";
		}
		${temp_select_.$config_select} = " SELECTED";
		$config_statspublic = getFile("config/stats_public.php");
		$config_statspublicentry = getFile("config/stats_publicentry.php");
		$config_statslogin = getFile("config/stats_login.php");
		$config_statsprivate = getFile("config/stats_private.php");
		$config_statsvars = getFile("config/stats_vars.php");
		$content = <<<HTML
<a href="#exist">Existing Ads</a> :: <a href="#add">Add Ad</a> :: <a href="#edit">Edit Ad</a> :: <a href="#options">Program Options</a> :: <a href="#stats">Skin Settings</a> :: <a href="#instructions">Instructions</a> :: <a href="$PHP_SELF?act=logout">Log Out</a> :: <a href="http://www.hotscripts.com/rate/28438.html" target="_blank">Rate mAd on Hotscripts.com</a>
<br /><br />
$result
<a name="exist" />
<fieldset>
<legend>Existing ads</legend>
<table cellspacing="0">
$content_adlist
</table>
</fieldset>
<br />
<a name="add" />
<fieldset>
<legend>Add a new ad banner</legend>
<form action="$PHP_SELF" method="post" name="add">
<input type="hidden" name="act" value="add">
<input type="text" name="add_name" value="Title" title="Ad title" size="50">&nbsp;<input type="text" name="add_url" value="URL" title="Image/frame URL" size="50">
<br />
<input type="text" name="add_link" value="Link" title="Link URL" size="50">&nbsp;<input type="text" name="add_pass" value="Statistics password" title="Stats protection password" size="50">
<br />
Type of ad: <input type="radio" name="add_type" value="image" onChange="setURLInput()" checked> Image, <input type="radio" name="add_type" value="iframe" onChange="setURLInput()"> Inline frame, <input type="radio" name="add_type" value="flash" onChange="setURLInput()"> Flash movie
<br />
<input type="submit" value="Add Banner">
</form>
</fieldset>
<br />
<a name="edit" />
<fieldset>
<legend>Edit an existing ad</legend>
<form action="$PHP_SELF" method="post" name="edit">
<input type="hidden" name="act" value="edit">
<input type="hidden" name="id" value="0">
<input type="text" name="edit_name" value="Title" title="Ad title" size="50" disabled>&nbsp;<input type="text" name="edit_url" value="URL" title="Image URL" size="50" disabled>
<br />
<input type="text" name="edit_link" value="Link" title="Link URL" size="50" disabled>&nbsp;<input type="text" name="edit_pass" value="Statistics password" title="Stats protection password" size="50" disabled>
<br />
Edit statistics password: <input type="checkbox" name="edit_editpass" value="yes" onChange="setPassInput()" disabled> (submit a blank text box to remove password)
<br />
Type of ad: <input type="radio" name="edit_type" value="image" onChange="setURLInput()"$temp_type_image disabled> Image, <input type="radio" name="edit_type" value="iframe" onChange="setURLInput()"$temp_type_iframe disabled> Inline frame, <input type="radio" name="edit_type" value="flash" onChange="setURLInput()"$temp_type_flash disabled> Flash movie
<br />
<input type="submit" name="edit_button" value="Edit Banner" disabled>
</form>
</fieldset>
<br />
<a name="options" />
<fieldset>
<legend>Program Options</legend>
<form action="$PHP_SELF" method="post" name="options">
<input type="hidden" name="act" value="options">
Format for display of image ads: <input type="text" size="70" name="options_skin" value="$options_config_skin">
<br />
Format for display of iframe ads: <input type="text" size="70" name="options_iframeskin" value="$options_config_iframeskin">
<br />
Format for display of Flash ads: <input type="text" size="70" name="options_flashskin" value="$options_config_flashskin">
<br />
Codes: <b>[title]</b> ad title, <b>[image]</b> URL of the ad, <b>[link]</b> URL to link to.
<br /><br />
Method of selecting advert to show : <select name="options_select"><option value="time"$temp_select_time> Time <option value="rand"$temp_select_rand> Random <option value="rotate"$temp_select_rotate> Rotation </select>
<br />
Time - The method used in mAd v0.3 and lower. This selects the ad based on what second the visitor calls the page. Each second calls a different ad and it loops once every ad has "had" a second.
<br />
Random - This method uses PHP's rand function to select an ad randomly.
<br />
Rotation - This is a true ad rotation - a value is set in the database to show the last ad shown, then it shows the next ad, and loops to the first ad after each one has been shown.
<br /><br />
Enable statistics protection: <input type="checkbox" name="options_statprotect" value="yes"$temp_statprotect>
<br />
Enabling stat protection stops public access of stats.php. A password - set for each ad - is required.
<br /><br />
<input type="submit" name="options_button" value="Change Options">
</form>
</fieldset>
<br />
<a name="stats" />
<fieldset>
<legend>Statistics Skins</legend>
<form action="$PHP_SELF" method="post" name="stats">
<input type="hidden" name="act" value="stats">
<input type="hidden" name="id" value="public">
<b>Public Mode Stats</b>
<br /><br />
Overall Statistics skin
<br />
<textarea name="stats_public" cols="70" rows="20">$config_statspublic</textarea>
<br />
Code: <b>[stats]</b> show statistics rows
<br /><br />
Ad Statistics (repeats for each ad at <b>[stats]</b> above)
<br />
<textarea name="stats_publicentry" cols="70" rows="5">$config_statspublicentry</textarea>
<br />
Codes: <b>[id]</b> ad ID, <b>[title]</b> ad title, <b>[image]</b> ad URL, <b>[link]</b> ad link, <b>[time]</b> time ad was added (Unix timestamp) <b>[views]</b> number of views, <b>[clicks]</b> number of clicks, <b>[display]</b> show the ad using the same code as the ads themselves.
<br /><br />
<input type="submit" name="public_button" value="Update Public Skin">
</form>
<br /><br />
<hr>
<br />
<form action="$PHP_SELF" method="post" name="stats">
<input type="hidden" name="act" value="stats">
<input type="hidden" name="id" value="private">
<b>Stats Protection Mode Stats</b>
<br /><br />
Advertiser Login skin
<br />
<textarea name="stats_login" cols="70" rows="20">$config_statslogin</textarea>
<br />
Code: <b>[id]</b> ID login box, <b>[pass]</b> password login box, <b>[submit]</b> submit button
<br /><br />
Private Statistics skin
<br />
<textarea name="stats_private" cols="70" rows="20">$config_statsprivate</textarea>
<br />
Codes: <b>[id]</b> ad ID, <b>[title]</b> ad title, <b>[image]</b> ad URL, <b>[link]</b> ad link, <b>[time]</b> time ad was added (Unix timestamp) <b>[views]</b> number of views, <b>[clicks]</b> number of clicks, <b>[display]</b> show the ad using the same code as the ads themselves.
<br /><br />
<input type="submit" name="private_button" value="Update Private Skin">
</form>
<br /><br />
<hr>
<br />
<form action="$PHP_SELF" method="post" name="stats">
<input type="hidden" name="act" value="stats">
<input type="hidden" name="id" value="vars">
<b>Customisable Variables (advanced users only)</b>
<br /><br />
<textarea name="stats_vars" cols="70" rows="20">$config_statsvars</textarea>
<br />
Use this area to set variables - for example <b>[ratio]</b> - for use in the Ad Statistics and Private Statistics skins. Use PHP-style equations (for example <b>time()</b>), and reference the time/views/clicks using <b>[time]</b> etc. One per line.
<br />
Format: <b>[variable] = equation;</b>
<br /><br />
<input type="submit" name="vars_button" value="Update Variables">
</form>
</fieldset>
<br />
<a name="instructions" />
<fieldset style="text-align: left">
<legend>Instructions</legend>
<form></form>
1: To add an advert to the rotation, type in the title of the site/ad, the image's URL, and the URL to link to in the Add area above, and click the submit button. For I-Frames and Flash movies, leave "Link" blank, and put the URL of the page or movie in the "URL" textbox.
<br /><br />
2: To edit an advert, click the "Edit" link in the banner list at the top, and then edit the details in the Edit area above.
<br /><br />
3: To remove an advert, click the "Remove" link in the banner list.
<br /><br />
Put ads on your page:
<list>
<ol>PHP inclusion - The page you display the ad on must have a .php extension. Include $config_path/include.php using PHP (for example, <b>&lt;?php include "$config_path/include.php"; ?></b>). The rest will be taken care of by mAd.</ol>
<ol>Javascript - Can be used on any page, but the client must have Javascript enabled. Use this code: <b>&lt;script language="Javascript" src="$config_path/include.php?js"></script></b>.</ol>
<ol>Inline Frame - Can be used on any page, the client must support inline frames. You cannot use ads of different sizes with this method. Use this code: <b>&lt;iframe width="<i>width</i>" height="<i>height</i>" frameborder="0" scrolling="no" src="$config_path/include.php?iframe"></iframe></b>, and replace <b><i>width</i></b> and <b><i>height</i></b> with the width and height of your ads.</ol>
</list>
Statistics: A public statistics page is at <a href="stats.php">$config_path/stats.php</a>. If you have statistics protection enabled, a password (set when adding/editing ads) must be input by the user (usually the owner of the advertised site). They can login at the above link. In either mode, they can access the private stats page at <b>$config_path/stats.php?ad_id=<i>[advert id]</i>&ad_pass=<i>[password]</i></b>, where <b><i>[advert id]</i></b> is replaced with the ID of that ad and <b><i>[password]</i></b> is the password you set here. If stats protection is enabled, the admin can access the public stats page at <b>$config_path/stats.php?user=<i>[username]</i>&pass=<i>[password]</i></b> using your mAd login details. You can also include stats.php into your site through PHP.
<br /><br />
Alternate ad selection: -Advanced-&nbsp;&nbsp;If you can code PHP (and preferably SQL), you can use your own method of selecting which ad to show. In the page(s) you would call <b>include.php</b> from, all you need to do is make sure the <b>&#36;mad_id</b> variable is set to a valid ad ID number before you call include.php. This only works for PHP inclusion.
</fieldset>
<script language="Javascript">
function getDetails(id,name,url,link,type) {
	document.edit.id.value = id;
	document.edit.edit_name.value = name;
	document.edit.edit_url.value = url;
	document.edit.edit_link.value = link;
	document.edit.edit_type[type].checked = true;
	document.edit.edit_name.disabled = false;
	document.edit.edit_url.disabled = false;
	document.edit.edit_link.disabled = false;
	document.edit.edit_button.disabled = false;
	document.edit.edit_editpass.disabled = false;
	document.edit.edit_type[0].disabled = false;
	document.edit.edit_type[1].disabled = false;
	document.edit.edit_type[2].disabled = false;
	setURLInput();
}
function setPassInput() {
	if (document.edit.edit_editpass.checked == true) {
		document.edit.edit_pass.disabled = false;
	}
	else {
		document.edit.edit_pass.disabled = true;
	}
}
function setURLInput() {
	if (document.add.add_type[0].checked == false) {
		document.add.add_link.disabled = true;
	}
	else {
		document.add.add_link.disabled = false;
	}
	if (document.edit.edit_type[0].checked == false) {
		document.edit.edit_link.disabled = true;
	}
	else {
		document.edit.edit_link.disabled = false;
	}
}

</script>
HTML;
	}
}
print <<<HTML
<html>
<head>
<title>mAd - I got ad skillz</title>
<style type="text/css">
body, table { text-align: center; font-family: Arial, sans-serif }
fieldset { width: 80%; text-align: center; margin-left: auto; margin-right: auto }
table { width: 90% }
table, table td { border: 1px solid black; margin-left: auto; margin-right: auto }
tr.title td { background-color: black; color: white; font-weight: bold }
img { border: none }
a { color: black }
hr { width: 30% }
</style>
</head>
<body>
<span style="font-size: 400%; font-weight: bold">mAd</span><br /><span style="font-size: 150%">Advert Rotation Manager</span>
<br /><br />
$content
<br /><br />
<font size="-1"><a href="http://www.w00ty.com/mad">mAd</a> Advert Rotation Manager v$mad_version created by and Copyright &copy; 2003-2005 <a href="http://www.ianbennett.net">Ian Bennett</a>.</font>
</body>
</html>
HTML;
unset($GLOBALS);
?>
<?php
$file['index.php'] = get_content();


// INCLUDE.PHP
?>
{start_php}
///////////////////////////////////
// mAd - Advert Rotation Manager //
///////////////////////////////////
// Version 0.5                  //
// 29 Jan 05                     //
// include.php                   //
///////////////////////////////////
// Created by Ian Bennett        //
// ian at ianbennett dot net     //
// w3 dot ianbennett dot net     //
///////////////////////////////////
foreach ($_GET as $key => $val) $$key = $val;
$mad_include_name = "config/config.php";
$mad_include_script = $SCRIPT_NAME;
$mad_include_dirnum = 1;
$mad_include_bars = count(explode("/",$script))-($mad_include_dirnum+2);
$mad_include_path = "";
if ($mad_include_bars > 0){
	for ($i=0; $i < $mad_include_bars; $i++) {
		$mad_include_path .= "../";
	}
}
require $mad_include_path . $mad_include_name;

unset($mad_error);

if (!$mad_sql_connect = @mysql_connect("$config_sqlhost", "$config_sqluser", "$config_sqlpass")) {
	$mad_error = "Login error [ " . mysql_error() . " ]";
}
else {
	if (!@mysql_select_db("$config_sqldb")) {
		$mad_error = "DB error [ " . mysql_error() . " ]";
	}
	else {
		if (!$mad_id) {
			$mad_sql_query1 = <<<SQL
SELECT * FROM $config_sqltable
SQL;
			if ($mad_sql_result = @mysql_query($mad_sql_query1)) {
				if (!$mad_ad_count = @mysql_num_rows($mad_sql_result)) {
					$mad_error = "Count error [ " . mysql_error() . " ]";
				}
			}
			else {
				$mad_error = "Count query error [ " . mysql_error() . " ]";
			}
			if ($config_select == "rand") {
				$mad_sql_number = rand(0,($mad_ad_count - 1));
			}
			elseif ($config_select == "rotate") {
				$mad_sql_query_rot = <<<SQL
SELECT ad_id FROM $config_sqltable WHERE ad_current=1 LIMIT 1
SQL;
				if ($mad_sql_result = @mysql_query($mad_sql_query_rot)) {
					$mad_last = @mysql_result($mad_sql_result,0);
					if (!$mad_last) {
						$mad_last = 0;
						$mad_error = "Last ad error (couldn't find last ad), used first ad instead [ " . mysql_error() . " ]";
					}
				}
				else {
					$mad_error = "Last ad query error [ " . mysql_error() . " ]";
				}
				$mad_sql_query_rot2 = <<<SQL
SELECT ad_id FROM $config_sqltable WHERE ad_id > $mad_last LIMIT 1
SQL;
				if ($mad_sql_result = @mysql_query($mad_sql_query_rot2)) {
					$mad_id = @mysql_result($mad_sql_result,0);
					if (!$mad_id) {
						$mad_sql_query_rot3 = <<<SQL
SELECT ad_id FROM $config_sqltable WHERE ad_id > 0 LIMIT 1
SQL;
						if ($mad_sql_result = @mysql_query($mad_sql_query_rot3)) {
							if (!$mad_id = @mysql_result($mad_sql_result,0)) {
								$mad_error = "Current ad error [ " . mysql_error() . " ]";
							}
						}
						else {
							$mad_error = "Current ad query error [ " . mysql_error() . " ]";
						}
					}
				}
				else {
					$mad_error = "Current ad query error [ " . mysql_error() . " ]";
				}
				$mad_sql_query_rot4 = <<<SQL
UPDATE $config_sqltable SET ad_current=0
SQL;
				if (!@mysql_query($mad_sql_query_rot4)) {
					$mad_error = "Last ad reset error [ " . mysql_error() . " ]";
				}
				$mad_sql_query_rot5 = <<<SQL
UPDATE $config_sqltable SET ad_current=1 WHERE ad_id=$mad_id
SQL;
				if (!@mysql_query($mad_sql_query_rot5)) {
					$mad_error = "Current ad log error [ " . mysql_error() . " ]";
				}
			}
			else {
				$mad_sql_number = (time() % $mad_ad_count);
			}
			if ($config_select != "rotate") {
				$mad_sql_query2 = <<<SQL
SELECT ad_id FROM $config_sqltable
SQL;
				if ($mad_sql_result = @mysql_query($mad_sql_query2)) {
					if (!$mad_id = @mysql_result($mad_sql_result,$mad_sql_number)) {
						$mad_error = "ID error [ " . mysql_error() . " ]";
					}
				}
				else {
					$mad_error = "ID query error [ " . mysql_error() . " ]";
				}
			}
		}
		$mad_sql_query3 = <<<SQL
SELECT ad_name, ad_url, ad_views, ad_type FROM $config_sqltable WHERE ad_id=$mad_id
SQL;
		if ($mad_sql_result = @mysql_query($mad_sql_query3)) {
			if (!$mad_sql_row = @mysql_fetch_row($mad_sql_result)) {
				$mad_error = "Data error [ " . mysql_error() . " ]";
			}
		}
		else {
			$mad_error = "Data query error [ " . mysql_error() . " ]";
		}
		list($mad_name,$mad_url,$mad_views,$mad_type) = $mad_sql_row;
		if ($mad_type == "iframe") {
			$config_skin = $config_iframeskin;
		}
		elseif ($mad_type == "flash") {
			$config_skin = $config_flashskin;
		}
		$mad_views++;
		$mad_sql_query4 = <<<SQL
UPDATE $config_sqltable SET ad_views=$mad_views WHERE ad_id=$mad_id
SQL;
		if (!@mysql_query($mad_sql_query4)) {
			$mad_error = "View increment error [ " . mysql_error() . " ]";
		}
	}
	@mysql_close($mad_sql_connect);
	if ($mad_error) {
		$mad_output = "An SQL error has occurred.<br /><br />" . $mad_error;
	}
	else {
		$mad_skin_find = array(
"[title]", "[image]", "[link]"
);
		$mad_skin_replace = array(
$mad_name, $mad_url, $config_path . "/out.php?id=" . $mad_id
);
		$mad_skin = str_replace($mad_skin_find, $mad_skin_replace, $config_skin);
		$mad_output = $mad_skin;

		print (($_GET['js'] == '') && (isset($_GET['js']))) ? "document.write('" . str_replace("'", "\'", $mad_output) . "');" : $mad_output." <!-- Ad powered by mAd - www.w00ty.com/mad --> ";
	}
}

unset($mad_include_name,$mad_include_script,$mad_include_dirnum,$mad_include_bars,$mad_include_path,$mad_error,$mad_sql_connect,$mad_sql_query1,$mad_sql_result,$mad_ad_count,$mad_sql_number,$mad_sql_query2,$mad_id,$mad_sql_query3,$mad_sql_row,$mad_name,$mad_url,$mad_views,$mad_sql_query4,$file_content,$mad_skin_find,$mad_skin_replace,$mad_skin,$config_sqlhost,$config_sqldb,$config_sqltable,$config_sqluser,$config_sqlpass,$config_path,$config_skin,$mad_sql_query_rot,$mad_sql_query_rot2,$mad_sql_query_rot3,$mad_sql_query_rot4,$mad_sql_query_rot5,$mad_last);

?>
<?php
$file['include.php'] = get_content();


// OUT.PHP
?>
{start_php}
///////////////////////////////////
// mAd - Advert Rotation Manager //
///////////////////////////////////
// Version 0.4                   //
///////////////////////////////////
// Created by Ian Bennett        //
// ian at ianbennett dot net     //
// w3 dot ianbennett dot net     //
///////////////////////////////////
foreach ($_GET as $key => $val) $$key = $val;
require "config/config.php";
if (!@$sql_connect = mysql_connect("$config_sqlhost", "$config_sqluser", "$config_sqlpass")) {
	$error = "Login error [ " . mysql_error() . " ]";
}
else {
	if (!@mysql_select_db("$config_sqldb")) {
		$error = "DB error [ " . mysql_error() . " ]";
	}
	else {
		$sql_query1 = <<<SQL
SELECT ad_link, ad_clicks FROM $config_sqltable WHERE ad_id=$id
SQL;
		if ($sql_result = @mysql_query($sql_query1)) {
			if (!$sql_row = @mysql_fetch_row($sql_result)) {
				$error = "Data error [ " . mysql_error() . " ]";
			}
			else {
				list($link,$clicks) = $sql_row;
				$clicks++;
				$sql_query2 = <<<SQL
UPDATE $config_sqltable SET ad_clicks=$clicks WHERE ad_id=$id
SQL;
				if (!@mysql_query($sql_query2)) {
					$mad_error = "Click increment error [ " . mysql_error() . " ]";
				}
			}
		}
		else {
			$error = "Data query error [ " . mysql_error() . " ]";
		}
	}
}
if ($error) {
	print "An SQL error has occurred.<br /><br />" . $error;
}
else {
	header("Location: " . $link);
}
unset($GLOBALS);
?>
<?php
$file['out.php'] = get_content();


// STATS.PHP
?>
{start_php}
///////////////////////////////////
// mAd - Advert Rotation Manager //
///////////////////////////////////
// Version 0.4                   //
///////////////////////////////////
// Created by Ian Bennett        //
// ian at ianbennett dot net     //
// w3 dot ianbennett dot net     //
///////////////////////////////////
foreach ($_POST as $key => $val) $$key = $val;
foreach ($_GET as $key => $val) if (!$$key) $$key = $val;
$mad_include_script = $SCRIPT_NAME;
$mad_include_dirnum = 1;
$mad_include_bars = count(explode("/",$mad_script))-($mad_include_dirnum+2);
$mad_include_path = "";
if ($mad_include_bars > 0){
	for ($mad_i=0; $mad_i < $mad_mad_include_bars; $mad_i++) {
		$mad_include_path .= "../";
	}
}
require $mad_include_path . "config/config.php";
require $mad_include_path . "config/user.php";
$mad_lines = file($mad_include_path . "config/stats_vars.php");
unset($mad_error);

function getFile($file) {
	$content = str_replace("
","",implode("",file($file)));
	return $content;
}
$mad_invalid = array("assert_options","call_user_func","call_user_func_array","call_user_method","call_user_method_array","chdir","chgrp","chmod","chown","chroot","constant","copy","define_syslog_variables","dir","diskfreespace","disk_free_space","disk_total_space","dl","error_log","eval","exec","explode","flush","fopen","fsockopen","fstat","get","glob","header","headers_sent","highlight_file","ignore_user_abort","import_request_variables","include","iptcembed","is_callable","is_executable","is_link","is_object","is_readable","is_uploaded_file","is_writable","is_writeable","link","linkinfo","lstat","mail","md5_file","memory_get_usage","mkdir","move_uploaded_file","opendir","openlog","output_add_rewrite_var","output_reset_rewrite_vars","parse_ini_file","passthru","pfsockopen","phpcredits","phpinfo","phpversion","php_ini_scanned_files","php_sapi_name","php_uname","proc_open","putenv","readfile","readlink","register_shutdown_function","register_tick_function","rename","require","rewinddir","rmdir","setcookie","set_file_buffer","set_include_path","set_time_limit","sha1_file","socket_set_blocking","socket_set_timeout","sort","srand","stat","stream_context_create","stream_context_get_options","stream_context_set_option","stream_context_set_params","stream_filter_append","stream_filter_prepend","stream_select","stream_set_blocking","stream_set_timeout","stream_set_write_buffer","stream_wrapper_register","symlink","syslog","system","tempnam","tmpfile","touch","umask","unlink","unpack","unregister_tick_function","unserialize","usleep","var_dump","aolserver_","apache_","apache2filter_","apache2handler_","array_","bcmath_","bz2_","calendar_","com_","cpdf_","crack_","ctype_","curl_","cyrus_","db_","dba_","dbase_","dbx_","dio_","domxml_","exif_","fbsql_","fdf_","file_","filepro_","fribidi_","ftp_","gd_","gettext_","gmp_","hyperwave_","iconv_","imap_","informix_","ingres_ii_","ini_","interbase_","ircg_","java_","ldap_","mbstring_","mcal_","mcrypt_","mcve_","mhash_","mime_magic_","ming_","mnogosearch_","msession_","msql_","mssql_","mysql_","ncurses_","notes_","nsapi_","ob_","oci8_","odbc_","openssl_","oracle_","overload_","ovrimos_","pcntl_","pcre_","pdf_","pfpro_","pgsql_","posix_","pspell_","qtdom_","readline_","recode_","session_","shmop_","snmp_","sockets_","swf_","sybase_","sysvmsg_","sysvsem_","sysvshm_","tokenizer_","wddx_","xml_","xmlrpc_","xslt_","yaz_","yp_","zip_","zlib_");

if (($ad_id && $ad_pass) || $config_statprotect == "no" || ((md5($user) == $config_user) && (md5($pass) == $config_pass))) {

	if (!$mad_sql_connect = @mysql_connect("$config_sqlhost", "$config_sqluser", "$config_sqlpass")) {
		$mad_error = "Login error [ " . mysql_error() . " ]";
	}
	else {
		if (!@mysql_select_db("$config_sqldb")) {
			$mad_error = "DB error [ " . mysql_error() . " ]";
		}
		else {
			if ($ad_id && $ad_pass) {
				$mad_sql_query = <<<SQL
SELECT ad_pass FROM $config_sqltable WHERE ad_id=$ad_id
SQL;
				if ($mad_sql_result = @mysql_query($mad_sql_query)) {
					if (md5($ad_pass) == mysql_result($mad_sql_result,0)) {
						$mad_sql_query = <<<SQL
SELECT ad_id, ad_name, ad_url, ad_link, ad_views, ad_clicks, ad_time, ad_type FROM $config_sqltable WHERE ad_id=$ad_id
SQL;
						if ($mad_row = @mysql_fetch_row(@mysql_query($mad_sql_query))) {
							list($mad_row_id,$mad_row_name,$mad_row_url,$mad_row_link,$mad_row_views,$mad_row_clicks,$mad_row_time,$mad_row_type) = $mad_row;
							if ($mad_row_type == "iframe") {
								$mad_temp = $config_iframeskin;
							}
							elseif ($mad_row_type == "flash") {
								$mad_temp = $config_flashskin;
							}
							else {
								$mad_temp = $config_skin;
							}
							$mad_find = array("[display]","[id]","[title]","[image]","[link]","[views]","[clicks]","[time]");
							$mad_replace = array($mad_temp,$mad_row_id,$mad_row_name,$mad_row_url,$mad_row_link,$mad_row_views,$mad_row_clicks,$mad_row_time);
							foreach ($mad_lines as $mad_key => $mad_line) {
								if ($mad_line[0] == "[") {
									$mad_error = 0;
									foreach ($mad_invalid as $invalid) {
										if (preg_match("/" . $invalid . "/i",$mad_line)) {
											print "ERROR: Variable uses an invalid command ($invalid). [ $mad_line ]<br />";
											$mad_error = 1;
										}
									}
									if ($mad_error == 0) {
										$mad_words = explode(" ",$mad_line);
										$mad_line = str_replace(array('$','[',']'),array('','$mad_row_',''),$mad_line);
										@eval($mad_line);
										$mad_find2[$mad_key] = $mad_words[0];
										$mad_words = str_replace(array('$','[',']'),array('','mad_row_',''),$mad_words[0]);
										$mad_replace2[$mad_key] = ${$mad_words};
									}
								}
								else {
									if (($mad_line[0] != "/" || $mad_line[1] != "/") && (trim($mad_line))) {
										print "ERROR: Does not set a variable. [ $mad_line ]<br />";
									}
								}
							}
							$mad_content = str_replace($mad_find,$mad_replace,getFile($mad_include_path . "config/stats_private.php"));
							print str_replace($mad_find2,$mad_replace2,$mad_content);
						}
						else {
							$mad_error = "Data query error [ " . mysql_error() . " ]";
						}
					}
					else {
						$mad_error = "Login error. please check your ID and password.";
					}
				}
				else {
					$mad_error = "Data query error [ " . mysql_error() . " ]";
				}
			}
			else {
				$mad_sql_query = <<<SQL
SELECT ad_id, ad_name, ad_url, ad_link, ad_views, ad_clicks, ad_time, ad_type FROM $config_sqltable
SQL;
				if ($mad_sql_result = @mysql_query($mad_sql_query)) {
					while ($mad_row = @mysql_fetch_row($mad_sql_result)) {
					list($mad_row_id,$mad_row_name,$mad_row_url,$mad_row_link,$mad_row_views,$mad_row_clicks,$mad_row_time,$mad_row_type) = $mad_row;
						if ($mad_row_type == "iframe") {
							$mad_temp = $config_iframeskin;
						}
						elseif ($mad_row_type == "flash") {
							$mad_temp = $config_flashskin;
						}
						else {
							$mad_temp = $config_skin;
						}
						$mad_find = array("[display]","[id]","[title]","[image]","[link]","[views]","[clicks]","[time]");
						$mad_replace = array($mad_temp,$mad_row_id,$mad_row_name,$mad_row_url,$mad_row_link,$mad_row_views,$mad_row_clicks,$mad_row_time);
						foreach ($mad_lines as $mad_key => $mad_line) {
							if ($mad_line[0] == "[") {
								$mad_error = 0;
								foreach ($mad_invalid as $invalid) {
									if (preg_match("/" . $invalid . "/i",$mad_line)) {
										print "ERROR: Variable uses an invalid command ($invalid). [ $mad_line ]<br />";
										$mad_error = 1;
									}
								}
								if ($mad_error == 0) {
									$mad_line = "$mad_line";
									$mad_words = explode(" ",$mad_line);
									$mad_line = str_replace(array('$','[',']'),array('&#36;','$mad_row_',''),$mad_line);
									@eval($mad_line);
									$mad_find2[$mad_key] = $mad_words[0];
									$mad_words = str_replace(array('$','[',']'),array('&#36;','mad_row_',''),$mad_words[0]);
									$mad_replace2[$mad_key] = ${$mad_words};
								}
							}
							else {
								if (($mad_line[0] != "/" || $mad_line[1] != "/") && (trim($mad_line))) {
									print "ERROR: Does not set a variable. [ $mad_line ]<br />";
								}
							}
						}
						$mad_content = str_replace($mad_find,$mad_replace,getFile($mad_include_path . "config/stats_publicentry.php"));
						$mad_content = str_replace($mad_find2,$mad_replace2,$mad_content);
						$mad_content_adlist .= $mad_content;
					}
					print str_replace("[stats]",$mad_content_adlist,getFile($mad_include_path . "config/stats_public.php"));
				}
				else {
					$mad_error = "Data query error [ " . mysql_error() . " ]";
				}
			}

		}
		if ($mad_error) {
			print $mad_error;
		}
	}
}

else {
	$mad_find = array("[id]","[pass]","[submit]");
	$mad_replace = array(
'<form action="' . $PHP_SELF . '" method="post" name="login"><input type="text" name="ad_id" value="' . $ad_id . '">',
'<input type="password" name="ad_pass">',
'<input type="submit" value="Login"></form>'
);
	print str_replace($mad_find,$mad_replace,getFile($mad_include_path . "config/stats_login.php"));
}

unset($mad_include_name,$mad_include_script,$mad_include_dirnum,$mad_include_bars,$mad_include_path,$config_sqlhost,$config_sqldb,$config_sqltable,$config_sqluser,$config_sqlpass,$config_path,$config_skin,$mad_sql_connect,$mad_sql_query,$mad_sql_result,$mad_row,$mad_row_clicks,$mad_row_views,$mad_row_link,$mad_row_url,$mad_row_name,$mad_row_id,$mad_row_namesl,$mad_content_adlist,$mad_invalid,$mad_lines,$mad_line,$mad_words,$mad_content,$mad_find,$mad_replace,$mad_find2,$mad_replace2,$config_statprotect,$mad_row_time,$mad_error,$invalid,$mad_key,$mad_temp);

?>
<?php
$file['stats.php'] = get_content();


// CONFIG/CONFIG.PHP
?>
{start_php}
$config_sqlhost = "<?php print $_REQUEST['sql_host']; ?>";
$config_sqldb = "<?php print $_REQUEST['sql_db']; ?>";
$config_sqltable = "mad";
$config_sqluser = "<?php print $_REQUEST['sql_user']; ?>";
$config_sqlpass = "<?php print $_REQUEST['sql_pass']; ?>";
$config_path = "<?php print $install_path; ?>";
$config_skin = "<a href=\"[link]\"><img src=\"[image]\" title=\"[title]\" border=\"0\"></a>";
$config_iframeskin = "<iframe src=\"[image]\" frameborder=\"0\" width=\"468\" height=\"60\"></iframe>";
$config_flashskin = "<embed src=\"[image]\" width=\"468\" height=\"60\"></embed>";
$config_statprotect = "no";
$config_select = "rotate";
?>
<?
$file['config/config.php'] = get_content();


// CONFIG/STATS_LOGIN.PHP
?>
<html>
<head>
<title>Ad Statistics: User Login</title>
<style type="text/css">
body, table { text-align: center; font-family: Arial, sans-serif }
fieldset { width: 80%; text-align: center; margin-left: auto; margin-right: auto }
table { width: 90% }
table, table td { border: 1px solid black; margin-left: auto; margin-right: auto }
tr.title td { background-color: black; color: white; font-weight: bold }
input { width: 10% }
img { border: none }
a { color: black }
</style>
</head>
<body>
<span style="font-size: 400%; font-weight: bold">mAd</span><br /><span style="font-size: 150%">Advert Rotation Manager</span>
<br /><br />
<h3>Statistics Login</h3>
Please enter the ID of your ad and the password you received from the site admin.
<br /><br />
[id] Advert ID
<br />
[pass] Password
<br />
[submit]
</form>
<br />
<font size="-1"><a href="http://www.w00ty.com/mad">mAd</a> Advert Rotation Manager created by and Copyright © 2003-2005 <a href="http://www.ianbennett.net">Ian Bennett</a></font>
</body>
</html>
<?php
$file['config/stats_login.php'] = get_content();


// CONFIG/STATS.PHP
?>
<html>
<head>
<title>mAd - I got ad skillz</title>
<style type="text/css">
body, table { text-align: center; font-family: Arial, sans-serif }
fieldset { width: 80%; text-align: center; margin-left: auto; margin-right: auto }
table { width: 90% }
table, table td { border: 1px solid black; margin-left: auto; margin-right: auto }
tr.title td { background-color: black; color: white; font-weight: bold }
input { width: 30% }
img { border: none }
a { color: black }
</style>
</head>
<body>
<span style="font-size: 400%; font-weight: bold">mAd</span><br /><span style="font-size: 150%">Advert Rotation Manager</span>
<br /><br />
<fieldset>
<legend>Ads currently in rotation</legend>
<table cellspacing="0">
[stats]
</table>
</fieldset>
<br />
<font size="-1"><a href="http://www.w00ty.com/mad">mAd</a> Advert Rotation Manager created by and Copyright &copy; 2003-2005 <a href="http://www.ianbennett.net">Ian Bennett</a></font>
</body>
</html>
<?php
$file['config/stats.php'] = get_content();


// CONFIG/STATS_PRIVATE.PHP
?>
<html>
<head>
<title>Ad Statistics</title>
<style type="text/css">
body { text-align: center }
body, table { font-family: Arial, sans-serif }
fieldset { width: 80%; text-align: center; margin-left: auto; margin-right: auto }
table { width: 90% }
table, table td { border: none; margin-left: auto; margin-right: auto }
tr.title td { background-color: black; color: white; font-weight: bold }
input { width: 30% }
img { border: none }
a { color: black }
</style>
</head>
<body>
<span style="font-size: 400%; font-weight: bold">mAd</span><br /><span style="font-size: 150%">Advert Rotation Manager</span>
<br /><br />
<fieldset>
<legend>Stats for [title]</legend>
<a href="[link]"><img src="[image]" title="[title]" border="0"></a>
<br /><br />
<table>
<tr><td align="right"><b>Ad ID:</b></td><td>[id]</td></tr>
<tr><td align="right"><b>Links to:</b></td><td><a href="[link]">[link]</a></td></tr>
<tr><td align="right"><b>Image URL:</b></td><td><a href="[image]">[image]</a></td></tr>
<tr><td align="right"><b>Views:</b></td><td>[views] ([viewsaday] a day)</td></tr>
<tr><td align="right"><b>Clicks:</b></td><td>[clicks] ([clicksaday] a day)</td></tr>
<tr><td align="right"><b>Views per click:</b></td><td>[viewsperclick]</td></tr>
<tr><td align="right"><b>Creation time:</b></td><td>[created]</td></tr>
<tr><td align="right"><b>Uptime:</b></td><td>[uptimedays] day, [uptimehrs] hr, [uptimemins] min</td></tr>
</table>
</fieldset>
<br />
<font size="-1"><a href="http://www.w00ty.com/mad">mAd</a> Advert Rotation Manager created by and Copyright © 2003-2005 <a href="http://www.ianbennett.net">Ian Bennett</a></font>
</body>
</html>
<?php
$file['config/stats_private.php'] = get_content();


// CONFIG/STATS_PUBLIC.PHP
?>
<html>
<head>
<title>Ad Statistics</title>
<style type="text/css">
body, table { text-align: center; font-family: Arial, sans-serif }
fieldset { width: 80%; text-align: center; margin-left: auto; margin-right: auto }
table { width: 90% }
table, table td { border: 1px solid black; margin-left: auto; margin-right: auto }
tr.title td { background-color: black; color: white; font-weight: bold }
input { width: 30% }
img { border: none }
a { color: black }
</style>
</head>
<body>
<span style="font-size: 400%; font-weight: bold">mAd</span><br /><span style="font-size: 150%">Advert Rotation Manager</span>
<br /><br />
<fieldset>
<legend>Currently in rotation</legend>
<table cellspacing="0">
<tr class="title"><td>Banner</td><td>Views</td><td>Clicks</td><td>Uptime</td></tr>
[stats]
</table>
</fieldset>
<br />
<font size="-1"><a href="http://www.w00ty.com/mad">mAd</a> Advert Rotation Manager created by and Copyright © 2003-2005 <a href="http://www.ianbennett.net">Ian Bennett</a></font>
</body>
</html>
<?php
$file['config/stats_public.php'] = get_content();


// CONFIG/STATS_PUBLICENTRY.PHP
?>
<tr><td>[display]</td><td>[views]<br />([viewsaday]/day)</td><td>[clicks]<br />([clicksaday]/day)</td><td>[uptimedays] day, [uptimehrs] hr</tr>
<?php
$file['config/stats_publicentry.php'] = get_content();


// CONFIG/STATS_VARS.PHP
?>
// date() stats - see php.net/date for a list of code letters
[created] = date("g:ia o\n d/m/y",[time]); // creation time, format "9:14am on 23/4/03"

// Uptime stats (time since ad was added)
[uptime] = time() - [time];  // in seconds
[uptimedays] = floor([uptime] / 86400);  // full days
[uptimehrs] = floor(([uptime] % 86400) / 3600);  // full hours since last full day
[uptimemins] = floor(([uptime] % 3600) / 60);  // full minutes since last full hour
[uptimesecs] = [uptime] % 60;  // seconds since last full minute

// View/click stats
[viewsaday] = round([views] / ([uptime] / 84000),2);  // views a day
[clicksaday] = round([clicks] / ([uptime] / 84000),2);  // clicks a day
[viewsperclick] = round([views] / [clicks],2);  // views per click
<?php
$file['config/stats_vars.php'] = get_content();


// CONFIG/USER.PHP
?>
{start_php}
$config_user = "<?php print md5($_REQUEST['username']); ?>";
$config_pass = "<?php print md5($_REQUEST['password']); ?>";
?>
<?php
$file['config/user.php'] = get_content();


// All done (finally ¬_¬)
ob_end_clean();


// Boring skin stuff
$PHP_SELF = $_SERVER['PHP_SELF'];
$skin = array(
	'make_folder'	=>	'Making folder `{FOLDER}`: <#make_folder><br />',
	'make_file'		=>	'Making file `{FILE}`: <#make_file><br />',
	'make_table'	=>	'Making table `{TABLE}`: <#make_table><br />',
	'pick_folder'	=>	'<input type="checkbox" name="create_folder[{ID}]" value="1" checked="checked" /> Create folder `{FOLDER}`?<br />',
	'pick_file'		=>	'<input type="checkbox" name="create_file[{ID}]" value="1" checked="checked" /> Create file `{FILE}`?<br />',
	'pick_table'	=>	'<input type="checkbox" name="create_table[{ID}]" value="1" checked="checked" /> Create table `{TABLE}`?<br />'
);

// Boring template
$skin['content'] = <<<HTML
<html>
<head>
<title>mAd v0.5 Installation</title>
<style type="text/css">
body { text-align: center; font-family: Arial, sans-serif }
fieldset { width: 50%; text-align: left; margin-left: auto; margin-right: auto }
a { color: black }
</style>
</head>
<body>
<span style="font-size: 400%; font-weight: bold">mAd</span><br /><span style="font-size: 150%">Advert Rotation Manager</span>
<br /><br />
{CONTENT}
</body>
</html>
HTML;

// Boring home skin
$skin['home'] = <<<HTML
<h3>Installing mAd v0.5</h3>
<form name="install_form" action="$PHP_SELF" method="post">
<input type="hidden" name="act" value="installing">
<fieldset>
<legend>Select Installation</legend>
<a href="$PHP_SELF?act=update">Update from an existing v0.4 installation</a>
<br /><br />
mAd will be updated to the new version. The login and SQL details will not be changed, and all ads will be intact. You must be using version 0.4 for an update to work - otherwise, use an earlier update pack, or make a fresh installation.
</fieldset>
<br />
<fieldset>
<legend>Login Details</legend>
<input type="text" name="username"> Admin Username
<br />
<input type="password" name="password"> Admin Password
</fieldset>
<br />
<fieldset>
<legend>Settings</legend>
The database and username/password must already exist. mAd uses a table called "mad".
<br /><br />
<input type="text" name="sql_host"> Database host location (usually "localhost")
<br />
<input type="text" name="sql_db"> SQL database to use
<br />
<input type="text" name="sql_user"> Username to log into database
<br />
<input type="password" name="sql_pass"> Password to log into database
<br />
</fieldset>
<br />
<fieldset>
<legend>Installation Options</legend>
{FOLDER_OPTIONS}
{FILE_OPTIONS}
{TABLE_OPTIONS}
</fieldset>
<br />
<fieldset>
<legend>Let's get move!</legend>
Please make sure that the folder this installer is in has a CHMOD of <b>777</b> (rwxrwxrwx) or <b>755</b> (rwxr--r--), else file installation may not work.
<br /><br />
<input type="submit" value="Continue with installation">
</fieldset>
</form>
HTML;

// Boring update skin
$skin['update'] = <<<HTML
<h3>mAd v0.5 update from v0.4</h3>
<form name="update_form" action="$PHP_SELF" method="post">
<input type="hidden" name="act" value="updating">
<fieldset>
<legend>Select Installation</legend>
<a href="$PHP_SELF">Full installation</a>
<br /><br />
mAd will be installed from scratch. You can choose which files to install, and if your SQL table already exists you can skip creation (v0.4 and v0.5 only).
</fieldset>
<br />
<fieldset>
<legend>Update Options</legend>
{FOLDER_OPTIONS}
{FILE_OPTIONS}
{TABLE_OPTIONS}
</fieldset>
<br />
<fieldset>
<legend>Let's go!</legend>
Please make sure that the folder this installer is in has a CHMOD of <b>777</b> (rwxrwxrwx) or <b>755</b> (rwxr--r--), else file installation may not work.
<br /><br />
<input type="submit" value="Continue with update">
</fieldset>
</form>
HTML;

// Boring installation skin
$skin['install'] = <<<HTML
<h3>Installing mAd</h3>
<fieldset>
<legend>Install Results</legend>
{FOLDER_DETAILS}
{FILE_DETAILS}
{TABLE_DETAILS}
</fieldset>
HTML;



// Choose what to do
switch ($_REQUEST['act']) {
	case 'installing':
		procedure_install($install);
		break;
	case 'updating':
		procedure_install($update);
		break;
	case 'update':
		procedure_home($update);
		break;
	default:
		procedure_home($install);
		break;
}




// PROCEDURES (finally!)

// Home
function procedure_home($data) {
	
	global $lang, $skin;
	
	// Make the folder content
	for ($i = 0; $data['folders'][$i]; $i++) {
		$content['folders'] .= str_replace(
			array(
				'{FOLDER}',
				'{ID}'
			),
			array(
				$data['folders'][$i],
				$i
			),
			$skin['pick_folder']
		);
	}
	
	// Make the file content
	for ($i = 0; $data['files'][$i]; $i++) {
		$content['files'] .= str_replace(
			array(
				'{FILE}',
				'{ID}'
			),
			array(
				$data['files'][$i],
				$i
			),
			$skin['pick_file']
		);
	}
	
	// Make the table content
	for ($i = 0; $data['tables'][$i]; $i++) {
		$content['tables'] .= str_replace(
			array(
				'{TABLE}',
				'{ID}'
			),
			array(
				$data['tables'][$i],
				$i
			),
			$skin['pick_table']
		);
	}
	
	// In comes the airplane...
	$content['home'] = str_replace(
		array(
			'{FOLDER_OPTIONS}',
			'{FILE_OPTIONS}',
			'{TABLE_OPTIONS}'
		),
		array(
			$content['folders'],
			$content['files'],
			$content['tables']
		),
		($_REQUEST['act'] == 'update') ? $skin['update'] : $skin['home']
	);
	
	// ...chew it up...
	$content['content'] = str_replace(
		'{CONTENT}',
		$content['home'],
		$skin['content']
	);
	
	// ...and spit it out!
	print $content['content'];
	
	// I never did like this script anyway...
	die();
	
}

// Install
function procedure_install($data) {
	global $lang, $skin, $file, $_REQUEST;
	
	// Make the folder(s)
	for ($i = 0; $data['folders'][$i]; $i++) {
		$content['folders'] .= str_replace(
			array(
				'{FOLDER}',
				'<#make_folder>'
			),
			array(
				$data['folders'][$i],
				make_folder($data['folders'][$i], ($_REQUEST['create_folder'][$i] == 1) ? 1 : 0)
			),
			$skin['make_folder']
		);
	}
	
	// Make the file(s)
	for ($i = 0; $data['files'][$i]; $i++) {
		$content['files'] .= str_replace(
			array(
				'{FILE}',
				'<#make_file>'
			),
			array(
				$data['files'][$i],
				make_file($file[$data['files'][$i]], $data['files'][$i], ($_REQUEST['create_file'][$i] == 1) ? 1 : 0)
			),
			$skin['make_file']
		);
	}
	
	// Make the table(s)
	for ($i = 0; $data['tables'][$i]; $i++) {
		$content['tables'] .= str_replace(
			array(
				'{TABLE}',
				'<#make_table>'
			),
			array(
				$data['tables'][$i],
				make_table($_REQUEST['sql_host'], $_REQUEST['sql_user'], $_REQUEST['sql_pass'], $_REQUEST['sql_db'], $data['tables'][$i], $data['fields'][$i], ($_REQUEST['create_table'][$i] == 1) ? 1 : 0)
			),
			$skin['make_table']
		);
	}
	
	// Cut 'n' paste job part 1...
	$content['install'] = str_replace(
		array(
			'{FOLDER_DETAILS}',
			'{FILE_DETAILS}',
			'{TABLE_DETAILS}'
		),
		array(
			$content['folders'],
			$content['files'],
			$content['tables']
		),
		$skin['install']
	);
	
	// ...2...
	$content['content'] = str_replace(
		'{CONTENT}',
		$content['install'],
		$skin['content']
	);
	
	// ...three times' the charm!
	print $content['content'];
	
	// Hm, how about a foursome then?
	die();

}

?>