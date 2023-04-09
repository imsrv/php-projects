# E-Lists 2.2 DO NOT EDIT
sub show_srch {
		&admnchk if $FORM{'cwrd'} ne crypt($main::theword,$main::bitword);
	my $acnt = 0; my $addel;
	my ($boxes,$s1,$c1,$nxtbtn,$cnt,$fpos,@tmp);
		if ($rslts =~ / pw: /) {$rslts .= "RETURN TO ADMIN AND TRY AGAIN!"; goto BUMMER;}
	my $sl = "          <option value=\"address\">address</option>\n";
		&read_file("$listDir$thuLst");
			my $elen = @entries; $elen = "%0".length($elen)."d";
	$FORM{'srchtxt'} =~ s/(\s.+|\@.+)//g;
	if (!$FORM{'srchtxt'}) {$rslts .= "<br>" if $rslts; $rslts .= "You must enter Search Text"; goto BUMMER;}
	$FORM{'next'} = "0" if !$FORM{'next'};
	for($s1 = $FORM{'next'}; $s1 < @entries; $s1++) {
			chomp($entries[$s1]);
			$boxes2 = ""; $addel = "";
	if ($entries[$s1] =~ /$FORM{'srchtxt'}/i){
			$acnt++; $dchk = 0;
			@tmp = split(/[$sep]/,$entries[$s1]);
			foreach $c1 (@tmp) {
				if ($c1 =~ /\w+\@\w+/) {$addel = $c1;}
				if ($c1 =~ /$FORM{'srchtxt'}/i && !$dchk) {
				  $boxes .= "              <font size=\"1\" color=\"#666666\">&nbsp;".sprintf("$elen",$s1 + 1)."</font><input type=\"checkbox\" name=\"add$acnt\" value=\"%%adr%%\">&nbsp;<font size=\"2\">$c1</font>&nbsp;"; $dchk = 1;
				}
				elsif ($c1) {
					$boxes2 .= "&nbsp;<font size=\"1\" color=\"#000080\">|" if !$boxes2;
					$boxes2 .= "&nbsp;$c1";
			}	}
		$boxes2 .= "</font>" if $boxes2;
		$boxes .= "$boxes2<br>\n";
		$boxes =~ s/%%adr%%/$addel/;
	} if ($acnt == 200) {last;}	}

		if ($s1 < (@entries - 1)) {
			$FORM{'next'} = $s1 + 1;
			$nxtbtn = "      <tr bgcolor=\"#EFEFEF\"><td width=\"100%\" align=\"center\">\n";
			$nxtbtn .= "        <input type=\"submit\" value=\"Search Next ".(@entries - $FORM{'next'})."\"></td></tr>\n";
		}
	BUMMER:	if ($acnt) {
		$dels = qq~
      <tr bgcolor="#EFDFDF"><td width="100%" valign="top" align="center">
        <input type="checkbox" name="lstdel" value="delem"><font size="1" face="verdana,arial,geneva,helvetica" color="#CC0000"><b> Confirm Delete</b> for selected addresses only</font></td></tr>
      <tr bgcolor="#EFEFEF"><td width="100%" valign="top" align="center"><font face="verdana,arial,geneva,helvetica" size="1"><b>Admin word</b></font>
      <input type="password" name="adminspwrd" size="10" maxlength="15"> <input name="subDel" type="submit" value=" Delete Selected! " onClick="return doDelet(this);"> <input type="reset" value="clear all"></td></tr>~;}
	else {
		$dels = qq~
      <tr bgcolor="#EFEFEF"><td width="100%" valign="top" align="center">
        <b><font size="2" face="verdana,arial,geneva,helvetica" color="#CC0000">No Match Found</b> - nothing to delete!</font></td></tr>~;}
        
$rslts = qq~    <table width="590" border="0" cellspacing="0" cellpadding="1"><tr bgcolor="#CC0000"> 
     <th><font face="Verdana,Arial,Geneva,Helvetica" size="1" color="#FFFFFF">$rslts</font></th></tr></table>~ if $rslts;
	print "Content-type: text/html\n\n";
print qq~<html><head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>E-Lists Administration</title>
<script language="JavaScript"><!-- 
 function doDelet(Frm) {
	if (Frm.name == 'subDel') {
			var numclicked = 0;
		if (document.forms['Da']['lstdel'].status == false) {alert ("Please CONFIRM the DELETE option"); return false;}
		else {
			for (var i=1; i <= $acnt; i++) {
				if (document.forms['Da']["add"+i].status == true) {numclicked++;}
			}
			if (numclicked == 0) {alert ("To delete, please SELECT from the $acnt listed RECORDS"); return false;}
	}	}
 }
//-->
</script></head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center><b><font face="Verdana, Arial, Geneva, Helvetica" size="3">E-Lists Administration</font><font face="Verdana, Arial, Geneva, Helvetica" size="4"><br>
  <font color="#CC0000" size="3">$REFS{'frmRef'}</font></font></b><font size="2" face="Verdana, Arial, Geneva, Helvetica"><BR>
  &#149; <b><a href="$admn_url?wrd=$FORM{'wrd'}&form=begin&bgnslct=$FORM{'df'}$list_exten">CLICK HERE to Return To/Refresh Admin</a> &#149;</b></font></font>~; 
	if ($rslts !~ / pw: /) {print qq~
  <form method="POST" action="$admn_url">
    <input type="hidden" name="srch" value="y">
    <input type="hidden" name="df" value="$FORM{'df'}">
    <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
    <input type="hidden" name="wrd" value="$main::FORM{'wrd'}">
    <input type="hidden" name="cwrd" value="$main::cwrd">
    <center><table border="0" width="590" cellspacing="0" cellpadding="2">
        <tr bgcolor="#660000"> 
          <td width="100%" align="center"><font face="arial,geneva,helvetica" color="#FFFFFF"><b><font face="Verdana, Arial, Geneva, Helvetica" size="2">NEW 
            Search</font></b><font face="Verdana, Arial, Geneva, Helvetica" size="2"> '$REFS{'frmRef'}' list</font></font></td>
        </tr><tr bgcolor="#E5E5E5"> 
          <td width="100%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1" color="#CC0000">lists 
            a maximum of 200 addresses per page</font><b><font face="arial, geneva, helvetica" size="2"><br>
            <font face="Verdana, Arial, Geneva, Helvetica" size="1">Search text</font></font></b> 
            <input type="text" name="srchtxt" size="20" maxlength="30" value="$FORM{'srchtxt'}"></td>
        </tr><tr bgcolor="#D5D5D5"> 
          <td width="100%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">ONLY 
            single words, or words seperated by [ dot dash underline ]( <b>. - _</b> )</font></td>
        </tr><tr bgcolor="#E5E5E5"> 
          <td width="100%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">Use only partial addresses in the text box - <i>ie</i> before OR after the @ sign.<br>
            <font color="#000099">if the @ sign is included only the first half of your text will be used!</font></font></td>
        </tr><tr bgcolor="#E5E5E5"> 
          <td width="100%" valign="top" align="center">
<!--           <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>Admin word</b></font> 
            <input type="password" name="adminspwrd" size="10" maxlength="15">-->
            <input type="submit" value="   Search the List   ">
            <input type="reset" value="clear"></td>
        </tr></table></center></form>~;}
	print qq~
  <form method="POST" action="$admn_url" name="Da">
    <input type="hidden" name="srchdel" value="y">
    <input type="hidden" name="df" value="$FORM{'df'}">
    <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
    <input type="hidden" name="next" value="$FORM{'next'}">
    <input type="hidden" name="srchtxt" value="$FORM{'srchtxt'}">
    <input type="hidden" name="wrd" value="$main::FORM{'wrd'}">
    <input type="hidden" name="cwrd" value="$main::cwrd">
$rslts
    <table border="0" width="590" cellspacing="0" cellpadding="2">
      <tr bgcolor="#660000"> 
        <td width="100%" valign="top" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="2" color="#FFFFFF"><b>Search Results</b> from '$REFS{'frmRef'}' list</font></td>
      </tr><tr bgcolor="#E5E5E5"> 
        <td width="100%" valign="top" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>Select 
         one or more addresses to <font color="#CC0000">Delete</font></b> AND select the confirmation button<br>
         <i>OR</i> <b>click the &quot;Search Next ??&quot; button to continue search</b> ( if it appears )</font></td>
      </tr><tr bgcolor="#FFFFFE"> 
        <td width="100%" valign="top"><p><font size="1"><code>$boxes</code></font></p></td></tr>$nxtbtn $dels </table></form>
    <font face="verdana,arial,geneva,helvetica" size="2">&#149; <b><a href="$admn_url?wrd=$FORM{'wrd'}&form=begin&bgnslct=$FORM{'df'}$list_exten">CLICK HERE to Return To/Refresh Admin</a> 
    &#149;</b></font><br><font face="arial,geneva,helvetica" size="1">E-Lists v2.2 copyright</font></center></body></html>~; exit(0);
		#ALL program and copyright notices MUST remain as is and visible on output pages
} 
sub srch_do {
	my ($tmpn,$tmpv,$tmp,$cnt,$bigone,$s1,$s2);
		&admnchk if $main::FORM{'cwrd'} ne crypt($main::theword,$main::bitword);
	if ($rslts =~ / pw: /) {&show_srch;}
	&read_file("$main::listDir$main::thuLst");
		$rslts = "NO Addresses Deleted!";

	while (($tmpn,$tmpv) = each (%FORM)) {
		if ($tmpn =~ /^add(\d+)$/ && $tmpv =~ /.+\@.+/) {$bigone .= "^$tmpv^"; $cnt++}	} 
	for($s1 = @entries - 1; $s1 >= 0; $s1--) { $tmp = "";
		if ($entries[$s1] =~ /(.*[$main::sep]|^)(.*\@.*?)(?=([$main::sep]|$))/) {$tmp = $2;} 
		if ($tmp && $bigone =~ /\^$tmp\^/) {$s2++; splice(@entries, $s1, 1);  }
		if ($s2 == $cnt) {last;}  }	
	if ($s2) {
		if (open (ADR, ">$main::listDir$main::thuLst")) {
 			eval "flock (ADR,2)"; print ADR @entries; eval "flock (ADR,8)";
			close (ADR);
		$rslts = "[ $s2 ] Addresses DELETED!";	}
		else {$rslts .= "<br>" if $rslts; $rslts .= "Cannot Re-Write List File!"; &show_srch;}
	}
	$main::FORM{'next'} = 0;
	$main::FORM{'lstdel'} = "";
		$isin = 1;
		&show_srch;
}
sub admnchk {
	local @theAword;
	if (!( -e "$main::admin_pth"."elist.pw")) {
		if (open(FF,">>$main::admin_pth"."elist.pw")) {print FF "Do NOT Edit\n"; close(FF);}
 		else {$rslts = " pw: Bad Path/Missing ADMIN Password File<br>"; return;}
 	}
	if (open(ADMwrd, "<$main::admin_pth"."elist.pw")) {
 		eval"flock (ADMwrd, 2)"; @theAword = <ADMwrd>; eval"flock (ADMwrd, 8)";
	close(ADMwrd);}
	else {$rslts = " pw: Cannot Access ADMIN Password File<br>"; return;} 
	if ($theAword[1] || $main::FORM{'adminspwrd'}) {
		if (crypt($main::FORM{'adminspwrd'},$main::FORM{'adminspwrd'}) ne $theAword[1]) {
			$rslts = " pw: Incorrect ADMIN Password<br>"; return;}
	}
}
1; #this line must remain as is
