<table width=100%>
 <tr>
  <td class="text" align=center>
   Choose the Admins for the Tournament. They will only be able to enter in Match Data.
  </td>
 </tr>
 <tr>
  <td class="text" align=center>
   <a href="?page=admin&cmd=tourny&cmdd=selectadmin&tournyid={TOURNY_ID}">Add Admin</a>
  </td>
 </tr>
</table>
<table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
 <tr><td class="subsubheader">Admins ({ADMIN_COUNT}):</td></tr>
</table>

<table width=100%>
 <template name="ROW">
  <tr class="{ROW_CLASS}">
   <td width=70% align="left" class="text">
    {ADMIN_NAME}
   </td>
   <td width=30% align="center">
    <a href="{ADMIN_R_LINK}"><span class="requiredtxt">Remove</span></a>
   </td>
  </tr>
 </template name="ROW">
</table>
<template name="NONE">
 <center>You need to assign Admins.</center>
</template name="NONE">

<table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
 <tr><td class="subsubheader"></td></tr>
</table>