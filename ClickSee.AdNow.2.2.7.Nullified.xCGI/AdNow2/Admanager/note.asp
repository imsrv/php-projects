<%@ Language=VBScript %>
<!--#Include File="../Data_Connection/Connection.asp"-->
<!--#Include File="include/editn.asp"-->
<HTML>
<HEAD>
<TITLE>Add a note</TITLE>
</HEAD>

<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr>
    <td>
<!-- BEGIN DETAIL -->

<form method="POST" action="include/newnote.asp?<%=Request.ServerVariables ("Query_String")%>">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
<!-- SPACER -->
<TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=5 BORDER="0"></TD></TR>


<!-- FORM -->
<TR>
<TD WIDTH="100%" VALIGN="TOP" COLSPAN="3" ALIGN="CENTER">
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
	<tr>
		<td width="600" VALIGN="TOP">
			<font size="-1" color="#FFCC33">
			<span style="font-family: Arial;">
			View Note::
			</span>
			</font>
			<font size="-1" color="#CCCCCC">
			<span style="font-family: Arial;"><%=Show_note%></span>
			</font>
			<hr size="1">
		</td>
	</tr>
	<tr>
		<td><p>&nbsp;</td>
	</tr>
	<tr>
		<td width="600" VALIGN="TOP">
			<font size="-1" color="#FFCC33">
			<span style="font-family: Arial;">
			Edit Note::
			</span>
			</font>
		</td>
	</tr>
	<TR>
	<TD WIDTH="428" VALIGN="TOP" ALIGN="CENTER">
	<table border="0">
		
	<TR>
		<TD VALIGN="TOP" COLSPAN="2" ALIGN="center"><FONT COLOR="#FF0000" FACE="arial, helvetica" SIZE="-1"><STRONG><%ErrMSG%></STRONG></FONT>
		</TD>
	</TR>
    <tr>
      <td align="right" valign="top"><b><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Company Note</span></font></b></td>
      <td>
      <TEXTAREA rows=6 cols=40 name="notes"><%=print_note%></TEXTAREA></td>
    </tr>
    <tr>
      <td>&nbsp;<input type="hidden" name="customerid" value="<%=Request("customerid")%>"></td>
      <td>
		<input type="submit" value="Finish" name="B1" style="font-weight: bold;">&nbsp;&nbsp;&nbsp;
		<input type="reset" value="Reset" name="B2">
		<p>	
		<%IF Request.QueryString ("BURL")<>EMPTY THEN%>
		<A HREF="<%=decode(Request.QueryString ("BURL"))%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO PREVIOUS"></A>
		<%END IF%>
</td>
    </tr>
  </table>
	</FORM>
	
	</TD>
	</TR>
	</TABLE>
</TD>
</TR>

<!-- SPACER -->
<TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=23 BORDER="0"></TD></TR>
</TABLE>

<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>