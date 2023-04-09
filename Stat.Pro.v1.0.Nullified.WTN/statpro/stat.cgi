#!/usr/bin/perl -w
##############################################################################
##                                                                          ##
##  Program Name         : Stat Pro                                         ##
##  Release Version      : 1.0                                              ##
##  Home Page            : http://www.cidex.ru                              ##
##  Supplied by          : CyKuH [WTN]                                      ##
##  Distribution         : via WebForum, ForumRU and associated file dumps  ##
##                                                                          ##
##############################################################################

use Socket;
use GD;

require "./setup.pl";
require "$cgidir/cookie.pl";

&get_data;

($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
($hours)=split(":",$time);

$host=$ENV{'REMOTE_ADDR'};
&GetCookies('host');

# Общая статистика
open (STAT,"+<$statall");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
chop($line);
($tkey,$tval)=split("\t",$line);
$statsu{$tkey}=$tval;
}
@stats=split ("#",$statsu{$ldate});
$stats[$hours]=$stats[$hours]+1;
$statsu{$ldate}=join("#",@stats[0..23]);
truncate(STAT,0);
seek(STAT,0,0);
foreach $key (keys %statsu){print STAT "$key\t$statsu{$key}\n";}
flock(STAT,$LOCK_UN);
close (STAT);

if ($host ne $Cookies{'host'}) { 

# Уникальная статистика
&SetCookies('host', $host);
open (STAT,"+<$statun");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
chop($line);
($tkey,$tval)=split("\t",$line);
$statsu{$tkey}=$tval;
}
@stats=split ("#",$statsu{$ldate});
$stats[$hours]=$stats[$hours]+1;
$statsu{$ldate}=join("#",@stats[0..23]);
truncate(STAT,0);
seek(STAT,0,0);
foreach $key (keys %statsu){print STAT "$key\t$statsu{$key}\n";}
flock(STAT,$LOCK_UN);
close (STAT);

}

open(IN, "$imgfile/stat.png") or &error(no_file);
$im = newFromPng GD::Image(IN); 
close(IN);

binmode STDOUT;
print "Content-type: image/gif\n" ; 
print "Pragma: no-cache\n";
print "Expires: now\n\n";
print $im->png;


###############################################################
#  Разбить на данные
###############################################################
sub get_data {

if ($ENV{'REQUEST_METHOD'} eq "POST")
    {
    read(STDIN, $bufer, $ENV{'CONTENT_LENGTH'});
    }
else
    {
    $bufer=$ENV{'QUERY_STRING'};
    }    
  @pairs = split(/&/, $bufer);
  foreach $pair (@pairs)
      {
        ($name, $value) = split(/=/, $pair);
        $name =~ tr/+/ /;
        $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $in{$name} = $value;
      }      
}
