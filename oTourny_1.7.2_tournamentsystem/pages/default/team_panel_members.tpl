<table width=100% align="center"><tr><td class="subheader" align="center">
 Team {TEAM_NAME} - Control Panel - Members
</td></tr></table>

<center>
 <br>
 <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=members&invite=1">
  Invite Player
 </a>
</center>

<br><br>

<table width="100%">
 <tr>
  <th class="header" width="25%">
   Name
  </th>
  <th class="header" width="5%">
   Status
  </th>
  <th class="header" width="70%">
   Set New Status
  </th>
 </tr>
 <template name="player_row">
  <tr>
   <td>{PLAYER_NAME}</td>
   <td align="center">{PLAYER_STATUS}</td>
   <td>
    <template name="player_set_found">
     <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=members&set={LEVEL_FOUNDER}&destuserid={PLAYER_ID}">Set Founder</a>
    </template name="player_set_found">
    <template name="player_set_capt">
     <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=members&set={LEVEL_CAPTAIN}&destuserid={PLAYER_ID}">Set Captain</a>
    </template name="player_set_capt">
    <template name="player_set_player">
     <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=members&set={LEVEL_PLAYER}&destuserid={PLAYER_ID}">Set Player</a>
    </template name="player_set_player">
    <template name="player_set_sub">
     <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=members&set={LEVEL_SUB}&destuserid={PLAYER_ID}">Set Sub</a>
    </template name="player_set_sub">
    <template name="player_set_kick">
     <a href="?page=teamcontrol&teamid={TEAM_ID}&cmd=members&type={PLAYER_TYPE}&set={LEVEL_NPLAYER}&destuserid={PLAYER_ID}">Kick</a>
    </template name="player_set_kick">
   </td>
  </tr>
 </template name="player_row">
</table>