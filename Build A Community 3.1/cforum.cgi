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
require "$GPath{'imagesize.pm'}";
require "$GPath{'cf.pm'}";



&parse_FORM;

if ((-e "clubs.cgi") && ($FORM{'forum'} eq "") && ($FORM{'action'} eq "")) {  # Are clubs running, send this person there!
	print "Location: $GUrl{'clubs.cgi'}\n\n";
}

($VALIDUSER, %IUSER) = &validate_session_no_error;  # Let's if this user is valid

if ($VALIDUSER eq "T") {
	&get_personal_settings;
}

if ($daystoshow eq "") { $daystoshow = $CONFIG{'daystoshow'};}
if ($threadstoshow eq "") { $threadstoshow = $CONFIG{'threadstoshow'};}


#  Let's set some run time variables...

 	$WIDTH = "100%";
	$forum_email = $CONFIG{'email'};
	$CONFIG{'bbs_table1'} =~ s/ +.*//g;
	$CONFIG{'bbs_table2'} =~ s/ +.*//g;
    	$Ignore .= " what how which when where do you find get and ";
    	$Ignore .= " or if not a the for an it of from by the to he ";
    	$Ignore .= " most all about i me is are be been with why could would ";
    	$Ignore .= " other like was has who as really im will its my on know ";
    	$Ignore .= " so we should up web net link";

	$rn = time;
	$extra_new = $CONFIG{'extra_new_minutes'} * 60;
	$extra_new = $rn - $extra_new;
	$CONFIG{'new_minutes'} = $CONFIG{'new_minutes'} * 60;
	$CONFIG{'new_minutes'} = $rn - $CONFIG{'new_minutes'};

	$forumdb = "$GPath{'cforums_data'}/$FORM{'forum'}.db";
	$threadsdb = "$GPath{'cforums_data'}/$FORM{'forum'}_threads.db";
	$thread_status = "$GPath{'cforums_data'}/thread_status.db";
	$authorsdb = "$GPath{'cforums_data'}/authors.db";
	$keywordsdb = "$GPath{'cforums_data'}/keywords.db";
	$postactivitydb = "$GPath{'cforums_data'}/postactivity.db";
	$activitydb = "$GPath{'cforums_data'}/activity.db";
	$TURL = &urlencode("$CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?action=$FORM{'action'}&forum=$FORM{'forum'}&thread=$FORM{'thread'}");
	$subject = $FORM{'subject'};
	$forum = $FORM{'forum'};

# Enough of that, let's log this access...

	if ($FORM{'forum'}) {
		&lock("activity");
		tie my %xdata, "DB_File", $activitydb;
		$xdata{$IUSER{'username'}} = "$rn\|$FORM{'forum'}";
		untie %xdata; 
		&unlock("activity");
	}

# Let's clean up a little

	unlink "$GPath{'cforums_data'}/.cfg";
	unlink "$GPath{'cforums_data'}/.db";
	unlink "$GPath{'cforums_data'}/_threads.db";

# Are post categories is use?

	open (POSTICONS, "$GPath{'cforums_data'}/post.categories");
	@PCATS = <POSTICONS>;
	close (POSTICONS);

	foreach $i (@PCATS) {
		$i =~ s/(\cM|\n)//g;
		@t = split(/\|\|/, $i);
		$picons{$t[0]} = $t[1];
	}
	undef ($i, @t, @PCATS);

# Who's God around here?

	open (FILE, "$GPath{'cforums_data'}/god.dat");
	@god = <FILE>;
	close(FILE);
	$admin_num = $god[0];

