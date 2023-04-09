#!/usr/bin/perl
##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.11                                                              #
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
use CGI::Carp qw(fatalsToBrowser); 
#use Time::HiRes qw(gettimeofday);
#$PSTART = gettimeofday;

use DB_File;

$userpm = "T";
require "./common.pm";
require "$GPath{'community_data'}/fields.pm";

$PROGRAM_NAME = "register.cgi";

&parse_FORM;


if (($ENV{'REQUEST_METHOD'} eq "GET") && ($FORM{'action'} eq "")) {
	if ($CONFIG{'REGISTER_show_rules'} eq "YES") {
		&print_registration_rules;
	}
	else {
		&print_registration_form_page1;
	}
	&print_output('register');
}


if ($FORM{'action'} eq "I Agree") {
	&print_registration_form_page1;
	&print_output('register');
}

#$FORM{'action'} = "Register";

if ($FORM{'action'} eq "Register"){
	if ($registration_urls =~ /\w/i) {
		$Valid_Location = "F";
		(@registration_urls) = split (/&&/, $registration_urls);
		foreach $r_url (@registration_urls) {
			$r_url =~ s/\s//g;
			if ($ENV{'HTTP_REFERER'} eq $r_url) {$Valid_Location = "T";}
		}
		if ($Valid_Location ne "T") {&error('bad_referer');}
	}
	if (-e "$GPath{'community_data'}/banned_username.txt") {
		open (USERNAMES, "$GPath{'community_data'}/banned_username.txt");
		@USERNAMES = <USERNAMES>;
		close (USERNAMES);

		foreach $ul (@USERNAMES) {
			$ul =~ s/(\n|\cM| )//g;
			if ($ul eq $FORM{'UserName'}) {
				&error('name_taken');
			}
		}
	}
	if ($CONFIG{'COMMUNITY_Assign_password'} ne "YES") {
		&check_entries;
		&print_registration_form_page2;
		&print_output('register');
	}
	else {
		&check_entries;
		&print_registration_form_page2;
		&print_output('register');
	}
}

if ($FORM{'action'} eq "Confirm"){
	$| = 1;
	if ($registration_urls =~ /\w/i) {
		$Valid_Location = "F";
		(@registration_urls) = split (/&&/, $registration_urls);
		foreach $r_url (@registration_urls) {
			if ($ENV{'HTTP_REFERER'} eq $r_url) {$Valid_Location = "T";}
		}
		if ($Valid_Location ne "T") {&error('bad_referer');}
	}
	if ($CONFIG{'COMMUNITY_Assign_password'} eq "YES") {
		&generate_password;
	}
	if ($CONFIG{'COMMUNITY_Approve_New_Members'} eq "YES") {
		$FORM{'status'} = "hold";
	}
	else {
		$FORM{'status'} = "active";
	}

	$FORM{'monthly_fee'} = $COMMUNITY_Monthly_Fee;

	$FORM{'expiry_date'} = ($COMMUNITY_Initial_Days_Till_Expiry * 60 * 60 * 24);

	&check_entries;
	%IUSER = &create_user($FORM{'RealName'},$FORM{'UserName'},$FORM{'PassWord'},$FORM{'Email'},$FORM{'USER_Age'},$FORM{'USER_Sex'},$FORM{'USER_Phonenumber'},$FORM{'USER_Faxnumber'},$FORM{'USER_Address'},$FORM{'USER_City'},$FORM{'USER_State'},$FORM{'USER_Country'},$FORM{'USER_ZipCode'},$IUSER{'status'},$IUSER{'expiry_date'},$IUSER{'monthly_fee'},$IUSER{'admin_notes'},$IUSER{'history'},$FORM{'USER_BirthDay'},$FORM{'USER_BirthMonth'},$FORM{'USER_BirthYear'},$FORM{'USER_Filler1'},$FORM{'USER_Filler2'},$FORM{'USER_Filler3'},$FORM{'USER_Filler4'},$FORM{'USER_Filler5'},$FORM{'USER_Filler6'},$FORM{'USER_Filler7'},$FORM{'USER_Filler8'},$FORM{'USER_Filler9'},$FORM{'USER_Filler10'},$FORM{'USER_FirstName'},$FORM{'USER_Initial'},$FORM{'USER_LastName'},$FORM{'USER_Referer'},$FORM{'USER_ICQ'},$FORM{'status'},$FORM{'monthly_fee'},$FORM{'USER_Marital_Status'}, $FORM{'USER_Children'},$FORM{'USER_Income'},$FORM{'USER_Primary_Computer_Use'},$FORM{'USER_Education'},$FORM{'USER_Employment'});
	&send_notice;

	&return_html;
	&print_output('profile');

}


