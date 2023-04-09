<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

$file = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$dir = getcwd();
$dir = $dir . "/attachments";

if (!$file) {
die('<center><font face="verdana" size="2"><b>You did not browse for a file!</b><br><br><a href="javascript:history.go(-1)">Go Back</a></font></center>');
}
if ($size > $message_attachments_maxsize) {
die('<center><font face="verdana" size="2"><b>Your file is too large!</b><br><br><a href="javascript:history.go(-1)">Go Back</a></font></center>');
}
if (file_exists($dir . "/" . $file)) {
die('<center><font face="verdana" size="2"><b>The file '.$file.' already exists!</b><br><br><a href="javascript:history.go(-1)">Go Back</a></font></center>');
}
move_uploaded_file($_FILES['file']['tmp_name'], $dir . "/" . $file) or die('<center><font face="verdana" size="2"><b>Cannot upload file, please try again! If the problem persists contact the system administrator...</b><br><br><a href="javascript:history.go(-1)">Go Back</a></font></center>');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
<head>
<title>Attachment Uploaded</title>
<style type="text/css">
<!--
body { color:#000;font-size:9.5pt;background:#fff;font-family:verdana,lucida,arial,helvetica,sans-serif; }
a { color:#000;font-size:9.5pt;font-family:verdana,lucida,arial,helvetica,sans-serif;text-decoration:underline; }
-->
</style>
<script language="javascript">
<!--
function insert(name) {
if (opener.compose.attachments.value == "") {
opener.compose.attachments.value = name;
}
else {
opener.compose.attachments.value = opener.compose.attachments.value + "|" + name;
}
}
-->
</script>
</head>
<body onLoad="javascript:insert('<?=$file?>');">
<center>
Successfully uploaded <i><?=$file?></i>
<br /><br />
<a href="javascript:self.close();">Close Window</a>
</center>
</body>
</html>