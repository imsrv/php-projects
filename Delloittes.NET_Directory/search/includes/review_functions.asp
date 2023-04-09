<!--#include file="../email_subs.asp"-->
<%

'*************************************
' Add review to database and send optional
' email notification
'*************************************

Dim SiteID

if Request.Querystring("action") = "addreview" and request.servervariables("REQUEST_METHOD") = "POST" then ' if this page has loaded from form submission then add info to DB
	SiteID = request.form("SiteID")
	AddReviewToDatabase
	if SendEmailAfterReviewSubmission = True then SendEmailReviewNotification()
else
	SiteID = Request.QueryString("SiteID")
end if

'*************************************
' End of add review to database
'*************************************

Sub SendEmailReviewNotification()

	Dim Body, EmailsFrom, EmailSubject

	Body = "Hi," & vbcrlf & vbcrlf 
	Body = Body & "A user has submitted a review of a resource..." & vbcrlf & vbcrlf 
	Body = Body & "FullName: " & CheckString(request.form("FullName")) & vbcrlf
	Body = Body & "EmailAddress: " & CheckString(lcase(request.form("EmailAddress"))) & vbcrlf 
	Body = Body & "Review: " & CheckString(request.form("Comments")) & vbcrlf & vbcrlf
	Body = Body & "Logon to the administration centre to approve this review..." & vbcrlf & vbcrlf 
	Body = Body & Path2Admin & vbcrlf & vbcrlf 
	
	EmailsFrom = "reviewsubmissions@" & GrabEmailFromDomain(GlobalEmailAddress) 
	EmailSubject = DirectoryName & " Review Submission"
	
	If EmailObject = "CDONTS" then
		SendWithCDONTS GlobalEmailAddress,EmailsFrom,EmailSubject,Body, ""
	ElseIf EmailObject = "ASPMail" then
		SendWithASPMail GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body, ""
	ElseIf EmailObject = "JMail" then
		SendWithJMail GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body, ""
	ElseIf EmailObject = "ASPEmail" then
		SendWithASPEmail GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body, ""
	Elseif EmailObject = "SA-SMTP" then
		SendWithSASMTP GlobalEmailAddress,EmailsFrom,EmailSubject,MailServer,Body, ""
	End If


End Sub

Sub AddReviewToDatabase()

	Dim ConnObj, SQL, Records

	SQL = "INSERT INTO del_Directory_Reviews (SiteID, Title, FullName, EmailAddress, Comments, Rated, PublishOnWeb, Created)"
	SQL = SQL & " VALUES "
	SQL = SQL & "(" & SiteID & ",'" & CheckString(request.form("Title")) & "','"
	SQL = SQL & CheckString(request.form("FullName")) & "','" & CheckString(lcase(request.form("EmailAddress")))
	SQL = SQL & "','" & CheckString(request.form("Comments")) & "'," 
	
	If DatabaseType = "Access" then
		SQL = SQL & request.form("Rating") & ",False,#" & ShortDate & "#)"	
	else
		SQL = SQL & request.form("Rating") & ",0,'" & ShortDateIso & "')"	
	end if
	
	if Debug = True then response.write SQL	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)
	ConnObj.Close
	Set Records = Nothing
	Set ConnObj = Nothing
	
End Sub

Sub DrawReviewForm()

With Response

	.write "<br><table width='97%' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "' align='center'><tr><td class='general_text'>"
	.write "To add your review of the above resource please complete the form below. All reviews are screened before they are set live. Any malicious, vulgar, or unsubstantiated reviews will be removed."
	.write "</td></tr></table><br>"

		.write "<table width='97%' align='center' cellpadding='0' cellspacing='0'  bgcolor='" & CellSpilt & "'>"
		.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='review.asp?id=" & id & "&parentid=" & parentid & "&siteid=" & SiteID & "&action=addreview' method='POST' name='frmAddReview'>"
	
	.write "<input type='hidden' name='ID' value='" & ID & "'>"
	.write "<input type='hidden' name='ParentID' value='" & ParentID & "'>"
	.write "<input type='hidden' name='SiteID' value='" & SiteID & "'>"

		.write "<table cellspacing='1' width='100%' cellpadding='8'>"
		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Review Title:</font>"
		.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' name='Title' size='44'> <font class='general_text_red'>*</font></td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Full Name:</font>"
		.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' name='FullName' size='44'> <font class='general_text_red'>*</font></td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Email Address or URL:</font>"
		.write "</td><td bgcolor='" & FormBGColor & "'><input type='text' class='input' name='EmailAddress' size='44'></td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td valign='top' bgcolor='" & FormBGColor & "'><font class='form_text'>Your Comments:</font></td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<textarea name='Comments' wrap='physical'"
		.write "onKeyDown='textCounter(this.form.Comments,this.form.remLen,250);' "
		.write "onKeyUp='textCounter(this.form.Comments,this.form.remLen,250);' rows='9' cols='39'>"
		.write "</textarea></font> <font class='general_text_red'>*</font><br>"
		.write "<input type='text' class='input' readonly value='250' name='remLen' size='3'> "
		.write "<font class='form_text'> Characters left. 250 Max Characters.</font>"
		.write "</td>"
		.write "</tr>"
		.write "<tr>"
		.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Your Rating:</font></td>"
		.write "<td bgcolor='" & FormBGColor & "'><select name='Rating'>"
		.write "<option value='5'>5 Stars - Best Rating</option>"
		.write "<option value='4'>4 Stars </option>"
		.write "<option value='3' selected>3 Stars</option>"
		.write "<option value='2'>2 Stars</option>"
		.write "<option value='1'>1 Star - Worst Rating</option>"
		.write "</select> <font class='general_text_red'>*</font></td>"
		.write "</tr><tr>"
		.write "<td bgcolor='" & FormBGColor & "'>&nbsp;</td>"
		.write "<td bgcolor='" & FormBGColor & "'>"
		.write "<input type='submit' class='form_buttons' name='submit' value='Add your review'> "
		.write "<input type='reset' class='form_buttons' name='reset' value='Reset'>"
		.write "</td></tr></table>"

	.write "</td></tr></table>"

