#!/usr/bin/perl

use Configz;
use Locking;

	$setfound=0;
	open(USR, "$scriptdir/dbase/users.txt");
	chomp(@usr=<USR>);
	close(USR);
	foreach $vsr (@usr) {
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $vsr);
		$today=(localtime)[3];
		if ((localtime)[4] =~ /^(3|5|8|10)$/) {$month = '30';}
		elsif ((localtime)[4] =~ /^1$/){$month = '29';}else {$month = '31';}
		$billday=($dayjoined + $autobill_time) - $month;
		if($today == $billday) {
			$newline="$iname|$iemail|$ilogin|$ipass|0|$dayjoined";
			push(@new, $newline);
			$setfound="1";
		} else {
			$vsr =~ s/\n//gi;
			push(@new, $vsr);
		}			
	}
	if($setfound eq "1") {
		open(OUT, ">$scriptdir/dbase/users.txt");
		&LockDB(OUT);
		foreach $line (new) {
			print OUT "$line\n";	
		}
		&UnlockDB(OUT);
		close(OUT);
	}
