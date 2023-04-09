<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/newsmanager.asp"-->
<SCRIPT RUNAT=SERVER LANGUAGE=VBSCRIPT>					
function DoDateTime(str, nNamedFormat, nLCID)				
	dim strRet								
	dim nOldLCID								
										
	strRet = str								
	If (nLCID > -1) Then							
		oldLCID = Session.LCID						
	End If									
										
	On Error Resume Next							
										
	If (nLCID > -1) Then							
		Session.LCID = nLCID						
	End If									
										
	If ((nLCID < 0) Or (Session.LCID = nLCID)) Then				
		strRet = FormatDateTime(str, nNamedFormat)			
	End If									
										
	If (nLCID > -1) Then							
		Session.LCID = oldLCID						
	End If									
										
	DoDateTime = strRet							
End Function									
</SCRIPT>	
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strCheck, strActivated, strExpiryDate, strItemName, strCategoryID, strItemID

Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_newsmanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strCheck = Request(iLoop & ".Check")
strActivated = Request(iLoop & ".Activated")
strExpiryDate = Request(iLoop & ".ExpiryDate")
strItemName = Request(iLoop & ".ItemName")
strItemName = replace(strItemName, "'", "''")
strCategoryID = Request(iLoop & ".CategoryID")
strItemID = Request(iLoop & ".ItemID")



if strCheck = "Remove" then
strSQL = "DELETE FROM tblNM_News WHERE ItemID = " & strItemID
else
strSQL = "UPDATE tblNM_News SET Activated = '" & strActivated & "'" & " , ExpiryDate = '" & strExpiryDate & "'"  & " , ItemName = '" & strItemName & "'"  & " , CategoryID = '" & strCategoryID & "'" & " WHERE ItemID = " & strItemID
end if
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("admin.asp")
%>
