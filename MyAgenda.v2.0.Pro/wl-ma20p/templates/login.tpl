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

	if ( (f.USERNAME.value=="") || (f.USERNAME.value.length < 4) ) {
		alert("{strJSUsername}")
		f.USERNAME.focus()
		return false
	}
	if ( (f.PASSWORD.value=="") || (f.PASSWORD.value.length < 4) ) {
		alert("{strJSPassword}")
		f.PASSWORD.focus();    			
		return false
	}
		return true
	}
</script>
</head>
<body bgcolor="#FFFFFF">
<br>
<br>
<form action="{SELF}" method="post" name="myAgenda" onsubmit="return(validate())">
<table border=0 cellpadding=1 cellspacing=0 width="400" align="center">
 <tr>
	<td><font class="text">{strLogin}</font></td>
 </tr>
</table>
<table border=0 cellspacing=0 cellpadding=1 width="400" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td bgcolor="#f3f3f3">

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
	<td colspan="2"><font color="#FF0000"><b>{errMsg}</b></font></td>
</tr><tr>
	<td width="40%" align="right"><b>{strUsername}</b> </td>
	<td width="60%"><input type="text" name="USERNAME" value="{USERNAME_value}" size="25" maxlength="100"></td>
</tr><tr>
	<td align="right"><b>{strPassword}</b> </td>
	<td><input type="PASSWORD" name="PASSWORD" size="25" maxlength="10"></td>
</tr><tr>
	<td align="right">&nbsp;</td>
	<td><input type="Submit" name="post" value="{strLogin}"></td>
</tr><tr>
	<td align="right">&nbsp;</td>
	<td><a href="fpw.php">{strForgotLoginInfo}</a></td>
</tr></form>
</table>

		
	</td>
 </tr>
</table>
	</td>
 </tr>
</table>
<img src="images/pixel.gif" width="1" height="2" border="0" alt=""><br>
<table border=0 cellspacing=0 cellpadding=1 width="400" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td>
		 <table border=0 cellpadding=2 cellspacing=2 width="100%">
		 <tr>
			<td bgcolor="#f3f3f3">{strRegFree}</td>
	 </tr>
	</table>

	</td>
 </tr>
</table>

	</td>
 </tr>
</table>
</BODY>
</HTML>
