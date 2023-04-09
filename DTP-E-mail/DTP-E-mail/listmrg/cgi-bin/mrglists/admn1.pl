#admn1.pl
sub get_fnames {
my ($fdir,$fextns,@tmp,$s1) = @_[0,1];
	opendir(DIR,"$fdir") || &err_msg('Error Accessing Lists Directory'); 
		@tmp = grep( /^.+($fextns)$/sg, sort(readdir(DIR)));
	closedir(DIR);
		for ($h1 = 0; $h1 < @tmp; $h1++) {
			if ($fextns eq $mrgdta_exten) {$tmp[$h1] =~ s/\..*$//;}
			else {$tmp[$h1] =~ s/\./$dot/;}	}
return @tmp;
}
sub sent_numb {
	my $s1 = shift; local ($sent);
		$issent = "0"; $ishold = "0"; 
	if (open(DB,"<$mrgdatdir_pth/$s1.db")) {
		($issent,$ishold) = split (/\|/,<DB>);
		$ishold =~ s/\s//g; $sent = $issent + $ishold;
	close (DB);	}
	else {$issent = "."; $ishold = ".";}
return $sent;
}
sub get_frmt {
	my $elst = shift; my ($eis,$f1,$f2,$f3,@ains,$ttl,$dis,$fmt);
		$elst =~ s/[$sep]htm$//i;
	foreach $f2 (@seps) {
		if ($f2 && $elst =~ /[$f2]/g) {
		$f3 = $f2; last;}
	}
		if (!$f3) {$fmt = "3"; $f3 = $sep; return ("$fmt","$f3");}
		elsif ($f3 ne $sep) {$fmt = "5"; return ("$fmt","$f3");}
		@ains = split (/[$sep]/,$elst);
			$ttl = @ains;
		for ($f1 = 0; $f1 < @ains; $f1++) {
			$ains[$f1] =~ s/"//g;
			if ($ains[$f1] =~ /(.*@.*\.[a-zA-Z]{2,3}$)/ && $ains[$f1] !~ /(^\.)|(\.$)|( )|(\.\.)|(@\.)|(\.@)|(@.*@)/ && $ains[$f1] !~ /[$sep]/g) {$eis = $f1;}
			if ($ains[$f1] =~ /\d+\/\d+\/\d+/ && $ains[$f1] =~ /\d+:\d+/) {$dis = $f1;}
		}
			if ($eis == 0 && $dis == 2 && $ttl == 3) {$fmt = "0";}
			elsif ($eis == 0 && $ttl == 2 && !$dis) {$fmt = "1";}
			elsif ($eis == 1 && $ttl == 2 && !$dis) {$fmt = "2";}
			elsif ($eis == 0 && $ttl == 1 && !$dis) {$fmt = "3";}
			elsif ($eis == 0 && $ttl > 1 && $dis == 2) {$fmt = "4";}
			else  {$err_msgs .= "[ <b>$m1</b> ] cannot understand &quot;$elst&quot;<br>";}
	return ("$fmt","$sep");
}
sub show_main {
	@efiles = &get_fnames("$edat_path","$elst_exten");
	@mfiles = &get_fnames("$mrgdatdir_pth","$mrgdta_exten");
print qq~<HEAD><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>ListMerge Administration</title></HEAD>
<script language="JavaScript"><!--
function do_window(pge,wid,hgt) {
  var wsze;
  wsze="toolbar=0,scrollbars=1,resizable=0,width="+wid+",height="+hgt;
    window.open(pge,"",wsze);  }
// -->
</script>
<BODY TEXT="#000000" BGCOLOR="#ededdb" LINK="#0000FF" VLINK="#0000FF">
<h3 align="center"><FONT FACE="arial,geneva,helvetica">ListMerge Administration</FONT></h3>
<center><FONT FACE="arial,geneva,helvetica" SIZE=2><b>&#149; <a href="$hm_url">home</a> &#149; <a href="$theScrpt?accwrd=$theword&frmpwrd=y">Passwords</a> &#149;</b><br><a href="$theScrpt?accwrd=$theword">refresh page</a></FONT</center>
<form method="POST" action="$theScrpt">
	<input type="hidden" name="frmsee" value="y">
	<input type="hidden" name="accwrd" value="$theword">
<CENTER><TABLE WIDTH="590" BORDER="0" CELLSPACING="0" CELLPADDING="0">
      <CAPTION ALIGN="TOP"><FONT FACE="arial,geneva,helvetica">Select a ListMerge File to Edit or Send</font></CAPTION>
  <tr><td align="center">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="2">
  <TR>
    <TD WIDTH="30%" BGCOLOR="#758040" ALIGN="RIGHT"><FONT FACE="arial,geneva,helvetica" color="#ffffff" SIZE=2><B>List Name</B></FONT></TD> 
    <TD WIDTH="55%" BGCOLOR="#758040"><FONT FACE="arial,geneva,helvetica" color="#ffffff" SIZE=2>&nbsp;</FONT></TD>
    <TD WIDTH="10%" BGCOLOR="#758040" ALIGN="center"><FONT FACE="arial,geneva,helvetica" color="#ffffff" SIZE=2>format</FONT></TD>
    <TD WIDTH="5%" BGCOLOR="#758040" ALIGN="center"><FONT FACE="arial,geneva,helvetica" color="#ffffff" SIZE=1>delete</FONT></TD></TR><TR>~;
for ($s1=0; $s1 < @mfiles; $s1++) {
	foreach $s2 (@efiles) {
	if ($mfiles[$s1] eq $s2) {
print "    <TD WIDTH=\"30%\" ALIGN=\"RIGHT\" BGCOLOR=\"#d5e0BB\"><FONT FACE=\"arial,geneva,helvetica\" SIZE=2 color=\"#660000\"><b>".$mfiles[$s1]."</b></FONT></TD>\n";
print "    <TD WIDTH=\"55%\" ALIGN=\"LEFT\" BGCOLOR=\"#d5e0BB\">\&nbsp;\&nbsp;\&nbsp;\&nbsp;<INPUT \n";
print "	 TYPE=\"radio\" NAME=\"view\" VALUE=\"".$mfiles[$s1]."\">\&nbsp;\&nbsp;\&nbsp;\&nbsp;<FONT FACE=\"arial,geneva,helvetica\" SIZE=1 color=\"#333333\">select to view the '".$mfiles[$s1]."' mailing page</font></TD>\n";
print "    <TD WIDTH=\"10%\" ALIGN=\"center\" BGCOLOR=\"#d5e0BB\"><FONT FACE=\"arial,geneva,helvetica\" SIZE=1 color=\"#660000\"><a href=javascript:do_window('$theScrpt?accwrd=$theword&fchk=$mfiles[$s1]','540','400')>check</a></FONT></TD>\n";
print "    <TD WIDTH=\"5%\" ALIGN=\"center\" BGCOLOR=\"#d5e0BB\"><FONT FACE=\"arial,geneva,helvetica\" SIZE=1 color=\"#660000\"><a href=\"$theScrpt?accwrd=$theword&kill=$mfiles[$s1]\">del</a></FONT></TD>\n";
print "  </TR><TR>\n";
} } }
print qq~    <TD WIDTH="100%" colspan="4" ALIGN="CENTER" BGCOLOR="#A5A580">
	<INPUT TYPE="submit" VALUE="Edit or Send Mail">&nbsp;&nbsp;<INPUT TYPE="reset" VALUE="Defaults"></TD> 
  </TR></TABLE></td></tr></TABLE></CENTER></FORM>
<form method="POST" action="$theScrpt">
	<input type="hidden" name="frmmake" value="y">
	<input type="hidden" name="accwrd" value="$theword">
<CENTER><TABLE WIDTH="590" BORDER="0" CELLSPACING="0" CELLPADDING="2">
      <CAPTION ALIGN="TOP"><FONT FACE="arial,geneva,helvetica">Create or ReNew a ListMerge file,<em> <u>or</u> </em>Update with Latest Entries</font></CAPTION>
  <tr><td align="center"><TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="2"><TR>
    <TD WIDTH="4%" BGCOLOR="#758040" ALIGN="CENTER"><B><FONT color="#ffffff" FACE="arial,geneva,helvetica" SIZE=2>#</FONT></B></TD> 
    <TD WIDTH="30%" BGCOLOR="#758040" ALIGN="CENTER"><B><FONT color="#ffffff" FACE="arial,geneva,helvetica" SIZE=2>E-List</FONT></B></TD> 
    <TD WIDTH="5%" BGCOLOR="#90a570" ALIGN="CENTER"><B><FONT COLOR="#CC0000" FACE="arial,geneva,helvetica" SIZE=2>new</FONT></B></TD> 
    <TD WIDTH="5%" BGCOLOR="#90a570" ALIGN="CENTER"><B><FONT FACE="arial,geneva,helvetica" SIZE=2>&nbsp;u/d</FONT></B></TD> 
    <TD WIDTH="30%" BGCOLOR="#758040" ALIGN="CENTER"><B><FONT color="#ffffff" FACE="arial,geneva,helvetica" SIZE=2>Mrg List</FONT></B></TD> 
    <TD WIDTH="6%" BGCOLOR="#758040" ALIGN="CENTER"><B><FONT color="#ffffff" FACE="arial,geneva,helvetica" SIZE=2>Sent</FONT></B></TD> 
    <TD WIDTH="6%" BGCOLOR="#758040" ALIGN="CENTER"><B><FONT color="#ffffff" FACE="arial,geneva,helvetica" SIZE=2>Ready</FONT></B></TD> 
    <TD WIDTH="16%" BGCOLOR="#758040" ALIGN="CENTER"><B><FONT color="#ffffff" FACE="arial,geneva,helvetica" SIZE=2>last&nbsp;sent</B></FONT></TD></TR><TR>~;
$cnt = 0;
foreach $ss (@efiles) {
		if (!($cnt % 2)) {$clr ="d5e0BB";} else {$clr = "c5d0B0";}
			$sent = &sent_numb("$ss");
		undef @eaddrs;
		$f4 = $f1 = $ss; $ecnt = 0;
		$f1 =~ s/[$dot]/\./;
		if (open(EF,"<$edat_path/$f1")) {  
		  eval "flock(EF,2)"; @eaddrs = <EF>; eval "flock(EF,8)"; 
		close(EF);
		}
		else {$ecnt = "<em>err</em>";}
			$ldate = "-"; $lastdate = 0;
		if (&get_txts("$mrgdatdir_pth/$f4$mrgdta_exten") && $lastdate =~ /^\d{3,}$/) {
			$ldate = $lastdate if $lastdate; 
				$ldate =~ s/[^\d*]//g;
				if ($ldate =~ /[\D*]/) {$ldate = "-";}
				else {$ldate = &date_time_real($ldate);}
		}
		else {$ldate = ".";}
		@stt = stat("$edat_path/$f1");
			if ($stt[9] ne $lchg) {$ecnt = "<font color=#B50000><b>".@eaddrs."</b></font>";}
			else {$ecnt = @eaddrs;}
	$f3 = "--";
	foreach $f2 (@mfiles) {if ($f4 eq $f2) {$f3 = $f2;}	}
	if ($f3 eq "--" || $issent eq ".") {$btn = "       &nbsp;</TD>";}
	else {$btn = "      <INPUT TYPE=\"radio\" NAME=\"ow$cnt\" VALUE=\"$f4.u\"></TD>";}

print qq~    <TD WIDTH="4%" BGCOLOR="#$clr" ALIGN="CENTER"><FONT FACE="arial,geneva,helvetica" SIZE=2>$ecnt</FONT></TD> 
    <TD WIDTH="30%" BGCOLOR="#$clr" ALIGN="CENTER"><FONT FACE="arial,geneva,helvetica" SIZE=2>$f1</FONT></TD> 
    <TD WIDTH="5%" BGCOLOR="#$clr" ALIGN="CENTER"><INPUT TYPE="radio" NAME="ow$cnt" VALUE="$f4.o"></TD> 
    <TD WIDTH="5%" BGCOLOR="#$clr" ALIGN="CENTER">
$btn
    <TD WIDTH="30%" BGCOLOR="#$clr" ALIGN="CENTER"><FONT FACE="arial,geneva,helvetica" SIZE=2>$f3</FONT></TD> 
    <TD WIDTH="7%" BGCOLOR="#$clr" ALIGN="CENTER"><FONT FACE="arial,geneva,helvetica" SIZE=2>$issent</FONT></TD> 
    <TD WIDTH="7%" BGCOLOR="#$clr" ALIGN="CENTER"><FONT FACE="arial,geneva,helvetica" SIZE=2>$ishold</FONT></TD> 
    <TD WIDTH="16%" BGCOLOR="#$clr" ALIGN="CENTER"><FONT FACE="arial,geneva,helvetica" SIZE=1>$ldate</FONT></TD></TR><TR>~;
	$cnt++;
}
print qq~    <TD WIDTH="100%" colspan="9" ALIGN="CENTER" BGCOLOR="#A5A580"><FONT FACE="arial,geneva,helvetica" SIZE=2><small>admin PWrd:</small></FONT>
	<input type="password" name="adminspwrd" size="12" maxlength="15">&nbsp;&nbsp;<INPUT TYPE="submit" VALUE="Create-Replace / Update">&nbsp;&nbsp;<INPUT TYPE="reset" VALUE="Defaults"></TD> 
  </TR><tr>
    <td WIDTH="100%" colspan="9"><FONT FACE="arial,geneva,helvetica" SIZE=1><ul>
      <li><FONT FACE="arial,geneva,helvetica" SIZE=1>Use the "New" button to either create the data files for a new list, or &quot;reset&quot; the 
      list copy between mail-outs ( do not use &quot;new&quot; if a mail-out is incomplete ).</font></li>
      <li><FONT FACE="arial,geneva,helvetica" SIZE=1>If part way through a mail-out and the left hand number is in bold indicating changes to the original e-mail list, 
      use the &quot;Update&quot; button <u>only</u> to ADD new additions to a list arrived since a mail-out began; <font color="#CC0000">slow on large lists!</font></font></li>
      <li><FONT FACE="arial,geneva,helvetica" SIZE=1>A new e-mail list will not appear in the top panel until data files are activated by the &quot;New&quot; option.</font></li>
      <li><FONT FACE="arial,geneva,helvetica" SIZE=1> A number in <u>both</u> the &quot;Sent&quot; and &quot;Ready&quot; to send columns indicates an incomplete mail-out.</font></li>
      </ul></font></td></tr>
</TABLE></td></tr></TABLE></CENTER></FORM>
<center><FONT FACE="arial,geneva,helvetica" SIZE=2><b>&#149; <a href="$hm_url">home</a> &#149; <a href="$theScrpt?accwrd=$theword&frmpwrd=y">Passwords</a> &#149;</b><br><a href="$theScrpt?accwrd=$theword">refresh page</a></FONT></center>
<p align="center"><FONT FACE="arial,geneva,helvetica" SIZE=1>ListMerge v2 copyright</FONT></p></BODY></HTML>~; exit;
}
sub do_del {
	opendir(DIR,"$mrgdatdir_pth") || &err_msg('Error Reading Data Directory'); 
		@tmp = grep( /^$FORM{'fdel'}\..*$/sg, sort(readdir(DIR))); closedir(DIR);
		foreach $s1 (@tmp) {unlink "$mrgdatdir_pth/$s1";}
	opendir(DIR,"$mrgdatdir_pth") || &err_msg('Error Reading Data Directory'); 
		@tmp = grep( /^$FORM{'fdel'}\..*$/sg, sort(readdir(DIR))); closedir(DIR);
	if (@tmp) {&err_msg('Could not delete all files</b>...<br>Close this window and<br>delete them manually via FTP!<b>');}
	&show_main;
}
sub do_makem {
	&chk_allow;
if ($FORM{'frmmake'} eq "y") {
		my ($m0,$m1,$m2,$m3,$m4,$m5);
	foreach $m1 (keys(%FORM)) {if ($m1 =~ /^ow[0-9]/) {push (@fnames,$FORM{$m1});} }
	if (!@fnames) {&err_msg('No Renew / Udate files specified');}
	foreach $m1 (@fnames) {
		$m2 = "";
		if ($m1 =~ /(\.o|\.u)/) {
		$m2 = $1; 
		$m1 =~ s/(\.o|\.u)//g ; 
		$m3 = $m1;
		$m1 =~ s/[$dot]/\./g;}
			&get_txts("$mrgdatdir_pth/$m3$mrgdta_exten");
				
	if ($m2 eq ".o") {
		if (open(FE,"<$edat_path/$m1")) {
		  eval "flock(FE,2)"; @file = <FE>; eval "flock(FE,8)";
		close(FE);	}
		else {$err_msgs .= "</b>[$m1] <b>MailList File Access error<br>\n";}

				if (!( -s "$mrgdatdir_pth/$m3$mrgdta_exten")) {
					($addr_only,$div) = &get_frmt("$file[0]","");
					if (open(DF,">$mrgdatdir_pth/$m3$mrgdta_exten")) { 
					$lastdate = "0"; $doprvw = "1"; $maxsend = "20"; $boxwidth = "66";
						&df_file("$lastdate","$doprvw","$maxsend","$boxwidth","$efrom","$subject","$hdr","$emsg","$sig","$addr_only","$nomerge","$staylve","$html","$frmhtm","$div","$lchg","$Org");
					close(DF); }
 					else {$err_msgs .= "[$m3] Unable to Create Data File<br>\n";}	}
		
			if (open(FN,">$mrgdatdir_pth/$m3$mrgLst_exten")) {
			eval "flock(FN,2)"; 
			  	foreach $m9 (@file) {
			  		chomp ($m9); $m9 =~ s/"//g; 
			  		if ($div eq $sep || !$div) {print FN "$m9\n";}
			  		else {($m9,$trash) = split (/[$div]/,$m9); print FN "$m9\n";}
			  	}
			eval "flock(FN,8)";
			close(FN);	}
			else {$err_msgs .= "</b>[$m3]<b> Cannot Create New list<br>\n";}

			if (open(DB,">$mrgdatdir_pth/$m3.db")) {
				print DB "0|".@file;
			close (DB);	}
			else {$err_msgs .= "</b>[$m3]<b> Cannot Create count DB<br>\n";}

			@stt = stat("$edat_path/$m1");
		if (-s "$mrgdatdir_pth/$m3$mrgdta_exten" && open(DF,">$mrgdatdir_pth/$m3$mrgdta_exten")) { 
			&df_file("$lastdate","$doprvw","$maxsend","$boxwidth","$efrom","$subject","$hdr","$emsg","$sig","$addr_only","$nomerge","$staylve","$html","$frmhtm","$div","$stt[9]","$Org");
		close(DF); }
		else {$err_msgs .= "</b>[$m3$mrgdta_exten]<b> Cannot Update last-change data<br>\n";}
	}
	elsif ($m2 eq ".u") {
		my ($numb);
		if (open(FN,"<$mrgdatdir_pth/$m3$mrgLst_exten")) {
			 eval "flock(FN,2)"; @mfile = <FN>; eval "flock(FN,8)";
		close(FN); }
		else {$err_msgs .= "</b>[$m3]<b> Cannot Read list file<br>\n";}
				$numb = @mfile;
			
			if (open(FE,"<$edat_path/$m1")) {
			  eval "flock(FE,2)"; @efile = <FE>; eval "flock(FE,8)";
			close(FE); }
			else {$err_msgs .= "</b>[$m1]<b> Mail List Read Access<br>\n";}

			foreach $m0 (@efile) {
				if ($addr_only eq "5") {($m5) = split(/[$div]/,$m0);}
				elsif ($addr_only eq "2") {($scrap,$m5) = split(/[$div]/,$m0);}
				else {($m5,$scrap) = split(/[$div]/,$m0);}
			$m4 = 0;
				chomp ($m5);
				for($cnt = 0; $cnt < @mfile; $cnt++) {
					if ($mfile[$cnt] =~ /(^|$sep)$m5($sep|$)/) {$m4 = 1; last;}
				}
				if (!$m4) {
					if ($addr_only eq "5") {push(@mfile,$m5."\n");}
					else {push(@mfile,$m0);}
			}	}

			if (@mfile > $numb) {
				if (-e "$mrgdatdir_pth/$m3$mrgLst_exten" && open(FN,">$mrgdatdir_pth/$m3$mrgLst_exten")) {
					 eval "flock(FN,2)"; print FN @mfile; eval "flock(FN,8)";
				close(FN); }
				else {$err_msgs .= "</b>[$m3]<b> Cannot Over-Write list file<br>\n";}

					if (open(DB,"+<$mrgdatdir_pth/$m3.db")) {
						($tmp,$trash) = split (/\|/,<DB>);
						$trash =~ s/\s//g; seek(DB,0,0); truncate(DB,0); print DB "$tmp|".($trash + (@mfile - $numb));
					close (DB);	}
					else {$err_msgs .= "</b>[$m3.db]<b> Cannot Open count DB<br>\n";}
				@stt = stat("$edat_path/$m1");
				if ($stt[9] && (-s "$mrgdatdir_pth/$m3$mrgdta_exten") && open(DF,">$mrgdatdir_pth/$m3$mrgdta_exten")) { 
						&df_file("$lastdate","$doprvw","$maxsend","$boxwidth","$efrom","$subject","$hdr","$emsg","$sig","$addr_only","$nomerge","$staylve","$html","$frmhtm","$div","$stt[9]","$Org");
					close(DF); }
				else {$err_msgs .= "</b>[$m3$mrgdta_exten]<b> Cannot Update last-change data<br>\n";}
	} }		}
	if ($err_msgs) {&errs;}
}
else {&err_msg('Option Not Recognised!');}
	&show_main;
}
1;
