<table width=100% align="center">
  <tr>
    <td class="headline" align="center">EDIT PROFILE</td>
  </tr>
</table>
{ERRORS}

<template name="EMAIL_CHANGE">
 A Email has been Sent to your New Email to confirm it. Please Follow the directions in the email.
</template name="EMAIL_CHANGE">

<form method=POST>
 <table width=100% align="center" class="news">
  <tr class="row">
   <td colspan="2" align=center>You can setup your Profile. Your profile is viewed by all Players and Administrators. The tournament engine will check your preferred server location when determine servers for your matches. It is highly suggested to fill out all of the information but it is also optional. Use the control panel to the above to View your Profile.</td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Name: <input type="text" maxlength="255" size="25" name="{FIELD_NAME}" value="{FIELD_NAME_VALUE}">
    <br>
    <span class="requiredtxt">
     Your Name will be used to login to the {SITE_NAME} system, to join teams and to compete in any tournaments that the {SITE_NAME} puts on. Please note that Names are first come first serve, dont complain to the admins about it.
    </span>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Password: <input type="password" maxlength="255" size="25" name="{FIELD_PASS}">
    <br>
    <span class="requiredtxt">
     Fill in a password (5+ letters) that you will be able to remember but won't be easy to find out. The best way to accomplish this would be to use a combination of letter and numbers that are familiar to yourself an no one else. It is asked to not use common words in your password.
    </span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Email: <input type="text" maxlength="6556" size="35" name="{FIELD_EMAIL}" value="{FIELD_EMAIL_VALUE}">
    <br>
    <input type="checkbox" name="{FIELD_EMAIL_VIS}" value="{FIELD_EMAIL_VIS_VALUE}" {FIELD_EMAIL_VIS_VALUE_CHECK}>
     Check here to make your Email visible to the public
    <br>
    <span class="requiredtxt">
     You can change your email. Please enter in only a valid email as we use it to contact you. We don't spam players or give out their emails. This email is for information purposes only.
    </span>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    <input type="hidden" name="{FIELD_HIDDEN_TIME}" value="{FIELD_HIDDEN_TIME_VALUE}">
    Your Current Time: <input type="text" maxlength="150" size="50" name="{FIELD_TIME}" value="{FIELD_TIME_VALUE}">
    <br>
    <span class="requiredtxt">Optional. Enter in your current time, this will be used to determine your timezone offset.</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Time Format: <input type="text" maxlength="150" size="50" name="{FIELD_TIME_FORMAT}" value="{FIELD_TIME_FORMAT_VALUE}">
    <br>
    <span class="requiredtxt">Optional. Enter in how date/time is to be formated. <a href="http://php.net/manual/en/function.date.php">Click here for Help</a></span>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Real Name: <input type="text" maxlength="255" size="25" name="{FIELD_RNAME}" value="{FIELD_RNAME_VALUE}">
    <br>
    <span class="requiredtxt">Optional. Just used for your Profile.</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    Location: <input type="text" maxlength="255" size="30" name="{FIELD_LOC}" value="{FIELD_LOC_VALUE}">
    <br>
    <span class="requiredtxt">Optional. Just used for your Profile.</span>
   </td>
  </tr>
  <tr class="row">
   <td valign="top" width=20%>
    Choose your preferred server locations:
    <br>
                                                                                 <span class="requiredtxt">Note: To select multiple locations, hold down Ctrl button while selecting with the left mouse button)</span>
   </td>
   <td width=60%>
    <select size="4" name="{FIELD_SRVLOC}" MULTIPLE>
     {FIELD_SRVLOC_VALUE}
    </select>
   </td>
  </tr>
  <tr class="rowoff">
   <td valign="top" width=10%>
    Games Played:
    <br>
    <span class="requiredtxt">Note: To select multiple games, hold down Ctrl button while selecting with the left mouse button)</span>
   </td>
   <td>
    <select size="7" name="{FIELD_GAMEPLAY}" MULTIPLE>
     {FIELD_GAMEPLAY_VALUE}
    </select>
   </td>
  </tr>
  <tr class="row">
   <td valign="top" width=10%>
    Main Team:
    <br>
    <span class="requiredtxt">Selecting a Main Team will allow the site to Append the Team's Tag to your User name.</span>
   </td>
   <td>
    <select size="5" name="{FIELD_TEAMS}">
     <template name="OPTION_TEAM">
      <option <template name="OPTION_TEAM_SELECTED">selected</template name="OPTION_TEAM_SELECTED">>
       <template name="OPTION_TEAM_NAME">---NONE---</template name="OPTION_TEAM_NAME">
      </option>
     </template name="OPTION_TEAM">
    </select>
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
    ICQ Number: <input type="text" maxlength="255" size="15" name="{FIELD_ICQ}" value="{FIELD_ICQ_VALUE}">
    <br><input type="checkbox" name="{FIELD_ICQ_VIS}" value="{FIELD_ICQ_VIS_VALUE}" {FIELD_ICQ_VIS_CHK}> &nbsp;<span class="requiredtxt">Check here to make this visible to the public</span>
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    MSN Screenname: <input type="text" maxlength="65535" size="35" name="{FIELD_MSN}" value="{FIELD_MSN_VALUE}">
    <br><input type="checkbox" name="{FIELD_MSN_VIS}" value="{FIELD_MSN_VIS_VALUE}" {FIELD_MSN_VIS_CHK}> &nbsp;<span class="requiredtxt">Check here to make this visible to the public</span>
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2">
    AIM Name: <input type="text" maxlength="255" size="20" name="{FIELD_AIM}" value="{FIELD_AIM_VALUE}">
    <br><input type="checkbox" name="{FIELD_AIM_VIS}" value="{FIELD_AIM_VIS_VALUE}" {FIELD_AIM_VIS_CHK}> &nbsp;<span class="requiredtxt">Check here to make this visible to the public</span>
   </td>
  </tr>
  <tr class="row">
   <td align="center" colspan="2">
    <input type="submit" name="{FIELD_SUBMIT}" value="Save">&nbsp;&nbsp;<input type="Reset" name="Reset" value="Reset">
   </td>
  </tr>
 </table>
</form>