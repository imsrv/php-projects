#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# modify.pl
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

&checkpermission;
&parse_form;
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
$form{'code'} =~ s/^\s+//;
$form{'code'} =~ s/\s+$//;  
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

if (!$form{'category'}) {
$message="Please enter your organization [Category].";
&error;
}

if ($form{'category'} eq "----- Select -----") {
$message="Please define your organization [Category].";
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

&lock("$lock", "$database");
open (DATABASE, "<$database");
open (TEMP, ">$temp");

foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/,$line, 19);
&checkrecord;

if ($emailaddr eq "$emailaddress") {
$ip=$ENV{'REMOTE_ADDR'};
$host=$ENV{'REMOTE_HOST'};
$datemod="$year-$month-$day";
$category=$form{'category'};
$name=$form{'name'};
$establish=$form{'establish'};
$address1=$form{'address1'};
$address2=$form{'address2'};
$city=$form{'city'};
$state=$form{'state'};
$zipcode=$form{'zipcode'};
$country=$form{'country'};
$phone=$form{'phone'};
$fax=$form{'fax'};
$companyemailaddress=$form{'companyemailaddress'};
$homepage="$form{'homepage'}";

$memberid=$id;
}

print TEMP "$name |$id|$ip|$host|$dateadd|$datemod|$category|$emailaddr|$establish|$address1|$address2|$city|$state|$zipcode|$country|$phone|$fax|$companyemailaddress|$homepage\n";
}

close DATABASE;
close TEMP;

unlink ($previous);
rename ($database, $previous);
unlink ($database);
rename ($temp, $database);
&unlock("$lock", "$database");

$messagefile="$sub2/$sub7/$memberid.txt";
&lock("$lock");
open (MESSAGE, ">$messagefile") || die ("Can't open $messagefile.");
print MESSAGE "$form{'describe'}\n";
close (MESSAGE);
&unlock("$lock");

$message="Your organization profile ID:$memberid has been successfully updated.";
&standard;
