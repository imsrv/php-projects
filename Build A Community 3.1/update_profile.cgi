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
$| = 1;
use DB_File;

use File::Copy;
$userpm = "T";
require "./common.pm";
require "./cm/user_changes.pm";

$PROGRAM_NAME = "update_profile.cgi";

&Validate_Admin_Local;


#if ($yh_domains ne "") { if( &Invalid_IP($yh_domains) ) { print "Location: $CONFIG{'COMMUNITY_noip'}\n\n"; } }
&parse_FORM;

&make_variables;



if ($FORM{'action'} eq "Delete Applicant") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
  	print "Content-type: text/html\n\n";
	&delete_member2($FORM{'User2Delete'});

	if ($FORM{'rejection_email'} ne "NONE") {
		if ($FORM{'rejection_email'} ne "Custom") {
			&send_acceptance_email($FORM{'rejection_email'},$FORM{'CUSTOM'});
		}
		else {
			&send_acceptance_email($FORM{'rejection_email'},"",$FORM{'CUSTOM'});
		}
	}


	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#cccc99><B>Database Updated</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "<B>This Member may still appear in searches until you update the database.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



if (($FORM{'action'} eq "delete_member") || ($FORM{'action'} eq "Delete Member")) {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
  	print "Content-type: text/html\n\n";
	&delete_member2($FORM{'User2Delete'});
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#cccc99><B>Database Updated</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "<B>This Member may still appear in searches until you update the database.</B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


if (($FORM{'action'} eq "Update Profile") || ($FORM{'action'} eq "Change User Group")) {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&get_user_information($FORM{'UserNum'});
	&update_profile;
	&return_a_response;
	exit;
}





if ($FORM{'action'} eq "Activate User"){
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&get_user_information($FORM{'UserNum'});
	$FORM{'USER_status'} = "active";
	&update_profile;
	if ($FORM{'acceptance_email'} ne "NONE") {
		if ($FORM{'acceptance_email'} eq "Add2Custom") {
			&send_acceptance_email("acceptance_email",$FORM{'CUSTOM'});
		}
		if ($FORM{'acceptance_email'} eq "Custom") {
			&send_acceptance_email("acceptance_email","",$FORM{'CUSTOM'});
		}
		else {
			&send_acceptance_email("acceptance_email");
		}
	}
	&return_a_response_sent;
	exit;
}

if ($FORM{'action'} eq ""){
  	print "Content-type: text/html\n\n";
	print "<H2>BuildACommunity.cgi</H2>\n";
	print "No action specified\n";
	exit;
}


sub send_acceptance_email {
	local ($filename) = $_[0];
	local ($append) = $_[1];
	local ($custom) = $_[2];


	if ($filename ne "Custom") {
		$fn = "$GPath{'community_data'}/$filename.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
 			@EMAIL = <FILE>;
		close(FILE);
	}

	open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
	  print MAIL "To: $IUSER{'email'}\n";
	  print MAIL "From: $CONFIG{'email'}\n";
	  if ($filename eq "acceptance_email") {
		  print MAIL "Subject: $CONFIG{'Acceptance_Message_Subject'}\n";
	  }
	  else {
		  print MAIL "Subject: Registration Information\n";
	  }

	  if ($custom eq "") {
		  if ($append ne "") {print MAIL "$append\n\n";}

		  foreach $line(@EMAIL) {
			$line =~ s/\[USERNAME\]/$IUSER{'username'}/g;
			$line =~ s/\[FIRSTNAME\]/$IUSER{'FirstName'}/g;
			$line =~ s/\[LASTNAME\]/$IUSER{'LastName'}/g;
			$line =~ s/\[PASSWORD\]/$IUSER{'password'}/g;
			print MAIL "$line";
		  }
	  }
	  else {
		  print MAIL "$custom\n";
	  }
	  print MAIL "\n\n\n";
	close(MAIL);
}


sub return_a_response_sent {
  	print "Content-type: text/html\n\n";
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#cccc99><B>Database Updated</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";

	print "Member file saved and activated.\n";
	if ($FORM{'letter2send'} ne "NONE") {
		print "<P>Acceptance letter sent.\n";
	}
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
}

sub return_a_response {
  	print "Content-type: text/html\n\n";
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#cccc99><B>Database Updated</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "Member File ($fn) Saved.\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
}


sub get_user_information {
	local ($UserNum) = $_[0];
	$fn = $GPath{'userpath'} . "/" . $UserNum . "\.usrdat";

	if(-e "$fn"){}                          # Checks for file's existence
		else {&USER_error(bad_user);}


	open(FILE, "$fn") || &diehtml("I can't open $fn\n");

	while(<FILE>) {
		chomp;
		@datafile = split(/\n/);

		foreach $line (@datafile) {
			$data .= $line;
            	}
      	}
	($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}, $IUSER{'Club'}, $IUSER{'ICQ'}, $IUSER{'Children'}, $IUSER{'Income'}, $IUSER{'Primary_Computer_Use'}, $IUSER{'Education'}, $IUSER{'Employment'}) = split(/&&/, $data);

	close(FILE);
}



