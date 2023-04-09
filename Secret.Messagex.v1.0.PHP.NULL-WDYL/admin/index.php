<?
require("../config.php");


if ($action == "fields") {
	head("Edit custom fields");
	if ($confirm == 'yes') {
		for ($i=1;$i<=6;$i++){
			if ($enabled[$i] != '1') {
				$enabled[$i] = '0';
				}
			if ($required[$i] != '1') {
				$required[$i] = '0';
				}
			mysql_query("UPDATE messagex_field SET field_title='$field_title[$i]', enabled='$enabled[$i]', required='$required[$i]' WHERE field_name='field_$i'");
			}
		print "Custom fields updated";
		}
	else {
		print "<form action=index.php method=post>\n";

		print "<table border=0 align=center>\n";
		print "<tr>\n";
		print "<td><font face=Arial size=2><b>Field</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Title</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Enabled</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Required</b></font></td>\n";
		print "</tr>\n";

		for ($i=1;$i<=6;$i++) {
			list($field_title, $enabled, $required) = mysql_fetch_row(mysql_query("SELECT field_title, enabled, required FROM messagex_field WHERE field_name = 'field_$i'"));
			$field_title = stripslashes($field_title);
			print "<tr>\n";
			print "<td align=center><font face=Arial size=2>field_$i</font></td>\n";
			print "<td><font face=Arial size=2><input type=text name=\"field_title[$i]\" size=30 value=\"$field_title\"></font></td>\n";
			if ($enabled)
				print "<td align=center><input type=checkbox name=\"enabled[$i]\" value=1 checked></font></td>\n";
			else
				print "<td align=center><input type=checkbox name=\"enabled[$i]\" value=1></font></td>\n";
			if ($required)
				print "<td align=center><input type=checkbox name=\"required[$i]\" value=1 checked></font></td>\n";
			else
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
		print "<input type=submit value='Submit' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=action value=fields>\n";
		print "<input type=hidden name=confirm value=yes>\n";
		print "</p>\n";
		print "</form>\n";	
		}
	foot();
	}
elseif ($action == "templates") {
	head("Edit templates");
	if ($confirm == 'yes') {	
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_header)."' WHERE name = 'header'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_footer)."' WHERE name = 'footer'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_admin_email)."'     WHERE name = 'admin_email'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_verify_subject)."'  WHERE name = 'verify_subject'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_verify_email)."'    WHERE name = 'verify_email'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_secret_subject)."'  WHERE name = 'secret_subject'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_secret_email)."'    WHERE name = 'secret_email'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_matched_subject)."' WHERE name = 'matched_subject'");
		mysql_query("UPDATE messagex_text SET content='".addslashes($new_matched_email)."'   WHERE name = 'matched_email'");
		print "Templates updated";
		}
	else {
		list($header) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='header'"));
		list($footer) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='footer'"));
		list($s_email) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='secret_email'"));
		list($m_email) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='matched_email'"));
		list($v_email) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='verify_email'"));
		list($secret_subject) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='secret_subject'"));
		list($matched_subject) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='matched_subject'"));
		list($verify_subject) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='verify_subject'"));
		list($admin_email) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='admin_email'"));
	
		$header = stripslashes($header);
		$footer = stripslashes($footer);
		$s_email = stripslashes($s_email);
		$m_email = stripslashes($m_email);
		$v_email = stripslashes($v_email);
		$secret_subject = stripslashes($secret_subject);
		$matched_subject = stripslashes($matched_subject);
		$verify_subject = stripslashes($verify_subject);
		$admin_email = stripslashes($admin_email);
	
		print "<form action=index.php method=post>\n";
		print "<b>Header:</b><br>\n";
		print "<textarea name=new_header cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$header</textarea><p>\n";
		print "<b>Footer:</b><br>\n";
		print "<textarea name=new_footer cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$footer</textarea><p>\n";

		print "<b>Admin Email:</b><br>\n";
		print "<input type=text name=new_admin_email value=\"$admin_email\" size=50 style=\"font-family: Courier New\"><p>\n";

		print "<b>Verification Email Subject:</b><br>\n";
		print "<input type=text name=new_verify_subject value=\"$verify_subject\" size=50 style=\"font-family: Courier New\"><br>\n";
		print "<b>Verification Email:</b><br>\n";
		print "<font color=red><b>Replacement code:</b><br>[RECIPIENT], [RECIPIENT_EMAIL], [VERIFY_CODE], [AD]</font><br>\n";
		print "<textarea name=new_verify_email cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$v_email</textarea><p>\n";

		print "<b>Secret Email Subject:</b><br>\n";
		print "<input type=text name=new_secret_subject value=\"$secret_subject\" size=50 style=\"font-family: Courier New\"><br>\n";
		print "<b>Secret Email:</b><br>\n";
		print "<font color=red><b>Replacement code:</b><br>[SENDER], [SENDER_EMAIL], [RECIPIENT], [RECIPIENT_EMAIL], [MESSAGE], [AD]</font><br>\n";
		print "<textarea name=new_secret_email cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$s_email</textarea><p>\n";

		print "<b>Matched Email Subject:</b><br>\n";
		print "<input type=text name=new_matched_subject value=\"$matched_subject\" size=50 style=\"font-family: Courier New\"><br>\n";
		print "<b>Matched Email:</b><br>\n";
		print "<font color=red><b>Replacement code:</b><br>[SENDER], [SENDER_EMAIL], [RECIPIENT], [RECIPIENT_EMAIL], [MESSAGE], [AD]</font><br>\n";
		print "<textarea name=new_matched_email cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$m_email</textarea><p>\n";

		print "<p align=center>\n";
		print "<input type=submit value='Submit' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=action value=templates>\n";
		print "<input type=hidden name=confirm value=yes>\n";
		print "</p>\n";
		print "</form>\n";
		}
	foot();
	}
