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
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
$pdate="$month $date $year";
@data=split("; ",$ENV{HTTP_COOKIE});
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex ($1))/eg;
		$cookie{$field}=$value;
	}
}
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

#p0ST dATA
open (F,">>$basepath/adcenter.pwd");
flock(F,$LOCK_EX);
print F crypt($data{Username},$data{Username}).":".crypt($data{Password},$data{Password})."\n";
flock(F,$LOCK_UN);
close (F);
if (-e "$basepath/maillist.db")
{
open (F,"+<$basepath/maillist.db");
flock(F,$LOCK_EX);
@maillist=<F>;
foreach(@maillist)
{
	$test=$_;
	chop($test);
	if ($test eq $data{EMail}){$eflag=1;last;}
}
push(@maillist,"$data{EMail}\n") unless ($eflag);
truncate(F,0);
seek(F,0,0);
print F @maillist;
flock(F,$LOCK_UN);
close (F);
}
else
{
open (F,">$basepath/maillist.db");
flock(F,$LOCK_EX);
print F "$data{EMail}\n";
flock(F,$LOCK_UN);
close (F);
}
open (F,">>$basepath/adcenter.db");
flock(F,$LOCK_EX);
print F "$data{Username}\t$data{URL}\t$data{Category}\t$data{Country}\t$defaultratio\t$cookie{adcenterreferal}\t1\n";
flock(F,$LOCK_UN);
close (F);
$data{show}=0 if (!$data{show});
open (F,">>$basepath/global.db");
flock(F,$LOCK_EX);
print F "$data{Username}\t$data{Name}\t$data{Address}\t$data{City}\t$data{ZipCode}\t$data{Country}\t$data{Phone}\t$data{EMail}\t$data{show}\n";
flock(F,$LOCK_UN);
close (F);
$data{Keywords}=~s/ //g;
open (F,">>$basepath/adcenter.srh");
flock(F,$LOCK_EX);
print F "$data{Username}\t$data{URL}\t$data{Category}\t$data{Sitetitle}\t$data{Description}\t$data{Keywords}\n";
flock(F,$LOCK_UN);
close (F);
open (F,">>$basepath/adcenter.bup");
flock(F,$LOCK_EX);
print F "$data{EMail}\t$data{Username}\t$data{Password}\n";
flock(F,$LOCK_UN);
close (F);
mkdir "$basepath/$data{Username}",0777;
chmod 0777,"$basepath/$data{Username}/";
open (F,">$basepath/$data{Username}/counter");
print F "0";
close (F);
open (F,">>$basepath/credits.db");
flock(F,$LOCK_EX);
print F "$data{Username}\t$startcred 0\n";
flock(F,$LOCK_UN);
close (F);
open (F,">>$basepath/credits.tx");
flock(F,$LOCK_EX);
print F "$data{Username}\t$startcredtx 0\n";
flock(F,$LOCK_UN);
close (F);
open (F,">>$basepath/credits.sb");
flock(F,$LOCK_EX);
print F "$data{Username}\t$startcredsb 0\n";
flock(F,$LOCK_UN);
close (F);
open (F,">$basepath/$data{Username}/join");
print F "$pdate";
close (F);
open (F,">$basepath/$data{Username}/lastact");
print F "$pdate";
close (F);
$i=0;
while($i<$totalbanner)
{
	open (F,">$basepath/$data{Username}/impressions$i");
	close (F);
	open (F,">$basepath/$data{Username}/clicks$i");
	close (F);
	open (F,">$basepath/$data{Username}/banner$i");
	print F "not uploaded";
	close (F);
	open (F,">$basepath/$data{Username}/reset$i");
	print F "$pdate";
	close (F);
	open (F,">$basepath/$data{Username}/timeman$i");
	print F "0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n0\t1000\n";
	close (F);
	$i++;
}
open (F,">$basepath/$data{Username}/header.msg");
print F "$data{Name} Maillist\n----------------------------------------\n";
close (F);
open (F,">$basepath/$data{Username}/footer.msg");
print F "----------------------------------------\nYour message footer\n";
close (F);
open (F,">$basepath/$data{Username}/tx.dat");
print F "FFFFFF\t000000\t400\t1";
close (F);
open (F,">$basepath/$data{Username}/affiliate");
close (F);
open (F,">$basepath/$data{Username}/clicks.tx");
close (F);
open (F,">$basepath/$data{Username}/clicks.sb");
close (F);
open (F,">$basepath/$data{Username}/impressions.tx");
close (F);
open (F,">$basepath/$data{Username}/impressions.sb");
close (F);
open (F,">$basepath/$data{Username}/referal");
close (F);
open (F,">$basepath/$data{Username}/counter.cmn");
close (F);
open (F,">$basepath/$data{Username}/counter.unq");
close (F);
open (F,">$basepath/$data{Username}/maillist.msg");
print F qq~\$errneml="Incorrect <b>e-mail</b>, you must put your e-mail address<br>";
\$errex="Your <b>e-mail</b> is already exist in our maillist<br>";
\$errnex="Your <b>e-mail</b> is not exist in our maillist<br>";
~;
close (F);
open (F,">$basepath/$data{Username}/maillist");
close (F);
open (F,"<$adcpath/template/$data{lang}/mesbmls.tpl");
@page=<F>;
close (F);
open (F,">$basepath/$data{Username}/mesbmls.tpl");
print F @page;
close (F);
open (F,"<$adcpath/template/$data{lang}/msubmls.tpl");
@page=<F>;
close (F);
open (F,">$basepath/$data{Username}/msubmls.tpl");
print F @page;
close (F);
open (F,"<$adcpath/template/$data{lang}/munsmls.tpl");
@page=<F>;
close (F);
open (F,">$basepath/$data{Username}/munsmls.tpl");
print F @page;
close (F);
open (F,">$basepath/$data{Username}/counter.ext");
print F qq~to\t0
ac\t0
ad\t0
ae\t0
af\t0
ag\t0
ai\t0
al\t0
am\t0
an\t0
ao\t0
aq\t0
ar\t0
as\t0
at\t0
au\t0
aw\t0
az\t0
ba\t0
bb\t0
bd\t0
be\t0
bf\t0
bg\t0
bh\t0
bi\t0
bj\t0
bm\t0
bn\t0
bo\t0
br\t0
bs\t0
bt\t0
bv\t0
bw\t0
by\t0
bz\t0
ca\t0
cc\t0
cd\t0
cf\t0
cg\t0
ch\t0
ci\t0
ck\t0
cl\t0
cm\t0
cn\t0
co\t0
cr\t0
cu\t0
cv\t0
cx\t0
cy\t0
cz\t0
de\t0
dj\t0
dk\t0
dm\t0
do\t0
dz\t0
ec\t0
ee\t0
eg\t0
eh\t0
er\t0
es\t0
et\t0
fi\t0
fj\t0
fk\t0
fm\t0
fo\t0
fr\t0
fx\t0
ga\t0
gb\t0
gd\t0
ge\t0
gf\t0
gg\t0
gh\t0
gi\t0
gl\t0
gm\t0
gn\t0
gp\t0
gq\t0
gr\t0
gs\t0
gt\t0
gu\t0
gw\t0
gy\t0
hk\t0
hm\t0
hn\t0
hr\t0
ht\t0
hu\t0
id\t0
ie\t0
il\t0
im\t0
in\t0
io\t0
iq\t0
ir\t0
is\t0
it\t0
je\t0
jm\t0
jo\t0
jp\t0
ke\t0
kg\t0
kh\t0
ki\t0
km\t0
kn\t0
kr\t0
kw\t0
ky\t0
kz\t0
la\t0
lb\t0
lc\t0
li\t0
lk\t0
lr\t0
ls\t0
lt\t0
lu\t0
lv\t0
ly\t0
ma\t0
mc\t0
md\t0
mg\t0
mh\t0
mk\t0
ml\t0
mm\t0
mn\t0
mo\t0
mp\t0
mq\t0
mr\t0
ms\t0
mt\t0
mu\t0
mv\t0
mw\t0
mx\t0
my\t0
mz\t0
na\t0
nc\t0
ne\t0
nf\t0
ng\t0
ni\t0
nl\t0
no\t0
np\t0
nr\t0
nt\t0
nu\t0
nz\t0
om\t0
pa\t0
pe\t0
pf\t0
pg\t0
ph\t0
pk\t0
pl\t0
pm\t0
pn\t0
pr\t0
pt\t0
pw\t0
py\t0
qa\t0
re\t0
ro\t0
ru\t0
rw\t0
sa\t0
sb\t0
sc\t0
sd\t0
se\t0
sg\t0
sh\t0
si\t0
sj\t0
sk\t0
sl\t0
sm\t0
sn\t0
so\t0
sr\t0
st\t0
su\t0
sv\t0
sy\t0
sz\t0
tc\t0
td\t0
tf\t0
tg\t0
th\t0
tj\t0
tk\t0
tm\t0
tn\t0
tp\t0
tr\t0
tt\t0
tv\t0
tw\t0
tz\t0
ua\t0
ug\t0
uk\t0
um\t0
us\t0
uy\t0
uz\t0
va\t0
vc\t0
ve\t0
vg\t0
vi\t0
vn\t0
vu\t0
ws\t0
ye\t0
yt\t0
yu\t0
za\t0
zm\t0
zr\t0
zw\t0
dother\t0
IE\t0
netscape\t0
bother\t0
r640\t0
r800\t0
r1024\t0
rother\t0
~;
close(F);
open (F,"<$basepath/category.db");
flock(F,$LOCK_EX);
@categs=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@categs)
{
	chop;
	($id)=split("\t",$_);
	$categs.="$id#";
}
open (F,"<$basepath/country.db");
flock(F,$LOCK_EX);
@categs=<F>;
flock(F,$LOCK_UN);
close (F);
foreach(@categs)
{
	chop;
	($id)=split("\t",$_);
	$countrs.="$id#";
}
open (F,">$basepath/$data{Username}/target");
flock(F,$LOCK_EX);
print F "\n\n$categs\n";
flock(F,$LOCK_UN);
close(F);
open (F,">>$basepath/target.db");
flock(F,$LOCK_EX);
print F "$data{Username}\t$categs#BETWEENTRG#$countrs\n";
flock(F,$LOCK_UN);
close(F);
#sEND e-MAiL
open(F,"<$adcpath/mail/admin.hdr");
@header=<F>;
close(F);
open(F,"<$adcpath/mail/admin.btm");
@bottom=<F>;
close(F);
if ($smtpserver)
{
	$header=join("",@header);
	$bottom=join("",@bottom);
	&sendviasmtp("$data{EMail} ($data{Name})",$email,"New User Information","$header\nName: $data{Name}\nAddress: $data{Address}\nCity: $data{City}\nZip code: $data{ZipCode}\nCountry: $data{Country}\nPhone number: $data{Phone}\nE-mail: $data{EMail}\nURL: $data{URL}\nCategory: $data{Category}\n---------------------------------------------------------------------------\nUsername: $data{Username}\nPassword: $data{Password}\n\n$bottom");
}
else
{
open (MAIL,"|$progmail");
print MAIL "To: $email\n";
print MAIL "From: $data{EMail} ($data{Name})\n";
print MAIL "Subject: New User Information\n\n";
$ltime=scalar gmtime(time+$gmtzone*3600); 
print MAIL @header;
print MAIL "Name: $data{Name}\n";
print MAIL "Address: $data{Address}\n";
print MAIL "City: $data{City}\n";
print MAIL "Zip code: $data{ZipCode}\n";
print MAIL "Country: $data{Country}\n";
print MAIL "Phone number: $data{Phone}\n";
print MAIL "E-mail: $data{EMail}\n";
print MAIL "URL: $data{URL}\n";
print MAIL "Category: $data{Category}\n";
print MAIL "-" x 75 . "\n";
print MAIL "Username: $data{Username}\n";
print MAIL "Password: $data{Password}\n";
print MAIL @bottom;
print MAIL "\n.\n";
close (MAIL);
}

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
	&sendviasmtp("$email ($owntitle)",$data{EMail},"$rep[22]","$header\n$rep[19]\n\n$adcenter\n$rep[20] $data{Username}\n$rep[21] $data{Password}\n\n$bottom");
}
else
{
open (MAIL,"|$progmail");
print MAIL "To: $data{EMail}\n";
print MAIL "From: $email ($owntitle)\n";
print MAIL "Subject: $rep[22]\n\n";
$ltime=scalar gmtime(time+$gmtzone*3600); 
print MAIL @header;
print MAIL "$rep[19]\n\n";
print MAIL "\n$adcenter\n";
print MAIL "$rep[20] $data{Username}\n";
print MAIL "$rep[21] $data{Password}\n";
print MAIL @bottom;
print MAIL "\n.\n";
close (MAIL);
}
#pRiNT sUCCESS
open (F,"<$adcpath/template/$data{lang}/success.tpl");
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
sub sendviasmtp
{
($from,$to,$subject,$message)=@_;
$message=~s/\n/\r\n/g;
$localhost=(gethostbyname('localhost'))[0] || 'localhost';
socket(S,PF_INET,SOCK_STREAM,(getprotobyname('tcp'))[2]) || return;
$farg=sockaddr_in($smtpport,inet_aton($smtpserver)) || return;
connect(S,$farg) || return("err$!");
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
