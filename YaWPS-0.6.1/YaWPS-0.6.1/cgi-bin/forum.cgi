#!/usr/bin/perl -Tw
$| = 1;
# =====================================================================
# YaWPS - Yet another Web Portal System 
#
# Copyright (C) 2001 by Adrian Heiszler (d3m1g0d@users.sourceforge.net)
#
# This program is free software; you can redistribute it and/or 
# modify it under the terms of the GNU General Public License 
# as published by the Free Software Foundation; either version 2 
# of the License, or (at your option) any later version. 
#
# This program is distributed in the hope that it will be useful, 
# but WITHOUT ANY WARRANTY; without even the implied warranty of 
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
# GNU General Public License for more details. 
# 
# You should have received a copy of the GNU General Public License 
# along with this program; if not, write to the 
# Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, 
# Boston, MA  02111-1307, USA. 
#
#
# $Id: forum.cgi,v 1.14 2003/01/18 13:16:37 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $board $thread $post $start $quote $notify $moda $del $state 
	$post_subject $post_message $post_icon 
	$to_board $from_board 
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$board = $query->param('board') || '';
$thread = $query->param('thread') || '';
$post = $query->param('post');
$start = $query->param('start') || 0;
$quote = $query->param('quote');
$notify = $query->param('notify');
$moda = $query->param('moda') || '';
$del = $query->param('del') || 0;
$state = $query->param('state');

$post_subject = $query->param('subject');
$post_message = $query->param('message');
$post_icon = $query->param('icon');

$to_board = $query->param('to_board');
$from_board = $query->param('from_board');

# Get user profile.
%user_data = authenticate();

# Define possible user actions.
%user_action = (
	view_board => \&view_board,
	view_thread => \&view_thread,
	post => \&post,
	post2 => \&post2,
	modify => \&modify,
	modify2 => \&modify2,
	notify => \&notify,
	notify2 => \&notify2,
	move_thread => \&move_thread,
	move_thread2 => \&move_thread2,
	remove_thread => \&remove_thread,
	remove_thread2 => \&remove_thread2,
	lock_thread => \&lock_thread,
	print_thread => \&print_thread
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { board_index(); }

# ---------------------------------------------------------------------
# Display the board index.
# ---------------------------------------------------------------------
sub board_index
{
	# Get all categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. $!", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	my $total_threads = 0;
	my $total_messages = 0;

	print_header();
	print_html($user_data{theme}, $nav{3});

	print <<"HTML";
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td valign="bottom"><img src="$cfg{imagesurl}/forum/open.gif" width="17" height="15" border="0" alt="">&nbsp;&nbsp;
$nav{3}</td>
</tr>
</table>
<table class="bg5" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td width="10">&nbsp;</td>
<td><b>$msg{95}</b></td>
<td nowrap align="center"><b>$msg{96}</b></td>
<td nowrap align="center"><b>$msg{97}</b></td>
<td nowrap align="center"><b>$msg{98}</b></td>
<td nowrap><b>$msg{99}</b></td>
</tr>
HTML

	# Get current date.
	my $current_date = get_date();

	# Cycle through the categories.
	foreach my $curcat (@categories) 
	{
		my @cat_info;
		if (-e("$cfg{boardsdir}/$curcat.cat"))
		{
			sysopen(FH, "$cfg{boardsdir}/$curcat.cat", O_RDONLY);
			chomp(@cat_info = <FH>);
			close(FH);
		}

		# Check if forum is private.
		if ($cat_info[1]) 
		{
			if ($user_data{sec_level} ne $usr{admin} && $user_data{sec_level} ne $cat_info[1]) { next; }
		}

		# Get name of category.
		my $cat_name = $cat_info[0];

		print <<"HTML";
<tr class="bg2">
<td width="10" valign="top">&nbsp;</td>
<td colspan="5"><b>$cat_name</b></td>
</tr>
HTML

		my $row_color = " class=\"tbl_row_dark\"";
		foreach my $curboard (@cat_info) 
		{
			if ($curboard ne $cat_info[0] && $curboard ne $cat_info[1]) 
			{
				# Alternate the row colors.
				if ($row_color eq " class=\"tbl_row_dark\"") { $row_color = " class=\"tbl_row_light\""; }
				else { $row_color = " class=\"tbl_row_dark\""; }

				# Get board info.
				my @board_info;
				if (-e("$cfg{boardsdir}/$curboard.dat"))
				{
					sysopen(FH, "$cfg{boardsdir}/$curboard.dat", O_RDONLY);
					chomp(@board_info = <FH>);
					close(FH);
				}

				my $board_name = $board_info[0];
				my $board_desc = $board_info[1];

				# Get data of current board.
				sysopen(FH, "$cfg{boardsdir}/$curboard.txt", O_RDONLY);
				chomp(my @messages = <FH>);
				close(FH);

				# Get count of topics in this board.
				my $board_topics = @messages;

				# Get date and name of poster of last post in this forum.
				my ($date, $poster, $num, $post_date, $replies) = '';
				if (@messages) { (undef, undef, undef, undef, undef, $date, undef, undef, $poster, undef, undef) = split(/\|/, $messages[0]); }

				# Get count of messages in every thread.
				my ($message_count, $unseen) = 0;
				for (my $i = 0; $i < @messages; $i++) 
				{
					($num, undef, undef, undef, undef, $post_date, $replies, undef, undef, undef, undef, undef) = split(/\|/, $messages[$i]);

					$message_count++;
					$message_count = $message_count + $replies;

					# Check if there are new messages in this forum.
					my $last_post_date = read_forum_log($user_data{uid}, $num);

					# Calulate time difference between postdate and current date.
					my $time_diff = calc_time_diff($post_date, $current_date, 1);

					# Count the unread messages.
					if ($last_post_date eq '' && $time_diff <= $cfg{max_log_days_old} && $user_data{uid} ne $usr{anonuser}) { $unseen++; }
				}

				# Get moderator for this forum.
				sysopen(FH, "$cfg{memberdir}/$board_info[2].dat", O_RDONLY);
				chomp(my @mod_profile = <FH>);
				close(FH);

				my $moderator = $mod_profile[1];

				# Check if forum contains new posts.
				my $new = qq(<img src="$cfg{imagesurl}/forum/off.gif" alt="">);
				if ($unseen) { $new = qq(<img src="$cfg{imagesurl}/forum/on.gif" alt="">); }
		
				if (!$poster) { $poster = "???"; }
				if (!$date) { $date = "???"; }

				print <<"HTML";
<tr$row_color>
<td valign="top" width=10>$new</td>
<td valign="top">
<b><a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_board;board=$curboard">$board_name</a></b><br>
$board_desc</td>
<td valign="top" width="15%" align="center">$board_topics</td>
<td valign="top" width="15%" align="center">$message_count</td>
<td valign="top" width="15%" align="center">$date<br>($poster)</td>
<td valign="top" width="20%">$moderator</td>
</tr>
HTML

				# Calculate total thread and message count.
				$total_messages = $total_messages + $message_count;
				$total_threads = $total_threads + $board_topics;
			}
		}
	}

	print <<"HTML";
</table>
</td>
</tr>
</table>
<table width="100%">
<tr>
<td align="right">$total_messages $msg{97}<br>
$total_threads $msg{96}</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, $nav{12}, 1);
}

