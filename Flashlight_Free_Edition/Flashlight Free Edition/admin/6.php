<?php
if ((!isset($_GET['user'])) || ($_GET['user'] == "")) {
die("No user ID specified!");
}

$user = $_GET['user'];

$get = mysql_query("SELECT first_name, last_name, username, notes FROM users WHERE id='$user'");
$fetch = mysql_fetch_row($get);
$first = $fetch[0];
$last = $fetch[1];
$uname = $fetch[2];
$notes = stripslashes($fetch[3]);
?>

<div id="textbox" align="center">
<u>Information for <?=$first?> <?=$last?></u><br /><br />
<b>User ID:</b><br />#<?=$user?><br /><br />
<b>First Name:</b><br /><?=$first?><br /><br />
<b>Last Name:</b><br /><?=$last?><br /><br />
<b>Username:</b><br /><?=$uname?><br /><br />
<b>User Notes:</b><br /><?=$notes?><br /><br />
<a href="admin.php?action=4">Search for a User</a> | <a href="admin.php">Home</a>
</div>