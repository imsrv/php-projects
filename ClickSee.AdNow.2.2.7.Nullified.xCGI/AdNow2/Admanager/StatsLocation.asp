<%@ Language=VBScript %>
<%
Session.TimeOut=20
%>
<!--#Include File="../data_connection/DSN_Connection.asp"-->
<!--#include file="include/stats_L.asp"-->
<HTML>
<HEAD>
<title>Clicksee AdEngine - Admin Center</title>
<style type="text/css">
<!--

.Textlink {  font-family: Verdana, Arial; font-size: 10pt; color: #FFFFFF}
-->
</style>
</HEAD>
<BODY text="#000000" link="#0000FF" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!-- LoGo -->
<!--#include file="include/logo.asp"--> <br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr valign="top">
    <td>
<!-- BEGIN DETAIL -->

<p align="center"><font face="Arial" color="DDDDDD" size="+1">STATISTICS OF AVERAGE CLICK THRU BY LOCATION</font></p>


<table border="0" cellspacing="2" cellpadding="2" width="600" bgcolor="#333333" align=center>
  <tr bgcolor="#333333"> 
    <td align="center"><font color="#FF6600"><b><font size=-2><span style="font-family: Verdana;">Location 
      </span></font></b></font></td>
    <td align="center"><font color="#FF6600"><b><font size=-2><span style="font-family: Verdana;">No. 
      of Active ads</span></font></b></font></td>
    <td align="center"><font color="#FF6600"><b><font size=-2><span style="font-family: Verdana;">Impressions</span></font></b></font></td>
    <td align="center"><font color="#FF6600"><b><font size=-2><span style="font-family: Verdana;">Clicks</span></font></b></font></td>
    <td align="center"><font color="#FF6600"><b><font size=-2><span style="font-family: Verdana;">Click 
      Thru</span></font></b></font></td>
  </tr>
  <%For Display_report=1 To TargetCount%> 
  <tr bgcolor="#CCCCCC"> 
    <td align="center"> <A HREF="statsLocation1.asp?selectlocation=<%=Server.URLEncode(Session("Location_DB" & Display_report))%>"> 
      <font size=-1><span style="font-family: Arial;"> <%Response.write decode(Session("Location_DB" & Display_report))%> 
      </span></font> </A> </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"> <%=NumberOfads (Session("Location_DB" & Display_report))%> 
      <%Session("Location_DB" & Display_report)=abandon%> </span></font> </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"><%=(Session("Imp" & Display_report))%></span></font>	
    </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"><%=(Session("Click" & Display_report))%></span></font>	
    </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"> <%If Session("Imp" & Display_report)<>0 Then
			Response.Write formatpercent(Session("Click" & Display_report)/Session("Imp" & Display_report),2)	
		Else%> 0.00% <%End If%> </span></font> <%
		Session("Imp" & Display_report)=Abandon
		Session("Click" & Display_report)=Abandon
		%> </td>
  </tr>
  <%Next%> 
</table>
<br>
<center>
  
</center>
<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>
<%Conn.Close%>
