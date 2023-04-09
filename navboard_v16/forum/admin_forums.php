<?php

include("global.php");

$pagetitle=" - Administration - Forums";
$links=" > Administration > Forums";

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

 if(!isset($editforum)&&!isset($editforum2)&&!$addforum&&!$addforum2&&!isset($deleteforum)&&!isset($editorder)){
 
  tableheader1();
  print "<tr>";

   
  function forumsadminlist($parentforum,$level){
  global $configarray,$forumlist;
  
  if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   for($n=0;$n<count($forumsublist);$n++){
    $forumconfigarray=getdata("$configarray[2]/$forumsublist[$n].php");
	
      print "<td width=\"80%\" class=\"tablecell1\">";
      print "<span class=\"textlarge\">";  
	 
	  for($m=0;$m<$level;$m++){
      print "&nbsp;&nbsp;&nbsp;&nbsp;";
      }

      print "<b>$forumconfigarray[3]</b> ($forumconfigarray[5])";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"10%\" class=\"tablecell2\">";
      print "<span class=\"textlarge\">";  
	  print "ID:$forumsublist[$n]";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"10%\" class=\"tablecell2\">";
      print "<span class=\"textlarge\">";  
	  print "<a href=\"admin_forums.php?editforum=$forumsublist[$n]\">Edit</a>";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"10%\" class=\"tablecell1\">";
      print "<span class=\"textlarge\">";  
      print "<a href=\"admin_forums.php?deleteforum=$forumsublist[$n]\">Delete</a>";
	  print "</span>";
	  print "</td>";
	  print "</tr>";
	  print "<tr>";
	  
      forumsadminlist($forumsublist[$n],$level+1);
   }//loop
  }//function
  
 forumsadminlist("0",0);
 
 print "</tr>";
 print "</table>";
  
 }

 if(isset($editforum)){
 print "<form action=\"admin_forums.php\" method=post>";
 print "<input type=hidden name=\"editforum2\" value=\"$editforum\">";

 tableheader1();
 $forumconfigarray=getdata("$configarray[2]/$editforum.php");
 print "<tr>";
 print "<td class=\"tableheadercell\" colspan=\"2\">";
 print "<span class=\"textlarge\">";
 print "<b>";
 print "ID: $editforum";
 print "</b>";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Forum name";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<input type=text name=\"name\" value=\"$forumconfigarray[3]\" size=40 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Forum description";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<input type=text name=\"description\" value=\"$forumconfigarray[2]\" size=80 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Parent forum";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<select size=1 name=\"parentforum\" size=40 class=\"forminput\">";
 
 print "<option value=\"0\">No Parent</option>";
 forumsmenu(0,0,$forumconfigarray[4]);
 print "</select>";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Function";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<select size=1 name=\"function\" size=40 class=\"forminput\">\n";
 if($forumconfigarray[5]=="category"){
 print "<option value=\"forum\">Forum</option>";
 print "<option value=\"category\" selected>Category</option>";
 }else{
 print "<option value=\"forum\" selected>Forum</option>";
 print "<option value=\"category\">Category</option>";
 }
 print "</select>";
 print "</span>";
 print "</td>";
 print "</tr>";

//VIEW ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "View access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a>  don't have access to view this forum (separated by commas)<br>";
 print "<input type=text name=\"viewaccess\" value=\"$forumconfigarray[0]\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

//NEW THREAD ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "New thread access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a> don't have access to start new threads in this forum (separated by commas)<br>";
 print "<input type=text name=\"newthreadaccess\" value=\"$forumconfigarray[7]\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

//REPLY ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Reply access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a>  don't have access to reply in this forum (separated by commas)<br>";
 print "<input type=text name=\"replyaccess\" value=\"$forumconfigarray[8]\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

//EDIT ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Edit access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a> don't have access to edit their posts in this forum (separated by commas)<br>";
 print "<input type=text name=\"editaccess\" value=\"$forumconfigarray[9]\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 //SHOW ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Show access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a> don't have access to see this forum (Ex: It will be hidden to them) (separated by commas)<br>";
 print "<input type=text name=\"showaccess\" value=\"$forumconfigarray[10]\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Moderators";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "(listed as <b>userid</b> NOT username, separate each id with comma)<br>";
 print "<input type=text name=\"moderators\" value=\"$forumconfigarray[1]\" size=50 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Posts increase user post count";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 if($forumconfigarray[6]=="on"){
  print "<input type=checkbox name=\"postincrease\" class=\"forminput\" checked>";
 }else{
  print "<input type=checkbox name=\"postincrease\" class=\"forminput\">";
 }
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell2\" colspan=\"2\">";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";

 print "</td>";
 print "</tr>";
 print "</table>";

 print "</form>";
}

