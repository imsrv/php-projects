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


&Validate_Admin;


sub build_search_line {
	local ($searchtype) = $_[0];

	if ($searchtype eq "username") {
		$search_line = $IUSER{'username'};
	}
	elsif ($searchtype eq "email") {
		$search_line = $IUSER{'email'};
	}
	elsif ($searchtype eq "url") {
		$search_line = $IUSER{'url'} . $IUSER{'urlname'};
	}
	elsif ($searchtype eq "screen_info") {
		$search_line = $IUSER{'realname'} . $IUSER{'handle'} . $IUSER{'description'};
	}
	elsif ($searchtype eq "phone_numbers") {
		$search_line = $IUSER{'Phonenumber'} . $IUSER{'Faxnumber'};
	}
	elsif ($searchtype eq "age") {
		$search_line = $IUSER{'Age'};
	}
	elsif ($searchtype eq "sex") {
		$search_line = $IUSER{'Sex'};
	}
	elsif ($searchtype eq "level") {
		$search_line = $IUSER{'user_level'};
	}


	elsif ($searchtype eq "totalbytes") {
		$search_line = $USER_totalbytes;
	}
	elsif ($searchtype eq "num_files") {
		$search_line = $USER_number_of_files;
	}
	elsif ($searchtype eq "recentvisits") {
		$search_line = $USER_Recent_visit;
	}
	elsif ($searchtype eq "total_hits") {
		$search_line = $USER_Hits_Total;
	}


	elsif ($searchtype eq "creation") {
		$search_line = $IUSER{'creation_date'};
	}
	elsif ($searchtype eq "lastupdate") {
		$search_line = $IUSER{'last_update'};
	}

	elsif ($searchtype eq "status") {
		$search_line = $IUSER{'status'};
	}
	elsif ($searchtype eq "expiry_date") {
		$search_line = $IUSER{'expiry_date'};
	}
	elsif ($searchtype eq "notes") {
		$search_line = $IUSER{'admin_notes'};
	}
	elsif ($searchtype eq "fillers") {
		$search_line = $IUSER{'Filler1'} . $IUSER{'Filler2'} . $IUSER{'Filler3'} . $IUSER{'Filler4'} . $IUSER{'Filler5'} . $IUSER{'Filler6'} . $IUSER{'Filler7'} . $IUSER{'Filler8'} . $IUSER{'Filler9'} . $IUSER{'Filler10'};
	}


	elsif ($searchtype eq "address") {
		$search_line = $IUSER{'Address'} . $IUSER{'State'} . $IUSER{'Country'} . $IUSER{'ZipCode'} . $IUSER{'City'};
	}
	elsif ($searchtype eq "zipcode") {
		$search_line = $IUSER{'ZipCode'};
	}
	else {
		$search_line = $IUSER{'realname'} . $IUSER{'username'} . $IUSER{'email'} . $IUSER{'password'} . $IUSER{'url'} . $IUSER{'urlname'} . $IUSER{'handle'} . $IUSER{'description'};
	}
}

sub time_search_database {
	local ($searchtype) = $_[0];
	local ($searchtime) = $_[1];
	local ($method) = $_[2];

	open(FILE, "$databasefile") || &diehtml("I can't open $databasefile\n");
		@data = <FILE>; 
	close(FILE);

	foreach $user (@data) {
		$found = "false";

		($USER_num, $IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}, $USER_totalbytes, $USER_number_of_files, $USER_Recent_visit, $USER_Hits_Total) = split(/&&/, $user);
		&build_search_line($searchtype);
		if ($method eq "prior") {
			if (($searchtime > $search_line) && ($IUSER{'username'} ne "")) {
				$found = "true";
			}
		}
		elsif ($method eq "after") {
			if (($searchtime < $search_line) && ($IUSER{'username'} ne "")) {
				$found = "true";
			}
		}
		elsif ($method eq "equals") {
			($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($search_line);
			$days = $mday * 86400;

			$mon++;
			if ($mon == 1) {$month = 0;}
			elsif ($mon == 2) {$month = 31;}
			elsif ($mon == 3) {$month = 59;}
			elsif ($mon == 4) {$month = 90;}
			elsif ($mon == 5) {$month = 120;}
			elsif ($mon == 6) {$month = 151;}
			elsif ($mon == 7) {$month = 181;}
			elsif ($mon == 8) {$month = 212;}
			elsif ($mon == 9) {$month = 243;}
			elsif ($mon == 10) {$month = 273;}
			elsif ($mon == 11) {$month = 304;}
			elsif ($mon == 12) {$month = 334;}
			$month = $month * 86400;

			$years = (($year - 70) * 365 * 86400) + (7 * 86400) ;

			$search_line = $years + $month + $days;
			if (($searchtime == $search_line) && ($IUSER{'username'} ne "")) {
				$found = "true";
			}
		}

		$fn = "$GPath{'community_data'}/email_titles.txt";
		open(FILE, "$fn");
			$Titles = <FILE>;
		close(FILE);
		chomp $Titles;
		($REJECT1, $REJECT2, $REJECT3) = split(/&&/, $Titles);

		if ($found eq "true") {
			$r_line = "<TR><TD><form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'update_profile.cgi'}\"><INPUT TYPE=hidden NAME=\"Listing\" VALUE=\"YES\"><INPUT TYPE=hidden NAME=\"UserName\" VALUE=\"$IUSER{'username'}\"><INPUT TYPE=HIDDEN NAME=UserNum VALUE=\"$USER_num\">$IUSER{'username'}</TD><TD>$IUSER{'password'}</TD><TD>$IUSER{'email'}</TD><TD><A HREF=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=view_details&UserNum=$USER_num&UserName=$IUSER{'username'}\');\">View / Edit Details</A></TD>";
			if ($FORM{'action'} =~ /View Inactive Members/i) {
				$r_line .= "<TD>\n";
				&parse_date($IUSER{'last_update'});
				$r_line .= "$date\n";
				$r_line .= "</TD>\n";
			}

			if ($CONFIG{'COMMUNITY_Approve_New_Members'} eq "YES") {
				if ($IUSER{'status'} eq "hold") {
					$r_line .= "<TD>\n";

					$r_line .= "Acceptance Letter:\n";
					$r_line .= "<BR><SELECT NAME=\"acceptance_email\">\n";
					$r_line .= "<OPTION VALUE=\"acceptance_email\" SELECTED>Use Default\n";
					$r_line .= "<OPTION VALUE=\"NONE\">Do Not Send\n";
					$r_line .= "</SELECT>\n";
					$r_line .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Activate User\"></CENTER>\n";

					$r_line .= "</TD>\n";
				}
				else {
					$r_line .= "<TD><BR></TD>\n";
				}
			}
			else {
				$r_line .= "<TD>\n";

				$r_line .= "<P>User Group:\n";
				$r_line .= "<BR><SELECT NAME=USER_user_level>\n";

				for $x(0 .. $max_groups) {
					if ($IUSER{'user_level'} == $x) {
						$GROUP_SELECT .= "<OPTION VALUE=\"$x\" SELECTED>$x</OPTION>\n";
					}
					else {
						$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
					}
				}
				$r_line .= $GROUP_SELECT;
				$r_line .= "</SELECT>\n";
				$r_line .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Change User Group\"></CENTER>\n";

				$r_line .= "</TD>\n";
			}

			$r_line .= "<TD>\n";
			$r_line .= "Rejection/Deletion Letter:\n";
			$r_line .= "<BR><SELECT NAME=\"rejection_email\">\n";
			if ($REJECT1 ne "") {$r_line .= "<OPTION VALUE=\"rejection_email_1\">$REJECT1\n";}
			if ($REJECT2 ne "") {$r_line .= "<OPTION VALUE=\"rejection_email_2\">$REJECT2\n";}
			if ($REJECT3 ne "") {$r_line .= "<OPTION VALUE=\"rejection_email_3\">$REJECT3\n";}
			$r_line .= "<OPTION VALUE=\"NONE\" SELECTED>Do Not Send\n";
			$r_line .= "</SELECT>\n";

			$r_line .= "<INPUT TYPE=HIDDEN NAME=\"User2Delete\" VALUE=\"$IUSER{'username'}\">\n";
			$r_line .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Delete Applicant\">\n";
			$r_line .= "</TD>\n";

			$r_line .= "</TR>";
			push(@results,"$r_line\n");
		}
	}
	if (@results == 0) {push(@results,"<TR><TD COLSPAN=4>No Matching Users</TD></TR>");}
}

