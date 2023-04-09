<?php

include("modules/search/global.php");

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
 print "<input type=hidden name=\"module\" value=\"search\">";
 print "<input type=hidden name=\"editconfig\" value=\"1\">";

 print "Results per page in search<br>";
 print "<input type=text name=\"resultsperpage\" value=\"$searchmoduleconfig[0]\" size=40 class=\"forminput\"><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>";
 print "</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
 }

 if($editconfig){

 writedata("$configarray[20]/search/config.php",$resultsperpage,0);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Search module config updated!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

}

?>
