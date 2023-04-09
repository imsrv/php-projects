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

sub io_get_template {
	my ($template) = $_[0];

	my $fn = $CONFIG{'data_dir'} . "/templates/" . $template ."\.txt";
	if (! -e "$fn") {
		if ($PROGRAM_NAME eq "postcards.cgi") {
			$fn = $CONFIG{'data_dir'} . "/templates/pc_default.txt";
		}
		elsif ($PROGRAM_NAME =~ /autoemail.*\.cgi/) {
			$fn = $CONFIG{'data_dir'} . "/templates/autoemail.txt";
		}
		elsif ($PROGRAM_NAME =~ /my.*\.cgi/) {
			$fn = $CONFIG{'data_dir'} . "/templates/myhomesettings.txt";
		}
		elsif ($PROGRAM_NAME =~ /club/) {
			$fn = $CONFIG{'data_dir'} . "/templates/club.txt";
			if (! -e $fn) {
				$fn = $CONFIG{'data_dir'} . "/templates/bbs.txt";
			}
		}
		else {
			$fn = $CONFIG{'data_dir'} . "/templates/cb_default.txt";
		}
	}
	if (! -e $fn) {
		$fn = $CONFIG{'data_dir'} . "/templates/cb_default.txt";
	}


	open(TEMPLATES,"$fn") || &diehtml("Can't open $fn\n");
   	my @template = <TEMPLATES>;
   	close(TEMPLATES);

	return $fn, @template;
}

sub io_flag_activity {
	my ($failed_time,$remote_address,$UserName,$Message,$Program) = @_;

	open (FLAGS, ">>$CONFIG{'data_dir'}/community/flags.txt");
	$failed_time = time;
	print FLAGS "$failed_time||$remote_address||$UserName||$Message||$Program\n";
	close FLAGS;
}

sub io_get_list {
	my ($list, $details) = @_;

	my %lists = (
		find_submission_email          => "$GPath{'community_data'}/find_submission_email.txt",
		flagged                        => "$CONFIG{'data_dir'}/watchwords.txt",
		bad                            => "$CONFIG{'data_dir'}/badwords.txt",
		profile                        => "$GPath{'community_data'}/profile_text.txt",
		rules                          => "$GPath{'community_data'}/rules.txt",
		thank_you_page                 => "$GPath{'community_data'}/thank_you_page.txt",
		initial_email                  => "$GPath{'community_data'}/initial_email.txt",
		passwords                      => "$CONFIG{'data_dir'}/passwords.txt",
	);

	open(TEMPLATES,"$lists{$list}") || &diehtml("Can't open $lists{$list}");
   	my @file = <TEMPLATES>;
   	close(TEMPLATES);

	return @file;
}


sub io_save_template {
	my ($template, $rs_source) = @_;
	
	$fn = "$GPath{'template_data'}/$template";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$$rs_source\n";
	close(FILE);
	chmod 0777, "$fn";
}

1;
