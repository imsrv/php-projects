<link href="index.css" rel="stylesheet" type="text/css">
<center>Tournament Matches:</center>

<template name="LIST_ADMIN">

Admin Listings:

<table width="100%" border="0" cellpadding="0" cellspacing="0">

 <tr>

  <td width="100%" align="center">

   <a href="?page=tourny&tournyid={TOURNY_ID}&cmd=matchs&show=admin">List Matchs I'm Admining</a>

  </td>

 </tr>
</table>

</template name="LIST_ADMIN">

Special Listings:

<table width="100%" border="0" cellpadding="0" cellspacing="0">

 <tr>

  <td width="50%" align="center">

   <a href="?page=tourny&tournyid={TOURNY_ID}&cmd=matchs">List My Matchs</a>

  </td>

  <td width="50%" align="center">

   <a href="?page=tourny&tournyid={TOURNY_ID}&cmd=matchs&show=listall">List All Matchs</a>

  </td>

 </tr>
</table>

<template name="MODULES">

 List by Module:

 <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

   <template name="MODULE_LIST">

    <td align="center">

     <a href="?page=tourny&tournyid={TOURNY_ID}&cmd=matchs&show=module&module={MODULE_ID}">{MODULE_NAME}</a>

    </td>

   </template name="MODULE_LIST">

  </tr>
</table>

</template name="MODULES">



<template name="MODULE_NONE">

 <center><span class="error">No Matchs To Display</span></center>

</template name="MODULE_NONE">

<template name="MODULE">



<hr><hr>

 <table width="100%" border=".1px" cellpadding="0" cellspacing="0">

  <tr>

   <td width="50%" align="left">

    <a href="{MODULE_LINK}">{MODULE_NAME}</a>

   </td>

   <td width="50%" align="right">

    Current Round: {MODULE_ROUND}

   <td>

  </tr>
</table>

 <template name="TABLE">

  <table width="480" border="0" cellpadding="0" cellspacing="0">

   <tr>

    <th>

     Round:

    </th>

    <th>

     Server:

    </th>

    <th>

     {TYPE}s:

    </th>

    <th>

     Time:

    </th>

    <th>

     Status:

    </th>

   </tr>

   <template name="MATCHS_NONE">

    <tr>

     <td colspan="5">

      <span class="requiredtxt">No Matchs To Display</span>

     </td>

    </tr>

   </template name="MATCHS_NONE">

   <template name="MATCH">

    <tr>

     <td>{ROUND}</td>

     <td>

      <template name="SERVER">

       <template name="SERVER_VALID">

        <a href="{SERVER_ID}">{SERVER_NAME}</a>

       </template name="SERVER_VALID">

       <template name="SERVER_NONE">

        Server Not Set

       </template name="SERVER_NONE">

      </template name="SERVER">

     </td>

     <td>

      <a href="{MATCH_LINK}">

       <template name="TEAM">

        <template name="TEAM_NONE">

         No {TYPE}s have been selected.

        </template name="TEAM_NONE">

        <template name="TEAM_VS">

         {TEAM_NAME} VS

        </template name="TEAM_VS">

        <template name="TEAM_END">

         {TEAM_NAME}

        </template name="TEAM_END">

       </template name="TEAM">

      </a>

     </td>

     <td>

      <template name="TIME">

       Not Set

      </template name="TIME">

     </td>

     <td>

      <template name="STATUS">

       <template name="STATUS_PENDING">

        <span class="pending">Pending</span>

       </template name="STATUS_PENDING">

       <template name="STATUS_DECIDED">

        <span class="decided">Decided</span>

       </template name="STATUS_DECIDED">

      </template name="STATUS">

     </td>

    </tr>

   </template name="MATCH">
 </table>

 </template name="TABLE">

</template name="MODULE">