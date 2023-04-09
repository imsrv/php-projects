<!--#include virtual="/Connections/sitechassismanager.asp" -->
<%
Dim menu
Dim menu_numRows

Set menu = Server.CreateObject("ADODB.Recordset")
menu.ActiveConnection = MM_sitechassismanager_STRING
menu.Source = "SELECT *  FROM tblSitePlanNavMenu  WHERE Activated = 'True'  ORDER BY SortOrder"
menu.CursorType = 0
menu.CursorLocation = 2
menu.LockType = 1
menu.Open()

menu_numRows = 0
%>
<%
Dim Repeat2__numRows
Dim Repeat2__index

Repeat2__numRows = -1
Repeat2__index = 0
menu_numRows = menu_numRows + Repeat2__numRows
%>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
    <% 
While ((Repeat2__numRows <> 0) AND (NOT menu.EOF)) 
%>&nbsp;&nbsp;<strong>:</strong>&nbsp;&nbsp;<a href="/<% if menu.Fields.Item("PageLink").Value <> "" then %><%=(menu.Fields.Item("PageLink").Value)%><%Else%>/content.asp<%End If%>?mid=<%=(menu.Fields.Item("mid").Value)%><% if menu.Fields.Item("IncludeFileID").Value <> "" then %>&incid=<%=(menu.Fields.Item("IncludeFileID").Value)%><% end if %><% if menu.Fields.Item("Variables").Value <> "" then %>&<%=(menu.Fields.Item("Variables").Value)%><% end if %>"><strong><%=(menu.Fields.Item("Menu").Value)%></strong></a>
    <% 
  Repeat2__index=Repeat2__index+1
  Repeat2__numRows=Repeat2__numRows-1
  menu.MoveNext()
Wend
%>
</td>
  </tr>
</table>
    <%
menu.Close()
Set menu = Nothing
%>
