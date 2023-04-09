<?php

include("global.php");

$pagetitle=" - Administration - Status";
$links=" > Administration > Status";

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

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";

 print "Board status information";
 print "<br><br>";
 
 print "<b>Attachments</b><br>";

 $allattachments=listfilesext("attachments");
 $totalsize=0;
 for($n=0;$n<count($allattachments);$n++){
  $filesize=filesize("attachments/$allattachments[$n]");
  $totalsize+=$filesize;
  print "<a href=\"attachments/$allattachments[$n]\" target=\"_blank\">$allattachments[$n]</a>, $filesize bytes<br>";
 }

 print "<br>";
 
 print "Total size of all attachments: $totalsize bytes<br>";
 print "Total alloted space for all attachments: $configarray[31]<br>";
 print "<br>"; 

 for($m=0;$m<count($forumarray);$m++){
 $topicarray=listdirs("$configarray[2]/$forumarray[$m]");

  for($n=0;$n<count($topicarray);$n++){
   $postarray=listfiles("$configarray[2]/$forumarray[$m]/$topicarray[$n]");
   $topic="$forumarray[$m]/$topicarray[$n]";
   $postamountarray[$topic]=count($postarray);
   unset($topicfilesize);
	
    for($l=0;$l<count($postarray);$l++){
	 $postfilesize=filesize("$configarray[2]/$forumarray[$m]/$topicarray[$n]/$postarray[$l].php");
	 $post="$forumarray[$m]/$topicarray[$n]/$postarray[$l]";
	 $postfilesizearray[$post]=$postfilesize;
	 $topicfilesize+=$postfilesize;
	}
   
   $topicfilesizearray[$topic]=$topicfilesize;
  }//thread loop

 }//forum loop
 
 @arsort($postamountarray,SORT_NUMERIC);
 @arsort($postfilesizearray,SORT_NUMERIC);
 @arsort($topicfilesizearray,SORT_NUMERIC);
 
 print "<b>5 largest individual posts by file size</b><br>";
 $n=0;
 if(count($postfilesizearray)>0){
 foreach($postfilesizearray as $post => $filesize){
  $n++;
  if($n==6){break;}
   $postnamearray=explode("/",$post);
   $topicnum=topic_timetonum($postnamearray[0],$postnamearray[1]);
   $post=($postnamearray[2]+1);
   print "<a href=\"index.php?forum=$postnamearray[0]&topic=$topicnum#post$post\">$postnamearray[0]/$topicnum/$post</a>, $filesize bytes<br>";
 }
 }
 print "<br>";
 
 print "<b>5 largest topics by file size</b><br>";
 $n=0;
 if(count($topicfilesizearray)>0){
 foreach($topicfilesizearray as $topic => $filesize){
  $n++;
  if($n==6){break;}
   $topicnamearray=explode("/",$topic);
   $topicnum=topic_timetonum($topicnamearray[0],$topicnamearray[1]);
   print "<a href=\"index.php?forum=$topicnamearray[0]&topic=$topicnum\">$topicnamearray[0]/$topicnum</a>, $filesize bytes<br>";
 }
 }
 print "<br>";
 
 print "<b>5 largest topics by posts</b><br>";
 $n=0;
 if(count($postamountarray)>0){
 foreach($postamountarray as $topic => $posts){
  $n++;
  if($n==6){break;}
   $topicnamearray=explode("/",$topic);
   $topicnum=topic_timetonum($topicnamearray[0],$topicnamearray[1]);
   print "<a href=\"index.php?forum=$topicnamearray[0]&topic=$topicnum\">$topicnamearray[0]/$topicnum</a>, $posts posts<br>";
 }
 }
 print "<br>";
 
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

}
include("admin_footer.php");
 print "<br><br>";
 tableheader1();

 include("footer.php");

?>
