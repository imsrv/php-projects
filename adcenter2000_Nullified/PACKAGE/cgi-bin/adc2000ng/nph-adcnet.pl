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
$bxalt=~s/\'/\\\'/g;
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
$getcode=$ENV{QUERY_STRING};
$getcode=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
($user,$spot,$random)=split("&",$getcode);
if (!$user || $spot eq undef || !$random)
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
if ($cookie{$random}>0 && $logcookieduplicates)
{
	open(F,">>$basepath/$user/ca.log");
	flock(F,$LOCK_EX);
	$acdate=scalar gmtime(time+$gmtzone*3600);
	print F "$acdate\tUsed same random number from one person\t$ENV{REMOTE_ADDR}\n";
	flock(F,$LOCK_UN);
	close(F);
}
$templine="adcngac$user$spot";
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
if (-s "$basepath/blitz.db")
{
	open(F,"+<$basepath/blitz.db");
	flock(F,$LOCK_EX);
	@blitz=<F>;
	truncate (F,0);
	seek (F,0,0);
	srand;
	$item=$blitz[int(rand scalar(@blitz))];
	chop($item);
	($uname,$ucred)=split("\t",$item);
	if ($uname ne $user && (-e "$adcpath/banners$spot/$uname.ext" || -e "$adcpath/banners$spot/$uname.gif" || -e "$adcpath/banners$spot/$uname.jpg"))
	{
	$ucred--;
	foreach(@blitz)
	{
		($uuname,$uucred)=split("\t",$_);
		if ($uuname eq $uname)
		{
			next if ($ucred==0);
			$_="$uname\t$ucred\n";
		}
		push(@nblitz,$_);
	}
	print F @nblitz;
	$username=$uname;
	$flag=1;
	$blitzdone=1;
	}
	else {print F @blitz;}
	flock(F,$LOCK_UN);
	close(F);
}
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
open (FICR,"+<$basepath/credits.db");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	$credit{$tusr}=$tval;
}
if (!$blitzdone)
{
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
		if ($targa[2]=~/\b$usrgroup\b/ && ($targs[0]=~/\b$tgroup\b/ || !$tgroup) && ($imp>1 || $clc>1 || -e "$basepath/$username/nonexpired") && ($targs[1]=~/\b$tcountry\b/ || $targs[1]=~/\b$ntld\b/ || !$tcountry) && (-e "$adcpath/banners$spot/$username.gif" || -e "$adcpath/banners$spot/$username.jpg" || (-e "$adcpath/banners$spot/$username.ext" && -e "$basepath/$user/showrmb")) && !(-e "$basepath/$username/dflag"))
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
	while ($i<@data)
	{
		srand;
		$item=int(rand (@data));
		$username=$data[$item];
		open (FL,"+<$basepath/$username/timeman$spot");
		flock(FL,$LOCK_EX);
		@work=<FL>;
		($onwork,$offwork)=split("\t",$work[$hours]);
		if ($onwork<$offwork)
		{
			$onwork=$onwork+1;
			$work[$hours]="$onwork\t$offwork";
			($onwork,$offwork)=split("\t",$work[$hourr]);
			$work[$hourr]="0\t$offwork";
			truncate (FL,0);
			seek (FL,0,0);
			print FL @work;
			flock(FL,$LOCK_UN);
			close(FL);
			$flag=1;
			last;
		}
		flock(FL,$LOCK_UN);
		close(FL);
		splice(@data,$item,1);
	}
}
$username=$yourname if (!$flag);
($rat1,$rat2)=split(":",$userratio);
if ($rat2){$userratio=$rat1/$rat2;}else{$userratio=0;}
if ($userratio=~/\./){$userratio=substr($userratio,0,5);}
($imp,$clc)=split(" ",$credit{$user});
$imp=$imp+$userratio;
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
if ($refus)
{
	open (F,"+<$basepath/$refus/referal");
	flock(F,$LOCK_EX);
	$credit=<F>;
	$credit=$credit+$refratio;
	truncate (F,0);
	seek (F,0,0);
	print F $credit;
	flock(F,$LOCK_UN);
	close(F);
}

