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

$PROGRAM_NAME = "profile.cgi";

&parse_FORM;

if ($FORM{'action'} eq "Get Password"){
	&email_password($FORM{'UserName'}, $FORM{'Email'});
}

if ($FORM{'action'} eq "") {
	$rnd=int rand 10000;
	print "Location: $GUrl{'profile.cgi'}?action=okay&$rnd\n\n";
	exit;
}
elsif ((($FORM{'action'} ne "") && ($ENV{'HTTP_COOKIE'} ne "")) && (($FORM{'action'} ne "Login") && ($FORM{'action'} ne "Continue"))) { 
	($VALID, %IUSER) = &validate_session;
}
elsif (($FORM{'action'} eq "Continue") || ($FORM{'action'} eq "Login")) {
	%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
	print "Location: $GUrl{'profile.cgi'}?action=okay&$rnd\n";
	&basic_cookie;
	print "\n";
}
else {
	&build_login_form;
	&print_output('login');
}


if ($FORM{'action'} =~ /Contact/i) {
	&print_contact_information;
	&print_output('profile');
	exit;
}

elsif (($FORM{'action'} eq "Update Profile") || ($FORM{'action'} eq "Save Your Changes!")){
	&make_variables;
	&update_profile;
	&return_html;
	&print_output('profile');
	exit;
}
else {
	&print_profile;
	&print_output('profile');
	exit;
}



sub print_login_form {
	&build_login_form;
	&print_output('login');
}

sub build_login_form {
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilelogin.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilelogin.tmplt";
}



sub return_html {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profileconfirm.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profileconfirm.tmplt";
}

