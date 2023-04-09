#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Signup Script
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
&main_functions::checkpath('signup', $path);
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

#Gather from config
my ($adminemail, $adminurl, $company, $websiteurl) = (&main_functions::config_vars())[0,1,3,4];

#Get Defaults
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my $displistings = $adv[8];
my $balance = $adv[9];

# Logics
if ($FORM{'tab'} eq "signup2") { &signup(); }
elsif ($FORM{'tab'} eq "signup3") { &signup2(); }
elsif ($FORM{'tab'} eq "signup4") { &signup3(); }
elsif ($FORM{'tab'} eq "merchant") { &merchant(); }
elsif ($FORM{'tab'} eq "merchant") { &merchant(); }
else {
	if ($FORM{'member'} && -e "${path}affiliate/config/config.cgi") {
		$FORM{'affiliatesignup'} = 1;
		do "${path}affiliate/click.cgi";
		&click_functions::affiliate_signup(%FORM);
		do "${path}config/config.cgi";
		if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
		else { do "${path}functions_text.$file_ext"; }
		do "${path}functions.$file_ext";
	}
	if ($opt[11] eq "CHECKED") { &signup(); }
	else { &main(); }
}
###############################################

###############################################
# First Sign Up Page
sub main {
my (@error) = @_;
open (FILE, "${path}template/signup.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/<!-- \[currency\] -->/$adv[15]/ig;
$temp =~ s/\[ext\]/$file_ext/ig;
if (@error) {
	$temp =~ s/<!-- \[error\] -->/ERROR:  Please correct the following fields<BR>/ig;
	%FORM = &main_functions::add_char($config{'data'}, %FORM);
}
if ($FORM{'free'} && $opt[12] eq "CHECKED") {
	$temp =~ s/<!-- \[free\] -->/<input type=hidden name=free value=1>/ig;
}
my @temparray = split(/\<!-- \[displaylistings\] --\>/,$temp);
print "Content-type: text/html\n\n";
print <<EOF;
$temparray[0]
EOF

my ($temp2);
for my $numb(1 .. $displistings) {
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
# Second Sign Up Page
sub signup {
my ($diserror, $error) = @_;
my ($hidden, $err);
%FORM = &main_functions::remove_char(%FORM);
unless ($opt[11] eq "CHECKED") {
	my (@error, $countvalue, $keyarr);
	unless ($diserror) {
		for my $numb(1 .. $displistings) {
			my ($keyword, $title, $description, $url, $bid);
			($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($numb, %FORM);
			if ($numb == 1) {
				$error[$numb] = &main_functions::check_new_listing($numb, %FORM);
				unless ($error[$numb] eq "") { $err = 1; }
				$hidden .= &hidden($keyword, $title, $description, $url, $bid, $err, %FORM);
				$countvalue++;
			} else {
				unless ($FORM{$keyword} eq "" && $FORM{$title} eq "" && $FORM{$description} eq "" && ($FORM{$url} eq "http://" || $FORM{$url} eq "") && ($FORM{$bid} eq "0.00" || $FORM{$bid} eq "")) { 
					$error[$numb] = &main_functions::check_new_listing($numb, %FORM);
					my @arr = split(/\|/, $keyarr);
					foreach my $line(@arr) {
						chomp($line);
						my @inner = split(/\-/, $line);
						if ($inner[0] eq $FORM{$keyword} && $inner[1] eq $FORM{$url}) {
							$error[$numb] .= "You have already used this <B>Keyword</B> with this <B>Domain</B><BR>";
						}
					}
					unless ($error[$numb] eq "") { $err = 1; }
					$hidden .= &hidden($keyword, $title, $description, $url, $bid, $err, %FORM);
					$countvalue++;
				}
			}
			$keyarr .= "$FORM{$keyword}-$FORM{$url}|";
		}
	}
	if ($err) {
		unless ($diserror) {
			&main(@error);
			&main_functions::exit;
		}
	}
	if ($FORM{'free'} && $opt[12] eq "CHECKED") {
		$hidden .= "<input type=hidden name=free value=1>";
	}
	$hidden .= "<input type=hidden name=signup1 value=$countvalue>\n";

	if ($diserror) {
		for my $count(1 .. $FORM{'signup1'}) {
			my ($keyword, $title, $description, $url, $bid);
			($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($count, %FORM);
			my $err;
			if (@error) { $err = 1; }
			$hidden .= &hidden($keyword, $title, $description, $url, $bid, $err, %FORM);
		}
		$hidden .= "<input type=hidden name=signup1 value=$FORM{'signup1'}>\n";
	}

	sub hidden {
		my ($keyword, $title, $description, $url, $bid, $err, %FORM) = @_;
		unless ($err) { $FORM{$bid} = sprintf("%.2f", $FORM{$bid}); }
		my $hidden = "<input type=hidden name=$keyword value=\"$FORM{$keyword}\">\n";
		$hidden .= "<input type=hidden name=$title value=\"$FORM{$title}\">\n";
		$hidden .= "<input type=hidden name=$description value=\"$FORM{$description}\">\n";
		$hidden .= "<input type=hidden name=$url value=\"$FORM{$url}\">\n";
		$hidden .= "<input type=hidden name=$bid value=\"$FORM{$bid}\">\n";
		return ($hidden);
	}
} else {
	if ($FORM{'free'} && $opt[12] eq "CHECKED") {
		$hidden .= "<input type=hidden name=free value=1>";
	}	
}

open (FILE, "${path}template/signup2.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
$temp =~ s/\[ext\]/$file_ext/ig;
$temp =~ s/<\!-- \[signup1\] -->/$hidden/ig;
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
	$temp =~ s/\[username\]/$FORM{'username'}/ig;
	$temp =~ s/\[password\]/$FORM{'password'}/ig;
} else {
	$temp =~ s/\[name\]//ig;
	$temp =~ s/\[company\]//ig;
	$temp =~ s/\[address1\]//ig;
	$temp =~ s/\[address2\]//ig;
	$temp =~ s/\[city\]//ig;
	$temp =~ s/\[state\]//ig;
	$temp =~ s/\[zip\]//ig;
	$temp =~ s/\[country\]/United States/ig;
	$temp =~ s/\[phone\]//ig;
	$temp =~ s/\[email\]//ig;
	$temp =~ s/\[username\]//ig;
	$temp =~ s/\[password\]//ig;
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
&main_functions::exit;
}
###############################################


###############################################
# Third Signup Page
sub signup2 {
my ($error, $diserror) = @_;
my $username = $FORM{'username'};
my $password = $FORM{'password'};
my $email = $FORM{'email'};
unless ($diserror) { $error = &main_functions::check_profile($username, $password, $email, %FORM); }

if ($error) {
	unless ($diserror) {
		my $diserror = 1;
		&signup($diserror, $error);
		&main_functions::exit;
	}
}
open (FILE, "${path}config/merchant.txt");
my @merchant = <FILE>;
close (FILE);
chomp($merchant[0]);
if ($opt[10] eq "CHECKED" || $merchant[0] eq "paypal" || ($opt[12] eq "CHECKED" && $FORM{'free'})) { &signup3(); }
else {
	my ($hidden);
	unless ($opt[11] eq "CHECKED") {
		for my $count(1 .. $FORM{'signup1'}) {
			my ($keyword, $title, $description, $url, $bid);
			($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($count, %FORM);
			$hidden .= "<input type=hidden name=$keyword value=\"$FORM{$keyword}\">\n";
			$hidden .= "<input type=hidden name=$title value=\"$FORM{$title}\">\n";
			$hidden .= "<input type=hidden name=$description value=\"$FORM{$description}\">\n";
			$hidden .= "<input type=hidden name=$url value=\"$FORM{$url}\">\n";
			$hidden .= "<input type=hidden name=$bid value=\"$FORM{$bid}\">\n";
		}
	}
	$hidden .= "<input type=hidden name=signup1 value=\"$FORM{'signup1'}\">\n";
	my $hidden2 = "<input type=hidden name=name value=\"$FORM{'name'}\">\n";
	$hidden2 .= "<input type=hidden name=company value=\"$FORM{'company'}\">\n";
	$hidden2 .= "<input type=hidden name=address1 value=\"$FORM{'address1'}\">\n";
	$hidden2 .= "<input type=hidden name=address2 value=\"$FORM{'address2'}\">\n";
	$hidden2 .= "<input type=hidden name=city value=\"$FORM{'city'}\">\n";
	$hidden2 .= "<input type=hidden name=state value=\"$FORM{'state'}\">\n";
	$hidden2 .= "<input type=hidden name=zip value=\"$FORM{'zip'}\">\n";
	$hidden2 .= "<input type=hidden name=country value=\"$FORM{'country'}\">\n";
	$hidden2 .= "<input type=hidden name=phone value=\"$FORM{'phone'}\">\n";
	$hidden2 .= "<input type=hidden name=email value=\"$FORM{'email'}\">\n";
	$hidden2 .= "<input type=hidden name=username value=\"$username\">\n";
	$hidden2 .= "<input type=hidden name=password value=\"$password\">\n";

	open (FILE, "${path}template/signup3.txt");
	my @tempfile = <FILE>;
	close (FILE);
	my $temp="@tempfile";
	$temp =~ s/\[ext\]/$file_ext/ig;
	$temp =~ s/<\!-- \[signup1\] -->/$hidden/ig;
	$temp =~ s/<\!-- \[signup2\] -->/$hidden2/ig;
	$temp =~ s/<\!-- \[balance\] -->/$adv[15]$balance/ig;
	if ($error) {
		$temp =~ s/<\!-- \[error\] -->/$error/ig;
		$temp =~ s/\[chname\]/$FORM{'chname'}/ig;
		$temp =~ s/\[ccnumber\]/$FORM{'ccnumber'}/ig;
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
		$temp =~ s/\[chname\]//ig;
		$temp =~ s/\[ccnumber\]//ig;
		$temp =~ s/\[cctype\]/Visa<\/option><option>MasterCard<\/option><option>American Express/ig;
		$temp =~ s/\[expire\]//ig;
		$temp =~ s/\[balance\]/$balance/ig;
	}
	print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
	&main_functions::exit;
}
}
###############################################


###############################################
# Sign Up Complete
sub signup3 {
open (FILE, "${path}config/merchant.txt");
my @merchant = <FILE>;
close (FILE);
chomp(@merchant);
unless ($opt[10] eq "CHECKED" || $merchant[0] eq "paypal" || ($opt[12] eq "CHECKED" && $FORM{'free'})) {
	my ($error);
	unless ($merchant[0] eq "clickbank" || $merchant[0] eq "2checkout") {
		unless ($FORM{'chname'}) { $error .= "Please specify the card holders <B>Name</B><BR>"; }
		unless ($FORM{'ccnumber'}) { $error .= "Please specify a valid <B>Credit Card Number</B><BR>"; }
		unless ($FORM{'expire'}) { $error .= "Please specify a valid <B>expiration date</B> in the format <B>mm/yy</B><BR>"; }
	}
	if ($FORM{'balance'} < $balance) { $error .= "You are under the minimum balance allowed which is <B>$balance</B><BR>"; }
	if ($FORM{'balance'} eq "") { $error .= "Please specify your desired <B>Balance</B><BR>"; }
	if ($error) {
		my $diserror = 1;
		&signup2($error, $diserror);
		&main_functions::exit;
	}
	$FORM{'balance'} =~ s/\$//;
} else { $FORM{'balance'} = "0"; }
my ($account) = $FORM{'username'};

if (-e "${path}config/merchant.txt" && $FORM{'free'} <=> 1 && $opt[10] ne "CHECKED") {
	foreach (@merchant) { chomp; }
	if ($merchant[0] eq "authorize.net") {
		my $auth = 1;
		&authorizenet($auth, $account, @merchant);
	} elsif ($merchant[0] eq "linkpoint") {
		my $auth = 1;
		&linkpoint($auth, $account, @merchant);
	} elsif ($merchant[0] eq "paypal") {
		my $auth = 2;
		&writefiles($auth, $account);
		$merchant[3] =~ tr/ /+/;
		$merchant[1] =~ s/\@/%40/;
		print "Location: https://www.paypal.com/cgibin/webscr?custom=$account|signup&item_name=$merchant[3]&submit.x=34&submit.y=15&business=$merchant[1]&item_number=$merchant[2]&cmd=_xclick&no_note=1&no_shipping=1\n\n";
		&main_functions::exit;
	} elsif ($merchant[0] eq "clickbank") {
		my $auth = 2;
		&writefiles($auth, $account);
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
		print "Location: http://www.clickbank.net/sell.cgi?link=$merchant[1]/$linknum/$company&seed=41FLZ9FJJ&u=$account&a=$FORM{'balance'}&t=signup\n\n";
		&main_functions::exit;
	} elsif ($merchant[0] eq "2checkout") {
		my $auth = 2;
		&writefiles($auth, $account);
		print "Location: https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c?x_Login=$merchant[1]&x_amount=$FORM{'balance'}&custom=$account|signup&x_First_Name=$FORM{'name'}&x_Address=$FORM{'address1'}&x_City=$FORM{'city'}&x_State=$FORM{'state'}&x_Zip=$FORM{'zip'}&x_Country=$FORM{'country'}&x_Phone=$FORM{'phone'}&x_Email=$FORM{'email'}\n\n";
		&main_functions::exit;
	}
} else {
	&writefiles('0', $account);
#	if (-e "${path}affiliate/config/config.cgi" && $FORM{'free'} <=> 1) {
#		$FORM{'affiliatesignup'} = 1;
#		$FORM{'username'} = $account;
#		do "${path}affiliate/click.cgi";
#	}
	open (FILE, "${path}template/signup4.txt");
	my @tempfile = <FILE>;
	close (FILE);
	my $temp="@tempfile";
	print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
}

&main_functions::exit;
}
###############################################

###############################################
sub authorizenet {
	my ($auth, $account, @merchant) = @_;
	my @data = &main_functions::merchant_authorizenet($merchant[1], $merchant[2], %FORM);
	if ($data[0] == 1) {
		&writefiles($auth, $account);
		if ($opt[9] eq "CHECKED" && $opt[11] ne "CHECKED") {
			&change_status('add', $account);
		}
		open (FILE, "${path}template/signup4.txt");
		my @tempfile = <FILE>;
		close (FILE);
		my $temp="@tempfile";
		print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
	} elsif ($data[0] == 2) {
		print "Content-type: text/html\n\n";
		print "Authorization Failed: $data[3]";
	} else {
		print "Content-type: text/html\n\n";
		print "Authorization Error: $data[3]";
	}
}
###############################################

###############################################
sub linkpoint {
	my ($auth, $account, @merchant) = @_;
	my ($status, $mess, $avs, $trackingid, $orderid)  = &main_functions::merchant_linkpoint($merchant[1], $merchant[2], %FORM);
	
	if ($status == 0) {
		print "Content-type: text/html\n\n";
		print "Authorization Error: $mess";
	} else {
		&writefiles($auth, $account);
		if ($opt[9] eq "CHECKED" && $opt[11] ne "CHECKED") {
			&change_status('add', $account);
		}
		open (FILE, "${path}template/signup4.txt");
		my @tempfile = <FILE>;
		close (FILE);
		my $temp="@tempfile";
		print "Content-type: text/html\n\n";
		print "$status, $mess, $avs, $trackingid, $orderid";
print <<EOF;
$temp
EOF
	}
}
###############################################

###############################################
sub writefiles {
my ($auth, $account) = @_;
my ($proact, $p, $balanceordered);
if (($opt[9] eq "CHECKED" || $auth == 2) && $auth <=> 1) {
	if ($opt[11] eq "CHECKED" && $opt[10] eq "CHECKED" && $auth <=> 2) {
		$proact = "active";		
	} else {
		$proact = "processing";
	}
} else {
	$proact = "active";
}


if ($config{'data'} eq "text") { &database_functions::addstatus($proact, $account); }
my $newdate = &main_functions::getdate;

if ($auth == 0) {
	$p = $FORM{'ccnumber'};
	my $encryptkey = "drbidsearch";
	$p = &main_functions::Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
}
my $pass = $FORM{'password'};
my $encryptkey = "mempassbse";
$pass = &main_functions::Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
if ($FORM{'free'} && $opt[12] eq "CHECKED") { $FORM{'chname'} = "Free"; }
&database_functions::writeuser($p, $pass, $proact, $newdate, %FORM);
my @user = &database_functions::GetUser($account);

unless ($opt[11] eq "CHECKED") {
	if ($config{'data'} eq "text") { open (FILE, ">${path}data/sites/$account.txt"); }
	for my $count(1 .. $FORM{'signup1'}) {
		my ($keyword, $title, $description, $url, $bid);
		($keyword, $title, $description, $url, $bid, %FORM) = &main_functions::parse_form($count, %FORM);
		if ($config{'data'} eq "mysql") { &database_functions::insert_site($newdate, $account, $count, %FORM); }
		else {
			my $new;
			if ($opt[9] eq "CHECKED") { $new = "new"; }
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}|$new|$count
EOF
		}
	}
	if ($config{'data'} eq "text") { close (FILE); }
}

if ($FORM{'free'} && $opt[12] eq "CHECKED") { $balanceordered = $FORM{'balance'} + $adv[16]; }
elsif ($adv[13] && $opt[9] ne "CHECKED") { $balanceordered = $FORM{'balance'} + $adv[13]; }
elsif ($adv[13] && $opt[10] eq "CHECKED" && $opt[11] eq "CHECKED") { $balanceordered = $FORM{'balance'} + $adv[13]; }
else { $balanceordered = $FORM{'balance'}; }

if ($auth == 0) { &database_functions::update_balance($account, $balanceordered); }

if ($auth == 0) {
	my $subject = "Search Listing - Order";
	my $emailtemp;
	if ($FORM{'free'} && $opt[12] eq "CHECKED") { $emailtemp = "The following member has signed up for free to your search engine:\n\n"; }
	$emailtemp = "The following member has signed up to your search engine:\n\n";
	$emailtemp .= "Name:     $FORM{'name'}\nCompany:  $FORM{'company'}\nEmail:    $FORM{'email'}\nUsername: $FORM{'username'}\nBalance:  $adv[15]$balanceordered\n\n";
	$emailtemp .= "Address:  $FORM{'address1'}\n          $FORM{'address2'}\nCity:     $FORM{'city'}\nState:    $FORM{'state'}\n";
	$emailtemp .= "Zip:      $FORM{'zip'}\nCountry:  $FORM{'country'}\nPhone:    $FORM{'phone'}\n\n";
	if ($opt[9] eq "CHECKED") { $emailtemp .= "Login to the admin to process this order:\n${adminurl}admin.$file_ext\n"; }
	&main_functions::send_email($adminemail, $adminemail, $subject, $emailtemp);		

	if ($opt[9] ne "CHECKED" || $auth == 1) {
		if (-e "${path}affiliate/config/config.cgi" && $FORM{'free'} <=> 1) {
			$FORM{'affiliatesignup'} = 1;
			$FORM{'username'} = $account;
			do "${path}affiliate/click.cgi";
			&click_functions::affiliate_signup(%FORM);
			do "${path}config/config.cgi";
			if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
			else { do "${path}functions_text.$file_ext"; }
			do "${path}functions.$file_ext";
		}
		&approve($account, $balanceordered, @user);
	}
	else {
		open (FILE, "${path}template/emailsignup.txt");
		my @emailmess = <FILE>;
		close (FILE);
		my ($emailtemp);
		foreach my $emailtemp2(@emailmess) {
			chomp($emailtemp2);
			$emailtemp .= "$emailtemp2\n";
		}
		$emailtemp =~ s/\[name\]/$FORM{'name'}/ig;
		$emailtemp =~ s/\[username\]/$FORM{'username'}/ig;
		$emailtemp =~ s/\[address\]/$FORM{'address1'}  $FORM{'address2'}/ig;
		$emailtemp =~ s/\[city\]/$FORM{'city'}/ig;
		$emailtemp =~ s/\[state\]/$FORM{'state'}/ig;
		$emailtemp =~ s/\[country\]/$FORM{'country'}/ig;
		$emailtemp =~ s/\[zip\]/$FORM{'zip'}/ig;
		$emailtemp =~ s/\[phone\]/$FORM{'phone'}/ig;
		$emailtemp =~ s/\[amount\]/$adv[15]$FORM{'balance'}/ig;
		$emailtemp =~ s/\[company\]/$company/ig;
		$emailtemp =~ s/\[url\]/$websiteurl/ig;
		my $subject = "$company - Listing Information";
		&main_functions::send_email($adminemail, $FORM{'email'}, $subject, $emailtemp);
	}
}
}
###############################################

###############################################
sub approve {
	my ($account, $balanceordered, @user) = @_;
	my $count = 0;
	my $newdate = &main_functions::getdate;
	&database_functions::approve_member($newdate, $account, %FORM);
	if ($balanceordered > 0) {
		&database_functions::payment_history($account, $newdate, $balanceordered, $FORM{'invoice'});
	}
	&emailmem($account, @user);
}
###############################################

###############################################
sub emailmem {
	my ($account, @user) = @_;
	open (FILE, "${path}template/emailapprove.txt");
	my @emailmess = <FILE>;
	close (FILE);
	my $emailtemp;
	foreach my $emailtemp2(@emailmess) {
		chomp($emailtemp2);
		$emailtemp .= "$emailtemp2\n";
	}
	my ($memurl);
	unless ($config{'secureurl'} eq "") { $memurl = $config{'secureurl'}; }
	else { $memurl = $config{'adminurl'}; }
	$emailtemp =~ s/\[balance\]/$FORM{'balance'}/ig;
	$emailtemp =~ s/\[totalbalance\]/$FORM{'balance'}/ig;
	$emailtemp =~ s/\[name\]/$FORM{'name'}/ig;
	$emailtemp =~ s/\[username\]/$account/ig;
	my $pass2 = $user[13];
	my $encryptkey = "mempassbse";
	$pass2 = &main_functions::Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
	$emailtemp =~ s/\[password\]/$pass2/ig;
	$emailtemp =~ s/\[listings\]//ig;
	$emailtemp =~ s/\[company\]/$company/ig;
	$emailtemp =~ s/\[url\]/$websiteurl/ig;
	$emailtemp =~ s/\[loginurl\]/${memurl}members.$file_ext/ig;
	my $subject = "$company - Listing Online";
	&main_functions::send_email($adminemail, $user[8], $subject, $emailtemp);
}
###############################################


###############################################
sub merchant {
	open (FILE, "${path}config/merchant.txt");
	my @merchant = <FILE>;
	close (FILE);
	chomp(@merchant);
	my $newdate = &main_functions::getdate;
	if ($FORM{'payment_status'} eq "Pending") { &main_functions::exit; }
	my (@eng, @adv, @opt, $user_id);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	my ($account, $type);
	if ($merchant[0] eq "paypal" || $merchant[0] eq "2checkout") {
		($account, $type) = split(/\|/, $FORM{'custom'});
		if ($merchant[0] eq "paypal") {
			$FORM{'balance'} = $FORM{'payment_gross'};
			$FORM{'invoice'} = $FORM{'txn_id'};
		} else {
			$FORM{'balance'} = $FORM{'total'};
			$FORM{'invoice'} = $FORM{'order_number'};
		}
	} else { ($account, $type, $FORM{'balance'}, $FORM{'invoice'}) = ($FORM{'u'}, $FORM{'t'}, $FORM{'a'}, $FORM{'cbpop'}); }	
	
	my $valid;
	if ($merchant[0] eq "paypal") {	$valid = &main_functions::merchant_paypal($inbuffer, $account, $FORM{'invoice'}); }
	elsif ($merchant[0] eq "clickbank") { $valid = &main_functions::clickbank_valid($FORM{'cbpop'}, $account, $config{'date'}); }
	elsif ($merchant[0] eq "2checkout") {
		my $string = "$merchant[2]"."$merchant[1]"."$merchant[1]-$FORM{'order_number'}"."$FORM{'total'}"; 
		$valid = &main_functions::merchant_2checkout($FORM{'x_MD5_Hash'}, $string, $account, $FORM{'invoice'}, $config{'date'});
	}

	# Affiliate
	if (-e "${path}affiliate/config/config.cgi" && $FORM{'free'} <=> 1) {
		$FORM{'affiliatesignup'} = 1;
		$FORM{'username'} = $account;
		do "${path}affiliate/click.cgi";
		&click_functions::affiliate_signup(%FORM);
		do "${path}config/config.cgi";
		if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
		else { do "${path}functions_text.$file_ext"; }
		do "${path}functions.$file_ext";
	}
	my @sites = &database_functions::GetSites($account);
	my @user = &database_functions::GetUser($account);
	my $oldstatus = $user[14];
	if ($valid == 1) {
		# approved
		my ($balance2, $balance, $newbalance);
		unless ($oldstatus eq "active") {
			if ($config{'data'} eq "text") { &database_functions::remove_status($oldstatus, $account); }
			&database_functions::change_status('active', $account, '1');
			&database_functions::change_status('active', $account);
		}
		if ($type eq "signup") {
			if ($opt[11] ne "CHECKED" && $opt[9] ne "CHECKED") {
				$balance2 = $FORM{'balance'};
				my $count;
				foreach my $line(@sites) {
					chomp($line);
					my @inner = split(/\|/, $line);
					$count++;
					my $keyword = "keyword$count";
					my $title = "title$count";
					my $description = "description$count";
					my $url = "url$count";
					my $bid = "bid$count";
					$FORM{$keyword} = $inner[0];
					$FORM{$bid} = $inner[1];
					$FORM{$title} = $inner[2];
					$FORM{$url} = $inner[3];
					$FORM{$description} = $inner[4];
				}
				$FORM{'signup1'} = $count;
				&approve($account, $FORM{'balance'}, @user);
			} elsif ($opt[11] ne "CHECKED") {
				&database_functions::change_status('add', $account);
				if ($adv[13]) { $FORM{'balance'} = $FORM{'balance'} + $adv[13]; }
				&database_functions::update_balance($account, $FORM{'balance'});
				if ($FORM{'balance'} > 0) { &database_functions::payment_history($account, $newdate, $FORM{'balance'}, $FORM{'invoice'}); }
			} else {
				if ($adv[13]) { $FORM{'balance'} = $FORM{'balance'} + $adv[13]; }
				&database_functions::update_balance($account, $FORM{'balance'});
				if ($FORM{'balance'} > 0) { &database_functions::payment_history($account, $newdate, $FORM{'balance'}, $FORM{'invoice'}); }
			}
		} elsif ($type eq "update") {
			$balance2 = $FORM{'balance'};
			$balance = &database_functions::GetBalance($account);
			$newbalance = $balance2+$balance;
			&database_functions::update_balance($account, $newbalance);
			if ($balance2 > 0) { &database_functions::payment_history($account, $newdate, $FORM{'balance'}, $FORM{'invoice'}); }
			if ($oldstatus eq "inactive") {
				foreach my $line(@sites) {
					chomp($line);
					my @inner = split(/\|/, $line);
					&database_functions::update_sites($inner[0], 'approved', $account, $inner[1], $inner[2], $inner[3], $inner[4], $inner[0], $inner[8]);
					if ($config{'data'} eq "text") { &database_functions::sortit($inner[0]); }
					&database_functions::outbidded($inner[0], $inner[1], $account, undef, undef);
				}	
			}
		}
		if ($type eq "update") {
			open (FILE, "${path}template/emailaddonbalance.txt");
			my @emailmess = <FILE>;
			close (FILE);
			my ($emailtemp, $memurl);
			foreach my $emailtemp2(@emailmess) {
				chomp($emailtemp2);
				$emailtemp .= "$emailtemp2\n";
			}
			unless ($config{'secureurl'} eq "") { $memurl = $config{'secureurl'}; }
			else { $memurl = $config{'adminurl'}; }
			$emailtemp =~ s/\[balance\]/$balance2/ig;
			$emailtemp =~ s/\[totalbalance\]/$newbalance/ig;
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
			
			$subject = "Search Listing - Order";
			$emailtemp = "The following member has successfully placed an order and it has been processed:\n\n";
			$emailtemp .= "Name:     $user[0]\nCompany:  $user[18]\nEmail:    $user[8]\nUsername: $user[12]\n\n";
			$emailtemp .= "Balance Ordered:  $adv[15]$balance2\n";
			$emailtemp .= "Total Balance:    $adv[15]$newbalance\n\n";
			&main_functions::send_email($adminemail, $adminemail, $subject, $emailtemp);			
		}
		my $message = "Your order has been successfully approved";
		&message($message, $account, $user[13]);
	} else {
		# not approved
		if ($type eq "signup") {
			&database_functions::remove_status($oldstatus, $account);
			if ($config{'data'} eq "mysql") {
				&database_functions::delete_member($account);
			} else {
				unlink("${path}data/sites/$account.txt");
				unlink("${path}data/users/$account.txt");
				unlink("${path}data/stats/$account.txt");
				unlink("${path}data/balance/$account.txt");
			}
		} elsif ($type eq "update") {
			if ($config{'data'} eq "mysql") {
				my $user_id = &database_functions::mySQLGetUserID($account);
				my $statement = "delete from balanceaddon where user='$user_id'";
				&database_functions::mySQL($statement);
			} else {
				&database_functions::remove_status('balanceaddon', $account);
			}
		}
		open (FILE, "${path}template/emaildenied.txt");
		my @emailmess = <FILE>;
		close (FILE);
		my $emailtemp;
		foreach my $emailtemp2(@emailmess) {
			chomp($emailtemp2);
			$emailtemp .= "$emailtemp2\n";
		}
		$emailtemp =~ s/\[name\]/$user[0]/ig;
		$emailtemp =~ s/\[company\]/$config{'company'}/ig;
		$emailtemp =~ s/\[url\]/$config{'websiteurl'}/ig;
		my $subject = "$config{'company'} - Order Denied";
		&main_functions::send_email($config{'adminemail'}, $user[8], $subject, $emailtemp);
		my $message = "Your order was denied.  If you have any questions about this, contact <a href=\"mailto:$config{'adminemail'}\">$config{'adminemail'}</a>";
		&message($message, $account, $user[13]);
	}
	&main_functions::exit;
}
###############################################


###############################################
sub message {
my ($message, $user, $pass) = @_;
open (FILE, "${path}template/message.txt");
my @tempfile = <FILE>;
close (FILE);
my $temp="@tempfile";
my $encryptkey = "mempassbse";
$pass = &main_functions::Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
$encryptkey = "drbidsearch";
$pass = &main_functions::Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
$temp =~ s/<\!-- \[message\] -->/$message/ig;
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