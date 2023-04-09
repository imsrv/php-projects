<% if Request.Querystring <> "" then %>
<% if Request.Querystring("mid3") <> "" then %>
<a href="admin/SiteChassisManager/html_editor_menu3.asp?mid=<%= Request.Querystring("mid")%>&mid2=<%= Request.Querystring("mid2")%>&mid3=<%= Request.Querystring("mid3")%>" target="_blank">Edit Page</a>
<% end if%>
<% if not Request.Querystring("mid3") <> "" then %>
<% if Request.Querystring("mid2") <> "" then %>
<a href="admin/SiteChassisManager/html_editor_menu2.asp?mid=<%= Request.Querystring("mid")%>&mid2=<%= Request.Querystring("mid2")%>" target="_blank">Edit Page</a>
<% else%>
<a href="admin/SiteChassisManager/html_editor_menu.asp?mid=<%= Request.Querystring("mid")%>" target="_blank">Edit Page</a>
<% end if%>
<% end if%> 
<% end if%> 

