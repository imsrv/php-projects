#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# signup2.pl
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

$form{'formemailaddress'} =~ s/^\s+//;
$form{'formemailaddress'} =~ s/\s+$//;  
$form{'formemailaddress'} =~ tr/A-Z/a-z/;
 
if (!$form{'formemailaddress'}) {
$message="Please enter your [E-mail Address].";
&error;
}

if (&valid_address($form{'formemailaddress'}) == 0) {
$message="Sorry, your [E-mail Address] is invalid.";
&error;
}

$file=$userfile;
$user="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval == 1) {
$message="Sorry, your [E-mail Address] already in use.";
&error;
}

$file=$tmpfile;
$user="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval == 1) {
$message="Sorry, your [E-mail Address] already registered!";
&error;
}

if (!($form{'formpassword'})) { 
$message="Please enter your [Password].";
&error;
}

if ($form{'formpassword'} =~ /[^A-Za-z0-9]/) {
$message="Sorry, your [Password] must be 0-9, A-Z and a-z.";
&error;
}

if ((length($form{'formpassword'}) <= 5) or (length($form{'formpassword'}) > 8)) {
$message="Sorry, your [Password] must be 6-8 characters.";
&error;
}

$file=$banip;
$record="$ENV{'REMOTE_ADDR'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&check($record, $safefile);

if ($returnval == 1) {
$message="Sorry, you have no permission to get a free membership!";
&error;
}

$file=$banmail;
$record="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&check($record, $safefile);

if ($returnval == 1) {
$message="Sorry, you have no permission to get a free membership!";
&error;
}

&header;
&top;
&include("/$sub/$sub9/signup2.htm");
&bottom;
exit;
