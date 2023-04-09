#!/bin/perl
######################################################################
# ADCenter 2000NG (Released 15.04.00)	            	             #
#--------------------------------------------------------------------#
# Copyright 1999-2000 TRXX Programming Group                         #
# Programming by Michael "TRXX" Sissine                              #
# All Rights Reserved                                                #
# Supplied by : Croif                                                #
# Nullified by: CyKuH                                                #
######################################################################
open (F, "<adc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

$getcode=$ENV{QUERY_STRING};
$getcode=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
($user,$spot)=split("&",$getcode);
print "HTTP/1.0 200 OK\n";
print "content-type: text/html\n\n";
print qq~document.write('<a href="$cgi/adcclick.pl?$user" target="_top"><img src="$adcenter/images/network$spot.gif" border=0 width=$banwidth[$spot] height=$mbanheight></a>');~;
