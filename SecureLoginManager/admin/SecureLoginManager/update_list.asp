<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/secureloginmanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strCheck, strActivated, strMemberID, strFirstName, strLastName, strEmailAddress, strUserName, strPassword1, strSecurityLevelID
Dim strSQL

Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_secureloginmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strCheck = Request(iLoop & ".Check")
strActivated = Request(iLoop & ".Activated")
strMemberID = Request(iLoop & ".MemberID")
strFirstName = Request(iLoop & ".FirstName")
strLastName = Request(iLoop & ".LastName")
strLastName = replace(strLastName, "'", "''")
strEmailAddress = Request(iLoop & ".EmailAddress")
strEmailAddress = replace(strEmailAddress, "'", "''")
strUsername = Request(iLoop & ".UserName")
strPassword1 = Request(iLoop & ".Password1")
strSecurityLevelID = Request(iLoop & ".SecurityLevelID")

if strCheck = "Remove" then
strSQL = "DELETE FROM tblMM_Members WHERE MemberID = " & strMemberID
else
strSQL = "UPDATE tblMM_Members SET Activated = '" & strActivated & "'" & " , EmailAddress = '" & strEmailAddress & "'"  & " , FirstName = '" & strFirstName & "'" & " , LastName = '" & strLastName & "'" &  ", UserName = '" & strUserName & "'"  &  ", SecurityLevelID = '" & strSecurityLevelID & "'"& ", Password1 = '" & strPassword1 & "'" & " WHERE MemberID = " & strMemberID
end if
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("admin.asp")
%>
