#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# add.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
do "message.pl";
do "cookie.lib";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&parse_form;
&checkpermission;
&get_time;

$form{'category'} =~ s/^\s+//;
$form{'category'} =~ s/\s+$//;  
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
$form{'describe'} =~ s/^\s+//;
$form{'describe'} =~ s/\s+$//;  

$file=$database;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&datadefined($user, $safefile);

if (($returnval == 1) && ($password eq "$pwd")) {
$message="Your organization profile ID:$id has been successfully added to $title.";
&standard;
}

if (!$form{'category'}) {
$message="Please enter your [Category].";
&error;
}

if ($form{'category'} eq "----- Select -----") {
$message="Please specify your [Category].";
&error;
}

if (!$form{'name'}) {
$message="Please enter your [Organization Name].";
&error;
}

if (int(length($form{'name'})) > 100) {
$message="Sorry, your [Organization Name] cannot exceed 100 characters.";
&error;
}

if ($form{'establish'} =~ /[^0-9]/) {
$message="Sorry, your organization [Established in] must be 0-9 only.";
&error;
}

if (int(length($form{'establish'})) > 4) {
$message="Sorry, your organization [Established in] cannot exceed 4 digits.";
&error;
}

if (!$form{'address1'}) {
$message="Please enter your organization [Address 1].";
&error;
}

if (int(length($form{'address1'})) > 100) {
$message="Sorry, your organization [Address 1] cannot exceed 100 characters.";
&error;
}

if (int(length($form{'address2'})) > 100) {
$message="Sorry, your organization [Address 2] cannot exceed 100 characters.";
&error;
}

if (!$form{'city'}) {
$message="Please enter your organization [City].";
&error;
}

if (int(length($form{'city'})) > 100) {
$message="Sorry, your organization [City] cannot exceed 100 characters.";
&error;
}

if (!$form{'state'}) {
$message="Please enter your organization [State].";
&error;
}

if (int(length($form{'state'})) > 100) {
$message="Sorry, your organization [State] cannot exceed 100 characters.";
&error;
}

if (!$form{'zipcode'}) {
$message="Please enter your organization [Zip Code/Postal Code].";
&error;
}

if (int(length($form{'zipcode'})) > 10) {
$message="Sorry, your organization [Zip Code/Postal Code] cannot exceed 10 digits.";
&error;
}

if ($form{'country'} eq "----- Select -----") {
$message="Please specify your organization [Country].";
&error;
}

if (int(length($form{'phone'})) > 50) {
$message="Sorry, your organization [Phone Number] cannot exceed 50 digits.";
&error;
}

if (int(length($form{'fax'})) > 50) {
$message="Sorry, your organization [Fax Number] cannot exceed 50 digits.";
&error;
}

if ($form{'companyemailaddress'}) {
if (&valid_address($form{'companyemailaddress'}) == 0) {
$message="Sorry, your organization [E-mail Address] is invalid.";
&error;
}
$form{'companyemailaddress'}=lc($form{'companyemailaddress'});
}

if ($form{'homepage'} eq "http://") {
$form{'homepage'}="";
}

if ($form{'homepage'} ne "") {
if ($form{'homepage'} =~ /[^A-Za-z0-9.:\-\_\&\=\?\/]/) {
$message="Sorry, your organization [Web Site] must be 0-9, A-Z and a-z.";
&error;
}
$val=index($form{'homepage'}, "http");
if ($val==-1) {
$message="Sorry, your organization [Web Site] is invalid.";
&error;
}
$val=index($form{'homepage'}, ":");
if ($val==-1) {
$message="Sorry, your organization [Web Site] is invalid.";
&error;
}
$val=index($form{'homepage'}, ".");
if ($val==-1) {
$message="Sorry, your organization [Web Site] is invalid.";
&error;
}
$val=index($form{'homepage'}, "//");
if ($val==-1) {
$message="Sorry, your organization [Web Site] is invalid.";
&error;
}
if (int(length($form{'homepage'})) > 100) {
$message="Sorry, your organization [Web Site] cannot exceed 100 characters.";
&error;
}
}

