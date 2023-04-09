<table width="100%" border="0" cellpadding="3" cellOR spacing="0" bgcolor="#FFFFCC" class="activeborder">
  <tr>
    <td>
      <% IF Request.QueryString("action") = "insert" Then %>
    <font size="4"><strong>Add New Item </strong></font>(Once your Item is added you can click on the &quot;Edit Items&quot; link to add additional details)    
    <% Elseif Request.QueryString("action") = "update" Then %>
    <font size="4"><strong>View/Edit Items </strong></font>(You can edit basic
    details directly on the page or click on the &quot;Edit Details&quot; link
    on the right to access the advanced editor)
    <% Elseif Request.QueryString("action") = "detail" Then %>
    <font size="4"><strong>Edit Item Detail </strong></font>(Use the advanced
    editor to add/edit Item details)
	 <% Elseif Request.QueryString("action") = "" AND Request.QueryString("settings") <> "paypal" Then %>
     <font size="4"><strong>Manage Catalog Items </strong></font>(You can edit
     basic details directly on the page or click on the &quot;Edit Details&quot; link
     on the right to access the advanced editor)
    <% Elseif Request.QueryString("settings") = "paypal" Then %>
	<font size="4"><strong>PayPal Settings </strong></font>(Configure PayPal settings)
	</strong></font>
	<%end if%></td>
	<% IF Request.QueryString("action") <> "" THEN %>
	 <td>
	<div align="right">[<a href="list.asp?action=insert">Add Item</a>]&nbsp;&nbsp;[<a href="list.asp?action=update">View/Edit
          Items</a>]
          <% IF Request.QueryString("ItemID") <> "" Then %>&nbsp;&nbsp;[<a href="/applications/PayPalStoreManager/inc_paypalstoremanager.asp?ItemID=<%=Request.QueryString("ItemID")%>&CategoryID=<%=Request.QueryString("CategoryID")%>" target="_blank">Live
Preview</a>]&nbsp;&nbsp;[<a href="delete.asp?ItemID=<%=Request.QueryString("ItemID")%>">Delete
Item</a>]
<%end if%>
      </div>
    </td>
	<%end if%>
  </tr>
</table>