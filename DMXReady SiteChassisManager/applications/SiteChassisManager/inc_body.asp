<!--#include virtual="/Connections/sitechassismanager.asp" -->
<%
Dim menudetail__value1
menudetail__value1 = "1"
If (Request.QueryString("mid")  <> "") Then 
  menudetail__value1 = Request.QueryString("mid") 
End If
%>
<%
Dim menudetail
Dim menudetail_numRows

Set menudetail = Server.CreateObject("ADODB.Recordset")
menudetail.ActiveConnection = MM_sitechassismanager_STRING
menudetail.Source = "SELECT *  FROM tblSitePlanNavMenu  WHERE tblSitePlanNavMenu.mid = " + Replace(menudetail__value1, "'", "''") + ""
menudetail.CursorType = 0
menudetail.CursorLocation = 2
menudetail.LockType = 1
menudetail.Open()

menudetail_numRows = 0
%>
<%
Dim menudetail2__value1
menudetail2__value1 = "0"
If (Request.QueryString("mid2")   <> "") Then 
  menudetail2__value1 = Request.QueryString("mid2")  
End If
%>
<%
Dim menudetail2
Dim menudetail2_numRows

Set menudetail2 = Server.CreateObject("ADODB.Recordset")
menudetail2.ActiveConnection = MM_sitechassismanager_STRING
menudetail2.Source = "SELECT tblSitePlanNavMenu.*, tblSitePlanNavMenu2.*, tblSitePlanNavMenu3.*  FROM (tblSitePlanNavMenu LEFT JOIN tblSitePlanNavMenu2 ON tblSitePlanNavMenu.mid = tblSitePlanNavMenu2.midkey) LEFT JOIN tblSitePlanNavMenu3 ON tblSitePlanNavMenu2.mid2 = tblSitePlanNavMenu3.mid2key  WHERE tblSitePlanNavMenu2.mid2 = " + Replace(menudetail2__value1, "'", "''") + ""
menudetail2.CursorType = 0
menudetail2.CursorLocation = 2
menudetail2.LockType = 1
menudetail2.Open()

menudetail2_numRows = 0
%>
<%
Dim menudetail3__value1
menudetail3__value1 = "0"
If (Request.QueryString("mid3")    <> "") Then 
  menudetail3__value1 = Request.QueryString("mid3")   
End If
%>
<%
Dim menudetail3
Dim menudetail3_numRows

Set menudetail3 = Server.CreateObject("ADODB.Recordset")
menudetail3.ActiveConnection = MM_sitechassismanager_STRING
menudetail3.Source = "SELECT tblSitePlanNavMenu.*, tblSitePlanNavMenu2.*, tblSitePlanNavMenu3.*  FROM (tblSitePlanNavMenu LEFT JOIN tblSitePlanNavMenu2 ON tblSitePlanNavMenu.mid = tblSitePlanNavMenu2.midkey) LEFT JOIN tblSitePlanNavMenu3 ON tblSitePlanNavMenu2.mid2 = tblSitePlanNavMenu3.mid2key  WHERE tblSitePlanNavMenu3.mid3 = " + Replace(menudetail3__value1, "'", "''") + ""
menudetail3.CursorType = 0
menudetail3.CursorLocation = 2
menudetail3.LockType = 1
menudetail3.Open()

menudetail3_numRows = 0
%>
<% If menudetail2.EOF And menudetail2.BOF Then %>
<% If menudetail3.EOF And menudetail3.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="95%" valign="top"> <font size="3"><strong><%=(menudetail.Fields.Item("Menu").Value)%></strong></font>&nbsp
          <p><%=(menudetail.Fields.Item("SectionContent").Value)%> </p>
</td>
    <td align="right" valign="top">
      <% if menudetail.Fields.Item("ImageFileA").Value <> "" then %>
      <p> <img src= "/applications/SiteChassisManager/images/<%=(menudetail.Fields.Item("ImageFileA").Value)%>" width="100"> </p>
      <% end if %>
      <% if menudetail.Fields.Item("ImageFileB").Value <> "" then %>
      <p> <img src= "/applications/SiteChassisManager/images/<%=(menudetail.Fields.Item("ImageFileB").Value)%>" width="100"> </p>
      <% end if %>
    </td>
  </tr>
