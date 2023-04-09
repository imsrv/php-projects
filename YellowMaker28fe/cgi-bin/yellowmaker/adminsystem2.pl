#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# adminsystem2.pl
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

&admincheckpermission;

&parse_form;

if ($form{'admin'} eq "") {
$message="Please enter [Your Name].";
&error;
}

if (($form{'admin'} =~ /[^A-Za-z0-9]/)) {
$message="Sorry, [Your Name] must be 0-9, A-Z and a-z.";
&error;
}

if (int(length($form{'admin'}) <= 5) || int(length($form{'admin'}) > 15)) {
$message="Sorry, [Your Name] must be 6-15 characters.";
&error;
}

if ($form{'adminpwd'} eq "") {
$message="Please enter [Your Password].";
&error;
}

if (($form{'adminpwd'} =~ /[^A-Za-z0-9]/)) {
$message="Sorry, [Your Password] must be 0-9, A-Z and a-z.";
&error;
}

if (int(length($form{'adminpwd'}) <= 5) || int(length($form{'adminpwd'}) > 15)) {
$message="Sorry, [Your Password] must be 6-15 characters.";
&error;
}

if ($form{'url'} eq "") {
$message="Please enter your [Web Address].";
&error;
}

if ($form{'company'} eq "") {
$message="Please enter your [Comapny Name].";
&error;
}

if ($form{'website'} eq "") {
$message="Please enter your [Web Site Name].";
&error;
}

if ($form{'title'} eq "") {
$message="Please enter your [Yellow Page Name].";
&error;
}

if ($form{'slogan'} eq "") {
$message="Please enter your [Yellow Page Slogan].";
&error;
}

if ($form{'copyright'} eq "") {
$message="Please enter your [Copyright Notice].";
&error;
}

if ($form{'webmaster'} eq "") {
$message="Please enter your [E-mail Address].";
&error;
}

if (&valid_address($form{'webmaster'}) == 0) {
$message="Sorry, your [E-mail Address] is invalid.";
&error;
}

if ($form{'root'} eq "") {
$message="Please enter your [Document Root].";
&error;
}

if ($form{'cgi'} eq "") {
$message="Please enter your [CGI Folder ].";
&error;
}

if ($form{'sub'} eq "") {
$message="Please enter your [Document & CGI Sub-directory].";
&error;
}

if ($form{'emailfunction'} eq "") {
$message="Please enter your [E-mail Function].";
&error;
}

if ($form{'sendmaillocation'} eq "") {
$message="Please enter your [SendMail Location].";
&error;
}

$form{'webmaster'} =~ s/@/\\@/;

$file="config.pl";
chmod (0666, "$file");
open (CFG, ">$file");
print CFG<<FILE;
\$admin=\"$form{'admin'}\";
\$adminpwd=\"$form{'adminpwd'}\";
\$url=\"$form{'url'}\";
\$company=\"$form{'company'}\";
\$website=\"$form{'website'}\";
\$title=\"$form{'title'}\";
\$slogan=\"$form{'slogan'}\";
\$copyright=\"$form{'copyright'}\";
\$webmaster=\"$form{'webmaster'}\";
\$root=\"$form{'root'}\";
\$cgi=\"$form{'cgi'}\";
\$sub=\"$form{'sub'}\";
\$EmailFunction=\"$form{'emailfunction'}\";
\$SendMailLocation=\"$form{'sendmaillocation'}\";


;1

FILE
close CFG;
chmod (0666, "$file");

$message="Your System Configurations has been successfully updated.";
&adminstandard;
