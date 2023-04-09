
<% 

'*****************************************
' Subs for the managemaillist.asp page
'*****************************************

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/managelist.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Mailing List</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	
		response.write "<table width='100%' cellspacing='0'>"
		response.write "<tr><td>"
		response.write "<font class='general_small_text'>"
		response.write "Manage subscribers to your newsletter."
		response.write "</font>"
		response.write "</td><td align='right'>"
		response.write "<font class='general_small_text'>"
		response.write "<a href='managemaillist.asp?filter=true'>Show Invalid Emails</a> | <a href='managemaillist.asp'>Show All Emails</a>"
		response.write "</font>"
		response.write "</td></tr>"
		response.write "</table>"

	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub ShowList()

	Dim ConnObj, SQL, Records

	SQL = "SELECT * FROM del_Directory_NewsletterList ORDER BY Created DESC"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)

	If Records.EOF then

	Else		
	
		With Response
		
		.write "<table width='90%' align='center' cellpadding='0' cellspacing='0'>"
		.write "<tr><td bgcolor='#bbbbbb'>"
		
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Email Address</b></font></td>"
		.write "<td bgcolor='#E8E8E8' align='center'><font class='general_small_text'><b>Created</b></font></td>"
		.write "<td bgcolor='#E8E8E8'></td>"
		.write "</tr>"
		
		Records.MoveFirst
			Do until records.EOF
			
		if request.querystring("filter") = "true" then
		
			if Instr(1,Records("EmailAddress"),"@",1) = 0 OR Instr(1,Records("EmailAddress"),".",1) = 0 OR Instr(1,Records("EmailAddress")," ",1) = 0 then
				
			.write "<tr>"
			.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" 
			.write "<a href='mailto:" & Records("EmailAddress") & "'>" & Records("EmailAddress") & "</a>"
			.write "</font></td>"
			.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" & Records("Created") & "</font></td>"
			.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'><img src='images/bin.gif' align='absmiddle' border='0'> <a href='managemaillist.asp?action=delete&id=" & Records("ID") & "'>Delete this user</a></font></td>"
			.write "</tr>"
			
			End If
		
		Else
		
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" 
		.write "<a href='mailto:" & Records("EmailAddress") & "'>" & Records("EmailAddress") & "</a>"
		.write "</font></td>"
		.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" & Records("Created") & "</font></td>"
		.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'><img src='images/bin.gif' align='absmiddle' border='0'> <a href='managemaillist.asp?action=delete&id=" & Records("ID") & "'>Delete this user</a></font></td>"
		.write "</tr>"
		
		End If
			
		  Records.MoveNext
		Loop
			
		.write "</table>"
		
		.write "</td></tr></table><br>"
	
		End With
		
	End If

	
	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing

End Sub

Sub ShowConfirmation(Text)

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'>"
	response.write "<b>" & Text & "</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DeleteUser()
	
	Dim ConnectionObj, SQL
	
	SQL = "DELETE FROM del_Directory_NewsletterList WHERE ID = " & request.querystring("id")	
	Set ConnectionObj = Server.CreateObject("ADODB.Connection")
	ConnectionObj.Open MyConnStr	
	ConnectionObj.Execute(SQL)
	ConnectionObj.Close
		
End Sub

Sub ShowDelete()

	Dim ConnectionObj, SQL, UserRecords, EmailAddress
		
	SQL = "SELECT EmailAddress FROM del_Directory_NewsletterList WHERE ID = " & request.querystring("id")
	Set ConnectionObj = Server.CreateObject("ADODB.Connection")
	ConnectionObj.Open MyConnStr	
	Set UserRecords = ConnectionObj.Execute(SQL)
	if Not UserRecords.EOF then EmailAddress = UserRecords("EmailAddress")
	Set UserRecords = Nothing
	ConnectionObj.Close

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the user <b>""" & EmailAddress & """</b> from your mailing list.<br><br>Are you sure you want to delete this user?<br><br><a href='managemaillist.asp?action=dodelete&id=" & request.querystring("ID") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='javascript:history.back(1)'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub

%>
