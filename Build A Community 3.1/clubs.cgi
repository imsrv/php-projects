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
use CGI::Carp qw(fatalsToBrowser); 

use DB_File;

$userpm = "T";
require "./common.pm";
require "$GPath{'imagesize.pm'}";
require "$GPath{'cf.pm'}";
$PROGRAM_NAME = "clubs.cgi";

#print "Content-type: text/html\n\n";

	&parse_FORM;

	$FORM{'category'} =~ s/\|$//;

	($VALIDUSER, %IUSER) = &validate_session_no_error;

	if ($VALIDUSER eq "T") {
		&get_personal_settings;
	}

#  Let's set some run time variables...

	$max_groups = 10;
	$rn = time;
	$statuses{'official'} = 4;
	$statuses{'recommended'} = 3;
	$statuses{'approved'} = 2;
	$statuses{'unreviewed'} = 1;
	$forum_email = $CONFIG{'email'};
	$CONFIG{'bbs_table1'} =~ s/ +.*//g;
	$CONFIG{'bbs_table2'} =~ s/ +.*//g;
	$forumdb = "$GPath{'cforums_data'}/$FORM{'forum'}.db";
	$threadsdb = "$GPath{'cforums_data'}/$FORM{'forum'}_threads.db";
	$thread_status = "$GPath{'cforums_data'}/thread_status.db";
	$authorsdb = "$GPath{'cforums_data'}/authors.db";
	$keywordsdb = "$GPath{'cforums_data'}/keywords.db";

# Let's clean up a little

	unlink "$GPath{'cforums_data'}/.cfg";
	unlink "$GPath{'cforums_data'}/.db";
	unlink "$GPath{'cforums_data'}/_threads.db";

# Who's God around here?

	open (FILE, "$GPath{'cforums_data'}/god.dat");
	@god = <FILE>;
	close(FILE);
	$admin_num = $god[0];


# Let's get started

	$start_message = $FORM{'last_message'};

	if ($start_message < $num_msgs || $start_message eq "") {
    		$start_message = 0;
	}

	$action = $FORM{'action'};
	$forum=$FORM{'forum'} if (! $forum);


	$GRP = $FORM{'club'};
	if ( !($GRP) ) {
		if ($FORM{'category'}) {
			$GRP = "$FORM{'category'}";
		}
		else {
			$GRP = "index";
		}
	}
	if ( !( -e "$GPath{'template_data'}/$GRP.txt" ) ) { $GRP = "club"; }

	if (($FORM{'action'} eq "Edit Settings") || ($FORM{'action'} eq "create")) {
		&forum_form;
		&print_output('club_mod');
		exit;
	}
	if ($FORM{'action'} eq "Save My Club!") {
		&save_forum;
		&print_output('club_mod');
		exit;
	}

	if (($FORM{'club'} eq "") && ($FORM{'forum'} eq "")) {
		&Page_Header($GRP);
		exit;
	}

	if ($FORM{'action'} eq "open") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);

		if (($IUSER{'username'} ne "") && ($VALIDUSER)) {
			open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'club'}\.members");
			@fm = <MEMBERS>;
			close (MEMBERS);

			foreach $l (@fm) {
				$l =~ s/(\cM|\n| )//g;
				if ($IUSER{'username'} eq $l) {
					$PRIVILEDGED = "T";
					last;
				}
			}
		}
		if ($PRIVILEDGED ne "T") {
			require $GPath{'cf_windows.pm'};
			&forum_login("Club Members Only");
			&print_output('clubs');
		}
		&buildframe;
		exit;
	}
	elsif ($FORM{'action'} eq "clubtitle") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&clubtitle;
		exit;
	}
	elsif ($FORM{'action'} eq "clubmenu") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&clubmenu;
		exit;
	}
	elsif ($FORM{'action'} eq "intro") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&intro_page;
		&print_output('clubs');
		exit;
	}
	elsif ($FORM{'action'} eq "process applications") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&process_members;
		print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?forum=$FORM{'forum'}&action=getall\n\n";
		exit;
	}
	elsif ($FORM{'action'} eq "review") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&approve_members;
		&print_output('club_mod');
		exit;
	}
	elsif ($FORM{'action'} eq "cancel") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&cancel_members;
		&print_output('club_mod');
		exit;
	}
	elsif ($FORM{'action'} eq "edit_intro") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&edit_intro;
		&print_output('club_mod');
		exit;
	}
	elsif ($FORM{'action'} eq "save_intro") {
		&save_intro;
		print "Location: $GUrl{'clubs.cgi'}?club=$FORM{'club'}&action=intro\n\n";
		exit;
	}
	elsif ($FORM{'action'} eq "deletemember") {
		$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
		%IFORUM = &readbbs($bbs_cfg);
		&cancelmember;
		print "Location: $CONFIG{'COMMUNITY_full_cgi'}/cforum.cgi?forum=$FORM{'forum'}&action=getall\n\n";
		exit;
	}
	else {
		&Page_Header($GRP); 
	}

