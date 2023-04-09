# E-Lists 2.2 DO NOT EDIT
sub begin {
		my $NwAlw = shift; $NwAlw =~ s/[$list_exten]//; $cWrd = $main::cwrd;
	if(opendir(DIR,"$listDir")) { 
		@FILEtemp = grep( /^(.+)$list_exten$/sg, sort(readdir(DIR)));
	closedir(DIR);	}
		@tmp = qw/redisplay.pl:E result.pl:E unsubpg.pl:E progerrs.pl:E showerrs.pl:E admin1.pl admin2.pl admin3.pl admin4.pl admin5.pl scribe.pl unsubs.pl el_samp.pl el_help.pl elist.pw/;
	foreach (@tmp) {
		$c1 = "ERROR";
		($c2 = $_) =~ s/:E//;
		if ( -e "$admin_pth$c2") {$c1 = OK;}
		if (!(-s "$admin_pth$c2")) {$c1 = "<font color=\"#CC0000\">EMPTY</font>";}
		$c4 = (-s "$admin_pth$c2"); $c4 = "<font color=\"#CC0000\">$c4</font>" if $c4 == 0;
		
	$fList .= qq~	<tr bgcolor="#FFFFFE"> 
	<td bgcolor="#FFFFFE"><font face="Verdana, Arial, Geneva, Helvetica" size="1">&nbsp;&nbsp;~;	
	if ($_ =~ /:E$/) {$fList .=  qq~<a href="$admn_url?cwrd=$cWrd&F=$c2" target="_blank">$c2</a></font></td>~;}
	else {$fList .= qq~$c2</font></td>~;}
	$fList .= qq~	<td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">$c1</font></td>
	<td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">$c4</font></td></tr>~;
	}
		my $ARYcnt = 0; my $cnt;
 		my $LNAry = "   var notAry = new Array();\n";
 	foreach (@FILEtemp) {
		$Sz = (-s "$listDir$_");
		$flst .= qq~<option value="$_">$_ : $Sz bytes</option>\n~;
		($cnt = $_) =~ s/$list_exten$//; $LNAry .= "   notAry[$ARYcnt] = \"$cnt\";\n";
	$ARYcnt++;
	}
		$ARYcnt = 0; my ($Nadrs,$Nnme,$Norg,@ary);
		my $LAry = "   var typeAry = new Array(); var nameAry = new Array();\n";
		$LAry .= "   var discAry = new Array(); var optAry = new Array();\n";
		$LAry .= "   var adrAry = new Array(); var adrnAry = new Array();\n";
		$LAry .= "   var orgAry = new Array();\n";
		my $Ldex = "   var LDxTyp = new Array();\n";
	foreach (@alwFiles) {
		$alwLsts .= qq~<option value="$_">$_</option>\n~; $Nadrs=$Nnme=$Norg="";
		@ary = split(/:/,$_); if ($ary[3]) {$ary[3] = "checked";} else {$ary[3] = "";}
		$LAry .= "   typeAry[$ARYcnt] = \"$ary[0]\"; nameAry[$ARYcnt] = \"$ary[1]\";\n";
		$LAry .= "   discAry[$ARYcnt] = \"$ary[2]\"; optAry[$ARYcnt] = \"$ary[3]\";\n";
		if (open (AD,"<$admin_pth$ary[1].adr")) {($Nadrs,$Nnme,$Norg) = split(/:/,<AD>); close(AD);}
		$LAry .= "   adrAry[$ARYcnt] = \"$Nadrs\"; adrnAry[$ARYcnt] = \"$Nnme\";\n";
		$LAry .= "   orgAry[$ARYcnt] = \"$Norg\";\n";
		$Ldex .= "     LDxTyp[$ARYcnt] = \"$ary[0]:$ary[1]\";\n";
	$ARYcnt++;
	}
	if (@alwFiles) {$SmP = qq~<a name="SmP" href="javascript:sMp();"><b>form</b></a>~;}
	else {$SmP = qq~form~;}
	chomp($Ldex); $isGmt = sprintf("%0.2f",$gmtPlusMinus / 60 / 60);
		(my $uL = $uload_url) =~ s/.*\///;
	if (open(WF,"<$main::admin_pth$main::aux_pth"."waits.wt")) {
		eval"flock(WF,2)"; @WTchk = <WF>; eval"flock(WF,8)"; close(WF);
		foreach $c6 (@WTchk) {
			($c1,$c2,$c3,$c4,$c5) = split (/\0/,$c6);
			next if time > $c3;
			push (@WChk,"$c6") if $c1 =~ /^(A|U)$/;}
	if (open(WF,">$main::admin_pth$main::aux_pth"."waits.wt")) {
		eval"flock(WF,2)"; print WF @WChk; eval"flock(WF,8)"; close(WF);}  }
	$errBox = qq~    <tr bgcolor="#CC0000" align="center"><th colspan="3" width="100%"><font size="1" face="Verdana, Arial, Geneva, Helvetica" color="#FFFFFF">$errBox</font></th></tr>~ if $errBox;
		my $LnkL; if (open (LK, "<$admin_pth"."lnklite.pth")) {$LnkL = <LK>; close(LK);}
		$LnkL =~ s/(\0|\s|\;|`)//g; $LnkL = "ERROR" if $LnkL && $LnkL !~ m#\Ahttps?://#;
	my $Tm = &main::date_time;
print "Content-type: text/html\n\n"; print qq~
<html><head>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>List Selection - Admin</title>
<script language="JavaScript"><!-- 
 function ELWindow(prog,winis,stuff) {window.open(prog,winis,stuff);}
 function sMp() {
   var isDexx = document.Nn.alwlIST.selectedIndex;
$Ldex
   if (LDxTyp[0] == null || LDxTyp[0] == "") {alert ("Please activate an Allowed List Name");}
   else {url = "$admn_url?cwrd=$cWrd&S="+LDxTyp[isDexx]; window.open(url);}
 }
 function doChnge(Frm) {
	if (Frm.name == "Gm") {
		if (Frm.gmted.status == false) {alert ("Please CONFIRM the option"); return false;	}	}
	else {if (Frm.name == "Dn") {
		if (Frm.auxDel.status == true) {return confirm ("WARNING: This will ALSO DELETE the list AND ALL records");	}	}	
}	}
 function alwMk() {
	var isDex1;
$LNAry
	isDex1 = document.Mm.bgnslct.selectedIndex;
	if (notAry[0] == null || notAry[0] == "") {alert ("No Existing List Selected!");}
	else {
	document.NnF.nLstNme.value = notAry[isDex1];
   	document.NnF.lstTyp[0].checked = true;
	document.NnF.nLstDesc.value = "";
	document.NnF.nAddrss.value = "";
	document.NnF.nAddnme.value = "";
	document.NnF.nOrg.value = "";
	document.NnF.optIn.checked = false; }
 }	
 function alwEd(thisIs) {
	var isDex; document.NnF.optIn.checked = "";
$LAry
	isDex = document.Nn.alwlIST.selectedIndex;
	if (nameAry[0] == null || nameAry[0] == "") {alert ("No activated Allowed List Names");}
	else {
   	document.NnF.lstTyp[typeAry[isDex]].checked = true;
	document.NnF.nLstNme.value = nameAry[isDex];
	document.NnF.nLstDesc.value = discAry[isDex];
	document.NnF.nAddrss.value = adrAry[isDex];
	document.NnF.nAddnme.value = adrnAry[isDex];
	document.NnF.nOrg.value = orgAry[isDex];
	document.NnF.optIn.checked = optAry[isDex]; }
 }	
//-->
</script></head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center>&nbsp;<table border="0" cellspacing="5" cellpadding="1" width="550">
    <tr bgcolor="#000000" align="center"> 
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center" bgcolor="#FFFFFE"> 
            <td><form name="Mm" method="post" action="$admn_url">
                <input type="hidden" name="form" value="begin">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr><td><font face="Verdana, Arial, Geneva, Helvetica" size="2">The following E-Lists lists have been found in your &quot;<b>$listDir</b>&quot; directory.</font><font face="Verdana, Arial, Geneva, Helvetica" size="2"><br>
                     </font><font face="Verdana, Arial, Geneva, Helvetica" size="1">&#149; Select a list name from this drop-list to view the admin pages for that mail list.</font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;File Name : file size</b></font></td>
                  </tr><tr align="center"> 
                    <td><select name="bgnslct">$flst</select> <input type="submit" name="Submit" value="View Admin"><br><font size="1" face="Verdana, Arial, Geneva, Helvetica">select and <a href="javascript:onclick=alwMk();">CLICK</a> to copy name below; - IF an existing list is not yet &quot;Allowed&quot;</font></td>
                  </tr></table></form></td>
          </tr></table></td>
    </tr><tr align="center"> 
      <td><form method="post" action="$admn_url">
          <input type="submit" value="Refresh this admin page" name="submit">
          <input type="hidden" name="wrd" value="$FORM{'wrd'}"></form></td>
    </tr><tr bgcolor="#660000" align="center"> 
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr><td bgcolor="#CCCCCC" width="8%"><font color="#FFFFFF" size="2" face="verdana, arial, geneva, helvetica">&nbsp;$SmP&nbsp;</font></td>
            <th width="84%"><font color="#FFFFFF" size="2" face="verdana, arial, geneva, helvetica">E-Lists Administration</font></th>
            <td align="right" bgcolor="#CCCCCC" width="8%"><font color="#FFFFFF" size="2" face="verdana, arial, geneva, helvetica">&nbsp;<a href="javascript:ELWindow('$admn_url?popv=1&H=H&cwrd=$cWrd','pop','scrollbars=1,width=590,height=440');"><b>Help</b></a>&nbsp;</font></td>
          </tr>$errBox</table></td>
    </tr><tr> 
      <td align="center" bgcolor="#000000"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr bgcolor="#666666"> 
            <th><font face="Verdana, Arial, Geneva, Helvetica" size="2" color="#FFFFFF">Names of &quot;Allowed&quot; Mail Lists</font></th>
          </tr><tr bgcolor="#FFFFFF"> 
            <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> 
               <td><center><form name="Nn" align="center"><b><font size="1" face="Verdana, Arial, Geneva, Helvetica">ListType : ListName : Description : Confirm by Mail</font></b><br>
                <select name="alwlIST">$alwLsts</select><br><font size="1" face="Verdana, Arial, Geneva, Helvetica">select and <a href="javascript:onclick=alwEd();">CLICK</a> to copy details below</form></center>
                <p>The following two options enable the addition OR deletion of allowed mail lists.<br>&nbsp;&nbsp;Use the....<br>&quot;<b>first option to add a new OR edit a</b>&quot; mail list name and description, the...<br>&quot;<b>second option to remove</b>&quot; an allowed mail-list name.<br>
                &#149; The list name must match, OR will become, the lists file name (no extension); use ONLY alpha-numeric characters!<br>&#149; List &quot;Type&quot; can only be changed for empty lists (no address records!)<br>&#149; List &quot;Name&quot; cannot be changed for existing lists.</font></td>
              </tr></table></td>
          </tr><tr bgcolor="#EFEFEF" align="center"> 
            <td><form method="post" action="$admn_url" name="NnF">
                <input type="hidden" name="addLnme" value="1">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                  <tr bgcolor="#CCCCCC"> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;<font size="2">Add/Edit</font></b></font></td>
                    <td align="center"> <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>Ad</b> 
                      - Address, <b>Nm</b> - Name, <b>Dt</b> - Date, [ (5) <b>relay</b> to autoresponder ]</font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;List Type</b></font></td>
                    <td><input type="radio" checked name="lstTyp" value="0">
                      <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>0</b> Ad,Nm,Dt </font> 
                      <input type="radio" name="lstTyp" value="1">
                      <font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>1</b> Ad,Nm </font> 
                      <input type="radio" name="lstTyp" value="2">
                      <font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>2</b> Nm,Ad </font> 
                      <input type="radio" name="lstTyp" value="3">
                      <font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>3</b> Ad </font> 
                      <input type="radio" name="lstTyp" value="4">
                      <font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>4</b> Ad,Dt</font> 
                      <input type="radio" name="lstTyp" value="5">
                      <font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>5</b></font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;List Name</b></font></td>
                    <td><input type="text" name="nLstNme" size="20" maxlength="20" value="$NwAlw">
                      <font size="1" face="Verdana, Arial, Geneva, Helvetica"> 8-15 chars - NO extension</font></td>
                  </tr><tr> 
                    <td><b><font size="1" face="Verdana, Arial, Geneva, Helvetica">&nbsp;Description</font></b></td>
                    <td><input type="text" name="nLstDesc" size="20" maxlength="30">
                      <font face="Verdana, Arial, Geneva, Helvetica" size="1">brief - appears in output</font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;Confirm</b></font></td>
                    <td><input type="checkbox" name="optIn" value="1">
                      <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>Submission confirmed</b> ONLY via an emailed link-back</font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;Your Address</b></font></td>
                    <td><input type="text" name="nAddrss" size="35" maxlength="75"><font face="Verdana, Arial, Geneva, Helvetica" size="1"> type 0-4 only</font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;Your Name</b></font></td>
                    <td><input type="text" name="nAddnme" size="35" maxlength="35"><font face="Verdana, Arial, Geneva, Helvetica" size="1"> type 0-4 only</font></td>
                  </tr><tr> 
                    <td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;Organisation</b></font></td>
                    <td><input type="text" name="nOrg" size="35" maxlength="35"><font face="Verdana, Arial, Geneva, Helvetica" size="1"> type 0-4 not compulsory</font></td>
                  </tr><tr align="center"> 
                    <td colspan="2"><font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>ADMIN word</b></font> 
                      <input type="password" name="adminspwrd" size="10" maxlength="15">
                      <input type="submit" name="Submit" value="Add/Edit">
                      <input type="reset" name="reset" value="reset"></td>
                  </tr></table></form></td>
          </tr><tr bgcolor="#CCCCCC"> 
            <td><font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>&nbsp;<font size="2">Deleting</font></b></font></td>
          </tr><tr bgcolor="#E5E5E5"> 
            <td><p><font size="1" face="Verdana, Arial, Geneva, Helvetica"> &#149; <b><font color="#990000">Checking</font> the checkbox</b> will 
                <font color="#CC0000">also delete an existing mail list AND any auxilliary files</font> created for that list - EVERY file conected to the selected &quot;allowed&quot; name!<br>
                &#149;<font color="#990000"> <b>NOT checking</b></font><b> the checkbox</b> will only delete the list name from the allowed list, 
                enabling reinstatement - and you will need to manually delete any related files.</font></p></td>
          </tr><tr bgcolor="#E5E5E5"> 
            <td align="center"><form method="post" action="$admn_url" name="Dn" onSubmit="return doChnge(this);">
                <input type="hidden" name="delLnme" value="1">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>Files</b></font> 
                <input type="checkbox" name="auxDel" value="1">
                <b><font size="1" face="Verdana, Arial, Geneva, Helvetica">List</font></b> 
                <select name="delAllw">$alwLsts</select>
                <b><font size="1" face="Verdana, Arial, Geneva, Helvetica"><br>ADMIN word</font></b> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" name="Submit" value="Delete">
                <input type="reset" name="reset" value="reset"></form></td>
          </tr><tr bgcolor="#666666"> 
            <th width="100%"><font color="#FFFFFF" face="Verdana, Arial, Geneva, Helvetica" size="2">LnkinLite URL - <small>if installed</small></font></th>
          </tr><tr bgcolor="#E5E5E5"> 
            <td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>IF you have LnkinLite installed</b>, save the FULL URL plus program ACCESS PASSWORD here.<br>
              <font size="2"><i><font color="#000099">ie</font></i> [ http://yourdomain.name/cgi-bin/lnkinlte.cgi<font color="#CC0000"><b>?p=</b></font>accesspassword ]<br>
              <font size="1">see readme.htm for details</font></font></font></td>
          </tr><tr bgcolor="#E5E5E5"> 
            <td align="center" width="100%"><form method="post" action="$admn_url">
                <input type="hidden" name="LnK" value="1">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <input type="text" name="LnKU" value="$LnkL" size="60" maxlength="95"><br>
                <b><font size="1" face="Verdana, Arial, Geneva, Helvetica">ADMIN word</font></b> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" value="Save LnkinLite URL" name="submit">
                <input type="reset" name="reset" value="reset"></form></td>
          </tr><tr bgcolor="#FFFFFF"> 
            <td align="center"> <font size="1">&nbsp;&nbsp;</font><br>
              <table border="0" cellspacing="0" cellpadding="0" width="200">
                <tr align="center" bgcolor="#E5E5E5"> 
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
                      <tr bgcolor="#FFFFFE"> 
                        <th colspan="3"><font face="Verdana, Arial, Geneva, Helvetica" size="1">Program Files status</font></th>
                      </tr><tr bgcolor="#999999"> 
                        <td><font color="#FFFFFF" face="Verdana, Arial, Geneva, Helvetica" size="1"><b>&nbsp;&nbsp;file</b></font></td>
                        <th><font color="#FFFFFF" face="Verdana, Arial, Geneva, Helvetica" size="1">path</font></th>
                        <th><font color="#FFFFFF" face="Verdana, Arial, Geneva, Helvetica" size="1">bytes</font></th>
                      </tr>$fList</table></td>
                </tr></table><font size="1">&nbsp;</font></td>
          </tr><tr bgcolor="#FFFFFF"><td align="center" width="100%"><table border="0" cellspacing="0" cellpadding="0"><tr><td><font face="Verdana, Arial, Geneva, Helvetica" size="1" color="#666666">latest available version...&nbsp;</font></td><td><font size="1"><a href="http://dtp-aus.com/cgiscript/emlscrpt.shtml" target="_blank"><img src="http://dtp-aus.com/cgi-bin/getv.pl?el" alt="program page" width="75" height="13" border="0"></a></font></td></tr></table></td>
          </tr>~; if (-s "$uL") { print qq~<tr bgcolor="#FFFFFF"><td align="center" width="100%"><form method="post" action="$uload_url" target="_blank">
            <input type="hidden" name="wrd" value="$FORM{'wrd'}"><input type="hidden" name="uL" value="1">
            <table width="75%" cellpading=1 cellspacing=0 border=0><tr><td align=center bgcolor="#999999"><table width="100%" cellpading=3 cellspacing=0 border=0><tr>
            <td align="center" width="100%" bgcolor="#E5E5E5"><font face="Verdana, Arial, Geneva, Helvetica" size="1">PC to List <b>File Up-Load</b> </font>
             <input type="submit" value="       Up-Load a List       " name="submit"></td></tr></table></td></tr></table></form></td>
          </tr>~;} print qq~<tr> 
            <td bgcolor="#FFFFFF"> 
              <form method="post" action="$admn_url">
                <input type="hidden" name="gped" value="1">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <center><table width="75%" border="0" cellspacing="0" cellpadding="1">
                    <tr><th colspan="4" bgcolor="#666666"><font face="Verdana, Arial, Geneva, Helvetica" size="2" color="#FFFFFF">Change ACCESS Password</font></th>
                    </tr><tr> 
                      <td colspan="4" align="center"><font size="1" face="Verdana, Arial, Geneva, Helvetica">Admin 
                        access and Form Testing (no saving).</font></td>
                    </tr><tr> 
                      <td align="right"><font face="Verdana, Arial, Geneva, Helvetica" size="1">NEW 
                        <b>Access</b></font></td>
                      <td><input type="text" name="nApwrd1" size="10" maxlength="15"></td>
                      <td align="right"><font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>Repeat</b> New</font></td>
                      <td><input type="text" name="nApwrd2" size="10" maxlength="15"></td>
                    </tr><tr align="center"> 
                      <td colspan="4"> <b><font size="1" face="Verdana, Arial, Geneva, Helvetica">ADMIN word</font></b> 
                        <input type="password" name="adminspwrd" size="10" maxlength="15">
                        <input type="submit" name="submit" value="Change">
                        <input type="reset" name="reset" value="reset"></td>
                    </tr></table></center></form>
              <form method="post" action="$admn_url">
                <input type="hidden" name="aped" value="1">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <center><table width="75%" border="0" cellspacing="0" cellpadding="1">
                    <tr bgcolor="#666666"> 
                      <th colspan="4"><font size="2" face="Verdana, Arial, Geneva, Helvetica" color="#FFFFFF">Change ADMIN Password</font></th>
                    </tr><tr> 
                      <td colspan="4" align="center"><font size="1" face="Verdana, Arial, Geneva, Helvetica">Allows admin saving of edited options.</font></td>
                    </tr><tr> 
                      <td align="right"><font face="Verdana, Arial, Geneva, Helvetica" size="1">NEW 
                        <b>Admin</b></font></td>
                      <td> <input type="text" name="newpwrd1" size="10" maxlength="15"></td>
                      <td align="right"><font size="1" face="Verdana, Arial, Geneva, Helvetica"><b>Repeat</b> 
                        New</font></td>
                      <td><input type="text" name="newpwrd2" size="10" maxlength="15"></td>
                    </tr><tr align="center"> 
                      <td colspan="4"><b><font size="1" face="Verdana, Arial, Geneva, Helvetica">ADMIN 
                        word</font></b> 
                        <input type="password" name="adminspwrd" size="10" maxlength="15">
                        <input type="submit" name="submit" value="Change">
                        <input type="reset" name="reset" value="reset"></td>
                    </tr></table></center></form></td>
          </tr><tr bgcolor="#666666"> 
            <td align="center"><font size="2" face="Verdana, Arial, Geneva, Helvetica" color="#FFFFFF"><b>Change GMT zone value</b> - current : $Tm</font></td>
          </tr><tr> 
            <td bgcolor="#FFFFFF">
              <form method="post" action="$admn_url" name="Gm" onSubmit="return doChnge(this);">
                <input type="hidden" name="gmed" value="y">
                <input type="hidden" name="wrd" value="$FORM{'wrd'}">
                <center><table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr><td align="center" bgcolor="#666666"><font face="arial,geneva,helvetica" size="2"><b><font color="#FFFFFF">GMT</font></b></font><br>
                        <input type="text" name="gmt" size="8" value="$isGmt" maxlength="6">
                        <br><font face="arial,geneva,helvetica" size="2" color="#FFFFFF">&nbsp;Hours&nbsp;+&nbsp;or&nbsp;-&nbsp;</font></td>
                      <td colspan="3" bgcolor="#E5E5E5"><input type="checkbox" name="gmted" value="y">
                        <font face="arial,geneva,helvetica" size="2"><b><font face="Verdana, Arial, Geneva, Helvetica" size="1">Confirm 
                        CHANGE</font></b><font face="Verdana, Arial, Geneva, Helvetica" size="1"><small><br>
                        If you move from the current time zone, or change to / from daylight savings, enter the new value and tick &quot;Change&quot;. 
                        Even if the local GMT time zone equals the servers, you must have your local GMT time zone value entered here.<br>
                        (<b>ie</b> 5.5 or -9 etc) - <i>affects ALL HostingNet programs</i><br>
                        &nbsp;&nbsp; ...<i>refer to your PC Clock set up</i></small></font></font></td>
                    </tr><tr> 
                      <td colspan="4" align="center"><b><font size="1" face="Verdana, Arial, Geneva, Helvetica">ADMIN word</font></b> 
                        <input type="password" name="adminspwrd" size="10" maxlength="15">
                        <input type="submit" name="submit" value="Change">
                        <input type="reset" name="reset" value="reset"></td>
                    </tr></table></center></form></td>
          </tr></table></td>
    </tr><tr><td align="center"><font face="arial, geneva, helvetica" size="1">E-Lists v2.2</font></td></tr></table>&nbsp;</center></body></html>
~; exit;
}


sub edits {
	local $salta; my @theAword;
if (!( -e "$main::admin_pth"."elist.pw")) {open(FF,">>$main::admin_pth"."elist.pw") || &showErr('Missing ADMIN Password File'); print FF "Do NOT Edit\n"; close(FF);}
	open(ADMwrd, "<$main::admin_pth"."elist.pw") || &showErr('ADMIN Password File Access');
 	 eval"flock (ADMwrd, 2)"; @theAword = <ADMwrd>; eval"flock (ADMwrd, 8)";
	close(ADMwrd);
	if ($theAword[1] || $main::FORM{'adminspwrd'}) {
		if (crypt($main::FORM{'adminspwrd'},$main::FORM{'adminspwrd'}) ne $theAword[1]) {$errBox = 'Incorrect ADMIN Password'; &begin;}
	}
if ($main::FORM{'aped'} eq "1") {
	if ($main::FORM{'newpwrd1'} ne $main::FORM{'newpwrd2'}) {$errBox = 'New ADMIN Password Entries Do Not Match'; &begin;}
	elsif ($main::FORM{'newpwrd1'} eq $main::FORM{'adminspwrd'}) {$errBox = 'No Admin-Password Change Requested'; &begin;}
	$theAword[1] = crypt($main::FORM{'newpwrd1'},$main::FORM{'newpwrd1'});
		open(ADMwrd, ">$main::admin_pth"."elist.pw") || &showErr('ADMIN Password File Access');
 		 eval"flock (ADMwrd, 2)"; print ADMwrd @theAword; eval"flock (ADMwrd, 8)";
		close(ADMwrd);
		$errBox = 'New E-Lists ADMIN Password Installed'; &begin;
}
elsif ($main::FORM{'gped'} eq "1") {
	if ($main::FORM{'nApwrd1'} ne $main::FORM{'nApwrd2'}) {$errBox = 'New Password Entries Do Not Match'; &begin;}
	elsif ($main::FORM{'nApwrd1'} eq $main::FORM{'wrd'}) {$errBox = 'No Access-Password Change Requested'; &begin;}
	$s1 = "\$theword = \"$main::FORM{'nApwrd1'}\";\n";
	$s2 = 0;
	open (CNF, "<$main::cnfg_pth" ) || &showErr('Config File Access');
 	 eval"flock (CNF, 2)"; @varyin = <CNF>; eval"flock (CNF, 8)";
	close (CNF);
		for($cnts = 0; $cnts < @varyin; $cnts++) {
			if ($varyin[$cnts] =~ /\$theword/) {
				$varyin[$cnts] = $s1;
				$s2 = 1; last;			
			}  }
		if ($s2 eq 0) {$errBox = '$theword - Config Variable Not Found'; &begin;}
	open (CNF, ">$main::cnfg_pth" ) || &showErr('Config File Access');
 	 eval"flock (CNF, 2)"; print CNF @varyin; eval"flock (CNF, 8)";
	close (CNF);
		$main::theword = $main::FORM{'wrd'} = $main::FORM{'nApwrd1'}; $main::cwrd = crypt($main::theword,$main::bitword);
		$errBox = 'New E-Lists ACCESS Password Installed'; &begin;
}
elsif ($main::FORM{'gmted'} eq "y") {
	if ($main::FORM{'gmt'} !~ /^(\+?|\-?)[0-9]+/) {$errBox = "GMT Value Error"; &begin;}
	elsif ($main::FORM{'gmt'} > 12 || $main::FORM{'gmt'} < -12) {$errBox = "GMT <> + or - 12"; &begin;}
		$s1 = "\$gmtPlusMinus = ". int(($main::FORM{'gmt'} * 60 * 60)).";\n";
		my $new = int(($main::FORM{'gmt'} * 60 * 60));
	open (GMT, "<$gmt_pth") || &showErr('gmtset.pl File Access');
 	 eval"flock (GMT, 2)"; @gmtin = <GMT>; eval"flock (GMT, 8)";
	close (GMT);
		$cnts = 0; $s3 = 0;
		foreach $s2 (@gmtin) {
			if ($s2 =~ /\$gmtPlusMinus/) {$gmtin[$cnts] = $s1; $s3 = 1; next;}
		$cnts++;
		}
		if ($s3 eq 0) {$errBox = "gmtset.pl Config Variable Not Found"; &begin;}
	open (GMT, ">$gmt_pth") || &showErr('GMTSET File Access');
 	 eval"flock (GMT, 2)"; print GMT @gmtin; eval"flock (GMT, 8)";
	close (GMT);
		$gmtPlusMinus = $new;
	$errBox = "New GMT Value is set"; &begin;
}

elsif ($main::FORM{'addLnme'} eq "1" && $main::FORM{'lstTyp'} =~ /^[0-5]$/ && $main::FORM{'nLstNme'} =~ /^\.?\w+$/ && $main::FORM{'nLstDesc'} =~ /^[\w+ ?]/) { 
	my (@hold, $typ,$nme,$dsc,$tmp1,$tmp2,$trash,@OUt,$Lin); my $optn = '0'; my $ALcnt = 0; 
	if ($main::FORM{'lstTyp'} < 5 && !&chk_addr($main::FORM{'nAddrss'})) {$errBox = "RECEIVER ADDRESS ERROR Detected"; &begin;} 
	$main::FORM{'nLstNme'} =~ s/(^\s+|\0|\.\.|\\|\/|\$|\r|\n|\Mc|\s+$)//g;
	$main::FORM{'nLstDesc'} =~ s/(^\s+|\0|\/|\\|`|~|#|"|'|!|%|\$|\r|\n|\Mc|\s+$)//g;
	$main::FORM{'nAddnme'} =~ s/(^\s+|\0|\.\.|\\|\/|\$|\r|\n|\Mc|\s+$)//g;
	$main::FORM{'nOrg'} =~ s/(^\s+|\0|\.\.|\\|\/|\$|\r|\n|\Mc|\s+$)//g;
	if ($main::FORM{'lstTyp'} =~ /^[0-4]$/ && (!$main::FORM{'nAddrss'} || !$main::FORM{'nAddnme'})) {$errBox = "Must Include Receiver Address AND Name"; &begin;}
		@hold = @alwFiles;
	foreach (@alwFiles) {
		if ($_ =~ /^(\d):([^:].+):(.+):(\d$)/) {
			$tmp1 = $1; $tmp2 = $2;
			if ($main::FORM{'nLstNme'} =~ /^$tmp2$/i) { 
				if (-s "$listDir$tmp2$list_exten") {$main::FORM{'lstTyp'} = $typ = $tmp1;}
				else {$typ = $main::FORM{'lstTyp'};}
				$main::FORM{'nLstNme'} = $nme = $tmp2;
				last;
	}	} $ALcnt++; }
	if (!$nme) {$nme = $main::FORM{'nLstNme'}; $errBox = "1";}
	if ($typ !~ /^[0-5]$/) {$typ = $main::FORM{'lstTyp'};}
	if ($typ !~ /^[0-5]$/) {$errBox = "List Format Must Be [ 0 - 5 ]"; &begin;}
	$dsc = $main::FORM{'nLstDesc'};
	$optn = "1" if $FORM{'optIn'};
	if ($typ == 5) {$optn = "0";}
		$alwFiles[$ALcnt] = "$typ:$nme:$dsc:$optn";
		$trash .= join "','",@alwFiles;
    if (open (CF, "<$cnfg_pth")) {
		eval"flock(CF,2)";	
    	while ($Lin = <CF>) {
    		chomp $Lin;
    		if ($Lin =~ /\@alwFiles/s) {push (@OUt," 	\@alwFiles = ('$trash');\n");}
    		else {push (@OUt,"$Lin\n");}
    } eval"flock(CF,8)"; close(CF); }
	else {$errBox = "Cannot READ Config File"; @alwFiles = @hold; &begin;}
    if (open (CF, ">$cnfg_pth")) {
		eval"flock(CF,2)"; print CF @OUt;	
    	eval"flock(CF,8)"; close(CF); }
	else {$errBox = "Cannot WRITE to Config File"; @alwFiles = @hold; &begin;}
	$errBox = "New List Name Added!" if $errBox eq "1";
	$errBox .= " 'Allowed List' Updated";
		    if ($typ == 5) {unlink "$admin_pth$nme.adr";}
		    if ($typ < 5 && open (AF,">$admin_pth$nme.adr")) {print AF "$main::FORM{'nAddrss'}:$main::FORM{'nAddnme'}:$main::FORM{'nOrg'}"; close(AF);}
			else {$errBox .= ". Address File Not Created";}
		if (!(-e "$listDir$nme$list_exten")) {
		   	if (open (CF,">$listDir$nme$list_exten")) {
		    	close(CF); $errBox .= ". NEW LIST Created!"; }
			else {$errBox .= ". Could Not CREATE NEW List!";}
		}
		else {$errBox .= ". List Exists!";}
 	&begin;
}
elsif ($main::FORM{'delLnme'} eq "1") {
	my (@hold,$ALcnt,$tmp1,$tmp2,$trash,@OUt,$Lin);
	($trash,$tmp2,$trash,$trash) = split (/:/,$FORM{'delAllw'});
	@hold = @alwFiles;
	for ($ALcnt = 0; $ALcnt < @alwFiles; $ALcnt++) {
		if ($alwFiles[$ALcnt] =~ /^(\d):([^:].+):(.+):(\d$)/) {
			if (uc($tmp2) eq uc($2)) { 
				splice (@alwFiles,$ALcnt,1);
				$errBox = "1";
				last;
	}	}	}
	if ($errBox ne "1") {$errBox = "Matching List Name Not Found! Cannot delete"; &begin;}
	$trash = ""; $trash = join "','",@alwFiles;
	$trash = "'".$trash."'" if $trash;
    if (open (CF, "<$cnfg_pth")) {
		eval"flock(CF,2)";	
    	while ($Lin = <CF>) {
    		chomp $Lin;
    		if ($Lin =~ /\@alwFiles/s) {push (@OUt," 	\@alwFiles = ($trash);\n");}
    		else {push (@OUt,"$Lin\n");}
    } eval"flock(CF,8)"; close(CF); }
	else {$errBox = "Cannot READ Config File"; @alwFiles = @hold; &begin;}
    if (open (CF, ">$cnfg_pth")) {
		eval"flock(CF,2)"; print CF @OUt; eval"flock(CF,8)"; close(CF); }
	else {$errBox = "Cannot WRITE to Config File"; @alwFiles = @hold; &begin;}
	$errBox = "[ $tmp2 ] List Name Deleted from 'Allowed' list!";
		if ($FORM{'auxDel'} eq "1") {
		    unlink ("$listDir$tmp2$list_exten",
		    "$admin_pth$tmp2.non",
		    "$admin_pth$tmp2.pl",
		    "$admin_pth$tmp2.adr",
		    "$admin_pth$tmp2.txt");
		    $errBox .= ". ALL FILES DELETED!"; }
 	&begin;
}
elsif ($main::FORM{'LnK'} eq "1") {
	$main::FORM{'LnKU'} =~ s/(^\s+|\0|\.\.|\$|\r|\n|\Mc|\s+$)//g;
	if ($main::FORM{'LnKU'} && $main::FORM{'LnKU'} !~ m#^https?://.+#) {$errBox = "LnkinLite URL ERROR - must be a proper full URL"; &begin;}
	if ($main::FORM{'LnKU'}) {
		if (open (LK, ">$admin_pth"."lnklite.pth")) {print LK $main::FORM{'LnKU'}; close(LK);}
		else {$errBox = "Failure WRITING to file [ lnklite.pth ]"; &begin;}	}
	else {unlink ("$admin_pth"."lnklite.pth");}	
	$errBox = "LnkinLite URL Editing complete"; &begin;
}
else {$errBox = "Form Options Empty or Not Recognised"; &begin;}
exit;
}
1;
