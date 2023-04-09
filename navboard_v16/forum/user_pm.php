<?php
include ("global.php");

if($configarray[40]){
 $links=" > User controls";
 $pagetitle=" - User controls";
 include("header.php");
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table>";
}else{

if(!$user){$user=$useridarray[$navboardlogin];}

$user=(float) $user;
$useridarray[$navboardlogin]=(float) $useridarray[$navboardlogin];

//not logged in || not own profile and not admin || not own profile
if(($user!==$useridarray[$navboardlogin])&&($userloggedinarray[15]!=="administrator")||$login!==1){
 $links=" > User controls";
 $pagetitle=" - User controls";

 include("header.php");
 include("user_header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "You do not have access to this users controls!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

}else{

createdir("$configarray[1]/$user/pms");
$userarray=getdata("$configarray[1]/$user/main.php");

$links=" > User controls > $userarray[0]";
$pagetitle=" - User controls - $userarray[0]";

include("header.php");
include("user_header.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "<a href=\"user_pm.php?mode=inbox&user=$user\">Inbox</a>";
 print " | <a href=\"user_pm.php?mode=send&user=$user\">Send message</a>";
 $total=checkpmspace($user);
 print " | Using ".$total['percentsize']."% alloted bytes, ".$total['percentnumber']."% alloted amount";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";

 if($mode==""||$mode=="inbox"){
 tableheader1();
 print "<tr>";
 print "<td class=\"tableheadercell\" width=\"40%\">";
 print "<span class=\"textheader\">";
 print "<b>Subject</b>";
 print "</span>";
 print "</td>";
 print "<td class=\"tableheadercell\" width=\"20%\">";
 print "<span class=\"textheader\">";
 print "<b>From</b>";
 print "</span>";
 print "</td>";
 print "<td class=\"tableheadercell\" width=\"18%\">";
 print "<span class=\"textheader\">";
 print "<b>Date</b>";
 print "</span>";
 print "</td>";
 print "<td class=\"tableheadercell\" width=\"10%\" align=\"center\">";
 print "<span class=\"textheader\">";
 print "<b>Delete</b>";
 print "</span>";
 print "</td>";
 print "<td class=\"tableheadercell\" width=\"8%\" align=\"center\">";
 print "<span class=\"textheader\">";
 print "<b>Read</b>";
 print "</span>";
 print "</td>";
 print "</tr>";

 $pmlistarray=listfiles("$configarray[1]/$user/pms");
 @rsort($pmlistarray,SORT_NUMERIC);

 for($n=0;$n<count($pmlistarray);$n++){
 $pmarray=getdata("$configarray[1]/$user/pms/$pmlistarray[$n].php");
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "<a href=\"user_pm.php?mode=view&message=$pmlistarray[$n]&user=$user\">$pmarray[2]</a>";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\">";
 print "<span class=\"textlarge\">";
 $userarray=getdata("$configarray[1]/$pmarray[0]/main.php");
 if(count($userarray)>0){
 print "<a href=\"profile.php?user=$pmarray[0]\">$userarray[0]</a>";
 }else{
 print "Guest";
 }
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 $date=date($dateformat,$pmarray[1]);
 print "$date";
 print "</span>";
 print "</td>";
 
 print "<td class=\"tablecell1\" align=\"center\">";
 print "<span class=\"textlarge\">";
 print "[<a href=\"user_pm.php?mode=delete&message=$pmlistarray[$n]&user=$user\">Delete</a>]";
 print "</span>";
 print "</td>";
 
 print "<td class=\"tablecell1\" align=\"center\">";
 print "<span class=\"textlarge\">";
 if($pmarray[8]!=="unread"){
  print "X";
 }else{
  print "&nbsp";
 }
 print "</span>";
 print "</td>";
 print "</tr>";
 }

 print "</table>";
 }elseif($mode=="send"){

  if($step==""){
  $pmarray=getdata("$configarray[1]/$user/pms/$message.php");

   tableheader1();
   print "<form action=\"user_pm.php\" method=post name=\"post\">";
   print "<input type=hidden name=\"step\" value=\"2\">";
   print "<input type=hidden name=\"mode\" value=\"$mode\">";
   print "<input type=hidden name=\"user\" value=\"$user\">";
   print "<tr>";
   print "<td class=\"tablecell1\"><span class=\"textlarge\">Send to</span><br>";
   print "<select name=\"sendto\" class=\"forminput\">";
   if($pmarray[0]){$selected=$pmarray[0];}
   usersmenu("$selected");
   print "</select>";
   print "</td>";
   print "</tr>";

   print "<tr>";
   print "<td class=\"tablecell1\"><span class=\"textlarge\">Subject</span><br>";
   if($pmarray[2]){
   print "<input type=text name=\"subject\" value=\"Re: $pmarray[2]\" class=\"forminput\" size=40>";
   }else{
   print "<input type=text name=\"subject\" class=\"forminput\" size=40>";
   }
   print "<br>";
   print "</td>";
   print "</tr>";

   print "<tr>";
   print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">Body<br><br>";
   displaysmilies();
   print "<br><br>";
   print "</span>";
   print "<textarea class=\"forminput\" rows=12 cols=80 name=\"body\" class=\"forminput\">$value</textarea><br></td>";
   print "</tr>";

   print "<tr>";
   print "<td class=\"tablecell1\"><input type=submit name=\"submit\" value=\"Send\" class=\"formbutton\"></td>";
   print "</form>";
   print "</tr>";
   print "</table>";
  }elseif($step=="2"){
  
  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\" colspan=\"2\">";
  print "<span class=\"textlarge\">";

  sendpm($sendto,$user,$subject,$body);
  
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";

  }//send step check

 }elseif($mode=="view"&&isset($message)){
 $pmarray=getdata("$configarray[1]/$user/pms/$message.php");
 writedata("$configarray[1]/$user/pms/$message.php","read",8);
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "From";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 $userarray=getdata("$configarray[1]/$pmarray[0]/main.php");
 if(count($userarray[0])>0){
 print "<a href=\"profile.php?user=$pmarray[0]\">$userarray[0]</a>";
 }else{
 print "Guest";
 }
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Date";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\">";
 print "<span class=\"textlarge\">";
 $date=date($dateformat,$pmarray[1]);
 print "$date";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Subject";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\">";
 print "<span class=\"textlarge\">";
 $pmarray[2]=stripslashes($pmarray[2]);
 $pmarray[2]=htmlentities($pmarray[2]);
 print "$pmarray[2]";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell2\" colspan=\"2\">";
 print "<span class=\"textlarge\">";
 $body=bodyparse($pmarray[3]);
 print "$body";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" colspan=\"2\" align=\"right\">";
 print "<span class=\"textlarge\">";
 if(count($userarray[0])>0){
 print "<a href=\"user_pm.php?mode=send&message=$message\">Reply</a>";
 }else{
 print "Cannot reply";
 }
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }elseif($mode=="delete"||isset($message)){
 @unlink("$configarray[1]/$user/pms/$message.php");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\" colspan=\"2\">";
 print "<span class=\"textlarge\">";
 print "PM '$message' deleted";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

}//access check

}

print "<br><br>";
tableheader1();

require ("footer.php");
?>
