package ADCml;
require Exporter;
@ISA = qw( Exporter );
@EXPORT = qw(
		sendml
		manml
		addemail
		removeemail
		chmhead
		chmfoot
		edmtemp
		edptemp
		chperr
		chpsub
		chpunsub
		Preview
		htmlmail
		maillist
		viewemail
		cherrmes
	    );
open (F, "<adc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

sub sendml
{
%data=@_;
$selectede{sendml}="selected";
open (F, "<$basepath/global.db");
flock(F,$LOCK_EX);
@dta=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@dta)
{
	chop;
	($fa,$sa,$ta,$foa,$fia,$sia,$eia,$sea)=split("\t",$_);
	last if ($data{name} eq $fa);
}
open (F, "<$basepath/$data{name}/maillist");
flock(F,$LOCK_EX);
@emails=<F>;
flock(F,$LOCK_UN);
close(F);
$total=scalar(@emails);
open (F,"<$adcpath/template/$data{lang}/msendmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub manml
{
%data=@_;
$selectede{manml}="selected";
if (-e "$basepath/$data{name}/tflag")
{
$trustedform1=qq~<form method="post" action="$cgi/adcuplml.pl" enctype="multipart/form-data"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="name" value="$data{name}">~;
$trustedform2=qq~</form>~;
}
open (F,"<$adcpath/template/$data{lang}/mmanmmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub viewemail
{
%data=@_;
open(F,"<$basepath/$data{name}/maillist");
flock(F,$LOCK_EX);
@emails=<F>;
flock(F,$LOCK_UN);
close(F);
@emails=sort (@emails);
$i=0;
while($i<@emails)
{
	chop($emails[$i]);
	$emails.="<tr><td bgcolor=\"#82C7DB\"><font size=2>$emails[$i]</font></td></tr>\n";
	$i++;
	if($i<@emails)
        {
		chop($emails[$i]);
		$emails.="<tr><td><font size=2>$emails[$i]</font></td></tr>\n";
		$i++;
	}
}
open (F,"<$adcpath/template/$data{lang}/mviewmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub addemail
{
%data=@_;
$data{maddr}=~s/ //g;
@maddr=split(",",$data{maddr});
foreach (@maddr)
{
$data{maddr}=$_;
@nemails=();
$flag=0;
open(F,"+<$basepath/$data{name}/maillist");
flock(F,$LOCK_EX);
@emails=<F>;
truncate(F,0);
seek(F,0,0);
foreach(@emails)
{
	chop;
	$flag=1 if ($data{maddr} eq $_);
	push (@nemails,"$_\n");
}
push(@nemails,"$data{maddr}\n") if (!$flag);
print F @nemails;
flock(F,$LOCK_UN);
close(F);
}
&manml;
}
sub removeemail
{
%data=@_;
$data{maddr}=~s/ //g;
@maddr=split(",",$data{maddr});
foreach (@maddr)
{
$data{maddr}=$_;
@nemails=();
open(F,"+<$basepath/$data{name}/maillist");
flock(F,$LOCK_EX);
@emails=<F>;
truncate(F,0);
seek(F,0,0);
foreach(@emails)
{
	chop;
	next if ($data{maddr} eq $_);
	push (@nemails,"$_\n");
}
print F @nemails;
flock(F,$LOCK_UN);
close(F);
}
&manml;
}
sub chmhead
{
%data=@_;
$data{header}=~s/\r\n/\n/g;
open (F, ">$basepath/$data{name}/header.msg");
flock(F,$LOCK_EX);
print F $data{header};
flock(F,$LOCK_UN);
close (F);
&edmtemp;
}
sub chmfoot
{
%data=@_;
$data{footer}=~s/\r\n/\n/g;
open (F, ">$basepath/$data{name}/footer.msg");
flock(F,$LOCK_EX);
print F $data{footer};
flock(F,$LOCK_UN);
close (F);
&edmtemp;
}
sub edmtemp
{
%data=@_;
$selectede{edmtemp}="selected";
open (F, "<$basepath/$data{name}/header.msg");
flock(F,$LOCK_EX);
@header=<F>;
flock(F,$LOCK_UN);
close (F);
open (F, "<$basepath/$data{name}/footer.msg");
flock(F,$LOCK_EX);
@footer=<F>;
flock(F,$LOCK_UN);
close (F);
$header=join("",@header);
$footer=join("",@footer);
open (F,"<$adcpath/template/$data{lang}/medmtmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub edptemp
{
%data=@_;
$selectede{edptemp}="selected";
open (F,"<$basepath/$data{name}/maillist.msg");
@messages=<F>;
close (F);
foreach(@messages){eval $_;}
open (F, "<$basepath/$data{name}/mesbmls.tpl");
flock(F,$LOCK_EX);
@error=<F>;
flock(F,$LOCK_UN);
close (F);
open (F, "<$basepath/$data{name}/msubmls.tpl");
flock(F,$LOCK_EX);
@subscribe=<F>;
flock(F,$LOCK_UN);
close (F);
open (F, "<$basepath/$data{name}/munsmls.tpl");
flock(F,$LOCK_EX);
@unsubscribe=<F>;
flock(F,$LOCK_UN);
close (F);
$error=join("",@error);
$subscribe=join("",@subscribe);
$unsubscribe=join("",@unsubscribe);
open (F,"<$adcpath/template/$data{lang}/medptmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub chperr
{
%data=@_;
$data{page}=~s/\r\n/\n/g;
$data{page}=~s/\~//g;
open (F, ">$basepath/$data{name}/mesbmls.tpl");
flock(F,$LOCK_EX);
print F $data{page};
flock(F,$LOCK_UN);
close (F);
open (F,"<$adcpath/template/$data{lang}/mchpemls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub cherrmes
{
%data=@_;
$data{err1}=~s/\~//g;
$data{err2}=~s/\~//g;
$data{err3}=~s/\~//g;
$data{err1}=~s/\"/\\\"/g;
$data{err2}=~s/\"/\\\"/g;
$data{err3}=~s/\"/\\\"/g;
open (F, ">$basepath/$data{name}/maillist.msg");
flock(F,$LOCK_EX);
print F qq~\$errneml="$data{err1}";
\$errex="$data{err2}";
\$errnex="$data{err3}";
~;
flock(F,$LOCK_UN);
close (F);
&edptemp;
}
sub chpsub
{
%data=@_;
$data{page}=~s/\r\n/\n/g;
$data{page}=~s/\~//g;
open (F, ">$basepath/$data{name}/msubmls.tpl");
flock(F,$LOCK_EX);
print F $data{page};
flock(F,$LOCK_UN);
close (F);
open (F,"<$adcpath/template/$data{lang}/mchpemls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub chpunsub
{
%data=@_;
$data{page}=~s/\r\n/\n/g;
$data{page}=~s/\~//g;
open (F, ">$basepath/$data{name}/munsmls.tpl");
flock(F,$LOCK_EX);
print F $data{page};
flock(F,$LOCK_UN);
close (F);
open (F,"<$adcpath/template/$data{lang}/mchpemls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub Preview
{
%data=@_;
$data{page}=~s/\r\n/\n/g;
$data{page}=~s/~//g;
@errors=();
$data{page}="print qq~$data{page}~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $data{page};
exit;
}
sub htmlmail
{
%data=@_;
$selectede{htmlmail}="selected";
open (F,"<$adcpath/template/$data{lang}/mhtmlmls.tpl");
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
%data=@_;
srand;
$selectede{sendml}="selected";
$num=rand();
open (F, "<$basepath/$data{name}/maillist");
flock(F,$LOCK_EX);
@emails=<F>;
flock(F,$LOCK_UN);
close(F);
close (F);
$count=@emails;
&sendml if (!$count || !$data{subject} || !$data{body});
open (FM,">$basepath/$data{name}/temp.msg");
flock(FM,$LOCK_EX);
binmode FM;
print FM "$data{subject}\r\n";
print FM $data{body};
flock(FM,$LOCK_UN);
close (FM);
open (F,"<$adcpath/template/$data{lang}/mmailmls.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
1;
