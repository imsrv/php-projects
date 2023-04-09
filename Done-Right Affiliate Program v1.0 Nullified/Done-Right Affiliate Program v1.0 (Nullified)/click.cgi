# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/affiliate/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####

# Affiliate Program by Done-Right Scripts
# Admin Script
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2000 Done-Right. All rights reserved.
###############################################

use Fcntl qw(:DEFAULT :flock);
use DB_File;

##control section##
if ($member ne '' and $keyword ne '') {	&add_click; }
else { die "Error: missing member and keyword values"; }

sub add_click {
	##remove harmful member values
	##someone could pass joe;mail ed@bla.com < /etc/passwd for the members param
	$member =~ s/;//g;
	$temp = $path;
	$temp =~ s/affiliate\///;
	require "${temp}affiliate/config/config.cgi";
	$pay = $config{'pay'};

	$LCK = "lockfile";
	sysopen(DBLOCK, $LCK, O_RDONLY | O_CREAT) or die "can't open $LCK: $!";
	##wait until we get the file lock
	flock(DBLOCK, LOCK_SH) or die ("can't LOCK_SH $LCK");
	
	##we need a database file for tracking unique users since DBM only supports flat hashes
	$DBNAME = "${temp}affiliate/stats/$member.db";
	tie(%hash, "DB_File", $DBNAME, O_RDWR|O_CREAT) or die ("Cannot open database $DBNAME: $!");

	$current_date = time();
	
	# Delete entries over 24 hours
	foreach $key (keys %hash) {
		unless ($key =~ /STAT/ or $key =~ /^lastrun$/ or $key =~ /MON/ or $key =~ /PAID/) {
			if ($pay == 1) { $gettime = $current_date - $hash{$key}; }
			else {
				@sep = split(/\|/, $hash{$key});
				$gettime = $current_date - $sep[0];
			}
			if ($gettime >= 86400) {
				delete $hash{$key};	
			}
		}
	}
	
	# Check for unique click
	foreach $key (keys %hash) {
		if ($pay == 1) {
			if (exists $hash{$ENV{'REMOTE_ADDR'}}) { $noclick = 1; }
		} else {
			if (exists $hash{$ENV{'REMOTE_ADDR'}."|".$keyword}) {
				@sep = split(/\|/, $hash{$key});
				if ($sep[1] eq $user) { $noclick = 1; }
			}
		}
	}
	$mon = (localtime)[4]+1;

	#Add up daily stats if new month
	if (exists $hash{'lastrun'}) {
		if ($mon <=> $hash{'lastrun'}) {
			if ($mon == 1) {
				$lastmon = 12;
				$lastdate = "MON".$lastmon.".".((localtime)[5] + 1899);
			} else {
				$lastmon = $mon-1;
				$lastdate = "MON".$lastmon.".".((localtime)[5] + 1900);
			}
			foreach $key (keys %hash) {
				if ($key =~ /STAT/) {
					@dat = split(/\./, $key);
					if ($dat[1] == $lastmon) {
						if ($pay == 3) {
							@split = split(/\|/, $hash{$key});
							$addclick += $split[0];
							$addbid += $split[1];
							$addtotal = "$addclick|$addbid";
						} else {
							$addtotal += $hash{$key};
						}
						delete $hash{$key};	
					}
				}
			}
			$hash{$lastdate} = $addtotal;
			$hash{'lastrun'} = $mon;
		}
	} else { $hash{'lastrun'} = $mon; }
	
	unless ($noclick) {
		#log unique click and stat
		# To store unique click, we need: time, keyword, ip and bid member
		if ($pay == 1) { $hash{$ENV{'REMOTE_ADDR'}} = "$current_date"; }
		else { $hash{$ENV{'REMOTE_ADDR'}."|".$keyword} = "$current_date|$user"; }
		
		# To store stat, we need date and click
		$date = "STAT".(localtime)[3].".".$mon.".".((localtime)[5] + 1900);
		if ($pay == 3) {
			if (exists $hash{$date}) {
				@split = split(/\|/, $hash{$date});
				$newclick = $split[0];
				$newclick++;
				$newbid = $split[1] + $bid;
				$hash{$date} = "$newclick|$newbid";
			} else {
				$hash{$date} = "1|$bid";
			}
		} else { $hash{$date}++; }
	}
	
	untie %hash;
	close DBLOCK;
}

1;