# Let's get started

	$forum=$FORM{'forum'} if (! $forum);
	$GRP = $FORM{'forum'};

	if ( !($GRP) ) {
		$GRP = "bbs";
	}
	if ($FORM{'clubs'} eq "T") {
		$PROGRAM_NAME = "clubs.cgi";
		if ( !( -e "$GPath{'template_data'}/$GRP.txt" ) ) {
			$GRP = "club";
		}
	}
	else {
		$PROGRAM_NAME = "cforum.cgi";
		if ( !( -e "$GPath{'template_data'}/$GRP.txt" ) ) {
			$GRP = "bbs";
		}
	}
	if ($FORM{'action'} eq "set_options") {
		&set_options;
	}
	elsif ($FORM{'action'} eq "help") {
		require $GPath{'cf_windows.pm'};
		&HelpWindow;
	}
	elsif ($FORM{'action'} eq "searchoptions") {
		require $GPath{'cf_search.pm'};
		&searchoptions;
	}
	elsif ($FORM{'action'} eq "") {
		&Page_Header($GRP); 
	}
	else {  
		$Version = "List";
		&Initialize_BBS; 
	}
	exit 0;



sub BBS_Menu {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/frontpage.tmplt");
	$OUT .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/frontpage.tmplt";
}


sub Initialize_BBS {
	%IFORUM = &readbbs("$GPath{'cforums_data'}/$FORM{'forum'}.cfg", 1);
	if ($FORM{'forum'} ne "") {
		%MOD = &get_moderator($IFORUM{'bbs_admin'});
	}

	$PRIVILEDGED = undef;

	if ($FORM{'action'} eq "login_password") {
		if ($FORM{'PassWord'} eq $IFORUM{'bbs_private_pw'}) {
			&set_password("password");
		}
		else {
			$BODY .= "<B>Invalid password</B>, the password that you entered is incorrect<P>\n";
		}
	}

	if ($FORM{'action'} eq "login_user") {
		&get_user($FORM{'UserName'},$FORM{'PassWord'});
		if ($IUSER{'user_level'} eq $group) {
			&set_password("username");
		}
		else {
			$BODY .= "<B>Access Denied</B>, your membership has not been set to grant you access to the forum.<P>\n";
		}
	}
	if ($FORM{'action'} eq "forumlogin") {
		require $GPath{'cf_windows.pm'};
		&forum_login($IFORUM{'restrictedto'});
	}

	if (($IFORUM{'access'} eq "Read-Only For Non-Privileged") || ($IFORUM{'access'} eq "Private")) {
		$PRIVILEDGED = "F";
		if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
			$PRIVILEDGED = "T";
		}
		elsif ($IFORUM{'restrictedto'} eq "User Group") {
			if ($IUSER{'user_level'} eq $IFORUM{'group'}) {
				$PRIVILEDGED = "T";
			}
		}
		elsif ($IFORUM{'restrictedto'} eq "Club Members Only") {
			open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'forum'}\.members");
			my @fm = <MEMBERS>;
			close (MEMBERS);

			foreach my $l (@fm) {
				$l =~ s/(\cM|\n| )//g;
				if ($IUSER{'username'} eq $l) {
					$PRIVILEDGED = "T";
					last;
				}
			}
		}
		elsif ($IFORUM{'restrictedto'} eq "PassWord") {
			%Cookies = &GetCompressedCookies("$forum",'PR_PassWord');
			if ($Cookies{'PR_PassWord'} eq $IFORUM{'bbs_private_pw'}) {
				$PRIVILEDGED = "T";
			}
		}

		if (($IFORUM{'access'} eq "Private") && ($PRIVILEDGED ne "T")) {
			require $GPath{'cf_windows.pm'};
			&forum_login($IFORUM{'restrictedto'});
		}
		elsif (($IFORUM{'access'} eq "Read-Only For Non-Privileged") && ($PRIVILEDGED ne "T")) {
			$RESTRICTIONS = "You are logged in as a guest, if you are supposed to have full access, click <A HREF=\"$GUrl{'cforum.cgi'}?action=forumlogin&clubs=$FORM{'clubs'}&forum=$forum\">here to login</A>";
		}			
	}

	if ($IFORUM{'access'} eq "Closed") {
		if (($IUSER{'filenum'} ne $IFORUM{'bbs_admin'}) && ($IUSER{'filenum'} ne $admin_num)) {
			require $GPath{'cf_errors.pm'};
			&forum_closed;
		}
	}

   

	elsif ($FORM{'action'} eq "delete_msg") {
		require $GPath{'cf_modify.pm'};
		&delete_i_post;
	} 
	elsif ($FORM{'action'} eq "delete_thread") {
		require $GPath{'cf_modify.pm'};
		&confirm_delete;
	} 
	elsif ($FORM{'action'} eq "hide") {
		require $GPath{'cf_modify.pm'};
		&hidethisthread;
	} 
	elsif ($FORM{'action'} eq "unhide") {
		require $GPath{'cf_modify.pm'};
		&unhidethisthread;
	} 
	elsif ($FORM{'action'} eq "close_thread") {
		require $GPath{'cf_modify.pm'};
		&closethisthread;
	} 
	elsif ($FORM{'action'} eq "save_subject") {
		require $GPath{'cf_modify.pm'};
		&save_subject;
	} 
	elsif ($FORM{'action'} eq "confirm_delete_thread") {
		require $GPath{'cf_modify.pm'};
		&godelete_i_thread($FORM{'thread'});
	} 
	elsif ($FORM{'action'} eq "open_thread") {
		require $GPath{'cf_modify.pm'};
		&openthisthread;
	} 

	elsif (($FORM{'action'} eq "post_reply") || ($FORM{'action'} eq "post_new")) { 
		require $GPath{'cf_modify.pm'};
		%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
		&PostMessage; 
	}

	elsif ($FORM{'action'} eq "publish_msg") { 
		require $GPath{'cf_modify.pm'};
#		&get_user($FORM{'UserName'},$FORM{'PassWord'});
		&publish_message; 
	}
	elsif ($FORM{'action'} eq "suspend_msg") { 
		require $GPath{'cf_modify.pm'};
#		&get_user($FORM{'UserName'},$FORM{'PassWord'});
		&suspend_message("T"); 
	}
	elsif ($FORM{'action'} eq "unsuspend_msg") { 
		require $GPath{'cf_modify.pm'};
#		&get_user($FORM{'UserName'},$FORM{'PassWord'});
		&suspend_message("F"); 
	}
	elsif ($FORM{'action'} eq "save_edit") { 
		require $GPath{'cf_modify.pm'};
		&get_user($FORM{'UserName'},$FORM{'PassWord'});
		&save_edited_message; 
	}
	else { 
		&Page_Header($GRP); 
	}
	exit 0;
}



