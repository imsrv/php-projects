<?
require("config.php");
$script = "sendmsg.php";
session_start();
$thisuser = $HTTP_SESSION_VARS["thisuser"];

if (!$thisuser) {
	header("Location: login.php");
	exit;
	}

print stripslashes($header);
?>

<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Send secretMessagex</font></b>
<p>

<?
list($name, $email) = mysql_fetch_row(mysql_query("SELECT name, email FROM messagex_user WHERE username = '$thisuser'"));

$error = 0;
if (!$crush_name) {
	$error = 1;
	print "<li>Crush's Name is missing</li>";
	}
if (!eregi(".+@.+\..+", $crush_email)) {
	print "<li>Crush's Email is invalid</li>";
	$error = 1;
	}
elseif (strtolower($crush_email) == strtolower($email)) {
	print "<li>You cannot send messages to yourself</li>";
	$error = 1;
	}
elseif (mysql_num_rows(mysql_query("SELECT * FROM messagex_msg WHERE username='$thisuser' AND crush_email = '$crush_email'"))) {
	print "<li>You have already sent a secret message to this email</li>";
	$error = 1;
	}	
if (strlen($message) >300) {
	print "<li>Your message is too long (max. 300 characters)</li>";
	$error = 1;
	}

if (!$error) {
	$query  = "INSERT INTO messagex_msg SET ";
	$query .= "username    = '$thisuser', ";
	$query .= "crush_name  = '$crush_name', ";
	$query .= "crush_email = '$crush_email', ";
	$query .= "message     = '$message', ";
	$query .= "time        = FROM_UNIXTIME(".time().") ";

	list($ad) = mysql_fetch_row(mysql_query("SELECT ad FROM messagex_ad ORDER BY RAND()"));

	$secret_email = ereg_replace("\[AD\]",              $ad,          $secret_email);
	$secret_email = ereg_replace("\[MESSAGE\]",         $message,     $secret_email);
	$secret_email = ereg_replace("\[SENDER\]",          $name,        $secret_email);
	$secret_email = ereg_replace("\[SENDER_EMAIL\]",    $email,       $secret_email);
	$secret_email = ereg_replace("\[RECIPIENT\]",       $crush_name,  $secret_email);
	$secret_email = ereg_replace("\[RECIPIENT_EMAIL\]", $crush_email, $secret_email);

	//print "$query<br>\n\n$secret_email";

	if (mysql_query($query)) {
		$mail_header = stripslashes("From: $admin_email");
		$mail_subject= stripslashes($secret_subject);
		$mail_body   = stripslashes($secret_email);
		mail($crush_email, $mail_subject, $mail_body, $mail_header);
		
		print "Your secret message has been sent successfully.<p>\n";
		print "<a href=\"send.php\">Send another secret message</a><br>\n";
		}


	// Check if they match
	
	$result = mysql_query("SELECT username, name FROM messagex_user WHERE email = '$crush_email'");
	if (mysql_num_rows($result)) {
		list($username, $crush_name) = mysql_fetch_row($result);
		
		$result = mysql_query("SELECT message FROM messagex_msg WHERE username = '$username' AND crush_email = '$email'");
		
		if (mysql_num_rows($result)) {
			list($message_received) = mysql_fetch_row($result);
			
			list($ad) = mysql_fetch_row(mysql_query("SELECT ad FROM messagex_ad ORDER BY RAND()"));

			$matched_email2 = $matched_email;

			$matched_email = ereg_replace("\[AD\]",              $ad,               $matched_email);
			$matched_email = ereg_replace("\[MESSAGE\]",         $message_received, $matched_email);
			$matched_email = ereg_replace("\[SENDER\]",          $crush_name,       $matched_email);
			$matched_email = ereg_replace("\[SENDER_EMAIL\]",    $crush_email,      $matched_email);
			$matched_email = ereg_replace("\[RECIPIENT\]",       $name,             $matched_email);
			$matched_email = ereg_replace("\[RECIPIENT_EMAIL\]", $email,            $matched_email);

			$mail_header = stripslashes("From: $admin_email");
			$mail_subject= stripslashes($matched_subject);
			$mail_body   = stripslashes($matched_email);
			mail($email, $mail_subject, $mail_body, $mail_header);


			$matched_email2 = ereg_replace("\[AD\]",              $ad,           $matched_email2);
			$matched_email2 = ereg_replace("\[MESSAGE\]",         $message,      $matched_email2);
			$matched_email2 = ereg_replace("\[SENDER\]",          $name,         $matched_email2);
			$matched_email2 = ereg_replace("\[SENDER_EMAIL\]",    $email,        $matched_email2);
			$matched_email2 = ereg_replace("\[RECIPIENT\]",       $crush_name, $matched_email2);
			$matched_email2 = ereg_replace("\[RECIPIENT_EMAIL\]", $crush_email,  $matched_email2);

			$mail_header = stripslashes("From: $admin_email");
			$mail_subject= stripslashes($matched_subject);
			$mail_body   = stripslashes($matched_email2);
			mail($crush_email, $mail_subject, $mail_body, $mail_header);


			}
		}
	}

print stripslashes($footer);
?>