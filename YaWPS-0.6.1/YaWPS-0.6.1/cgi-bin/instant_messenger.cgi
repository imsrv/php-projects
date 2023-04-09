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
# $Id: instant_messenger.cgi,v 1.8 2002/12/15 11:34:22 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $quote $id $to $subject $message
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$quote = $query->param('quote');
$id = $query->param('id') || 0;
$to = $query->param('to') || '';
$subject = $query->param('subject');
$message = $query->param('message');

# Get user profile.
%user_data = authenticate();

# Define possible user actions.
%user_action = (
	send_im => \&send_im,
	send_im2 => \&send_im2,
	delete_im => \&delete_im
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { display_im_index(); }

# ---------------------------------------------------------------------
# Display all available instant messages.
# ---------------------------------------------------------------------
sub display_im_index
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get messages in IM inbox.
	my @messages;
	if (-e("$cfg{memberdir}/$user_data{uid}.msg"))
	{
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_RDONLY);
		chomp(@messages = <FH>);
		close(FH);
	}

	# Get member ranks.
	my @member_ranks;
	if (-e("$cfg{memberdir}/membergroups.dat"))
	{
		sysopen(FH, "$cfg{memberdir}/membergroups.dat", O_RDONLY);
		chomp(my @member_ranks = <FH>);
		close(FH);
	};
	
	# Get censored words.
	my @censored;
	if (-e("$cfg{datadir}/censor.txt"))
	{
		sysopen(FH, "$cfg{datadir}/censor.txt", O_RDONLY);
		chomp(@censored = <FH>);
		close(FH);
	};

	print_header();
	print_html($user_data{theme}, $nav{28});

	# If there are no messages in the inbox.
	if (@messages == 0) { print $msg{50}; }
	else
	{
		print <<"HTML";
<table class="bg5" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>$msg{49}</b></td>
<td><b>$msg{37}</b></td>
</tr>
HTML

		my $row_color = " class=\"tbl_row_dark\"";
		for (my $i = 0; $i < @messages; $i++) 
		{
			my ($message_info, $star, $view, $url, $icq, $signature);
			my ($username, $subject, $date, $message, $id, $unread) = split(/\|/, $messages[$i]);
                
			if (!$subject) { $subject = "---"; }

			# Alternate the row colors.
			if ($row_color eq " class=\"tbl_row_dark\"") { $row_color = " class=\"tbl_row_light\""; }
			else { $row_color = " class=\"tbl_row_dark\""; }

			my @user_profile;
			if (-e("$cfg{memberdir}/$username.dat"))
			{
				sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY);
				chomp(@user_profile = <FH>);
				close(FH);
			}
		
			my $member_info = '';
			if ($user_profile[7]) { $member_info = $user_profile[7]; }

			# Make UBBC.
			$message = do_ubbc($message);

			# Check for censored words.
			foreach my $word (@censored) 
			{
				my ($bad_word, $censored) = split(/\=/, $word);
				$message =~ s/$bad_word/$censored/g;
				$subject =~ s/$bad_word/$censored/g;
			}

			# Print the message.
			print <<"HTML";
<tr$row_color>
<td width="140" valign="top" rowspan="2"><b><a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$username">$user_profile[1]</a></b><br>
$member_info</td>
<td valign="top">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
<tr>
<td width="100%">&nbsp;<b>$subject</b></td>
<td align="right" nowrap><b>$msg{54}</b> $date</td>
</tr>
</table>
<hr size="1" noshade>
$message</td>
</tr>
<tr$row_color>
<td>
<table border="0" width="100%" cellpadding="0" cellspacing="1">
<tr>
<td colspan="2" align="right"><a href="$cfg{pageurl}/instant_messenger.$cfg{ext}?op=send_im;id=$id;quote=1;to=$username">$msg{56}</a>&nbsp;&nbsp;<a href="$cfg{pageurl}/instant_messenger.$cfg{ext}?op=delete_im;id=$id">$msg{58}</a></td>
</tr>
</table>
</td>
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

	print <<"HTML";
<br>
<a href="$cfg{pageurl}/instant_messenger.$cfg{ext}?op=send_im">$nav{29}</a>
HTML

	print_html($user_data{theme}, $nav{28}, 1);
}

