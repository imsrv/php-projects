<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------
if (!isset($dbpass)) Header("location:install.html");
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"pama.css\">";
include_once("functions.php");
$admin_url="<a href=\"http://".$thedomain."/phpautomembersarea/".$adminfolder."/\">http://".$thedomain."/phpautomembersarea/".$adminfolder."/</a>";
define("DBHOST", $dbhost);
define("DBUSER", $dbuser);
define("DBPASS", $dbpass);
define("DBNAME", $dbname);
$go_back = "<hr><a href=\"javascript:history.go(-1)\">&lt;&lt; Click here to go back &lt;&lt;</a>";
if (file_exists($installed_config_file))
{
 echo "<h2>Already installed!<br><br>To re-install please delete the file: \"$installed_config_file\" $go_back";
 exit;
}
if (!is_email($email))
{
 echo "<h2>Email address not real!<br><br>To install please enter a real email address. $go_back";
 exit;
}
$crt1="CREATE TABLE pama_members (
  id int(11) NOT NULL,
  name varchar(64) default NULL,
  companyname varchar(64) default NULL,
  email varchar(128) default NULL,
  address varchar(128) default NULL,
  county varchar(28) default NULL,
  postcode varchar(28) default NULL,
  tel varchar(28) default NULL,
  fax varchar(28) default NULL,
  heardaboutusfrom varchar(28) default NULL,
  their_username varchar(64) default NULL,
  their_password varchar(64) default NULL,
  comments text,
  activated tinyint(1) NOT NULL default '0',
  activated_date int(11),
  PRIMARY KEY (id),
  KEY activated (activated),
  KEY activated_date (activated_date),
  KEY their_username (their_username)) TYPE=MyISAM";

$crt2="CREATE TABLE pama_admin (
  id int(11) NOT NULL,
  their_username varchar(64) default NULL,
  their_password varchar(64) default NULL,
  contact_email varchar(64) default NULL,
  auto_activate tinyint(1) NOT NULL default '0',
  PRIMARY KEY (id)) TYPE=MyISAM";

$md5_password = md5($dbpass);
$crt3="INSERT INTO `pama_admin`
       VALUES ('1', '$email', '$md5_password', '$email', '0')";

$crt4="CREATE TABLE pama_logins (
  id int(11) NOT NULL auto_increment,
  login_date int(11) NOT NULL default '0',
  member_id int(11) default NULL,
  ip_no varchar(32) default NULL,
  user_agent varchar(250) default NULL,
  PRIMARY KEY  (id),
  KEY login_date (login_date)
  ) TYPE=MyISAM";

if (!db_connect())
{
 echo "<h2>Unable to continue, details entered are incorrect to connect to database. $go_back";
 exit;
}
mysql_query("drop table if exists pama_members");
mysql_query("drop table if exists pama_admin");
mysql_query("drop table if exists pama_logins");
echo "Attempting to create new tables... ";
if ( !mysql_query($crt1) )
{
 echo "<h2>There has been a problem creating the required tables, and/or inserting data (error message: ".mysql_error()."). $go_back";
 echo $crt1;
 exit;
}
if ( !mysql_query($crt2) )
{
 echo "<h2>There has been a problem creating the required tables, and/or inserting data (error message: ".mysql_error()."). $go_back";
 echo $crt2;
 exit;
}
if ( !mysql_query($crt3) )
{
 echo "<h2>There has been a problem creating the required tables, and/or inserting data (error message: ".mysql_error()."). $go_back";
 echo $crt3;
 exit;
}
if ( !mysql_query($crt4) )
{
 echo "<h2>There has been a problem creating the required tables, and/or inserting data (error message: ".mysql_error()."). $go_back";
 echo $crt4;
 exit;
}
else
{
 if (!rename("_admin_",$adminfolder))
 {
  echo "<center><h2>Unable to locate \"phpautomembersarea/_admin_\" folder!<br><br>To re-install please rename your existing admin folder to:<br><br> \"phpautomembersarea/_admin_\" $go_back";
  exit;
 }
 echo "<b> Success.</b> Created new tables and inserted default data.<br>";
 create_config_file($installed_config_file,$dbhost,$dbuser,$dbpass,$dbname,$phpAutoMembersArea_version,$coname,$adminfolder);
 include("install_complete.html");
}
db_close();

function create_config_file($installed_config_file,$dbhost,$dbuser,$dbpass,$dbname,$phpAutoMembersArea_version,$coname,$adminfolder)
{
 echo "Attempting to create configuration file: $installed_config_file ...";
 $just_one_dollar_please = "$";
 $config_data = "<?\n//  phpAutoMembersArea config file \n\n".
  $just_one_dollar_please."phpAutoMembersArea_version = \"$phpAutoMembersArea_version\";\n\n
  define('DBHOST', '$dbhost');
  define('DBUSER', '$dbuser');
  define('DBPASS', '$dbpass');
  define('DBNAME', '$dbname');

  define('CO_NAME', '$coname');
  define('ADMIN_FOLDER', '$adminfolder');
?>";
 $fp=fopen($installed_config_file, "w");
 if ($fp)
 {
  set_file_buffer($fp, 0);
  $file_write = fputs($fp, $config_data);
  fclose($fp);
  echo "<b> Success.</b> Created config file.";
 }
}
?>