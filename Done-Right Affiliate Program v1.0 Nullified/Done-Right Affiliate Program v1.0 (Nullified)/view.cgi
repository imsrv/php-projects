#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/affiliate/"; # With a slash at the end as shown
$path = "";

# Code added by TNO - Naughty people at Done-Right thought they would spy on you by
# calling images from their server, tut tut! These images come with this warez release
# so please specify the full url where you will upload these images to on your server.
# Example:
# $tno = "http://www.yourdomain.com/images"; # Do not add a trailing slash
$tno = "";

#### Nothing else needs to be edited ####

# Affiliate Program by Done-Right Scripts
# Admin Script
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright й 2000 Done-Right. All rights reserved.


###############################################
#Read Input
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
		$FORM{$name} = $value;
	}
}
###############################################

use DB_File;
use Fcntl qw(:DEFAULT :flock);
###############################################
if ($FORM{'tab'} eq "view") { &view; }
elsif ($FORM{'tab'} eq "details") { &details; }
elsif ($FORM{'tab'} eq "deletemember") { &deletemember; }
elsif ($FORM{'tab'} eq "email") { &email; }
elsif ($FORM{'tab'} eq "sendemail") { &sendemail; }
elsif ($FORM{'tab'} eq "search") { &search; }
elsif ($FORM{'tab'} eq "sendcheck") { &sendcheck; }
else { &main; }
###############################################


###############################################
#Security Check
sub checklogin {
require "${path}config/config.cgi";

$current_time = time();
$ip = $ENV{'REMOTE_ADDR'};

$p = $FORM{'user'};
$encryptkey = "draffiliate";
$p = &Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
if ($p eq $config{'user'}) {
	open (FILE, "${path}config/session.txt");
	@session = <FILE>;
	close (FILE);
	$ff=0;
	foreach $line(@session) {
		chomp($line);
		@inner = split(/\|/, $line);
		if ($inner[0] eq $ip) {
			$elapsed = $current_time - $inner[1];
			if ($elapsed > 3600) {
				$logmessage = "Session Expired, Please <a href=admin.cgi>click here</a> to re-login";
				&expiredsession;
				last;
			} else {
				$verified=1;
				open (FILE, "${path}config/session.txt");
				@session = <FILE>;
				close (FILE);
				open (FILE, ">${path}config/session.txt");
				$ss=0;
				foreach $line(@session) {
					chomp($line);
					if ($ff == $ss) {
						@inner = split(/\|/, $line);
						print FILE "$inner[0]|$current_time\n";
					} else { print FILE "$line\n"; }
					$ss++;
				}
				close (FILE);
				$encryptkey = "draffiliate";
				$p = &Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
				$FORM{'user'} = $p;
				last;
			}
		}
		$ff++;
	}
}


unless ($verified) {
	print "Content-type: text/html\n\n";
	$nolink=1;
	&header;
	if ($logmessage) { print $logmessage; }
	else { print "Access Denied. Please <a href=admin.cgi>click here</a> to login"; }
	&footer;
	exit;
}

sub expiredsession {
	open (FILE, "${path}config/session.txt");
	@session = <FILE>;
	close (FILE);
	open (FILE, ">${path}config/session.txt");
	foreach $line(@session) {
		chomp($line);
		@inner = split(/\|/, $line);
		$elapsed = $current_time - $inner[1];
		unless ($elapsed > 3600) {
			print FILE "$line\n";
		}
	}
	close (FILE);
}
}
###############################################


