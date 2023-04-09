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

$daystoshow = 10;

use DB_File;

$userpm = "T";
require "./common.pm";
require "$GPath{'imagesize.pm'}";

$PROGRAM_NAME = "cf_utils.cgi";


	$max_groups = 10;

	$postactivitydb = "$GPath{'cforums_data'}/postactivity.db";
	$activitydb = "$GPath{'cforums_data'}/activity.db";

	$statuses{'official'} = 4;
	$statuses{'recommented'} = 3;
	$statuses{'approved'} = 2;
	$statuses{'unreviewed'} = 1;
	
	$userpm = "T";
	require "./common.pm";
	require ("$GPath{'cf.pm'}");


	$forum_email = $CONFIG{'email'};
	$CONFIG{'bbs_table1'} =~ s/ +.*//g;
	$CONFIG{'bbs_table2'} =~ s/ +.*//g;

	&parse_FORM;

	if ($FORM{'action'} eq "WhoisOnline") {
		&WhoisOnline;
	}
	if ($FORM{'action'} eq "icq") {
		&icq;
	}
	if ($FORM{'action'} eq "show_members") {
		&show_members;
	}
	if ($FORM{'action'} eq "login") {
		&print_login_form;
		&print_output('login');
	}
	if ($FORM{'Send'} ne "") {
		&send_icq;
	}
	if ($FORM{'action'} eq "Login") {
		%IUSER = &get_user($FORM{'UserName'},$FORM{'PassWord'});
		print "Location: $FORM{'returnto'}\n";
		&basic_cookie;	
		print "\n";
	}


sub print_login_form {
	$BODY .= "<TABLE WIDTH=550 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Login</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";

   	$BODY .= "<P>Please fill in the blanks below to login and access The Member's Area\n";
   	$BODY .= "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'cf_utils.cgi'}\">\n";
	$BODY .= "<INPUT TYPE=HIDDEN NAME=\"returnto\" VALUE=\"$FORM{'returnto'}\">\n";
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
}


sub WhoisOnline {
	$postactivitydb = "$GPath{'cforums_data'}/postactivity.db";
	$activitydb = "$GPath{'cforums_data'}/activity.db";

	$rightnow = time;
	$ttc = $rightnow - (15*60);

	tie %activity, "DB_File", "$activitydb";

	$BODY .= "<TABLE BORDER=3 WIDTH=400>\n";
	$BODY .= "<TR><TD COLSPAN=2><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<CENTER><FONT SIZE=+1><B>Who's Here?</B></FONT><BR>These people have been active during the last fifteen minutes.</CENTER></TD></TR>\n";
	foreach $k (keys %activity) {
		@t = split(/\|/, $activity{$k});
		if (($t[0] eq "") || ($t[1] eq "")) {next;}
		if ($t[0] > $ttc) {
			push (@online, $k);
			%IUSER = &get_user_no_password($k,"NO");
			if (! $IUSER{'username'}) {next;}
			$IUSER{'password'} = undef;
			$BODY .= "<TR>\n";
			if ($IUSER{'icon'} ne "") {
				if ($IUSER{'icon'} =~ /\D/) {
					($iwidth, $iheight) = &imgsize("$CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'icon'}");
					$BODY .= "<TD><CENTER><A HREF=\"$GUrl{'moreinfo.cgi'}?UserName=$IUSER{'username'}\"><IMG SRC=\"$CONFIG{'ICON_upload_url'}/thumbs/$IUSER{'icon'}\" WIDTH=$iwidth HEIGHT=$iheight BORDER=0></A></CENTER></TD>";
				}
				else {
					$BODY .= "<TD><CENTER><IMG SRC=\"$GUrl{'icon_images'}/$IUSER{'icon'}.gif\" WIDTH=32 HEIGHT=32></CENTER></TD>";
				}
			}
			else {
				$BODY .= "<TD><BR></TD>\n";
			}
			if ($IUSER{'handle'} ne "") {
				$NAME = "$IUSER{'handle'}";
			}
			else {
				$NAME = "$IUSER{'realname'}";
			}
			$BODY .= "<TD>";
			$BODY .= "<FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
			$BODY .= "<B>Name: </B><A HREF=\"$GUrl{'moreinfo.cgi'}?UserName=$k\">$NAME ($k)</A><BR>\n";

			open (CFG, "$GPath{'cforums_data'}/$t[1].cfg");
			@cfg = <CFG>;
			close (CFG);
			@tcfg = split(/\|/, $cfg[0]);
			if ($tcfg[22] ne "Club") {
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
				$URL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=getall&forum=$t[1]\" TARGET=\"_top\">";
			}
			else {
				$clubflag = "$CONFIG{'clubflag'}";
				$URL = "<A HREF=\"$GUrl{'clubs.cgi'}?action=open&club=$t[1]\" TARGET=\"_top\">";
			}
			$BODY .= "<B>Where: </B>";
			$BODY .= "$forum_icon$URL$tcfg[0]</A> $clubflag<BR>\n";

			tie %pactivity, "DB_File", "$postactivitydb";
			@r = split(/&&/, $pactivity{$k});
			if ($r[0] ne "") {
				$td = &Long_Date($r[0]);
			   	$BODY .= "<B>Last Post: </B><A HREF=\"$GUrl{'cforum.cgi'}?action=message&forum=$r[1]&thread=$r[3]&highlight=$r[2]\">$td</A></TD></TR>\n";
			}
		}
	}
	$BODY .= "</TABLE>\n";
}

