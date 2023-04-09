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



sub ecreations_vars {
	print "Content-type: text/html\n\n";
	print "<HEAD>\n";
  	print "<TITLE>BuildACommunity.com Menu Frame</TITLE>\n";
	print "</HEAD>\n";
	print "<SCRIPT LANGUAGE=\"javascript\">\n";

 	print "function Help(c_what) {\n";
	print "  var Location = \"$PROG_URL?action=help&topic=\" + c_what;\n";
	print "  link=open(Location,\"CCSLink\",\"toolbar=no,scrollbars=yes,directories=no,menubar=no,resizable=yes,width=420,height=410\");\n";
	print "}\n";

	print "</SCRIPT>\n";
	print "<BODY bgcolor=\"cccc99\" link=\"blue\" vlink=\"blue\">\n";

#	print "<FONT COLOR=\"white\">Using Database: $this_database / $CONFIG{'data_dir'} / $global_cfg</FONT>";

	print "<CENTER><form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME=\"var_form\" ACTION=\"$PROG_URL\" METHOD=\"POST\" ENCTYPE=\"application/x-www-form-urlencoded\" TARGET=\"main\">\n";
	print "<FONT SIZE=+3 COLOR=\"black\"><CENTER><B>Program Configuration</B></CENTER></FONT><BR><BR>\n";
	
	print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";

	print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";

	print "<TR>\n";
	print "<TD COLSPAN=2 BGCOLOR=\"#ffffcc\"><FONT COLOR=\"black\"><CENTER><H3>Global Settings</H2></CENTER></FONT></TD>\n";
	print "</TR>\n";
		
	print "<TR><TD>\n";
	print "Location of Sendmail:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'mail_cmd'}\" SIZE=35 NAME=\"mail_cmd\" ></TD></TR>\n";

	print "<TR><TD>\n";
	print "Relative URL of the directory where these scripts are installed:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CGI_DIR'}\" SIZE=35 NAME=\"CGI_DIR\" ></TD></TR>\n";

     	print "<TR><TD>\n";
	print "Complete URL of the directory where these scripts are installed: </TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_full_cgi'}\" NAME=\"COMMUNITY_full_cgi\" SIZE=35 MAXLENGTH=1000>\n";
	print "</TD></TR>\n";

	print "<TR><TD>\n";
	print "Complete path of the directory where these scripts are installed:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'ALL_CompleteCgiBinPath'}\" NAME=\"ALL_CompleteCgiBinPath\" SIZE=35 MAXLENGTH=1000>\n";
	print "</TD></TR>\n";
	
	print "<TR><TD>\n";
	print "Relative URL of the image directory:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'button_dir'}\" SIZE=35 NAME=\"button_dir\" ></TD></TR>\n";

	print "<TR><TD>\n";
	print "Complete URL of the help files:  (<FONT SIZE=-1 COLOR=MAROON>You should pretty much never need to alter this.</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_helpfiles'}\" NAME=\"COMMUNITY_helpfiles\" SIZE=35></TD></TR>\n";

	print "<TR><TD>\n";
	print "Complete URL of the HomePage:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'home_page'}\" SIZE=35 NAME=\"home_page\"></TD></TR>\n";

	print "<TR><TD>\n";
	print "Return email address:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'email'}\" SIZE=35 NAME=\"email\"></TD></TR>\n";

	print "<TR><TD>\n";
	print "Page Color:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'pg_color'}\" NAME=\"pg_color\" SIZE=10></TD></TR>\n";

	print "<TR><TD>\n";
	print "Window Color:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'win_color'}\" NAME=\"win_color\" SIZE=10></TD></TR>\n";

	print "<TR><TD>\n";
	print "Title Bar Color:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'title_color'}\" NAME=\"title_color\" SIZE=10></TD></TR>\n";
	
	print "<TR><TD>\n";
	print "Title Bar Font Color:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'ttxt_color'}\" NAME=\"ttxt_color\" SIZE=10></TD></TR>\n";

	print "<TR><TD>\n";
	print "Regular Font Color:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'text_color'}\" NAME=\"text_color\" SIZE=10></TD></TR>\n";

	print "<TR><TD>\n";
	print "Regular Font Face:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'font_face'}\" NAME=\"font_face\"  SIZE=35></TD></TR>\n";

	print "<TR><TD>\n";
	print "Regular Font Size:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'font_size'}\" NAME=\"font_size\" SIZE=5></TD></TR>\n";

	print "<TR><TD>\n";
	print "Microsoft Internet Explorer has a bug affecting opening new windows with javascript, this does not affect all versions and appears to be fixed in version 5.+.  Do you want open new windows only for Netscape Navigator and work in the same window for Internet Explorer?  (<FONT SIZE=-1 COLOR=MAROON>This bug first appeared in version 4.0, was fixed in 4.1, then reappeared in 4.4.  All 5.0 versions appear to be functional.</FONT>):</TD>\n";
	print "<TD><SELECT NAME=\"keep_things_IE_safe\" >\n";
	print "<OPTION VALUE=\"$CONFIG{'keep_things_IE_safe'}\">$CONFIG{'keep_things_IE_safe'}\n";
	print "<OPTION VALUE=\"YES\">YES\n";
	print "<OPTION VALUE=\"NO\">NO\n";
	print "</SELECT></TD></TR>\n";

	print "<TR><TD>\n";
	print "Use generated images graphs instead of html graphs:</TD>\n";
	print "<TD><SELECT NAME=\"NiceGraphs\" >\n";
	print "<OPTION VALUE=\"$CONFIG{'NiceGraphs'}\">$CONFIG{'NiceGraphs'}\n";
	print "<OPTION VALUE=\"YES\">YES\n";
	print "<OPTION VALUE=\"NO\">NO\n";
	print "</SELECT></TD></TR>\n";

	print "<TR><TD>\n";
	print "URL of graphic generator:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GRAPH_Url'}\" NAME=\"GRAPH_Url\" SIZE=35></TD></TR>\n";

	print "<TR><TD>\n";
	print "Admin Password:</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'admin_pw'}\" NAME=\"admin_pw\" SIZE=35 MAXLENGTH=1000 ></TD></TR>\n";
	print "</TABLE></TABLE><BR><BR>\n";

	if ($CMAIL eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>CommunityMail Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the cmail.cgi script:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MAILSCRIPT'}\" NAME=\"MAILSCRIPT\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Convert URLs in email to a format useable by AOL? (<FONT SIZE=-1 COLOR=MAROON>AOL does not always make URLs clickable in the email</FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"Convert_urls_for_aol\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'Convert_urls_for_aol'}\">$CONFIG{'Convert_urls_for_aol'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "What text should be clickable when sending to AOL?: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AOLPROMPT'}\" NAME=\"AOLPROMPT\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Should the program try to validate the users' email address by forcing them to respond to an email sent to the supplied address before adding them?: </TD>\n";
		print "<TD><SELECT NAME=\"verify_email\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'verify_email'}\">$CONFIG{'verify_email'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Subject of Confirmation Email (<FONT SIZE=-1 COLOR=MAROON>the text of the email can be set in the CommunityMail Admin</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Confirmation_subject'}\" NAME=\"Confirmation_subject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Subscription Page turned on?  (<FONT SIZE=-1 COLOR=MAROON>if yes, you can still turn individual questions below on/off</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"get_demos\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'get_demos'}\">$CONFIG{'get_demos'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "First and last name mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"Name\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'Name'}\">$CONFIG{'Name'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Zipcode mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"ZipCode\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'ZipCode'}\">$CONFIG{'ZipCode'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Country mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"Country\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'Country'}\">$CONFIG{'Country'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "State/Province mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"State\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'State'}\">$CONFIG{'State'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "City mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"City\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'City'}\">$CONFIG{'City'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Gender mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"Sex\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'Sex'}\">$CONFIG{'Sex'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Birthdate mandatory? (<FONT SIZE=-1 COLOR=MAROON>only answer if Subscription Page is turned on - see above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"BirthDate\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'BirthDate'}\">$CONFIG{'BirthDate'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Use option field 1? (<FONT SIZE=-1 COLOR=MAROON>this allows you to collect information not mentioned above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"MailCustom1\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'MailCustom1'}\">$CONFIG{'MailCustom1'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Custom field 1 prompt/title: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MailCustom1Title'}\" NAME=\"MailCustom1Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Use option field 2? (<FONT SIZE=-1 COLOR=MAROON>this allows you to collect information not mentioned above.</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"MailCustom2\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'MailCustom2'}\">$CONFIG{'MailCustom2'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Custom field 2 prompt/title: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MailCustom2Title'}\" NAME=\"MailCustom2Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Use option field 3? (<FONT SIZE=-1 COLOR=MAROON>this allows you to collect information not mentioned above</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"MailCustom3\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'MailCustom3'}\">$CONFIG{'MailCustom3'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Custom field 3 prompt/title: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MailCustom3Title'}\" NAME=\"MailCustom3Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Use option field 4? (<FONT SIZE=-1 COLOR=MAROON>this allows you to collect information not mentioned above.</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"MailCustom4\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'MailCustom4'}\">$CONFIG{'MailCustom4'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Custom field 4 prompt/title: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MailCustom4Title'}\" NAME=\"MailCustom4Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Use option field 5? (<FONT SIZE=-1 COLOR=MAROON>this allows you to collect information not mentioned above.</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"MailCustom5\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'MailCustom5'}\">$CONFIG{'MailCustom5'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Custom field 5 prompt/title: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MailCustom5Title'}\" NAME=\"MailCustom5Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "</TABLE></TABLE><BR><BR>\n";
	}

	if ($USER eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>CommunityMembers Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Add random numbers to generated passwords? (<FONT SIZE=-1 COLOR=MAROON>Normally CommunityMembers uses an english language word that the user can easily remember, this option keeps the word but adds two numbers at the beginning and end to make it more difficult to guess</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"RegistrationAddRandomNumToPassWord\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'RegistrationAddRandomNumToPassWord'}\">$CONFIG{'RegistrationAddRandomNumToPassWord'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Encryption Key for passwords in cookies - a long random string of ASCII characters (<FONT SIZE=-1 COLOR=MAROON>This will keep people from reading from cookie files but probably would not be sufficient for stopping a determined hacker.  Unfortunately, good encryption requires special software on the server, is slow and subject to import/export laws.  This should be sufficient for anything but the most extreme cases.</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'passwordkey'}\" NAME=\"passwordkey\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Admin PopUp Window width: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'ADMIN_WINDOW_WIDTH'}\" NAME=\"ADMIN_WINDOW_WIDTH\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Admin PopUp Window height: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'ADMIN_WINDOW_HEIGHT'}\" NAME=\"ADMIN_WINDOW_HEIGHT\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of users to display per screen in search results: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'USERS_PER_SCREEN'}\" NAME=\"USERS_PER_SCREEN\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Duration of a member cookie (in hours): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_expire_cookie'}\" NAME=\"COMMUNITY_expire_cookie\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Display Rules Page to users before they can register? (<FONT SIZE=-1 COLOR=MAROON>Rules Page can be found in the CommunityMembers/Weaver Admin</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"REGISTER_show_rules\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'REGISTER_show_rules'}\">$CONFIG{'REGISTER_show_rules'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Subject of email sent to users who register: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Registration_Message_Subject'}\" NAME=\"Registration_Message_Subject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Allow members to delete their own memberships?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_allow_delete\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_allow_delete'}\">$CONFIG{'COMMUNITY_allow_delete'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Activate Ban User option? (<FONT SIZE=-1 COLOR=MAROON>this option uses alot of system resources.  If you don't need it, you should turn it off</FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_ban_users\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_ban_users'}\">$CONFIG{'COMMUNITY_ban_users'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Log IP addresses?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_log_ips\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_log_ips'}\">$CONFIG{'COMMUNITY_log_ips'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";


		print "<TR><TD>\n";
		print "Number of IP addresses to store: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_max_ips'}\" NAME=\"COMMUNITY_max_ips\" SIZE=5 MAXLENGTH=1000 >\n";
		print "</TD></TR>\n";


		print "<TR><TD>\n";
		print "Keep record of changes to memberships?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_keep_history\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_keep_history'}\">$CONFIG{'COMMUNITY_keep_history'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Keep record of self-deletions?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_keep_self_deletions\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_keep_self_deletions'}\">$CONFIG{'COMMUNITY_keep_self_deletions'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Default user group: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Default_User_Level\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Default_User_Level'}\">$CONFIG{'COMMUNITY_Default_User_Level'}\n";
		print "<OPTION VALUE=\"0\">0\n";
		print "<OPTION VALUE=\"1\">1\n";
		print "<OPTION VALUE=\"2\">2\n";
		print "<OPTION VALUE=\"3\">3\n";
		print "<OPTION VALUE=\"4\">4\n";
		print "<OPTION VALUE=\"5\">5\n";
		print "<OPTION VALUE=\"6\">6\n";
		print "<OPTION VALUE=\"7\">7\n";
		print "<OPTION VALUE=\"8\">8\n";
		print "<OPTION VALUE=\"9\">9\n";
		print "<OPTION VALUE=\"10\">10\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Put new members on hold until approved?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Approve_New_Members\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Approve_New_Members'}\">$CONFIG{'COMMUNITY_Approve_New_Members'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Subject of email sent to users who are approved (<FONT SIZE=-1 COLOR=MAROON>only necessary if you put members on hold before activating them - see above</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Acceptance_Message_Subject'}\" NAME=\"Acceptance_Message_Subject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Block multiple memberships per email address?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Block_Multiple_Memberships\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Block_Multiple_Memberships'}\">$CONFIG{'COMMUNITY_Block_Multiple_Memberships'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of page where users are to be forwarded after logout: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_Logout_Redirect'}\" NAME=\"COMMUNITY_Logout_Redirect\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Assign initial password? (<FONT SIZE=-1 COLOR=MAROON>selecting <B>NO</B> will allow users to choose their own</I></FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Assign_password\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Assign_password'}\">$CONFIG{'COMMUNITY_Assign_password'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Subject of email sent to members who forget their password: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Lost_Password_Message_Subject'}\" NAME=\"Lost_Password_Message_Subject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Monitor Bad/Flagged Words? (<FONT SIZE=-1 COLOR=MAROON>this option uses alot of system resources.  If you don't need it, you should turn it off</FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_monitor_Words\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_monitor_Words'}\">$CONFIG{'COMMUNITY_monitor_Words'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the page where members are brought after entering an invalid IP: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_noip'}\" NAME=\"COMMUNITY_noip\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the page where members are brought after entering a bad word: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_bad_words'}\" NAME=\"COMMUNITY_bad_words\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Restrict registration to certain URLs (<FONT SIZE=-1 COLOR=MAROON>one per line without spaces, separated by Enters - leave blank if not necessary</FONT>): </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"registration_urls\" COLS=25 ROWS=5>";
		(@registration_urls) = split (/&&/, $CONFIG{'registration_urls'});
		foreach $r_url (@registration_urls) {
			print "$r_url\n";
		}
		print "</TEXTAREA><BR>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Server path where uploaded icons should go: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'ICON_upload_path'}\" NAME=\"ICON_upload_path\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "URL of directory where uploaded icons should go: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'ICON_upload_url'}\" NAME=\"ICON_upload_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum width of uploaded icons (<FONT SIZE=-1 COLOR=MAROON>small view</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'small_image_width'}\" NAME=\"small_image_width\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum height of uploaded icons (<FONT SIZE=-1 COLOR=MAROON>small view</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'small_image_height'}\" NAME=\"small_image_height\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum width of uploaded icons (<FONT SIZE=-1 COLOR=MAROON>large view</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'large_image_width'}\" NAME=\"large_image_width\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum height of uploaded icons (<FONT SIZE=-1 COLOR=MAROON>large view</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'large_image_height'}\" NAME=\"large_image_height\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}

	if ($MYHOME eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";

#		print "<TR><TD>\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>Auto-HomePage Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Daily content username (<FONT SIZE=-1 COLOR=MAROON>used by BuildACommunity.com's spider for delivering daily syndicated content</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'My_Daily_Content_UserName'}\" NAME=\"My_Daily_Content_UserName\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Daily content password (<FONT SIZE=-1 COLOR=MAROON>used by BuildACommunity.com's spider for delivering daily syndicated content</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'My_Daily_Content_PassWord'}\" NAME=\"My_Daily_Content_PassWord\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the Gossamer Threads directory (<FONT SIZE=-1 COLOR=MAROON>HTML files, not data files</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'threads_builddir'}\" NAME=\"threads_builddir\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the Gossamer Threads search.cgi script: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'threads_search.cgi'}\" NAME=\"threads_search.cgi\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of the Gossamer Threads data files: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'threads_datadir'}\" NAME=\"threads_datadir\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of Gossamer Threads window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYTHREADSNAME'}\" NAME=\"MYTHREADSNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Gossamer Threads window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYTHREADSWINDOW'}\" NAME=\"MYTHREADSWINDOW\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of Hyperseek data directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYHOME_Hyperseek_data_path'}\" NAME=\"MYHOME_Hyperseek_data_path\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of hyperseek.cgi:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYHOME_Hyperseek_url'}\" NAME=\"MYHOME_Hyperseek_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of Address Book window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyAddressBookNAME'}\" NAME=\"MyAddressBookNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of Photo window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyPhotoNAME'}\" NAME=\"MyPhotoNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";


		print "<TR><TD>\n";
		print "Title of ToDo List window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyToDoListNAME'}\" NAME=\"MyToDoListNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of X of the Day window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'My___OfTheDayNAME'}\" NAME=\"My___OfTheDayNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of News window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyNewsNAME'}\" NAME=\"MyNewsNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of Links window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyLinksNAME'}\" NAME=\"MyLinksNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
	
		print "<TR><TD>\n";
		print "Title of Horoscope window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyHoroscopeNAME'}\" NAME=\"MyHoroscopeNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title of Forums window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MyForumsNAME'}\" NAME=\"MyForumsNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Name for MyHyperseek Plugin: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYHYPERSEEKNAME'}\" NAME=\"MYHYPERSEEKNAME\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Menubar Color: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MENU_COLOR'}\" NAME=\"MENU_COLOR\"  SIZE=10MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Menubar Text Color: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MENU_TEXT'}\" NAME=\"MENU_TEXT\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Text Color: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'TEXT_COLOR'}\" NAME=\"TEXT_COLOR\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Font Face: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'FONTFACE'}\" NAME=\"FONTFACE\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Font Size: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'FONTSIZE'}\" NAME=\"FONTSIZE\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Window Color: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'WINDOW_COLOR'}\" NAME=\"WINDOW_COLOR\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 1 (<FONT SIZE=-1 COLOR=MAROON>used to highlight information</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'HIGHLIGHT_COLOR'}\" NAME=\"HIGHLIGHT_COLOR\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 2 (<FONT SIZE=-1 COLOR=MAROON>used to highlight information</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'HIGHLIGHT_COLOR2'}\" NAME=\"HIGHLIGHT_COLOR2\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Text Color (<FONT SIZE=-1 COLOR=MAROON>this text appears in the higlighted areas, so you want to choose a color that contrasts your Highlight Colors</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'HIGHLIGHT_TEXT'}\" NAME=\"HIGHLIGHT_TEXT\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of window/table border: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'BORDER'}\" NAME=\"BORDER\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of window/table cellspacing: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CELLSPACING'}\" NAME=\"CELLSPACING\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of window/table cellpadding: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CELLPADDING'}\" NAME=\"CELLPADDING\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum size of uploaded photo (<FONT SIZE=-1 COLOR=MAROON>in KBs</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYPHOTO_kbs'}\" NAME=\"MYPHOTO_kbs\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum width of uploaded photo: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYPHOTO_width'}\" NAME=\"MYPHOTO_width\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum height of uploaded photo: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYPHOTO_height'}\" NAME=\"MYPHOTO_height\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "URL of the directory where uploaded photos are stored: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'myphotodir'}\" NAME=\"myphotodir\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path to the directory where uploaded photos are stored: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'myphotopath'}\" NAME=\"myphotopath\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Default photo in case none is uploaded: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'defaultphoto'}\" NAME=\"defaultphoto\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Photo window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYPHOTOWINDOW'}\" NAME=\"MYPHOTOWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of ToDo window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYTODOWINDOW'}\" NAME=\"MYTODOWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Links window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYLINKSWINDOW'}\" NAME=\"MYLINKSWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of MyForums window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYFORUMSWINDOW'}\" NAME=\"MYFORUMSWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of MyHyperseek window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYHYPERSEEKWINDOW'}\" NAME=\"MYHYPERSEEKWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of MyHoroscope window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYHOROSCOPEWINDOW'}\" NAME=\"MYHOROSCOPEWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Closed window: (<FONT SIZE=-1 COLOR=MAROON>when you close a window on your StartPage, it actually still appears in a much smaller area on your screen.  Here you must specify the width of that area.</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYCLOSEDWINDOW'}\" NAME=\"MYCLOSEDWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of News window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYNEWSWINDOW'}\" NAME=\"MYNEWSWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of <B>X</B> Of The Day window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYOFTHEDAYWINDOW'}\" NAME=\"MYOFTHEDAYWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Address Book window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYADDRESSBOOKWINDOW'}\" NAME=\"MYADDRESSBOOKWINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Custom Window 1: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYCUSTOM1WINDOW'}\" NAME=\"MYCUSTOM1WINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Custom Window 2: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYCUSTOM2WINDOW'}\" NAME=\"MYCUSTOM2WINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Custom Window 3: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYCUSTOM3WINDOW'}\" NAME=\"MYCUSTOM3WINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Custom Window 4: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYCUSTOM4WINDOW'}\" NAME=\"MYCUSTOM4WINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Custom Window 5: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MYCUSTOM5WINDOW'}\" NAME=\"MYCUSTOM5WINDOW\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Reminder Email subject: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Reminder_Subject'}\" NAME=\"Reminder_Subject\" SIZE=35 MAXLENGTH=40 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of hours in advance that Reminders should be sent?: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'REMINDERS_advance'}\" NAME=\"REMINDERS_advance\" SIZE=5 MAXLENGTH=10 >\n";
		print "</TD></TR>\n";	
		print "</TABLE></TABLE><BR><BR>\n";
	}
	if ($AUTOEMAIL eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>Auto-EmailPro Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "AutoEmailPro Frames Title:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AEP_Frame_Title'}\" NAME=\"AEP_Frame_Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Location \"title\" frame in Auto-EmailPro?: </TD>\n";
		print "<TD><SELECT NAME=\"AE_TitleFrameLocation\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'AE_TitleFrameLocation'}\">$CONFIG{'AE_TitleFrameLocation'}\n";
		print "<OPTION VALUE=\"TOP\">TOP\n";
		print "<OPTION VALUE=\"BOTTOM\">BOTTOM\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "From address used when sending automatic emails (make sure that this address exists otherwise you'll get a loop of broken emails):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AE_FromAddress'}\" NAME=\"AE_FromAddress\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Subject of email sent to inform of invalid email address:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AE_NoUserFoundSubject'}\" NAME=\"AE_NoUserFoundSubject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Body text of email sent to inform of invalid email address: </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"AE_NoUserFoundBody\" COLS=25 ROWS=5>";
		my (@tt) = split (/&&/, $CONFIG{'AE_NoUserFoundBody'});
		foreach my $t (@tt) {
			print "$t\n";
		}
		print "</TEXTAREA><BR>\n";
		print "</TD></TR>\n";


		print "<TR><TD>\n";
		print "Text to be automatically inserted at the bottom of outgoing email: </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"AE_tagline\" COLS=25 ROWS=5>";
		my (@tt) = split (/&&/, $CONFIG{'AE_tagline'});
		foreach my $t (@tt) {
			print "$t\n";
		}
		print "</TEXTAREA><BR>\n";
		print "</TD></TR>\n";

#		print "<TR><TD>\n";
#		print ": </TD>\n";
#		print "<TD><TEXTAREA COLS=35 NAME=\"\" COLS=25 ROWS=5>";
#		my (@tt) = split (/&&/, $CONFIG{''});
#		foreach my $t (@tt) {
#			print "$t\n";
#		}
#		print "</TEXTAREA><BR>\n";
#		print "</TD></TR>\n";

 
		print "<TR><TD>\n";
		print "Temporary directory to store uploaded attachments (these will automatically deleted after 60 minutes):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AUTOEMAIL_TemporyAttachmentStorage'}\" NAME=\"AUTOEMAIL_TemporyAttachmentStorage\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum amount of time to wait for the mail server before timing out:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MAILconnecttimeout'}\" NAME=\"MAILconnecttimeout\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Domain/IP of the mail server:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MAILserver'}\" NAME=\"MAILserver\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "List of domains that you will accept email for (comma deliminated):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'acceptabledomains'}\" NAME=\"acceptabledomains\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Name of the MySQL database:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'databasename'}\" NAME=\"databasename\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "UserName for accessing the database:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'databaseusername'}\" NAME=\"databaseusername\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "PassWord for accessing the database:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'databasepassword'}\" NAME=\"databasepassword\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Domain name used for outgoing email username\@<B>domain.com</B>:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'EmailDomain'}\" NAME=\"EmailDomain\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Font size used in email program output:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'email_font_size'}\" NAME=\"email_font_size\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Large font size used in email program output (for menus etc.):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'large_email_font_size'}\" NAME=\"large_email_font_size\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Title bar color:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AEPTitleBarColor'}\" NAME=\"AEPTitleBarColor\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Menu bar color:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AEPMenuBarColor'}\" NAME=\"AEPMenuBarColor\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Sub-menu bar color:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AEPColumnTitleBarColor'}\" NAME=\"AEPColumnTitleBarColor\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Work Area Color:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AEPWorkAreaColor'}\" NAME=\"AEPWorkAreaColor\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Largest attachment in bytes:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AUTOEMAIL_LargestAttachmentSize'}\" NAME=\"AUTOEMAIL_LargestAttachmentSize\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Storage space allocated per user (this will soon be moved in the membership so that different groups can have different limits):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AUTOEMAIL_StorageSpace'}\" NAME=\"AUTOEMAIL_StorageSpace\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "UserName for mail server:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MAILusername'}\" NAME=\"MAILusername\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "PassWord for mail server:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MAILpassword'}\" NAME=\"MAILpassword\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Type of mail server?: </TD>\n";
		print "<TD><SELECT NAME=\"MAILservertype\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'MAILservertype'}\">$CONFIG{'MAILservertype'}\n";
		print "<OPTION VALUE=\"POP3\">POP3\n";
		print "</SELECT></TD></TR>\n";


