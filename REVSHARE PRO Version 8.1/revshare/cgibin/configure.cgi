#!/usr/bin/perl
####################################################################################################
# REVSHARE PRO					 		                  Version 8.1                            
# Copyright 1998  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 6/12/98                                      			Last Modified 10/2/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999 Telecore Media International, INC - All Rights Reserved.                    
# http://www.superscripts.com                                                                                                            
# Selling the code for this program, modifying or redistributing this software over the Internet or 
# in any other medium is forbidden.  Copyright and header may not be modified
#
# my name is drew star... and i am funky... http://www.drewstar.com/
####################################################################################################

sub configure {

$localurl = "yourdomain.com";

$MasterAccountID = "axxxx";
$MasterAccountNumber = "axxxx";
$ErrorURL="http://www.yourdomain.com/revshare/error.html";
$SuccessURL="http://www.yourdomain.com/revshare/thankyou.html";

$mysqldatabase = "your mysql databasename";
$mysqlusername = "your mysql username";
$mysqlpassword = "your mysql password";

$mailprogram='/path/to/sendmail';
$adminemail = "you\@yourdomain.com";

$webmasterurl = "http://www.yourdomain.com/revshare/webmasters/";

$clickthroughurl[0] = "http://www.somewebsite.com/";
$clickthroughurl[1] = "http://www.anotherwebsite.com/";
$clickthroughurl[2] = "http://www.andanothersite.com/";

$cgidirectory = "/path/to/cgi-bin/revshare";
$cgiurl = "http://www.yourdomain.com/cgi-bin/revshare";

$datadirectory = "/path/to/cgi-bin/revshare/data";
#####################################################################################################
# DO NOT EDIT BELOW THIS LINE
#####################################################################################################
$agentcode = "revshare";
$remote = "secure.ibill.com";
$port = 80;
$script = "/cgi-win/ccard/rssignup.exe";
$RevSharerPayMethod="check";
$RequestType="SignupRevSharer";

$eurl = "$cgiurl/agents.cgi";
$loginurl = "$cgiurl/stats.cgi";
$memberdatabase = "$datadirectory/memberdatabase";
$schedule = "$datadirectory/schedule.db";
$passwords = "$datadirectory/passwords";
}
1;    #  Return true







