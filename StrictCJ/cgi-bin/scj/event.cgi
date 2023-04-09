#!/usr/bin/perl
#################################
#    Variables you must set     #
#################################

# Your Database TABLE Names... refer to variables.inc.php if you don'T remember
my $tableusers = "strictCJ_USERS";
my $tablehour = "strictCJ_HOUR";
my $tableday = "strictCJ_DAY";

# path to ROOT directory (contains index.php, out.php, etc)
# NO TRAILING SLASH!!
my $index_path = "/your/path/to/yourdomain.com/public_html";

# full path to dbsub.cgi
my $dbsub = "/your/path/to/yourdomain.com/cgi-bin/scj/dbsub.cgi";

#################################
#       End of variables        #
#    Do not edit below this     #
#################################
#16
my $outfile = $index_path."/scj/data/outgoing.dat";
require "$dbsub";
my($dbh,$sth,$sql);

# Ok now lets connect to DB
$dbh = DB_Connect();

#beginning
my ($hour,$min) = getDate();
# UPDATE
if ($min % 2 != 0) {
	updateCurrentHour($dbh,$tablehour,$tableday,$min,$hour);
	updateMainTable($dbh,$tableusers,$tableday);
	createOutgoingFile($dbh,$tableusers,$tablehour,$outfile);
	# IF END OF HOUR THEN RESET NEXT HOUR AND UPDATE TOPLIST 
	if ($min == 59) {
	  updateToplist($dbh,$tableusers,$min,$hour);
	  my $rhour;
	  if ($hour == 23) { $rhour = 0; }
	  else { $rhour = $hour + 1 }
	  $sql = "UPDATE $tableday SET UIN$rhour=0,RIN$rhour=0,UOUT$rhour=0,TOUT$rhour=0,GOUT$rhour=0";
	  Do_SQL($dbh,$sql);
	}
	# toplist upate so it updates bi-hourly
	if ($min == 29) {
	  updateToplist($dbh,$tableusers,$min,$hour);
	}
	# RESET NEXT 2 MINS
	$sql = "UPDATE $tablehour SET RIN$min=0,UIN$min=0,UOUT$min=0,TOUT$min=0,GOUT$min=0";
	Do_SQL($dbh,$sql);
	resetNextLog($index_path,$min,$hour);
}

sub resetNextLog {
	my ($index_path,$min,$hour) = @_;
	$inFile = $index_path."/scj/data/logs/incoming-".$hour."-".$min.".dat";
	$inLockFile = $inFile.".lock";
	$outFile = $index_path."/scj/data/logs/incoming-".$hour."-".$min.".dat";
	$outLockFile = $outFile.".lock";
	if (-e$inFile) { open(DELETE,">".$inFile); close(DELETE); }
	if (-e$inLockFile) { open(DELETE,">".$inLockFile); close(DELETE); }
	if (-e$outFile) { open(DELETE,">".$outFile); close(DELETE); }
	if (-e$outLockFile) { open(DELETE,">".$outLockFile); close(DELETE); }
}

sub getDate {
	my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) =localtime(time());
	return ($hour,$min);
}

sub updateCurrentHour {
	my ($dbh,$tablehour,$tableday,$min,$hour) = @_;
	if ($min == 1) { $min = 59; }
	else { $min -= 2; }
	# UPDATE CURRENT HOUR
	my $sql = "SELECT USER,UIN$min,RIN$min,UOUT$min,TOUT$min,GOUT$min FROM $tablehour";
	my $sth = Do_SQL($dbh,$sql) or die "\n\n-- can't execute query --\n\n";
	my ($user,$uin,$rin,$uout,$tout,$gout,$pointer);
	while ($pointer = $sth->fetchrow_hashref) {
	  $user = $pointer->{"USER"};
	  $uin = $pointer->{"UIN$min"};
	  $rin = $pointer->{"RIN$min"};
	  $uout = $pointer->{"UOUT$min"};
	  $tout = $pointer->{"TOUT$min"};
	  $gout = $pointer->{"GOUT$min"};
	  $sql = "UPDATE $tableday SET RIN$hour=RIN$hour + $rin,UIN$hour=UIN$hour + $uin,UOUT$hour=UOUT$hour + $uout,TOUT$hour=TOUT$hour + $tout,GOUT$hour=GOUT$hour + $gout WHERE USER='$user'";
	  Do_SQL($dbh,$sql);
	}
}

