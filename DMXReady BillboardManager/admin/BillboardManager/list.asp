<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/billboardmanager.asp" -->
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_billboardmanager_STRING
Category.Source = "SELECT BillboardCategory.CategoryID, BillboardCategory.CategoryName  FROM BillboardCategory INNER JOIN Billboard ON BillboardCategory.CategoryID = Billboard.CategoryID  GROUP BY BillboardCategory.CategoryID, BillboardCategory.CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim List_Billboard__value1
List_Billboard__value1 = "%"
If (Request.querystring("ItemID")  <> "") Then 
  List_Billboard__value1 = Request.querystring("ItemID") 
End If
%>
<%
Dim List_Billboard__value2
List_Billboard__value2 = "%"
If (Request.Form("searchcat")   <> "") Then 
  List_Billboard__value2 = Request.Form("searchcat")  
End If
%>
<%
Dim List_Billboard__value3
List_Billboard__value3 = "%"
If (Request.Form("search")   <> "") Then 
  List_Billboard__value3 = Request.Form("search")  
End If
%>
<%
set List_Billboard = Server.CreateObject("ADODB.Recordset")
List_Billboard.ActiveConnection = MM_billboardmanager_STRING
List_Billboard.Source = "SELECT Billboard.*, BillboardCategory.CategoryName  FROM Billboard INNER JOIN BillboardCategory ON Billboard.CategoryID = BillboardCategory.CategoryID  WHERE ItemID LIKE '" + Replace(List_Billboard__value1, "'", "''") + "' AND  BillboardCategory.CategoryName Like '" + Replace(List_Billboard__value2, "'", "''") + "'  AND ( Billboard.ItemDesc Like '%" + Replace(List_Billboard__value3, "'", "''") + "%' OR Billboard.ItemName Like '%" + Replace(List_Billboard__value3, "'", "''") + "%' OR Billboard.ItemMemo Like '%" + Replace(List_Billboard__value3, "'", "''") + "%')  ORDER BY BillboardCategory.CategoryID, DateAdded DESC"
List_Billboard.CursorType = 0
List_Billboard.CursorLocation = 2
List_Billboard.LockType = 3
List_Billboard.Open()
List_Billboard_numRows = 0
%>
<%
Dim List_BillboardRepeat__numRows
List_BillboardRepeat__numRows = -1
Dim List_BillboardRepeat__index
List_BillboardRepeat__index = 0
List_Billboard_numRows = List_Billboard_numRows + List_BillboardRepeat__numRows
%>
<html>
<head>
<title>Billboard Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<form action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>" method="post" name="form2" id="form2">  
 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
  <tr class="tableheader"> 
    <td height="24" width="50%" valign="baseline">
      <div align="center">Search by Category 
          <select name="searchcat" id="searchcat" >
          <option selected value="%">Show All</option>
          <%
While (NOT Category.EOF)
%>
          <option value="<%=(Category.Fields.Item("CategoryName").Value)%>"><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
                  <input name="submit2" type="submit" value="Go">
  
    </div></td>
    <td height="24" width="50%" valign="baseline"> 
          <div align="center">
            Search by Keyword 
            <input name="search" type="text" id="search">
            <input type="submit" value="Go" name="submit">
          </div></td>
  </tr>
</table>
</form>
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader"> 
    <td>&nbsp; </td>
    <td>Date</td>
    <td>Category</td>
    <td width="16%">Name </td>
    <td width="24%">Description</td>
    <td width="13%"><div align="center">Activated </div></td>
    <td width="14%"><div align="center"><a href="insert.asp">Insert New</a></div></td>
  </tr>
  <% 
While ((List_BillboardRepeat__numRows <> 0) AND (NOT List_Billboard.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> 
    <td width="3%" height="13">      <strong>
    <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>.      </strong>   </td>
    <td width="15%"><%=(List_Billboard.Fields.Item("DateAdded").Value)%></td>
    <td width="15%" height="13"><%=(List_Billboard.Fields.Item("CategoryName").Value)%></td>
    <td width="16%" height="13"><%=(List_Billboard.Fields.Item("ItemName").Value)%> </td>
    <td width="24%" height="13"><%=(List_Billboard.Fields.Item("ItemDesc").Value)%> </td>
    <td width="13%" height="13"> 
      <div align="center">
        <% If List_Billboard.Fields.Item("Activated").Value = "True" Then %>Yes <%else%> No <%end if%>
      </div>
    </td>
    <td width="14%" height="13"><div align="center"><a href="update.asp?ItemID=<%=(List_Billboard.Fields.Item("ItemID").Value)%>">Edit</a> | <a href="delete.asp?ItemID=<%=(List_Billboard.Fields.Item("ItemID").Value)%>">Delete</a></div></td>
  </tr>
  <% 
  List_BillboardRepeat__index=List_BillboardRepeat__index+1
  List_BillboardRepeat__numRows=List_BillboardRepeat__numRows-1
  List_Billboard.MoveNext()
Wend
%>
</table>
</body>
</html>
<%
Category.Close()
%>
<%
List_Billboard.Close()
Set List_Billboard = Nothing
%>
