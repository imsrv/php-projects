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

# $debug=1;

	require("./common.pm"); 
	require $GPath{'admaster.pm'}; 

	## Set our flag ##
	$BMS=1;

	&parse_FORM;

	$group = $input{'group'};
	if (!$group) {
		$group="default";
	}

	$account = $input{'account'};
	$show = $input{'show'};
  
	if(! &lock("admaster")) {
		&bmPANIC;
	}
	# Find the group / account file...
	if ($account ne "") {
		&Use_Account;
	}
	else {
		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &Use_Group($group);
	}

	&unlock("admaster");

	# Show the banner
	&Show_Banner;

	if ($debug) { 
		print "Content-Type: text/html\n\n";
		print "<PRE>\n\nDebug Mode...\n\n$debug_text</PRE>"; 
	}

	exit 0;


sub Show_Banner {
	if ($LOCAL eq "T") {
		print "Content-type: image/gif\n\n";
		open("GIF","$real_image");
		binmode(STDOUT);
		while (read(GIF,$buffer,4096)) {
			print $buffer;
		}
		close(GIF);
	}

	else  {
		print "Location: $image\n\n";
	}
}