sub updateToplist {
	my ($dbh,$tableusers,$min,$hour) = @_;
	if (-e$index_path."/scj/data/toplist.tpl.html") {
		$query = "SELECT * FROM $tableusers WHERE NOUSER!='noref' ORDER BY RAWIN DESC;";
		my ($pointer,$title,$clicks);
		my $count = 1;
		my $sth = Do_SQL($dbh,$query);
		open(TEMPLATE,$index_path."/scj/data/toplist.tpl.html");
		@templateArr=<TEMPLATE>;
		close(TEMPLATE);
		while ($pointer = $sth->fetchrow_hashref) {	
			$clicks = $pointer->{"HITSGEN"} + $pointer->{"GALOUT"};
			if ($pointer->{"TITLE"} eq "") {
				$title = $pointer->{"DOMAIN"}
			} else {
				$title = $pointer->{"TITLE"};
			}
			for ($i=0; $i<@templateArr; $i++) {
				$templateArr[$i] =~ s/\{\%USER$count\%\}/$pointer->{"NOUSER"}/i;	
				$templateArr[$i] =~ s/\{\%TITLE$count\%\}/$title/i;	
				$templateArr[$i] =~ s/\{\%HITSIN$count\%\}/$pointer->{"RAWIN"}/i;				
				$templateArr[$i] =~ s/\{\%CLICKS$count\%\}/$clicks/i;				
				$templateArr[$i] =~ s/\{\%HITSOUT$count\%\}/$pointer->{"HITSOUT"}/i;				
			}
			$count++;
		}
		$time=$hour.":".$min;
		open(TOPLIST,">".$index_path."/toplist.html");
		for ($i=0; $i<@templateArr; $i++) {
			$templateArr[$i] =~ s/\{\%TIME\%\}/$time/i;
			$templateArr[$i] =~ s/\{\%USER.?.?[0-9]\%\}//i;
			$templateArr[$i] =~ s/\{\%TITLE.?.?[0-9]\%\}//i;
			$templateArr[$i] =~ s/\{\%HITSIN.?.?[0-9]\%\}//i;
			$templateArr[$i] =~ s/\{\%CLICKS.?.?[0-9]\%\}//i;
			$templateArr[$i] =~ s/\{\%HITSOUT.?.?[0-9]\%\}//i;
			print TOPLIST $templateArr[$i];
		}
		close(TOPLIST);
	}
}

sub updateMainTable {
	my ($dbh,$tableusers,$tableday) = @_;
	# UPDATE MAIN TABLE
	my $sql = "SELECT USER, (UIN0+UIN1+UIN2+UIN3+UIN4+UIN5+UIN6+UIN7+UIN8+UIN9+UIN10+UIN11+UIN12+UIN13+UIN14+UIN15+UIN16+UIN17+UIN18+UIN19+UIN20+UIN21+UIN22+UIN23) TUIN, (UOUT0+UOUT1+UOUT2+UOUT3+UOUT4+UOUT5+UOUT6+UOUT7+UOUT8+UOUT9+UOUT10+UOUT11+UOUT12+UOUT13+UOUT14+UOUT15+UOUT16+UOUT17+UOUT18+UOUT19+UOUT20+UOUT21+UOUT22+UOUT23) TUOUT, (RIN0+RIN1+RIN2+RIN3+RIN4+RIN5+RIN6+RIN7+RIN8+RIN9+RIN10+RIN11+RIN12+RIN13+RIN14+RIN15+RIN16+RIN17+RIN18+RIN19+RIN20+RIN21+RIN22+RIN23) TRIN, (TOUT0+TOUT1+TOUT2+TOUT3+TOUT4+TOUT5+TOUT6+TOUT7+TOUT8+TOUT9+TOUT10+TOUT11+TOUT12+TOUT13+TOUT14+TOUT15+TOUT16+TOUT17+TOUT18+TOUT19+TOUT20+TOUT21+TOUT22+TOUT23) TTOUT, (GOUT0+GOUT1+GOUT2+GOUT3+GOUT4+GOUT5+GOUT6+GOUT7+GOUT8+GOUT9+GOUT10+GOUT11+GOUT12+GOUT13+GOUT14+GOUT15+GOUT16+GOUT17+GOUT18+GOUT19+GOUT20+GOUT21+GOUT22+GOUT23) TGOUT FROM $tableday";
	my $result = Do_SQL($dbh,$sql) or die "\n\n-- can't execute query --\n\n";
	my ($user,$tuin,$trin,$tuout,$ttout,$tgout,$pointer);
	while ($pointer = $result->fetchrow_hashref){
	  $user = $pointer->{"USER"};
	  $tuin = $pointer->{"TUIN"};
	  $trin = $pointer->{"TRIN"};
	  $tuout = $pointer->{"TUOUT"};
	  $ttout = $pointer->{"TTOUT"};
	  $tgout = $pointer->{"TGOUT"};
	  $sql = "UPDATE $tableusers SET UNIQUEIN=$tuin,RAWIN=$trin,HITSGEN=$ttout,GALOUT=$tgout,HITSOUT=$tuout,PCRETURN=(($tuout/($trin + MIN)) * 100),PCUNIQUE=(($tuin/$trin) * 100),PCPROD=((($ttout + $tgout)/$trin) * 100) WHERE NOUSER='$user'";
	  Do_SQL($dbh,$sql);
	}
}

