<template name="ADMIN">
 <tr><td><br><table width="100%" class="panel" border="0"><tr class="adminsubbartournytop"><td class="adminsubbartournytop" align=center>
  <a class="adminsubbartournytop" href="?page=admin&cmd=tourny&cmdd=select&tournyid={TOURNY_ID}">
   Select Tournament
  </a>
 </td><td class="adminsubbartournytop" align=center>
  <a class="adminsubbartournytop" href="?page=admin&cmd=tourny&cmdd=approve&tournyid={TOURNY_ID}">
   Approve Tournament
  </a>
 </td></tr></table>
</template name="ADMIN">
<table width="100%" class="panel" border="0"><tr class="adminsubbartournymiddle"><td class="adminsubbartournymiddle" align=center>
 <a class="adminsubbartournymiddle" href="?page=admin&cmd=tourny&cmdd=setup&tournyid={TOURNY_ID}">
  Setup
 </a>
</td><td class="adminsubbartournymiddle" align=center>
 <a class="adminsubbartournymiddle" href="?page=admin&cmd=tourny&cmdd=banner&tournyid={TOURNY_ID}">
  Banner
 </a>
</td><td class="adminsubbartournymiddle" align=center>
 <a class="adminsubbartournymiddle" href="?page=admin&cmd=tourny&cmdd=admins&tournyid={TOURNY_ID}">
  Admins
 </a>

</td><td class="adminsubbartournymiddle" align=center>
 <a class="adminsubbartournymiddle" href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}">
  Servers
 </a>
</td><td class="adminsubbartournymiddle" align=center>
 <a class="adminsubbartournymiddle" href="?page=admin&cmd=tourny&cmdd=teamsetup&tournyid={TOURNY_ID}">
  Teams
 </a>
</td></tr></table><table width="100%" class="panel" border="0"><tr class="adminsubbartournybot"><td class="adminsubbartournybot" align=center>
 <a class="adminsubbartournybot" href="?page=admin&cmd=tourny&cmdd=stage&tournyid={TOURNY_ID}">

 Delete Tournament

 </a>
</td></tr></table></td></tr>