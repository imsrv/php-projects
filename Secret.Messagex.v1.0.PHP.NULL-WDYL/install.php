<?
#######################################################################
#                         Secret Messagex v1.0 by WDYL                       #
#######################################################################

require("config.php");

$page = $page ? $page : 1;
$script = 'install.php';

switch ($page) {
	case 1:
		head("Secret Messagex Installation");
		print "Make sure you have edited config.php and entered your MySQL login and password correctly.\n";
		print "<p>\n";
		print "The following are what you have set:<br>\n";
		print "<font face='Courier New'>\n";
		print "Your MySQL login&nbsp;&nbsp;&nbsp;&nbsp;: $mysql_username<br>\n";
		print "Your MySQL password&nbsp;: $mysql_password<br>\n";
		print "Your MySQL database&nbsp;: $mysql_database<br>\n";
		print "Your MySQL host&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $mysql_host\n";
		print "</font>\n";
		print "</p>\n";
		print "If you are ready, click the following button to continue.\n";
		print "<form action=$script method=post>\n";
		print "<p align=center>\n";
		print "<input type=submit value='Continue...' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=page value=2>\n";
		print "<input type=hidden name=action value=setsql>\n";
		print "</p>\n";
		print "</form>\n";
		foot();
		break;

	case 2:
		$query[0] = "DROP TABLE IF EXISTS messagex_ad";
		$query[1] = "CREATE TABLE `messagex_ad` (  `id` int(10) unsigned NOT NULL auto_increment,  `ad` text NOT NULL,  `time` int(10) unsigned NOT NULL default '0',  PRIMARY KEY  (`id`))";
		$query[2] = "DROP TABLE IF EXISTS messagex_field";
		$query[3] = "CREATE TABLE `messagex_field` (  `field_name` varchar(12) NOT NULL default '',  `field_title` varchar(255) NOT NULL default '',  `enabled` tinyint(1) unsigned NOT NULL default '0',  `required` tinyint(1) unsigned NOT NULL default '0',  PRIMARY KEY  (`field_name`))";
		$query[4] = "DROP TABLE IF EXISTS messagex_msg";
		$query[5] = "CREATE TABLE `messagex_msg` (  `username` varchar(12) binary NOT NULL default '',  `crush_name` varchar(50) NOT NULL default '',  `crush_email` varchar(50) NOT NULL default '',  `message` text NOT NULL,  `time` datetime NOT NULL default '0000-00-00 00:00:00')";
		$query[6] = "DROP TABLE IF EXISTS messagex_text";
		$query[7] = "CREATE TABLE `messagex_text` (  `name` varchar(15) NOT NULL default '',  `content` text NOT NULL,  PRIMARY KEY  (`name`))";
		$query[8] = "DROP TABLE IF EXISTS messagex_user";
		$query[9] = "CREATE TABLE `messagex_user` (  `username` varchar(12) binary NOT NULL default '',  `password` varchar(12) binary NOT NULL default '',  `name` varchar(50) NOT NULL default '',  `email` varchar(50) NOT NULL default '', `verify_code` int(15) unsigned NOT NULL default '0', `field_1` varchar(255) NOT NULL default '',  `field_2` varchar(255) NOT NULL default '',  `field_3` varchar(255) NOT NULL default '',  `field_4` varchar(255) NOT NULL default '',  `field_5` varchar(255) NOT NULL default '',  `field_6` varchar(255) NOT NULL default '',  PRIMARY KEY  (`username`))";

		$query[10] = "INSERT INTO messagex_field VALUES ('field_1','','','')";
		$query[11] = "INSERT INTO messagex_field VALUES ('field_2','','','')";
		$query[12] = "INSERT INTO messagex_field VALUES ('field_3','','','')";
		$query[13] = "INSERT INTO messagex_field VALUES ('field_4','','','')";
		$query[14] = "INSERT INTO messagex_field VALUES ('field_5','','','')";
		$query[15] = "INSERT INTO messagex_field VALUES ('field_6','','','')";

		$query[16] = "INSERT INTO messagex_text VALUES ('header','')";
		$query[17] = "INSERT INTO messagex_text VALUES ('footer','')";
		$query[18] = "INSERT INTO messagex_text VALUES ('secret_email','')";
		$query[19] = "INSERT INTO messagex_text VALUES ('matched_email','')";
		$query[20] = "INSERT INTO messagex_text VALUES ('verify_email','')";
		$query[21] = "INSERT INTO messagex_text VALUES ('secret_subject','')";
		$query[22] = "INSERT INTO messagex_text VALUES ('matched_subject','')";
		$query[23] = "INSERT INTO messagex_text VALUES ('verify_subject','')";
		$query[24] = "INSERT INTO messagex_text VALUES ('admin_email','')";


		$message = array(
			"DROP TABLE messagex_ad",
			"CREATE TABLE messagex_ad",
			"DROP TABLE messagex_field",
			"CREATE TABLE messagex_field",
			"DROP TABLE messagex_msg",
			"CREATE TABLE messagex_msg",
			"DROP TABLE messagex_text",
			"CREATE TABLE messagex_text",
			"DROP TABLE messagex_user",
			"CREATE TABLE messagex_user"
			);
	
		head("Creating MySQL tables...");
		if ($action=='setsql') {
			$failed = 0;
			for ($i=0; $i<10; $i++) {
				$result = mysql_query($query[$i]);
				if ($result) {
					print "$message[$i] successful.<br>";
					}
				else {
					print "$message[$i] not successful.<br>";
					print "mysql_error($result)<br>";
					$failed = 1;
					}
				}

			if (!$failed) {
				for ($i=10; $i<25; $i++) {
					$result = mysql_query($query[$i]);
					}
				}

			if (!$failed) {
				print "<form action=$script method=post>\n";
				print "<p align=center>\n";
				print "<input type=submit value='Continue...' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
				print "<input type=hidden name=page value=3>\n";
				print "<input type=hidden name=action value=config>\n";
				print "</p>\n";
				print "</form>\n";
				}
			}
		foot();
		break;

	case 3:
		head("Setting Secret Messagex custom fields...");
		
		if ($action=='config') {
			print "<form action=$script method=post>\n";

			print "<table border=0 align=center>\n";
			print "<tr>\n";
			print "<td><font face=Arial size=2><b>Field</b></font></td>\n";
			print "<td><font face=Arial size=2><b>Title</b></font></td>\n";
			print "<td><font face=Arial size=2><b>Enabled</b></font></td>\n";
			print "<td><font face=Arial size=2><b>Required</b></font></td>\n";
			print "</tr>\n";

			for ($i=1;$i<=6;$i++) {
				print "<tr>\n";
				print "<td align=center><font face=Arial size=2>field_$i</font></td>\n";
				print "<td><font face=Arial size=2><input type=text name=\"field_title[$i]\" size=30></font></td>\n";
				print "<td align=center><input type=checkbox name=\"enabled[$i]\" value=1></font></td>\n";
				print "<td align=center><input type=checkbox name=\"required[$i]\" value=1></font></td>\n";
				print "</tr>\n";
				}
			print "<tr>\n";
			print "<td align=center><font face=Arial size=2>e.g.</font></td>\n";
			print "<td><font face=Arial size=2><input type=text value=\"Country\" size=30 disabled></font></td>\n";
			print "<td align=center><input type=checkbox checked disabled></font></td>\n";
			print "<td align=center><input type=checkbox disabled></font></td>\n";
			print "</tr>\n";
			print "</table>\n";

			print "<p align=center>\n";
			print "<input type=submit value='Continue...' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
			print "<input type=hidden name=page value=4>\n";
			print "<input type=hidden name=action value=config>\n";
			print "</p>\n";
			print "</form>\n";
			}
		foot();
		break;

	case 4:
		head("Setting Secret Messagex templates");
		if ($action=='config') {
			
			for ($i=1;$i<=6;$i++){
				if ($enabled[$i] != '1') {
					$enabled[$i] = '0';
					}
				if ($required[$i] != '1') {
					$required[$i] = '0';
					}
					
				mysql_query("UPDATE messagex_field SET field_title='$field_title[$i]', enabled='$enabled[$i]', required='$required[$i]' WHERE field_name='field_$i'");
				}
		
			print "<form action=$script method=post>\n";

			$header .= "<head>\n";
			$header .= "<title>Secret Messagex [WDYL]</title>\n";
			$header .= "</head>\n";
			$header .= "<body bgcolor=\"#FFEABD\" text=\"#000000\" link=\"#FF6779\" vlink=\"#FF7267\">\n";
			$header .= "<table width=\"550\" height=400 border=\"0\" cellpadding=\"2\" cellspacing=\"0\" align=center bgcolor=#ffffff>\n";
			$header .= "<tr><td colspan=\"3\" width=\"550\" height=\"60\" align=center><img src=\"images/logo.gif\"></td></tr>\n";
			$header .= "<tr>\n";
			$header .= "	<td width=20 height=\"289\"><img src=\"images/transparent.gif\"></td>\n";
			$header .= "	<td width=510 height=\"289\" bgcolor=\"#FFEABD\">\n";
			$header .= "	<table width=510 border=0 cellspacing=0 cellpadding=0><tr><td>\n";
			$header .= "		<font color=\"#000000\" face=Arial size=2>\n";
			$header .= "		<p align=center><font size=3><b>$msg</b></font></p>\n";

			$footer .= "		</font>\n";
			$footer .= "	</td></tr></table>\n";
			$footer .= "	</td>\n";
			$footer .= "	<td width=20 height=\"289\"><img src=\"images/transparent.gif\"></td>\n";
			$footer .= "</tr>\n";
			$footer .= "</table>\n";
			$footer .= "</body>\n";
			$footer .= "</html>\n";
			
			$s_email .= "[RECIPIENT],\n";
			$s_email .= "\n";
			$s_email .= "Someone has sent you a secret message!\n";
			$s_email .= "Surprised?\n";
			$s_email .= "To find out who and what message s/he has sent to you,\n";
			$s_email .= "visit http://www.yourdomain.com\n";
			$s_email .= "\n";
			$s_email .= "*******************************************************\n";
			$s_email .= "[AD]\n";
			
			$m_email .= "[RECIPIENT],\n";
			$m_email .= "\n";
			$m_email .= "Congratulations!!\n";
			$m_email .= "You have been matched through SecretMessagex!\n";
			$m_email .= "To see who you have been matched with, and what\n";
			$m_email .= "secret message s/he has sent to you,\n";
			$m_email .= "visit http://www.yourdomain.com and log in your\n";
			$m_email .= "account now!\n";
			$m_email .= "\n";
			$m_email .= "*******************************************************\n";
			$m_email .= "[AD]\n";

			$v_email .= "[RECIPIENT],\n";
			$v_email .= "\n";
			$v_email .= "Please visit\n";
			$v_email .= "http://www.yourdomain.com/verify.php?[VERIFY_CODE]\n";
			$v_email .= "to verify your email. \n";
			$v_email .= "And you'll be able to send secret messages to your\n";
			$v_email .= "crush after that.\n";
			$v_email .= "\n";
			$v_email .= "*******************************************************\n";
			$v_email .= "[AD]\n";

			print "<b>Header:</b><br>\n";
			print "<textarea name=\"header\" cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$header</textarea><p>\n";
			print "<b>Footer:</b><br>\n";
			print "<textarea name=\"footer\" cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$footer</textarea><p>\n";

			print "<b>Admin Email:</b><br>\n";
			print "<input type=text name=\"admin_email\" value=\"webmaster@yourdomain.com\" size=50 style=\"font-family: Courier New\"><p>\n";

			print "<b>Verification Email Subject:</b><br>\n";
			print "<input type=text name=\"verify_subject\" value=\"SecretMessagex\" size=50 style=\"font-family: Courier New\"><br>\n";
			print "<b>Verification Email:</b><br>\n";
			print "<font color=red><b>Replacement code:</b><br>[RECIPIENT], [RECIPIENT_EMAIL], [VERIFY_CODE], [AD]</font><br>\n";
			print "<textarea name=\"verify_email\" cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$v_email</textarea><p>\n";

			print "<b>Secret Email Subject:</b><br>\n";
			print "<input type=text name=\"secret_subject\" value=\"You have a secret message! (this isn't junk mail!)\" size=50 style=\"font-family: Courier New\"><br>\n";
			print "<b>Secret Email:</b><br>\n";
			print "<font color=red><b>Replacement code:</b><br>[SENDER], [SENDER_EMAIL], [RECIPIENT], [RECIPIENT_EMAIL], [MESSAGE], [AD]</font><br>\n";
			print "<textarea name=\"secret_email\" cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$s_email</textarea><p>\n";

			print "<b>Matched Email Subject:</b><br>\n";
			print "<input type=text name=\"matched_subject\" value=\"You matched!\" size=50 style=\"font-family: Courier New\"><br>\n";
			print "<b>Matched Email:</b><br>\n";
			print "<font color=red><b>Replacement code:</b><br>[SENDER], [SENDER_EMAIL], [RECIPIENT], [RECIPIENT_EMAIL], [MESSAGE], [AD]</font><br>\n";
			print "<textarea name=\"matched_email\" cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$m_email</textarea><p>\n";

			print "<p align=center>\n";
			print "<input type=submit value='Continue...' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
			print "<input type=hidden name=page value=5>\n";
			print "<input type=hidden name=action value=config>\n";
			print "</p>\n";
			print "</form>\n";
			}
		foot();
		break;
		
	case 5:
		head("Remove The Installation Script...");
		
		if ($action=='config') {
			mysql_query("UPDATE messagex_text SET content='$header' WHERE name = 'header'");
			mysql_query("UPDATE messagex_text SET content='$footer' WHERE name = 'footer'");
			mysql_query("UPDATE messagex_text SET content='$admin_email'     WHERE name = 'admin_email'");
			mysql_query("UPDATE messagex_text SET content='$verify_subject'  WHERE name = 'verify_subject'");
			mysql_query("UPDATE messagex_text SET content='$verify_email'    WHERE name = 'verify_email'");
			mysql_query("UPDATE messagex_text SET content='$secret_subject'  WHERE name = 'secret_subject'");
			mysql_query("UPDATE messagex_text SET content='$secret_email'    WHERE name = 'secret_email'");
			mysql_query("UPDATE messagex_text SET content='$matched_subject' WHERE name = 'matched_subject'");
			mysql_query("UPDATE messagex_text SET content='$matched_email'   WHERE name = 'matched_email'");			
			
			print "The installation of Secret Messagex has been done.\n";
			print "<p>\n";
			print "<b>IMPORTANT:</b> For security reasons, please delete this file on your server.";
			print "</p>\n";
			print "After that, you can go to <a href='./admin/index.php'>the Administration Panel</a> to customize your Secret Messagex.\n";

			}
		foot();
		break;
		
	}

