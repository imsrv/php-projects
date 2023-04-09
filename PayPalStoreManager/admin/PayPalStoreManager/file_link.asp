<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include virtual="/Connections/paypalstoremanager.asp" -->
<%
filenum = Request.QueryString("filenum")
filetype = Request.QueryString("filetype")
fileattribute = Request.QueryString("fileattribute")
%>
<%
' *** Edit Operations: declare variables

Dim MM_editAction
Dim MM_abortEdit
Dim MM_editQuery
Dim MM_editCmd

Dim MM_editConnection
Dim MM_editTable
Dim MM_editRedirectUrl
Dim MM_editColumn
Dim MM_recordId

Dim MM_fieldsStr
Dim MM_columnsStr
Dim MM_fields
Dim MM_columns
Dim MM_typeArray
Dim MM_formVal
Dim MM_delim
Dim MM_altVal
Dim MM_emptyVal
Dim MM_i

MM_editAction = CStr(Request.ServerVariables("SCRIPT_NAME"))
If (Request.QueryString <> "") Then
  MM_editAction = MM_editAction & "?" & Request.QueryString
End If

' boolean to abort record edit
MM_abortEdit = false

' query string to execute
MM_editQuery = ""
%>

<%
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "FileForm" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_paypalstoremanager_STRING
  MM_editTable = "tblItems"
  MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "closewindow_redirect.asp"
  MM_fieldsStr  = "File|value"
  MM_columnsStr = filetype & "File" & fileattribute & "Value" & filenum & "|',none,''"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

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
' *** Update Record: construct a sql update statement and execute it

If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then

  ' create the sql update statement
  MM_editQuery = "update " & MM_editTable & " set "
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_formVal = MM_fields(MM_i+1)
    MM_typeArray = Split(MM_columns(MM_i+1),",")
    MM_delim = MM_typeArray(0)
    If (MM_delim = "none") Then MM_delim = ""
    MM_altVal = MM_typeArray(1)
    If (MM_altVal = "none") Then MM_altVal = ""
    MM_emptyVal = MM_typeArray(2)
    If (MM_emptyVal = "none") Then MM_emptyVal = ""
    If (MM_formVal = "") Then
      MM_formVal = MM_emptyVal
    Else
      If (MM_altVal <> "") Then
        MM_formVal = MM_altVal
      ElseIf (MM_delim = "'") Then  ' escape quotes
        MM_formVal = "'" & Replace(MM_formVal,"'","''") & "'"
      Else
        MM_formVal = MM_delim + MM_formVal + MM_delim
      End If
    End If
    If (MM_i <> LBound(MM_fields)) Then
      MM_editQuery = MM_editQuery & ","
    End If
    MM_editQuery = MM_editQuery & MM_columns(MM_i) & " = " & MM_formVal
  Next
  MM_editQuery = MM_editQuery & " where " & MM_editColumn & " = " & MM_recordId

  If (Not MM_abortEdit) Then
    ' execute the update
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
filenum = Request.QueryString("filenum")
filetype = Request.QueryString("filetype")
fileattribute = Request.QueryString("fileattribute")
%>
<%
Dim items__value1
items__value1 = "0"
If (Request.QueryString("ItemID")        <> "") Then 
  items__value1 = Request.QueryString("ItemID")       
End If
%>
<%
set items = Server.CreateObject("ADODB.Recordset")
items.ActiveConnection = MM_paypalstoremanager_STRING
items.Source = "SELECT *  FROM tblItems  WHERE ItemID = " + Replace(items__value1, "'", "''") + ""
items.CursorType = 0
items.CursorLocation = 2
items.LockType = 3
items.Open()
items_numRows = 0
%>
<html>
<head>
<title>Add External Link to <%=filetype%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="FileForm" id="FileForm">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
    <tr>
      <td colspan="2" valign="baseline" nowrap>Creat link to <%=filetype%>: <strong><%=(items.Fields.Item("ItemName").Value)%>&nbsp;</strong></td>
    </tr>
    <tr>
      <td width="0" height="21"> Enter URL address
        to external <%=filetype%>:</td>
      <td width="0" height="21" valign="top">
        <input name="File" type="text" id="File" size="32">
        <br>
      i.e. <font color="#FF0000">http://www.sample.com/image.gif</font> </td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td height="21" valign="top"><input name="submit" type="submit" value="Save"></td>
    </tr>
  </table>

  <input type="hidden" name="MM_update" value="FileForm">
  <input type="hidden" name="MM_recordId" value="<%= items.Fields.Item("ItemID").Value %>">
</form>
</body>
</html>
<%
items.Close()
%>
