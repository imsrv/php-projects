<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include virtual="/Connections/sitechassismanager.asp" -->
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

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePreferences"
  MM_editColumn = "ID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "DomainName|value|CompanyName|value|CopyrightYear|value|SiteTitle|value|FooterText|value|MetaDescription|value|MetaKeywords|value"
  MM_columnsStr = "DomainName|',none,''|CompanyName|',none,''|CopyrightYear|',none,''|SiteTitle|',none,''|FooterText|',none,''|MetaDescription|',none,''|MetaKeywords|',none,''"

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
Dim sitepreferences
Dim sitepreferences_numRows

Set sitepreferences = Server.CreateObject("ADODB.Recordset")
sitepreferences.ActiveConnection = MM_sitechassismanager_STRING
sitepreferences.Source = "SELECT *  FROM tblSitePreferences"
sitepreferences.CursorType = 0
sitepreferences.CursorLocation = 2
sitepreferences.LockType = 1
sitepreferences.Open()

sitepreferences_numRows = 0
%>
<html>
<head>
<title>Site Preferences</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--#include file="header.asp" -->
<form method="POST" action="<%=MM_editAction%>" name="form1">
  <table width="100%" align="center" class="tableborder">
    <tr>
      <td width="116" valign="middle" class="tableheader">Domain Name</td>
      <td width="875" valign="baseline"><input name="DomainName" type="text" id="DomainName" value="<%=(sitepreferences.Fields.Item("DomainName").Value)%>"></td>
    </tr>
    <tr>
      <td valign="middle" class="tableheader">Company Name</td>
      <td valign="baseline"><input name="CompanyName" type="text" id="CompanyName" value="<%=(sitepreferences.Fields.Item("CompanyName").Value)%>"></td>
    </tr>
    <tr>
      <td valign="middle" class="tableheader">CopyrightYear</td>
      <td valign="baseline"><input name="CopyrightYear" type="text" id="CopyrightYear" value="<%=(sitepreferences.Fields.Item("CopyrightYear").Value)%>"></td>
    </tr>
    <tr>
      <td valign="middle" class="tableheader">SiteTitle:</td>
      <td valign="baseline"><textarea name="SiteTitle" cols="80" rows="2"><%=(sitepreferences.Fields.Item("SiteTitle").Value)%></textarea></td>
    </tr>
    <tr>
      <td valign="middle" nowrap class="tableheader">FooterText:</td>
      <td valign="baseline"><textarea name="FooterText" cols="80" rows="2"><%=(sitepreferences.Fields.Item("FooterText").Value)%></textarea>
</td>
    </tr>
    <tr valign="baseline">
      <td valign="middle" nowrap class="tableheader">Meta Description:</td>
      <td><textarea name="MetaDescription" cols="80" rows="6" id="MetaDescription"><%=(sitepreferences.Fields.Item("MetaDescription").Value)%></textarea>
</td>
    </tr>
    <tr valign="baseline">
      <td valign="middle" nowrap class="tableheader">Meta Keywords:</td>
      <td><textarea name="MetaKeywords" cols="80" rows="6" id="MetaKeywords"><%=(sitepreferences.Fields.Item("MetaKeywords").Value)%></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="tableheader">&nbsp;</td>
      <td><input name="submit" type="submit" value="Update Record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="MM_recordId" value="<%= sitepreferences.Fields.Item("ID").Value %>">
</form>
<p>&nbsp;</p>
</body>
</html>
<%
sitepreferences.Close()
Set sitepreferences = Nothing
%>
