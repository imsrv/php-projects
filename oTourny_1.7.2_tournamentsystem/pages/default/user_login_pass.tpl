<table width=100% align="center"><tr><td class="subheader" align="center">{SITE_NAME} - Lost Password</td></tr></table>
<form method=POST>
 <table width=100% class="lostpass">
 {ERRORS}
  <tr class="row"><td align="center">You will need to enter in your Player name and your email address, this will be used to confirm who you are. You will be emailed a link to login and change your password.</td></tr>
  <tr class="rowoff"><td>Player Name: <input type="text" maxlength="255" size="25" name="{FIELD_NAME}" value="{FIELD_NAME_VALUE}"></td></tr>
  <tr class="row"><td>E-Mail Address: <input type="text" maxlength="65535" size="30" name="{FIELD_EMAIL}" value="{FIELD_EMAIL_VALUE}"></td></tr>
  <tr class="rowoff"><td align="center"><input type="submit" name="{FIELD_SUBMIT}" value="Request Password">&nbsp;&nbsp;<input type="Reset" name="Reset" value="Clear Information"></td></tr>
 </table>
</form>
<span class="requiredtxt">Note: All trailing and leading spaces from your entries will be trimed for you convience.</span>