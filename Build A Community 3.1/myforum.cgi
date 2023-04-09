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
require "$GPath{'cf.pm'}";


$PROGRAM_NAME = "myforum.cgi";

&parse_FORM;

if ($FORM{'action'} eq "Login") {
	%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
}

elsif ($FORM{'action'} eq "Continue") {
	%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
	print "Location: $CONFIG{'COMMUNITY_full_cgi'}/$PROGRAM_NAME?$FORM{'vars'}\n";
	&basic_cookie;
	print "\n";
}

($VALID, %IUSER) = &validate_session;

if (($FORM{'action'} eq "Edit My Preferences") || ($FORM{'action'} =~ /Login/i) || ($FORM{'action'} eq "Preferences") || ($FORM{'action'} eq "")) {
	&get_lsettings;
	&print_profile;
	&print_output('login');
	exit;
}

if (($FORM{'action'} eq "Save My Preferences") || ($FORM{'action'} =~ /Save/i)) {
	&get_lsettings;
	&make_variables;
	&update_myforums;
	&save_settings;
	&return_html;
	&print_output('myforums');
	exit;
}

if ($FORM{'action'} eq "addfilter") {
	$FORM{'cfilteredusers'} = 1;
	$FORM{'cfilteron'} = 1;
	&get_lsettings;

	$tfilteredusers = $filteredusers;
	$tfilteredusers =~ s/!+/ /g;
	$FORM{'filteredusers'} = $tfilteredusers . " " . $FORM{'user'};
	$FORM{'filteron'} = "ON";
	&make_variables;
	&update_myforums;
	&save_settings;
	&print_profile;
	&print_output('myforums');
	exit;
}

	


if ($FORM{'action'} eq "highlight") {
	$FORM{'chighlightedposts'} = 1;
	&get_lsettings;
	@myhighlight = split(/!+/, $highlightedposts);
	$FOUND = "F";
	foreach $th (@myhighlight) {
		@thishighlight = split(/%%/, $th);
		if ($thishighlight[1] eq $FORM{'message'}) {
			$FOUND = "T";
		}
	}
	if ($FOUND ne "T") {
		$FORM{'highlightedposts'} .= $highlightedposts . "$FORM{'forum'}%%$FORM{'message'}!!";
	}
	else {
		$FORM{'highlightedposts'} = $highlightedposts;
	}

	&make_variables;
	&update_myforums;
	&save_settings;
	print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?forum=$FORM{'forum'}&thread=$FORM{'thread'}&action=message\n\n";
}

sub print_login_form {
	&build_login_form;
	&print_output('login');
}

sub build_login_form {
	$RETURNTO = $GUrl{'myforum.cgi'};
	$vars = $buffer;
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/members/login.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/members/login.tmplt";
}




sub return_html {
	if ($FORM{'returnto'} eq "") {
		print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi\n\n";
	}
	else {
		print "Location: $FORM{'returnto'}\n\n";
	}
	exit;
}


sub get_lsettings {
	$fn = $GPath{'userdirs'} . "/$IUSER{'filenum'}/myforums.txt";
#	&diehtml("$fn");
	open (FILE, "$fn");
	@content = <FILE>;
	close (FILE);
	chop @content;

	($filteron, $filterhow, $notifyhow, $emailonreponse, $daystoshow, $threadstoshow) = split(/&&/, $content[0]);
	$filteredusers = $content[1];
	$filteredwords = $content[2];
	$highlightedposts = $content[3];
	$notifywords = $content[4];
	$myforums = $content[5];

	if ($daystoshow eq "") { $daystoshow = $CONFIG{'daystoshow'};}
	if ($threadstoshow eq "") { $threadstoshow = $CONFIG{'threadstoshow'};}

}

sub save_settings {
	$fn = $GPath{'userdirs'} . "/$IUSER{'filenum'}/myforums.txt";
	open (FILE, ">$fn") || &diehtml("Can't write to $fn");
	print FILE "$filteron&&$filterhow&&$notifyhow&&$emailonreponse&&$daystoshow&&$threadstoshow\n";
	print FILE "$filteredusers\n";
	print FILE "$filteredwords\n";
	print FILE "$highlightedposts\n";
	print FILE "$notifywords\n";
	print FILE "$myforums\n";
	close (FILE);

}


sub update_myforums {
	if (($filteron ne $FORM{'filteron'}) && ($FORM{'cfilteron'})) {
		$filteron = $FORM{'filteron'};
	}
	if (($filteredusers ne $FORM{'filteredusers'}) && ($FORM{'cfilteredusers'})) {
		$filteredusers = $FORM{'filteredusers'};
	}
	if (($filteredwords ne $FORM{'filteredwords'}) && ($FORM{'cfilteredwords'})) {
		$filteredwords = $FORM{'filteredwords'};
	}
	if (($filterhow ne $FORM{'filterhow'}) && ($FORM{'cfilterhow'})) {
		$filterhow = $FORM{'filterhow'};
	}
	if (($highlightedposts ne $FORM{'highlightedposts'}) && ($FORM{'chighlightedposts'})) {
		$highlightedposts = $FORM{'highlightedposts'};
	}
	if (($notifywords ne $FORM{'notifywords'}) && ($FORM{'cnotifywords'})) {
		$notifywords = $FORM{'notifywords'};
	}
	if (($notifyhow ne $FORM{'notifyhow'}) && ($FORM{'cnotifyhow'})) {
		$notifyhow = $FORM{'notifyhow'};
	}
	if (($emailonreponse ne $FORM{'emailonreponse'}) && ($FORM{'cemailonreponse'})) {
		$emailonreponse = $FORM{'emailonreponse'};
	}
	if (($myforums ne $FORM{'myforums'}) && ($FORM{'cmyforums'})) {
		$myforums = $FORM{'myforums'};
	}
	if (($daystoshow ne $FORM{'daystoshow'}) && ($FORM{'cdaystoshow'})) {
		$daystoshow = $FORM{'daystoshow'};
	}
	if (($threadstoshow ne $FORM{'threadstoshow'}) && ($FORM{'cthreadstoshow'})) {
		$threadstoshow = $FORM{'threadstoshow'};
	}
#	foreach $k (keys %FORM) {
#		$BODY .= "$k -> $FORM{$k}<BR>\n";
#	}
#	&print_output("default");
}

sub make_variables {
	foreach $f(keys %FORM) {
		if ($f =~ /^f_/) {
			$FORM{'myforums'} .= $FORM{$f} . "!!";
		}
		if ($f =~ /^h_/) {
			push (@hl, $f);
		}
	}


	if ($FORM{'action'} ne "highlight") {
		@myhighlight = split(/!+/, $highlightedposts);
		foreach $th (@myhighlight) {
			$FOUND = "F";
			foreach $x (@hl) {
				if ($th eq $FORM{$x}) {
					$FOUND = "T";
				}
			}
			if ($FOUND ne "T") {
				$FORM{'highlightedposts'} .= $th . "!!";
			}
		}
	}


	$FORM{'filteredusers'} =~ s/[\n|\cM| ]+/!!/g;
	$FORM{'filteredwords'} =~ s/[\n|\cM| ]+/!!/g;
	$FORM{'highlightedposts'} =~ s/[\n|\cM| ]+/!!/g;
	$FORM{'notifywords'} =~ s/[\n|\cM| ]+/!!/g;
}




sub print_profile {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/myforum.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/myforum.tmplt";
}





sub error {
	$error = $_[0];

	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";
	&print_output('error');
}