sub update_profile {
	require "./cm/user_changes.pm";

	$LOGGING .= "if (($IUSER{'email'} ne $FORM{'Email'}) && ($FORM{'Email'})) {<BR>\n";

	if ($FORM{'USER_Initial'} ne "") {
		$FORM{'RealName'} = $FORM{'USER_FirstName'} . " " . $FORM{'USER_Initial'} . " " . $FORM{'USER_LastName'};
	}
	else {
		$FORM{'RealName'} = $FORM{'USER_FirstName'} . " " . $FORM{'USER_LastName'};
	}
	if (($IUSER{'realname'} ne $FORM{'RealName'}) && ($FORM{'RealName'})) {
		$LOGGING .= "change_realname\n";
		&change_realname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'RealName'},\%IUSER);
	}
	if (($IUSER{'email'} ne $FORM{'Email'}) && ($FORM{'Email'})) {
		$LOGGING .= "change_email\n";
		&update_datafile($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'NewPassWord'},$FORM{'Email'},$IUSER{'email'});
		&change_email($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'NewPassWord'},$FORM{'Email'},\%IUSER);
	}
	if (($IUSER{'password'} ne $FORM{'NewPassWord'}) && ($FORM{'NewPassWord'})) {
		$LOGGING .= "change_password\n";
		&change_password($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'NewPassWord'},\%IUSER);
		&update_datafile($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'NewPassWord'},$FORM{'Email'},\%IUSER); 
		$password_changed = 1;
	}
	if (($IUSER{'url'} ne $FORM{'URL'}) && ($FORM{'URL'})) {
		$LOGGING .= "change_url\n";
		&change_url($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'URL'},\%IUSER);
	}
	if (($IUSER{'urlname'} ne $FORM{'URLNAME'}) && ($FORM{'URLNAME'})) {
		$LOGGING .= "change_urlname\n";
		&change_urlname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'URLNAME'},\%IUSER);
	}

	if (($IUSER{'handle'} ne $FORM{'HANDLE'}) && ($FORM{'HANDLE'})) {
		$LOGGING .= "change_filenum\n";
		&change_handle($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'HANDLE'},\%IUSER);
	}
	if (($IUSER{'favetypes'} ne $FORM{'FavType'}) && ($FORM{'FavType'})) {
		$LOGGING .= "change_favtype\n";
		&change_favtype($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'FavType'},\%IUSER);
	}
	if (($USER_wherelive ne $FORM{'WhereLive'}) && ($FORM{'WhereLive'})) {
		$LOGGING .= "change_wherelive\n";
		&change_wherelive($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'WhereLive'},\%IUSER);
	}
	if (($IUSER{'warnings'} ne $FORM{'Warnings'}) && ($FORM{'Warnings'})) {
		$LOGGING .= "change_warnings\n";
		&change_warnings($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'Warnings'},\%IUSER);
	}
	if (($IUSER{'description'} ne $FORM{'Description'}) && ($FORM{'Description'})) {
		$LOGGING .= "change_description\n";
		&change_description($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'Description'},\%IUSER);
	}
	if (($IUSER{'BirthDay'} ne $FORM{'USER_BirthDay'}) && ($FORM{'USER_BirthDay'})) {
		$LOGGING .= "change_brithday\n";
		&change_birthday($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_BirthDay'},\%IUSER);
	}
	if (($IUSER{'BirthMonth'} ne $FORM{'USER_BirthMonth'}) && ($FORM{'USER_BirthMonth'})) {
		$LOGGING .= "change_birthmonth\n";
		&change_birthmonth($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_BirthMonth'},\%IUSER);
	}
	if (($IUSER{'BirthYear'} ne $FORM{'USER_BirthYear'}) && ($FORM{'USER_BirthYear'})) {
		$LOGGING .= "change_birthyear\n";
		&change_birthyear($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_BirthYear'},\%IUSER);
	}
	if (($IUSER{'FirstName'} ne $FORM{'USER_FirstName'}) && ($FORM{'USER_FirstName'})) {
		$LOGGING .= "change_firstname\n";
		&change_firstname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_FirstName'},\%IUSER);
	}
	if (($IUSER{'Initial'} ne $FORM{'USER_Initial'}) && ($FORM{'USER_Initial'})) {
		$LOGGING .= "change_initial\n";
		&change_initial($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Initial'},\%IUSER);
	}
	if (($IUSER{'LastName'} ne $FORM{'USER_LastName'}) && ($FORM{'USER_LastName'})) {
		$LOGGING .= "change_lastname\n";
		&change_lastname($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_LastName'},\%IUSER);
	}
	if (($IUSER{'Age'} ne $FORM{'USER_Age'}) && ($FORM{'USER_Age'})) {
		$LOGGING .= "change_age\n";
		&change_age($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Age'},\%IUSER);
	}
	if (($IUSER{'Sex'} ne $FORM{'USER_Sex'}) && ($FORM{'USER_Sex'})) {
		$LOGGING .= "change_sex\n";
		&change_sex($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Sex'},\%IUSER);
	}
	if (($IUSER{'Phonenumber'} ne $FORM{'USER_Phonenumber'}) && ($FORM{'USER_Phonenumber'})) {
		$LOGGING .= "change_phonenumber\n";
		&change_phonenumber($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Phonenumber'},\%IUSER);
	}
	if (($IUSER{'Faxnumber'} ne $FORM{'USER_Faxnumber'}) && ($FORM{'USER_Faxnumber'})) {
		$LOGGING .= "change_faxnumber\n";
		&change_faxnumber($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Faxnumber'},\%IUSER);
	}
	if (($IUSER{'Address'} ne $FORM{'USER_Address'}) && ($FORM{'USER_Address'})) {
		$LOGGING .= "change_address\n";
		&change_address($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Address'},\%IUSER);
	}
	if (($IUSER{'City'} ne $FORM{'USER_City'}) && ($FORM{'USER_City'})) {
		$LOGGING .= "change_city\n";
		&change_city($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_City'},\%IUSER);
	}
	if (($IUSER{'State'} ne $FORM{'USER_State'}) && ($FORM{'USER_State'})) {
		$LOGGING .= "change_state\n";
		&change_state($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_State'},\%IUSER);
	}
	if (($IUSER{'ICQ'} ne $FORM{'USER_ICQ'}) && ($FORM{'USER_ICQ'})) {
		$LOGGING .= "change_icq\n";
		&change_ICQ($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_ICQ'},\%IUSER);
	}
	if (($IUSER{'Country'} ne $FORM{'USER_Country'}) && ($FORM{'USER_Country'})) {
		$LOGGING .= "change_country\n";
		&change_country($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Country'},\%IUSER);
	}
	if (($IUSER{'ZipCode'} ne $FORM{'USER_ZipCode'}) && ($FORM{'USER_ZipCode'})) {
		$LOGGING .= "change_aipcode\n";
		&change_zipcode($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_ZipCode'},\%IUSER);
	}
	if (($IUSER{'Filler1'} ne $FORM{'USER_Filler1'}) && ($FORM{'USER_Filler1'})) {
		$LOGGING .= "change_f1\n";
		&change_Filler1($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler1'},\%IUSER);
	}
	if (($IUSER{'Filler2'} ne $FORM{'USER_Filler2'}) && ($FORM{'USER_Filler2'})) {
		$LOGGING .= "change_f2\n";
		&change_Filler2($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler2'},\%IUSER);
	}
	if (($IUSER{'Filler3'} ne $FORM{'USER_Filler3'}) && ($FORM{'USER_Filler3'})) {
		$LOGGING .= "change_f3\n";
		&change_Filler3($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler3'},\\%IUSER);
	}
	if (($IUSER{'Filler4'} ne $FORM{'USER_Filler4'}) && ($FORM{'USER_Filler4'})) {
		$LOGGING .= "change_f4\n";
		&change_Filler4($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler4'},\%IUSER);
	}
	if (($IUSER{'Filler5'} ne $FORM{'USER_Filler5'}) && ($FORM{'USER_Filler5'})) {
		$LOGGING .= "change_f5\n";
		&change_Filler5($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler5'},\%IUSER);
	}
	if (($IUSER{'Filler6'} ne $FORM{'USER_Filler6'}) && ($FORM{'USER_Filler6'})) {
		$LOGGING .= "change_f6\n";
		&change_Filler6($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler6'},\%IUSER);
	}
	if (($IUSER{'Filler7'} ne $FORM{'USER_Filler7'}) && ($FORM{'USER_Filler7'})) {
		$LOGGING .= "change_f7\n";
		&change_Filler7($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler7'},\%IUSER);
	}
	if (($IUSER{'Filler8'} ne $FORM{'USER_Filler8'}) && ($FORM{'USER_Filler8'})) {
		$LOGGING .= "change_f8\n";
		&change_Filler8($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler8'},\%IUSER);
	}
	if (($IUSER{'Filler9'} ne $FORM{'USER_Filler9'}) && ($FORM{'USER_Filler9'})) {
		$LOGGING .= "change_f9\n";
		&change_Filler9($IUSER{'filenum'}, $FORM{'UserName'},$FORM{'PassWord'},$FORM{'USER_Filler9'},\%IUSER);
	}
	if (($IUSER{'Filler10'} ne $FORM{'USER_Filler10'}) && ($FORM{'USER_Filler10'})) {
		$LOGGING .= "change_f10\n";
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
}

sub make_variables {
	if ($FORM{'nosendnotice'}) {
		$FORM{'mailings'} ="no"
	}
	else {
		$FORM{'mailings'} ="yes"
	}
	$http = "http://";
	if (($Url ne "") && ($Url !~ /$http/i)){&error(bad_url);}
	
	$UrlName = $FORM{'URLNAME'};
	if (($Url ne "") && ($Url =~ /$http/i) && ($UrlName eq "")) {$UrlName = $Url;}

	$Description = $FORM{'Description'};
	$Description =~ s/\n//ig;

	if (($FORM{action} eq "Save Your Changes!") && ($FORM{'Email'})) {
		if ($FORM{'Email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $FORM{'Email'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
			&error('bad_email_address');}
	}

	if (($FORM{action} eq "Save Your Changes!") && ($FORM{'NewPassWord'})) {
		$FORM{'NewPassWord'} =~ tr/A-Z/a-z/;

		$_ = $FORM{'NewPassWord'};
		$PassWordLength = tr/a-z1234567890//;
		if ($PassWordLength > 12) {
		      &USER_error(long_PassWord);
		}
		if ($PassWordLength < 4) {
	      	&USER_error(short_PassWord);
		}
		$FORM{'NewPassWord'} =~ s/ //;
	}

}




sub print_contact_information {
	require "$GPath{'community_data'}/fields.pm";

	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profilecontact.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profilecontact.tmplt";
}



sub print_profile {
	require "$GPath{'imagesize.pm'}";
	my @ALL = &io_get_list("profile");

	foreach $line(@ALL) {
		&parse_iweb_plugins;
		$profiletext .= $line;
	}

	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/profile/profile.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/profile/profile.tmplt";
}





sub error {
	$error = $_[0];
	%Cookies = &get_member_cookie();
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";
	&print_output('error');
}

