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

If (CStr(Request("MM_update")) = "SendPassword" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_secureloginmanager_STRING
  MM_editTable = "tblSLM_MessagingPreferences"
  MM_editColumn = "id"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "AdminEmailAddress|value|MessageSubjectVisitor|value|MessageBodyVisitor|value|MessageFooterVisitorLine1|value|MessageFooterVisitorLine2|value|MessageFooterVisitorLine3|value"
  MM_columnsStr = "AdminEmailAddress|',none,''|MessageSubjectVisitor|',none,''|MessageBodyVisitor|',none,''|MessageFooterVisitorLine1|',none,''|MessageFooterVisitorLine2|',none,''|MessageFooterVisitorLine3|',none,''"

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
Dim SendPassword
Dim SendPassword_numRows

Set SendPassword = Server.CreateObject("ADODB.Recordset")
SendPassword.ActiveConnection = MM_secureloginmanager_STRING
SendPassword.Source = "SELECT *  FROM tblSLM_MessagingPreferences"
SendPassword.CursorType = 0
SendPassword.CursorLocation = 2
SendPassword.LockType = 1
SendPassword.Open()

SendPassword_numRows = 0
%>
<html>
<head>
<title>Contact Us Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function openPictureWindow_Fever(imageName,imageWidth,imageHeight,alt,posLeft,posTop) {
	newWindow = window.open("","newWindow","width="+imageWidth+",height="+imageHeight+",left="+posLeft+",top="+posTop);
	newWindow.document.open();
	newWindow.document.write('<html><title>'+alt+'</title><body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" onBlur="self.close()">'); 
	newWindow.document.write('<img src='+imageName+' width='+imageWidth+' height='+imageHeight+' alt='+alt+'>'); 
	newWindow.document.write('</body></html>');
	newWindow.document.close();
	newWindow.focus();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body>
<!--#include file="header.asp" -->
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="SendPassword" id="SendPassword">
  <br>
  <table width="100%" align="center" class="tableborder">
    <tr class="tableheader">
      <td height="18" colspan="3" valign="top">This section allows you to configure the &quot;Lost
      Password&quot; email that is automatically sent to the Member</td>
    </tr>
    <tr class="row2">
      <td width="32%" align="right" valign="top">From Email Address</td>
      <td width="68%" colspan="2"><input name="AdminEmailAddress" type="text" id="AdminEmailAddress" value="<%=(SendPassword.Fields.Item("AdminEmailAddress").Value)%>">
      <img src="questionmark.gif" alt="Enter the email address you want the message to be sent from" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="24" align="right" valign="top">Set the
        Subject Line of "Lost Password" email sent to Member:</td>
      <td colspan="2" valign="top">
        <input name="MessageSubjectVisitor" type="text" value="<%=(SendPassword.Fields.Item("MessageSubjectVisitor").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Body
        of "Lost Password" email sent to Member:</td>
      <td colspan="2" valign="top">
        <textarea name="MessageBodyVisitor" cols="60" rows="5"><%=(SendPassword.Fields.Item("MessageBodyVisitor").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the body of the email message" width="15" height="15">       </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        Line1 of "Lost Password" email sent to Member:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageFooterVisitorLine1" value="<%=(SendPassword.Fields.Item("MessageFooterVisitorLine1").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 1st line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        Line2 of "Lost Password" email sent to Member:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageFooterVisitorLine2" value="<%=(SendPassword.Fields.Item("MessageFooterVisitorLine2").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 2nd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        Line3 of "Lost Password" email sent to Member:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageFooterVisitorLine3" value="<%=(SendPassword.Fields.Item("MessageFooterVisitorLine3").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 3rd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr>
      <td align="right" valign="top">&nbsp;</td>
      <td colspan="2" valign="top">
        <input name="submit2" type="submit" value="Update Record">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="SendPassword">
  <input type="hidden" name="MM_recordId" value="<%= SendPassword.Fields.Item("id").Value %>">
</form>
</body>
</html>
<%
SendPassword.Close()
Set SendPassword = Nothing
%>
