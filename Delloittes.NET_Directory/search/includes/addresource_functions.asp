<!--#include file="../email_subs.asp"-->
<%

Dim ContactEmail, ResourceID, ContactName, Title, Description, WebAddress

If Request.QueryString("action") = "add" then ' if this page has loaded from form submission then add info to DB
	AddResource() ' add resource to database
	if SendEmailAfterLinkAddition = True then SendAdditionNotification() ' send notification email 
End If

Sub DrawAddNewResource()

With Response

	.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
	.write "<tr><td class='general_text'>"

	.write "<br>"
	.write "<center>"
	.write "Your listing will be submitted to the following category:<br><br><b>"
	i = 0 
	ConstructCategories ID
	.write TopNavLinks & "</b></font><br><br></center>"
	.write "</td></tr></table>"

	.write "<table width='100%' cellspacing='0' cellpadding='0' Border='0'>"
	.write "<tr><td bgcolor='" & CellSpilt & "'>"

	.write "<form onSubmit='return checkForm(this)' action='add.asp?action=add' method='POST' name='frmAddResource'>"
	.write "<input type='hidden' name='ID' value='" & request.querystring("id") & "'>"
	.write "<input type='hidden' name='ParentID' value='" & request.querystring("parentid") & "'>"

	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Resource Title:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' name='Title' size='44'> <font class='general_text_red'>*</font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td valign='top' bgcolor='" & FormBGColor & "'><font class='form_text'>Description:</font></td>"
	.write "<td bgcolor='" & FormBGColor & "'>"
	.write "<textarea name='description' wrap='physical'"
	.write "onKeyDown='textCounter(this.form.description,this.form.remLen,250);' "
	.write "onKeyUp='textCounter(this.form.description,this.form.remLen,250);' rows='9' cols='39'>"
	.write "</textarea> <font class='general_text_red'>*</font></font><br>"
	.write "<input type='text' class='input' readonly value='250' name='remLen' size='3'> "
	.write "<font class='form_text'> Characters left. 250 Max Characters.</font>"
	.write "</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Resource URL:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' value='http://' name='URL' size='44'> <font class='general_text_red'>*</font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Contact Name:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' value='" & request.cookies("ContactName") & "' name='ContactName' size='44'> <font class='general_text_red'>*</font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Contact Email:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' value='" & request.cookies("ContactEmail") & "' name='ContactEmail' size='44'> <font class='general_text_red'>*</font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>&nbsp;</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'><input type='checkbox' name='REM' value='ON' checked> <font class='form_text'>Remember my contact details for future submissions</font></td>"
	.write "</tr>"
	.write "<tr><td bgcolor='" & FormBGColor & "'>&nbsp;</td>"
	.write "<td bgcolor='" & FormBGColor & "'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='  Submit Resource  '> "
	.write "<input type='reset' class='form_buttons' name='reset' value='Reset'>"
	.write "</td></tr></table>"

	.write "</td></tr></table>"

End With

End Sub

Sub DrawThankYou

	response.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"
	response.write "<font class='general_text'>"
	response.write "Your listing has been submitted. We will review your listing within the next 1-2 days for submission to our directory.<br><br>Thank you for taking the time to submit your site.<br><br>"
	response.write "<a href='default.asp?id=" & ID & "&parentID=" & ParentID & "' class='general_text'><b>Return to Index</b></a>"
	response.write "</font>"
	response.write "</td></tr></table>"

End Sub 

