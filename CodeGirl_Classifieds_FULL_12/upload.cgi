#!/usr/local/bin/perl
use CGI;
use vars qw(%config %form %category %left %right %form %supercat);
use strict;

#####################################################
# Configuration section
#####################################################


$config{'basedir'} = "/path/to/your/pictures/pictures";
$config{'imageuploadurl'} = "http://yourdomain.com/pictures";
$config{'windows'} = 'no';
$config{'returnurl'} = 'http://yourdomain.com/cgi-bin/classifieds.cgi';
$config{'mailerror'} = 'admin\@codegirl.virtualave.net';

#####################################################
# Main Program
#####################################################

umask(000);
mkdir("$config{'basedir'}", 0777) unless (-M "$config{'basedir'}");
$| = 1;
&delpic;

my $buffer;
my $bound;
my @parts;
my $filename;
my @subparts;
my @stuff;
my $totalT;
my $fname;
my @a;
my $extension;
my $directory;
my $mailerror;

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
$buffer =~ /^(.+)\r\n/;
$bound = $1;
@parts = split(/$bound/,$buffer);

$filename=$parts[1];
$parts[1] =~ s/\r\nContent\-Disposition.+\r\n//g;
$parts[1] =~ s/Content\-Type.+\r\n//g;
$parts[1] =~ s/^\r\n//;

@subparts = split(/\r\n/,$parts[2]);
$directory = $subparts[3];
$directory =~ s/\r//g;
$directory =~ s/\n//g;	#got the directory name

$filename =~ s/Content-Disposition\: form-data\; name=UploadedFile\; filename\=//g;
@stuff=split(/\r/,$filename);
$filename = $stuff[1];
$filename =~ s/\"//g;
$filename =~ s/\r//g;
$filename =~ s/\n//g;

@a=split(/\\/,$filename);
$totalT = @a;
--$totalT;
$fname=$a[$totalT];

@a=split(/\//,$fname);		
$totalT = @a;
--$totalT;
$fname=$a[$totalT];

@a=split(/\:/,$fname);		
$totalT = @a;
--$totalT;
$fname=$a[$totalT];

@a=split(/\"/,$fname);		
$filename=$a[0];

if($parts[1] !~ m/[\w\d]/)
{
	print "Content-Type: text/html\n\n";
	print "<html>\n<title>Error!</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "You did not provide a file to be uploaded or it is empty.<BR>\n";
	print "Press your browsers BACK button to try again.";
	print "</html>\n";
	exit 0;
}



$extension = (split(/\./,$filename))[-1];
if ($extension !~ /(gif|jpg)/i )	{
 print "Content-Type: text/html\n\n";
	print "<html>\n<title>Error!</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "<DIV ALIGN=CENTER><H4><FONT COLOR=RED>ERROR - FILE TYPE NOT ALLOWED\!</FONT></H4><P>\n";
	print "You can only upload a jpg or gif file.<BR>\n";
	print "<b>or</b><BR>\n";
	print "This routine does not work with your version of Internet Explorer.<P>\n";
	print "Press your browsers BACK button to try again.</DIV>";
	print "</html>\n";
	exit 0;
}

if ($ENV{'CONTENT_LENGTH'} >= 100000) {
	print "Content-Type: text/html\n\n";
	print "<html>\n<title>File size is too large!</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "<DIV ALIGN=CENTER><H4><FONT COLOR=RED>ERROR - IT'S TOO BIG\!</FONT></H4><P>\n";
	print "Sorry but you are not authorized to upload files over 100k.<br>\n";
	print "Please only upload files less than 100k in size.</DIV>";
	print "</html>\n";
	exit 0;
}


$directory = $config{'basedir'};
$filename = time . '.' . $extension;
open(REAL,">$directory/$filename") || &error($!);
binmode REAL;
print REAL $parts[1];
close(REAL);

if($config{'windows'} ne 'yes')	{	#chmod it for unix systems
	`chmod 777 $directory$filename`;
}



if(-e "$directory/$filename") {
	print "Content-Type: text/html\n\n";
	print "<html>\n<title>Upload Successful</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
 print "<center>\n";
	print "<b>Upload Complete</b>\n";
	print "<br><br>\n";
	print "<b>File Name</b>: $filename<br>\n";
	print "<b>Size</b>: $ENV{'CONTENT_LENGTH'} bytes\n";
	print "<br><br>\n";
 	print "<img src=\"$config{'imageuploadurl'}/$filename\"><br><br>\n";
	print "<A HREF=$config{'returnurl'}?action=uploaddone\&image=$filename\&extension=$extension>Click here to continue</A>";
	print "</center>\n</body>\n</html>";
	exit 0;
}
else {
	print "Content-Type: text/html\n\n";
	print "<html>\n<title>Upload Unsuccessful</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "The upload was unsuccessful\.\.\.unable to create $directory.\n";
	print "<br><b>Error Message</b>\n";
	print "<pre>$!</pre>\n";
	print "Click <A HREF=mailto:$mailerror>HERE</A> to notify the site administrator";
	print "</html>\n";
	exit 0;
}

#------------------------------------------------------#
#Sub: Error
#------------------------------------------------------#
sub error {
#------------------------------------------------------#

	print "Content-Type: text/html\n\n";
	print "<html>\n<title>Error!</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "Could not create/delete <b>$directory</b>\n";
	print "<br><b>Error message:</b>$_[0]\n";
	print "<br>Click <A HREF=mailto:$mailerror>HERE</A> to notify the site administrator";
	print "</body>\n</html>\n";
	exit 0;
}

sub unable{
#------------------------------------------------------#

	print "Content-type: text/html\n\n";
	print "<html>\n";
	print "<title>Error</title>\n";
	print "<body bgcolor=\"\#ffffff\" text=\"\#000000\">\n";
	print "Unable to open: $_[0]\n";
	print "Click <A HREF=mailto:$mailerror>HERE</A> to notify the site administrator";
	print "</html>\n";
	exit 0;
}


sub delpic {
#------------------------------------------------------#
 my @allfiles;
 my $file;
 my $filedate;
 my $key;
 my $checktime = time;

 opendir PICDIR, "$config{'basedir'}" || &error($!);
 @allfiles = readdir PICDIR;
 closedir PICDIR;
     foreach $file (@allfiles) {
         if (length($file) == 13) {
             $filedate = substr($file, 0, 9);
                 if (($checktime - $filedate) > 600) { # 10 minutes
                     unlink ("$config{'basedir'}/$file") || &error($!);
                 }
         }
     }
}

#------------------------------------------------------#
1;
