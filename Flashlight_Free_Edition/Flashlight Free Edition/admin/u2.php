<?php

function doerror($err) {
echo '<div id="textbox" align="center">
<b>Error:</b><br /><br />
'.$err.'<br /><br />
<a href="javascript:history.go(-1)">&lt;&lt; Go Back</a>
</div>';
include("footer.php");
exit();
}

$vars = array('first', 'last', 'username', 'password', 'cpassword', 'notes', 'userid');

for ($i = 0; $i < count($vars); $i++) {
$vars[$i] = addslashes($_POST[$vars[$i]]);
}

if (strlen(trim($first)) == 0) {
doerror('You did not enter a first name!');
}

if (strlen(trim($last)) == 0) {
doerror('You did not enter a last name!');
}

if (strlen(trim($username)) == 0) {
doerror('You did not enter a username!');
}

// Change password
if (strlen(trim($password)) > 0) {
if (strlen(trim($cpassword)) == 0) {
doerror('You did not enter the confirmed password!');
}
if ($cpassword !== $password) {
doerror('The password and confirmed password do not match!');
}
$password = md5($password);
mysql_query("UPDATE users SET password='$password' WHERE id='$userid'") or die (mysql_error());
}

$first = ucfirst(strtolower($first));
$last = ucfirst(strtolower($last));
$notes = htmlspecialchars($notes, ENT_QUOTES);

mysql_query("UPDATE users SET first_name='$first', last_name='$last', username='$username', notes='$notes' WHERE id='$userid'") or die (mysql_error());
?>

<div id="textbox" align="center">
<?=$first?> <?=$last?> (<i><?=$username?></i>) has been updated!
<br /><br />
<a href="admin.php?action=2">Edit a User</a> | <a href="admin.php">Home</a>
</div>