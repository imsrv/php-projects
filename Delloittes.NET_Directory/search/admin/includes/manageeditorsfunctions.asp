
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
		.write "<img src='images/icons/deluser.gif' align='absmiddle'>&nbsp;&nbsp;"
		.write "<font class='menuLinks'>Manage Editors</font>"
		.write "</td></tr>"
		.write "<tr><td background='images/divide_bg.gif'></td></tr>"
		.write "<tr><td bgcolor='#ffffff'>"
		.write "<font class='general_small_text'>"
		.write "Modify or delete directory editors."
		.write "</font>"
		.write "</td></tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
	
	End With
	
End Sub

Sub Instruction()

	With Response

		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<font class='general_small_text'>Click a users name to edit their details or click delete to remove the user.</b></font>"
		.write "</td></tr></table>"
		.write "</td></tr></table><br>"
		
	End With

End Sub

Sub ShowUsers()

	Dim ConnObj, SQL, Records
	
	SQL = "SELECT * FROM del_Directory_Users ORDER BY FullName ASC"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)
	
	With Response
	
	If Records.EOF then
	
		.write "<table cellspacing='1' width='90%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'><font class='general_small_text'><b>No Users Found</b></font></td>"
		.write "</tr>"
	
	Else		
	

		.write "<table width='90%' align='center' cellpadding='0' cellspacing='0'>"
		.write "<tr><td bgcolor='#bbbbbb'>"
		
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>FullName</b></font></td>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Username</b></font></td>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Password</b></font></td>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Admin</b></font></td>"
		.write "<td bgcolor='#E8E8E8' align='center'><font class='general_small_text'><b>Created</b></font></td>"
		.write "<td bgcolor='#E8E8E8' align='center'><font class='general_small_text'><b>Last Accessed</b></font></td>"
		.write "<td bgcolor='#E8E8E8' align='center'><font class='general_small_text'><b>Login Count</b></font></td>"
		
		.write "<td bgcolor='#E8E8E8'></td>"
		.write "</tr>"
		
		Records.MoveFirst
			Do until records.EOF
			
			if Session("UserID") <> Records("UserID") then
			
			.write "<tr>"
			.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" 
			.write "<a href='manageeditors.asp?action=modify&id=" & Records("UserID") & "' title='Click to modify user details'>" & Records("fullname") & "</a>"
			.write "</font></td>"
			.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" & Records("username") & "</font></td>"
			.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>" 
			for i = 1 to len(Records("Upassword"))
			.write "*"
			next
			.write "</font></td>"
			.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" 
			if Records("admin") = True then
			.write "<img src='images/chkon.gif'>"
			else
			.write "<img src='images/chkoff.gif'>"
			end if
			.write "</font></td>"
					.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" & Records("created") & "</font></td>"

			.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" & Records("lastaccessed") & "</font></td>"
			.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'>" & Records("logincount") & "</font></td>"

			.write "<td bgcolor='#F9F9F9' align='center'><font class='general_small_text'><img src='images/bin.gif' align='absmiddle' border='0'> <a href='manageeditors.asp?action=delete&id=" & Records("UserID") & "'>Delete</a></font></td>"
			.write "</tr>"	
			
			end if		
			
		  Records.MoveNext
		Loop
			
		.write "</table>"		
		.write "</td></tr></table><br>"
	
		
		
	End If
	
	End With

	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing	

End Sub

Sub DrawModifyProfileForm(UserID)

	Dim ConnObj, SQL, Records

	SQL = "SELECT * FROM del_Directory_Users WHERE UserID = " & UserID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)
	
	if Records.EOF then
	
	else
	
	With Response
	
		.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
		.write "<tr><td>"
		.write "<form onSubmit='return checkForm(this)' action='manageeditors.asp?action=update&id=" & request.querystring("id") & "' method='POST' name='frmResourceEdit'>"
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Full Name:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & Records("FullName") & "' class='input' name='fullname' size='40'> *</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Username:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & Records("UserName") & "' class='input' name='username' size='40'> *</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Password:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & Records("UPassword") & "' class='input' name='password' size='40'> *</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Admin:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='admin'"
		if Records("Admin") = True then .write " checked"
		.write "> <font class='general_small_text'><i>(Non-admins can only access the approve resources page.)</i></font></td>"
		.write "</tr>"	
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
	Set Records = Nothing
	

End Sub

Sub ShowConfirmation(Text)

	With Response

		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<font class='warning_text'>"
		.write "<b>" & Text & "</b>"
		.write "</font>"
		.write "</td></tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
		
	End With
	
End Sub

Sub UpdateProfile()

	Dim ConnObj, SQL, Admin

	If request.form("admin") = "ON" then
	
		If DatabaseType = "Access" then
			Admin = True
		else
			Admin = 1
		end if
				
	else
	
		If DatabaseType = "Access" then
			Admin = False
		else
			Admin = 0
		end if
		
	end if
	
	SQL = "UPDATE del_Directory_Users SET FullName = '" & CheckString(request.form("fullname")) & "', "
	SQL = SQL & "UserName = '" & CheckString(request.form("username")) & "', "
	SQL = SQL & "UPassword = '" & CheckString(request.form("password")) & "', "
	SQL = SQL & "Admin = " & Admin & " WHERE UserID = " & request.querystring("id")
	
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr	
		ConnObj.Execute(SQL)
		ConnObj.Close
		Set ConnObj = Nothing
			
		
End Sub

Sub DeleteProfile()

	Dim ConnObj, SQL

	SQL = "DELETE FROM del_Directory_Users WHERE UserID = " & request.querystring("id")	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr	
		ConnObj.Execute(SQL)
		ConnObj.Close
	Set ConnObj = Nothing
		
End Sub

Sub ShowDelete()

	Dim ConnObj, SQL, Records, UserName

	SQL = "SELECT FullName FROM del_Directory_Users WHERE UserID = " & request.querystring("id")
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr	
		Set Records = ConnObj.Execute(SQL)
		if Not Records.EOF then UserName = Records("FullName")
		Set Records = Nothing
		ConnObj.Close
	Set ConnObj = Nothing

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the user <b>""" & UserName & """</b> from database.<br><br>Are you sure you want to delete this user?<br><br><a href='manageeditors.asp?action=dodelete&id=" & request.querystring("ID") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='javascript:history.back(1)'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub

%>
