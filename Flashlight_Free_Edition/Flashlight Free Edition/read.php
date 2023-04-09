<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
include("func.inc.php");

// Header
$cur = 'Inbox';
include("header.php");
?>

<div id="textbox">
<?php
$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$id' AND msg_to='$user_id'");
$check = mysql_num_rows($sql);
$first = "To";
if ($check == 0) {
$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$id' AND msg_cc='$user_id'");
$check = mysql_num_rows($sql);
$first = "Cc";
}
if ($check == 0) {
echo '<center><b>This message is not available!</b></center></div>';
include("footer.php");
exit();
}

mysql_query("UPDATE inbox SET msg_read='1' WHERE msg_id='$id'");
while($r = mysql_fetch_array($sql)) {
$from = $r['msg_from'];
$cc = $r['msg_cc'];
$time = $r['msg_time'];
$subject = stripslashes($r['msg_subject']);
$msg = format($r['msg_body']);
$attachments = stripslashes($r['msg_attachments']);

$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$from'");
$fetch = mysql_fetch_row($get);
$from_user = $fetch[0] . " " . $fetch[1];

if ($from_user == " ") {
$from_user = "N/A";
}

if ($attachments !== "") {
$attach_array = array();
$explode = explode('|', $attachments);
for ($i = 0; $i < count($explode); $i++) {
$attach_array[] = '<a href="attachment.php?id='.$explode[$i].'">'.$explode[$i].'</a>';
}
$msg .= '<br /><br /><b>Attachments:</b> ' . implode(', ', $attach_array);
}

echo '<b>From:</b> '.$from_user.'<br />
<b>'.$first.':</b> '.$user_firstname.' '.$user_lastname.'<br />
<b>Date:</b> '.gmdate('l, F jS, H:i A', $time).'<br />
<b>Subject:</b> '.$subject.'<br /><br />
'.$msg;
}
?>

<br /><br />
<center>
<input type="button" value="Reply to Message" onClick="jump('compose.php?action=reply&id=<?=$id?>');"> <input type="button" value="Forward Message" onClick="jump('compose.php?action=forward&id=<?=$id?>');"> <input type="button" value="Delete Message" onClick="jump('delete.php?id=<?=$id?>');">
</center>
</div>

<?php

// Footer
include("footer.php");

?>