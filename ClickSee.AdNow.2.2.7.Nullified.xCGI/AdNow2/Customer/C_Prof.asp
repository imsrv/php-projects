<%@ Language=VBScript %>
<!--#Include File="include/Cadmin.asp"-->
<HTML>
<HEAD>
<TITLE>Company Profile - Customer Section</title>
</HEAD>
<body background="../images2/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#ff6600" bottommargin="0" rightmargin="0">
<!-- LOGO -->
<!--#include file="include/c_logo.inc"-->

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	    <td ALIGN="CENTER"><br><b><font face="Arial,helvetica" color="#FFFFFF" size="3">COMPANY PROFILE</font></b></td>
	</tr>
	<!-- END 1ST ROW -->
</table>


<%
Set Rs=Conn.Execute ("Select * From Companies Where CustomerID=(" & Request.QueryString ("ID")+0 & ")")
%>
<FORM action="include/C_com.asp?ID=<%=Request.QueryString ("ID")%>" method=POST>
<div align="center">
<FONT COLOR="#FFFFFF" FACE="arial,helvetica" SIZE="-1"><strong><%ErrMSG%></STRONG></FONT>

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=2 WIDTH="80%" ALIGN="CENTER">
<TR>
<!-- Right Space -->
<TD VALIGN="TOP" ALIGN="RIGHT">
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
	<TR>
	<!-- "Required*" -->
	<TD VALIGN="TOP" ALIGN="RIGHT"><FONT COLOR="#FF9900"><font size="3"><b>*</b></font>&nbsp;&nbsp;Required</FONT></TD>
	<TD VALIGN="TOP"><IMG SRC="../images2/spacer.gif" WIDTH=5 HEIGHT=300 ALT="" BORDER="0"></TD>
	<!-- Vertical Line -->
	<TD WIDTH="0" VALIGN="TOP"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=550 BORDER="0"></TD>
	</TR>
	</TABLE>
</TD>
<!-- Form -->
<TD VALIGN="TOP" ALIGN="LEFT">
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
	
	<TR>
		<TD><b><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Company Name*</span></font></b></TD>
		<TD><INPUT type="text" style="font-weight: bold;" id=text1 name="text1" Value="<% If Rs("CompanyName")<>Empty Then Response.Write decode(Rs("CompanyName")) End If %>"></TD>
	</TR>
	<TR>
		<TD>&nbsp;</TD>
		<TD><INPUT type="Hidden" id=text3 name="text3" Value="<% If Rs("CustomerSince")<>Empty Then Response.Write (Rs("CustomerSince")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Address (line 1)</span></font></TD>
		<TD><INPUT type="text" id=text2 name="text2" Value="<% If Rs("CompanyAddress1")<>Empty Then Response.Write decode(Rs("CompanyAddress1")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Address (line 2)</span></font></TD>
		<TD><INPUT type="text" id=text4 name="text4" Value="<% If Rs("CompanyAddress2")<>Empty Then Response.Write decode(Rs("CompanyAddress2")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">City</span></font></TD>
		<TD><INPUT type="text" id=text5 name="text5" Value="<% If Rs("CompanyCity")<>Empty Then Response.Write decode(Rs("CompanyCity")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">State/Province</span></font></TD>
		<TD><INPUT type="text" id=text6 name="text6" Value="<% If Rs("CompanyState")<>Empty Then Response.Write decode(Rs("CompanyState")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Postal Code</span></font></TD>
		<TD><INPUT type="text" id=text7 name="text7" Value="<% If Rs("CompanyPostalCode")<>Empty Then Response.Write decode(Rs("CompanyPostalCode")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Country</span></font></TD>
		<TD><INPUT type="text" id=text9 name="text9" Value="<% If Rs("CompanyCountry")<>Empty Then Response.Write decode(Rs("CompanyCountry")) End If %>"></TD>
	</TR>	
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Contact Name</span></font></TD>
		<TD><INPUT type="text" id=text8 name="text8" Value="<% If Rs("ContactName")<>Empty Then Response.Write decode(Rs("ContactName")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Contact Email</span></font></TD>
		<TD><INPUT type="text" id=text10 name="text10" Value="<% If Rs("ContactEmail")<>Empty Then Response.Write decode(Rs("ContactEmail")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Company URL</span></font></TD>
		<TD><INPUT type="text" id=text11 name="text11" Value="<% If Rs("CompanyURL")<>Empty Then Response.Write decode(Rs("CompanyURL")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Phone</span></font></TD>
		<TD><INPUT type="text" id=text12 name="text12" Value="<% If Rs("CompanyPhoneVoice")<>Empty Then Response.Write decode(Rs("CompanyPhoneVoice")) End If %>"></TD>
	</TR>
	<TR>
		<TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Fax</span></font></TD>
		<TD><INPUT type="text" id=text13 name="text13" Value="<% If Rs("CompanyPhoneFax")<>Empty Then Response.Write decode(Rs("CompanyPhoneFax")) End If %>"></TD>
	</TR>
	<tr>
		<td>&nbsp;</td>
		<td><br><INPUT type="submit" value="Submit" id=submit1 name=submit1>&nbsp;&nbsp;&nbsp;<INPUT type="reset" value="Reset" id=reset1 name=reset1></td>
	</tr>
	<tr>
		<td COLSPAN="2" HEIGHT="3">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><A HREF="C_center.asp?id=<%Response.Write Request.QueryString ("ID")%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO MAIN PAGE"></A></td>
	</tr>
	<!-- End Form -->
	</TABLE>
</TD>
</TR>
</table>

</div>
</FORM>
<p>&nbsp;</p>
<!--#include file="../admanager/include/bottom.html"-->

</BODY>
</HTML>
