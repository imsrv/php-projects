<!--#include file="../../email_subs.asp"-->
<% 

'*****************************************
' Subs for the sendnewsletter.asp page
'*****************************************

Dim content,SubjectLine,Body

NewsletterDate = formatdatetime((now),vblongdate)

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/sendnewsletter.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Send Newsletter</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Send your latest additions newsletter to the mailing list."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub ShowTemplates()

Dim ConnObj, SQL, Records

SQL = "SELECT * FROM del_Directory_Templates ORDER BY Created DESC"
Set ConnObj = Server.CreateObject("ADODB.Connection")
ConnObj.Open MyConnStr	
Set Records = ConnObj.Execute(SQL)

	If Records.EOF then
	
		With Response
		
		.write "<table width='90%' align='center' cellpadding='0' cellspacing='0'>"
		.write "<tr><td bgcolor='#bbbbbb'>"
		
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#F9F9F9'><font class='general_small_text'><b>No Templates Found.</b><br><br>You must create at least one newsletter template before you can send a newsletter.<br><br><a href='createtemplate.asp'><b>Create Template</b></a></font></td>"
		.write "</tr>"
		.write "</table>"
		
		.write "</td></tr>"
		.write "</table>"
	
		End With
	
	Else
			
	With Response
	
	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<font class='general_small_text'>"
	.write "Before you can send your newsletter to the mailing you must select a newsletter template to use from the list below."
	.write "</font>"
	.write "</td></tr>"
	.write "</table>"
	.write "</td></tr></table><br>"	
			
		.write "<table width='90%' align='center' cellpadding='0' cellspacing='0'>"
		.write "<tr><td bgcolor='#bbbbbb'>"
		
		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='#E8E8E8'><font class='general_small_text'><b>Please select your newsletter template:</b></font></td>"
		.write "</tr>"
		
		Records.MoveFirst
			Do until records.EOF
			
			.write "<tr>"
			.write "<td bgcolor='#F9F9F9'><font class='general_small_text'>"
		
			.write "<table width='100%' cellspacing='0'>"
			.write "<tr><td><font class='general_small_text'><a href='managetemplate.asp?action=modify&id=" & Records("ID") & "' title='Modify Template'>" & Records("TemplateName") & "</a>"

			if Records("DefaultTemplate") = True then 
			.write "</font> <font class='warning_text'><b><i>(Default Template)</i></b>"
			end if
		
			.write "</font></td>"
			.write "<td align='right'>"
			.write "<font class='general_small_text'><img src='images/template.gif' align='absmiddle' border='0'> <a href='sendnewsletter.asp?action=preview&id=" & Records("ID") & "' title='Goto newsletter preview...'><b>Preview & Send</b></a></font>"
			.write "</td></tr></table>"

			.write "</td>"
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

Sub ConstructNewsletter()

		Dim ConnObj, SQL, Records, ResourceCount
		
		SQL = "SELECT ID, Title, Description, Created "
		
		If DatabaseType = "Access" then
			SQL = SQL & " FROM del_Directory_Sites WHERE del_Directory_Sites.PublishOnWeb = True ORDER BY del_Directory_Sites.Created DESC"
		else
			SQL = SQL & " FROM del_Directory_Sites WHERE del_Directory_Sites.PublishOnWeb = 1 ORDER BY del_Directory_Sites.Created DESC"
		end if
		
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr
		Set Records = ConnObj.Execute(SQL)
		
			If Records.EOF or Records.BOF then
				
				content = "No Resources Found"
				
			else
			
				Records.MoveFirst
				 ResourceCount = 0
				  Do While ResourceCount < HowManyResourcesToShowInNewsletter And Not Records.EOF 
		
						content = content & UCASE(Records("Title")) & " "		
						if formatdatetime(Records("Created")) = formatdatetime(now(),2) then
						content = content & "(TODAY)"
						else
						content = content & "(" & Records("Created") & ")"
						end if		
						content = content & "<br>"
						content = content & Records("Description") & "<br>"
						content = content & Path2Directory & "redirect.asp?id=" & Records("ID")
						if ResourceCount <> HowManyResourcesToShowInNewsletter - 1 then
						content = content & "<br><br>"		
						end if
				
				  ResourceCount = ResourceCount + 1
				 Records.MoveNext
				Loop
			
			End If
			
		Set Records = Nothing
		ConnObj.Close

End Sub

