#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Members Script
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
use vars qw(%config %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value $user $pass);
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
&main_functions::checkpath('members', $path);
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

my ($adminemail, $adminurl, $company, $websiteurl) = (&main_functions::config_vars())[0,1,3,4];

# Check Login
local ($user, $pass);
if ($FORM{'tab'}) {
	unless ($FORM{'tab'} eq "forgot" || $FORM{'tab'} eq "modifyprofile") {
		if ($FORM{'password'}) {
			$user=$FORM{'username'};
			$pass=$FORM{'password'};
			$pass = &passcheck($user, $pass);
		} else {
			$user=$FORM{'user'};
			$pass=$FORM{'pass'};
			my $encryptkey = "drbidsearch";
			$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
			$pass = &passcheck($user, $pass);
		}
		sub passcheck {
			my ($user, $pass) = @_;
			my $error;
			if ($user eq "") {
				$error = "Invalid Login";
				&main($error);
			} elsif ($pass eq "") {
				$error = "Invalid Login";
				&main($error);
			}
	    	my @info = &database_functions::GetUser($user);
			if (@info == 0) {
				$error = "Invalid Login";
				&main($error);
			}

			if ($info[14] eq 'processing') {
				$error = "Your Account Has Not Been Approved Yet, Please Try Again Later";
				&main($error);
			}

			my $pass2 = $info[13];
			my $encryptkey = "mempassbse";
			$pass2 = &main_functions::Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
			unless ($pass eq $pass2) {
				$error = "Invalid Login";
				&main($error);
			} else {
				my $encryptkey = "drbidsearch";
				$pass = &main_functions::Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
				return ($pass);
			}
		}
	}
}
# Logics
if ($FORM{'tab'} eq "login") { &members(); }
elsif ($FORM{'tab'} eq "forgot") { &forgot(); }
elsif ($FORM{'tab'} eq "stats") { &stats(); }
elsif ($FORM{'tab'} eq "profile") { &profile(); }
elsif ($FORM{'tab'} eq "modifyprofile") { &modifyprofile(); }
elsif ($FORM{'tab'} eq "manage") { &manage(); }
elsif ($FORM{'tab'} eq "nontargeted") { &nontargeted(); }
elsif ($FORM{'tab'} eq "addlisting") { &addlisting(); }
elsif ($FORM{'tab'} eq "editlisting") { &editlisting(); }
elsif ($FORM{'tab'} eq "deletelisting") { &deletelisting(); }
elsif ($FORM{'tab'} eq "nontargetedsubmit") { &nontargetedsubmit(); }
elsif ($FORM{'tab'} eq "addsubmit") { &addsubmit(); }
elsif ($FORM{'tab'} eq "editsubmit") { &editsubmit(); }
elsif ($FORM{'tab'} eq "deletesubmit") { &deletesubmit(); }
elsif ($FORM{'tab'} eq "balance") { &balance(); }
elsif ($FORM{'tab'} eq "balancesubmit") { &balancesubmit(); }
elsif ($FORM{'tab'} eq "bids") { &bids(); }
elsif ($FORM{'tab'} eq "bidsubmit") { &bidsubmit(); }
elsif ($FORM{'tab'} eq "bulk") { &bulk(); }
else { &main(); }
###############################################


###############################################
sub activity {
	my $balance = &database_functions::GetBalance($user);
	my ($grand, $divider, @date) = &database_functions::stat_activity($user);
	my ($avg, $daysleft);
	if ($grand) {
		$avg = $grand/$divider;
		$daysleft = $balance/$avg;
		$daysleft = sprintf("%.0f", $daysleft);
		$avg = sprintf("%.2f", $avg);
	}
	return ($avg, $daysleft, $balance, @date);
}
###############################################


