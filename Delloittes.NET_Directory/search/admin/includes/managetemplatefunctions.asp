
<% 

'*****************************************
' Subs for the managetemplate.asp page
'*****************************************

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/newsletterformat.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Newsletter Templates</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Edit or remove your newsletter templates."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub ShowTemplates()

	Dim ConnObj, SQL, Records
	Dim SubjectLine, Body
	
SQL = "SELECT * FROM del_Directory_Templates ORDER BY Created DESC"
Set ConnObj = Server.CreateObject("ADODB.Connection")
ConnObj.Open MyConnStr	
Set Records = ConnObj.Execute(SQL)

	If Records.EOF then
	
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>"
	response.write "<b>No Templates Found.</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
	Else	
		
		With Response
		
		Records.MoveFirst
			Do until records.EOF
			
		SubjectLine = Replace(Records("SubjectLine"),"@DirectoryName@",DirectoryName)
		SubjectLine = Replace(SubjectLine,"@DirectoryURL@",Path2Directory)
		SubjectLine = Replace(SubjectLine,"@DateStamp@",NewsletterDate)
		Body = Replace(Records("Template"),chr(13) & chr(10),"<br>")
		Body = Replace(Body,"@DirectoryName@",DirectoryName)
		Body = Replace(Body,"@DirectoryURL@",Path2Directory)
		Body = Replace(Body,"@DateStamp@",NewsletterDate)
		
		.write "<table width='90%' align='center' cellpadding='0' cellspacing='0'>"
		.write "<tr><td bgcolor='#bbbbbb'>"
		
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		
		.write "<tr>"
		.write "<td bgcolor='#E8E8E8'>"
		
		.write "<table width='100%' cellspacing='0'><tr><td>"
		.write "<font class='general_small_text'><b>" & Records("TemplateName") 
		
		if Records("DefaultTemplate") = True then 
		.write "</font> <font class='warning_text'><b><i>(Default Template)</i>"
		end if
		
		.write "</b></font>"
		.write "</td>"
		.write "<td align='right'><font class='general_small_text'><img src='images/modify.gif' align='absmiddle' border='0'> <a href='managetemplate.asp?action=modify&id=" & Records("ID") & "' title='Modify this newsletter template'>Modify Template</a> <img src='images/template.gif' align='absmiddle' border='0'> <a href='sendnewsletter.asp?action=preview&id=" & Records("ID") & "' title='Preview & Send newsletter using this template'>Preview & Send</a> <img src='images/bin.gif' align='absmiddle' border='0'> <a href='managetemplate.asp?action=delete&id=" & Records("ID") & "' title='Delete this newsletter template'>Delete</a></font>"
		.write "</td></tr></table>"
		
		.write "</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'>"		
		
		.write "<table width='100%' cellspacing='0'><tr><td>"
		.write "<font class='general_small_text'>" & SubjectLine & "</font>"
		.write "</td>"
		.write "<td align='right'><font class='general_small_text'>Created: " & Records("Created") & "</font>"
		.write "</td></tr></table>"
				
		.write "</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td bgcolor='#ffffff'><font class='general_small_text'>" 
		.write Body
		.write "</td>"
		.write "</tr>"			
		.write "</table>"
		
		.write "</td></tr></table><br>"	
			
		  Records.MoveNext
		Loop
	
		End With
		
	End If

	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing
	

End Sub

