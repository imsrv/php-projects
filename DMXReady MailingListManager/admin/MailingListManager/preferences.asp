<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include virtual="/Connections/mailinglistmanager.asp" -->
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

If (CStr(Request("MM_update")) = "form1" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_mailinglistmanager_STRING
  MM_editTable = "tblMailingListManagerPreferences"
  MM_editColumn = "ID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "MailingListTitle|value|TestEmailAddress|value|FromEmailAddress|value|SubscribeConfirmationEmailMessage|value|SubscribeMessage|value|UnsubscribeConfirmationEmailMessage|value|UnsubscribeMessage|value|UnsubscribeLink|value"
  MM_columnsStr = "MailingListTitle|',none,''|TestEmailAddress|',none,''|FromEmailAddress|',none,''|SubscribeConfirmationEmailMessage|',none,''|SubscribeMessage|',none,''|UnsubscribeConfirmationEmailMessage|',none,''|UnsubscribeMessage|',none,''|UnsubscribeLink|',none,''"

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
Dim preferences
Dim preferences_numRows

Set preferences = Server.CreateObject("ADODB.Recordset")
preferences.ActiveConnection = MM_mailinglistmanager_STRING
preferences.Source = "SELECT *  FROM tblMailingListManagerPreferences"
preferences.CursorType = 0
preferences.CursorLocation = 2
preferences.LockType = 1
preferences.Open()

preferences_numRows = 0
%>
<html>
<head>
<title>Mailing List Manager Preferences</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--#include file="header.asp" -->

<form method="POST" action="<%=MM_editAction%>" name="form1">
  <table align="center" class="tableborder">
    <tr>
      <td height="22" colspan="2" align="right" valign="top" class="tableheader" >Configure Mailing
        List Preferences</td>
    </tr>
    <tr>
      <td width="262" height="52" align="right" valign="top" class="tableheader" >Web
        Site Name:<br>
        <span class="helptext">(Will be used as the Name of your mailing list
        i.e. domain.com)</span></td>
      <td width="713" valign="baseline"><textarea name="MailingListTitle" cols="50" rows="2"><%=(preferences.Fields.Item("MailingListTitle").Value)%></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" class="tableheader" >Test Email Address:<br>
      <span class="helptext">(Enter a test email address you will use to preview
      a message prior to sending out to all members)</span></td>
      <td>
        <input type="text" name="TestEmailAddress" value="<%=(preferences.Fields.Item("TestEmailAddress").Value)%>" size="50">
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" class="tableheader" >From Email Address:<br>
      <span class="helptext">(The &quot;From&quot; email address that will be displayed
      on all outgoing messages)</span></td>
      <td>
        <input type="text" name="FromEmailAddress" value="<%=(preferences.Fields.Item("FromEmailAddress").Value)%>" size="50">
      </td>
    </tr>
    <tr>
      <td align="right" valign="top" class="tableheader" >Confirmation Email Message:<br>
        <span class="helptext">(Automatically sent to new subscribers)</span></td>
      <td valign="baseline">
        <textarea name="SubscribeConfirmationEmailMessage" cols="80" rows="5"><%=(preferences.Fields.Item("SubscribeConfirmationEmailMessage").Value)%></textarea>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top" class="tableheader" >Subscribe Message:<br>
        <span class="helptext">(Message displayed when member successfully subscribes to mailing list)</span></td>
      <td valign="baseline">
        <textarea name="SubscribeMessage" cols="80" rows="5"><%=(preferences.Fields.Item("SubscribeMessage").Value)%></textarea>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top" class="tableheader" >Unsubscribe Confirmation
        Email Message:<br>
        <span class="helptext">(Automatically sent to unsubscribers)</span></td>
      <td valign="baseline">
        <textarea name="UnsubscribeConfirmationEmailMessage" cols="80" rows="5"><%=(preferences.Fields.Item("UnsubscribeConfirmationEmailMessage").Value)%></textarea>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top" class="tableheader" >Unsubscribe Message:<br>        
      <span class="helptext">(Message displayed when member successfully
        unsubscribes from mailing list)</span></td>
      <td valign="baseline"><textarea name="UnsubscribeMessage" cols="80" rows="5"><%=(preferences.Fields.Item("UnsubscribeMessage").Value)%></textarea>
</td>
    </tr>
    <tr valign="baseline">
      <td align="right" class="tableheader" >Unsubscribe Link:<br>
        <span class="helptext">(The URL link will be added to the footer of every
        message sent out)</span></td>
      <td>
        <input type="text" name="UnsubscribeLink" value="<%=(preferences.Fields.Item("UnsubscribeLink").Value)%>" size="80">
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" class="tableheader" >&nbsp;</td>
      <td>
        <input type="submit" value="Set Preferences">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="MM_recordId" value="<%= preferences.Fields.Item("ID").Value %>">
</form>
<p>&nbsp;</p>
</body>
</html>
<%
preferences.Close()
Set preferences = Nothing
%>
