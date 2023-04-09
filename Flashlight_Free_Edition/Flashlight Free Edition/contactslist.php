<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

$sendtofield = $_REQUEST['f'];
if (!$sendtofield) { $sendtofield = "to"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
<head>
<title>Contacts List</title>
<style type="text/css">
<!--
body { color:#000;font-size:8.5pt;background:#fff;font-family:verdana,lucida,arial,helvetica,sans-serif; }
input { color:#000;font-size:8.5pt;font-family:verdana,lucida,arial,helvetica,sans-serif;border:1px solid #666; }
a { color:#000;font-size:8.5pt;font-family:verdana,lucida,arial,helvetica,sans-serif;text-decoration:underline; }
.blu { color:#0046D5;font-size:8.5pt;font-weight:bold;font-family:verdana,lucida,arial,helvetica,sans-serif; }
input.submit { color:#000;font-size:8.5pt;font-weight: bold;cursor: pointer;background:#ECE9D8;font-family:verdana,lucida,arial,helvetica,sans-serif; }
-->
</style>
<script language="javascript">
<!--
function insert(name) {
if (opener.compose.<?=$sendtofield?>.value == "") {
opener.compose.<?=$sendtofield?>.value = name;
}
else {
opener.compose.<?=$sendtofield?>.value = opener.compose.<?=$sendtofield?>.value + ", " + name;
}
}
-->
</script>
</head>
<body>
<center>
<span class="blu">Search for a Contact</span>
<form name="search" action="contactslist.php" method="get">
<input type="hidden" name="action" value="search">
<input type="hidden" name="f" value="<?=$sendtofield?>">
First Name:<br /><input type="text" name="first" size="20"><br />
Last Name:<br /><input type="text" name="last" size="20"><br />
<input type="submit" value="Search" class="submit">
</form>
</center>
<?php
if ($_GET['action'] == "search") {
$param = "";
echo '<br /><center><span class="blu">Search Results</span></center><br /><br />';

//First name search
if (isset($_GET['first'])) {
$first_name = urldecode(trim($_GET['first']));
$param = "first_name LIKE '%" . $first_name ."%'";
}

//Last name search
if (isset($_GET['last'])) {
if (isset($first_name)) { $param .= " AND "; }
$last_name = urldecode(trim($_GET['last']));
$param .= "last_name LIKE '%" . $last_name ."%'";
}

if ($param !== "") {
$query = mysql_query("SELECT * FROM users WHERE $param ORDER BY last_name");
while($r = mysql_fetch_array($query)) {
$fullname = $r['first_name'] . " " . $r['last_name'];
echo '<li> <a href="javascript:void(0)" onClick="insert(\''.$fullname.'\');">'.$fullname.'</a>';
}
}
mysql_close();
}
?>
</body>
</html>