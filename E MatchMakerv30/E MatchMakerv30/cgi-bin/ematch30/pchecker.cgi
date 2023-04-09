#!/usr/local/bin/perl

require 'email-lib.pl';
require 'setup.cgi';

#################################################
# Password Checker for e_Match
#################################################
# CONFIGURATION SECTION


# The subject line for the email message.

	$subject = 'Your e_Match Nickname and Password';

# END OF CONFIGURATION SECTION
#################################################

sub get_form_data {
	read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'});
	if ($ENV{'QUERY_STRING'}) {
		$buffer = "$buffer\&$ENV{'QUERY_STRING'}"
	}
	@pairs = split(/&/,$buffer);
	foreach $pair (@pairs) {
		($name,$value) = split(/=/,$pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
		$FORM{$name} = $value
	}
}

&get_form_data;

unless(exists($FORM{'email'})) {

print <<INPUT;
Content-type: text/html

<html><head></head><body>
<form action="$ENV{'SCRIPT_NAME'}" method=POST>
Email: <input type=text name=email>
<input type=submit>
</form>
</body></html>
INPUT
exit;
}

open(LOGFILE,"$logpath/$log") || &system_error("Can't read log.\n");
@lines = <LOGFILE>;
close(LOGFILE);

for $line (@lines) {
	@item = split(/\t/, $line);
	if($FORM{'email'} eq $item[2]) {
		$from = $admin;
		$to = $item[2];
		$message = "Hi!\n\nYour nickname is: $item[0]\nYour password is: $item[1]\n\ne_Match Admin";
		&email($from, $to, $smtp, $subject, $message);

		print "Content-type: text/html\n\n";
		print "<html><head></head><body>\n";
		print "<h2>Your nickname and password will arrive via email shortly.</h2>\n";
		print "</body></html>";
		exit;
	}
}
print "Content-type: text/html\n\n";
print "<html><head></head><body>\n";
print "<h2>Your nickname could not be found.</h2><hr>\n";
print "Use your browser's [Back] Button to return to the form and check your spelling.\n";
print "</body></html>";
exit;

#################################################
# Error Subs

sub system_error {
	local($errmsg) = @_;
	&print_header("System Error");
	print $errmsg;
	&print_footer;
	exit;
}

sub print_header {
	local($title) = @_;
	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<HEAD>\n";
	print "<TITLE>$title</TITLE>\n";
	print "</HEAD>\n";
	print "<BODY>\n";
	print "<H1>$title</H1>\n";
}

sub print_footer {
	print "</BODY>\n";
	print "</HTML>\n";
}


