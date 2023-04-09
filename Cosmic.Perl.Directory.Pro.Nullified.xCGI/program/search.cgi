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

print "Content-type: text/html\n\n";

require 'dirpro.lib';
require 'dirprovar.lib';

##################################################
######################## Other variables
##################################################

&get_get_data;


##################################################
######################## Searching thing
##################################################

(@searchterms) = split(/ /, $WHATWANT{'terms'});
$familyfilter = 0;
if ($WHATWANT{'family'} eq "ON") {
  $familyfilter = 1;
} ## End if

$optimumtermsmatch = @searchterms;
$more_results = 0;
$site_matches = 0;
$results_froms = 0;
$results_fromc = 0;
if (exists $WHATWANT{'results'}) { 
  $results_froms = $WHATWANT{'results'} * $maxsiteshow;
  $results_fromc = $WHATWANT{'results'} * $maxcatshow;
  $maxsiteshow = ($WHATWANT{'results'} + 1) * $maxsiteshow;
  $maxcatshow = ($WHATWANT{'results'} + 1) * $maxcatshow;
} ## End if

if (-e "$data/advertise.dta") {
  open(INF,"$data/advertise.dta");
    @adsdataa = <INF>; ## Put into an array
  close(INF); ## Close file
  foreach $adsdata (@adsdataa) {
    chomp($adsdata);
    ($bannerurl, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$keywords,$email) = split(/¦/, $adsdata);
    if ($keywords =~ /,$WHATWANT{'terms'},/) {
      open(FILE, "$searchresultsb");
        @searchresultsba = <FILE>;
      close(FILE);
      $searchbanner = join('',@searchresultsba);
      $searchbanner =~ s/::bannerurl::/$bannerurl/gis;
      $searchbanner =~ s/::siteurl::/$siteurl/gis;
      $searchbanner =~ s/::sitedescription::/$sitedescription/gis;
      $searchbanner =~ s/::u1::/$u1/gis;
      $searchbanner =~ s/::u2::/$u2/gis;
      $searchbanner =~ s/::u3::/$u3/gis;
      $searchbanner =~ s/::u4::/$u4/gis;
      $searchbanner =~ s/::u5::/$u5/gis;
      $searchbanner =~ s/::u6::/$u6/gis;
      $searchbanner =~ s/::u7::/$u7/gis;
      $searchbanner =~ s/::u8::/$u8/gis;
      $searchbanner =~ s/::u9::/$u9/gis;
      $searchbanner =~ s/::u10::/$u10/gis;
    } ## End if
  } ## End loop
} ## End if

open(FILE, "$searchresultsp");
  @searchresultspa = <FILE>;
close(FILE);
$searchresultspage = join('',@searchresultspa);
$content = $searchresultspage;
$content =~ s/::terms::/$WHATWANT{'terms'}/gis;
$content =~ s/::banner::/$searchbanner/gis;
($pagetop, $pagemiddle1, $pagemiddle2, $pagebottom) = split(/::resultshere::/, $content);

$resultspagedone = $pagetop;

