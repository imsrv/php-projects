<%@ Language=VBScript %>
<!--#Include File="include/Cadmin.asp"-->
<%
Set Rs=Conn.Execute ("Select * From Companies Where CustomerID=(" & Request.QueryString ("ID")+0 & ")")
If Not Rs.EOF Then
%>
<HTML>
<HEAD>
<title>View all ads | ADNOW Ad Center (Customer Section)</title>
<style type="text/css">
.link1 {color: #FF6600; text-decoration: underline;}
</style>
</HEAD>
<body background="../images2/bg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#FF6600" bottommargin="0" rightmargin="0">
<!-- LOGO -->
<!--#include file="include/c_logo.inc"-->
<br>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" height="450">
  <TR VALIGN="TOP">
	<TD ALIGN="CENTER" height="57"> 
      <p><font face="Arial, helvetica" size="2" color="#CCCCCC">
              Click on the hyperlink under &quot;Ad Name&quot; to view the detail 
              statistics of each ad.</font> <br><p>
      <TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="85%" bgcolor="#666666">
        <tr> 
          <td align="LEFT" width="44%"> <b><font face="arial, helvetica" color="#FFCC00">&nbsp;&nbsp;&nbsp;<%=decode(Rs("CompanyName"))%></font></b> 
            <% 
		       Ntemp=decode(Rs("Notes"))
		       Rs.Close  
		    %> 
		  </td>
          <td colspan="7" align="LEFT"> 
			  <div align="right"><font face="Arial, helvetica" size="-2" color="#CCCCCC">
			  &nbsp;&nbsp;&#187;&nbsp;<A HREF="C_Prof.asp?ID=<%=Request.QueryString ("ID")%>" class="link1">PROFILE</a>
			  &nbsp;&nbsp;&#187;&nbsp;<A HREF="C_change.asp?ID=<%=Request.QueryString ("ID")%>" class="link1">CHANGE PASSWORD</a>
			  &nbsp;&nbsp;&#187;&nbsp;<a href="C_logout.asp" class="link1">LOG OUT</a>
			  </font></div>
          </td>
        </tr>
      </TABLE>
	</TD>
  </TR>
  <TR VALIGN="TOP">
	<TD ALIGN="CENTER">
	  <TABLE BORDER="0" CELLSPACING="1" CELLPADDING="2" WIDTH="85%">
		<%  
			Set Rs=Conn.Execute ("Select * From Ad_data Where CustomerID=(" & Request.QueryString ("ID")+0 & ") ")
			
			Do While Not Rs.EOF
				If Not Rs.EOF Then
					Set StatsRs=Server.CreateObject ("ADODB.RecordSet")
					StatsRs.CursorType = adOpendynamic 
					Set StatsRs=Conn.Execute ("Select Impressions,Clicks From Stats Where AdID=(" & Rs("AdID")+0 & ")")
					SumIm=0
					SumC=0
					Do While Not StatsRs.EOF
						SumIm=SumIm+StatsRs("Impressions")
						SumC=SumC+StatsRs("Clicks")
						StatsRs.MoveNext
					Loop
		
		     Ad_ID = Rs("AdID") 
		     
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
		<tr>
		  <td colspan="9">&nbsp;</td>
		</TR>
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
		  <td BGCOLOR="#EEEEEE" align="center"><A HREF="C_ad.asp?ID=<%=Request.QueryString ("ID")%>&adID=<%=Ad_ID%>" class="link1"><font size=-1><span style="font-family: Arial;"><%=decode(Rs("AdName"))%></span></font></A></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write decode(Rs("Status"))%></span></font></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write decode(Rs("target"))%></span></font></td>	
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write Print_Date(Rs("DateStart"))%></span></font></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write Print_Date(Rs("Actualenddate"))%>&nbsp;</span></font></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%=ExpV%>&nbsp;</span></font></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write SumIm%></span></font></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%Response.Write SumC%></span></font></td>
		  <td BGCOLOR="#EEEEEE" align="center"><font size=-1><span style="font-family: Arial;"><%If SumIm<>Empty And SumIm<>0 Then Response.Write Round(((SumC/SumIm)*100),2) Else Response.Write "0" End If%>%</span></font></td>
		</tr>
		<%
				End If
				Rs.MoveNext
			    Loop
		
		   End If
		   '--------
		   Rs.close
		%>
	  </TABLE>
	</TD>
  </TR>
	<%  Conn.close %> 
  <TR>
	<TD ALIGN="CENTER" VALIGN="TOP">
      <TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="85%">
        <TR> 
          <TD> 
              <%if Ntemp <> "" and Ntemp <> "null" then %>
            <p><font face="Arial, Helvetica" size="2" color="#FFCC00"><b>Notes:</b></font> <br>
              <font face="Arial, helvetica" size="2"><b><font color="#FFCC00">&#187;</font></b></font> 
              <font size=-1 color="#CCCCCC"><span style="font-family: Arial;">
              <% Response.Write Ntemp %>
              </span></font> 
            </p>
			<% End If %>
          </TD>
        </TR>
      </TABLE>
	</TD>
  </TR>
</TABLE>
<p>&nbsp;</p>
<!--#include file="../admanager/include/bottom.html"-->
</body>
</html>


