<%@ Language=VBScript %>
<!--#Include File="include/Cadmin.asp"-->
<HTML>
<HEAD>
<title>Change Password</title>
</HEAD>

<body background="../images2/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#ff6600" bottommargin="0" rightmargin="0">
<!-- LOGO -->
<!--#include file="include/c_logo.inc"-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="450">
  <tr>
    <td valign="top">
<!-- CONTENT BEGIN -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <td ALIGN="CENTER"><br><b><font face="Arial,helvetica" color="#FFFFFF" size="3">CHANGE PASSWORD</font></b></td>
	</tr>
	<!-- END 1ST ROW -->
</table>



<FORM action="include/C_changP.asp?ID=<%=Request.QueryString ("ID")%>" method=POST>
<div align="center">
<TABLE BORDER=0 CELLSPACING="0" CELLPADDING="3">
	
	<!-- Error Message -->
	<TR>
	<TD ALIGN="center" colspan=3><FONT FACE="arial,helvetica" SIZE="-1" COLOR="#FFFFFF"><STRONG><%ErrMSG%></STRONG></FONT>
	</TD>
	</TR>

	<TR>
		<TD ROWSPAN="5" VALIGN="TOP">
		<TABLE BORDER="0" CELLSPACING="3" CELLPADDING="0">
		<TR>
		
		<!-- Required* -->
		<TD ALIGN="RIGHT" VALIGN="TOP"><FONT COLOR="#FF9900" SIZE="-1" FACE="ARIAL,helvetica"><font size="3"><b>*</b></font>&nbsp;&nbsp;Required</FONT></TD>
		
		<!-- V grey line -->
		<TD WIDTH="1" VALIGN="MIDDLE"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=130 ALT="" BORDER="0"></TD>
		</TR>
		</TABLE>
		</TD>
	
		<!-- User Name -->
		<TD align="right"><font size="-1"  color="#CCCCCC"><span style="font-family: Arial;">User Name</span></font></TD>
		<TD><INPUT type="text" name="OLD1"></TD>
	</TR>
	
	<!-- Old Password -->
	<TR>
		<TD align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Old Password</span></font></TD>
		<TD><INPUT type="password" id=password1 name="OLD2"></TD>
	</TR>
	
	<!-- New Password -->
	<TR>
		<TD align="right"><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;"><STRONG>New Password*</STRONG></span></font></TD>
		<TD><INPUT type="password" id=password1 name="password1"></TD>
	</TR>
	
	<!-- Confirm Password -->
	<TR>
		<TD align="right"><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;"><STRONG>Confirm Password*</STRONG></span></font></TD>
		<TD><INPUT type="password" id=password1 name="password2"></TD>
	</TR>

<TR>
	<td>&nbsp;</td>
	<!-- Submit Button -->
	<TD>
	<INPUT type="submit" value="Submit" id=submit1 name=submit1>&nbsp;&nbsp;
	<!-- Reset Buttom -->
	<INPUT type="reset" value="Reset" id=reset1 name=reset1>
	<p>
	<A HREF="C_center.asp?id=<%Response.Write Request.QueryString ("ID")%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO MAIN PAGE"></A>
	</TD>
</TR>
</TABLE>
</div>
</FORM>
<!-- END CONTENT -->	
	</td>
  </tr>
</table>
<p>&nbsp;</p>
<!--#include file="../admanager/include/bottom.html"-->
</BODY>
</HTML>
