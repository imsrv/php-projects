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
if (-e $GPath{'user.pm'}) {
	$USER = "T";
	require $GPath{'user.pm'};
}

$accountsdb = "$GPath{'admaster_data'}/accounts.db";
$groupsdb = "$GPath{'admaster_data'}/groups.db";
$lastdb = "$GPath{'admaster_data'}/rotation.db";
$clickdb = "$GPath{'admaster_data'}/clicks.db";
$tot_imp = "$GPath{'admaster_data'}/acctimp.db";
$tot_clk = "$GPath{'admaster_data'}/acctclicks.db";
$showndb =    "$GPath{'admaster_data'}/exshown.db";
$creditsdb =  "$GPath{'admaster_data'}/excredits.db";


##############################################################################
#  Show a banner for a specific group  (SSI)
##############################################################################
sub Group_Banner {
	if(! &lock("admaster")) {
		&bmPANIC;
	}

	my($group) = $_[0];

	$debug_text = "";

#	if (! $group) {
#		if ((! $VALID) && (! $VALIDUSER) && ($USER eq "T")) {
#			($VALID, %IUSER) = &validate_session_no_error;
#		}
#
#		my @tgroups = ("age_$IUSER{'Age'}", "sex_$IUSER{'Sex'}", "group_$IUSER{'user_level'}", "state_$IUSER{'State'}", "country_$IUSER{'Country'}", "zipcode_$IUSER{'ZipCode'}", "city_$IUSER{'City'}", "children_$IUSER{'Children'}", "income_$IUSER{'Income'}", "primary_computer_usage_$IUSER{'Primary_Computer_Use'}", "education_$IUSER{'Education'}", "employment_$IUSER{'Employment'}");
#
#		my $FOUND = undef;
#		tie my %groups, "DB_File", $groupsdb;
#		foreach my $k (@tgroups) {
#			$debug_text .= "<LI>$k => $groups{$k}<BR>\n";
#			@accounts=split(/\|/,$groups{$k});
#			foreach my $a (@accounts) {
#	#			if (! $a) {next;}
#				push(@ga, $a);
#				$chance{$a}++;
#				$FOUND++;
#				$debug_text = "<BR><B>foung: $a -></B>\n";
#			}
#		}
#	}	

#	if ($FOUND) {
#		$FOUND--;
#		srand;
#		my $x = int rand $FOUND;
#		$debug_text .= "found: $FOUND picking: $x meaning: $ga[$x] chance's were: $chance{$ga[$x]}/$FOUND\n";
#		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &Use_Account($ga[$x]);
#	}
#	else {
#		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &Use_Group($group);
#	}
	
#	if (! $acct_name) {
		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &Use_Group('default');
#	}

	&unlock("admaster");
  
	if($target =~ "NONE") { $TARGET=""; }
	else { $TARGET="TARGET=\"$target\""; }

	if ($banner_type eq "IMAGE") { 
		$CODE = "<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\"><TR><TD><CENTER>\n";
		$CODE .= "<A HREF=\"$GUrl{'adm_click.cgi'}?account=$acct_name\" $TARGET><IMG SRC=\"$image\" BORDER=\"0\" HEIGHT=\"$banner_height\" WIDTH=\"$banner_width\" ALT=\"$alt_text\"></A></CENTER>\n";
		$CODE .= "</TD></TR><TR BGCOLOR=\"black\"><TD><CENTER><FONT FACE=\"arial\" COLOR=\"white\" SIZE=\"$font_size\">$under_text</FONT></CENTER></TD></TR></TABLE>\n";
	}

	elsif($banner_type eq "TEXT") {
		$CLICK = "$GUrl{'adm_click.cgi'}?account=$acct_name";

		$banner_text =~ s/CLICK/$CLICK/g;

		$CODE = "<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\" WIDTH=\"$banner_width\"><TR><TD HEIGHT=\"$banner_height\">$banner_text</TD></TR></TABLE>\n";
	}

	$RANDNUM = int rand 10000;
	$GROUPNAME = $group;
	$CODE =~ s/RANDNUM/$RANDNUM/g;
	$CODE =~ s/GROUPNAME/$GROUPNAME/g;

	if ($debug) { $CODE = "Ad-Master matching ($Saved_Terms)...<BR>$debug_text<BR>Used: ($group)<BR>$CODE\n"; }

	return($CODE);
}



##############################################################################
#  Show a banner for a specific account
##############################################################################
sub Use_Account {
	$account = $_[0];

	my $ugroup = undef;
	my @return = undef;

	if ( -e "$GPath{'admaster_data'}/accounts/$account.DISABLED" ) { 
		my $group = "default";
		$ugroup = "default";
		@return = &Use_Group($group);
	}
	else {
		@return = &bmUpdate_Account($account,"acct");
		$debug_text .= "<B>using account: $account</B><BR>\n";
	}
	$debug_text .= "<B>return: $return[8], $return[11]</B>\n";
	if (($return[8] =~ /\w/) || ($return[11] =~ /\w/) || ($ugroup eq "default")) {
		return @return;
	}
	else {
		my $group = "default";
		return &Use_Group($group); 
	}
}



