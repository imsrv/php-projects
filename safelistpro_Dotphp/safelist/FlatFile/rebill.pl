#!/usr/bin/perl
#########################################################
#     SafeList - A full pay to join Opt in mail site    #
#########################################################
#                                                       #
#                                                       #
# This script was created by:                           #
#                                                       #
# PerlCoders Web Development Division.                  #
# http://www.perlcoders.com/                            #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are copyright 2001              #
# PerlCoders (http://perlcoders.com) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Purchasers are granted rights to use this script      #
# on any site they own. There is no individual site     #
# license needed per site.                              #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the authors at       #
# staff@perlcoders.com or info@perlcoders.com           #
#                                                       #
#########################################################

use CGI ':cgi';
use Configs;
use Locking;

$ref=param('ref');

	open(USR, "$scriptdir/dbase/users.txt");
	chomp(@usr=<USR>);
	close(USR);
	foreach $vsr (@usr) {
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $vsr);
		if($ref eq $iemail) {
			$newline="$iname|$iemail|$ilogin|$ipass|1|$dayjoined";
			push(@new, $newline);
			$setfound="1";
			open(IN4, "templates/mail/admin_rebilled.txt");
			chomp(@in4=<IN4>);
			close(IN4);
			$mail_body2=join("\n", @in4);
			$mail_body2 =~ s/%name%/$iname/gi;
			$mail_body2 =~ s/%email%/$iemail/gi;
			$mail_body2 =~ s/%username%/$ilogin/gi;
			$mail_body2 =~ s/%password%/$ipass/gi;
			#mail user
			open(MAIL2, "|$sendmail -t");
			print MAIL2<<"EOT";
From: $iemail
To: $adminmail
Subject: I just renewed to your safelist.


$mail_body2

EOT
			close(MAIL2);
		} else {
			$vsr =~ s/\n//gi;
			push(@new, $vsr);
		}
	}
	if($setfound eq "1") {
		open(OUT, ">$scriptdir/dbase/users.txt");
		&LockDB(OUT);
		foreach $line (@new) {
			print OUT "$line\n";
		}
		&UnlockDB(OUT);
	}
	print "Location: $rebill_success\n\n";
	exit;

