#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Admin Script
# Version 2.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2002 Done-Right. All rights reserved.
###############################################


###############################################
use vars qw(%config %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value %semod);
use CGI::Carp qw(fatalsToBrowser);
undef %config;
local %config = ();
do "${path}config/config.cgi";
if ($config{'modperl'} == 1) {
	eval("use Apache"); if ($@) { die "The Apache module used for mod_perl appears to not be installed"; }
}
my $file_ext = "$config{'extension'}";
if ($file_ext eq "") { $file_ext = "cgi"; }
if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
else { do "${path}functions_text.$file_ext"; }
do "${path}functions.$file_ext";
&main_functions::checkpath('settings', $path);
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
###############################################


###############################################
local (%FORM, $inbuffer, $qsbuffer, $buffer, @pairs, $pair, $name, $value);
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		#$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		#$value =~ s/<([^>]|\n)*>//g;
		$FORM{$name} = $value;
	}
}

#logics
if ($FORM{'tab'} eq "categories") { &categories(); }
elsif ($FORM{'tab'} eq "defaults") { &defaults(); }
elsif ($FORM{'tab'} eq "setdefaults") { &setdefaults(); }
elsif ($FORM{'tab'} eq "set") { &set(); }
elsif ($FORM{'tab'} eq "cache") { &cache(); }
elsif ($FORM{'tab'} eq "clearcache") { &clearcache(); }
elsif ($FORM{'tab'} eq "wordfilter") { &wordfilter(); }
elsif ($FORM{'tab'} eq "domainfilter") { &domainfilter(); }
elsif ($FORM{'tab'} eq "setfilter") { &setfilter(); }
elsif ($FORM{'tab'} eq "backup") { &backup(); }
elsif ($FORM{'tab'} eq "databackup") { &databackup(); }
else { &settings(); }
###############################################


