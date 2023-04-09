<?php

include("global.php");

$pagetitle=" - Administration - Ban list";
$links=" > Administration > Ban list";

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

 if(!$editbanlist){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_banlist.php\" method=post>";
 print "<input type=hidden name=\"editbanlist\" value=\"1\" size=40>";

 print "<span class=\"textlarge\">";
 print "<b>Ban list</b><br><br>";
 print "<textarea name=\"banlist\" cols=40 rows=10 class=\"forminput\">";
 for($n=0;$n<count($banarray);$n++){
 print "$banarray[$n]\n";
 }
 print "</textarea>";
 
 print "<br><br>";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if($editbanlist){

 $banlist=explode("\n",$banlist);
 @unlink("$configarray[1]/ban.php");
 
 for($n=0;$n<count($banlist);$n++){
  writedata("$configarray[1]/ban.php",$banlist[$n],$n);
 }

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Ban list updated!<br>";
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
