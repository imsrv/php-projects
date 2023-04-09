
<TABLE BORDER=0 width=98% align=center>
<TR>

<TD VALIGN=top width=40px></tD>

<TD VALIGN=top>

<SCRIPT LANGUAGE="JavaScript">
<!--
function checkform ( form )
{

    if (form.username.value == "") {
        alert( "Please enter your username." );
        form.username.focus();
        return false ;
    }
        if (form.password.value == "") {
	        alert( "Please enter your password." );
	        form.password.focus();
	        return false ;
    }

	return true ;
}
//-->
</SCRIPT>




<TABLE BORDER=0 width=98% align=center><TR><TD>
<form action="login.php"  onsubmit="return checkform(this);" method=post>
<table border=0 width=100%>

<tr>
	<td align=right nowrap>* Username</td><td><input type=text name="username" value="" size="15"></td>
</tr>

<tr>
	<td align=right nowrap>* Password</td><td><input type=password name="password" value="" size="15"></td>
</tr>
<tr>
	<td align=right nowrap>&nbsp;</td><td><input type="submit" value="login"></td>
</tr>
<tr>
	<td colspan=2 align=center><B>* = required fields </B></td>
</tr>

</table></form>
<BR>
</TD></tR></tABLE>

</TD></TR></tABLE>