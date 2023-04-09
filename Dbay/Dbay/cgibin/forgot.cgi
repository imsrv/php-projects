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
open (HDISPLAY, "$htmlheader");
@header=<HDISPLAY>;
open (HDISPLAY, "$htmlfooter");
@footer=<HDISPLAY>;
print "Content-type: text/html\n\n";
    
&form_parse;
$value = $FORM{'value'};
&lookup;

if ($vpassword ne ""){
&dumpdata;
print @header;
print "Your password has been emailed to $vemail";
print @footer;
exit;
}

print @header;
print "No registration exists for $value";
print @footer;
exit;

#####################################################################################################
#  REQUIRE UNIQUE EMAIL TO REGISTER
#####################################################################################################
sub dumpdata{
                           
open (MAIL, "| $mailprogram $vemail");

print MAIL "Reply-to: $adminemail\n";
print MAIL "From: $adminemail\n";
print MAIL "To: $email\n";
print MAIL "Subject: Forget your password?\n\n";

print MAIL "Here is your login information.\n";
print MAIL "Your username is: $vusername\n";
print MAIL "Your password is: $vpassword\n";
print MAIL "========================================================\n";
print MAIL "Software Developed by http://www.superscripts.com\n";
close MAIL;

}
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {
use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

	my($query) = "SELECT * FROM profile where username = '$value' or email = '$value'";
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
}############################################################
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
