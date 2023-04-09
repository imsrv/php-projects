<?php

// Before page load 
session_start();

// Check for installer files
if (file_exists('install.php')) {
die('<b>Warning:</b> Please delete <b>install.php</b> before running Flashlight!');
}
if (file_exists('installer.php')) {
die('<b>Warning:</b> Please delete <b>installer.php</b> before running Flashlight!');
}

include("config.php");
include("auth.php");
include("info.php");

// Header
$cur = 'Home';
include("header.php");

$browser = getenv("HTTP_USER_AGENT");
if (!preg_match("/MSIE/i", $browser)) {
echo '<script>alert("It is recommended that you use the latest version of Internet Explorer to view Flashlight!");</script>';
}

###### MAIN ######

$ampm = gmdate('A', time());
if ($ampm == "AM") {
$ampm = "morning";
}
else {
$ampm = "afternoon";
}

$unread = 0;
$sql = mysql_query("SELECT * FROM inbox WHERE msg_to='$user_id' OR msg_cc='$user_id'");
$total = mysql_num_rows($sql);

if ($total > 0) {
while($r = mysql_fetch_array($sql)) {
$id = $r['msg_id'];
$row = mysql_query("SELECT msg_read FROM inbox WHERE msg_id='$id'");
$fetch = mysql_fetch_row($row);
if ($fetch[0] == 0) { $unread = $unread + 1; }
}
}

if ($unread == 1) {
$s = "";
}
else {
$s = "s";
}

?>

<div id="textbox" align="center">

<p>Good <?=$ampm?> <?=$user_firstname?>.</p>
<p>You are logged in on <?=gmdate('l jS of F', time())?> at <?=gmdate('H:i A', time())?>.</p>
<p>You have <b><?=$unread?></b> unread message<?=$s?> in your <a href="inbox.php">inbox</a> (<b><?=number_format($total)?></b> total messages).</p>
<?php
if ($user_admin == 1) { echo '<p><i>Your account has administrator privileges.</i></p>'; }
?>

</div>

<?php

// Footer
include("footer.php");

?>