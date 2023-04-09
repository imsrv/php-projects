#!/usr/bin/perl
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
use DB_File;

$userpm = "T";
require "./common.pm";

$PROGRAM_NAME = "help.cgi";

&parse_FORM;

$FORM{'action'} =~ s/\W//g;
if ($FORM{'UserName'} ne "") {&get_user_no_password($FORM{'UserName'});}

if (-e "$GPath{'source_templates'}/help/$FORM{'action'}.tmplt") {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/help/$FORM{'action'}.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/help/$FORM{'action'}.tmplt";
}
elsif ($FORM{'action'} =~ /autoemail/) {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/help/autoemail.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/help/autoemail.tmplt";
}

&print_output('help');

exit 0;
