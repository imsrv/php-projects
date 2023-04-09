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
chop($date = &ctime(time));

open (MEMBERBASE, "$memberdatabase");
flock(MEMBERBASE, 2);
@countmembers=<MEMBERBASE>;
$countagents = @countmembers;
flock(MEMBERBASE, 8);
close MEMBERBASE;

&printheader;

open (SCHEDULESEEDS, "$schedule");
flock(SCHEDULESEEDS, 2);
@schedules=<SCHEDULESEEDS>;
flock(SCHEDULESEEDS, 8);
close SCHEDULESEEDS;

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");


foreach $schedules (@schedules){
	$period++;
	&getperiodata;
	&outstats;
}

$dbh->disconnect;
&printfooter;
exit;
######################################################################
# PRINT STATS
######################################################################
sub outstats {

$perioddailyclicks = "0";
$periodsales = "0";
$periodcommissions = "0";


my($query) = "SELECT * FROM overview where period = '$period'";

my($sth) = $dbh->prepare($query);
$sth->execute || die("Couldn't exec sth!");

while(@row = $sth->fetchrow)  {
	$perioddailyclicks = $row[0];
	$periodsales = $row[1];
	$periodcommissions = $row[2];
}

$sth->finish;

$totalclicks = $totalclicks + $perioddailyclicks;
$totalconfirmed = $totalconfirmed + $periodsales;
$totalcash = $totalcash + $periodcommissions;



$salesratio  = "0";
if ($perioddailyclicks ne "0"){
$salesratio = int(($periodsales/$perioddailyclicks)*100);
}

print <<INSERTSTATS;

<tr>
<td width="20%" cellpadding="1" bgcolor="#FFFFFF">
<form action="$cgiurl/bydate.cgi" method="post">
<input type="hidden" name="period" value="$period">
<input type="submit" value="$startdate-$stopdate" name="submit">
</form>
</td>
<td width="20%" cellpadding="1" bgcolor="#8080FF"><font color="#FFFFFF"><font face="Arial">$salesratio\%</font></font></td>
<td width="20%" cellpadding="1" bgcolor="#8080FF"><font color="#FFFFFF"><font face="Arial">$perioddailyclicks</font></font></td>
<td width="20%" cellpadding="1" bgcolor="#8080FF"><font color="#FFFFFF"><font face="Arial">$periodsales</font></font></td>
</tr>

INSERTSTATS
}
######################################################################
# PRINT HEADER
######################################################################
sub printheader {

print <<ENDHEADER;

<html>

<head><title>YEARLY OVERVIEW</title>

</head>

<body bgcolor=\"white\">

<p align=\"center\"><font face=\"Arial\" color=\"#000000\"><strong>YEARLY OVERVIEW</strong></font></p>

<p align=\"center\"><font face=\"Arial\" color=\"#000000\"><strong>$date</strong></font></p>
<p align=\"center\"><font face=\"Arial\" color=\"#000000\"><strong>$countagents AGENTS HAVE JOINED</strong></font></p>



<div align="center"><center>

<table border="0" width="50%" cellpadding="0" cellspacing="4">
  <tr>
    <td width="20%" bgcolor="#000000"><p align="left"><font color="#FFFFFF"><font face="Arial"><strong>PERIOD</strong></font></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font color="#FFFFFF"><font face="Arial"><strong>CONVERSION</strong></font></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font color="#FFFFFF"><font face="Arial"><strong>CLICKS</strong></font></font></td>
    <td width="20%" bgcolor="#000000"><p align="left"><font color="#FFFFFF"><font face="Arial"><strong>SALES</strong></font></font></td>
  </tr>

ENDHEADER
}
######################################################################
# PRINT FOOTER
######################################################################
sub printfooter {


$totalsalesratio= "0";
if ($totalclicks> 0){
$totalsalesratio= int (($totalconfirmed/$totalclicks)*100);
}

print <<ENDFOOTER;


  <tr>
    <td width="20%" bgcolor="#000000"><p align="left"><strong><font face="Arial"
    color="#FFFFFF">TOTAL</font></strong></td>
    <td width="20%" bgcolor="#000000"><p align="left"><strong><font face="Arial"
    color="#FFFFFF">$totalsalesratio\%</font></strong></td>
    <td width="20%" bgcolor="#000000"><p align="left"><strong><font face="Arial"
    color="#FFFFFF">$totalclicks</font></strong></td>
    <td width="20%" bgcolor="#000000"><p align="left"><strong><font face="Arial"
    color="#FFFFFF">$totalconfirmed</font></strong></td>
  </tr>



</table>
</center></div><p>&nbsp;</p>
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
#  GET PERIOD
############################################################
sub getperiodata {            



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