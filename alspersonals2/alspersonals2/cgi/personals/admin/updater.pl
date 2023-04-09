#!/usr/bin/perl
use CGI::Carp qw(fatalsToBrowser);

require "../configdat.lib";
require "../gensubs.lib";
require "adminmenu.lib";
require "subs.lib";
require "../userspresent.lib";
require "updater2.lib";
require "../variables.lib";
require "updater3.lib";
require "../defaulttext.lib";
require "updater4.lib";
################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################
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
    $FORM{$name} = $value;  
    }
###############################################################################
$datatoadd		= $FORM{'datatoadd'};
$featureF		= $FORM{'featureF'};
$featureM		= $FORM{'featureM'};
$question		= $FORM{'question'};
$topdatatoadd		= $FORM{'topdatatoadd'};
$bottomdatatoadd	= $FORM{'bottomdatatoadd'};
$username		= $FORM{'username'};
$picturetodel		= $FORM{'picturetodel'};
$picturetodel2		= $FORM{'picturetodel2'};
$postersname		= $FORM{'postersname'};
$deltick			= $FORM{'deltick'};
$adcat			= $FORM{'adcat'};
$searchby			= $FORM{'searchby'};
$searchterm			= $FORM{'searchterm'};
################################################################################

	if (($FORM{'updateindex'} ne "") || ($ENV{'QUERY_STRING'} =~ /updateindex/)){
	&updateindex; 
	exit;}	

	if (($FORM{'changefeatureprof'} ne "") || ($ENV{'QUERY_STRING'} =~ /changefeatureprof/)){
	&changefeatureprof; 
	exit;}
	
	if (($FORM{'checksuggestions'} ne "") || ($ENV{'QUERY_STRING'} =~ /checksuggestions/)){
	&checksuggestions; 
	exit;}

	if (($FORM{'cleanfilesuggestions'} ne "") || ($ENV{'QUERY_STRING'} =~ /cleanfilesuggestions/)){
	&cleanfilesuggestions; 
	exit;}	

	if (($FORM{'checkcomplaints'} ne "") || ($ENV{'QUERY_STRING'} =~ /checkcomplaints/)){
	&checkcomplaints; 
	exit;}

	if (($FORM{'dispro'} ne "") || ($ENV{'QUERY_STRING'} =~ /dispro/)){
	&dispro; 
	exit;}	

	if (($FORM{'picinspector'} ne "") || ($ENV{'QUERY_STRING'} =~ /picinspector/)){
	&pictureinspector; 
	exit;}	

	if (($FORM{'adspy'} ne "") || ($ENV{'QUERY_STRING'} =~ /adspy/)){
	&adspy; 
	exit;}

	if (($FORM{'admdelmemad'} ne "") || ($ENV{'QUERY_STRING'} =~ /admdelmemad/)){
	&admdelmemad; 
	exit;}

	if($FORM{'updatetopcontent'} eq "Update Top Content"){
	&updatetop;
	}

	if($FORM{'updatebottomcontent'} eq "Update Bottom Content"){
	&updatebottom;
	}
	

	if($FORM{'updateffeature'} eq "Update"){
	&updateffeature;
	}

	if($FORM{'updatemfeature'} eq "Update"){
	&updatemfeature;
	}

	if($FORM{'askvenus'} eq "Ask"){
	&filelovequestion; 
	exit;}

	if (($FORM{'editconfigdat'} ne "") || ($ENV{'QUERY_STRING'} =~ /editconfigdat/)){
	&editconfigdat; 
	exit;}	

	if($FORM{'updateconfig'} eq "Update"){
	&updateconfig; 
	exit;}

	if (($FORM{'editrightmenu'} ne "") || ($ENV{'QUERY_STRING'} =~ /editrightmenu/)){
	&editrightmenu; 
	exit;}	

	if($FORM{'updaterightmenu'} eq "Update"){
	&dorightmenuupdate; 
	exit;}

	if (($FORM{'wsmspy'} ne "") || ($ENV{'QUERY_STRING'} =~ /wsmspy/)){
	&wsmspy; 
	exit;}	

	if (($FORM{'wswspy'} ne "") || ($ENV{'QUERY_STRING'} =~ /wswspy/)){
	&wswspy; 
	exit;}	

	if (($FORM{'msmspy'} ne "") || ($ENV{'QUERY_STRING'} =~ /msmspy/)){
	&msmspy; 
	exit;}	

	if (($FORM{'mswspy'} ne "") || ($ENV{'QUERY_STRING'} =~ /mswspy/)){
	&mswspy; 
	exit;}	

	if($FORM{'delpicture'} eq "Delete"){
	&admdelpicture;}

	if($FORM{'lookupticknum'} eq "Look up ticket number"){
	&lookupticknum;}

	if($FORM{'admdelad'} eq "Delete Ad"){
	&admdelad;}

	if (($FORM{'launchmailcenter'} ne "") || ($ENV{'QUERY_STRING'} =~ /launchmailcenter/)){
	&launchmailcenter; 
	exit;}


	if (($FORM{'showallprofiles'} ne "") || ($ENV{'QUERY_STRING'} =~ /showallprofiles/)){
	&showallprofiles; 
	exit;}

	if (($FORM{'showallmembers'} ne "") || ($ENV{'QUERY_STRING'} =~ /showallmembers/)){
	&showallmembers; 
	exit;}

	if($FORM{'deluname'} eq "Delete"){
	&deloffensive;}

	if($FORM{'cff'} eq "Feature"){
	&feaf;}

	if($FORM{'rff'} eq "Remove"){
	&removeF;}

	if($FORM{'feam'} eq "Feature"){
	&feam;}

	if($FORM{'remm'} eq "Remove"){
	&removeM;}

	if($FORM{'renameuser'} eq "Rename"){
	&renameuser;}

	if (($FORM{'searchmemdatafile'} ne "") || ($ENV{'QUERY_STRING'} =~ /searchmemdatafile/)){
	&searchmemdatafile; 
	exit;}

	if($FORM{'searchdata'} eq "Search"){
	&searchdata;}

	if($FORM{'deletedir'} eq "Delete Selected"){&deleteselectedmessagecenter;}
	if($FORM{'deletedir'} eq "Delete All"){&deletemessagecenterdir;}

	if (($FORM{'manmescen'} ne "") || ($ENV{'QUERY_STRING'} =~ /manmescen/)){
	&manmescen; 
	}

	if (($FORM{'expelmember'} ne "") || ($ENV{'QUERY_STRING'} =~ /expelmember/)){
	&expelmember; 
	}

	if($FORM{'admdelprof'} eq "Delete Profile"){&admindelprofile;}
	if($FORM{'doexpulsion'} eq "Expel Member"){&doexpulsion;}
	
	if (($FORM{'admdelpicb'} ne "") || ($ENV{'QUERY_STRING'} =~ /admdelpicb/)){
	&admdelpicb; 
	exit;}	

	if($FORM{'admpbrmpic'} eq "Start"){&admpbrmpic;}

	if($FORM{'adminpbrem'} eq "Remove"){&adminpbrem;}
