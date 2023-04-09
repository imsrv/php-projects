#!/usr/bin/perl -s
use Socket;
####################################################################################################
# REVSHARE PRO					 		                  Version 8.1                            
# Copyright 1998  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 6/12/98                                      			Last Modified 10/20/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999 Telecore Media International, INC - All Rights Reserved.                    
# http://www.superscripts.com                                                                                                            
# Selling the code for this program, modifying or redistributing this software over the Internet or 
# in any other medium is forbidden.  Copyright and header may not be modified
#
# my name is drew star... and i am funky... http://www.drewstar.com/
####################################################################################################
require "configure.cgi";
&configure;
#&refergate;
####################################################################################################
&form_parse;

$name=$FORM{'RevSharerName'};
$company=$FORM{'RevSharerPayTo'};
$sitename=$FORM{'sitename'};
$url=$FORM{'url'};
$email=$FORM{'RevSharerEmail'};
$address1=$FORM{'RevSharerAddrOne'};
$address2=$FORM{'RevSharerAddrTwo'};
$city=$FORM{'RevSharerCity'};
$state=$FORM{'RevSharerState'};
$zip=$FORM{'RevSharerZIP'};
$country=$FORM{'RevSharerCountry'};
$ssnumber=$FORM{'ssnumber'};
$username=$FORM{'NewRevSharer'};
$password=$FORM{'NewPassword'};
$vpassword=$FORM{'ConfirmPassword'};
$agreement=$FORM{'agreement'};
$address = "$address1$address2";

$NewRevSharer=$FORM{'NewRevSharer'};
$NewPassword=$FORM{'NewPassword'};
$ConfirmPassword=$FORM{'ConfirmPassword'};
$RevSharerName=$FORM{'RevSharerName'};
$RevSharerAddrOne=$FORM{'RevSharerAddrOne'};
$RevSharerAddrTwo=$FORM{'RevSharerAddrTwo'};
$RevSharerCity=$FORM{'RevSharerCity'};
$RevSharerZIP=$FORM{'RevSharerZIP'};
$RevSharerCountry=$FORM{'RevSharerCountry'};
$RevSharerPhone=$FORM{'RevSharerPhone'};
$RevSharerEmail=$FORM{'RevSharerEmail'};
$RevSharerPayTo=$FORM{'RevSharerPayTo'};

print "Content-type: text/html\n\n";

&errcheck;
&lookup;
&getperiod;

$buffer = "$buffer&ErrorURL=$ErrorURL&SuccessURL=$SuccessURL&RevSharerPayMethod=check&RequestType=SignupRevSharer&MasterAccountID=$MasterAccountID&MasterAccountNumber=$MasterAccountNumber";
$add = $buffer;
$postlen = length($add);
$msg = "POST $script HTTP/1.0\r\nContent-type: application/x-www-form-urlencoded\r\nContent-length: $postlen\r\n\r\n$add\r\n";
$submit = "$msg";
&ssl_post;


&encrypt;
&setupuserstats;
&save;
&welcome;
&autoreply;
exit;
############################################################
# SETUP USERSTATS
############################################################
sub setupuserstats{

$clicks = '0';
$sales = '0';
$commission= '0';
$agent = "$username";
$mix = "$agent"."$shortdate";
use DBI;

$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

$query = "INSERT INTO stats values('$agent',$clicks,$sales,$commission,'$shortdate','$mix')";
$dbh->do($query);

$mix = "$agent"."$currentperiod";
$query = "INSERT INTO byuser values('$agent',$clicks,$sales,$commission,'$currentperiod','$mix')";
$dbh->do($query);

$dbh->disconnect;
}
############################################################
#  FIRST CHECK TO SEE IF USERNAME IS AVAILABLE
############################################################
sub lookup	{
open (PASSWORDS, "$passwords");
@passwords=<PASSWORDS>;

foreach $passwords (@passwords)	{
($checkusername,$checkpass)=split(/:/,$passwords);

if ($checkusername eq $username)	{

print <<ENDOFPAGE;
<body bgcolor=#008080 text=#FFFFFF>
$username is unavailable.  Please backup and choose another username.
ENDOFPAGE
	exit;		}}}
############################################################
#  CREATE A PASSWORD FOR THE NEW USER
############################################################
sub encrypt	{
$crypted = crypt($password,"Gp");
}
############################################################
#  SAVE INFORMATION TO YOUR BANNER DATABSE
############################################################
sub save	{
open (FILE, ">>$memberdatabase");
flock(FILE, 2);
print FILE "$name|$company|$sitename|$url|$email|$address|$city|$state|$zip|$country|$ssnumber|$username|$password|$recruiter|$signmeupfor\n";
flock(FILE, 8);
close (FILE);

open (FILE, ">>$passwords");
flock(FILE, 2);
print FILE "$username:$crypted\n";
flock(FILE, 8);
close (FILE);

		}
############################################################
#  SUBROUTINES
############################################################
sub form_parse  {
	read (STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs)
	{
    	($name, $value) = split(/=/, $pair);
    	$value =~ tr/+/ /;
    	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    	$FORM{$name} = $value;
	}}
