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



require "cm/user.adv";


#  $USER_realname, $USER_username, $USER_email, $USER_password, $USER_url, $USER_urlname, 
#  $USER_handle, $USER_IPs, $IUSER{'creation_date'}, $USER_last_update, $USER_numvisits, 
#  $USER_Age, $USER_Sex, $IUSER{'user_level'}, $USER_favtype, $USER_warnings, $USER_icon, 
#  $USER_description, $USER_send_update, $USER_community, $USER_Phonenumber, $USER_Faxnumber, 
#  $USER_Address, $USER_State, $USER_Country, $USER_ZipCode, $USER_City, $USER_status, $USER_expiry_date
#  $USER_monthly_fee, $USER_admin_notes, $USER_history, $USER_BirthDay, $USER_BirthMonth, $USER_BirthYear
#  $USER_Filler1, $USER_Filler2, $USER_Filler3, $USER_Filler4, $USER_Filler5, $USER_Filler6, $USER_Filler7
#  $USER_Filler8, $USER_Filler9, $USER_Filler10, $USER_FirstName, $USER_Initial, $USER_LastName
#  $USER_Referer, $USER_Club, $USER_ICQ


sub verify_that_user_does_not_exist {
	my $UserName = $_[0];
	my $Email = $_[1];

	my ($match2, $match, %dusers, %demails) = (undef, undef, undef, undef);

	$UserName =~ /^(.)/;
	my $udb = $1;
	$Email =~ /^(.)/;
	my $edb = $1;
	$udb =~ tr/A-Z/a-z/;
	$edb =~ tr/A-Z/a-z/;
	my $userdatabase = "$GPath{'userpath'}/users_$udb.db";
	my $emaildatabase = "$GPath{'userpath'}/email_$edb.db";

	tie %dusers, "DB_File", $userdatabase;
	if ($dusers{$UserName} ne "") {$match = 1;}

	tie %demails, "DB_File", $emaildatabase;
	if ($demails{$Email} ne "") {$match2 = 1;}

	return $match, $match2;
}


sub add_user_to_db {
	my (%data, %edata);
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Email) = $_[3];

	$UserName =~ /^(.)/;
	my $udb = $1;
	$udb =~ tr/A-Z/a-z/;
	my $userdatabase = "$GPath{'userpath'}/users_$udb.db";

	$Email =~ /^(.)/;
	my $edb = $1;
	$edb =~ tr/A-Z/a-z/;
	my $emaildatabase = "$GPath{'userpath'}/email_$edb.db";

	&lock("users_$udb");
	tie %data, "DB_File", $userdatabase;
	$data{$UserName} = "$UserName&&$PassWord&&$FileNum&&$Email";
	untie %data; 
	&unlock("users_$udb");
  
	&lock("email_$edb");
	tie %edata, "DB_File", $emaildatabase;
	$edata{$Email} = "$UserName&&$PassWord&&$FileNum&&$Email";
	untie %edata;
	&unlock("email_$edb");

}


sub update_datafile {
	my (%udata, %oemails, %edata);

	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Email) = $_[3];
	my ($oldEmail) = $_[4];

	$UserName =~ /^(.)/;
	my $udb = $1;
	$udb =~ tr/A-Z/a-z/;

	$oldEmail =~ /^(.)/;
	my $oedb = $1;
	$oedb =~ tr/A-Z/a-z/;
	my $oemaildatabase = "$GPath{'userpath'}/email_$oedb.db";

	&lock("email_$oedb");
	tie %oedata, "DB_File", $oemaildatabase;
	delete $oedata{$oldEmail};
	untie %oedata;  
 	&unlock("email_$oedb");

	$Email =~ /^(.)/;
	my $edb = $1;
	$edb =~ tr/A-Z/a-z/;
	my $emaildatabase = "$GPath{'userpath'}/email_$edb.db";

	&lock("email_$edb");
	tie %edata, "DB_File", $emaildatabase;
	$edata{$Email} = "$UserName&&$PassWord&&$IUSER{'filenum'}&&$Email";
	untie %edata;   
	&unlock("email_$edb");

	$userdatabase = "$GPath{'userpath'}/users_$udb.db";
	&lock("users_$udb");
	tie %udata, "DB_File", $userdatabase;
	$udata{$UserName} = "$UserName&&$PassWord&&$IUSER{'filenum'}&&$Email";
	untie %udata;
	&unlock("users_$udb");
}



