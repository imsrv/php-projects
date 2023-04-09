#!/usr/bin/perl


use CGI::Carp qw(fatalsToBrowser);

require "../configdat.lib";
require "adminmenu.lib";
require "../variables.lib";
require "subs.lib";
require "../userspresent.lib";

################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################
# Do not make changes here		                                              
################################################################################

$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
    $msg = "@_"; 
  print "\nContent-type: text/html\n\n";
  print "The following error occurred : $msg\n";
  exit;
}
################################################################################
# Get the input
################################################################################

read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
   @pairs = split(/&/, $input);
   foreach $pair (@pairs) {
   ($name, $value) = split(/=/, $pair);
   $name =~ tr/+/ /;  
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ s/<([^>]|\n)*>//g;
   $FORM{$name} = $value;  
   }
###############################################################################
if($FORM{'activatemembership'} eq "Activate Membership"){&activatemembership;}
if($FORM{'doactivation'} eq "Activate"){&doactivation;}
if (($FORM{'start'} ne "") || ($ENV{'QUERY_STRING'} =~ /start/)){&start; }	

sub start {
if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){
print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}

print "Content-type:text/html\n\n";
&adminmenu;
print "<table width=100% bgcolor=eeeeee><tr><td>
<form method=\"post\" action=\"$admincgiurl/activatemember.pl\">
<blockquote><font size=1 face=verdana>
You are operating a site that requires members to pay a membership fee. The program does not automatically activate membership, 
as it does not have a way to determine if a member has paid or not.
This means that each time you are notifed of a purchased membership, you must
activate the member's username and password yourself. To activate the username and password, you must enter the first and last name of the member as
into the membership activation box below once you have received notice of their purchased membership.
The program will search the data file for matching data, and once found, will activate the username and password for the particular member. An email will
be sent to the member to notify him/her that membership has been activated.</font></blockquote></td></tr></table>
<table width=100% cellpadding=2 cellspacing=2 bgcolor=404040 border=0><tr>
<td width=5%>&nbsp;</td>
<td width=20% bgcolor=c0c0c0><font size=2 face=verdana><b>Membership Activation Box</b></font></td>
<td width=75%><table bgcolor=ffffff width=100%><tr><td><font size=2 face=verdana>First Name:</font></td>
<td><input type=\"text\" name=\"firstname\" size=20></td>
<td><table><tr><td><font size=2 face=verdana>Last Name:</font></td>
<td><input type=\"text\" name=\"lastname\" size=20></td>
<td><input type=\"submit\" name=\"activatemembership\" value=\"Activate Membership\" class=\"button\"></td></tr></table>
<td width=10%></form>&nbsp;</td></tr></table></td></tr></table>\n";

print <<EOF;
<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=60 border=\"0\" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=35 border=\"0\" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align=\"right\"><a href=\"$admincgiurl/adminindex.pl?launchindex\">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
}


