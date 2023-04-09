<html>
<!--
<?php
// CHECK ENV
// determine if php is running
if(1==0)
{
	echo "-->You are not running PHP - Please contact your system administrator.<!--";
}else{
	echo "-->";
}
// /* <? */ Securety info
$programm =   'E-MatchMaker';
$version	= '1.51';
$thisscript	= 'install.php';
if($HTTP_GET_VARS['step'])
{
	$step 	= $HTTP_GET_VARS['step'];
}else{
	$step 	= $HTTP_POST_VARS['step'];
}
$userip		= $HTTP_ENV_VARS['REMOTE_ADDR'];
$userphpself	= $HTTP_SERVER_VARS['PHP_SELF'];
$userpathtran	= $HTTP_SERVER_VARS['PATH_TRANSLATED'];
$usersafemode	= get_cfg_var("safe_mode");

//include('./define.inc.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (function_exists("set_time_limit")==1 && get_cfg_var("safe_mode")==0)
{
	@set_time_limit(1200);
}

if (get_cfg_var("safe_mode") != 0)
{
	$installnote ="<p><b>Note:</b> In your server PHP configuration the <b>Safe Mode is active</b>, You will need edit your config.inc.php file to allow safe mode uploading!</p>";
	$safemode ="1";
}
$onvservers	= "0"; // set this to 1 if you're on Vservers and get disconnected after running an ALTER TABLE command

function dodb_queries()
{
	global $DB_site,$query,$explain,$onvservers;
	while (list($key,$val)=each($query))
	{
		echo "<p>$explain[$key]</p>\n";
		echo "<!-- ".htmlspecialchars($val)." -->\n\n";
		flush();
		if ($onvservers==1 and substr($val, 0, 5)=="ALTER")
		{
			$DB_site->reporterror=0;
		}
		$DB_site->query($val);
		if ($onvservers==1 and substr($val, 0, 5)=="ALTER")
		{
			$DB_site->connect();
			$DB_site->reporterror=1;
		}
	}
	unset ($query);
	unset ($explain);
}
function gotonext($extra="") {
	global $step,$thisscript;
	
	$nextstep = $step+1;
	echo "<div align=\"center\"><p><a href=\"$thisscript?step=$nextstep\"><b>Click here to continue &raquo;&raquo;</b></a> $extra</p>\n</div>";
echo <<<EOF
<p align="center"><!--CyKuH [WTN]-->&copy WTN Team `2000 - `2002</p>
EOF;
}
function stripslashesarray(&$arr) {
	while (list($key,$val) = each($arr))
	{
		if ((strtoupper($key)!=$key || "".intval($key)=="$key") && $key!="argc" && $key!="argv")
		{
			if(is_string($val))
			{
				$arr[$key] = stripslashes($val);
			}
			if(is_array($val))
			{
				$arr[$key] = stripslashesarray($val);
			}
		}
	}
	return $arr;
}
if (get_magic_quotes_gpc() and is_array($GLOBALS))
{
	$GLOBALS = stripslashesarray($GLOBALS);
}
set_magic_quotes_runtime(0);

if($HTTP_GET_VARS['see_phpinfo']==1)
{
	phpinfo();
	exit;
}
?>
<HTML>
	<HEAD>
	<title><? echo $programm ?> Install Script</title>
<STYLE TYPE="text/css">
	<!--
	A { text-decoration: none; }
	A:hover { text-decoration: underline; }
	H1 { font-family: arial,helvetica,sans-serif; font-size: 18pt; font-weight: bold;}
	H2 { font-family: arial,helvetica,sans-serif; font-size: 14pt; font-weight: bold;}
	BODY,TD,FORM,INPUT,TEXTAREA { font-family: arial,helvetica,sans-serif; font-size: 10pt; }
	TH { font-family: arial,helvetica,sans-serif; font-size: 11pt; font-weight: bold; }
	.textpre {font-family : "Courier New", Courier, monospace; font-size : 1px; font-weight : bold;}
	//-->
