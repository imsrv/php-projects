<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
<head>
<title>Flashlight Installer</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js/scripts.js" /></script>
</head>
<body>
<div id="wrap">
<div id="textbox" align="center">
<b>Welcome to Flashlight, please enter the following details before installation begins:</b>
<form name="install" action="installer.php" method="post" onSubmit="disableButton(document.install.submit)">
<i>Admin Information</i><br /><br />
First Name:<br /><input type="text" name="first" size="20" maxlength="50"><br /><br />
Last Name:<br /><input type="text" name="last" size="20" maxlength="50"><br /><br />
Username:<br /><input type="text" name="username" size="20" maxlength="50"><br /><br />
Password:<br /><input type="password" name="password" size="20" maxlength="25"><br /><br />
Confirm Password:<br /><input type="password" name="cpassword" size="20" maxlength="25"><br /><br />
<br /><i>Flashlight Settings</i><br /><br />
Company Name (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Enter the name of the company Flashlight is licensed to.');">?</a>):<br /><input type="text" name="cname" size="20" maxlength="50"><br /><br />
Company URL (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Enter the URL of the company Flashlight is licensed to.');">?</a>):<br /><input type="text" name="curl" size="20" maxlength="100" value="http://"><br /><br />
<input type="submit" name="submit" value="Install Flashlight">
</form>
</div>
<div id="footer">
<span>Copyright &copy; <a target="_new" href="http://www.xeweb.net" title="Visit XEWeb">XEWeb</a> 2005. All rights reserved.</span>
</div>
</div>
</body>
</html>