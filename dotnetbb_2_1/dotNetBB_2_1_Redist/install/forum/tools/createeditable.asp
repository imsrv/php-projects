<% 
	response.Buffer = false
	
'==============================================
'==	retreives post values for edit
'==
'==============================================
	Function GetPostValues(MessageText)
		
		Dim EditText, marker		
			EditText = MessageText
			marker = InStr(1, EditText, "<!-- Begin Signature  //--><br /><br />")
			If marker > 0 Then
				EditText = Left(EditText, marker - 1)
			End If
			marker = 0
			
			marker = InStr(1, EditText, "<!-- Edit Post //-->")
			If marker > 0 Then
				EditText = Left(EditText, marker - 1)
			End If
			marker = 0
			
			TStr = EditText
			i = 0
			Do While InStr(1, EditText, "alt=:") > 0
				marker = 0
				marker2 = 0
				marker3 = 0
				tstr = EditText
				marker = InStr(1, TStr, "alt=:")
				If marker > 0 Then
					marker2 = InStrRev(TStr, "<img", marker)
					marker3 = InStr(marker + 5, TStr, ":")
					tstr2 = Left(tstr, marker2 - 1)
					tstr3 = right(tstr, len(tstr) - (marker3 + 1))
					tstr4 = Left(tstr, marker3)
					tstr4 = Right(tstr4, marker3 - (marker + 3))
					EditText = tstr2 & tstr4 & tstr3					
				End If		
			loop			
			
			Do While InStr(1, EditText, "<img") > 0
				marker = 0
				marker2 = 0
				tstr = EditText
				marker = InStr(1, tstr, "<img")
				If marker > 0 Then
					marker2 = InStr(marker + 10, tstr, ">")
					marker3 = InStr(marker + 10, tstr, " border")
					tstr2 = left(tstr, marker-1)
					tstr3 = right(tstr, len(tstr) - marker2)
					tstr4 = left(tstr, marker3 - 2)
					tstr4 = Right(tstr4, (marker3 - 2) - (marker + 9))
					EditText = tstr2 & "[img]" & tstr4 & "[/img]" & tstr3
				End If
			loop

			Do While InStr(1, EditText, "<a href") > 0
				marker = 0
				marker2 = 0
				tstr = EditText
				marker = InStr(1, tstr, "<a href")
				If marker > 0 Then
					marker2 = InStr(marker + 9, tstr, ">")
					marker3 = InStr(marker2, tstr, "</a>")
					tstr2 = left(tstr, marker - 1)
					tstr3 = right(tstr, len(tstr) - (marker3 + 3))
					tstr4 = left(tstr, marker3 - 1)
					tstr4 = Right(tstr4, (marker3 - 1) - (marker2))
					
					EditText = tstr2 & "[url]" & tstr4 & "[/url]" & tstr3
				End If
			loop
			EditText = Replace(EditText, "<br />", vbCrLf)
			EditText = Replace(EditText, "<b>", "[b]")
			EditText = Replace(EditText, "</b>", "[/b]")
			EditText = Replace(EditText, "<i>", "[i]")
			EditText = Replace(EditText, "</i>", "[/i]")
			EditText = Replace(EditText, "<u>", "[u]")
			EditText = Replace(EditText, "</u>", "[/u]")
		GetPostValues = PostValues
		
	End Function	
	
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Create Editable Messages</title>
</head>
<body>
<div style="font-family:Tahoma;font-size:9pt;">
<%
	Dim dataConn, dataCmd, dataCmd2, rs_main
	Dim messID, oldText, newText
	Dim iCount : iCount = 0
	Dim iCent : iCent = 0
	Set dataConn = Server.CreateObject("ADODB.Connection")
	dataConn.ConnectionString = "SERVER=SECONDBASE;DATABASE=TKK;UID=sa;PWD=1godaboveall;"
	dataConn.Provider = "SQLOLEDB"
	dataConn.Open
	
	Set dataCmd = Server.CreateObject("ADODB.Command")
	dataCmd.ActiveConnection = dataConn
	dataCmd.CommandType = 4
	dataCmd.CommandText = "TB_GetMissingEditMessages"
	
	Set dataCmd2 = Server.CreateObject("ADODB.Command")
	dataCmd2.ActiveConnection = dataConn
	dataCmd2.CommandType = 4
	dataCmd2.CommandText = "TB_MissingEditMessageCount"
	
	Set rs_main = Server.CreateObject("ADODB.Recordset")
	Set rs_main = dataCmd2.Execute
	If Not rs_main.BOF Then
		response.Write(CStr(rs_main.Fields(0).Value) + " missing editable message posts.  Beginning processing.<br /><br />")
	End If
	rs_main.Close
	
	Set rs_main = dataCmd.Execute
	If Not rs_main.BOF Then
		Do While Not rs_main.EOF
			oldText = rs_main.Fields(0).Value
			messID = rs_main.Fields(1).Value
			'newText = GetPostValues(oldText)
			'dataCmd2.CommandText = "TB_CreateEditableEntry"
			'dataCmd2.Parameters.Refresh
			'dataCmd2("@EditableText") = newText
			'dataCmd2("@MessageID") = messID
			'dataCmd2.Execute
			iCount = iCount + 1
			If iCount MOD 10 = 0 AND iCount Mod 400 <> 0 Then
				response.Write(".")
			ElseIf iCount MOD 400 = 0 Then
				Response.Write(CStr(iCount) & "<br />")				
			End If
			
			
		rs_main.MoveNext
		loop
	End If
	rs_main.Close
	dataConn.Close
	Set rs_main = Nothing
	Set dataCmd = Nothing
	Set dataCmd2 = Nothing
	Set dataConn = Nothing

%>
</div>

</body>
</html>
