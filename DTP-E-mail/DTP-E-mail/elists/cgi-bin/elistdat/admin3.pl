# E-Lists 2.2 DO NOT EDIT
sub show_lst {
		&admnchk if $FORM{'cwrd'} ne $main::cwrd;
	if($FORM{'lstall'} eq "1") {
		my $acnt = 0;
		my ($boxes,$s1,$s2,$add,$nme,$dte,$nxtbtn,$cnt,$fpos,@tmp,$Htm);
	&read_file("$listDir$thuLst");
			my $elen = @entries; $elen = "%0".length($elen)."d";

	for($s1 = $FORM{'next'}; $s1 < @entries; $s1++) {
			$s2 = 0;
			chomp($entries[$s1]);
			@tmp = split(/[$sep]/,$entries[$s1]);
			$acnt++;
			$add = $dte = $nme = $Htm = "";
				if (!$addr_only) {($add,$nme,$dte,$Htm) = split(/[$sep]/,$entries[$s1]);} #add nme dte
				elsif ($addr_only eq "1") {($add,$nme,$Htm) = split(/[$sep]/,$entries[$s1]);} #add nme
				elsif ($addr_only eq "2") {($nme,$add,$Htm) = split(/[$sep]/,$entries[$s1]);} #nme add
				elsif ($addr_only eq "4") {($nme,$dte,$Htm) = split(/[$sep]/,$entries[$s1]);} #nme add
				else {($add,$Htm) = split(/[$sep]/,$entries[$s1]);} #add
			$lrslt .= "              <font size=\"1\" color=\"#808080\">&nbsp;".sprintf("$elen",$s1 + 1)."</font><font size=\"2\"> $add</font>";
			$lrslt .= " <font size=\"1\" color=\"#000080\"> | $nme" if $nme;
			$lrslt .= " $dte" if $dte;
			$lrslt .= " $Htm" if $Htm;
			$lrslt .= "</font>" if $dte || $nme || $Htm;
			$lrslt .= "<br>\n";
		if ($acnt == 200) {last;}	}	
			if ($s1 < @entries - 1) {
				$FORM{'next'} = $s1 + 1;
				$nxtbtn = '        <tr><td width="99%" bgcolor="#EFEFEF" align="center">'."\n";
				$nxtbtn .= "         <input type=\"submit\" value=\"List from Next ".(@entries - $s1 - 1)."\"></td></tr>\n";	}
			else {
				$FORM{'next'} = "0";
				$FORM{'adminspwrd'} = "";
				$nxtbtn = '        <tr><th width="99%" bgcolor="#EFEFEF">'."\n";
				$nxtbtn .= '         <font face="verdana, arial, geneva, helvetica" size="2" color="#CC0000">End Of List</font></th></tr>'."\n";	}
print "Content-type: text/html\n\n"; print qq~<html><head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>E-Lists Administration</title></head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
 <center><b><font face="verdana,arial,geneva,helvetica" size="3">E-Lists Administration<br><font color="#CC0000">$REFS{'frmRef'}</font></font></b><BR>
  <!--<font face="verdana,arial,geneva,helvetica" size="2">&#149; <b><font color="#0000FF">CLOSE WINDOW to Return</font></b> &#149;</font>-->
<form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form>
 <form method="POST" action="$admn_url">
    <input type="hidden" name="lstall" value="1">
 	<input type="hidden" name="df" value="$FORM{'df'}">
	<input type="hidden" name="frmref" value="$REFS{'frmRef'}">
	<input type="hidden" name="cwrd" value="$main::cwrd">
	<input type="hidden" name="next" value="$FORM{'next'}">
    <input type="hidden" name="wrd" value="$FORM{'wrd'}">
   <center><table border="0" width="595" cellspacing="0" cellpadding="2">
     <tr bgcolor="#660000"><td width="100%" align="center"><font face="verdana,arial,geneva,helvetica" size="2" color="#FFFFFF"><b>List</b> $REFS{'frmRef'} <b>subscribers</b></font></td>
     </tr><tr><td width="99%" bgcolor="#FFFFFE" align="center">
      <font face="verdana, arial, geneva, helvetica" size="1" color="#CC0000">lists a maximum of 200 per page</font></td>
     </tr><tr><td width="99%" bgcolor="#FFFFFE"> <font size="1"><code>$lrslt</code></font></td></tr>$nxtbtn</table></center></form>
  <!--<font face="verdana,arial,geneva,helvetica" size="2">&#149; <b><font color="#0000FF">CLOSE WINDOW to Return</font></b> &#149;</font><br>-->
  <form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"><br><font face="arial,geneva,helvetica" size="1">E-Lists v2.2 copyright</font></form></center></body></html>~; exit(0);
		#ALL program and copyright notices MUST remain as is and visible on output pages
}
else {&doErr('<b>List Request Not Recognised</b>');}
} 
sub admnchk {
if (!( -e "$admin_pth"."elist.pw")) {open(FF,">>$admin_pth"."elist.pw") || &doErr('Missing ADMIN Password File'); print FF "Do NOT Edit\n"; close(FF);}
	open(ADMwrd, "<$admin_pth"."elist.pw") || &doErr('ADMIN Password File Access');
 	 eval"flock (ADMwrd, 2)"; @theAword = <ADMwrd>; eval"flock (ADMwrd, 8)";
	close(ADMwrd);
	if ($theAword[1] || $FORM{'adminspwrd'}) {
		if (crypt($FORM{'adminspwrd'},$FORM{'adminspwrd'}) ne $theAword[1]) {&doErr('Incorrect ADMIN Password');}
	}
}
sub doErr {
	print "Content-type: text/html\n\n";
	print qq~<html><head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>Error Response</title></head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000"><center><p>&nbsp;</p><table border="0" cellpadding="2" cellspacing="0">
<tr> <th bgcolor="#333333"><font face="verdana, arial, geneva, helvetica" color="#FFFFFF">E-Lists Error Response</font></th>
</tr><tr bgcolor="#FFFFFF" align="center"><td><p align="center"><font size="2" face="arial,helvetica,geneva"><b>&nbsp;The program has responded with an error&nbsp;</b></font></p>
<p><font size="2" face="arial,helvetica,geneva" color="#CC0000"><b>$_[0]<br></b></font><font size="1">&nbsp;</font></p></td>
</tr><tr><td align=center><font face="arial,helvetica,geneva" size="1" color="#808080">E-Lists v2.2 copyright</font></td></tr></table>
<form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form></center></body></html>~; exit;
		#ALL program and copyright notices MUST remain as is and visible on output pages
}
1; #this line must remain as is
