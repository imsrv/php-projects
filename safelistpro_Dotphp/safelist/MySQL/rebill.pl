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
use Locking;

$ref=param('ref');

	$dbh=DBI->connect("DBI:mysql:database=$dbname;hostname=$dbhost", $dbuser, $dbpass, {RaiseError=>1}) or sqldie("$DBI::errstr");

$sth=$dbh->prepare("UPDATE users SET Status=\"1\" WHERE Iemail=\"$ref\"");
$sth->execute;
if($sth->rows > 0) { 

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

	}

	print "Location: $rebill_success\n\n";
	exit;

sub sqldie {
$error = $_[0];
print "Content-type: text/html\n\n";
print qq~ ERROR: $error
~;
exit;
}
1;