if(isset($editforum2)){
 $forumconfigarray=getdata("$configarray[2]/$editforum2.php");

 if($parentforum!==$forumconfigarray[4]){
  if($forumlist[$forumconfigarray[4]]){$forumsublist=@explode(",",$forumlist[$forumconfigarray[4]]);}
   for($n=0;$n<count($forumsublist);$n++){
    if($forumsublist[$n]==$editforum2){
     unset($forumsublist[$n]);
    }
   }
  $forumsubline=@implode(",",$forumsublist);
  writedata("$configarray[2]/list.php",$forumsubline,$forumconfigarray[4]);

  if($forumlist[$parentforum]){$forumsublist=@explode(",",$forumlist[$parentforum]);}
  @array_push($forumsublist,$editforum2);
  $forumsubline=@implode(",",$forumsublist);
  writedata("$configarray[2]/list.php",$forumsubline,$parentforum);
 }

 writedata("$configarray[2]/$editforum2.php",$viewaccess,0,array('forum'=>$editforum2));
 writedata("$configarray[2]/$editforum2.php",$moderators,1,array('forum'=>$editforum2));
 $varname=$forumarray[$n] . "description";
 $description=stripslashes($description);
 $description=strip_tags($description);
 $description=htmlentities($description);
 writedata("$configarray[2]/$editforum2.php",$description,2,array('forum'=>$editforum2));
 $name=stripslashes($name);
 $name=strip_tags($name);
 $name=htmlentities($name);
 writedata("$configarray[2]/$editforum2.php",$name,3);
 writedata("$configarray[2]/$editforum2.php",$parentforum,4);
 writedata("$configarray[2]/$editforum2.php",$function,5);
 writedata("$configarray[2]/$editforum2.php",$postincrease,6);
 writedata("$configarray[2]/$editforum2.php",$newthreadaccess,7);
 writedata("$configarray[2]/$editforum2.php",$replyaccess,8);
 writedata("$configarray[2]/$editforum2.php",$editaccess,9);
 writedata("$configarray[2]/$editforum2.php",$showaccess,10);


 
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Forum information updated";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if($addforum){
 print "<form action=\"admin_forums.php\" method=post>";
 print "<input type=hidden name=\"addforum2\" value=\"1\" size=40>";

 tableheader1();
 print "<tr>";
 print "<td class=\"tableheadercell\" colspan=\"2\">";
 print "<span class=\"textlarge\">";
 print "<b>";
 print "Add new forum";
 print "</b>";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Forum name";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<input type=text name=\"name\" size=40 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Forum description";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<input type=text name=\"description\" size=80 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Parent forum";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<select size=1 name=\"parentforum\" size=40 class=\"forminput\">";
 print "<option value=\"0\">No Parent</option>";
 forumsmenu(0,0);
 print "</select>";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Function";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<select size=1 name=\"function\" size=40 class=\"forminput\">\n";
 print "<option value=\"forum\" selected>Forum</option>";
 print "<option value=\"category\">Category</option>";
 print "</select>";
 print "</span>";
 print "</td>";
 print "</tr>";

//VIEW ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "View access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a>  don't have access to view this forum (separated by commas)<br>";
 print "<input type=text name=\"viewaccess\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

//NEW THREAD ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "New thread access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a> don't have access to start new threads in this forum (separated by commas)<br>";
 print "<input type=text name=\"newthreadaccess\" value=\"guest\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

//REPLY ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Reply access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a>  don't have access to reply in this forum (separated by commas)<br>";
 print "<input type=text name=\"replyaccess\" value=\"guest\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

//EDIT ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Edit access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a> don't have access to edit their posts in this forum (separated by commas)<br>";
 print "<input type=text name=\"editaccess\" size=60 value=\"guest\" class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";
 
 //SHOW ACCESS
 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Show access";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "Which <a href=\"admin_usergroups.php\">user groups</a> don't have access to see this forum (Ex: It will be hidden to them) (separated by commas)<br>";
 print "<input type=text name=\"showaccess\" size=60 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Moderators";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "(listed as <b>userid</b> NOT username, separate each id with comma)<br>";
 print "<input type=text name=\"moderators\" size=50 class=\"forminput\">";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell1\" width=\"20%\">";
 print "<span class=\"textlarge\">";
 print "Posts increase user post count";
 print "</span>";
 print "</td>";
 print "<td class=\"tablecell2\" width=\"80%\">";
 print "<span class=\"textlarge\">";
 print "<input type=checkbox name=\"postincrease\" class=\"forminput\" checked>";
 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td class=\"tablecell2\" colspan=\"2\">";
 print "<input type=submit name=\"submit\" value=\"Add forum\" class=\"formbutton\">";

 print "</td>";
 print "</tr>";
 print "</table>";

 print "</form>";
 }

 if(isset($addforum2)){
   
 @rsort($forumarray,SORT_NUMERIC);

 $newforumid=$forumarray[0]+1;

 createdir("$configarray[2]/$newforumid");

 writedata("$configarray[2]/$newforumid.php",$viewaccess,0);
 writedata("$configarray[2]/$newforumid.php",$moderators,1);
 $description=stripslashes($description);
 $description=strip_tags($description);
 $description=htmlentities($description);
 writedata("$configarray[2]/$newforumid.php",$description,2);
 $name=stripslashes($name);
 $name=strip_tags($name);
 $name=htmlentities($name);
 writedata("$configarray[2]/$newforumid.php",$name,3);
 writedata("$configarray[2]/$newforumid.php",$parentforum,4);
 writedata("$configarray[2]/$newforumid.php",$function,5);
 writedata("$configarray[2]/$newforumid.php",$postincrease,6);
 writedata("$configarray[2]/$newforumid.php",$newthreadaccess,7);
 writedata("$configarray[2]/$newforumid.php",$replyaccess,8);
 writedata("$configarray[2]/$newforumid.php",$editaccess,9);
 writedata("$configarray[2]/$newforumid.php",$showaccess,10);
 writedata("$configarray[2]/$newforumid.php","0",11);

 if($forumlist[$parentforum]){
  $forumsublist=@explode(",",$forumlist[$parentforum]);
  @array_push($forumsublist,$newforumid);
  $forumsubline=@implode(",",$forumsublist);
 }else{
  $forumsubline=$newforumid;
 }
 writedata("$configarray[2]/list.php",$forumsubline,$parentforum);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "New forum created!";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

}