# ---------------------------------------------------------------------
# Display forular to send IMs.
# ---------------------------------------------------------------------
sub send_im 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

        my $time_stamp = time; 

	# Get messages in IM inbox.
	my @messages;
	if (-e("$cfg{memberdir}/$user_data{uid}.msg"))
	{
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_RDONLY);
		chomp(@messages = <FH>);
		close(FH);
	}

	# Format the current IM.
	my ($subject, $message) = '';
	for (my $i = 0; $i < @messages; $i++) 
	{
		my ($from, $temp_subject, $date, $temp_message, $mid, $unread) = split(/\|/, $messages[$i]);

		if ($id == $mid && $quote == 1) 
		{ 
			$subject = $temp_subject;

			$temp_message = html_to_text($temp_message);
			$temp_message =~ s/\[quote\](\S+?)\[\/quote\]//isg;
			$temp_message =~ s/\[(\S+?)\]//isg;

			$message = "\n\n[quote\]" . $temp_message . "\[/quote\]";
		}
		else
		{
			$subject = '';
			$message = '';
		}
	}

	print_header();
	print_html($user_data{theme}, $nav{29});

	print <<"HTML";
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
<td><form action="$cfg{pageurl}/instant_messenger.$cfg{ext}" method="post" name="creator">
<table border="0">
<tr>
<td><b>$msg{59}</b></td>
<td><select name="to">
HTML

	# Print list of available users.
	sysopen(FH, "$cfg{memberdir}/memberlist.dat", O_RDONLY) or user_error("$err{1} $cfg{memberdir}/memberlist.dat. ($!)", $user_data{theme});
	chomp(my @members = <FH>);
	close(FH);

	my $selected = '';
	for (my $i = 0; $i < @members; $i++) 
	{
		my @user_profile;
		if (-e("$cfg{memberdir}/$members[$i].dat"))
		{
			sysopen(FH, "$cfg{memberdir}/$members[$i].dat", O_RDONLY);
			chomp(@user_profile = <FH>);
			close(FH);
		}

		if ($to eq $members[$i]) { $selected = " selected"; }

		print qq(<option value="$members[$i]"$selected>$user_profile[1]</option>\n);
	}

	print <<"HTML";
</select></td>
</tr>
<tr>
<td><b>$msg{37}</b></td>
<td><input type="text" name="subject" value="$subject" size="40" maxlength="50"></td>
</tr>
<tr>
<td valign="top"><b>$msg{38}</b></td>
<td><script language="javascript" type="text/javascript">
<!--
function addCode(anystr) { 
document.creator.message.value+=anystr;
} 
function showColor(color) { 
document.creator.message.value+="[color="+color+"][/color]";
}
// -->
</script>
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
<td colspan="2"><input type="hidden" name="op" value="send_im2">
<input type="hidden" name="id" value="$time_stamp">
<input type="submit" value="$btn{8}">
<input type="reset" value="$btn{9}"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, $nav{29}, 1);
}

# ---------------------------------------------------------------------
# Send an IM.
# ---------------------------------------------------------------------
sub send_im2 
{
	user_error($err{10}, $user_data{theme}) unless (-e("$cfg{memberdir}/$to.dat"));
	user_error($err{14}, $user_data{theme}) unless($subject);
	user_error($err{15}, $user_data{theme}) unless($message);

	# Format the input.
	$subject = html_escape($subject);
	$message = html_escape($message);

	# Get the current date.
	my $date = get_date();

	# Get existing messages for recipient user.
	my @messages;
	if (-e("$cfg{memberdir}/$to.msg"))
	{
		sysopen(FH, "$cfg{memberdir}/$to.msg", O_RDONLY);
		@messages = <FH>;
		close (FH);
	}

	# Data integrity check.
	if ($to =~ /^([\w.]+)$/) { $to = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Save the new IM.
	sysopen(FH, "$cfg{memberdir}/$to.msg", O_WRONLY | O_TRUNC | O_CREAT);
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$user_data{uid}|$subject|$date|$message|$id|1\n";
	foreach my $i (@messages) { print FH $i; }

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/instant_messenger.' . $cfg{ext});
}

# ---------------------------------------------------------------------
# Delete an IM.
# ---------------------------------------------------------------------
sub delete_im 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get messages in IM inbox.
	my @messages;
	if (-e("$cfg{memberdir}/$user_data{uid}.msg"))
	{
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_RDONLY);
		@messages = <FH>;
		close(FH);
	};

	# Data integrity check.
	if ($user_data{uid} =~ /^([\w.]+)$/) { $user_data{uid} = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update IM inbox.
	sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_WRONLY | O_TRUNC);
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @messages; $i++) 
	{
		my ($from, $subject, $date, $message, $mid, $unread) = split(/\|/, $messages[$i]);

		if ($id != $mid) { print FH $messages[$i]; }
	}

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/instant_messenger.' . $cfg{ext});
}
