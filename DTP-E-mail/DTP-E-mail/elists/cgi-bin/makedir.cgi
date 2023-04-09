#!/usr/bin/perl

#### Once this script is used, DELETE IT immediatly.####
#### Once this script is used, DELETE IT immediatly.####
####     Input to this script is not protected      ####

##--Place in your cgi-bin directory and chmod 755 (7=r+w+x, 5=r+x).
##--Then run from browser command line, ie http://www.yourdomain.path/cgi-bin/makedir.cgi
##--The $firstfile name can be changed now or later via your FTP program (= first list file)... for samples only.

$dir = "sets";
mkdir $dir,"766";
chmod(0766, "$dir");

$dir1 = "maillists";
mkdir $dir1,"766";
chmod(0766, "$dir1");

$dir2 = "elistdat";
mkdir $dir2,"766";
chmod(0766, "$dir2");

$dir3 = "elistdat/work";
mkdir $dir3,"766";
chmod(0766, "$dir3");

$dir4 = "elistdat/export";
mkdir $dir4,"766";
chmod(0766, "$dir4");

if (!open (NEW, "+<$dir/gmtset.pl")) {open (NEW, ">$dir/gmtset.pl");}
close (NEW); chmod(0666, "$dir/gmtset.pl");
if (!open (NEW, "+<$dir/elistset.pl")) {open (NEW, ">$dir/elistset.pl");}
close (NEW); chmod(0666, "$dir/elistset.pl");
if (!open (NEW, "+<$dir1/list1.elf")) {open (NEW, ">$dir1/list1.elf");}
close (NEW); chmod(0666, "$dir1/list1.elf");
if (!open (NEW, "+<$dir2/elist.pw")) {open (NEW, ">$dir2/elist.pw");}
close (NEW); chmod(0666, "$dir2/elist.pw");
if (!open (NEW, "+<$dir2/admin1.pl")) {open (NEW, ">$dir2/admin1.pl");}
close (NEW); chmod(0666, "$dir2/admin1.pl");
if (!open (NEW, "+<$dir2/admin2.pl")) {open (NEW, ">$dir2/admin2.pl");}
close (NEW); chmod(0666, "$dir2/admin2.pl");
if (!open (NEW, "+<$dir2/admin3.pl")) {open (NEW, ">$dir2/admin3.pl");}
close (NEW); chmod(0666, "$dir2/admin3.pl");
if (!open (NEW, "+<$dir2/admin4.pl")) {open (NEW, ">$dir2/admin4.pl");}
close (NEW); chmod(0666, "$dir2/admin4.pl");
if (!open (NEW, "+<$dir2/admin5.pl")) {open (NEW, ">$dir2/admin5.pl");}
close (NEW); chmod(0666, "$dir2/admin5.pl");
if (!open (NEW, "+<$dir2/el_help.pl")) {open (NEW, ">$dir2/el_help.pl");}
close (NEW); chmod(0666, "$dir2/el_help.pl");
if (!open (NEW, "+<$dir2/el_samp.pl")) {open (NEW, ">$dir2/el_samp.pl");}
close (NEW); chmod(0666, "$dir2/el_samp.pl");
if (!open (NEW, "+<$dir2/list1.adr")) {open (NEW, ">$dir2/list1.adr");}
close (NEW); chmod(0666, "$dir2/list1.adr");
if (!open (NEW, "+<$dir2/list1.non")) {open (NEW, ">$dir2/list1.non");}
close (NEW); chmod(0666, "$dir2/list1.non");
if (!open (NEW, "+<$dir2/list1.txt")) {open (NEW, ">$dir2/list1.txt");}
close (NEW); chmod(0666, "$dir2/list1.txt");
if (!open (NEW, "+<$dir2/progerrs.pl")) {open (NEW, ">$dir2/progerrs.pl");}
close (NEW); chmod(0666, "$dir2/progerrs.pl");
if (!open (NEW, "+<$dir2/redisplay.pl")) {open (NEW, ">$dir2/redisplay.pl");}
close (NEW); chmod(0666, "$dir2/redisplay.pl");
if (!open (NEW, "+<$dir2/result.pl")) {open (NEW, ">$dir2/result.pl");}
close (NEW); chmod(0666, "$dir2/result.pl");
if (!open (NEW, "+<$dir2/scribe.pl")) {open (NEW, ">$dir2/scribe.pl");}
close (NEW); chmod(0666, "$dir2/scribe.pl");
if (!open (NEW, "+<$dir2/showerrs.pl")) {open (NEW, ">$dir2/showerrs.pl");}
close (NEW); chmod(0666, "$dir2/showerrs.pl");
if (!open (NEW, "+<$dir2/unsubpg.pl")) {open (NEW, ">$dir2/unsubpg.pl");}
close (NEW); chmod(0666, "$dir2/unsubpg.pl");
if (!open (NEW, "+<$dir2/unsubs.pl")) {open (NEW, ">$dir2/unsubs.pl");}
close (NEW); chmod(0666, "$dir2/unsubs.pl");
if (!open (NEW, "+<$dir3/waits.wt")) {open (NEW, ">$dir3/waits.wt");}
close (NEW); chmod(0666, "$dir3/waits.wt");
if (!open (NEW, "+<$dir3/waitadd.htm")) {open (NEW, ">$dir3/waitadd.htm");}
close (NEW); chmod(0666, "$dir3/waitadd.htm");
if (!open (NEW, "+<$dir3/waituns.htm")) {open (NEW, ">$dir3/waituns.htm");}
close (NEW); chmod(0666, "$dir3/waituns.htm");

