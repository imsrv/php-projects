<?php

include("global.php");

$pagetitle=" - Administration - Themes";
$links=" > Administration > Themes";

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

@chmod("themes",octdec(777));
@chmod("templates",octdec(777));
@chmod("replacements",octdec(777));

if(!$editfile&&!$editfile2&&!$deletefolder&&!$copyfolder&&!$copyfolder2&&!$renamefolder&&!$renamefolder2&&!$filecontents){

tableheader1();
print "<tr>";
print "<td class=\"tablecell1\">";
print "<span class=\"textlarge\">";
print "<b>Theme editing</b><br>";
print "If you are unable to edit these files, make sure themes/templates/replacement directories have 777 chmod permissions<br><br>";
print "NOTE: If you only have one theme and you rename it, the board will initially not find the theme and appear unformated until you goto another page";
print "<br><br>";

print "<a name=\"main\">Themes</a><br>";

for($n=0;$n<count($themesarray);$n++){
 print "&nbsp;&nbsp;";
 print "$themesarray[$n]";
 @chmod("themes/$themesarray[$n]",octdec(777));
 print " | <a href=\"admin_themes.php?deletefolder=themes/$themesarray[$n]\">Delete theme</a>";
 print " | <a href=\"admin_themes.php?copyfolder=themes/$themesarray[$n]\">Copy theme</a>";
 print " | <a href=\"admin_themes.php?renamefolder=themes/$themesarray[$n]\">Rename theme</a><br>";
 print "&nbsp;&nbsp;&nbsp;&nbsp;";
 print "<a href=\"admin_themes.php?editfile=themes/${themesarray[$n]}/style.css\">CSS</a><br>";
 print "&nbsp;&nbsp;&nbsp;&nbsp;";
 print "<a href=\"admin_themes.php?editfile=themes/$themesarray[$n]/config.php\">Options</a><br>";
 print "&nbsp;&nbsp;&nbsp;&nbsp;";
 print "<a href=\"admin_themes.php?editfile=themes/$themesarray[$n]/functions.php\">Functions</a><br>";
}
print "<br>";

$templatesetarray=listdirs("templates");
print "<a name=\"templates\">Template sets</a><br>";

for($n=0;$n<count($templatesetarray);$n++){
 $templatearray=listfilesext("templates/$templatesetarray[$n]");
 print "&nbsp;&nbsp;";
 print "$templatesetarray[$n]";
 @chmod("templates/$templatesetarray[$n]",octdec(777));
 print " | <a href=\"admin_themes.php?deletefolder=templates/$templatesetarray[$n]\">Delete template set</a>";
 print " | <a href=\"admin_themes.php?copyfolder=templates/$templatesetarray[$n]\">Copy template set</a>";
 print " | <a href=\"admin_themes.php?renamefolder=templates/$templatesetarray[$n]\">Rename template set</a><br>";

 for($m=0;$m<count($templatearray);$m++){
  print "&nbsp;&nbsp;&nbsp;&nbsp;";
  print "<a href=\"admin_themes.php?editfile=templates/$templatesetarray[$n]/$templatearray[$m]\">$templatearray[$m]</a><br>";
 }

}
print "<br>";

$replacementsetarray=listdirs("replacements");
print "<a name=\"replacements\">Replacement sets</a><br>";

for($n=0;$n<count($replacementsetarray);$n++){
 $replacementarray=listfilesext("replacements/$replacementsetarray[$n]");
 print "&nbsp;&nbsp;";
 print "$replacementsetarray[$n]";
 @chmod("replacements/$replacementsetarray[$n]",octdec(777));
 print " | <a href=\"admin_themes.php?deletefolder=replacements/$replacementsetarray[$n]\">Delete replacement set</a>";
 print " | <a href=\"admin_themes.php?copyfolder=replacements/$replacementsetarray[$n]\">Copy replacement set</a>";
 print " | <a href=\"admin_themes.php?renamefolder=replacements/$replacementsetarray[$n]\">Rename replacement set</a><br>";

 for($m=0;$m<count($replacementarray);$m++){
  print "&nbsp;&nbsp;&nbsp;&nbsp;";
  print "<a href=\"admin_themes.php?editfile=templates/$replacementsetarray[$n]/$replacementarray[$m]\">$replacementarray[$m]</a><br>";
 }

}

print "</span>";
print "</td>";
print "</tr>";
print "</table>";

}//nothing to do check

if($editfile){
$filearray=file($editfile);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 
 print "<span class=\"textlarge\">";
 print "Editing file: $editfile<br><br>";

 print "<form action=\"admin_themes.php\" method=post>";
 print "<input type=hidden name=\"editfile2\" value=\"$editfile\" size=40>";

 print "<textarea name=\"filecontents\" cols=90 rows=30 class=\"forminput\">";
 for($n=0;$n<count($filearray);$n++){
 print htmlentities($filearray[$n]);
 }
 print "</textarea>";

 print "<br><br>";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";

 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 unset($editfile);

}

if($editfile2){

 $filearray=explode("\n",$filecontents);
 @unlink("$editfile2");

 $handle=fopen($editfile2,"a+");
 for($n=0;$n<count($filearray);$n++){
  fwrite($handle,stripslashes($filearray[$n]));
 }
 fclose($handle);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "File '$editfile2' updated!<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 unset($editfile2);

}

if($renamefolder){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_themes.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"renamefolder2\" value=\"$renamefolder\">";

 print "Rename '$renamefolder'<br>";
 print "<input type=text name=\"newname\" size=40 class=\"forminput\"><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Rename\" class=\"formbutton\">";
 print "</span>";
 print "</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
}

if($renamefolder2){
 $basefolder=substr($renamefolder2,0,strrpos($renamefolder2,"/")+1);
 rename($renamefolder2,"$basefolder"."$newname");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "'$renamefolder2' renamed!<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}

if($copyfolder){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_themes.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"copyfolder2\" value=\"$copyfolder\">";

 print "Copy '$copyfolder' to new folder named:<br>";
 print "<input type=text name=\"copyname\" size=40 class=\"forminput\"><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Rename\" class=\"formbutton\">";
 print "</span>";
 print "</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
}

if($copyfolder2){
 $basefolder=substr($copyfolder2,0,strrpos($copyfolder2,"/")+1);
 $newpath="$basefolder"."$copyname";
 copydir($copyfolder2,$newpath);
 
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "'$copyfolder2' copied to '$copyname'!<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}

if($deletefolder){
 deletedir("$deletefolder");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "'$deletefolder' deleted!<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}

}//admin check bracket

include("admin_footer.php");

print "<br><br>";
tableheader1();

include("footer.php");

?>
