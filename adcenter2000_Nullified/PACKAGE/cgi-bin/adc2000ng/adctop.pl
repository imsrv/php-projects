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
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
$data{top}=10 if (!$data{top});
$data{type}="banner" if (!$data{type});
open (F, "<$adcpath/langpack/$data{lang}.stp");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if ($data{type} eq "counter")
{
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@sites=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@sites)
{
	chop;
	$unique=0;
	$common=0;
	($unme,$usurl,$uscat,$ustit,$usdesc,$uskeyw)=split("\t",$_);
	if ($uscat==$data{category} || !$data{category})
	{
	open (STAT,"<$basepath/$unme/counter.cmn");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$common+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	open (STAT,"<$basepath/$unme/counter.unq");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$unique+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	push(@basic,"$common\t$unique\t$ustit\t$usurl\t$usdesc");
	}
}
@basic=sort({$b<=>$a}@basic);
$i=0;
if (@basic>0)
{
foreach(@basic)
{
	($uscomm,$usuniq,$ustit,$usurl,$usdesc)=split("\t",$_);
	$result.=qq~
<tr>
<td width="70%"><a href="$usurl" target="_blank"><font size="2"><b>$ustit</b></font></a></td><td width="15%" align=right><font size=2>$uscomm</font></td><td width="15%" align=right><font size=2>$usuniq</font></td></tr>
<tr>
<td colspan=3 bgcolor="#82c7db"><font size="1">$usdesc</font></td></tr>
~;
	$i++;
	last if ($i==$data{top});
}
}
else
{
	$result.=qq~
<tr>
<td colspan=3><p align="center"><font size="2"><b>$rep[23]</b></font></td></tr>
~;
}
$categories=qq~<option value="">All</option>\n~;
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/top.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
if ($data{type} eq "banner")
{
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@sites=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@sites)
{
	chop;
	$unique=0;
	$common=0;
	$i=0;
	($unme,$usurl,$uscat,$ustit,$usdesc,$uskeyw)=split("\t",$_);
	if ($uscat==$data{category} || !$data{category})
	{
	while ($i<$totalbanner)
	{
	open (STAT,"<$basepath/$unme/impressions$i");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$common+=$temp;}
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
		foreach $temp(@temp){$unique+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	$i++;
	}
	push(@basic,"$common\t$unique\t$ustit\t$usurl\t$usdesc");
	}
}
@basic=sort({$b<=>$a}@basic);
$i=0;
if (@basic>0)
{
foreach(@basic)
{
	($uscomm,$usuniq,$ustit,$usurl,$usdesc)=split("\t",$_);
	$result.=qq~
<tr>
<td width="70%"><a href="$usurl" target="_blank"><font size="2"><b>$ustit</b></font></a></td><td width="15%" align=right><font size=2>$uscomm</font></td><td width="15%" align=right><font size=2>$usuniq</font></td></tr>
<tr>
<td colspan=3 bgcolor="#82c7db"><font size="1">$usdesc</font></td></tr>
~;
	$i++;
	last if ($i==$data{top});
}
}
else
{
	$result.=qq~
<tr>
<td colspan=3><p align="center"><font size="2"><b>$rep[23]</b></font></td></tr>
~;
}
$categories=qq~<option value="">All</option>\n~;
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/top1.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
if ($data{type} eq "banners")
{
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@sites=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
while ($i<$totalbanner)
{
foreach(@sites)
{
	chop;
	$unique=0;
	$common=0;
	($unme,$usurl,$uscat,$ustit,$usdesc,$uskeyw)=split("\t",$_);
	if ($uscat==$data{category} || !$data{category})
	{
	open (STAT,"<$basepath/$unme/impressions$i");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$common+=$temp;}
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
		foreach $temp(@temp){$unique+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	push(@basic,"$common\t$unique\t$unme\t$usurl\t$i");
	}
}
$i++;
}
@basic=sort({$b<=>$a}@basic);
$i=0;
if (@basic>0)
{
foreach(@basic)
{
	($uscomm,$usuniq,$unme,$usurl,$spot)=split("\t",$_);
	if (-e "$adcpath/banners$spot/$unme.gif"){$bannerline=qq~<a href="$usurl" target="_blank"><img src="$adcenter/banners$spot/$unme.gif" border=0></a>~;}
	elsif (-e "$adcpath/banners$spot/$unme.jpg"){$bannerline=qq~<a href="$usurl" target="_blank"><img src="$adcenter/banners$spot/$unme.jpg" border=0></a>~;}
	elsif (-e "$adcpath/banners$spot/$unme.ext")
	{
		open(F,"$adcpath/banners$spot/$unme.ext");
		flock(F,$LOCK_EX);
		@bann=<F>;
		flock(F,$LOCK_UN);
		close(F);
		$bannerline=join("",@bann);
	}
	else {$bannerline="<font size=2>$rep[31]</font>";}
	$result.=qq~
<tr>
<td width="70%"><a href="$usurl" target="_blank"><font size="2"><b>$unme</b></font></a></td><td width="15%" align=right><font size=2>$uscomm</font></td><td width="15%" align=right><font size=2>$usuniq</font></td></tr>
<tr>
<td colspan=3 bgcolor="#82c7db" align=center>$bannerline</td></tr>
~;
	$i++;
	last if ($i==$data{top});
}
}
else
{
	$result.=qq~
<tr>
<td colspan=3><p align="center"><font size="2"><b>$rep[23]</b></font></td></tr>
~;
}
$categories=qq~<option value="">All</option>\n~;
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/top4.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
if ($data{type} eq "sbanner")
{
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@sites=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@sites)
{
	chop;
	$unique=0;
	$common=0;
	$i=0;
	($unme,$usurl,$uscat,$ustit,$usdesc,$uskeyw)=split("\t",$_);
	if ($uscat==$data{category} || !$data{category})
	{
	open (STAT,"<$basepath/$unme/impressions.sb");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$common+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	open (STAT,"<$basepath/$unme/clicks.sb");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$unique+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	push(@basic,"$common\t$unique\t$ustit\t$usurl\t$usdesc");
	}
}
@basic=sort({$b<=>$a}@basic);
$i=0;
if (@basic>0)
{
foreach(@basic)
{
	($uscomm,$usuniq,$ustit,$usurl,$usdesc)=split("\t",$_);
	$result.=qq~
<tr>
<td width="70%"><a href="$usurl" target="_blank"><font size="2"><b>$ustit</b></font></a></td><td width="15%" align=right><font size=2>$uscomm</font></td><td width="15%" align=right><font size=2>$usuniq</font></td></tr>
<tr>
<td colspan=3 bgcolor="#82c7db"><font size="1">$usdesc</font></td></tr>
~;
	$i++;
	last if ($i==$data{top});
}
}
else
{
	$result.=qq~
<tr>
<td colspan=3><p align="center"><font size="2"><b>$rep[23]</b></font></td></tr>
~;
}
$categories=qq~<option value="">All</option>\n~;
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/top2.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
if ($data{type} eq "tx")
{
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@sites=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@sites)
{
	chop;
	$unique=0;
	$common=0;
	$i=0;
	($unme,$usurl,$uscat,$ustit,$usdesc,$uskeyw)=split("\t",$_);
	if ($uscat==$data{category} || !$data{category})
	{
	open (STAT,"<$basepath/$unme/impressions.tx");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$common+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	open (STAT,"<$basepath/$unme/clicks.tx");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach $temp(@temp){$unique+=$temp;}
	}
	flock(STAT,$LOCK_UN);
	close(STAT);
	push(@basic,"$common\t$unique\t$ustit\t$usurl\t$usdesc");
	}
}
@basic=sort({$b<=>$a}@basic);
$i=0;
if (@basic>0)
{
foreach(@basic)
{
	($uscomm,$usuniq,$ustit,$usurl,$usdesc)=split("\t",$_);
	$result.=qq~
<tr>
<td width="70%"><a href="$usurl" target="_blank"><font size="2"><b>$ustit</b></font></a></td><td width="15%" align=right><font size=2>$uscomm</font></td><td width="15%" align=right><font size=2>$usuniq</font></td></tr>
<tr>
<td colspan=3 bgcolor="#82c7db"><font size="1">$usdesc</font></td></tr>
~;
	$i++;
	last if ($i==$data{top});
}
}
else
{
	$result.=qq~
<tr>
<td colspan=3><p align="center"><font size="2"><b>$rep[23]</b></font></td></tr>
~;
}
$categories=qq~<option value="">All</option>\n~;
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/top3.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
