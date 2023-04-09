<?php

include("global.php");

$pagetitle=" - Administration - News";
$links=" > Administration > News";

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

 if(!$editinfolocation){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";

 if(!$configarray[26]){$configarray[26]="http://navarone.f2o.org/info/navboard.txt";}

 if(ini_get("allow_url_fopen")){
 
 $infoarray=getdata("$configarray[26]");

 if(count($infoarray)>0){

  for($n=0;$n<count($infoarray);$n++){
   print "$infoarray[$n]<br>";
  }

 }else{
  print "NavBoard was unable to get info or there was no info, double check address below<br>";
 }

 }else{
  print "<b>Info cannot be received on this server because allow_url_fopen is off in php ini!</b><br>";
 }
 
 print "<br>================<br>";

 print "<form action=\"admin_news.php\" method=post>";
 print "<input type=hidden name=\"editinfolocation\" value=\"1\" size=40>";

 print "URL address to get info from, check official site if you need address<br>";
 print "<input type=text name=\"infolocation\" value=\"$configarray[26]\" size=40 class=\"forminput\"><br>";
 print "<br><br>";

 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";

 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if($editinfolocation){
 writedata("$maindatadir/config.php",$infolocation,26);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Info location updated!";
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
