<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------

	SUB HPrintForm(ByVal CompanyName,ByVal companyID)

		PrintLn ("<table border=""0"" width=""95%"" cellspacing=""0"" cellpadding=""2"" align=""center"">")
		PrintLn ("<tr>")
		PrintLn ("	<td colspan=""13"" bgcolor=""#CCCC99"">")
		PrintLn ("		<b><font face=""Arial"" color=""#000000"">&nbsp;")
		PrintLn (decode(CompanyName))
		PrintLn ("		</font></b>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		PrintLn ("<tr>")
		PrintLn ("	<td colspan=""13"">")
		PrintLn ("		<a href=""javascript:new_window('glossary.asp#com_mngt')""><img src=""../IMAGES2/queswork.GIF"" width=""11"" height=""12"" border=""0"" alt=""Company Management"" align=""right""></a>")
		PrintLn ("		<A HREF=""editcompany.asp?customerid=" & companyid & "&" & VarBACK & """ class=""link1""><font face=""Arial"" size=""-2"">EDIT</font></a>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<A HREF=""delcompany.asp?customerid=" & companyid & "&" & VarBACK & """ class=""link1""><font face=""Arial"" size=""-2"">DELETE</font></A>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<A HREF=""campaign.asp?customerid=" & companyid & "&" & VarBACK & """ class=""link1""><font face=""Arial"" size=""-2"">ADD NEW CAMPAIGN</font></a>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<A HREF=""note.asp?customerid=" & companyid & "&" & VarBACK & """ class=""link1""><font face=""Arial"" size=""-2"">NOTE</font></a>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<A HREF=""ads.asp?campaignid=0&customerid=" & companyid & "&" & VarBACK & """ class=""link1""><font face=""Arial"" size=""-2"">ADD NEW AD</font></a>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<A HREF=""editreport.asp?customerid=" & companyid & "&" & VarBACK & """ class=""link1""><font face=""Arial"" size=""-2"">E-MAIL REPORT</font></a>")
		PrintLn ("	</td>")
		PrintLn ("</tr>")
		PrintLn ("</table>")
		PrintLn ("<br>")

	END SUB
	
	'-------------------------------------------Print Campaign-------------------------------------------
	

	SUB CPrintForm (ByVal campaignname,ByVal campaignid,ByVal companyID)

		IF campaignname<>EMPTY AND campaignid<>EMPTY AND companyID<>EMPTY THEN
		PrintLn ("<table border=""1"" width=""90%"" cellpadding=""5"" cellspacing=""0"" align=""center"">")
		PrintLn ("  <tr>")
		PrintLn ("	  <td>")
		PrintLn (" 		<table width=""100%"" cellpadding=""2"" cellspacing=""0"" align=""center"">")
		PrintLn ("		  <tr>")
		PrintLn ("			<td colspan=""9"" bgcolor=""#0066CC"" valign=""top"">")
		PrintLn ("			  <font face=""Arial"" color=""#FFFFFF"" size=""-1""><span style=""font-family: Arial;""><b>CAMPAIGN:</b></span></font>")
		PrintLn ("				<AHREF=""editcampaign.asp?campaignid=" & campaignid & "&" & VarBACK & """><font face=""Arial"" color=""#FFCC00"" size=""-1""><span style=""font-family: Arial;""><b>" & decode(campaignname) & "</b></span></font></a>")
		PrintLn ("			</td>")
		PrintLn ("		  </tr>")
		PrintLn ("		  <tr>")
		PrintLn ("	  	    <td colspan=""9"">")
		PrintLn ("			  <a href=""javascript:new_window('glossary.asp#cam_mngt')""><img src=""../IMAGES2/queswork.GIF"" width=""11"" height=""12"" border=""0"" alt=""Campaign Management"" align=""right""></a>")
		PrintLn ("				<A HREF=""editcampaign.asp?campaignid=" & campaignid & "&" & VarBACK & """><font face=""Arial"" color=""#FFCC33"" size=""-2""><span style=""font-family: Arial;"">EDIT</span></font></a>")
		PrintLn ("				&nbsp;/&nbsp;")
		PrintLn ("				<A HREF=""clonecampaign.asp?campaignid=" & campaignid & "&" & VarBACK & """><font face=""Arial"" color=""#FFCC33"" size=""-2""><span style=""font-family: Arial;"">CLONE</span></font></A>")
		PrintLn ("				&nbsp;/&nbsp;")
		PrintLn ("				<A HREF=""delcampaign.asp?campaignid=" & campaignid & "&" & VarBACK & """><font face=""Arial"" color=""#FFCC33"" size=""-2""><span style=""font-family: Arial;"">DELETE</span></font></A>")
		PrintLn ("				&nbsp;/&nbsp;")
		PrintLn ("				<A HREF=""ads.asp?customerid="&companyID&"&campaignid=" & campaignid & "&" & VarBACK & """><font face=""Arial"" color=""#FFCC33"" size=""-2""><span style=""font-family: Arial;"">ADD NEW AD TO CAMPAIGN</span></font></A>")
		PrintLn ("			</td>")
		PrintLn ("		  </tr>")
		PrintLn ("	    </table>")
		PrintLn (" 	  </td>")
		PrintLn ("  </tr>")
		PrintLn ("  <tr>")
		PrintLn ("    <td>")
		PrintLn ("		<br>")

		END IF

	END SUB
	
	SUB LCPrintForm
		PrintLn ("</td>")
		PrintLn ("</tr>")
		PrintLn ("</table>")	
	END SUB

	'-------------------------------------------
	
	SUB WOPrintForm
	
		PrintLn ("<table border=""1"" width=""90%"" cellpadding=""5"" cellspacing=""0"" align=""center"">")
		PrintLn ("  <tr>")
		PrintLn ("	  <td>")
		PrintLn (" 		<table width=""100%"" cellpadding=""2"" cellspacing=""0"" align=""center"">")
		PrintLn ("		  <tr>")
		PrintLn ("			<td colspan=""9"" bgcolor=""#0066CC"" valign=""top"">")
		PrintLn ("			  <font face=""Arial"" color=""#FFFFFF"" size=""-1""><span style=""font-family: Arial;""><b>CAMPAIGN:</b></span></font>")
		PrintLn ("			  <font face=""Arial"" color=""#FFCC00"" size=""-1""><span style=""font-family: Arial;""><b>N/A</b></span></font>")
		PrintLn ("			</td>")
		PrintLn ("		  </tr>")
		PrintLn ("	    </table>")
		PrintLn (" 	  </td>")
		PrintLn ("  </tr>")
		PrintLn ("  <tr>")
		PrintLn ("    <td>")
		PrintLn ("		<br>")

	END SUB

	'-------------------------------------------
	
	SUB MPrintForm (ByVal adname, ByVal adid, ByVal Status, ByVal location, ByVal Weight, ByVal datestart, ByVal enddate, ByVal Hend, ByVal Dend, ByVal impression, ByVal clicks, ByVal clickthru, ByRef ColorSet)

		Dim ColorScreen
		
		IF ColorSet THEN
			ColorScreen="CCCCCC"
		ELSE
			ColorScreen="CCCCCC"
		END IF
		PrintLn ("<table border=""0"" cellspacing=""0"" cellpadding=""2"" align=""center"" width=""100%"">")
		'Print AD NAME
		PrintLn ("  <tr>")
		PrintLn("	  <td bgcolor=""#006699"" colspan=""9"">")
		PrintLn ("		<a href=""javascript:new_window('glossary.asp#viewads')""><img src=""../IMAGES2/queswork.GIF"" width=""11"" height=""12"" border=""0"" alt=""View Advertisement Profile"" align=""right""></a>")
		PrintLn ("		<b><font face=""Arial"" size=""2""><font color=""#FFFFFF"">AD NAME:</font></b>")
		PrintLn ("		<b><font face=""Arial"" size=""-1"" color=""#FFCC00""><A HREF=""stats_detail.asp?adid=" & adid & "&" & VarBACK & """ class=""link2"">" & decode(AdName) & "</a></font></b>")
		PrintLn("	  </td>")
		PrintLn ("	</tr>")
		'END Print AD NAME		

		'Print FUNCTION
		PrintLn ("	<tr>")
		PrintLn("	  <td colspan=""9"">")
		PrintLn ("		<a href=""javascript:new_window('glossary.asp#ad_mngt')""><img src=""../IMAGES2/queswork.GIF"" width=""11"" height=""12"" border=""0"" alt=""Advertisement Management"" align=""right""></a>")
		PrintLn ("		<font face=""Arial"" size=""1"" ><A HREF=""editad.asp?adid=" & adid & "&" & VarBACK & """ class=""link1"">EDIT</a></font>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<font face=""Arial"" size=""1""><A HREF=""delad.asp?adid=" & adid  & "&" & VarBACK & """ class=""link1"">DELETE</a></font>")
		PrintLn ("		&nbsp;<font color=""#FFFFFF"">/</font>&nbsp;")
		PrintLn ("		<font face=""Arial"" size=""1""><A HREF=""cloneads.asp?adid=" & adid & "&" & VarBACK & """ class=""link1"">CLONE</a></font>")
		PrintLn("	  </td>")
		PrintLn ("	</tr>")
		'END Prind FUNCTION
		
		'Print HEAD
		PrintLn ("	<tr>")
		PrintLn ("    <td>")
		PrintLn ("		<table width=""100%"" border=""0"" cellspacing=""1"">")
		PrintLn ("		  <tr>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Status</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Location</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Weight</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Start Date</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">End Date</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">" & Hend & "</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Impressions</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Clicks</span></font></b></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#333333""><b><font size=""-1"" color=""FF9900""><span style=""font-family: Arial;"">Click thru</span></font></b></td>")
		PrintLn ("  	  </tr>")
		'End Print HEAD

		' Print AD DETAIL
		PrintLn ("  	  <tr>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & decode(Status) & "&nbsp;</span></font></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & decode(location) & "&nbsp;</span></font></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & weight & "&nbsp;</span></font></td>")
		Response.Write ("	<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & Print_Date (datestart) & "&nbsp;</span></font></td>")
		Response.Write ("	<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & Print_Date (enddate) & "&nbsp;</span></font></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & Dend & "&nbsp;</span></font></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">&nbsp;" & impression & "&nbsp;</span></font></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">&nbsp;" & clicks & "&nbsp;</span></font></td>")
		PrintLn ("	  		<td valign=""top"" align=""center"" bgcolor=""#CCCCCC""><font size=""-1""><span style=""font-family: Arial;"">" & clickthru & "&nbsp;</span></font></td>")
		PrintLn ("		  </tr>")
		PrintLn ("		</table>")		
		PrintLn ("	  </td>")
		PrintLn ("	</tr>")
		PrintLn ("</table>")
		PrintLn ("<br>")
		'END Print AD DETAIL
	END SUB
	
	'-------------------------------------------
	
	SUB LPrintForm 
	
		PrintLn ("</td>")
		PrintLn ("</tr>")
		PrintLn ("</Table>")
		PrintLn ("<br>")
	
	END SUB
	
	'-------------------------------------------
	
	FUNCTION Vfield (ByVal str)
	
		IF str<>EMPTY THEN
			Vfield=decode(str)
		ELSE
			Vfield="&nbsp;"
		END IF	
		
	END FUNCTION
	
	'-------------------------------------------
	
	FUNCTION Sumimp (ByVal num)
		
		Dim FUNCTIONConn
		
		IF isnumeric(num) THEN
			
			SET FUNCTIONConn=Server.CreateObject ("ADODB.Connection")
			FUNCTIONConn.Open DSNad,uid,pwd
			
			QUERY="SELECT SUM(impressions) FROM stats "	&_
							  "WHERE adid=" & num
		
			SET RS=Server.CreateObject ("ADODB.Recordset")
			RS.Open QUERY,FUNCTIONConn,1,3
		
			IF RS.EOF THEN
				Sumimp=0
			ELSE
				Sumimp=RS(0)
			END IF
			
			RS.Close
			FUNCTIONConn.Close
			
		END IF	
		
	END FUNCTION

	'-------------------------------------------
	
	FUNCTION Sumclick (ByVal num)
	
		Dim FUNCTIONConn
		
		IF isnumeric(num) THEN
		
			SET FUNCTIONConn=Server.CreateObject ("ADODB.Connection")
			FUNCTIONConn.Open DSNad,uid,pwd

			QUERY="SELECT SUM(clicks) FROM stats "	&_
							  "WHERE adid=" & num
		
			SET RS=Server.CreateObject ("ADODB.Recordset")
			RS.Open QUERY,FUNCTIONConn,1,3
		
			IF RS.EOF THEN
				Sumclick=0
			ELSE
				Sumclick=RS(0)
			END IF
			
			RS.Close
			FUNCTIONConn.Close
			
		END IF
	
		
	END FUNCTION
	
	'-------------------------------------------

</SCRIPT>
