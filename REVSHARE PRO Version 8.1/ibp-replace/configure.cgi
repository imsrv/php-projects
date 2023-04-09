#!/usr/bin/perl
####################################################################################################
# REVSHARE PRO REPLACEMENT FILE FOR IBILL PROCESSOR	                  Version 8.0                            
# Copyright 1998  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 6/12/98                                      			Last Modified 7/30/99                           
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

$date_command = "/usr/bin/date";
$localurl = "yourdomain.com";
$remoteurl = "netleader.com";
$remoteurl2 = "ibill.com";
$securedurl = "http://www.yourdomain.com/members/";
$userdatabase = "/path/to/cgi-bin/mastergate/database";
$accessfile = "/path/to/cgi-bin/mastergate/passwords";
$logfile  = "/path/to/cgi-bin/mastergate/log";
$deleteurl = "http://www.yourdomain.com/cgi-bin/mastergate/delete.cgi";
$modifyurl = "http://www.yourdomain.com/cgi-bin/mastergate/modify.cgi";
$payoutcgi = "http://www.yourdomain.com/cgi-bin/revshare/payout.cgi";

}

1;    #  Return true

