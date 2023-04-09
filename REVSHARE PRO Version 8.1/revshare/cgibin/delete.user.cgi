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
print "Content-type: text/html\n\n";

&form_parse;

$delete=$FORM{'username'};

open (DATABASE, "$memberdatabase");
flock(DATABASE, 2);
@database=<DATABASE>;
flock(DATABASE, 8);
close DATABASE;

foreach $database (@database)  {
chomp $database;
($name,$company,$sitename,$url,$email,$address,$city,$state,$zip,$country,$ssnumber,$username,$password) = split(/\|/,$database);
push (@newdatabase,$database) unless ($delete eq $username);
                        }

open (DATABASE, ">$memberdatabase");
flock(DATABASE, 2);
foreach $newdatabase (@newdatabase)       {
print DATABASE "$newdatabase\n";              }
flock(DATABASE, 8);
close (DATABASE);


open (PASSWORDS, "$passwords");
flock(PASSWORDS, 2);
@passwordz=<PASSWORDS>;
flock(PASSWORDS, 8);
close PASSWORDS;

foreach $passwordz (@passwordz)  {
chomp $passwordz;
($username,$password) = split(/\:/,$passwordz);
push (@newpasswords,$passwordz) unless ($delete eq $username);
                        }

open (PASSWORDS, ">$passwords");
flock(PASSWORDS, 2);
foreach $newpasswords (@newpasswords)       {
print PASSWORDS "$newpasswords\n";              }
flock(PASSWORDS, 8);
close (PASSWORDS);

print "$delete ACCOUNT REMOVED FROM SYSTEM\n";
############################################################
#  FORM PARSING
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

