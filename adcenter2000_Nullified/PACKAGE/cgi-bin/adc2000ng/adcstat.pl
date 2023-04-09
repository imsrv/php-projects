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
if ($smtpserver){use Socket;$sockaddr = 'S n a4 x8';}
use ADCmhelp;
if ($enablemaillist){use ADCml;}
if ($enablecounter){use ADCcnt;}
if ($enabletex){use ADCtx;}
if ($enableswim){use ADCstr;}
######################################################################
# Main Section                                                       #
######################################################################
# Get data
if ($ENV{CONTENT_LENGTH}>0){if ($sysid eq "Windows"){read(STDIN,$data,$ENV{CONTENT_LENGTH});} else {$data=<STDIN>;}}
else {($data=$ENV{QUERY_STRING});}
@data=split("&",$data);
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		if ($field eq "target" || $field eq "remads")
		{
			if (defined $data{$field}){$data{$field}="$data{$field}#$value";}
			else {$data{$field}=$value;}
		}
		else
		{
			if ($data{$field}){$data{$field}="$data{$field},$value";}
			else {$data{$field}=$value;}
		}
	}
}
$data{lang}=$defaultlanguage unless ($data{lang});
$encline=crypt($data{name},$data{name}).":".crypt($data{password},$data{password});
$data{newmethod}="Preview" if ($data{'preview.x'});
$data{method}=$data{newmethod} if ($data{newmethod});
$destination=$data{method};
$selected{$destination}="selected";
$spott=$data{spot};
$selected{$spott}="selected";
$selected{genstats}="selected" if ($destination eq "m_resetrefer" || $destination eq "m_resetstats");
$selected{affiliate}="selected" if ($destination eq "clearestats");
$selected{genman}="selected" if ($destination eq "m_general" || $destination eq "m_transfer");
$selected{perman}="selected" if ($destination eq "m_personal");
$selected{banman}="selected" if ($destination eq "uplhtml" || $destination eq "upl2html");
$selected{tasman}="selected" if ($destination eq "m_target");
$selected{tabman}="selected" if ($destination eq "m_btarget");
$selected{tacman}="selected" if ($destination eq "m_ctarget");
$selected{adtman}="selected" if ($destination eq "m_settime");
$selected{faq}="selected" if ($destination eq "gtfaq");
$selected{support}="selected" if ($destination eq "sendsup");
$selected{sendml}="selected" if ($destination eq "manml" || $destination eq "addemail" || $destination eq "removeemail" || $destination eq "chmhead" || $destination eq "chmfoot" || $destination eq "edmtemp" || $destination eq "edptemp" || $destination eq "chperr" || $destination eq "chpsub" || $destination eq "chpunsub" || $destination eq "Preview" || $destination eq "htmlmail" || $destination eq "maillist" || $destination eq "viewemail" || $destination eq "cherrmes");
$selected{visitors}="selected" if ($destination eq "htmlcounter" || $destination eq "clearcounter" || $destination eq "dailycount" || $destination eq "dailyucount" || $destination eq "montlycount" || $destination eq "montlyucount" || $destination eq "hourlycount" || $destination eq "hourlyucount");
$selected{tx}="selected" if ($destination eq "htmltx" || $destination eq "cleartx" || $destination eq "dailytx" || $destination eq "montlytx" || $destination eq "hourlytx" || $destination eq "mantx" || $destination eq "remadtx" || $destination eq "addadtx" || $destination eq "customtx");
$selected{str}="selected" if ($destination eq "htmlstr" || $destination eq "clearstr" || $destination eq "dailystr" || $destination eq "montlystr" || $destination eq "hourlystr" || $destination eq "manstr" || $destination eq "upl2str");
open (F, "<$adcpath/langpack/$data{lang}.mtd");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

