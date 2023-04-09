#!/usr/bin/perl

#################################################
##           Albinator System                  ##
##           by Mayank Gandhi	                 ##
##      (e-mail: mayank@radiolink.net)         ##
##                                             ##
##              version: c102                  ##
##         last modified: 14/5/2002            ##
##           copyright (c) 2001-02             ##
##                                             ##
## aVAILABLe FoR fReeLANCE cGi/php PROgramming ##
##             www.mgzhome.com                 ##
#################################################
##     YOU CAN DO CHANGES ON YOUR OWN RISK     ##
#################################################

#### EDIT THIS ######
# You can find the detailed help at:
# http://www.albinator.com/manual/getting.php#cgisettings

@okaydomains =("albinator.com", "mgzhome.com"); # allowed domains to send manipulate request
$DATAPATH = ".."; # NO TRAILING SLASH - give the relative path from your cgi directory to the albinator directory
$DATADIR  = "../data"; # NO TRAILING SLASH - give the relative path from your cgi directory to the datapath directory

$deflang  = "eng"; # Optional: The default language code for picking the CSS file.

#### STOP HERE ######


&security_check;
&decode_vars;

if($fields{'callwhat'} eq "reimage")
{
use Image::Magick;
my($image);
$image = Image::Magick->new;
$ENV{PATH}='/bin:/usr/bin:/usr/local/bin';

$BASEDIR = $DATADIR;

$fpath = "$BASEDIR/$fields{'uid'}";
$wt = $fields{'wt'};
$ht = $fields{'ht'};
$fn = "$fpath/$fields{'fn'}";
$fnfinal =  "$fpath/tb_$fields{'fn'}";

$image->Read("$fn");
$image->Resize(width=>$wt, height=>$ht);
$image->Write(filename=>"$fnfinal", compression=>'None');

print "Content-type: text/html","\n\n";

exit;
}

elsif($fields{'callwhat'} eq "reimageb")
{
$BASEDIR = $DATADIR;
$ENV{PATH}='/bin:/usr/bin:/usr/local/bin';

use Image::Magick;

$fpath = "$BASEDIR/$fields{'uid'}";
$wt = $fields{'wt'};
$ht = $fields{'ht'};
$fn = "$fpath/$fields{'fn'}";

if($fields{'sav'} == "1")
{ $fnfinal = "$fpath/t_$fields{'fn'}"; }

elsif($fields{'noforce'} == "1")
{ $fnfinal = "$fpath/$fields{'fn'}"; }

else
{ $fnfinal = "$fpath/full_$fields{'fn'}"; }

my($image);
$image = Image::Magick->new;
$image->Read("$fn");
$image->Resize(width=>$wt, height=>$ht);
$image->Write(filename=>"$fnfinal", compression=>'None');

if($fields{'sav'} == "1")
{
open(FILEEND,">$fn");
flock(FILEEND, 2);
open(FILE,"$fnfinal");

$content;

while($content = <FILE>)
{ 
$fdata = "$content"; 
print FILEEND "$fdata";
}
close(FILE);
flock(FILEEND, 8);
close(FILEEND);

unlink($fnfinal);
}

print "Content-type: text/html","\n\n";

exit;
}

