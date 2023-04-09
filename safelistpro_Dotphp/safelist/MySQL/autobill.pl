#!/usr/bin/perl

use Configs;
use Locking;
use DBI;

	$setfound=0;
 $dbh=DBI->connect("DBI:mysql:database=$dbname;hostname=$dbhost", $dbuser, $dbpass, {RaiseError=>1}) or sqldie("$DBI::errstr");
  $sth=$dbh->prepare("SELECT * from users");
$sth->execute;

  $res=$sth->fetchrow_hashref;
  while($res->{'ID'} ne undef) {
  $iname = $res->{'Iname'}; 
  $iemail = $res->{'Iemail'};
  $ilogin = $res->{'Ilogin'};
  $ipass = $res->{'Ipass'};
  $status = $res->{'Status'};
  $dayjoined = $res->{'Dayjoined'};

		$today=(localtime)[3];
                $mnth = (localtime)[4];
		if ($mnth =~ /^(3|5|8|10)$/) {$month = '30';}
		elsif ($mnth =~ /^1$/){$month = '29';}else {$month = '31';}
                $jar = ($dayjoined + $autobill_time);
                if ($jar <= $month) {$billday = $jar;}else {
		$billday=($dayjoined + $autobill_time) - $month;}
		if($today == $billday) {

	 $sth2=$dbh->prepare("UPDATE users SET Status=\"0\" WHERE Ilogin=\"$ilogin\"");
	 $sth2->execute;  

		}
  	$res=$sth->fetchrow_hashref;		
	}
                        
sub sqldie {
  $error = $_[0];
  print "Content-type: text/html\n\n";
  print qq~ ERROR: $error
  ~;
  exit;
}

1;
