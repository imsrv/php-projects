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

#use Time::HiRes qw(gettimeofday);
#$PSTART = gettimeofday;

use DB_File;

$userpm = "T";
require "./common.pm";
require "$GPath{'imagesize.pm'}";


$postactivitydb = "$GPath{'cforums_data'}/postactivity.db";
$activitydb = "$GPath{'cforums_data'}/activity.db";

tie %memberposts, "DB_File", "$GPath{'cforums_data'}/authors.db";

$PROGRAM_NAME = "profile.cgi";

&parse_FORM;

%TUSER = &get_user_no_password($FORM{'UserName'},"NO");

$TUSER{'password'} = undef;

	(@posts) = split (/\|/, $memberposts{$TUSER{'filenum'}});

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/members/moreinfo.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/members/moreinfo.tmplt";
	&print_output('member');

exit;

