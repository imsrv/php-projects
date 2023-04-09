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
require "/web1/gb000002/docs/revshare/cgibin/configure.cgi";
&configure;

&getperiod;
$periodlength--;

&setupadminstats;

&newperiod;
############################################################
# BEGIN NEW PERIOD
############################################################
sub newperiod{

$clicks = '0';
$sales = '0';
$commission= '0';
$currentperiod= "$currentperiod";

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

open (USERS, "$passwords");
flock(USERS, 2);
@userz=<USERS>;
flock(USERS, 8);
close USERS;
foreach $userz (@userz)	{
$cash = 0;
chomp $userz;
($username,$trash) = split(/\:/,$userz);

	$mix = "$username"."$currentperiod";
	$query = "INSERT INTO byuser values('$username',$clicks,$sales,$commission,'$currentperiod','$mix')";
	$dbh->do($query);

}

$dbh->disconnect;

}
############################################################
# SETUP ADMINSTATS
############################################################
sub setupadminstats{

$clicks = '0';
$sales = '0';
$commission= '0';
$currentperiod= "$currentperiod";

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

$query = "INSERT INTO overview values($clicks,$sales,$commission,'$currentperiod')";
$dbh->do($query);
$query = "INSERT INTO bydate values($clicks,$sales,$commission,'$shortdate')";
$dbh->do($query);

open (USERS, "$passwords");
flock(USERS, 2);
@userz=<USERS>;
flock(USERS, 8);
close USERS;
foreach $userz (@userz)	{
$cash = 0;
chomp $userz;
($username,$trash) = split(/\:/,$userz);
	$mix = "$username"."$shortdate";
	$query = "INSERT INTO stats values('$username',$clicks,$sales,$commission,'$shortdate','$mix')";
	$dbh->do($query);


}

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
