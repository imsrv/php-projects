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

	sub REGISTER {
		return "$GUrl{'register.cgi'}";
	}

	sub LOGIN {
	}

	sub HELLO {
		if ($IUSER{username}){
      		$CONFIG{'hello_string'} =~ s/\[USERNAME\]/$IUSER{'username'}/g;
	      	$CONFIG{'hello_string'} =~ s/\[REALNAME\]/$IUSER{'realname'}/g;
      		$CONFIG{'hello_string'} =~ s/\[FIRSTNAME\]/$IUSER{'firstname'}/g;
      		$CONFIG{'hello_string'} =~ s/\[LASTNAME\]/$IUSER{'lastname'}/g;
	      	$CONFIG{'hello_string'} =~ s/\[HANDLE\]/$IUSER{'handle'}/g;
			return $CONFIG{'hello_string'};
		}
		else {
			return $CONFIG{'default_hello_string'};
		}		
	}

	sub LOGOUT {
		return "$GUrl{'users_utilities.cgi'}?action=Logout";
	}

	sub USEREMAIL {
		return $IUSER{'email'};
	}

	sub USERDESCRIPTION {
		return $IUSER{'description'};
	}

	sub USERCOMMUNITY {
		return $IUSER{'community'};
	}

	sub HANDLE {
		return $IUSER{'handle'};
	}

	sub USERREALNAME {
		return $IUSER{'realname'};
	}

	sub FIRSTNAME {
		return $IUSER{'FirstName'};
	}

	sub LASTNAME {
		return $IUSER{'LastName'};
	}

	sub MIDDLENAME {
		return $IUSER{'Initial'};
	}

	sub BIRTH {
		$_[0] =~ s/\W//g;
		if ($_[0] eq "DAY") {
			return $IUSER{'BirthDay'};
		}
		elsif ($_[0] eq "MONTH") {
			return $IUSER{'BirthMonth'};
		}
		elsif ($_[0] eq "MONTHWORD") {
			@months = ("","January","February","March","April","May","June","July","August","September","October","November","December");
			return $months[$IUSER{'BirthMonth'}];
		}
		elsif ($_[0] eq "YEAR") {
			return $IUSER{'BirthYear'};
		}
      	}

	sub FILLER {
		$_[0] =~ s/\W//g;

		if ($_[0] =~ /\d/) {
			my $name = "FILLER",$_[0];
			return $$name;
		}
		else {
			return undef;
		}
	}


	sub PASSWORD {
		return $IUSER{'password'};
	}

	sub USERNAME {
		return $IUSER{'username'};
	}

	sub COMMUNITYNAME {
		return $Group;
	}

	sub SCREENNAME {
		if ($IUSER{'handle'} ne "") {
			$ScreenName = $IUSER{'handle'};
		}
		else {
			$ScreenName = $IUSER{'realname'};
		}
		return $ScreenName;
	}

	sub MOREINFO {
		return "$GUrl{'moreinfo.cgi'}?UserName=$IUSER{'username'}";
	}

	sub ICON {
		if ($IUSER{'icon'} ne "") {
			$icon_image = "<IMG SRC=\"$GUrl{'icon_images'}/$IUSER{'icon'}.gif\">";
		}
		else {
			my %Cookies = &get_member_cookie;
			if ($Cookies{'Icon'}) {
				return "<IMG SRC=\"$GUrl{'icon_images'}/$Cookies{'Icon'}.gif\">";
			}
			else {
				return "<BR>";
			}
		}
	}

	sub POPUP {
		my $POPUP = undef;
		$POPUP = "<SCRIPT LANGUAGE=\"javascript\">\n";
		$POPUP .= "<!--\n";
		$POPUP .= "function OpenAdWin(Loc) {\n";
		$POPUP .= "wAdWindow=window.open(Loc,\"wAdWindow\",\"toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'POPUP_Width'},height=$CONFIG{'POPUP_Height'}\");\n";
		$POPUP .= "wAdWindow.focus();\n";
		$POPUP .= "}\n";
		$POPUP .= "// -->\n";
		$POPUP .= "</SCRIPT>\n";
		$POPUP .= "<! POPUP CODE >\n";
		return $POPUP;
	}
	sub ZIPCODE {
		return $IUSER{'ZipCode'};
	}
	sub COUNTRY {
		return $IUSER{'Country'};
	}
	sub PHONENUMBER {
		return $IUSER{'Phonenumber'};
	}
	sub FAXNUMBER {
		return $IUSER{'Faxnumber'};
	}
	sub ADDRESS {
		return $IUSER{'Address'};
	}
	sub STATE {
		return $IUSER{'State'};
	}
	sub CITY {
		return $IUSER{'City'};
	}
	sub ICQ {
		return $IUSER{'ICQ'};
	}
1;
