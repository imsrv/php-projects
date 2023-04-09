#!/usr/bin/perl
use CGI::Carp qw(fatalsToBrowser);

use CGI qw(:standard);
$query = new CGI;

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
$deltick		= $FORM{'deltick'};
$adcat			= $FORM{'adcat'};
$searchby		= $FORM{'searchby'};
$searchterm		= $FORM{'searchterm'};



$file=$query->param('name');

unless((-e "$profilesdir/catwsm/$file.html")||(-e "$profilesdir/catwsw/$file.html")||
(-e "$profilesdir/catmsm/$file.html")||(-e "$profilesdir/catmsw/$file.html")){
print "Content-type:text/html\n\n";
&adminmenu;
print <<EOF;
<blockquote><font size=2 face=verdana>This member does not have a profile</font></blockquote>


<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>
EOF
opendir(DIR, "$users");
@files = readdir(DIR);
closedir(DIR);

foreach $file(@files){



if($file =~ /\.txt$/){
$file =~ s/\.txt//g;

if(-e "$profilesdir/catwsm/$file.html"){$profilecat="catwsm";}
if(-e "$profilesdir/catwsw/$file.html"){$profilecat="catwsw";}
if(-e "$profilesdir/catmsm/$file.html"){$profilecat="catmsm";}
if(-e "$profilesdir/catmsw/$file.html"){$profilecat="catmsw";}


print "<a href=\"$admincgiurl/viewp.pl?name=$file\"><font size=2 face=verdana>$file</font></a> | ";
}
}
print <<EOF;

</td></tr></table>


<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
exit;
}


if(-e "$profilesdir/catwsm/$file.html"){$profilecat="catwsm";}
if(-e "$profilesdir/catwsw/$file.html"){$profilecat="catwsw";}
if(-e "$profilesdir/catmsm/$file.html"){$profilecat="catmsm";}
if(-e "$profilesdir/catmsw/$file.html"){$profilecat="catmsw";}

print "Content-type:text/html\n\n";
&adminmenu;


open(IN, "$profilesdir/$profilecat/$file.html");
@lines=<IN>;
close(IN);

foreach $line(@lines){
$content = $line;
print "
$content";
}
print <<EOF;
<table cellspacing="0" cellpadding="0" width=100% height=60 border="0" bgcolor=eeeeee>
<tr><TD WIDTH=10>&nbsp;</td><td>
EOF
opendir(DIR, "$users");
@files = readdir(DIR);
closedir(DIR);

foreach $file(@files){



if($file =~ /\.txt$/){
$file =~ s/\.txt//g;

if(-e "$profilesdir/catwsm/$file.html"){$profilecat="catwsm";}
if(-e "$profilesdir/catwsw/$file.html"){$profilecat="catwsw";}
if(-e "$profilesdir/catmsm/$file.html"){$profilecat="catmsm";}
if(-e "$profilesdir/catmsw/$file.html"){$profilecat="catmsw";}


print "<a href=\"$admincgiurl/viewp.pl?name=$file\"><font size=2 face=verdana>$file</font></a> | ";
}
}
print <<EOF;

</td></tr></table>

<table cellspacing="0" cellpadding="0" width=100% height=35 border="0" bgcolor=808080>
<tr><TD WIDTH=10>&nbsp;</td><td align="right"><a href="$admincgiurl/adminindex.pl?launchadmin">
<font size=2 face=verdana color=white>ADMINISTRATION CENTER</font></a>
</td></tr></table>
</body></html>
EOF
