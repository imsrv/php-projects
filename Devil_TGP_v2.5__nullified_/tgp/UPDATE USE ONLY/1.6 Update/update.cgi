#!/usr/bin/perl
require "config.pl";
use DBI;
use CGI::Carp qw(fatalsToBrowser);
print "Content-type: text/html\n\n";


print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">\n";
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
print "DB name correctly in config.pl!<!--CyKuH--></b></font></p>\n";


$dbh = DBI->connect("dbi:mysql:$database:$dbhost:dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
my($query) = "CREATE TABLE DMtgpdeclines (
  decname varchar(35) NOT NULL default '',
  decvalue text NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;


my($query) = "INSERT INTO DMtgpdeclines VALUES ('Broken Recip', 'We require a working recip. link. Yours does not seem to be working or doesn&#39;t exist.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Sponsor Content', 'Overuse of sponsor content or content that we receive often.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Broken Pics', 'Some of your pics/videos seemed to be broken.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Popups', 'Popups on your page. We do not list ANY galleries with popups.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Too many ads.', 'Too many advertisements.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;my($query) = "INSERT INTO DMtgpdeclines VALUES ('Poor quality', 'Either your gallery design or the content was of very poor quality.');";
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Unspecified', 'No specific reason given.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('404', 'Your page returned a 404 (Page not found) error.');";
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