<?php

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"user_edit.php?user=$user\">Edit info</a>";
   print " | <a href=\"user_options.php?user=$user\">Edit options</a>";
   print " | <a href=\"user_pass.php?user=$user\">Change password</a>";
   print " | <a href=\"user_buddy.php?user=$user\">Buddy list</a>";
   print " | <a href=\"user_pm.php?user=$user\">Private messages</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

   print "<br>";

?>
