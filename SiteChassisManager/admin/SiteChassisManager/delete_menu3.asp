<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/sitechassismanager.asp" -->
<%
' *** Edit Operations: declare variables
MM_editAction = CStr(Request("URL"))
If (Request.QueryString <> "") Then
  MM_editAction = MM_editAction & "?" & Request.QueryString
End If
' boolean to abort record edit
MM_abortEdit = false
' query string to execute
MM_editQuery = ""
%>
<%
' *** Delete Record: declare variables
if (CStr(Request("MM_delete")) <> "" And CStr(Request("MM_recordId")) <> "") Then
  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu3"
  MM_editColumn = "mid3"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  ' append the query string to the redirect URL
  If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
    If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    Else
      MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
    End If
  End If
End If
%>
<%
' *** Delete Record: construct a sql delete statement and execute it
if (CStr(Request("MM_delete")) <> "" And CStr(Request("MM_recordId")) <> "") Then
  ' create the sql delete statement
  MM_editQuery = "delete from " & MM_editTable & " where " & MM_editColumn & " = " & MM_recordId
  If (Not MM_abortEdit) Then
    ' execute the delete
    Set MM_editCmd = Server.CreateObject("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_editConnection
    MM_editCmd.CommandText = MM_editQuery
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close
    If (MM_editRedirectUrl <> "") Then
      Response.Redirect(MM_editRedirectUrl)
    End If
  End If
End If
%>
<%
Dim deletelistitem__MMColParam
deletelistitem__MMColParam = "1000"
If (Request.QueryString("mid3")       <> "") Then 
  deletelistitem__MMColParam = Request.QueryString("mid3")      
End If
%>
<%
set deletelistitem = Server.CreateObject("ADODB.Recordset")
deletelistitem.ActiveConnection = MM_sitechassismanager_STRING
deletelistitem.Source = "SELECT *  FROM tblSitePlanNavMenu3  WHERE mid3 = " + Replace(deletelistitem__MMColParam, "'", "''") + ""
deletelistitem.CursorType = 0
deletelistitem.CursorLocation = 2
deletelistitem.LockType = 3
deletelistitem.Open()
deletelistitem_numRows = 0
%>
<body onload="document.form1.submit()">
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="form1">
<input type="hidden" name="MM_delete" value="form1">
<input type="hidden" name="MM_recordId" value="<%= deletelistitem.Fields.Item("mid3").Value %>">
</form>
<%
deletelistitem.Close()
%>