if(isset($deleteforum)){

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  
  $forumconfigarray=allforumconfigarray($deleteforum);
  if($forumlist[$forumconfigarray[4]]){$forumsublist=@explode(",",$forumlist[$forumconfigarray[4]]);}
   for($n=0;$n<count($forumsublist);$n++){
    if($forumsublist[$n]==$deleteforum){
     unset($forumsublist[$n]);
    }
  }
  $forumsubline=@implode(",",$forumsublist);
  writedata("$configarray[2]/list.php",$forumsubline,$forumconfigarray[4]);

  $threadarray=listdirs("$configarray[2]/$deleteforum");
   for($n=0;$n<count($threadarray);$n++){
   $postarray=listfiles("$configarray[2]/$deleteforum/$threadarray[$n]");
    for($m=0;$m<count($postarray);$m++){
	 @unlink("$configarray[2]/$deleteforum/$threadarray[$n]/$postarray[$m].php");
	}
   @rmdir("$configarray[2]/$deleteforum/$threadarray[$n]");
   }
  $threadcfgarray=listfiles("$configarray[2]/$deleteforum");
   for($n=0;$n<count($threadcfgarray);$n++){
   @unlink("$configarray[2]/$deleteforum/$threadcfgarray[$n].php");
   }
  @unlink("$configarray[2]/$deleteforum.php");
  @rmdir("$configarray[2]/$deleteforum");

  print "Forum '$deleteforum' deleted";

 print "</span>";

 print "</td>";
 print "</tr>";
 print "</table>";

}//remove bracket

