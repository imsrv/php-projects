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
$standout1 = "$variables{'standout1'}";	
$standout2 = "$variables{'standout2'}";	
$body = "$variables{'body'}";
$signup = "$variables{'signup'}";
$displaymult = "$variables{'displaymult'}";
$mintoshow = "$variables{'mintoshow'}";

$buffer = $ENV{'QUERY_STRING'};
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
($name,$value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/~!/ ~!/g;
$in{$name} = $value;
}
$start = $in{'start'};
$end = $in{'end'};
$min = $in{'min'};
##########################
##
#
if($start eq "") { 
# you can change this number if you want...
$start = 1; 
}
if($end eq "") { 
# you can change this number if you want...
$end = 20;
}
if($min eq "") { $min = $mintoshow; }
#
##
##########################
# Don't mess with anything below this.

open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
@data = sort {$b <=> $a} @data;
foreach $line(@data) {
$counter++;
@linedata = split (/\|/, $line);
if(($counter >= $start)&&($linedata[0] >= $min)) {
	if((($linedata[0]*$displaymult) > $linedata[1])||($linedata[1] eq 0)) {
						$begun = "1";
						if($linedata[0] > $linedata[1]) { print "$standout1"; }
						print "$counter. <a href=\"$cgiurl/out.cgi?id=$linedata[2]\" style=\"text-decoration: none\" onmouseover=\"window.status='In:$linedata[0] Out:$linedata[1] Description: $linedata[5]';return true\" onmouseout=\"window.status=''; return true\" target=\"_blank\">$linedata[4]</a><br>\n";
						if($linedata[0] > $linedata[1]) { print "$standout2"; }
													} else { $counter--; }
						}
						else {
							if(($signup eq "1")&&($begun ne "")) { print "$counter. <a href=\"$cgiurl/addlink.cgi\">Your site?</a><br>\n"; }
							}
if($counter eq $end) { exit; }
}
