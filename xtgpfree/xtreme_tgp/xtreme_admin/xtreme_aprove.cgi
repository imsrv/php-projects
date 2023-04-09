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


sub delete {




$data_file="aprove.txt";
open(DAT, "<$path/$data_file") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);

foreach $main (@raw_data)
{
 chop($main);
 ($name,$email,$count,$url,$ip,$type)=split(/\|/,$main);
 $check = $check + 1;

if ($check == $cnt)
{
$data_file="list.txt";
open(DAT, "<$path/$data_file") || die("Could not open file!");
@re=<DAT>;
close(DAT);   

$file = "list.txt";
open(DAT,">$path/$file") || die("THERE WAS A FILE ERROR!");
print DAT "$name|$email|$count|$url|$ip|$type\n"; 
print DAT "@re";
}
else
{
}
}
close(DAT);

$cnt = $cnt -1;
$sitedata="aprove.txt";

open(DAT, "<$path/$sitedata") || die("Cannot Open File");
@raw_data=<DAT>; 
close(DAT);

splice(@raw_data,$cnt,1);

open(DAT,">$path/$sitedata") || die("Cannot Open File");
print DAT @raw_data; 
close(DAT);


print <<HTML2;   
ADDED
<META HTTP-EQUIV="Refresh" CONTENT="0; URL=xtreme_admin.cgi">
HTML2

}

&delete;




