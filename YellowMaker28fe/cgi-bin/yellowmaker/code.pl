#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# code.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
do "message.pl";
do "cookie.lib";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&GetCookies("emailaddress","password");

if (($Cookies{'emailaddress'}) && ($Cookies{'password'})) {
$emailaddress=lc($Cookies{'emailaddress'});
$password=$Cookies{'password'};
}        

&get_time;

if ($register == 2) {
$message="Sorry, your membership account did not approve yet!";
&error;
exit;
} else {
$file=$tmpfile;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if (($returnval == 0) || ($password ne "$pwd")) {
$message="Sorry, your membership account has been activated!";
&error;
exit;
}
}

########## SENDMAIL ##########
$ipaddr="$ENV{'REMOTE_ADDR'}";
$date=localtime();
$recipientaddr="$emailaddress";
$webmaster="$webmaster";

$subject="Your Free Membership Account Information";
&letterofcode;
&sendmail($webmaster,$subject,$msgtxt,$recipientaddr);
########## SENDMAIL ##########

$message="Your Activation Code has been sent to: <strong><font color=\"#FF0000\">$emailaddress</font></strong>. You will received it shortly.";
&standard;
