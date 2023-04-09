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

# Get member directory info
opendir(DIR,"$membpath") || err("Could not open directory $membpath for reading: $!");
@allfiles  = readdir(DIR);
close(DIR);

# Extract member files
@membfiles = grep(/\d+\.cgi/, @allfiles);

# Loop through member files
foreach $membfile(@membfiles) {

	# Reset member file
	open(FILE,"+<$membpath/$membfile") || err("Could not update $membpath/$membfile: $!");
	flock(FILE,2);
	@mprofile = <FILE>;
	$mprofile[9]  = "0\n";
	$mprofile[11] = "0\n";
	$mprofile[12] = "0\n";
	$mprofile[14] = "0\n";
	seek(FILE,0,0);
	truncate(FILE,0);
	print FILE @mprofile;
	close(FILE);
}

# Get current time
$curtime = time();

# Save the time of last reset
open(TIMER,"+<$membpath/timer.log") || err("Could not update $membpath/timer.log: $!");
flock(TIMER,2);
@timerinfo = <TIMER>;
$timerinfo[2] = "\$reset  = $curtime;\n";
seek(TIMER,0,0);
truncate(TIMER,0);
print TIMER @timerinfo;
close(TIMER);

# Return the time to calling script
$reset = $curtime;

1;
