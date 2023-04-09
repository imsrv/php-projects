<?php
// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
$t = time();
mysql_query("UPDATE users SET lastlogin='$t' WHERE id='$user_id'");
mysql_close();
session_destroy();
?>
<html>
<head>
<title>Flashlight Account [Logged Out]</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<center>
<br><br><br><br>
<h1>Logged Out</h1>
<b>You have successfully logged out...</b>
<br><br>
<a href="javascript:self.close();">Close Window</a>
</center>
</body>
</html>