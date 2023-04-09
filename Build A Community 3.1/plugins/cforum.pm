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


	sub CONTROL_PANEL {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/controlpanel.tmplt");
		my $cp = $template->fill_in;
#		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/controlpanel.tmplt";
		return $cp;
	}

	sub FORUMNAME {
		return $IFORUM{'title'};
	}

	sub MODERATORNAME {
		return $MOD{'name'};
	}

1;
