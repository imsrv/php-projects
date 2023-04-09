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
if ($ENV{CONTENT_LENGTH}>0){if ($sysid eq "Windows"){read(STDIN,$query,$ENV{CONTENT_LENGTH});} else {$query=<STDIN>;}}
@query=split("&",$query);
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
#vALiDATi0N
open (F,"<$basepath/$data{destination}/maillist.msg");
@messages=<F>;
close (F);
foreach(@messages){eval $_;}
unless ($data{email}=~/.+\@.+/)
{
	push (@errors,$errneml);
	open (F,"<$basepath/$data{destination}/mesbmls.tpl");
	@htmlpage=<F>;
	close (F);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
}
$destination=$data{method};
&$destination;

sub subscribe
{
open (F,"<$basepath/$data{destination}/maillist");
flock(F,$LOCK_EX);
@emaillist=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@emaillist)
{
	chop;
	if ($_ eq $data{email})
	{
		push (@errors,$errex);
		open (F,"<$basepath/$data{destination}/mesbmls.tpl");
		@htmlpage=<F>;
		close (F);
		$htmlpage=join("",@htmlpage);
		$htmlpage="print qq~$htmlpage~;";
		print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
		print "content-type: text/html\n\n";
		eval $htmlpage;
		exit;
	}
}
open (F,">>$basepath/$data{destination}/maillist");
flock(F,$LOCK_EX);
print F "$data{email}\n";
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/$data{destination}/msubmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub unsubscribe
{
open (F,"+<$basepath/$data{destination}/maillist");
flock(F,$LOCK_EX);
@emaillist=<F>;
foreach(@emaillist)
{
	chop;
	if ($_ eq $data{email})
	{
		$flag=1;
		next;
	}
	push(@nemaillist,"$_\n");
}
if (!$flag)
{
	flock(F,$LOCK_UN);
	close(F);
	push (@errors,$errnex);
	open (F,"$basepath/$data{destination}/mesbmls.tpl");
	@htmlpage=<F>;
	close (F);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
}
truncate (F,0);
seek (F,0,0);
print F @nemaillist;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/$data{destination}/munsmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}