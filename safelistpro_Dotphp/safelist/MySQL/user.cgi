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
use DBI;

$action=param('a');
$u=param('u');
$p=param('p');
$scripturl=$scriptdirurl."/user.cgi";
$lostpass=$scriptdirurl."/lostpass.cgi";

 $dbh=DBI->connect("DBI:mysql:database=$dbname;hostname=$dbhost", $dbuser, $dbpass, {RaiseError=>1}) or sqldie("$DBI::errstr");
  $sth=$dbh->prepare("SELECT * from users WHERE Ilogin=\"$u\"");
$sth->execute; $res=$sth->fetchrow_hashref;
  if ($res->{'Ilogin'}) {
    $iname = $res->{'Iname'}; 
    $iemail = $res->{'Iemail'};
    $ilogin = $res->{'Ilogin'};
    $ipass = $res->{'Ipass'};
    $status = $res->{'Status'};
    $dayjoined = $res->{'Dayjoined'};
		$setfound="1";
		if($p eq $ipass) {
			$setgood="1";
			}
		}

	unless ($u) { &main; }
	if($setfound ne "1") { &baduser; }
	if($setgood ne "1") { &badpass; }		
	# do we have autobill set?
	if($autobill_use eq "yes") {
		#check status of account
		if($status ne "1") { &rebill; }
	}
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
		&LockDB(OUT);
		print OUT "$utime|0";
		&UnlockDB(OUT);
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
			$used_remove_link = $remove_link;
			$used_remove_link =~ s/%email%/$line/gi;   
			open(MAIL, "|$sendmail -t");
			print MAIL<<"EOT";
From: $mail_from
To: $line
Subject: $mailout_subject


$mailout_body


$used_remove_link
EOT
			close(MAIL);
		}
		$num++;
		open(OUT2, ">$scriptdir/userdata/.$u");
		&LockDB(OUT2);
		print OUT2 "$utime|$num";
		&UnlockDB(OUT2);
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
sub rebill {

  $sth=$dbh->prepare("SELECT * from users WHERE Ilogin=\"$u\"");
  $sth->execute; $res=$sth->fetchrow_hashref;   
  if($res->{'email'}) {

    $iname = $res->{'Iname'}; 
    $iemail = $res->{'Iemail'};
    $ilogin = $res->{'Ilogin'};
    $ipass = $res->{'Ipass'};
    $status = $res->{'Status'};
    $dayjoined = $res->{'Dayjoined'};
    
			open(PAGE, "templates/rebill.html");
			chomp(@page=<PAGE>);
			close(PAGE);
			$page_html=join("\n", @page);
			$page_html =~ s/%scripturl%/$scripturl/gi;
			$page_html =~ s/%name%/$iname/gi;
			$page_html =~ s/%email%/$iemail/gi;
			$page_html =~ s/%username%/$ilogin/gi;
			$page_html =~ s/%password%/$ipass/gi;
			#swap out paypal info
			$paypal = qq~
<!-- Begin PayPal Logo -->
<form action="https://www.paypal.com/cgi-bin/webscr" methd="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="$paypal_account">
<input type="hidden" name="item_name" value="$paypal_item Rebill">
<input type="hidden" name="item_number" value="$ilogin">
<input type="hidden" name="amount" value="$paypal_amount">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="$scripturl/rebill.pl?ref=$iemail">
<input type="hidden" name="cancel_return" value="$paypal_rebill_return">
<input type="image" src="http://images.paypal.com/images/x-click-but6.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<!-- End PayPal Logo -->
~;
			$page_html =~ s/%paypal_code%/$paypal/gi;
			print "Content-type: text/html\n\n";
			print "$page_html\n";
			exit;
		
	}
}

sub sqldie {
$error = $_[0];
print "Content-type: text/html\n\n";
print qq~ ERROR: $error
~;
exit;
}
1;
