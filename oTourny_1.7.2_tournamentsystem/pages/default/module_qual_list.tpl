<table width="100%">
 <tr>
  <th width="40%">
   Team
  </th>
  <th>
   Score
  </th>
  <th>
   Wins
  </th>
  <th>
   Loses
  </th>
  <th>
   Ties
  </th>
 </tr>
 <template name="TEAMS">
  <template name="TEAM">
   <tr>
    <td align="left">
     {NAME}
    </td>
    <td align="left">
     {SCORE}
    </td>
    <td align="center">
     {WINS}
    </td>
    <td align="center">
     {LOSES}
    </td>
    <td align="center">
     {TIES}
    </td>
   </tr>
  </template name="TEAM">
  <template name="NONE">
   <tr>
    <td colspan="5">
     <span class="requiredtxt">
      <center>
       There are no {TYPE}s in Qualifing Round.
      </center>
     </span>
    </td>
   </tr>
  </template name="NONE">
 </template name="TEAMS">
</table>