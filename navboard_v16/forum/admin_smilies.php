<?php

include("global.php");

$pagetitle=" - Administration - Smilies";
$links=" > Administration > Smilies";

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

if(!$addsmilie&&!isset($editsmilie)&&!isset($deletesmilie)&!$addsmilie2&&!isset($editsmilie2)){

 $smiliearray=getdata("$configarray[5]/smilies.php");

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Smilies images go in forum/images/smilies folder<br><br>";

   for($n=0;$n<count($smiliearray);$n++){
    $linearray=explode("\t",$smiliearray[$n]);

    if(count($linearray)>1){

    print "<b>$linearray[0] + $linearray[1] + <img src=\"images/smilies/$linearray[1]\"></b>\n";
    print " | <a href=\"admin_smilies.php?editsmilie=$n\">Edit</a>";
    print " | <a href=\"admin_smilies.php?deletesmilie=$n\">Delete</a>";

    print "<br><br>";
    }

   }//end smilie loop

  print "<br><br>";
  print "<a href=\"admin_smilies.php?addsmilie=1\">Add new</a>";

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($editsmilie)){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 $smiliearray=getdata("$configarray[5]/smilies.php");
 $linearray=explode("\t",$smiliearray[$editsmilie]);

 print "<form action=\"admin_smilies.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"editsmilie2\" value=\"$editsmilie\" size=40>";

 print "Edit smilie $editsmilie<br><br>";

 print "Smilie text, Examples :) :grin: =) whatever you want<br>";
 print "<input type=text name=\"smilietext\" size=5 value=\"$linearray[0]\" class=\"forminput\"><br><br>";

 print "Smilie image (list is gotten from (forumfolder)/images/smilies) you have to add images there yourself<br>";
 print "Download smilie images on the main navboard site<br>";
 $smilieimagesarray=listfilesext("images/smilies");
 @sort($smilieimagesarray);

 print "<select size=1 name=\"smilieimage\" class=\"forminput\">\n";

 for($n=0;$n<count($smilieimagesarray);$n++){
  if($smilieimagesarray[$n]==$linearray[1]){
   print "<option value=\"$smilieimagesarray[$n]\" selected>$smilieimagesarray[$n]</option>";
  }else{
   print "<option value=\"$smilieimagesarray[$n]\">$smilieimagesarray[$n]</option>";
  }
 }

 print "</select>";
 
 print "<br><br>";

 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>"; 
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($editsmilie2)){

  if(trim($smilietext)==""){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Smilie text cannot be empty!";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
  }else{
   writedata("$configarray[5]/smilies.php","$smilietext\t$smilieimage",$editsmilie2);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Smilie edited - <a href=\"admin_smilies.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
  }


 }

 if($addsmilie=="1"){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_smilies.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"addsmilie\" value=\"2\" size=40>";
 print "<input type=hidden name=\"tags\" value=\"$tags\" size=40>";

 print "Add smilie<br><br>";

 print "Smilie text, Examples :) :grin: =) whatever you want<br>";
 print "<input type=text name=\"smilietext\" size=5 class=\"forminput\"><br><br>";

 print "Smilie image (list is gotten from /images/smilies) you have to add images there yourself<br>";
 print "Download images on the main navboard site<br>";
 $smilieimagesarray=listfilesext("images/smilies");

 print "<select size=1 name=\"smilieimage\" class=\"forminput\">\n";

 for($n=0;$n<count($smilieimagesarray);$n++){
  print "<option value=\"$smilieimagesarray[$n]\">$smilieimagesarray[$n]</option>";
 }

 print "</select>";
 
 print "<br><br>";

 print "<input type=submit name=\"submit\" value=\"Add smilie\" class=\"formbutton\">";
 print "</span>";
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";

 }

 if($addsmilie=="2"){

  if(trim($smilietext)==""){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Smilie text cannot be empty!";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
  }else{
   $smiliesarray=getdata("$configarray[5]/smilies.php");
   $end=count($smiliesarray);
   writedata("$configarray[5]/smilies.php","$smilietext\t$smilieimage",$end);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Smilie added - <a href=\"admin_smilies.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
  }

 }

 if(isset($deletesmilie)){
 deletedata("$configarray[5]/smilies.php",$deletesmilie);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Smilie $deletesmilie deleted - <a href=\"admin_smilies.php\">Back to listing</a>";
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
