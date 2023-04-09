#!/usr/bin/perl
# Delete messages

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

use Mail::Internet;
use Net::SMTP;
use Time::CTime;

&config;
&javascript;
&movemsg;
&htmlend;
exit;


sub movemsg
 {
$localmail = 1 if($localmbox);
                        
if($localmail)  {
require 'localmbox.pm';
newbox("Inbox","$Bin/users/$confdir") if(!$localmbox);
newbox("$localmbox","$Bin/users/$confdir/mbox") if($localmbox);
                }
else    {
use Net::POP3;
&pop3connect;                                    
        }

my $msgcount = scalar(@msgdelete);    

foreach $value (@msgdelete)	{

$email = readbox($value) if($localmail);
$email = $pop3->get($value) if(!$localmail);

open(MBOX,">>$Bin/users/$confdir/mbox/$folder") ||
print "Cannot write $Bin/users/$confdir/mbox/$folder: $!\n";

print MBOX "From atmail ", asctime(localtime(time));

foreach $line (@{$email})       {
print MBOX "$line";
				}
close(MBOX);

deletebox($value) if($localmail);
$pop3->delete($value) if(!$localmail);

			}

&htmlheader("Moved messages");
print "Moved $msgcount messages to <a href=\"showmail.pl?username=$username&pop3host=$pop3host&localmbox=$folder\">$folder</a>";

 }
