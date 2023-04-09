#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/affiliate/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# Affiliate Program by Done-Right Scripts
# Signup Script
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


###############################################
#Gather from config
require "${path}config/config.cgi";
$adminemail = $config{'adminemail'};
$sendmail = $config{'sendmail'};
$company = $config{'company'};
$websiteurl = $config{'websiteurl'};
###############################################


###############################################
# Logics
if ($FORM{'tab'} eq "complete") { &complete; }
else { &main; }
###############################################


###############################################
# First Sign Up Page
sub main {
open (FILE, "${path}template/signup.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
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
	$temp =~ s/\[hits\]/$FORM{'hits'}/ig;
	$temp =~ s/\[username\]/$FORM{'username'}/ig;
	$temp =~ s/\[password\]/$FORM{'password'}/ig;
} else {
	$temp =~ s/\[name\]//ig;
	$temp =~ s/\[checkname\]//ig;
	$temp =~ s/\[email\]//ig;
	$temp =~ s/\[address1\]//ig;
	$temp =~ s/\[address2\]//ig;
	$temp =~ s/\[city\]//ig;
	$temp =~ s/\[state\]//ig;
	$temp =~ s/\[zip\]//ig;
	$temp =~ s/\[country\]/United States/ig;
	$temp =~ s/\[phone\]//ig;
	$temp =~ s/\[sitetitle\]//ig;
	$temp =~ s/\[siteurl\]/http:\/\//ig;
	$temp =~ s/\[category\]/Select Category/ig;
	$temp =~ s/\[hits\]//ig;
	$temp =~ s/\[username\]//ig;
	$temp =~ s/\[password\]//ig;
}
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF

exit;
}
###############################################


###############################################
sub complete {
$username = $FORM{'username'};
$password = $FORM{'password'};
$email = $FORM{'email'};
$username =~ tr/A-Z/a-z/;
$username =~ tr/ /_/;
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
unless ($FORM{'hits'}) { $error .= "Please specify the amount <B>Hits</B> your site receives<BR>"; }
unless ($FORM{'username'}) { $error .= "Please specify a <B>Username</B><BR>"; }
unless ($FORM{'password'}) { $error .= "Please specify a <B>Password</B><BR>"; }

if ($username eq $password) { $error .= "Your <B>Username</B> cannot be the same as your <B>Password</B><BR>"; }

if (-e "${path}users/$username.txt") { $error .= "The <B>Username</B> you chose is <B>Already Taken</B>, please choose a different one<BR>"; }
$lengthuser = length($username);
$lengthpass = length($password);
if ($lengthuser < 5) { $error .= "Please specify a <B>Username</B> of <B>5 - 12</B> characters<BR>"; }
if ($lengthpass < 5) { $error .= "Please specify a <B>Password</B> of <B>5 - 12</B> characters<BR>"; }
if ($FORM{'terms'} eq "off") { $error .= "Please check the box to agree to the <B>Terms & Conditions</B><BR>"; }

if ($error) {
	&main;
	exit;
}
&writeuser;
&email;
open (FILE, "${path}template/complete.txt");
@tempfile = <FILE>;
close (FILE);
$temp="@tempfile";
print "Content-type: text/html\n\n";
print <<EOF;
$temp
EOF
}
###############################################


###############################################
sub writeuser {
$pass = $password;
$encryptkey = "mempassaff";
$pass = &Encrypt($pass,$encryptkey,'asdfhzxcvnmpoiyk');

($sec, $min, $hour, $mday, $mon, $year)=localtime(time);
$year2 = $year;
$year2 =~ s/1//;
$year =~ s/1/20/;
$mon++;
if (length($mon) == 1) { $mon = "0$mon"; }
if (length($mday) == 1) { $mday = "0$mday"; }
$newdate = "$year-$mon-$mday";

open (FILE, ">${path}users/$username.txt");
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
$FORM{'hits'}
$username
$pass
$newdate
EOF
close (FILE);

use DB_File;
use Fcntl qw(:DEFAULT :flock);
$LCK = "lockfile";
sysopen(DBLOCK, $LCK, O_RDONLY | O_CREAT) or die "can't open $LCK: $!";
flock(DBLOCK, LOCK_SH) or die ("can't LOCK_SH $LCK");
$DBNAME = "${path}stats/$username.db";
tie(%hash, "DB_File", $DBNAME, O_RDWR|O_CREAT) or die ("Cannot open database $DBNAME: $!");
untie %hash;
close DBLOCK;
}
###############################################


###############################################
sub email {

open (FILE, "${path}template/emailsignup.txt");
@emailmess = <FILE>;
close (FILE);
foreach $emailtemp2(@emailmess) {
	chomp($emailtemp2);
	$emailtemp .= "$emailtemp2\n";
}
$memurl = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
$memurl =~ s/signup\.cgi$//;
$emailtemp =~ s/\[name\]/$FORM{'name'}/ig;
$emailtemp =~ s/\[username\]/$username/ig;
$emailtemp =~ s/\[password\]/$password/ig;
$emailtemp =~ s/\[company\]/$company/ig;
$emailtemp =~ s/\[url\]/$websiteurl/ig;
$emailtemp =~ s/\[members\]/${memurl}members.cgi/ig;
		
if ($config{'server'} eq "nt") {
	eval { require Net::SMTP; };
	$smtp = Net::SMTP->new($sendmail);
	$smtp->mail($adminemail);
	$smtp->to($FORM{'email'});

	$smtp->data();
	$smtp->datasend("To: $FORM{'email'}\n");
	$smtp->datasend("From: $adminemail\n");
	$smtp->datasend("Subject: $company - Affiliate Program\n");
	$smtp->datasend($emailtemp);
	$smtp->dataend();
	$smtp->quit;
} else {
	open(MAIL,"|$sendmail -t");
	print MAIL "Subject: $company - Affiliate Program\n";
	print MAIL "To: $FORM{'email'}\n";
	print MAIL "From: $adminemail\n";
print MAIL <<EOF;
$emailtemp
EOF
	close(MAIL);
}
	
}
###############################################


###############################################
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