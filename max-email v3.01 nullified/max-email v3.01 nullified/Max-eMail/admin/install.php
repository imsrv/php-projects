<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Install Script Author: CyKuH [WTN]                                       //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
?>
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
$programm =   'Max-eMail Elite';
$version	= '3.01';
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
<p>Welcome to <? echo $programm ?> Installation Script.</p>
<p>Running this script will do an install of <? echo $programm ?> database strucuctury and default data onto your server.</p>
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
if ($step >= 2)
{

}
if ($step == 2)
{
echo "<center>";
$install=1;include "../config.inc.php";
mysql_connect($MySQLServer, $MySQLUser, $MySQLPass) or die(mysql_error());
mysql_select_db($MySQLDatabase) or die(mysql_error());
echo <<<EOF
Setting install config - ok.<br>
Connect to server - ok.<br>
Connect to database - ok.
EOF;
	gotonext();
	exit;
}

if($step>=3)
{
}

if($step==3)
{
echo "<center>";
$install=1;include "../config.inc.php";
mysql_connect($MySQLServer, $MySQLUser, $MySQLPass) or die(mysql_error());
mysql_select_db($MySQLDatabase) or die(mysql_error());
////////////////////////////////////////////////////////////////////////
////////////////////////// Dump MySQL //////////////////////////////////
////////////////////////////////////////////////////////////////////////

mysql_query("CREATE TABLE `admin_group_privelages` (
  `AdminGroupID` int(11) NOT NULL default '0',
  `Action` text NOT NULL
) TYPE=MyISAM;");
echo "Creating  table admin_group_privelages  -  ok<br>";

mysql_query("CREATE TABLE `admin_groups` (
  `AdminGroupID` int(11) NOT NULL auto_increment,
  `AdminGroupName` text NOT NULL,
  `PasswordChangeGap` mediumint(9) NOT NULL default '0',
  `SuperUser` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`AdminGroupID`),
  UNIQUE KEY `AdminGroupID` (`AdminGroupID`)
) TYPE=MyISAM;");
echo "Creating  table admin_groups  -  ok<br>";

mysql_query("CREATE TABLE `admin_messages` (
  `MessageID` int(11) NOT NULL auto_increment,
  `Subject` text NOT NULL,
  `Body` blob NOT NULL,
  `ToAdminID` int(11) NOT NULL default '0',
  `FromAdminID` int(11) NOT NULL default '0',
  `Date` int(11) NOT NULL default '0',
  `Received` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`MessageID`),
  UNIQUE KEY `MessageID` (`MessageID`)
) TYPE=MyISAM;");
echo "Creating  table  admin_messages -  ok<br>";

mysql_query("CREATE TABLE `admin_templates` (
  `AdminTemplateID` int(11) NOT NULL auto_increment,
  `AdminTemplateName` text NOT NULL,
  `LogoURL` text NOT NULL,
  `TopBarImageURL` text NOT NULL,
  `ColorOne` text NOT NULL,
  `ColorTwo` text NOT NULL,
  `PageTitle` text NOT NULL,
  `sidebarlinks` text NOT NULL,
  `sidebarlinkshover` text NOT NULL,
  `formtext` text NOT NULL,
  `smalltext` text NOT NULL,
  `admintext` text NOT NULL,
  `adminlink` text NOT NULL,
  `adminlinkhover` text NOT NULL,
  `inputfields` text NOT NULL,
  `IsDefault` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`AdminTemplateID`),
  UNIQUE KEY `AdminTemplateID` (`AdminTemplateID`)
) TYPE=MyISAM;");
echo "Creating  table admin_templates  -  ok<br>";

