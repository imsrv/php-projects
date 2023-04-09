#!/usr/bin/perl

##########################################################################
##																		##
##						 IntelliLink Manager Pro						##
##						 -----------------------						##
##					   by Jimmy (wordx@hotmail.com)						##
##						http://www.smartCGIs.com						##
##																		##
##	IntelliLink Pro is not a free script. If you got this from someone  ##
##  please contact me. Visit our site for up to date versions. Most		##
##  CGIs are over $100, sometimes more than $500, this script is much	##
##  less. We can keep this script cheap, as well as a free version on	##
##  our site, if people don't steal it. If you are going to use a		##
##	stolen version, please atleast DO NOT remove any of the copyrights  ##
##	or links to our site, they keep this CGI cheap for everyone.		##
##	Thanks!																##
##																		##
##				  (c) copyright 2000 The Mp3eCom Network				##
##########################################################################

print "Content-type: text/html\n\n";

require "variables.cgi";
$sitename = "$variables{'sitename'}";
$siteurl = "$variables{'siteurl'}";
$cgiurl = "$variables{'cgiurl'}";
$mailp = "$variables{'mailp'}";	
$wemail = "$variables{'wemail'}";	
$body = "$variables{'body'}";	
$report = "$variables{'report'}";	
$resetdays = "$variables{'resetdays'}";	

$buffer = $ENV{'QUERY_STRING'};
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
($name,$value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/~!/ ~!/g;
$in{$name} = $value;
}
$id = $in{'id'};

open(DATA,"reset.txt");
$reset = <DATA>;
close(DATA);
&getdate;
$timenow = time();
if($timenow > $reset+($resetdays*86400)) { &reset; }
&countout;
print <<EOF;
<META HTTP-EQUIV=REFRESH CONTENT="1; URL=$url">
<script>
self.location="$url"
</script>
<center><a href="$url">Continue</a>
EOF


sub countout {
@data = "";
$line = "";
@linedata = "";
@newlist="";
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
foreach $line(@data) {
	@linedata = split (/\|/, $line);
	if($linedata[2] eq $id) {
							$linedata[1]++;
							$url = $linedata[6];
							}
	$line = join('|',@linedata);
	push(@newlist, $line);
					}
open(DATA,">data.txt");
flock (DATA,2);
print DATA @newlist;
flock (DATA,8);
close(DATA);
}

sub reset {
if($report eq "1") { &emailreport; }
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
$totalin = "0";
$totalout = "0";
$total_active = "0";
foreach $line(@data) {
chomp($line);
@linedata = split (/\|/, $line);
$totalin = $totalin + $linedata[0];
$totalout = $totalout + $linedata[1];
	if($linedata[9] eq "") { 
						$linedata[9] = "0"; 
							}
	if($linedata[0] eq "0") { 
						$linedata[9]++ 
							}  else {
						$linedata[9] = "0"; 
						$total_active++;
							}
$linedata[0] = 0;
$linedata[1] = 0;
$line = join('|',@linedata);
push(@newlist, "$line\n");
					}
open(DATA,">data.txt");
flock (DATA,2);
print DATA @newlist;
flock (DATA,8);
close(DATA);

open(DATA,">reset.txt");
print DATA "$timenow";
close(DATA);
if($totalin > 10) { &addtolog; }

open(FILE, ">iplog.txt");
print FILE "";
close(FILE);
}

sub emailreport {
print "<center>Please Wait...<p></center>\n";
@data = "";
$line = "";
@linedata = "";
@newlist="";
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[8] ne "") {
open(MAIL,"|$mailp -t");
print MAIL "To: $linedata[7]\n";
print MAIL "From: $wemail\n";
print MAIL "Subject: $sitename Daily LE Report\n\n";
print MAIL "These are the stats for your link exchange with $sitename for yesterday:\n\n";
print MAIL "Visitors YOU sent $sitename (IN): $linedata[0]\n";
print MAIL "Visitors $sitename sent you (OUT): $linedata[1]\n\n";
print MAIL "If you wish to no longer receive this report, go to: $cgiurl/edit.cgi\n";
print MAIL "\n\n";
close (MAIL);
						}
}

}

sub addtolog {
if (-e "logs.txt") {
open(DATA,">>logs.txt");
print DATA "$totalin|$totalout|$total_active|$date\n";
close(DATA);
					} else {
					open(DATA,">logs.txt");
					print DATA "$totalin|$totalout|$total_active|$date\n";
					close(DATA);
					}
}