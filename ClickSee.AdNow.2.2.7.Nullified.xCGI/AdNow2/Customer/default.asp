
<HTML>
<HEAD>
</HEAD>
<body background="../images2/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#ff6600" bottommargin="0" rightmargin="0">
<FORM action="include/C_login.asp" method=POST>	
<!-- LOGO -->
<!--#include file="include/c_logo.inc"-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="450">
  
  <TR><TD HEIGHT="5">&nbsp;</TD></TR>
	<!-- Login Form -->
	<TR valign="top">
	<TD ALIGN="CENTER">
	    <TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" width="300">
          <TR>
	<TD>
	
	    <% if Session("Wstr") <> Empty then 
	    
	       Response.Write "<p><b><font face='Verdana,Arial' size='2' color='#FFFFFF'>"&Session("Wstr")&"</font></b></p>"
	       Session("Wstr")=Empty
	       end if
	    %>     
		      <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="300">
                <TR>
		<!-- USER NAME IMG -->
		          <TD width="124"><font face="Verdana,Arial" size="3" color="#FFFFFF"><b>USERNAME:</b></font></TD>
		<!-- TEXT FIELD:USER NAME -->
		          <TD WIDTH=176 HEIGHT=28> 
                    <INPUT type="text" id=text1 name="Username" ALIGN="center" SIZE="25" MAXLENGTH="195">
		</TD>
		</TR>
		<TR>
		<!-- PASSWORD IMG -->
		          <TD width="124"><font face="Verdana,Arial" size="3" color="#FFFFFF"><b>PASSWORD:</b></font></TD>
		<!-- TEXT FIELD:PASSWORD -->
		          <TD WIDTH=176 HEIGHT=30> 
                    <INPUT type="password" id=password1 name="Password" ALIGN="center" SIZE="25" MAXLENGTH="195">
		</TD>
		</TR>
			<TR>
			      <TD WIDTH="124" HEIGHT="20"><br>
                  </TD>
			<!-- Submit Button-->
			<tr>
		          <td width="124">&nbsp;</td>
		          <td WIDTH=176 HEIGHT=30> 
                    <INPUT type="image" src="../images2/logon.gif" border="0" value="LOGON" name="submit1"></td>
			</tr>
		
</table>
</tr>
</table>
</tr>
</table>
</FORM>
<p>&nbsp;</p>
<!--#include file="../admanager/include/bottom.html"-->

</body>
</html>
