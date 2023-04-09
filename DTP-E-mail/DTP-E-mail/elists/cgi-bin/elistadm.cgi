#!/usr/bin/perl

#  Welcome to the www.dtp-aus.com E-Lists script. Version 2.2 - July. 2000   #
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
#--- Alter these four paths only, IF needed! ---------------------#
	if ((-s "sets/gmtset.pl")) {
		require "sets/gmtset.pl";} else {print "Content-type: text/html\n\n"; print "Empty/Missing/Bad Path - GMTime file\n"; exit;}
	if (-s "sets/elistset.pl") {
		require "sets/elistset.pl";} else {print "Content-type: text/html\n\n"; print "Empty/Missing/Bad Path - Config file\n"; exit;}
#--- Do Not make any code logic changes below this line. ---------#
	if (!(-s $admin_pth."admin4.pl")) {print "Content-type: text/html\n\n"; print "Empty/Missing/Bad Path - admin4.pl\n"; exit;}

sub chk_addr {
    my $chk = shift;
    if ($chk =~ /(.*@.*\.[a-zA-Z]{2,3}$)/ && $chk !~ /(^\.)|(\.$)|( )|(\.\.)|(@\.)|(\.@)|(@.*@)/ && $chk !~ /[$sep]/g) { return(1); }
    else { return(0); }
}
sub check_method {
	if ( $ENV{'REQUEST_METHOD'} eq 'GET' ) { $query_string = $ENV{'QUERY_STRING'}; } 
  	elsif ( $ENV{'REQUEST_METHOD'} eq 'POST' ) { read(STDIN,$query_string,$ENV{'CONTENT_LENGTH'}); }
	else { &showErr('Request Method'); }
}
sub check_ref {
	$crf = 0;
	if ($ENV{'HTTP_REFERER'}) {
        foreach $referer (@referers) {
            if ($ENV{'HTTP_REFERER'} =~ m|\Ahttps?://$referer|i) {
                $crf = 1;
                last;
	}	}	}
	if ($crf eq 0) {
		return(1) if $FORM{'cwrd'} = $cwrd;
		&showErr('Bad Referrer</b> - remote access denied;<br>please use only forms or links ON this site.<b>'); return(0);}
	 return(1)
}
sub read_file {
	local $datFile = shift;
	open(FF,"<$datFile") || &showErr("( $datFile ) List File Access");
	 eval"flock(FF,2)"; @entries = <FF>; eval"flock(FF,8)";
	close(FF);
}
sub get_txt {
	$sndback = ""; my $txtfile = shift;
	if ( -e "$txtfile") {
		open(TF,"<$txtfile") || &showErr('Text File read Access'); eval"flock(TF,2)";
		while ($txts = <TF>) {
			$txts =~ s/(\n|\cM\n)$//g;
			$txts =~ s/(\$siteis)/$siteis/g;
			$txts =~ s/(\$listis)/$listis/g;
			$txts =~ s/~!/ ~!/g;
			$txts =~ s/<!--#(.|\n)*-->//g;
			$txts =~ s/(^\.)/ /g;
			$sndback .= $txts."\n";
	} eval"flock(TF,8)"; close(TF);	}
}
sub date_time {
   local(($sec,$min,$hour,$mday,$mon,$year,$wday,$yday)) = (gmtime(time + $gmtPlusMinus));
   	if ($year < 39) { $year = "20$year"; }
   	elsif ($year > 99 && $year < 2000) { $year = 2000 + ( $year - 100 ); }
   	elsif ($year > 38) { $year = "19$year"; }
   if (!$dtUS) {$datetime = sprintf("%02d\/%02d\/%04d - %02d:%02d",$mday,$mon + 1,$year,$hour,$min); return $datetime; }
   else {$datetime = sprintf("%02d\/%02d\/%04d - %02d:%02d",$mon + 1,$mday,$year,$hour,$min); return $datetime; }
}
sub isEdit {
		if ($REFS{'addr_only'} !~ /^[0-5]$/ || !$REFS{'frmRef'}) {
			$errBox = "List [ $FORM{'bgnslct'} ] NOT 'ALLOWED'.... must be activated first!";
			require $admin_pth."admin4.pl"; 
			&begin($FORM{'bgnslct'});
		}
		else {return(1);}
}
sub whatWrd {print "Content-type: text/html\n\n"; print qq~
<html><head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>E-Lists Access</title></head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000"><center>&nbsp;<form method="post" action="$admn_url"><input type="hidden" name="gO" value="word"><table border="0" cellspacing="5" cellpadding="1">
<tr bgcolor="#000066"><th width="100%"><font color="#FFFFFF" size="2" face="verdana, arial, geneva, helvetica"> &nbsp;E-Lists ACCESS Password&nbsp;</font></th>
</tr><tr bgcolor="#000066"><td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="3"><tr align="center" bgcolor="#FFFFFF"><td><input type="password" name="wrd" size="12" maxlength="15">
<input type="submit" name="Submit" value="Enter"></td></tr></table></td></tr><tr><td align="center"><font face="arial, geneva, helvetica" size="1">E-Lists v2.2</font></td></tr></table></form></center></body></html>~; exit;
}
sub showErr {
	$serr = shift; print "Content-type: text/html\n\n"; require $admin_pth."showerrs.pl"; exit;
}
		&check_method;
	@pairs = split(/&/, $query_string);
	foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$name =~ s/~!/ ~!/gs;
		$value =~ s/~!/ ~!/gs;
		$name =~ s/<!--#(.|\n)*-->//gs;
		$value =~ s/<!--#(.|\n)*-->//gs;
		$name =~ s/(\0|`|\\|\.?\.\/)//sg;
		$value =~ s/(\0|`|\\|\.?\.\/)//sg;
	$FORM{$name} = $value;
	if ($name eq "fstname") {$usename = 1;} 
	}
		$cwrd = crypt($theword,$bitword);
	if ($FORM{'cwrd'} ne $cwrd) {&whatWrd if $FORM{'wrd'} ne $theword;}
		&check_ref; 
			if ($FORM{'H'} eq "H" && $FORM{'popv'} == 1) {require $admin_pth."el_help.pl";}
			if ($FORM{'S'} =~ /\d:\w/) {require $admin_pth."el_samp.pl"; &show($FORM{'S'})}
		if ($FORM{'bgnslct'}) {$thuLst = $FORM{'bgnslct'};}
		else {$thuLst = "$FORM{'df'}$list_exten";}
			($thuLstEx = $thuLst) =~ s/$list_exten//;	
	my $aChk = 0; 
		foreach (@alwFiles) {
		if ($_ =~ /^(\d):$thuLstEx:(.+):(\d$)/) {
		$REFS{'addr_only'} = $1;
		$REFS{'frmRef'} = $2; 
		$REFS{'opit'} = $3; 
		$aChk = 1; last;}	}
			$REFS{'frmRef'} =~ s/(^\s+|\s+$)//; 
			$REFS{'force'} = 1 if $REFS{'addr_only'} =~ /[0-3]/;
	if (($FORM{'aded'} || $FORM{'edtxt'} eq "1" || $FORM{'edrej'} eq "1" || $FORM{'doDB'} eq "1") && &isEdit) { require $admin_pth."admin1.pl"; &edits;}
	elsif ($FORM{'lstall'} eq "1" && &isEdit) {require $admin_pth."admin3.pl"; &show_lst;}
	elsif ($FORM{'srchdel'} eq "y" && $FORM{'lstdel'} eq "delem" && &isEdit) { require $admin_pth."admin2.pl"; &srch_do;}
	elsif (($FORM{'srch'} eq "y" || ($FORM{'next'} && $FORM{'srchdel'} eq "y")) && &isEdit) { require $admin_pth."admin2.pl"; &show_srch;}
	elsif ($FORM{'LnK'} eq "1" || $FORM{'addLnme'} eq "1" || $FORM{'delLnme'} eq "1" || $FORM{'gmted'} || $FORM{'aped'} || $FORM{'gped'}) { require $admin_pth."admin4.pl"; &edits;}
	elsif (":progerrs.pl:redisplay.pl:result.pl:unsubpg.pl:showerrs.pl:" =~ /:$FORM{'F'}:/) { require $admin_pth."admin5.pl"; &show($FORM{'F'})}
	elsif ($FORM{'edF'} eq "1" && $FORM{'fleIs'} && $FORM{'samp'}) { require $admin_pth."admin5.pl"; &saveF($FORM{'fleIs'});}
	elsif ($FORM{'form'} eq "begin" && &isEdit) { require $admin_pth."admin1.pl"; &show_admin;}
	else { require $admin_pth."admin4.pl"; &begin;}

exit(0);
