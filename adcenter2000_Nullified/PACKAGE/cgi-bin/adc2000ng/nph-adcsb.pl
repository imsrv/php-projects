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

($user)=split("&",$ENV{QUERY_STRING});
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
$templine="adcngacsb$user";
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
open (FICR,"+<$basepath/credits.sb");
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
	($imp,$clc)=split(" ",$credit{$username});
	@targs=split("#BETWEENTRG#",$targets{$username});
	if ($targa[2]=~/\b$usrgroup\b/ && ($targs[0]=~/\b$tgroup\b/ || !$tgroup) && ($imp>1 || $clc>1 || -e "$basepath/$username/nonexpired") && ($targs[1]=~/\b$tcountry\b/ || $targs[1]=~/\b$ntld\b/ || !$tcountry) && (-e "$adcpath/sb/$username.ext") && !(-e "$basepath/$username/dflag"))
	{
	$j=0;
	while ($j<$weight)
	{
		push(@data,$username);
		$j++;
	}
	}
}
flock(F,$LOCK_UN);
close (F);
$i=0;
srand;
$item=int(rand (@data));
$username=$data[$item];
$username=$yourname unless (@data);
($rat1,$rat2)=split(":",$defaultratiosb);
if ($rat2){$defaultratiosb=$rat1/$rat2;}else{$defaultratiosb=0;}
if ($defaultratiosb=~/\./){$defaultratiosb=substr($defaultratiosb,0,5);}
($imp,$clc)=split(" ",$credit{$user});
$imp=$imp+$defaultratiosb;
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
unless (-e "$basepath/$username/impressions.sb")
{
	open (F,">$basepath/$username/impressions.sb");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
}
open (STAT,"+<$basepath/$username/impressions.sb");
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
if (-e "$adcpath/sb/$username.gif"){$ext="gif";}
else {$ext="jpg";}
open (TEXT,"<$adcpath/sb/$username.ext");
$textad=<TEXT>;
close (TEXT);
print "HTTP/1.0 200 OK\n";
print "set-cookie: adcngacsb$user=$howmany#$fromwhere; \n";
print "set-cookie: ngsb$user=1; \n";
print "content-type: text/html\n\n";
print qq~
var advRes = $sbwidth;
var advImage = '$adcenter/sb/$username.$ext';
var setText = '$textad';
var advTextAlign = 'left';
var allowedWidth = 300;
var advUrl = '$cgi/adcrdsb.pl?$username&$user';
var advAlt = '$owntitle';
var setTextHeader = '<DIV STYLE="font-family: MS Sans Serif; font-size: 10px; color: 000000; background-color: ffffff">';
var advText = setTextHeader+setText+'</font></DIV>';
var SWMLogo = '$adcenter/images/adc_logo.gif';
var SwimLogo = '$adcenter/images/swim_logo.gif';
var maxButton = '$adcenter/images/banner_up.gif';
var minButton = '$adcenter/images/banner_down.gif';
var clsButton = '$adcenter/images/banner_close.gif';
var OnebyOne = '$adcenter/images/1x1.gif';
var OnebyTwo = '$adcenter/images/1x1_2.gif';
var underFon = '$adcenter/images/under_fon.gif';
var details = '$adcenter/images/details.gif';
var BXURL = '$furl';
var textClose = '$adcenter/images/text_close.gif';~;
print q~
var ourBanner1 =
'<table border=0 cellspacing=0 cellpadding=0 bgcolor=#7EBAD4 width='+(advRes+8)+'>'+
'<tr><td colspan=3 height=1 bgcolor=#7EBAD4>';
var ourBanner2 = '<table border=0 cellspacing=0 cellpadding=0 bgcolor=#7EBAD4 width='+(advRes+8)+'>'+
'<tr><td align=left width=80><a href="'+BXURL+'" onMouseOver="window.status=\''+advAlt+'\';return true" onMouseOut="window.status=\'\';return true"><img src="'+SWMLogo+'" width=22 height=14 alt="'+advAlt+'" border=0></a><img src="'+OnebyTwo+'" width=1 height=14><a href="'+BXURL+'" onMouseOver="window.status=\'SwimBanner\';return true" onMouseOut="window.status=\'\';return true"><img src="'+SwimLogo+'" width=49 height=14 alt="SwimBanner" border=0></a><br></td>'+
'<td align=right>';
buttonUp = '<a href="javascript:setStatus(0)" onMouseOver="window.status=\'Minimize\';return true" onMouseOut="window.status=\'\';return true"><img src="'+minButton+'" width=10 height=14 alt="Minmize" border=0></a><img src="+OnebyOne+" width=2 height=14><a href="javascript:setStatus(-1)" onMouseOver="window.status=\'Close\';return true" onMouseOut="window.status=\'\';return true"><img src="'+clsButton+'" width=10 height=14 alt="Close" border=0></a><img src="+OnebyOne+" width=2 height=14><br></td></tr>'+
'</table></td></tr>';
buttonDown = '<a href="javascript:setStatus(1)" onMouseOver="window.status=\'Maximize\';return true" onMouseOut="window.status=\'\';return true"><img src="'+maxButton+'" width=10 height=14 alt="Maximize" border=0></a><img src="+OnebyOne+" width=2 height=14><a href="javascript:setStatus(-1)" onMouseOver="window.status=\'Close\';return true" onMouseOut="window.status=\'\';return true"><img src="'+clsButton+'" width=10 height=14 alt="Close" border=0></a><img src="+OnebyOne+" width=2 height=14><br></td></tr>'+
'</table></td></tr>';
var ourBanner3 = '<tr><td colspan=3 height=1 bgcolor=#7EBAD4><img src="+OnebyOne+" width=1 height=1><br></td></tr>'+
'<tr><td colspan=3 height=1><img src="+OnebyOne+" width=1 height=1><br></td></tr>'+
'<tr><td width=1><img src="+OnebyOne+" width=1 height=1><br></td>'+
'<td><table border=0 cellspacing=0 cellpadding=0 bgcolor=white>'+
'<tr><td colspan=3 background="'+underFon+'" height=3><img src="'+underFon+'" width=1 height=3><br></td></tr>'+
'<tr><td colspan=3 width=1><img src="+OnebyOne+" width=1 height=1><br></td></tr>'+
'<tr><td width=1><img src="+OnebyOne+" width=3 height=1><br></td>'+
'<td><a href="'+advUrl+'" target=_top><img src="'+advImage+'" width='+advRes+' height='+advRes+' border=0 alt="'+advAlt+'"></A><br></td>'+
'<td width=1><img src="+OnebyOne+" width=3 height=1><br></td></tr>'+
'<tr><td colspan=3 width=1><img src="'+OnebyOne+'" width=1 height=3><br></td></tr>'+
'<tr><td width=1 height=12><img src="'+OnebyOne+'" width=3 height=1><br></td>'+
'<td bgcolor=#7EBAD4 height=12 align=center><a href="javascript:setStatus(2)" onMouseOver="window.status=\'Click here for details\';return true" onMouseOut="window.status=\'\';return true"><img src="'+details+'" width=62 height=10 alt="Click for details" border=0></a><br></td>'+
'<td width=1 height=12><img src="'+OnebyOne+'" width=3 height=1><br></td></tr>'+
'<tr><td colspan=3 width=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr></table></td>'+
'<td width=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'<tr><td colspan=3 height=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'</table>';
var ourBanner4 =
'<tr><td colspan=3 height=1 bgcolor=#7EBAD4><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'<tr><td colspan=3 height=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'<tr><td width=1><img src="'+OnebyOne+'" width=1 height=1><br></td>'+
'<td><table border=0 cellspacing=0 cellpadding=0 bgcolor=white>'+
'<tr><td colspan=3 background="'+underFon+'" height=3><img src="'+underFon+'" width=1 height=3><br></td></tr>'+
'<tr><td colspan=3 width=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'<tr><td width=1><img src="'+OnebyOne+'" width=3 height=1><br></td>'+
'<td><a href="'+advUrl+'" target=_top><img src="'+advImage+'" width='+advRes+' height='+advRes+' border=0 alt="'+advAlt+'"></A><br><img src="'+OnebyOne+'" width=1 height=3><br>'+advText+'<br><img src="'+OnebyOne+'" width=1 height=3></td>'+
'<td width=1><img src="'+OnebyOne+'" width=3 height=1><br></td></tr>'+
'<tr><td colspan=3 width=1><img src="'+OnebyOne+'" width=1 height=3><br></td></tr>'+
'<tr><td width=1 height=12><img src="'+OnebyOne+'" width=3 height=1><br></td>'+
'<td bgcolor=#7EBAD4 height=12 align=center><a href="javascript:setStatus(1)" onMouseOver="window.status=\'Close details\';return true" onMouseOut="window.status=\'\';return true"><img src="'+textClose+'" width=48 height=10 alt="Close details" border=0></a><br></td>'+
'<td width=1 height=12><img src="'+OnebyOne+'" width=3 height=1><br></td></tr>'+
'<tr><td colspan=3 width=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr></table></td>'+
'<td width=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'<tr><td colspan=3 height=1><img src="'+OnebyOne+'" width=1 height=1><br></td></tr>'+
'</table>';

