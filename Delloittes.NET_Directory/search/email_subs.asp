<% 

'*************************************************
' Send Email Using CDO for NTS from Microsoft
' CDO for NTS online documentation can be found at
' http://msdn.microsoft.com/library/default.asp?URL=/library/psdk/cdo/_denali_cdo_for_nts_library.htm
'*************************************************

Sub SendWithCDONTS(ToEmail,FromEmail,Subject,BodyCopy,BCCList)
	
  Dim ObjMail
  Set objMail = Server.CreateObject("CDONTS.Newmail")  
  
	objMail.To = ToEmail  
	objMail.Subject = Subject
	objMail.From = FromEmail
	objMail.BCC = BCCList
	objMail.Body = BodyCopy
	objMail.Send  
	
  Set objMail = Nothing
  
End Sub

'*************************************************
' Send Email Using ASPMail from ServerObjects
' ASPMail online documentation can be found at
' http://www.serverobjects.com/comp/Aspmail4.htm
'*************************************************

Sub SendWithASPMail(ToEmail,FromEmail,Subject,MailServer,BodyCopy,BCCList)

	'------------------------------------------------------------------		
	' SMTP Authentication not supported with ASPMail
	'------------------------------------------------------------------	
	
	Dim objMail
	Set objMail = Server.CreateObject("SMTPsvg.Mailer")
	
		objMail.FromName = FromEmail 
		objMail.FromAddress = FromEmail 
		objMail.RemoteHost = MailServer
		objMail.AddRecipient ToEmail & ", " & ToEmail
		objMail.AddBCC BCCList
		objMail.Subject = Subject
		objMail.BodyText = BodyCopy
	
		if Mailer.SendMail then
		else
		  Response.Write "Mail send failure. Error was " & Mailer.Response
		end if
	
	Set objMail = Nothing

End Sub

'*************************************************
' Send Email Using JMail 4.3 from Dimac
' JMail online documentation can be found at
' http://tech.dimac.net/
'*************************************************

Sub SendWithJMail(ToEmail,FromEmail,Subject,MailServer,BodyCopy,BCCList)
	
	Dim objMail
	Set objMail = Server.CreateOBject("JMail.Message")
	
		objMail.Logging = true
		objMail.silent = true	
		objMail.From = FromEmail
		objMail.FromName = FromEmail	
		objMail.AddRecipient ToEmail
		objMail.AddRecipientBCC BCCList
		objMail.Subject = Subject
		objMail.Body = BodyCopy
		
		'------------------------------------------------------------------
		' SMTP Authentication UserName and Password should be added below.
		'------------------------------------------------------------------		
		' objMail.Send("ryan@deloittes.com:jv35k4@" & MailServer) ' use this if your SMTP requires authentication
		
		if not objMail.Send(MailServer) then
		    Response.write "<pre>" & msg.log & "</pre>"
		end if
	
	Set objMail = Nothing

End Sub

'*************************************************
' Send Email Using ASPEmail from Persits Software, Inc.
' ASPEmail online documentation can be found at
' http://www.aspemail.com/
' http://www.aspemail.com/manual.html
'*************************************************

Sub SendWithASPEmail(ToEmail,FromEmail,Subject,MailServer,BodyCopy,BCCList)
	
	Dim objMail
	Set objMail = Server.CreateObject("Persits.MailSender")
	
		objMail.Host = MailServer ' Specify a valid SMTP server
		objMail.From = FromEmail ' Specify sender's address
		objMail.FromName = FromEmail ' Specify sender's name
		objMail.AddAddress ToEmail
		objMail.AddBCC BCCList, ""
		objMail.Subject = Subject
		objMail.Body = BodyCopy
		
		'------------------------------------------------------------------
		' SMTP Authentication UserName and Password should be added below.
		' IMPORTANT : This is only supported in the premium edition of ASPEmail
		'------------------------------------------------------------------		
		'ObjMail.Username "username"
		'ObjMail.Password "password"
		
		'On Error Resume Next
	
		objMail.Send
	
		If Err <> 0 Then
		   Response.Write "Error encountered: " & Err.Description
		End If
	
	Set objMail = nothing
	
End Sub

'*************************************************
' Send Email Using SA-SMTP Mail from SoftArtisans
' ASPEmail online documentation can be found at
' http://www.softartisans.com/softartisans/smtpmail.html
'*************************************************

' For further information regarding SMTP authentication please
' consult the documentation provided on the SoftArtisans site.

Sub SendWithSASMTP(ToEmail,FromEmail,Subject,MailServer,BodyCopy,BCCList)
	
	Dim ObjMail
  	Set ObjMail = Server.CreateObject("SoftArtisans.SMTPMail")
  	
  		ObjMail.RemoteHost = MailServer
		ObjMail.FromAddress = FromEmail
		ObjMail.AddRecipient "" , ToEmail
		ObjMail.AddBCC "", BCCList
  		ObjMail.BodyText = BodyCopy
  		ObjMail.Subject = Subject

  		If ObjMail.SendMail <> true then 
		 		Response.Write "Mail failure."
  		End If

  	Set ObjMail = nothing
	
End Sub

%>
