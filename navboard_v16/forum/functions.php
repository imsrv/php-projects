<?php

function BBCode($string,$override="",$highlight=""){
global $configarray,$indpostarray,$globalsmiliesarray,$globalbbcodearray;
unset($trans);

 if($indpostarray[10]!=="on"||$override=="1"){
 $bbcodearray=bbcodearray();

 for($n=0;$n<count($bbcodearray);$n++){
 $linearray=explode("\t",$bbcodearray[$n]);

 if($linearray[2]=="on"){
  $trans['{param}']="\\1";
  $trans['{option}']="\\2";
  $linearray[3]=strtr($linearray[3],$trans);
   for($m=0;$m<$configarray[43];$m++){
   $replacearray[]=$linearray[3];
   $patternarray[]="/\[".$linearray[1]."=(.*?)\](.*?)\[\/".$linearray[1]."\]/i";
   }
 }else{
  $trans['{option}']="\\1";
  $linearray[3]=strtr($linearray[3],$trans);
   for($m=0;$m<$configarray[43];$m++){
   $replacearray[]=$linearray[3];
   $patternarray[]="/\[".$linearray[1]."\](.*?)\[\/".$linearray[1]."\]/i";
   }
 }

 }//end bbcode loop

  //quotes
  for($m=0;$m<$configarray[43];$m++){
  $replacearray[]=template("quote","<u><b>Quote originally posted by \\1</b></u><br><br>\\2<br>");
  $patternarray[]="/\[quote=(.*?)\](.*?)\[\/quote\]/i";
  }

 }//disable check
 if($highlight){
  unset($trans);
  $trans[$highlight]="<span class=\"highlight\">$highlight</span>";
  $string=strtr($string,$trans);
 }

 //line breaks cannot be disabled
 $patternarray[]="/\[br\]/i";
 $replacearray[]="<br>";

 $string=preg_replace($patternarray,$replacearray,$string);

return $string;
}

function smilies($string,$override=""){
global $configarray,$indpostarray,$globalsmiliesarray,$globalbbcodearray;
unset($trans);

 if($indpostarray[10]!=="on"||$override=="1"){
 $string=str_replace("&gt;)", "&gt; )", $string);
 $string=str_replace("&lt;)", "&lt; )", $string);

 $smiliesarray=smiliesarray();

  for($n=0;$n<count($smiliesarray);$n++){
   $linearray=explode("\t",$smiliesarray[$n]);
   $trans[$linearray[0]]="<img src=\"images/smilies/$linearray[1]\">";
  }//end smilies loop

  if($trans){$string=strtr($string,$trans);}
 }

return $string;
}

function subforums($parentforum,$level){
global $configarray,$forumlist,$allforumconfigarray,$alltopicarray,$alluserarray,$allpostarray;

  if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   for($n=0;$n<count($forumsublist);$n++){
    $forumconfigarray=allforumconfigarray($forumsublist[$n]);
     if(getforumaccess("show",$forumsublist[$n])&&$level<$configarray[27]&&$level<30){
      displayforumrow($forumsublist[$n],$level+1,$forumconfigarray);
      subforums($forumsublist[$n],$level+1);
     }
   }

}//end sub forums function


