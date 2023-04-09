<%@ Language=VBScript %>
<!--#Include File="../Data_Connection/Connection.asp"-->
<HTML>
<HEAD>
<TITLE>Add A New Campaign</TITLE>
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

<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr>
    <td>
<!-- BEGIN DETAIL -->
<form method="POST" action="include/newcampaign.asp?<%=Request.ServerVariables ("Query_String")%>">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
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
	<strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">ADD NEW CAMPAIGN</strong></font>&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#campaign')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'CAMPAIGN'?"></a><br>
	  		<br><table border="0">
			  <TR>
		  		<TD VALIGN="TOP" COLSPAN="2" ALIGN="center"><FONT COLOR="#FFFFFF" FACE="arial, helvetica" SIZE="-1"><STRONG><%ErrMSG%></STRONG></FONT></TD>
	  		  </TR>
    		  <tr>
      	  		<td align="right"><b><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Campaign Name*</span></font></b></td>
      	  		<td><input type="text" name="campaignname" size="40" value="<%=session("campaignname")%>"></td>
    		  </tr>
    		  <tr>
	      	  	<td align="right"><b><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Campaign Description</span></font></b></td>
	      	  	<td>
	      		<TEXTAREA rows=6 cols=40 name="campaigndescription"><%=session("cdescription")%></TEXTAREA></td>
    		  </tr>
    		  <tr>
      	  		<td>&nbsp;<input type="hidden" name="customerid" value="<%=Request("customerid")%>"></td>
      	  		<td>
				  <input type="submit" value="Next >>" name="Next" style="font-weight: bold;">&nbsp;&nbsp;&nbsp;
				  <INPUT type="reset" value="Reset" id=reset1 name=reset1>
					<p>	
					<%IF Request.QueryString ("BURL")<>EMPTY THEN%>
					<A HREF="<%=decode(Request.QueryString ("BURL"))%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO PREVIOUS"></A>
					<%END IF%>
		  		</td>
    		  </tr>
  	  		</table>
  		  </TD>
  		</TR>
	  </TABLE>
	</TD>
  </TR>
<!-- SPACER -->
  <TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=23 BORDER="0"></TD></TR>
</TABLE>
</FORM>
<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>