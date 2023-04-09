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
use vars qw(%config %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value);
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
&main_functions::checkpath('view', $path);
###############################################


###############################################
#Read Input
local (%FORM, $inbuffer, $qsbuffer, $buffer, @pairs, $pair, $name, $value);
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		$value =~ s/<([^>]|\n)*>//g;
		if ($config{'data'} eq "mysql") { $value = &database_functions::escape($value); }
		$FORM{$name} = $value;
	}
}

if ($FORM{'tab'} eq "view") { &view(); }
elsif ($FORM{'tab'} eq "details") { &details(); }
elsif ($FORM{'tab'} eq "deletemember") { &deletemember(); }
elsif ($FORM{'tab'} eq "deletelisting") { &deletelisting(); }
elsif ($FORM{'tab'} eq "email") { &email(); }
elsif ($FORM{'tab'} eq "sendemail") { &sendemail(); }
elsif ($FORM{'tab'} eq "addbalance") { &addbalance(); }
elsif ($FORM{'tab'} eq "search") { &search(); }
elsif ($FORM{'tab'} eq "edit_profile") { &edit_profile(); }
elsif ($FORM{'tab'} eq "submit_profile") { &submit_profile(); }
else { &main(); }
###############################################


###############################################
sub main {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my ($backmess, $backlink);
if ($FORM{'backup'}) {
	$backmess = "- <font color=\"red\">Backed Up Database</font>";
	$backlink = "&backup=1";
}
my (@processing, @active, @inactive, @addition, @balanceaddon);
my ($processing, $active, $inactive, $addition, $balanceaddon) = &database_functions::count_members(\@processing, \@active, \@inactive, \@addition, \@balanceaddon, $FORM{'backup'});
unless ($processing) { $processing = "0"; }
unless ($active) { $active = "0"; }
unless ($inactive) { $inactive = "0"; }
print <<EOF;
<font face="verdana" size="-1"><B><U>View Members</U>$backmess</B></font><P>
<center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><font face="verdana" size="-1"><B>Amount of active members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$active</font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Amount of processing members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$processing</font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Amount of inactive members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$inactive</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><P>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.$file_ext?tab=view&user=$FORM{'user'}&type=active$backlink">Active Members</a></td>
<td width="65%"><font face="verdana" size="-1">View members with active accounts.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.$file_ext?tab=view&user=$FORM{'user'}&type=processing$backlink">Processing Members</a></td>
<td width="65%"><font face="verdana" size="-1">View members waiting to be processed.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.$file_ext?tab=view&user=$FORM{'user'}&type=inactive$backlink">Inactive Members</a></td>
<td width="65%"><font face="verdana" size="-1">View members with inactive accounts.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR>
<form METHOD="POST" ACTION="view.$file_ext?tab=search&user=$FORM{'user'}$backlink">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td><font face="verdana" size="-1" color="#000099"><B>Search for Member</B></font></td></tr>
<tr><td><font face="verdana" size="-1">
Search By: &nbsp;<input type=radio name=searchby value="username" CHECKED> Username 
<input type=radio name=searchby value="name"> Name 
<input type=radio name=searchby value="company"> Company 
<input type=radio name=searchby value="siteterm"> Site Term</td></tr>
<tr><td><font face="verdana" size="-1">
Account Name: <input type=text name=member size=30>&nbsp;<input type=submit value="Search"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub view {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my (@eng, @adv, @opt);
my ($backmess, $backlink);
if ($FORM{'backup'}) {
	$backmess = " <font color=\"red\">(Backed Up Database)</font>";
	$backlink = "&backup=1";
}
&main_functions::getdefaults(\@eng, \@adv, \@opt);
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my ($type, $typedisplay) = ($FORM{'type'}) x 2;
$typedisplay = "\u$typedisplay";
my (@processing, $count, $field, $account, $created, $balance, $listings);
unless ($FORM{'tab'} eq "search") { @processing = &database_functions::view_search($type, $FORM{'backup'}); }
else { (@processing) = @_; }
foreach (@processing) { $count++; }
unless ($FORM{'start'}) { $FORM{'start'} = 1; }
unless ($FORM{'end'}) {
	if ($count >= 20) { $FORM{'end'} = 20; }
	else { $FORM{'end'} = $count; }
}
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing $typedisplay Members</U> - <font color=red>$FORM{'start'} to $FORM{'end'} of $count$backmess</U></B></font><P>
<center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF">
<tr bgcolor="#CCCCCC">
EOF
#my $sort = $FORM{'sort'};
#if ($FORM{'sort'} eq "" || $FORM{'sort'} eq "account") {
#	$sort = "account";
#	$field = 0;
#	unless ($FORM{'dir'}) { $account = "&dir=desc"; }
#} elsif ($FORM{'sort'} eq "created") {
#	$field = 1;
#	unless ($FORM{'dir'}) { $created = "&dir=desc"; }
#} elsif ($FORM{'sort'} eq "balance") {
#	$field = 2;
#	unless ($FORM{'dir'}) { $balance = "&dir=desc"; }
#}
# view.$file_ext?tab=$FORM{'tab'}&user=$FORM{'user'}&type=$type&sort=account$account$searchtags$backlink
my $searchtags;
if ($FORM{'tab'} eq "search") {
	$searchtags = "&searchby=$FORM{'searchby'}&member=$FORM{'member'}";
}
print <<EOF;
<td><font face="verdana" size="-1"><B>Account</B></td>
<td><font face="verdana" size="-1"><B>Account Created</B></td>
<td><font face="verdana" size="-1"><B>Balance</B></td>
<td><font face="verdana" size="-1"><B># of Listings</B></td>
</tr>
EOF
#my (@member, $plus, $counter);
#foreach my $line(@processing) {
#	chomp($line);
#	my $account = $line;
#	my @info = &database_functions::GetUser($line, $FORM{'backup'});
#	my $balance = &database_functions::GetBalance($line, $FORM{'backup'});
#	my $created = $info[15];
#	$created =~ s/\-//g;
#	$member[$plus] = "$account|$created|$balance\n";
#	$plus++;
#	last if $plus == 20;
#}

#my @sorted_links = @member;
#my @sorted_links = &main_functions::link_sort($plus, $field, $FORM{dir}, @member);
#my $counter;
foreach my $member(@processing) {
	$counter++;
	if ($counter >= $FORM{'start'}) {
		chomp($member);
		my @info = &database_functions::GetUser($member, $FORM{'backup'});
		my $created = $info[15];
		$created =~ s/\-//g;
		my $balance = &database_functions::GetBalance($member, $FORM{'backup'});
		my @sites = &database_functions::GetSites($member, $FORM{'backup'});
		my $listings = @sites;
		my @inner = ($member, $created, $balance, $listings);
		#my @inner = split(/\|/, $member);
		if (length($inner[1]) > 7) {
			substr($inner[1],4,0) = "-";
			substr($inner[1],7,0) = "-";
		}
print <<EOF;
<tr>
<td><font face="verdana" size="-1"><a href="view.$file_ext?tab=details&user=$FORM{'user'}&type=$type&member=$inner[0]$backlink">$inner[0]</a></B></td>
<td><font face="verdana" size="-1">$inner[1]</B></td>
<td><font face="verdana" size="-1">$adv[15]$inner[2]</B></td>
<td><font face="verdana" size="-1">$listings</B></td>
</tr>
EOF
	}
	last if ($counter == $FORM{'end'});
}

print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
<center><font face="verdana" size="-1"><B>
EOF

my $start = $FORM{'start'}+20;
my $end = $FORM{'end'}+20;
my $start2 = $FORM{'start'}-20;
my $end2 = $FORM{'end'}-20;
unless ($FORM{'start'} == 1) {
	print "<a href=\"view.$file_ext?tab=$FORM{'tab'}&user=$FORM{'user'}&type=$type&sort=$FORM{'sort'}&start=$start2&end=$end2$searchtags$backlink\">Previous</a> ";
} else {
	print "Previous ";
}
unless ($count <= 20) {
	my $stop = $count/20;
	$stop = ($stop-int($stop))>=0.01? int($stop)+1 : int($stop); 
	my $go = $FORM{'end'}/20;
	for my $number(1 .. $stop) {
		if ($go == $number) {
			print "$number ";	
		} else {
			my $end = $number*20;
			my $start = ($end-20)+1;
			print "<a href=\"view.$file_ext?tab=$FORM{'tab'}&user=$FORM{'user'}&type=$type&sort=$FORM{'sort'}&start=$start&end=$end$searchtags$backlink\">$number</a> ";
		}
	}
}
unless ($FORM{'end'} >= $count) {
	print "<a href=\"view.$file_ext?tab=$FORM{'tab'}&user=$FORM{'user'}&type=$type&sort=$FORM{'sort'}&start=$start&end=$end$searchtags$backlink\">Next</a> ";
} else {
	print "Next ";
}

print <<EOF;
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub search {
	my ($member) = $FORM{'member'};
	my ($found, @processing) = &database_functions::do_view_search($member, $FORM{'backup'}, $FORM{'searchby'});
	unless ($found) { &notfound($member); }
	else { &view(@processing); }
}
###############################################


###############################################
sub notfound {
	my ($member) = @_;
	my ($backmess, $backlink);
	if ($FORM{'backup'}) {
		$backmess = "- <font color=\"red\">Backed Up Database</font>";
		$backlink = "&backup=1";
	}
	print "Content-type: text/html\n\n";
	&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing Member</U>$backmess</B></font><P>
<center><font face="verdana" size="-1" color="red">Found no accounts to match keyword <B>$member</B><BR><BR>
<form METHOD="POST" ACTION="view.$file_ext?tab=search&user=$FORM{'user'}$backlink">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td><font face="verdana" size="-1" color="#000099"><B>Search for Member</B></font></td></tr>
<tr><td><font face="verdana" size="-1">
Search By: &nbsp;<input type=radio name=searchby value="username" CHECKED> Username 
<input type=radio name=searchby value="name"> Name 
<input type=radio name=searchby value="company"> Company 
<input type=radio name=searchby value="siteterm"> Site Term</td></tr>
<tr><td><font face="verdana" size="-1">
Account Name: <input type=text name=member size=30>&nbsp;<input type=submit value="Search"></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
	&main_functions::footer;
	&main_functions::exit;
}
###############################################


###############################################
sub details {
my $message = $_[0];
my ($backmess, $backlink);
if ($FORM{'backup'}) {
	$backmess = " <font color=\"red\">(Backed Up Database)</font>";
	$backlink = "&backup=1";
}
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my $member = $FORM{'member'};
if ($config{'data'} eq "mysql") { $member = &database_functions::unescape($member); }
my @info = &database_functions::GetUser($member, $FORM{'backup'});

unless (@info > 0) {
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing Member</U>$backmess</B></font><P>
<center><font face="verdana" size="-1" color="red"><B>$member</B> account not found<BR><BR>
<form METHOD="POST" ACTION="view.$file_ext?tab=details&user=$FORM{'user'}$backlink">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td><font face="verdana" size="-1" color="#000099"><B>Search for Member</B></font></td></tr>
<tr><td><font face="verdana" size="-1">
Search By: &nbsp;<input type=radio name=searchby value="username" CHECKED> Username 
<input type=radio name=searchby value="name"> Name 
<input type=radio name=searchby value="company"> Company 
<input type=radio name=searchby value="siteterm"> Site Term</td></tr>
<tr><td><font face="verdana" size="-1">
Account Name: <input type=text name=member size=30>&nbsp;<input type=submit value="Search"></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
	&main_functions::footer;
	&main_functions::exit;
}
my $balance = &database_functions::GetBalance($member, $FORM{'backup'});
my ($address2);
if ($info[2]) { $address2 = " (Address 2: $info[2])"; }
my $p = $info[10];
my $encryptkey = "drbidsearch";
$p = &main_functions::Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
if ($config{'data'} eq "mysql") { $p = &database_functions::unescape($p); }
my $pass = $info[13];
$encryptkey = "mempassbse";
$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');

my @site = &database_functions::GetSites($member, $FORM{'backup'});
my ($grand, $divider, @date, $avg, $daysleft);
unless ($FORM{'backup'}) {
	($grand, $divider, @date) = &database_functions::stat_activity($member);
	if ($grand) {
		$avg = $grand/$divider;
		$daysleft = $balance/$avg;
		$daysleft = sprintf("%.0f", $daysleft);
		$avg = sprintf("%.2f", $avg);
	}
}

if ($config{'data'} eq "mysql") { $pass = &database_functions::unescape($pass); }
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing Member</U> - <font color=red>$member$backmess</font></B></font><P>
<center><font face="verdana" size="-1">
EOF
unless ($FORM{'backup'}) {
	print "<a href=\"view.$file_ext?tab=edit_profile&user=$FORM{'user'}&member=$member\">Edit Member</a><BR>";
}
print <<EOF;
$message
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="40%"><font face="verdana" size="-1">Account Created:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[15]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Status:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[14]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Password:</font></td>
<td width="60%"><font face="verdana" size="-1">$pass</font></td>
</tr>
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Contact Information</B></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Name:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[0]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Company:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[18]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Email:</font></td>
<td width="60%"><font face="verdana" size="-1"><a href="mailto:$info[8]">$info[8]</a></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">Address:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[1] $address2<BR>$info[3], $info[4], $info[6]<BR>$info[5]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Phone:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[7]</font></td>
</tr>
EOF
unless (($info[9] eq "" || $info[9] eq "Free") && $p eq "") {
print <<EOF;
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Credit Information</B></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Card Holders Name:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[9]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Credit Card #:</font></td>
<td width="60%"><font face="verdana" size="-1">$p</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Credit Card Type:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[16]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Expiration Date:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[11]</font></td>
</tr>
EOF
} elsif ($info[9] eq "Free") {
print <<EOF;
<tr>
<td width="40%"><font face="verdana" size="-1">Account Type:</font></td>
<td width="60%"><font face="verdana" size="-1">Free Signup</font></td>
</tr>
EOF
}
print <<EOF;
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Search Listing Information</B></font></td>
</tr>
EOF
unless ($FORM{'backup'}) {
print <<EOF;
<tr>
<td width="40%"><font face="verdana" size="-1">Estimated Depletion:</font></td>
<td width="60%"><font face="verdana" size="-1">$daysleft days</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Average Cost per Day:</font></td>
<td width="60%"><font face="verdana" size="-1">$adv[15]$avg</font></td>
</tr>
EOF
}
print <<EOF;
<tr>
<td width="40%"><font face="verdana" size="-1">Balance:</font></td>
<td width="60%"><font face="verdana" size="-1">$adv[15]$balance</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR></form>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=3><font face="verdana" size="-1" color="#000099"><B>Search Listings</B></font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>#</B></font></td>
<td><font face="verdana" size="-1"><B>Search Term</B></font></td>
<td><font face="verdana" size="-1"><B>Listing</B></font></td>
<td><font face="verdana" size="-1"><B>Bid</B></font></td>
EOF
unless ($FORM{'backup'}) {
print <<EOF;
<td><font face="verdana" size="-1"><B>Delete</B></font></td>
EOF
}
print "</tr>";

my ($sitenum);
foreach my $line(@site) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[5] eq "new") {
		$sitenum++;
		my $term = $inner[0];
		my $site_id;
		if ($config{'data'} eq "mysql") { $site_id = $inner[8]; }
		else { $site_id = $inner[6]; }
		$term =~ tr/ /+/;
print <<EOF;
<tr>
<td valign="top"><font face="verdana" size="-1">$sitenum</font></td>
<td valign="top"><font face="verdana" size="-1">$inner[0]</font></td>
<td valign="top"><font face="verdana" size="-1"><a href="$inner[3]" target="new">$inner[2]</a><BR><font size="-2">$inner[4]</font></font></td>
<td valign="top"><font face="verdana" size="-1">$adv[15]$inner[1]</font></td>
EOF
unless ($FORM{'backup'}) {
print <<EOF;
<td valign="top"><font face="verdana" size="-1"><a href="view.$file_ext?tab=deletelisting&user=$FORM{'user'}&listing=$term&member=$member&id=$site_id">Delete Listing</a></font></td>
EOF
}
print "</tr>";
	}
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=3><font face="verdana" size="-1" color="#000099"><B>Payment History</B></font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>#</B></font></td>
<td><font face="verdana" size="-1"><B>Date</B></font></td>
<td><font face="verdana" size="-1"><B>Amount</B></font></td>
</tr>
EOF
my @stat = &database_functions::GetStats($member, $FORM{'backup'});
my ($total, $numb);
foreach my $line(@stat) {
	chomp($line);
	my @inner = split(/\|/, $line);
	($total, $numb) = &database_functions::display_payhistory($adv[15], $total, $numb, @inner);
}
$total = sprintf("%.2f", $total);
print <<EOF;
<tr>
<td><font face="verdana" size="-1">&nbsp;</font></td>
<td><font face="verdana" size="-1"><B>TOTAL:</B></font></td>
<td><font face="verdana" size="-1"><B>$adv[15]$total</B></font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub edit_profile {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my $member = $FORM{'member'};
if ($config{'data'} eq "mysql") { $member = &database_functions::unescape($member); }
my @info = &database_functions::GetUser($member);
my $balance = &database_functions::GetBalance($member);
my ($address2, $avg, $daysleft);
if ($info[2]) { $address2 = " (Address 2: $info[2])"; }
my $p = $info[10];
my $encryptkey = "drbidsearch";
$p = &main_functions::Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
if ($config{'data'} eq "mysql") { $p = &database_functions::unescape($p); }
my $pass = $info[13];
$encryptkey = "mempassbse";
$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');

my @stat = &database_functions::GetStats($member);
my @site = &database_functions::GetSites($member);
my ($grand, $divider, @date) = &database_functions::stat_activity($member);

if ($grand) {
	$avg = $grand/$divider;
	$daysleft = $balance/$avg;
	$daysleft = sprintf("%.0f", $daysleft);
	$avg = sprintf("%.2f", $avg);
}
if ($config{'data'} eq "mysql") { $pass = &database_functions::unescape($pass); }
print <<EOF;
<font face="verdana" size="-1"><B><U>Edit Member</U> - <font color=red>$member</font></B></font><P>
<form METHOD="POST" ACTION="view.$file_ext?tab=submit_profile&user=$FORM{'user'}&member=$member">
<center><font face="verdana" size="-1"><a href="view.$file_ext?tab=details&user=$FORM{'user'}&member=$member">View Member</a><BR>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="40%"><font face="verdana" size="-1">Account Created:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="created" size="10" value="$info[15]"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Status:</font></td>
<td width="60%"><font face="verdana" size="-1"><select name="status" size="-1"><option SELECTED>$info[14]</option>
EOF
if ($info[14] eq "active") { print "<option>inactive</option>"; }
else { print "<option>active</option>"; }
print <<EOF;
</select></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Password:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="password" size="30" value="$pass"></font></td>
</tr>
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Contact Information</B></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Name:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="personsname" size="30" value="$info[0]"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Company:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="company" size="30" value="$info[18]"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Email:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="email" size="30" value="$info[8]"></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">Address:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="address1" size="30" value="$info[1]"></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">Address 2:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="address2" size="30" value="$info[2]"></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">City:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="city" size="30" value="$info[3]"></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">State:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="state" size="30" value="$info[4]"></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">Country:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="country" size="30" value="$info[6]"></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">Zip:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="zip" size="30" value="$info[5]"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Phone:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="phone" size="30" value="$info[7]"></font></td>
</tr>
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Credit Information</B></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Card Holders Name:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="ccname" size="30" value="$info[9]"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Credit Card #:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="ccnumber" size="30" value="$p"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Credit Card Type:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="cctype" size="30" value="$info[16]"></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Expiration Date:</font></td>
<td width="60%"><font face="verdana" size="-1"><input type="text" name="expiration" size="30" value="$info[11]"></font></td>
</tr>

<tr>
<td width="40%"><font face="verdana" size="-1">Balance:</font></td>
<td width="60%"><font face="verdana" size="-1">$adv[15]<input type="text" name="balance" size="10" value="$balance"></font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><center><input type="submit" value="Submit"></form>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=3><font face="verdana" size="-1" color="#000099"><B>Search Listings</B></font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>#</B></font></td>
<td><font face="verdana" size="-1"><B>Search Term</B></font></td>
<td><font face="verdana" size="-1"><B>Listing</B></font></td>
<td><font face="verdana" size="-1"><B>Bid</B></font></td>
<td><font face="verdana" size="-1"><B>Delete</B></font></td>
</tr>
EOF
my ($sitenum);
foreach my $line(@site) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[5] eq "new") {
		$sitenum++;
		my $term = $inner[0];
		my $site_id;
		if ($config{'data'} eq "mysql") { $site_id = $inner[8]; }
		else { $site_id = $inner[6]; }
		$term =~ tr/ /+/;
print <<EOF;
<tr>
<td valign="top"><font face="verdana" size="-1">$sitenum</font></td>
<td valign="top"><font face="verdana" size="-1">$inner[0]</font></td>
<td valign="top"><font face="verdana" size="-1"><a href="$inner[3]" target="new">$inner[2]</a><BR><font size="-2">$inner[4]</font></font></td>
<td valign="top"><font face="verdana" size="-1">$adv[15]$inner[1]</font></td>
<td valign="top"><font face="verdana" size="-1"><a href="view.$file_ext?tab=deletelisting&user=$FORM{'user'}&listing=$term&member=$member&id=$site_id">Delete Listing</a></font></td>
</tr>
EOF
	}
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR>
<form METHOD="POST" ACTION="view.$file_ext?tab=deletemember&user=$FORM{'user'}&member=$member&type=$FORM{'type'}">
<input type="submit" value=" Delete Member ">
</form>
<BR><BR>
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub submit_profile {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my $member = $FORM{'member'};
my @info = &database_functions::GetUser($member);
my ($sitestatus);
if ($info[14] eq "inactive" && ($FORM{'status'} eq "active" || $FORM{'balance'} > 0)) {
	$FORM{'status'} = "active";
	if ($config{'data'} eq "text") {
		&database_functions::remove_status('inactive', $member);
		&database_functions::addstatus('active', $member);
		my $newdate = &main_functions::getdate;
		&database_functions::add_listing($member, $newdate);
	} else {
		$sitestatus = "approved";
	}
} elsif ($info[14] eq "active" && $FORM{'status'} eq "inactive") {
	if ($config{'data'} eq "text") { &database_functions::make_inactive($member); }
	else { $sitestatus = "inactive"; }
} else {
	$sitestatus = "approved";	
}
my $p = $FORM{'ccnumber'};
my $encryptkey = "drbidsearch";
$p = &main_functions::Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
my $pass2 = $FORM{'password'};
$encryptkey = "mempassbse";
$pass2 = &main_functions::Encrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
&database_functions::update_member($sitestatus, $p, $pass2, $member, %FORM);
my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Member Edited</B></font></font>";
&details($message);
}
###############################################


###############################################
sub addbalance {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	my $member = $FORM{'member'};
	my @user = &database_functions::GetUser($member);
	my $balance = &database_functions::GetBalance($member);
	my $newdate = &main_functions::getdate;
	if ($user[14] eq "inactive") {
		&database_functions::make_active($member);
	} elsif ($user[14] eq "active" && $balance <= 0 && $config{'data'} eq "text") {
		&database_functions::add_listing($member, $newdate);
	}

	$balance = &database_functions::GetBalance($member);
	my $newbalance = $balance + $FORM{'addbalance'};
	&database_functions::update_balance($member, $newbalance);
	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Balance Added</B></font></font>";
	&details($message);
}
###############################################


###############################################
sub deletelisting {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	my $member = $FORM{'member'};
	my $listing = $FORM{'listing'};
	&database_functions::delete_listing($member, $listing, $FORM{'id'});

	my $message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Listing Deleted</B></font></font>";
	&details($message);
}
###############################################


###############################################
sub deletemember {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	my $member = $FORM{'member'};

	unless ($FORM{'confirmed'}) {
		print "Content-type: text/html\n\n";
		&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Delete Member</U></B></font><P>
<center><BR>
<font face="verdana" size="-1" color="red"><B>Please confirm your action to delete member "$member"</B></font><BR>
<form METHOD="POST" ACTION="view.$file_ext?tab=deletemember&user=$FORM{'user'}&member=$member&confirmed=1&type=$FORM{'type'}">
<input type="submit" value=" Confirm Removal of Member ">
</form>
EOF
		&main_functions::footer;
		&main_functions::exit;
	} else {
		&database_functions::delete_member($member);
		print "Content-type: text/html\n\n";
		&main_functions::header(undef, $FORM{user});
print <<EOF;
<center>
<font face="verdana" size="-1" color="red"><B>Member Deleted</B></font><BR>
EOF
		&main_functions::footer;
		&main_functions::exit;
	}
}
###############################################


###############################################
sub email {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Email Members</U></B></font><P>
<center>
<form METHOD="POST" ACTION="view.$file_ext?tab=sendemail&user=$FORM{'user'}&file=bidsearchengine">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="20%"><font face="verdana" size="-1"><B>From:</B></font></td>
<td width="80%"><input type=text name=from size="20" value="$config{'adminemail'}"></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1"><B>To:</B></font></td>
<td width="80%"><select name="to"><option SELECTED>All Members</option>
<option>Processing Members</option>
<option>Active Members</option>
<option>Inactive Members</option>
</select>&nbsp;&nbsp;<font face="verdana" size="-1"><B>OR</B> Specific Email <input type=text name=to2 size="20"></font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1"><B>Subject:</B></font></td>
<td width="80%"><input type=text name=subject size="20"></td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Message:</B></font></td>
</tr>
<tr>
<td colspan=2>
<TEXTAREA NAME="message" ROWS=30 COLS=110 WRAP="ON">



$config{'company'}
$config{'websiteurl'}
</TEXTAREA></td>
</tr>
<tr>
<td colspan=2><input type=submit value="Send"></td>
</tr>
<tr>
<td colspan=2>&nbsp;</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Tags</B></font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1">[name]</font></td>
<td width="80%"><font face="verdana" size="-1">Displays the members name</font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1">[username]</font></td>
<td width="80%"><font face="verdana" size="-1">Displays the members username</font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1">[password]</font></td>
<td width="80%"><font face="verdana" size="-1">Displays the members password</font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1">[mailingaddress]</font></td>
<td width="80%"><font face="verdana" size="-1">Displays the members mailing address</font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1">[phone]</font></td>
<td width="80%"><font face="verdana" size="-1">Displays the members phone number</font></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1">[balance]</font></td>
<td width="80%"><font face="verdana" size="-1">Displays the members current balance</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub sendemail {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my $mailer = $config{'mailer'};
my $from = $FORM{'from'};
my ($org_message);
my $subject = $FORM{'subject'};
my @message = split(/\n/, $FORM{'message'});
foreach my $line(@message) {
	chomp($line);
	$org_message .= "$line\n";
}
if ($config{'data'} eq "mysql") { $org_message = &database_functions::unescape($org_message); }
my (@user);
if ($FORM{'to2'}) { @user = () }
elsif ($FORM{'to'} eq "All Members") { @user = &database_functions::gather_emails('all'); }
elsif ($FORM{'to'} eq "Processing Members") { @user = &database_functions::gather_emails('processing'); }
elsif ($FORM{'to'} eq "Active Members") { @user = &database_functions::gather_emails('active'); }
elsif ($FORM{'to'} eq "Inactive Members") { @user = &database_functions::gather_emails('inactive'); }
#else { &collect_vars($org_message, $from, $subject, undef); }

if (@user) {
	foreach my $line(@user) {
		my @info = &database_functions::GetUser($line);
		&sendout($org_message, $from, $subject, @info);
	}
} else {
	&sendout($org_message, $from, $subject);
}

sub sendout {
	my ($org_message, $from, $subject, @info) = @_;
	my ($to);
	if ($FORM{'to2'}) { $to = $FORM{'to2'}; }
	else { $to = $info[8]; }
	my $balance = &database_functions::GetBalance($info[12]);
	my $message = $org_message;
	$message =~ s/\[name\]/$info[0]/ig;
	$message =~ s/\[username\]/$info[12]/ig;
	my $pass2 = $info[13];
	my $encryptkey = "mempassbse";
	$pass2 = &main_functions::Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
	$message =~ s/\[password\]/$pass2/ig;
	my $address = "$info[1]\n";
	if ($info[2]) { $address .= "$info[2]\n"; }
	$address .= "$info[3], $info[4]  $info[5]\n$info[6]\n";
	$message =~ s/\[mailingaddress\]/$address/ig;
	$message =~ s/\[phone\]/$info[7]/ig;
	$message =~ s/\[balance\]/$balance/ig;
	&main_functions::send_email($from, $to, $subject, $message);
}

print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<center><font face="verdana" color="red"><B>Email Message Sent!</B></font>
<BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################