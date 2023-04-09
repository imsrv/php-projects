#!/usr/bin/perl

use FindBin qw($Bin);
use lib "$Bin/libs";

$exp = '([^":\s<>()/;]*@[^":\s<>()/;]*)';

while(<>)       {
$message .= $_;
if(/^To: (.*)/) {
%email = ($_ =~ /$exp/ig);
                }

                }


foreach (sort keys %email) { $email = $_; }

if(-e "$Bin/users/$email")   {
open(INBOX,">>$Bin/users/$email/Inbox");
print INBOX $message;
close(INBOX);
                                }