#####  DISPLAY FORUM ROW FUNCTION  #####
function displayforumrow($forum,$level,$forumconfigarray){
global $configarray,$theme,$userloggedinarray,$mainfile,$useridarray,$userkeyarray,$dateformat,$login,$allforumconfigarray,$alluserarray,$alltopicarray,$allpostarray,$theme_images;

  $topicarray=alltopicarray($forum);

  if($forumconfigarray[5]=="category"){

  print "<tr>";
  print "<td colspan=\"6\" class=\"categorycell\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=0 cellpadding=0>";
  print "<tr>";

  //icon spacing
  print "<td width=\"3%\">";
  print "&nbsp;";
  print "</td>";

  //spacer and title

  print "<td width=\"46%\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=0 cellpadding=0>";
  print "<tr>";
  print "<td>";

  $width=($level*$configarray[44])+1;
  print "<td width=\"$width%\">";
  print "&nbsp;";
  print "</td>";

  $width=99-($level*$configarray[44]);
  print "<td width=\"$width%\">";
  print "<span class=\"textlarge\">";
  print "<b><a href=\"index.php?forum=$forum\">$forumconfigarray[3]</a></b>\n";
  print "</span>";
  print "<br>";
  print "<span class=\"textsmall\">";
  print "$forumconfigarray[2]&nbsp;";
  print "</span>";
  print "</td>";

  print "</td>";
  print "</tr>";
  print "</table>";

  print "</td>";
  print "<td width=\"51%\">";
  print "&nbsp;";
  print "</td>";

  print "</tr>";
  print "</table>";

  print "</td>";
  print "</tr>";

  }else{

   if(count($topicarray)>0){
   $topictime=newestthread($forum);
   $topicnum=topic_timetonum($forum,$topictime);

    $postarray=allpostarray($forum,$topictime);
    if(count($postarray)>0){
     @rsort($postarray,SORT_NUMERIC);
     $lastpostarray=getdata("$configarray[2]/$forum/$topictime/$postarray[0].php");
     @sort($postarray,SORT_NUMERIC);
    }
	
   }

   $lastposton=$lastpostarray[1];

   print "<tr>";
   print "<td valign=\"top\" class=\"tablecell2\" width=\"2%\">";
   if(getforumaccess("view",$forum,"")){
    $lastloginarray=explode("\t",$userloggedinarray[5]);
    if($lastposton>$lastloginarray[0]){print "<img src=\"images/${theme_images}/new.gif\" alt=\"\">";}
    if($lastposton<=$lastloginarray[0]){print "<img src=\"images/${theme_images}/nonew.gif\" alt=\"\">";}
   }else{
    print "<img src=\"images/${theme_images}/locked.gif\" alt=\"\">";
   }
   print "</td>";

   print "<td valign=\"top\" class=\"tablecell1\" width=\"39%\">";

   print "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
   print "<tr>";

   $width=($level*$configarray[44])+1;
   //spacing before forum name
   print "<td width=\"$width%\">";
   print "&nbsp;";
   print "</td>";

   $width=99-($level*$configarray[44]);
   //forum name/description
   print "<td valign=\"top\" width=\"$width%\">";
   print "<span class=\"textlarge\">";

   print "<a href=\"index.php?forum=$forum\">$forumconfigarray[3]</a>\n";
   print "</span>";
   print "<span class=\"textsmall\">";
   print "<br>";

   print "$forumconfigarray[2]&nbsp;";
   print "</span>";

   print "</td>";
   print "</tr>";
   print "</table>";

   print "</td>";

   print "<td class=\"tablecell2\">";

   print "<table align=\"left\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
   print "<tr>";
   print "<td width=\"99%\" noWrap align=\"right\">";
   print "<span class=\"textsmall\">";

   if(count($topicarray)>0){
   $lastpostby=$lastpostarray[0];
   $lastposton=$lastpostarray[1];
   $lastposton=date($dateformat,$lastposton);

   print "$lastposton<br>";

   $userarray=alluserarray($lastpostby);

   if(count($userarray)>0){
   print "by <b><a href=\"profile.php?user=$lastpostby\">$userarray[0]</a></b>";
   }else{
   print "by <b>Guest</a></b>";
   }

   }else{
   print "never";
   }
   print "</span>";

   print "</td>";

   print "<td width=\"1%\" valign=\"middle\" align=\"right\">";
   print "<span class=\"textsmall\">";
   @rsort($postarray,SORT_NUMERIC);
   print "&nbsp;<a href=\"index.php?forum=$forum&topic=$topicnum&page=last#post".($postarray[0]+1)."\"><img border=\"0\" alt=\"Goto this post\" src=\"images/${theme_images}/goto.gif\"></a>";
   @sort($postarray,SORT_NUMERIC);
   print "</span>";
   print "</td>";

   print "</tr>";
   print "</table>";
   print "</td>";


   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<p align=\"center\">".count($topicarray)."</p></span></td>\n";

   if($configarray[42]=="on"){
   $replies=$forumconfigarray[11];
   }else{
    $replies=0;
    for($m=0;$m<count($topicarray);$m++){
     $postarray2=allpostarray($forum,$topicarray[$m]);
     $replies+=count($postarray2)-1;
    }
   }
   print "<td class=\"tablecell2\" align=\"center\"><span class=\"textlarge\">";
   print "$replies</span></td>\n";

   print "<td class=\"tablecell1\">\n";
   print "<p align=\"center\">";
   print "<span class=\"textsmall\">";
   $moderatorsarray=explode(",",$forumconfigarray[1]);
   if($moderatorsarray[0]!==""){
    for($m=0;$m<count($moderatorsarray);$m++){
    $userarray=alluserarray($moderatorsarray[$m]);

    if(count($userarray)>0){
    print "<a href=\"profile.php?user=$moderatorsarray[$m]\">$userarray[0]</a>";
    }else{
    print "Guest ($moderatorsarray[$m])";
    }

      if($m<count($moderatorsarray)-1){print ", ";}
    }
   }else{
   print "&nbsp;";
   }
   print "</span>";
   print "</p>";

   print "</td>";
   print "</tr>";
 }//category bracket

}//end display forum row function

function forumsmenu($parentforum,$level,$selected=""){
global $configarray,$forumlist,$allforumconfigarray;

  if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   for($m=0;$m<count($forumsublist);$m++){
    $forumconfigarray=allforumconfigarray($forumsublist[$m]);
	if(getforumaccess("show",$forumsublist[$m])&&$level<$configarray[27]){
	 if($forumsublist[$m]==$selected){
      print "<option value=\"$forumsublist[$m]\" selected>";
     }else{
      print "<option value=\"$forumsublist[$m]\">";
     }//selected test
	
	 for($l=0;$l<$level;$l++){
     print ">";
     }
	
     print " $forumconfigarray[3]</option>\n";
	 forumsmenu($forumsublist[$m],$level+1,$selected);
	}//access/level test
   }//loop

}//end forums menu function