print "Content-type: text/html\n\n";
print "<html><body bgcolor=\"FFFFFF\" text=\"000000\">\n";

if (!( -e "$dir")) {print "New $dir Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir1")) {print "New $dir1 Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2")) {print "New $dir2 Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir3")) {print "New $dir3 Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir4")) {print "New $dir4 Directory not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir/gmtset.pl")) {print "$dir/gmtset.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir/elistset.pl")) {print "$dir/elistset.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/elist.pw")) {print "$dir2/elist.pw File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/admin1.pl")) {print "$dir2/admin1.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/admin2.pl")) {print "$dir2/admin2.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/admin3.pl")) {print "$dir2/admin3.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/admin4.pl")) {print "$dir2/admin4.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/admin5.pl")) {print "$dir2/admin5.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/el_help.pl")) {print "$dir2/el_help.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/el_samp.pl")) {print "$dir2/el_samp.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/list1.adr")) {print "$dir2/list1.adr File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/list1.non")) {print "$dir2/list1.non File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/list1.txt")) {print "$dir2/list1.txt File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/progerrs.pl")) {print "$dir2/progerrs.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/redisplay.pl")) {print "$dir2/redisplay.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/result.pl")) {print "$dir2/result.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/scribe.pl")) {print "$dir2/scribe.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/showerrs.pl")) {print "$dir2/showerrs.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/unsubpg.pl")) {print "$dir2/unsubpg.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir2/unsubs.pl")) {print "$dir2/unsubs.pl File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir3/waits.wt")) {print "$dir3/waits.wt File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir3/waitadd.htm")) {print "$dir3/waitadd.htm File not created.<br>\n"; $s1 = 1;}
if (!( -e "$dir3/waituns.htm")) {print "$dir3/waituns.htm File not created.<br>\n"; $s1 = 1;}

if ($s1) {print "<br>Errors Occurred! Read the Readme file for options.\n";}
else {print "No Errors reported, so the sub directory and files should be ready for you to copy to. <em>See Readme file</em>.\n";}
print "<br>Script finished, ".localtime(time).", Server Local Time.\n";
print "<p>The absolute pathname of this script is $ENV{'SCRIPT_FILENAME'}.<br>\n";
print "The relative pathname of this script (via the root directory) is $ENV{'SCRIPT_NAME'}.<br><em>Delete this script NOW!</em>.</P>\n";
print "<body><html>\n";

exit;

#### Once this script is used, DELETE IT immediatly.####
#### Once this script is used, DELETE IT immediatly.####
