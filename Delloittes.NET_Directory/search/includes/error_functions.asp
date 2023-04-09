<!--#include file="../email_subs.asp"-->
<% 

Dim SiteID
SiteID = Request.QueryString("siteID")

' if from error form call SendErrorViaEmail sub

If Request.ServerVariables("REQUEST_METHOD") = "POST" then ' if this page has loaded from form submission then add info to DB

	AddErrorToDatabase() 
	if SendEmailAfterErrorSubmission = True then SendEmailErrorNotification()

End If

'*************************************
' Add error report to database
'*************************************

Sub AddErrorToDatabase()

Dim ConnObj, Records
Dim FullName, EmailAddress, NatureOfError, Comments, Body, SendEmailsTo, EmailsFrom, EmailSubject

	' grab form values and construct body of email
	
	FullName = CheckString(request.form("FullName"))
	EmailAddress = CheckString(request.form("EmailAddress"))
	NatureOfError = CheckString(request.form("Nature"))
	Comments = CheckString(request.form("comments"))
	SiteID = request.form("SiteID")
	
	if comments = "" then comments = "None provided"
	
	SQL = "INSERT INTO del_Directory_Errors (SiteID, FullName, EmailAddress, NatureOfError, Comments, Created) VALUES "
	SQL = SQL & "(" & SiteID  & ",'" & FullName & "','" & EmailAddress & "','" 
	
	If DatabaseType = "Access" then	
		SQL = SQL & NatureOfError & "','" & Comments & "',#" & ShortDate & "#)"
	else
		SQL = SQL & NatureOfError & "','" & Comments & "','" & ShortDateIso & "')"
	end if	
	
	if Debug = True then response.write SQL
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)
	
	Set Records = Nothing
	ConnObj.Close
	
		
End Sub

'*************************************
' End of add error to database
'*************************************

Sub DrawErrorForm()

With Response

	.write "<font class='general_text'>If you have noticed an error with the above resource please complete our simple form below and we will look into the error as soon as possible. Many thanks for helping keep the directory tidy.</font><br><br>"

	.write "<table width='100%' cellpadding='0' cellspacing='0' bgcolor='" & CellSpilt & "'>"
	.write "<tr>"
	.write "<form onSubmit='return CheckErrorForm(this)' action='error.asp?popup=true' method='POST' name='frmReportError'>"
	.write "<input type='hidden' name='SiteID' value='" & SiteID & "'>"
	.write "<td>"

		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<font class='form_text'>Full Name:</font>"
		.write "</td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<input type='text' class='input' name='FullName' size='40' value=''> <font class='general_text_red'>*</font></td>"
		.write "</tr>"
		
		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<font class='form_text'>Email Address:</font>"
		.write "</td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<input type='text' class='input' name='EmailAddress' size='40' value=''> <font class='general_text_red'>*</font></td>"
		.write "</tr>"

		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<font class='form_text'>Nature of error:</font>"
		.write "</td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<select name='Nature'>"
		.write "<option></option>"
		.write "<option value='Dead Link'>Dead Link</option>"
		.write "<option value='Incorrect Title'>Incorrect Title</option>"
		.write "<option value='Incorrect Description'>Incorrect Description</option>"
		.write "<option value='Incorrect URL'>Incorrect URL</option>"
		.write "<option value='Remove Listing'>Remove Listing</option>"
		.write "</select> <font class='general_text_red'>*</font></td>"
		.write "</tr>"

		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "' valign='top'>"
		.write "<font class='form_text'>Comments:</font>"
		.write "</td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<textarea name='comments' rows='5' cols='39'></textarea>"
		.write "</td>"
		.write "</tr>"

		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "' valign='top'>&nbsp;</td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<input type='submit' name='submit' class='form_buttons' value='Send Error Report'> "
		.write "<input type='reset' name='reset' class='form_buttons' value='Reset'>"
		.write "</td>"
		.write "</tr>"
		.write "</td></tr></table>"
		
	.write "</td></tr></table>"

End With

End Sub

Sub DrawErrorThankYou()

	response.write "<font class='general_text'>Thank you, your error report has been submitted.<br><br>"
	response.write "We will review your error within 2-3 days and if required remove this listing from our directory.<br><br>"
	response.write "<a href='javascript:self.close()' class='general_text'><b>Close Window</b></a></font>"

End Sub

Sub SendEmailErrorNotification()

		Dim Body, EmailsFrom, EmailSubject

	Body = "Hi," & vbcrlf & vbcrlf 
	Body = Body & "A user has submitted an error within your directory..." & vbcrlf & vbcrlf 
	Body = Body & "FullName: " & CheckString(request.form("FullName")) & vbcrlf
	Body = Body & "EmailAddress: " & CheckString(lcase(request.form("EmailAddress"))) & vbcrlf 
	Body = Body & "Comments: " & CheckString(request.form("Comments")) & vbcrlf & vbcrlf
	Body = Body & "Logon to the administration centre to investigate this error." & vbcrlf & vbcrlf 
	Body = Body & Path2Admin & vbcrlf & vbcrlf 
	
	EmailsFrom = request.form("EmailAddress")
	EmailSubject = DirectoryName & " Error Submission"
	
	If EmailObject = "CDONTS" then
		SendWithCDONTS GlobalEmailAddress,EmailsFrom,EmailSubject,Body,""
	ElseIf EmailObject = "ASPMail" then
		SendWithASPMail GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body,""
	ElseIf EmailObject = "JMail" then
		SendWithJMail GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body,""
	Elseif EmailObject = "ASPEmail" then
		SendWithASPEmail GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body,""
	Elseif EmailObject = "SA-SMTP" then
		SendWithSASMTP GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body,""
	End If


End Sub

%>