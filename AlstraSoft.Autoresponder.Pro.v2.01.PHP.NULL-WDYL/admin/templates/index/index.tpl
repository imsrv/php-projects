<html>
<head>
<title>Autoresponder :: Administration Area</title>
<link rel="stylesheet" type="text/css" href="../slim.css">
</head>
<body onload="DoOnLoad();">

<form name="form_login" action="do_login.php" method="post">
<table cellSpacing="0" cellPadding="5" width="400" border="0" align="center" bgColor="#FFFFFF">
<tr height="60" bgColor="#FFFFFF">
	<td align="middle" colSpan="2"><b>Site Administration</b></td>
</tr>
<tr>
	<td align="right" width="30%">Username</td>
	<td width="70%"><b>Administrator</b></td>
</tr>
<tr>
	<td align="right">Password</td>
	<td><input type="password" name="password" maxlength="40"></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" value="Login"></td>
</tr>
</table>
</form>
</body>

<script language="javascript">
function DoOnLoad()
{
	document.form_login.password.focus();
}
</script>

</html>