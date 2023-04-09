<?php

include("global.php");

$pagetitle=" - Administration - Approvals";
$links=" > Administration > Approvals";

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

 if(!isset($approvedisplay)&&!isset($rejectdisplay)&&!isset($approvereg)&&!isset($rejectreg)){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<span class=\"textlarge\">";
 print "<b>Items to be approved by administrator</b><br><br>";

 print "Registrations:<br><br>";
 if($configarray[39]!=="approve"){
 print "Admin approved registration is turned off, goto config to turn on<br><br>";
 }
  print "User ID --- Username --- Displayname --- Email --- Admin Approve or Email Confirm<br><br>";
  for($n=0;$n<count($usersarray);$n++){
  $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");
   if($userarray[15]=="approve" || $userarray[15]=="confirm"){
    print "$usersarray[$n] --- ".$userkeyarray[$usersarray[$n]]." --- $userarray[0] --- $userarray[2] --- $userarray[15]";
    print " | <a href=\"admin_approve.php?approvereg=$usersarray[$n]\">Approve</a>";
    print " | <a href=\"admin_approve.php?rejectreg=$usersarray[$n]\">Reject</a><br>";
   }
  }
 print "<br><br>";
 print "=============================";
 print "<br><br>";
 
 print "Display name changes:<br><br>";
 if($configarray[41]!=="approve"){
 print "Admin approved display name change is turned off, goto config to turn on<br><br>";
 }
  $displaychangearray=getdata("$configarray[1]/displaychange.php");
  print "User ID / Requested name<br><br>";
  for($n=0;$n<count($displaychangearray);$n++){
   if(trim($displaychangearray[$n])){
    print "$n / $displaychangearray[$n]";
    print " | <a href=\"admin_approve.php?approvedisplay=$n\">Approve</a>";
    print " | <a href=\"admin_approve.php?rejectdisplay=$n\">Reject</a><br>";
   }
  }

 print "</span>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($approvedisplay)){

 $displaychangearray=getdata("$configarray[1]/displaychange.php");
 
 writedata("$configarray[1]/$approvedisplay/main.php",$displaychangearray[$approvedisplay],0);
 deletedata("$configarray[1]/displaychange.php",$approvedisplay);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Display name changed<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }
 
 if(isset($rejectdisplay)){
 deletedata("$configarray[1]/displaychange.php",$rejectdisplay);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Display name change rejected<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }
 
 if(isset($approvereg)){
 
 writedata("$configarray[1]/$approvereg/main.php","registered",15);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "User registration approved<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }
 
 if(isset($rejectreg)){
 deleteuser($rejectreg);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "User registration rejected<br>";
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
