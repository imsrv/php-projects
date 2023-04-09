<center>Configure Tournament Draft Team:</center>

{ERRORS}

<form method=POST>
 <table width=100% align="center" class="news">
  <tr class="rowoff">
   <td align=center>
    As a captain for the draft tournament you will need to setup your team. You will have limited permissions as compared to a normal team.
   </td>
  </tr>
  <tr>
   <td align="right">
    <input type="submit" name="submit" value="Save Team">
   </td>
  </tr>
  <tr class="row">
   <td>
    Enter in Team Name. It must be unique.
    <br>
    Team Name: <input type="text" maxlength="254" size="55" name="{FIELD_TEAM_NAME}" value="{FIELD_TEAM_NAME_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td>
    Your Clan tags must be unique.

    <table width=100% class="news">
     <tr>
      <td width=50%>
       Clan Tags: <input type="text" maxlength="10" size="10" name="{FIELD_TEAM_TAGS}" value="{FIELD_TEAM_TAGS_VALUE}">
      </td>
      <td width=50%>
       <input type="checkbox" name="{FIELD_TEAM_SIDE}" value="{FIELD_TEAM_SIDE_VALUE}" {FIELD_TEAM_SIDE_CHK}>Tag on right side of team name
      </td>
     </table>
   </td>
  </tr>
  <tr class="row">
   <td>
    Here we need an email address that can be used to communicate matches, scrimms, etc. to the Team.
    <br>
    Team's E-Mail Address: <input type="text" maxlength="6550" size="50" name="{FIELD_TEAM_EMAIL}" value="{FIELD_TEAM_EMAIL_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td>
    You will need to give a rank to each of the possible players that you want for your team.
    Give a rank of "1" for players you want the most.
    Give a rank of "10" for players you want the least.
    You can give the same rank to more than one player, but it will not increase your chances of getting the players.
    All the players will be assigned to the teams at the start of the tournament.
   </td>
  </tr>
  <tr class="row">
   <td>
    <table width="100%">
     <tr>
      <th width="80%" align="left">
       Player
      </th>
      <th width="20%" align="center">
       Rank
      </th>
     </tr>
     <template name="PLAYER_LIST">
      <template name="PLAYER_NONE">
       <span class="error">There are 0 Players to Draft.</span>
      </template name="PLAYER_NONE">
      <template name="PLAYER">
       <tr class="{CLASS}">
        <td>
         {PLAYER_NAME}
        </td>
        <td align="center">
         <input type="text" maxlength="2" size="4" name="{FIELD_PLAYER_NAME}" value="{FIELD_PLAYER_VALUE}">
        </td>
       </tr>
      </template name="PLAYER">
     </template name="PLAYER_LIST">
    </table>
   </td>
  </tr>
  <tr>
   <td align="center">
    <input type="submit" name="submit" value="Save Team">
   </td>
  </tr>
 </table>
</form>