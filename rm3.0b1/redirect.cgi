#!/usr/bin/perl

###############################################################
#                                                             #
# Any use of this program is entirely at the risk of the      #
# user. No liability will be accepted by the author.          #
#                                                             #
# This code must not be distributed or sold, even in modified #
# form, without the written permission of the author.         #
#                                                             #
###############################################################

###############################################################
#                                                             #
# Nothing below needs to be modified. You can apply           #
# modifications if you know what you are doing. Remember that #
# all credits must remain intact.                             #
#                                                             #
###############################################################

# Locate and load required files
eval {
	# Get the script location (for UNIX and Windows)
	($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");

	# Get the script location (for Windows)
	($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");

	# Load files
	require "settings.cgi";
	require "common.sub";
};

# Check referring URL
&urlcheck;

# Read the form
&readform;

# Redirect or reload Top List
if (-e "$membpath/$FORM{'id'}.cgi") {

	# Initialize IP Log update flag
	$addip = 0;

	# Read IP Log
	open(IPS,"$membpath/ip.log") || err("Could not open $membpath/ip.log: $!");
	@iploginfo = <IPS>;
	close(IPS);

	# Get current time
	$curtime = time();

	# Update member file
	open(PROFILE,"+<$membpath/$FORM{'id'}.cgi") || err("Could not update $FORM{'id'}.cgi: $!");
	flock(PROFILE,2);
	@mprofile = <PROFILE>;
	chomp(@mprofile);
	# Check for duplicate outgoing hits
	unless (grep(/^$ENV{'REMOTE_ADDR'}\t$FORM{'id'}\tout/, @iploginfo) || $ENV{'HTTP_REFERER'} !~ /$scripturl/i) {
		$mprofile[14]++;
		$mprofile[15] = $curtime;
		$addip = 1;
	}
	seek(PROFILE,0,0);
	truncate(PROFILE,0);
	foreach $line(@mprofile) {
		print PROFILE "$line\n";
	}
	close(PROFILE);

	# Update IP Log
	if ($addip) {
		open(IPS,">>$membpath/ip.log") || err("Could not update $membpath/ip.log: $!");
		flock(IPS,2);
		seek(IPS,0,2);
		print IPS "$ENV{'REMOTE_ADDR'}\t$FORM{'id'}\tout\n";
		close(IPS);
	}

	# Display member website
	print "Location:$mprofile[4]\n\n";
} else {
	print "Location:$scripturl/index.cgi\n\n";
}

exit;