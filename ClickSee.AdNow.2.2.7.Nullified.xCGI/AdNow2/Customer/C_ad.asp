<%@ Language=VBScript %>
<!--#Include File="include/Cadmin.asp"-->
<%
'Page size
Pagesize=30
%>
<HTML>
<HEAD>
  <title>VIEW ADVERTISING DETAIL</title>
<style type="text/css">
.link1 {color: #FF6600; text-decoration: underline;}
</style>
</HEAD>
<body background="../images2/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#ff6600" bottommargin="0" rightmargin="0">

	<%
	Query="Select * From Ad_Data " &_
		  "Where AdID=" & Request.QueryString ("adID")+0
		  Set RS=Conn.Execute (Query)
		  
	If Not RS.EOF Then 
		Textmsg=(RS("Textmsg"))
			
				
		Query="Select CompanyName,CustomerID From Companies " &_
			  "Where CustomerID=" & RS("CustomerID")
			  Set ComName=Conn.execute(Query)
		
		Set StatsRs=Server.CreateObject ("ADODB.RecordSet")
		StatsRs.CursorType = adOpendynamic 
		
		Query="Select Impressions,Clicks From Stats " &_
			  "Where AdID=" & Rs("AdID")
			  Set StatsRs=Conn.Execute (Query)
		
		SumIm=0
		SumC=0
		Do While Not StatsRs.EOF
			SumIm=SumIm+StatsRs("Impressions")
			SumC=SumC+StatsRs("Clicks")
			StatsRs.MoveNext
		Loop

		IF Rs("ImpressionsPurchased")<>EMPTY AND Rs("ImpressionsPurchased")>0 THEN
		   ExpW="Imp"
		   ExpV=Rs("ImpressionsPurchased")
		ELSEIF Rs("DateEnd")<>EMPTY AND Rs("DateEnd")>0 THEN
		   ExpW="Date"
		   ExpV=Print_Date(Rs("DateEnd"))
		ELSEIF RS("Clickexpire")<>EMPTY AND Rs("Clickexpire")>0 THEN
		   ExpW="Click"
		   ExpV=Rs("Clickexpire")
		END IF
	%>
<!-- LOGO -->
<!--#include file="include/c_logo.inc"-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><br><td ALIGN="CENTER"><font face="Arial,helvetica" color="#FFFFFF" size="1"><b>&#149;&nbsp;VIEW SINGLE AD</b></font></td></tr>
	<!-- END 1ST ROW -->
			
	<!-- SPACER -->
	<tr>
		<td valign="top" width="100%" ALIGN="CENTER"><img src="../images2/spacer.gif" height="10" border="0"></td>
	</tr>
			
	<tr>
		<td width="100%" ALIGN="CENTER" VALIGN="TOP">
			<p>&nbsp;
            <div align="center">
            
			<table border="0" cellspacing="0" cellpadding="0" WIDTH="90%">
			  <tr> 
			    <td colspan="8" align="LEFT" bgcolor="#666666"> <%If Not ComName.EOF Then%> 
			      <b><font face="Verdana, Arial" color="#FFCC00">&nbsp;&nbsp;&nbsp;<%=decode(ComName("CompanyName"))%></font></b><%End IF%> 
			    </td>
			    <td align="LEFT" bgcolor="#666666"> 
		  <div align="right"><font face="Arial, helvetica" size="-2" color="#CCCCCC">
		  &nbsp;&nbsp;&#187;&nbsp;<A HREF="C_Prof.asp?ID=<%=Request.QueryString ("ID")%>" class="link1">PROFILE</a>
		  &nbsp;&nbsp;&#187;&nbsp;<A HREF="C_change.asp?ID=<%=Request.QueryString ("ID")%>" class="link1">CHANGE PASSWORD</a>
		  &nbsp;&nbsp;&#187;&nbsp;<a href="C_logout.asp" class="link1">LOG OUT</a>
		  </font></div>
			    </td>
			  </tr>
			</table>
			
	      <table border="0" cellspacing="1" cellpadding="3" WIDTH="90%">
          <tr> 
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Ad Name</span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Status</span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Location</span></font></b></td>	
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Date Start</span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">End Date</span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Exp By <%=ExpW%></span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Impressions</span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Clicks</span></font></b></td>
			<td bgcolor="#333333" align="center"><b><font size=-1 color="#FF9900"><span style="font-family: Arial;">Click thru</span></font></b></td>
          </tr>
          <tr> 
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%=decode(Rs("AdName"))%></span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write decode(Rs("Status"))%></span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write decode(Rs("target"))%></span></font></td>	
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write Print_Date(Rs("DateStart"))%></span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write Print_Date(Rs("Actualenddate"))%>&nbsp;</span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%=ExpV%>&nbsp;</span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write SumIm%></span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write SumC%></span></font></td>
			<td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%If SumIm<>Empty And SumIm<>0 Then Response.Write Round(((SumC/SumIm)*100),2) Else Response.Write "0" End If%>%</span></font></td>
          </tr>
		  </table>

<!-- Image -->
<p>&nbsp;
<table width="600" border="0" cellpadding="3" cellspacing="0" bgcolor="#EEEEEE">
<tr>
	<td align="center" bgcolor="#666666">
		<font face="Verdana, Arial" size="2" color="#CCCCCC">
		<b>IMAGE</b></font>
	</td>
</tr>
<tr>
	<td valign="top">
		<%If trim(RS("ImageURL"))<>Empty Then%>
		<p align="center"><IMG SRC="<%=decode(RS("ImageURL"))%>" alt="<%If trim(RS("Alt"))<> EMpty Then Response.Write decode(RS("Alt")) Else Response.Write "HostSearch Direct" End If%>"></p>
		<%ELSE%>&nbsp;
		<%End If%>
	</td>
</tr>
</table>

<br>

<!-- Text -->
<%If trim(Textmsg)<>Empty Then%>
<table width="600" border="0" cellpadding="3" cellspacing="0" bgcolor="#EEEEEE">
<tr>
	<td align="center" bgcolor="#666666">
		<font face="Verdana, Arial" size="2" color="#CCCCCC">
		<b>TEXT</b></font>
	</td>
</tr>
<tr>
	<td valign="top">
		<font face="Verdana, Arial" size="2"><%Response.Write decode(Textmsg)%></font>
	</td>
</tr>
</table>
<%End IF%>

<% ' Variable "Lurl" stores URL value %>
<% Lurl= decode(RS("URL")) %>

<p><B><font face="Arial" size="-1" color="#FFCC00">LINK URL:</font></B>&nbsp;&nbsp;<a href="<%Response.Write Lurl%>" class="link1"><%Response.Write Lurl%></a>
</div>

<br>
<div align="center"><center>

<%
	TotalIMP=0
	Totalday=0
	TotalClick=0
	TotalPercent=0
	StatsRs.Close
	Set StatsRs=Server.CreateObject ("ADODB.RecordSet")
	StatsRs.CursorType = adOpenstatic
	Sql="Select * From Stats Where AdID=" & Request.QueryString ("adID")+0 & " Order by ID Desc"
	StatsRs.Open sql,Conn,1,1

	If Request.form ("Page")=Empty Then	
		Pagesize=30
	ElseIf isnumeric(Request.Form ("Page")) Then
		If Request.Form ("Page")>0 Then
			Pagesize=Request.Form ("Page")
		Else
			'Page size
			Pagesize=30
		End If
	Else
		'Page size
		Pagesize=30
	End If
	ToTalRows=StatsRs.RecordCount
	StatsRs.PageSize=Pagesize
	TotalPage=StatsRs.PageCount
	If Not StatsRs.EOF Then
		StatsRs.Absolutepage=1
	End If
%>
<hr size="1" width="600">

<!--Page On-->
<FORM action="<%=Request.ServerVariables ("Path_info")%>?ID=<%=Request.QueryString ("ID")%>&adID=<%=Request.QueryString ("adID")%>" method=POST id=form1 name=form1>
<p>
<b>
<font size="-1" color="#FFCC00"><span style="font-family: Arial;">View the stats in the past &nbsp;<INPUT type="text" id=text1 name="Page" size="5">&nbsp;days &nbsp;</span></font>
</b>
<INPUT type="submit" value="View" id=submit1 name=submit1>
</FORM>

<font size="-1" color="#FFCC00"><span style="font-family: Arial;">By default, you will see the past 30 day statistics.</span></font>

<table border="0" cellspacing="1" cellpadding="5" width="500">
  <tr>
    <td align="center" bgcolor="#cccccc"><b><font size="2" color="#000000"><span style="font-family: Arial;">Date</span></font></b></td>
    <td align="center" bgcolor="#cccccc"><b><font size="2" color="#000000"><span style="font-family: Arial;">Impressions</span></font></b></td>
    <td align="center" bgcolor="#cccccc"><b><font size="2" color="#000000"><span style="font-family: Arial;">Clicks</span></font></b></td>
    <td align="center" bgcolor="#cccccc"><b><font size="2" color="#000000"><span style="font-family: Arial;">Percentage</span></font></b></td>
  </tr>
<%
	Do While Not StatsRs.EOF And RowCount<=Pagesize-1
%>
<tr>
	<td bgcolor="#FFFFFF" align="center"><tt><%Response.Write StatsRs("Datelog")%></tt></td>
	<td bgcolor="#FFFFFF" align="center"><tt><%Response.Write StatsRs("Impressions")%></tt></td>
	<td bgcolor="#FFFFFF" align="center"><tt><%Response.Write StatsRs("Clicks")%></tt></td>
	<td bgcolor="#FFFFFF" align="center"><tt><%If StatsRs("Impressions")<>Empty And StatsRs("Impressions")<>0 Then Response.Write Round(((StatsRs("Clicks")/StatsRs("Impressions"))*100),2) Else Response.Write "0" End If%> %</tt></td>	
</tr>
<%
		RowCount=RowCount+1
		StatsRs.MoveNext 
	Loop
	StatsRs.Close
	
%>
</table>
<%End If%>
		<p><% CID = RS("CustomerID")  %>
		<div ALIGN="CENTER"> <A HREF="C_center.asp?id=<%=CID%>" class="link1"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO MAIN PAGE"></A></DIV>
		<br>
		<%'------Close conn object----------
		  Conn.close
		%>
		<br>
		</DIV>
		
		</td>	
	</tr>
	</table>
<p>&nbsp;</p>
<!--#include file="../admanager/include/bottom.html"-->

</body>
</html>
