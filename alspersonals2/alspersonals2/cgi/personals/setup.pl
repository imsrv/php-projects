#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);
require "configdat.lib";
require "admin/subs.lib";
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


print "Content-type:text/html\n\n";
print <<EOF;
<html><head>

<link rel=stylesheet type=text/css href=$personalsurl/includes/adminstyles.css>

<title>ALsPersonals Version 2 Installation</title></head>
<body topmargin=0 bottommargin=0 rightmargin=0 leftmargin=0 marginheight=0 marginwidth=0>

<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td>
<td><font size=2 face=verdana color=ffffff>ALsPersonals Version 2 Installation</font></td></tr>
</table>
<br><br>
<blockquote><font size=2 face=verdana>
Before you run the setup, be sure you have transferred all the files and folders needed to run the program to your remote server.
If you have transferred all the program's files and folders to your remote server, you may
press the "Start Setup" button. <P>

If you are on a server that does not allow you to set .htaccess using an outside program, you should not press "Start Setup". Instead,
press "Skip htaccess", and setup your htaccess files according to your server specifications. <P>
If your password does not work after you have run the setup, check your admin HTML folder. If you do not see the files htaccess, htgroup and htpasswd, 
you will need to run the uninstaller, reinstall the program and press "Skip htaccess" instead of "Start Setup".<P>

As part of the setup process, the program will attempt to automatically set permissions on your files and folders. In the
event the automatic chmodding does not work, you will have to manually set your permissions. Manually chmodding instructions are included in your installation document.
</blockquote></font><br><br>

<form method="post" action="$admincgiurl/setaccess.pl">
<center><input type="submit" name="startsetup" value="Start Setup" class="button">
<input type="submit" name="skiphtaccess" value="Skip htaccess" class="button">
</center><br>
</form>
<table width=100% height=50 cellpadding=0 cellspacing=0 border=0 bgcolor=404040><tr><td>
<td width=10%>&nbsp;</td><td><center><font size=1 face=verdana color=ffffff>A Personals Touch<br>Copyright &copy 2000, 2001<br>Adela Lewis<br>
<a href=#top><font color=white>Back to Top</font></a><br></td></tr></table>
EOF