sub Body {
	if ($FORM{'action'} eq "search") {
		require $GPath{'cf_search.pm'};
		&go_search;
	}
	elsif ($FORM{'action'} eq "usersearch") {
		require $GPath{'cf_search.pm'};
		&usersearch;
	}

	elsif (! ($forum) ) { &BBS_Menu; }

	else {
		if ($FORM{'action'} eq "reply") {
			&reply_form;
		}
     		if ($FORM{'action'} eq "i_post") {
			&Forum_ShowText;
		} 
		if ($FORM{'action'} eq "new") {
			&new_form;
		}
		if ($FORM{'action'} eq "edit_post") {
			require $GPath{'cf_modify.pm'};
			&edit_post;
		}
		if ($FORM{'action'} eq "edit_subject") {
			require $GPath{'cf_modify.pm'};
			&edit_subject;
		}
		if ($FORM{'action'} eq "message") {
			&Forum_ShowText;
		}
		elsif ((($FORM{'action'} eq "getall") || ($FORM{'action'} eq "Open Forum")) && ($FORM{'forum'} ne "")) {
			&Forum_Headers;
		}
	}
}


sub Forum_ShowText {
	if ($FORM{'clubs'} eq "T") {
		require $GPath{'cf_logs.pm'};
		&log_visit($FORM{'forum'});

		open (MEMBERS, "$GPath{'cforums_data'}/$forum.members.tmp");
		@mpending = <MEMBERS>;
		close (MEMBERS);
		$mp = $#mpending + 1;
	}

  	tie my %threads, "DB_File", $threadsdb;
	tie my %posts, "DB_File", $forumdb;

	$LAST_VISIT = $LAST_VISIT - 1800;

	open (REPLACEMENTS, "$GPath{'cforums_data'}/replacements.dat");
	@REPLACEMENTS = <REPLACEMENTS>;
	close (REPLACEMENTS);

	tie my %thrstatdb, "DB_File", $thread_status;
	if ($thrstatdb{$thread} eq "CLOSED") {
		$thread_closed = "T";
		$OPENTEXT = "(Closed / Read-Only)";
	}

	if (($FORM{'clubs'} eq "T") && ($VALIDUSER eq "T") && (-e "$GPath{'cforums_data'}/$forum.members.tmp") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		if ($#mpending ne undef) {$MPENDING = "There are $mp application(s) waiting for you <A HREF=\"$GUrl{'clubs.cgi'}?action=review&clubs=$FORM{'clubs'}&forum=$forum\">to review</A>.";}
		$CM = "<A HREF=\"$GUrl{'clubs.cgi'}?action=cancel&clubs=$FORM{'clubs'}&forum=$forum\">Cancel Memberships</A>";
	}

	if ($FORM{'action'} ne "i_post") {
		$current_thread = $FORM{'thread'};
		(@postslist) = split(/\|/,$threads{$current_thread});
		%tpost = &readpost($posts{$postslist[0]});
	}
	else {
		@postslist = ($FORM{'message_id'});
		%tpost = &readpost($posts{$postslist[0]});
	}

	$thissubject = $subject;
	$nextaction = &urlencode("action=message&clubs=$FORM{'clubs'}&forum=$FORM{'forum'}&thread=$tpost{'this_thread'}");

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/textheader.tmplt");
	$OUT .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/textheader.tmplt";

	$color_num = 1;
	$post_num = 1;

	@myhighlight = split(/!+/, $highlightedposts);

	if ($CONFIG{'reverseposts'} eq "YES") {
		@postslist = reverse @postslist;
	}

	foreach my $upost (@postslist) {
		%ipost = readpost($posts{$upost});
		if ($ipost{'pdate'} !~ /\w/) {next;}
		if ((($daystoshow * 86400) < ($rn - $ipost{'pdate'})) && ($FORM{'showall'} ne "T")) {$notshown++;next;}

		$thisurl = &urlencode("$CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?action=message&clubs=$FORM{'clubs'}&forum=$forum&thread=$ipost{'thisthread'}&highlight=$ipost{'message_id'}");

		$myicon = "";
		$imagename = "";
		if (($ipost{'icon'} ne "") && ($forum ne "")) {
			if ($ipost{'icon'} =~ /\D/) {
				if (-e "$CONFIG{'ICON_upload_path'}/thumbs/$ipost{'icon'}") {
					$imagename = "$ipost{'icon'}";
				}
				else {
					@ti = split(/\./, $ipost{'icon'});
					if ($ti[1] =~ /\.jpg/i) {
						if (-e "$CONFIG{'ICON_upload_path'}/thumbs/$ti[0].gif") {
							$imagename = "$ti[0].gif";
						}
						else {
							$imagename = "NONE";
						}
					}
					if ($ti[1] =~ /\.gif/i) {
						if (-e "$CONFIG{'ICON_upload_path'}/thumbs/$ti[0].jpg") {
							$imagename = "$ti[0].jpg";
						}
						else {
							$imagename = "NONE";
						}
					}
				}
				if ((-e "$CONFIG{'ICON_upload_path'}/thumbs/$imagename") && ($imagename ne "")) {
					($iwidth, $iheight) = &imgsize("$CONFIG{'ICON_upload_path'}/thumbs/$imagename");
					$myicon .= "<A HREF=\"$GUrl{'moreinfo.cgi'}?UserName=$IUSER{'username'}\"><IMG SRC=\"$CONFIG{'ICON_upload_url'}/thumbs/$imagename\" WIDTH=$iwidth HEIGHT=$iheight BORDER=0 ALIGN=LEFT></A>";
				}
			}
			else {
				$myicon .= "<IMG SRC=\"$GUrl{'icon_images'}/$ipost{'icon'}.gif\" WIDTH=32 HEIGHT=32 ALIGN=LEFT>";
			}
		}

		if ($filteron eq "ON") {
			$uFOUND = "F";
			$wFOUND = "F";
			@busers = split(/!+/, $filteredusers);
			foreach $bu (@busers) {
				if ($bu eq $ipost{'username'}) {
					$uFOUND = "T";
					last;
				}
			}
			@bwords = split(/!+/, $filteredwords);
			foreach $bu (@bwords) {
				if ($bu ne "") {
					if ($bu eq $ipost{'username'}) {
						$wFOUND = "T";
						last;
					}
				}
			}
			if ((($uFOUND eq "T") || ($wFOUND eq "T")) && ($FORM{'action'} ne "i_post")) {
				if ($filterhow eq "HIDE") {
					$ipost{'message'} = "This message is hidden according to your <A HREF=\"$GUrl{'myforum.cgi'}?returnto=$TURL\">personal preferences</A>, you can read the message by <A HREF=\"$GUrl{'cforum.cgi'}?action=i_post&clubs=$FORM{'clubs'}&forum=$forum&message_id=$ipost{'message_id'}\">clicking here</A>.";
					$myicon = undef;
				}
				elsif ($filterhow eq "SKIP") {
					next;
				}
			}
		}

		if (($ipost{'hidden'} eq "T") && ($FORM{'action'} ne "i_post")) {
			$ipost{'message'} = "This message was hidden by either the moderator or the author of the message, <A HREF=\"$GUrl{'cforum.cgi'}?action=i_post&clubs=$FORM{'clubs'}&forum=$forum&message_id=$ipost{'message_id'}\">click here to read it</A>.";
			$myicon = undef;
			$hide_code = "<A HREF=\"$GUrl{'cforum.cgi'}?action=unhide&clubs=$FORM{'clubs'}&forum=$forum&message=$ipost{'message_id'}&thread=$FORM{'thread'}\">$CONFIG{'unhide_message'}</A>";
		}
		else {
			$hide_code = "<A HREF=\"$GUrl{'cforum.cgi'}?action=hide&clubs=$FORM{'clubs'}&forum=$forum&message=$ipost{'message_id'}&thread=$FORM{'thread'}\">$CONFIG{'hide_message'}</A>";
		}

		$PENDING = undef;
		if (($moderated eq "Yes") && ($ipost{'approved'} eq "F")) {
			if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
				$PENDING = "<A HREF=\"$GUrl{'cforum.cgi'}?action=publish_msg&thread=$FORM{'thread'}&message_id=$ipost{'message_id'}&clubs=$FORM{'clubs'}&forum=$forum\">$CONFIG{'addsubmission'}</A><BR>";
			}
			else {
				next;
			}
		}

		if ($ipost{'suspended'} eq "T") {
			if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
				$SUSPEND = "<A HREF=\"$GUrl{'cforum.cgi'}?action=unsuspend_msg&thread=$FORM{'thread'}&message_id=$ipost{'message_id'}&clubs=$FORM{'clubs'}&forum=$forum\">$CONFIG{'unsuspendmessage'}</A><BR>";
			}
			else {
				next;
			}
		}
		else {
			if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
				$SUSPEND = "<A HREF=\"$GUrl{'cforum.cgi'}?action=suspend_msg&thread=$FORM{'thread'}&message_id=$ipost{'message_id'}&clubs=$FORM{'clubs'}&forum=$forum\">$CONFIG{'suspendmessage'}</A><BR>";
			}
		}

		$num_shown++;
        	$NEW = undef;

		if ($ipost{'pdate'} >= $extra_new) {
			$NEW = "$CONFIG{'extra_new_message'}";
		}
		elsif (($ipost{'pdate'} >= $LAST_VISIT) && ($CONFIG{'new_minutes'} < $ipost{'pdate'})) {
			$NEW = "$CONFIG{'new_message'}";
		}

        	$ipost{'message'} =~ s/\n/<BR>/g;
		
		if ($color_num == 1) {
			$COLOR = "$CONFIG{'bbs_table1'}";
			$FONTCOLOR = "$CONFIG{'text_color'}";
			$TABLECOLOR = "$CONFIG{'bbs_table1'}";
			$color_num = 0;
		}
		else {
			$COLOR = "$CONFIG{'bbs_table2'}";
			$FONTCOLOR = "$CONFIG{'text_color'}";
			$TABLECOLOR = "$CONFIG{'bbs_table2'}";
			$color_num = 1;
		}

		if ($num_shown == 1) {
			$COLOR = "$CONFIG{'topic_color'}";
			$FONTCOLOR = "$CONFIG{'text_color'}";
			$TABLECOLOR = "$CONFIG{'topic_color'}";
		}
 		if ($ipost{'message_id'} eq $FORM{'highlight'}) {
			$TABLECOLOR = "$CONFIG{'highlightcolor'}";
		}

		foreach my $th (@myhighlight) {
			@thishighlight = split(/%%/, $th);
			if (($thishighlight[1] eq $ipost{'message_id'}) || ($ipost{'message_id'} eq $FORM{'highlight'})) {
				$TABLECOLOR = "$CONFIG{'highlightcolor'}";
				last;
			}
		}

		$thismessage = &do_parses($ipost{'message'});

		if (($thread_closed ne "T") && ($Post_In_Forums ne "NO")) {
			$reply = "<A HREF=\"$GUrl{'cforum.cgi'}?action=reply&thread=$FORM{'thread'}&message_id=$ipost{'message_id'}&clubs=$FORM{'clubs'}&forum=$forum\">$CONFIG{'reply_message'}</A> &nbsp; &nbsp; <A HREF=\"$GUrl{'cforum.cgi'}?action=edit_post&clubs=$FORM{'clubs'}&forum=$forum&message=$ipost{'message_id'}\">$CONFIG{'edit_message'}</A> &nbsp; ";
		}
		else {
			$reply = undef;
		}

		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/post.tmplt");
		$OUT .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/post.tmplt";

		if ($post_num > 4) {
			$OUT .= "</TABLE><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=$WIDTH><TR><TD BGCOLOR=\"$CONFIG{'win_color'}\">";
			$post_num = 1;
			$openclose++;
		}
		else {
			$post_num++;
		}
   	}
	$OUT .= "</table>\n";
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/textfooter.tmplt");
	$OUT .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/textfooter.tmplt";
}