# Authorisation
if (-e "$basepath/$data{name}/dflag")
{
open (F, "<$basepath/category.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($id,$_)=split("\t",$_);
	($cat,$subcat)=split(":",$_);
	$cata[$id]=$cat;
	if ($cat ne $last){push(@categories,$cat);$last=$cat;}
}
open (F, "<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($umn,$uurl,$cat)=split("\t",$_);
	$hits{$cata[$cat]}+=1;
}
$i=0;
while($i<@categories)
{
	$result.="<tr>";
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/\&/\%26/g;
	$categories[$i]=~s/ /\+/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>";
	$i++;
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>" if ($i<@categories);
	$i++;
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>" if ($i<@categories);
	$result.="</tr>\n";
	$i++;
}
$error="Your account is temporary disabled<br>";
open (F,"<$adcpath/template/$data{lang}/index.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
open (F, "<$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
@pass=<F>;
flock(F,$LOCK_UN);
close (F);
shift(@pass);
foreach (@pass)
{
	chop;
	&$destination(%data) if ($_ eq $encline);
}
open (F, "<$basepath/category.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($id,$_)=split("\t",$_);
	($cat,$subcat)=split(":",$_);
	$cata[$id]=$cat;
	if ($cat ne $last){push(@categories,$cat);$last=$cat;}
}
open (F, "<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($umn,$uurl,$cat)=split("\t",$_);
	$hits{$cata[$cat]}+=1;
}
$i=0;
while($i<@categories)
{
	$result.="<tr>";
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/\&/\%26/g;
	$categories[$i]=~s/ /\+/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>";
	$i++;
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>" if ($i<@categories);
	$i++;
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>" if ($i<@categories);
	$result.="</tr>\n";
	$i++;
}
$error="Wrong username or password<br>";
open (F,"<$adcpath/template/$data{lang}/index.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;

######################################################################
#sUBR0TiNES sECTi0N                                                  #
######################################################################
sub m_resetstats
{
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
open (F,">$basepath/$data{name}/reset$data{spot}");
flock(F,$LOCK_EX);
print F "$month $date $year";
flock(F,$LOCK_UN);
close(F);
$selected{genstats}="selected";
&genstats;
}
sub m_resetrefer
{
open (F,">$basepath/$data{name}/referal");
flock(F,$LOCK_EX);
print F "0";
flock(F,$LOCK_UN);
close(F);
$selected{genstats}="selected";
&genstats;
}
sub affiliate
{
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if (-e "$basepath/$data{name}/adate")
{
open (F, "<$basepath/$data{name}/adate");
flock(F,$LOCK_EX);
$adate=<F>;
flock(F,$LOCK_UN);
close (F);
}
else
{
open (F, "<$basepath/$data{name}/join");
flock(F,$LOCK_EX);
$adate=<F>;
flock(F,$LOCK_UN);
close (F);
}
open (F, "<$basepath/$data{name}/affiliate");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
@dta=sort(@dta);
$i=0;
while($i<@dta)
{
	chop($dta[$i]);
	($username,$url,$imp,$clc)=split("\t",$dta[$i]);
	$url="---------" if (!$url);
	push (@res,qq~<tr><td width="60%" bgcolor="#82C7DB" valign="top"><font size=1><b>$url</b></font></td><td width="20%" align="right" bgcolor="#82C7DB"><font size=2>$imp</font></td><td width="20%" align="right" bgcolor="#82C7DB"><font size=2>$clc</font></td></tr>\n~);
	$i++;
	if ($i<@dta)
	{
		chop($dta[$i]);
		($username,$url,$imp,$clc)=split("\t",$dta[$i]);
		$url="---------" if (!$url);
		push (@res,qq~<tr><td width="60%" valign="top"><font size=1><b>$url</b></font></td><td width="20%" align="right"><font size=2>$imp</font></td><td width="20%" align="right"><font size=2>$clc</font></td></tr>\n~);
		$i++;
	}
}
push (@res,qq~<tr><td width="60%" background="$adcenter/images/$data{lang}/globalbk.gif" valign="top" colspan=3><font size=1 color=white>$rep[0]</font></td></tr>\n~) if (!@res);
open (F,"<$adcpath/template/$data{lang}/mextstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub clearestats
{
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unlink("$basepath/$data{name}/affiliate");
open (F,">$basepath/$data{name}/adate");
flock(F,$LOCK_EX);
print F $ldate;
flock(F,$LOCK_UN);
close(F);
$selected{affiliate}="selected";
&affiliate;
}
sub genstats
{
$data{method}="genstats";
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($username,$url,$usrgroup,$country,$uratio,$referuser,$weight)=split("\t",$_);
	last if ($username eq $data{name})
}
$weight=0 if (!$weight);
$refusers=0;
foreach(@dta)
{
	($u1,$u2,$u3,$u4,$u5,$u6,$u7)=split("\t",$_);
	$refusers++ if ($u6 eq $data{name})
}
if (-e "$basepath/$data{name}/advert"){$usersts="Advertiser";}
else {$usersts="Free";}
if (-e "$basepath/$data{name}/nonexpired"){$usersts.=", Non-expirable";}
else {$usersts.=", Expirable";}
if (-e "$basepath/$data{name}/tflag"){$usersts.=", Trusted";}
else {$usersts.=", Regular";}
if (-e "$basepath/$data{name}/autoaccept"){$usersts.=", Auto-accept";}
open (F,"<$basepath/$data{name}/banner$data{spot}");
flock(F,$LOCK_EX);
@bannerdate=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/$data{name}/referal");
flock(F,$LOCK_EX);
$refcredit=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/$data{name}/reset$data{spot}");
flock(F,$LOCK_EX);
@resetdate=<F>;
flock(F,$LOCK_UN);
close(F);
($b1,$b2,$b3)=split(" ",$bannerdate[0]);
($r1,$r2,$r3)=split(" ",$resetdate[0]);
$b1=$cal{$b1};
$r1=$cal{$r1};
$i=0;
while($i<$totalbanner)
{
	open (STAT,"<$basepath/$data{name}/impressions$i");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach(@temp){$globimp+=$_;}
	}
	flock(STAT,$LOCK_UN);
	close (STAT);
	open (STAT,"<$basepath/$data{name}/clicks$i");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach(@temp){$globclc+=$_;}
	}
	flock(STAT,$LOCK_UN);
	close (STAT);
	$i++;
}
open (STAT,"<$basepath/$data{name}/impressions$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	($n1,$n2,$n3,$n4)=split(" ",$tkey);
	$n2=$cal{$n2};
	@temp=split("#",$tval);
	foreach(@temp){$genimp+=$_;$banimp+=$_ if ($b3<$n4 || ($b1<$n2 && $b3==$n4) || ($b1==$n2 && $b2<=$n3 && $b3==$n4));$resimp+=$_ if ($r3<$n4 || ($r1<$n2 && $r3==$n4) || ($r1<=$n2 && $r2<=$n3 && $r3<=$n4))}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (STAT,"<$basepath/$data{name}/clicks$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	($n1,$n2,$n3,$n4)=split(" ",$tkey);
	$n2=$cal{$n2};
	@temp=split("#",$tval);
	foreach(@temp){$genclc+=$_;$banclc+=$_ if ($b3<$n4 || ($b1<$n2 && $b3==$n4) || ($b1==$n2 && $b2<=$n3 && $b3==$n4));$resclc+=$_ if ($r3<$n4 || ($r1<$n2 && $r3==$n4) || ($r1<=$n2 && $r2<=$n3 && $r3<=$n4))}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (F,"<$basepath/credits.db");
flock(F,$LOCK_EX);
@credits=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@credits)
{
	chop;
	($user,$other)=split("\t",$_);
	if ($user eq $data{name}){($impres,$cli)=split(" ",$other);last;}
}
$affilx=-s "$basepath/$data{name}/affilx";
$affilc=-s "$basepath/$data{name}/affilc";
open (F,"<$basepath/$data{name}/lastimp");
flock(F,$LOCK_EX);
@lastimp=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/$data{name}/lastclc");
flock(F,$LOCK_EX);
@lastclc=<F>;
flock(F,$LOCK_UN);
close(F);
chop($lastimp[0]);
chop($lastimp[1]);
chop($lastclc[0]);
chop($lastclc[1]);
open (F,"<$basepath/$data{name}/join");
flock(F,$LOCK_EX);
@joindate=<F>;
flock(F,$LOCK_UN);
close(F);
$genimp=0 if ($genimp eq "");
$genclc=0 if ($genclc eq "");
$globimp=0 if ($globimp eq "");
$globclc=0 if ($globclc eq "");
$banimp=0 if ($banimp eq "");
$banclc=0 if ($banclc eq "");
$resimp=0 if ($resimp eq "");
$resclc=0 if ($resclc eq "");
$affilx=0 if ($affilx eq "");
$affilc=0 if ($affilc eq "");
$refcredit=0 if ($refcredit eq "");
$lastclc[1]="N/A" if ($lastclc[1] eq "");
$lastimp[1]="N/A" if ($lastimp[1] eq "");
if ($genimp!=0){$genrat=$genclc/$genimp*100;}
else {$genrat=0;}
if ($globimp!=0){$globrat=$globclc/$globimp*100;}
else {$globrat=0;}
if ($banimp!=0){$banrat=$banclc/$banimp*100;}
else {$banrat=0;}
if ($resimp!=0){$resrat=$resclc/$resimp*100;}
else {$resrat=0;}
$genrat=substr($genrat,0,5) if (length($genrat)>5);
$globrat=substr($globrat,0,5) if (length($globrat)>5);
$banrat=substr($banrat,0,5) if (length($banrat)>5);
$resrat=substr($resrat,0,5) if (length($resrat)>5);
open (F,"<$adcpath/template/$data{lang}/mgenstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub hourstats
{
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$dtmn,$dtdt,$time,$dtyr)=split(" ",scalar gmtime(time+$gmtzone*3600));
unless ($data{date})
{
($day,$data{month},$data{date},$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$data{date}=~s/\D+//g;
$data{date}=1 if ($data{date} eq "" || $data{date}<0 || $data{date}>31);
$data{year}=~s/\D+//g;
$data{year}=$dtyr if ($data{year} eq "" || $data{year}<0);
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
$mns=$data{month};
$selected{$mns}="selected";
open (STAT,"<$basepath/$data{name}/impressions$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{date} / && $tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	@dimp=split("#",$tval);
	foreach(@dimp){$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (STAT,"<$basepath/$data{name}/clicks$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{date} / && $tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	@dclc=split("#",$tval);
	foreach(@dclc){$totclc+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
$i=0;
while($i<24)
{
	$dimp[$i]=0 if (!$dimp[$i]);
	$dclc[$i]=0 if (!$dclc[$i]);
	$i++;
}
$totimp=0 if (!$totimp);
$totclc=0 if (!$totclc);
@mdimp=@dimp;
@mdimp=sort ({$b<=>$a} @mdimp);
$maximp=shift(@mdimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=0;
foreach(@dimp)
{
	$height=int($_/$grat);
	$result1.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<23){$result1.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
@mdclc=@dclc;
@mdclc=sort ({$b<=>$a} @mdclc);
$maxclc=shift(@mdclc);
if ($maxclc<=10){$itm1=10;$itm2=7.5;$itm3=5;$itm4=2.5;}
elsif ($maxclc<=100){$itm1=100;$itm2=75;$itm3=50;$itm4=25;}
elsif ($maxclc<=1000){$itm1=1000;$itm2=750;$itm3=500;$itm4=250;}
elsif ($maxclc<=10000){$itm1=10000;$itm2=7500;$itm3=5000;$itm4=2500;}
elsif ($maxclc<=100000){$itm1=100000;$itm2=75000;$itm3=50000;$itm4=25000;}
elsif ($maxclc<=1000000){$itm1=1000000;$itm2=750000;$itm3=500000;$itm4=250000;}
$grat=$itm1/100;
$i=0;
foreach(@dclc)
{
	$height=int($_/$grat);
	$result2.=qq~<img src="$adcenter/images/$data{lang}/sg2.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<23){$result2.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mhrsstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub daystats
{
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{month})
{
($day,$data{month},$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
($day,$dtmn,$dtdt,$time,$dtyr)=split(" ",scalar gmtime(time+$gmtzone*3600));
$data{year}=~s/\D+//g;
$data{year}=$dtyr if ($data{year} eq "" || $data{year}<0);
$mns=$data{month};
$selected{$mns}="selected";
open (STAT,"<$basepath/$data{name}/impressions$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@dimp=split("#",$tval);
	foreach(@dimp){$totimp+=$_;$mimp[$fas]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (STAT,"<$basepath/$data{name}/clicks$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@dimp=split("#",$tval);
	foreach(@dimp){$totclc+=$_;$mclc[$fas]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
$month=$data{month};
$year=$data{year};
$calendar{$month}=29 if ($year/4-int($year/4)==0 && $month eq "Feb");
$tablewidth=12*$calendar{$month}-2;
$table=$tablewidth+60;
$i=1;
while($i<$calendar{$month}+1)
{
	$mclc[$i]=0 if ($mclc[$i] eq "");
	$mimp[$i]=0 if ($mimp[$i] eq "");
	push(@mstats,"<tr><td bgcolor=\"#82C7DB\"><font size=2><b>$i</b></font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2>$mimp[$i]</font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2>$mclc[$i]</font></td></tr>\n");
	$i++;
	if ($i<$calendar{$month}+1)
	{
		$mclc[$i]=0 if ($mclc[$i] eq "");
		$mimp[$i]=0 if ($mimp[$i] eq "");
		push(@mstats,"<tr><td><font size=2><b>$i</b></font></td><td align=\"right\"><font size=2>$mimp[$i]</font></td><td align=\"right\"><font size=2>$mclc[$i]</font></td></tr>\n");
		$i++;
	}
}
$totclc=0 if (!$totclc);
$totimp=0 if (!$totimp);
@mmimp=@mimp;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=1;
while($i<$calendar{$month}+1)
{
	$height=int($mimp[$i]/$grat);
	$result1.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<$calendar{$month}){$result1.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
@mmclc=@mclc;
@mmclc=sort ({$b<=>$a} @mmclc);
$maxclc=shift(@mmclc);
if ($maxclc<=10){$itm1=10;$itm2=7.5;$itm3=5;$itm4=2.5;}
elsif ($maxclc<=100){$itm1=100;$itm2=75;$itm3=50;$itm4=25;}
elsif ($maxclc<=1000){$itm1=1000;$itm2=750;$itm3=500;$itm4=250;}
elsif ($maxclc<=10000){$itm1=10000;$itm2=7500;$itm3=5000;$itm4=2500;}
elsif ($maxclc<=100000){$itm1=100000;$itm2=75000;$itm3=50000;$itm4=25000;}
elsif ($maxclc<=1000000){$itm1=1000000;$itm2=750000;$itm3=500000;$itm4=250000;}
$grat=$itm1/100;
$i=1;
while($i<$calendar{$month}+1)
{
	$height=int($mclc[$i]/$grat);
	$result2.=qq~<img src="$adcenter/images/$data{lang}/sg2.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<$calendar{$month}){$result2.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mdaystat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub monstats
{
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{year})
{
($day,$month,$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
($day,$dtmn,$dtdt,$time,$dtyr)=split(" ",scalar gmtime(time+$gmtzone*3600));
$data{year}=~s/\D+//g;
$data{year}=$dtyr if ($data{year} eq "" || $data{year}<0);
open (STAT,"<$basepath/$data{name}/impressions$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	$temp=$cal{$fae};
	@dimp=split("#",$tval);
	foreach(@dimp){$totimp+=$_;$mimp[$temp]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (STAT,"<$basepath/$data{name}/clicks$data{spot}");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	$temp=$cal{$fae};
	@dimp=split("#",$tval);
	foreach(@dimp){$totclc+=$_;$mclc[$temp]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
$tablewidth=12*12-2;
$table=$tablewidth+60;
foreach(@cal)
{
	$temp=$cal{$_};
	$mimp[$temp]=0 if ($mimp[$temp] eq "");
	$mclc[$temp]=0 if ($mclc[$temp] eq "");
}
$totimp=0 if (!$totimp);
$totclc=0 if (!$totclc);
@mmimp=@mimp;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=1;
while($i<13)
{
	$height=int($mimp[$i]/$grat);
	$result1.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<12){$result1.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
@mmclc=@mclc;
@mmclc=sort ({$b<=>$a} @mmclc);
$maxclc=shift(@mmclc);
if ($maxclc<=10){$itm1=10;$itm2=7.5;$itm3=5;$itm4=2.5;}
elsif ($maxclc<=100){$itm1=100;$itm2=75;$itm3=50;$itm4=25;}
elsif ($maxclc<=1000){$itm1=1000;$itm2=750;$itm3=500;$itm4=250;}
elsif ($maxclc<=10000){$itm1=10000;$itm2=7500;$itm3=5000;$itm4=2500;}
elsif ($maxclc<=100000){$itm1=100000;$itm2=75000;$itm3=50000;$itm4=25000;}
elsif ($maxclc<=1000000){$itm1=1000000;$itm2=750000;$itm3=500000;$itm4=250000;}
$grat=$itm1/100;
$i=1;
while($i<13)
{
	$height=int($mclc[$i]/$grat);
	$result2.=qq~<img src="$adcenter/images/$data{lang}/sg2.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<12){$result2.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mmonstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub htmlcode
{
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spc");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
open (F,"<$adcpath/template/$data{lang}/mhcostat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub genman
{
$result2="checked" if (-e "$basepath/$data{name}/showrmb");
$selected{genman}="selected";
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
open (F,"<$basepath/credits.db");
flock(F,$LOCK_EX);
@creds=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@creds)
{
	chop;
	($user,$other)=split("\t",$_);
	if ($user eq $data{name})
	{
		($creds)=split(" ",$other);
		last;
	}
}
$statusline.=" $rep[3]: $creds";
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@sinfo=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@sinfo)
{
	($username,$url,$usrgroup,$sitetitle,$description,$keyword)=split("\t",$_);
	last if ($username eq $data{name})
}
chop($keyword);
foreach(@categ)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($id==$usrgroup)
	{
		$result.="<option selected value=\"$id\">$idn</option>\n";
	}
	else {$result.="<option value=\"$id\">$idn</option>\n";}
}
open (F,"<$adcpath/template/$data{lang}/mgsestat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub perman
{
open (F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/global.db");
flock(F,$LOCK_EX);
@sinfo=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@sinfo)
{
	($username,$name,$street,$city,$zip,$country,$phone,$uemail,$uflg)=split("\t",$_);
	last if ($username eq $data{name})
}
chop($uflg);
foreach(@categ)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($id==$country)
	{
		$result.="<option selected value=\"$id\">$idn</option>\n";
	}
	else {$result.="<option value=\"$id\">$idn</option>\n";}
}
if ($uflg)
{
	$result2="<input type=checkbox name=uflg value=1 checked>";
}
else
{
	$result2="<input type=checkbox name=uflg value=1>";
}
open (F,"<$adcpath/template/$data{lang}/mpsestat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub banman
{
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spb");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
$spot=$data{spot};
if (-e "$adcpath/banners$data{spot}/$data{name}.gif")
{
	$result="<br><img src=\"$adcenter/banners$data{spot}/$data{name}.gif\" width=$banwidth[$spot] height=$banheight[$spot]>";
}
elsif (-e "$adcpath/banners$data{spot}/$data{name}.jpg")
{
	$result="<br><img src=\"$adcenter/banners$data{spot}/$data{name}.jpg\" width=$banwidth[$spot] height=$banheight[$spot]>";
}
elsif (-e "$adcpath/banners$data{spot}/$data{name}.swf")
{
	open (F, "<$adcpath/banners$data{spot}/$data{name}.ext");
	$code=<F>;
	close (F);
	$spot=$data{spot};
	$result=qq~<br><table width=$banwidth[$spot] height=$banheight[$spot]><tr><td>$code</td></tr></table>~;
}
elsif (-d "$adcpath/banners$data{spot}/$data{name}")
{
	open (F, "<$adcpath/banners$data{spot}/$data{name}.ext");
	$code=<F>;
	close (F);
	$spot=$data{spot};
	$result=qq~<br><table width=$banwidth[$spot] height=$banheight[$spot]><tr><td>$code</td></tr></table>~;
}
elsif (-e "$adcpath/banners$data{spot}/$data{name}.ext")
{
	open (F, "<$adcpath/banners$data{spot}/$data{name}.ext");
	$code=<F>;
	close (F);
	$spot=$data{spot};
	$result=qq~<br><table width=$banwidth[$spot] height=$banheight[$spot]><tr><td>$code</td></tr></table>~;
}
else{$result=" NONE";}
open (F,"<$adcpath/template/$data{lang}/mbmastat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub tasman
{
open(F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
open(F,"<$basepath/target.db");
flock(F,$LOCK_EX);
@target=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@target)
{
	chop;
	($user,$other)=split("\t",$_);
	if ($user eq $data{name}){$target{$user}=$other;last;}
}
$targetof=$data{name};
($target[0])=split("#BETWEENTRG#",$target{$targetof});
foreach(@categ)
{
	chop;
	($id,$_)=split("\t",$_);
	$cata{$_}=$id;
	/([^:]+):(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		if ($categ{$field}){$categ{$field}="$categ{$field}##$value";}
		else {$categ{$field}=$value;}
	}
}
foreach $key (sort keys %categ)
{
	$result.="<tr><td colspan=4 bgcolor=\"#82C7DB\"><font size=2><b>$key</b></font></td></tr>";
	@temp=split("##",$categ{$key});
	$i=0;
	while($i<scalar(@temp))
	{
		$verytemp="$key:$temp[$i]";
		if ($target[0]=~/\b$cata{$verytemp}\b/)
		{
			$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\" checked></td><td width=\"40%\"><font size=2>$temp[$i]</font></td>";
		}
		else {$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\"></td><td width=\"40%\"><font size=2>$temp[$i]</font></td>";}
		$i++;
		if ($temp[$i] ne "")
		{
		$verytemp="$key:$temp[$i]";
		if ($target[0]=~/\b$cata{$verytemp}\b/)
		{
			$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\" checked></td><td width=\"40%\"><font size=2>$temp[$i]</font></td></tr>\n";
		}
		else {$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\"></td><td width=\"40%\"><font size=2>$temp[$i]</font></td></tr>\n";}
		}
		else {$result.="<td></td><td></td></tr>\n";}
		$i++;
	}
}
open (F,"<$adcpath/template/$data{lang}/mtsmstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub tabman
{
open(F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
@categ=sort(@categ);
open(F,"<$basepath/$data{name}/target");
flock(F,$LOCK_EX);
@target=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@categ)
{
	chop;
	($id,$_)=split("\t",$_);
	$cata{$_}=$id;
	/([^:]+):(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		if ($categ{$field}){$categ{$field}="$categ{$field}##$value";}
		else {$categ{$field}=$value;}
	}
}
foreach $key (sort keys %categ)
{
	$result.="<tr><td colspan=4 bgcolor=\"#82C7DB\"><font size=2><b>$key</b></font></td></tr>";
	@temp=split("##",$categ{$key});
	$i=0;
	while($i<scalar(@temp))
	{
		$verytemp="$key:$temp[$i]";
		if ($target[2]=~/\b$cata{$verytemp}\b/)
		{
			$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\" checked></td><td width=\"40%\"><font size=2>$temp[$i]</font></td>";
		}
		else {$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\"></td><td width=\"40%\"><font size=2>$temp[$i]</font></td>";}
		$i++;
		if ($temp[$i] ne "")
		{
		$verytemp="$key:$temp[$i]";
		if ($target[2]=~/\b$cata{$verytemp}\b/)
		{
			$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\" checked></td><td width=\"40%\"><font size=2>$temp[$i]</font></td></tr>\n";
		}
		else {$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\"></td><td width=\"40%\"><font size=2>$temp[$i]</font></td></tr>\n";}
		}
		else {$result.="<td></td><td></td></tr>\n";}
		$i++;
	}
}
open (F,"<$adcpath/template/$data{lang}/mtbmstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub adtman
{
$data{method}="adtman";
$data{spot}=0 if (!$data{spot});
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
open (F,"<$basepath/$data{name}/timeman$data{spot}");
flock(F,$LOCK_EX);
@temp=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@temp)
{
	chop;
	($first,$second)=split("\t",$_);
	push(@res,$second);
}
open (F,"<$adcpath/template/$data{lang}/matmstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub tacman
{
open(F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@categ){chop;}
open(F,"<$basepath/target.db");
flock(F,$LOCK_EX);
@target=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@target)
{
	chop;
	($user,$other)=split("\t",$_);
	if ($user eq $data{name}){$target{$user}=$other;last;}
}
$targetof=$data{name};
($target[0],$target[1])=split("#BETWEENTRG#",$target{$targetof});
$i=0;
while ($i<@categ)
{
	($id,$categ[$i])=split("\t",$categ[$i]);
	if ($target[1]=~/\b$id\b/)
	{
		$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$id\" checked></td><td width=\"40%\"><font size=2>$categ[$i]</font></td>";
	}
	else {$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$id\"></td><td width=\"40%\"><font size=2>$categ[$i]</font></td>";}
	$i++;
	if ($i<@categ)
	{
	($id,$categ[$i])=split("\t",$categ[$i]);
	if ($target[1]=~/\b$id\b/)
	{
		$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$id\" checked></td><td width=\"40%\"><font size=2>$categ[$i]</font></td></tr>";
	}
	else {$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$id\"></td><td width=\"40%\"><font size=2>$categ[$i]</font></td></tr>";}
        }
	else {$result.="<td width=\"10%\"></td><td width=\"40%\"><font size=2></font></td></tr>";}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mtcmstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub m_general
{
$data{keywords}=~s/\,/ /g;
$data{keywords}=~s/ +/\,/g;
open(F,"+<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@db=<F>;
foreach (@db)
{
	chop;
	($username,$url,$usrgroup,$country,$ratio,$referuser,$userweight)=split("\t",$_);
	$_="$username\t$data{url}\t$data{category}\t$country\t$ratio\t$referuser\t$userweight" if ($username eq $data{name});
	$_.="\n";
}
truncate (F,0);
seek (F,0,0);
print F @db;
flock(F,$LOCK_UN);
close(F);
open(F,"+<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@db=<F>;
foreach (@db)
{
	($username,$url,$usrgroup,$sitetitle,$description,$keyword)=split("\t",$_);
	$_="$username\t$data{url}\t$data{category}\t$data{sitetitle}\t$data{description}\t$data{keywords}\n" if ($username eq $data{name});
}
truncate (F,0);
seek (F,0,0);
print F @db;
flock(F,$LOCK_UN);
close(F);
if ($data{show})
{
	open(F,">$basepath/$data{name}/showrmb");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close(F);
}
else
{
	unlink("$basepath/$data{name}/showrmb");
}
&genman;
}
sub m_transfer
{
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
unless (-e "$basepath/$data{name}/tflag")
{
	$statusline="$rep[25].";
	&genman;
}
unless (-e "$basepath/$data{touser}/target")
{
	$statusline="$rep[2].";
	&genman;
}
if ($data{credits}<0)
{
	$statusline="$rep[24].";
	&genman;
}
open(F,"+<$basepath/credits.db");
flock(F,$LOCK_EX);
@creds=<F>;
foreach(@creds)
{
	chop;
	($user,$other)=split("\t",$_);
	$creds{$user}=$other;
}
$fromuser=$data{name};
($impc,$xc)=split(" ",$creds{$fromuser});
if ($data{credits}>$impc)
{
	$data{credits}=$impc;
	$impc=0;
}
else {$impc=$impc-$data{credits};}
$creds{$fromuser}="$impc $xc";
$touser=$data{touser};
($impc,$xc)=split(" ",$creds{$touser});
$impc+=$data{credits};
$creds{$touser}="$impc $xc";
truncate(F,0);
seek(F,0,0);
foreach $key (keys %creds){print F "$key\t$creds{$key}\n";}
flock(F,$LOCK_UN);
close(F);
$statusline="$data{credits} $rep[4] $data{touser}.";
&genman;
}
sub m_personal
{
$data{uflg}=0 if (!$data{uflg});
$data{uemail}=$data{pemail} unless ($data{uemail}=~/^[\w\-.]+\@{1}[\w\-.]+$/ && $data{uemail}=~/^\w+/ && $data{uemail}=~/\w+$/);
open(F,"+<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@db=<F>;
foreach (@db)
{
	chop;
	($username,$url,$usrgroup,$country,$ratio,$referuser,$userweight)=split("\t",$_);
	$_="$username\t$url\t$usrgroup\t$data{country}\t$ratio\t$referuser\t$userweight" if ($username eq $data{name});
	$_.="\n";
}
truncate (F,0);
seek (F,0,0);
print F @db;
flock(F,$LOCK_UN);
close(F);
open(F,"+<$basepath/global.db");
flock(F,$LOCK_EX);
@db=<F>;
foreach (@db)
{
	chop;
	($username,$name,$street,$city,$zip,$country,$phone,$uemail,$uflg)=split("\t",$_);
	$_="$username\t$data{realname}\t$data{street}\t$data{city}\t$data{zip}\t$data{country}\t$data{phone}\t$data{uemail}\t$data{uflg}" if ($username eq $data{name});
	$_.="\n";
}
truncate (F,0);
seek (F,0,0);
print F @db;
flock(F,$LOCK_UN);
close(F);
if ($data{pemail} ne $data{uemail})
{
open(F,"+<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@db=<F>;
foreach (@db)
{
	chop;
	($uemail,$logn,$pasw)=split("\t",$_);
	$_="$data{uemail}\t$logn\t$pasw" if ($logn eq $data{name});
	$_.="\n";
}
truncate (F,0);
seek (F,0,0);
print F @db;
flock(F,$LOCK_UN);
close(F);
open(F,"+<$basepath/maillist.db");
flock(F,$LOCK_EX);
@db=<F>;
foreach (@db)
{
	chop;
	$_=$data{uemail} if ($_ eq $data{pemail});
	$_.="\n";
}
truncate (F,0);
seek (F,0,0);
print F @db;
flock(F,$LOCK_UN);
close(F);
}
&perman;
}
sub m_target
{
open(F,"+<$basepath/target.db");
flock(F,$LOCK_EX);
@target=<F>;
foreach(@target)
{
	($user,$other)=split("\t",$_);
	if ($user eq $data{name})
	{
		($first,$second)=split("#BETWEENTRG#",$other);
		$_="$user\t$data{target}#BETWEENTRG#$second";
		last;
	}
}
truncate(F,0);
seek(F,0,0);
print F @target;
flock(F,$LOCK_UN);
close(F);
&tasman;
}	
sub m_ctarget
{
open(F,"+<$basepath/target.db");
flock(F,$LOCK_EX);
@target=<F>;
foreach(@target)
{
	($user,$other)=split("\t",$_);
	if ($user eq $data{name})
	{
		($first,$second)=split("#BETWEENTRG#",$other);
		$_="$user\t$first#BETWEENTRG#$data{target}\n";
		last;
	}
}
truncate(F,0);
seek(F,0,0);
print F @target;
flock(F,$LOCK_UN);
close(F);
&tacman;
}	
sub m_btarget
{
open(F,"+<$basepath/$data{name}/target");
flock(F,$LOCK_EX);
@target=<F>;
truncate(F,0);
seek(F,0,0);
print F "$target[0]$target[1]$data{target}\n";
flock(F,$LOCK_UN);
close(F);
&tabman;
}	
sub m_settime
{
$i=0;
while($i<24)
{
	$temp="res$i";
	$data{$temp}=~s/\D+//g;
	$data{$temp}=0 if ($data{$temp} eq "");
	$i++;
}
open(F,">$basepath/$data{name}/timeman$data{spot}");
flock(F,$LOCK_EX);
print F "0\t$data{res0}\n0\t$data{res1}\n0\t$data{res2}\n0\t$data{res3}\n0\t$data{res4}\n0\t$data{res5}\n0\t$data{res6}\n0\t$data{res7}\n0\t$data{res8}\n0\t$data{res9}\n0\t$data{res10}\n0\t$data{res11}\n0\t$data{res12}\n0\t$data{res13}\n0\t$data{res14}\n0\t$data{res15}\n0\t$data{res16}\n0\t$data{res17}\n0\t$data{res18}\n0\t$data{res19}\n0\t$data{res20}\n0\t$data{res21}\n0\t$data{res22}\n0\t$data{res23}\n";
flock(F,$LOCK_UN);
close(F);
&adtman;
}
sub faq
{
open(F,"<$adcpath/faq/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
while ($i<@categ)
{
	chop($categ[$i]);
	($id,$categ)=split("\t",$categ[$i]);
	$result.="<tr><td width=\"100%\"><a href=\"$cgi/adcstat.pl?name=$data{name}&password=$data{password}&lang=$data{lang}&method=gtfaq&id=$id\"><font size=2>$categ</font></a></td></tr>";
	$i++;
	if ($i<@categ)
	{
		chop($categ[$i]);
		($id,$categ)=split("\t",$categ[$i]);
		$result.="<tr><td width=\"100%\" bgcolor=\"#82C7DB\"><a href=\"$cgi/adcstat.pl?name=$data{name}&password=$data{password}&lang=$data{lang}&method=gtfaq&id=$id\"><font size=2>$categ</font></a></td></tr>";
		$i++;
        }
}
open (F,"<$adcpath/template/$data{lang}/mfaqstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub gtfaq
{
open(F,"<$adcpath/faq/$data{id}.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
foreach (@categ)
{
	chop;
	($quest,$answer)=split("\t",$_);
	$result.="<tr><td width=\"100%\"><font size=2><b>$quest</b></font></td></tr>\n<tr><td width=\"100%\" bgcolor=\"#82C7DB\"><font size=2>$answer</font></td></tr>";
}
open (F,"<$adcpath/template/$data{lang}/mfaqgstt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub support
{
open (F,"<$adcpath/template/$data{lang}/msupstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub sendsup
{
$data{message}=~s/\r\n/\<br\>/g;
open(F,">>$adcpath/faq/query.db");
flock(F,$LOCK_EX);
print F "$data{name}\t$data{message}\n";
flock(F,$LOCK_UN);
close(F);
if ($smtpserver)
{
	&sendviasmtp("$email ($owntitle)",$email,"New question in FAQ section","User $data{name} left a question for you in FAQ section. Check it out, please.\n\n");
}
else
{
open (MAIL,"|$progmail");
print MAIL "To: $email\n";
print MAIL "From: $email ($owntitle)\n";
print MAIL "Subject: New question in FAQ section\n\n";
print MAIL "User $data{name} left a question for you in FAQ section. Check it out, please.\n\n";
print MAIL "\n.\n";
close (MAIL);
}
open (F,"<$adcpath/template/$data{lang}/msupsstt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub uplhtml
{
$data{method}="banman";
&banman unless ($data{file});
$data{file}=~s/\r\n//g;
$data{file}=~s/\'/\\\'/g;
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if (-e "$basepath/$data{name}/autoaccept")
{
unlink ("$adcpath/banners$data{spot}/$data{name}.gif");
unlink ("$adcpath/banners$data{spot}/$data{name}.jpg");
unlink ("$adcpath/banners$data{spot}/$data{name}.swf");
unlink ("$adcpath/banners$data{spot}/$data{name}.class");
open(F,">$adcpath/banners$data{spot}/$data{name}.ext");
flock(F,$LOCK_EX);
print F $data{file};
flock(F,$LOCK_UN);
close(F);
open (F,"<$adcpath/template/$data{lang}/muphstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
unlink ("$adcpath/queye/$data{spot}/$data{name}.gif");
unlink ("$adcpath/queye/$data{spot}/$data{name}.jpg");
unlink ("$adcpath/queye/$data{spot}/$data{name}.swf");
unlink ("$adcpath/queye/$data{spot}/$data{name}.class");
open(F,">$adcpath/queye/$data{spot}/$data{name}.ext");
flock(F,$LOCK_EX);
print F $data{file};
flock(F,$LOCK_UN);
close(F);
if ($smtpserver)
{
	&sendviasmtp("$email ($owntitle)",$email,"Banner Pending Approval","Received from: $owntitle\n\nUsername: $data{name}\nBannerpool: $data{spot}\n\n");
}
else
{
open (MAIL,"|$progmail");
print MAIL "To: $email\n";
print MAIL "From: $email ($owntitle)\n";
print MAIL "Subject: Banner Pending Approval\n\n";
print MAIL "Received from: $owntitle\n\nUsername: $data{name}\nBannerpool: $data{spot}\n\n";
print MAIL "\n.\n";
close (MAIL);
}
open (F,"<$adcpath/template/$data{lang}/muphstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub upl2html
{
$data{method}="banman";
$data{file}=~s/\r\n//g;
$data{file}=~s/\'//g;
open (F, "<$adcpath/langpack/$data{lang}.spt");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if ($data{ext} eq "swf"){$testline="$adcenter/banners$data{spot}/$data{name}.$data{ext}";}
else {$testline="$adcenter/banners$data{spot}/$data{name}\" CODE=\"$data{filenm}.$data{ext}";}
unless ($data{file}=~/$testline/)
{
	open (F,"<$adcpath/template/$data{lang}/meupstat.tpl");
	@htmlpage=<F>;
	close (F);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
}
if (-e "$basepath/$data{name}/autoaccept")
{
open(F,">$adcpath/banners$data{spot}/$data{name}.ext");
flock(F,$LOCK_EX);
print F $data{file};
flock(F,$LOCK_UN);
close(F);
open (F,"<$adcpath/template/$data{lang}/muphstat2.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
open(F,">$adcpath/queye/$data{spot}/$data{name}.ext");
flock(F,$LOCK_EX);
print F $data{file};
flock(F,$LOCK_UN);
close(F);
if ($smtpserver)
{
	&sendviasmtp("$email ($owntitle)",$email,"Banner Pending Approval","Received from: $owntitle\n\nUsername: $data{name}\nBannerpool: $data{spot}\n\n");
}
else
{
open (MAIL,"|$progmail");
print MAIL "To: $email\n";
print MAIL "From: $email ($owntitle)\n";
print MAIL "Subject: Banner Pending Approval\n\n";
print MAIL "Received from: $owntitle\n\nUsername: $data{name}\nBannerpool: $data{spot}\n\n";
print MAIL "\n.\n";
close (MAIL);
}
open (F,"<$adcpath/template/$data{lang}/muphstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub sendviasmtp
{
($from,$to,$subject,$message)=@_;
$message=~s/\n/\r\n/g;
$localhost=(gethostbyname('localhost'))[0] || 'localhost';
socket(S,PF_INET,SOCK_STREAM,(getprotobyname('tcp'))[2]) || return;
$farg=sockaddr_in($smtpport,inet_aton($smtpserver)) || return;
connect(S,$farg) || return;
$res=<S>;
if ($res=~/^[45]/){close(S);return;}
$mes="HELO $localhost\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){close(S);return;}
$mes="mail from: <$email>\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){close(S);return;}
$mes="rcpt to: <$to>\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){close(S);return;}
$mes="data\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
$mes="From:$from\r\nTo:$to\r\nSubject:$subject\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$mes="\r\n$message\r\n.\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){close(S);return;}
$mes="quit\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
close(S);
}
sub backindex
{
print "HTTP/1.0 302 Found\n" if ($sysid eq "Windows");
print "Location: $cgi/adcindex.pl?lang=$data{lang}\n\n";
exit;
}