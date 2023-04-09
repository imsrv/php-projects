#!/usr/local/bin/perl
##-----------------------------------------------------------------##
##                                                                 ##
##                                                                 ##
## © Copyright Mr Lyle R Hopkins 2001. All rights reserved. No part##
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

##################################################
######################## Other variables
##################################################

print "Content-type: text/html\n\n";

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
  ($name, $value) = split(/=/, $pair);
  $value =~ tr/+/ /;
  $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
  $FORM{$name} = $value;
}

@values = split(/\&/,$ENV{'QUERY_STRING'});
foreach $i (@values) {
  ($varname, $mydata) = split(/=/,$i);
  $mydata =~ tr/+/ /;
  $mydata =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
  $WHATWANT{$varname} = $mydata;
}


($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time); ## Get date
$year += 1900;

if ($WHATWANT{'want'} eq "start") {
  &chmodcheck;
  &start;
  exit;
}
if ($WHATWANT{'want'} eq "start2") {
  &start;
  exit;
}
if ($WHATWANT{'want'} eq "step1") {
  &step1;
  exit;
}
if ($WHATWANT{'want'} eq "step2") {
  &step2;
  exit;
}
if ($WHATWANT{'want'} eq "step3") {
  &step3;
  exit;
}


open(FILE, "install.html");
  @install = <FILE>;
close(FILE);
$content = join('',@install);
print "$content";


sub chmodcheck {

chmod(0777, "adminpass.txt") || &chmoderror;

} ## End sub


sub chmoderror {

open(FILE, "installchmod.html");
  @installchmod = <FILE>;
close(FILE);
$content = join('',@installchmod);
print "$content";
exit;

} ## End sub


##################################################
######################## Start
##################################################

sub start {

open(FILE, "installt1.html");
  @installt1 = <FILE>;
close(FILE);
$content = join('',@installt1);

$url = $ENV{'HTTP_REFERER'};
$url =~ s/\/install.cgi//gis;
$url =~ /(http:\/\/.*?\/)/gis;
$urldomain = $1;

$content =~ s/::url::/$url/gis;
$content =~ s/::urldomain::/$urldomain/gis;
print "$content";

} ## End sub

sub step1 {

open(FILE, "installt2.html");
  @installt2 = <FILE>;
close(FILE);
$content = join('',@installt2);
$content =~ s/::programurl::/$FORM{'programurl'}/gis;
$content =~ s/::data::/$FORM{'data'}/gis;
$content =~ s/::data_url::/$FORM{'data_url'}/gis;
$content =~ s/::subcompletepage::/$FORM{'subcompletepage'}/gis;
$content =~ s/::urldomain::/$FORM{'urldomain'}/gis;
print "$content";

} ## End sub


sub step2 {

if ($FORM{'tradeonly'} == 2) {
  print "<HTML><BODY><font size=4><b>Invalid</b> selection, please use you browsers back button and select yes or no from the selection box</font></BODY></HTML>";
  exit;
} ## End if

open(FILE, "installt3.html");
  @installt3 = <FILE>;
close(FILE);
$content = join('',@installt3);
$content =~ s/::programurl::/$FORM{'programurl'}/gis;
$content =~ s/::data::/$FORM{'data'}/gis;
$content =~ s/::data_url::/$FORM{'data_url'}/gis;
$content =~ s/::subcompletepage::/$FORM{'subcompletepage'}/gis;
$content =~ s/::urldomain::/$FORM{'urldomain'}/gis;
$content =~ s/::tradeonly::/$FORM{'tradeonly'}/gis;
$content =~ s/::needlinkpage::/$FORM{'needlinkpage'}/gis;
$content =~ s/::certificate::/$FORM{'certificate'}/gis;
$content =~ s/::maxsiteshow::/$FORM{'maxsiteshow'}/gis;
$content =~ s/::maxcatshow::/$FORM{'maxcatshow'}/gis;

print "$content";

} ## End sub


