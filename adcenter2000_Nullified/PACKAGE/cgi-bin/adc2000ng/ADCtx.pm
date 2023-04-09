package ADCtx;
require Exporter;
@ISA = qw( Exporter );
@EXPORT = qw(
		tx
		htmltx
		cleartx
		dailytx
		montlytx
		hourlytx
		mantx
		remadtx
		addadtx
		customtx
	    );
open (F, "<adc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

sub tx
{
%data=@_;
$selectede{tx}="selected";
open (STAT,"<$basepath/$data{name}/impressions.tx");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	@temp=split("#",$tval);
	foreach(@temp){$itx+=$_;}
}
flock(STAT,$LOCK_UN);
close (STAT);
open (STAT,"<$basepath/$data{name}/clicks.tx");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	@temp=split("#",$tval);
	foreach(@temp){$ctx+=$_;}
}
flock(STAT,$LOCK_UN);
close (STAT);
$itx=0 if (!$itx);
$ctx=0 if (!$ctx);
if ($itx>0){$ctr=$ctx/$itx;}
else {$ctr=0;}
($ctr1,$ctr2)=split(/\./,$ctr);
$ctr2=substr($ctr2,0,2);
$ctr2.="00" if (!$ctr2);
$ctr="$ctr1.$ctr2";
open (F,"<$adcpath/template/$data{lang}/mstattx.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub dailytx
{
%data=@_;
$selectede{dailytx}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{month})
{
($day,$data{month},$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$data{month};
$selected{$mns}="selected";
open (STAT,"<$basepath/$data{name}/impressions.tx");
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
		foreach(@temp){$totimp+=$_;$mimp[$fas]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
open (STAT,"<$basepath/$data{name}/clicks.tx");
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
		foreach(@temp){$totclc+=$_;$mclc[$fas]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
$month=$data{month};
$year=$data{year};
$calendar{$month}=29 if ($year/4-int($year/4)==0 && $month eq "Feb");
$tablewidth=12*$calendar{$month}-2;
$table=$tablewidth+60;
$i=1;
while($i<$calendar{$month}+1)
{
	$mclc[$i]=0 if ($mclc[$i] eq "");
	$mimp[$i]=0 if ($mimp[$i] eq "");
	push(@mstats,"<tr><td bgcolor=\"#82C7DB\"><font size=2><b>$i</b></font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2>$mimp[$i]</font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2>$mclc[$i]</font></td></tr>\n");
	$i++;
	if ($i<$calendar{$month}+1)
	{
		$mclc[$i]=0 if ($mclc[$i] eq "");
		$mimp[$i]=0 if ($mimp[$i] eq "");
		push(@mstats,"<tr><td><font size=2><b>$i</b></font></td><td align=\"right\"><font size=2>$mimp[$i]</font></td><td align=\"right\"><font size=2>$mclc[$i]</font></td></tr>\n");
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
	$result1.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<$calendar{$month}){$result1.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
@mmclc=@mclc;
@mmclc=sort ({$b<=>$a} @mmclc);
$maxclc=shift(@mmclc);
if ($maxclc<=10){$itm1=10;$itm2=7.5;$itm3=5;$itm4=2.5;}
elsif ($maxclc<=100){$itm1=100;$itm2=75;$itm3=50;$itm4=25;}
elsif ($maxclc<=1000){$itm1=1000;$itm2=750;$itm3=500;$itm4=250;}
elsif ($maxclc<=10000){$itm1=10000;$itm2=7500;$itm3=5000;$itm4=2500;}
elsif ($maxclc<=100000){$itm1=100000;$itm2=75000;$itm3=50000;$itm4=25000;}
elsif ($maxclc<=1000000){$itm1=1000000;$itm2=750000;$itm3=500000;$itm4=250000;}
$grat=$itm1/100;
$i=1;
while($i<$calendar{$month}+1)
{
	$height=int($mclc[$i]/$grat);
	$result2.=qq~<img src="$adcenter/images/$data{lang}/sg2.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<$calendar{$month}){$result2.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mdaytx.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub montlytx
{
%data=@_;
$selectede{montlytx}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{year})
{
($day,$month,$date,$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
open (STAT,"<$basepath/$data{name}/impressions.tx");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{year}/)
	{
		$tkey=~s/  / /;
		($faf,$fae,$fas)=split(" ",$tkey);
		$temp=$cal{$fae};
		@temp=split("#",$tval);
		foreach(@temp){$totimp+=$_;$mimp[$temp]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
open (STAT,"<$basepath/$data{name}/clicks.tx");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{year}/)
	{
		$tkey=~s/  / /;
		($faf,$fae,$fas)=split(" ",$tkey);
		$temp=$cal{$fae};
		@temp=split("#",$tval);
		foreach(@temp){$totclc+=$_;$mclc[$temp]+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
$tablewidth=12*12-2;
$table=$tablewidth+60;
foreach(@cal)
{
	$temp=$cal{$_};
	$mimp[$temp]=0 if ($mimp[$temp] eq "");
	$mclc[$temp]=0 if ($mclc[$temp] eq "");
}
$totimp=0 if (!$totimp);
$totclc=0 if (!$totclc);
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
	$result1.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<12){$result1.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
@mmclc=@mclc;
@mmclc=sort ({$b<=>$a} @mmclc);
$maxclc=shift(@mmclc);
if ($maxclc<=10){$itm1=10;$itm2=7.5;$itm3=5;$itm4=2.5;}
elsif ($maxclc<=100){$itm1=100;$itm2=75;$itm3=50;$itm4=25;}
elsif ($maxclc<=1000){$itm1=1000;$itm2=750;$itm3=500;$itm4=250;}
elsif ($maxclc<=10000){$itm1=10000;$itm2=7500;$itm3=5000;$itm4=2500;}
elsif ($maxclc<=100000){$itm1=100000;$itm2=75000;$itm3=50000;$itm4=25000;}
elsif ($maxclc<=1000000){$itm1=1000000;$itm2=750000;$itm3=500000;$itm4=250000;}
$grat=$itm1/100;
$i=1;
while($i<13)
{
	$height=int($mclc[$i]/$grat);
	$result2.=qq~<img src="$adcenter/images/$data{lang}/sg2.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<12){$result2.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mmontx.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub hourlytx
{
%data=@_;
$selectede{hourlytx}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($data{date})
{
($day,$data{month},$data{date},$time,$data{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$data{month};
$selected{$mns}="selected";
#$data{date}="0$data{date}" if (length($data{date})==1);
open (STAT,"<$basepath/$data{name}/impressions.tx");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{date} / && $tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
		@dimp=split("#",$tval);
		foreach(@dimp){$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
open (STAT,"<$basepath/$data{name}/clicks.tx");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $data{date} / && $tkey=~/ $data{month} / && $tkey=~/ $data{year}/)
	{
		@dclc=split("#",$tval);
		foreach(@dclc){$totclc+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);
$i=0;
while($i<24)
{
	$dimp[$i]=0 if (!$dimp[$i]);
	$dclc[$i]=0 if (!$dclc[$i]);
	$i++;
}
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
	$result1.=qq~<img src="$adcenter/images/$data{lang}/sg1.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<23){$result1.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
@mdclc=@dclc;
@mdclc=sort ({$b<=>$a} @mdclc);
$maxclc=shift(@mdclc);
if ($maxclc<=10){$itm1=10;$itm2=7.5;$itm3=5;$itm4=2.5;}
elsif ($maxclc<=100){$itm1=100;$itm2=75;$itm3=50;$itm4=25;}
elsif ($maxclc<=1000){$itm1=1000;$itm2=750;$itm3=500;$itm4=250;}
elsif ($maxclc<=10000){$itm1=10000;$itm2=7500;$itm3=5000;$itm4=2500;}
elsif ($maxclc<=100000){$itm1=100000;$itm2=75000;$itm3=50000;$itm4=25000;}
elsif ($maxclc<=1000000){$itm1=1000000;$itm2=750000;$itm3=500000;$itm4=250000;}
$grat=$itm1/100;
$i=0;
foreach(@dclc)
{
	$height=int($_/$grat);
	$result2.=qq~<img src="$adcenter/images/$data{lang}/sg2.gif" width=8 height=$height border=1 bordercolor=black>~;
	if ($i<23){$result2.=qq~<img src="$adcenter/images/$data{lang}/sdot.gif">~;}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mhourtx.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub htmltx
{
%data=@_;
$selectede{htmltx}="selected";
open (F,"<$basepath/$data{name}/tx.dat");
flock(F,$LOCK_EX);
($bgcol,$fncol,$boxw,$bgimg)=split("\t",<F>);
flock(F,$LOCK_UN);
close(F);
$i=$stxw;
while($i<$etxw+1)
{
	if ($i==$boxw){$boxwidth.="<option selected value=\"$i\">$i</option>\n";}
	else {$boxwidth.="<option value=\"$i\">$i</option>\n";}
	$i++;
}
$i=1;
while($i<4)
{
	if ($i==$bgimg){$speed.="<option selected value=\"$i\">$i</option>";}
	else {$speed.="<option value=\"$i\">$i</option>";}
	$i++;
}
open (F,"<$adcpath/template/$data{lang}/mhtmltx.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub cleartx
{
%data=@_;
open (F,">$basepath/$data{name}/impressions.tx");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close(F);
open (F,">$basepath/$data{name}/clicks.tx");
flock(F,$LOCK_EX);
flock(F,$LOCK_UN);
close(F);
&tx;
}
sub mantx
{
%data=@_;
$selectede{mantx}="selected";
open (F,"<$adcpath/tx/$data{name}");
flock(F,$LOCK_EX);
@ads=<F>;
flock(F,$LOCK_UN);
close(F);
$i=0;
while($i<@ads)
{
	chop($ads[$i]);
	push(@adtxt,"<tr><td bgcolor=\"#82C7DB\"><font size=2><b>$ads[$i]</b></font></td><td align=\"right\" bgcolor=\"#82C7DB\"><font size=2><input type=checkbox name=remads value=$i></font></td></tr>\n");
	$i++;
	if ($i<@ads)
	{
		chop($ads[$i]);
		push(@adtxt,"<tr><td><font size=2><b>$ads[$i]</b></font></td><td align=\"right\"><font size=2><input type=checkbox name=remads value=$i></font></td></tr>\n");
		$i++;
	}
}
if (@adtxt)
{
	push(@adtxt,"<tr><td align=right colspan=2><font size=2><input type=\"image\" border=0 src=\"$adcenter/images/$data{lang}/proceed.gif\" width=83 height=23></font></td></tr>\n");
}
else
{
open (F,"<$adcpath/langpack/$data{lang}.msg");
flock(F,$LOCK_EX);
$evline=<F>;
flock(F,$LOCK_UN);
close(F);
eval $evline;
push(@adtxt,"<tr><td colspan=2><font size=2>$rep[0]</font></td></tr>\n");
}
open (F,"<$adcpath/template/$data{lang}/mmadstx.tpl");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
eval $htmlpage;
exit;
}
sub remadtx
{
%data=@_;
@remads=split("##",$data{remads});
open (F,"<$adcpath/tx/$data{name}");
flock(F,$LOCK_EX);
@ads=<F>;
flock(F,$LOCK_UN);
close(F);
@remads=reverse(@remads);
foreach(@remads)
{
	splice(@ads,$_,1);
}
open (F,">$adcpath/tx/$data{name}");
flock(F,$LOCK_EX);
print F @ads;
flock(F,$LOCK_UN);
close(F);
&mantx;
}
sub addadtx
{
%data=@_;
$data{ad}=~s/\'//g;
$data{ad}=~s/\"//g;
$data{ad}=~s/\~//g;
$data{ad}=~s/\<[^>]+\>//g;
$data{ad}=~s/\r\n/ /g;
if (-e "$basepath/$data{name}/autoaccept")
{
open (F,">>$adcpath/tx/$data{name}");
flock(F,$LOCK_EX);
print F "$data{ad}\n";
flock(F,$LOCK_UN);
close(F);
}
else
{
open (F,">>$adcpath/queye/tx/$data{name}");
flock(F,$LOCK_EX);
print F "$data{ad}\n";
flock(F,$LOCK_UN);
close(F);
}
&mantx;
}
sub customtx
{
%data=@_;
open (F,">$basepath/$data{name}/tx.dat");
flock(F,$LOCK_EX);
print F "$data{bgcol}\t$data{fncol}\t$data{boxwidth}\t$data{bgimg}";
flock(F,$LOCK_UN);
close(F);
&htmltx;
}
1;
