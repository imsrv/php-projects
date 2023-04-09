<!--#include virtual="/Connections/sitechassismanager.asp" -->
<%
Dim menu2__value1
menu2__value1 = "0"
If (request.querystring("mid")         <> "") Then 
  menu2__value1 = request.querystring("mid")        
End If
%>
<%
Dim menu2
Dim menu2_numRows

Set menu2 = Server.CreateObject("ADODB.Recordset")
menu2.ActiveConnection = MM_sitechassismanager_STRING
menu2.Source = "SELECT tblSitePlanNavMenu.mid, tblSitePlanNavMenu.Menu, tblSitePlanNavMenu2.*  FROM tblSitePlanNavMenu INNER JOIN tblSitePlanNavMenu2 ON tblSitePlanNavMenu.mid = tblSitePlanNavMenu2.midkey  WHERE (((tblSitePlanNavMenu2.midkey) Like '" + Replace(menu2__value1, "'", "''") + "') AND ((tblSitePlanNavMenu2.Activated2)='True'))  ORDER BY tblSitePlanNavMenu2.SortOrder2"
menu2.CursorType = 0
menu2.CursorLocation = 2
menu2.LockType = 1
menu2.Open()

menu2_numRows = 0
%>
<%
Dim menu3__value1
menu3__value1 = "0"
If (Request.QueryString("mid2") <> "") Then 
  menu3__value1 = Request.QueryString("mid2")
End If
%>
<%
Dim menu3
Dim menu3_numRows

Set menu3 = Server.CreateObject("ADODB.Recordset")
menu3.ActiveConnection = MM_sitechassismanager_STRING
menu3.Source = "SELECT tblSitePlanNavMenu3.*  FROM tblSitePlanNavMenu3  WHERE tblSitePlanNavMenu3.Activated3 = 'True' AND mid2key = " + Replace(menu3__value1, "'", "''") + "  ORDER BY SortOrder3"
menu3.CursorType = 0
menu3.CursorLocation = 2
menu3.LockType = 1
menu3.Open()

menu3_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
menu2_numRows = menu2_numRows + Repeat1__numRows
%>
<% If Not menu2.EOF Or Not menu2.BOF Then %>
&nbsp;&nbsp;<b><%=(menu2.Fields.Item("Menu").Value)%></b><br>
<% 
While ((Repeat1__numRows <> 0) AND (NOT menu2.EOF)) 
%>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<a href="<% if menu2.Fields.Item("PageLink2").Value <> "" then %>/<%=(menu2.Fields.Item("PageLink2").Value)%><%Else%>/content.asp<%End If%>?mid=<%= Request.QueryString("mid") %>&mid2=<%=(menu2.Fields.Item("mid2").Value)%><% if menu2.Fields.Item("IncludeFileID2").Value <> "" then %>&incid=<%=(menu2.Fields.Item("IncludeFileID2").Value)%><% end if %><% if menu2.Fields.Item("Variables2").Value <> "" then %>&<%=(menu2.Fields.Item("Variables2").Value)%><% end if %>"><strong><%=(menu2.Fields.Item("Menu2").Value)%></strong></a></td>
  </tr>
  <tr>
    <td>
      <%
FilterParam = menu2.Fields.Item("mid2").Value
menu3.Filter = "mid2key = " & FilterParam 
While (NOT menu3.EOF)
%>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<% if menu3.Fields.Item("PageLink3").Value <> "" then %>/<%=(menu3.Fields.Item("PageLink3").Value)%><%Else%>/content.asp<%End If%>?mid=<%= Request.QueryString("mid") %>&mid2=<%=(menu3.Fields.Item("mid2key").Value)%>&mid3=<%=(menu3.Fields.Item("mid3").Value)%><% if menu3.Fields.Item("IncludeFileID3").Value <> "" then %>&incid=<%=(menu3.Fields.Item("IncludeFileID3").Value)%><% end if %><% if menu3.Fields.Item("Variables3").Value <> "" then %>&<%=(menu3.Fields.Item("Variables3").Value)%><% end if %>"><%=(menu3.Fields.Item("Menu3").Value)%></a><br>
<% 
menu3.MoveNext()
Wend
%>
</td>
  </tr>
</table>
<% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  menu2.MoveNext()
Wend
%>
<% End If ' end Not menu2.EOF Or NOT menu2.BOF %>
<p>
  <%
menu2.Close()
Set menu2 = Nothing
%>
  <%
menu3.Close()
Set menu3 = Nothing
%>
