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

######################################################################
#mAiN sECTi0N                                                        #
######################################################################
#gET dATA
print "HTTP/1.0 200 OK\n";
print "content-type: text/html\n\n";
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
		$data{$field}=$value;
	}
}
$encline=crypt($data{name},$data{name}).":".crypt($data{password},$data{password});
$destination=$data{method};
#aUTH0RiSATiON
open (F, "<$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
@pass=<F>;
flock(F,$LOCK_UN);
close (F);
chop($admpass=shift(@pass));
&$destination if ($admpass eq $encline);
print qq~<font size=4>ACCESS DENIED</font>
~;
sub maillist
{
	open (F,"<$basepath/temp.msg");
	flock(F,$LOCK_EX);
	@body=<F>;
	flock(F,$LOCK_UN);
	close (F);
	$data{subject}=shift(@body);
	unlink ("$basepath/temp.msg");
	open (F,"<$basepath/maillist.db");
	flock(F,$LOCK_EX);
	@emails=<F>;
	flock(F,$LOCK_UN);
	close (F);
	open(F,"<$adcpath/mail/list.hdr");
	flock(F,$LOCK_EX);
	@header=<F>;
	flock(F,$LOCK_UN);
	close(F);
	open(F,"<$adcpath/mail/list.btm");
	flock(F,$LOCK_EX);
	@bottom=<F>;
	flock(F,$LOCK_UN);
	close(F);
	$count=0;
	$total=@emails;
	$current=0;
	if (@emails>0)
	{
	if ($smtpserver)
	{
		$header=join("",@header);
		$body=join("",@body);
		$bottom=join("",@bottom);
		$message="$header\n$body\n\n$bottom";
		$message=~s/\n/\r\n/g;
		&sendviasmtp;
	}
	foreach(@emails)
	{
	chop;
	$count++;
	open (MAIL,"|$progmail");
	print MAIL "To: $_\n";
	print MAIL "From: $email ($owntitle)\n";
	print MAIL "Subject: $data{subject}\n\n";
	print MAIL @header;
	print MAIL "\n";
	print MAIL @body;
	print MAIL "\n\n";
	print MAIL @bottom;
	print MAIL "\n.\n";
	close (MAIL);
	if (int($count/$total*100)>$current)
	{
		$differ=int($count/$total*100)-$current;
		$current+=$differ;
		$stb=qq~<img src="$adcenter/images/mailbar.gif" height=$differ width=96><br>\n~;
		$numb=4052-7-length($stb);
		$addln="A" x $numb;
		print qq~<!--$addln-->$stb~;
	}
	}
	}
	print qq~<font size=3>MAIL SENT</font>
	~;
	exit;
}
sub sendviasmtp
{
$localhost=(gethostbyname('localhost'))[0] || 'localhost';
foreach(@emails)
{
chop;
$count++;
socket(S,PF_INET,SOCK_STREAM,(getprotobyname('tcp'))[2]) || &error($!);
$farg=sockaddr_in($smtpport,inet_aton($smtpserver)) || &error($!);
connect(S,$farg) || &error($!);
$res=<S>;
if ($res=~/^[45]/){&error($res);}
$mes="HELO $localhost\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){&error($res);}
$mes="mail from: <$email>\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){&error($res);}
$mes="rcpt to: <$_>\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if (int($count/$total*100)>$current)
{
	$differ=int($count/$total*100)-$current;
	$current+=$differ;
	$stb=qq~<img src="$adcenter/images/mailbar.gif" height=$differ width=96><br>\n~;
	$numb=4052-7-length($stb);
	$addln="A" x $numb;
	print qq~<!--$addln-->$stb~;
}
if ($res=~/^[45]/){close(S);next;}
$mes="data\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
$mes="From: $owntitle <$email>\r\nTo: $_\r\nSubject:$data{subject}\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$mes="\r\n$message\r\n.\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
if ($res=~/^[45]/){&error($res);}
$mes="quit\r\n";
$len=length($mes);
syswrite(S,$mes,$len);
$res=<S>;
close(S);
}
print qq~<font size=3>MAIL SENT</font>~;
exit;
}

sub error
{
$res=$_[0];
close(S);
print qq~<font size=3>ERROR: $res</font>~;
exit;
}
