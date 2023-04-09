#!/usr/bin/perl -w
use CGI::Carp qw(fatalsToBrowser);


require "configdat.lib";
require "userspresent.lib";
require "variables.lib";



############################################################
$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
    $msg = "@_"; 
   print "\nContent-type: text/html\n\n";
  print "The following error occurred : $msg\n";
  exit;
}

# Get the input
read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
   @pairs = split(/&/, $input);
   foreach $pair (@pairs) {

   ($name, $value) = split(/=/, $pair);
  
   $name =~ tr/+/ /;  
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

	unless($HTML_ALLOW eq "Y"){

   $value =~ s/<([^>]|\n)*>//g;}

 $FORM{$name} = $value;  
      }
 

######################################################################
if($FORM{'searchprofiles'} eq "Browse Profiles"){&searchprofiles;}
if($FORM{'find'} eq "Search"){
&searchprofiles;}

sub searchprofiles {
&verify;}


sub searchprofiles {
&verify;}


sub verify {
&vars;

if(($mygender eq "Man")&&($lookingfor eq "Female")){
$profilecat = catwsm;}
elsif(($mygender eq "Man")&&($lookingfor eq "Man")){
$profilecat = catmsm;}
elsif(($mygender eq "Female")&&($lookingfor eq "Man")){
$profilecat = catmsw;}
elsif(($mygender eq "Female")&&($lookingfor eq "Female")){
$profilecat = catwsw;}


unless(-e "$profilesdir/$profilecat/datafiles/proflist.txt"){
print "Content-type:text/html\n\n";
print <<EOF;
$mainheader<br><br>
<font size=2 face=verdana><blockquote>There were <b>(0)</b> ads found.</font></blockquote>
<center><FORM> <INPUT type="button" value="Click here to go back" onClick="history.go(-1)" class="button"> </FORM></center>
<br><br>$botcode
EOF
exit;}

&checkforempty;
}

sub checkforempty {
&vars;
unless(-e "$profilesdir/$profilecat/datafiles/proflist1.txt"){
open(IN, "$profilesdir/$profilecat/datafiles/proflist.txt")||&oops($!,"Cannot read $profilesdir/$profilecat/datafiles/proflist.txt");
@lines= <IN>;
close(IN);

$x= @lines;



unless($x > 0){
print "Content-type:text/html\n\n";
print "$mainheader<br><br>\n";
print "<font size=2 face=verdana><blockquote>There were <b>(0)</b> ads found
</font></blockquote>
<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>\n";
print "<br><br>$botcode\n";
exit;}

&checkformat;

}
}


sub checkformat {
&vars;


if($andor eq "ageonly"){&agesearch;}
if($andor eq "loconly"){&locsearch;}

}

sub noresults {
print "Content-type:text/html\n\n";
print "$mainheader$menu1$menu2<br><br>\n";
print "<font size=2 face=verdana><blockquote>There were <b>(0)</b> ads found
</font></blockquote>
<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>\n";
print "<br><br>$botcode\n";
exit;
}

sub andnoresults {
print "<font size=2 face=verdana><blockquote>There were <b>(0)</b> ads found
</font></blockquote>
<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>\n";


}


sub agesearch {
&vars;

if($FORM{'age1'} > $FORM{'age2'}){&adjustages;}

print "Content-type:text/html\n\n";
print "$mainheader$menu1$menu2<br><br><center><table width=85%><tr><td>
<blockquote><font size=2 face=verdana>The results of your search are shown below. If there are no entries listed,
there were no results found. <a href=\"javascript:history.go(-1)\">Go Back</a></font><blockquote>\n";

opendir(DIR, "$profilesdir/$profilecat/datafiles");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
if($file =~ /proflist/){

open(IN, "$profilesdir/$profilecat/datafiles/$file")||&oops($!,"Cannot read $profilesdir/$profilecat/datafiles/$file");
@lines= <IN>;
close(IN);

$x=@lines;
foreach $line(@lines) {
($username,$picfilename,$additionalinfo,$age,$country,$city,$state,$zip)=split(/\|/,$line);
if($picfilename eq "nopicg.jpg"){
$imgnmloc="$imgurl/npg.gif";}
elsif($picfilename eq "nopicgaf.jpg"){
$imgnmloc="$imgurl/npg.gif";}
elsif($picfilename eq "nopicm.jpg"){
$imgnmloc="$imgurl/npm.gif";}
elsif($picfilename eq "nopicmaf.jpg"){
$imgnmloc="$imgurl/npm.gif";}
else{
$imgnmloc="$userimagesurl/$picfilename";}

unless(($age < $FORM{'age1'})||($age > $FORM{'age2'})){
print "<table width=100% cellpadding=1 cellspacing=1><tr><td bgcolor=$searchresultspictdcol width=\"10%\"><a href=\"$profilesurl/$profilecat/$username.html\"><center><img src=\"$imgnmloc\" width=\"60\" border=1><br><font size=1 face=verdana>$username($age)</font></center></a></td><td width=90% bgcolor=$searchresultstxttdcol><blockquote><font size=1 face=verdana>$additionalinfo</font></blockquote></td></tr></table>";

}
}
}
}
print "</td></tr></table></center><br><br>$botcode\n";
exit;
}


