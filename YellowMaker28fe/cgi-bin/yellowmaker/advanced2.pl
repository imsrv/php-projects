#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# advanced2.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
do "cookie.lib";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&parse_form;

$form{'name'} =~ s/^\s+//;
$form{'name'} =~ s/\s+$//;  
$form{'establish'} =~ s/^\s+//;
$form{'establish'} =~ s/\s+$//;  
$form{'address1'} =~ s/^\s+//;
$form{'address1'} =~ s/\s+$//;  
$form{'address2'} =~ s/^\s+//;
$form{'address2'} =~ s/\s+$//;  
$form{'city'} =~ s/^\s+//;
$form{'city'} =~ s/\s+$//;  
$form{'state'} =~ s/^\s+//;
$form{'state'} =~ s/\s+$//;  
$form{'zipcode'} =~ s/^\s+//;
$form{'zipcode'} =~ s/\s+$//;  
$form{'country'} =~ s/^\s+//;
$form{'country'} =~ s/\s+$//;  
$form{'phone'} =~ s/^\s+//;
$form{'phone'} =~ s/\s+$//;  
$form{'fax'} =~ s/^\s+//;
$form{'fax'} =~ s/\s+$//;  
$form{'companyemailaddress'} =~ s/^\s+//;
$form{'companyemailaddress'} =~ s/\s+$//;  
$form{'homepage'} =~ s/^\s+//;
$form{'homepage'} =~ s/\s+$//;  
$form{'category'} =~ s/^\s+//;
$form{'category'} =~ s/\s+$//;
$category=$form{'category'};
$form{'keys'} =~ s/^\s+//;
$form{'keys'} =~ s/\s+$//;

if ($form{'goto'}) {
&header;
&top;
&include("/$sub/$sub9/advanced.htm");
&bottom;
exit;
}

if ($form{'searchtype'} eq "1") {
if (!$form{'keys'}) {
$message="Please enter one or more search terms in the search box.";
&error;
}
if ($form{'keys'} !~ /^[0-9a-zA-Z"]/i) { 
$message="Please enter one or more search terms in the search box.";
&error;
}
}

if (!($form{'category'})) {
$form{'category'}="Doesn't Matter";
}

if (!($form{'name'})) {
$form{'name'}="Doesn't Matter";
}

if (!($form{'establish'})) {
$form{'establish'}="Doesn't Matter";
}

if (!($form{'address1'})) {
$form{'address1'}="Doesn't Matter";
}

if (!($form{'address2'})) {
$form{'address2'}="Doesn't Matter";
}

if (!($form{'city'})) {
$form{'city'}="Doesn't Matter";
}

if (!($form{'state'})) {
$form{'state'}="Doesn't Matter";
}

if (!($form{'zipcode'})) {
$form{'zipcode'}="Doesn't Matter";
}

if (!($form{'country'})) {
$form{'country'}="Doesn't Matter";
}

if (!($form{'phone'})) {
$form{'phone'}="Doesn't Matter";
}

if (!($form{'fax'})) {
$form{'fax'}="Doesn't Matter";
}

if (!($form{'companyemailaddress'})) {
$form{'companyemailaddress'}="Doesn't Matter";
}

if ((!($form{'homepage'})) || ($form{'homepage'} eq "http://")) {
$form{'homepage'}="Doesn't Matter";
}

if ($form{'searchtype'} eq "2") {
$form{'dateadd'}="Doesn't Matter";
$form{'datemod'}="Doesn't Matter";
$form{'id'}="Doesn't Matter";
$form{'ip'}="Doesn't Matter";
$form{'emailaddr'}="Doesn't Matter";
}

if ($form{'back'}) { 
&checksearchsession;
if (!$form{'keys'}) {
$form{'id'}="Doesn't Matter";
$form{'ip'}="Doesn't Matter";
$form{'host'}="Doesn't Matter";
$form{'dateadd'}="Doesn't Matter";
$form{'datemod'}="Doesn't Matter";
$form{'emailaddr'}="Doesn't Matter";
}
}

&createsearchsession;

&header;
&top;

$search_results=0;
$recno=0;
$counter=0;

if ($display > $form{'end'}){$form{'end'} eq "$display";} 
if (!$form{'begin'}){$form{'begin'}=1;}
if (!$form{'end'}){$form{'end'}=$display;}

$begin=$form{'end'}+1;
$end=$form{'end'}+$display;

open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (sort{uc($a) cmp uc($b)}(<DATABASE>)) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;

if (($matched == 1) && (($name =~ /$form{'name'}/gi) || ($form{'name'} eq "Doesn't Matter")) && (($id =~ /$form{'id'}/gi) ||  ($form{'id'} eq "Doesn't Matter")) && (($ip =~ /$form{'ip'}/gi) || ($form{'ip'} eq "Doesn't Matter")) && (($host =~ /$form{'host'}/gi) || ($form{'host'} eq "Doesn't Matter")) && (($dateadd =~ /$form{'dateadd'}/gi) || ($form{'dateadd'} eq "Doesn't Matter")) && (($datemod =~ /$form{'datemod'}/gi) || ($form{'datemod'} eq "Doesn't Matter")) && (($category =~ /$form{'category'}/gi) || ($form{'category'} eq "Doesn't Matter")) && (($emailaddr =~ /$form{'emailaddr'}/gi) || ($form{'emailaddr'} eq "Doesn't Matter")) && (($establish =~ /$form{'establish'}/gi) || ($form{'establish'} eq "Doesn't Matter")) && (($address1 =~ /$form{'address1'}/gi) || ($form{'address1'} eq "Doesn't Matter")) && (($address2 =~ /$form{'address2'}/gi) || ($form{'address2'} eq "Doesn't Matter")) && (($city =~ /$form{'city'}/gi) || ($form{'city'} eq "Doesn't Matter")) && (($state =~ /$form{'state'}/gi) || ($form{'state'} eq "Doesn't Matter")) && (($zipcode =~ /$form{'zipcode'}/gi) || ($form{'zipcode'} eq "Doesn't Matter")) && (($country =~ /$form{'country'}/gi) || ($form{'country'} eq "Doesn't Matter")) && (($phone =~ /$form{'phone'}/gi) || ($form{'phone'} eq "Doesn't Matter")) && (($fax =~ /$form{'fax'}/gi) || ($form{'fax'} eq "Doesn't Matter")) && (($companyemailaddress =~ /$form{'companyemailaddress'}/gi) || ($form{'companyemailaddress'} eq "Doesn't Matter")) && (($hompage =~ /$form{'homepage'}/gi) || ($form{'homepage'} eq "Doesn't Matter"))) {

$search_results=$search_results+1;

}
}
close DATABASE;

