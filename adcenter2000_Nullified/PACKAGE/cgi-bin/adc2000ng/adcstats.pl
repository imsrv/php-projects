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
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
if ($ENV{CONTENT_LENGTH}>0){if ($sysid eq "Windows"){read(STDIN,$data,$ENV{CONTENT_LENGTH});} else {$data=<STDIN>;}}
else {($data=$ENV{QUERY_STRING});}
@query=split("&",$data);
foreach (@query)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9A-Fa-f]{2})/pack('C',hex($1))/eg;
		$data{$field}=$value;
	}
}
$data{lang}=$defaultlanguage unless ($data{lang});
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@users=<F>;
flock(F,$LOCK_UN);
close(F);
$totalusers=@users;
$todayusers=0;
$todayimp=0;
$todayclc=0;
$totalimp=0;
$totalclc=0;
foreach(@users)
{
	($unme)=split("\t",$_);
	$i=0;
	while($i<$totalbanner)
	{
		open (STAT,"<$basepath/$unme/impressions$i");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach $temp(@temp){$totalimp+=$temp;}
			if ($tkey=~/ $date / && $tkey=~/ $month / && $tkey=~/ $year/)
			{
				foreach $temp(@temp){$todayimp+=$temp;}
			}
		}
		flock(STAT,$LOCK_UN);
		close(STAT);
		open (STAT,"<$basepath/$unme/clicks$i");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$totalclc+=$_;}
			if ($tkey=~/ $date / && $tkey=~/ $month / && $tkey=~/ $year/)
			{
				foreach(@temp){$todayclc+=$_;}
			}
		}
		flock(STAT,$LOCK_UN);
		close(STAT);
		$i++;
	}
	$todayusers++ if (-M "$basepath/$unme/join"<1);
}
if ($totalimp)
{
	$totalctr=$totalclc/$totalimp;
	$totalctr=substr($totalctr,0,5);
}
else {$totalctr=0;}
if ($todayimp)
{
	$todayctr=$todayclc/$todayimp;
	$todayctr=substr($todayctr,0,5);
}
else {$todayctr=0;}
open (F,"<$adcpath/template/$data{lang}/netstats.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
