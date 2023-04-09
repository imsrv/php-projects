<form method=POST>
 <table width=600 align="center">
  <tr><td colspan="2" class="headline" align="center">Tournament Summary Data Entry</td></tr>
  <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
  <tr>
   <td colspan="2" class="text" width=600 align="center">
    Enter in all the Information for the Tournament.<br>
    Max Teams and Start Date are not enforced by website for qualifing rounds. All sections are optional, empty sections will not be shown.
   </td>
  </tr>
  <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
 </table>
 <table width=600 align="center" class="borderit"><!-- Outer Table -->
  <tr><td height=10></td></tr>

  <tr>
   <td width=50% valign="top">
    <table width=600 align="center">
     <tr><td class="text">Game Selection / Details:</td></tr>
     <tr>
      <td class="qstat">
       <table width=600 align="center">
        <tr><td height=5></td></tr>
        <tr>
         <td class="text">Tournament Game: </td>
         <td width=70%>
          <select size="1" name="{FIELD_GAME}">
           {FIELD_GAME_OPTIONS}
          </select>
         </td>
        </tr>
        <tr><td class="text">Game Type: </td><td><input type="text" maxlength="{FIELD_GAME_TYPE_MAX}" size="25" name="{FIELD_GAME_TYPE}" value="{FIELD_GAME_TYPE_VALUE}"></td></tr>
        <tr><td class="text">Game Mod: </td><td><input type="text" maxlength="{FIELD_GAME_MOD_MAX}" size="25" name="{FIELD_GAME_MOD}" value="{FIELD_GAME_MOD_VALUE}"></td></tr>
        <tr><td height=5></td></tr>
       </table>
      </td>
     </tr>
    </table>
   </td>
  </tr>
  <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
  <tr>
   <td width=50% valign="top">
    <table width=600 align="center">
     <tr><td class="text">Tournament Settings:</td></tr>
     <tr>
      <td class="qstat">
       <table width=600 align="center">
        <tr><td height=5></td></tr>
        <tr><td class="text">Maximum Teams:<br>(Max Not Enforced) </td><td width=70%> <input type="text" maxlength="{FIELD_TEAMS_MAX}" size="25" name="{FIELD_TEAMS}" value="{FIELD_TEAMS_VALUE}"></td></tr>
        <tr><td class="text">
         Start Date: </td><td><input type="text" maxlength="{FIELD_DATE_MAX}" size="25" name="{FIELD_DATE}" value="{FIELD_DATE_VALUE}">

         <span class="requiredtxt">
          Format: 11:45 PM March 10, 2004
          <br>
          Set time in your timezone. Time will be adjusted automatically for each player.
         </span>
        </td></tr>
        <tr><td height=5></td></tr>
       </table>
      </td>
     </tr>
    </table>
   </tr>
  </tr>
  <template name="TEAM_REQ">
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Team Requirments:</td></tr>
      <tr>
       <td class="qstat">
        <table width=600 align="center">
         <tr><td class="text">Min Team Members:<br>(0 = Disabled) </td><td width=70%> <input type="text" maxlength="{FIELD_PLAYERMIN_MAX}" size="25" name="{FIELD_PLAYERMIN}" value="{FIELD_PLAYERMIN_VALUE}"></td></tr>
         <tr><td class="text">Max Team Members:<br>(0 = Disabled) </td><td width=70%> <input type="text" maxlength="{FIELD_PLAYERMAX_MAX}" size="25" name="{FIELD_PLAYERMAX}" value="{FIELD_PLAYERMAX_VALUE}"></td></tr>
        </table>
       </td>
      </tr>
     </table>
    </tr>
   </tr>
  </template name="TEAM_REQ">
  <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
  <tr>
   <td width=50% valign="top">
    <table width=600 align="center">
     <tr><td class="text">Tournament News:</td></tr>
     <tr>
      <td>
       <textarea cols="95" rows="20" name="{FIELD_NEWS}">{FIELD_NEWS_VALUE}</textarea>
      </td>
     </tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Description:</td></tr>
      <tr><td><textarea cols="95" rows="20" name="{FIELD_DESC}">{FIELD_DESC_VALUE}</textarea></td></tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Rules:</td></tr>
      <tr><td><textarea cols="95" rows="20" name="{FIELD_RULES}">{FIELD_RULES_VALUE}</textarea></td></tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Server Requirments:</td></tr>
      <tr><td> <textarea cols="95" rows="20" name="{FIELD_SRVREQ}">{FIELD_SRVREQ_VALUE}</textarea></td></tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Maps:</td></tr>
      <tr><td><textarea cols="95" rows="20" name="{FIELD_MAP}">{FIELD_MAP_VALUE}</textarea></td></tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Schedule:</td></tr>
      <tr><td><textarea cols="95" rows="20" name="{FIELD_SCH}">{FIELD_SCH_VALUE}</textarea></td></tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Sponsers:</td></tr>
      <tr><td><textarea cols="95" rows="20" name="{FIELD_SPONS}">{FIELD_SPONS_VALUE}</textarea></td></tr>
     </table>
    </td>
   </tr>
   <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
   <tr>
    <td width=50% valign="top">
     <table width=600 align="center">
      <tr><td class="text">Tournament Prizes:</td></tr>
      <tr><td><textarea cols="95" rows="20" name="{FIELD_PRIZE}">{FIELD_PRIZE_VALUE}</textarea></td></tr>
     </table>
    </td>
  </tr>
  <tr><td height=10></td></tr>
  <tr><td align="center"><input type="submit" name="{FIELD_SUBMIT}" value="Save Tournament Setup"></td></tr>
  <tr><td height=10></td></tr>
 </table>
</form> 