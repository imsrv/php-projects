<table width=100% align="center"><tr><td class="subheader" align="center">
 EDIT USER
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
    Password: <input type="text" maxlength="255" size="25" name="{FIELD_PASS}" value="{FIELD_PASS_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    <span class="requiredtxt">Note: Enter Password to Change.</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Email: <input type="text" maxlength="255" size="25" name="{FIELD_EMAIL}" value="{FIELD_EMAIL_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Real Name: <input type="text" maxlength="255" size="25" name="{FIELD_RNAME}" value="{FIELD_RNAME_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Location: <input type="text" maxlength="255" size="30" name="{FIELD_LOC}" value="{FIELD_LOC_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td valign="top" width=20%>Preferred Server Locations:</td>
   <td width=60%>
    <select size="4" name="{FIELD_SRVLOC}" MULTIPLE>
     {FIELD_SRVLOC_VALUE}
    </select>
   </td>
  </tr>
  <tr class="rowoff">
   <td valign="top" width=10%>Games Played:</td>
   <td>
    <select size="7" name="{FIELD_GAMEPLAY}" MULTIPLE>
     {FIELD_GAMEPLAY_VALUE}
    </select>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    <span class="requiredtxt">Note: To select multiple games, hold down Ctrl button while selecting with the left mouse button)</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Affiliation: <input type="text" maxlength="65535" size="20" name="{FIELD_AFF}" value="{FIELD_AFF_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Webpage: <input type="text" maxlength="65535" size="55" name="{FIELD_WEB}" value="{FIELD_WEB_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    ICQ Number: <input type="text" maxlength="255" size="10" name="{FIELD_ICQ}" value="{FIELD_ICQ_VALUE}"> &nbsp;&nbsp;&nbsp;<input type="checkbox" name="{FIELD_ICQ_VIS}" value="{FIELD_ICQ_VIS_VALUE}" {FIELD_ICQ_VIS_CHK}><span class="requiredtxt">Check here to make this visible to the public</span>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    MSN Screenname: <input type="text" maxlength="65535" size="15" name="{FIELD_MSN}" value="{FIELD_MSN_VALUE}"> &nbsp;&nbsp;&nbsp;<input type="checkbox" name="{FIELD_MSN_VIS}" value="{FIELD_MSN_VIS_VALUE}" {FIELD_MSN_VIS_CHK}><span class="requiredtxt">Check here to make this visible to the public</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    AIM Name: <input type="text" maxlength="255" size="20" name="{FIELD_AIM}" value="{FIELD_AIM_VALUE}"> &nbsp;&nbsp;&nbsp;<input type="checkbox" name="{FIELD_AIM_VIS}" value="{FIELD_AIM_VIS_VALUE}" {FIELD_AIM_VIS_CHK}><span class="requiredtxt">Check here to make this visible to the public</span>
   </td>
  </tr>
  <tr class="row">
   <td align="center" colspan="2">
    <input type="submit" name="{FIELD_SUBMIT}" value="Save">&nbsp;&nbsp;<input type="Reset" name="Reset" value="Reset">
   </td>
  </tr>
 </table>
</form>