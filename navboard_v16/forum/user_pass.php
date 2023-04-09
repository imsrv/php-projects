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
 print "You do not have access to this users controls!";
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

  if(md5($currentpass)==$userarray[1]){

   if($newpass==$newpassconfirm){
   writedata("$configarray[1]/$user/main.php",md5($newpass),1);
   print "Password changed, you will need to log in with new password to verify";
   }else{
   print "New password does not match new password confirm!";
   }

  }else{
   print "Old password incorrect!";
  }

 print "</span>";
 print "</p>";
 print "</td>";
 print "</tr>";
 print "</table>";

 //if update is not 1
 }else{

  $userarray=getdata("$configarray[1]/$user/main.php");

  print "<form action=\"user_pass.php\" method=post>";
  print "<input type=hidden name=\"update\" value=\"1\">";
  print "<input type=hidden name=\"user\" value=\"$user\">";

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\" width=\"20%\">";
  print "<span class=\"textlarge\">Current password</span><br>";
  print "</td><td class=\"tablecell2\" width=\"80%\">";
  print "<input type=password name=\"currentpass\" size=30 class=\"forminput\">";
  print "</td>";
  print "</tr>";
  print "<tr>";
  print "<td class=\"tablecell1\" width=\"20%\">";
  print "<span class=\"textlarge\">New password & <br>Confirm new password</span><br>";
  print "</td><td class=\"tablecell2\" width=\"80%\">";
  print "<input type=password name=\"newpass\" size=30 class=\"forminput\">";
  print "---<input type=password name=\"newpassconfirm\" size=30 class=\"forminput\">";
  print "</td>";
  print "</tr>";
  print "</table>";

  print "<br><br>";

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\" colspan=\"2\">";
  print "<input type=submit name=\"submit\" value=\"Change\" class=\"formbutton\"></td>";
  print "</tr>";
  print "</table>";

 }//update check

}//access check

}

print "<br><br>";
tableheader1();

require ("footer.php");
?>