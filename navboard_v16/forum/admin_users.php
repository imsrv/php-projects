<?php

include("global.php");

$pagetitle=" - Administration - Users";
$links=" > Administration > Users";

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

if(!$edituser&&!$edituser2&&!isset($ban)&&!$unban&&!$action&&!isset($showuser)){

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "For deleting and adding, use the in forum functions<br><br>";

  print "Edit user (id,display,account):";
  print "</span>";

  print "<form action=\"admin_users.php\" method=post>";
  print "<span class=\"textlarge\">";

  print "<select size=1 name=\"showuser\" class=\"forminput\">";

  @sort($usersarray,SORT_NUMERIC);

  for($n=0;$n<count($usersarray);$n++){
  $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");
  $username=$userkeyarray[$usersarray[$n]];
  print "<option value=\"$usersarray[$n]\">$usersarray[$n], $userarray[0], $username</option>";
  }

  print "</select>";

  print "<br>";
  print "<input type=submit name=\"submit\" value=\"Continue\" class=\"formbutton\">";
  print "</span>";
  print "</form>";

  print "</td>";
  print "</tr>";
  print "</table>";
}


if(isset($showuser)){

    $userarray=getdata("$configarray[1]/$showuser/main.php");
	
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

    if(count($userarray)>0){

    $username=$userkeyarray[$showuser];

    print "<b>Username: $username, Displayname: $userarray[0], UserID: $showuser</b>";
    print "<br><br>";

    if(@in_array($showuser,$banarray)){
    print "<a href=\"admin_users.php?unban=$showuser\">Unban by userid</a>";
    }else{
    print "<a href=\"admin_users.php?ban=$showuser\">Ban by userid</a>";
    }

    if(@in_array($userarray[19],$banarray)){
    print " | <a href=\"admin_users.php?unban=$userarray[19]\">Unban by IP</a>";
    }else{
    print " | <a href=\"admin_users.php?ban=$userarray[19]\">Ban by IP</a>";
    }

    $emailarray=explode("\t",$userarray[2]);

    if(@in_array($emailarray[0],$banarray)){
    print " | <a href=\"admin_users.php?unban=$emailarray[0]\">Unban by email</a>";
    }else{
    print " | <a href=\"admin_users.php?ban=$emailarray[0]\">Ban by email</a>";
    }

    print "<br><br>";

    print " <a href=\"admin_users.php?action=updatepostcount&user=$showuser\">Update post count to what is on forum</a>";
    
	print "<br><br>";
	print "<b>Advanced user details</b><br>";
	print "For more common options like profile details and passwords and buddy lists, ";
	print "<a href=\"user_edit.php?user=$showuser\">edit the user</a> normally through the forum<br><br>";
	
    print "<form action=\"admin_users.php\" method=post>";
    print "<input type=hidden name=\"edituser\" value=\"$showuser\" size=40>";
	
	print "Registration Timestamp<br>";
	print "<input type=text name=\"registeredtime\" value=\"$userarray[4]\" class=\"forminput\" size=\"40\"><br>";
	print "Previous Login Timestamp (tab separated) Most recent activity timestamp<br>";
	print "<input type=text name=\"previousandrecenttime\" value=\"$userarray[5]\" class=\"forminput\" size=\"40\"><br>";
	print "Post count<br>";
	print "<input type=text name=\"postcount\" value=\"$userarray[6]\" class=\"forminput\" size=\"40\"><br>";
	print "User group<br>";
    print "<select name=\"usergroup\" class=\"forminput\">";
	
	if($userarray[15]=="registered")
	{print "<option value=\"registered\" selected>registered</option>";}
	else{print "<option value=\"registered\">registered</option>";}
	
	if($userarray[15]=="administrator")
	{print "<option value=\"administrator\" selected>administrator</option>";}
	else{print "<option value=\"administrator\">administrator</option>";}
	
    if($userarray[15]=="confirm")
	{print "<option value=\"confirm\" selected>confirm</option>";}
	else{print "<option value=\"confirm\">confirm</option>";}
	
	$usergroupsarray=getdata("$configarray[1]/usergroups.php");
	 for($n=0;$n<count($usergroupsarray);$n++){
	  if($userarray[15]==$usergroupsarray[$n])
	  {print "<option value=\"$usergroupsarray[$n]\" selected>$usergroupsarray[$n]</option>";}
	  else{print "<option value=\"$usergroupsarray[$n]\">$usergroupsarray[$n]</option>";}
	 }
	print "</select><br>";
	print "Last post timestamp<br>";
	print "<input type=text name=\"lastposttime\" value=\"$userarray[18]\" class=\"forminput\" size=\"40\"><br>";
	print "Last IP<br>";
	print "<input type=text name=\"lastip\" value=\"$userarray[19]\" class=\"forminput\" size=\"40\"><br>";
	
    print "<br><br>";
    print "<input type=submit name=\"submit\" value=\"Update\" class=\"formbutton\">";
    print "</form>";
	
	}else{
    Print "User does not exist";
    }
   
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";

 }
 
 if($edituser){
  writedata("$configarray[1]/$edituser/main.php",$registeredtime,4);
  writedata("$configarray[1]/$edituser/main.php",$previousandrecenttime,5);
  writedata("$configarray[1]/$edituser/main.php",$postcount,6);
  writedata("$configarray[1]/$edituser/main.php",$usergroup,15);
  writedata("$configarray[1]/$edituser/main.php",$lastposttime,18);
  writedata("$configarray[1]/$edituser/main.php",$lastip,19);

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">";
  print "User edited - <a href=\"admin_users.php\">Back to listing</a> - <a href=\"admin_users.php?showuser=$edituser\">Back to user</a>";
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";
 }

 if(isset($ban)){
 
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 if(!@in_array($ban,$banarray)){
 writedata("$configarray[1]/ban.php",$ban,count($banarray));
 print "'$ban' has been added to ban list";
 }else{
 print "'$ban' is already in ban list";
 }
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }

 if(isset($unban)){

 for($n=0;$n<count($banarray);$n++){

  if($banarray[$n]==$unban){
  deletedata("$configarray[1]/ban.php",$n);
  }

 }

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "'$unban' has been removed from ban list";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 }

if($action=="updatepostcount"){
$posts=0;

 for($m=0;$m<count($forumarray);$m++){
 $forumconfigarray=getdata("$configarray[2]/$forumarray[$m].php");

  if($forumconfigarray[6]=="on"){
  $threadarray=listdirs("$configarray[2]/$forumarray[$m]");

  for($n=0;$n<count($threadarray);$n++){
   $postarray=listfiles("$configarray[2]/$forumarray[$m]/$threadarray[$n]");
    
   for($l=0;$l<count($postarray);$l++){
    $indpostarray=getdata("$configarray[2]/$forumarray[$m]/$threadarray[$n]/$postarray[$l].php");

    if($indpostarray[0]=="$user"){
     $posts++;
    }

   }//post loop

  }//thread loop

  }//post increase check

 }//forum loop

writedata("$configarray[1]/$user/main.php",$posts,6);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "User '$user' post count has been recounted at '$posts' posts";
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
