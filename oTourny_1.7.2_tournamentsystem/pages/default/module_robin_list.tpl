<template name="DIVISION">
 <table width="100%">
  <tr>
   <th>
    Division: {DIVISION_ID}
   </th>
  </tr>
 </table>
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
        There are no {TYPE}s in Round Robin.
       </center>
      </span>
     </td>
    </tr>
   </template name="NONE">
  </template name="TEAMS">
 </table>
</template name="DIVISION">
<template name="DIVISION_NONE">
 <span class="requiredtxt">
  <center>
   There are no Divisions.
  </center>
 </span>
</template name="DIVISION_NONE"> 