sub buildframe {
  	print "Content-type: text/html\n\n";
	print "<TITLE>$CONFIG{'CLUBS_Frame_Title'}</TITLE>\n";

	print "<FRAMESET COLS=\"135,*\" border=\"0\">\n";
  	print "   <frame src=\"$GUrl{'clubs.cgi'}?action=clubmenu&club=$FORM{'club'}\" leftmargin=\"5\" topmargin=\"5\" marginheight=\"5\" marginwidth=\"5\" name=\"titleframe\" noresize bordercolor=\"#000000\">\n";
  	print "   <frameset ROWS=\"70,*\" border=\"0\">\n";
  	print "   <frame src=\"$GUrl{'clubs.cgi'}?action=clubtitle&club=$FORM{'club'}\" leftmargin=\"5\" topmargin=\"5\" marginheight=\"5\" marginwidth=\"10\" name=\"menuframe\" scrolling=\"no\" noresize bordercolor=\"#000000\">\n";
  	print "   <frame src=\"$GUrl{'clubs.cgi'}?club=$FORM{'club'}&action=intro&clubs=T\" name=\"mainframe\" scrolling=\"auto\" leftmargin=\"5\" topmargin=\"5\" marginheight=\"5\" marginwidth=\"10\">\n";
  	print "   </frameset>\n";
	print "</FRAMESET>\n";
	exit;
}

sub clubtitle {
	$statuses{'official'} = "$CONFIG{'officialclub'}";
	$statuses{'recommended'} = "$CONFIG{'recommendedclub'}";
	$statuses{'approved'} = "$CONFIG{'approvedclub'}";
	$statuses{'unreviewed'} = "$CONFIG{'unreviewedclub'}";

	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";

	%IFORUM = &readbbs($bbs_cfg);
	%MOD = &get_moderator($IFORUM{'bbs_admin'});

	$fstatus = $statuses{$IFORUM{'status'}};

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/titlebar.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/titlebar.tmplt";

	&print_output('clubtitle');  
}

sub clubmenu {
	$TURL = &urlencode("$GUrl{'clubs.cgi'}?action=open&club=$FORM{'club'}");

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/menu.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/menu.tmplt";

	&print_output('clubmenu');  
}


sub intro_page {
	require $GPath{'cf_logs.pm'};
	&log_visit($FORM{'club'});
	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'club'}.cfg";
	%IFORUM = &readbbs($bbs_cfg);
	%MOD = &get_moderator($IFORUM{'bbs_admin'});

	$FORM{'forum'} = $FORM{'club'};
	$forum = $FORM{'club'};
	$FORM{'clubs'} = "T";

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/clubintro.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/clubintro.tmplt";
}


sub save_intro {
	$FORM{'introtext'} =~ s/(\cM|\n)/\n/g;
	open (INTRO, ">$GPath{'clubs_data'}/$FORM{'club'}/club_intro.txt");
	print INTRO "$FORM{'introtext'}\n";
	close (INTRO);
}

sub edit_intro {
	open (INTRO, "$GPath{'clubs_data'}/$FORM{'club'}/club_intro.txt");
	@intro = <INTRO>;
	close (INTRO);

	foreach $l (@intro) {
		$tintro .= $l;
	}
	if ($tintro eq "") {$tintro = "Welcome to our club!";}

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/editintro.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/editintro.tmplt";
}


