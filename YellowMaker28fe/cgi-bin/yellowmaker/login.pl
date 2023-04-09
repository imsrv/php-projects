#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# login.pl
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

$form{'formemailaddress'} =~ s/^\s+//;
$form{'formemailaddress'} =~ s/\s+$//;  
$form{'formpassword'} =~ s/^\s+//;
$form{'formpassword'} =~ s/\s+$//;
$form{'formemailaddress'} =~ tr/A-Z/a-z/;

if (!$form{'formemailaddress'}) {
$message="Please enter your [E-mail Address].";
&error;
}

if (!$form{'formpassword'}) {
$message="Please enter your [Password].";
&error;
}

$file=$userfile;
$user="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval == 0) {

$file=$tmpfile;
$user="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);
if ($returnval == 1) {
if ($form{'formpassword'} ne "$pwd") {
$message="Sorry, your [Password] is incorrect! Please try again.";
&error;
}
&createsession($form{'formemailaddress'}, $form{'formpassword'});
&header;
&top;
&include("/$sub/$sub9/activate.htm");
&bottom;
exit;
}

$message="Sign in failure for Your [E-mail Address: $form{'formemailaddress'}].<br><a href=\"$homecgi/signup.pl\">Sign up now</a> if you don't already have a membership account.<br>Did you <a href=\"$homecgi/passwd.pl\">forget your password?</a> 
";
&error;
} 

if ($form{'formpassword'} ne "$pwd") {
$message="Sorry, your [Password] is incorrect! Please try again.<br>Did you <a href=\"$homecgi/passwd.pl\">forget your password?</a>";
&error;
}

&createsession($form{'formemailaddress'}, $form{'formpassword'});

$id=$form{'id'};

&header;
&top;

if ($id) {
&include("/$sub/$sub9/contact.htm");
&bottom;
exit;
}

&include("/$sub/$sub9/member.htm");
&bottom;
exit;
