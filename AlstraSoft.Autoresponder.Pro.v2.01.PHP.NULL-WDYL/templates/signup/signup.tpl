<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Autoresponder Free Sign Up</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="slim.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form_signup" action="do_signup.php" method="post">
<input type="hidden" name="affiliate" value="{AFFILIATE_ID}">
<input type="hidden" name="paid" value="{paid}">
<table cellSpacing="0" cellPadding="5" width="400" border="0" align="center" bgColor="#FFFFFF" >
<tr vAlign="center" align="middle" height="25" bgColor="#FFFFFF">
	<td align="middle" align="center" width="70%" colSpan="2"><b>Sign Up For Free!</b></td>
</tr>
<tr>
	<td align="left" width="25%"><font color="red">*</font>&nbsp;Your Name:</td>
	<td width="60%"><input type="text" name="name" maxlength="100"></td>
</tr>
<tr>
	<td align="left"><font color="red">*</font>&nbsp;Your E-mail:</td>
	<td><input type="text" name="email" maxlength="100"></td>
</tr>
<tr>
	<td align="left"><font color="red">*</font>&nbsp;{sitename}&nbsp;name:<br><font size="1">(letters&nbsp;and&nbsp;numbers&nbsp;only!)</font></td>
	<td><input type="text" name="username" maxlength="20">@{sitename}</td>
</tr>
<tr>
	<td align="left">Your Password:</td>
	<td><input type="password" name="password" maxlength="40"></td>
</tr>
<tr>
	<td align="left">Retype Password:</td>
	<td><input type="password" name="confirm_password" maxlength="40"></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colSpan="2"><input type="submit" value="Submit"></td>
</tr>
<tr>
	<td height="40" colSpan="2" align="right" valign="bottom"><font color="red">*</font>&nbsp;denotes a required field</td>
</tr>
</table>
</form>
</body>

</html>
