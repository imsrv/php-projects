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
	$username = $FORM{'username'};
	$password = $FORM{'password'};
	$itemnumber = $FORM{'itemnumber'};
	$bid = $FORM{'bid'};

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

&lookupbidderdata;
&getitemdata;

print @header;
&biddingwar;

$dbh->disconnect;
############################################################
#  BIDDINGWAR
############################################################
sub biddingwar{

if ($rmaxbid > $bid){
	$newcurrenthibid = $bid + 2;
	print "Your have been outbid.  Current bid is $newcurrenthibid";
	$query = "UPDATE items SET currenthibid = '$newcurrenthibid' where itemnumber = '$itemnumber'";
	$dbh->do($query);
	print @footer;
	exit;
}
if ($bid < $rcurrenthibid){
	print "This is not enough.  You must bid equal or more than $rcurrenthibid";
	print @footer;
	exit;
}
if ($bid < $rstartprice){
	print "This is not enough.  You must bid equal or more than $rstartprice";
	print @footer;
	exit;
}

if ($bid > $rmaxbid){
	$newcurrenthibid = $rmaxbid + $increment;
	if ($rstartprice > $newcurrenthibid){
		$newcurrenthibid = $rstartprice;
		}
	$newcurrenthibidder = $username;
	$newcurrenthibidemail = $vemail;
	$newmaxbid = $bid;
	$query = "UPDATE items SET currenthibid = '$newcurrenthibid' where itemnumber = '$itemnumber'";
	$dbh->do($query);
	$query = "UPDATE items SET currenthibidder = '$newcurrenthibidder' where itemnumber = '$itemnumber'";
	$dbh->do($query);
	$query = "UPDATE items SET currenthibidemail = '$newcurrenthibidemail' where itemnumber = '$itemnumber'";
	$dbh->do($query);
	$query = "UPDATE items SET maxbid = '$newmaxbid' where itemnumber = '$itemnumber'";
	$dbh->do($query);
	print "Your maximum bid has been placed for $bid.  Current price is $newcurrenthibid";
	print @footer;
	exit;
}

}
############################################################
#  GET ITEM DATA FROM DATABASE
############################################################
sub getitemdata  {

	my($query) = "SELECT * FROM items where itemnumber = '$itemnumber'";
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
sub lookupbidderdata{

	my($query) = "SELECT * FROM profile where username = '$username'";
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

	if (!$vusername){
	print "Not a valid username";
	exit;
	}
	if ($password ne $vpassword){
	print "Invalid Password";
	exit;
	}
}
############################################################
#  SAVE ITEM DATA
############################################################
sub savedata{
	$query = "INSERT INTO items values('$itemnumber','$title','$category','$description','$reserve','$getnoticed','$pictureurl','$username','$password','$startprice','$duration','$buyerpaymentmethod','$shipinternationally','$whopaysshipping','$paymentmethodbyseller','$cardnumber','$expirationdate','$theday','$time','$currenthibid','$currenthibidder','$currenthibidemail','$maxbid','$finalbid','$itemstatus')";
	$dbh->do($query);
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
