Match Status:

<table width="100%">
 <tr>
  <th>
   {TYPE}
  </th>
  <th>
   Winner
  </th>
  <th>
   Loser
  </th>
  <th>
   Tie
  </th>
  <th>
   Forfeit
  </th>
  <th>
   Undecided
  </th>
 </tr>
 <template name="STATUS_TEAM_LIST">
  <tr>
   <td align="left">
    <a href="{TEAM_LINK}"><template name="STATUS_TEAM_NAME">{TYPE} Not Set</template name="STATUS_TEAM_NAME"></a>
   </td>
   <td align="center">
    <input type="radio" name="{FIELD_WIN_NAME}" value="{FIELD_WIN_VALUE_4}" {FIELD_WIN_CHK_4} {FIELD_WIN_DIS_4}>
   </td>
   <td align="center">
    <input type="radio" name="{FIELD_WIN_NAME}" value="{FIELD_WIN_VALUE_3}" {FIELD_WIN_CHK_3} {FIELD_WIN_DIS_3}>
   </td>
   <td align="center">
    <input type="radio" name="{FIELD_WIN_NAME}" value="{FIELD_WIN_VALUE_2}" {FIELD_WIN_CHK_2} {FIELD_WIN_DIS_2}>
   </td>
   <td align="center">
    <input type="radio" name="{FIELD_WIN_NAME}" value="{FIELD_WIN_VALUE_1}" {FIELD_WIN_CHK_1} {FIELD_WIN_DIS_1}>
   </td>
   <td align="center">
    <input type="radio" name="{FIELD_WIN_NAME}" value="{FIELD_WIN_VALUE_0}" {FIELD_WIN_CHK_0} {FIELD_WIN_DIS_0}>
   </td>
  </tr>
 </template name="STATUS_TEAM_LIST">
</table>