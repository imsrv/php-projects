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
#rEADiNG vARiABLES fROM fiLE
open (F, "<adc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
if ($smtpserver){use Socket;$sockaddr = 'S n a4 x8';}
use ADCahelp;

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
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		if ($field eq "target")
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
$encline=crypt($data{name},$data{name}).":".crypt($data{password},$data{password});
$data{newmethod}="remove_banner" if ($data{'remban.x'});
$data{newmethod}="accept_banner" if ($data{'accban.x'});
$data{newmethod}="remove_sbanner" if ($data{'sremban.x'});
$data{newmethod}="accept_sbanner" if ($data{'saccban.x'});
$data{newmethod}="remove_txbanner" if ($data{'txremban.x'});
$data{newmethod}="accept_txbanner" if ($data{'txaccban.x'});
$data{newmethod}="delete_faq" if ($data{'delete_faq.x'});
$data{newmethod}="update_faq" if ($data{'update_faq.x'});
$data{method}=$data{newmethod} if ($data{newmethod});
$destination=$data{method};
$selected{$destination}="selected";
$spoot=$data{spot};
$selected{$spoot}="selected";

#aUTH0RiSATiON
open (F, "<$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
@pass=<F>;
flock(F,$LOCK_UN);
close (F);
chop($admpass=shift(@pass));
&$destination(%data) if ($admpass eq $encline);
open (F,"<$adcpath/template/aerrauth.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;

######################################################################
#sUBR0TiNES sECTi0N                                                  #
######################################################################
sub genset
{
$selected{genset}="selected";
$banwidth=join(",",@banwidth);
$banheight=join(",",@banheight);
$mfilesize=join(",",@mfilesize);
$enablemb=join(",",@enablemb);
open (F,"<$adcpath/template/agenstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub userman
{
$selected{userman}="selected";
$statusline="Status is not avaivable. Just logged in." if (!$statusline);
open (F,"<$adcpath/template/auserman.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub analyze
{
$selected{analyze}="selected";
$selectedn{analyze}="selected";
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	($username)=split("\t",$_);
        $size=-s "$basepath/$username/ca.log";
	push (@ndta,qq~<a href="$cgi/adcadm.pl?method=getuserlog&name=$data{name}&password=$data{password}&user=$username">$username ($size b)</a>~) if ($size);
}
@ndta=sort(@ndta);
$ndta=join("<br>\n",@ndta);
open (F,"<$adcpath/template/aanalyze.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub getuserlog
{
$selected{analyze}="selected";
$selectedn{analyze}="selected";
open (F, "<$basepath/$data{user}/ca.log");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($date,$comment,$ip)=split("\t",$_);
	$ip=~s/\,/\, /g;
	push (@ndta,qq~<tr><td valign=top><font size=2>$date</font></td><td valign=top><font size=2>$comment</font></td><td valign=top><font size=2>$ip</font></td></tr>~);
}
$ndta=join("\n",@ndta);
open (F,"<$adcpath/template/auserlog.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub clearalllogs
{
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	($username)=split("\t",$_);
	if (-s "$basepath/$username/ca.log")
	{
		open (F, ">$basepath/$username/ca.log");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close (F);
	}
}
&analyze;
}
sub clearlog
{
open (F, ">$basepath/$data{user}/ca.log");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close (F);
&analyze;
}
sub ctranalyze
{
$selected{analyze}="selected";
$selectedn{ctranalyze}="selected";
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	($username)=split("\t",$_);
	if (-s "$basepath/$username/affilx")
	{
        $size=(-s "$basepath/$username/affilc")/(-s "$basepath/$username/affilx");
	$size=$size*100;
	$size=sprintf "%.2f",$size;
	}
	else {$size=0;}
	push (@ndta,qq~<tr><td valign=top><font size=2>$username</font></td><td valign=top><font size=2>$size</font></td></tr>~) if ($size<$minctr || $size>$maxctr);
}
@ndta=sort(@ndta);
$ndta=join("\n",@ndta);
open (F,"<$adcpath/template/actranal.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub advanalyze
{
$selected{analyze}="selected";
$selectedn{advanalyze}="selected";
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	($username)=split("\t",$_);
	open (F, "<$basepath/$username/affiliate");
	flock(F,$LOCK_EX);
	@dcta=<F>;
	flock(F,$LOCK_UN);
	close (F);
	foreach $dcta(@dcta)
	{
		chop($dcta);
		($user,$url,$imp,$clc)=split("\t",$dcta);
		push (@ndta,qq~<tr><td valign=top><font size=2>$username</font></td><td valign=top><font size=2>$user</font></td><td valign=top><font size=2>$imp</font></td><td valign=top><font size=2>$clc</font></td></tr>~)if ($clc>$imp);
	}
}
@ndta=sort(@ndta);
$ndta=join("\n",@ndta);
open (F,"<$adcpath/template/aadvanal.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub maillist
{
$selected{genset}="maillist";
open (F, "<$basepath/maillist.db");
flock(F,$LOCK_EX);
@emails=<F>;
flock(F,$LOCK_UN);
close(F);
$total=scalar(@emails);
open (F,"<$adcpath/template/amaillst.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub remmail
{
@emails=split(",",$data{email});
foreach $eml(@emails)
{
$eml=~s/ //g;
$data{email}=$eml;
@nemails=();
open (F, "+<$basepath/maillist.db");
flock(F,$LOCK_EX);
@emailse=<F>;
foreach(@emailse)
{
chop;
next if ($_ eq $data{email});
push(@nemails,"$_\n");
}
truncate (F,0);
seek (F,0,0);
print F @nemails;
flock(F,$LOCK_UN);
close (F);
}
&maillist;
}
sub addmail
{
@emails=split(",",$data{email});
foreach $eml(@emails)
{
$eml=~s/ //g;
$data{email}=$eml;
$flag=0;
open (F, "+<$basepath/maillist.db");
flock(F,$LOCK_EX);
@emailse=<F>;
foreach(@emailse)
{
chop;
if ($_ eq $data{email}){$flag=1;$_.="\n";last;}
$_.="\n";
}
push (@emailse,"$data{email}\n") unless ($flag);
truncate (F,0);
seek (F,0,0);
print F @emailse;
flock(F,$LOCK_UN);
close (F);
}
&maillist;
}
sub globstats
{
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	($username,$url,$usrgroup,$uratio,$referuser)=split("\t",$_);
	$i=0;
	while ($i<$totalbanner)
	{
		open (STAT,"<$basepath/$username/impressions$i");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$genimp+=$_;}
			if ($tkey eq $ldate){foreach(@temp){$todimp+=$_;}}
		}
		flock(STAT,$LOCK_UN);
		close (STAT);
		open (STAT,"<$basepath/$username/clicks$i");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$genclc+=$_;}
			if ($tkey eq $ldate){foreach(@temp){$todclc+=$_;}}
		}
		flock(STAT,$LOCK_UN);
		close (STAT);
		$i++;
	}
	open (STAT,"<$basepath/$username/impressions.sb");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach(@temp){$genimpsb+=$_;}
		if ($tkey eq $ldate){foreach(@temp){$todimpsb+=$_;}}
	}
	flock(STAT,$LOCK_UN);
	close (STAT);
	open (STAT,"<$basepath/$username/clicks.sb");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach(@temp){$genclcsb+=$_;}
		if ($tkey eq $ldate){foreach(@temp){$todclcsb+=$_;}}
	}
	flock(STAT,$LOCK_UN);
	close (STAT);
	open (STAT,"<$basepath/$username/impressions.tx");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach(@temp){$genimptx+=$_;}
		if ($tkey eq $ldate){foreach(@temp){$todimptx+=$_;}}
	}
	flock(STAT,$LOCK_UN);
	close (STAT);
	open (STAT,"<$basepath/$username/clicks.tx");
	flock(STAT,$LOCK_EX);
	while($line=<STAT>)
	{
		chop($line);
		($tkey,$tval)=split("\t",$line);
		@temp=split("#",$tval);
		foreach(@temp){$genclctx+=$_;}
		if ($tkey eq $ldate){foreach(@temp){$todclctx+=$_;}}
	}
	flock(STAT,$LOCK_UN);
	close (STAT);
}
$genimp=0 if ($genimp eq "");
$genclc=0 if ($genclc eq "");
$todimp=0 if ($todimp eq "");
$todclc=0 if ($todclc eq "");
$genimpsb=0 if ($genimpsb eq "");
$genclcsb=0 if ($genclcsb eq "");
$todimpsb=0 if ($todimpsb eq "");
$todclcsb=0 if ($todclcsb eq "");
$genimptx=0 if ($genimptx eq "");
$genclctx=0 if ($genclctx eq "");
$todimptx=0 if ($todimptx eq "");
$todclctx=0 if ($todclctx eq "");
$members=scalar(@dta);
open (F,"<$adcpath/template/aglbstat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub affiliate
{
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
@dta=sort(@dta);
$result=qq~
<tr><td width="450">
<font size=5 color="#00B0B0">AFFILIATE STATS</font>
<table border="0" width="100%" cellpadding="0" bgcolor="#E0E0E0">
<tr><td width="60%" valign="top"><font size=2><b>USERNAME</b></font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>IMPRESSIONS</font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>CLICKS</font></td></tr>
~;
foreach(@dta)
{
	($username,$url,$usrgroup,$uratio,$referuser)=split("\t",$_);
	$affilx=-s "$basepath/$username/affilx";
	$affilc=-s "$basepath/$username/affilc";
	$result.=qq~<tr><td width="60%" bgcolor="#C0C0C0" valign="top"><font size=2><b>$username</b></font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>$affilx</font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>$affilc</font></td></tr>\n~;
}
$result.=qq~
<tr><td width="100%" valign="top" colspan=3><font size=2><form action="$cgi/adcadmin.pl" method=post><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="clearaf"><input type=text value="Clear stats"></form></td></tr>
</table>
</td></tr>
~;
open (F,"<$adcpath/template/adm.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("\n",@htmlpage);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub clearaf
{
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
open (F, "<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
@dta=sort(@dta);
$result=qq~
<tr><td width="450">
<font size=5 color="#00B0B0">AFFILIATE STATS</font>
<table border="0" width="100%" cellpadding="0" bgcolor="#E0E0E0">
<tr><td width="60%" valign="top"><font size=2><b>USERNAME</b></font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>IMPRESSIONS</font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>CLICKS</font></td></tr>
~;
foreach(@dta)
{
	($username,$url,$usrgroup,$uratio,$referuser)=split("\t",$_);
	open (F, ">$basepath/$username/affilx");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
	open (F, ">$basepath/$username/affilc");
	flock(F,$LOCK_EX);
	flock(F,$LOCK_UN);
	close (F);
	$affilx=-s "$basepath/$username/affilx";
	$affilc=-s "$basepath/$username/affilc";
	$result.=qq~<tr><td width="60%" bgcolor="#C0C0C0" valign="top"><font size=2><b>$username</b></font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>$affilx</font></td><td width="20%" align="right" bgcolor="#C0C0C0"><font size=2>$affilc</font></td></tr>\n~;
}
$result.=qq~
<tr><td width="100%" valign="top" colspan=3><font size=2><form action="$cgi/adcadmin.pl" method=post><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="clearaf"><input type=text value="Clear stats"></form></td></tr>
</table>
</td></tr>
~;
open (F,"<$adcpath/template/adm.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("\n",@htmlpage);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub banners
{
$data{method}="banners";
$selected{banners}="selected";
$data{spot}=0 if (!$data{spot});
if ($totalbanner>1){$i=0;$spots=qq~<form action="$cgi/adcadm.pl" method=post><table><tr><td><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><input type=hidden name=method value=$data{method}><select name=spot>~;while($i<$totalbanner){$spots.=qq~<option $selected{$i} value="$i">$i ($banwidth[$i] x $banheight[$i])</option>~;$i++;}$spots.=qq~</select></td><td><input type=image border=0 src="$adcenter/images/proceed.gif" width="96" height="23"></td></tr></table></form>\n~;}
$data{start}=0 if (!$data{start});
$start=$data{start};
@data=();
unless (-e "$basepath/log.db" && -M "$basepath/log.db"<15)
{ 
open (F,">$basepath/log.db");
close(F);
}
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@dta)
{
	($user)=split("\t",$_);
	push (@data,$user) if (-e "$adcpath/queye/$data{spot}/$user.gif" || -e "$adcpath/queye/$data{spot}/$user.jpg" || -e "$adcpath/queye/$data{spot}/$user.ext");
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>$reclimit)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=banners&name=$data{name}&password=$data{password}&spot=$data{spot}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=1 face=arial><b>$icount BANNERS IN EXCHANGE</b></font></td>");
	if ($start*$reclimit+$reclimit<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=banners&name=$data{name}&password=$data{password}&spot=$data{spot}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1 face=arial><b>$icount BANNERS IN EXCHANGE</b></font></td>");}
push (@footer,"</tr></table>");
if ($start*$reclimit+$reclimit>scalar(@data))
{
	$i=$start*$reclimit;
	while($i<scalar(@data))
	{
		$user=$data[$i];
		if (-e "$adcpath/queye/$data{spot}/$user.gif")
		{
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"spot\" value=\"$data{spot}\"><li><b>Username:</b> $user</li><br><img src=\"$adcenter/queye/$data{spot}/$user.gif\" height=$banheight[$data{spot}] width=$banwidth[$data{spot}]><br><center><table border=0><tr><td><input type=\"text\" name=\"reason\" size=20 value=\"Decline reason\"></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" border=0 name=\"remban\"><input type=\"image\" border=0 src=\"$adcenter/images/accban.gif\" name=\"accban\"></td></tr></table></center></form>\n");
		}
		elsif (-e "$adcpath/queye/$data{spot}/$user.jpg")
		{
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"spot\" value=\"$data{spot}\"><li><b>Username:</b> $user</li><br><img src=\"$adcenter/queye/$data{spot}/$user.jpg\" height=$banheight[$data{spot}] width=$banwidth[$data{spot}]><br><center><table border=0><tr><td><input type=\"text\" name=\"reason\" size=20 value=\"Decline reason\"></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" border=0 name=\"remban\"><input type=\"image\" border=0 src=\"$adcenter/images/accban.gif\" name=\"accban\"></td></tr></table></center></form>\n");
		}
		elsif (-e "$adcpath/queye/$data{spot}/$user.ext")
		{
			open(F,"<$adcpath/queye/$data{spot}/$user.ext");
			@bannercode=<F>;
			close(F);
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"spot\" value=\"$data{spot}\"><li><b>Username:</b> $user</li><br><textarea name=bannercode cols=55 rows=3>@bannercode</textarea><br><center><table border=0><tr><td><input type=\"text\" name=\"reason\" size=20 value=\"Decline reason\"></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" border=0 name=\"remban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" border=0 name=\"accban\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&user=$user&spot=$data{spot}&method=preview_banner\" target=banner onclick=opwin('$cgi/adcadm.pl?name=$data{name}&password=$data{password}&user=$user&spot=$data{spot}&method=preview_banner')><img border=0 src=\"$adcenter/images/preview.gif\"></a></td></tr></table></center></form>\n");
		}
		$i++;
	}
}
else
{
	$i=$start*$reclimit;
	$last=$i+$reclimit;
	while($i<$last)
	{
		$user=$data[$i];
		if (-e "$adcpath/queye/$data{spot}/$user.gif")
		{
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"spot\" value=\"$data{spot}\"><li><b>Username:</b> $user</li><br><img src=\"$adcenter/queye/$data{spot}/$user.gif\" height=$banheight[$data{spot}] width=$banwidth[$data{spot}]><br><center><table border=0><tr><td><input type=\"text\" name=\"reason\" size=20 value=\"Decline reason\"></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"remban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"accban\"></td></tr></table></center></form>\n");
		}
		elsif (-e "$adcpath/queye/$data{spot}/$user.jpg")
		{
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"spot\" value=\"$data{spot}\"><li><b>Username:</b> $user</li><br><img src=\"$adcenter/queye/$data{spot}/$user.jpg\" height=$banheight[$data{spot}] width=$banwidth[$data{spot}]><br><center><table border=0><tr><td><input type=\"text\" name=\"reason\" size=20 value=\"Decline reason\"></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"remban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"accban\"></td></tr></table></center></form>\n");
		}
		elsif (-e "$adcpath/queye/$data{spot}/$user.ext")
		{
			open(F,"<$adcpath/queye/$data{spot}/$user.ext");
			@bannercode=<F>;
			close(F);
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><input type=\"hidden\" name=\"spot\" value=\"$data{spot}\"><li><b>Username:</b> $user</li><br><textarea name=bannercode cols=55 rows=3>@bannercode</textarea><br><center><table border=0><tr><td><input type=\"text\" name=\"reason\" size=20 value=\"Decline reason\"></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"remban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"accban\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&user=$user&spot=$data{spot}&method=preview_banner\" target=banner onclick=opwin('$cgi/adcadm.pl?name=$data{name}&password=$data{password}&user=$user&spot=$data{spot}&method=preview_banner')><img border=0 src=\"$adcenter/images/preview.gif\"></a></td></tr></table></center></form>\n");
		}
		$i++;
	}
}
if (!@result)
{
	push(@result,"<li>No banners</li>");
}
open (F,"<$adcpath/template/abanover.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub inactive
{
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
$date=$date-7;
if ($date<=0)
{
	$date=31+$date;
	$month=$cal{$month}-1;
	if ($month==0)
	{
		$month=12;
		$year=$year-1;
	}
}
else {$month=$cal{$month};}
$edate="$year$month$date";
$data{start}=0 if (!$data{start});
$start=$data{start};
@data=();
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@dta)
{
	($user,$userurl,$group,$oratio,$ref)=split("\t",$_);
	open (F,"<$basepath/$user/lastact");
	flock(F,$LOCK_EX);
	@lastact=<F>;
	flock(F,$LOCK_UN);
	close(F);
	unless (-e "$basepath/$user/dflag")
	{
	push (@data,$_) if ($lastact[0]<$edate);
	}
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>10)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=inactive&name=$data{name}&password=$data{password}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=1><b>$icount INACTIVE ACCOUNTS</b></font></td>");
	if ($start*10+10<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=inactive&name=$data{name}&password=$data{password}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1><b>$icount INACTIVE ACCOUNTS</b></font></td>");}
push (@footer,"</tr></table>");
if ($start*10+10>scalar(@data))
{
	$i=$start*10;
	while($i<scalar(@data))
	{
		($user,$userurl,$group,$oratio,$ref)=split("\t",$data[$i]);
		open (F, "<$basepath/$user/lastact");
		flock(F,$LOCK_EX);
		@lastact=<F>;
		flock(F,$LOCK_UN);
		close (F);
		$lastact=substr($lastact[0],4,2).".".substr($lastact[0],6,2).".".substr($lastact[0],0,4);
		push(@result,"<form action=\"$cgi/adcadmin.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"username\" value=\"$user\"><li><b>Username:</b> <a href=\"$cgi/adcgnfo.pl?name=$user&method=userinfo\" target=\"_blank\">$user</a></li><br>Last activity: $lastact<br><center><input type=\"submit\" name=\"method\" value=\"remove\"><input type=\"submit\" name=\"method\" value=\"disable\"></center></form>\n");
		$i++;
	}
}
else
{
	$i=$start*10;
	$last=$i+10;
	while($i<$last)
	{
		($user,$userurl,$group,$oratio,$ref)=split("\t",$data[$i]);
		open (F, "<$basepath/$user/lastact");
		flock(F,$LOCK_EX);
		@lastact=<F>;
		flock(F,$LOCK_UN);
		close (F);
		$lastact=substr($lastact[0],4,2).".".substr($lastact[0],6,2).".".substr($lastact[0],0,4);
		push(@result,"<form action=\"$cgi/adcadmin.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"username\" value=\"$user\"><li><b>Username:</b> <a href=\"$cgi/adcgnfo.pl?name=$user&method=userinfo\" target=\"_blank\">$user</a></li><br>Last activity: $lastact<br><center><input type=\"submit\" name=\"method\" value=\"remove\"><input type=\"submit\" name=\"method\" value=\"disable\"></center></form>\n");
		$i++;
	}
}
if (!@result)
{
	push(@result,"<li>No inactive accounts</li>");
}
$result=qq~
<tr><td width="470">
<font size=5 color="#00B0B0">INACTIVE ACCOUNTS</font><br>
<ul>@result</ul>
</td></tr>
<tr><td width="470">
@footer
</td></tr>
~;
open (F,"<$adcpath/template/adm.tpl");
@html=<F>;
close (F);
$html=join("\n",@html);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $html;
exit;
}
sub tasman
{
$selected{tasman}="selected";
open(F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
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
	$result.="<tr><td colspan=2><font size=2><b>$key</b></font></td></tr>";
	@temp=split("##",$categ{$key});
	$i=0;
	while($i<scalar(@temp))
	{
		$verytemp="$key:$temp[$i]";
		$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\"></td><td width=\"40%\"><font size=2>$temp[$i]</font></td>";
		$i++;
		if ($temp[$i] ne "")
		{
		$verytemp="$key:$temp[$i]";
		$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$cata{$verytemp}\"></td><td width=\"40%\"><font size=2>$temp[$i]</font></td></tr>\n";
		}
		else {$result.="<td></td><td></td></tr>\n";}
		$i++;
	}
}
open (F,"<$adcpath/template/acateg.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub category
{
open(F,"+<$basepath/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
foreach(@categ)
{
	chop;
	($id,$idn)=split("\t",$_);
	next if ($data{target}=~/\b$id\b/);
	push(@ncateg,"$_\n");
}
truncate (F,0);
seek (F,0,0);
print F @ncateg;
flock(F,$LOCK_UN);
close(F);
&tasman;
}
sub addcateg
{
if ($data{categ} && $data{subcateg})
{
open(F,"+<$basepath/category.cnt");
flock(F,$LOCK_EX);
$id=<F>;
$id++;
truncate (F,0);
seek (F,0,0);
print F $id;
flock(F,$LOCK_UN);
close(F);
open(F,"+<$basepath/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
push(@categ,"$id\t$data{categ}:$data{subcateg}\n");
foreach(@categ){chop;($first,$second)=split("\t",$_);$_="$second\t$first";}
@categ=sort(@categ);
foreach(@categ){($first,$second)=split("\t",$_);$_="$second\t$first\n";}
truncate (F,0);
seek (F,0,0);
print F @categ;
flock(F,$LOCK_UN);
close(F);
}
&tasman;
}
sub countman
{
$selected{countman}="selected";
open(F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
while($i<scalar(@categ))
{
	
	chop($categ[$i]);
	($id,$categ)=split("\t",$categ[$i]);
	$result.="<tr><td width=\"10%\"><input type=checkbox name=target value=\"$id\"></td><td width=\"40%\"><font size=2>$categ</font></td>";
	$i++;
	if ($categ[$i] ne "")
	{
	chop($categ[$i]);
	($id,$categ)=split("\t",$categ[$i]);
	$result.="<td width=\"10%\"><input type=checkbox name=target value=\"$id\"></td><td width=\"40%\"><font size=2>$categ</font></td></tr>\n";
	}
	else {$result.="<td></td><td></td></tr>\n";}
	$i++;
}
open (F,"<$adcpath/template/acountry.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub country
{
open(F,"+<$basepath/country.db");
flock(F,$LOCK_EX);
@categ=<F>;
foreach(@categ)
{
	chop;
	($id,$idn)=split("\t",$_);
	next if ($data{target}=~/\b$id\b/);
	push(@ncateg,"$_\n");
}
truncate (F,0);
seek (F,0,0);
print F @ncateg;
flock(F,$LOCK_UN);
close(F);
&countman;
}
sub addcountry
{
if ($data{country})
{
open(F,"+<$basepath/category.cnt");
flock(F,$LOCK_EX);
$id=<F>;
$id++;
truncate (F,0);
seek (F,0,0);
print F $id;
flock(F,$LOCK_UN);
close(F);
open(F,"+<$basepath/country.db");
flock(F,$LOCK_EX);
@categ=<F>;
push(@categ,"$id\t$data{country}\n");
foreach(@categ){chop;($first,$second)=split("\t",$_);$_="$second\t$first";}
@categ=sort(@categ);
foreach(@categ){($first,$second)=split("\t",$_);$_="$second\t$first\n";}
truncate (F,0);
seek (F,0,0);
print F @categ;
flock(F,$LOCK_UN);
close(F);
}
&countman;
}
sub checkurl
{
srand;
$random=rand;
$result=qq~
<script language=javascript>
window.open("$cgi/adcspider.pl?name=$data{name}&password=$data{password}&random=$random");
</script>
<tr><td width="450">
<font size=5 color="#00B0B0">URL CHECKING</font>
<table border="0" width="100%" cellpadding="0" bgcolor="#00B0B0">
<tr><td><font size=1><b>This process can take several minutes in dependance how much members do you have. Please, track progress in new opened window.</b></font></td></tr>
</table>
</td></tr>
~;
open (F,"<$adcpath/template/adm.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("\n",@htmlpage);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub a_general
{
open(F,">adc.cfg");
flock(F,$LOCK_EX);
print F qq~######################################################################
# ADCenter 2000NG (Released 15.04.00)	            	             #
#--------------------------------------------------------------------#
# Copyright 1999-2000 TRXX Programming Group                         #
# Programming by Michael "TRXX" Sissine                              #
# All Rights Reserved                                                #
######################################################################
\$owntitle="$data{owntitle}";
\$adcpath="$data{adcpath}";
\$basepath="$data{basepath}";
\$cgi="$data{cgi}";
\$adcenter="$data{adcenter}";
\$sysid="$data{sysid}";
\$progmail="$data{progmail}";
\$smtpserver="$data{smtpserver}";
\$smtpport=$data{smtpport};
\$email='$data{email}';
\$furl="$data{furl}";
\$yourname="$data{yourname}";
\$reclimit=$data{reclimit};
\$gmtzone=$data{gmtzone};
\$copyright="$data{copyright}";
\$inlim=$data{inlim};
\$logrefererfault=$data{logrefererfault};
\$logagentfault=$data{logagentfault};
\$logallowimpperbrowser=$data{logallowimpperbrowser};
\$logallowclcperbrowser=$data{logallowclcperbrowser};
\$logallowipperbrowser=$data{logallowipperbrowser};
\$logcookieduplicates=$data{logcookieduplicates};
\$minctr=$data{minctr};
\$maxctr=$data{maxctr};
\$defaultreason="$data{defaultreason}";
\$defaultlanguage="$data{defaultlanguage}";
\$defaultratio="$data{defaultratio}";
\$clickratio="$data{clickratio}";
\$refratio="$data{refratio}";
\$enablece=$data{enablece};
\$weighttype=$data{weighttype};
\$startcred=$data{startcred};
\$bxalt="$data{bxalt}";
\$totalbanner=$data{totalbanner};
\@banwidth=($data{banwidth});
\@banheight=($data{banheight});
\@mfilesize=($data{mfilesize});
\@enablemb=($data{enablemb});
\$mbanheight=$data{mbanheight};
\$defaultratiosb="$data{defaultratiosb}";
\$clickratiosb="$data{clickratiosb}";
\$enablecesb=$data{enablecesb};
\$enableswim=$data{enableswim};
\$startcredsb=$data{startcredsb};
\$sbwidth=$data{sbwidth};
\$sbheight=\$sbwidth;
\$sbsize=$data{sbsize};
\$defaultratiotx="$data{defaultratiotx}";
\$clickratiotx="$data{clickratiotx}";
\$enablecetx=$data{enablecetx};
\$enabletex=$data{enabletex};
\$startcredtx=$data{startcredtx};
\$stxw=$data{stxw};
\$etxw=$data{etxw};
\$enablecounter=$data{enablecounter};
\$counteralt="$data{counteralt}";
\$enablemaillist=$data{enablemaillist};
\%cal=('Jan','1','Feb','2','Mar','3','Apr','4','May','5','Jun','6','Jul','7','Aug','8','Sep','9','Oct','10','Nov','11','Dec','12');
\%calendar=('Jan','31','Feb','28','Mar','31','Apr','30','May','31','Jun','30','Jul','31','Aug','31','Sep','30','Oct','31','Nov','30','Dec','31');
\@cal=('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
\$LOCK_SH=1;
\$LOCK_EX=2;
\$LOCK_NB=4;
\$LOCK_UN=8;
\$license="$license";
~;
flock(F,$LOCK_UN);
close(F);
open (F, "<adc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}
&genset;
}
sub m_admin
{
open (F,"+<$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
@pass=<F>;
$pass[0]=crypt($data{nname},$data{nname}).":".crypt($data{npassword},$data{npassword})."\n";
truncate (F,0);
seek (F,0,0);
print F @pass;
flock(F,$LOCK_UN);
close (F);
$data{name}=$data{nname};
$data{password}=$data{npassword};
$statusline="You admin login data was changed successfully.";
&userman;
}
sub get_userlist
{
if ($data{type} eq "blitz")
{
	$start=$data{start};
	@data=();
	open (F,"<$basepath/blitz.db");
	flock(F,$LOCK_EX);
	@data=<F>;
	flock(F,$LOCK_UN);
	close(F);
	push (@footer,"<table width=\"100%\" border=0><tr>");
	$icount=scalar(@data);
	if (scalar (@data)>$reclimit)
	{
		if ($start>0)
		{
			$pstart=$start-1;
			push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=$data{method}&type=$data{type}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
		}
		else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
		push(@footer,"<td width=\"70%\" align=\"center\"><font size=1><b>$icount MEMBERS IN DATABASE</b></font></td>");
		if ($start*$reclimit+$reclimit<scalar(@data))
		{
			$nstart=$start+1;
			push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=$data{method}&type=$data{type}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
		}
		else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	}
	else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1><b>$icount MEMBERS IN DATABASE</b></font></td>");}
	push (@footer,"</tr></table>");
	@data=sort(@data);
	if ($start*$reclimit+$reclimit>scalar(@data))
	{
		$i=$start*$reclimit;
		while($i<scalar(@data))
		{
			chop($data[$i]);
			($user,$creds)=split("\t",$data[$i]);
			push(@result,"<li><b>Username:</b> $user<br><font size=\"2\"><b>Blitz credits:</b> $creds</font></li>\n");
			$i++;
		}
	}
	else
	{
		$i=$start*$reclimit;
		$last=$i+$reclimit;
		while($i<$last)
		{
			chop($data[$i]);
			($user,$creds)=split("\t",$data[$i]);
			push(@result,"<li><b>Username:</b> $user<br><font size=\"2\"><b>Blitz credits:</b> $creds</font></li>\n");
			$i++;
		}
	}
	if (!@result)
	{
		push(@result,"<li>Empty blitz pool</li>");
	}
}
else
{
open (FICR,"<$basepath/credits.db");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
flock(FICR,$LOCK_UN);
close(FICR);
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	($imp,$clc)=split(" ",$tval);
	$icredit{$tusr}=$imp;
	$ccredit{$tusr}=$clc;
}
open (FICR,"<$basepath/credits.sb");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
flock(FICR,$LOCK_UN);
close(FICR);
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	($imp,$clc)=split(" ",$tval);
	$icreditsb{$tusr}=$imp;
	$ccreditsb{$tusr}=$clc;
}
open (FICR,"<$basepath/credits.tx");
flock(FICR,$LOCK_EX);
@credits=<FICR>;
flock(FICR,$LOCK_UN);
close(FICR);
foreach(@credits)
{
	chop;
	($tusr,$tval)=split("\t",$_);
	($imp,$clc)=split(" ",$tval);
	$icredittx{$tusr}=$imp;
	$ccredittx{$tusr}=$clc;
}
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@passd=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@passd)
{
	chop;
	($em,$us,$ps)=split("\t",$_);
	$password{$us}=$ps;
}
$start=$data{start};
@data=();
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@gdata=<F>;
flock(F,$LOCK_UN);
close(F);
if ($data{type} eq "all"){@data=@gdata;}
else
{
foreach(@gdata)
{
	($username)=split("\t",$_);
	if ($data{type} eq "enable"){push(@data,$_) unless (-e "$basepath/$username/dflag");}
	elsif ($data{type} eq "disable"){push(@data,$_) if (-e "$basepath/$username/dflag");}
	elsif ($data{type} eq "free"){push(@data,$_) unless (-e "$basepath/$username/advert");}
	elsif ($data{type} eq "advertiser"){push(@data,$_) if (-e "$basepath/$username/advert");}
	elsif ($data{type} eq "expirable"){push(@data,$_) unless (-e "$basepath/$username/nonexpired");}
	elsif ($data{type} eq "nonexpirable"){push(@data,$_) if (-e "$basepath/$username/nonexpired");}
	elsif ($data{type} eq "untrust"){push(@data,$_) unless (-e "$basepath/$username/tflag");}
	elsif ($data{type} eq "trust"){push(@data,$_) if (-e "$basepath/$username/tflag");}
	elsif ($data{type} eq "standard"){push(@data,$_) unless (-e "$basepath/$username/autoaccept");}
	elsif ($data{type} eq "autoaccept"){push(@data,$_) if (-e "$basepath/$username/autoaccept");}
	elsif ($data{type} eq "inactive"){push(@data,$_) if (-M "$basepath/$username/lastact">$inlim && !(-e "$basepath/$username/advert"));}
}
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>$reclimit)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=$data{method}&type=$data{type}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=1><b>$icount MEMBERS IN DATABASE</b></font></td>");
	if ($start*$reclimit+$reclimit<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=$data{method}&type=$data{type}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1><b>$icount MEMBERS IN DATABASE</b></font></td>");}
push (@footer,"</tr></table>");
@data=sort(@data);
if ($start*$reclimit+$reclimit>scalar(@data))
{
	$i=$start*$reclimit;
	while($i<scalar(@data))
	{
		chop($data[$i]);
		($user,$userurl,$group,$country,$oratio,$ref,$weight)=split("\t",$data[$i]);
		if (-e "$basepath/$user/advert"){$usersts="Advertiser";}
		else {$usersts="Free";}
		if (-e "$basepath/$user/nonexpired"){$usersts.=", Non-expirable";}
		else {$usersts.=", Expirable";}
		if (-e "$basepath/$user/tflag"){$usersts.=", Trusted";}
		else {$usersts.=", Untrusted";}
		if (-e "$basepath/$user/autoaccept"){$usersts.=", Autoaccept";}
		else {$usersts.=", Approval required";}
		$inactive=int(-M "$basepath/$user/lastact");
		push(@result,"<li><b>Username:</b> <a href=\"$cgi/adcstat.pl?name=$user&password=$password{$user}&method=genstats&lang=english\" target=\"_blank\">$user</a><br><font size=\"2\"><b>URL:</b> <a href=\"$userurl\" target=\"_blank\">$userurl</a></font><br><font size=1><b>Ratio:</b> $oratio<br><b>Unused credits (IMP/CLC):</b> $icredit{$user}/$ccredit{$user}<br><b>Unused SwimBanner credits (IMP/CLC):</b> $icreditsb{$user}/$ccreditsb{$user}<br><b>Unused TX credits (IMP/CLC):</b> $icredittx{$user}/$ccredittx{$user}<br><b>Weight:</b> $weight<br><b>User status:</b> $usersts<br><b>Inactive:</b> &gt;$inactive days<br></font></li>\n");
		$i++;
	}
}
else
{
	$i=$start*$reclimit;
	$last=$i+$reclimit;
	while($i<$last)
	{
		chop($data[$i]);
		($user,$userurl,$group,$country,$oratio,$ref,$weight)=split("\t",$data[$i]);
		if (-e "$basepath/$user/advert"){$usersts="Advertiser";}
		else {$usersts="Free";}
		if (-e "$basepath/$user/nonexpired"){$usersts.=", Non-expirable";}
		else {$usersts.=", Expirable";}
		if (-e "$basepath/$user/tflag"){$usersts.=", Trusted";}
		else {$usersts.=", Untrusted";}
		$inactive=int(-M "$basepath/$user/lastact");
		push(@result,"<li><b>Username:</b> <a href=\"$cgi/adcstat.pl?name=$user&password=$password{$user}&method=genstats&lang=english\" target=\"_blank\">$user</a><br><font size=\"2\"><b>URL:</b> <a href=\"$userurl\" target=\"_blank\">$userurl</a></font><br><font size=1><b>Ratio:</b> $oratio<br><b>Unused credits (IMP/CLC):</b> $icredit{$user}/$ccredit{$user}<br><b>Unused SwimBanner credits (IMP/CLC):</b> $icreditsb{$user}/$ccreditsb{$user}<br><b>Unused TX credits (IMP/CLC):</b> $icredittx{$user}/$ccredittx{$user}<br><b>Weight:</b> $weight<br><b>User status:</b> $usersts<br><b>Inactive:</b> &gt;$inactive days<br></font></li>\n");
		$i++;
	}
}
if (!@result)
{
	push(@result,"<li>Empty database</li>");
}
}
open (F,"<$adcpath/template/auserlst.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub m_enable
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (-e "$basepath/$data{username}/dflag"){unlink ("$basepath/$data{username}/dflag");$statusline.="Account <b>$data{username}</b> was enabled; ";}
	else {$statusline.="Account <b>$data{username}</b> is already enabled; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_disable
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (!-e "$basepath/$data{username}/dflag"){open (F,">$basepath/$data{username}/dflag");close(F);$statusline.="Account <b>$data{username}</b> was disabled; ";}
	else {$statusline.="Account <b>$data{username}</b> is already disabled; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_free
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (-e "$basepath/$data{username}/advert"){unlink ("$basepath/$data{username}/advert");$statusline.="Account <b>$data{username}</b> was changed to free status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has free status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_advertiser
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (!-e "$basepath/$data{username}/advert"){open (F,">$basepath/$data{username}/advert");close(F);$statusline.="Account <b>$data{username}</b> was changed to advertiser status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has advertiser status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_expired
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (-e "$basepath/$data{username}/nonexpired"){unlink ("$basepath/$data{username}/nonexpired");$statusline.="Account <b>$data{username}</b> was changed to expirable status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has expirable status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_nonexpired
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (!-e "$basepath/$data{username}/nonexpired"){open (F,">$basepath/$data{username}/nonexpired");close(F);$statusline.="Account <b>$data{username}</b> was changed to non-expirable status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has non-expirable status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_untrust
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (-e "$basepath/$data{username}/tflag"){unlink ("$basepath/$data{username}/tflag");$statusline.="Account <b>$data{username}</b> was changed to untrusted status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has untrusted status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_trust
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (!-e "$basepath/$data{username}/tflag"){open (F,">$basepath/$data{username}/tflag");close(F);$statusline.="Account <b>$data{username}</b> was changed to trusted status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has trusted status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_standard
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (-e "$basepath/$data{username}/autoaccept"){unlink ("$basepath/$data{username}/autoaccept");$statusline.="Account <b>$data{username}</b> was changed to Approval required status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has Approval required status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_autoaccept
{
if ($data{username})
{
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
if (-d "$basepath/$data{username}")
{
	if (!-e "$basepath/$data{username}/autoaccept"){open (F,">$basepath/$data{username}/autoaccept");close(F);$statusline.="Account <b>$data{username}</b> was changed to Autoaccept status; ";}
	else {$statusline.="Account <b>$data{username}</b> is already has Autoaccept status; ";}
}
else {$statusline.="Unknown account <b>$data{username}</b>; ";}
}
}
else {$statusline="Please, choose username first";}
&userman;
}
sub m_remove
{
if (!$data{username}){$statusline="Please, choose username first";&userman;}
@usersy=split(",",$data{username});
foreach (@usersy)
{
$data{username}=$_;
$flag=0;
$mflg=0;
@npass=();
@nusers=();
@nuusers=();
@neusers=();
@newusers=();
open (F,"+<$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
@pass=<F>;
$encname=crypt($data{username},$data{username});
foreach(@pass)
{
	if ($_=~/^$encname/)
	{
		$flag=1;
		next;
	}
	push (@npass,$_);
}
truncate (F,0);
seek (F,0,0);
print F @npass;
flock(F,$LOCK_UN);
close (F);
if (!$flag){$statusline.="Unknown account <b>$data{username}</b>; ";next;}
open (F,"+<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@users=<F>;
foreach(@users)
{
	next if ($_=~/^$data{username}\t/);
	push (@nusers,$_);
}
truncate (F,0);
seek (F,0,0);
print F @nusers;
flock(F,$LOCK_UN);
close (F);
open (F,"+<$basepath/global.db");
flock(F,$LOCK_EX);
@users=<F>;
foreach(@users)
{
	next if ($_=~/^$data{username}\t/);
	push (@nuusers,$_);
}
truncate (F,0);
seek (F,0,0);
print F @nuusers;
flock(F,$LOCK_UN);
close (F);
open (F,"+<$basepath/adcenter.srh");
flock(F,$LOCK_EX);
@users=<F>;
foreach(@users)
{
	next if ($_=~/^$data{username}\t/);
	push (@neusers,$_);
}
truncate (F,0);
seek (F,0,0);
print F @neusers;
flock(F,$LOCK_UN);
close (F);
open (F,"+<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@users=<F>;
foreach(@users)
{
	($eml,$usrnm)=split("\t",$_);
	if ($usrnm eq $data{username}){$emlob=$elm;next;}
	push (@newusers,$_);
}
truncate (F,0);
seek (F,0,0);
print F @newusers;
flock(F,$LOCK_UN);
close (F);
foreach(@newusers)
{
	if ($_=~/$emlob\t/){$mflg=1;last;}
}
if (!$mflg)
{
	open (F,"+<$basepath/maillist.db");
	flock(F,$LOCK_EX);
	@users=<F>;
	foreach(@users)
	{
		chop;
		if ($_ eq $emlob){next;}
		push (@newausers,"$_\n");
	}
	truncate (F,0);
	seek (F,0,0);
	print F @newausers;
	flock(F,$LOCK_UN);
	close (F);
}
opendir(Dir,"$basepath/$data{username}");
@files=readdir(Dir);
closedir(Dir);
shift(@files);
shift(@files);
foreach(@files){unlink ("$basepath/$data{username}/$_");}
rmdir ("$basepath/$data{username}");
$i=0;
while($i<$totalbanner)
{
	unlink ("$adcpath/banners$i/$data{username}.gif");
	unlink ("$adcpath/banners$i/$data{username}.jpg");
	unlink ("$adcpath/banners$i/$data{username}.swf");
	unlink ("$adcpath/banners$i/$data{username}.ext");
	opendir(Dir,"$adcpath/banners$i/$data{username}");
	@files=readdir(Dir);
	closedir(Dir);
	shift(@files);
	shift(@files);
	foreach(@files){unlink ("$adcpath/banners$i/$data{username}/$_");}
	rmdir ("$adcpath/banners$i/$data{username}");
	$i++;
}
$statusline.="Account <b>$data{username}</b> was canceled; ";
}
&userman;
}
sub impcred
{
if (!$data{username} && $data{for} eq "user"){$statusline="Please, choose username first";&userman;}
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
if ($data{for} eq "user")
{
	if ($data{service} eq "bx"){open (FICR,"+<$basepath/credits.db");}
	elsif ($data{service} eq "sbx"){open (FICR,"+<$basepath/credits.sb");}
	elsif ($data{service} eq "tx"){open (FICR,"+<$basepath/credits.tx");}
	else {$statusline="Unknown service";&userman;}
	flock(FICR,$LOCK_EX);
	@db=<FICR>;
	foreach(@db)
	{
		chop;
		($tusr,$tval)=split("\t",$_);
		$creds{$tusr}=$tval;
	}
	@users=split(",",$data{username});
	foreach (@users)
	{
	$data{username}=$_;
	if (!-d "$basepath/$data{username}"){$statusline.="Unknown account <b>$data{username}</b>; ";next;}
	($imp,$clc)=split(" ",$creds{$_});
	$imp=$imp+$data{cred};
	$creds{$_}="$imp $clc";
	open (F,">$basepath/$data{username}/lastimp");
	flock(F,$LOCK_EX);
	print F "$data{cred}\n$month $date $year\n";
	flock(F,$LOCK_UN);
	close (F);
	$statusline.="$data{cred} credits were added to account <b>$data{username}</b>; ";
	}
	truncate(FICR,0);
	seek(FICR,0,0);
	foreach $key (keys %creds){print FICR "$key\t$creds{$key}\n";}
	flock(FICR,$LOCK_UN);
	close(FICR);
	&userman;
}
elsif ($data{for} eq "all")
{
	if ($data{service} eq "bx"){open (FICR,"+<$basepath/credits.db");}
	elsif ($data{service} eq "sbx"){open (FICR,"+<$basepath/credits.sb");}
	elsif ($data{service} eq "tx"){open (FICR,"+<$basepath/credits.tx");}
	else {$statusline="Unknown service";&userman;}
	flock(FICR,$LOCK_EX);
	@db=<FICR>;
	foreach(@db)
	{
		chop;
		($tusr,$tval)=split("\t",$_);
		$creds{$tusr}=$tval;
	}
	open (F,"<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@users=<F>;
	flock(F,$LOCK_UN);
	close (F);
	foreach (@users)
	{
		($data{username})=split("\t",$_);
		$usrt=$data{username};
		($imp,$clc)=split(" ",$creds{$usrt});
		$imp=$imp+$data{cred};
		$creds{$usrt}="$imp $clc";
		open (F,">$basepath/$data{username}/lastimp");
		flock(F,$LOCK_EX);
		print F "$data{cred}\n$month $date $year\n";
		flock(F,$LOCK_UN);
		close (F);
	}
	$statusline="$data{cred} credits were added to all accounts</b>";
	truncate(FICR,0);
	seek(FICR,0,0);
	foreach $key (keys %creds){print FICR "$key\t$creds{$key}\n";}
	flock(FICR,$LOCK_UN);
	close(FICR);
	&userman;
}
elsif ($data{for} eq "trust")
{
	if ($data{service} eq "bx"){open (FICR,"+<$basepath/credits.db");}
	elsif ($data{service} eq "sbx"){open (FICR,"+<$basepath/credits.sb");}
	elsif ($data{service} eq "tx"){open (FICR,"+<$basepath/credits.tx");}
	else {$statusline="Unknown service";&userman;}
	flock(FICR,$LOCK_EX);
	@db=<FICR>;
	foreach(@db)
	{
		chop;
		($tusr,$tval)=split("\t",$_);
		$creds{$tusr}=$tval;
	}
	open (F,"<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@users=<F>;
	flock(F,$LOCK_UN);
	close (F);
	foreach (@users)
	{
		($data{username})=split("\t",$_);
		if (-e "$basepath/$data{username}/tflag")
		{
			$usrt=$data{username};
			($imp,$clc)=split(" ",$creds{$usrt});
			$imp=$imp+$data{cred};
			$creds{$usrt}="$imp $clc";
			open (F,">$basepath/$data{username}/lastimp");
			flock(F,$LOCK_EX);
			print F "$data{cred}\n$month $date $year\n";
			flock(F,$LOCK_UN);
			close (F);
		}
	}
	$statusline="$data{cred} credits were added to trusted accounts</b>";
	truncate(FICR,0);
	seek(FICR,0,0);
	foreach $key (keys %creds){print FICR "$key\t$creds{$key}\n";}
	flock(FICR,$LOCK_UN);
	close(FICR);
	&userman;
}
$statusline="Unknown usergroup</b>";
&userman;
}
sub clccred
{
if (!$data{username} && $data{for} eq "user"){$statusline="Please, choose username first";&userman;}
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
if ($data{for} eq "user")
{
	if ($data{service} eq "bx"){open (FICR,"+<$basepath/credits.db");}
	elsif ($data{service} eq "sbx"){open (FICR,"+<$basepath/credits.sb");}
	elsif ($data{service} eq "tx"){open (FICR,"+<$basepath/credits.tx");}
	else {$statusline="Unknown service";&userman;}
	flock(FICR,$LOCK_EX);
	@db=<FICR>;
	foreach(@db)
	{
		chop;
		($tusr,$tval)=split("\t",$_);
		$creds{$tusr}=$tval;
	}
	@users=split(",",$data{username});
	foreach (@users)
	{
	$data{username}=$_;
	($imp,$clc)=split(" ",$creds{$_});
	$clc=$clc+$data{cred};
	$creds{$_}="$imp $clc";
	open (F,">$basepath/$data{username}/lastimp");
	flock(F,$LOCK_EX);
	print F "$data{cred}\n$month $date $year\n";
	flock(F,$LOCK_UN);
	close (F);
	$statusline.="$data{cred} credits were added to account <b>$data{username}</b>; ";
	}
	truncate(FICR,0);
	seek(FICR,0,0);
	foreach $key (keys %creds){print FICR "$key\t$creds{$key}\n";}
	flock(FICR,$LOCK_UN);
	close(FICR);
	&userman;
}
elsif ($data{for} eq "all")
{
	if ($data{service} eq "bx"){open (FICR,"+<$basepath/credits.db");}
	elsif ($data{service} eq "sbx"){open (FICR,"+<$basepath/credits.sb");}
	elsif ($data{service} eq "tx"){open (FICR,"+<$basepath/credits.tx");}
	else {$statusline="Unknown service";&userman;}
	flock(FICR,$LOCK_EX);
	@db=<FICR>;
	foreach(@db)
	{
		chop;
		($tusr,$tval)=split("\t",$_);
		$creds{$tusr}=$tval;
	}
	open (F,"<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@users=<F>;
	flock(F,$LOCK_UN);
	close (F);
	foreach (@users)
	{
		($data{username})=split("\t",$_);
		$usrt=$data{username};
		($imp,$clc)=split(" ",$creds{$usrt});
		$clc=$clc+$data{cred};
		$creds{$usrt}="$imp $clc";
		open (F,">$basepath/$data{username}/lastimp");
		flock(F,$LOCK_EX);
		print F "$data{cred}\n$month $date $year\n";
		flock(F,$LOCK_UN);
		close (F);
	}
	$statusline="$data{cred} credits were added to all accounts</b>";
	truncate(FICR,0);
	seek(FICR,0,0);
	foreach $key (keys %creds){print FICR "$key\t$creds{$key}\n";}
	flock(FICR,$LOCK_UN);
	close(FICR);
	&userman;
}
elsif ($data{for} eq "trust")
{
	if ($data{service} eq "bx"){open (FICR,"+<$basepath/credits.db");}
	elsif ($data{service} eq "sbx"){open (FICR,"+<$basepath/credits.sb");}
	elsif ($data{service} eq "tx"){open (FICR,"+<$basepath/credits.tx");}
	else {$statusline="Unknown service";&userman;}
	flock(FICR,$LOCK_EX);
	@db=<FICR>;
	foreach(@db)
	{
		chop;
		($tusr,$tval)=split("\t",$_);
		$creds{$tusr}=$tval;
	}
	open (F,"<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@users=<F>;
	flock(F,$LOCK_UN);
	close (F);
	foreach (@users)
	{
		($data{username})=split("\t",$_);
		if (-e "$basepath/$data{username}/tflag")
		{
			$usrt=$data{username};
			($imp,$clc)=split(" ",$creds{$usrt});
			$clc=$clc+$data{cred};
			$creds{$usrt}="$imp $clc";
			open (F,">$basepath/$data{username}/lastimp");
			flock(F,$LOCK_EX);
			print F "$data{cred}\n$month $date $year\n";
			flock(F,$LOCK_UN);
			close (F);
		}
	}
	$statusline="$data{cred} credits were added to trusted accounts</b>";
	truncate(FICR,0);
	seek(FICR,0,0);
	foreach $key (keys %creds){print FICR "$key\t$creds{$key}\n";}
	flock(FICR,$LOCK_UN);
	close(FICR);
	&userman;
}
$statusline="Unknown usergroup</b>";
&userman;
}
sub m_ratio
{
if (!$data{username} && $data{for} eq "user"){$statusline="Please, choose username first";&userman;}
if ($data{for} eq "user")
{
	@users=split(",",$data{username});
	foreach (@users)
	{
	$data{username}=$_;
	if (!-d "$basepath/$data{username}"){$statusline.="Unknown account <b>$data{username}</b>; ";next;}
	open (F,"+<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@db=<F>;
	foreach (@db)
	{
		if ($_=~/^$data{username}\t/)
		{
			($user,$userurl,$group,$country,$oratio,$ref,$wei)=split("\t",$_);
			$_="$user\t$userurl\t$group\t$country\t$data{ratio}\t$ref\t$wei";
			last;
		}
	}
	truncate (F,0);
	seek (F,0,0);
	print F @db;
	flock(F,$LOCK_UN);
	close (F);
	$statusline.="Ratio was changed to $data{ratio} for account <b>$data{username}</b>; ";
	}
	&userman;
}
elsif ($data{for} eq "all")
{
	open (F,"+<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@db=<F>;
	foreach (@db)
	{
		($user,$userurl,$group,$country,$oratio,$ref,$wei)=split("\t",$_);
		$_="$user\t$userurl\t$group\t$country\t$data{ratio}\t$ref\t$wei";
	}
	truncate (F,0);
	seek (F,0,0);
	print F @db;
	flock(F,$LOCK_UN);
	close (F);
	$statusline="Ratio was changed to $data{ratio} for all accounts";
	&userman;
}
elsif ($data{for} eq "trust")
{
	open (F,"+<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@db=<F>;
	foreach (@db)
	{
		($user,$userurl,$group,$country,$oratio,$ref,$wei)=split("\t",$_);
		$_="$user\t$userurl\t$group\t$country\t$data{ratio}\t$ref\t$wei" if (-e "$basepath/$user/tflag");
	}
	truncate (F,0);
	seek (F,0,0);
	print F @db;
	flock(F,$LOCK_UN);
	close (F);
	$statusline="Ratio was changed to $data{ratio} for trusted accounts";
	&userman;
}
$statusline="Unknown usergroup</b>";
&userman;
}
sub m_wght
{
if (!$data{username} && $data{for} eq "user"){$statusline="Please, choose username first";&userman;}
if ($data{for} eq "user")
{
	@users=split(",",$data{username});
	foreach (@users)
	{
	$data{username}=$_;
	if (!-d "$basepath/$data{username}"){$statusline.="Unknown account <b>$data{username}</b>; ";next;}
	open (F,"+<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@db=<F>;
	foreach (@db)
	{
		if ($_=~/^$data{username}\t/)
		{
			($user,$userurl,$group,$country,$oratio,$ref,$wei)=split("\t",$_);
			$_="$user\t$userurl\t$group\t$country\t$oratio\t$ref\t$data{wght}\n";
			last;
		}
	}
	truncate (F,0);
	seek (F,0,0);
	print F @db;
	flock(F,$LOCK_UN);
	close (F);
	$statusline.="Weight was changed to $data{wght} for account <b>$data{username}</b>; ";
	}
	&userman;
}
elsif ($data{for} eq "all")
{
	open (F,"+<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@db=<F>;
	foreach (@db)
	{
		($user,$userurl,$group,$country,$oratio,$ref,$wei)=split("\t",$_);
		$_="$user\t$userurl\t$group\t$country\t$oratio\t$ref\t$data{wght}\n";
	}
	truncate (F,0);
	seek (F,0,0);
	print F @db;
	flock(F,$LOCK_UN);
	close (F);
	$statusline="Weight was changed to $data{wght} for all accounts";
	&userman;
}
elsif ($data{for} eq "advertiser")
{
	open (F,"+<$basepath/adcenter.db");
	flock(F,$LOCK_EX);
	@db=<F>;
	foreach (@db)
	{
		($user,$userurl,$group,$country,$oratio,$ref,$wei)=split("\t",$_);
		$_="$user\t$userurl\t$group\t$country\t$oratio\t$ref\t$data{wght}\n" if (-e "$basepath/$user/advert");
	}
	truncate (F,0);
	seek (F,0,0);
	print F @db;
	flock(F,$LOCK_UN);
	close (F);
	$statusline="Weight was changed to $data{wght} for advertisers";
	&userman;
}
$statusline="Unknown usergroup</b>";
&userman;
}
sub blitz
{
if (!$data{username}){$statusline="Please, choose username first";&userman;}
unless (-e "$basepath/blitz.db")
{
open (F,">$basepath/blitz.db");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close (F);
}
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
$fflag=0;
if (!-d "$basepath/$data{username}"){$statusline.="Unknown account <b>$data{username}</b>; ";next;}
open (F,"+<$basepath/blitz.db");
flock(F,$LOCK_EX);
@blitz=<F>;
foreach(@blitz)
{
	($user,$cred)=split("\t",$_);
	if ($user eq $data{username})
	{
		chop($cred);
		$cred+=$data{cred};
		$_="$user\t$cred\n";
		$fflag=1;
		last;
	}
}
push(@blitz,"$data{username}\t$data{cred}\n") if (!$fflag);
truncate(F,0);
seek(F,0,0);
print F @blitz;
flock(F,$LOCK_UN);
close (F);
$statusline.="Account <b>$data{username}</b> was added to blitz pool; ";
}
&userman;
}
sub rem_blitz
{
if (!$data{username}){$statusline="Please, choose username first";&userman;}
@users=split(",",$data{username});
foreach (@users)
{
$data{username}=$_;
@nblitz=();
if (!-d "$basepath/$data{username}"){$statusline.="Unknown account <b>$data{username}</b>; ";next;}
open (F,"+<$basepath/blitz.db");
flock(F,$LOCK_EX);
@blitz=<F>;
foreach(@blitz)
{
	($user)=split("\t",$_);
	next if ($user eq $data{username});
	push(@nblitz,$_);
}
truncate(F,0);
seek(F,0,0);
print F @nblitz;
flock(F,$LOCK_UN);
close (F);
$statusline.="Account <b>$data{username}</b> was removed from blitz pool; ";
}
&userman;
}
sub res_blitz
{
open (F,">$basepath/blitz.db");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close (F);
$statusline="Blitz pool was reset";
&userman;
}
sub remove_banner
{
$data{reason}=$defaultreason if (!$data{reason});
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@usrs=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@usrs)
{
	($ueml,$unm)=split("\t",$_);
	if ($unm eq $data{user})
	{
		open(F,"<$adcpath/mail/msg.hdr");
		flock(F,$LOCK_EX);
		@header=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open(F,"<$adcpath/mail/msg.btm");
		flock(F,$LOCK_EX);
		@bottom=<F>;
		flock(F,$LOCK_UN);
		close(F);
		if ($smtpserver)
		{
			$header=join("",@header);
			$bottom=join("",@bottom);
			&sendviasmtp("$email ($owntitle)",$ueml,"Your banner was declined. Account: $data{user}","$header\nYour banner was declined by admin. Reason: $data{reason}\n\n$bottom");
		}
		else
		{
		open (MAIL,"|$progmail");
		print MAIL "To: $ueml\n";
		print MAIL "From: $email ($owntitle)\n";
		print MAIL "Subject: Your banner was declined. Account: $data{user}\n\n";
		print MAIL @header;
		print MAIL "Your banner was declined by admin. Reason: $data{reason}\n\n";
		print MAIL @bottom;
		print MAIL "\n.\n";
		close (MAIL);
		}
		last;
	}
}
unlink ("$adcpath/queye/$data{spot}/$data{user}.gif");
unlink ("$adcpath/queye/$data{spot}/$data{user}.jpg");
unlink ("$adcpath/queye/$data{spot}/$data{user}.ext");
unlink ("$adcpath/queye/$data{spot}/$data{user}.swf");
opendir(Dir,"$adcpath/queye/$data{spot}/$data{user}");
@files=readdir(Dir);
closedir(Dir);
shift(@files);
shift(@files);
foreach(@files){unlink ("$adcpath/queye/$data{spot}/$data{user}/$_");}
rmdir ("$adcpath/queye/$data{spot}/$data{user}");
&banners;
}
sub accept_banner
{
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@usrs=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@usrs)
{
	($ueml,$unm)=split("\t",$_);
	if ($unm eq $data{user})
	{
		open(F,"<$adcpath/mail/msg.hdr");
		flock(F,$LOCK_EX);
		@header=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open(F,"<$adcpath/mail/msg.btm");
		flock(F,$LOCK_EX);
		@bottom=<F>;
		flock(F,$LOCK_UN);
		close(F);
		if ($smtpserver)
		{
			$header=join("",@header);
			$bottom=join("",@bottom);
			&sendviasmtp("$email ($owntitle)",$ueml,"Your banner was accepted. Account: $data{user}","$header\nYour banner was accepted to $data{spot} banner pool\n\n$bottom");
		}
		else
		{
		open (MAIL,"|$progmail");
		print MAIL "To: $ueml\n";
		print MAIL "From: $email ($owntitle)\n";
		print MAIL "Subject: Your banner was accepted. Account: $data{user}\n\n";
		print MAIL @header;
		print MAIL "Your banner was accepted to $data{spot} banner pool\n\n";
		print MAIL @bottom;
		print MAIL "\n.\n";
		close (MAIL);
		}
		last;
	}
}
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
$pdate="$month $date $year";
if (-e "$adcpath/queye/$data{spot}/$data{user}.gif")
{
	&clear_pool;
	open (F,"<$adcpath/queye/$data{spot}/$data{user}.gif");
	flock(F,$LOCK_EX);
	binmode F;
	@file=<F>;
	flock(F,$LOCK_UN);
	close(F);
	open (F,">$adcpath/banners$data{spot}/$data{user}.gif");
	flock(F,$LOCK_EX);
	binmode F;
	print F @file;
	flock(F,$LOCK_UN);
	close (F);
	open (FL, ">$basepath/$data{user}/banner$data{spot}");
	flock(FL,$LOCK_EX);
	print FL $pdate;
	flock(FL,$LOCK_UN);
	close(FL);
	unlink ("$adcpath/queye/$data{spot}/$data{user}.gif");
}
elsif (-e "$adcpath/queye/$data{spot}/$data{user}.jpg")
{
	&clear_pool;
	open (F,"<$adcpath/queye/$data{spot}/$data{user}.jpg");
	flock(F,$LOCK_EX);
	binmode F;
	@file=<F>;
	flock(F,$LOCK_UN);
	close(F);
	open (F,">$adcpath/banners$data{spot}/$data{user}.jpg");
	flock(F,$LOCK_EX);
	binmode F;
	print F @file;
	flock(F,$LOCK_UN);
	close (F);
	open (FL, ">$basepath/$data{user}/banner$data{spot}");
	flock(FL,$LOCK_EX);
	print FL $pdate;
	flock(FL,$LOCK_UN);
	close(FL);
	unlink ("$adcpath/queye/$data{spot}/$data{user}.jpg");
}
elsif (-e "$adcpath/queye/$data{spot}/$data{user}.ext")
{
	&clear_pool;
	open (F,"<$adcpath/queye/$data{spot}/$data{user}.ext");
	flock(F,$LOCK_EX);
	@file=<F>;
	flock(F,$LOCK_UN);
	close(F);
	open (F,">$adcpath/banners$data{spot}/$data{user}.ext");
	flock(F,$LOCK_EX);
	print F @file;
	flock(F,$LOCK_UN);
	close (F);
	open (FL, ">$basepath/$data{user}/banner$data{spot}");
	flock(FL,$LOCK_EX);
	print FL $pdate;
	flock(FL,$LOCK_UN);
	close(FL);
	unlink ("$adcpath/queye/$data{spot}/$data{user}.ext");
	if (-e "$adcpath/queye/$data{spot}/$data{user}.swf")
	{
		open (F,"<$adcpath/queye/$data{spot}/$data{user}.swf");
		flock(F,$LOCK_EX);
		binmode F;
		@file=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$adcpath/banners$data{spot}/$data{user}.swf");
		flock(F,$LOCK_EX);
		binmode F;
		print F @file;
		flock(F,$LOCK_UN);
		close (F);
		unlink ("$adcpath/queye/$data{spot}/$data{user}.swf");
	}
	elsif (-d "$adcpath/queye/$data{spot}/$data{user}")
	{
		mkdir "$adcpath/banners$data{spot}/$data{user}",0777;
		chmod 0777,"$adcpath/banners$data{spot}/$data{user}/";
		opendir(Dir,"$adcpath/queye/$data{spot}/$data{user}");
		@files=readdir(Dir);
		closedir(Dir);
		shift(@files);
		shift(@files);
		foreach(@files)
		{
			open (F,"<$adcpath/queye/$data{spot}/$data{user}/$_");
			flock(F,$LOCK_EX);
			binmode F;
			@file=<F>;
			flock(F,$LOCK_UN);
			close(F);
			open (F,">$adcpath/banners$data{spot}/$data{user}/$_");
			flock(F,$LOCK_EX);
			binmode F;
			print F @file;
			flock(F,$LOCK_UN);
			close (F);
			unlink ("$adcpath/queye/$data{spot}/$data{user}/$_");
		}
		rmdir("$adcpath/queye/$data{spot}/$data{user}");
	}

}
&banners;
}
sub clear_pool
{
unlink ("$adcpath/banners$data{spot}/$data{user}.ext");
unlink ("$adcpath/banners$data{spot}/$data{user}.gif");
unlink ("$adcpath/banners$data{spot}/$data{user}.jpg");
unlink ("$adcpath/banners$data{spot}/$data{user}.swf");
opendir(Dir,"$adcpath/banners$data{spot}/$data{user}");
@files=readdir(Dir);
closedir(Dir);
shift(@files);
shift(@files);
foreach(@files){unlink ("$adcpath/banners$data{spot}/$data{user}/$_");}
rmdir("$adcpath/banners$data{spot}/$data{user}");
}
sub preview_banner
{
open(F,"<$adcpath/queye/$data{spot}/$data{user}.ext");
@bannercode=<F>;
close(F);
$data{bannercode}=join("",@bannercode);
$data{bannercode}=~s/$adcenter\/banners$data{spot}/$adcenter\/queye\/$data{spot}/g;
open (F,"<$adcpath/template/abanprev.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub sbanners
{
$data{method}="sbanners";
$selected{sbanners}="selected";
$data{start}=0 if (!$data{start});
$start=$data{start};
@data=();
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@dta)
{
	($user)=split("\t",$_);
	push (@data,$user) if (-e "$adcpath/queye/sb/$user.ext");
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>$reclimit)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=sbanners&name=$data{name}&password=$data{password}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=1><b>$icount BANNERS IN EXCHANGE</b></font></td>");
	if ($start*$reclimit+$reclimit<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=sbanners&name=$data{name}&password=$data{password}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1><b>$icount BANNERS IN EXCHANGE</b></font></td>");}
push (@footer,"</tr></table>");
if ($start*$reclimit+$reclimit>scalar(@data))
{
	$i=$start*$reclimit;
	while($i<scalar(@data))
	{
		$user=$data[$i];
		if (-e "$adcpath/queye/sb/$user.gif")
		{
			open(F,"<$adcpath/queye/sb/$user.ext");
			@bannercode=<F>;
			close(F);
			$cellwidth=400-$sbwidth;
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><li><b>Username:</b> $user</li><table border=0 width=\"400\"><tr><td width=$cellwidth valign=top><font size=2>@bannercode</font></td><td width=$sbwidth valign=top align=center><img src=\"$adcenter/queye/sb/$user.gif\" height=$sbheight width=$sbwidth></td></tr></table><center><table border=0><tr><td></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"sremban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"saccban\"></td></tr></table></center></form>\n");
		}
		elsif (-e "$adcpath/queye/sb/$user.jpg")
		{
			open(F,"<$adcpath/queye/sb/$user.ext");
			@bannercode=<F>;
			close(F);
			$cellwidth=400-$sbwidth;
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><li><b>Username:</b> $user</li><table border=0 width=\"400\"><tr><td width=$cellwidth valign=top><font size=2>@bannercode</font></td><td width=$sbwidth valign=top align=center><img src=\"$adcenter/queye/sb/$user.jpg\" height=$sbheight width=$sbwidth></td></tr></table><center><table border=0><tr><td></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"sremban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"saccban\"></td></tr></table></center></form>\n");
		}
		$i++;
	}
}
else
{
	$i=$start*$reclimit;
	$last=$i+$reclimit;
	while($i<$last)
	{
		$user=$data[$i];
		if (-e "$adcpath/queye/sb/$user.gif" && -e "$adcpath/queye/sb/$user.ext")
		{
			open(F,"<$adcpath/queye/sb/$user.ext");
			@bannercode=<F>;
			close(F);
			$cellwidth=400-$sbwidth;
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><li><b>Username:</b> $user</li><table border=0 width=\"400\"><tr><td width=$cellwidth valign=top><font size=2>@bannercode</font></td><td width=$sbwidth valign=top align=center><img src=\"$adcenter/queye/sb/$user.gif\" height=$sbheight width=$sbwidth></td></tr></table><center><table border=0><tr><td></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"sremban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"saccban\"></td></tr></table></center></form>\n");
		}
		elsif (-e "$adcpath/queye/sb/$user.jpg" && -e "$adcpath/queye/sb/$user.ext")
		{
			open(F,"<$adcpath/queye/sb/$user.ext");
			@bannercode=<F>;
			close(F);
			$cellwidth=400-$sbwidth;
			push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><li><b>Username:</b> $user</li><table border=0 width=\"400\"><tr><td width=$cellwidth valign=top><font size=2>@bannercode</font></td><td width=$sbwidth valign=top align=center><img src=\"$adcenter/queye/sb/$user.jpg\" height=$sbheight width=$sbwidth></td></tr></table><center><table border=0><tr><td></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"sremban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"saccban\"></td></tr></table></center></form>\n");
		}
		$i++;
	}
}
if (!@result)
{
	push(@result,"<li>No banners</li>");
}
open (F,"<$adcpath/template/asbanovr.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub remove_sbanner
{
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@usrs=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@usrs)
{
	($ueml,$unm)=split("\t",$_);
	if ($unm eq $data{user})
	{
		open(F,"<$adcpath/mail/msg.hdr");
		flock(F,$LOCK_EX);
		@header=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open(F,"<$adcpath/mail/msg.btm");
		flock(F,$LOCK_EX);
		@bottom=<F>;
		flock(F,$LOCK_UN);
		close(F);
		if ($smtpserver)
		{
			$header=join("",@header);
			$bottom=join("",@bottom);
			&sendviasmtp("$email ($owntitle)",$ueml,"Your SwimBanner was declined. Account: $data{user}","$header\nYour SwimBanner was declined, try to change the text and image and upload your SwimBanner again\n\n$bottom");
		}
		else
		{
		open (MAIL,"|$progmail");
		print MAIL "To: $ueml\n";
		print MAIL "From: $email ($owntitle)\n";
		print MAIL "Subject: You SwimBanner was declined. Account: $data{user}\n\n";
		print MAIL @header;
		print MAIL "Your SwimBanner was declined, try to change the text and image and upload your SwimBanner again\n\n";
		print MAIL @bottom;
		print MAIL "\n.\n";
		close (MAIL);
		}
		last;
	}
}
unlink ("$adcpath/queye/sb/$data{user}.gif");
unlink ("$adcpath/queye/sb/$data{user}.jpg");
unlink ("$adcpath/queye/sb/$data{user}.ext");
&sbanners;
}
sub accept_sbanner
{
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@usrs=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@usrs)
{
	($ueml,$unm)=split("\t",$_);
	if ($unm eq $data{user})
	{
		open(F,"<$adcpath/mail/msg.hdr");
		flock(F,$LOCK_EX);
		@header=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open(F,"<$adcpath/mail/msg.btm");
		flock(F,$LOCK_EX);
		@bottom=<F>;
		flock(F,$LOCK_UN);
		close(F);
		if ($smtpserver)
		{
			$header=join("",@header);
			$bottom=join("",@bottom);
			&sendviasmtp("$email ($owntitle)",$ueml,"Your SwimBanner was accepted. Account: $data{user}","$header\nYour SwimBanner was accepted\n\n$bottom");
		}
		else
		{
		open (MAIL,"|$progmail");
		print MAIL "To: $ueml\n";
		print MAIL "From: $email ($owntitle)\n";
		print MAIL "Subject: Your SwimBanner was accepted. Account: $data{user}\n\n";
		print MAIL @header;
		print MAIL "Your SwimBanner was accepted.\n\n";
		print MAIL @bottom;
		print MAIL "\n.\n";
		close (MAIL);
		}
		last;
	}
}
unlink ("$adcpath/sb/$data{user}.gif");
unlink ("$adcpath/sb/$data{user}.jpg");
unlink ("$adcpath/sb/$data{user}.ext");
if (-e "$adcpath/queye/sb/$data{user}.gif")
{
	open (F,"<$adcpath/queye/sb/$data{user}.gif");
	flock(F,$LOCK_EX);
	binmode F;
	@file=<F>;
	flock(F,$LOCK_UN);
	close(F);
	open (F,">$adcpath/sb/$data{user}.gif");
	flock(F,$LOCK_EX);
	binmode F;
	print F @file;
	flock(F,$LOCK_UN);
	close (F);
	open (FL,"<$adcpath/queye/sb/$data{user}.ext");
	flock(FL,$LOCK_EX);
	@file=<FL>;
	flock(FL,$LOCK_UN);
	close(FL);
	open (FL,">$adcpath/sb/$data{user}.ext");
	flock(FL,$LOCK_EX);
	print FL @file;
	flock(FL,$LOCK_UN);
	close (FL);
	unlink ("$adcpath/queye/sb/$data{user}.gif");
	unlink ("$adcpath/queye/sb/$data{user}.ext");
}
elsif (-e "$adcpath/queye/sb/$data{user}.jpg")
{
	open (F,"<$adcpath/queye/sb/$data{user}.jpg");
	flock(F,$LOCK_EX);
	binmode F;
	@file=<F>;
	flock(F,$LOCK_UN);
	close(F);
	open (F,">$adcpath/sb/$data{user}.jpg");
	flock(F,$LOCK_EX);
	binmode F;
	print F @file;
	flock(F,$LOCK_UN);
	close (F);
	open (FL,"<$adcpath/queye/sb/$data{user}.ext");
	flock(FL,$LOCK_EX);
	@file=<FL>;
	flock(FL,$LOCK_UN);
	close(FL);
	open (FL,">$adcpath/sb/$data{user}.ext");
	flock(FL,$LOCK_EX);
	print FL @file;
	flock(FL,$LOCK_UN);
	close (FL);
	unlink ("$adcpath/queye/sb/$data{user}.jpg");
	unlink ("$adcpath/queye/sb/$data{user}.ext");
}
&sbanners;
}
sub txbanners
{
$data{method}="txbanners";
$selected{txbanners}="selected";
$data{start}=0 if (!$data{start});
$start=$data{start};
@data=();
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@dta)
{
	($user)=split("\t",$_);
	push (@data,$user) if (-e "$adcpath/queye/tx/$user");
}
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>$reclimit)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=txbanners&name=$data{name}&password=$data{password}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=1><b>$icount ADS IN EXCHANGE</b></font></td>");
	if ($start*$reclimit+$reclimit<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?method=txbanners&name=$data{name}&password=$data{password}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1><b>$icount ADS IN EXCHANGE</b></font></td>");}
push (@footer,"</tr></table>");
if ($start*$reclimit+$reclimit>scalar(@data))
{
	$i=$start*$reclimit;
	while($i<scalar(@data))
	{
		$user=$data[$i];
		open(F,"<$adcpath/queye/tx/$user");
		@bannercode=<F>;
		close(F);
		$j=1;
		$intline="";
		foreach(@bannercode)
		{
			chop;
			$intline.="$j). $_<br>\n";
			$j++;
		}
		push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><li><b>Username:</b> $user</li><br><font size=2>$intline</font><center><table border=0><tr><td></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"txremban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"txaccban\"></td></tr></table></center></form>\n");
		$i++;
	}
}
else
{
	$i=$start*$reclimit;
	$last=$i+$reclimit;
	while($i<$last)
	{
		$user=$data[$i];
		open(F,"<$adcpath/queye/tx/$user");
		@bannercode=<F>;
		close(F);
		$j=1;
		$intline="";
		foreach(@bannercode)
		{
			chop;
			$intline.="$j). $_<br>\n";
			$j++;
		}
		push(@result,"<form action=\"$cgi/adcadm.pl\" method=\"post\"><input type=\"hidden\" name=\"name\" value=\"$data{name}\"><input type=\"hidden\" name=\"password\" value=\"$data{password}\"><input type=\"hidden\" name=\"user\" value=\"$user\"><li><b>Username:</b> $user</li><font size=2>$intline</font><center><table border=0><tr><td></td><td><input type=\"image\" src=\"$adcenter/images/remban.gif\" name=\"txremban\"><input type=\"image\" src=\"$adcenter/images/accban.gif\" name=\"txaccban\"></td></tr></table></center></form>\n");
		$i++;
	}
}
if (!@result)
{
	push(@result,"<li>No ads</li>");
}
open (F,"<$adcpath/template/asbanovr.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub remove_txbanner
{
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@usrs=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@usrs)
{
	($ueml,$unm)=split("\t",$_);
	if ($unm eq $data{user})
	{
		open(F,"<$adcpath/mail/msg.hdr");
		flock(F,$LOCK_EX);
		@header=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open(F,"<$adcpath/mail/msg.btm");
		flock(F,$LOCK_EX);
		@bottom=<F>;
		flock(F,$LOCK_UN);
		close(F);
		if ($smtpserver)
		{
			$header=join("",@header);
			$bottom=join("",@bottom);
			&sendviasmtp("$email ($owntitle)",$ueml,"Your TextAds were declined. Account: $data{user}","$header\nYour TextAds were declined, try to change the text and upload your text ad again\n\n$bottom");
		}
		else
		{
		open (MAIL,"|$progmail");
		print MAIL "To: $ueml\n";
		print MAIL "From: $email ($owntitle)\n";
		print MAIL "Subject: Your TextAds were declined. Account: $data{user}\n\n";
		print MAIL @header;
		print MAIL "Your TextAds were declined, try to change the text and upload your text ad again\n\n";
		print MAIL @bottom;
		print MAIL "\n.\n";
		close (MAIL);
		}
		last;
	}
}
unlink ("$adcpath/queye/tx/$data{user}");
&txbanners;
}
sub accept_txbanner
{
open (F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@usrs=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@usrs)
{
	($ueml,$unm)=split("\t",$_);
	if ($unm eq $data{user})
	{
		open(F,"<$adcpath/mail/msg.hdr");
		flock(F,$LOCK_EX);
		@header=<F>;
		flock(F,$LOCK_UN);
		close(F);
		open(F,"<$adcpath/mail/msg.btm");
		flock(F,$LOCK_EX);
		@bottom=<F>;
		flock(F,$LOCK_UN);
		close(F);
		if ($smtpserver)
		{
			$header=join("",@header);
			$bottom=join("",@bottom);
			&sendviasmtp("$email ($owntitle)",$ueml,"Your TextAds were accepted. Account: $data{user}","$header\nYour TextAds were accepted\n\n$bottom");
		}
		else
		{
		open (MAIL,"|$progmail");
		print MAIL "To: $ueml\n";
		print MAIL "From: $email ($owntitle)\n";
		print MAIL "Subject: Your TextAds were accepted. Account: $data{user}\n\n";
		print MAIL @header;
		print MAIL "Your TextAds were accepted\n\n";
		print MAIL @bottom;
		print MAIL "\n.\n";
		close (MAIL);
		}
		last;
	}
}
open (F,"<$adcpath/queye/tx/$data{user}");
flock(F,$LOCK_EX);
@file=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,">>$adcpath/tx/$data{user}");
flock(F,$LOCK_EX);
print F @file;
flock(F,$LOCK_UN);
close (F);
unlink ("$adcpath/queye/tx/$data{user}");
&txbanners;
}
sub faq
{
$selected{faq}="selected";
$selectede{faq}="selected";
open(F,"<$adcpath/faq/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@categ)
{
	chop;
	($id,$cat)=split("\t",$_);
	$fcat.="<option value=\"$id\">$cat</option>\n";
}
open (F,"<$adcpath/template/afaqcat.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub add_cat_faq
{
open(F,"<$adcpath/faq/category.cnt");
flock(F,$LOCK_EX);
$id=<F>;
flock(F,$LOCK_UN);
close(F);
$id=$id+1;
open(F,">$adcpath/faq/category.cnt");
flock(F,$LOCK_EX);
print F $id;
flock(F,$LOCK_UN);
close(F);
open(F,">>$adcpath/faq/category.db");
flock(F,$LOCK_EX);
print F "$id\t$data{category}\n";
flock(F,$LOCK_UN);
close(F);
&faq;
}
sub rem_cat_faq
{
open(F,"+<$adcpath/faq/category.db");
flock(F,$LOCK_EX);
@categs=<F>;
foreach(@categs)
{
	($id,$cat)=split("\t",$_);
	next if ($id==$data{category});
	push(@ncategs,$_);
}
truncate(F,0);
seek(F,0,0);
print F @ncategs;
flock(F,$LOCK_UN);
close(F);
unlink("$adcpath/faq/$data{category}.db");
&faq;
}
sub edit_faq
{
$selected{faq}="selected";
open(F,"<$adcpath/faq/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
&faq unless (@categ);
$selectede{edit_faq}="selected";
foreach(@categ)
{
	chop;
	($id,$cat)=split("\t",$_);
	$fcat.="<option value=\"$id\">$cat</option>\n";
}
($data{category})=split("\t",$categ[0]) if (!$data{category});
open(F,"<$adcpath/faq/$data{category}.db");
flock(F,$LOCK_EX);
@records=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
foreach (@records)
{
	chop;
	($question,$answer)=split("\t",$_);
	$question=~s/\<br\>/\n/g;
	$answer=~s/\<br\>/\n/g;
	$result.=qq~<tr><td><form action="$cgi/adcadm.pl" method=post><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><input type=hidden name=id value=$i><input type=hidden name=category value=$data{category}><textarea name=question cols=45 rows=6>$question</textarea><br><textarea name=answer cols=45 rows=6>$answer</textarea><br><input type=image name="delete_faq" border=0 src="$adcenter/images/delete.gif"><input type=image name="update_faq" border=0 src="$adcenter/images/update.gif"></form></td></tr>\n~;
	$i++;
}
$result="<tr><td><font size=2>No entries in this category</font></td></tr>\n" if (!$result);
open (F,"<$adcpath/template/afaqedit.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub update_faq
{
open(F,"+<$adcpath/faq/$data{category}.db");
flock(F,$LOCK_EX);
@records=<F>;
$data{question}=~s/\r\n/\<br\>/g;
$data{answer}=~s/\r\n/\<br\>/g;
$records[$data{id}]="$data{question}\t$data{answer}\n";
truncate(F,0);
seek(F,0,0);
print F @records;
flock(F,$LOCK_UN);
close(F);
&edit_faq;
}
sub delete_faq
{
open(F,"+<$adcpath/faq/$data{category}.db");
flock(F,$LOCK_EX);
@records=<F>;
splice(@records,$data{id},1);
truncate(F,0);
seek(F,0,0);
print F @records;
flock(F,$LOCK_UN);
close(F);
&edit_faq;
}
sub new_faq
{
$selectede{new_faq}="selected";
$selected{faq}="selected";
open(F,"<$adcpath/faq/category.db");
flock(F,$LOCK_EX);
@categ=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@categ)
{
	chop;
	($id,$cat)=split("\t",$_);
	$fcat.="<option value=\"$id\">$cat</option>\n";
}
open(F,"<$basepath/adcenter.bup");
flock(F,$LOCK_EX);
@users=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@users)
{
	($eml,$usr)=split("\t",$_);
	$emls{$usr}=$eml;
}
open(F,"<$adcpath/faq/query.db");
flock(F,$LOCK_EX);
@records=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
foreach (@records)
{
	chop;
	($user,$question)=split("\t",$_);
	$question=~s/\<br\>/\n/g;
	$result.=qq~<tr><td><form action="$cgi/adcadm.pl" method=post><input type=hidden name=method value="answer_faq"><input type=hidden name=id value=$i><input type=hidden name=to value="$emls{$user}"><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><textarea name=question cols=62 rows=6>$question</textarea><font size=5><b>Q</b></font><br><textarea name=answer cols=62 rows=6></textarea><font size=5><b>A</b></font><br><center><input type=checkbox name=add value=1><font size=2> Add entry to FAQ category <select name=category>$fcat</select><br><input type=image border=0 src="$adcenter/images/proceed.gif"></center></form></td></tr>\n~;
	$i++;
}
$result="<tr><td align=center><font size=2>No new questions</font></td></tr>\n" if (!$result);
open (F,"<$adcpath/template/afaqnew.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub answer_faq
{
$data{question}=~s/\r//g;
$data{answer}=~s/\r//g;
open(F,"+<$adcpath/faq/query.db");
flock(F,$LOCK_EX);
@records=<F>;
splice(@records,$data{id},1);
truncate(F,0);
seek(F,0,0);
print F @records;
flock(F,$LOCK_UN);
close(F);
open(F,"<$adcpath/mail/faq.hdr");
flock(F,$LOCK_EX);
@header=<F>;
flock(F,$LOCK_UN);
close(F);
open(F,"<$adcpath/mail/faq.btm");
flock(F,$LOCK_EX);
@bottom=<F>;
flock(F,$LOCK_UN);
close(F);
if ($smtpserver)
{
	$header=join("",@header);
	$bottom=join("",@bottom);
	&sendviasmtp("$email ($owntitle)",$data{to},"Thank you for your request","$header\nQuestion: $data{question}\n\nAnswer: $data{answer}\n\n$bottom");
}
else
{
open (MAIL,"|$progmail");
print MAIL "To: $data{to}\n";
print MAIL "From: $email ($owntitle)\n";
print MAIL "Subject: Thank you for your request\n\n";
print MAIL @header;
print MAIL "Question: $data{question}\n\n";
print MAIL "Answer: $data{answer}\n\n";
print MAIL @bottom;
print MAIL "\n.\n";
close (MAIL);
}
if ($data{add} && $data{category})
{
$data{question}=~s/\n/\<br\>/g;
$data{answer}=~s/\n/\<br\>/g;
open(F,">>$adcpath/faq/$data{category}.db");
flock(F,$LOCK_EX);
print F "$data{question}\t$data{answer}\n";
flock(F,$LOCK_UN);
close(F);
}
&new_faq;
}
sub get_userstats
{
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@data=<F>;
flock(F,$LOCK_UN);
close(F);
@data=sort(@data);
$flg=0;
foreach(@data)
{
	chop;
	($user,$userurl,$group,$country,$oratio,$ref,$weight)=split("\t",$_);
	if ($data{type} eq "affiliate")
	{
		$affilx=-s "$basepath/$user/affilx";
		$affilc=-s "$basepath/$user/affilc";
		$affilx=0 if (!$affilx);
		$affilc=0 if (!$affilc);
		if ($flg){push(@result,"<tr><td><font size=2><b>$user</b></font></td><td><font size=2>$affilx</font></td><td><font size=2>$affilc</font></td></tr>\n");}
		else {push(@result,"<tr><td bgcolor=\"#82c7db\"><font size=2><b>$user</b></font></td><td bgcolor=\"#82c7db\"><font size=2>$affilx</font></td><td bgcolor=\"#82c7db\"><font size=2>$affilc</font></td></tr>\n");}
	}
	elsif ($data{type} eq "bx")
	{
		$i=0;
		$genimp=0;
		$genclc=0;
		while($i<$totalbanner)
		{
			open (STAT,"<$basepath/$user/impressions$i");
			flock(STAT,$LOCK_EX);
			while($line=<STAT>)
			{
				chop($line);
				($tkey,$tval)=split("\t",$line);
				@temp=split("#",$tval);
				foreach(@temp){$genimp+=$_;}
			}
			flock(STAT,$LOCK_UN);
			close (STAT);
			open (STAT,"<$basepath/$user/clicks$i");
			flock(STAT,$LOCK_EX);
			while($line=<STAT>)
			{
				chop($line);
				($tkey,$tval)=split("\t",$line);
				@temp=split("#",$tval);
				foreach(@temp){$genclc+=$_;}
			}
			flock(STAT,$LOCK_UN);
			close (STAT);
			$i++;
		}
		if ($flg){push(@result,"<tr><td><font size=2><b>$user</b></font></td><td><font size=2>$genimp</font></td><td><font size=2>$genclc</font></td></tr>\n");}
		else {push(@result,"<tr><td bgcolor=\"#82c7db\"><font size=2><b>$user</b></font></td><td bgcolor=\"#82c7db\"><font size=2>$genimp</font></td><td bgcolor=\"#82c7db\"><font size=2>$genclc</font></td></tr>\n");}
	}
	elsif ($data{type} eq "sbx")
	{
		$genimp=0;
		$genclc=0;
		open (STAT,"<$basepath/$user/impressions.sb");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$genimp+=$_;}
		}
		flock(STAT,$LOCK_UN);
		close (STAT);
		open (STAT,"<$basepath/$user/clicks.sb");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$genclc+=$_;}
		}
		flock(STAT,$LOCK_UN);
		close (STAT);
		if ($flg){push(@result,"<tr><td><font size=2><b>$user</b></font></td><td><font size=2>$genimp</font></td><td><font size=2>$genclc</font></td></tr>\n");}
		else {push(@result,"<tr><td bgcolor=\"#82c7db\"><font size=2><b>$user</b></font></td><td bgcolor=\"#82c7db\"><font size=2>$genimp</font></td><td bgcolor=\"#82c7db\"><font size=2>$genclc</font></td></tr>\n");}
	}
	elsif ($data{type} eq "tx")
	{
		$genimp=0;
		$genclc=0;
		open (STAT,"<$basepath/$user/impressions.tx");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$genimp+=$_;}
		}
		flock(STAT,$LOCK_UN);
		close (STAT);
		open (STAT,"<$basepath/$user/clicks.tx");
		flock(STAT,$LOCK_EX);
		while($line=<STAT>)
		{
			chop($line);
			($tkey,$tval)=split("\t",$line);
			@temp=split("#",$tval);
			foreach(@temp){$genclc+=$_;}
		}
		flock(STAT,$LOCK_UN);
		close (STAT);
		if ($flg){push(@result,"<tr><td><font size=2><b>$user</b></font></td><td><font size=2>$genimp</font></td><td><font size=2>$genclc</font></td></tr>\n");}
		else {push(@result,"<tr><td bgcolor=\"#82c7db\"><font size=2><b>$user</b></font></td><td bgcolor=\"#82c7db\"><font size=2>$genimp</font></td><td bgcolor=\"#82c7db\"><font size=2>$genclc</font></td></tr>\n");}
	}
	if ($flg){$flg=0;} else {$flg=1;}
}
push(@result,"<tr><td colspan=3 align=center><font size=2>Empty database</font></td></tr>\n") unless (@result);
open (F,"<$adcpath/template/ausersts.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub reset_userstats
{
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
open (F,"<$basepath/adcenter.db");
flock(F,$LOCK_EX);
@data=<F>;
flock(F,$LOCK_UN);
close(F);
@data=sort(@data);
$flg=0;
foreach(@data)
{
	chop;
	($user,$userurl,$group,$country,$oratio,$ref,$weight)=split("\t",$_);
	if ($data{type} eq "affiliate")
	{
		open (F,">$basepath/$user/affilx");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$basepath/$user/affilc");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$basepath/$user/adate");
		flock(F,$LOCK_EX);
		print F "$month $date $year";
		flock(F,$LOCK_UN);
		close(F);
	}
	elsif ($data{type} eq "bx")
	{
		$i=0;
		while($i<$totalbanner)
		{
			open (F,">$basepath/$user/impressions$i");
			flock(F,$LOCK_EX);
			flock(F,$LOCK_UN);
			close(F);
			open (F,">$basepath/$user/clicks$i");
			flock(F,$LOCK_EX);
			flock(F,$LOCK_UN);
			close(F);
			open (F,">$basepath/$user/reset$i");
			flock(F,$LOCK_EX);
			print F "$month $date $year";
			flock(F,$LOCK_UN);
			close(F);
			$i++;
		}
	}
	elsif ($data{type} eq "sbx")
	{
		open (F,">$basepath/$user/impressions.sb");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$basepath/$user/clicks.sb");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$basepath/$user/reset.sb");
		flock(F,$LOCK_EX);
		print F "$month $date $year";
		flock(F,$LOCK_UN);
		close(F);
	}
	elsif ($data{type} eq "tx")
	{
		open (F,">$basepath/$user/impressions.tx");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$basepath/$user/clicks.tx");
		flock(F,$LOCK_EX);
		flock(F,$LOCK_UN);
		close(F);
		open (F,">$basepath/$user/reset.tx");
		flock(F,$LOCK_EX);
		print F "$month $date $year";
		flock(F,$LOCK_UN);
		close(F);
	}
}
&get_userstats;
}
sub a_maillist
{
srand;
$num=rand();
open (F,"<$basepath/maillist.db");
flock(F,$LOCK_EX);
@emails=<F>;
flock(F,$LOCK_UN);
close (F);
$count=@emails;
&maillist if (!$count || !$data{subject} || !$data{body});
open (FM,">$basepath/temp.msg");
flock(FM,$LOCK_EX);
binmode FM;
print FM "$data{subject}\r\n";
print FM $data{body};
flock(FM,$LOCK_UN);
close (FM);
open (F,"<$adcpath/template/asendmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub get_maillist
{
$start=$data{start};
@data=();
open (F,"<$basepath/maillist.db");
flock(F,$LOCK_EX);
@data=<F>;
flock(F,$LOCK_UN);
close(F);
push (@footer,"<table width=\"100%\" border=0><tr>");
$icount=scalar(@data);
if (scalar (@data)>$reclimit)
{
	if ($start>0)
	{
		$pstart=$start-1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=$data{method}&start=$pstart\"><img src=\"$adcenter/images/prev.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
	push(@footer,"<td width=\"70%\" align=\"center\"><font size=1><b>$icount MEMBERS IN DATABASE</b></font></td>");
	if ($start*$reclimit+$reclimit<scalar(@data))
	{
		$nstart=$start+1;
		push(@footer,"<td width=\"15%\" align=\"center\"><a href=\"$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=$data{method}&start=$nstart\"><img src=\"$adcenter/images/next.gif\" border=0></a></td>");
	}
	else {push(@footer,"<td width=\"15%\" align=\"center\"></td>");}
}
else {push(@footer,"<td width=\"100%\" align=\"center\"><font size=1><b>$icount MEMBERS IN DATABASE</b></font></td>");}
push (@footer,"</tr></table>");
@data=sort(@data);
if ($start*$reclimit+$reclimit>scalar(@data))
{
	$i=$start*$reclimit;
	while($i<scalar(@data))
	{
		chop($data[$i]);
		push(@result,"<li><font size=\"2\">$data[$i]</font></li>\n");
		$i++;
	}
}
else
{
	$i=$start*$reclimit;
	$last=$i+$reclimit;
	while($i<$last)
	{
		chop($data[$i]);
		push(@result,"<li><font size=\"2\">$data[$i]</font></li>\n");
		$i++;
	}
}
if (!@result)
{
	push(@result,"<li>Empty maillist</li>");
}
open (F,"<$adcpath/template/amluslst.tpl");
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
print "Location: $cgi/adcindex.pl?lang=$defaultlanguage\n\n";
exit;
}