##############################################################################
#  Show a banner for a specific group 
##############################################################################
sub Use_Group {
	my ($group) = $_[0];
	my (@grp_accounts);
	my (@accounts);


	$using_original_group = 1;

	tie my %groups, "DB_File", $groupsdb; 

	#--------------------------------------------------------------------------------#
	# Read in the sent group file and check to see that there are accounts in it     #
	#--------------------------------------------------------------------------------#
	if (($group) && ($groups{$group})) {
		@accounts=split(/\|/,$groups{$group});
		$debug_text .= "Opened $group ($groups{$group})\n";

		if ($#accounts < 0) { 
			if ($group ne "default") {
				$using_original_group=0;
				$group = "default"; 
			}
			else {
				&bmPANIC;
			}
		}

		$debug_text .= "Count: $#accounts ... using: $group\n";

	}
	else { 
		$debug_text .= "Sent group ($group) does not exist\n";
		if ($group ne "default") {
			$using_original_group=0;
			$group = "default"; 
		}
		else {
			&bmPANIC;
		}
	}

	if (! $using_original_group) {
		$debug_text .= "Group Changed, had to read in $group file\n";
		@accounts=split(/\|/,$groups{"default"});
	}


	#--------------------------------------------------------------------------------#
	# Now, we have a list of accounts.  Make sure atleast one is not disabled.       #
	#--------------------------------------------------------------------------------#
   
	foreach my $account (@accounts) {
		if($account && $account ne "1") {
			$debug_text .= "Checking $account\n";
			if (! -e "$GPath{'admaster_data'}/accounts/$account.DISABLED") {
				$found++;
				push @grp_accounts, $account;
				$debug_text .= "Adding: $account to rotation list\n";
			}
		}
	}
	if (! $found) {
		$debug_text .= "No accounts were valid in $group ... Reverting to default group\n";
		if ($group eq "default") {
			&bmPANIC;
		}
		$group = "default";

		my @accounts=split(/\|/,$groups{"default"});
		my $found = undef;

		foreach my $account(@accounts) {
			if (! -e "$GPath{'admaster_data'}/accounts/$account.DISABLED") {
				$found++;
				push @grp_accounts,$account;
			}
		}

		if (! $found) {
			&bmPANIC;
		}
	}

	#--------------------------------------------------------------------------------#
	# At this point, we should have atleast one account to show.                     #
	#--------------------------------------------------------------------------------#

	if (! $PANIC) {
		tie %lastbanner, "DB_File", $lastdb;

		### Find the last one...
		$Last_Banner_Shown = $lastbanner{$group};
		$Last_Banner_Shown =~ s/\cM//g;
		$Last_Banner_Shown =~ s/\n//g;
		$Last_Banner_Shown =~ s/\r//g;

		### Go through the group file to find it.
		### If we are at the end of the group, start over
		### If not, then show the next one.

		$Num_Accounts = $#grp_accounts;
		if($Last_Banner_Shown >= $Num_Accounts) {
			$Next_Banner_To_Show = 0;
		}
		else {
			$Next_Banner_To_Show = $Last_Banner_Shown + 1;
		}

		$debug_text .= "Using $Num_Accounts as base\n";
		$debug_text .= "Last Banner: $Last_Banner_Shown ($grp_accounts[$Last_Banner_Shown])\n";
		$debug_text .= "Next Banner: $Next_Banner_To_Show ($grp_accounts[$Next_Banner_To_Show])\n";
   
		$account = $grp_accounts[$Next_Banner_To_Show];
		$account =~ s/\cM//g;
		$account =~ s/\n//g;
		$account =~ s/\r//g;

		$debug_text .= "Using: $account\n";

   
		$lastbanner{$group} = $Next_Banner_To_Show;

		untie %lastbanner;

		### Update the Account and Get the banner file.
		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = &bmUpdate_Account($account,"grp");
	}
	return ($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date);

}