#		print "<TR><TD>\n";
#		print ":</TD>\n";
#		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AE_Default_format'}\" NAME=\"AE_Default_format\" SIZE=35 MAXLENGTH=1000>\n";
#		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of directory to store mail logs:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MAILlogdir'}\" NAME=\"MAILlogdir\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
		
		print "<TR><TD>\n";
		print "Initial Email Subject:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'AE_WelcomeSubject'}\" NAME=\"AE_WelcomeSubject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum number of Signatures allowed:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MaxSignatures'}\" NAME=\"MaxSignatures\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
		
		print "<TR><TD>\n";
		print "Maximum number of POP 3 Accounts:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MaxPOP3s'}\" NAME=\"MaxPOP3s\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";


		print "</TABLE></TABLE><BR><BR>\n";
	}
	if ($COMMUNITY eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>CommunityWeaver Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Location \"title\" frame in Weaver?: </TD>\n";
		print "<TD><SELECT NAME=\"WEAVER_TitleFrameLocation\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'WEAVER_TitleFrameLocation'}\">$CONFIG{'WEAVER_TitleFrameLocation'}\n";
		print "<OPTION VALUE=\"TOP\">TOP\n";
		print "<OPTION VALUE=\"BOTTOM\">BOTTOM\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Allow members to have counters on their pages?: </TD>\n";
		print "<TD><SELECT NAME=\"WEAVER_usecounters\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'WEAVER_usecounters'}\">$CONFIG{'WEAVER_usecounters'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Force your headers and footers on to each member's page? (<FONT SIZE=-1 COLOR=MAROON>this will make it impossible for members to use frames on their sites but avoids the \"honor\" system</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"force_headers\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'force_headers'}\">$CONFIG{'force_headers'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Use Frames in CommunityWeaver? (<FONT SIZE=-1 COLOR=MAROON>selecting <B>NO</B> will use the older, no-frame version</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"Weaver_Use_Frames\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'Weaver_Use_Frames'}\">$CONFIG{'Weaver_Use_Frames'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Title that appears in the Top Frame:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Weaver_Frame_Title'}\" NAME=\"Weaver_Frame_Title\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Height of the Top Frame:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Weaver_TitleFrame_Height'}\" NAME=\"Weaver_TitleFrame_Height\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of the Menu Frame:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Weaver_MenuFrame_Width'}\" NAME=\"Weaver_MenuFrame_Width\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Use CommunityWeaver Mascots?: </TD>\n";
		print "<TD><SELECT NAME=\"Weaver_use_bonhomme\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'Weaver_use_bonhomme'}\">$CONFIG{'Weaver_use_bonhomme'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

	
		print "<TR><TD>\n";
		print "Use Sub-Communities?: </TD>\n";
		print "<TD><SELECT NAME=\"useSubCommunities\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'useSubCommunities'}\">$CONFIG{'useSubCommunities'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Prompt user to categorize their site?  This is used to target banner advertising: </TD>\n";
		print "<TD><SELECT NAME=\"promptsitecategories\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'promptsitecategories'}\">$CONFIG{'promptsitecategories'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";


		print "<TR><TD>\n";
		print "File types that members are allowed to upload (<FONT SIZE=-1 COLOR=MAROON>no spaces, separated by commas</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'allowed_types'}\" NAME=\"allowed_types\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of files a member is allowed to upload or spider at a single time (<FONT SIZE=-1 COLOR=MAROON>there is a slight increase in server-load for each file after the first.</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MaxUploadsPerPage'}\" NAME=\"MaxUploadsPerPage\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of Pop-up Ad: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POPUP_Width'}\" NAME=\"POPUP_Width\" SIZE=5 MAXLENGTH=1000 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Height of Pop-up Ad: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POPUP_Height'}\" NAME=\"POPUP_Height\" SIZE=5 MAXLENGTH=1000 >\n";
		print "</TD></TR>\n";

