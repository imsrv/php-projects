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
 print "<span class=\"textlarge\">";

  for($n=0;$n<$configarray[28];$n++){
   $var="buddy$n";
   writedata("$configarray[1]/$user/buddys.php",${$var},$n);
  }

 print "Buddy list updated";

 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 //if update is not 1
 }else{

  $userarray=getdata("$configarray[1]/$user/main.php");

  print "<form action=\"user_buddy.php\" method=post>";
  print "<input type=hidden name=\"update\" value=\"1\">";
  print "<input type=hidden name=\"user\" value=\"$user\">";

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";

  print "Buddy list<br>";

  $buddyarray=getdata("$configarray[1]/$user/buddys.php");

  for($n=0;$n<$configarray[28];$n++){
  print "<select name=\"buddy$n\" class=\"forminput\">";
  usersmenu("$buddyarray[$n]");
  print "</select>";
    if($buddyarray[$n]){
    $buddyuserarray=getdata("$configarray[1]/$buddyarray[$n]/main.php");
    print " <b><a href=\"profile.php?user=$buddyarray[$n]\">$buddyuserarray[0]</a></b> ";
    print " Status: ";
     if(@in_array("$buddyarray[$n]",$onlinearray)){
      print "<b><i>! Online !</i></b>";
     }else{
      print "Offline";
     }
	  print "&nbsp;&nbsp;&nbsp;&nbsp;Last Location: ";
	 if($buddyuserarray[22]){
	  print "$buddyuserarray[22]";
	 }else{
	  print "None";
	 }
    }
   print "<br>";
  }

  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";

  print "<br><br>";

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\" colspan=\"2\">";
  print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\"></td>";
  print "</tr>";
  print "</table>";

 }//update check

}//access check

}

print "<br><br>";
tableheader1();

require ("footer.php");
?>