open(INF,"$data/catsearchdata.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(FILE, "$searchresultsc");
  @searchresultsca = <FILE>;
close(FILE);
$searchresultscat = join('',@searchresultsca);
foreach $line (@userdata) {
  chomp($line);
  ($catname, $catdescription) = split(/¦/, $line);
  if ($catname =~ /\//) {
    ($catnameshort2, $catnameshort) = $catname =~ m!^(.+/)(.+)?$!;
    chop($catnameshort2);
  } ## End if
  else { $catnameshort = $catname; $catnameshort2 = ""; }
  $categorymatch = 0;
  foreach $term (@searchterms) {
    if ($catnameshort =~ /\b$term\b/gis) { $categorymatch++; }
    if ($catdescription =~ /\b$term\b/gis) { $categorymatch++; }
  } ## End loop
  if ($categorymatch > 0) {
    if ($categorymatch < 10) { $categorymatch = "0$categorymatch"; }
    push(@matching_categories, "$categorymatch¦$catname¦$catnameshort¦$catnameshort2¦$catdescription");
  } ## End if
} ## End loop
@matching_categories = sort { $b <=> $a }@matching_categories;
$cat_matches = @matching_categories;

if ($cat_matches < 1) {
  $resultspagedone .= $nocatresultstext;
} ## End if

$num_shown = 0;
while ($num_shown <= ($maxcatshow - 1) && $matching_categories[$num_shown] ne "") {
 if ($num_shown >= $results_fromc) {
  ($categorymatch, $catname, $catnameshort, $catnameshort2, $catdescription) = split(/¦/, $matching_categories[$num_shown]);
  $num_shown++;
  $content = $searchresultscat;
  $caturl = "$data_url/$catname";
  $content =~ s/::catname::/$catname/gis;
  $content =~ s/::caturl::/$caturl/gis;
  $content =~ s/::catnameshort::/$catnameshort/gis;
  $content =~ s/::catnameshort2::/$catnameshort2/gis;
  $content =~ s/::catdescription::/$catdescription/gis;
  $content =~ s/::catnumber::/$num_shown/gis;
  $content =~ s/::catmatch::/$categorymatch/gis;
  $resultspagedone .= $content;
 } ## End if
 else { $num_shown++; }
} ## End loop
if ($matching_categories[$maxcatshow] ne "") { $more_results = 1; }


$resultspagedone .= $pagemiddle1;

if (-e "$data/topsites.dta") {
  open(INF,"$data/topsites.dta");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  open(FILE, "$searchresultst");
    @$searchresultsto = <FILE>;
  close(FILE);
  $searchresultstopsite = join('',@$searchresultsto);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $sitename,$sitedescription,$siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$email) = split(/¦/, $line);
    $sitematch = 0;
    foreach $term (@searchterms) {
      &sitematcher;
    } ## End loop
    if ($sitematch > 0) {
      if ($sitematch < 10) { $sitematch = "0$sitematch"; }
      if ($familyfilter && $cert ne "a") {
        push(@matching_sites, "$sitematch¦$line");
      } ## End if
      unless ($familyfilter) {
        push(@matching_sites, "$sitematch¦$line");
      } ## End unless
    } ## End if
  } ## End loop
  @matching_sites = sort { $b <=> $a }@matching_sites;
  $site_matches_tmp = @matching_sites;
  $site_matches += $site_matches_tmp;
  $num_shown = 0;
  while ($num_shown <= ($maxsiteshow - 1) && $matching_sites[$num_shown] ne "") {
   if ($num_shown >= $results_froms) {
    ($sitematch, $catname, $sitename,$sitedescription,$siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$email) = split(/¦/, $matching_sites[$num_shown]);
    $num_shown++;
    if ($catname =~ /\//) {
      ($catnameshort2, $catnameshort) = $catname =~ m!^(.+/)(.+)?$!;
      chop($catnameshort2);
    } ## End if
    else { $catnameshort = $catname; $catnameshort2 = ""; }
    $content = $searchresultstopsite;
    $caturl = "$data_url/$catname";
    $content =~ s/::caturl::/$caturl/gis;
    $content =~ s/::catname::/$catname/gis;
    $content =~ s/::catnameshort::/$catnameshort/gis;
    $content =~ s/::catnameshort2::/$catnameshort2/gis;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitematch::/$sitematch/gis;
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
    $content =~ s/::sitenumber::/$num_shown/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $resultspagedone .= $content;
   } ## End if
   else { $num_shown++; }
  } ## End loop
}
if ($matching_sites[$maxsiteshow] ne "") { $more_results = 1; }

$resultspagedone .= $pagemiddle2;