Sub AddResource()
	
	Dim ConnObj, Records, Dupe
	Dim Title, Description, WebAddress, CategoryID, ContactName, ContactEmail
		
	Title = CheckString(trim(request.form("Title")))
	Title = FilterHTML(Title)
	Description = CheckString(trim(request.form("Description")))
	Description = FilterHTML(Description)
	WebAddress = CheckString(trim(request.form("URL")))
	CategoryID = request.form("ID")
	ContactName = trim(request.form("ContactName"))
	ContactEmail = trim(request.form("ContactEmail"))
	if CategoryID = "" then CategoryID = 0		
	
	if request.form("REM") = "ON" then
		response.cookies("ContactName") = ContactName
		response.cookies("ContactName").Expires = now() + 365
		response.cookies("ContactEmail") = ContactEmail
		response.cookies("ContactEmail").Expires = now() + 365
	end if
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")	
	ConnObj.Open MyConnStr
	
		' determine if this is a duplicate URL...
		
		SQL = "SELECT URL FROM del_Directory_Sites WHERE URL = '" & WebAddress & "'"
		if Debug = True then response.write SQL
		Set Records = ConnObj.Execute(SQL)
			If Records.EOF then
			
				if DatabaseType = "Access" then
					Dupe = False
				else
					Dupe = 0
				end if
				
			Else
				
				if DatabaseType = "Access" then
					Dupe = True
				else
					Dupe = 1
				end if
				
			End If
		Set Records = Nothing
	
		' insert resource into database...
		
		SQL = "INSERT INTO del_Directory_Sites (Title, Description, URL, Created, LastAccessed, HitsTodayDate, "
		SQL = SQL & "CategoryID, ContactName, ContactEmail, Favorite, Sponsor, PublishOnWeb, DuplicateURL) VALUES ("
		
		if DatabaseType = "Access" then
			SQL = SQL & "'" & Title & "','" & Description & "','" & WebAddress & "',#" 
			SQL = SQL & ShortDate & "#,#" & ShortDate & "#," & Day(Now()) & "," & CategoryID
			SQL = SQL & ",'" & ContactName & "','" & ContactEmail & "',False,False,False," & Dupe & ")"
		else
			SQL = SQL & "'" & Title & "','" & Description & "','" & WebAddress & "','" 
			SQL = SQL & ShortDateIso & "','" & ShortDateIso & "'," & Day(Now()) & "," & CategoryID
			SQL = SQL & ",'" & ContactName & "','" & ContactEmail & "',0,0,0," & Dupe & ")"		
		end if
		
		if Debug = True then response.write SQL
		
		ConnObj.Execute(SQL)
		
		if DatabaseType = "Access" then
		SQL = "SELECT ID FROM del_Directory_Sites WHERE URL = '" & WebAddress & "' AND Created = #" & ShortDate & "#"
		else
		SQL = "SELECT ID FROM del_Directory_Sites WHERE URL = '" & WebAddress & "' AND Created = '" & ShortDateIso & "'"
		end if
		
		if Debug = True then response.write SQL
		
		Set Records = ConnObj.Execute(SQL)
			If Records.EOF then
				ResourceID = "0"
			Else
				ResourceID = records("ID")
			End If
		Set Records = Nothing
	
	ConnObj.Close
	Set ConnObj = Nothing
	
End Sub

'*************************************
' Get rid of HTML
'*************************************

Function FilterHTML(strToFilter)

  Dim strTemp
  strTemp = strToFilter
  
  While Instr(1,strTemp,"<") AND Instr(1, strTemp, ">")
    strTemp = Left(strTemp, Instr(1, strTemp, "<")-1) & Right(strTemp, Len(strTemp)-Instr(1,strTemp, ">"))
  WEnd
  
  FilterHTML = strTemp
  
End Function

Sub ConstructCategories (theID) 

	Dim ConnObj,CategoryTitle

	if theID <> "" and theID <> "0" then

			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			Set CategoryTitle = ConnObj.Execute(SQL) 
				
			If CategoryTitle.EOF then					
			else	
			
			if i = 0 then
			TopNavLinks = "Home " & NavigationSep & " "
			end if
				
				i = i + 1
			
				if CategoryTitle("ParentID") <> 0 then
					ConstructCategories CategoryTitle("ParentID")
				end if
				
				if CategoryTitle("ParentID") <> 0 then 
				TopNavLinks = TopNavLinks & " " &  NavigationSep & " "
				end if

				TopNavLinks = TopNavLinks & CategoryTitle("CategoryName")

			end if
		
		ConnObj.Close
		Set ConnObj = Nothing
		Set CategoryTitle = Nothing
		
			
	else
	
		TopNavLinks = "Home"
		
	End If
	
	
End Sub

' send resource to me for review with link to review page in dbadmin

Sub SendAdditionNotification()

Dim Body, ContactEmail

ContactEmail = request.form("ContactEmail")

	Body = "Hi," & vbcrlf & vbcrlf 
	Body = Body & "Please review the following directory submission..." & vbcrlf & vbcrlf 
	Body = Body & "Title: " & RemoveQs(request.form("Title")) & vbcrlf
	Body = Body & "Description: " & RemoveQs(request.form("Description")) & vbcrlf 
	Body = Body & "URL: " & RemoveQs(request.form("URL")) & vbcrlf & vbcrlf
	Body = Body & "Logon to the administration centre to approve this review..." & vbcrlf & vbcrlf 
	Body = Body & Path2Admin & vbcrlf & vbcrlf

	If EmailObject = "CDONTS" then
		SendWithCDONTS GlobalEmailAddress,ContactEmail,"Resource Submission...",Body,""
	ElseIf EmailObject = "ASPMail" then
		SendWithASPMail GlobalEmailAddress,ContactEmail,"Resource Submission...",MailServer,Body,""
	ElseIf EmailObject = "JMail" then
		SendWithJMail GlobalEmailAddress,ContactEmail,"Resource Submission...",MailServer,Body,""
	ElseIf EmailObject = "ASPEmail" then
		SendWithASPEmail GlobalEmailAddress,ContactEmail,"Resource Submission...",MailServer,Body,""
	ElseIf EmailObject = "SA-SMTP" then
		SendWithSASMTP GlobalEmailAddress,ContactEmail,"Resource Submission...",MailServer,Body,""
	End If

End Sub


Function RemoveQs(strInput)	
	Dim strTemp	
	strTemp = Replace(strInput, "'", "''")
	RemoveQs = strTemp	
End Function

%>
