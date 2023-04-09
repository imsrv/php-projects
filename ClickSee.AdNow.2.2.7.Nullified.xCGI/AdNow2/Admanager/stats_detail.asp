<%@ Language=VBScript %>
<!--#Include File="include/viewstats.asp"-->
<html>
<head>
<title>Clicksee AdNow! Version 2.0: STATS DETAIL</title>
<style type="text/css">
.link1 {color: #FFCC00; text-decoration: underline;}
</style>
</head>
<BODY text="#000000" link="#FFCC00" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<p align="center"><font face="Arial" color="#CCCCCC" size="4"><b>ADVERTISEMENT PROFILE</b></font></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td><FONT FACE="arial,helvetica" SIZE="3" COLOR="#FF0000"><STRONG><%ErrMSG%></STRONG></FONT></td>
  </tr>
  <tr>
	<td width="100%" ALIGN="CENTER" VALIGN="TOP">
								
<%=print_CompanyName (Request.QueryString ("adid"))%>

<hr size="1" width="600" align=center><br>
      <!--Page On--> 
      <table border="0" cellspacing="1" cellpadding="3">
		<% x=0 %>
        <%=statistics(x)%> 
      </table>
      
      <FORM action="<%=Request.ServerVariables ("Path_info")%>?<%=Request.ServerVariables ("QUERY_STRING")%>" method=POST>


<p><font face="Verdana,Arial" size="2" color="#CCCCCC"><b>View the stats in the past </b></font>
<INPUT type="text" id=text1 name="Page" size="5">&nbsp;<font face="Verdana,Arial" size="2" color="#CCCCCC"><b>days </b></font>
<INPUT type="submit" value="View" id=submit1 name=submit1>
</FORM>

<table border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td bgcolor="#cccccc" align="center"><font face="Verdana,Arial" size="2"><b>Date</b></font></td>
    <td bgcolor="#cccccc" align="center"><font face="Verdana,Arial" size="2"><b>Impressions</b></font></td>
    <td bgcolor="#cccccc" align="center"><font face="Verdana,Arial" size="2"><b>Clicks</b></font></td>
    <td bgcolor="#cccccc" align="center"><font face="Verdana,Arial" size="2"><b>Percentage</b></font></td>
  </tr>
  <% x=1 %>
<%=statistics(x)%>
</table>

</center></div>
		<p>
		<div ALIGN="CENTER">
		<%IF Request.QueryString ("BURL")<>EMPTY THEN%>
		<A HREF="<%=decode(Request.QueryString ("BURL"))%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO PREVIOUS"></A>
		<%END IF%>
		<br>
		<br>
		</DIV>
</td>
</tr>
</table>
<!--#include file="include/bottom.html"-->
</body>
</HTML>
