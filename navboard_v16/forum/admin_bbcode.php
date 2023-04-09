<?php

include("global.php");

$pagetitle=" - Administration - BBCode";
$links=" > Administration > BBCode";

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

if(!$addbbcode&&!isset($editbbcode)&&!isset($deletebbcode)&!$addbbcode2&&!isset($editbbcode2)){

 $bbcodearray=getdata("$configarray[5]/bbcode.php");

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

   for($n=0;$n<count($bbcodearray);$n++){
    $linearray=explode("\t",$bbcodearray[$n]);

    if(count($linearray)>1){

    print "<b>$linearray[0]</b>\n";
    print " | <a href=\"admin_bbcode.php?editbbcode=$n\">Edit</a>";
    print " | <a href=\"admin_bbcode.php?deletebbcode=$n\">Delete</a>";

    print "<br><br>";
    }

   }//end bbcode loop

  print "<br><br>";
  print "<a href=\"admin_bbcode.php?addbbcode=1\">Add new</a>";

   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($editbbcode)){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 $bbcodearray=getdata("$configarray[5]/bbcode.php");
 $linearray=explode("\t",$bbcodearray[$editbbcode]);

 print "<form action=\"admin_bbcode.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"editbbcode2\" value=\"$editbbcode\" size=40>";

 print "Edit bbcode $editbbcode<br><br>";

 print "Description of bbcode (this tells members how to use the bbcode)<br>";
 print "Example: for images '[img]imglocation[/img]' or url '[url=address]site title[/url]'<br>";
 $linearray[0]=htmlentities($linearray[0]);
 print "<input type=text name=\"bbcodedesc\" size=40 value=\"$linearray[0]\" class=\"forminput\"><br><br>";

 print "BBCode tag (the text to use inside the tag<br>";
 print "Example: for bold the tag would be 'b' which would be put into the [] brackets making the full tag [b]<br>";
 print "For [url] you would just use 'url'<br>";
 print "<input type=text name=\"bbcodetag\" size=40 value=\"$linearray[1]\" class=\"forminput\"><br><br>";

 print "Use parameter (if you want to have extra info in the bbcode tag<br>";
 print "Example: for url tag ([url]) this would allow you to have more info like [url=address] in the starting tag<br>";
 print "For the bold tag b ([b]) you dont need a extra parameter<br>";

 if($linearray[2]=="on"){
 print "<input type=checkbox name=\"bbcodeparamter\" class=\"forminput\" checked>";
 }else{
 print "<input type=checkbox name=\"bbcodeparameter\" class=\"forminput\">";
 }
 print "<br><br>";

 print "HTML Code<br>";
 print "This is what will actually replace the bbcode<br>";
 print "The place where you want the main text to go put {option}<br>";
 print "If you have a parameter, put {param} where you want that text to go<br>";
 print "Example: for url it would be &lta href=\"{param}\"&gt {option}&lt/a&gt<br>";
 print "For something like italic ([i]) &lti&gt{option}&lt/i&gt no parameter needed<br>";
 $linearray[3]=htmlentities($linearray[3]);
 print "<input type=text name=\"bbcodehtml\" size=40 value=\"".$linearray[3]."\" class=\"forminput\"><br><br>";

 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</span>"; 
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($editbbcode2)){
 $bbcodedesc=stripslashes($bbcodedesc);
 $bbcodetag=stripslashes($bbcodetag);
 $bbcodehtml=stripslashes($bbcodehtml);
 writedata("$configarray[5]/bbcode.php","$bbcodedesc\t$bbcodetag\t$bbcodeparameter\t$bbcodehtml",$editbbcode2);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "BBCode edited - <a href=\"admin_bbcode.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";


 }

 if($addbbcode=="1"){

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";

 print "<form action=\"admin_bbcode.php\" method=post>";
 print "<span class=\"textlarge\">";
 print "<input type=hidden name=\"addbbcode\" value=\"2\" size=40>";
 print "<input type=hidden name=\"tags\" value=\"$tags\" size=40>";

 print "Add bbcode<br><br>";

 print "Description of bbcode (this tells members how to use the bbcode)<br>";
 print "Example: for images '[img]imglocation[/img]' or url '[url=address]site title[/url]'<br>";
 print "<input type=text name=\"bbcodedesc\" size=40 class=\"forminput\"><br><br>";

 print "BBCode tag (the text to use inside the tag<br>";
 print "Example: for bold the tag would be 'b' which would be put into the [] brackets making the full tag [b]<br>";
 print "For [url] you would just use 'url'<br>";
 print "<input type=text name=\"bbcodetag\" size=40 class=\"forminput\"><br><br>";

 print "Use parameter (if you want to have extra info in the bbcode tag<br>";
 print "Example: for url tag ([url]) this would allow you to have more info like [url=address] in the starting tag<br>";
 print "For the bold tag b ([b]) you dont need a extra parameter<br>";

 print "<input type=checkbox name=\"bbcodeparameter\" class=\"forminput\">";
 print "<br><br>";

 print "HTML Code<br>";
 print "This is what will actually replace the bbcode<br>";
 print "The place where you want the main text to go put {option}<br>";
 print "If you have a parameter, put {param} where you want that text to go<br>";
 print "Example: for url it would be &lta href=\"{param}\"&gt {option}&lt/a&gt<br>";
 print "For something like italic ([i]) &lti&gt{option}&lt/i&gt no parameter needed<br>";
 print "<input type=text name=\"bbcodehtml\" size=40 class=\"forminput\"><br><br>";

 print "<br>";
 print "<input type=submit name=\"submit\" value=\"Add bbcode\" class=\"formbutton\">";
 print "</span>";
 print "</form>";

 print "</td>";
 print "</tr>";
 print "</table>";

 }

 if($addbbcode=="2"){
 $bbcodearray=getdata("$configarray[5]/bbcode.php");
 $end=count($bbcodearray);

 $bbcodedesc=stripslashes($bbcodedesc);
 $bbcodetag=stripslashes($bbcodetag);
 $bbcodehtml=stripslashes($bbcodehtml);
 writedata("$configarray[5]/bbcode.php","$bbcodedesc\t$bbcodetag\t$bbcodeparameter\t$bbcodehtml",$end);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "BBCode added - <a href=\"admin_bbcode.php\">Back to listing</a>";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }

 if(isset($deletebbcode)){
 deletedata("$configarray[5]/bbcode.php",$deletebbcode);

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "BBCode $deletebbcode deleted - <a href=\"admin_bbcode.php\">Back to listing</a>";
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