sub get_user_number {
	my (%rdata);

	my ($UserName) = $_[0];
	my (@r);

	$UserName =~ /^(.)/;
	my $udb = $1;
	$udb =~ tr/A-Z/a-z/;
	my $userdatabase = "$GPath{'userpath'}/users_$udb.db";

	tie %rdata, "DB_File", $userdatabase;
	my $line = $rdata{$UserName};

	if ($line ne "") {
		@r = split(/&&/, $line);
	}

	return $r[2], $r[3];
}


sub get_user_no_password {
	my ($UserName) = $_[0];
	my ($log) = $_[1];
	my ($suppress_error) = $_[2];

	my (%data);

	$UserName =~ /^(.)/;
	my $udb = $1;
	$udb =~ tr/A-Z/a-z/;
	my $userdatabase = "$GPath{'userpath'}/users_$udb.db";

	if ($COMMUNITY_case_sensitive ne "YES") {
		$UserName =~ lc($UserName);
	}

	tie %data, "DB_File", $userdatabase;
	my $line = $data{$UserName};
	my %IUSER = undef;

	if ($line ne "") {
		my ($loginname, $loginpassword, $userfile, $Emailver) = split(/&&/, $line);
		%IUSER = &open_user($userfile,$log);
		$IUSER{'filenum'} = $userfile;
	}

	else {
		if ($suppress_error ne "") {
			&USER_error('bad_user_name');
		}
	}
	return %IUSER;
}


sub get_user_by_email {
	my ($Email) = $_[0];
	my (%data);

	$Email =~ /^(.)/;
	my $edb = $1;
	$edb =~ tr/A-Z/a-z/;
	my $emaildatabase = "$GPath{'userpath'}/email_$edb.db";

	tie %data, "DB_File", $emaildatabase;
	my $line = $data{$Email};
	my %IUSER = undef;

	if ($line ne "") {
		my ($loginname, $loginpassword, $userfile, $Emailver) = split(/&&/, $line);
		%IUSER = &open_user($userfile);
		$IUSER{'filenum'} = $userfile;
	}
	elsif ($PROGRAM_NAME ne "community_admin.cgi") {
		&USER_error('bad_email_on_password');
	}

	return %IUSER;
}


sub search_users {
	my (%data);
	my ($match, $Found, %IUSER) = (undef, undef, undef);

	my ($UserName) = $_[0];
	my ($PassWord) = $_[1];
	my ($no_error) = $_[2];

	$UserName =~ /^(.)/;
	my $udb = $1;
	$udb =~ tr/A-Z/a-z/;
	my $userdatabase = "$GPath{'userpath'}/users_$udb.db";

	tie (%data, "DB_File", $userdatabase)|| &diehtml("$userdatabase $!");
	my $line = $data{$UserName};

	my %IUSER = undef;

	if ($line ne "") {
		my ($loginname, $loginpassword, $userfile, $Emailver) = split(/&&/, $line);
		if ($loginpassword eq $PassWord) {
			$match = 1;
			%IUSER = &open_user($userfile);
			$IUSER{'filenum'} = $userfile;
			$realusername = $loginname;
			$Found = "T";
		}
	}
	if (! $match) {
		if ($no_error eq "T") {}
		else {
			&log_failed_login($UserName,$PassWord);
			if ($no_error ne "T") {
				&USER_error("bad_password",$UserName,$PassWord);
			}
		}
	}
	return %IUSER;
}

sub delete_member2 {
	my (%data, %edata);

	my ($UserName) = $_[0];

	$UserName =~ /^(.)/;
	my $udb = $1;
	$udb =~ tr/A-Z/a-z/;
	my $userdatabase = "$GPath{'userpath'}/users_$udb.db";

	&lock("users_$udb");

	tie %data, "DB_File", $userdatabase;
	my $line = $data{$UserName};
	my ($loginname, $loginpassword, $userfile, $Emailver) = split(/&&/, $line);
	if ($line = "") {
		&ADMIN_error("bad_username",$UserName,$PassWord);
	}
	delete $data{$UserName}; 
	untie %data;  

	&unlock("users_$udb");


	$Emailver =~ /^(.)/;
	my $edb = $1;
	$edb =~ tr/A-Z/a-z/;
	my $emaildatabase = "$GPath{'userpath'}/email_$edb.db";
	
	chomp $Emailver;

	&lock("email_$edb");
	tie %edata, "DB_File", $emaildatabase;
	delete $edata{$Emailver};
	untie %edata;
	unlock("email_$edb");

	&delete_files($userfile);
	&a_cancel_membership(\%IUSER);
}



