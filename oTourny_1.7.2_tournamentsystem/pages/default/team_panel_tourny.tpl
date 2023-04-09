<table width=100% align="center"><tr><td class="headline" align="center">
 TEAM TOURNAMENTS
</td></tr></table>
<template name="MSG_FOUNDER">
 <center>Your Team is allowed to join and leave tournaments while signup is open. The time duration of open signup is designated by the tournament founder. The tournaments that you can join and part are listed, if they are not, you no longer have the ability to join or part them.</center>
</template name="MSG_FOUNDER">
<template name="MSG_CAPTAIN">
 <center>You are allowed to leave tournaments while signup is open. The time duration of open signup is designated by the tournament founder. Tournaments that you can leave are listed, if they are not, you no longer have the ability to part them.</center>
</template name="MSG_CAPTAIN">
<br>
Click on A Tournament to Join the Tournament.
<table width=100% align="center"><tr><td class="headline" align="center">Available Tournaments:</td></tr></table>
<table width="100%" border="0">
 <template name="JT_ROW">
  <tr>
   <td align="center" width="100%">
    <a href="{JT_LINK}">{JT_NAME}</a>
    <br>
    <template name="JT_BANNER">
     <a href="{JT_LINK}">
      <img border="0" src="{JT_BANNER}" width="600">
     </a>
    </template name="JT_BANNER">
   </td>
 </template name="JT_ROW">
</table>
<template name="JT_NONE">
 <center>
  <span class="error">
   There are 0 Team Tournaments that you can Join.
  </span>
 </center>
 </template name="JT_NONE">
<br><br>
<template name="LEAVE">
 Click on A Tournament to leave the tournament.
 <table width=100% align="center"><tr><td class="headline" align="center">Current Tournaments:</td></tr></table>
 <table width="100%" border="0">
  <template name="LT_ROW">
   <tr>
    <td align="center" width="100%">
     <a href="{LT_LINK}">{LT_NAME}</a>
     <br>
     <template name="LT_BANNER">
       <a href="{LT_LINK}">
        <img border="0" src="{LT_BANNER}" width="600">
       </a>
     </template name="LT_BANNER">
    </td>
   </tr>
   </template name="LT_ROW">
 </table>
 <template name="LT_NONE">
  <center>
   <span class="error">
    There are 0 Team Tournaments that you can Leave.
   </span>
  </center>
 </template name="LT_NONE">
</template name="LEAVE">