function addattachment(){
global $configarray,$forum,$thread,$post,$attachmentfile,$attachmentfile_name,$fileext;

   $attachnamearray=explode(".",$attachmentfile_name);
   $end=count($attachnamearray)-1;
   $extarray=explode(",",$configarray[22]);

   $allattachments=listfilesext("attachments");
   $totalsize=0;
   for($n=0;$n<count($allattachments);$n++){
    $totalsize+=filesize("attachments/$allattachments[$n]");
   }

  if(!@in_array($attachmentfile_name,$allattachments)){
   if(($totalsize+filesize($attachmentfile))<$configarray[31]){
    if(@in_array($attachnamearray[$end],$extarray)){
     if(filesize($attachmentfile)<$configarray[23]){

       if(@move_uploaded_file($attachmentfile,"attachments/$attachmentfile_name")){
	    @chmod("attachments/$attachmentfile_name",octdec(777));
        print "Attachment uploaded!<br>";
        return 1;
       }else{
        print "Unable to upload Attachment!<br>";
        return 0;
       }

     }else{
      print "Attachment file size must be less than $configarray[23] bytes<br>";
      return 0;
     }//end size check
    }else{
     print "Attachment image must be $configarray[22]<br>";
     return 0;
    }//end type check
   }else{
    print "There is not enough alloted attachment space to store your attachment!<br>";
    return 0;
   }//end total space check
  }else{
   print "There already is a file with the same name as your file<br>";
   return 0;
  }//end exist check

}

function topiclistbuttons(){
global $configarray,$userloggedinarray,$allforumconfigarray,$alluserarray,$forum,$theme,$alltemplates,$replacements,$theme_templates,$theme_replacements;

  if(!getforumaccess("topic")){
  print "Dont have new thread access";
  }else{
  print "<table border=0 width=\"1\" cellpadding=0 cellspacing=0>";
  print "<tr>";
  print "<td align=\"right\">";
  print template("tablebutton","<a href=\"post.php?forum=$forum\">New Topic</a>");
  print "</td>";
  print "</tr>";
  print "</table>";
  }

}

function topicbuttons(){
global $configarray,$userloggedinarray,$allforumconfigarray,$alluserarray,$forum,$topicnum,$page,$theme,$alltemplates,$replacements,$theme_templates,$theme_replacements;

  if(getforumaccess("topic")&&$topicconfigarray[0]!=="closed"){
   print "<td width=\"1\" align=\"right\">";
   print template("tablebutton","<a href=\"post.php?forum=$forum\">New Topic</a>");
   print "</td>";
  }else{
   print "<td align=\"right\" noWrap>";
   print "<span class=\"textsmall\">";
   print "Dont have new topic access&nbsp.&nbsp";
   print "</span>";
   print "</td>";
  }
  if(getforumaccess("reply")&&$topicconfigarray[0]!=="closed"){
   print "<td width=\"1\" align=\"right\">";
   print template("tablebutton","<a href=\"post.php?forum=$forum&topic=$topicnum&page=$page\">Reply</a>");
   print "</td>";
  }else{
   print "<td align=\"right\" noWrap>";
   print "<span class=\"textsmall\">";
   print "Dont have reply access";
   print "</span>";
   print "</td>";
  }
}

function getforumaccess($type,$forum="",$user=""){
global $configarray,$userloggedinarray,$allforumconfigarray,$alluserarray;

if($forum==""){global $forumconfigarray;}
if($forum!==""){$forumconfigarray=allforumconfigarray($forum);}
if($user!==""){$userarray=alluserarray($user);}else{$userarray=$userloggedinarray;}

 $access=1;

 if($type=="view"){
  $forumgroupsarray=explode(",",$forumconfigarray[0]);
  if(@in_array($userarray[15],$forumgroupsarray)){$access=0;}
 }

 if($type=="topic"){
  $forumgroupsarray=explode(",",$forumconfigarray[7]);
  if(@in_array($userarray[15],$forumgroupsarray)||$forumconfigarray[5]=="category"){$access=0;}
 }

 if($type=="reply"){
  $forumgroupsarray=explode(",",$forumconfigarray[8]);
  if(@in_array($userarray[15],$forumgroupsarray)){$access=0;}
 }

 if($type=="edit"){
  $forumgroupsarray=explode(",",$forumconfigarray[9]);
  if(@in_array($userarray[15],$forumgroupsarray)){$access=0;}
 }

 if($type=="show"){
  $forumgroupsarray=explode(",",$forumconfigarray[10]);
  if(@in_array($userarray[15],$forumgroupsarray)){$access=0;}
 }

 return $access;
}

function geteditaccess(){
 global $configarray,$useridarray,$navboardlogin,$indpostarray,$userloggedinarray,$moderatorsarray,$login;

 $access=0;
 $indpostarray[0]=(float) $indpostarray[0];
 $useridarray[$navboardlogin]=(float) $useridarray[$navboardlogin];
 if(($useridarray[$navboardlogin]==$indpostarray[0]||$userloggedinarray[15]=="administrator"||@in_array("$useridarray[$navboardlogin]",$moderatorsarray))&&$login==1)
 {$access=1;}
 return $access;
}

