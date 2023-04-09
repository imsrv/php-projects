	package scribe;
	$HT = $main::sep."htm" if $main::FRMish eq "htm"; $HT = "" if $main::FRMish ne "htm";

		if (-s "$main::admin_pth$main::REFS{'form_df'}.non") {
			my $crf = 0; my $refs;
			if (open(NF,"<$main::admin_pth$main::REFS{'form_df'}.non")) {
		        while($refs = <NF>) {
		        	chomp($refs);
		            if ($main::FFrom =~ m|\@$refs|i || $main::FFrom =~ m|^$refs$|i) {
		                $crf = 1; last;
			}	}	}
			close(NF);
			if ($crf == 1) {$main::noAlw = 1; $main::isErr .= "<b>Provider Access Denied</b> to [ ".$main::REFS{'frmRef'}." ]";}
		}
	
	$main::chngd = $main::exsts = $cnt = '0'; $match = $tmp = $main::chVal = "";
if (!$main::redis) {
	if ($main::NOsve != 1) {
		open(FF,"<$main::listfile") || &main::showErr("</b>[ $main::listname ]<b><br> List File Access");
		 eval"flock(FF,2)"; @entries = <FF>; eval"flock(FF,8)";
		close(FF);
		foreach  (@entries) {
			$tmp = $_; chomp ($tmp);
			if ($tmp =~ /(^|[$main::sep])$main::FORM{'from'}([$main::sep]|$)/i) {
			$match = $tmp; 
			$main::exsts = 1; 
			last;}
			$cnt++;
		} 
			if ($main::exsts == 1) {
				if ($HT && $match !~ m/([$main::sep]htm)$/) {
					$tmp = $match.$main::sep."htm\n"; $main::chngd = 1; $main::chVal = "HTML";}
				elsif (!$HT && $match =~ m/(.+)([$main::sep]htm)$/) {
					$tmp = $1."\n"; $main::chngd = 1; $main::chVal = "plain text";}
			}

			if ($main::chngd != 1) {
				 $ENt = "";
				if ($main::REFS{'addr_only'} eq "0") {$ENt = "$main::FFrom$main::sep$main::FName$main::sep$main::datetime$HT\n";}
				elsif ($main::REFS{'addr_only'} eq "1") {$ENt = "$main::FFrom$main::sep$main::FName$HT\n";}
				elsif ($main::REFS{'addr_only'} eq "2") {$ENt = "$main::FName$main::sep$main::FFrom$HT\n";}
				elsif ($main::REFS{'addr_only'} eq "3") {$ENt = "$main::FFrom$HT\n";}
				else {$ENt = "$main::FFrom$main::sep$main::datetime$HT\n";}
			}

			if ($main::exsts != 1 && $main::REFS{'opit'} == 1) {
				@WChk=(); ($is,$c1,$c2,$c3,$c4,$c5,$c6) = (0,"","","","","","");
			    local (@sLt) = ('A'..'Z','a'..'z','0'..'9'); 
    			srand(time^$$); chomp ($ENt); $cFm = $sLt[rand(61)].int(rand(998999) + 1000).$sLt[rand(61)].$sLt[rand(61)];
				$svin = "A$main::Zz$cFm$main::Zz".(time + $main::LMt)."$main::Zz$main::REFS{'form_df'}$main::Zz$ENt";

				if (open(WF,"<$main::admin_pth$main::aux_pth"."waits.wt")) {
					eval"flock(WF,2)"; @WTchk = <WF>; eval"flock(WF,8)"; 
				close(WF);}
				else {&main::showErr("Could Not Read Subscriber File!");}

				foreach $c6 (@WTchk) {
					($c1,$c2,$c3,$c4,$c5) = split (/[$main::Zz]/,$c6);
					next if time > $c3;
					if ($c1 eq "A" && $c5 =~ /(\A|[$main::sep])$main::FFrom([$main::sep]|$)/i && $c4 eq $main::REFS{'form_df'}) {$is = 1; $main::exsts = 2;}
					push (@WChk,"$c6") if $c1 =~ /^(A|U)$/;
				}
			}

		if ($main::exsts == 1 && $main::chngd != 1) {$main::isErr .= "<b>The address already exists</b> in this list<br>\n"}
		elsif ($main::exsts == 2 && $main::chngd != 1) {$main::isErr .= "<b>Address already submitted</b> - waiting for confirmation!<br>\n"}
		elsif ($main::exsts == 1 && $main::chngd == 1) {$entries[$cnt] = $tmp;}
		if ($main::chVal && $main::chngd == 1) {$main::htmChng .= "<b>Mail Format changed</b> to [ <b>$main::chVal</b> ];<br>&nbsp;&nbsp;- <i>in list</i> &quot;".$main::REFS{'frmRef'}."&quot;<br>You will receive our next subscribed e-mail in this format.\n"}

		if ($main::myT == 0 && ($main::chngd == 1 || ($main::exsts == 0 && $main::noAlw != 1))) {
			if ($main::REFS{'opit'} != 1 || $main::chngd == 1) {
				push(@entries,$ENt) if $main::chngd != 1;
				@entries = sort (@entries);
				if (open(FF,">$main::listfile")) {
					eval"flock(FF,2)"; print FF @entries; eval"flock(FF,8)"; close(FF);
				}
				else {&main::showErr("[ $main::listname ] List File Access");}
			}
			else {
				push (@WChk,"$svin\n") if $is != 1;
				if (open(WF,">$main::admin_pth$main::aux_pth"."waits.wt")) {
					eval"flock(WF,2)"; print WF @WChk; eval"flock(WF,8)"; 
				close(WF);}
				else {&main::showErr("Could Not Write to Subscriber File!");}
				$cFm = $main::cnfm_url."?$cFm";
			}
		}
	} 
	
		if ($main::chVal && $main::chngd == 1) {
			$mbit = "  $main::FName: $main::FFrom\n  mail format change to [ $main::chVal ]\n  list - '".$main::REFS{'frmRef'}."'";
		}
		elsif (!$main::isErr && $main::NOsve != 1 && $main::REFS{'opit'} != 1) {
			$mbit = "  $main::FName: $main::FFrom\n  added to list - '".$main::REFS{'frmRef'}."'";
			$bbit = qq~<p align=\"center\"><b>Address was added to</b> '$main::REFS{'frmRef'}' list<p>\n~;
		}
		elsif (!$main::isErr && $main::NOsve != 1 && $main::REFS{'opit'} == 1) {
			$mbit = "  $main::FName: $main::FFrom\n  will be added to list - '".$main::REFS{'frmRef'}."'";
			$bbit = qq~<p align=\"center\"><b>Address will be added to</b> '$main::REFS{'frmRef'}' list<p>\n~;
		}
		elsif (!$main::isErr && $main::NOsve == 1) {
			$mbit = "  RELAYED: $main::FFrom\n  SENT to list - '".$main::REFS{'frmRef'}."'";
			$bbit = qq~<p align=\"center\"><b>Address will be Subscribed to</b> '$main::REFS{'frmRef'}' list<p>\n~;
		}


}  
elsif ($main::redis) {
		$plural = "ERROR"; if ($main::redis =~ /(<br>).*(<br>)/sg) {$plural .= "S" if $2;} $plural .= " Detected";
		print "Content-type: text/html\n\n"; require $main::admin_pth."redisplay.pl"; exit;
}
		$main::htmChng = qq~<p align="center">$main::htmChng</p>~ if $main::htmChng;
		$main::isErr = qq~<p align="center">$main::isErr</p>~ if $main::isErr;
	
	if ($main::NOsve == 1 && -s "$main::admin_pth$main::REFS{'form_df'}.pl") {
		require "$main::admin_pth$main::REFS{'form_df'}.pl"; 
		($ADDadrs,$ADDsubject,$ADDbody,$UNSadrs,$UNSsubject,$UNSbody) = &AUt::specs;
	}
	elsif ($main::NOsve == 1) {&main::showErr('Cannot Access Autorespond Data');}
		
	if ($main::FRMthnx =~ /^https?:\/\/.+/i) {print "Location: $main::FRMthnx\n\n";}
	else {
		if ($main::FRMthnx =~ /^pop$/) {$bit2 = qq~Please <b>CLOSE THIS WINDOW</b> to return.~;}
		elsif ($main::FRMrtn) {$bit2 = qq~Click on <a href="$main::FRMrtn"><b>this Link to return</b></a>.~;}
		else {$bit2 = qq~
<script language="JavaScript"><!--
document.write('<a href="javascript:history.go(-1)"><b>Click To Return</b></a>.');
// -->
</script>
<noscript>Use your <b>Back Arrow</b> to return.</noscript>~;}
	print "Content-type: text/html\n\n";  require $main::admin_pth."result.pl";	}
	#ALL program and copyright notices MUST remain as is and visible on output pages

	&main::tellme($mbit) if ($main::wbmstr_notify && $mbit && $main::REFS{'opit'} != 1);
		if ($main::REFS{'opit'} != 1 && $main::FORM{'cwrd'} && $main::FORM{'cwrd'} eq crypt($main::theword,$main::bitword)) {exit;}
			&tellthem if $mbit && $main::chngd != 1 && $main::REFS{'addr_only'} < 5;
