<link href="index.css" rel="stylesheet" type="text/css">
<table width="495" align="center"><tr><td class="headline" align="center">
 Team {TEAM_NAME} - Control Panel - Set Team Profile
</td></tr></table>
{ERRORS}
<form method=POST>
 <table width="495" class="news">
  <tr class="row">
   <td colspan="2">Team Name: <input type="text" maxlength="254" size="55" name="{FIELD_TEAM_NAME}" value="{FIELD_TEAM_NAME_VALUE}"> 
    <br><span class="requiredtxt">Must be > 3 And < 255 Characters.</span></td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">Team Password: <input type="text" maxlength="255" size="25" name="{FIELD_TEAM_PASS}"> 
    <br><span class="requiredtxt">Must be atleast 3 Characters.</span></td>
  </tr>
  <tr class="row">
   <td width=50%>
    Team Tags: <input type="text" maxlength="6556" size="10" name="{FIELD_TEAM_TAG}" value="{FIELD_TEAM_TAG_VALUE}">
   </td>
   <td>
    <input type="checkbox" name="{FIELD_TEAM_TAG_SIDE}" value="1" {FIELD_TEAM_TAG_SIDE_VALUE}>Tag on right side of team name
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">Email: <input type="text" maxlength="6556" size="45" name="{FIELD_TEAM_EMAIL}" value="{FIELD_TEAM_EMAIL_VALUE}"> 
    <br><span class="requiredtxt">Must be a Valid Email.</span></td>
  </tr>
  <tr class="row">
   <td valign="top" width="50%">Choose your preferred Server Locations:<br>
     <span class="requiredtxt">(Note: To select multiple options, hold down Ctrl button while selecting with the left mouse button)</span></td>
   <td><select size="4" name="{FIELD_TEAM_SRVLOCATION}" MULTIPLE>{FIELD_TEAM_SRVLOCATION_VALUE}</select></td>
  </tr>
  <tr class="rowoff">
   <td valign="top" width="50%">Games Played:</td><td><select size="7" name="{FIELD_TEAM_GAMES}" MULTIPLE>{FIELD_TEAM_GAMES_VALUE}</select></td>
  </tr>
  <tr class="row">
   <td colspan="2">This will set your team status. All Players will be able to see it in your user Profile.</td>
  </tr>
  <tr class="row">
   <td valign="top" width="50%">Team Status:<br>
     <span class="requiredtxt">(Note: To select multiple options, hold down Ctrl button while selecting with the left mouse button)</span></td>
   <td><select size="5" name="{FIELD_TEAM_STATUS}">{FIELD_TEAM_STATUS_VALUE}</select></td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">Webpage: <input type="text" maxlength="65535" size="55" name="{FIELD_TEAM_WEBPAGE}" value="{FIELD_TEAM_WEBPAGE_VALUE}">
   <span class="requiredtxt">Optional</span></td>
  </tr>
  <tr class="row">
   <td width="50%">Irc Server: <input type="text" maxlength="255" size="20" name="{FIELD_TEAM_IRCSERV}" value="{FIELD_TEAM_IRCSERV_VALUE}">
   <br><span class="requiredtxt">Optional</span></td>
   <td width="50%">Irc Channel: <input type="text" maxlength="65535" size="15" name="{FIELD_TEAM_IRCCHAN}" value="{FIELD_TEAM_IRCCHAN_VALUE}">
   <br><span class="requiredtxt">Optional</span></td>
  </tr>
  <tr class="rowoff">
   <td valign="top" width=50%>Team Description:<br>Enter in Team description.<br><span class="requiredtxt">Optional</span></td>
   <td><textarea cols="50" rows="15" name="{FIELD_TEAM_DESCRIPTION}">{FIELD_TEAM_DESCRIPTION_VALUE}</textarea></td>

  </tr>
  <tr class="row"><td align="center" colspan="2"><input type="submit" name="submit" value="Save Profile">&nbsp;&nbsp;<input type="Reset" name="Reset" value="Reset"></td></tr>
 </table>
</form> 