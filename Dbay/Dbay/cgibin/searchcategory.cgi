#!/usr/bin/perl
####################################################################################################
# DBAY				                                        	Version 1.0                            
# Copyright 1999  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 9/24/99                                      			Last Modified 11/29/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999  Telecore Media International, Inc. - All Rights Reserved.                    
# http://www.superscripts.com/                                                                                                           
# Selling the code for this program without prior written consent is         
# expressly forbidden.                                           
#                                                                           
# Obtain written permission before redistributing this software over the Internet or 
# in any other medium.  In all cases copyright and header must remain intact.
#
# My name is drew star... and i am funky...  http://www.drewstar.com/artist/
####################################################################################################
print "Content-type: text/html\n\n";
require "configure.cgi";
&configure;
open (HDISPLAY, "$htmlheader");
@header=<HDISPLAY>;
open (HDISPLAY, "$htmlfooter");
@footer=<HDISPLAY>;
use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

&searchbyget;
&printheader;
&getbytitle;
&printfooter;
############################################################
#  FIGURE OUT REMAINING TIME/BID INCREMENTS
############################################################
sub countdown  {

chop($date = &ctime(time));
($weekday,$month,$day,$time,$zone,$year)=split(/ /,$date);

if ($day eq ""){
	$day = $time;
	$time= $zone;
	}
if ($weekday =~ /mon/i){
$ttheday = 1;
}
if ($weekday =~ /tue/i){
$ttheday = 2;
}
if ($weekday =~ /wed/i){
$ttheday = 3;
}
if ($weekday =~ /thr/i){
$ttheday = 4;
}
if ($weekday =~ /fri/i){
$ttheday = 5;
}
if ($weekday =~ /sat/i){
$ttheday = 6;
}
if ($weekday =~ /sun/i){
$ttheday = 7;
}

if ($ttheday < $rstartday){
$ttheday = $ttheday+7;
}

($shour,$min,$sec)=split(/\:/,$rstarttime);
($fhour,$min,$sec)=split(/\:/,$time);

$hourcountdown = $shour - $fhour;
$dayselapsed = $ttheday- $rstartday;
$daysremaining = $rduration - $dayselapsed;

if ($hourcountdown < 0){
$hourcountdown = $hourcountdown+24;
$daysremaining = $daysremaining - 1;
}

}
############################################################
#  GET MATCHES BY TITLE
############################################################
sub getbytitle {

my($query) = "SELECT * FROM items where category = '$category'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");
	while(@row = $sth->fetchrow)  {
		$ritemnumber = $row[0];
		$rtitle = $row[1];
		$rcategory = $row[2];
		$rdescription = $row[3];
		$rreserve = $row[4];
		$rgetnoticed = $row[5];
		$rpictureurl = $row[6];
		$rusername = $row[7];
		$rpassword = $row[8];
		$rstartprice = $row[9];
		$rduration = $row[10];
		$rbuyerpaymentmethod = $row[11];
		$rshipinternationally = $row[12];
		$rwhopaysshipping = $row[13];
		$rpaymentmethodbyseller = $row[14];
		$rcardnumber = $row[15];
		$rexpirationdate = $row[16];
		$rstartday = $row[17];
		$rstarttime = $row[18];
		$rcurrenthibid = $row[19];
		$rcurrenthibidder = $row[20];
		$rcurrenthibidemail = $row[21];
		$rmaxbid = $row[22];
		$rfinalbid = $row[23];
		$ritemstatus = $row[24];
		&dumpresults;
	}
$sth->finish;
}
############################################################
#  SEARCH BY GET METHOD
############################################################
sub searchbyget {

$category = $ENV{'QUERY_STRING'};

$end=$start+50;	
$restart = 0;

if ($category eq "all"){
	$category="";
	}

}
############################################################
#  PRINT RESULTS
############################################################
sub dumpresults  {
&countdown;

if ($rcurrenthibid eq ""){
$rcurrenthibid = "0.00";
}

if (!($rcurrenthibid =~ /\./)){
$rcurrenthibid = $rcurrenthibid.".00";
}

if ($rgetnoticed eq "none"){
$displayitem = "<td width=\"64%\" bgcolor=\"#ffffff\"><small><a href=\"$getitemcgi?$ritemnumber\"><font face=\"Arial\" color=\"#000000\">$rtitle</a></small></td>";
}
if ($rgetnoticed eq "boldface"){
$displayitem = "<td width=\"64%\" bgcolor=\"#ffffff\"><small><a href=\"$getitemcgi?$ritemnumber\"><font face=\"Arial\" color=\"#000000\"><strong>$rtitle</strong></a></small></td>";
}
if ($rgetnoticed eq "hilited"){
$displayitem = "<td width=\"64%\" bgcolor=\"#FFFF80\"><small><a href=\"$getitemcgi?$ritemnumber\"><font face=\"Arial\" color=\"#000000\">$rtitle</a></small></td>";
}
if ($rgetnoticed eq "icon"){#icon
$displayitem = "<td width=\"64%\" bgcolor=\"#ffffff\"><small><a href=\"$getitemcgi?$ritemnumber\"><font face=\"Arial\" color=\"#000000\">$rtitle</a><img src=\"$icon\"></small></td>";
}



$i++;
$j++;
if ($i > $start){
if ($i <= $end){


print <<ENDDUMP;
  <tr>
    <td width="8%" bgcolor="#ffffff"><small><font face="Arial" color="#000000">$ritemnumber</font></small></td>
$displayitem
    <td width="12%" bgcolor="#ffffff"><small><font face="Arial" color="#000000">\$$rcurrenthibid</font></small></td>
    <td width="16%" bgcolor="#ffffff"><small><font face="Arial" color="#000000">$daysremaining</font></small></td>
  </tr>

ENDDUMP
}}
}
############################################################
#  PRINT HEADER
############################################################
sub printheader  {

$sstart = $end-49;
print @header;

print <<ENDHEADER;



<table border="0" width="100%" cellspacing="3" cellpadding="0">
  <tr>
    <td width="8%" bgcolor="#99CCCC"><strong><small><font face="Arial">Item#</font></small></strong></td>
    <td width="64%" bgcolor="#99CCCC"><strong><small><font face="Arial">Item</font></small></strong></td>
    <td width="12%" bgcolor="#99CCCC"><strong><small><font face="Arial">Price</font></small></strong></td>
    <td width="16%" bgcolor="#99CCCC"><strong><small><font face="Arial">Days Remaining</font></small></strong></td>
  </tr>



ENDHEADER
}
############################################################
#  PRINT FOOTER
############################################################
sub printfooter  {

if ($j < 50){
print "</table></form></center></div>";
print "<br><font face=\"Arial\" color=\"#000000\"><strong><small>END OF SEARCH RESULTS";
#exit;
}

print <<ENDFOOTER;

</table>

<table border="0" width="100%" cellpadding="0">
  <tr>
    <td width="77%"></td>
    <td width="77%">
<p align="right">

<form action="$searchcgi" method="post">
<input type="hidden" name="keyword" value="$keyword">
<input type="hidden" name="category" value="$category">
<input type="hidden" name="start" value="$restart">
<input type="submit" value="Previous Page">
</form>


</td>
    <td width="34%"><p align="left">
<form action="$searchcgi" method="post">
<input type="hidden" name="keyword" value="$keyword">
<input type="hidden" name="category" value="$category">
<input type="hidden" name="start" value="$end">
<input type="submit" value="Next Page">
</form>

</td>
  </tr>
</table>




ENDFOOTER
print @footer;
print "</body></html>";
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



