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
$u=param('u');
$p=param('p');
$scripturl=$scriptdirurl."/user.cgi";
$lostpass=$scriptdirurl."/lostpass.cgi";

	open(USR, "$scriptdir/dbase/users.txt");
	chomp(@usr=<USR>);
	close(USR);
	foreach $vsr (@usr) {
		($iname, $iemail, $ilogin, $ipass)=split(/\|/, $vsr);
		if($u eq $ilogin) {
			$setfound="1";
			if($p eq $ipass) {
				$setgood="1";
			}
		}
	}
	unless ($u) { &main; }
	if($setfound ne "1") { &baduser; }
	if($setgood ne "1") { &badpass; }		
	# see what we do now
	if($action eq "main") { &main; }
	elsif($action eq "user_area") { &user_area; }
	elsif($action eq "mailout") { &mailout; }
	else { &main; }

sub main {
	open(PAGE, "templates/login.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%lostpass%/$lostpass/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub user_area {
	open(PAGE, "templates/usermenu.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%u%/$u/gi;
	$page_html =~ s/%p%/$p/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub mailout {
	open(DATA, "$scriptdir/userdata/.$u");
	chomp(@data=<DATA>);
	close(DATA);
	($utime, $num)=split(/\|/, $data[0]);
	$max_allowed++;
	#change unixtime if past 24 hours
	if ($utime < (time() - 86400)) { 
		$utime = time();
		open(OUT, ">$scriptdir/userdata/.$u");
		print OUT "$utime|0";
		close(OUT);
	}
	open(DATA2, "$scriptdir/userdata/.$u");
	chomp(@data2=<DATA2>);
	close(DATA2);
	($utime, $num)=split(/\|/, $data2[0]);
	if($num < $max_allowed) {
		open(IN, "$scriptdir/all_mails.txt");
		chomp(@in=<IN>);
		close(IN);
		foreach $line (@in) {
			$mailout_subject=param('subject');
			$mailout_body=param('message');
			open(MAIL, "|$sendmail -t");
			print MAIL<<"EOT";
From: $mail_from
To: $line
Subject: $mailout_subject


$mailout_body

EOT
			close(MAIL);
		}
		$num++;
		open(OUT2, ">$scriptdir/userdata/.$u");
		print OUT2 "$utime|$num";
		close(OUT2);
		open(PAGE, "templates/mailout_success.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%scripturl%/$scripturl/gi;
		$page_html =~ s/%u%/$u/gi;
		$page_html =~ s/%p%/$p/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	} else {
		open(PAGE, "templates/mailouts_exceeded.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%scripturl%/$scripturl/gi;
		$page_html =~ s/%u%/$u/gi;
		$page_html =~ s/%p%/$p/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	}
}
sub baduser {
	open(PAGE, "templates/baduser.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub badpass {
	open(PAGE, "templates/badpass.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}	
