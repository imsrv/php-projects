#!/usr/bin/perl
#Script Tester 1.0
#Provided by CGI Connection
#http://www.CGIConnection.com

$| = 1;

use CGI;
$query = new CGI;
$query->import_names();

# Directory to store and execute uploaded scripts
# Eg. /tmp/
$tmp_dir = "!TMPDIR!/";

# Set temporary scripts to this permission level
$mode = '0755';

# DO NOT EDIT BELOW THIS LINE
#############################################
$filename = $Q::filename;
$warnings = $Q::warnings;

srand();
$tmp_filename1 = int(rand(1000000));
$tmp_filename = "$tmp_filename1\.$$";

if ($filename eq "")
 {
 print "Content-type: text/html\n\n";
 &upload_screen;
 exit;
 }

print "Content-type: text/html\n\n";
print "<HTML><BODY><PRE>\n";

open(FILE, ">$tmp_dir$tmp_filename");

while($bytesread=read($filename, $buffer, 4096))
 {
 print FILE $buffer;
 }

close(FILE);

if (-s "$tmp_dir$tmp_filename" <= 0)
 {
 print "File did not upload!\n";
 exit;
 }

chmod oct($mode), "$tmp_dir$tmp_filename";

if ($warnings eq "")
 {
 $wc = "-c";
 }
 else
 {
 $wc = "-wc";
 }

$tmpfilen1 = rindex($filename, "\\");
$tmpfilen2 = rindex($filename, "/");

if ($tmpfilen2 > $tmpfilen1)
 {
 $tmpfilen1 = $tmpfilen2;
 }

$tmpfilen1++;
$sfname = substr ($filename, $tmpfilen1);

print "<B>Testing:</B> $sfname\n";
print "<B>Temporary Name:</B> $tmp_filename\n";
print "<B>Permissions:</B> $mode\n\n";

$out = `perl $wc $tmp_dir$tmp_filename 2>&1`;
unlink ("$tmp_dir$tmp_filename");

splice(@lines, 0);
@lines = split(/\n/, $out);

for ($j = 0; $j < @lines; $j++)
 {
 $count = $j + 1;
 print "<B>[$count]</B> @lines[$j]\n";
 }

print "\n\nFinished!\n";
print "</PRE></BODY></HTML>";

exit;

sub upload_screen
{
print<<END
<HTML><BODY>
<CENTER>
<H2>Script Tester</H2>

<TABLE BORDER=0>
<FORM ENCTYPE="multipart/form-data" METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<TR><TD>Script Filename:</TD> <TD><INPUT TYPE=FILE NAME=filename></TD></TR>
<TR><TD><INPUT TYPE=CHECKBOX NAME=warnings VALUE="YES"> Show Warnings</TD></TR>
<TR><TD><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Upload"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