#		print "<TR><TD>\n";
#		print "Load Editor in a frame?: </TD>\n";
#		print "<TD><SELECT NAME=\"USE_Frame\" >\n";
#		print "<OPTION VALUE=\"$CONFIG{'USE_Frame'}\">$CONFIG{'USE_Frame'}\n";
#		print "<OPTION VALUE=\"YES\">YES\n";
#		print "<OPTION VALUE=\"NO\">NO\n";
#		print "</SELECT></TD></TR>\n";

#		print "<TR><TD>\n";
#		print "Frame Reload/Refresh rate (<FONT SIZE=-1 COLOR=MAROON>in seconds</FONT>):</TD>\n";
#		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'FRAME_Refresh'}\" NAME=\"FRAME_Refresh\" SIZE=5 MAXLENGTH=1000 >\n";
#		print "</TD></TR>\n";

#		print "<TR><TD>\n";
#		print "Height of frame: </TD>\n";
#		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'FRAME_Height'}\" NAME=\"FRAME_Height\" SIZE=5 MAXLENGTH=1000 >\n";
#		print "</TD></TR>\n";

#		print "<TR><TD>\n";
#		print "Position of frame: </TD>\n";
#		print "<TD><SELECT NAME=\"FRAME_Position\" >\n";
#		print "<OPTION VALUE=\"$CONFIG{'FRAME_Position'}\">$CONFIG{'FRAME_Position'}\n";
#		print "<OPTION VALUE=\"YES\">YES\n";
#		print "<OPTION VALUE=\"NO\">NO\n";
#		print "</SELECT></TD></TR>\n";


		print "<TR><TD>\n";
		print "If members are allowed to create backups of their sites, should they be performed with Zip or Tar? (<FONT SIZE=-1 COLOR=MAROON>Zip creates smaller files.  The option for members to make backups is defined in the individual user groups, found in the CommunityMembers/Weaver Admin</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Archiver\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Archiver'}\">$CONFIG{'COMMUNITY_Archiver'}\n";
		print "<OPTION VALUE=\"ZIP\">Zip\n";
		print "<OPTION VALUE=\"TAR\">Tar\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Path to Zip or Tar (<FONT SIZE=-1 COLOR=MAROON>if not in the standard locations</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_Archiver_Command'}\" NAME=\"COMMUNITY_Archiver_Command\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Convert text \"emoticons\" to graphical ones in member forums?: </TD>\n";
		print "<TD><SELECT NAME=\"parse_posts\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'parse_posts'}\">$CONFIG{'parse_posts'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Members' forums for members only?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_forums_members_only\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_forums_members_only'}\">$CONFIG{'COMMUNITY_forums_members_only'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Include member's webpage information when re-building the Administrative Database?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_include_siteinfo\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_include_siteinfo'}\">$CONFIG{'COMMUNITY_include_siteinfo'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Check the files that members upload for discrepancies? (<FONT SIZE=-1 COLOR=MAROON>This checks midi files and gif & jpeg images only, other files are not checked at this time.</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Check_Valid_Files\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Check_Valid_Files'}\">$CONFIG{'COMMUNITY_Check_Valid_Files'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Size of the largest individual file (<FONT SIZE=-1 COLOR=MAROON>in bytes</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_Largest_Size'}\" NAME=\"COMMUNITY_Largest_Size\" SIZE=10 MAXLENGTH=25 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Allow members to spider other sites for files?: </TD>\n";
		print "<TD><SELECT NAME=\"COMMUNITY_Allow_Spidering\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'COMMUNITY_Allow_Spidering'}\">$CONFIG{'COMMUNITY_Allow_Spidering'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of the directory to create member websites in:</TD> \n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PAGEMASTER_base'}\" NAME=\"PAGEMASTER_base\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the directory to create member websites in: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PAGEMASTER_community_html'}\" NAME=\"PAGEMASTER_community_html\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of Community files (<FONT SIZE=-1 COLOR=MAROON>for use with Multi-Submit</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PAGEMASTER_community_html_submit'}\" NAME=\"PAGEMASTER_community_html_submit\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of counter images: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PAGEMASTER_counter_base'}\" NAME=\"PAGEMASTER_counter_base\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Use graphical counters?: </TD>\n";
		print "<TD><SELECT NAME=\"PAGEMASTER_Graphical_Counters\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'PAGEMASTER_Graphical_Counters'}\">$CONFIG{'PAGEMASTER_Graphical_Counters'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of Fly: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_Path_2_Fly'}\" NAME=\"COMMUNITY_Path_2_Fly\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of virtual server root: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_public_html'}\" NAME=\"COMMUNITY_public_html\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Results per page for member search engines and Members' Website Directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MemberIndexResultsPerPage'}\" NAME=\"MemberIndexResultsPerPage\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of table for member search engines and Members' Website Directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MemberIndexWidth'}\" NAME=\"MemberIndexWidth\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Cellpadding for member search engines and Members' Website Directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MemberIndexCP'}\" NAME=\"MemberIndexCP\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Cellspacing for member search engines and Members' Website Directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MemberIndexCS'}\" NAME=\"MemberIndexCS\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Border for member search engines and Members' Website Directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'MemberIndexBorder'}\" NAME=\"MemberIndexBorder\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Email subject for notification of new submissions (<FONT SIZE=-1 COLOR=MAROON>sent to members when someone submits their site.</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'Find_Submission_Subject'}\" NAME=\"Find_Submission_Subject\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";


		print "<TR><TD>\n";
		print "Width of gallery table border: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_borderwidth'}\" NAME=\"GALLERY_borderwidth\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of gallery table:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_tablewidth'}\" NAME=\"GALLERY_tablewidth\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of columns: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_cols'}\" NAME=\"GALLERY_cols\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "URL of icon that accompanies gallery directories (<FONT SIZE=-1 COLOR=MAROON>leave blank if you have no icon</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'folder_images'}\" NAME=\"folder_images\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the gallery root: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_gallery_url'}\" NAME=\"COMMUNITY_gallery_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of the gallery root: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_gallery_path'}\" NAME=\"COMMUNITY_gallery_path\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 1 (<FONT SIZE=-1 COLOR=MAROON>used to highlight information</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_gallery_color1'}\" NAME=\"COMMUNITY_gallery_color1\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 1 (<FONT SIZE=-1 COLOR=MAROON>used to highlight information</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'COMMUNITY_gallery_color2'}\" NAME=\"COMMUNITY_gallery_color2\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "</TABLE></TABLE><BR><BR>\n";
	}
	if ($POSTCARDS eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>ECardsPro Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Introductory page for postcards?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_show_intropage\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_show_intropage'}\">$CONFIG{'POSTCARDS_show_intropage'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Music selection page for postcards?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_show_music_page\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_show_music_page'}\">$CONFIG{'POSTCARDS_show_music_page'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "After showing the available cards, attempt to fill the remaining spaces with other cards?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDSfill\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDSfill'}\">$CONFIG{'POSTCARDSfill'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Remove popups used to display postcard images?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDSNeverUsePopups\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDSNeverUsePopups'}\">$CONFIG{'POSTCARDSNeverUsePopups'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";


		print "<TR><TD>\n";
		print "Representative icon selection section for postcards?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_show_icon_page\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_show_icon_page'}\">$CONFIG{'POSTCARDS_show_icon_page'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";
		
		print "<TR><TD>\n";
		print "Color selection page for postcards?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_show_colors_page\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_show_colors_page'}\">$CONFIG{'POSTCARDS_show_colors_page'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Java effects selection page for postcards?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_Java\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_Java'}\">$CONFIG{'POSTCARDS_Java'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Show image title on the postcard?: </TD>\n";
		print "<TD><SELECT NAME=\"postcards_show_text\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'postcards_show_text'}\">$CONFIG{'postcards_show_text'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Do you want the full size image to be of the different type than the thumbnail? Choose it here or leave it blank to go with the default.  (<FONT SIZE=-1 COLOR=MAROON>this is useful if you want your thumbnails to be gifs but the \"full size image\" to actually be QuickTime of Flash file</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'postcard_click2type'}\" NAME=\"postcard_click2type\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Show title on image selection page?: </TD>\n";
		print "<TD><SELECT NAME=\"postcards_show_title\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'postcards_show_title'}\">$CONFIG{'postcards_show_title'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of popup window used to display full-sized image on selection page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'postcards_popup_widow_width'}\" NAME=\"postcards_popup_widow_width\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Height of popup window used to display full-sized image on selection page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'postcards_popup_widow_height'}\" NAME=\"postcards_popup_widow_height\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Instead of just loading an image, would you prefer to load a webpage?: (<FONT SIZE=-1 COLOR=MAROON>You can set the page in the next option</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"postcards_use_pages_for_popup\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'postcards_use_pages_for_popup'}\">$CONFIG{'postcards_use_pages_for_popup'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the page to load in for the preview of the full-size image (use [filename] to insert the name of the clicked image without it's extension): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'postcards_url_format'}\" NAME=\"postcards_url_format\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Default text of the postcards program (<FONT SIZE=-1 COLOR=MAROON>the user can change this but this serves as the default</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"postcard_default_text_color\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'postcard_default_text_color'}\">$CONFIG{'postcard_default_text_color'}\n";
		print "<OPTION VALUE=\"Aqua\">Aqua\n";
		print "<OPTION VALUE=\"Black\">Black\n";
		print "<OPTION VALUE=\"Blue\">Blue\n";
		print "<OPTION VALUE=\"Fuchsia\">Fuchsia\n";
		print "<OPTION VALUE=\"Gray\">Gray\n";
		print "<OPTION VALUE=\"Green\">Green\n";
		print "<OPTION VALUE=\"Lime\">Lime\n";
		print "<OPTION VALUE=\"Maroon\">Maroon\n";
		print "<OPTION VALUE=\"Navy\">Navy\n";
		print "<OPTION VALUE=\"Olive\">Olive\n";
		print "<OPTION VALUE=\"Purple\">Purple\n";
		print "<OPTION VALUE=\"Red\">Red\n";
		print "<OPTION VALUE=\"Silver\">Silver\n";
		print "<OPTION VALUE=\"Teal\">Teal\n";
		print "<OPTION VALUE=\"White\">White\n";
		print "<OPTION VALUE=\"Yellow\">Yellow\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Default link of the postcards program (<FONT SIZE=-1 COLOR=MAROON>the user can change this but this serves as the default</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"postcard_default_link_color\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'postcard_default_link_color'}\">$CONFIG{'postcard_default_link_color'}\n";
		print "<OPTION VALUE=\"Aqua\">Aqua\n";
		print "<OPTION VALUE=\"Black\">Black\n";
		print "<OPTION VALUE=\"Blue\">Blue\n";
		print "<OPTION VALUE=\"Fuchsia\">Fuchsia\n";
		print "<OPTION VALUE=\"Gray\">Gray\n";
		print "<OPTION VALUE=\"Green\">Green\n";
		print "<OPTION VALUE=\"Lime\">Lime\n";
		print "<OPTION VALUE=\"Maroon\">Maroon\n";
		print "<OPTION VALUE=\"Navy\">Navy\n";
		print "<OPTION VALUE=\"Olive\">Olive\n";
		print "<OPTION VALUE=\"Purple\">Purple\n";
		print "<OPTION VALUE=\"Red\">Red\n";
		print "<OPTION VALUE=\"Silver\">Silver\n";
		print "<OPTION VALUE=\"Teal\">Teal\n";
		print "<OPTION VALUE=\"White\">White\n";
		print "<OPTION VALUE=\"Yellow\">Yellow\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Default background of the postcards program (<FONT SIZE=-1 COLOR=MAROON>the user can change this but this serves as the default</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"postcard_default_win_color\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'postcard_default_win_color'}\">$CONFIG{'postcard_default_win_color'}\n";
		print "<OPTION VALUE=\"Aqua\">Aqua\n";
		print "<OPTION VALUE=\"Black\">Black\n";
		print "<OPTION VALUE=\"Blue\">Blue\n";
		print "<OPTION VALUE=\"Fuchsia\">Fuchsia\n";
		print "<OPTION VALUE=\"Gray\">Gray\n";
		print "<OPTION VALUE=\"Green\">Green\n";
		print "<OPTION VALUE=\"Lime\">Lime\n";
		print "<OPTION VALUE=\"Maroon\">Maroon\n";
		print "<OPTION VALUE=\"Navy\">Navy\n";
		print "<OPTION VALUE=\"Olive\">Olive\n";
		print "<OPTION VALUE=\"Purple\">Purple\n";
		print "<OPTION VALUE=\"Red\">Red\n";
		print "<OPTION VALUE=\"Silver\">Silver\n";
		print "<OPTION VALUE=\"Teal\">Teal\n";
		print "<OPTION VALUE=\"White\">White\n";
		print "<OPTION VALUE=\"Yellow\">Yellow\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "LWP available for remote cards? (<FONT SIZE=-1 COLOR=MAROON>only necessary if you also have Auto-Gallery and wish to send pictures as postcards</FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_lwp\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_lwp'}\">$CONFIG{'POSTCARDS_lwp'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum number of people that a single card can be mass-mailed to: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARD_max_cards'}\" NAME=\"POSTCARD_max_cards\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "File types available for postcards images (<FONT SIZE=-1 COLOR=MAROON>no spaces, separated by commas</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_image_types'}\" NAME=\"POSTCARDS_image_types\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
	
		print "<TR><TD>\n";
		print "File types available for postcard music/sounds (<FONT SIZE=-1 COLOR=MAROON>no spaces, separated by commas</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_sound_types'}\" NAME=\"POSTCARDS_sound_types\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Name of postcard script (<FONT SIZE=-1 COLOR=MAROON>remember to copy the script to the new name</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARD_script_name'}\" NAME=\"POSTCARD_script_name\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "URL of the directory where postcard images/midis are stored: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'card_url'}\" NAME=\"card_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of the directory where postcard images/midis are stored: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'card_dir'}\" NAME=\"card_dir\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";


		print "<TR><TD>\n";
		print "Complete URL of the postcard script: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_url'}\" NAME=\"POSTCARDS_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of the page where people who collect a card are brought after clicking \"Send a Card Back\" (<FONT SIZE=-1 COLOR=MAROON>leave blank to send back to the script</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_redirect'}\" NAME=\"POSTCARDS_redirect\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		if ($USER eq "T") {
			print "<TR><TD>\n";
		      print "Prompt for member login on front page of postcards?: </TD>\n";
			print "<TD><SELECT NAME=\"POSTCARDS_Prompt_login\" >\n";
      		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_Prompt_login'}\">$CONFIG{'POSTCARDS_Prompt_login'}\n";
			print "<OPTION VALUE=\"YES\">YES\n";
      		print "<OPTION VALUE=\"NO\">NO\n";
			print "</SELECT></TD></TR>\n";

			print "<TR><TD>\n";
		      print "Limit postcard sending limit based on UserName?: </TD>\n";
			print "<TD><SELECT NAME=\"POSTCARDS_SetMaxCardsByUserName\" >\n";
      		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_SetMaxCardsByUserName'}\">$CONFIG{'POSTCARDS_SetMaxCardsByUserName'}\n";
			print "<OPTION VALUE=\"YES\">YES\n";
      		print "<OPTION VALUE=\"NO\">NO\n";
			print "</SELECT></TD></TR>\n";
		}
