<%@ Language=VBScript%>
<!--#Include File="../Data_Connection/Connection.asp"-->
<HTML>
<HEAD>
<TITLE>Clicksee AdNow! Version 2.0 - Administrative Login Page</TITLE>
<META content=no-cache http-equiv=pragma>
</HEAD>
<body background="../images2/bg.gif" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<FORM action="admin.asp" method=POST name=form2>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="485">
  <tr>
    <td valign="top">
<!-- Error Message -->
<p ALIGN="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><FONT FACE="arial,helvetica" SIZE="2" COLOR="#FFFFFF"><%=session("MSG")%></FONT></b></p>
<% session("MSG")=abandon %>
      <table width="600" border="0" cellpadding="0" cellspacing="0" align="left">
        <tr>
		  <td width="50">&nbsp;</td>
		  <td>
		    <table width="100%" border="0" cellpadding="3" cellspacing="3">
			  <tr>
          		<td width="40%"><font face="Verdana,Arial" color="#FFFFFF"><b>USER NAME:</b></font></td>
          		<td width="60%"><INPUT type="text" name="username"></td>
		  	  </tr>
		  	  <tr>
	            <td width="40%"><font face="Verdana,Arial" color="#FFFFFF"><b>PASSWORD:</b></font></td>
	            <td width="60%"><INPUT type="password" name="password1"></td>
		  	  </tr>
		<%CheckFirst%>
		  	  <tr>
		    	<td width="40%">&nbsp;</td>
				<td><INPUT type="image" src="../images2/logon.gif" border="0" value="LOGON" name="submit1"></td>
			  </tr>
			</table>
		  </td>
		  </tr>
		</table>
	  </td>
  </tr>
</table>
</FORM>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>
<%EndSession%>