mysql_query("CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL auto_increment,
  `AdminRealName` text NOT NULL,
  `AdminEmail` text NOT NULL,
  `AdminUsername` text NOT NULL,
  `AdminPassword` text NOT NULL,
  `AdminGroupID` int(11) NOT NULL default '0',
  `LastLoggedIN` int(11) NOT NULL default '0',
  `LastChangedPassword` int(11) NOT NULL default '0',
  `Active` tinyint(4) NOT NULL default '0',
  `IdentityKey` text NOT NULL,
  `AdminTemplateID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`AdminID`),
  UNIQUE KEY `AdminID` (`AdminID`)
) TYPE=MyISAM;");
echo "Creating  table admins  -  ok<br>";

mysql_query("CREATE TABLE `autofill_fields` (
  `AutoFillID` int(11) NOT NULL auto_increment,
  `AutoFillGroupID` int(11) NOT NULL default '0',
  `AutoFillName` text NOT NULL,
  `AutoFillField` text NOT NULL,
  `ReplaceWith` text NOT NULL,
  `Type` text NOT NULL,
  PRIMARY KEY  (`AutoFillID`),
  UNIQUE KEY `AutoFIllID` (`AutoFillID`)
) TYPE=MyISAM;");
echo "Creating  table autofill_fields  -  ok<br>";

mysql_query("CREATE TABLE `autofill_groups` (
  `AutoFillGroupID` int(11) NOT NULL auto_increment,
  `AutoFillGroupName` text NOT NULL,
  `FieldLimit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`AutoFillGroupID`),
  UNIQUE KEY `AutoFillGroupID` (`AutoFillGroupID`)
) TYPE=MyISAM;");
echo "Creating  table  autofill_groups -  ok<br>";

mysql_query("CREATE TABLE `banned_emails` (
  `BannedID` int(11) NOT NULL auto_increment,
  `BannedEmail` text NOT NULL,
  `BannedDate` int(11) NOT NULL default '0',
  `BannedGroup` int(11) NOT NULL default '0',
  PRIMARY KEY  (`BannedID`),
  UNIQUE KEY `BannedID` (`BannedID`)
) TYPE=MyISAM;");
echo "Creating  table banned_emails  -  ok<br>";

mysql_query("CREATE TABLE `banned_groups` (
  `BannedGroupID` int(11) NOT NULL auto_increment,
  `BannedGroupName` text NOT NULL,
  PRIMARY KEY  (`BannedGroupID`),
  UNIQUE KEY `BannedGroupID` (`BannedGroupID`)
) TYPE=MyISAM;");
echo "Creating  table banned_groups  -  ok<br>";

mysql_query("CREATE TABLE `bounce_addresses` (
  `BounceAddressID` int(11) NOT NULL auto_increment,
  `Mail_Server` text NOT NULL,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `EmailAddress` text NOT NULL,
  PRIMARY KEY  (`BounceAddressID`),
  UNIQUE KEY `BounceAddressID` (`BounceAddressID`)
) TYPE=MyISAM;");
echo "Creating  table bounce_addresses  -  ok<br>";

mysql_query("CREATE TABLE `bounced_emails` (
  `Email` text NOT NULL,
  `Time` int(11) NOT NULL default '0',
  `BouncedAddress` int(11) NOT NULL default '0'
) TYPE=MyISAM;");
echo "Creating  table bounced_emails  -  ok<br>";

mysql_query("CREATE TABLE `composed_emails` (
  `ComposeID` int(11) NOT NULL auto_increment,
  `ComposeName` text NOT NULL,
  `TemplateID` int(11) NOT NULL default '0',
  `Format` tinytext NOT NULL,
  `AdminID` int(11) NOT NULL default '0',
  `HTML_Version` longblob NOT NULL,
  `Text_Version` longblob NOT NULL,
  `Text_Subject` text NOT NULL,
  `HTML_Subject` text NOT NULL,
  PRIMARY KEY  (`ComposeID`),
  UNIQUE KEY `ComposeID` (`ComposeID`)
) TYPE=MyISAM;");
echo "Creating  table composed_emails -  ok<br>";

