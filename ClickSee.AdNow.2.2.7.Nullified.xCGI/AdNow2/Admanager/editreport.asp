<%@ Language=VBScript %>
<!--#Include File="Include/editR.asp"-->
<HTML>
<HEAD>
<title>Edit Stats Report by Email</title>
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
	<TD WIDTH="500" VALIGN="TOP" ALIGN="CENTER">
	<div align="right"><strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">STATS REPORT BY E-MAIL</span></font></strong></div>
	<FONT FACE="arial,helvetica" SIZE="-1" COLOR="#FF0000"><STRONG><%ErrMSG%></STRONG></FONT>
		<FORM action="<%=Request.ServerVariables ("Path_info")%>?<%=Request.ServerVariables ("Query_String")%>" method=POST onsubmit="return validate(this)" id=form1 name=form1>
<script language="JavaScript">
function wrong()
{
theForm.elements["emailreport"].focus();
alert("Incorrect Syntax.  Please check your email again.");
};

function validate(theForm)
{
w=0; x=0; y=0; z=0;
a=0; b=0; c=0; d=0;
mail = theForm.elements["emailreport"].value;
mail2=theForm.elements["fromaddress"].value;

if (((((((((theForm.elements["DReport"].value!="") || (theForm.elements["iReport"].value!="")) || (theForm.elements["fromname"].value!="")) || (theForm.elements["fromaddress"].value!="")) || (theForm.elements["emailreport"].value!="")) || (theForm.elements["Name"].value!="")) || (theForm.elements["cc"].value!="")) || (theForm.elements["subject"].value!="")) || (theForm.elements["Body"].value!=""))
{
  if (theForm.elements["fromaddress"].value == "")
  {
    theForm.elements["fromaddress"].focus();
    alert("Please enter a value for the \"From Email\" field.");
    return (false);
  }

  if (theForm.elements["fromaddress"].value != "")
  {
     for (i=mail2.length; i>0; i--)
	 {
	 if (mail2.substring(i-1,i) == "@") a++; //only one @ allowed
	 if (mail2.substring(i-1,i) == ".") b++; //only one dot allowed
	 if (mail2.substring(i-1,i) == " ") c++; //no spaces allowed
	 };
		 
	  //Check if @ and . not on position one
	  if (mail2.substring(0,1) == "@") d++;
		  
	  
	  //Validation
	  if (a != 1 || c != 0 || d != 0) 
	{
	  theForm.elements["fromaddress"].focus();
	  alert("Please check your e-mail again");
	  return (false)
	 }
	 if (b == 0)
	{
	  theForm.elements["fromaddress"].focus();
	  alert("Please check your e-mail again");
	  return (false)
	 }
   }
  
  if (theForm.elements["emailreport"].value == "")
  {
    theForm.elements["emailreport"].focus();
    alert("Please enter a value for the \"Contact Email Report\" field.");
    return (false);
  }
  if (theForm.elements["emailreport"].value != "")
  {
     for (i=mail.length; i>0; i--)
	 {
	 if (mail.substring(i-1,i) == "@") x++; //only one @ allowed
	 if (mail.substring(i-1,i) == ".") y++; //only one dot allowed
	 if (mail.substring(i-1,i) == " ") z++; //no spaces allowed
	 };
		 
	  //Check if @ and . not on position one
	  if (mail.substring(0,1) == "@") w++;
		  
	  //Validation
	  if (x != 1 || z != 0 || w != 0) 
	{
	  theForm.elements["emailreport"].focus();
	  alert("Please check your e-mail again");
	  return (false)
	 }
	 if (y == 0)
	{
	  theForm.elements["emailreport"].focus();
	  alert("Please check your e-mail again");
	  return (false)
	 }
   }

  if (theForm.elements["DReport"].value == "")
  {
	  theForm.elements["DReport"].focus();
    alert("Please enter 'Report by day'.");
    return (false);
  }
  if (theForm.elements["Body"].value == "")
  {
    theForm.elements["Body"].focus();
    alert("Please enter a value for the \"Body\" field.");
    return (false);
  }
}
}  
</script>
		<table border="0" width="100%">
	<!-- Report Stats by Email -->
    <tr>
      <td align="right"><br><font size="-1" color="#FF9900"><span style="font-family: Arial;"><b>Report every*</b></span></font></td>
      <td valign="top"><br><INPUT size="3" type="text" name="DReport" Value="<%=Print_companies ("DReport",Request ("customerid"))%>" maxlength="3">&nbsp;<font size="-1" color="#FFCC00"><span style="font-family: Arial;">days.</span></font></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Sender Name</span></font></td>
      <td><INPUT size="40" type="text" name="fromname" Value="<%=Print_companies ("fromname",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#FF9900"><span style="font-family: Arial;"><b>Sender Email*</b></span></font></td>
      <td><INPUT size="40" type="text" name="fromaddress" Value="<%=Print_companies ("fromaddress",Request ("customerid"))%>"></TD>
	</TR>
    <tr>	
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Receiver Name</span></font></td>
      <td><INPUT size="40" type="text" name="Name" Value="<%=Print_companies ("Name",Request ("customerid"))%>"></TD>
	</TR>	
    <tr>
      <td align="right"><font size="-1" color="#FF9900"><span style="font-family: Arial;"><b>Receiver Email*</b></span></font></td>
      <td><INPUT size="40" type="text" name="emailreport" Value="<%=Print_companies ("emailreport",Request ("customerid"))%>"></TD>
	</TR>	
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Cc</span></font></td>
      <td><INPUT size="40" type="text" name="cc" Value="<%=Print_companies ("cc",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Subject</span></font></td>
      <td><INPUT size="40" type="text" name="subject" Value="<%=Print_companies ("subject",Request ("customerid"))%>"></TD>
	</TR>
    <tr>
       <td align="right" valign="top"><font size="-1" color="#FF9900"><span style="font-family: Arial;"><b>Body*</b></span></font></td>
      <td valign="top"><TEXTAREA rows=6 cols=40 name="Body"><%=Print_companies ("Body",Request ("customerid"))%></TEXTAREA>&nbsp;&nbsp; 
	  <a href="javascript:new_window('glossary.asp#body')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="How to write BODY?"></a></TD>
	</TR>
	<tr>
		<td align="right" valign="top">&nbsp;</td>
		<td valign="top"><p><font size="-1" color="#cccccc"><span style="font-family: Arial;">Type <--Advertiser_Name--> = Print Company Name.
		<BR>Type <--Call_Report--> = Print Statistics Report.<br>
					<font color="#FF3333"><b>These two parameters are case sensitive.</b></font></span></font></p></td>
	</tr>
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
<p>&nbsp;</p>
	
	
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