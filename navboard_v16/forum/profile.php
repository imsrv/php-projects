<?php
include ("global.php");

if($configarray[40]){
 $links=" > Profile";
 $pagetitle=" - Profile";
 include("header.php");
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table>";
}else{

$userarray=getdata("$configarray[1]/$user/main.php");

//not logged in/no such user
if(count($userarray)<=0){
 $links=" > Profile";
 $pagetitle=" - Profile";

 include("header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Please login or specify a user that exists!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

}else{

$links=" > Profile: $userarray[0]";
$pagetitle=" - Profile: $userarray[0]";

include("header.php");

   tableheader1();

   print "<tr>";
   print "<td width=\"100%\" colspan=\"2\" class=\"tableheadercell\">";
   print "<span class=\"textheader\">";
   print "<b>Standard Info</b>";
   print "</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">ID #</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">";
   print "$user";
   print "</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">E-mail</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">";
   $emailarray=explode("\t",$userarray[2]);
   if($emailarray[1]=="hide"){
   print "Hidden";
   }else{
   print "$emailarray[0]";
   }
   print "</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Date Registered</span></td>";
   $date=date($dateformat,$userarray[4]);
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$date</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Last Seen</span></td>";
   $lastseenarray=explode("\t",$userarray[5]);
   $date=date($dateformat,$lastseenarray[1]);
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$date</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Post Count</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[6]</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Birthday</span></td>";
   $birthday=explode("\t",$userarray[8]);
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$birthday[0]-$birthday[1]-$birthday[2]</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Website</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\"><a href=\"$userarray[9]\">$userarray[9]</a>&nbsp</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">ICQ</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[10]&nbsp</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">YIM</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[11]&nbsp</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">AIM</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[12]&nbsp</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">MSN</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[13]&nbsp</span></td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Last post</span></td>";
   $lastpost=date($dateformat,$userarray[18]);
   print "<td width=\"60%\" class=\"tablecell2\">";
   print "<span class=\"textlarge\">";
    if($userarray[18]){
    print "$lastpost";
    }else{
    print "never";
    }
   print "</span>";
   print "</td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">Group</span></td>";
   print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[15]</span></td>";
   print "</tr>";

   print "</table>";

   print "<br><br>";

   tableheader1();

   print "<tr>";
   print "<td width=\"100%\" colspan=\"2\" class=\"tableheadercell\">";
   print "<span class=\"textheader\">";
   print "<b>Extra Info</b>";
   print "</span></td>";
   print "</tr>";

   $profilefieldsarray=getdata("$configarray[5]/profilefields.php");
   $userprofilefieldsarray=getdata("$configarray[1]/$user/profilefields.php");

   for($n=0;$n<count($profilefieldsarray);$n++){
    print "<tr>";
    print "<td width=\"40%\" class=\"tablecell1\"><span class=\"textlarge\">$profilefieldsarray[$n]</span></td>";
    print "<td width=\"60%\" class=\"tablecell2\"><span class=\"textlarge\">";
     if($userprofilefieldsarray[$n]){
     print "$userprofilefieldsarray[$n]";
     }else{
     print "&nbsp";
     }
    print "</span></td>";
    print "</tr>";
   }

   print "</table>";


   if($userloggedinarray[15]=="administrator"){
    print "<br><br>";
    tableheader1();
    print "<tr>";
    print "<td class=\"tablecell2\">";
    print "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
    print "<tr>";
    print "<td width=\"50%\">";
    print "&nbsp";
    print "</td>";
    print "<td width=\"50%\" align=\"right\">";
    print "<span class=\"textlarge\">";
    print "<a href=\"user_edit.php?user=$user\">Edit this profile</a>";
    print "</span>";
    print "</td>";
    print "</tr>";
    print "</table>";
    print "</td>";
    print "</tr>";
    print "</table>";
   }

}

}//board closed check

print "<br><br>";
tableheader1();

require ("footer.php");
?>
