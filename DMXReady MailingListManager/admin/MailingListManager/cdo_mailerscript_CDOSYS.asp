<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/mailinglistmanager.asp" -->
<%
'Set the response buffer to false as we may need to puase while the e-mails are being sent
Response.Buffer = False

'Set the script timeout to 90 minutes incase there are lots of e-mails to send
Server.ScriptTimeout = 5400
%>
<%
Dim preferences
Dim preferences_numRows

Set preferences = Server.CreateObject("ADODB.Recordset")
preferences.ActiveConnection = MM_mailinglistmanager_STRING
preferences.Source = "SELECT *  FROM tblMailingListManagerPreferences"
preferences.CursorType = 0
preferences.CursorLocation = 2
preferences.LockType = 1
preferences.Open()

preferences_numRows = 0
%>
<%
'******************************************************
'Set Global Variables
'******************************************************
	dim strFrom, strSubject, strBody, strPriority, strCC, strBCC, strDate,  strText, strBodyFormat, strMailFormat
	strFrom= Request.Form("txtFrom")
	strSubject= Request.Form("txtSubject")
	strBody= Request.Form("txtBody")
	strPriority= Request.Form("txtPriority")
	strCC= Request.Form("txtCC")
	strBCC= Request.Form("txtBCC")
	strDate= Now()
	strText= "---------------------------------------------------------------"
	strBodyFormat = Request.Form("strBodyFormat")
	strMailFormat = Request.Form("strMailFormat") 
	strRemoveLink = preferences.Fields.Item("UnsubscribeLink").Value
%>
<%
If Request.Form("send_test") = "Send Test Email" Then
  '******************************************************
'SEND PREVIEW
'******************************************************
	'Display a message on the screen incase the user thinks nothing is happening and hits refresh sending the e-mail's twice
Response.Write("<link href=""../styles.css"" rel=""stylesheet"" type=""text/css""><table width=""100%"" border=""0"" cellspacing=""0"" cellpadding=""10"" class=""tableborder""><tr><td><div align=""center""><b><font size=""3"">The e-mail's are being sent<br>Do not Hit refresh or some members will receive the same e-mail twice!</font></b><br><br>Please be patient as this may take some time depending on the speed of the mail server and how many e-mail's there are to send.<br>")
	
	'Display the number of e-mails sent and how many left to send
Response.Write("<form name=""frmSent"">There are <input type=""text"" size=""3"" name=""sent"" value=""0""> e-mail's sent out of a total of 1 </form><p><a href=""admin.asp"">Home</a></p></div></td></tr></table>")

dim strSentLoopCounterPrev, strEmailPrev, strFooterPrev
		'loop counter to count how many e-mails have been sent
		strSentLoopCounterPrev = strSentLoopCounterPrev + 1
		strEmailPrev = preferences.Fields.Item("TestEmailAddress").Value
		'Update the text box displaying the number of e-mails sent
		Response.Write(vbCrLf & "<script langauge=""JavaScript"">document.frmSent.sent.value = " & strSentLoopCounterPrev & ";</script>")
If request.form("type") = "html" Then
strFooterPrev = "<a href = " & strRemoveLink & "?email=" & strEmailPrev & ">Click Here</a> to be removed from our mailing list <br>"  & vbCrLf
strBodyPrevHTML = strDate & "<br><br>" & vbCrLf _
					& strText & "<br><br>" & vbCrLf _
					& strBody & "<br><br>" & vbCrLf _
					& "<br><br>" & vbCrLf _
					& strText & vbCrLf _
					& "<br><br>" & vbCrLf _
					& strFooterPrev & vbCrLf _
					& "<br><br>" & vbCrLf
else
strFooterPrev = "Click on the link to be removed from our mailing list " & strRemoveLink & "?email=" & strEmailPrev & vbCrLf					 
strBodyPrevTEXT = strDate & vbCrLf _
					& vbCrLf _
					& strText & vbCrLf _
					& vbCrLf _
					& strBody & vbCrLf _
					& vbCrLf _
					& strText & vbCrLf _ 
					& strFooterPrev & vbCrLf
					End if

