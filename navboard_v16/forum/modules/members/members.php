<?php

include("modules/members/global.php");

$pagetitle=" - Members";
$links=" > Members";

include("header.php");

if(!$mode){$mode="alpha";}

if($mode=="ida"||$mode=="idd"){

  for($n=0;$n<count($usersarray);$n++){
  $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");

  $idarray[$usersarray[$n]]=$usersarray[$n];
  }


 if($mode=="ida"){@asort($idarray);}
 if($mode=="idd"){@arsort($idarray);}
 $orderarray=@array_keys($idarray);

}

if($mode=="alpha"||$mode=="reversealpha"){

  for($n=0;$n<count($usersarray);$n++){

  $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");

  $username=$usersarray[$n];

  $displaynamearray["$username"]=$userarray[0];
  }


 if($mode=="alpha"){@asort($displaynamearray);}
 if($mode=="reversealpha"){@arsort($displaynamearray);}

 $orderarray=@array_keys($displaynamearray);

}

if($mode=="postsa"||$mode=="postsd"){

  //create array of post count from each user
  for($n=0;$n<count($usersarray);$n++){

  $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");

  $username=$usersarray[$n];

  $postcountarray["$username"]=$userarray[6];

  }

  if($mode=="postsa"){@asort($postcountarray);}
  if($mode=="postsd"){@arsort($postcountarray);}
  $orderarray=@array_keys($postcountarray);

}

if($mode=="rega"||$mode=="regd"){

  //create array of post count from each user

  for($n=0;$n<count($usersarray);$n++){

  $userarray=getdata("$configarray[1]/$usersarray[$n]/main.php");

  $userid=$usersarray[$n];

  $regarray["$userid"]=$userarray[4];

  }

  if($mode=="rega") {@asort($regarray);}
  if($mode=="regd") {@arsort($regarray);}

  $orderarray=array_keys($regarray);
}

tableheader1();
print "<tr>";

print "<td width=\"5%\" class=\"tableheadercell\"><span class=\"textheader\">";
print "<p align=\"center\">";
print "<b>";
if($mode=="ida"){
print "<a href=\"modules.php?module=members&mode=idd\">ID #</a>";
}else{
print "<a href=\"modules.php?module=members&mode=ida\">ID #</a>";
}
print "</b></p></span></td>";

print "<td width=\"15%\" class=\"tableheadercell\"><span class=\"textheader\">";
print "<p align=\"center\">";
print "<b>";
if($mode=="alpha"){
print "<a href=\"modules.php?module=members&mode=reversealpha\">Name</a>";
}else{
print "<a href=\"modules.php?module=members&mode=alpha\">Name</a>";
}
print "</b></p></span></td>";

print "<td width=\"12%\" class=\"tableheadercell\"><span class=\"textheader\">";
print "<p align=\"center\">";
print "<b>";
print "E-mail";
print "</b></p></span></td>";

print "<td width=\"5%\" class=\"tableheadercell\"><span class=\"textheader\">";
print "<p align=\"center\">";
print "<b>";
if($mode=="postsd"){
print "<a href=\"modules.php?module=members&mode=postsa\">Posts</a>";
}else{
print "<a href=\"modules.php?module=members&mode=postsd\">Posts</a>";
}
print "</b></p></span></td>";

print "<td width=\"15%\" class=\"tableheadercell\"><span class=\"textheader\">";
print "<p align=\"center\">";
print "<b>";
if($mode=="rega"){
print "<a href=\"modules.php?module=members&mode=regd\">Registered</a>";
}else{
print "<a href=\"modules.php?module=members&mode=rega\">Registered</a>";
}
print "</b></p></span></td>";

print "<td width=\"10%\" class=\"tableheadercell\"><span class=\"textheader\">";
print "<p align=\"center\">";
print "<b>";
print "Group";
print "</b></p></span></td>";

print "</tr>";

if(!$page){$page=1;}

   for($n=($page-1)*$membersmoduleconfig[0];$n<count($orderarray)&&$n<(($page-1)*$membersmoduleconfig[0])+$membersmoduleconfig[0];$n++){
   $txtarray=getdata("$configarray[1]/$orderarray[$n]/main.php");

   print "<tr>";

   print "<td class=\"tablecell1\"><span class=\"textlarge\">";
   print "<p align=\"center\">";
   print "$orderarray[$n]";
   print "</p></span></td>";

   print "<td class=\"tablecell1\"><span class=\"textlarge\">";
   print "<p align=\"center\">";
   print "<a href=\"profile.php?user=$orderarray[$n]\">$txtarray[0]</a>";
   print "</p></span></td>";

   print "<td class=\"tablecell2\"><span class=\"textlarge\">";
   $emailarray=explode("\t",$txtarray[2]);
   if($emailarray[1]=="hide")
   {
   print "hidden";
   }else{
   print "$emailarray[0]";
   }
   print "</span></td>";

   print "<td class=\"tablecell1\"><span class=\"textlarge\">";
   print "<p align=\"center\">";
   print "$txtarray[6]";
   print "</p></span></td>";

   $date=date($dateformat,$txtarray[4]);
   print "<td class=\"tablecell2\"><span class=\"textlarge\">$date</span></td>";

   print "<td class=\"tablecell2\"><span class=\"textlarge\">$txtarray[15]</span></td>";
   print "</tr>";
   }

  print "</table>";

  print "<br><br>";

  tableheader1();

  print "<tr>";
  print "<td class=\"tablecell1\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

  print "<tr>";
  print "<td width=\"50%\">";

  print "&nbsp";

  print "</td>";

  print "<td width=\"50%\" height=\"1\">";
  print "<span class=\"textsmall\">";
  print "<p align=\"right\">";
  print "Page: ";
  $page2=1;

  for($n=0;$n<count($orderarray);$n+=$membersmoduleconfig[0]){

   if($n==($page-1)*$membersmoduleconfig[0]) {
   print "<b>$page2</b> ";
   }else{
   print "<a href=\"modules.php?module=members&mode=$mode&page=$page2\">$page2</a> ";
   }

  $page2++;
  }

  print "</p>\n";
  print "</span>";
  print "</td>";
  print "</tr>";

  print "</table>";

  print "</td>";
  print "</tr>";

  print "</table>";

  print "<br><br>";

  tableheader1();


require ("footer.php");
?>
