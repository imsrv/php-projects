<a href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}">
 Back to Server List
</a>
<center>
 Select a Tournament Admin.
 <br>
 Selected Server: <b>{SERVER_NAME} ({SERVER_IP}:{SERVER_PORT})</b>
 <br>
</center>
<br>
<table width=100% align="center">
 <tr><td class="subheader" align="center">Admins:</td></tr>
</table>
<table width=100%>
 <template name="ROW">
  <tr>
   <template name="COL">
    <td align="center" width="33%">
     <a href="{LINK}">{TXT}</a>
    </td>
   </template name="COL">
  </tr>
 </template name="ROW">
</table>
<template name="ERROR">
 <center>
  <span class="error">
   You need to assign admins to the tournament.
  </span>
 </center>
</template name="ERROR">