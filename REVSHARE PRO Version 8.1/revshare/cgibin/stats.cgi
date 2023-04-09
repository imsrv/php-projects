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
####################################################################################################
print "Content-type: text/html\n\n";

&form_parse;
$username = $FORM{'username'};
$password = $FORM{'password'};
&getperiod;

$agent = $username;

&printheader;
&outstats;
&printfooter;
exit;
######################################################################
# PRINT STATS
######################################################################
sub outstats {

$dailyclicks= "0";
$confirmed= "0";
$dailycash = "0";
$periodlength--;

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

for ($count=0;$count<=$periodlength;$count++) {
$paydates = $paydays[$count];

my($query) = "SELECT * FROM stats where username = '$agent' and sdate = '$paydates'";

my($sth) = $dbh->prepare($query);
$sth->execute || die("Couldn't exec sth!");

while(@row = $sth->fetchrow)  {
	$dailyclicks = $row[1];
	$confirmed = $row[2];
	$dailycash = $row[3];
}

$sth->finish;

print <<OUTSTATS;
  <tr>
    <td width="33%" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF"><small>$paydates</small> </font></td>
    <td width="33%" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF"><small>$dailyclicks</small> </font></td>
    <td width="33%" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF"><small>$confirmed</small> </font></td>
  </tr>
OUTSTATS

	$totalcash = $totalcash + $dailycash;
	$totalconfirmed = $totalconfirmed + $confirmed;
	$totalclicks = $totalclicks + $dailyclicks;
	$dailyclicks = 0;
	$confirmed = 0;
	$dailycash = 0;


}


$dbh->disconnect;
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

<p align=\"center\"><font face="Arial" color="#000000"><strong>STATISTICS FOR $username:  PERIOD $period</strong></font></p>

<p align=\"center\"><font face="Arial" color="#000000"><strong>$startdate - $stopdate</strong></font></p>

<p align=\"center\"><font face="Arial" color="#000000"><strong><a href="https://secure2.ibill.com/cgi-win/ccard/cmiuserm.exe">For your detailed sales figures Click on this link to go to Internet Billing Co.</a></strong></font></p>

<p align=\"center\"><font face="Arial" color="#000000"><strong>Use your same Username and Password to Log in:</strong></font></p>


<div align=\"center\"><center>


<table border="0" width="51%" cellpadding="0" cellspacing="4">
  <tr>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>Date</strong></font></td>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>Clicks</strong></font></td>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>Sales</strong></font></td>
  </tr>

ENDHEADER
}
######################################################################
# PRINT FOOTER
######################################################################
sub printfooter {

if ($totalclicks > 0){
$totalsalesratio = int (($totalconfirmed/$totalclicks)*100);
}

print <<ENDFOOTER;

  <tr>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>TOTALS</strong></font></td>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>$totalclicks</strong></font></td>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>$totalconfirmed</strong></font></td>
  </tr>



</table>
</center></div>


<div align=\"center\"><center>

<table border=\"0\" width=\"20%\" cellpadding=\"0\">
  <tr>

<td width=\"25%\"><p align=\"center\">
<form action="$cgiurl/stats.cgi" method="post">
<input type="hidden" value="$lastperiod" name="period">
<input type="hidden" value="$username" name="username">
<input type="hidden" value="$password" name="password">
<input type="submit" value="Previous Pay Period" name="submit">
</form>
</td>

<td width=\"25%\"><p align=\"center\">
<form action="$cgiurl/stats.cgi" method="post">
<input type="hidden" value="$nextperiod" name="period">
<input type="hidden" value="$username" name="username">
<input type="hidden" value="$password" name="password">
<input type="submit" value="Next Pay Period" name="submit">
</form>
</td>

<td width=\"25%\"><p align=\"center\">
<form action="$cgiurl/banners.cgi" method="post">
<input type="hidden" value="$username" name="username">
<input type="hidden" value="$password" name="password">
<input type="hidden" value="$website" name="website">
<input type="submit" value="Get Banners" name="submit">
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