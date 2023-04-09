#!/usr/bin/perl

require "../configdat.lib";
################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################
# Do not make changes here		                                              
################################################################################

$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
    $msg = "@_"; 
  print "\nContent-type: text/html\n\n";
  print "The following error occurred : $msg\n";
  exit;
}
################################################################################
# Get the input
################################################################################

read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
   @pairs = split(/&/, $input);
   foreach $pair (@pairs) {
   ($name, $value) = split(/=/, $pair);
   $name =~ tr/+/ /;  
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ s/<([^>]|\n)*>//g;
   $FORM{$name} = $value;  
   }
###############################################################################

print "Content-type: text/html\n\n";
print "
<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>A Personals Touch Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>Administration Login Screen
</font></td></tr>
</table>
<br><br>\n";
print "<form method=post action=\"$admincgiurl/adminindex.pl\">\n";
print "<blockquote><font size=2 face=verdana>
<br><br></font></blockquote>\n";
print "<p><center><table><tr><td>
<font size=2 color=000000 face=verdana>
Admin Login Name:</font></td><td>
<INPUT TYPE=\"text\" NAME=\"adminname\" SIZE=15 MAXLENGTH=25></td></tr><tr>\n";
print "<td><font size=2 color=000000 face=verdana>
Admin Password:</font></td><td>
<INPUT TYPE=\"password\" NAME=\"adminpassword\" SIZE=15 MAXLENGTH=25></td></tr></table>\n";
print "<p><center>
<input type=\"submit\" name=\"adminlogin\" value=\"Login\" class=\"button\">

</center>\n";
print "</form>\n";
print "<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top><font color=ffffff>Back to Top</font></a><br></td></tr></table>\n";
print "</body></html>\n";
exit;


