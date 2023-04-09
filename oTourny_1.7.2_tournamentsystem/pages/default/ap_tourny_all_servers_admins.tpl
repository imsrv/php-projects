<a href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}">
 Back to Server List
</a>
<center>
 Add or Remove Admins From Server.
 <br>
 Selected Server: <b>{SERVER_NAME} ({SERVER_IP}:{SERVER_PORT})</b>
 <br><br>
 <a href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}&server={SERVER_ID}&selectadmin=1">Add Admin</a>
</center>
<br>
<table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
 <tr><td class="subsubheader">Admins:</td></tr>
</table>
<table width=100%>
 <tr>
  <th width=90%></th>
  <th width=10%></th>
 </tr>
 <template name="ROW">
  <tr>
   <td width="50%" align="left">
    {ADMIN}
   </td>
   <td align="right" width="50%">
    <a href="{LINK_REM_ADMIN}">
     <span class="requiredtxt">
      Delete
     </span>
    </a>
   </td>
  </tr>
 </template name="ROW">
</table>
<template name="ERROR">
 <center>
  <span class="requiredtxt">
   You must assign atleast 1 admin to each Server.
  </span>
 </center>
</template name="ERROR">