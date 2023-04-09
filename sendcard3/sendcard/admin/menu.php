<?php
include("prepend.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#99CC33">
<p align="center"><a href="http://www.sendcard.f2s.com/"><img src="<?php echo SENDCARD_HOST; ?>poweredbysendcard102x47.gif" width="102" height="47" border="0" alt="Powered by sendcard - an advanced PHP e-card program"></a></p>
<a href="index2.php" target="main">Home</a><br><br>
<?php 
$diary_directory = opendir(".");
while($filename = readdir($diary_directory)) {
     if(ereg("modi_", $filename)){
		include($filename);
		$filename = substr($filename, 4);
		if ($mod_path) {
			$filepath = $mod_path;
		} else {
			$filepath = "mod" . $filename;
		}
     	echo("<a href=\"$filepath\" target=\"main\">$mod_name</a><br><br>\n");
     }
}
closedir($diary_directory);
?>
<a href="login.php?action=logout" target="_top">Log out</a>
</body>
</html>