<?php
include("prepend.php");
if($first_time == 0) {
	include(DOCROOT . "sendcard_setup.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#ffffff">
<div align="center">
  <h1>Welcome to sendcard admin! </h1>
  <p>&nbsp;</p>
  <p>Please use the menu to the left to navigate.<br>
	<a href="http://www.sendcard.f2s.com/exchange/">Get more modules</a></p>
    <script language="JavaScript" src="http://www.sendcard.f2s.com/update.php?ver=<? echo urlencode($sc_version); ?>" type="text/javascript"></script>
Modify the administration <a href="setup.php">setup</a>
</div>
<?php
if($first_time == 1)
{
?>
<h1>First time here?</h1>
  <p>Before you can use the administration interface you just need to check that the <a href="setup.php">information contained here</a> is correct.</p>
<?php
}
?>
</body>
</html>
