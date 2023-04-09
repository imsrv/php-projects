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
$lusername = $FORM{'username'};
$lpassword = $FORM{'password'};

open (DATABASE, "$memberdatabase");
flock(DATABASE, 2);
@database=<DATABASE>;
flock(DATABASE, 8);
close DATABASE;


foreach $database (@database)  {
	chomp $database;
	($name,$company,$sitename,$url,$email,$address,$city,$state,$zip,$country,$ssnumber,$username,$password) = split(/\|/,$database);
		if ($lusername eq $username){
			if ($lpassword eq $password){
				print "Content-type: text/html\n\n";
				&login;
				exit;
				}
                  }
}
print "Content-type: text/html\n\n";
print "INVALID LOGIN!";
exit;
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
#  SUBROUTINES
############################################################
sub login {
print <<ENDFOOTER

<html>

<head><title>WELCOME $lusername!</title>

</head>

<body bgcolor=\"white\">

<p align="center"><font face="Arial" color="#000000">WELCOME $lusername!</font></p>

<form action="$cgiurl/stats.cgi" method="post">
  <input type="hidden" name="username"
  value="$lusername"><input type="hidden" name="password" value="$lpassword">
<div align="center"><center><p><input type="submit" value="Get Statistics"
  name="submit"> </p>
  </center></div>
</form>

<form action="$cgiurl/banners.cgi" method="post">
  <input type="hidden" name="username" value="$lusername"><input type="hidden" name="password"
  value="$lpassword"><div align="center"><center><p><input
  type="submit" value="Get Banners" name="submit"></p>
  </center></div>
</form>





ENDFOOTER
}
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
