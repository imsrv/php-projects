#!/usr/bin/perl
# Check Email
# Non MIME Version

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

&config;
&readmbox;
&htmlend;
exit;

sub readmbox
 {
&htmlheader("Reading $folder ...");
open(MBOX,"$Bin/users/$confdir/mbox/$folder");
while(<MBOX>)
{
$_ =~ s/\n/<BR>/g;
print $_;
}
close(MBOX);
 }
