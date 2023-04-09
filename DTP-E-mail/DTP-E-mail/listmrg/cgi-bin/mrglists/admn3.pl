#admn3.pl
sub do_words {
		$gtme = &date_time_real(time + $gmtPlusMinus);
	if ($fixed) {$fixed = qq~<center><table border="0" cellpadding="0" cellspacing="0"><tr><th bgcolor="#CC0000"><FONT size="2" FACE="verdana,arial,geneva,helvetica" color="#FFFFFF">&nbsp;&nbsp;$fixed&nbsp;&nbsp;</font></th></tr></table></center>~;}
 print qq~<HEAD><meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <title>ListMerge Password Administration</title></HEAD><BODY TEXT="#000000" BGCOLOR="#ededdb" link="#0000FF" vlink="#0000FF">
<h3 align="center"><FONT FACE="arial,geneva,helvetica">ListMerge Password Administration</FONT></h3>
<p align="center"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>&#149; <a href="$theScrpt?accwrd=$theword">Return to Main Page</a> &#149;</b></FONT></p>
$fixed<form method="POST" action="$theScrpt">
	<input type="hidden" name="aped" value="y">
	<input type="hidden" name="accwrd" value="$theword">
  <center><table width="515" border="0" cellpadding="1" cellspacing="0"><tr>
  <td align="center"bgcolor="#758040"><font size="2" face="arial,helvetica,geneva" color="#ffffff">Create or Change <b>ADMIN Password</b></font></td></tr></table>
  <table border="0" width="515" cellspacing="0" cellpadding="2">
    <tr><td width="33%" align="center" bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>OLD</b> Admin password:</FONT><br>
      <input type="password" name="adminspwrd" size="12" maxlength="15"></td>
      <td width="33%" align="center" bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>NEW</b> Admin Password:</FONT><br>
      <input type="password" name="newpwrd1" size="12" maxlength="15"></td>
      <td width="33%" align="center" bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2>Repeat <b>NEW</b> Password:</FONT><br>
      <input type="password" name="newpwrd2" size="12" maxlength="15"></td></tr>
    <tr><td width="100%" valign="top" align="center" colspan="3" bgcolor="#c5c599"><input type="submit"
      value="Change ADMIN word"> <input type="reset" value="clear"></td></tr>
  </table></form>
<form method="POST" action="$theScrpt">
	<input type="hidden" name="gped" value="y">
	<input type="hidden" name="accwrd" value="$theword">
  <table width="515" border="0" cellpadding="2" cellspacing="0"><tr>
  <td align="center" bgcolor="#758040"><font size="2" face="arial,helvetica,geneva" color="#ffffff">Create or Change <b>ACCESS Password</b></font></td></tr></table>
  <table border="0" width="515" cellspacing="0" cellpadding="2">
    <tr><td width="33%" valign="top" align="center" bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>OLD</b> Access password:</FONT><br>
      <input type="password" name="oldacc" size="12" maxlength="15"></td>
      <td width="33%" valign="top" align="center" bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>NEW</b> Access Password:</FONT><br>
      <input type="password" name="newacc1" size="12" maxlength="15"></td>
      <td width="33%" valign="top" align="center" bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2>Repeat <b>NEW</b> Password:</FONT><br>
      <input type="password" name="newacc2" size="12" maxlength="15"></td></tr>
    <tr><td width="100%" valign="top" align="center" colspan="3" bgcolor="#c5c599"><FONT FACE="arial,geneva,helvetica" SIZE=2>admin PWrd:</FONT><input 
	type="password" name="adminspwrd" size="12" maxlength="15"> <input type="submit"
      value="Change ACCESS word"> <input type="reset" value="clear"></td></tr>
  </table></form>
<form method="POST" action="$theScrpt">
 	<input type="hidden" name="gmed" value="y">
	<input type="hidden" name="accwrd" value="$theword">
   <center><table width="515" border="0" cellpadding="2" cellspacing="0"><tr>
   <td align="center" bgcolor="#758040"><font size="2" color="#ffffff" face="arial,helvetica,geneva">Adjust <b>GMT Time Zone</b>&nbsp;&nbsp;&nbsp;<font size="1">...current $gtme</font></font></td></tr></table>
   <table border="0" width="515" cellspacing="0" cellpadding="2">
   <tr><td valign="middle" align="center" nowrap bgcolor="#fafae0"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>&nbsp;GMT</b><br></FONT>~;
$s1 = sprintf("%0.2f",$gmtPlusMinus / 60 / 60);
print qq~     &nbsp;&nbsp;<input type="text" name="gmt" value="$s1" size="8">&nbsp;&nbsp;<FONT FACE="arial,geneva,helvetica" SIZE=2><br>Hours + or -</FONT></td>
      <td bgcolor="#fafae0"><input type="checkbox" name="gmted" value="y"><FONT FACE="arial,geneva,helvetica" SIZE=2>:<b>Change</b><br><font size="1">
      If you move from the current time zone, or change to / from daylight savings, enter the new value and tick &quot;Change&quot;, Even if the local GMT time zone equals the servers, you must
      have your local GMT time zone value entered here (ie 5.5 or -9 etc).<br><i>&nbsp;&nbsp;use your PC clock set-up for reference</i></font></FONT></td></tr>
    <tr><td width="591" valign="top" align="center" colspan="2" bgcolor="#c5c599"><FONT FACE="arial,geneva,helvetica" SIZE=2>admin PWrd:</FONT><input
      type="password" name="adminspwrd" size="12" maxlength="15"> <input type="submit" value="Save Local GMT Zone"> <input type="reset" value="reset"></td></tr></table></center></form>
    <p align="center"><FONT FACE="arial,geneva,helvetica" SIZE=2><b>&#149; <a href="$theScrpt?accwrd=$theword">Return to Main Page</a> &#149;</b></FONT></p>
<p align="center"><FONT FACE="arial,geneva,helvetica" SIZE=1>ListMerge v2 copyright</FONT></p></BODY></HTML>~; exit;
}
sub edits {
	&chk_allow;
if ($FORM{'aped'} eq "y") {
	if ($FORM{'newpwrd1'} ne $FORM{'newpwrd2'}) {&err_msg('New ADMIN Password Entries Do Not Match');}
	elsif ($FORM{'newpwrd1'} eq $FORM{'adminspwrd'}) {&err_msg('No Change Requested');}
	$theAword[1] = crypt($FORM{'newpwrd1'},"$FORM{'newpwrd1'}");
		open(ADMwrd, ">$adminword_pth") || &err_msg('ADMIN Password File Access');
 		  eval "flock (ADMwrd,2)"; print ADMwrd @theAword; eval "flock (ADMwrd,8)";
		close(ADMwrd);
	$fixed = "New ADMIN Password Installed";
	&do_words;
}
if ($FORM{'gped'} eq "y") {
	&pwrd($FORM{'oldacc'});
	if ($FORM{'newacc1'} ne $FORM{'newacc2'}) {&err_msg('New Password Entries Do Not Match');}
	elsif ($FORM{'newacc1'} eq $FORM{'oldacc'}) {&err_msg('No Change Requested');}
	$s1 = "\$theword = \"$FORM{'newacc1'}\";\n";
	$s2 = 0;
	open (CNF, "<$cnfg_pth" ) || &err_msg('Config File Access');
 	  eval "flock (CNF,2)"; @varyin = <CNF>; eval "flock (CNF,8)";
	close (CNF);
		for($cnts = 0; $cnts < @varyin; $cnts++) {
			if ($varyin[$cnts] =~ /theword/) {
				$varyin[$cnts] = $s1;
				$s2 = 1; next;			
			}  }
		if ($s2 eq 0) {&err_msg('Config Variable Not Found');}
	if (-s "$cnfg_pth") {
		open (CNF, ">$cnfg_pth" ) || &err_msg('Config File Access');
 		  eval "flock (CNF,2)"; print CNF @varyin; eval "flock (CNF,8)";
		close (CNF);
		$theword = $FORM{'newacc1'};
		$fixed = "New ACCESS Password Installed";
	}
	else {&err_msg('Config File empty or missing!');}
		&do_words;
}
if ($FORM{'gmed'} eq "y") {
	if ($FORM{'gmted'} eq "y") {
	if ($FORM{'gmt'} !~ /[0-9]/) {&err_msg('GMT Value Error');}
	elsif ($FORM{'gmt'} > 12 || $FORM{'gmt'} < -12) {&err_msg('GMT <> + or - 12');}
		$s1 = "\$gmtPlusMinus = ".($FORM{'gmt'} * 60 * 60).";\n";
	open (GMT, "<$gmt_pth") || &err_msg('GMT.SET File Access');
 	 eval "flock (GMT,2)"; @gmtin = <GMT>; eval "flock (GMT,8)";
	close (GMT);
		$cnts = 0; $s3 = 0;
		foreach $s2 (@gmtin) {
			if ($s2 =~ /gmtPlusMinus/) {$gmtin[$cnts] = $s1; $s3 = 1; next;}
		$cnts++;
		}
		if ($s3 eq 0) {&err_msg('gmtset.pl Variable Not Found');}
	if (-s "$gmt_pth" && open (GMT, ">$gmt_pth")) {
 	 eval "flock (GMT,2)"; print GMT @gmtin; eval "flock (GMT,8)";
	close (GMT);
		$gmtPlusMinus = ($FORM{'gmt'} * 60 * 60);
		$fixed = "New GMT Value is set";	}
	else {&err_msg("GMT.SET File Access error");}
		&do_words;
 	}
else  {&err_msg("Please tick 'Change' to confirm");}
}
exit;
}
1;
