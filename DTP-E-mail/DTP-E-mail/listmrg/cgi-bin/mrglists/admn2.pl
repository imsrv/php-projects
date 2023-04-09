#admn2.pl
sub sent_numb {
	local $s1 = shift; local ($sent);
		$issent = "0"; $ishold = "0"; 
	if (open(DB,"<$mrgdatdir_pth/$s1.db")) {
		($issent,$ishold) = split (/\|/,<DB>);
		$ishold =~ s/\s//g; $sent = $issent + $ishold;
	close (DB);	}
	else {$issent = "."; $ishold = ".";}
return $sent;
}
sub detag_prv {
$do = shift; 
	$do =~ s|<<email>>|member\@domain.nme|g;
	$do =~ s|<<ename>>|Members Name|g;
	$do =~ s|<<edate>>|06/11/1999 - 06:04|g;
	$do =~ s/\&/\&amp\;/g;
	$do =~ s/"/\&quot\;/g;
	$do =~ s/</\&lt\;/g;
	$do =~ s/>/\&gt\;/g;
	$do =~ s/©/\&\#169\;/g;
	$do =~ s/®/\&\#174\;/g;
	$do =~ s/™/\&\#153\;/g;
	$do =~ s/\cM\n/\n/g;
	chomp($do);
	$do =~ s/\n\n/<p>/g;
	$do =~ s/\n/<br>/g;
return $do;
}
sub show_mail {
	if ($FORM{'view'}) {$s1 = $FORM{'view'};}
	else {&err_msg("You must select a ListMerge data file");}
	if (!&get_txts("$mrgdatdir_pth/$s1$mrgdta_exten")) {&err_msg("($s1$mrglst_exten) Read Access");}
	if ($doprvw) {$doprvw = "checked";}
	if ($lastdate) {$ldate = &date_time_real($lastdate);} else {$ldate = "N/A";}
		if (!$addr_only || $addr_only eq "4") {$dteclr = "000099";} else {$dteclr = "c5c5c5";} 
		if ($addr_only < "3") {$nmeclr = "000099";} else {$nmeclr = "c5c5c5";} 
#		if (!$nmeclr && $dteclr) {$nmeclr = "c5c5c5"; $dteclr = "c5c5c5";} 
	&sent_numb("$s1");
	$chks1 = "checked" if $nomerge; $chks2 = "checked" if $staylve; $chks3 = "checked" if $frmhtm;
 print qq~<HEAD><TITLE>ListMerge Setup and Send</TITLE></HEAD><BODY text="#000000" BGCOLOR="#ededdb" link="#0000FF" vlink="#0000FF"><H3 align="center"><FONT FACE="arial,geneva,helvetica">ListMerge Merge-File Set Up</FONT></H3>
<CENTER><FONT SIZE="2" FACE="arial,geneva,helvetica"><B>&#149; <A HREF="$theScrpt?accwrd=$theword">Main Page</A> &#149; <A HREF="$theScrpt?accwrd=$theword&frmpwrd=y">Passwords</A> &#149;</B></FONT></CENTER>
<FORM METHOD="POST" ACTION="$theScrpt">
   <INPUT TYPE="hidden" NAME="frmsend" VALUE="y">
   <INPUT TYPE="hidden" NAME="accwrd" VALUE="$theword">
   <INPUT TYPE="hidden" NAME="view" VALUE="$s1">
<CENTER><TABLE WIDTH="590" BORDER="1" CELLSPACING="0" CELLPADDING="0">
  <CAPTION ALIGN="TOP"><FONT SIZE="3" FACE="arial,geneva,helvetica">SEND Mail to current <b>$s1$mrglst_exten</b> list</FONT></CAPTION>
  <tr><td align="center">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="2"><TR>
   <TD WIDTH="30%" ALIGN="CENTER" VALIGN="TOP" BGCOLOR="#007777">
    <FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" SIZE="2">Sent: <B><big>$issent</big></B></FONT></TD>
    <TD WIDTH="30%" ALIGN="CENTER" VALIGN="TOP" BGCOLOR="#007777">
    <FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" SIZE="2">Waiting: <B><big>$ishold</big></B></FONT></TD>
    <TD WIDTH="40%" ALIGN="CENTER" VALIGN="TOP" BGCOLOR="#007777">
    <FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" SIZE="2">Last sent: $ldate</FONT></TD>
  </TR><TR>
    <TD WIDTH="100%" COLSPAN="3" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><FONT FACE="arial,geneva,helvetica" SIZE="2">Enter the <b>Maximum Batch Total</b>:</FONT>
    <INPUT NAME="max" TYPE="text" SIZE="5" MAXLENGTH="4" VALUE="$maxsend"> <FONT FACE="arial,geneva,helvetica" SIZE=1> - Use this option to reduce Server Load</FONT></TD>
  </TR><TR><TD WIDTH="100%" COLSPAN="3" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr><td width="50%"><input type="checkbox" name="nomrge" value="1" $chks1><font face="arial, geneva, helvetica" size="2"><b>NO Merge</b></font><font face="arial, geneva, helvetica" size="1"> Disables field checking; <font color="#CC0000">REMOVE ALL</font> field markers from the header/body/signature texts.</font></td>
     <td width="50%"><input type="checkbox" name="stay" value="1" $chks2><font face="arial, geneva, helvetica" size="2"><b>Keep Alive</b></font><font face="arial, geneva, helvetica" size="1"> The program sends data to the browser during mailing - <font color="#CC0000">Read the readme page</font>.</font></td>
     </tr></table></TD></TR><TR>
    <TD WIDTH="100%" COLSPAN="3" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#cccccc"><FONT FACE="arial,geneva,helvetica" SIZE=2>admin PWrd:</FONT>
    <input type="password" name="adminspwrd" size="12" maxlength="15">&nbsp;&nbsp;
    <INPUT TYPE="submit" VALUE="Send Next Batch now">&nbsp;&nbsp;<INPUT TYPE="reset" VALUE="Reset"></TD>
  </TR></TABLE></td></tr></table></CENTER></form>

<form method="post" action="$theScrpt"><INPUT TYPE="hidden" NAME="accwrd" VALUE="$theword"><INPUT TYPE="hidden" NAME="view" VALUE="$s1"><INPUT TYPE="hidden" NAME="test" VALUE="y">
  <center><TABLE WIDTH="590" BORDER="1" CELLSPACING="0" CELLPADDING="0" align="center"><tr><td align="center"><TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="2">
   <TR><TD WIDTH="100%" ALIGN="CENTER" VALIGN="TOP" BGCOLOR="#007777" colspan="3"><FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" SIZE="2"><b>Send yourself TEST MAIL</b> - one or two depending on format and entries below</FONT></TD>
   </TR><TR><TD WIDTH="100%" COLSPAN="3" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#cccccc"><FONT FACE="arial,geneva,helvetica" SIZE=2>admin PWrd:</FONT>
  <input type="password" name="adminspwrd" size="12" maxlength="15">&nbsp;&nbsp;<INPUT TYPE="submit" VALUE="Send Test"></TD>
 </TR></TABLE></td></tr></table></center></form>

<FORM METHOD="POST" ACTION="$theScrpt">
   <INPUT TYPE="hidden" NAME="frmtxt" VALUE="y">
   <INPUT TYPE="hidden" NAME="accwrd" VALUE="$theword">
   <INPUT TYPE="hidden" NAME="max" VALUE="$maxsend">
   <INPUT TYPE="hidden" NAME="view" VALUE="$s1">
   <INPUT TYPE="hidden" NAME="dte" VALUE="$lastdate">
   <INPUT TYPE="hidden" NAME="addrFmt" VALUE="$addr_only">
   <INPUT TYPE="hidden" NAME="nomrge" VALUE="$nomerge">
   <INPUT TYPE="hidden" NAME="stay" VALUE="$staylve">
   <INPUT TYPE="hidden" NAME="div" VALUE="$div">
   <INPUT TYPE="hidden" NAME="lchg" VALUE="$lchg">
<CENTER><TABLE WIDTH="590" BORDER="1" CELLSPACING="0" CELLPADDING="0">
  <CAPTION ALIGN="TOP"><FONT SIZE="3" FACE="arial,geneva,helvetica">SET UP E-Mail Body-Text in <b>$s1$mrgdta_exten</b> data file</FONT></CAPTION>
  <tr><td align="center">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="2"><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#007777">
    <FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" SIZE="2">Mail header 'From' address and 'Subject' line (do not appear in texts)</FONT></TD>
  </TR><TR>
    <TD WIDTH="100%" colspan="2" ALIGN="right" BGCOLOR="#e6f1f1"><font FACE="arial,geneva,helvetica" size="3" $colr><b>From Address<b></font> </TD>
    <TD WIDTH="100%" colspan="3" BGCOLOR="#e6f1f1"><FONT FACE="arial,geneva,helvetica" SIZE="1">a different 'from' address can be used for each mail list<br>
    </FONT><INPUT NAME="from" TYPE="text" SIZE="35" MAXLENGTH="50" VALUE="$efrom">$coltxt</TD>
  </TR><TR>
    <TD WIDTH="100%" colspan="2" ALIGN="right" BGCOLOR="#e6f1f1"><font FACE="arial,geneva,helvetica" size="3"><b>Subject<b></font> </TD>
    <TD WIDTH="100%" colspan="3" BGCOLOR="#e6f1f1"><FONT FACE="arial,geneva,helvetica" SIZE="1">do not use field markers in the Subject line<br>
    </FONT><INPUT NAME="sbjct" TYPE="text" SIZE="45" MAXLENGTH="50" VALUE="$subject"></TD>
  </TR><TR>
    <TD WIDTH="100%" colspan="2" ALIGN="right" BGCOLOR="#e6f1f1"><font FACE="arial,geneva,helvetica" size="2"><b>Organisation<b></font> </TD>
    <TD WIDTH="100%" colspan="3" BGCOLOR="#e6f1f1"><FONT FACE="arial,geneva,helvetica" SIZE="1">not compulsory... included with above in mail header<br>
    </FONT><INPUT NAME="org" TYPE="text" SIZE="35" MAXLENGTH="35" VALUE="$Org"></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#007777">
    <FONT COLOR="#ffffff" FACE="arial,geneva,helvetica" SIZE="2">Copy template fields into the texts where needed (grey fields NOT applicable)</FONT></TD>
 </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><input type="checkbox" name="frmhtm" value="1" $chks3><FONT 
    FACE="arial,geneva,helvetica" SIZE="2"><font color="#CC0000"><b>HTML ONLY</b>:</font> Select to <b>send HTML formatted e-mail to ALL</b> recipients</FONT></TD>
 </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE></TD>
  </TR><TR>
    <TD WIDTH="15%" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT COLOR="#000099" SIZE="2" FACE="arial,geneva,helvetica"><b>&lt;&lt;email&gt;&gt;</b></FONT></TD>
    <TD WIDTH="15%" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT COLOR="#$nmeclr" SIZE="2" FACE="arial,geneva,helvetica"><b>&lt;&lt;ename&gt;&gt;</b></FONT></TD>
    <TD WIDTH="15%" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT COLOR="#$dteclr" SIZE="2" FACE="arial,geneva,helvetica"><b>&lt;&lt;edate&gt;&gt;</b></FONT></TD>
    <TD WIDTH="25%" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <INPUT TYPE="checkbox" NAME="shwprev" VALUE="1" $doprvw>
    <FONT FACE="arial,geneva,helvetica" SIZE="2">Show Preview</FONT></TD>
    <TD WIDTH="30%" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <INPUT NAME="bxwid" TYPE="text" SIZE="3" MAXLENGTH="2" VALUE="$boxwidth">
    <FONT FACE="arial,geneva,helvetica" SIZE="2">Box Width (40-66)</FONT></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT SIZE="3" FACE="arial,geneva,helvetica"><b>Message</b><FONT SIZE="2">
    (to control layout line width, press enter near box edge)<BR></FONT></FONT>
    <TEXTAREA NAME="msg" ROWS="15" COLS="$boxwidth">$emsg</TEXTAREA><BR>
    <FONT FACE="arial,geneva,helvetica" SIZE=2>Box is $boxwidth characters wide</FONT></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE width="100%"></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT SIZE="3" FACE="arial,geneva,helvetica"><b>Header</b><FONT SIZE="2">
    (unchanging introduction or name etc)<BR></FONT></FONT>
    <TEXTAREA NAME="head" ROWS="6" COLS="$boxwidth">$hdr</TEXTAREA><BR>
    <FONT FACE="arial,geneva,helvetica" SIZE=2>Appears above the body of your e-mail - Box is $boxwidth characters wide&nbsp;</FONT></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT SIZE="3" FACE="arial,geneva,helvetica"><b>Signature</b><FONT SIZE="2">
    (your name, site URL, unsubscribe notice etc)<BR></FONT></FONT>
    <TEXTAREA NAME="sig" ROWS="6" COLS="$boxwidth">$sig</TEXTAREA><BR>
    <FONT FACE="arial,geneva,helvetica" SIZE=2>Appears at the foot of your e-mail - Box is $boxwidth characters wide&nbsp;</FONT></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1">
    <FONT SIZE="3" FACE="arial,geneva,helvetica"><b>HTML paste box</b><FONT SIZE="2">
    (paste a complete HTML page in to this box)</FONT><BR><FONT SIZE="1">field markers displayed above can be included in the html page: <i>see readme.htm</i></FONT></FONT><BR>
    <TEXTAREA NAME="html" ROWS="15" COLS="$boxwidth">$html</TEXTAREA><BR>
    <FONT FACE="arial,geneva,helvetica" SIZE=2>HTML formatted mail is sent IF there is no message above, OR the &quot;HTML ONLY&quot; checkbox<br>is 
    checked, OR an &quot;HTM&quot; field is found in the subscribers record - <i>E-Lists subscriber option</i>.</FONT></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#e6f1f1"><HR SIZE="1" NOSHADE></TD>
  </TR><TR>
    <TD COLSPAN="5" VALIGN="TOP" ALIGN="CENTER" BGCOLOR="#cccccc"><FONT FACE="arial,geneva,helvetica" SIZE=2>admin PWrd:</FONT>
    <input type="password" name="adminspwrd" size="12" maxlength="15">&nbsp;&nbsp;
    <INPUT TYPE="submit" VALUE="Save Text Changes">&nbsp;&nbsp;<INPUT TYPE="reset" VALUE="Reset"></TD>
  </TR><TR><TD COLSPAN="5" VALIGN="TOP" BGCOLOR="#e6f1f1">~;
if ($doprvw) {
	$hdr = &detag_prv($hdr);
	$emsg = &detag_prv($emsg);
	$sig = &detag_prv($sig);
$hdr_code = "     <code><p><FONT COLOR=\"#ff0000\">Preview sample - last saved </FONT></p>
$hdr";
$msg_cde = "$emsg";
$sig_cde = "$sig</code>
<p><FONT SIZE=\"1\" color=\"#cc0000\" FACE=\"arial,geneva,helvetica\">Preview (only) of long line wrapping is unpredictable because of system font / recipient e-mail program variations.</font>";
}
print qq~$hdr_code
<p>$msg_cde
<p>$sig_cde
</TD></TR></TABLE></td></tr></table></CENTER></form><CENTER><FONT FACE="arial,geneva,helvetica" SIZE=2><B>&#149; <A HREF="$theScrpt?accwrd=$theword">Main
 Page</A> &#149; <A HREF="$theScrpt?accwrd=$theword&frmpwrd=y">Passwords</A> &#149;</B></FONT></CENTER>
<P><CENTER><FONT FACE="arial,geneva,helvetica" SIZE=1>ListMerge v2 copyright</FONT></CENTER></BODY></HTML>~; exit;
}
sub save_txts {
	&chk_allow;
	$colr = ""; $coltxt = ""; if ($FORM{'frmhtm'}) {$FORM{'shwprev'} = 0;}
	if (!&chk_addr($FORM{'from'})) {$colr = "color=\"#CC0000\""; $coltxt = "<font face=\"arial,geneva,helvetica\" color=\"#CC0000\"> <b>ERROR</b></font>"}
		$FORM{'from'} =~ s/\cM\n//g; $FORM{'from'} = "" if !&chk_addr($FORM{'from'});
		$FORM{'sbjct'} =~ s/\cM\n//g; $FORM{'sbjct'} =~ s/"/'/g;
		$FORM{'head'} =~ s/\cM\n/\n/g;
		$FORM{'msg'} =~ s/\cM\n/\n/g;
		$FORM{'htm'} =~ s/\cM\n/\n/g;
		$FORM{'sig'} =~ s/\cM\n/\n/g;
			$FORM{'head'} =~ s/\A\.\Z/ /mg;
				$FORM{'msg'} =~ s/\A\.\Z/ /mg;
					$FORM{'htm'} =~ s/\A\.\Z/ /mg;
						$FORM{'sig'} =~ s/\A\.\Z/ /mg;	
		if ($FORM{'bxwid'} > "66") {$FORM{'bxwid'} = "66";}
		elsif ($FORM{'bxwid'} < "40") {$FORM{'bxwid'} = "40";}
			if (-s "$mrgdatdir_pth/$FORM{'view'}$mrgdta_exten" && open(DF,">$mrgdatdir_pth/$FORM{'view'}$mrgdta_exten")) { 
			 eval "flock (DF, 2)";
				&df_file($FORM{dte},$FORM{'shwprev'},$FORM{'max'},$FORM{'bxwid'},$FORM{'from'},$FORM{'sbjct'},$FORM{'head'},$FORM{'msg'},$FORM{'sig'},$FORM{'addrFmt'},$FORM{'nomrge'},$FORM{'stay'},$FORM{'html'},$FORM{'frmhtm'},$FORM{'div'},$FORM{'lchg'},$FORM{'org'});
			 eval "flock (DF, 8)";
			close(DF); }
			else {&err_msg("</b>[ $FORM{'view'}$mrgdta_exten ]<b> Unable to Update Data File<br>\n");}
	&show_mail; 
}
1;