sub get_forum {
	my ($cnt, $ff, $cfg, $id) = @_;

	tie my %posts, "DB_File", $ff;
	$forums[$cnt]{'id'} = $id; 
	$forums[$cnt]{'posts'} = 0;
	$forums[$cnt]{'systemtime'} = 0;
	$forums[$cnt]{'lastposting'} = "<I>Empty</I>";

	open(FCG, "$cfg");
	@contents = <FCG>;
	close(FCG);	

#	$OUT .= "$contents[0]=====$contents[1]<BR>\n";

	@config = split(/\|/, @contents[0]);

	$forums[$cnt]{'title'} = $config[0]; 
	$forums[$cnt]{'pg_color'} = $config[1]; 
	$forums[$cnt]{'win_color'} = $config[2]; 
	$forums[$cnt]{'font_face'} = $config[3]; 
	$forums[$cnt]{'text_color'} = $config[4]; 
	$forums[$cnt]{'title_color'} = $config[5]; 
	$forums[$cnt]{'ttxt_color'} = $config[6]; 
	$forums[$cnt]{'bbs_admin'} = $config[7];
	$forums[$cnt]{'access'} = $config[8];
	$forums[$cnt]{'restrictedto'} = $config[9];
	$forums[$cnt]{'group'} = $config[10];
	$forums[$cnt]{'newthreads'} = $config[11];
	$forums[$cnt]{'moderated'} = $config[12];
	$forums[$cnt]{'emailmoderator'} = $config[13];
	$forums[$cnt]{'moderator_edit'} = $config[14];
	$forums[$cnt]{'bbs_table1'} = $config[15];
	$forums[$cnt]{'bbs_table2'} = $config[16];
	$forums[$cnt]{'highlightcolor'} = $config[17];
	$forums[$cnt]{'topic_color'} = $config[18];
	$forums[$cnt]{'public'} = $config[19];
	$forums[$cnt]{'status'} = $statuses{$config[20]};
	if ($forums[$cnt]{'status'} =~ /\D/) { $forums[$cnt]{'status'} = 4; }
	$forums[$cnt]{'clubforum'} = $config[22];
	$forums[$cnt]{'bbs_private_pw'} = $config[26];
	$forums[$cnt]{'bbs_desc'} = $contents[1];
	$forums[$cnt]{'bbs_private_pw'} =~ s/\n//g;

	if ($forums[$cnt]{'moderated'} eq "Yes") {
		foreach $upost(sort keys %posts) {            #foreach thread...
			my %tposts = &readpost($posts{$upost});
			if (($moderated eq "Yes") && ($approved eq "F")) {next;}
			$forums[$cnt]{'posts'}++;
			$forums[$cnt]{'systemtime'} = $tposts{'pdate'};
			$forums[$cnt]{'lastposting'} = $tposts{'date'};
		}
	}
	else {
		my @tposts = sort keys %posts;
		$tot = $#tposts;
		my %tpost = &readpost($posts{$tposts[$tot]});
		$forums[$cnt]{'posts'} = $tot + 1;
		$forums[$cnt]{'systemtime'} = $tpost{'pdate'};
		$forums[$cnt]{'lastposting'} = $tpost{'date'} || "<I>Empty</I>";
	}
	if (! $forums[$cnt]{'posts'}) {$forums[$cnt]{'posts'} = 0;}

}


