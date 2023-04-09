<!-- $Id: poplogin.body.tpl,v 1.3 2000/04/11 22:38:46 prenagha Exp $ -->
<p>&nbsp;
<p>You have attempted an action that requires you to be authenticated.<br>
Please enter your POP user ID and password.

<form name="login" action="{FORM_ACTION}" method=post>
<table border=0 bgcolor="#EEEEEE" align="center" cellspacing=0 cellpadding=4>
 <tr valign=center align=left>
  <td>POP Username:</td>
  <td><input type="text" name="username" value="{DEFAULT_USERNAME}" size=15 maxlength=32></td>
 </tr>
 <tr valign=center align=left>
  <td>POP Password:</td>
  <td><input type="password" name='password' size=15 maxlength=32></td>
 </tr>
 <tr valign=center align=left>
  <td>POP Server:</td>
  <td>{SERVER_HTML}</td>
 </tr>
{PORT_HTML}
 <tr>
  <td colspan=2 align=right><input type="submit" name="submitbtn" value="Login"></td>
 </tr>
</table>
</form>
{INVALID_MSG}
<script language="JavaScript">
<!--
  // Activate the appropriate input form field.
  if (document.login.username.value == '') {
    document.login.username.focus();
  } else {
    document.login.password.focus();
  }
// -->
</script>
