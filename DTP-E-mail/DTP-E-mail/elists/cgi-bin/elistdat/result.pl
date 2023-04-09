use strict; my $datetime = $main::datetime; my $FName = $main::FName; my $FFrom = $main::FFrom;
 my $bbit = $scribe::bbit; my $htmChng = $main::htmChng; my $isErr = $main::isErr; my $tahh; my $bit2 = $scribe::bit2; 
 my $cnf = "e-mail"; $cnf = "request" if $main::REFS{'opit'} == 1;
if ($main::NOsve == 1) { 
$tahh = "
  <p align=\"center\">Your interest in joining this list is very much appreciated.</p>
"; } elsif ($main::noAlw == 1) { 
$tahh = "
  <p>We appreciate your desire to subscribe to this list, but addresses from your service provider are not permitted at this time.</p>
"; } elsif ($main::exsts == 1 && $main::chngd != 1) { 
$tahh = "
  <p>We appreciate your continued support of this list, but to help avoid annoying you with duplicate e-mail we cannot allow repeat subscriptions to the same list.</p>
"; } elsif ($main::exsts == 2 && $main::chngd != 1) { 
$tahh = "
  <p>We appreciate your continued support of this list, but the address has already been submitted and is waiting for your confirmation. <b>An email was sent</b> containing a simple confirmation request URL.</p>
"; } elsif ($main::chVal && $main::chngd == 1) { 
$tahh = "
  <p>We appreciate your continued support of this list. <p>Should you later decide to again change the e-mail format between Plain Text and HTML, just return and resubmit your subscription using the EXACT 
  same address but with the alternate format selected.</p>
"; } elsif (!$main::chVal && $main::chngd != 1) {  
$tahh = "
  <p>Your interest in joining this list is very much appreciated, and a confirmation $cnf is on the way; please keep the auto-response e-mail as a record.</p>
"; } 

print qq~
 <html><head>
 <title>E-Lists Subscription results</title>
 </head>
 <body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#0000FF">

 <center><p>&nbsp;</p>
  <table border="0" cellspacing="0" cellpadding="1" width="380">
    <tr bgcolor="#000099" align="center"> 
      <td width="100%"><table width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#FFFFFF">
          <tr bgcolor="#000099">
            <th width="100%"><font face="verdana, arial, geneva, helvetica" color="#FFFFFF" font="font" size="3">Subscription Details</font></th>
          </tr><tr bgcolor="#FFFFFF">
            <td width="100%"><font face="arial, geneva, helvetica" size="2"> 
            <center><font size="1">$datetime</font><b><br>
            Here is the result of your subscription request<br>
            </b>$FName <b>:</b><font color="#000099"> $FFrom</font> 
            </center>
              $bbit $htmChng $isErr $tahh</font></td>
          </tr><tr align="center" bgcolor="#FFFFFF">
            <td width="100%"><font face="arial, geneva, helvetica" size="2"><font face="arial, geneva, helvetica" size="2"><font size="1" color="#CC0000">private 
              details submitted used ONLY for our mailing lists</font></font></font></td>
          </tr><tr align="center" bgcolor="#EEEEEE">
            <td width="100%"><font size="2" face="arial, geneva, helvetica">$bit2</font><font size="2"> <em>Thank you.</em></font></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF" align="center">
      <td width="100%"><font color="#808080" face="arial, geneva, helvetica" size="1">E-Lists v2.2 copyright</font></td>
    </tr>
  </table>
 </center>

 </body>
 </html>
~; # you must retain the program name / copyright visible and readable as is
1; # last TWO lines must remain
