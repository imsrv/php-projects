<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/registrationmanager.asp" -->
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
' *** Insert Record: set variables
If (CStr(Request("MM_insert")) <> "") Then
  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_MemberLookuptxt2"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "MemberLookuptxt2Value|value|MemberLookuptxt2ItemName|value"
  MM_columnsStr = "MemberLookuptxt2ItemValue|',none,''|MemberLookuptxt2ItemName|',none,''"
  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  ' set the form values
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(i+1) = CStr(Request.Form(MM_fields(i)))
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
' *** Delete Record: declare variables
if (CStr(Request("MM_delete")) <> "" And CStr(Request("MM_recordId")) <> "") Then
  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_MemberLookuptxt2"
  MM_editColumn = "MemberLookuptxt2ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
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
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "CreatLookupGroup") Then

  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_MemberLookuptxt2"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "MemberLookuptxt2ItemName|value|MemberLookuptxt2ItemDesc|value|MemberLookuptxt2ItemValue|value"
  MM_columnsStr = "MemberLookuptxt2ItemName|',none,''|MemberLookuptxt2ItemDesc|',none,''|MemberLookuptxt2ItemValue|',none,''"

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

If (CStr(Request("MM_update")) = "UpdateLookupGroup" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_MemberLookuptxt2"
  MM_editColumn = "MemberLookuptxt2ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "MemberLookuptxt2ItemName2|value|MemberLookuptxt2ItemDesc2|value"
  MM_columnsStr = "MemberLookuptxt2ItemName|',none,''|MemberLookuptxt2ItemDesc|',none,''"

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
If (CStr(Request("MM_update")) = "form" And CStr(Request("MM_recordId")) <> "") Then
  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_MemberLookuptxt2"
  MM_editColumn = "MemberLookuptxt2ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "MemberLookuptxt2Value|value"
  MM_columnsStr = "MemberLookuptxt2ItemValue|',none,''"
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
' *** Insert Record: construct a sql insert statement and execute it
If (CStr(Request("MM_insert")) <> "") Then
  ' create the sql insert statement
  MM_tableValues = ""
  MM_dbValues = ""
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    FormVal = MM_fields(i+1)
    MM_typeArray = Split(MM_columns(i+1),",")
    Delim = MM_typeArray(0)
    If (Delim = "none") Then Delim = ""
    AltVal = MM_typeArray(1)
    If (AltVal = "none") Then AltVal = ""
    EmptyVal = MM_typeArray(2)
    If (EmptyVal = "none") Then EmptyVal = ""
    If (FormVal = "") Then
      FormVal = EmptyVal
    Else
      If (AltVal <> "") Then
        FormVal = AltVal
      ElseIf (Delim = "'") Then  ' escape quotes
        FormVal = "'" & Replace(FormVal,"'","''") & "'"
      Else
        FormVal = Delim + FormVal + Delim
      End If
    End If
    If (i <> LBound(MM_fields)) Then
      MM_tableValues = MM_tableValues & ","
      MM_dbValues = MM_dbValues & ","
    End if
    MM_tableValues = MM_tableValues & MM_columns(i)
    MM_dbValues = MM_dbValues & FormVal
  Next
  MM_editQuery = "insert into " & MM_editTable & " (" & MM_tableValues & ") values (" & MM_dbValues & ")"
  If (Not MM_abortEdit) Then
    ' execute the insert
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
set List_MemberLookuptxt2 = Server.CreateObject("ADODB.Recordset")
List_MemberLookuptxt2.ActiveConnection = MM_registrationmanager_STRING
List_MemberLookuptxt2.Source = "SELECT *  FROM tblMM_MemberLookuptxt2  ORDER BY MemberLookuptxt2ItemID"
List_MemberLookuptxt2.CursorType = 0
List_MemberLookuptxt2.CursorLocation = 2
List_MemberLookuptxt2.LockType = 3
List_MemberLookuptxt2.Open()
List_MemberLookuptxt2_numRows = 0
%>
<%
Dim Repeat1__numRows
Repeat1__numRows = -1
Dim Repeat1__index
Repeat1__index = 0
List_MemberLookuptxt2_numRows = List_MemberLookuptxt2_numRows + Repeat1__numRows
%>
<%
' UltraDeviant - Row Number written by Owen Palmer (http://ultradeviant.co.uk)
Dim OP_RowNum
If MM_offset <> "" Then
	OP_RowNum = MM_offset + 1
Else
	OP_RowNum = 1
End If
%>
<html>
<head>
<title>MemberLookuptxt Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<% If List_MemberLookuptxt2.EOF And List_MemberLookuptxt2.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tableborder">
  <tr>
    <td class="tableheader">Create Lookup Group</td>
  </tr>
  <tr>
    <td><form action="<%=MM_editAction%>" method="POST" name="CreatLookupGroup" id="CreatLookupGroup">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="21%"><p>Name of Lookup Group</p>
            </td>
            <td width="79%"><input name="MemberLookuptxt2ItemName" type="text" id="MemberLookuptxt2ItemName" size="25">
            </td>
          </tr>
          <tr>
            <td>Descrption of Lookup Group</td>
            <td><input name="MemberLookuptxt2ItemDesc" type="text" id="MemberLookuptxt2ItemDesc" size="50">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit32" value="Create">
              <input name="MemberLookuptxt2ItemValue" type="hidden" id="MemberLookuptxt2ItemValue" value="Lookup Value">
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="CreatLookupGroup">
      </form>
    </td>
  </tr>
</table>
<% End If ' end List_MemberLookuptxt2.EOF And List_MemberLookuptxt2.BOF %>
<% If Not List_MemberLookuptxt2.EOF Or Not List_MemberLookuptxt2.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tableborder">
  <tr>
    <td class="tableheader">Update Lookup Group Properties</td>
  </tr>
  <tr>
    <td><form action="<%=MM_editAction%>" method="POST" name="UpdateLookupGroup" id="UpdateLookupGroup">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="21%"><p>Name of Lookup Group</p>
            </td>
            <td width="79%"><input name="MemberLookuptxt2ItemName2" type="text" id="MemberLookuptxt2ItemName4" value="<%=(List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemName").Value)%>" size="25">
            </td>
          </tr>
          <tr>
            <td>Descrption of Lookup Group</td>
            <td><input name="MemberLookuptxt2ItemDesc2" type="text" id="MemberLookuptxt2ItemDesc2" value="<%=(List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemDesc").Value)%>" size="50">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <input type="submit" name="Submit3" value="Update">
            </td>
          </tr>
        </table>

        <input type="hidden" name="MM_update" value="UpdateLookupGroup">
        <input type="hidden" name="MM_recordId" value="<%= List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemID").Value %>">
    </form>
    </td>
  </tr>
