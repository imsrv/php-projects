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

	open (DATA, "$GPath{'autohome_data'}/spidered/conversionlist.txt");
	my @LIST = <DATA>;
	close (DATA);

	open (DATA, "$GPath{'autohome_data'}/spidered/oftheday.txt");
	my @CONTENT = <DATA>;
	close (DATA);

	foreach my $d (@LIST) {
		$d =~ s/(\n|\cM)//g;
		my @td = split(/\|\|/, $d);
		foreach my $c (@CONTENT) {
			my @tc = split(/\|\|/, $c);
			if ($tc[0] eq $td[1]) {
				$DAILYCONTENT{$td[0]} = $tc[1];
			}
		}
	}


	sub TELEVISIONJOKES {
		return $DAILYCONTENT{'television'};
	}

	sub GENERALJOKES {
		return $DAILYCONTENT{'jokes'};
	}

	sub LOVELIFEJOKES {
		return $DAILYCONTENT{'love_life'};
	}

	sub SCIENCEPOLITICSJOKES {
		return $DAILYCONTENT{'science_politics'};
	}

	sub TRIVIA {
		return $DAILYCONTENT{'trivia'};
	}

	sub BORNONTHISDAY {
		return $DAILYCONTENT{'bornonthisday'};
	}

	sub COMPUTERNERDS {
		return $DAILYCONTENT{'computernerds'};
	}

	sub MOVIEQUOTES {
		return $DAILYCONTENT{'quotes'};
	}
1;
