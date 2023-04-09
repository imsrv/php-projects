<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/registrationmanager.asp" -->
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

If (CStr(Request("MM_update")) = "messaging_preferences" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblRM_MessagingPreferences"
  MM_editColumn = "id"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "FromEmailAddress|value|MessageSubjectAdmin|value|MessageBCAdmin|value|MessageCCAdmin|value|MessageHeaderAdmin|value|MessageFooterAdmin|value|MessageSubjectVisitor|value|MessageBodyVisitor|value|MessageHeaderVisitor|value|MessageFooterVisitorLine1|value|MessageFooterVisitorLine2|value|MessageFooterVisitorLine3|value"
  MM_columnsStr = "AdminEmailAddress|',none,''|MessageSubjectAdmin|',none,''|MessageBCAdmin|',none,''|MessageCCAdmin|',none,''|MessageHeaderAdmin|',none,''|MessageFooterAdmin|',none,''|MessageSubjectVisitor|',none,''|MessageBodyVisitor|',none,''|MessageHeaderVisitor|',none,''|MessageFooterVisitorLine1|',none,''|MessageFooterVisitorLine2|',none,''|MessageFooterVisitorLine3|',none,''"

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
Dim message_preferences
Dim message_preferences_numRows

Set message_preferences = Server.CreateObject("ADODB.Recordset")
message_preferences.ActiveConnection = MM_registrationmanager_STRING
message_preferences.Source = "SELECT *  FROM tblRM_MessagingPreferences"
message_preferences.CursorType = 0
message_preferences.CursorLocation = 2
message_preferences.LockType = 1
message_preferences.Open()

message_preferences_numRows = 0
%>
<html>
<head>
<title>Membership Registration Manager</title>
<meta http-equiv="Content-Type" content="text/hMMl; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="messaging_preferences" id="messaging_preferences">
<table width="100%" align="center" class="tableborder">
  <tr>
    <td colspan="3" valign="top"  class="tableheader"><strong>This section allows
        you to configure the confirmation email that is automatically sent to
        the Registrant and notification email sent to Administrator</strong></td>
    </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Adminstrators Email Address:</strong></td>
    <td colspan="2" valign="top"><input name="FromEmailAddress" type="text" id="FromEmailAddress" value="<%=(message_preferences.Fields.Item("AdminEmailAddress").Value)%>" size="60">
      <img src="questionmark.gif" alt="This is the address designated to recieve the email notification" width="15" height="15"></td>
  </tr>
  <tr class="row2">
    <td width="21%" align="right" valign="top"><strong>Set the Subject Line of
        Confirmation Email sent to Administrator:</strong></td>
    <td colspan="2" valign="top">
      <textarea name="MessageSubjectAdmin" cols="60" rows="2"><%=(message_preferences.Fields.Item("MessageSubjectAdmin").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of confirmation email sent to Administrator" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td height="22" align="right" valign="top"><strong>Set the BCC of Confirmation
        Email sent to Administrator:</strong></td>
    <td colspan="2" valign="top">
      <input name="MessageBCAdmin" type="text" value="<%=(message_preferences.Fields.Item("MessageBCAdmin").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter an additional email address you wish to BCC" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the CC of Confirmation Email sent
        to Administrator:</strong></td>
    <td colspan="2" valign="top">
      <input name="MessageCCAdmin" type="text" value="<%=(message_preferences.Fields.Item("MessageCCAdmin").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter an additional email address you wish CC" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td height="56" align="right" valign="top"><strong>Set the Message Header
        of Confirmation Email sent to Administrator:</strong></td>
    <td colspan="2" valign="top">
      <textarea name="MessageHeaderAdmin" cols="60" rows="3"><%=(message_preferences.Fields.Item("MessageHeaderAdmin").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the header text you wish displayed in the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the Message Footer of Confirmation
        Email sent to Administrator:</strong></td>
    <td colspan="2" valign="top">
      <textarea name="MessageFooterAdmin" cols="60" rows="3" id="MessageFooterAdmin"><%=(message_preferences.Fields.Item("MessageFooterAdmin").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the footer text you wish displayed in the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td height="24" align="right" valign="top"><strong>Set the Subject Line of
        Confirmation Email sent to Registrant:</strong></td>
    <td colspan="2" valign="top">
      <input name="MessageSubjectVisitor" type="text" value="<%=(message_preferences.Fields.Item("MessageHeaderVisitor").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the Message Body of Confirmation
        Email sent to Registrant:</strong></td>
    <td colspan="2" valign="top">
      <textarea name="MessageBodyVisitor" cols="60" rows="5"><%=(message_preferences.Fields.Item("MessageBodyVisitor").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the body of the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the Message Header of Confirmation
        Email sent to Registrant:</strong></td>
    <td colspan="2" valign="top">
      <textarea name="MessageHeaderVisitor" cols="60" rows="3"><%=(message_preferences.Fields.Item("MessageHeaderVisitor").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the header text you wish displayed in the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the Message Footer Line1 of Confirmation
        Email sent to Registrant:</strong></td>
    <td colspan="2" valign="top">
      <input name="MessageFooterVisitorLine1" type="text" value="<%=(message_preferences.Fields.Item("MessageFooterVisitorLine1").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 1st line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the Message Footer Line2 of Confirmation
        Email sent to Registrant:</strong></td>
    <td colspan="2" valign="top">
      <input name="MessageFooterVisitorLine2" type="text" value="<%=(message_preferences.Fields.Item("MessageFooterVisitorLine2").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 2nd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
  </tr>
  <tr class="row2">
    <td align="right" valign="top"><strong>Set the Message Footer Line3 of Confirmation
        Email sent to Registrant:</strong></td>
    <td colspan="2" valign="top">
      <input name="MessageFooterVisitorLine3" type="text" value="<%=(message_preferences.Fields.Item("MessageFooterVisitorLine3").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 3rd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
  </tr>
  <tr>
    <td align="right" valign="top"  class="tableheader">&nbsp;</td>
    <td colspan="2" valign="top">
      <input name="submit" type="submit" id="submit" value="Update">
    </td>
  </tr>
</table>

<input type="hidden" name="MM_update" value="messaging_preferences">
<input type="hidden" name="MM_recordId" value="<%= message_preferences.Fields.Item("id").Value %>">
</form>
<%
message_preferences.Close()
Set message_preferences = Nothing
%>
