<center>Join Tournament:</center>

<template name="JOIN">
 <template name="LOGIN">
  If you are a member of the {SITE_NAME}, please login at this time. If you are new to {SITE_NAME}, you can signup by clicking here: <a href="?page=playersignup">Signup</a>
 </template name="LOGIN">
 <template name="NEED_TEAM">
  This is a team tournament. You need to be a member of a team. You can start your own team by clicking here: <a href="?page=playercontrol&cmd=cteam">Create A Team</a>
  <br>
  Only captains and founders can join tournaments.

  <template name="NEED_TEAM_DRAFT">
   <hr>
   This is a draft tournament which will allows you to be drafted into a team. If you would like to join the draft click here: <a href="?page=playercontrol&cmd=tourny">Join Tournament</a>
  </template name="NEED_TEAM_DRAFT">
 </template name="NEED_TEAM">
 <template name="TEAMS">
  <template name="TEAMS_DRAFT">
   This is a draft tournament which will allows you to be drafted into a team. If you would like to join the draft click here: <a href="?page=playercontrol&cmd=tourny">Join Tournament</a>
   <hr>
  </template name="TEAMS_DRAFT">

  Choose which team you would like to join the tournment in:
  <table width="100%">
   <template name="TEAMS_TEAM">
    <tr>
     <td width="50%">
      {TEAM_NAME}
     </td>
     <td width="50%">
      <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=tourny">Join Tournament</a>
     </td>
    </tr>
   </template name="TEAMS_TEAM">
  </table>
 </template name="TEAMS">
</template name="JOIN"> 