###############################################
sub main {
my ($error, $error2) = @_;
open (FILE, "${path}template/login.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/<!-- \[error\] -->/$error/ig;
$temp =~ s/<!-- \[error2\] -->/$error2/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub forgot {
my @info = &database_functions::GetUser($FORM{user});

my $error2;
if ($FORM{'user'} eq "") { $error2 = "Please enter your username."; }
elsif(@info == 0) { $error2 = "Account not found."; }
if ($error2) {
	&main(undef, $error2);
	&main_functions::exit;
}

my $pass=$info[13];
my $encryptkey = "mempassbse";
$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
my $emailmessage = "Dear $info[0],\n\nHere is your password as you requested it:\n$pass\n\nSincerely,\n\n$company\n$websiteurl";
my $subject = "$company - Forgot Password";
&main_functions::send_email($adminemail, $info[8], $subject, $emailmessage);

my $email = $info[8];
open (FILE, "${path}template/forgot.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/<\!-- \[email\] -->/$email/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub members {
my ($avg, $daysleft, $balance) = &activity;
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my @info = &database_functions::GetUser($user);
open (FILE, "${path}template/members.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[created\] -->/$info[15]/ig;
$temp =~ s/<!-- \[balance\] -->/$adv[15]$balance/ig;
$temp =~ s/<!-- \[depletion\] -->/$daysleft days/ig;
$temp =~ s/<!-- \[costperday\] -->/$adv[15]$avg/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub stats {
my ($avg, $daysleft, $balance, @date) = &activity;
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my @info = &database_functions::GetUser($user);

my ($viewing, $myviewing) = ($FORM{'viewing'}) x 2;
my $newdate = &main_functions::getdate;
my ($viewing2, $options, $view_date);
unless ($viewing) { $FORM{'viewing'}= $viewing = $myviewing = "All" }
if ($viewing eq "All") { $viewing2 = "$info[15] to $newdate"; }
else { $viewing2 = "$FORM{'viewing'}"; }
if (length($myviewing) == 10) { substr($myviewing,0,2) = "-"; }
$myviewing =~ s/\-//g;

for (my $i = 0; $i < @date; $i++) {
	unless ($date[$i] eq "") {
		$options .= "<option>$date[$i]</option>";
	}
}

unless ($viewing eq "All") {
	$options .= "<option>All</option>";
	$options =~ s/<option>$viewing<\/option>//;
	$view_date = "and date= '$viewing'";
}

open (FILE, "${path}template/statistics.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[viewing\] -->/$viewing/ig;
$temp =~ s/<!-- \[options\] -->/$options/ig;
$temp =~ s/<!-- \[viewing2\] -->/$viewing2/ig;
$temp =~ s/<!-- \[created\] -->/$info[15]/ig;
$temp =~ s/<!-- \[balance\] -->/$adv[15]$balance/ig;
$temp =~ s/<!-- \[depletion\] -->/$daysleft days/ig;
$temp =~ s/<!-- \[costperday\] -->/$adv[15]$avg/ig;
my $sort = $FORM{'sort'};
my $searchterm = "<a href=\"members.$file_ext?tab=stats&user=$user&pass=$pass&viewing=$FORM{'viewing'}&sort=searchterm\">Search Term<\/a>";
my $clickthroughs = "<a href=\"members.$file_ext?tab=stats&user=$user&pass=$pass&viewing=$FORM{'viewing'}&sort=clickthroughs\">Click Throughs<\/a>";
my $termcost = "<a href=\"members.$file_ext?tab=stats&user=$user&pass=$pass&viewing=$FORM{'viewing'}&sort=cost\">Cost<\/a>";

my ($order_by, $field);
if ($FORM{'sort'} eq "" || $FORM{'sort'} eq "searchterm") {
	$order_by = 'term';
	$sort = "searchterm";
	$field = 0;
	$temp =~ s/<!-- \[searchterm\] -->/Search Term/ig;
	$temp =~ s/<!-- \[clickthroughs\] -->/$clickthroughs/ig;
	$temp =~ s/<!-- \[termcost\] -->/$termcost/ig;
} elsif ($FORM{'sort'} eq "clickthroughs") {
	$order_by = 'clicks';
	$sort = "clickthroughs";
	$field = 1;
	$temp =~ s/<!-- \[searchterm\] -->/$searchterm/ig;
	$temp =~ s/<!-- \[clickthroughs\] -->/Click Throughs/ig;
	$temp =~ s/<!-- \[termcost\] -->/$termcost/ig;
} elsif ($FORM{'sort'} eq "cost") {
	$order_by = 'amount';
	$sort = "cost";
	$field = 2;
	$temp =~ s/<!-- \[searchterm\] -->/$searchterm/ig;
	$temp =~ s/<!-- \[clickthroughs\] -->/$clickthroughs/ig;
	$temp =~ s/<!-- \[termcost\] -->/Cost/ig;
} else {
	$order_by = 'term';
}

my @temparray = split(/<\!-- \[listing\] -->/,$temp);
print "Content-type: text/html\n\n";
print $temparray[0];

my ($totalclicks, $totalcost) = &database_functions::gather_statistics($temparray[1], $user, $view_date, $order_by, $viewing, $field, $myviewing);
$totalcost = sprintf("%.2f", $totalcost);
$temparray[2] =~ s/<!-- \[totalclicks\] -->/$totalclicks/ig;
$temparray[2] =~ s/<!-- \[totalcost\] -->/$adv[15]$totalcost/ig;
print $temparray[2];
&main_functions::exit;
}
###############################################


###############################################
sub profile {
my ($error, $tempuser, $temppass) = @_;
my @info = &database_functions::GetUser($user);
open (FILE, "${path}template/profile.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
unless ($FORM{'tab'} eq "modifyprofile") {
	$tempuser = $user;
	$temppass = $pass;
}
if ($config{'data'} eq "mysql") { $tempuser = &database_functions::unescape($tempuser); }
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$tempuser/ig;
$temp =~ s/\[pass\]/$temppass/ig;
if ($error) {
	$temp =~ s/<\!-- \[error\] -->/$error/ig;
	$temp =~ s/\[name\]/$FORM{'name'}/ig;
	$temp =~ s/\[company\]/$FORM{'company'}/ig;
	$temp =~ s/\[address1\]/$FORM{'address1'}/ig;
	$temp =~ s/\[address2\]/$FORM{'address2'}/ig;
	$temp =~ s/\[city\]/$FORM{'city'}/ig;
	$temp =~ s/\[state\]/$FORM{'state'}/ig;
	$temp =~ s/\[zip\]/$FORM{'zip'}/ig;
	$temp =~ s/\[country\]/$FORM{'country'}/ig;
	$temp =~ s/\[phone\]/$FORM{'phone'}/ig;
	$temp =~ s/\[email\]/$FORM{'email'}/ig;
	$temp =~ s/\[password\]/$FORM{'password'}/ig;
} else {
	$temp =~ s/\[name\]/$info[0]/ig;
	$temp =~ s/\[company\]/$info[18]/ig;
	$temp =~ s/\[address1\]/$info[1]/ig;
	$temp =~ s/\[address2\]/$info[2]/ig;
	$temp =~ s/\[city\]/$info[3]/ig;
	$temp =~ s/\[state\]/$info[4]/ig;
	$temp =~ s/\[zip\]/$info[5]/ig;
	$temp =~ s/\[country\]/$info[6]/ig;
	$temp =~ s/\[phone\]/$info[7]/ig;
	$temp =~ s/\[email\]/$info[8]/ig;
	my $pass2 = $info[13];
	my $encryptkey = "mempassbse";
	$pass2 = &main_functions::Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
	$temp =~ s/\[password\]/$pass2/ig;	
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub modifyprofile {
my $email = $FORM{'email'};
my $user = $FORM{'user'};
my $username = $FORM{'user'};
my $password = $FORM{'password'};
my $pass = $FORM{'password'};
my $encryptkey = "drbidsearch";
$pass = &main_functions::Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
my $error = &main_functions::check_profile($username, $password, $email, %FORM);
if ($error) {
	&profile($error, $user, $pass);
	&main_functions::exit;
}

my $pass2 = $FORM{'password'};
$encryptkey = "mempassbse";
$pass2 = &main_functions::Encrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
&database_functions::profile_update($pass2, $user, %FORM);


my $message = "Profile Updated";
&message($message, $user, $pass);
&main_functions::exit;
}
###############################################


###############################################
sub message {
my ($message, $user2, $pass2) = @_;
open (FILE, "${path}template/message.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/<\!-- \[message\] -->/$message/ig;
if ($FORM{'tab'} eq "modifyprofile") {
	$temp =~ s/\[user\]/$user2/ig;
	$temp =~ s/\[pass\]/$pass2/ig;
} else {
	$temp =~ s/\[user\]/$user/ig;
	$temp =~ s/\[pass\]/$pass/ig;
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub manage {
open (FILE, "${path}template/manage.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub deletelisting {
my $inactive_mem = &database_functions::active($user, %FORM);
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
if ($inactive_mem) {
	&message($inactive_mem);
	&main_functions::exit;
}
my @sites = &database_functions::GetSites($user);

open (FILE, "${path}template/delete.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[currency\] -->/$adv[15]/ig;
my @temparray = split(/\<!-- \[displaylistings\] --\>/,$temp);
print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
EOF

my $numb;
foreach my $line(@sites) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[5] eq "new" or $inner[5] eq 'edit') {
		$numb++;
		my $temp2 = $temparray[1];
		$temp2 =~ s/<!-- \[numb\] -->/$numb/ig;
		$temp2 =~ s/\[numb\]/$numb/ig;
		$temp2 =~ s/<!-- \[keyword\] -->/$inner[0]/ig;
		my $key = $inner[0];
		$key =~ tr/ /+/;
		$temp2 =~ s/\[keyword\]/$key&id=$inner[6]/ig;
		$temp2 =~ s/<!-- \[title\] -->/$inner[2]/ig;
		$temp2 =~ s/<!-- \[description\] -->/$inner[4]/ig;
		$temp2 =~ s/<!-- \[url\] -->/$inner[3]/ig;
		$temp2 =~ s/<!-- \[bid\] -->/$inner[1]/ig;	
print <<EOF;
$temp2
EOF
	}
}
print <<EOF;
$temparray[2]
EOF
&main_functions::exit;
}
###############################################


###############################################
sub deletesubmit {
my $keyword = $FORM{'listing'};
$keyword =~ tr/+/ /;
&database_functions::delete_listing($FORM{user}, $keyword, $FORM{'id'});

my $message = "Listing Deleted";
&message($message);
&main_functions::exit;
}
###############################################


###############################################
sub editlisting {
my (@error) = @_;
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $inactive_mem = &database_functions::active($user, %FORM);
if ($inactive_mem) {
	&message($inactive_mem);
	&main_functions::exit;
}
my @sites = &database_functions::GetSites($user);
open (FILE, "${path}template/edit.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[currency\] -->/$adv[15]/ig;
if (@error) {
	$temp =~ s/<!-- \[error\] -->/ERROR:  Please correct the following fields error<BR>/ig;
	%FORM = &main_functions::add_char($config{'data'}, %FORM);
}
my @temparray = split(/\<!-- \[displaylistings\] --\>/,$temp);
print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
EOF
my $numb=0;

foreach my $line(@sites) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[0] eq "Non-Targeted Listing" || $inner[5] eq "new" || $inner[5] eq "edit" || $inner[5] eq "add") {
		$numb++;
		my $temp2 = $temparray[1];
		if (@error) {
			my $keyword = "keyword$numb";
			my $title = "title$numb";
			my $description = "description$numb";
			my $url = "url$numb";
			my $bid = "bid$numb";
			my $id = "id$numb";
			$id = "<input type=hidden name=id$numb value=\"$FORM{$id}\">";
			$temp2 =~ s/<!-- \[numb\] -->/$numb$id/ig;
			$temp2 =~ s/\[numb\]/$numb/ig;
			$temp2 =~ s/<!-- \[listerror\] -->/<BR>$error[$numb]/ig;
			$temp2 =~ s/\[keyword\]/$FORM{$keyword}/ig;
			$temp2 =~ s/\[title\]/$FORM{$title}/ig;
			$temp2 =~ s/\[description\]/$FORM{$description}/ig;
			$temp2 =~ s/\[url\]/$FORM{$url}/ig;
			$temp2 =~ s/\[bid\]/$FORM{$bid}/ig;
		} else {
			my $site_id;
			if ($config{'data'} eq "mysql") { $site_id = $inner[8]; }
			else { $site_id = $inner[6]; }
			my $id = "<input type=hidden name=id$numb value=\"$site_id\">";
			$temp2 =~ s/<!-- \[numb\] -->/$numb$id/ig;
			$temp2 =~ s/\[numb\]/$numb/ig;
			$temp2 =~ s/\[keyword\]/$inner[0]/ig;
			$temp2 =~ s/\[title\]/$inner[2]/ig;
			$temp2 =~ s/\[description\]/$inner[4]/ig;
			$temp2 =~ s/\[url\]/$inner[3]/ig;
			$temp2 =~ s/\[bid\]/$inner[1]/ig;	
		}
print <<EOF;
$temp2
EOF
	}
}
print <<EOF;
$temparray[2]
EOF
&main_functions::exit;
}
###############################################


###############################################
sub editsubmit {
my @sites = &database_functions::GetSites($user);
my $balance = &database_functions::GetBalance($user);
my (@eng, @adv, @opt, @error, $err, $numb, $keyarr);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
%FORM = &main_functions::remove_char(%FORM);
foreach my $line(@sites) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[0] eq "Non-Targeted Listing" || $inner[5] eq "new") {
		$numb++;
		my ($keyword, $title, $description, $url, $bid);
		($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($numb, %FORM);
		$error[$numb] = &main_functions::check_new_listing($numb, %FORM);
		if ($FORM{$bid} > $balance) { $error[$numb] .= "Please enter a bid that is less than your total balance of <B>$adv[15]$balance</B><BR>"; }
		my @arr = split(/\|/, $keyarr);
		foreach my $line(@arr) {
			chomp($line);
			@inner = split(/\-/, $line);
			if ($inner[0] eq $FORM{$keyword} && $inner[1] eq $FORM{$url}) {
				$error[$numb] .= "You have already used this <B>Keyword</B> with this <B>Domain</B><BR>";
			}
		}
		unless ($error[$numb] eq "") { $err = 1; }
		$keyarr .= "$FORM{$keyword}-$FORM{$url}|";
	}
}
if ($err) {
	&editlisting(@error);
	&main_functions::exit;
}
my $newdate = &main_functions::getdate;
&database_functions::edit_site($user, $newdate, %FORM);

my $count = 0;
if ($opt[9] eq "CHECKED") {
	my @info = &database_functions::GetUser($user);
	if ($config{'data'} eq "text") {
		&database_functions::remove_status('addition', $user);
		&database_functions::addstatus('addition', $user);
	}
	my $subject = "Search Listing - Modification";
	my $emailmessage = "The following member has just modified their listings and is waiting for them to be approved:\n\n";
	$emailmessage .= "Name:     $info[0]\nEmail:    $info[8]\nUsername: $info[12]\n\n";
	if ($opt[9] eq "CHECKED") { $emailmessage .= "Login to the admin to process this order:\n${adminurl}admin.$file_ext\n"; }
	&main_functions::send_email($adminemail, $adminemail, $subject, $emailmessage);
} else {
	if ($config{'data'} eq "text") {
		my @sites = &database_functions::GetSites($user);
		foreach my $line(@sites) {
			chomp($line);
			my @inner = split(/\|/, $line);
			unless ($inner[0] eq "Non-Targeted Listing" || $inner[5] eq "new") {
				open (FILE, "${path}data/search/$inner[0].txt");
				my @search = <FILE>;
				close(FILE);
				open (FILE, ">${path}data/search/$inner[0].txt");
				my ($rank, $yep);
				my @inner2;
				foreach my $line(@search) {
					chomp($line);
					@inner2 = split(/\|/, $line);
					$rank++;
					if ($inner[6] && $inner2[6]) {
						if ($inner2[1] eq $user && $inner2[6] == $inner[6]) {
							print FILE "$inner[1]|$user|$inner[2]|$inner[3]|$inner[4]|$inner2[5]|$inner[6]\n";
							$yep = 1;
						} else {
							print FILE "$line\n";
						}
					} else {
						if ($inner2[1] eq $user) {
							print FILE "$inner[1]|$user|$inner[2]|$inner[3]|$inner[4]|$inner2[5]|$inner[6]\n";
							$yep = 1;
						} else {
							print FILE "$line\n";
						}
					}
				}
				unless ($yep) { print FILE "$inner[1]|$user|$inner[2]|$inner[3]|$inner[4]|$inner2[5]|$inner[6]\n"; }
				close (FILE);
				&database_functions::outbidded($inner[0], $inner[1], $user, $yep);
			}
		}
	}
}
my $message = "Listing(s) Edited";
&message($message);
&main_functions::exit;
}
###############################################


###############################################
sub nontargeted {
my ($error) = @_;
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $inactive_mem = &database_functions::active($user, %FORM);
if ($inactive_mem) {
	&message($inactive_mem);
	&main_functions::exit;
}

if ($config{'data'} eq "mysql") {
	##we must check to see if the listing is currently under review
	my $user_id = &database_functions::mySQLGetUserID($user);
	my $statement = "select id from sites where user='$user_id' and term='Non-Targeted Listing' and status != 'approved'";
	my $sth = &database_functions::mySQL($statement);
	if($sth->rows > 0) {
		$sth->finish;
		my $message = "This listing is currently under review for approval and as a result this function has been disabled for the time being.";
		&message($message);
		&main_functions::exit;
	}
}


open (FILE, "${path}template/nontargeted.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[currency\] -->/$adv[15]/ig;

if ($error) {
	$temp =~ s/<!-- \[error\] -->/ERROR:  Please correct the following fields<BR>/ig;
}
if ($error) {
	%FORM = &main_functions::add_char($config{'data'}, %FORM);
	$temp =~ s/<!-- \[listerror\] -->/<BR>$error/ig;
	$temp =~ s/\[title\]/$FORM{'title'}/ig;
	$temp =~ s/\[description\]/$FORM{'description'}/ig;
	$temp =~ s/\[url\]/$FORM{'url'}/ig;
	$temp =~ s/\[bid\]/$FORM{'bid'}/ig;
} else {
	my ($title, $description, $url, $bid, $nontargetedexists) = &database_functions::get_nontargeted($user);	
	if ($nontargetedexists) {
		$temp =~ s/\[title\]/$title/ig;
		$temp =~ s/\[description\]/$description/ig;
		$temp =~ s/\[url\]/$url/ig;
		$temp =~ s/\[bid\]/$bid/ig;
	} else {
		$temp =~ s/\[title\]//ig;
		$temp =~ s/\[description\]//ig;
		$temp =~ s/\[url\]/http:\/\//ig;
		$temp =~ s/\[bid\]/0.00/ig;
	}
}

print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub nontargetedsubmit {
my (@eng, @adv, @opt, $error);
my $balance = &database_functions::GetBalance($user);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
%FORM = &main_functions::remove_char(%FORM);
$FORM{bid} =~ s/\$//;
$FORM{url} =~ s/\|/\:/g;
$FORM{title} =~ s/\|/\:/g;
$FORM{description} =~ s/\|/\:/g;
$FORM{description} =~ s/\r+/ /g;
$FORM{description} =~ s/\t+/ /g;
$FORM{description} =~ s/\n+/ /g;
if ($FORM{title} eq "") { $error .= "Please specify a valid <B>Title</B><BR>"; }
if ($FORM{description} eq "") { $error .= "Please specify a valid <B>Description</B><BR>"; }
if ($FORM{url} eq "http://" || $FORM{url} eq "" || $FORM{url} !~ /./) { $error .= "Please specify a valid <B>URL</B><BR>"; }
my @result = &database_functions::open_listings('Non-Targeted Listing', undef, $adv[17]);
my $num = $adv[17]-1;
my @data2 = split(/\|/, $result[$num]);
my $newbid = $data2[0]+0.01;
if ($FORM{bid} eq "0.00" || $FORM{bid} eq "" || $FORM{bid} < "0.01" || $FORM{bid} !~ /\./) { $error .= "Please specify a valid <B>Bid</B><BR>"; }
elsif ($FORM{bid} < $adv[14]) { $error .= "Please enter a minimum bid of <B>$adv[15]$adv[14]</B><BR>"; }
elsif ($FORM{bid} <= $data2[0]) { $error .= "Please enter a minimum bid of <B>$adv[15]$newbid</B><BR>"; }
elsif ($FORM{bid} > $balance) { $error .= "Please enter a bid that is less than your total balance of <B>$adv[15]$balance</B><BR>"; }
if ($error) {
	&nontargeted($error);
	&main_functions::exit;
}
my $newdate = &main_functions::getdate;
my $site_bid = &database_functions::nontargeted_sites($user, $opt[9], $newdate, %FORM);

unless ($opt[9] eq "CHECKED") {
	my $count = 0;
	&database_functions::create_stat($user, $newdate);
	if ($config{'data'} eq "text") {
		my @inner = ('Non-Targeted Listing', $FORM{'bid'}, $FORM{'title'}, $FORM{'url'}, $FORM{'description'});
		&database_functions::add_listing($user, $newdate);
	}
	
	##only check for outbids if the bid has changed
	if ($FORM{'bid'} > $site_bid) {
		&database_functions::outbidded('Non-Targeted Listing', '$FORM{bid}', '$user', undef, '$site_bid');
	}
	my $message = "Listing Added";
	&message($message);
} else {
	my @info = &database_functions::GetUser($user);
	if ($config{'data'} eq "text") {
		&database_functions::remove_status('addition', $user);
		&database_functions::addstatus('addition', $user);
	}
	my $subject = "Search Listing - Addition";
	my $emailmessage = "The following member has just added listings and is waiting for them to be approved:\n\n";
	$emailmessage .= "Name:     $info[0]\nEmail:    $info[8]\nUsername: $info[12]\n\n";
	if ($opt[9] eq "CHECKED") { $emailmessage .= "Login to the admin to process this order:\n${adminurl}admin.$file_ext\n"; }
	&main_functions::send_email($adminemail, $adminemail, $subject, $emailmessage);
	my $message = "Listing Submitted for Approval";
	&message($message);
}
&main_functions::exit;
}
###############################################


###############################################
sub bulk {
my ($error) = @_;
my $inactive_mem = &database_functions::active($user, %FORM);
if ($inactive_mem) {
	&message($inactive_mem);
	&main_functions::exit;
}

open (FILE, "${path}template/bulk.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
if ($error) {
	$temp =~ s/<!-- \[error\] -->/$error<BR>/ig;
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub addlisting {
my (@error) = @_;
my @site = &database_functions::GetSites($user);
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $inactive_mem = &database_functions::active($user, %FORM);
if ($inactive_mem) {
	&message($inactive_mem);
	&main_functions::exit;
}
open (FILE, "${path}template/add.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[currency\] -->/$adv[15]/ig;
if (@error) {
	$temp =~ s/<!-- \[error\] -->/ERROR:  Please correct the following fields<BR>/ig;
}
my @temparray = split(/\<!-- \[displaylistings\] --\>/,$temp);
print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
EOF
my ($temp2);
for my $numb(1 .. $adv[8]) {
	if ($numb == 1) {
		my @temparray2 = split(/\<!-- \[copy\] --\>/,$temparray[1]);
		$temp2 = "$temparray2[0]$temparray2[2]";
	} else {
		$temp2 = $temparray[1];
	}
	$temp2 =~ s/<!-- \[numb\] -->/$numb/ig;
	$temp2 =~ s/\[numb\]/$numb/ig;
	if (@error) {
		my $keyword = "keyword$numb";
		my $title = "title$numb";
		my $description = "description$numb";
		my $url = "url$numb";
		my $bid = "bid$numb";
		$temp2 =~ s/<!-- \[listerror\] -->/<BR>$error[$numb]/ig;
		$temp2 =~ s/\[keyword\]/$FORM{$keyword}/ig;
		$temp2 =~ s/\[title\]/$FORM{$title}/ig;
		$temp2 =~ s/\[description\]/$FORM{$description}/ig;
		$temp2 =~ s/\[url\]/$FORM{$url}/ig;
		$temp2 =~ s/\[bid\]/$FORM{$bid}/ig;
	} else {
		$temp2 =~ s/\[keyword\]//ig;
		$temp2 =~ s/\[title\]//ig;
		$temp2 =~ s/\[description\]//ig;
		$temp2 =~ s/\[url\]/http:\/\//ig;
		$temp2 =~ s/\[bid\]/0.00/ig;
	}
print <<EOF;
$temp2
EOF
}
print <<EOF;
$temparray[2]
EOF
&main_functions::exit;
}
###############################################


###############################################
sub addsubmit {
my @site = &database_functions::GetSites($user);
my $balance = &database_functions::GetBalance($user);
%FORM = &main_functions::remove_char(%FORM);
if ($FORM{'bulk'}) {
	my @bulk = split(/\n/, $FORM{'bulktext'});
	my ($num, $keyarr, $error);
	foreach my $line(@bulk) {
		chomp($line);
		unless ($line eq "") {
			$num++;
			my @inner = split(/\|/, $line);
			my $count;
			foreach(@inner) { $count++ }
			if (!$count >= 5) {
				$error .= "Your data is not formatted correctly.  Ensure that you have the entered in the correct data format by separating each item with a | symbol";
			}
			my $keyword = "keyword$num";
			my $title = "title$num";
			my $description = "description$num";
			my $url = "url$num";
			my $bid = "bid$num";
			$FORM{$keyword} = $inner[0];
			$FORM{$keyword} = lc($FORM{$keyword});
			$FORM{$url} = $inner[1];
			$FORM{$title} = $inner[2];
			$FORM{$description} = $inner[3];
			$FORM{$bid} = $inner[4];
			$FORM{$bid} =~ s/[\r\n]//g;
			
			if ($FORM{$bid} > $balance) { $error .= "Please enter a bid that is less than your <B>total balance</B><BR>"; }
			my @arr = split(/\|/, $keyarr);
			foreach my $line2(@arr) {
				chomp($line2);
				my @inner2 = split(/\-/, $line2);
				if ($inner2[0] eq $FORM{$keyword} && $inner2[1] eq $FORM{$url}) {
					$error .= "You have already used the keyword <B>$FORM{$keyword}</B> with the domain <B>$FORM{$url}</B><BR>";
				}
			}
			$keyarr .= "$FORM{$keyword}-$FORM{$url}|";
			foreach my $line3(@site) {
				chomp($line3);
				my @inner2 = split(/\|/, $line3);
				if ($inner2[0] eq $FORM{$keyword} && $inner2[3] eq $FORM{$url}) {
					$error .= "You have already used the keyword <B>$FORM{$keyword}</B> with the domain <B>$FORM{$url}</B><BR>";
				}
			}
		}
	}
	if ($error) {
		&bulk($error);
		&main_functions::exit;
	}
	&database_functions::bulk_upload($user, %FORM);
	my $message = "Listing(s) Submitted";
	&message($message);
	&main_functions::exit;	
}
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my (@error, $countvalue, $keyarr, $err);
for my $numb(1 .. $adv[8]) {
	my ($keyword, $title, $description, $url, $bid);
	($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($numb, %FORM);
	if ($numb == 1) {
		$error[$numb] = &main_functions::check_new_listing($numb, %FORM);
		if ($FORM{$bid} > $balance) { $error[$numb] .= "Please enter a bid that is less than your total balance of <B>$adv[15]$balance</B><BR>"; }
		$countvalue++;
	} else {
		unless ($FORM{$keyword} eq "" && $FORM{$title} eq "" && $FORM{$description} eq "" && ($FORM{$url} eq "http://" || $FORM{$url} eq "") && ($FORM{$bid} eq "0.00" || $FORM{$bid} eq "")) { 
			$error[$numb] = &main_functions::check_new_listing($numb, %FORM);
			if ($FORM{$bid} > $balance) { $error[$numb] .= "Please enter a bid that is less than your total balance of <B>$adv[15]$balance</B><BR>"; }
			my @arr = split(/\|/, $keyarr);
			foreach my $line(@arr) {
				chomp($line);
				my @inner = split(/\-/, $line);
				if ($inner[0] eq $FORM{$keyword} && $inner[1] eq $FORM{$url}) {
					$error[$numb] .= "You have already used this <B>Keyword</B> with this <B>Domain</B><BR>";
				}
			}
			$countvalue++;
		}
	}
	$keyarr .= "$FORM{$keyword}-$FORM{$url}|";
	foreach my $line(@site) {
		chomp($line);
		my @inner = split(/\|/, $line);
		if ($inner[0] eq $FORM{$keyword} && $inner[3] eq $FORM{$url}) {
			$error[$numb] .= "You have already used this <B>Keyword</B> with this <B>Domain</B><BR>";
		}
	}
	unless ($error[$numb] eq "") { $err = 1; }
}

if ($err) {
	&addlisting(@error);
	&main_functions::exit;
}
my $addition;
if ($opt[9] eq "CHECKED") { 
	if ($config{'data'} eq "mysql") { $addition = "add"; }
	else { $addition = "new"; }
} else {
	if ($config{'data'} eq "mysql") { $addition = 'approved'; }
}

my $newdate = &main_functions::getdate;
my $user_id;
if ($config{'data'} eq "mysql") {
	$user_id = &database_functions::mySQLGetUserID($user);
} else {
	open (FILE, ">>${path}data/sites/$user.txt");
}
my $org_site_id;
if ($config{'data'} eq "text") { $org_site_id = &database_functions::GetSiteId($user); }
my $site_id = $org_site_id;
for my $count(1 .. $countvalue) {
	my ($keyword, $title, $description, $url, $bid);
	($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($count, %FORM);
	if ($config{'data'} eq "mysql") {
		my $statement = "insert into sites(term, bid, title, url, description, status, user, date) values 
		('$FORM{$keyword}', '$FORM{$bid}', '$FORM{$title}', '$FORM{$url}', '$FORM{$description}', '$addition', '$user_id', '$newdate')";
		my $sth = &database_functions::mySQL($statement);
	} else {
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}|$addition|$site_id
EOF
		$site_id++;
	}
}
if ($config{'data'} eq "text") { close (FILE); }

unless ($opt[9] eq "CHECKED") {
	for my $count(1 .. $countvalue) {
		my $keyword = "keyword$count";
		my $bid = "bid$count";
		my $title = "title$count";
		my $description = "description$count";
		my $url = "url$count";
		if ($config{'data'} eq "text") {
			open (FILE, ">>${path}data/stats/$user.txt");
print FILE <<EOF;
$FORM{$keyword}|$newdate^0
EOF
			close(FILE);
			if (-e "${path}data/search/$FORM{$keyword}.txt") {
				open (FILE, ">>${path}data/search/$FORM{$keyword}.txt");
			} else {
				open (FILE, ">${path}data/search/$FORM{$keyword}.txt");
			}
			print FILE "$FORM{$bid}|$user|$FORM{$title}|$FORM{$url}|$FORM{$description}|$newdate|$org_site_id\n";
			close (FILE);
			$org_site_id++;
			&database_functions::sortit($FORM{$keyword});
		} else {
			my $statement = "insert into stats(user, term, date) values ('$user_id', '$FORM{$keyword}', '$newdate')";
			my $sth = &database_functions::mySQL($statement);
		}
		&database_functions::outbidded($FORM{$keyword}, $FORM{$bid}, $user);
	}
	my $message = "Listing(s) Added";
	&message($message);
} else {
	my @info = &database_functions::GetUser($user);
	if ($config{'data'} eq "text") {
		&database_functions::remove_status('addition', $user);
		&database_functions::addstatus('addition', $user);
	}
	my $subject = "Search Listing - Addition";
	my $emailmessage = "The following member has just added listings and is waiting for them to be approved:\n\n";
	$emailmessage .= "Name:     $info[0]\nEmail:    $info[8]\nUsername: $info[12]\n\n";
	if ($opt[9] eq "CHECKED") { $emailmessage .= "Login to the admin to process this order:\n${adminurl}admin.$file_ext\n"; }
	&main_functions::send_email($adminemail, $adminemail, $subject, $emailmessage);
	my $message = "Listing(s) Submitted";
	&message($message);
}
&main_functions::exit;
}
###############################################


###############################################
sub bids {
my ($error) = @_;
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $inactive_mem = &database_functions::active($user, %FORM);
if ($inactive_mem) {
	&message($inactive_mem);
	&main_functions::exit;
}
open (FILE, "${path}template/bids.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[currency\] -->/$adv[15]/ig;
if ($error) {
	$temp =~ s/<!-- \[error\] -->/ERROR:  $error/ig;
}
my @temparray = split(/\<!-- \[listing\] --\>/,$temp);
print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
EOF

my @sites = &database_functions::GetSites($user);
if ($config{'data'} eq "mysql") {
	my $user_id = &database_functions::mySQLGetUserID($user);
}

my $numb=0;
foreach my $line(@sites) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[5] eq "new" || $inner[5] eq "add" || $inner[5] eq "edit") {
		##lets get the needed data shall we
		my $temp = $inner[1];
		my $term_submit = $inner[0];
		if ($config{'data'} eq "mysql") { $term_submit = &database_functions::escape($term_submit); }
		my $term_date = $inner[7];
		$term_date =~ s/\-//g;
		
		##this must be done because we are comparing floats
		$temp -= .0001;
		
		my ($bidtobe1, $position) = &database_functions::getbid($user, $term_submit, $temp);
		if ($position == 1) { $bidtobe1 = '-'; }
		else {
			$bidtobe1 += .01;
			$bidtobe1 = sprintf("%.2f", $bidtobe1);
			$bidtobe1 = "$adv[15]$bidtobe1";
		}

		my $bidid;
		if ($config{'data'} eq "mysql") { $bidid = $inner[8]; }
		else { $bidid = $inner[6]; }
		$numb++;
		my $temp2 = $temparray[1];
		$temp2 =~ s/<!-- \[numb\] -->/$numb/ig;
		$temp2 =~ s/\[numb\]/$numb/ig;
		if ($error) {
			my $bid = "newbid$numb";
			$temp2 =~ s/<!-- \[keyword\] -->/$inner[0]/ig;
			$temp2 =~ s/<!-- \[position\] -->/$position/ig;
			$temp2 =~ s/<!-- \[bidtobe1\] -->/$bidtobe1/ig;
			$temp2 =~ s/\[newbid\]/$FORM{$bid}/ig;
			$temp2 =~ s/\[bidid\]/$bidid/ig;
		} else {
			$temp2 =~ s/<!-- \[keyword\] -->/$inner[0]/ig;
			$temp2 =~ s/<!-- \[position\] -->/$position/ig;
			$temp2 =~ s/<!-- \[bidtobe1\] -->/$bidtobe1/ig;
			$temp2 =~ s/\[bidid\]/$bidid/ig;
			$temp2 =~ s/\[newbid\]/$inner[1]/ig;
		}
print <<EOF;
$temp2
EOF
	}
}
print <<EOF;
$temparray[2]
EOF
&main_functions::exit;
}
###############################################


###############################################
sub bidsubmit {
my @sites = &database_functions::GetSites($user);
my (@eng, @adv, @opt, $error);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $balance = &database_functions::GetBalance($user);
my $numb;
unless ($FORM{'changeto'}) {
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		unless ($inner[5] eq "new") {
			$numb++;
			my $bid = "newbid$numb";
			$bid = (split(/_/, $bid))[0];
			$FORM{$bid} =~ s/\$//;
			if ($FORM{$bid} < $adv[14]) { $error = "Please enter a minimum bid of <B>$adv[15]$adv[14]</B><BR>"; }
			elsif ($FORM{$bid} > $balance) { $error = "Please enter a bid that is less than your total balance of <B>$adv[15]$balance</B><BR>"; }
		}
	}
	if ($error) {
		&bids($error);
		&main_functions::exit;
	}
} else {
	my $count;
	foreach my $line(@sites) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my $temp = $inner[1];
		my $term_submit = $inner[0];
		if ($config{'data'} eq "mysql") { $term_submit = &database_functions::escape($term_submit); }
		$temp -= .0001;
		my ($bidtobe1, $position) = &database_functions::getbid($user, $term_submit, $temp);
		$count++;
		my $bid = "newbid$count";
		unless ($bidtobe1 eq "") {
			$bidtobe1 += .01;
			$FORM{$bid} = $bidtobe1;
		} else {
			$FORM{$bid} = $inner[1];
		}
	}
}

my $count=0;
if ($config{'data'} eq "text") { open (FILE, ">${path}data/sites/$user.txt"); }
my %outbid;
foreach my $line(@sites) {
	chomp($line);
	my @inner = split(/\|/, $line);
	unless ($inner[5] eq "new") {
		$count++;
		my $bid = "newbid$count";
		my $site_id = "bidid$count";
		$FORM{$bid} = sprintf("%.2f", $FORM{$bid});
		if ($config{'data'} eq "mysql") {
			my $user_id = &database_functions::mySQLGetUserID($user);
			$inner[0] = &database_functions::escape($inner[0]);
			my $statement = "update sites set bid = '$FORM{$bid}' where user='$user_id' and term='$inner[0]'";
			if ($FORM{$site_id}) { $statement .= " and id='$FORM{$site_id}'"; }
			my $sth = &database_functions::mySQL($statement);
		} else {
print FILE <<EOF;
$inner[0]|$FORM{$bid}|$inner[2]|$inner[3]|$inner[4]||$inner[6]
EOF
		}
		
		##only do it of the bid has actually changed
		if ($FORM{$bid} > $inner[1]) { $outbid{$inner[0]} = "$FORM{$bid}|$inner[1]"; }
	} else {
		if ($config{'data'} eq "text") {
print FILE <<EOF;
$line
EOF
		}
	}
}
close (FILE);
if ($config{'data'} eq "text") {
	my $newdate = &main_functions::getdate;
	&database_functions::add_listing($user, $newdate);
}

foreach my $key(keys %outbid) {
	my @inner = split(/\|/, $outbid{$key});
	&database_functions::outbidded($key, $inner[0], $user, undef, $inner[1]);
}

my $message = "Bid(s) Updated";
&message($message);
&main_functions::exit;
}
###############################################


###############################################
sub balance {
my ($error) = @_;
my @info = &database_functions::GetUser($user);
my $balance = &database_functions::GetBalance($user);
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);

open (FILE, "${path}config/merchant.txt");
my @merchant = <FILE>;
close (FILE);
chomp(@merchant);
if ($merchant[0] eq "paypal") {
	$merchant[3] =~ tr/ /+/;
	$merchant[1] =~ s/\@/%40/;
	print "Location: https://www.paypal.com/cgibin/webscr?custom=$user|update&item_name=$merchant[3]&submit.x=34&submit.y=15&business=$merchant[1]&item_number=$merchant[2]&cmd=_xclick&no_note=1&no_shipping=1\n\n";
	&main_functions::exit;
}

open (FILE, "${path}template/balance.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<\!-- \[currentbalance\] -->/$adv[15]$balance/ig;
if ($error) {
	$temp =~ s/<\!-- \[error\] -->/$error/ig;
	$temp =~ s/\[chname\]/$FORM{'chname'}/ig;
	my $p = $info[10];
	my $encryptkey = "drbidsearch";
	$p = &main_functions::Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
	$p =~ s/ //;
	my @split = split('', $p);
	my $num = @split;
	$p = "$split[0]$split[1]$split[2]$split[3] ... $split[$num-4]$split[$num-3]$split[$num-2]$split[$num-1]";
	$temp =~ s/<\!-- \[ccnumber\] -->/$p/ig;
	if ($FORM{'ccnumber'}) { $temp =~ s/\[ccnumber\]/$FORM{'ccnumber'}/ig; }
	else { $temp =~ s/\[ccnumber\]//ig; }
	if ($FORM{'cctype'} eq "Visa") {
		$temp =~ s/\[cctype\]/$FORM{'cctype'}<\/option><option>MasterCard<\/option><option>American Express/ig;
	} elsif ($FORM{'cctype'} eq "MasterCard") {
		$temp =~ s/\[cctype\]/$FORM{'cctype'}<\/option><option>Visa<\/option><option>American Express/ig;
	} elsif ($FORM{'cctype'} eq "American Express") {
		$temp =~ s/\[cctype\]/$FORM{'cctype'}<\/option><option>Visa<\/option><option>MasterCard/ig;
	}
	$temp =~ s/\[expire\]/$FORM{'expire'}/ig;
	$temp =~ s/\[balance\]/$FORM{'balance'}/ig;
} else {
	if ($info[9] eq "Free") { $temp =~ s/\[chname\]//ig; }
	else { $temp =~ s/\[chname\]/$info[9]/ig; }
	if ($info[16] eq "") {
		$temp =~ s/\[cctype\]/Visa<\/option><option>MasterCard<\/option><option>American Express/ig;
	} else {
		if ($info[16] eq "Visa") {
			$temp =~ s/\[cctype\]/$info[16]<\/option><option>MasterCard<\/option><option>American Express/ig;
		} elsif ($info[16] eq "MasterCard") {
			$temp =~ s/\[cctype\]/$info[16]<\/option><option>Visa<\/option><option>American Express/ig;
		} elsif ($info[16] eq "American Express") {
			$temp =~ s/\[cctype\]/$info[16]<\/option><option>Visa<\/option><option>MasterCard/ig;
		}
	}
	my $p = $info[10];
	my $encryptkey = "drbidsearch";
	$p = &main_functions::Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
	$p =~ s/ //;
	my @split = split('', $p);
	my $num = @split;
	$p = "$split[0]$split[1]$split[2]$split[3] ... $split[$num-4]$split[$num-3]$split[$num-2]$split[$num-1]";
	$temp =~ s/<\!-- \[ccnumber\] -->/$p/ig;
	$temp =~ s/\[ccnumber\]//ig;
	$temp =~ s/\[expire\]/$info[11]/ig;
	$temp =~ s/\[balance\]//ig;
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
sub balancesubmit {
my ($auth, $error);
open (FILE, "${path}config/merchant.txt");
my @merchant = <FILE>;
close (FILE);
chomp (@merchant);
my @info = &database_functions::GetUser($user);
if ($merchant[0] eq "authorize.net") { $auth = 1; }
elsif ($merchant[0] eq "clickbank" || $merchant[0] eq "2checkout") { $auth = 2; }
else { $auth = 0; }
unless ($auth == 2) {
	unless ($FORM{'chname'}) { $error .= "Please specify the card holders <B>Name</B><BR>"; }
	unless ($FORM{'expire'}) { $error .= "Please specify a valid <B>expiration date</B> in the format <B>mm/yy</B><BR>"; }
}
if ($FORM{'balance'} eq "") { $error .= "Please specify a <B>balance</B><BR>"; }
if ($error) {
	&balance($error);
	&main_functions::exit;
}

if ($merchant[0] eq "clickbank") {
	my ($aa, $linknum);
	foreach my $link(@merchant) {
		unless ($aa == 0 || $aa == 1 || $aa == 2) {
			my @inner = split(/\|/, $link);
			if ($inner[1] eq $FORM{'balance'}) {
				$linknum = $inner[0];
				last;
			}
		}
		$aa++;	
	}
	print "Location: http://www.clickbank.net/sell.cgi?link=$merchant[1]/$linknum/$company&seed=41FLZ9FJJ&u=$user&a=$FORM{'balance'}&t=update\n\n";
	&main_functions::exit;
} elsif ($merchant[0] eq "2checkout") {
	print "Location: https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c?x_Login=$merchant[1]&x_amount=$FORM{'balance'}&custom=$user|update&x_First_Name=$info[0]&x_Address=$info[1]&x_City=$info[3]&x_State=$info[4]&x_Zip=$info[5]&x_Country=$info[6]&x_Phone=$info[7]&x_Email=$info[8]\n\n";
	&main_functions::exit;
}

my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
$FORM{'balance'} =~ s/\$//;
my $p;
if ($FORM{'ccnumber'}) {
	$p = $FORM{'ccnumber'};
	my $encryptkey = "drbidsearch";
	$p = &main_functions::Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
} else {
	$p = $info[10];
}

my $proact;
if ($opt[9] eq "CHECKED") { $proact = $info[14]; }
else { $proact = "active"; }
&database_functions::update_credit($p, $proact, $user, %FORM);

if ($auth == 1) {
	my @data = &main_functions::merchant_authorizenet($merchant[1], $merchant[2], %FORM);
	if ($data[0] == 1) {
		&approve;
		my $message = "Balance Update Processed";
		&message($message);
	} elsif ($data[0] == 2) {
		my $message = "Authorization Failed: $data[3]";
		&message($message);
	} else {
		my $message = "Authorization Error: $data[3]";
		&message($message);
	}
} elsif ($opt[9] ne "CHECKED" && $auth == 0) { &approve; }
else {
	if ($config{'data'} eq "mysql") {
		my $user_id = &database_functions::mySQLGetUserID($user);
		my $statement = "insert into balanceaddon(user, amount) values ('$user_id', '$FORM{balance}')";
		my $sth = &database_functions::mySQL($statement);
	} else {
		open (FILE, "${path}data/balanceaddon.txt");
		my @DATA = <FILE>;
		close (FILE);
		my $foundit;
		open (FILE, ">${path}data/balanceaddon.txt");
		foreach my $line(@DATA) {
			chomp($line);
			my @inner = split(/\|/, $line);
			if ($inner[0] eq $user) {
				my $balance2 = $inner[1];
				my $newbalance = $FORM{'balance'}+$balance2;
				print FILE "$inner[0]|$newbalance\n";
				$foundit = 1;
			} else {
				print FILE "$line\n";
			}
		}
		unless ($foundit) {
			print FILE "$user|$FORM{'balance'}\n";
		}
		close (FILE);
	}
}

if ($auth == 0) {
	my $subject = "Search Listing - Order";
	my $emailmessage = "The following member has just ordered a balance update:\n\n";
	$emailmessage .= "Name:     $info[0]\nEmail:    $info[8]\nUsername: $info[12]\nBalance:  $adv[15]$FORM{'balance'}\n\n";
	$emailmessage .= "Address:  $info[1]\n          $info[2]\nCity:     $info[3]\nState:    $info[4]\n";
	$emailmessage .= "Zip:      $info[5]\nCountry:  $info[6]\nPhone:    $info[7]\n\n";
	if ($opt[9] eq "CHECKED") {
		$emailmessage .= "Login to the admin to process this order:\n${adminurl}admin.$file_ext\n";
	}
	&main_functions::send_email($adminemail, $adminemail, $subject, $emailmessage);
	my $message = "Balance Updated";
	&message($message);
}
&main_functions::exit;
}
###############################################


###############################################
sub approve {
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $user = $FORM{user};
my @user = &database_functions::GetUser($user);
my $status = $user[14];
my ($newbalance, $emailtemp);
if ($config{'data'} eq "mysql") {
	my $statement = "update users set status='active', balance = balance + $FORM{balance} where username='$user'";
	my $sth = &database_functions::mySQL($statement);
	$newbalance = &database_functions::GetBalance($user);
} else {
	unless ($status eq "active") {
		&database_functions::remove_status($user[14], $user);
		$user[14] = "active";
		&database_functions::change_status('active', $user, '1');
	}
	$newbalance = &database_functions::GetBalance($user);
	$newbalance = $newbalance + $FORM{'balance'};
	&database_functions::update_balance($user, $newbalance);
}
my $newdate = &main_functions::getdate;
if ($status eq "inactive") {
	&database_functions::add_listing($user, $newdate);
}

&database_functions::payment_history($user, $newdate, $FORM{'balance'});
open (FILE, "${path}template/emailaddonbalance.txt");
my @emailmess = <FILE>;
close (FILE);
foreach my $emailtemp2(@emailmess) {
	chomp($emailtemp2);
	$emailtemp .= "$emailtemp2\n";
}
my $memurl;
unless ($config{'secureurl'} eq "") { $memurl = $config{'secureurl'}; }
else { $memurl = $config{'adminurl'}; }
$emailtemp =~ s/\[balance\]/$adv[15]$FORM{'balance'}/ig;
$emailtemp =~ s/\[totalbalance\]/$adv[15]$newbalance/ig;
$emailtemp =~ s/\[name\]/$user[0]/ig;
$emailtemp =~ s/\[username\]/$user[12]/ig;
my $pass2 = $user[13];
my $encryptkey = "mempassbse";
$pass2 = &main_functions::Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
$emailtemp =~ s/\[password\]/$pass2/ig;
$emailtemp =~ s/\[company\]/$company/ig;
$emailtemp =~ s/\[url\]/$websiteurl/ig;
$emailtemp =~ s/\[loginurl\]/${memurl}members.$file_ext/ig;
my $subject = "$company - Balance Update Processed";
&main_functions::send_email($config{'adminemail'}, $user[8], $subject, $emailtemp);
}
###############################################