#p0ST sTATiSTiCS
unless (-e "$basepath/$username/impressions$spot")
{
	open (F,">$basepath/$username/impressions$spot");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
}
open (STAT,"+<$basepath/$username/impressions$spot");
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
if (-e "$basepath/$username/affiliate")
{
open (F,"+<$basepath/$username/affiliate");
flock(F,$LOCK_EX);
@lines=<F>;
foreach (@lines)
{
	($arg1,$arg2,$arg3,$arg4)=split("\t",$_);
	if ($arg1 eq $user)
	{
		$arg3++;
		$_="$arg1\t$arg2\t$arg3\t$arg4";
		$foundflag=1;
		last;
	}
}
push (@lines,"$user\t$usersurl\t1\t0\n") if (!$foundflag);
truncate(F,0);
seek(F,0,0);
print F @lines;
flock(F,$LOCK_UN);
close (F);
}
else
{
open (F,">$basepath/$username/affiliate");
flock(F,$LOCK_EX);
print F "$user\t$usersurl\t1\t0\n";
flock(F,$LOCK_UN);
close (F);
}
open (F,">>$basepath/$user/affilx");
flock(F,$LOCK_EX);
print F "A";
flock(F,$LOCK_UN);
close (F);

#pRiNT liNK
if (-e "$adcpath/banners$spot/$username.gif")
{
	print "HTTP/1.0 200 OK\n";
	print "set-cookie: adcngac$user$spot=$howmany#$fromwhere; \n";
	print "set-cookie: $random=1; \n";
	print "content-type: text/html\n\n";
	$minibannerc=qq~<br><a href="$cgi/adcclick.pl?$user" target="_top"><img src="$adcenter/images/network$spot.gif" border=0 width=$banwidth[$spot] height=$mbanheight></a>~ if ($enablemb[$spot]);
	print qq~document.write(\'<p><a href="$cgi/adcrdst.pl?$username&$spot&$user" target="_top"><img src="$adcenter/banners$spot/$username.gif" border=0 width=$banwidth[$spot] height=$banheight[$spot] alt="$bxalt"></a>$minibannerc</p>\')~;
}
elsif (-e "$adcpath/banners$spot/$username.jpg")
{
	print "HTTP/1.0 200 OK\n";
	print "set-cookie: adcngac$user$spot=$howmany#$fromwhere; \n";
	print "set-cookie: $random=1; \n";
	print "content-type: text/html\n\n";
	$minibannerc=qq~<br><a href="$cgi/adcclick.pl?$user" target="_top"><img src="$adcenter/images/network$spot.gif" border=0 width=$banwidth[$spot] height=$mbanheight></a>~ if ($enablemb[$spot]);
	print qq~document.write(\'<p><a href="$cgi/adcrdst.pl?$username&$spot&$user" target="_top"><img src="$adcenter/banners$spot/$username.jpg" border=0 width=$banwidth[$spot] height=$banheight[$spot] alt="$bxalt"></a>$minibannerc</p>\')~;
}
elsif (-e "$adcpath/banners$spot/$username.ext")
{
	open(F,"$adcpath/banners$spot/$username.ext");
	$comline=<F>;
	close(F);
	print "HTTP/1.0 200 OK\n";
	print "set-cookie: adcngac$user$spot=$howmany#$fromwhere; \n";
	print "set-cookie: $random=1; \n";
	print "set-cookie: adc2000ng$username$spot=$user; \n";
	print "content-type: text/html\n\n";
	$minibannerc=qq~<script language="Javascript" type="text/javascript" src="$cgi/nph-adcgetmb.pl?$user&$spot"></script>~ if ($enablemb[$spot]);
	print qq~document.write(\'<table border=0 cellpadding=0 cellspacing=0><tr><td>$comline</td></tr><tr><td>$minibannerc</td></tr></table>\')~;
}
