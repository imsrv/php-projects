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
		if ($field eq "target" || $field eq "remad")
		{
			if ($data{$field}){$data{$field}="$data{$field}##$value";}
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
$data{lang}=$defaultlanguage unless (-d "$adcpath/template/$data{lang}");
$data{method}="initial" if (!$data{method});
$destination=$data{method};
&$destination;

sub initial
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
	if ($i<@categories)
	{
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td>";
	$i++;
	}
	else
	{
	$result.="<td></td>";
	}
	if ($i<@categories)
	{
	$temp=$categories[$i];
	$hits{$temp}=0 if (!$hits{$temp});
	$categories[$i]=~s/ /\+/g;
	$categories[$i]=~s/\&/\%26/g;
	$result.="<td><a href=\"$cgi/adcbrow.pl?lang=$data{lang}&cat=$categories[$i]\"><font size=1 color=black><b>$temp ($hits{$temp})</b></font></a></td></tr>";
	$i++;
	}
	else
	{
	$result.="<td></td></tr>";
	}
}
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
