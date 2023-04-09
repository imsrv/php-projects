#admn4.pl
sub shw_chk {
		my ($m1,$bit,$is1,$is2,$is3,$is4,$is5); ($m1 = $FORM{'fchk'}) =~ s/$dot/\./;
	if (open(EF,"<$edat_path/$m1")) {  
	  eval "flock(EF,2)"; $topline = <EF>; eval "flock(EF,8)"; 
	close(EF);	}
	else {&err_msg("</b>[$m1]<b> Cannot Read mail list<br>\n");}
		if (open(LF,"<$mrgdatdir_pth/$FORM{'fchk'}$mrgLst_exten")) {  
		  eval "flock(LF,2)"; $lmtop = <LF>; eval "flock(LF,8)"; 
		close(LF);	}
		else {&err_msg("</b>[$m1]<b> Cannot Read Listmerge list<br>\n");}
		$topline =~ s/[$sep]htm$//i; $topline =~ s/\t/\&nbsp;\&nbsp;\&nbsp;/i; $lmtop =~ s/[$sep]htm$//i;
	&get_txts("$mrgdatdir_pth/$FORM{'fchk'}$mrgdta_exten");
		if($addr_only eq "0") {$bit = "[ address,name,date <small>+ html option</small>"; $is1 = "checked";}
		elsif($addr_only eq "1") {$bit = "[ address,name ] <small>+ html option</small>"; $is2 = "checked";}
		elsif($addr_only eq "2") {$bit = "[ name,address ] <small>+ html option</small>"; $is3 = "checked";}
		elsif($addr_only eq "3") {$bit = "[ address ] <small>+ html option</small>"; $is4 = "checked";}
		elsif($addr_only eq "4") {$bit = "[ address,date ] <small>+ html option</small>"; $is5 = "checked";}
		elsif($addr_only eq "5") {$bit = "[ address only ] <small>no option</small>"; $is6 = "checked";}
		else {$bit = "???";}
	if ($sep eq "\t") {$sep = "Tab";}
print qq~<head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>$m1 Mail List Format</title></head><body bgcolor="#ededdb" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<form method="POST" action="$theScrpt"><INPUT TYPE="hidden" NAME="accwrd" VALUE="$theword"><INPUT TYPE="hidden" NAME="dotype" VALUE="$FORM{'fchk'}">
  <center><p><font face="verdana, arial, geneva, helvetica" size="2"><b>Close This Window</b> if not changing the value</font></p><table width="95%" border="0" cellspacing="0" cellpadding="5" align="center">
      <tr bgcolor="#758040"><th><font face="arial, geneva, helvetica" size="2" color="#FFFFFF">$m1 list format check</font></th>
      </tr><tr bgcolor="#d5e0BB">
        <td><font size="2" face="arial, geneva, helvetica">E-Lists and ennyForms can be used to create these various list formats for personalised mailings via their Subscriber forms. Perhaps you have lists from other sources.<br>
          When first activating a mail list records file and associated data file (safe copies of the original lists), ListMerge automatically attempts to recognise the list format used. If the attempt is incorrect you can change the data file below. Option five is for &quot;plain vanilla&quot; address only lists where any extra record data is stripped - if it exists.<i><font color="#336600"> If the original format does not
          appear here then try to select a format that best describes the address field position (and not use field markers in the letter texts). As long as the delimitter is recognised option five might then be the best choice.</font></i></font></td>
      </tr><tr bgcolor="#ededdb">
        <td align="center"><font face="arial, geneva, helvetica" size="2">The first line of the '$m1' list is<br>[ <b>$topline</b> ]</font></td>
      </tr><tr bgcolor="#ededdb">
        <td align="center"><font face="arial, geneva, helvetica" size="2">The format selected is &quot;<b>$addr_only</b>&quot; <b>$bit</b></font></td>
      </tr><tr bgcolor="#ededdb">
        <td align="center"><font face="arial, geneva, helvetica" size="2">The ListMerge first line is <br>[ <b>$lmtop</b> ]</font></td>
      </tr><tr bgcolor="#ededdb">
        <td><font face="arial, geneva, helvetica" size="2">If, and ONLY IF, this format is incorrect then select the correct format from the following options and submit to update the data file. <font size="1" color="#CC0000">this value is not just for personalising but when mailing, recognising the address.</font></font></td>
      </tr><tr bgcolor="#d5e0BB">
        <td><font size="1" face="arial, geneva, helvetica">&quot;html option&quot; refers to the E-Lists and ennyForms OPT-IN option allowing users to choose Plain Text or HTML for their received e-mails; ListMerge detects the extra record field.</font><blockquote><p><input 
              type="radio" name="frmtbtn" value="0" $is1><font face="arial, geneva, helvetica" size="2"> &quot;<b>0</b>&quot; [ address,name,date ] <small>html option</small></font><br>
              <input type="radio" name="frmtbtn" value="1" $is2><font face="arial, geneva, helvetica" size="2"> &quot;<b>1</b>&quot; [ address,name ] <small>+ html option</small></font><br>
              <input type="radio" name="frmtbtn" value="2" $is3><font size="2" face="arial, geneva, helvetica"> &quot;<b>2</b>&quot; [ name,address ] <small>+ html option</small></font><br>
              <input type="radio" name="frmtbtn" value="3" $is4><font size="2" face="arial, geneva, helvetica"> &quot;<b>3</b>&quot; [ address ] <small>+ html option</small></font><br>
              <input type="radio" name="frmtbtn" value="4" $is5><font size="2" face="arial, geneva, helvetica"> &quot;<b>4</b>&quot; [ address,date ] <small>+ html option</small></font><br>
              <input type="radio" name="frmtbtn" value="5" $is6><font size="2" face="arial, geneva, helvetica"> &quot;<b>5</b>&quot; [ address only ] <small>NO OPTIONS</small></font></p></blockquote></td></tr><tr bgcolor="#d5e0BB">
        <td><font face="arial, geneva, helvetica" size="2">NOTE: The config variable  &quot;\$sep&quot; MUST match the delimiting character between fields to take advantage of the E-Lists and ennyForms personalising options; <i>...</i> currently &quot;<b>$sep</b>&quot;.<p align="center"><font color="#CC0000">Once changed refresh the list via the &quot;New&quot; button and re-check!</font></font></td>
      </tr><tr><td align="center"><font face="arial,geneva,helvetica" size=2>Admin <b>password</b>:</font><input type="password" name="adminspwrd" size="12" maxlength="15"> <input type="submit" value="Submit" name="submit"> <input type="reset" value="reset"></td></tr></table></center></FORM></body></html>~; exit;
}
sub change_chk {
	&get_txts("$mrgdatdir_pth/$FORM{'dotype'}$mrgdta_exten");
		$addr_only = $FORM{'frmtbtn'} if $FORM{'frmtbtn'} =~ /[0-5]/;
	if ($FORM{'frmtbtn'} =~ /[0-5]/) {
		if (-s "$mrgdatdir_pth/$FORM{'dotype'}$mrgdta_exten" && open(DF,">$mrgdatdir_pth/$FORM{'dotype'}$mrgdta_exten")) { 
		eval "flock(DF,2)";
			&df_file("$lastdate","$doprvw","$maxsend","$boxwidth","$efrom","$subject","$hdr","$emsg","$sig","$addr_only","$nomerge","$staylve","$html","$frmhtm","$div","$lchg","$Org");
		eval "flock(DF,8)";
		close(DF); }
		else {&err_msg("</b>[$FORM{'dotype'}$mrgdta_exten]<b><br>Cannot Write to data file<br>\n");}
	}
print qq~<head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>Data Updated</title></head><body bgcolor="#ededdb" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center><p>&nbsp;</p><p>&nbsp;</p><p><font face="verdana, arial, geneva, helvetica" size="4"><font color="#758040"><b>Data File updated</b></font><br>[ <b>$FORM{'dotype'}$mrgdta_exten</b> ]</font></p>
<font face="verdana, arial, geneva, helvetica" size="2"><p align="center"><font color="#CC0000">Use the &quot;New&quot; button to <b>refesh</b>, then re-check!</font><p>Please<b> Close This Window</b> to resume ListMerge</p></font></center></body></html>~; exit;
}
sub shw_del {
($s1 = $FORM{'kill'}) =~ s/-/\./; print qq~<head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>Delete $FORM{'kill'} files</title></head><body bgcolor="#ededdb" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000"><p>&nbsp;</p>
<form method="POST" action="$theScrpt"><INPUT TYPE="hidden" NAME="accwrd" VALUE="$theword"><INPUT TYPE="hidden" NAME="fdel" VALUE="$FORM{'kill'}"><center><p><font face="verdana, arial, geneva, helvetica" size="2"><b><a href="$theScrpt?accwrd=$theword">Return here</a></b> if not deleting!</font></p>
<table width="450" border="0" cellspacing="0" cellpadding="5" align="center"><tr bgcolor="#758040" align="center"><td><font face="arial, geneva, helvetica" size="2" color="#FFFFFF">[ CONFIRMATION ] <b>DELETE ALL $FORM{'kill'} files</b></font></td>
</tr><tr bgcolor="#d5e0BB"><td><p><font size="2" face="arial, geneva, helvetica">Proceeding will permanently delete ALL three ListMerge files associated with the &quot;<b>$s1</b>&quot; mail list. </font></p><p align="center"><font size="2" face="arial, geneva, helvetica">The ORIGINAL E-MAIL LIST 
WILL <b>NOT</b> be affected<small><br>if it still exists!</small></font></p></td></tr><tr bgcolor="#d5e0BB"></tr><tr><td align="center"><font face="arial,geneva,helvetica" size=2>Admin <b>password</b>:</font><input type="password" name="adminspwrd" size="12" maxlength="15"><input type="submit" value="Delete" name="submit"></td></tr></table></center></FORM></body></html>~; exit;
}
1;
