<?php

include ("global.php");

$pagetitle=" - Topic admin";

$links=" > Topic admin";

include ("header.php");

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

$topicnum=$topic;
$topictime=topic_numtotime($forum,$topicnum);

$forumconfigarray=getdata("$configarray[2]/$forum.php");
$moderatorsarray=explode("\t",$forumconfigarray[1]);

if($action=="closetopic"){
  writedata("$configarray[2]/$forum/$topictime.php","closed",0);
  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "Forum '$forum', Topic '$topicnum' closed<br>";
  print "Auto redirecting <a href=\"index.php?forum=$forum&topic=$topicnum&page=0\">back to topic</a>";
  print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&page=0\">";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";

}

if($action=="opentopic"){
  writedata("$configarray[2]/$forum/$topictime.php","open",0);
  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "Forum '$forum', Topic '$topicnum' opened";
  print "Auto redirecting <a href=\"index.php?forum=$forum&topic=$topicnum&page=0\">back to topic</a>";
  print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&page=0\">";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";
}

if($action=="movetopic"){

 if(!$moveforum){

 tableheader1();
 print "<form action=\"admin_topicoptions.php\" method=post>";
 print "<input type=hidden name=\"forum\" value=\"$forum\" size=40>";
 print "<input type=hidden name=\"topic\" value=\"$topicnum\" size=40>";
 print "<input type=hidden name=\"action\" value=\"$action\" size=40>";
 print "<tr>";
 print "<td class=\"tablecell1\"><span class=\"textlarge\">Move '$topicnum' to which forum?</span><br>";

 print "<br><p align=\"left\">";
 print "<form action=\"admin.php\" method=post>";
 print "<select size=1 name=\"moveforum\" class=\"forminput\">";

 forumsmenu("0",0);

 print "</select>";
 print "<input type=submit name=\"submit\" value=\"Move\" class=\"formbutton\">";
 print "</form>";
 print "</p>";

 print "</tr>";
 print "</table>";
 }

 if($moveforum){
  $topicidarray=getdata("$configarray[2]/${moveforum}_topics.php");
  $newtopicid=count($topicidarray);
  
  $postarray=listfiles("$configarray[2]/$forum/$topictime");

  createdir("$configarray[2]/$moveforum/$topictime");

  for($n=0;$n<count($postarray);$n++){
   @rename("$configarray[2]/$forum/$topictime/$postarray[$n].php","$configarray[2]/$moveforum/$topictime/$postarray[$n].php");
  }

  @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$moveforum/$topictime.php");

  @rmdir("$configarray[2]/$forum/$topictime");
  
  writedata("$configarray[2]/${moveforum}_topics.php",$topictime,$newtopicid);
  writedata("$configarray[2]/${moveforum}/$topictime.php",$newtopicid,3);

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "Moved topic '$topicnum'<br>";
  print "Auto redirecting <a href=\"index.php?forum=$moveforum&topic=$newtopicid&page=0\">back to topic</a>";
  print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$moveforum&topic=$newtopicid&page=0\">";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";

 }

}

}

print "<br><br>";

include("footer.php");

?>