sub Forum_Headers {
	if ($FORM{'clubs'} eq "T") {
		require $GPath{'cf_logs.pm'};
		&log_visit($FORM{'forum'});

		open (MEMBERS, "$GPath{'cforums_data'}/$forum.members.tmp");
		my @mpending = <MEMBERS>;
		close (MEMBERS);
		$mp = $#mpending + 1;
	}

  	tie my %threads, "DB_File", $threadsdb;
	tie my %posts, "DB_File", $forumdb;

	$LAST_VISIT = $LAST_VISIT - 1800;
	$level = 1;

	tie my %thrstatdb, "DB_File", $thread_status;

	if (($VALIDUSER eq "T") && ($FORM{'clubs'} eq "T") && (-e "$GPath{'cforums_data'}/$forum.members.tmp") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		if ($#mpending ne undef) {$MPENDING = "There are $mp application(s) waiting for you <A HREF=\"$GUrl{'clubs.cgi'}?action=review&clubs=$FORM{'clubs'}&forum=$forum\">to review</A>.";}
		$CM = "<A HREF=\"$GUrl{'clubs.cgi'}?action=cancel&clubs=$FORM{'clubs'}&forum=$forum\">Cancel Memberships</A>";
	}

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/threadlistheader.tmplt");
	$OUT .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/threadlistheader.tmplt";

	my $threadcount = undef;
	foreach $thread(reverse sort keys %threads) {            #foreach thread...
		($hotcount, $num_posts, $HOT, $NEW, $ADMIN_CODE, $SUSPEND, $PENDING) = (0, 0, undef, undef, undef, undef, undef);

		(@threadposts) = split(/\|/, $threads{$thread});   #get a list of posts in each thread
		%ft = &readpost($posts{$threadposts[0]});		   #get the contents of thread 1 (the first)
		if ($ft{'subject'} !~ /\w/) {  # If this post has been corrupted somehow - I would LOVE to know why posts sometimes lose their subjects but until I know...
			%ft = &readpost($posts{$threadposts[1]});		   #get the contents of thread 2 (the second)
			if ($ft{'subject'} !~ /\w/) {  # If this post has also been corrupted somehow
				$ft{'subject'} = "<I>missing</I>";
			}
		}
		if ($ft{'suspended'} eq "T") {
			if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
				$SUSPEND = "<BR>The first post of this message has been suspended making the thread invisible";
			}
			else {
				next;
			}
		}

		if (($IFORUM{'moderated'} eq "Yes") && ($ft{'approved'} eq "F")) {
			if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
				$PENDING = "Contains post(s) pending approval.<BR>";
			}
			else {
				next;
			}
		}

		my %ltp = &readpost($posts{$threadposts[$#threadposts]});		   #get the contents of the last post in the thread
		$ldate = $ltp{'date'};
		if (($daystoshow * 86400) < ($rn - $ltp{'pdate'})) {next;}
		$threadsshown++;
		if (($threadsshown > $threadstoshow) && (! $FORM{'viewall'})){
			last;
		}
		if ($IFORUM{'moderated'} eq "Yes") {
			$num_posts = $#threadposts + 1;
		}
		foreach $postnthread (@threadposts) {
			my %t = &readpost($posts{$postnthread});
			if ($t{'approved'} eq "F") {
				if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
					$PENDING = "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Contains post(s) pending approval.<BR>";
				}
			}
			else {
				(@info) = split(/,/, $postnthread);
				if ($info[0] > ($rn-86400)) {
					$hotcount++;
				}
				$num_posts++;
			}
		}

		if ($hotcount > $CONFIG{'hot_topic'}) {
			$HOT = "$CONFIG{'hot_topic_message'}";
			$HOT_on = "T";
		}

		if ($ltp{'pdate'} >= $extra_new) {
			$NEW = "$CONFIG{'extra_new_message'}";
		}
		elsif (($ltp{'pdate'} >= $LAST_VISIT) && ($CONFIG{'new_minutes'} < $ltp{'pdate'})) {
			$NEW = "$CONFIG{'new_message'}";
		}
#		$NEW .= "(($lpt{'pdate'} >= $LAST_VISIT) && ($CONFIG{'new_minutes'} < $lpt{'pdate'})) === $posts{$threadposts[$#threadposts]});";
		if ($level eq "1") { 
			$color = "$CONFIG{'bbs_table1'}"; 
			$level = "2";
		}
		else { 
			$color = "$CONFIG{'bbs_table2'}"; 
			$level = "1";
		}
            if ($thrstatdb{$thread} eq "CLOSED") {
			$folder_image = "$CONFIG{'closed_folder_message'}";
			$closed++;
		}
		else {
			$folder_image = "$CONFIG{'open_folder_message'}";
		}
		if ($suspended eq "T") {
			$folder_image = "$CONFIG{'closed_folder_message'}";
		}
		if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
			$ADMIN_CODE = "<TD bgcolor=\"$color\" COLSPAN=1><font color=\"$FONTCOLOR\" FACE=\"$CONFIG{'font_face'}\" SIZE=\"1\">$PENDING<A HREF=\"$GUrl{'cforum.cgi'}?action=delete_thread&thread=$ft{thisthread}&clubs=$FORM{'clubs'}&forum=$forum\">$CONFIG{'deletethread'}</A><BR>\n";
			$ADMIN_CODE .= "<A HREF=\"$GUrl{'cforum.cgi'}?action=edit_subject&thread=$ft{thisthread}&clubs=$FORM{'clubs'}&forum=$forum\">Edit Subject</A>\n";
			$ADMIN_CODE .= "$SUSPEND</TD>\n";
		}

		$teaser = substr(&Remove_ALL_Tags($ft{'message'}),0,50); 

		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/threadlisting.tmplt");
		$OUT .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/threadlisting.tmplt";
	}
	$OUT .= "</td></tr></table></td></tr></table>\n";


	if (($threadsshown > $threadstoshow) && (! $FORM{'viewall'})) {
		$OUT .= "<CENTER><FONT SIZE=2><B>$threadstoshow threads shown, <A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$FORM{'forum'}&viewall=T\">View All Recent Threads</A></B></FONT><BR>\n";
	}
	if ($HOT_on eq "T") {
		$OUT .= "<FONT SIZE=1>$CONFIG{'hot_topic_message'} = more than $CONFIG{'hot_topic'} posts in the last 24 hours.</FONT>\n";
	}
	if ($closed > 0) {
		$OUT .= "<BR><FONT SIZE=1>$CONFIG{'open_folder_message'} = open threads &nbsp; &nbsp; $CONFIG{'closed_folder_message'} = closed threads </FONT>\n";
	}
	if (($newthreads eq "Moderator/Admin Only") || ($Post_In_Forums eq "NO")) {
		if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
			&new_form;
		}
	}
	else {
		&new_form;
	}
	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		if ($FORM{'clubs'} ne "T") {
			if (($moderator_edit eq "Yes") || ($moderator_edit eq "Settings Not Appearance")) {
				$OUT .= " &nbsp; <A HREF=\"$GUrl{'cf_moderators.cgi'}?clubs=$FORM{'clubs'}&forum=$forum\">Edit Forum Settings</A>";
			}
		}
	}
	$OUT .= <<LIST1;
		<SCRIPT LANGUAGE="javascript">
		function ShowHelp(c_what) {
		  var Location = "$GUrl{'cforum.cgi'}?action=help&file=" + c_what;
		  link=open(Location,"CCSLink","toolbar=no,scrollbars=yes,directories=no,menubar=no,resizable=yes,width=420,height=410");
		}

		function OpenWin(Loc) {
		  link=open(Loc,"CCSLink","toolbar=no,scrollbars=yes,directories=no,menubar=no,resizable=yes,width=420,height=410");
		}

		function OpenForum(v_forum) {
		  document.forum_select.forum.value = v_forum;
		  document.forum_select.submit();  
		}
		</SCRIPT>
