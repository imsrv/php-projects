<center>
 Click Delete or Activate for the Users
 <template name="ACT">
  <hr>
  Activation Link for {PLAYER}
  <br>
  <a href="{LINK}">Send This Link To Player</a>
  <hr>
 </template name="ACT">
</center>
<table width="40%" align="center">
 <tr>
  <td class="subheader" width="50%" align="center">
   <a href="?page=admin&cmd=uauth&cmdd=4" class="uauthdel">
    Delete all
   </a>
  </td>
  <td class="subheader" width="50%" align="center">
   <a href="?page=admin&cmd=uauth&cmdd=5" class="uauthmail">
    Email all
   </a>
  </td>
 </tr>
</table>
<table width=100% class="news">
 <tr>
  <th class="header" width=20%>
   Player
  </th>
  <th width=20% class="header">
   Email
  </th>
  <th width=20% class="header">
   Delete?
  </th>
  <th width=20% class="header">
   Activate
  </th>
  <th width=20% class="header">
   Email
  </th>
 </tr>
 <template name="USERS">
  <template name="USER_NONE">
   <tr>
    <td colspan="5" align="center">
     <span class="error">There are 0 Users awaiting Auth.</span>
    </td>
   </tr>
  </template name="USER_NONE">
  <template name="USER_ROW">
   <tr class="{CLASS}">
    <td>
     {PLAYER}
    </td>
    <td>
     {EMAIL}
    </td>
    <td align="center">
     <a class="uauthdel" href="{LINK_DEL}">
      Delete
     </a>
    </td>
    <td align="center">
     <a class="uauthact" href="{LINK_ACT}">
      Activate
     </a>
    </td>
    <td align="center">
     <a class="uauthmail" href="{LINK_RES}">
      Resend Email
     </a>
    </td>
   </tr>
  </template name="USER_ROW">
 </template name="USERS">
</table> 