function loginaccess($cookieset){
 global $banarray,$useridarray,$navboardlogin,$navboardpass,$rememberme,$configarray,$QUERY_STRING,$userloggedinarray;

 $navboardlogin==substr($navboardlogin,0,30);
 $navboardlogin==stripslashes($navboardlogin);
 $navboardlogin==htmlentities($navboardlogin);

 $navboardpass==stripslashes($navboardpass);
 $navboardpass==htmlentities($navboardpass);

 $userloggedinarray=getdata("$configarray[1]/$useridarray[$navboardlogin]/main.php");

   if(count($userloggedinarray)>0)
   {

    if(md5($navboardpass)==$userloggedinarray[1])
    {

     if($userloggedinarray[15]!=="confirm"&&$userloggedinarray[15]!=="approve")
     {

     $emailarray=explode("\t",$userloggedinarray[2]);
	
     if(!checkban($useridarray[$navboardlogin],$userloggedinarray[19],$emailarray[0],$userloggedinarray[15]))
     {
      $login=1;
      if($cookieset){
       if($rememberme=="on"){
        @setcookie("navboardlogin","$navboardlogin",time()+100000000);
        @setcookie("navboardpass","$navboardpass",time()+100000000);
       }else{
        @setcookie("navboardlogin","$navboardlogin");
        @setcookie("navboardpass","$navboardpass");
       }
      }
     }else{
      $login=3;
     }//ban check

    }else{
     $login=5;
    }//confirm check

    }else{
     $login=4;
    }//pass check

   }else{
    $login=2;
   }//exist check

return $login;
}

function bodyparse($body){
global $configarray,$indpostarray,$highlight;

 if($configarray[14]!=="allowhtml"){
 $body=htmlentities($body);
 }

 $body=smilies($body);
 $body=BBCode($body,"",$highlight);

 return $body;
}

function displaysmilies(){
global $configarray,$globalsmiliesarray,$globalbbcodearray;

 print "Clicky Smilies<br>";
 $smiliesarray=smiliesarray();

 for($n=0;$n<count($smiliesarray);$n++){
  $linearray=explode("\t",$smiliesarray[$n]);
  print "<a href=\"javascript:codeinsert('$linearray[0]')\"><img border=0 src=\"images/smilies/$linearray[1]\"></a>";
 }
}

function checkpmspace($user){
global $configarray;

 $pmlistarray=listfiles("$configarray[1]/$user/pms");
 @rsort($pmlistarray,SORT_NUMERIC);

 $total['size']=0;
 $total['number']=count($pmlistarray);
 $total['percentsize']=0;
 $total['percentnumber']=0;

 for($n=0;$n<count($pmlistarray);$n++){
  $total['size']+=filesize("$configarray[1]/$user/pms/$pmlistarray[$n].php");
 }

 if($total['size']>0){
  $total['percentsize']=round((($total['size']/$configarray[29])*100),1);
 }
 if($total['number']>0){
  $total['percentnumber']=round((($total['number']/$configarray[30])*100),1);
 }

return $total;
}

function checkdupdisplay($displayname){
global $usersarray,$user,$configarray,$mainfile,$alluserarray;

$dup=0;
if($configarray[32]!=="on"){

 for($n=0;$n<count($usersarray);$n++){
 $userarray=alluserarray($usersarray[$n]);
  if($displayname==$userarray[0]&&"$usersarray[$n]"!=="$user"){$dup=1;break 1;}
 }

}

return $dup;
}

function usersmenu($selected){
global $usersarray,$configarray,$mainfile,$alluserarray;

 @sort($usersarray);
 print "<option value=\"\"></option>";
  for($n=0;$n<count($usersarray);$n++){
   $userarray=alluserarray($usersarray[$n]);
   if("$selected"=="$usersarray[$n]"){
    print "<option value=\"$usersarray[$n]\" selected>$userarray[0]</option>";
   }else{
    print "<option value=\"$usersarray[$n]\">$userarray[0]</option>";
   }
  }
}

function mail2($contact,$subject,$message){
global $configarray,$alluserarray;

//if user 'contact' exists use their email otherwise use send it to 'contact'
$userarray=alluserarray($contact);
if(count($userarray)>0){
 $emailarray=explode("\t",$userarray[2]);
 $email=$emailarray[0];
}else{
 $email=$contact;
}

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: $configarray[0]\r\n";
$headers .= "To: $userarray[0]\r\n";

mail($email,$subject,$message,$headers);

}

function deleteuser($user){
global $configarray;
   $pmarray=listfiles("$configarray[1]/$user/pms");
    for($n=0;$n<count($pmarray);$n++){
     @unlink("$configarray[1]/$user/pms/$pmarray[$n].php");
    }
   @rmdir("$configarray[1]/$user/pms");
   $filesarray=listfilesext("$configarray[1]/$user");
   for($n=0;$n<count($filesarray);$n++){
    @unlink("$configarray[1]/$user/$filesarray[$n]");
   }
   @rmdir("$configarray[1]/$user");
   writedata("$configarray[1]/accounts.php","",$user);
}

