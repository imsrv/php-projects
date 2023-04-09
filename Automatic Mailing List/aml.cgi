#!/usr/bin/perl

##########################################################################
##																		##
##						  Automatic Mailing List						##
##						  ----------------------						##
##					   by Jimmy (wordx@hotmail.com)						##
##						http://www.smartCGIs.com						##
##																		##
##	This is a free script, if anyone sold it to you please contact me.  ##
##  Please DO NOT remove any of the copyrights or links to our site,    ##
##  they keep this CGI free for everyone. Thanks!						##
##																		##
##				     (c) copyright 2001 SmartCGIs.com					##
##########################################################################

# TERMS OF USE
# ============
# This CGI (Automatic Mailing List) can be used for free as long as all text (copyrights, 
# links, etc.) of Smart CGIs or Automatic Mailing List are not removed or modified in any way. 
# If you want to use this script without these limitations, you can register
# Automatic Mailing List for $10 at http://www.smartcgis.com/register.shtml
# Thank You.

# FOLLOW THESE INSTRUCTIONS
# =========================
# 1. Make sure you have the Net::POP3 module installed on your server.
# 2. Customize the script by defining the following variables...

# The address of your POP3 mail account:
$mail_server = "mail.yourdomain.com";

# POP3 account username:
$username = "myusername";

# POP3 account password:
$password = "mypass";

# Your e-mail address (subscribe/unsubscribe notification messages are sent from this email).
$wemail = 'unsubscribe@smartcgis.com';

# Path to Sendmail on your server.
$mailp = "/usr/lib/sendmail";

# Name of your mailing list (or site).
$sitename = "The Smart CGIs Newsletter";

# Unsubscribe instructions printed in email message.
$unsubscribe_instructions = '(To unsubscribe, simply send an e-mail to unsubscribe@smartcgis.com)';

# Full unix path and file name of mailing list file.
# Note: This file must contain 1 email address per line, and nothing else. 
#		Also, make sure the permissions of this file are set to CHMOD 777.
$efile = "/home/smart/www/cgi-bin/addresses.txt";

# Full unix path and file name of log file.
# (Leave blank if you don't want to keep logs.)
$logfile = "/home/smart/www/cgi-bin/aml/log.txt";

# Subscribe email address.
# (any person sending a message to this email address will be automatically subscribed to your mailing list)
# Leave this blank if you aren't using this script for subscribing.
$subscribe_email = 'webmaster@smartcgis.com';

# Subscribe Condition (optional): Subject of email MUST contain the following word (case insensitive).
# (If you leave this blank any person emailing the above address will be subscribed, no matter what the subject is.)
$subscribe_subject = "subscribe";

# UN-Subscribe email address.
# (any person sending a message to this email address will be automatically unsubscribed from your mailing list)
# Leave this blank if you aren't using this script for unsubscribing.
$unsubscribe_email = 'unsubscribe@smartcgis.com';

# UN-Subscribe Condition (optional): Subject of email MUST contain the following word (case insensitive).
# (If you leave this blank any person emailing the above address will be unsubscribed, no matter what the subject is.)
$unsubscribe_subject = "";

# Delete the message after the sender has been subscribed/unsubscribed?
# (Set this to zero while you test the script... just in case :)
# 1 = Yes
# 0 = No
$deletemessage = "0";



####################################
# DO NOT edit anything below this! #
####################################


use Net::POP3;

print "Content-type: text/html\n\n";

open(DATA,"$efile") || &error("Could not open $efile file ($!)");
@efile = <DATA>;
close(DATA);

