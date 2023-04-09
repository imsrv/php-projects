<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
include("func.inc.php");

if (isset($_GET['action'])) {
if ($_GET['action'] == "reply") {
$replyid = $_GET['id'];

$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$replyid' AND msg_to='$user_id'");
$check = mysql_num_rows($sql);
if ($check == 0) {
$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$replyid' AND msg_cc='$user_id'");
$check = mysql_num_rows($sql);
}
if ($check == 1) {
$sql = mysql_query("SELECT msg_from, msg_subject, msg_body, msg_password FROM inbox WHERE msg_id='$id'");
$fetch = mysql_fetch_row($sql);
$to = $fetch[0];
$subject = stripslashes($fetch[1]);
$body = stripslashes($fetch[2]);
$pass = $fetch[3];
$message_focus = 1;

$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$to'");
$row = mysql_fetch_row($get);
$to = $row[0] . " " . $row[1];

if (substr($subject, 0, 4) !== "Re: ") {
$subject = "Re: " . $subject;
}

if ($pass !== "") {
$body = "\n\n\n------\n*** Encrypted Message ***";
}
else {
$body = "\n\n\n------\n" . $to . " wrote:\n" . $body;
}
}
}

if ($_GET['action'] == "forward") {
$forwardid = $_GET['id'];

$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$forwardid' AND msg_to='$user_id'");
$check = mysql_num_rows($sql);
if ($check == 0) {
$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$forwardid' AND msg_cc='$user_id'");
$check = mysql_num_rows($sql);
}
if ($check == 1) {
$sql = mysql_query("SELECT msg_from, msg_subject, msg_body, msg_time, msg_password FROM inbox WHERE msg_id='$forwardid'");
if (mysql_num_rows($sql) == 1) {
$fetch = mysql_fetch_row($sql);
$to = $fetch[0];
$subject = stripslashes($fetch[1]);
$body = stripslashes($fetch[2]);
$date = $fetch[3];
$pass = $fetch[4];
$message_focus = 1;

$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$to'");
$row = mysql_fetch_row($get);
$to = $row[0] . " " . $row[1];

if (substr($subject, 0, 4) !== "Fw: ") {
$subject = "Fw: " . $subject;
}

if ($pass !== "") {
$body = "\n\n\n------\n*** Encrypted Message ***";
}
else {
$body = "\n\n\n------\n" . $to . " wrote on " . gmdate('l, F jS, H:i A', $date) . ":\n" . $body;
}
$to = "";
}
}
}
}


// Header
$cur = 'Compose Message';
$onload_hide_div = 1;
include("header.php");

?>

<div id="textbox" align="center">
<form name="compose" action="send.php" method="post" onSubmit="disableButton(document.compose.s); disableButton(document.compose.c);">
<input type="button" value="  To...  " onClick="showContacts('to')"> <input type="text" name="to" size="50" value="<?=$to?>"><br /><br />
<input type="button" value="  Cc...  " onClick="showContacts('cc')"> <input type="text" name="cc" size="50"><br /><br />
Subject: <input type="text" name="subject" size="50" maxlength="150" value="<?=$subject?>"><br /><br />
<a href="javascript:void(0)" onClick="bbcode('[b]TEXT[/b]');"><img src="images/bold.gif" border="0" alt="Bold"></a> <a href="javascript:void(0)" onClick="bbcode('[i]TEXT[/i]');"><img src="images/italic.gif" border="0" alt="Italics"></a> <a href="javascript:void(0)" onClick="bbcode('[u]TEXT[/u]');"><img src="images/underline.gif" border="0" alt="Underline"></a> <a href="javascript:void(0)" onClick="bbcode('[bp]TEXT[/bp]');"><img src="images/bullet.gif" border="0" alt="Bullet Points"></a> <a href="javascript:void(0)" onClick="bbcode('url');"><img src="images/link.gif" border="0" alt="Add Link"></a> <a href="javascript:void(0)" onClick="bbcode('[img]IMAGE URL[/img]');"><img src="images/pic.gif" border="0" alt="Add Image"></a><br />
<textarea name="message" cols="55" rows="12"><?=$body?></textarea><br /><br />
<input type="submit" name="s" class="submit" value="Send Message" accesskey="s"> <input type="reset" name="c" accesskey="c" value=" Clear "><br /><br />
<input type="button" name="ex" value="Extras..." onClick="showDiv('extra'); disableButton(document.compose.ex);"><br /><br />
<div id="extra">
<fieldset>
<legend>Extras</legend>
<?php
$avail = 0;
if ($message_attachments == 1) {
echo '<b>Attachments:</b><br />
<input type="button" value="Upload" onClick="addAttachments(document.compose.attachments.value)"> <input type="text" name="attachments" size="30" readonly>
<br /><br />';
$avail = 1;
}
if ($message_security == 1) {
echo 'Password (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert(\'This will help secure your message by storing it in an encrypted format, so that only the password you set will be able to decrypt the message. Adding a hint will help the person receiving the message to work out what the password is...\');">?</a>): <input type="password" name="password" size="20"><br />
Password Hint: <input type="text" name="hint" size="20" maxlength="100">';
$avail = 1;
}
if ($avail == 0) {
echo '<i>No extras are available...</i>';
}
?>

</fieldset>
</div>
</form>
</div>

<?php

// Footer
include("footer.php");

?>