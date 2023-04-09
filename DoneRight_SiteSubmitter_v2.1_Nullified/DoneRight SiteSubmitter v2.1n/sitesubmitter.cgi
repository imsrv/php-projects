#!/usr/bin/perl

#*********************************************************#
#   Program Name    	: Site Submitter
#   Program Version 	: 2.1
#   Program Author  	: Done Right
#   Home Page       	: http://www.done-right.net/
#   Retail Price    	: $74.99 United States Dollars
#	xCGI Price			: $00.00 United States Dollars
#   Nullified By    	: cHARLIeZ
#*********************************************************#

# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/sitesubmitter/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####


###############################################
#Gather from config
require "${path}config/config.cgi";
$images = $config{'image'};
$adminemail = $config{'adminemail'};
$mailer = $config{'mailer'};
###############################################


###############################################
#Read Input
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		$value =~ s/<([^>]|\n)*>//g;
		$FORM{$name} = $value;
	}
}
###############################################


###############################################
#Logics
if ($ENV{'QUERY_STRING'} =~ /submit/) { &submit; }
else { &main; }
###############################################


###############################################
sub modsub {
#Module Sub
require "${path}template/semod.cgi";
$selist = "$semod{'all_engines'}";
$enginelist = $selist;
@selist = split(/\|/,$enginelist);
}
###############################################