sub get_number {
	my $filenum = time . "," . $$;
	return $filenum;
}



sub create_user {
	my %IUSER = undef;
	$IUSER{'realname'} = $_[0];
	$IUSER{'username'} = $_[1];
	$IUSER{'password'} = $_[2];
	$IUSER{'email'} = $_[3];
	$IUSER{'Age'} = $_[4];
	$IUSER{'Sex'} = $_[5];
	$IUSER{'Phonenumber'} = $_[6];
	$IUSER{'Faxnumber'} = $_[7];
	$IUSER{'Address'} = $_[8];
	$IUSER{'City'} = $_[9];
	$IUSER{'State'} = $_[10];
	$IUSER{'Country'} = $_[11];
	$IUSER{'ZipCode'} = $_[12];

	$IUSER{'status'} = $_[13];
	$IUSER{'expiry_date'} = $_[14];
	$IUSER{'monthly_fee'} = $_[15];
	$IUSER{'admin_notes'} = $_[16];
	$IUSER{'history'} = $_[17];
	$IUSER{'BirthDay'} = $_[18];
	$IUSER{'BirthMonth'} = $_[19];
	$IUSER{'BirthYear'} = $_[20];

	$IUSER{'Filler1'} = $_[21];
	$IUSER{'Filler2'} = $_[22];
	$IUSER{'Filler3'} = $_[23];
	$IUSER{'Filler4'} = $_[24];
	$IUSER{'Filler5'} = $_[25];
	$IUSER{'Filler6'} = $_[26];
	$IUSER{'Filler7'} = $_[27];
	$IUSER{'Filler8'} = $_[28];
	$IUSER{'Filler9'} = $_[29];
	$IUSER{'Filler10'} = $_[30];

	$IUSER{'FirstName'} = $_[31];
	$IUSER{'Initial'} = $_[32];
	$IUSER{'LastName'} = $_[33];
	$IUSER{'Referer'} = $_[34];
	$IUSER{'ICQ'} = $_[35];

	$IUSER{'status'} = $_[36];
	$IUSER{'monthly_fee'} = $_[37];
	$IUSER{'Marital_Status'} = $_[38];
	$IUSER{'Children'} = $_[39];
	$IUSER{'Income'} = $_[40];
	$IUSER{'Primary_Computer_Use'} = $_[41];
	$IUSER{'Education'} = $_[42];
	$IUSER{'Employment'} = $_[43];


	$IUSER{'creation_date'} = time;
	$IUSER{'user_level'} = $CONFIG{'COMMUNITY_Default_User_Level'};

	$IUSER{'filenum'} = &get_number();

	&lock("$IUSER{'filenum'}");

	&write_user($IUSER{'filenum'},$IUSER{'username'},$IUSER{'password'},\%IUSER);
	&unlock("$IUSER{'filenum'}");

	&add_user_to_db($IUSER{'filenum'},$IUSER{'username'},$IUSER{'password'},$IUSER{'email'});

	&a_create_user(\%IUSER);

	return %IUSER;
}