############################################################
#  SUBROUTINES
############################################################
sub errcheck {
if ($agreement ne "AGREE"){
	print "YOU MUST AGREE TO ALL TERMS TO JOIN!\n";
	exit;
	}

if ($password ne $vpassword){
	print "PASSWORDS DO NOT MATCH!\n";
	exit;
	}
if ($name eq ""){
	print "NAME IS REQUIRED!\n";
	exit;
	}
if ($company eq ""){
	print "COMPANY NAME IS REQUIRED!\n";
	exit;
	}
if ($sitename eq ""){
	print "SITE NAME IS REQUIRED!\n";
	exit;
	}
if ($url eq ""){
	print "SITE URL IS REQUIRED!\n";
	exit;
	}
if ($email eq ""){
	print "VALID EMAIL ADDRESS IS REQUIRED!\n";
	exit;
	}
if ($address eq ""){
	print "ADDRESS IS REQUIRED!\n";
	exit;
	}
if ($city eq ""){
	print "CITY IS REQUIRED!\n";
	exit;
	}
if ($state eq ""){
	print "STATE IS REQUIRED!\n";
	exit;
	}
if ($zip eq ""){
	print "ZIPCODE IS REQUIRED!\n";
	exit;
	}
if ($country eq ""){
	print "COUNTRY IS REQUIRED!\n";
	exit;
	}
if ($ssnumber eq ""){
	print "TAX ID NUMBER IS REQUIRED!\n";
	exit;
	}
if ($username eq ""){
	print "USERNAME IS REQUIRED!\n";
	exit;
	}
if ($password eq ""){
	print "PASSWORD IS REQUIRED!\n";
	exit;
	}

if (length ($username) < 4){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}
if (length ($username) > 12){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}
if (length ($password) < 4){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}
if ($username eq ""){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}

if ($password eq ""){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}

if ($username =~ / /){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}

if ($password =~ / /){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}

if ($password eq $username){
print "Content-Type: text/html\n\n";
print "SIGNUP ERROR!<br>";
print "Username and Password Must be 4-8 Characters Long<br>";
print "Spaces are not allowed in username or password<br>";
print "Password and Username Must Not Match.<br>";
print "Please backup and choose a valid username and password.<br>";
exit;
}

}
######################################################################
# PRINT THANK YOU MESSAGE TO SCREEN
######################################################################
sub welcome {
print <<ENDHEADER;

<html>

<head>
<title>WELCOME!</title>
</head>

<body bgcolor="white">

<p><font face="Arial" color="#000000"><small>Your Affiliates Account is now setup. </small></font></p>

<p><font face="Arial" color="#000000"><small>You will be receiving an email confirmation
shortly. </small></font></p>

<p><font face="Arial" color="#000000"><small>The following URL is where you can 
retrieve your link code and check your stats in realtime: <a
href="$webmasterurl">$webmasterurl</a>
</small></font></p>

<p><font face="Arial" color="#000000"><small>Remember to place the link code in a heavy
traffic area to earn the most money possible. We look forward to a long and prosperous
business relationship. If you have any questions please feel free to contact our
office at anytime. </small></font></p>

<p><font face="Arial" color="#000000"><small>Best Regards </small></font></p>

<p><font face="Arial" color="#000000"><small>Staff</small> </font></p>

<p><font face="Arial" color="#000000"><small>CGI DEVELOPED BY <a
href="http://www.superscripts.com">Drewstar's Superscripts</a></small> </font></p>
</body>
</html>

ENDHEADER
}

######################################################################
# EMAIL THANK YOU MESSAGE
######################################################################

