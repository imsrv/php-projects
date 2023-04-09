<center>Tournament Draft:</center>

<template name="CAPTAIN">
 <br>
 <center>
  <a href="{LINK_CAPT_SETUP}">Setup Your Team</a>
 </center>
 <br>
</template name="CAPTAIN">

<table width="100%">
 <tr>
  <th width="40%" align="left">
   Player
  </th>
  <th width="40%" align="left">
   Team
  </th>
  <th width="10%" align="right">
   Status
  </th>
 </tr>
 <template name="PLAYER_LIST">
  <template name="PLAYER_NONE">
   <tr>
    <td colspan="3" align="center">
     <span class="requiredtxt">
      There are 0 Players in Draft.
     </span>
    </td>
   </tr>
  </template name="PLAYER_NONE">
  <template name="PLAYER">
   <tr>
    <td>
     {USER_NAME}
    </td>
    <td>
     <template name="PLAYER_TEAM">
      Not Drafted
     </template name="PLAYER_TEAM">
    </td>
    <td>
     <template name="PLAYER_TYPE">
      <template name="PLAYER_TYPE_CAPT">
       Captain
      </template name="PLAYER_TYPE_CAPT">
      <template name="PLAYER_TYPE_USER">
       Player
      </template name="PLAYER_TYPE_USER">
     </template name="PLAYER_TYPE">
    </td>
   </tr>
  </template name="PLAYER">
 </template name="PLAYER_LIST">
</table> 