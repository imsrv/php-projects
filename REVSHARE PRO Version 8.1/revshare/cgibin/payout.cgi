#!/usr/bin/perl
####################################################################################################
# REVSHARE PRO					 		                  Version 8.1                            
# Copyright 1998  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 6/12/98                                      			Last Modified 9/14/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999 Telecore Media International, INC - All Rights Reserved.                    
# http://www.superscripts.com                                                                                                            
# Selling the code for this program, modifying or redistributing this software over the Internet or 
# in any other medium is forbidden.  Copyright and header may not be modified
#
# my name is drew star... and i am funky... http://www.drewstar.com/
####################################################################################################
&form_parse;
&payout;

print "Content-Type: text/html\n\n";
print "<center><a href=$membersurl>CLICK HERE TO ENTER MEMBER AREA</a>\n\n";
############################################################
# MAIN ROUTINE
############################################################
sub payout {
require "configure.cgi";
############################################################
&configure;
$commission = 1;
$identity = $FORM{'subscription'};
$agent = $FORM{'agent'};
$membersurl = $FORM{'membersurl'};

#$query = "$ENV{'QUERY_STRING'}";
#($identity,$agent)=split(/\=/,$query);

if ($agent eq ""){
return;
}
&getperiod;
&savepayout;
}
############################################################
#  SAVE COMMISSION
############################################################
sub savepayout {

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

my($query) = "SELECT * FROM bysale where tracer = '$identity'";
my($sth) = $dbh->prepare($query);
$sth->execute || die("Couldn't exec sth!");

while(@row = $sth->fetchrow)  {
	$referingagent = $row[0];
}
$sth->finish;

if ($referingagent eq $agent){
return;
}

$query = "INSERT INTO bysale values('$agent',$commission,'$identity','$shortdate','$currentperiod')";
$dbh->do($query);

$query = "UPDATE stats SET sales= (sales+ 1) where username = '$agent' and sdate = '$shortdate'";
$dbh->do($query);
$query = "UPDATE stats SET commission = (commission+$commission) where username = '$agent' and sdate = '$shortdate'";
$dbh->do($query);

$query = "UPDATE overview SET sales= (sales+ 1) where period = '$currentperiod'";
$dbh->do($query);
$query = "UPDATE overview SET commission = (commission+$commission) where period = '$currentperiod'";
$dbh->do($query);

$query = "UPDATE byuser SET sales= (sales+ 1) where username = '$agent' and period = '$currentperiod'";
$dbh->do($query);
$query = "UPDATE byuser SET commission = (commission+$commission) where username = '$agent' and period = '$currentperiod'";
$dbh->do($query);

$query = "UPDATE bydate SET sales= (sales+ 1) where sdate = '$shortdate'";
$dbh->do($query);
$query = "UPDATE bydate SET commission = (commission+$commission) where sdate = '$shortdate'";
$dbh->do($query);




$dbh->disconnect;

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
open (SCHEDULESEEDS, "$schedule");
flock(SCHEDULESEEDS, 2);
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


$period = $FORM{'period'};

if ($period eq ""){
	@paydays = @currentpaydays;
	$period = $currentperiod;
	$startdate = $paydays[0];
	$periodlength = @paydays;
	$periodcue = $periodlength - 1;
	$stopdate = $paydays[$periodcue];
}

else {
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
}


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
1;    #  Return true
