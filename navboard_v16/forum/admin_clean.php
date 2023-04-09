<?php

include("global.php");

$pagetitle=" - Administration - Clean";
$links=" > Administration > Clean";

include ("header.php");

include ("admin_header.php");

if($userloggedinarray[15]!=="administrator"){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Must be logged in as administrator to use control panel!";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
}else{

 if(!$clean){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Backup ALL data before performing any of these tasks<br><br>";
 print "<form action=\"admin_clean.php\" method=post>";
 print "<input type=hidden name=\"clean\" value=\"1\" size=40>";

 print "<input type=checkbox name=\"correcttopictime\" class=\"forminput\" checked>";
 print " Correct topic time with correct last post time<br>";
 print "<input type=checkbox name=\"postuseridfixreg\" class=\"forminput\">";
 print " Revert post user ids to zero if post time is before user registration date<br>";
 print "<input type=checkbox name=\"postuseridfixexist\" class=\"forminput\">";
 print " Revert post user ids to zero if user doesn't exist<br>";
 print "<input type=checkbox name=\"blankuserfix\" class=\"forminput\">";
 print " Delete users if username or displayname or password is blank<br>";
 print "<input type=checkbox name=\"topicconfigfix\" class=\"forminput\" checked>";
 print " Delete uploaded attachments that are not used<br>";
 print "<input type=checkbox name=\"avatarfix\" class=\"forminput\" checked>";
 print " Delete uploaded avatars that are not used<br>";
 print "<input type=checkbox name=\"invalidtopicfix\" class=\"forminput\" checked>";
 print " Delete topics where first post is invalid (blank user or time or subject) <br>";
 print "<input type=checkbox name=\"invalidpostfix\" class=\"forminput\" checked>";
 print " Delete posts that are invalid (blank user or time) <br>";
 print "<input type=checkbox name=\"emptytopicfix\" class=\"forminput\" checked>";
 print " Delete threads where there is no first post or no posts at all<br>";
 print "<br><br>";
 print "<input type=submit name=\"submit\" value=\"Clean\" class=\"formbutton\">";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if($clean){
 @ini_set(MAX_EXECUTION_TIME,120);

 for($m=0;$m<count($forumarray);$m++){
 $topicarray=listdirs("$configarray[2]/$forumarray[$m]");

  for($n=0;$n<count($topicarray);$n++){
  $postarray=listfiles("$configarray[2]/$forumarray[$m]/$topicarray[$n]");
  @sort($postarray,SORT_NUMERIC);
  
  if($correcttopictime=="on"){
  @rsort($postarray,SORT_NUMERIC);
  $indpostarray2=getdata("$configarray[2]/$forumarray[$m]/$topicarray[$n]/$postarray[0].php");
  print "-$forumarray[$m]-$topicarray[$n]-<br>";
  $topicnum=topic_timetonum($forumarray[$m],$topicarray[$n]);
  if(substr($topicarray[$n],0,10)=="important_"){
   $newtopictime="important_$indpostarray2[1]";
  }else{
   $newtopictime="$indpostarray2[1]";
  }
  @rename("$configarray[2]/$forumarray[$m]/$topicarray[$n]","$configarray[2]/$forumarray[$m]/$newtopictime");
  @rename("$configarray[2]/$forumarray[$m]/$topicarray[$n].php","$configarray[2]/$forumarray[$m]/$newtopictime.php");

  print "-$newtopictime-$topicnum-<br>";
  writedata("$configarray[2]/${forumarray[$m]}_topics.php",$newtopictime,$topicnum);
  @sort($postarray,SORT_NUMERIC);
  }

    if($emptytopicfix=="on"){
     if($postarray[0]!=="0"||!count($postarray)>0){
	    deletetopic($forumarray[$m],$topicarray[$n]);
	   }
    }
    
   for($l=0;$l<count($postarray);$l++){
   $indpostarray=getdata("$configarray[2]/$forumarray[$m]/$topicarray[$n]/$postarray[$l].php");
   $userarray=getdata("$configarray[1]/$indpostarray[0]/main.php");

    if($invalidtopicfix=="on"&&$l==0){
     if($indpostarray[0]==""||$indpostarray[1]==""||$indpostarray[2]==""){
	    deletetopic($forumarray[$m],$topicarray[$n]);
	   }
    }
   
    if($invalidpostfix=="on"){
     if($indpostarray[0]==""||$indpostarray[1]==""){
	    deletepost($forumarray[$m],$topicarray[$n],$postarray[$l]);
	   }
    }

    if($postuseridfixreg=="on"){
     if($indpostarray[1]<$userarray[4]){
	    writedata("$configarray[2]/$forumarray[$m]/$topicarray[$n]/$postarray[$l].php","0",0);
	   }
    }
	
	  if($postuseridfixexist=="on"){
     if(!count($userarray)>0){
	    writedata("$configarray[2]/$forumarray[$m]/$topicarray[$n]/$postarray[$l].php","0",0);
	   }
    }
	
	 if($attachmentfix=="on"){
	  if($indpostarray[4]=="attachment"){
     $usedattachmentsarray[]=$indpostarray[5];
	  }
   }

   }//post loop

  }//thread loop

 }//forum loop
 
 if($attachmentfix=="on"){
 $attachmentsarray=listfilesext("attachments");
  for($n=0;$n<count($attachmentsarray);$n++){
 
   if(!@in_array($attachmentsarray[$n],$usedattachmentsarray)){
    @unlink("attachments/$attachmentsarray[$n]");
   }
 
  }
 }
 
 for($n=0;$n<count($usersarray);$n++){
 $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");
 
 if($blankuserfix=="on"){
  if($userarray[0]==""||$userarray[1]==""||$userkeyarray[$usersarray[$n]]==""){
   deleteuser($usersarray[$n]);
  }
 }
 
 if($avatarfix=="on"){
  $usedavatarsarray[]=$userarray[7];
 }
 
 }
 
 if($avatarfix=="on"){
 $avatarsarray=listfilesext("avatars");
 for($n=0;$n<count($avatarsarray);$n++){
 
  if(!@in_array($avatarsarray[$n],$usedavatarsarray)){
  @unlink("avatars/$avatarsarray[$n]");
  }
 
 }
 }

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Cleaning finished!<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

}
include("admin_footer.php");
 print "<br><br>";
 tableheader1();

 include("footer.php");

?>
