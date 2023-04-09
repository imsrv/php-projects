<template name="ASKCAPT">
 <table width=100% align="center">
  <tr>
   <td class="headline" align="center">JOIN DRAFT TOURNAMENT</td>
  </tr>
 </table>

 <center>
  You have the option of becoming a Team Captain for the draft tournament.
  A Team Captain will be the leader of their own team and will have the choice to select the team members.
  Tournament admins will award players as Team Captain.
  <br><br>

 <form method="POST">
  <input type="checkbox" name="{FIELD_CAPT_NAME}" value="{FIELD_CAPT_VALUE}">
   Yes, I want to be a Team Captain.
   <br><br>
   <input type="submit" name="{FIELD_SUBMIT}" value="Join Tournament">
 </form>
 </center>
</template name="ASKCAPT">

<table width=100% align="center"><tr><td class="headline" align="center">SINGLE PLAYER AND DRAFT TOURNAMENTS</td></tr></table>
<center>You are allowed to join and leave tournaments while signup is open. The time duration of open signup is designated by the tournament founder. The tournaments that you can join and part are listed, if they are not, you no longer have the ability to join or part them.</center>
<br>
Click on A Tournament to Join the Tournament.
<table width=100% align="center"><tr><td class="headline" align="center">Available Draft Tournaments:</td></tr></table>
<table width="100%" border="0">
 <template name="JD_ROW">
  <tr>
   <td align="center" width="100%">
    <a href="{JD_LINK}">{JD_NAME}</a>
    <br>
    <template name="JD_BANNER">
     <a href="{JD_LINK}">
      <img border="0" src="{JD_BANNER}" width="600">
     </a>
    </template name="JD_BANNER">
   </td>
 </template name="JD_ROW">
</table>
<template name="JD_NONE">
 <center>
  <span class="error">
   There are 0 Draft Tournaments that you can Join.
  </span>
 </center>
</template name="JD_NONE">
<br>
<table width=100% align="center"><tr><td class="headline" align="center">Available Single Player Tournaments:</td></tr></table>
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
   There are 0 Single Player Tournaments that you can Join.
  </span>
 </center>
</template name="JT_NONE">
<br>
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
   There are 0 Single Player or Draft Tournaments that you can Leave.
  </span>
 </center>
</template name="LT_NONE">