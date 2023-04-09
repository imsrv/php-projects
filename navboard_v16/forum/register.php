<?php
include("global.php");

$links=" > Register";
$pagetitle=" - Register";

include("header.php");

if($configarray[40]){
 tableheader1();
 print "<tr><td class=\"tablecell1\"><span class=\"textlarge\">";
 print "<b>Board closed:</b><br>$configarray[40]";
 print "</span></td></tr></table>";
}else{

 if($step==""){
 
 tableheader1();
 print "<form action=\"register.php\" method=\"post\">";
 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">User name (required) This is what you will login with 2-30chars</span><br>";
 print "<input type=text name=\"username\" size=30 class=\"forminput\"><br></td>";
 print "</tr>";

 if($configarray[41]!=="off"){
 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell2\"><span class=\"textlarge\">Display name (required) This is what all other users will see 2-30chars</span><br>";
 print "<input type=text name=\"displayname\" size=30 class=\"forminput\"><br></td>";
 print "</tr>";
 }

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\"><span class=\"textlarge\">Password/Confirm password (required) 2-30chars</span><br>";
 print "<input type=password name=\"password\" size=30 class=\"forminput\">";
 print "---<input type=password name=\"passwordconfirm\" size=30 class=\"forminput\">";
 print "</td>";
 print "</tr>";

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell2\"><span class=\"textlarge\">";
 print "E-mail (required)<br>";
 if($configarray[39]=="confirm"){print "Note: Accounts will be confirmed through email so this MUST be valid!<br>";}
 print "</span>";
 print "<input type=text name=\"email\" size=40 class=\"forminput\"><br></td>";
 print "</tr>";

 print "</table>";

 print "<br><br>";

 tableheader1();

 print "<tr>";
 print "<td width=\"100%\" class=\"tablecell1\">";
 if($configarray[39]=="approve"){print "<span class=\"textlarge\">Note: Accounts are admin approved!</span><br>";}
 print "<input type=submit name=\"submit\" value=\"Submit!\" class=\"formbutton\"></td>";
 print "</form>";
 print "</tr>";
 print "</table>";
 }

 if($step==2){
 
 if($configarray[41]=="off"){
 $displayname=$username;
 }
 
 $username=trim($username);
 $displayname=trim($displayname);
 $password=trim($password);
 
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";

 @rsort($usersarray,SORT_NUMERIC);
 $userarray=getdata("$configarray[1]/$usersarray[0]/main.php");
 @sort($usersarray,SORT_NUMERIC);
 $time=time();
 if(($userarray[4]+$configarray[38])<$time){

 if($username && $password && $email && $displayname){
 
 if(!checkban($username,$REMOTE_ADDR,$email,"")){
 
  if($useridarray[$username]==""){
 
   $user="-1";
   if(!checkdupdisplay($displayname)){

   if($password==$passwordconfirm){

    if(strlen(trim($username))>=2&&strlen(trim($username))<=30&&strlen(trim($password))>=2&&strlen(trim($password))<=30&&strlen(trim($displayname))>=2&&strlen(trim($password))<=30){

     if(eregi(".+@.+",$email)){

     if(count($usersarray)<=0){
     $newuserid=1;
     }else{
     @rsort($usersarray,SORT_NUMERIC);
     $newuserid=$usersarray[0]+1;
     @sort($usersarray,SORT_NUMERIC);
     }
	   createdir("$configarray[1]/$newuserid");

     $time=time();
     $username=stripslashes($username);
     $username=htmlentities($username);
     writedata("$configarray[1]/accounts.php",$username,$newuserid);

     $displayname=stripslashes($displayname);
     $displayname=htmlentities($displayname);
     writedata("$configarray[1]/$newuserid/main.php",$displayname,0);
     $password=stripslashes($password);
     $password=htmlentities($password);
	   $passwordbefore=$password;
     $password=md5($password);
     writedata("$configarray[1]/$newuserid/main.php",$password,1);
     $email=stripslashes($email);
     $email=htmlentities($email);
     writedata("$configarray[1]/$newuserid/main.php",$email,2);
     writedata("$configarray[1]/$newuserid/main.php",$time,4);
     writedata("$configarray[1]/$newuserid/main.php","$time\t$time",5); 
     writedata("$configarray[1]/$newuserid/main.php","0",6);

	 if($configarray[39]=="approve"){
	   writedata("$configarray[1]/$newuserid/main.php","approve",15);
       print "An admin now has to approve your account<br>";
       print "Check back soon<br>";
     }elseif($configarray[39]=="confirm"){
       writedata("$configarray[1]/$newuserid/main.php","confirm",15);
	   $code=md5($username).md5($email);
	   $message="Welcome to $configarray[0]<BR>You or someone else registered at these forums with:<br>username: $username<BR>password: $passwordbefore<BR><BR>Click the following link to confirm this account<BR><BR><a href=\"http://${SERVER_NAME}${PHP_SELF}?step=3&code=$code&user=$newuserid\">http://${SERVER_NAME}${PHP_SELF}?step=3&code=$code&user=$newuserid</a><BR><BR>Please keep this email for future reference. If you lose or forget your password, you will have this email to help you remember it.<BR>";
       mail2($email,"Registration Confirmation",$message);
       print "You will recieve a email soon<br>";
       print "Follow the instructions to activate your account<br>";
     }elseif(count($usersarray)<=0){
	 writedata("$configarray[1]/$newuserid/main.php","administrator",15);
     }else{
	 writedata("$configarray[1]/$newuserid/main.php","registered",15);
     }

	 writedata("$configarray[1]/$newuserid/main.php",$REMOTE_ADDR,19);
     print "User Created!";
 
     }else{
     print "Invalid email";
     }

   }else{
   print "Username, password, display name must be 2-30chars long";
   }

  }else{
  print "Password does not match password confirm!<br>";
  }

  }else{
  print "Display name already taken!<br>";
  }

  }else{
  print "Username taken!<br>";
  }

  }else{
  print "Username or IP or email banned from this board<br>";
  }
  
 }else{
 print "Please fill in all info!<br>";
 }

}else{
print "Only one account can be registered every $configarray[38] seconds";
}

print "</span>";
print "</td>";
print "</tr>";
print "</table>";

}//step 2 bracket

if($step=="3"&&$code&&isset($user)){
$userarray=getdata("$configarray[1]/$user/main.php");

tableheader1();
print "<tr>";
print "<td class=\"tablecell1\">";
print "<span class=\"textlarge\">";

if(count($userarray)>1){

 if($userarray[15]=="confirm"){

$emailarray=explode("\t",$userarray[2]);
$storedcode=md5($userkeyarray[$user]).md5($emailarray[0]);

 if($code==$storedcode){
  writedata("$configarray[1]/$user/main.php","registered",15);
  print "Your account has been activated, you may now login";
 }else{
  print "Account not activated, codes do not match";
 }
 
 }else{
  print "Your account has already been activated";
 }

}else{
 print "Cannot actviate account, no such user";
}

print "</span>";
print "</td>";
print "</tr>";
print "</table>";

}//step 3

}//board closed check

print "<br><br>";

tableheader1();

require ("footer.php");
?>
