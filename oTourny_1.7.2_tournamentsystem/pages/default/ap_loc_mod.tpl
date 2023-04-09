<form method="POST">
 <table width="100%" align="center">
  <tr class="row">
   <td colspan="2">
    Enter in the name of the Location.
   </td>
  </tr>
  <tr class="rowoff">
   <td width="50%" align="left">
    Name:
   </td>
   <td width="50%" align="left">
    <input type="text" maxlength="{FIELD_NAME_MAX}" size="60" name="{FIELD_NAME_NAME}" value="{FIELD_NAME_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td colspan="2">
    Use the Map of the Earth Below to Determine the Longitude and Latitude of the Region.
   </td>
  </tr>
  <tr class="rowoff">
   <td width="50%" align="left">
    Longitude:
   </td>
   <td width="50%" align="left">
    <input type="text" maxlength="{FIELD_LON_MAX}" size="4" name="{FIELD_LON_NAME}" value="{FIELD_LON_VALUE}">
   </td>
  </tr>
  <tr class="row">
   <td width="50%" align="left">
    Latitude:
   </td>
   <td width="50%" align="left">
    <input type="text" maxlength="{FIELD_LAT_MAX}" size="4" name="{FIELD_LAT_NAME}" value="{FIELD_LAT_VALUE}">
   </td>
  </tr>
  <tr class="rowoff">
   <td colspan="2" align="center">
    <input type="submit" name="{FIELD_SUBMIT_NAME}" value="Save Location">
   </td>
  </tr>
 </table>
 <div align="center">
  <img src="{LOCATION_IMAGES}earth.gif">
 </div>
</form>