if ($search_results <= $form{'end'}){
$search_limit="on";
} else {
$search_limit="";
}

$redirect="advanced2.pl";
if ($search_results != 0) {
$top_index=1;
$total_profiles=$search_results;
}
&print_top;

open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (sort{uc($a) cmp uc($b)}(<DATABASE>))  {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;

if (($matched == 1) && (($name =~ /$form{'name'}/gi) || ($form{'name'} eq "Doesn't Matter")) && (($id =~ /$form{'id'}/gi) ||  ($form{'id'} eq "Doesn't Matter")) && (($ip =~ /$form{'ip'}/gi) || ($form{'ip'} eq "Doesn't Matter")) && (($host =~ /$form{'host'}/gi) || ($form{'host'} eq "Doesn't Matter")) && (($dateadd =~ /$form{'dateadd'}/gi) || ($form{'dateadd'} eq "Doesn't Matter")) && (($datemod =~ /$form{'datemod'}/gi) || ($form{'datemod'} eq "Doesn't Matter")) && (($category =~ /$form{'category'}/gi) || ($form{'category'} eq "Doesn't Matter")) && (($emailaddr =~ /$form{'emailaddr'}/gi) || ($form{'emailaddr'} eq "Doesn't Matter")) && (($establish =~ /$form{'establish'}/gi) || ($form{'establish'} eq "Doesn't Matter")) && (($address1 =~ /$form{'address1'}/gi) || ($form{'address1'} eq "Doesn't Matter")) && (($address2 =~ /$form{'address2'}/gi) || ($form{'address2'} eq "Doesn't Matter")) && (($city =~ /$form{'city'}/gi) || ($form{'city'} eq "Doesn't Matter")) && (($state =~ /$form{'state'}/gi) || ($form{'state'} eq "Doesn't Matter")) && (($zipcode =~ /$form{'zipcode'}/gi) || ($form{'zipcode'} eq "Doesn't Matter")) && (($country =~ /$form{'country'}/gi) || ($form{'country'} eq "Doesn't Matter")) && (($phone =~ /$form{'phone'}/gi) || ($form{'phone'} eq "Doesn't Matter")) && (($fax =~ /$form{'fax'}/gi) || ($form{'fax'} eq "Doesn't Matter")) && (($companyemailaddress =~ /$form{'companyemailaddress'}/gi) || ($form{'companyemailaddress'} eq "Doesn't Matter")) && (($hompage =~ /$form{'homepage'}/gi) || ($form{'homepage'} eq "Doesn't Matter"))) {

$recno=$recno+1;

if ($counter < $form{'end'})  { 
$counter=$counter+1;
$num=$recno;

&get_time;
&check_new;

$yellowpage="";

$namefile="$sub2/$sub4/$id.txt";
if (-e $namefile) {
open (NAME, "<$namefile") || die ("Can't open $namefile.");
}
foreach $line (<NAME>)  {
$line =~ s/^\s+//;
$line =~ s/\s+$//;  
$yellowpage="$line";
}
close (NAME);

if (!$yellowpage) {
if ($homepage) {
$link="<a href=\"$homepage\" target=\"_top\">»</a>";
} else {
$link="";
}
} else {
$link="<a href=\"$url/$yellowpage\" target=\"_top\">»</a>";
}

if ($counter >= $form{'begin'}) {
$list="advanced2";
$plate="$homedir/$sub9/list.htm";
&print_record;
$new="";
}

}
}
}
close DATABASE;

if ($recno <= $form{'end'}) {
$form{'end'}=$recno;
}

if ($counter == 0) {
$form{'end'}=0;
$form{'begin'}=0;
$recno=0;
}

if (($total_profiles > 0) && ($recno != 0)) {
&print_total2;
}

if (($total_profiles <= 0) || ($recno == 0)) {
&print_noresults;
}

&print_search;

&bottom;

exit;
