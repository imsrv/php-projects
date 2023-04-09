<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/contactusmanager.asp" -->
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

  MM_editConnection = MM_contactusmanager_STRING
  MM_editTable = "tblContactUs"
  MM_editColumn = "ContactID"
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

If (CStr(Request("MM_delete")) <> "" And CStr(Request("MM_recordId")) <> "") Then

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
Dim contactus__MMColParam
contactus__MMColParam = "1000"
if (Request.QueryString("ContactID")  <> "") then contactus__MMColParam = Request.QueryString("ContactID") 
%>
<%
set contactus = Server.CreateObject("ADODB.Recordset")
contactus.ActiveConnection = MM_contactusmanager_STRING
contactus.Source = "SELECT *  FROM tblContactUs  WHERE ContactID = " + Replace(contactus__MMColParam, "'", "''") + ""
contactus.CursorType = 0
contactus.CursorLocation = 2
contactus.LockType = 3
contactus.Open()
contactus_numRows = 0
%>
<body onload="document.form1.submit()">
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="form1">
  <input type="hidden" name="MM_delete" value="true">
  <input type="hidden" name="MM_recordId" value="<%= Request.QueryString("ContactID") %>">
</form>
<%
contactus.Close()
%>