sub write_user {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($luser) = $_[3];

	if ($CONFIG{'COMMUNITY_keep_history'} ne "YES") {
		$$luser{'history'} = undef;
	}

	$$luser{'last_update'} = time;
	$$luser{'num_visits'}++;


	my $fn = $GPath{'userpath'} . "/" . $FileNum . ".usrdat";
	$LOGGING .= "$$luser{'realname'}&&$$luser{'username'}&&$$luser{'email'}&&$$luser{'password'}&&$$luser{'url'}&&$$luser{'urlname'}\n<P>\n";

	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$$luser{'realname'}&&$$luser{'username'}&&$$luser{'email'}&&$$luser{'password'}&&$$luser{'url'}&&$$luser{'urlname'}&&$$luser{'handle'}&&$$luser{'IPs'}&&$$luser{'creation_date'}&&$$luser{'last_update'}&&$$luser{'num_visits'}&&$$luser{'Age'}&&$$luser{'Sex'}&&$$luser{'user_level'}&&$$luser{'favetypes'}&&$$luser{'warnings'}&&$$luser{'icon'}&&$$luser{'description'}&&$$luser{'send_update'}&&$$luser{'community'}&&$$luser{'Phonenumber'}&&$$luser{'Faxnumber'}&&$$luser{'Address'}&&$$luser{'State'}&&$$luser{'Country'}&&$$luser{'ZipCode'}&&$$luser{'City'}&&$$luser{'status'}&&$$luser{'expiry_date'}&&$$luser{'monthly_fee'}&&$$luser{'admin_notes'}&&$$luser{'history'}&&$$luser{'BirthDay'}&&$$luser{'BirthMonth'}&&$$luser{'BirthYear'}&&$$luser{'Filler1'}&&$$luser{'Filler2'}&&$$luser{'Filler3'}&&$$luser{'Filler4'}&&$$luser{'Filler5'}&&$$luser{'Filler6'}&&$$luser{'Filler7'}&&$$luser{'Filler8'}&&$$luser{'Filler9'}&&$$luser{'Filler10'}&&$$luser{'FirstName'}&&$$luser{'Initial'}&&$$luser{'LastName'}&&$$luser{'Referer'}&&$$luser{'Club'}&&$$luser{'ICQ'}&&$$luser{'Children'}&&$$luser{'Income'}&&$$luser{'Primary_Computer_Use'}&&$$luser{'Education'}&&$$luser{'Employment'}\n";
	close(FILE);

	my $fn = $GPath{'userdirs'} . "/" . $FileNum;
	if (! (-e "$fn")) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn = $!");
	}
}



sub validate_session_no_error {
	my $VALIDUSER = "F";
	%Cookies = &get_member_cookie();
	my $IUSER = undef;
	if ($Cookies{'UserName'} ne "") {
		%IUSER = &get_user_4_forums($Cookies{'UserName'},$Cookies{'PassWord'},"T");
		if ($IUSER{'username'} ne "") {
			$VALIDUSER = "T";
		}
	}

	return $VALIDUSER, %IUSER;
}


sub validate_session {
	my $VALID = "F";
	%Cookies = &get_member_cookie();
	my $IUSER = undef;
	if ($Cookies{'UserName'} ne "") {
		%IUSER = &get_user_4_forums($Cookies{'UserName'},$Cookies{'PassWord'},"T");
		if ($IUSER{'username'} ne "") {
			$VALID = "T";
		}
	}

	if ($VALID ne "T") {
		&USER_error('session_expired');
	}
	return $VALID, %IUSER;
}


sub get_user_autologin {
	my ($UserName) = $_[0];
	my ($PassWord) = $_[1];

	my %IUSER = &search_users($UserName, $PassWord);

	return %IUSER;
}

sub get_user_4_forums {
	my ($UserName) = $_[0];
	my ($PassWord) = $_[1];
	my ($no_error) = $_[2];

	if ($CONFIG{'COMMUNITY_case_sensitive'} ne "YES") {
		$UserName =~ tr/A-Z/a-z/;
		$PassWord =~ tr/A-Z/a-z/;
	}

	my %IUSER = &search_users($UserName, $PassWord, $no_error);

	return %IUSER;
}

sub get_user {
	my ($UserName) = $_[0];
	my ($PassWord) = $_[1];

	if ($CONFIG{'COMMUNITY_case_sensitive'} ne "YES") {
		$UserName =~ tr/A-Z/a-z/;
		$PassWord =~ tr/A-Z/a-z/;
	}

	my %IUSER = &search_users($UserName, $PassWord);

	return %IUSER;
}

sub log_failed_login {
	my $UserName = $_[0];
	my $PassWord = $_[0];

	my $fn = $CONFIG{'data_dir'} . "/community/failed.txt";

	if (($UserName ne "") && ($PassWord ne "")) {
		&lock("failed");
		open(FILE, ">>$fn") || &diehtml("I can't write to $fn\n");
		my $failed_time = time;
		print FILE "$failed_time\|\|$ENV{'REMOTE_ADDR'}\|\|$UserName\|\|$PassWord\|\|$PROGRAM_NAME\n";
		close(FILE);
		&unlock("failed");
	}
}