</STYLE>
	</HEAD>
<BODY onLoad="window.defaultStatus=' '" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<table width="600" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="Black">
	<tr valign="middle" bgcolor="#9999CC">
		<td align="left">
		<!--CyKuH [WTN]-->
		<H1><? echo $programm ?> Script</H1>
		<b>Installation: version <?php echo $version; ?></b></td>
	</TR>
</TABLE>
<BR>

<table width="600" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="Black">
<TR VALIGN="top" BGCOLOR="#CCCCCC"><TD ALIGN="left">
Note: Please be patient as some parts of this may take quite some time.<br>
Nullified by <b>CyKuH [WTN]</b>
</TD></TR>
</TABLE><BR>

<?php
if ($step == "")
{
?>
<table width="600" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="Black">
<tr valign="top" bgcolor="#CCCCCC"><TD ALIGN="left">
Welcome to <? echo $programm ?> Installation Script.<br>
First you need to edit <b>siteconfig.php & dblogin.inc.php</b> and put in the 
values they request. <br>

Running this script will do an install of <? echo $programm ?> database strucuctury and default data onto your server.
</TD></TR>
</TABLE><BR>

	<table width="600" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#000000">
	<tr valign="baseline" bgcolor="#CCCCCC"><th bgcolor="#9999CC" colspan="3" align="center"><b> Database Check </b></th></tr>
	<tr valign="baseline" bgcolor="#CCCCCC" align="center">
		<td bgcolor="#CCCCFF"><b><? echo $programm ?> version <?php echo $version; ?></b></td>
		<td><b>System Requirements:</b></td>
		<td><b>Your System:</b></td>
	</tr>
	<tr valign="baseline" bgcolor="#CCCCCC">
		<td bgcolor="#CCCCFF"><b>PHP version</b></td>
		<td>PHP 4 >= 4.0.4</td>
		<td>Your PHP version: <b><?php echo phpversion();?></b></td>
	</tr>
	<tr valign="baseline" bgcolor="#CCCCCC">
		<td bgcolor="#CCCCFF"><b>MySQL version</b></td>
		<td>MySQL version 3.22 or higher</td>
		<td>See your MySQL version (<a href="install.php?see_phpinfo=1#module_mysql" target="_blank">check ver.</a>)</td>
	</tr>
	</table>
<?php
	$step = 1;
	gotonext();
}
if ($step == 2)
{
// old
require('mmsoft.inc.php');

$sql = "CREATE TABLE login_confirm (
   mdhash longtext,
   username text,
   password text,
   f_name text,
   l_name text,
   email text,
   date datetime DEFAULT '00-00-0000 00:00:00' NOT NULL
)";

$query = $db->Execute($sql);
if (!$query) echo "<font color=red><b>login_confirm</b> table was not created due to an internal error";
else echo "<center><font color=black><b>login_confirm</b> table created Complite<br>";

$sql = "CREATE TABLE login_confirm_email (
   id int(8),
   email text,
   mdhash longtext,
   date datetime DEFAULT '00-00-0000 00:00:00' NOT NULL
)";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>login_confirm_email</b> table was not created due to an internal error";
else echo "<center><font color=black><b>login_confirm_email</b> table created Complite<br>";

$sql = "CREATE TABLE login_data (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   f_name text NOT NULL,
   l_name text NOT NULL,
   email text NOT NULL,
   username text NOT NULL,
   password text NOT NULL,
   lastlogin datetime DEFAULT '00-00-0000 00:00:00',
   usersince datetime DEFAULT '00-00-0000 00:00:00',
   emails_sent int NULL DEFAULT '0',
   PRIMARY KEY (id)
)";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>login_data</b> table was not created due to an internal error";
else echo "<center><font color=black><b>login_data</b> table created Complite<br>";

