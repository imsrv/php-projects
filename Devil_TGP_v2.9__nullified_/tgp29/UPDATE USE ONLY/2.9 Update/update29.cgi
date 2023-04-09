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
print "Content-type: text/html\n\n";


print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>MySQL Database Setup</title>\n";
print "</head>\n";
print "\n";
print "<body>\n";
print "\n";
print "<p align=\"center\"><font face=\"Verdana\"><b>Please wait, setup is attempting to\n";
print "update MySQL database.</b></font></p>\n";
print "\n";
print "<p align=\"center\"><font face=\"Verdana\"><b>If you don't see a green box below\n";
print "within a few seconds, verify that you have set your MySQL username, password and\n";
print "DB name correctly in config.pl!</b></font></p>\n";


$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");

my($query) = "ALTER TABLE DMtgpcategories
ADD autopost int(3) NOT NULL default '1'
;";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

my($query) = "ALTER TABLE DMtgpgalleries 
ADD thumb char(1) DEFAULT '0' NOT NULL 
;";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

print "<div align=\"center\">\n";
print "  <center>\n";
print "  <table border=\"0\" cellspacing=\"0\" width=\"65%\" cellpadding=\"0\" bgcolor=\"#00FF00\">\n";
print "    <tr>\n";
print "      <td width=\"100%\">\n";
print "        <p align=\"center\"><font face=\"Verdana\"><b>DONE!</b></font></p>\n";
print "        <p align=\"center\"><b><i><font face=\"Verdana\" size=\"4\">You will not need\n";
print "        update.cgi again!</font></i></b><font face=\"Verdana\"><b><br>\n";
print "        Make sure to either reset permissions on it so it may not be executed\n";
print "        again or delete it from your server!</b></font></td>\n";
print "    </tr>\n";
print "  </table>\n";
print "  </center>\n";
print "</div>\n";

print "</body>\n";
print "\n";
print "</html>\n";