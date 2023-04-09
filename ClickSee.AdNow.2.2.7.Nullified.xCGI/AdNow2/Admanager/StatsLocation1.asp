<%@ Language=VBScript %>
<%
Session.TimeOut=20
%>
<!--#Include File="../data_Connection/DsN_Connection.asp"-->
<!--#include file="include/stats_L1.asp"-->
<HTML>
<HEAD>
<title>Clicksee AdEngine - Admin Center</title>
<style type="text/css">
<!--
.textlink {  font-family: Verdana, Arial; font-size: 10pt; color: #FFFFFF}
-->
</style>
</HEAD>
<BODY text="#000000" link="#0000FF" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr valign="top">
    <td>
<!-- BEGIN DETAIL -->

<p align="center"><font face="Arial" color="DDDDDD" size="+1">STATISTICS OF AVERAGE CLICK THRU BY LOCATION</font></p>


<table border="0" cellspacing="2" cellpadding="2" bgcolor="#333333" align=center>
  <tr bgcolor="#CCCC99"> 
    <td colspan=5><b><font face="Arial" size="-1">AVG report</font></b><b><font face="Arial" size="-1"></font></b></td>
  </tr>
  <tr bgcolor="#333333"> 
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Company 
      Name</span></font></b></font></td>
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Ad 
      Name</span></font></b></font></td>
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Impressions</span></font></b></font></td>
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Clicks</span></font></b></font></td>
    <td align="center"><font color="#FF9900"><b><font size=-2><span style="font-family: Verdana;">Percentage</span></font></b></font></td>
  </tr>
  <% tmp = "" %> <%For Display_report=1 To TargetCount%> 
  <tr bgcolor="#CCCCCC"> 
    <td align="center"> <% 'if tmp <> Session("companyname" & Display_report) then %> 
      <font size=-1><span style="font-family: Arial;"><a href="stats.asp?companycode=<%=session("Customer" & Display_report)%>"> 
      <%=decode(Session("companyname" & Display_report))%></a></span> </font>
      <% 'tmp = Session("companyname" & Display_report) %> 
      <% Session("companyname" & Display_report)=abandon
	  'end if
	%> </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"><a href="stats_detail.asp?adid=<%=Session("AdID"& Display_report)%>"> 
      <%=decode(Session("Adname"& Display_report))%></a></span></font> <%Session("Adname"& Display_report)=abandon
		%> </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"><%=(Session("Imp" & Display_report))%></span></font>	
    </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"><%=(Session("Click" & Display_report))%></span></font>	
    </td>
    <td align="center"> <font size=-1><span style="font-family: Arial;"> <%
		If Session("Imp" & Display_report)<>0 Then
			Response.Write FormatPercent(Session("Click" & Display_report)/Session("Imp" & Display_report),2)
		Else
		%> 0.00% <%End If%> </span></font> <%Session("Imp" & Display_report)=Abandon%> 
      <%Session("Click" & Display_report)=Abandon%> </td>
  </tr>
  <%Next%> 
</table>
<br>

<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->

</BODY>
</HTML>
<%Conn.Close%>
