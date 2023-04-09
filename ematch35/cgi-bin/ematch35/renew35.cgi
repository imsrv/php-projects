#!/usr/local/bin/perl

require 'setup35.cgi';

#################################################
# renew35.cgi
#
# This script receives a password, and an email address.
#
# If the password is correct, it searches the users.log file
# for the email address and extends that user's subscription
# by the number of days specified below.
#################################################
# CONFIGURATION

# Your password to access this script via your browser.

	$password = 'toolbox';

# Number of days to extend user's membership.

	$extend = 90;

#################################################

&get_form_data;

if($FORM{'password'} ne $password) {
	&return_page("Access denied", "You do not have permission to access this resource.$ENV{'QUERY_STRING'}");
}

open(XLOG,"+>>$logpath/$xlog") || &return_page('System Error', "Can't write to $xlog.(26)\n");
flock XLOG, 2 if $lockon eq 'yes';
seek (XLOG, 0, 0);
@lines = <XLOG>;

for($i=0;$i<=$#lines;$i++) {
	if($lines[$i] =~ /\t$FORM{'email'}\t/) {
		$xline = $line[$i];
		splice(@lines, $i, 1);
		last;
	}
}

seek (XLOG, 0, 0);
truncate (XLOG, 0);
print XLOG @lines;
close(XLOG);

open(LOG,"+>>$logpath/$log") || &return_page('System Error', "Can't write to $log.(42)\n");
flock LOG, 2 if $lockon eq 'yes';

seek (LOG, 0, 0);
@lines = <LOG>;

push(@lines, $xline) if $xline;

foreach $line (@lines) {
	if($line =~ /\t$FORM{'email'}\t/) {
		chomp($line);
		($nickname, $password, $email, $time, $status) = split (/\t/, $line);
		$status = time if $status < time;
		$status += $extend*60*60*24;
		$line = "$nickname\t$password\t$email\t$time\t$status\n";
		last;
	}
}

seek (LOG, 0, 0);
truncate (LOG, 0);
print LOG @lines;

close(LOG);
print <<RET;
Content-type: text/html

<html><head></head><body>
$nickname - $extend days.
</body></html>
RET
exit;

sub get_form_data {
	read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'});
	if ($ENV{'QUERY_STRING'}) {
		$buffer = "$buffer\&$ENV{'QUERY_STRING'}"
	}
	@pairs = split(/&/,$buffer);
	foreach $pair (@pairs) {
		($name,$value) = split(/=/,$pair);
		$value =~ tr/+/ /;
		$value =~ s/%0a//gi;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
		#$value =~ s/([;<>\*\|\`'\$!#\(\)\[\]\{\}:"])/\\$1/g; #security
		$FORM{$name} = $value
	}
}


#################################################
# Return HTML

sub return_page {
	my($heading, $message) = @_;
	&print_header($heading);
	print $message;
	&print_footer;
	exit;
}

sub print_header {
	local($title) = @_;
	print "Content-type: text/html\n\n";
	print "<HTML><HEAD>\n";
	print "<TITLE>$title</TITLE>\n";
	print "</HEAD><BODY>\n";
	print "<H1>$title</H1><hr>\n";
}

sub print_footer {
	print "</BODY></HTML>\n";
}
