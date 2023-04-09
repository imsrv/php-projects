#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/affiliate/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# Affiliate Program by Done-Right Scripts
# Members Script
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
###############################################
#Gather from config
require "${path}config/config.cgi";
$adminemail = $config{'adminemail'};
$sendmail = $config{'sendmail'};
$company = $config{'company'};
$websiteurl = $config{'websiteurl'};
$bidsearchurl = $config{'bidsearchurl'};
$pay = $config{'pay'};
$payamount = $config{'amount'};
###############################################


###############################################
# Check Login
if ($FORM{'tab'}) {
	unless ($FORM{'tab'} eq "forgot" || $FORM{'tab'} eq "modifyprofile") {
		if ($FORM{'password'}) {
			$user=$FORM{'username'};
			$pass=$FORM{'password'};
			&passcheck;
		} else {
			$user=$FORM{'user'};
			$pass=$FORM{'pass'};
			$encryptkey = "draffiliate";
			$pass = &Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
			&passcheck;
		}
		sub passcheck {
			if ($user eq "") {
				$error = "Invalid Login";
				&main;
			} elsif ($pass eq "") {
				$error = "Invalid Login";
				&main;
			}
			unless (-e "${path}users/$user.txt") {
				$error = "Invalid Login";
				&main;
			}
			open(FILE, "${path}users/$user.txt");
			@info = <FILE>;
			close(FILE);
			chomp(@info);
			$pass2 = $info[15];
			$encryptkey = "mempassaff";
			$pass2 = &Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
			unless ($pass eq $pass2) {
				$error = "Invalid Login";
				&main;
			} else {
				$encryptkey = "draffiliate";
				$pass = &Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
			}
		}
	}
}
###############################################


###############################################
# Logics
if ($FORM{'tab'} eq "login") { &members; }
elsif ($FORM{'tab'} eq "forgot") { &forgot; }
elsif ($FORM{'tab'} eq "stats") { &stats; }
elsif ($FORM{'tab'} eq "profile") { &profile; }
elsif ($FORM{'tab'} eq "modifyprofile") { &modifyprofile; }
elsif ($FORM{'tab'} eq "searchcode") { &searchcode; }
else { &main; }
###############################################


