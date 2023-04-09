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
use DBI;
use CGI::Carp qw(fatalsToBrowser);
use LWP::UserAgent;
$ua = new LWP::UserAgent;

require "config.pl";
open(B, "$botoptions_db") || print "Cant open $botoptions_db REASON ($!)"; 
$poin = <B>;
close(B); 
($pon1,$pon2,$pon3)=split(/::/, $poin);
$isnow=time;
$starttime = $pon1 * 86400;
$stoptime = $pon2 * 86400;

$older= $isnow - $starttime;
$newer= $isnow - $stoptime;

print "TGPDevil Gallery Bot Starting\n\n\n\n";

$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
	my($query) = "SELECT weburl, idnum, fsize FROM DMtgpgalleries WHERE approval = '1' AND vermail = '1' AND stamp <= '$older' AND stamp >= '$newer'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Could not execute!");
	while(@row = $sth->fetchrow_array)  {
	$whereto = "$row[0]";
	$idnum = "$row[1]";
	$fsize = "$row[2]";
	&letsgo;
	}
	exit;
	
	sub letsgo {
	
$ua->agent ('Mozilla/4.0 (compatible; MSIE 5.03; Windows 95)');
$ua->timeout (30); 

my $request = new HTTP::Request "GET", $whereto;
$request->referer($whereto);
my $response = $ua->request ($request);
$con = $response->content; 
$leng = length ($con); 

  if ($response->is_success) {
if ($fsize eq "0"){
$news = UNKNOWN;
} else {
$news = "$fsize bytes";
}
     print "Gallery not 404 - $whereto - Original size $news is now $leng bytes.\n";
       if ($fsize > 400){
  if ($fsize != "0"){
  if ($leng != $fsize) {
       print "GALLERY CHANGED - $whereto<BR>\n";
	if ($pon3 eq "queue"){
		$sql = "INSERT INTO DMtgpdead VALUES('$whereto','$idnum')";
		$dbh->do($sql);
  }
  if ($pon3 eq "delete"){
  my $qy = "DELETE FROM DMtgpgalleries WHERE idnum ='$idnum'";
  $dbh->do($qy);
}
}
}
}

  } else {
    print "\*BAD\* - $whereto<BR>\n";
	if ($pon3 eq "queue"){
		$sql = "INSERT INTO DMtgpdead VALUES('$whereto','$idnum')";
		$dbh->do($sql);
  }
  if ($pon3 eq "delete"){
  my $qy = "DELETE FROM DMtgpgalleries WHERE idnum ='$idnum'";
  $dbh->do($qy);
}

  }

  	

}

exit;





