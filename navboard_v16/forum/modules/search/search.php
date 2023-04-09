<?php

include("modules/search/global.php");

$links=" > Search";
$pagetitle=" - Search";

include("header.php");

 if(!$keyword){
 global $stylearray;

 tableheader1();

 print "<form action=\"modules.php?module=search\" method=\"post\">";
 print "<tr>";

 $searcharray[0]="profiles	0	Profiles: Display Name";
 $searcharray[1]="profiles	15	Profiles: Group";
 $searcharray[2]="posts	0	Posts: User (user id)";
 $searcharray[3]="posts	2	Posts: Subject";
 $searcharray[4]="posts	3	Posts: Body";

 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">Search word (not case sensitive)</span><br>";
 print "<span class=\"textlarge\">";
 print "<input type=text name=\"keyword\" size=40 class=\"forminput\">";
 print "<br><br>";
 print "Search in:<br>";

 print "<select size=1 name=\"searchin\" class=\"forminput\">";

 for($n=0;$n<count($searcharray);$n++){
  $searchlinearray=explode("\t",$searcharray[$n]);
  print "<option value=\"$searchlinearray[0]-$searchlinearray[1]\">$searchlinearray[2]</option>\n";
 }

 print "</select>\n";

 print "</span>";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell2\"><input type=submit name=\"submit\" value=\"Search!\" class=\"formbutton\"></td>";
 print "</form>";
 print "</tr>";
 print "</table>";

 print "<br><br>";
 
 tableheader1();
 }

 if($keyword&&$searchin){

 $searchinarray=explode("-",$searchin);

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Search results for '$keyword' in '$searchinarray[0]':";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

 print "<br><br>";

 if($searchinarray[0]=="posts"){

 $k=$searchinarray[1];
 unset($searcharray);
 
  for($n=0;$n<count($forumarray);$n++){
  $threadarray=listdirs("$configarray[2]/$forumarray[$n]");

   for($m=0;$m<count($threadarray);$m++){
   $postarray=listfiles("$configarray[2]/$forumarray[$n]/$threadarray[$m]");

    for($l=0;$l<count($postarray);$l++){
    $indpostarray=getdata("$configarray[2]/$forumarray[$n]/$threadarray[$m]/$postarray[$l].php");

     if(stristr($indpostarray[$k],$keyword)){
     $searcharray[]="$forumarray[$n]\t$threadarray[$m]\t$postarray[$l]";
     break;
     }

    }

   }

  }

}

 if($searchinarray[0]=="profiles"){

 $k=$searchinarray[1];
 $l=0;

   for($m=0;$m<count($usersarray);$m++){

   $userarray=getdata("$configarray[1]/$usersarray[$m]/main.php");

     if(stristr($userarray[$k],$keyword)){

     $searcharray[$l]=$usersarray[$m];

     $l++;
     }

   }

  }

if($searchinarray[0]=="profiles"){

 tableheader1();

 print "<tr bgcolor=\"$stylearray[6]\">";
 print "<td width=\"34%\" class=\"tableheadercell\"><span class=\"textheader\"><b>Username</b></span></td>";
 print "<td width=\"33%\" class=\"tableheadercell\"><span class=\"textheader\"><b>Group</b></span></td>";
 print "<td width=\"33%\" class=\"tableheadercell\"><span class=\"textheader\"><b>Location</b></span></td>";
 print "</tr>";

}

if($searchinarray[0]=="posts"){

 tableheader1();

 print "<tr bgcolor=\"$stylearray[6]\">";
 print "<td width=\"34%\" class=\"tableheadercell\"><span class=\"textheader\"><b>Thread Title</b></span></td>";
 print "<td width=\"33%\" class=\"tableheadercell\"><span class=\"textheader\"><b>Thread Starter</b></span></td>";
 print "<td width=\"33%\" class=\"tableheadercell\"><span class=\"textheader\"><b>Forum</b></span></td>";
 print "</tr>";

}

if(!$page){$page=1;}

for($n=($page-1)*$searchmoduleconfig[0];$n<count($searcharray)&&$n<(($page-1)*$searchmoduleconfig[0])+$searchmoduleconfig[0];$n++){

  if($searchinarray[0]=="profiles"){

     $userarray=getdata("$configarray[1]/$searcharray[$n]/main.php");

     print "<tr>";
     print "<td width=\"34%\" class=\"tablecell1\"><span class=\"textlarge\"><a href=\"profile.php?user=$searcharray[$n]\">$userarray[0]</a></span></td>";
     print "<td width=\"33%\" class=\"tablecell2\"><span class=\"textlarge\">$userarray[15]</span></td>";
     print "<td width=\"33%\" class=\"tablecell1\"><span class=\"textlarge\">";
     if($userarray[14]){
     print "$userarray[14]";
     }else{
     print "&nbsp";
     }
     print "</span></td>";
     print "</tr>";

  }

  if($searchinarray[0]=="posts"){

     $searcharray2=explode("\t",$searcharray[$n]);
     $firstpostarray=getdata("$configarray[2]/$searcharray2[0]/$searcharray2[1]/0.php");

     print "<tr>";
     $threadid=substr($searcharray2[1],0,-4);
	 $firstpostarray[2]=htmlentities($firstpostarray[2]);
	 $topicnum=topic_timetonum($searcharray2[0],$searcharray2[1]);
     print "<td width=\"34%\" class=\"tablecell1\"><span class=\"textlarge\"><a href=\"index.php?forum=$searcharray2[0]&topic=$topicnum&highlight=$keyword\">$firstpostarray[2]</a></span></td>";

     $userarray=getdata("$configarray[1]/$firstpostarray[0]/main.php");
     print "<td width=\"33%\" class=\"tablecell2\"><span class=\"textlarge\">";

      if(count($userarray)>0){
      print "<a href=\"profile.php?user=$firstpostarray[0]\">$userarray[0]</a>";
      }else{
      print "Guest";
      }

     print "</span></td>";

     $forumconfigarray=getdata("$configarray[2]/$searcharray2[0].php");
     print "<td width=\"33%\" class=\"tablecell1\"><span class=\"textlarge\">$forumconfigarray[3]</span></td>";
     print "</tr>";

  }

}

  print "</table>";

  print "<br><br>";

  tableheader1();

  print "<tr>";
  print "<td class=\"tablecell2\">";

  print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

  print "<tr>";
  print "<td width=\"50%\">";

  print "&nbsp";

  print "</td>";

  print "<td width=\"50%\">";
  print "<p align=\"right\">";
  print "<span class=\"textsmall\">";
  print "Page: ";
  $page2=1;

  for($n=0;$n<count($searcharray);$n+=$searchmoduleconfig[0]){

   if($n==($page-1)*$searchmoduleconfig[0]) {
   print "<b>$page2</b> ";
   }else{
   print "<a href=\"modules.php?module=search&keyword=$keyword&searchin=$searchin&page=$page2\">$page2</a> ";
   }

  $page2++;
  }

  print "</span>";
  print "</p>\n";
  print "</td>";
  print "</tr>";

  print "</table>";

  print "</td>";
  print "</tr>";

  print "</table>";

  print "<br><br>";

  tableheader1();

}


require ("footer.php");
?>
