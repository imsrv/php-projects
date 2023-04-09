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
	

# Initialize update array
@memblist = ();

# Get member directory info
opendir(DIR,"$membpath") || err("Could not open directory $membpath for reading: $!");
@allfiles  = readdir(DIR);
close(DIR);

# Extract member files
@membfiles = grep(/\d+\.cgi/, @allfiles);

# Initialize new member array index
$membindex = 0;

# Get current time
$curtime = time();

# Loop through member files
foreach $membfile(@membfiles) {

	# Open member file
	open(FILE,"$membpath/$membfile") || err("Could not open $membpath/$membfile: $!");
	@mprofile = <FILE>;
	close(FILE);
	chomp(@mprofile);

	# Check if member is active
	unless ($idletime && !$idleshow && ($curtime - $mprofile[13]) >= $idletime) {

		# Calculate member rating
		if ($mprofile[9]) {
			$membrating = $mprofile[11] / $mprofile[9];
		} else {
			$membrating = 0;
		}

		# Add member to update array: Member ID | Country | Title | Desc | In | Out | Votes | Rating | Score
		push(@memblist, "$mprofile[0]\t$mprofile[7]\t$mprofile[5]\t$mprofile[6]\t$mprofile[12]\t$mprofile[14]\t$mprofile[9]\t$membrating\t$mprofile[11]");

		# Increment array index
		$membindex++;
	}
}

# Sort the array
if ($topsort eq 'in') {
	@memblist = sort byin @memblist;
} elsif ($topsort eq 'out') {
	@memblist = sort byout @memblist;
} elsif ($topsort eq 'hits') {
	@memblist = sort byhits @memblist;
} elsif ($topsort eq 'votes') {
	@memblist = sort byvotes @memblist;
} elsif ($topsort eq 'rating') {
	@memblist = sort byrating @memblist;
} elsif ($topsort eq 'score') {
	@memblist = sort byscore @memblist;
}

# Save update
open(UPDATE,"+<$membpath/lastupdate.log") || err("Could not update $membpath/lastupdate.log: $!");
flock(UPDATE,2);
@prevupdate = <UPDATE>;
chomp(@prevupdate);
seek(UPDATE,0,0);
truncate(UPDATE,0);
for ($j = 1; $j <= scalar(@memblist); $j++) {
	@memblistrec = split(/\t/, $memblist[$j - 1]);
	@prevmembrec = grep(/^$memblistrec[0]\t/, @prevupdate);
	@prevmembinfo = split(/\t/, $prevmembrec[0]);
	print UPDATE "$memblistrec[0]\t$j\t$prevmembinfo[1]\t$memblistrec[1]\t$memblistrec[2]\t$memblistrec[3]\t$memblistrec[4]\t$memblistrec[5]\t$memblistrec[6]\t$memblistrec[7]\t$memblistrec[8]\n";
}
close(UPDATE);

# Save the time of last update
open(TIMER,"+<$membpath/timer.log") || err("Could not update $membpath/timer.log: $!");
flock(TIMER,2);
@timerinfo = <TIMER>;
$timerinfo[1] = "\$update = $curtime;\n";
seek(TIMER,0,0);
truncate(TIMER,0);
print TIMER @timerinfo;
close(TIMER);

# Return the time to calling script
$update = $curtime;

1;


########################### SUBROUTINES ###########################


# Sort by incoming hits
sub byin {
	@a = split(/\t/,$a);
	@b = split(/\t/,$b);
	$b[4] <=> $a[4] || $a[2] cmp $b[2];
}


# Sort by outgoing hits
sub byout {
	@a = split(/\t/,$a);
	@b = split(/\t/,$b);
	$b[5] <=> $a[5] || $a[2] cmp $b[2];
}


# Sort by total hits
sub byhits {
	@a = split(/\t/,$a);
	@b = split(/\t/,$b);
	($b[4] + $b[5]) <=> ($a[4] + $a[5]) || $a[2] cmp $b[2];
}


# Sort by the number of votes
sub byvotes {
	@a = split(/\t/,$a);
	@b = split(/\t/,$b);
	$b[6] <=> $a[6] || $a[2] cmp $b[2];
}


# Sort by average rating 
sub byrating {
	@a = split(/\t/,$a);
	@b = split(/\t/,$b);
	$b[7] <=> $a[7] || $a[2] cmp $b[2];
}


# Sort by the score
sub byscore {
	@a = split(/\t/,$a);
	@b = split(/\t/,$b);
	$b[8] <=> $a[8] || $a[2] cmp $b[2];
}
