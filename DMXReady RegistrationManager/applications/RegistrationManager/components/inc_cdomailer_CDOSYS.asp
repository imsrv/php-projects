<!--#include virtual="/Connections/registrationmanager.asp" -->
<%
Dim message_preferences
Dim message_preferences_numRows

Set message_preferences = Server.CreateObject("ADODB.Recordset")
message_preferences.ActiveConnection = MM_registrationmanager_STRING
message_preferences.Source = "SELECT *  FROM tblRM_MessagingPreferences"
message_preferences.CursorType = 0
message_preferences.CursorLocation = 2
message_preferences.LockType = 1
message_preferences.Open()

message_preferences_numRows = 0
%>
<%
' CDO Form Mailer Created by Robert Paddock (Robp) 26/01/2001 ver 1.0
' Sorting functionality added by Simon Collyer 08/05/2001 ver 1.1
 'The header/footer for the email
 Header = (message_preferences.Fields.Item("MessageHeaderAdmin").Value)
 Footer = (message_preferences.Fields.Item("MessageFooterAdmin").Value)
 ' read all the form elements and place them in the variable mailBody
    mailBody = Header & vbCrLf & vbCrLf
    mailBody = mailBody & "Registration submitted at " & Now() & vbCrLf & vbCrLf
   dim i
for i=1 to request.form.count
	  mailBody = mailBody & request.form.key(i) & ": " & request.form.item(i) & vbCrLf 
	  Next
    mailBody = mailBody & vbCrLf & Footer
    'Create the mail object and send the mail
	Set objMailAdmin = Server.CreateObject("CDO.Message")
	Set adminConf = Server.CreateObject("CDO.Configuration")
	Set adminFlds = adminConf.Fields
				adminConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
				adminConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
				adminConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 10
				adminConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25
				adminConf.Fields.Update
				Set objMailAdmin.Configuration = adminConf
	objMailAdmin.From = Request.Form("EmailAddress")
	objMailAdmin.To = (message_preferences.Fields.Item("AdminEmailAddress").Value)
	objMailAdmin.CC = ""
	objMailAdmin.BCC = ""
	objMailAdmin.Subject = (message_preferences.Fields.Item("MessageSubjectAdmin").Value)
	objMailAdmin.TextBody = mailBody 
	objMailAdmin.Send
Set objMailAdmin = Nothing
Set adminFlds = Nothing
Set adminConf = Nothing
    'Create the mail object and send Confirmation Email
Set objMailClient = Server.CreateObject("CDO.Message")
	Set clientConf = Server.CreateObject("CDO.Configuration")
	Set clientFlds = clientConf.Fields
				clientConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2 'use 2 if smtp server is used
				clientConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
				clientConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 10
				clientConf.Fields.Item("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25
				clientConf.Fields.Update
				Set objMailClient.Configuration = clientConf
	objMailClient.From = (message_preferences.Fields.Item("AdminEmailAddress").Value)
	objMailClient.To = Request.Form("EmailAddress")
	objMailClient.CC = ""
	objMailClient.BCC = ""
	objMailClient.Subject = (message_preferences.Fields.Item("MessageSubjectVisitor").Value)
	objMailClient.TextBody = "Thank you " & Request.Form("FirstName") & ", " & vbCrLf _
	& vbCrLf _
	& message_preferences.Fields.Item("MessageBodyVisitor").Value & vbCrLf _
    & vbCrLf _
    & vbCrLf _
	& message_preferences.Fields.Item("MessageFooterVisitorLine1").Value & vbCrLf _
	& message_preferences.Fields.Item("MessageFooterVisitorLine2").Value & vbCrLf _
	& message_preferences.Fields.Item("MessageFooterVisitorLine3").Value & vbCrLf
	objMailClient.Send
Set objMailClient = Nothing
Set clientFlds = Nothing
Set clientConf = Nothing
%>
<%
message_preferences.Close()
Set message_preferences = Nothing
%>
