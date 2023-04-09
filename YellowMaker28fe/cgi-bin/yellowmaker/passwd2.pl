#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# passwd2.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
do "message.pl";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&parse_form;
&get_time;

$form{'emailaddress'} =~ s/^\s+//;
$form{'emailaddress'} =~ s/\s+$//;  
$form{'code'} =~ s/^\s+//;
$form{'code'} =~ s/\s+$//;
$form{'emailaddress'} =~ tr/A-Z/a-z/;
 
if (!$form{'emailaddress'}) {
$message="Please enter your [E-mail Address].";
&error;
}

if (!$form{'code'}) {
$message="Please enter your [Activation Code].";
&error;
}

$file=$tmpfile;
$user="$form{'emailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval == 0) {
$file=$userfile;
$user="$form{'emailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval eq "0") {
$message="Sorry, your [E-mail Address] have not registered yet!";
&error;
}
} 

if ($form{'code'} ne $code) {
$message="Sorry, your [Activation Code] is incorrect! Please try again.";
&error;
}

########## SENDMAIL ##########
$ipaddr="$ENV{'REMOTE_ADDR'}";
$date=localtime();
$recipientaddr="$form{'emailaddress'}";
$webmaster="$webmaster";

$subject="Welcome to $website";
&letterofpassword;
&sendmail($webmaster,$subject,$msgtxt,$recipientaddr);
########## SENDMAIL ##########

$message="Your password has been sent to: $form{'emailaddress'}.<br>You will received it shortly.";
&standard;
