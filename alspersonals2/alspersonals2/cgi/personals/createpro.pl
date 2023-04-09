#!/usr/bin/perl -w
################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################

use CGI::Carp qw(fatalsToBrowser);
########################################################################################################################

require "configdat.lib";
require "variables.lib";
require "gensubs.lib";
require "validate.lib";
require "defaulttext.lib";

&readparse;
########################################################################################################################

if($FORM{'createpro'} eq "Create Profile"){&createpro;}

if($FORM{'skipupload'} eq "Skip Upload"){&skipupload;}

if($FORM{'appendpic'} eq "Append Picture"){&appendpic;}
########################################################################################################################


sub createpro { 

&validate; 

&vars; 


unless(-e "$users/$username.txt"){
&problemencountered;}

open (FILE, "$users/$username.txt") || &oops ($!, "Could not open $users/$username.txt");
flock (FILE, 1) or die "Cannot lock file\n";
while (<FILE>) {
chop;
	@datafile=split(/\n/);
	foreach $line (@datafile) {
	&isokaytogo($line);
	}
	}
	close(FILE);
	

}

sub isokaytogo($line){

local ($line) = @_;
	local ($loginname,$password,$emailaddr);
		  ($loginname,$password,$emailaddr)= split(/\|/, $line);


if(($FORM{'username'} eq "$loginname")&&($FORM{'password'} eq "$password")){
&goprofnext;}

else {&invalidlogin;}
}

