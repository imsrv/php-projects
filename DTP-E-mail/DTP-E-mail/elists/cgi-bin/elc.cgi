#!/usr/bin/perl

##############################################################################
# The program scripts ELISTS.CGI, ELISTADM.CGI, ELC.CGI, TESTBIN.CGI and     #
# associated Perl files were written (c) by Ron F Woolley, Melbourne         #
# Australia. Copyright 1998'99,2000. These scripts and associated Perl files #
# CAN BE ALTERED for personal site use OR commercial site use as instructed  #
# here in and in our original program files,                                 #
# BUT whole or portions of code cannot be copied,                            #
# AND all program name and copyright notices must remain in all output as is,#
# AND all of the header notices in the scripts MUST REMAIN intact as is,     #
# AND using the scripts without first reading the README file(s), is         #
# prohibited. IF YOU DO NOT AGREE, destroy all files NOW!                    #
#                                                                            #
# This code MUST NOT be sold, hired, or given/made available to others, in   #
# any way. Changing output English words to another language is permitted for#
# OWN USE ONLY except program name and copyright notices must remain as is!  #
#                                                                            #
# Australian copyright is recognised/supported in over 130 countries...      #
# per the Berne Convention and other treaties ( including USA! )             #
# registration not required!                                                 #
#                                                                            #
# The scripts, code, and supplied associated files remain the property of    #
# Ron F Woolley. NO PROFIT what so ever is to be gained from users of these  #
# scripts for their sites use of these scripts, EXCEPT that a reasonable     #
# minimal charge for installation may be allowed if installing, as a site    #
# developer, for a user on the users site that is not on the developers site.#
# This program must NOT be used for multiple E-Lists users on one site OR    #
# offered as a remote service. Ron Woolley, the author, MUST be notified via #
# the addresses/URLs below if any gain is to be made from the installation   #
# of these scripts.                                                          #
##############################################################################
# NOTE: If you use these files, you do so entirely at your own risk, and     #
# take on full responsibility for the consequences of using the described    #
# You must first agree that Ron Woolley / HostingNet, the ONLY permitted     #
# files, suppliers of this or accompanying files are exempt from any         #
# responsibility for all or any resulting problems, losses or costs caused   #
# by your using these or any associated files. IF YOU DISAGREE with any of   #
# these requirements for any reason, you must immediately destroy all files. #
##############################################################################
# These program scripts are free to use, but if you use them, a support      #
# donation would be appreciated and help in continuing support for           #
# free-to-use E-Lists and the creation of other programs for wemasters on    #
# the internet (secure direct on line Visa/Mastercard payment possible).     #
# Help/Advice Information is available at:                                   #
#     http://www.dtp-aus.com/cgiscript/scrpthlp.htm                          #
# Files from:                                                                #
#     http://www.dtp-aus.com/cgiscript/emlscrpt.shtml                        #
# An outline of all dtp-aus scripts is at:                                   #
#     http://www.dtp-aus.com/cgiscript/allcgi.shtml                          #
##############################################################################
# THESE FILES can only be obtained via the above web addresses,              #
# and MUST NOT BE PASSED ON TO OTHERS in any form by any means what so ever. #
# This does not contradict any other statements above.                       #
##############################################################################
#  TO KEEP IT FREE, WE NEED your support on link and resource listing sites! #

package main;
#--- Alter these four paths only, if needed! ---------------------#
	if (-s "sets/gmtset.pl") {require "sets/gmtset.pl";} else {print "Content-type: text/html\n\n"; print "Empty/Missing/Bad Path to GMTime file\n"; exit;}
	if (-s "sets/elistset.pl") {require "sets/elistset.pl";} else {print "Content-type: text/html\n\n"; print "Empty/Missing/Bad Path to Config file\n"; exit;}
