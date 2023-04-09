<%@ Language=VBScript %>
<!--#Include File="Include/editC.asp"-->
<HTML>
<HEAD>
<title>Edit Company Profile</title>
</HEAD>

<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
<!-- SPACER -->
<TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=10 BORDER="0"></TD></TR>

<!-- FORM -->
<TR>
<TD WIDTH="100%" VALIGN="TOP" COLSPAN="3" ALIGN="CENTER">
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
	<TR>
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
	
	<TD VALIGN="TOP"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=550 ALT="" BORDER="0"></TD>
	<TD WIDTH="428" VALIGN="TOP" ALIGN="CENTER">
	<div align="right"><strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">EDIT COMPANY PROFILE</strong></font></div><br>
	<!-- Error Message -->
		<FORM action="<%=Request.ServerVariables ("Path_info")%>?<%=Request.ServerVariables ("Query_String")%>" method=POST>
		<table border="0">
		<tr>
      <td align="right"><b><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Company Name*</span></font></b></td>
      <td><INPUT size="40" type="text" id=text1 name="companyname" Value="<%=Print_companies ("companyname",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Company URL</span></font></td>
      <td><input type="text" size="40" name="companyURL" Value="<%=Print_companies ("companyURL",Request ("customerid"))%>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Address (line1)</span></font></td>
      <td><INPUT size="40" type="text" id=text2 name="companyaddress1" Value="<%=Print_companies ("companyaddress1",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Address (line2)</span></font></td>
      <td><INPUT size="40" type="text" id=text4 name="companyaddress2" Value="<%=Print_companies ("companyaddress2",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">City</span></font></td>
      <td><INPUT size="40" type="text" id=text5 name="companycity" Value="<%=Print_companies ("companycity",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">State/Province</span></font></td>
      <td><INPUT size="40" type="text" id=text6 name="companystate" Value="<%=Print_companies ("companystate",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Postal Code</span></font></td>
      <td><INPUT size="40" type="text" id=text7 name="companypostalcode" Value="<%=Print_companies ("companypostalcode",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Country</span></font></td>
      <td><INPUT size="40" type="text" id=text9 name="companycountry" Value="<%=Print_companies ("companycountry",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Phone</span></font></td>
      <td><INPUT size="40" type="text" id=text12 name="companyphonevoice" Value="<%=Print_companies ("companyphonevoice",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Fax</span></font></td>
      <td><INPUT size="40" type="text" id=text13 name="companyphonefax" Value="<%=Print_companies ("companyphonefax",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Contact Name</span></font></td>
      <td><INPUT size="40" type="text" id=text8 name="contactname" Value="<%=Print_companies ("contactname",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Contact Email</span></font></td>
      <td><INPUT size="40" type="text" name="contactemail" Value="<%=Print_companies ("contactemail",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;"><STRONG>User Name*</STRONG></span></font></td>
      <td><INPUT size="40" type="text" id=text14 name="companyusername" Value="<%=Print_companies ("companyusername",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;"><STRONG>Password*</STRONG></span></font></td>
      <td><INPUT size="40" type="text" id=text15 name="companypassword" Value="<%=Print_companies ("companypassword",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;"><STRONG>Customer Since</STRONG></span></font></td>
      <TD><font size="-1" color="#CCCCCC"><span style="font-family: Arial;"><%=Print_companies ("customersince",Request ("customerid"))%></span></font></TD>
	</TR>
    <tr>
  	  <td>&nbsp;<input type="hidden" value="<%=Request("customerid")%>" name="customerid"></td>
	  <td><br><INPUT type="submit" value="D O N E" id=submit1 name=submit1>&nbsp;&nbsp;<INPUT type="reset" value="Reset" id=reset1 name=reset1>
	  <p>
	  <%IF Request.QueryString ("BURL")<>EMPTY THEN%>
	  <A HREF="<%=decode(Request.QueryString ("BURL"))%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO PREVIOUS"></A>
	  <%END IF%>
	</td>
	</tr>
	</TABLE>
	</FORM>
	

</center></div>
	</TD>
	</TR>
	</TABLE>
</TD>
</TR>

<!-- SPACER -->
<TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=23 BORDER="0"></TD></TR>
</TABLE>
<!--#include file="include/bottom.html"-->

</BODY>
</HTML>