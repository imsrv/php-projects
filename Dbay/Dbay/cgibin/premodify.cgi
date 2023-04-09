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
####################################################################################################
print "Content-type: text/html\n\n";

&form_parse;
	$username = $FORM{'username'};
	$password = $FORM{'password'};
&lookup;

if ($username ne $vusername){
print "INVALID LOGIN";
exit;
}
if ($password ne $vpassword ){
print "INVALID LOGIN";
exit;
}
&formout;

############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {
use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");

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
############################################################
#  OUTPUT FORM
############################################################
sub formout  {

print @header;

print <<FORM;

<p><small><font face="Arial">&nbsp;</font></small></p>

<p align="center"><big><strong><font face="Arial">MODIFY REGISTRATION FORM</font></strong></big></p>
<div align="center"><center>
<form action="$modifycgi" method="post">
<table border="0" width="51%" height="223" cellpadding="0">
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Email</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="email" size="40" maxlength="63" value="$vemail"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="17" bgcolor="#99CCCC"><small><font face="Arial">Name</font></small></td>
    <td width="50%" height="17" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="name" size="40" maxlength="63" value="$vname"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Address</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="address" size="40" maxlength="63" value="$vaddress"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">City</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="city" size="40" maxlength="63" value="$vcity"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">State/Region</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="state" size="40" maxlength="63" value="$vstate"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Postal Code</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="zip" size="40" maxlength="63" value="$vzip"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Country</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="country" size="40" maxlength="63" value="$vcountry"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Phone Number</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input type="text"
    name="phone" size="40" maxlength="63" value="$vphone"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Username</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small> <font face="Arial">$vusername <input type="hidden"
    name="username" size="12" maxlength="63" value="$vusername"></font></small></td>
  </tr>
  <tr>
    <td width="58%" height="19" bgcolor="#99CCCC"><small><font face="Arial">Password</font></small></td>
    <td width="50%" height="19" bgcolor="#99CCCC"><small><font face="Arial"><input
    type="password" name="password" size="12" maxlength="63" value="$vpassword"></font></small></td>
  </tr>
</table>
</center></div>

<p align="center"><input type="submit" value="MODIFY INFORMATION"></p></form>


</body>
</html>


FORM

print @footer;
}