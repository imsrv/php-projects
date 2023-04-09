#!/usr/bin/perl

#### Once this script is used, DELETE IT immediatly.####
#### Once this script is used, DELETE IT immediatly.####
####     Input to this script is NOT protected      ####

##--Place in your cgi-bin directory and chmod 755 (7=r+w+x, 5=r+x).
##--Then run from browser command line, ie http://www.yourdomain.path/cgi-bin/makedir.cgi

$dir = "sets";
mkdir $dir,"766";
chmod(0766, "$dir");

$dir1 = "mrglists";
mkdir $dir1,"766";
chmod(0766, "$dir1");

if (!open (NEW, "+<$dir/gmtset.pl")) {open (NEW, ">$dir/gmtset.pl");}
close (NEW); chmod(0766, "$dir/gmtset.pl");
if (!open (NEW, "+<$dir/lmrgeset.pl")) {open (NEW, ">$dir/lmrgeset.pl");}
close (NEW); chmod(0766, "$dir/lmrgeset.pl");
if (!open (NEW, "+<$dir1/mrgml.pw")) {open (NEW, ">$dir1/mrgml.pw");}
close (NEW); chmod(0766, "$dir1/mrgml.pw");
if (!open (NEW, "+<$dir1/admn1.pl")) {open (NEW, ">$dir1/admn1.pl");}
close (NEW); chmod(0766, "$dir1/admn1.pl");
if (!open (NEW, "+<$dir1/admn2.pl")) {open (NEW, ">$dir1/admn2.pl");}
close (NEW); chmod(0766, "$dir1/admn2.pl");
if (!open (NEW, "+<$dir1/admn3.pl")) {open (NEW, ">$dir1/admn3.pl");}
close (NEW); chmod(0766, "$dir1/admn3.pl");
if (!open (NEW, "+<$dir1/admn4.pl")) {open (NEW, ">$dir1/admn4.pl");}
close (NEW); chmod(0766, "$dir1/admn4.pl");
if (!open (NEW, "+<$dir1/admn5.pl")) {open (NEW, ">$dir1/admn5.pl");}
close (NEW); chmod(0766, "$dir1/admn5.pl");

print "Content-type: text/html\n\n";
print "<html><body bgcolor=\"FFFFFF\" text=\"000000\">\n";

if (!( -e "$dir")) {print "New $dir Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1")) {print "New $dir1 Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir/gmtset.pl")) {print "$dir/gmtset.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir/lmrgeset.pl")) {print "$dir/lmrgeset.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1/mrgml.pw")) {print "$dir1/mrgml.pw File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1/admn1.pl")) {print "$dir1/admn1.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1/admn2.pl")) {print "$dir1/admn2.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1/admn3.pl")) {print "$dir1/admn3.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1/admn4.pl")) {print "$dir1/admn4.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1/admn5.pl")) {print "$dir1/admn5.pl File not created.<br>\n"; $s1 = 1;}

if ($s1) {print "<br>Errors Occurred! Read the Readme file for options.\n";}
else {print "No Errors reported, so the sub directory and files should be ready for you to copy to (FTP). <em>See Readme file</em>.\n";}
print "<br>Script finished, ".localtime(time).", Server Local Time.\n";
print "<p>The absolute pathname of this script is $ENV{'SCRIPT_FILENAME'}.<br>\n";
print "The relative pathname of this script (via the root directory) is $ENV{'SCRIPT_NAME'}.<br><em>Delete this script NOW!</em>.</P>\n";
print "<body><html>\n";

exit;

#### Once this script is used, DELETE IT immediatly.####
#### Once this script is used, DELETE IT immediatly.####
