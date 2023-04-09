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
($file,$spot,$random)=split("&",$ENV{QUERY_STRING});
open(F,"<$adcpath/queye/$spot/$file");
binmode F;
@file=<F>;
close(F);
($fl,$ext)=split(/\./,$file);
$ext="jpeg" if ($ext eq "jpg");
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: image/$ext\n\n";
binmode STDOUT;
print @file;