# ---------------------------------------------------------------------
# Display the message index.
# ---------------------------------------------------------------------
sub view_board 
{
	# Get all categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. $!", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	# Check if user has permission to access the forum.
	foreach my $curcat (@categories) 
	{
		sysopen(FH, "$cfg{boardsdir}/$curcat.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$curcat.cat. $!", $user_data{theme});
		chomp(my @cat_info = <FH>);
		close(FH);

		foreach my $curboard (@cat_info) 
		{
			if ($curboard ne $cat_info[0]) 
			{
				if ($cat_info[1] && $curboard eq $board && $user_data{sec_level} ne $usr{admin} && $user_data{sec_level} ne $cat_info[1]) { user_error($err{11}, $user_data{theme}); }
			}
		}
	}

	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	# Get board name.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	# Get censored words.
	my @censored;
	if (-e("$cfg{datadir}/censor.txt"))
	{
		sysopen(FH, "$cfg{datadir}/censor.txt", O_RDONLY);
		chomp(@censored = <FH>);
		close(FH);
	}

	my $board_name = $board_info[0];

	print_header();
	print_html($user_data{theme}, "$nav{3} >>> $board_name");

	print <<"HTML";
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td><img src="$cfg{imagesurl}/forum/open.gif" width="17" height="15" border="0" alt="">&nbsp;&nbsp;
<a href="$cfg{pageurl}/forum.$cfg{ext}">$nav{3}</a>
<br>
<img src="$cfg{imagesurl}/forum/tline.gif" width="12" height="12" border="0" alt=""><img src="$cfg{imagesurl}/forum/open.gif" width="17" height="15" border="0" alt="">&nbsp;&nbsp;$board_name</td>
<td align="right" valign="bottom"><a href="$cfg{pageurl}/forum.$cfg{ext}?op=post;board=$board"><img src="$cfg{imagesurl}/forum/new_thread.gif" alt="$msg{100}" border="0"></a></td>
</tr>
</table>
<table class="bg5" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td width="16">&nbsp;</td>
<td width="15">&nbsp;</td>
<td width="40%"><b>$msg{37}</b></td>
<td width="20%"><b>$msg{101}</b></td>
<td width="10%" align="center"><b>$msg{102}</b></td>
<td width="10%" align="center"><b>$msg{157}</b></td>
<td width="20%" align="center"><b>$msg{103}</b></td>
HTML

	# Get current date.
	my $current_date = get_date();

	# Get all topics in this forum.
	my $num_shown = 0;
	my $row_color = " class=\"tbl_row_dark\"";
	for (my $i = $start; $i < @messages; $i++) 
	{
		my ($num, $subject, $name, $username, $email, $date, $replies, $views, $last_poster, $icon, $state) = split(/\|/, $messages[$i]);

		# Alternate the row colors.
		if ($row_color eq " class=\"tbl_row_dark\"") { $row_color = " class=\"tbl_row_light\""; }
		else { $row_color = " class=\"tbl_row_dark\""; }

		# Check if message is new.
		my $last_viewed_date = read_forum_log($user_data{uid}, $num);

		# Calulate time difference between postdate and current date.
		my $time_diff = calc_time_diff($date, $current_date, 1);

		# Check if post should be marked as new.
		my $new = '';
		if ($last_viewed_date eq '' && $time_diff <= $cfg{max_log_days_old} && $user_data{uid} ne $usr{anonuser}) { $new = qq(<img src="$cfg{imagesurl}/forum/new.gif" alt="">); }

		# Check for bad words.
		foreach my $censor (@censored) 
		{
			my ($word, $censored) = split(/\=/, $censor);
			$subject =~ s/$word/$censored/g;
		}

		# Check if thread is hot or not.
		my $type;
		if ($state == 0) { $type = "thread"; }
		if ($replies >= 15 || $views >= 75) { $type = "hotthread"; }
		if ($replies >= 25 || $views >= 100) { $type = "veryhotthread"; }
		if ($state == 1) { $type = "locked"; }

		# Thread page navigator.
		my $num_messages = $replies + 1;
		my $count = 0;
		my $pages;
		if ($num_messages > $cfg{max_items_per_page}) 
		{
			while ($count * $cfg{max_items_per_page} < $num_messages) 
			{
				my $view = $count + 1;
				my $strt = ($count * $cfg{max_items_per_page});
				$pages .= qq( [<a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$num;start=$strt">$view</a>]);
				$count++;
			}

			$pages =~ s/\n$//g;
			$pages = qq(( <img src="$cfg{imagesurl}/forum/multipage.gif" alt=""> $pages ));
		}
		else { $pages = ''; }

		print <<"HTML";
<tr$row_color>
<td width="16"><img src="$cfg{imagesurl}/forum/$type.gif" alt=""></td>
<td width="15"><img src="$cfg{imagesurl}/forum/$icon.gif" alt="" border="0" align="middle"></td>
<td width="40%"><a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$num"><b>$subject</b></a> $new $pages</td>
<td width="20%">$name</td>
<td width="10%" align="center">$replies</td>
<td width="10%" align="center">$views</td>
<td width="20%" align="center">$date<br>$msg{42} $last_poster</td>
</tr>
HTML

		$num_shown++;
		if ($num_shown >= $cfg{max_items_per_page}) { $i = @messages; }
	}

	print <<"HTML";
</table>
</td>
</tr>
</table>
<table border="0" width="100%">
<tr>
<td><b>$msg{39}</b>
HTML

	# Make page navigation bar.
	my $num_messages = @messages;
	my $count = 0;
	while ($count * $cfg{max_items_per_page} < $num_messages) 
	{
		my $view = $count + 1;
		my $strt = $count * $cfg{max_items_per_page};
		if ($start == $strt) { print "[$view] "; }
		else { print qq(<a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_board;board=$board;start=$strt">$view</a> ); }
		$count++;
	}

	print <<"HTML";
</td>
<td align="right"><a href="$cfg{pageurl}/forum.$cfg{ext}?op=post;board=$board"><img src="$cfg{imagesurl}/forum/new_thread.gif" alt="$msg{100}" border="0"></a></td>
</tr>
<tr>
<td colspan="2" align="right" valign="bottom">
<div align="right">
HTML

	# Make forum selector.
	forum_selector();

	print <<"HTML";
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "$nav{3} >>> $board_name", 1);
}

# ---------------------------------------------------------------------
# Display a thread.
# ---------------------------------------------------------------------
sub view_thread
{
	user_error($err{6}, $user_data{theme}) if ($thread !~ /^[0-9]+$/);

	# Get all categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. $!", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	# Check if user has permission to access the forum.
	foreach my $curcat (@categories) 
	{
		sysopen(FH, "$cfg{boardsdir}/$curcat.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$curcat.cat. $!", $user_data{theme});
		chomp(my @cat_info = <FH>);
		close(FH);

		foreach my $curboard (@cat_info) 
		{
			if ($curboard ne $cat_info[0]) 
			{
				if ($cat_info[1] && $curboard eq $board && $user_data{sec_level} ne $usr{admin} && $user_data{sec_level} ne $cat_info[1]) { user_error($err{11}, $user_data{theme}); }
			}
		}
	}

	my ($num, $subject, $nick, $email, $date, $username, $icon, $ip, $message, $replies, $views, $last_poster, $state);

	# Get member ranks.
	my @member_ranks;
	if (-e("$cfg{memberdir}/membergroups.dat"))
	{
		sysopen(FH, "$cfg{memberdir}/membergroups.dat", O_RDONLY);
		chomp(@member_ranks = <FH>);
		close(FH);
	}

	# Get thread data.
	sysopen(FH, "$cfg{messagedir}/$thread.txt", O_RDONLY) or user_error("$err{1} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	if (@messages) { ($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[@messages - 1]); }

	# Log action.
	write_forum_log($user_data{uid}, $thread);

	# Get board name and name of moderator.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_name = $board_info[0];
	my $board_moderator = $board_info[2];

	# Get censored words.
	my @censored;
	if (-e("$cfg{datadir}/censor.txt"))
	{
		sysopen(FH, "$cfg{datadir}/censor.txt", O_RDONLY);
		chomp(@censored = <FH>);
		close(FH);
	}

	# Get board threads.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Data integrity check.
	if ($board =~ /^([\w.]+)$/) { $board = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update view counter
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @threads; $i++) 
	{
		($num, $subject, $nick, $username, $email, $date, $replies, $views, $last_poster, $icon, $state) = split(/\|/, $threads[$i]);
		if ($thread eq $num) 
		{
			$views++;
			print FH "$num|$subject|$nick|$username|$email|$date|$replies|$views|$last_poster|$icon|$state\n";
		}
		else { print FH "$num|$subject|$nick|$username|$email|$date|$replies|$views|$last_poster|$icon|$state\n"; }
	}

	close(FH);

	# Check if thread is hot or not.
	my $type;
	for (my $i = 0; $i < @threads; $i++) 
	{
		($num, $subject, $nick, $username, $email, $date, $replies, $views, $last_poster, $icon, $state) = split(/\|/, $threads[$i]);
		if ($thread eq $num) 
		{ 
			if ($state == 0) { $type = "thread"; }
			if ($replies >= 15 || $views >= 75) { $type = "hotthread"; }
			if ($replies >= 25 || $views >= 100) { $type = "veryhotthread"; }
			if ($state == 1) { $type = "locked"; }
			$i = @threads;
		}
	}

	# Get thread title
	if (@messages) { ($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[0]); }

	# Check for bad words.
	foreach my $censor (@censored) 
	{
		my ($word, $censored) = split(/\=/, $censor);
		$subject =~ s/$word/$censored/g;
	}

	# Make notify button.
	my $notification = '';
	if ($cfg{enable_notification} && $user_data{uid} ne $usr{anonuser}) 
	{ 
		$notification = qq(&nbsp;<a href="$cfg{pageurl}/forum.$cfg{ext}?op=notify;board=$board;thread=$thread"><img src="$cfg{imagesurl}/forum/notify.gif" alt="$msg{105}" border="0"></a> ); 
	}

	print_header();
	print_html($user_data{theme}, "$nav{3} >>> $board_name");

	print <<"HTML";
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td valign="bottom"><img src="$cfg{imagesurl}/forum/open.gif" width="17" height="15" border="0" alt="">&nbsp;&nbsp;
<a href="$cfg{pageurl}/forum.$cfg{ext}">$nav{3}</a>
<br>
<img src="$cfg{imagesurl}/forum/tline.gif" width="12" height="12" border="0" alt=""><img src="$cfg{imagesurl}/forum/open.gif" width="17" height="15" border="0" alt="">&nbsp;&nbsp;<a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_board;board=$board">$board_name</a>
<br>
<img src="$cfg{imagesurl}/forum/tline2.gif" width="24" height="12" border="0" alt=""><img src="$cfg{imagesurl}/forum/open.gif" width="17" height="15" border="0" alt="">&nbsp;&nbsp;$subject</td>
<td align="right" valign="bottom"><a href="$cfg{pageurl}/forum.$cfg{ext}?op=print_thread;board=$board;thread=$thread" target="_blank"><img src="$cfg{imagesurl}/forum/print.gif" alt="$msg{106}" border="0"></a><br>
<a href="$cfg{pageurl}/forum.$cfg{ext}?op=post;board=$board;thread=$thread;start=$start;quote="><img src="$cfg{imagesurl}/forum/reply.gif" alt="$msg{107}" border="0"></a>$notification</td>
</tr>
</table>
<table class="bg5" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="$cfg{imagesurl}/forum/$type.gif" alt=""></td>
<td>&nbsp;<b>$msg{49}</b></td>
</tr>
</table>
</td>
<td><b>$msg{64} $subject</b></td>
</tr>
HTML

	# Show all messages in this thread.
	my $num_shown;
	my $row_color = " class=\"tbl_row_dark\"";
	for (my $i = $start; $i < @messages; $i++) 
	{
		($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[$i]);

		if (!$subject) { $subject = "---"; }
		$message =~ s/\n//g;

		# Alternate the row colors.
		if ($row_color eq " class=\"tbl_row_dark\"") { $row_color = " class=\"tbl_row_light\""; }
		else { $row_color = " class=\"tbl_row_dark\""; }

		# Check if IP address should be viewable.
		if ($user_data{sec_level} ne $usr{admin}) { $ip = $msg{108}; }
		
		my $removed = 0;
		if (!(-e("$cfg{memberdir}/$username.dat"))) { $removed = 1; }

		my ($postinfo, $signature, $star, $url_link, $email_link, $profile_link, $icq_link, $send_im_link) = '';

		# Display member's profile.
		my (@user_profile, $member_info);
		if ($username ne $usr{anonuser} && $removed == 0) 
		{
			if (-e("$cfg{memberdir}/$username.dat"))
			{
				sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY);
				chomp(@user_profile = <FH>);
				close(FH);
			}

			my $ranking = $user_profile[6] + $user_profile[11] + $user_profile[12];

			# Display member ranking.
			$member_info = $member_ranks[0];
			$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			if ($ranking > 25) 
			{
				$member_info = $member_ranks[1];
				$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			}
			if ($ranking > 50) 
			{
				$member_info = $member_ranks[2];
				$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			}
			if ($ranking > 75) 
			{
				$member_info = $member_ranks[3];
				$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			}
			if ($ranking > 100) 
			{
				$member_info = $member_ranks[4];
				$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			}
			if ($ranking > 250) 
			{
				$member_info = $member_ranks[5];
				$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			}
			if ($ranking > 500) 
			{
				$member_info = $member_ranks[6];
				$star = qq(<img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0"><img src="$cfg{imagesurl}/forum/star.gif" alt="" border="0">);
			}

			if ($board_moderator eq $username) { $member_info = $usr{mod}; }
			if ($user_profile[7]) { $member_info = $user_profile[7]; }

			if ($user_data{uid} ne $usr{anonuser} && $username ne $usr{anonuser})
			{ 
				# Make link to user's homepage.
				$url_link = qq(<a href="$user_profile[4]" target="_blank"><img src="$cfg{imagesurl}/forum/www.gif" alt="$msg{53} $user_profile[1]" border="0"></a>); 

				# Make link to send email to user.
				$email_link = qq(&nbsp;&nbsp;<a href="mailto:$email"><img src="$cfg{imagesurl}/forum/email.gif" alt="$msg{55} $nick" border="0"></a>); 

				# Make link to user's profile.
				$profile_link = qq(&nbsp;&nbsp;<a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$username"><img src="$cfg{imagesurl}/forum/profile.gif" alt="$msg{51} $user_profile[1]" border="0"></a>);

				# Make link to send IMs.
				$send_im_link = qq(&nbsp;&nbsp;<a href="$cfg{pageurl}/instant_messenger.$cfg{ext}?op=imsend;to=$username"><img src="$cfg{imagesurl}/forum/message.gif" alt="$msg{109} $nick" border="0"></a>); 

				# Make ICQ link.
				if ($user_profile[8]) { $icq_link = qq(&nbsp;&nbsp;<a href="http://www.icq.com/$user_profile[8]" target="_blank"><img src="http://wwp.icq.com/scripts/online.dll?icq=$user_profile[8]&amp;img=5" alt="$msg{52} $user_profile[8]" border="0"></a>); }
				if (!$user_profile[8]) { $icq_link = ''; }
			}

			# Display the signature.
			$signature = $user_profile[5];
			$signature =~ s/\&\&/<br>/g;
			$signature = <<"HTML";
<br><br><br>
__________________<br>
$signature
HTML
		}

		# Show member picture.
		my $member_pic;
		if ($username ne $usr{anonuser}) 
		{ 
			if (!$user_profile[9]) { $user_profile[9] = "_nopic.gif"; }
			if ($user_profile[9] =~ /http:\/\//) 
			{
				my ($width, $height);
				if ($cfg{picture_width}) { $width = qq(width="$cfg{picture_width}"); } 
				if ($cfg{picture_height}) { $height = qq(height="$cfg{picture_height}"); } 

				$member_pic = qq(<img src="$user_profile[9]" $width $height border="0" alt="$username">);
			}
			else { $member_pic = qq(<img src="$cfg{imagesurl}/avatars/$user_profile[9]" border="0" alt="">); }
		}

		# Disable special infos if user is a guest.
		if ($username eq $usr{anonuser}) 
		{ 
			$member_pic = ''; 
			$member_info = ''; 
			$star = ''; 
			$signature = ''; 
		}

		# Add signature to message and make UBBC.
		$message = "$message\n$signature";
		$message = do_ubbc($message);


		# Check for bad words.
		foreach my $censor (@censored) 
		{
			my ($word, $censored) = split(/\=/, $censor);
			$subject =~ s/$word/$censored/g;
			$message =~ s/$word/$censored/g;
		}

		print <<"HTML";
<tr$row_color>
<td width="140" valign="top"><a name="$i"></a><b>$nick</b><br>
$member_pic<br>
$member_info<br>
$star</td>
<td valign="top">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td><img src="$cfg{imagesurl}/forum/$icon.gif" alt=""></td>
<td width="100%">&nbsp;<b>$subject</b></td>
<td align="right" nowrap>&nbsp;<b>$msg{110}</b> $date</td>
</tr>
</table>
<hr noshade="noshade" size="1">
$message<br>
</td>
</tr>
<tr$row_color>
<td><img src="$cfg{imagesurl}/forum/ip.gif" alt="$msg{111}" align="top"> $ip</td>
<td>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
HTML

	if ($user_data{uid} ne $usr{anonuser} && $username ne $usr{anonuser}) { print $url_link . $email_link . $profile_link . $send_im_link . $icq_link; }

	print <<"HTML";
</td>
<td align="right"><a href="$cfg{pageurl}/forum.$cfg{ext}?op=post;board=$board;thread=$thread;quote=$i;title=post+reply;start=$start"><img src="$cfg{imagesurl}/forum/quote.gif" alt="$msg{56}" border="0"></a>&nbsp;&nbsp;
HTML

	# Print user actions.
	if ($user_data{uid} ne $usr{anonuser}) { print qq(<a href="$cfg{pageurl}/forum.$cfg{ext}?op=modify;board=$board;thread=$thread;post=$i"><img src="$cfg{imagesurl}/forum/modify.gif" alt="$msg{112}" border="0"></a>&nbsp;&nbsp;<a href="$cfg{pageurl}/forum.$cfg{ext}?op=modify2;board=$board;thread=$thread;post=$i;del=1"><img src="$cfg{imagesurl}/forum/delete.gif" alt="$msg{58}" border="0"></a>); }

	print <<"HTML";
</td>
</tr>
</table>
</td>
</tr>
HTML

		$num_shown++;
		if ($num_shown >= $cfg{max_items_per_page}) { $i = @messages; }
	}

	print <<"HTML";
</table>
</td>
</tr>
</table>
<table border="0" width="100%" cellspacing="1" cellpadding="2">
<tr>
<td><b>$msg{39}</b>
HTML

	# Make page navigation bar.
	my $num_messages = @messages;
	my $count = 0;
	while ($count * $cfg{max_items_per_page} < $num_messages) 
	{
		my $view = $count + 1;
		my $strt = $count * $cfg{max_items_per_page};
		if ($start == $strt) { print "[$view] "; }
		else { print qq(<a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$thread;start=$strt">$view</a> ); }
		$count++;
	}

	print qq(</td>\n<td align="right">);

	# Make admin buttons.
	if ($user_data{uid} eq $board_moderator || $user_data{sec_level} eq $usr{admin}) { print qq(<a href="$cfg{pageurl}/forum.$cfg{ext}?op=move_thread;board=$board;thread=$thread"><img src="$cfg{imagesurl}/forum/move.gif" alt="$msg{113}" border="0"></a>&nbsp;<a href="$cfg{pageurl}/forum.$cfg{ext}?op=remove_thread;board=$board;thread=$thread"><img src="$cfg{imagesurl}/forum/remove.gif" alt="$msg{114}" border="0"></a>&nbsp;<a href="$cfg{pageurl}/forum.$cfg{ext}?op=lock_thread;board=$board;thread=$thread"><img src="$cfg{imagesurl}/forum/lock.gif" alt="$msg{115}" border="0"></a>); }

	print <<"HTML";
</td>
<td align="right"><a href="$cfg{pageurl}/forum.$cfg{ext}?op=post;board=$board;thread=$thread;start=$start;quote="><img src="$cfg{imagesurl}/forum/reply.gif" alt="$msg{107}" border="0"></a>$notification</td>
</tr>
</table>
<div align="right">
HTML

	# Make forum selector.
	forum_selector();

	print "</div>";

	print_html($user_data{theme}, "$nav{3} >>> $board_name", 1);
}

# ---------------------------------------------------------------------
# Print formular to add a post.
# ---------------------------------------------------------------------
sub post 
{
	if ($user_data{uid} eq $usr{anonuser} && !$cfg{enable_guest_posting}) { user_error($err{11}, $user_data{theme}); }

	my ($num, $subject, $nick, $email, $date, $username, $icon, $ip, $message, $replies, $views, $last_poster, $state, @messages);

	# Get board threads.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Check if thread is locked.
	for (my $i = 0; $i < @threads; $i++) 
	{
		($num, $subject, $nick, $username, $email, $date, $replies, $views, $last_poster, $icon, $state) = split(/\|/, $threads[$i]);

		if ($thread eq $num && $state == 1) 
		{
			$i = @threads;
			user_error($err{24}, $user_data{theme});
		}
	}

	# Display the notification button. 
	my $notification = '';
	if ($cfg{enable_notification} && $user_data{uid} ne $usr{anonuser}) 
	{
	 	$notification = <<"HTML";
<tr>
<td><b>$msg{105}</b></td>
<td><input type="checkbox" name="notify" value="x"></td>
</tr>
HTML
	}

	# Get post data.
	my ($subject_form_field, $message_form_field) = '';
	if ($thread)
	{
		sysopen(FH, "$cfg{messagedir}/$thread.txt", O_RDONLY) or user_error("$err{1} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
		chomp(@messages = <FH>);
		close(FH);

		($subject, undef, undef, undef, undef, undef, undef, $message) = split(/\|/, $messages[0]);

		# Format subject and message.
		$subject =~ s/Re: //g;
		$subject_form_field = "Re: $subject";

		if ($quote ne '') 
		{
			my ($subject_q, $nick_q, $email_q, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[$quote]);
			
			$message_form_field = $message;
			$message_form_field =~ s/\[quote\](\S+?)\[\/quote\]//isg;
			$message_form_field =~ s/\[(\S+?)\]//isg;
			$message_form_field = "\n\n\[quote\]$message\[/quote\]";
			$message_form_field = html_to_text($message_form_field);

			$subject =~ s/Re: //g;
			$subject_form_field = "Re: $subject";
		}
		else { $message_form_field = ''; }
	}
	else
	{
		$subject_form_field = '';
		$message_form_field = '';
	}

	print_header();
	print_html($user_data{theme}, $nav{36});

	print <<"HTML";
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
<td><form action="$cfg{pageurl}/forum.$cfg{ext}" method="post" name="creator">
<table border="0">
<tr>
<td><b>$msg{13}</b></td>
<td>$user_data{nick}</td>
</tr>
<tr>
<td><b>$msg{7}</b></td>
<td>$user_data{email}</td>
</tr>
<tr>
<td><b>$msg{37}</b></td>
<td><input type="text" name="subject" value="$subject_form_field" size="40" maxlength="50"></td>
</tr>
<tr>
<td><b>$msg{116}</b></td>
<td>
HTML

	# Print the UBBC image selector.
	my $ubbc_image_selector = print_ubbc_image_selector();
	print $ubbc_image_selector;

print <<"HTML";
<textarea name="message" rows="10" cols="40">$message_form_field</textarea></td>
</tr>
<tr>
<td><b>$msg{156}</b></td>
<td valign="top">
HTML

	# Print the UBBC panel.
	my $ubbc_panel = print_ubbc_panel();
	print $ubbc_panel;

print <<"HTML";
</td>
</tr>
$notification
<tr>
<td align="center" colspan="2"><input type="hidden" name="op" value="post2">
<input type="hidden" name="board" value="$board">
<input type="hidden" name="post" value="$thread">
<input type=submit value="$btn{8}">
<input type="reset" value="$btn{9}"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
HTML

	# Print message history.
	if (@messages) 
	{ 
		print <<"HTML";
<br>
<b>$msg{141}</b><br>
<table class="bg5" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
HTML
		foreach my $i (@messages) 
		{
			($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $i);

			# UBBC formatting.	
			$message = do_ubbc($message);

			print <<"HTML";
<tr class="tbl_header">
<td>$msg{47} $nick ($date)</td>
</tr>
<tr class="tbl_row_light">
<td>$message</td>
</tr>
HTML
		}

		print <<"HTML";
</table>
</td>
</tr>
</table>
HTML
 	}

	print_html($user_data{theme}, $nav{36}, 1);
}

# ---------------------------------------------------------------------
# Add a post.
# ---------------------------------------------------------------------
sub post2 
{
	if ($user_data{uid} eq $usr{anonuser} && $cfg{enable_guest_posting} == 0) { user_error($err{11}, $user_data{theme}); }

	# Get all categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. $!", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	# Check if user has permission to access the forum.
	foreach my $curcat (@categories) 
	{
		sysopen(FH, "$cfg{boardsdir}/$curcat.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$curcat.cat. $!", $user_data{theme});
		chomp(my @cat_info = <FH>);
		close(FH);

		foreach my $curboard (@cat_info) 
		{
			if ($curboard ne $cat_info[0]) 
			{
				if ($cat_info[1] && $curboard eq $board && $user_data{sec_level} ne $usr{admin} && $user_data{sec_level} ne $cat_info[1]) { user_error($err{11}, $user_data{theme}); }
			}
		}
	}

	# Check input.
	user_error($err{14}, $user_data{theme}) unless($post_subject);
	user_error($err{15}, $user_data{theme}) unless($post_message);

	# Format input.
	$post_subject = html_escape($post_subject);
	$post_message = html_escape($post_message);

	if (length($post_subject) > 50) { $post_subject = substr($post_subject, 0, 50); }

	# Get ID for new post.
	my $post_num = '';
	if ($post eq '') 
	{
		opendir(DIR, "$cfg{messagedir}");
		my @files = readdir(DIR);
		closedir(DIR);

		@files = grep(/\.txt/, @files);
		foreach (@files) { $_ =~s/\.txt//; }
		@files = reverse(sort { $a <=> $b } @files);

		$post_num = $files[0] || 0;
		if ($post_num) { $post_num =~ s/\.txt//; }
		$post_num++;
	}

	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	# Get date.
	my $date = get_date();

	# Data integrity check.
	if ($board =~ /^([\w.]+)$/) { $board = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update board data.
	sysopen (FH, "$cfg{boardsdir}/$board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	# Add a new post to board index.
	if ($post eq '') 
	{
		print FH "$post_num|$post_subject|$user_data{nick}|$user_data{uid}|$user_data{email}|$date|0|0|$user_data{nick}|$post_icon\|0\n";
		for (my $i = 0; $i < @messages; $i++) { print FH "$messages[$i]\n"; }
	}

	# Add a reply to board index.
	else 
	{
		for (my $i = 0; $i < @messages; $i++) 
		{
			my ($num, $subject, $nick, $username, $email, $post_date, $replies, $views, $last_poster, $icon, $state) = split(/\|/, $messages[$i]);

			$replies++;

			if ($num == $post) { print FH "$num|$subject|$nick|$username|$email|$date|$replies|$views|$user_data{nick}|$icon|$state\n"; }
			else { print FH "$messages[$i]\n"; }
		}
	}

	close(FH);

	# Add reply.
	if (-e("$cfg{messagedir}/$post.txt")) 
	{ 
		# Data integrity check.
		if ($post =~ /^([\w.]+)$/) { $post = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		sysopen(FH, "$cfg{messagedir}/$post.txt", O_WRONLY | O_APPEND) or user_error("$err{16} $cfg{messagedir}/$post.txt. ($!)", $user_data{theme}); 
	}

	# Add new post.
	else 
	{ 
		# Data integrity check.
		if ($post_num =~ /^([\w.]+)$/) { $post_num = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		sysopen(FH, "$cfg{messagedir}/$post_num.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{messagedir}/$post_num.txt. ($!)", $user_data{theme}); 
	}

	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$post_subject|$user_data{nick}|$user_data{email}|$date|$user_data{uid}|$post_icon|$ENV{REMOTE_ADDR}|$post_message\n";

	close(FH);

	# Get message ID of newly added post.
	my @thread;
	if (-e("$cfg{messagedir}/$post.txt"))
	{
		sysopen(FH, "$cfg{messagedir}/$post.txt", O_RDONLY);
		chomp(@thread = <FH>);
		close(FH);
	}

	my $count = @thread - 1;

	# Notify users, who are watching this thread.	
	if (-e "$cfg{messagedir}/$post.mail") { notify_users($post, "$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$thread;start=$start#$count"); }

	# Log action.
	if ($post) { $thread = $post; }
	if ($post_num) { $thread = $post_num; }

	# Increment user's post count.
	if ($user_data{uid} ne $usr{anonuser}) 
	{
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
		chomp(my @user_profile= <FH>);
		close(FH);

		$user_profile[6]++;

		# Data integrity check.
		if ($user_data{uid} =~ /^([\w.]+)$/) { $user_data{uid} = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_WRONLY | O_TRUNC) or user_error($err{10}, $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		for (my $i = 0; $i < @user_profile; $i++) { print FH "$user_profile[$i]\n"; }

		close(FH);
	}

	if ($post) { print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_thread;board=' . $board . ';thread=' . $thread . ';start=' . $start . '#' . $count); }
	else { print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_thread;board=' . $board . ';thread=' . $thread); }
}

# ---------------------------------------------------------------------
# Print formular to edit a post.
# ---------------------------------------------------------------------
sub modify 
{
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get all categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. $!", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	# Check if user has permission to access the forum.
	foreach my $curcat (@categories) 
	{
		sysopen(FH, "$cfg{boardsdir}/$curcat.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$curcat.cat. $!", $user_data{theme});
		chomp(my @cat_info = <FH>);
		close(FH);

		foreach my $curboard (@cat_info) 
		{
			if ($curboard ne $cat_info[0]) 
			{
				if ($cat_info[1] && $curboard eq $board && $user_data{sec_level} ne $usr{admin} && $user_data{sec_level} ne $cat_info[1]) { user_error($err{11}, $user_data{theme}); }
			}
		}
	}

	my ($num, $subject, $nick, $email, $date, $username, $icon, $ip, $message, $replies, $views, $last_poster, $state);

	# Get board threads.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Get board info.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	# Get thread.
	sysopen(FH, "$cfg{messagedir}/$thread.txt", O_RDONLY) or user_error("$err{1} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	# Get moderator name.
	my $board_moderator = $board_info[2];

	# Check if thread is locked.
	for (my $i = 0; $i < @threads; $i++) 
	{
		($num, $subject, $nick, $username, $email, $date, $replies, $views, $last_poster, $icon, $state) = split(/\|/, $threads[$i]);

		if ($thread eq $num && $state == 1) 
		{
			$i = @threads;
			user_error($err{24}, $user_data{theme});
		}
	}

	# Get message to be modified.
	($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[$post]);
	$message = html_to_text($message);

	# Check if user has permissions to edit this post.
	if ($user_data{uid} ne $username && $board_moderator ne $username && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	print_header();
	print_html($user_data{theme}, "$nav{3} >>> $nav{35}");

	print <<"HTML";
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
<td><form action="$cfg{pageurl}/forum.$cfg{ext}" method="post" name="creator">
<table border="0">
<tr>
<td><b>$msg{13}</b></td>
<td>$nick</td>
</tr>
<tr>
<td><b>$msg{7}</b></td>
<td>$email</td>
</tr>
<tr>
<td><b>$msg{37}</b></td>
<td><input type="text" name="subject" value="$subject" size="40" maxlength="50"></font></td>
</tr>
<tr>
<td><b>$msg{116}</b></td>
<td>
HTML

	# Print the UBBC image selector.
	my $ubbc_image_selector = print_ubbc_image_selector($icon);
	print $ubbc_image_selector;

print <<"HTML";
<textarea name="message" rows="10" cols="40">$message</textarea></td>
</tr>
<tr>
<td><b>$msg{156}</b></td>
<td valign="top">
HTML

	# Print the UBBC panel.
	my $ubbc_panel = print_ubbc_panel();
	print $ubbc_panel;

print <<"HTML";
</td>
</tr>
<tr>
<td align=center colspan="2"><input type="hidden" name="op" value="modify2">
<input type="hidden" name="board" value="$board">
<input type="hidden" name="thread" value="$thread">
<input type="hidden" name="post" value="$post">
<input type="submit" name="moda" value="$btn{15}">
<input type="submit" name="moda" value="$btn{16}"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "$nav{3} >>> $nav{35}", 1);
}

# ---------------------------------------------------------------------
# Modify a post.
# ---------------------------------------------------------------------
sub modify2 
{
	# Get board info.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Get thread.
	sysopen(FH, "$cfg{messagedir}/$thread.txt", O_RDONLY) or user_error("$err{1} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	# Get moderator name.
	my $board_moderator = $board_info[2];

	# Check if post has replies.
	if ($post == 0 && ($#messages + 1) > 1 && ($moda eq $btn{16} || $del == 1)) { user_error($err{25}, $user_data{theme}); }

	# Get message to be modified
	my ($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[$post]);

	# Check if user has permission to edit message.
	if ($post eq $messages[$post])
	{
		if ($user_data{uid} ne $username || $user_data{sec_level} ne $usr{admin} || $user_data{uid} ne $board_moderator || $user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }
	}

	# Check if user has permission to delete message.
	if ($del == 1)
	{
		if ($user_data{uid} ne $board_moderator && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }
	}

	# Data integrity check.
	if ($thread =~ /^([\w.]+)$/) { $thread = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update message.
	sysopen(FH, "$cfg{messagedir}/$thread.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @messages; $i++) 
	{
		($subject, $nick, $email, $date, $username, $icon, $ip, $message) = split(/\|/, $messages[$i]);

		if ($post == $i) 
		{
			# Modify message.
			if ($moda eq $btn{15})
			{
				# Check input.
				user_error($err{14}, $user_data{theme}) unless($post_subject);
				user_error($err{15}, $user_data{theme}) unless($post_message);

				# Format input.
				$post_subject = html_escape($post_subject);
				$post_message = html_escape($post_message);

				if ($post == 0) 
				{
					# Data integrity check.
					if ($board =~ /^([\w.]+)$/) { $board = $1; } 
					else { user_error($err{6}, $user_data{theme}); }

					# Update board index.
					sysopen(FH2, "$cfg{boardsdir}/$board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
					flock(FH2, LOCK_EX) if $cfg{use_flock};

					for (my $j = 0; $j < @threads; $j++) 
					{
						my ($num, $subject_thread, $nick_thread, $username_thread, $email_thread, $date_thread, $replies_thread, $views_thread, $last_poster_thread, $icon_thread, $state_thread) = split(/\|/, $threads[$j]);

						if ($num == $thread) { print FH2 "$num|$post_subject|$nick_thread|$username_thread|$email_thread|$date_thread|$replies_thread|$views_thread|$last_poster_thread|$post_icon|$state_thread\n"; }
						else { print FH2 "$threads[$j]\n"; }
					}

					close(FH2);
				}

				# Update message.
				print FH "$post_subject|$nick|$email|$date|$username|$post_icon|$ip|$post_message\n";
			}

			# Delete message.
			if ($moda eq $btn{16} || $del == 1) 
			{
				# Get data of previous post.
				my ($new_nick_thread, $new_date_thread);
				if ($post == $#messages) { (undef, undef, undef, $new_date_thread, $new_nick_thread, undef, undef, undef) = split(/\|/, $messages[$#messages - 1]); }

				# Data integrity check.
				if ($board =~ /^([\w.]+)$/) { $board = $1; } 
				else { user_error($err{6}, $user_data{theme}); }

				# Update board index.
				sysopen(FH2, "$cfg{boardsdir}/$board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
				flock(FH2, LOCK_EX) if $cfg{use_flock};

				for (my $j = 0; $j < @threads; $j++) 
				{
					my ($num, $subject_thread, $nick_thread, $username_thread, $email_thread, $date_thread, $replies_thread, $views_thread, $last_poster_thread, $icon_thread, $state_thread) = split(/\|/, $threads[$j]);

					# Decrement reply counter.
					$replies_thread--;

					if ($num == $thread) { print FH2 "$num|$subject_thread|$nick_thread|$username_thread|$email_thread|$new_date_thread|$replies_thread|$views_thread|$new_nick_thread|$icon_thread|$state_thread\n"; }
					else { print FH2 "$threads[$j]\n"; }
				}

				close(FH2);

				# Update user's post count.
				if ($username ne $usr{anonuser}) 
				{
					sysopen(FH2, "$cfg{memberdir}/$username.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
					chomp(my @user_profile= <FH2>);
					close(FH2);

					$user_profile[6]--;

					# Data integrity check.
					if ($username =~ /^([\w.]+)$/) { $username = $1; } 
					else { user_error($err{6}, $user_data{theme}); }

					sysopen(FH2, "$cfg{memberdir}/$username.dat", O_WRONLY | O_TRUNC) or user_error($err{10}, $user_data{theme});
					flock(FH2, LOCK_EX) if $cfg{use_flock};

					for (my $i = 0; $i < @user_profile; $i++) { print FH2 "$user_profile[$i]\n"; }

					close(FH2);
				}
			}
		}
		else { print FH "$messages[$i]\n"; }
	}

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_thread;board=' . $board . ';thread=' . $thread . ';start=' . $start . '#' . $post);
}

# ---------------------------------------------------------------------
# Print the forum selector.
# ---------------------------------------------------------------------
sub forum_selector 
{
	opendir(DIR, "$cfg{boardsdir}"); 
	my @files = readdir(DIR);
	closedir(DIR);

	my @cats = grep(/\.dat/, @files);

	# Print list of available forums.
	my $select = '';
	foreach my $i (@cats) 
	{
		my ($name, $trash) = split(/\./, $i);

		sysopen(FH, "$cfg{boardsdir}/$i", O_RDONLY) || next;
		chomp(my @cat = <FH>);
		close(FH);

		$select = qq($select<option value="$name">$cat[0]</option>);
	}

	print <<"HTML";
<form action="$cfg{pageurl}/forum.$cfg{ext}" method="post">$msg{104} 
<select name="board">
$select
</select>
<input type="hidden" name="op" value="view_board">
<input type="submit" value="$btn{14}">
</form>
HTML
}

# ---------------------------------------------------------------------
# Print Formular to subscribe/unsubscribe to a thread notification.
# ---------------------------------------------------------------------
sub notify 
{
	# Check if user has permissions to access this area.
	if ($user_data{sec_level} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get list of user's watching this topic.
	my (@mails, $subscribed);
	if (-e "$cfg{messagedir}/$thread.mail")
	{
		sysopen(FH, "$cfg{messagedir}/$thread.mail", O_RDONLY);
		chomp(@mails = <FH>);
		close(FH);

		# Check if user has subscribed to this thread.
		foreach my $i (@mails) 
		{
			if ($user_data{email} eq $i) { $subscribed = 1; }
			else { $subscribed = 0; }
		}
	}

	# Get board name .
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_name = $board_info[0];

	print_header();
	print_html($user_data{theme}, "$nav{3} >>> $board_name");

	# Print user actions.
	if ($subscribed) { print qq($msg{155}<br>\n<b><a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$thread">$nav{47}</a> - <a href="$cfg{pageurl}/forum.$cfg{ext}?op=notify2;board=$board;thread=$thread;state=0">$nav{48}</a></b>); }
	else { print qq($msg{155}<br>\n<b><a href="$cfg{pageurl}/forum.$cfg{ext}?op=notify2;board=$board;thread=$thread;state=1">$nav{47}</a> - <a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$thread">$nav{48}</a></b>); }

	print_html($user_data{theme}, "$nav{3} >>> $board_name", 1);
}

# ---------------------------------------------------------------------
# Update thread notification.
# ---------------------------------------------------------------------
sub notify2 
{
	# Check if user has permissions to access this area.
	if ($user_data{sec_level} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get list of user's watching this topic.
	my @mails;
	if (-e "$cfg{messagedir}/$thread.mail")
	{
		sysopen(FH, "$cfg{messagedir}/$thread.mail", O_RDONLY);
		chomp(@mails = <FH>);
		close(FH);
	};

	# Data integrity check.
	if ($thread =~ /^([\w.]+)$/) { $thread = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update subscriber list.
	sysopen(FH, "$cfg{messagedir}/$thread.mail", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{messagedir}/$thread.mail. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	if ($state) { print FH "$user_data{email}\n"; }
	foreach my $i (@mails) 
	{
		if($user_data{email} ne $i) { print FH "$i\n"; }
	}
	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_thread;board=' . $board . ';thread=' . $thread);
}

# ---------------------------------------------------------------------
# Send notification email to subscribed users.
# ---------------------------------------------------------------------
sub notify_users 
{
	my ($watch_thread, $link) = @_;

	# Get list of users watching this topic.
	if (-e "$cfg{messagedir}/$watch_thread.mail")
	{
		sysopen(FH, "$cfg{messagedir}/$watch_thread.mail", O_RDONLY);
		chomp(my @mails = <FH>);
		close(FH);

		my $subject = $cfg{pagename} . " " . $msg{142};
		my $message = $inf{16} . " " . $link;

		# Send the email to recipients.
		foreach (@mails) { send_email($cfg{webmaster_email}, $_, $subject, $message); }
	}
}

# ---------------------------------------------------------------------
# Print forular to move a thread.
# ---------------------------------------------------------------------
sub move_thread 
{
	# Get all categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. ($!)", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_moderator = $board_info[2];

	# Check if user is authorized to access this area.
	if($user_data{uid} ne $board_moderator && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	my $board_list;
	foreach my $i (@cats) 
	{
		sysopen(FH, "$cfg{boardsdir}/$i.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$i.cat. ($!)", $user_data{theme});
		chomp(my @cat_info = <FH>);
		close(FH);

		foreach my $j (@cat_info) 
		{
			if ($j ne $cat_info[0] && $j ne $cat_info[1]) 
			{ 
				# Get board name.
				sysopen(FH, "$cfg{boardsdir}/$j.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$j.dat. ($!)", $user_data{theme});
				chomp(@board_info = <FH>);
				close(FH);

				my $board_name = $board_info[0];

				$board_list .= "<option value=\"$j\">$board_name</option>\n"; 
			}
		}
	}

	print_header();
	print_html($user_data{theme}, $nav{46});

	print <<"HTML";
<form action="$cfg{pageurl}/forum.$cfg{ext}" method="post">
<b>$msg{151}</b> <select name="to_board">
$board_list</select>
<input type="hidden" name="op" value="move_thread2">
<input type="hidden" name="thread" value="$thread">
<input type="hidden" name="from_board" value="$board">
<input type="submit" value="Move">
</form>
HTML

	print_html($user_data{theme}, $nav{46}, 1);
}

# ---------------------------------------------------------------------
# Move a thread.
# ---------------------------------------------------------------------
sub move_thread2 
{
	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$from_board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$from_board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_moderator = $board_info[2];

	# Check if user is authorized to access this area.
	if($user_data{uid} ne $board_moderator && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	if ($from_board eq $to_board) { user_error($err{6}, $user_data{theme}); }

	# Get old board threads.
	sysopen(FH, "$cfg{boardsdir}/$from_board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$from_board.txt. ($!)", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Data integrity check.
	if ($from_board =~ /^([\w.]+)$/) { $from_board = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update old board index.
	my $move_thread;
	sysopen(FH, "$cfg{boardsdir}/$from_board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$from_board.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @threads; $i++) 
	{
		my ($num, $subject, $nick, $username, $email, $post_date, $replies, $views, $last_poster, $icon, $state) = split(/\|/,$threads[$i]);

		if ($num ne $thread) { print FH "$threads[$i]\n"; }
		else { $move_thread = $threads[$i]; }
	}

	close(FH);

	# Get new board threads.	
	sysopen(FH, "$cfg{boardsdir}/$to_board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$to_board.txt. ($!)", $user_data{theme});
	chomp(@threads = <FH>);
	close(FH);

	# Data integrity check.
	if ($to_board =~ /^([\w.]+)$/) { $to_board = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update new board index.
	sysopen(FH, "$cfg{boardsdir}/$to_board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$to_board.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$move_thread\n";
	foreach my $i (@threads) { print FH "$i\n"; }

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_thread;board=' . $to_board . ';thread=' . $thread);	
}

# ---------------------------------------------------------------------
# Print forular to remove a thread.
# ---------------------------------------------------------------------
sub remove_thread 
{
	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_moderator = $board_info[2];

	# Check if user is authorized to access this area.
	if($user_data{uid} ne $board_moderator && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	print_header();
	print_html($user_data{theme}, $nav{54});

	print <<"HTML";
$msg{152}<br>
<a href="$cfg{pageurl}/forum.$cfg{ext}?op=remove_thread2;board=$board;thread=$thread">$nav{47}</a> - <a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$thread">$nav{48}</a>
HTML

	print_html($user_data{theme}, $nav{54}, 1);
}

# ---------------------------------------------------------------------
# Remove a thread.
# ---------------------------------------------------------------------
sub remove_thread2 
{
	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_moderator = $board_info[2];

	# Check if user is authorized to access this area.
	if($user_data{uid} ne $board_moderator && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	# Get thread.
	sysopen(FH, "$cfg{messagedir}/$thread.txt", O_RDONLY) or user_error("$err{1} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	# Check if thread is empty.
	if (@messages != 0) { user_error($err{25}, $user_data{theme}); }

	# Get board threads.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Data integrity check.
	if ($board =~ /^([\w.]+)$/) { $board = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update board index.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @threads; $i++) 
	{
		my ($num, $subject, $nick, $username, $email, $post_date, $replies, $views, $last_poster, $icon, $state) = split(/\|/,$threads[$i]);

		if ($num ne $thread) { print FH "$threads[$i]\n"; }
	}

	close(FH);

	# Data integrity check.
	if ($thread =~ /^([\w.]+)$/) { $thread = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Delete thread messages and notification database.
	unlink("$cfg{messagedir}/$thread.txt");
	unlink("$cfg{messagedir}/$thread.mail");

	print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_board;board=' . $board);	
}

# ---------------------------------------------------------------------
# Lock/unlock a thread.
# ---------------------------------------------------------------------
sub lock_thread 
{
	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$board.dat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.dat. ($!)", $user_data{theme});
	chomp(my @board_info = <FH>);
	close(FH);

	my $board_moderator = $board_info[2];

	# Check if user is authorized to access this area.
	if($user_data{uid} ne $board_moderator && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	# Get board threads.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	chomp(my @threads = <FH>);
	close(FH);

	# Data integrity check.
	if ($board =~ /^([\w.]+)$/) { $board = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update board index.
	sysopen(FH, "$cfg{boardsdir}/$board.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$board.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @threads; $i++) 
	{
		my ($num, $subject, $nick, $username, $email, $post_date, $replies, $views, $last_poster, $icon, $state) = split(/\|/,$threads[$i]);

		if ($num eq $thread) 
		{
			# Unlock thread if is locked.
			if (!$state) { $state = 1; }
			else { $state = 0; }

			print FH "$num|$subject|$nick|$username|$email|$post_date|$replies|$views|$last_poster|$icon|$state\n";
		}
		else { print FH "$threads[$i]\n"; }
	}

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/forum.' . $cfg{ext} . '?op=view_thread;board=' . $board . ';thread=' . $thread);	
}

# ---------------------------------------------------------------------
# Display a printerfriendly version of a thread.
# ---------------------------------------------------------------------
sub print_thread 
{
	my ($title, $subject, $nick, $date, $message);

	if ($thread) 
	{
		# Get thread.
		sysopen(FH, "$cfg{messagedir}/$thread.txt", O_RDONLY) or user_error("$err{1} $cfg{messagedir}/$thread.txt. ($!)", $user_data{theme});
		chomp(my @messages = <FH>);
		close(FH);

		# Get title of thread.
		($title, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $messages[0]);

		print_header();
		print <<"HTML";
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<meta name="Generator" content="YaWPS $VERSION">
<title>$title</title>
</head>

<body bgcolor="#ffffff" text="#000000">
<h1 align="center">$title</h1>
HTML

		# Print messages.
		foreach my $i (@messages) 
		{
			($subject, $nick, undef, $date, undef, undef, undef, $message) = split(/\|/, $i);

			# Make UBBC.
			$message = do_ubbc($message);

			print <<"HTML";
<hr size=2 width="100%">
<h3>$subject</h3>
<b>$msg{47} $nick ($date)</b><br>
<p>$message</p>
HTML
		}

		print "</body>\n\n</html>\n";
	}
}