sub send_notice {
	my @EMAIL = &io_get_list("initial_email");

	open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
	  print MAIL "To: $FORM{'Email'}\n";
	  print MAIL "From: $CONFIG{'email'}\n";
	  print MAIL "Subject: $CONFIG{'Registration_Message_Subject'}\n";

	  foreach my $line(@EMAIL) {
		$line =~ s/\[USERNAME\]/$FORM{'UserName'}/g;
		$line =~ s/\[FIRSTNAME\]/$FORM{'FirstName'}/g;
		$line =~ s/\[LASTNAME\]/$FORM{'LastName'}/g;
		$line =~ s/\[PASSWORD\]/$FORM{'PassWord'}/g;
		print MAIL "$line";
	  }
	  print MAIL "\n\n\n";
	close(MAIL);
}

sub print_registration_rules {
	my @aRULES = &io_get_list("rules");
	foreach $line (@aRULES) {
		$RULES .= $line;
	}
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/register/registrationrules.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$Text::Template::ERROR|$GPath{'source_templates'}/register/registrationrules.tmplt";
}

sub print_registration_form_page1 {
	if ($COMMUNITY_Vcard eq "BUSINESS") {
		$vcard_location = "Business";
	}
	else {
		$vcard_location = "Home";
	}

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/register/registerquestions.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/register/registerquestions.tmplt";

}



sub print_registration_form_page2 {

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/register/registrationconfirm.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/register/registrationconfirm.tmplt";

}


sub return_html {
	my @THANK_YOU_PAGE = &io_get_list("thank_you_page");
	
	foreach $line (@THANK_YOU_PAGE) {
		$line =~ s/PLUGIN:USERNAME/$FORM{'UserName'}/g;
		$line =~ s/PLUGIN:PASSWORD/$FORM{'PassWord'}/g;
		&parse_iweb_plugins;
		$THANKYOU .= $line;
	}

	$OUTPUT = "";
	$line = "";
	$OUT = "";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/register/registerthankyou.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/register/registerthankyou.tmplt";
}


