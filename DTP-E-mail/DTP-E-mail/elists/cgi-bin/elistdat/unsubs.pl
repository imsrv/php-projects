sub do_unsub {
	use strict;
	my $s2 = 0; my ($s1,$s3,@WChk,$cFmm);
	$main::exsts = '0';
if ($main::FFrom =~ /\@/ && $main::FORM{'unsub'} eq "1") {
if ($main::NOsve != 1) {
	open (ADR, "<$main::listfile") || &main::showErr("( $main::listfile ) List File Access");
 	 eval"flock (ADR, 2)"; my @addrin = <ADR>; eval"flock (ADR, 8)";
	close (ADR);
		for($s1 = 0; $s1 < @addrin; $s1++) {
			if ($addrin[$s1] =~ /(^|[$main::sep])$main::FFrom([$main::sep]|$)/i) {
				if ($main::REFS{'opit'} != 1) {splice(@addrin, $s1, 1);} 
				else {$s3 = $addrin[$s1];}
				$s2 = 1; last;
		}	}	
	if ($s2 == 1 && $main::REFS{'opit'} != 1) {
			if (open (ADR, ">$main::listfile")) {
 			 eval"flock (ADR, 2)"; print ADR @addrin; eval"flock (ADR, 8)";
			close (ADR); }
			else {&main::showErr('Unable to Re-Write list file');}
	}
	elsif ($main::REFS{'opit'} == 1) {  #$s2 == 1 && 
		@addrin = (); chomp($s3); $s3 =~ s/([$main::sep]htm)$//;
		my (@WTchk,$is,$c1,$c2,$c3,$c4,$c5,$c6,$svin); my $Zz = $main::Zz; #"\0";
	    my (@sLt) = ('A'..'Z','a'..'z','0'..'9'); 
    			srand(time^$$); chomp ($main::ENt); $cFmm = $sLt[rand(61)].int(rand(998999) + 1000).$sLt[rand(61)].$sLt[rand(61)];
		$svin = "U$Zz$cFmm$Zz".(time + $main::LMt)."$Zz$main::REFS{'form_df'}$Zz$s3";

		if (open(WF,"<$main::admin_pth$main::aux_pth"."waits.wt")) {
			eval"flock(WF,2)"; @WTchk = <WF>; eval"flock(WF,8)"; 
		close(WF);}
		else {&main::showErr("Could Not Read Subscriber File!");}

		foreach $c6 (@WTchk) {
			($c1,$c2,$c3,$c4,$c5) = split (/[$Zz]/,$c6);
			next if time > $c3;
			if ($c1 eq "A" && $c5 =~ /(\A|[$main::sep])$main::FFrom([$main::sep]|$)/i && $c4 eq $main::REFS{'form_df'}) {$is = 1; $main::exsts = 1;} 
			elsif ($c1 eq "U" && $c5 =~ /(\A|[$main::sep])$main::FFrom([$main::sep]|$)/i && $c4 eq $main::REFS{'form_df'}) {$is = 1; $main::exsts = 2;} 
			push (@WChk,"$c6");
		}
		if ($main::exsts == 0) {
			push (@WChk,"$svin\n");  #if $is == 0;
			if (open(WF,">$main::admin_pth$main::aux_pth"."waits.wt")) {
				eval"flock(WF,2)"; print WF @WChk; eval"flock(WF,8)"; 
			close(WF);}
			else {&main::showErr("Could Not Write to Subscriber File!");}
			$cFmm = $main::cnfm_url."?$cFmm";
		}
	}
	$main::exsts = 3 if $main::exsts == 0 && $s2 == 0;
}  	
		if ($main::FRMthnx =~ /^https?:\/\/.+/) {print "Location: $main::FRMthnx\n\n";}
		else {
			if ($main::exsts != 3 && $main::FRMthnx =~ /^pop$/) {$main::bit2 = "Please <b>CLOSE THIS WINDOW</b> to return.";}
			elsif ($main::exsts != 3 && $main::FRMrtn) {$main::bit2 = "Click on <a href=\"$main::FRMrtn\"><b>this Link to return</b></a>.";}
			else { $main::bit2 = qq~
<script language="JavaScript"><!--
document.write('<a href="javascript:history.go(-1)"><b>Click To Return</b></a>.');
// -->
</script>
<noscript>Use your <b>Back Arrow</b> to return.</noscript>~;}
			print "Content-type: text/html\n\n"; require $main::admin_pth."unsubpg.pl"; &shw::shw($main::exsts);}
	#ALL program and copyright notices MUST remain as is and visible on output pages

	&main::tellme($main::mbit) if ($main::exsts == 0 && $main::wbmstr_notify && $main::mbit && $main::REFS{'opit'} != 1);
		if ($main::REFS{'opit'} != 1 && $main::FORM{'cwrd'} && $main::FORM{'cwrd'} eq crypt($main::theword,$main::bitword)) {exit;}

	if ($main::exsts == 0 && $main::NOsve != 1) {
		open (MAIL, "|$main::mailprog -t") || &main::showErr('Mail Program Access');
		print MAIL "Date: $main::Date\n";
		print MAIL "To: $main::FName <$main::FFrom>\n";
		print MAIL "From: $main::mstrName <$main::webmstr>\n";
		print MAIL "Organization: $main::Norg\n" if $main::Norg;
		print MAIL "Subject: UN-Subscribed - Confirmation\n";
		print MAIL "Mime-Version: 1.0\n";
		print MAIL "X-Mailer: E-Lists v2.2\n";
		print MAIL "Content-Type: text/plain;\n";
		print MAIL "Content-Transfer-Encoding: 7bit\n\n";
		print MAIL "  $main::FName\n" if $main::FName;
	    if ($main::REFS{'opit'} != 1) {
		print MAIL "You received this e-mail because your address has\n";
		print MAIL "been removed from the\n"; 
		print MAIL "  '$main::REFS{'frmRef'}' mail list.\n";
		print MAIL "We are sorry to see you leave and have appreciated \n";
		print MAIL "your participation. Please return often to find out\n"; 
		print MAIL "what's new. You will be most welcome to re-subscribe\n";
		print MAIL "to this list at a later time\n\n";
		print MAIL "---------------------------------------\n";
		print MAIL "If UN-Subscribed by someone else please return to:\n";
		print MAIL " $main::FRMredo \n";
		print MAIL "to reinstate your subscription.\n";}
		elsif ($main::REFS{'opit'} == 1) {
		print MAIL "You received this e-mail because of a request to\n";
		print MAIL "remove your address from our mail list:\n"; 
		print MAIL "'$main::REFS{'frmRef'}'.\n";
		print MAIL "We have appreciated your participation and will be\n";
		print MAIL "sorry to see you leave.\n\n"; 
		print MAIL "You have 5 Days to respond to your request!\n\n";
		print MAIL "  ** PLEASE CONFIRM **\n"; 
		print MAIL "To ensure it was indeed your request, click on\n"; 
		print MAIL "this URL to confirm removal from the list.\n";
		print MAIL " $cFmm \n\n";
		print MAIL "If your mail program does not click-activate the FULL\n";
		print MAIL "URL and password, then just copy and paste it to your\n";
		print MAIL "browsers command line now while on-line.\n\n";
		print MAIL "  ---------------------------------------\n";
		print MAIL "  If UN-Subscribed by someone else, please\n";
		print MAIL "  ignore this letter.\n";}
		print MAIL "  ---------------------------------------\n\n";
		print MAIL "UN-Subscribe ISP#: $ENV{'REMOTE_ADDR'}\n";
	    if ($main::FRMundo =~ /^https?:\/\//) {
		print MAIL "UN-Subscribe request from:\n";
	    print MAIL "  $main::FRMundo\n\n";}
		close (MAIL);
	} 	
	exit;
}
	&main::showErr('Matching Address not found<br></b>Please check your input carefully<b>');
}
1;
