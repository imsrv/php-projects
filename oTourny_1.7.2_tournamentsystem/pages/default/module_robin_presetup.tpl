<template name="ERROR">
 <span class="error">
  Your Round Robin did not meet specifications. The values have been corrected, please check and resubmit.
 </span>
</template name="ERROR">
<center>
 Round Robin Setup
</center>
<br>
<form method=POST>
 <table width="100%">
  <tr>
   <td width="50%">
    Name:
    <br>
    <span class="requiredtxt">
     Use a unique name as this is your reference for this module throughout the site.
     <br>
     Min: 5 Max: 125
    </span>
   </td>
   <td width="50%">
    <input type="text" maxlength="125" size="35" name="{FIELD_NAME_NAME}" value="{FIELD_NAME_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
    {TYPE}s Per Match
    <br>
    <span class="requiredtxt">
     Min: 2 Max: {TPM_MAX}
    </span>
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_TPM_NAME}" value="{FIELD_TPM_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
    Maps Per Match
    <br>
    <span class="requiredtxt">
     Min: 1 Max: 999
    </span>
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_MPM_NAME}" value="{FIELD_MPM_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
    Divisions:
    <br>
    <span class="requiredtxt">
     Min: 1 Max: 999
     <br>
     Number of Divisions. The teams will be evenly divided per division.
    </span>
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_DIV_NAME}" value="{FIELD_DIV_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
    Qualifing Teams:
    <br>
    <span class="requiredtxt">
     Min: 0 Max: 999
     <br>
     Number of teams that will qualify from each Division. Enter "0" to have all teams qualify.
    </span>
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_QUAL_NAME}" value="{FIELD_QUAL_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
    Points by:
    <br>
    <span class="requiredtxt">
     Points by Map - Points are given on map basis.
     <br>
     Points by Match - Points are given on a match basis.
    </span>
   </td>
   <td width="50%">
    <select name="{FIELD_POINTS}">
     <option value="{FIELD_POINTS_MAP}">
      Points By Map
     </option>
     <option value="{FIELD_POINTS_MATCH}">
      Points By Match
     </option>
    </select>
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
    Points for:
   </td>
  </tr>
  <tr>
   <td width="50%">
     Winning
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_WIN_NAME}" value="{FIELD_WIN_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
     Losing
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_LOSE_NAME}" value="{FIELD_LOSE_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
     Tie
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_TIE_NAME}" value="{FIELD_TIE_VALUE}">
   </td>
  </tr>
  <tr>
   <td width="50%">
     Forfeit
   </td>
   <td width="50%">
    <input type="text" maxlength="3" size="20" name="{FIELD_FORFEIT_NAME}" value="{FIELD_FORFEIT_VALUE}">
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
    <input type="submit" name="{FIELD_SUBMIT_NAME}" value="Create Qualifing Round">
   </td>
  </tr>
 </table>
</form>