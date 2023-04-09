<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include virtual="/Connections/newsmanager.asp"-->
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

  MM_editConnection = MM_newsmanager_STRING
  MM_editTable = "tblNM_NewsCategory"
  MM_editColumn = "CategoryID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "list.asp"
  MM_fieldsStr  = "CategoryValue|value|CategoryDesc|value|CategoryImageFile|value"
  MM_columnsStr = "CategoryValue|',none,''|CategoryDesc|',none,''|CategoryImageFile|',none,''"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

  ' append the query string to the redirect URL
 ' If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
  '  If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
   '   MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    'Else
     ' MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
   ' End If
 ' End If

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
Dim Category__MMColParam
Category__MMColParam = "0"
If (Request.QueryString("cid")    <> "") Then 
  Category__MMColParam = Request.QueryString("cid")   
End If
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_newsmanager_STRING
Category.Source = "SELECT *  FROM tblNM_NewsCategory  WHERE CategoryID = " + Replace(Category__MMColParam, "'", "''") + ""
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
Recordset1_numRows = Recordset1_numRows + Repeat1__numRows
%>
<html>
<head>
<title>Category Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<Body>
<!--#include file="header.asp" -->
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="form1" >
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr>
    <td height="28" colspan="2" class="tableheader">Update  Category</td>
    </tr>
    <tr>
      <td width="25%" height="27" class="tableheader">Category Name</td>
      <td width="86%"><input name="CategoryValue" type="text" id="CategoryValue" value="<%=(Category.Fields.Item("CategoryValue").Value)%>">
      </td>
    </tr>
  <tr>
    <td height="26" class="tableheader">Category Desc</td>
    <td><textarea name="CategoryDesc" id="CategoryDesc"><%=(Category.Fields.Item("CategoryDesc").Value)%></textarea>
</td>
  </tr>
    <tr>
      <td  class="tableheader">
          <p>Category Image</p>
          <p>&nbsp; </p>
      </td>
      <td valign="baseline">
        <% if Category.Fields.Item("CategoryImageFile").Value <>"" Then %>
        <img src="../../../applications/assets/images/<%=(Category.Fields.Item("CategoryImageFile").Value)%>" width="50">
        <%else%>
        <a href="javascript:;" onClick="MM_openBrWindow('update_image_category.asp?cid=<%=(Category.Fields.Item("CategoryID").Value)%>','image','width=300,height=150')">Click
        here to Upload Image</a>
        <%end if%>
        <input name="CategoryImageFile" type="text" id="CategoryImageFile" value="<%=(Category.Fields.Item("CategoryImageFile").Value)%>">
      </td>
    </tr>
    <tr>
      <td align="right" valign="baseline" class="tableheader" >&nbsp;</td>
      <td valign="baseline"><input name="submit" type="submit" value="Update Record"></td>
    </tr>
  </table>
  
  

    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="MM_recordId" value="<%= Category.Fields.Item("CategoryID").Value %>">
</form>
<p>&nbsp;</p>
</body>
</html>
<%
Category.Close()
%>
