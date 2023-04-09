<?
require("config.php");
$script = "myaccount.php";
session_start();
$thisuser = $HTTP_SESSION_VARS["thisuser"];

if ($action == "login") {
	$arrSessions=$HTTP_SESSION_VARS; 
	session_destroy(); 
	foreach ($arrSessions as $session_name => $session_value) { 
		unset($$session_name); 
		} 
	unset($arrSessions);

	if (mysql_num_rows(mysql_query("SELECT * FROM messagex_user WHERE username = '$username' AND password = '$password' AND verify_code = '0'"))) {
		$thisuser = $username;
		session_register("thisuser");
		}
	else {
		$login_failed = 1;
		}
	}
elseif (!$action && !$thisuser) {
	header("Location: login.php");
	exit;
	}
else {
	if (!$thisuser) {
		$login_failed = 1;
		}
	}

print stripslashes($header);
?>

<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
	<td align=left><b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>My Account</font></b></td>
<? if ($thisuser) {
	print "<td align=right><font face=\"Trebuchet MS, Arial\" color=#FF7E15 size=2><b><a href=\"logout.php\">Logout</a></b></font></td>\n";
	}
?>
</tr>
</table>
<p>

<?

if ($login_failed) {
	print "Login information incorrect.";
	}
else {

	list($name, $email) = mysql_fetch_row(mysql_query("SELECT name, email FROM messagex_user WHERE username = '$thisuser'"));
	print "Welcome, $name!<p>\n";
	
	print "<script language = \"JavaScript\">\n";
	print "function showMsg(msg) {\n";
	print "	features = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=300,height=200';\n";
	print "	dlg = window.open (\"\",\"Dialog\",features);\n";
	print "	dlg.document.write (\"<body><font face=Arial size=2><b>Message:</b><p>\");\n";
	print "	dlg.document.write (msg);\n";
	print "	dlg.document.write (\"</font><p><form><center><input type='button' value='close' onclick='self.close()'></center></form></body>\");\n";
	print "	}\n";
	print "</script>\n";

	print "<b>Sent messages</b><br>";
	print "<table border=0 bgcolor=#000000 cellspacing=0 cellpadding=0 width=500><tr><td>\n";
	print "<table border=0 width=100%>\n";
	
	if (! mysql_num_rows(mysql_query("SELECT * FROM messagex_msg WHERE username = '$thisuser'"))) {
		print "<tr><td bgcolor=#FFEABD><font face=Arial size=2>You have not sent any messages yet.</font></td></tr>\n";
		}
	else {
		print "<tr>\n";
		print "<td bgcolor=#FFEABD><font face=Arial size=2><b>Crush</b></font></td>\n";
		print "<td bgcolor=#FFEABD><font face=Arial size=2><b>Email</b></font></td>\n";
		print "<td bgcolor=#FFEABD align=center><font face=Arial size=2><b>Message</b></font></td>\n";
		print "<td bgcolor=#FFEABD align=right><font face=Arial size=2><b>Date</b></font></td>\n";
		print "</tr>\n";
		
		$result = mysql_query("SELECT crush_name, crush_email, message, DATE_FORMAT(time, \"%e %b %y\") FROM messagex_msg WHERE username = '$thisuser' ORDER BY time DESC");
		
		for ($i=0;$i<mysql_num_rows($result);$i++) {
			list($crush_name, $crush_email, $message, $time) = mysql_fetch_row($result);
			print "<tr>\n";
			print "<td bgcolor=#FFEABD><font face=Arial size=2>$crush_name</font></td>\n";
			print "<td bgcolor=#FFEABD><font face=Arial size=2>$crush_email</font></td>\n";
			print "<td bgcolor=#FFEABD align=center><font face=Arial size=2><a href=\"javascript:showMsg('".addslashes(eregi_replace("\n", "<br>", $message))."')\"><img src=\"images/message.gif\" border=0></a></font></td>\n";
			print "<td bgcolor=#FFEABD align=right><font face=Arial size=2>$time</font></td>\n";
			print "</tr>\n";
			}
		}
	print "</table>\n";
	print "</td></tr></table>\n";

	print "<p>";
	print "<b>Received messages</b><br>";
	print "<table border=0 bgcolor=#000000 cellspacing=0 cellpadding=0 width=500><tr><td>\n";
	print "<table border=0 width=100%>\n";
	if (! mysql_num_rows(mysql_query("SELECT * FROM messagex_msg WHERE crush_email = '$email'"))) {
		print "<tr><td bgcolor=#FFEABD><font face=Arial size=2>You have not received any messages yet.</font></td></tr>\n";
		}
	else {
		print "<tr>\n";
		print "<td bgcolor=#FFEABD align=left><font face=Arial size=2><b>Sender</b></font></td>\n";
		print "<td bgcolor=#FFEABD align=center><font face=Arial size=2><b>Message</b></font></td>\n";
		print "<td bgcolor=#FFEABD align=right><font face=Arial size=2><b>Date</b></font></td>\n";
		print "</tr>\n";
		
		$result = mysql_query("SELECT username, message, DATE_FORMAT(time, \"%e %b %y\") FROM messagex_msg WHERE crush_email='$email' ORDER BY time DESC");
		
		for ($i=0;$i<mysql_num_rows($result);$i++) {
			list($username, $message, $time) = mysql_fetch_row($result);
			
			list($sender_email) = mysql_fetch_row(mysql_query("SELECT email FROM messagex_user WHERE username = '$username'"));
			$result2 = mysql_query("SELECT crush_name, crush_email FROM messagex_msg WHERE username = '$thisuser' AND crush_email = '$sender_email'");
			
			if (mysql_num_rows($result2)) {
				list($crush_name, $crush_email) = mysql_fetch_row($result2);
				$sender = "<a href=\"mailto:$crush_email\">$crush_name</a>";
				}
			else {
				$sender = "Unknown yet";
				}
			$message = "<a href=\"javascript:showMsg('".addslashes(eregi_replace("\n", "<br>", $message))."')\"><img src=\"images/message.gif\" border=0></a>";
			
			print "<tr>\n";
			print "<td bgcolor=#FFEABD align=left><font face=Arial size=2>$sender</font></td>\n";
			print "<td bgcolor=#FFEABD align=center><font face=Arial size=2>$message</font></td>\n";
			print "<td bgcolor=#FFEABD align=right><font face=Arial size=2>$time</font></td>\n";
			print "</tr>\n";
			}
		
		}
	print "</table>\n";
	print "</td></tr></table>\n";

	print "<p><b><a href=\"send.php\">Send my <b><font color=#000000>secret</font><font color=#ff0000>Messagex</font></b>!</a></b>\n";
	}
print stripslashes($footer);
?>