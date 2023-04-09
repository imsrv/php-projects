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
sub searchoptions {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/searchoptions.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/searchoptions.tmplt";

	&print_output('cforums_search');
}

sub SearchResults {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/searchresults.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/searchresults.tmplt";
}


sub go_search {
	@terms = split (/ +/, $FORM{'terms'});
	$cnt = 0;
	tie my %keywords, "DB_File", $keywordsdb;

	foreach $term (@terms) {
		$termcount++;
		$term =~ tr/A-Z/a-z/;
		$term =~ s/[^\w ]//g;

		if ($keywords{$term}) {
			(@matchs) = split(/\|/, $keywords{$term});
			foreach $match (@matchs) {
				($forum, $id, $thread, $count) = split(/&&/, $match);
				$count = $count+$found;
				$foundposts[$cnt]{'forum'} = $forum;
				$foundposts[$cnt]{'id'} = $id;
				$foundposts[$cnt]{'thread'} = $thread;
				$foundposts[$cnt++]{'count'} = $count;
			}
		}
	}

	$cnt--;

	for $tpost (0 .. $cnt) {
		$ttemp{$foundposts[$tpost]{'id'}}++;
	}
	$num_results = 0;
	foreach $t (keys %ttemp) {
		for $tfp (0 .. $cnt) {
			if ($t eq $foundposts[$tfp]{'id'}) {
				$foundposts[$tfp]{'count'} = $foundposts[$tfp]{'count'} * $ttemp{$t};
			}
			$num_results++;
		}
	}

	@foundposts = reverse sort { $a->{'count'} <=> $b->{'count'} } @foundposts;

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/gosearch.tmplt");
	$OUT = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/gosearch.tmplt";
}


sub usersearch {
	$cnt = 0;

	$FORM{'terms'} =~ /^(.)/;
	$udb = $1;
	$udb =~ tr/A-Z/a-z/;

	$userdatabase = "$GPath{'userpath'}/users_$udb.db";
	tie my %users, "DB_File", $userdatabase;
	($tloginname, $tloginpassword, $tuserfile, $tEmailver) = split(/&&/, $users{$FORM{'terms'}});

	tie my %memberposts, "DB_File", "$authorsdb";
	$TEMP .= $memberposts{$tuserfile};
	(@posts) = split (/\|/, $memberposts{$tuserfile});

	@posts = reverse sort @posts;

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/usersearch.tmplt");
	$OUT = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/usersearch.tmplt";
}

1;