</table>
<% End If ' end menudetail2.EOF And menudetail2.BOF %>
<% End If ' end menudetail2.EOF And menudetail2.BOF %>
<% If menudetail3.EOF Or menudetail3.BOF Then %>
<% If Not menudetail2.EOF Or Not menudetail2.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
  <td width="95%" valign="top"> <font size="2">
  
  <a href="<% if menudetail2.Fields.Item("PageLink2").Value <> "" then %><%=(menudetail2.Fields.Item("PageLink2").Value)%><%Else%>content.asp<%End If%>?mid=<%=(menudetail2.Fields.Item("mid").Value)%><% if menudetail2.Fields.Item("IncludeFileID").Value <> "" then %>&incid=<%=(menudetail2.Fields.Item("IncludeFileID").Value)%><% end if %><% if menudetail2.Fields.Item("Variables").Value <> "" then %>&<%=(menudetail2.Fields.Item("Variables").Value)%><% end if %>"><%=(menudetail2.Fields.Item("Menu").Value)%></a></font><font size="1">  &gt;</font><font size="3"><strong> <%=(menudetail2.Fields.Item("Menu2").Value)%></strong></font>&nbsp
<p><%=(menudetail2.Fields.Item("SectionContent2").Value)%> </p>
</td>
  <td align="right" valign="top">
    <% if menudetail2.Fields.Item("ImageFileA2").Value <> "" then %>
    <p> <img src= "/applications/SiteChassisManager/images/<%=(menudetail2.Fields.Item("ImageFileA2").Value)%>" width="100"> </p>
    <% end if %>
    <% if menudetail2.Fields.Item("ImageFileB2").Value <> "" then %>
    <p> <img src= "/applications/SiteChassisManager/images/<%=(menudetail2.Fields.Item("ImageFileB2").Value)%>" width="100"> </p>
    <% end if %>
  </td>
</tr>
</table>
<% End If ' end Not menudetail2.EOF Or NOT menudetail2.BOF %>
<% End If ' end menudetail3.EOF Or menudetail3.BOF %>
<% If Not menudetail3.EOF Or Not menudetail3.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
  <td width="95%" valign="top"> <font size="2"><a href="<% if menudetail3.Fields.Item("PageLink").Value <> "" then %><%=(menudetail3.Fields.Item("PageLink").Value)%><%Else%>content.asp<%End If%>?mid=<%=(menudetail3.Fields.Item("mid").Value)%><% if menudetail3.Fields.Item("IncludeFileID").Value <> "" then %>&incid=<%=(menudetail3.Fields.Item("IncludeFileID").Value)%><% end if %><% if menudetail3.Fields.Item("Variables").Value <> "" then %>&<%=(menudetail3.Fields.Item("Variables").Value)%><% end if %>"><%=(menudetail3.Fields.Item("Menu").Value)%></a></font><font size="3"> <font size="1"> &gt;</font><font size="2"> 
  
  <a href="<% if menudetail3.Fields.Item("PageLink2").Value <> "" then %><%=(menudetail3.Fields.Item("PageLink2").Value)%><%Else%>content.asp<%End If%>?mid=<%=(menudetail3.Fields.Item("mid").Value)%>&mid2=<%=(menudetail3.Fields.Item("mid2").Value)%><% if menudetail3.Fields.Item("IncludeFileID2").Value <> "" then %>&incid2=<%=(menudetail3.Fields.Item("IncludeFileID2").Value)%><% end if %><% if menudetail3.Fields.Item("Variables2").Value <> "" then %>&<%=(menudetail3.Fields.Item("Variables2").Value)%><% end if %>"><%=(menudetail3.Fields.Item("Menu2").Value)%></a>
 </font><font size="1"> &gt; </font><strong><%=(menudetail3.Fields.Item("Menu3").Value)%></strong></font>&nbsp
    <p><%=(menudetail3.Fields.Item("SectionContent3").Value)%> </p>
</td>
  <td align="right" valign="top">
    <% if menudetail3.Fields.Item("ImageFileA3").Value <> "" then %>
    <p> <img src= "/applications/SiteChassisManager/images/<%=(menudetail3.Fields.Item("ImageFileA3").Value)%>" width="100"> </p>
    <% end if %>
    <% if menudetail3.Fields.Item("ImageFileB3").Value <> "" then %>
    <p> <img src= "/applications/SiteChassisManager/images/<%=(menudetail3.Fields.Item("ImageFileB3").Value)%>" width="100"> </p>
    <% end if %>
  </td>
</tr>
</table>
<% End If ' end Not menudetail3.EOF Or NOT menudetail3.BOF %>
<!--#include file="extras/inc_include_rules.asp" -->
<%
menudetail.Close()
Set menudetail = Nothing
%>
<%
menudetail2.Close()
Set menudetail2 = Nothing
%>
<%
menudetail3.Close()
Set menudetail3 = Nothing
%>
