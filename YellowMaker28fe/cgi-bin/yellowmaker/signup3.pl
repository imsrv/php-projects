#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# signup3.pl
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

if (!($form{'formpassword'})) { 
$message="Please enter your [Password].";
&error;
}

if ($form{'formpassword'} =~ /[^A-Za-z0-9]/) {
$message="Sorry, your [Password] must be 0-9, A-Z and a-z.";
&error;
}

if (int(length($form{'formpassword'}) <= 5) || int(length($form{'formpassword'}) > 8)) {
$message="Sorry, your [Password] must be 6-8 characters.";
&error;
}

if (!$form{'agree'}) {
$message="You must agree on the [Terms & Conditions] to sign up.";
&error;
}

$file=$banip;
$record="$ENV{'REMOTE_ADDR'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&check($record, $safefile);

if ($returnval == 1) {
$message="Sorry, you have no permission to register your free membership account.<br>Please contact us to apply your membership.";
&error;
}

$file=$banmail;
$record="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&check($record, $safefile);

if ($returnval == 1) {
$message="Sorry, you have no permmission to register your free membership account.<br>Please contact us to apply your membership.";
&error;
}

$file=$tmpfile;
$user="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);

if ($returnval != 0) {
if ($register eq "0") {
$message="Congratulations! Your membership applicaton has been successfully submitted to $website.<br><br>You will received your e-mail with an Activation Code shortly.<br>Thank you for choosing $website services!";
}
if ($register eq "1") {
$message="Congratulations! Your membership applicaton has been approved.<br>Thank you for choosing $website services!";
}
if ($register eq "2") {
$message="Thank you for your order for listing in $title!<br>You will be received a notification upon accepttance of your payment.";
}
&standard;
}

&generate_password;
$date=localtime();

if ($register eq "1") {
&lock("$lock", "$userfile");
open (USERLIST, ">>$userfile") || die ("Can't open $userfile.");
print USERLIST "$form{'formemailaddress'}|$form{'formpassword'}|$code|$ENV{'REMOTE_ADDR'}|$ENV{'REMOTE_HOST'}|$date\n";
close (USERLIST);
&unlock("$lock", "$userfile");

$file=$mailfile;
$var="$form{'formemailaddress'}";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&maildefined($var, $safefile);

if ($returnval == 0) {
&lock("$lock");
open (MAILLIST, ">>$mailfile") || die ("Can't open $mailfile.");
print MAILLIST "$form{'formemailaddress'}\n";
close (MAILLIST);
&unlock("$lock");
}

} else {
&lock("$lock", "$tmpfile");
open (TMPLIST, ">>$tmpfile") || die ("Can't open $tmpfile.");
print TMPLIST "$form{'formemailaddress'}|$form{'formpassword'}|$code|$ENV{'REMOTE_ADDR'}|$ENV{'REMOTE_HOST'}|$date\n";
close (TMPLIST);
&unlock("$lock", "$tmpfile");
}

########## SENDMAIL ##########
$ipaddr="$ENV{'REMOTE_ADDR'}";
$recipientaddr="$form{'formemailaddress'}";
$webmaster="$webmaster";


if ($register eq "0") {
$subject2="Your Free Membership Account Information";
&letterofsignup2;
&sendmail($webmaster,$subject2,$msgtxt2,$recipientaddr);
}

if ($register eq "1") {
$subject="Your Free Membership Account Information";
&letterofsignup;
&sendmail($webmaster,$subject,$msgtxt,$recipientaddr);
}

if ($msgsignup eq "1") {
$subject3="Membership Application";
&letterofsignup3;
&sendmail($recipientaddr,$subject3,$msgtxt3,$webmaster);
}
########## SENDMAIL ##########

if ($register eq "0") {
$message="Congratulations! Your membership applicaton has been successfully submitted to $website.<br><br>You will received your e-mail with an Activation Code shortly.<br>Thank you for choosing $website services!";
}
if ($register eq "1") {
$message="Congratulations! Your membership applicaton has been approved.<br>Thank you for choosing $website services!";
}
if ($register eq "2") {
$message="Thank you for your order for listing in $title!<br>You will be received a notification upon accepttance of your payment.";
}
&standard;
