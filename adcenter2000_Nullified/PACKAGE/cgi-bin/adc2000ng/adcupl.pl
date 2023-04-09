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
binmode STDIN;
read (STDIN,$buf,$ENV{CONTENT_LENGTH});
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
$pdate="$month $date $year";

#pARSE dATA
($boundary)=$ENV{CONTENT_TYPE}=~/boundary="([^"]+)"/; #";
($boundary)=$ENV{CONTENT_TYPE}=~/boundary=(\S+)/ unless $boundary;
$boundary="--".$boundary;
@file=split("\r\n$boundary",$buf);
foreach (@file)
{
	s/\r\n\r\n/delimeter/;
}
($field,$data{name})=split("delimeter",$file[0]);
($field,$data{lang})=split("delimeter",$file[1]);
($field,$data{password})=split("delimeter",$file[2]);
($field,$data{spot})=split("delimeter",$file[3]);
($field,$data{method})=split("delimeter",$file[4]);
($field,$file)=split("delimeter",$file[5]);
$name=$data{name};
$spot=$data{spot};
$selected{$spot}="selected";
$field=~s/filename\=//;
$field=~s/\"//g;
@field=split(/\./,$field);
$exten=pop(@field);
($exten)=split(" ",$exten);
$filenm=join("",@field);
$exten=~tr/A-Z/a-z/;
if ($filenm=~/\\/){@filenm=split(/\\/,$filenm);$filenm=pop(@filenm);}
else {@filenm=split(/\//,$filenm);$filenm=pop(@filenm);}
$selected{banman}="selected";
open (F, "<$adcpath/langpack/$data{lang}.mtd");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
open (F, "<$adcpath/langpack/$data{lang}.spb");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if (($exten eq "jpg" || $exten eq "gif") && length($file)<=$mfilesize[$spot])
{
	if (-e "$basepath/$data{name}/autoaccept")
	{
	unlink ("$adcpath/banners$data{spot}/$data{name}.gif");
	unlink ("$adcpath/banners$data{spot}/$data{name}.jpg");
	unlink ("$adcpath/banners$data{spot}/$data{name}.swf");
	opendir(Dir,"$adcpath/banners$data{spot}/$data{name}");
	@flz=readdir(Dir);
	closedir(Dir);
	shift(@flz);
	shift(@flz);
	foreach(@flz){unlink("$adcpath/banners$data{spot}/$data{name}/$_");}
	rmdir("$adcpath/banners$data{spot}/$data{name}");
	unlink ("$adcpath/banners$data{spot}/$data{name}.ext");
	($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
	$pdate="$month $date $year";
	open (FL, ">$basepath/$name/banner$spot");
	flock(FL,$LOCK_EX);
	print FL $pdate;
	flock(FL,$LOCK_UN);
	close(FL);
	open (F,">$adcpath/banners$spot/$name.$exten");
	flock(F,$LOCK_EX);
	binmode F;
	print F $file;
	flock(F,$LOCK_UN);
	close (F);
	srand;
	$random=rand 1;
	if (-e "$adcpath/banners$data{spot}/$data{name}.gif")
	{
		$bannerco="<br><img src=\"$cgi/adcgepic.pl?$data{name}.gif&$data{spot}&$random\" width=$banwidth[$spot] height=$banheight[$spot]>";
	}
	elsif (-e "$adcpath/banners$data{spot}/$data{name}.jpg")
	{
		$bannerco="<br><img src=\"$cgi/adcgepic.pl?$data{name}.jpg&$data{spot}&$random\" width=$banwidth[$spot] height=$banheight[$spot]>";
	}
	open (FL, "<$adcpath/template/$data{lang}/muplstat2.tpl");
	@htmlpage=<FL>;
	close (FL);
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
	opendir(Dir,"$adcpath/queye/$data{spot}/$data{name}");
	@flz=readdir(Dir);
	closedir(Dir);
	shift(@flz);
	shift(@flz);
	foreach(@flz){unlink("$adcpath/queye/$data{spot}/$data{name}/$_");}
	rmdir("$adcpath/queye/$data{spot}/$data{name}");
	unlink ("$adcpath/queye/$data{spot}/$data{name}.ext");
	open (F,">$adcpath/queye/$spot/$name.$exten");
	flock(F,$LOCK_EX);
	binmode F;
	print F $file;
	flock(F,$LOCK_UN);
	close (F);
	if ($smtpserver)
	{
		&sendviasmtp("$email ($owntitle)",$email,"Banner Pending Approval","Received from: $owntitle\n\nUsername: $name\nBannerpool: $spot\n\n");
	}
	else
	{
	open (MAIL,"|$progmail");
	print MAIL "To: $email\n";
	print MAIL "From: $email ($owntitle)\n";
	print MAIL "Subject: Banner Pending Approval\n\n";
	print MAIL "Received from: $owntitle\n\n";
	print MAIL "Username: $name\n";
	print MAIL "Bannerpool: $spot\n";
	print MAIL "\n.\n";
	close (MAIL);
	}
	srand;
	$random=rand 1;
	if (-e "$adcpath/queye/$data{spot}/$data{name}.gif")
	{
		$bannerco="<br><img src=\"$cgi/adcgpic.pl?$data{name}.gif&$data{spot}&$random\" width=$banwidth[$spot] height=$banheight[$spot]>";
	}
	elsif (-e "$adcpath/queye/$data{spot}/$data{name}.jpg")
	{
		$bannerco="<br><img src=\"$cgi/adcgpic.pl?$data{name}.jpg&$data{spot}&$random\" width=$banwidth[$spot] height=$banheight[$spot]>";
	}
	open (FL, "<$adcpath/template/$data{lang}/muplstat.tpl");
	@htmlpage=<FL>;
	close (FL);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
}
if (($exten eq "swf" || $exten eq "class") && length($file)<=$mfilesize[$spot])
{
	if (-e "$basepath/$data{name}/autoaccept")
	{
	$spot=$data{spot};
	unlink ("$adcpath/banners$data{spot}/$data{name}.gif");
	unlink ("$adcpath/banners$data{spot}/$data{name}.jpg");
	unlink ("$adcpath/banners$data{spot}/$data{name}.swf");
	opendir(Dir,"$adcpath/banners$data{spot}/$data{name}");
	@flz=readdir(Dir);
	closedir(Dir);
	shift(@flz);
	shift(@flz);
	foreach(@flz){unlink("$adcpath/banners$data{spot}/$data{name}/$_");}
	rmdir("$adcpath/banners$data{spot}/$data{name}");
	unlink ("$adcpath/banners$data{spot}/$data{name}.ext");
	if ($exten eq "class")
	{
		mkdir "$adcpath/banners$data{spot}/$data{name}",0777;
		chmod 0777,"$adcpath/banners$data{spot}/$data{name}/";
		open (F,">$adcpath/banners$spot/$name/$filenm.$exten");
		flock(F,$LOCK_EX);
		binmode F;
		print F $file;
		flock(F,$LOCK_UN);
		close (F);
	}
	else
	{
		open (F,">$adcpath/banners$spot/$name.$exten");
		flock(F,$LOCK_EX);
		binmode F;
		print F $file;
		flock(F,$LOCK_UN);
		close (F);
	}
	if ($exten eq "swf")
	{
$code=qq~<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0" ID=TD WIDTH=$banwidth[$spot] HEIGHT=$banheight[$spot]>
<PARAM NAME=movie VALUE="$adcenter/banners$data{spot}/$data{name}.$exten">
<PARAM NAME=quality VALUE=high>
<PARAM NAME=bgcolor VALUE=#004E75>
<EMBED src="$adcenter/banners$data{spot}/$data{name}.$exten" quality=high bgcolor=#FF9966  WIDTH=$banwidth[$spot] HEIGHT=$banheight[$spot] TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
</OBJECT>
~;
	}
	else
	{
$code=qq~<APPLET CODEBASE="$adcenter/banners$data{spot}/$data{name}" CODE="$filenm.class" WIDTH="$banwidth[$spot]" HEIGHT="$banheight[$spot]">
</APPLET>
~;
	}
	open (FL, "<$adcpath/template/$data{lang}/mup2stat.tpl");
	@htmlpage=<FL>;
	close (FL);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
	}
	$spot=$data{spot};
	unlink ("$adcpath/queye/$data{spot}/$data{name}.gif");
	unlink ("$adcpath/queye/$data{spot}/$data{name}.jpg");
	unlink ("$adcpath/queye/$data{spot}/$data{name}.swf");
	opendir(Dir,"$adcpath/queye/$data{spot}/$data{name}");
	@flz=readdir(Dir);
	closedir(Dir);
	shift(@flz);
	shift(@flz);
	foreach(@flz){unlink("$adcpath/queye/$data{spot}/$data{name}/$_");}
	rmdir("$adcpath/queye/$data{spot}/$data{name}");
	unlink ("$adcpath/queye/$data{spot}/$data{name}.ext");
	if ($exten eq "class")
	{
		mkdir "$adcpath/queye/$data{spot}/$data{name}",0777;
		chmod 0777,"$adcpath/queye/$data{spot}/$data{name}/";
		open (F,">$adcpath/queye/$spot/$name/$filenm.$exten");
		flock(F,$LOCK_EX);
		binmode F;
		print F $file;
		flock(F,$LOCK_UN);
		close (F);
	}
	else
	{
		open (F,">$adcpath/queye/$spot/$name.$exten");
		flock(F,$LOCK_EX);
		binmode F;
		print F $file;
		flock(F,$LOCK_UN);
		close (F);
	}
	if ($exten eq "swf")
	{
$code=qq~<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0" ID=TD WIDTH=$banwidth[$spot] HEIGHT=$banheight[$spot]>
<PARAM NAME=movie VALUE="$adcenter/banners$data{spot}/$data{name}.$exten">
<PARAM NAME=quality VALUE=high>
<PARAM NAME=bgcolor VALUE=#004E75>
<EMBED src="$adcenter/banners$data{spot}/$data{name}.$exten" quality=high bgcolor=#FF9966  WIDTH=$banwidth[$spot] HEIGHT=$banheight[$spot] TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
</OBJECT>
~;
	}
	else
	{
$code=qq~<APPLET CODEBASE="$adcenter/banners$data{spot}/$data{name}" CODE="$filenm.class" WIDTH="$banwidth[$spot]" HEIGHT="$banheight[$spot]">
</APPLET>
~;
	}
	open (FL, "<$adcpath/template/$data{lang}/mup2stat.tpl");
	@htmlpage=<FL>;
	close (FL);
	$htmlpage=join("",@htmlpage);
	$htmlpage="print qq~$htmlpage~;";
	print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
	print "content-type: text/html\n\n";
	eval $htmlpage;
	exit;
}
open (F, "<$adcpath/langpack/$data{lang}.msg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
push (@errors, $rep[1]);
open (FL, "<$adcpath/template/$data{lang}/merustat.tpl");
@htmlpage=<FL>;
close (FL);
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
