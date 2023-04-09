#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# org.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&parse_form;

$id=$form{'id'};
$memberid=$id;

$file=$database;
$user="$id";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&checkid($user, $safefile);

$file=$database;
$user="$emailaddr";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&datadefined($user, $safefile);

$messagefile="$sub2/$sub7/$memberid.txt";
if (-e $messagefile) {
open (MESSAGE, "<$messagefile") || die ("Can't open $messagefile.");
}
foreach $line (<MESSAGE>) {
$line =~ s/^\s+//;
$line =~ s/\s+$//;  
$describe="$describe$line";
}
close (MESSAGE);

$messagefile="$sub2/$sub4/$memberid.txt";
if (-e $messagefile) {
open (MESSAGE, "<$messagefile") || die ("Can't open $messagefile.");
}
foreach $line (<MESSAGE>) {
$line =~ s/^\s+//;
$line =~ s/\s+$//;  
$yellowpage="$line";
}
close (MESSAGE);

if ($establish) {
$establish="<b>Established in:</b>&nbsp;&nbsp;$establish<br><br>";
}

if (!$phone) {
$phone="----------";
}

if (!$fax) {
$fax="----------";
}

$hp=$homepage;

if (!$yellowpage) {
if ($homepage) {
$homepage="   <a href=\"$hp\"><img src=\"$home/pics/homepage.gif\" alt=\"Visit $name web site\" border=\"0\"></a>";
}
} else {
$homepage="   <a href=\"$url/$yellowpage\"><img src=\"$home/pics/homepage.gif\" alt=\"Visit $name web site\" border=\"0\"></a>";
}

$adminlist="<a href=\"$homecgi/adminlist.pl?formlist=$form{'formlist'}&formid=$id&begin=$form{'begin'}&end=$form{'end'}\"><font color=\"#000000\" face=\"$font\" size=\"$size\"><img src=\"$home/pics/file.gif\" border=\"0\" align=\"middle\"></font></a>&nbsp;&nbsp;&nbsp;";

$category="<a href=\"$homecgi/advanced2.pl?category=$category&host=Doesn't%20Matter&id=Doesn't%20Matter&ip=Doesn't%20Matter&emailaddr=Doesn't%20Matter&dateadd=Doesn't%20Matter&datemod=Doesn't%20Matter\">$category</a>";

&header;
&top;

&include("/$sub/$sub9/list2.htm");

&print_search;
&bottom;
exit;
