<?php
include("global.php");

if($configarray[40]){
 $links=" > Module";
 $pagetitle=" - Module";
 include("header.php");
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table>";
 print "<br><br>";
 tableheader1();
 include("footer.php");
}else{

if(@include("modules/$module/config.php")){

if($moduleconfig['active']=="no"){
 include("header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Module is not active<br>";
 print "</font>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";

 include("footer.php");
}else{
include("modules/$module/".$moduleconfig['mainpage']);
}

//no such module
}else{

$pagetitle=" - Modules";
$links=" > Modules";

include("header.php");

tableheader1();
print "<tr>";
print "<td class=\"tablecell1\">";
print "<span class=\"textlarge\">";
print "Module '$module' does not exist";
print "</span>";
print "</td>";
print "</tr>";
print "</table>";

print "<br><br>";
tableheader1();

include("footer.php");

}//include test

}//board closed check
?>