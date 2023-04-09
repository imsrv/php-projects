#!/usr/bin/perl

use strict;
my $is_sendmail = 'Cannot locate sendmail';

my @send_mail = qw(
	 /usr/sbin/sendmail
	/sbin/sendmail
	/usr/bin/sendmail
	/bin/sendmail
	/usr/lib/sendmail
	/lib/sendmail
	/usr/slib/sendmail
	/slib/sendmail
	/usr/sendmail
	/sendmail
	sendmail
	/var/qmail/bin/qmail-inject
);

eval { require 5 };
my $is_perl = $@ ? 'No' : 'Yes';
my $perl_version = $];

eval { require CGI };
my $is_cgi = $@ ? 'No' : 'Yes';
my $cgi_version = $CGI::VERSION;

my $script = $0;
$script =~ s/.*\/(.*?)/$1/;

my $path = $ENV{'DOCUMENT_ROOT'};
if (eval { require Cwd; }) 
{
	use Cwd;
	$path = cwd();
}

for (@send_mail) { $is_sendmail = $_ if (-e $_); }

print "Content-Type: text/html\n\n";
print <<"HTML";
<html>
<head>
<title>Environment Checker</title>
</head>
<body>
<b>Environment Checker</b>
<hr>
<table cellspacing="5">
<tr>
<td>Is Perl Version 5 or above installed?</td><td><b>$is_perl</b></td>
</tr>
<tr>
<td>Version of Perl running on this server:</td><td><b>$perl_version</b></td>
</tr>
<tr>
<td>Is the CGI.pm module installed?</td><td><b>$is_cgi</b></td>
</tr>
<tr>
<td>Version of CGI running on this server:</td><td><b>$cgi_version</b></td>
</tr>
<tr>
<td>Full path to this script:</td><td><b>$path</b></td>
</tr>
<tr>
<td>Sendmail Path:</td><td><b>$is_sendmail</b></td>
</tr>
</table>
</body>
</html>
HTML

exit;
