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
	$email = $FORM{'email'};
	$name = $FORM{'name'};
	$address = $FORM{'address'};
	$city = $FORM{'city'};
	$state = $FORM{'state'};
	$zip = $FORM{'zip'};
	$country = $FORM{'country'};
	$phone = $FORM{'phone'};
	$username = $FORM{'username'};
	$password = $FORM{'password'};

&lookup;

if ($vusername){
print "This username is unavailable.  Please choose another";
exit;
}

&savedata;
&emailnotice;

&confirmationpage;
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {
use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

	my($query) = "SELECT * FROM profile where username = '$username' or email = '$email'";
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
#  SAVE REGISTRATION
############################################################
sub savedata{
	use DBI;
	$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");
	$query = "INSERT INTO profile values('$email','$name','$address','$city','$state','$country','$zip','$phone','$username','$password')";
	$dbh->do($query);
	$dbh->disconnect;
}
######################################################################
# EMAIL REGISTRATION INFO
######################################################################
sub emailnotice	{

open (MAIL, "| $mailprogram $email");
print MAIL "Reply-to: $adminemail\n";
print MAIL "From: $adminemail\n";
print MAIL "To: $email\n";

print MAIL "Subject: Welcome to DBAY!\n\n";

print MAIL "Your DBay Account is now setup. Below is \n";
print MAIL "all your account information.\n\n";

print MAIL "$email\n";
print MAIL "$name\n";
print MAIL "$address\n";
print MAIL "$city, $state  $zip\n";
print MAIL "$country\n";
print MAIL "$phone\n";
print MAIL "$username\n";
print MAIL "$password\n\n";

print MAIL "We look forward to a long and prosperous business relationship. \n";
print MAIL "If you have any questions please feel free to contact our office at anytime.\n\n";
print MAIL "Best Regards\n";
print MAIL "Staff\n\n\n";



print MAIL "CGI developed by http://www.superscripts.com/\n";
close MAIL;

}
############################################################
#  SUBROUTINES
############################################################
sub confirmationpage{

print @header;
print <<ENDCONFIRM;


<table border="1" cellspacing="0" width="100%" bgcolor="#99CCCC">
  <tr>
    <td align="center" width="100%"><font color="#000000" face="Arial" size="3"><b>Welcome
    $username!</b></font></td>
  </tr>
  <tr>
    <td align="center" width="100%">&nbsp;</td>
  </tr>
</table>
</center></div>

<p align="center"><small><font face="Arial">Your account information is below.&nbsp; Save
this in a safe place.&nbsp; A copy of your registration information has also been emailed
to $email</font></small></p>
<div align="center"><center>

<table border="0" width="100%" cellpadding="0">
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Username</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$username</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Password</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$password</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Name</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$name</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Address</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><small><font face="Arial" color="#000000">$address</font></small></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>City</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$city</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>State</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$state</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Zipcode</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$zip</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Country</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$country</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Phone</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$phone</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Country</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$country</small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><strong><small>Email</small></strong></font></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small>$email</small></font></td>
  </tr>
</table>
</center></div><div align="center"><center>

<table border="1" cellspacing="0" width="100%" bgcolor="#99CCCC">
  <tr>
    <td align="center" width="100%"><font color="#000000" face="Arial" size="3"><a name="DESC"><b>Enjoy!</b></a></font></td>
  </tr>
</table>
</center></div>


<p>&nbsp;</p>
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