###############################################
sub main {
&checklogin;
print "Content-type: text/html\n\n";
&header;

opendir(FILE,"${path}stats");
@stats = grep { /.db/ } readdir(FILE);
closedir (FILE);
$mon = (localtime)[4]+1;
$all=$active=$inactive=$owed="0";
foreach $line(@stats) {
	chomp($line);
	unless ($line eq ".db") {
		$username = $line;
		$username =~ s/.db//;
		$DBNAME = "${path}stats/$line";
		tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
		if (exists $click_hash{'lastrun'}) { $timeperiod = $mon-$click_hash{'lastrun'}; }
		else { $timeperiod = 0; }
		if ($timeperiod >= 2) { $inactive++; }
		$paidowing = $add = 0;
		foreach $key (keys %click_hash) {
			if ($key =~ /MON/) {
				$key =~ s/MON//;
				unless (exists $click_hash{"PAID".$key}) {
					if ($config{'pay'} == 3) {
						@three = split(/\|/, $click_hash{"MON".$key});
						$add += $three[1];
					} else {
						$add += $click_hash{"MON".$key};
					}
				}
			}
		}
		$paidowing = $add*$config{'amount'};
		if ($paidowing >= $config{'sendchecks'}) { $owed++; }
		$all++;
		untie %click_hash;
	}
}
$active = $all-$inactive;
print <<EOF;
<font face="verdana" size="-1"><B><U>View Members</U></B></font><P>
<center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><font face="verdana" size="-1"><B>Amount of total members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$all</font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Amount of active members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$active</font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Amount of inactive members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$inactive</font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Amount of members owed money:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$owed</font></td>
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
<td width="35%"><font face="verdana" size="-1"><a href="view.cgi?tab=view&user=$FORM{'user'}&type=all&number=$all">All Members</a></td>
<td width="65%"><font face="verdana" size="-1">View active and inactive members.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.cgi?tab=view&user=$FORM{'user'}&type=active&number=$active">Active Members</a></td>
<td width="65%"><font face="verdana" size="-1">View members with active accounts.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.cgi?tab=view&user=$FORM{'user'}&type=inactive&number=$inactive">Inactive Members</a></td>
<td width="65%"><font face="verdana" size="-1">View members with inactive accounts (haven't generated a click for 2 months).</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.cgi?tab=view&user=$FORM{'user'}&type=owing&number=$owed">Members Owed Money</a></td>
<td width="65%"><font face="verdana" size="-1">Members that have generated more than \$$config{'sendchecks'} over the past months.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR>
<form METHOD="POST" ACTION="view.cgi?tab=search&user=$FORM{'user'}&file=affiliateprogram">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td><font face="verdana" size="-1" color="#000099"><B>Search for Member</B></font></td></tr>
<tr><td><font face="verdana" size="-1">
Account Name: <input type=text name=member size=30>&nbsp;<input type=submit value="Search"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&footer;
}
###############################################


###############################################
sub view {
&checklogin;
print "Content-type: text/html\n\n";
&header;
$type = $typedisplay = $FORM{'type'};
$typedisplay = "\u$typedisplay";

$count = $FORM{'number'};

unless ($FORM{'start'}) { $FORM{'start'} = 1; }
unless ($FORM{'end'}) {
	if ($count >= 20) { $FORM{'end'} = 20; }
	else { $FORM{'end'} = $count; }
}
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing $typedisplay Affiliate Members</U> - <font color=red>$FORM{'start'} to $FORM{'end'} of $count</U></B></font><P>
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
$sort = $FORM{'sort'};
if ($FORM{'sort'} eq "" || $FORM{'sort'} eq "account") {
$sort = "account";
$field = 0;
print <<EOF;
<td><font face="verdana" size="-1"><B>Account</B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=created&number=$count">Account Created</a></B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=amount&number=$count">Amount</a></B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=clicks&number=$count">Click-Throughs/Searches</a></B></td>
EOF
} elsif ($FORM{'sort'} eq "created") {
$field = 1;
print <<EOF;
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=account&number=$count">Account</a></B></td>
<td><font face="verdana" size="-1"><B>Account Created</B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=amount&number=$count">Amount</a></B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=clicks&number=$count">Click-Throughs/Searches</a></B></td>
EOF
} elsif ($FORM{'sort'} eq "amount") {
$field = 2;
print <<EOF;
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=account&number=$count">Account</a></B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=created&number=$count">Account Created</a></B></td>
<td><font face="verdana" size="-1"><B>Amount</B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=clicks&number=$count">Click-Throughs/Searches</a></B></td>
EOF
} elsif ($FORM{'sort'} eq "clicks") {
$field = 3;
print <<EOF;
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=account&number=$count">Account</a></B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=created&number=$count">Account Created</a></B></td>
<td><font face="verdana" size="-1"><B><a href="view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=amount&number=$count">Amount</a></B></td>
<td><font face="verdana" size="-1"><B>Click-Throughs/Searches</B></td>
EOF
}
print "</tr>";

opendir(FILE,"${path}stats");
@stats = grep { /.db/ } readdir(FILE);
closedir (FILE);
$mon = (localtime)[4]+1;

if ($FORM{'tab'} eq "search") {
	foreach $line(@members) {
		chomp($line);
		$account = $line;
		$DBNAME = "${path}stats/$line.db";
		tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
		&fillvar;
		untie %click_hash;
	}
} else {
	foreach $line(@stats) {
		chomp($line);
		unless ($line eq ".db") {
			$account = $line;
			$account =~ s/.db//;
			$DBNAME = "${path}stats/$line";
			tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
			if ($type eq "all" || $type eq "owing") { &fillvar; }
			else {
				if (exists $click_hash{'lastrun'}) { $timeperiod = $mon-$click_hash{'lastrun'}; }
				else { $timeperiod = 0; }
				if ($type eq "inactive" && $timeperiod >= 2) { &fillvar; }
				elsif ($type eq "active" && $timeperiod < 2) { &fillvar; }
			}
			untie %click_hash;
		}
	}
}
sub fillvar {
	open (FILE, "${path}users/$account.txt");
	@info = <FILE>;
	close (FILE);
	chomp (@info);
	$created = $info[16];
	$created =~ s/\-//g;
	$amount=$clicks=$owing="0";
	foreach $key (keys %click_hash) {
		if ($key =~ /MON/ || $key =~ /STAT/) {
			$key2 =~ s/MON//;
			unless (exists $click_hash{"PAID".$key2}) {
				if ($config{'pay'} == 3) {
					@sp = split(/\|/, $click_hash{$key});
					$amount += $config{'amount'}*$sp[1];
					$clicks += $sp[0];
					if ($type eq "owing" && $key !~ /STAT/) {
						$owing += $config{'amount'}*$sp[1];	
					}
				} else {
					$amount += $click_hash{$key}*$config{'amount'};
					$clicks += $click_hash{$key};
					if ($type eq "owing" && $key !~ /STAT/) {
						$owing += $click_hash{$key}*$config{'amount'};
					}
				}
			}
		}
	}
	$amount = sprintf("%.2f", $amount);
	if ($type eq "owing") {
	 	if ($owing >= $config{'sendchecks'}) {
	 		$member[$plus] = "$account|$created|$amount|$clicks\n";
	 		$plus++;
	 	}
	} else {
		$member[$plus] = "$account|$created|$amount|$clicks\n";
		$plus++;
	}
}

if ($plus == 1) {
	@sorted_links = @member;
} else {
	if ($field == 0 || $field == 1) {
		@sorted_links =
			sort {
			my @field_a = split /\|/, $a;
			my @field_b = split /\|/, $b;
				$field_a[$field] cmp $field_b[$field]
								||
				$field_a[0] cmp $field_b[0]
				;
		} @member;
	} else {
		@sorted_links =
			reverse sort {
			my @field_a = split /\|/, $a;
			my @field_b = split /\|/, $b;
				$field_a[$field] <=> $field_b[$field]
								||
				$field_a[0] cmp $field_b[0]
				;
		} @member;
	}
}
foreach $member(@sorted_links) {
	chomp($member);
	@inner = split(/\|/, $member);
	substr($inner[1],4,0) = "-";
	substr($inner[1],7,0) = "-";
print <<EOF;
<tr>
<td><font face="verdana" size="-1"><a href="view.cgi?tab=details&user=$FORM{'user'}&member=$inner[0]">$inner[0]</a></B></td>
<td><font face="verdana" size="-1">$inner[1]</B></td>
<td><font face="verdana" size="-1">\$$inner[2]</B></td>
<td><font face="verdana" size="-1">$inner[3]</B></td>
</tr>
EOF
}

print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
<center><font face="verdana" size="-1"><B>
EOF

$start = $FORM{'start'}+20;
$end = $FORM{'end'}+20;
$start2 = $FORM{'start'}-20;
$end2 = $FORM{'end'}-20;
if ($FORM{'start'} == 1) { print "Previous 20 | "; }
else { print "<a href=\"view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=$FORM{'sort'}&start=$start2&end=$end2&number=$count\">Previous 20</a> | "; }
if ($FORM{'end'} >= $plus) { print "Next 20"; }
else { print "<a href=\"view.cgi?tab=view&user=$FORM{'user'}&type=$type&sort=$FORM{'sort'}&start=$start&end=$end&number=$count\">Next 20</a>"; }


print <<EOF;
</font></B></center>
EOF
&footer;
}
###############################################


###############################################
sub search {
$member = $FORM{'member'};
opendir(FILE,"${path}users");
@members2 = grep { /.txt/ } readdir(FILE);
closedir (FILE);
foreach $mem(@members2) {
	chomp($mem);
	$mem =~ s/.txt//;
	if ($mem =~ /$member/) {
		$members[$i] = $mem;
		$i++;
		$found=1;
	}
}
$FORM{'number'} = $i;
unless ($found) { &notfound; }
else { &view; }
}
###############################################


###############################################
sub notfound {
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing Member</U></B></font><P>
<center><font face="verdana" size="-1" color="red">Found no accounts to match keyword <B>$member</B><BR><BR>
<form METHOD="POST" ACTION="view.cgi?tab=details&user=$FORM{'user'}">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td><font face="verdana" size="-1" color="#000099"><B>Search for Member</B></font></td></tr>
<tr><td><font face="verdana" size="-1">
Account Name: <input type=text name=member size=30>&nbsp;<input type=submit value="Search"></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub details {
&checklogin;
$member = $FORM{'member'};
unless (-e "${path}users/$member.txt") {
	&notfound;
	exit;
}
open (FILE, "${path}users/$member.txt");
@info = <FILE>;
close (FILE);
chomp(@info);

if ($info[4]) { $address2 = " (Address 2: $info[4])"; }
$pass = $info[15];
$encryptkey = "mempassaff";
$pass = &Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');

$mon = (localtime)[4]+1;
$owing=$paid="0";
$DBNAME = "${path}stats/$member.db";
tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
if (exists $click_hash{'lastrun'}) { $timeperiod = $mon-$click_hash{'lastrun'}; }
else { $timeperiod = 0; }
if ($timeperiod >= 2) { $status = "Inactive (Has not had a click for $timeperiod months)"; }
else { $status = "active"; }
foreach $key (keys %click_hash) {
	if ($key =~ /MON/) {
		$key2 =~ s/MON//;
		unless (exists $click_hash{"PAID".$key2}) {
			if ($config{'pay'} == 3) {
				@sp = split(/\|/, $click_hash{$key});
				$owing += $config{'amount'}*$sp[1];
			} else {
				$owing += $click_hash{$key}*$config{'amount'};
			}
		} else {
			$paid += $click_hash{$key};
		}
	}
}
$owing = sprintf("%.2f", $owing);
$paid = sprintf("%.2f", $paid);
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Viewing Member</U> - <font color=red>$member</font></B></font><P>
<center><BR>
$message<BR>
<font face="verdana" size="-1"><a href="#statistics">Statistics</a> | <a href="#delete">Delete Member</a> | <a href="#pay">Pay Member</a>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="40%"><font face="verdana" size="-1">Account Created:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[16]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Status:</font></td>
<td width="60%"><font face="verdana" size="-1">$status</font></td>
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
<td width="40%"><font face="verdana" size="-1">Checks Payable To:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[1]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Email:</font></td>
<td width="60%"><font face="verdana" size="-1"><a href="mailto:$info[2]">$info[2]</a></font></td>
</tr>
<tr>
<td width="40%" valign=top><font face="verdana" size="-1">Address:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[3] $address2<BR>$info[5], $info[6], $info[8]<BR>$info[7]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Phone:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[9]</font></td>
</tr>
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Site Information</B></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Title:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[10]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">URL:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[11]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Category:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[12]</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Hits/month:</font></td>
<td width="60%"><font face="verdana" size="-1">$info[13]</font></td>
</tr>
<tr>
<td colspan=2><BR><font face="verdana" size="-1" color="#000099"><B>Payment Information</B></font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Total Amount Received/Paid:</font></td>
<td width="60%"><font face="verdana" size="-1">\$$paid</font></td>
</tr>
<tr>
<td width="40%"><font face="verdana" size="-1">Total Amount Owing:</font></td>
<td width="60%"><font face="verdana" size="-1">\$$owing</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR>
<BR></form>
<a name="statistics"><table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=4><font face="verdana" size="-1" color="#000099"><B>Statistics</B></font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Date</B></font></td>
<td><font face="verdana" size="-1"><B>Click-Throughs/Searches</B></font></td>
<td><font face="verdana" size="-1"><B>Amount</B></font></td>
<td><font face="verdana" size="-1"><B>Paid/Owing</B></font></td>
</tr>
EOF
%month = ("1"	=> "January",
		  "2"	=> "Febuary",
		  "3"	=> "March",
		  "4"	=> "April",
		  "5"	=> "May",
		  "6"	=> "June",
		  "7"	=> "July",
		  "8"	=> "August",
		  "9"	=> "September",
		  "10"	=> "October",
		  "11"	=> "November",
		  "12"	=> "December");
		  
$plus = 0;
$payamount = $config{'amount'};
$pay = $config{'pay'};
foreach $key (keys %click_hash) {
	if ($key =~ /STAT/) {
		$key =~ s/STAT//;
		unless ($additex) {
			$addit = $plus;
			$plus++;
			$additex = 1;
		}
		@sp = split(/\./, $key);
		if ($pay == 3) {
			@sp2 = split(/\|/, $click_hash{"STAT".$key});
			$addup += $sp2[0];
			$clk = $addup;
			$amt = $sp2[1]*$payamount;
		} else {
			$addup += $click_hash{"STAT".$key};
			$clk = $addup;
			$amt = $addup*$payamount;
		}
		$member[$addit] = "$sp[1].$sp[2]|$clk|$amt|OWING (But month not over)";
	} elsif ($key =~ /MON/) {
		$val = $key;
		$key =~ s/MON//;
		&tally;
	}
}

sub tally {
	if ($pay == 3) {
		@sp = split(/\|/, $click_hash{$val});
		$clk = $sp[0];
		$amt = $sp[1]*$payamount;
	} else {
		$clk = $click_hash{$val};
		$amt = $click_hash{$val}*$payamount;
	}
	if (exists $click_hash{"PAID".$key}) { $paidowing = "PAID"; }
	else {
		$paidowing = "OWING";
		$dateperiod .= "$key-$amt|";
		$totalamount += $amt;
	}
	$member[$plus] = "$key|$clk|$amt|$paidowing";
	$plus++;
}

if ($plus == 1) {
	@sorted_links = @member;
} else {
	@sorted_links =
		sort {
		my @field_a = split /\|/, $a;
		my @field_b = split /\|/, $b;
			$field_a[$field] cmp $field_b[$field]
							||
			$field_a[0] cmp $field_b[0]
			;
		} @member;
}
untie %click_hash;

foreach $line(@sorted_links) {
	chomp($line);
	unless ($line eq "") {
		@inner = split(/\|/, $line);
		@date = split(/\./, $inner[0]);
		$formal = "$month{$date[0]} $date[1]";
		$inner[2] = sprintf("%.2f", $inner[2]);
print <<EOF;
<tr>
<td valign="top"><font face="verdana" size="-1">$formal</font></td>
<td valign="top"><font face="verdana" size="-1">$inner[1]</font></td>
<td valign="top"><font face="verdana" size="-1">\$$inner[2]</font></td>
<td valign="top"><font face="verdana" size="-1">$inner[3]</font></td>
</tr>
EOF
	}
}

print <<EOF;
</table>
</td></tr></table>
</td></tr></table><BR>
<a name="delete"><form METHOD="POST" ACTION="view.cgi?tab=deletemember&user=$FORM{'user'}&member=$member">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><font face="verdana" size="-1" color="#000099"><B>Delete Member</B></font></td>
</tr>
<tr>
<td><input type="submit" value=" Delete Member "></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR>
</form>
<BR>
<a name="pay"><form METHOD="POST" ACTION="view.cgi?tab=sendcheck&user=$FORM{'user'}&member=$member&data=$dateperiod&total=$totalamount">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=3><font face="verdana" size="-1" color="#000099"><B>Pay Member</B></font></td>
</tr>
EOF
if ($dateperiod eq "") {
print <<EOF;
<tr>
<td colspan=3><font face="verdana" size="-1"><B>Member not owed money.  If member has made money this month, you cannot pay member until the month is over.</B></font></td>
</tr>
EOF
} else {
print <<EOF;
<tr>
<td><font face="verdana" size="-1"><B>Date</td>
<td><font face="verdana" size="-1"><B>Amount</td>
</tr>
EOF
chop($dateperiod);
@timeperiod = split(/\|/, $dateperiod);
foreach $line(@timeperiod) {
	chomp($line);
	@dateamt = split(/\-/, $line);
	@innersp = split(/\./, $dateamt[0]);
print <<EOF;
<tr>
<td><font face="verdana" size="-1">$month{$innersp[0]} $innersp[1]</td>
<td><font face="verdana" size="-1">\$$dateamt[1]</td>
</tr>
EOF
}
print <<EOF;
<tr>
<td></td>
<td><font face="verdana" size="-1"><B>TOTAL: \$$totalamount</td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Pay Member"></td>
</tr>
EOF
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
</font></B></center>
<BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub sendcheck {
&checklogin;
$member = $FORM{'member'};
$amount = $FORM{'amt'};
%month = ("1"	=> "January",
		  "2"	=> "Febuary",
		  "3"	=> "March",
		  "4"	=> "April",
		  "5"	=> "May",
		  "6"	=> "June",
		  "7"	=> "July",
		  "8"	=> "August",
		  "9"	=> "September",
		  "10"	=> "October",
		  "11"	=> "November",
		  "12"	=> "December");
$data = $FORM{'data'};
@innerdata = split(/\|/, $data);
$total = $FORM{'total'};

$LCK = "lockfile";
sysopen(DBLOCK, $LCK, O_RDONLY | O_CREAT) or die "can't open $LCK: $!";
flock(DBLOCK, LOCK_SH) or die ("can't LOCK_SH $LCK");
$DBNAME = "${path}stats/$member.db";
tie(%hash, "DB_File", $DBNAME, O_RDWR|O_CREAT) or die ("Cannot open database $DBNAME: $!");
foreach $line(@innerdata) {
	chomp($line);
	@dateamt = split(/\-/, $line);
	@innersp = split(/\./, $dateamt[0]);
	$hash{"PAID".$dateamt[0]} = $total;
	$formal .= "$month{$innersp[0]} $innersp[1],";
}
chop($formal);
untie %hash;
close DBLOCK;

open (FILE, "${path}users/$member.txt");
@info = <FILE>;
close (FILE);
chomp(@info);
$info[17] .= "$data";
open (FILE, ">${path}users/$member.txt");
foreach $line(@info) {
	chomp($line);
	print FILE "$line\n";
}
close (FILE);
$email = $info[2];
chomp($email);
open (FILE, "${path}template/emailinvoice.txt");
@emailmess = <FILE>;
close (FILE);
foreach $emailtemp2(@emailmess) {
	chomp($emailtemp2);
	$emailtemp .= "$emailtemp2\n";
}
$emailtemp =~ s/\[name\]/$info[0]/ig;
$emailtemp =~ s/\[date\]/$formal/ig;
$emailtemp =~ s/\[amount\]/\$$total/ig;
$emailtemp =~ s/\[company\]/$config{'company'}/ig;
$emailtemp =~ s/\[url\]/$config{'websiteurl'}/ig;

if ($config{'server'} eq "nt") {
	eval { require Net::SMTP; };
	$smtp = Net::SMTP->new($sendmail);
	$smtp->mail($from);
	$smtp->to($email);

	$smtp->data();
	$smtp->datasend("To: $email\n");
	$smtp->datasend("From: $config{'adminemail'}\n");
	$smtp->datasend("Subject: $config{'company'} - Affiliate Program Invoice\n");
	$smtp->datasend($emailtemp);
	$smtp->dataend();
	$smtp->quit;
} else {
	open(MAIL,"|$config{'sendmail'} -t");
	print MAIL "Subject: $config{'company'} - Affiliate Program Invoice\n";
	print MAIL "To: $email\n";
	print MAIL "From: $config{'adminemail'}\n";
print MAIL <<EOF;
$emailtemp
EOF
	close(MAIL);
}

$message = "<font face=verdana size=-1><B>Message:</B> <font color=red>Balance of \$$total paid & email invoice sent</B></font></font>";
&details;
exit;
}
###############################################


###############################################
sub message {
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1" color="red"><B>$message</B></font><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
sub deletemember {
&checklogin;
$member = $FORM{'member'};

unless ($FORM{'confirmed'}) {
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Delete Member</U></B></font><P>
<center><BR>
<font face="verdana" size="-1" color="red"><B>Please confirm your action to delete member "$member"</B></font><BR>
<form METHOD="POST" ACTION="view.cgi?tab=deletemember&user=$FORM{'user'}&member=$member&confirmed=1">
<input type="submit" value=" Confirm Removal of Member ">
</form>
EOF
&footer;
} else {


unlink("${path}users/$member.txt");
unlink("${path}stats/$member.db");

print "Content-type: text/html\n\n";
&header;
print <<EOF;
<center>
<font face="verdana" size="-1" color="red"><B>Member Deleted</B></font><BR>
EOF
&footer;
}
}
###############################################


###############################################
sub email {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Email Members</U></B></font><P>
<center>
<form METHOD="POST" ACTION="view.cgi?tab=sendemail&user=$FORM{'user'}&file=affiliateprogram">
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
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub sendemail {
&checklogin;
$mailer = $config{'mailer'};
$from = $FORM{'from'};
if ($FORM{'to2'}) { $to = $FORM{'to2'}; }
else { $to = $FORM{'to'}; }
$subject = $FORM{'subject'};
$message = $FORM{'message'};

if ($to eq "All Members") {
	opendir(FILE,"${path}users");
	@emails = grep { /.txt/ } readdir(FILE);
	closedir (FILE);
	&gather;
} elsif ($to eq "Active Members" || $to eq "Inactive Members") {
	opendir(FILE,"${path}stats");
	@stats = grep { /.db/ } readdir(FILE);
	closedir (FILE);
	$mon = (localtime)[4]+1;

	foreach $line(@stats) {
		chomp($line);
		$username = $line;
		$username =~ s/.db//;
		$DBNAME = "${path}stats/$line";
		tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
		if (exists $click_hash{'lastrun'}) { $timeperiod = $mon-$click_hash{'lastrun'}; }
		else { $timeperiod = 0; }
		if ($to eq "Inactive Members") {
			if ($timeperiod >= 2) { $emails[$plus] = "$username.txt"; }
		} else {
			if ($timeperiod < 2) { $emails[$plus] = "$username.txt"; }
		}
		$plus++;
		untie %click_hash;
	}
	&gather;
} else {
	&sendout;	
}

sub gather {
	foreach $line(@emails) {
		chomp($line);
		open(DATA,"${path}users/$line");
		@info = <DATA>;
		close(DATA);
		chomp(@info);
		$to = $info[2];
		&sendout;
	}	
}

sub sendout {
	$message =~ s/\[name\]/$info[0]/ig;
	if ($config{'server'} eq "nt") {
		eval { require Net::SMTP; };
		$smtp = Net::SMTP->new($sendmail);
		$smtp->mail($from);
		$smtp->to($to);

		$smtp->data();
		$smtp->datasend("To: $to\n");
		$smtp->datasend("From: $from\n");
		$smtp->datasend("Subject: $subject\n");
		$smtp->datasend($message);
		$smtp->dataend();
		$smtp->quit;
	} else {
		open(MAIL,"|$config{'sendmail'} -t");
		print MAIL "Subject: $subject\n";
		print MAIL "To: $to\n";
		print MAIL "From: $from\n";
	}
print MAIL <<EOF;
$message
EOF
	close(MAIL);
}
	

print "Content-type: text/html\n\n";
&header;
print <<EOF;
<center><font face="verdana" color="red"><B>Email Message Sent!</B></font>
<BR><BR>
EOF
&footer;
}
###############################################


###############################################
#Header HTML
sub header {
print <<EOF;
<html>
 <head>
 
 <title>Admin Area</title>
 <style>
 <!--
 BODY      {font-family:verdana;}
 A:link    {text-decoration: underline;  color: #000099}
 A:visited {text-decoration: underline;  color: #000099}
 A:hover   {text-decoration: none;  color: #000099}
 A:active  {text-decoration: underline;  color: #000099}
 -->
 </style> 
 <body text="#000000" bgcolor="#333333" link="#000099" vlink="#000099" alink="#000099">
 
 <!-- start top table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td width="1"><img SRC="$tno/place.gif" height=1 width=5></td>
 
 <td><img SRC="$tno/place.gif" height=5 width=1></td>
 
 <td width="1"><img SRC="$tno/place.gif" height=1 width=5></td> </tr>
 
 <tr>
 <td width="10%"><img SRC="$tno/place.gif" height=1 width=5></td>
 
 <td>
 
 <!-- start logo table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=2 WIDTH="100%" BGCOLOR="#000066" >
 <tr>
 <td width="15%">
<img src="$tno/smalllogo.gif" ALT="Done-Right Scripts" WIDTH="130" HEIGHT="83">
</td>
 <td valign=bottom><center><img src="$tno/adminarea.gif" width=351 height=60></center>
 </td>
 <td width="15%">
<img src="$tno/smalllogo.gif" ALT="Done-Right Scripts" ALIGN="RIGHT" WIDTH="130" HEIGHT="83">
</td>
 </tr>
 </center></table>
 <!-- end logo table -->
 
 <!-- start border table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td><img SRC="$tno/place.gif" height=5 width=1></td>
 </tr>
 </center></table>
 <!-- end border table -->

 <!-- start home and date table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <tr><td>
EOF
$url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
unless ($nolink == 1) {
print <<EOF;
<center><font face="verdana" size="-1"><B><a href="admin.cgi?tab=login&user=$FORM{'user'}&file=affiliateprogram">Main</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=config&user=$FORM{'user'}&file=affiliateprogram">Configure Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<strike>Download</strike>&nbsp;&nbsp;|&nbsp;&nbsp;
<strike>Support</strike>&nbsp;&nbsp;|&nbsp;&nbsp;
<strike>Feedback</strike></font></b>
<BR><font face="verdana" size="-1"><B><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">Customize</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="view.cgi?user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">View Members</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="view.cgi?tab=email&user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">Email</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=statistics&user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">Statistics</font></a></center></font></b>
EOF
} else {
	print "&nbsp;";
}
print <<EOF;
 </td>
 </TR>
 </TABLE></CENTER>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="$tno/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=4 COLS=1 WIDTH="100%" BGCOLOR="#FFFFFF" >
 <TR>
 <TD>
<P><BR><center>

EOF
}
###############################################


###############################################
#Footer HTML
sub footer {
print <<EOF;

 </td></tr></table>
 <TD><IMG SRC="$tno/place.gif" height=1 width=5></TD>
 </TR>
 
 <TR>
 <TD><IMG SRC="$tno/place.gif" height=1 width=5></TD>
 
 <TD>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 ADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="$tno/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <TR><TD>
 <CENTER>&nbsp;</CENTER>
 </TD>
 <TD align="center"><FONT color="#000066" FACE=verdana size="-1">www.done-right.net
 </TD>
 </TR>
 </TABLE></CENTER>
 
 <IMG SRC="$tno/place.gif" height=5 width=1></TD>
 
 <TD><IMG SRC="$tno/place.gif" height=1 width=5></TD>
 </TR>
 
 </TABLE></CENTER>
  
 </BODY>
 </HTML>
</body></html>
EOF
}
###############################################


###############################################
sub Encrypt {
#	($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
#	$encryptkey = "$encryptkey$dayofyear";
    my ($source,$key,$pub_key) = @_;
    my ($cr,$index,$char,$key_char,$enc_string,$encode,$first,
        $second,$let1,$let2,$encrypted,$escapes) = '';
    $source = &rot13($source); 
    $cr = '╖иа'; 
    $source =~ s/[\n\f]//g; 
    $source =~ s/[\r]/$cr/g; 
    while ( length($key) < length($source) ) { $key .= $key } 
    $key=substr($key,0,length($source)); 
    while ($index < length($source)) { 
        $char = substr($source,$index,1);
        $key_char = substr($key,$index,1);
        $enc_string .= chr(ord($char) ^ ord($key_char));
        $index++;
    }
    for (0..255) { $escapes{chr($_)} = sprintf("%2x", $_); } 
    $index=0;
    while ($index < length($enc_string)) { 
        $char = substr($enc_string,$index,1);
        $encode = $escapes{$char};
        $first = substr($encode,0,1);
        $second = substr($encode,1,1);
        $let1=substr($pub_key, hex($first),1);
        $let2=substr($pub_key, hex($second),1);
        $encrypted .= "$let1$let2";
        $index++;
    }
    return $encrypted;
}
###############################################


###############################################
sub Decrypt {
#	($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
#	$encryptkey = "$encryptkey$dayofyear";
    my ($encrypted, $key, $pub_key) = @_;
    $encrypted =~ s/[\n\r\t\f]//eg; 
    my ($cr,$index,$decode,$decode2,$char,$key_char,$dec_string,$decrypted) = '';
    while ( length($key) < length($encrypted) ) { $key .= $key }
    $key=substr($key,0,length($encrypted)); 
    while ($index < length($encrypted)) {
        $decode = sprintf("%1x", index($pub_key, substr($encrypted,$index,1)));
        $index++;
        $decode2 = sprintf("%1x", index($pub_key, substr($encrypted,$index,1)));
        $index++;
        $dec_string .= chr(hex("$decode$decode2")); 
    }
    $index=0;
    while( $index < length($dec_string) ) { 
        $char = substr($dec_string,$index,1);
        $key_char = substr($key,$index,1);
        $decrypted .= chr(ord($char) ^ ord($key_char));
        $index++;
    }
    $cr = '╖иа'; 
    $decrypted =~ s/$cr/\r/g;
    return &rot13( $decrypted ); 
}
###############################################


###############################################
sub rot13{ 
    my $source = shift (@_);
    $source =~ tr /[a-m][n-z]/[n-z][a-m]/; 
    $source =~ tr /[A-M][N-Z]/[N-Z][A-M]/;
    $source = reverse($source);
    return $source;
}
###############################################
