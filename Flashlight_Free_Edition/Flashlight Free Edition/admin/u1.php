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

$vars = array('first', 'last', 'username', 'password', 'cpassword', 'notes');

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

if (strlen(trim($password)) == 0) {
doerror('You did not enter a password!');
}

if (strlen(trim($cpassword)) == 0) {
doerror('You did not enter the confirmed password!');
}

if ($cpassword !== $password) {
doerror('The password and confirmed password do not match!');
}

$sql = mysql_query("SELECT * FROM users WHERE username='$username'");
if (mysql_num_rows($sql) == 1) {
doerror('The username <b>'.$username.'</b> already exists!');
}

$first = ucfirst(strtolower($first));
$last = ucfirst(strtolower($last));
$password = md5($password);
$notes = htmlspecialchars($notes, ENT_QUOTES);

eval(base64_decode('JHF0ID0gbXlzcWxfcXVlcnkoIlNFTEVDVCAqIEZST00gdXNlcnMiKTsNCmlmIChteXNxbF9udW1fcm93cygkcXQpID49IDE1KSB7DQpkb2Vycm9yKCdZb3UgY2FuIG9ubHkgaGF2ZSBhIG1heGltdW0gb2YgMTUgdXNlcnMgaW4gdGhlIGZyZWUgZWRpdGlvbiEnKTsNCn0='));
eval(base64_decode('bXlzcWxfcXVlcnkoIklOU0VSVCBJTlRPIHVzZXJzIChmaXJzdF9uYW1lLCBsYXN0X25hbWUsIHVzZXJuYW1lLCBwYXNzd29yZCwgbm90ZXMpIFZBTFVFUygnJGZpcnN0JywgJyRsYXN0JywgJyR1c2VybmFtZScsICckcGFzc3dvcmQnLCAnJG5vdGVzJykiKSBvciBkaWUgKG15c3FsX2Vycm9yKCkpOw=='));
?>

<div id="textbox" align="center">
<?=$first?> <?=$last?> (<i><?=$username?></i>) is now a Flashlight user!
<br /><br />
<a href="admin.php?action=1">Add a User</a> | <a href="admin.php">Home</a>
</div>