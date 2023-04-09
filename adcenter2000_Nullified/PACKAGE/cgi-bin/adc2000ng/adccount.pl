#!/bin/perl
use Socket;
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
@digits = ("3c 7e 66 66 66 66 66 66 7e 3c","60 70 78 60 60 60 60 60 60 60","3c 7e 66 66 60 30 18 0c 7e 7e","3c 7e 66 60 30 30 60 66 7e 3c","60 70 78 6c 66 66 7e 7e 60 60","7e 7e 06 3e 7e 60 60 60 7e 3e","7c 7e 06 3e 7e 66 66 66 7e 3c","7e 7e 60 30 18 0c 0c 0c 0c 0c","3c 7e 66 66 3c 7e 66 66 7e 3c","3c 7e 66 66 66 7e 7c 60 7e 3e");
($username,$variant,$resolution)=split("&",$ENV{QUERY_STRING});
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
($day,$month,$date,$time,$year)=split(" ",scalar gmtime(time+$gmtzone*3600));
($hours)=split(":",$time);
unless (-e "$basepath/$username/counter.ext")
{
open(F,">$basepath/$username/counter.ext");
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
}
$r_hst=$ENV{REMOTE_HOST};
unless ($r_hst=~/\w+/)
{
	$r_hst=gethostbyaddr(inet_aton($ENV{REMOTE_ADDR}), AF_INET);
}
@hosts=split(/\./,$r_hst);
$host=pop(@hosts);
if ($ENV{HTTP_USER_AGENT}=~/MSIE/){$browser="IE";}
elsif ($ENV{HTTP_USER_AGENT}=~/^Mozilla/){$browser="netscape";}
else {$browser="bother";}
open (F,"+<$basepath/$username/counter.ext");
flock(F,$LOCK_EX);
@dta=<F>;
foreach(@dta)
{
	chop;
	($type,$cnt)=split("\t",$_);
	if ($type eq $host)
	{
		$cnt++;
		$flg=1;
		$_="$type\t$cnt\n";
		next;
	}
	if ($type eq "dother" && !$flg)
	{
		$cnt++;
		$flg=1;
		$_="$type\t$cnt\n";
		next;
	}
	if ($type eq $browser)
	{
		$cnt++;
		$flg=1;
		$_="$type\t$cnt\n";
		next;
	}
	if ($type eq $resolution)
	{
		$cnt++;
		$flg=1;
		$_="$type\t$cnt\n";
		next;
	}
	$_.="\n";
}
truncate(F,0);
seek(F,0,0);
print F @dta;
flock(F,$LOCK_UN);
close (F);
if ($variant eq "A")
{
open (STAT,"<$basepath/$username/counter.cmn");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	$stats.="#$tval";
}
flock(STAT,$LOCK_UN);
close (STAT);
@stats=split ("#",$stats);
foreach (@stats)
{
$count+=$_;
}
open (F,"<$basepath/$username/counter.prt");
flock(F,$LOCK_EX);
$preset=<F>;
flock(F,$LOCK_UN);
close(F);
$count=$count+$preset;
}
elsif ($variant eq "B")
{
open (STAT,"<$basepath/$username/counter.unq");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	$stats.="#$tval";
}
flock(STAT,$LOCK_UN);
close (STAT);
@stats=split ("#",$stats);
foreach(@stats)
{
$count+=$_;
}
open (F,"<$basepath/$username/counter.pru");
flock(F,$LOCK_EX);
$preset=<F>;
flock(F,$LOCK_UN);
close(F);
$count=$count+$preset;
}
$len=8;
$counter = sprintf("%0${len}d",$count);
for ($y=0; $y < 10; $y++)
{
	for ($x=0; $x < $len; $x++){push(@bytes,substr(@digits[substr($counter,$x,1)],$y*3,2));}
}
print "Content-type: image/x-xbitmap\n\n";
print "#define count_width 64\n#define count_height 10\n";
print "static char count_bits[] = {\n";
for($i = 0; $i < ($#bytes + 1); $i++)
{
	print("0x$bytes[$i]");
	if ($i != $#bytes){print(",");if (($i+1) % 7 == 0){print("\n");}}
}
print("};\n");
