<html>
<head>
<META http-equiv="content-type" content="text/html; charset=windows-1254">
<META http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>myAgenda</title>
<script LANGUAGE="javascript" src="js/jslib.js"></script>
<link rel="StyleSheet" href="css/style.css" type="text/css">
<script LANGUAGE="javascript">
function validate() {

var f = document.myAgenda

if ( (f.EMAIL.value=="") || !validate_email(f.EMAIL) ) {
	alert("{strJSEmail}")
	f.EMAIL.focus()
	return false
}
	return true
}
</script>
</head>
<body bgcolor="#FFFFFF">
<br>
<br>
<table border=0 cellpadding=1 cellspacing=0 width="400" align="center">
 <tr>
	<td><font class="text">{strSendMyPassword}</font></td>
 </tr>
</table>
<table border=0 cellspacing=0 cellpadding=1 width="400" bgcolor="#333333" align="center">
 <tr><form action="{SELF}" method="post" name="myAgenda" onsubmit="return(validate())">
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td bgcolor="#f3f3f3">

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
	<td colspan="2">{errMsg}{noteMsg}</td>
</tr><tr>
	<td width="50%" align="right"><b>{strEmail}</b> </td>
	<td width="50%"><input type="text" name="EMAIL" value="{EMAIL_value}" size="25" maxlength="100"></td>
</tr><tr>
	<td align="right">&nbsp;</td>
	<td><input type="Submit" name="post" value="{strGo}">
	</td>
</tr></form>
</table>

		
	</td>
 </tr>
</table>

	</td>
 </tr>
</table>
<img src="images/spacer.gif" width="1" height="2" border="0" alt=""><br>
</BODY>
</HTML>