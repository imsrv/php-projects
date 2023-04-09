<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/contactusmanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strCheck, strActivated, strContactID, strCategoryID, strFirstName, strLastName, strEmailAddress
Dim strSQL

Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_contactusmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strCheck = Request(iLoop & ".Check")
strActivated = Request(iLoop & ".Activated")
strContactID = Request(iLoop & ".ContactID")
strCategoryID = Request(iLoop & ".CategoryID")
strFirstName = Request(iLoop & ".FirstName")
strLastName = Request(iLoop & ".LastName")
strEmailAddress = Request(iLoop & ".EmailAddress")

if strCheck = "Remove" then
strSQL = "DELETE FROM tblContactUs WHERE ContactID = " & strContactID
else
strSQL = "UPDATE tblContactUs SET Activated = '" & strActivated & "'" & " , EmailAddress = '" & strEmailAddress & "'"  & " , FirstName = '" & strFirstName & "'" & " , LastName = '" & strLastName & "'" & " , CategoryID = '" & strCategoryID & "'" & " WHERE ContactID = " & strContactID
end if
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("admin.asp")
%>
