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

use Net::POP3;
use Mail::Internet;
use Net::SMTP;

&config;
&javascript;
&deletemsg;
&htmlend;
exit;


sub deletemsg
 {
                        
&pop3connect;                                    
my $msgcount = scalar(@msgdelete);    

foreach $value (@msgdelete)	{
my $email = $pop3->get($value);
open(MBOX,">>$Bin/users/$confdir/mbox/Trash") ||
print "Cannot write $Bin/users/$confdir/mbox/Trash: $!\n";

foreach $line (@{$email})       {
print MBOX "$line";
				}
close(MBOX);
$pop3->delete($value);
				}
$pop3->quit;
&htmlheader("Deleted messages");

print<<_EOF;
Moved $msgcount messages to <a href="readmbox.pl?folder=Trash">Trash</a><BR>
_EOF

 }