function head ($msg) {
	print "<head>\n";
	print "<title>Secret Messagex Installation</title>\n";
	print "</head>\n";
	print "<body bgcolor=\"#FFEABD\" text=\"#000000\" link=\"#FF6779\" vlink=\"#FF7267\">\n";
	print "<table width=\"550\" height=400 border=\"0\" cellpadding=\"2\" cellspacing=\"0\" align=center bgcolor=#ffffff>\n";
	print "<tr><td colspan=\"3\" width=\"550\" height=\"60\" align=center><img src=\"images/logo.gif\"></td></tr>\n";
	print "<tr>\n";
	print "	<td width=20 height=\"289\"><img src=\"images/transparent.gif\"></td>\n";
	print "	<td width=510 height=\"289\" bgcolor=\"#FFEABD\">\n";
	print "	<table width=510 border=0 cellspacing=0 cellpadding=0><tr><td>\n";
	print "		<font color=\"#000000\" face=Arial size=2>\n";
	print "		<p align=center><font size=3><b>$msg</b></font></p>\n";
	}
function foot () {
	print "		</font>\n";
	print "	</td></tr></table>\n";
	print "	</td>\n";
	print "	<td width=20 height=\"289\"><img src=\"images/transparent.gif\"></td>\n";
	print "</tr>\n";
	print "</table>\n";
	print "</body>\n";
	print "</html>\n";
	}

?>