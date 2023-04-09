<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<TITLE>Clicksee AdNow! Version 2.0 - Database Page</TITLE>
<META content=no-cache http-equiv=pragma>
</HEAD>
<body background="../images2/bg.gif" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" text="#FFFF00">
<!--#include file="logo.asp"-->

<p>&nbsp;</p>
<p>&nbsp;</p>
<% If (Request("name") <> "") Then
	 Select Case UCase(Request("name"))
       Case "SQL"
%>

		 <form method="post" action="sql_1.asp">
			<table width="62%" border="0" align="center">
			<tr>
				<td width="48%" height="33">
					<font face="Verdana,Arial" color="#CCCCCC">Please insert user name of sql</font>
				</td>
				<td width="15%" height="33">&nbsp;</td>
				<td width="49%" height="33">
					<input type="text" name="USER" size="30">
				</td>
			</tr>
			<tr>
				<td width="48%">
					<font face="Verdana,Arial" color="#CCCCCC">Please insert password of sql</font>
				</td>
				<td width="15%" height="33">&nbsp;</td>
				<td width="49%">
					<input type="password" name="PWD" size="30">
				</td>
			</tr>
	        <tr>
				<td width="48%">
					<font face="Verdana,Arial" color="#CCCCCC">Please insert Data Source</font>
				</td>
				<td width="15%">&nbsp;</td>
				<td width="49%">
					<input type="text" name="DataSource" size="30">
				</td>
			</tr>
	        <tr>
				<td width="48%">
					<font face="Verdana,Arial" color="#CCCCCC">Please insert FileName</font>
				</td>
				<td width="15%">&nbsp;</td>
				<td width="49%">
					<input type="text" name="FileName" size="30">
				</td>
			</tr>
			<tr>
				<td Colspan="3">&nbsp;</td>
			</tr>
		    <tr>
				<td width="48%">&nbsp;</td>
				<td width="15%"><input type="image" border="0" name="imageField" src="../images2/btnext.gif" width="69" height="21" alt="Next"></td>
				<td width="49%">&nbsp;</td>
			</tr>
          </table>
          </form>
<%
       Case "ACCESS"
%>
		  <form method="post" action="mcdb.asp">
		  <table width="75%" border="0" align="center">
		  <tr><td><font face="Verdana,Arial" color="#CCCCCC">Please enter the ODBC data source name of Clicksee Adnow V.1.0</font></td><td>&nbsp;</td>
		  <td><input type="text" name="ODBC" size=30></td></tr>
		  <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td><td><input type="image" border="0" name="imageField" src="../images2/btnext.gif" width="69" height="21" alt="Next"></td><td>&nbsp;</td></tr>
		  </table>
          </form>
<%
     End Select
   End If 
%> 
</body>
</html>
