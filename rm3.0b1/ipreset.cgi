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

# If the script is not called from another script
if (!$fromscript) {

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

	# Exit if ran from a browser
	err("This script cannot be run from a browser.") if ($ENV{'HTTP_USER_AGENT'});
}

# Reset IP Log
open(IPLOG,">$membpath/ip.log") || err("Could not reset $membpath/ip.log: $!");
flock(IPLOG,2);
close(IPLOG);

# Get current time
$curtime = time();

# Save the time of last reset
open(TIMER,"+<$membpath/timer.log") || err("Could not update $membpath/timer.log: $!");
flock(TIMER,2);
@timerinfo = <TIMER>;
$timerinfo[0] = "\$iplog  = $curtime;\n";
seek(TIMER,0,0);
truncate(TIMER,0);
print TIMER @timerinfo;
close(TIMER);

1;
