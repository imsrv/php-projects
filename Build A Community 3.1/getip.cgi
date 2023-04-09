#!/usr/bin/perl

##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################


	print "Content-type: text/html\n\n";
	print "<P>You current IP Address is: $ENV{'REMOTE_ADDR'}\n";
	print "<P>If you are logged in through a proxy server or and ISP that doesn't provide direct internet connectivity (AOL, WebTV and Compuser are examples) then your IP address may change between requests.\n";
	print "\n</body></html>\n";
	exit;