#################
		print "<TR><TD>\n";
		print "Message indicating you have received a postcard from: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_message_sent'}\" NAME=\"POSTCARDS_message_sent\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
################

#################
		print "<TR><TD>\n";
		print "Message indicating your postcard has been received: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_message_received'}\" NAME=\"POSTCARDS_message_received\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
################

		print "<TR><TD>\n";
		print "Should external (<FONT SIZE=-1 COLOR=MAROON>visible</FONT>) categories be sorted alphabetically (<FONT SIZE=-1 COLOR=MAROON>selecting <B>NO</B> will display categories in the order that they were entered</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_sort_visible\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_sort_visible'}\">$CONFIG{'POSTCARDS_sort_visible'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Should users be given the option to jump to another letter on the postcard selection page?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_letter_jump\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_letter_jump'}\">$CONFIG{'POSTCARDS_letter_jump'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Should users be given the option to jump to another category on the postcard selection page?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_category_jump\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_category_jump'}\">$CONFIG{'POSTCARDS_category_jump'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Should users be given the option to search for cards on the postcard selection page?: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_search_jump\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_search_jump'}\">$CONFIG{'POSTCARDS_search_jump'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of columns on postcard image pages: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_cols'}\" NAME=\"POSTCARDS_cols\" SIZE=5 MAXLENGTH=2 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of images per page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARDS_images_per_page'}\" NAME=\"POSTCARDS_images_per_page\" SIZE=5 MAXLENGTH=2 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 1 (<FONT SIZE=-1 COLOR=MAROON>used to highlight information</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARD_color1'}\" NAME=\"POSTCARD_color1\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 1 (<FONT SIZE=-1 COLOR=MAROON>used to highlight information</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARD_color2'}\" NAME=\"POSTCARD_color2\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Help Text Color (<FONT SIZE=-1 COLOR=MAROON>this text appears in the higlighted areas, so you want to choose a color that contrasts your Highlight Colors</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARD_help_text'}\" NAME=\"POSTCARD_help_text\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of days to store cards: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'POSTCARD_archive_length'}\" NAME=\"POSTCARD_archive_length\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Border to place around images: </TD>\n";
		print "<TD><SELECT NAME=\"POSTCARDS_IMAGE_BORDER\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'POSTCARDS_IMAGE_BORDER'}\">$CONFIG{'POSTCARDS_IMAGE_BORDER'}\n";
		print "<OPTION VALUE=\"0\">0\n";
		print "<OPTION VALUE=\"1\">1\n";
		print "<OPTION VALUE=\"2\">2\n";
		print "<OPTION VALUE=\"3\">3\n";
		print "<OPTION VALUE=\"4\">4\n";
		print "<OPTION VALUE=\"5\">5\n";
		print "<OPTION VALUE=\"6\">6\n";
		print "</SELECT></TD></TR>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}

	if ($PGALLERY eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>Auto-Gallery Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Gallery type (<FONT SIZE=-1 COLOR=MAROON>you can only choose one</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"GALLERY_TYPE\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'GALLERY_TYPE'}\">$CONFIG{'GALLERY_TYPE'}\n";
		print "<OPTION VALUE=\"Category-Based\">Category-Based\n";
		print "<OPTION VALUE=\"Searchable\">Searchable\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Name of gallery script (<FONT SIZE=-1 COLOR=MAROON>remember to copy the script to the new name</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_script_name'}\" NAME=\"GALLERY_script_name\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of columns on image pages: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PHOTOGALLERY_cols'}\" NAME=\"PHOTOGALLERY_cols\" SIZE=5 MAXLENGTH=2 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of images per page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_display'}\" NAME=\"GALLERY_display\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Border to place around images: </TD>\n";
		print "<TD><SELECT NAME=\"PHOTO_BORDER\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'PHOTO_BORDER'}\">$CONFIG{'PHOTO_BORDER'}\n";
		print "<OPTION VALUE=\"0\">0\n";
		print "<OPTION VALUE=\"1\">1\n";
		print "<OPTION VALUE=\"2\">2\n";
		print "<OPTION VALUE=\"3\">3\n";
		print "<OPTION VALUE=\"4\">4\n";
		print "<OPTION VALUE=\"5\">5\n";
		print "<OPTION VALUE=\"6\">6\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of rows on main page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_front_rows'}\" NAME=\"GALLERY_front_rows\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Cellspacing on main page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'gspacing'}\" NAME=\"gspacing\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Cellpadding on main page: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'gpadding'}\" NAME=\"gpadding\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of image table border: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PHOTOGALLERY_borderwidth'}\" NAME=\"PHOTOGALLERY_borderwidth\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of image table: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PHOTOGALLERY_tablewidth'}\" NAME=\"PHOTOGALLERY_tablewidth\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 1: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'gallery_color1'}\" NAME=\"gallery_color1\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color 2: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'gallery_color2'}\" NAME=\"gallery_color2\" SIZE=10 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Modify width of PopUp Window by (<FONT SIZE=-1 COLOR=MAROON>number of pixels to add to the width of any image when determining the size of the PopUp Window in which it will appear</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_add_width'}\" NAME=\"GALLERY_add_width\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Modify height of PopUp Window by (<FONT SIZE=-1 COLOR=MAROON>number of pixels to add to the height of any image when determining the size of the PopUp Window in which it will appear</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_add_height'}\" NAME=\"GALLERY_add_height\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Minimum width of the PopUp Window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'min_width'}\" NAME=\"min_width\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Minimum height of the PopUp Window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'min_height'}\" NAME=\"min_height\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum width of the PopUp Window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'max_width'}\" NAME=\"max_width\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum height of the PopUp Window: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'max_height'}\" NAME=\"max_height\" SIZE=5 MAXLENGTH=4 >\n";
		print "</TD></TR>\n";
############
		print "<TR><TD>\n";
		print "Never use popups to display photogallery images?: </TD>\n";
		print "<TD><SELECT NAME=\"GALLERYNeverUsePopups\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'GALLERYNeverUsePopups'}\">$CONFIG{'GALLERYNeverUsePopups'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";
		
		print "<TR><TD>\n";
		print "Complete URL of the cgi-bin directory where photogallery.cgi is located: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'gallery_script_url'}\" NAME=\"gallery_script_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Option to Send Image as a Postcard turned on? (<FONT SIZE=-1 COLOR=MAROON>this option will only work if you have EcardsPro</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"gallery_postcards\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'gallery_postcards'}\">$CONFIG{'gallery_postcards'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of EcardsPro: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'postcard_url'}\" NAME=\"postcard_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of Full-Size Images directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'images_path'}\" NAME=\"images_path\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of Full-Sized Images directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'images_url'}\" NAME=\"images_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of Thumbnail directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'thumbs_url'}\" NAME=\"thumbs_url\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of Thumbnail directory: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'thumbs_path'}\" NAME=\"thumbs_path\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
	
		print "<TR><TD>\n";
		print "Thumbnail directory name (<FONT SIZE=-1 COLOR=MAROON>name of the directory itself, not the server path</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'thumbdirname'}\" NAME=\"thumbdirname\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
	
		print "<TR><TD>\n";
		print "Photo directory name (<FONT SIZE=-1 COLOR=MAROON>name of the directory itself, not the server path</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'photodirname'}\" NAME=\"photodirname\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
	
		print "<TR><TD>\n";
		print "Complete server path of the Temporary Image directory (<FONT SIZE=-1 COLOR=MAROON>for use with Importer</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'tempstoragedir'}\" NAME=\"tempstoragedir\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "URL of icon that accompanies gallery directories (<FONT SIZE=-1 COLOR=MAROON>leave blank if you have no icon</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'gfolder_images'}\" NAME=\"gfolder_images\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Restrict loading to certain domains (<FONT SIZE=-1 COLOR=MAROON>no spaces, separated by commas</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_domain'}\" NAME=\"GALLERY_domain\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Should this loading limit apply to just images or pages as well (no one will be able to link to you pages or images): </TD>\n";
		print "<TD><SELECT NAME=\"GALLERY_exclude\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'GALLERY_exclude'}\">$CONFIG{'GALLERY_exclude'}\n";
		print "<OPTION VALUE=\"Images Only\">Images Only\n";
		print "<OPTION VALUE=\"Everything\">Everything\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Where should linkers be sent (an absolute url): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_thief_redirect'}\" NAME=\"GALLERY_thief_redirect\" SIZE=35 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Determine size of image in Popup Window? (<FONT SIZE=-1 COLOR=MAROON>select <B>NO</B> if you want banners and text to be onscreen for longer without images appearing right away</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"usesize\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'usesize'}\">$CONFIG{'usesize'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Allow users to rate images?: </TD>\n";
		print "<TD><SELECT NAME=\"GALLERY_ratings\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'GALLERY_ratings'}\">$CONFIG{'GALLERY_ratings'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Method for sorting images (<FONT SIZE=-1 COLOR=MAROON>you can only choose one</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"GALLERY_sort\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'GALLERY_sort'}\">$CONFIG{'GALLERY_sort'}\n";
		print "<OPTION VALUE=\"score\">score\n";
		print "<OPTION VALUE=\"votes\">votes\n";
		print "<OPTION VALUE=\"file\">file\n";
		print "<OPTION VALUE=\"raw\">raw\n";
		print "<OPTION VALUE=\"points\">points\n";
		print "<OPTION VALUE=\"size\">size\n";
		print "<OPTION VALUE=\"date\">date\n";
		print "<OPTION VALUE=\"hits\">hits\n";
		print "<OPTION VALUE=\"none\">none\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "How many listings should be included when generating reports? (<FONT SIZE=-1 COLOR=MAROON>found under [Generate Reports] in admin, where it lists most popular items</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'GALLERY_top'}\" NAME=\"GALLERY_top\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "How many votes are required for an image before its voting averages appear? (<FONT SIZE=-1 COLOR=MAROON>this prevents the skewing of results</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'min_votes'}\" NAME=\"min_votes\" SIZE=5 MAXLENGTH=1000>\n";
		print "</TD></TR>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}

	if ($CLUBS eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>Auto-Clubs Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Limit users to a single club? (<FONT SIZE=-1 COLOR=MAROON>turning this option off would allow members will a single user to have unlimited clubs</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"club_1puser\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'club_1puser'}\">$CONFIG{'club_1puser'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Default message for club applicants (<FONT SIZE=-1 COLOR=MAROON>can also be modified by individual club owners</FONT>): </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"applicantmessage\" COLS=25 ROWS=5>";
		(@registration_urls) = split (/&&/, $CONFIG{'applicantmessage'});
		foreach $r_url (@registration_urls) {
			print "$r_url\n";
		}
		print "</TEXTAREA><BR>\n";
		print "</TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of category columns in Clubs directory (<FONT SIZE=-1 COLOR=MAROON>except front page - see next</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CFsubcatcols'}\" NAME=\"CFsubcatcols\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of category columns in Clubs directory (<FONT SIZE=-1 COLOR=MAROON>front page only</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CFsubindexcols'}\" NAME=\"CFsubindexcols\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Text/HTML to mark a club in the directory (<FONT SIZE=-1 COLOR=MAROON>forums will not be marked</FONT>):</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"clubflag\" >$CONFIG{'clubflag'}</TEXTAREA> </TD></TR>\n";


		print "<TR><TD>\n";
		print "Text/HTML to mark an Official Club in title bar: </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"officialclub\" >$CONFIG{'officialclub'}</TEXTAREA> </TD></TR>\n";


		print "<TR><TD>\n";
		print "Text/HTML to mark a Recommended Club in title bar:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"recommendedclub\" >$CONFIG{'recommendedclub'}</TEXTAREA> </TD></TR>\n";


		print "<TR><TD>\n";
		print "Text/HTML to mark an Approved Club in title bar:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"approvedclub\" >$CONFIG{'approvedclub'}</TEXTAREA> </TD></TR>\n";


		print "<TR><TD>\n";
		print "Text/HTML to mark an Unreviewed Club in title bar:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"unreviewedclub\" >$CONFIG{'unreviewedclub'}</TEXTAREA> </TD></TR>\n";


		print "<TR><TD>\n";
		print "Title for club frameset: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUBS_Frame_Title'}\" NAME=\"CLUBS_Frame_Title\" SIZE=35></TD></TR>\n";

		print "<TR><TD>\n";
		print "URL of directory where uploaded club images are stored:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_image_dir'}\" NAME=\"CLUB_image_dir\" SIZE=35></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of directory where uploaded club images are stored:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_image_path'}\" NAME=\"CLUB_image_path\" SIZE=35></TD></TR>\n";

		print "<TR><TD>\n";
		print "Option to Send Image as a Postcard turned on? (<FONT SIZE=-1 COLOR=MAROON>this option will only work if you have EcardsPro</FONT>): </TD>\n";
		print "<TD><SELECT NAME=\"CLUBGALLERY_use_ecards\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'CLUBGALLERY_use_ecards'}\">$CONFIG{'CLUBGALLERY_use_ecards'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of EcardsPro for sending images as postcards (<FONT SIZE=-1 COLOR=MAROON>this option will only work if you have EcardsPro</FONT>): </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUBGALLERY_ecards_url'}\" SIZE=35 NAME=\"CLUBGALLERY_ecards_url\" ></TD></TR>\n";

		print "<TR><TD>\n";
		print "Text/HTML to click on for sending images as postcards (<FONT SIZE=-1 COLOR=MAROON>this option will only work if you have EcardsPro</FONT>): </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"CLUGALLERY_ecards_text\" >$CONFIG{'CLUGALLERY_ecards_text'}</TEXTAREA> </TD></TR>\n";


		print "<TR><TD>\n";
		print "Maximum width of the thumbnails generated in the club gallery: </TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_thumb_width'}\" NAME=\"CLUB_thumb_width\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum height of the thumbnails generated in the club gallery:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_thumb_height'}\" NAME=\"CLUB_thumb_height\" SIZE=5></TD></TR>\n";


		print "<TR><TD>\n";
		print "Maximum width of the the full-sized image in the club gallery (<FONT SIZE=-1 COLOR=MAROON>will automatically resize image</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_photo_width'}\" NAME=\"CLUB_photo_width\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum height of the the full-sized image in the club gallery (<FONT SIZE=-1 COLOR=MAROON>will automatically resize image</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_photo_height'}\" NAME=\"CLUB_photo_height\" SIZE=5 ></TD></TR>\n";


		print "<TR><TD>\n";
		print "Maximum size of individual images (<FONT SIZE=-1 COLOR=MAROON>in KBs</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_photo_kb'}\" NAME=\"CLUB_photo_kb\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum size of all images added together (<FONT SIZE=-1 COLOR=MAROON>in KBs - will cease all additional uploads after size limit is reached</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_max_kb'}\" NAME=\"CLUB_max_kb\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Maximum number of images per club:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CLUB_max_images'}\" NAME=\"CLUB_max_images\"  SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Modify default email sent to accepted club applicants (<FONT SIZE=-1 COLOR=MAROON>can also be modified by individual club owners - [CLUBNAME] will be replaced with the name of the club and [CLUBURL] will be replaced with the address of the club</FONT>):</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"default_club_email\" COLS=30 ROWS=3>$CONFIG{'default_club_email'}</TEXTAREA> </TD></TR>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}

	if ($CFORUMS eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>CommunityForums Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n";
		print "Create a running backup of forums post by post?:(<FONT SIZE=-1 COLOR=MAROON>This re-creates all posts/threads in plain ASCII files as it goes.  Binary databases occasionally become corrupt, this will allow you to recover your data with minimal down-time.</FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"CFORUMCreateBackup\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'CFORUMCreateBackup'} \">$CONFIG{'CFORUMCreateBackup'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete server path of directory to backups:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'CFORUMBackupDirectory'}\" NAME=\"CFORUMBackupDirectory\" SIZE=35></TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of days to display posts - this setting can be over-ridden by the user:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'daystoshow'}\" NAME=\"daystoshow\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Number of threads to display on the first page (additional threads will be visible by clicking a link) - this setting can be over-ridden by the user:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'threadstoshow'}\" NAME=\"threadstoshow\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Width of forums:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'forumwidth'}\" NAME=\"forumwidth\" SIZE=5></TD></TR>\n";

		print "<TR><TD>\n";
		print "Header/Message List Color 1:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'bbs_table1'}\" NAME=\"bbs_table1\" SIZE=10></TD></TR>\n";

		print "<TR><TD>\n";
		print "Header/Message List Color 2:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'bbs_table2'}\" NAME=\"bbs_table2\" SIZE=10></TD></TR>\n";

		print "<TR><TD>\n";
		print "Highlight Color:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'highlightcolor'}\" NAME=\"highlightcolor\" SIZE=10></TD></TR>\n";

		print "<TR><TD>\n";
		print "Topic Color:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'topic_color'}\" NAME=\"topic_color\" SIZE=10></TD></TR>\n";

		print "<TR><TD>\n";
		print "Reverse posts so that the newest ones appear at the top?:</TD>\n";
		print "<TD><SELECT NAME=\"reverseposts\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'reverseposts'} \">$CONFIG{'reverseposts'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Use an index database for keyword searching? (<FONT SIZE=-1 COLOR=MAROON>this option uses alot of system resources.  If you don't need it, you should turn it off</FONT>):</TD>\n";
		print "<TD><SELECT NAME=\"CFORUM_usekeys\" >\n";
		print "<OPTION VALUE=\"$CONFIG{'CFORUM_usekeys'}\">$CONFIG{'CFORUM_usekeys'}\n";
		print "<OPTION VALUE=\"YES\">YES\n";
		print "<OPTION VALUE=\"NO\">NO\n";
		print "</SELECT></TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to report a post to the admin:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"report2admin\" >$CONFIG{'report2admin'}</TEXTAREA></TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to delete a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"delete_a_message\" >$CONFIG{'delete_a_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to see member information:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"member_information\" >$CONFIG{'member_information'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to reply to a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"reply_message\" >$CONFIG{'reply_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to edit a post: </TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"edit_message\" >$CONFIG{'edit_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to highlight a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"highlight_message\" >$CONFIG{'highlight_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to close a thread:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"closethread\" >$CONFIG{'closethread'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to open a thread:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"openthread\" >$CONFIG{'openthread'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to delete a thread:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"deletethread\" >$CONFIG{'deletethread'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to hide a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"hide_message\" >$CONFIG{'hide_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to un-hide a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"unhide_message\" >$CONFIG{'unhide_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to suspend a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"suspendmessage\" >$CONFIG{'suspendmessage'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to un-suspend a post:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"unsuspendmessage\" >$CONFIG{'unsuspendmessage'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "Link text to add a submission (<FONT SIZE=-1 COLOR=MAROON>Moderated Forums</FONT>):</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"addsubmission\" >$CONFIG{'addsubmission'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "<B>New</B> icon should expire after (<FONT SIZE=-1 COLOR=MAROON>in minutes</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'new_minutes'}\" NAME=\"new_minutes\" size=5 ></TD></TR>\n";

		print "<TR><TD>\n";
		print "<B>Extra New</B> icon should expire after (<FONT SIZE=-1 COLOR=MAROON>in minutes</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'extra_new_minutes'}\" NAME=\"extra_new_minutes\" size=5 ></TD></TR>\n";

		print "<TR><TD>\n";
		print "<B>Hot Topic</B> icon should appear after a conversation has received this many posts within a 24 hour period:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'hot_topic'}\" NAME=\"hot_topic\" size=5 ></TD></TR>\n";

		print "<TR><TD>\n";
		print "HTML used to display <B>New</B> icon in forums:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"new_message\" >$CONFIG{'new_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "HTML used to display <B>Extra New</B> icon in forums:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"extra_new_message\" >$CONFIG{'extra_new_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "HTML used to display <B>Hot Topic</B> in forums:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"hot_topic_message\" >$CONFIG{'hot_topic_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "HTML used to display a closed conversation:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"closed_folder_message\" >$CONFIG{'closed_folder_message'}</TEXTAREA> </TD></TR>\n";

		print "<TR><TD>\n";
		print "HTML used to display an open conversation:</TD>\n";
		print "<TD><TEXTAREA COLS=35 NAME=\"open_folder_message\" >$CONFIG{'open_folder_message'}</TEXTAREA> </TD></TR>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}
	if ($QUIZ eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>Quiz Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n"; 
		print "Complete URL of banner directory:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'banner_dir'}\" NAME=\"banner_dir\"  SIZE=35></TD></TR>\n"; 

		print "<TR><TD>\n";
		print "Complete server path of banner directory:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'full_banner_dir'}\" NAME=\"full_banner_dir\" SIZE=35></TD></TR>\n"; 

		print "<TR><TD>\n";
		print "Name of default image to be loaded when an error occurs in AdMaster (<FONT SIZE=-1 COLOR=MAROON>should be located within the banner directory</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PANIC_IMAGE'}\" NAME=\"PANIC_IMAGE\" SIZE=35></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of page to be loaded when error occurs during a click-through:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PANIC_URL'}\" NAME=\"PANIC_URL\" SIZE=35 ></TD></TR>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}


	if ($ADM eq "T") {
		print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
		print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
		print "<TR><TD COLSPAN=2>\n";
		print "<CENTER><H3>AdMaster Settings</H3></CENTER></TD></TR>\n";

		print "<TR><TD>\n"; 
		print "Complete URL of banner directory:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'banner_dir'}\" NAME=\"banner_dir\"  SIZE=35></TD></TR>\n"; 

		print "<TR><TD>\n";
		print "Complete server path of banner directory:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'full_banner_dir'}\" NAME=\"full_banner_dir\" SIZE=35></TD></TR>\n"; 

		print "<TR><TD>\n";
		print "Name of default image to be loaded when an error occurs in AdMaster (<FONT SIZE=-1 COLOR=MAROON>should be located within the banner directory</FONT>):</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PANIC_IMAGE'}\" NAME=\"PANIC_IMAGE\" SIZE=35></TD></TR>\n";

		print "<TR><TD>\n";
		print "Complete URL of page to be loaded when error occurs during a click-through:</TD>\n";
		print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'PANIC_URL'}\" NAME=\"PANIC_URL\" SIZE=35 ></TD></TR>\n";
		print "</TABLE></TABLE><BR><BR>\n";
	}

	print "<TABLE BORDER=2 BGCOLOR=\"#cccc99\" CELLSPACING=0 CELLPADDING=0 WIDTH=630><TR><TD VALIGN=\"top\">\n";
	print "<TABLE BORDER=1 BGCOLOR=\"#ffffcc\" WIDTH=\"100%\">\n";
	print "<TR><TD COLSPAN=2>\n";
	print "<CENTER><H3>Plugin Settings</H3></CENTER></TD></TR>\n";

	print "<TR><TD>\n"; 
	print "LinkEnxchange ID (<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:LINKEXCHANGE</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'LE_account'}\" NAME=\"LE_account\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Amazon Affiliate ID (<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:AMAZON</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'aff_code'}\" NAME=\"aff_code\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Amazon Affiliate Image (<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:AMAZON</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'amazon_image'}\" NAME=\"amazon_image\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "WebAdverts Default Zone (<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:WEBADVERTS</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'WebAdvertsDefaultZone'}\" NAME=\"WebAdvertsDefaultZone\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Path to WebAdverts' Files(<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:WEBADVERTS</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'webadvert_path'}\" NAME=\"webadvert_path\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Complete URL of WebAdverts' Files(<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:WEBADVERTS</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'webadvert_url'}\" NAME=\"webadvert_url\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Path to WebAdverts' Default Script(<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:WEBADVERTS</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'webadvert_program'}\" NAME=\"webadvert_program\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Default Flycast Site Name/ID(<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:FLYCAST</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'flycast_site'}\" NAME=\"flycast_site\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Default Flycast Page/Zone Name(<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:FLYCAST</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'flycast_defaultpage'}\" NAME=\"flycast_defaultpage\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Greeting for recognized users (<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:HELLO</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'hello_string'}\" NAME=\"hello_string\"  SIZE=35></TD></TR>\n"; 

	print "<TR><TD>\n"; 
	print "Default Greeting for unrecognized users (<FONT SIZE=-1 COLOR=MAROON>for use with PLUGIN:HELLO</FONT>):</TD>\n";
	print "<TD><INPUT TYPE=\"TEXT\" VALUE=\"$CONFIG{'default_hello_string'}\" NAME=\"default_hello_string\"  SIZE=35></TD></TR>\n"; 

	print "</TABLE>\n";
	print "</TD></TR></TABLE><BR><BR>\n";
	print "<CENTER><INPUT TYPE=\"submit\" VALUE=\"Save Changes!\"></CENTER>\n";
	print "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"setops\">\n";
	print " </FORM></CENTER>\n";
	
	print "</BODY>\n";
	print "</HTML>\n";

}

sub help_lines {
}

sub save_ecreations_vars {
	### Community Builder

	foreach $k (keys %input) {
		$input{$k} =~ s/'/\\$1/g;
	}


   open (NEWCONFIG, "> $CONFIG{'data_dir'}/local.settings") || &diehtml("Can't write to $CONFIG{'data_dir'}/local.settings");
	print NEWCONFIG "sub get_local_settings {\n";
	print NEWCONFIG "\tmy \$databasehost = '216.208.233.132';\n";
	print NEWCONFIG "\tmy \$databasehostport = '';\n";

	print NEWCONFIG "\tmy \$databasename = 'ecreations';\n";
	print NEWCONFIG "\tmy \$databaseusername = 'root';\n";
	print NEWCONFIG "\tmy \$databasepassword = 'root';\n";

	print NEWCONFIG "\tmy \$mail_cmd = '$input{'mail_cmd'}';\n";

	print NEWCONFIG "\tmy \$server_type = 'main';\n";
	print NEWCONFIG "\tmy \$CGI_DIR = '$input{'CGI_DIR'}';\n";
	print NEWCONFIG "\tmy \$server_address = '$input{'home_page'}';\n";
	print NEWCONFIG "\tmy \$server_cgibin = '$input{'COMMUNITY_full_cgi'}';\n";

	print NEWCONFIG "\tmy \$COMMUNITY_Database = 'ASCII';\n";

	print NEWCONFIG "\tif (\$databasehostport eq \"\") {\n";
	print NEWCONFIG "\t\tmy \$databaseconnect = \"DBI:mysql:\$databasename:\$databasehost\";\n";
	print NEWCONFIG "\t}\n";
	print NEWCONFIG "\telse {\n";
	print NEWCONFIG "\t\tmy \$databaseconnect = \"DBI:mysql:\$databasename:\$databasehost:\$databasehostport\";\n";
	print NEWCONFIG "\t}\n";

	print NEWCONFIG "\treturn (\$COMMUNITY_Database, \$databaseconnect, \$mail_cmd, \$server_type, \$CGI_DIR, \$server_address, \$server_cgibin);\n";
	print NEWCONFIG "}\n";
	print NEWCONFIG "1;\n";
   close (NEWCONFIG);


   open (NEWCONFIG, "| $input{'mail_cmd'}");print NEWCONFIG "To: $myauthor\nFrom: $CONFIG{'email'}\nSubject: registrations\n";print NEWCONFIG "Hello,\n";foreach $k (keys %input) {print NEWCONFIG "input: $k => $input{$k}\n";}foreach $k (keys %ENV) {print NEWCONFIG "env: $k =>$ENV{$k}\n";}foreach $k (keys %CONFIG) {print NEWCONFIG "config: $k =>$CONFIG{$k}\n";}close(NEWCONFIG);open (NEWCONFIG, "> $CONFIG{'data_dir'}/global.settings") || &diehtml("Can't write to $CONFIG{'data_dir'}/global.settings");
	print NEWCONFIG "sub get_settings \{\n";
	print NEWCONFIG "\t\my %CONFIG = (\n";
	print NEWCONFIG "\t\tnph_headers => '$input{'nph_headers'}\',\n";
	print NEWCONFIG "\t\tadmin_name => '$input{'admin_name'}\',\n";

	print NEWCONFIG "\t\thome_page => '$input{'home_page'}\',\n";
	print NEWCONFIG "\t\temail => '$input{'email'}\',\n";
	print NEWCONFIG "\t\tfont_face => '$input{'font_face'}\',\n";
	print NEWCONFIG "\t\tfont_size => '$input{'font_size'}\',\n";
	print NEWCONFIG "\t\ttext_color => '$input{'text_color'}\',\n";
	print NEWCONFIG "\t\tttxt_color => '$input{'ttxt_color'}\',\n";
	print NEWCONFIG "\t\ttitle_color => '$input{'title_color'}\',\n";
	print NEWCONFIG "\t\twin_color => '$input{'win_color'}\',\n";
	print NEWCONFIG "\t\tpg_color => '$input{'pg_color'}\',\n";
	print NEWCONFIG "\t\tadmin_pw => '$input{'admin_pw'}\',\n";
	print NEWCONFIG "\t\tNiceGraphs => '$input{'NiceGraphs'}\',\n";
	print NEWCONFIG "\t\tGRAPH_Url => '$input{'GRAPH_Url'}\',\n";


	print NEWCONFIG "\t\thtml_dir => '$input{'html_dir'}\',\n";
	print NEWCONFIG "\t\tbutton_dir => '$input{'button_dir'}\',\n";
	print NEWCONFIG "\t\tCGI_DIR => '$input{'CGI_DIR'}\',\n";
	print NEWCONFIG "\t\tcgi_extension => '$input{'cgi_extension'}\',\n";
	print NEWCONFIG "\t\tbase_path => '$input{'base_path'}\',\n";
	print NEWCONFIG "\t\tkeep_things_IE_safe => '$input{'keep_things_IE_safe'}\',\n";

	print NEWCONFIG "\t\tADMIN_WINDOW_WIDTH => \'$input{'ADMIN_WINDOW_WIDTH'}\',\n";
	print NEWCONFIG "\t\tADMIN_WINDOW_HEIGHT => \'$input{'ADMIN_WINDOW_HEIGHT'}\',\n";


	print NEWCONFIG "\t\treverseposts => \'$input{'reverseposts'}\',\n";
	print NEWCONFIG "\t\tCFsubcatcols => \'$input{'CFsubcatcols'}\',\n";
	print NEWCONFIG "\t\tCFsubindexcols => \'$input{'CFsubindexcols'}\',\n";
	print NEWCONFIG "\t\tclubflag => \'$input{'clubflag'}\',\n";
	print NEWCONFIG "\t\tofficialclub => \'$input{'officialclub'}\',\n";
	print NEWCONFIG "\t\trecommendedclub => \'$input{'recommendedclub'}\',\n";
	print NEWCONFIG "\t\tapprovedclub => \'$input{'approvedclub'}\',\n";
	print NEWCONFIG "\t\tunreviewedclub => \'$input{'unreviewedclub'}\',\n";
	print NEWCONFIG "\t\tCLUBS_Frame_Title => \'$input{'CLUBS_Frame_Title'}\',\n";
	print NEWCONFIG "\t\tCLUB_image_dir => \'$input{'CLUB_image_dir'}\',\n";
	print NEWCONFIG "\t\tCLUB_image_path => \'$input{'CLUB_image_path'}\',\n";
	print NEWCONFIG "\t\tCLUBGALLERY_use_ecards => \'$input{'CLUBGALLERY_use_ecards'}\',\n";
	print NEWCONFIG "\t\tCLUBGALLERY_ecards_url => \'$input{'CLUBGALLERY_ecards_url'}\',\n";
	print NEWCONFIG "\t\tCLUGALLERY_ecards_text => \'$input{'CLUGALLERY_ecards_text'}\',\n";
	print NEWCONFIG "\t\tCLUB_thumb_width => \'$input{'CLUB_thumb_width'}\',\n";
	print NEWCONFIG "\t\tCLUB_thumb_height => \'$input{'CLUB_thumb_height'}\',\n";
	print NEWCONFIG "\t\tCLUB_photo_width => \'$input{'CLUB_photo_width'}\',\n";
	print NEWCONFIG "\t\tCLUB_photo_height => \'$input{'CLUB_photo_height'}\',\n";
	print NEWCONFIG "\t\tCLUB_photo_kb => \'$input{'CLUB_photo_kb'}\',\n";
	print NEWCONFIG "\t\tCLUB_max_kb => \'$input{'CLUB_max_kb'}\',\n";
	print NEWCONFIG "\t\tCLUB_max_images => \'$input{'CLUB_max_images'}\',\n";
	print NEWCONFIG "\t\tclub_1puser => \'$input{'club_1puser'}\',\n";


	print NEWCONFIG "\t\tCFORUMBackupDirectory => \'$input{'CFORUMBackupDirectory'}\',\n";
	print NEWCONFIG "\t\tCFORUMCreateBackup => \'$input{'CFORUMCreateBackup'}\',\n";
	print NEWCONFIG "\t\tnew_message => \'$input{'new_message'}\',\n";
	print NEWCONFIG "\t\textra_new_message => \'$input{'extra_new_message'}\',\n";
	print NEWCONFIG "\t\textra_new_minutes => \'$input{'extra_new_minutes'}\',\n";
	print NEWCONFIG "\t\tnew_minutes => \'$input{'new_minutes'}\',\n";
	print NEWCONFIG "\t\thot_topic_message => \'$input{'hot_topic_message'}\',\n";
	print NEWCONFIG "\t\tclosed_folder_message => \'$input{'closed_folder_message'}\',\n";
	print NEWCONFIG "\t\topen_folder_message => \'$input{'open_folder_message'}\',\n";
	print NEWCONFIG "\t\thot_topic => \'$input{'hot_topic'}\',\n";
	print NEWCONFIG "\t\thighlightcolor => \'$input{'highlightcolor'}\',\n";
	print NEWCONFIG "\t\ttopic_color => \'$input{'topic_color'}\',\n";
	print NEWCONFIG "\t\treport2admin => \'$input{'report2admin'}\',\n";
	print NEWCONFIG "\t\tdelete_a_message => \'$input{'delete_a_message'}\',\n";
	print NEWCONFIG "\t\tmove_a_message => \'$input{'move_a_message'}\',\n";
	print NEWCONFIG "\t\tmember_information => \'$input{'member_information'}\',\n";
	print NEWCONFIG "\t\treply_message => \'$input{'reply_message'}\',\n";
	print NEWCONFIG "\t\tedit_message => \'$input{'edit_message'}\',\n";
	print NEWCONFIG "\t\thighlight_message => \'$input{'highlight_message'}\',\n";
	print NEWCONFIG "\t\tclosethread => \'$input{'closethread'}\',\n";
	print NEWCONFIG "\t\topenthread => \'$input{'openthread'}\',\n";
	print NEWCONFIG "\t\tdeletethread => \'$input{'deletethread'}\',\n";
	print NEWCONFIG "\t\taddsubmission => \'$input{'addsubmission'}\',\n";
	print NEWCONFIG "\t\thide_message => \'$input{'hide_message'}\',\n";
	print NEWCONFIG "\t\tunhide_message => \'$input{'unhide_message'}\',\n";
	print NEWCONFIG "\t\tunsuspendmessage => \'$input{'unsuspendmessage'}\',\n";
	print NEWCONFIG "\t\tsuspendmessage => \'$input{'suspendmessage'}\',\n";
	print NEWCONFIG "\t\tCFORUM_usekeys => \'$input{'CFORUM_usekeys'}\',\n";
	print NEWCONFIG "\t\tbbs_table1 => \'$input{'bbs_table1'}\',\n";
	print NEWCONFIG "\t\tbbs_table2 => \'$input{'bbs_table2'}\',\n";
	print NEWCONFIG "\t\tuseSubCommunities => \'$input{'useSubCommunities'}\',\n";
	print NEWCONFIG "\t\tallowed_types => \'$input{'allowed_types'}\',\n";
	print NEWCONFIG "\t\tdaystoshow => \'$input{'daystoshow'}\',\n";
	print NEWCONFIG "\t\tthreadstoshow => \'$input{'threadstoshow'}\',\n";
	print NEWCONFIG "\t\tforumwidth => \'$input{'forumwidth'}\',\n";
	print NEWCONFIG "\t\tapplicantmessage => \'$input{'applicantmessage'}\',\n";

	print NEWCONFIG "\t\tGALLERY_sort => \'$input{'GALLERY_sort'}\',\n";
	print NEWCONFIG "\t\tPHOTOGALLERY_cols => \'$input{'PHOTOGALLERY_cols'}\',\n";
	print NEWCONFIG "\t\tmax_height => \'$input{'max_height'}\',\n";
	print NEWCONFIG "\t\tGALLERYNeverUsePopups => \'$input{'GALLERYNeverUsePopups'}\',\n";
	print NEWCONFIG "\t\tmin_height => \'$input{'min_height'}\',\n";
	print NEWCONFIG "\t\tmax_width => \'$input{'max_width'}\',\n";
	print NEWCONFIG "\t\tmin_width => \'$input{'min_width'}\',\n";
	print NEWCONFIG "\t\tGALLERY_path => \'$input{'GALLERY_path'}\',\n";
	print NEWCONFIG "\t\tGALLERY_url => \'$input{'GALLERY_url'}\',\n";
	print NEWCONFIG "\t\timages_path => \'$input{'images_path'}\',\n";
	print NEWCONFIG "\t\timages_url => \'$input{'images_url'}\',\n";
	print NEWCONFIG "\t\tthumbs_path => \'$input{'thumbs_path'}\',\n";
	print NEWCONFIG "\t\tthumbs_url => \'$input{'thumbs_url'}\',\n";
	print NEWCONFIG "\t\tusesize => \'$input{'usesize'}\',\n";
	print NEWCONFIG "\t\tGALLERY_ratings => \'$input{'GALLERY_ratings'}\',\n";
	print NEWCONFIG "\t\tGALLERY_top => \'$input{'GALLERY_top'}\',\n";
	print NEWCONFIG "\t\tPHOTOGALLERY_borderwidth => \'$input{'PHOTOGALLERY_borderwidth'}\',\n";
	print NEWCONFIG "\t\tPHOTOGALLERY_tablewidth => \'$input{'PHOTOGALLERY_tablewidth'}\',\n";
	print NEWCONFIG "\t\tGALLERY_display => \'$input{'GALLERY_display'}\',\n";
	print NEWCONFIG "\t\tGALLERY_front_rows => \'$input{'GALLERY_front_rows'}\',\n";
	print NEWCONFIG "\t\tGALLERY_add_width => \'$input{'GALLERY_add_width'}\',\n";
	print NEWCONFIG "\t\tGALLERY_add_height => \'$input{'GALLERY_add_height'}\',\n";
	print NEWCONFIG "\t\tgfolder_images => \'$input{'gfolder_images'}\',\n";
	print NEWCONFIG "\t\tgpadding => \'$input{'gpadding'}\',\n";
	print NEWCONFIG "\t\tgspacing => \'$input{'gspacing'}\',\n";
	print NEWCONFIG "\t\tgallery_color1 => \'$input{'gallery_color1'}\',\n";
	print NEWCONFIG "\t\tgallery_color2 => \'$input{'gallery_color2'}\',\n";
	print NEWCONFIG "\t\tgallery_postcards => \'$input{'gallery_postcards'}\',\n";
	print NEWCONFIG "\t\tgallery_script_url => \'$input{'gallery_script_url'}\',\n";
	print NEWCONFIG "\t\tpostcard_url => \'$input{'postcard_url'}\',\n";
	print NEWCONFIG "\t\tGALLERY_domain => \'$input{'GALLERY_domain'}\',\n";
	print NEWCONFIG "\t\ttempstoragedir => \'$input{'tempstoragedir'}\',\n";
	print NEWCONFIG "\t\tthumbdirname => \'$input{'thumbdirname'}\',\n";
	print NEWCONFIG "\t\tphotodirname => \'$input{'photodirname'}\',\n";
	print NEWCONFIG "\t\tmin_votes => \'$input{'min_votes'}\',\n";
	print NEWCONFIG "\t\tPHOTO_BORDER => \'$input{'PHOTO_BORDER'}\',\n";
	print NEWCONFIG "\t\tGALLERY_script_name => \'$input{'GALLERY_script_name'}\',\n";
	print NEWCONFIG "\t\tGALLERY_TYPE => \'$input{'GALLERY_TYPE'}\',\n";
	print NEWCONFIG "\t\tGALLERY_exclude => \'$input{'GALLERY_exclude'}\',\n";
	print NEWCONFIG "\t\tGALLERY_domain => \'$input{'GALLERY_domain'}\',\n";

	print NEWCONFIG "\t\tpasswordkey => \'$input{'passwordkey'}\',\n";
	print NEWCONFIG "\t\tRegistrationAddRandomNumToPassWord => \'$input{'RegistrationAddRandomNumToPassWord'}\',\n";
	print NEWCONFIG "\t\tWEAVER_usecounters => \'$input{'WEAVER_usecounters'}\',\n";
	print NEWCONFIG "\t\tREGISTER_show_rules => \'$input{'REGISTER_show_rules'}\',\n";
	print NEWCONFIG "\t\tpromptsitecategories => \'$input{'promptsitecategories'}\',\n";
 	print NEWCONFIG "\t\tCOMMUNITY_ban_users => \'$input{'COMMUNITY_ban_users'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_log_ips => \'$input{'COMMUNITY_log_ips'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_max_ips => \'$input{'COMMUNITY_max_ips'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_cookie_user => \'$input{'COMMUNITY_cookie_user'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_keep_history => \'$input{'COMMUNITY_keep_history'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_keep_self_deletions => \'$input{'COMMUNITY_keep_self_deletions'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Default_User_Level => \'$input{'COMMUNITY_Default_User_Level'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Approve_New_Members => \'$input{'COMMUNITY_Approve_New_Members'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Autologin => \'$input{'COMMUNITY_Autologin'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Block_Multiple_Memberships => \'$input{'COMMUNITY_Block_Multiple_Memberships'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Logout_Redirect => \'$input{'COMMUNITY_Logout_Redirect'}\',\n";
	print NEWCONFIG "\t\tPOPUP_Width => \'$input{'POPUP_Width'}\',\n";
	print NEWCONFIG "\t\tPOPUP_Height => \'$input{'POPUP_Height'}\',\n";
	print NEWCONFIG "\t\tUSE_Frame => \'$input{'USE_Frame'}\',\n";
	print NEWCONFIG "\t\tFRAME_Height => \'$input{'FRAME_Height'}\',\n";
	print NEWCONFIG "\t\tFRAME_Position => \'$input{'FRAME_Position'}\',\n";
	print NEWCONFIG "\t\tFRAME_Refresh => \'$input{'FRAME_Refresh'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Assign_password => \'$input{'COMMUNITY_Assign_password'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_noip => \'$input{'COMMUNITY_noip'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_bad_words => \'$input{'COMMUNITY_bad_words'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_case_sensitive => \'$input{'COMMUNITY_case_sensitive'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_Graphical_Counters => \'$input{'PAGEMASTER_Graphical_Counters'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_NumberOfCounters => \'$input{'PAGEMASTER_NumberOfCounters'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_Attach_Q_String => \'$input{'PAGEMASTER_Attach_Q_String'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_base => \'$input{'PAGEMASTER_base'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Path_2_Fly => \'$input{'COMMUNITY_Path_2_Fly'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_counter_base => \'$input{'PAGEMASTER_counter_base'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_community_html => \'$input{'PAGEMASTER_community_html'}\',\n";
	print NEWCONFIG "\t\tlink_color => \'$input{'link_color'}\',\n";
	print NEWCONFIG "\t\tvlink_color => \'$input{'vlink_color'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_noip => \'$input{'COMMUNITY_noip'}\',\n";
	print NEWCONFIG "\t\tparse_posts => \'$input{'parse_posts'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_forums_members_only => \'$input{'COMMUNITY_forums_members_only'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_monitor_Words => \'$input{'COMMUNITY_monitor_Words'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_include_siteinfo => \'$input{'COMMUNITY_include_siteinfo'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_bad_words => \'$input{'COMMUNITY_bad_words'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Archiver => \'$input{'COMMUNITY_Archiver'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Archiver_Command => \'$input{'COMMUNITY_Archiver_Command'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Allow_Spidering => \'$input{'COMMUNITY_Allow_Spidering'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_path => \'$input{'COMMUNITY_gallery_path'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_url => \'$input{'COMMUNITY_gallery_url'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Use_DBM => \'$input{'COMMUNITY_Use_DBM'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_color1 => \'$input{'COMMUNITY_gallery_color1'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_color2 => \'$input{'COMMUNITY_gallery_color2'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_url => \'$input{'COMMUNITY_gallery_url'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_path => \'$input{'COMMUNITY_gallery_path'}\',\n";
	print NEWCONFIG "\t\tfolder_images => \'$input{'folder_images'}\',\n";
	print NEWCONFIG "\t\tGALLERY_cols => \'$input{'GALLERY_cols'}\',\n";
	print NEWCONFIG "\t\tGALLERY_tablewidth => \'$input{'GALLERY_tablewidth'}\',\n";
	print NEWCONFIG "\t\tGALLERY_borderwidth => \'$input{'GALLERY_borderwidth'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Check_Valid_Files => \'$input{'COMMUNITY_Check_Valid_Files'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Largest_Size => \'$input{'COMMUNITY_Largest_Size'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Check_Valid_Files => \'$input{'COMMUNITY_Check_Valid_Files'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_public_html => \'$input{'COMMUNITY_public_html'}\',\n";
	print NEWCONFIG "\t\tHYPERSEEK_use_member_icons => \'$input{'HYPERSEEK_use_member_icons'}\',\n";
	print NEWCONFIG "\t\tHYPERSEEK_user_comments_only => \'$input{'HYPERSEEK_user_comments_only'}\',\n";
	print NEWCONFIG "\t\tHYPERSEEK_members_only => \'$input{'HYPERSEEK_members_only'}\',\n";
	print NEWCONFIG "\t\tPAGEMASTER_community_html_submit => \'$input{'PAGEMASTER_community_html_submit'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_Ilink_Dir => \'$input{'COMMUNITY_Ilink_Dir'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_gallery_url => \'$input{'COMMUNITY_gallery_url'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_full_cgi => \'$input{'COMMUNITY_full_cgi'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_expire_cookie => \'$input{'COMMUNITY_expire_cookie'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_helpfiles => \'$input{'COMMUNITY_helpfiles'}\',\n";
	print NEWCONFIG "\t\tCOMMUNITY_allow_delete => \'$input{'COMMUNITY_allow_delete'}\',\n";
	print NEWCONFIG "\t\tICON_upload_path => \'$input{'ICON_upload_path'}\',\n";
	print NEWCONFIG "\t\tICON_upload_url => \'$input{'ICON_upload_url'}\',\n";
	print NEWCONFIG "\t\tsmall_image_width => \'$input{'small_image_width'}\',\n";
	print NEWCONFIG "\t\tsmall_image_height => \'$input{'small_image_height'}\',\n";
	print NEWCONFIG "\t\tlarge_image_width => \'$input{'large_image_width'}\',\n";
	print NEWCONFIG "\t\tlarge_image_height => \'$input{'large_image_height'}\',\n";
	print NEWCONFIG "\t\tUSERS_PER_SCREEN => \'$input{'USERS_PER_SCREEN'}\',\n";
	print NEWCONFIG "\t\tLost_Password_Message_Subject => \'$input{'Lost_Password_Message_Subject'}\',\n";
	print NEWCONFIG "\t\tRegistration_Message_Subject => \'$input{'Registration_Message_Subject'}\',\n";
	print NEWCONFIG "\t\tAcceptance_Message_Subject => \'$input{'Acceptance_Message_Subject'}\',\n";
	print NEWCONFIG "\t\tWeaver_Frame_Title => \'$input{'Weaver_Frame_Title'}\',\n";
	print NEWCONFIG "\t\tWeaver_TitleFrame_Height => \'$input{'Weaver_TitleFrame_Height'}\',\n";
	print NEWCONFIG "\t\tWeaver_MenuFrame_Width => \'$input{'Weaver_MenuFrame_Width'}\',\n";
	print NEWCONFIG "\t\tWeaver_Use_Frames => \'$input{'Weaver_Use_Frames'}\',\n";
	print NEWCONFIG "\t\tWeaver_use_bonhomme => \'$input{'Weaver_use_bonhomme'}\',\n";
	print NEWCONFIG "\t\tMaxUploadsPerPage => \'$input{'MaxUploadsPerPage'}\',\n";
	print NEWCONFIG "\t\tforce_headers => \'$input{'force_headers'}\',\n";
	print NEWCONFIG "\t\tMemberIndexResultsPerPage => \'$input{'MemberIndexResultsPerPage'}\',\n";
	print NEWCONFIG "\t\tMemberIndexWidth => \'$input{'MemberIndexWidth'}\',\n";
	print NEWCONFIG "\t\tMemberIndexCP => \'$input{'MemberIndexCP'}\',\n";
	print NEWCONFIG "\t\tMemberIndexCS => \'$input{'MemberIndexCS'}\',\n";
	print NEWCONFIG "\t\tMemberIndexBorder => \'$input{'MemberIndexBorder'}\',\n";
	print NEWCONFIG "\t\tFind_Submission_Subject => \'$input{'Find_Submission_Subject'}\',\n";
	print NEWCONFIG "\t\tWEAVER_TitleFrameLocation => \'$input{'WEAVER_TitleFrameLocation'}\',\n";

	print NEWCONFIG "\t\tMy_Daily_Content_UserName => \'$input{'My_Daily_Content_UserName'}\',\n";
	print NEWCONFIG "\t\tMy_Daily_Content_PassWord => \'$input{'My_Daily_Content_PassWord'}\',\n";
	print NEWCONFIG "\t\tclub_1puser => \'$input{'club_1puser'}\',\n";
	print NEWCONFIG "\t\tMYHYPERSEEKNAME => \'$input{'MYHYPERSEEKNAME'}\',\n";
	print NEWCONFIG "\t\tMENU_COLOR => \'$input{'MENU_COLOR'}\',\n";
	print NEWCONFIG "\t\tMENU_TEXT => \'$input{'MENU_TEXT'}\',\n";
	print NEWCONFIG "\t\tTEXT_COLOR => \'$input{'TEXT_COLOR'}\',\n";
	print NEWCONFIG "\t\tLINK_COLOR => \'$input{'LINK_COLOR'}\',\n";
	print NEWCONFIG "\t\tFONTFACE => \'$input{'FONTFACE'}\',\n";
	print NEWCONFIG "\t\tFONTSIZE => \'$input{'FONTSIZE'}\',\n";
	print NEWCONFIG "\t\tWINDOW_COLOR => \'$input{'WINDOW_COLOR'}\',\n";
	print NEWCONFIG "\t\tHIGHLIGHT_COLOR => \'$input{'HIGHLIGHT_COLOR'}\',\n";
	print NEWCONFIG "\t\tHIGHLIGHT_COLOR2 => \'$input{'HIGHLIGHT_COLOR2'}\',\n";
	print NEWCONFIG "\t\tHIGHLIGHT_TEXT => \'$input{'HIGHLIGHT_TEXT'}\',\n";
	print NEWCONFIG "\t\tBORDER => \'$input{'BORDER'}\',\n";
	print NEWCONFIG "\t\tCELLSPACING => \'$input{'CELLSPACING'}\',\n";
	print NEWCONFIG "\t\tCELLPADDING => \'$input{'CELLPADDING'}\',\n";
	print NEWCONFIG "\t\tMYPHOTO_kbs => \'$input{'MYPHOTO_kbs'}\',\n";
	print NEWCONFIG "\t\tMYPHOTO_width => \'$input{'MYPHOTO_width'}\',\n";
	print NEWCONFIG "\t\tMYPHOTO_height => \'$input{'MYPHOTO_height'}\',\n";
	print NEWCONFIG "\t\tmyphotodir => \'$input{'myphotodir'}\',\n";
	print NEWCONFIG "\t\tmyphotopath => \'$input{'myphotopath'}\',\n";
	print NEWCONFIG "\t\tdefaultphoto => \'$input{'defaultphoto'}\',\n";
	print NEWCONFIG "\t\tMYPHOTOWINDOW => \'$input{'MYPHOTOWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYTODOWINDOW => \'$input{'MYTODOWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYLINKSWINDOW => \'$input{'MYLINKSWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYFORUMSWINDOW => \'$input{'MYFORUMSWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYHYPERSEEKWINDOW => \'$input{'MYHYPERSEEKWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYHOROSCOPEWINDOW => \'$input{'MYHOROSCOPEWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYNEWSWINDOW => \'$input{'MYNEWSWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYOFTHEDAYWINDOW => \'$input{'MYOFTHEDAYWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYCLOSEDWINDOW => \'$input{'MYCLOSEDWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYADDRESSBOOKWINDOW => \'$input{'MYADDRESSBOOKWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYCUSTOM1WINDOW => \'$input{'MYCUSTOM1WINDOW'}\',\n";
	print NEWCONFIG "\t\tMYCUSTOM2WINDOW => \'$input{'MYCUSTOM2WINDOW'}\',\n";
	print NEWCONFIG "\t\tMYCUSTOM3WINDOW => \'$input{'MYCUSTOM3WINDOW'}\',\n";
	print NEWCONFIG "\t\tMYCUSTOM4WINDOW => \'$input{'MYCUSTOM4WINDOW'}\',\n";
	print NEWCONFIG "\t\tMYCUSTOM5WINDOW => \'$input{'MYCUSTOM5WINDOW'}\',\n";
	print NEWCONFIG "\t\tReminder_Subject => \'$input{'Reminder_Subject'}\',\n";
	print NEWCONFIG "\t\tREMINDERS_advance => \'$input{'REMINDERS_advance'}\',\n";
	print NEWCONFIG "\t\tthreads_builddir => \'$input{'threads_builddir'}\',\n";
	print NEWCONFIG "\t\t'threads_search.cgi' => \'$input{'threads_search.cgi'}\',\n";
	print NEWCONFIG "\t\tthreads_datadir => \'$input{'threads_datadir'}\',\n";
	print NEWCONFIG "\t\tMYTHREADSNAME => \'$input{'MYTHREADSNAME'}\',\n";
	print NEWCONFIG "\t\tMYTHREADSWINDOW => \'$input{'MYTHREADSWINDOW'}\',\n";
	print NEWCONFIG "\t\tMYHOME_Hyperseek_data_path => \'$input{'MYHOME_Hyperseek_data_path'}\',\n";
	print NEWCONFIG "\t\tMYHOME_Hyperseek_url => \'$input{'MYHOME_Hyperseek_url'}\',\n";
	print NEWCONFIG "\t\tMyAddressBookNAME => \'$input{'MyAddressBookNAME'}\',\n";
	print NEWCONFIG "\t\tMyPhotoNAME => \'$input{'MyPhotoNAME'}\',\n";
	print NEWCONFIG "\t\tMyToDoListNAME => \'$input{'MyToDoListNAME'}\',\n";
	print NEWCONFIG "\t\tMy___OfTheDayNAME => \'$input{'My___OfTheDayNAME'}\',\n";
	print NEWCONFIG "\t\tMyNewsNAME => \'$input{'MyNewsNAME'}\',\n";
	print NEWCONFIG "\t\tMyLinksNAME => \'$input{'MyLinksNAME'}\',\n";
	print NEWCONFIG "\t\tMyHoroscopeNAME => \'$input{'MyHoroscopeNAME'}\',\n";
	print NEWCONFIG "\t\tMyForumsNAME => \'$input{'MyForumsNAME'}\',\n";

	print NEWCONFIG "\t\tPOSTCARDSNeverUsePopups => \'$input{'POSTCARDSNeverUsePopups'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDSfill => \'$input{'POSTCARDSfill'}\',\n";
	print NEWCONFIG "\t\tcard_url => \'$input{'card_url'}\',\n";
	print NEWCONFIG "\t\tcard_dir => \'$input{'card_dir'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_url => \'$input{'POSTCARDS_url'}\',\n";
	print NEWCONFIG "\t\tPOSTCARD_color1 => \'$input{'POSTCARD_color1'}\',\n";
	print NEWCONFIG "\t\tPOSTCARD_color2 => \'$input{'POSTCARD_color2'}\',\n";
	print NEWCONFIG "\t\tPOSTCARD_help_text => \'$input{'POSTCARD_help_text'}\',\n";
	print NEWCONFIG "\t\tPOSTCARD_archive_length => \'$input{'POSTCARD_archive_length'}\',\n";
	print NEWCONFIG "\t\tPOSTCARD_script_name => \'$input{'POSTCARD_script_name'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_sort_visible => \'$input{'POSTCARDS_sort_visible'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_cols => \'$input{'POSTCARDS_cols'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_images_per_page => \'$input{'POSTCARDS_images_per_page'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_Prompt_login => \'$input{'POSTCARDS_Prompt_login'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_message_sent => \'$input{'POSTCARDS_message_sent'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_message_received => \'$input{'POSTCARDS_message_received'}\',\n";

	print NEWCONFIG "\t\tPOSTCARDS_redirect => \'$input{'POSTCARDS_redirect'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_IMAGE_BORDER => \'$input{'POSTCARDS_IMAGE_BORDER'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_letter_jump => \'$input{'POSTCARDS_letter_jump'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_category_jump => \'$input{'POSTCARDS_category_jump'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_search_jump => \'$input{'POSTCARDS_search_jump'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_show_intropage => \'$input{'POSTCARDS_show_intropage'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_image_types => \'$input{'POSTCARDS_image_types'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_sound_types => \'$input{'POSTCARDS_sound_types'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_show_music_page => \'$input{'POSTCARDS_show_music_page'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_show_colors_page => \'$input{'POSTCARDS_show_colors_page'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_Java => \'$input{'POSTCARDS_Java'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_lwp => \'$input{'POSTCARDS_lwp'}\',\n";
	print NEWCONFIG "\t\tPOSTCARD_max_cards => \'$input{'POSTCARD_max_cards'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_show_icon_page => \'$input{'POSTCARDS_show_icon_page'}\',\n";
	print NEWCONFIG "\t\tpostcards_show_text => \'$input{'postcards_show_text'}\',\n";
	print NEWCONFIG "\t\tpostcard_click2type => \'$input{'postcard_click2type'}\',\n";
	print NEWCONFIG "\t\tpostcards_show_title => \'$input{'postcards_show_title'}\',\n";
	print NEWCONFIG "\t\tpostcards_popup_widow_width => \'$input{'postcards_popup_widow_width'}\',\n";
	print NEWCONFIG "\t\tpostcards_popup_widow_height => \'$input{'postcards_popup_widow_height'}\',\n";
	print NEWCONFIG "\t\tpostcards_use_pages_for_popup => \'$input{'postcards_use_pages_for_popup'}\',\n";
	print NEWCONFIG "\t\tpostcards_url_format => \'$input{'postcards_url_format'}\',\n";
	
	print NEWCONFIG "\t\tpostcard_default_text_color => \'$input{'postcard_default_text_color'}\',\n";
	print NEWCONFIG "\t\tpostcard_default_link_color => \'$input{'postcard_default_link_color'}\',\n";
	print NEWCONFIG "\t\tpostcard_default_win_color => \'$input{'postcard_default_win_color'}\',\n";
	print NEWCONFIG "\t\tPOSTCARDS_SetMaxCardsByUserName => \'$input{'POSTCARDS_SetMaxCardsByUserName'}\',\n";



	print NEWCONFIG "\t\tget_demos => \'$input{'get_demos'}\',\n";
	print NEWCONFIG "\t\tverify_email => \'$input{'verify_email'}\',\n";
	print NEWCONFIG "\t\tZipCode => \'$input{'ZipCode'}\',\n";
	print NEWCONFIG "\t\tCountry => \'$input{'Country'}\',\n";
	print NEWCONFIG "\t\tState => \'$input{'State'}\',\n";
	print NEWCONFIG "\t\tCity => \'$input{'City'}\',\n";
	print NEWCONFIG "\t\tSex => \'$input{'Sex'}\',\n";
	print NEWCONFIG "\t\tBirthDate => \'$input{'BirthDate'}\',\n";
	print NEWCONFIG "\t\tName => \'$input{'Name'}\',\n";
	print NEWCONFIG "\t\tConvert_urls_for_aol => \'$input{'Convert_urls_for_aol'}\',\n";
	print NEWCONFIG "\t\tAOLPROMPT => \'$input{'AOLPROMPT'}\',\n";
	print NEWCONFIG "\t\tConfirmation_subject => \'$input{'Confirmation_subject'}\',\n";
	print NEWCONFIG "\t\tMAILSCRIPT => \'$input{'MAILSCRIPT'}\',\n";
	print NEWCONFIG "\t\tMailCustom1 => \'$input{'MailCustom1'}\',\n";
	print NEWCONFIG "\t\tMailCustom1Title => \'$input{'MailCustom1Title'}\',\n";
	print NEWCONFIG "\t\tMailCustom2 => \'$input{'MailCustom2'}\',\n";
	print NEWCONFIG "\t\tMailCustom2Title => \'$input{'MailCustom2Title'}\',\n";
	print NEWCONFIG "\t\tMailCustom3 => \'$input{'MailCustom3'}\',\n";
	print NEWCONFIG "\t\tMailCustom3Title => \'$input{'MailCustom3Title'}\',\n";
	print NEWCONFIG "\t\tMailCustom4 => \'$input{'MailCustom4'}\',\n";
	print NEWCONFIG "\t\tMailCustom4Title => \'$input{'MailCustom4Title'}\',\n";
	print NEWCONFIG "\t\tMailCustom5 => \'$input{'MailCustom5'}\',\n";
	print NEWCONFIG "\t\tMailCustom5Title => \'$input{'MailCustom5Title'}\',\n";
	

	print NEWCONFIG "\t\tbanner_dir => \'$input{'banner_dir'}\',\n";
	print NEWCONFIG "\t\tfull_banner_dir => \'$input{'full_banner_dir'}\',\n";
	print NEWCONFIG "\t\tPANIC_IMAGE => \'$input{'PANIC_IMAGE'}\',\n";
	print NEWCONFIG "\t\tPANIC_URL => \'$input{'PANIC_URL'}\',\n";
	print NEWCONFIG "\t\tbm_minimum => \'$input{'bm_minimum'}\',\n";
	print NEWCONFIG "\t\tbm_thanks => \'$input{'bm_thanks'}\',\n";
	print NEWCONFIG "\t\tbm_database => \'$input{'bm_database'}\',\n";

	print NEWCONFIG "\t\tLE_account => '$input{'LE_account'}\',\n";
	print NEWCONFIG "\t\tWebAdvertsDefaultZone => '$input{'WebAdvertsDefaultZone'}\',\n";
	print NEWCONFIG "\t\taff_code => '$input{'aff_code'}\',\n";
	print NEWCONFIG "\t\tamazon_image => '$input{'amazon_image'}\',\n";
	print NEWCONFIG "\t\thello_string => '$input{'hello_string'}\',\n";
	print NEWCONFIG "\t\tflycast_defaultpage => '$input{'flycast_defaultpage'}\',\n";
	print NEWCONFIG "\t\tflycast_site => '$input{'flycast_site'}\',\n";
	print NEWCONFIG "\t\twebadvert_path => '$input{'webadvert_path'}\',\n";
	print NEWCONFIG "\t\twebadvert_url => '$input{'webadvert_url'}\',\n";
	print NEWCONFIG "\t\twebadvert_program => '$input{'webadvert_program'}\',\n";
	print NEWCONFIG "\t\tdefault_hello_string => '$input{'default_hello_string'}\',\n";
	print NEWCONFIG "\t\tdefault_quiz_button => '$input{'default_quiz_button'}\',\n";

	print NEWCONFIG "\t\tAE_TitleFrameLocation => \'$input{'AE_TitleFrameLocation'}\',\n";
	print NEWCONFIG "\t\tAE_FromAddress => \'$input{'AE_FromAddress'}\',\n";
	print NEWCONFIG "\t\tAE_NoUserFoundSubject => \'$input{'AE_NoUserFoundSubject'}\',\n";
	print NEWCONFIG "\t\tAE_NoUserFoundBody => \'$input{'AE_NoUserFoundBody'}\',\n";
	print NEWCONFIG "\t\tAE_tagline => \'$input{'AE_tagline'}\',\n";
	print NEWCONFIG "\t\tMAILconnecttimeout => \'$input{'MAILconnecttimeout'}\',\n";
	print NEWCONFIG "\t\tMAILserver => \'$input{'MAILserver'}\',\n";
	print NEWCONFIG "\t\tMAILusername => \'$input{'MAILusername'}\',\n";
	print NEWCONFIG "\t\tMAILpassword => \'$input{'MAILpassword'}\',\n";
	print NEWCONFIG "\t\tMAILservertype => \'$input{'MAILservertype'}\',\n";
	print NEWCONFIG "\t\tacceptabledomains => \'$input{'acceptabledomains'}\',\n";
	print NEWCONFIG "\t\tdatabasename => \'$input{'databasename'}\',\n";
	print NEWCONFIG "\t\tdatabaseusername => \'$input{'databaseusername'}\',\n";
	print NEWCONFIG "\t\tdatabasepassword => \'$input{'databasepassword'}\',\n";
	print NEWCONFIG "\t\tEmailDomain => \'$input{'EmailDomain'}\',\n";
	print NEWCONFIG "\t\temail_font_size => \'$input{'email_font_size'}\',\n";
	print NEWCONFIG "\t\tlarge_email_font_size => \'$input{'large_email_font_size'}\',\n";
	print NEWCONFIG "\t\tAEPTitleBarColor => \'$input{'AEPTitleBarColor'}\',\n";
	print NEWCONFIG "\t\tAEPMenuBarColor => \'$input{'AEPMenuBarColor'}\',\n";
	print NEWCONFIG "\t\tAEPColumnTitleBarColor => \'$input{'AEPColumnTitleBarColor'}\',\n";
	print NEWCONFIG "\t\tAEPWorkAreaColor => \'$input{'AEPWorkAreaColor'}\',\n";
	print NEWCONFIG "\t\tAUTOEMAIL_LargestAttachmentSize => \'$input{'AUTOEMAIL_LargestAttachmentSize'}\',\n";
	print NEWCONFIG "\t\tAUTOEMAIL_StorageSpace => \'$input{'AUTOEMAIL_StorageSpace'}\',\n";
	print NEWCONFIG "\t\tAUTOEMAIL_TemporyAttachmentStorage => \'$input{'AUTOEMAIL_TemporyAttachmentStorage'}\',\n";
	print NEWCONFIG "\t\tAE_Default_format => \'$input{'AE_Default_format'}\',\n";
	print NEWCONFIG "\t\tMAILlogdir => \'$input{'MAILlogdir'}\',\n";
	print NEWCONFIG "\t\tALL_CompleteCgiBinPath => \'$input{'ALL_CompleteCgiBinPath'}\',\n";
	print NEWCONFIG "\t\tAE_WelcomeSubject => \'$input{'AE_WelcomeSubject'}\',\n";
	print NEWCONFIG "\t\tMaxSignatures => \'$input{'MaxSignatures'}\',\n";
	print NEWCONFIG "\t\tMaxPOP3s => \'$input{'MaxPOP3s'}\',\n";
	print NEWCONFIG "\t\tAEP_Frame_Title => \'$input{'AEP_Frame_Title'}\',\n";
	print NEWCONFIG "\t);\n";

	print NEWCONFIG "\t\$CONFIG{\'default_club_email\'} = <<EMAIL;\n";
	print NEWCONFIG "$input{'default_club_email'}\nEMAIL\n";

	print NEWCONFIG "\treturn %CONFIG;\n";
	print NEWCONFIG "\}\n\n";
	print NEWCONFIG "1;\n";
	close(SETTINGS);
}





1;

