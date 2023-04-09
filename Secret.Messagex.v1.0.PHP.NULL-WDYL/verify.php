<?
require("config.php");
$script = "verify.php";

print stripslashes($header);
?>

<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Email Verification</font></b>
<p>

<?
if ($action == 'verify') {
	$code = $verify_code;
	}
else {
	$code = getenv("QUERY_STRING");
	}

if (!$code || $code == '0' || !mysql_num_rows(mysql_query("SELECT * FROM messagex_user WHERE verify_code = '$code'"))) {
	print "Verification code is invalid!";
	}
else {
	if ($action != 'verify') {
		print "<form action=\"$script\" method=post>\n";
		print "Verification code: $code<p>\n";
		print "Enter your email:<br>\n";
		print "<input type=text name=v_email size=30 style=\"font-family: Courier New\"><p>\n";
		print "<input type=submit value=Submit style=\"font-family: Arial\">";
		print "<input type=hidden name=verify_code value=$code>";
		print "<input type=hidden name=action value=verify>";
		print "</form>\n";
		}
	else {
		if (!mysql_num_rows(mysql_query("SELECT * FROM messagex_user WHERE verify_code = '$verify_code' AND email = '$v_email'"))) {
			print "Email does not match with the one registered.";
			}
		else {
			if (mysql_query("UPDATE messagex_user SET verify_code = '0' WHERE verify_code = '$verify_code' AND email = '$v_email'")) {
				print "Thank you! Your email has been verified, you can now send <b><font color=#000000>secret</font><font color=#ff0000>Messagex</font></b> to your crush. Good Luck!";
				}
			}
		}
	}
print stripslashes($footer);
?>