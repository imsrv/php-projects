<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
include("func.inc.php");

if ($user_admin == 0) {
die('Access Denied!');
}

// Header
$cur = 'Administrator Options';
include("header.php");

$inc = $_GET['action'];

if ((!isset($inc)) || (!file_exists("admin/".$inc.".php"))) {
echo '<div id="textbox">
<div id="msglist">
<span>
<b><u>User Management</u></b><br />
<li> <a href="admin.php?action=1">Add a User</a></li>
<li> <a href="admin.php?action=2">Edit a User</a></li>
<li> <a href="admin.php?action=3">Delete a User</a></li>
<li> <a href="admin.php?action=4">Search for a User</a></li>
<br /><br />
<b><u>Settings</u></b><br />
<li> <a href="admin.php?action=5">Flashlight Settings</a></li>
</span>
</div>
</div>';
}
else {
include ("admin/".$inc.".php");
}

// Footer
include("footer.php");

?>