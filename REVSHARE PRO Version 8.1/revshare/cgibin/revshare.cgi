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


$cookie="$ENV{'HTTP_COOKIE'}";
($trash,$agent) = split(/$agentcode=/,$cookie);

if ($agent =~ /;/){
($agent,$trash) = split(/;/,$agent);
}

print "Content-type: text/html\n\n";
print "<input type= \"hidden\" name=\"RevSharerID\" value=\"$agent\">";
print "<input type= \"hidden\" name=\"ref3\" value=\"$agent\">";
