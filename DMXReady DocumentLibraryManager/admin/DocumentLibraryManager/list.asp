<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/documentlibrarymanager.asp" -->
<%
Dim List__MMColParam1
List__MMColParam1 = "%"
If (Request.Form("search")   <> "") Then 
  List__MMColParam1 = Request.Form("search")  
End If
%>
<%
Dim List__MMColParam2
List__MMColParam2 = "%"
If (Request.Form("searchcat")   <> "") Then 
  List__MMColParam2 = Request.Form("searchcat")  
End If
%>
<%
set List = Server.CreateObject("ADODB.Recordset")
List.ActiveConnection = MM_documentlibrarymanager_STRING
List.Source = "SELECT DocumentLibrary.*, DocumentLibraryCategory.CategoryName, DocumentLibraryCategory.CategoryDesc  FROM DocumentLibraryCategory RIGHT JOIN DocumentLibrary ON DocumentLibraryCategory.CategoryID = DocumentLibrary.CategoryID  WHERE DocumentLibraryCategory.CategoryName Like '" + Replace(List__MMColParam2, "'", "''") + "'  AND (DocumentLibrary.ItemDesc Like '%" + Replace(List__MMColParam1, "'", "''") + "%' OR DocumentLibrary.ItemName Like '%" + Replace(List__MMColParam1, "'", "''") + "%' OR DocumentLibrary.ItemLink Like '%" + Replace(List__MMColParam1, "'", "''") + "%' OR DocumentLibraryCategory.CategoryName Like '%" + Replace(List__MMColParam1, "'", "''") + "%')  ORDER BY CategoryName, DateAdded"
List.CursorType = 0
List.CursorLocation = 2
List.LockType = 3
List.Open()
List_numRows = 0
%>
<%
Dim RepeatLibraryList__numRows
RepeatLibraryList__numRows = -1
Dim RepeatLibraryList__index
RepeatLibraryList__index = 0
List_numRows = List_numRows + RepeatLibraryList__numRows
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_documentlibrarymanager_STRING
Category.Source = "SELECT DocumentLibraryCategory.CategoryID, DocumentLibraryCategory.CategoryName  FROM DocumentLibrary INNER JOIN DocumentLibraryCategory ON DocumentLibrary.CategoryID = DocumentLibraryCategory.CategoryID  GROUP BY DocumentLibraryCategory.CategoryID, DocumentLibraryCategory.CategoryName  ORDER BY DocumentLibraryCategory.CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<html>
<head>
<title>List</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp"-->
<table width="100%" height="42" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr> 
    <td height="17" width="50%"> 
      <form name="form1" method="post" action="">
        <div align="center">
          <% If Not Category.EOF Or Not Category.BOF Then %>
Search by Category
<select name="searchcat" id="searchcat">
            <option value="%" <%If (Not isNull(request.form("searchcat"))) Then If ("%" = CStr(request.form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
            All</option>
            <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("CategoryName").Value)%>" <%If (Not isNull(request.form("searchcat"))) Then If (CStr(Category.Fields.Item("CategoryName").Value) = CStr(request.form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
          <input type="submit" value="Go" name="submit2">
          <% End If ' end Not Category.EOF Or NOT Category.BOF %>
        </div>
      </form>
    </td>
    <td height="17" width="50%"> 
      <form name="form" method="post" action="">
        <div align="center">Search by Keyword 
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader"> 
    <td colspan="2"> Category</td>
    <td width="31%">Item Name </td>
    <td width="24%">Download Link</td>
    <td width="27%"><div align="center"> <a href="insert.asp">Insert New</a></div></td>
  </tr>
  <% 
While ((RepeatLibraryList__numRows <> 0) AND (NOT List.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> 
    <td width="2%" height="13">      <strong>
    <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>.      </strong>   </td>
    <td width="16%" height="13"><%=(List.Fields.Item("CategoryName").Value)%></td>
    <td width="31%" height="13"><%=(List.Fields.Item("ItemName").Value)%> </td>
    <td width="24%" height="13"><a href="../../applications/DocumentLibraryManager/upload/<%=(List.Fields.Item("ItemLink").Value)%>" target="_blank"><%=(List.Fields.Item("ItemLink").Value)%></a> </td>
    <td width="27%" height="13"> 
      <div align="center"><a href="update.asp?ItemID=<%=(List.Fields.Item("ItemID").Value)%>">Edit</a> 
        | <a href="delete.asp?ItemID=<%=(List.Fields.Item("ItemID").Value)%>">Delete</a></div>
    </td>
  </tr>
  <% 
  RepeatLibraryList__index=RepeatLibraryList__index+1
  RepeatLibraryList__numRows=RepeatLibraryList__numRows-1
  List.MoveNext()
Wend
%>
</table>
</body>
</html>
<%
List.Close()
%>
<%
Category.Close()
%>




