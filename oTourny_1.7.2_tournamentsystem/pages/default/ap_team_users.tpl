<table width=100% align="center"><tr><td class="subheader" align="center">
 TEAM USERS
</td></tr></table>
<br>
<center>
 <template name="ADD">
  <template name="ADD_DRAFT">
   <a href="{LINK_ADD_USER}">Add Draft User</a>
   <a href="{LINK_ADD_CAPT}">Add Draft Captain</a>
  </template name="ADD_DRAFT">
  <template name="ADD_USER">
   <a href="{LINK_ADD_USER}">Add User</a>
  </template name="ADD_USER">
 </template name="ADD">
</center>
<br>
<table width="100%">
 <tr>
  <th width="70%" class="header">
   Player
  </th>
  <th width="20%" class="header">
   Status
  </th>
  <th width="10%" class="header">
  </th>
 </tr>
 <template name="TEAM">
  <tr>
   <td>
    {USER_NAME}
   </td>
   <td>
    {USER_RANK}
   </td>
   <td>
    <a href="{LINK_DEL}">Delete</a>
   </td>
  </tr>
 </template name="TEAM">
</table>