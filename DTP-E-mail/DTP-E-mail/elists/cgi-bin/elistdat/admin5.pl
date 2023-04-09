# E-Lists 2.2 DO NOT EDIT
sub show {
use strict; 
	my $fle = shift; my $errBox = shift; my $cWrd = $main::cwrd;
	my ($fIn,$fRm,$fRm1,$fRm2,$FF);
	if (open EF, "<$main::admin_pth$fle") {
		while ($fIn = <EF>) {
			chomp ($fIn); 
			$fIn =~ s/(^\s+|\s+$|\r+|\n+)//sg; 
			$fIn =~ s/&/&amp;/sg;
			$FF .= $fIn."\n"; 
	} close (EF);  }  
	$FF =~ s/(\n+|(\r\n)+)$//g;
	if ($fle eq "redisplay.pl") {
		$FF =~ /.+qq~(.*?)~;.+qq~(.*?)~;.+qq~(.*?)~;/s; 
		$fRm1 = $1 if $1; $fRm2 = $2 if $2; $fRm = $3 if $3; chomp($fRm1,$fRm2,$fRm);
	}
	else {$FF =~ /.+qq~(.*?)~;.+/s; $fRm = $1 if $1; chomp($fRm);	}
	$errBox = qq~    <tr bgcolor="#CC0000" align="center"><th colspan="3" width="100%"><font size="1" face="Verdana, Arial, Geneva, Helvetica" color="#FFFFFF">$errBox</font></th></tr>~ if $errBox;

print "Content-type: text/html\n\n"; 
print qq~<html><head>
<title>E-Lists Sample</title>
<script language="JavaScript">
<!-- 
 function selectCode(thisIs){	
	document.editFrm[thisIs].focus(); 
	document.editFrm[thisIs].select();
 }
//-->
</script>
</head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
 <center><p><font size="3" face="Verdana, Arial, Geneva, Helvetica"><b>E-Lists HTML PAGE Editing</b><br>[ <font color="#CC0000"><b>Edit <b>File : $fle</b></font> ]</font>
  <!--<font size="2">&#149; <font color="#0000CC"><b>Close This Window to return</b></font> &#149;</font></p>-->
<form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form></center>
<form name="editFrm" method="POST" action=""><center>
  <input type="hidden" name="edF" value="1">
  <input type="hidden" name="cwrd" value="$cWrd">
  <input type="hidden" name="fleIs" value="$fle">
  <table border="0" width="595" cellspacing="0" cellpadding="1">
      <tr bgcolor="#660000"> 
        <th width="100%" align="center"><font size="2" face="verdana,arial,geneva,helvetica" color="#FFFFFF">[ File : $fle ] Copy/Edit/Save</font></th>
      </tr>$errBox<tr bgcolor="#F5F5F5"> 
       <td width="100%"> <table width="100%" border="0" cellspacing="0" cellpadding="8"><tr> 
       <td><font face="verdana, arial, geneva, helvetica" size="1"><b><font color="#CC0000">NOTE:</font> These pages contain imbedded program variables!<br><br>This window allows you to 
         copy/edit/paste the generated response pages of E-Lists</b>.<br>
         IF you want to customise the look of these pages to more closely match your site, then copy the code and paste in to a text or 
         WYSIWYG editing window. Make the changes BEING CAREFUL TO KEEP any imbedded variables, then paste back here and save.</font></td></tr></table></td>
      </tr><tr bgcolor="#F5F5F5"> 
        <td width="100%" align="center"><b><font size="1" face="Verdana, Arial, Geneva, Helvetica">Admin word </font> 
          <input type="password" name="admpsword" size="10" maxlength="15"> <input type="submit" name="Submit" value="  Save to File  "></b></td>
      </tr>~;
if ($fRm2 || $fRm1) {print qq~      <tr bgcolor="#F5E5E5" align="center"> 
        <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="8"><tr> 
        <td><font face="verdana, arial, geneva, helvetica" size="1">When an input error is detected in a submission AND the list type is 
          0, 1, or 2, a &quot;Name&quot; entry box also appears with the address entry box displayed on the unique redisplayed error form.<br>
          When the &quot;Repeat Address&quot; entry box is used with list types 0, 1, 2, 3, or 4, a &quot;Repeat Address&quot; entry box also appears in the redisplayed error form.<br>
          &#149; <b>The first box below</b> contains the html table row/cell code for the &quot;Repeat Address&quot; entry box. <br>
          &#149; <b>The second box below</b> contains the html table row/cell code for the &quot;Name&quot; entry box. <br>
          &#149; <b>The code in the third box below</b> must contain imbedded variables ( <b>\$Achk</b> and <b>\$not3</b> ) WHERE the table row/cell for 
          the &quot;Repeat Address&quot; entry box will appear AND the &quot;Name&quot; entry box will appear. IF changing the appearance of this page then also edit these table rows/cells to suit.</font></td></tr></table></td>
      </tr><tr bgcolor="#E5E5E5"> 
        <td width="100%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b><a href="javascript:selectCode('samp1');">Click</a> 
          to Select All</b><i> - or [Control+A] in active box</i><br>...then right mouse button click [select 'Copy'], <i>OR</i> [Control+C], 
          to copy to clip board.</font><br><textarea name="samp1" cols="66" rows="3" wrap="OFF">$fRm1</textarea></b></td>
      </tr><tr bgcolor="#E5E5E5"> 
        <td width="100%" align="center"><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b><a href="javascript:selectCode('samp2');">Click</a> 
          to Select All</b><i> - or [Control+A] in active box</i><br>...then right mouse button click [select 'Copy'], <i>OR</i> [Control+C], 
          to copy to clip board.</font><br><textarea name="samp2" cols="66" rows="3" wrap="OFF">$fRm2</textarea></b></td>
      </tr>~;}
print qq~      <tr bgcolor="#E5E5E5"> 
        <td width="100%" align="center"> <b> </b><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b> 
          </b></font><font face="Verdana, Arial, Geneva, Helvetica" size="1"><b> <a href="javascript:selectCode('samp');">Click</a> to Select All</b><i> 
          - or [Control+A] in active box</i><br>Then right mouse button click [select 'Copy'], <i>OR</i> [Control+C], to copy to clip board.</font><br>
          <textarea name="samp" cols="66" rows="30" wrap="OFF">$fRm</textarea></td>
      </tr><tr> 
        <td width="100%" align="center"><font face="Arial, Geneva, Helvetica" size="1">E-Lists 2.2 copyright</font></td>
      </tr></table><!--<font face="verdana,Arial,Geneva,Helvetica" size="2">&#149; <font color="#0000CC"><b>Close This Window to return</b></font> &#149;</font>-->
<form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form>
</center></form></body></html>
~; 
exit;
}
sub saveF {
use strict;
	my $fle = shift;
	my $fRm = $main::FORM{'samp'};
	my $fRm1 = $main::FORM{'samp1'} if $main::FORM{'samp1'};
	my $fRm2 = $main::FORM{'samp2'} if $main::FORM{'samp2'};
	my ($errBox,$fIn,$FF);
	if (open EF, "<$main::admin_pth$fle") {while ($fIn = <EF>) {$FF .= $fIn;} close (EF);}  
	if ($FF && $main::FORM{'edF'} eq "1") {
		if ($fRm) {
			$fRm =~ s/^(\Mc+|\n+|\r+)//g;
			$fRm =~ s/(\Mc+|\s+|\n+|\r+)$//g;
			$fRm .= "\n" if $fRm;	}
		if ($fRm1) {
			$fRm1 =~ s/^(\Mc+|\n+|\r+)//g;
			$fRm1 =~ s/(\Mc+|\s+|\n+|\r+)$//g;
			$fRm1 .= "\n" if $fRm1;	}
		if ($fRm2) {
			$fRm2 =~ s/^(\Mc+|\n+|\r+)//g;
			$fRm2 =~ s/(\Mc+|\s+|\n+|\r+)$//g;
			$fRm2 .= "\n" if $fRm2;	}
		if ($fle eq "redisplay.pl") {
			if (!$fRm || !$fRm1 || !$fRm2) {$errBox = "One or all HTML Code boxes empty!"; &show($fle,$errBox);}
			$FF =~ m|(.+qq~).*?(~;.+qq~).*?(~;.+qq~).*?(~;.+)|s; 
			$FF = "$1\n$fRm1$2\n$fRm2$3\n$fRm$4";	}
		else {
			if (!$fRm) {$errBox = "HTML Code box empty!"; &show($fle,$errBox);}
			$FF =~ m|(.+qq~).*?(~;.+)|s; 
			$FF = "$1\n$fRm$2";	}
	}
	else {$errBox = "Option Not Recognised, or File Not Found!"; &show($fle,$errBox);}

	if (open(TF,">$main::admin_pth$fle")) {eval"flock(TF,2)"; print TF $FF; eval"flock(TF,8)"; close(TF);
		$errBox = "[ $fle ] File updated"; &show($fle,$errBox);}
	else {$errBox = "Could not find/write to '$fle'!"; &show($fle,$errBox);}
exit(0);
}
1;