# Get date and time for log file...
($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
$minute2 = $minute;
chop($minute2);
if($minute2 eq "") { $minute = "0$minute"; }
$realmonth = $month + 1;
if($year =~ /10/) {
$year = reverse $year;
chop($year);
$year = reverse $year;
}
$date = "$realmonth/$dayofmonth/$year $hour:$minute";

$subscribe_email =~ tr/A-Z/a-z/;
$unsubscribe_email =~ tr/A-Z/a-z/;
$scount = 0;
$uscount = 0;
$dcount = 0;
%messages = ();
$pop = Net::POP3->new($mail_server) || &error("Could not connect to $mail_server mail server ($!)");
$pop->login($username, $password) || &error("Could not login to $mail_server mail server ($!)");
$messages = $pop->list;
foreach $msgid (keys %$messages) {
$mymessage = $pop->get($msgid);
$to = "";
$from = "";
$subject = "";
	if($mymessage) {
	@mess = @$mymessage;
		foreach $line (@mess) {
			if ($line =~ m/To: /) {
			$line =~ s/To: // unless ($line =~ m/Reply-To:/i);
			$line =~ s/<//gm;
			$line =~ s/>//gm;
			chomp($line);
			$to = $line;
			}
			if ($line =~ m/From: /) {
			$line =~ s/From: //;
			$line =~ s/<//gm;
			$line =~ s/>//gm;
			chomp($line);
			@lines = split(/ /,$line);
				foreach $line2(@lines) {
					if($line2 =~ /\@/) { $from = $line2; }
				}
			}
			if($line =~ m/Subject: /) {
			$line =~ s/Subject: //;
			chomp($line);
			$subject = $line;
			}
		} #done message scan
		$mfound = 0;
		$to =~ tr/A-Z/a-z/;
		$from =~ tr/A-Z/a-z/;
		if($to eq $subscribe_email) { &subscribe; }
		if($to eq $unsubscribe_email) { &unsubscribe; }
		if(($mfound eq 1)&&($deletemessage eq 1)) { 
		$pop->delete($msgid); 
		$log_delete .= "$date\t Message \#$msgid deleted (Sender:$from Subject:$subject) from $mail_server mail server\n";
		$dcount++; 
		}
	}
}
$pop->quit(); #quit and delete marked messages


if(($scount > 0)||($uscount > 0)) {
open(DATA,">$efile") || &error("Could not write to $efile file ($!)");
print DATA @efile;
close(DATA);
}

if($logfile ne "") {
$log .= $log_delete;
open(DATA,">>$logfile");
print DATA $log;
close(DATA);
}

print "Done. $scount user(s) subscribed, $uscount user(s) removed, and $dcount message(s) deleted from your mail server.\n";

sub subscribe {
if($subscribe_subject eq "") {
$mfound = 1;
$already_subscribed = 0;
	foreach $email(@efile) {
	chomp($email);
		if($email eq $from) { $already_subscribed = 1; }
	$email .= "\n";
	}
	if($already_subscribed eq 1) { 
	$log .= "$date\t Subscribe error: $from is already subscribed\n";
	} else {
	push(@efile,"$from\n"); 
	$log .= "$date\t $from subscribed successfully\n";
$scount++;																																			open(MAIL,"|$mailp -t");print MAIL "To: $from\n";print MAIL "From: $wemail\n";print MAIL "Subject: Subscribe Complete\n\n";print MAIL "You have been subscribed successfully to $sitename\n";print MAIL "$unsubscribe_instructions\n\n\n";print MAIL "-----------------------------------\n";print MAIL "Automatic Mailing List CGI provided free by http://www.SmartCGIs.com\n\n"; close (MAIL);# Removing this link to SmartCGIs.com is against the terms of use for this script (It's all we ask in exchange for great free scripts!).
	}
} else {
	if($subject =~ /$subscribe_subject/i) {
	$mfound = 1;
	$already_subscribed = 0;
		foreach $email(@efile) {
		chomp($email);
			if($email eq $from) { $already_subscribed = 1; }
		$email .= "\n";
		}
		if($already_subscribed eq 1) { 
		$log .= "$date\t Subscribe error: $from is already subscribed\n";
		} else {
		push(@efile,"$from\n"); 
		$log .= "$date\t $from subscribed successfully\n";
		$scount++;																																			open(MAIL,"|$mailp -t");print MAIL "To: $from\n";print MAIL "From: $wemail\n";print MAIL "Subject: Subscribe Complete\n\n";print MAIL "You have been subscribed successfully to $sitename\n";print MAIL "$unsubscribe_instructions\n\n\n";print MAIL "-----------------------------------\n";print MAIL "Automatic Mailing List CGI provided free by http://www.SmartCGIs.com\n\n"; close (MAIL);# Removing this link to SmartCGIs.com is against the terms of use for this script (It's all we ask in exchange for great free scripts!).
		}
	}
}
}


sub unsubscribe {
if($unsubscribe_subject eq "") {
$mfound = 1;
$already_unsubscribed = 1;
@efile2 = ();
	foreach $email(@efile) {
	chomp($email);
		if($email eq $from) { $already_unsubscribed = 1; } else { push(@efile2,"$email\n"); }
	}
	if($already_unsubscribed eq 0) { 
	$log .= "$date\t Unsubscribe error: $from was not found in $efile\n";
	} else {
	@efile = @efile2;
	$log .= "$date\t $from unsubscribed successfully\n";
	$uscount++;																																				open(MAIL,"|$mailp -t");print MAIL "To: $from\n";print MAIL "From: $wemail\n";print MAIL "Subject: Unsubscribe Complete\n\n";print MAIL "You have been unsubscribed successfully from $sitename\n\n\n";print MAIL "-----------------------------------\n";print MAIL "Automatic Mailing List CGI provided free by http://www.SmartCGIs.com\n\n";close (MAIL);# Removing this link to SmartCGIs.com is against the terms of use for this script (It's all we ask in exchange for great free scripts!).
	}
} else {
	if($subject =~ /$unsubscribe_subject/i) {
	$mfound = 1;
	$already_unsubscribed = 1;
	@efile2 = ();
		foreach $email(@efile) {
		chomp($email);
			if($email eq $from) { $already_unsubscribed = 0; } else { push(@efile2,"$email\n"); }
		}
		if($already_unsubscribed eq 1) { 
		$log .= "$date\t Unsubscribe error: $from was not found in $efile\n";
		} else {
		@efile = @efile2;
		$log .= "$date\t $from unsubscribed successfully\n";
		$uscount++;																																			open(MAIL,"|$mailp -t");print MAIL "To: $from\n";print MAIL "From: $wemail\n";print MAIL "Subject: Unsubscribe Complete\n\n";print MAIL "You have been unsubscribed successfully from $sitename\n\n\n";print MAIL "-----------------------------------\n";print MAIL "Automatic Mailing List CGI provided free by http://www.SmartCGIs.com\n\n";close (MAIL);# Removing this link to SmartCGIs.com is against the terms of use for this script (It's all we ask in exchange for great free scripts!).
		}
	}
}
}


sub error 
{
my $error = shift;
print <<EOF;
<title>Error</title>
Error: $error
EOF
exit;
}