sub update_profile {
	$IUSER{'filenum'} = $FORM{'UserNum'};

	if (($FORM{'USER_FirstName'} ne "") && ($FORM{'USER_LastName'} ne "")) {
		if ($FORM{'USER_Initial'} ne "") {
			$FORM{'RealName'} = $FORM{'USER_FirstName'} . " " . $FORM{'USER_Initial'} . " " . $FORM{'USER_LastName'};
		}
		else {
			$FORM{'RealName'} = $FORM{'USER_FirstName'} . " " . $FORM{'USER_LastName'};
		}
	}

	&change_date($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$date,\%IUSER);

	#############
	if (($IUSER{'status'} ne $FORM{'USER_status'}) && ($FORM{'USER_status'})) {
		&change_status($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_status'},\%IUSER);
	}
	if (($IUSER{'user_level'} ne $FORM{'USER_user_level'}) && (defined $FORM{'USER_user_level'})) {
		&change_user_level($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_user_level'},\%IUSER);
	}
	##############

	if (($IUSER{'realname'} ne $FORM{'RealName'}) && ($FORM{'RealName'})) {
		&change_realname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'RealName'},\%IUSER);
	}
	if (($IUSER{'email'} ne $FORM{'Email'}) && ($FORM{'Email'})) {
		&change_email($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'NewPassWord'},$FORM{'Email'},\%IUSER);
		&update_datafile($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'NewPassWord'},$FORM{'Email'},$IUSER{'email'},\%IUSER);
	}
	if (($IUSER{'password'} ne $FORM{'NewPassWord'}) && ($FORM{'NewPassWord'})) {
		&change_password($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'NewPassWord'},\%IUSER);
		&update_datafile($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'NewPassWord'},$FORM{'Email'},\%IUSER); 
		$password_changed = 1;
	}
	if (($IUSER{'url'} ne $FORM{'URL'}) && ($FORM{'URL'})) {
		&change_url($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'URL'},\%IUSER);
	}
	if (($IUSER{'urlname'} ne $FORM{'URLNAME'}) && ($FORM{'URLNAME'})) {
		&change_urlname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'URLNAME'},\%IUSER);
	}

	if (($IUSER{'handle'} ne $FORM{'HANDLE'}) && ($FORM{'HANDLE'})) {
		&change_handle($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'HANDLE'},\%IUSER);
	}
	if (($IUSER{'favetypes'} ne $FORM{'FavType'}) && ($FORM{'FavType'})) {
		&change_favtype($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'FavType'},\%IUSER);
	}
	if (($USER_wherelive ne $FORM{'WhereLive'}) && ($FORM{'WhereLive'})) {
		&change_wherelive($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'WhereLive'},\%IUSER);
	}
	if (($IUSER{'warnings'} ne $FORM{'Warnings'}) && ($FORM{'Warnings'})) {
		&change_warnings($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'Warnings'},\%IUSER);
	}
	if (($IUSER{'description'} ne $FORM{'Description'}) && ($FORM{'Description'})) {
		&change_description($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'Description'},\%IUSER);
	}
	if (($IUSER{'BirthDay'} ne $FORM{'USER_BirthDay'}) && ($FORM{'USER_BirthDay'})) {
		&change_birthday($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_BirthDay'},\%IUSER);
	}
	if (($IUSER{'BirthMonth'} ne $FORM{'USER_BirthMonth'}) && ($FORM{'USER_BirthMonth'})) {
		&change_birthmonth($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_BirthMonth'},\%IUSER);
	}
	if (($IUSER{'BirthYear'} ne $FORM{'USER_BirthYear'}) && ($FORM{'USER_BirthYear'})) {
		&change_birthyear($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_BirthYear'},\%IUSER);
	}
	if (($IUSER{'FirstName'} ne $FORM{'USER_FirstName'}) && ($FORM{'USER_FirstName'})) {
		&change_firstname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_FirstName'},\%IUSER);
	}
	if (($IUSER{'Initial'} ne $FORM{'USER_Initial'}) && ($FORM{'USER_Initial'})) {
		&change_initial($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Initial'},\%IUSER);
	}
	if (($IUSER{'LastName'} ne $FORM{'USER_LastName'}) && ($FORM{'USER_LastName'})) {
		&change_lastname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_LastName'},\%IUSER);
	}
	if (($IUSER{'Age'} ne $FORM{'USER_Age'}) && ($FORM{'USER_Age'})) {
		&change_age($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Age'},\%IUSER);
	}
	if (($IUSER{'Sex'} ne $FORM{'USER_Sex'}) && ($FORM{'USER_Sex'})) {
		&change_sex($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Sex'},\%IUSER);
	}
	if (($IUSER{'Phonenumber'} ne $FORM{'USER_Phonenumber'}) && ($FORM{'USER_Phonenumber'})) {
		&change_phonenumber($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Phonenumber'},\%IUSER);
	}
	if (($IUSER{'Faxnumber'} ne $FORM{'USER_Faxnumber'}) && ($FORM{'USER_Faxnumber'})) {
		&change_faxnumber($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Faxnumber'},\%IUSER);
	}
	if (($IUSER{'Address'} ne $FORM{'USER_Address'}) && ($FORM{'USER_Address'})) {
		&change_address($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Address'},\%IUSER);
	}
	if (($IUSER{'City'} ne $FORM{'USER_City'}) && ($FORM{'USER_City'})) {
		&change_city($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_City'},\%IUSER);
	}
	if (($IUSER{'State'} ne $FORM{'USER_State'}) && ($FORM{'USER_State'})) {
		&change_state($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_State'},\%IUSER);
	}
	if (($IUSER{'Country'} ne $FORM{'USER_Country'}) && ($FORM{'USER_Country'})) {
		&change_country($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Country'},\%IUSER);
	}
	if (($IUSER{'ZipCode'} ne $FORM{'USER_ZipCode'}) && ($FORM{'USER_ZipCode'})) {
		&change_zipcode($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_ZipCode'},\%IUSER);
	}
	if (($IUSER{'Filler1'} ne $FORM{'USER_Filler1'}) && ($FORM{'USER_Filler1'})) {
		&change_Filler1($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler1'},\%IUSER);
	}
	if (($IUSER{'Filler2'} ne $FORM{'USER_Filler2'}) && ($FORM{'USER_Filler2'})) {
		&change_Filler2($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler2'},\%IUSER);
	}
	if (($IUSER{'Filler3'} ne $FORM{'USER_Filler3'}) && ($FORM{'USER_Filler3'})) {
		&change_Filler3($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler3'},\%IUSER);
	}
	if (($IUSER{'Filler4'} ne $FORM{'USER_Filler4'}) && ($FORM{'USER_Filler4'})) {
		&change_Filler4($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler4'},\%IUSER);
	}
	if (($IUSER{'Filler5'} ne $FORM{'USER_Filler5'}) && ($FORM{'USER_Filler5'})) {
		&change_Filler5($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler5'},\%IUSER);
	}
	if (($IUSER{'Filler6'} ne $FORM{'USER_Filler6'}) && ($FORM{'USER_Filler6'})) {
		&change_Filler6($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler6'},\%IUSER);
	}
	if (($IUSER{'Filler7'} ne $FORM{'USER_Filler7'}) && ($FORM{'USER_Filler7'})) {
		&change_Filler7($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler7'},\%IUSER);
	}
	if (($IUSER{'Filler8'} ne $FORM{'USER_Filler8'}) && ($FORM{'USER_Filler8'})) {
		&change_Filler8($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler8'},\%IUSER);
	}
	if (($IUSER{'Filler9'} ne $FORM{'USER_Filler9'}) && ($FORM{'USER_Filler9'})) {
		&change_Filler9($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler9'},\%IUSER);
	}
	if (($IUSER{'Filler10'} ne $FORM{'USER_Filler10'}) && ($FORM{'USER_Filler10'})) {
		&change_Filler10($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler10'},\%IUSER);
	}
	if (($IUSER{'Children'} ne $FORM{'USER_Children'}) && ($FORM{'USER_Children'})) {
		$LOGGING .= "change_Children\n";
		&change_Children($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Children'},\%IUSER);
	}
	if (($IUSER{'Income'} ne $FORM{'USER_Income'}) && ($FORM{'USER_Income'})) {
		$LOGGING .= "change_Income\n";
		&change_Income($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Income'},\%IUSER);
	}
	if (($IUSER{'Primary_Computer_Use'} ne $FORM{'USER_Primary_Computer_Use'}) && ($FORM{'USER_Primary_Computer_Use'})) {
		$LOGGING .= "change_Primary_Computer_Use\n";
		&change_Children($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Primary_Computer_Use'},\%IUSER);
	}
	if (($IUSER{'Education'} ne $FORM{'USER_Education'}) && ($FORM{'USER_Education'})) {
		$LOGGING .= "change_Education\n";
		&change_Education($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Education'},\%IUSER);
	}
	if (($IUSER{'Employment'} ne $FORM{'USER_Employment'}) && ($FORM{'USER_Employment'})) {
		$LOGGING .= "change_Employment\n";
		&change_Employment($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Employment'},\%IUSER);
	}
	if (($IUSER{'ICQ'} ne $FORM{'USER_ICQ'}) && ($FORM{'USER_ICQ'})) {
		$LOGGING .= "change_icq\n";
		&change_ICQ($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_ICQ'},\%IUSER);
	}
	$UserName = $FORM{'UserName'};

	if (($IUSER{'community'} ne $FORM{'USER_community'}) && ($FORM{'USER_community'})) {
		$old_dir = $CONFIG{'PAGEMASTER_base'} . "/" . $IUSER{'community'} . "/" . $UserName;
		&change_community($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_community'});
		&update_webpage;
		&delete_old_webpage;
	}

}

sub update_webpage {
	&get_user_information($FORM{'UserNum'});
	&get_priveledges;
	$CW_base = $CONFIG{'PAGEMASTER_base'} . "/" . $FORM{'USER_community'};

	$FORM{'UserName'} = $IUSER{'username'};
	&recreate_files;
}

sub delete_old_webpage {
	if (-e "$old_dir/") {
		opendir(FILES, "$old_dir/") || &diehtml("Can't open directory $old_dir/");
   			while($file = readdir(FILES)) {
			$fn = $old_dir . "/" . $file;
			unlink ($fn);
		}
		$dn = $old_dir;
		rmdir ($dn) || &diehtml("I can't delete $dn\n");
	}
}

sub make_variables {
	$http = "http://";
	if (($Url ne "") && ($Url !~ /$http/i)){&ADMIN_error(bad_url);}
	
	$UrlName = $FORM{'URLNAME'};
	if (($Url ne "") && ($Url =~ /$http/i) && ($UrlName eq "")) {$UrlName = $Url;}

	$Description = $FORM{'Description'};
	$Description =~ s/\n//ig;

	if (($FORM{action} eq "Update Profile") && ($FORM{'Email'})) {
		if ($FORM{'Email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $FORM{'Email'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
			&ADMIN_error('bad_email_address');}
	}

	if (($FORM{action} eq "Update Profile") && ($FORM{'NewPassWord'})) {
		$FORM{'NewPassWord'} =~ tr/A-Z/a-z/;

		$_ = $FORM{'NewPassWord'};
		$PassWordLength = tr/a-z//;
		if ($PassWordLength > 12) {
		      &USER_error(long_PassWord);
		}
#		if ($PassWordLength < 4) {
#	      	&USER_error(short_PassWord);
#		}
		$FORM{'NewPassWord'} =~ s/ //;
	}

}



sub Validate_Admin_Local {

   %passcookie= &split_cookie( $ENV{'HTTP_COOKIE'}, 'admin' );
   $password = $passcookie{'password'};


   $Allowed = "F";

   if ($password eq $CONFIG{'admin_pw'}) { $Allowed = "T"; }
   if ($moderator_pw) { $Allowed = "T"; }

   if ($Allowed eq "F") {
	&ADMIN_error("Access Denied.");
        exit 0;
   }

   if (-e "$CONFIG{'data_dir'}/admin_ip.txt") {
		$fn = "$CONFIG{'data_dir'}/admin_ip.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
 			$IPaddress = <FILE>;
		close(FILE);
		chomp $IPaddress;
		if ($IPaddress ne "") {
			if (($ENV{'REMOTE_ADDR'} !~ $IPaddress) && ($IPaddress !~ $ENV{'REMOTE_ADDR'})) {
				&ADMIN_error("Access Denied.  Your IP address is not allowed to access the Admin Scripts.  You need to set the allowed IP manually on the server.  You can find out what IP address you are currently using <A HREF=\"$GUrl{'getip.cgi'}\">here</A>.");
			}
		}
	}
}



sub ADMIN_error {
   	$error = $_[0];
   	$UserName = $_[1];
   	$PassWord = $_[2];
  	print "Content-type: text/html\n\n";

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