End With

End Sub

Sub DrawThankYou
	
	With Response
	
		.write "<br><table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
		.write "<tr><td class='general_text'>"
		.write "Thank you, your review has been submitted. We will screen your review within 48 hours.<br><br>"
		.write "<a class='general_text' href='default.asp?id=" & ID & "&parentID=" & ParentID & "'><b>Return to Index</b></a> | "
		.write "<a class='general_text' href='default.asp'><b>Return Home</b></a>"
		.write "</td></tr></table>"
	
	End With
	
End Sub 

Sub DrawVisitorsReviews(ListingID)

	Dim ConnObj, SQL, TheReviews
	
	If DatabaseType = "Access" then
		SQL = "SELECT * FROM del_Directory_Reviews WHERE SiteID = " & ListingID & " AND PublishOnWeb = True ORDER BY Created ASC"
	Else
		SQL = "SELECT * FROM del_Directory_Reviews WHERE SiteID = " & ListingID & " AND PublishOnWeb = 1 ORDER BY Created ASC"
	End If
	
	if Debug = True then response.write SQL
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheReviews = ConnObj.Execute(SQL)
	
	If TheReviews.EOF OR TheReviews.BOF then 
	
	else
	
		TheReviews.MoveFirst
			Do Until TheReviews.EOF 
			
			With Response
			
			.write "<table width='97%' align='center' cellpadding='0' cellspacing='1'  bgcolor='" & CellSpilt & "'>"
			.write "<tr><td>"
			
					.write "<table cellspacing='0' width='100%' cellpadding='" & CellPadding & "'>"
					.write "<tr><td bgcolor='" & CellBGColor & "'>"
					.write "<font class='general_text'><b>"
					.write TheReviews("Title") 
					.write "</b></font>"
					.write "</td><td bgcolor='" & CellBGColor & "' align='right'>"
					.write "<img src='" & Path2Directory & "images/rating.gif'>&nbsp;&nbsp;" 
					 DrawReviewerRating TheReviews("Rated")
					.write "</td></tr>"		
					.write "<tr><td colspan='2' bgcolor='" & CellSpilt & "'></td></tr>"			
					.write "<tr><td bgcolor='#ffffff'>"
					.write "<font class='small_listing_description'>"
					.write "Written by " & TheReviews("FullName") 
						 if TheReviews("EmailAddress") <> "" then
						 	
							if Instr(1,TheReviews("EmailAddress"),"@",1) then
								.write " - <i>[ <a href='mailto:" & TheReviews("EmailAddress") & "' class='search_results_category'>" 
							else
								.write " - <i>[ <a href='" & TheReviews("EmailAddress") & "' class='search_results_category'>" 	
							end if
						
						.write TheReviews("EmailAddress") & "</a> ]</i>"
						 end if 
					.write "</font>"
					.write "</td><td bgcolor='#ffffff' align='right'>"
					.write "<font class='small_listing_description'>"
					.write "Added: " & FormatDateTime(TheReviews("Created"),2) 
					.write "</font>"
					.write "<tr><td colspan='2' bgcolor='#ffffff'>"
					.write "<font class='general_text'>"
					.write TheReviews("Comments")
					.write "</font>"
					.write "</td></tr></table>"
					
			.write "</td></tr></table><br>"
			
			End With
			
		TheReviews.MoveNext
		Loop
		
	End If
	
	response.write "<table width='97%' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td class='general_text'>"	
	response.write "<a class='general_text' href='review.asp?id=" & ID 
	response.write "&parentID=" & parentID & "&siteid=" & ListingID & "'>"
	response.write "<b>Add Your Review</b></a></font></td></tr></table><br>"
	
	Set TheReviews = Nothing
	ConnObj.Close 

End Sub

Sub DrawReviewerRating(Rated)

	if Rated = 1 then	
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 2 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 3 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 4 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 5 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'>"
	else
	response.write "<img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"	
	end if 

End Sub

%>
