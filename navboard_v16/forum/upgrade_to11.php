<?php

include("global.php");

 if($step==""){

 print "<table>";
 print "<form action=\"upgrade_to11.php\" method=\"post\">";
 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\">";
 print "Upgrade to v11<br><br>";
 print "READ upgrade.txt documentation before proceeding!<br>";
 print "DO NOT run this file if you dont want to upgrade!<br>";
 print "BACKUP data files before running this upgrade!<br>";
 print "<br>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\">User ID# to start converting users at (if you dont know leave this at 1)<br>";
 print "<input type=text name=\"useridstart\" size=40 value=\"1\"></td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\">Forum ID# to start converting forums at (if you dont know leave this at 1)</font><br>";
 print "<input type=text name=\"forumidstart\" size=40 value=\"1\"></td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\">Delete blank users<br>";
 print "<input type=checkbox name=\"deleteblankusers\" checked></td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\">Delete posts with blank subjects<br>";
 print "<input type=checkbox name=\"deleteblankposts\" checked><br></td>";
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

 $usersarray=ReadFiles("$configarray[1]",".txt");

  $m=$useridstart;
  for($n=0;$n<count($usersarray);$n++){
  $userarray=GetTxtData("$configarray[1]/$usersarray[$n]");

   if($deleteblankusers=="on"&&(trim($userarray[0])==""||trim(substr($usersarray[$n],0,-4))=="")){

   @unlink("$configarray[1]/$usersarray[$n]");

   print "Deleted blank user '$userarray[0]'<br>";

   }else{

    //put account name in accounts.txt
    WriteTxtData($m,"$configarray[1]/accounts.txt",$userarray[0]);

    //make new directory for user with id
    @mkdir("$configarray[1]/$m",octdec(777));
    chmod("$configarray[1]/$m",octdec(777));

    //move user file to mainfile under new directory
    rename("$configarray[1]/$usersarray[$n]","$configarray[1]/$m/$mainfile");

    print "Upgraded user '$userarray[0]'<br>";

   }//deleteblank user bracket

  $m++;
  }

 print "<a href=\"upgrade_to11.php?step=3&forumidstart=$forumidstart&deleteblankposts=$deleteblankposts\">Next step</a>";

 }//step 2 bracket

 if($step==3){

 $forumarray=ReadDirs("$configarray[2]");

  $m=$forumidstart;
  for($n=0;$n<count($forumarray);$n++){

  //change moderators to be split by comma instead of tab and change them to user ids
  $forumconfigarray=GetTxtData("$configarray[2]/$forumarray[$n].cfg");
  $moderatorsarray=explode("\t",$forumconfigarray[1]);

  if($moderatorsarray[0]!==""){

   for($p=0;$p<count($moderatorsarray);$p++){
   $moderatorsarray[$p]=$useridarray[$moderatorsarray[$p]];
   }

  }

  $moderatorsline=implode(",",$moderatorsarray);
  WriteTxtData(1,"$configarray[2]/$forumarray[$n].cfg","$moderatorsline");

  //put forum name/other defaults in forum config
  WriteTxtData(3,"$configarray[2]/$forumarray[$n].cfg","$forumarray[$n]");
  WriteTxtData(4,"$configarray[2]/$forumarray[$n].cfg","0");
  WriteTxtData(5,"$configarray[2]/$forumarray[$n].cfg","forum");

  //change forum folder and configfile to id
  rename("$configarray[2]/$forumarray[$n]","$configarray[2]/$m");
  rename("$configarray[2]/$forumarray[$n].cfg","$configarray[2]/$m.cfg");

  print "Upgraded forum '$forumarray[$n]'<br>";

  $m++;
  }

 print "<a href=\"upgrade_to11.php?step=4&deleteblankposts=$deleteblankposts\">Next step</a>";

 }//step 3 bracket

 if($step==4){

 $forumarray=ReadDirs("$configarray[2]");

  for($n=0;$n<count($forumarray);$n++){
  $threadarray=ReadFiles("$configarray[2]/$forumarray[$n]",".txt");

   for($m=0;$m<count($threadarray);$m++){
   $postarray=GetTxtData("$configarray[2]/$forumarray[$n]/$threadarray[$m]");

   if($deleteblankposts=="on"&&trim($postarray[2])==""){

   @unlink("$configarray[2]/$forumarray[$n]/$threadarray[$m]");

   print "Deleted blank thread '$threadarray[$m]'<br>";

   }else{

    for($o=0;$o<count($postarray);$o+=4){
    //change usernames to user ids
    $username=trim($postarray[$o]);
    $userid=$useridarray[$username];

    //if userid is 0 it may be becuase of inconsistency
    if($userid=="0"||$userid==""||$userid==" "||$userid==0){
    $username=ucfirst(trim($postarray[$o]));
    $userid=$useridarray[$username];
    }

    WriteTxtData($o,"$configarray[2]/$forumarray[$n]/$threadarray[$m]","$userid");
    }

   print "Upgraded thread '$threadarray[$m]'<br>";

   }//end delete blank posts bracket

   }

  }

 print "<a href=\"upgrade_to11.php?step=5\">Next step</a>";

 }//step 4 bracket

 if($step==5){
 @unlink("$configarray[5]/bbcode.txt");

 print "UPGRADE IS FINISHED!";
 }//step 5 bracket


?>