sub ForumList {
	$LAST_VISIT = $LAST_VISIT - 1800;

	$OUT .= "<TR><TD BGCOLOR=$CONFIG{'bbs_table2'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Forum</TD><TD BGCOLOR=$CONFIG{'bbs_table2'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Moderator/Owner</TD><TD BGCOLOR=$CONFIG{'bbs_table2'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">#Posts</TD><TD BGCOLOR=$CONFIG{'bbs_table2'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Last Post</TD></TR>\n";
	$Category = $FORM{'category'};

	open(FCAT,"$GPath{'cforums_data'}/forum.categories");
	@fcats=<FCAT>;
	close(FCAT);

	$cnt = 0;
	foreach $fc(@fcats) {
		chomp($fc);
		@entries=split(/\:/,$fc);
		$entries[1] =~ s/\|$//;

		if ($entries[1] eq $FORM{'category'}) {
			$forum_file = "$GPath{'cforums_data'}/$entries[0].db";
			$forum_cfg = "$GPath{'cforums_data'}/$entries[0].cfg";
			&get_forum($cnt,$forum_file,$forum_cfg,$entries[0]);
			$cnt++;
		}
	}

#	if ($#forums > 2) {
#		@forums = sort { $a=>{'status'} <=> $b=>{'status'} or $a=>{'posts'} <=> $b=>{'posts'} } @forums;
#	}
	$cnt--;

	for $x (0 .. $cnt) {
		if ($forums[$x]{'public'} eq "No") {next;}
		$f_name = $forums[$x]{'title'};
		$f_desc = $forums[$x]{'bbs_desc'};
		$f_mod = $forums[$x]{'bbs_admin'};
		$access = $forums[$x]{'access'};
		if (($f_mod ne "") && (-e "$GPath{'userpath'}/$f_mod.usrdat")) {
			%MOD = &get_moderator($f_mod);
			if ($MOD{'handle'} ne "") {
				$f_mod = $MOD{'handle'};
			}
			else {
				$f_mod = $MOD{'realname'};
			}
		}
		else {
			$f_mod = "Admin";
		}
		$NEW="";

		$time = $ilastvisit{$forums[$x]{'id'}} - 1800;

		if (($ilastvisit{$forums[$x]{'id'}}) && ($forums[$x]{'systemtime'} >= $time)) {
			$NEW .= $CONFIG{'new_message'};
		}
		$forum_icon = "";
		$clubflag = "";
		$URL = "";
		if ($forums[$x]{'clubforum'} ne "Club") {
			if (($access ne "Open To All") && ($access ne "")) {
				if ($access eq "Read-Only For Non-Privileged") {
					$forum_icon = "<IMG SRC=\"$CONFIG{'button_dir'}/readonly.gif\" ALT=\"Restricted Access\"> &nbsp; ";
					$readonly_forum++;
				}
				elsif ($access eq "Closed") {$f_name .= " (closed)";}
				else {
					$forum_icon = "<IMG SRC=\"$CONFIG{'button_dir'}/lock.gif\" ALT=\"Restricted Access\"> &nbsp; ";
					$closed_forum++;
				}
			}
			$URL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$forums[$x]{'id'}\">";
		}
		else {
			$clubflag = "$CONFIG{'clubflag'}";
			$URL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$forums[$x]{'id'}\">";
		}
		$OUT .= "$THISCATEGORY<TR BGCOLOR=\"$CONFIG{'bbs_table1'}\">\n";
		$OUT .= "<TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
		$OUT .= "<B>$forum_icon$URL$f_name</A> $clubflag</B><BR>$f_desc<BR>$PW</TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">$f_mod</TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><CENTER>$forums[$x]{'posts'}</CENTER></TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">$forums[$x]{'lastposting'}$NEW</TD>\n";
		$THISCATEGORY = "";
	}	
	if ($n == 2) {
		$n = 0;
	}
	if ($nc == $bbs_menu_columns) {
		$nc = 0; $OUT .= "</TR>";
	}
}


sub Body {
	&BBS_Menu;
}

sub BBS_Menu {

	if ($FORM{'category'} eq "") {
		&get_personal_settings($IUSER{'filenum'});
		@mfs = split(/!!/, $myforums);
		$MYFORUMS = "<TABLE WIDTH=600><TR><TD VALIGN=TOP WIDTH=150>\n\n";
		$MYFORUMS .= "<TABLE WIDTH=100% BORDER=2 CELLPADDING=0 CELLSPACING=0><TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><NOBR>&nbsp;&nbsp;My Clubs & Forums...</NOBR></TD><TD><IMG SRC=\"$CONFIG{'button_dir'}/none.gif\" BORDER=0 WIDTH=\"25\" HEIGHT=\"25\" VALIGN=middle ALIGN=middle></TD></TR></TABLE></TD><TR><TR><TD><TABLE WIDTH=100%>\n";
		foreach $mf (@mfs) {
			$count++;
			my %iFORUM = &readbbs("$GPath{'cforums_data'}/$mf.cfg");
			if (! $iFORUM{'title'}) {next;}
			if ($iFORUM{'clubforum'} ne "Club") { 
				$URL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$mf\" TARGET=\"_top\">";
			}
			else {
				$URL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$mf\" TARGET=\"_top\">";
			}
			$MYFORUMS .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">$count</TD><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">$URL$iFORUM{'title'}</A></FONT></TD></TR>\n";
		}
		if ($count < 1) {
			$MYFORUMS .= "<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">You have not joined any clubs or subscribed to any forums yet.</FONT></TD></TR>\n";
		}
		$MYFORUMS .= "</FONT></TABLE></TD></TR></TABLE></TD><TD VALIGN=TOP WIDTH=450>\n";
		$MYendFORUMS = "</TD></TR></TABLE>";
	}

	if ($CONFIG{'win_color'} ne "") {
		$CONFIG{'WINCOLOR'} .= " BGCOLOR=$CONFIG{'win_color'}";
	}
	else {
		$CONFIG{'WINCOLOR'} .= "";
	}

	if ($ENV{'HTTP_USER_AGENT'} =~ /MSIE/i) {
		$HELPURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=help&file=club_gettingaround\">";
	}
	else {
		$HELPURL = "<A HREF=\"javascript:ShowHelp('club_gettingaround')\">";
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

		<CENTER>
		$MYFORUMS
		<TABLE BORDER=2 $CONFIG{'WINCOLOR'} CELLSPACING=0 CELLPADDING=0>
		<TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">
		<TABLE BORDER=0 BGCOLOR="$CONFIG{'title_color'}" WIDTH="100%" CELLSPACING=0 CELLPADDING=0><TR>
             <TD><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">&nbsp;&nbsp;Find a Club or Forum and discuss your interests...</FONT></TD>
             <TD ALIGN="right" VALIGN=middle>
		     <TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD><A HREF="$GUrl{'myforum.cgi'}"><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">Personalize</FONT></A>&nbsp;&nbsp;</TD><TD>
                $HELPURL<IMG SRC="$CONFIG{'button_dir'}/help.gif" BORDER=0 WIDTH="25" HEIGHT="25"></A></TD></TR></TABLE>
             </TD></TR></TABLE>
          </TD></TR>
          <TR $CONFIG{'WINCOLOR'}>
             <TD><FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}">
                 <FONT FACE="$CONFIG{'font_face'}" COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}">
                   <INPUT TYPE="hidden" NAME="action" VALUE="getall">
