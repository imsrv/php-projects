<%@LANGUAGE="VBSCRIPT"%>
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

If (CStr(Request("MM_update")) = "updatemenu" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu3"
  MM_editColumn = "mid3"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "Menu|value|MenuDesc|value|SectionContent|value|ImageFileA|value|ImageFileB|value|SortOrder|value|includefile|value|PageLink|value|Variables|value|Activated|value"
  MM_columnsStr = "Menu3|',none,''|MenuDesc3|',none,''|SectionContent3|',none,''|ImageFileA3|',none,''|ImageFileB3|',none,''|SortOrder3|none,none,NULL|IncludeFileID3|none,none,NULL|PageLink3|',none,''|Variables3|',none,''|Activated3|',none,''"

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
Dim menu3navigation__value1
menu3navigation__value1 = "0"
If (Request.QueryString("mid3")  <> "") Then 
  menu3navigation__value1 = Request.QueryString("mid3") 
End If
%>
<%
set menu3navigation = Server.CreateObject("ADODB.Recordset")
menu3navigation.ActiveConnection = MM_sitechassismanager_STRING
menu3navigation.Source = "SELECT tblSitePlanNavMenu.*, tblSitePlanNavMenu2.*, tblSitePlanNavMenu3.*  FROM (tblSitePlanNavMenu LEFT JOIN tblSitePlanNavMenu2 ON tblSitePlanNavMenu.mid = tblSitePlanNavMenu2.midkey) LEFT JOIN tblSitePlanNavMenu3 ON tblSitePlanNavMenu2.mid2 = tblSitePlanNavMenu3.mid2key  WHERE mid3 = " + Replace(menu3navigation__value1, "'", "''") + ""
menu3navigation.CursorType = 0
menu3navigation.CursorLocation = 2
menu3navigation.LockType = 3
menu3navigation.Open()
menu3navigation_numRows = 0
%>
<%
Dim controlpanel
Dim controlpanel_numRows

Set controlpanel = Server.CreateObject("ADODB.Recordset")
controlpanel.ActiveConnection = MM_sitechassismanager_STRING
controlpanel.Source = "SELECT *  FROM ControlPanel"
controlpanel.CursorType = 0
controlpanel.CursorLocation = 2
controlpanel.LockType = 1
controlpanel.Open()

controlpanel_numRows = 0
%>
<html>
<head>
<title>Update</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
  <!--#include file="header.asp" --> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="382" valign="top">
      <form ACTION="<%=MM_editAction%>" METHOD="POST" name="updatemenu" id="updatemenu">
        <table width="100%" align="center" class="tableborder">
          <tr>
            <td colspan="2" align="right" valign="baseline" nowrap class="tableheader">Update
              Menu Item</td>
          </tr>
          <tr>
            <td width="12%" align="right" valign="baseline" nowrap class="tableheader">Section</td>
            <td width="88%" valign="baseline" class="tablebody"> <strong><%=(menu3navigation.Fields.Item("Menu").Value)%>-  <%=(menu3navigation.Fields.Item("Menu2").Value)%> - <%=(menu3navigation.Fields.Item("Menu3").Value)%></strong> | <a href="admin.asp?mid2=<%=(menu3navigation.Fields.Item("mid2key").Value)%>">add a new section/menu button</a></td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Menu
            Name</td>
            <td valign="baseline" class="tablebody"><input name="Menu" type="text" id="Menu" value="<%=(menu3navigation.Fields.Item("Menu3").Value)%>" size="50"></td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Section
              Desc:</td>
            <td valign="baseline" class="tablebody">
              <textarea name="MenuDesc" cols="60" rows="2" id="MenuDesc"><%=(menu3navigation.Fields.Item("MenuDesc3").Value)%></textarea>
            </td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Section
              Content</td>
            <td class="tablebody"><textarea name="SectionContent" cols="60" rows="2" id="SectionContent"><%=(menu3navigation.Fields.Item("SectionContent3").Value)%></textarea>
              <a href="html_editor_menu3.asp?mid3=<%=(menu3navigation.Fields.Item("mid3").Value)%>">Edit
              using HTML Editor </a> </td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Image
              1</td>
            <td valign="baseline" class="tablebody"><input name="ImageFileA" type="text" id="ImageFileA" value="<%=(menu3navigation.Fields.Item("ImageFileA3").Value)%>" size="50"> 
			<a href="javascript:;" onClick="MM_openBrWindow('upload_menu3_imageA.asp?mid3=<%=(menu3navigation.Fields.Item("mid3").Value)%>','Image','width=300,height=100')">ADD
            IMAGE</a> 
              </td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Image
              2</td>
            <td valign="baseline" class="tablebody"><input name="ImageFileB" type="text" id="ImageFileB" value="<%=(menu3navigation.Fields.Item("ImageFileB3").Value)%>" size="50">
			<a href="javascript:;" onClick="MM_openBrWindow('upload_menu3_imageB.asp?mid3=<%=(menu3navigation.Fields.Item("mid3").Value)%>','Image','width=300,height=100')">ADD IMAGE </a>   
                     </td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Sort
              Order</td>
            <td valign="baseline" class="tablebody"><input name="SortOrder" type="text" id="SortOrder" value="<%=(menu3navigation.Fields.Item("SortOrder3").Value)%>">
            </td>
          </tr>
<tr>
            <td nowrap align="right" class="tableheader" valign="middle">Application:</td>
            <td class="tablebody">
              <select name="includefile" id="includefile">
              <option value="">Inlcude a DMX App</option>
              <%
While (NOT controlpanel.EOF)
%>
              <option value="<%=(controlpanel.Fields.Item("ItemID").Value)%>" <%If (Not isNull((menu3navigation.Fields.Item("IncludeFileID3").Value))) Then If (CStr(controlpanel.Fields.Item("ItemID").Value) = CStr((menu3navigation.Fields.Item("IncludeFileID3").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(controlpanel.Fields.Item("ItemName").Value)%></option>
                <%
  controlpanel.MoveNext()
Wend
If (controlpanel.CursorType > 0) Then
  controlpanel.MoveFirst
Else
  controlpanel.Requery
End If
%>
            </select></td>
          </tr>
          <tr>
            <td nowrap align="right" class="tableheader" valign="middle">Include
            File ID</td>
            <td class="tablebody"><strong>incid = <%=(menu3navigation.Fields.Item("IncludeFileID3").Value)%></strong></td>
          </tr>
          <tr>
            <td nowrap align="right" class="tableheader" valign="middle">Page
              Link:</td>
            <td class="tablebody" valign="middle"><input name="PageLink" type="text" id="PageLink" value="<%=(menu3navigation.Fields.Item("PageLink3").Value)%>" size="50">
            </td>
          </tr>
          <tr>
            <td nowrap align="right" class="tableheader" valign="middle">Variables</td>
            <td class="tablebody" valign="middle"><input name="Variables" type="text" id="Variables" value="<%=(menu3navigation.Fields.Item("Variables3").Value)%>" size="50">
            </td>
          </tr>
          <tr>
            <td nowrap align="right" class="tableheader" valign="middle">Activated</td>
            <td class="tablebody" valign="middle"><input <%If (CStr((menu3navigation.Fields.Item("Activated3").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated" type="checkbox" id="Activated" value="True">
            </td>
          </tr>
          <tr>
            <td height="24" align="right" valign="baseline" nowrap class="tableheader">&nbsp;</td>
            <td valign="baseline" class="tablebody">
              <input type="submit" value="Update Record">
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="updatemenu">
        <input type="hidden" name="MM_recordId" value="<%= menu3navigation.Fields.Item("mid3").Value %>">
      </form> 
    </td>
  </tr>
</table>
<%
menu3navigation.Close()
Set menu3navigation = Nothing
%>
<%
controlpanel.Close()
Set controlpanel = Nothing
%>
