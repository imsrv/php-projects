<?php
include ("global.php");

if($configarray[40]){
 $links=" > User controls";
 $pagetitle=" - User controls";
 include("header.php");
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table>";
}else{

if(!$user){$user=$useridarray[$navboardlogin];}

$user=(float) $user;
$useridarray[$navboardlogin]=(float) $useridarray[$navboardlogin];

//not logged in || not own profile and not admin || not own profile
if(($user!==$useridarray[$navboardlogin])&&($userloggedinarray[15]!=="administrator")||$login!==1){
 $links=" > User controls";
 $pagetitle=" - User controls";

 include("header.php");
 include("user_header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "You do not have access to the users controls";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

}else{

$userarray=getdata("$configarray[1]/$user/main.php");

$links=" > User controls > $userarray[0]";
$pagetitle=" - User controls - $userarray[0]";

include("header.php");
include("user_header.php");

 //update account
 if($update==1){

  tableheader1();

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<p align=\"left\">";
  print "<span class=\"textlarge\">";

  writedata("$configarray[1]/$user/options.php",$turnoffautocheckpms,0);
  writedata("$configarray[1]/$user/options.php",$turnofficonguide,1);
  writedata("$configarray[1]/$user/options.php",$turnoffpoststats,2);
  if($onlinelistname=="on"){
   $onlinearray=getdata("$configarray[1]/online.php");
   for($n=0;$n<count($onlinearray);$n++){
    if($onlinearray[$n]==$user){
	deletedata("$configarray[1]/online.php",$n);
	}
   }
  }
  writedata("$configarray[1]/$user/options.php",$onlinelistname,3);

  print "User options updated!<br>Changes will be seen on next page you load";

  print "</span>";
  print "</p>";
  print "</td>";
  print "</tr>";
  print "</table>";

 }else{

  $useroptarray=getdata("$configarray[1]/$user/options.php");

  print "<form action=\"user_options.php\" method=post>";
  print "<input type=hidden name=\"update\" value=\"1\">";
  print "<input type=hidden name=\"user\" value=\"$user\">";
  print "<input type=hidden name=\"mode\" value=\"edit\">";

  tableheader1();

  print "<tr>";
  print "<td class=\"tableheadercell\" colspan=\"2\">";
  print "<span class=\"textheader\"><b>Standard Options</b></span>";
  print "</td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\" width=\"50%\">";
  print "<span class=\"textlarge\">Turn off auto check for private messages on every page</span><br>";
  print "</td><td class=\"tablecell2\" width=\"50%\">";
  if($useroptarray[0]=="on"){
  print "<input type=checkbox name=\"autocheckpms\" class=\"forminput\" checked>";
  }else{
  print "<input type=checkbox name=\"autocheckpms\" class=\"forminput\">";
  }
  print "</td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Turn off forum/thread icon guide on bottom of pages</span><br>";
  print "</td><td class=\"tablecell2\">";
  if($useroptarray[1]=="on"){
  print "<input type=checkbox name=\"turnofficonguide\" class=\"forminput\" checked>";
  }else{
  print "<input type=checkbox name=\"turnofficonguide\" class=\"forminput\">";
  }
  print "</td>";
  print "</tr>";
  
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Turn off post stats on footer to increase speed of page loads</span><br>";
  print "</td><td class=\"tablecell2\">";
  if($useroptarray[2]=="on"){
  print "<input type=checkbox name=\"turnoffpoststats\" class=\"forminput\" checked>";
  }else{
  print "<input type=checkbox name=\"turnoffpoststats\" class=\"forminput\">";
  }
  print "</td>";
  print "</tr>";
  
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Don't show your name in online list (invisible mode)</span><br>";
  print "</td><td class=\"tablecell2\">";
  if($useroptarray[3]=="on"){
  print "<input type=checkbox name=\"onlinelistname\" class=\"forminput\" checked>";
  }else{
  print "<input type=checkbox name=\"onlinelistname\" class=\"forminput\">";
  }
  print "</td>";
  print "</tr>";

  print "</table>";
  
  print "<br>";

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\" colspan=\"2\">";
  print "<p>";
  print "<input type=submit name=\"submit\" value=\"Update!\" class=\"formbutton\">";
  print "</form>";
  print "</p>";

  print "</td>";
  print "</tr>";
  print "</table>";

 }//update check

}//access check

}

print "<br>";
tableheader1();

require ("footer.php");
?>
