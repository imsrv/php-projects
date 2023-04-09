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
print "Content-Type: text/html\n\n";
&form_parse;
$username = $FORM{'username'};

print "<BODY BGCOLOR=#ffffff text=\"#000000\" link=\"#000000\" vlink=\"#000000\">";

print "</font></td></tr>";
print "<p align=\"left\"><font color=\"#000000\" face=\"Arial\">";
print "INFORMATION FOR $username<br><br>";	


&memberinfo;

exit;
################################################################################
# SEARCH MEMBER DATABASE
################################################################################
sub memberinfo {
open (MEMBERS, "$memberdatabase");
flock(MEMBERS, 2);
@members=<MEMBERS>;
flock(MEMBERS, 8);
close MEMBERS;

foreach $members (@members)  {
chomp $members;
($name,$company,$sitename,$url,$email,$address,$city,$state,$zip,$country,$ssnumber,$uzername,$password) = split(/\|/,$members);
if ($username eq $uzername){

print "<blockquote><p align=\"left\"><font color=\"#000000\" face=\"Arial\"><small>";
print "USERNAME:  <a href=mailto:$email>$uzername</a>";
print "<br>PASSWORD:  $password";
print "<br><a href=\"$url\">$sitename</a>";
print "<br><a href=\"mailto:$email\">$name</a>";
print "<br>$company";
print "<br>$address";
print "<br>$city,$state  $zip  $country";
print "<br><br>$ssnumber";
print "</small></font></p></blockquote>";
last;
}

}}

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
