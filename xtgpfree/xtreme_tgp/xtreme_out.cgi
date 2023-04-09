#!/usr/bin/perl
######################################################################
#                       X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################

#This is the url to your out script
###################################
$url = "http://www.18z.org";

#What percentage of surfers should go to the intended gallery
#############################################################
$pig = "70";

#NOTHING BELOW THIS LINE NEEDS TO BE TOUCHED
###########################################################

$data_file="stats.txt";
open(DAT, $data_file) || die("Could not open file!");
@raw_data=<DAT>;
close(DAT); 
foreach $main (@raw_data)
{
 chop($main);
 ($gal_out,$other_out)=split(/\|/,$main);
}



$where = $ENV{'QUERY_STRING'};

srand;
$n = int rand(100);
if ($n < $pig) 
{
$gal_out = $gal_out + 1;
$ip="stats.txt";
open(DAT,">$ip") || die("THERE WAS A FILE ERROR!");
print DAT "$gal_out|$other_out\n";
close(DAT);
print "Location: $where\n\n";
}
else
{
$other_out = $other_out + 1;
$ip="stats.txt";
open(DAT,">$ip") || die("THERE WAS A FILE ERROR!");
print DAT "$gal_out|$other_out\n"; 
close(DAT);
print "Location: $url\n\n";
}