sub search_database {
	local ($searchtype) = $_[0];
	local ($searchstring) = $_[1];
	local ($method) = $_[2];

	if (($CONFIG{'COMMUNITY_Use_DBM'} eq "YES") && ($method eq "equals") && ($searchtype ne "level")) {
		if ($searchtype eq "username") {
			require ("$lib_dir/user_dbm.pm");
			&get_user_no_password($searchstring);
			$found = "true";	

		}
		if ($searchtype eq "email") {
			require ("$lib_dir/user_dbm.pm");
			&get_user_by_email($searchstring);
			$found = "true";	
		}
		$USER_num = $IUSER{'filenum'};
		&outputuser;
	}
	else {
		if (($method eq "equals") && ($searchtype ne "level")) {$method = "contains";}
		open(FILE, "$databasefile") || &diehtml("I can't open $databasefile\n");
			@data = <FILE>; 
		close(FILE);

		foreach $user (@data) {
			$found = "false";
			$foundmembers++;


			($USER_num, $IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}, $USER_totalbytes, $USER_number_of_files, $USER_Recent_visit, $USER_Hits_Total) = split(/&&/, $user);
			&build_search_line($searchtype);
			if ($method eq "not") {
				if (($search_line !~ /$searchstring/ig) && ($IUSER{'username'} ne "")) {
					$found = "true";
				}
			}
			elsif ($method eq "less") {
				if (($search_line <= $searchstring) && ($IUSER{'username'} ne "")) {
					$found = "true";
				}
			}
			elsif ($method eq "greater") {
				if (($search_line >= $searchstring) && ($IUSER{'username'} ne "")) {
					$found = "true";
				}
			}
			elsif ($method eq "equals") {
				if (($search_line == $searchstring) || ($search_line eq $searchstring)) {
					if ($IUSER{'username'} ne "") { 
						$found = "true";	
					}
				}
			}
			else {
				if (($search_line =~ /$searchstring/ig) && ($IUSER{'username'} ne "")) {
					$found = "true";
				}
			}
			if (($FORM{'include_wp'} eq "YES") && ($found eq "true")) {
				if ($USER_Recent_visit > $searchstring) {
					$found = "false";
				}
			}
			&outputuser;
		}
	if (@results == 0) {push(@results,"<TR><TD COLSPAN=4>No Matching Users</TD></TR>");}
	}
}

sub outputuser {

	$fn = "$GPath{'community_data'}/email_titles.txt";
	open(FILE, "$fn");
		$Titles = <FILE>;
	close(FILE);
	chomp $Titles;
	($REJECT1, $REJECT2, $REJECT3) = split(/&&/, $Titles);
	if ($found eq "true") {
		if ($BGCOLORn==1) {
			$BGCOLOR=" bgcolor=\"#ffffcc\"";
			$BGCOLORn=0;
		}
		else {
			$BGCOLOR="WHITE";
			$BGCOLORn=1;
		}
		$r_line = "<TR><TD $BGCOLOR><form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'update_profile.cgi'}\"><INPUT TYPE=hidden NAME=\"Listing\" VALUE=\"YES\"><INPUT TYPE=hidden NAME=\"UserName\" VALUE=\"$IUSER{'username'}\"><INPUT TYPE=HIDDEN NAME=UserNum VALUE=\"$USER_num\">$IUSER{'username'}</TD><TD $BGCOLOR>$IUSER{'password'}</TD><TD $BGCOLOR>$IUSER{'email'}</TD><TD $BGCOLOR><A HREF=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=view_details&UserNum=$USER_num&UserName=$IUSER{'username'}\');\">View / Edit Details</A></TD>";
#		if ($FORM{'action'} =~ /View Inactive Members/i) {
			$r_line .= "<TD $BGCOLOR>\n";
			&parse_date($IUSER{'last_update'});
			$r_line .= "$date\n";
			$r_line .= "</TD>\n";
#		}
		if ($CONFIG{'COMMUNITY_Approve_New_Members'} eq "YES") {
			if ($IUSER{'status'} eq "hold") {
				$r_line .= "<TD $BGCOLOR>\n";
				$r_line .= "Acceptance Letter:\n";
				$r_line .= "<BR><SELECT NAME=\"acceptance_email\">\n";
				$r_line .= "<OPTION VALUE=\"acceptance_email\" SELECTED>Use Default\n";
				$r_line .= "<OPTION VALUE=\"NONE\">Do Not Send\n";
				$r_line .= "</SELECT>\n";
				$r_line .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Activate User\"></CENTER>\n";
				$r_line .= "</TD>\n";
			}
			else {
				$r_line .= "<TD $BGCOLOR><BR></TD>\n";
			}
		}
		else {
			$r_line .= "<TD $BGCOLOR>\n";
			$r_line .= "<P>User Level:\n";
			$r_line .= "<BR><SELECT NAME=USER_user_level>\n";
			for $x(0 .. $max_groups) {
				if ($IUSER{'user_level'} == $x) {
					$GROUP_SELECT .= "<OPTION VALUE=\"$x\" SELECTED>$x</OPTION>\n";
				}
				else {
					$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
				}
			}
			$r_line .= $GROUP_SELECT;
			$r_line .= "</SELECT>\n";
			$r_line .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Change User Group\"></CENTER>\n";
			$r_line .= "</TD>\n";
		}

		$r_line .= "<TD $BGCOLOR>\n";
		$r_line .= "Rejection/Deletion Letter:\n";
		$r_line .= "<BR><SELECT NAME=\"rejection_email\">\n";
		if ($REJECT1 ne "") {$r_line .= "<OPTION VALUE=\"rejection_email_1\">$REJECT1\n";}
		if ($REJECT2 ne "") {$r_line .= "<OPTION VALUE=\"rejection_email_2\">$REJECT2\n";}
		if ($REJECT3 ne "") {$r_line .= "<OPTION VALUE=\"rejection_email_3\">$REJECT3\n";}
		$r_line .= "<OPTION VALUE=\"NONE\" SELECTED>Do Not Send\n";
		$r_line .= "</SELECT>\n";
		$r_line .= "<INPUT TYPE=HIDDEN NAME=\"User2Delete\" VALUE=\"$IUSER{'username'}\">\n";
		$r_line .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Delete Applicant\">\n";
		$r_line .= "</TD>\n";
		$r_line .= "</FORM></TR>";
		push(@results,"$r_line\n");
	}
}