function deletetopic($forum,$topictime){
global $configarray,$allforumconfigarray,$allpostarray,$alluserarray;

$postarray=allpostarray($forum,$topictime);
if($configarray[42]=="on"){
$forumconfigarray=allforumconfigarray($forum);
$forumconfigarray[11]-=(count($postarray)-1);
writedata("$configarray[2]/$forum.php",$forumconfigarray[11],11);
}

 for($n=0;$n<count($postarray);$n++){
  $indpostarray=getdata("$configarray[2]/$forum/$topictime/$postarray[$n].php");

  $userarray=alluserarray($indpostarray[0]);
  if(count($userarray)>0){
  $posts=$userarray[6]-1;
  writedata("$configarray[1]/$indpostarray[0]/main.php",$posts,6);
  }
	
  if($indpostarray[4]=="attachment"){
  @unlink("attachments/$indpostarray[5]");
  }

  @unlink("$configarray[2]/$forum/$topictime/$postarray[$n].php");
 }



 @unlink("$configarray[2]/$forum/$topictime.php");

 @rmdir("$configarray[2]/$forum/$topictime");

}

function deletepost($forum,$topictime,$post){
global $configarray,$allpostarray,$allforumconfigarray,$alluserarray;
$topicnum=topic_timetonum($forum,$topictime);
$postarray=allpostarray($forum,$topictime);
if($configarray[42]=="on"){
$forumconfigarray=allforumconfigarray($forum);
writedata("$configarray[2]/$forum.php",$forumconfigarray[11]-1,11);
}

$indpostarray=getdata("$configarray[2]/$forum/$topictime/$post.php");
$userarray=alluserarray($indpostarray[0]);

 if(count($userarray)>0){
  $posts=$userarray[6]-1;
  writedata("$configarray[1]/$indpostarray[0]/main.php",$posts,6);
 }

@unlink("$configarray[2]/$forum/$topictime/$post.php");
	
@rsort($postarray,SORT_NUMERIC);
if($post==$postarray[0]){
 $indpostarray2=getdata("$configarray[2]/$forum/$topictime/$postarray[1].php");
 @rename("$configarray[2]/$forum/$topictime","$configarray[2]/$forum/$indpostarray2[1]");
 @rename("$configarray[2]/$forum/$topictime.php","$configarray[2]/$forum/$indpostarray2[1].php");
 writedata("$configarray[2]/${forum}_topics.php",$indpostarray2[1],$topicnum);
}
@sort($postarray,SORT_NUMERIC);
}

function newestthread($forum){
global $configarray,$alltopicarray;

$threadarray=alltopicarray($forum);
@rsort($threadarray);
$newestimp=$threadarray[0];
$newestimptime=substr($threadarray[0],0,10);
if($newestimptime=="important_"){$newestimptime=substr($threadarray[0],10);}

for($l=0;$l<count($threadarray)&&substr($threadarray[$l],0,10)=="important_";$l++){}
$newest=$threadarray[$l];
$newesttime=$threadarray[$l];

if($newestimptime>$newesttime){$thread=$newestimp;}else{$thread=$newest;}

return $thread;
}

function checkban($username,$ip,$email,$group){
global $banarray;
$ban=0;

if((trim($group)&&$group=="banned")||(trim($username)&&@in_array($username,$banarray))||(trim($ip)&&@in_array($ip,$banarray))||(trim($email)&&@in_array($email,$banarray)))
{$ban=1;}

return $ban;
}

function topic_numtotime($forum,$topicnum){
global $configarray;

$topicidarray=getdata("$configarray[2]/${forum}_topics.php");
$topictime=$topicidarray[$topicnum];
 if($topictime){
  return $topictime;
 }else{
  return "0";
 }
}

function topic_timetonum($forum,$topictime){
global $configarray;

$topicconfigarray=getdata("$configarray[2]/$forum/$topictime.php");
$topicnum=$topicconfigarray[3];
return $topicnum;
}

