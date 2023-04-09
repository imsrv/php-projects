#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# admingeneral2.pl
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

if ($form{'font'} eq "") {
$message="Please enter your [Yellow Page Font Type].";
&error;
}

if ($form{'background'} eq "1") {
$form{'background'}="/$sub/pics/backgnd.gif";
}

$file="config2.pl";
chmod (0666, "$file");
open (CFG, ">$file");
print CFG<<FILE;
\$background=\"$form{'background'}\";
\$contact=\"$form{'contact'}\";
\$display=\"$form{'display'}\";
\$expired=\"$form{'expired'}\";
\$font=\"$form{'font'}\";
\$imgmax=\"$form{'imgmax'}\";
\$msgactivate=\"$form{'msgactivate'}\";
\$msgadd=\"$form{'msgadd'}\";
\$msgremove=\"$form{'msgremove'}\";
\$msgsignup=\"$form{'msgsignup'}\";
\$redirect=\"$form{'redirect'}\";
\$register=\"$form{'register'}\";
\$size=\"$form{'size'}\";
\$tell=\"$form{'tell'}\";


;1

FILE
close CFG;
chmod (0666, "$file");

$message="Your General Configuration has been successfully updated.";
&adminstandard;
