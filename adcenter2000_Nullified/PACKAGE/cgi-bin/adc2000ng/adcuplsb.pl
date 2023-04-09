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
binmode STDIN;
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
($field,$data{name})=split("delimeter",$file[0]);
($field,$data{lang})=split("delimeter",$file[1]);
($field,$data{password})=split("delimeter",$file[2]);
($field,$data{spot})=split("delimeter",$file[3]);
($field,$data{method})=split("delimeter",$file[4]);
($field,$file)=split("delimeter",$file[5]);
$name=$data{name};
$spot=$data{spot};
$field=~s/filename\=//;
$field=~s/\"//g;
@field=split(/\./,$field);
$exten=pop(@field);
($exten)=split(" ",$exten);
$filenm=join("",@field);
$exten=~tr/A-Z/a-z/;
$selected{str}="selected";
$selectede{manstr}="selected";
open (F, "<$adcpath/langpack/$data{lang}.mtd");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
open (F, "<$adcpath/langpack/$data{lang}.spb");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if (($exten eq "jpg" || $exten eq "gif") && length($file)<=$sbsize)
{
	if (-e "$basepath/$data{name}/autoaccept")
	{
	unlink ("$adcpath/sb/$data{name}.gif");
	unlink ("$adcpath/sb/$data{name}.jpg");
	unlink ("$adcpath/sb/$data{name}.ext");
	open (F,">$adcpath/sb/$name.$exten");
	flock(F,$LOCK_EX);
	binmode F;
	print F $file;
	flock(F,$LOCK_UN);
	close (F);
	if (-e "$adcpath/sb/$data{name}.gif")
	{
		$bannerco="<br><img src=\"$adcenter/sb/$data{name}.gif\" width=$sbwidth height=$sbheight>";
	}
	elsif (-e "$adcpath/sb/$data{name}.jpg")
	{
		$bannerco="<br><img src=\"$adcenter/sb/$data{name}.jpg\" width=$sbwidth height=$sbheight>";
	}
	open (FL, "<$adcpath/template/$data{lang}/musbstr.tpl");
	@htmlpage=<FL>;
	close (FL);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
	}
	unlink ("$adcpath/queye/sb/$data{name}.gif");
	unlink ("$adcpath/queye/sb/$data{name}.jpg");
	unlink ("$adcpath/queye/sb/$data{name}.ext");
	open (F,">$adcpath/queye/sb/$name.$exten");
	flock(F,$LOCK_EX);
	binmode F;
	print F $file;
	flock(F,$LOCK_UN);
	close (F);
	if (-e "$adcpath/queye/sb/$data{name}.gif")
	{
		$bannerco="<br><img src=\"$adcenter/queye/sb/$data{name}.gif\" width=$sbwidth height=$sbheight>";
	}
	elsif (-e "$adcpath/queye/sb/$data{name}.jpg")
	{
		$bannerco="<br><img src=\"$adcenter/queye/sb/$data{name}.jpg\" width=$sbwidth height=$sbheight>";
	}
	open (FL, "<$adcpath/template/$data{lang}/musbstr.tpl");
	@htmlpage=<FL>;
	close (FL);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
}
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
push (@errors, $rep[1]);
open (FL, "<$adcpath/template/$data{lang}/meusstr.tpl");
@htmlpage=<FL>;
close (FL);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