sub show_members {
	open (CFG, "$GPath{'cforums_data'}/$FORM{'club'}.cfg");
	@cfg = <CFG>;
	close (CFG);
	@tcfg = split(/\|/, $cfg[0]);

	$postactivitydb = "$GPath{'cforums_data'}/postactivity.db";
	$activitydb = "$GPath{'cforums_data'}/activity.db";
	
	tie %activity, "DB_File", "$activitydb";
	tie %pactivity, "DB_File", "$postactivitydb";

	$rightnow = time;
	$ttc = $rightnow - (15*60);

	tie %activity, "DB_File", "$activitydb";

	$BODY .= "<TABLE BORDER=3 WIDTH=400>\n";
	$BODY .= "<TR><TD COLSPAN=3><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "<CENTER><FONT SIZE=+1><B>Members of $tcfg[0]</B></FONT></CENTER></TD></TR>\n";

	open (FILE, "$GPath{'cforums_data'}/$FORM{'club'}.members");
	@members = <FILE>;
	close (FILE);

	foreach $member (@members) {
		$member =~ s/(\n|\cM)//g;
		if ($member !~ /\w/) {next;}
		&get_user_no_password($member,"NO","YES");
		$BODY .= "<TR>\n";
		if ($IUSER{'handle'}) {
			$name = $IUSER{'handle'};
		}
		else {
			$name = $IUSER{'realname'};
		}
		$MODERATOR = "";
		if ($IUSER{'filenum'} eq $tcfg[7]) {
			if ($tcfg[22] eq "Club") {
				$MODERATOR = "Club President";
			}
			else {
				$MODERATOR = "Moderator";
			}
		}
		if ($IUSER{'icon'} ne "") {
			if ($IUSER{'icon'} =~ /\D/) {
				($iwidth, $iheight) = &imgsize("$CONFIG{'ICON_upload_path'}/thumbs/$IUSER{'icon'}");
				$BODY .= "<TD><CENTER><A HREF=\"$GUrl{'moreinfo.cgi'}?UserName=$IUSER{'username'}\"><IMG SRC=\"$CONFIG{'ICON_upload_url'}/thumbs/$IUSER{'icon'}\" WIDTH=$iwidth HEIGHT=$iheight BORDER=0></A></CENTER></TD>";
			}
			else {
				$BODY .= "<TD><CENTER><IMG SRC=\"$GUrl{'icon_images'}/$IUSER{'icon'}.gif\" WIDTH=32 HEIGHT=32></CENTER></TD>";
			}
		}
		$BODY .= "<TD VALIGN=TOP><A HREF=\"$GUrl{'moreinfo.cgi'}?UserName=$member\">$name ($member)</A> $MODERATOR</TD>\n";
		@r = split(/&&/, $pactivity{$member});
		if ($r[0]) {
			$td = &Long_Date($r[0]);
		}
		else {
			$td = "N/A";
		}
		$BODY .= "<TD><B>Last Visit:</B> $td</TD></TR>\n";
	}

	$BODY .= "</TABLE>\n";
}



sub icq {
	$BODY .= <<ICQ;
		<form action="http://wwp.icq.com/scripts/WWPMsg.dll" method="post">
		<table border="2" cellpadding="1" cellspacing="1"><tr><td>
		<table cellpadding="0" cellspacing="0" border="0" $CONFIG{'WINCOLOR'}>
		<tr>
		<td align="center" nowrap colspan="2" BGCOLOR="$CONFIG{'title_color'}">
		<FONT COLOR="$CONFIG{'ttxt_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}"><b>The ICQ Online-Message Panel</b><BR>
		Instantly send a message to $FORM{'name'} via ICQ.</font></td>
		</tr>
		<tr>
		<td align="center"><FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}"><b>Sender Name</b> (optional):<br><input type="text" name="from" value="" size=15 maxlength=40 onfocus="this.select()"></td>
		<td align="center"><FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}"><b>Sender EMail</b> (optional):<br><input type="text" name="fromemail" value="" size=15 maxlength=40 onfocus="this.select()">
		<input type="hidden" name="subject" value="An Instant Message!"></td>
		</tr>
		<tr>
		<td align="center" colspan="2"><FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}">Message:<br>
		<FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}">
		<textarea name="body" rows="3" cols="30" wrap="Virtual"></textarea><br></td>
		</tr>
		<tr>
		<td colspan="2" align="center"><FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}">
		<input type="hidden" name="to" value="$FORM{'icq'}">
		<input type="submit" name="Send" value="Send Message">&nbsp;&nbsp;
		<input type="reset" value="Clear">
		</td>
		</tr>
		<tr>
		<td align="center" nowrap colspan="2">
		<FONT COLOR="$CONFIG{'text_color'}" SIZE="$CONFIG{'font_size'}" FACE="$CONFIG{'font_face'}">
		<a href="http://public.icq.com/public/panels/messagepanel/links/icq.html" TARGET=NEW>What is ICQ, Download</a>
		</td>
		</tr>
		</table>
		</td></tr></table>
		<CENTER><font face="ms sans serif" size="-2">&copy; 1999 ICQ Inc. All Rights Reserved.<br>Use of the ICQ Online-Message Panel is subject to <a href="http://public.icq.com/public/panels/messagepanel/links/legal.html" TARGET=NEW>Terms of Service</a></font></form></CENTER>
ICQ
}


&print_output('cf_utils');
exit;