sub step3 {

if ($FORM{'automodify'} == 2) {
  print "<HTML><BODY><font size=4><b>Invalid</b> selection, please use you browsers back button and select yes or no from the selection box</font></BODY></HTML>";
  exit;
} ## End if

chmod(0777, "dirprovar.lib");
open(OUTF,">dirprovar.lib");
  print OUTF
"##################################################
######################## Define variables
##################################################

\$data = \"$FORM{'data'}\";
\$programurl = \"$FORM{'programurl'}\";
\$data_url = \"$FORM{'data_url'}\";
\$needlinkpage = \"$FORM{'needlinkpage'}\";
\$subcompletepage = \"$FORM{'subcompletepage'}\";
\$tradeonly = $FORM{'tradeonly'};
";

@certificate = split(/,/, $FORM{'certificate'});

print OUTF "\@certificate = (";

foreach $line (@certificate) {
  chomp($line);
  print OUTF "\"$line\"";
  unless ($certificate[$#certificate] eq $line) { print OUTF ","; } ## End if
} ## End loop

print OUTF ");
\$categoryp = \"categoryp.tpl\"; ## Category page template
\$categorys = \"categorys.tpl\"; ## Category sites template
\$categoryt = \"categoryt.tpl\"; ## Category topsites template
\$categoryc = \"categoryc.tpl\"; ## Category subcat template
\$categoryb = \"categoryb.tpl\"; ## Category banner template
\$searchresultsp = \"searchresultsp.tpl\"; ## Search results page template
\$searchresultsb = \"searchresultsb.tpl\"; ## Search results banner template
\$searchresultss = \"searchresultss.tpl\"; ## Search results sites template
\$searchresultst = \"searchresultst.tpl\"; ## Search results topsites template
\$searchresultsc = \"searchresultsc.tpl\"; ## Search results categories template
\$maxcatshow = $FORM{'maxcatshow'}; ## Maximum number of categories to show per page
\$maxsiteshow = $FORM{'maxsiteshow'}; ## Maximum number of sites to show per page
\$coolsitelogo = \"$FORM{'coolsitelogo'}\";
\$nextresultslink = '$FORM{'nextresultslink'}';
\$addsitepage = \"addsite.tpl\";
\$modifyhtml = '$FORM{'modifyhtml'}';
\$modifypass = \"modifypass.tpl\"; ## Template for modify password page
\$modifypage = \"modifypage.tpl\"; ## Template for modify page
\$automodify = $FORM{'automodify'}; ## 1 for auto modify, 0 for submission
\$nositeresultstext = \"No matching sites\"; ## HTML for no site search results
\$nocatresultstext = \"No matching categories\"; ## HTML for no category search results
\$nositesincattext = \"No sites in this category\"; ## HTML for no sites in category
\$nocatincattext = \"No sub-categories in this category\"; ## HTML for no sub-categories in category


1;";
close(OUTF); ## Close file


chmod(0777, "dirpro.lib");
chmod(0777, "dirprovar.lib");
chmod(0777, "manager.cgi");
chmod(0777, "search.cgi");
chmod(0755, "search2.cgi");
chmod(0777, "submit.cgi");

open(FILE, "install.cgi");
  $perlpath = <FILE>;
close(FILE);

open(FILE, "manager.cgi");
  @maninput = <FILE>;
close(FILE);
$maninput[0] = "$perlpath";
open(OUTF,">manager.cgi");
  foreach $line (@maninput) {
    print OUTF "$line";
  } ## End loop
close(OUTF);

open(FILE, "search.cgi");
  @searcher = <FILE>;
close(FILE);
$searcher[0] = "$perlpath";
open(OUTF,">search.cgi");
  foreach $line (@searcher) {
    print OUTF "$line";
  } ## End loop
close(OUTF);

open(FILE, "submit.cgi");
  @submiter = <FILE>;
close(FILE);
$submiter[0] = "$perlpath";
open(OUTF,">submit.cgi");
  foreach $line (@submiter) {
    print OUTF "$line";
  } ## End loop
close(OUTF);

chmod(0755, "manager.cgi");
chmod(0755, "search.cgi");
chmod(0755, "submit.cgi");

mkdir("$FORM{'data'}", 0777);
chmod(0777, "$FORM{'data'}");

open(FILE, "installt4.html");
  @installt4 = <FILE>;
close(FILE);
$content = join('',@installt4);

$adminstyle1 = "*.pU8Tz9HKBtM";
$adminstyle2 = "*.pbnMU1TaBfU";
$passcrypt = crypt("adminpass", substr($adminstyle1, 0, 2));
if ($passcrypt ne $adminstyle1){
  $passcrypt = crypt("adminpass", substr($adminstyle2, 0, 2));
  if ($passcrypt ne $adminstyle2){
    $content =~ s/::badadminpass::/"There is a problem with your server encryption capabilities."/gis;
  } ## End if
  else {
    $content =~ s/::badadminpass:://gis;
  } ## End else
} ## End if
else {
  $content =~ s/::badadminpass:://gis;
} ## End else

chmod(0777, "adminpass.txt");

open(OUTF,">adminpass.txt");
  print OUTF "admin:$passcrypt";
close(OUTF);

$url = $ENV{'HTTP_REFERER'};
$url =~ s/\/install.cgi\?want=step2//gis;

$btrack = "";
$content =~ s/::bt::/$btrack/gis;

print "$content";

} ## End sub