LIST1



	$OUT .= "<TABLE WIDTH=100%><TR><TD><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">";
	$OUT .= "<B><A HREF=\"$GUrl{'clubs.cgi'}\">Home</A></B>::";
	@s = split(/\|/, $FORM{'category'});
	$us = &urlencode("\|$s[1]");
	$OUT .= "<B><A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$s[1]</A></B> / ";
	$us = &urlencode("\|$s[1]\|$s[2]");
	$OUT .= "<B><A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$s[2]</A></B>";
	if ($FORM{'category'} ne "") {
		$OUT .= "</TD><TD ALIGN=RIGHT HALIGN=RIGHT><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><A HREF=\"$GUrl{'clubs.cgi'}?action=create&category=$us\">Create A Club!</A></TD></TR></TABLE>\n";
	}
	else {
		$OUT .= "</TD><TD ALIGN=RIGHT HALIGN=RIGHT><BR></TD></TR></TABLE>\n";
	}
	if ($FORM{'category'} ne "") {
		&sub_cats($FORM{'category'});

		$OUT .= "<TABLE>\n<TR><TD BGCOLOR=BLACK>\n";
		$OUT .= "<TABLE CELLSPACING=0 CELLPADDING=5 WIDTH=\"100%\">\n";


		$js="L";
		&ForumList;

		$OUT .= "</TD></TR></TABLE>\n";
		$OUT .= "</TD></TR></TABLE>\n";

		if ($readonly_forum > 0) {
			$OUT .= "<BR><IMG SRC=\"$CONFIG{'button_dir'}/readonly.gif\" ALT=\"Restricted Access\"> = Read-Only: Only authorized members may post.\n";
		}
		if ($closed_forum > 0) {
			$OUT .= "<BR><IMG SRC=\"$CONFIG{'button_dir'}/lock.gif\" ALT=\"Restricted Access\"> = Private: Restricted/Limited Access\n";
		}
		$OUT .= "</TD></TR></TABLE>\n";
		$OUT .= "</CENTER>\n";
		$OUT .= "<INPUT TYPE=\"hidden\" NAME=\"forum\" VALUE=\"\">\n";
		$OUT .= "</FORM>$MYendFORUMS\n";
	}
	else {
		&sub_index;
		$OUT .= "</TD></TR></TABLE>\n";
		$OUT .= "</CENTER>\n";
		$OUT .= "<INPUT TYPE=\"hidden\" NAME=\"forum\" VALUE=\"\">\n";
		$OUT .= "</FORM>$MYendFORUMS\n";
	}
}




sub sub_index {
	my (@forumcats, $line, $c, $t, $found, $s, $us);

	open(FCAT,"$GPath{'cforums_data'}/categories.def");
	@forumcats=<FCAT>;
	close(FCAT);

	foreach $line (@forumcats) {
		$line =~ s/\|$//;
		$line =~ s/(\n|\cM)//g;
		@cs = split(/\|/, $line);
		$subs{$cs[1]} .= $cs[2] . "\|";
		if ($subc{$cs[1]} < 1) {
			push (@tsubs, $cs[1]);
		}
		$counts{$cs[2]} = $cs[3];
		$subc{$cs[1]}++;
	}
	

	@subs = sort (@subs);
	$OUT .= "<CENTER><TABLE CELLSPACING=5 CELLPADDING=5>\n";
	$colcount = 0;
	for $s (0 .. $#tsubs) {
		if ($colcount == 0) { $OUT .= "<TR>\n"; }
		$us = &urlencode("\|$tsubs[$s]");
		$OUT .= "<TD VALIGN=TOP>\n";
		$OUT .= "<LI><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><B><A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$tsubs[$s]</A></B><BR><FONT SIZE=-1>\n";
		@subsubs = split(/\|/, $subs{$tsubs[$s]});
		foreach $ss (@subsubs) {
			if ($ss eq "") {next;}
			$us = &urlencode("\|$tsubs[$s]\|$ss");
			$OUT .= "<A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$ss</A>, \n";
		}
		$OUT =~ s/, $//;
		$OUT .= "...</FONT></TD>\n";
		$colcount++;
		if ($CONFIG{'CFsubindexcols'} == $colcount) {
			$OUT .= "</TR>\n";
			$colcount = 0;
		}
	}
	if ($colcount != 0) {
		$OUT .= "</TR>\n";
	}
	$OUT .= "</TABLE>\n";
}