#--- Do Not make any code logic changes below this line. ---------#
use strict 'refs';
my $MPGp = $mailprog;
my $DFMt = $dtUS;
my $GMTz = $gmtPlusMinus;
my $CFGp = $cnfg_pth;
my $ADMp = $admin_pth;
my $EXPp = $xport_pth;
my $AUXp = $aux_pth;
my $WMnt = $wbmstr_notify;
my @ALWf = @alwFiles;
my $LDRp = $listDir;
my $LEXt = $list_exten;
my $FRMu = $hm_url;
my $WMSt = $webmstr;
my $Sp = $sep;
my (@WTchk,@WChk,%RFS,$FFrom,$FName,@entries);
my $Zz; $Zz = "\0";
my ($c1,$c2,$c3,$c4,$c5,$c6,$is,$mbit,$WHo,$WHis,$WHat);
my ($Nis,$Ndf,$Nad);
	print "Content-type: text/html\n\n"; 
my $Qs = $ENV{'QUERY_STRING'}; 
	$Qs =~ s/(\0|\r|\n|\Mc|`|#|~|=|\+)//gs;
	$Qs =~ s/(\&.*)//gs;
	$Qs =~ s/(^\s+|\s+$)//gs;
		if ($Qs =~ /^[a-z0-9][0-9]{1,6}[a-z0-9]{2,2}$/i) {}
		else {&showErr("illegal method<br></b>use e-mailed link only!<b>");}

	if (($ENV{'REMOTE_ADDR'} eq $ENV{'REMOTE_HOST'} || $ENV{'REMOTE_HOST'} !~ /[a-z][A-Z][0-9]/ ) && ($ENV{'REMOTE_ADDR'} =~ /(\d+)\.(\d+)\.(\d+)\.(\d+)/)) {
		my $pk = pack('C4', $1, $2, $3, $4);
		my $cnvrt = (gethostbyaddr($pk, 2))[0];
		if ($cnvrt) {$ENV{'REMOTE_HOST'} = $cnvrt;}
		else {$ENV{'REMOTE_HOST'} = $ENV{'REMOTE_ADDR'};}	}

	if (open(WF,"<$ADMp$AUXp"."waits.wt")) {
		eval"flock(WF,2)"; @WTchk = <WF>; eval"flock(WF,8)"; close(WF);}
	else {&showErr("Could Not Read Subscriber File!");}
	foreach $c6 (@WTchk) {
		($c1,$c2,$c3,$c4,$c5) = split (/[$Zz]/,$c6);
		next if time > $c3; 
		if ($c2 eq $Qs) {
			$Nis = $c1;
			$Ndf = $c4;
			$Nad = $c5;
			chomp($Nad);
			next;
		} push (@WChk,"$c6") if $c1 =~ /^(A|U)$/;  }
	&showErr("Request already activated,</b> <i>OR</i><b><br>the 5 Day Time Limit has expired.</b><br>Please refer back to your e-mail.<b>") if $Nis !~ /(A|U)/;

	my $aChk = 0; 
	foreach (@ALWf) {
		if ($_ =~ /^(\d):$Ndf:(.+):(\d$)/) {
		$RFS{'typ'} = $1;
		$RFS{'fRef'} = $2; 
		$RFS{'opit'} = $3; 
		$aChk = 1; last;}	}
	&showErr("Required list-access not allowed.<br></b>Refer to your e-mail and please resubscribe.<b>") if $aChk != 1;
	&showErr("Required list-access not allowed.<br></b>Remote confirmation not accepted.<br>Refer to your e-mail and please resubscribe.<b>") if $RFS{'opit'} != 1;

		$c1=$c2=$c3=$c4="";
		($c1,$c2,$c3,$c4) = split (/[$Sp]/,$Nad);
		if ($RFS{'typ'} =~ /(0|1)/) {$FFrom=$c1; $FName=$c2;}
		elsif ($RFS{'typ'} == 2) {$FFrom=$c2; $FName=$c1;}
		elsif ($RFS{'typ'} =~ /(3|4)/) {$FFrom=$c1; $FName="";}
	$WHo = "$FName"; $WHis = "$FFrom";
		my $listfile = $LDRp.$Ndf.$LEXt; 
		my $listname = $Ndf.$LEXt;
		my $txtfile = $ADMp.$Ndf.".txt"; 

   my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$datetime);
   ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday) = (gmtime(time + $GMTz));
   	if ($year < 39) { $year = "20$year"; }
   	elsif ($year > 99 && $year < 2000) { $year = 2000 + ( $year - 100 ); }
   	elsif ($year > 38) { $year = "19$year"; }
   if (!$DFMt) {$datetime = sprintf("%02d\/%02d\/%04d - %02d:%02d",$mday,$mon + 1,$year,$hour,$min);}
   else {$datetime = sprintf("%02d\/%02d\/%04d - %02d:%02d",$mon + 1,$mday,$year,$hour,$min);}

	my($w,$ww,$www,$Date);
    my(@wkdy)=qw~Sun Mon Tue Wed Thu Fri Sat~;
    my(@mnth)=qw~Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec~;
		($sec,$min,$hour,$mday,$mon,$year,$wday) = (gmtime(time + $GMTz));
		if ($year > 99) {$year = 2000 + ($year - 100);}
		elsif ($year < 100) {$year = "19$year";}
	$w = $GMTz /60 /60; ($ww = $w) =~ s/\..*//; ($www = $w) =~ s/$ww//;	$www = (60 * $www);
	$Date = sprintf("$wkdy[$wday], %02d $mnth[$mon] %04d %02d:%02d:%02d %+03d%02d (GMT)",$mday,$year,$hour,$min,$sec,$ww,$www);

		my ($Nadrs,$Nnme,$Norg,$mstrName);
		if (open (AD,"<$ADMp$Ndf.adr")) {
			($Nadrs,$Nnme,$Norg) = split(/:/,<AD>); close(AD);
			$mstrName = $Nnme if $Nnme; $WMSt = $Nadrs if $Nadrs;
		}
		else {($WMSt,$mstrName) = split (/:/,$WMSt);}

	if ($Nis eq "A") {
		open(FF,"<$listfile") || &showErr("</b>[ $listname ]<b><br>Cannot Read List File");
		 eval"flock(FF,2)"; @entries = <FF>; eval"flock(FF,8)";
		close(FF);
			push(@entries,$Nad."\n"); @entries = sort(@entries);
		open(FF,">$listfile") || &showErr("</b>[ $listname ]<b><br>Cannot Write to List File");
		 eval"flock(FF,2)"; print FF @entries; eval"flock(FF,8)";
		close(FF);
	$mbit = "  $FName: $FFrom\n  Addition to list - '$RFS{'fRef'}'";
	$WHat = "Addition to list '$RFS{'fRef'}'";
	}

	elsif ($Nis eq "U") {
	open (ADR, "<$listfile") || &showErr("( $listfile ) List File Access");
 	 eval"flock (ADR, 2)"; my @addrin = <ADR>; eval"flock (ADR, 8)";
	close (ADR); my ($s1,$s2,$s3);
		for($s1 = 0; $s1 < @addrin; $s1++) {
			if ($addrin[$s1] =~ /(^|[$sep])$FFrom([$sep]|$)/i) {
				if ($RFS{'opit'} == 1) {splice(@addrin, $s1, 1);} 
				else {$s3 = $addrin[$s1];}
				$s2 = 1; last;
		}	}	
	if ($s2 == 1 && $RFS{'opit'} == 1) {
			if (open (ADR, ">$listfile")) {
 			 eval"flock (ADR, 2)"; print ADR @addrin; eval"flock (ADR, 8)";
			close (ADR); }
			else {&showErr('Unable to Re-Write list file');}
	}
	else {&showErr('Address Not Found</b> in this list!<br>request incomplete.<b>');}
	$mbit = "  $FName: $FFrom\n  Removed from list - '".$RFS{'fRef'}."'";
	$WHat = "Removed from list '$RFS{'fRef'}'";
	}
	else {&showErr("Fatal Program Error");}

	if (open(WF,">$ADMp$AUXp"."waits.wt")) {
		eval"flock(WF,2)"; print WF @WChk; eval"flock(WF,8)"; close(WF);}
	else {&showErr("Could Not Write to Subscriber File!");}

	if ($Nis =~ /(A|U)/) {
	my $sndback = ""; my $txts = "";
		if ( -e "$txtfile" && $Nis eq "A") {
			open(TF,"<$txtfile") || &showErr('Mail-Text File read Access'); eval"flock(TF,2)";
			while ($txts = <TF>) {
				$txts =~ s/(\n|\cM\n)$//g;
				$txts =~ s/~!/ ~!/g;
				$txts =~ s/<!--#(.|\n)*-->//g;
				$txts =~ s/(^\.)/ /g;
				$sndback .= $txts."\n";
			} eval"flock(TF,8)"; close(TF);  }
		my $SBJct = "Our Mail List; you are subscribed";
			$SBJct = "Un-Subscribe Confirmation" if $Nis eq "U";
		open (MAIL, "|$MPGp -t") || &showErr('Mail Program Access');
		print MAIL "Date: $Date\n";
		print MAIL "To: $FName <$FFrom>\n";
		print MAIL "From: $mstrName <$WMSt>\n";
		print MAIL "Organization: $Norg\n" if $Norg;
		print MAIL "Subject: $SBJct\n";
		print MAIL "Mime-Version: 1.0\n";
		print MAIL "X-Mailer: E-Lists v2.2\n";
		print MAIL "Content-Type: text/plain;\n";
		print MAIL "Content-Transfer-Encoding: 7bit\n\n";
		print MAIL "** $SBJct **\n\n";
		if ($Nis eq "A") {
		print MAIL "Your personal confirmation submission to our mail-list\n";
		print MAIL "has been accepted.\n"; }
		else {
		print MAIL "Your personal confirmation to Un-Subscribe from our\n";
		print MAIL "mail-list has been accepted.\n\n";
		print MAIL "We are sorry to see you go and hope you return often\n";
		print MAIL "to find out what's new; you will of course be most\n";
		print MAIL "welcome to resubscribe at another time. Thank you for\n";
		print MAIL "your participation and best wishes from all of us.\n\n"; }
		print MAIL "  Details: via remote access\n$mbit\n\n";
		print MAIL "$sndback\n" if $Nis eq "A" && $sndback;
		print MAIL "This confirmation message was sent from:\n  $FRMu\n" if $FRMu =~ /\Ahttps?:\/\//;
		print MAIL "  Report Time: $datetime\n";
	    print MAIL "  subscriber route: $ENV{'REMOTE_ADDR'}\n\n";
		close (MAIL);
	}

	if ($WMnt) {
		open (MAIL, "|$MPGp -t") || &showErr('Webmaster Notification');
		print MAIL "Date: $Date\n";
		print MAIL "To: $mstrName <$WMSt>\n";
		print MAIL "From: $FName <$FFrom>\n";
		print MAIL "Organization: $Norg\n" if $Norg;
		print MAIL "Subject: Mail List \"$RFS{'fRef'}\"\n";
		print MAIL "Mime-Version: 1.0\n";
		print MAIL "X-Mailer: E-Lists v2.2\n";
		print MAIL "Content-Type: text/plain;\n";
		print MAIL "Content-Transfer-Encoding: 7bit\n\n";
		print MAIL "** Mail List Subscription Report **\n\n";
		print MAIL "  Details: via remote access\n$mbit\n\n";
		print MAIL "-----END Message----\n";
		print MAIL "  Report Time: $datetime\n";
		print MAIL "trace $ENV{'REMOTE_ADDR'} : $ENV{'REMOTE_HOST'}\n\n";
		close (MAIL);
	}

	my $inLin; my $hTm = "waitadd.htm"; $hTm = "waituns.htm" if $Nis eq "U";
	if (open(HF,"<$ADMp$AUXp$hTm")) {  
		eval"flock(HF,2)";
		while ($inLin = <HF>) {
			$inLin =~ s/%%WHO%%/$WHo/;
			$inLin =~ s/%%WHIS%%/$WHis/;
			$inLin =~ s/%%WHAT%%/$WHat/;
			print $inLin;  }
		eval"flock(HF,8)"; close(HF); }
	else {&showErr('Cannot Read HTML page');}
	
exit(0);

sub showErr {$FRMthnx ="RMT"; $serr = shift; require $ADMp."progerrs.pl"; exit;}
