
<% 

'*****************************************
' Subs for the settings.asp page
'*****************************************

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/prop.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Directory Settings</font>"
	response.write "</td></tr>"
	response.write "<tr><td bgcolor='#BD0021'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Control global behaviours and modify settings for the directory."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DrawSettingsForm()

 Dim ConfigConnectionObj, SQL, ConfigurationRecords, num

 SQL = "SELECT * FROM del_Directory_Configuration WHERE ID = 1"
 Set ConfigConnectionObj = Server.CreateObject("ADODB.Connection")
 ConfigConnectionObj.Open MyConnStr	
 Set ConfigurationRecords = ConfigConnectionObj.Execute(SQL)
	
	if ConfigurationRecords.EOF then
	
	else
	
	With Response
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='settings.asp?action=update' method='POST' name='frmResourceEdit'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr><td bgcolor='#E8E8E8' colspan='2'><font class='page_header'>General Settings</b></td></tr>"
	.write "<tr>"
	.write "<td width='30%' bgcolor='#F9F9F9'><font class='form_text'>Directory Name:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & ConfigurationRecords("DirectoryName") & "' class='input' name='directoryname' size='40'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Navigation Separator:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"
	
		.write "<select name='navsep' size='1'>"
	        .write "<option selected value=':'"
		if ConfigurationRecords("NavigationSeperator") = ":" then .write " selected"
		.write ">:</option>"
	        .write "<option value='/'"
		if ConfigurationRecords("NavigationSeperator") = "/" then .write " selected"
		.write ">/</option>"
	        .write "<option value='\'"
		if ConfigurationRecords("NavigationSeperator") = "\" then .write " selected"
		.write ">\</option>"
		.write "<option value='-'"
		if ConfigurationRecords("NavigationSeperator") = "-" then .write " selected"
		.write ">-</option>"
	        .write "<option value='&gt;'"
		if ConfigurationRecords("NavigationSeperator") = ">" then .write " selected"
		.write ">&gt;</option>"
		.write "</select>"

	.write "</td>"
	.write "</tr>"

	.write "<tr><td bgcolor='#E8E8E8' colspan='2'><font class='page_header'>Homepage Settings</b></td></tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>How many ""Latest Addition""<br> links to show on homepage:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='newlinks' size='1'>"	
	for num = 5 to 50 step + 5
        .write "<option value='" & num & "'"
	if num = cint(ConfigurationRecords("HowManyNewLinksToShow")) then .write " selected"
	.write ">" & num & "</option>"
	next		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>How many ""Popular Resource""<br> links to show on homepage:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='popularlinks' size='1'>"	
	for num = 1 to 20 step + 1
        .write "<option value='" & num & "'"
	if num = cint(ConfigurationRecords("HowManyPopularLinksToShow")) then .write " selected"
	.write ">" & num & "</option>"
	next		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr><td bgcolor='#E8E8E8' colspan='2'><font class='page_header'>Directory Settings</b></td></tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Amount of sub items to<br> show under categories:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='subitemstoshow' size='1'>"	
	for num = 1 to 20 step + 1
        .write "<option value='" & num & "'"
	if num = cint(ConfigurationRecords("ShowSubCategoryCount")) then .write " selected"
	.write ">" & num & "</option>"
	next		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Directory results per page:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='linksperpagedir' size='1'>"	
	for num = 5 to 100 step + 5
        .write "<option value='" & num & "'"
	if num = cint(ConfigurationRecords("LinksPerPage")) then .write " selected"
	.write ">" & num & "</option>"
	next		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Search results per page:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='linksperpagesearch' size='1'>"	
	for num = 5 to 100 step + 5
        .write "<option value='" & num & "'"
	if num = cint(ConfigurationRecords("SearchResultsPerPage")) then .write " selected"
	.write ">" & num & "</option>"
	next		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Number of latest additions within newsletter:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='newsletteritems' size='1'>"	
	for num = 5 to 100 step + 5
        .write "<option value='" & num & "'"
	if num = cint(ConfigurationRecords("HowManyResourcesInNewsletter")) then .write " selected"
	.write ">" & num & "</option>"
	next		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"

	.write "<tr><td bgcolor='#E8E8E8' colspan='2'><font class='page_header'>Email Settings</b></td></tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Email Component:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='emailcom' size='1'>"
	
        .write "<option value='CDONTS'"
	if ConfigurationRecords("EmailObjectToUse") = "CDONTS" then .write " selected"
	.write ">CDONTS (Microsoft)</option>"
	
        .write "<option value='ASPMail'"
	if ConfigurationRecords("EmailObjectToUse") = "ASPMail" then .write " selected"
	.write ">ASPMail (ServerObjects)</option>"
	
        .write "<option value='JMail'"
	if ConfigurationRecords("EmailObjectToUse") = "JMail" then .write " selected"
	.write ">JMail (Dimac)</option>"
	
		.write "<option value='ASPEmail'"
	if ConfigurationRecords("EmailObjectToUse") = "ASPEmail" then .write " selected"
	.write ">ASPEmail (Persits Software)</option>"
	
		.write "<option value='SA-SMTP'"
	if ConfigurationRecords("EmailObjectToUse") = "SA-SMTP" then .write " selected"
	.write ">SA-SMTP (SoftwareArtisans)</option>"
	
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Send email alert for<br>resource submissions:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' "
	if ConfigurationRecords("SendEmailAfterLinkAddition") = True then .write "Checked "
	.write " name='emailforresourcesubmission'><font class='general_small_text'><i>"
	.write "(Tick to send a notification email when a resource is submitted)</i></font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Send email alert for<br>review submissions:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' "
	if ConfigurationRecords("SendEmailAfterReviewSubmission") = True then .write "Checked "
	.write " name='emailforreviewsubmission'><font class='general_small_text'><i>"
	.write "(Tick to send a notification email when a review is submitted)</i></font></td>"
	.write "</tr>"	
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Send email alert for<br>error submissions:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' "
	if ConfigurationRecords("SendEmailAfterErrorSubmission") = True then .write "Checked "
	.write " name='emailforerrorsubmission'><font class='general_small_text'><i>"
	.write "(Tick to send a notification email when a error report is submitted)</i></font></td>"
	.write "</tr>"	
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Your Email Address:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & ConfigurationRecords("EmailAddress") & "' class='input' name='emailaddress' size='40'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>SMTP MailServer:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & ConfigurationRecords("MailServer") & "' class='input' name='mailserver' size='40'> *<br><br><font class='general_small_text'>Note : If your SMTP server requires authentication please see the notes within email_subs.asp within the root directory folder to enable SMTP authentication.</td>"
	.write "</tr>"

	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Settings'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

	end if
	
 Set ConfigurationRecords = Nothing
 ConfigConnectionObj.Close

