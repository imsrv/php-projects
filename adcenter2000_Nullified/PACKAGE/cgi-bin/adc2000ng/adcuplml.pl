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
#gET dATA
read (STDIN,$buf,$ENV{CONTENT_LENGTH});
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
$pdate="$month $date $year";

#pARSE dATA
($boundary)=$ENV{CONTENT_TYPE}=~/boundary="([^"]+)"/; #";
($boundary)=$ENV{CONTENT_TYPE}=~/boundary=(\S+)/ unless $boundary;
$boundary="--".$boundary;
@file=split("\r\n$boundary",$buf);
foreach (@file)
{
	s/\r\n\r\n/delimeter/;
}
($field,$data{lang})=split("delimeter",$file[0]);
($field,$data{password})=split("delimeter",$file[1]);
($field,$data{name})=split("delimeter",$file[2]);
($field,$file)=split("delimeter",$file[3]);
$name=$data{name};
@file=split(/\r\n/,$file);
open (F, "+<$basepath/$name/maillist");
flock(F,$LOCK_EX);
@emails=<F>;
$emails=join("",@emails);
foreach(@file)
{
	$_=~s/ //g;
	next if ($emails=~/\b$_\b/i);
	$emails.="$_\n";
}
truncate(F,0);
seek(F,0,0);
print F $emails;
flock(F,$LOCK_UN);
close (F);
$selectede{manml}="selected";
$selected{sendml}="selected";
open (F, "<$adcpath/langpack/$data{lang}.mtd");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if (-e "$basepath/$data{name}/tflag")
{
$trustedform1=qq~<form method="post" action="$cgi/adcuplml.pl" enctype="multipart/form-data"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="name" value="$data{name}">~;
$trustedform2=qq~</form>~;
}
open (F,"<$adcpath/template/$data{lang}/mmanmmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
