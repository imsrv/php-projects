<template name="SERVER_REQS">
 <table width=100% align="center"><tr><td class="subheader" align="center">
  Server Requirments:
 </td></tr></table>

 {SERVER_REQS}
 <br><br>
</template name="SERVER_REQS">

<template name="SERVERS">
 <table width=100%>
  <tr>
   <th width=60% class="header" align=left>Server</th>
   <th width=40% class="header">IP</th>
  </tr>
  <template name="SERVER_ROWS">
   <tr class="{ROW_CLASS}">
    <td>
     {SERVER_NAME}
    </td>
    <td align="center">
      {SERVER_IP}
    </td>
   </tr>
  </template name="SERVER_ROWS">
 </table>
</template name="SERVERS">  