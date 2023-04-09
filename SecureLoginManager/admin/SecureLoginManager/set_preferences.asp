<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/secureloginmanager.asp" -->
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

If (CStr(Request("MM_update")) = "Update_Security" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_secureloginmanager_STRING
  MM_editTable = "tblSLM_Security"
  MM_editColumn = "SecurityLevelID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "LoginSuccessURL|value|LogoutURL|value"
  MM_columnsStr = "LoginSuccessURL|',none,''|LogoutURL|',none,''"

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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "SetPreferences" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_secureloginmanager_STRING
  MM_editTable = "tblSLM_SecurityPreferences"
  MM_editColumn = "ID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "FailedLoginURL|value"
  MM_columnsStr = "UnauthorizedAccessURL|',none,''"

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
Dim SecurityLevels
Dim SecurityLevels_numRows

Set SecurityLevels = Server.CreateObject("ADODB.Recordset")
SecurityLevels.ActiveConnection = MM_secureloginmanager_STRING
SecurityLevels.Source = "SELECT *  FROM tblSLM_Security"
SecurityLevels.CursorType = 0
SecurityLevels.CursorLocation = 2
SecurityLevels.LockType = 1
SecurityLevels.Open()

SecurityLevels_numRows = 0
%>
<%
Dim SecurityPreferences
Dim SecurityPreferences_numRows

Set SecurityPreferences = Server.CreateObject("ADODB.Recordset")
SecurityPreferences.ActiveConnection = MM_secureloginmanager_STRING
SecurityPreferences.Source = "SELECT *  FROM tblSLM_SecurityPreferences"
SecurityPreferences.CursorType = 0
SecurityPreferences.CursorLocation = 2
SecurityPreferences.LockType = 1
SecurityPreferences.Open()

SecurityPreferences_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = 10
Repeat1__index = 0
SecurityLevels_numRows = SecurityLevels_numRows + Repeat1__numRows
%>
<html>
<head>
<title>Set Login Preferences</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tableborder">
  <tr class="row2">
    <td width="36%" valign="middle" >Redirect <font color="#FF0000"><strong>Unauthorized</strong></font> users
      to the following page: (include full URL)</td>
    <td width="64%" valign="middle">
      <form ACTION="<%=MM_editAction%>" METHOD="POST" name="SetPreferences" id="SetPreferences">
      <input name="FailedLoginURL" type="text" id="FailedLoginURL" value="<%=(SecurityPreferences.Fields.Item("UnauthorizedAccessURL").Value)%>" size="50">
      <input type="submit" value="Save">
      <input type="hidden" name="MM_update" value="SetPreferences">
      <input type="hidden" name="MM_recordId" value="<%= SecurityPreferences.Fields.Item("ID").Value %>">
(Use login page as default)
      </form></td>
  </tr>
</table>
<% 
While ((Repeat1__numRows <> 0) AND (NOT SecurityLevels.EOF)) 
%>
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="Update_Security" id="Update_Security">
  <table width="100%" height="32" border="0" cellpadding="5" cellspacing="0" class="tableborder">
    <% Dim iCount
  iCount = 0
%>
  <tr class="row2">
      <td width="19%" height="13" rowspan="3">Security Level <font color="#FF0000"><strong><%=(SecurityLevels.Fields.Item("SecurityLevelID").Value)%> </strong></font>= <strong><%=(SecurityLevels.Fields.Item("SecurityLevelName").Value)%></strong>             </td>
      <td width="39%">Redirect <font color="#FF0000"><strong>Authorized </strong></font><strong><%=(SecurityLevels.Fields.Item("SecurityLevelName").Value)%></strong>  to
      the following page: (include full URL)</td>
      <td width="31%" height="7">        <input name="LoginSuccessURL" type="text" value="<%=(SecurityLevels.Fields.Item("LoginSuccessURL").Value)%>" size="50"> 
      </td>
      <td width="11%" height="13" rowspan="3">
        <input type="hidden" name="MM_update" value="Update_Security">
        <input type="hidden" name="MM_recordId" value="<%= SecurityLevels.Fields.Item("SecurityLevelID").Value %>">
  <input name="Submit2" type="submit" id="Submit2" value="Update">
      </td>
    </tr>
  <tr class="row2">
    <td>On <font color="#FF0000"><strong>LOGOUT </strong></font> redirect <strong><%=(SecurityLevels.Fields.Item("SecurityLevelName").Value)%></strong> to
      the following page: (include full URL)</td>
    <td width="31%" height="3"><input name="LogoutURL" type="text" id="LogoutURL" value="<%=(SecurityLevels.Fields.Item("LogoutURL").Value)%>" size="50"></td>
  </tr>
      </table>
</form>
<% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  SecurityLevels.MoveNext()
Wend
%>

</body>
</html>
<%
SecurityLevels.Close()
Set SecurityLevels = Nothing
%>
<%
SecurityPreferences.Close()
Set SecurityPreferences = Nothing
%>
