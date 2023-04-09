<html>
<head>
<META http-equiv="content-type" content="text/html; charset=windows-1254">
<META http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>myAgenda</title>
<script LANGUAGE="javascript" src="js/jslib.js"></script>
<link rel="StyleSheet" href="css/style.css" type="text/css">
<SCRIPT language="JavaScript">
function check() {

	var f = document.myAgenda

		if ( (f.NAME.value=="") || (f.NAME.value.length < 2) ) {
			alert("{strJSEnterName}");
		    f.NAME.focus();
			return false
		}

		if ( (f.SURNAME.value=="") || (f.SURNAME.value.length < 2) ) {
			alert("{strJSEnterSurname}");
		    f.SURNAME.focus();
			return false
		}
		if (!validate_email(f.EMAIL) ) {
			alert("{strJSEnterEmail}");
			f.EMAIL.focus();
			return false;
		}
		if ( (f.USERNAME.value !="") && (f.USERNAME.value.length < 4) ) {
			alert("{strJSUsername}");
		    f.USERNAME.focus();
			return false
		}
		if ( (f.PASSWORD.value != "") && (f.PASSWORD.value.length < 4) ) {
			alert("{strJSPassword}")
		    f.PASSWORD.focus();
			return false
		}
		if ( (f.PASSWORD.value != "") || (f.PASSWORD2.value != "") ) {
			if (f.PASSWORD.value != f.PASSWORD2.value) {
				alert("{strJSPasswordsNoMatch}")
			    f.PASSWORD.focus();
				return false
			}
		}
		if ( (f.OLDPASSWORD.value == "") || (f.OLDPASSWORD.value.length < 4) ) {
			alert("{strJSOldPassword}")
		    f.OLDPASSWORD.focus();
			return false
		}
		return true
	}
</SCRIPT>
</head>
<body bgcolor="#FFFFFF">
<br>
<br>
<table border=0 cellpadding=1 cellspacing=0 width="400" align="center">
 <tr>
	<td><font class="text">{strModifyInfo}</font></td>
 </tr>
</table>
<table border=0 cellspacing=0 cellpadding=1 width="400" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td bgcolor="#f3f3f3">

<form action="{SELF}" method="post" name="myAgenda" onsubmit="return(check())">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
 <tr>
	<td colspan="2">{errMsg}{noteMsg}</td>
</tr><tr>
	<td width="50%" align="right"><b>{strName}</b> </td>
	<td width="50%"><input type="text" name="NAME" value="{NAME_value}" size="25" maxlength="100"></td>
</tr><tr>
	<td align="right"><b>{strSurname}</b> </td>
	<td><input type="text" name="SURNAME" value="{SURNAME_value}" size="25" maxlength="100"></td>
</tr><tr>
	<td align="right"><b>{strEmail}</b> </td>
	<td><input type="text" name="EMAIL" value="{EMAIL_value}" size="25" maxlength="100"></td>
</tr><tr>
	<td colspan="2">{strUserPassInfo}</td>
</tr><tr>
	<td align="right"><b>{strUsername}</b> </td>
	<td><input type="text" name="USERNAME" size="25" maxlength="16"></td>
</tr><tr>
	<td align="right"><b>{strNewPassword}</b> </td>
	<td><input type="password" name="PASSWORD" size="25" maxlength="10"></td>
</tr><tr>
	<td align="right"><b>{strNewPassword} ({strRepeate})</b> </td>
	<td><input type="password" name="PASSWORD2" size="25" maxlength="10"></td>
</tr><tr>
	<td colspan="2">{strForSecurityPass}</td>
</tr><tr>
	<td align="right"><b>{strOldPassword}</b> </td>
	<td><input type="password" name="OLDPASSWORD" size="25" maxlength="10"></td>
</tr><tr>
	<td align="right">&nbsp;</td>
	<td><input type="Submit" name="post" value="{strSubmit}"></td>
</tr>
</table>
</form>		
	</td>
 </tr>
</table>
	</td>
 </tr>
</table>
</BODY>
</HTML>
