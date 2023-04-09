use strict; print qq~
<html><head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>Error Response</title></head>
  <body bgcolor="#FFFFFF" text="#000000" link="#0000FF"><center><p>&nbsp;</p>
  <table border="0" cellpadding="2" cellspacing="0">
    <tr bgcolor="#FFFFFF">
      <th><font face="verdana, arial, geneva, helvetica">E-Lists <font color="#FF0000">Error Response</font></font></th>
    </tr><tr bgcolor="#FFFFFF"> 
      <td><fot size="2" face="arial,helvetica,geneva">
        <p align="center"><b><font face="Arial, Geneva, Helvetica" size="2">The 
          program has responded with an <font color="#FF0000">error</font></font></b></p>
        <dl> 
          <dt><font size="2" face="arial,helvetica,geneva">The result is:</font></dt>
          <dd><font size="2" face="arial,helvetica,geneva" color="#CC0000"><b>$main::serr</b></font></dd>
        </dl></td>
    </tr><tr bgcolor="#666666">
      <td align=center><font size="2" face="arial,helvetica,geneva" color="#FFFFFF">&nbsp;Use 
        your <b>Back Arrow</b> to return. <em>Thank you&nbsp;</em></font></td>
    </tr><tr bgcolor="#FFFFFF"> 
      <td align=center><font face="arial,helvetica,geneva" size="1" color="#808080">E-Lists v2.2 copyright</font></td>
    </tr>
  </table></center></body></html>
~;	#ALL program and copyright notices MUST remain as is and visible on output pages
1;
