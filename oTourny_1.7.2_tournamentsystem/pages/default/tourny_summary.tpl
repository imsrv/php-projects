<template name="NEWS">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament News</td></tr></table>
 {CONTENT}
</template name="NEWS">
<template name="SPONS">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Sponsors</td></tr></table>
 {CONTENT}
</template name="SPONS">
<template name="PRIZES">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Prizes</td></tr></table>
 {CONTENT}
</template name="PRIZES">
<template name="DESC">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Description</td></tr></table>
 {CONTENT}
</template name="DESC">
<template name="GAME">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Game</td></tr></table>
 <table width=""470"">
  <template name="GAME_NAME">
   <tr><td>
    Game Name: {CONTENT}
   </td></tr>
  </template name="GAME_NAME">
  <template name="GAME_TYPE">
   <tr><td>
    Game Type: {CONTENT}
   </td></tr>
  </template name="GAME_TYPE">
  <template name="GAME_MOD">
   <tr><td>
    Game Mod: {CONTENT}
   </td></tr>
  </template name="GAME_MOD">
 </table>
</template name="GAME">
<template name="SCHEDULE">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Schedule</td></tr></table>
 {CONTENT}
</template name="SCHEDULE">
<template name="MAPS">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Maps</td></tr></table>
 {CONTENT}
</template name="MAPS">
<template name="RULES">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Rules</td></tr></table>
 {CONTENT}
</template name="RULES">
<template name="ADMINS">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament Admins</td></tr></table>
 <table width="470" border=0>
  <template name="ADMIN_ROWS">
   <tr>
    <template name="ADMIN_COLS">
     <td width=30% align="center">
      {ADMIN_NAME}
     </td>
    </template name="ADMIN_COLS">
   </tr>
  </template name="ADMIN_ROWS">
 </table>
</template name="ADMINS">
<template name="TEAMS">
 <table width="470" align="center"><tr><td class="headline" align="center">Tournament {TYPE_NAME}s</td></tr></table>
 <table width="470">
  <template name="TEAMS_ROWS">
   <tr>
    <template name="TEAMS_COLS">
     <td width=30% align="center">
      {TEAM_NAME}
     </td>
     </template name="TEAMS_COLS">
   </tr>
  </template name="TEAMS_ROWS">
 </table>
</template name="TEAMS">