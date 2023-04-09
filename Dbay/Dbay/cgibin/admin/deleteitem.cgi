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
require "configure.cgi";
&configure;

print "Content-type: text/html\n\n";

&form_parse;
$item = $FORM{'item'};

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

&lookup;
if (!$ritemnumber){
print "This item does not exist";
exit;
}

&deleteitem;
print "$username has been removed from system";

############################################################
#  DELETE USER
############################################################
sub deleteitem  {
	my($query) = "DELETE from items where itemnumber = '$item'";
	$dbh->do($query);
}
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {
	my($query) = "SELECT * FROM items where itemnumber = '$item'";
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
#  FORM PARSING
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