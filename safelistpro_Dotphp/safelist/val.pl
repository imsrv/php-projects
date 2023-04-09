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
$ref=param('ref');

	if($automate eq "yes") {
		open(IN, "$scriptdir/dbase/holding.txt");
		chomp(@in=<IN>);
		close(IN);
		foreach $line (@in) {
			($id, $iname, $iemail, $ilogin, $ipass)=split(/\|/, $line);
			if($ref eq $id) {
				$set_found=1;
				open(OUT, ">>$scriptdir/dbase/users.txt") or die("$!");
				print OUT "$iname|$iemail|$ilogin|$ipass\n";
				close(OUT);
				open(OUT5, ">>$scriptdir/all_mails.txt");
				print OUT5 "$iemail\n";
				close(OUT5);
				#mail user
				$ua_url="$scripturl/user.cgi";
				open(IN2, "templates/mail/user_validated.txt");
				chomp(@in2=<IN2>);
				close(IN2);
				$mail_body=join("\n", @in2);
				$mail_body =~ s/%name%/$iname/gi;
				$mail_body =~ s/%email%/$iemail/gi;
				$mail_body =~ s/%username%/$ilogin/gi;
				$mail_body =~ s/%password%/$ipass/gi;
				$mail_body =~ s/%userpage%/$ua_url/gi;
				open(MAIL, "|$sendmail -t");
				print MAIL<<"EOT";
From: $mail_from
To: $email
Subject: Congratulations!


$mail_body

EOT
				close(MAIL);
				if($mail_admin eq "yes") {
					open(IN4, "templates/mail/admin_validated.txt");
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
Subject: I just joined your safelist


$mail_body2

EOT
					close(MAIL2);
				}
			}			
			if($ref ne $id) {
				push(@new, $line);
			}
		}
		# remove this entry from holding dbase
		open(OUT2, ">$scriptdir/dbase/holding.txt");
		foreach $thing (@new) {
			print OUT2 $thing;
		}
		close(OUT2);
		if($set_found eq "1") {
			$ua_url="$scripturl/user.cgi";
			open(PAGE, "templates/val_success.html");
			chomp(@page=<PAGE>);
			close(PAGE);
			$page_html=join("\n", @page);
			$page_html =~ s/%name%/$iname/gi;
			$page_html =~ s/%email%/$iemail/gi;
			$page_html =~ s/%username%/$ilogin/gi;
			$page_html =~ s/%password%/$ipass/gi;
			$page_html =~ s/%userpage%/$ua_url/gi;
			print "Content-type: text/html\n\n";
			print "$page_html\n";
			exit;
		} else {
			open(PAGE, "templates/val_failure.html");
			chomp(@page=<PAGE>);
			close(PAGE);
			$page_html=join("\n", @page);
			$page_html =~ s/%ref%/$ref/gi;
			print "Content-type: text/html\n\n";
			print "$page_html\n";
			exit;
		}
		exit;
	} else {
		$val_url="$scripturl/admin.cgi?a=val&ref=$ref&p=$admin_pass";
		open(IN4, "templates/mail/admin_validated.txt");
		chomp(@in4=<IN4>);
		close(IN4);
		$mail_body2=join("\n", @in4);
		$mail_body2 =~ s/%name%/$iname/gi;
		$mail_body2 =~ s/%email%/$iemail/gi;
		$mail_body2 =~ s/%username%/$ilogin/gi;
		$mail_body2 =~ s/%password%/$ipass/gi;
		$mail_body2 =~ s/%ref%/$ref/gi;
		$mail_body2 =~ s/%validate%/$val_url/gi;
		open(MAIL2, "|$sendmail -t");
		print MAIL2<<"EOT";
From: $iemail
To: $adminmail
Subject: Waiting for validation


$mail_body2

EOT
		close(MAIL2);
		open(PAGE, "templates/admin_notify.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%ref%/$ref/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	}
