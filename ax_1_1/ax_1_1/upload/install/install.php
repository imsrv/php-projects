<?php
//+----------------------------------
//	AnnouncementX Installer
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/20
//	Finished: 2004/10/22
//	Updated: 2005/10/12
//	Description:
//	This script helps to install 
//	AnnouncementX with minimum 
//	knowledge. :D
//+----------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (file_exists('finish.lock')) {
	do_header();
	echo "AnnouncementX is installed.<br />To re-install, remove <b>finish.lock</b> file from the <b>install</b> folder.";
	do_bottom();
	exit;
}

$config_file='../conf_global.php';
$check=fopen($config_file,'r');
$contents=fread($check,filesize($config_file));
fclose($check);

if (filesize($config_file) > 10) {

include($config_file);
define ('USER',$username_file);
define ('PASS',$password_file);
define ('DATA',$database_file);
define ('HOST',$host_file);

}

switch ($step) {

default:
	do_header();
	do_script();
	do_welcome();
	do_bottom();
break;

case "1":
	do_header();
	do_script();
	do_first();
	do_bottom();
break;

case "5":
	do_header();
	do_script_2();
	do_finish();
	do_bottom();
break;

case "2":
	do_header();
	do_script_2();
	do_part_1();
	do_bottom();
break;

case "3":
	do_header();
	do_script_2();
	do_tables();
	do_bottom();
break;

case "4":
	do_header();
	do_script_2();
	do_values();
	do_bottom();
break;

}
//Main Functions

function do_first() {

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$domain=$_SERVER['SERVER_NAME'];
$ffull=$_SERVER['SCRIPT_NAME'];

$folder=str_replace('/install/install.php','',$ffull);

$agreement=$_POST['agree'];

if ($agreement == 1) {

echo <<<END
<table width=700 align=center border=1 border-color='#ffffff' style='border-collapse: collapse' cellpadding='2'>
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<table width='40%' align=center border=0 cellpadding=3>
		<form name='install' action='install.php?step=2' method='post' onsubmit='return ValidateForm()'>
		<input type=hidden name='security' value='ok'>
			<tr>
				<td align=left class=FORM colspan=2>
				<b>Install Settings:</b>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				AnnouncementX Folder:
				</td>
				<td align=center class=FORM>
				$domain<br />
				<input type=text name='path' class='field' value='$folder' size='30'>
				</td>
			</tr>
			<tr>
				<td align=left class=FORM colspan=2>
				<b>Admin Settings:</b>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Admin Username:
				</td>
				<td align=center>
				<input type=text name='a_user' value='Username' onfocus="this.value=''" size='30' maxlength="255" class='field'>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Admin Password:
				</td>
				<td align=center>
				<input type=password name='a_pass' value='catrules' onfocus="this.value=''" size='30' maxlength="255" class='field'>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Admin E-mail:
				</td>
				<td align=center>
				<input type=text name='a_email' size='30' maxlength='255' class='field'>
				</td>
			</tr>
			<tr>
				<td align=left class=FORM colspan=2>
				<b>Database Settings:</b>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Database Username:
				</td>
				<td align=center>
				<input type=text name='d_user' size='30' class='field'>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Database Password:
				</td>
				<td align=center>
				<input type=password name='d_pass' size='30' class='field'>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Database Name:
				</td>
				<td align=center>
				<input type=text name='d_name' size='30' class='field'>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM>
				Database Host:
				</td>
				<td align=center>
				<input type=text name='d_host' value='localhost' size='30' class='field'>
				</td>
			</tr>
			<tr>
				<td align=center class=FORM colspan=2>
				<input type=submit name='submit' value='Continue' class='submit'>
				</td>
			</tr>
		</form>
		</table>
		</td>
	</tr>
</table>
END;

} else {

	echo "<center>To continue you must agree with the license";

}

}

