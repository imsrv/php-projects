<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/mailinglistmanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strActivated, strID, strCheck, strEmailAddress
Dim strSQL

Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_mailinglistmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strCheck = Request(iLoop & ".Check")
strActivated = Request(iLoop & ".Activated")
strID = Request(iLoop & ".ID")
strEmailAddress = Request(iLoop & ".EmailAddress")

if strCheck = "Remove" then
strSQL = "DELETE FROM tblMemberList WHERE MemberID = " & strID
else
strSQL = "UPDATE tblMemberList SET Activated = '" & strActivated & "'" & " , EmailAddress = '" & strEmailAddress & "'" & " WHERE MemberID = " & strID
end if
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("admin.asp")
%>