<?php

include("global.php");

 if($step==""){

 print "<table>";
 print "<form action=\"upgrade_to13.php\" method=\"post\">";
 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\">";
 print "Upgrade to v13<br><br>";
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

  for($n=0;$n<count($forumarray);$n++){
  $threadarray=ReadDirs("$configarray[2]/$forumarray[$n]");
  @rename("$configarray[2]/$forumarray[$n].cfg","$configarray[2]/$forumarray[$n].txt");

   for($m=0;$m<count($threadarray);$m++){
    $postarray=ReadFiles("$configarray[2]/$forumarray[$n]/$threadarray[$m]",".txt");
    @rename("$configarray[2]/$forumarray[$n]/$threadarray[$m].cfg","$configarray[2]/$forumarray[$n]/$threadarray[$m].txt");

    for($o=0;$o<count($postarray);$o++){
    $indpostarray=GetTxtData("$configarray[2]/$forumarray[$n]/$threadarray[$m]/$postarray[$o]");
    $extraarray=explode(",",$indpostarray[4]);
     if($extraarray[0]=="attachment"){
     WriteTxtData(4,"$configarray[2]/$forumarray[$n]/$threadarray[$m]/$postarray[$o]","attachment");
     WriteTxtData(5,"$configarray[2]/$forumarray[$n]/$threadarray[$m]/$postarray[$o]","$extraarray[1]");
     }
    }

    @unlink("$configarray[2]/$forumarray[$n]/$threadarray[$m]");

    print "Upgraded thread '$threadarray[$m]'<br>";

   }
  }

 print "<a href=\"upgrade_to13.php?step=3\">Next step</a>";

 }//step 2 bracket

 if($step==3){
 @unlink("$configarray[5]/bbcode.txt");

 print "UPGRADE IS FINISHED!";
 }//step 3 bracket


?>