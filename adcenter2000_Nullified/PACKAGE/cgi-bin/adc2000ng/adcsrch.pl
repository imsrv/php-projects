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
$argum=$data{words};
$data{words}=~s/\+/ /g;
$data{words}=~s/%([0-9A-Fa-f]{2})/pack('C',hex($1))/eg;
if ($data{words}=~/\"/)
{
	$data{words}=~s/\"//g;
	push (@words,$data{words});
}
else
{
	@words=split(" ",$data{words});
}

#sEARCH
$start=$data{start};
@data=();
$destination=$data{type};
&$destination;

sub web
{
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@info=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@info)
{
	chop;
	($id,$idn)=split("\t",$_);
	$cata[$id]=$idn;
}
open (F,"<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@info=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@info)
{
	$flag=0;
	($username,$url,$group,$title,$description,$keywords)=split("\t",$_);
	foreach $word (@words)
	{
		$word=~s/^\+//;
		$word=~s/^\*//;
		$word=~s/^\?//;
		unless ($description=~/$word/i || $keywords=~/$word/i || $title=~/$word/i)
		{
			$flag=1;
		}
	}
	push (@data,"$title\t$url\t$description\t$group") if ($flag==0);
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>10)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcsrch.pl?lang=$data{lang}&type=$data{type}&words=$argum&start=$pstart\"><img src=\"$adcenter/images/$data{lang}/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=2><b>$rep[29] $icount $rep[30]</b></font></td>");
	if ($start*10+10<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcsrch.pl?lang=$data{lang}&type=$data{type}&words=$argum&start=$nstart\"><img src=\"$adcenter/images/$data{lang}/next.gif\" border=0></a></td>");
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
		push(@result,"<li><a href=\"$url\"><font size=\"2\"><b>$title - ($url)</b></font></a><br><font size=1>$description</font><br><font size=2><b>CATEGORY: $cata[$group]</b></li>\n");
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
		push(@result,"<li><a href=\"$url\"><font size=\"2\"><b>$title - ($url)</b></font></a><br><font size=1>$description</font><br><font size=2><b>CATEGORY: $cata[$group]</b></li>\n");
		$i++;
	}
}
push(@result,"<li><font size=1>$rep[7]</font></li>") if (!@result);
open (F,"<$adcpath/template/$data{lang}/mainsres.tpl");
@html=<F>;
close (F);
$html=join("",@html);
$html="print qq~$html~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $html;
}
sub people
{
open (F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@info=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@info)
{
	chop;
	($id,$idn)=split("\t",$_);
	$cata[$id]=$idn;
}
open (F,"<$basepath/global.db");
flock(F,$LOCK_EX);
@info=<F>;
flock(F,$LOCK_UN);
close(F);
$searchby=$data{searchby};
foreach(@info)
{
	$flag=0;
	chop;
	($username,$got{name},$got{address},$got{city},$got{zip},$got{country},$got{phone},$got{email},$show)=split("\t",$_);
	$cou=$got{country};
	if ($show)
	{
	foreach $word (@words)
	{
		$word=~s/^\+//;
		$word=~s/^\*//;
		$word=~s/^\?//;
		unless ($got{$searchby}=~/$word/i || ($searchby eq "country" && $cata[$cou]=~/$word/i))
		{
			$flag=1;
		}
	}
	push (@data,"$got{name}\t$got{address}\t$got{city}\t$got{zip}\t$got{country}\t$got{phone}\t$got{email}") if ($flag==0 && $show);
	}
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>10)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcsrch.pl?lang=$data{lang}&type=$data{type}&searchby=$data{searchby}&words=$argum&start=$pstart\"><img src=\"$adcenter/images/$data{lang}/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=2><b>$rep[29] $icount $rep[30]</b></font></td>");
	if ($start*10+10<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcsrch.pl?lang=$data{lang}&type=$data{type}&searchby=$data{searchby}&words=$argum&start=$nstart\"><img src=\"$adcenter/images/$data{lang}/next.gif\" border=0></a></td>");
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
		($name,$address,$city,$zip,$country,$phone,$email)=split("\t",$data[$i]);
		push(@result,"<li><a href=\"mailto:$email\"><font size=\"2\"><b>$name</b></font></a><br><font size=2>$address<br>$city, $zip<br>$cata[$country]<br>$phone</font></li>\n");
		$i++;
	}
}
else
{
	$i=$start*10;
	$last=$i+10;
	while($i<$last)
	{
		($name,$address,$city,$zip,$country,$phone,$email)=split("\t",$data[$i]);
		push(@result,"<li><a href=\"mailto:$email\"><font size=\"2\"><b>$name</b></font></a><br><font size=2>$address<br>$city, $zip<br>$cata[$country]<br>$phone</font></li>\n");
		$i++;
	}
}
push(@result,"<li><font size=1>$rep[7]</font></li>") if (!@result);
open (F,"<$adcpath/template/$data{lang}/mainsres.tpl");
@html=<F>;
close (F);
$html=join("",@html);
$html="print qq~$html~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $html;
}
