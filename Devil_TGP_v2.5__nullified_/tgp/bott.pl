#!/usr/bin/perl
# Program Name         : TGPDevil TGP System                    
# Program Version      : 2.5
# Program Author       : Dot Matrix Web Services                
# Home Page            : http://www.tgpdevil.com                
# Supplied by          : CyKuH                                  
# Nullified By         : CyKuH                                  
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
print "Content-type: text/html\n\n";
print "Time is now $isnow\n";
print "Starting is $older\n";
print "Stopping is $newer\n";
$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
	my($query) = "SELECT weburl, idnum FROM DMtgpgalleries WHERE approval = '1' AND vermail = '1' AND stamp <= '$older' AND stamp >= '$newer'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Could not execute!");
	while(@row = $sth->fetchrow_array)  {
	$whereto = "$row[0]";
	$idnum = "$row[1]";
	&letsgo;
	}
	exit;
	sub letsgo {
	
   $ua->agent("CyKuH TGP SPIDER");
   $ua->timeout(10);
     $req = new HTTP::Request HEAD => $whereto;
  $req->header('Accept' => 'text/html');

  # send request
    $res = $ua->request($req);



  if ($res->is_success) {
     print "Good - $whereto\n";

  } else {
    print "\*BAD\* - $whereto\n";
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





