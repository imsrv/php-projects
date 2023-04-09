<?php

include("global.php");

if($loggingin==1&&$login==1){

 $loggingin=0;

 $pagetitle=" - Logged in";
 $links=" > Logged in";

 include("header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Logged in, auto redirecting to <a href=\"$HTTP_REFERER\">previous page</a>\n";
 print "<meta http-equiv=\"refresh\" content=\"0; url=$HTTP_REFERER\">";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";
 tableheader1();
}elseif($logout==1){

 $pagetitle=" - Logged out";
 $links=" > Logged out";

 include("header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Logged out, auto redirecting to <a href=\"index.php\">index</a>\n";
 print "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";
 tableheader1();
}else{

if($configarray[40]){
 include("header.php");
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table><br><br>";
}else{

#########################################
###############SHOW FORUMS####################
  if(!isset($forum)){
 
 $pagetitle="";
 $links="";

 include("header.php");

tableheader1();

print "<tr height=\"0\">\n";
print "<td width=\"43%\" class=\"tableheadercell\" colspan=\"2\"><span class=\"textheader\" id=\"textheaderlink\"><b>Forum</b></span></td>\n";

print "<td width=\"15%\" class=\"tableheadercell\" align=\"center\">";
print "<span class=\"textheader\" id=\"textheaderlink\"><b>Last Post</b></span>";
print "</span></td>\n";

print "<td width=\"6%\" class=\"tableheadercell\" align=\"center\">";
print "<span class=\"textheader\" id=\"textheaderlink\"><b>Threads</b></span>";
print "</td>\n";

print "<td width=\"6%\" class=\"tableheadercell\" align=\"center\">";
print "<span class=\"textheader\" id=\"textheaderlink\"><b>Replies</b></span>";
print "</td>\n";

print "<td width=\"14%\" class=\"tableheadercell\" align=\"center\">";
print "<span class=\"textheader\" id=\"textheaderlink\"><b>Moderator</b></span>";
print "</td>\n";

print "</tr>";

subforums("0",-1);

   if($userloggedinoptarray[1]!=="on"){

   print "<tr>";
   print "<td class=\"tablecell2\" colspan=\"6\">";

   print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

   print "<tr>";
   print "<td width=\"50%\" height=\"0\">";
   print "&nbsp;";
   print "</td>";

   print "<td width=\"50%\" align=\"right\">";

   print "<span class=\"textsmall\">";
   print "<img src=\"images/${theme_images}/nonew.gif\"> No new posts ";
   print "<img src=\"images/${theme_images}/new.gif\"> New posts ";
   print "<img src=\"images/${theme_images}/locked.gif\"> No access ";
   print "</span>";

   print "</td>";
   print "</tr>";

   print "</table>";

   print "</td>";
   print "</tr>";
   }
   
   print "</table>";

   print "<br>";

   tableheader1();

  }
  //END SHOW FORUMS

#########################################
##############SHOW THREADS################
  if(isset($forum)&&!isset($topic)){

$topictimearray=listdirs("$configarray[2]/$forum");
$forumconfigarray=allforumconfigarray($forum);

if(count($forumconfigarray)>0){

 $pagetitle=" - $forumconfigarray[3]";

 //start link bar
 $links=" > $forumconfigarray[3]";

 $forumconfigarray2=allforumconfigarray($forum);

 while($forumconfigarray2[4]!=="0"){
 $links2=" > <a href=\"index.php?forum=$forumconfigarray2[4]\">";
 $forumconfigarray2=allforumconfigarray($forumconfigarray2[4]);
 $links="$links2$forumconfigarray2[3]</a>$links";
 }

 //end link bar

 include("header.php");

  if(!getforumaccess("view")){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "You do not have access to view this forum!\n";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
  }else{

$subforums=0;

 for($n=0;$n<count($forumarray);$n++){
 $forumconfigarray4=allforumconfigarray($forumarray[$n]);

  if($forumconfigarray4[4]=="$forum"){
  $subforums=1;
  break 1;
  }

 }

if($subforums==1){

tableheader1();

print "<tr bgcolor=\"$stylearray[6]\" height=\"0\">\n";
print "<td width=\"43%\" class=\"tableheadercell\" align=\"left\" colspan=\"2\">";
print "<span class=\"textheader\"><b>Forum</b></span>";
print "</td>\n";

print "<td width=\"15%\" class=\"tableheadercell\">";
print "<p align=\"center\">";
print "<span class=\"textheader\"><b>Last Post</b></span>";
print "</p></span></td>\n";

print "<td width=\"6%\" class=\"tableheadercell\">";
print "<p align=\"center\">";
print "<span class=\"textheader\"><b>Threads</b></span>";
print "</p></td>\n";

print "<td width=\"6%\" class=\"tableheadercell\">";
print "<p align=\"center\">";
print "<span class=\"textheader\"><b>Replies</b></span>";
print "</p></td>\n";

print "<td width=\"14%\" class=\"tableheadercell\">";
print "<p align=\"center\">";
print "<span class=\"textheader\"><b>Moderator</b></span>";
print "</p></td>\n";

print "</tr>";

subforums("$forum",-1);
$forumarray=listdirs("$configarray[2]");

print "</table>";

print "<br>";
}

$forumconfigarray3=allforumconfigarray($forum);

if($forumconfigarray3[5]!=="category"){

  tableheader1();

  print "<tr>";
  print "<td class=\"tablecell2\" colspan=\"7\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

  print "<tr>";
  print "<td width=\"50%\">";

  print "&nbsp";

  print "</td>";

  print "<td width=\"50%\" align=\"right\">";
  print "<span class=\"textsmall\">";

  topiclistbuttons();

  print "</span>";
  print "</td>";
  print "</tr>";

  print "</table>";

  print "</td>";
  print "</tr>";

print "<tr>\n";
print "<td width=\"40%\" class=\"tableheadercell\" colspan=\"2\"><span class=\"textheader\"><b>Topic Title</b></span></td>\n";
print "<td width=\"20%\" class=\"tableheadercell\" align=\"center\"><span class=\"textheader\"><b>Thread Starter</b></span></td>\n";
print "<td width=\"6%\" class=\"tableheadercell\" align=\"center\"><span class=\"textheader\"><b>Replies</b></span></td>\n";
print "<td width=\"6%\" class=\"tableheadercell\" align=\"center\"><span class=\"textheader\"><b>Views</b></span></td>\n";
print "<td width=\"10%\" class=\"tableheadercell\" align=\"center\"><span class=\"textheader\"><b>Rating</b></span></td>\n";
print "<td width=\"19%\" class=\"tableheadercell\" align=\"center\"><span class=\"textheader\"><b>Last Post</b></span></td>\n";
print "</tr>\n";

if(!$page){$page=1;}

 @rsort($topictimearray);
 
  for($n=(($page-1)*$configarray[7]);$n<count($topictimearray)&&$n<((($page-1)*$configarray[7])+($configarray[7]));$n++){
   print "<tr>\n";

   $postarray=listfiles("$configarray[2]/$forum/$topictimearray[$n]");
   $firstpostarray=getdata("$configarray[2]/$forum/$topictimearray[$n]/0.php");
   @rsort($postarray);
   $lastpostarray=getdata("$configarray[2]/$forum/$topictimearray[$n]/$postarray[0].php");
   @sort($postarray);
   $topicconfigarray=getdata("$configarray[2]/$forum/$topictimearray[$n].php");
   $topicnum=topic_timetonum($forum,$topictimearray[$n]);

   print "<td valign=\"top\" class=\"tablecell2\" width=\"1%\">";

   $lastposton=$lastpostarray[1];
   $lastloginarray=explode("\t",$userloggedinarray[5]);

   if($topicconfigarray[0]=="closed"){
     print "<img src=\"images/${theme_images}/locked.gif\" alt=\"\">";
   }else{
    if($lastposton>$lastloginarray[0]){
     print "<img src=\"images/${theme_images}/new.gif\" alt=\"\">";
    }else{
     print "<img src=\"images/${theme_images}/nonew.gif\" alt=\"\">";
    }
   }

   print "</td>";
   print "<td width=\"39%\" class=\"tablecell1\" valign=\"top\">";

   print "<span class=\"textlarge\">";

   $stickytest=substr($topictimearray[$n],0,10);

     if($stickytest=="important_"){
     print "Important: ";
     }

     $extraarray=explode("\t",$firstpostarray[4]);
     if($extraarray[0]=="poll"){
      print "Poll: ";
     }

     $firstpostarray[2]=htmlentities($firstpostarray[2]);

   print "<a href=\"index.php?forum=$forum&topic=$topicnum\">$firstpostarray[2]</a>";
   print "</span>";

   if(count($postarray)>$configarray[8]){
   $page2=1;

   print "<span class=\"textsmall\">";
   print "<br>";
   print "Page: ";
   for($m=0;$m<count($postarray);$m+=$configarray[8]){
   print "<a href=\"index.php?forum=$forum&topic=$topicnum&page=$page2\">$page2</a> ";
   $page2++;
   }

   }

   print "</span>";
   print "</td>";

   print "<td class=\"tablecell2\"><span class=\"textlarge\"><p align=\"center\">";
   
   $userarray=alluserarray($firstpostarray[0]);

   if(count($userarray)>0&&$firstpostarray[0]){
   print "<a href=\"profile.php?user=$firstpostarray[0]\">$userarray[0]</a>";
   }else{
   print "Guest";
   }

   print "</p></span></td>\n";

   $posts=count($postarray)-1;
   print "<td align=\"center\" class=\"tablecell1\"><span class=\"textlarge\">$posts</span></td>";

   print "<td align=\"center\" class=\"tablecell1\"><span class=\"textlarge\">";
   if($topicconfigarray[2]){
    print "$topicconfigarray[2]";
   }else{
    print "0";
   }
   print "</span></td>";

   //rating
   print "<td align=\"center\" class=\"tablecell2\">";
   print "<span class=\"textlarge\">";
   $ratingarray=explode("\t",$threadconfigarray[1]);
   if($ratingarray[0]>0&&$ratingarray[1]>0){
   $rating=$ratingarray[0]/$ratingarray[1];
   $rating=round($rating,1);
   print "${rating}/10\n";
   }else{
   print "&nbsp\n";
   }
   print "</span>";
   print "</td>\n";

   $lastpostby=$lastpostarray[0];
   $lastposton=date($dateformat,$lastpostarray[1]);
   print "<td class=\"tablecell1\" noWrap><span class=\"textsmall\">";
   print "<p align=\"right\">";
   print "$lastposton<br>";
   $userarray=alluserarray($lastpostby);
   if(count($userarray)>0){
   print "by <b><a href=\"profile.php?user=$lastpostby\">$userarray[0]</a><b>";
   }else{
   print "by <b>Guest<b>";
   }
   print "</p>";
   print "</span></td>\n";

   print "</tr>";

  }

  print "<tr>";
  print "<td class=\"tablecell2\" colspan=\"7\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

  print "<tr>";
  print "<td width=\"50%\">";

  print "&nbsp";

  print "</td>";

  print "<td width=\"50%\" align=\"right\">";
  print "<span class=\"textsmall\">";
  topiclistbuttons();

  print "</span>";
  print "</td>";
  print "</tr>";

  print "</table>";

  print "</td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\" colspan=\"7\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

  print "<tr>";

  print "<td width=\"50%\">";
  print "<span class=\"textsmall\">";

  if($userloggedinoptarray[1]!=="on"){
  print "<img src=\"images/${theme_images}/nonew.gif\" alt=\"\"> No new posts ";
  print "<img src=\"images/${theme_images}/new.gif\" alt=\"\"> New posts ";
  print "<img src=\"images/${theme_images}/locked.gif\" alt=\"\"> Locked";
  }

  print "&nbsp;";
  print "</span>";
  print "</td>";

  print "<td width=\"50%\" align=\"right\">";
  print "<span class=\"textsmall\">";
  print "Page: ";
  $page2=1;

  for($n=0;$n<count($topictimearray);$n+=$configarray[7]){

   if($n==(($page-1)*$configarray[7])) {
   print "<b>$page2</b> ";
   }else{
   print "<a href=\"index.php?forum=$forum&page=$page2\">$page2</a> ";
   }

  $page2++;
  }

  print "</span>";

  print "</td>";
  print "</tr>";

  print "</table>";
  print "</td>";
  print "</tr>";

 print "</table>";

 }//end check if category

 }//view access check

 }else{

 $pagetitle=" - Forum view";

 //start link bar
 $links=" > Forum view";

 include("header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Forum does not exist!\n";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 }//end no such forum bracket

  print "<br>";

  tableheader1();

}//END SHOWTHREADS

#########################################
####################SHOW POSTS######################

if(isset($forum)&&isset($topic)){

$topicnum=$topic;
$topictime=topic_numtotime($forum,$topic);

$topicarray=alltopicarray($forum);
$forumconfigarray=allforumconfigarray($forum);
$topicconfigarray=getdata("$configarray[2]/$forum/$topictime.php");
$postarray=allpostarray($forum,$topictime); @sort($postarray,SORT_NUMERIC);
$firstpostarray=getdata("$configarray[2]/$forum/$topictime/0.php");
$userlevelsarray=getdata("$configarray[5]/userlevels.php");
$moderatorsarray=explode(",",$forumconfigarray[1]);

 if(count($postarray)>0){

 $pagetitle=" - $forumconfigarray[3] - $firstpostarray[2]";

 //start link bar
 $links=" > <a href=\"index.php?forum=$forum\">$forumconfigarray[3]</a>";

 $forumconfigarray2=allforumconfigarray($forum);

 while($forumconfigarray2[4]!=="0"){
 $links2=" > <a href=\"index.php?forum=$forumconfigarray2[4]\">";
 $forumconfigarray2=allforumconfigarray($forumconfigarray2[4]);
 $links="$links2$forumconfigarray2[3]</a>$links";
 }

 $firstpostarray[2]=htmlentities($firstpostarray[2]);

 if(substr($topictime,0,10)=="important_"){
 $links="$links > Important: $firstpostarray[2]";
 }else{
 $links="$links > $firstpostarray[2]";
 }
 //end link bar

 }else{
 $pagetitle=" - Post view";
 $links=" > Post view";
 }//exist check

include("header.php");

if(!getforumaccess("view")){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "You do not have access to view this thread!\n";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";
 tableheader1();
}else{

if(count($postarray)<=0){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Thread does not exist!\n";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";
 tableheader1();
}else{

writedata("$configarray[2]/$forum/$topictime.php",$topicconfigarray[2]+1,2);

tableheader1();

print "<tr>";
print "<td class=\"tablecell2\" colspan=\"2\">";

print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

print "<tr>";
print "<td width=\"50%\">";

print "&nbsp;";

print "</td>";

print "<td width=\"50%\" align=\"right\">";

 print "<span class=\"textsmall\">";
 topicbuttons();
 print "</span>";

print "</td>";
print "</tr>";

print "</table>";

print "</td>";
print "</tr>";


if(!$page){$page=1;}
if($page=="last"){
$num=count($postarray)/$configarray[8];
 if($num==intval($num)){$page=$num;}else{$page=intval($num)+1;}
}

for($n=(($page-1)*$configarray[8]);$n<count($postarray)&&$n<((($page-1)*$configarray[8])+($configarray[8]));$n++)
{
 displaypostrow($forum,$topictime,$postarray[$n]);
}

print "<tr>";
print "<td class=\"tablecell2\" colspan=\"2\">";

print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

print "<tr>";
print "<td width=\"50%\">";

print "&nbsp;";

print "</td>";

print "<td width=\"50%\" align=\"right\">";

 print "<span class=\"textsmall\">";
 topicbuttons();
 print "</span>";

print "</td>";
print "</tr>";

print "</table>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td class=\"tablecell1\" colspan=\"2\">";

print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

print "<tr>";
print "<td width=\"50%\" align=\"left\">";
print "<span class=\"textsmall\">";
  if($userloggedinarray[15]=="administrator"||(in_array($useridarray[$navboardlogin],$moderatorsarray)&&!$userloggedinarray[0]=="")){

   print "<p align=\"left\">\n";
   print "<form action=\"admin_topicoptions.php\" method=post>\n";
   print "<span class=\"textsmall\">";
   print "Admin options:\n";
   print "<input type=hidden name=\"forum\" value=\"$forum\" size=40>\n";
   print "<input type=hidden name=\"topic\" value=\"$topicnum\" size=40>\n";
   print "<select size=1 name=\"action\" class=\"forminput\">\n";
   if($topicconfigarray[0]==""||$topicconfigarray[0]=="open") {print "<option value=\"closetopic\">Close Topic</option>\n";}
   if($topicconfigarray[0]=="closed") {print "<option value=\"opentopic\">Open Topic</option>\n";}
   print "<option value=\"movetopic\">Move Topic</option>\n";
   print "</select>\n";
   print "<input type=submit name=\"submit\" value=\"Submit\" class=\"formbutton\">\n";
   print "</span>";
   print "</form>\n";
   print "</p>\n";

  }else{
  print "&nbsp";
  }
print "</span>";
print "</td>";

print "<td width=\"50%\" align=\"right\">";

  print "<table align=\"right\" cellspacing=\"0\" cellpadding=\"0\">";
  print "<tr>";
  print "<td>";

  print "<span class=\"textsmall\">";
  print "Page: ";
 $page2=1;

 for($n=0;$n<count($postarray);$n+=$configarray[8]){

 if($n==(($page-1)*$configarray[8])){
 print "<b>$page</b> \n";
 }else{
 print "<a href=\"index.php?forum=$forum&topic=$topicnum&page=$page2";
  if($highlight){print "&highlight=$highlight";}
 print "\">$page2</a> ";
 }

 $page2++;
 }
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";

print "</td>";
print "</tr>";

print "</table>";

print "</td>";
print "</tr>";

print "</table>";

print "<br>";

tableheader1();

}//access test

}//end testing for empty thread bracket

}//show posts check

}//closed check

}//logging in check
include("footer.php");
?>
