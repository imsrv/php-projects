
<% 

'*****************************************
' Subs for the managemaillist.asp page
'*****************************************

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/newtemplate.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>New Newsletter Template</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Create plain text newsletter templates to send to your mailing list."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub ShowCreateTemplateForm()

	With Response

	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<font class='general_small_text'>Use the form below to create a new newsletter template. </b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"

	.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<font class='general_small_text'>"
	.write "You can use the following tags to indicate where you would like the dynamic content to appear within the newsletter template.<br><br><b>@DirectoryName@</b> = Directory Name specified in directory settings<br>"
	.write "<b>@DirectoryURL@</b> = Path2Directory variable specified within configuration_file.asp (URL to directory)<br>"
	.write "<b>@NewsletterContent@</b> = Latest additions to directory generated dynamically<br>"
	.write "<b>@DateStamp@</b> = Todays Date<br><br>These shortcut tags are case sensitive. You can specifiy how many latest additions appear within the directory within <a href='settings.asp'>the directory settings</a><br>"
	.write "</font>"
	.write "</td></tr></table><br>"
	

	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='createtemplate.asp?action=save' method='POST' name='frmNewCategory'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Template Name:</font>"
	.write "</td><td width='85%' bgcolor='#F9F9F9'><input type='text' value='' class='input' style='width:95%;' name='tempname' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Newsletter Subject:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='@DirectoryName@ Update - @DateStamp@' style='width:95%;' class='input' name='tempsubject' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9' valign='top'><font class='form_text'>Newsletter Template:</font>"
	.write "</td><td bgcolor='#F9F9F9'><textarea name='template' rows='50' style='width:100%;'>"
	.write "@DirectoryName@ - @DateStamp@" & vbcrlf
	.write "@DirectoryURL@" & vbcrlf
	.write "---------------------------------------------------------------" & vbcrlf & vbcrlf
	.write "Your essential guide to what's new at @DirectoryName@" & vbcrlf & vbcrlf
	.write "---------------------------------------------------------------" & vbcrlf & vbcrlf
	.write "@NewsletterContent@" & vbcrlf & vbcrlf
	.write "---------------------------------------------------------------" & vbcrlf & vbcrlf
	.write "You can unsubscribe from this newsletter at:" & vbcrlf
	.write "@DirectoryURL@newsletter.asp"
	.write "</textarea></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Default template:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='default'><font class='general_small_text'><i>(Tick to set this template as your default newsletter format)</i></font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Template'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With


End Sub

Sub AddTemplate()
	
	Dim ConnObj, SQL, DefaultTemp
	
	if request.form("default") = "ON" then
		ClearAllOtherDefaults()
		
		If DatabaseType = "Access" then
			DefaultTemp = True
		else
			DefaultTemp = 1
		end if
		
	Else
	
		If DatabaseType = "Access" then
			DefaultTemp = False
		else
			DefaultTemp = 0
		end if
		
	end if
		
	SQL = "INSERT INTO del_Directory_Templates (TemplateName, SubjectLine, "
	SQL = SQL & "Template, Created, DefaultTemplate) VALUES "
	SQL = SQL & "('" & RemoveQs(Request.Form("tempname")) & "','" & RemoveQs(request.form("tempsubject")) & "', '"
	
	If DatabaseType = "Access" then
		SQL = SQL & RemoveQs(Request.Form("template")) & "',#" & ShortDate & "#," & DefaultTemp & ")"
	else
		SQL = SQL & RemoveQs(Request.Form("template")) & "','" & ShortDateIso & "'," & DefaultTemp & ")"
	end if	
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	ConnObj.Execute(SQL)
	ConnObj.Close
	
End Sub

Sub ClearAllOtherDefaults()

	Dim ConnObj

	If DatabaseType = "Access" then
		SQL = "UPDATE del_Directory_Templates SET DefaultTemplate = False"	
	else
		SQL = "UPDATE del_Directory_Templates SET DefaultTemplate = 0"	
	end if
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	ConnObj.Execute(SQL)
	ConnObj.Close

End Sub

Function RemoveQs(strInput)
	
	Dim strTemp
	
	strTemp = Replace(strInput, "'", "''")
	RemoveQs = strTemp
	
End Function

Sub ShowSave()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'>"
	response.write "<b>Newsletter Template Saved.</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>"
	response.write "<b><a href='sendnewsletter.asp'>Send Newsletter using this Template</a> | <a href='managetemplate.asp'>Modify Template</a> | <a href='createtemplate.asp'>Create Another Template</a></b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

%>