sub bmUpdate_Account {
	my $ACCOUNT = $_[0];
	my $SOURCE = $_[1];

	if ( $ENV{'HTTP_REFERER'} ) {
		$REF=$ENV{'HTTP_REFERER'};
	}
	else {
		$REF=$SELF;
	}

	tie my %accounts, "DB_File", $accountsdb;
	my ($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = split(/\|/,$accounts{$ACCOUNT});
	## Update the Impressions for Total Calculations ##
	tie my %totals,"DB_File",$tot_imp;
	$totals{$ACCOUNT}++;
	$NewImpressions=$totals{$ACCOUNT};
	untie %totals;

       
	## Get time for the log file...
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$year = $year + 1900;

	if(length($mday) == 1) { $mday = "0$mday"; }
	$month = $mon+1;
	if(length($month) == 1) { $month = "0$month"; }

	$name = "$month" . "_" . "$mday" . "_" . "$year.log";

	$TIME=time;
	$DATE_STRING = "$month" . "_" . "$mday" . "_" . "$year";

	$filename = "$GPath{'admaster_data'}/logs/$ACCOUNT.$name";

	if ($BMS) { 
		$who = $ENV{'REMOTE_ADDR'};
		tie my %clicks, "DB_File", $clickdb;
		$clicks{$who} = $ACCOUNT;
		untie %clicks;
	}

	open("LOG",">>$filename");
	print LOG "$TIME|$REF|$SOURCE\n";
	close(LOG);

	$rtime = time;
	$RAND = "x$rtime";
	$RAND = substr($rtime,-1,1);
	$R1 = "RAND";

	$banner_text =~ s/$R1/$RAND/g;

	if ($banner =~ "http") {
		$LOCAL = "F";
		$image = "$banner";
		$image =~ s/$R1/$RAND/g;
 
	}
	else { 
		$LOCAL = "T";
		$image = "$banner_dir/$banner";
		$image =~ s/$R1/$RAND/g;
		$real_image = "$full_banner_dir/$banner"; 
		$real_image =~ s/$R1/$RAND/g;
	}

#		$CODE .= "<H1>$end_date | $DATE_STRING</H1>\n";

	### Check for Disabling....
	if ($expiration_type eq "impressions" && $NewImpressions >= $num_impressions) {
		&bmDisable_Account;
	}
	elsif ($expiration_type eq "date") {
		($e_month, $e_day, $e_year) = split(/\//,$end_date);
		($d_month, $d_day, $d_year) = split(/\_/,$DATE_STRING);
		$CODE .= "<H1>$e_month, $e_day, $e_year | $d_month, $d_day, $d_year</H1>\n";

		$comp .= "Compared $e_month/$e_day/$e_year (expires) to $d_month/$d_day/$d_year (today)...<BR>\n";

		## Date Comparisons ....
 
		## This year less than expiration year
		if ($d_year > $e_year) {
			$comp .= "Disabled due to year.";
			&bmDisable_Account;
		}

		## Same year, this month later than expiration month
		elsif ($d_year == $e_year && $d_month > $e_month) {
			$comp .= "Disabled due to month.";
			&bmDisable_Account;
		}

		## Same year, same month, today later than expiration day
		elsif ($d_year == $e_year && $d_month == $e_month && $d_day > $e_day) {
			$comp .= "Disabled due to day.";
			&bmDisable_Account;
		}
		$CODE .= $comp;
	}
	return ($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date);
}


sub bmClick_Account {
	$acct = $_[0];
	if ($acct) {
		$ACCOUNT = $acct;
	}
	else {
		$who = $ENV{'REMOTE_ADDR'};
		tie %clicks,"DB_File",$clickdb;
		$ACCOUNT = $clicks{$who};
		untie %clickdb;
		$ACCOUNT =~ s/\cM//g;
		$ACCOUNT =~ s/\n//g;
		$ACCOUNT =~ s/\r//g;
	}

	if ( $ENV{'HTTP_REFERER'} ) {
		$REF=$ENV{'HTTP_REFERER'};
	}
	else {
		$REF=$SELF;
	}

	tie %accounts,"DB_File",$accountsdb;
	if ($accounts{$ACCOUNT}) {
		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner,$banner_width,$banner_height,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = split(/\|/,$accounts{$ACCOUNT});

		tie %totals,"DB_File",$tot_clk;
		$totals{$ACCOUNT}++;
		$NewClicks=$totals{$ACCOUNT};
		untie %totals;

		if($expireation_type eq "clicks" && $NewClicks >= $num_clicks) {
			&bmDisable_Account;
		}
	}
	else {
		&bmCLICK_PANIC;
	}
	untie %accounts;

	## Log the Click / Referring Page
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$year = $year + 1900;

	if(length($mday) == 1) {
		$mday = "0$mday";
	}
	$month = $mon+1;
	if(length($month) == 1) {
		$month = "0$month";
	}

	$name = "$month" . "_" . "$mday" . "_" . "$year.clicks";
	$TIME=time;
	$filename = "$GPath{'admaster_data'}/logs/$ACCOUNT.$name";

	open("LOG",">>$filename");
	print LOG "$TIME|$REF|click\n";
	close(LOG);

	$lines[0] =~ s/\n//g;

	return $expiration_type, $num_clicks, $redirect_url;
}

1;
