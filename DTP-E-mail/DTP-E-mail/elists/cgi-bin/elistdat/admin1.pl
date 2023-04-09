# E-Lists 2.2 DO NOT EDIT
sub show_admin {
$EFrm = qq~ function MLWindow(prog,winis,stuff) {
	winis=open(prog,winis,stuff);
 strng = "<html><head>\\r\\n";
 strng += "<title>E-Lists Administration</title>\\r\\n";
 strng += "</head>\\r\\n";
 strng += " <body bgcolor=#F5F5F5 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>\\r\\n";
 strng += "   <center>&nbsp;<br><table width=340 border=0 cellspacing=0 cellpadding=1>\\r\\n"; 
 strng += "      <tr><th><font face=\\"Verdana,Arial,Geneva,Helvetica\\" size=2>This pop-up window can be resized</font></th></tr>\\r\\n";
 strng += "      <tr><th><font face=\\"Verdana,Arial,Geneva,Helvetica\\" size=1>&#149; <font color=\\"#0000CC\\">Close this window to return to Admin</font> &#149;</font></th></tr>\\r\\n";
 strng += "      <tr><th><font face=\\"Verdana,Arial,Geneva,Helvetica\\" size=1>&#149; Remember to refresh the admin page when finished &#149;</font></th></tr></table></center>\\r\\n";
 strng += " <form align=center method=POST action=$prog_url>\\r\\n";
 strng += "     <input type=hidden name=frmref value=\\"$REFS{'frmRef'}\\">\\r\\n";
 strng += "     <input type=hidden name=df value=\\"$thuLstEx" + "::\\">\\r\\n";
 strng += "     <input type=hidden name=thnx value=\\"pop\\">\\r\\n";
 strng += "     <input type=hidden name=cwrd value=\\"$main::cwrd\\">\\r\\n";
 strng += "    <center><table border=0 width=340 cellspacing=0 cellpadding=1>\\r\\n";
 strng += "      <tr bgcolor=#666666>\\r\\n"; 
 strng += "        <td align=center colspan=2><font size=2 face=\\"Verdana,Arial,Geneva,Helvetica\\" color=#FFFFFF><b>Subscribe to</b> &quot;$REFS{'frmRef'}&quot; <b>List</b></font></th></tr>\\r\\n";
~;
      $EFrm .= qq~ strng += "    <tr bgcolor=#FFFFFE><th width=100% colspan=2><font face=\\"Verdana,Arial,Geneva,Helvetica\\" size=1>Subscribe <input type=radio checked value=0 name=unsub> UN-Subscribe  <input type=radio value=1 name=unsub></font></th></tr>\\r\\n";~;
      if ($REFS{'addr_only'} < 5 && $REFS{'opit'} == 1) {
      $EFrm .= qq~ strng += "    <tr bgcolor=#FFFFFE><td width=100% colspan=2 align=center><font face=\\"Verdana,Arial,Geneva,Helvetica\\" size=1>NOTE: Mail will be sent to recipients if using this option!</font></td></tr>\\r\\n";
~;}
      $EFrm .= qq~ strng += "    <tr bgcolor=#FFFFFE>\\r\\n"; 
 strng += "        <td width=30% align=right><font face=\\"Verdana,Arial,Geneva,Helvetica\\" size=1><b>Address </b> </font></td>\\r\\n";
 strng += "        <td width=70%><input type=text name=from size=25></td></tr>\\r\\n";
~;
      if ($REFS{'addr_only'} < 3) { $EFrm .= qq~ strng += "     <tr bgcolor=#FFFFFE>\\r\\n";
 strng += "        <td width=30% align=right><font size=1 face=\\"Verdana,Arial,Geneva,Helvetica\\"><b>Name</b> </font></td>\\r\\n";
 strng += "        <td width=70%><input type=text name=fstname size=25></td></tr>\\r\\n";
~;}
      $EFrm .= qq~ strng += "     <tr bgcolor=#FFFFFE>\\r\\n"; 
 strng += "        <td colspan=2 align=center><input type=submit value=\\"Submit Address\\" name=send></td>\\r\\n";
 strng += "      </tr></table></center></form>\\r\\n";
 strng += "      </body></html>\\r\\n";
	winis.document.write(strng);
}
~;
	if ($REFS{'addr_only'} < 5) {
		&read_file("$listDir$thuLst"); &get_txt("$admin_pth$thuLstEx.txt");	}
	local ($recs,$rjLSt,$rJ,$F1,$F2,$F3,$F4,%Tp,$tYp); my ($LnkL,$LnkLp);
		$recs = @entries;
	if (open RF, "<$admin_pth$thuLstEx.non") {
		while ($rJ = <RF>) {chomp ($rJ); $rJ =~ s/(^\s+|\s+$|\r+|\n+)//g; $rjLSt .= $rJ."\n"; } close (RF);
	}  $rjLSt =~ s/(\n+|(\r\n)+)$//;
		%Tp = (0=>"address".$sep."name".$sep."date",1=>"address".$sep."name",2=>"name".$sep."address",3=>"address",4=>"address".$sep."date",5=>" redirect to auto-responder");
		$tYp = qq~
	  <table width="100%" border="0" cellspacing="0" cellpadding="5"><tr bgcolor="#660000"> 
	    <th><font face="Verdana, Arial, Geneva, Helvetica" color="#FFFFFF" size="2">Enabled List Type is [ <b>$REFS{'addr_only'}</b> ] - <b>$Tp{$REFS{'addr_only'}}</b></font></th></tr>~;
	if ($recs && $REFS{'addr_only'} < 5) { ($ens = $entries[0]) =~ s/[$sep]/ \&#149; /g;
	$tYp .= qq~  <tr align="center" bgcolor="#F5F5F5"><td><font face="Verdana, Arial, Geneva, Helvetica" size="1"><font color="#666666">The first record in this list is</font><font size="1"><br>$ens</font></font></td></tr>~;}
	$tYp .= qq~  </table>~;

	( -e "$admin_pth$thuLstEx.adr") ? ($F0 .= "(YES)") : ($F0 .= "(<font color=\"#CC0000\"><b>NO</b></font>)") if $REFS{'addr_only'} < 5;
	( -e "$admin_pth$thuLstEx.txt") ? ($F1 .= "(YES)") : ($F1 .= "(<font color=\"#CC0000\"><b>NO</b></font>)") if $REFS{'addr_only'} < 5;
	( -e "$admin_pth$thuLstEx.non") ? ($F2 .= "(YES)") : ($F2 .= "(<font color=\"#CC0000\"><b>NO</b></font>)");
	( -e "$admin_pth$thuLstEx.pl") ? ($F3 .= "(YES)") : ($F3 .= "(<font color=\"#CC0000\"><b>NO</b></font>)") if $REFS{'addr_only'} == 5;
		$F0 = "$thuLstEx.<b>adr</b> $F0 - your address/name<br>" if $REFS{'addr_only'} < 5 && $F0;
		$F1 = "$thuLstEx.<b>txt</b> $F1 - response text<br>" if $REFS{'addr_only'} < 5 && $F1;
		$F2 = "$thuLstEx.<b>non</b> $F2 - rejects list<br>" if $F2;
		$F3 = "$thuLstEx.<b>pl</b> $F3 - autoresponder data<br>" if $REFS{'addr_only'} == 5 && $F3;
			$F4 = qq~</font></td></tr><tr><td colspan="2" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>manually</b> create/edit the <b>$thuLstEx.pl</b> file if using this option!<br>&nbsp;~ if $F3;
		$AA = ""; 
		if ($REFS{'opit'} == 1 && open (WK, "<$main::admin_pth$aux_pth"."waits.wt")) {
				@Wk = <WK>; close (WK); $AA = $UU = '0';
		 	foreach $wkin (@Wk) {
		 		if ($wkin =~ /^A\0/ && $wkin =~ /\0$thuLstEx\0/) {$AA++;}
		 		elsif ($wkin =~ /^U\0/ && $wkin =~ /\0$thuLstEx\0/) {$UU++;} }
		 $AA = qq~<tr><td colspan="2" align="center"><font face="Verdana,Arial,Geneva,Helvetica" size="2">Subscribers waiting = $AA. UN-Subcribers waiting = $UU.<br>&nbsp;</font></td></tr>~; }
	$errBox = qq~<tr bgcolor="#CC0000"><th width="100%" bgcolor="#CC0000"><font face="verdana,arial,geneva,helvetica" size="1" color="#FFFFFF">$errBox</font></th></tr>~ if $errBox;
		if (open (LK, "<$admin_pth"."lnklite.pth")) {($LnkL,$LnkLp) = split(/\?/,<LK>); close(LK);} 
		$LnkL = "" if $LnkL !~ m#\Ahttps?://#; $LnkL =~ s/(\0|\s|\;|`)//g; if ($LnkL) {$LnkLp =~ s/p=//;} else {$LnkLp = "";}  
	print "Content-type: text/html\n\n";
print qq~
<html><head>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>E-Lists Administration</title>
<script language="JavaScript"><!-- 
$EFrm
 function ELWindow(prog,winis,stuff) {window.open(prog,winis,stuff);}
 function doDelet(Frm) {
	if (Frm.name == "kil") {
	if (Frm.deladdr[0].status == false && Frm.deladdr[1].status == false) {
		alert ("Please CONFIRM an option"); return false;	}
	else {if (Frm.deladdr[1].status == true) {
	 		return confirm("WARNING: This will DELETE ALL records");	}	}	}
 }
//-->
</script>
</head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center><b><font face="Verdana, Arial, Geneva, Helvetica" size="3">E-Lists Administration</font><font face="arial,geneva,helvetica" size="4"><br>
  <font color="#CC0000" size="4" face="Verdana, Arial, Geneva, Helvetica">$REFS{'frmRef'}</font> <font size="3"></b>[ <b>$thuLst</b> ]</font></font><BR>
  <font face="Verdana, Arial, Geneva, Helvetica" size="2">&#149; <b><a href="$admn_url?wrd=$FORM{'wrd'}">Program Defaults</a></b> &#149;</font><br><font size="1">&nbsp;</font> 
<table width="570" border="0" cellspacing="0" cellpadding="0" align="center">
$errBox 
  <tr align="center" bgcolor="#DFDFDF"> 
   <td>$tYp<table border="0" cellspacing="0" cellpadding="1"><tr> 
     <td valign="top"> <font size="1" face="Verdana, Arial, Geneva, Helvetica">Auxiliary Files found... </font></td>
     <td valign="top"><font size="1" face="Verdana, Arial, Geneva, Helvetica">$F0$F1$F2$F3$F4</font></td></tr>$AA</table>
  </td></tr>
  <tr align="center" bgcolor="#DFDFDF"><td>
   <table border="0" cellspacing="0" cellpadding="1"><tr>
    <td align=center><form><INPUT type="button" value="Subscribe to this list" onClick="MLWindow('','','status=1,scrollbars=1,resizable=1,width=450,height=350');">&nbsp;</form></td>
    <td align=center><form method="post" action="$admn_url">
    &nbsp;<INPUT type="submit" value="Refresh this admin page">
    <input type="hidden" name="bgnslct" value="$thuLst">
    <input type="hidden" name="form" value="begin">
    <input type="hidden" name="wrd" value="$FORM{'wrd'}"></form></td></tr></table></td></tr>
  <tr align="center" bgcolor="#DFDFDF"><td>~; 
      if ($REFS{'addr_only'} < 5) { print qq~
      <form method="POST" action="$admn_url" name="kil" onSubmit="return doDelet(this);">
        <input type="hidden" name="aded" value="y">
        <input type="hidden" name="df" value="$thuLstEx">
        <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
        <input type="hidden" name="wrd" value="$FORM{'wrd'}">
        <center><table border="0" width="80%" cellspacing="0" cellpadding="1">
            <tr bgcolor="#666666"><td valign="middle" align="center" colspan="3"><font size="2" face="arial,geneva,helvetica" color="#FFFFFF"><b>Delete</b> &quot;$REFS{'frmRef'}&quot; <b>Record</b></font></td>
            </tr><tr bgcolor="#FFFFFE" align="center"> 
              <td valign="top" colspan="3"><font face="arial,geneva,helvetica" size="2">&nbsp;<font face="Verdana, Arial, Geneva, Helvetica" size="1">To delete an address, enter correct address and tick &quot;Confirm Delete&quot;.</font></font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td valign="middle" align="center" width="15%"><font face="arial,geneva,helvetica" size="2"><b><font face="Verdana, Arial, Geneva, Helvetica">Records</font></b><font face="Verdana, Arial, Geneva, Helvetica"><br>
                <font size="3" color="#CC3300"><b>$recs</b></font></font></font></td>
              <td valign="middle" align="center" width="50%"><font face="Verdana, Arial, Geneva, Helvetica" size="1">Enter <b>E-Mail ADDRESS to Delete:</b></font><br>
                <input type="text" name="addrtxt" size="25">
              </td><td width="35%" align="center" valign="middle" bgcolor="#FFFFFE"> 
                <input type="radio" value="d" name="deladdr">
                <font face="Verdana, Arial, Geneva, Helvetica" size="1" color="#CC0000"><b>Confirm<font size="2"> Delete</font></b></font></td>
            </tr><tr bgcolor="#FFEFEF"> 
              <td valign="top" align="center" colspan="3"><font face="arial,geneva,helvetica" size="2"> 
                <input type="radio" name="deladdr" value="k">
                <b><font face="Verdana, Arial, Geneva, Helvetica">KILL</font></b><font face="Verdana, Arial, Geneva, Helvetica">&nbsp;&nbsp;<font size="1">Note: 
                This option will <b>DELETE ALL records</b> from the mail list.</font></font></font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="591" valign="top" align="center" colspan="3"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>admin</b> Password</font> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" value="Edit Address list"> <input type="reset" value="reset"></td>
            </tr></table></center></form>
      <form method="POST" action="$admn_url">
        <input type="hidden" name="srch" value="y">
        <input type="hidden" name="df" value="$thuLstEx">
        <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
        <input type="hidden" name="wrd" value="$FORM{'wrd'}">
        <center><table border="0" width="80%" cellspacing="0" cellpadding="1">
            <tr><td width="100%" align="center" bgcolor="#666666"><font size="2" face="arial,geneva,helvetica" color="#FFFFFF"><b>Search and Delete</b> - &quot;$REFS{'frmRef'}&quot; list</font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="99%" align="center"> <font face="verdana, arial, geneva, helvetica" size="1">lists 
                a maximum of 200 per page</font><b><font face="arial, geneva, helvetica" size="2"><br>Search text</font></b> 
                <input type="text" name="srchtxt" size="20" maxlength="35"></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="99%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">ONLY 
                single words, or words seperated by [ dot dash underline ]( <b>. - _</b> )</font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="99%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">Use 
                only partial addresses in the text box - <i>ie</i> before OR after the @ sign.<br>
                <font color="#000066">if the @ sign is included only the first half of your text will be used!</font></font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%" valign="top" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>admin</b> Password</font> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" value="Search the List">
                <input type="reset" value="reset"></td>
            </tr></table></center></form>
      <form method="POST" action="$admn_url" target="_blank">
        <input type="hidden" name="lstall" value="1">
        <input type="hidden" name="df" value="$thuLstEx">
        <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
        <input type="hidden" name="next" value="0">
        <input type="hidden" name="wrd" value="$FORM{'wrd'}">
        <center><table border="0" width="80%" cellspacing="0" cellpadding="1">
            <tr><td width="100%" align="center" bgcolor="#666666"><font size="2" face="arial,geneva,helvetica" color="#FFFFFF"><b>List</b> &quot;$REFS{'frmRef'}&quot; <b>subscribers</b></font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="99%" align="center"> <font face="verdana, arial, geneva, helvetica" size="1" color="#CC0000">lists a maximum of 200 per page</font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%" valign="top" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>admin</b> Password</font> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" value="  List Subscribers  "></td>
            </tr></table></center></form>~;}
      print qq~
<form align="center" method="POST" action="$admn_url">
        <input type="hidden" name="edrej" value="1">
        <input type="hidden" name="df" value="$thuLstEx">
        <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
        <input type="hidden" name="wrd" value="$FORM{'wrd'}">
  <center><table border="0" width="80%" cellspacing="0" cellpadding="1">
      <tr bgcolor="#666666"> 
        <td valign="middle" align="center"><font size="2" face="Verdana, Arial, Geneva, Helvetica" color="#FFFFFF"><b>Rejected Domains/Addresses</b> - &quot;$REFS{'frmRef'}&quot; </font></td>
      </tr><tr bgcolor="#FFFFFE" align="center"> 
        <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="1">
         <tr><td valign="top"><p><b><font size="1" face="Verdana, Arial, Geneva, Helvetica">Domain Blocking<br>
          </font></b><font size="1" face="Verdana, Arial, Geneva, Helvetica">This is a rejection list for....<br> &#149; Full Domain Names,<br>
          &#149; Partial Domain Names,<br> &#149; E-Mail addresses.<br>&nbsp;&nbsp;....ie<br>
          &quot;afreemail.com&quot;<br>&nbsp;&nbsp;is a full name,<br> &quot;afreemail.&quot; <i>with end dot</i><br>&nbsp;&nbsp;is a partial domain name,<br>
          &quot;wally\@afreemail.com&quot;<br>&nbsp;&nbsp;is an address.</font></p></td>
          <td width="60%" valign="top"><textarea name="rejLst" cols="30" rows="8" wrap="OFF">$rjLSt</textarea></td></tr></table></td>
      </tr><tr bgcolor="#FFFFFE">
        <td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">Hit <b>the Enter Key after each</b> entry to create a list.</font></td>
        </tr><tr bgcolor="#FFFFFE">
        <td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>admin</b> Password</font> 
          <input type="password" name="adminspwrd" size="10" maxlength="15">
          <input type="submit" value="Create/Save List" name="send"></td>
      </tr></table></center></form></td></tr>~;
      if ($REFS{'addr_only'} < 5) { print qq~
    <tr align="center" bgcolor="#DFDFDF"> 
      <td><form method="POST" action="$admn_url">
          <input type="hidden" name="doDB" value="1">
          <input type="hidden" name="df" value="$thuLstEx">
          <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
          <input type="hidden" name="wrd" value="$FORM{'wrd'}">
          <table border="0" width="80%" cellspacing="0" cellpadding="1">
            <tr bgcolor="#666666"> 
              <td width="100%" align="center" colspan="3"><font size="2" face="arial,geneva,helvetica" color="#FFFFFF"><b>Create DB file</b> for &quot;Test Form one&quot;</font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%" align="center" colspan="3"> 
               <table width="95%" border="0" cellspacing="0" cellpadding="8">
                <tr><td><font face="Verdana, Arial, Geneva, Helvetica" size="1">If FTP downloading a mail list in to a program on your local 
                PC, AND the default list extension OR your default record field delimiter is unsuitable, this option enables the creation of a duplicate copy of this list...<br>
                &#149; with a file extension of &quot;.txt&quot;, <i>...or</i><br>&#149; with a file extension of &quot;.csv&quot; <i>- common text import for MS Excel.</i></font></td></tr></table></td>
            </tr><tr bgcolor="#F5F5F5"> 
              <td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>Extension</b> <br></font> 
                <input type="radio" name="dbExt" value="t" checked>
                <font face="Verdana, Arial, Geneva, Helvetica" size="1">'<b>.txt</b>' </font> 
                <input type="radio" name="dbExt" value="c">
                <font face="Verdana, Arial, Geneva, Helvetica" size="1">'<b>.csv</b>'</font></td>
              <td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1">add <b>quotes</b><br></font> 
                <input type="checkbox" name="dbQ" value="1">
                <font face="Verdana, Arial, Geneva, Helvetica" size="1">(&quot;field&quot;)</font></td>
              <td align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>end delimiter<br></b> </font> 
                <input type="checkbox" name="dbEnd" value="1">
                <font face="Verdana, Arial, Geneva, Helvetica" size="1">(,)field,field(,)</font></td>
            </tr><tr bgcolor="#F5F5F5"> 
              <td width="100%" colspan="3" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>field delimiter</b></font> 
                <input type="radio" name="dbDelim" value="0" checked>
                <font face="Verdana, Arial, Geneva, Helvetica" size="1"> ( , ) comma</font> 
                <input type="radio" name="dbDelim" value="1">
                <font face="Verdana, Arial, Geneva, Helvetica" size="1">Tab</font> 
                <input type="radio" name="dbDelim" value="2">
                <font size="1" face="Verdana, Arial, Geneva, Helvetica">( | ) pipe</font></td>
            </tr><tr bgcolor="#F5F5F5">
              <td width="100%" colspan="3" align="center">
                <input type="checkbox" name="dbHead" value="1">
                <font size="1" face="Verdana, Arial, Geneva, Helvetica">Include <b>first line as field name header</b></font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%" valign="top" align="center" colspan="3"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b><font color="#CC0000">This will always overwrite an existing db file; original list is safe!</font><br>
                admin</b> Password</font> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" value="Create DB" name="submit"> <input type="reset" value="reset"> 
              </td></tr></table></form></td>
            </tr>~;
     if ($LnkL) { print qq~<tr align="center" bgcolor="#F5F5F5">
             <td><form method="post" action="$LnkL" target="_blank">
                 <font size="1">&nbsp; &nbsp;</font><br>
                 <input type="submit" value="LnkinLite hyperlink... Create / Get" name="submit">
                 <input type="hidden" name="p" value="$LnkLp"></form></td>
            </tr>~;}
     print qq~<tr align="center" bgcolor="#F5F5F5"> 
     <td><form method="POST" action="$admn_url">
        <input type="hidden" name="edtxt" value="1">
        <input type="hidden" name="df" value="$thuLstEx">
        <input type="hidden" name="frmref" value="$REFS{'frmRef'}">
        <input type="hidden" name="wrd" value="$FORM{'wrd'}">
        <center><table border="0" width="100%" cellspacing="0" cellpadding="1">
            <tr> <td width="100%" align="center" bgcolor="#666666"><font size="2" face="arial,geneva,helvetica" color="#FFFFFF"> 
              <b>Edit Additional auto response text - </b>&quot;<b>$thuLstEx</b>&quot;<b>.txt file</b></font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%"><font face="verdana, arial, geneva, helvetica" size="1"><br></font> 
                <blockquote><font face="verdana, arial, geneva, helvetica" size="1">This box is for editing text included in the auto response email 
                sent to the subscriber. By default an introduction text is added above, and UN-subscribe info is added below the text you enter 
                here. Subscribe and UN-Subscribe yourself to test changes. E-mail programs will also accept space-bar indents at the start of lines.<br>
                <b>NOTE</b>: Around 60 characters is a good line length to pre-wrap text (using the Enter Key) for most mail programs used by recipients; 
                helps ensure easy-to-read paragraphs.</font></blockquote></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%" align="center"> 
                <textarea name="none" cols="65" rows="1" wrap="VIRTUAL">1........10........20........30........40........50........60....</textarea>
                <br><textarea name="adtxt" cols="65" rows="12" wrap="OFF">$sndback</textarea><br>
                <font face="Verdana, Arial, Geneva, Helvetica" size="1">Reference width : textarea is 65 characters wide</font></td>
            </tr><tr bgcolor="#FFFFFE"> 
              <td width="100%" valign="top" align="center"> <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b>admin</b> Password</font> 
                <input type="password" name="adminspwrd" size="10" maxlength="15">
                <input type="submit" value="Save Text Changes" name="submit">
                <input type="reset" value="reset" name="reset">
              </td></tr></table></center></form></td></tr>~;}
      print qq~</table>
	  <font face="Verdana, Arial, Geneva, Helvetica" size="2">&#149; <b><a href="$admn_url?wrd=$FORM{'wrd'}">Program Defaults</a></b> &#149;<br></font><font face="arial,geneva,helvetica" size="1">E-Lists v2.2 copyright</font> 
	  </center></body></html>~;
		#ALL program and copyright notices MUST remain as is and visible on output pages
exit;
} 
sub edits {
if (!( -e "$admin_pth"."elist.pw")) {open(FF,">>$admin_pth"."elist.pw") || &showErr('Missing ADMIN Password File'); print FF "Do NOT Edit\n"; close(FF);}
	open(ADMwrd, "<$admin_pth"."elist.pw") || &showErr('ADMIN Password File Access');
 	 eval"flock (ADMwrd, 2)"; @theAword = <ADMwrd>; eval"flock (ADMwrd, 8)";
	close(ADMwrd);
	if ($theAword[1] || $FORM{'adminspwrd'}) {
		if (crypt($FORM{'adminspwrd'},$FORM{'adminspwrd'}) ne $theAword[1]) {$errBox = "Incorrect ADMIN Password"; &show_admin;}
	}
if ($FORM{'aded'} eq "y" && $FORM{'deladdr'} eq "k") {
		open(ADR, ">$listDir$thuLst") || &showErr('Opening List File');
 		 eval"flock (ADR, 2)"; $fsize = ( -s "$listDir$thuLst" ); eval"flock (ADR, 8)";
		close(ADR);
	if ($fsize) {$errBox = "deletion attempted BUT List File NOT Empty!"; &show_admin;}
	$errBox = "All E-Mail Records Deleted</b> from '$REFS{'frmRef'}' list<b>"; &show_admin;
} 
elsif ($FORM{'aded'} eq "y" && $FORM{'deladdr'} eq "d" && $FORM{'addrtxt'} =~ /\@/) {
	open (ADR, "<$listDir$thuLst") || &showErr("( $thuLst ) List File Access");
 	 eval"flock (ADR, 2)"; @addrin = <ADR>; eval"flock (ADR, 8)";
 	close (ADR);
	$s2 = 0;
	for($s1 = 0; $s1 < @addrin; $s1++) {
			if ($addrin[$s1] =~ /(^|[$sep])$FORM{'addrtxt'}([$sep]|$)/i) {splice(@addrin, $s1, 1); $s2 = 1; last;}
	}	
	if ($s2 == 1) {
		open (ADR, ">$listDir$thuLst") || &showErr('List File Re-Write');
 		 eval"flock (ADR, 2)"; print ADR @addrin; eval"flock (ADR, 8)";
		close (ADR);
		$errBox = "Address Removed</b> from '$REFS{'frmRef'}' list<b>"; &show_admin;
	}
	else {$errBox = "Matching Address NOT found"; &show_admin;}
}
elsif ($FORM{'edtxt'} eq "1") {
		$FORM{'adtxt'} =~ s/^[ ]+$//m;
		$FORM{'adtxt'} =~ s/\"/'/mg;
		$FORM{'adtxt'} =~ s/(\r\n?)/\n/mg;
		$FORM{'adtxt'} =~ s/(\s+|\n+|\r+)$//g;
	if ($FORM{'adtxt'}) {
	$FORM{'adtxt'} .= "\n";
		open(TF,">$admin_pth$thuLstEx.txt") || &showErr('Text File Write Access');
		 eval"flock(TF,2)"; print TF $FORM{'adtxt'}; eval"flock(TF,8)";
		close(TF);
	}
	else {unlink "$admin_pth$thuLstEx.txt" if -e "$admin_pth$thuLstEx.txt";}
		$errBox = "Text-File updated</b> for '$REFS{'frmRef'}' list<b>"; &show_admin;
}
elsif ($FORM{'edrej'} eq "1") {
		$FORM{'rejLst'} =~ s/^[ ]+$//m;
		$FORM{'rejLst'} =~ s/\"/'/mg;
		$FORM{'rejLst'} =~ s/(\r\n?)/\n/mg;
		$FORM{'rejLst'} =~ s/(\s+|\n+|\r+)$//g;
	if ($FORM{'rejLst'}) {
	$FORM{'rejLst'} =~ s/(\n+|(\r\n)+)$//;
		open(TF,">$admin_pth$thuLstEx.non") || &showErr('Text File Write Access');
		 eval"flock(TF,2)"; print TF $FORM{'rejLst'}; eval"flock(TF,8)";
		close(TF);
	}
	else {unlink "$admin_pth$thuLstEx.non" if -e "$admin_pth$thuLstEx.non";}
		$errBox = "Reject List updated</b> for '$REFS{'frmRef'}' list<b>"; &show_admin;
}

elsif ($FORM{'doDB'} eq "1" && $FORM{'dbDelim'} =~ /^[0-2]$/ && $FORM{'dbExt'} =~ /^(t|c)$/) {
	my($ext,$dL,$Qt,$EdL,@Hd,$HD,@Out,$Lin,$Rcnt); my @Dl = (",","\t","|");
	$FORM{'dbExt'} eq "t" ? ($ext = ".txt") : ($ext = ".csv");
	$dL = $Dl[$FORM{'dbDelim'}];
	$Qt = '"' if $FORM{'dbQ'} eq "1";
	$EdL = $dL if $FORM{'dbEnd'} eq "1";
	if ($FORM{'dbHead'} eq "1") {
	$Hd[0] = $EdL.$Qt."Address".$Qt.$dL.$Qt."Name".$Qt.$dL.$Qt."Date".$Qt.$dL.$Qt."HTML".$Qt.$EdL;
	$Hd[1] = $EdL.$Qt."Address".$Qt.$dL.$Qt."Name".$Qt.$dL.$Qt."HTML".$Qt.$EdL;
	$Hd[2] = $EdL.$Qt."Name".$Qt.$dL.$Qt."Address".$Qt.$dL.$Qt."HTML".$Qt.$EdL;
	$Hd[3] = $EdL.$Qt."Address".$Qt.$dL.$Qt."HTML".$Qt.$EdL;
	$Hd[4] = $EdL.$Qt."Address".$Qt.$dL.$Qt."Date".$Qt.$dL.$Qt."HTML".$Qt.$EdL;
	$HD = $Hd[$REFS{'addr_only'}];	}
		push (@Out,"$HD\n") if $HD;
	if (open(FF,"<$listDir$thuLst")) {
	 eval"flock(FF,2)"; 
	 	while ($Lin = <FF>) {
	 		chomp ($Lin);
	 		$Lin =~ s/[$Qt]/'/sg if $Qt;
	 		$Lin =~ s/[$sep]/$Qt$dL$Qt/sg;
	 		push (@Out,"$EdL$Qt$Lin$Qt$EdL\n");
	 	} eval"flock(FF,8)"; close(FF);	}
	else {$errBox = "Could NOT READ List [$thuLst ]"; &show_admin;}
		$Rcnt = (@Out-1);
	if (open(FO,">$admin_pth$xport_pth"."db_$thuLstEx$ext")) {print FO @Out; close(FO); }
	else {$errBox = "Could NOT SAVE To File [ db_$thuLstEx$ext ]"; &show_admin;}
		$errBox = "[ db_$thuLstEx$ext ] File Created - $Rcnt Records"; $errBox .= " - Plus Header" if $HD; &show_admin;
}
else {$errBox = 'Form Options Empty or Not Recognised'; &show_admin;}
exit;
}
1;
