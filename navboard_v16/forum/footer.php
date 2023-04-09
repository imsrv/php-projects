<?php

unset($footer);
$inactivitymin=$configarray[13]/60;
$onlinearray=getdata("$configarray[1]/online.php");
$onlineguestcount=0;
$onlineusercount=0;
$count=count($onlinearray);

 //find old entries and delete
 for($n=0;$n<$count;$n++){

 if(substr($onlinearray[$n],0,5)=="Guest"){//its a guest
 $time=time();

  //if guest last activity is less than '$configarray[13]' seconds ago
  if(($time-$configarray[13])<substr($onlinearray[$n+1],5)){
   $onlineguestcount++;
   $n++;
  }else{
   deletedata("$configarray[1]/online.php",$n);
   deletedata("$configarray[1]/online.php",$n);
   $onlinearray=getdata("$configarray[1]/online.php");
   $count=count($onlinearray);
   $n--;
  }

 }else{ //its a user
 $userarray=getdata("$configarray[1]/$onlinearray[$n]/main.php");
 $lastloginarray=explode("\t",$userarray[5]);
 $time=time();

  //if user last activity is less than '$configarray[13]' seconds ago
  if(($time-$configarray[13])<$lastloginarray[1]){
   $onlineusercount++;
   if($userarray[15]=="administrator"){
   $onlineusers=$onlineusers . "<a href=\"profile.php?user=$onlinearray[$n]\"><b>$userarray[0]</b></a>&nbsp&nbsp";
   }else{
   $onlineusers=$onlineusers . "<a href=\"profile.php?user=$onlinearray[$n]\">$userarray[0]</a>&nbsp&nbsp";
   }
  }else{
   deletedata("$configarray[1]/online.php",$n);
   $n-=1;
  }

 }

 }//end online loop

$onlinetotal=$onlineguestcount+$onlineusercount;
$footer['online']="$onlinetotal online in last $inactivitymin min > $onlineguestcount Guests, $onlineusercount Members";
if($onlineusers!==""){$footer['online'].=" $onlineusers";}

if($login==1&&$userloggedinoptarray[0]!=="on"){

$pmsarray=listfiles("$configarray[1]/$useridarray[$navboardlogin]/pms");
 for($n=0;$n<count($pmsarray);$n++){
  $pmarray=getdata("$configarray[1]/$useridarray[$navboardlogin]/pms/$pmsarray[$n].php");
  if($pmarray[8]=="unread"){$newpms=1;break 1;}
 }

 if($newpms==1){
 $footer['newpms']="New messages in your <a href=\"user_pm.php\">inbox</a>!";
 }
}


$footer['navigation']="<p><form action=\"index.php\" method=get>".
"Navigation:".
"<select size=1 onchange=\"window.location=(this.options[this.selectedIndex].value)\" class=\"forminput\">".
"<option value=\"\"></option>".

"<option value=\"index.php\">Forum home</option>".
"<option value=\"register.php\">Register</option>";
if($login==1){
$footer['navigation'].="<option value=\"\">--------------</option>".
"<option value=\"user_edit.php\">User CP</option>".
"<option value=\"user_pm.php\">PMs</option>".
"<option value=\"user_buddy.php\">Buddy List</option>";
}
$footer['navigation'].="<option value=\"\">--------------</option>";

for($n=0;$n<count($modulesarray);$n++){
$footer['navigation'].="<option value=\"modules.php?module=$modulesarray[$n]\">$modulesarray[$n]</option>";
}
$footer['navigation'].="<option value=\"\">--------------</option>";

function forumsfootermenu($parentforum,$level){
global $configarray,$forumlist,$allforumarray,$footer;
  if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   for($m=0;$m<count($forumsublist);$m++){
    $forumconfigarray=allforumconfigarray($forumsublist[$m]);
	  if(getforumaccess("show",$forumsublist[$m])&&$level<$configarray[27]){
     $footer['navigation'].="<option value=\"index.php?forum=$forumsublist[$m]\">";
	
	   for($l=0;$l<$level;$l++){
     $footer['navigation'].=">";
     }
	
     $footer['navigation'].=" $forumconfigarray[3]</option>";
	 forumsfootermenu($forumsublist[$m],$level+1,$selected);
	 }//access/level test
  }//loop
}

