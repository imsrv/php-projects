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
sub clean_logs {
	my ($fn, @log, $time, $today, $yesterday, $previousday);

	$log_day = $1;
	$today = &US_Date($rn);
	$yesterday = $rn - 86400;
	$yesterday = &US_Date($yesterday);
	$previousday = $rn - 172800;
	$previousday = &US_Date($previousday);

	$today =~ s/\//_/g;
	$yesterday =~ s/\//_/g;
	$previousday =~ s/\//_/g;

	opendir(FILES, "$GPath{'cforums_data'}/") || &diehtml("Can't open $GPath{'cforums_data'}/");
    	while($file = readdir(FILES)) {
		if ($file =~ /^$forum%(.+)\.log$/) {
			if (($1 eq $today) || ($1 eq $yesterday) || ($1 eq $previousday)) {}
			else {
				unlink ("$GPath{'cforums_data'}/$file");
			}
		}
	}
}


sub log_upload {
	my ($f) = $_[0];
	my ($fn, @log, $time);

	$time = &US_Date($rn);
	$time =~ s/\//_/g;

	&lock("log_$f");
	$fn = "$GPath{'cforums_data'}/$f%$time.log";
	open (LOG, $fn);
	@log = <LOG>;
	close (LOG);

	chomp(@log);

	$log[3]++;
	open (LOG, ">$fn");
	print LOG "$log[0]\n$log[1]\n$log[2]\n$log[3]\n$log[4]\n$log[5]";
	close (LOG);
	&unlock("log_$f");
	chmod (0777, $fn);
}

sub log_new_news {
	my ($f) = $_[0];
	my ($fn, @log, $time);

	$time = &US_Date($rn);
	$time =~ s/\//_/g;

	&lock("log_$f");
	$fn = "$GPath{'cforums_data'}/$f%$time.log";
	open (LOG, $fn);
	@log = <LOG>;
	close (LOG);

	chomp(@log);

	$log[4]++;
	open (LOG, ">$fn");
	print LOG "$log[0]\n$log[1]\n$log[2]\n$log[3]\n$log[4]\n$log[5]";
	close (LOG);
	&unlock("log_$f");
	chmod (0777, $fn);
}

sub log_new_links {
	my ($f) = $_[0];
	my ($fn, @log, $time);

	$time = &US_Date($rn);
	$time =~ s/\//_/g;

	&lock("log_$f");
	$fn = "$GPath{'cforums_data'}/$f%$time.log";
	open (LOG, $fn);
	@log = <LOG>;
	close (LOG);

	chomp(@log);

	$log[5]++;
	open (LOG, ">$fn");
	print LOG "$log[0]\n$log[1]\n$log[2]\n$log[3]\n$log[4]\n$log[5]";
	close (LOG);
	&unlock("log_$f");
	chmod (0777, $fn);
}

sub log_visit {
	my ($f) = $_[0];
	my ($fn, @log, $time);

	$time = &US_Date($rn);
	$time =~ s/\//_/g;

	&lock("log_$f");
	$fn = "$GPath{'cforums_data'}/$f%$time.log";
	open (LOG, $fn);
	@log = <LOG>;
	close (LOG);

	chomp(@log);

	$log[0]++;
	open (LOG, ">$fn");
	print LOG "$log[0]\n$log[1]\n$log[2]\n$log[3]\n$log[4]\n$log[5]";
	close (LOG);
	&unlock("log_$f");
	chmod (0777, $fn);
}

sub log_post {
	my ($f) = $_[0];
	my ($fn, @log, $time);

	$time = &US_Date($rn);
	$time =~ s/\//_/g;

	&lock("log_$f");
	$fn = "$GPath{'cforums_data'}/$f%$time.log";
	open (LOG, $fn);
	@log = <LOG>;
	close (LOG);

	chomp(@log);

	$log[1]++;
	open (LOG, ">$fn");
	print LOG "$log[0]\n$log[1]\n$log[2]\n$log[3]\n$log[4]\n$log[5]";
	close (LOG);
	&unlock("log_$f");
	chmod (0777, $fn);
}

sub log_join {
	my ($f, $inc) = @_;
	my ($fn, @log, $time);

	$time = &US_Date($rn);
	$time =~ s/\//_/g;

	&lock("log_$f");
	$fn = "$GPath{'cforums_data'}/$f%$time.log";
	open (LOG, $fn);
	@log = <LOG>;
	close (LOG);

	chomp(@log);

	$log[2] = $log[2] + $inc;
	open (LOG, ">$fn");
	print LOG "$log[0]\n$log[1]\n$log[2]\n$log[3]\n$log[4]\n$log[5]";
	close (LOG);
	&unlock("log_$f");
	chmod (0777, $fn);
}

1;
