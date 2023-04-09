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
 print "You do not have access to the users controls";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";

}else{

$userarray=getdata("$configarray[1]/$user/main.php");

$links=" > User controls > $userarray[0]";
$pagetitle=" - User controls - $userarray[0]";

include("header.php");
include("user_header.php");

 //update account
 if($update==1){

  tableheader1();

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<p align=\"left\">";
  print "<span class=\"textlarge\">";

  if($deleteaccount=="on"){
   deleteuser($user);
   print "User deleted<br>";
  }else{
  
   $displayname=stripslashes($displayname);
   $displayname=htmlentities($displayname); 
  
   if($configarray[41]!=="off"&&$userarray[0]!==$displayname){//disp change on and different displayname
   if(strlen(trim($displayname))>=2&&strlen(trim($displayname))<=30){
   
    if(!checkdupdisplay($displayname)){
	
	 if($configarray[41]=="approve"){
     writedata("$configarray[1]/displaychange.php","$displayname",$user);
	 }else{
	 writedata("$configarray[1]/$user/main.php",$displayname,0);
	 }
    }else{
     print "Display name NOT updated: display name already used<br>";
    }

   }else{
   print "Display name NOT updated: must be 2-30chars long<br>";
   }
   }//enabled check

   $email=stripslashes($email);
   $email=htmlentities($email);
   $email=substr($email,0,100);

   if(eregi(".+@.+\..+",$email)){

    if($hideemail=="on"){
	 writedata("$configarray[1]/$user/main.php","$email\thide",2);
    }else{
     writedata("$configarray[1]/$user/main.php","$email",2);
    }

   }else{
   print "Email NOT updated: must be valid<br>";
   }

   if(strlen($signature)<$configarray[19]){
   $signature=ereg_replace("\n","",$signature);
   $signature=ereg_replace("\r","[br]",$signature);
   $signature=stripslashes($signature);
   $signature=htmlentities($signature);
   
   writedata("$configarray[1]/$user/main.php","$signature",3);
   }else{
   print "Signature NOT updated: must be less than $configarray[19] characters<br>";
   }

   if($avatarfile!==""&&$avatarfile!=="none"&&$avatarfile&&!$deleteavatar&&!$avatarurl){
   $dimarray=explode("x",$configarray[10]);
   $avatarfileinfo=getimagesize($avatarfile);
   $ext=strrchr($avatarfile_name,".");
   
    if($ext==".gif"||$ext==".jpeg"||$ext==".jpg"||$ext==".png"){
	 //file size && width && height
     if($avatarfile_size<$configarray[9]&&$avatarfileinfo[1]<=$dimarray[0]&&$avatarfileinfo[0]<=$dimarray[1]){

	  if($userarray[7]){
      @unlink("avatars/$userarray[7]");
	  }
	  @unlink("avatars/$user.$ext");
	  
      if(@move_uploaded_file($avatarfile,"avatars/".$user.$ext)){
	  @chmod("avatars/".$user.$ext,octdec(777));
	  writedata("$configarray[1]/$user/main.php",$user.$ext,7);
      print "Avatar uploaded!<br>";
      }else{
      print "Unable to upload avatar<br>";
      }

     }else{
     print "Avatar file size must be less than $configarray[9] bytes and dimensions must be less than $configarray[10]<br>"; 
     }//end dim/size check
	 
    }else{
    print "Avatar image must be gif, jpg, or png<br>";
    }//end type check

   }elseif($avatarurl&&!$avatarfile=="none"&&!$avatarfile){
    $avatarurl=stripslashes($avatarurl);
    $avatarurl=htmlentities($avatarurl);
    $avatarurl=substr($avatarurl,0,100);
    $pattern="(http://)?(.+)";
    $replace="http://\\2";
    $avatarurl=eregi_replace($pattern,$replace,$avatarurl);
	
	$dimarray=explode("x",$configarray[10]);
    $avatarfileinfo=@getimagesize($avatarurl);
    $ext=strrchr($avatarurl,".");
   
    if($ext==".gif"||$ext==".jpeg"||$ext==".jpg"||$ext==".png"){
	 //file size && width && height
     if($avatarfile_size<$configarray[9]&&$avatarfileinfo[1]<=$dimarray[0]&&$avatarfileinfo[0]<=$dimarray[1]){
   	  writedata("$configarray[1]/$user/main.php",$avatarurl,7);
     }else{
     print "Avatar file size must be less than $configarray[9] bytes and dimensions must be less than $configarray[10]<br>"; 
     }//end dim/size check
	 
    }else{
    print "Avatar image must be gif, jpg, or png<br>";
    }//end type check
	
   }

   if($deleteavatar=="on"){
   @unlink("avatars/$userarray[7]");
   writedata("$configarray[1]/$user/main.php","",7);
   print "Avatar deleted<br>";
   }

   writedata("$configarray[1]/$user/main.php","$bdaymonth\t$bdayday\t$bdayyear",8);

   $website=stripslashes($website);
   $website=htmlentities($website);
   $pattern="(http://)?(.+)";
   $replace="http://\\2";
   $website=@eregi_replace($pattern,$replace,$website);
   writedata("$configarray[1]/$user/main.php","$website",9);

   $icq=stripslashes($icq);
   $icq=htmlentities($icq);
   $icq=substr($icq,0,30);
   writedata("$configarray[1]/$user/main.php","$icq",10);
   $yim=stripslashes($yim);
   $yim=htmlentities($yim);
   $yim=substr($yim,0,30);
   writedata("$configarray[1]/$user/main.php","$yim",11);
   $aim=stripslashes($aim);
   $aim=htmlentities($aim);
   $aim=substr($aim,0,30);
   writedata("$configarray[1]/$user/main.php","$aim",12);
   $msn=stripslashes($msn);
   $msn=htmlentities($msn);
   $msn=substr($msn,0,30);
   writedata("$configarray[1]/$user/main.php","$msn",13);
   $title=stripslashes($title);
   $title=htmlentities($title);
   $titleq=substr($titleq,0,30);
   writedata("$configarray[1]/$user/main.php","$title",16);
   writedata("$configarray[1]/$user/main.php","$usertheme",17);

   $profilefieldsarray=getdata("$configarray[5]/profilefields.php");

   for($n=0;$n<count($profilefieldsarray);$n++){
   $varname="extrapf_$n";
   ${$varname}=stripslashes(${$varname});
   ${$varname}=htmlentities(${$varname});
   ${$varname}=substr(${$varname},0,30);
   writedata("$configarray[1]/$user/profilefields.php",${$varname},$n);
   }

   $userdateformat=stripslashes($userdateformat);
   $userdateformat=htmlentities($userdateformat);
   $userdateformat=substr($userdateformat,0,30);
   writedata("$configarray[1]/$user/main.php",$userdateformat,21);

   print "User info updated!<br>Changes will be seen on next page you load";
  }

 print "</span>";
 print "</p>";
 print "</td>";
 print "</tr>";
 print "</table>";

 //if update is not 1
 }else{

  if(!$delete=="on"){
  $file_uploads=ini_get("file_uploads");

  print "<form ";
  if($file_uploads){print "enctype=\"multipart/form-data\" ";}
  print "action=\"user_edit.php\" method=post>";

  print "<input type=hidden name=\"update\" value=\"1\">";
  print "<input type=hidden name=\"user\" value=\"$user\">";
  print "<input type=hidden name=\"mode\" value=\"edit\">";

  tableheader1();

  print "<tr>";
  print "<td class=\"tableheadercell\" colspan=\"2\">";
  print "<span class=\"textheader\"><b>Standard Info</b></span>";
  print "</td>";
  print "</tr>";

  if($configarray[41]!=="off"){
  print "<tr>";
  print "<td class=\"tablecell1\" width=\"20%\">";
  print "<span class=\"textlarge\">";
  print "Display name (required)";
  if($configarray[41]=="approve"){print "<br>This will be admin approved, so change is not immediate";}
  print "</span><br>";
  print "</td><td class=\"tablecell2\" width=\"80%\">";
  print "<input type=text name=\"displayname\" value=\"$userarray[0]\" size=40 class=\"forminput\">";
  print "</td>";
  print "</tr>";
  }

  print "<tr>";
  print "<td class=\"tablecell1\">";
  $emailarray=explode("\t",$userarray[2]);
  print "<span class=\"textlarge\">E-mail (required)</span><br>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"email\" value=\"$emailarray[0]\" size=40 class=\"forminput\"><br>";
  print "<span class=\"textlarge\">Hide email from public: </span>";
  if(trim($emailarray[1])=="hide"){
  print "<input type=checkbox name=\"hideemail\" checked class=\"forminput\">";
  }else{
  print "<input type=checkbox name=\"hideemail\" class=\"forminput\">";
  }
  print "</td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Title</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"title\" value=\"$userarray[16]\" size=40 class=\"forminput\">";
  print "</td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Signature<br>(max $configarray[19] chars)</span>";
  print "</td><td class=\"tablecell2\">";
  $userarray[3]=ereg_replace("\[br\]","\n",$userarray[3]);  
  print "<textarea rows=4 cols=50 name=\"signature\" class=\"forminput\">$userarray[3]</textarea>";
  print "</td></tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Avatar</span><br>";
  print "</td><td class=\"tablecell2\">";

  print "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
  print "<tr><td width=\"70%\">";
  print "<span class=\"textlarge\">";

  if($file_uploads){
   print "Upload avatar from your computer<br>";
   print "<input type=file name=\"avatarfile\" size=40 class=\"forminput\">";
  }else{
   print "<b>Avatar uploads cannot be used on this server, file_uploads is off in php ini!</b>";
  }

  print "<br><br>";
  print "or type URL address of a avatar image on the internet<br>";
  print "<input type=text name=\"avatarurl\" size=40 class=\"forminput\" ";
  if(eregi("http://(.+)",$userarray[7])){print "value=\"$userarray[7]\" ";}
  print ">";
  print "<br><br>";
  print "Delete Avatar: <input type=checkbox name=\"deleteavatar\" class=\"forminput\">";
  print "</span>";
  print "</td>";
  print "<td width=\"30%\">";
  print "<span class=\"textlarge\">";
  if($userarray[7]){
   if(eregi("http://(.+)",$userarray[7])){
    print "<img border=0 src=\"$userarray[7]\">";
   }else{
    print "<img border=0 src=\"avatars/$userarray[7]\">";
   }
  }else{
  print "No avatar";
  }
  print "</span>";
  print "</td>";
  print "</tr>";
  print "</table>";

  print "</td></tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Birthday</span><br>";
  print "</td><td class=\"tablecell2\">";
  print "<span class=\"textlarge\">";
  $currentbday=explode("\t",$userarray[8]);

  print "Month:";
  print "<select size=1 name=\"bdaymonth\" class=\"forminput\">";

  print "<option value=\" \"> </option>\n";

  for($n=1;$n<=12;$n++){
   if($n==$currentbday[0]){
   print "<option value=\"$n\" selected>$n</option>\n";
   }else{
   print "<option value=\"$n\">$n</option>\n";
   }
  }

  print "</select>\n";

  print "Day:";
  print "<select size=1 name=\"bdayday\" class=\"forminput\">";

  print "<option value=\" \"> </option>\n";

  for($n=1;$n<=31;$n++){
   if($n==$currentbday[1]){
   print "<option value=\"$n\" selected>$n</option>\n";
   }else{
   print "<option value=\"$n\">$n</option>\n";
   }
  }

  print "</select>\n";

  print "Year:";
  print "<select size=1 name=\"bdayyear\" class=\"forminput\">";

  print "<option value=\" \"> </option>\n";

  $currentyear=date("Y",time());

  for($n=$currentyear-100;$n<=$currentyear;$n++){
   if($n==$currentbday[2]){
   print "<option value=\"$n\" selected>$n</option>\n";
   }else{
   print "<option value=\"$n\">$n</option>\n";
   }
  }

  print "</select>\n";

  print "</span>";
  print "</td></tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">Website</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"website\" value=\"$userarray[9]\" size=40 class=\"forminput\"></td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">ICQ</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"icq\" value=\"$userarray[10]\" size=40 class=\"forminput\"></td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">YIM</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"yim\" value=\"$userarray[11]\" size=40 class=\"forminput\"></td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\">";
  print "<span class=\"textlarge\">AIM</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"aim\" value=\"$userarray[12]\" size=40 class=\"forminput\"></td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\"><span class=\"textlarge\">MSN</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"msn\" value=\"$userarray[13]\" size=40 class=\"forminput\"></td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\"><span class=\"textlarge\">Theme</span>";
  print "</td><td class=\"tablecell2\">";
  $themesarray=listdirs("themes");

  print "<select size=1 name=\"usertheme\" class=\"forminput\">";

  for($n=0;$n<count($themesarray);$n++){
   $userarray[17]=trim($userarray[17]);

   if($userarray[17]==$themesarray[$n]){
   print "<option value=\"$themesarray[$n]\" selected>$themesarray[$n]</option>\n";
   }else{
   print "<option value=\"$themesarray[$n]\">$themesarray[$n]</option>\n";
   }
  }

  print "</select>";
  print "</td>";
  print "</tr>";

  print "<tr>";
  print "<td class=\"tablecell1\"><span class=\"textlarge\">Date format<br>(php <a href=\"http://www.php.net/manual/en/function.date.php\" target=\"_new\">date</a> format)</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=text name=\"userdateformat\" value=\"$dateformat\" size=40 class=\"forminput\"></td>";
  print "</tr>";
  
  print "<tr>";
  print "<td class=\"tablecell1\"><span class=\"textlarge\">Delete user</span>";
  print "</td><td class=\"tablecell2\">";
  print "<input type=checkbox name=\"deleteaccount\" class=\"forminput\"></td>";
  print "</tr>";

  print "</table>";

  $profilefieldsarray=getdata("$configarray[5]/profilefields.php");
  $userprofilefieldsarray=getdata("$configarray[1]/$user/profilefields.php");

  if(count($profilefieldsarray)>0){
  print "<br><br>";

  tableheader1();
  print "<tr>";
  print "<td class=\"tableheadercell\" colspan=\"2\">";
  print "<span class=\"textheader\"><b>Extra Info</b></span>";
  print "</td>";
  print "</tr>";

  for($n=0;$n<count($profilefieldsarray);$n++){
  print "<tr>";
  print "<td class=\"tablecell1\" width=\"20%\"><span class=\"textlarge\">$profilefieldsarray[$n]</span>";
  print "</td><td class=\"tablecell2\" width=\"80%\">";
  print "<input type=text name=\"extrapf_$n\" value=\"$userprofilefieldsarray[$n]\" size=40 class=\"forminput\">";
  print "</td>";
  print "</tr>";
  }

  print "</table>";

  }//if extra pf fields

  print "<br><br>";

  tableheader1();
  print "<tr>";
  print "<td class=\"tablecell1\" colspan=\"2\">";
  print "<input type=submit name=\"submit\" value=\"Update!\" class=\"formbutton\">";

  print "</td>";
  print "</tr>";
  print "</table>";
  
  print "</form>";  

  }//delete check

 }//update check

}//access check

}//board closed check

print "<br>";
tableheader1();

require ("footer.php");
?>
