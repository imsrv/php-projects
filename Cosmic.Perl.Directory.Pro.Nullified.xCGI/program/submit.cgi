#!/usr/local/bin/perl
##-----------------------------------------------------------------##
##                                                                 ##
##                                                                 ##
## © Copyright Mr Lyle R Hopkins 2000. All rights reserved. No part##
## of this or any of the attached documents shall be               ##
## reproduced/stored in any way whatsoever without written         ##
## permission from the Copyright holder.                           ##
##   The Copyright holder holds no responsibility for errors or    ##
## omissions. No liability is assumed in any way for damages       ##
## resulting from the use of this document/program.                ##
##                                                                 ##
## Have a nice day.                                                ##
##                                                                 ##
##                                                                 ##
##-----------------------------------------------------------------##

## By Lyle Hopkins ##

require 'dirpro.lib';
require 'dirprovar.lib';


##################################################
######################## Other variables
##################################################

use LWP::Simple; ## Needed to check for the return link
$linkexist = 0;
$cert = "f";


##################################################
######################## Adding site
##################################################

&get_post_data;
&get_get_data;
$cert = "f";
$linkexist = 0;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time); ## Get date
$year += 1900;

if ($WHATWANT{'want'} eq "addsite") {
  &addsite();
}
if ($WHATWANT{'want'} eq "addsitemaker") {
  print "Content-type: text/html\n\n";
  &addsitemaker();
}
if ($WHATWANT{'want'} eq "modpassword") {
  print "Content-type: text/html\n\n";
  &modpassword();
}
if ($WHATWANT{'want'} eq "modifypage") {
  print "Content-type: text/html\n\n";
  &modifypage();
}
if ($WHATWANT{'want'} eq "addmod") {
  &addmod();
}
if ($WHATWANT{'want'} eq "modcatdisplay") {
  print "Content-type: text/html\n\n";
  &modcatdisplay();
}


##################################################
######################## Submission handler
##################################################