$sql = "CREATE TABLE profile (
   age int(4) NOT NULL,
   height int(4) NOT NULL,
   hair int(4) NOT NULL,
   sex int(4) NOT NULL,
   race int(4) NOT NULL,
   eyes int(4) NOT NULL,
   kids int(4) NOT NULL,
   build int(4) NOT NULL,
   interest text,
   smoke int(4) NOT NULL,
   education int(4) NOT NULL,
   income int(4) NOT NULL,
   drink int(4) NOT NULL,
   relation int(4) NOT NULL,
   travel int(4) NOT NULL,
   city text NOT NULL,
   state text NOT NULL,
   zipcode int(10) NOT NULL,
   catch text NOT NULL,
   about blob NOT NULL,
   looking blob NOT NULL,
   id int(11) NOT NULL,
   username varchar(200) NOT NULL,
   haspicture int(4) NOT NULL,
   isverified int(4) NOT NULL,
   PRIMARY KEY (username)
)";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>profile</b> table was not created due to an internal error";
else echo "<center><font color=black><b>profile</b> table created Complite<br>";

$sql = "CREATE TABLE profile_pic (
   username varchar(200) NOT NULL PRIMARY KEY,
   image longblob NOT NULL,
   image_type text NOT NULL,
   sub_date datetime DEFAULT '00-00-0000 00:00:00' NOT NULL,
   approved int(4) NOT NULL DEFAULT '0',
   approval_date datetime DEFAULT '00-00-0000 00:00:00'
)";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>profile_pic</b> table was not created due to an internal error";
else echo "<center><font color=black><b>profile_pic</b> table created Complite<br>";

$sql = "CREATE TABLE verified (
   username varchar(200) NOT NULL PRIMARY KEY,
   f_name text NOT NULL,
   l_name text NOT NULL,
   address text NOT NULL,
   city text NOT NULL,
   state text NOT NULL,
   zipcode text NOT NULL,
   telephone text NOT NULL,
   paypalemail text NOT NULL,
   sub_date datetime DEFAULT '00-00-0000 00:00:00' NOT NULL,
   verified_by text,
   verified_date datetime DEFAULT '00-00-0000 00:00:00',
   comments text,
   paid int(4) NOT NULL DEFAULT '0'
)";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>verified</b> table was not created due to an internal error";
else echo "<center><font color=black><b>verified</b> table created Complite<br>";

$sql = "CREATE TABLE messages (
   id int(32) PRIMARY KEY NOT NULL DEFAULT '0' auto_increment,
   sending_user text NOT NULL,
   receiving_user text NOT NULL,
   message longblob,
   date datetime DEFAULT '00-00-0000 00:00:00' NOT NULL,
   beenread tinyint DEFAULT '0',
   hidesender tinyint DEFAULT '0',
   hidereceiver tinyint DEFAULT '0'
)";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>message</b> table was not created due to an internal error";
else echo "<center><font color=black><b>message</b> table created Complite<br>";

$sql = "CREATE TABLE ibill (
  pincode int(11) NOT NULL default '0',
  submit_date date NOT NULL default '0000-00-00',
  is_used tinyint(3) unsigned NOT NULL default '0',
  used_date datetime default NULL,
  userid_used_by text,
  PRIMARY KEY  (pincode)
) TYPE=MyISAM;";

$query = $db->Execute($sql);
if (!$query) echo "<br><b>ibill</b> table was not created due to an internal error<font color=black>";
else echo "<center><font color=black><b>ibill</b> table created Complite<br>";

//old
	gotonext();
	exit;
}

if ($step == 3)
{
	unlink($thisscript);
	echo "<p><h3><b>You has completed the installation of ".$programm." successfully.</b></h3>"; 
	echo "<blockquote>	<p><b>Automatic delete file: install.php </b> for security reasons."; 
	echo "	<p><a href=\"./\" target=\"blank\">The default content of $programm can be found here &raquo;&raquo;</a></p>";
	echo "	<p><a href=\"./admin.php\" target=\"blank\">Access your admin page here &raquo;&raquo;</a> (<b>Default login see in siteconfig.php !</b>)</p>";
	echo " $installnote";
	echo "	</body>";
	echo "	</html>";
}

?>

