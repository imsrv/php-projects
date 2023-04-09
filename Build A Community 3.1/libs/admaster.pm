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

#$debug = "T";

### Suck in the database specific routines....
	require("$GPath{'adm_dbm.pm'}");


### Common Routines 
sub bmDisable_Account {
	my $ACCOUNT = $_[0];
	open ("DIS", ">$GPath{'admaster_data'}/accounts/$ACCOUNT.DISABLED");
	close (DIS);
}


sub bmPANIC {
	### We end up here if there is no banner to show
	### This will happen if after we've tried everything, even the default group has no eligible
	### accounts to show. 

	$image = "$CONFIG{'banner_dir'}/$CONFIG{'PANIC_IMAGE'}";
	$banner_type="IMAGE";
	$PANIC=1;

	if ($debug) { 
		print "\n\nPanic!\n\n";
		print $debug_text;
		print "Showing $CONFIG{'PANIC_IMAGE'}\n";
	}
}


sub bmCLICK_PANIC {
	### We end up here if there is a bad $ACCOUNT with adm_click.cgi
	### This will happen if the account is not sent via SSI, a Cookie is not there, or if there
	### is no file in $GPath{'admaster_data'}/rotation/ for the users IP Address.

	print "Location: $CONFIG{'PANIC_URL'}\n\n";

	exit 0;
}
