#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# admin2.pl
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

&parse_form;

$form{'formadmin'} =~ s/^\s+//;
$form{'formadmin'} =~ s/\s+$//;  
$form{'formpassword'} =~ s/^\s+//;
$form{'formpassword'} =~ s/\s+$//;
$form{'formadmin'} =~ tr/A-Z/a-z/;

if (!$form{'formadmin'}) {
$message="Please enter your [Administrator]'s name.";
&error;
}

if (!$form{'formpassword'}) {
$message="Please enter your [Password].";
&error;
}

if ($form{'formadmin'} ne $admin) {
$message="Sorry, your [Administrator]'s name is incorrect! Please try again.";
&error;
}

if ($form{'formpassword'} ne $adminpwd) {
$message="Sorry, your [Password] is incorrect! Please try again.";
&error;
}

&admincreatesession($form{'formadmin'}, $form{'formpassword'});

&header;
&top;

if ($form{'setup'} eq "1") {
&include("/$sub/$sub9/system.htm");
&bottom;
exit;
} 

if (($form{'begin'} ne "") && ($form{'end'} ne "")) {
$file=$database;
$user="$form{'formid'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&checkid($user, $safefile);
$form{'formemailaddress'}=$emailaddr;
&include("/$sub/$sub9/adminlist.htm");
&bottom;
exit;
}

&total_registered;
&total_activated;
&total_profiles;

&include("/$sub/$sub9/admin2.htm");
&bottom;
exit;