elseif ($action == "users") {
	head("Delete users");
	if ($confirm == 'yes') {
		foreach ($user AS $i => $username) {
			if ($username != '') {
				mysql_query("DELETE FROM messagex_user WHERE username = '$username'");
				print "$username deleted<br>\n";
				}
			}
		}
	else {
		print "<form action=index.php method=post>\n";

		print "<table border=0 align=center>\n";
		print "<tr>\n";
		print "<td><font face=Arial size=2><b>Username</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Name</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Email</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Validated</b></font></td>\n";
		print "<td><font face=Arial size=2><b>Delete</b></font></td>\n";
		print "</tr>\n";

		$result = mysql_query("SELECT username, name, email, verify_code FROM messagex_user ORDER BY username");

		for ($i=0;$i<mysql_num_rows($result);$i++) {
			list($username, $name, $email, $verify_code) = mysql_fetch_row($result);
			if ($verify_code == 0) $validated = "Yes";
			else $validated = "No";
		
			print "<tr>\n";
			print "<td><font face=Arial size=2>$username</font></td>\n";
			print "<td><font face=Arial size=2>$name</font></td>\n";
			print "<td><font face=Arial size=2>$email</font></td>\n";
			print "<td align=center><font face=Arial size=2>$validated</font></td>\n";
			print "<td align=center><font face=Arial size=2><input type=checkbox name=user[$i] value=\"$username\"></font></td>\n";
			print "</tr>\n";
			}

		print "</table>\n";
		print "<p align=center>\n";
		print "<input type=submit value='Delete' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=action value=users>\n";
		print "<input type=hidden name=confirm value=yes>\n";
		print "</p>\n";
		print "</form>\n";
		}
	foot();
	}
elseif ($action == "ad") {
	head("Add/Remove ADs");
	if ($confirm == 'delete') {
		foreach ($ad_id AS $i => $id) {
			if ($id != '') {
				mysql_query("DELETE FROM messagex_ad WHERE id = '$id'");
				print "AD ($id) deleted<br>\n";
				}
			}
		print "<p>";
		}
	elseif ($confirm == 'add') {
		mysql_query("INSERT INTO messagex_ad set ad = '$new_ad'");
		print "<p>AD added</p>";
		}

		$result = mysql_query("SELECT id, ad FROM messagex_ad ORDER BY id");
		
		print "<form action=index.php method=post>\n";
		print "<table border=0 align=center width=400>\n";
		print "<tr>\n";
		print "<td><font face=Arial size=2><b>AD</b></font></td>\n";
		print "<td align=right><font face=Arial size=2><b>Delete</b></font></td>\n";
		print "</tr>\n";			

		for ($i=0;$i<mysql_num_rows($result);$i++) {
			list($id, $ad) = mysql_fetch_row($result);
			$ad = eregi_replace(" ", "&nbsp;", $ad);
			$ad = eregi_replace("\n", "<br>\n", $ad);
			print "<tr>\n";
			print "<td align=left><font face=\"Courier New\" size=1>$ad</font></td>\n";
			print "<td align=right><font face=Arial size=2><input type=checkbox name=ad_id[$i] value=\"$id\"></font></td>\n";
			print "</tr>\n";
			}
			
		print "</table>\n";
		print "<p align=center>\n";
		print "<input type=submit value='Delete' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=action value=ad>\n";
		print "<input type=hidden name=confirm value=delete>\n";
		print "</p>\n";
		print "</form>\n";
		
		
		print "<form action=index.php method=post>\n";
		print "<p align=center>\n";
		print "<textarea name=new_ad cols=50 rows=10 wrap=off style=\"font-family: Courier New\"></textarea>\n";
		print "</p>\n";
		print "<p align=center>\n";
		print "<input type=submit value='Add' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=action value=ad>\n";
		print "<input type=hidden name=confirm value=add>\n";
		print "</p>\n";
		print "</form>\n";
				
	foot();
	}
