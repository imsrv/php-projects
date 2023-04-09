#!/usr/bin/perl
####################################################################################################
# REVSHARE PRO					 		                  Version 8.1                            
# Copyright 1998  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 6/12/98                                      			Last Modified 9/14/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999 Telecore Media International, INC - All Rights Reserved.                    
# http://www.superscripts.com                                                                                                            
# Selling the code for this program, modifying or redistributing this software over the Internet or 
# in any other medium is forbidden.  Copyright and header may not be modified
#
# my name is drew star... and i am funky... http://www.drewstar.com/
####################################################################################################
require "configure.cgi";
&configure;
&refergate;
####################################################################################################
&form_parse;
print "Content-Type: text/html\n\n";
$username=$FORM{'username'};

&printheader;
######################################################################
# PRINT HEADER
######################################################################
sub printheader {

print <<ENDHEADER;


<html>

<head>
<title>BANNER CODE</title>
</head>

<body bgcolor="white">
<font SIZE="2"><font SIZE="2"><font SIZE="2">

<p><strong><font color="#000000" SIZE="2" face="Arial">DOWNLOAD ONE OF THESE BANNERS</font></strong></p>
<br>

<img src="banner.gif"><br>

</font></font>

<p></font><strong><font SIZE="2" color="#000000" face="Arial">AND CUT OUT THE FOLLOWING
LINK CODE BELOW</font></strong><font SIZE="2"></p>

<blockquote>
  <p></font><font face="Arial" SIZE="2" color="#FF0000">&lt;a
  href=&quot;$eurl?refer=$username&amp;website=0&quot;&gt;&lt;img src=&quot;banner.gif&quot;&gt;&lt;/a&gt;</font><font
  SIZE="2"></p>
  <p><font color="#000000" face="Arial" SIZE="2">&nbsp;</font></p>
</blockquote>

<p></font><font color="#000000" SIZE="2" face="Arial">DONT FORGET TO UPLOAD YOUR BANNER
AND CHANGE THE IMG SRC URL!</font><font SIZE="2"></p>
</font>
</body>
</html>





ENDHEADER
}





############################################################
#  SUBROUTINES
############################################################
sub form_parse  {
	read (STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs)
	{
    	($name, $value) = split(/=/, $pair);
    	$value =~ tr/+/ /;
    	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    	$FORM{$name} = $value;
	}}
############################################################
#  VALIDATE POST IS AUTHENTIC
############################################################
sub refergate {            
         if ($ENV{'HTTP_REFERER'} =~ /$localurl/i) {
			$flag = "OK";
          }
        if ($flag ne "OK"){
          print "Content-Type: text/html\n\n";
          print "PERMISSION DENIED:  $ENV{'HTTP_REFERER'}";
          exit;
          }                 
}  