function do_part_1() {
$security=$_POST['security'];
if (empty($security)) {
print "You do not have rights to view this page";
exit();
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$a_user=$_POST['a_user'];
$a_pass=$_POST['a_pass'];
$a_email=$_POST['a_email'];
$d_user=$_POST['d_user'];
$d_pass=$_POST['d_pass'];
$d_name=$_POST['d_name'];
$d_host=$_POST['d_host'];
$path=$_POST['path'];
		if (empty($a_user)||empty($a_pass)||empty($a_email)||empty($d_user)||empty($d_pass)||empty($d_name)||empty($d_host)) {
echo <<<EOF
<table width=700 align=center border=1 border-color='#ffffff' style="border-collapse: collapse" cellpadding="2">
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		Please, fill in all the fields!.<br />
		Click the button below to continue.<br />
		<form name='install' action='install.php?step=' onsubmit='ValidateForm()'>
		<input type=submit name=submit value='Continue' class='submit'>
		</form>
		</td>
	</tr>
	</table>
EOF;
} else {
	$file='../conf_global.php';
		$k="$";
	$write="<?\n".$k."username_file=$d_user;\n".$k."password_file=$d_pass;\n".$k."database_file=$d_name;\n".$k."host_file=$d_host;\n?>";
		$fp=fopen ($file,'w');
		fwrite($fp,$write);
		fclose($fp);
		/*$handle=fopen($file,'r');
		$contents=fread($handle,filesize($file));
		$what=".";
		$to_do="";
		$new=str_replace($what,$to_do,$contents);
		fclose($handle);
		$new_again=$new;
		$ok=fopen($file,'w');
		fwrite($ok,$new_again);
		fclose($ok);*/
	include $file;
		define ('HOST',$host_file);
		define ('USER',$username_file);
		define ('PASS',$password_file);
		define ('DATA',$database_file);
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$blah=mysql_query("DROP TABLE IF EXISTS `members`") or die ("AnnouncementX Error: " . mysql_error());
	
	$query='CREATE TABLE `members` ('
        . ' `id` BIGINT(10) NOT NULL AUTO_INCREMENT, '
        . ' `Name` VARCHAR(255) NOT NULL, '
        . ' `Password` VARCHAR(255) NOT NULL, '
        . ' `Email` VARCHAR(255) NOT NULL, '
        . ' `Location` TEXT NOT NULL, '
        . ' `Occupation` TEXT NOT NULL, '
        . ' `Group` VARCHAR(255) NOT NULL,'
        . ' PRIMARY KEY (`id`)'
        . ' )';
	mysql_query($query) or die ('AnnouncementX Error: ' . mysql_error());
	$add="INSERT INTO members VALUES ('','$a_user','$a_pass','$a_email','','','Admin')";
	mysql_query($add) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_close($link);
echo <<<EOF
<table width=700 align=center border=1 border-color='#ffffff' style='border-collapse: collapse' cellpadding='2'>
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		The second step of installation has been succesfully completed.<br />
		Click the button below to continue and create tables.<br />
		<form name='install' action='install.php?step=3' method='post' onsubmit='ValidateForm()'>
		<input type=hidden name='security' value='ok'>
		<input type=hidden name=path value='$path'>
		<input type=submit name=submit value='Continue' class='submit'>
		</form>
		</td>
	</tr>
</table>
EOF;
}
}

function do_tables() { 
$security=$_POST['security'];
if (empty($security)) {
print "You do not have rights to view this page";
exit();
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$path=$_POST['path'];
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
		
	$checkdb="DROP TABLE IF EXISTS `config`,`categories`,`posts`,`groups`,`badwords`,`skins`,`pms`,`replies`,`notebook`";
	$checkdbqr=mysql_query($checkdb) or die ("AnnouncementX Error: " . mysql_error());
	
	$cr_1='CREATE TABLE `config` (' 
		. ' `Name` VARCHAR(255) NOT NULL, ' 
		. ' `Value` TEXT NOT NULL );' 
		. ' ';
	$cr_2='CREATE TABLE `categories` (' 
		. ' `id` INT(4) NOT NULL AUTO_INCREMENT, ' 
		. ' `Name` varchar(255) NOT NULL, ' 
		. ' `Description` text NOT NULL, ' 
        . ' PRIMARY KEY (`id`)'
        . ' )';
	$cr_3='CREATE TABLE `posts` ('
        . ' `id` BIGINT(8) NOT NULL AUTO_INCREMENT, '
        . ' `Category` int(4) NOT NULL, '
        . ' `Poster` VARCHAR(255) NOT NULL, '
        . ' `Title` VARCHAR(255) NOT NULL, '
        . ' `Message` TEXT NOT NULL,'
        . ' PRIMARY KEY (`id`)'
        . ' )';
	$cr_4 = 'CREATE TABLE `groups` ('
        . ' `id` TINYINT(2) NOT NULL AUTO_INCREMENT, '
        . ' `Name` VARCHAR(255) NOT NULL, '
        . ' `Description` TEXT NOT NULL, '
        . ' `Pr_admin` VARCHAR(3) NOT NULL, '
        . ' `Pr_banned` VARCHAR(3) NOT NULL, '
        . ' `Pr_mod` VARCHAR(3) NOT NULL, '
        . ' `Pr_valid` VARCHAR(3) NOT NULL,'
        . ' PRIMARY KEY (`id`)'
        . ' )';
	$cr_5='CREATE TABLE `badwords` ('
        . ' `id` INT(4) NOT NULL AUTO_INCREMENT, '
        . ' `Word` varchar(255) NOT NULL, '
        . ' PRIMARY KEY (`id`)'
        . ' )';
	$cr_6='CREATE TABLE `skins` ('
		. ' `id` TINYINT(3) NOT NULL AUTO_INCREMENT, '
		. ' `Name` VARCHAR(255) NOT NULL, '
		. ' `Path` VARCHAR(150) NOT NULL, '
		. ' `Css` VARCHAR(255) NOT NULL, '
		. ' PRIMARY KEY (`id`)'
		. ' )';
	$cr_7='CREATE TABLE `replies` (' 
		. ' `id` INT(6) NOT NULL AUTO_INCREMENT, ' 
		. ' `Category` int(4) NOT NULL, ' 
		. ' `Poster` varchar(255) NOT NULL, ' 
		. ' `Post_title` varchar(255) NOT NULL, ' 
		. ' `Message` text NOT NULL, ' 
		. ' PRIMARY KEY (`id`)' 
		. ' )';
	$cr_8='CREATE TABLE `pms` (' 
		. ' `id` INT(6) NOT NULL AUTO_INCREMENT, ' 
		. ' `To` varchar(255) NOT NULL, ' 
		. ' `From` varchar(255) NOT NULL, ' 
		. ' `Title` varchar(255) NOT NULL, ' 
		. ' `Message` text NOT NULL, ' 
		. ' `Read` varchar(3) NOT NULL, ' 
		. ' PRIMARY KEY (`id`)' 
		. ' )';
	$cr_9='CREATE TABLE `notebook` (' 
		. ' `id` int(10) NOT NULL AUTO_INCREMENT, ' 
		. ' `mid` int(10) NOT NULL, ' 
		. ' `Message` text NOT NULL, ' 
		. ' PRIMARY KEY (`id`)' 
		. ' )';
	mysql_query($cr_1) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_2) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_3) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_4) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_5) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_6) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_7) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_8) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($cr_9) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_close($link);
