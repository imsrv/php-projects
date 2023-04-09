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
@data=();
open (F,"<$basepath/domains.db");
flock(F,$LOCK_EX);
@domains=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@domains)
{
	chop;
	($dom,$dcou)=split("\t",$_);
	$domain{$dom}=$dcou;
}
@userhost=split(/\./,$ENV{REMOTE_HOST});
$ntld=pop(@userhost);
$domain{$ntld}="NOTHING" if (!$domain{$ntld});
$ntld=$domain{$ntld};
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
($hours)=split(":",$time);
if ($hours==0){$hourr=23;}
else {$hourr=$hours-1;}
$lmon=$cal{$month};
$ldte=$date;
$lmon="0".$lmon if (length($lmon)==1);
$ldte="0".$date if (length($date)==1);
$lastact="$year$lmon$ldte";
$time=~s/://g;

$user=$ENV{QUERY_STRING};
if (!$user)
{
	print "HTTP/1.0 200 OK\n";
	print "content-type: text/html\n\n";
	print qq~document.write(\'<table border=0 cellpadding=0 cellspacing=0><tr><td><font size=2><b>Wrong banner code</b></font></td></tr></table>\')~;
	exit;
}
if (!$ENV{HTTP_REFERER} && $logrefererfault)
{
	open(F,">>$basepath/$user/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tCant resolve referer address\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
if (!$ENV{HTTP_USER_AGENT} && $logagentfault)
{
	open(F,">>$basepath/$user/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tCant resolve user agent\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
$templine="adcngactx$user";
if ($cookie{$templine})
{
	($howmany,$fromwhere)=split("#",$cookie{$templine});
	$howmany++;
	$fromwhere.=",$ENV{REMOTE_ADDR}" unless ($fromwhere=~/$ENV{REMOTE_ADDR}/);
	@fromwhere=split(",",$fromwhere);
	$totalfrom=scalar (@fromwhere);
	if ($howmany>$logallowimpperbrowser || $totalfrom>$logallowipperbrowser)
	{
	open(F,">>$basepath/$user/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tLimit for impressions or IPs per browser is exceed (IMP:$howmany IPS: $totalfrom)\t$fromwhere\n";
	flock(F,$LOCK_UN);
	close(F);
	}
}
else
{
	$howmany=1;
	$fromwhere=$ENV{REMOTE_ADDR};
}


open (F,"<$basepath/$user/target");
flock(F,$LOCK_EX);
@targa=<F>;
flock(F,$LOCK_UN);
close(F);
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
open (F,">$basepath/$user/lastact");
flock(F,$LOCK_EX);
print F $lastact;
flock(F,$LOCK_UN);
close (F);
open (F,"<$basepath/target.db");
flock(F,$LOCK_EX);
@targets=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@targets)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	$targets{$tusr}=$tval;
}
open (FICR,"+<$basepath/credits.tx");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	$credit{$tusr}=$tval;
}
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
while($line=<F>)
{
	chop($line);
	($username,$url,$usrgroup,$country,$ratio,$referuser,$weight)=split("\t",$line);
	if ($username eq $user)
	{
		$tgroup=$usrgroup;
		$tcountry=$country;
		$userratio=$ratio;
		$refus=$referuser;
		$usersurl=$url;
		next;
	}
	$weight=1 if (!$weight || $weight==0);
	$j=0;
	($imp,$clc)=split(" ",$credit{$username});
	@targs=split("#BETWEENTRG#",$targets{$username});
	if ($targa[2]=~/\b$usrgroup\b/ && ($targs[0]=~/\b$tgroup\b/ || !$tgroup) && ($imp>1 || $clc>1 || -e "$basepath/$username/nonexpired") && ($targs[1]=~/\b$tcountry\b/ || $targs[1]=~/\b$ntld\b/ || !$tcountry) && (-s "$adcpath/tx/$username") && !(-e "$basepath/$username/dflag"))
	{
	while ($j<$weight)
	{
		push(@data,$username);
		$j++;
	}
	}
}
flock(F,$LOCK_UN);
close (F);
srand;
$item=int(rand (@data));
$username=$data[$item];
$username=$yourname unless (@data);
($rat1,$rat2)=split(":",$defaultratiotx);
if ($rat2){$defaultratiotx=$rat1/$rat2;}else{$defaultratiotx=0;}
if ($defaultratiotx=~/\./){$defaultratiotx=substr($defaultratiotx,0,5);}
($imp,$clc)=split(" ",$credit{$user});
$imp=$imp+$defaultratiotx;
$credit{$user}="$imp $clc";
($imp,$clc)=split(" ",$credit{$username});
$imp=$imp-1 if ($imp>1);
$credit{$username}="$imp $clc";
if ($refus)
{
($rat1,$rat2)=split(":",$refratio);
if ($rat2){$refratio=$rat1/$rat2;}else{$refratio=0;}
if ($refratio=~/\./){$refratio=substr($refratio,0,5);}
($imp,$clc)=split(" ",$credit{$refus});
$imp=$imp+$refratio;
$credit{$refus}="$imp $clc";
}
truncate(FICR,0);
seek(FICR,0,0);
foreach $key (keys %credit){print FICR "$key\t$credit{$key}\n";}
flock(FICR,$LOCK_UN);
close (FICR);

#p0ST sTATiSTiCS
unless (-e "$basepath/$username/impressions.tx")
{
	open (F,">$basepath/$username/impressions.tx");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
}
open (STAT,"+<$basepath/$username/impressions.tx");
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

#pRiNT liNK
open(F,"<$adcpath/tx/$username");
flock(F,$LOCK_EX);
@ads=<F>;
flock(F,$LOCK_UN);
close(F);
srand;
$id=int(rand scalar @ads);
$ad=$ads[$id];
chop($ad);
open (F,"<$basepath/$user/tx.dat");
flock(F,$LOCK_EX);
($bgcol,$fncol,$boxw,$speed)=split("\t",<F>);
flock(F,$LOCK_UN);
close(F);
srand;
$frst=int(rand 10000);
$scnd=int(rand 10000);
print "HTTP/1.0 200 OK\n";
print "set-cookie: adcngacsb$user=$howmany#$fromwhere; \n";
print "content-type: text/html\n\n";
print qq~
var marqueewidth$frst=$boxw
var marqueeheight$frst=20
var speed$frst=$speed
var marqueecontents$frst='<a href="$cgi/adcrdtx.pl?$username&$user" target="_top"><font color="$fncol" size=3>$ad</font></a>'
var bcolor$frst='#$bgcol'
var bfile$frst='$bgimg'
if (document.all)
document.write('<marquee scrollAmount='+speed$frst+' border=0 bgcolor='+bcolor$frst+' style="width:'+marqueewidth$frst+'">'+marqueecontents$frst+'</marquee>')

function regenerate$frst(){
window.location.reload()
}
function regenerate2$frst(){
if (document.layers){
//tx2=setTimeout("window.onresize=regenerate$frst",450)
intializemarquee$frst()
}
}

function intializemarquee$frst(){
document.cmarquee$frst.document.cmarquee$scnd.document.write('<nobr>'+marqueecontents$frst+'</nobr>')
document.cmarquee$frst.document.cmarquee$scnd.document.close()
thelength$frst=document.cmarquee$frst.document.cmarquee$scnd.document.width
scrollit$frst()
}

function scrollit$frst(){
if (document.cmarquee$frst.document.cmarquee$scnd.left>=thelength$frst*(-1)){
document.cmarquee$frst.document.cmarquee$scnd.left-=speed$frst
tx=setTimeout("scrollit$frst()",100)
}
else{
document.cmarquee$frst.document.cmarquee$scnd.left=marqueewidth$frst
scrollit$frst()
}
}
document.write('<ilayer width='+marqueewidth$frst+' height='+marqueeheight$frst+' name="cmarquee$frst" bgcolor='+bcolor$frst+'>')
document.write('<layer name="cmarquee$scnd"></layer>')
document.write('</ilayer>')
window.onload=regenerate2$frst
~;