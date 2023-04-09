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
require $GPath{'cf_logs.pm'};

$PROGRAM_NAME = "club_links.cgi";


$max_groups = 10;
$rn = time;
$statuses{'official'} = 4;
$statuses{'recommented'} = 3;
$statuses{'approved'} = 2;
$statuses{'unreviewed'} = 1;
$forum_email = $CONFIG{'email'};
$CONFIG{'bbs_table1'} =~ s/ +.*//g;
$CONFIG{'bbs_table2'} =~ s/ +.*//g;

&parse_FORM;

$FORM{'category'} =~ s/\|$//;
($VALIDUSER, %IUSER) = &validate_session_no_error;

&lock("activity");
tie %data, "DB_File", "$GPath{'cforums_data'}/activity.db";
$data{$IUSER{'username'}} = "$rn\|$FORM{'club'}";
untie %data; 
&unlock("activity");


$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
%IFORUM = &readbbs($bbs_cfg);

open (FILE, "$GPath{'cforums_data'}/god.dat");
@god = <FILE>;
close(FILE);
$admin_num = $god[0];

$action = $FORM{'action'};
$forum=$FORM{'forum'} if (! $forum);


	$GRP = $forum;
	if ( !($GRP) ) { $GRP = "club"; }
	if ( !( -e "$GPath{'template_data'}/$GRP.txt" ) ) { $GRP = "club"; }


	if ($FORM{'action'} eq "edit") {
		&admin_form;
		&print_output('club_mod');
		exit;
	}
	elsif ($FORM{'action'} eq "add_link") {
		my $rnd=int rand 10000;
		if (&Not_Valid_URL($FORM{'url'})) {&bad_url;}
		&add_link;
		print "Location: $GUrl{'club_links.cgi'}?club=$FORM{'club'}&$rnd\n\n";
		&log_new_links($FORM{'club'});
		exit;
	}
	elsif ($FORM{'action'} eq "deletelink") {
		my $rnd=int rand 10000;
		&delete_link;
		print "Location: $GUrl{'club_links.cgi'}?club=$FORM{'club'}&$rnd\n\n";
		exit;
	}
	elsif ($FORM{'action'} eq "save_links") {
		my $rnd=int rand 10000;
		&save_links;
		print "Location: $GUrl{'club_links.cgi'}?club=$FORM{'club'}&$rnd\n\n";
		exit;
	}
	else {
		&log_visit($FORM{'club'});
		&Page_Header($GRP); 
	}


sub Body {
	&Links;
}


sub delete_link {
	open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/links.txt");
	@lines = <FILE>;
	close (FILE);

	open (FILE, ">$GPath{'clubs_data'}/$FORM{'club'}/links.txt");
	foreach $l (@lines) {
		@r = split(/\|\|/, $l);
		if ($r[0] eq $FORM{'id'}) {}
		else {
			print FILE $l;
		}
	}
	close (FILE);
}


sub add_link {
	$id = time . "," . $$;
	$line  = "$id\|\|";
	$line .= "$FORM{'category'}\|\|";
	$line .= "$FORM{'url'}\|\|";
	$line .= "$FORM{'title'}\|\|";
	$line .= "$IUSER{'username'}\|\|";
	$line .= "$FORM{'description'}\|\|";
	$line =~ s/(\n|\cM)/ /g;

	if (-e "$GPath{'clubs_data'}/$FORM{'club'}/links.txt") {
		open (FILE, ">>$GPath{'clubs_data'}/$FORM{'club'}/links.txt");
	}
	else {
		open (FILE, ">$GPath{'clubs_data'}/$FORM{'club'}/links.txt");
	}
	print FILE "$line\n";
	close (FILE);
}

sub Links {
	$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
	open (FILE, "$dir/l_intro.txt");
	@intro = <FILE>;
	close (FILE);
	foreach $l (@intro) {
		$introtext .= $l;
	}

	open (FILE, "$dir/l_settings.txt");
	@t = <FILE>;
	close (FILE);
	$admin_only = $t[0];

	if (-e "$GPath{'clubs_data'}/$FORM{'club'}/l_cats.txt") {
		open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/l_cats.txt");
 		@t = <FILE>;
		close (FILE);
		foreach $l (@t) {
			$l =~ s/(\n|\cM)//;
			push (@cats, $l);
		}
	}
	else {
		@cats = ("Home Pages", "Cool Stuff", "Free Stuff", "Business", "Computers");
	}

	open (FILE, "$GPath{'clubs_data'}/$FORM{'club'}/links.txt");
 	@t = <FILE>;
	close (FILE);
	foreach $l (@t) {
		$l =~ s/(\n|\cM)/ /;
		push (@links, $l);
	}	
	
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/links/list.tmplt");
	$OUT .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/links/list.tmplt";

	if (($admin_only ne "T") || (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num)))) {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/links/addform.tmplt");
		$OUT .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/links/addform.tmplt";
	}
}

sub save_links {
	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
		if (-d "$dir/") {}
		else {
			mkdir("$dir",0777) || &diehtml("Can't Create $dir: $!");
		}

		@lines = split(/(\n|\cM)/, $FORM{'linkcats'});
	
		open (FILE, ">$dir/l_cats.txt");
		foreach $l (@lines) {
			$l =~ s/(\n|\cM)//g;
			if ($l ne "") {
				print FILE "$l\n";
			}
		}
		close (FILE);
		open (FILE, ">$dir/l_intro.txt");
		print FILE "$FORM{'introtext'}";
		close (FILE);
	
		open (FILE, ">$dir/l_settings.txt");
		print FILE "$FORM{'admin_only'}";
		close (FILE);

		chmod (0777, "$dir/l_intro.txt");
		chmod (0777, "$dir/l_cats.txt");
		chmod (0777, "$dir/l_settings.txt");
	}
}

sub admin_form {
	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		$dir = "$GPath{'clubs_data'}/$FORM{'club'}";
		open (FILE, "$dir/l_cats.txt");
		@cats = <FILE>;
		close (FILE);
		foreach $c (@cats) {
			$linkcats .= $c;
		}

		open (FILE, "$dir/l_intro.txt");
		@intro = <FILE>;
		close (FILE);
		foreach $l (@intro) {
			$introtext .= $l;
		}

		open (FILE, "$dir/l_settings.txt");
		@t = <FILE>;
		close (FILE);
		$admin_only = $t[0];

		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/links/adminform.tmplt");
		$BODY .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/links/adminform.tmplt";
	}
}	


sub bad_url {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	&print_output('error');  
}


sub error_not_logged_in {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/errornotloggedin.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/errornotloggedin.tmplt";

	&print_output('error');  
}

