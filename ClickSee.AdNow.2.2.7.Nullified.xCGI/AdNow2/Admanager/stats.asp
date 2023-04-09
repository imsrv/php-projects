<%@ Language=VBScript %>
<!--#Include File="include/detail.asp"-->
<HTML>
<HEAD>
<TITLE>Clicksee AdNow! Version 2.0</TITLE>
<style type="text/css">
.link1 {color: #CCCCCC; text-decoration: underline;}
.link2 {color: #FFCC00; text-decoration: underline;}
</style>
<script language="JavaScript">
<!--//BEGIN Script

function new_window(url) {

link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=400,height=360,left=80,top=80");

}
//END Script-->
</script>
</HEAD>
<BODY text="#000000" link="#000000" vlink="#000000" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="450">
  <tr>
    <td width="90%" valign="top">
<!-- DETAIL -->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
  <TR>
    <TD><IMG SRC="../images2/spacer.gif" HEIGHT=23 BORDER="0"></TD>
  </TR>
  <TR>
	<TD VALIGN="TOP">
<p align="center"><font face="Arial" color="#CCCCCC" size="4"><b>CLIENTS PROFILES</b></font></p>
	</TD>
  </TR>
</Table><br>
<FONT FACE="arial,helvetica" SIZE="3" COLOR="#FF0000"><STRONG><%ErrMSG%></STRONG></FONT><br>
<%detail%>
<br>
<!-- END DETAIL -->
	</td>
  </tr>
</table>
<br>
<!--#include file="include/bottom.html"-->
</BODY>

</HTML>