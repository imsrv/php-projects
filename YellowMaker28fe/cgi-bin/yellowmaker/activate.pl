#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# activate.pl
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

&parse_form;
&get_time;

&GetCookies("emailaddress","password");

if (($Cookies{'emailaddress'}) && ($Cookies{'password'})) {
$emailaddress=lc($Cookies{'emailaddress'});
$password=$Cookies{'password'};
}        

if (!$form{'code'}) {
$message="Please enter your [Activation Code].";
&error;
}

$file=$tmpfile;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval == 0) {
$file=$userfile;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval == 0) {
$message="Your membership account does not exist!<br>Please click here to <a href=\"$homecgi/signup.pl\">Sign Up Your Free Membership</a>.";
&error;
} else {
$message="Your membership account has been activated.<br>You can fully access $website Member Center now.";
&standard;
} 
}

if ($form{'code'} ne $code) {
$message="Sorry, your [Activation Code] is incorrect! Please try again.";
&error;
}

$date=localtime();

$file=$tmpfile;
&lock("$lock", "$tmpfile");
$user="$emailaddress";
&deleteuser($user, $file);
&unlock("$lock", "$tmpfile");

&lock("$lock", "$userfile");
open (USERLIST, ">>$userfile") || die ("Can't open $userfile.");
print USERLIST "$emailaddress|$pwd|$code|$ENV{'REMOTE_ADDR'}|$ENV{'REMOTE_HOST'}|$date\n";
close (USERLIST);
&unlock("$lock", "$userfile");

$file=$mailfile;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&maildefined($user, $safefile);

if ($returnval == 0) {
&lock("$lock", "$mailfile");
open (MAILLIST, ">>$mailfile") || die ("Can't open $mailfile.");
print MAILLIST "$emailaddress\n";
close (MAILLIST);
&unlock("$lock", "$mailfile");
}

########## SENDMAIL ##########
$ipaddr="$ENV{'REMOTE_ADDR'}";
$recipientaddr="$emailaddress";
$webmaster="$webmaster";

$subject="Your Membership Account Has Been Activated";
&letterofactivate;
&sendmail($webmaster,$subject,$msgtxt,$recipientaddr);

if ($msgactivate == 1) {
$file=$database;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&retrieveid($user, $safefile);

$subject2="The Membership Account: [$emailaddress] Has Been Activated";
&letterofactivate2;
&sendmail($recipientaddr,$subject2,$msgtxt2,$webmaster);
}
########## SENDMAIL ##########

$message="Your membership account has been activated.<br>You can fully access $website Member Center now.";
&standard;
