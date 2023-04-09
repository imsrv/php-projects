<?php

include("global.php");

 if($step==""){

 print "<table>";
 print "<form action=\"upgrade_to12.php\" method=\"post\">";
 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\">";
 print "Upgrade to v12<br><br>";
 print "READ upgrade.txt documentation before proceeding!<br>";
 print "DO NOT run this file if you dont want to upgrade!<br>";
 print "BACKUP data files before running this upgrade!<br>";
 print "Upgrading around 1000 posts take approx 10 seconds on step 3!<br>";
 print "<br>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\">Delete styles (styles not used in v12, themes are now used)<br>";
 print "<input type=checkbox name=\"deletestyles\"></td>";
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
  $avatarsarray=ReadFiles("$configarray[11]",".");
  @mkdir("avatars",octdec(777));
  @chmod("avatars",octdec(777));

  for($n=0;$n<count($avatarsarray);$n++){
  @rename("$configarray[11]/$avatarsarray[$n]","avatars/$avatarsarray[$n]");
  print "Upgraded avatar '$avatarsarray[$n]'<br>";
  }

  @rmdir("$configarray[11]");

  print "<a href=\"upgrade_to12.php?step=3\">Next step</a>";
 }//step 2 bracket

 if($step==3){

 $forumarray=ReadDirs("$configarray[2]");

  for($n=0;$n<count($forumarray);$n++){
  $threadarray=ReadFiles("$configarray[2]/$forumarray[$n]",".txt");

   for($m=0;$m<count($threadarray);$m++){
    $postarray=GetTxtData("$configarray[2]/$forumarray[$n]/$threadarray[$m]");
    $threadid=substr($threadarray[$m],0,-4);
    @mkdir("$configarray[2]/$forumarray[$n]/$threadid",octdec(777));
    @chmod("$configarray[2]/$forumarray[$n]/$threadid",octdec(777));

    for($o=0;$o<count($postarray);$o+=4){
     $postid=$o/4;
     WriteTxtData(0,"$configarray[2]/$forumarray[$n]/$threadid/$postid.txt",$postarray[$o]);
     WriteTxtData(1,"$configarray[2]/$forumarray[$n]/$threadid/$postid.txt",$postarray[$o+1]);
     WriteTxtData(2,"$configarray[2]/$forumarray[$n]/$threadid/$postid.txt",$postarray[$o+2]);
     WriteTxtData(3,"$configarray[2]/$forumarray[$n]/$threadid/$postid.txt",$postarray[$o+3]);
    }

    @unlink("$configarray[2]/$forumarray[$n]/$threadarray[$m]");

    print "Upgraded thread '$threadarray[$m]'<br>";

   }
  }

 print "<a href=\"upgrade_to12.php?step=4\">Next step</a>";

 }//step 3 bracket

 if($step==4){
 @unlink("$configarray[5]/bbcode.txt");

  if($deletestyles=="on"){

   $stylesarray=ReadFiles("$configarray[3]",".txt");
   for($n=0;$n<count($stylesarray);$n++){
    @unlink("$configarray[3]/$stylesarray[$n]");
   }
   @rmdir("$configarray[3]");

  }

 print "UPGRADE IS FINISHED!";
 }//step 4 bracket


?>