sub addsite {

######################## Return link check
$content = get($FORM{'url'});
if ($content =~ /(A HREF=\"$myurl\")/gis) { $linkexist = 1; }
if ($tradeonly && $linkexist == 0) {
  print "Location: $needlinkpage\n\n";
  exit;
} ## End if tradeonly

######################## Certificate
foreach $cword (@certificate) {
  if ($FORM{'name'} =~ /\b$cword\b/) { $cert = "a"; }
  if ($FORM{'description'} =~ /\b$cword\b/) { $cert = "a"; }
} ## end loop

$FORM{'description'} =~ s/\n/ /gis;
$FORM{'description'} =~ s/\r/ /gis;

######################## Add submission
open(OUTF,">>$data/submissions.dta") || &errormessage("Could not open output file");
flock(OUTF,2);
  print OUTF
  "$FORM{'category'}¦$FORM{'name'}¦$FORM{'description'}¦$FORM{'url'}¦";
  for ($usernum = 1; $usernum < 11; $usernum++) {
    print OUTF
    "$FORM{\"user$usernum\"}¦";
  } ## end loop
  print OUTF
  "$cert¦$FORM{'affiliate'}¦$linkexist¦$FORM{'email'}¦$FORM{'password'}\n";
flock(OUTF,8);
close(OUTF); ## Close file

print "Location: $subcompletepage\n\n";

} ## End sub


##################################################
######################## Add site maker
##################################################

sub addsitemaker {

open (FILE, "$addsitepage");
  @addsitepagedone = <FILE>;
close (FILE);
$content = join('',@addsitepagedone);
$content =~ s/::category::/$WHATWANT{'category'}/gis;

print "$content";

} ## End sub


##################################################
######################## Category with modify links
##################################################

sub modcatdisplay {

$categoryname = $WHATWANT{'category'};
($categorynameshort2, $categorynameshort) = $categoryname =~ m!^(.+/)(.+)?$!;

unless ($categoryname =~ /\//) { $categorynameshort = $categoryname; } ## End unless

if (-e "$data/$categoryname/category.ads") {
  open(INF,"$data/$categoryname/category.ads");
    $adsdata = <INF>; ## Put into an array
  close(INF); ## Close file
  chomp($adsdata);
  ($bannerurl, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$email) = split(/¦/, $adsdata);
  open(FILE, "$categoryb");
    @categoryba = <FILE>;
  close(FILE);
  $categorybanner = join('',@categoryba);
  $categorybanner =~ s/::bannerurl::/$bannerurl/gis;
  $categorybanner =~ s/::siteurl::/$siteurl/gis;
  $categorybanner =~ s/::sitedescription::/$sitedescription/gis;
  $categorybanner =~ s/::u1::/$u1/gis;
  $categorybanner =~ s/::u2::/$u2/gis;
  $categorybanner =~ s/::u3::/$u3/gis;
  $categorybanner =~ s/::u4::/$u4/gis;
  $categorybanner =~ s/::u5::/$u5/gis;
  $categorybanner =~ s/::u6::/$u6/gis;
  $categorybanner =~ s/::u7::/$u7/gis;
  $categorybanner =~ s/::u8::/$u8/gis;
  $categorybanner =~ s/::u9::/$u9/gis;
  $categorybanner =~ s/::u10::/$u10/gis;

} ## End if

$addsitelink = "$programurl/submit.cgi?want=addsitemaker&category=$categoryname";

open(FILE, "$categoryp");
  @categorypa = <FILE>;
close(FILE);
$categorypage = join('',@categorypa);
$content = $categorypage;
$content =~ s/::addsitelink::/$addsitelink/gis;
$content =~ s/::catname::/$categoryname/gis;
$content =~ s/::catnameshort::/$categorynameshort/gis;
$content =~ s/::catnameshort2::/$categorynameshort2/gis;
$content =~ s/::banner::/$categorybanner/gis;
($pagetop, $pagemiddle1, $pagemiddle2, $pagebottom) = split(/::resultshere::/, $content);

print "$pagetop\n";

if (-e "$data/$categoryname/category.sub") {
  open(INF,"$data/$categoryname/category.sub");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  open(FILE, "$categoryc");
    @categoryca = <FILE>;
  close(FILE);
  $categorycat = join('',@categoryca);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    $content = $categorycat;
    $caturl = "$data_url/$categoryname/$catname";
    $content =~ s/::catname::/$catname/gis;
    $content =~ s/::caturl::/$caturl/gis;
    $content =~ s/::catdescription::/$catdescription/gis;
    print "$content\n";
  } ## End loop
}

  print "$pagemiddle1\n";

if (-e "$data/$categoryname/category.top") {
  open(INF,"$data/$categoryname/category.top");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  @userdata = sort(@userdata);
  open(FILE, "$categoryt");
    @categoryto = <FILE>;
  close(FILE);
  $categorytopsite = join('',@categoryto);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$ig1,$ig2,$email) = split(/¦/, $line);
    $content = $categorytopsite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    print "$content\n";
  } ## End loop
}

  print "$pagemiddle2\n";

if (-e "$data/$categoryname/category.dta") {
  open(INF,"$data/$categoryname/category.dta");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  @userdata = sort(@userdata);
  open(FILE, "$categorys");
    @categorysi = <FILE>;
  close(FILE);
  $categorysite = join('',@categorysi);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    if ($affiltrade) {
      push(@tradesites,$line);
    } ## End if
    else {
      push(@nontradesites,$line);
    } ## End else
  } ## End loop
  foreach $line (@tradesites) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    $content = $categorysite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $modifyurl = "$programurl/submit.cgi?want=modpassword&site=$sitename&category=$categoryname";
    $modifyhtmlb = $modifyhtml;
    $modifyhtmlb =~ s/::url::/$modifyurl/gis;
    $content =~ s/::modify::/$modifyhtmlb/gis;
    print "$content\n";
  } ## End loop
  foreach $line (@nontradesites) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    $content = $categorysite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $modifyurl = "$programurl/submit.cgi?want=modpassword&site=$sitename&category=$categoryname";
    $modifyhtmlb = $modifyhtml;
    $modifyhtmlb =~ s/::url::/$modifyurl/gis;
    $content =~ s/::modify::/$modifyhtmlb/gis;
    print "$content\n";
  } ## End loop
}

  print "$pagebottom\n";

} ## End sub


##################################################
######################## Password page
##################################################

sub modpassword {

open(FILE, "$modifypass");
  @modifypass = <FILE>;
close(FILE);
$content = join('',@modifypass);
$content =~ s/::category::/$WHATWANT{'category'}/gis;
$content =~ s/::site::/$WHATWANT{'site'}/gis;
print "$content";

} ## End sub


##################################################
######################## Modify page
##################################################