var wWidth=advRes+9;
var timeOut = 90000;
var timeOut1 = 90000;
var allowStayOnTop = true;
var confirm = allowStayOnTop;
var touched = false;
var H="hidden";
var V="visible";

function setPositionNN(){
document.SWM.pageX = window.innerWidth-wWidth-16;
document.SWM2.pageX = window.innerWidth-wWidth-16;
document.MORE.pageX = window.innerWidth-wWidth-16;
}

function drawItemsNN(){

document.writeln(
'<layer name=SWM pageX='+(window.innerWidth-wWidth-16)+' pageY=0 visibility=hidden z-index:100>'+
ourBanner2+buttonDown+
'</layer>');
document.writeln(
'<layer name=SWM2 pageX='+(window.innerWidth-wWidth-16)+' pageY=0 visibility=visible z-index:100>'+
ourBanner1+ourBanner2+buttonUp+ourBanner3+
'</layer>');
document.writeln(
'<layer name=MORE pageX='+(window.innerWidth-wWidth-16)+' pageY=0 visibility=hidden z-index:100>'+
ourBanner1+ourBanner2+buttonUp+ourBanner4+
'</layer>');
}

function startSWMNN(){
	if ((window.innerWidth-10)<allowedWidth) return false;
	drawItemsNN();
	if (allowStayOnTop) stayOnTopNN()
		else setTimeout("setStatus(-1);", timeOut);
	setPositionNN();
	window.onresize=setPositionNN;
return true;
}

