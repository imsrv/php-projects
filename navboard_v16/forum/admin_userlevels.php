<?php

include("global.php");

$pagetitle=" - Administration - User Levels";
$links=" > Administration > User Levels";

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

if(!$adduserlevels&&!isset($edituserlevels)&&!isset($deleteuserlevels)&!$adduserlevels2&&!isset($edituserlevels2)){

 $userlevelsarray=getdata("$configarray[5]/userlevels.php");

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

   print "Info: User levels are a rank that a normal user can achieve if they get a certain number of posts<br>";
   if($configarray[45]!=="on"){
    print "NOTE: User level image icons are enabled, this means the name you give the level will not mean anything<br>";
   }
   print "<br>";

   for($n=0;$n<count($userlevelsarray);$n+=2){

    print "<b>$userlevelsarray[$n] -> ".$userlevelsarray[$n+1]."</b>\n";
    print " | <a href=\"admin_userlevels.php?edituserlevels=$n\">Edit</a>";
    print " | <a href=\"admin_userlevels.php?deleteuserlevels=$n\">Delete</a>";

    print "<br><br>";

   }//end userlevels loop

   print "<br>";
   print "<a href=\"admin_userlevels.php?adduserlevels=1\">Add new</a>";

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($edituserlevels)){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 $userlevelsarray=getdata("$configarray[5]/userlevels.php");

 print "<form action=\"admin_userlevels.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"edituserlevels2\" value=\"$edituserlevels\" size=40>";

 print "Edit User Level $edituserlevels<br><br>";

 print "User Level Name<br>";
 print "<input type=text name=\"userlevelname\" value=\"$userlevelsarray[$edituserlevels]\" size=40 class=\"forminput\"><br>";
 print "Posts to achieve this level <input type=text name=\"userlevelposts\" value=\"".$userlevelsarray[$edituserlevels+1]."\" size=5 class=\"forminput\"><br>";
 print "<br><br>";

 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>"; 
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($edituserlevels2)){

 writedata("$configarray[5]/userlevels.php",$userlevelname,$edituserlevels2);
 writedata("$configarray[5]/userlevels.php",$userlevelposts,$edituserlevels2+1);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Profile Field edited - <a href=\"admin_userlevels.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";


 }

 if($adduserlevels=="1"){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_userlevels.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"adduserlevels\" value=\"2\" size=40>";

 print "Add User Level<br><br>";

 print "User Level Name<br>";
 print "<input type=text name=\"userlevelname\" size=40 class=\"forminput\"><br>";
 print "Posts to achieve this level <input type=text name=\"userlevelposts\" size=5 class=\"forminput\"><br>";
 print "<br><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Add Profile Field\" class=\"formbutton\">";
 print "</span>";
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";

 }

 if($adduserlevels=="2"){
 $userlevelsarray=getdata("$configarray[5]/userlevels.php");
 $end=count($userlevelsarray);

 writedata("$configarray[5]/userlevels.php",$userlevelname,$end);
 writedata("$configarray[5]/userlevels.php",$userlevelposts,$end+1);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "User level edited - <a href=\"admin_userlevels.php\">Back to listing</a>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 }

 if(isset($deleteuserlevels)){
 deletedata("$configarray[5]/userlevels.php",$deleteuserlevels);
 deletedata("$configarray[5]/userlevels.php",$deleteuserlevels);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "User level $deleteuserlevels deleted - <a href=\"admin_userlevels.php\">Back to listing</a>";
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
