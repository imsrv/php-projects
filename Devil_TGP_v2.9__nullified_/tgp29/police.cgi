#!/usr/bin/perl -w
###############################################################################
#                                                                             #
# Program Name         : TGPDevil TGP System                                  #
# Program Version      : 2.9                                                  #
# Program Author       : Dot Matrix Web Services                              #
# Home Page            : http://www.tgpdevil.com                              #
# Supplied by          : CyKuH                                                #
# Nullified By         : CyKuH                                                #
#                                                                             #
#                   Copyright (c) WTN Team `2002                              #
###############################################################################
require "config.pl";
use DBI;
use CGI::Carp qw(fatalsToBrowser);

	read (STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs)
	{
    	($Jname, $value) = split(/=/, $pair);
    	$value =~ tr/+/ /;
    	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    	$form{$Jname} = $value;
	}
$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
$reportnum = "$ENV{'QUERY_STRING'}";

if ($form{'send_report'}){ 
&send_report; 
}

print "Content-type: text/html\n\n";
	
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Report this gallery to the administrator</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#B1B1B1\">\n";
print "\n";
print "<form method=\"POST\" action=\"$police_pl\?$ENV{'QUERY_STRING'}\">\n";
print "<div align=\"center\"><center><table border=\"0\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\" bgcolor=\"white\" width=\"400\" height=\"287\">\n";
print "<tr>\n";
print "<td width=\"102%\" bgcolor=\"#FF0000\" height=\"24\"> \n";
print "  <p align=\"center\"><strong><font\n";
print "face=\"Arial\"> <font color=white> <big>REPORT THIS GALLERY</big></font></strong></p>\n";
print "  </font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"17%\" height=\"25\"><strong><font face=\"Arial\" color=\"black\">Report the current gallery.</font></strong>\n";
print "  <p><font face=\"Verdana\">\n";
print "  If the gallery you selected\n";
print "  is inappropriate, cheating or if it is broken, please click the report gallery\n";
print "  button below. If you do not wish to report the gallery, simply close this\n";
print "  window. </font><input type=\"hidden\" name=\"rec\" value=\"$mail_name\"></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" valign=\"top\" height=\"21\" align=\"center\"><strong><font face=\"Arial\" color=\"#FFFFFF\"></font></strong><input type=\"submit\" value=\"Report Gallery\"\n";
print "name=\"send_report\">\n";
print "<input type=\"submit\" value=\"Close Window\" onClick=\"javascript:window.close();\">\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"101%\" valign=\"top\" height=\"21\"><hr size=\"1\">\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div>\n";
print "</form>\n";
print "</body>\n";
print "</html>\n";






sub send_report {

	my($query) = "SELECT * FROM DMtgpgalleries WHERE idnum = '$reportnum' LIMIT 1";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Could not execute!");
		while(@rowze = $sth->fetchrow)  {
		$linkurl = $rowze[2];
		$ipaddy = $rowze[10];
		}

	my($query) = "SELECT * FROM DMtgppolice WHERE idnum = '$reportnum' LIMIT 1";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Could not execute!");
		while(@rowz = $sth->fetchrow)  {
		$postid = $rowz[0];
		$reports = $rowz[2];
		}

if (!$postid){
		$sql = "INSERT INTO DMtgppolice VALUES('$reportnum','$linkurl','1','$ipaddy')";
$dbh->do($sql);
}

if ($postid){
$reports++;
my $qy = "UPDATE DMtgppolice SET reports = '$reports' WHERE idnum ='$reportnum'";
$dbh->do($qy);
}

print "Content-type: text/html\n\n";
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Thank You </title>\n";
print "</head>\n";
print "\n";
print "<body>\n";
print "<div align=\"center\"><center>\n";
print "\n";
print "<table border=\"0\" width=\"95%\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#5486AB\"><p align=\"center\"><font face=\"Arial\" color=\"#FFFFFF\"><big>Thank\n";
print "You !</big></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\"><ul>\n";
print "<li><font face=\"Arial\">Your message has been sent to the administrator.</font></li>\n";
print "</ul>\n";
print "<ul>\n";
print "<li><strong><font face=\"Arial\">Thank you.</font></strong></li>\n";
print "</ul>\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\"><p align=\"center\"><input type=\"submit\" value=\"Close Window\" onClick=\"javascript:window.close();\">\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div>\n";
print "</body>\n";
print "</html>\n";
exit;


	
}