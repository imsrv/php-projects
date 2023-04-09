<center>
 Select a Module Team List
 <br>
 <span class="requriredtxt">
  Every {TYPE} in the Tournament is listed below. Each team has a rank, which will decide their seeding order. Select the Correct teams and modify ranks if neccessary.
 </span>
 <br>
</center>
<hr>
<form method=POST>
<div align="right">
 <input type="submit" name="{FIELD_SUBMIT}" value="Seed Teams">
</div>
 <table width="100%">
  <tr>
   <th width="90%">
    {TYPE} Name
   </th>
   <th width="10%" align="right">
    Rank
   </th>
  </tr>
  <template name="LIST">
   <template name="ROW">
    <tr class="{CLASS}">
     <td>
      <input type="checkbox" name="{FIELD_CHK}" value="{FIELD_CHK_VALUE}" {FIELD_CHK_CHK}>
      {NAME}
     </td>
     <td align="right">
      <input type="text" maxlength="4" size="4" name="{FIELD_RANK}" value="{FIELD_RANK_VALUE}">
     </td>
    </tr>
   </template name="ROW">
   <template name="NONE">
    <tr>
     <td align="center">
      <span class="error">There are no {TYPE}s in Tournament.</span>
     </td>
    </tr>
   </template name="NONE">
  </template name="LIST">
 </table>
<div align="right">
 <input type="submit" name="{FIELD_SUBMIT}" value="Seed Teams">
</div>

</form>