###############################################################################
sub changefeatureprof {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><br><blockquote>
<font color=000000 face=verdana size=1>
Use the updater below to update the featured profiles. Simply select the member you want to feature and
press "Feature". To remove a member you do not plan to feature, check the radio button next to the member's name
and press "Remove".
<table width=100%><tr><td width=5%>&nbsp;</td>
<td width=90%>
<font size=1 face=verdana>
<b>The following members have requested to be featured: (Click on the name to view the member's profile)</b></font>
</td>
<td width=5%>&nbsp;</td></tr></table>
<hr size=1 color=black>
<center><table width=60% border=1 bordercolor=black cellpadding=1 cellspacing=1><tr>
<td valign="top"><center>Female Requests</center><br>
<form method="post" action="$admincgiurl/updater.pl">
<center><table><tr>
<font size=1 face=verdana>
EOF

open(IN, "$admincgidir/getfeaturedf.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
print "$line";
}



print <<EOF;

</font><td>&nbsp;</td></tr></table>
<center><table><tr>
<td><input type="submit" name="cff" value="Feature"></td>
<td><input type="submit" name="rff" value="Remove"></td></table></center>
</form>
</td>

<td valign="top"><center>Male Requests</center><br>
<form method="post" action="$admincgiurl/updater.pl">
<center><table><tr>
<font size=1 face=verdana>
EOF

open(IN, "$admincgidir/getfeaturedm.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
print "$line";
}



print <<EOF;

</font><td>&nbsp;</td></tr></table>
<center><table><tr>
<td><input type="submit" name="feam" value="Feature"></td>
<td><input type="submit" name="remm" value="Remove"></td></table></center>
</td></tr></table>

</blockquote></font><br>
</td>
</tr></table>


<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
}

################################################################################
sub feaf {

open(IN, "$admincgidir/featuredlinksf.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
if($line =~ /$FORM{'username'}/){
$theline = $line;
}
}

open (FILE, ">$perscgidir/feaf.txt") || die "Cannot open $perscgidir/femalefeature.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$theline\n";
close (FILE);

open(IN, "$admincgidir/featuredlinksf.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksf.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/featuredlinksf.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksf.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

open(IN, "$admincgidir/getfeaturedf.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksf.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/getfeaturedf.txt")||&adminerror($!,"Cannot read $admincgidir/getfeaturedf.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><br>
<blockquote><font size=2 face=verdana>The female featured profile has been changed.
<a href="$cgiurl/index.pl">Click here to view changes</a></font></blockquote><br><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
EOF
exit;
}



sub removeF {

open(IN, "$admincgidir/featuredlinksf.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksf.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/featuredlinksf.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksf.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

open(IN, "$admincgidir/getfeaturedf.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksf.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/getfeaturedf.txt")||&adminerror($!,"Cannot read $admincgidir/getfeaturedf.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><br>
<blockquote><font size=2 face=verdana>$FORM{'username'} has been removed from the list.
<a href="javascript:history.go(-1)">Go back</a></font></blockquote><br><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
EOF
exit;
}


sub feam {

open(IN, "$admincgidir/featuredlinksm.txt");
@lines=<IN>;
close(IN);

foreach $line(@lines){
if($line =~ /$FORM{'username'}/){
$theline = $line;
}
}

open (FILE, ">$perscgidir/feam.txt") || die "Cannot open $perscgidir/feam.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$theline\n";
close (FILE);

open(IN, "$admincgidir/featuredlinksm.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksm.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/featuredlinksm.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksm.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

open(IN, "$admincgidir/getfeaturedm.txt")||&adminerror($!,"Cannot read $admincgidir/getfeaturedm.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/getfeaturedm.txt")||&adminerror($!,"Cannot read $admincgidir/getfeaturedm.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><br>
<blockquote><font size=2 face=verdana>The male featured profile has been changed.
<a href="$cgiurl/index.pl">Click here to view changes</a></font></blockquote><br><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
EOF
exit;
}



sub removeM {

open(IN, "$admincgidir/featuredlinksm.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksm.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/featuredlinksm.txt")||&adminerror($!,"Cannot read $admincgidir/featuredlinksm.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

open(IN, "$admincgidir/getfeaturedm.txt")||&adminerror($!,"Cannot read $admincgidir/getfeaturedm.txt");
flock (IN, 1);
@lines= <IN>;
close(IN);

open(OUT,">$admincgidir/getfeaturedm.txt")||&adminerror($!,"Cannot read $admincgidir/getfeaturedm.txt");
flock (OUT, 2);
foreach $line(@lines) {
$codetofind = $FORM{'username'};
if ($line !~ /$codetofind/) {
print OUT "$line";
}
}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><br>
<blockquote><font size=2 face=verdana>$FORM{'username'} has been removed from the list.
<a href="javascript:history.go(-1)">Go back</a></font></blockquote><br><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
EOF
exit;

}
################################################################################

sub checkcomplaints {


if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}

print "Content-type:text/html\n\n";
&adminmenu;

print <<EOF;
<table width=100% bgcolor=eeeeee cellpadding=0 cellspacing=0 border=0><tr>
<td width=10%>&nbsp;</td><td><b><font size=1 face=verdana>MEMBER COMPLAINTS</font></b></td>
<td><a href="$admincgiurl/updater.pl?cleanfilecomplaints"><b><font size=2 face=verdana>Clean File</font></b></a></td>

</tr></table>
<br><ul><blockquote><font size=2 face=verdana>
EOF

open(IN, "$admincgidir/complaints.txt");
@lines=<IN>;
close(IN);

# find out how many lines
$x = @lines;

# because arrays count from zero, 
# knock that count down by one


# read from end to front
for($i = $x; $i >=0; $i--) {

unless($x > 0) {
print "There have been no complaints filed.";}

print "$lines[$i]";}

print<<EOF;
</font></blockquote></ul>

<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;

}

################################################################################

sub checksuggestions {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}

print "Content-type:text/html\n\n";
&adminmenu;

print <<EOF;
<table width=100% bgcolor=eeeeee cellpadding=0 cellspacing=0 border=0><tr>
<td width=10%>&nbsp;</td><td><b><font size=1 face=verdana>MEMBER SUGGESTIONS</font></b></td>
<td><a href="$admincgiurl/updater.pl?cleanfilesuggestions"><b><font size=2 face=verdana>Clean File</font></b></a></td>

</tr></table>
<br><ul><blockquote><font size=2 face=verdana>
EOF

open(IN, "$admincgidir/suggestions.txt");
@lines=<IN>;
close(IN);

# find out how many lines
$x = @lines;

# because arrays count from zero, 
# knock that count down by one


# read from end to front
for($i = $x; $i >=0; $i--) {

unless($x > 0) {
print "There have been no suggestions or comments posted.";}

print "$lines[$i]";}



print<<EOF;
</font></blockquote></ul>

<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;

}

################################################################################

sub adspy {


if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><br><blockquote><font color=000000 face=verdana size=1>
Run the ad spy to check each ad file for profanity. You will have the option to email a warning to violators and delete their
ad. Click on a category to send the ad spy searching for violations.<br><br>
</td></tr></table><br><br>

<center>
<table width=60% height=40 cellpadding=1 cellspacing=1 bgcolor=404040 border=0><tr>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?wsmspy"><font size=2 face=verdaba>Women Seeking Men</font></a></center></td>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?mswspy"><font size=2 face=verdaba>Men Seeking Women</font></a></center></td></tr><tr>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?wswspy"><font size=2 face=verdaba>Women Seeking Women</font></a></center></td>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?msmspy"><font size=2 face=verdaba>Men Seeking Men</font></a></center></td>
</tr></table></center>

<br><br><br>
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
################################################################################

sub wsmspy {

unless(-e "$persadsdir/wsmads/ads/wsmads.txt"){&noadfile;}
opendir(DIR, "$persadsdir/wsmads/ads");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
unless(($file eq ".")||($file eq "..")){

open(IN, "$persadsdir/wsmads/ads/$file")||&adminerror($!,"Cannot read $persadsdir/wsmads/ads/$file");
@lines= <IN>;
close(IN);


foreach $foulword(@foulwords){
foreach $line(@lines){

if($line =~ /$foulword/i){
$adcat="wsmads";
&writetoadviolationfile;}
}
}
}
}
if($line !~ /$foulword/i){
&noviolationfound;}
}

################################################################################

sub wswspy {
unless(-e "$persadsdir/wswads/ads/wswads.txt"){&noadfile;}
opendir(DIR, "$persadsdir/wswads/ads");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
unless(($file eq ".")||($file eq "..")){

open(IN, "$persadsdir/wswads/ads/$file")||&adminerror($!,"Cannot read $persadsdir/wswads/ads/$file");
@lines= <IN>;
close(IN);


foreach $foulword(@foulwords){
foreach $line(@lines){

if($line =~ /$foulword/i){
$adcat="wswads";
&writetoadviolationfile;}
}
}
}
}

if($line !~ /$foulword/i){
&noviolationfound;}
}
################################################################################
sub msmspy {
unless(-e "$persadsdir/msmads/ads/msmads.txt"){&noadfile;}
opendir(DIR, "$persadsdir/msmads/ads");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
unless(($file eq ".")||($file eq "..")){

open(IN, "$persadsdir/msmads/ads/$file")||&adminerror($!,"Cannot read $persadsdir/msmads/ads/$file");
@lines= <IN>;
close(IN);


foreach $foulword(@foulwords){
foreach $line(@lines){

if($line =~ /$foulword/i){
$adcat="msmads";
&writetoadviolationfile;}
}
}
}
}

if($line !~ /$foulword/i){
&noviolationfound;}
}
################################################################################
sub mswspy {
unless(-e "$persadsdir/mswads/ads/mswads.txt"){&noadfile;}
opendir(DIR, "$persadsdir/mswads/ads");
@files=readdir(DIR);
closedir(DIR);

foreach $file(@files){
unless(($file eq ".")||($file eq "..")){

open(IN, "$persadsdir/mswads/ads/$file")||&adminerror($!,"Cannot read $persadsdir/mswads/ads/$file");
@lines= <IN>;
close(IN);


foreach $foulword(@foulwords){
foreach $line(@lines){

if($line =~ /$foulword/i){
$adcat="mswads";
&writetoadviolationfile;}
}
}
}
}

if($line !~ /$foulword/i){
&noviolationfound;}
}
################################################################################
sub writetoadviolationfile {
if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><form method="post" action="$admincgiurl/updater.pl"><br><blockquote><font color=000000 face=verdana size=1>
The following ads were found to contain one or more violations<br><br>
To find the deletion ticket number associated with a particular ad, enter the name of the person who posted the ad (Shown at "Posted By: ) into the "look up ticket number" box below; then 
press the "Look up ticket number button.<br>
<b>Enter Ad Posters Name:</b>&nbsp;<input type="text" name="postersname" size=20>
&nbsp;
<input type="hidden" name="adcat" value="$adcat">
<input type="submit" name="lookupticknum" value="Look up ticket number" class="button">
</td></tr></table><br>
EOF

print "$line";

print <<EOF;
<br>
<font size=1 face=verdana><blockquote>
To find the deletion ticket number associated with a particular ad, enter the name of the person who posted the ad (Shown at "Posted By: ) into the "look up ticket number" box below, then press the "Look up ticket number" button.<br>
<b>Enter Ad Posters Name:</b>&nbsp;<input type="text" name="postersname" size=20>
&nbsp;
<input type="submit" name="lookupticknum" value="Look up ticket number" class="button">
</font></blockquote>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html></form>
EOF
exit;
}

################################################################################
sub noviolationfound {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table><tr><td>
<br><br><blockquote><font size=2 face=verdana>Ad spy did not find any violations to report.</font</blockquote><br><br><br>
</td></tr></table><br>

<center>
<table width=60% height=40 cellpadding=1 cellspacing=1 bgcolor=404040 border=0><tr>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?wsmspy"><font size=2 face=verdaba>Women Seeking Men</font></a></center></td>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?mswspy"><font size=2 face=verdaba>Men Seeking Women</font></a></center></td></tr><tr>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?wswspy"><font size=2 face=verdaba>Women Seeking Women</font></a></center></td>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?msmspy"><font size=2 face=verdaba>Men Seeking Men</font></a></center></td>
</tr></table></center>
<br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}
################################################################################
sub noadfile {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<table><tr><td>
<br><br><blockquote><font size=2 face=verdana>There are not yet any ads in this category; therefore there is no file 
for ad spy to search.
</font</blockquote><br><br><br></td></tr></table><br>
<center>
<table width=60% height=40 cellpadding=1 cellspacing=1 bgcolor=404040 border=0><tr>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?wsmspy"><font size=2 face=verdaba>Women Seeking Men</font></a></center></td>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?mswspy"><font size=2 face=verdaba>Men Seeking Women</font></a></center></td></tr><tr>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?wswspy"><font size=2 face=verdaba>Women Seeking Women</font></a></center></td>
<td bgcolor=eeeeee><center><a href="$admincgiurl/updater.pl?msmspy"><font size=2 face=verdaba>Men Seeking Men</font></a></center></td>
</tr></table></center>
<br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}
################################################################################

sub filelovequestion {
if($question eq "")
{
print "Content-type:text/html\n\n";
print <<EOF;
$mainheader<br><br>
<blockquote><font size=2 face=verdana>
You did not enter a question.
</font></blockquote><p>
<center><FORM> <INPUT type="button" value="Click here to go back" onClick="history.go(-1)" class="button"> </FORM></center>
$botcode
EOF
exit;
}

if($username eq "")
{
print "Content-type:text/html\n\n";
print <<EOF;
$mainheader<br><br>
<blockquote><font size=2 face=verdana>
You did not enter the name of the person asking the question.
</font></blockquote><p>
<center><FORM> <INPUT type="button" value="Click here to go back" onClick="history.go(-1)" class="button"> </FORM></center>
$botcode
EOF
exit;
}

open (FILE, ">>$admincgidir/lovequestions.txt") || die "Cannot open $admincgidir/suggestions.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$question|$username\n";  
close (FILE);

print "Content-type:text/html\n\n";
print <<EOF;
$mainheader<br><br>
<blockquote><font size=2 face=verdana>Your question has been filed. Venus reviews the questions she receives,
and her answers are displayed randomly. Keep checking back to see if your question is being displayed.
</font></blockquote><br><br>
$botcode
EOF
exit;
}
################################################################################

sub editconfigdat {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><br><blockquote><font color=000000 face=verdana size=1>
Use the updater below to edit the file configdat.lib. Please note that configdat.lib is an essential file and that the program will malfunction
if an error is made in file. <b>Make a backup copy of configdat.lib</b> before you make any changes to the file using the updater. 
</blockquote></font><br>
</td>
</tr></table>
<form method="post" action="$admincgiurl/updater.pl">
<center><table><tr>
<td><b><font size=2 face=verdana>Edit Configuration File:</font></b></td></tr><tr>
<td><center><textarea name="datatoadd" cols=90 rows=30 wrap=physical class="tarea">
EOF

open(IN,"$perscgidir/configdat.lib");
@lines = <IN>;
close(IN);

foreach $line (@lines) {
	chomp($line);
	print "$line\n";}

print <<EOF;


</textarea></center></td></tr><tr>
<td><center><input type="submit" name="updateconfig" value="Update" class="button">
</center></td></tr></table></center>

</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
}
################################################################################
sub updateconfig {

open (FILE, ">$perscgidir/configdat.lib") || die "Cannot open $perscgidir/configdat.lib\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$datatoadd\n";  
close (FILE);  

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><br>
<blockquote><font size=2 face=verdana>The configuration file has been edited successfully.
Please check the functionality of the program.
<a href="$cgiurl/index.pl">Click here</a></font></blockquote><br><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>

</body></html>
EOF

}
################################################################################

sub editrightmenu {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;

<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><br><blockquote><font color=000000 face=verdana size=1>
Use the updater below to update the top middle table content of index.pl. Edit only where indicated. 
Failure to edit only where indicated can result in a program malfunction.

</blockquote></font><br>
</td>
</tr></table>
<form method="post" action="$admincgiurl/updater.pl">
<table width=100% cellpadding=1 cellspacing=1 border=1><tr>
<td width=50% valign="top">
<center><table><tr>
<td><b><font size=2 face=verdana>Edit Right Menu:</font></b></td></tr><tr>
<td><center><textarea name="datatoadd" cols=80 wrap=physical rows=8 class="tarea">
EOF


open(IN,"$perscgidir/rightmenu.txt");
@lines = <IN>;
close(IN);

foreach $line (@lines) {
	chomp($line);
	print "$line\n";}

print <<EOF;


</textarea></center></td></tr><tr>
<td><center><input type="submit" name="updaterightmenu" value="Update" class="button">
</center></td></tr></table></center>


</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>
</body></html>
EOF
}

###################################################################################################

sub dorightmenuupdate {

open (FILE, ">$perscgidir/rightmenu.txt") || die "Cannot open $perscgidir/rightmenu.txt\n";  
flock (FILE, 2) or die "can't lock file\n";  
print FILE "$datatoadd\n";  
close (FILE);  

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><br>
<blockquote><font size=2 face=verdana>The right menu has been updated. You may view the change in effect
by <a href="$cgiurl/index.pl">Clicking here</a></font></blockquote><br><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>

</body></html>
EOF

}

################################################################################
sub pictureinspector {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<table cellspacing="0" cellpadding="0" width=100% height=30 border="0" bgcolor=eeeeee>
<tr>
<td><form method="post" action="$admincgiurl/updater.pl"><br><blockquote><font color=000000 face=verdana size=1>
Run the picture inspector to check the user images directory for pictures users upload that might be offensive.
The inspector will show all pictures in the directory, therefore the page might take some time to load depending on how many pictures are in the 
directory and the individual picture file sizes. Inspector resizes so all pictures are shown at 130 pixels in height; but it does not reduce file byte size. 
<p>Use your browsers right-click option to check out the properites of a particular picture. It will show the file name. If you need to delete a picture, enter the file name
into the box and press delete.

</blockquote></font><br>
</td>
</tr></table>
<br>
<table align="right"><tr>
<td><font size=1 face=verdana><b>Enter file name to delete picture</b></font></td>
<td><input type="text" name="picturetodel1" size=20></td>
<td><input type="submit" name="delpicture" value="Delete" class="button"></td></tr></table>
<br><br>

EOF




	opendir (DIR, $userimagesdir) || &adminerror ("Error Reading Directory:", "$!");
	@picfiles = readdir(DIR);
	closedir (DIR);

	foreach $picfile(@picfiles) {
	if($picfile =~/\.gif$|\.jpg$|\.jpeg$/){

		
print"<img src=\"$userimagesurl/$picfile\" border=1 height=130>";}}

print <<EOF;
<br><br>
<table align="right"><tr>
<td><font size=1 face=verdana><b>Enter file name to delete picture</b></font></td>
<td><input type="text" name="picturetodel2" size=20></td>
<td><input type="submit" name="delpicture" value="Delete" class="button"></td></tr></table>
<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table></form>

</body></html>
EOF
exit;

}

################################################################################

sub admdelpicture {

if($FORM{'picturetodel1'} ne ""){
$picturetodel="$FORM{'picturetodel1'}";}

if($FORM{'picturetodel2'} ne ""){
$picturetodel="$FORM{'picturetodel2'}";}



if(($FORM{'picturetodel1'} ne "")&&($FORM{'picturetodel2'} ne "")){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><font size=2 face=verdana><blockquote>You cannot enter a picture file name into both boxes. Remove the file name from either the top box or the bottom box 
to proceed. <a href="javascript:history.go(-1)">Go back</a>
</font></blockquote><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>
<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;}

if($picturetodel eq ""){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<br><br><font size=2 face=verdana><blockquote>You are trying to delete a picture but you have not
entered the file name. Please <a href="javascript:history.go(-1)">go back</a>
and enter the file name.</font></blockquote><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>
<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;}

if($picturetodel !~/\.gif$|\.GIF$|\.JPG$|\.jpg$|\.jpeg$|\.JPEG$/){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<font size=2 face=verdana><blockquote>It seems you have not entered the file extension. Please <a href="javascript:history.go(-1)">go back</a>
and enter the complete file name.</font></blockquote><br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;}

unless(-e "$userimagesdir/$picturetodel"){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<font size=2 face=verdana><blockquote>The directory does not contain a file by the name you have entered.
Did you enter the file name correctly. Please <a href="javascript:history.go(-1)">go back</a>
and check.</font></blockquote>
<br><br><table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;}

$cnt=unlink "$userimagesdir/$picturetodel";


print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<font size=2 face=verdana><blockquote>The picture has been deleted.<P>
<a href="javascript:history.go(-1)">Go back</a>
</font></blockquote>
<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;

}


sub deletemessagecenterdir {

&gettotalnumcenters;

if(-e "$messagecenterdir"){
`rm -rf $messagecenterdir`;}

umask(000); 
mkdir("$personalsdir/messagecenter", 0777) unless (-d "$personalsdir/messagecenter/");  

open (HTML, ">$personalsdir/messagecenter/index.html") || die "Cannot open $personalsdir/messagecenter/index.html\n";
flock (HTML, 2) or die "cannot lock file\n";
print HTML <<EOF;
<HTML><HEAD>
<title>Personals</title>
<SCRIPT LANGUAGE="JavaScript">
<!-- Original:  desypfa\@hotmail.com -->
<!-- Modified:  Benjamin Wright, Editor -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
redirTime = "1000";
redirURL = "$cgiurl/index.pl";
function redirTimer() { self.setTimeout("self.location.href = redirURL;",redirTime); }
//  End -->
</script>

</head>
<body onLoad="redirTimer()">
</body></html>
EOF
close(HTML);


print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<font size=2 face=verdana><blockquote><b>$totalcenters </b> message center directories
have been deleted.<P>
<a href="javascript:history.go(-1)">Go back</a>
</font></blockquote>
<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}

sub deleteselectedmessagecenter {

if(-e "$messagecenterdir/$FORM{'dirtodel'}"){
`rm -rf $messagecenterdir/$FORM{'dirtodel'}`;}

print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<font size=2 face=verdana><blockquote>The message center directory, <b>$FORM{'dirtodel'}</b>
has been deleted.<P>
<a href="javascript:history.go(-1)">Go back</a>
</font></blockquote>
<br><br>
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>&nbsp;
</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}

sub manmescen {

if($ENV{'HTTP_REFERER'} !~ /$admincgiurl/){

print "Content-type:text/html\n\n";
print "<br><br><br><br><blockquote><font size=2 face=verdana><b><b>Access Violation</b><br><br>
You are not authorized to access this document. </font></blockquote><br><br><br>\n";
exit;}


&gettotalnumcenters;
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=60 border=\"0\">
<tr><td><form method="post" action="$admincgiurl/updater.pl"></td>
<td><blockquote><font size=2 face=verdana>(<b>$totalcenters</b>) User Message Centers</b></font></td>
<td><select name="dirtodel" class="selist">
EOF

opendir (DIR, "$messagecenterdir") || &adminerror ("Error Reading Directory:$messagecenterdir", "$!");
	@dircontents = readdir(DIR);
	closedir (DIR);

	foreach $dircontent(@dircontents) {

unless($dircontent =~/\./){

print "<option>$dircontent</option>";
}
}

print <<EOF;
</select>

</td><td><input type="submit" name="deletedir" value="Delete Selected" class="button"></td>
<td><input type="submit" name="deletedir" value="Delete All" class="button"></td>
<td></form></td></tr></table>
<br><br>
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


sub gettotalnumcenters {
opendir (DIR, "$messagecenterdir") || &adminerror ("Error Reading Directory:$messagecenterdir", "$!");
	@dircontents = readdir(DIR);
	closedir (DIR);

$x=@dircontents;
$totalcenters=$x-2;


}



