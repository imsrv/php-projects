<HTML>
<HEAD>
<title>Clicksee AdEngine - Admin Center</title>
<style type="text/css">
<!--
.Textlink {  font-family: Verdana, Arial; font-size: 10pt; color: #FFFFFF}
-->
</style>
</HEAD>
<BODY background="../images2/bg.gif" text="#000000" link="#0000FF" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<%
   if Request.QueryString ("CID") = "" then 
      CID = "-"
   else 
      CID = Request.QueryString ("CID")
   end if
   if Request.QueryString ("adID") = "" then 
      adID = "-"
   else 
      adID = Request.QueryString ("adID")
   end if
%>


<table border="0" cellspacing="2" cellpadding="2" bgcolor="#333333" align=center>
  <tr bgcolor="#CCCC99"> 
    <td colspan=2><b><font face="Arial" size="-1">Pass by value</font></b></td>
  </tr>
  <tr bgcolor="#333333"> 
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Customer 
      ID</span></font></b></font></td>
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Ad 
      ID</span></font></b></font></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td align="center"> <%=CID%> </td>
    <td align="center"> <%=adID%> </td>
  </tr>
</table>
<br>





</BODY>
</HTML>

