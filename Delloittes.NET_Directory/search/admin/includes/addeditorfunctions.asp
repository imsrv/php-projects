
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
		.write "<img src='images/icons/adduser.gif' align='absmiddle'>&nbsp;&nbsp;"
		.write "<font class='menuLinks'>Add Editors</font>"
		.write "</td></tr>"
		.write "<tr><td background='images/divide_bg.gif'></td></tr>"
		.write "<tr><td bgcolor='#ffffff'>"
		.write "<font class='general_small_text'>"
		.write "Add content editors to manage the directory."
		.write "</font>"
		.write "</td></tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
	
	End With
	
End Sub

Sub DrawAddEditorForm()

	With Response
	
		.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
		.write "<tr><td>"
		.write "<form onSubmit='return checkForm(this)' action='addeditor.asp?action=addeditor' method='POST' name='frmResourceEdit'>"
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		If Request.Querystring("action") = "addeditor" then
		.write "<tr>"
		.write "<td colspan='2' bgcolor='#F9F9F9'><font class='form_text'>Add another directory editor...</td>"
		.write "</tr>"
		end if
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Full Name:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='text' value='' class='input' name='fullname' size='40'> *</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Username:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='text' value='' class='input' name='username' size='40'> *</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Password:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='text' value='' class='input' name='password' size='40'> *</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Admin:</font>"
		.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='admin'>"
		.write "<font class='general_small_text'><i>(Non-admins can only access the approve resources page.)</i></font></td>"
		.write "</tr>"	
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
		.write "<td bgcolor='#F9F9F9'>"
		.write "<input type='submit' class='form_buttons' name='submit' value='Add New Editor'> "
		.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
		.write "</td></tr></table>"

		.write "</td></tr></table><br>"

	End With


End Sub

Sub AddEditor()

	Dim ConnObj, SQL, Admin

	If request.form("admin") = "ON" then
	
		if DatabaseType = "Access" then
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
	
	SQL = "INSERT INTO del_Directory_Users (FullName, UserName, "
	SQL = SQL & "UPassword, LoginCount, Admin,Created) VALUES "
	SQL = SQL & "('" & CheckString(request.form("fullname")) & "'," 
	SQL = SQL & "'" & CheckString(request.form("username")) & "',"
	SQL = SQL & "'" & CheckString(request.form("password")) & "',0,"
	SQL = SQL & Admin & ","
	
	If DatabaseType = "Access" then	
		SQL = SQL & "#" & ShortDate & "#)"
	else
		SQL = SQL & "'" & ShortDateIso & "')"
	end if	
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set ConnObj = Nothing
	
End Sub

Sub ShowAddition()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'>"
	response.write "<b>Directory Editor Added Successfully.</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
		
End Sub


%>