###############################################
sub main {
open (FILE, "${path}template/login.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/<!-- \[error\] -->/$error/ig;
$temp =~ s/<!-- \[error2\] -->/$error2/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;	
}
###############################################


###############################################
sub forgot {
$user=$FORM{'user'};
if ($FORM{'user'} eq "") { $error2 = "Please enter your username."; }
elsif(not(-e "${path}users/$user.txt")) { $error2 = "Account not found."; }
if ($error2) {
	&main;
	exit;
}

open(DATA,"${path}users/$user.txt");
@info = <DATA>;
close(DATA);
chomp(@info);
$email=$info[2];
$pass=$info[15];
$encryptkey = "mempassaff";
$pass = &Decrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
$message = "Your password has been emailed to you.";
if ($config{'server'} eq "nt") {
	eval { require Net::SMTP; };
	$smtp = Net::SMTP->new($sendmail);
	$smtp->mail($adminemail);
	$smtp->to($email);
	
	$smtp->data();
	$smtp->datasend("To: $email\n");
	$smtp->datasend("From: $adminemail\n");
	$smtp->datasend("Subject: $company - Forgot Password\n");
	$smtp->datasend("Dear $info[0],\n\nHere is your password as you requested it:\n$pass\n\nSincerely,\n\n$company\n$websiteurl");
	$smtp->dataend();
	$smtp->quit;
} else {
	open(MAIL,"|$sendmail -t");
	print MAIL "Subject: $company - Forgot Password\n";
	print MAIL "To: $email\n";
	print MAIL "From: $adminemail\n";
print MAIL <<EOF;
Dear $info[0],

Here is your password as you requested it:
$pass

Sincerely,

$company
$websiteurl
EOF
	close(MAIL);
}

open (FILE, "${path}template/forgot.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/<\!-- \[email\] -->/$email/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
}
###############################################


###############################################
sub members {
open (FILE, "${path}template/members.txt");
@tempfile = <FILE>;
close (FILE);
$todaysearnings=$todaysclicks="0";
$date = "STAT".(localtime)[3].".".((localtime)[4]+1).".".((localtime)[5] + 1900);
$DBNAME = "${path}stats/$user.db";
tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
if (exists $click_hash{$date}) {
	if ($pay == 3) {
		@sp = split(/\|/, $click_hash{$date});
		$todaysclicks = $sp[0];
		$todaysearnings = $sp[1]*$payamount;
	} else {
		$todaysclicks = $click_hash{$date};
		$todaysearnings = $todaysclicks*$payamount;
	}
}
untie %hash;
$todaysearnings = sprintf("%.2f", $todaysearnings);
$temp="@tempfile";
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[created\] -->/$info[16]/ig;
$temp =~ s/<!-- \[todaysclicks\] -->/$todaysclicks/ig;
$temp =~ s/<!-- \[todaysearnings\] -->/\$$todaysearnings/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;	
}
###############################################


###############################################
sub stats {
open(FILE, "${path}users/$user.txt");
@info = <FILE>;
close(FILE);
chomp(@info);
($sec, $min, $hour, $mday, $mon, $year)=localtime(time);
$year =~ s/1/20/;
$mon++;
$current = "$mon.$year";
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
		  
%day =   ("1"	=> "31",
		  "2"	=> "28",
		  "3"	=> "31",
		  "4"	=> "30",
		  "5"	=> "31",
		  "6"	=> "30",
		  "7"	=> "31",
		  "8"	=> "31",
		  "9"	=> "30",
		  "10"	=> "31",
		  "11"	=> "30",
		  "12"	=> "31");

if (length($mday) == 1) { $mday = "0$mday"; }


$DBNAME = "${path}stats/$user.db";
tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
foreach $key (keys %click_hash) {
	if ($key =~ /MON/) {
		$date = $key;
		$date =~ s/MON//;
		@date = split(/\./, $date);
		if ($#date == 2) {
			$formal = "$month{$date[1]} 01, $date[2]";
			$formal2 = "$month{$date[1]} $date[1], $date[2]";
		} else {
			$formal = "$month{$date[0]} 01, $date[1]";
			$formal2 = "$month{$date[0]} $day{$date[0]}, $date[1]";
		}
		$datehash{$date} = "$formal|$formal2";
	} elsif ($key =~ /PAID/) {
		$amountreceived += $click_hash{$key};
	}
}
$amountreceived = sprintf("%.2f", $amountreceived);
$formal = "$month{$mon} 01, $year";
$formal2 = "$month{$mon} $mday, $year";
$datehash{$mon.".".$year} = "$formal|$formal2";

unless ($FORM{'viewing'}) {
	$FORM{'viewing'} = $viewing = "$month{$mon} 01, $year";
	$FORM{'viewing2'} = $viewing2 = "$month{$mon} $mday, $year";
	$myviewing = $myviewing2 = "$mon.$year";
} else {
	@viewdate = split(/\./, $FORM{'viewing'});
	@viewdate2 = split(/\./, $FORM{'viewing2'});
	$viewing = "$month{$viewdate[0]} 01, $viewdate[1]";
	$viewing2 = "$month{$viewdate2[0]} $day{$viewdate2[0]}, $viewdate2[1]";
	$myviewing = $FORM{'viewing'};
	$myviewing2 = $FORM{'viewing2'};
}
foreach $test(sort keys %datehash) {
	@split = split(/\|/, $datehash{$test});
	if ($test eq $myviewing) { $options .= "<option SELECTED value=\"$test\">$split[0]</option>"; }
	else { $options .= "<option value=\"$test\">$split[0]</option>"; }
	if ($test eq $myviewing2) { $options2 .= "<option SELECTED value=\"$test\">$split[1]</option>"; }
	else { $options2 .= "<option value=\"$test\">$split[1]</option>"; }
}


open (FILE, "${path}template/statistics.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
$temp =~ s/<!-- \[viewing\] -->/$viewing/ig;
$temp =~ s/<!-- \[viewing2\] -->/$viewing2/ig;
$temp =~ s/<!-- \[options\] -->/$options/ig;
$temp =~ s/<!-- \[options2\] -->/$options2/ig;
$temp =~ s/<!-- \[viewing3\] -->/$viewing - $viewing2/ig;
$temp =~ s/<!-- \[created\] -->/$info[16]/ig;
$temp =~ s/<!-- \[amount\] -->/\$$amountreceived/ig;

$sort = $FORM{'sort'};
$datelink = "<a href=\"members.cgi?tab=stats&user=$user&pass=$pass&viewing=$myviewing&viewing2=$myviewing2&sort=datelink\">Date<\/a>";
$clickthroughs = "<a href=\"members.cgi?tab=stats&user=$user&pass=$pass&viewing=$myviewing&viewing2=$myviewing2&sort=clickthroughs\">Click Throughs<\/a>";
$amountmade = "<a href=\"members.cgi?tab=stats&user=$user&pass=$pass&viewing=$myviewing&viewing2=$myviewing2&sort=amountmade\">Amount<\/a>";



if ($FORM{'sort'} eq "" || $FORM{'sort'} eq "datelink") {
	$sort = "datelink";
	$field = 0;
	$temp =~ s/<!-- \[datelink\] -->/Date/ig;
	$temp =~ s/<!-- \[clickthroughs\] -->/$clickthroughs/ig;
	$temp =~ s/<!-- \[amountmade\] -->/$amountmade/ig;
} elsif ($FORM{'sort'} eq "clickthroughs") {
	$sort = "clickthroughs";
	$field = 1;
	$temp =~ s/<!-- \[datelink\] -->/$datelink/ig;
	$temp =~ s/<!-- \[clickthroughs\] -->/Click Throughs/ig;
	$temp =~ s/<!-- \[amountmade\] -->/$amountmade/ig;
} elsif ($FORM{'sort'} eq "amountmade") {
	$sort = "amountmade";
	$field = 2;
	$temp =~ s/<!-- \[datelink\] -->/$datelink/ig;
	$temp =~ s/<!-- \[clickthroughs\] -->/$clickthroughs/ig;
	$temp =~ s/<!-- \[amountmade\] -->/Amount/ig;
}

@temparray = split(/<\!-- \[listing\] -->/,$temp);
print "Content-type: text/html\n\n";
print $temparray[0];

$plus = 0;
foreach $key (keys %click_hash) {
	if ($myviewing eq $myviewing2 && $myviewing eq $current) {
		if ($key =~ /STAT/) {
			$val = $key;
			$key =~ s/STAT//;
			&tally;
		}
	} elsif ($myviewing eq $current || $myviewing2 eq $current) {
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
			$member[$addit] = "$sp[1].$sp[2]|$clk|$amt|OWING";
		}
		if ($key =~ /MON/) {
			$val = $key;
			$key =~ s/MON//;
			&tally;
		}
	} else {
		if ($key =~ /MON/) {
			$val = $key;
			$key =~ s/MON//;
			&tally;
		}
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
	else { $paidowing = "OWING"; }
	$member[$plus] = "$key|$clk|$amt|$paidowing";
	$plus++;
}

if ($plus == 1) {
	@sorted_links = @member;
} else {
	if ($field == 0) {
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

foreach $line(@sorted_links) {
	chomp($line);
	$temp = $temparray[1];
	unless ($line eq "") {
		@inner = split(/\|/, $line);
		@date = split(/\./, $inner[0]);
		if (length($inner[0]) >= 8) {
			$formal = "$month{$date[1]} $date[0], $date[2]";
		} else {
			$formal = "$month{$date[0]} $date[1]";
		}
		$inner[2] = sprintf("%.2f", $inner[2]);
		$temp =~ s/<!-- \[statdate\] -->/$formal/ig;
		$temp =~ s/<!-- \[statclicks\] -->/$inner[1]/ig;
		$temp =~ s/<!-- \[statmade\] -->/\$$inner[2]/ig;
		$temp =~ s/<!-- \[paidowing\] -->/$inner[3]/ig;
		print $temp;
		$totalclicks += $inner[1];
		$totalamount += $inner[2];
	}
}
$totalamount = sprintf("%.2f", $totalamount);
$temparray[2] =~ s/<!-- \[totalclicks\] -->/$totalclicks/ig;
$temparray[2] =~ s/<!-- \[totalamount\] -->/\$$totalamount/ig;
print $temparray[2];
untie %click_hash;
exit;	
}
###############################################


###############################################
sub profile {
open(FILE, "${path}users/$user.txt");
@info = <FILE>;
close(FILE);
open (FILE, "${path}template/profile.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;


if ($error) {
	$temp =~ s/<\!-- \[error\] -->/$error/ig;
	$temp =~ s/\[name\]/$FORM{'name'}/ig;
	$temp =~ s/\[checkname\]/$FORM{'checkname'}/ig;
	$temp =~ s/\[email\]/$FORM{'email'}/ig;
	$temp =~ s/\[address1\]/$FORM{'address1'}/ig;
	$temp =~ s/\[address2\]/$FORM{'address2'}/ig;
	$temp =~ s/\[city\]/$FORM{'city'}/ig;
	$temp =~ s/\[state\]/$FORM{'state'}/ig;
	$temp =~ s/\[zip\]/$FORM{'zip'}/ig;
	$temp =~ s/\[country\]/$FORM{'country'}/ig;
	$temp =~ s/\[phone\]/$FORM{'phone'}/ig;
	$temp =~ s/\[sitetitle\]/$FORM{'sitetitle'}/ig;
	$temp =~ s/\[siteurl\]/$FORM{'siteurl'}/ig;
	$temp =~ s/\[category\]/$FORM{'category'}/ig;
	$temp =~ s/\[password\]/$FORM{'password'}/ig;
} else {
	$temp =~ s/\[name\]/$info[0]/ig;
	$temp =~ s/\[checkname\]/$info[1]/ig;
	$temp =~ s/\[email\]/$info[2]/ig;
	$temp =~ s/\[address1\]/$info[3]/ig;
	$temp =~ s/\[address2\]/$info[4]/ig;
	$temp =~ s/\[city\]/$info[5]/ig;
	$temp =~ s/\[state\]/$info[6]/ig;
	$temp =~ s/\[zip\]/$info[7]/ig;
	$temp =~ s/\[country\]/$info[8]/ig;
	$temp =~ s/\[phone\]/$info[9]/ig;
	$temp =~ s/\[sitetitle\]/$info[10]/ig;
	$temp =~ s/\[siteurl\]/$info[11]/ig;
	$temp =~ s/\[category\]/$info[12]/ig;
	$pass2 = $info[15];
	$encryptkey = "mempassaff";
	$pass2 = &Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
	$temp =~ s/\[password\]/$pass2/ig;	
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;	
}
###############################################


###############################################
sub modifyprofile {
$user = $FORM{'user'};
$password = $FORM{'password'};
$email = $FORM{'email'};
$password =~ tr/ /_/;
if ($FORM{'name'} eq "" || $FORM{'name'} !~ / /) { $error .= "Please specify your first & last <B>Name</B><BR>"; }
unless ($FORM{'checkname'}) { $error .= "Please specify who to make the <B>Checks Out</B><BR>"; }
if ($email !~ /.*\@.*\..*/) { $error .= "Please specify a valid <B>E-Mail Address</B><BR>"; }
unless ($FORM{'address1'}) { $error .= "Please specify your <B>Street Address</B><BR>"; }
unless ($FORM{'city'}) { $error .= "Please specify your <B>City</B><BR>"; }
unless ($FORM{'state'}) { $error .= "Please specify your <B>State</B><BR>"; }
unless ($FORM{'zip'}) { $error .= "Please specify your <B>Zip</B><BR>"; }
unless ($FORM{'phone'}) { $error .= "Please specify your <B>Phone Number</B><BR>"; }
unless ($FORM{'sitetitle'}) { $error .= "Please specify your <B>Site's Title</B><BR>"; }
if ($FORM{'siteurl'} eq "http://" || $FORM{'siteurl'} eq "") { $error .= "Please specify your <B>Site's URL</B><BR>"; }
unless ($FORM{'category'}) { $error .= "Please specify your <B>Site's Category</B><BR>"; }
unless ($FORM{'password'}) { $error .= "Please specify a <B>Password</B><BR>"; }
if ($error) {
	&profile;
	exit;
}

open(FILE, "${path}users/$user.txt");
@info = <FILE>;
close(FILE);
chomp(@info);
$pass2 = $FORM{'password'};
$encryptkey = "mempassaff";
$pass2 = &Encrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
open (FILE, ">${path}users/$user.txt");
print FILE <<EOF;
$FORM{'name'}
$FORM{'checkname'}
$FORM{'email'}
$FORM{'address1'}
$FORM{'address2'}
$FORM{'city'}
$FORM{'state'}
$FORM{'zip'}
$FORM{'country'}
$FORM{'phone'}
$FORM{'sitetitle'}
$FORM{'siteurl'}
$FORM{'category'}
$info[13]
$user
$pass2
$info[16]
EOF
close (FILE);
$pass = $FORM{'password'};
$encryptkey = "draffiliate";
$pass = &Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');
$message = "Profile Updated";
&message;
exit;
}
###############################################


###############################################
sub searchcode {
open (FILE, "${path}template/searchcode.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/\[searchurl\]/$bidsearchurl/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;
}
###############################################


###############################################
sub message {
open (FILE, "${path}template/message.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
$temp =~ s/<\!-- \[message\] -->/$message/ig;
$temp =~ s/\[user\]/$user/ig;
$temp =~ s/\[pass\]/$pass/ig;
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
exit;
}
###############################################


###############################################
#($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
#$encryptkey = "$encryptkey$dayofyear";
sub Encrypt {
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