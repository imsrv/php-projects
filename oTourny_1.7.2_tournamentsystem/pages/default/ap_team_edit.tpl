<table width=100% align="center"><tr><td class="subheader" align="center">
 EDIT TEAM
</td></tr></table>
{ERRORS}
<form method=POST>
 <table width=100% align="center">
  <tr class="row">
   <td colspan="2">
    Name: <input type="text" maxlength="255" size="25" name="{FIELD_NAME}" value="{FIELD_NAME_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Tag: <input type="text" maxlength="255" size="25" name="{FIELD_TAG}" value="{FIELD_TAG_VALUE}">
    <input type="checkbox" name="{FIELD_TAGSIDE_NAME}" value="{FIELD_TAGSIDE_VALUE}"><span class="requiredtxt">Tag on right side of Team Name.</span>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Join Password: <input type="text" maxlength="255" size="25" name="{FIELD_PASS}" value="{FIELD_PASS_VALUE}"> <input type="checkbox" name="{FIELD_JPASS_NAME}" value="{FIELD_JPASS_VALUE}"> <span class="requiredtxt">Disable Join By Password.</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Email: <input type="text" maxlength="255" size="25" name="{FIELD_EMAIL}" value="{FIELD_EMAIL_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Team Website: <input type="text" maxlength="255" size="25" name="{FIELD_WEB}" value="{FIELD_WEB_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Irc Channel: <input type="text" maxlength="255" size="30" name="{FIELD_IRCC}" value="{FIELD_IRCC_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Irc Server: <input type="text" maxlength="255" size="30" name="{FIELD_IRCS}" value="{FIELD_IRCS_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td valign="top" width=20%>Preferred Server Locations:</td>
   <td width=60%>
    <select size="4" name="{FIELD_SRVLOC}" MULTIPLE>
     {FIELD_SRVLOC_VALUE}
    </select>
   </td>
  </tr>
  <tr class="row">
   <td valign="top" width=10%>Games Played:</td>
   <td>
    <select size="7" name="{FIELD_GAMEPLAY}" MULTIPLE>
     {FIELD_GAMEPLAY_VALUE}
    </select>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    <span class="requiredtxt">Note: To select multiple games, hold down Ctrl button while selecting with the left mouse button)</span>
   </td>
  </tr>
  <tr class="row">
   <td>
    Team Description:
   </td>
   <td>
    <textarea cols="50" rows="15" name="{FIELD_TEAM_DESCRIPTION}">{FIELD_TEAM_DESCRIPTION_VALUE}</textarea>
   </td>
  </tr>
  <tr class="rowoff">
   <td align="center" colspan="2">
    <input type="submit" name="{FIELD_SUBMIT}" value="Save">&nbsp;&nbsp;<input type="Reset" name="Reset" value="Reset">
   </td>
  </tr>
 </table>
</form>