mysql_query("CREATE TABLE `content_cats` (
  `ContentCatID` int(11) NOT NULL auto_increment,
  `ContentCatName` text NOT NULL,
  `ItemLimit` int(11) NOT NULL default '0',
  `HTMLFormat` text NOT NULL,
  `TextFormat` text NOT NULL,
  PRIMARY KEY  (`ContentCatID`),
  UNIQUE KEY `ContentCatID` (`ContentCatID`)
) TYPE=MyISAM;");
echo "Creating  table content_cats  -  ok<br>";

mysql_query("CREATE TABLE `content_data` (
  `ContentID` int(11) NOT NULL default '0',
  `FieldID` int(11) NOT NULL default '0',
  `Data` blob NOT NULL
) TYPE=MyISAM;");
echo "Creating  table content_data  -  ok<br>";

mysql_query("CREATE TABLE `content_fields` (
  `ContentCatID` int(11) NOT NULL default '0',
  `FieldID` int(11) NOT NULL default '0',
  `FieldName` text NOT NULL,
  `Required` tinyint(4) NOT NULL default '0',
  `Type` tinytext NOT NULL
) TYPE=MyISAM;");
echo "Creating  table content_fields  -  ok<br>";

mysql_query("CREATE TABLE `content_items` (
  `ContentID` int(11) NOT NULL auto_increment,
  `ContentCatID` int(11) NOT NULL default '0',
  `ContentItemName` text NOT NULL,
  `Source` text NOT NULL,
  `DateAdded` int(11) NOT NULL default '0',
  `Reviewed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ContentID`),
  UNIQUE KEY `ContentID` (`ContentID`)
) TYPE=MyISAM;");
echo "Creating  table  content_items -  ok<br>";

mysql_query("CREATE TABLE `extra_data` (
  `DataItemID` int(11) NOT NULL auto_increment,
  `ListID` int(11) NOT NULL default '0',
  `UniqueFieldValue` text NOT NULL,
  `DataFieldName` text NOT NULL,
  `DataFieldValue` text NOT NULL,
  `CollectedFrom` text NOT NULL,
  `DataDate` text NOT NULL,
  PRIMARY KEY  (`DataItemID`),
  UNIQUE KEY `DataItemID` (`DataItemID`)
) TYPE=MyISAM;");
echo "Creating  table extra_data  -  ok<br>";

mysql_query("CREATE TABLE `form_actions` (
  `FormID` int(11) NOT NULL auto_increment,
  `Response` text NOT NULL,
  `SendEmailTo` text NOT NULL,
  `EmailSubject` text NOT NULL,
  `EmailBody` text NOT NULL,
  `EmailFrom` text NOT NULL,
  `DisplayURL` text NOT NULL,
  `DisplayText` text NOT NULL,
  `ReDisplayForm` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`FormID`),
  UNIQUE KEY `FormID` (`FormID`)
) TYPE=MyISAM;");
echo "Creating  table form_actions -  ok<br>";

mysql_query("CREATE TABLE `form_fields` (
  `FormID` int(11) NOT NULL default '0',
  `ListID` text NOT NULL,
  `ListField` text NOT NULL,
  `FormFieldName` text NOT NULL,
  `Verification` text NOT NULL,
  `FieldType` text NOT NULL,
  `FieldData` text NOT NULL,
  `Weight` int(11) NOT NULL default '0'
) TYPE=MyISAM;");
echo "Creating  table form_fields  -  ok<br>";

mysql_query("CREATE TABLE `forms` (
  `FormID` int(11) NOT NULL auto_increment,
  `FormType` tinytext NOT NULL,
  `Lists` text NOT NULL,
  `FormName` text NOT NULL,
  `ParentFormID` int(11) NOT NULL default '0',
  `IndexField` text NOT NULL,
  PRIMARY KEY  (`FormID`),
  UNIQUE KEY `FormID` (`FormID`)
) TYPE=MyISAM;");
echo "Creating  table forms -  ok<br>";

