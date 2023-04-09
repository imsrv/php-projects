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
&initial if (!$data{method});
open (F,"<$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
@users=<F>;
flock(F,$LOCK_UN);
close (F);
$data{Username}=~tr/A-Z/a-z/;

#vALiDATi0N
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if (!$data{Name})
{
	$data{Name}=$rep[8];
	$flag=1;
}
if (!$data{Address})
{
	$data{Address}=$rep[9];
	$flag=1;
}
if (!$data{City})
{
	$data{City}=$rep[10];
	$flag=1;
}
if (!$data{ZipCode})
{
	$data{ZipCode}=$rep[11];
	$flag=1;
}
if (!$data{Phone})
{
	$data{Phone}=$rep[12];
	$flag=1;
}
unless ($data{EMail}=~/^[\w\-.]+\@{1}[\w\-.]+$/ && $data{EMail}=~/^\w+/ && $data{EMail}=~/\w+$/)
{
	$data{EMail}=$rep[13];
	$flag=1;
}
if ($data{Username}=~/\W+/ || $data{Username} eq "")
{
	$data{Username}=$rep[14];
	$flag=1;
}
foreach (@users)
{
	($user,$password)=split(":",$_);
	if (crypt($data{Username},$data{Username}) eq $user)
	{
		$data{Username}=$rep[15];
		$flag=1;
        }
}
if ($data{Password}=~/\W+/ || $data{Password} eq "")
{
	$data{Password}=$rep[16];
	$flag=1;
}
unless ($data{URL}=~/http:\/\/.+/)
{
	$data{URL}=$rep[17];
	$flag=1;
}
if (!$data{Sitetitle})
{
	$data{Sitetitle}=$rep[18];
	$flag=1;
}
&error if ($flag);
$data{Keywords}=~s/\,/ /g;
$data{Keywords}=~s/ +/\,/g;
#pRiNT cONFIRMATION pAGE
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{Category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@country=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@country)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{Country}==$id){$countries.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$countries.=qq~<option value="$id">$idn</option>\n~;
}
if ($data{show}){$showcheck="<input type=checkbox checked name=show value=1>";}
else {$showcheck="<input type=checkbox name=show value=1>";}
open (F,"<$adcpath/template/$data{lang}/confirm.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;

######################################################################
#sUBROTiNES sECTiON                                                  #
######################################################################
sub error
{
if ($data{show}){$showcheck="<input type=checkbox checked name=show value=1>";}
else {$showcheck="<input type=checkbox name=show value=1>";}
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{Category}==$id){$categories.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@country=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@country)
{
	chop;
	($id,$idn)=split("\t",$_);
	if ($data{Country}==$id){$countries.=qq~<option selected value="$id">$idn</option>\n~;next;}
	$countries.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/joinerr.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub initial
{
$showcheck="<input type=checkbox name=show value=1>";
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@category=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@category)
{
	chop;
	($id,$idn)=split("\t",$_);
	$categories.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@country=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@country)
{
	chop;
	($id,$idn)=split("\t",$_);
	$countries.=qq~<option value="$id">$idn</option>\n~;
}
open (F,"<$adcpath/template/$data{lang}/join.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