sub sub_cats {
	my ($cat) = $_[0];
	@tc = split(/\|/, $cat);
	my (@forumcats, $line, $c, $t, $found, $s, $us);

	open(FCAT,"$GPath{'cforums_data'}/categories.def");
	@forumcats=<FCAT>;
	close(FCAT);

	if ($cat ne "") {
		foreach $line (@forumcats) {
			@cs = split(/\|/, $line);
			$found = "F";
			if ($cs[1] eq $tc[1]) {
				if ($tc[2] eq "") {
					push (@subs, $cs[2]);
					push (@tsubs, $cs[1]);
					$counts{$cs[2]} = $cs[3];
				}
			}
		}
	}

	@subs = sort (@subs);
	$OUT .= "<CENTER><TABLE CELLSPACING=5>\n";
	$colcount = 0;
	for $s (0 .. $#subs) {
		if ($colcount == 0) { $OUT .= "<TR>\n"; }
		$subs[$s] =~ s/\n|\cM//g;
		$us = &urlencode("\|$tsubs[$s]\|$subs[$s]");
		$OUT .= "<TD><LI><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><B><A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$subs[$s]</A></B></TD>\n";
		$colcount++;
		if ($CONFIG{'CFsubcatcols'} == $colcount) {
			$OUT .= "</TR>\n";
			$colcount = 0;
		}
	}
	if ($colcount != 0) {
		$OUT .= "</TR>\n";
	}
	$OUT .= "</TABLE>\n";
}


			
sub save_forum {
#	print "Content-type: text/html\n\n";

	if ($VALIDUSER ne "T") {
		&error_not_logged_in;
	}

	$FORM{'applicantmessage'} =~ s/(\cM|\n)/ /g;

	if (($FORM{'title'} !~ /\w/) || ($FORM{'bbs_desc'} !~ /\w/)) {
		$error = "You must fill a title and a description for you club before creating it.  Please press back to try again.\n";
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";
		&print_output('error');
	}

	open (CFG, ">$GPath{'cforums_data'}/$FORM{'forum'}.cfg");
      print CFG "$FORM{'title'}|";
      print CFG "$CONFIG{'pg_color'}|";
      print CFG "$CONFIG{'win_color'}|";
      print CFG "$CONFIG{'font_face'}|";
      print CFG "$CONFIG{'text_color'}|";
      print CFG "$CONFIG{'title_color'}|";
      print CFG "$CONFIG{'ttxt_color'}|";
      print CFG "$FORM{'bbs_admin'}|";
      print CFG "$FORM{'access'}|";
      print CFG "$FORM{'restrictedto'}|";
      print CFG "$FORM{'group'}|";
      print CFG "$FORM{'newthreads'}|";
      print CFG "$FORM{'moderated'}|";
      print CFG "$FORM{'emailmoderator'}|";
      print CFG "$FORM{'moderator_edit'}|";
      print CFG "$CONFIG{'bbs_table1'}|";
      print CFG "$CONFIG{'bbs_table2'}|";
      print CFG "$CONFIG{'highlightcolor'}|";
      print CFG "$CONFIG{'topic_color'}|";
	print CFG "$FORM{'public'}|";
	print CFG "unreviewed|";
	print CFG "$FORM{'applicantmessage'}|";
	print CFG "$FORM{'clubforum'}|";
	print CFG "$CONFIG{'CLUB_max_kb'}|";
	print CFG "$CONFIG{'CLUB_max_images'}|";
	print CFG "|";
      print CFG "$FORM{'bbs_private_pw'}\n";
      print CFG "$FORM{'bbs_desc'}";
	close (CFG);

	open (CAT, "$GPath{'cforums_data'}/forum.categories");
	@CAT = <CAT>;
	close (CAT);

	open (CAT, ">$GPath{'cforums_data'}/forum.categories");
	foreach $l (@CAT) {
		@lc = split(/:/, $l);
		if ($lc[0] eq $FORM{'forum'}) {
			print CAT "$FORM{'forum'}:$FORM{'category'}\n";
			$FOUND1 = "T";
		}
		else {
			print CAT $l;
		}
	}
	close (CAT);

	if ($FOUND1 ne "T") {
		open (CAT, ">>$GPath{'cforums_data'}/forum.categories");
		print CAT "$FORM{'forum'}:$FORM{'category'}\n";
		close (CAT);
	}

	mkdir ("$GPath{'clubs_data'}/$FORM{'forum'}/", 0777);
	mkdir ("$CONFIG{'CLUB_image_path'}/$FORM{'forum'}/", 0777);
	mkdir ("$CONFIG{'CLUB_image_path'}/$FORM{'forum'}/photos/", 0777);
	mkdir ("$CONFIG{'CLUB_image_path'}/$FORM{'forum'}/thumbs/", 0777);

	if ($FORM{'restrictedto'} eq "Club Members Only") {
		open (MEMBERS, ">>$GPath{'cforums_data'}/$FORM{'forum'}.members");
		$FORM{'members'} =~ s/(\cM|\n)/\n/g;
		$FORM{'members'} =~ s/ +//g;
		print MEMBERS "$FORM{'members'}\n";
		close (MEMBERS);
	}

	require "./cm/user_changes.pm";
	&change_club($IUSER{'filenum'}, $IUSER{'username'}, $IUSER{'password'}, $FORM{'forum'}, \%IUSER);

	&get_personal_settings($IUSER{'filenum'});
	@mfrms = split(/!!/, $myforums);
	$myforums = "";
	foreach $mfrm (@mfrms) {
		if ($mfrm ne $FORUM{'forum'}) {
			$myforums .= "$mfrm!!";
		}
	}
	$myforums .= "$FORM{'forum'}";
	&save_settings($IUSER{'filenum'});

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/clubcreated.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/clubcreated.tmplt";
}