sub modifypage {

open(INF,"$data/$FORM{'category'}/category.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
  if ($sitename eq $FORM{'site'}) {
    $siteinfo = $line;
  } ## End if  
} ## End loop

($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $siteinfo);

if ($FORM{'password'} eq $password) {
  open(FILE, "$modifypage");
    @modifypage = <FILE>;
  close(FILE);
  $content = join('',@modifypage);
  $content =~ s/::siteurl::/$siteurl/gis;
  $content =~ s/::sitename::/$sitename/gis;
  $content =~ s/::sitenameold::/$sitename/gis;
  $content =~ s/::sitedescription::/$sitedescription/gis;
  $content =~ s/::u1::/$u1/gis;
  $content =~ s/::u2::/$u2/gis;
  $content =~ s/::u3::/$u3/gis;
  $content =~ s/::u4::/$u4/gis;
  $content =~ s/::u5::/$u5/gis;
  $content =~ s/::u6::/$u6/gis;
  $content =~ s/::u7::/$u7/gis;
  $content =~ s/::u8::/$u8/gis;
  $content =~ s/::u9::/$u9/gis;
  $content =~ s/::u10::/$u10/gis;
  $content =~ s/::email::/$email/gis;
  $content =~ s/::password::/$password/gis;
  $content =~ s/::cool::/$cool/gis;
  $content =~ s/::affiltrade::/$affiltrade/gis;
  $content =~ s/::category::/$FORM{'category'}/gis;
  $content =~ s/::site::/$FORM{'site'}/gis;
  print "$content";
} ## End if
else {
  print "Incorrect password";
} ## End else
} ## End sub


##################################################
######################## Add modification
##################################################

