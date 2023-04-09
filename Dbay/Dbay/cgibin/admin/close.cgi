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
require "/full/path/to/cgi-bin/dbay/admin/configure.cgi";
&configure;

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

&determinehour;
&getitemdata;

$dbh->disconnect;
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
######################################################################
# NOTIFY HI BIDDER
######################################################################
sub notifybidder	{

if ($rcurrenthibidemail eq ""){
$rcurrenthibidemail  = $vemail;
}

open (MAIL, "| $mailprogram $rcurrenthibidemail");
print MAIL "Reply-to: $vemail\n";
print MAIL "From: $vemail\n";
print MAIL "To: $rcurrenthibidemail\n";

print MAIL "Subject: YOU WON THE AUCTION!\n\n";

print MAIL "Congratulations!  You won the auction!\n";
print MAIL "$getcloseditemcgi?$ritemnumber\n\n";

print MAIL "TITLE:  $rtitle\n";
print MAIL "CATEGORY:  $rcategory\n";
print MAIL "DESCRIPTION:  $rdescription\n";
print MAIL "FINALBID:  $rcurrenthibid\n";

print MAIL "Please see the item description url for more information.\n";
print MAIL "Best Regards\n";
print MAIL "Staff\n\n\n";

print MAIL "CGI developed by http://www.superscripts.com/\n";
close MAIL;

}
######################################################################
# NOTIFY SELLER
######################################################################
sub notifyseller	{

open (MAIL, "| $mailprogram $vemail");
print MAIL "Reply-to: $rcurrenthibidemail\n";
print MAIL "From: $rcurrenthibidemail\n";
print MAIL "To: $vemail\n";

print MAIL "Subject: I WON THE AUCTION!\n\n";

print MAIL "Hi!  I won the auction!\n";
print MAIL "$getcloseditemcgi?$ritemnumber\n\n";

print MAIL "TITLE:  $rtitle\n";
print MAIL "CATEGORY:  $rcategory\n";
print MAIL "DESCRIPTION:  $rdescription\n";
print MAIL "FINALBID:  $rcurrenthibid\n";

print MAIL "Please see the item description url for more information.\n";
print MAIL "Best Regards\n";
print MAIL "Staff\n\n\n";

print MAIL "CGI developed by http://www.superscripts.com/\n";
close MAIL;

}
######################################################################
# NOTIFY SELLER
######################################################################
sub nobidders	{

if ($rcurrenthibidemail eq ""){
$rcurrenthibidemail  = $vemail;
}

open (MAIL, "| $mailprogram $vemail");
print MAIL "Reply-to: $rcurrenthibidemail\n";
print MAIL "From: $rcurrenthibidemail\n";
print MAIL "To: $vemail\n";

print MAIL "Subject: AUCTION CLOSED!\n\n";

print MAIL "The following auction is closed!\n";
print MAIL "$getcloseditemcgi?$ritemnumber\n\n";

print MAIL "TITLE:  $rtitle\n";
print MAIL "CATEGORY:  $rcategory\n";
print MAIL "DESCRIPTION:  $rdescription\n";
print MAIL "FINALBID:  $rcurrenthibid\n";
print MAIL "RESERVE:  $rreserve\n";
print MAIL "HI BIDDER:  $rcurrenthibidder\n";

print MAIL "Either there were no bidders or your reserve was not met.\n";
print MAIL "Please see the item description url for more information.\n";
print MAIL "Best Regards\n";
print MAIL "Staff\n\n\n";

print MAIL "CGI developed by http://www.superscripts.com/\n";
close MAIL;

}
############################################################
#  GET ITEM DATA FROM DATABASE
############################################################
sub getitemdata  {

	my($query) = "SELECT * FROM items where starttime LIKE '%$finalhour%'";
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
		&wipeout;
	}
	$sth->finish;
}
############################################################
#  FIGURE OUT REMAINING TIME/BID INCREMENTS
############################################################
sub determinehour{

chop($date = &ctime(time));
($weekday,$month,$day,$time,$zone,$year)=split(/ /,$date);

if ($day eq ""){
	$day = $time;
	$time= $zone;
	}

($finalhour,$min,$sec)=split(/\:/,$time);

}
############################################################
#  CLOSE EXPIRED ITEMS
############################################################
sub wipeout  {
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

$dayselapsed = $ttheday- $rstartday;
$daysremaining = $rduration - $dayselapsed;

if ($daysremaining < 1){
	push (@closeditems,$ritemnumber);
	$query = "INSERT INTO closeditems values('$ritemnumber','$rtitle','$rcategory','$rdescription','$rreserve','$rgetnoticed','$rpictureurl','$rusername','$rpassword','$rstartprice','$rduration','$rbuyerpaymentmethod','$rshipinternationally','$rwhopaysshipping','$rpaymentmethodbyseller','$rcardnumber','$rexpirationdate','$rtheday','$rtime','$rcurrenthibid','$rcurrenthibidder','$rcurrenthibidemail','$rmaxbid','$rfinalbid','$ritemstatus')";
	$dbh->do($query);
	my($query) = "DELETE from items where itemnumber = '$ritemnumber'";
	$dbh->do($query);
	print "$ritemnumber is closed\n";
	&lookup;
	print "$rcurrenthibid:$rreserve\n";
	if ($rcurrenthibidder ne ""){
		if ($rcurrenthibid > $rreserve){
			&notifybidder;
			&notifyseller;
			}
		}
		&nobidders;
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
