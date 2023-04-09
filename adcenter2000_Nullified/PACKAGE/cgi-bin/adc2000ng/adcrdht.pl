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
		$cookie{$field}=$value;
	}
}
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$date,$month,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
($hours)=split(":",$time);
if ($ENV{CONTENT_LENGTH}>0){$data=<STDIN>;}
else {($data=$ENV{QUERY_STRING});}
@data=split("&",$data);
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$data{$field}=$value;
	}
}
$bun=$data{bun};
$spot=$data{spot};
$url=$data{url};
$url=~s/\+/ /g;
$url=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
delete $data{url};
delete $data{spot};
delete $data{bun};
if (!$bun || $spot eq undef)
{
	print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
	print "Location: $adcenter/errclick.html\n\n";
	exit;
}
if (!$sun){$templine="adc2000ng$bun$spot";$sun=$cookie{$templine};}
if (!$ENV{HTTP_REFERER} && $logrefererfault && $sun)
{
	open(F,">>$basepath/$sun/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tCant resolve referer address\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
if (!$ENV{HTTP_USER_AGENT} && $logagentfault && $sun)
{
	open(F,">>$basepath/$sun/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tCant resolve user agent\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
$templine="adcngacc$sun$spot";
if ($cookie{$templine} && $sun)
{
	($howmany,$fromwhere)=split("#",$cookie{$templine});
	$howmany++;
	$fromwhere.=",$ENV{REMOTE_ADDR}" unless ($fromwhere=~/$ENV{REMOTE_ADDR}/);
	@fromwhere=split(",",$fromwhere);
	$totalfrom=scalar (@fromwhere);
	if ($howmany>$logallowclcperbrowser || $totalfrom>$logallowipperbrowser)
	{
	open(F,">>$basepath/$sun/ca.log");
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
open (FICR,"+<$basepath/credits.db");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	$credit{$tusr}=$tval;
}
($rat1,$rat2)=split(":",$clickratio);
if ($rat2){$clickratio=$rat1/$rat2;}else{$clickratio=0;}
if ($clickratio=~/\./){$clickratio=substr($clickratio,0,5);}
if ($bun)
{
($imp,$clc)=split(" ",$credit{$bun});
$clc=$clc-1 if ($clc>1);
$credit{$bun}="$imp $clc";
}
if ($sun)
{
($imp,$clc)=split(" ",$credit{$sun});
if ($enablece){$clc=$clc+$clickratio;}
else {$imp=$imp+$clickratio;}
$credit{$sun}="$imp $clc";
}
truncate(FICR,0);
seek(FICR,0,0);
foreach $key (keys %credit){print FICR "$key\t$credit{$key}\n";}
flock(FICR,$LOCK_UN);
close (FICR);

if ($bun)
{
unless (-e "$basepath/$bun/clicks$spot")
{
	open (F,">$basepath/$bun/clicks$spot");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
}
open (STAT,"+<$basepath/$bun/clicks$spot");
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
open (F,"+<$basepath/$bun/affiliate");
flock(F,$LOCK_EX);
@lines=<F>;
foreach (@lines)
{
	($arg1,$arg2,$arg3,$arg4)=split("\t",$_);
	if ($arg1 eq $sun)
	{
		chop($arg4);
		$arg4++;
		$_="$arg1\t$arg2\t$arg3\t$arg4\n";
		$foundflag=1;
		last;
	}
}
truncate(F,0);
seek(F,0,0);
print F @lines;
flock(F,$LOCK_UN);
close (F);
}
if ($sun)
{
open (F,">>$basepath/$sun/affilc");
flock(F,$LOCK_EX);
print F "A";
flock(F,$LOCK_UN);
close (F);
}

#rEDiRECT
foreach $key (keys %data){push(@qline,"$key=$data{$key}");}
$qline=join("&",@qline);
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "set-cookie: adcngacc$sun$spot=$howmany#$fromwhere; \n";
print "Location: $url?$qline\n\n";
