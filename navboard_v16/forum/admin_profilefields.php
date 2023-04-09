<?php

include("global.php");

$pagetitle=" - Administration - Profile Fields";
$links=" > Administration > Profile Fields";

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

if(!$addprofilefields&&!isset($editprofilefields)&&!isset($deleteprofilefields)&!$addprofilefields2&&!isset($editprofilefields2)){

 $profilefieldsarray=getdata("$configarray[5]/profilefields.php");

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

   for($n=0;$n<count($profilefieldsarray);$n++){

    print "<b>$profilefieldsarray[$n]</b>\n";
    print " | <a href=\"admin_profilefields.php?editprofilefields=$n\">Edit</a>";
    print " | <a href=\"admin_profilefields.php?deleteprofilefields=$n\">Delete</a>";

    print "<br><br>";

   }//end profilefields loop

   print "<br>";
   print "<a href=\"admin_profilefields.php?addprofilefields=1\">Add new</a>";

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($editprofilefields)){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 $profilefieldsarray=getdata("$configarray[5]/profilefields.php");

 print "<form action=\"admin_profilefields.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"editprofilefields2\" value=\"$editprofilefields\" size=40>";

 print "Edit Profile Field $editprofilefields<br><br>";

 print "Profile Field Name<br>";
 print "<input type=text name=\"profilefieldname\" value=\"$profilefieldsarray[$editprofilefields]\" size=40 class=\"forminput\"><br><br>";

 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>"; 
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($editprofilefields2)){

 writedata("$configarray[5]/profilefields.php",$profilefieldname,$editprofilefields2);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Profile Field edited - <a href=\"admin_profilefields.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";


 }

 if($addprofilefields=="1"){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_profilefields.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"addprofilefields\" value=\"2\" size=40>";

 print "Add profilefields<br><br>";

 print "Profile Field Name<br>";
 print "<input type=text name=\"profilefieldname\" size=40 class=\"forminput\"><br><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Add Profile Field\" class=\"formbutton\">";
 print "</span>";
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";

 }

 if($addprofilefields=="2"){
 $profilefieldsarray=getdata("$configarray[5]/profilefields.php");
 $end=count($profilefieldsarray);

 writedata("$configarray[5]/profilefields.php",$profilefieldname,$end);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Profile Field added - <a href=\"admin_profilefields.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($deleteprofilefields)){
 deletedata("$configarray[5]/profilefields.php",$deleteprofilefields);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Profile Field $deleteprofilefields deleted - <a href=\"admin_profilefields.php\">Back to listing</a>";
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