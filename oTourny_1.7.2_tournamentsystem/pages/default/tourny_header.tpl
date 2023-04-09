<table align="center"><tr><td class="header" align="center">
 {TOURNY_NAME}
</td></tr></table>

<template name="BANNER">
 <center>
  <a href="?page=tourny&tournyid={TOURNY_ID}">
   <img border=0 src="picture.php?id={BANNER_ID}">
  </a>
 </center>
</template name="BANNER">

<table>
 <tr><td>
  <table class="news" align="center" width="465">
   <tr>
    <td width="33%" align="center">
     <template name="DATE">
      Start Date: {TOURNY_DATE}
     </template name="DATE">
    </td>
    <td width="33%" align="center">
     <template name="JOIN">
      <a href="?page=tourny&tournyid={TOURNY_ID}&cmd=join">Join Tournament</a>
     </template name="JOIN">
    </td>
    <td width="33%" align="center">
     <template name="MAX">
      Max {TYPE_NAME}s: {TOURNY_JOIN}
     </template name="MAX">
    </td>
   </tr>
  </table>
 </td></tr>
</table>
<br>
{CONTENT}