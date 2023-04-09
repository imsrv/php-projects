<?php
function auth() {
header('WWW-Authenticate: Basic realm="Please Login to Flashlight"');
header('HTTP/1.0 401 Unauthorized');
die('<center><h1>Access Denied!</h1>You must enter a valid login ID and password to access Flashlight.</center>');
}

if ((!isset($_SESSION['flashlightuser'])) || ($_SESSION['flashlightuser'] == "")) {
if (!isset($_SERVER['PHP_AUTH_USER'])) {
auth();
}
if (!isset($_SERVER['PHP_AUTH_PW'])) {
auth();
}

$auth_user = $_SERVER['PHP_AUTH_USER'];
$auth_pass = md5($_SERVER['PHP_AUTH_PW']);
$sql = mysql_query("SELECT * FROM users WHERE username='$auth_user' AND password='$auth_pass'");

if (mysql_num_rows($sql) == 0) {
auth();
}
else {
$_SESSION['flashlightuser'] = $auth_user;
}
}
?>