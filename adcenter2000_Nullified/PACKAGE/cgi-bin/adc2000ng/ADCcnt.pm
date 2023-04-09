package ADCcnt;
require Exporter;
@ISA = qw( Exporter );
@EXPORT = qw(
		visitors
		htmlcounter
		clearcounter
		dailycount
		dailyucount
		montlycount
		montlyucount
		hourlycount
		hourlyucount
		presetcounter
	    );
open (F, "<adc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

sub visitors
{
%data=@_;
$selectede{visitors}="selected";
open (F,"<$basepath/$data{name}/counter.prt");
flock(F,$LOCK_EX);
$tpreset=<F>;
flock(F,$LOCK_UN);
close(F);
open (F,"<$basepath/$data{name}/counter.pru");
flock(F,$LOCK_EX);
$upreset=<F>;
flock(F,$LOCK_UN);
close(F);
$tpreset="0" unless($tpreset);
$upreset="0" unless($upreset);
open (STAT,"<$basepath/$data{name}/counter.cmn");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	@temp=split("#",$tval);
	foreach(@temp){$globcnt+=$_;}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (STAT,"<$basepath/$data{name}/counter.unq");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	@temp=split("#",$tval);
	foreach(@temp){$unqcnt+=$_;}
}
flock(STAT,$LOCK_UN);
close (STAT);
$globcnt=0 if (!$globcnt);
$unqcnt=0 if (!$unqcnt);
open (F,"<$basepath/$data{name}/counter.ext");
flock(F,$LOCK_EX);
@external=<F>;
flock(F,$LOCK_UN);
close(F);
foreach(@external)
{
	chop;
	($id,$cnt)=split("\t",$_);
	$ext{$id}=$cnt;
}
foreach $key(keys %ext)
{
	$ext{$key}=0 if (!$ext{$key});
}
if ($unqcnt>0){$popularity=int(($globcnt-$unqcnt)/$unqcnt);}
else {$popularity=0;}
open(F,"<$basepath/domains.ndb");
flock(F,$LOCK_EX);
@domains=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
while($i<@domains)
{
	chop($domains[$i]);
	($dmn,$country)=split("\t",$domains[$i]);
	if ($ext{$dmn})
	{
	$result.=qq~<tr><td width="40%" $backgrnd valign="top"><font size=2><b>$country</b></font></td><td width="60%" $backgrnd align="right"><font size=2>$ext{$dmn}</font></td></tr>\n~;
	if ($backgrnd){$backgrnd="";}
	else {$backgrnd="bgcolor=\"#82C7DB\"";}
	}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mstatcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub dailycount
{
%data=@_;
$selectede{dailycount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{month})
{
($day,$data{month},$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$data{month};
$selected{$mns}="selected";
open (STAT,"<$basepath/$data{name}/counter.cmn");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	foreach(@temp){$mimp[$fas]+=$_;$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
$month=$data{month};
$calendar{$month}=29 if ($year/4-int($year/4)==0 && $month eq "Feb");
$tablewidth=12*$calendar{$month}-2;
$table=$tablewidth+60;
$i=1;
while($i<$calendar{$month}+1)
{
	$mimp[$i]=0 if ($mimp[$i] eq "");
	push(@mstats,"<tr><td bgcolor=\"#82C7DB\"><font size=2><b>$i</b></font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2>$mimp[$i]</font></td></tr>\n");
	$i++;
	if($i<$calendar{$month}+1)
	{
		$mimp[$i]=0 if ($mimp[$i] eq "");
		push(@mstats,"<tr><td><font size=2><b>$i</b></font></td><td align=\"right\"><font size=2>$mimp[$i]</font></td></tr>\n");
		$i++;
	}
}
$totclc=0 if (!$totclc);
$totimp=0 if (!$totimp);
@mmimp=@mimp;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=1;
while($i<$calendar{$month}+1)
{
	$height=int($mimp[$i]/$grat);
	$result.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<$calendar{$month}){$result.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mdastcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub dailyucount
{
%data=@_;
$selectede{dailyucount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{month})
{
($day,$data{month},$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$data{month};
$selected{$mns}="selected";
open (STAT,"<$basepath/$data{name}/counter.unq");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	foreach(@temp){$mimp[$fas]+=$_;$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
$month=$data{month};
$calendar{$month}=29 if ($year/4-int($year/4)==0 && $month eq "Feb");
$tablewidth=12*$calendar{$month}-2;
$table=$tablewidth+60;
$i=1;
while($i<$calendar{$month}+1)
{
	$mimp[$i]=0 if ($mimp[$i] eq "");
	push(@mstats,"<tr><td bgcolor=\"#82C7DB\"><font size=2><b>$i</b></font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2>$mimp[$i]</font></td></tr>\n");
	$i++;
	if($i<$calendar{$month}+1)
	{
		$mimp[$i]=0 if ($mimp[$i] eq "");
		push(@mstats,"<tr><td><font size=2><b>$i</b></font></td><td align=\"right\"><font size=2>$mimp[$i]</font></td></tr>\n");
		$i++;
	}
}
$totclc=0 if (!$totclc);
$totimp=0 if (!$totimp);
@mmimp=@mimp;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=1;
while($i<$calendar{$month}+1)
{
	$height=int($mimp[$i]/$grat);
	$result.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<$calendar{$month}){$result.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mdustcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub montlycount
{
%data=@_;
$selectede{montlycount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{year})
{
($day,$month,$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
open (STAT,"<$basepath/$data{name}/counter.cmn");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	$temp=$cal{$fae};
	foreach(@temp){$mimp[$temp]+=$_;$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);
$tablewidth=12*12-2;
$table=$tablewidth+60;
foreach(@cal)
{
	$temp=$cal{$_};
	$mimp[$temp]=0 if ($mimp[$temp] eq "");
}
$totimp=0 if (!$totimp);
@mmimp=@mimp;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=1;
while($i<13)
{
	$height=int($mimp[$i]/$grat);
	$result.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<12){$result.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mmnstcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub montlyucount
{
%data=@_;
$selectede{montlyucount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{year})
{
($day,$month,$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
open (STAT,"<$basepath/$data{name}/counter.unq");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	$temp=$cal{$fae};
	foreach(@temp){$mimp[$temp]+=$_;$totimp+=$_;}
	}
}
$tablewidth=12*12-2;
$table=$tablewidth+60;
foreach(@cal)
{
	$temp=$cal{$_};
	$mimp[$temp]=0 if ($mimp[$temp] eq "");
}
$totimp=0 if (!$totimp);
@mmimp=@mimp;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=1;
while($i<13)
{
	$height=int($mimp[$i]/$grat);
	$result.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<12){$result.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mmustcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub hourlycount
{
%data=@_;
$selectede{hourlycount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{date})
{
($day,$data{month},$data{date},$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$data{month};
$selected{$mns}="selected";
#$data{date}="0$data{date}" if (length($data{date})==1);
open (STAT,"<$basepath/$data{name}/counter.cmn");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{date} / && $tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	@dimp=split("#",$tval);
	foreach(@dimp){$_=0 if (!$_);$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
$totimp=0 if (!$totimp);
$inx=0;
while ($inx<24){$dimp[$inx]=0 if (!$dimp[$inx]);$inx++;}
@mdimp=@dimp;
@mdimp=sort ({$b<=>$a} @mdimp);
$maximp=shift(@mdimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=0;
foreach(@dimp)
{
	$height=int($_/$grat);
	$result.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<23){$result.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mhostcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub hourlyucount
{
%data=@_;
$selectede{hourlyucount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{date})
{
($day,$data{month},$data{date},$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$data{month};
$selected{$mns}="selected";
#$data{date}="0$data{date}" if (length($data{date})==1);
open (STAT,"<$basepath/$data{name}/counter.unq");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{date} / && $tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
	@dimp=split("#",$tval);
	foreach(@dimp){$_=0 if (!$_);$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
$totimp=0 if (!$totimp);
$inx=0;
while ($inx<24){$dimp[$inx]=0 if (!$dimp[$inx]);$inx++;}
@mdimp=@dimp;
@mdimp=sort ({$b<=>$a} @mdimp);
$maximp=shift(@mdimp);
if ($maximp<=10){$item1=10;$item2=7.5;$item3=5;$item4=2.5;}
elsif ($maximp<=100){$item1=100;$item2=75;$item3=50;$item4=25;}
elsif ($maximp<=1000){$item1=1000;$item2=750;$item3=500;$item4=250;}
elsif ($maximp<=10000){$item1=10000;$item2=7500;$item3=5000;$item4=2500;}
elsif ($maximp<=100000){$item1=100000;$item2=75000;$item3=50000;$item4=25000;}
elsif ($maximp<=1000000){$item1=1000000;$item2=750000;$item3=500000;$item4=250000;}
$grat=$item1/100;
$i=0;
foreach(@dimp)
{
	$height=int($_/$grat);
	$result.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<23){$result.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mhustcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub htmlcounter
{
%data=@_;
$selectede{htmlcounter}="selected";
open (F,"<$adcpath/template/$data{lang}/mhtmlcnt.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub clearcounter
{
%data=@_;
open (F,">$basepath/$data{name}/counter.cmn");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close(F);
open (F,">$basepath/$data{name}/counter.unq");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close(F);
open (F,">$basepath/$data{name}/counter.ext");
flock(F,$LOCK_EX);
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
flock(F,$LOCK_UN);
close(F);
open (F,">$basepath/$data{name}/visitors.ip");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close(F);
&visitors;
}
sub presetcounter
{
%data=@_;
$data{tpreset}=~s/\D//g;
$data{upreset}=~s/\D//g;
$data{tpreset}=0 unless ($data{tpreset});
$data{upreset}=0 unless ($data{upreset});
open (F,">$basepath/$data{name}/counter.prt");
flock(F,$LOCK_EX);
print F $data{tpreset};
flock(F,$LOCK_UN);
close(F);
open (F,">$basepath/$data{name}/counter.pru");
flock(F,$LOCK_EX);
print F $data{upreset};
flock(F,$LOCK_UN);
close(F);
&visitors;
}
1;