' Send Email to Member 
Set objCDOPreview = Server.CreateObject("CDO.Message")
Set objCDOSYSConPreview = Server.CreateObject ("CDO.Configuration") 
Set Flds = objCDOSYSConPreview.Fields

'Out going SMTP server 
objCDOSYSConPreview.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
objCDOSYSConPreview.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
objCDOSYSConPreview.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSConPreview.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSConPreview.Fields.Update 

set objCDOPreview.Configuration = objCDOSYSConPreview


objCDOPreview.To = strEmailPrev
objCDOPreview.From = strFrom
objCDOPreview.CC = strCC
objCDOPreview.BCC = strBCC
objCDOPreview.Subject = strSubject
objCDOPreview.TextBody = strBodyPrevTEXT
objCDOPreview.HTMLBody = strBodyPrevHTML
objCDOPreview.Send()
'Cleanup and Close DB
Set objCDOPreview = Nothing
End If
%>
<%
'******************************************************
'SEND TO ALL MEMBERS
'******************************************************
If Request.Form("send_all") = "Send to All Members" Then
%>
<%
Dim ListRS__value1
ListRS__value1 = "%"
If (Request.QueryString("email")    <> "") Then 
  ListRS__value1 = Request.QueryString("email")   
End If
%>
<%
Dim ListRS
Dim ListRS_numRows

Set ListRS = Server.CreateObject("ADODB.Recordset")
ListRS.ActiveConnection = MM_mailinglistmanager_STRING
ListRS.Source = "SELECT *  FROM tblMemberList  WHERE Activated = 'True' AND EmailAddress LIKE '" + Replace(ListRS__value1, "'", "''") + "'"
ListRS.CursorType = 0
ListRS.CursorLocation = 2
ListRS.LockType = 1
ListRS.Open()

ListRS_numRows = 0
%>
<%
Dim TotalRecords__value1
TotalRecords__value1 = "%"
If (Request.QueryString("email") <> "") Then 
  TotalRecords__value1 = Request.QueryString("email")
End If
%>
<%
Dim TotalRecords
Dim TotalRecords_numRows

Set TotalRecords = Server.CreateObject("ADODB.Recordset")
TotalRecords.ActiveConnection = MM_mailinglistmanager_STRING
TotalRecords.Source = "SELECT Count(MemberID) AS TotalMembers  FROM tblMemberList  WHERE Activated = 'True' AND EmailAddress LIKE '" + Replace(TotalRecords__value1, "'", "''") + "'"
TotalRecords.CursorType = 0
TotalRecords.CursorLocation = 2
TotalRecords.LockType = 1
TotalRecords.Open()

TotalRecords_numRows = 0
%>
<%
Dim TotalMembers
' set the record count
TotalMembers = TotalRecords.Fields.Item("TotalMembers").Value

'******************************************************
'getting variables from mail set-up page and creating others
'******************************************************
	'Display a message on the screen incase the user thinks nothing is happening and hits refresh sending the e-mail's twice
	If NOT ListRS.EOF Then Response.Write("<link href=""../styles.css"" rel=""stylesheet"" type=""text/css""><table width=""100%"" border=""0"" cellspacing=""0"" cellpadding=""10"" class=""tableborder""><tr><td><div align=""center""><b><font size=""3"">The e-mail's are being sent<br>Do not Hit refresh or some members will receive the same e-mail twice!</font></b><br><br>Please be patient as this may take some time depending on the speed of the mail server and how many e-mail's there are to send.<br>")
	
	'Display the number of e-mails sent and how many left to send
	Response.Write("<form name=""frmSent"">There are <input type=""text"" size=""3"" name=""sent"" value=""0""> e-mail's sent out of a total of " & TotalMembers & "</form><p><a href=""admin.asp"">Home</a></p></div></td></tr></table>")
While Not ListRS.EOF

dim SentLoopCounter, strEmail, strFooter
		'loop counter to count how many e-mails have been sent
		SentLoopCounter = SentLoopCounter + 1
		strEmail = ListRS("EmailAddress")
		
		'Update the text box displaying the number of e-mails sent
		Response.Write(vbCrLf & "<script langauge=""JavaScript"">document.frmSent.sent.value = " & SentLoopCounter & ";</script>")

