<%@ Language=VBScript %>
<!--#Include File="Include/editCamp.asp"-->
<HTML>
<HEAD>
<TITLE>Edit Campaign</TITLE>
<!-- START open.window script -->
<script language="JavaScript">
<!--//BEGIN Script

function new_window(url) {

link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=400height=360,left=80,top=80");

}
//END Script-->
</script>
<!-- END open.window script -->
</HEAD>

<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br><br><table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr>
    <td>
<!-- BEGIN DETAIL -->

<form method="POST" action="<%=Request.ServerVariables ("Path_info")%>?<%=Request.ServerVariables ("Query_String")%>">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
<!-- SPACER -->
<TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=10 BORDER="0"></TD></TR>


<!-- FORM -->
<TR>
<TD WIDTH="100%" VALIGN="TOP" COLSPAN="3" ALIGN="CENTER">
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
	<TR>
	<!-- Text "Required*" -->
	<TD WIDTH="169" VALIGN="TOP" ALIGN="CENTER">
		<TABLE WIDTH="150" BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
		<TD WIDTH="150"><IMG SRC="../images2/spacer.gif" WIDTH=150 HEIGHT=6 ALT="" BORDER="0"></TD>
		</TR>
		<TR>
		<TD WIDTH=150 ALIGN="RIGHT"><FONT COLOR="#FF9900" FACE="arial, helvetica" SIZE="-1"><font size="3"><b>*</b></font>&nbsp;&nbsp;Required</FONT></TD>
		</TR>
		
		</TABLE>
	</TD>
	
	<!-- V LINE -->
	<TD VALIGN="TOP"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=400 ALT="" BORDER="0"></TD>


	<TD WIDTH="428" VALIGN="TOP" ALIGN="CENTER">
	<div align="right"><strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">EDIT CAMPAIGN</strong></font></div><br>
	<table border="0">
		
	<TR>
		<TD VALIGN="TOP" COLSPAN="2" ALIGN="center"><FONT COLOR="#FF0000" FACE="arial, helvetica" SIZE="-1"><STRONG><%ErrMSG%></STRONG></FONT>
		</TD>
	</TR>
    <tr>
      <td align="right"><b><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Campaign Name*</span></font></b></td>
      <td><input type="text" name="campaignname" size="40" value="<%=Print_campaign ("campaignname",Request.QueryString ("campaignid"))%>"></td>
    </tr>
    <tr>
      <td align="right"><b><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Campaign Description</span></font></b></td>
      <td>
      <TEXTAREA rows=6 cols=40 name="campaigndescription"><%=Print_campaign ("campaigndescription",Request.QueryString ("campaignid"))%></TEXTAREA></td>
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