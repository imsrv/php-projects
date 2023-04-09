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
use DB_File;
use Time::Local;

require "./common.pm";
require "$GPath{'community_admin.pm'}";

require "$GPath{'community_data'}/levels.pm";
require "$GPath{'community_data'}/list.pm";
require "$GPath{'community_data'}/fields.pm";


$PROGRAM_NAME = "community_admin.cgi";
$max_groups = 10;

&Validate_Admin_Local;


&parse_FORM;

	$databasefile = $GPath{'userpath'} . "/database\.txt";
	$users_file = "$GPath{'userpath'}/users.txt";

if (($FORM{'action'} eq "admin") || ($FORM{'action'} eq "")) {
	&create_frame;
}


if ($FORM{'action'} eq "main") {
	&main;
}

if ($FORM{'action'} eq "Save Thank You Page") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_thank_you_page;
}

if ($FORM{'action'} eq "edit_thank_you_page") {
	&edit_thank_you_page;
}

if ($FORM{'action'} eq "Start The Backup") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&create_backup;
}


if ($FORM{'action'} eq "view_members_on_hold") {
	&view_members_on_hold;
}

if ($FORM{'action'} eq "mass_mail") {
	&mass_mail;
}

if ($FORM{'action'} eq "Send This Mail") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&send_mail;
}

if ($FORM{'action'} eq "view_user_warnings") {
	&view_user_warnings;
}

if ($FORM{'action'} eq "user0") {
	&view0users;
}

if ($FORM{'action'} eq "Save Frame Version") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_weaver_frames;
}

if ($FORM{'action'} eq "Edit Weaver Frames") {
	&edit_weaver_frames;
}


if ($FORM{'action'} eq "edit_hints") {
	&edit_hints;
}

if ($FORM{'action'} eq "setup_rules") {
	&setup_rules;
}

if ($FORM{'action'} eq "save_rules") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_rules;
}

if ($FORM{'action'} eq "Save Hints") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_hints;
}

if ($FORM{'action'} eq "menu") {
	&menu;
}

if ($FORM{'action'} eq "edit_emails") {
	&edit_emails;
}

if ($FORM{'action'} eq "delete_logs") {
	&list_logs;
}

if ($FORM{'action'} eq "delete_log") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&delete_log;
}

if ($FORM{'action'} eq "backup_menu") {
	&backup_menu;
}

if ($FORM{'action'} eq "edit_profile_text") {
	&edit_profile_text;
}

if ($FORM{'action'} eq "Save Database Fields") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_fields;
}

if ($FORM{'action'} eq "Save Profile Text") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_profile_text;
}

if ($FORM{'action'} eq "Save Template") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_template;
}

if ($FORM{'action'} eq "Save User Groups") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_user_level;
}

if ($FORM{'action'} eq "view_inactive_options") {
	&view_inactive_options;
}

if ($FORM{'action'} eq "View Inactive Members") {
	&view_inactive_members;
}

if ($FORM{'action'} eq "Edit Text") {
	&edit_top_bottom;
}

if ($FORM{'action'} eq "Save Popup") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_popup;
}

if ($FORM{'action'} eq "Save Text") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_top_bottom;
}

if ($FORM{'action'} eq "Edit Pop-Up Setup") {
	&edit_popup;
}

if ($FORM{'action'} eq "Edit BBS Header Setup") {
	&edit_bbs_banner;
}

if ($FORM{'action'} eq "Save BBS Header") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_bbs_banner;
}

if ($FORM{'action'} eq "setup_fields") {
	&setup_fields;
}

if ($FORM{'action'} eq "view_failed_logins") {
	&view_failed_logins;
}

if (($FORM{'action'} eq "view_user_levels") || ($FORM{'action'} eq "Edit Groups")) {
	&view_user_levels;
}

if ($FORM{'action'} eq "Save Email Text") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_emails;
}

if ($FORM{'action'} eq "edit_templates") {
	&edit_templates;
}

if ($FORM{'action'} eq "Open Template") {
	&open_templates;
}

if ($FORM{'action'} eq "edit_banned_list") {
	&edit_banned_users;
}

if ($FORM{'action'} eq "Save Banned List") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_banned_users;
}
if ($FORM{'action'} eq "CreateAdmGroups") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&CreateAdmGroups;
}
if ($FORM{'action'} eq "webpage_headers_footers") {
	&edit_footers_headers;
}

if ($FORM{'action'} eq "EditPassWords") {
	&edit_passwords;
}

if ($FORM{'action'} eq "EditWords") {
	&edit_badwords;
}

if ($FORM{'action'} eq "Save PassWords") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_passwords;
}

if ($FORM{'action'} eq "Save Words") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_badwords;
}

if ($FORM{'action'} eq "edit_frame") {
	&edit_frame;
}

if ($FORM{'action'} eq "Save Frame") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&save_frame;
}

if ($FORM{'action'} eq "generate_reports") {
	&simple_reports;
}

if ($FORM{'action'} eq "reports") {
	&view_report_options;
}

if ($FORM{'action'} eq "Update Webiste with New Variables") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&update_webpage;
}

if ($FORM{'action'} eq "search") {
  	print "Content-type: text/html\n\n";
	&search_box;
	exit;
}


if ($FORM{'action'} eq "view_details") {
	&view_member($FORM{'UserNum'},$FORM{'UserName'});
}