If request.form("type") = "html" Then
strFooter = "<a href = " & preferences.Fields.Item("UnsubscribeLink").Value & "?email=" & strEmail & ">Click Here</a> to be removed from our mailing list <br>"  & vbCrLf
strBodyNewHTML = strDate & "<br><br>" & vbCrLf _
					& strText & "<br><br>" & vbCrLf _
					& strBody & "<br><br>" & vbCrLf _
					& "<br><br>" & vbCrLf _
					& strText & vbCrLf _
					& "<br><br>" & vbCrLf _
					& strFooter & vbCrLf _
					& "<br><br>" & vbCrLf
					End If
If not request.form("type") = "html" Then
strFooter = "Click on the link to be removed from our mailing list " & strRemoveLink & "?email=" & strEmail & vbCrLf					 
strBodyNewTEXT = strDate & vbCrLf _
					& vbCrLf _
					& strText & vbCrLf _
					& vbCrLf _
					& strBody & vbCrLf _
					& vbCrLf _
					& strText & vbCrLf _ 
					& strFooter & vbCrLf
					End if

Set objCDO = Server.CreateObject("CDO.Message")
Set objCDOSYSCon = Server.CreateObject ("CDO.Configuration") 
Set Flds = objCDOSYSCon.Fields

'Out going SMTP server 
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2 
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSCon.Fields.Update 

set objCDO.Configuration = objCDOSYSCon

objCDO.To = strEmail
objCDO.From = strFrom
objCDO.CC = strCC
objCDO.BCC = strBCC
objCDO.TextBody = strBodyNewTEXT
objCDO.HTMLBody = strBodyNewHTML
objCDO.Subject = strSubject
objCDO.Send()
'Cleanup and Close DB
Set objCDO = Nothing
%>
<%
Dim EmailSendQTY
EmailSendQTY = ListRS.Fields.Item("SentMessages").Value + 1
%>
<%
if(strDate <> "") then updatesentdate__value1 = strDate
if(strEmail <> "") then updatesentdate__value2 = strEmail
if(EmailSendQTY <> "") then updatesentdate__value3 = EmailSendQTY
%>
<%
set updatesentdate = Server.CreateObject("ADODB.Command")
updatesentdate.ActiveConnection = MM_mailinglistmanager_STRING
updatesentdate.CommandText = "UPDATE tblMemberList  SET LastMessageDate = '" + Replace(updatesentdate__value1, "'", "''") + "', SentMessages = '" + Replace(updatesentdate__value3, "'", "''") + "' WHERE EmailAddress ='" + Replace(updatesentdate__value2, "'", "''") + "'"
updatesentdate.CommandType = 1
updatesentdate.CommandTimeout = 0
updatesentdate.Prepared = true
updatesentdate.Execute()
%>
<%
	  ListRS.MoveNext
  Wend
%>
<%
if(strBody <> "") then COMInsertactivity__value1 = strBody
if(strSubject <> "") then COMInsertactivity__value2 = strSubject
if(TotalMembers <> "") then COMInsertactivity__value3 = TotalMembers
%>
<%
set COMInsertactivity = Server.CreateObject("ADODB.Command")
COMInsertactivity.ActiveConnection = MM_mailinglistmanager_STRING
COMInsertactivity.CommandText = "INSERT INTO tblMailingListActivity (EmailMessageBody, EmailMessageSubject, EmailCount)  VALUES ('" + Replace(COMInsertactivity__value1, "'", "''") + "', '" + Replace(COMInsertactivity__value2, "'", "''") + "', " + Replace(COMInsertactivity__value3, "'", "''") + ") "
COMInsertactivity.CommandType = 1
COMInsertactivity.CommandTimeout = 0
COMInsertactivity.Prepared = true
COMInsertactivity.Execute()
%>
<%
ListRS.Close()
Set ListRS = Nothing
%>
<%
TotalRecords.Close()
Set TotalRecords = Nothing
%>
<% End If %>
<%
preferences.Close()
Set preferences = Nothing
%>