mysql_query("CREATE TABLE `image_groups` (
  `ImageGroupID` int(11) NOT NULL auto_increment,
  `ImageGroupName` text NOT NULL,
  `MaximumImages` int(11) NOT NULL default '0',
  `FileSizeLimit` int(11) NOT NULL default '0',
  `TotalSizeLimit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ImageGroupID`),
  UNIQUE KEY `ImageGroupID` (`ImageGroupID`)
) TYPE=MyISAM;");
echo "Creating  table image_groups  -  ok<br>";

mysql_query("CREATE TABLE `images` (
  `ImageID` int(11) NOT NULL auto_increment,
  `ImageGroupID` int(11) NOT NULL default '0',
  `FileName` text NOT NULL,
  `FileSize` int(11) NOT NULL default '0',
  `ImageData` longblob NOT NULL,
  `ImageType` text NOT NULL,
  PRIMARY KEY  (`ImageID`),
  UNIQUE KEY `ImageID` (`ImageID`)
) TYPE=MyISAM;");
echo "Creating  table images  -  ok<br>";

mysql_query("CREATE TABLE `imports` (
  `ImportID` int(11) NOT NULL default '0',
  `ListID` int(11) NOT NULL default '0',
  `DataSource` text NOT NULL,
  `DataSourceInfo` text NOT NULL,
  `ImportDate` int(11) NOT NULL default '0',
  `Completed` tinyint(4) NOT NULL default '0',
  `NumberOfRecords` tinyint(4) NOT NULL default '0'
) TYPE=MyISAM;");
echo "Creating  table imports  -  ok<br>";

mysql_query("CREATE TABLE `link_clicks` (
  `LinkID` int(11) NOT NULL default '0',
  `IPAddress` text NOT NULL,
  `TimeStamp` int(11) NOT NULL default '0',
  `TraceCode` text NOT NULL,
  `TracedBy` text NOT NULL
) TYPE=MyISAM;");
echo "Creating  table link_clicks  -  ok<br>";

mysql_query("CREATE TABLE `link_groups` (
  `LinkGroupID` int(11) NOT NULL auto_increment,
  `LinkGroupName` text NOT NULL,
  `MaximumLinks` int(11) NOT NULL default '0',
  PRIMARY KEY  (`LinkGroupID`),
  UNIQUE KEY `LinkGroupID` (`LinkGroupID`)
) TYPE=MyISAM;");
echo "Creating  table link_groups  -  ok<br>";

mysql_query("CREATE TABLE `links` (
  `LinkID` int(11) NOT NULL auto_increment,
  `LinkGroupID` int(11) NOT NULL default '0',
  `LinkName` text NOT NULL,
  `Link` text NOT NULL,
  `TraceBy` tinytext NOT NULL,
  `TraceCode` tinytext NOT NULL,
  PRIMARY KEY  (`LinkID`),
  UNIQUE KEY `LinkID` (`LinkID`)
) TYPE=MyISAM;");
echo "Creating  table links  -  ok<br>";

mysql_query("CREATE TABLE `lists` (
  `ListID` int(11) NOT NULL auto_increment,
  `ListName` text NOT NULL,
  `ListSource` text NOT NULL,
  `ListSourceType` tinytext NOT NULL,
  `EmailField` text NOT NULL,
  `DateField` text NOT NULL,
  `ReceivingField` text NOT NULL,
  `ReceivingValues` text NOT NULL,
  `FormatField` text NOT NULL,
  `FormatValues` text NOT NULL,
  `Active` tinyint(4) NOT NULL default '0',
  `DefaultFormat` tinytext NOT NULL,
  `DefaultReceiving` tinytext NOT NULL,
  `UniqueField` text NOT NULL,
  `BounceAddressID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ListID`),
  UNIQUE KEY `ListID` (`ListID`)
) TYPE=MyISAM;");
echo "Creating  table lists  -  ok<br>";

mysql_query("CREATE TABLE `send_recipients` (
  `SendID` int(11) NOT NULL default '0',
  `UniqueKey` text NOT NULL,
  `Format` text NOT NULL,
  `Failed` tinyint(4) NOT NULL default '0'
) TYPE=MyISAM;");
echo "Creating  table send_recipients  -  ok<br>";

