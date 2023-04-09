<template name="ERRORS">
 <template name="ERROR_HEAD">
  Your Entry had the following errors:
  <hr>
  <span class="error">{ERRORS}</span>
  <hr>
 </template name="ERROR_HEAD">

 <template name="ERROR_NAME_BOUNDS">
  Your Name must be more than 3 and less than 50 characters.<br>
 </template name="ERROR_NAME_BOUNDS">

 <template name="ERROR_PASS_BOUNDS">
  Password must be longer than 5 characters and less than 50 characters.<br>
 </template name="ERROR_PASS_BOUNDS">

 <template name="ERROR_EMAIL">
  Email is not a Valid format.<br>
 </template name="ERROR_EMAIL">
</template name="ERRORS">

Please configure the admin account.
<br>
<form method=POST>
 <table width="600" class="setup">
  <tr>
   <th width="40%">
   </th>
   <th width="60%">
   </th>
  </tr>
  <tr>
   <td colspan="2" align="right">
    <input type="submit" name="{FIELD_SUBMIT}" value="Submit">
   </td>
  </tr>
  <tr>
   <td>
    Name:
    <br>
    <span class="requiredtxt">
     Min: 3 letters.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_NAME}" value="{FIELD_NAME_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Password:
    <br>
    <span class="requiredtxt">
     Min: 5 letters.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_PASS}" value="{FIELD_PASS_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Email:
    <br>
    <span class="requiredtxt">
     Must be a Valid Email. Min: 3 letters.
    </span>
   </td>
   <td>
     <input type="text" maxlength="255" size="30" name="{FIELD_EMAIL}" value="{FIELD_EMAIL_VALUE}">
   </td>
  </tr>
  <tr>
   <td colspan="2" align="right">
    <input type="submit" name="{FIELD_SUBMIT}" value="Submit">
   </td>
  </tr>
 </table>
</form> 