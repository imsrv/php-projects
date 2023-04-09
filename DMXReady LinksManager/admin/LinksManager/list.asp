<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/linksmanager.asp" -->
<%
Dim List_Links__MMColParam1
List_Links__MMColParam1 = "%"
if (Request.Form("search")  <> "") then List_Links__MMColParam1 = Request.Form("Search") 
%>
<%
set List_Links = Server.CreateObject("ADODB.Recordset")
List_Links.ActiveConnection = MM_linksmanager_STRING
List_Links.Source = "SELECT Links.*, LinksCategory.CategoryName, LinksCategory.ParentCategoryID, LinksCategory.CategoryDesc  FROM LinksCategory RIGHT JOIN Links ON LinksCategory.CategoryID = Links.CategoryID  WHERE LinksCategory.CategoryName Like '" + Replace(List_Links__MMColParam1, "'", "''") + "'  OR Links.ItemDesc Like '%" + Replace(List_Links__MMColParam1, "'", "''") + "%' OR Links.ItemName Like '%" + Replace(List_Links__MMColParam1, "'", "''") + "%' OR Links.ItemUrl Like '%" + Replace(List_Links__MMColParam1, "'", "''") + "%'  ORDER BY LinksCategory.CategoryName"
List_Links.CursorType = 0
List_Links.CursorLocation = 2
List_Links.LockType = 3
List_Links.Open()
List_Links_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_linksmanager_STRING
Category.Source = "SELECT LinksCategory.CategoryID, LinksCategory.CategoryName, LinksCategory.ParentCategoryID, LinksCategory.CategoryDesc  FROM LinksCategory INNER JOIN Links ON LinksCategory.CategoryID = Links.CategoryID  GROUP BY LinksCategory.CategoryID, LinksCategory.CategoryName, LinksCategory.ParentCategoryID, LinksCategory.CategoryDesc  ORDER BY LinksCategory.CategoryName"
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
List_Links_numRows = List_Links_numRows + Repeat1__numRows
%>
<html>
<head>
<title>List</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<table width="100%" height="42" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr> 
    <td height="17" width="50%"> 
      <form name="form1" method="post" action="">
        <div align="center">Search by Category
          <select name="search" id="search">
            <option value="%" <%If (Not isNull(Request.Form("search"))) Then If ("%" = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
            <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("CategoryName").Value)%>" <%If (Not isNull(Request.Form("search"))) Then If (CStr(Category.Fields.Item("CategoryName").Value) = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
    <td width="31%">Name </td>
    <td width="24%">Link URL</td>
    <td width="27%"><div align="center"> <a href="insert.asp">Insert New</a> </div></td>
  </tr>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT List_Links.EOF)) 
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
    <td width="16%" height="13"><%=(List_Links.Fields.Item("CategoryName").Value)%></td>
    <td width="31%" height="13"><%=(List_Links.Fields.Item("ItemName").Value)%> </td>
    <td width="24%" height="13"><a href="<%=(List_Links.Fields.Item("ItemUrl").Value)%>" target="_blank"><%=(List_Links.Fields.Item("ItemUrl").Value)%></a> </td>
    <td width="27%" height="13"> 
      <div align="center"><a href="update.asp?ItemID=<%=(List_Links.Fields.Item("ItemID").Value)%>">Edit</a> 
        | <a href="delete.asp?ItemID=<%=(List_Links.Fields.Item("ItemID").Value)%>">Delete</a></div>
    </td>
  </tr>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  List_Links.MoveNext()
Wend
%>
</table>
</body>
</html>
<%
List_Links.Close()
%>
<%
Category.Close()
%>





