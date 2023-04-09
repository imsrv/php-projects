#!/usr/bin/perl
####################################################################################################
# REVSHARE PRO REPLACEMENT FILE FOR IBILL PROCESSOR	                  Version 8.0                            
# Copyright 1998  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 6/12/98                                      			Last Modified 7/30/99                           
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
&form_parse;

$pincode=$FORM{'pincode'};
$username=$FORM{'username'};
$password = $FORM{'password'};
$transaction = $FORM{'transaction'};
$subscription = $FORM{'subscription'};
$billingmethod = $FORM{'billingmethod'};
$email = $FORM{'email'};
$firstname = $FORM{'firstname'};
$lastname = $FORM{'lastname'};
$webfile = $FORM{'ref1'};
$expire = $FORM{'ref2'};
$revshareid = $FORM{'ref3'};
$loggedin=$transaction;
############################################################
#  MAIN ROUTINE IS HERE
############################################################ 
#&refergate;

if ($username eq ""){
print "Content-Type: text/html\n\n";
print "Invalid username - backup and choose another";
exit;
}

if ($password eq ""){
print "Content-Type: text/html\n\n";
print "Invalid password - backup and choose another";
exit;
}

&lookup;
&expire;  #remove expired passwords
&refreshpincodes;
&ibill; # Make sure Pin Number is Valid and update database
&encrypt; # Encrypt Pin Number
&save; # Save user info to database


print "Content-Type: text/html\n\n";

print" <form action=\"$payoutcgi\" method=\"post\">";
print"<input type=hidden name=\"subscription\" value=\"$subscription\">";
print"<input type=hidden name=\"agent\" value=\"$revshareid\">";
print"<input type=hidden name=\"membersurl\" value=\"$securedurl\">";
print"<input type=submit value=\"PRESS TO ENTER MEMBER AREA\">";
print"</form>";


exit;
############################################################
#  VALIDATE POST IS AUTHENTIC
############################################################
sub refergate {            
         if ($ENV{'HTTP_REFERER'} =~ /$localurl/i) {
			$flag = "OK";
          }
          if ($ENV{'HTTP_REFERER'} =~ /$remoteurl/i) {
			$flag = "OK";
          } 
		  if ($ENV{'HTTP_REFERER'} =~ /$remoteurl2/i) {
			$flag = "OK";
          } 
        if ($flag ne "OK"){
          print "Content-Type: text/html\n\n";
          print "PERMISSION DENIED:  $ENV{'HTTP_REFERER'}";
          exit;
          }                 
}  
############################################################
#  FIRST CHECK TO SEE IF USERNAME IS AVAILABLE
############################################################
sub lookup	{
open (PASSWORDS, "$accessfile");
@passwords=<PASSWORDS>;

foreach $passwords (@passwords)	{
($checkusername,$checkpass)=split(/:/,$passwords);

if ($checkusername eq $FORM{'username'})	{
        print "Content-type: text/html\n\n";

print <<ENDOFPAGE;
<body bgcolor=#008080 text=#FFFFFF>
$username is unavailable.  Please backup and try again.
ENDOFPAGE
	exit;		}}}
############################################################
#  CREATE A PASSWORD FOR THE NEW USER
############################################################
sub encrypt	{

chomp $password;			
$crypted = crypt($password,"Gp");
}
############################################################
#  SAVE NEW ACCOUNT INFORMATION TO YOUR PASSWORD DATABSE
############################################################
sub save	{
&todayjulean;

if ($billingmethod eq "recurring"){
$expire = 999999999;
}

open (FILE, ">>$userdatabase");
flock(FILE, 2);
print FILE "$username|$crypted|$pincode|$transaction|$subscription|$today|$expire\n";
flock(FILE, 8);
close (FILE);

open (FILE, ">>$accessfile");
flock(FILE, 2);
print FILE "$username:$crypted\n";
flock(FILE, 8);
close (FILE);

		}
