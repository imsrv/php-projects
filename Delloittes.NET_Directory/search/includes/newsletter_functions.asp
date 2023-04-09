<!--#include file="../email_subs.asp"-->
<%

' Remember Email Address


Sub DrawNewsletterForm()

	With Response

		.write "<table width='100%' align='center' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"		
		.write "<font class='general_text'>"
		.write "You want all the latest information from our directory, sign-up to our free newsletter.</font>"
		.write "</td></tr></table><img src='images/spacer.gif' width='0' height='10'>"

		.write "<table width='100%' cellpadding='0' align='center' cellspacing='0' bgcolor='" & CellSpilt & "'>"
		.write "<tr><td>"
		.write "<form onSubmit='return checkForm(this)' action='newsletter.asp?action=add&from="
		.write request.querystring("from") & "' method='POST' name='frmNewsletter'>"

			.write "<table cellspacing='1' width='100%' cellpadding='8'>"
			.write "<tr>"
			.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Email Address:</font>"
			.write "</td><td bgcolor='" & FormBGColor & "'>"
			.write "<input type='text' class='input' name='email' size='40' value=''>"			
			.write " <font class='general_text_red'>*</font></td>"
			.write "</tr>"
			.write "<tr>"
			.write "<td bgcolor='" & FormBGColor & "'>&nbsp;</td>"
			.write "<td bgcolor='" & FormBGColor & "'>"
			.write "<input type='submit' class='form_buttons' name='submit' value='Sign-Up'> "
			.write "<input type='button' class='form_buttons' onClick='RemoveFromNewsletter(frmNewsletter)' value='Unsubscribe'>"
			.write "</td></tr></table>"

		.write "</td></form></tr></table>"
		.write "<script>frmNewsletter.email.focus()</script>"

	End With

End Sub

Sub CheckAddEmailAddress()

	Dim ConnObj, SQL, Records

	SQL = "SELECT EmailAddress FROM del_Directory_NewsletterList WHERE EmailAddress = '" & trim(request.form("email")) & "'"
	if Debug = True then response.write SQL
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)
	
		If Records.EOF then ' if not found then address to mailing
		
			SQL = "INSERT INTO del_Directory_NewsletterList (EmailAddress, Created)"
			SQL = SQL & " VALUES "
			SQL = SQL & "('" & trim(request.form("email")) & "',"
			
				if DatabaseType = "Access" then 
					SQL = SQL & "#" & shortdate & "#)"
				else
					SQL = SQL & "'" & ShortDateIso & "')"
				end if
				
			if Debug = True then response.write SQL
			
			ConnObj.Execute(SQL)
			
			With Response
			
				.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
				"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
				"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"
				.write "<font class='general_text'>"
				.write "<b>Thank you. Your email address has been added to our mailing list.</b>"
				.write "</font>"
				.write "</td></tr></table>"
			
			End With
		
		Else
		
			With Response
			
				.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
				"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
				"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"
				.write "<font class='general_text_red'><b>"
				.write "<img src='images/warning.gif' align='absmiddle'> Your email address is already subscribed to our newsletter.</b></font>"
				.write "</td></tr></table>"
			
			End With
			
			DrawNewsletterForm()

		End If	
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing
	
	
End Sub

Sub CheckRemoveEmailAddress()

	SQL = "SELECT EmailAddress FROM del_Directory_NewsletterList WHERE EmailAddress = '" & trim(request.querystring("email")) & "'"
	if Debug = True then response.write SQL
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)
	
		If Records.EOF then ' if not found then address to mailing
		
			response.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
			"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
			"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"
			response.write "<font class='general_text_red'><b>"
			response.write "<img src='images/warning.gif' align='absmiddle'> Sorry your email address could not be found within our database.</b>"
			response.write "</font>"
			response.write "</td></tr></table>"
			
			DrawNewsletterForm()
		
		Else
		
			SQL = "DELETE FROM del_Directory_NewsletterList WHERE EmailAddress = '" & trim(request.querystring("email")) & "'"
			ConnObj.Execute(SQL)
		
			response.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
			"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
			"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"
			response.write "<font class='general_text'>"
			response.write "<b>Your email address has been removed from our mailing list.</b>"
			response.write "</font>"
			response.write "</td></tr></table>"
			
			DrawNewsletterForm()
		
		End If	
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing
	
	
End Sub



%>

