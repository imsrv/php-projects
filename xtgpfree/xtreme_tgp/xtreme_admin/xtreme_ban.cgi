#!/usr/bin/perl

######################################################################
#                        X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################
$path = "/home/darkforce/newraw";

#NOTHING BELOW THIS LINE NEEDS TO BE TOUCHED
###########################################################

$cnt = $ENV{'QUERY_STRING'};
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
        ($name, $value) = split(/=/, $pair);
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ s/<([^>]|\n)*>//g;
        if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
        else { $INPUT{$name} = $value; }
}  

print "Content-type:text/html\n\n";
@months
=('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');

$time = time;
$reset_offset = $reset_offset * 3600;
$time = $time + $reset_offset;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$sunday = $yday - $wday;
$weekly="weekly.txt";



$aproveme="ban.txt";
open(DAT,">>$aproveme") || die("THERE WAS A FILE ERROR!");
print DAT "$INPUT{'ip'}|$now\n"; 
close(DAT);

sub main {



print <<HTML2;   

Added




HTML2

}

&main;