mysql_query("CREATE TABLE `sends` (
  `SendID` int(11) NOT NULL auto_increment,
  `StartTime` int(11) NOT NULL default '0',
  `FinishTime` int(11) NOT NULL default '0',
  `Method` text NOT NULL,
  `PerExec` int(11) NOT NULL default '0',
  `ListID` int(11) NOT NULL default '0',
  `ComposeID` int(11) NOT NULL default '0',
  `AdminID` int(11) NOT NULL default '0',
  `Completed` tinyint(4) NOT NULL default '0',
  `FromName` text NOT NULL,
  `FromEmail` text NOT NULL,
  `Done` int(11) NOT NULL default '0',
  `Failed` int(11) NOT NULL default '0',
  PRIMARY KEY  (`SendID`),
  UNIQUE KEY `SendID` (`SendID`)
) TYPE=MyISAM;");
echo "Creating  table sends  -  ok<br>";

mysql_query("CREATE TABLE `system_setup` (
  `Name` text NOT NULL,
  `Value` text NOT NULL
) TYPE=MyISAM;");
echo "Creating  table system_setup  -  ok<br>";

mysql_query("CREATE TABLE `templates` (
  `TemplateID` int(11) NOT NULL auto_increment,
  `TemplateName` text NOT NULL,
  `HTML_Version` blob NOT NULL,
  `Text_Version` blob NOT NULL,
  `HTML_Subject` text NOT NULL,
  `Text_Subject` text NOT NULL,
  `DateModified` int(11) NOT NULL default '0',
  `AllowFormating` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`TemplateID`),
  UNIQUE KEY `TemplateID` (`TemplateID`)
) TYPE=MyISAM;");
echo "Creating  table templates  -  ok<br>";

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
echo "<center><font color=ffffff>Insert Data Complite<br>";
	gotonext();
	exit;
}

if ($step == 4)
{
$install=1;include "../config.inc.php";
mysql_connect($MySQLServer, $MySQLUser, $MySQLPass) or die(mysql_error());
mysql_select_db($MySQLDatabase) or die(mysql_error());
mysql_query("INSERT INTO admin_groups SET AdminGroupName='RootUsers', PasswordChangeGap='30', SuperUser=1");
$ADG=mysql_insert_id();
 srand ((double) microtime() * 1000000);
            $IdentityKey=rand(100,9999);
mysql_query("INSERT INTO admins SET AdminUsername='Admin', AdminPassword='saFD435546', Active='0', IdentityKey='$IdentityKey', AdminGroupID='$ADG'");
mysql_query("INSERT INTO admin_templates VALUES ( '1', 'Default Template', 'images/logo.gif', 'images/top_bar.gif', '#B0C0D0', '#efefef', 'Max-eMail V3 Elite Admin Panel', 'font-size:12; text-decoration:none; color:black; font-face:verdana,arial', 'font-size:12; text-decoration:none; color:#777777; font-face:verdana,arial', 'font-size:12; text-decoration:none; color:black; font-face:verdana,arial', 'font-size:10; text-decoration:none; color:black; font-face:verdana,arial', 'font-size:12; text-decoration:none; color:black; font-face:verdana,arial', 'font-size:12; text-decoration:none; color:black; color:#006699; font-face:verdana,arial', 'font-size:12; text-decoration:underline; color:black; font-face:verdana,arial', 'border-style:box;border-width:1;font-size:12;background-color:#FFFFF4; font-face:verdana,arial', '1');");
	echo "<p><h2><b>You has completed the installation of ".$programm." successfully.</b></h2>"; 
	echo "<blockquote>	<p><b>Automatic delete file: install.php </b> for security reasons."; 
	echo "	<p><a href=\"index.php\" target=\"new\">Access your admin page here &raquo;&raquo;</a><BR>Use the following details:<BR>Username: Admin<BR>IdentityKey: ".$IdentityKey."</p>";
	echo " $installnote";
	echo "	</body>";
	echo "	</html>";
	unlink('install.php');

}
?>