if ($FORM{'action'} =~ /Search/) {
	if (($FORM{'method'} eq "less") || ($FORM{'method'} eq "less")) {
		if (($FORM{'fields'} eq "username") || ($FORM{'fields'} eq "email") || ($FORM{'fields'} eq "url") ||($FORM{'fields'} eq "screen_info") || ($FORM{'fields'} eq "phone_numbers") ||($FORM{'fields'} eq "address") ||($FORM{'fields'} eq "sex") ||($FORM{'fields'} eq "zipcode")) {
			&ADMIN_error("bad_method");
		}
	}
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<FONT SIZE=1>All search results are drawn from the Administrative Database.  If it hasn't been re-built recently, recent changes will not appear and the information may be somewhat outdated.</FONT><BR><BR>\n";
	print "<H2>CommunityWeaver</H2>\n";

	($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$databasefile");
	&parse_date($mtime);
	print "The Current Admin Database was rebuilt at $long_date.  <A HREF=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=build_db\');\">Re-Build The Database</A>?\n";
	&view_members;
print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wCommunityWindow=window.open(Loc,"wCommunityWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wCommunityWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT
	exit;
}


if ($FORM{'action'} eq "view_communities") {
	&view_communities;
}

if ($FORM{'action'} eq "Save Communities") {
	&save_communities;
}



if ($FORM{'action'} eq "build_db") {
	$| = 1;
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	&build_database;
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#cccc99><B>Database Updated</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "<B>The Database has been refreshed with the most current information available.  Changes made from this moment on will not appear until you update again.  There are currently $actualusers members.</B>\n";



	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}

print "Content-type: text/html\n\n";
print "Something did not work!\n";
exit;


sub edit_templates {
  	print "Content-type: text/html\n\n";
	print "<CENTER><HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD><CENTER><H3>Edit Community Templates</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<SELECT NAME=\"template2edit\">\n";
	print "<OPTION VALUE=\"cb_default.txt\">CommunityWeaver Default</OPTION>\n";
	print "<OPTION VALUE=\"forms.txt\">Webpage Editor</OPTION>\n";
	print "<OPTION VALUE=\"gallery.txt\">Image Gallery</OPTION>\n";
	print "<OPTION VALUE=\"log_reports.txt\">Member's Log Reports</OPTION>\n";
	print "<OPTION VALUE=\"member.txt\">Member Page (About Me Page)</OPTION>\n";
	print "<OPTION VALUE=\"error.txt\">Error Template</OPTION>\n";
	print "<OPTION VALUE=\"create.txt\">Webpage Creation Template (Terms of Use etc.)</OPTION>\n";
	print "<OPTION VALUE=\"help.txt\">Help Pages</OPTION>\n";
	print "<OPTION VALUE=\"login.txt\">Login Page</OPTION>\n";
	print "<OPTION VALUE=\"profile.txt\">Profile / Member's Page</OPTION>\n";
	print "<OPTION VALUE=\"upload.txt\">Uploaded Files Page</OPTION>\n";
	print "<OPTION VALUE=\"register.txt\">Registration Pages</OPTION>\n";
	print "<OPTION VALUE=\"change_level.txt\">Member-Group Change Page</OPTION>\n";
	print "</SELECT>\n";
	print "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"Open Template\">\n";
	print "<INPUT TYPE=SUBMIT VALUE=\"Open Template!\">\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE></CENTER>\n";
      print "<BR><BR><B><CENTER><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub view_failed_logins {
	$fn = "$GPath{'community_data'}/failed.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@FAILED = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD COLSPAN=5><CENTER><H3>View Failed Logins</H3></TD></TR>\n";
	print "<TR>\n";
	print "<TD><B>Time</B></TD>\n";
	print "<TD><B>Host</B></TD>\n";
	print "<TD><B>Attempted UserName</B></TD>\n";
	print "<TD><B>Attempted PassWord</B></TD>\n";
	print "<TD><B>Script Name</B></TD>\n";
	print "</TR>\n";

	foreach $line (@FAILED) {
		($failed_time,$host,$UserName,$PassWord,$PROGRAM_NAME) = split(/\|\|/, $line);
		print "<TR>\n";
		&parse_date($failed_time);
		print "<TD>$date</TD>\n";
		print "<TD>$host</TD>\n";
		print "<TD><A HREF=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=view_details&UserNum=$USER_num&UserName=$UserName\');\">$UserName</A></TD>\n";
		print "<TD>$PassWord</TD>\n";
		print "<TD>$PROGRAM_NAME</TD>\n";
		print "</TR>\n";
	
	}
	print "</TABLE>\n";
     	print "<BR><BR><B><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	exit;
}


sub view_user_warnings {
	$fn = "$GPath{'community_data'}/flags.txt";
	open(FILE, "$fn") || &diehtml("I can't read $fn");
 		@FAILED = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD COLSPAN=5><CENTER><H3>View Warnings To Members</H3></TD></TR>\n";
	print "<TR>\n";
	print "<TR>\n";
	print "<TD COLSPAN=5>These warnings were generated by the use of words in the /data/watchwords.txt file or by member's not including the PLUGIN:HEADER in their manually edited pages (this my be okay if they are using the page as a menu bar within frames, it is best to check visually).\n";
	print "</TD></TR>\n";
	print "<TR>\n";
	print "<TD><B>Time</B></TD>\n";
	print "<TD><B>Host</B></TD>\n";
	print "<TD><B>UserName</B></TD>\n";
	print "<TD><B>Problem</B></TD>\n";
	print "<TD><B>Script Name</B></TD>\n";
	print "</TR>\n";

	foreach $line (@FAILED) {
		($failed_time,$host,$UserName,$PassWord,$PROGRAM_NAME) = split(/\|\|/, $line);
		print "<TR>\n";
		&parse_date($failed_time);
		print "<TD>$date</TD>\n";
		print "<TD>$host</TD>\n";
		print "<TD><A HREF=\"javascript:OpenWin(\'$GUrl{'community_admin.cgi'}?action=view_details&UserNum=$USER_num&UserName=$UserName\');\">$UserName</A></TD>\n";
		print "<TD>$PassWord</TD>\n";
		print "<TD>$PROGRAM_NAME</TD>\n";
		print "</TR>\n";
	}
	print "</TABLE>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";

	exit;
}


sub view_user_levels {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>View / Edit User Groups</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<P>You can define $max_groups user groups and the permissions and privileges that accompany each of them.\n";
	print "Every member is assigned a group (set in the <A HREF=\"$GUrl{'eadmin.cgi'}?action=config\" target=\"NEW\">Configuration Section</A>) when they sign up.  You can change the user's group at any time from the Admin.  This will affect what they are ";
	print "allowed to do on your site. ";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";

	if (($FORM{'group'} ne "") && ($FORM{'group'} ne "Options")) {
		print "<INPUT TYPE=hidden NAME=\"MOVE_MAX\" VALUE=\"$MOVE_MAX\">\n";
		print "<INPUT TYPE=hidden NAME=\"ALLOW_ZERO_MOVE\" VALUE=\"$ALLOW_ZERO_MOVE\">\n";
	}
	else {
		print "<TABLE BORDER=5 WIDTH=100%>\n";
		print "<TR><TD>\n";
		print "<P>You may want to allow members to switch between groups without your involvement.\n";
		&get_priveledges;
		print "<P>What is the maximum group (level) that a member can jump to?<BR><SELECT NAME=\"MOVE_MAX\">\n";
	   	for $x(0 .. $max_groups) {
			if ($MOVE_MAX eq "$x") {
				print "<OPTION VALUE=$x SELECTED>$x</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=$x>$x</OPTION>\n";
			}
		}
		print "</SELECT>\n";

		print "<P>Can they move up from zero or do they need to wait until they have been raised manually by you?<BR><SELECT NAME=\"ALLOW_ZERO_MOVE\">\n";
		if ($ALLOW_ZERO_MOVE eq "YES") {
			print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
		}
		else {
			print "<OPTION VALUE=YES>YES</OPTION>\n";
		}
		if ($ALLOW_ZERO_MOVE eq "NO") {
			print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
		}
		else {
			print "<OPTION VALUE=NO>NO</OPTION>\n";
		}
		print "</SELECT>\n";
		print "</TD></TR>\n";
		print "</TABLE>\n";
	}

	print "<P>\n";

   	for $x(0 .. $max_groups) {
		$IUSER{'user_level'} = $x;
		&get_priveledges($x);
		if (($FORM{'group'} ne "") && ($FORM{'group'} ne $x)) {
			print "<INPUT TYPE=hidden NAME=\"Max_Pages_$x\" VALUE=\"$Max_Pages\">\n";
			print "<INPUT TYPE=hidden NAME=\"Allow_Image_Uploads_$x\" VALUE=\"$Allow_Image_Uploads\">\n";
			print "<INPUT TYPE=hidden NAME=\"Max_Files_$x\" VALUE=\"$Max_Files\">\n";
			print "<INPUT TYPE=hidden NAME=\"Max_Bytes_$x\" VALUE=\"$Max_Bytes\">\n";
			print "<INPUT TYPE=hidden NAME=\"Post_In_Forums_$x\" VALUE=\"$Post_In_Forums\">\n";
			print "<INPUT TYPE=hidden NAME=\"Create_Forums_$x\" VALUE=\"$Create_Forums\">\n";
			print "<INPUT TYPE=hidden NAME=\"Add_Postcards_$x\" VALUE=\"$Add_Postcards\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_Allow_SE_Submission_$x\" VALUE=\"$COMMUNITY_Allow_SE_Submission\">\n";
			print "<INPUT TYPE=hidden NAME=\"Simple_Search_$x\" VALUE=\"$Simple_Search\">\n";
			print "<INPUT TYPE=hidden NAME=\"Add_Quiz_$x\" VALUE=\"$Add_Quiz\">\n";
			print "<INPUT TYPE=hidden NAME=\"Admin_Webring_$x\" VALUE=\"$Admin_Webring\">\n";
			print "<INPUT TYPE=hidden NAME=\"headerfile_$x\" VALUE=\"$headerfile\">\n";
			print "<INPUT TYPE=hidden NAME=\"footerfile_$x\" VALUE=\"$footerfile\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_Allow_GB_$x\" VALUE=\"$COMMUNITY_Allow_GB\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_allow_Free4All_$x\" VALUE=\"$COMMUNITY_allow_Free4All\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_Allow_Voting_$x\" VALUE=\"$COMMUNITY_Allow_Voting\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_Allow_Form2Email_$x\" VALUE=\"$COMMUNITY_Allow_Form2Email\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_Allow_Backup_$x\" VALUE=\"$COMMUNITY_Allow_Backup\">\n";
			print "<INPUT TYPE=hidden NAME=\"COMMUNITY_allow_direct_edit_$x\" VALUE=\"$COMMUNITY_allow_direct_edit\">\n";
			print "<INPUT TYPE=hidden NAME=\"Hit_Logs_$x\" VALUE=\"$Hit_Logs\">\n";
			print "<INPUT TYPE=hidden NAME=\"Hit_Logs_Storage_$x\" VALUE=\"$Hit_Logs_Storage\" VALUE=\"$Hit_Logs_Storage\">\n";
			print "<INPUT TYPE=hidden NAME=\"Create_Ilinks_$x\" VALUE=\"$Create_Ilinks\">\n";
			print "<INPUT TYPE=hidden NAME=\"POSTCARD_max_cards_$x\" VALUE=\"$'POSTCARD_max_cards\" VALUE=\"$POSTCARD_max_cards\">\n";
		}
		else {
			print "<TABLE BORDER=5><TR><TD COLSPAN=2>\n";
			print "<H3>User Group $x</H3>\n";
			print "</TD></TR>\n";
			print "<TR><TD VALIGN=TOP>\n";
			print "<P>Maximum Number Of Files (there are internal files that are included in this number so your should usually add about 140% the number of pages you wish to actually provide):<BR><INPUT TYPE=TEXT SIZE=5 NAME=\"Max_Files_$x\" VALUE=\"$Max_Files\">\n";
			print "</TD>\n";


			print "<TD VALIGN=TOP>\n";
			print "<P>Are members allowed to upload images? <BR><SELECT NAME=\"Allow_Image_Uploads_$x\">\n";
			if ($Allow_Image_Uploads eq "YES") {
				print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=YES>YES</OPTION>\n";
			}
			if ($Allow_Image_Uploads eq "NO") {
				print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=NO>NO</OPTION>\n";
			}
			print "</SELECT>\n";
			print "</TD></TR>\n";


			print "<TR><TD>\n";
			print "<P>Maximum Bytes For Upload (1000 bytes/kilobyte):<BR><INPUT TYPE=TEXT SIZE=5 NAME=\"Max_Bytes_$x\" VALUE=\"$Max_Bytes\">\n";
			print "</TD><TD>\n";
			print "<P>Post in Existing Forums:<BR><SELECT NAME=\"Post_In_Forums_$x\">\n";
				if ($Post_In_Forums eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($Post_In_Forums eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD></TR><TR><TD>\n";

			print "<P>Create Forums?:<BR><SELECT NAME=\"Create_Forums_$x\">\n";
				if ($Create_Forums eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($Create_Forums eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}	
			print "</SELECT>\n";
			print "</TD><TD>\n";

			print "<P>Create A Postcard Page: <FONT COLOR=MAROON><I>Coming Soon</I></FONT><BR><SELECT NAME=\"Add_Postcards_$x\">\n";
				if ($Add_Postcards eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($Add_Postcards eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
	
			print "</TD></TR><TR><TD>\n";

			print "<P>Use Search Engine Submission Script?:<BR><SELECT NAME=\"COMMUNITY_Allow_SE_Submission_$x\">\n";
				if ($COMMUNITY_Allow_SE_Submission eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($COMMUNITY_Allow_SE_Submission eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}	
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD><TD>\n";
	
			print "<P>Add Simple Search To Their Site?<BR><SELECT NAME=\"Simple_Search_$x\">\n";
				if ($Simple_Search eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($Simple_Search eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";

			print "</TD></TR><TR><TD>\n";
	
			print "<P>Create A Quiz Page: <FONT COLOR=MAROON><I>Coming Soon</I></FONT><BR><SELECT NAME=\"Add_Quiz_$x\">\n";
				if ($Add_Quiz eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($Add_Quiz eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD><TD>\n";

			print "<P>Administer A Webring: <FONT COLOR=MAROON><I>Coming Soon</I></FONT><BR><SELECT NAME=\"Admin_Webring_$x\">\n";
				if ($Admin_Webring eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($Admin_Webring eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD></TR>\n";
			print "</TD></TR><TR><TD>\n";

			print "<P>Web Page Header:<BR><SELECT NAME=\"headerfile_$x\">\n";
				if ($headerfile == 1) {
					print "<OPTION VALUE=1 SELECTED>1</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=1>1</OPTION>\n";
				}
				if ($headerfile == 2) {
					print "<OPTION VALUE=2 SELECTED>2</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=2>2</OPTION>\n";
				}
				if ($headerfile == 3) {
					print "<OPTION VALUE=3 SELECTED>3</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=3>3</OPTION>\n";
				}
				if ($headerfile == 4) {
					print "<OPTION VALUE=4 SELECTED>4</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=4>4</OPTION>\n";
				}	
				print "</SELECT>\n";
				print "</TD><TD>\n";
	
				print "<P>Web Page Footer:<BR><SELECT NAME=\"footerfile_$x\">\n";
				if ($footerfile == 1) {
					print "<OPTION VALUE=1 SELECTED>1</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=1>1</OPTION>\n";
				}
				if ($footerfile == 2) {
					print "<OPTION VALUE=2 SELECTED>2</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=2>2</OPTION>\n";
				}
				if ($footerfile == 3) {
					print "<OPTION VALUE=3 SELECTED>3</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=3>3</OPTION>\n";
				}
				if ($footerfile == 4) {
					print "<OPTION VALUE=4 SELECTED>4</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=4>4</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD></TR>\n";
##	
			print "<TR><TD VALIGN=TOP>\n";

			print "<P>Allow Members To Have A Guestbook? <BR><SELECT NAME=\"COMMUNITY_Allow_GB_$x\">\n";
				if ($COMMUNITY_Allow_GB eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($COMMUNITY_Allow_GB eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD><TD>\n";

			print "<P>Allow Members To Have A Free4All Links Page? <BR><SELECT NAME=\"COMMUNITY_allow_Free4All_$x\">\n";
				if ($COMMUNITY_allow_Free4All eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}	
				if ($COMMUNITY_allow_Free4All eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD></TR>\n";

			print "<TR><TD VALIGN=TOP>\n";

			print "<P>Allow Members To Have A Voting Page? <BR><SELECT NAME=\"COMMUNITY_Allow_Voting_$x\">\n";
				if ($COMMUNITY_Allow_Voting eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
				if ($COMMUNITY_Allow_Voting eq "NO") {
					print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=NO>NO</OPTION>\n";
				}
			print "</SELECT>\n";
			print "</TD><TD>\n";

			print "<P>Allow Members To Have A Form 2 Email Page? <BR><SELECT NAME=\"COMMUNITY_Allow_Form2Email_$x\">\n";
				if ($COMMUNITY_Allow_Form2Email eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
			}
			if ($COMMUNITY_Allow_Form2Email eq "NO") {
				print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=NO>NO</OPTION>\n";
			}
			print "</SELECT>\n";
			print "</TD></TR>\n";
	
			print "<TR><TD VALIGN=TOP>\n";

			print "<P>Generate Hit Logs For This Member:<BR><SELECT NAME=\"Hit_Logs_$x\">\n";
			if ($Hit_Logs eq "YES") {
				print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=YES>YES</OPTION>\n";
			}
			if ($Hit_Logs eq "NO") {
				print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=NO>NO</OPTION>\n";
			}
			print "</SELECT>\n";
			print "</TD><TD VALIGN=TOP>\n";

			print "<P>How many days should they be stored?:<BR>\n";
			print "<BR><INPUT TYPE=TEXT SIZE=5 NAME=\"Hit_Logs_Storage_$x\" VALUE=\"$Hit_Logs_Storage\">\n";
			print "</TD></TR><TR><TD>\n";

			print "<TD VALIGN=TOP>\n";
			print "<P>Allow Members To Backup Their Sites? <BR><SELECT NAME=\"COMMUNITY_Allow_Backup_$x\">\n";
			if ($COMMUNITY_Allow_Backup eq "YES") {
				print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=YES>YES</OPTION>\n";
			}
			if ($COMMUNITY_Allow_Backup eq "NO") {
				print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=NO>NO</OPTION>\n";
			}
			print "</SELECT>\n";
			print "</TD><TD>\n";
			print "<P>Create/Manage a Search Engine (Ilink):<BR><SELECT NAME=\"Create_Ilinks_$x\">\n";
				if ($Create_Ilinks eq "YES") {
					print "<OPTION VALUE=YES SELECTED>YES</OPTION>\n";
				}
				else {
					print "<OPTION VALUE=YES>YES</OPTION>\n";
				}
			if ($Create_Ilinks eq "NO") {
				print "<OPTION VALUE=NO SELECTED>NO</OPTION>\n";
			}
			else {
				print "<OPTION VALUE=NO>NO</OPTION>\n";
			}
			print "</SELECT>\n";

			print "</TD></TR>\n";

			print "</TD></TR>\n";
			if ($CONFIG{'POSTCARDS_SetMaxCardsByUserName'} eq "YES") {
				print "<TR><TD VALIGN=TOP>\n";

				print "</TD>\n";
				print "<TD VALIGN=TOP>\n";
					print "<P>How many postcards are they allowed to send at once?:\n";
					print "<BR><INPUT TYPE=TEXT SIZE=5 NAME=\"POSTCARD_max_cards_$x\" VALUE=\"$POSTCARD_max_cards\">\n";
				print "<BR>\n";
				print "</TD></TR>\n";
			}
			print "</TABLE>\n";
		}
	}
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save User Groups\">\n";
      print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



sub save_user_level {
	$fn = "$GPath{'community_data'}/levels.pm";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");

	print FILE "sub get_priveledges {\n";
	print FILE "	my \$level = \$_[0];\n";
	print FILE "	\$ALLOW_ZERO_MOVE = \"$FORM{'ALLOW_ZERO_MOVE'}\";\n";
	print FILE "	\$MOVE_MAX = \"$FORM{'MOVE_MAX'}\";\n";


	for $xf (1 .. $max_groups) {
			$temp = "Hit_Logs_Storage_$xf";
		if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}
			$temp = "Max_Files_$xf";
		if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}
			$temp = "Max_Bytes_$xf";
		if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}
			$temp = "POSTCARD_max_cards_$xf";
		if ($FORM{$temp} eq "") {$FORM{$temp} = 1;}
	
		if ($xf == 1) {
			print FILE "	if (\$level eq \"$xf\") {\n";
		}
		else {
			print FILE "	elsif (\$level eq \"$xf\") {\n";
		}


			$temp = "Create_Ilinks_$xf";
		print FILE "		\$Create_Ilinks = \"$FORM{$temp}\";\n";
			$temp = "Allow_Image_Uploads_$xf";
		print FILE "		\$Allow_Image_Uploads = \"$FORM{$temp}\";\n";
			$temp = "Hit_Logs_$xf";
		print FILE "		\$Hit_Logs = \"$FORM{$temp}\";\n";
			$temp = "Hit_Logs_Storage_$xf";
		print FILE "		\$Hit_Logs_Storage = $FORM{$temp};\n";
#			$temp = "Max_Pages_$xf";
#		print FILE "		\$Max_Pages = $FORM{$temp};\n";
			$temp = "Max_Files_$xf";
		print FILE "		\$Max_Files = $FORM{$temp};\n";
			$temp = "Max_Bytes_$xf";
		print FILE "		\$Max_Bytes = $FORM{$temp};\n";
			$temp = "Create_Forums_$xf";
		print FILE "		\$Create_Forums = \"$FORM{$temp}\";\n";
			$temp = "Post_In_Forums_$xf";
		print FILE "		\$Post_In_Forums = \"$FORM{$temp}\";\n";
			$temp = "Add_Postcards_$xf";
		print FILE "		\$Add_Postcards = \"$FORM{$temp}\";\n";
			$temp = "Add_Quiz_$xf";
		print FILE "		\$Add_Quiz = \"$FORM{$temp}\";\n";
			$temp = "Admin_Webring_$xf";
		print FILE "		\$Admin_Webring = \"$FORM{$temp}\";\n";
			$temp = "footerfile_$xf";
		print FILE "		\$footerfile = \"$FORM{$temp}\";\n";
			$temp = "headerfile_$xf";
		print FILE "		\$headerfile = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_allow_direct_edit_$xf";
		print FILE "		\$COMMUNITY_allow_direct_edit = \"$FORM{$temp}\";\n";
			$temp = "POSTCARD_max_cards_$xf";
		print FILE "		\$COMMUNITY_Allow_Backup = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_SE_Submission_$xf";
		print FILE "		\$COMMUNITY_Allow_SE_Submission = \"$FORM{$temp}\";\n";
			$temp = "Simple_Search_$xf";
		print FILE "		\$Simple_Search = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_Form2Email_$xf";
		print FILE "		\$COMMUNITY_Allow_Form2Email = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_Voting_$xf";
		print FILE "		\$COMMUNITY_Allow_Voting = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_allow_Free4All_$xf";
		print FILE "		\$COMMUNITY_allow_Free4All = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_GB_$xf";
		print FILE "		\$COMMUNITY_Allow_GB = \"$FORM{$temp}\";\n";
			$temp = "POSTCARD_max_cards_$xf";
		print FILE "		\$POSTCARD_max_cards = \"$FORM{$temp}\";\n";
		print FILE "	}\n";
	}

	$xf = 0;

		$temp = "Hit_Logs_Storage_$xf";
	if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}
		$temp = "Max_Files_$xf";
	if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}
		$temp = "Max_Bytes_$xf";
	if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}
		$temp = "POSTCARD_max_cards_$xf";
	if ($FORM{$temp} eq "") {$FORM{$temp} = 0;}

	print FILE "	else {\n";

			$temp = "Create_Ilinks_$xf";
		print FILE "		\$Create_Ilinks = \"$FORM{$temp}\";\n";
			$temp = "Allow_Image_Uploads_$xf";
		print FILE "		\$Allow_Image_Uploads = \"$FORM{$temp}\";\n";
			$temp = "Hit_Logs_$xf";
		print FILE "		\$Hit_Logs = \"$FORM{$temp}\";\n";
			$temp = "Hit_Logs_Storage_$xf";
		print FILE "		\$Hit_Logs_Storage = $FORM{$temp};\n";
#			$temp = "Max_Pages_$xf";
#		print FILE "		\$Max_Pages = $FORM{$temp};\n";
			$temp = "Max_Files_$xf";
		print FILE "		\$Max_Files = $FORM{$temp};\n";
			$temp = "Max_Bytes_$xf";
		print FILE "		\$Max_Bytes = $FORM{$temp};\n";
			$temp = "Create_Forums_$xf";
		print FILE "		\$Create_Forums = \"$FORM{$temp}\";\n";
			$temp = "Post_In_Forums_$xf";
		print FILE "		\$Post_In_Forums = \"$FORM{$temp}\";\n";
			$temp = "Add_Postcards_$xf";
		print FILE "		\$Add_Postcards = \"$FORM{$temp}\";\n";
			$temp = "Add_Quiz_$xf";
		print FILE "		\$Add_Quiz = \"$FORM{$temp}\";\n";
			$temp = "Admin_Webring_$xf";
		print FILE "		\$Admin_Webring = \"$FORM{$temp}\";\n";
			$temp = "footerfile_$xf";
		print FILE "		\$footerfile = \"$FORM{$temp}\";\n";
			$temp = "headerfile_$xf";
		print FILE "		\$headerfile = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_allow_direct_edit_$xf";
		print FILE "		\$COMMUNITY_allow_direct_edit = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_Backup_$xf";
		print FILE "		\$COMMUNITY_Allow_Backup = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_SE_Submission_$xf";
		print FILE "		\$COMMUNITY_Allow_SE_Submission = \"$FORM{$temp}\";\n";
			$temp = "Simple_Search_$xf";
		print FILE "		\$Simple_Search = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_Form2Email_$xf";
		print FILE "		\$COMMUNITY_Allow_Form2Email = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_Voting_$xf";
		print FILE "		\$COMMUNITY_Allow_Voting = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_allow_Free4All_$xf";
		print FILE "		\$COMMUNITY_allow_Free4All = \"$FORM{$temp}\";\n";
			$temp = "COMMUNITY_Allow_GB_$xf";
		print FILE "		\$COMMUNITY_Allow_GB = \"$FORM{$temp}\";\n";
			$temp = "POSTCARD_max_cards_$xf";
		print FILE "		\$POSTCARD_max_cards = \"$FORM{$temp}\";\n";
		print FILE "	}\n";

	print FILE "}\n";
	print FILE "1;\n";

	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'community_admin.cgi'}\"><INPUT TYPE=\"HIDDEN\" NAME=\"action\" VALUE=\"main\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";	
	print "</TD></TR></TABLE></CENTER>\n";
	exit;
}

sub backup_menu {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD><CENTER><H3>Create Backups</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<INPUT TYPE=CHECKBOX NAME=\"datafiles\">Data Files (in the data directory)<BR>\n";
	print "<INPUT TYPE=CHECKBOX NAME=\"scripts\">Scripts (usually not necessary)<BR>\n";
	print "<INPUT TYPE=CHECKBOX NAME=\"memberpages\">Member Pages<BR>\n";
	print "<UL>\n";
	print "<LI><INPUT TYPE=CHECKBOX NAME=\"exclude_images\">Exclude Images and Midi\n";
	print "</UL>\n";
	print "Archive Method:\n";
	print "<SELECT NAME=archive_method>\n";
	print "<OPTION VALUE=Zip>Zip - recommended if available\n";
	print "<OPTION VALUE=Tar>Tar\n";
	print "</SELECT>\n";
	print "<BR>Archiver path (if not set in the server path): <BR><INPUT TYPE=text NAME=archiverpath><BR>\n";
	print "<P><INPUT TYPE=SUBMIT NAME=action VALUE=\"Start The Backup\">\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE>\n";
	exit;

}

sub create_backup {
	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	if ($FORM{'datafiles'} ne "") {
		system "find $CONFIG{'data_dir'} -name \*.\* -print > $CONFIG{'data_dir'}/files_temp.txt";
		chmod 0777, "$CONFIG{'data_dir'}/files_temp.txt";

		open(FILES,"$CONFIG{'data_dir'}/files_temp.txt") || &diehtml("Cannot open files_temp.txt to read");
		@FILES=<FILES>;
		close(FILES);

		if ($FORM{'archive_method'} eq "Tar") {
			if (-e "./community_data.tar") {
				unlink "./community_data.tar";
			}
			if ($FORM{'archiverpath'} ne "") {
				$command = $FORM{'archiverpath'};
			}
			else {
				$command = "tar";
			}
			foreach $file (@FILES) {
				chop($file);
	    			`$command Avf ./community_data.tar $file`;
				print "<LI>Adding $file to Tar file\n";
			}
		}

		if ($FORM{'archive_method'} eq "Zip") {
			if (-e "./community_data.zip") {unlink "./community_data.zip";}
			if ($FORM{'archiverpath'} ne "") {$command = $FORM{'archiverpath'};}
			else {$command = "zip";}
			foreach $file (@FILES) {
				chop($file);
		    		`$command -9 ./community_data.zip $file`;
				print "<LI>Adding $file to Zip file\n";
			}
		}		
	}
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Backup Created</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "The backup files were created, You should now download a copy for safe-keeping.\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}

sub menu {
	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER>\n";
	print "<TABLE WIDTH=500><TR><TD VALIGN=TOP WIDTH=40%>\n";
	print "<A HREF=\"$GUrl{'community_admin.cgi'}?action=view_members_on_hold\" TARGET=\"workarea\">View Members On Hold</A>\n";
	print "<BR><A HREF=\"$GUrl{'community_admin.cgi'}?action=user0\" TARGET=\"workarea\">View \"Group 0\" Members</A>\n";
	print "<BR><A HREF=\"$GUrl{'community_admin.cgi'}?action=search\" TARGET=\"workarea\">Search Members</A>\n";
	print "</TD><TD>\n";
	if (! (-e "cforum.cgi")) {
		print "<A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/communityweaver.html\" TARGET=\"_top\"><B>Help!</B></A></TD>\n";
	}
	else {
		print "<A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/communitymembers.html\" TARGET=\"_top\"><B>Help!</B></A></TD>\n";
	}
	print "</TD><TD VALIGN=TOP>\n";
	print "<A HREF=\"$GUrl{'community_admin.cgi'}?action=view_inactive_options\" TARGET=\"workarea\">View Inactive Members</A>\n";
	print "<BR><A HREF=\"eadmin.cgi?action=admin\" TARGET=\"_top\">Main Admin</A>\n";
	print "<BR><A HREF=\"$GUrl{'community_admin.cgi'}?action=main\" TARGET=\"workarea\">CW Admin</A>\n";
	print "</TD></TR></TABLE>\n";
	print "</BODY>\n";
	exit;
}


sub view_inactive_options {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD><CENTER><H3>Inactivity Reports</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";

	print "<P>List members who have been inactive for (days):\n";
	print "<BR><SELECT NAME=\"Num_Days\">\n";
   	for $day(1 .. 60) {
		print "<OPTION>$day\n";
	}
	print "<OPTION>75\n";
	print "<OPTION>90\n";
	print "<OPTION>120\n";
	print "<OPTION>180\n";
	print "<OPTION>270\n";
	print "<OPTION>365\n";
	print "</SELECT>\n";
	
	print "<P>Include webpage accesses?  (You may not want to delete pages that are still popular.)\n";
	print "<INPUT TYPE=CHECKBOX NAME=\"include_wp\" VALUE=\"YES\">\n";

	print "<P>\n";
	print "</CENTER><INPUT TYPE=SUBMIT NAME=action VALUE=\"View Inactive Members\">\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub open_templates {
	($tmpl = $FORM{'template2edit'}) =~ s/\.txt$//g;
	my ($fn, @t) = &io_get_template($tmpl);

	foreach my $l (@t) {
		$TEXT .= $l;
	}
     	$TEXT =~ s/\cM//g;

   $DESC = "Editing Template: <B>$FORM{'template2edit'}</B><BR>(Read in from $fn)<BR><BR>";
   $DESC .= "If there was not a template already defined, we used the current default.  \n";
   $DESC .= "<A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">Click here</A> for a definition of the <A HREF=\"$CONFIG{'COMMUNITY_helpfiles'}/plugins.html\">available plugins</A>.\n";


   &Symbol_List;
   &Font_List;
   &Plugin_List;
   &Tags;
   &Colors;

print "Content-Type: text/html\n\n";
print <<DONE;
    <SCRIPT LANGUAGE="javascript">
	    function Symbols() {
		    var text=document.html_form.source.value;
			var num = document.html_form.symbol.selectedIndex;
			var sval = document.html_form.symbol[num].text;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}
		
	    function Font() {
		    var text=document.html_form.source.value;
			var num = document.html_form.font.selectedIndex;
			var sval = document.html_form.font[num].text;
			if(num > 0) {			
 			   text = text + "<FONT FACE='" + sval + "' SIZE='$CONFIG{'font_size'}' COLOR='$CONFIG{'text_color'}'>";
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}			   
		}		

	    function Plugin() {
		    var text=document.html_form.source.value;
			var num = document.html_form.plugin.selectedIndex;
			var sval = document.html_form.plugin[num].value;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}

	    function Tag() {
		    var text=document.html_form.source.value;
			var num = document.html_form.tag.selectedIndex;
			var sval = document.html_form.tag[num].value;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}

	    function Color(c_value) {
		    var text=document.html_form.source.value;
			text = text + c_value;
			document.html_form.source.value=text;
			document.html_form.source.focus();
		}
				
	</SCRIPT>
	<body bgcolor="#ffffcc" link=navy vlink=navy text=black>
	<FONT FACE="arial,helvetica" SIZE=-1>
        <BLOCKQUOTE><BLOCKQUOTE>$DESC</BLOCKQUOTE></BLOCKQUOTE>
	<CENTER>
    <form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME="html_form" ACTION="$GUrl{'community_admin.cgi'}" METHOD="post">
	<TABLE BGCOLOR="#cccc99" BORDER=0 WIDTH=500 CELLSPACING=2 CELLPADDING=0><TR><TD>
	  <TABLE WIDTH=100% BORDER=0 BGCOLOR="\"#ffffcc\">
	    <TR><TD VALIGN="top" BGCOLOR="#cccc99">
		  <FONT FACE="arial,helvetica" SIZE=-1>
		    <H3>Template Editor</H3>
 	        $symbols
	        $fonts
	        $plugins
	        $tags
	      </FONT>		  
		</TD></TR>
	    <TD VALIGN="top">
 		 <CENTER>
	     <TEXTAREA NAME="source" COLS=60 ROWS=15>$TEXT</TEXTAREA><BR>
                 <INPUT TYPE="hidden" NAME="password" VALUE="$password">
                 <INPUT TYPE="hidden" NAME="filename" VALUE="$FILENAME">
                 <INPUT TYPE="hidden" NAME="template2edit" VALUE="$FORM{'template2edit'}">
                 <INPUT TYPE="hidden" NAME="mode" VALUE="$input{'mode'}">
                 <INPUT TYPE="hidden" NAME="todo" VALUE="$input{'todo'}">
                 <INPUT TYPE="hidden" NAME="action" VALUE="Save Template">
                 <CENTER><INPUT TYPE=SUBMIT VALUE="Save Changes!"></CENTER>

		 </CENTER>
	    </TD></TR>
	  </TABLE>
	</TD></TR></TABLE>
	</FORM>
    <B>Click to insert color...</B><BR>
    <TABLE BORDER="1" CELLSPACING="0" CELLPADDING="1">
      <TR>
        $colortable
      </TR>
    </TABLE>
  </CENTER>

DONE

        exit 0;


}




sub Plugin_List {

   $plugins=<<DONEPLUGINS;
    <SELECT NAME="plugin" onChange="Plugin();">
      <OPTION>Plugins
      <OPTION VALUE="\nPLUGIN:BODY\n">PLUGIN:BODY
      <OPTION VALUE="\nPLUGIN:BANNER\n">PLUGIN:BANNER

      <OPTION VALUE="PLUGIN:LONGDATE">PLUGIN:LONGDATE
      <OPTION VALUE="PLUGIN:USDATE">PLUGIN:USDATE
      <OPTION VALUE="PLUGIN:SHORTDATE">PLUGIN:SHORTDATE
      <OPTION VALUE="PLUGIN:REFERER">PLUGIN:REFERER
      <OPTION VALUE="PLUGIN:USEREMAIL">PLUGIN:USEREMAIL
      <OPTION VALUE="PLUGIN:USERDESCRIPTION">PLUGIN:USERDESCRIPTION
      <OPTION VALUE="PLUGIN:USERCOMMUNITY">PLUGIN:USERCOMMUNITY
      <OPTION VALUE="PLUGIN:COMMUNITYNAME">PLUGIN:COMMUNITYNAME
      <OPTION VALUE="PLUGIN:HANDLE">PLUGIN:HANDLE
      <OPTION VALUE="PLUGIN:USERREALNAME">PLUGIN:USERREALNAME
      <OPTION VALUE="PLUGIN:SCREENNAME">PLUGIN:SCREENNAME
      <OPTION VALUE="PLUGIN:PASSWORD">PLUGIN:PASSWORD
      <OPTION VALUE="PLUGIN:USERNAME">PLUGIN:USERNAME
      <OPTION VALUE="PLUGIN:FIRSTNAME">PLUGIN:FIRSTNAME
      <OPTION VALUE="PLUGIN:MIDDLENAME">PLUGIN:MIDDLENAME
      <OPTION VALUE="PLUGIN:LASTNAME">PLUGIN:LASTNAME
      <OPTION VALUE="PLUGIN:BIRTH:DAY">PLUGIN:BIRTH:DAY
      <OPTION VALUE="PLUGIN:BIRTH:MONTH">PLUGIN:BIRTH:MONTH
      <OPTION VALUE="PLUGIN:BIRTH:MONTH:WORD">PLUGIN:BIRTH:MONTH:WORD
      <OPTION VALUE="PLUGIN:BIRTH:YEAR">PLUGIN:BIRTH:YEAR
      <OPTION VALUE="PLUGIN:FILLER(1..10)">PLUGIN:FILLER
      <OPTION VALUE="PLUGIN:_VIEWCARDS">PLUGIN:_VIEWCARDS
      <OPTION VALUE="PLUGIN:POPUP">PLUGIN:POPUP
      <OPTION VALUE="PLUGIN:GALLERYLOCATION">PLUGIN:GALLERYLOCATION
      <OPTION VALUE="PLUGIN:DIRECTORIES">PLUGIN:DIRECTORIES
      <OPTION VALUE="PLUGIN:IMAGES">PLUGIN:IMAGES
	<OPTION VALUE="PLUGIN:CUSTOM:Your_Function_Name">PLUGIN:CUSTOM


    </SELECT>
DONEPLUGINS

}

sub Font_List {

   $fonts=<<DONEFONTS;
    <SELECT NAME="font" onChange="Font();">
     <OPTION>Font
     <OPTION>Arial,Helvetica
     <OPTION>Tahoma,Helvetica
     <OPTION>Verdana,Helvetica
     <OPTION>Times Roman
     <OPTION>MS Comic Sans Serif
     <OPTION>Courier
    </SELECT>
DONEFONTS
}


sub Tags {
   $tags=<<DONETAGS;
    <SELECT NAME="tag" onChange="Tag();">
     <OPTION>HTML Tags
     <OPTION VALUE="&lt;H1&gt; &lt;/H1&gt;">H1
     <OPTION VALUE="&lt;H2&gt; &lt;/H2&gt;">H2
     <OPTION VALUE="&lt;H3&gt; &lt;/H3&gt;">H3
     <OPTION VALUE="&lt;H4&gt; &lt;/H4&gt;">H4
     <OPTION VALUE="&lt;B&gt; &lt;/B&gt;">BOLD
     <OPTION VALUE="&lt;U&gt; &lt;/U&gt;">Underline
     <OPTION VALUE="&lt;I&gt; &lt;/I&gt;">Italics
     <OPTION VALUE="&lt;BLOCKQUOTE&gt;\n&lt;/BLOCKQUOTE&gt;">Blockquote
     <OPTION VALUE="&lt;IMG SRC='/path/to/image.gif'&gt;">Image
     <OPTION VALUE="&lt;CENTER&gt; &lt;/CENTER&gt;">Center
     <OPTION VALUE="&lt;P ALIGN='left'&gt; &lt;/P&gt;">Align Left
     <OPTION VALUE="&lt;P ALIGN='right'&gt; &lt;/P&gt;">Align Right
    </SELECT>
DONETAGS
}

sub Symbol_List {

   $symbols=<<DONESYMBOLS;
   <SELECT NAME="symbol" onChange="Symbols();">
     <OPTION>Symbol
     <OPTION>&quot;
     <OPTION>&amp
     <OPTION>&lt;
     <OPTION>&gt;
	 
	 <!--
     <OPTION>&euro;
     <OPTION>&fnof;
     <OPTION>&hellip;
     <OPTION>&dagger;
     <OPTION>&Dagger;
     <OPTION>&permil;
     <OPTION>&Scaron;
     <OPTION>&OElig;
     <OPTION>&bull;
     <OPTION>&mdash;
     <OPTION>&trade;
     <OPTION>&scaron;
     <OPTION>&rsaquo;
     <OPTION>&oelig;
     <OPTION>&Yuml;
	 -->
	 
     <OPTION>&nbsp;
     <OPTION>&iexcl;
     <OPTION>&cent;
     <OPTION>&pound;
     <OPTION>&curren;
     <OPTION>&yen;
     <OPTION>&brvbar;
     <OPTION>&sect;
     <OPTION>&copy;
     <OPTION>&laquo;
     <OPTION>&not;
     <OPTION>&reg;
     <OPTION>&deg;
     <OPTION>&plusmn;
     <OPTION>&sup2;
     <OPTION>&sup3;
     <OPTION>&acute;
     <OPTION>&micro;
     <OPTION>&para;
     <OPTION>&middot;
     <OPTION>&sup1;
     <OPTION>&raquo;
     <OPTION>&frac14;
     <OPTION>&frac12;
     <OPTION>&frac34;
     <OPTION>&iquest;
     <OPTION>&Agrave;
     <OPTION>&times;
     <OPTION>&Oslash;
     <OPTION>&szlig;
     <OPTION>&divide;
    </SELECT>
DONESYMBOLS
   
}


sub Colors {

   push @cl,"#000000";
   push @cl,"#003300";
   push @cl,"#006600";
   push @cl,"#009900";
   push @cl,"#00cc00";
   push @cl,"#00ff00";
   push @cl,"#000033";
   push @cl,"#003333";
   push @cl,"#006633";
   push @cl,"#009933";
   push @cl,"#00cc33";
   push @cl,"#00ff33";
   push @cl,"#000066";
   push @cl,"#003366";
   push @cl,"#006666";
   push @cl,"#009966";
   push @cl,"#00cc66";
   push @cl,"#00ff66";
   push @cl,"#000099";
   push @cl,"#003399";
   push @cl,"#006699";
   push @cl,"#009999";
   push @cl,"#00cc99";
   push @cl,"#00ff99";
   push @cl,"#0000cc";
   push @cl,"#0033cc";
   push @cl,"#0066cc";
   push @cl,"#0099cc";
   push @cl,"#00cccc";
   push @cl,"#00ffcc";
   push @cl,"#0000ff";
   push @cl,"#0033ff";
   push @cl,"#0066ff";
   push @cl,"#0099ff";
   push @cl,"#00ccff";
   push @cl,"#00ffff";
   push @cl,"#330000";
   push @cl,"#333300";
   push @cl,"#336600";
   push @cl,"#339900";
   push @cl,"#33cc00";
   push @cl,"#33ff00";
   push @cl,"#330033";
   push @cl,"#333333";
   push @cl,"#336633";
   push @cl,"#339933";
   push @cl,"#33cc33";
   push @cl,"#33ff33";
   push @cl,"#330066";
   push @cl,"#333366";
   push @cl,"#336666";
   push @cl,"#339966";
   push @cl,"#33cc66";
   push @cl,"#33ff66";
   push @cl,"#330099";
   push @cl,"#333399";
   push @cl,"#336699";
   push @cl,"#339999";
   push @cl,"#33cc99";
   push @cl,"#33ff99";
   push @cl,"#3300cc";
   push @cl,"#3333cc";
   push @cl,"#3366cc";
   push @cl,"#3399cc";
   push @cl,"#33cccc";
   push @cl,"#33ffcc";
   push @cl,"#3300ff";
   push @cl,"#3333ff";
   push @cl,"#3366ff";
   push @cl,"#3399ff";
   push @cl,"#33ccff";
   push @cl,"#660000";
   push @cl,"#663300";
   push @cl,"#666600";
   push @cl,"#669900";
   push @cl,"#66cc00";
   push @cl,"#66ff00";
   push @cl,"#660033";
   push @cl,"#663333";
   push @cl,"#666633";
   push @cl,"#669933";
   push @cl,"#66cc33";
   push @cl,"#66ff33";
   push @cl,"#660066";
   push @cl,"#663366";
   push @cl,"#666666";
   push @cl,"#669966";
   push @cl,"#66cc66";
   push @cl,"#66ff66";
   push @cl,"#660099";
   push @cl,"#663399";
   push @cl,"#666699";
   push @cl,"#669999";
   push @cl,"#66cc99";
   push @cl,"#66ff99";
   push @cl,"#6600cc";
   push @cl,"#6633cc";
   push @cl,"#6666cc";
   push @cl,"#6699cc";
   push @cl,"#66cccc";
   push @cl,"#66ffcc";
   push @cl,"#6600ff";
   push @cl,"#6633ff";
   push @cl,"#6666ff";
   push @cl,"#6699ff";
   push @cl,"#66ccff";
   push @cl,"#66ffff";
   push @cl,"#990000";
   push @cl,"#993300";
   push @cl,"#996600";
   push @cl,"#999900";
   push @cl,"#99cc00";
   push @cl,"#99ff00";
   push @cl,"#990033";
   push @cl,"#993333";
   push @cl,"#996633";
   push @cl,"#999933";
   push @cl,"#99cc33";
   push @cl,"#99ff33";
   push @cl,"#990066";
   push @cl,"#993366";
   push @cl,"#996666";
   push @cl,"#999966";
   push @cl,"#99cc66";
   push @cl,"#99ff66";
   push @cl,"#990099";
   push @cl,"#993399";
   push @cl,"#996699";
   push @cl,"#999999";
   push @cl,"#99cc99";
   push @cl,"#99ff99";
   push @cl,"#9900cc";
   push @cl,"#9933cc";
   push @cl,"#9966cc";
   push @cl,"#9999cc";
   push @cl,"#99cccc";
   push @cl,"#99ffcc";
   push @cl,"#9900ff";
   push @cl,"#9933ff";
   push @cl,"#9966ff";
   push @cl,"#9999ff";
   push @cl,"#99ccff";
   push @cl,"#99ffff";
   push @cl,"#cc0000";
   push @cl,"#cc3300";
   push @cl,"#cc6600";
   push @cl,"#cc9900";
   push @cl,"#cccc00";
   push @cl,"#ccff00";
   push @cl,"#cc0033";
   push @cl,"#cc3333";
   push @cl,"#cc6633";
   push @cl,"#cc9933";
   push @cl,"#cccc33";
   push @cl,"#ccff33";
   push @cl,"#cc0066";
   push @cl,"#cc3366";
   push @cl,"#cc6666";
   push @cl,"#cc9966";
   push @cl,"#cccc66";
   push @cl,"#ccff66";
   push @cl,"#cc0099";
   push @cl,"#cc3399";
   push @cl,"#cc6699";
   push @cl,"#cc9999";
   push @cl,"#cccc99";
   push @cl,"#ccff99";
   push @cl,"#cc00cc";
   push @cl,"#cc33cc";
   push @cl,"#cc66cc";
   push @cl,"#cc99cc";
   push @cl,"#cccccc";
   push @cl,"#ccffcc";
   push @cl,"#cc00ff";
   push @cl,"#cc33ff";
   push @cl,"#cc66ff";
   push @cl,"#cc99ff";
   push @cl,"#ccccff";
   push @cl,"#ccffff";
   push @cl,"#ff0000";
   push @cl,"#ff3300";
   push @cl,"#ff6600";
   push @cl,"#ff9900";
   push @cl,"#ffcc00";
   push @cl,"#ffff00";
   push @cl,"#ff0033";
   push @cl,"#ff3333";
   push @cl,"#ff6633";
   push @cl,"#ff9933";
   push @cl,"#ffcc33";
   push @cl,"#ffff33";
   push @cl,"#ff0066";
   push @cl,"#ff3366";
   push @cl,"#ff6666";
   push @cl,"#ff9966";
   push @cl,"#ffcc66";
   push @cl,"#ffff66";
   push @cl,"#ff0099";
   push @cl,"#ff3399";
   push @cl,"#ff6699";
   push @cl,"#ff9999";
   push @cl,"#ffcc99";
   push @cl,"#ffff99";
   push @cl,"#ff00cc";
   push @cl,"#ff33cc";
   push @cl,"#ff66cc";
   push @cl,"#ff99cc";
   push @cl,"#ffcccc";
   push @cl,"#ffffcc";
   push @cl,"#ff00ff";
   push @cl,"#ff33ff";
   push @cl,"#ff66ff";
   push @cl,"#ff99ff";
   push @cl,"#ffccff";
   push @cl,"#ffffff";
   push @cl,"aqua";
   push @cl,"gray">
   push @cl,"navy";
   push @cl,"silver";
   push @cl,"black";
   push @cl,"green";
   push @cl,"olive";
   push @cl,"teal";
   push @cl,"blue";
   push @cl,"lime";
   push @cl,"purple";
   push @cl,"white";
   push @cl,"fuchsia";
   push @cl,"maroon";
   push @cl,"red";
   push @cl,"yellow";

   $x=0;
   foreach $color(@cl) {
      $x++;
      $colortable .= "<TD BGCOLOR=\"$color\"><A HREF=\"javascript:Color('$color');\">&nbsp;&nbsp;&nbsp;</a></TD>\n";
      if($x == 36) { $colortable .= "</TR><TR>"; $x=0; }
   }

}


sub save_template {
	&io_save_template($FORM{'template2edit'}, \$FORM{'source'});


  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "File ($fn) Saved.\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	print "<P>\n";
	print "<HR>\n";
	print "$FORM{'source'}\n";
	exit;
}



sub create_frame{
  	print "Content-type: text/html\n\n";
	print "<TITLE>Community Admin</TITLE>\n";
	print "<FRAMESET ROWS=\"75,*\">\n";
	print "<FRAME SRC=\"$GUrl{'community_admin.cgi'}?action=menu\" NAME=\"menu\" scrolling=\"right\" border=\"0\" frameborder=\"0\" noresize marginheight=0>\n";
	print "<FRAME SRC=\"$GUrl{'community_admin.cgi'}?action=main\" NAME=\"workarea\">\n";
	print "</FRAMESET>\n";
}

sub main {
	for $x(0 .. $max_groups) {
		$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
	}

	($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$databasefile");
	&parse_date($mtime);
	$database_age = $long_date;
   print "Content-Type: text/html\n\n";

   if (-e "community.cgi") {
   $cw_add = <<CW;
   </tr>
CW
}
   else {
   $cw_add = <<CW;
	<td><br>
	</td>
	<td><br>
	</td>
     </tr>
CW
}


   print <<DONE;

   <script language="javascript">
      function Go(i) {
           if ( i == "ViewCommunities" ) { Loc = "$GUrl{'community_admin.cgi'}?action=view_communities"; } 
           if ( i == "ViewUserLevels" ) { Loc = "$GUrl{'community_admin.cgi'}?action=view_user_levels"; }
           if ( i == "EditEmails" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_emails"; }
           if ( i == "EditThankYou" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_thank_you_page"; } 
           if ( i == "EditFrame" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_frame"; } 
           if ( i == "EditPopup" ) { Loc = "$GUrl{'community_admin.cgi'}?action=Edit+Pop-Up+Setup"; } 
           if ( i == "EditBBSHeaders" ) { Loc = "$GUrl{'community_admin.cgi'}?action=Edit+BBS+Header+Setup"; } 
           if ( i == "EditHints" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_hints"; } 
           if ( i == "EditProfileText" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_profile_text"; } 
           if ( i == "BanUser" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_banned_list"; } 
           if ( i == "FailedLogins" ) { Loc = "$GUrl{'community_admin.cgi'}?action=view_failed_logins"; } 
           if ( i == "DataFields" ) { Loc = "$GUrl{'community_admin.cgi'}?action=setup_fields"; } 
           if ( i == "DeleteLogs" ) { Loc = "$GUrl{'community_admin.cgi'}?action=delete_logs"; } 
           if ( i == "ViewWarnings" ) { Loc = "$GUrl{'community_admin.cgi'}?action=view_user_warnings"; } 
           if ( i == "HeadersFooters" ) { Loc = "$GUrl{'community_admin.cgi'}?action=webpage_headers_footers"; } 
           if ( i == "Templates" ) { Loc = "$GUrl{'community_admin.cgi'}?action=edit_templates"; } 
           if ( i == "MassMail" ) { Loc = "$GUrl{'community_admin.cgi'}?action=mass_mail"; } 
           if ( i == "ReBuild" ) { Loc = "$GUrl{'community_admin.cgi'}?action=build_db"; } 
           if ( i == "Reports" ) { Loc = "$GUrl{'community_admin.cgi'}?action=reports"; } 
           if ( i == "EditPassWords" ) { Loc = "$GUrl{'community_admin.cgi'}?action=EditPassWords"; } 
           if ( i == "EditWords" ) { Loc = "$GUrl{'community_admin.cgi'}?action=EditWords"; } 
           if ( i == "EditRules" ) { Loc = "$GUrl{'community_admin.cgi'}?action=setup_rules"; } 
           if ( i == "EditWeaverFrames" ) { Loc = "$GUrl{'community_admin.cgi'}?action=Edit+Weaver+Frames"; } 
           if ( i == "CreateAdmGroups" ) { Loc = "$GUrl{'community_admin.cgi'}?action=CreateAdmGroups"; } 
           if ( i == "EditWebsiteDirectory" ) { Loc = "$GUrl{'find.cgi'}"; } 
           X=window.open(Loc,"X","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}")
      }
   </script>

<body bgcolor="#ffffcc" link=navy vlink=navy text=black>
 <center>
 <table width=630><tr><td>
 <center><h1>CommunityMembers / CommunityWeaver Admin</h1>

<TABLE WIDTH=500><TR><TD>
<P><B>Warning:</B> We recommend using a recent version of Netscape while editing, as certain browsers may overwrite important changes that you make to your files.
</TD></TR></TABLE></CENTER><BR>

 <table cellpadding=5 WIDTH=630>

   <tr>
	<TD></TD>
      <td colspan=2 halign=center valign=middle>
        <B>The current database was last re-built on $database_age.  <a href=javascript:Go("ReBuild")>Re-build The Administrative Database</a>?</B><BR><BR>
	</td>
      <td>
      </td>
   </tr>

 <tr>
     <td valign=top align=center width=25%>
	   <form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action="$GUrl{'community_admin.cgi'}">
         <table border><tr><td><img src=$CONFIG{'button_dir'}/icon-groups.gif border=0 width=60 height=60></td></tr></table>
         View/Edit User Groups:
         <SELECT NAME=group>
		<OPTION VALUE="Options">Options</OPTION>
		$GROUP_SELECT
	   </SELECT>
	   <INPUT TYPE=hidden NAME=action VALUE=\"Edit Groups\">
	   <INPUT TYPE=submit VALUE=Edit>
	   </FORM>
	</td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditEmails")><img src=$CONFIG{'button_dir'}/icon-edit-email.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditEmails")>Edit Automatic Emails</a></td>
            <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("ViewCommunities")><img src=$CONFIG{'button_dir'}/icon-edit-community.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("ViewCommunities")>Edit Communities</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("Templates")><img src=$CONFIG{'button_dir'}/icon-templates.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("Templates")>Edit Community Templates</a></td>
</tr>
<tr>    
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("DataFields")><img src=$CONFIG{'button_dir'}/icon-validate.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("DataFields")>Edit Registration Questions</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditThankYou")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditThankYou")>Edit <I>Thank You</I> Page</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditPopup")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditPopup")>Edit PopUp Windows</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("HeadersFooters")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("HeadersFooters")>Edit Page Headers/Footers</a></td>
</tr>
<tr>    
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditProfileText")><img src=$CONFIG{'button_dir'}/icon-edit-profiletext.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditProfileText")>Edit <I>What's New?</I> In Profile </a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditPassWords")><img src=$CONFIG{'button_dir'}/icon-edit-passwords.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditPassWords")>Edit Default PassWords</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditHints")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditHints")>Edit Rotating Hints</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditWeaverFrames")><img src=$CONFIG{'button_dir'}/icon-templates.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditWeaverFrames")>Edit Weaver Frames Version</a></td>
</tr>
<tr>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditBBSHeaders")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditBBSHeaders")>Edit Forum Header</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("MassMail")><img src=$CONFIG{'button_dir'}/icon-send-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("MassMail")>Send Mass-Mailing</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("Reports")><img src=$CONFIG{'button_dir'}/icon-stats.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("Reports")>Generate Reports</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("DeleteLogs")><img src=$CONFIG{'button_dir'}/icon-dbmgr.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("DeleteLogs")>Delete Unnecessary Logs</a></td>
</tr>
<tr>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditWords")><img src=$CONFIG{'button_dir'}/icon-edit-badwords.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditWords")>Edit Bad/Flagged Words & Usernames</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("BanUser")><img src=$CONFIG{'button_dir'}/icon-ban-users.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("BanUser")>Ban Users</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("FailedLogins")><img src=$CONFIG{'button_dir'}/icon-dead.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("FailedLogins")>View Failed Logins</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("ViewWarnings")><img src=$CONFIG{'button_dir'}/icon-dead.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("ViewWarnings")>View Warnings To Members</a></td>
</tr>         
<tr>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditRules")><img src=$CONFIG{'button_dir'}/icon-edit-badwords.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditRules")>Edit Membership Rules</a></td>
     <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditFrame")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditFrame")>Edit Editor Frame (<I>optional</I>)</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("CreateAdmGroups")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("CreateAdmGroups")>Create AdMaster Groups</a></td>
      <td valign=top align=center width=25%>
         <table border><tr><td><a href=javascript:Go("EditWebsiteDirectory")><img src=$CONFIG{'button_dir'}/icon-edit-mail.gif border=0 width=60 height=60></a></td></tr></table>
         <a href=javascript:Go("EditWebsiteDirectory")>Edit Website Directory</a></td>
</tr>         


   </table></center><p>
   </td></tr></table>
DONE
   exit 0;


}

sub CreateAdmGroups {
	$groupsdb = "$GPath{'admaster_data'}/groups.db";

	tie %groups, "DB_File", $groupsdb;
	$groups{'sex_Male'} = $groups{'sex_Male'} || $groups{'sex_Male'}++;
	$groups{'sex_Female'} = $groups{'sex_Female'} || $groups{'sex_Female'}++;
	$groups{'group_0'} = $groups{'group_0'} || $groups{'group_0'}++;
	$groups{'group_1'} = $groups{'group_1'} || $groups{'group_1'}++;
	$groups{'group_2'} = $groups{'group_2'} || $groups{'group_2'}++;
	$groups{'group_3'} = $groups{'group_3'} || $groups{'group_3'}++;
	$groups{'group_4'} = $groups{'group_4'} || $groups{'group_4'}++;
	$groups{'group_5'} = $groups{'group_5'} || $groups{'group_5'}++;
	$groups{'group_6'} = $groups{'group_6'} || $groups{'group_6'}++;
	$groups{'group_7'} = $groups{'group_7'} || $groups{'group_7'}++;
	$groups{'group_8'} = $groups{'group_8'} || $groups{'group_8'}++;
	$groups{'group_9'} = $groups{'group_9'} || $groups{'group_9'}++;
	$groups{'group_10'} = $groups{'group_10'} || $groups{'group_10'}++;
	$groups{'children_0'} = $groups{'children_0'} || $groups{'children_0'}++;
	$groups{'children_1'} = $groups{'children_1'} || $groups{'children_1'}++;
	$groups{'children_2'} = $groups{'children_2'} || $groups{'children_2'}++;
	$groups{'children_3'} = $groups{'children_3'} || $groups{'children_3'}++;
	$groups{'children_4'} = $groups{'children_4'} || $groups{'children_4'}++;
	$groups{'children_5'} = $groups{'children_5'} || $groups{'children_5'}++;
	$groups{'children_6'} = $groups{'children_6'} || $groups{'children_6'}++;
	$groups{'children_7_or_more'} = $groups{'children_7_or_more'} || $groups{'children_7_or_more'}++;
	$groups{'income_lt30k'} = $groups{'income_lt30k'} || $groups{'income_lt30k'}++;
	$groups{'income_30k-50k'} = $groups{'income_30k-50k'} || $groups{'income_30k-50k'}++;
	$groups{'income_50k-75k'} = $groups{'income_50k-75k'} || $groups{'income_50k-75k'}++;
	$groups{'income_75k-100k'} = $groups{'income_75k-100k'} || $groups{'income_75k-100k'}++;
	$groups{'income_100k-200k'} = $groups{'income_100k-200k'} || $groups{'income_100k-200k'}++;
	$groups{'income_gt200k'} = $groups{'income_gt200k'} || $groups{'income_gt200k'}++;
	$groups{'primary_computer_usage_Home'} = $groups{'primary_computer_usage_Home'} || $groups{'primary_computer_usage_Home'}++;
	$groups{'primary_computer_usage_Office'} = $groups{'primary_computer_usage_Office'} || $groups{'primary_computer_usage_Office'}++;
	$groups{'primary_computer_usage_School'} = $groups{'primary_computer_usage_School'} || $groups{'primary_computer_usage_School'}++;
	$groups{'primary_computer_usage_Home_Office'} = $groups{'primary_computer_usage_Home_Office'} || $groups{'primary_computer_usage_Home_Office'}++;
	$groups{'education_Grade_School'} = $groups{'education_Grade_School'} || $groups{'education_Grade_School'}++;
	$groups{'education_High_School'} = $groups{'education_High_School'} || $groups{'education_High_School'}++;
	$groups{'education_Vocational_Technical_School'} = $groups{'education_Vocational_Technical_School'} || $groups{'education_Vocational_Technical_School'}++;
	$groups{'education_Some_College'} = $groups{'education_Some_College'} || $groups{'education_Some_College'}++;
	$groups{'education_College_Graduate'} = $groups{'education_College_Graduate'} || $groups{'education_College_Graduate'}++;
	$groups{'education_Post_Graduate'} = $groups{'education_Post_Graduate'} || $groups{'education_Post_Graduate'}++;
	$groups{'employment_Accounting'} = $groups{'employment_Accounting'} || $groups{'employment_Accounting'}++;
	$groups{'employment_Banking'} = $groups{'employment_Banking'} || $groups{'employment_Banking'}++;
	$groups{'employment_BizServices'} = $groups{'employment_BizServices'} || $groups{'employment_BizServices'}++;
	$groups{'employment_Clerical'} = $groups{'employment_Clerical'} || $groups{'employment_Clerical'}++;
	$groups{'employment_Computerware'} = $groups{'employment_Computerware'} || $groups{'employment_Computerware'}++;
	$groups{'employment_Consulting'} = $groups{'employment_Consulting'} || $groups{'employment_Consulting'}++;
	$groups{'employment_Constructionland'} = $groups{'employment_Constructionland'} || $groups{'employment_Constructionland'}++;
	$groups{'employment_ConsumerRetailWhole'} = $groups{'employment_ConsumerRetailWhole'} || $groups{'employment_ConsumerRetailWhole'}++;
	$groups{'employment_CustomerSvc'} = $groups{'employment_CustomerSvc'} || $groups{'employment_CustomerSvc'}++;
	$groups{'employment_Education'} = $groups{'employment_Education'} || $groups{'employment_Education'}++;
	$groups{'employment_Engineering'} = $groups{'employment_Engineering'} || $groups{'employment_Engineering'}++;
	$groups{'employment_Entertainment'} = $groups{'employment_Entertainment'} || $groups{'employment_Entertainment'}++;
	$groups{'employment_Executive'} = $groups{'employment_Executive'} || $groups{'employment_Executive'}++;
	$groups{'employment_GenAdminSupe'} = $groups{'employment_GenAdminSupe'} || $groups{'employment_GenAdminSupe'}++;
	$groups{'employment_GovMil'} = $groups{'employment_GovMil'} || $groups{'employment_GovMil'}++;
	$groups{'employment_Homemaker'} = $groups{'employment_Homemaker'} || $groups{'employment_Homemaker'}++;
	$groups{'employment_Hospitality'} = $groups{'employment_Hospitality'} || $groups{'employment_Hospitality'}++;
	$groups{'employment_HumanResources'} = $groups{'employment_HumanResources'} || $groups{'employment_HumanResources'}++;
	$groups{'employment_Manufacturing'} = $groups{'employment_Manufacturing'} || $groups{'employment_Manufacturing'}++;
	$groups{'employment_Legal'} = $groups{'employment_Legal'} || $groups{'employment_Legal'}++;
	$groups{'employment_Managerial'} = $groups{'employment_Managerial'} || $groups{'employment_Managerial'}++;
	$groups{'employment_Marketing'} = $groups{'employment_Marketing'} || $groups{'employment_Marketing'}++;
	$groups{'employment_Media'} = $groups{'employment_Media'} || $groups{'employment_Media'}++;
	$groups{'employment_Health'} = $groups{'employment_Health'} || $groups{'employment_Health'}++;
	$groups{'employment_NonProfit'} = $groups{'employment_NonProfit'} || $groups{'employment_NonProfit'}++;
	$groups{'employment_RandD'} = $groups{'employment_RandD'} || $groups{'employment_RandD'}++;
	$groups{'employment_RealEstate'} = $groups{'employment_RealEstate'} || $groups{'employment_RealEstate'}++;
	$groups{'employment_Sales'} = $groups{'employment_Sales'} || $groups{'employment_Sales'}++;
	$groups{'employment_Trade_Craft'} = $groups{'employment_Trade_Craft'} || $groups{'employment_Trade_Craft'}++;
	$groups{'employment_StudentCollege'} = $groups{'employment_StudentCollege'} || $groups{'employment_StudentCollege'}++;
	$groups{'employment_Self'} = $groups{'employment_Self'} || $groups{'employment_Self'}++;
	$groups{'employment_Retired'} = $groups{'employment_Retired'} || $groups{'employment_Retired'}++;
	$groups{'employment_Unemployed'} = $groups{'employment_Unemployed'} || $groups{'employment_Unemployed'}++;

	$cn = "site_community_$Community1_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community2_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community3_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community4_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community5_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community6_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community7_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community8_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community9_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community10_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community11_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community12_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community13_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community14_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community15_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community16_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community17_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community18_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community19_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	$cn = "site_community_$Community20_Name";
	$groups{$cn} = $groups{$cn} || $groups{$cn}++;

	delete $groups{'site_community_'};

	@cats = ("Autos","Business_Finance","Celebrities","Computers","Family","Fitness","Friends","Games","Health","Hobbies_Crafts","Internet & Web","Issues_Causes","Military","Movies","Music","Pets","Religion & Beliefs","Romance","Schools_Education","Science","Seniors","Sports","Teen","Travel","TV");
	foreach my $c (@cats) {
		my $cn = "site_category_$c";
		$groups{$cn} = $groups{$cn} || $groups{$cn}++;
	}

	untie %groups;

 	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=\"#ffffcc\"><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	print "<P>\n";
	exit;
}


sub get_file_info {
	local ($UserName) = $_[0];
	local ($UserCommunity) = $_[1];
	my ($file, $filename);

	if ($CONFIG{'useSubCommunities'} eq "YES") {
		$CW_base = $CONFIG{'PAGEMASTER_base'} . "/" . $IUSER{'community'};
		$CW_base_html = $CONFIG{'PAGEMASTER_community_html'} . "/" . $IUSER{'community'};
	}
	else {
		$CW_base = $CONFIG{'PAGEMASTER_base'};
		$CW_base_html = $CONFIG{'PAGEMASTER_community_html'};
	}

	$size = `du -b -s $CW_base/$UserName/`;
	$size =~ s/\D//g;
	$kilobytes = $size/1000;
	$totalbytes = $totalbytes + $kilobytes;

	my $list = `find $CW_base/$UserName/ -name \\*`;
	my @r = split(/\n/, $list);
	$num_of_files = $#r + 1;
}




sub save_communities {
	$FORM{'Community1_Name'} = lc($FORM{'Community1_Name'});
	$FORM{'Community2_Name'} = lc($FORM{'Community2_Name'});
	$FORM{'Community3_Name'} = lc($FORM{'Community3_Name'});
	$FORM{'Community4_Name'} = lc($FORM{'Community4_Name'});
	$FORM{'Community5_Name'} = lc($FORM{'Community5_Name'});
	$FORM{'Community6_Name'} = lc($FORM{'Community6_Name'});
	$FORM{'Community7_Name'} = lc($FORM{'Community7_Name'});
	$FORM{'Community8_Name'} = lc($FORM{'Community8_Name'});
	$FORM{'Community9_Name'} = lc($FORM{'Community9_Name'});
	$FORM{'Community10_Name'} = lc($FORM{'Community10_Name'});
	$FORM{'Community11_Name'} = lc($FORM{'Community11_Name'});
	$FORM{'Community12_Name'} = lc($FORM{'Community12_Name'});
	$FORM{'Community13_Name'} = lc($FORM{'Community13_Name'});
	$FORM{'Community14_Name'} = lc($FORM{'Community14_Name'});
	$FORM{'Community15_Name'} = lc($FORM{'Community15_Name'});
	$FORM{'Community16_Name'} = lc($FORM{'Community16_Name'});
	$FORM{'Community17_Name'} = lc($FORM{'Community17_Name'});
	$FORM{'Community18_Name'} = lc($FORM{'Community18_Name'});
	$FORM{'Community19_Name'} = lc($FORM{'Community19_Name'});
	$FORM{'Community20_Name'} = lc($FORM{'Community20_Name'});
	$FORM{'Community21_Name'} = lc($FORM{'Community21_Name'});
	$FORM{'Community22_Name'} = lc($FORM{'Community22_Name'});
	$FORM{'Community23_Name'} = lc($FORM{'Community23_Name'});
	$FORM{'Community24_Name'} = lc($FORM{'Community24_Name'});
	$FORM{'Community25_Name'} = lc($FORM{'Community25_Name'});
	$FORM{'Community26_Name'} = lc($FORM{'Community26_Name'});
	$FORM{'Community27_Name'} = lc($FORM{'Community27_Name'});
	$FORM{'Community28_Name'} = lc($FORM{'Community28_Name'});
	$FORM{'Community29_Name'} = lc($FORM{'Community29_Name'});
	$FORM{'Community30_Name'} = lc($FORM{'Community30_Name'});
	$FORM{'Community31_Name'} = lc($FORM{'Community31_Name'});
	$FORM{'Community32_Name'} = lc($FORM{'Community32_Name'});
	$FORM{'Community33_Name'} = lc($FORM{'Community33_Name'});
	$FORM{'Community34_Name'} = lc($FORM{'Community34_Name'});
	$FORM{'Community35_Name'} = lc($FORM{'Community35_Name'});
	$FORM{'Community36_Name'} = lc($FORM{'Community36_Name'});
	$FORM{'Community37_Name'} = lc($FORM{'Community37_Name'});
	$FORM{'Community38_Name'} = lc($FORM{'Community38_Name'});
	$FORM{'Community39_Name'} = lc($FORM{'Community39_Name'});
	$FORM{'Community40_Name'} = lc($FORM{'Community40_Name'});


	$FORM{'Community1_Name'} =~ s/\W//g;
	$FORM{'Community2_Name'} =~ s/\W//g;
	$FORM{'Community3_Name'} =~ s/\W//g;
	$FORM{'Community4_Name'} =~ s/\W//g;
	$FORM{'Community5_Name'} =~ s/\W//g;
	$FORM{'Community6_Name'} =~ s/\W//g;
	$FORM{'Community7_Name'} =~ s/\W//g;
	$FORM{'Community8_Name'} =~ s/\W//g;
	$FORM{'Community9_Name'} =~ s/\W//g;
	$FORM{'Community10_Name'} =~ s/\W//g;
	$FORM{'Community11_Name'} =~ s/\W//g;
	$FORM{'Community12_Name'} =~ s/\W//g;
	$FORM{'Community13_Name'} =~ s/\W//g;
	$FORM{'Community14_Name'} =~ s/\W//g;
	$FORM{'Community15_Name'} =~ s/\W//g;
	$FORM{'Community16_Name'} =~ s/\W//g;
	$FORM{'Community17_Name'} =~ s/\W//g;
	$FORM{'Community18_Name'} =~ s/\W//g;
	$FORM{'Community19_Name'} =~ s/\W//g;
	$FORM{'Community20_Name'} =~ s/\W//g;
	$FORM{'Community21_Name'} =~ s/\W//g;
	$FORM{'Community22_Name'} =~ s/\W//g;
	$FORM{'Community23_Name'} =~ s/\W//g;
	$FORM{'Community24_Name'} =~ s/\W//g;
	$FORM{'Community25_Name'} =~ s/\W//g;
	$FORM{'Community26_Name'} =~ s/\W//g;
	$FORM{'Community27_Name'} =~ s/\W//g;
	$FORM{'Community28_Name'} =~ s/\W//g;
	$FORM{'Community29_Name'} =~ s/\W//g;
	$FORM{'Community30_Name'} =~ s/\W//g;
	$FORM{'Community31_Name'} =~ s/\W//g;
	$FORM{'Community32_Name'} =~ s/\W//g;
	$FORM{'Community33_Name'} =~ s/\W//g;
	$FORM{'Community34_Name'} =~ s/\W//g;
	$FORM{'Community35_Name'} =~ s/\W//g;
	$FORM{'Community36_Name'} =~ s/\W//g;
	$FORM{'Community37_Name'} =~ s/\W//g;
	$FORM{'Community38_Name'} =~ s/\W//g;
	$FORM{'Community39_Name'} =~ s/\W//g;
	$FORM{'Community40_Name'} =~ s/\W//g;

	$fn = "$GPath{'community_data'}/list.pm";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "\$Communities_List  = <<EONCOM;\n";
	if ($FORM{'Community1_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community1_Name'}>$FORM{'Community1_Description'}\n";}
	if ($FORM{'Community2_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community2_Name'}>$FORM{'Community2_Description'}\n";}
	if ($FORM{'Community3_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community3_Name'}>$FORM{'Community3_Description'}\n";}
	if ($FORM{'Community4_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community4_Name'}>$FORM{'Community4_Description'}\n";}
	if ($FORM{'Community5_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community5_Name'}>$FORM{'Community5_Description'}\n";}
	if ($FORM{'Community6_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community6_Name'}>$FORM{'Community6_Description'}\n";}
	if ($FORM{'Community7_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community7_Name'}>$FORM{'Community7_Description'}\n";}
	if ($FORM{'Community8_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community8_Name'}>$FORM{'Community8_Description'}\n";}
	if ($FORM{'Community9_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community9_Name'}>$FORM{'Community9_Description'}\n";}
	if ($FORM{'Community10_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community10_Name'}>$FORM{'Community10_Description'}\n";}
	if ($FORM{'Community11_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community11_Name'}>$FORM{'Community11_Description'}\n";}
	if ($FORM{'Community12_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community12_Name'}>$FORM{'Community12_Description'}\n";}
	if ($FORM{'Community13_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community13_Name'}>$FORM{'Community13_Description'}\n";}
	if ($FORM{'Community14_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community14_Name'}>$FORM{'Community14_Description'}\n";}
	if ($FORM{'Community15_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community15_Name'}>$FORM{'Community15_Description'}\n";}
	if ($FORM{'Community16_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community16_Name'}>$FORM{'Community16_Description'}\n";}
	if ($FORM{'Community17_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community17_Name'}>$FORM{'Community17_Description'}\n";}
	if ($FORM{'Community18_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community18_Name'}>$FORM{'Community18_Description'}\n";}
	if ($FORM{'Community19_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community19_Name'}>$FORM{'Community19_Description'}\n";}
	if ($FORM{'Community20_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community20_Name'}>$FORM{'Community20_Description'}\n";}
	if ($FORM{'Community21_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community21_Name'}>$FORM{'Community21_Description'}\n";}
	if ($FORM{'Community22_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community22_Name'}>$FORM{'Community22_Description'}\n";}
	if ($FORM{'Community23_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community23_Name'}>$FORM{'Community23_Description'}\n";}
	if ($FORM{'Community24_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community24_Name'}>$FORM{'Community24_Description'}\n";}
	if ($FORM{'Community25_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community25_Name'}>$FORM{'Community25_Description'}\n";}
	if ($FORM{'Community26_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community26_Name'}>$FORM{'Community26_Description'}\n";}
	if ($FORM{'Community27_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community27_Name'}>$FORM{'Community27_Description'}\n";}
	if ($FORM{'Community28_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community28_Name'}>$FORM{'Community28_Description'}\n";}
	if ($FORM{'Community29_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community29_Name'}>$FORM{'Community29_Description'}\n";}
	if ($FORM{'Community30_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community30_Name'}>$FORM{'Community30_Description'}\n";}
	if ($FORM{'Community31_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community31_Name'}>$FORM{'Community31_Description'}\n";}
	if ($FORM{'Community32_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community32_Name'}>$FORM{'Community32_Description'}\n";}
	if ($FORM{'Community33_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community33_Name'}>$FORM{'Community33_Description'}\n";}
	if ($FORM{'Community34_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community34_Name'}>$FORM{'Community34_Description'}\n";}
	if ($FORM{'Community35_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community35_Name'}>$FORM{'Community35_Description'}\n";}
	if ($FORM{'Community36_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community36_Name'}>$FORM{'Community36_Description'}\n";}
	if ($FORM{'Community37_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community37_Name'}>$FORM{'Community37_Description'}\n";}
	if ($FORM{'Community38_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community38_Name'}>$FORM{'Community38_Description'}\n";}
	if ($FORM{'Community39_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community39_Name'}>$FORM{'Community39_Description'}\n";}
	if ($FORM{'Community40_Name'} ne "") {print FILE "<OPTION VALUE=$FORM{'Community40_Name'}>$FORM{'Community40_Description'}\n";}
	print FILE "EONCOM\n\n\n";

	print FILE "\$Community1_Name = \"$FORM{'Community1_Name'}\";\n";
	print FILE "\$Community1_Description = \"$FORM{'Community1_Description'}\";\n";
	print FILE "\$icon1 = \"$FORM{'icon1'}\";\n";

	print FILE "\$Community2_Name = \"$FORM{'Community2_Name'}\";\n";
	print FILE "\$Community2_Description = \"$FORM{'Community2_Description'}\";\n";
	print FILE "\$icon2 = \"$FORM{'icon2'}\";\n";

	print FILE "\$Community3_Name = \"$FORM{'Community3_Name'}\";\n";
	print FILE "\$Community3_Description = \"$FORM{'Community3_Description'}\";\n";
	print FILE "\$icon3 = \"$FORM{'icon3'}\";\n";

	print FILE "\$Community4_Name = \"$FORM{'Community4_Name'}\";\n";
	print FILE "\$Community4_Description = \"$FORM{'Community4_Description'}\";\n";
	print FILE "\$icon4 = \"$FORM{'icon4'}\";\n";

	print FILE "\$Community5_Name = \"$FORM{'Community5_Name'}\";\n";
	print FILE "\$Community5_Description = \"$FORM{'Community5_Description'}\";\n";
	print FILE "\$icon5 = \"$FORM{'icon5'}\";\n";

	print FILE "\$Community6_Name = \"$FORM{'Community6_Name'}\";\n";
	print FILE "\$Community6_Description = \"$FORM{'Community6_Description'}\";\n";
	print FILE "\$icon6 = \"$FORM{'icon6'}\";\n";

	print FILE "\$Community7_Name = \"$FORM{'Community7_Name'}\";\n";
	print FILE "\$Community7_Description = \"$FORM{'Community7_Description'}\";\n";
	print FILE "\$icon7 = \"$FORM{'icon7'}\";\n";

	print FILE "\$Community8_Name = \"$FORM{'Community8_Name'}\";\n";
	print FILE "\$Community8_Description = \"$FORM{'Community8_Description'}\";\n";
	print FILE "\$icon8 = \"$FORM{'icon8'}\";\n";

	print FILE "\$Community9_Name = \"$FORM{'Community9_Name'}\";\n";
	print FILE "\$Community9_Description = \"$FORM{'Community9_Description'}\";\n";
	print FILE "\$icon9 = \"$FORM{'icon9'}\";\n";

	print FILE "\$Community10_Name = \"$FORM{'Community10_Name'}\";\n";
	print FILE "\$Community10_Description = \"$FORM{'Community10_Description'}\";\n";
	print FILE "\$icon10 = \"$FORM{'icon10'}\";\n";

	print FILE "\$Community11_Name = \"$FORM{'Community11_Name'}\";\n";
	print FILE "\$Community11_Description = \"$FORM{'Community11_Description'}\";\n";
	print FILE "\$icon11 = \"$FORM{'icon11'}\";\n";

	print FILE "\$Community12_Name = \"$FORM{'Community12_Name'}\";\n";
	print FILE "\$Community12_Description = \"$FORM{'Community12_Description'}\";\n";
	print FILE "\$icon12 = \"$FORM{'icon12'}\";\n";

	print FILE "\$Community13_Name = \"$FORM{'Community13_Name'}\";\n";
	print FILE "\$Community13_Description = \"$FORM{'Community13_Description'}\";\n";
	print FILE "\$icon13 = \"$FORM{'icon13'}\";\n";

	print FILE "\$Community14_Name = \"$FORM{'Community14_Name'}\";\n";
	print FILE "\$Community14_Description = \"$FORM{'Community14_Description'}\";\n";
	print FILE "\$icon14 = \"$FORM{'icon14'}\";\n";

	print FILE "\$Community15_Name = \"$FORM{'Community15_Name'}\";\n";
	print FILE "\$Community15_Description = \"$FORM{'Community15_Description'}\";\n";
	print FILE "\$icon15 = \"$FORM{'icon15'}\";\n";

	print FILE "\$Community16_Name = \"$FORM{'Community16_Name'}\";\n";
	print FILE "\$Community16_Description = \"$FORM{'Community16_Description'}\";\n";
	print FILE "\$icon16 = \"$FORM{'icon16'}\";\n";

	print FILE "\$Community17_Name = \"$FORM{'Community17_Name'}\";\n";
	print FILE "\$Community17_Description = \"$FORM{'Community17_Description'}\";\n";
	print FILE "\$icon17 = \"$FORM{'icon17'}\";\n";

	print FILE "\$Community18_Name = \"$FORM{'Community18_Name'}\";\n";
	print FILE "\$Community18_Description = \"$FORM{'Community18_Description'}\";\n";
	print FILE "\$icon18 = \"$FORM{'icon18'}\";\n";

	print FILE "\$Community19_Name = \"$FORM{'Community19_Name'}\";\n";
	print FILE "\$Community19_Description = \"$FORM{'Community19_Description'}\";\n";
	print FILE "\$icon19 = \"$FORM{'icon19'}\";\n";

	print FILE "\$Community20_Name = \"$FORM{'Community20_Name'}\";\n";
	print FILE "\$Community20_Description = \"$FORM{'Community20_Description'}\";\n";
	print FILE "\$icon20 = \"$FORM{'icon20'}\";\n";

	print FILE "\$Community21_Name = \"$FORM{'Community21_Name'}\";\n";
	print FILE "\$Community21_Description = \"$FORM{'Community21_Description'}\";\n";
	print FILE "\$icon21 = \"$FORM{'icon21'}\";\n";

	print FILE "\$Community22_Name = \"$FORM{'Community22_Name'}\";\n";
	print FILE "\$Community22_Description = \"$FORM{'Community22_Description'}\";\n";
	print FILE "\$icon22 = \"$FORM{'icon22'}\";\n";

	print FILE "\$Community23_Name = \"$FORM{'Community23_Name'}\";\n";
	print FILE "\$Community23_Description = \"$FORM{'Community23_Description'}\";\n";
	print FILE "\$icon23 = \"$FORM{'icon23'}\";\n";

	print FILE "\$Community24_Name = \"$FORM{'Community24_Name'}\";\n";
	print FILE "\$Community24_Description = \"$FORM{'Community24_Description'}\";\n";
	print FILE "\$icon24 = \"$FORM{'icon24'}\";\n";

	print FILE "\$Community25_Name = \"$FORM{'Community25_Name'}\";\n";
	print FILE "\$Community25_Description = \"$FORM{'Community25_Description'}\";\n";
	print FILE "\$icon25 = \"$FORM{'icon25'}\";\n";

	print FILE "\$Community26_Name = \"$FORM{'Community26_Name'}\";\n";
	print FILE "\$Community26_Description = \"$FORM{'Community26_Description'}\";\n";
	print FILE "\$icon26 = \"$FORM{'icon26'}\";\n";

	print FILE "\$Community27_Name = \"$FORM{'Community27_Name'}\";\n";
	print FILE "\$Community27_Description = \"$FORM{'Community27_Description'}\";\n";
	print FILE "\$icon27 = \"$FORM{'icon27'}\";\n";

	print FILE "\$Community28_Name = \"$FORM{'Community28_Name'}\";\n";
	print FILE "\$Community28_Description = \"$FORM{'Community28_Description'}\";\n";
	print FILE "\$icon28 = \"$FORM{'icon28'}\";\n";

	print FILE "\$Community29_Name = \"$FORM{'Community29_Name'}\";\n";
	print FILE "\$Community29_Description = \"$FORM{'Community29_Description'}\";\n";
	print FILE "\$icon29 = \"$FORM{'icon29'}\";\n";

	print FILE "\$Community30_Name = \"$FORM{'Community30_Name'}\";\n";
	print FILE "\$Community30_Description = \"$FORM{'Community30_Description'}\";\n";
	print FILE "\$icon30 = \"$FORM{'icon30'}\";\n";

	print FILE "\$Community31_Name = \"$FORM{'Community31_Name'}\";\n";
	print FILE "\$Community31_Description = \"$FORM{'Community31_Description'}\";\n";
	print FILE "\$icon31 = \"$FORM{'icon31'}\";\n";

	print FILE "\$Community32_Name = \"$FORM{'Community32_Name'}\";\n";
	print FILE "\$Community32_Description = \"$FORM{'Community32_Description'}\";\n";
	print FILE "\$icon32 = \"$FORM{'icon32'}\";\n";

	print FILE "\$Community33_Name = \"$FORM{'Community33_Name'}\";\n";
	print FILE "\$Community33_Description = \"$FORM{'Community33_Description'}\";\n";
	print FILE "\$icon33 = \"$FORM{'icon33'}\";\n";

	print FILE "\$Community34_Name = \"$FORM{'Community34_Name'}\";\n";
	print FILE "\$Community34_Description = \"$FORM{'Community34_Description'}\";\n";
	print FILE "\$icon34 = \"$FORM{'icon34'}\";\n";

	print FILE "\$Community35_Name = \"$FORM{'Community35_Name'}\";\n";
	print FILE "\$Community35_Description = \"$FORM{'Community35_Description'}\";\n";
	print FILE "\$icon35 = \"$FORM{'icon35'}\";\n";

	print FILE "\$Community36_Name = \"$FORM{'Community36_Name'}\";\n";
	print FILE "\$Community36_Description = \"$FORM{'Community36_Description'}\";\n";
	print FILE "\$icon36 = \"$FORM{'icon36'}\";\n";

	print FILE "\$Community37_Name = \"$FORM{'Community37_Name'}\";\n";
	print FILE "\$Community37_Description = \"$FORM{'Community37_Description'}\";\n";
	print FILE "\$icon37 = \"$FORM{'icon37'}\";\n";

	print FILE "\$Community38_Name = \"$FORM{'Community38_Name'}\";\n";
	print FILE "\$Community38_Description = \"$FORM{'Community38_Description'}\";\n";
	print FILE "\$icon38 = \"$FORM{'icon38'}\";\n";

	print FILE "\$Community39_Name = \"$FORM{'Community39_Name'}\";\n";
	print FILE "\$Community39_Description = \"$FORM{'Community39_Description'}\";\n";
	print FILE "\$icon39 = \"$FORM{'icon39'}\";\n";

	print FILE "\$Community40_Name = \"$FORM{'Community40_Name'}\";\n";
	print FILE "\$Community40_Description = \"$FORM{'Community40_Description'}\";\n";
	print FILE "\$icon40 = \"$FORM{'icon40'}\";\n";

	print FILE "\n\n\n1;\n";
	close(FILE);

	open(CATS, ">$GPath{'memberindex'}/categorylist.txt");
	print CATS "$FORM{'Community1_Name'}||$FORM{'Community1_Description'}||$FORM{'icon1'}\n";
	print CATS "$FORM{'Community2_Name'}||$FORM{'Community2_Description'}||$FORM{'icon2'}\n";
	print CATS "$FORM{'Community3_Name'}||$FORM{'Community3_Description'}||$FORM{'icon3'}\n";
	print CATS "$FORM{'Community4_Name'}||$FORM{'Community4_Description'}||$FORM{'icon4'}\n";
	print CATS "$FORM{'Community5_Name'}||$FORM{'Community5_Description'}||$FORM{'icon5'}\n";
	print CATS "$FORM{'Community6_Name'}||$FORM{'Community6_Description'}||$FORM{'icon6'}\n";
	print CATS "$FORM{'Community7_Name'}||$FORM{'Community7_Description'}||$FORM{'icon7'}\n";
	print CATS "$FORM{'Community8_Name'}||$FORM{'Community8_Description'}||$FORM{'icon8'}\n";
	print CATS "$FORM{'Community9_Name'}||$FORM{'Community9_Description'}||$FORM{'icon9'}\n";
	print CATS "$FORM{'Community10_Name'}||$FORM{'Community10_Description'}||$FORM{'icon10'}\n";
	print CATS "$FORM{'Community11_Name'}||$FORM{'Community11_Description'}||$FORM{'icon11'}\n";
	print CATS "$FORM{'Community12_Name'}||$FORM{'Community12_Description'}||$FORM{'icon12'}\n";
	print CATS "$FORM{'Community13_Name'}||$FORM{'Community13_Description'}||$FORM{'icon13'}\n";
	print CATS "$FORM{'Community14_Name'}||$FORM{'Community14_Description'}||$FORM{'icon14'}\n";
	print CATS "$FORM{'Community15_Name'}||$FORM{'Community15_Description'}||$FORM{'icon15'}\n";
	print CATS "$FORM{'Community16_Name'}||$FORM{'Community16_Description'}||$FORM{'icon16'}\n";
	print CATS "$FORM{'Community17_Name'}||$FORM{'Community17_Description'}||$FORM{'icon17'}\n";
	print CATS "$FORM{'Community18_Name'}||$FORM{'Community18_Description'}||$FORM{'icon18'}\n";
	print CATS "$FORM{'Community19_Name'}||$FORM{'Community19_Description'}||$FORM{'icon19'}\n";
	print CATS "$FORM{'Community20_Name'}||$FORM{'Community20_Description'}||$FORM{'icon20'}\n";
	print CATS "$FORM{'Community21_Name'}||$FORM{'Community21_Description'}||$FORM{'icon21'}\n";
	print CATS "$FORM{'Community22_Name'}||$FORM{'Community22_Description'}||$FORM{'icon22'}\n";
	print CATS "$FORM{'Community23_Name'}||$FORM{'Community23_Description'}||$FORM{'icon23'}\n";
	print CATS "$FORM{'Community24_Name'}||$FORM{'Community24_Description'}||$FORM{'icon24'}\n";
	print CATS "$FORM{'Community25_Name'}||$FORM{'Community25_Description'}||$FORM{'icon25'}\n";
	print CATS "$FORM{'Community26_Name'}||$FORM{'Community26_Description'}||$FORM{'icon26'}\n";
	print CATS "$FORM{'Community27_Name'}||$FORM{'Community27_Description'}||$FORM{'icon27'}\n";
	print CATS "$FORM{'Community28_Name'}||$FORM{'Community28_Description'}||$FORM{'icon28'}\n";
	print CATS "$FORM{'Community29_Name'}||$FORM{'Community29_Description'}||$FORM{'icon29'}\n";
	print CATS "$FORM{'Community30_Name'}||$FORM{'Community30_Description'}||$FORM{'icon30'}\n";
	print CATS "$FORM{'Community31_Name'}||$FORM{'Community31_Description'}||$FORM{'icon31'}\n";
	print CATS "$FORM{'Community32_Name'}||$FORM{'Community32_Description'}||$FORM{'icon32'}\n";
	print CATS "$FORM{'Community33_Name'}||$FORM{'Community33_Description'}||$FORM{'icon33'}\n";
	print CATS "$FORM{'Community34_Name'}||$FORM{'Community34_Description'}||$FORM{'icon34'}\n";
	print CATS "$FORM{'Community35_Name'}||$FORM{'Community35_Description'}||$FORM{'icon35'}\n";
	print CATS "$FORM{'Community36_Name'}||$FORM{'Community36_Description'}||$FORM{'icon36'}\n";
	print CATS "$FORM{'Community37_Name'}||$FORM{'Community37_Description'}||$FORM{'icon37'}\n";
	print CATS "$FORM{'Community38_Name'}||$FORM{'Community38_Description'}||$FORM{'icon38'}\n";
	print CATS "$FORM{'Community39_Name'}||$FORM{'Community39_Description'}||$FORM{'icon39'}\n";
	print CATS "$FORM{'Community40_Name'}||$FORM{'Community40_Description'}||$FORM{'icon40'}\n";
	close (CATS);


	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community1_Name'};
	if (($FORM{'Community1_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community2_Name'};
	if (($FORM{'Community2_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community3_Name'};
	if (($FORM{'Community3_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community4_Name'};
	if (($FORM{'Community4_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community5_Name'};
	if (($FORM{'Community5_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community6_Name'};
	if (($FORM{'Community6_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community7_Name'};
	if (($FORM{'Community7_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community8_Name'};
	if (($FORM{'Community8_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community9_Name'};
	if (($FORM{'Community9_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community10_Name'};
	if (($FORM{'Community10_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community11_Name'};
	if (($FORM{'Community11_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community12_Name'};
	if (($FORM{'Community12_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community13_Name'};
	if (($FORM{'Community13_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community14_Name'};
	if (($FORM{'Community14_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community15_Name'};
	if (($FORM{'Community15_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community16_Name'};
	if (($FORM{'Community16_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community17_Name'};
	if (($FORM{'Community17_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community18_Name'};
	if (($FORM{'Community18_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community19_Name'};
	if (($FORM{'Community19_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community20_Name'};
	if (($FORM{'Community20_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}



	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community21_Name'};
	if (($FORM{'Community21_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community22_Name'};
	if (($FORM{'Community22_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community23_Name'};
	if (($FORM{'Community23_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community24_Name'};
	if (($FORM{'Community24_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community25_Name'};
	if (($FORM{'Community25_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community26_Name'};
	if (($FORM{'Community26_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community27_Name'};
	if (($FORM{'Community27_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community28_Name'};
	if (($FORM{'Community28_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community29_Name'};
	if (($FORM{'Community29_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community30_Name'};
	if (($FORM{'Community30_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community31_Name'};
	if (($FORM{'Community31_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community32_Name'};
	if (($FORM{'Community32_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community33_Name'};
	if (($FORM{'Community33_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community34_Name'};
	if (($FORM{'Community34_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community35_Name'};
	if (($FORM{'Community35_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community36_Name'};
	if (($FORM{'Community36_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community37_Name'};
	if (($FORM{'Community37_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community38_Name'};
	if (($FORM{'Community38_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community39_Name'};
	if (($FORM{'Community39_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

	$fn = $CONFIG{'PAGEMASTER_base'}. "/" . $FORM{'Community40_Name'};
	if (($FORM{'Community40_Name'} ne "") && (! (-e "$fn"))) {
		mkdir("$fn",0777) || &diehtml("I can't create directory: $fn");
		open(FILE, ">$fn/index.shtml");
		print FILE "<!--#exec cgi=\"$GUrl{'find.cgi_ssi'}\"-->\n";
		close (FILE);
	}

 	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=\"#ffffcc\"><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#cccc99\">\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	print "<P>\n";
	exit;
}



sub list_logs {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD>\n";
	print "<H3><CENTER>Delete Unnecessary Logs</CENTER></H3>\n";
      print "<P>Some log files can grow very quickly and unexpectedly.  You can delete their contents here.\n";
	print "<UL>\n";
	print "<LI><A HREF=\"$GUrl{'community_admin.cgi'}?action=delete_log&logname=failed.txt\">Failed Login Attempts</A>\n";
	print "<LI><A HREF=\"$GUrl{'community_admin.cgi'}?action=delete_log&logname=flags.txt\">Warnings About Member Behavior</A> - This includes pages that are edited by hand but don't include the PLUGIN:HEADER and submiting information that contains words that appear in the /data/watchwords.txt file.\n";
	print "<LI><A HREF=\"$GUrl{'community_admin.cgi'}?action=delete_log&logname=iplog.txt\">IP Log File</A> - This logs logins by IP addresses.  It is used to limit the number of IPs using a membership within 24 hours and to stop one IP from entering more than X (set in the <A HREF=\"$GUrl{'eadmin.cgi'}?action=config\" target=\"NEW\">Configuration Section</A>) memberships per day.\n";
	print "</UL>\n";
      print "<BR><BR><B><CENTER><FONT SIZE=-1>Click to Exit</FONT></CENTER></B>\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub delete_log {
	$fn = "$GPath{'community_data'}/$FORM{'logname'}";

	open(FILE, ">$fn") || &diehtml("I can't write to $fn\n");
	print FILE "";
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Log Deleted</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "Log reset to empty.\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	exit;
}

sub view_report_options {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD><CENTER><H3>Generate Reports</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<P>It is important to note that when dealing with a large number of members, reports can take a few minutes to compile.\n";
	print "The turning on of mutiple reports at the same time can slow things further AND increase server-load (when dealing with many members).\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "<CENTER><TABLE>\n";
	print "<TR><TD>Signups/Day:</TD><TD><INPUT TYPE=checkbox NAME=signups VALUE=1></TD></TR>\n";
	print "<TR><TD>Sex:</TD><TD><INPUT TYPE=checkbox NAME=sex VALUE=1></TD></TR>\n";
	print "<TR><TD>Age (based on age reported):</TD><TD><INPUT TYPE=checkbox NAME=agebyentry VALUE=1></TD></TR>\n";
	print "<TR><TD>Age (based on birthday entered):</TD><TD><INPUT TYPE=checkbox NAME=agebydate VALUE=1></TD></TR>\n";
	print "<TR><TD>Page Views:</TD><TD><INPUT TYPE=checkbox NAME=views VALUE=1></TD></TR>\n";
	print "<TR><TD>User Groups:</TD><TD><INPUT TYPE=checkbox NAME=groups VALUE=1></TD></TR>\n";
	print "<TR><TD>Choice Of Icon:</TD><TD><INPUT TYPE=checkbox NAME=icon VALUE=1></TD></TR>\n";
	print "<TR><TD>Choice Of Community:</TD><TD><INPUT TYPE=checkbox NAME=community VALUE=1></TD></TR>\n";
	print "<TR><TD>Entered State:</TD><TD><INPUT TYPE=checkbox NAME=state VALUE=1></TD></TR>\n";
	print "<TR><TD>Entered Country:</TD><TD><INPUT TYPE=checkbox NAME=country VALUE=1></TD></TR>\n";
	print "<TR><TD>Entered ZipCode:</TD><TD><INPUT TYPE=checkbox NAME=zipcode VALUE=1></TD></TR>\n";
	print "<TR><TD>Entered City:</TD><TD><INPUT TYPE=checkbox NAME=city VALUE=1></TD></TR>\n";
	print "<TR><TD>Referer prior to registering:</TD><TD><INPUT TYPE=checkbox NAME=referer VALUE=1></TD></TR>\n";
	print "<TR><TD COLSPAN=2><INPUT TYPE=hidden NAME=action VALUE=generate_reports>\n<INPUT TYPE=submit VALUE=\"Generate My Reports!\"></TD></TR>\n";
	print "</TABLE></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}



	
sub view_communities {
  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD><CENTER><H3>Edit Communities</H3></TD></TR>\n";
	print "<TR><TD>\n"; 
	print "<P>This is a filing system for all of your members' sites.  Once you have created categories, members can \"file\" their sites into the categories that are relevant to them.  Just fill out the following fields with the categories of your choice and a short description for each one.\n";
	
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";

	print "<P><B>Community 1:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community1_Name\" VALUE=\"$Community1_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon1\" VALUE=\"$icon1\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community1_Description\" VALUE=\"$Community1_Description\">\n";

	print "<P><B>Community 2:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community2_Name\" VALUE=\"$Community2_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon2\" VALUE=\"$icon2\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community2_Description\" VALUE=\"$Community2_Description\">\n";

	print "<P><B>Community 3:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community3_Name\" VALUE=\"$Community3_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon3\" VALUE=\"$icon3\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community3_Description\" VALUE=\"$Community3_Description\">\n";

	print "<P><B>Community 4:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community4_Name\" VALUE=\"$Community4_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon4\" VALUE=\"$icon4\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community4_Description\" VALUE=\"$Community4_Description\">\n";

	print "<P><B>Community 5:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community5_Name\" VALUE=\"$Community5_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon5\" VALUE=\"$icon5\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community5_Description\" VALUE=\"$Community5_Description\">\n";

	print "<P><B>Community 6:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community6_Name\" VALUE=\"$Community6_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon6\" VALUE=\"$icon6\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community6_Description\" VALUE=\"$Community6_Description\">\n";

	print "<P><B>Community 7:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community7_Name\" VALUE=\"$Community7_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon7\" VALUE=\"$icon7\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community7_Description\" VALUE=\"$Community7_Description\">\n";

	print "<P><B>Community 8:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community8_Name\" VALUE=\"$Community8_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon8\" VALUE=\"$icon8\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community8_Description\" VALUE=\"$Community8_Description\">\n";

	print "<P><B>Community 9:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community9_Name\" VALUE=\"$Community9_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon9\" VALUE=\"$icon9\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community9_Description\" VALUE=\"$Community9_Description\">\n";

	print "<P><B>Community 10:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community10_Name\" VALUE=\"$Community10_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon10\" VALUE=\"$icon10\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community10_Description\" VALUE=\"$Community10_Description\">\n";

	print "<P><B>Community 11:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community11_Name\" VALUE=\"$Community11_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon11\" VALUE=\"$icon11\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community11_Description\" VALUE=\"$Community11_Description\">\n";

	print "<P><B>Community 12:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community12_Name\" VALUE=\"$Community12_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon12\" VALUE=\"$icon12\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community12_Description\" VALUE=\"$Community12_Description\">\n";

	print "<P><B>Community 13:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community13_Name\" VALUE=\"$Community13_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon13\" VALUE=\"$icon13\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community13_Description\" VALUE=\"$Community13_Description\">\n";

	print "<P><B>Community 14:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community14_Name\" VALUE=\"$Community14_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon14\" VALUE=\"$icon14\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community14_Description\" VALUE=\"$Community14_Description\">\n";

	print "<P><B>Community 15:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community15_Name\" VALUE=\"$Community15_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon15\" VALUE=\"$icon15\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community15_Description\" VALUE=\"$Community15_Description\">\n";

	print "<P><B>Community 16:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community16_Name\" VALUE=\"$Community16_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon16\" VALUE=\"$icon16\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community16_Description\" VALUE=\"$Community16_Description\">\n";

	print "<P><B>Community 17:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community17_Name\" VALUE=\"$Community17_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon17\" VALUE=\"$icon17\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community17_Description\" VALUE=\"$Community17_Description\">\n";

	print "<P><B>Community 18:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community18_Name\" VALUE=\"$Community18_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon18\" VALUE=\"$icon18\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community18_Description\" VALUE=\"$Community18_Description\">\n";

	print "<P><B>Community 19:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community19_Name\" VALUE=\"$Community19_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon19\" VALUE=\"$icon19\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community19_Description\" VALUE=\"$Community19_Description\">\n";

	print "<P><B>Community 20:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community20_Name\" VALUE=\"$Community20_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon20\" VALUE=\"$icon20\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community20_Description\" VALUE=\"$Community20_Description\">\n";

	print "<P><B>Community 21:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community21_Name\" VALUE=\"$Community21_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon21\" VALUE=\"$icon21\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community21_Description\" VALUE=\"$Community21_Description\">\n";

	print "<P><B>Community 22:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community22_Name\" VALUE=\"$Community22_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon22\" VALUE=\"$icon22\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community22_Description\" VALUE=\"$Community22_Description\">\n";

	print "<P><B>Community 23:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community23_Name\" VALUE=\"$Community23_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon23\" VALUE=\"$icon23\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community23_Description\" VALUE=\"$Community23_Description\">\n";

	print "<P><B>Community 24:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community24_Name\" VALUE=\"$Community24_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon24\" VALUE=\"$icon24\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community24_Description\" VALUE=\"$Community24_Description\">\n";

	print "<P><B>Community 25:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community25_Name\" VALUE=\"$Community25_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon25\" VALUE=\"$icon25\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community25_Description\" VALUE=\"$Community25_Description\">\n";

	print "<P><B>Community 26:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community26_Name\" VALUE=\"$Community26_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon26\" VALUE=\"$icon26\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community26_Description\" VALUE=\"$Community26_Description\">\n";

	print "<P><B>Community 27:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community27_Name\" VALUE=\"$Community27_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon27\" VALUE=\"$icon7\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community27_Description\" VALUE=\"$Community27_Description\">\n";

	print "<P><B>Community 28:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community28_Name\" VALUE=\"$Community28_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon28\" VALUE=\"$icon28\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community28_Description\" VALUE=\"$Community28_Description\">\n";

	print "<P><B>Community 29:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community29_Name\" VALUE=\"$Community29_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon29\" VALUE=\"$icon29\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community29_Description\" VALUE=\"$Community29_Description\">\n";

	print "<P><B>Community 30:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community30_Name\" VALUE=\"$Community30_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon30\" VALUE=\"$icon30\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community30_Description\" VALUE=\"$Community30_Description\">\n";

	print "<P><B>Community 31:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community31_Name\" VALUE=\"$Community31_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon31\" VALUE=\"$icon31\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community31_Description\" VALUE=\"$Community31_Description\">\n";

	print "<P><B>Community 32:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community32_Name\" VALUE=\"$Community32_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon32\" VALUE=\"$icon32\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community32_Description\" VALUE=\"$Community32_Description\">\n";

	print "<P><B>Community 33:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community33_Name\" VALUE=\"$Community33_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon33\" VALUE=\"$icon33\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community33_Description\" VALUE=\"$Community33_Description\">\n";

	print "<P><B>Community 34:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community34_Name\" VALUE=\"$Community34_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon34\" VALUE=\"$icon34\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community34_Description\" VALUE=\"$Community34_Description\">\n";

	print "<P><B>Community 35:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community35_Name\" VALUE=\"$Community35_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon35\" VALUE=\"$icon35\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community35_Description\" VALUE=\"$Community35_Description\">\n";

	print "<P><B>Community 36:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community36_Name\" VALUE=\"$Community36_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon36\" VALUE=\"$icon36\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community36_Description\" VALUE=\"$Community36_Description\">\n";

	print "<P><B>Community 37:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community37_Name\" VALUE=\"$Community37_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon37\" VALUE=\"$icon7\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community37_Description\" VALUE=\"$Community37_Description\">\n";

	print "<P><B>Community 38:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community38_Name\" VALUE=\"$Community38_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon38\" VALUE=\"$icon38\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community38_Description\" VALUE=\"$Community38_Description\">\n";

	print "<P><B>Community 39:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community39_Name\" VALUE=\"$Community39_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon39\" VALUE=\"$icon39\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community39_Description\" VALUE=\"$Community39_Description\">\n";

	print "<P><B>Community 40:</B>\n";
	print "<BR><I><B>Name:</B> <FONT SIZE=-1>All lowercase, without spaces or punctuation.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community40_Name\" VALUE=\"$Community40_Name\">\n";
	print "<BR><I><B>Community Icon:</B> <FONT SIZE=-1>Complete URL - leave blank for none.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"icon40\" VALUE=\"$icon40\">\n";
	print "<BR><I><B>Brief Description:</B> <FONT SIZE=-1>No HTML.</FONT></I>\n";
	print "<BR><input type=text size=40 name=\"Community40_Description\" VALUE=\"$Community40_Description\">\n";

	print "</TD></TR>\n";
	print "<TR><TD COLSPAN=2><P><INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"Save Communities\">\n";
	print "<TR><TD COLSPAN=2><CENTER><P><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TABLE>\n";
	print "</HTML>\n";
	exit;
}


sub get_user {
	local ($UserNum) = $_[0];
	$fn = $GPath{'userpath'} . "/" . $UserNum . "\.usrdat";
	&lock("$usernumber");
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
	($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}) = split(/&&/, $data);

	$hfn = $GPath{'userdirs'} . "/" . $UserNum . "/visit.log";
	if (-e "$hfn") {
		open(HITS,"$hfn") || &diehtml("can't open $hfn");
   		@tfile = <HITS>;
 		close(HITS);
		chomp $tfile[0];
		chomp $tfile[1];
		$IUSER{'num_visits'} = $tfile[0];
		$IUSER{'last_update'} = $tfile[1];
		$IUSER{'IPs'} = $tfile[2];
	}

	&unlock("$usernumber");
	close(FILE);
}




sub get_counter_info {
	local ($UserName) = $_[0];
	local ($UserCommunity) = $_[1];
	my ($file, $filename);
	$Recent_visit = 0;
	$Hits_Total = 0;

	opendir(CFILES, "$CONFIG{'PAGEMASTER_base'}/$UserCommunity/$UserName/"); # || &diehtml("Can't open $CONFIG{'PAGEMASTER_base'}/$UserCommunity/$UserName/");
    	while($file = readdir(CFILES)) {
        	if($file =~ /counter_.*\.txt/) {
			open (CFILE,"$CONFIG{'PAGEMASTER_base'}/$UserCommunity/$UserName/$file") || &diehtml("$CONFIG{'PAGEMASTER_base'}/$UserCommunity/$UserName/$file\n");
				($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$blocks) = stat("$CONFIG{'PAGEMASTER_base'}/$UserCommunity/$UserName/$file");
				if ($Recent_visit < $mtime) {
					$Recent_visit = $mtime;
				}
			  	$CounterValue=<CFILE>;
				$Hits_Total = $Hits_Total + $CounterValue;

			close(CFILE);
		}
	}
	closedir(CFILES);
}


sub view_member {
	local ($UserNum) = $_[0];
	local ($UserName) = $_[1];

	&get_user($UserNum);

 	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
	print "<TR><TD><CENTER><H3>Basic Info</H3></TD><TD><CENTER><H3>Optional Info</H3></TD></TR>\n";
	print "<TR><TD VALIGN=TOP>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'update_profile.cgi'}\">\n";

	print "<P><B>Unique User Number</B><BR>(For use in CommunityForums)<B>:</B>\n";
	print "<BR>$UserNum\n";

	print "<P><B>User Name:</B>\n";
	print "<BR>$IUSER{'username'}\n";
	print "<INPUT TYPE=hidden NAME=\"UserName\" VALUE=\"$IUSER{'username'}\">\n";

	&parse_date($IUSER{'creation_date'});
	print "<P><B>Date Joined:</B>\n";
	print "<BR>$date\n";

	&parse_date($IUSER{'last_update'});
	print "<P><B>Last Visit:</B>\n";
	print "<BR>$date\n";

	print "<P><B>Number of Pageviews:</B>\n";
	print "<BR>$IUSER{'num_visits'}\n";

	if ($CONFIG{'useSubCommunities'} eq "YES") {
		$CW_base = $CONFIG{'PAGEMASTER_base'} . "/" . $IUSER{'community'};
		$CW_base_html = $CONFIG{'PAGEMASTER_community_html'} . "/" . $IUSER{'community'};
	}
	else {
		$CW_base = $CONFIG{'PAGEMASTER_base'};
		$CW_base_html = $CONFIG{'PAGEMASTER_community_html'};
	}

	if (-e "$CW_base/$UserName") {
		&get_file_info($UserName,$IUSER{'community'});
		&get_counter_info($UserName,$IUSER{'community'});

		print "<H4>Webpage Information</H4>\n";

		print "<P><B>Community:</B>\n";
		print "<BR>$IUSER{'community'} \n";
#
# Transfering from one community to another is a server killer and not as stable as I would like.  If people ask for the feature, I'll uncomment it.
#
#		print "<BR><SELECT NAME=USER_community>\n";
#		if ($Community1_Name ne "") {
#			if ($IUSER{'community'} eq $Community1_Name) {
#				print "<OPTION SELECTED>$Community1_Name\n";
#			}
#			else {
#				print "<OPTION>$Community1_Name\n";
#			}
#		}
#		if ($Community2_Name ne "") {
#			if ($IUSER{'community'} eq $Community2_Name) {
#				print "<OPTION SELECTED>$Community2_Name\n";
#			}
#			else {
#				print "<OPTION>$Community2_Name\n";
#			}
#		}
#		if ($Community3_Name ne "") {
#			if ($IUSER{'community'} eq $Community3_Name) {
#				print "<OPTION SELECTED>$Community3_Name\n";
#			}
#			else {
#				print "<OPTION>$Community3_Name\n";
#			}
#		}
#		if ($Community4_Name ne "") {
#			if ($IUSER{'community'} eq $Community4_Name) {
#				print "<OPTION SELECTED>$Community4_Name\n";
#			}
#			else {
#				print "<OPTION>$Community4_Name\n";
#			}
#		}
#		if ($Community5_Name ne "") {
#			if ($IUSER{'community'} eq $Community5_Name) {
#				print "<OPTION SELECTED>$Community5_Name\n";
#			}
#			else {
#				print "<OPTION>$Community5_Name\n";
#			}
#		}
#		if ($Community6_Name ne "") {
#			if ($IUSER{'community'} eq $Community6_Name) {
#				print "<OPTION SELECTED>$Community6_Name\n";
#			}
#			else {
#				print "<OPTION>$Community6_Name\n";
#			}
#		}
#		if ($Community7_Name ne "") {
#			if ($IUSER{'community'} eq $Community7_Name) {
#				print "<OPTION SELECTED>$Community7_Name\n";
#			}
#			else {
#				print "<OPTION>$Community7_Name\n";
#			}
#		}
#		if ($Community8_Name ne "") {
#			if ($IUSER{'community'} eq $Community8_Name) {
#				print "<OPTION SELECTED>$Community8_Name\n";
#			}
#			else {
#				print "<OPTION>$Community8_Name\n";
#			}
#		}
#		if ($Community9_Name ne "") {
#			if ($IUSER{'community'} eq $Community9_Name) {
#				print "<OPTION SELECTED>$Community9_Name\n";
#			}
#			else {
#				print "<OPTION>$Community9_Name\n";
#			}
#		}
#		if ($Community10_Name ne "") {
#			if ($IUSER{'community'} eq $Community10_Name) {
#				print "<OPTION SELECTED>$Community10_Name\n";
#			}
#			else {
#				print "<OPTION>$Community10_Name\n";
#			}
#		}
#		print "</SELECT>\n";


		print "<P><B>Disk Usage:</B>\n";
		print "<BR>$totalbytes kbs\n";

		print "<P><B>Number of Files:</B>\n";
		print "<BR>$num_of_files\n";

		&parse_date($Recent_visit);
		print "<P><B>Last Date Visited:</B>\n";
		print "<BR>$date\n";

		print "<P><B>Total Visited (according to counters):</B>\n";
		print "<BR>$Hits_Total\n";

		print "<P><A HREF=\"javascript:OpenWin(\'$CW_base_html/$IUSER{'username'}/\');\">View The Webpage</A>\n";
	}

	print "<P><B>Real Name:</B>\n";
	print "<BR><input type=text name=\"RealName\" VALUE=\"$IUSER{'realname'}\">\n";

	print "<P><B><A HREF=\"mailto:$IUSER{'email'}\">Email</A>:</B>\n";
	print "<BR><input type=text name=\"Email\" VALUE=\"$IUSER{'email'}\">\n";

	print "<P><B>PassWord:</B>\n";
	print "<BR><input type=text name=\"NewPassWord\" VALUE=\"$IUSER{'password'}\">\n";

	print "<P><B>Online Name:</B>\n";
	print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=HANDLE VALUE=\"$IUSER{'handle'}\">\n";

	print "<P><B>Screen Description:</B>\n";
	print "<BR><textarea COLS=20 ROWS=5 name=\"Description\" WRAP=\"VIRTUAL\">$IUSER{'description'}</textarea>\n";

	print "<P><B>Website Name:</B>\n";
	print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=URLNAME VALUE=\"$IUSER{'urlname'}\">\n";

	print "<P><B>URL:</B>\n";
	print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=URL VALUE=\"$IUSER{'url'}\">\n";

	print "</TD><TD VALIGN=TOP>\n";

	if ($IUSER{'icon'} ne "") {
		print "<IMG SRC=\"$GUrl{'icon_images'}/$IUSER{'icon'}\.gif\">\n";
	}


	if ($IUSER{'status'} eq "hold") {
		print "<TABLE WIDTH=98% BORDER=3 BGCOLOR=#ffffcc>\n";
		print "<TR><TD>\n";

		print "<CENTER><P><B>Membership Awaiting Approval:</B>\n";
		print "<P>Acceptance Letter:\n";
		print "<BR><SELECT NAME=\"acceptance_email\" onChange=\"if (this.form.acceptance_email.selectedIndex >= 2) {self.location.href='#custom';}\">\n";
		print "<OPTION VALUE=\"acceptance_email\" SELECTED>Use Default\n";
		print "<OPTION VALUE=\"NONE\">Do Not Send\n";
		print "<OPTION VALUE=\"Custom\">Custom\n";
		print "<OPTION VALUE=\"Add2Custom\">Append To Default\n";
		print "</SELECT>\n";
		print "<BR><INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Activate User\"></CENTER>\n";

		print "</TD></TR><TR><TD>\n";

		$fn = "$GPath{'community_data'}/email_titles.txt";
		open(FILE, "$fn");
 			$Titles = <FILE>;
		close(FILE);
		chomp $Titles;
		($REJECT1, $REJECT2, $REJECT3) = split(/&&/, $Titles);

		print "<CENTER>Rejection Letter:\n";
		print "<BR><SELECT NAME=\"rejection_email\" onChange=\"if (this.form.rejection_email.selectedIndex = 0) {self.location.href='#custom';}\">\n";
		print "<OPTION VALUE=\"Custom\">Custom\n";
		if ($REJECT1 ne "") {print "<OPTION VALUE=\"rejection_email_1\">$REJECT1\n";}
		if ($REJECT2 ne "") {print "<OPTION VALUE=\"rejection_email_2\">$REJECT2\n";}
		if ($REJECT3 ne "") {print "<OPTION VALUE=\"rejection_email_3\">$REJECT3\n";}
		print "<OPTION VALUE=\"Add2Custom\">Append To Default\n";
		print "<OPTION VALUE=\"NONE\" SELECTED>Do Not Send\n";
		print "</SELECT>\n";

	 	print "<BR><INPUT TYPE=HIDDEN NAME=\"User2Delete\" VALUE=\"$UserName\">\n";
		print "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Delete Applicant\"></CENTER>\n";

		print "</TD></TR></TABLE>\n";
	}

	for $x(0 .. $max_groups) {
		if ($IUSER{'user_level'} == $x) {
			$GROUP_SELECT .= "<OPTION VALUE=\"$x\" SELECTED>$x</OPTION>\n";
		}
		else {
			$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
		}
	}
	print "<P><B>User Group:</B>\n";
	print "<BR><SELECT NAME=USER_user_level>\n";
	print "$GROUP_SELECT\n";
	print "</SELECT>\n";

	print "<P><B>Administrative Notes:</B>\n";
	print "<BR><textarea COLS=20 ROWS=5 name=\"USER_admin_notes\" WRAP=\"VIRTUAL\">$IUSER{'admin_notes'}</textarea>\n";

	print "<P><B>IP Addresses (useful for banning users):</B>\n";
	print "<BR><textarea COLS=20 ROWS=5 name=\"USER_IPs\">\n";
	(@IPs) = split (/\|\|/, $IUSER{'IPs'});
	foreach $IP(@IPs) {
		print "$IP\n";
	}
	print "</textarea>\n";

	if ($COMMUNITY_ZipCode eq "YES") {
		print "<P><B>Zip Code / Postal Code:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_ZipCode VALUE=\"$IUSER{'ZipCode'}\">\n";
	}

	if ($COMMUNITY_Age eq "YES") {
		print "<P><B>Age:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=4 NAME=USER_Age VALUE=\"$IUSER{'Age'}\">\n";
	}

	if ($COMMUNITY_Sex eq "YES") {
		print "<P><B>Sex:</B>\n";
		print "<BR><SELECT NAME=USER_Sex>\n";
		if ($IUSER{'Sex'} eq "Male") {
			print "<OPTION SELECTED>Male\n";
		}
		else {
			print "<OPTION>Male\n";
		}
		if ($IUSER{'Sex'} eq "Female") {
			print "<OPTION SELECTED>Female\n";
		}
		else {
			print "<OPTION>Female\n";
		}
		print "</SELECT>\n";
	}

	if ($COMMUNITY_PhoneNumber eq "YES") {
		print "<P><B>Phone Number (xxx) xxx-xxxx:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Phonenumber VALUE=\"$IUSER{'Phonenumber'}\">\n";
	}

	if ($COMMUNITY_FaxNumber eq "YES") {
		print "<P><B>Fax Number (xxx) xxx-xxxx:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Faxnumber VALUE=\"$IUSER{'Faxnumber'}\">\n";
	}

	if ($COMMUNITY_Address eq "YES") {
		print "<P><B>Address:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Address VALUE=\"$IUSER{'Address'}\">\n";
	}

	if ($COMMUNITY_City eq "YES") {
		print "<P><B>City:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_City VALUE=\"$IUSER{'City'}\">\n";
	}

	if ($COMMUNITY_State eq "YES") {
		print "<P><B>State / Province:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_State VALUE=\"$IUSER{'State'}\">\n";
	}

	if ($COMMUNITY_Country eq "YES") {
		print "<P><B>Country:</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Country VALUE=\"$IUSER{'Country'}\">\n";
	}
	if ($COMMUNITY_Filler1 eq "YES") {
		print "<P><B>$COMMUNITY_Filler1_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler1 VALUE=\"$IUSER{'Filler1'}\">\n";
	}
	if ($COMMUNITY_Filler2 eq "YES") {
		print "<P><B>$COMMUNITY_Filler2_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler2 VALUE=\"$IUSER{'Filler2'}\">\n";
	}
	if ($COMMUNITY_Filler3 eq "YES") {
		print "<P><B>$COMMUNITY_Filler3_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler3 VALUE=\"$IUSER{'Filler3'}\">\n";
	}
	if ($COMMUNITY_Filler4 eq "YES") {
		print "<P><B>$COMMUNITY_Filler4_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler4 VALUE=\"$IUSER{'Filler4'}\">\n";
	}
	if ($COMMUNITY_Filler5 eq "YES") {
		print "<P><B>$COMMUNITY_Filler5_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler5 VALUE=\"$IUSER{'Filler5'}\">\n";
	}
	if ($COMMUNITY_Filler6 eq "YES") {
		print "<P><B>$COMMUNITY_Filler6_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler6 VALUE=\"$IUSER{'Filler6'}\">\n";
	}
	if ($COMMUNITY_Filler7 eq "YES") {
		print "<P><B>$COMMUNITY_Filler7_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler7 VALUE=\"$IUSER{'Filler7'}\">\n";
	}
	if ($COMMUNITY_Filler8 eq "YES") {
		print "<P><B>$COMMUNITY_Filler8_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler8 VALUE=\"$IUSER{'Filler8'}\">\n";
	}
	if ($COMMUNITY_Filler9 eq "YES") {
		print "<P><B>$COMMUNITY_Filler9_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler9 VALUE=\"$IUSER{'Filler9'}\">\n";
	}
	if ($COMMUNITY_Filler10 eq "YES") {
		print "<P><B>$COMMUNITY_Filler10_Prompt</B>\n";
		print "<BR><INPUT TYPE=TEXT SIZE=20 NAME=USER_Filler10 VALUE=\"$IUSER{'Filler10'}\">\n";
	}


	print "<INPUT TYPE=HIDDEN NAME=UserNum VALUE=\"$UserNum\">\n";

	print "</TD></TR>\n";
	if ($IUSER{'status'} ne "hold") {
		print "<TR><TD COLSPAN=2><CENTER><P><INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Update Profile\"></CENTER>\n";
		print "<TR><TD COLSPAN=2><CENTER><BR></CENTER>\n";
		print "<TR><TD COLSPAN=2 BGCOLOR=RED><CENTER><P>\n";
 		print "<INPUT TYPE=HIDDEN NAME=\"User2Delete\" VALUE=\"$UserName\">\n";
		print "<INPUT TYPE=SUBMIT NAME=\"action\" VALUE=\"Delete Member\"></CENTER>\n";
	}
	print "<TR><TD COLSPAN=2>\n";
	print "<A NAME=custom><H4>Custom Email</H4></A>\n";
	print "<TEXTAREA NAME=CUSTOM COLS=60 ROWS=5></TEXTAREA>\n";
	print "</FORM>\n";
	print "</TD></TR></TABLE>\n";

print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wCommunityWindow=window.open(Loc,"wCommunityWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wCommunityWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT
	exit;
}


sub write_user {
	local ($FileNum) = $_[0];
	local ($UserName) = $_[1];
	local ($PassWord) = $_[2];

	$fn = $GPath{'userpath'} . "/" . $FileNum . ".usrdat";

	$IUSER{'last_update'} = time;
	$IUSER{'num_visits'}++;

	&lock("$FileNum");
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$IUSER{'realname'}&&$IUSER{'username'}&&$IUSER{'email'}&&$IUSER{'password'}&&$IUSER{'url'}&&$IUSER{'urlname'}&&$IUSER{'handle'}&&$IUSER{'IPs'}&&$IUSER{'creation_date'}&&$IUSER{'last_update'}&&$IUSER{'num_visits'}&&$IUSER{'Age'}&&$IUSER{'Sex'}&&$IUSER{'user_level'}&&$IUSER{'favetypes'}&&$IUSER{'warnings'}&&$IUSER{'icon'}&&$IUSER{'description'}&&$IUSER{'send_update'}&&$IUSER{'community'}&&$IUSER{'Phonenumber'}&&$IUSER{'Faxnumber'}&&$IUSER{'Address'}&&$IUSER{'State'}&&$IUSER{'Country'}&&$IUSER{'ZipCode'}&&$IUSER{'City'}&&$IUSER{'status'}&&$IUSER{'expiry_date'}&&$IUSER{'monthly_fee'}&&$IUSER{'admin_notes'}&&$IUSER{'history'}&&$IUSER{'Filler1'}&&$IUSER{'Filler2'}&&$IUSER{'Filler3'}&&$IUSER{'Filler4'}&&$IUSER{'Filler5'}&&$IUSER{'Filler6'}&&$IUSER{'Filler7'}&&$IUSER{'Filler8'}&&$IUSER{'Filler9'}&&$IUSER{'Filler10'}\n";
	close(FILE);
	&unlock("$FileNum");
}




sub search_box {
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<BR><CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4>\n";
	print "<TR><TD COLSPAN=3>\n";
	print "<CENTER><form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
	print "Fields: \n";
	print "<SELECT NAME=fields>\n";
	if ($FORM{'fields'} eq "") {
		print "<OPTION VALUE=\"\" SELECTED> All Text Areas</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"\"> All Text Areas</OPTION>\n";
	}

	if ($FORM{'fields'} eq "username") {
		print "<OPTION VALUE=\"username\" SELECTED> User Name</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"username\"> User Name</OPTION>\n";
	}

	if ($FORM{'fields'} eq "email") {
		print "<OPTION VALUE=\"email\" SELECTED> Email Address</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"email\"> Email Address</OPTION>\n";
	}

	if ($FORM{'fields'} eq "url") {
		print "<OPTION VALUE=\"url\" SELECTED> Webpage Address</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"url\"> Webpage Address</OPTION>\n";
	}

	if ($FORM{'fields'} eq "screen_info") {
		print "<OPTION VALUE=\"screen_info\" SELECTED> Screen Information</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"screen_info\"> Screen Information</OPTION>\n";
	}

	if ($FORM{'fields'} eq "phone_numbers") {
		print "<OPTION VALUE=\"phone_numbers\" SELECTED> Phone/Fax Number</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"phone_numbers\"> Phone/Fax Number</OPTION>\n";
	}

	if ($FORM{'fields'} eq "age") {
		print "<OPTION VALUE=\"age\" SELECTED> Age</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"age\"> Age</OPTION>\n";
	}

	if ($FORM{'fields'} eq "sex") {
		print "<OPTION VALUE=\"sex\" SELECTED> Sex (Male/Female)</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"sex\"> Sex (Male/Female)</OPTION>\n";
	}

	if ($FORM{'fields'} eq "level") {
		print "<OPTION VALUE=\"level\" SELECTED> User Group</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"level\"> User Group</OPTION>\n";
	}

	if ($FORM{'fields'} eq "address") {
		print "<OPTION VALUE=\"address\" SELECTED> Street Address</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"address\"> Street Address</OPTION>\n";
	}

	if ($FORM{'fields'} eq "zipcode") {
		print "<OPTION VALUE=\"zipcode\" SELECTED> Zip/Postal Code</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"zipcode\"> Zip/Postal Code</OPTION>\n";
	}

	if ($FORM{'fields'} eq "totalbytes") {
		print "<OPTION VALUE=\"totalbytes\" SELECTED> Total Bytes Used</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"totalbytes\"> Total Bytes Used</OPTION>\n";
	}

	if ($FORM{'fields'} eq "num_files") {
		print "<OPTION VALUE=\"num_files\" SELECTED> Number of Uploaded Files</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"num_files\"> Number of Uploaded Files</OPTION>\n";
	}

	if ($FORM{'fields'} eq "recentvisits") {
		print "<OPTION VALUE=\"recentvisits\" SELECTED> Most Recent Visit to Personal Page</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"recentvisits\"> Most Recent Visit to Personal Page</OPTION>\n";
	}

	if ($FORM{'fields'} eq "total_hits") {
		print "<OPTION VALUE=\"total_hits\" SELECTED> Total Hits to Personal Page</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"total_hits\"> Total Hits to Personal Page</OPTION>\n";
	}

	if ($FORM{'fields'} eq "creation") {
		print "<OPTION VALUE=\"creation\" SELECTED> Date Joined</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"creation\"> Date Joined</OPTION>\n";
	}

	if ($FORM{'fields'} eq "lastupdate") {
		print "<OPTION VALUE=\"lastupdate\" SELECTED> Date of Last Visit</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"lastupdate\"> Date of Last Visit</OPTION>\n";
	}

	if ($FORM{'fields'} eq "notes") {
		print "<OPTION VALUE=\"notes\" SELECTED> Administrative Notes</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"notes\"> Administrative Notes</OPTION>\n";
	}

	if ($FORM{'fields'} eq "fillers") {
		print "<OPTION VALUE=\"fillers\" SELECTED> Custom Fields</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"fillers\"> Custom Fields</OPTION>\n";
	}
	print "</SELECT>\n";


	print "</TD></TR><TR><TD WIDTH=45%>\n";

	print "Perform a text search.\n";

	print "<P>Criteria: <BR>\n";
	print "<SELECT NAME=method>\n";
	if ($FORM{'method'} eq "contains") {
		print "<OPTION VALUE=\"contains\" SELECTED> Contains</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"contains\"> Contains</OPTION>\n";
	}

	if ($FORM{'method'} eq "less") {
		print "<OPTION VALUE=\"less\" SELECTED> is LESS Than or Equal to</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"less\"> is LESS Than or Equal to</OPTION>\n";
	}

	if ($FORM{'method'} eq "greater") {
		print "<OPTION VALUE=\"greater\" SELECTED> is GREATER Than or Equal to</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"greater\"> is GREATER Than or Equal to</OPTION>\n";
	}

	if ($FORM{'method'} eq "not") {
		print "<OPTION VALUE=\"not\" SELECTED> Does NOT Contain</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"not\"> Does NOT Contain</OPTION>\n";
	}

	if ($FORM{'method'} eq "equals") {
		print "<OPTION VALUE=\"equals\" SELECTED> Equals</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"equals\"> Equals</OPTION>\n";
	}

	print "</SELECT>\n";

	print "<BR>String / Value: <BR>\n";
	print "<INPUT TYPE=TEXT SIZE=20 NAME=searchstring VALUE=\"$FORM{'searchstring'}\">\n";

	print "<BR><CENTER><INPUT TYPE=SUBMIT NAME=action VALUE=\"Text Search\">\n";

	print "</TD><TD><H1><B>OR</B></H1></TD><TD WIDTH=45%>\n";
	print "Perform a search based on dates<BR>(only works on fields that are dates).\n";


	print "<P>Criteria:\n";
	print "<BR><SELECT NAME=timemethod>\n";
	if ($FORM{'timemethod'} eq "not") {
		print "<OPTION VALUE=\"equals\" SELECTED> On This Date</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"equals\"> On This Date</OPTION>\n";
	}

	if ($FORM{'timemethod'} eq "not") {
		print "<OPTION VALUE=\"prior\" SELECTED> Prior To</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"prior\"> Prior To</OPTION>\n";
	}

	if ($FORM{'timemethod'} eq "not") {
		print "<OPTION VALUE=\"after\" SELECTED> After</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"after\"> After</OPTION>\n";
	}
	print "</SELECT>\n";


	print "<BR>Date:\n";
	print "<BR>Day:\n";
	print "<SELECT NAME=day>\n";

	if ($FORM{'day'} == 1) {
		print "<OPTION VALUE=\"1\" SELECTED> 1</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"1\"> 1</OPTION>\n";
	}

	if ($FORM{'day'} == 2) {
		print "<OPTION VALUE=\"2\" SELECTED> 2</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"2\"> 2</OPTION>\n";
	}

	if ($FORM{'day'} == 3) {
		print "<OPTION VALUE=\"3\" SELECTED> 3</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"3\"> 3</OPTION>\n";
	}

	if ($FORM{'day'} == 4) {
		print "<OPTION VALUE=\"4\" SELECTED> 4</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"4\"> 4</OPTION>\n";
	}

	if ($FORM{'day'} == 5) {
		print "<OPTION VALUE=\"5\" SELECTED> 5</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"5\"> 5</OPTION>\n";
	}

	if ($FORM{'day'} == 6) {
		print "<OPTION VALUE=\"6\" SELECTED> 6</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"6\"> 6</OPTION>\n";
	}

	if ($FORM{'day'} == 7) {
		print "<OPTION VALUE=\"7\" SELECTED> 7</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"7\"> 7</OPTION>\n";
	}

	if ($FORM{'day'} == 8) {
		print "<OPTION VALUE=\"8\" SELECTED> 8</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"8\"> 8</OPTION>\n";
	}

	if ($FORM{'day'} == 9) {
		print "<OPTION VALUE=\"9\" SELECTED> 9</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"9\"> 9</OPTION>\n";
	}

	if ($FORM{'day'} == 10) {
		print "<OPTION VALUE=\"10\" SELECTED>10</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"10\">10</OPTION>\n";
	}

	if ($FORM{'day'} == 11) {
		print "<OPTION VALUE=\"11\" SELECTED>11</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"11\">11</OPTION>\n";
	}

	if ($FORM{'day'} == 12) {
		print "<OPTION VALUE=\"12\" SELECTED>12</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"12\">12</OPTION>\n";
	}

	if ($FORM{'day'} == 13) {
		print "<OPTION VALUE=\"13\" SELECTED>13</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"13\">13</OPTION>\n";
	}

	if ($FORM{'day'} == 14) {
		print "<OPTION VALUE=\"14\" SELECTED>14</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"14\">14</OPTION>\n";
	}

	if ($FORM{'day'} == 15) {
		print "<OPTION VALUE=\"15\" SELECTED>15</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"15\">15</OPTION>\n";
	}

	if ($FORM{'day'} == 16) {
		print "<OPTION VALUE=\"16\" SELECTED>16</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"16\">16</OPTION>\n";
	}

	if ($FORM{'day'} == 17) {
		print "<OPTION VALUE=\"17\" SELECTED>17</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"17\">17</OPTION>\n";
	}

	if ($FORM{'day'} == 18) {
		print "<OPTION VALUE=\"18\" SELECTED>18</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"18\">18</OPTION>\n";
	}

	if ($FORM{'day'} == 19) {
		print "<OPTION VALUE=\"19\" SELECTED>19</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"19\">19</OPTION>\n";
	}

	if ($FORM{'day'} == 20) {
		print "<OPTION VALUE=\"20\" SELECTED>20</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"20\">20</OPTION>\n";
	}

	if ($FORM{'day'} == 21) {
		print "<OPTION VALUE=\"21\" SELECTED>21</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"21\">21</OPTION>\n";
	}

	if ($FORM{'day'} == 22) {
		print "<OPTION VALUE=\"22\" SELECTED>22</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"22\">22</OPTION>\n";
	}

	if ($FORM{'day'} == 23) {
		print "<OPTION VALUE=\"23\" SELECTED>23</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"23\">23</OPTION>\n";
	}

	if ($FORM{'day'} == 24) {
		print "<OPTION VALUE=\"24\" SELECTED>24</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"24\">24</OPTION>\n";
	}

	if ($FORM{'day'} == 25) {
		print "<OPTION VALUE=\"25\" SELECTED>25</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"25\">25</OPTION>\n";
	}

	if ($FORM{'day'} == 26) {
		print "<OPTION VALUE=\"26\" SELECTED>26</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"26\">26</OPTION>\n";
	}

	if ($FORM{'day'} == 27) {
		print "<OPTION VALUE=\"27\" SELECTED>27</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"27\">27</OPTION>\n";
	}

	if ($FORM{'day'} == 28) {
		print "<OPTION VALUE=\"28\" SELECTED>28</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"28\">28</OPTION>\n";
	}

	if ($FORM{'day'} == 29) {
		print "<OPTION VALUE=\"29\" SELECTED>29</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"29\">29</OPTION>\n";
	}

	if ($FORM{'day'} == 30) {
		print "<OPTION VALUE=\"30\" SELECTED>30</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"30\">30</OPTION>\n";
	}

	if ($FORM{'day'} == 31) {
		print "<OPTION VALUE=\"31\" SELECTED>31</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"31\">31</OPTION>\n";
	}
	print "</SELECT>\n";

	print "Month:\n";
	print "<SELECT NAME=month>\n";
	if ($FORM{'month'} == 1) {
		print "<OPTION VALUE=\"1\" SELECTED> 1</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"1\"> 1</OPTION>\n";
	}

	if ($FORM{'month'} == 2) {
		print "<OPTION VALUE=\"2\" SELECTED> 2</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"2\"> 2</OPTION>\n";
	}

	if ($FORM{'month'} == 3) {
		print "<OPTION VALUE=\"3\" SELECTED> 3</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"3\"> 3</OPTION>\n";
	}

	if ($FORM{'month'} == 4) {
		print "<OPTION VALUE=\"4\" SELECTED> 4</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"4\"> 4</OPTION>\n";
	}

	if ($FORM{'month'} == 5) {
		print "<OPTION VALUE=\"5\" SELECTED> 5</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"5\"> 5</OPTION>\n";
	}

	if ($FORM{'month'} == 6) {
		print "<OPTION VALUE=\"6\" SELECTED> 6</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"6\"> 6</OPTION>\n";
	}

	if ($FORM{'month'} == 7) {
		print "<OPTION VALUE=\"7\" SELECTED> 7</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"7\"> 7</OPTION>\n";
	}

	if ($FORM{'month'} == 8) {
		print "<OPTION VALUE=\"8\" SELECTED> 8</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"8\"> 8</OPTION>\n";
	}

	if ($FORM{'month'} == 9) {
		print "<OPTION VALUE=\"9\" SELECTED> 9</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"9\"> 9</OPTION>\n";
	}

	if ($FORM{'month'} == 10) {
		print "<OPTION VALUE=\"10\" SELECTED>10</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"10\">10</OPTION>\n";
	}

	if ($FORM{'month'} == 11) {
		print "<OPTION VALUE=\"11\" SELECTED>11</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"11\">11</OPTION>\n";
	}

	if ($FORM{'month'} == 12) {
		print "<OPTION VALUE=\"12\" SELECTED>12</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"12\">12</OPTION>\n";
	}
	print "</SELECT>\n";

	print "Year:\n";
	print "<SELECT NAME=year>\n";
	if ($FORM{'year'} == 29) {
		print "<OPTION VALUE=\"29\" SELECTED>1999</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"29\">1999</OPTION>\n";
	}

	if ($FORM{'year'} == 30) {
		print "<OPTION VALUE=\"30\" SELECTED>2000</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"30\">2000</OPTION>\n";
	}

	if ($FORM{'year'} == 31) {
		print "<OPTION VALUE=\"31\" SELECTED>2001</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"31\">2001</OPTION>\n";
	}

	if ($FORM{'year'} == 32) {
		print "<OPTION VALUE=\"32\" SELECTED>2002</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"32\">2002</OPTION>\n";
	}

	if ($FORM{'year'} == 33) {
		print "<OPTION VALUE=\"33\" SELECTED>2003</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"33\">2003</OPTION>\n";
	}

	if ($FORM{'year'} == 34) {
		print "<OPTION VALUE=\"34\" SELECTED>2004</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"34\">2004</OPTION>\n";
	}

	if ($FORM{'year'} == 35) {
		print "<OPTION VALUE=\"35\" SELECTED>2005</OPTION>\n";
	}
	else {
		print "<OPTION VALUE=\"35\">2005</OPTION>\n";
	}
	print "</SELECT>\n";

	print "<BR><CENTER><INPUT TYPE=SUBMIT NAME=action VALUE=\"Date Search\">\n";

	print "</FORM>\n";
	print "</TD></TR>\n";
	print "</TABLE>\n";
}



sub view0users {
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<FONT SIZE=1>All search results are drawn from the Administrative Database.  If it hasn't been re-built recently, new changes will not appear and the information may be outdated.</FONT><BR><BR>\n";

print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wMessageWindow=window.open(Loc,"wMessageWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wMessageWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT
	&search_database("level",0,"equals");

	print "<H4>Group 0 Users:</H4>\n";
	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4>\n";
	$start = $FORM{'start'};
	if ($start eq "") {$start = 0;}
	$lastmem = $start + $CONFIG{'USERS_PER_SCREEN'};
   	for $x($start .. $lastmem) {
		if ($results[$x] ne "") {
			print "$results[$x]\n";
		}
	}
	print "</TABLE>\n";
	if ($lastmem < $foundmembers) {
		print "<CENTER><A HREF=\"$GUrl{'community_admin.cgi'}?action=" . &urlencode($FORM{'action'}) . "&start=$lastmem&timemethod=$FORM{'timemethod'}&fields=$FORM{'fields'}&searchstring=$FORM{'searchstring'}&method=$FORM{'method'}&day=$FORM{'day'}&month=$FORM{'month'}&year=$FORM{'year'}\">Next</A></CENTER>\n";
	}	exit;
}




sub view_members {
print <<EOT;
	<SCRIPT LANGUAGE="javascript">
	<!--
	   function OpenWin(Loc) {
      	wMessageWindow=window.open(Loc,"wMessageWindow","toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=$CONFIG{'ADMIN_WINDOW_WIDTH'},height=$CONFIG{'ADMIN_WINDOW_HEIGHT'}");
	      wMessageWindow.focus();
	   }
	// -->
	</SCRIPT>
EOT

	$days = $FORM{'day'} * 86400;

	if ($FORM{'month'} == 1) {$month = 0;}
	elsif ($FORM{'month'} == 2) {$month = 31;}
	elsif ($FORM{'month'} == 3) {$month = 59;}
	elsif ($FORM{'month'} == 4) {$month = 90;}
	elsif ($FORM{'month'} == 5) {$month = 120;}
	elsif ($FORM{'month'} == 6) {$month = 151;}
	elsif ($FORM{'month'} == 7) {$month = 181;}
	elsif ($FORM{'month'} == 8) {$month = 212;}
	elsif ($FORM{'month'} == 9) {$month = 243;}
	elsif ($FORM{'month'} == 10) {$month = 273;}
	elsif ($FORM{'month'} == 11) {$month = 304;}
	elsif ($FORM{'month'} == 12) {$month = 334;}
	$month = $month * 86400;

	$year = ($FORM{'year'} * 365 * 86400) + (7 * 86400); # 7 leap years since 1970, will need to be changed in 2004 (no leap year on centenials for some reason?  Blame the astronomers;=))

	$time2check = $year + $month + $days;

	if ($FORM{'action'} eq "Text Search") {
		&search_database($FORM{'fields'},$FORM{'searchstring'},$FORM{'method'});
	}
	if ($FORM{'action'} eq "Date Search") {
		$time = 
		&time_search_database($FORM{'fields'},$time2check,$FORM{'timemethod'});
	}

	print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4>\n";
	$start = $FORM{'start'};
	if ($start eq "") {$start = 0;}
	$lastmem = $start + $CONFIG{'USERS_PER_SCREEN'};
   	for $x($start .. $lastmem) {
		if ($results[$x] ne "") {
			print "$results[$x]\n";
		}
	}
	print "</TABLE>\n";
	$lastmem++;
	if ($lastmem < $foundmembers) {
		print "<CENTER><A HREF=\"$GUrl{'community_admin.cgi'}?action=$FORM{'action'}&start=$lastmem&timemethod=$FORM{'timemethod'}&fields=$FORM{'fields'}&searchstring=$FORM{'searchstring'}&method=$FORM{'method'}&day=$FORM{'day'}&month=$FORM{'month'}&year=$FORM{'year'}\">Next</A></CENTER>\n";
	}
	&search_box;
}	






sub build_database {
    	opendir(FILES, "$CONFIG{'data_dir'}/users/") || die ERROR("Can't open directory");

    	while($file = readdir(FILES)) {
	     	if($file =~ /.*\.usrdat/) {
			$data = "";
			($i = $file) =~ s/\..*//g;
			$fn = $GPath{'userpath'} . "/" . $file;
			$filenum = $file;
			$filenum =~ s/\.usrdat//;
			open(FILE, "$fn") || &diehtml("I can't open $fn\n");
			@datafile = <FILE>;
			$mline = "";
			foreach $line (@datafile) {
				chomp $line;
				$mline .= $line;
	            }
			($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $IUSER{'IPs'}, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}, $IUSER{'status'}, $IUSER{'expiry_date'}, $IUSER{'monthly_fee'}, $IUSER{'admin_notes'}, $IUSER{'history'}, $IUSER{'BirthDay'}, $IUSER{'BirthMonth'}, $IUSER{'BirthYear'}, $IUSER{'Filler1'}, $IUSER{'Filler2'}, $IUSER{'Filler3'}, $IUSER{'Filler4'}, $IUSER{'Filler5'}, $IUSER{'Filler6'}, $IUSER{'Filler7'}, $IUSER{'Filler8'}, $IUSER{'Filler9'}, $IUSER{'Filler10'}, $IUSER{'FirstName'}, $IUSER{'Initial'}, $IUSER{'LastName'}, $IUSER{'Referer'}) = split(/&&/, $mline);
			if (($IUSER{'community'} ne "") && ($CONFIG{'COMMUNITY_include_siteinfo'} eq "YES")) {
				&get_file_info($IUSER{'username'},$IUSER{'community'});
				&get_counter_info($IUSER{'username'},$IUSER{'community'});
			}

			$hfn = $GPath{'userdirs'} . "/" . $i . "/visit.log";
			if (-e "$hfn") {
   				open(HITS,"$hfn");
  				@tfile = <HITS>;
 	 			close(HITS);
				chomp $tfile[0];
				chomp $tfile[1];
				$IUSER{'num_visits'} = $tfile[0];
				$IUSER{'last_update'} = $tfile[1];
				$IUSER{'IPs'} = $tfile[2];
			}

			$data .= "$filenum&&$IUSER{'realname'}&&$IUSER{'username'}&&$IUSER{'email'}&&$IUSER{'password'}&&$IUSER{'url'}&&$IUSER{'urlname'}&&$IUSER{'handle'}&&$IUSER{'IPs'}&&$IUSER{'creation_date'}&&$IUSER{'last_update'}&&$IUSER{'num_visits'}&&$IUSER{'Age'}&&$IUSER{'Sex'}&&$IUSER{'user_level'}&&$IUSER{'favetypes'}&&$IUSER{'warnings'}&&$IUSER{'icon'}&&$IUSER{'description'}&&$IUSER{'send_update'}&&$IUSER{'community'}&&$IUSER{'Phonenumber'}&&$IUSER{'Faxnumber'}&&$IUSER{'Address'}&&$IUSER{'State'}&&$IUSER{'Country'}&&$IUSER{'ZipCode'}&&$IUSER{'City'}&&$IUSER{'status'}&&$IUSER{'expiry_date'}&&$IUSER{'monthly_fee'}&&$IUSER{'admin_notes'}&&$IUSER{'history'}&&$IUSER{'BirthDay'}&&$IUSER{'BirthMonth'}&&$IUSER{'BirthYear'}&&$IUSER{'Filler1'}&&$IUSER{'Filler2'}&&$IUSER{'Filler3'}&&$IUSER{'Filler4'}&&$IUSER{'Filler5'}&&$IUSER{'Filler6'}&&$IUSER{'Filler7'}&&$IUSER{'Filler8'}&&$IUSER{'Filler9'}&&$IUSER{'Filler10'}&&$IUSER{'FirstName'}&&$IUSER{'Initial'}&&$IUSER{'LastName'}&&$IUSER{'Referer'}" . "&&" . $totalbytes . "&&" . $number_of_files . "&&" . $Recent_visit . "&&" . $Hits_Total;
			print "<BR>$IUSER{'username'}\n";
			$actualusers++;
			$database .= $data . "\n";
		}
	}


	open(FILE, ">$databasefile") || &diehtml("I can't create that $databasefile\n");
	print FILE "$database\n";
	close(FILE);
	chmod(0666,$fn);
}




		




sub get_member_number {
	$numberfile = $GPath{'userpath'} . "/" . "num.txt";
   	open(NUMBER,"$numberfile") || &diehtml("can't open $numberfile");
   	$numofusers = <NUMBER>;
   	close(NUMBER);
}



sub diehtml {
	local ($Message) = $_[0];
   	print "Content-type: text/html\n\n";
	print "$Message\n\n";
	exit;
}


sub parse_date {
	local ($time) = $_[0];
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$year = $year + 1900;

	if ($sec < 10) {
		$sec = "0$sec";
	}
	if ($min < 10) {
		$min = "0$min";
	}
	if ($hour < 10) {
		$hour = "0$hour";
	}
	if ($mon < 10) {
		$mon = "0$mon";
	}
	if ($mday < 10) {
		$mday = "0$mday";
	}

	$month = ($mon + 1);

	@months = ("January","February","March","April","May","June","July","August","September","October","November","December");

	$date = "$hour\:$min\:$sec $month/$mday/$year";

	chop($date) if ($date =~ /\n$/);

	#$year = $year + 1900;
	$long_date = "$months[$mon] $mday, $year at $hour\:$min\:$sec";
}


sub mass_mail {
	if (-e "cmail_admin.cgi") {
	  	print "Content-type: text/html\n\n";
		print "<HTML>\n";
		print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
		print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
		print "<TR><TD><CENTER><H3>Send Mass-Mailing</H3></TD></TR>\n";
		print "<TR><TD>\n";
		print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cmail_admin.cgi'}\">\n";
		print "Compose the messages for your mailing list members below.\n";
		print "<P>You can automatically insert the following information:\n";
		print "<LI>[FIRSTNAME] - The member's first name (or whatever they entered into that field).\n";
		print "<LI>[LASTNAME] - The member's last name (or whatever they entered into that field).\n";
		print "<LI>[SCRIPT] - The address of the cmail.cgi script for subscribing and un-subscribing.\n";
		print "<LI>[EMAIL] - The recipient's email address.\n";
		print "<P>Subject:<BR>\n";
		print "<INPUT TYPE=TEXT NAME=\"subject\" SIZE=40>\n";
		print "<P>Body:</BR>\n";
		print "<TEXTAREA NAME=message COLS=80 ROWS=10>";
		print "</TEXTAREA>\n";
		print "<P>\n";
		print "<INPUT TYPE=hidden NAME=\"list\" VALUE=\"WeaverMembers\">\n";
		print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Preview Message\">\n";
		print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Preview Message!\"></CENTER>\n";
		print "</TD></TR></TABLE>\n";
		print "</HTML>\n";
		exit;
	}
	else {
	  	print "Content-type: text/html\n\n";
		print "<HTML>\n";
		print "<BODY BGCOLOR=#cccc99>\n";
		print "<TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7>\n";
		print "<TR><TD><CENTER><H3>Send A Mass Mailing</H3></TD></TR>\n";
		print "<TR><TD>\n";
		print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'community_admin.cgi'}\">\n";
		print "Just fill in the subject and the message and you'll be ready to go.\n";
		print "<P>Subject: <INPUT TYPE=TEXT NAME=\"subject\" LENGTH=60>\n";

		print "<H3>Text:</H3>\n";
		print "<TEXTAREA NAME=message COLS=60 ROWS=10>";
		print "</TEXTAREA>\n";
		print "<P>\n";
		print "</CENTER><INPUT TYPE=SUBMIT NAME=action VALUE=\"Send This Mail\">\n";
		print "</TD></TR></TABLE>\n";
		print "</HTML>\n";
		exit;
	}
}

sub send_mail {
	$| = 1;
	print "Content-type: text/html\n\n"; 
	print "<HTML>\n";
	print "<HEAD><TITLE>Email Sent</TITLE></HEAD>\n";
	print "<BODY BGCOLOR=#FFFFFF>\n";
	$temp=0;

    	opendir(FILES, "$GPath{'userpath'}/") || die ERROR("Can't open directory");
    	while($file = readdir(FILES)) {
        	if($file =~ /.*\.usrdat/) {
			$sentcount++;
			$data = "";
			$fn = $GPath{'userpath'} . "/" . $file;
			if(-e "$fn") {
				open(FILE, "$fn") || &diehtml("I can't open $fn\n");
				while(<FILE>) {
					chomp;
					@datafile = split(/\n/);
					foreach $line (@datafile) {
						($IUSER{'realname'}, $IUSER{'username'}, $IUSER{'email'}, $IUSER{'password'}, $IUSER{'url'}, $IUSER{'urlname'}, $IUSER{'handle'}, $USER_mailings, $IUSER{'creation_date'}, $IUSER{'last_update'}, $IUSER{'num_visits'}, $IUSER{'Age'}, $IUSER{'Sex'}, $IUSER{'user_level'}, $IUSER{'favetypes'}, $IUSER{'warnings'}, $IUSER{'icon'}, $IUSER{'description'}, $IUSER{'send_update'}, $IUSER{'community'}, $IUSER{'Phonenumber'}, $IUSER{'Faxnumber'}, $IUSER{'Address'}, $IUSER{'State'}, $IUSER{'Country'}, $IUSER{'ZipCode'}, $IUSER{'City'}) = split(/&&/, $line);
		            	}
      			}
				&send_email;
			}
			else {
				print "Member $count Deleted<BR>\n";
			}
		}
	}
	print "<TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Mail Sent</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=\"#ffffcc\">\n";
	print "Email sent to $sentcount members.\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"self.close();\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "<P>\n";
	print "</BODY>\n";
	print "</HTML>\n";
	exit;
}

sub send_email {
     	if ($IUSER{'email'} !~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $IUSER{'email'} =~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
		open (MAIL, "| $CONFIG{'mail_cmd'} -t") || die "I can't open $CONFIG{'mail_cmd'}\n";
		  print MAIL "To: $IUSER{'email'}\n";
		  print MAIL "From: $CONFIG{'email'}\n";
		  print MAIL "Subject: $FORM{'subject'}\n\n";
		  print MAIL "$FORM{'message'}\n\n";
		  print MAIL "\n--------------------------------------------\n";
		  print MAIL "Your Username: $IUSER{'username'}\n";
		  print MAIL "\n\n\n";
		close(MAIL);

		print "$sentcount) email sent to $IUSER{'username'} at $IUSER{'email'}<BR>\n";
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