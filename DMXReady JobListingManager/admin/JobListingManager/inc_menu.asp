<table width="100%" border="0" cellpadding="3" cellOR spacing="0" bgcolor="#FFFFCC" class="activeborder">
  <tr>
    <td>
      <% IF Request.QueryString("action") = "insert" Then %>
    <font size="4"><strong>Add New Job </strong></font>(Once your job is added
    you can click on the &quot;Edit Job &quot; link to add additional details)    
    <% Elseif Request.QueryString("action") = "update" Then %>
    <font size="4"><strong>View/Edit Jobs</strong></font> (You can edit basic
    details directly on the page or click on the &quot;Edit Details&quot; link
    on the right to access the advanced editor)
    <% Elseif Request.QueryString("action") = "detail" Then %>
    <font size="4"><strong>Edit Job Detail </strong></font>(Use the advanced
    editor to add/edit Job details)
	 <% Elseif Request.QueryString("action") = "" AND Request.QueryString("settings") <> "paypal" Then %>
     <font size="4"><strong>Manage Job Listings </strong></font>(You can edit
     basic details directly on the page or click on the &quot;Edit Details&quot; link
     on the right to access the advanced editor)
     
	<%end if%></td>
	<% IF Request.QueryString("action") <> "" THEN %>
	 <td>
	<div align="right">[<a href="list.asp?action=insert">Add Job </a>]&nbsp;&nbsp;[<a href="list.asp?action=update">View/Edit
          Jobs</a>]
          <% IF Request.QueryString("ItemID") <> "" Then %>
          &nbsp;&nbsp;[<a href="/applications/JobListingManager/inc_joblistingmanager.asp?ItemID=<%=Request.QueryString("ItemID")%>&CategoryID=<%=Request.QueryString("CategoryID")%>" target="_blank">Live
Preview</a>]&nbsp;&nbsp;[<a href="delete.asp?ItemID=<%=Request.QueryString("ItemID")%>">Delete
Job
</a>]
<%end if%>
      </div>
    </td>
	<%end if%>
  </tr>
</table>