sub autoreply	{

open (MAIL, "| $mailprogram $email");
print MAIL "Reply-to: $adminemail\n";
print MAIL "From: $adminemail\n";
print MAIL "To: $email\n";

print MAIL "Subject: Welcome to Our Affiliates Program!\n\n";

print MAIL "Your Affiliates Account is now setup. Below is \n";
print MAIL "all your account information.\n\n";

print MAIL "$name\n";
print MAIL "$company\n";
print MAIL "$sitename\n";
print MAIL "$email\n";
print MAIL "$address\n";
print MAIL "$city, $state  $zip\n";
print MAIL "$country\n";
print MAIL "$ssnumber\n";
print MAIL "$username\n";
print MAIL "$password\n\n";

print MAIL "The following URL is where you can retrieve your link code and\n";
print MAIL "check your stats in realtime:\n\n";

print MAIL "$webmasterurl\n\n";
print MAIL "Remember to place the link code in a heavy traffic area.\n";

print MAIL "We look forward to a long and prosperous business relationship. \n";
print MAIL "If you have any questions please feel free to contact our office at anytime.\n\n";
print MAIL "Best Regards\n";
print MAIL "Staff\n\n\n";








print MAIL "CGI Developed by http://www.superscripts.com\n";
close MAIL;

}
############################################################
#  VALIDATE POST IS AUTHENTIC
############################################################
sub refergate {            
         if ($ENV{'HTTP_REFERER'} =~ /$localurl/i) {
			$flag = "OK";
          }
        if ($flag ne "OK"){
          print "Content-Type: text/html\n\n";
          print "PERMISSION DENIED:  $ENV{'HTTP_REFERER'}";
          exit;
          }                 
}  
############################################################
#  TIME ROUTINE
############################################################
sub ctime {

    @DoW = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    @MoY = ('Jan','Feb','Mar','Apr','May','Jun',
	    'Jul','Aug','Sep','Oct','Nov','Dec');

    local($time) = @_;
    local($[) = 0;
    local($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst);

    $TZ = defined($ENV{'TZ'}) ? ( $ENV{'TZ'} ? $ENV{'TZ'} : 'GMT' ) : '';
    ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) =
        ($TZ eq 'GMT') ? gmtime($time) : localtime($time);

    if($TZ=~/^([^:\d+\-,]{3,})([+-]?\d{1,2}(:\d{1,2}){0,2})([^\d+\-,]{3,})?/){
        $TZ = $isdst ? $4 : $1;
    }
    $TZ .= ' ' unless $TZ eq '';

    $year += 1900;
    sprintf("%s %s %2d %2d:%02d:%02d %s%4d\n",
      $DoW[$wday], $MoY[$mon], $mday, $hour, $min, $sec, $TZ, $year);
}
#####################################################################################################
#  SEND CREDIT CARD INFO TO BANK
#####################################################################################################
sub ssl_post {

if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') } 
die "No port specified." unless $port; 
if(!($iaddr = inet_aton($remote))) 
{ 
print "Content-type: text/html\n\n";
print "Could not lookup host: $remote\n"; 
return; 
} 
$paddr = sockaddr_in($port, $iaddr); 
$proto = getprotobyname('tcp'); 
socket(SOCK, PF_INET, SOCK_STREAM, $proto) || die "socket: $!"; 
if(!(connect(SOCK, $paddr))) 
{ 
print "Content-type: text/html\n\n";
print "Unable to conect to $remote\n"; 
return; 
} 
send(SOCK,$submit,0); 
while(<SOCK>) { 
#print $_;

if ($_ =~ /errorcode=1031/i){
#print "Content-type: text/html\n\n";
print "This username is not available.  Please backup and choose another";
exit;
}
if ($_ =~ /error/i){
#print "Content-type: text/html\n\n";
print "THERE IS AN ERROR IN YOUR FORM - PLEASE BACKUP AND TRY AGAIN";
exit;
}


}

return 0; 
}
############################################################
#  GET PERIOD
############################################################
sub getperiod {            
chop($date = &ctime(time));
($weekday,$month,$day,$time,$zone,$year)=split(/ /,$date);

if ($day eq ""){
$day = $time;
}

$shortdate = "$month $day";
flock(SCHEDULESEEDS, 2);
open (SCHEDULESEEDS, "$schedule");
@schedules=<SCHEDULESEEDS>;
flock(SCHEDULESEEDS, 8);
close SCHEDULESEEDS;

foreach $schedules (@schedules){
	($searchperiod,$getpaydays)=split(/\|/,$schedules);
	(@searchpaydays)=split(/\,/,$getpaydays);
	foreach $searchpaydays(@searchpaydays){
		chomp $searchpaydays;
		if ($shortdate eq $searchpaydays){
			$currentperiod = $searchperiod;
			@currentpaydays = @searchpaydays;
		}
	}
}

$period = $currentperiod;


	foreach $schedules (@schedules){
		($searchperiod,$getpaydays)=split(/\|/,$schedules);
		(@searchpaydays)=split(/\,/,$getpaydays);
			if ($period eq $searchperiod){
				@paydays = @searchpaydays;
			}
	}

	$startdate = $paydays[0];
	$periodlength = @paydays;
	$periodcue = $periodlength - 1;
	$stopdate = $paydays[$periodcue];


$lastperiod = $period - 1;
$nextperiod = $period + 1;

}
############################################################
#  TIME ROUTINE
############################################################
sub ctime {

    @DoW = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    @MoY = ('Jan','Feb','Mar','Apr','May','Jun',
	    'Jul','Aug','Sep','Oct','Nov','Dec');

    local($time) = @_;
    local($[) = 0;
    local($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst);

    $TZ = defined($ENV{'TZ'}) ? ( $ENV{'TZ'} ? $ENV{'TZ'} : 'GMT' ) : '';
    ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) =
        ($TZ eq 'GMT') ? gmtime($time) : localtime($time);

    if($TZ=~/^([^:\d+\-,]{3,})([+-]?\d{1,2}(:\d{1,2}){0,2})([^\d+\-,]{3,})?/){
        $TZ = $isdst ? $4 : $1;
    }
    $TZ .= ' ' unless $TZ eq '';

    $year += 1900;
    sprintf("%s %s %2d %2d:%02d:%02d %s%4d\n",
      $DoW[$wday], $MoY[$mon], $mday, $hour, $min, $sec, $TZ, $year);
}
