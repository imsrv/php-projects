<?php
include("global.php");

$pagetitle=" - Administration - Module: $module";
$links=" > Administration > Module: $module";

include ("header.php");
include ("admin_header.php");

if(@include("modules/$module/config.php")){

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
include("modules/$module/".$moduleconfig['adminpage']);
}


//no such module
}else{

tableheader1();
print "<tr>";
print "<td class=\"tablecell1\">";
print "<span class=\"textlarge\">";
print "Admin module '$module' does not exist";
print "</span>";
print "</td>";
print "</tr>";
print "</table>";

}//include test

include("admin_footer.php");
print "<br><br>";
tableheader1();
include("footer.php");
?>