sub error_not_logged_in {
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/errornotloggedin.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/errornotloggedin.tmplt";

	&print_output('error');  
}

sub error_multiple_clubs {
	$error = "clubexists";
	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/error.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/error.tmplt";

	# For the sake of convience, just spit it out.
	&print_output('error');  
}

sub forum_form {
	$CAT .= "<A HREF=\"$GUrl{'clubs.cgi'}\">Home</A>::";
	@s = split(/\|/, $FORM{'category'});
	$us = &urlencode("\|$s[1]");
	$CAT .= "<A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$s[1]</A> / ";
	$us = &urlencode("\|$s[1]\|$s[2]");
	$CAT .= "<A HREF=\"$GUrl{'clubs.cgi'}?category=$us&display=$FORM{'display'}\">$s[2]</A>";


	if ($VALIDUSER ne "T") {
		&error_not_logged_in;
	}
	if (($IUSER{'Club'} ne "") && ($IUSER{'filenum'} ne $admin_num) && ($CONFIG{'club_1puser'} eq "YES")) {
		&error_multiple_clubs;
	}

	$forum = time . "," . $$;

	for $x(0 .. $max_groups) {
		$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
	}

	if ($ENV{'HTTP_USER_AGENT'} =~ /MSIE/i) {
		$HELPURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=help&file=club_create\">";
	}
	else {
		$HELPURL = "<A HREF=\"javascript:ShowHelp('club_create')\">";
	}

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/create.tmplt");
	$BODY .= $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/create.tmplt";
}

sub cancelmember {
	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'forum'}.cfg";
	%IFORUM = &readbbs($bbs_cfg);

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {

		open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'forum'}.members");
		@members = <MEMBERS>;
		close (MEMBERS);

		open (MEMBERS, ">$GPath{'cforums_data'}/$FORM{'forum'}.members");
		foreach $m (@members) {
			$m =~ s/(\n|\cM| )//g;
			if (($m ne "") && ($m ne $FORM{'UserName'})) {
				print MEMBERS "$m\n";
			}
		}
		close (MEMBERS);
	}
}


sub process_members {
	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'forum'}.cfg";
	%IFORUM = &readbbs($bbs_cfg);

	open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'forum'}.members");
	my @m = <MEMBERS>;
	close (MEMBERS);

	foreach my $l (@m) {
		$l =~ s/\n|\cM//g;
		$cmembers{$l}++;
	}