sub activatemembership {
&vars;

if(($firstname eq "")||($lastname eq "")){
print "Content-type:text/html\n\n";
&adminmenu;
print "<br>
<font size=2 face=verdana><blockquote>
Please enter both a first name and a last name.</font></blockquote><br><br>\n";
print "<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=60 border=\"0\" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=35 border=\"0\" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align=\"right\"><a href=\"$admincgiurl/adminindex.pl?launchindex\">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>\n";
exit;
}


opendir(DIR, "$admincgidir/memberdatafiles");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){

unless(($file eq "next.txt")||($file eq ".")||($file eq "..")){

open(IN, "$admincgidir/memberdatafiles/$file")||&adminerror($!,"Cannot open $admincgidir/memberdatafiles/$file");
@lines=<IN>;
close(IN);

foreach $line(@lines){
($firstname,$lastname,$street,$city,$state,$zip,$country,$mofbirth,$dofbirth,$yofbirth,$username,$password,$emailaddr,$profilecategory,$remote_addr,$membercode)=split(/\|/,$line);


if(($FORM{'firstname'} eq "$firstname")&&($FORM{'lastname'} eq "$lastname")){

print "Content-type:text/html\n\n";
&adminmenu;
print "

<table width=100% cellpadding=0 cellspacing=0 border=0><tr><td>
<form method=\"post\" action=\"$admincgiurl/activatemember.pl\">
<blockquote><font size=2 face=verdana>The table below shows all persons found with the name <b>$firstname $lastname</b>.<p>

<table width=100% cellpadding=1 cellspacing=1 border=0 bgcolor=404040><tr>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>First Name</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>Last name</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>Street</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>City</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>State</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>Zip</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>Country</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>Username</font></center></td>
<td bgcolor=c0c0c0><center><font size=1 face=verdana>Email Address</font></center></td></tr><tr>
<td bgcolor=ffffff><center><input type=radio name=username value=$username><font size=1 face=verdana>$firstname</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$lastname</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$street</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$city</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$state</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$zip</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$country</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$username <input type=\"hidden\" name=\"password\" value=\"$password\">
<input type=\"hidden\" name=\"firstname\" value=\"$firstname\">
<input type=\"hidden\" name=\"lastname\" value=\"$lastname\">
</font></center></td>
<td bgcolor=ffffff><center><font size=1 face=verdana>$emailaddr<input type=\"hidden\" name=\"emailaddr\" value=\"$emailaddr\"></font></center></td></tr></table><p>
<blockquote><font size=2 face=verdana>Check the radio button if this is the <b>$firstname $lastname</b> whose memebership you wish to activate; then press the \"Activate\" button.</font></blockquote>
<center><input type=\"submit\" name=\"doactivation\" value=\"Activate\" class=\"button\"></center><br><br></td></tr></table>\n";

print <<EOF;
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchindex">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>

EOF
exit;
}
}
}
}
if(($FORM{'firstname'} ne "$firstname")||
($FORM{'lastname'} ne "$lastname")){
&activationerror;exit;}
}






sub activationerror {
&vars;
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<br><br><table><tr><td><br><br><blockquote><font size=2 face=verdana>There was no information in the data file for the member <b>$FORM{'firstname'} $FORM{'lastname'}</b>. Perhaps 
you have made a spelling error. Please go back and try again; or if there was no error, please register the member in order to add the member's
information to the data file. <a href=\"javascript:history.go(-1)\">Go Back</a></font></blockquote></td></tr></table><br><br>


<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchindex">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
exit;
}

sub doactivation {
&vars;

if($FORM{'username'} eq ""){
&vars;
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<br><br><table><tr><td><br><br><blockquote><font size=2 face=verdana>
You must first check the radio button next to the name of the person whose membership you want to activate.
<a href=\"javascript:history.go(-1)\">Go Back</a></font></blockquote></td></tr></table><br><br>


<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchindex">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
exit;
}

open (FILE, ">>$users/$username.txt") || die "Cannot open $users/$username\.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$username|$password|$emailaddr\n";  
close (FILE); 

if(-e "$users/mintran/$username.txt"){
$cnt=unlink "$users/mintran/$username.txt";}


open(IN, "$admincgidir/members.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
($numberofmembers)=split(/\n/,$line);
$oldcount=$numberofmembers;
$newcount=$numberofmembers + 1;

open (FILE, ">$admincgidir/members.txt") || die "Cannot open $admincgidir/members.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$newcount\n";  
close (FILE);
}

open(IN, "$admincgidir/quasimembers.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
($numberofmembers)=split(/\n/,$line);
$oldcount=$numberofmembers;
$newcount=$numberofmembers - 1;

if($newcount < 0){$newcount = 0;}
open (FILE, ">$admincgidir/members.txt") || die "Cannot open $admincgidir/members.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$newcount\n";  
close (FILE);
}

open  (MAIL, "| $sendmail -t") || die "cannot open sendmail\n";  
print MAIL "To: $username <$emailaddr>\n";  
print MAIL "From: $email\n"; 
print MAIL "Subject: $sitename Membership Activated\n"; 
print MAIL "Dear $username\n";
print MAIL "\n";
print MAIL "Your $sitename membership is now active. Your username and password are shown below. Thank you for joining $sitename. We are glad to have you.\n";  
print MAIL "\n";
print MAIL "Your Chosen user name and password are:\n";  
print MAIL "User Name: $username\n";  
print MAIL "Password: $password\n";  
print MAIL "\n";  
print MAIL "$sitename administration\n";  
close MAIL;  


print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0">
<tr><TD><blockquote><font size=2 face=verdana> <b>$firstname $lastname 's</b> membership has been activated,
and an email notification has been sent to <b>$emailaddr</b>.
</font></blockquote></td></tr></table><br><br>


<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
}