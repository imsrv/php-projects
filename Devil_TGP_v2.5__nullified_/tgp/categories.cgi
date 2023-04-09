#!/usr/bin/perl
# Program Name         : TGPDevil TGP System                    
# Program Version      : 2.5
# Program Author       : Dot Matrix Web Services                
# Home Page            : http://www.tgpdevil.com                
# Supplied by          : CyKuH                                  
# Nullified By         : CyKuH                                  
require "config.pl";
use DBI;
print "Content-type: text/html\n\n";


	$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");


	my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Could not execute!");
	while(@row = $sth->fetchrow)  {	
	print "<option value=\"$row[0]\">$row[0]</option>\n";
	}
	exit;