###############################################
#Main Sub
sub main {
open (FILE, "${path}template/start.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
&modsub;
@all = split(/\|/, $semod{'all_engines'});
$engines .= "<table BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
foreach $line(@all) {
	chomp($line);
	$line2 = $line;
	$line2 =~ tr/_/ /;
	if ($counter == 0) { $engines .= "<tr>\n"; }
	$engines .= "<td><input TYPE=\"checkbox\" NAME=\"$line\" VALUE=\"1\" CHECKED>&nbsp;<font size=-1>$line2</font></td>\n";
	$counter++;
	if ($counter == 4) { $engines .= "</tr>\n"; $counter = 0; }
	else { $engines .= "<td>&nbsp;&nbsp;&nbsp;</td>\n"; }
}
$engines .= "</table>";
$temp =~ s/<!-- \[engines\] -->/$engines/ig;
$temp =~ s/<!-- \[error\] -->/$error/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;
}
###############################################


###############################################
#display results sub
sub submit {
use LWP::UserAgent;

$url=$FORM{'url'};
$email=$FORM{'email'};
$timeout=$FORM{'timeout'};
if ($url eq "http://" || $url eq "") { $error .= "Please specify a valid URL<BR>"; }
if ($email !~ /.*\@.*\..*/) { $error .= "Please specify a valid Email<BR>"; }
open(FILE,"${path}template/emailblock.txt");
@email = <FILE>;
foreach $line(@email) {
	chomp($line);
	if ($line eq $email) {
		$error .= "I'm sorry but your email address has ben banned<BR>";
		last;
	}
}
if ($error) {
	&main;
	exit;
}

unless ($timeout) { $timeout = "15"; }
&modsub;
$| = 1;
open (FILE, "${path}template/submit.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/<!-- \[url\] -->/$url/ig;


@temparray = split(/\<!-- \[display\] --\>/,$temp);
$old_fh = select(OUTPUT_HANDLE);
$| = 1;
select($old_fh);
print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
EOF

foreach $name(@selist) {
	chomp($name);
	if ($FORM{$name}) {
		$sename = $sename2 = $name;
		$sename =~ tr/_/ /;

print <<EOF;
<tr>
<td height=\"40\"><b><font size=+1 face=\"verdana, helvetica\">$sename</font></b></td>
<td height=\"40\"><img src=\"$images/clockani.gif\" name=\"$sename2\" width=36 height=36></td>
<td height=\"40\"><img src=\"$images/processing.gif\" name=\"${sename2}3\" width=98 height=28></td>
<td height=\"40\"><img src=\"$images/waiting.gif\" name=\"${sename2}2\" width=103 height=28></td>
EOF
	}
}

print <<EOF;
$temparray[1]
EOF

&gather;
if ($email) { &logemail; }
&emailuser;

exit;
} #end sub submit
###############################################


###############################################
sub logemail {
$found = 0;
if (-e "${path}template/emaillog.txt") {
	open(FILE,"${path}template/emaillog.txt");
	@email = <FILE>;
	foreach $line(@email) {
		chomp($line);
		if ($line eq $email) {
			$found = 1;
			last;
		}
	}
}
if ($found == 0) {
	if (-e "${path}template/emaillog.txt") {
		open(FILE,">>${path}template/emaillog.txt");
	} else {
		open(FILE,">${path}template/emaillog.txt");
	}
	print FILE "$email\n";
	close (FILE);
}
}
###############################################


###############################################
sub emailuser {
open (FILE, "${path}template/email.txt");
@emailmess = <FILE>;
close (FILE);
foreach (@emailmess) {
	chomp ($emailmess[$rr]);
	$emailtemp .= "$emailmess[$rr]\n";
	$emailtemp =~ s/\[url\]/$url/ig;
	$rr++;	
}
if ($config{'server'} eq "nt") {
	eval { use Net::SMTP; };
	$smtp = Net::SMTP->new($mailer);
	$smtp->mail($adminemail);
	$smtp->to($email);
	
	$smtp->data();
	$smtp->datasend("To: $email\n");
	$smtp->datasend("From: $adminemail\n"); 
	$smtp->datasend("Subject: Search Engine Submission\n"); 
	$smtp->datasend($emailtemp);
	$smtp->dataend();
	$smtp->quit;
} else {
	open(MAIL,"|$mailer -t");
	print MAIL "Subject: Search Engine Submission\n";
	print MAIL "To: $email\n";
	print MAIL "From: $adminemail\n";
print MAIL <<EOF;
$emailtemp
EOF
	close(MAIL);
}

}
###############################################


###############################################
sub gather {
if ($config{'server'} eq "nt") {
	foreach (@selist) {
		$name = $selist[$i];
		if ($FORM{$name}) {
			&gather2;
		}
		$i++;
	}
} else {
	foreach (@selist) {
		$name = $selist[$i];
		if ($FORM{$name} == 1) {
			#$SIG{CHLD} = 'IGNORE';
			unless(fork) {
				&gather2;
				exit;
			}
		}
		$i++;
	}
}
}
###############################################


###############################################
#display normal results
sub gather2 {
$engname = $selist[$i];
$engurl2 = "${engname}url";
$engurl = $semod{$engurl2};
$engmessage2 = "${engname}message";
$engmessage3 = "${engname}message2";
$engmessage_2 = $semod{$engmessage3};
$engmessage = $semod{$engmessage2};
$engurl =~ s/\[url\]/$url/ig;    
$engurl =~ s/\[email\]/$email/ig;


my $ua = new LWP::UserAgent;
$ua->timeout ($timeout);
$ua->agent("AgentName/0.1 " . $ua->agent);
my $request = new HTTP::Request 'GET', $engurl;
#$ua->header('Accept' => 'text/html');
my $response = $ua->request ($request);
$searchengine = $response->content();

$searchengine=~ tr/'\n'//d;
$searchengine=~ s/<[^>]*>//g;
if ($searchengine =~ /$engmessage/ || $searchengine =~ /$engmessage_2/) {
print "
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
document.$engname.src = \"$images/clockblank.gif\" 
document.${engname}2.src = \"$images/success.gif\" 
document.${engname}3.src = \"$images/finished.gif\" 
//-->
</SCRIPT>";
} elsif ($@ =~ /timeout/) {
print "
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
document.$engname.src = \"$images/clocktimed.gif\" 
document.${engname}2.src = \"$images/timedout.gif\" 
document.${engname}3.src = \"$images/finished.gif\" 
//-->
</SCRIPT>";
} else {
print "
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
document.$engname.src = \"$images/clockblank.gif\" 
document.${engname}2.src = \"$images/failed.gif\" 
document.${engname}3.src = \"$images/finished.gif\" 
//-->
</SCRIPT>";
}
}#end sub
###############################################