#!/usr/bin/perl
####################################################################################################
# DBAY				                                        	Version 1.0                            
# Copyright 1999  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 9/24/99                                      			Last Modified 9/25/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999  Telecore Media International, Inc. - All Rights Reserved.                    
# http://www.superscripts.com/                                                                                                           
# Selling the code for this program without prior written consent is         
# expressly forbidden.                                           
#                                                                           
# Obtain written permission before redistributing this software over the Internet or 
# in any other medium.  In all cases copyright and header must remain intact.
#
# My name is drew star... and i am funky...  http://www.drewstar.com/artist/
####################################################################################################
sub configure {
$localurl = "http://www.yourdomain.com/";
$datadirectory =  "/path/to/cgi-bin/dbay/data";
$cgiurl = "http://www.yourdomain.com/cgi-bin/dbay";

$mysqldatabase = "name of mysql database";
$mysqlusername = "mysql username";
$mysqlpassword = "mysql password";

$mailprogram='/path/to/sendmail';
$adminemail = "you\@yourdomain.com";

$nopic= "http://www.yourdomain.com/dbay/pix/nopic";
$icon ="http://www.yourdomain.com/dbay/pix/icon.gif";
$registrationurl = "http://www.yourdomain.com/dbay/index.html";

$increment = 2;
##################################################
# AUTHORIZE.NET CONFIGURATION VARIABLES (optional)
##################################################
$LOGIN="";
$PASSWORD="";
$DESCRIPTION = "";
$REJECTAVSMISMATCH = "FALSE";
$remote = "secure.authorize.net"; 
$script = "/gateway/transact.dll"; 
$port = "80"; 
$TYPE = "NA";
$AUTHCODE  = "";
$EMAILCUSTOMER = "TRUE";
$ECHODATA = "TRUE";
$TESTREQUEST = "FALSE";
$DELIMCHARACTER = "|";
$ENCAPSULATE = "FALSE";
##################################################
# NO EDITING REQUIRED
##################################################
$htmlheader = "$datadirectory/header.html";
$htmlfooter = "$datadirectory/footer.html";
$searchcategorycgi = "$cgiurl/searchcategory.cgi";
$feedbackcgi= "$cgiurl/feedback.cgi";
$bidcgi ="$cgiurl/bid.cgi";
$modifycgi ="$cgiurl/modify.cgi";
$getitemcgi ="$cgiurl/getitem.cgi";
$getcloseditemcgi ="$cgiurl/getcloseditem.cgi";
$searchcgi = "$cgiurl/search.cgi";
$getprofilecgi= "$cgiurl/feedback.cgi";

}
1;    #  Return true