sub open_user {
	my ($usernumber) = $_[0];
	my ($logaccess) = $_[1];

	if ($CONFIG{'COMMUNITY_ban_users'} eq "YES") {
		my $fn = "$GPath{'community_data'}/banned_hosts.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
 			my @HOSTS = <FILE>;
		close(FILE);

		foreach my $bannedhost (@HOSTS) {
			if (($ENV{'REMOTE_ADDR'} eq $bannedhost) || ($bannedhost eq $ENV{'REMOTE_ADDR'})) {
				&USER_error('banned user');
			}
		}
	}

	my $fn = $GPath{'userpath'} . "/" . $usernumber . "\.usrdat";

	&lock("$usernumber");
	if(-e "$fn"){}                          # Checks for file's existence
	else {&USER_error("bad_user un: $usernumber");}


	open(FILE, "$fn") || &diehtml("I can't open $fn\n");
	my $data = undef;
	while(<FILE>) {
		chomp;
		@datafile = split(/\n/);

		foreach my $line (@datafile) {
			$data .= $line;
		}
      }
	
	my %IUSER = undef;
	($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}, $IUSER{'Club'}, $IUSER{'ICQ'}, $IUSER{'Children'}, $IUSER{'Income'}, $IUSER{'Primary_Computer_Use'}, $IUSER{'Education'}, $IUSER{'Employment'}) = split(/&&/, $data);
	&unlock("$usernumber");
	close(FILE);
	$IUSER{'filenum'} = $usernumber;
	if ($CONFIG{'COMMUNITY_ban_users'} eq "YES") {
		my $fn = "$GPath{'community_data'}/banned_emails.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
		my @EMAILS = <FILE>;
		close(FILE);

		foreach my $bannedemail (@EMAILS) {
			if (($IUSER{'email'} =~ /$bannedemail/i) || ($bannedemail =~ /$IUSER{'email'}/i)) {
				&USER_error('banned user');
			}
		}
	}

	if (($IUSER{'status'} eq "hold") && ($COMMUNITY_Allow_Access_Prior_To_Approval ne "YES")) {
		&USER_error('on_hold');
	}
	require "$GPath{'community_data'}/levels.pm";

	&get_priveledges($IUSER{'user_level'});
	if ($logaccess eq "") {
		($IUSER{'num_visits'}, $IUSER{'last_update'}, $IUSER{'IPs'}) = &log_access($IUSER{'filenum'},$IUSER{'username'},$IUSER{'password'});
	}
	else {
		($IUSER{'num_visits'}, $IUSER{'last_update'}, $IUSER{'IPs'}) = &get_access_info($IUSER{'filenum'},$IUSER{'username'},$IUSER{'password'});
	}
	$IUSER{'USER_directory'} = $GPath{'userdirs'} . "/" . $IUSER{'filenum'};

	if ($IUSER{'Initial'}) {
		$IUSER{'realname'} = "$IUSER{'FirstName'} $IUSER{'Initial'} $IUSER{'LastName'}";
	}
	else {
		$IUSER{'realname'} = "$IUSER{'FirstName'} $IUSER{'LastName'}";
	}
	return %IUSER;
}


sub get_access_info {
	my ($filenum) = $_[0];
	my ($hfn, $fn, $file);

	my $hfn = $GPath{'userdirs'} . "/" . $filenum . "/visit.log";
	if (-e "$hfn") {
	   	open(HITS,"$hfn") || &diehtml("can't open $hfn");
   		@file = <HITS>;
 	  	close(HITS);
		chomp $file[0];
		chomp $file[1];
   	}

	my $last_update = $file[1];
	my $num_visits = $file[0];

	return $num_visits, $last_update, $IPs;
}



sub log_access {
	my ($filenum) = $_[0];
	my ($hfn, $fn, $file);

	&lock("$filenum");

	my $mask = umask(0);
	my $fn = $GPath{'userdirs'} . "/" . $filenum;
	if (! (-e "$fn")) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
	}
	umask($mask);	
	my $hfn = $GPath{'userdirs'} . "/" . $filenum . "/visit.log";
	if (-e "$hfn") {
	   	open(HITS,"$hfn") || &diehtml("can't open $hfn");
   		@file = <HITS>;
 	  	close(HITS);
		chomp $file[0];
		chomp $file[1];
		$file[0]++;
   	}

	$file[1] = time;
	my $IPs = $file[2];
	my $num_of_ips;

	if  ($PROGRAM_NAME ne "update_profile.cgi") {
		if ($CONFIG{'COMMUNITY_log_ips'} eq "YES") {
			my (@IPs) = split (/\|\|/, $IUSER{'IPs'});
			foreach my $IP (@IPs) {
				if ($IP == $ENV{'REMOTE_ADDR'}) {
					my $already_there = "TRUE";
				}
				$num_of_ips++;
			}
			if ($already_there ne "TRUE") {
				push(@IPs,$ENV{'REMOTE_ADDR'});
			}
			if ($num_of_ips > $CONFIG{'COMMUNITY_max_ips'}) {
				shift(@IPs);
			}
		}
		$IUSER{'IPs'} = "";
		foreach $IP(@IPs) {
			$IPs .= $IP . "\|\|";
		}
	}

   	open(HITS,">$hfn") || &diehtml("can't write $hfn");
   	print HITS "$file[0]\n$file[1]\n$IUSER{'IPs'}";
   	close(HITS);

	my $mask = umask(0);
	chmod(0777,$hfn);
	umask($mask);	

	&unlock("$filenum");

	my $last_update = $file[1];
	my $num_visits = $file[0];

	return $num_visits, $last_update, $IPs;
}



