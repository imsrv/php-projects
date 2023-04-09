#!/usr/bin/perl

#       Welcome to the www.dtp-aus.com ListMerge script - v2 March 2000      #
#  IMPORTANT INFORMATION THAT MUST BE READ IF YOU WISH TO USE THESE SCRIPTS  #
##############################################################################
# The program "LSTMRGE.CGI" was written (c) by Ron F Woolley, Melbourne      #
# Australia. Copyright 1998'99 2000. This script can be altered for private  #
# site use or commercial site use, EXCEPT THAT:                              #
# ALL COPYRIGHT NOTICES must remain in the code, visible on all output pages,#
# AND ALL of the header notices MUST REMAIN intact as is,                    #
# AND using the script without first reading the README.HTM, is prohibited.  #
#                                                                            #
# Australian copyright is recognised/supported in over 130 countries...      #
# per the Berne Convention and other treaties ( including USA! )             #
#                                                                            #
#  The scripts and associated files REMAIN the property of Ron F Woolley.    #
#  NO PROFIT what so ever is to be gained from users of these scripts for    #
#  installation of these scripts, except that a reasonable minimal charge    #
#  for installation MAY be allowed. Supply, per installation, is directly    #
#  from dtp-aus.com ONLY. Remote hosting of this program/resources is        #
#  strictly not allowed. Installation on anothers behalf of altered          #
#  ListMerge code or copy of parts of ListMerge code is strictly forbidden.  #
#  Ron Woolley, the author, MUST be notified via the addresses/URLs below    #
#  if any gain is to be made for the installation of these scripts.          #
#                                                                            #
##############################################################################
# NOTE: If you use these files, you do so entirely at your own risk, and     #
# take on full responsibility for the consequences of using the described    #
# files. You must first agree that Ron Woolley / HostingNet, the only        #
# permitted supplier of this and/or accompanying files is exempt from any    #
# responsibility for all or any resulting problems, losses or costs caused   #
# by your using these or any associated files. If you disagree with ANY of   #
# the included requirements, you must IMMEDIATELY DESTROY ALL FILES.         #
##############################################################################
#  This program scripts are free to use   Copyright notices must remain      #
##############################################################################
# These program scripts are free-to-use, but if you use them, a donation to  #
# the author would be appreciated and help in continuing support for         #
# ListMerge and the creation of other scripts for users of the internet.     #
# An on-line Visa / MasterCard payment cart is available for support         #
# donations and low cost program installations.                              #
##############################################################################
# Support Information is available at:                                       #
#      http://www.dtp-aus.com/cgiscript/scrpthlp.htm                         #
# Files from:                                                                #
#      http://www.dtp-aus.com/cgiscript/lmrgscpt.shtml                       #
# All script descriptions are at:                                            #
#      http://www.dtp-aus.com/cgiscript/allcgi.shtml                         #
#   THESE FILES can only be obtained via the above web addresses, and MUST   #
#      NOT BE PASSED ON TO OTHERS in any form by any means what so ever.     #
#           This does not contradict any other statements above.             #
##############################################################################
# TO KEEP IT FREE, WE NEED your support on link and resource listing sites!  #

#--- Alter these four paths only, if needed! ---------------------#
	if (-s "sets/gmtset.pl") {require "sets/gmtset.pl";} else {print "Content-type: text/html\n\n"; print "Missing/Bad Path to GMTime file\n"; exit;}
	if (-s "sets/lmrgeset.pl") {require "sets/lmrgeset.pl";} else {print "Content-type: text/html\n\n"; print "Missing/Bad Path to Config file\n"; exit;}
#--- Do Not make any changes below this line. -------------------#

