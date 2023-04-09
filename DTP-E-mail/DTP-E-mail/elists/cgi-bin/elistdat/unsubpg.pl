package shw;
sub shw {
use strict; my $frmref = $main::REFS{'frmRef'}; my ($who,$b2,$did,$will); my $exsts = shift;
	$who = $main::FFrom; $b2 = $main::bit2;
	my $rsLt = "Thank you for your participation. ";

	if ($exsts == 3) {$rsLt = "Sorry, but your address was not found in this list. Please<br>check that the spelling of your address is correct and<br>try again; <i>or contact the webmaster of this site.</i>";
			$did = "Address NOT found";  $will = "Submission Error";}
	elsif ($main::REFS{'opit'} != 1) {
		$rsLt .= "We are sorry to see<br>you go and hope you return often to find out what's new;<br>you will be welcome to subscribe again at another time."; 
		if ($main::REFS{'addr_only'} == 5) {$did = "Address will be Removed"; $will = "Request to Un-Subscribe received";}
		else {$did = "Address Removed"; $will = "You are no longer subscribed";}  }
	else {
		if ($exsts == 1) {$rsLt .= "However, this address is<br>waiting for Subscribe Confirmation, and therefore cannot be<br>Un-Subscribed; <i>notification was sent to this address!</i>";
			$did = "Address cannot be removed!";  $will = "Request Received";}
		elsif ($exsts == 2) {$rsLt .= "However, this address is<br>already listed for UN-Subscribing, and an e-mail letter was<br>sent containing a simple confirmation request URL!";
			$did = "Address will be removed once confirmed";  $will = "Request Received";}
		else {$rsLt .= "However, to ensure the<br>removal was submitted correctly, an e-mail letter has been sent<br>containing a simple confirmation request URL.";
			$did = "Address will be removed once confirmed";  $will = "Request Received";}	}
print qq~
<html><head>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>E-Lists Edit Complete</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF">

<center><p>&nbsp;</p>
  <table border="0" cellspacing="0" cellpadding="1">
    <tr align="center" bgcolor="#000099">
      <td><table width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#FFFFFF">
          <tr bgcolor="#000099">
            <th><font face="verdana, arial, geneva, helvetica" color="#FFFFFF">UN-Subscribing Result</font></th>
          </tr><tr bgcolor="#FFFFFF"> 
            <td><p align="center"><font size="2" face="arial,geneva,helvetica"><b>$will</b><br>
              <font color="#000099"> [ </font>$who <font color="#000099"> ]<br>
              <b>$did</b></font><br><i>from</i> &quot;$frmref&quot; <i>list</i></font></p>
              <p><font face="arial, geneva, helvetica" size="2">$rsLt<br>&nbsp;</font></p></td>
          </tr><tr>
            <td align=center bgcolor="#E5E5E5"><font size="2" face="arial,helvetica,geneva"><font color="#0000CC">$b2</font> <em>Thank you.</em></font></td>
          </tr>
        </table></td></tr>
    <tr align="center" bgcolor="#FFFFFF">
      <td><font face="arial,geneva,helvetica" size="-2" color="#808080">E-Lists v2.2 copyright</font></td>
    </tr>
  </table>
</center>

</body>
</html>
~;	#ALL program and copyright notices MUST remain as is and visible on output pages
}
1;