elseif ($action == "email") {
	head("Send email to users");
	if ($confirm == 'yes') {
		if ($email_subject && $email_body) {
			$result = mysql_query("SELECT name, email FROM messagex_user WHERE verify_code = '0' ORDER BY username");
			for ($i=0;$i<mysql_num_rows($result);$i++) {
				list($name, $email) = mysql_fetch_row($result);
				list($ad) = mysql_fetch_row(mysql_query("SELECT ad FROM messagex_ad ORDER BY RAND()"));
				$temp = $email_body;

				$temp = ereg_replace("\[AD\]",              $ad,    $temp);
				$temp = ereg_replace("\[RECIPIENT\]",       $name,  $temp);
				$temp = ereg_replace("\[RECIPIENT_EMAIL\]", $email, $temp);

				$mail_header = stripslashes("From: $admin_email");
				$mail_subject= stripslashes($email_subject);
				$mail_body   = stripslashes($email_body);
				mail("\"$name\" <$email>", $mail_subject, $mail_body, $mail_header);

				print "<li>Sent to <a href=\"mailto:$email\">\"$name\"</a></li>\n";
				}
			print "<p>Finished.</p>\n";
			}
		else {
			print "Email subject and message body are required.";
			}
		}
	else {
		print "<form action=index.php method=post>\n";
		print "<b>Email Subject:</b><br>\n";
		print "<input type=text name=email_subject size=50 style=\"font-family: Courier New\"><br>\n";
		print "<b>Email body:</b><br>\n";
		print "<font color=red><b>Replacement code:</b><br>[RECIPIENT], [RECIPIENT_EMAIL], [AD]</font><br>\n";
		print "<textarea name=email_body cols=50 rows=15 wrap=off style=\"font-family: Courier New\">$s_email</textarea><p>\n";

		print "<p align=center>\n";
		print "<input type=submit value='Submit' style='font-family: Arial; font-weight: bold; background: #ffffff; color:#587AB1'>\n";
		print "<input type=hidden name=action value=email>\n";
		print "<input type=hidden name=confirm value=yes>\n";
		print "</p>\n";
		print "</form>\n";
		}
	foot();
	}
elseif ($action == "stats") {
	head("Show statistics");
	list($ttl_users) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM messagex_user"));
	list($verified_users) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM messagex_user WHERE verify_code = '0'"));
	
	print "<b>Total users registered:</b> $ttl_users<br>\n";
	print "<b>Total users verified:</b> $verified_users<br>\n";
	
	
	for ($i=0;$i<6;$i++) {
		list($enabled, $field_title) = mysql_fetch_row(mysql_query("SELECT enabled, field_title FROM messagex_field WHERE field_name = 'field_$i'"));
		if ($enabled) {
			print "<p>\n";
			print "<b>$field_title</b><br>\n";
			print "<table border=0 align=center width=400>\n";

			$result = mysql_query("SELECT field_$i, COUNT(field_$i) AS count_field FROM messagex_user GROUP BY field_$i ORDER BY count_field DESC");
			for ($j=0;$j<mysql_num_rows($result);$j++) {
				list($field, $count_field) = mysql_fetch_row($result);
				if ($field == '') $field = "(n/a)";
				print "<tr>\n";
				print "<td><font face=Arial size=2><b>$field</b></font></td>\n";
				print "<td><font face=Arial size=2><b>$count_field</b></font></td>\n";
				}
			print "</table>\n";
			print "</p>\n";
			}
		}
	
	
	foot();
	}
else {
	head("Administration Center");
	print "<table border=0 align=center><tr><td><font face=Arial size=2>\n";
	print "<li><a href='index.php?action=fields'>Edit custom fields</a></li>\n";
	print "<li><a href='index.php?action=templates'>Edit templates</a></li>\n";
	print "<li><a href='index.php?action=users'>Delete users</a></li>\n";
	print "<li><a href='index.php?action=ad'>Add/Remove ADs</a></li>\n";
	print "<li><a href='index.php?action=email'>Send email to users</a></li>\n";
	print "<li><a href='index.php?action=stats'>Show statistics</a></li>\n";
	print "</font></td></tr></table>\n";
	foot();
	}


function head ($msg) {
	print "<head>\n";
	print "<title>Secret Messagex Administration</title>\n";
	print "</head>\n";
	print "<body bgcolor=\"#FFEABD\" text=\"#000000\" link=\"#FF6779\" vlink=\"#FF7267\">\n";
	print "<table width=\"550\" height=400 border=\"0\" cellpadding=\"2\" cellspacing=\"0\" align=center bgcolor=#ffffff>\n";
	print "<tr><td colspan=\"3\" width=\"550\" height=\"60\" align=center><img src=\"../images/logo.gif\"></td></tr>\n";
	print "<tr>\n";
	print "	<td width=20 height=\"289\"><img src=\"../images/transparent.gif\"></td>\n";
	print "	<td width=510 height=\"289\" bgcolor=\"#FFEABD\">\n";
	print "	<table width=510 border=0 cellspacing=0 cellpadding=0><tr><td>\n";
	print "		<font color=\"#000000\" face=Arial size=2>\n";
	print "		<p align=center><font size=3><b>$msg</b></font></p>\n";
	}
function foot () {
	print "<p align=right><a href=\"index.php\">home</a></p>\n";
	print "		</font>\n";
	print "	</td></tr></table>\n";
	print "	</td>\n";
	print "	<td width=20 height=\"289\"><img src=\"../images/transparent.gif\"></td>\n";
	print "</tr>\n";
	print "</table>\n";
	print "</body>\n";
	print "</html>\n";
	}
?>