######################
## DISPLAY POST ROW ##
######################
function displaypostrow($forum,$topictime,$post){
global $postarray,$configarray,$dateformat,$userloggedinarray,$theme,$topicnum,$userlevelsarray,$moderatorsarray,$topicarray,$topicconfigarray,$forumconfigarray,$firstpostarray,$showvoters,$vote,$useridarray,$login,$navboardlogin,$indpostarray,$highlight,$alluserarray,$globalsmiliesarray,$globalbbcodearray,$theme_images;
$indpostarray=getdata("$configarray[2]/$forum/$topictime/$post.php");

 print "<tr>\n";
 print "<td width=\"20%\" valign=\"top\" class=\"tablecell2\">\n";
 print "<span class=\"textlarge\">";
 $userarray=alluserarray($indpostarray[0]);

  if(count($userarray)>0){
   print "<span class=\"textlarge\">";
   print "<b>$userarray[0]</b><br>\n";
   print "</span><span class=\"textsmall\">";
   print "$userarray[16]<br>\n";

   if($userarray[7]) {
    if(eregi("http://(.+)",$userarray[7])){
	 print "<img src=\"$userarray[7]\">";
	}else{
     print "<img src=\"avatars/$userarray[7]\">";
	}
	print "<br>";
	
   }else{
    print "<br><br><br><br><br><br>";
   }
   print "<b>".ucfirst($userarray[15])."</b><br>";
   if(count($userlevelsarray)>0){
    for($p=1;$p<count($userlevelsarray);$p+=2){
     if($userlevelsarray[$p]>$userarray[6]){break 1;}
    }

    if($configarray[45]=="on"){
     print "Level: ".$userlevelsarray[$p-3]."<br>";
    }else{
     for($n=0;$n<((($p-3)/2)+1);$n++){
      print "<img src=\"images/$theme_images/userlevel.gif\">&nbsp;";
     }
     echo '<br>';
    }
   }

   print "Posts: $userarray[6]<br>";
   print "</span>";
  }else{
   print "<span class=\"textlarge\">";
   print "<b>Guest ($indpostarray[0])</b><br>\n";
   print "</span>";
  }

 print "</td>";

 print "<td width=\"80%\" valign=\"top\" class=\"tablecell1\">";
 print "<span class=\"textsmall\">";

 $indpostarray[2]=htmlentities($indpostarray[2]);

 print "<b>";
  if(substr($topictime,0,10)=="important_"){
  print "Important: ";
  }

  if($indpostarray[4]=="poll"){
   print "Poll: ";
  }

 print "<a name=\"post".($post+1)."\">$indpostarray[2]</a>";
 print "</b><br><br>\n";
 print "</span>";
 print "<span class=\"textlarge\">";

########### START POLL STUFF #################
  if($indpostarray[4]=="poll"){
   $pollitems=explode("\t",$indpostarray[5]);
   $pollvotes=explode(",",$indpostarray[6]);
   if($indpostarray[7]){$pollvoters=explode(",",$indpostarray[7]);}

 	print "<span class=\"textsmall\">";
    if($showvoters==1){
	print "Who voted: ";
     for($m=0;$m<count($pollvoters);$m++){
      $userarray2=alluserarray($pollvoters[$m]);
	  if($pollvoters[$m]){
       if(count($userarray2)>0){
       print "<a href=\"profile.php?user=$pollvoters[$m]\">$userarray2[0]</a>";
       }else{
       print "Guest ($pollvoters[$m])";
       }
       if($m<count($pollvoters)-1){print ", ";}
	  }
     }
    }else{
    print "<a href=\"index.php?forum=$forum&topic=$topicnum&poststart=$poststart&showvoters=1\">Who voted</a>";	
    }
    print "<br>";
    print "</span>";

   if($login==1&&!@in_array($useridarray[$navboardlogin],$pollvoters)){

    if(isset($vote)){
    $pollvotes[($vote-1)]+=1;
    $pollvoters[]=$useridarray[$navboardlogin];

    $pollvotesline=implode(",",$pollvotes);
    $pollvotersline=implode(",",$pollvoters);

    writedata("$configarray[2]/$forum/$topictime/0.php",$pollvotesline,6);
    writedata("$configarray[2]/$forum/$topictime/0.php",$pollvotersline,7);

    print "<table border=0 cellspacing=0 cellpadding=4 width=\"60%\" class=\"table\">";
    print "<tr>\n";
    print "<td class=\"tablecell2\">\n";
    print "<span class=\"textlarge\">";
	  print "Your vote has been added...auto refreshing <a href=\"index.php?forum=$forum&topic=$topicnum&poststart=0\">thread</a> to see results";
    print "<meta http-equiv=\"refresh\" content=\"0; url=index.php?forum=$forum&topic=$topicnum&poststart=0\">";
    print "</span>";
    print "</td>";
    print "</tr>";
    print "</table>";

    }else{
    print "<table border=0 cellspacing=0 cellpadding=4 width=\"60%\" class=\"table\">";
    print "<form action=\"index.php\" method=get>";
    print "<input type=hidden value=\"$forum\" name=\"forum\">";
    print "<input type=hidden value=\"$topicnum\" name=\"topic\">";

    for($m=0;$m<count($pollitems);$m++){
     print "<tr>\n";
     print "<td class=\"tablecell2\" width=\"99%\">\n";
     print "<span class=\"textlarge\">";
     print "$pollitems[$m]";
     print "</span>";
     print "</td>";

     print "<td class=\"tablecell2\" width=\"1%\">\n";
     print "<span class=\"textlarge\">";
     print "<input type=radio value=\"".($m+1)."\" name=\"vote\" class=\"forminput\">";
     print "</span>";
     print "</td>";
     print "</tr>";
    }

    print "<tr>\n";
    print "<td class=\"tablecell2\" colspan=2>\n";
    print "<input type=submit value=\"Vote\" class=\"forminput\">";
    print "</td>";
    print "</tr>";
    print "</form>";
    print "</table>";
    print "<br>";
    }

   }else{
    print "<table border=0 cellspacing=0 cellpadding=4 width=\"70%\" class=\"table\">";

    $totalvotes=0;
    for($m=0;$m<count($pollitems);$m++){
     $totalvotes=$totalvotes+$pollvotes[$m];
    }

    for($m=0;$m<count($pollitems);$m++){
    print "<tr>\n";
    print "<td class=\"tablecell2\" width=\"50%\">\n";
    print "<span class=\"textlarge\">";
    print "$pollitems[$m]";
    print "</span>";
    print "</td>";
	
    $width = ($pollvotes[$m]/$totalvotes)*100;
	  if($width<1){$width=1;}
	  if($width>99){$width=99;}
    print "<td class=\"tablecell1\" width=\"30%\">\n";

    print "<table width=\"$width%\" height=10 border=0 cellpadding=0 cellspacing=0>";
    print "<tr>";
    print "<td class=\"tablecell2=\">";
    print "<img src=\"images/${theme_images}/poll_left.gif\" border=0>";

    print "</td>";
    print "<td height=10 width=\"100%\" background=\"images/${theme_images}/poll_mid.gif\">";

    print "</td>";

    print "<td>";
    print "<img src=\"images/${theme_images}/poll_right.gif\" border=0>";
    print "</td>";
    print "</tr>";
    print "</table>";
	
	  print "</td>";

    print "<td class=\"tablecell2\" width=\"20%\">\n";
    print "<span class=\"textlarge\">";
	
      if($totalvotes>0){
      print round(($pollvotes[$m]/$totalvotes)*100,1)."%";
      }else{
      print "0%";
      }

      if($pollvotes[$m]>0){
      print " ($pollvotes[$m])";
      }else{
      print " (0)";
      }
    print "</span>";
    print "</td>";
    print "</tr>";
    }//item loop

    print "</table>";
   }

  print "<br>";

  }
############# END POLL STUFF#################

 $body=bodyparse($indpostarray[3]);

 print "$body<br>\n";

 print "<span class=\"textsmall\">";
 if($indpostarray[4]=="attachment"&&file_exists("attachments/$indpostarray[5]")){
 print "<br>";
 print "Attachment: <a href=\"attachments/$indpostarray[5]\">$indpostarray[5]</a>";
 print "<br>";
 }
 print "<br>";
 if($indpostarray[11]){
  $editarray=explode(",",$indpostarray[11]);
  if($configarray[46]!=="on"){
   $lastedit=count($editarray)-2;
   $userarray=alluserarray($editarray[$lastedit]);
   print "Last edited by <b><a href=\"profile.php?user=$editarray[$lastedit]\">$userarray[0]</a></b> on ".date($dateformat,$editarray[$lastedit+1])."<br>";
  }else{
  for($n=0;$n<count($editarray);$n+=2){
   $userarray=alluserarray($editarray[$n]);
   print "Edited by <b>userarray[0]</b> on ".date($dateformat,$editarray[$n+1])."<br>";
  }
  }//only show last edit check
 }
 print "</span>";

 if($userarray[3]){
 print "<span class=\"textlarge\">";
 print "____________________<br>\n";
 $userarray[3]=BBCode($userarray[3],"1");
 print "$userarray[3]<br><br>\n";
 print "</span>";
 }
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\">\n";
 print "<span class=\"textsmall\">";
 $date=date($dateformat,$indpostarray[1]);
 print "$date\n";
 print "</span>";
 print "</td>\n";
 print "<td class=\"tablecell2\" valign=\"center\">";

 $postnumber=$post+1;

 print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"left\">\n";

 print "<tr>";

 if(geteditaccess()&&getforumaccess("edit")&&$topicconfigarray[0]!=="closed"){
 print "<td>";
 echo template("tablebutton","<a href=\"post.php?forum=$forum&topic=$topicnum&post=$postnumber&mode=edit&page=$page\" title=\"Edit this post\" alt=\"Edit this post\">Edit</a>");
 print "</td>";
 }

 if(getforumaccess("reply")){
 print "<td>";
 echo template("tablebutton","<a href=\"post.php?forum=$forum&topic=$topicnum&post=$postnumber&mode=quote\" title=\"Quote this post\" alt=\"Quote this post\">Quote</a>");
 print "</td>";
 }

 $userarray=alluserarray($indpostarray[0]);

 if(count($userarray)>0){
 print "<td>";
 echo template("tablebutton","<a href=\"profile.php?user=$indpostarray[0]\" title=\"View users profile\" alt=\"View users profile\">Profile</a>");
 print "</td>";
 }

 if($userarray[9]) {
 print "<td>";
 echo template("tablebutton","<a href=\"$userarray[9]\" title=\"Goto users website\" alt=\"Goto users website\" target=\"_new\">Website</a>");
 print "</td>";
 }

 if(count($userarray)>0&&$login==1){
 print "<td>";
 echo template("tablebutton","<a href=\"user_pm.php?selected=$indpostarray[0]&mode=send\" title=\"Send PM to this user\" alt=\"Send PM to this user\">Send PM</a>");
 print "</td>";
 }


 if($userloggedinarray[15]=="administrator"){
 print "<td valign=\"center\">";
 print "<span class=\"textsmall\">";
 print "&nbsp;&nbsp;&nbsp;&nbsp; IP Logged:";
 print " $indpostarray[9]";
 print "&nbsp;&nbsp;&nbsp;";
 print "<a href=\"admin_users.php?ban=$indpostarray[9]\">Ban IP</a>";
 print "</span>";
 print "</td>";
 }

 print "</tr>";
 print "</table>";



 print "</td>\n";
 print "</tr>\n";
}

