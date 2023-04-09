#admn5.pl
sub sendem {
	$| = 1;
		&chk_allow;
		$s1 = $FORM{'view'};
	my ($mailhdr,$mailmsg,$mailsig,$val1,$val2,$val3,@mFiles,$has,$not);
	if (!&get_txts("$mrgdatdir_pth/$s1$mrgdta_exten")) {&err_msg("</b>[ $s1$mrgdta_exten ]<b><br>&nbsp;Data File Access");}
		$maxsend = $FORM{'max'}; $nomerge = $FORM{'nomrge'}; $staylve = $FORM{'stay'};

	if (open(DB,"+<$mrgdatdir_pth/$s1.db")) {
		($has,$not) = split (/\|/,<DB>); $not =~ s/\s//g;
		
			$subject =~ s/^ *//;
				$efrom =~ s/^ *//;
			$subject =~ s/^\.*//;
				$efrom =~ s/^\.*//;

	if (!$FORM{'test'}) {
		if (open(FN,"<$mrgdatdir_pth/$s1$mrgLst_exten")) {
			eval "flock(FN,2)"; @mFiles = <FN>; eval "flock(FN,8)";
		close(FN);	}
		else {&err_msg("</b>[$s1]<b> Cannot Read list<br>\n");}
	} else { undef @mFiles; $maxsend = 2; $has = 0;
			if ($addr_only eq "5") {push (@mFiles,"$deflt_mail");}
			elsif ($addr_only eq "3") {push (@mFiles,"$deflt_mail"); push (@mFiles,"$deflt_mail$sep"."htm");}
			elsif ($addr_only eq "4") {push (@mFiles,"$deflt_mail$sep".&date_time_real(time + $gmtPlusMinus)); push (@mFiles,"$deflt_mail$sep".&date_time_real(time + $gmtPlusMinus).$sep."htm");}
			elsif ($addr_only eq "0") {push (@mFiles,"$deflt_mail$sep"."Boss$sep".&date_time_real(time + $gmtPlusMinus)); push (@mFiles,"$deflt_mail$sep"."Boss$sep".&date_time_real(time + $gmtPlusMinus).$sep."htm");}
			elsif ($addr_only eq "2") {push (@mFiles,"Boss$sep$deflt_mail"); push (@mFiles,"Boss$sep$deflt_mail$sep"."htm");}
			elsif ($addr_only eq "1") {push (@mFiles,"$deflt_mail$sep"."Boss"); push (@mFiles,"$deflt_mail$sep"."Boss$sep"."htm");}
	}
	if ($nomerge) {
		if ($html =~ /(<<email>>|<<ename>>|<<edate>>)/mg) {$err_msgs .= "&nbsp;&#149; HTML page contains field markers<br>\n";}
		if ($emsg =~ /(<<email>>|<<ename>>|<<edate>>)/sg) {$err_msgs .= "&nbsp;&#149; Message text contains field markers<br>\n";}
		if ($hdr =~ /(<<email>>|<<ename>>|<<edate>>)/sg) {$err_msgs .= "&nbsp;&#149; Header text contains field markers<br>\n";}
		if ($sig =~ /(<<email>>|<<ename>>|<<edate>>)/sg) {$err_msgs .= "&nbsp;&#149; Signature text contains field markers<br>\n";}
		if ($err_msgs) {$err_msgs = "<font color=\"#CC0000\"><b>\"No Merge\" selected</b></font>.<br>$err_msgs<b>Field markers will show and must be removed</b>\n";}
	}
	$Date = &mailtime; 
for($cnt = $has; $cnts < $maxsend && $cnt < @mFiles; $cnt++) {
		$val1=$val2=$val3=$htm="";
	if ($addr_only eq "5") {$val1 = $mFiles[$cnt];}
	elsif ($addr_only eq "3") {($val1,$htm) = split(/[$sep]/,$mFiles[$cnt]);}
	elsif ($addr_only eq "0") {($val1,$val2,$val3,$htm) = split(/[$sep]/,$mFiles[$cnt]);}
	elsif ($addr_only eq "2") {($val2,$val1,$htm) = split(/[$sep]/,$mFiles[$cnt]);}
	elsif ($addr_only eq "1") {($val1,$val2,$htm) = split(/[$sep]/,$mFiles[$cnt]);}
	elsif ($addr_only eq "4") {($val1,$val3,$htm) = split(/[$sep]/,$mFiles[$cnt]);}
		chomp($val1,$val2,$val3,$htm);

	(($html && $htm eq "htm") || $frmhtm || !$emsg) ? ($mailmsg = $html and $htm = 1) : ($mailmsg = "$hdr\n$emsg\n$sig" and $htm = 0);
		
	if (!$nomerge) {
		$mailmsg =~ s/<<email>>/$val1/sg;
		$mailmsg =~ s/<<ename>>/$val2/sg if $val2;
		$mailmsg =~ s/<<edate>>/$val3/sg if $val3;	}
		
	$val2 = " \"$val2\"" if $val2;
	if ($mailmsg && $val1 && $subject) {
		if (open (MAIL, "|$mailprog -t")) {
			print MAIL "Date: $Date\n";
			print MAIL "To: $val2 <$val1>\n";
			print MAIL "From: <$efrom>\n";
			print MAIL "Organization: $Org\n" if $Org;
			print MAIL "Subject: $subject\n";
			print MAIL "Mime-Version: 1.0\n";
			print MAIL "X-Mailer: ListMerge v2\n";
			if ($htm) {print MAIL "Content-Type: text/html; $ISO; name=\"mailer.htm\"\n";}
			else {print MAIL "Content-Type: text/plain; $ISO;\n";}
			print MAIL "Content-Transfer-Encoding: 7bit\n\n";
			print MAIL "$mailmsg\n\n";
		close (MAIL);	}
		else {&err_msg("</b>[ $val1 ]<b><br> Failed to open Mail Program");}
	}
	else {&err_msg("[ FAIL! ] data missing...<br></b>HTML/Message, or Address, or Subject<b>");}
		$cnts++; seek (DB,0,0); truncate(DB, 0); print DB ($cnt + 1)."|".($not - $cnts)." " if !$FORM{'test'};
			if ($staylve && !($cnts % $sty)) {$|=1; print " " ;}
}
	close (DB);	}
	else {&err_msg("</b>[ $s1 ]<b><br> Failed to open count file");}
	
	if (!$FORM{'test'}) {
		if (-s "$mrgdatdir_pth/$s1$mrgdta_exten"  && open(DF,">$mrgdatdir_pth/$s1$mrgdta_exten")) { 
			  eval "flock(DF,2)"; $tme = (time + $gmtPlusMinus);
				&df_file("$tme","$doprvw","$maxsend","$boxwidth","$efrom","$subject","$hdr","$emsg","$sig","$addr_only","$nomerge","$staylve","$html","$frmhtm","$div","$lchg","$Org");
			  eval "flock(DF,8)";
		close(DF); }
 		else {$err_msgs .= "</b>[ $s1$mrgdta_exten ]<b> Unable to Update Data File<br>\n";}
	}
if ($err_msgs) {&errs;}
else {require "$mrgdatdir_pth/admn2.pl"; &show_mail;}
}
sub mailtime {
	my($sec,$min,$hour,$mday,$mon,$year,$wday,$w,$ww,$www);
    my(@wkdy) = qw~Sun Mon Tue Wed Thu Fri Sat~;
    my(@mnth)=qw~Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec~;
		($sec,$min,$hour,$mday,$mon,$year,$wday) = (gmtime(time + $gmtPlusMinus));
		if ($year > 99) {$year = 2000 + ($year - 100);}
		elsif ($year < 100) {$year = "19$year";}
	$w = $gmtPlusMinus /60 /60; ($ww = $w) =~ s/\..*//; ($www = $w) =~ s/$ww//;	$www = (60 * $www);
	return sprintf("$wkdy[$wday], %02d $mnth[$mon] %04d %02d:%02d:%02d %+03d%02d (GMT)",$mday,$year,$hour,$min,$sec,$ww,$www);
}
1;
