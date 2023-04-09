#!/usr/bin/perl

use DB_File;

$BBS="T";
$PROGRAM_NAME = "clubs.cgi";

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

	$PROGRAM_NAME = "javachat.cgi";

	$rn = time;

	$userpm = "T";
	require "./common.pm";


	&parse_FORM;
	$CHATROOM = $FORM{'room'};

	($VALIDUSER, %IUSER) = &validate_session_no_error;

	if ($VALIDUSER eq "T") {
		#
	}
	else {
		&error_not_logged_in;
	}
	&print_output('chat');


sub error_not_logged_in {
	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>An Error Has Occured</B></FONT></CENTER></TD></TR>\n";
	if ($CONFIG{'win_color'} ne "") {
		$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}>";
	}
	else {
		$BODY .= "<TR><TD>";
	}
	$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$u = &urlencode("javachat.cgi?room=$FORM{'room'}");
	$BODY .= "You are not currently logged in and only recognized members can enter a chat.  If you are a member, please <A HREF=\"$GUrl{'cf_utils.cgi'}?action=login&returnto=$u\">login here</A>, if you would like to join <A HREF=\"$GUrl{'register.cgi'}\">click to here</A>.\n";
	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');  
}
