<table width=100% align="center">
 <tr><td colspan="2" class="headline" align="center">Tournament Banner</td></tr>
 <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
</table>
<table cellspacing="0" cellpadding="0" width=100# border="0"  align="center"  class="borderit">	<!-- Outer Table -->
 <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
 <tr>
  <td width=50% valign="top">
   <table cellspacing="0" cellpadding="0" width=95% border="0" align="center">
    <template name="ERROR">
     <tr><td class="text" align="center"><span class="error">
      There was an Error while Uploading Picture. Please Try Again.
     </span></td></tr>
    </template name="ERROR">
    <tr><td class="text">Main Banner: {FILE_NAME}</td></tr>
    <tr>
     <td class="qstat" align="center" valign="middle">
      <img src="{FILE_LOCATION}">
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
 <tr>
  <td align="center">
   <form enctype="{enctype}" method=POST>
    <input type="hidden" name="MAX_FILE_SIZE" value="{FILE_MAX}">Main Banner:
    <input type="{FIELD_FILE_TYPE}" name="{FIELD_FILE_NAME}"  size="70">
    <input type="submit" name="{FIELD_SUBMIT_NAME}" value="Upload">
   </form>
  </td>
 </tr>
 <tr><td colspan="2" height=10> </td></tr> <!-- Spacer used for positioning -->
</table>