#	print "$VALIDUSER eq \"T\") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num\n";
	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {
		open (MEMBERS, ">>$GPath{'cforums_data'}/$FORM{'forum'}.members");
#		print "Members open!\n";
		foreach $k (keys %FORM) {
			if ($FORM{$k} eq "approve") {
				if ($cmembers{$k}) {next;}
				$cmembers{$k}++;
#				print "eaching $k\n";
				print MEMBERS "$k\n";
				($unumber,$uemail) = &get_user_number($k);
				if (($uemail) && ($unumber)) {
#					print "EMAIL: $uemail, $unumber<P>\n";
					&get_userpersonal_settings($unumber);
					@mfrms = split(/!!/, $myforums);
					$myforums = "";
					foreach $mfrm (@mfrms) {
						if ($mfrm ne $FORUM{'forum'}) {
							$myforums .= "$mfrm!!";
						}
					}
					$myforums .= "$FORM{'forum'}";
					&save_myforum_settings($unumber);
	
					$FORM{'email_text'} =~ s/\cM/\n/g;
					open (MAIL, "| $CONFIG{'mail_cmd'}") || &diehtml("I can't open sendmail\n");
					print MAIL "To: $uemail\n";
					print MAIL "From: $CONFIG{'email'}\n";
					print MAIL "Subject: Clubs Membership\n";
					print MAIL "$FORM{'email_text'}\n\n";
					close(MAIL);
					$jc++;
				}
			}
		}
		close (MEMBERS);
		unlink ("$GPath{'cforums_data'}/$FORM{'forum'}.members.tmp");
		require $GPath{'cf_logs.pm'};
		&log_join($FORM{'forum'}, $jc);
	}
}


sub approve_members {
	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'forum'}.cfg";
	%IFORUM = &readbbs($bbs_cfg);

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {

		open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'forum'}.members.tmp");
		@mpending = <MEMBERS>;
		close (MEMBERS);

		$CONFIG{'default_club_email'} =~ s/\[CLUBNAME\]/$IFORUM{'title'}/g;
		$CONFIG{'default_club_email'} =~ s/\[CLUBURL\]/$CONFIG{'COMMUNITY_full_cgi'}\/clubs.cgi?club=$FORM{'forum'}&action=open/g;

		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/approvemembers.tmplt");
		$BODY .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/approvemembers.tmplt";

	}
}
		
sub cancel_members {
	$bbs_cfg = "$GPath{'cforums_data'}/$FORM{'forum'}.cfg";
	%IFORUM = &readbbs($bbs_cfg);

	if (($VALIDUSER eq "T") && (($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) || ($IUSER{'filenum'} eq $admin_num))) {

		open (MEMBERS, "$GPath{'cforums_data'}/$FORM{'forum'}.members");
		@members = <MEMBERS>;
		close (MEMBERS);

		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/cancelmembers.tmplt");
		$BODY .= $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/cancelmembers.tmplt";
	}
}


sub long_date {
	my ($time) = @_;
	my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst )= localtime( $time );
	$year = $year + 1900;
	$sec = "0$sec" if ($sec < 10);
	$min = "0$min" if ($min < 10);
	$hour = "0$hour" if ($hour < 10);
	$mon = "0$mon" if ($mon < 10);
	$mday = "0$mday" if ($mday < 10);
	my ( $month )= ($mon + 1);
	my ( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

	my ( @weekday )=( "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" );

	return "$weekday[$wday -1] $months[$month -1] $mday, $year";
}


sub save_myforum_settings {
	my $un = $_[0];

	my $fn = $GPath{'userdirs'} . "/$un/myforums.txt";
	open (FILE, ">$fn") || &diehtml("Can't write to $fn");
	print FILE "$filteron&&$filterhow&&$notifyhow&&$emailonreponse\n";
	print FILE "$filteredusers\n";
	print FILE "$filteredwords\n";
	print FILE "$highlightedposts\n";
	print FILE "$notifywords\n";
	print FILE "$myforums\n";
	close (FILE);
}

sub get_userpersonal_settings {
	my $fn = $GPath{'userdirs'} . "/$USER_filenum/myforums.txt";
	open (FILE, "$fn");
	@tcontent = <FILE>;
	close (FILE);
	chop @tcontent;

	($filteron, $filterhow, $notifyhow, $emailonreponse) = split(/&&/, $tcontent[0]);
	$filteredusers = $tcontent[1];
	$filteredwords = $tcontent[2];
	$highlightedposts = $tcontent[3];
	$notifywords = $tcontent[4];
	$myforums = $tcontent[5];
}