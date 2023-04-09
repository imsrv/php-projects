#!/usr/bin/perl
# Program Name         : TGPDevil TGP System                    
# Program Version      : 2.5
# Program Author       : Dot Matrix Web Services                
# Home Page            : http://www.tgpdevil.com                
# Supplied by          : CyKuH                                  
# Nullified By         : CyKuH                                  
require "config.pl";
use DBI;
use CGI::Carp qw(fatalsToBrowser);
print "Content-type: text/html\n\n";

	read (STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs)
	{
    	($Jname, $value) = split(/=/, $pair);
    	$value =~ tr/+/ /;
    	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    	$form{$Jname} = $value;
	}
 $postidnum="$ENV{'QUERY_STRING'}";
## Read in options		
open(P, "$options_db") || print "Cant open $options_db REASON ($!)";
$poi = <P>;
close(P);
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10,$pont11,$pont12,$pont13,$pont14)=split(/::/, $poi);



$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
	my($query) = "SELECT * FROM DMtgpgalleries WHERE uniqueid = '$postidnum' and approval = '0' and vermail = '0'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Could not execute!");
	while(@info = $sth->fetchrow)  {
	$galurl=$info[2];
$galname=$info[0];
$galdate=$info[6];
$galip=$info[10];
$galcate=$info[3];
$galid=$info[11];
$galmail=$info[1];
	}
	if ($galname eq ""){
	open(HTML, "$header_txt") || print "Can't open $header_txt\n";
	@html_text = <HTML>;
	close(HTML);
	foreach $later (@html_text) {
	chomp $later;
	print "$later\n";
}
		
print "<p align=\"center\"><font face=\"Verdana\" size=\"4\"><b><font color=\"#FF0000\">OOPS!</font></b></font></p>\n";
print "<p align=\"center\"><b><font face=\"Verdana\" color=\"#000000\">The post you have attempted to confirm \n";
print "either does not exist or has already been confirmed</font></b></p>\n";
exit;

		
		}
	open(HTML, "$postverified") || print "Can't open $postverified\n";
	@html_text = <HTML>;
	close(HTML);
	foreach $later (@html_text) {
	chomp $later;
	print  "$later\n";
}
	my $qy = "UPDATE DMtgpgalleries SET vermail = '1' where uniqueid = '$postidnum'";
 	$dbh->do($qy);
	if ($pont6 eq "yes"){
	&submail;
	}
 	exit;

sub submail{
	open(MAIL,"|$mailprog") || &error("Could not open Sendmail ($!)");
print MAIL "To: $galmail\n";
print MAIL "From: $adminemail\n";
print MAIL "Subject: Your post to $sitename... \n\n";
	open(LINE, "$submail") || print "Can't open $submail\n";
	@linetemp = <LINE>;
	close(LINE);
foreach $laters (@linetemp){
	chomp $laters;
	$laters =~ s/#GALLERYURL#/$galurl/g;
	$laters =~ s/#NAME#/$galname/g;
	$laters =~ s/#DATE#/$galdate/g;
	$laters =~ s/#IP#/$galip/g;
	$laters =~ s/#CATEGORY#/$galcate/g;
	$laters =~ s/#UNIQUEID#/$galid/g;
	print MAIL "$laters\n";
	}
close (MAIL);
}