LIST1
}


sub Remove_ALL_Tags {
   local($string_to_modify) = @_[0];
   
   $string_to_modify =~ s/\[[^\]]+\]//ig;
   $string_to_modify = &Remove_HTML_Tags($string_to_modify);
   return($string_to_modify);
}





sub set_password {
	local($type) = $_[0];
	
	if ($type eq "password") {
		&SetCookiePath('/');
		print "Content-type: text/html\n"; 
		&SetCompressedCookies("$forum",'PR_PassWord',$FORM{'PassWord'});
		print "\n";
	}
	if ($type eq "username") {
		&SetCookiePath('/');
		&SetCookieExpDate('Wed, 31-Dec-2029 00:00:00 GMT');
		print "Content-type: text/html\n"; 
		&SetCompressedCookies('user','UserName',$FORM{'UserName'},'PassWord',$FORM{'PassWord'},'Icon',$IUSER{'icon'},'Id',$IUSER{'filenum'});
		print "\n";
	}

	print "<HEAD>\n";
	print "<META HTTP-EQUIV=\"Refresh\" CONTENT= \"0; URL=$GUrl{'cforum.cgi'}?action=getall&clubs=$FORM{'clubs'}&forum=$forum\">\n";
	print "</HEAD>\n";
	exit;
}

