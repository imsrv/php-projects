<?
require("config.php");

print stripslashes($header);
?>

<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Register</font></b>
<p>

<?

$error = 0;
if (!eregi("^[[:alnum:]]{6,12}$", $username)) {
	print "<li>Username is invalid</li>";
	$error = 1;
	}
elseif (mysql_num_rows(mysql_query("SELECT * FROM messagex_user WHERE username='$username'"))) {
	print "<li>Username is already in use</li>";
	$error = 1;
	}
if (!eregi("^[[:alnum:]]{6,12}$", $password)) {
	print "<li>Password is invalid</li>";
	$error = 1;
	}
if (!$name) {
	$error = 1;
	print "<li>Name is missing</li>";
	}
if (!eregi(".+@.+\..+", $email)) {
	print "<li>Email is invalid</li>";
	$error = 1;
	}
elseif (mysql_num_rows(mysql_query("SELECT * FROM messagex_user WHERE email='$email'"))) {
	print "<li>You already have an account</li>";
	$error = 1;
	}

$result = mysql_query("SELECT field_name, field_title FROM messagex_field WHERE enabled = '1' AND required = '1'");
for ($i=0;$i<mysql_num_rows($result);$i++) {
	list($field_name, $field_title) = mysql_fetch_row($result);
	if (!${$field_name}) {
		print "<li>$field_title is missing</li>";
		$error = 1;
		}
	}



if (!$error) {
	
	$fields = array();
	$result = mysql_query("SELECT field_name FROM messagex_field WHERE enabled = '1'");
	for ($i=0;$i<mysql_num_rows($result);$i++) {
		list($field_name) = mysql_fetch_row($result);
		$fields[] = ",$field_name = '${$field_name}' ";
		}

	$verify_code = rand();
	
	$query  = "INSERT INTO messagex_user SET ";
	$query .= "username    = '$username', ";
	$query .= "password    = '$password', ";
	$query .= "name        = '$name', ";
	$query .= "email       = '$email', ";
	$query .= "verify_code = '$verify_code' ";
	$query .= join("", $fields);

	list($ad) = mysql_fetch_row(mysql_query("SELECT ad FROM messagex_ad ORDER BY RAND()"));

	$verify_email = ereg_replace("\[AD\]",              $ad,           $verify_email);
	$verify_email = ereg_replace("\[VERIFY_CODE\]",    "$verify_code", $verify_email);
	$verify_email = ereg_replace("\[RECIPIENT\]",       $name,         $verify_email);
	$verify_email = ereg_replace("\[RECIPIENT_EMAIL\]", $email,        $verify_email);

	if (mysql_query($query)) {
		$mail_header = stripslashes("From: $admin_email");
		$mail_subject= stripslashes($verify_subject);
		$mail_body   = stripslashes($verify_email);
		mail($email, $mail_subject, $mail_body, $mail_header);
		
		print "The verification email has been sent to your email address, please check your mail box and follow the instructions to verify your email. After that you will be able to send <b><font color=#000000>secret</font><font color=#ff0000>Messagex</font></b> to your crush!";
		}
	}


print stripslashes($footer);
?>