#################################################################################
#################################################################################
sub refreshpincodes {
open (PINS, "$webfile");
@pins=<PINS>;
close PINS;

foreach $pins (@pins)  {
chomp $pins;
push (@refreshpins,$pins) unless ($pins =~ /x/i);
                        }

open (REFRESHEDWEBFILE, ">$webfile");
flock(REFRESHEDWEBFILE, 2);
foreach $refreshpins (@refreshpins)       {
print REFRESHEDWEBFILE "$refreshpins\n";              }
flock(REFRESHEDWEBFILE, 8);
close (REFRESHEDWEBFILE);

}
############################################################
#  VALIDATE IBILL PINCODE
############################################################ 
sub ibill {

$formfile = "webchall.html";
$goodfile = "good.html";
$badfile  = "bad.html";

$WEBLEN = 8;
chop($date = &ctime(time));

$method = $ENV{"REQUEST_METHOD"};
$type = $ENV{"CONTENT_TYPE"};
if($method eq "GET") {
        &send_file($formfile);
        exit;
}
if($method ne "POST" || $type ne "application/x-www-form-urlencoded") {
        &system_error("Web authorization code must come from a Form\n");
        exit;
}

$number = &normalize_query($pincode);

if(length($number) != 7) {
        &system_error("Sorry, but $number is not a valid number\n");
        exit;
}
unless(open(WEB,"+<$webfile")) {
        &system_error("Could not open web data file $webfile.\n");
        exit;
}
seek(WEB, 0, 0);
unless(open(WLOG,">>$logfile")) {
        &system_error("Could not open log file $logfile.\n");
        exit;
}
$goodbad=$badfile;
SEARCH:
for ($recnum = 0; read(WEB, $goodnum, $WEBLEN); $recnum++) {
        $goodnum =~ tr/0-9//cd;
        if($number eq $goodnum) {
                $goodbad=$goodfile;
                seek(WLOG, 0, 2);
             
print (WLOG"$today|$username|$password|$email|$firstname $lastname|$webfile|$pincode|$transaction|$subscription|$expire\n");

                             
                seek(WEB, -$WEBLEN, 1);
                $goodnum =~ tr/0-9/x/;
                print WEB $goodnum;
                last SEARCH;
        }
        seek(WEB, $recnum*$WEBLEN, 0);
}
close(WEB);
close(WLOG);
chmod(0666, $logfile);


if ($goodbad eq $badfile){
&send_file($goodbad);
exit;
}
############################################################
#  IBILL SUBROUTINES
############################################################ 

sub system_error {
        local($errmsg) = @_;
        &print_header("System Error");
        print $errmsg;
        &print_footer;
}

sub print_header {
        local($title) = @_;
        print "Content-type: text/html\n\n";
        print "<HTML>\n";
        print "<HEAD>\n";
        print "<TITLE>$title</TITLE>\n";
        print "</HEAD>\n";
        print "<BODY>\n";
        print "<H1>$title</H1>\n";
}

sub print_footer {
        print "</BODY>\n";
        print "</HTML>\n";
}

sub normalize_query {
        local($value) = @_;
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
        return $value;
}

sub send_file {
        local($file) = @_;
        unless(open(FILE,$file)) {
                &system_error("This pincode is not in our system - Access denied\n");
                exit;
        }
        print "Content-type: text/html\n\n";
        while (<FILE>) {
                print;
        }
        close(FILE);
}
}
############################################################
#  REMOVE OLD PASSWORDS
############################################################
sub expire {

&todayjulean;

open (PASSWORDS, "$userdatabase");
@expire=<PASSWORDS>;
close PASSWORDS;

foreach $expire (@expire)  {

($expireusername,$expirepass,$ibilp,$ibilt,$ibils,$expiredate,$expireexp)=split(/\|/,$expire);
$diff=($today-$expiredate);
$secretpass = $expireusername.":".$expirepass."\n";
push (@refreshcards,$expire) unless ($diff > $expireexp);
push (@refreshpass,$secretpass) unless ($diff > $expireexp);
                        }
open (PASSWORDS, ">$userdatabase");
flock(PASSWORDS, 2);
foreach $refreshcards (@refreshcards)       {
print PASSWORDS $refreshcards;              }
flock(PASSWORDS, 8);
close (PASSWORDS);

open (PASSWORDS, ">$accessfile");
flock(PASSWORDS, 2);
foreach $refreshpass (@refreshpass)       {
print PASSWORDS $refreshpass;              }
flock(PASSWORDS, 8);
close (PASSWORDS);

}
############################################################
#  FORM PARSING
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
#  DATE ROUTINES
############################################################
sub date	{
	$date=localtime(time);
	($day, $month, $no, $hr, $year) = split (/\s+/,$date);
	$return_date = "$hr, $month $no";
	if ($month =~ /jan/i) {$month=1}     
	elsif ($month =~ /feb/i) {$month=2}  
	elsif ($month =~ /mar/i) {$month=3}  
	elsif ($month =~ /apr/i) {$month=4}  
	elsif ($month =~ /may/i) {$month=5}  
	elsif ($month =~ /jun/i) {$month=6}  
	elsif ($month =~ /jul/i) {$month=7}  
	elsif ($month =~ /aug/i) {$month=8}  
	elsif ($month =~ /sep/i) {$month=9}  
	elsif ($month =~ /oct/i) {$month=10} 
	elsif ($month =~ /nov/i) {$month=11} 
	elsif ($month =~ /dec/i) {$month=12} 
		}

sub todayjulean	{
&date;
	$date=localtime(time);
	@date=split (/\s+/, $date);
	&julean ($month, @date[2], @date[4]);
	$today = $jule;

		}

sub julean{ 
#
# Julean date based on Jan. 1, 1992 being day 1.

$thisdayjulean=0;

@months=(0,31,28,31,30,31,30,31,31,30,31,30,31);

$local_month=$_[0];
$tday=$_[1];
$tyear=$_[2];
$leapdays=((($tyear-1992)/4)+1);     #must be a leap year, so I chose 1992 

# This section drops the remainder of the leap day for the year.
$leapdays2=(($tyear-1992)%4);
$leapdays-=($leapdays2*0.25);
if ($tyear>=2000) {$leapdays-= 1};   #even 100 year years do not have
                                                # leap days in them
$local_thisyear=$tyear-1992;
for ($local_i=1;$local_i<=$local_thisyear;$local_i++) {
                $thisdayjulean+=365;}
for ($local_i=1;$local_i<$local_month;$local_i++) {    #minus 1 because current month not complete
        $thisdayjulean+=@months[$local_i]}
if ($local_month<3 && $leapdays2==0) {$leapdays--};
$thisdayjulean+=$leapdays+$tday;
$jule=$thisdayjulean;
}

sub footer {print "</body></html>";}

sub redirect {
$loc=$_[0];
print"Location: $_ \n\n"; }

sub month_txt   {
($_)=@_;
if ($_==1) {$month_txt = "January"}
elsif ($_==2) {$month_txt="February"}
elsif ($_==3) {$month_txt="March"}
elsif ($_==4) {$month_txt="April"}
elsif ($_==5) {$month_txt="May"}
elsif ($_==6) {$month_txt="June"}
elsif ($_==7) {$month_txt="July"}
elsif ($_==8) {$month_txt="August"}
elsif ($_==9) {$month_txt="September"}
elsif ($_==10) {$month_txt="October"}
elsif ($_==11) {$month_txt="November"}
elsif ($_==12) {$month_txt="December"}
else {$month_txt="ERROR"};
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