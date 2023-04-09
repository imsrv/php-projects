#!/usr/bin/perl
####################################################################################################
# DBAY				                                        	Version 1.0                            
# Copyright 1999  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 9/24/99                                      			Last Modified 9/24/99                           
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

&form_parse;
	$itemnumber = $ENV{'QUERY_STRING'};

		if ($startprice eq ""){
			$startprice="0.00";
			}
		if (!($startprice =~ /\./)){
			$startprice = $startprice.".00";
			}

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

&getitemdata;
	if ($rpictureurl eq "http://"){
		$rpictureurl = $nopic;
		}
	if ($rpictureurl eq ""){
		$rpictureurl = $nopic;
		}
	if ($rtitle eq ""){
		print "This item is no longer available";
		exit;
		}
	if ($rcurrenthibid eq ""){
		$rcurrenthibid = "no bidders";
		}
&lookup;
&calculaterating;
$dbh->disconnect;

&countdown;

if (!$rcurrenthibid){
$nextbid = $rstartprice;
}
if ($rcurrenthibid){
$nextbid = $rcurrenthibid + 2;
}

if (!($nextbid =~ /\./)){
$nextbid = $nextbid.".00";
}
if (!($rcurrenthibid=~ /\./)){
$rcurrenthibid= $rcurrenthibid.".00" unless ($rcurrentbid = "no bidders");
}

&confirmationpage;
############################################################
#  CALCULATE USER RATING
############################################################
sub calculaterating{

	my($query) = "SELECT * FROM feedback where losername = '$vusername'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$cusername = $row[0];
		$closername = $row[1];
		$ccomments = $row[2];
		$crating = $row[3];
		$cdate = $row[4];
		$citemnumber = $row[5];
	}
	$sth->finish;


if ($crating eq "p"){
	$countpos++;
	$countresults++;
	}
if ($crating eq "n"){
	$countneg++;
	$countresults--;
	}
if ($crating eq "e"){
	$countneu++;
	}


}
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
#  GET ITEM DATA FROM DATABASE
############################################################
sub getitemdata  {

	my($query) = "SELECT * FROM closeditems where itemnumber = '$itemnumber'";
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
	}
	$sth->finish;

}
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {

	my($query) = "SELECT * FROM profile where username = '$rusername'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$vemail = $row[0];
		$vname = $row[1];
		$vaddress = $row[2];
		$vcity = $row[3];
		$vstate = $row[4];
		$vcountry = $row[5];
		$vzip = $row[6];
		$vphone = $row[7];
		$vusername = $row[8];
		$vpassword = $row[9];
	}
	$sth->finish;

}
############################################################
#  PRINT ITEM PAGE
############################################################
sub confirmationpage{
print @header;
print <<ENDCONFIRM;

<div align="center"><center>

<table border="1" cellspacing="0" width="100%" bgcolor="#99CCCC">
  <tr>
    <td align="center" width="100%"><font color="#000000" size="3" face="Arial"><b>$rtitle</b></font></td>
  </tr>
  <tr>
    <td align="center" width="100%"><font color="#000000" size="2" face="Arial"><b>Item
    #$itemnumber</b></font></td>
  </tr>
  <tr>
    <td align="center" width="100%"><font color="#000000" size="2" face="Arial">$rcategory</font></td>
  </tr>
</table>
</center></div>

<p align="center">&nbsp;</p>
<div align="center"><center>

<table border="0" width="100%" cellpadding="0">
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Starting
    Price</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small>\$$rstartprice</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Time
    Remaining</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small>AUCTION CLOSED</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>SELLERID</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small><a href="$feedbackcgi?$vusername">$vusername($countresults)</a></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Payment
    Method</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial"><font color="#000000"></font><font
    size="2" color="#000000">$rbuyerpaymentmethod</font></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Who
    Pays Shipping</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small>$rwhopaysshipping</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Final
    Bid</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small>\$$rcurrenthibid</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Location</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small>$vcity,$vstate,$vcountry</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><strong><small>Email
    Seller</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000" face="Arial"><small><a href="mailto:$vemail">$vemail</a></small></font></td>
  </tr>
</table>
</center></div>

<blockquote>
  <blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
          <blockquote>
            <p align="center"><font face="Arial"><small>Seller assumes all responsibility for listing
            this item. You should contact the seller to resolve any questions before bidding. Currency
            is U.S. dollar (\$) unless otherwise noted.</small></font></p>
          </blockquote>
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
</blockquote>
<div align="center"><center>

<table border="1" cellspacing="0" width="100%" bgcolor="#99CCCC">
  <tr>
    <td align="center" width="100%"><font color="#000000" size="3" face="Arial"><b><a
    name="DESC">Description</a></b></font></td>
  </tr>
</table>
</center></div>

<blockquote>
  <p align="center"><font face="Arial"><small><br>
  $rdescription</small></font></p>
  <p align="center"><font face="Arial"><small><img src="$rpictureurl"><br>
  </small></font></p>
</blockquote>
<div align="center"><center>




</body>
</html>




ENDCONFIRM
print @footer;
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
