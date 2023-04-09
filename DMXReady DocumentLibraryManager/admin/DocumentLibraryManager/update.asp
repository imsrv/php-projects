<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/documentlibrarymanager.asp" -->
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
' *** Update Record: set variables
If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then
  MM_editConnection = MM_documentlibrarymanager_STRING
  MM_editTable = "DocumentLibrary"
 MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "CategoryID|value|LibraryItemName|value|LibraryItemDescription|value|file|value|LibraryActivated|value|DateAdded|value"
  MM_columnsStr = "CategoryID|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|ItemLink|',none,''|Activated|',none,''|DateAdded|',none,NULL"
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
' *** Update Record: construct a sql update statement and execute it
If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then
 ' create the sql update statement
  MM_editQuery = "update " & MM_editTable & " set "
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
      MM_editQuery = MM_editQuery & ","
    End If
    MM_editQuery = MM_editQuery & MM_columns(i) & " = " & FormVal
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
Dim List_Library__MMcolParam
List_Library__MMcolParam = "1000"
If (Request.QueryString("ItemID")  <> "") Then 
  List_Library__MMcolParam = Request.QueryString("ItemID") 
End If
%>
<%
set List_Library = Server.CreateObject("ADODB.Recordset")
List_Library.ActiveConnection = MM_documentlibrarymanager_STRING
List_Library.Source = "SELECT *  FROM DocumentLibrary  WHERE ItemID = " + Replace(List_Library__MMcolParam, "'", "''") + ""
List_Library.CursorType = 0
List_Library.CursorLocation = 2
List_Library.LockType = 3
List_Library.Open()
List_Library_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_documentlibrarymanager_STRING
Category.Source = "SELECT *  FROM DocumentLibraryCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
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
<!--#include file="header.asp"-->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> 
            <form method="POST" action="<%=MM_editAction%>" name="form1">
              <table width="100%" align="center" class="tableborder">
                <tr valign="baseline"> 
                  <td colspan="2" align="right" nowrap class="tableheader">Update
                    Record</td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" nowrap class="tableheader">Document ID: 
                  </td>
                  <td><%=(List_Library.Fields.Item("ItemID").Value)%></td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" nowrap class="tableheader">Category: </td>
                  <td> 
                    <select name="CategoryID">
                      <%
While (NOT Category.EOF)
%>
                      <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull(List_Library.Fields.Item("CategoryID").Value)) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr(List_Library.Fields.Item("CategoryID").Value)) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
                      <%
  Category.MoveNext()
Wend
If (Category.CursorType > 0) Then
  Category.MoveFirst
Else
  Category.Requery
End If
%>
                    </select>
                    | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=400,height=300')">add/edit
              category</a> <img src="questionmark.gif" alt="select a category that best describes the document" width="15" height="15"></td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" valign="top" nowrap class="tableheader">Document  Name:</td>
                  <td> 
                    <textarea name="LibraryItemName" cols="60" rows="2"><%=(List_Library.Fields.Item("ItemName").Value)%></textarea>
                  <img src="questionmark.gif" alt="Enter a short name to identify the document" width="15" height="15">                  </td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" valign="top" nowrap class="tableheader">Document  Description:</td>
                  <td> 
                    <textarea name="LibraryItemDescription" cols="60" rows="5"><%=(List_Library.Fields.Item("ItemDesc").Value)%></textarea>
                    <img src="questionmark.gif" alt="Enter a description of the document" width="15" height="15">                  </td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" nowrap class="tableheader">Link to Download File:</td>
                  <td> 
                    View Document:                    <a href="../../applications/DocumentLibraryManager/upload/<%=(List_Library.Fields.Item("ItemLink").Value)%>"><%=(List_Library.Fields.Item("ItemLink").Value)%></a> | 
                    <input type="text" name="file" value="<%=(List_Library.Fields.Item("ItemLink").Value)%>"> |
					<a href="javascript:;" onClick="MM_openBrWindow('upload_document.asp?ItemID=<%=(List_Library.Fields.Item("ItemID").Value)%>','Category','scrollbars=yes,width=400,height=300')"> 
					Upload New Document</a><img src="questionmark.gif" alt="Click the (Update Document) link if you wish to replace existing file " width="15" height="15"> </td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" nowrap class="tableheader">Activated:</td>
                  <td> 
                    <input type="checkbox" name="LibraryActivated" <%If (CStr((List_Library.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> value="True">
                  <img src="questionmark.gif" alt="(Check if you want this document to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15">                  </td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" nowrap class="tableheader">Date Added:</td>
                  <td><input name="DateAdded" type="text" id="DateAdded" value="<%=(List_Library.Fields.Item("DateAdded").Value)%>"></td>
                </tr>
                <tr valign="baseline"> 
                  <td align="right" nowrap class="tableheader">&nbsp;</td>
                  <td> 
                    <input type="submit" value="Update Record">
                  </td>
                </tr>
              </table>             
<input type="hidden" name="MM_update" value="form1">
<input type="hidden" name="MM_recordId" value="<%= List_Library.Fields.Item("ItemID").Value %>">
            </form>
          </td>
        </tr>
</table>
    </td>
</body>
</html>
<%
List_Library.Close()
%>
<%
Category.Close()
%>