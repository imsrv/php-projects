<%@ Language=VBScript %>
<%
Session.TimeOut=20
%>
<!--#Include File="../data_connection/DSN_Connection.asp"-->
<!--#include file="include/stats_AVG.asp"-->
<HTML>
<HEAD>
<title>Clicksee AdEngine - Admin Center</title>
<script language="JavaScript">
<!--
function MM_findObj(n, d) { //v3.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document); return x;
}

function MM_validateForm() { //v3.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (val!=''+num) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_findObj(n, d) { //v3.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document); return x;
}

function MM_validateForm() { //v3.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (val!=''+num) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<style type="text/css">
<!--
.Textlink {  font-family: Verdana, Arial; font-size: 10pt; color: #FFFFFF}
-->
</style>
</HEAD>

<BODY text="#000000" link="#0000FF" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
 
<!--#include file="include/logo.asp"--><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="504">
  <tr valign="top">
    <td>
<!-- BEGIN DETAIL -->
<p align="center"><font face="Arial" color="DDDDDD" size="+1">STATISTICS OF AVERAGE IMPRESSION BY LOCATION</font></p>


<form name="View_stats_avg" method="post" action="StatsAVG1.asp" >
  <table border="0" cellspacing="2" cellpadding="2" width="600" align=center>
    <% 'Check the error message
            if session("errMessage") <> "" then  
        %> 
    <tr> 
      <div align="center"><b><font color="#FFFFAA" face="Arial" size="-1"> <%
			Response.Write session("errMessage") 
			session("errMessage") = ""
		%> </font></b></div>
    </tr>
    <% end if %> 
    <tr> 
      <td> 
        <div align="right"><b><font color="#CCCCCC" face="Arial" size="-1">View 
          the stats of </font></b><b><font color="#CCCCCC" face="Arial" size="-1"> 
          </font></b></div>
      </td>
      <td><b><font color="#CCCCCC" face="Arial" size="-1">
        <select name="Location">
          <option value="">Select Location</option>
          <%
            TCLNo = Session("LNo")  
            For TC=1 to TCLNo
          %> 
          <option value="<%=Session("location_DB" & TC) %>"><%=Session("location_DB" & TC) %></option>
          <% next %> 
        </select>
        </font></b> <b><font color="#CCCCCC" face="Arial" size="-1"></font></b></td>
    </tr>
    <tr> 
      <td> 
        <div align="right"><b><font color="#CCCCCC" face="Arial" size="-1">in 
          the past </font></b> <b><font color="#CCCCCC" face="Arial" size="-1"> 
          </font></b></div>
      </td>
      <td><b><font color="#CCCCCC" face="Arial" size="-1"> 
        <input type="text" name="day" size="5" value="30" maxlength="3">
        days </font></b></td>
    </tr>
    <tr> 
      <td></td>
      <td width="50%"><b><font color="#CCCCCC" face="Arial" size="-1"> 
        <input type="submit" name="Submit" value="View" onClick="MM_validateForm('day','','RinRange1:999');return document.MM_returnValue">
        </font></b></td>
    </tr>
  </table>
  
</form>
<br>
<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->

</BODY>
</HTML>
<%Conn.Close%>
