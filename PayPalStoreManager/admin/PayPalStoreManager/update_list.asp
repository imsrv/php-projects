<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/paypalstoremanager.asp" -->
<%
Response.Buffer = True 
Dim iCount
iCount = Request.Form("Count")

Dim strActivated, strItemName, strItemID, strItemPrice, strItemUOM


Dim CommandUD
set CommandUD = Server.CreateObject("ADODB.Connection")
CommandUD.ConnectionString = MM_paypalstoremanager_STRING
CommandUD.Open

Dim iLoop
For iLoop = 0 to iCount
strActivated = Request(iLoop & ".Activated")
strItemName = Request(iLoop & ".ItemName")
strItemName = replace(strItemName, "'", "''")
strItemID = Request(iLoop & ".ItemID")
strItemPrice = Request(iLoop & ".ItemPriceValue1")
strItemUOM = Request(iLoop & ".ItemUOM")


strSQL = "UPDATE tblItems SET Activated = '" & strActivated & "'" & " , ItemName = '" & strItemName & "'"  & " , ItemPriceValue1 = '" & strItemPrice & "'"  & " , ItemUOM = '" & strItemUOM &  "'" &" WHERE ItemID = " & strItemID
CommandUD.Execute strSQL
Next

CommandUD.Close
set CommandUD = Nothing

Response.Redirect("list.asp?action=update")
%>