sub adjustages {
print "Content-type:text/html\n\n";
print "$mainheader<br><br>\n";
print "<font size=2 face=verdana><blockquote>
Your starting age appears to be higher than your ending age. Please adjust the ages and try again.
</font></blockquote>
<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>\n";
print "<br><br>$botcode\n";
exit;
}



sub noagematch {
print "Content-type:text/html\n\n";
print "$mainheader<br><br>\n";
print "<font size=2 face=verdana><blockquote>There were <b>(0)</b> profiles found
for members who are $FORM{'age1'} - $FORM{'age2'}.</font></blockquote>
<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>\n";
print "<br><br>$botcode\n";
exit;
}


sub locsearch {
&vars;

opendir(DIR, "$profilesdir/$profilecat/datafiles");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
if($file =~ /proflist/){

open(IN, "$profilesdir/$profilecat/datafiles/$file")||&oops($!,"Cannot read $profilesdir/$profilecat/datafiles/$file");
@lines= <IN>;
close(IN);

foreach $line(@lines) {
($username,$picfilename,$additionalinfo,$age,$country,$city,$state,$zip)=split(/\|/,$line);

if($line =~ /$FORM{'kywds'}/i){
&showresultsloc;}
}
}
}
if($line !~ /$FORM{'kywds'}/i){
&nolocmatch;}

}


sub showresultsloc {
&vars;

print "Content-type:text/html\n\n";
print "$mainheader$menu1$menu2<br><br><center><table width=85%><tr><td>
<blockquote><font size=2 face=verdana>The results of your search are shown below. If there are no entries listed,
there were no results found. <a href=\"javascript:history.go(-1)\">Go Back</a></font><blockquote>\n";

opendir(DIR, "$profilesdir/$profilecat/datafiles");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
if($file =~ /proflist/){

open(IN, "$profilesdir/$profilecat/datafiles/$file")||&oops($!,"Cannot read $profilesdir/$profilecat/datafiles/$file");
@lines= <IN>;
close(IN);

$x=@lines;
foreach $line(@lines) {
($username,$picfilename,$additionalinfo,$age,$country,$city,$state,$zip)=split(/\|/,$line);
if($picfilename eq "nopicg.jpg"){
$imgnmloc="$imgurl/npg.gif";}
elsif($picfilename eq "nopicgaf.jpg"){
$imgnmloc="$imgurl/npg.gif";}
elsif($picfilename eq "nopicm.jpg"){
$imgnmloc="$imgurl/npm.gif";}
elsif($picfilename eq "nopicmaf.jpg"){
$imgnmloc="$imgurl/npm.gif";}
else{
$imgnmloc="$userimagesurl/$picfilename";}

if($line =~ /$FORM{'kywds'}/i){
print "<table width=100% cellpadding=1 cellspacing=1><tr><td bgcolor=$searchresultspictdcol width=\"10%\"><a href=\"$profilesurl/$profilecat/$username.html\"><center><img src=\"$imgnmloc\" width=\"60\" border=1><br><font size=1 face=verdana>$username($age)</font></center></a></td><td width=90% bgcolor=$searchresultstxttdcol><blockquote><font size=1 face=verdana>$additionalinfo</font></blockquote></td></tr></table>";

}
}
}
}

print "</td></tr></table></center><br><br>$botcode\n";
exit;
}






sub nolocmatch {
print "Content-type:text/html\n\n";
print "$mainheader<br><br>\n";
print "<font size=2 face=verdana><blockquote>There were <b>(0)</b> profiles found
for members from </b>$key</b>.</font></blockquote>
<center><FORM> <INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>\n";
print "<br><br>$botcode\n";
exit;

}