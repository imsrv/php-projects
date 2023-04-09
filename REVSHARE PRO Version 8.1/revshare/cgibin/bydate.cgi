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
&getperiod;

open (PAYABLES, "$logsdirectory/$period.log");
flock(PAYABLES, 2);
@payables=<PAYABLES>;
$confirmed = @payables;
flock(PAYABLES, 8);
close PAYABLES;

&printheader;
&outstats;

&printfooter;
exit;
######################################################################
# PRINT STATS
######################################################################
sub outstats {

$periodlength--;

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

for ($count=0;$count<=$periodlength;$count++) {
$dailyclicks = "0";
$confirmed = "0";
$dailycash = "0";
$paydates = $paydays[$count];
	chomp $paydates;

	my($query) = "SELECT * FROM bydate where sdate = '$paydates'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$dailyclicks= $row[0];
		$confirmed = $row[1];
		$dailycash= $row[2];
	}
$sth->finish;



$totalconfirmed = $totalconfirmed + $confirmed;
$totalclicks = $totalclicks + $dailyclicks;
$totalcash = $totalcash + $dailycash;


print <<INSERTSTATS;

  <tr>
    <td width="33%" cellpadding="1" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF"><strong>$paydates</strong></font></td>
    <td width="33%" cellpadding="1" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF">$dailyclicks</font></td> 
   <td width="33%" cellpadding="1" bgcolor="#8080FF"><font face="Arial" color="#FFFFFF">$confirmed</font></td>
  </tr>


INSERTSTATS
}

$dbh->disconnect;
}
######################################################################
# PRINT HEADER
######################################################################
sub printheader {

print <<ENDHEADER;

<html>

<head><title>STATISTICS BY DATE:  PERIOD $period</title>

</head>

<body bgcolor=\"white\">

<p align=\"center\"><font face="Arial" color="#000000"><strong>STATISTICS BY DATE FOR PERIOD $period</strong></font></p>

<p align=\"center\"><font face="Arial" color="#000000"><strong>$startdate - $stopdate</strong></font></p>


<p align=\"center\"><font face="Arial" color="#000000"><strong>$date</strong></font></p>

<div align=\"center\"><center>
<table border=\"0\" width=\"25%\" cellpadding=\"0\">
<td width=\"20%\">
<form action="$cgiurl/bydate.cgi" method="post">
<input type="hidden" value="$lastperiod" name="period">
<input type="submit" value="PREVIOUS PERIOD" name="submit">
</form>
</td>
<td width=\"20%\">
<td width=\"20%\"><font face=\"Comic Sans MS\" color=\"#000000\">
<form action="$cgiurl/bydate.cgi" method="post">
<input type="hidden" value="$nextperiod" name="period">
<input type="submit" value="NEXT PERIOD" name="submit">
</form>
</td></tr></table></center></div>

<div align=\"center\"><center>
<table border="0" width="50%" cellpadding="0" cellspacing="4">
  <tr>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>DATE</strong></font></td>
    <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>CLICKS</strong></font></td> 
  <td width="33%" bgcolor="#000000"><p align="left"><font face="Arial" color="#FFFFFF"><strong>SALES</strong></font></td>
  </tr>

ENDHEADER
}
######################################################################
# PRINT FOOTER
######################################################################
sub printfooter {

print <<ENDFOOTER;

  <tr>
    <td width="33%" cellpadding="1" bgcolor="#000000"><strong><font face="Arial"
    color="#FFFFFF">TOTALS</font></strong></td>
    <td width="33%" cellpadding="1" bgcolor="#000000"><strong><font face="Arial"
    color="#FFFFFF">$totalclicks</font></strong></td>
    <td width="33%" cellpadding="1" bgcolor="#000000"><strong><font face="Arial"
    color="#FFFFFF">$totalconfirmed</font></strong></td>
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
<form action="$cgiurl/byuser.cgi" method="post">
<input type="hidden" value="$period" name="period">
<input type="submit" value="BY AGENT" name="submit">
</form>
</td>


  </tr>
</table>
</center></div>&nbsp;



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