###############################################
#Main Sub
sub settings {
my $text = $_[0];
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Settings</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=wordfilter&user=$FORM{'user'}&file=bidsearchengine">Word Filter</a></td>
<td width="65%"><font face="verdana" size="-1">Filter out offensive results to provide a safe family search.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=domainfilter&user=$FORM{'user'}&file=bidsearchengine">Domain Filter</a></td>
<td width="65%"><font face="verdana" size="-1">Filter out certain urls so they are not displayed in the search results.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=categories&user=$FORM{'user'}&file=bidsearchengine">Add Categories</a></td>
<td width="65%"><font face="verdana" size="-1">Create your own search categories.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=defaults&user=$FORM{'user'}&file=bidsearchengine">Set Defaults</a></td>
<td width="65%"><font face="verdana" size="-1">Select default options to use.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=cache&user=$FORM{'user'}&file=bidsearchengine">Cache Details</a></td>
<td width="65%"><font face="verdana" size="-1">View the amount of caches searches among other things.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=backup&user=$FORM{'user'}&file=bidsearchengine">Backup Database</a></td>
<td width="65%"><font face="verdana" size="-1">Backup current database and view backed up database.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Family Filter
sub wordfilter {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
open (FILE, "${path}template/wordfilter.txt");
my @data = <FILE>;
close (FILE);
print <<EOF;
<font face="verdana" size="-1"><B><U>Family Filter</U></B></font>
<center><P>
<form METHOD="POST" ACTION="settings.$file_ext?tab=setfilter&user=$FORM{'user'}&file=bidsearchengine">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B><input TYPE="checkbox" NAME="popwordfilter" $opt[1]> Filter Bad Words for Popular Searches Display</B></font><P>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<center><font face="verdana" size="-1">Enter each new family filter word on a new line</font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="code" ROWS=40 COLS=50>
EOF
foreach my $line(@data) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><BR><BR>
<input type=hidden name=file2 value="wordfilter">
<input type=submit value="Save">
</form>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Domain Filter
sub domainfilter {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
open (FILE, "${path}template/domainfilter.txt");
my @data = <FILE>;
close (FILE);
print <<EOF;
<font face="verdana" size="-1"><B><U>Domain Filter</U></B></font>
<center><P>
<form METHOD="POST" ACTION="settings.$file_ext?tab=setfilter&user=$FORM{'user'}&file=bidsearchengine">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B><input TYPE="checkbox" NAME="domainfilter" $opt[0]> Enable Domain Filter</B></font><P>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<center><font face="verdana" size="-1">Enter each new domain filter on a new line (ex. http://www.domain.com)</font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="code" ROWS=40 COLS=50>
EOF

foreach my $line(@data) {
	chomp($line);
	print "$line\n";
}

print <<EOF;
</TEXTAREA><BR><BR>
<input type=hidden name=file2 value="domainfilter">
<input type=submit value="Save">
</form>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write to filter file
sub setfilter {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my ($opt);
if ($FORM{'file2'} eq "domainfilter") {
	if ($FORM{'domainfilter'} eq "on") { $FORM{'domainfilter'} = "CHECKED"; }
	else { $FORM{'domainfilter'} = ""; }
	my @newarray = splice(@opt,0,1,$FORM{'domainfilter'});
	my $a = 0;
	foreach my $new(@opt) {
		chomp($new);
		if ($a == 0) { $opt = "$new"; }
		else { $opt .= "|$new"; }
		$a++;
	}
} else {
	if ($FORM{'popwordfilter'} eq "on") { $FORM{'popwordfilter'} = "CHECKED"; }
	else { $FORM{'popwordfilter'} = ""; }
	my @newarray = splice(@opt,1,1,$FORM{'popwordfilter'});
	my $a = 0;
	foreach my $new(@opt) {
		chomp($new);
		if ($a == 0) { $opt = "$new"; }
		else { $opt .= "|$new"; }
		$a++;
	}
}

open (FILE, "${path}config/defaults.txt");
my @data = <FILE>;
close (FILE);
chomp(@data);
open (FILE, ">${path}config/defaults.txt");
print FILE <<EOF;
$data[0]
$data[1]
$data[2]
$data[3]
$opt
EOF
close (FILE);
my @code = split(/\n/, $FORM{'code'});
open (FILE, ">${path}template/$FORM{'file2'}.txt");
foreach my $coder(@code) {
	chomp($coder);
	$coder =~ s/[\n\t]//g;
	print FILE "$coder\n";
}
close (FILE);

unless ($FORM{'file2'} eq "domainfilter") {
	open (FILE, "${path}template/$FORM{'file2'}.txt");
	my @data = <FILE>;
	close (FILE);
	chomp(@data);
	my @sort = sort(@data);
	my $a = 0;
	open (FILE, ">${path}template/$FORM{'file2'}.txt");
	foreach my $line(@data) {
		if ($line =~ /[\w+\d+]/) {
			chomp($line);
print FILE "$sort[$a]\n";
		}
		$a++;
	}
	close(FILE);	
}

my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Filter Saved</B></font></font>";
&settings($text);
}
###############################################


###############################################
#Add Categories
sub categories {
my $message = $_[0];
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Categories</U></B></font><BR>
<center><P>
<form METHOD="POST" ACTION="settings.$file_ext?tab=set&user=$FORM{'user'}&file=bidsearchengine">
<center>$message
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Create New Category</B><BR>(You don't have to fill out all the sub categories)</font></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Category:</td>
<td width=70%><input type=text name=category size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 1:</td>
<td width=70%><input type=text name=sub1 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 2:</td>
<td width=70%><input type=text name=sub2 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 3:</td>
<td width=70%><input type=text name=sub3 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 4:</td>
<td width=70%><input type=text name=sub4 size=45></td></tr>
<tr>
<td width=30%><font face="verdana" size="-1">Sub Category 5:</td>
<td width=70%><input type=text name=sub5 size=45></td></tr>
<tr>
<td colspan=2><input type=submit name=type value="Submit"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form>
<P>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write to Categories Page (categories.txt & searchstart.txt)
sub set {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my $category = $FORM{'category'};
my $sub1 = $FORM{'sub1'};
my $sub2 = $FORM{'sub2'};
my $sub3 = $FORM{'sub3'};
my $sub4 = $FORM{'sub4'};
my $sub5 = $FORM{'sub5'};
chomp($category);
chomp($sub1);
chomp($sub2);
chomp($sub3);
chomp($sub4);
chomp($sub5);

my $catfile = "$category";
if ($sub1 ne "") { $catfile .= "|$sub1"; }
if ($sub2 ne "") { $catfile .= "|$sub2"; }
if ($sub3 ne "") { $catfile .= "|$sub3"; }
if ($sub4 ne "") { $catfile .= "|$sub4"; }
if ($sub5 ne "") { $catfile .= "|$sub5"; }
open (FILE, "${path}template/categories.txt");
my @data = <FILE>;
close(FILE);
my $a=0;
foreach (@data) { $a++; }
$data[$a] = "$catfile";
my @sort = sort(@data);
my ($f, $c);
my $printhtml = "<!-- [Categories] -->\n<table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH=90%><tr>\n";
open (FILE, ">${path}template/categories.txt");
foreach (@data) {
	chomp($sort[$c]);
print FILE <<EOF;
$sort[$c]
EOF
	if ($f == 3) {
		$f=0;
		$printhtml .= "</tr><tr>";	
	}
	my @htmldata = split(/\|/, $sort[$c]);
	my $linkurl = $htmldata[0];
	$linkurl =~ tr/ /+/;
	$printhtml .= "<td><b><font face=verdana size=-1><a href=\"search.$file_ext?keywords=$linkurl\">$htmldata[0]</a></b><BR><font size=-2>\n";
	my $d=0;
	foreach (@htmldata) {
		unless ($d == 0) {
			my $linkurl = $htmldata[$d];
			$linkurl =~ tr/ /+/;
			$printhtml .= "<a href=\"search.$file_ext?keywords=$linkurl\">$htmldata[$d]</a>\n";
		}
		$d++;
	}
	$printhtml .= "<BR>&nbsp;</td>\n";
	$c++;
	$f++;
}
$printhtml .= "</table>\n<!-- [Categories] -->\n";
close (FILE);

open (FILE, "${path}template/searchstart.txt");
my @catgy = <FILE>;
close (FILE);
my $catvar = "@catgy";
my @catsplit = split(/<!-- \[Categories\] -->/, $catvar);
open (FILE, ">${path}template/searchstart.txt");
print FILE <<EOF;
$catsplit[0]
$printhtml
$catsplit[2]
EOF

my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Category Created</B></font></font>";
&categories($message);
&main_functions::exit;
}
###############################################


###############################################
#Set Defaults
sub defaults {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
undef %semod;
local %semod = ();
do "${path}template/Web.cgi";
my @se = split(/\|/, $semod{'search_engines'});
print <<EOF;
<font face="verdana" size="-1"><B><U>Set Defaults</U></B></font><BR>
<center><BR>
<table width=90% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><form METHOD="POST" ACTION="settings.$file_ext?tab=setdefaults&user=$FORM{'user'}&file=bidsearchengine">
<font face="verdana" size="-1" color="#000066"><b>Default Values</b></font></td></tr>
<tr>
<td width=40% valign=top><font face="verdana" size="-1">Default Engines:</td>
<td width=60%>
<table BORDER=0 CELLSPACING=0 CELLPADDING=0><tr>
EOF
my ($innernum, $senum);
foreach (@se) {
	if ($innernum == 4) {
		print "</tr><tr>";
		$innernum = 0;
	}
print <<EOF;
<td><input TYPE="checkbox" NAME="eng$senum" $eng[$senum]></td>
<td><font size=-2>&nbsp;$se[$senum]</td>
EOF
	$innernum++;
	$senum++;	
}
print <<EOF;
</tr></table>
</td></tr>

<tr>
<td width=40%><font face="verdana" size="-1">Default Resuls per page:</td>
<td width=60%><select NAME="perpage" SIZE="1"><option SELECTED>$adv[0]<option>---<option>10<option>20<option>30<option>40<option>50</select></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Default Timeout:</td>
<td width=60%><select NAME="timeout" SIZE="1"><option SELECTED>$adv[1]<option>---<option>2<option>5<option>7<option>15</select></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Number of Popular Searches to Display:</td>
<td width=60%><font face="verdana" size="-1"><input TYPE="text" NAME="amtpopsearches" size="2" value="$adv[4]"></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Number of days to keep cache:</td>
<td width=60%><font face="verdana" size="-1"><input TYPE="text" NAME="cache" size="2" value="$adv[2]"> days <font face="verdana" size="-2">(Specify 0 if you do not want to use cache results)</font></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Amount of Characters before Cutoff:</td>
<td width=60%><input TYPE="text" NAME="cutoff" size="2" value="$adv[3]">
&nbsp;<font face="verdana" size="-2">(ex. if the title of a search result is over 50 characters, it will print the first 50 characters of the title and cut the end of with ...)</font></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1">Display a Minimum of <input TYPE="text" NAME="minrel" size="2" value="$adv[5]"> and a Maximum of <input TYPE="text" NAME="maxrel" size="2" value="$adv[6]"> Related Search Terms</td>
<tr>
<td width=40%><font face="verdana" size="-1">Number of Search Listing Fields Displayed on Add Listings page:</td>
<td width=60%><font face="verdana" size="-1"><select NAME="signuplistings" SIZE="1"><option SELECTED>$adv[8]<option>---<option>10<option>20<option>30<option>40</select></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Minimum Balance allowed to Order:</td>
<td width=60%><font face="verdana" size="-1">$adv[15]<input TYPE="text" NAME="minbalance" size="5" value="$adv[9]"></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Send Low Balance Warning Email when:</td>
<td width=60%><font face="verdana" size="-1">Estimated Depletion in <select NAME="warning1" SIZE="1"><option SELECTED>$adv[10]<option>---<option>6<option>5<option>4<option>3<option>2<option>1</select> <B>OR</B> Balance is at $adv[15]<input TYPE="text" NAME="warning2" size="5" value="$adv[11]"></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Display Image beside Paid Results (optional):</td>
<td width=60%><font face="verdana" size="-1"><input TYPE="text" NAME="paidimage" size="45" value="$adv[12]"></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1">Give new members an extra $adv[15]<input TYPE="text" NAME="extrabalance" size="5" value="$adv[13]"> added to their balance ordered when they signup (optional)</td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Minimum Bid Allowed:</td>
<td width=60%><font face="verdana" size="-1">$adv[15]<input TYPE="text" NAME="minbid" size="5" value="$adv[14]"></td></tr>
<tr>
<td width=40%><font face="verdana" size="-1">Default Currency Symbol:</td>
<td width=60%><font face="verdana" size="-1"><input TYPE="text" NAME="currency" size="5" value="$adv[15]"></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="freesignup" $opt[12]> Enable free signups and add $adv[15]<input TYPE="text" NAME="freeamount" size="5" value="$adv[16]"> to members account.<BR>
(Send members wanting free signups to this URL: <a href="$config{'adminurl'}signup.$file_ext?free=1" target="new">$config{'adminurl'}signup.$file_ext?free=1</a>)</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="nontargeted" $opt[13]> Enable Non-Targeted Listings and only display <input TYPE="text" NAME="nontaramount" size="5" value="$adv[17]"> non-targeted listings.<BR>
(If you decide to disable non-targeted listings, you must delete the non-targeted link from the member template pages)</td></tr>
<tr>
<td width=40%>&nbsp;</td>
<td width=60%>&nbsp;</td>
</tr>
<tr><td colspan=2><font face="verdana" size="-1" color="#000066"><b>Default Options</b></font></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="domainfilter" $opt[0]> Enable Domain Filter</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="popwordfilter" $opt[1]> Filter Bad Words for Popular Searches Display</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="related" $opt[2]> Enable Related Searches</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="frame" $opt[3]> Display Results in a Frame</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="keepdaystats" $opt[4]> Track Daily Statistics</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="popsearches" $opt[5]> Log Search Terms <font size=-2>(used for related results, popular searches and search term suggestion tool)</font></td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="highlight" $opt[6]> Enable Highlighted Terms</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="unique" $opt[7]> Enable Unique Click-Thrus</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="outbid" $opt[8]> Email Member when listing is outbided by another Member</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="approveorder" $opt[9]> Each Order has to be Approved by the Admin before listing can be online</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="nocreditsignup" $opt[10]> Omit the credit card signup step (3rd step)</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><input TYPE="checkbox" NAME="nolistingsignup" $opt[11]> Omit the specify search listing signup step (1st step) in which the member would add listings through the members admin</td>
</tr>
<tr><td colspan=2>
<input type=submit name=setdef value="Submit">
</form></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write to Defaults.txt
sub setdefaults {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
undef %semod;
local %semod = ();
do "${path}template/Web.cgi";
my @se = split(/\|/, $semod{'search_engines'});
my ($aaa, $engfile);
foreach (@se) {
	my $eng = "eng$aaa";
	if ($FORM{$eng} eq "on") {
		if ($aaa == 0) { $engfile .= "CHECKED"; }
		else { $engfile .= "|CHECKED"; }
	} else {
		if ($aaa == 0) { $engfile .= ""; }
		else { $engfile .= "|"; }	
	}
	$aaa++;
}
if ($FORM{'frame'} eq "on") {
	unless (-e "${path}template/frame.txt") {
		open (FILE, ">${path}template/frame.txt");
print FILE <<EOF;
<HTML>
<HEAD>
  <TITLE>Search</TITLE>
</HEAD>
<frameset rows="10%,*" frameborder=0 border=0 framespacing=0>
  <frame src="[topframe]" noresize name=top scrolling=no marginwidth=0 marginheight=0 frameborder=0>
  <frame src="[frameurl]" name="bottom" noresize marginwidth=0 marginheight=0 frameborder=0>
</frameset>
<noframes>
  <body bgcolor="#FFFFFF">
    <font face=verdana size="-1">If the page did not open, please <a href="[frameurl]"><b>Click Here</b></a>.
  </body>
</noframes>
</HTML>
EOF
		close (FILE);
	}
	unless (-e "${path}template/topframe.txt") {
		open (FILE, ">${path}template/topframe.txt");
print FILE <<EOF;
<HTML>
<HEAD>
  <TITLE>Search</TITLE>
</HEAD>
<BODY bgcolor="#000066" link=#999999 vlink=#999999>
<TABLE width="100%" bgcolor="#000066">
<TR><TD width="20%" valign=top><img src="images/framelogo.gif" border=0></TD>
<TD width="60%" valign=top>
<center><!-- [banner] -->
</TD>
<TD width="20%" align=right valign=top><font face=verdana size=-1 color=#999999><B>
<a href="[frameurl]" target="_top"><B>CLOSE FRAME</A>&nbsp;<BR>
<a href="[topframe]" target="_top"><B>BACK</A>&nbsp;
</font></B></TD></TR></TABLE>
</BODY>
</HTML>
EOF
		close (FILE);
	}
}

my $adv = "$FORM{'perpage'}|$FORM{'timeout'}|$FORM{'cache'}|$FORM{'cutoff'}|$FORM{'amtpopsearches'}|$FORM{'minrel'}|$FORM{'maxrel'}|0|$FORM{'signuplistings'}|$FORM{'minbalance'}|$FORM{'warning1'}|$FORM{'warning2'}|$FORM{'paidimage'}|$FORM{'extrabalance'}|$FORM{'minbid'}|$FORM{'currency'}|$FORM{'freeamount'}|$FORM{'nontaramount'}";
my $opt = "$FORM{'domainfilter'}|$FORM{'popwordfilter'}|$FORM{'related'}|$FORM{'frame'}|$FORM{'keepdaystats'}|$FORM{'popsearches'}|$FORM{'highlight'}|$FORM{'unique'}|$FORM{'outbid'}|$FORM{'approveorder'}|$FORM{'nocreditsignup'}|$FORM{'nolistingsignup'}|$FORM{'freesignup'}|$FORM{'nontargeted'}";
$opt =~ s/on/CHECKED/ig;
$opt =~ s/off//ig;
open (FILE, "${path}config/defaults.txt");
my @data = <FILE>;
close (FILE);
chomp($data[2]);
chomp($data[3]);
open (FILE, ">${path}config/defaults.txt");
print FILE <<EOF;
$engfile
$adv
$data[2]
$data[3]
$opt
EOF
close (FILE);

my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Defaults Set</B></font></font>";
&settings($text);
&main_functions::exit;
}
###############################################


###############################################
#Cache
sub cache {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
opendir(FILE,"${path}cache");
my @products = grep { /.txt/ } readdir(FILE);
closedir (FILE);
my $number=0;
my %hash2;
foreach my $line(@products) {
	my @split = split(/\-/, $line);
	my $num = @split-2;
	unless (exists $hash2{$split[$num]}) {
		$hash2{$split[$num]} = 1;
		$number++;
	}
}

print <<EOF;
<font face="verdana" size="-1"><B><U>Cache</U></B></font><BR>
<center><P>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<form METHOD="POST" ACTION="settings.$file_ext?tab=clearcache&user=$FORM{'user'}&file=bidsearchengine"><BR></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000066"><center><B>Currently $number Cached Searches</B></td>
</tr><tr>
<td colspan=2><font face="verdana" size="-1"><center>Cached Searches: 
<select NAME="caches" SIZE="1"><option SELECTED>------- Cache Searches -------
EOF
my @sort = sort(@products);
my %hash;
foreach my $line(@sort) {
	$line =~ s/.txt//;
	my @split = split(/\-/, $line);
	my $num = @split-2;
	unless (exists $hash{$split[$num]}) {
		$hash{$split[$num]} = 1;
		print "<option>$split[$num]";
	}
}
print <<EOF;
</td></tr>
<tr><td colspan=2><center>
<input type=submit name=setdef value="Clear Expired Cache"> <input type=submit name=setdef value=" Clear All Cache ">
</form></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Clear Cache
sub clearcache {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
opendir(FILE,"${path}cache");
my @products = grep { /.txt/ } readdir(FILE);
closedir (FILE);
if ($FORM{'setdef'} eq " Clear All Cache ") {
	foreach my $line(@products) {
		unlink("${path}cache/$line");
	}
} else {
	foreach my $line(@products) {
		my $age = -M "${path}cache/$line";
		if ($age > $adv[2]) {
			unlink("${path}cache/$line");
		}
	}
}
my $newtime = time();
open (FILE, "${path}config/records.txt");
my $data = <FILE>;
close (FILE);
my @data = split(/\|/, $data);
open (FILE, ">${path}config/records.txt");
print FILE "$newtime|$data[1]";
close (FILE);
my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Cache Cleared</B></font></font>";
&settings($text);
}
###############################################


###############################################
sub backup {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
open (FILE, "${path}config/records.txt");
my $data = <FILE>;
close (FILE);
my @data = split(/\|/, $data);
my $backupdate = $data[1];
print <<EOF;
<font face="verdana" size="-1"><B><U>Backup Database</U></B></font><BR>
<center><P>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<form METHOD="POST" ACTION="settings.$file_ext?tab=databackup&user=$FORM{'user'}&file=bidsearchengine"><BR></td></tr>
<tr><td><center><font face="verdana" size="-1"><a href="view.$file_ext?&user=$FORM{'user'}&backup=1">View backup database</a></td></tr>
<tr><td><center><font face="verdana" size="-1"><B>Data backup last performed on:</B> <font color="#000099">$backupdate</font></td></tr>
<tr><td><center><font face="verdana" size="-1"><input type=submit value="Backup Current Database">
</form></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub databackup {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	&database_functions::backup_database;
	my ($newdate) = &main_functions::getdate;
	open (FILE, "${path}config/records.txt");
	my $data = <FILE>;
	close (FILE);
	my @data = split(/\|/, $data);
	open (FILE, ">${path}config/records.txt");
	print FILE "$data[0]|$newdate";
	close (FILE);
	my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Database Backed Up</B></font></font>";
	&settings($text);
}
###############################################