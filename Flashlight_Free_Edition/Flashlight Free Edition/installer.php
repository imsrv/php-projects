<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
<head>
<title>Flashlight Installer</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js/scripts.js" /></script>
</head>
<body>
<div id="wrap">
<div id="textbox" align="center">
<?php

// Error reporting
error_reporting(2039);

// Disable magic_quotes
if ( get_magic_quotes_gpc () ) {
function traverse ( &$arr ) {
if ( !is_array ( $arr ) )
return;
foreach ( $arr as $key => $val )
is_array ( $arr[$key] ) ? traverse ( $arr[$key] ) : ( $arr[$key] = stripslashes ( $arr[$key] ) );
}
$gpc = array ( &$_GET, &$_POST, &$_COOKIE );
traverse ( $gpc );
}

function doerror($err) {
echo '<b>Error:</b>
<br /><br />
'.$err.'
<br /><br />
<a href="javascript:history.go(-1)">&lt;&lt; Go Back</a>
</div>
<div id="footer">
<span>Copyright &copy; <a href="#">Flashlight</a> 2005. All rights reserved.</span>
</div>
</div>
</body>
</html>';
exit();
}

$vars = array('first', 'last', 'username', 'password', 'cpassword', 'cname', 'curl');

for ($i = 0; $i < count($vars); $i++) {
$vars[$i] = addslashes($_POST[$vars[$i]]);
}

if (($first == "") || ($last == "") || ($username == "") || ($password == "") || ($cpassword == "")) {
doerror('Please fill in all of the fields in admin information!');
}
if ($password !== $cpassword) {
doerror('Password and confirmed password do not match!');
}

if ($cname == "") {
doerror('Please enter a company name!');
}

$first = ucfirst(strtolower($first));
$last = ucfirst(strtolower($last));

include("config.php");
mysql_query("CREATE TABLE IF NOT EXISTS `inbox` (
  `msg_id` int(10) NOT NULL auto_increment,
  `msg_to` int(5) NOT NULL default '0',
  `msg_cc` int(5) NOT NULL default '0',
  `msg_from` int(5) NOT NULL default '0',
  `msg_time` int(10) NOT NULL default '0',
  `msg_subject` varchar(150) NOT NULL default '',
  `msg_body` text NOT NULL,
  `msg_attachments` varchar(150) NOT NULL default '',
  `msg_read` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`msg_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;") or doerror(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `outbox` (
  `msg_id` int(10) NOT NULL auto_increment,
  `msg_to` int(5) NOT NULL default '0',
  `msg_cc` int(5) NOT NULL default '0',
  `msg_from` int(5) NOT NULL default '0',
  `msg_time` int(10) NOT NULL default '0',
  `msg_subject` varchar(150) NOT NULL default '',
  `msg_body` text NOT NULL,
  `msg_attachments` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`msg_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;") or doerror(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `settings` (
  `company_name` varchar(50) NOT NULL default '',
  `company_url` varchar(100) NOT NULL default '',
  `attachments` tinyint(1) NOT NULL default '0',
  `attachments_maxsize` int(20) NOT NULL default '0',
  `attachments_total` int(5) NOT NULL default '0',
  `setup_date` int(10) NOT NULL default '0'
) TYPE=MyISAM;") or doerror(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL auto_increment,
  `first_name` varchar(50) NOT NULL default '',
  `last_name` varchar(50) NOT NULL default '',
  `username` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `notes` text NOT NULL,
  `lastlogin` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;") or doerror(mysql_error());

$time = time();
$pass = md5($password);

mysql_query("INSERT INTO settings (company_name, company_url, attachments, attachments_maxsize, attachments_total, setup_date) VALUES('$cname', '$curl', '1', '2097152', '5', '$time')") or doerror (mysql_error());
mysql_query("INSERT INTO users (first_name, last_name, username, password) VALUES('$first', '$last', '$username', '$pass')") or doerror (mysql_error());
mysql_close();
?>
<u>Installation Completed</u>
<br /><br />
Please now delete <b>install.php</b> and <b>installer.php</b> before proceeding on to the <a href="index.php">homepage</a>.
<br /><br />
<i>You can change other settings from Administrator Options once logged in.</i>
</div>
<div id="footer">
<span>Copyright &copy; <a target="_new" href="http://www.xeweb.net" title="Visit XEWeb">XEWeb</a> 2005. All rights reserved.</span>
</div>
</div>
</body>
</html>