elsif($fields{'callwhat'} eq "savman")
{
$DELDIR = "$DATADIR/temp";
$TDIR = "temp";
$BASEDIR = $DATADIR;

$DAYS = "1";

  local(@items, $item);
  opendir(CARDDIR, "$DELDIR");
  @items = grep(/[0-9]$EXT/,readdir(CARDDIR));
  closedir(CARDDIR);
  foreach $item (@items)
  {
   if (-M "$DELDIR/$item" > $DAYS)
    {
     unlink("$DELDIR/$item");
    }
  }


if($fields{'fn'} == "")
{
print "Content-type: text/html","\n\n";
print "Invalid Data";

$valid = 0;
exit;
}

$fpath = "$BASEDIR/$fields{'uid'}";

$fn = "$fpath/$fields{'fn'}";
$tbfn =  "$BASEDIR/$TDIR/temp_"."$fields{'fn'}";

if($fields{'dowhat'} eq "save")
{
unlink($fn);

open(FILEEND,">$fn");
flock(FILEEND, 2);
open(FILE,"$tbfn");

$content;

while($content = <FILE>)
{ 
$fdata = "$content"; 
print FILEEND "$fdata";
}
close(FILE);
flock(FILEEND, 8);
close(FILEEND);

unlink($tbfn);

if($fields{'thumb'} eq "1")
{
	$fnfinal = "$fpath/tb_$fields{'fn'}";
	unlink($fnfinal);

	$wt = $fields{'wt'};
	$ht = $fields{'ht'};

	use Image::Magick;

	my($image);
	$image = Image::Magick->new;
	$image->Read("$fn");
	$image->Resize(width=>$wt, height=>$ht);
	$image->Write(filename=>"$fnfinal", compression=>'None');
}

if($fields{'full'} eq "1")
{
	$fnfinal = "$fpath/full_$fields{'fn'}";
	unlink($fnfinal);

	$wt = $fields{'wtf'};
	$ht = $fields{'htf'};

	use Image::Magick;

	my($image);
	$image = Image::Magick->new;
	$image->Read("$fn");
	$image->Resize(width=>$wt, height=>$ht);
	$image->Write(filename=>"$fnfinal", compression=>'None');
}

print "Content-type: text/html","\n\n";
print "<html><head>\n<script>\n<!--\n";
print "self.opener.location.reload();\nself.close();\n";
print "\n//-->\n</script></head><body>Done</body></html>\n";
}

else
{ 
unlink($tbfn); 
print "Content-type: text/html","\n\n";
print "<html><head>\n<script>\n<!--\n";
print "self.close()\n";
print "\n//-->\n</script></head><body>Done</body></html>\n";
}


exit;
}

