<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

$count = substr_count(urldecode($_GET['t']), '|');
if ($count >= $message_attachments_total  - 1) {
die('<center><font face="verdana" size="2"><b>You can only upload a maximum of '.$message_attachments_total.' files!</b><br><br><a href="javascript:self.close();">Close Window</a></font></center>');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
<head>
<title>Upload Attachment</title>
<style type="text/css">
<!--
body { color:#000;font-size:9.5pt;background:#fff;font-family:verdana,lucida,arial,helvetica,sans-serif; }
input { color:#000;font-size:9.5pt;font-family:verdana,lucida,arial,helvetica,sans-serif; }
a { color:#000;font-size:9.5pt;font-family:verdana,lucida,arial,helvetica,sans-serif;text-decoration:underline; }
input.submit { color:#0046D5;font-size:9.5pt;font-weight: bold;cursor: pointer;font-family:verdana,lucida,arial,helvetica,sans-serif; }
-->
</style>
<script language="javascript">
<!--
function check() {
if (document.upload.file.value == "") {
alert('Please browse for a file!');
return false;
}
else {
document.upload.submit.disabled = true;
alert('Your file is being uploaded...');
return true;
}
}
-->
</script>
</head>
<body>
<center>
<form name="upload" action="upload.php" method="post" enctype="multipart/form-data" onSubmit="return check()">
<b>Upload Attachment</b><br /><br />
<input type="file" name="file" size="40"> <input type="submit" name="submit" value="Upload" class="submit">
<input type="hidden" name="MAX_FILE_SIZE" value="<?=$message_attachments_maxsize?>">
</form>
</center>
</body>
</html>