Sub ModifyTemplateForm()
	
	Dim ConnObj, SQL, Records
	
	With Response
	
	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<font class='general_small_text'>Use the form below to modify your newsletter template.</b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"

	.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<font class='general_small_text'>"
	.write "You can use the following tags to indicate where you would like the dynamic content to appear within the newsletter template.<br><br>@DirectoryName@ = Directory Name specified in directory settings<br>"
	.write "@DirectoryURL@ = Path2Directory variable specified in configuration_file.asp<br>"
	.write "@NewsletterContent@ = Latest additions to directory generated automatically<br>"
	.write "@DateStamp@ = Todays Date<br><br>These shortcut tags are case sensitive.<br>"
	.write "</font>"
	.write "</td></tr></table><br>"
	
	SQL = "SELECT * FROM del_Directory_Templates WHERE ID = " & request.querystring("id") & " ORDER BY Created DESC"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)	
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='managetemplate.asp?action=save&id=" & request.querystring("id") & "' method='POST' name='frmModifyTemplate'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Template Name:</font>"
	.write "</td><td width='85%' bgcolor='#F9F9F9'><input type='text' style='width:95%;' value='" & Records("TemplateName") & "' class='input' name='tempname' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Newsletter Subject:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' style='width:95%;' value='" & Records("SubjectLine") & "' class='input' name='tempsubject' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9' valign='top'><font class='form_text'>Newsletter Template:</font>"
	.write "</td><td bgcolor='#F9F9F9'><textarea name='template' rows='50' style='width:100%;'>"
	.write Records("Template")
	.write "</textarea></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Default template:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON'  name='default'"
	
	if Records("DefaultTemplate") = True then response.write " checked"
	
	.write ">"
	.write "<font class='general_small_text'><i>(Tick to set this template as your default newsletter format)</i></font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Template'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With
		
	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing

End Sub

Sub UpdateTemplate()
	
	Dim ConnObj, SQL, DefaultTemp
	
	if request.form("default") = "ON" then
		
		ClearAllOtherDefaults()
		
		if DatabaseType = "Access" then
			DefaultTemp = True
		else
			DefaultTemp = 1
		end if
		
	Else
	
		if DatabaseType = "Access" then
			DefaultTemp = False
		else
			DefaultTemp = 0
		end if
		
	end if
		
	SQL = "UPDATE del_Directory_Templates Set TemplateName = '" & CheckString(Request.Form("tempname")) & "',"
	SQL = SQL & "SubjectLine = '" & CheckString(request.form("tempsubject")) & "',"
	SQL = SQL & "Template = '" & RemoveQs(request.form("template")) & "',"
	SQL = SQL & "DefaultTemplate = " & DefaultTemp
	SQL = SQL & " WHERE ID = " & Request.Querystring("ID")
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set Connobj = Nothing
	
End Sub

Sub ClearAllOtherDefaults()
	
	Dim ConnObj, SQL
	
	if DatabaseType = "Access" then
		SQL = "UPDATE del_Directory_Templates SET DefaultTemplate = False"	
	else
		SQL = "UPDATE del_Directory_Templates SET DefaultTemplate = 0"	
	end if
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set Connobj = Nothing

End Sub

Sub ShowSave()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'>"
	response.write "<b>Template Saved.</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"	
		
End Sub

Function RemoveQs(strInput)

	Dim strTemp
	strTemp = Replace(strInput, "'", "''")
	RemoveQs = strTemp
	
End Function

Sub DeleteTemplate()
	
	Dim ConnObj, SQL
	SQL = "DELETE FROM del_Directory_Templates WHERE ID = " & request.querystring("id")	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set Connobj = Nothing
		
End Sub

Sub ShowDelete()
	
	Dim ConnObj, SQL, TemplateRecords, Template

	SQL = "SELECT TemplateName FROM del_Directory_Templates WHERE ID = " & request.querystring("id")
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TemplateRecords = ConnObj.Execute(SQL)
	if Not TemplateRecords.EOF then Template = TemplateRecords("TemplateName")
	Set TemplateRecords = Nothing
	ConnObj.Close
	Set Connobj = Nothing

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the template <b>""" & Template & """</b> from the database.<br><br>Are you sure you want to delete this template?<br><br><a href='managetemplate.asp?action=dodelete&id=" & request.querystring("ID") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='javascript:history.back(1)'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DoneDelete()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'>"
	response.write "<b>Template Deleted.</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

%>
