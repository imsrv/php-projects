<%@ Language=VBScript %>
<%Session.TimeOut=20%>
<!--#Include File="../data_connection/DSN_Connection.asp"-->
<!--#include file="include/stats_AVG1.asp"-->
<HTML>
<HEAD>
<title>Clicksee AdEngine - Admin Center</title>
<style type="text/css">
<!--
.text {  font-family: Arial; font-size: 12pt; color: #DDDDDD}
.textlink {  font-family: Verdana, Arial; font-size: 10pt; color: #FFFFFF}
-->
</style>
</HEAD>

<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
 <!--#include file="include/logo.asp"--><br>
 <table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr valign="top">
    <td>
<!-- BEGIN DETAIL -->
<p align="center"><font face="Arial" color="CCCCCC" size="+1">STATISTICS OF AVERAGE IMPRESSION BY LOCATION</font></p>
<table align="center" width="400" bgcolor="#333333">
  <tr bgcolor="#CCCC99"> 
    <td colspan="4"><font face="Verdana" size="2"><%=Session("dayview")%> </font><font face="Verdana" size="2">Days 
      Average</font></td>
  </tr>
  <tr bgcolor="#333333"> 
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">Weight</font></b></font></div>
    </td>
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">No. 
        of AD</font></b></font></div>
    </td>
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">Impressions</font></b></font></div>
    </td>
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">Clicks</font></b></font></div>
    </td>
  </tr>
  <% 
    wc = session("wcount")
    for i=1 to wc 
  %> 
  <tr> 
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =session("adweight" & i)%></font></td>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =session("no_ad" & i)%></font></td>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =( (session("Imp" & i))/(session("no_ad" & i)) )%></font></td>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =( (session("Click" & i))/(session("no_ad" & i)) )%></font></td>
  </tr>
  <%
     Session("Imp" & i)=Abandon
     Session("Click" & i)=Abandon
	 Session("Imp" & i)=0
	 Session("Click" & i)=0
     next 
  %> 
</table>
<br>
  <% dayview = Session("dayview")
     for j=1 to dayview 
     wc = session("wcount")
     for i=1 to wc 
     if session("adofday" & j  & i) <> 0 then %>
<table align="center" width="400" bgcolor="#003366">
  <tr bgcolor="#CCCC99"> 
    <td colspan="4"><font face="Verdana" size="2"><%=Session("day" & j)%></font></td>
  </tr>
  <tr bgcolor="#333333"> 
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">Weight</font></b></font></div>
    </td>
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">No. 
        of AD</font></b></font></div>
    </td>
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">Impressions</font></b></font></div>
    </td>
    <td height="18"> 
      <div align="center"><font color="#FF9900" size="-2"><b><font face="Verdana">Clicks</font></b></font></div>
    </td>
  </tr>
   
  <tr>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =session("adweight" & i )%></font></td>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =session("adofday" & j  & i)%></font></td>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =( (session("d" &j& "Imp" & i))/(session("adofday" & j & i)) )%></font></td>
    <td bgcolor="#CCCCCC"><font color="#000000" face="Verdana" size="-1"><% =( (session("d" &j& "Click" & i))/(session("adofday" & j & i)) )%></font></td>
    
	<%
	 session("adofday" & j  & i) = 0
     session("d" &j& "Imp" & i) = abandon
     session("d" &j& "Click" & i) = abandon
	 session("d" &j& "Imp" & i) = 0
	 session("d" &j& "Click" & i) = 0
     %>
	 </tr>
	 </table>
     <br>
     <% End If 
	    next 
        next  
        Conn.Close
     %>   
<Center>
  <p><a href="statsAVG.asp" ><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK"></a></p>
  
  <p>&nbsp;</p>
</center>
<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>

