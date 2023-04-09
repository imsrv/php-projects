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
$ref=param('email');

	$setfound="";
	open(IN, "$scriptdir/all_mails.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		if($ref eq $line) { 
			$setfound="1";
			$setfound2="yes";
		} else {
			$line =~ s/\n//gi;
			push(@new, $line);
		}
	}
	if($setfound eq "1") {
		open(OUT, ">$scriptdir/all_mails.txt");
		&LockDB(OUT);
		foreach $thing (@new) {
			print OUT "$thing\n";
		}
		&UnlockDB(OUT);
		close(OUT);
	}
	$setfound="";
	if($disable_removes eq "yes") {
		open(IN, "$scriptdir/dbase/users.txt");
		chomp(@in=<IN>);
		close(IN);
		foreach $line (@in) {
			($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
			if($ref eq $iemail) { 
				$newline="$iname|$iemail|$ilogin|$ipass|0|$dayjoined";
				push(@new2, $newline);
				$setfound="1";
			} else {
				$line =~ s/\n//gi;
				push(@new2, $line);
			}
		}
		if($setfound eq "1") {
			open(OUT, ">$scriptdir/dbase/users.txt");
			&LockDB(OUT);
			foreach $thing (@new2) {
				print OUT "$thing\n";
			}
			&UnlockDB(OUT);
			close(OUT);
		}
	}
	if($setfound2 eq "yes") {
		open(PAGE, "templates/removed_yes.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	} else {
		open(PAGE, "templates/removed_no.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	}
