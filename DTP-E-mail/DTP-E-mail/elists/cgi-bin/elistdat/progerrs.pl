use strict; my $b2 = $main::serr; my $bit2;
	if ($main::FRMthnx =~ /^pop$/ && $main::FORM{'unsub'} ne "1") {$bit2 = "Please <b>CLOSE THIS WINDOW</b> to return.";}
	elsif ($main::FRMthnx =~ /^RMT$/) {$bit2 = "<small>Contact the webmaster if problems persist.</small>";}
	else {$bit2 = "Use your <font color=\"#0000CC\"><b>Back Arrow</b></font> to return.";}
print qq~
<html><head>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>Error Response</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF">
<center><p>&nbsp;</p>

  <table cellspacing="0" cellpadding="1"><tr align="center" bgcolor="#000099">
      <td><table border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" width="100%">
          <tr bgcolor="#000099">
            <th><font face="verdana, arial, geneva, helvetica" color="#FFFFFF">E-Lists Error response</font></th>
          </tr><tr bgcolor="#FFFFFF">
            <td><p align="center"><font size="2" face="arial,helvetica,geneva"><b>The program has responded with an error</b></font></p>
              <dl> 
              <dt><font size="2" face="arial,helvetica,geneva">The result is:</font></dt>
              <dd><font size="2" face="arial,helvetica,geneva" color="#CC0000"><b>$b2</b></font></dd>
              </dl></td>
          </tr><tr bgcolor="#EEEEEE">
            <td align=center><font size="2" face="arial,helvetica,geneva">&nbsp;$bit2 <em>Thank you&nbsp;</em></font></td>
          </tr>
        </table></td>
    </tr>
    <tr align="center"> 
      <td bgcolor="#FFFFFF"><font face="arial,helvetica,geneva" size="1" color="#808080">E-Lists v2.2 copyright</font></td>
    </tr></table>

</center>
</body></html>
~;	#ALL program and copyright notices MUST remain as is and visible on output pages
1;
