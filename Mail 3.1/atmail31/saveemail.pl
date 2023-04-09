#!/usr/bin/perl
# Read email via catchall email address and forward into users email
# account if it exists.

use FindBin qw($Bin);
use lib "$Bin/libs";
require "$Bin/atmail.conf";

$exp = '([^":\s<>()/;]*@[^":\s<>()/;]*)';
#open(M,">>$Bin/master.message");

while(<>)       {
$message .= $_;
#print M $_;          
if(/^To: (.*)/) {
$_ =~ s/<//g;
$_ =~ s/>//g;
$email{$1}++ if(/$exp/);  
                }

      }

# Uncomment if you want to watch people email
#open(M,">>$Bin/master.message");
#print M $message;


foreach (sort keys %email)      {
@mboxstat = stat("$Bin/users/$_/Inbox");
#print "$userquota = $mboxstat[7]\n";
if($mboxstat[7] > $userquota) { print STDERR "User disk quota exceeded!\n"; exit(69);}

open(INBOX,">>$Bin/users/$_/Inbox");
print INBOX $message;
close(INBOX);
#print "$_ %email{$_}\n";
#print M "$_ %email{'$_'}\n";

                                }
#close(M);