forumsfootermenu("0",0);

$footer['navigation'].="</select>".
"</form></p>";

if($login>1){
   $loginerror=array("","","No such user","You are banned","Invalid password","Account not activated");
   $footer['login'].="<i>$loginerror[$login]</i>";
 }

 if($login==1){
   $footer['login'].="Logged in with account <b>$navboardlogin</b> display as <b>$userloggedinarray[0]</b> ".
   "</td><td>".
   template("tablebutton","<a href=index.php?logout=1>Logout</a>").
   "</td>";
 }

 if($login!==1){
   $footer['login'].="<p><form action=\"index.php\" method=post>";
   $footer['login'].="Username: ".
   "<input type=text name=\"navboardlogin2\" size=10 class=\"forminput\"> ".
   "Password: ".
   "<input type=password name=\"navboardpass2\" size=10 class=\"forminput\">".
   "<input type=hidden name=\"loggingin\" value=1>".
   " Remember me: ".
   "<input type=checkbox name=\"rememberme\" class=\"forminput\"> ".
   "<input type=submit name=\"submit\" value=\"Login!\" class=\"formbutton\">".
   "</form></p>";
 }

$footer['credits']="<a href=\"http://navarone.f2o.org\">".
"NavBoard</a>".
" 2.6.0<br>".
"by bryan986 &copy; 2002-2003";


$footer['contact']="< ";
if($configarray[35]){
$footer['contact'].="<a href=\"mailto:$configarray[35]\">".
"Contact".
"</a> ".
"-";
}
$footer['contact'].=" <a href=\"$configarray[36]\">".
"Homepage".
"</a>".
" >";

//START FOOTER STATS

if($userloggedinoptarray[2]!=="on"){
//TOTAL POST COUNT START

 for($m=0;$m<count($forumarray);$m++){
  $forumconfigarray=allforumconfigarray($forumarray[$m]);

  if($forumconfigarray[5]!=="category"){//dont scan categories
  $topicarray=alltopicarray($forumarray[$m]);
  $totaltopics+=count($topicarray);

  if($configarray[42]=="on"){
  $totalposts+=$forumconfigarray[11];
  }else{
    for($n=0;$n<count($topicarray);$n++){
     $postarray=allpostarray($forumarray[$m],$topicarray[$n]);
     $totalposts+=count($postarray)-1;
    }
  }//real time disable check
  }//dont scan categories check
 }//forum loop
//END TOTALPOSTCOUNT
$totaloverallposts=$totaltopics+$totalposts;
}

$totalusers=count($usersarray);

if(count($usersarray)>0){
 @rsort($usersarray);
 $userarray=alluserarray($usersarray[0]);
 $footer['stats']="Newest member: <a href=\"profile.php?user=$usersarray[0]\">$userarray[0]</a>";
}else{
 $footer['stats']="Newest member: None";
}

$footer['stats'].=", Members: $totalusers<br>";

if($userloggedinoptarray[2]!=="on"){
$footer['stats'].="Threads: $totaltopics, Replies: $totalposts, Total: $totaloverallposts";
}
//END FOOTER STATS

//end footer vars

print template("footer",$footer);

print "</td>";
print "</tr>";

print "</table>";

print "</body>\n";
print "</html>\n";

$time_portions = explode(' ', microtime());
$end_time = $time_portions[1] . substr($time_portions[0], 1);
$elapsed_time =$end_time - $start_time;
$shift = pow(10, 3);
$exectime=((floor($elapsed_time * $shift)) / $shift);

print "<span class=\"textsmall\">";
print "<p align=center>";
print "[ Exec time: ".$exectime." | Files queried: ${filesopened} | Dirs queried: ${dirsread} | File writes: $filewrites ]";
print "</p>";
print "</span>";

if($configarray[21]!=="disablegz"){
@ob_end_flush();
}

?>