sub addmod {

open(INF,"$data/$FORM{'category'}/category.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
  if ($sitename eq $FORM{'site'}) {
    $siteinfo = $line;
  } ## End if  
} ## End loop

($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $siteinfo);

if ($FORM{'password'} eq $password) {

$content = get($FORM{'url'});
if ($content =~ /(A HREF=\"$myurl\")/gis) { $linkexist = 1; }
if ($tradeonly && $linkexist == 0) {
  print "Location: $needlinkpage\n\n";
  exit;
} ## End if tradeonly
######################## Certificate
foreach $cword (@certificate) {
  if ($FORM{'name'} =~ /\b$cword\b/) { $cert = "a"; }
  if ($FORM{'description'} =~ /\b$cword\b/) { $cert = "a"; }
} ## end loop
if ($FORM{'newpassword'} ne "") { $FORM{'password'} = $FORM{'newpassword'}; } ## End if

if ($automodify) {

print "Content-type: text/html\n\n";

if ($FORM{'affiltrade'} == 0 && $linkexist == 1) { $FORM{'affiltrade'} = 1; } ## End if

open(INF,"$data/$FORM{'category'}/category.dta") || &errormessage("Could not open category file"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/$FORM{'category'}/category.dta") || &errormessage("Could not open output file \"$FORM{'category'}/category.dta\"");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    if ($sitename eq $FORM{'sitenameold'}) {
      print OUTF
      "$FORM{'name'}¦$FORM{'description'}¦$FORM{'url'}¦";
      for ($usernum = 1; $usernum < 11; $usernum++) {
        $tempvar = "user$usernum";
        print OUTF
        "$FORM{$tempvar}¦";
      } ## end loop
      print OUTF
      "$FORM{'cert'}¦$FORM{'cool'}¦$FORM{'affiltrade'}¦$yday¦$year¦$FORM{'email'}¦$FORM{'password'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n";
    } ## End else
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml($FORM{'category'});

print "Done!";

} ## End if
else {

######################## Add submission
open(OUTF,">>$data/modify.dta") || &errormessage("Could not open output file");
flock(OUTF,2);
  print OUTF
  "$FORM{'site'}¦$FORM{'category'}¦$FORM{'name'}¦$FORM{'description'}¦$FORM{'url'}¦";
  for ($usernum = 1; $usernum < 11; $usernum++) {
    $tempvar = "user$usernum";
    print OUTF
    "$FORM{$tempvar}¦";
  } ## End loop
  print OUTF
  "$cert¦$FORM{'affiliate'}¦$linkexist¦$FORM{'email'}¦$FORM{'password'}\n";
flock(OUTF,8);
close(OUTF); ## Close file

print "Location: $subcompletepage\n\n";

} ## End else

} ## End if
else {
  print "Content-type: text/html\n\n";
  print "Incorrect password";
} ## End else

} ## End sub


##################################################
######################## Generate category HTML
##################################################

sub generatecathtml {

$categoryname = $_[0];
($categorynameshort2, $categorynameshort) = $categoryname =~ m!^(.+/)(.+)?$!;

unless ($categoryname =~ /\//) { $categorynameshort = $categoryname; } ## End unless

if (-e "$data/$categoryname/category.ads") {
  open(INF,"$data/$categoryname/category.ads");
    $adsdata = <INF>; ## Put into an array
  close(INF); ## Close file
  chomp($adsdata);
  ($bannerurl, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$email) = split(/¦/, $adsdata);
  open(FILE, "$categoryb");
    @categoryba = <FILE>;
  close(FILE);
  $categorybanner = join('',@categoryba);
  $categorybanner =~ s/::bannerurl::/$bannerurl/gis;
  $categorybanner =~ s/::siteurl::/$siteurl/gis;
  $categorybanner =~ s/::sitedescription::/$sitedescription/gis;
  $categorybanner =~ s/::u1::/$u1/gis;
  $categorybanner =~ s/::u2::/$u2/gis;
  $categorybanner =~ s/::u3::/$u3/gis;
  $categorybanner =~ s/::u4::/$u4/gis;
  $categorybanner =~ s/::u5::/$u5/gis;
  $categorybanner =~ s/::u6::/$u6/gis;
  $categorybanner =~ s/::u7::/$u7/gis;
  $categorybanner =~ s/::u8::/$u8/gis;
  $categorybanner =~ s/::u9::/$u9/gis;
  $categorybanner =~ s/::u10::/$u10/gis;

} ## End if

$addsitelink = "$programurl/submit.cgi?want=addsitemaker&category=$categoryname";
$modifysitelink = "$programurl/submit.cgi?want=modcatdisplay&category=$categoryname";

open(FILE, "$categoryp");
  @categorypa = <FILE>;
close(FILE);
$categorypage = join('',@categorypa);
$content = $categorypage;
$content =~ s/::addsitelink::/$addsitelink/gis;
$content =~ s/::modifysitelink::/$modifysitelink/gis;
$content =~ s/::catname::/$categoryname/gis;
$content =~ s/::catnameshort::/$categorynameshort/gis;
$content =~ s/::catnameshort2::/$categorynameshort2/gis;
$content =~ s/::banner::/$categorybanner/gis;
($pagetop, $pagemiddle1, $pagemiddle2, $pagebottom) = split(/::resultshere::/, $content);

open(OUTF,">$data/$categoryname/index.html") || &errormessage("Could not open output file index.html");
flock(OUTF,2);

  print OUTF
  "$pagetop\n";

if (-e "$data/$categoryname/category.sub") {
  open(INF,"$data/$categoryname/category.sub");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file

  $cat_matches = @userdata;

  if ($cat_matches < 1) {
    print OUTF "$nocatincattext\n";
  } ## End if

  open(FILE, "$categoryc");
    @categoryca = <FILE>;
  close(FILE);
  $categorycat = join('',@categoryca);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    $content = $categorycat;
    $caturl = "$data_url/$categoryname/$catname";
    $content =~ s/::catname::/$catname/gis;
    $content =~ s/::caturl::/$caturl/gis;
    $content =~ s/::catdescription::/$catdescription/gis;
    print OUTF
    "$content\n";
  } ## End loop
} ## End if
else {
  print OUTF "$nocatincattext\n";
} ## End else

  print OUTF
  "$pagemiddle1\n";

if (-e "$data/$categoryname/category.top") {
  open(INF,"$data/$categoryname/category.top");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  @userdata = sort(@userdata);
  $site_matches = @userdata;

  open(FILE, "$categoryt");
    @categoryto = <FILE>;
  close(FILE);
  $categorytopsite = join('',@categoryto);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$ig1,$ig2,$email) = split(/¦/, $line);
    $content = $categorytopsite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    print OUTF
    "$content\n";
  } ## End loop
} ## End if
else {
  $site_matches = 0;
} ## End else

  print OUTF
  "$pagemiddle2\n";

if (-e "$data/$categoryname/category.dta") {
  open(INF,"$data/$categoryname/category.dta");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  @userdata = sort(@userdata);
  $site_matches_tmp = @userdata;
  $site_matches += $site_matches_tmp;

  if ($site_matches < 1) {
    print OUTF "$nositesincattext";
  } ## End if

  open(FILE, "$categorys");
    @categorysi = <FILE>;
  close(FILE);
  $categorysite = join('',@categorysi);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    if ($affiltrade) {
      push(@tradesites,$line);
    } ## End if
    else {
      push(@nontradesites,$line);
    } ## End else
  } ## End loop
  foreach $line (@tradesites) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    $content = $categorysite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $content =~ s/::modify:://gis;
    print OUTF
    "$content\n";
  } ## End loop
  foreach $line (@nontradesites) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    $content = $categorysite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $content =~ s/::modify:://gis;
    print OUTF
    "$content\n";
  } ## End loop
} ## End if
else {
  if ($site_matches < 1) { 
    print OUTF "$nositesincattext";
  } ## End if
} ## End else

  print OUTF
  "$pagebottom\n";

flock(OUTF,8);
close(OUTF); ## Close file

} ## End sub



