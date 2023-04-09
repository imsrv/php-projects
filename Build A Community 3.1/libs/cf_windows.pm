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
sub HelpWindow {
   	$help_file = "$GPath{'cforums_data'}/$FORM{'file'}.help";

	$BODY .= "<CENTER>\n";
	$BODY .= "<TABLE BORDER=\"1\" CELLSPACING=\"2\" CELLPADDING=\"10\">\n";
	$BODY .= "<TR BGCOLOR=\"$CONFIG{'title_color'}\">\n";
	$BODY .= "<TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><B>Community Help</B></FONT></TD></TR>\n";
	$BODY .= "<TR $CONFIG{'WINCOLOR'}>\n";
	$BODY .= "<TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";

	open(HLP,"$help_file");
		while(<HLP>) { $BODY .= $_; }
	close(HLP);

	if ($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i) {
		$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><CENTER><H3><A HREF=\"javascript:self.close();\">Close Window</A></H3></CENTER>\n";
	}
	$BODY .= "</TD></TR></TABLE></CENTER>\n";

	require "common.pm";
	&print_output('bbs_help');

	exit 0;
}



sub forum_login {
	local($restrictedto) = $_[0];

	$BODY .= "<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=0 $CONFIG{'WINCOLOR'} WIDTH=400>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><font face=\"$CONFIG{'font_face'}\" size=\"+1\" color=\"$CONFIG{'ttxt_color'}\"><CENTER><B>Login</CENTER></B></TD><TR>\n";
	$BODY .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";

	if (($VALIDUSER eq "T") && ($restrictedto eq "Club Members Only")) {
	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_join.cgi'}\">\n";
	   	$BODY .= "<P><B>This club is for club members only.  You can apply for membership below...</B>\n";
		$BODY .= "<P>$applicantmessage\n";
		$BODY .= "<P>UserName:<BR><INPUT TYPE=text NAME=UserName SIZE=25 VALUE=\"$IUSER{'username'}\">\n";
		$BODY .= "<P>PassWord:<BR><INPUT TYPE=password NAME=PassWord SIZE=25 VALUE=\"$IUSER{'password'}\">\n";
		$BODY .= "<P>Comments:<BR><TEXTAREA NAME=comments COLS=40 ROWS=4></TEXTAREA>\n";
		if ($FORM{'forum'} ne "") {
			$f2j = $FORM{'forum'};
		}
		else {
			$f2j = $FORM{'club'};
		}
		$BODY .= "<INPUT TYPE=hidden NAME=forum VALUE=\"$f2j\">\n";
		$BODY .= "<INPUT TYPE=hidden NAME=action VALUE=\"apply\">\n";
		$BODY .= "<CENTER><INPUT TYPE=submit VALUE=\"Apply!\"></CENTER>\n";
	   	$BODY .= "</FONT>\n";
	   	$BODY .= "</form>\n";
		$BODY .= "</TD></TR></TABLE>\n";
	}
	elsif (($restrictedto eq "Club Members Only") && ($VALIDUSER ne "T")) {
	   	$BODY .= "<P>Please fill in the blanks below to login and access The Member's Area\n";
   		$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_utils.cgi'}\">\n";
		$BODY .= "<INPUT TYPE=HIDDEN NAME=\"returnto\" VALUE=\"$GUrl{'clubs.cgi'}?action=open&club=$FORM{'club'}\">\n";
		&login_form("Login");
	   	$BODY .= "</FONT>\n";
		$BODY .= "</FORM>\n";
	   	$BODY .= "<HR WIDTH=50%><P><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">If you aren't a member yet, please <A HREF=\"$GUrl{'register.cgi'}\">visit the registration page.</A>\n";
   		$BODY .= "<HR WIDTH=50%><P><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Have you forgotten your password?<BR>Just fill in your email address and we'll send it to you:<BR>\n";
	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'profile.cgi'}\">\n";
   		$BODY .= "<input type=text name=\"Email\" size=20><br>\n";
	    	$BODY .= "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"Get Password\"></CENTER>\n";
	  	$BODY .= "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Get Password\"></CENTER>\n";
   		$BODY .= "</FORM>\n";
		$BODY .= "</TD></TR></TABLE>\n";

#	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_join.cgi'}\">\n";
#	   	$BODY .= "<P><B>This club is open to club members only.</B>\n";
#		$BODY .= "<P>$applicantmessage\n";
#		$BODY .= "<P>UserName:<BR><INPUT TYPE=text NAME=UserName SIZE=25 VALUE=\"$IUSER{'username'}\">\n";
#		$BODY .= "<P>PassWord:<BR><INPUT TYPE=password NAME=PassWord SIZE=25 VALUE=\"$IUSER{'password'}\">\n";
#		$BODY .= "<INPUT TYPE=hidden NAME=forum VALUE=\"$forum\">\n";
#		$BODY .= "<INPUT TYPE=hidden NAME=action VALUE=\"apply\">\n";
#		$BODY .= "<CENTER><INPUT TYPE=submit VALUE=\"Apply!\"></CENTER>\n";
#	   	$BODY .= "</FONT>\n";
#		$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><HR WIDTH=50%><P>If you aren't a member yet, please <A HREF=\"$GUrl{'register.cgi'}\">visit the registration page</A>\n";
#   		$BODY .= "<HR WIDTH=50%><P>Have you forgotten your password?\n";
#	   	$BODY .= "<BR>Just fill in your email address and we'll send it to you:<BR>\n";
#	   	$BODY .= "</form>\n";
#
#	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'profile.cgi'}\">\n";
#   		$BODY .= "<input type=text name=\"Email\" size=20><br>\n";
#	   	$BODY .= "<CENTER><INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Get Password\"></CENTER>\n";
#   		$BODY .= "</FORM>\n";
#		$BODY .= "</TD></TR></TABLE>\n";
	}
	elsif ($restrictedto eq "User Group") {
	   	$BODY .= "<P>This forum is restricted to certain members only, if you are one those members, please fill in the blanks below to login and access the message forum.  <I>Please note: your browser must support cookies and you must have the feature enabled</I>. \n";
	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cforum.cgi'}\">\n";
		&basic_login_form;
		$BODY .= "<INPUT TYPE=hidden NAME=forum VALUE=\"$forum\">\n";
		$BODY .= "<INPUT TYPE=hidden NAME=action VALUE=\"login_user\">\n";
		$BODY .= "<INPUT TYPE=submit VALUE=\"Login!\">\n";
	   	$BODY .= "</FONT>\n";
	   	$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><HR WIDTH=50%><P>If you aren't a member yet, please <A HREF=\"$GUrl{'register.cgi'}\">visit the registration page</A>\n";
   		$BODY .= "<HR WIDTH=50%><P>Have you forgotten your password?\n";
	   	$BODY .= "<BR>Just fill in your email address and we'll send it to you:<BR>\n";
	   	$BODY .= "</form>\n";

	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'profile.cgi'}\">\n";
   		$BODY .= "<input type=text name=\"Email\" size=20><br>\n";
	   	$BODY .= "<CENTER><INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Get Password\"></CENTER>\n";
   		$BODY .= "</FORM>\n";
		$BODY .= "</TD></TR></TABLE>\n";
	}
	else {
	   	$BODY .= "<P>This forum is restricted to those who know the password, please fill in the field below to login and access the message forum.  <I>Please note: your browser must support cookies and you must have the feature enabled</I>.\n";
	   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cforum.cgi'}\">\n";
		$BODY .= "<P><B>PassWord:</B>\n";
		$BODY .= "<BR><INPUT TYPE=password NAME=PassWord VALUE=\"\">\n";
		$BODY .= "<INPUT TYPE=hidden NAME=action VALUE=\"login_password\">\n";
		$BODY .= "<INPUT TYPE=hidden NAME=forum VALUE=\"$forum\">\n";
		$BODY .= "<INPUT TYPE=submit VALUE=\"Login!\">\n";
	   	$BODY .= "</FONT>\n";
   		$BODY .= "</FORM>\n";
		$BODY .= "</TD></TR></TABLE>\n";
	}

	require "common.pm";
	&print_output('cforums');
}


1;