echo <<<EOF
		<table width=700 align=center border=1 border-color='#ffffff' style='border-collapse: collapse' cellpadding='2'>
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		The third step of installation has been succesfully completed.<br />
		Click the button below to continue and insert values.<br />
		<form name='install' action='install.php?step=4' method='post' onsubmit='ValidateForm()'>
		<input type=hidden name='security' value='ok'>
		<input type=hidden name=path value='$path'>
		<input type=submit name=submit value='Continue' class='submit'>
		</form>
		</td>
	</tr>
	</table>
EOF;
}

function do_values() {
$security=$_POST['security'];
if (empty($security)) {
print "You do not have rights to view this page";
exit();
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$path=$_POST['path'];
$domain=$_SERVER['SERVER_NAME'];
$path_full=$domain.''.$path;
	$file="../conf_global.php";
	include $file;
		define ('HOST',$host_file);
		define ('USER',$username_file);
		define ('PASS',$password_file);
		define ('DATA',$database_file);
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	$in[1]="INSERT INTO config(Name,Value) VALUES ('Application','On')";
	$in[2]="INSERT INTO config(Name,Value) VALUES ('Title','AnnouncementX')";
	$in[3]="INSERT INTO config(Name,Value) VALUES ('Subtitle','Powered by AnnouncementX')";
	$in[4]="INSERT INTO config(Name,Value) VALUES ('Path','$path_full')";
	$in[5]="INSERT INTO config(Name,Value) VALUES ('Cookies','On')";
	$in[6]="INSERT INTO config(Name,Value) VALUES ('Registrations','On')";
	$in[7]="INSERT INTO config(Name,Value) VALUES ('Validation','On')";
	$in[8]="INSERT INTO config(Name,Value) VALUES ('Version','1.0')";
	$in[9]="INSERT INTO config(Name,Value) VALUES ('Offline_message','The AnnouncementX is offline.')";
	$in[10]="INSERT INTO config(Name,Value) VALUES ('IP_Logs','On')";
	$in[11]="INSERT INTO config(Name,Value) VALUES ('PM','On')";
	$in[12]="INSERT INTO config(Name,Value) VALUES ('Emails','On')";
	$in[13]="INSERT INTO config(Name,Value) VALUES ('BadWords','Off')";
	//+--------------
	$in[14]="INSERT INTO groups(id,Name,Description,Pr_admin,Pr_banned,Pr_mod,Pr_valid) VALUES ('','Admin','AnnouncementX Admins','yes','no','yes','no')";
	$in[15]="INSERT INTO groups(id,Name,Description,Pr_admin,Pr_banned,Pr_mod,Pr_valid) VALUES ('','Member','AnnouncementX Members','no','no','no','no')";
	$in[16]="INSERT INTO groups(id,Name,Description,Pr_admin,Pr_banned,Pr_mod,Pr_valid) VALUES ('','Banned','AnnouncementX Banned People','no','yes','no','no')";
	$in[17]="INSERT INTO groups(id,Name,Description,Pr_admin,Pr_banned,Pr_mod,Pr_valid) VALUES ('','Validating','People waiting for validating','no','no','no','yes')";
	//+--------------
	$in[18]="INSERT INTO badwords VALUES ('','fuck')";
	$in[19]="INSERT INTO badwords VALUES ('','bitch')";
	$in[20]="INSERT INTO badwords VALUES ('','bastard')";
	$in[21]="INSERT INTO badwords VALUES ('','geek')";
	//+--------------
	$in[22]="INSERT INTO categories VALUES ('','A Test Category','This is a test category you can delete')";
	//+--------------
	$in[23]="INSERT INTO posts VALUES ('','A Test Category','AnnouncementX','Welcome to AnnouncementX','Welcome and enjoy AnnouncementX v.1.0')";
	//+--------------
	$in[24]="INSERT INTO config VALUES ('Guests_Post','Off')";
	$in[25]="INSERT INTO config VALUES ('Used_Skin','default')";
	$in[26]="INSERT INTO config VALUES ('PM_number','50')";
	//+--------------
	$in[27]="INSERT INTO skins VALUES ('','default','/default/','/default.css')";
	//+--------------
	$in[28]="INSERT INTO groups (id,Name,Description,Pr_admin,Pr_banned,Pr_mod,Pr_valid) VALUES ('','Moderator','AnnouncementX Mods','no','no','yes','no')";
	//+--------------
	$in[29]="INSERT INTO notebook VALUES ('','1','It is the place for your personal notes!')";
	
	mysql_query($in[1]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[2]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[3]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[4]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[5]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[6]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[7]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[8]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[9]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[10]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[11]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[12]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[13]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[14]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[15]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[16]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[17]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[18]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[19]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[20]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[21]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[22]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[23]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[24]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[25]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[26]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[27]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[28]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_query($in[29]) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_close($link);
echo <<<END
		<table width=700 align=center border=1 border-color='#ffffff' style='border-collapse: collapse' cellpadding='2'>
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		The fourth step of installation has been succesfully completed.<br />
		Click the button below to continue and finish setup.<br />
		<form name='install' action="install.php?step=5" onsubmit='ValidateForm()'>
		<br /><a href='install.php?step=5'><font color='#006699'>Click here to continue</font></a><br />
		</form>
		</td>
	</tr>
	</table>
END;
}

function do_finish() {
	$file='finish.lock';
	$fp=fopen($file,'w');
	fwrite($fp,'The installer has been locked');
	fclose($fp);
	$global='../conf_global.php';
	if (@chmod($global,0666)) {
	$chmod_error="";
	} else {
	$chmod_error="Chmod conf_global.php to <b>0666</b>";
	}

echo "
<table width=700 align=center border=1 border-color='#ffffff' style='border-collapse: collapse' cellpadding='2'>
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		Installation succesfully completed.<br />
		Click the button below to login.<br />
		<form name='install' action='../index.php' onsubmit='ValidateForm()'>
		<br /><br />
		$chmod_error
		<br /><br />
		<input type=submit name=submit value='Continue' class='submit'>
		</form>
		</td>
	</tr>
</table>
";
}

//Additional Functions

function do_header() {
echo <<<EOF
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
<title>AnnouncementX Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css.css" rel="stylesheet" type="text/css">
</head>
<body>
EOF;
}
function do_bottom() {
echo "</body>\n</html>";
}
function do_script() {
echo "
<script language='JavaScript'>
<!--
function ValidateForm() {
	var check=0;

	if (doument.install.a_user.value = '' || document.install.a_pass.value = '' || document.install.a_email.value = '' || document.install.d_user.value = '' || document.install.d_pass.value = '' || document.install.d_name.value = '')
	{
	
	check = '1';
	
	}

	if (check=1) 
	{
	
	alert ('Please fill in all the fileds!');
	return false;
	
	} else {
	
	document.install.submit.disabled = true;
	return true;
	
	}
}
-->
</script>
";
}
function do_script_2() {
echo "
<script language='JavaScript'>
<!--
function ValidateForm() {
document.install.submit.disabled = true;
return true;
}
-->
</script>
";
}
function do_welcome() {

$file=file_get_contents('./gpl.txt');

echo "
	<table width=700 align=center border=1 border-color='#ffffff' style='border-collapse: collapse' cellpadding='2'>
	<tr>
		<td align=center class=HEADER>
		::AnnouncementX Installer::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		Welcome to AnnouncementX Installer. To continue you need to agree with that license:<br /><br />
		<form name='install' action='./install.php?step=1' method='post'>
		<textarea name='license' rows='8' cols='60'>$file</textarea><br /><br />
		<input type='checkbox' name='agree' value='1'>&nbsp;I agree<br /><br />
		<input type=submit name=submit value='Continue' class=submit>
		</form>
		</td>
	</tr>
	</table>
";

}
?>