function sendpm($sendto,$user,$subject,$body){
global $configarray;

   $body=ereg_replace("\n","",$body);
   $body=ereg_replace("\r","[br]",$body);
   $body=stripslashes($body);

   $subject=ereg_replace("\n","",$subject);
   $subject=ereg_replace("\r","",$subject);
   $subject=stripslashes($subject);

   $total=checkpmspace($sendto);

   if($total['percentsize']>=100||$total['percentnumber']>=100){
    print "The selected user does not have enough space to store your pm, sorry";
   }else{

   if(trim($subject)&&trim($body)&&$sendto){
   $userpms=listfiles("$configarray[1]/$sendto/pms");
   @rsort($userpms,SORT_NUMERIC);
   $end=$userpms[0]+1;
   $time=time();

   createdir("$configarray[1]/$sendto/pms");

   writedata("$configarray[1]/$sendto/pms/$end.php",$user,0);
   writedata("$configarray[1]/$sendto/pms/$end.php",$time,1);
   writedata("$configarray[1]/$sendto/pms/$end.php",$subject,2);
   writedata("$configarray[1]/$sendto/pms/$end.php",$body,3);
   writedata("$configarray[1]/$sendto/pms/$end.php","unread",8);

    print "Private message sent";
   }else{
    print "Message must have send to, subject, body all filled out";
   }//fields check

  }//space check

}

