<?php

@error_reporting(7);
@ini_set("display_errors","1");
@ini_set("register_globals","1");
@ini_set("magic_quotes_gpc","1");
@ini_set("file_uploads","1");
@ini_set("disable_functions","");
@ini_set("open_basedir","");
@ini_set("allow_url_fopen","1");
@ini_set("safe_mode","0");
@ini_set("session.auto_start","0");
@ini_set("session.use_trans_sid","0");

foreach($HTTP_GET_VARS as $key => $val) $$key=$val;
foreach($HTTP_POST_VARS as $key => $val) $$key=$val;
foreach($HTTP_COOKIE_VARS as $key => $val) $$key=$val;

$time_portions = explode(' ', microtime());
$start_time = $time_portions[1] . substr($time_portions[0], 1);

//php1,php2,or php3, see documentation for differences, php1 recommended
//MUST leave variable here (for conversion scripts)
$filesystem="php1";
include ("file_functions_${filesystem}.php");
include ("functions.php");

$maindatadir="data";
createdir("$maindatadir");
$configarray=getdata("$maindatadir/config.php");
if(!$configarray[0]){$configarray[0]="NavBoard";}
if(!$configarray[1]){$configarray[1]="$maindatadir/users";}
if(!$configarray[2]){$configarray[2]="$maindatadir/forum";}
if(!$configarray[5]){$configarray[5]="$maindatadir";}
if(!$configarray[7]){$configarray[7]="20";}
if(!$configarray[8]){$configarray[8]="20";}
if(!$configarray[9]){$configarray[9]="90000";}
if(!$configarray[10]){$configarray[10]="100x100";}
if(!$configarray[13]){$configarray[13]="300";}
if(!$configarray[18]){$configarray[18]="15000";}
if(!$configarray[19]){$configarray[19]="800";}
if(!$configarray[20]){$configarray[20]="$maindatadir/modules";}
if(!$configarray[22]){$configarray[22]="zip,ace,rar,txt,jpg,jpeg,png,bmp,gif,gz,tar";}
if(!$configarray[23]){$configarray[23]="500000";}
if(!$configarray[24]){$configarray[24]="5";}
if(!$configarray[25]){$configarray[25]="50";}
if(!$configarray[27]){$configarray[27]="10";}
if(!$configarray[28]){$configarray[28]="10";}
if(!$configarray[29]){$configarray[29]="50000";}
if(!$configarray[30]){$configarray[30]="40";}
if(!$configarray[31]){$configarray[31]="1000000";}
if(!$configarray[33]){$configarray[33]="n-j-Y h:iA";}
if(!$configarray[37]){$configarray[37]="30";}
if(!$configarray[38]){$configarray[38]="60";}
if(!$configarray[43]){$configarray[43]="3";}
if(!isset($configarray[44])){$configarray[44]="5";}

createdir("$configarray[1]");
createdir("$configarray[2]");
createdir("avatars");
createdir("attachments");
createdir("$configarray[20]");

//data arrays
$userkeyarray=getdata("$configarray[1]/accounts.php");
$useridarray=@array_flip($userkeyarray);
$forumarray=listdirs("$configarray[2]"); @sort($forumarray,SORT_NUMERIC);
$forumlist=getdata("$configarray[2]/list.php");
$usersarray=listdirs("$configarray[1]"); @sort($usersarray,SORT_NUMERIC);
$banarray=getdata("$configarray[1]/ban.php");

//gz compression
if($configarray[21]!=="disablegz"){@ob_start("ob_gzhandler");}

//START LOGIN CHECK///////////

if($navboardlogin&&$navboardpass){//already logged in, rechecking
 $login=loginaccess("0");
}
if($navboardlogin2&&$navboardpass2){//new login
 $navboardlogin=$navboardlogin2;
 $navboardpass=$navboardpass2;
 $login=loginaccess("1");
}

//LOGOUT
if(($logout==1&&$login==1)||$login!==1){
 @setcookie("navboardlogin","",time()-3600);
 @setcookie("navboardpass","",time()-3600);
 unset($navboardlogin);
 unset($loggingin);
  if($login==1){
   $login=0;
  }
}

unset($navboardpass);
unset($navboardpass2);
unset($navboardlogin2);

if($login==1){
$userloggedinoptarray=getdata("$configarray[1]/$useridarray[$navboardlogin]/options.php");
}
//////END LOGIN CHECK////

//set up some dummy data for guests
if($login!==1){
 $userloggedinarray[5]="1	1";
 $userloggedinarray[17]="";
 $userloggedinarray[15]="guest";
 $useridarray[""]=0;
 $useridarray[" "]=0;
}

//start session stuff
if($navboardsess){ //if there is a sess stored in the cookie
 $sess=$navboardsess;
}else{ //no sess stored in cookie so make a new sess and store in the cookie
 $sess=md5(uniqid(microtime()));
 @setcookie("navboardsess","$sess");
}

/////##!DO NOT DISPLAY DATA TO USER BEFORE THIS POINT! (WILL MESS UP COOKIES) ##///////

if($login==1){

 //current sess different than stored sess
 if($userloggedinarray[20]!==$sess){
  writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$sess,20);
  $time=time();
  $lastloginarray=explode("\t",$userloggedinarray[5]);
  writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php","$lastloginarray[1]\t$time",5);
  writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$REMOTE_ADDR,19);
 }else{ //current sess same as stored sess
  $time=time();
  $lastloginarray=explode("\t",$userloggedinarray[5]);
  writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php","$lastloginarray[0]\t$time",5);
 }

 $userlocation=substr($REQUEST_URI,strrpos($REQUEST_URI,"/")+1);;
 if($userloggedinarray[22]!==$userlocation){
  writedata("$configarray[1]/$useridarray[$navboardlogin]/main.php",$userlocation,22);
 }

}

//end sess stuff

//start online users stuff
$onlinearray=getdata("$configarray[1]/online.php");
$count=count($onlinearray);

if($login==1){//user
  if(!@in_array($useridarray[$navboardlogin],$onlinearray)&&$userloggedinoptarray[3]!=="on"){
  writedata("$configarray[1]/online.php","$useridarray[$navboardlogin]",$count);
  }
}else{//guest
  $time=time();
  if(!@in_array("Guest".$sess,$onlinearray)){
  writedata("$configarray[1]/online.php","Guest$sess",$count);
  writedata("$configarray[1]/online.php","Guest$time",$count+1);
  }
}
//end online users stuff

if($userloggedinarray[21]){$dateformat=$userloggedinarray[21];}else{$dateformat=$configarray[33];}

//theme
$themesarray=listdirs("themes");
if($userloggedinarray[17]&&@in_array($userloggedinarray[17],$themesarray)){
 $theme=$userloggedinarray[17];
}elseif($configarray[12]&&@in_array($configarray[12],$themesarray)){
 $theme=$configarray[12];
}elseif($themesarray[0]){
 $theme=$themesarray[0];
}else{
 die("<font color=red>NavBoard Error: There are no themes available</font>");
}

include("themes/$theme/config.php");
include("themes/$theme/functions.php");

?>
