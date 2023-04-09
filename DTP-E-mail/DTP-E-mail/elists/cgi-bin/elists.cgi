#!/usr/bin/perl

#   Welcome to the www.dtp-aus.com E-Lists scripts. Version 2.2 - July 2000  #
#  IMPORTANT INFORMATION THAT MUST BE READ IF YOU WISH TO USE THESE SCRIPTS  #
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

sub chk_addr {
    my $chk = shift;
    if ($chk =~ /(.*@.*\.[a-zA-Z]{2,3}$)/ && $chk !~ /(^\.)|(\.$)|( )|(\.\.)|(@\.)|(\.@)|(@.*@)|\,|\`|\^/ && $chk !~ /[$sep]/g) {return(1);}
    else {return(0);}
}
sub check_ref {
		local $crf = 0;
	if ($ENV{'HTTP_REFERER'}) {
        foreach $referer (@referers) {
            if ($ENV{'HTTP_REFERER'} =~ m|\Ahttps?://$referer|i) {
                $crf = 1;
                last;
	}	}	}
	if ($crf == 0) {&showErr('Bad Referrer</b> - remote access denied;<br>please use ONLY forms or page links ON this site.<b>');}
}
sub date_time {
   my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday);
   ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday) = (gmtime(time + $gmtPlusMinus));
   	if ($year < 39) { $year = "20$year"; }
   	elsif ($year > 99 && $year < 2000) { $year = 2000 + ( $year - 100 ); }
   	elsif ($year > 38) { $year = "19$year"; }
   if (!$dtUS) {return sprintf("%02d\/%02d\/%04d - %02d:%02d",$mday,$mon + 1,$year,$hour,$min);}
   else {return sprintf("%02d\/%02d\/%04d - %02d:%02d",$mon + 1,$mday,$year,$hour,$min);}
}
sub mailtime {
	my($sec,$min,$hour,$mday,$mon,$year,$wday,$w,$ww,$www);
    my(@wkdy)=qw~Sun Mon Tue Wed Thu Fri Sat~;
    my(@mnth)=qw~Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec~;
		($sec,$min,$hour,$mday,$mon,$year,$wday) = (gmtime(time + $gmtPlusMinus));
		if ($year > 99) {$year = 2000 + ($year - 100);}
		elsif ($year < 100) {$year = "19$year";}
	$w = $gmtPlusMinus /60 /60; ($ww = $w) =~ s/\..*//; ($www = $w) =~ s/$ww//;	$www = (60 * $www);
	return sprintf("$wkdy[$wday], %02d $mnth[$mon] %04d %02d:%02d:%02d %+03d%02d (GMT)",$mday,$year,$hour,$min,$sec,$ww,$www);
}
sub tellme {
	local $mbit = shift;
	open (MAIL, "|$mailprog -t") || &showErr('Webmaster Notification');
	print MAIL "Date: $Date\n";
	print MAIL "To: $mstrName <$webmstr>\n";
	print MAIL "From: $FName <$FFrom>\n";
	print MAIL "Organization: $Norg\n" if $Norg;
	print MAIL "Subject: Mail List \"$REFS{'frmRef'}\"\n";
	print MAIL "Mime-Version: 1.0\n";
	print MAIL "X-Mailer: E-Lists v2.2\n";
	print MAIL "Content-Type: text/plain;\n";
	print MAIL "Content-Transfer-Encoding: 7bit\n\n";
	print MAIL "** Mail List Subscription Report **\n\n";
	print MAIL "  Details:\n$mbit\n\n";
	print MAIL "-----END Message----\n";
	print MAIL "  Report Time: $datetime\n";
	print MAIL "trace $ENV{'REMOTE_ADDR'} : $ENV{'REMOTE_HOST'}\n\n";
	close (MAIL);
}
sub showErr {$serr = shift; print "Content-type: text/html\n\n"; require $admin_pth."progerrs.pl"; exit;}

		my $query_string;
	if ( $ENV{'REQUEST_METHOD'} eq 'GET' ) { $query_string = $ENV{'QUERY_STRING'}; } 
  	elsif ( $ENV{'REQUEST_METHOD'} eq 'POST' ) { read(STDIN,$query_string,$ENV{'CONTENT_LENGTH'}); }
	else { &showErr('Illegal Request Method'); }
		@pairs = split(/&/, $query_string);
	foreach $pair (@pairs) {
	($name, $value) = split(/=/,$pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$name =~ s/~!/ ~!/gs;
		$value =~ s/~!/ ~!/gs;
		$name =~ s/<!--#(.|\n)*-->//gs;
		$value =~ s/<!--#(.|\n)*-->//gs;
		$name =~ s/(\0|`|\.?\.\\|\.?\.\/)//sg;
		$value =~ s/(\0|`)//sg;
	$FORM{$name} = $value;
	}
		$FORM{'df'} =~ s/(^\s+|\s+$)//;
		$FORM{'df'} =~ s/(\0|`|\.?\.\\|\.?\.\/)//sg; 
	if ($FORM{'df'} =~ /[\!\.\#~\&\%\$\@\^\|\\\/;'"\*\(\)\{\}\?=\t]/sg) {&showErr ("Improper 'df' value</b><br>use plain text and &quot;<b>:</b>&quot; characters only");}
		($REFS{'form_df'},$trash,$trsh) = split (/:/,$FORM{'df'});
		$REFS{'form_df'} =~ s/(\0|\s)//sg;
	my $aChk = 0; foreach (@alwFiles) {
		if ($_ =~ /^(\d):$REFS{'form_df'}:(.+):(\d$)/) {
		$REFS{'addr_only'} = $1;
		$REFS{'frmRef'} = $2; 
		$REFS{'opit'} = $3; 
		$aChk = 1; last;}	}
	&showErr("List Name Not Allowed") if $aChk != 1;
		$REFS{'frmRef'} =~ s/(^\s+|\s+$)//; 
			&check_ref if $REFS{'frmRef'} !~ /^\.{1,1}.+/; 
				$REFS{'frmRef'} =~ s/\.+//g;
		if ($REFS{'addr_only'} < 3) {$REFS{'force'} = 1;} else {delete $FORM{'fstname'};}
	if (!$REFS{'form_df'} || $REFS{'addr_only'} !~ /(0|1|2|3|4|5)/ || $REFS{'form_df'} =~ /(\/)|(\.)/) {&showErr("Missing or incorrect 'df' form data");}

		$LMt = (5 * 86400) + 43200; $myT = '0'; $Nadrs=$Nnme=$Norg=""; $Zz = "\0";
		if (open (AD,"<$admin_pth$REFS{'form_df'}.adr")) {
			($Nadrs,$Nnme,$Norg) = split(/:/,<AD>); close(AD);
			$mstrName = $Nnme if $Nnme; $webmstr = $Nadrs if $Nadrs;
		}
		else {($webmstr,$mstrName) = split (/:/,$webmstr);}

		if ($FORM{'from'} ne $theword) {
				$FORM{'from'} =~ s/($sep|^\s*)//sg;
				$FORM{'from'} =~ s/(\0|`|\.?\.\\|\.?\.\/)//sg; 
					$FORM{'fstname'} =~ s/($sep|^\s*|^htm$|\s*$)//sg if $FORM{'fstname'}; 
					$FORM{'fstname'} =~ s/(\0|`|\.?\.\\|\.?\.\/)//sg; 
		}
		else { $myT = 1; $FORM{'from'} = $webmstr; $FORM{'fstname'} = $mstrName if $REFS{'addr_only'} < 3; }
		$Norg =~ s/(\0|\A\.\Z|^\s+|\s+$|`)//sg;

		if (length ($FORM{'from'}) > 75) {
			$redis .= "&#149; E-Mail Address too long<br>";	}
		if (!&chk_addr($FORM{'from'}) || !$FORM{'from'}) {
			$redis .= "&#149; E-Mail Address error<br>";	}
		if (defined ($FORM{'fromChk'}) && $FORM{'from'} ne $FORM{'fromChk'}) {
			$redis .= "&#149; Both Addresses must match<br>";	}
		
		if ($REFS{'force'}) {
			if (length ($FORM{'fstname'}) > 35) {$redis .= "&#149; Personal Name too long<br>";}
			elsif (!$FORM{'fstname'} || $FORM{'fstname'} !~ /^\w+( )?/i) {$redis .= "&#149; Personal Name error<br>";}	}

	if (($ENV{'REMOTE_ADDR'} eq $ENV{'REMOTE_HOST'} || $ENV{'REMOTE_HOST'} !~ /[a-z][A-Z][0-9]/ ) && ($ENV{'REMOTE_ADDR'} =~ /(\d+)\.(\d+)\.(\d+)\.(\d+)/)) {
		my $pk = pack('C4', $1, $2, $3, $4);
		my $cnvrt = (gethostbyaddr($pk, 2))[0];
		if ($cnvrt) {$ENV{'REMOTE_HOST'} = $cnvrt;}
		else {$ENV{'REMOTE_HOST'} = $ENV{'REMOTE_ADDR'};}	}
	$FFrom = $FORM{'from'};		$FRMdf = $FORM{'df'}; 		 
	$FName = $FORM{'fstname'}; 	$FRMish = $FORM{'ishtml'}; 
	$FRMrtn = $FORM{'return'}; 	$FRMthnx = $FORM{'thnx'}; 
	$FRMredo = $FORM{'this'};	$FRMundo = $FORM{'undo'};
	$FRMredo = $hm_url if !$FRMredo; $FRMundo = $FRMredo if !$FRMundo && $REFS{'addr_only'} < 5;
		$listfile = $listDir.$REFS{'form_df'}.$list_exten; 
		$listname = $REFS{'form_df'}.$list_exten;
		$txtfile = $admin_pth.$REFS{'form_df'}.".txt"; 
	$NOsve = 0; if ($REFS{'addr_only'} eq "5") {$NOsve = '1'; $REFS{'opit'} = '0';} 			
		$Date = &mailtime; $datetime = &date_time;
	if ($FORM{'unsub'} eq "1") { 
		$mbit = "  $FName: $FFrom\n  Un-Subscribed - '".$REFS{'frmRef'}."'"; $mbit = "  RELAYED: $FFrom\n  Un-Subscribed - '".$REFS{'frmRef'}."'" if $REFS{'addr_only'} == 5; 
		$exsts = ""; $bit2 = ""; require $admin_pth."unsubs.pl"; &do_unsub;}
	else { ($noAlw,$chngd,$exsts,$chVal) = (0,0,0,""); require $admin_pth."scribe.pl";}

exit(0);
