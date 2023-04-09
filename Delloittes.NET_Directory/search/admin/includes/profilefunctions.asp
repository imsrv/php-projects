
<% 

'*****************************************
' Subs for the editprofile.asp page
'*****************************************

Sub Header()

	With Response

		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<img src='images/icons/editprofile.gif' align='absmiddle'>&nbsp;&nbsp;"
		.write "<font class='menuLinks'>Edit Your Profile</font>"
		.write "</td></tr>"
		.write "<tr><td background='images/divide_bg.gif'></td></tr>"
		.write "<tr><td bgcolor='#ffffff'>"
		.write "<font class='general_small_text'>"
		.write "Edit your details including your username and password."
		.write "</font>"
		.write "</td></tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
	
	End With
	
End Sub

Sub DrawProfileForm(UserID)

	Dim ConnObj, SQL, UserRecords
	
	SQL = "SELECT * FROM del_Directory_Users WHERE UserID = " & UserID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set UserRecords = ConnObj.Execute(SQL)
	
	if UserRecords.EOF then
	
	else
	
	With Response
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='editprofile.asp?action=update&id=" & request.querystring("id") & "' method='POST' name='frmUserEdit'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Full Name:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & UserRecords("FullName") & "' class='input' name='fullname' size='40'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Username:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & UserRecords("UserName") & "' class='input' name='username' size='40'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Password:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & UserRecords("UPassword") & "' class='input' name='password' size='40'> *</td>"
	.write "</tr>"
	
	if Session("Admin") = True Or Session("Admin") = 1 then
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Admin:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' value='ON' name='admin'"
	if UserRecords("Admin") = True Or UserRecords("Admin") = 1 then .write " checked"
		.write "> <font class='general_small_text'><i>(Admin privileges allow you to manage directory editors, edit directory settings and manage your newsletter and mailing list)</i></font></td>"
		.write "</tr>"	
	Else
		.write "<input type='hidden' name='admin' value='OFF'>"
	End If
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Changes'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

	end if
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set UserRecords = Nothing
	

End Sub

Sub UpdateProfile()

	Dim ConnObj, SQL, isAdmin
	
	If DatabaseType = "Access" then
	
		If request.form("admin") = "ON" then
			isAdmin = True
		else
			isAdmin = False
		end if
		
	Else
		
		If request.form("admin") = "ON" then
			isAdmin = 1
		else
			isAdmin = 0
		end if
	
	End If
	
	Session("FullName") = CheckString(request.form("fullname"))
	Session("Admin") = isAdmin	

	SQL = "UPDATE del_Directory_Users SET FullName = '" & CheckString(request.form("fullname")) & "', "
	SQL = SQL & "UserName = '" & CheckString(request.form("username")) & "', "
	SQL = SQL & "UPassword = '" & CheckString(request.form("password")) & "', "
	SQL = SQL & "Admin = " & isAdmin & " WHERE UserID = " & cint(request.querystring("id"))

	'Response.Write SQL
	'Response.End 
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set ConnObj = Nothing	
			
End Sub

Sub ShowSave()
	
	With Response
		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<font class='warning_text'>"
		.write "<b>Profile Updated.</b>"
		.write "</font>"
		.write "</td></tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
	End With
	
End Sub

%>
