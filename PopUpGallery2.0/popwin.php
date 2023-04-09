<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php $file = $HTTP_GET_VARS['file']; echo "$file";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="popstyle.css" type="text/css" />

<body>
<?php
	$file = $HTTP_GET_VARS['file'];
	echo "<a href='#' onclick='javascript:window.close()'><img src='imgs/$file' alt='click to close' class='popimage' /></a>";
	?>
</body>
</html>