sub goprofnext {
&vars;
&checkprofdat;

if(($gender eq "female")&&($lookingfor eq "male")){
$profilecat="catwsm";}

if(($gender eq "female")&&($lookingfor eq "female")){
$profilecat="catwsw";}

if(($gender eq "male")&&($lookingfor eq "male")){
$profilecat="catmsm";}

if(($gender eq "male")&&($lookingfor eq "female")){
$profilecat="catmsw";}



if(($gender eq "female")&&($ethnicbackground eq "African-American")){
$nopic="nopicgaf.jpg";}
elsif(($gender eq "female")&&($ethnicbackground eq "Black/Non-American")){
$nopic="nopicgaf.jpg";}
elsif($gender eq "female"){
$nopic="nopicg.jpg";}

if(($gender eq "male")&&($ethnicbackground eq "African-American")){
$nopic="nopicmaf.jpg";}
elsif(($gender eq "male")&&($ethnicbackground eq "Black/Non-American")){
$nopic="nopicmaf.jpg";}
elsif($gender eq "male"){
$nopic="nopicm.jpg";}


open (HTML, ">$profilesdir/$profilecat/$FORM{'username'}.html") || die "Cannot open $profilesdir/$profilecat/$username.html to create user profile\n";
flock (HTML, 2) or die "cannot lock file\n";
print HTML <<EOF;
$mainheader
$submenu
<table cellpadding=2 cellspacing=2 width=100% height=60 bgcolor=$profilepagesthemecolor border=0><tr> <td><center>
<span style="color:$profileheadfontcolor; font-family:$profileheadfontfamily; font-size:$profileheadfontsize; text-decoration:none; font-weight:bold;">
Profile for $FORM{'username'}
<form method="post" action="$cgiurl/personals.pl"></center>
</td></tr></table>
<center><table cellpadding=3 cellspacing=3 width=75% border=0><tr>
EOF
if($picyn eq "No"){
print HTML"<td><img src=\"$imgurl/$nopic\" border=0></td>\n";} 

else { 
print HTML" <td>

 <!--picture here--> 
</td>\n";}  

print HTML <<EOF;
<td width=70% height=200 valign="top">
<table width=100% cellpadding=2 cellspacing=2 border=0><tr>
<td bgcolor=$profilepagesthemecolor><font size=2 face=verdana color=$fcolortheme><center><b>About Me</b></center></font></td></tr></table>
 
<table cellpadding=2 cellspacing=2 border=0><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Name </b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$username</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Gender </b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$gender</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Age </b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$age</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Zodiac Sign</b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$zodiacsign</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1  color=$fcolor1 face=verdana>Ethnicity</b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$ethnicbackground</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Sexual Orientation</b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$sexualorientation</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Height</b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$height</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Weight </b></font></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$weight</b></font></td></tr><tr> 
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1  face=verdana>Profession</font></b></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$profession</b></font></td></tr><tr>
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Parental Status</font></b></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$parentalstatus</b></font></td></tr><tr>
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Smoker/Non-Smoker</font></b></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$smoker_nonsmoker</b></font></td></tr><tr>
<td bgcolor=$ppcolor1><b><font size=1 color=$fcolor1 face=verdana>Country</font></b></td>
<td bgcolor=$ppcolor2><font size=1 face=verdana color=$fcolor2><b>$country</b></font></td>
</tr></table></td>  </tr></table></center>
<table width=100%><tr><td width=10>&nbsp;</td>
<td> 
<table width=100% cellpadding=2 cellspacing=2 border=0><tr>
<td width=50% bgcolor=$profilepagesthemecolor>
<font size=2 face=verdana color=$fcolortheme><center><b>What I'm Looking For</b></center></font></td>
<td width=50% bgcolor=$ppcolor1>&nbsp;</td></tr></table>
 <table cellpadding=2 cellspacing=2 width=100% border=0><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Type of relationship wanted </font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$reltype </font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Partner's Gender</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$lookingfor </font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Partner's Age</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$betwages </font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Partner's Height</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$partnersheight1 - $partnersheight2</font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Partner's smoking habits</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$smokinghabit</font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Partner's parental status</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$pparentalstatus</font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2  color=$fcolor3 face=univers>Partner's Ethnicity</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$partnersethnicbackground </font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2  color=$fcolor3 face=univers>Partner's Personality Type</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$yourtype</font></td></tr>
</table>

<table width=100% cellpadding=2 cellspacing=2 border=0><tr>
<td bgcolor=$profilepagesthemecolor width=50%><font size=2 color=$fcolortheme face=verdana><center><b>More About Me</b></center></font></td>
<td width=50% bgcolor=$ppcolor1>
<center>


</center>
&nbsp;</td></tr></table>

<table width=100% cellpadding=2 cellspacing=2 border=0><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Status</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=univers>$status </font></td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Favorite Activity</font></b></td> 
<td bgcolor=$ppcolor1><b><font size=2 color=$fcolor1 face=verdana><b><font color=000000 size=2 face=verdana><b>
<font size=2 face=univers color=$fcolor1><b>$favoriteactivity </b></font>
</td> </tr><tr> 
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>The one thing I hate most</font></b></td> 
<td bgcolor=$ppcolor1><b>
<font size=2 face=verdana><b><font size=2 face=univers color=$fcolor1><b>$faveperformer</b></font>
</td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>The one thing I can't live without</font></b></td> 
<td bgcolor=$ppcolor1><b>
<font size=2 face=verdana><b><font size=2 face=univers color=$fcolor1><b>$favemovie</b></font>
</td></tr><tr>
<td bgcolor=$ppcolor3 width=25%><b><font size=2 color=$fcolor3 face=univers>Personality Type</font></b></td> 
<td bgcolor=$ppcolor1><b>
<font size=2 face=verdana><b><font size=2 face=univers color=$fcolor1><b>$mytype</b></font>
</td></tr>
</table>
<table cellpadding=2 cellspacing=2 width=100% border=0><tr>

 <td bgcolor=$ppcolor3 width=150><b><font size=2 color=$fcolor3 face=univers>Contact</font></b></td> 

<td bgcolor=$ppcolor1> <input type="hidden" name="username" value="$username">
<input type="submit" name="leaveamessage" value="Leave A Message In My Message Box" class="button">

</td></tr></table>

</td></tr></table>

<table cellpadding=2 cellspacing=2 width=100% border=0><tr> <td><br><blockquote>

<font size=2 face=arial color=black>$additionalinfo</font></blockquote> </td>
</tr></table>  
<input type="hidden" name="notes" value="$additionalinfo">
<table cellpadding=2 cellspacing=2 width=100% height=60 bgcolor=$profilepagesthemecolor border=0><tr> 
<td>&nbsp;</td></tr></table>  </form>
$botcode
EOF
close(HTML);


open(IN, "$profilesdir/$profilecat/datafiles/profdat.txt");
@data=<IN>;
close(IN);

$numentries=@data;

if($numentries >= 250){

open(IN, "$profilesdir/$profilecat/datafiles/pdnext.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){

$pdataval = $line;
$pnewval = $pdataval + 1;

rename("$profilesdir/$profilecat/datafiles/profdat.txt", "$profilesdir/$profilecat/datafiles/profdat$pnewval.txt");

open (FILE, ">$profilesdir/$profilecat/datafiles/pdnext.txt") || die "Cannot open $profilesdir/$profilecat/datafiles/pdnext.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$pnewval";  
close (FILE);
chmod 0777, '$profilesdir/$profilecat/datafiles/profdat.txt';

}
}

open (FILE, ">>$profilesdir/$profilecat/datafiles/profdat.txt") || die "Cannot open $profilesdir/$profilecat/datafiles/profdat.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$username\n";  
close (FILE); 
chmod 0777, '$profilesdir/$profilecat/datafiles/profdat.txt';




open(IN, "$admincgidir/profiles.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
($numberofprofiles)=split(/\n/,$line);
$oldprocount=$numberofprofiles;
$newprocount=$numberofprofiles + 1;

open (FILE, ">$admincgidir/profiles.txt") || die "Cannot open $admincgidir/profiles.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$newprocount";  
close (FILE);

}

open (FILE, ">$profiledatadir/$username.txt") || die "Cannot open $profiledatadir/$username.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$gender|$lookingfor|$age|$betwages|$sexualorientation|$weight|$height|$partnersheight1|$partnersheight2|$zodiacsign|$ethnicbackground|$partnersethnicbackground|$profession|$parentalstatus|$smoker_nonsmoker|$smokinghabit|$pparentalstatus|$city|$state|$zip|$country|$favemovie|$faveperformer|$reltype|$status|$favoriteactivity|$mytype|$yourtype|$picyn|$additionalinfo"; 
close (FILE);
chmod 0777, '$profiledatadir/$username.txt';

}


if($picyn eq "Yes"){

print "Content-type:text/html\n\n";
print "$mainheader<br><br>
<center><table cellpadding=0 cellspacing=0 width=500 border=0><tr><td>
<blockquote>
<font size=2 face=verdana>You may now upload your picture to include with your profile.
There are two steps involved in the process.<p>
<b>First:</b><br>
Press the \"Browse\" button to search your system for the picture you want to upload. When you have selected the
picture you want to use, press \"Upload Picture\". <p>

<b>Next:</b><br>
You will be prompted to complete the
process of attaching your picture to your file. If you've uploaded a picture before that you would like to use,
press \"Skip Upload\" to move on</blockquote></td>

</tr><tr><td><form ENCTYPE=\"multipart/form-data\" method=\"post\" action=\"fileupload.pl\">
<input type=\"hidden\" name=\"age\" value=\"$age\">
<input type=\"hidden\" name=\"reltype\" value=\"$reltype\">
<input type=\"hidden\" name=\"gender\" value=\"$gender\">
<input type=\"hidden\" name=\"lookingfor\" value=\"$lookingfor\">
<input type=\"hidden\" name=\"username\" value=\"$username\">
<input type=\"hidden\" name=\"password\" value=\"$password\">
<input type=\"hidden\" name=\"emailaddr\" value=\"$emailaddr\">
<input type=\"hidden\" name=\"country\" value=\"$country\">
<input type=\"hidden\" name=\"city\" value=\"$city\">
<input type=\"hidden\" name=\"zip\" value=\"$zip\">
<input type=\"hidden\" name=\"state\" value=\"$state\">
<input type=\"hidden\" name=\"additionalinfo\" value=\"$additionalinfo\">
<center><input type=file name=\"file-to-upload-01\" size=35 class=\"button\"></center></td></tr><tr>

<td>
<center>
<table><tr><td>
<input type=\"submit\" value=\"Upload Picture\" class=\"button\"></td>
<td></form></td>
<td><form method=\"post\" action=\"$cgiurl/createpro.pl\"></td><td>
<input type=\"hidden\" name=\"age\" value=\"$age\">
<input type=\"hidden\" name=\"reltype\" value=\"$reltype\">
<input type=\"hidden\" name=\"gender\" value=\"$gender\">
<input type=\"hidden\" name=\"lookingfor\" value=\"$lookingfor\">
<input type=\"hidden\" name=\"username\" value=\"$username\">
<input type=\"hidden\" name=\"password\" value=\"$password\">
<input type=\"hidden\" name=\"emailaddr\" value=\"$emailaddr\">
<input type=\"hidden\" name=\"country\" value=\"$country\">
<input type=\"hidden\" name=\"city\" value=\"$city\">
<input type=\"hidden\" name=\"zip\" value=\"$zip\">
<input type=\"hidden\" name=\"state\" value=\"$state\">
<input type=\"hidden\" name=\"additionalinfo\" value=\"$additionalinfo\">
<input type=\"submit\" name=\"skipupload\" value=\"Skip Upload\" class=\"button\"></td><td></form></td></tr></table>
</td></tr></table></center>
<table cellpadding=0 cellspacing=0 width=100% height=100><tr>
<td>&nbsp;</td></tr></table>
$botcode\n";
exit;
}

else {

&writetoprolist;

$thusername = $username;
$thpassword = $password;
$classification = $profilecat;

print "Content-type:text/html\n\n";
print "$mainheader<br><br>
<form method=\"post\" action=\"$cgiurl/personals.pl\">
<input type=\"hidden\" name=\"username\" value=\"$username\">
<input type=\"hidden\" name=\"password\" value=\"$password\">
<input type=\"hidden\" name=\"gender\" value=\"$gender\">
<input type=\"hidden\" name=\"lookingfor\" value=\"$lookingfor\">
<blockquote><font size=2 face=verdana>

$profilecreated

<P>
</blockquote>
<center><input type=\"submit\" name=\"postadnow\" value=\"Post Ad Now\" class=\"button\"></center>

<p><font size=2 face=verdana><blockquote>
You may
<a href=\"$profilesurl/$profilecat/$username.html\">click here
to view your profile</a>, <br>or <a href=\"javascript:history.go(-4)\">Return to main page</a></font>
</blockquote><br><br>
</form>
$botcode\n"; 
exit;
} 



sub appendpic {
&vars;

if(($gender eq "female")&&($lookingfor eq "male")){
$profilecat="catwsm";}

if(($gender eq "female")&&($lookingfor eq "female")){
$profilecat="catwsw";}

if(($gender eq "male")&&($lookingfor eq "male")){
$profilecat="catmsm";}

if(($gender eq "male")&&($lookingfor eq "female")){
$profilecat="catmsw";}

if(($username eq "")||($password eq "")||($picfilename eq "")){&missinginfo;}

if(-e "$profilesdir/$profilecat/$username.html"){
open (FILE, "$profilesdir/$profilecat/$username.html") || die "Could not open the specified file $profilesdir/$username.html. Dying in the effort to append 
picture to profile page.\n";
flock (FILE, 1)  or die  "cannot lock index file\n";
	@lines = <FILE>;
	close (FILE);
	$sizelines = @lines;

#Append picture to page

open (FILE, ">$profilesdir/$profilecat/$username.html") || die "Could not open the specified file $profilesdir/$profilecat/$username.html. Dying in the effort to append 
picture to profile page.\n";
flock (FILE, 2)  or die  "cannot lock index file\n";
	for ($a = 0; $a <=$sizelines; $a++) {
	$_ = $lines[$a];
       if (/<!--picture here-->/)  {	
       print FILE "<!--picture here-->\n";
       print FILE "<img src=\"$userimagesurl/$picfilename\" border=0><br>\n";
	} else {

	      print FILE $_;

	}

}

close (FILE);



###########################################################################

&writetoprolist;

$thusername = $username;
$thpassword = $password;
$classification = $profilecat;

print "Content-type:text/html\n\n";
print "$mainheader<br><br>
<table width=100% cellpadding=0 cellspacing=0 border=0><tr><td>
<blockquote>
<form method=\"post\" action=\"$cgiurl/personals.pl\">
<font size=2 face=verdana>
<input type=\"hidden\" name=\"username\" value=\"$username\">
<input type=\"hidden\" name=\"password\" value=\"$password\">
<input type=\"hidden\" name=\"gender\" value=\"$gender\">
<input type=\"hidden\" name=\"lookingfor\" value=\"$lookingfor\">
<blockquote><font size=2 face=verdana>

$profilecreated

<P>
</blockquote>
<center><input type=\"submit\" name=\"postadnow\" value=\"Post Ad Now\" class=\"button\"></center>
<font size=2 face=verdana,geneva><blockquote> You may
<a href=\"$profilesurl/$profilecat/$username.html\">click here
to view your profile</a>, or 
<a href=\"javascript:history.go(-4)\">Return to main page</a>
</font></blockquote>
<br>
<br></td></tr></table>
</form>
\n";
print "$botcode\n";
exit;

}


else {&invalidlogin;}



}


sub skipupload {
&vars;
print "Content-type:text/html\n\n";
print "$mainheader<br><br>
<center><table cellpadding=0 cellspacing=0 width=400 border=0><tr><td>
<font size=1 face=verdana><blockquote>
You must enter your username and password below to assure that your picture gets appended to the
correct profile. You must also enter the name of your image file if it is not already entered.
</blockquote><br><br>
<form method=\"post\" action=\"$cgiurl/createpro.pl\">
<input type=\"hidden\" name=\"age\" value=\"$age\">
<input type=\"hidden\" name=\"reltype\" value=\"$reltype\">
<input type=\"hidden\" name=\"gender\" value=\"$gender\">
<input type=\"hidden\" name=\"lookingfor\" value=\"$lookingfor\">
<input type=\"hidden\" name=\"username\" value=\"$username\">
<input type=\"hidden\" name=\"password\" value=\"$password\">
<input type=\"hidden\" name=\"emailaddr\" value=\"$emailaddr\">
<input type=\"hidden\" name=\"country\" value=\"$country\">
<input type=\"hidden\" name=\"city\" value=\"$city\">
<input type=\"hidden\" name=\"zip\" value=\"$zip\">
<input type=\"hidden\" name=\"state\" value=\"$state\">
<input type=\"hidden\" name=\"additionalinfo\" value=\"$additionalinfo\">

<table cellpadding=0 cellspacing=0 width=400 border=0><tr>
<td><font size=2 face=verdana><b>Username</b></font></td>
<td><input type=\"text\" name=\"username\" value=\"$username\" size=15></td></tr><tr>
<td><font size=2 face=verdana><b>Password</b></font></td>
<td><input type=\"text\" name=\"password\" value=\"$password\" size=15></td></tr><tr>
<td><font size=2 face=verdana><b>Picture File Name</b></font></td>
<td><input type=\"text\" name=\"picfilename\" value=\"$Filename\" size=15></td></tr><tr>
</tr></table><br>
<center><input type=\"submit\" name=\"appendpic\" value=\"Append Picture\" class=\"button\"></center><br><br>
</form>
</td></tr></table></center>
$botcode\n";
}

sub profileexists {

print "Content-type:text/html\n\n";
print " $mainheader<br>\n"; 
print "<blockquote><font size=2 face=verdana>

$profileExists

</blockquote>\n";
print "<center><b><a href=\"javascript:history.go(-2\">Exit</a>&nbsp;&nbsp;
<a href=\"$cgiurl/delprofile.pl\">Delete My Profile</a>
</b></center></font>\n";
print "<br><br>$botcode\n";

exit;

}



##############################################################################

sub writetoprolist {
&vars;
if(($gender eq "female")&&($lookingfor eq "male")){
$profilecat="catwsm";}

if(($gender eq "female")&&($lookingfor eq "female")){
$profilecat="catwsw";}

if(($gender eq "male")&&($lookingfor eq "male")){
$profilecat="catmsm";}

if(($gender eq "male")&&($lookingfor eq "female")){
$profilecat="catmsw";}

unless(-e "$profilesdir/$profilecat/datafiles/proflist.txt"){
open (FILE, ">>$profilesdir/$profilecat/datafiles/proflist.txt") || die "Cannot open $profilesdir/$profilecat/datafiles/proflist.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "\n";  
close (FILE); }

unless($picfilename){

if(($gender eq "female")&&($ethnicbackground eq "African-American")){
$picfilename="nopicgaf.jpg";}
elsif(($gender eq "female")&&($ethnicbackground eq "Black/Non-American")){
$picfilename="nopicgaf.jpg";}
elsif($gender eq "female"){
$picfilename="nopicg.jpg";}

if(($gender eq "male")&&($ethnicbackground eq "African-American")){
$picfilename="nopicmaf.jpg";}
elsif(($gender eq "male")&&($ethnicbackground eq "Black/Non-American")){
$picfilename="nopicmaf.jpg";}
elsif($gender eq "male"){
$picfilename="nopicm.jpg";}
}

unless($additionalinfo){$additionalinfo="Hi, I'm $username. I'm $age. Interested in $reltype with a $lookingfor";}

open(IN, "$profilesdir/$profilecat/datafiles/proflist.txt");
@data=<IN>;
close(IN);

$numentries=@data;

if($numentries >= 250){

open(IN, "$profilesdir/$profilecat/datafiles/plnext.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){

$pldataval = $line;
$plnewval = $pldataval + 1;

rename("$profilesdir/$profilecat/datafiles/proflist.txt", "$profilesdir/$profilecat/datafiles/$proflist$plnewval.txt");

open (FILE, ">$profilesdir/$profilecat/datafiles/plnext.txt") || die "Cannot open $profilesdir/$profilecat/datafiles/plnext.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$plnewval\n";  
close (FILE);
}
}

open (FILE, ">>$profilesdir/$profilecat/datafiles/proflist.txt") || die "Cannot open $profilesdir/$profilecat/datafiles/proflist.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$username|$picfilename|$additionalinfo|$age|$country|$state|$city|$zip\n";  
close (FILE); 
chmod 0777, '$profilesdir/$profilecat/datafiles/proflist.txt';

}


sub checkprofdat {

if(($gender eq "female")&&($lookingfor eq "male")){
$profilecat="catwsm";}

if(($gender eq "female")&&($lookingfor eq "female")){
$profilecat="catwsw";}

if(($gender eq "male")&&($lookingfor eq "male")){
$profilecat="catmsm";}

if(($gender eq "male")&&($lookingfor eq "female")){
$profilecat="catmsw";}

unless(-e "$profilesdir/$profilecat/datafiles/profdat.txt"){
open (FILE, ">>$profilesdir/$profilecat/datafiles/profdat.txt") || die "Cannot open $profilesdir/$profilecat/datafiles/profdat.txt\n";  
flock (FILE, 2) or die "can't lock file\n"; 
print FILE ""; 
close (FILE);}

opendir(DIR, "$profilesdir/$profilecat/datafiles");
@dircont=readdir(DIR);
closedir(DIR);

foreach $fileindir(@dircont){
unless(($fileindir eq ".")||($fileindir eq "..")||($fileindir eq "pdnext.txt")||($fileindir eq "plnext.txt")){

open(IN, "$profilesdir/$profilecat/datafiles/$fileindir");
@lines=<IN>;
close(IN);

foreach $line(@lines){
$nametocheckfor=$FORM{'username'};
if($line =~ /$nametocheckfor/){&profileexists;}

}
}
}
}