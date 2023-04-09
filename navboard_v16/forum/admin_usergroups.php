<?php

include("global.php");

$pagetitle=" - Administration - User Groups";
$links=" > Administration > User Groups";

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

if(!$addusergroups&&!isset($editusergroups)&&!isset($deleteusergroups)&!$addusergroups2&&!isset($editusergroups2)){

 $usergroupsarray=getdata("$configarray[1]/usergroups.php");

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "User Groups are special groups that members of a forum can belong to<br>";
   print "To add a user to a specific group goto the users admin control panel<br>";
   print "<b>guest, registered, administrator</b> are always user groups no matter what<br>";
   print "<br>";

   for($n=0;$n<count($usergroupsarray);$n++){

    print "<b>$usergroupsarray[$n]</b>\n";
    print " | <a href=\"admin_usergroups.php?editusergroups=$n\">Edit</a>";
    print " | <a href=\"admin_usergroups.php?deleteusergroups=$n\">Delete</a>";

    print "<br><br>";

   }//end usergroups loop

   print "<br>";
   print "<a href=\"admin_usergroups.php?addusergroups=1\">Add new</a>";

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($editusergroups)){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 $usergroupsarray=getdata("$configarray[1]/usergroups.php");

 print "<form action=\"admin_usergroups.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"editusergroups2\" value=\"$editusergroups\" size=40>";

 print "Edit User Group $editusergroups<br><br>";

 print "User Group Name<br>";
 print "<input type=text name=\"usergroupname\" value=\"$usergroupsarray[$editusergroups]\" size=40 class=\"forminput\"><br><br>";

 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>"; 
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($editusergroups2)){


 writedata("$configarray[1]/usergroups.php",$usergroupname,$editusergroups2);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "User Group edited - <a href=\"admin_usergroups.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";


 }

 if($addusergroups=="1"){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_usergroups.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"addusergroups\" value=\"2\" size=40>";

 print "Add usergroups<br><br>";

 print "User Group Name<br>";
 print "<input type=text name=\"usergroupname\" size=40 class=\"forminput\"><br><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Add User Group\" class=\"formbutton\">";
 print "</span>";
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";

 }

 if($addusergroups=="2"){
 $usergroupsarray=getdata("$configarray[1]/usergroups.php");
 $end=count($usergroupsarray);

 writedata("$configarray[1]/usergroups.php",$usergroupname,$end);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "User Group added - <a href=\"admin_usergroups.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($deleteusergroups)){
 deletedata("$configarray[1]/usergroups.php",$deleteusergroups);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "User Group $deleteusergroups deleted - <a href=\"admin_usergroups.php\">Back to listing</a>";
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