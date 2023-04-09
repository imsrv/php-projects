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
$pass=param('p');
$scripturl=$scriptdirurl."/signup.cgi";

	# see what we do now
	if($action eq "main") { &main; }
	elsif($action eq "process") { &process; }
	else { &main; }

sub main {
	open(PAGE, "templates/signup.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%user%/$user/gi;
	$page_html =~ s/%pass%/$pass/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub process {
	$name=param('name');
	$email=param('email');
	$login=param('login');
	$pass=param('password');
	if(length($name) < 1) {$response .= "Full name was not entered. <BR>\n";}
	if(length($email) < 1) {$response .= "Email address not entered. <BR>\n";}
	if(length($login) < 1) {$response .= "A username was not entered. <BR>\n";}
	if(length($pass) < 1) {$response .= "A password was not entered. <BR>\n";}
	if($response ne "") { &err; }
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		($iname, $iemail, $ilogin, $ipass)=split(/\|/, $line);
		if($iemail eq $email) {
			$response .= "That Email is already in our databases.<br>\n";
		}	
		if($ilogin eq $login) {
			$response .= "The username $login is already taken.<br>\n";
		}	
	}
	open(IN2, "$scriptdir/dbase/holding.txt");
	chomp(@in2=<IN2>);
	close(IN2);
	foreach $line2 (@in2) {
		($id, $iname, $iemail, $ilogin, $ipass)=split(/\|/, $line2);
		if($iemail eq $email) {
			$response .= "That Email is already in our databases.<br>\n";
		}
		if($ilogin eq $login) {
			$response = "The username $login is already taken.<br>\n";
		}	
	}
	if($response ne "") { &err; }
	# if we passed all checks lets add it to the holding database
	$id=time();
	open(OUT, ">>$scriptdir/dbase/holding.txt");	
	print OUT "$id|$name|$email|$login|$pass\n";
	close(OUT);
	#read in mail template
	open(IN2, "templates/mail/signup_mail.txt");
	chomp(@in2=<IN2>);
	close(IN2);
	$mail_body=join("\n", @in2);
	$mail_body =~ s/%name%/$name/gi;
	$mail_body =~ s/%email%/$email/gi;
	$mail_body =~ s/%username%/$login/gi;
	$mail_body =~ s/%password%/$pass/gi;
	#mail user
	open(MAIL, "|$sendmail -t");
	print MAIL<<"EOT";
From: $mail_from
To: $email
Subject: $mail_subject


$mail_body

EOT
	close(MAIL);
	# display submission good page
	open(PAGE, "templates/signup_success.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%name%/$name/gi;
	$page_html =~ s/%email%/$email/gi;
	$page_html =~ s/%username%/$login/gi;
	$page_html =~ s/%password%/$pass/gi;
	#swap out paypal info
	$paypal = qq~
<!-- Begin PayPal Logo -->
<form action="https://www.paypal.com/cgi-bin/webscr" methd="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="$paypal_account">
<input type="hidden" name="item_name" value="$paypal_item">
<input type="hidden" name="item_number" value="$id">
<input type="hidden" name="amount" value="$paypal_amount">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="$scripturl/val.cgi?ref=$id">
<input type="hidden" name="cancel_return" value="$paypal_return">
<input type="image" src="http://images.paypal.com/images/x-click-but6.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<!-- End PayPal Logo -->
~;
	$page_html =~ s/%paypal_code%/$paypal/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub err {
	$bottom .= "Please <a href=\"javascript\:window.history.go(-1)\">click here</a> to correct<BR>\n";
	$bottom .= "the error(s) and submit your input again.<P>\n";
	$reason=${response};
	open(PAGE, "templates/error.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%reason%/$reason/gi;
	$page_html =~ s/%bottom%/$bottom/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