open(INF,"$data/searchdata.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(FILE, "$searchresultss");
  @searchresultssi = <FILE>;
close(FILE);
$searchresultssite = join('',@searchresultssi);
foreach $line (@userdata) {
  chomp($line);
  ($catname, $sitename,$sitedescription,$siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$affiltrade,$cool,$email) = split(/¦/, $line);
  $sitematch = 0;
  foreach $term (@searchterms) {
    &sitematcher;
  } ## End loop
  if ($sitematch > 0) {
    if ($sitematch < 10) { $sitematch = "0$sitematch"; }
    if ($familyfilter && $cert ne "a") {
      if ($affiltrade) {
        push(@matching_tradesites, "$sitematch¦$line");
      } ## End if
      else {
        push(@matching_nontradesites, "$sitematch¦$line");
      } ## End else
    } ## End if
    unless ($familyfilter) {
      if ($affiltrade) {
        push(@matching_tradesites, "$sitematch¦$line");
      } ## End if
      else {
        push(@matching_nontradesites, "$sitematch¦$line");
      } ## End else
    } ## End unless
  } ## End if
} ## End loop
@matching_tradesites = sort { $b <=> $a }@matching_tradesites;
$site_matches_tmp = @matching_tradesites;
$site_matches += $site_matches_tmp;
@matching_nontradesites = sort { $b <=> $a }@matching_nontradesites;
$site_matches_tmp = @matching_nontradesites;
$site_matches += $site_matches_tmp;
if (exists $WHATWANT{'results'}) { $num_showna = $results_froms; } ## End if
else { $num_showna = 0; } ## End else
while ($num_shown <= ($maxsiteshow - 1) && $matching_tradesites[$num_showna] ne "") {
 if ($num_shown >= $results_froms) {
  ($sitematch, $catname, $sitename,$sitedescription,$siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$affiltrade,$cool,$email) = split(/¦/, $matching_tradesites[$num_showna]);
  $num_shown++;
  $num_showna++;
  if ($catname =~ /\//) {
    ($catnameshort2, $catnameshort) = $catname =~ m!^(.+/)(.+)?$!;
    chop($catnameshort2);
  } ## End if
  else { $catnameshort = $catname; $catnameshort2 = ""; }
  $content = $searchresultssite;
  $caturl = "$data_url/$catname";
  $content =~ s/::caturl::/$caturl/gis;
  $content =~ s/::catname::/$catname/gis;
  $content =~ s/::catnameshort::/$catnameshort/gis;
  $content =~ s/::catnameshort2::/$catnameshort2/gis;
  $content =~ s/::siteurl::/$siteurl/gis;
  $content =~ s/::sitename::/$sitename/gis;
  $content =~ s/::sitematch::/$sitematch/gis;
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
  $content =~ s/::sitenumber::/$num_shown/gis;
  if ($cool) {
    $content =~ s/::coolsite::/$coolsitelogo/gis;
  } ## End if
  $content =~ s/::coolsite:://gis;
  $content =~ s/::modify:://gis;
  $resultspagedone .= $content;
 } ## End if
 else { $num_shown++; }
} ## End loop
if (exists $WHATWANT{'results'}) { $num_showna = $results_froms; } ## End if
else { $num_showna = 0; } ## End else
while ($num_shown <= ($maxsiteshow - 1) && $matching_nontradesites[$num_showna] ne "") {
 if ($num_shown >= $results_froms) {
  ($sitematch,$catname,$sitename,$sitedescription,$siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$affiltrade,$cool,$email) = split(/¦/, $matching_nontradesites[$num_showna]);
  $num_shown++;
  $num_showna++;
  if ($catname =~ /\//) {
    ($catnameshort2, $catnameshort) = $catname =~ m!^(.+/)(.+)?$!;
    chop($catnameshort2);
  } ## End if
  else { $catnameshort = $catname; $catnameshort2 = ""; }
  $content = $searchresultssite;
  $caturl = "$data_url/$catname";
  $content =~ s/::caturl::/$caturl/gis;
  $content =~ s/::catname::/$catname/gis;
  $content =~ s/::catnameshort::/$catnameshort/gis;
  $content =~ s/::catnameshort2::/$catnameshort2/gis;
  $content =~ s/::siteurl::/$siteurl/gis;
  $content =~ s/::sitename::/$sitename/gis;
  $content =~ s/::sitematch::/$sitematch/gis;
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
  $content =~ s/::sitenumber::/$num_shown/gis;
  if ($cool) {
    $content =~ s/::coolsite::/$coolsitelogo/gis;
  } ## End if
  $content =~ s/::modify:://gis;
  $content =~ s/::coolsite:://gis;
  $resultspagedone .= $content;
 } ## End if
 else { $num_shown++; }
} ## End loop
if ($matching_tradesites[$maxsiteshow] ne "") { $more_results = 1; }
if ($matching_nontradesites[$maxsiteshow] ne "") { $more_results = 1; }

if ($site_matches < 1) {
  $resultspagedone .= $nositeresultstext;
} ## End if

$resultspagedone .= $pagebottom;

if ($more_results) {
  if (exists $WHATWANT{'results'}) { $resultsurl = $WHATWANT{'results'} + 1; }
  else { $resultsurl = 1; }
  $nextresultslinkurl = "$programurl/search.cgi?terms=$WHATWANT{'terms'}&results=$resultsurl&field=$WHATWANT{'field'}";
  $nextresultslink =~ s/::url::/$nextresultslinkurl/gis;
  $resultspagedone =~ s/::nextresults::/$nextresultslink/gis;
} ## End if
else { $resultspagedone =~ s/::nextresults:://gis; }
print "$resultspagedone";


###############################################
###################### Site matcher
###############################################

sub sitematcher {

      if ($WHATWANT{'field'} eq "" || $WHATWANT{'field'} eq "normal") {
        if ($sitename =~ /\b$term\b/gis) { $sitematch++; }
        if ($sitedescription =~ /\b$term\b/gis) { $sitematch++; }
      } ## End if
      elsif ($WHATWANT{'field'} eq "u1") { if ($u1 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u2") { if ($u2 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u3") { if ($u3 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u4") { if ($u4 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u5") { if ($u5 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u6") { if ($u6 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u7") { if ($u7 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u8") { if ($u8 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u9") { if ($u9 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "u10") { if ($u10 =~ /\b$term\b/gis) { $sitematch++; } } ## End elsif
      elsif ($WHATWANT{'field'} eq "all") {
        if ($sitename =~ /\b$term\b/gis) { $sitematch++; }
        if ($sitedescription =~ /\b$term\b/gis) { $sitematch++; }
        if ($u1 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u2 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u3 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u4 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u5 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u6 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u7 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u8 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u9 =~ /\b$term\b/gis) { $sitematch++; }
        if ($u10 =~ /\b$term\b/gis) { $sitematch++; }
      } ## End elsif

} ## End sub





