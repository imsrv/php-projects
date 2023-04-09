<?php

include("global.php");

 if($step==""){

 print "<table>";
 print "<form action=\"upgrade_to14.php\" method=\"post\">";
 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\">";
 print "Upgrade to v14<br><br>";
 print "READ upgrade.txt documentation before proceeding!<br>";
 print "DO NOT run this file if you dont want to upgrade!<br>";
 print "BACKUP data files before running this upgrade!<br>";
 print "<br>";
 print "</tr>";
 print "</table>";

 print "<br><br>";

 print "<table>";

 print "<tr>";
 print "<td width=\"100%\"><input type=submit name=\"submit\" value=\"Upgrade!\"</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
 }

 if($step==2){
 
 print "This needs to be manually done by user<br>";
 print "ONLY if you secured your data directories before<br>";
 print "If you never heard of that or dont know how then you most likely didn't do it!<br><br>";
 print "Rename data directories back to normal:<br>";
 print "data<br>";
 print "data/forum<br>";
 print "data/users<br>";
 print "data/modules<br>";
 print "Custom options should be in main data directory<br><br>";
 print "See secure.txt for how to secure your files again<br>";
 print "Do this before next step";

 print "<br>";

 print "<a href=\"upgrade_to14.php?step=3\">Next step</a>";

 }//step 2 bracket

 if($step==3){
  for($n=0;$n<count($forumarray);$n++){
   fs_write("forumconfig","",0,array('forum'=>$forumarray[$n]));
   fs_write("forumconfig","guest",7,array('forum'=>$forumarray[$n]));
   fs_write("forumconfig","guest",8,array('forum'=>$forumarray[$n]));
   fs_write("forumconfig","guest",9,array('forum'=>$forumarray[$n]));
  }
 
 print "Security/permission settings for individual forums have been reset<br>";
 print "Very sorry for the trouble but there is a new system in place<br>";
 
 print "<br><br>UPGRADE IS FINISHED!";
 }//step 3


?>