function stayOnTopNN() {
	if (!touched) timer2 = setTimeout("closeItNN()", timeOut1);
	if (!allowStayOnTop) return false;
	document.SWM.pageY = window.pageYOffset;
	document.SWM2.pageY = window.pageYOffset;
	document.MORE.pageY = window.pageYOffset;
	timer = setTimeout("stayOnTopNN()", 100);
return true;
}

function closeItNN() {
if (touched) return false;
document.SWM.visibility=H;
document.SWM2.visibility=H;
document.MORE.visibility=H;
return true;
}

if (document.layers) startSWMNN();

function setStatus(state){

if (document.layers) setPositionNN();
if (document.all) setPositionIE();

	if ((state==-1) && (document.layers)) {
	document.SWM.visibility=H;
	document.SWM2.visibility=H;
	document.MORE.visibility=H;
	}
	if ((state==0) && (document.layers)) {
	document.SWM.visibility=V;
	document.SWM2.visibility=H;
	document.MORE.visibility=H;
        touched = true;
	if (confirm) clearTimeout(timer);
        allowStayOnTop = false;
	stayOnTopNN();
	}
	if ((state==1) && (document.layers)) {
	document.SWM.visibility=V;
	document.SWM2.visibility=V;
	document.MORE.visibility=H;
        touched = true;
	if (confirm) {
		allowStayOnTop = true;
		stayOnTopNN();
		}
	}
	if ((state==2) && (document.layers)) {
	document.SWM.visibility=V;
	document.SWM2.visibility=H;
	document.MORE.visibility=V;
        touched = true;
	}
	if ((state==3) && (document.layers)) {
	document.SWM.visibility=V;
	document.SWM2.visibility=H;
	document.MORE.visibility=H;
        touched = true;
	}
	if ((state==-1) && (document.all)) {
	SWM.style.visibility=H;
	SWM2.style.visibility=H;
	MORE.style.visibility=H;
	}

	if ((state==0) && (document.all)) {
	SWM.style.visibility=V;
	SWM2.style.visibility=H;
	MORE.style.visibility=H;
        touched = true;
	if (confirm) clearTimeout(timer);
	allowStayOnTop = false;
	stayOnTopIE();
	}

	if ((state==1) && (document.all)) {
	SWM.style.visibility=V;
	SWM2.style.visibility=V;
	MORE.style.visibility=H;
        touched = true;
	if (confirm) {
		allowStayOnTop = true;
		stayOnTopIE();
		}
	}

	if ((state==2) && (document.all)) {
	SWM.style.visibility=V;
	SWM2.style.visibility=H;
	MORE.style.visibility=V;
        touched = true;
	}

	if ((state==3) && (document.all)) {
	SWM.style.visibility=V;
	SWM2.style.visibility=H;
	MORE.style.visibility=H;
        touched = true;
	}
}

if (document.all) startSWMIE();

function setPositionIE(){
SWM.style.left = document.body.clientWidth-wWidth-1;
SWM2.style.left = document.body.clientWidth-wWidth-1;
MORE.style.left = document.body.clientWidth-wWidth-1;
}

function drawItemsIE(){
document.writeln('<span style="position:absolute;left:'+(document.body.clientWidth-advRes)+';top:0;visibility=hidden" id=SWM>'+
ourBanner2+buttonDown+
'</span>');
document.writeln('<span style="position:absolute;left:'+(document.body.clientWidth-advRes)+';top:0;visibility=visible" id=SWM2>'+
ourBanner1+ourBanner2+buttonUp+ourBanner3+
'</span>');
document.writeln('<span style="position:absolute;left:'+(document.body.clientWidth-advRes)+';top:0;visibility=hidden" id=MORE>'+
ourBanner1+ourBanner2+buttonUp+ourBanner4+
'</span>');
}

function startSWMIE(){
	if ((document.body.clientWidth)<allowedWidth) return false;
	drawItemsIE();
	if (allowStayOnTop) stayOnTopIE()
		else setTimeout("setStatusIE(-1);", timeOut);
	setPositionIE();
	window.onresize=setPositionIE;
return true;
}

function stayOnTopIE() {
	if (!touched) timer2 = setTimeout("closeItIE()", timeOut1);
	if (!allowStayOnTop) return false;
	SWM.style.top = document.body.scrollTop;
	SWM2.style.top = document.body.scrollTop;
	MORE.style.top = document.body.scrollTop;
	timer = setTimeout("stayOnTopIE()", 100);
return true;
}

function closeItIE() {
if (touched) return false;
SWM.style.visibility=H;
SWM2.style.visibility=H;
MORE.style.visibility=H;
return true;
}
~;
