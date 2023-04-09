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
($username,$variant)=split("&",$ENV{QUERY_STRING});
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
$temp="ngcount$username";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
($hours)=split(":",$time);
unless (-e "$basepath/$username/counter.cmn")
{
	open (F,">$basepath/$username/counter.cmn");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
}
open (STAT,"+<$basepath/$username/counter.cmn");
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
unless ($cookie{$temp})
{
	unless (-e "$basepath/$username/counter.unq")
	{
		open (F,">$basepath/$username/counter.unq");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close (F);
	}
	open (STAT,"+<$basepath/$username/counter.unq");
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

print "HTTP/1.0 200 OK\n";
print "set-cookie: ngcount$username=1; expires=Sunday, 31-Dec-$year 23:59:59 GMT \n";
print "content-type: text/html\n\n";
print qq~if (screen.width==640&&screen.height==480) {var resol="r640"}
else if (screen.width==800&&screen.height==600) {var resol="r800"}
else if (screen.width==1024&&screen.height==768) {var resol="r1024"}
else {var resol="rother"}
document.write('<table width=80 height=42 border=0 cellpadding=0 cellspacing=0 background="$adcenter/images/counter.gif"><tr><td align=center valign=center><a href="$furl" target="_top"><img border=0 width=64 height=10 alt="$counteralt" src="$cgi/adccount.pl?$username&$variant&'+resol+'&'+Math.random()+'"></a></td></tr></table>');~;
