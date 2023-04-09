<?php

include("global.php");

@ini_set("max_execution_time",120);

 if($step==""){
 print "Upgrade to v15<br><br>";
 print "READ upgrade.txt documentation before proceeding!<br>";
 print "DO NOT run this file if you dont want to upgrade!<br>";
 print "BACKUP data files before running this upgrade!<br>";
 print "<br>";
 print "<a href=\"upgrade_to16.php?step=2\">Upgrade!</a>";
 }

 //convert to topic num from timestamp id
 if($step==2){

 for($n=0;$n<count($forumarray);$n++){
  $topicarray=listdirs("$configarray[2]/$forumarray[$n]");

   unset($timesarray);
   for($m=0;$m<count($topicarray);$m++){
   $postarray=listfiles("$configarray[2]/$forumarray[$n]/$topicarray[$m]"); @sort($postarray,SORT_NUMERIC);
   $indpostarray=getdata("$configarray[2]/$forumarray[$n]/$topicarray[$m]/$postarray[0].php");
   $timesarray[$topicarray[$m]]=$indpostarray[1];
   }
   
   @asort($timesarray,SORT_NUMERIC);
   $p=0;
   if(count($timesarray)>0){
    foreach($timesarray as $topic => $time){
     writedata("$configarray[2]/$forumarray[$n]/$topic.php",$p,3);
     writedata("$configarray[2]/$forumarray[$n]_topics.php",$topic,$p);
     $p++;
    }
   }
 }

 print "<a href=\"upgrade_to16.php?step=3\">Next step</a>";
 }//step 2
 
 //make forum list file
 if($step==3){
 
 function subforums_upgrade($parentforum,$level){
 global $configarray,$forumarray;

 for($n=0;$n<count($forumarray);$n++){
 $forumconfigarray=getdata("$configarray[2]/$forumarray[$n].php");
  if($forumconfigarray[4]==$parentforum){
   //add to list
   $forumlist=getdata("$configarray[2]/list.php");
   unset($forumsublist);
   if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   $forumsublist[]=$forumarray[$n];
   $forumsublistline=implode(",",$forumsublist);
   writedata("$configarray[2]/list.php",$forumsublistline,$parentforum);
   //end add to list
   subforums_upgrade($forumarray[$n],$level+1);;
  }
 }
 


}//end sub forums function
 
 subforums_upgrade("0","0");
 
 print "UPGRADE IS FINISHED!";
 }//step 2


?>