####################################
# Email Password to User who Forgot

sub email_password {
	my $UserName = $_[0];
	my $Email = $_[1];

	my %IUSER = undef;
	if ($UserName ne "") {
		%IUSER = &get_user_no_password($UserName);
	}
	elsif ($Email ne "") {
		$Email =~ tr/A-Z/a-z/;
		%IUSER = &get_user_by_email($Email);
	}
	else {
		&USER_error("no_user_or_email",$UserName,$Email);
	}

	my $fn = "$GPath{'community_data'}/password_email.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		my @EMAIL = <FILE>;
	close(FILE);

	open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
	  print MAIL "To: $IUSER{'email'}\n";
	  print MAIL "From: $CONFIG{'email'}\n";
	  print MAIL "Subject: $CONFIG{'Lost_Password_Message_Subject'}\n";

	  foreach my $line (@EMAIL) {
		$line =~ s/\[USERNAME\]/$IUSER{'username'}/g;
		$line =~ s/\[FIRSTNAME\]/$IUSER{'FirstName'}/g;
		$line =~ s/\[LASTNAME\]/$IUSER{'LastName'}/g;
		$line =~ s/\[PASSWORD\]/$IUSER{'password'}/g;
		print MAIL "$line";
	  }
	  print MAIL "\n\n\n";
	close(MAIL);


	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Your Password Has Been Sent</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";

	$BODY .= "<P><B>Your password has been sent to you at $IUSER{'email'}.  It should arrive shortly!</B>\n";

	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');  
}	


sub print_icon {
	my (%Cookies) = &get_member_cookie();
	if ($Cookies{'Icon'}) {$BODY .= "<IMG SRC=\"$GUrl{'icon_images'}/$Cookies{'Icon'}.gif\">";}
	else {$BODY .= "<BR>";}
}
	

sub set_member_cookie {
	print "Content-type: text/html\n"; 
	&basic_cookie();	
	print "\n";
	# end of cookie
}

sub kill_cookie {
	print "Content-type: text/html\n"; 
	&SetCompressedCookies('user','UserName',"",'PassWord',"",'Icon',"",'Id',"",'Time',"");
	print "\n";
}

sub basic_cookie {
	my $rn = time;
	my @keys = unpack('C*', $CONFIG{'passwordkey'});
	my @o = unpack('C*', $FORM{'PassWord'});
	my $pw = undef;

	my $x = 0;
	foreach my $l (@o) {
		$pw .= ($l + $keys[$x++]);
		$pw .= "|";
	}
#	$BODY .= "password: $pw<P>\n";
	&SetCompressedCookies('user','UserName',$FORM{'UserName'},'PassWord',$pw,'Icon',$IUSER{'icon'},'Id',$IUSER{'filenum'},'Time',$rn);
}


sub get_member_cookie {
   	my (%Cookies) = &GetCompressedCookies('user','UserName','PassWord','Icon','Id','Time');
	my $dif = $CONFIG{'COMMUNITY_expire_cookie'} * 60 * 60;
	my $cutoff = time - $dif;

	my @keys = unpack('C*', $CONFIG{'passwordkey'});

	my @o = split(/\|/, $Cookies{'PassWord'});

	my $x = 0;
	$Cookies{'PassWord'} = undef;
	foreach my $l (@o) {
		$l = $l - $keys[$x++];
		$Cookies{'PassWord'} .= pack('C*', $l);
	}

	if ($Cookies{'Time'} < $cutoff) {
		$Cookies{'PassWord'} = undef;
	}
	return (%Cookies);
}

