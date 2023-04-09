<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
include("func.inc.php");

// Header
$cur = 'Compose Message';
include("header.php");

function doerror($err) {
echo '<div id="textbox" align="center"><b>Error:</b><br /><br />'.$err.'<br /><br /><a href="javascript:history.go(-1)">&lt;&lt; Go Back</a> | <a href="index.php">Home</a></div>';
include("footer.php");
exit();
}

$to = stripslashes($_POST['to']);
$cc = stripslashes($_POST['cc']);
$subject = htmlspecialchars(addslashes($_POST['subject']), ENT_QUOTES);
$msg = addslashes($_POST['message']);
$time = time();
$to_array = array();
$cc_array = array();
$sent_users = array();

if ($to !== "") {
// Cater for multiple users in to field
$to_explode = explode(',', $to);
for ($i = 0; $i < count($to_explode); $i++) {
$user = trim($to_explode[$i]);
$check = checkuser($user);
if ($check == 0) {
doerror('The user &quot;<b>'.$user.'</b>&quot; does not exist!');
}
if ($check > 1) {
doerror('The user &quot;<b>'.$user.'</b>&quot; is found more than once in the database!<br />Please go back and be more specific (clicking on the &quot;To...&quot; button will bring up the contacts list).');
}
$uid = getuserid($user);
$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$uid'");
$fetch = mysql_fetch_row($get);
$usersname = $fetch[0] . " " . $fetch[1];
$sent_users[] = $usersname;
$to_array[] = $uid;
}
}
elseif ($cc !== "") {
// Cater for multiple users in cc field
$cc_explode = explode(',', $cc);
for ($i = 0; $i < count($cc_explode); $i++) {
$user = trim($cc_explode[$i]);
$check = checkuser($user);
if ($check == 0) {
doerror('The user &quot;<b>'.$user.'</b>&quot; does not exist!');
}
if ($check > 1) {
doerror('The user &quot;<b>'.$user.'</b>&quot; is found more than once in the database!<br />Please go back and be more specific (clicking on the &quot;Cc...&quot; button will bring up the contacts list).');
}
$uid = getuserid($user);
$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$uid'");
$fetch = mysql_fetch_row($get);
$usersname = $fetch[0] . " " . $fetch[1];
$sent_users[] = $usersname;
$cc_array[] = $uid;
}
}
else {
doerror('You must enter at least one name in the to or cc field!');
}

if (strlen($msg) > 65535) {
doerror('Maximum 65535 characters are allowed in message!');
}
if ($_POST['subject'] == "") {
$subject = "No Subject";
}

if ($message_attachments == 1) {
if ($_POST['attachments'] !== "") {
$attachments = addslashes($_POST['attachments']);
}
}

// Send message 2 users in to array
if (!empty($to_array)) {
for ($i = 0; $i < count($to_array); $i++) {
$to_ = trim($to_array[$i]);
mysql_query("INSERT INTO inbox (msg_to, msg_from, msg_time, msg_subject, msg_body, msg_attachments) VALUES('$to_', '$user_id', '$time', '$subject', '$msg', '$attachments')") or die (mysql_error());
mysql_query("INSERT INTO outbox (msg_to, msg_from, msg_time, msg_subject, msg_body, msg_attachments) VALUES('$to_', '$user_id', '$time', '$subject', '$msg', '$attachments')") or die (mysql_error());
}
}

// Send message 2 users in cc array
if (!empty($cc_array)) {
for ($i = 0; $i < count($cc_array); $i++) {
$cc_ = trim($cc_array[$i]);
mysql_query("INSERT INTO inbox (msg_cc, msg_from, msg_time, msg_subject, msg_body, msg_attachments) VALUES('$cc_', '$user_id', '$time', '$subject', '$msg', '$attachments')") or die (mysql_error());
mysql_query("INSERT INTO outbox (msg_cc, msg_from, msg_time, msg_subject, msg_body, msg_attachments) VALUES('$cc_', '$user_id', '$time', '$subject', '$msg', '$attachments')") or die (mysql_error());
}
}

?>
<div id="textbox" align="center">
<b>Message Sent!</b>
<br /><br />
Your message has been successfully sent to the following people:
<br /><br />
<?php
for ($i = 0; $i < count($sent_users); $i++) {
echo "<li> " . trim($sent_users[$i]) . "</li>\n";
}
?>

<br /><br />
<a href="compose.php">Compose Message</a> | <a href="index.php">Return Home</a>
</div>
<?php

// Footer
include("footer.php");

?>