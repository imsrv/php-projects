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
	sub PICKUP {
		my $PICKUP = "<form ENCTYPE=\"application/x-www-form-urlencoded\" action=\"$GUrl{'postcards.cgi'}\" method=POST>\n";
		$PICKUP .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Enter your claim ticket number (it was in the email that you received) to pick up your postcard:\n";
		$PICKUP .= "<P><input name=ticket>\n";
		$PICKUP .= "<BR>\n";
		$PICKUP .= "<input type=hidden NAME=action VALUE=\"Pick up Your Postcard\">\n";
		$PICKUP .= "<input type=submit NAME=action VALUE=\"Pick up Your Postcard\">\n";
		$PICKUP .= "</form>\n";

		return $PICKUP;
	}

	sub SAVECARD {
		my $SAVECARD = "<form ENCTYPE=\"application/x-www-form-urlencoded\"  action=\"$GUrl{'savecard.cgi'}\" method=POST>\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"ref\" VALUE=\"$FORM{'ref'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"refered_search\" VALUE=\"$FORM{'refered_search'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"filename\" VALUE=\"$FORM{'filename'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"sound\" VALUE=\"$FORM{'sound'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"text\" VALUE=\"$FORM{'text'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=$FORM{'page'}>\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"sender\" VALUE=\"$FORM{'sender'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"senderemail\" VALUE=\"$FORM{'senderemail'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"recipient\" VALUE=\"$FORM{'recipient'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"email\" VALUE=\"$FORM{'email'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"preview\" VALUE=\"yes\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"view\" VALUE=\"$FORM{'view'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"search\" VALUE=\"$FORM{'search'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"cat\" VALUE=\"$FORM{'cat'}\">\n";
		$SAVECARD .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Save This Card!\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"imageurl\" VALUE=\"$FORM{'imageurl'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"Text_Color\" VALUE=\"$FORM{'Text_Color'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"Link_Color\" VALUE=\"$FORM{'Link_Color'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"BackGround_Color\" VALUE=\"$FORM{'BackGround_Color'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"BackGround\" VALUE=\"$FORM{'BackGround'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"Icon\" VALUE=\"$FORM{'Icon'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"UserName\" VALUE=\"$FORM{'UserName'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"PassWord\" VALUE=\"$FORM{'PassWord'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"PickupPage\" VALUE=\"$FORM{'PickupPage'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"CardSentRedirect\" VALUE=\"$FORM{'CardSentRedirect'}\">\n";
		$SAVECARD .= "<INPUT TYPE=HIDDEN NAME=\"respemail\" VALUE=\"$FORM{'respemail'}\">\n";
		$SAVECARD .= "</FORM>\n";

		return $SAVECARD;
	}

	sub SENDANOTHER {
		my $SENDANOTHER = "<form ENCTYPE=\"application/x-www-form-urlencoded\" action=\"$GUrl{'postcards.cgi'}\" method=POST>\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"ref\" VALUE=\"$FORM{'ref'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"refered_search\" VALUE=\"$FORM{'refered_search'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"filename\" VALUE=\"\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"sound\" VALUE=\"\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"text\" VALUE=\"$FORM{'text'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"$FORM{'refered_search'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"sender\" VALUE=\"$FORM{'sender'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"senderemail\" VALUE=\"$FORM{'senderemail'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"recipient\" VALUE=\"\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"email\" VALUE=\"\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"view\" VALUE=\"$FORM{'view'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"search\" VALUE=\"$FORM{'search'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"cat\" VALUE=\"$FORM{'cat'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"imageurl\" VALUE=\"$FORM{'imageurl'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"Text_Color\" VALUE=\"$FORM{'Text_Color'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"Link_Color\" VALUE=\"$FORM{'Link_Color'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"BackGround_Color\" VALUE=\"$FORM{'BackGround_Color'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"BackGround\" VALUE=\"$FORM{'BackGround'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"Icon\" VALUE=\"$FORM{'Icon'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"UserName\" VALUE=\"$FORM{'UserName'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"PassWord\" VALUE=\"$FORM{'PassWord'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"PickupPage\" VALUE=\"$FORM{'PickupPage'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"CardSentRedirect\" VALUE=\"$FORM{'CardSentRedirect'}\">\n";
		$SENDANOTHER .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Send Another Postcard\">\n";
		$SENDANOTHER .= "<INPUT TYPE=HIDDEN NAME=\"respemail\" VALUE=\"$FORM{'respemail'}\">\n";
		$SENDANOTHER .= "</FORM>\n";

		return $SENDANOTHER;
	}

	sub BACKTOPOSTOFFICE {
		my $BACKTOPOSTOFFICE = "<form ENCTYPE=\"application/x-www-form-urlencoded\" action=\"$GUrl{'postcards.cgi'}\" method=POST>\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"ref\" VALUE=\"$FORM{'ref'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"refered_search\" VALUE=\"$FORM{'refered_search'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"filename\" VALUE=\"\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"sound\" VALUE=\"\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"text\" VALUE=\"$FORM{'text'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"$FORM{'refered_search'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"sender\" VALUE=\"$FORM{'sender'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"senderemail\" VALUE=\"$FORM{'senderemail'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"recipient\" VALUE=\"\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"email\" VALUE=\"\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"view\" VALUE=\"$FORM{'view'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"search\" VALUE=\"$FORM{'search'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"cat\" VALUE=\"$FORM{'cat'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"imageurl\" VALUE=\"$FORM{'imageurl'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"Text_Color\" VALUE=\"$FORM{'Text_Color'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"Link_Color\" VALUE=\"$FORM{'Link_Color'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"BackGround_Color\" VALUE=\"$FORM{'BackGround_Color'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"BackGround\" VALUE=\"$FORM{'BackGround'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"Icon\" VALUE=\"$FORM{'Icon'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"UserName\" VALUE=\"$FORM{'UserName'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"PassWord\" VALUE=\"$FORM{'PassWord'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"PickupPage\" VALUE=\"$FORM{'PickupPage'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"CardSentRedirect\" VALUE=\"$FORM{'CardSentRedirect'}\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Back To The Main Post Office Page!\">\n";
		$BACKTOPOSTOFFICE .= "<INPUT TYPE=HIDDEN NAME=\"respemail\" VALUE=\"$FORM{'respemail'}\">\n";
		$BACKTOPOSTOFFICE .= "</FORM>\n";

		return $BACKTOPOSTOFFICE;
	}

1;