sub basic_login_form {
	my $ref = $_[0];
   	$BODY .= "UserName:<BR> <input type=text name=\"UserName\" VALUE=\"$$ref{'UserName'}\" size=20><br>\n";
   	$BODY .= "<BR>PassWord:<BR>  <input type=password name=\"PassWord\" VALUE=\"$$ref{'PassWord'}\" size=20><br>\n";
}


sub login_form {
	my ($ButtonText) = $_[0];
	if ($ButtonText eq "") {$ButtonText = "login";}
	my (%Cookies) = &get_member_cookie();

	&basic_login_form(\%Cookies);
   	$BODY .= "<CENTER><INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"$ButtonText\"></CENTER>\n";
}




sub delete_files {
	my ($UserNum) = $_[0];

	&lock("users");
	&lock("$UserNum");

	my $fn = $GPath{'userpath'} . "/" . $UserNum . "\.usrdat";

	my $data = undef;
	open(FILE, "$fn") || &diehtml("I can't open $fn\n");
	while(<FILE>) {
		chomp;
		my @datafile = split(/\n/);

		foreach my $line (@datafile) {
			$data .= $line;
           	}
     	}
	my %IUSER = undef;
	($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}, $IUSER{'Club'}, $IUSER{'ICQ'}) = split(/&&/, $data);
	&lock("$IUSER{'username'}");

	if ($CONFIG{'useSubCommunities'} eq "YES") {
		$CW_base = $CONFIG{'PAGEMASTER_base'} . "/" . $IUSER{'community'};
		$CW_base_html = $CONFIG{'PAGEMASTER_community_html'} . "/" . $IUSER{'community'};
	}
	else {
		$CW_base = $CONFIG{'PAGEMASTER_base'};
		$CW_base_html = $CONFIG{'PAGEMASTER_community_html'};
	}

	close(FILE);

	unlink ($fn) || &diehtml("I can't delete $fn\n");

	my $UserName = $IUSER{'username'};

	my $hfn = $GPath{'userdirs'} . "/" . $UserNum . "/";
	if (-d "$hfn") {
		opendir(FILES, "$hfn") || &diehtml("Can't open directory $hfn");
    		while($file = readdir(FILES)) {
			my $fn = $hfn . $file;
			unlink ($fn);
		}
		rmdir("$GPath{'userdirs'}/$UserNum") || &diehtml("I can't delete $hfn $!\n");
	}


	if ($CONFIG{'COMMUNITY_keep_self_deletions'} eq "YES") {
		my $fn = $GPath{'userpath'} . "/cancelled/" . $UserNum . "\.usrdat";
		open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
		print FILE "$data";
		close(FILE);
		chmod 0777, "$fn";
	}

	if ($CONFIG{'useSubCommunities'} eq "YES") {
		if ($IUSER{'community'} ne "") {
			if ((-e "$CW_base/$UserName/") && ($IUSER{'community'} ne $UserName) && ($IUSER{'community'} =~ /\w/) && ($UserName =~ /\w/) && ($UserName !~ /(\/|\.\.|\*)/)) {
				system("rm -rf $CW_base/$UserName/");  # don't try this at home
			}
		}
	}
	else {
		if ((-e "$CW_base/$UserName/") && ($UserName =~ /\w/) && ($UserName !~ /(\/|\.\.)/)) {
			system("rm -rf $CW_base/$UserName/");  # don't try this at home
		}
	}

	&unlock("users");
	&unlock("$IUSER{'username'}");
	&unlock("$UserNum");
}




########################################
# Error Messages

sub USER_error {
	$error = $_[0];
	$UserName = $_[1];
	$Email = $_[2];

	my $fn = "$GPath{'community_data'}/banned_message.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
	my @MESSAGE = <FILE>;
	close(FILE);
	
	foreach my $line (@MESSAGE) {
		$BANNEDMESSAGE .= $line;
	}

	if ($error eq 'bad_password') {
		%Cookies = &get_member_cookie();
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/badpassworderror.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/badpassworderror.tmplt";
	}
	elsif ($error eq 'session_expired') {
		&build_login_form;
		&print_output('login');
	}
	else {
		%Cookies = &get_member_cookie();
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";
	}
	
	&print_output('error');  
}


1;