exit(0);

sub tellthem {
	my $sndback = ""; my $txts = "";
		if ( -e "$main::txtfile" && $main::REFS{'opit'} != 1) {
			open(TF,"<$main::txtfile") || &main::showErr('Mail-Text File read Access'); eval"flock(TF,2)";
			while ($txts = <TF>) {
				$txts =~ s/(\n|\cM\n)$//g;
				$txts =~ s/~!/ ~!/g;
				$txts =~ s/<!--#(.|\n)*-->//g;
				$txts =~ s/(^\.)/ /g;
				$sndback .= $txts."\n";
			} 
			eval"flock(TF,8)"; close(TF);
		}
		my $SBJct = "Our Mail List; you are subscribed";
		$SBJct = "Please Confirm your Subscription" if $main::REFS{'opit'} == 1;
			if ($main::NOsve == 1) {
				$main::webmstr = $main::FFrom; 
				$main::FFrom = $ADDadrs;
				$main::FName = "";
				$main::Norg = "";
				$main::mstrName = "";
				$ADDsubject =~ s/<%%ADDRS%%>/$main::webmstr/sg;
				$ADDbody =~ s/<%%ADDRS%%>/$main::webmstr/sg;
				$UNSsubject =~ s/<%%UNADDRS%%>/$main::webmstr/sg;
				$UNSbody =~ s/<%%UNADDRS%%>/$main::webmstr/sg;
				$SBJct = $ADDsubject;
			}
		open (MAIL, "|$main::mailprog -t") || &main::showErr('Mail Program Access');
		print MAIL "Date: $main::Date\n";
		print MAIL "To: $main::FName <$main::FFrom>\n";
		print MAIL "From: $main::mstrName <$main::webmstr>\n";
		print MAIL "Organization: $main::Norg\n" if $main::Norg;
		print MAIL "Subject: $SBJct\n";
		print MAIL "Mime-Version: 1.0\n";
		print MAIL "X-Mailer: E-Lists v2.2\n";
		print MAIL "Content-Type: text/plain;\n";
		print MAIL "Content-Transfer-Encoding: 7bit\n\n";
		if ($main::NOsve != 1) {
		if ($main::REFS{'opit'} != 1) {
		print MAIL "You received this e-mail because you (or someone\n";
		print MAIL "using your address) asked to be included in our\n";
		print MAIL "subscribed mail list '$main::REFS{'frmRef'}'.\n"; }
		else {
		print MAIL "\nYou have 5 Days to respond to your request!\n\n";
		print MAIL "  ** PLEASE CONFIRM YOUR SUBSCRIPTION **\n";
		print MAIL "Your address was submitted to our mail list and as\n";
		print MAIL "a courtesy to ensure you entered your own details,\n";
		print MAIL "please click on this URL:\n";
		print MAIL " $cFm \n\n";
		print MAIL "If your mail program does not click-activate the FULL\n";
		print MAIL "URL, then just copy and paste it to your browsers\n";
		print MAIL "command line now while on-line.\n\n";
		print MAIL "The response will finalise your subscription to our\n";
		print MAIL "mail list - '$main::REFS{'frmRef'}'. Thank you.\n\n"; 
		print MAIL "We look forward to your participation once you have\n";
		print MAIL "confirmed membership via the above URL and password.\n"; }
		print MAIL "  Details:\n$mbit\n\n";
		if ($sndback) { print MAIL "$sndback\n"; }
		if ($main::REFS{'opit'} == 1) {my $wRd = " once confirmed";}
		print MAIL "This confirmation message was sent from:\n  $main::FRMredo\n" if $main::FRMredo =~ /\Ahttps?:\/\//;
		print MAIL "To UN-Subscribe$wRd, return to:\n  $main::FRMundo\n" if $main::FRMundo =~ /\Ahttps?:\/\//;
		print MAIL "  Report Time: $main::datetime\n";
		print MAIL "  subscriber route: $ENV{'REMOTE_ADDR'}\n\n";
		}
		elsif ($main::NOsve == 1) {print MAIL "$ADDbody\n\n";}
		close (MAIL);
}
1;