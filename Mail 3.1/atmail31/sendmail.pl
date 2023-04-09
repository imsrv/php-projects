#!/usr/bin/perl
# Send Email via SMTP server or sendmail binary. See Web Interface for 
# configuration

# @Mail library configuration
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
do "$Bin/html/javascript.js";

require 'Common.pm';

use Net::POP3;
use Mail::Internet;
use Net::SMTP;
use Time::CTime;
use Time::ParseDate;

&config;
&javascript;
&sendmail;
&htmlend;
exit;


sub sendmail
 {

open(MBOX,">>$Bin/users/$confdir/mbox/Sent") || print "Cannot write $Bin/users/$confdir/mbox/Sent: $!\n";
print MBOX "From ??? Fri Feb 19 09:25:01 1999\n";
print MBOX "From: $emailfrom\n";
print MBOX "To: $emailto\n";
print MBOX "Subject: $emailsubject\n";
print MBOX "\n$emailmessage\n\n";
close(MBOX);

if($fileupload) {
use MIME::Entity;

$file = $cgi->param('fileupload');
    if (!$file) {
        print "No file uploaded.";
        return;
    }

while (<$file>) { $attach .= $_; }

if($file =~ /\\/)   {
$file =~ /\\([a-z0-9]+)\.([a-z0-9]+)\Z/i;
$filename = $1;
$ext = $2;

#print "$file -> $filename -> $ext\n";

                    }

if($file =~ /\//)   {                          
$file =~ /\/([a-z0-9]+)\.([a-z0-9]+)\Z/i;      
$filename = $1;                                    
$ext = $2;                                         
print "$file -> $filename -> $ext\n";          
                        }     

my %TypeFor = qw(
    txt   text/plain
    sh    text/x-sh
    csh   text/x-csh
    pm    text/x-perl
    pl    text/x-perl                                              
    jpg   image/jpeg                                               
    jpeg  image/jpeg                                               
    gif   image/gif                                                
    gif   image/gif                                                
    tif   image/tiff                                               
    tiff  image/tiff                                               
    xbm   image/xbm                                                
    );   

    $top =  build MIME::Entity Type=>"multipart/mixed";
    $top->head->add('To', $emailto);
    $top->head->add('Subject', $emailsubject);

    $emailmessage .= "\n$signature" if($signature);

    $top->attach(Data => $emailmessage, Type =>'text/plain', Encoding => '-SUGGEST');

    $top->attach(Data => $attach,
                 Type => ($TypeFor{lc($ext)} || 'application/octet-stream'),
                 Encoding => 'base64', Filename=> "$filename.$ext");

# Send attachment email via SMTP server or sendmail binary
# CHoose which via the webcontrol panel
if(!$mailserver)        {
$mymail = $top->stringify;
smtpmail("$username\@$pop3host",$emailto,$emailsubject, $mymail) if(!$mailserver);
} else  {
 open SENDMAIL, "|sendmail -t -oi -oem"
       or die "$0: open sendmail: $!\n";
   $top->print(\*SENDMAIL);
   close SENDMAIL;
        }
    }

elsif(!$mailserver)	{
use Net::SMTP;
smtpmail("$realname <$user\@$pop3host>",$emailto,$subject, $emailmessage);
		}
else
 {
$sendmailbinary = "sendmail -t" if(!$sendmailbinary);
open(SENDMAIL,"|$sendmailbinary -t") || die "Cannot execute $sendmailbinary: $!<BR>";
print SENDMAIL "To: $emailto\n";
print SENDMAIL "From: $emailfrom\n";
print SENDMAIL "Subject: $emailsubject\n";
print SENDMAIL "X-Mailer: \@Mail $version (http://webbasedemail.net)\n\n";
print SENDMAIL "$emailmessage\n";
print SENDMAIL "$footermsg" if($footermsg);
close(SENDMAIL);
 }

&htmlheader("Sent message");
print "Sent message to $emailto ($emailsubject)<BR>";
}