Sub ShowPreview()

	Dim ConnObj, SQL, Records
		
	SQL = "SELECT * FROM del_Directory_Templates WHERE ID = " & request.querystring("id") 
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)

	If Records.EOF then

	Else
	
        SubjectLine = Replace(Records("SubjectLine"),"@DirectoryName@",DirectoryName)
        SubjectLine = Replace(SubjectLine,"@DirectoryURL@",Path2Directory)
        SubjectLine = Replace(SubjectLine,"@DateStamp@",NewsletterDate)
        Body = Replace(Records("Template"),chr(13) & chr(10),"<br>",1)
        Body = Replace(Body,"@DirectoryName@",DirectoryName)
        Body = Replace(Body,"@DirectoryURL@",Path2Directory)
        Body = Replace(Body,"@DateStamp@",NewsletterDate)
        Body = Replace(Body,"@NewsletterContent@",content)
	
		if request.querystring("action") <> "dosend" then
	
			response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
			response.write "<tr><td>"
			Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<font class='general_small_text'>"
			response.write "To send this newsletter to your mailing list click the ""Send this newsletter"" button below the preview. Did you know you can specify how many latest additions to show in your newsletter within <a href='settings.asp'>Directory Settings</a>."
			response.write "</font>"
			response.write "</td></tr>"
			response.write "</table>"
			response.write "</td></tr></table><br>"
	
		end if
			
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#E8E8E8'>"
	
	response.write "<table width='100%' cellspacing='0'><tr><td>"
	response.write "<font class='page_header'>Newsletter Template Preview"
	response.write "</td><td align='right'>"
	response.write "<font class='general_small_text'>"
	response.write "<img src='images/modify.gif' align='absmiddle' border='0'> <a href='managetemplate.asp?action=modify&id=" & Records("ID") & "'>Modify This Newsletter Template</a>"
	response.write "</font>"
	response.write "</td></tr></table>"
	
	response.write "</td></tr>"
	response.write "<tr><td bgcolor='#bcbcbc'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	
	response.write "<table cellpadding='8' width='60%'>"
	response.write "<tr><td>"
	response.write "<font class='general_small_text'>"
	response.write "<b>To:</b> mailinglist@" & GrabDomainFromEmail(GlobalEmailAddress) & "<br>"
	response.write "<b>From:</b> " & GlobalEmailAddress & "<br>"
	response.write "<b>Subject:</b> " & SubjectLine & "<br>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "<tr><td>"
	response.write "<font class='general_small_text'>"
	response.write Body
	response.write "</font><br><br>"
	response.write "</td></tr>"
	
	if request.querystring("action") <> "dosend" then
	
		response.write "<tr><td>"
		response.write "<input type='submit' class='form_buttons' onclick=""javascript:location = 'sendnewsletter.asp?action=dosend&id=" & request.querystring("id") & "';"" name='submit' value='Send this newsletter'> "
		response.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
		response.write "</td></tr>"
	
	end if
	
	response.write "</table>"
	
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
		
	End If

	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing

End Sub

Sub SendNewsletter()

	' Construct Newsletter Subject 
	
	Dim ConnObj, SQL, Records, EmailSubject, Body, NewsletterEmailAddress, TheBCCList	
	
	SQL = "SELECT * FROM del_Directory_Templates WHERE ID = " & request.querystring("id") 
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)

	If Records.EOF then
	
		response.write "Template Not Found"

	Else
	
		ConstructNewsletter() ' Construct Newsletter Body
	
		EmailSubject = Replace(Records("SubjectLine"),"@DirectoryName@",DirectoryName)
		EmailSubject = Replace(EmailSubject,"@DirectoryURL@",Path2Directory)
		EmailSubject = Replace(EmailSubject,"@DateStamp@",NewsletterDate)
		
		Body = Records("Template")		
		Body = Replace(Body,"@DirectoryName@",DirectoryName)
		Body = Replace(Body,"@DirectoryURL@",Path2Directory)
		Body = Replace(Body,"@DateStamp@",NewsletterDate)
		Body = Replace(Body,"@NewsletterContent@",Content)
		Body = Replace(Body,"<br>",chr(13) & chr(10),1)
		
		' Construct Newsletter To & From Email Addresses
		
		NewsletterEmailAddress = "mailinglist@" & GrabEmailFromDomain(GlobalEmailAddress) 
		
			' Construct BCC List from the mailing list table
			SQL = "SELECT DISTINCT * FROM del_Directory_NewsletterList ORDER BY Created DESC"
			Set Records = ConnObj.Execute(SQL)
			
				If Records.EOF then			
					TheBCCList = GlobalEmailAddress			
				Else			
					Records.MoveFirst
					Do until records.EOF
							TheBCCList = TheBCCList & Records("EmailAddress") & "; "
					Records.MoveNext
					Loop						
				End If
						
			ConnObj.Close
			Set Records = Nothing
			Set ConnObj = Nothing
			
			If EmailObject = "CDONTS" then
				SendWithCDONTS NewsletterEmailAddress,GlobalEmailAddress,EmailSubject,Body,TheBCCList
			ElseIf EmailObject = "ASPMail" then
				SendWithASPMail NewsletterEmailAddress,GlobalEmailAddress,EmailSubject,MailServer,Body,TheBCCList
			ElseIf EmailObject = "JMail" then
				SendWithJMail NewsletterEmailAddress,GlobalEmailAddress,EmailSubject,MailServer,Body,TheBCCList
			ElseIf EmailObject = "ASPEmail" then
				SendWithASPEmail NewsletterEmailAddress,GlobalEmailAddress,EmailSubject,MailServer,Body,TheBCCList
			ElseIf EmailObject = "SA-SMTP" then
				SendWithSASMTP NewsletterEmailAddress,GlobalEmailAddress,EmailSubject,MailServer,Body,TheBCCList
			End If
			
	
	End If


End Sub

Sub ShowSent()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'><b>Newsletter Sent</b></b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"
	
End Sub





%>
