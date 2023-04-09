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
$cgiurl = "$variables{'cgiurl'}";
$body = "$variables{'body'}";	
$randshow = "$variables{'randshow'}";	

$buffer = $ENV{'QUERY_STRING'};
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
($name,$value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/~!/ ~!/g;
$in{$name} = $value;
}
$pick = $in{'pick'};

open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);

foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[0] > $linedata[1]) { 
								push(@leftout, $line); 
								$foundleftout = "1";
								}
}
if($foundleftout eq "1") {
#pick random site that hasn't gotten an even amount of hits in return yet. (in > out)
$randnum = (int rand(@leftout))+1;
foreach $line(@leftout) {
$rand++;
@linedata = split (/\|/, $line);
if($rand eq $randnum) {
					print "<a href=\"$cgiurl/out.cgi?id=$linedata[2]\" style=\"text-decoration: none\" onmouseover=\"window.status='In:$linedata[0] Out:$linedata[1] Description: $linedata[5]';return true\" onmouseout=\"window.status=''; return true\" target=\"_blank\">$linedata[4]</a>\n";
					}
						}
} else {
if($randshow eq "0") { print "<!--- No Site Needs to be displayed. --->\n"; }
if($randshow eq "1") { &anyrandom; }
if($randshow eq "2") { print "<a href=\"$cgiurl/addlink.cgi\">Your site?</a>\n"; }
}

sub anyrandom {
$randnum = (int rand(@data))+1;
foreach $line(@data) {
$count++;
@linedata = split (/\|/, $line);
if($count eq $randnum) {
					print "<a href=\"$cgiurl/out.cgi?id=$linedata[2]\" style=\"text-decoration: none\" onmouseover=\"window.status='In:$linedata[0] Out:$linedata[1] Description: $linedata[5]';return true\" onmouseout=\"window.status=''; return true\" target=\"_blank\">$linedata[4]</a>\n";
					}
}

}