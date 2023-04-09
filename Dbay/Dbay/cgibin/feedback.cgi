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


&form_parse;
	$losername=$ENV{'QUERY_STRING'};
&lookup;

if ($vusername eq ""){
print "no feedback profile exists for $losername";
exit;
}
&printheader;
&dumpdata;
&printfooter;
print @footer;
############################################################
#  PRINT HEADER
############################################################
sub printheader{
print @header;
print <<ENDHEADER;

<p align="center"><font face="Arial" color="#FF0000"><strong>Feedback Profile for
$losername</strong></font></p>
<div align="center"><center>

<table border="5" width="53%" cellpadding="0">
  <tr>
    <td width="50%"><small><font face="Arial">Positive</font></small></td>
    <td width="50%"><small><font face="Arial">$countpos</font></small></td>
  </tr>
  <tr>
    <td width="50%"><small><font face="Arial">Neutral</font></small></td>
    <td width="50%"><small><font face="Arial">$countneu</font></small></td>
  </tr>
  <tr>
    <td width="50%"><small><font face="Arial">Negative</font></small></td>
    <td width="50%"><small><font face="Arial">-$countneg</font></small></td>
  </tr>
  <tr>
    <td width="50%"><small><font face="Arial">Total</font></small></td>
    <td width="50%"><small><font face="Arial">$countresults</font></small></td>
  </tr>
</table>
</center></div>

<p><strong><font face="Arial">Comments</font></strong></p>
<table border="1" width="100%">

ENDHEADER

}
############################################################
#  PRINT FOOTER
############################################################
sub printfooter{

print <<ENDFOOTER;

</table>
</body>
</html>

ENDFOOTER

}
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {

	my($query) = "SELECT * FROM feedback where losername = '$losername'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$vusername = $row[0];
		$vlosername = $row[1];
		$vcomments = $row[2];
		$vrating = $row[3];
		$vdate = $row[4];
		$vitemnumber = $row[5];
		&makestats;

	}
	$sth->finish;

}
############################################################
#  MAKE FEEDBACK STATS
############################################################
sub makestats{

if ($vrating eq "p"){
$countpos++;
$countresults++;
}
if ($vrating eq "n"){
$countneg++;
$countresults--;
}
if ($vrating eq "e"){
$countneu++;
}
$incident = "$vusername|$vlosername|$vcomments|$vrating|$vdate|$vitemnumber";
push (@data,$incident);

}
############################################################
#  PRINT FEEDBACK
############################################################
sub dumpdata{

	foreach $data(@data){
		chomp $data;
		($dusername,$dlosername,$dcomments,$drating,$ddate,$ditemnumber) = split(/\|/,$data);
			if ($drating eq "n"){
				$drating = "negative";
				}
			if ($drating eq "e"){
				$drating = "neutral";
				}
			if ($drating eq "p"){
				$drating = "positive";
				}
print <<ENDSTATS;
  <tr>
    <td width="50%" bgcolor="#99CCCC"><small><font face="Arial">User: $dusername left on $ddate</font></small></td>
    <td width="50%" bgcolor="#99CCCC"><small><font face="Arial">ITEM:&nbsp; $ditemnumber</font></small></td>
  </tr>
  <tr>
    <td width="100%" colspan="2"><small><font face="Arial">$drating:&nbsp; $dcomments</font></small></td>
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
	$value =~ s/\'//g;
    	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    	$FORM{$name} = $value;
	}}



