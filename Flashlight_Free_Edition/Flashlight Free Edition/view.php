<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
include("func.inc.php");

// Header
$cur = 'Outbox';
include("header.php");
?>

<div id="textbox">
<?php
$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM outbox WHERE msg_id='$id' AND msg_from='$user_id'");
$check = mysql_num_rows($sql);
if ($check == 0) {
echo '<center><b>This message is not available!</b></center></div>';
include("footer.php");
exit();
}

while($r = mysql_fetch_array($sql)) {
$to = $r['msg_to'];
$cc = $r['msg_cc'];
$time = $r['msg_time'];
$subject = stripslashes($r['msg_subject']);
$msg = format($r['msg_body']);
$attachments = stripslashes($r['msg_attachments']);

$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$to'");
$fetch = mysql_fetch_row($get);
$to_user = $fetch[0] . " " . $fetch[1];
$first = "To";

if ($to_user == " ") {
$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='$cc'");
$fetch = mysql_fetch_row($get);
$to_user = $fetch[0] . " " . $fetch[1];
$first = "Cc";
}

if ($to_user == " ") {
$to_user = "N/A";
}

if ($attachments !== "") {
$attach_array = array();
$explode = explode('|', $attachments);
for ($i = 0; $i < count($explode); $i++) {
$attach_array[] = '<a href="attachment.php?id='.$explode[$i].'">'.$explode[$i].'</a>';
}
$msg .= '<br /><br /><b>Attachments:</b> ' . implode(', ', $attach_array);
}

echo '<b>'.$first.':</b> '.$to_user.'<br />
<b>Date:</b> '.gmdate('l, F jS, H:i A', $time).'<br />
<b>Subject:</b> '.$subject.'<br /><br />
'.$msg;
}
?>

<br /><br />
<center>
<input type="button" value="Delete Message" onClick="jump('delete_outbox.php?id=<?=$id?>');">
</center>
</div>

<?php

// Footer
include("footer.php");

?>