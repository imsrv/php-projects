<%@ Language=VBScript %>
<!--#Include File="../Data_Connection/Connection.asp"-->
<HTML>
<HEAD>
<TITLE>Add a new company</TITLE>
</HEAD>

<body background="../images2/bg.gif" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<form method="POST" action="include/newcompany.asp?<%=Request.ServerVariables ("QUERY_STRING")%>" onsubmit="return validate(this)" id=form1 name=form1>
<script Language="JavaScript">
function validate(theForm)
{
  if (theForm.elements["CompanyName"].value == "") {
    theForm.elements["CompanyName"].focus();
    alert("Please enter a value for the \"Company Name\" field.");
    return false;
  }


  if (theForm.elements["T13"].value == "")
  {
    theForm.elements["T13"].focus();
    alert("Please enter a value for the \"Username\" field.");
    return (false);
  }

  if (theForm.elements["T14"].value == "")
  {
    theForm.elements["T14"].focus();
    alert("Please enter a value for the \"Password\" field.");
    return (false);
  }
}
</script>

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
	<TD VALIGN="TOP"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=520 ALT="" BORDER="0"></TD>


	<TD WIDTH="428" VALIGN="TOP" ALIGN="CENTER">
	<div align="right"><strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">Add A Company</strong></font></div><br>
		<table border="0">
		
		<TR>
		<TD VALIGN="TOP" COLSPAN="2" ALIGN="center"><FONT COLOR="#FFFFFF" FACE="arial, helvetica" SIZE="-1"><STRONG><%=session("MSG")%></STRONG></FONT>
		</TD>
<% session("MSG")=abandon %>
		</TR>
		
    <tr>
      <td align="right"><b><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Company Name*</span></font></b></td>
      <td><input type="text" name="CompanyName" size="40" value="<%=session("CName")%>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Company URL</span></font></td>
      <td><input type="text" name="T11" size="40" value="<%= session("url") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Address (line1)</span></font></td>
      <td><input type="text" name="T2" size="40" value="<%= session("address1") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Address (line2)</span></font></td>
      <td><input type="text" name="T3" size="40" value="<%= session("address2") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">City</span></font></td>
      <td><input type="text" name="T4" size="40" value="<%= session("city") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">State/Province</span></font></td>
      <td><input type="text" name="T5" size="40" value="<%= session("states") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Postal Code</span></font></td>
      <td><input type="text" name="T6" size="40" value="<%= session("zip") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Country</span></font></td>
      <td><input type="text" name="T7" size="40" value="<%= session("country") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Phone</span></font></td>
      <td><input type="text" name="T8" size="40" value="<%= session("phone") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Fax</span></font></td>
      <td><input type="text" name="T9" size="40" value="<%= session("fax") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Contact Name</span></font></td>
      <td><input type="text" name="T10" size="40" value="<%= session("contactname") %>"></td>
    </tr>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Contact Email</span></font></td>
      <td><input type="text" name="T12" size="40" value="<%= session("contactemail") %>"></td>
    </tr>
    <tr>
      <td align="right"><b><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">User Name*</span></font></B></td>
      <td><input type="text" name="T13" size="40" value="<%= session("T13") %>"></td>
    </tr>
    <tr>
      <td align="right"><B><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Password*</span></font></B></td>
      <td><input type="password" name="T14" size="40" value="<%= session("T14") %>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><br>
		<input type="submit" value="Add Campaign >>" name="Next" style="font-weight: bold;">&nbsp;&nbsp;&nbsp;
		<INPUT type="submit" value="Done" name="Finish">
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


</BODY>
</HTML>