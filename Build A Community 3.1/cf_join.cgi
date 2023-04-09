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

$PROGRAM_NAME = "clubs.cgi";


$forum_email = $CONFIG{'email'};
$CONFIG{'bbs_table1'} =~ s/ +.*//g;
$CONFIG{'bbs_table2'} =~ s/ +.*//g;

&parse_FORM;

&get_user($FORM{'UserName'},$FORM{'PassWord'});

$FORM{'comments'} =~ s/(\n|\cM)/ /g;
$FORM{'UserName'} =~ s/(\n|\cM)//g;

open (MEMBERS, ">>$GPath{'cforums_data'}/$FORM{'forum'}.members.tmp");
print MEMBERS "$FORM{'UserName'}\|$FORM{'comments'}\n";
close (MEMBERS);

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/applicationreceived.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/applicationreceived.tmplt";



	&print_output('join_club');

