<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------

	IF Request.QueryString ("adid")=EMPTY THEN
		Response.Redirect "adcenter.asp"
	END IF
	
	'-------------------------------------------
	
	FUNCTION Print_CompanyName(ByVal adid)
	
	Dim companyRS
	Dim QUERY
	Dim functionConn
	Dim dateend
	Dim clickex
	Dim imp_purchased
	Dim dstatus
    Dim StartDate
    Dim SQL
    
	QUERY="SELECT c.companyname,c.customerid,p.campaignname,a.* FROM companies c, campaign p, ad_data a	"
	QUERY=QUERY&"WHERE a.adid="&adid&" "
	QUERY=QUERY&"AND a.customerid=c.customerid "
	
	SET functionConn=Server.CreateObject ("ADODB.connection")
	functionConn.Open DSNad,uid,pwd
	
	SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
	companyRS.Open QUERY,functionConn,1,3
	
	IF companyRS.EOF THEN
		companyRS.Close
		SQL="SELECT c.companyname,c.customerid,a.* FROM companies c, ad_data a "
		SQL=SQL&"WHERE a.adid="&adid&" "
		SQL=SQL&"AND a.customerid=c.customerid "
		
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		companyRS.Open SQL,functionConn,1,3
	END IF
	
	IF NOT companyRS.EOF THEN
		textmsg			=	 (companyRS("textmsg"))
		enddate		    =    (companyRS("Actualenddate"))
		dstatus			=	 (companyRS("status"))
		dateend			=	 (companyRS("dateend"))
		clickex			=	 (companyRS("clickexpire"))
		imp_purchased	=	 (companyRS("impressionspurchased"))
		StartDate       =    (companyRS("datestart"))
				
		IF dateend <> Empty  THEN
					  Hend = "Exp By Date"
					  Dend = Print_date(dateend)
		ELSEIF  clickex <> EMPTY AND clickex+0>0 THEN
					  Hend = "Exp By Click"
					  Dend = clickex
					
		ELSEIF imp_purchased <> EMPTY AND imp_purchased+0>0 THEN
					  Hend = "Exp By Imp"
					  Dend = imp_purchased
					
		ELSEIF dstatus = "Hold" AND dateend = EMPTY AND clickex+0 = 0 AND imp_purchased+0 = 0 THEN
					  Hend = "N/A"
					  Dend = "N/A"
		END IF
	
		PrintLn ("<table border=""0"" width=""95%"" cellspacing=""1"" cellpadding=""3"">")
		Println ("<tr>")
		PrintLn ("	<td colspan=""9"" align=""left"" bgcolor=""#CCCC99"">")
		PrintLn ("		<A HREF=""stats.asp?companycode="&companyRS("customerid")&""">")
		PrintLn ("		<font face=""Arial"" color=""#000000""><b>"&decode(companyRS("companyname"))&"</b></font>")
		PrintLn ("		</A>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		Println ("<tr>")
		PrintLn ("	<td colspan=""9"" align=""left"" bgcolor=""#006699"">")
		PrintLn ("		<b><font face=""Arial"" size=""2"" color=""#FFFFFF"">AD NAME&nbsp;:&nbsp;")
		PrintLn ("		"&decode(companyRS("adname"))&"")
		PrintLn ("		</font></b>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		PrintLn ("<tr>")
    	PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Status</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Location</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Weight</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Start Date</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">End Date</span></font></b></td>")
        PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">" & Hend & "</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Impressions</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Clicks</span></font></b></td>")
		PrintLn ("	<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Verdana;"">Click thru</span></font></b></td>")
		PrintLn ("</tr>")
		PrintLn ("<tr>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&decode(companyRS("status"))&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&decode(companyRS("target"))&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&companyRS("adweight")&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&Print_Date( StartDate )&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&Print_Date( enddate )&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&( Dend )&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&Print_stats (adid,"sum(impressions)")&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&Print_stats (adid,"sum(clicks)")&"&nbsp;</span></font></td>")
		PrintLn ("	<td bgcolor=""#CCCCCC"" align=""center""><font size=""-1"" color=""#333333""><span style=""font-family: Arial;"">"&percentclicksthru (Print_stats (adid,"sum(clicks)"),Print_stats (adid,"sum(impressions)"))&"</span></font></td>")
		PrintLn ("</tr>")
		PrintLn ("</table>")
		
		PrintLn ("<p>&nbsp;")
		'Image
		PrintLn ("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""600"" bgcolor=""#EEEEEE"">")
		PrintLn ("<tr>")
		PrintLn ("	<td align=""center"" bgcolor=""#666666"">")
		PrintLn ("		<font face=""Verdana, Arial"" size=""2"" color=""#CCCCCC""><b>IMAGE</b></font>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		PrintLn ("<tr>")
		PrintLn ("	<td valign=""top"">")
		PrintLn ("		<p align=""center"">")
		IF Trim(companyRS("imageURL")) <> EMPTY THEN
		PrintLn ("		  <IMG SRC="""&decode(companyRS("imageURL"))&""" alt="""&decode(companyRS("alt"))&""">")
		ELSE
		PrintLn ("		<font face=""Verdana, Arial"" size=""2"" color=""#000000"">(No image)</font>")
		END IF
		PrintLn ("		</p>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		PrintLn ("</table>")

		PrintLn ("<p>&nbsp;")
		
		'Text
		PrintLn ("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""600"" bgcolor=""#EEEEEE"">")
		PrintLn ("<tr>")
		PrintLn ("	<td align=""center"" bgcolor=""#666666"">")
		PrintLn ("		<font face=""Verdana, Arial"" size=""2"" color=""#CCCCCC""><b>TEXT</b></font>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		PrintLn ("<tr>")
		PrintLn ("	<td valign=""top"" align=""center""><font face=""Verdana, Arial"" size=""-1"" color=""#000000"">")
		IF Trim(textmsg)<>EMPTY THEN
			PrintLn (		decode(textmsg))
		ELSE
			PrintLn (		"(No text)")
		END IF
		PrintLn ("	</font></td>")
		PrintLn ("</tr>")
		PrintLn ("</table>")
		
		PrintLn ("<p>&nbsp;")
		
		'Link
		PrintLn ("<B><font face=""Arial"" size=""-1"" color=""#CCCCCC"">Link URL:</font></B>&nbsp;&nbsp;")
		PrintLn ("<a href="""&decode(companyRS("url"))&""" class=""link1"">"&decode(companyRS("url"))&"</a>")
		
	END IF
	companyRS.Close 
	functionConn.Close 
		
	END FUNCTION

	'-------------------------------------------
	
	FUNCTION Print_stats (byval adid,byval fieldname)

	Dim QUERY
	Dim functionConn
	
	QUERY="SELECT "&fieldname&" FROM [stats] "
	QUERY=QUERY&"WHERE adid="&adid
	
	SET functionConn=Server.CreateObject ("ADODB.connection")
	functionConn.Open DSNad,uid,pwd

	SET StatsRS=Server.CreateObject ("ADODB.Recordset")
	StatsRS.Open QUERY,functionConn,1,3
	
	IF NOT StatsRS.EOF THEN
		IF StatsRS(0)<>EMPTY THEN
			Print_stats=StatsRS(0)
		ELSE
			Response.Write "&nbsp;"
		END IF
	ELSE
		Response.Write "&nbsp;"
	END IF
	StatsRS.Close 
	functionConn.close
	
	END FUNCTION
	
	'-------------------------------------------

	FUNCTION statistics (ByVal x)
	
	Dim QUERY
	Dim functionConn
	Dim StatsRs
	Dim RowCount
	Dim ToTalRows
	Dim Pagesize
	Dim Today
	
	Today = month(date()) &"/"& day(date()) &"/"& year(date())
	RowCount=0
	
	SET functionConn=Server.CreateObject ("ADODB.connection")
	functionConn.Open DSNad,uid,pwd
	
	if x=0 then
	QUERY="SELECT * FROM [stats] "
	QUERY=QUERY&"WHERE adid="&Request.QueryString ("adid")&" and Datelog = '"&Today&"' " 
	QUERY=QUERY&"ORDER BY ID desc"
	
	elseif x=1 then
	QUERY="SELECT * FROM [stats] "
	QUERY=QUERY&"WHERE adid="&Request.QueryString ("adid")&" and Datelog <> '"&Today&"' " 
	QUERY=QUERY&"ORDER BY ID desc"
	end if
	
	Set StatsRs=Server.CreateObject ("ADODB.RecordSet")
	StatsRs.CursorType = adOpenstatic
	StatsRs.Open QUERY,functionConn,1,1
	
	If Request.form ("Page")=Empty Then	
		Pagesize=30
	ElseIf isnumeric(Request.Form ("Page")) Then
		If Request.Form ("Page")>0 Then
			Pagesize=Request.Form ("Page")
		Else
			Pagesize=30
		End If
	Else
		Pagesize=30
	End If
	ToTalRows=StatsRs.RecordCount
	StatsRs.PageSize=Pagesize
	TotalPage=StatsRs.PageCount
	If Not StatsRs.EOF Then
		StatsRs.Absolutepage=1
	End If
	
	
	IF x=0 and NOT statsRS.EOF then
	PrintLn("<tr>") 
    PrintLn("<td bgcolor=""#cccccc"" align=""center"">")
	PrintLn("  <font face=""Verdana,Arial"" size=""2""><b>Date</b></font></td>")
	PrintLn("     <td bgcolor=""#cccccc"" align=""center""> ")
	PrintLn("<font face=""Verdana,Arial"" size=""2""><b>Impressions</b></font></td>")
    PrintLn(" <td bgcolor=""#cccccc"" align=""center"">")
	PrintLn("<font face=""Verdana,Arial"" size=""2""><b>Clicks</b></font></td>")
    PrintLn(" <td bgcolor=""#cccccc"" align=""center"">")
	PrintLn("<font face=""Verdana,Arial"" size=""2""><b>Percentage</b></font></td>")
    PrintLn(" </tr> ")
	End if
	
	
	
	DO While NOT statsRS.EOF And RowCount<=Pagesize-1
	
	PrintLn ("<tr>")
	Println ("	<td bgcolor=""#EEEEEE"" align=""center"">")
	PrintLn ("		<tt>"&StatsRs("Datelog")&"</tt>")
	PrintLn ("	</td>")
	PrintLn ("	<td bgcolor=""#EEEEEE"" align=""center"">")
	PrintLn ("		<tt>"&StatsRs("Impressions")&"</tt>")
	PrintLn ("	</td>")
	PrintLn ("	<td bgcolor=""#EEEEEE"" align=""center"">")
	PrintLn ("		<tt>"&StatsRs("Clicks")&"</tt>")
	Println ("	</td>")
	PrintLn ("	<td bgcolor=""#EEEEEE"" align=""center"">")
	PrintLn ("		<tt>"&percentclicksthru (StatsRs("Clicks"),StatsRs("Impressions"))&"</tt>")
	PrintLn ("	</td>")
	PrintLn ("</tr>")

	RowCount=RowCount+1
	StatsRs.MoveNext 
	Loop

	END FUNCTION

	'-------------------------------------------
	
	FUNCTION percentclicksthru (ByVal clicks,ByVal impressions)
		IF clicks>0 AND Impressions>0 THEN
			percentclicksthru=Formatpercent(clicks/impressions,2)
		ELSE
			percentclicksthru=0
		END IF
	END FUNCTION 

</SCRIPT>