function alluserarray($user){
global $alluserarray,$configarray;

 if(isset($alluserarray[$user])){
 $userarray=$alluserarray[$user];
 }else{
 $alluserarray[$user]=getdata("$configarray[1]/$user/main.php");
  if(count($alluserarray[$user])<1){$alluserarray[$user]=array();}
 $userarray=$alluserarray[$user];
 }

return $userarray;
}

function allforumconfigarray($forum){
global $allforumconfigarray,$configarray;

 if(isset($allforumconfigarray[$forum])){
 $forumconfigarray=$allforumconfigarray[$forum];
 }else{
 $allforumconfigarray[$forum]=getdata("$configarray[2]/$forum.php");
  if(count($allforumconfigarray[$forum])<1){$allforumconfigarray[$forum]=array();}
 $forumconfigarray=$allforumconfigarray[$forum];
 }

return $forumconfigarray;
}

function alltopicarray($forum){
global $alltopicarray,$configarray;

 if(isset($alltopicarray[$forum])){
 $topicarray=$alltopicarray[$forum];
 }else{
 $alltopicarray[$forum]=listdirs("$configarray[2]/$forum");
  if(count($alltopicarray[$forum])<1){$alltopicarray[$forum]=array();}
 $topicarray=$alltopicarray[$forum];
 }

return $topicarray;
}

function allpostarray($forum,$topictime){
global $allpostarray,$configarray;

 if(isset($allpostarray[$forum][$topictime])){
 $postarray=$allpostarray[$forum][$topictime];
 }else{
 $allpostarray[$forum][$topictime]=listfiles("$configarray[2]/$forum/$topictime");
  if(count($allpostarray[$forum][$topictime])<1){$allpostarray[$forum][$topictime]=array();}
 $postarray=$allpostarray[$forum][$topictime];
 }

return $postarray;
}

function bbcodearray(){
global $globalbbcodearray,$configarray;

 if(isset($globalbbcodearray)){
  $bbcodearray=$globalbbcodearray;
 }else{
  $globalbbcodearray=$bbcodearray=getdata("$configarray[5]/bbcode.php");
   if(count($globalbbcodearray)<1){$globalbbcodearray=array();}
  $bbcodearray=$globalbbcodearray;
 }

return $bbcodearray;
}

function smiliesarray(){
global $globalsmiliesarray,$configarray;

 if(isset($globalsmiliesarray)){
  $smiliesarray=$globalsmiliesarray;
 }else{
  $globalsmiliesarray=$smiliesarray=getdata("$configarray[5]/smilies.php");
   if(count($globalsmiliesarray)<1){$globalsmiliesarray=array();}
  $smiliesarray=$globalsmiliesarray;
 }

return $smiliesarray;
}

function template($templatename,$content=""){
global $theme,$alltemplates,$replacements,$theme_templates,$theme_replacements;
 if($alltemplates[$templatename]){
  $template=$alltemplates[$templatename];
 }else{
  if(!@include("templates/${theme_templates}/$templatename.php")){
   $templatesetarray=listdirs("templates");
   include("templates/${templatesetarray[0]}/$templatename.php");
  }
  if(!count($replacements)>0){
   if(!@include("replacements/${theme_replacements}/replacements.php")){
    $replacementsetarray=listdirs("replacements");
    include("replacements/${replacementsetarray[0]}/replacements.php");
   }
  }
  $template=strtr($template,$replacements);
  $template=addslashes($template);
  $alltemplates[$templatename]=$template;
 }
 eval("\$template=\"$template\";");
 return $template;
}

?>
