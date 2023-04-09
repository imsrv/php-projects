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
# $debug=1;

	$userpm = "T";
	require("./common.pm"); 
	require $GPath{'admaster.pm'}; 
	&parse_FORM;

	$site_com_db = $GPath{'admaster_data'} . "/site_community.db";
	$site_cat_db = $GPath{'admaster_data'} . "/site_cats.db";


	$group = $input{'group'};
	if (!$group) {
		$group="default";
	}

	$account = $input{'account'};
	$show = $input{'show'};
  
	# Find the group / account file...

	if(! &lock("admaster")) {
		&bmPANIC;
	}

	($VALID, %IUSER) = &validate_session_no_error;

	my @tgroups = ("age_$IUSER{'Age'}", "sex_$IUSER{'Sex'}", "group_$IUSER{'user_level'}", "state_$IUSER{'State'}", "country_$IUSER{'Country'}", "zipcode_$IUSER{'ZipCode'}", "city_$IUSER{'City'}", "children_$IUSER{'Children'}", "income_$IUSER{'Income'}", "primary_computer_usage_$IUSER{'Primary_Computer_Use'}", "education_$IUSER{'Education'}", "employment_$IUSER{'Employment'}");

	$memberdir = $ENV{'DOCUMENT_URI'};
	$memberdir =~ s/\/(\w+\.shtml)//i;
	$memberdir = $CONFIG{'COMMUNITY_public_html'} . $memberdir;
	$memberdir =~ s/$CONFIG{'PAGEMASTER_base'}\///;


	my @dirs = split(/\//, $memberdir);

	if ($CONFIG{'useSubCommunities'} eq "YES") {
		$SiteOwner = $dirs[1];
	}
	else {
		$SiteOwner = $dirs[1];
	}

	tie my %site_cat, "DB_File", $site_cat_db;
	$category = $site_cat{$SiteOwner};

	tie my %site_community, "DB_File", $site_com_db;
	$community = $site_community{$SiteOwner};

	push (@tgroups, "site_category_$category", "site_community_$community");

	my $FOUND = undef;
	tie my %groups, "DB_File", $groupsdb;
	foreach my $k (@tgroups) {
		@accounts=split(/\|/,$groups{$k});
		foreach my $a (@accounts) {
			push(@ga, $a);
			$chance{$a}++;
			$FOUND++;
		}
	}
	
	if ($FOUND) {
#		$FOUND--;
		srand;
		my $x = int rand $FOUND;
		$TEMP .= "found: $FOUND picking: $x meaning: $ga[$x] chances were: $chance{$ga[$x]}/$FOUND\n";
		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &Use_Account($ga[$x]);
	}
	else {
		if ($account ne "") {
			&Use_Account($account);
		}
		else {
			($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &Use_Group($group);
		}
	}

	&unlock("admaster");

	# Show the banner
	&Show_Banner;

	if ($debug) { 
		print "<PRE>\n\nDebug Mode...\n\n$debug_text</PRE>"; 
	}

	exit 0;






sub Show_Banner {

	print "Content-Type: text/html\n\n";

	if($target =~ "NONE") {
		$TARGET="";
	}
	else {
		$TARGET="TARGET=\"$target\"";
	}

	$PELAPSEDTIME = gettimeofday-$PSTART;

	if ($banner_type eq "IMAGE") { 
		$CODE = "<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\"><TR><TD><CENTER>\n";
		$CODE .= "<A HREF=\"$GUrl{'adm_click.cgi'}?account=$acct_name\" $TARGET><IMG SRC=\"$image\" BORDER=\"0\" HEIGHT=\"$banner_height\" WIDTH=\"$banner_width\" ALT=\"$alt_text\"></A></CENTER>\n";
		$CODE .= "</TD></TR><TR BGCOLOR=\"black\"><TD><CENTER><FONT FACE=\"arial\" COLOR=\"white\" SIZE=\"$CONFIG{'font_size'}\">$under_text</FONT></CENTER></TD></TR></TABLE>\n";
	}

	elsif($banner_type eq "TEXT") {
		$CLICK = "$GUrl{'adm_click.cgi'}?account=$acct_name";
		$RANDNUM = int rand 10000;
		$GROUPNAME = $group;

		$banner_text =~ s/RANDNUM/$RANDNUM/g;
		$banner_text =~ s/GROUPNAME/$GROUPNAME/g;
		$banner_text =~ s/CLICK/$CLICK/g;

		$CODE = "<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\" WIDTH=\"$banner_width\"><TR><TD HEIGHT=\"$banner_height\">$banner_text</TD></TR></TABLE>\n";
	}
	else {
		$CODE = "<!-- No Banner Returned -->$TEMP\n";
	}

	print $CODE;
}




