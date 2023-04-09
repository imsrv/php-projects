<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/accountlistmanager.asp" -->
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
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "CreateCategoryLabel") Then

  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_AccountsCategory"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "CategoryLabel|value|CategoryDesc|value|CategoryValue|value"
  MM_columnsStr = "CategoryLabel|',none,''|CategoryDesc|',none,''|CategoryValue|',none,''"

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

If (CStr(Request("MM_update")) = "UpdateCategoryLabel" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_AccountsCategory"
  MM_editColumn = "CategoryID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "CategoryLabel|value|CategoryDesc|value"
  MM_columnsStr = "CategoryLabel|',none,''|CategoryDesc|',none,''"

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

If (CStr(Request("MM_update")) = "ManageCategoryValues" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_AccountsCategory"
  MM_editColumn = "CategoryID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "CategoryValue|value"
  MM_columnsStr = "CategoryValue|',none,''"

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
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "InsertCategoryValue") Then

  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_AccountsCategory"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "CategoryValue|value|CategoryLabel|value"
  MM_columnsStr = "CategoryValue|',none,''|CategoryLabel|',none,''"

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
' *** Delete Record: declare variables

if (CStr(Request("MM_delete")) = "delete" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_AccountsCategory"
  MM_editColumn = "CategoryID"
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
' *** Insert Record: construct a sql insert statement and execute it

Dim MM_tableValues
Dim MM_dbValues

If (CStr(Request("MM_insert")) <> "") Then

  ' create the sql insert statement
  MM_tableValues = ""
  MM_dbValues = ""
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
      MM_tableValues = MM_tableValues & ","
      MM_dbValues = MM_dbValues & ","
    End If
    MM_tableValues = MM_tableValues & MM_columns(MM_i)
    MM_dbValues = MM_dbValues & MM_formVal
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
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_accountlistmanager_STRING
Category.Source = "SELECT *  FROM tblAM_AccountsCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeat1__numRows
Repeat1__numRows = -1
Dim Repeat1__index
Repeat1__index = 0
Category_numRows = Category_numRows + Repeat1__numRows
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
<title>Category Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<% If Category.EOF And Category.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tableborder">
  <tr>
    <td class="tableheader">Create Category Label</td>
  </tr>
  <tr>
    <td><form action="<%=MM_editAction%>" method="POST" name="CreateCategoryLabel" id="CreateCategoryLabel">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="21%"><p>Category Label</p>
            </td>
            <td width="79%"><input name="CategoryLabel" type="text" id="CategoryLabel" size="25">
            </td>
          </tr>
          <tr>
            <td>Descrption of Category Label</td>
            <td><input name="CategoryDesc" type="text" id="CategoryDesc" size="50">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit32" value="Create">
              <input name="CategoryValue" type="hidden" id="CategoryValue" value="List Value">
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="CreateCategoryLabel">
      </form>
    </td>
  </tr>
</table>
<% End If ' end Category.EOF And Category.BOF %>
<% If Not Category.EOF Or Not Category.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tableborder">
  <tr>
    <td class="tableheader">Update Category Label</td>
  </tr>
  <tr>
    <td><form ACTION="<%=MM_editAction%>" METHOD="POST" name="UpdateCategoryLabel" id="UpdateCategoryLabel">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="21%"><p>Category Label</p>
            </td>
            <td width="79%"><input name="CategoryLabel" type="text" id="CategoryLabel" value="<%=(Category.Fields.Item("CategoryLabel").Value)%>" size="25">
            </td>
          </tr>
          <tr>
            <td>Descrption of Category Label</td>
            <td><input name="CategoryDesc" type="text" id="CategoryDesc" value="<%=(Category.Fields.Item("CategoryDesc").Value)%>" size="50">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <input type="submit" name="Submit3" value="Update">
            </td>
          </tr>
        </table>

        
        
    
        <input type="hidden" name="MM_update" value="UpdateCategoryLabel">
        <input type="hidden" name="MM_recordId" value="<%= Category.Fields.Item("CategoryID").Value %>">
    </form>
    </td>
  </tr>
</table>
<% End If ' end Not Category.EOF Or NOT Category.BOF %>
<% If Not Category.EOF Or Not Category.BOF Then %>
<table width="100%"border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr valign="middle">
    <td colspan="4" class="tableheader"><table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td width="49%" valign="baseline"><strong>Add list values to Category
              labeled as: <font color="#FF0000"><%=(Category.Fields.Item("CategoryLabel").Value)%></font></strong></td>
          <td width="51%" valign="baseline">
            <form method="POST" action="<%=MM_editAction%>" name="InsertCategoryValue" id="InsertCategoryValue">
              <input name="CategoryValue" type="text" id="CategoryValue" value="" size="32">
              <input type="submit" value="Insert New" name="submit">
              <input name="CategoryLabel" type="hidden" id="CategoryLabel" value="<%=(Category.Fields.Item("CategoryLabel").Value)%>">
              <input type="hidden" name="MM_insert" value="InsertCategoryValue">
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT Category.EOF)) 
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
    <td width="80%" valign="middle"><form name="ManageCategoryValues" method="POST" action="<%=MM_editAction%>">
        <div align="left">
          <input name="CategoryValue" type="text" id="CategoryValue" value="<%=(Category.Fields.Item("CategoryValue").Value)%>">
          <input type="hidden" name="MM_recordId" value="<%= Category.Fields.Item("CategoryID").Value %>">
        <input type="hidden" name="MM_update" value="ManageCategoryValues"> 
        <input type="submit" name="Submit4" value="Update">
		</div>
    </form>
    </td>
    <td width="20%" valign="baseline"><form ACTION="<%=MM_editAction%>" METHOD="POST" name="delete">
        <div align="left">
        <input type="submit" name="Submit" value="Delete">
        <input type="hidden" name="MM_recordId" value="<%= Category.Fields.Item("CategoryID").Value %>">
        <input type="hidden" name="MM_delete" value="delete">
</div>
    </form>
    </td>
  </tr>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  Category.MoveNext()
Wend
%>
</table>
<% End If ' end Not Category.EOF Or NOT Category.BOF %>
<form name="form2" method="post" action="closewindow_redirect.asp">
  <div align="center">
    <input type="submit" name="Submit2" value="Close">
  </div>
</form>
</body>
</html>
<%
Category.Close()
%>
