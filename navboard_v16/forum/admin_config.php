<?php

include("global.php");

$pagetitle=" - Administration - Config";
$links=" > Administration > Config";

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
 print "<form action=\"admin_config.php\" method=post>";
 print "<input type=hidden name=\"editconfig\" value=\"1\" size=40>"; 
 print "<tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Main forum settings</b>";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Board Title";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"boardtitle\" value=\"$configarray[0]\" size=40 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Admin email address (blank will not display)";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"adminemail\" value=\"$configarray[35]\" size=40 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Main website address (NOT forum address, blank will display forum address)";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"mainwebsite\" value=\"$configarray[36]\" size=40 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Display text title instead of graphic logo for faster loading<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[34]=="on")
 {print "<input type=checkbox name=\"textlogo\" class=\"forminput\" checked>";}
 else{print "<input type=checkbox name=\"textlogo\" class=\"forminput\">";}
 print "</span></td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 
 print "<b>Forums</b><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max levels of subforums to display on one page (less will make for faster loading)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxsubforumdisplay\" value=\"$configarray[27]\" size=2 class=\"forminput\">";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Don't find forum reply count on the fly, recount during posting<br>(faster forum page, may slow posting slightly)";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[42]=="on"){
 print "<input type=checkbox name=\"dontscanreplycount\" class=\"forminput\" checked>";
 }else{print "<input type=checkbox name=\"dontscanreplycount\" class=\"forminput\">";}
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Forum/Thread indenting amount<br>Percentage of title cell used for indent spaing";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"indentspacing\" value=\"$configarray[44]\" size=2 class=\"forminput\">%";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 
 print "<b>Posts</b><br>";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Seconds before user may add another post (flood control)";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"postfloodcontrolsec\" value=\"$configarray[37]\" size=2 class=\"forminput\">";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Amount of nested bbcodes allowed<br>(how many times a bbcode tag can be put over itself) 3 is default";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"nestedbbcodes\" value=\"$configarray[43]\" size=2 class=\"forminput\">";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Show names for user levels instead of imageicons:<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[45]=="on"){
 print "<input type=checkbox name=\"userlevelnames\" class=\"forminput\" checked>";
 }else{
 print "<input type=checkbox name=\"userlevelnames\" class=\"forminput\">";
 }
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Show all edits instead of only last edit on posts<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[46]=="on"){
 print "<input type=checkbox name=\"showalledits\" class=\"forminput\" checked>";
 }else{
 print "<input type=checkbox name=\"showalledits\" class=\"forminput\">";
 }
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 
 print "<b>Registration</b><br>";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Seconds before another account can be registered (flood control)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"regfloodcontrolsec\" value=\"$configarray[38]\" size=2 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Method of registration<br>";
 print "NOTE: Mailing in php must be setup correctly on your server to work with email confirmation";
 print "</span></td><td class=\"tablecell2\" width=\"50%\"><span class=\"textlarge\">";
 if($configarray[39]=="on"||$configarray[39]==""){
 print "<input type=radio name=\"registration\" value=\"on\" class=\"forminput\" checked> ";
 }else{
 print "<input type=radio name=\"registration\" value=\"on\" class=\"forminput\"> ";
 }
 print "Allowed<br>";
 if($configarray[39]=="confirm"){
 print "<input type=radio name=\"registration\" value=\"confirm\" class=\"forminput\" checked> ";
 }else{
 print "<input type=radio name=\"registration\" value=\"confirm\" class=\"forminput\"> ";
 }
 print "Email confirmed<br>";
 if($configarray[39]=="approve"){
 print "<input type=radio name=\"registration\" value=\"approve\" class=\"forminput\" checked> ";
 }else{
 print "<input type=radio name=\"registration\" value=\"approve\" class=\"forminput\"> ";
 }
 print "Admin approved";
 print "</span></td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Profiles</b>";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Allow duplicate display names<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[32]=="on"){
 print "<input type=checkbox name=\"allowdupdisplay\" class=\"forminput\" checked>";
 }else{
 print "<input type=checkbox name=\"allowdupdisplay\" class=\"forminput\">";
 }
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Display name changing<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\"><span class=\"textlarge\">";
 if($configarray[41]=="off"){
 print "<input type=radio name=\"displaychange\" value=\"off\" class=\"forminput\" checked> ";
 }else{
 print "<input type=radio name=\"displaychange\" value=\"off\" class=\"forminput\"> ";
 }
 print "Not allowed<br>";
 if($configarray[41]=="on"||$configarray[41]==""){
 print "<input type=radio name=\"displaychange\" value=\"on\" class=\"forminput\" checked> ";
 }else{
 print "<input type=radio name=\"displaychange\" value=\"on\" class=\"forminput\"> ";
 }
 print "Allowed<br>";
 if($configarray[41]=="approve"){
 print "<input type=radio name=\"displaychange\" value=\"approve\" class=\"forminput\" checked> ";
 }else{
 print "<input type=radio name=\"displaychange\" value=\"approve\" class=\"forminput\"> ";
 }
 print "Admin approved";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Default time format (php <a href=\"http://www.php.net/manual/en/function.date.php\" target=\"_new\">date</a> format) ";
 print "Recommended: n-j-Y h:iA <br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"defaulttime\" value=\"$configarray[33]\" size=40 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max people on individual users buddy lists";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"buddylistmax\" value=\"$configarray[28]\" size=2 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Avatars</b><br>";
 print "</span></td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Avatar file size limit (bytes)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"avatarfilesize\" value=\"$configarray[9]\" size=20 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Avatar dimensions limit (height)x(width)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"avatardimension\" value=\"$configarray[10]\" size=20 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Attachments</b>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Allowed attachment extensions (separated by commas) (blank would allow no attachments)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"allowedattachext\" value=\"$configarray[22]\" size=40 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max size of attachments (in bytes)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxattachsize\" value=\"$configarray[23]\" size=20 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max total size of all attachments (in bytes)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxtotalattachsize\" value=\"$configarray[31]\" size=20 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Polls</b>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max poll options<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxpolloptions\" value=\"$configarray[24]\" size=2 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Theme</b><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Default theme<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 $themesarray=listdirs("themes");
 print "<select size=1 name=\"defaulttheme\" size=40 class=\"forminput\">\n";
 for($n=0;$n<count($themesarray);$n++){

  if($themesarray[$n]==$configarray[12]){
  print "<option value=\"$themesarray[$n]\" selected>$themesarray[$n]</option>";
  }else{
  print "<option value=\"$themesarray[$n]\">$themesarray[$n]</option>";
  }

 }
 print "</select>";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Online users</b><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Seconds of inactivity before user is removed from online list (300seconds=5minutes)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"inactivityseconds\" value=\"$configarray[13]\" size=2 class=\"forminput\">";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Page settings</b>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Threads to show per page in forum<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"threadperpage\" value=\"$configarray[7]\" size=2 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Posts to show per page in thread<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"postperpage\" value=\"$configarray[8]\" size=2 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Max character settings</b><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max total characters in body of posts<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxcharsbody\" value=\"$configarray[18]\" size=5 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max total characters in subject of posts<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxcharssubject\" value=\"$configarray[25]\" size=5 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max total characters in signatures<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxcharssigs\" value=\"$configarray[19]\" size=5 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Enabling/Disabling</b>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Allow HTML in posts:<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[14]=="allowhtml"){
 print "<input type=checkbox name=\"html\" class=\"forminput\" checked>";
 }else{
 print "<input type=checkbox name=\"html\" class=\"forminput\">";
 }
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Enable GZ Compression:<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 if($configarray[21]=="disablegz"){
 print "<input type=checkbox name=\"gzcompress\" class=\"forminput\">";
 }else{
 print "<input type=checkbox name=\"gzcompress\" class=\"forminput\" checked>";
 } 
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Private Messaging</b><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max total size of pms per user (bytes)<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxpmsize\" value=\"$configarray[29]\" size=10 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Max total number of pms per user<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"maxpmnumber\" value=\"$configarray[30]\" size=10 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tableheadercell\" colspan=\"2\"><span class=\"textlarge\">";
 print "<b>Board Closing</b>";
 print "</td></tr><tr><td class=\"tablecell1\" width=\"50%\"><span class=\"textlarge\">";
 print "Entering info here will cause the entire bulletin board to be closed<br>";
 print "This is the message that shows up when the board is closed<br>";
 print "</span></td><td class=\"tablecell2\" width=\"50%\">";
 print "<input type=text name=\"boardclosing\" value=\"$configarray[40]\" size=60 class=\"forminput\"><br>";
 print "</td></tr><tr><td class=\"tablecell2\" colspan=\"2\"><span class=\"textlarge\">";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>";
 print "</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
 }

 if($editconfig){

 $boardtitle=stripslashes($boardtitle);
 $boardtitle=htmlentities($boardtitle);
 writedata("$maindatadir/config.php",$boardtitle,0);
 writedata("$maindatadir/config.php",$threadperpage,7);
 writedata("$maindatadir/config.php",$postperpage,8);
 writedata("$maindatadir/config.php",$avatarfilesize,9);
 writedata("$maindatadir/config.php",$avatardimension,10);
 writedata("$maindatadir/config.php",$defaulttheme,12);
 writedata("$maindatadir/config.php",$inactivityseconds,13);
 if($html=="on"){
 writedata("$maindatadir/config.php","allowhtml",14);
 }else{
 writedata("$maindatadir/config.php","denyhtml",14);
 }
 writedata("$maindatadir/config.php",$maxcharsbody,18);
 writedata("$maindatadir/config.php",$maxcharssigs,19);
 if($gzcompress=="on"){
 writedata("$maindatadir/config.php","enablegz",21);
 }else{
 writedata("$maindatadir/config.php","disablegz",21);
 }
 writedata("$maindatadir/config.php",$allowedattachext,22);
 writedata("$maindatadir/config.php",$maxattachsize,23);
 writedata("$maindatadir/config.php",$maxpolloptions,24);
 writedata("$maindatadir/config.php",$maxcharssubject,25);
 writedata("$maindatadir/config.php",$maxsubforumdisplay,27);
 writedata("$maindatadir/config.php",$buddylistmax,28);
 writedata("$maindatadir/config.php",$maxpmsize,29);
 writedata("$maindatadir/config.php",$maxpmnumber,30);
 writedata("$maindatadir/config.php",$maxtotalattachsize,31);
 writedata("$maindatadir/config.php",$allowdupdisplay,32);
 writedata("$maindatadir/config.php",$defaulttime,33);
 writedata("$maindatadir/config.php",$textlogo,34);
 writedata("$maindatadir/config.php",$adminemail,35);
 writedata("$maindatadir/config.php",$mainwebsite,36);
 writedata("$maindatadir/config.php",$postfloodcontrolsec,37);
 writedata("$maindatadir/config.php",$regfloodcontrolsec,38);
 writedata("$maindatadir/config.php",$registration,39);
 writedata("$maindatadir/config.php",$boardclosing,40);
 writedata("$maindatadir/config.php",$displaychange,41);
 
 if($configarray[42]!=="on"&&$dontscanreplycount=="on"){//if turning on for first time, make a recount
  for($n=0;$n<count($forumarray);$n++){
  $topicarray=listdirs("$configarray[2]/$forumarray[$n]");
  $replies=0;
   for($m=0;$m<count($topicarray);$m++){
    $postarray2=listfiles("$configarray[2]/$forumarray[$n]/$topicarray[$m]");
    $replies+=count($postarray2)-1;
   }
  writedata("$configarray[2]/$forumarray[$n].php",$replies,11);
  }
 writedata("$maindatadir/config.php",$dontscanreplycount,42);
 }else{
 writedata("$maindatadir/config.php",$dontscanreplycount,42);
 }
 
 writedata("$maindatadir/config.php",$nestedbbcodes,43);
 writedata("$maindatadir/config.php",$indentspacing,44);
 writedata("$maindatadir/config.php",$userlevelnames,45);
 writedata("$maindatadir/config.php",$showalledits,46);

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
