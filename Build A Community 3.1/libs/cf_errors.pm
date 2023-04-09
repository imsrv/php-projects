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
sub spelling_error {
	$warningtext = $_[0];

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/spellingerror.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/spellingerror.tmplt";

	&print_output('error');  
}


sub posting_denied {
	$error = "posting_denied";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	&print_output('error');  
}

sub bad_name {
	$error = "bad_name";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	# For the sake of convience, just spit it out.
	&print_output('error');  
}


sub forum_closed {
	$error = "forum_closed";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	&print_output('error');  
}

sub subject_required {
	$error = "subject_required";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	&print_output('error');  
}


sub approval_denied {
	$error = "approval_denied";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	&print_output('error');  
}


sub modification_denied {
	$error = "modification_denied";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	&print_output('error');  
}


1;
