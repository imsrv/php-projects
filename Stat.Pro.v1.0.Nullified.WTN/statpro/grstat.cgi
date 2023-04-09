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

use GD;

require "./setup.pl";
require "$cgidir/cookie.pl";

&get_data;
$go= ($in{'go'});

open(IN, "$imgfile/$go.png");
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