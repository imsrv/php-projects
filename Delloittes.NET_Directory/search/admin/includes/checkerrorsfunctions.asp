
<% 

'*****************************************
' Subs for the editprofile.asp page
'*****************************************

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/errors.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Check Errors</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Keep the directory tidy by checking for error submissions."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub ShowErrors()

	Dim ConnObj, SQL, Records
	
	SQL = "SELECT * FROM del_Directory_Errors ORDER BY Created DESC"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)

	If Records.EOF then
	
		With Response
		
		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='0' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'><font class='general_small_text'><b>No Errors Found</b></font></td>"
		.write "</tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
	
		End With
	
	Else		
	
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>"
	response.write "Below are errors reported by visitors to your directory.<br><br>&#149;&nbsp;Click ""Show Resource"" to view, modify or delete the resource related to the error.<br>&#149;&nbsp;Click ""Delete"" to delete the error. You can email the author of the error by clicking thier name."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
		With Response
		.write "<table width='90%' align='center' cellpadding='0' cellspacing='0'>"
		.write "<tr><td bgcolor='#bbbbbb'>"
		
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Name</b></font></td>"
		.write "<td bgcolor='#E8E8E8' align='center'><font class='general_small_text'><b>Nature Of Error</b></font></td>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Comments</b></font></td>"
		.write "<td bgcolor='#E8E8E8' align='center'><font class='general_small_text'><b>Created</b></font></td>"
		.write "<td bgcolor='#E8E8E8'></td>"
		.write "</tr>"
		
		Records.MoveFirst
			Do until records.EOF
			
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" 
		.write "<a href='mailto:" & Records("EmailAddress") & "' title='Click to send email'>" & Records("FullName") & "</a>"
		.write "</font></td>"
		.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" 
		.write Records("NatureOfError")
		.write "</font></td>"
		.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" 
		.write Records("Comments")	
		.write "</font></td>"
		.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" 
		.write Records("Created") 
		.write "</font></td>"
		.write "<td bgcolor='#F9F9F9' width='25%' align='center'><font class='general_small_text'>"
		.write "<img src='images/ie.gif' align='absmiddle' alt='Show Resource' border='0'> <a href='manageresources.asp?siteid=" & Records("siteID") & "&action=search' title='Show resource related to this error'>Show Resource</a> <img src='images/bin.gif' align='absmiddle' alt='Delete Error Report' border='0'> <a href='checkerrors.asp?id=" & Records("ID") & "&action=delete' title='Delete Error'>Delete</a></font></td>"
		.write "</tr>"			
			
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

Sub ShowDelete()

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete an error report from the database.<br><br>Are you sure you want to delete this report?<br><br><a href='checkerrors.asp?action=dodelete&id=" & request.querystring("id") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='javascript:history.back(1)'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub


Sub ShowConfirmation(Text)

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>"
	response.write "<b>" & Text & "</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DeleteError()
	
	Dim ConnObj, SQL
		
	SQL = "DELETE FROM del_Directory_Errors WHERE ID = " & request.querystring("id")
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
		
End Sub

%>
