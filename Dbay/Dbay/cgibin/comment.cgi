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
	$username=$FORM{'username'};
	$password=$FORM{'password'};	
	$rankingusername=$FORM{'rankingusername'};
	$itemnumber=$FORM{'itemnumber'};
	$rating=$FORM{'rating'};
	$comments=$FORM{'comments'};

use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");
&lookupmyself;

if ($password ne $mypassword){
	print "Invalid Password";
	exit;
	}
&lookuploser;
if ($lusername = ""){
	print "This user does not exist";
	exit;
	}

&savefeedback;
print @header;
print "Feedback has been left for $rankingusername by $username";
print @footer;
############################################################
#  LOOKUP COMMENTERS ACCOUNT INFO
############################################################
sub savefeedback{
	$query = "INSERT INTO feedback values('$username','$rankingusername','$comments','$rating','$date','$itemnumber')";
	$dbh->do($query);
}
############################################################
#  LOOKUP COMMENTERS ACCOUNT INFO
############################################################
sub lookupmyself  {

	my($query) = "SELECT * FROM profile where username = '$username'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$myemail = $row[0];
		$myname = $row[1];
		$myaddress = $row[2];
		$mycity = $row[3];
		$mystate = $row[4];
		$mycountry = $row[5];
		$myzip = $row[6];
		$myphone = $row[7];
		$myusername = $row[8];
		$mypassword = $row[9];
	}
	$sth->finish;
}
############################################################
#  LOOKUP THE OTHER GUY
############################################################
sub lookuploser  {

	my($query) = "SELECT * FROM profile where username = '$rankingusername'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$lemail = $row[0];
		$lname = $row[1];
		$laddress = $row[2];
		$lcity = $row[3];
		$lstate = $row[4];
		$lcountry = $row[5];
		$lzip = $row[6];
		$lphone = $row[7];
		$lusername = $row[8];
		$lpassword = $row[9];
	}
	$sth->finish;
}
############################################################
#  PRINT HEADER
############################################################
sub printheader{

print <<ENDHEADER;

<html>

<head>
<title>Feedback Profile for $username</title>
</head>

<body>

<p align="center"><font face="Arial" color="#FF0000"><strong>Feedback Profile for
$losername</strong></font></p>
<div align="center"><center>

<table border="5" width="53%" cellpadding="0">
  <tr>
    <td width="50%"><small><font face="Arial">Positive</font></small></td>
    <td width="50%"><small><font face="Arial">$positive</font></small></td>
  </tr>
  <tr>
    <td width="50%"><small><font face="Arial">Neutral</font></small></td>
    <td width="50%"><small><font face="Arial">$neutral</font></small></td>
  </tr>
  <tr>
    <td width="50%"><small><font face="Arial">Negative</font></small></td>
    <td width="50%"><small><font face="Arial">$negative</font></small></td>
  </tr>
  <tr>
    <td width="50%"><small><font face="Arial">Total</font></small></td>
    <td width="50%"><small><font face="Arial">$total</font></small></td>
  </tr>
</table>
</center></div>

<p><strong><small><font face="Arial">Comments</font></small></strong></p>

<table border="1" width="100%">

ENDHEADER

}
############################################################
#  PRINT FOOTER
############################################################
sub printfooter{

print <<ENDFOOTER;

</table>

<p>&nbsp;</p>
</body>
</html>

ENDFOOTER

}
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {

	my($query) = "SELECT * FROM feedback where username = '$losername'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$username = $row[0];
		$losername = $row[1];
		$comments = $row[2];
		$rating = $row[3];
		$date = $row[4];
		$itemnumber = $row[5];
		$countresults++;
		&makestats;
	}
	$sth->finish;
}
############################################################
#  MAKE FEEDBACK STATS
############################################################
sub makestats{

if ($rating eq "positive"){
$countpos++;
}
if ($rating eq "negative"){
$countneg++;
}
if ($rating eq "neutral"){
$countneu++;
}
$incident = "$username|$losername|$comments|$rating|$date|$itemnumber";
push (@data,$incident );

}
############################################################
#  PRINT FEEDBACK
############################################################
sub dumpdata{

	foreach $data(@data){
		chomp $data;
		($username,$losername,$comments,$rating,$date,$itemnumber) = split(/\|/, $data);

print <<ENDSTATS;
  <tr>
    <td width="50%" bgcolor="#9BFFFF"><small><font face="Arial">User: $username left on $date</font></small></td>
    <td width="50%" bgcolor="#9BFFFF"><small><font face="Arial">ITEM:&nbsp; $itemnumber</font></small></td>
  </tr>
  <tr>
    <td width="100%" colspan="2"><small><font face="Arial">$rating:&nbsp; $comments</font></small></td>
  </tr>
ENDSTATS

		}
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



