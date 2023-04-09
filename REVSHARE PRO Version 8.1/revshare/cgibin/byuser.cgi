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
require "configure.cgi";
&configure;
&refergate;
&form_parse;
####################################################################################################
print "Content-type: text/html\n\n";
$totalconfirmed = "0";
&form_parse;
&getperiod;
if ($FORM{'period'}){
$currentperiod =$FORM{'period'};
}

&printheader;

open (USERS, "$passwords");
flock(USERS, 2);
@userz=<USERS>;
flock(USERS, 8);
close USERS;

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

foreach $userz (@userz)	{
$cash = 0;
chomp $userz;
	($username,$trash) = split(/\:/,$userz);


$dailyclicks = "0";
$confirmed = "0";
$dailycash = "0";

	my($query) = "SELECT * FROM byuser where period = '$currentperiod' and username = '$username'";

	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$dailyclicks= $row[1];
		$confirmed = $row[2];
		$dailycash= $row[3];
	}
$sth->finish;

&outstats;
}
&printfooter;
exit;
######################################################################
# PRINT STATS
######################################################################
sub outstats {
	
$totalcash = $totalcash + $dailycash;
$totalconfirmed = $totalconfirmed + $confirmed unless ($dailycash eq "0");
$totalclicks = $totalclicks + $dailyclicks;

if ($dailyclicks > 0){


print <<INSERTSTATS;


  <tr>
    <td width="20%">
<form action="$cgiurl/stats.cgi" method="post">
<input type="hidden" name="period" value="$period">
<input type="hidden" name="username" value="$username">
<input type="hidden" name="password" value="$password">
<input type="submit" value="$username" name="submit">
</form>
    </td>
    <td width="20%" cellpadding="1" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF">$dailyclicks</font></td>
    <td width="20%" cellpadding="1" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF">$confirmed</font></td>
    <td width="20%"><form action="$cgiurl/getinfo.cgi" method="post">
<input type="hidden" value="$username" name="username">
<input type="submit" value="GET INFO" name="submit">
</form>
    </td>
    <td width="20%"><form action="$cgiurl/delete.user.cgi" method="post">
<input type="hidden" value="$username" name="username">
<input type="submit" value="DELETE" name="submit">
</form>
    </td>
  </tr>



INSERTSTATS
}
}
######################################################################
# PRINT HEADER
######################################################################
sub printheader {

print <<ENDHEADER;

<html>

<head><title>STATISTICS FOR $username:  PERIOD $period</title>

</head>

<body bgcolor=\"white\">

<p align=\"center\"><font face="Arial" color="#000000"><strong>SUBSCRIPTIONS BY USER FOR PERIOD $period</strong></font></p>

<p align=\"center\"><font face="Arial" color="#000000"><strong>$startdate - $stopdate</strong></font></p>


<p align=\"center\"><font face="Arial" color="#000000"><strong>$date $time</strong></font></p>

<div align=\"center\"><center>
<table border=\"0\" width=\"25%\" cellpadding=\"0\">
<td width=\"20%\">
<form action="$cgiurl/byuser.cgi" method="post">
<input type="hidden" value="$lastperiod" name="period">
<input type="submit" value="PREVIOUS PERIOD" name="submit">
</form>
</td>
<td width=\"20%\">
<form action="$cgiurl/byuser.cgi" method="post">
<input type="hidden" value="$nextperiod" name="period">
<input type="submit" value="NEXT PERIOD" name="submit">
</form>
</td></tr></table></center></div>

<div align=\"center\"><center>

<table border="0" width="50%" cellpadding="0" cellspacing="4">
  <tr>
    <td width="20%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>AGENT</strong></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>CLICKS</strong></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>SALES</strong></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"></td>
    <td width="20%" bgcolor="#000000"><p align="left"></td>
  </tr>

ENDHEADER
}
######################################################################
# PRINT FOOTER
######################################################################
sub printfooter {

print <<ENDFOOTER;

  <tr>
    <td width="20%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>TOTALS</strong></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>$totalclicks</strong></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>$totalconfirmed</strong></font></td>
    <td width="20%" bgcolor="#000000"><font face="Arial" color="#FFFFFF"><strong></strong></font></td>
    <td width="20%" bgcolor="#000000"><font face="Arial" color="#FFFFFF"><strong></strong></font></td>
  </tr>



</table>
</center></div>

<div align=\"center\"><center>

<table border=\"0\" width=\"25%\" cellpadding=\"0\">
<tr>


<td width=\"20%\" cellpadding=\"1\">
<form method="post" action="overview.cgi">
<input type="submit" value="BY PERIOD"></form>
</td>
<td width=\"20%\" cellpadding=\"1\">
<form action="$cgiurl/bydate.cgi" method="post">
<input type="hidden" value="$period" name="period">
<input type="submit" value="BY DATE" name="submit">
</form>
</td>
 </tr>
</table>
</center></div>


</body>

</html>



ENDFOOTER
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
        if ($flag ne "OK"){
          print "Content-Type: text/html\n\n";
          print "PERMISSION DENIED:  $ENV{'HTTP_REFERER'}";
          exit;
          }                 
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