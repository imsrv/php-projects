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
if ($ENV{CONTENT_LENGTH}>0){if ($sysid eq "Windows"){read(STDIN,$query,$ENV{CONTENT_LENGTH});} else {$query=<STDIN>;}}
@query=split("&",$query);
foreach (@query)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9A-Fa-f]{2})/pack('C',hex($1))/eg;
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
open (F, "<$basepath/category.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($cat,$subcat)=split(":",$_);
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
	($cat,$subcat)=split(":",$cat);
	$hits{$cat}+=1;
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
if (!$data{EMail})
{
	$error1="$rep[26]<br>";
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
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@users=<F>;
flock(F,$LOCK_UN);
close (F);
foreach (@users)
{
	($emls,$user,$password)=split("\t",$_);
	if ($data{EMail} eq $emls)
	{
		$fres.="Login: $user\nPassword: $password\n\n";
		$flag=1;
        }
}
if ($flag)
{
	open(F,"<$adcpath/mail/user.hdr");
	@header=<F>;
	close(F);
	open(F,"<$adcpath/mail/user.btm");
	@bottom=<F>;
	close(F);
	if ($smtpserver)
	{
		$header=join("",@header);
		$bottom=join("",@bottom);
		&sendviasmtp("$email ($owntitle)",$data{EMail},"Password request","$header\n$fres\n\n$bottom");
	}
	else
	{
	open (MAIL,"|$progmail");
	print MAIL "To: $data{EMail}\n";
	print MAIL "From: $email ($owntitle)\n";
	print MAIL "Subject: Password request\n\n";
	print MAIL @header;
	print MAIL "\n";
	print MAIL $fres;
	print MAIL "\n\n";
	print MAIL @bottom;
	print MAIL "\n.\n";
	close (MAIL);
	}
	$error1="$rep[27]<br>";
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
$error1="$rep[28]<br>";
open (F,"<$adcpath/template/$data{lang}/index.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
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