sub pwrd {
if ($_[0] ne $theword) {&ask_word;}
else {return 1;}
}
sub chk_allow {
if (!( -e "$adminword_pth")) {open(FF,">>$adminword_pth") || &err_msg('Missing ADMIN Password File'); print FF "Do NOT Edit\n"; close(FF);}
	open(ADMwrd, "<$adminword_pth") || &err_msg('ADMIN Password File Access');
 	  eval "flock (ADMwrd,2)"; @theAword = <ADMwrd>; eval "flock (ADMwrd,8)";
	close(ADMwrd);
	if ($theAword[1] || $FORM{'adminspwrd'}) {
		if (crypt($FORM{'adminspwrd'},"$FORM{'adminspwrd'}") ne $theAword[1]) {&err_msg('Incorrect ADMIN Password');}
	}
}
sub get_txts {
		local $s1 = shift; local $s2;
		$lastdate = $doprvw = $maxsend = $boxwidth = $efrom = $subject = $hdr = $emsg = $sig = $addr_only = $nomerge = $staylve = $html = $frmhtm = $div = $lchg = $Org = "";
	if (open(FM,"<$s1")) { 
			eval "flock(FM,2)";
		while ($lins = <FM>) {
			if ($lins =~ /^%%::%%$/) {$s2 = 0; next;}
				chomp($lins) if $s2 < 7;
			if ($lins =~ /^LST::DTE$/) {$s2 = 1; next;}
			elsif ($lins =~ /^DO::PRV$/) {$s2 = 2; next;}
			elsif ($lins =~ /^MX::SND$/) {$s2 = 3; next;}
			elsif ($lins =~ /^BX::WID$/) {$s2 = 4; next;}
			elsif ($lins =~ /^EML::FRM$/) {$s2 = 5; next;}
			elsif ($lins =~ /^EML::SBJ$/) {$s2 = 6; next;}
			elsif ($lins =~ /^LTR::HDR$/) {$s2 = 7; next;}
			elsif ($lins =~ /^LTR::MSG$/) {$s2 = 8; next;}
			elsif ($lins =~ /^LTR::SIG$/) {$s2 = 9; next;}
			elsif ($lins =~ /^LST::FMT$/) {$s2 = 10; next;}
			elsif ($lins =~ /^NO::MRG$/) {$s2 = 11; next;}
			elsif ($lins =~ /^STY::LVE$/) {$s2 = 12; next;}
			elsif ($lins =~ /^LTR::HTM$/) {$s2 = 13; next;}
			elsif ($lins =~ /^FRM::HTM$/) {$s2 = 14; next;}
			elsif ($lins =~ /^LST::DIV$/) {$s2 = 15; next;}
			elsif ($lins =~ /^LST::CHG$/) {$s2 = 16; next;}
			elsif ($lins =~ /^NME::ORG$/) {$s2 = 17; next;}
			elsif ($s2 == 1) {$lastdate = $lins; next;}
			elsif ($s2 == 2) {$doprvw = $lins; next;}
			elsif ($s2 == 3) {$maxsend = $lins; next;}
			elsif ($s2 == 4) {$boxwidth = $lins; next;}
			elsif ($s2 == 5) {$efrom = $lins; next;}
			elsif ($s2 == 6) {$subject = $lins; next;}
			elsif ($s2 == 7) {$hdr .= $lins; next;}
			elsif ($s2 == 8) {$emsg .= $lins; next;}
			elsif ($s2 == 9) {$sig .= $lins; next;}
			elsif ($s2 == 10) {$addr_only = $lins; next;}
			elsif ($s2 == 11) {$nomerge = $lins; next;}
			elsif ($s2 == 12) {$staylve = $lins; next;}
			elsif ($s2 == 13) {$html .= $lins; next;}
			elsif ($s2 == 14) {$frmhtm = $lins; next;}
			elsif ($s2 == 15) {$div = $lins; next;}
			elsif ($s2 == 16) {$lchg = $lins; next;}
			elsif ($s2 == 17) {$Org = $lins; next;}
		}
			eval "flock(FM,8)";
		close(FM);
	chomp ($lastdate,$doprvw,$maxsend,$boxwidth,$efrom,$subject,$hdr,$emsg,$sig,$addr_only,$nomerge,$staylve,$html,$frmhtm,$div,$lchg,$Org);
	return (1);
	}
return (0);
}
sub df_file {
	print DF "LST::DTE\n".($_[0])."\n%%::%%\n";
	print DF "DO::PRV\n".($_[1])."\n%%::%%\n";
	print DF "MX::SND\n".($_[2])."\n%%::%%\n";
	print DF "BX::WID\n".($_[3])."\n%%::%%\n";
	print DF "EML::FRM\n".($_[4])."\n%%::%%\n";
	print DF "EML::SBJ\n".($_[5])."\n%%::%%\n";
	print DF "LTR::HDR\n".($_[6])."\n%%::%%\n";
	print DF "LTR::MSG\n".($_[7])."\n%%::%%\n";
	print DF "LTR::SIG\n".($_[8])."\n%%::%%\n";
	print DF "LST::FMT\n".($_[9])."\n%%::%%\n";
	print DF "NO::MRG\n".($_[10])."\n%%::%%\n";
	print DF "STY::LVE\n".($_[11])."\n%%::%%\n";
	print DF "LTR::HTM\n".($_[12])."\n%%::%%\n";
	print DF "FRM::HTM\n".($_[13])."\n%%::%%\n";
	print DF "LST::DIV\n".($_[14])."\n%%::%%\n";
	print DF "LST::CHG\n".($_[15])."\n%%::%%\n";
	print DF "NME::ORG\n".($_[16])."\n%%::%%\n";
}
sub chk_addr {
    local($chk) = shift; 
    if ($chk =~ /(.*@.*\.[a-zA-Z]{2,3}$)/ && $chk !~ /(^\.)|(\.$)|( )|(\.\.)|(@\.)|(\.@)|(@.*@)/) { return(1); }
	elsif ($chk =~ m/$sep/g) { return(1); } 
    else { return(0); }
}
sub check_method {
	if ( $ENV{'REQUEST_METHOD'} eq 'GET' ) { $query_string = $ENV{'QUERY_STRING'}; } 
  	elsif ( $ENV{'REQUEST_METHOD'} eq 'POST' ) { read(STDIN,$query_string,$ENV{'CONTENT_LENGTH'}); }
	else { &err_msg('Request Method'); }
}
sub check_ref {
	$crf = 0;
	if ($ENV{'HTTP_REFERER'}) {
        foreach $referer (@referers) {
            if ($ENV{'HTTP_REFERER'} =~ m|^\Ahttps?://$referer|i) {
                $crf = 1;
                last;
      }      }  }
	if ($crf eq 0) {&err_msg('</b>[ Bad Referrer ] <b>Remote Access denied<br></b>...use only links or forms ON the site.<b>');}
}
sub date_time_real {
   local($intime) = @_;
   ($min,$hour,$mday,$mon) = (gmtime($intime))[1,2,3,4]; $mon++;
	if ($dtUS eq "1") {return sprintf("%02d\/%02d\&nbsp;%02d:%02d",$mon,$mday,$hour,$min);}
	else {return sprintf("%02d\/%02d\&nbsp;%02d:%02d",$mday,$mon,$hour,$min);}
}
sub ask_word {
	print qq~<HEAD><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"></HEAD><BODY text="#000000" BGCOLOR="#ededdb"><CENTER><p>&nbsp;<br>~; if ($FORM{'fchk'} || $FORM{'dotype'}) {print qq~&nbsp;<br><FONT FACE="verdana,arial,geneva,helvetica" size="3"><b>Access Permission denied!</b><p><font size="2">please close this window</font></font></CENTER></BODY></HTML>~; exit;}
	print qq~&nbsp;<FORM METHOD="POST" ACTION="$theScrpt"><TABLE WIDTH="300" BORDER="0" CELLSPACING="0" CELLPADDING="1"><TR><Th WIDTH="100%" BGCOLOR="#992515"><FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" size="2">Please Submit Access Password</FONT></Th>~;
	print qq~</TR><TR><TD WIDTH="100%" ALIGN="CENTER" BGCOLOR="#d5e0BB"><TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2"><TR><TD WIDTH="100%" ALIGN="CENTER"><INPUT NAME="accwrd" TYPE="password" SIZE="15" MAXLENGTH="15">&nbsp;&nbsp;&nbsp;<INPUT TYPE="submit" VALUE="Enter Admin"></TD></TR></TABLE></TD></TR></TABLE></FORM></CENTER></BODY></HTML>~; exit;}
sub errs {
	print qq~<head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>Error Response</title></head><body bgcolor="#ededdb" text="#000000" link="#0000FF" vlink="#0000FF"><center><p>&nbsp;</p><table cellpadding="1" cellspacing="2" border="0"><tr><td bgcolor="#fdfdeb"><font face="verdana, arial, geneva, helvetica" size="3"><b>&nbsp;ListMerge <font color="#CC0000">Error Response</font></b></font></td></tr><tr><td><blockquote><p>&nbsp;<br><font size="2" face="arial,helvetica,geneva">$err_msgs</font></p></blockquote></td></tr><tr bgcolor="#CCCCCC"><td align=center><font size="2" face="arial,helvetica,geneva">Link back to the ~;
	print qq~<A HREF="$theScrpt?accwrd=$theword"><b>Main Lists Page</b></a></font></td></tr><tr bgcolor="#CCCCCC"><td align=center><font size="2" face="arial,helvetica,geneva">Link back to the <A HREF="$theScrpt?accwrd=$theword&frmpwrd=y"><b>Passwords Page<b></a></font></td></tr><tr bgcolor="#666666"><td align=center><font size="2" face="arial,helvetica,geneva" color="#FFFFFF">&nbsp;<b>Back Arrow</b> to return to a <b>Mailing Page</b>. <em>Thank you.&nbsp;</em></font></td></tr><tr><td align=center><font face="arial,geneva,helvetica" size="1" color="#808080">ListMerge v2 copyright</font></td></tr></table></center></body></html>~; exit;}
sub err_msg {
	print qq~<head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>Error Response</title></head><body bgcolor="#ededdb" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000"><center><h3>&nbsp;</h3><table cellpadding="1" cellspacing="2" border="0"><tr><td bgcolor="#fdfdeb"><font face="verdana, arial, geneva, helvetica" size="3"><b>&nbsp;ListMerge <font color="#FF0000">Error Response</font></b></font></td></tr><tr><td><font size="2" face="arial,helvetica,geneva"><p align="center"><b>&nbsp;The program has responded with an error&nbsp;</b></p></font><dl><dt><font size="2" face="arial,helvetica,geneva">The result is:</font></dt><dd><font size="2" face="arial,helvetica,geneva"><font color="#CC0000"><b>$_[0]</b></font></font></dd></dl></td></tr>~;
	print qq~<tr bgcolor="#CCCCCC"><td align=center><font size="2" face="arial,helvetica,geneva">Link back to the <A HREF="$theScrpt?accwrd=$theword"><b>Main Lists Page</b></a></font></td></tr><tr bgcolor="#CCCCCC"><td align=center><font size="2" face="arial,helvetica,geneva">Link back to the <A HREF="$theScrpt?accwrd=$theword&frmpwrd=y"><b>Passwords Page<b></a></font></td></tr><tr bgcolor="#666666"><td align=center><font size="2" face="arial,helvetica,geneva" color="#FFFFFF">&nbsp;<b>Back Arrow</b> to return to a <b>Mailing Page</b>. <em>Thank you.&nbsp;</em></font></td></tr><tr><td align=center><font face="arial,geneva,helvetica" size="1" color="#808080">ListMerge v2 copyright</font></td></tr></table></center></body></html>~; exit;}

	$dot = "-"; $sty = 50;
		$| = 1;
			print "Content-type: text/html\n\n"; print "<HTML>";
	&check_method;
	@pairs = split(/&/, $query_string);
	foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/~!/ ~!/g;
		$value =~ s/<!--#(.|\n)*-->//g;
		$name =~ s/(`|\\|\.?\.\/|\0)//sg;
		$value =~ s/(`|\\|\.?\.\/|\0)//sg;
	$FORM{$name} = $value;
	}
		&pwrd($FORM{'accwrd'}); 
			$mrgdatdir_pth =~ s/(\\|\/)$//g;
			$edat_path =~ s/(\\|\/)$//g;
				$mrgdta_exten = ".md"; $mrgLst_exten = ".ml";
	if ($FORM{'fchk'}) {require "$mrgdatdir_pth/admn4.pl"; &shw_chk;}
	elsif ($FORM{'kill'}) {require "$mrgdatdir_pth/admn4.pl"; &shw_del;}
		&check_ref ; 
	if ($FORM{'frmpwrd'} eq "y") {require "$mrgdatdir_pth/admn3.pl"; &do_words;}
	elsif ($FORM{'frmsee'} eq "y") {require "$mrgdatdir_pth/admn2.pl"; &show_mail;}
	elsif ($FORM{'frmtxt'} eq "y") {require "$mrgdatdir_pth/admn2.pl"; &save_txts;}
	elsif ($FORM{'frmsend'} eq "y") {require "$mrgdatdir_pth/admn5.pl"; &sendem;}
	elsif ($FORM{'test'} eq "y" && $FORM{'view'} ne "") {require "$mrgdatdir_pth/admn5.pl"; &sendem;}
	elsif ($FORM{'aped'} eq "y" || $FORM{'gped'} eq "y" || $FORM{'gmed'} eq "y") {require "$mrgdatdir_pth/admn3.pl"; &edits;}
	elsif ($FORM{'frmmake'} eq "y") {require "$mrgdatdir_pth/admn1.pl"; &do_makem;}
	elsif ($FORM{'dotype'}) {require "$mrgdatdir_pth/admn4.pl"; &change_chk;}
	elsif ($FORM{'fdel'}) {require "$mrgdatdir_pth/admn1.pl"; &do_del;}
	else {require "$mrgdatdir_pth/admn1.pl"; &show_main;}
exit(0);
