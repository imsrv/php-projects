<?

/*


	Copyright (C) 2005 ScriptsMill

	E-Mail: info@scriptsmill.com
	URL: http://www.scriptsmill.com
	
    This file is part of ScriptsMill Comments.

    ScriptsMill Comments is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or
    (at your option) any later version.

    ScriptsMill Comments is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ScriptsMill Comments; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


*/


main();

function main() {

	if ($_REQUEST['action'] == 'make_install') {
		make_install();
	}
	else {
		display_config_form();		
	}

}

function display_config_form() {

	preg_match("/(.*)\/install.php/", $_SERVER['REQUEST_URI'], $matches);
	$script_dir = $matches[1];

	print<<<EOF
<html>
<head>
 <title>Comments script configuration</title>
</head>
<body>
<h1>Comments script configuration</h1>
EOF;
	if (file_exists("./config.php")) {
	 	print "It seems that you have already installed comments script. If you want to reinstall it, please delete mysql tables created during previous install and delete file config.php";
	}
	else {
		print<<<EOF
<form action="{$_SERVER['REQUEST_URI']}" method="POST">
<input type="hidden" name="action" value="make_install">
<table>
 <tr>
  <td align="right" valign="top"><b>Site URL:</b></td>
  <td align="left"><input name="site_url" type="text" value="http://{$_SERVER['HTTP_HOST']}" size="80"><br><small>(without trailing slash)</small></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>MySQL host:</b></td>
  <td align="left"><input name="dbhost" type="text" value="" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>MySQL username:</b></td>
  <td align="left"><input name="dbuser" type="text" value="" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>MySQL password:</b></td>
  <td align="left"><input name="dbpassword" type="text" value="" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>MySQL database:</b></td>
  <td align="left"><input name="dbname" type="text" value="" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>MySQL tables preffix:</b></td>
  <td align="left"><input name="dbtablespreffix" type="text" value="comments_" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Script virtual directory:</b></td>
  <td align="left"><input name="script_dir" type="text" value="{$script_dir}" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Admin login:</b></td>
  <td align="left"><input name="admin_name" type="text" value="admin" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Admin password:</b></td>
  <td align="left"><input name="admin_passw" type="password" value="" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Confirm password:</b></td>
  <td align="left"><input name="admin_passw2" type="password" value="" size="80"></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Admin email:</b></td>
  <td align="left"><input name="email_admin" type="text" value="" size="80"><br><small>(leave blank if you don't want to receive notification about new comments on your site)</small></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Script email:</b></td>
  <td align="left"><input name="email_from" type="text" value="" size="80"><br><small>(field 'From:' in notification messages)</small></td>
 </tr>
 <tr>
  <td align="right" valign="top"><b>Comments sort order:</b></td>
  <td align="left"><select name="sort_order"><option value="">Newest comments in the end</option><option value="desc">Newest comments in the begining</option></td>
 </tr>
 <tr>
  <td align="center" colspan="2"><br><input type="submit" value="Install"></td>
 </tr>
</table>
</form>
EOF;

}

	@mail("info@scriptsmill.com", "Someone trying to install comments", "Trying to install on {$_SERVER['HTTP_HOST']}", "From: Install <install@scriptsmill.com>\r\n");

print<<<EOF
</body>
</html>
EOF;


}

function make_install() {

print<<<EOF
<html>
<head>
 <title>Comments script installation process</title>
</head>
<body>
<h1>Comments script installation process</h1>
EOF;

 foreach ($_POST as $key => $value) {
 	if ($key != 'admin_email' && $key != 'sort_order' && $value == '') {
		$error_message .= "Field '$key' shouldn't be blank.<br>\n";
 	}
 }
 if ($_POST['admin_passw'] != $_POST['admin_passw2']) {
		$error_message .= "'Password' and 'Confirm password' fields should have equal values.<br>\n";
 }

 if (!$error_message) {
 	print "Connecting to mysql ... ";
 	$comments_db_link = mysql_connect($_POST['dbhost'],$_POST['dbuser'],$_POST['dbpassword']);
	mysql_select_db($_POST['dbname'], $comments_db_link);
 	if (mysql_error()) {
		$error_message .=  mysql_error() . "<br>\n";
 	}
 	else {
		print "done<br>";
 	}
 }

 if (!$error_message) {
  	print "Creating table {$_POST['dbtablespreffix']}data ... ";
 	mysql_query("CREATE TABLE `{$_POST['dbtablespreffix']}data` (
			  `ID` bigint(3) NOT NULL auto_increment,
			  `time` datetime NOT NULL default '0000-00-00 00:00:00',
			  `href` varchar(255) NOT NULL default '',
			  `text` text NOT NULL,
			  `author` varchar(255) NOT NULL default '',
			  `email` varchar(255) default NULL,
			  `dont_show_email` int(11) default '0',
			  `ip` varchar(15) default NULL,
			  PRIMARY KEY  (`ID`),
			  KEY `time` (`time`,`href`),
			  KEY `href` (`href`)
			)");
 	if (mysql_error()) {
		$error_message .=  mysql_error() . "<br>\n";
 	}
 	else {
 		print "done<br>";
 	}

  	print "Creating table {$_POST['dbtablespreffix']}subscribes ... ";
 	mysql_query("CREATE TABLE `{$_POST['dbtablespreffix']}subscribes` (
			  `ID` bigint(20) NOT NULL auto_increment,
			  `email` varchar(255) NOT NULL default '',
			  `href` varchar(255) NOT NULL default '',
			  `hash` varchar(255) NOT NULL default '',
			  PRIMARY KEY  (`ID`),
			  KEY `href` (`href`)
			)");
 	if (mysql_error()) {
		$error_message .=  mysql_error() . "<br>\n";
 	}
 	else {
 		print "done<br>";
 	}


  	print "Creating table {$_POST['dbtablespreffix']}banned ... ";
 	mysql_query("CREATE TABLE `{$_POST['dbtablespreffix']}banned` (
			  `ID` int(1) NOT NULL default '0',
			  `ip` varchar(15) NOT NULL default '',
			  PRIMARY KEY  (`ID`),
			  UNIQUE KEY `ip` (`ip`)
			)");
 	if (mysql_error()) {
		$error_message .=  mysql_error() . "<br>\n";
 	}
 	else {
 		print "done<br>";
 	}

 	
 }

 if (!$error_message) {

	$keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
	$length = 10;
	$copy_random_seed = "";
	$max=strlen($keychars)-1;
	for ($i=0;$i<=$length-1;$i++) {
	  $copy_random_seed .= substr($keychars, rand(0, $max), 1);
	}

	$config_file =<<<EOF
<?
\$COM_CONF['site_url'] = "{$_POST['site_url']}";  // Without trailing slash

\$COM_CONF['dbhost'] = "{$_POST['dbhost']}";
\$COM_CONF['dbuser']="{$_POST['dbuser']}";
\$COM_CONF['dbpassword']="{$_POST['dbpassword']}";
\$COM_CONF['dbname']="{$_POST['dbname']}";
\$COM_CONF['dbtablespreffix'] = "{$_POST['dbtablespreffix']}";
\$COM_CONF['dbmaintable'] = "{\$COM_CONF['dbtablespreffix']}data";
\$COM_CONF['dbemailstable'] = "{\$COM_CONF['dbtablespreffix']}subscribes";
\$COM_CONF['dbbannedipstable'] = "{\$COM_CONF['dbtablespreffix']}banned";

\$COM_CONF['script_dir'] = "{$_POST['script_dir']}";
\$COM_CONF['admin_name'] = "{$_POST['admin_name']}";
\$COM_CONF['admin_passw'] = "{$_POST['admin_passw']}";
\$COM_CONF['email_admin'] = "{$_POST['email_admin']}";
\$COM_CONF['email_from'] = "{$_POST['email_from']}";
\$COM_CONF['admin_script_url']="{\$COM_CONF['script_dir']}/admin.php";

\$COM_CONF['script_url']="{\$COM_CONF['script_dir']}/comments.php";
\$COM_CONF['template']="default";
\$COM_CONF['lang']="en";
\$COM_CONF['sort_order']="{$_POST['sort_order']}";      // If you want newest comments at the beginig use "desc"
				 // otherwise leave blank

\$COM_CONF['anti_flood_pause'] = '60';  // in seconds

\$COM_CONF['copy_random_seed'] = "{$copy_random_seed}"; // Was generated during install. 
						 // Using in email notifications for unsubscribing.
						 // Don't change it!
?>
EOF;

  	print "Writing config file ... "; 	
 	if($handle = fopen("./config.php", 'w')) {
        	fwrite($handle, $config_file);
        	fclose($handle);
        	print "done<br>";
 	}
 	else {
		print "can't open config file for writing, you can manually create file config.php and copy/paste following content into it:<br>
		<textarea cols=80 rows=10>{$config_file}</textarea>";
 	}


	@mail("info@scriptsmill.com", "New install of comments", "Comments installed on {$_SERVER['HTTP_HOST']}", "From: Install <install@scriptsmill.com>\r\n");


 	print<<<EOF
<p><b>Installation complete.</b> Now include comments.php to your pages. See <b>readme.txt</b> for more info.</p>
EOF;

 }

 if($error_message) {
	print "<br><b>The following errors occured:</b><br>$error_message";
 }

 print<<<EOF
</body>
</html>
EOF;


}


?>