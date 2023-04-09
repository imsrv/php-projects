<?
require("config.php");
print stripslashes($header);

?>

	<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Retrieve password</font></b>
	<p>

<?
if ($action == 'retrieve') {
	$result = mysql_query("SELECT password FROM messagex_user WHERE email='$email'");

	if (mysql_num_rows($result)) {
		list($ad) = mysql_fetch_row(mysql_query("SELECT ad FROM messagex_ad ORDER BY RAND()"));
		list($password) = mysql_fetch_row($result);
		$mail_header = stripslashes("From: $admin_email");
		$mail_subject= stripslashes("Your password");
		$mail_body   = "Your password is: $password\n\n";
		$mail_body  .= $ad;
		mail("$email", $mail_subject, $mail_body, $mail_header);
		print "The password has been sent to your email address.";
		}
	else {
		print "The email you entered was not found in our database.";
		}
	print stripslashes($footer);
	exit;
	}

?>

	<form action="retrieve.php" method=post>
	Email address: <input type=text name=email size=30 style="font-family: Arial"><br>
	<input type=submit value=Retrieve my password style="font-family: Arial">
	<input type=hidden name="action" value=retrieve>
	</form>
	</p>

<? 
print stripslashes($footer);
?>