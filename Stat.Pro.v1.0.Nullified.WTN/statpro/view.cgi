#!/usr/bin/perl -w
##############################################################################
##                                                                          ##
##  Program Name         : Stat Pro                                         ##
##  Release Version      : 1.0                                              ##
##  Home Page            : http://www.cidex.ru                              ##
##  Supplied by          : CyKuH [WTN]                                      ##
##  Distribution         : via WebForum, ForumRU and associated file dumps  ##
##                                                                          ##
##############################################################################
use GD;

require "./setup.pl";
require "$cgidir/cookie.pl";

&get_data;

   print "content-type: text/html\n\n";
   print $header;
      &hourlyucount;
   print "<hr size=1>";
      &dailyucount;
   print "<hr size=1>";
      &montlyucount;
   print $footer;
   print "<center><small>Статистика ведется с $start</small></center>";

exit;

###############################################################
sub dailyucount  {

&newimage;

if(!$in{date}) {
   $timeoffset = 0;
   ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime(time + (3600*$timeoffset));
   $in{date}=$mday;
   }

$in{dailyucount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($in{month})
{
($day,$in{month},$date,$time,$in{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$in{month};
$selected{$mns}="selected";
#un
open (STAT,"<$statun");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $in{month} / && $tkey=~/ $in{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	foreach(@temp){$mimp[$fas]+=$_;$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);

#all
open (STAT,"<$statall");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $in{month} / && $tkey=~/ $in{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	foreach(@temp){$mimpall[$fas]+=$_;$totimpall+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);


$month=$in{month};

$calendar{$month}=29 if ($year/4-int($year/4)==0 && $month eq "Feb");

$i=1;

      push(@mstats,"<table border=0 width=100% cellpadding=3 cellspacing=1><tr><td width=15%  bgcolor=\"#f0f0f0\"><b>Дата</b></td><td width=20% bgcolor=\"#f0f0f0\"></td><td width=5% bgcolor=\"#f0f0f0\"></td><td width=15% bgcolor=\"#f0f0f0\"><b>Дата</b></td><td width=20% bgcolor=\"#f0f0f0\"></td><td width=5% bgcolor=\"#f0f0f0\"></td></tr>\n");
      
      while($i<$calendar{$month}+1)
            {
	$mimp[$i]=0 if ($mimp[$i] eq "");
	$mimpall[$i]=0 if ($mimpall[$i] eq "");
	if ( $mimp[$i] eq $mimp[$i-1] ) { $proc = "<img src=\"$statn\">"; }
	elsif ( $mimp[$i] > $mimp[$i-1] ) { $proc = "<img src=\"$statu\">"; }
	elsif ( $mimp[$i] < $mimp[$i-1] ) { $proc = "<img src=\"$statd\">"; }
	else { $proc = "<img src=\"$statn\">"; }
	push(@mstats,"<tr><td>$i&nbsp;$rusmonth{$month}</td><td align=\"center\"><small><b>$mimpall[$i] / $mimp[$i]</small></b></td><td>$proc</td>\n");
	$i++;
	
	        if($i<$calendar{$month}+1)
	              {
		$mimp[$i]=0 if ($mimp[$i] eq "");
		$mimpall[$i]=0 if ($mimpall[$i] eq "");
		if ( $mimp[$i] eq $mimp[$i-1] ) { $proc = "<img src=\"$statn\">"; }
	                elsif ( $mimp[$i] > $mimp[$i-1] ) { $proc = "<img src=\"$statu\">"; }
	                elsif ( $mimp[$i] < $mimp[$i-1] ) { $proc = "<img src=\"$statd\">"; }
	                else { $proc = "<img src=\"$statn\">"; }
		push(@mstats,"<td>$i&nbsp;$rusmonth{$month}</td><td align=\"center\"><small><b>$mimpall[$i] / $mimp[$i]</small></b></td><td>$proc</td></tr>\n");
		$i++;
                              }
            }
      $totimp=0 if (!$totimp);
      $totimpall=0 if (!$totimpall);
       push(@mstats,"<tr><td class=b2 colspan=6></td></tr></table>\n");

$totclc=0 if (!$totclc);
$totimp=0 if (!$totimp);
$totimpall=0 if (!$totimpall);
@mmimp=@mimpall;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);

$maxcount =1;
while($maximp>=$maxcount) { $maxcount = $maxcount+10; }
$maxcount = $maxcount-1;
$item1=$maxcount; $item2=int($maxcount/4*3); $item3=int($maxcount/2); $item4=int($maxcount/4);

$grat=$item1/100;
$i=1;

           $co = 40;             
      for ($i=1;$i<=$calendar{$month}+1;$i++)
                                          { $im->line($co, 25, $co, 149, $ser);
                                            $co = $co+10; }
           $co = 29;             
      for ($i=1;$i<=$calendar{$month};$i++)
                                          { $im->stringUp(gdTinyFont, $co+3, 165, "$i", $black);
                                            $height=int(145-$mimp[$i]/$grat);
                                            $heightall=int(145-$mimpall[$i]/$grat);
                                            
                                         if ($contur) {$im->rectangle($co+1,$heightall,$co+4,148,$black);      
                                                            $im->rectangle($co+6,$height,$co+9,148,$black);}
                                            
        for ($o=1;$o<=4;$o++) {
           $im->line($co+$o,$heightall+1,$co+$o,147,$zhelt);
           $im->line($co+$o+5,$height+1,$co+$o+5,147,$zel);
        }
                                              $co = $co+10; }
      $im->string(gdTinyFont,, 5, 140, "0", $black);
      $im->string(gdTinyFont, 5, 115, "$item4", $black);
      $im->string(gdTinyFont, 5, 90, "$item3", $black);
      $im->string(gdTinyFont, 5, 65, "$item2", $black);
      $im->string(gdTinyFont, 5, 40, "$item1", $black);
           
                                           
 $png_data = $im->png;
 
 open (DISPLAY,">$imgfile/daily.png");
 binmode DISPLAY;
 print DISPLAY $png_data;
 close DISPLAY;
 
open (F,"<$thtml/dailyucount.htm");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";

eval $htmlpage;
$totimp = "";
$totimpall = "";
$result = "";
@mimp="";
@mimpall="";
}

###############################################################
sub montlyucount  {

&newimage;

$selectede{montlyucount}="selected";

#un
open (STAT,"<$statun");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $in{year}/)
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

#all
open (STAT,"<$statall");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $in{year}/)
	{
	$tkey=~s/  / /;
	($faf,$fae,$fas)=split(" ",$tkey);
	@temp=split("#",$tval);
	$temp=$cal{$fae};
	foreach(@temp){$mimpall[$temp]+=$_;$totimpall+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close (STAT);


foreach(@cal)
{
	$temp=$cal{$_};
	$mimp[$temp]=0 if ($mimp[$temp] eq "");
	$mimpall[$temp]=0 if ($mimpall[$temp] eq "");
	if ( $mimp[$temp] eq $mimp[$temp-1] ) { $proc[$temp] = "<img src=\"$statn\">"; }
	elsif ( $mimp[$temp] > $mimp[$temp-1] ) { $proc[$temp] = "<img src=\"$statu\">"; }
	elsif ( $mimp[$temp] < $mimp[$temp-1] ) { $proc[$temp] = "<img src=\"$statd\">"; }
	else { $proc[$temp] = "<img src=\"$statn\">"; }

}
$totimp=0 if (!$totimp);
$totimpall=0 if (!$totimpall);
@mmimp=@mimpall;
@mmimp=sort ({$b<=>$a} @mmimp);
$maximp=shift(@mmimp);

$maxcount =1;
while($maximp>=$maxcount) { $maxcount = $maxcount+10; }
$maxcount = $maxcount-1;
$item1=$maxcount; $item2=int($maxcount/4*3); $item3=int($maxcount/2); $item4=int($maxcount/4);

$grat=$item1/100;
$i=1;

           $co = 40;
      for ($i=1;$i<=13;$i++)
                                          { $im->line($co, 25, $co, 149, $ser);
                                            $co = $co+24; }
           $co = 39;             
      for ($i=1;$i<=12;$i++)
                                          { $im->stringUp(gdSmallFont, $co+6, 165, "$i", $black);
                                            $height=int(145-$mimp[$i]/$grat);
                                            $heightall=int(145-$mimpall[$i]/$grat);
                                            
                                             if ($contur) {$im->rectangle($co+1,$heightall,$co+10,148,$black);
                                                                $im->rectangle($co+13,$height,$co+22, 148,$black);}
                                            
                                               for ($o=1;$o<=8;$o++) {
           $im->line($co+$o+1,$heightall+1,$co+$o+1,147,$zhelt);
           $im->line($co+$o+13,$height+1,$co+$o+13,147,$zel); }
                                              $co = $co+24; }
      $im->string(gdTinyFont,, 5, 140, "0", $black);
      $im->string(gdTinyFont, 5, 115, "$item4", $black);
      $im->string(gdTinyFont, 5, 90, "$item3", $black);
      $im->string(gdTinyFont, 5, 65, "$item2", $black);
      $im->string(gdTinyFont, 5, 40, "$item1", $black);
           
                                           
 $png_data = $im->png;
 
 open (DISPLAY,">$imgfile/montly.png");
 binmode DISPLAY;
 print DISPLAY $png_data;
 close DISPLAY;

open (F,"<$thtml/mmustcnt.htm");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";

eval $htmlpage;
$totimp = "";
$totimpall = "";
$result = "";
@mimp="";
@mimpall="";
}
###############################################################
sub hourlyucount  {

&newimage;

$selectede{hourlyucount}="selected";
($ldate=scalar gmtime(time+$gmtzone*3600))=~s/ \d+:\d+:\d+//;
unless ($in{date})
{
($day,$in{month},$in{date},$time,$in{year})=split(" ",scalar gmtime(time+$gmtzone*3600));
}
$mns=$in{month};
$selected{$mns}="selected";
#$in{date}="0$in{date}" if (length($in{date})==1);

#un
open (STAT,"<$statun");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $in{date} / && $tkey=~/ $in{month} / && $tkey=~/ $in{year}/)
	{
	@dimp=split("#",$tval);
	foreach(@dimp){$_=0 if (!$_);$totimp+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);

#all
open (STAT,"<$statall");
flock(STAT,$LOCK_EX);
while($line=<STAT>)
{
	chop($line);
	($tkey,$tval)=split("\t",$line);
	if ($tkey=~/ $in{date} / && $tkey=~/ $in{month} / && $tkey=~/ $in{year}/)
	{
	@dimpall=split("#",$tval);
	foreach(@dimpall){$_=0 if (!$_); $totimpall+=$_;}
	}
}
flock(STAT,$LOCK_UN);
close(STAT);

$totimp=0 if (!$totimp);
$totimpall=0 if (!$totimpall);
$inx=0;

while ($inx<24){

  $dimp[$inx]=0 if (!$dimp[$inx]);
  $dimpall[$inx]=0 if (!$dimpall[$inx]);

if ( $inx eq 0 ) { $pr[$0] = "<img src=\"$statn\">"; }
elsif ( $dimp[$inx] eq $dimp[$inx-1] ) { $pr[$inx] = "<img src=\"$statn\">"; }
elsif ( $dimp[$inx] > $dimp[$inx-1] ) { $pr[$inx] = "<img src=\"$statu\">"; }
elsif ( $dimp[$inx] < $dimp[$inx-1] ) { $pr[$inx] = "<img src=\"$statd\">"; }
else { $pr[$inx] = "<img src=\"$statn\">"; }

$inx++;}

@mdimp=@dimpall;
@mdimp=sort ({$b<=>$a} @mdimp);
$maximp=shift(@mdimp);

$maxcount =1;
while($maximp>=$maxcount) { $maxcount = $maxcount+10; }
$maxcount = $maxcount-1;
$item1=$maxcount; $item2=int($maxcount/4*3); $item3=int($maxcount/2); $item4=int($maxcount/4);

$grat=$item1/100;
#$grat=10;
$i=0;

           $co = 42;
      foreach(@dimp)          { $im->line($co, 26, $co, 149, $ser);
                                            $co = $co+13; }
           $co = 29;
           $i =1;
      foreach(@dimp)
                { $im->stringUp(gdTinyFont, $co+3, 165, "$i", $black);
                  $height=int(145-$dimp[$i]/$grat);
                  $heightall=int(145-$dimpall[$i]/$grat);
                  $i++;
                                           
        for ($o=1;$o<=5;$o++) {
           $im->line($co+$o,$heightall+1,$co+$o,147,$zhelt);
           $im->line($co+$o+6,$height+1,$co+$o+6,147,$zel);
        }

        if ($contur) {$im->rectangle($co+1,$heightall,$co+5,148,$black);      
                           $im->rectangle($co+7,$height,$co+11,148,$black);}

                                              $co = $co+13; }
      $im->string(gdTinyFont,, 5, 140, "0", $black);
      $im->string(gdTinyFont, 5, 115, "$item4", $black);
      $im->string(gdTinyFont, 5, 90, "$item3", $black);
      $im->string(gdTinyFont, 5, 65, "$item2", $black);
      $im->string(gdTinyFont, 5, 40, "$item1", $black);
           
                                           
 $png_data = $im->png;
 
 open (DISPLAY,">$imgfile/hourly.png");
 binmode DISPLAY;
 print DISPLAY $png_data;
 close DISPLAY;

open (F,"<$thtml/mhustcnt.htm");
@htmlpage=<F>;
close (F);
$htmlpage=join("",@htmlpage);
$htmlpage="print qq~$htmlpage~;";

eval $htmlpage;
$totimp = "";
$totimpall = "";
$result = "";
@mimp="";
@mimpall="";
}

#####################################################
# Создание картинки
#####################################################
sub newimage {

 #$im = new GD::Image(350,180);
   open(IN, "$grfile");
     $im = newFromPng GD::Image(IN); 
   close(IN);

    # цвета (значения в RGB)
    $wite = $im->colorAllocate(255,255,255);
    $ser = $im->colorAllocate(204,204,204);
    $zel = $im->colorAllocate(0,166,81);
    $zhelt = $im->colorAllocate(252,173,1);
    $black = $im->colorAllocate(0,0,0);
    $red = $im->colorAllocate(155,0,0);
}

###############################################################
#  Разбить на данные
###############################################################
sub get_data {

if ($ENV{'REQUEST_METHOD'} eq "POST")
    {
    read(STDIN, $bufer, $ENV{'CONTENT_LENGTH'});
    }
else
    {
    $bufer=$ENV{'QUERY_STRING'};
    }    
  @pairs = split(/&/, $bufer);
  foreach $pair (@pairs)
      {
        ($name, $value) = split(/=/, $pair);
        $name =~ tr/+/ /;
        $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $in{$name} = $value;
      }      
}
