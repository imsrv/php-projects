<?php

include("modules/members/global.php");

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

 if(!$editconfig){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_modules.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"module\" value=\"members\" size=40>";
 print "<input type=hidden name=\"editconfig\" value=\"1\" size=40>";

 print "Users to show per page in members list<br>";
 print "<input type=text name=\"membersperpage\" value=\"$membersmoduleconfig[0]\" size=40 class=\"forminput\"><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Update\" size=40 class=\"formbutton\">";
 print "</span>";
 print "</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
 }

 if($editconfig){

 writedata("$configarray[20]/members/config.php",$membersperpage,0);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Members module config updated!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

}

?>
