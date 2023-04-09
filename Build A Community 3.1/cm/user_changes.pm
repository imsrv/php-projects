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
sub change_Children {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Children\|\|$$luser{'Children'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Children'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_Income {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Income\|\|$$luser{'Income'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Income'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_Primary_Computer_Use {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Primary_Computer_Use\|\|$$luser{'Primary_Computer_Use'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Primary_Computer_Use'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_Education {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Education\|\|$$luser{'Education'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Education'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_Employment {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Employment\|\|$$luser{'Employment'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Employment'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_ICQ {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change ICQ\|\|$$luser{'ICQ'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'ICQ'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_club {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Club\|\|$$luser{'Club'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Club'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_firstname {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change First Name\|\|$$luser{'FirstName'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'FirstName'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_initial {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Middle Name\|\|$$luser{'Initial'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Initial'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_lastname {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Last Name\|\|$$luser{'LastName'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'LastName'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_birthday {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Birth DAY\|\|$$luser{'BirthDay'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'BirthDay'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_birthmonth {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Birth MONTH\|\|$$luser{'BirthMonth'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'BirthMonth'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_birthyear {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Birth YEAR\|\|$$luser{'BirthYear'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'BirthYear'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_phonenumber {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Phone number\|\|$$luser{'Phonenumber'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Phonenumber'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_status {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change status\|\|$$luser{'status'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'status'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
	&a_activate_user($luser);


}


sub change_expiry_date {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change expiry date\|\|$$luser{'expiry_date'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'expiry_date'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_monthly_fee {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change monthly fee\|\|$$luser{'monthly_fee'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'monthly_fee'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_admin_notes {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change admin notes\|\|\|\|\|\|$PROGRAM_NAME";
	$$luser{'admin_notes'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_ips {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change IPs\|\|\|\|\|\|$PROGRAM_NAME";
	$$luser{'IPs'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_history {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	$$luser{'history'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler1 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler1\|\|$$luser{'Filler1'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler1'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler2 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler2\|\|$$luser{'Filler2'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler2'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler3 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler3\|\|$$luser{'Filler3'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler3'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler4 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler4\|\|$$luser{'Filler4'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler4'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler5 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler5\|\|$$luser{'Filler5'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler5'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler6 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler6\|\|$$luser{'Filler6'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler6'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler7 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler7\|\|$$luser{'Filler7'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler7'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler8 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler8\|\|$$luser{'Filler8'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler8'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler9 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler9\|\|$$luser{'Filler9'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler9'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_Filler10 {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change USER_Filler10\|\|$$luser{'Filler10'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Filler10'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_phonenumber {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change Phone number\|\|$$luser{'Phonenumber'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Phonenumber'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_user_level {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change user level\|\|$$luser{'user_level'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'user_level'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_faxnumber {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change faxnumber\|\|$$luser{'Faxnumber'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Faxnumber'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_city {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change city\|\|$$luser{'City'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'City'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_address {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change address\|\|$$luser{'Address'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Address'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_state {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change state\|\|$$luser{'State'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'State'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_country {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change country\|\|$$luser{'Country'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Country'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_zipcode {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change zipcode\|\|$$luser{'ZipCode'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'ZipCode'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_community {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change community\|\|$$luser{'community'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'community'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_description {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change description\|\|\|\|\|\|$PROGRAM_NAME";
	$$luser{'description'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_sex {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change sex\|\|$$luser{'Sex'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Sex'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_warnings {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change warnings\|\|$$luser{'warnings'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'warnings'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_age {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change age\|\|$$luser{'Age'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'Age'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_handle {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];
	my $changetime = time;

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	$luser{'history'} .= "%%$changetime\|\|change handle\|\|$$luser{'handle'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'handle'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}


sub change_urlname {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change urlname\|\|$$luser{'urlname'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'urlname'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_url {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change url\|\|$$luser{'url'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'url'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");


}

sub change_password {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change password\|\|$$luser{'password'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'password'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
	&a_change_password($luser);


}

sub change_email {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change email\|\|$$luser{'email'}\|\|$Change\|\|$PROGRAM_NAME";
	$LOGGING .= "%%$changetime\|\|change email\|\|$$luser{'email'}\|\|$Change\|\|$PROGRAM_NAME\n<P>";
	$$luser{'email'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
	&a_change_email($luser);
}

sub change_realname {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change realname\|\|$$luser{'realname'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'realname'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

sub change_date {
}

sub change_icon {
	my ($FileNum) = $_[0];
	my ($UserName) = $_[1];
	my ($PassWord) = $_[2];
	my ($Change) = $_[3];
	my ($luser) = $_[4];

	if (! $luser) {&diehtml("Reference to user does not exist, check function call");}
	my $changetime = time;
	$$luser{'history'} .= "%%$changetime\|\|change icon\|\|$$luser{'icon'}\|\|$Change\|\|$PROGRAM_NAME";
	$$luser{'icon'} = $Change;
	&lock("$FileNum");
	&write_user($FileNum,$UserName,$PassWord,$luser);
	&unlock("$FileNum");
}

1;
