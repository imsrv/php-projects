#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# open2.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
do "cookie.lib";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&checkpermission;

&parse_form;

$form{'category'} =~ s/^\s+//;
$form{'category'} =~ s/\s+$//;  

$form{'category'} =~ s/%26/&/gi;

if (!$form{'category'}) {
$message="Please select a [Category].";
&error;
}

$file=$database;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&datadefined($user, $safefile);

$category=$form{'category'};

&header;
&top;

if (!$country) {
$country="----- Select -----";
}

if (!$homepage) {
$homepage="http://";
}

if ($id) {
$messagefile="$sub2/$sub7/$id.txt";
if (-e $messagefile) {
open (MESSAGE, "<$messagefile") || die ("Can't open $messagefile.");
}
foreach $line (<MESSAGE>) {
$line =~ s/^\s+//;
$line =~ s/\s+$//;  
$describe="$describe$line\n";
}
close (MESSAGE);

$id="(ID:$id)";
}

if (($returnval == 0) && ($password eq "$pwd")) {
$open="add.pl";
&include("/$sub/$sub9/open.htm");
&bottom;
exit;
}

$open="modify.pl";
&include("/$sub/$sub9/open.htm");
&bottom;
exit;
