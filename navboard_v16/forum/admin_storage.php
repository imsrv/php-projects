<?php

include("global.php");

$pagetitle=" - Administration - Storage";
$links=" > Administration > Storage";

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

 if(!$editconfig){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_storage.php\" method=post>";
 print "<input type=hidden name=\"editconfig\" value=\"1\" size=40>";

 print "<span class=\"textlarge\">";
 print "<b>Storage Locations</b><br><br>";
 print "IMPORTANT: Change the setting here first, then manually change the folder name after<br>";
 print "-> config.php must always be in main data directory<br><br>";
 print "Users data location (default: data/users)<br>";
 print "<input type=text name=\"usersdir\" value=\"$configarray[1]\" size=40 class=\"forminput\"><br>";
 print "Forums data location (default: data/forum)<br>";
 print "<input type=text name=\"forumsdir\" value=\"$configarray[2]\" size=40 class=\"forminput\"><br>";
 print "Custom options data location (ex: smilies,bbcode etc) (default: data)<br>";
 print "<input type=text name=\"customdir\" value=\"$configarray[5]\" size=40 class=\"forminput\"><br>";
 print "Modules data location (default: data/forum)<br>";
 print "<input type=text name=\"modulesdatadir\" value=\"$configarray[20]\" size=40 class=\"forminput\"><br>";

 print "<br><br>";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if($editconfig){

 writedata("$maindatadir/config.php",$usersdir,1);
 writedata("$maindatadir/config.php",$forumsdir,2);
 writedata("$maindatadir/config.php",$customdir,5);
 writedata("$maindatadir/config.php",$modulesdatadir,20);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Config updated!<br>";
 print "Changes will be seen on next page you load";
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
