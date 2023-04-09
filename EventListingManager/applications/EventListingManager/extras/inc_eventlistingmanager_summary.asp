<!--#include file="../../../Connections/eventlistingmanager.asp" -->
<%
set eventlist = Server.CreateObject("ADODB.Recordset")
eventlist.ActiveConnection = MM_eventlistingmanager_STRING
eventlist.Source = "SELECT tblEventListings.*, tblEventCategory.CategoryDesc, tblEventCategory.CategoryName  FROM tblEventCategory INNER JOIN tblEventListings ON tblEventCategory.CategoryID = tblEventListings.CategoryID  WHERE Activated = 'True'"
eventlist.CursorType = 0
eventlist.CursorLocation = 2
eventlist.LockType = 3
eventlist.Open()
eventlist_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = 2
Repeat1__index = 0
eventlist_numRows = eventlist_numRows + Repeat1__numRows
%>
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
<html>
<head>
<title>Event Listings</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../styles.css" rel="stylesheet" type="text/css">
<SCRIPT RUNAT=SERVER LANGUAGE=VBSCRIPT>	
function DoTrimProperly(str, nNamedFormat, properly, pointed, points)
  dim strRet
  strRet = Server.HTMLEncode(str)
  strRet = replace(strRet, vbcrlf,"")
  strRet = replace(strRet, vbtab,"")
  If (LEN(strRet) > nNamedFormat) Then
    strRet = LEFT(strRet, nNamedFormat)			
    If (properly = 1) Then					
      Dim TempArray								
      TempArray = split(strRet, " ")	
      Dim n
      strRet = ""
      for n = 0 to Ubound(TempArray) - 1
        strRet = strRet & " " & TempArray(n)
      next
    End If
    If (pointed = 1) Then
      strRet = strRet & points
    End If
  End If
  DoTrimProperly = strRet
End Function
</SCRIPT>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><% 
While ((Repeat1__numRows <> 0) AND (NOT eventlist.EOF)) 
%>
<%= DoDateTime((eventlist.Fields.Item("EventStartDate").Value), 1, 2057) %> <br>
      <strong><%=(eventlist.Fields.Item("ItemName").Value)%></strong><br>
    <% =(DoTrimProperly((eventlist.Fields.Item("ItemDescShort").Value), 50, 1, 1, "")) %>
    ....More    <br>
    <br>
	<% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  eventlist.MoveNext()
Wend
%>
</td>
  </tr>
</table>
</body>
</html>
<%
eventlist.Close()
%>