End Sub

Sub ShowSave()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'>"
	response.write "<b>Settings Saved</b>"
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub UpdateConfig()
	
	Dim ConnObj, SQL
	Dim emailforresourcesubmission, emailforreviewsubmission, emailforerrorsubmission

	If request.form("emailforresourcesubmission") = "ON" then		
		if DatabaseType = "Access" then
			emailforresourcesubmission = True
		else
			emailforresourcesubmission = 1
		end if		
	else		
		if DatabaseType = "Access" then
			emailforresourcesubmission = false
		else
			emailforresourcesubmission = 1
		end if		
	end if
	
	If request.form("emailforreviewsubmission") = "ON" then	
		if DatabaseType = "Access" then
			emailforreviewsubmission = True
		else
			emailforreviewsubmission = 1
		end if		
	else		
		if DatabaseType = "Access" then
			emailforreviewsubmission = false
		else
			emailforreviewsubmission = 0
		end if		
	end if
	
	If request.form("emailforerrorsubmission") = "ON" then	
		if DatabaseType = "Access" then
			emailforerrorsubmission = True
		else
			emailforerrorsubmission = 1
		end if					
	else		
		if DatabaseType = "Access" then		
			emailforerrorsubmission = false
		else
			emailforerrorsubmission = 0
		end if
	end if

	SQL = "UPDATE del_Directory_Configuration SET DirectoryName = '" & CheckString(request.form("directoryname")) & "', "
	SQL = SQL & "NavigationSeperator = '" & request.form("navsep") & "', "
	SQL = SQL & "ShowSubCategoryCount = " & request.form("subitemstoshow") & ", "
	SQL = SQL & "EmailObjectToUse = '" & request.form("emailcom") & "', "
	SQL = SQL & "MailServer = '" & CheckString(request.form("mailserver")) & "', "
	SQL = SQL & "SendEmailAfterLinkAddition = " & emailforresourcesubmission & ", "
	SQL = SQL & "SendEmailAfterReviewSubmission = " & emailforreviewsubmission & ", "
	SQL = SQL & "SendEmailAfterErrorSubmission = " & emailforerrorsubmission & ", "
	SQL = SQL & "EmailAddress = '" & CheckString(request.form("emailaddress")) & "', "
	SQL = SQL & "HowManyNewLinksToShow = " & request.form("newlinks") & ", "
	SQL = SQL & "HowManyPopularLinksToShow = " & request.form("popularlinks") & ", "
	SQL = SQL & "HowManyResourcesInNewsletter = " & request.form("newsletteritems") & ", "
	SQL = SQL & "LinksPerPage = " & request.form("linksperpagedir") & ", "
	SQL = SQL & "SearchResultsPerPage = " & request.form("linksperpagesearch")
	SQL = SQL & " WHERE ID = 1" 
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)	
	ConnObj.Close
	Set ConnObj = Nothing
		
End Sub

%>
