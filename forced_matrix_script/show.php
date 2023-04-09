<?
/* nulled by [GTT] :) */    
include("functions.php");
db_connect();
$defaff=db_result_to_array("select defurl, affdir from admininfo");
$defurl="http://";
$defurl=$defurl.$defaff[0][0];
if (@$stp&&($stp!=0)) {$url=db_result_to_array("select url from startpages where id='$stp'"); $url=$url[0][0];}
if ($affid)
 {
  if($adid)
  {
   $ad=db_result_to_array("select imgsrc, text from banners where id='$adid'");
   $usclicks=db_result_to_array("select banclicks, textclicks name from users where id='$affid'");
   if ($ad[0][0]) $usclicks[0][0]++; else $usclicks[0][1]++;
    mysql_query("update users set banclicks='".$usclicks[0][0]."', textclicks='".$usclicks[0][1]."' where id='$affid'");
  }
   $cookex=db_result_to_array("select cookex from admininfo");
   $cookex=$cookex[0][0];
   setcookie("refid", $affid, time() + 60*60*24*$cookex, "", "");
  }
if (@$adtr) {$clicks=db_result_to_array("select clicks, name from grpsnclicks where id='$adtr'");
  $clicks[0][0]++;
  mysql_query("update grpsnclicks set clicks='".$clicks[0][0]."' where id='$adtr'");}
if (@$url) header("Location:$url"); else header("Location:$defurl");
?>