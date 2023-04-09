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
use MIME::Base64 ();
require HTTP::Request; 
require LWP::UserAgent;

$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");

open(P, "$options_db") || print "Cant open $options_db REASON ($!)";
$poi = <P>;
close(P);
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10,$pont11,$pont12,$pont13,$pont14)=split(/::/, $poi);

open(Q, "$tgpoptions_db") || print "Cant open $tgpoptions_db REASON ($!)";
$tgpb = <Q>;
close(Q);
($tgp1,$tgp2,$tgp3,$tgp4,$tgp5)=split(/::/, $tgpb);

open(R, "$apstats") || print "Cant open $apstats REASON ($!)";
$ap = <R>;
close(R);
($aps1,$aps2)=split(/::/, $ap);


if ($aps2 eq "YES"){
$isnow=time;
&gloc;
my $agent = LWP::UserAgent->new; 
 
$agent->timeout(30); 
my $req = HTTP::Request->new(GET => "$pre$auth$location");
my $req2 = HTTP::Request->new(GET => "$pre$auth$location$fin");
$jc=$agent->request($req)->as_string;
if($jc =~ /Authorization Required/g) {
print "TGPBase access denied!\n";    
open(MAIL,"|$mailprog") || &error("Could not open Sendmail ($!)");
print MAIL "To: $adminemail\n";
print MAIL "From: $adminemail\n";
print MAIL "Subject: $sitename ERROR getting TGPBase Galleries \n\n";
print MAIL "Automated email from your TGPDevil installation: An error was reported when fetching TGPBase galleries. Username/Password was declined. Contact support if you feel this is an error.\n";
close (MAIL);
exit;
}

my $result = $agent->request( $req2 ); 
my $xmlin = $result->content; 

if ($tgp4 eq "yes") {
if ($aps1 eq "ON") {
	$apstat = 2;
	} else {
	$apstat = 1;
}
} else {
$apstat = 0;
}

        open(TGPMAIN,">$filesdir/gall") || print "Can't open $filesdir/gall REASON: ($!)\n";
print TGPMAIN "$xmlin\n";
        close(TGPMAIN);      
 
        open(HTML, "$filesdir/gall") || print "Can't open $filesdir/gall\n";
        @html_text = <HTML>;
       close(HTML);
		my($query) = "SELECT idnum,datecode FROM DMtgpgalleries ORDER BY idnum DESC LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@PID = $sth->fetchrow)  {
        $CURPID = $PID[0];
        $dc = $PID[1];
        }

$newpid = $CURPID+1;

    $alice=0;
        foreach $later (@html_text) {
        chomp $later;
        ($gurl,$gcat,$gpics,$gdesc,$gd,$gdc)=split(/\|\|/, $later);
        $alice++;
        if ($alice = 1){        
        my($query) = "SELECT * FROM DMtgpgalleries where webname = 'TGPBASE.COM' AND datecode = '$gdc'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@dcrx = $sth->fetchrow)  {
        $d1 = $dcrx[7];
        }
        $d1 =~ s/<BR>//g;
        $gdc =~ s/<BR>//g;
        $gdc =~ s/\W//g;
        $gdc =~ s/\W//g;
}
}

        if ($gdc = $d1) {
print "Galleries have already been fetched today.\n";
&doup;
exit;
} elsif ($gurl eq "-ERROR-"){
print "Error fetching TGPBase galleries. Error was: $gcat\n";    
open(MAIL,"|$mailprog") || &error("Could not open Sendmail ($!)");
print MAIL "To: $adminemail\n";
print MAIL "From: $adminemail\n";
print MAIL "Subject: $sitename ERROR getting TGPBase Galleries \n\n";
print MAIL "Automated email from your TGPDevil installation: An error was reported when fetching TGPBase galleries. Error message was: $gcat\n";
close (MAIL);
&doup;
exit;
} else {
        my($query) = "SELECT catname FROM DMtgpcategories";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@rows = $sth->fetchrow)  {
        push (@cats, "$rows[0]");
        }
        
       my($query) = "SELECT * FROM DMtgpredirects";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@red = $sth->fetchrow)  {
        push (@cats, "$red[0]");
        }
	
	 open(HTML, "$filesdir/gall") || print "Can't open $filesdir/gall\n";
        @gal = <HTML>;
        close(HTML);
        open(TGPGALS,">$filesdir/fgall") || print "Can't open $filesdir/fgall REASON: ($!)\n";
        	
        	
        foreach $cats (@cats){
        foreach $gal (@gal) {
		chomp $gal;
        ($gurl,$gcat,$gpics,$gdesc,$gd,$gdc)=split(/\|\|/, $gal);
		if ($gcat eq $cats) {
		print TGPGALS "$gal\n";
	}
}
}
close(TGPGALS);

####################
## Handle Inserts ########
####################
	 open(FGAL, "$filesdir/fgall") || print "Can't open $filesdir/fgall\n";
        @fgal = <FGAL>;
        close(FGAL);

        foreach $fgal (@fgal) {
	chomp $fgal;
        ($gurl,$gcat,$gpics,$gdesc,$gd,$gdc)=split(/\|\|/, $fgal);
    if ($gurl =~ /http/i){
      $sql = "INSERT INTO DMtgpgalleries VALUES('TGPBASE.COM','galleries\@tgpbase.com','$gurl','$gcat','$gpics','$gdesc','$gd','$gdc','$apstat',$newpid,'000.000.000.000','00000000','1','$isnow','$tgp5','0','0','0')";
	$dbh->do($sql);
	$newpid++;
	}
}

################################
## Complete Category Redirects ##########
###############################
        
        my($query) = "SELECT * FROM DMtgpredirects";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
        my $qy = "UPDATE DMtgpgalleries SET webcate = '$row[1]' WHERE webcate ='$row[0]'";
$dbh->do($qy);
}
}
&doup;
}

sub gloc {
$pre = MIME::Base64::decode("aHR0cDovLw==");
if ($tgp1 eq "yes") {
$auth="$tgp2\:$tgp3\@";
	$location = MIME::Base64::decode("d3d3LnRncGJhc2UuY29tL2RhdGEvcGFpZC9nYWxsZXJpZXMucGw=");
	} else {
	$location = MIME::Base64::decode("d3d3LnRncGJhc2UuY29tL2RhdGEvZnJlZS9nYWxsZXJpZXMucGw=");
	}
$fin = "?$cgiurl";
}

sub doup {
	    my($query) = "SELECT * FROM DMtgpcategories";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@rowz = $sth->fetchrow)  {
        my($query) = "SELECT * FROM DMtgpgalleries WHERE approval ='2' AND webcate = '$rowz[0]' ORDER BY datecode,idnum LIMIT $rowz[2]";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@ro = $sth->fetchrow)  {
        my $qy = "UPDATE DMtgpgalleries SET approval = '1' WHERE approval ='2' AND webcate = '$ro[3]' AND idnum = '$ro[9]'";
	    $dbh->do($qy) or die "Unable to execute query: ".$sth->errstr;
	    }
}
print "Updated.\n";
}

print "DONE!\n";
exit;


