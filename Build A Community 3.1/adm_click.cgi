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

	require "./common.pm";
	require $GPath{'admaster.pm'};

	&parse_FORM;

	$debug = 0;
	if ($debug) {
		print "Content-Type: text/plain\n\n";
	}

	### Get account name .... ###

	if(! &lock("bannermaster")) {
		&bmCLICK_PANIC;
	}
 
	($expiration_type, $num_clicks, $redirect_url) = &bmClick_Account($FORM{'account'});

	if ($expiration_type eq "clicks" && $NewClicks >= $num_clicks) {
		&bmDisable_Account($FORM{'account'});
	}

	&unlock("bannermaster");

	print "Location: $redirect_url\n\n";

	exit 0;
