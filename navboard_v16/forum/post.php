<?php
include ("global.php");

if($configarray[40]){
 $links=" > Post";
 $pagetitle=" - Post";
 include("header.php");
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table>";
}else{

if(isset($topic)){
$topicnum=$topic;
$topictime=topic_numtotime($forum,$topicnum);
}

$forumconfigarray=getdata("$configarray[2]/$forum.php");
$topicconfigarray=getdata("$configarray[2]/$forum/$topictime.php");
$postarray=listfiles("$configarray[2]/$forum/$topictime");
$firstpostarray=getdata("$configarray[2]/$forum/$topictime/0.php");


if(!isset($forum)){
$pagetitle=" - Post";
$links=" > Post";
}

if(isset($forum)&&!isset($topic)){
$pagetitle=" - New topic in forum: $forumconfigarray[3]";
$links=" > New topic in forum: $forumconfigarray[3]";
}

$firstpostarray[2]=htmlentities($firstpostarray[2]);

if(isset($forum)&&isset($topictime)){
 if($mode=="edit"){
 $pagetitle=" - Editing - Forum: $forumconfigarray[3], Topic: $firstpostarray[2]";
 $links=" > Editing > Forum: $forumconfigarray[3], Topic: $firstpostarray[2]";
 }else{
 $links=" > New reply > Forum: $forumconfigarray[3], Topic: $firstpostarray[2]";
 $pagetitle=" - New reply - Forum: $forumconfigarray[3], Topic: $firstpostarray[2]";
 }
}

include ("header.php");

if(isset($forum)&&isset($topictime)&&!isset($post)&&!$mode){$mode="reply";}
if(isset($forum)&&!isset($topictime)&&!isset($post)&&!$mode){$mode="topic";}

$emailarray=explode("\t",$userloggedinarray[2]);
if(checkban($userkeyarray[$navboardlogin],$REMOTE_ADDR,$emailarray[0],$userloggedinarray[15])){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "You are banned, you cannot post";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}else{

if(($mode=="topic"&&!getforumaccess("topic")) || (($mode=="reply"||$mode=="quote")&&!getforumaccess("reply")) || (isset($forum)&&isset($topictime)&&$topicconfigarray[0]=="closed")){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "You do not have access to post here!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}elseif((!isset($forum))||(isset($forum)&&count($forumconfigarray)<=0)||(isset($forum)&&isset($topictime)&&count($postarray)<=0)){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Forum or topic is invalid!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}else{

 if($step==""){
 $moderatorsarray=explode(",",$forumconfigarray[1]);
 $post--;
 $indpostarray=getdata("$configarray[2]/$forum/$topictime/$post.php");

 if($mode=="edit"&&!geteditaccess()){
  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "You dont have access to edit this post!";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";
 }else{

 tableheader1();

 $file_uploads=ini_get("file_uploads");

 print "<form action=\"post.php\" ";
 if($file_uploads){print "enctype=\"multipart/form-data\" ";}
 print "method=post name=\"post\">";

 print "<input type=hidden name=\"step\" value=\"2\">";
 if(isset($forum)) {print "<input type=hidden name=\"forum\" value=\"$forum\">";}
 if(isset($topic)) {print "<input type=hidden name=\"topic\" value=\"$topicnum\">";}
 if(isset($post)) {print "<input type=hidden name=\"post\" value=\"$post\">";}
 if($mode) {print "<input type=hidden name=\"mode\" value=\"$mode\">";}
 if(isset($poststart)) {print "<input type=hidden name=\"poststart\" value=\"$poststart\">";}

 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">Subject</span><br>";

 unset($value);
 if($mode=="edit"&&isset($post)){
 $value=htmlentities($indpostarray[2]);
 }

 print "<input type=text name=\"subject\" value=\"$value\" class=\"forminput\" size=40 tabindex=\"1\"><br>";

 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">Body<br><br>";

 displaysmilies();

 print "<br><br>";

 print "</span>";

 $value="";

 //quote
 if($mode=="quote"&&isset($post)){
 $value=trim(ereg_replace("\[br\]","\n",$indpostarray[3]));
 $poster=$indpostarray[0];
 $userarray=getdata("$configarray[1]/$poster/main.php");
  if(count($userarray)<=0||$poster==0){
  $userarray[0]="Guest";
  }
 $value="[quote=$userarray[0]]${value}[/quote]";
 }
 //edit
 if($mode=="edit"&&isset($post)){
 $value=ereg_replace("\[br\]","\n",$indpostarray[3]);
 $value=htmlentities($value);
 }

 print "<textarea class=\"forminput\" rows=12 cols=80 name=\"body\" class=\"forminput\" tabindex=\"2\">$value</textarea><br></td>";

 print "</tr>";

 //edit
 if($mode=="edit"){
 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">";
 print "Delete post ";
 print "<input type=checkbox name=\"deletepost\" class=\"forminput\" tabindex=\"3\">";
 print " (click submit after checking box)</span>";
 print "</td>";
 print "</tr>";
 }

 //not edit or new topic
 if($mode!=="edit"&&$mode!=="topic"){
  print "<tr><td width=\"100%\" class=\"tablecell1\">\n";
  print "<span class=\"textlarge\">Rate this thread (optional) 1=worst 10=best</span><br>\n";
  print "<select size=1 name=\"rating\" class=\"forminput\" tabindex=\"4\">\n";
  print "<option value=\"$r\"></option>\n";
   for($r=10;$r>0;$r--){
   print "<option value=\"$r\">$r</option>\n";
   }
  print "</select>\n";
  print "</td></tr>\n";
 }

  print "<tr><td width=\"100%\" class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  if($file_uploads){
   print "Attachment (optional)<br>";
   print "Valid extensions: $configarray[22]<br>";
   print "Size limit: ".round(($configarray[23]/1024),2)." kb ($configarray[23] bytes)<br>";
   if($mode=="edit"){
    print "NOTE: Using this when editing will overwrite any currect attachment!<br>";
    print "<input type=checkbox name=\"deleteattachment\" class=\"forminput\" size=40 tabindex=\"5\"> Delete current attachment<br>";
   }
   print "<input type=file name=\"attachmentfile\" class=\"forminput\" size=40 tabindex=\"6\">";
  }else{
   print "Attachments cannot be used on this server, file_uploads is off in php ini!";
  }
  print "</span>";
  print "</td></tr>";

 //new thread
 if($mode=="topic"){
 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Make this thread a poll <input type=checkbox name=\"poll\" class=\"forminput\" tabindex=\"7\"> (subject would be poll question)<br>";
 print "At least options 1 and 2 must be filled out, the rest are optional<br>";
  for($n=0;$n<$configarray[24];$n++){
  print "Option ".($n+1)." <input type=text name=\"pollitem$n\" class=\"forminput\" tabindex=\"".(8+$n)."\"><br>";
  }
 print "</span>";
 print "</td>";
 print "</tr>";
 }

 if(($userloggedinarray[15]=="administrator"||(@in_array($useridarray[$navboardlogin],$moderatorsarray)&&$login==1))&&($post==0||$mode=="topic")){

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">";
 print "Make post important ";

  if(substr($topictime,0,10)=="important_"){
  print "<input type=checkbox name=\"importantpost\" checked class=\"forminput\" tabindex=\"".(7+$configarray[24]+1)."\">";
  }else{
  print "<input type=checkbox name=\"importantpost\" class=\"forminput\" tabindex=\"".(7+$configarray[24]+1)."\">";
  }

 print " (will stick it to the top of the forum!)</span>";
 print "</td>";
 print "</tr>";

 }else{

  if(substr($thread,0,10)=="important_"&&($mode=="reply"||$mode=="edit")){
  print "<input type=hidden name=\"importantpost\" value=\"on\">";
  }

 }

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">";
 print "Disable bbcode/smilies in this post (board will ignore bbcode/smilies) ";
 if($indpostarray[10]=="on"){
 print "<input type=checkbox name=\"disablebbcode\" class=\"forminput\" checked tabindex=\"".(7+$configarray[24]+2)."\">";
 }else{
 print "<input type=checkbox name=\"disablebbcode\" class=\"forminput\" tabindex=\"".(7+$configarray[24]+2)."\">";
 }
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><input type=submit name=\"submit\" value=\"Submit\" class=\"formbutton\" tabindex=\"".(7+$configarray[24]+3)."\"></td>";
 print "</form>";
 print "</tr>";
 print "</table>";

 print "<br><br>";

 tableheader1();

 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 if($configarray[14]=="allowhtml"){
 print "HTML Enabled<br>";
 }else{
 print "HTML Disabled<br>";
 }

 print "BB Code Enabled:<br>";

 $bbcodearray=getdata("$configarray[5]/bbcode.php");

 if(count($bbcodearray)>0){

  for($n=0;$n<count($bbcodearray);$n++){
   $linearray=explode("\t",$bbcodearray[$n]);

   print "$linearray[0]<br>\n";
  }

 }else{
 print "None\n";
 }

 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

  print "<br>";
   if(isset($topictime)&&isset($forum)){

   tableheader1();
   print "<tr>";
   print "<td class=\"tableheadercell\" colspan=\"2\">";
   print "<span class=\"textsmall\">";
   print "<b>Last $configarray[8] posts of topic (newest post first):</b><br>";
   print "</span>";
   print "</td>";
   print "</tr>";

   @rsort($postarray,SORT_NUMERIC);
   for($n=0;$n<count($postarray)&&$n<$configarray[8];$n++)
   {
    displaypostrow($forum,$topictime,$postarray[$n]);
   }
   @sort($postarray,SORT_NUMERIC);

   print "</table>";
   }//iframe display check

 }//end edit access check bracket
}//end step 1 bracket

 #######ADDING THE POST#######
 if($step==2){
 
 if(isset($topic)){
 $topicnum=$topic;
 $topictime=topic_numtotime($forum,$topicnum);
 }

 $body=ereg_replace("\n","",$body);
 $body=ereg_replace("\r","[br]",$body);
 $body=stripslashes($body);

 $subject=ereg_replace("\n","",$subject);
 $subject=ereg_replace("\r","",$subject);
 $subject=stripslashes($subject);
 
 if($login!==1){ //this part finds most recent post time in forum (for guest flood control)
 $newesttopictime=newestthread($forum);
 $userloggedinarray[18]=$newesttopictime;
 }

 if((($userloggedinarray[18]+$configarray[37])>time())&&($mode=="topic"||$mode=="reply"||$mode=="quote")){
  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "You must wait at least $configarray[37] seconds between your posts<br>";
  print "The last post time is the same for all guests";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";
 }else{
 if(strlen($body)>$configarray[18]||strlen($subject)>$configarray[25]){
  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "Body must be less than $configarray[18] characters long<br>";
  print "Subject must be less than $configarray[25] characters long<br>";
  print "Your body is ".strlen($body)." characters long<br>";
  print "Your subject is ".strlen($subject)." characters long";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";
 }else{
   ############# new topic #################
  if(isset($forum)&&!isset($topictime)&&trim($subject)&&trim($body)&&$mode=="topic"){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

   $post="0";

   $time=time();
   if($importantpost=="on"){
   $topictime="important_$time";
   }else{
   $topictime=$time;
   }

   $pollstatus=1;
   if($poll=="on"){

    if(!$pollitem0||!$pollitem1){
    $pollstatus=0;
    print "You must fill out at least poll item 1 and 2!<br>";
    }else{
     unset($pollitems);
      for($n=0;$n<$configarray[24];$n++){
      $varname="pollitem$n";
       if(${$varname}){
       $pollitems=$pollitems.stripslashes(${$varname})."\t";
	     $pollvotes=$pollvotes.",";
       }
      }
	   createdir("$configarray[2]/$forum/$topictime");
     writedata("$configarray[2]/$forum/$topictime/$post.php","poll",4);
     writedata("$configarray[2]/$forum/$topictime/$post.php",$pollitems,5);
	   writedata("$configarray[2]/$forum/$topictime/$post.php",$pollvotes,6);
	   writedata("$configarray[2]/$forum/$topictime/$post.php",$pollvoters,7);
     $pollstatus=1;
    }

   }else{
   createdir("$configarray[2]/$forum/$topictime");
   }

   $attachstatus=1;
   if($attachmentfile&&$attachmentfile!=="none"){
    $attachstatus=addattachment();

    if($attachstatus==1){
	  createdir("$configarray[2]/$forum/$topictime");
	  writedata("$configarray[2]/$forum/$topictime/$post.php","attachment",4);
    writedata("$configarray[2]/$forum/$topictime/$post.php",$attachmentfile_name,5);
    }
   }else{
   createdir("$configarray[2]/$forum/$topictime");
   }

   if($attachstatus==0||$pollstatus==0){
     print "Post not added, attachment or poll problem";
     @rmdir("$configarray[2]/$forum/$topictime");
   }else{
	writedata("$configarray[2]/$forum/$topictime/$post.php",$useridarray[$navboardlogin],0);
	writedata("$configarray[2]/$forum/$topictime/$post.php",$time,1);
	writedata("$configarray[2]/$forum/$topictime/$post.php",$subject,2);
	writedata("$configarray[2]/$forum/$topictime/$post.php",$body,3);
	writedata("$configarray[2]/$forum/$topictime/$post.php",$REMOTE_ADDR,9);
	writedata("$configarray[2]/$forum/$topictime/$post.php",$disablebbcode,10);

    if($forumconfigarray[6]=="on"){
     $posts=$userloggedinarray[6]+1;
	   writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$posts,6);
    }

    //add last post info to user
    writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$time,18);

	$topicidarray=getdata("$configarray[2]/${forum}_topics.php");
	$topicnum=count($topicidarray);
    writedata("$configarray[2]/${forum}_topics.php",$topictime,$topicnum);
	writedata("$configarray[2]/$forum/$topictime.php",$topicnum,3);

    print "Post added...auto redirecting <a href=\"index.php?forum=$forum&topic=$topicnum&page=0\">back to post</a>";
    print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&page=0\">";
   }//attach success check

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

   ############# quoting post or reply ################
  }elseif(isset($forum)&&isset($topictime)&&trim($body)&&($mode=="quote"||$mode=="reply")){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

   @rsort($postarray,SORT_NUMERIC);
   $post=$postarray[0]+1;
   @sort($postarray,SORT_NUMERIC);

   $attachstatus=1;
   if($attachmentfile&&$attachmentfile!=="none"){
   $attachstatus=addattachment();
    if($attachstatus==1){
     $newname=time();

     //update time of thread and update config file to new time also
     if($importantpost=="on"){
	 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/important_$newname");
	 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/important_$newname.php");
     $newtopic="important_$newname";
	 }else{
	 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/$newname");
	 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/$newname.php");
     $newtopic="$newname";
     }

	  writedata("$configarray[2]/$forum/$newname/$post.php","attachment",4);
      writedata("$configarray[2]/$forum/$newname/$post.php",$attachmentfile_name,5);
    }
   }else{
     $newname=time();

     //update time of thread and update config file to new time also
     if($importantpost=="on"){
	 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/important_$newname");
	 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/important_$newname.php");
     $newtopic="important_$newname";
	 }else{
	 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/$newname");
	 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/$newname.php");
     $newtopic="$newname";
     }
   }//if attachment

   if($attachstatus==0){
    print "Post not added, attachment problem";
   }else{
	writedata("$configarray[2]/$forum/$newtopic/$post.php",$useridarray[$navboardlogin],0);
	writedata("$configarray[2]/$forum/$newtopic/$post.php",$time,1);
	writedata("$configarray[2]/$forum/$newtopic/$post.php",$subject,2);
	writedata("$configarray[2]/$forum/$newtopic/$post.php",$body,3);
	writedata("$configarray[2]/$forum/$newtopic/$post.php",$disablebbcode,10);
    writedata("$configarray[2]/$forum/$newtopic/$post.php",$REMOTE_ADDR,9);

   //add one to users post count
   if($forumconfigarray[6]=="on"){
    $posts=$userloggedinarray[6]+1;
	writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$posts,6);
   }

   //add last post info to user
   writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$time,18);

   //add rating
   if($rating!==""){
   $ratingarray=explode("\t",$topicconfigarray[1]);
   $ratingarray[0]=$ratingarray[0]+$rating;
   $ratingarray[1]++;
   writedata("$configarray[2]/$forum/$topictime.php","$ratingarray[0]	$ratingarray[1]",1);
   }

   writedata("$configarray[2]/${forum}_topics.php",$newtopic,$topicnum);
   if($configarray[42]=="on"){writedata("$configarray[2]/$forum.php",$forumconfigarray[11]+1,11);}

   print "Post added...auto redirecting <a href=\"index.php?forum=$forum&topic=$topicnum&page=last\">back to post</a>";
   print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&page=last\">";   
   }//end attach success check

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

   ############## editing/deleting post ####################
  }elseif($mode=="edit"&&trim($body)&&isset($post)&&isset($topictime)&&isset($forum)){

   if($deletepost=="on"){

    if($post==0){

      deletetopic($forum,$topictime);

      tableheader1();
      print "<tr>";
      print "<td class=\"tablecell1\">";
      print "<span class=\"textlarge\">";
      print "Thread deleted<br>";
      print "</span>";
      print "</td>";
      print "</tr>";
      print "</table>";

    }else{
    deletepost($forum,$topictime,$post);

    tableheader1();
    print "<tr>";
    print "<td class=\"tablecell1\">";
    print "<span class=\"textlarge\">";
    print "Post deleted...auto redirecting <a href=index.php?forum=$forum&topic=$topicnum&page=1>back to post</a>";
    print "</span>";
    print "</td>";
    print "</tr>";
    print "</table>";

    print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&page=1\">";
    }//delete post 0 check

   }else{//not deleting post

   if($post==0&&!trim($subject)){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "You can't put a blank subject in the first post!!";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
   }else{

    $indpostarray=getdata("$configarray[2]/$forum/$topictime/$post.php");
    $moderatorsarray=explode(",",$forumconfigarray[1]);
 
     if($mode=="edit"&&!geteditaccess()){
      tableheader1();
      print "<tr>";
      print "<td class=\"tablecell1\">";
      print "<span class=\"textlarge\">";
      print "You dont have access to edit this post!";
      print "</span>";
      print "</td>";
      print "</tr>";
      print "</table>";
     }else{

     writedata("$configarray[2]/$forum/$topictime/$post.php",$subject,2);
	   writedata("$configarray[2]/$forum/$topictime/$post.php",$body,3);
     writedata("$configarray[2]/$forum/$topictime/$post.php",$disablebbcode,10);
     if($indpostarray[11]){$editarray=explode(",",$indpostarray[11]);}
     $editarray[]=$useridarray[$navboardlogin].",".time();
     $editline=implode(",",$editarray);
     writedata("$configarray[2]/$forum/$topictime/$post.php",$editline,11);

     tableheader1();
     print "<tr>";
     print "<td class=\"tablecell1\">";
     print "<span class=\"textlarge\">";

     if($deleteattachment=="on"){
      $indpostarray=getdata("$configarray[2]/$forum/$topictime/$post.php");
      @unlink("attachments/$indpostarray[5]");
	    writedata("$configarray[2]/$forum/$topictime/$post.php","",4);
	    writedata("$configarray[2]/$forum/$topictime/$post.php","",5);
     }
     
     $attachstatus=1;
     if($attachmentfile&&$attachmentfile!=="none"){
     $attachstatus=addattachment();

      if($attachstatus==1){
       $indpostarray=getdata("$configarray[2]/$forum/$topictime/$post.php");
       @unlink("attachments/$indpostarray[5]");
	     writedata("$configarray[2]/$forum/$topictime/$post.php","attachment",4);
       writedata("$configarray[2]/$forum/$topictime/$post.php",$attachmentfile_name,5);
      }
     }

     if(substr($topictime,0,10)=="important_"){
      $newtopic=substr($topictime,10);
     }else{
      $newtopic=$topictime;
     }

	 if($importantpost=="on"){
	 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/important_$newtopic");
	 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/important_$newtopic.php");
     $newtopic="important_$newtopic";
	 }else{
	 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/$newtopic");
	 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/$newtopic.php");
     $newtopic="$newtopic";
     }

     writedata("$configarray[2]/${forum}_topics.php",$newtopic,$topicnum);

     print "Post edited...auto redirecting <a href=\"index.php?forum=$forum&topic=$topicnum&page=$page\">back to post</a>";
     print "</span>";
     print "</td>";
     print "</tr>";
     print "</table>";

     print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&page=$page\">";

    }//access check

   }//edit check for blank subject post 0

   }//delete check

  }else{
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Your post was not added for one of the following reasons:<br>";
   print "-All posts must have a body<br>";
   print "-New threads and first posts must also have a subject<br>";
   print "-Someone may have replied to the thread while you were posting<br>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
  }//mode if/then

 }//end size check
 }//end flood control check

 }//end step 2 bracket

}//access check

}//ban check

}//board closed check

print "<br><br>";

tableheader1();

require ("footer.php");
?>
