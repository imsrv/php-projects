<%@ Language=VBScript %>
<!--#Include File="include/del.asp"-->
<HTML>
<HEAD>
<TITLE>CLICKSEEADNOW VERSION 2</TITLE>
</HEAD>
<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH="100%" height="505">
<TR valign="top">
<TD ALIGN="CENTER">
	<FORM action="<%=Request.ServerVariables ("PATH_INFO")%>?<%=Request.ServerVariables ("Query_String")%>" method=POST id=form1 name=form1>
<div align="center"><p><b><font style="font-family: Courier New;"><br><br><font color="#FFFFFF">Are you sure you want to delete?</font></font></b></p>
	<INPUT type="submit" value="YES" name="Deletecampaign">
	&nbsp;&nbsp;<INPUT type="submit" value="NO" name="NO"></div>
	</FORM>
</TD>
</TR>
</TABLE>
<!--#include file="include/bottom.html"-->

</BODY>
</HTML>