<table width=100%>
 <tr><td colspan=2 align="center">Choose the Servers for the Tournament.</td></tr>
 <tr><td colspan=2 align="center">After the Servers have been added, click on the Server Name to set the Admins.</td></tr>
 <tr>
  <td align="center" colspan=2>
   <a href="?page=admin&cmd=tourny&cmdd=createserv&tournyid={TOURNY_ID}&serverid=-1">Create Server</a>
  </td>
 </tr>
</table>
<table width=100%>
 <tr>
  <th class="header" width=30% align=left>Server</th>
  <th class="header" width=15%>IP</th>
  <th class="header" width=5%>Port</th>
  <th class="header" width=5%>Admins</th>
  <th class="header" width=5%>Modify</th>
  <th class="header" width=5%>Delete?</th>
 </tr>
 <template name="ROW">
  <tr class="{ROW_CLASS}">
   <td>
    <a href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}&server={SERVER_ID}">{SERVER_NAME}</a>
   </td>
   <td>
    {SERVER_IP}
   </td>
   <td>
    {SERVER_PORT}
   </td>
   <td align=center>
    <template name="ADMIN_GOOD">
     <span class="adminsgood">{SERVER_ADMIN_CNT}</span>
    </template name="ADMIN_GOOD">
    <template name="ADMIN_BAD">
     <span class="adminsbad">0</span>
    </template name="ADMIN_BAD">
   </td>
   <td align=center>
    <a href="?page=admin&cmd=tourny&cmdd=createserv&tournyid={TOURNY_ID}&serverid={SERVER_ID}">
     Modify
    </a>
   </td>
   <td align=center>
    <a href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}&delserver={SERVER_ID}">
     <span class="requiredtxt">Delete</span>
    </a>
   </td>
  </tr>
 </template name="ROW">
</table>
<template name="NEED_SRV">
 <span class="requiredtxt">
  You must make atleast 1 Server, then assign admin to the servers. Admins will only be able to set matchs if they are assigned to servers.
 </span>
</template name="NEED_SRV">