elsif($fields{'callwhat'} eq "manipulate")
{
$DELDIR = "$DATADIR/temp";
$BASEDIR = $DATADIR;
$TDIR = "temp";

$DAYS = "1";

  local(@items, $item);
  opendir(CARDDIR, "$DELDIR");
  @items = grep(/[0-9]$EXT/,readdir(CARDDIR));
  closedir(CARDDIR);
  foreach $item (@items)
   {
    if (-M "$DELDIR/$item" > $DAYS)
     {
      unlink("$DELDIR/$item");
     }
   }

$ENV{PATH}='/bin:/usr/bin:/usr/local/bin';

if($fields{'fn'} == "")
{
print "Content-type: text/html","\n\n";
print "Invalid Data";

$valid = 0;
exit;
}

use Image::Magick;

$fpath = "$BASEDIR/$fields{'uid'}";
$wt = $fields{'wt'};
$ht = $fields{'ht'};
$fn = "$fpath/$fields{'fn'}";
$randnum = time;
$fnfinalb =  "$BASEDIR/$TDIR/temp_"."$fields{'fn'}";

my($image);
$image = Image::Magick->new;
$image->Read("$fn");

if($fields{'dowhat'} eq "addnoise")
{ $image->AddNoise(noise=>$fields{'param_a'}); }

elsif($fields{'dowhat'} eq "reducenoise")
{ $image->ReduceNoise(radius=>$fields{'param_a'}); }

elsif($fields{'dowhat'} eq "shade")
{ $image->Shade(geometry=>geometry, azimuth=>$fields{'param_b'}, elevation=>$fields{'param_b'}, color=>{false}); }

elsif($fields{'dowhat'} eq "blur")
{ $image->Blur(geometry=>geometry, radius=>$fields{'param_a'}, sigma=>$fields{'param_a'}); }

elsif($fields{'dowhat'} eq "sharpen")
{ $image->Sharpen(geometry=>geometry, radius=>$fields{'param_a'}, sigma=>$fields{'param_a'}); }

elsif($fields{'dowhat'} eq "border")
{ $image->Border(geometry=>geometry, width=>$fields{'param_a'}, height=>$fields{'param_a'}, fill=>$fields{'param_b'}); }

elsif($fields{'dowhat'} eq "raise")
{ $image->Raise(geometry=>geometry, width=>10, height=>10, x=>10, y=>10, raise=>{True}); }

elsif($fields{'dowhat'} eq "flip")
{ $image->Flip(); }

elsif($fields{'dowhat'} eq "flop")
{ $image->Flop(); }

elsif($fields{'dowhat'} eq "enhance")
{ $image->Enhance(); }

elsif($fields{'dowhat'} eq "despeckle")
{ $image->Despeckle(); }

elsif($fields{'dowhat'} eq "trim")
{ $image->Trim(); }

elsif($fields{'dowhat'} eq "edge")
{ $image->Edge(radius=>.001); }

elsif($fields{'dowhat'} eq "emboss")
{ $image->Emboss(geometry=>geometry, radius=>1, sigma=>1); }

elsif($fields{'dowhat'} eq "grayscale")
{ $image->Quantize(colorspace=>'gray'); }

elsif($fields{'dowhat'} eq "gamma")
{
 if($fields{'param_a'} < 0 || $fields{'param_a'} > 5 || $fields{'param_a'} == "")
 { $fields{'param_a'} = 1; }
 if($fields{'param_b'} < 0 || $fields{'param_b'} > 5 || $fields{'param_a'} == "")
 { $fields{'param_b'} = 1; }
 if($fields{'param_c'} < 0 || $fields{'param_c'} > 5 || $fields{'param_a'} == "")
 { $fields{'param_c'} = 1; }

 $image->Gamma(red=>$fields{'param_a'}, green=>$fields{'param_b'}, blue=>$fields{'param_c'}); }

elsif($fields{'dowhat'} eq "brightness")
{
 if($fields{'param_a'} < -100 || $fields{'param_a'} > 100 || $fields{'param_a'} == "")
 { $fields{'param_a'} = 1; }
 if($fields{'param_b'} < -100 || $fields{'param_b'} > 100 || $fields{'param_b'} == "")
 { $fields{'param_b'} = 1; }
 if($fields{'param_c'} < -100 || $fields{'param_c'} > 100 || $fields{'param_c'} == "")
 { $fields{'param_c'} = 1; }

 $image->Modulate(brightness=>$fields{'param_a'}, saturation=>$fields{'param_b'}, hue=>$fields{'param_c'}); }

elsif($fields{'dowhat'} eq "contrast")
{ 
	if($fields{'param_a'} eq "True")
	{ $image->Contrast(sharpen=>{$fields{'param_a'}}); }
	else
	{ $image->Contrast(); }
}

$image->Write(filename=>"$fnfinalb", compression=>'None');

print "Content-type: text/html","\n\n";
print "<html><head><title>Manipluated</title><link rel=\"stylesheet\" HREF=\"$DATAPATH/essential/".$deflang."_default.css\" type=\"text/css\"></head>\n";
print "<body background='$DATAPATH/images/design/background.gif' bgcolor='#ffffff'><div align='center' class='tn'><a href=\"$DATAPATH/user/savman.php?fn=$fields{'fn'}&uid=$fields{'uid'}&dowhat=save\">Save</a> :: <a href=\"albinator.cgi?fn=$fields{'fn'}&uid=$fields{'uid'}&dowhat=cancel&callwhat=savman\">Cancel</a>";
print "<br><br><img src=$fnfinalb?$randnum><br><br><a href=\"$DATAPATH/user/savman.php?fn=$fields{'fn'}&uid=$fields{'uid'}&dowhat=save\">Save</a> :: <a href=\"albinator.cgi?fn=$fields{'fn'}&uid=$fields{'uid'}&dowhat=cancel&callwhat=savman\">Cancel</a></div></body></html>";

exit;

}

sub decode_vars
{
  $i=0;

    if ($ENV{'REQUEST_METHOD'} eq 'GET') 
    {
     @pairs = split(/&/, $ENV{'QUERY_STRING'});
    }

  elsif ($ENV{'REQUEST_METHOD'} eq 'POST') 
  {
  read(STDIN,$temp,$ENV{'CONTENT_LENGTH'});
  @pairs=split(/&/,$temp);
  }

  foreach $item(@pairs)
   {
    ($key,$content)=split(/=/,$item,2);
    $content=~tr/+/ /;
    $content=~s/%(..)/pack("c",hex($1))/ge;
    $content =~ s/<!--(.|\n)*-->//g;
    push(@Field_Order,$key);
    $fields{$key}=$content;
    $i++;
    $item{$i}=$key;
    $response{$i}=$content;
   }
}

sub security_check
{
  $DOM_ERR = 0;

  $RF=$ENV{'HTTP_REFERER'};
  $RF=~tr/A-Z/a-z/;

  foreach $ts (@okaydomains)
  {
	if ($RF =~ /$ts/)
	{ $DOM_ERR = 1; }
  }

  if($DOM_ERR == 0)
  {
    print "Content-type: text/html\n\n";
    print "<br><br><br><div align=center><font face=verdana size=4>Security Error, please try again.</div></font>";
    exit; 
  }
}