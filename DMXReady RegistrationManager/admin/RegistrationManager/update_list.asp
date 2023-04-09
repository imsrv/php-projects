<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/registrationmanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strCheck, strActivated, strMemberID, strCategoryID, strFirstName, strLastName, strEmailAddress, strMemberStatus
Dim strSQL

Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_registrationmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strCheck = Request(iLoop & ".Check")
strActivated = Request(iLoop & ".Activated")
strMemberID = Request(iLoop & ".MemberID")
strCategoryID = Request(iLoop & ".CategoryID")
strFirstName = Request(iLoop & ".FirstName")
strLastName = Request(iLoop & ".LastName")
strLastName = replace(strLastName, "'", "''")
strEmailAddress = Request(iLoop & ".EmailAddress")
strEmailAddress = replace(strEmailAddress, "'", "''")
strMemberStatus = Request(iLoop & ".MemberStatus")

if strCheck = "Remove" then
strSQL = "DELETE FROM tblMM_Members WHERE MemberID = " & strMemberID
else
strSQL = "UPDATE tblMM_Members SET Activated = '" & strActivated & "'" & " , EmailAddress = '" & strEmailAddress & "'"  & " , FirstName = '" & strFirstName & "'" & " , LastName = '" & strLastName & "'" & " , CategoryID = '" & strCategoryID & "'" & " , MemberStatus = '" & strMemberStatus & "'" &  " WHERE MemberID = " & strMemberID
end if
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("admin.asp")
%>
