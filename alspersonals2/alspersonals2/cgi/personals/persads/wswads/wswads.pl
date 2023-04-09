#!/usr/bin/perl -w
################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################

use CGI::Carp qw(fatalsToBrowser);
use CGI qw(:standard);
$query = new CGI;
########################################################################################################################

require "../../configdat.lib";
require "../../variables.lib";
require "../../gensubs.lib";
require "../../validate.lib";
require "../../defaulttext.lib";

print "Content-type:text/html\n\n";

print <<EOF;

$mainheader
<table width=100% cellpadding=0 cellspacing=0 bgcolor=$adpagesmainbgcolor><tr><td>

<table width=100% cellpadding=0 cellspacing=0 border=0 bgcolor=$adcategorybgcolor><tr><td>
<td width=50>&nbsp;</td><td><br><font size=2 face=verdana><b>WOMEN SEEKING WOMEN</b></font><br><br></td>
<td>&nbsp;</td></tr></table>

<table width=100% cellpadding=0 cellspacing=0><tr>
<td width=20% bgcolor=$adpagesleftcolumnbgcolor valign="top">
$menumain</td>
<td width=80% valign="top">
$wswcontenttop
<table width=100% cellpadding=0 cellspacing=0 border=0><tr><td>
<ol>
EOF


$showthisnum = 11;
$wherebeginct=0;
$wherebeginct = $query->param('begincthere');
unless($query->param('begincthere')){
$wherebeginct=0;}



$end = ($wherebeginct + $showthisnum);
opendir(DIR, "$persadscgidir/wswads/ads");
@docs=readdir(DIR);
closedir(DIR);
$numdocs=@docs;
$adnumdocs=$numdocs - 2;

foreach $doc(@docs){
unless(($doc eq ".")||($doc eq "..")){

open(IN, "$persadscgidir/wswads/ads/$doc");
@lines=<IN>;
close(IN);
$stlns = 250 * $adnumdocs;
$ttlns=@lines;
$adjustedttlns=($stlns-250)+$ttlns;
$tlns=$adjustedttlns;


if($end > $tlns){ $end = $tlns }

for( $i = $wherebeginct; $i < $end; $i++ ){
&pln($line);
}
}
}

if($tlns > $end) {
print "<div align=\"center\"><b><a href=\"wswads.pl?begincthere=$end\">Next</a></b></div>\n";}

if($wherebeginct > 0) {
$prev = ($wherebeginct - $showthisnum);
print "<div align=\"center\"><b><a href=\"wswads.pl?begincthere=$prev\">Previous</a></b></div>\n";
}




print <<EOF;
<br><br>
$wswcontentbottom
</td></tr></table>
</td></tr></table>
</td></tr></table>
$botcode

EOF


1;