sub setExp {
	my $col = $_[0];
	my $sql = "(";
	for (my $i=1;$i<=59;$i+=2) {
		if ($i == 59) { $sql .= "h." . $col . $i; }
		else { $sql .= "h." . $col . $i . "+"; }
	}
	$sql .= ")";
	return $sql;
}

sub inArray {
	my ($user,@myarray) = @_;
	my $value;
	foreach $value (@myarray) {
       if ($value eq $user) {
		   return 1;
       }
	}
	return 0;
}

sub createOutgoingFile {
	my ($dbh,$tablename,$thour,$outfile) = @_;
	my ($sql,$arows,$user,$url);
	my $lockfile = $outfile . ".lock";
	my $offset = 0; my $count = 0; 
	my @users;
	unless (-e$lockfile) {
		open(LOCKFILE,">$lockfile");
		close(LOCKFILE);
	}
	open(LOCKFILE,"$lockfile");
	while (!flock(LOCKFILE,2)) {}
	open(DATAFILE,">$outfile");
#	$sql = "SELECT u.NOUSER,u.URL,u.TRADETYPE FROM $tablename u,$thour h WHERE u.PCRETURN < u.RATIO AND u.DOMAIN != 'noref' ORDER BY ".setExp("TOUT")." DESC, u.HITSGEN DESC LIMIT 2";
#	$result = Do_SQL($dbh,$sql);
	my $added = 0;
#	while (($pointer = $result->fetchrow_hashref) && ($added < 2)) {
#		$user = $pointer->{"NOUSER"};
#		$url = $pointer->{"URL"};
#		$tradetype = $pointer->{"TRADETYPE"};
#		print DATAFILE "$user|$url|$tradetype\n";
#		$added++;
#		$users[$count] = $user;
#		$count++;
#   }
#	if ($added < 2) { $offset += 2 - $added; }
	$sql = "SELECT NOUSER,URL,((PCPROD/100) + ((HITSGEN+GALOUT)/HITSOUT) - (PCRETURN/100)) RANK FROM $tablename WHERE PCRETURN < RATIO AND DOMAIN != 'noref' ORDER BY RANK DESC, HITSGEN DESC LIMIT 10";
	$result = Do_SQL($dbh,$sql);
    $arows = $result->rows;
	$added = 0;
	while (($pointer = $result->fetchrow_hashref) && ($added < 10)) {
		$user = $pointer->{"NOUSER"};
		$url = $pointer->{"URL"};
		print DATAFILE "$user|$url\n";
		$added++;
		$users[$count] = $user;
		$count++;
	}
	if ($added < 10) { $offset += 10 - $added; }
	$sql = "SELECT u.NOUSER,u.URL FROM $tablename u,$thour h WHERE ".setExp("UOUT")."<MIN AND u.DOMAIN != 'noref' ORDER BY ".setExp("UOUT")." ASC, u.HITSGEN DESC LIMIT 12";
	$result = Do_SQL($dbh,$sql);
    $arows = $result->rows;
	$added = 0;
	while (($pointer = $result->fetchrow_hashref) && ($added < 2)) {
		$user = $pointer->{"NOUSER"};
		unless (inArray($user,@users)) {
			$url = $pointer->{"URL"};
			print DATAFILE "$user|$url\n";
			$added++;
			$users[$count] = $user;
			$count++;
		}
    }
	if ($added < 2) { $offset += 2 - $added; }
	if ($offset != 0) {
		$sql = "SELECT u.NOUSER,u.URL FROM $tablename u,$thour h WHERE u.DOMAIN != 'noref' ORDER BY ".setExp("TOUT")." ASC, u.HITSGEN DESC";
		$result = Do_SQL($dbh,$sql);
		$added = 0;
		while (($pointer = $result->fetchrow_hashref) && ($added < $offset)) {
			$user = $pointer->{"NOUSER"};
			unless (inArray($user,@users)) {
				$url = $pointer->{"URL"};
				print DATAFILE "$user|$url\n";
				$added++;
				$users[$count] = $user;
				$count++;
			}
	    }
	}
	close(DATAFILE);
	flock(LOCKFILE,8);
	close(LOCKFILE);
	$result->finish;
}
$dbh->disconnect;