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

######################################################################
#mAiN sECTi0N                                                        #
######################################################################
#rEAD dATABASE aND gET bANNER
$username=$yourname;
if (-e "$adcpath/banners0/$username.jpg"){$banner="$adcenter/banners0/$username.jpg";}
else {$banner="$adcenter/banners0/$username.gif";}
#pRiNT liNK
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "Location: $banner\n\n";
 