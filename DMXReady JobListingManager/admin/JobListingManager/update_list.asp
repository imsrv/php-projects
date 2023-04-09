<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/joblistingmanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strActivated, strItemName, strItemID, strSendToEmailAddress


Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_joblistingmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strActivated = Request(iLoop & ".Activated")
strItemName = Request(iLoop & ".ItemName")
strItemName = replace(strItemName, "'", "''")
strItemID = Request(iLoop & ".ItemID")
strSendToEmailAddress = Request(iLoop & ".SendToEmailAddress")


strSQL = "UPDATE tblItems SET Activated = '" & strActivated & "'" & " , ItemName = '" & strItemName & "'"  & " , SendToEmailAddress = '" & strSendToEmailAddress & "'"  &" WHERE ItemID = " & strItemID
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("list.asp?action=update")
%>
