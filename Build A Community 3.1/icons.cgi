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

$PROGRAM_NAME = "icons.cgi";

&parse_FORM;

if ($FORM{'action'} eq "") {
	$rnd=int rand 10000;
	print "Location: $GUrl{'icons.cgi'}?action=okay&$rnd\n\n";
	exit;
}
elsif ((($FORM{'action'} ne "") && ($ENV{'HTTP_COOKIE'} ne "")) && (($FORM{'action'} ne "Login") && ($FORM{'action'} ne "Continue"))) { 
	($VALID, %IUSER) = &validate_session;
}
elsif (($FORM{'action'} eq "Continue") || ($FORM{'action'} eq "Login")) {
	%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
	print "Location: $GUrl{'icons.cgi'}?action=okay&$rnd\n";
	&basic_cookie;
	print "\n";
}
else {
	&build_login_form;
	&print_output('login');
}

&make_variables;

if ($FORM{action} eq "Previous") {
	$startnum = $startnum - 100;
	if ($startnum < 1) {
		$startnum = 1;}
	&print_list;
	&print_output('profile');
}

elsif (($FORM{action} eq "Change Icon") || ($FORM{action} eq "More")) {
	&print_list;
	&print_output('profile');
}

elsif ($FORM{action} eq "Update Your Icon"){
	&update_profile;
	&print_output('profile');
}

else {
	&print_list;
	&print_output('profile');
}





sub build_login_form {
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";
}



sub update_profile {
	require "./cm/user_changes.pm";

	if ($IUSER{'icon'} ne $FORM{'Icon'}) {
		&change_icon($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'Icon'},\%IUSER);
	}
	&return_html;
}




sub return_html {
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/iconsconfirm.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/iconsconfirm.tmplt";
}




sub make_variables {
	$startnum = $FORM{'startnum'};
	$selectedicon = $FORM{'icon'};
}




sub print_list {
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/iconselection.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/iconselection.tmplt";
}