if($editorder=="1"){

  tableheader1();
  print "<form action=\"admin_forums.php\" method=post>";
  print "<input type=hidden name=\"editorder\" value=\"2\" size=40>";
  
  print "<td colspan=\"4\" class=\"tableheadercell\">";
  print "<span class=\"textlarge\">";
  print "<b>Forum ordering</b><br>";
  print "Top most is to the left, bottom most is to the right<br>";
  print "Enter in list as ID number, separated by commas";
  print "</span>";
  print "</td>";
  print "</tr>"; 
  
  	  print "<tr>";
      print "<td width=\"30%\" class=\"categorycell\">";
      print "<span class=\"textlarge\">";  
      print "<b>Forum name</b>";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"10%\" class=\"categorycell\">";
      print "<span class=\"textlarge\">";  
	  print "<b>Forum ID</b>";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"30%\" class=\"categorycell\">";
      print "<span class=\"textlarge\">";  
      print "<b>Current sub forums order</b>";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"30%\" class=\"categorycell\">";
      print "<span class=\"textlarge\">";  
      print "<b>New sub forums order</b>";
	  print "</span>";
	  print "</td>";
	  print "</tr>";
	  
	  print "<tr>";
      print "<td width=\"30%\" class=\"tablecell1\">";
      print "<span class=\"textlarge\">";  
	 
	  for($m=0;$m<$level;$m++){
      print "&nbsp;&nbsp;&nbsp;&nbsp;";
      }

      print "<b>Parent forum (top level)</b>";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"10%\" class=\"tablecell2\">";
      print "<span class=\"textlarge\">";  
	  print "0";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"30%\" class=\"tablecell1\">";
      print "<span class=\"textlarge\">";
      print $forumlist[0]."&nbsp;";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"30%\" class=\"tablecell2\">";
      print "<span class=\"textlarge\">";
	  print "<input type=text name=\"order0\" value=\"".$forumlist[0]."\" size=20 class=\"forminput\">";
	  print "</span>";
	  print "</td>";
	  print "</tr>";
     
  function forumsorderlist($parentforum,$level){
  global $configarray,$forumlist;
  
  if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   for($n=0;$n<count($forumsublist);$n++){
    $forumconfigarray=getdata("$configarray[2]/$forumsublist[$n].php");
	
	  print "<tr>";
      print "<td width=\"30%\" class=\"tablecell1\">";
      print "<span class=\"textlarge\">";  
	 
	  for($m=0;$m<$level;$m++){
      print "&nbsp;&nbsp;&nbsp;&nbsp;";
      }

      print "<b>$forumconfigarray[3]</b>";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"10%\" class=\"tablecell2\">";
      print "<span class=\"textlarge\">";  
	  print "$forumsublist[$n]";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"30%\" class=\"tablecell1\">";
      print "<span class=\"textlarge\">";
      print $forumlist[$forumsublist[$n]]."&nbsp;";
	  print "</span>";
	  print "</td>";
	  print "<td width=\"30%\" class=\"tablecell2\">";
      print "<span class=\"textlarge\">";
	  print "<input type=text name=\"order$forumsublist[$n]\" value=\"".$forumlist[$forumsublist[$n]]."\" size=20 class=\"forminput\">";
	  print "</span>";
	  print "</td>";
	  print "</tr>";
	  
      forumsorderlist($forumsublist[$n],$level+1);
   }//loop
  }//function
  
 forumsorderlist("0",0);
 
 print "<tr>";
 print "<td class=\"tablecell2\" colspan=\"4\">";
 print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
 print "</td>";
 print "</tr>";
 print "</table>";

}//order bracket

if($editorder=="2"){

  $orderarray=explode(",",$order0);
  for($n=0;$n<count($orderarray);$n++){
   writedata("$configarray[2]/$orderarray[$n].php","0",4);
  }

  writedata("$configarray[2]/list.php",$order0,0);

  function forumsorderlist2($parentforum,$level){
  global $configarray,$forumlist;
  
  if($forumlist[$parentforum]){$forumsublist=explode(",",$forumlist[$parentforum]);}
   for($n=0;$n<count($forumsublist);$n++){
    writedata("$configarray[2]/$forumsublist[$n].php",$parentforum,4);
    $forumconfigarray=getdata("$configarray[2]/$forumsublist[$n].php");
	
	  $val="order".$forumsublist[$n];
	  global ${$val};
	  writedata("$configarray[2]/list.php",${$val},$forumsublist[$n]);
	  
      forumsorderlist2($forumsublist[$n],$level+1);
   }//loop
  }//function
  
 forumsorderlist2("0",0);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\" colspan=\"4\">";
 print "<span class=\"textlarge\">Forum ordering updated</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 
}//order2 bracket

}//admin check bracket

include("admin_footer.php");

print "<br><br>";
tableheader1();

include("footer.php");

?>
