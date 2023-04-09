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
$action=param('a');
$user=param('u');
$email=param('e');
$scripturl=$scriptdirurl."/lostpass.cgi";

	# see what we do now
	if($action eq "main") { &main; }
	elsif($action eq "process") { &process; }
	else { &main; }

sub main {
	open(PAGE, "templates/lostpass.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub process {
	open(IN, "$scriptdir/dbase/users.txt") or die("$!");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($email ne "") {
			if($email eq $iemail) {
				open(MAIL, "|$sendmail -t");
				print MAIL<<"EOT";
From: $mail_from
To: $iemail
Subject: Lost Password!


Hello $iname,

Your login is: $ilogin
Password is:   $ipass

This is an automated reply from our lost 
password service.

EOT
				close(MAIL);
			}	
		}
		elsif($user ne "") {
			if($user eq $ilogin) {
				open(MAIL, "|$sendmail -t");
				print MAIL<<"EOT";
From: $mail_from
To: $iemail
Subject: Lost Password!


Hello $iname,

Your login is: $ilogin
Password is:   $ipass

This is an automated reply from our lost 
password service.

EOT
				close(MAIL);
			}			
		}
	}
	open(PAGE, "templates/lostpass_sent.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
