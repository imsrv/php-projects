use strict; my $prog_url = $main::prog_url; my $FFrom = $main::FFrom; my $FName = $main::FName; my $FRMdf = $main::FRMdf; my $FRMish = $main::FRMish; 
my $FRMrtn = $main::FRMrtn; my $FRMthnx = $main::FRMthnx; my $FRMundo = $main::FRMundo; my $FRMredo = $main::FRMredo; my $plural = $scribe::plural; my $redis = $main::redis; my ($not3,$Achk,$defd);
if (defined ($main::FORM{'fromChk'})) {$defd = $main::FORM{'fromChk'};}
if (defined ($main::FORM{'fromChk'})) {	$Achk = qq~
        <tr><td bgcolor="#FFFFFF" width="100%" valign="top" align="center"><font 
        face="verdana,arial,geneva,helvetica" size="1"><b>Repeat</b> Address<br> 
        </font><input type="text" name="fromChk" size="25" value="$defd"></td></tr>
~;}  
if ($main::REFS{'force'} == 1) {	$not3 = qq~
        <tr><td bgcolor="#FFFFFF" width="100%" valign="top" align="center"><font 
        face="verdana,arial,geneva,helvetica" size="1">Your <b>Full Name</b><br> 
        </font><input type="text" name="fstname" size="25" value="$FName"></td></tr>
~;}  

print qq~
<html><head>
 <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
 <title>E-Lists Data Entry ERROR</title>
 </head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
 <p>&nbsp;</p>
 <center>

  <form align="center" method="POST" action="$prog_url">
    <input type="hidden" name="df" value="$FRMdf">
    <input type="hidden" name="ishtml" value="$FRMish">
    <input type="hidden" name="return" value="$FRMrtn">
    <input type="hidden" name="thnx" value="$FRMthnx">
    <input type="hidden"name="this" value="$FRMredo">
    <input type="hidden"name="undo" value="$FRMundo">
    <input type="hidden" value="0" name="unsub">
     
    <font face="verdana,arial,geneva,helvetica" size="3"><b>$plural</b><font size="2"><br>
    Please correct the following</font></font> 
    <table border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td bgcolor="#990000" align="center"><table border="0" cellspacing="0" cellpadding="2"><tr bgcolor="#CC0000"> 
        <td><font face="verdana,arial,geneva,helvetica" color="#FFFFFF" size="2"><b>$redis</b></font></td>
        </tr><tr> 
        <td bgcolor="#FFFFFF" width="100%" valign="top" align="center"><font face="verdana,arial,geneva,helvetica" size="1">Your <b>E-mail Address</b><br>
        </font><input type="text" name="from" size="25" value="$FFrom"></td>
        </tr>
$Achk
$not3
        <tr> 
        <td bgcolor="#FFFFFF" width="100%" valign="top" align="center"><input type="submit" value="Resubmit Details" name="send"></td>
        </tr></table></td>
      </tr></table></form>

 </center>
</body>
</html>
~; 
1;