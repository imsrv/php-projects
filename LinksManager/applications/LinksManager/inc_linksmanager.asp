<!--#include virtual="/Connections/linksmanager.asp" -->
<%
Dim List_Links__MMColParam1
List_Links__MMColParam1 = "%"
If (Request.Form("search")   <> "") Then 
  List_Links__MMColParam1 = Request.Form("search")  
End If
%>
<%
set List_Links = Server.CreateObject("ADODB.Recordset")
List_Links.ActiveConnection = MM_linksmanager_STRING
List_Links.Source = "SELECT Links.*, LinksCategory.CategoryName, LinksCategory.ParentCategoryID, LinksCategory.CategoryDesc  FROM LinksCategory RIGHT JOIN Links ON LinksCategory.CategoryID = Links.CategoryID  WHERE Activated = 'True' AND (LinksCategory.CategoryName Like '" + Replace(List_Links__MMColParam1, "'", "''") + "'  OR Links.ItemDesc Like '%" + Replace(List_Links__MMColParam1, "'", "''") + "%' OR Links.ItemName Like '%" + Replace(List_Links__MMColParam1, "'", "''") + "%' OR Links.ItemUrl Like '%" + Replace(List_Links__MMColParam1, "'", "''") + "%')  ORDER BY LinksCategory.CategoryName"
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
Dim RepeatList_Links__numRows
RepeatList_Links__numRows = -1
Dim RepeatList_Links__index
RepeatList_Links__index = 0
List_Links_numRows = List_Links_numRows + RepeatList_Links__numRows
%>
<% Dim TFM_nestcat, lastTFM_nestcat%>
<link href="../../styles.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableborder" height="42">
  <tr> 
    <td height="17" width="50%"> 
      <form name="form1" method="post" action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">
        <div align="center">Search by Category 
          <select name="Search" id="Search">
          <option value="%" <%If (Not isNull(Request.Form("Search"))) Then If ("%" = CStr(Request.Form("Search"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
          <%
While (NOT Category.EOF)
%>
          <option value="<%=(Category.Fields.Item("CategoryName").Value)%>" <%If (Not isNull(Request.Form("Search"))) Then If (CStr(Category.Fields.Item("CategoryName").Value) = CStr(Request.Form("Search"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
      <form name="form" method="post" action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">
        <div align="center">Search by Keyword 
          <input type="text" name="Search">
          <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <% 
While ((RepeatList_Links__numRows <> 0) AND (NOT List_Links.EOF)) 
%>
  <tr> 
    <td colspan="2" valign="middle">      <% TFM_nestcat = List_Links.Fields.Item("CategoryName").Value
If lastTFM_nestcat <> TFM_nestcat Then 
	lastTFM_nestcat = TFM_nestcat %>          <br>          <strong><%=(List_Links.Fields.Item("CategoryName").Value)%></strong>    <%End If 'End Basic-UltraDev Simulated Nested Repeat %>        
    </td>
  </tr>
  <tr><td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="99%" height="15"><li><a href="<%=(List_Links.Fields.Item("ItemUrl").Value)%>" target="_blank"><%=(List_Links.Fields.Item("ItemName").Value)%></a></li>
    </td>
  </tr>
  <% 
  RepeatList_Links__index=RepeatList_Links__index+1
  RepeatList_Links__numRows=RepeatList_Links__numRows-1
  List_Links.MoveNext()
Wend
%>
</table>
<div align="center">
  <% If List_Links.EOF And List_Links.BOF Then %>
  <p>Sorry....No Records Found
  </p>
  <% End If ' end List_Links.EOF And List_Links.BOF %>
</div>
<hr size="1" noshade>
<%
List_Links.Close()
%>
<%
Category.Close()
%>