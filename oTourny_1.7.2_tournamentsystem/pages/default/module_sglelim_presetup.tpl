<template name="ERROR">
 <span class="error">
  Your Bracket did not meet specifications. The values have been corrected, please check and resubmit.
 </span>
</template name="ERROR">
<center>
 Double Elimination Bracket Setup
</center>
<br>
<form method=POST>
 <table width="100%">
  <tr>
   <td width="50%">
    Name:
    <br>
    <span class="requiredtxt">
     Use a unique name as this is your reference for this bracket throughout the site.
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
   <td colspan="2" align="center">
    <input type="submit" name="{FIELD_SUBMIT_NAME}" value="Create Bracket">
   </td>
  </tr>
 </table>
</form>