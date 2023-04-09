<% 

Dim TopNavLinks, i

response.expires = 0
	
	Dim ver
	ver = "1.2" ' DO NOT MODIFY - Used to check for updates

	Dim NewsletterDate
	NewsletterDate = formatdatetime((now),vblongdate)

Sub ShowHeader()

	With Response
		.write "<table border='0' width='100%' cellspacing='0' cellpadding='0'>"
		.write "<tr>"
		.write "<td width='18%' align='center' bgcolor='#900D1A'><img src='" & Path2Admin & "/images/dellogo.gif'>"
		.write "<br></td>"
		.write "<td width='1' bgcolor='#900D1A'><img src='' width='1'></td>"
		.write "<td width='82%' bgcolor='#002C22'>"
		
		.write "<table width='100%' cellpadding='0' cellspacing='0'>"
		.write "<tr><td><img src='" & Path2Admin & "/images/dellogo2.gif'></td>"
		.write "<td align='right'>"
		if Session("FullName") <> "" then .write "<font class='username'>Welcome " & Session("FullName") & "</font>&nbsp;&nbsp;&nbsp;&nbsp;"
		.write "</td></tr></table>"
		
		.write "</td>"
		.write "</tr>"
		.write "<tr><td colspan='3' bgcolor='#003366'></td></tr>"
		.write "<tr><td colspan='3' bgcolor='#FFB6C3'></td></tr>"
		.write "<tr><td colspan='3' bgcolor='#BD0021'></td></tr>"
		.write "<tr><td colspan='3' bgcolor='#97001A'></td></tr>"	
		.write "<tr><td colspan='3' bgcolor='#003366'></td></tr>"
		.write "</table>"		
	End With

End Sub

Sub ShowFooter()

	With Response
	
		.write "<table width='90%' align='center' cellspacing='0' cellpadding='8' Border='0'>"		
		.write "<tr><td align='center'>"
		.write "<font class='general_small_text'>"
		.write "Copyright © 1999-2002 deloittes.NET Limited - (http://www.deloittes.net) . All Rights Reserved."
		.write "</td></tr></table><br><br>"
	
	End With

End Sub

Function ReturnNumberOfSites(PubStatus)
	
	Dim ConnObj, TheSet, NumOfSites

	SQL = "SELECT id FROM del_Directory_Sites WHERE PublishOnWeb = " & PubStatus		
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
		NumOfSites = 0
	else
		NumOfSites = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnNumberOfSites = NumOfSites
	
End Function

Function ReturnNumberOfErrors()

	Dim ConnObj, TheSet, NumberOfErrors

	SQL = "SELECT id FROM del_Directory_Errors"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
	NumberOfErrors = 0
	else
	NumberOfErrors = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnNumberOfErrors = NumberOfErrors
	
End Function

Function ReturnNumberForMailingList()

	Dim ConnObj, TheSet, NumberForMailingList

	SQL = "SELECT id FROM del_Directory_NewsletterList"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
		NumberForMailingList = 0
	else
		NumberForMailingList = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnNumberForMailingList = NumberForMailingList
	
End Function

Function ReturnNumberOfCategories(AllowStatus)

	Dim ConnObj, TheSet, NumberOfCategories
	
	SQL = "SELECT id FROM del_Directory_Categories WHERE AllowLinks = " & AllowStatus 
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
		NumberOfCategories = 0
	else
		NumberOfCategories = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnNumberOfCategories = NumberOfCategories
	
End Function

Function ReturnNumberOfReviews(PubStatus)

	Dim ConnObj, TheSet, NumberOfReviews

	SQL = "SELECT id FROM del_Directory_Reviews WHERE PublishOnWeb = " & PubStatus
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
		NumberOfReviews = 0
	else
		NumberOfReviews = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnNumberOfReviews = NumberOfReviews
	
End Function

Function LinkToCategoryRatio()

		if DatabaseType = "Access" then 
		
			if ReturnNumberOfSites(True) > 0 and ReturnNumberOfCategories(True) > 0 then	
				LinkToCategoryRatio = FormatNumber(ReturnNumberOfSites(True) / ReturnNumberOfCategories(True),0,0) & ":1"
			else
				LinkToCategoryRatio = "0:0"
			end if
			
		else
		
			if ReturnNumberOfSites(1) > 0 and ReturnNumberOfCategories(1) > 0 then	
				LinkToCategoryRatio = FormatNumber(ReturnNumberOfSites(1) / ReturnNumberOfCategories(1),0,0) & ":1"
			else
				LinkToCategoryRatio = "0:0"
			end if
			
		end if	

			
End Function

Function CheckString(strInput)
	Dim strTemp
	strTemp = Replace(strInput, "'", "''")
	strTemp = Replace(strTemp, vbcrlf, "")
	CheckString = strTemp
End Function

Function NewIcon(Updated)
	
	Dim daysOld	
	if Updated <> "" then	
		DaysOld = DateDiff("d", formatdatetime(now(),2), formatdatetime(Updated,2))
		DaysOld = trim(replace(DaysOld,"-","",1))	
		if DaysOld >= 0 and DaysOld <= 4 then
			NewIcon = "<img src='" & Path2Directory & "images/new1.gif' align='absbottom'>" 
		elseif DaysOld > 4 AND DaysOld <= 8 then
			NewIcon = "<img src='" & Path2Directory & "images/new2.gif' align='absbottom'>" 
		elseif DaysOld > 8 AND DaysOld <= 12 then
			NewIcon = "<img src='" & Path2Directory & "images/new3.gif' align='absbottom'>" 
		end if		
	end if

End Function

Function GrabDomainFromEmail(Email)

	if Email <> "" then
	GrabDomainFromEmail = right(Email,len(Email) - instr(1,Email,"@"))
	else
	GrabDomainFromEmail = "yourdomain.com"
	end if

End Function




%>