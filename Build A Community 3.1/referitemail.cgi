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

	$forum_email = $CONFIG{'email'};

	&parse_FORM;
	&validate_session_no_error;

	if ($FORM{'action'} ne "Send!") {
		&printmessageform;
		&print_output('referit');
		exit;

	}

	$FORM{'senderemail'} =~ tr/A-Z/a-z/;
     	if ($FORM{'senderemail'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $FORM{'senderemail'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
		&bad_email_address;}

	if ($FORM{'url'} eq "") {
		&missing_url;
	}

	if (($FORM{'sender'} eq "") || ($FORM{'message'} eq "")) {
		&missing_fields;
	}

	&send_mail_notification;
	&print_thank_you;


sub printmessageform {
	$BODY .= "<TABLE WIDTH=550 CELLPADDING=0 CELLSPACING=0>\n";
	if ($FORM{'mod_email'} eq "") {
		$rr = "A Friend";
	}
	else {
		$rr = "The Moderator/Admin";
	}
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Refer This Thread To $rr</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";

	$BODY .= "<TABLE>\n<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'referitemail.cgi'}\">\n";
	$BODY .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Your Name:</TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><INPUT TYPE=text NAME=sender SIZE=30 VALUE=\"$IUSER{'realname'}\"></TD></TR>\n";
	$BODY .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Your Email Address:</TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><INPUT TYPE=text NAME=senderemail SIZE=30 VALUE=\"$IUSER{'email'}\"></TD></TR>\n";
	if ($FORM{'mod_email'} ne "") {
		$BODY .= "<INPUT TYPE=hidden NAME=email VALUE=\"$FORM{'mod_email'}\">";
	}
	else {
		$BODY .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">The Recipient's Email Address:</TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><INPUT TYPE=text NAME=email SIZE=30 VALUE=\"\"></TD></TR>\n";
	}
	$BODY .= "<TR><TD COLSPAN=2><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">A message from you:<BR>";
	$BODY .= "<TEXTAREA NAME=message COLS=40 ROWS=5></TEXTAREA></TD></TR>\n";

	$BODY .= "<INPUT TYPE=hidden NAME=url VALUE=\"$FORM{'url'}\">\n";
	$BODY .= "<TR><TD COLSPAN=2><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><INPUT TYPE=submit NAME=action VALUE=\"Send!\"></TD></TR>\n";
	$BODY .= "</FORM>\n";
	$BODY .= "</TABLE>\n";


	$BODY .= "</TD></TR></TABLE>\n";
}


sub send_mail_notification {
	$fn = "$GPath{'cforums_data'}/referit_email.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@EMAIL = <FILE>;
	close(FILE);

	&send_note($FORM{'email'});

}

sub send_note {
	local($address) = $_[0];

	if (($address !~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/) || ($address =~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)){
		if ($address ne "") {
			open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
			  print MAIL "To: $address\n";
			  print MAIL "From: $CONFIG{'email'}\n";
			  print MAIL "Subject: Check This Out!\n";

			  foreach $eline(@EMAIL) {
				$eline =~ s/\[SENDER\]/$FORM{'sender'}/g;
				$eline =~ s/\[SENDEREMAIL\]/$FORM{'senderemail'}/g;
				$eline =~ s/\[RECIPIENTEMAIL\]/$address/g;
				$eline =~ s/\[MESSAGE\]/$FORM{'message'}/g;
				$eline =~ s/\[URL\]/$FORM{'url'}/g;
				print MAIL "$eline";
			  }
			  print MAIL "\n\n\n";
			close(MAIL);
		}
	}
}



sub bad_email_address {
	$error = "bad_email_address";

	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>An Error Has Occured</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<html><head><title>The email address that you provided is invalid.</title></head>\n";
	$BODY .= "<body><h2>The email address ($FORM{'senderemail'}) that you provided is invalid.</h2>\n";
	$BODY .= "<P>AOL members, please remember that you need to include the \@aol.com at the end of your address.\n";
	$BODY .= "<P>Please press your [BACK] button to fill in the blanks.<p>\n";
	$BODY .= "\n</body></html>\n";
	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');  
}

sub missing_url {
	$error = "missing_url";

	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>An Error Has Occured</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<html><head><title>Missing Address</title></head>\n";
	$BODY .= "<body><h2>You are missing some information.</h2>\n";
	$BODY .= "<P>The url (address) that you are refering is invalid.  This is probably the result of a bad setting by the administrator, please contact them so that they can correct it.\n";
	$BODY .= "Please press your [BACK] button to fill in the blanks.<p>\n";
	$BODY .= "\n</body></html>\n";
	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');
}


sub missing_fields {
	$error = "missing_fields";


	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>An Error Has Occured</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<html><head><title>Missing Information</title></head>\n";
	$BODY .= "<body><h2>You are missing some information.</h2>\n";
	$BODY .= "<P>All fields must be filled in.\n";
	$BODY .= "Please press your [BACK] button to fill in the blanks.<p>\n";
	$BODY .= "\n</body></html>\n";
	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');
}



sub print_thank_you {
	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Thank You</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<html><head><title>Thank You</title></head>\n";
	$BODY .= "<BODY BGCOLOR=\"#FFFFFF\">";
	$BODY .= "<H2>Your message has been sent!</H2>";
	$BODY .= "<A HREF=\"$FORM{'url'}\">Click here to return</A>!\n";
	$BODY .= "<hr>\n";
	$BODY .= "</body></html>\n";
	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('referit');
}

