<table width=100% align="center"><tr><td class="headline" align="center">TEAM CREATION</td></tr></table>
{ERRORS}
<form method=POST>
 <table width=100% align="center" class="news">
  <tr class="rowoff">
   <td align=center>
    Here you can create a Team. You will be the team founder and will have complete control over your Team.
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
    If you wish, you may enter a join password for your team.  This enables users to join your team without you having to invite them, simply by communicating the password with your teammates.  You may also invite other users.
    <br>
    Team's Join Password: <input type="text" maxlength="255" size="35" name="{FIELD_TEAM_PASS}" value="{FIELD_TEAM_PASS_VALUE}"> <span class="requiredtxt">Optional</span>
   </td>
  </tr>
  <tr class="row">
   <td align=center>
    <input type="submit" name="submit" value="Create Team">&nbsp;&nbsp;<input type="Reset" name="Reset" value="Clear Information">
   </td>
  </tr>
 </table>
</form>