if (!$form{'describe'}) {
$message="Please enter your organization [Description].";
&error;
}

if (int(length($form{'describe'})) > 150) {
$message="Sorry, your organization [Description] cannot exceed 150 characters.";
&error;
}

if (!$form{'declaration'}) {
$message="Sorry, please make your [Declaration] in order to add/change your organization profile.";
&error;
}

$form{'category'}=~ tr/|//d;
$form{'name'}=~ tr/|//d;
$form{'establish'}=~ tr/|//d;
$form{'address1'}=~ tr/|//d;
$form{'address2'}=~ tr/|//d;
$form{'city'}=~ tr/|//d;
$form{'state'}=~ tr/|//d;
$form{'zipcode'}=~ tr/|//d;
$form{'country'}=~ tr/|//d;
$form{'phone'}=~ tr/|//d;
$form{'fax'}=~ tr/|//d;
$form{'companyemailaddress'}=~ tr/|//d;
$form{'homepage'}=~ tr/|//d;
$form{'describe'}=~ tr/|//d;

if ($form{'homepage'} eq "http://") {
$form{'homepage'}="";
}

$string="$form{'name'}";
&convertstr($string);
$form{'name'}=$results;

$string="$form{'address1'}";
&convertstr($string);
$form{'address1'}=$results;

$string="$form{'address2'}";
&convertstr($string);
$form{'address2'}=$results;

$string="$form{'city'}";
&convertstr($string);
$form{'city'}=$results;

$string="$form{'state'}";
&convertstr($string);
$form{'state'}=$results;

$form{'homepage'}=lc($form{'homepage'});
$form{'describe'}=ucfirst($form{'describe'});

open (COUNTER, "$counter");
$count=<COUNTER>;
close (COUNTER);

&lock("$lock", "$counter");
open (COUNTER, ">$counter");
$count += 1;
print COUNTER "$count";
close (COUNTER);	 
&unlock("$lock", "$counter");

&lock("$lock", "$database");
open (DATABASE, ">>$database");
print DATABASE 
"$form{'name'} |$count|$ENV{'REMOTE_ADDR'}|$ENV{'REMOTE_HOST'}|$year-$month-$day|$year-$month-$day|$form{'category'}|$emailaddress|$form{'establish'}|$form{'address1'}|$form{'address2'}|$form{'city'}|$form{'state'}|$form{'zipcode'}|$form{'country'}|$form{'phone'}|$form{'fax'}|$form{'companyemailaddress'}|$form{'homepage'}\n";
close DATABASE;
&unlock("$lock", "$database");

&lock("$lock", "$previous");
open (PREVIOUS, ">>$previous");
print PREVIOUS 
"$form{'name'} |$count|$ENV{'REMOTE_ADDR'}|$ENV{'REMOTE_HOST'}|$year-$month-$day|$year-$month-$day|$form{'category'}|$emailaddress|$form{'establish'}|$form{'address1'}|$form{'address2'}|$form{'city'}|$form{'state'}|$form{'zipcode'}|$form{'country'}|$form{'phone'}|$form{'fax'}|$form{'companyemailaddress'}|$form{'homepage'}\n";
close PREVIOUS;
&unlock("$lock", "$previous");

$messagefile="$sub2/$sub7/$count.txt";
open (MESSAGE, ">$messagefile") || die ("Can't open $messagefile.");
print MESSAGE "$form{'describe'}\n";
close (MESSAGE);

########## SENDMAIL ##########
$ipaddr="$ENV{'REMOTE_ADDR'}";
$date=localtime();
$recipientaddr="$emailaddress";
$webmaster="$webmaster";

$subject="Your Organization Profile ID:$count";
&letterofadd;
&sendmail($webmaster,$subject,$msgtxt,$recipientaddr);

if ($msgadd == 1) {
$subject2="New Profile ID:$count";
&letterofadd2;
&sendmail($recipientaddr,$subject2,$msgtxt2,$webmaster);
}
########## SENDMAIL ##########

$message="Your organization profile ID:$count has been successfully added to $title.";
&standard;