sub view_members_on_hold {
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<FONT SIZE=1>All search results are drawn from the Administrative Database.  If it hasn't been re-built recently, new changes will not appear and the information may be outdated.</FONT><BR><BR>\n";


print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wMessageWindow=window.open(Loc,"wMessageWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wMessageWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT
	&search_database("status","hold","contains");

	print "<H4>Members Currently On Hold (Awaiting Approval):</H4>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4>\n";
	$start = $FORM{'start'};
	if ($start eq "") {$start = 0;}
	$lastmem = $start + 20;
   	for $x($start .. $lastmem) {
		if ($results[$x] ne "") {
			print "$results[$x]\n";
		}
	}
	print "</TABLE>\n";
	exit;
}



sub view_inactive_members {
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<FONT SIZE=1>All search results are drawn from the Administrative Database.  If it hasn't been re-built recently, new changes will not appear and the information may be outdated.</FONT><BR><BR>\n";

print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wMessageWindow=window.open(Loc,"wMessageWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wMessageWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT
	$s_time = time - ($FORM{'Num_Days'} * 60 * 60 *24);
	&search_database("lastupdate","$s_time","less");

	print "<H4>Members Who Have Been Inactive For $FORM{'Num_Days'} Days:</H4>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4>\n";
	$start = $FORM{'start'};
	if ($start eq "") {$start = 0;}
	$lastmem = $start + 100;
   	for $x($start .. $lastmem) {
		if ($results[$x] ne "") {
			print "$results[$x]\n";
		}
	}
	print "</TABLE>\n";
	exit;
}

sub get_midnights_time {
	$rightnow = time;
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime;
#	$year = $year + 1900;

	$mday++;
	$mon++;
	$year = $year - 70;

	$days = $mday * 86400;

	if ($mon == 1) {$month = 0;}
	elsif ($mon == 2) {$month = 31;}
	elsif ($mon == 3) {$month = 59;}
	elsif ($mon == 4) {$month = 90;}
	elsif ($mon == 5) {$month = 120;}
	elsif ($mon == 6) {$month = 151;}
	elsif ($mon == 7) {$month = 181;}
	elsif ($mon == 8) {$month = 212;}
	elsif ($mon == 9) {$month = 243;}
	elsif ($mon == 10) {$month = 273;}
	elsif ($mon == 11) {$month = 304;}
	elsif ($mon == 12) {$month = 334;}
	$month = $month * 86400;

	$years = ($year * 365 * 86400) + (7 * 86400); # 7 leap years since 1970, will need to be changed in 2004 (no leap year on centenials for some reason?  Blame the astronomers;=))

	$midnight = $years + $month + $days;
}




sub simple_reports {
	$| = 1;

	&get_midnights_time;

	$test_midnight = $midnight;
	$num_of_days = 10;
	$max_to_show = 100;

	$spyear = 365 * 24 * 60 *60;

	open(FILE, "$databasefile") || &diehtml("I can't open $databasefile\n");
		@data = <FILE>; 
	close(FILE);

	foreach $user (@data) {
		$test_midnight = $midnight;

		$foundmembers++;

		($USER_num, $IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}, $USER_totalbytes, $USER_number_of_files, $USER_Recent_visit, $USER_Hits_Total) = split(/&&/, $user);
		if ($IUSER{'username'} ne "") {
			if ($FORM{'signups'} eq "1") {
				$PROGRESS = "first test_midnight = $test_midnight<P>\n";
				$rep_count = 0;
				$notfound = "F";
				while ($IUSER{'creation_date'} < $test_midnight) {
					$test_midnight = $test_midnight - 86400;
					$PROGRESS .= "$test_midnight ====  $IUSER{'creation_date'}<BR>\n";
					$rep_count++;
					if ($rep_count > $num_of_days) {
						$notfound = "T";
						last;
					}
				}
				if ($notfound ne "T") {
					$perday{$test_midnight}++;
				}
			}
#			print "$PROGRESS\n";

			if ($FORM{'sex'} eq "1") {
				if ($IUSER{'Sex'} eq "") {$IUSER{'Sex'} = "N/A";}
				$sex{$IUSER{'Sex'}}++;
			}
			if ($FORM{'state'} eq "1") {
				if ($IUSER{'State'} eq "") {$IUSER{'State'} = "N/A";}
				$state{$IUSER{'State'}}++;
			}
			if ($FORM{'country'} eq "1") {
				if ($IUSER{'Country'} eq "") {$IUSER{'Country'} = "N/A";}
				$country{$IUSER{'Country'}}++;
			}
			if ($FORM{'zipcode'} eq "1") {
				if ($IUSER{'ZipCode'} eq "") {$IUSER{'ZipCode'} = "N/A";}
				$zipcode{$IUSER{'ZipCode'}}++;
			}
			if ($FORM{'city'} eq "1") {
				if ($IUSER{'City'} eq "") {$IUSER{'City'} = "N/A";}
				$city{$IUSER{'City'}}++;
			}
			if ($FORM{'referer'} eq "1") {
				if ($IUSER{'Referer'} eq "") {$IUSER{'Referer'} = "N/A";}
				$referer{$IUSER{'Referer'}}++;
			}

			if ($FORM{'agebydate'} eq "1") {
				my $tage = 0;
				my $date = timelocal(0,0,0,$IUSER{'BirthDay'},$IUSER{'BirthMonth'},$IUSER{'BirthYear'},0,0,0);
				$date = time - $date;
				if ($date < 0) {$tage = "N/A";}
				else {
					$tage = int($date/$spyear);
				}
				$age{$tage}++;
			}
			if ($FORM{'agebyentry'} eq "1") {
				if ($IUSER{'Age'} eq "") {$IUSER{'Age'} = "N/A";}
				$age{$IUSER{'Age'}}++;
			}
			if ($FORM{'views'} eq "1") {
				if ($IUSER{'num_visits'} < 10) {
					$views{'10'}++;
				}
				elsif ($IUSER{'num_visits'} < 100) {
					$views{'100'}++;
				}
				elsif ($IUSER{'num_visits'} < 500) {
					$views{'500'}++;
				}
				elsif ($IUSER{'num_visits'} < 1000) {
					$views{'1000'}++;
				}
				elsif ($IUSER{'num_visits'} < 2500) {
					$views{'2500'}++;
				}
				elsif ($IUSER{'num_visits'} < 5000) {
					$views{'5000'}++;
				}
				elsif ($IUSER{'num_visits'} < 7500) {
					$views{'7500'}++;
				}
				elsif ($IUSER{'num_visits'} < 10000) {
					$views{'10000'}++;
				}
				elsif ($IUSER{'num_visits'} < 15000) {
					$views{'15000'}++;
				}
				elsif ($IUSER{'num_visits'} < 20000) {
					$views{'20000'}++;
				}
				else {
					$views{'plus'}++;
				}
			}
			if ($FORM{'groups'} eq "1") {
				$groups{$IUSER{'user_level'}}++;
			}

			if ($FORM{'community'} eq "1") {
				if ($IUSER{'community'} eq "") {$IUSER{'community'} = "N/A";}
				$community{$IUSER{'community'}}++;
			}
		}
	}

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<FONT SIZE=2>All reports are drawn from the Administrative Database.  If it hasn't been re-built recently, new changes will not appear and the information may be outdated.</FONT><BR><BR>\n";

	
	if ($CONFIG{'NiceGraphs'} eq "YES") {
		print "Please note that the graphs on this page are generated on a BuildACommunity.com server.  We are currently offering this as a free service since the code to run it is still under development and will not run on most servers. Please note that you can return to the HTML format by changing the setting in the Configuration Settings (available along the top of the screen).\n<P>";
		print "<CENTER>\n";
	}

	if ($FORM{'signups'} eq "1") {
		if ($CONFIG{'NiceGraphs'} eq "YES") {
			my $xlabel = "Days";
			my $ylabel = "Registrations";
			my $title = "Registrations Per Day";
			my $data = undef;

			my $count = 0;
			my $x = 0;
			foreach my $k(sort keys %perday) {
				$data .= "$perday{$k},";
				&parse_date($k);
				$data .= "$month/$mday/$year|";
				if ($count++ > $num_of_days) {last;}
			}
			my $url = "$CONFIG{'GRAPH_Url'}?xlabel=" . &urlencode($xlabel) . "&ylabel=" . &urlencode($ylabel) . "&title=" . &urlencode($title) .  "&data=" . &urlencode($data);
			print "<IMG SRC=\"$url\"><P>\n";
		}
	}


	if ($FORM{'sex'} eq "1") {
		&displaygraph("","","Sex Breakdown","",\%sex,"pie");
	}

	if (($FORM{'agebydate'} eq "1") || ($FORM{'agebyentry'} eq 1)) {
		&displaygraph("Days","Registrations","Age Distribution","",\%age,"","key","noreverse");
	}

	if ($FORM{'groups'} eq "1") {
		&displaygraph("","","Break-Down By Group","Group ",\%groups,"pie");
	}

	if ($FORM{'state'} eq "1") {
		&displaygraph("","","Break-Down By State","",\%state,"","key","noreverse");
	}

	if ($FORM{'country'} eq "1") {
		&displaygraph("","","Break-Down By Country","",\%country,"","key","noreverse");
	}

	if ($FORM{'zipcode'} eq "1") {
		&displaygraph("","","Break-Down By ZipCode","",\%zipcode,"","key","noreverse");
	}

	if ($FORM{'city'} eq "1") {
		&displaygraph("","","Break-Down By City","",\%city,"","key","noreverse");
	}

	if ($FORM{'referer'} eq "1") {
		&displaygraph("","","Break-Down By Referer (prior to registration)","",\%referer,"","","","hbar");
	}


#	$state{$IUSER{'State'}}++;
#	$country{$IUSER{'Country'}}++;
#	$zipcode{$IUSER{'ZipCode'}}++;
#	$city{$IUSER{'City'}}++;
#	$referer{$IUSER{'Referer'}}++;
			
	if ($FORM{'views'} eq "1") {
		if ($CONFIG{'NiceGraphs'} eq "YES") {
			undef my $labels;
			$labels{'10'} = "less than 10";
			$labels{'100'} = "11 - 100";
			$labels{'500'} = "101 - 500";
			$labels{'1000'} = "501 - 1000";
			$labels{'2500'} = "1001 - 2500";
			$labels{'5000'} = "2501 - 5000";
			$labels{'7500'} = "5001 - 7500";
			$labels{'10000'} = "7501 - 10000";
			$labels{'15000'} = "10001 - 15000";
			$labels{'20000'} = "15001 - 20000";
			$labels{'plus'} = "20001 and more";
	
			my $xlabel = "";
			my $ylabel = "";
			my $title = "Pageviews Per Member";
			my $data = undef;

			my $x = 0;
			foreach my $k(sort keys %views) {
				$data .= "$views{$k},";
				$data .= "$labels{$k} pageviews|";
			}
			my $url = "$CONFIG{'GRAPH_Url'}?pie=T&xlabel=" . &urlencode($xlabel) . "&ylabel=" . &urlencode($ylabel) . "&title=" . &urlencode($title) .  "&data=" . &urlencode($data);
			print "<IMG SRC=\"$url\"><P>\n";
		}
		else {
			$count = 0;
			$x = 0;
			foreach $viewl(reverse sort keys %views) {
				if ($views{$viewl} > $x) {
					$x = $views{$viewl};
				}
			}

			$x = 300 / $x;

			print "<H3>Page Views</H3>\n";
			print "<TABLE>\n";
			foreach $mykey(sort {$views->{$a} <=> $views->{$b}} keys %views) {
				if ($views{$mykey} > 0) {
					if ($x == 0) {
						$x = 300 / $views{$mykey};
					}
					$length = $views{$mykey} * $x;
				}
				$length++;

				if ($mykey == 10) {
					$text = "less than 10";
				}
				elsif ($mykey == 100) {
					$text = "11 -- 100";
				}
				elsif ($mykey == 500) {
					$text = "101 --- 500";
				}
				elsif ($mykey == 1000) {
					$text = "501 -- 1000";
				}
				elsif ($mykey == 2500) {
					$text = "1001 -- 2500";
				}
				elsif ($mykey == 5000) {
					$text = "2501 -- 5000";
				}
				elsif ($mykey == 7500) {
					$text = "5001 -- 7500";
				}
				elsif ($mykey == 10000) {
					$text = "7501 -- 10000";
				}
				elsif ($mykey == 15000) {
					$text = "10001 -- 15000";
				}
				elsif ($mykey == 20000) {
					$text = "15001 -- 20000";
				}
				elsif ($mykey eq "plus") {
					$text = "20001 and more";
				}

				print "<TR><TD>$text</TD><TD>$views{$mykey}</TD><TD><IMG SRC=\"$CONFIG{'button_dir'}/bar.gif\" height=10 width=$length></TD></TR>\n";
				if ($count++ > $max_to_show) {last;}
			}
			print "</TABLE>\n";
		}
	}


	print "</BODY></HTML>\n";
	print " <SCRIPT LANGUAGE=\"javascript\">\n";
	print " <!--\n";
	print " function OpenWin(Loc) {\n";
	print "	wUploadWindow=window.open(Loc,\"wUploadWindow\",\"toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=400,height=300\");\n";
	print "  wUploadWindow.focus();\n";
	print " 	   }\n";
	print " 	// -->\n";
	print " 	</SCRIPT>\n";
      print "<BR><BR><B><CENTER><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;



}





sub setup_rules {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Membership Rules</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";

	print "<P>This form allows you to create and edit a Rules Page for your site that users have to read and agree to before registering.  You can turn that option on/off in the <A HREF=\"$GUrl{'eadmin.cgi'}?action=config\" target=\"NEW\">Configuration Section</A>.\n";

	open (FILE, "$GPath{'community_data'}/rules.txt");
	@RULES = <FILE>;
	close (FILE);

	print "<P><B>Rules Page:</B><BR><TEXTAREA NAME=RULES COLS=50 ROWS=5>\n";
	foreach $line (@RULES) {
		print $line;
	}
	print "</TEXTAREA>\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"save_rules\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_rules {
	my $fn = "$GPath{'community_data'}/rules.txt";
	open (FILE, ">$fn");
	print FILE "$FORM{'RULES'}\n";
	close (FILE);

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}

sub setup_fields {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Registration Questions</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<P>You can scroll through the following list of questions to decide which ones will be asked at registration time.  You can also decide whether an answer is <I>required</I> or not.  If it is required, the user will be prompted to answer if they leave the field blank.\n";

	print "<P>CommunityWeaver is equipped to handle Internet Explorer 5.+ AutoComplete commands on forms.  The option of having Internet Explorer 5.+ automatically fill in certain registration fields for the visiting user is available.  When there is a choice between submitting their business information or their home information, which would you prefer Internet Explorer use?  The member can override Internet Explorer's suggestions.\n";
	print "  <SELECT NAME=\"COMMUNITY_Vcard\">\n";
	print "   <OPTION VALUE=\"$COMMUNITY_Vcard\" SELECTED>$COMMUNITY_Vcard\n"; 
	print "   <OPTION VALUE=\"HOME\">HOME\n";
	print "   <OPTION VALUE=\"BUSINESS\">BUSINESS\n";
	print "  </SELECT><BR>\n";

print "  <P><B>Date of Birth</B> (MM/DD/YY)<B>:</B> <SELECT NAME=\"COMMUNITY_BirthDate\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_BirthDate\" SELECTED>$COMMUNITY_BirthDate\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_BirthDate_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_BirthDate_Required\" SELECTED>$COMMUNITY_BirthDate_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Age:</B> <SELECT NAME=\"COMMUNITY_Age\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Age\" SELECTED>$COMMUNITY_Age\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Age_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Age_Required\" SELECTED>$COMMUNITY_Age_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Sex:</B> <SELECT NAME=\"COMMUNITY_Sex\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Sex\" SELECTED>$COMMUNITY_Sex\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Sex_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Sex_Required\" SELECTED>$COMMUNITY_Sex_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Phone Number:</B> <SELECT NAME=\"COMMUNITY_PhoneNumber\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_PhoneNumber\" SELECTED>$COMMUNITY_PhoneNumber\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_PhoneNumber_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_PhoneNumber_Required\" SELECTED>$COMMUNITY_PhoneNumber_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Fax Number:</B> <SELECT NAME=\"COMMUNITY_FaxNumber\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_FaxNumber\" SELECTED>$COMMUNITY_FaxNumber\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_FaxNumber_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_FaxNumber_Required\" SELECTED>$COMMUNITY_FaxNumber_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";


print "  <P><B>Address:</B> <SELECT NAME=\"COMMUNITY_Address\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Address\" SELECTED>$COMMUNITY_Address\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Address_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Address_Required\" SELECTED>$COMMUNITY_Address_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";


print "  <P><B>City:</B> <SELECT NAME=\"COMMUNITY_City\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_City\" SELECTED>$COMMUNITY_City\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_City_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_City_Required\" SELECTED>$COMMUNITY_City_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>State/Province:</B> <SELECT NAME=\"COMMUNITY_State\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_State\" SELECTED>$COMMUNITY_State\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_State_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_State_Required\" SELECTED>$COMMUNITY_State_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Country:</B> <SELECT NAME=\"COMMUNITY_Country\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Country\" SELECTED>$COMMUNITY_Country\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Country_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Country_Required\" SELECTED>$COMMUNITY_Country_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>ZipCode:</B> <SELECT NAME=\"COMMUNITY_ZipCode\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_ZipCode\" SELECTED>$COMMUNITY_ZipCode\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_ZipCode_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_ZipCode_Required\" SELECTED>$COMMUNITY_ZipCode_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>ICQ:</B> <SELECT NAME=\"COMMUNITY_ICQ\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_ICQ\" SELECTED>$COMMUNITY_ICQ\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_ICQ_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_ICQ_Required\" SELECTED>$COMMUNITY_ICQ_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Marital Status:</B> <SELECT NAME=\"COMMUNITY_Marital_Status\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Marital_Status\" SELECTED>$COMMUNITY_Marital_Status\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Marital_Status_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Marital_Status_Required\" SELECTED>$COMMUNITY_Marital_Status_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Number Of Children:</B> <SELECT NAME=\"COMMUNITY_Children\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Children\" SELECTED>$COMMUNITY_Children\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Children_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Children_Required\" SELECTED>$COMMUNITY_Children_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Family Income:</B> <SELECT NAME=\"COMMUNITY_Income\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Income\" SELECTED>$COMMUNITY_Income\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Income_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Income_Required\" SELECTED>$COMMUNITY_Income_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Education:</B> <SELECT NAME=\"COMMUNITY_Education\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Education\" SELECTED>$COMMUNITY_Education\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Education_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Education_Required\" SELECTED>$COMMUNITY_Education_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Employment:</B> <SELECT NAME=\"COMMUNITY_Employment\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Employment\" SELECTED>$COMMUNITY_Employment\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Employment_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Employment_Required\" SELECTED>$COMMUNITY_Employment_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  <P><B>Area Of Primary Computer Use:</B> <SELECT NAME=\"COMMUNITY_Primary_Computer_Use\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Primary_Computer_Use\" SELECTED>$COMMUNITY_Primary_Computer_Use\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Primary_Computer_Use_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Primary_Computer_Use_Required\" SELECTED>$COMMUNITY_Primary_Computer_Use_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";



print "  <P><B>Optional Field 1:</B> <SELECT NAME=\"COMMUNITY_Filler1\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler1\" SELECTED>$COMMUNITY_Filler1\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler1_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler1_Required\" SELECTED>$COMMUNITY_Filler1_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler1_Prompt' NAME=\"COMMUNITY_Filler1_Prompt\" onFocus=\"select();\"><BR>\n";


print "  <P><B>Optional Field 2:</B> <SELECT NAME=\"COMMUNITY_Filler2\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler2\" SELECTED>$COMMUNITY_Filler2\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler2_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler2_Required\" SELECTED>$COMMUNITY_Filler2_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler2_Prompt' NAME=\"COMMUNITY_Filler2_Prompt\" onFocus=\"select();\"><BR>\n";


print "  <P><B>Optional Field 3:</B> <SELECT NAME=\"COMMUNITY_Filler3\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler3\" SELECTED>$COMMUNITY_Filler3\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler3_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler3_Required\" SELECTED>$COMMUNITY_Filler3_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler3_Prompt' NAME=\"COMMUNITY_Filler3_Prompt\" onFocus=\"select();\"><BR>\n";


print "  <P><B>Optional Field 4:</B> <SELECT NAME=\"COMMUNITY_Filler4\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler4\" SELECTED>$COMMUNITY_Filler4\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler4_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler4_Required\" SELECTED>$COMMUNITY_Filler4_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler4_Prompt' NAME=\"COMMUNITY_Filler4_Prompt\" onFocus=\"select();\"><BR>\n";



print "  <P><B>Optional Field 5:</B> <SELECT NAME=\"COMMUNITY_Filler5\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler5\" SELECTED>$COMMUNITY_Filler5\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler5_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler5_Required\" SELECTED>$COMMUNITY_Filler5_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler5_Prompt' NAME=\"COMMUNITY_Filler5_Prompt\" onFocus=\"select();\"><BR>\n";



print "  <P><B>Optional Field 6:</B> <SELECT NAME=\"COMMUNITY_Filler6\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler6\" SELECTED>$COMMUNITY_Filler6\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler6_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler6_Required\" SELECTED>$COMMUNITY_Filler6_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler6_Prompt' NAME=\"COMMUNITY_Filler6_Prompt\" onFocus=\"select();\"><BR>\n";



print "  <P><B>Optional Field 7:</B> <SELECT NAME=\"COMMUNITY_Filler7\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler7\" SELECTED>$COMMUNITY_Filler7\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler7_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler7_Required\" SELECTED>$COMMUNITY_Filler7_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler7_Prompt' NAME=\"COMMUNITY_Filler7_Prompt\" onFocus=\"select();\"><BR>\n";



print "  <P><B>Optional Field 8:</B> <SELECT NAME=\"COMMUNITY_Filler8\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler8\" SELECTED>$COMMUNITY_Filler8\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler8_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler8_Required\" SELECTED>$COMMUNITY_Filler8_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler8_Prompt' NAME=\"COMMUNITY_Filler8_Prompt\" onFocus=\"select();\"><BR>\n";



print "  <P><B>Optional Field 9:</B> <SELECT NAME=\"COMMUNITY_Filler9\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler9\" SELECTED>$COMMUNITY_Filler9\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler9_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler9_Required\" SELECTED>$COMMUNITY_Filler9_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler9_Prompt' NAME=\"COMMUNITY_Filler9_Prompt\" onFocus=\"select();\"><BR>\n";



print "  <P><B>Optional Field 10:</B> <SELECT NAME=\"COMMUNITY_Filler10\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler10\" SELECTED>$COMMUNITY_Filler10\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Required?: <SELECT NAME=\"COMMUNITY_Filler10_Required\">\n";
print "   <OPTION VALUE=\"$COMMUNITY_Filler10_Required\" SELECTED>$COMMUNITY_Filler10_Required\n"; 
print "   <OPTION VALUE=\"YES\">YES\n";
print "   <OPTION VALUE=\"NO\">NO\n";
print "  </SELECT><BR>\n";

print "  Prompt: <INPUT TYPE=\"TEXT\" VALUE='$COMMUNITY_Filler10_Prompt' NAME=\"COMMUNITY_Filler10_Prompt\" onFocus=\"select();\"><BR>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Database Fields\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_fields {
	$fn = "$GPath{'community_data'}/fields.pm";
	open(NEWCONFIG, ">$fn") || &diehtml("I can't create that $fn\n");
	print NEWCONFIG "\$COMMUNITY_Vcard = \'$FORM{'COMMUNITY_Vcard'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Age = \'$FORM{'COMMUNITY_Age'}\';\n";
	print NEWCONFIG "\$COMMUNITY_BirthDate = \'$FORM{'COMMUNITY_BirthDate'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Sex = \'$FORM{'COMMUNITY_Sex'}\';\n";
	print NEWCONFIG "\$COMMUNITY_PhoneNumber = \'$FORM{'COMMUNITY_PhoneNumber'}\';\n";
	print NEWCONFIG "\$COMMUNITY_FaxNumber = \'$FORM{'COMMUNITY_FaxNumber'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Address = \'$FORM{'COMMUNITY_Address'}\';\n";
	print NEWCONFIG "\$COMMUNITY_City = \'$FORM{'COMMUNITY_City'}\';\n";
	print NEWCONFIG "\$COMMUNITY_State = \'$FORM{'COMMUNITY_State'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Country = \'$FORM{'COMMUNITY_Country'}\';\n";
	print NEWCONFIG "\$COMMUNITY_ZipCode = \'$FORM{'COMMUNITY_ZipCode'}\';\n";
	print NEWCONFIG "\$COMMUNITY_ICQ = \'$FORM{'COMMUNITY_ICQ'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Marital_Status = \'$FORM{'COMMUNITY_Marital_Status'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Children = \'$FORM{'COMMUNITY_Children'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Income = \'$FORM{'COMMUNITY_Income'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Primary_Computer_Use = \'$FORM{'COMMUNITY_Primary_Computer_Use'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Education = \'$FORM{'COMMUNITY_Education'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Employment = \'$FORM{'COMMUNITY_Employment'}\';\n";

	print NEWCONFIG "\$COMMUNITY_Age_Required = \'$FORM{'COMMUNITY_Age_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Sex_Required = \'$FORM{'COMMUNITY_Sex_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_PhoneNumber_Required = \'$FORM{'COMMUNITY_PhoneNumber_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_FaxNumber_Required = \'$FORM{'COMMUNITY_FaxNumber_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Address_Required = \'$FORM{'COMMUNITY_Address_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_City_Required = \'$FORM{'COMMUNITY_City_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_State_Required = \'$FORM{'COMMUNITY_State_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Country_Required = \'$FORM{'COMMUNITY_Country_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_ZipCode_Required = \'$FORM{'COMMUNITY_ZipCode_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_BirthDate_Required = \'$FORM{'COMMUNITY_BirthDate_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_ICQ_Required_Required = \'$FORM{'COMMUNITY_ICQ_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Marital_Status_Required = \'$FORM{'COMMUNITY_Marital_Status_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Children_Required = \'$FORM{'COMMUNITY_Children_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Income_Required = \'$FORM{'COMMUNITY_Income_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Primary_Computer_Use_Required = \'$FORM{'COMMUNITY_Primary_Computer_Use_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Education_Required = \'$FORM{'COMMUNITY_Education_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Employment_Required = \'$FORM{'COMMUNITY_Employment_Required'}\';\n";


	print NEWCONFIG "\$COMMUNITY_Filler1 = \'$FORM{'COMMUNITY_Filler1'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler2 = \'$FORM{'COMMUNITY_Filler2'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler3 = \'$FORM{'COMMUNITY_Filler3'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler4 = \'$FORM{'COMMUNITY_Filler4'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler5 = \'$FORM{'COMMUNITY_Filler5'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler6 = \'$FORM{'COMMUNITY_Filler6'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler7 = \'$FORM{'COMMUNITY_Filler7'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler8 = \'$FORM{'COMMUNITY_Filler8'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler9 = \'$FORM{'COMMUNITY_Filler9'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler10 = \'$FORM{'COMMUNITY_Filler10'}\';\n";

	print NEWCONFIG "\$COMMUNITY_Filler1_Required = \'$FORM{'COMMUNITY_Filler1_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler2_Required = \'$FORM{'COMMUNITY_Filler2_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler3_Required = \'$FORM{'COMMUNITY_Filler3_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler4_Required = \'$FORM{'COMMUNITY_Filler4_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler5_Required = \'$FORM{'COMMUNITY_Filler5_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler6_Required = \'$FORM{'COMMUNITY_Filler6_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler7_Required = \'$FORM{'COMMUNITY_Filler7_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler8_Required = \'$FORM{'COMMUNITY_Filler8_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler9_Required = \'$FORM{'COMMUNITY_Filler9_Required'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler10_Required = \'$FORM{'COMMUNITY_Filler10_Required'}\';\n";

	print NEWCONFIG "\$COMMUNITY_Filler1_Prompt = \'$FORM{'COMMUNITY_Filler1_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler2_Prompt = \'$FORM{'COMMUNITY_Filler2_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler3_Prompt = \'$FORM{'COMMUNITY_Filler3_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler4_Prompt = \'$FORM{'COMMUNITY_Filler4_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler5_Prompt = \'$FORM{'COMMUNITY_Filler5_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler6_Prompt = \'$FORM{'COMMUNITY_Filler6_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler7_Prompt = \'$FORM{'COMMUNITY_Filler7_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler8_Prompt = \'$FORM{'COMMUNITY_Filler8_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler9_Prompt = \'$FORM{'COMMUNITY_Filler9_Prompt'}\';\n";
	print NEWCONFIG "\$COMMUNITY_Filler10_Prompt = \'$FORM{'COMMUNITY_Filler10_Prompt'}\';\n";

	print NEWCONFIG "\n\n1;\n";

	close(NEWCONFIG);
	chmod 0777, "$fn";


  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



sub edit_thank_you_page {
	$fn = "$GPath{'community_data'}/thank_you_page.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@THANK_YOU_PAGE = <FILE>;
	close(FILE);



  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit <I>Thank You</I> Page</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "Users will be brought to a confirmation page after they register, and this is where you can edit the body text of that page.  This text is inserted into the middle of a page, but is not a complete page in and of itself.  To edit the page itself, **click here**.\n";
	print "<P><B>Hint:</B> You can use some basic HTML and also insert the member's Username and Password into the body with PLUGIN:USERNAME and PLUGIN:PASSWORD.  But we highly recommend that you only reveal their Password to them in the email that is sent to them after registration.\n";
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	
      print "<P>\n";

	print "<FONT SIZE=+1><B>Body Text:</B></FONT>\n";
	print "<TEXTAREA NAME=THANK_YOU_PAGE COLS=60 ROWS=10>";
	foreach $line(@THANK_YOU_PAGE) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	
      print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Thank You Page\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_thank_you_page {
	$fn = "$GPath{'community_data'}/thank_you_page.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'THANK_YOU_PAGE'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	print "<HR>\n";
      print "<CENTER><B>Here is a preview of what your changes will look like:</B></CENTER>\n";
	print "$FORM{'THANK_YOU_PAGE'}\n";
	exit;
}


sub edit_badwords {
	$fn = "$CONFIG{'data_dir'}/badwords.txt";
	open(FILE, "$fn");
 		@BAD = <FILE>;
	close(FILE);

	$fn = "$CONFIG{'data_dir'}/watchwords.txt";
	open(FILE, "$fn");
 		@WATCH = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/banned_username.txt";
	open (FILE, "$fn");
	@USERNAMES = <FILE>;
	close (FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Bad/Flagged Words & Usernames</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "You can block new members from choosing certain disallowed words as usernames - we recommend words like \"admin\" or \"webmaster\".  Banned words are words that are automatically blocked when they are submitted.  A warning page is displayed to the user.  Flagged words will not be blocked but their use will be logged for human review.  Placing a word in both fields will warn the user <I>and</I> log the attempt.\n";
	print "<P>\n";

	print "<H3>Disallowed Usernames:</H3>\n";
	print "<TEXTAREA NAME=USERNAMES COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@USERNAMES) {
		$$line =~ s/(\n|\cM| )/\n/g;
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<H3>Edit Banned Words:</H3>\n";
	print "<TEXTAREA NAME=BAD COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@BAD) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<H3>Edit Flagged Words:</H3>\n";
	print "<TEXTAREA NAME=WATCH COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@WATCH) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Words\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_badwords {
	$fn = "$GPath{'community_data'}/banned_username.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'USERNAMES'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$CONFIG{'data_dir'}/badwords.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'BAD'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$CONFIG{'data_dir'}/watchwords.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'WATCH'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub edit_passwords {
	$fn = "$CONFIG{'data_dir'}/passwords.txt";
	open(FILE, "$fn");
 		@WORDS = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Default PassWords</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "If you have decided that members will be assigned a password at registration (instead of allowing them to choose their own), you can edit the password list here.  The words should range from five to twelve alpha-numeric characters.\n";
	print "<P>\n";

	print "<FONT SIZE=+1><B>PassWords:</B></FONT> <I>All lowercase without spaces or punctuation, separated by Enters.</I>\n";
	print "<TEXTAREA NAME=WORDS COLS=40 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@WORDS) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save PassWords\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
      print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_passwords {

	$fn = "$CONFIG{'data_dir'}/passwords.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'WORDS'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



sub edit_hints {
	$fn = "$GPath{'community_data'}/hints.txt";
	open(FILE, "$fn");
 		@HINTS = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Rotating Hints</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "When members log in to edit their site, they are presented with a variety of options.  Beneath the drop-down menu is an area for a random hint or instruction from you, which you can edit below.  Be sure to separate individual messages with <B>qqq</B> and the program will rotate them at random each time someone loads the page.\n";
	print "<P>\n";

	print "<FONT SIZE=+1><B>Hints:</B></FONT>\n";
	print "<TEXTAREA NAME=HINTS COLS=60 ROWS=10 WRAP=VIRTUAL>";
	foreach $line(@HINTS) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Hints\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
      print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_hints {
	$fn = "$GPath{'community_data'}/hints.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'HINTS'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}




sub edit_emails {
	$fn = "$GPath{'community_data'}/initial_email.txt";
	open(FILE, "$fn");
 		@INITIAL_EMAIL = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/password_email.txt";
	open(FILE, "$fn");
 		@PASSWORD_EMAIL = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/find_submission_email.txt";
	open(FILE, "$fn");
 		@FIND_EMAIL = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/acceptance_email.txt";
	open(FILE, "$fn");
 		@ACCEPTANCE_EMAIL = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/email_titles.txt";
	open(FILE, "$fn");
 		$Titles = <FILE>;
	close(FILE);
	($REJECT1, $REJECT2, $REJECT3) = split(/&&/, $Titles);

	$fn = "$GPath{'community_data'}/rejection_email_1.txt";
	open(FILE, "$fn");
 		@REJECTION_EMAIL_1 = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/rejection_email_2.txt";
	open(FILE, "$fn");
 		@REJECTION_EMAIL_2 = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/rejection_email_3.txt";
	open(FILE, "$fn");
 		@REJECTION_EMAIL_3 = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Automatic Emails</H3></CENTER></TD></TR>\n";
      print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
      print "<P><B>Hint:</B> Insert the following Plugins - [USERNAME], [FIRSTNAME], [LASTNAME] and [PASSWORD] - into an email field and the program will automatically include each member's personal Username and Password in the email.\n";	
      print "<P>\n";
      print "<P>\n";

	print "<FONT SIZE=+1><B>[Initial Email]:</B></FONT>  This is the initial email sent to users after they register.\n";
	print "<TEXTAREA NAME=INITIAL_EMAIL COLS=60 ROWS=10>";
	foreach $line(@INITIAL_EMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
      print "<P>\n";

      print "<FONT SIZE=+1><B>[Acceptance Email]:</B></FONT>  This is the email sent to users once you activate them.\n";  
      print "<BR><I>This is not needed if you do not have this feature turned on.</I>\n";
	print "<TEXTAREA NAME=ACCEPTANCE_EMAIL COLS=60 ROWS=10>";
	foreach $line(@ACCEPTANCE_EMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
      print "<P>\n"; 
      print "<P>\n";

	print "<FONT SIZE=+1><B>[Rejection Email #1]:</B></FONT>  This is the email sent to users if you reject them.  You also have two extra fields available to enter emails with alternative reasons for rejecting/deleting their application or membership.\n";
	print "<P><B>Email Title:</B> <INPUT TYPE=TEXT NAME=REJECT1 VALUE=\"$REJECT1\">\n";
	print "<TEXTAREA NAME=REJECTION_EMAIL_1 COLS=60 ROWS=10>";
	foreach $line(@REJECTION_EMAIL_1) {
		print "$line";
	}
	print "</TEXTAREA>\n";
      print "<P>\n";
      print "<P>\n";

	print "<FONT SIZE=+1><B>[Rejection Email #2]:</B></FONT>  This is the email sent to users if you reject them.  You also have two extra fields available to enter emails with alternative reasons for rejecting/deleting their application or membership.\n";
	print "<P><B>Email Title:</B> <INPUT TYPE=TEXT NAME=REJECT2 VALUE=\"$REJECT2\">\n";
	print "<TEXTAREA NAME=REJECTION_EMAIL_2 COLS=60 ROWS=10>";
	foreach $line(@REJECTION_EMAIL_2) {
		print "$line";
	}
	print "</TEXTAREA>\n";
      print "<P>\n";
      print "<P>\n";

	print "<FONT SIZE=+1><B>[Rejection Email #3]:</B></FONT>  This is the email sent to users if you reject them.  You also have two extra fields available to enter emails with alternative reasons for rejecting/deleting their application or membership.\n";
	print "<P><B>Email Title:</B> <INPUT TYPE=TEXT NAME=REJECT3 VALUE=\"$REJECT3\">\n";
	print "<TEXTAREA NAME=REJECTION_EMAIL_3 COLS=60 ROWS=10>";
	foreach $line(@REJECTION_EMAIL_3) {
		print "$line";
      
      }
	print "</TEXTAREA>\n";
      print "<P>\n";
      print "<P>\n";

	print "<FONT SIZE=+1><B>[Lost PassWord]:</B></FONT>  This is the email sent to members who have lost their password.\n";
	print "<TEXTAREA NAME=PASSWORD_EMAIL COLS=60 ROWS=10>";
	foreach $line(@PASSWORD_EMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
      print "<P>\n";

	print "<FONT SIZE=+1><B>[Find.cgi Submission Notification]:</B></FONT>  Sent to users when someone submits a new link to their personal search engine.\n";
	print "<TEXTAREA NAME=FIND_EMAIL COLS=60 ROWS=10>";
	foreach $line(@FIND_EMAIL) {
		print "$line";
	}
	print "</TEXTAREA>\n";
      print "<P>\n";

      print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Email Text\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_emails {
	$fn = "$GPath{'community_data'}/initial_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'INITIAL_EMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/find_submission_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'FIND_EMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/password_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'PASSWORD_EMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/acceptance_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'ACCEPTANCE_EMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/email_titles.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'REJECT1'}&&$FORM{'REJECT2'}&&$FORM{'REJECT3'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/password_email.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'PASSWORD_EMAIL'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/rejection_email_1.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'REJECTION_EMAIL_1'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/rejection_email_2.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'REJECTION_EMAIL_2'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/rejection_email_3.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'REJECTION_EMAIL_3'}\n";
	close(FILE);
	chmod 0777, "$fn";



  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}

sub edit_banned_users {
	$fn = "$GPath{'community_data'}/banned_hosts.txt";
	open(FILE, "$fn");
 		@HOSTS = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/banned_emails.txt";
	open(FILE, "$fn");
 		@EMAILS = <FILE>;
	close(FILE);

	$fn = "$GPath{'community_data'}/banned_message.txt";
	open(FILE, "$fn");
 		@MESSAGE = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Ban Users</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "No method of banning users on the Internet will ever be 100% effective.  If you ban an email address, there are a hundred different companies offering a free alternative.  Banning IPs does not work and banning hosts means that you are locking out anyone who shares the same ISP (eg: there are 10 million AOL users - to ban one would actually be to ban millions).  We've found that the best method to avoid problems is to add them to a ban list and then give them a cryptic message when they try to log in.  They'll try to get back in for a couple of days/weeks and then give up, thinking that there is a problem with your system.  They'll never realize that they have been targeted.  <I>You can also tell them plainly that they have been banned, and explain why, but not everyone is reasonable and they may attempt to cause problems for you and your site</I>.\n";
	print "<P>\n";

	print "<H3>Banned Email Addresses (most effective):</H3>\n";
	print "<TEXTAREA NAME=BANNED_EMAILS COLS=30 ROWS=10>";
	foreach $line(@EMAILS) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<H3>Banned Hosts:</H3>\n";
	print "<TEXTAREA NAME=BANNED_HOSTS COLS=30 ROWS=10>";
	foreach $line(@HOSTS) {
		print "$line";
	}
	print "</TEXTAREA>\n";

	print "<H3>Message To Display:</H3>\n";
	print "Cryptic is better than confrontational - even if it doesn't leave you feeling as satisfied ;).\n";
	print "<TEXTAREA NAME=MESSAGE COLS=60 ROWS=10>";
	foreach $line(@MESSAGE) {
		print "$line";
	}
	print "</TEXTAREA>\n";


	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Banned List\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}


sub save_banned_users {
	$fn = "$GPath{'community_data'}/banned_hosts.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'BANNED_HOSTS'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/banned_emails.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'BANNED_EMAILS'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$fn = "$GPath{'community_data'}/banned_message.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'MESSAGE'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub edit_footers_headers {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Page Headers/Footers</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "You can create up to four headers and footers which will automatically be added to members' pages.  You can select which ones to display depending on the member's user group (or you can have the same one shown regardless).  You need at least one header and footer (even if it's empty), but the others are optional.\n";
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<CENTER><SELECT NAME=\"file2edit\">\n";
	print "<OPTION VALUE=\"top1.txt\">Top 1</OPTION>\n";
	print "<OPTION VALUE=\"top2.txt\">Top 2</OPTION>\n";
	print "<OPTION VALUE=\"top3.txt\">Top 3</OPTION>\n";
	print "<OPTION VALUE=\"top4.txt\">Top 4</OPTION>\n";
	print "<OPTION VALUE=\"bottom1.txt\">Bottom 1</OPTION>\n";
	print "<OPTION VALUE=\"bottom2.txt\">Bottom 2</OPTION>\n";
	print "<OPTION VALUE=\"bottom3.txt\">Bottom 3</OPTION>\n";
	print "<OPTION VALUE=\"bottom4.txt\">Bottom 4</OPTION>\n";
	print "</SELECT>\n";
	print "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"Edit Text\">\n";
	print "<INPUT TYPE=SUBMIT VALUE=\"Edit Text!\"></FORM>\n";
	print "<P><FORM><INPUT TYPE=BUTTON VALUE=\"Edit Pop-Up!\" onClick=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=Edit+Pop-Up+Setup\');\">\n";
	print "<P><FORM><INPUT TYPE=BUTTON VALUE=\"Edit BBS Header!\" onClick=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=Edit+BBS+Header+Setup\');\">\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE>\n";
      print "<BR><BR><B><CENTER><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wMessageWindow=window.open(Loc,"wMessageWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wMessageWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT
	exit;
}


sub edit_weaver_frames {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Editor Frame (<I>optional</I>)</H3><I>This option only applies to the NEW version of CommunityWeaver</I></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";

	print "<P><FONT SIZE=+1><B>Top Menubar:</B></FONT>\n";
	print "<TEXTAREA NAME=topmenu COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/topmenu.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Side Menubar:</B></FONT>\n";
	print "<TEXTAREA NAME=sidemenu COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/sidemenu.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Main Frame Of The Front Page Of Weaver:</B></FONT>\n";
	print "<TEXTAREA NAME=mainframe COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/mainframe.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Index Page(s) Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=index_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/index_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Poll Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=poll_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/poll_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Email Page Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=email_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/email_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Links Page Main Frame</B></FONT>\n";
	print "<TEXTAREA NAME=links_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/links_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Guestbook Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=guestbook_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/guestbook_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";



	print "<P><FONT SIZE=+1><B>ILink Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=ilink_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/ilink_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>Search Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=search_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/search_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";


	print "<P><FONT SIZE=+1><B>BBS Main Frame:</B></FONT>\n";
	print "<TEXTAREA NAME=bbs_main_frame COLS=60 ROWS=10>";

	my $fn = "$GPath{'template_data'}/bbs_main_frame.txt";
	open(FILE, "$fn");
 	my @TEXT = <FILE>;
	close(FILE);

	foreach my $line(@TEXT) {
		print "$line";
	}

	print "</TEXTAREA>\n";
	print "<P>\n";

	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Frame Version\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}


sub save_weaver_frames {
	my $fn = "$GPath{'template_data'}/bbs_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'bbs_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";

	my $fn = "$GPath{'template_data'}/search_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'search_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";


	my $fn = "$GPath{'template_data'}/ilink_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'ilink_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";


	my $fn = "$GPath{'template_data'}/guestbook_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'guestbook_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";


	my $fn = "$GPath{'template_data'}/links_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'links_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";


	my $fn = "$GPath{'template_data'}/email_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'email_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";


	my $fn = "$GPath{'template_data'}/poll_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'poll_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";

	my $fn = "$GPath{'template_data'}/index_main_frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'index_main_frame'}\n";
	close(FILE);
	chmod 0777, "$fn";

	my $fn = "$GPath{'template_data'}/mainframe.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'mainframe'}\n";
	close(FILE);
	chmod 0777, "$fn";

	my $fn = "$GPath{'template_data'}/topmenu.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'topmenu'}\n";
	close(FILE);
	chmod 0777, "$fn";

	my $fn = "$GPath{'template_data'}/sidemenu.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'sidemenu'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'TEXT'}\n";
	exit;
}




sub edit_frame {
	$fn = "$GPath{'community_data'}/frame.txt";
	open(FILE, "$fn");
 		@TEXT = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Editor Frame (<I>optional</I>)</H3><I>This option only applies to the Old version of CommunityWeave</I></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "If you choose to use a frame to display ads while members are editing their pages, you need to provide the codes/text for the <B>BODY</B> of the frame.  The <B>HEAD</B> of the page is defined automatically in the <A HREF=\"$GUrl{'eadmin.cgi'}?action=config\" target=\"NEW\">Configuration Section</A>.\n";  
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	

	print "<P><FONT SIZE=+1><B>Text:</B></FONT>\n";
	print "<TEXTAREA NAME=TEXT COLS=60 ROWS=10>";
	foreach $line(@TEXT) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Frame\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_frame {
	$fn = "$GPath{'community_data'}/frame.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'TEXT'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'TEXT'}\n";
	exit;
}


sub edit_profile_text {
	$fn = "$GPath{'community_data'}/profile_text.txt";
	open(FILE, "$fn");
 		@TEXT = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit <I>What's New?</I> In Profile </H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "Through this form you can keep your visitors informed or provide links to other features on your site.  This text will appear in the righthand column of each member's Profile Page.  This text is inserted into the middle of the page and is not a complete page in and of itself.  To edit the page itself, **click here**.\n";
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	
	print "<P>\n";

	print "<B><FONT SIZE=+1>Text:</FONT></B>\n";
	print "<TEXTAREA NAME=TEXT COLS=60 ROWS=10>";
	foreach $line(@TEXT) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Profile Text\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_profile_text {
	$fn = "$GPath{'community_data'}/profile_text.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'TEXT'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'TEXT'}\n";
	exit;
}

sub edit_bbs_banner {
	$fn = "$GPath{'community_data'}/bbs_banner.txt";
	open(FILE, "$fn");
 		@TEXT = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit Forum Header</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<P>Because of the setup of forums, you can only control the header section of the page instead of both the header and footer sections.\n";
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	
	print "<P>\n";

	print "<FONT SIZE=+1><B>Text:</B></FONT>\n";
	print "<TEXTAREA NAME=TEXT COLS=60 ROWS=10>";
	foreach $line(@TEXT) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save BBS Header\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_bbs_banner {
	$fn = "$GPath{'community_data'}/bbs_banner.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'TEXT'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";

	print "<HR>\n";
	print "$FORM{'TEXT'}\n";
	exit;
}


sub edit_popup {
	$fn = "$GPath{'community_data'}/popup.txt";
	open(FILE, "$fn");
 		@TEXT = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Edit PopUp Window</H3></TD></TR>\n";
	print "<TR><TD>\n";
      print "<P>If you insert <B>PLUGIN:POPUP</B> inside of the header or footer of a member's page, a mini PopUp window will appear whenever someone visits that page.  This form controls the content of that PopUp window.  The height and width of this window can be altered in the <A HREF=\"$GUrl{'eadmin.cgi'}?action=config\" target=\"NEW\">Configuration Section</A>.\n";
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<P>\n";

	print "<P><B><FONT SIZE=+1>Text:</FONT></B>\n";
	print "<TEXTAREA NAME=TEXT COLS=60 ROWS=10>";
	foreach $line(@TEXT) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Popup\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_popup {
	$fn = "$GPath{'community_data'}/popup.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'TEXT'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";

	print "<HR>\n";
	print "$FORM{'TEXT'}\n";
	exit;
}


sub edit_top_bottom {
	$fn = "$GPath{'community_data'}/$FORM{'file2edit'}";
	open(FILE, "$fn");
 		@TEXT = <FILE>;
	close(FILE);


  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>View / Edit $FORM{'file2edit'}</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print ".\n";
      print "<P><A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> to view the other available Plugins.\n";	
	print "<P>\n";

	print "<H3>Text:</H3>\n";
	print "<TEXTAREA NAME=TEXT COLS=60 ROWS=10>";
	foreach $line(@TEXT) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	print "<INPUT TYPE=HIDDEN NAME=\"file2edit\" VALUE=\"$FORM{'file2edit'}\">\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Text\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_top_bottom {
	$fn = "$GPath{'community_data'}/$FORM{'file2edit'}";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'TEXT'}\n";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'TEXT'}\n";
	exit;
}


sub Validate_Admin {

   %passcookie= &split_cookie( $ENV{'HTTP_COOKIE'}, 'admin' );
   $password = $passcookie{'password'};


   $Allowed = "F";

   if ($password eq $CONFIG{'admin_pw'}) { $Allowed = "T"; }
   if ($moderator_pw) { $Allowed = "T"; }

   if ($Allowed eq "F") {
	&ADMIN_error("Access Denied.");
        exit 0;
   }


}


sub ADMIN_error {
   	$error = $_[0];
   	$UserName = $_[1];
   	$PassWord = $_[2];
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";

   	if ($error eq "bad_username") {
		print "<center><h3>ERROR: No such User</h3>\n";
   	}
   	elsif ($error eq "bad_method") {
		print "<center><h3>ERROR: That Search Won't Work!</h3></CENTER>\n";
		print "You can only compare <B>numbers</B> with \"greater than\" or \"less than\".\n";
   	}
   	else {
		print "<center><h3>ERROR: !</h3></CENTER>\n";
		print "$error\n";
   	}
	exit;
}

sub open_user{
	local ($usernumber) = $_[0];

	$fn = $GPath{'userpath'} . "/" . $usernumber . "\.usrdat";

	&lock("$usernumber");
	if(-e "$fn"){}                          # Checks for file's existence
		else {&USER_error(bad_user);}


	open(FILE, "$fn") || &diehtml("I can't open $fn\n");

	while(<FILE>) {
		chomp;
		@datafile = split(/\n/);

		foreach $line (@datafile) {
			$data .= $line;
		}
      
		($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}) = split(/&&/, $data);
		$hfn = $GPath{'userdirs'} . "/" . $filenum . "/visit.log";
		if (-e "$hfn") {
   			open(HITS,"$hfn") || &diehtml("can't open $hfn");
			@tfile = <HITS>;
 	  		close(HITS);
			chomp $tfile[0];
			chomp $tfile[1];
			$IUSER{'num_visits'} = $tfile[0];
			$IUSER{'last_update'} = $tfile[1];
			$IUSER{'IPs'} = $tfile[2];
		}
	}
	&unlock("$usernumber");
	close(FILE);
	
}

##############################################################################
#                    ______               __    _
#                   / ____/____   ____   / /__ (_)___   _____
#                  / /    / __ \ / __ \ / //_// // _ \ / ___/
#                 / /___ / /_/ // /_/ // ,<  / //  __/(__  )
#                 \____/ \____/ \____//_/|_|/_/ \___//____/
#
##############################################################################

   ## Sample code to set a cookie....
   ## Note: separate cookie values with a ":"
   #  $newcookie= "voted\~Yes:iscool\~No";
   #  print "Set-Cookie: COOKIENAME=$newcookie;";
   #  print " expires=", &Cookie_Date( time + 31536000 , 1 ), "; path=/\n";

   ## Sample code to get a cookie
   #  %bbscookie= &split_cookie( $ENV{ 'HTTP_COOKIE' }, 'COOKIENAME' );
   #  $bbscookie{'voted'} and $bbscookie{'cool'} are the values...

sub split_cookie
{
   # put cookie into array
   local( $incookie, $tag )= @_;
   local( %cookie );
   $tester= $incookie;
   local( @temp )= split( /; /, $incookie );
   foreach ( @temp )
   {
      ( $temp, $temp2 )= split( /=/ );
      $cookie{ $temp }= $temp2;
   }
   return &split_sub_cookie( $cookie{ $tag } );
}

sub split_sub_cookie
{
   local( $cookie )= @_;
   local( %newcookie );
   local( @temp )= split( /\|/, $cookie );
   foreach ( @temp )
   {
      ( $temp, $temp2 )= split( /~/ );
      $newcookie{ $temp }= $temp2;
   }
   return %newcookie;
}

sub join_cookie
{
   local( %set )= @_;
   local( $newcookie );
   foreach $key( keys %set )
   {
      $newcookie.= "$key\~$set{ $key }:";
   }
   return $newcookie;
}

sub Cookie_Date
{
   local( $time, $format )= @_;

   local( $sec, $min, $hour, $mday, $mon, $year,
          $wday, $yday, $isdst )= localtime( $time );

   $sec = "0$sec" if ($sec < 10);
   $min = "0$min" if ($min < 10);
   $hour = "0$hour" if ($hour < 10);
   $mon = "0$mon" if ($mon < 10);
   $mday = "0$mday" if ($mday < 10);
   local( $month )= ($mon + 1);
   local( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                       "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

   local( @weekday )=( "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun" );

   return "$weekday[$wday], $month-$mday-$year $hour\:$min\:$sec GMT";
}



1;