</table>
<% End If ' end Not List_MemberLookuptxt2.EOF Or NOT List_MemberLookuptxt2.BOF %>
<% If Not List_MemberLookuptxt2.EOF Or Not List_MemberLookuptxt2.BOF Then %>
<table width="100%"border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr valign="middle">
    <td colspan="4" class="tableheader"><table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td width="49%" valign="baseline"><strong>Edit Lookup Group: <font color="#FF0000"><%=(List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemName").Value)%></font></strong></td>
          <td width="51%" valign="baseline">
            <form method="POST" action="<%=MM_editAction%>" name="form1">
              <input name="MemberLookuptxt2Value" type="text" id="MemberLookuptxt2Value" value="" size="32">
              <input type="submit" value="Insert New" name="submit">
              <input type="hidden" name="MM_insert" value="form1">
              <input name="MemberLookuptxt2ItemName" type="hidden" value="<%=(List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemName").Value)%>">
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT List_MemberLookuptxt2.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
    <td width="2%" height="32" valign="baseline"><b>
      <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>
      .</b> </td>
    <td width="80%" valign="middle"><form name="form" method="POST" action="<%=MM_editAction%>">
        <div align="left">
          <input name="MemberLookuptxt2Value" type="text" id="MemberLookuptxt2Value" value="<%=(List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemValue").Value)%>">
          <input type="hidden" name="MM_update" value="form">
          <input type="hidden" name="MM_recordId" value="<%= List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemID").Value %>">
          <input type="submit" name="Submit" value="Update">
        </div>
      </form>
    </td>
    <td width="20%" valign="baseline"><form ACTION="<%=MM_editAction%>" METHOD="POST" name="delete">
        <div align="left">
          <input type="submit" name="Submit" value="Delete">
          <input type="hidden" name="MM_delete" value="delete">
          <input type="hidden" name="MM_recordId" value="<%=(List_MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemID").Value)%>">
        </div>
      </form>
    </td>
  </tr>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  List_MemberLookuptxt2.MoveNext()
Wend
%>
</table>
<% End If ' end Not List_MemberLookuptxt2.EOF Or NOT List_MemberLookuptxt2.BOF %>

<form name="form2" method="post" action="../closewindow_redirect.asp">
  <div align="center">
    <input type="submit" name="Submit2" value="Close">
  </div>
</form>
</body>
</html>
<%
List_MemberLookuptxt2.Close()
%>