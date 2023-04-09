<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/globalfunctions.asp"-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>deloittes.NET Directory - Login</title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0">

<% ShowHeader() %>

<table width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="18%" bgcolor="#F6F6F6" valign="top"><!--#include file="includes/navigation.asp"--></td>
<td width="1" bgcolor="#bbbbbb"><img src="" width="1"></td>
<td width="82%" valign="top"><br>

<% 	

if request.querystring("action") = "" then

	With Response
	
	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<img src='images/icons/logout.gif' align='absmiddle'>&nbsp;&nbsp;"
	.write "<font class='menuLinks'>Login</font>"
	.write "</td></tr>"
	.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	.write "<tr><td bgcolor='#ffffff'>"
	.write "<font class='general_small_text'>"
	.write "Enter your username and password to login."
	.write "</font>"
	.write "</td></tr>"
	.write "</table>"
	.write "</td></tr></table><br>"
	
		If request.querystring("loginfailed") = "true" then
	
			.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
			.write "<tr><td>"
			.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
			.write "<tr><td bgcolor='#F9F9F9'>"
			.write "<font class='warning_text'>"
			.write "<b>Incorrect Username and Password.</b>"
			.write "</font>"
			.write "</td></tr></table>"
			.write "</td></tr></table><br>"
	
		ElseIf request.querystring("logout") = "true" then
	
			.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
			.write "<tr><td>"
			.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
			.write "<tr><td bgcolor='#F9F9F9'>"
			.write "<font class='warning_text'>"
			.write "<b>You have been logged out.</b>"
			.write "</font>"
			.write "</td></tr></table>"
			.write "</td></tr></table><br>"
	
		End If
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form action='login.asp?action=checklogin' method='POST' name='frmResourceEdit'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Username:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & request.cookies("AdminUsername") & "' class='input' name='username' size='40'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td width='20%' bgcolor='#F9F9F9'><font class='form_text'>Password:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='password' value='" & request.cookies("AdminPassword") & "' class='input' name='password' size='40'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td width='20%' bgcolor='#F9F9F9'>&nbsp;"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' value='ON' name='remember'> <font class='general_small_text'>Remember my username and password so it automatically fills in next time.</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Login'> "
	.write "</td></tr></table>"

	.write "</td></tr></form></table><br>"

	End With
	
	ElseIf request.querystring("action") = "checklogin" then
	
		Dim ConnObj, Records
		SQL = "SELECT * FROM del_Directory_Users WHERE UserName = '" & request.form("username") & "' AND UPassword = '" & request.form("password") & "'"
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr	
		Set Records = ConnObj.Execute(SQL)
	
		If Records.EOF then
	
			response.write "<script>location = 'login.asp?loginfailed=true'</script>"	
	
		Else
			
			SQL = "UPDATE del_Directory_Users SET LoginCount = " & Records("LoginCount") + 1 
			
				if DatabaseType = "Access" then
					SQL = SQL & ", LastAccessed = #" & shortdate & "#"
				else	
					SQL = SQL & ", LastAccessed = '" & ShortDateIso & "'"
				end if

			SQL = SQL & " WHERE UserID = " & Records("UserID")
			
			ConnObj.Execute(SQL)
			
			Session("FullName") = Records("FullName")
			Session("UserID") = Records("UserID")	
			Session("Admin") = Records("Admin")
						
			if Request.Form("remember") = "ON" then			
				response.cookies("AdminUsername") = request.form("username")
				response.cookies("AdminUsername").Expires = now() + 365
				response.cookies("AdminPassword") = request.form("password")
				response.cookies("AdminPassword").Expires = now() + 365
			end if

			response.write "<script>location = 'default.asp'</script>"	
	
		End If
	
		ConnObj.Close
		Set ConnObj = Nothing
		Set Records = Nothing
		
	
end if
		
ShowFooter() 

%>

</td>

</tr>
</table>


</body>
</html>
