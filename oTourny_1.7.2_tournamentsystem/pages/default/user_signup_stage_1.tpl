<table width=100% border="0" cellpadding="0" cellspacing="0" class="signup">

<tr><td colspan="2" align="center" class="headline">Player Signup - Stage 1</td>
</tr>

<tr><td colspan="2" class="error">{ERRORS}</td></tr>

<tr><td colspan="2" class="news">

Welcome to {SITE_NAME}, as a New Member you will be required to fill out several forms and to provide a valid email address. After you have become a member, you will be able to join tournaments and join/create teams.</td></tr>

<form method="post">

  <tr>

   <td colspan=2>Please fill out all the fields completely.  A required field is denoted with a <span class="requiredtxt">*</span></td>

  </tr>

    <tr><td width="39%" height=10></td></tr>

  <tr class="rowoff">

   <td colspan=2><span class="requiredtxt">Min: 3 Letters</span></td>

  </tr>

  <tr class="row">

   <td class="info">Username: <span class="requiredtxt">*</span></td>

   <td width="61%" align=right><div align="left">
     <input type=text name="{FIELD_NAME}" size=35 maxlength=65535 value="{FIELD_NAME_VALUE}">
   </div></td>

  </tr>

  <tr class="rowoff">

   <td colspan=1><span class="requiredtxt">Min: 5 Letters</span></td><td colspan=1><span class="requiredtxt">Use a Temporary Password, You can change it later.</span></td>

  </tr>

  <tr class="row">

   <td class="info">Password <span class="requiredtxt">*</span></td>

   <td align=right><div align="left">
     <input type=password name="{FIELD_PASS1}" size=35 maxlength=65535>
   </div></td>

  </tr>

  <tr class="row">

   <td class="info">Reenter your Password <span class="requiredtxt">*</span></td>

   <td align=right><div align="left">
     <input type=password name="{FIELD_PASS2}" size=35 maxlength=65535>
   </div></td>

  </tr>

  <tr class="rowoff">

   <td colspan=2><span class="requiredtxt">Valid Email Required. Min: 3 Letters</span></td>

  </tr>

  <tr class="row">

   <td class="info">Enter a <i>valid</i> email address <span class="requiredtxt">*</span></td>

   <td align=right><div align="left">
     <input type=text name="{FIELD_EMAIL}" size=35 maxlength=65535  value="{FIELD_EMAIL_VALUE}">
   </div></td>

  </tr>

  <tr class="rowoff">
   <td align="center" colspan=2><input type="checkbox" name="{FIELD_COOPA}" value="{FIELD_COOPA_VALUE}">I am 13 years or older.</span></td>

  </tr>

  <tr>

   <td colspan=2>&nbsp;</td>

  </tr>

  <tr>    <td colspan="2" align="center" class="headline">Player Agreement:</td></tr>

    <tr> <td colspan=2>{USER_SIGNUP_AGREEMENT}

   </td>

  </tr>

   <td align="center" colspan=2><br>

    <input type=submit value="I Agree - Onto Step 2 >>"> <input type=reset value="Reset Data Fields">

   </td>

  </tr>

</form>
</table>