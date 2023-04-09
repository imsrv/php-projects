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
@data=split("; ",$ENV{HTTP_COOKIE});
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex ($1))/eg;
		$cooki{$field}=$value;
	}
}
@data=();
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$date,$month,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
($hours)=split(":",$time);
($cookie{adcenterurl},$cookie{adcentersource})=split("&",$ENV{QUERY_STRING});
if (!$cookie{adcenterurl} || !$cookie{adcentersource})
{
	print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
	print "Location: $adcenter/errclick.html\n\n";
	exit;
}
if (!$ENV{HTTP_REFERER} && $logrefererfault)
{
	open(F,">>$basepath/$cookie{adcentersource}/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tCant resolve referer address\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
if (!$ENV{HTTP_USER_AGENT} && $logagentfault)
{
	open(F,">>$basepath/$cookie{adcentersource}/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tCant resolve user agent\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
$templine="adcngaccsb$cookie{adcentersource}";
if ($cooki{$templine})
{
	($howmany,$fromwhere)=split("#",$cooki{$templine});
	$howmany++;
	$fromwhere.=",$ENV{REMOTE_ADDR}" unless ($fromwhere=~/$ENV{REMOTE_ADDR}/);
	@fromwhere=split(",",$fromwhere);
	$totalfrom=scalar (@fromwhere);
	if ($howmany>$logallowclcperbrowser || $totalfrom>$logallowipperbrowser)
	{
	open(F,">>$basepath/$cookie{adcentersource}/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tLimit for clicks or IPs per browser is exceed (CLC:$howmany IPS: $totalfrom)\t$fromwhere\n";
	flock(F,$LOCK_UN);
	close(F);
	}
}
else
{
	$howmany=1;
	$fromwhere=$ENV{REMOTE_ADDR};
}



#p0ST sTATiSTiCS
$bun=$cookie{adcenterurl};
$sun=$cookie{adcentersource};
open (FICR,"+<$basepath/credits.sb");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	$credit{$tusr}=$tval;
}
($rat1,$rat2)=split(":",$clickratiosb);
if ($rat2){$clickratiosb=$rat1/$rat2;}else{$clickratiosb=0;}
if ($clickratiosb=~/\./){$clickratiosb=substr($clickratiosb,0,5);}
($imp,$clc)=split(" ",$credit{$bun});
$clc=$clc-1 if ($clc>1);
$credit{$bun}="$imp $clc";
($imp,$clc)=split(" ",$credit{$sun});
if ($enablecesb){$clc=$clc+$clickratiosb;}
else {$imp=$imp+$clickratiosb;}
$credit{$sun}="$imp $clc";
truncate(FICR,0);
seek(FICR,0,0);
foreach $key (keys %credit){print FICR "$key\t$credit{$key}\n";}
flock(FICR,$LOCK_UN);
close (FICR);
unless (-e "$basepath/$bun/clicks.sb")
{
	open (F,">$basepath/$bun/clicks.sb");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
}
open (STAT,"+<$basepath/$bun/clicks.sb");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	$stats{$tkey}=$tval;
}
@stats=split ("#",$stats{$ldate});
$stats[$hours]=$stats[$hours]+1;
$stats{$ldate}=join("#",@stats[0..23]);
truncate(STAT,0);
seek(STAT,0,0);
foreach $key (keys %stats){print STAT "$key\t$stats{$key}\n";}
flock(STAT,$LOCK_UN);
close (STAT);

#rEDiRECT
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dt=<F>;
flock(F,$LOCK_UN);
close (F);
foreach (@dt)
{
	($username,$url)=split("\t",$_);
	if ($username eq $cookie{adcenterurl}){$found=1;last;}
}
$url=$furl unless ($found);
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "set-cookie: adcngaccsb$cookie{adcentersource}=$howmany#$fromwhere; \n";
print "Location: $url\n\n";
