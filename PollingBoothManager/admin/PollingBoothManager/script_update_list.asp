<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/pollingboothmanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strActivated, strID, strCheck, strDisplayStatus
Dim strSQL

Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_pollingboothmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strCheck = Request(iLoop & ".Check")
If Request(iLoop & ".Activated") <> "" THEN
strActivated = Request(iLoop & ".Activated")
else
strActivated = "False"
end if
strID = Request(iLoop & ".ID")
If Request(iLoop & ".DisplayStatus") <> "" THEN
strDisplayStatus = Request(iLoop & ".DisplayStatus")
else
strDisplayStatus = "False"
end if

if strCheck = "Remove" then
strSQL = "DELETE FROM tblPBM_PollQuestions WHERE QuestionID = " & strID
else
strSQL = "UPDATE tblPBM_PollQuestions SET Activated = '" & strActivated & "'" & " , DisplayStatus = '" & strDisplayStatus & "'" & " WHERE QuestionID = " & strID
end if
CommandUD.Execute strSQL
Next
CommandUD.Close
set CommandUD = Nothing

Response.Redirect("admin.asp")
%>