<?php
$auth_user = $_SESSION['flashlightuser'];

// Settings
$q_settings = mysql_query("SELECT * FROM settings");
while($q = mysql_fetch_array($q_settings)) {
$company_name = stripslashes($q['company_name']);
$company_url = $q['company_url'];
$message_attachments = $q['attachments'];
$message_attachments_maxsize = $q['attachments_maxsize'];
$message_attachments_total = $q['attachments_total'];
}

// Logged in user info
$user_get = mysql_query("SELECT id, first_name, last_name, lastlogin FROM users WHERE username='$auth_user'");
$user_fetch = mysql_fetch_row($user_get);
$user_id = $user_fetch[0];
$user_firstname = $user_fetch[1];
$user_lastname = $user_fetch[2];
$user_lastlogin = $user_fetch[3];
if ($user_id == 1) { $user_admin = 1; } else { $user_admin = 0; }

// Flashlight Version
$ver = '1.0';
?>