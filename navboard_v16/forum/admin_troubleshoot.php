<?php

include("global.php");

$pagetitle=" - Administration - Troubleshooting";
$links=" > Administration > Troubleshooting";

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

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "<b>Board troubleshooting</b>";
 print "<br><br>";
 print "</span>";
 
 print "<table border=1 bordercolor=\"black\" cellpadding=2 cellspacing=0 width=\"40%\">";
 print "<tr>";
 print "<td bgcolor=\"white\" colspan=\"3\">";
 print "<span class=\"textlarge\">";
 print "<b>Php.ini Settings (blank=unset)</b>";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 $inisetting[0]="file_uploads";
 $inisetting[1]="register_globals";
 $inisetting[2]="safe_mode";
 $iniwarning[0]="yellow";
 $iniwarning[1]="yellow";
 $iniwarning[2]="yellow";
 $inigoodvalue[0]=TRUE;
 $inigoodvalue[1]=TRUE;
 $inigoodvalue[2]=FALSE;
 
 for($n=0;$n<count($inisetting);$n++){
 $settingvalue=ini_get($inisetting[$n]);
 
 print "<tr>";
 print "<td bgcolor=\"white\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print $inisetting[$n];
 print "</span>";
 print "</td>";
 print "<td bgcolor=\"white\" width=\"10%\">";
 print "<span class=\"textlarge\">";
 print $settingvalue."&nbsp";
 print "</span>";
 print "</td>";
 if($settingvalue==$inigoodvalue[$n]){
 print "<td bgcolor=\"green\" width=\"10%\">";
 }else{
 print "<td bgcolor=\"$iniwarning[$n]\" width=\"10%\">";
 }
 print "<span class=\"textlarge\">";
 print "&nbsp";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 }
  
 print "</table>";

 print "<br><br>";

 print "<table border=1 bordercolor=\"black\" cellpadding=2 cellspacing=0 width=\"40%\">";
 print "<tr>";
 print "<td bgcolor=\"white\" colspan=\"3\">";
 print "<span class=\"textlarge\">";
 print "<b>Data Folder Permissons</b>";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 $foldersetting[0]=$maindatadir;
 $foldersetting[1]=$configarray[1];
 $foldersetting[2]=$configarray[2];
 $foldersetting[3]=$configarray[5];
 $foldersetting[4]=$configarray[20];
 $folderwarning[0]="red";
 $folderwarning[1]="red";
 $folderwarning[2]="red";
 $folderwarning[3]="red";
 $folderwarning[4]="red";
 $foldergoodvalue[0]="775";
 $foldergoodvalue[1]="775";
 $foldergoodvalue[2]="775";
 $foldergoodvalue[3]="775";
 $foldergoodvalue[4]="775";
 
 for($n=0;$n<count($foldersetting);$n++){
 $settingvalue=substr(decoct(@fileperms($foldersetting[$n])),-3);
 
 print "<tr>";
 print "<td bgcolor=\"white\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print $foldersetting[$n];
 print "</span>";
 print "</td>";
 print "<td bgcolor=\"white\" width=\"10%\">";
 print "<span class=\"textlarge\">";
 print $settingvalue."&nbsp";
 print "</span>";
 print "</td>";
 if($settingvalue>=$foldergoodvalue[$n]){
 print "<td bgcolor=\"green\" width=\"10%\">";
 }else{
 print "<td bgcolor=\"$folderwarning[$n]\" width=\"10%\">";
 }
 print "<span class=\"textlarge\">";
 print "&nbsp";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 }//loop
  
 print "</table>";

 print "<br><br>";

 print "<table border=1 bordercolor=\"black\" cellpadding=2 cellspacing=0 width=\"40%\">";
 print "<tr>";
 print "<td bgcolor=\"white\" colspan=\"3\">";
 print "<span class=\"textlarge\">";
 print "<b>Folder Permissons</b>";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 unset($foldersetting);
 unset($folderwarning);
 unset($foldergoodvalue);

 $foldersetting[0]="attachments";
 $foldersetting[1]="avatars";
 $folderwarning[0]="red";
 $folderwarning[1]="red";
 $foldergoodvalue[0]="775";
 $foldergoodvalue[1]="775";
 
 for($n=0;$n<count($foldersetting);$n++){
 $settingvalue=substr(decoct(@fileperms($foldersetting[$n])),-3);
 
 print "<tr>";
 print "<td bgcolor=\"white\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print $foldersetting[$n];
 print "</span>";
 print "</td>";
 print "<td bgcolor=\"white\" width=\"10%\">";
 print "<span class=\"textlarge\">";
 print $settingvalue."&nbsp";
 print "</span>";
 print "</td>";
 if($settingvalue>=$foldergoodvalue[$n]){
 print "<td bgcolor=\"green\" width=\"10%\">";
 }else{
 print "<td bgcolor=\"$folderwarning[$n]\" width=\"10%\">";
 }
 print "<span class=\"textlarge\">";
 print "&nbsp";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 }//loop
  
 print "</table>";

 print "</td>";
 print "</tr>";
 print "</table>";

 }//access
include("admin_footer.php");
 print "<br><br>";
 tableheader1();

 include("footer.php");

?>
