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
use DBI;
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
	$dbh=DBI->connect("DBI:mysql:database=$dbname;hostname=$dbhost", $dbuser, $dbpass, {RaiseError=>1}) or sqldie("$DBI::errstr");

  	if($email ne "") {
   

$sth=$dbh->prepare("SELECT * from users WHERE Iemail=\"$email\"");
  $sth->execute; $res=$sth->fetchrow_hashref;
  if($res->{'Iemail'}) {
  $iname = $res->{'Iname'}; 
  $iemail = $res->{'Iemail'};
  $ilogin = $res->{'Ilogin'};
  $ipass = $res->{'Ipass'};
  $status = $res->{'Status'};
  $dayjoined = $res->{'Dayjoined'};   
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
$sth=$dbh->prepare("SELECT * from users WHERE Ilogin=\"$user\"");
  $sth->execute; $res=$sth->fetchrow_hashref;
  if($res->{'Ilogin'}) {
  $iname = $res->{'Iname'}; 
  $iemail = $res->{'Iemail'};
  $ilogin = $res->{'Ilogin'};
  $ipass = $res->{'Ipass'};
  $status = $res->{'Status'};
  $dayjoined = $res->{'Dayjoined'};   
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
	open(PAGE, "templates/lostpass_sent.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}

sub sqldie {
$error = $_[0];
print "Content-type: text/html\n\n";
print qq~ ERROR: $error
~;
exit;
}
1;