sub check_entries {
	my $match = 0;
	my $match2 = 0;

	if ($FORM{'USER_Initial'} ne "") {
		$FORM{'RealName'} = $FORM{'USER_FirstName'} . " " . $FORM{'USER_Initial'} . " " . $FORM{'USER_LastName'};
	}
	else {
		$FORM{'RealName'} = $FORM{'USER_FirstName'} . " " . $FORM{'USER_LastName'};
	}

	# Verify and strip bad characters from Username
	$FORM{'UserName'} =~ s/ /_/;
	$FORM{'UserName'} =~ s/\W//;
	$FORM{'UserName'}  = lc($FORM{'UserName'});

	if (length($FORM{'UserName'}) > 12) {
		&error(long_user);
	}

	if ($CONFIG{'COMMUNITY_Assign_password'} ne "YES") {
		if ($FORM{'PassWord'} ne $FORM{'PassWord2'}) {
 			&error(passwords_dont_match);
		}	
	}

	if ($FORM{'action'} eq "Confirm") {
		# Verify and strip bad characters from PassWord
		$FORM{'PassWord'} =~ s/ /_/;
		$FORM{'PassWord'} =~ s/\W//;
		$FORM{'PassWord'} =~ tr/A-Z/a-z/;

		if ($CONFIG{'COMMUNITY_Assign_password'} ne "YES") {
			if (length($FORM{'PassWord'}) > 12) {
				&error(long_PassWord);
			}
			if (length($FORM{'PassWord'}) < 4) {
      			&error(short_PassWord);
			}
		}
	}

	# Verify Email Address
	$FORM{'Email'} = lc($FORM{'Email'});
	$FORM{'Email'} =~ s/ //g;
     	if ($FORM{'Email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $FORM{'Email'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
		&error('bad_email_address');}

	if ($FORM{'RealName'} eq ""){&error(missing_info);}
	if ($FORM{'UserName'} eq ""){&error(missing_info);}
	if ($FORM{'Email'} eq ""){&error(missing_info);}

	($match, $match2) = &verify_that_user_does_not_exist($FORM{'UserName'}, $FORM{'Email'});

	if ($COMMUNITY_Age_Required eq "YES") {
		if ($FORM{'USER_Age'} eq "") {
			&error('missing','age');
		}
	}

	if ($COMMUNITY_Sex_Required eq "YES") {
		if ($FORM{'USER_Sex'} eq "") {
			&error('missing','sex');
		}
	}

	if ($COMMUNITY_PhoneNumber_Required eq "YES") {
		if ($FORM{'USER_Phonenumber'} eq "") {
			&error('missing','phone number');
		}
	}

	if ($COMMUNITY_FaxNumber_Required eq "YES") {
		if ($FORM{'USER_Faxnumber'} eq "") {
			&error('missing','fax number');
		}
	}

	if ($COMMUNITY_Address_Required eq "YES") {
		if ($FORM{'USER_Address'} eq "") {
			&error('missing','address');
		}
	}

	if ($COMMUNITY_City_Required eq "YES") {
		if ($FORM{'USER_City'} eq "") {
			&error('missing','city');
		}
	}

	if ($COMMUNITY_State_Required eq "YES") {
		if ($FORM{'USER_State'} eq "") {
			&error('missing','state');
		}
	}

	if ($COMMUNITY_Country_Required eq "YES") {
		if ($FORM{'USER_Country'} eq "") {
			&error('missing','country');
		}
	}

	if ($COMMUNITY_ZipCode_Required eq "YES") {
		if ($FORM{'USER_ZipCode'} eq "") {
			&error('missing','zip code');
		}
	}
	
	if ($COMMUNITY_BirthDate_Required eq "YES") {
		if ($FORM{'USER_BirthDay'} eq "") {
			&error('missing','birth day');
		}
		if ($FORM{'USER_BirthMonth'} eq "") {
			&error('missing','birth month');
		}
		if ($FORM{'USER_BirthYear'} eq "") {
			&error('missing','birth year');
		}
	}

	if ($COMMUNITY_ICQ_Required eq "YES") {
		if ($FORM{'USER_ICQ'} eq "") {
			&error('missing','ICQ');
		}
	}

	if ($COMMUNITY_Filler1_Required eq "YES") {
		if ($FORM{'USER_Filler1'} eq "") {
			$COMMUNITY_Filler1_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler1_Prompt);
		}
	}

	if ($COMMUNITY_Filler2_Required eq "YES") {
		if ($FORM{'USER_Filler2'} eq "") {
			$COMMUNITY_Filler2_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler2_Prompt);
		}
	}

	if ($COMMUNITY_Filler3_Required eq "YES") {
		if ($FORM{'USER_Filler3'} eq "") {
			$COMMUNITY_Filler3_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler3_Prompt);
		}
	}

	if ($COMMUNITY_Filler4_Required eq "YES") {
		if ($FORM{'USER_Filler4'} eq "") {
			$COMMUNITY_Filler4_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler4_Prompt);
		}
	}

	if ($COMMUNITY_Filler5_Required eq "YES") {
		if ($FORM{'USER_Filler5'} eq "") {
			$COMMUNITY_Filler5_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler5_Prompt);
		}
	}

	if ($COMMUNITY_Filler6_Required eq "YES") {
		if ($FORM{'USER_Filler6'} eq "") {
			$COMMUNITY_Filler6_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler6_Prompt);
		}
	}

	if ($COMMUNITY_Filler7_Required eq "YES") {
		if ($FORM{'USER_Filler7'} eq "") {
			$COMMUNITY_Filler7_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler7_Prompt);
		}
	}

	if ($COMMUNITY_Filler8_Required eq "YES") {
		if ($FORM{'USER_Filler8'} eq "") {
			$COMMUNITY_Filler8_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler8_Prompt);
		}
	}

	if ($COMMUNITY_Filler9_Required eq "YES") {
		if ($FORM{'USER_Filler9'} eq "") {
			$COMMUNITY_Filler9_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler9_Prompt);
		}
	}

	if ($COMMUNITY_Filler10_Required eq "YES") {
		if ($FORM{'USER_Filler10'} eq "") {
			$COMMUNITY_Filler10_Prompt =~ s/\:$//;
			&error('missing',$COMMUNITY_Filler10_Prompt);
		}
	}


	if ($match==1) {&error(name_taken);}
	if ($CONFIG{'COMMUNITY_Block_Multiple_Memberships'} eq "YES") {
		if ($match2==1) {&error(email_taken);}
	}

}


sub generate_password {
	my @passwords = &io_get_list("passwords");

	srand();
     	$seed=$#passwords;
	my $Passnum=int rand $seed;

	if ($Passnum<1){$Passnum=1;}

	$FORM{'PassWord'} = $passwords[$Passnum];
	$FORM{'PassWord'} =~ s/\n//g;
	$FORM{'PassWord'} =~ s/\cM//g;

	if ($FORM{'PassWord'} eq ""){
		$FORM{'PassWord'} = "plane";
	}
	my $rnd1 = int rand 100;
	my $rnd2 = int rand 100;
	if ($CONFIG{'RegistrationAddRandomNumToPassWord'} eq "YES") {
		$FORM{'PassWord'} = $rnd1 . $FORM{'PassWord'} . $rnd2;
	}
}




########################################
# Error Messages

sub error {
	$error = $_[0];
	my $specific = $_[1];

	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";
	&print_output('error');
}



sub log_missed_catch {
	open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
	  print MAIL "To: pickup\@ecreations.com\n";
	  print MAIL "From: $CONFIG{'email'}\n";
	  print MAIL "Subject: Missed Catch\n";

	  print MAIL "buffer:\n\n========================\n $buffer\n";
        print MAIL "ENVIRONMENT:\n=============\n";
	  foreach $k (keys %ENV) {
		print MAIL "$k = $ENV{$k}\n";
	  }	
	  print MAIL "\n\n\n";
	close(MAIL);
}


	&log_missed_catch;
	&print_registration_form_page1;
	&print_output('register');
	exit;

