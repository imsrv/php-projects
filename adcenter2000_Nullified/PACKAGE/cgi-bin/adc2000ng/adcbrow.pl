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
if ($ENV{CONTENT_LENGTH}>0){if ($sysid eq "Windows"){read(STDIN,$data,$ENV{CONTENT_LENGTH});} else {$data=<STDIN>;}}
else {($data=$ENV{QUERY_STRING});}
@data=split("&",$data);
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		if ($data{$field}){$data{$field}.=",$value";}
		else {$data{$field}=$value;}
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
if ($data{subcat})
{
if (!$data{start}){$start=0;} else {$start=$data{start};}
$argum=$data{cat};
$argum2=$data{subcat};
$data{cat}=~s/\+/ /g;
$data{cat}=~s/%([0-9A-Fa-f]{2})/pack('C',hex($1))/eg;
$data{subcat}=~s/\+/ /g;
$data{subcat}=~s/%([0-9A-Fa-f]{2})/pack('C',hex($1))/eg;
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@info=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@info)
{
	chop;
	($id,$idn)=split("\t",$_);
	$cata{$idn}=$id;
}
$category="$data{cat}:$data{subcat}";
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@info=<F>;
flock(F,$LOCK_UN);
close(F);
@data=();
foreach(@info)
{
	chop;
	($username,$url,$group,$title,$description,$keywords)=split("\t",$_);
	push (@data,"$title\t$url\t$description") if ($group==$cata{$category});
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>10)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$argum&subcat=$argum2&start=$pstart\"><img src=\"$adcenter/images/$data{lang}/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=2><b>$rep[29] $icount $rep[30]</b></font></td>");
	if ($start*10+10<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$argum&subcat=$argum2&start=$nstart\"><img src=\"$adcenter/images/$data{lang}/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=2><b>$rep[29] $icount $rep[30]</b></font></td>");}
push (@footer,"</tr></table>");
if ($start*10+10>scalar(@data))
{
	$i=$start*10;
	while($i<scalar(@data))
	{
		($title,$url,$description,$group)=split("\t",$data[$i]);
		push(@result,"<li><a href=\"$url\"><font size=\"2\"><b>$title - ($url)</b></font></a><br><font size=1>$description</font></li>\n");
		$i++;
	}
}
else
{
	$i=$start*10;
	$last=$i+10;
	while($i<$last)
	{
		($title,$url,$description,$group)=split("\t",$data[$i]);
		push(@result,"<li><a href=\"$url\"><font size=\"2\"><b>$title - ($url)</b></font></a><br><font size=1>$description</font></li>\n");
		$i++;
	}
}
push(@result,"<li><font size=1>$rep[6]</font></li>") if (!@result);
open (F,"<$adcpath/template/$data{lang}/maininfo.tpl");
@html=<F>;
close (F);
$html=join("",@html);
$html="print qq~$html~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $html;
}
else
{
$argum=$data{cat};
$data{cat}=~s/\+/ /g;
$data{cat}=~s/%([0-9A-Fa-f]{2})/pack('C',hex($1))/eg;
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
	$cata[$id]=$subcat;
	if ($cat eq $data{cat}){push(@categories,$subcat);$allow.="#$id";}
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
	if ($allow=~/\b$cat\b/)
	{
	$hits{$cata[$cat]}+=1;
	}
}
$i=0;
$total=@categories;
while($i<$total)
{
	$result.="<tr>";
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/\&/\%26/g;
	$categories[$i]=~s/ /\+/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$argum&subcat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>";
	$i++;
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$argum&subcat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>" if ($i<$total);
	$i++;
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$argum&subcat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>" if ($i<$total);
	$result.="</tr>\n";
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mainbrow.tpl");
@html=<F>;
close (F);
$html=join("",@html);
$html="print qq~$html~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $html;
}
