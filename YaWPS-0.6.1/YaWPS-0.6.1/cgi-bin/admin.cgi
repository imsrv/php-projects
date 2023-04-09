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
# $Id: admin.cgi,v 1.14 2003/01/18 13:16:01 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query
	$op $start 
	$title $message
	$cats $id $name $access
	$descr $mod $moda
	$boards $first $second
	$censor 
	$question $answer
	$poster_nick $poster_name $poster_email
	$view_num $new_cat $old_cat
	$url
	$pos $status
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$start = $query->param('start') || 0;

$title = $query->param('title');
$message = $query->param('message');

$cats = $query->param('cats') || '';
$id = $query->param('id');
$name = $query->param('name');
$access = $query->param('access');

$descr = $query->param('descr');
$mod = $query->param('mod') || '';
$moda = $query->param('moda');

$boards = $query->param('boards');
$first = $query->param('first');
$second = $query->param('second');

$censor = $query->param('censor');

$question = $query->param('question');
$answer = $query->param('answer');

$poster_nick = $query->param('poster_nick');
$poster_name = $query->param('poster_name');
$poster_email = $query->param('poster_email');

$view_num = $query->param('view_num');
$new_cat = $query->param('new_cat');
$old_cat = $query->param('old_cat');

$url = $query->param('url');

$pos = $query->param('pos');
$status = $query->param('status') || 0;

# Get user profile.
%user_data = authenticate();

# Check if user has admin permissions.
if ($user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

# Define possible user actions.
%user_action = (
	site_config => \&site_config,
	welcome_msg => \&welcome_msg,
	welcome_msg2 => \&welcome_msg2,
	ban => \&ban,
	ban2 => \&ban2,
	set_censor => \&set_censor,
	set_censor2 => \&set_censor2,
	meta_tags => \&meta_tags,
	meta_tags2 => \&meta_tags2,
	manage_cats => \&manage_cats,
	reorder_cats => \&reorder_cats,
	remove_cat => \&remove_cat,
	create_cat => \&create_cat,
	manage_boards => \&manage_boards,
	reorder_boards => \&reorder_boards,
	reorder_boards2 => \&reorder_boards2,
	modify_board => \&modify_board,
	create_board => \&create_board,
	edit_polls => \&edit_polls,
	create_poll => \&create_poll,
	edit_poll => \&edit_poll,
	edit_poll2 => \&edit_poll2,
	edit_poll3 => \&edit_poll3,
	edit_poll4 => \&edit_poll4,
	reset_poll => \&reset_poll,
	delete_poll => \&delete_poll,
	verify_news => \&verify_news,
	verify_news2 => \&verify_news2,
	modify_news => \&modify_news,
	modify_news2 => \&modify_news2,
	modify_news3 => \&modify_news3,
	move_topic => \&move_topic,
	edit_topic_categories => \&edit_topic_categories,
	edit_topic_categories2 => \&edit_topic_categories2,
	edit_topic_categories3 => \&edit_topic_categories3,
	edit_link_cats => \&edit_link_cats,
	edit_link_cats2 => \&edit_link_cats2,
	edit_link_cats3 => \&edit_link_cats3,
	edit_links => \&edit_links,
	edit_links2 => \&edit_links2,
	edit_links3 => \&edit_links3,
	move_link => \&move_link,
	user_ranks => \&user_ranks,
	user_ranks2 => \&user_ranks2,
	view_online => \&view_online,
	edit_pages => \&edit_pages,
	edit_pages2 => \&edit_pages2,
	edit_blocks => \&edit_blocks,
	edit_blocks2 => \&edit_blocks2,
	edit_quotes => \&edit_quotes,
	add_quote => \&add_quote,
	delete_quote => \&delete_quote,
	edit_quote => \&edit_quote,
	edit_quote2 => \&edit_quote2
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { admin_index(); }

# ---------------------------------------------------------------------
# Display the admin index page.
# ---------------------------------------------------------------------
sub admin_index
{
	print_header();
	print_html($user_data{theme}, $nav{42});

	print <<"HTML";
<b>$nav{42}</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=site_config">View Site Configuartion</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=welcome_msg">Welcome Message</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=ban">Ban Management</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=set_censor">Set Censored Words</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=meta_tags">Define Meta Description</a><br>
<br>
<b>$nav{43}</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=manage_cats">Categories (reorder/create/remove)</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=manage_boards">Boards (reorder/create/remove)</a><br>
<br>
<b>$nav{44}</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_polls">Poll Admin (edit/create/remove)</a><br>
<br>
<b>$nav{24}</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=verify_news">New Articles (publish/remove)</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=modify_news">News/Comments (edit/move/remove)</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_topic_categories">Topic Categories (rename/create/remove)</a><br>
<br>
<b>$nav{49}</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_link_cats">Categories (edit/create/remove)</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_links">Links (edit/remove)</a><br>
<br>
<b>User Admin</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=user_ranks">Edit Userranks</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=view_online">View online Users</a><br>
<br>
<b>Content Admin</b><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_pages">Pages</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_blocks">Blocks</a><br>
<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_quotes">Quotes</a><br>
<br>
<b>Module Admin</b><br>
HTML

	# Get list of installed modules.
	opendir(DIR, "$cfg{modulesdir}");
	my @modules = readdir(DIR);
	closedir(DIR);

	foreach (sort @modules) 
	{
	        next if ($_ eq '.' || $_ eq '..');

		my ($module_name, $extension) = split (/\./, $_);
		if (!$extension) { print qq(<a href="$cfg{modulesurl}/$module_name/admin.$cfg{ext}">Configure '$module_name'</a><br>\n); }
	}

	print_html($user_data{theme}, $nav{42}, 1);
}

# ---------------------------------------------------------------------
# Show content of yawpsrc.pl.
# ---------------------------------------------------------------------
sub site_config
{
	print_header();
	print_html($user_data{theme}, "$nav{42} >>> Site Configuration");

	print "Please modify these settings in yawpsrc.pl!\n";

	print <<"HTML";
<table width="100%" class="bg5" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>Variable</b></td>
<td><b>Value</b></td>
HTML

	while (my ($key, $value) = each(%cfg))
	{
		print "<tr>\n<td class=\"bg3\"><b>" . $key . "</b></td><td class=\"bg2\">" . $value . "</td>\n</tr>\n";
	}

	print <<"HTML";
</table></td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "$nav{42} >>> Site Configuration", 1);
}

# ---------------------------------------------------------------------
# Formular to edit site welcome message.
# ---------------------------------------------------------------------
sub welcome_msg
{
	my @lines;
	if (-e("$cfg{datadir}/welcomemsg.txt"))
	{
		sysopen(FH, "$cfg{datadir}/welcomemsg.txt", O_RDONLY);
		chomp(@lines = <FH>);
		close(FH);
	}

	$lines[0] = html_to_text($lines[0]);
	$lines[1] = html_to_text($lines[1]);

	print_header();
	print_html($user_data{theme}, "$nav{42} >>> Welcome message");

	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table border="0" width="100%" cellpading="0" cellspacing="0">
<tr>
<td><b>Welcome Title:</b></td>
<td><input type="text" name="title" size="40" maxlength="50" value="$lines[0]"></td>
</tr>
<tr>
<td valign="top"><b>Welcome Text:</b></td>
<td><textarea name="message" rows="10" cols="40">$lines[1]</textarea></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="welcome_msg2">
<input type="submit" value="Save">
<input type="reset" value="Reset"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, "$nav{42} >>> Welcome message", 1);
}

# ---------------------------------------------------------------------
# Update site welcome message.
# ---------------------------------------------------------------------
sub welcome_msg2
{
	user_error($err{14}, $user_data{theme}) unless ($title);
	user_error($err{15}, $user_data{theme}) unless ($message);

	# Format input.
	$title = html_escape($title);
	$message = html_escape($message);

	# Update the message.
	sysopen(FH, "$cfg{datadir}/welcomemsg.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{datadir}/welcomemsg.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$title\n";
	print FH "$message\n";

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=welcome_msg');
}

# ---------------------------------------------------------------------
# Edit user bannings.
# ---------------------------------------------------------------------
sub ban 
{
	# Get banned users.
	my @banned;
	if (-e("$cfg{datadir}/ban.txt"))
	{
		sysopen(FH, "$cfg{datadir}/ban.txt", O_RDONLY);
		@banned = <FH>;
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, "$nav{42} >>> Ban Management");

	print <<"HTML";
<table>
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td><textarea name="name" rows="10" cols="40">@banned</textarea><br>
One entry per line (you can insert IP addresses, usernames or email adresses).</td>
</tr>
<tr>
<td><input type="submit" value="Edit">
<input type="hidden" name="op" value="ban2"></td>
</tr>
</form>
</table>
HTML

	print_html($user_data{theme}, "$nav{42} >>> Edit Userranks", 1);
}

# ---------------------------------------------------------------------
# Update banlist.
# ---------------------------------------------------------------------
sub ban2
{
	$name =~ s/\r//g;

	# Update categories.
	if ($name)
	{
		sysopen(FH, "$cfg{datadir}/ban.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{datadir}/ban.txt. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH $name;

		close(FH);
	}

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=ban');
}

# ---------------------------------------------------------------------
# Edit censor.
# ---------------------------------------------------------------------
sub set_censor 
{
	# Get censored words.
	my @censored;
	if (-e("$cfg{datadir}/censor.txt"))
	{
		sysopen(FH, "$cfg{datadir}/censor.txt", O_RDONLY);
		@censored = <FH>;
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Set Censored Words");

	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table border="0" width="100%" cellpading="0" cellspacing="0">
<tr>
<td>One word per line in the form: word=w*rd<br>
<textarea cols="20" rows="10" name="censor">
HTML

	# Print the list.
	foreach (@censored) { print $_; }

	print <<"HTML";
</textarea><br>
<input type="hidden" name="op" value="set_censor2">
<input type="submit" value="Save">
</td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, "$nav{43} >>> Set Censored Words", 1);
}

# ---------------------------------------------------------------------
# Update censor.
# ---------------------------------------------------------------------
sub set_censor2 
{
	# Update the censorlist.
	sysopen(FH, "$cfg{datadir}/censor.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{datadir}/censor.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH $censor; 

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=set_censor');
}

# ---------------------------------------------------------------------
# Print formular to edit meta tags.
# ---------------------------------------------------------------------
sub meta_tags
{
	# Get meta tags.
	my @lines;
	my ($description, $keywords, $checked) = '';
	if (-e("$cfg{datadir}/meta.txt"))
	{
		sysopen(FH, "$cfg{datadir}/meta.txt", O_RDONLY);
		chomp(@lines = <FH>);
		close(FH);

		$description = $lines[0];
		$keywords = $lines[1];
		if ($lines[2] == 1) { $checked = " checked"; }
	}
	else
	{
		$description = '';
		$keywords = '';
		$checked = '';
	}

	print_header();
	print_html($user_data{theme}, "$nav{42} >>> Meta Tags");

	print <<"HTML";
<table>
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td>Enter a short site description (100 bytes maximum):<br>
<textarea name="descr" rows="5" cols="40" maxlength="100">$description</textarea></td>
</tr>
<tr>
<td>Enter keywords for search engines (seperate them with commas):<br>
<textarea name="name" rows="5" cols="40">$keywords</textarea></td>
</tr>
<tr>
<td>Use meta tags: <input type="checkbox" name="status"$checked></td>
</tr>
<tr>
<td><input type="submit" value="Edit">
<input type="hidden" name="op" value="meta_tags2"></td>
</tr>
</form>
</table>
HTML

	print_html($user_data{theme}, "$nav{42} >>> Meta Tags", 1);
}

# ---------------------------------------------------------------------
# Update meta tags.
# ---------------------------------------------------------------------
sub meta_tags2
{
	# Check input.
	chomp($descr);
	chomp($name);
	chomp($status);

	if ($status eq "on" || $status == 1) { $status = 1; }
	else { $status = 0; }

	# Update the meta tag db.
	sysopen(FH, "$cfg{datadir}/meta.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{datadir}/meta.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$descr\n";
	print FH "$name\n";
	print FH "$status\n";

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=meta_tags');
}

# ---------------------------------------------------------------------
# Manage forum categories.
# ---------------------------------------------------------------------
sub manage_cats
{
	# Get all forum categories.
	my ($catsdropdown, $catlist);
	if (-e("$cfg{boardsdir}/cats.txt"))
	{
		sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY);
		chomp(my @categories = <FH>);
		close(FH);

		if (@categories)
		{
			foreach (@categories) 
			{
				$catsdropdown .= "<option>$_</option>\n";
				$catlist .= "$_\n";
			}
		}
		else
		{
			$catsdropdown = '';
			$catlist = '';
		}
	}
	else
	{
		$catsdropdown = '';
		$catlist = '';
	}

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Manage Cats");

	print <<"HTML";
<table border="0" width="100%" cellpading="0" cellspacing="0">
<tr>
<td valign="top">
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<b>Current categories:</b><br>
<textarea name="cats" cols="40" rows="4">$catlist</textarea><br>
<input type="hidden" name="op" value="reorder_cats">
<input type="submit" value="Change order">
</form>
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<b>Remove category:</b><br>
<select name="cats">
$catsdropdown
</select>
<input type="hidden" name="op" value="remove_cat">
<input type=submit value="Delete">
</form>
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<b>Create new category:</b><br>
ID:<br>
<input type="text" size="15" name="id"><br>
Full name:<br>
<input type="text" size="40" name="name"><br>
Access granted for:<br>
<select name="access">
<option value="">Everybody</option>
<option value="admin">$usr{admin}</option>
<option value="mod">$usr{mod}</option>
<option value="user">$usr{user}</option>
</select>
<br>
<input type="hidden" name="op" value="create_cat">
<input type="submit" value="Create">
</form>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "$nav{42} >>> Site Configuration", 1);
}

# ---------------------------------------------------------------------
# Order forum categories.
# ---------------------------------------------------------------------
sub reorder_cats
{
	$cats =~ s/\r//g;

	# Update categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/cats.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH $cats;

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=manage_cats');
}

# ---------------------------------------------------------------------
# Delete forum category.
# ---------------------------------------------------------------------
sub remove_cat
{
	# Get all forum categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. ($!)", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	my $newcatlist = '';
	foreach (@categories) 
	{
		if ($_ ne $cats) { $newcatlist = "$newcatlist$_\n"; }
	}

	# Delete board data.
	sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$cats.cat. ($!)", $user_data{theme});
	chomp(my @cat_info = <FH>);
	close(FH);

	my $cat_name = $cat_info[0];

	# Delete messages.
	foreach my $cat (@cat_info) 
	{
		if ($cat ne $cat_info[0] && $cat ne $cat_info[1]) 
		{
			# Data integrity check.
			if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
			else { user_error($cat, $user_data{theme}); }

			if ($cat ne $cat_info[0]) 
			{
				my @messages;
				if (-e("<$cfg{boardsdir}/$cat.txt"))
				{
					sysopen(FH, "$cfg{boardsdir}/$cat.txt", O_RDONLY);
					@messages = <FH>;
					close(FH);

					foreach my $i (@messages) 
					{
						my ($mid, undef) = split(/\|/, $i);

						# Data integrity check.
						if ($mid =~ /^([\w.]+)$/) { $mid = $1; } 
						else { user_error($err{6}, $user_data{theme}); }

						unlink("$cfg{messagedir}/$mid.txt");
						unlink("$cfg{messagedir}/$mid.mail");
					}
				}
			}

			unlink("$cfg{boardsdir}/$cat.txt");
			unlink("$cfg{boardsdir}/$cat.mail");
			unlink("$cfg{boardsdir}/$cat.dat");
		}
	}

	# Data integrity check.
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	unlink("$cfg{boardsdir}/$cats.cat");

	# Update categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/cats.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH $newcatlist;

	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Delete Cat");

	print "Category '$cat_name' deleted!";

	print_html($user_data{theme}, "$nav{43} >>> Delete Cat", 1);
}

# ---------------------------------------------------------------------
# Create a new forum category.
# ---------------------------------------------------------------------
sub create_cat
{
	# Get all forum categories.
	my @categories;
	if (-e("$cfg{boardsdir}/cats.txt"))
	{
		sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY);
		chomp(@categories = <FH>);
		close(FH);
	}

	# Add new category to database.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{boardsdir}/cats.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	foreach (@categories) { print FH "$_\n"; }
	print FH $id;

	close(FH);

	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Create new category.
	sysopen(FH, "$cfg{boardsdir}/$id.cat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{boardsdir}/$id.cat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$name\n$access\n";

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=manage_cats');
}

# ---------------------------------------------------------------------
# Manage forums.
# ---------------------------------------------------------------------
sub manage_boards
{
	# Get all forum categories.
	sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/cats.txt. ($!)", $user_data{theme});
	chomp(my @categories = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Manage Boards");

	print <<"HTML";
<table border="0" cellspacing="1">
<tr>
<td><b>Forum name</b></td>
<td><b>Moderator</b></td>
<td><b>Action</b></td>
</tr>
HTML

	# Cycle through the categories.
	foreach (@categories) 
	{
		my @cat_info;
		my $cat_name = '';
		if (-e("$cfg{boardsdir}/$_.cat"))
		{
			sysopen(FH, "$cfg{boardsdir}/$_.cat", O_RDONLY);
			chomp(@cat_info = <FH>);
			close(FH);

			$cat_name = $cat_info[0];
		}

		print <<"HTML";
<tr>
<td colspan="3"><a href="$cfg{pageurl}/admin.$cfg{ext}?op=reorder_boards;cats=$_"><b>$cat_name</b></a></td>
</tr>
HTML
		foreach my $i (@cat_info) 
		{
			if ($i ne $cat_info[0] && $i ne $cat_info[1]) 
			{
				# Get board name and description.
				sysopen(FH, "$cfg{boardsdir}/$i.dat", O_RDONLY);
				chomp(my @board_info = <FH>);
				close(FH);

				# Get moderator for this forum.
				sysopen(FH, "$cfg{memberdir}/$board_info[2].dat", O_RDONLY);
				chomp(my @mod_profile = <FH>);
				close(FH);

				my $moderator = $mod_profile[1];

				print <<"HTML";
<tr>
<td valign="top"><form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<input type="text" name="name" value="$board_info[0]" size="20"><br>
<textarea name="descr" cols="30" rows="3">$board_info[1]</textarea>
</td>
<td valign="top"><input type=text name="mod" value="$board_info[2]" size="10"></td>
<td valign="top"><input type="hidden" name="op" value="modify_board">
<input type="hidden" name="id" value="$i">
<input type="hidden" name="cats" value="$_">
<input type="submit" name="moda" value="Modify">
<input type="submit" name="moda" value="Remove">
</form>
</td>
</tr>
HTML
			}
		}

		print <<"HTML";
<tr>
<td colspan="3"><hr size="1"></td>
</tr>
<tr>
<td valign="top"><form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table>
<tr>
<td>ID:</td>
<td><input type="text" name="id" size="15"></td>
</tr>
<tr>
<td>Full name:</td>
<td><input type="text" name="name" size="20"></td>
</tr>
<tr>
<td colspan="2">Description:<br>
<textarea name="descr" cols="30" rows="3"></textarea></td>
</tr>
</table>
</td>
<td valign="top"><input type="text" name="mod" size="10"></td>
<td valign="bottom"><input type="hidden" name="op" value="create_board">
<input type="hidden" name="cats" value="$_">
<input type="submit" value="Add">
</form></td>
</tr>
HTML
	}

	print "</table>";

	print_html($user_data{theme}, "$nav{43} >>> Manage Boards", 1);
}

# ---------------------------------------------------------------------
# Order forums in a category.
# ---------------------------------------------------------------------
sub reorder_boards
{
	# Get board data.
	sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$cats.cat. ($!)", $user_data{theme});
	chomp(my @cat_boards = <FH>);
	close(FH);

	# Make list of available boards.
	my $board_list;
	foreach (@cat_boards) 
	{
		if ($_ ne $cat_boards[0] && $_ ne $cat_boards[1]) { $board_list = "$board_list\n$_"; }
	}

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Manage Boards >>> Reorder Boards");

	print <<"HTML";
<table border="0" width="100%" cellpading="0" cellspacing="0">
<tr>
<td valign="top"><form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<b>Current boards:</b><br>
<textarea name="boards" cols="30" rows="4">$board_list</textarea><br>
<input type="hidden" name="op" value="reorder_boards2">
<input type="hidden" name="first" value="$cat_boards[0]">
<input type="hidden" name="second" value="$cat_boards[1]">
<input type="hidden" name="cats" value="$cats">
<input type="submit" value="Reorder">
</form>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "$nav{43} >>> Manage Boards >>> Reorder Boards", 1);
}

# ---------------------------------------------------------------------
# Update forum order in a category.
# ---------------------------------------------------------------------
sub reorder_boards2
{
	$boards =~ s/\r//g;
	$first =~ s/\n//g;
	$second =~ s/\n//g;

	# Data integrity check.
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update categories.
	sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$cats.cat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$first\n$second\n";
	print FH $boards;

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=manage_boards');
}

# ---------------------------------------------------------------------
# Modify a forum or create a forum.
# ---------------------------------------------------------------------
sub modify_board 
{
	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Modify a board.
	if ($moda eq "Modify") 
	{
		# Format input.
		$descr =~ s/\n/ /g;
		$descr =~ s/\r//g;

		# Update board data.
		sysopen(FH, "$cfg{boardsdir}/$id.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$id.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH "$name\n$descr\n$mod\n";

		close(FH);

		print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=manage_boards');
	}

	# Delete a board.
	else 
	{
		# Get board data.
		sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$cats.cat. ($!)", $user_data{theme});
		chomp(my @categories = <FH>);
		close(FH);

		my $cat_list = '';
		foreach $_ (@categories) 
		{
			if ($_ ne $id) { $cat_list = "$cat_list$_\n"; }
		}

		# Data integrity check.
		if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Update category data.
		sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{boardsdir}/$cats.cat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH $cat_list;

		close(FH);

		# Get all messages in this forum.	
		sysopen(FH, "$cfg{boardsdir}/$id.txt", O_RDONLY) or user_error("$err{1} $cfg{boardsdir}/$id.txt. ($!)", $user_data{theme});
		chomp(my @messages = <FH>);
		close(FH);

		print_header();
		print_html($user_data{theme}, "$nav{43} >>> Manage Boards >>> Delete Board");

		# Remove all board data.
		foreach $_ (@messages) 
		{
			my ($mid, undef) = split(/\|/, $_); 

			# Data integrity check.
			if ($mid =~ /^([\w.]+)$/) { $mid = $1; } 
			else { user_error($err{6}, $user_data{theme}); }

			unlink("$cfg{messagedir}/$mid.txt");
			unlink("$cfg{messagedir}/$mid.mail");

			print "Removing message $mid...<br>";
		}

		print "Removing board datafiles...<br>";

		unlink("$cfg{boardsdir}/$id.dat");
		unlink("$cfg{boardsdir}/$id.txt");

		print "Done!";

		print_html($user_data{theme}, "$nav{43} >>> Manage Boards >>> Delete Board", 1);
	}
}

# ---------------------------------------------------------------------
# Create a new forum.
# ---------------------------------------------------------------------
sub create_board 
{
	if (!$mod) { $mod = "admin"; }
	$descr =~ s/[\n\r]//g;

	# Get category data.
	my @categories;
	if (-e("$cfg{boardsdir}/$cats.cat"))
	{
		sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_RDONLY);
		chomp(@categories = <FH>);
		close(FH);
	}

	# Data integrity check.
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update category data.
	sysopen(FH, "$cfg{boardsdir}/$cats.cat", O_WRONLY | O_TRUNC| O_CREAT) or user_error("$err{16} $cfg{boardsdir}/$cats.cat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	foreach my $i (@categories) { print FH "$i\n"; }
	print FH $id;

	close(FH);

	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Create new board.
	sysopen(FH, "$cfg{boardsdir}/$id.dat", O_WRONLY | O_TRUNC | O_CREAT);
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$name\n$descr\n$mod\n";

	close(FH);

	# Create message db for the new board.
	sysopen(FH, "$cfg{boardsdir}/$id.txt", O_WRONLY | O_TRUNC | O_CREAT);
	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=manage_boards');
}

# ---------------------------------------------------------------------
# Display all polls.
# ---------------------------------------------------------------------
sub edit_polls 
{
	# Get all available polls.
	my @polls;
	my $num = 1;
	if (-e("$cfg{polldir}/polls.txt"))
	{
		sysopen(FH, "$cfg{polldir}/polls.txt", O_RDONLY);
		chomp(@polls = <FH>);
		close(FH);

		# Get ID of new poll.
		my $name;
		($num, $name) = split(/\|/, $polls[0]);
		$num++;
	}

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Poll Admin");

	if (@polls != 0) 
	{
		print <<"HTML";
<table width="100%" class="bg5" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>Title</b></td>
<td><b>Action</b></td>
HTML

		# Print user actions.
		foreach (@polls) 
		{
			my @item = split(/\|/, $_);
			print <<"HTML";
<tr class="bg2">
<td><a href="$cfg{pageurl}/polls.$cfg{ext}?op=view_poll;id=$item[0]">$item[1]</a></td>
<td>[<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_poll;id=$item[0]">Edit</a>] [<a href="$cfg{pageurl}/admin.$cfg{ext}?op=delete_poll;id=$item[0]">Delete</a>] [<a href="$cfg{pageurl}/admin.$cfg{ext}?op=reset_poll;id=$item[0]">Reset</a>]</td>
</tr>
HTML
		}

		print <<"HTML";
</table>
</td>
</tr>
</table>
<br><br>
HTML
	}

	print qq(<a href="$cfg{pageurl}/admin.$cfg{ext}?op=create_poll;id=$num"><b>Create a new poll</b></a>);

	print_html($user_data{theme}, "$nav{43} >>> Poll Admin", 1);
}

# ---------------------------------------------------------------------
# Create a poll.
# ---------------------------------------------------------------------
sub create_poll 
{
	# Update poll index.
	sysopen(FH, "$cfg{polldir}/polls.txt", O_RDWR | O_CREAT) or user_error("$err{16} $cfg{polldir}/polls.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$id|Welcome to the Pollbooth\n";

	close(FH);

	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Generate question db.
	my $file = $id . "_q.dat";
	sysopen(FH, "$cfg{polldir}/$file", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{polldir}/$file. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "Option 1\n";

	close(FH);

	# Generate answer db.
	$file = $id . "_a.dat";
	sysopen(FH, "$cfg{polldir}/$file", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{polldir}/$file. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "0\n";

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_poll;id=' . $id);
}

# ---------------------------------------------------------------------
# Print formular to edit a poll.
# ---------------------------------------------------------------------
sub edit_poll 
{
	# Get all available polls.
	my @polls;
	if (-e("$cfg{polldir}/polls.txt"))
	{
		sysopen(FH, "$cfg{polldir}/polls.txt", O_RDONLY);
		chomp(@polls = <FH>);
		close(FH);
	}

	# Get pollname.
	my ($pid, $poll_name, $title);
	for (@polls) 
	{
		($pid, $poll_name) = split(/\|/, $_);
		if ($id == $id) { $title = $poll_name; }
	}

	# Get questions.
	my $qfile = $id . "_q.dat";
	sysopen(FH, "$cfg{polldir}/$qfile", O_RDONLY) or user_error("$err{1} $cfg{polldir}/$qfile. ($!)", $user_data{theme});
	chomp(my @questions = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{43} >>> Poll Admin >>> Edit Poll");

	# Print title.
	print <<"HTML";
<table>
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td>Question:</td>
<td><input type="text" name="question" size="40" value="$title"></td>
<td><input type="hidden" name="op" value="edit_poll2">
<input type="hidden" name="id" value="$id">
<input type="submit" name="moda" value="$btn{15}"></td>
</tr>
</form>
HTML

	# Print choices.
	for (my $i = 0; $i < @questions; $i++) 
	{
		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td>Answer $i:</td>
<td><input type="text" name="answer" size="40" value="$questions[$i]"></td>
<td><input type="hidden" name="op" value="edit_poll3">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="pos" value="$i">
<input type="submit" name="moda" value="$btn{15}">
<input type="submit" name="moda" value="$btn{16}"></td>
</tr>
</form>
HTML
	}

	# Print option to add a new choice.
	print <<"HTML";
</table>
</form>
<hr size="1">
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table>
<tr>
<td>Add an answer: <input type="text" name="answer" size="40">
<input type="hidden" name="op" value="edit_poll4">
<input type="hidden" name="id" value="$id">
<input type="submit" name="moda" value="Add"></td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "$nav{43} >>> Poll Admin >>> Edit Poll", 1);
}

# ---------------------------------------------------------------------
# Change poll title.
# ---------------------------------------------------------------------
sub edit_poll2 
{
	# Get all available polls.
	my @polls;
	if (-e("$cfg{polldir}/polls.txt"))
	{
		sysopen(FH, "$cfg{polldir}/polls.txt", O_RDONLY);
		@polls = <FH>;
		close(FH);
	}

	sysopen(FH, "$cfg{polldir}/polls.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/polls.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	# Update title.
	for (my $i = 0; $i < @polls; $i++) 
	{
		my ($pid, $poll_name) = split(/\|/, $polls[$i]);
		if ($pid == $id) { print FH "$pid|$question\n"; }
		else { print FH $polls[$i]; }
	}
	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_poll;id=' . $id);
}

# ---------------------------------------------------------------------
# Modify a choice.
# ---------------------------------------------------------------------
sub edit_poll3 
{
	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get questions.
	my $qfile = $id . "_q.dat";
	sysopen(FH, "$cfg{polldir}/$qfile", O_RDONLY) or user_error("$err{1} $cfg{polldir}/$qfile. ($!)", $user_data{theme});
	chomp(my @questions = <FH>);
	close(FH);

	# Get questions.
	my $afile = $id . "_a.dat";
	sysopen(FH, "$cfg{polldir}/$afile", O_RDONLY) or user_error("$err{1} $cfg{polldir}/$afile. ($!)", $user_data{theme});
	chomp(my @answers = <FH>);
	close(FH);

	# Delete a question.
	if ($moda eq $btn{16}) 
	{
		sysopen(FH, "$cfg{polldir}/$qfile", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/$qfile. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		# Update questions.
		for (my $i = 0; $i < @questions; $i++) 
		{
			if ($pos != $i) { print FH "$questions[$i]\n"; }
		}

		close(FH);

		# Update answers.
		sysopen(FH, "$cfg{polldir}/$afile", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/$afile. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		for (my $i = 0; $i < @answers; $i++) 
		{
			if ($pos != $i) { print FH "$answers[$i]\n"; }
		}

		close(FH);
	}

	# Modify a question.
	else {
		sysopen(FH, "$cfg{polldir}/$qfile", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/$qfile. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		for (my $i = 0; $i < @questions; $i++) 
		{
			if ($pos == $i) { print FH "$answer\n"; }
			else { print FH $questions[$i]; }
		}

		close(FH);
	}

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_poll;id=' . $id);
}

# ---------------------------------------------------------------------
# Add a new choice to poll.
# ---------------------------------------------------------------------
sub edit_poll4 
{
	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get questions.
	my $qfile = $id . "_q.dat";
	sysopen(FH, "$cfg{polldir}/$qfile", O_RDONLY) or user_error("$err{1} $cfg{polldir}/$qfile. ($!)", $user_data{theme});
	my @questions = <FH>;
	close(FH);

	# Get questions.
	my $afile = $id . "_a.dat";
	sysopen(FH, "$cfg{polldir}/$afile", O_RDONLY) or user_error("$err{1} $cfg{polldir}/$afile. ($!)", $user_data{theme});
	my @answers = <FH>;
	close(FH);

	# Add a new question.
	sysopen(FH, "$cfg{polldir}/$qfile", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/$qfile. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH @questions;
	print FH "$answer\n";

	close(FH);

	# Add a new answer.
	sysopen(FH, "$cfg{polldir}/$afile", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/$afile. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH @answers;
	print FH "0\n";

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_poll;id=' . $id);
}

# ---------------------------------------------------------------------
# Reset a poll.
# ---------------------------------------------------------------------
sub reset_poll 
{
	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get answer file.
	my $afile = $id . "_a.dat";
	sysopen(FH, "$cfg{polldir}/$afile", O_RDONLY) or user_error("$err{1} $cfg{polldir}/$afile. ($!)", $user_data{theme});
	my @answers = <FH>;
	close(FH);

	sysopen(FH, "$cfg{polldir}/$afile", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/$afile. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	# Reset all voting counts to zero.
	foreach (@answers) { print FH "0\n"; }

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_polls');
}

# ---------------------------------------------------------------------
# Delete a poll.
# ---------------------------------------------------------------------
sub delete_poll 
{
	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get all polls.
	sysopen(FH, "$cfg{polldir}/polls.txt", O_RDONLY) or user_error("$err{1} $cfg{polldir}/polls.txt. ($!)", $user_data{theme});
	chomp(my @polls = <FH>);
	close(FH);

	sysopen(FH, "$cfg{polldir}/polls.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{polldir}/polls.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	# Update poll index.
	for (my $i = 0; $i < @polls; $i++) 
	{
		my ($pid, $poll_name) = split(/\|/, $polls[$i]);
		if ($id != $pid) { print FH "$polls[$i]\n"; }
	}

	close(FH);

	# Remove poll files.
	my $qfile = $id . "_q.dat";
	my $afile = $id . "_a.dat";

	unlink("$cfg{polldir}/$qfile");
	unlink("$cfg{polldir}/$afile");

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_polls');
}

# ---------------------------------------------------------------------
# Display pending news.
# ---------------------------------------------------------------------
sub verify_news 
{
	# Get all pending topics.
	my @pending;
	if (-e("$cfg{topicsdir}/newarticles.dat"))
	{
		sysopen(FH, "$cfg{topicsdir}/newarticles.dat", O_RDONLY);
		chomp(@pending = <FH>);
		close(FH);
	}

	# Get topic categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/cats.dat. ($!)", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Verify News");

	if (@pending == 0) { print $msg{36}; }
	else 
	{
		print <<"HTML";
<table border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td align="center"><b>$msg{35}</b></td>
</tr>
</table>
HTML

		my $num = 0;
		for (my $i = 0; $i < @pending; $i++) 
		{
			my ($pid, $category, $subject, $nick, $poster, $email, $date, $message) = split(/\|/, $pending[$i]);

			# Make category selction drop down menu.
			my $cats_select = '';
			foreach my $cat (@cats) 
			{
				my ($cat_name, $cat_link) = split(/\|/, $cat);

				my $selected;
				if ($category eq $cat_link) { $selected = " selected"; }
				else { $selected = ""; }

				$cats_select = qq($cats_select\n<option value="$cat_link" $selected>$cat_name</option>);
			}

			$message = html_to_text($message);

			print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<hr noshade="noshade" size="1">
<table>
<tr>
<td colspan="2"><b>Article from $date:</b><input type="hidden" name="postdate" value="$date"></td>
</tr>
<tr>
<td>$msg{13}</td>
<td>$nick<input type="hidden" name="poster_nick" value="$nick"></td>
</tr>
<tr>
<td>$msg{7}</td>
<td>$email<input type="hidden" name="poster_email" value="$email"></td>
</tr>
<tr>
<td>$msg{34}</td>
<td>
<select name="cats">$cats_select
</select>
</td>
</tr>
<td>$msg{37}</td>
<td><input type="text" name="title" size="40" maxlength="50" value="$subject"></td>
</tr>
<tr>
<td valign="top">$msg{38}</td>
<td>
<textarea name="message" rows="10" cols="40">$message</textarea><br>
</td>
</tr>
<td colspan="2" align="center"><input type="hidden" name="op" value="verify_news2">
<input type="hidden" name="id" value="$pid">
<input type="hidden" name="poster_name" value="$poster">
<input type="submit" name="moda" value="$btn{10}">
<input type="submit" name="moda" value="$btn{11}">
</td>
</tr>
</table>
</form>
HTML
			$num++;
			if ($num >= $cfg{max_items_per_page}) { $i = @pending; }
		}

		# Make jumpbar.
		if ($num >= $cfg{max_items_per_page}) 
		{
			print qq(<hr noshade="noshade" size="1">\n$msg{39} );

			my $count = 0;
			while (($count * $cfg{max_items_per_page}) < $num) 
			{
				my $viewc = $count + 1;
				my $strt = ($count * $cfg{max_items_per_page});
				if ($start == $strt) { print "[$viewc] "; }
				elsif ($strt == 0) { print qq(<a href="$cfg{pageurl}/admin.$cfg{ext}?op=verify_news">$viewc</a> ); }
				else { print qq(<a href="$cfg{pageurl}/admin.$cfg{ext}?op=verify_news;start=$strt">$viewc</a> ); }
				$count++;
			}
		}
	}

	print_html($user_data{theme}, "$nav{24} >>> Verify News", 1);
}

# ---------------------------------------------------------------------
# Verify or delete pending news.
# ---------------------------------------------------------------------
sub verify_news2 
{
	user_error($err{14}, $user_data{theme}) unless ($title);
	user_error($err{15}, $user_data{theme}) unless ($message);

	# Format input.
	$title = html_escape($title);
	$message = html_escape($message);

	# Get all pending topics.
	my @pending;
	if (-e("$cfg{topicsdir}/newarticles.dat"))
	{
		sysopen(FH, "$cfg{topicsdir}/newarticles.dat", O_RDONLY);
		chomp(@pending = <FH>);
		close(FH);
	}

	# Publish article.
	if ($moda eq $btn{10}) 
	{
		# Get ID of new topic.
		opendir(DIR, "$cfg{articledir}");
		my @files = readdir(DIR);
		closedir(DIR);

		@files = grep(/\.txt/, @files);
		foreach (@files) { $_ =~s/\.txt//; }
		@files = reverse(sort { $a <=> $b } @files);

		my $post_num = $files[0] || 0;
		if ($post_num) { $post_num =~ s/\.txt//; }
		$post_num++;

		for (my $i = 0; $i < @pending; $i++) 
		{
			my $tid;
			($tid, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $pending[$i]);

			if ($tid == $id) 
			{
				# Get date.
				my $date = get_date();
	
				# Get messages in category.
				my @topics;
				if (-e("$cfg{topicsdir}/$cats.cat"))
				{
					sysopen(FH, "$cfg{topicsdir}/$cats.cat", O_RDONLY);
					@topics = <FH>;
					close(FH);
				}

				# Data integrity check.
				if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
				else { user_error($err{6}, $user_data{theme}); }

				# Add topic to message index.
				sysopen(FH, "$cfg{topicsdir}/$cats.cat", O_WRONLY | O_TRUNC | O_CREAT);
				flock(FH, LOCK_EX) if $cfg{use_flock};

				print FH "$post_num|$title|$poster_nick|$poster_name|$poster_email|$date|0|0\n";
				print FH @topics;

				close(FH);

				# Data integrity check.
				if ($post_num =~ /^([\w.]+)$/) { $post_num = $1; } 
				else { user_error($err{6}, $user_data{theme}); }

				# Save topic.
				sysopen(FH, "$cfg{articledir}/$post_num.txt", O_WRONLY | O_TRUNC | O_CREAT);
				flock(FH, LOCK_EX) if $cfg{use_flock};

				print FH "$title|$poster_nick|$poster_name|$poster_email|$date|$message\n";

				close(FH);
			}
		}

		# Update the pending news db.
		sysopen(FH, "$cfg{topicsdir}/newarticles.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/newarticles.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};
	
		for (my $i = 0; $i < @pending; $i++) 
		{
			my $tid;
			($tid, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $pending[$i]);

			if ($tid != $id) { print FH "$pending[$i]\n"; }
		}

		close(FH);

		# Data integrity check.
		if ($poster_name =~ /^([\w.]+)$/) { $poster_name = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Update article count of user who posted news.
		sysopen(FH, "$cfg{memberdir}/$poster_name.dat", O_RDONLY) or user_error("$err{1} $cfg{memberdir}/$poster_name.dat. ($!)", $user_data{theme});
		chomp(my @user_profile = <FH>);
		close(FH);

		$user_profile[11]++;

		sysopen(FH, "$cfg{memberdir}/$poster_name.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{memberdir}/$poster_name.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		for (my $i = 0; $i < @user_profile; $i++) { print FH "$user_profile[$i]\n"; }

		close(FH);

		# Export to RDF-file.
		rdf_export();

		# Notify users, who are watching this category.
		require "topics.cgi";
		if (-e "$cfg{topicsdir}/$cats.mail") { notify_users($cats, "$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cats;id=$post_num"); }
	}

	# Delete the submitted article.
	else 
	{
		sysopen(FH, "$cfg{memberdir}/newarticles.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{memberdir}/newarticles.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		for (my $i = 0; $i < @pending; $i++) 
		{
			my $tid;
			($tid, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $pending[$i]);

			if ($tid != $id) { print FH "$pending[$i]\n"; }
		}

		close(FH);
	}

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=verify_news');
}

# ---------------------------------------------------------------------
# Print index of available articles.
# ---------------------------------------------------------------------
sub modify_news 
{
	# Get all topic cats.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/cats.dat. ($!)", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Edit/Delete News");

	print <<"HTML";
<table>
<tr>
<td valign="top">Choose article category: </td>
<td valign="top"><form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<select name="cats">
HTML

	# Make dropdown menu with all cats.
	my $cat;
	foreach (@cats) 
	{
		my ($cat_name, $cat_link) = split(/\|/, $_);
		if ($cats eq $cat_link) { 
			print qq(<option value="$cat_link" selected>$cat_name</option>); 
			$cat = $cat_name;
		}
		else { print qq(<option value="$cat_link">$cat_name</option>); }
	}

	print <<"HTML";
</select>
<input type="hidden" name="op" value="modify_news">
<input type="submit" value="$btn{14}">
</form></td>
</tr>
</table><br>
HTML

	# Print article list.
	if ($cats ne '') 
	{
		print <<"HTML";
<b>Articles in this Category "$cat":</b><br>
<table width="100%" class="bg5" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>ID</b></td>
<td><b>Subject</b></td>
<td><b>Date</b></td>
<td><b>Poster</b></td>
HTML

		my @articles;
		if (-e("$cfg{topicsdir}/$cats.cat"))
		{
			sysopen(FH, "$cfg{topicsdir}/$cats.cat", O_RDONLY);
			chomp(@articles = <FH>);
			close(FH);
		}

		for (my $i = 0; $i < @articles; $i++) 
		{
			my ($tid, $subject, $nick, $poster, $email, $postdate, $comments, $views) = split(/\|/, $articles[$i]);

			print <<"HTML";
<tr class="bg2">
<td>$tid</td>
<td><a href="$cfg{pageurl}/admin.$cfg{ext}?op=modify_news2;cats=$cats;id=$tid">$subject</a></td>
<td>$postdate</td>
<td><a href="mailto:$email">$nick</a></td>
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

	print_html($user_data{theme}, "$nav{24} >>> Edit/Delete News", 1);
}

# ---------------------------------------------------------------------
# Print formular to edit a topic article.
# ---------------------------------------------------------------------
sub modify_news2 
{
	# Get article data.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_RDONLY) or user_error("$err{1} $cfg{articledir}/$id.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Edit/Delete News");

	print qq(<table width="100%">\n);

	# Print article with comments.
	for (my $i = 0; $i < @messages; $i++) 
	{
		my ($subject, $nick, $poster, $email, $postdate, $text) = split(/\|/, $messages[$i]);

		$text = html_to_text($text);

		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td valign="top"><a href="mailto:$email">$nick</a><br>
$postdate</td>
<td><input type="text" name="title" value="$subject" size="30"><br>
<textarea name="message" rows="3" cols="40">$text</textarea></td>
<td><input type="hidden" name="op" value="modify_news3">
<input type="hidden" name="cats" value="$cats">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="view_num" value="$i">
<input type="submit" name="moda" value="$btn{15}"><br>
<input type="submit" name="moda" value="$btn{16}"></td>
</tr>
<tr>
<td colspan="3"><hr size="1"></td>
</tr>
</form>
HTML
	}
	
	# Get all topic cats.
	my @cats;
	if (-e("$cfg{topicsdir}/cats.dat"))
	{
		sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	}

	# Make dropdown menu with all categories.
	my $cat;
	foreach (@cats) 
	{
		my ($cat_name, $cat_link) = split(/\|/, $_);
		if ($cats eq $cat_link) { $cat .= qq(<option value="$cat_link" selected>$cat_name</option>\n); }
		else { $cat .= qq(<option value="$cat_link">$cat_name</option>\n); }
	}

	# Print menu to move topics.
	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td colspan="3">Move to: <select name="new_cat">
$cat</select>
<input type="hidden" name="op" value="move_topic">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="old_cat" value="$cats">
<input type="submit" value="Move"></td>
</tr>
</form>
</table>
HTML

	print_html($user_data{theme}, "$nav{24} >>> Edit/Delete News", 1);
}

# ---------------------------------------------------------------------
# Edit or delete a topic message.
# ---------------------------------------------------------------------
sub modify_news3 
{
	# Get article data.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_RDONLY) or user_error("$err{1} $cfg{articledir}/$id.txt. ($!)", $user_data{theme});
	chomp(my @messages = <FH>);
	close(FH);

	# Check if there are comments attached.
	my $count = @messages;
	if ($view_num == 0 && $count > 1 && $moda eq $btn{16}) {  user_error($err{25}, $user_data{theme}); }

	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update topic.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{articledir}/$id.txt. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @messages; $i++) 
	{
		if ($view_num == $i) 
		{
			my ($subject, $nick, $poster, $email, $postdate, $text) = split(/\|/, $messages[$i]);

			# Modify topic entry.
			if ($moda eq $btn{15}) 
			{
				# Format input.
				chomp($title);
				chomp($message);
				$title = html_escape($title);
				$message = html_escape($message);

				# Update category index if this is initial message.
				if ($view_num == 0) 
				{
					# Get category index.
					sysopen(FH2, "$cfg{topicsdir}/$cats.cat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/$cats.cat. ($!)", $user_data{theme});
					chomp(my @cats = <FH2>);
					close(FH2);

					# Update index.
					sysopen(FH2, "$cfg{topicsdir}/$cats.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/$cats.cat. ($!)", $user_data{theme});
					flock(FH2, LOCK_EX) if $cfg{use_flock};

					for (my $j = 0; $j < @cats; $j++) 
					{
						my @cat = split(/\|/, $cats[$j]);

						if ($cat[0] == $id) { print FH2 "$cat[0]|$title|$cat[2]|$cat[3]|$cat[4]|$cat[5]|$cat[6]|$cat[7]\n"; }
						else { print FH2 "$cats[$j]\n"; }
					}

					close(FH2);
				}

				print FH "$title|$nick|$poster|$email|$postdate|$message\n";
			}

			# Delete topic entry.
			else 
			{
				# Get category index.
				sysopen(FH2, "$cfg{topicsdir}/$cats.cat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/$cats.cat. ($!)", $user_data{theme});
				chomp(my @cats = <FH2>);
				close(FH2);

				# Update index.
				sysopen(FH2, "$cfg{topicsdir}/$cats.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/$cats.cat. ($!)", $user_data{theme});
				flock(FH2, LOCK_EX) if $cfg{use_flock};

				for (my $j = 0; $j < @cats; $j++) 
				{
					my @cat = split(/\|/, $cats[$j]);

					# If message is a comment, update comment counter.
					if ($cat[0] == $id) 
					{ 
						if ($view_num != 0) 
						{
							# Decrement comment counter.
							$cat[6]--;

							print FH2 "$cat[0]|$cat[1]|$cat[2]|$cat[3]|$cat[4]|$cat[5]|$cat[6]|$cat[7]\n"; 
						}
					}
					else { print FH2 "$cats[$j]\n"; }
				}

				close(FH2);

				# Get poster profile.
				sysopen(FH2, "$cfg{memberdir}/$poster.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
				chomp(my @user_profile = <FH2>);
				close(FH2);

				# Decrement article count.
				if ($view_num == 0) { $user_profile[11]--; }

				# Decrement update comment count.
				else { $user_profile[12]--; }

				# Data integrity check.
				if ($poster =~ /^([\w.]+)$/) { $poster = $1; } 
				else { user_error($err{6}, $user_data{theme}); }

				# Update poster profile.
				sysopen(FH2, "$cfg{memberdir}/$poster.dat", O_WRONLY | O_TRUNC);
				flock(FH2, LOCK_EX) if $cfg{use_flock};

				for (my $j = 0; $j < @user_profile; $j++) { print FH2 "$user_profile[$j]\n"; }

				close(FH2);

			}
		}
		else { print FH "$messages[$i]\n"; }
	}

	close(FH);

	# Export to RDF-file.
	rdf_export();

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=modify_news2;cats=' . $cats . ';id=' . $id);
}

# ---------------------------------------------------------------------
# Move a topic.
# ---------------------------------------------------------------------
sub move_topic 
{
	# Get old category index.
	sysopen(FH, "$cfg{topicsdir}/$old_cat.cat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/$old_cat.cat. ($!)", $user_data{theme});
	chomp(my @topics = <FH>);
	close(FH);

	# Data integrity check.
	if ($old_cat =~ /^([\w.]+)$/) { $old_cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Remove topic from old category.
	sysopen(FH, "$cfg{topicsdir}/$old_cat.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/$old_cat.cat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	my $move_topic;
	for (my $i = 0; $i < @topics; $i++) 
	{
		my ($tid, $subject, $nick, $poster, $email, $postdate, $comments, $views) = split(/\|/, $topics[$i]);

		if ($tid ne $id) { print FH "$topics[$i]\n"; }
		else { $move_topic = $topics[$i]; }
	}

	close(FH);

	# Get new category index.
	sysopen(FH, "$cfg{topicsdir}/$new_cat.cat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/$new_cat.cat. ($!)", $user_data{theme});
	chomp(@topics = <FH>);
	close(FH);

	# Data integrity check.
	if ($new_cat =~ /^([\w.]+)$/) { $new_cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Save topic in new category.
	sysopen(FH, "$cfg{topicsdir}/$new_cat.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/$new_cat.cat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$move_topic\n";
	foreach (@topics) { print FH "$_\n"; }

	close(FH);
	
	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=modify_news');
}

# ---------------------------------------------------------------------
# Print list of all topic categories.
# ---------------------------------------------------------------------
sub edit_topic_categories 
{
	# Get all topic cats.
	my @cats;
	if (-e("$cfg{topicsdir}/cats.dat"))
	{
		sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Topic Categories");

	print "<table>\n";

	# Print list of all available categories.
	foreach (@cats) 
	{
		my @item = split(/\|/, $_);
		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td><img src="$cfg{imagesurl}/topics/$item[1].gif" alt="$cfg{imagesurl}/topics/$item[1].gif"></td>
<td valign="top">
<table>
<tr>
<td>Description:</td>
<td><input type="text" name="descr" value="$item[0]"></td>
</tr>
<tr>
<td>Category:</td>
<td><input type="text" name="cats" value="$item[1]"></td>
</tr>
</table>
</td>
<td valign="top"><input type="hidden" name="op" value="edit_topic_categories2">
<input type="hidden" name="old_cat" value="$item[1]">
<input type="submit" name="moda" value="$btn{15}"><br>
<input type="submit" name="moda" value="$btn{16}"></td>
</tr>
</form>
HTML
	}

	# Print panel to add a new category.
	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td colspan="2"><hr size="1">
<b>Add Category</b></td>
</tr>
<tr>
<td>Description:</td>
<td><input type="text" name="descr"></td>
</tr>
<tr>
<td>Category:</td>
<td><input type="text" name="cats"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="edit_topic_categories3">
<input type="submit" value="Create"></td>
</tr>
</form>
</table>
HTML

	print_html($user_data{theme}, "$nav{24} >>> Topic Categories", 1);
}

# ---------------------------------------------------------------------
# Update or delete a topic category.
# ---------------------------------------------------------------------
sub edit_topic_categories2
{
	# Data integrity check.
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get all topic cats.
	my @cats;
	if (-e("$cfg{topicsdir}/cats.dat"))
	{
		sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	}

	# Modify category.
	if ($moda eq $btn{15}) 
	{
		chomp($old_cat);

		# Update main category index.
		sysopen(FH, "$cfg{topicsdir}/cats.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/cats.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@cats) 
		{
			my ($cat_name, $cat_link) = split(/\|/, $_);

			if ($old_cat eq $cat_link) { print FH "$descr|$cats\n"; }
			else { print FH "$_\n"; }
		}

		close(FH);

		# Get data of category.
		my @topics;
		if (-e("<$cfg{topicsdir}/$old_cat.cat"))
		{
			sysopen(FH, "$cfg{topicsdir}/$old_cat.cat", O_RDONLY);
			chomp(my @topics = <FH>);
			close(FH);
		}

		# Update category.
		sysopen(FH, "$cfg{topicsdir}/$cats.cat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/$cats.cat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@topics) { print FH "$_\n"; }

		close(FH);

		# Data integrity check.
		if ($old_cat =~ /^([\w.]+)$/) { $old_cat = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		unlink("$cfg{topicsdir}/$old_cat.cat");
	}

	# Delete topic category
	if ($moda eq $btn{16}) 
	{
		chomp($cats);

		# Get data of category.
		my @topics;
		if (-e("<$cfg{topicsdir}/$cats.cat"))
		{
			sysopen(FH, "$cfg{topicsdir}/$cats.cat", O_RDONLY);
			chomp(@topics = <FH>);
			close(FH);
		}

		# Exit if there are topics in this category.
		if (@topics != 0) { user_error($err{25}, $user_data{theme}); }

		# Update main category index.
		sysopen(FH, "$cfg{topicsdir}/cats.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{topicsdir}/cats.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@cats) 
		{
			my ($cat_name, $cat_link) = split(/\|/, $_);

			if ($cats ne $cat_link) { print FH "$_\n"; }
		}

		close(FH);

		unlink("$cfg{topicsdir}/$cats.cat");
	}

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_topic_categories');
}

# ---------------------------------------------------------------------
# Create a topic category.
# ---------------------------------------------------------------------
sub edit_topic_categories3
{
	# Get all topic categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) or user_error("$err{1} $cfg{topicsdir}/cats.dat. ($!)", $user_data{theme});
	my @cats = <FH>;
	close(FH);

	# Update main category index.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{topicsdir}/cats.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$descr|$cats\n";
	print FH @cats;

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_topic_categories');
}

# ---------------------------------------------------------------------
# Display all link categories.
# ---------------------------------------------------------------------
sub edit_link_cats 
{
	# Get all link categories.
	my @cats;
	if (-e("$cfg{linksdir}/linkcats.dat"))
	{
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Link Categories");
	
	print "<table>\n";

	# Print all categories.
	foreach (@cats) 
	{
		my @item = split(/\|/, $_);
		$item[2] = html_to_text($item[2]);

		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td colspan="2" valign="top">
<table>
<tr>
<td>Name:</td>
<td><input type="text" name="name" value="$item[0]">
<input type="hidden" name="cats" value="$item[1]"></td>
</tr>
<tr>
<td valign="top">Description:</td>
<td><textarea name="descr" rows="10" cols="40">$item[2]</textarea></td>
</tr>
</table>
</td>
<td valign="top"><input type="hidden" name="op" value="edit_link_cats2">
<input type="hidden" name="old_cat" value="$item[1]">
<input type="submit" name="moda" value="$btn{15}"><br>
<input type="submit" name="moda" value="$btn{16}"></td>
</tr>
</form>
HTML
	}

	# Print panel to create a new category.
	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td colspan="2"><hr size="1">
<b>Add Category</b></td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" name="name"></td>
</tr>
<tr>
<td>Link:</td>
<td><input type="text" name="cats"></td>
</tr>
<tr>
<td valign="top">Description:</td>
<td><textarea name="descr" rows="10" cols="40"></textarea></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="edit_link_cats3">
<input type="submit" value="Create"></td>
</tr>
</form>
</table>
HTML

	print_html($user_data{theme}, "$nav{24} >>> Link Categories", 1);
}

# ---------------------------------------------------------------------
# Modify or delete a link category.
# ---------------------------------------------------------------------
sub edit_link_cats2 
{
	# Check and format input.
	user_error($err{6}, $user_data{theme}) if (!$name || !$descr);

	$name = html_escape($name);
	$descr = html_escape($descr);

	# Data integrity check.
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }
	if ($old_cat =~ /^([\w.]+)$/) { $old_cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get all link categories.
	my @cats;
	if (-e("$cfg{linksdir}/linkcats.dat"))
	{
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	};

	# Mofify link category.
	if ($moda eq $btn{15}) 
	{
		chomp($old_cat);

		# Update main link category.
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/linkcats.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@cats) 
		{
			my @item = split(/\|/, $_);
			if ($old_cat eq $item[1]) { print FH "$name|$cats|$descr\n"; }
			else { print FH "$_\n"; }
		}

		close(FH);

		# Rename category.
		if ($old_cat ne $cats && -e("<$cfg{linksdir}/$old_cat.dat"))
		{
			sysopen(FH, "$cfg{linksdir}/$old_cat.dat", O_RDONLY);
			chomp(my @links = <FH>);
			close(FH);

			sysopen(FH, "$cfg{linksdir}/$cats.dat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{linksdir}/$cats.dat. ($!)", $user_data{theme});
			flock(FH, LOCK_EX) if $cfg{use_flock};

			foreach (@links) { print FH "$_\n"; }

			close(FH);

			unlink("$cfg{linksdir}/$old_cat.dat");
		}
	}

	# Delete link category.
	if ($moda eq $btn{16}) 
	{
		chomp($cats);

		# Update main link category.
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/linkcats.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@cats) 
		{
			my @item = split(/\|/, $_);
			if ($old_cat ne $item[1]) { print FH "$_\n"; }
		}

		close(FH);

		unlink("$cfg{linksdir}/$old_cat.dat");
	}

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_link_cats');
}

# ---------------------------------------------------------------------
# Create a link category.
# ---------------------------------------------------------------------
sub edit_link_cats3 
{
	# Check and format input.
	user_error($err{6}, $user_data{theme}) if (!$name || !$descr || !$cats || $cats !~ /^[0-9A-Za-z#%+,-\.:=?@^_]+$/);

	$name = html_escape($name);
	$descr = html_escape($descr);

	# Get all link categories.
	my @cats;
	if (-e("$cfg{linksdir}/linkcats.dat"))
	{
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY);
		@cats = <FH>;
		close(FH);
	};

	# Update main link category.
	sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{linksdir}/linkcats.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH @cats;
	print FH "$name|$cats|$descr\n";

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_link_cats');
}

# ---------------------------------------------------------------------
# Display all available links.
# ---------------------------------------------------------------------
sub edit_links 
{
	# Get all link categories.
	sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/linkcats.dat. ($!)", $user_data{theme});
	my @cats = <FH>;
	close(FH);

	# Make dropdown menu with all categories.
	my ($cat, $catname);
	foreach (@cats) 
	{
		my ($cat_name, $cat_link, $cat_descr) = split(/\|/, $_);
		if ($cats eq $cat_link) 
		{
			$cat .= qq(<option value="$cat_link" selected>$cat_name</option>\n); 
			$catname = $cat_name;
		}
		else { $cat .= qq(<option value="$cat_link">$cat_name</option>\n); }
	}

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Edit Links");

	print <<"HTML";
<table>
<tr>
<td valign="top">Choose link category: </td>
<td valign="top"><form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<select name="cats">
$cat</select>
<input type="hidden" name="op" value="edit_links">
<input type="submit" value="$btn{14}">
</form></td>
</tr>
</table><br>
HTML

	# Print links in selected category.
	if ($cats ne '') 
	{
		print <<"HTML";
<b>Links in Category "$catname":</b><br>
<table width="100%" class="bg5" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>ID</b></td>
<td><b>Name</b></td>
<td><b>Description</b></td>
<td><b>Date</b></td>
<td><b>Poster</b></td>
HTML

		# Get data of category.
		my @links;
		if (-e("$cfg{linksdir}/$cats.dat"))
		{
			sysopen(FH, "$cfg{linksdir}/$cats.dat", O_RDONLY);
			chomp(@links = <FH>);
			close(FH);
		}

		# Print links.
		foreach (@links) 
		{
			my ($lid, $link_name, $url, $descr, $postdate, $link_poster, $hits, $votes, $rate) = split(/\|/, $_);

			# Get poster profile.
			sysopen(FH, "$cfg{memberdir}/$link_poster.dat", O_RDONLY);
			chomp(my @user_profile = <FH>);
			close(FH);

			print <<"HTML";
<tr class="bg2">
<td><a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_links2;cats=$cats;id=$lid"><b>$lid</b></a></td>
<td><a href="$url" target="_blank">$link_name</a></td>
<td>$descr</td>
<td>$postdate</td>
<td><a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$link_poster">$user_profile[1]</a></td>
</tr>
HTML
		}

		print <<"HTML";
</td>
</tr>
</table>
</td>
</tr>
</table>
HTML
	}

	print_html($user_data{theme}, "$nav{24} >>> Edit Links", 1);
}

# ---------------------------------------------------------------------
# Print formular to edit a link.
# ---------------------------------------------------------------------
sub edit_links2 
{
	# Get data of category.
	sysopen(FH, "$cfg{linksdir}/$cats.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$cats.dat. ($!)", $user_data{theme});
	chomp(my @links = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{24} >>> Edit Link");

	print "<table width=\"100%\">";

	for (my $i = 0; $i < @links; $i++) 
	{
		my ($lid, $link_name, $url, $descr, $postdate, $link_poster, $hits) = split(/\|/, $links[$i]);

		if ($id == $lid) 
		{
			# Get poster profile.
			my @user_profile;
			if (-e("$cfg{memberdir}/$link_poster.dat"))
			{
				sysopen(FH, "$cfg{memberdir}/$link_poster.dat", O_RDONLY);
				chomp(@user_profile = <FH>);
				close(FH);
			}

			$descr = html_to_text($descr);

			print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td valign="top">From <a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$link_poster">$user_profile[1]</a>:<br>
($postdate)</td>
<td><input type="text" name="name" value="$link_name" size="30"><br>
<input type="text" name="url" value="$url" size="30"><br>
<textarea name="descr" rows="3" cols="40">$descr</textarea></td>
<td><input type="hidden" name="op" value="edit_links3">
<input type="hidden" name="cats" value="$cats">
<input type="hidden" name="id" value="$id">
<input type="submit" name="moda" value="$btn{15}"><br>
<input type="submit" name="moda" value="$btn{16}"></td>
</tr>
<tr>
<td colspan="3"><hr size="1"></td>
</tr>
</form>
HTML
		}
	}

	# Get all link categories.
	my @cats;
	if (-e("$cfg{linksdir}/linkcats.dat"))
	{
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	};

	# Make dropdown menu with all categories.
	my ($cat, $catname);
	foreach (@cats) 
	{
		my ($cat_name, $cat_link, $cat_descr) = split(/\|/, $_);
		if ($cats eq $cat_link) 
		{
			$cat .= qq(<option value="$cat_link" selected>$cat_name</option>\n); 
			$catname = $cat_name;
		}
		else { $cat .= qq(<option value="$cat_link">$cat_name</option>\n); }
	}

	# Print panel to move link to another category.
	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td colspan="3">Move to: <select name="new_cat">
$cat</select>
<input type="hidden" name="op" value="move_link">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="old_cat" value="$cats">
<input type="submit" value="Move"></td>
</tr>
</form>
</table>
HTML
	print_html($user_data{theme}, "$nav{24} >>> Edit Link", 1);
}

# ---------------------------------------------------------------------
# Modify or delete a link.
# ---------------------------------------------------------------------
sub edit_links3 
{
	# Data integrity check.
	if ($cats =~ /^([\w.]+)$/) { $cats = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get data of category.
	sysopen(FH, "$cfg{linksdir}/$cats.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$cats.dat. ($!)", $user_data{theme});
	chomp(my @links = <FH>);
	close(FH);

	# Modify link. 
	if ($moda eq $btn{15}) 
	{
		# Check and format input.
		user_error($err{6}, $user_data{theme}) if (!$name || !$descr || !$url);

		$name = html_escape($name);
		$descr = html_escape($descr);

		sysopen(FH, "$cfg{linksdir}/$cats.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/$cats.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@links) 
		{
			my ($lid, $link_name, $link_url, $link_descr, $postdate, $link_poster, $hits, $votes, $rate) = split(/\|/, $_);

			if ($lid == $id) { print FH "$lid|$name|$url|$descr|$postdate|$link_poster|$hits|$votes|$rate\n"; }
			else { print FH "$_\n"; }
		}

		close(FH);
	}

	# Delete link.
	if ($moda eq $btn{16}) 
	{
		sysopen(FH, "$cfg{linksdir}/$cats.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/$cats.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@links) 
		{
			my ($lid, $link_name, $url, $descr, $postdate, $link_poster, $hits) = split(/\|/, $_);

			if ($lid != $id) { print FH "$_\n"; }
		}

		close(FH);
	}

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_links');
}

# ---------------------------------------------------------------------
# Move a link.
# ---------------------------------------------------------------------
sub move_link 
{
	# Data integrity check.
	if ($old_cat =~ /^([\w.]+)$/) { $old_cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }
	if ($new_cat =~ /^([\w.]+)$/) { $new_cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Check input.
	if ($old_cat eq $new_cat) { user_error($err{6}, $user_data{theme}); }

	# Get old category index.
	sysopen(FH, "$cfg{linksdir}/$old_cat.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$old_cat.cat. ($!)", $user_data{theme});
	chomp(my @links = <FH>);
	close(FH);

	# Get new category index.
	my @links2;
	my $new_id = 0;
	if (-e("$cfg{linksdir}/$new_cat.dat"))
	{
		sysopen(FH, "$cfg{linksdir}/$new_cat.dat", O_RDONLY);
		chomp(@links2 = <FH>);
		close(FH);

		# Get ID for link in new category.
		if (@links2) { ($new_id, undef, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $links2[0]); }
		else { $new_id = 0; }
	}
	$new_id++;

	# Remove link from old category.
	my $move_link;
	sysopen(FH, "$cfg{linksdir}/$old_cat.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/$old_cat.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @links; $i++) 
	{
		my ($lid, $link_name, $url, $link_descr, $postdate, $link_poster, $hits, $votes, $rate) = split(/\|/, $links[$i]);

		if ($lid != $id) { print FH "$links[$i]\n"; }
		else { $move_link = "$new_id|$link_name|$url|$link_descr|$postdate|$link_poster|$hits|$votes|$rate\n"; }
	}

	close(FH);

	# Insert link into new category.
	sysopen(FH, "$cfg{linksdir}/$new_cat.dat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{linksdir}/$new_cat.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$move_link";
	foreach (@links2) { print FH "$_\n"; }

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_links');
}

# ---------------------------------------------------------------------
# Edit user ranks.
# ---------------------------------------------------------------------
sub user_ranks 
{
	# Get user ranks.
	sysopen(FH, "$cfg{memberdir}/membergroups.dat", O_RDONLY) or user_error("$err{1} $cfg{memberdir}/membergroups.dat. ($!)", $user_data{theme});
	chomp(my @user_ranks = <FH>);
	close(FH);

	my @required_posts = qw(0 25 50 75 100 250 500);

	print_header();
	print_html($user_data{theme}, "User Admin >>> Edit Userranks");

	print "<table>\n";

	my $num = 0;
	foreach (@user_ranks) 
	{
		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<tr>
<td>> $required_posts[$num] Posts</td>
<td><input type="text" name="first" value="$_">&nbsp;<input type="submit" value="Edit">
<input type="hidden" name="op" value="user_ranks2">
<input type="hidden" name="second" value="$num"></td>
</tr>
</form>
HTML
		$num++;
	}

	print "</table>\n";

	print_html($user_data{theme}, "User Admin >>> Edit Userranks", 1);
}

# ---------------------------------------------------------------------
# Update user ranks.
# ---------------------------------------------------------------------
sub user_ranks2 
{
	# Get user ranks.
	sysopen(FH, "$cfg{memberdir}/membergroups.dat", O_RDONLY) or user_error("$err{1} $cfg{memberdir}/membergroups.dat. ($!)", $user_data{theme});
	chomp(my @user_ranks = <FH>);
	close(FH);

	sysopen(FH, "$cfg{memberdir}/membergroups.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{memberdir}/membergroups.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	my $num = 0;
	foreach (@user_ranks) 
	{
		if ($num eq $second) { print FH "$first\n"; }
		else { print FH "$_\n"; }
		$num++;
	}

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=user_ranks');
}

# ---------------------------------------------------------------------
# Show online users.
# ---------------------------------------------------------------------
sub view_online 
{
	my @online_users;
	if (-e("$cfg{datadir}/log.dat"))
	{
		sysopen(FH, "$cfg{datadir}/log.dat", O_RDONLY);
		chomp(@online_users = <FH>);
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, "User Admin >>> View online Users");

	print <<"HTML";
<table width="100%" class="bg5" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>User</b></td>
<td><b>Last online</b></td>
</tr>
HTML

	# Print log.
	foreach (@online_users) 
	{
		my ($user_name, $user_value) = split(/\|/, $_);

		# Guest.
		if ($user_name =~ /\./) 
		{ 
			print <<"HTML";
<tr class="bg2">
<td>$usr{anonuser} ($user_name)</td>
<td>$user_value</td>
</tr>
HTML
		}

		# Registered member.
		else 
		{ 
			my @user_profile;
			if (-e("$cfg{memberdir}/$user_name.dat"))
			{
				sysopen(FH, "$cfg{memberdir}/$user_name.dat", O_RDONLY);
				chomp(@user_profile = <FH>);
				close(FH);
			}

			print <<"HTML";
<tr class="bg2">
<td><a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$user_name">$user_profile[1]</a></td>
<td>$user_value</td>
</tr>
HTML
		}
	}

	print <<"HTML";
</table>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, "User Admin >>> View online Users", 1);
}

# ---------------------------------------------------------------------
# Edit a user generated page.
# ---------------------------------------------------------------------
sub edit_pages 
{
	# Get all pages.
	my @pages;
	my ($page, $page_name, $page_content) = '';

	if (-e("$cfg{pagesdir}/pages.dat"))
	{
		sysopen(FH, "$cfg{pagesdir}/pages.dat", O_RDONLY);
		chomp(@pages = <FH>);
		close(FH);

		# Make dropdown menu with all pages.
		foreach (@pages) 
		{
			my @item = split(/\|/, $_);
			if ($id && $id eq $item[0]) 
			{
				$page .= qq(<option value="$item[0]" selected>$item[1]</option>\n); 
				$page_name = $item[1];
			}
			else { $page .= qq(<option value="$item[0]">$item[1]</option>\n); }
		}
	}

	print_header();
	print_html($user_data{theme}, "Content Admin >>> Edit Pages");

	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table>
<tr>
<td valign="top">Choose a page to edit: </td>
<td valign="top"><select name="id">
<option value=""></option>
$page</select>
<input type="hidden" name="op" value="edit_pages">
<input type="submit" value="$btn{14}">
</td>
</tr>
<tr>
<td colspan="2">Or <a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_pages;id=new">create a new page</a></td>
</tr>
</table>
</form>
<hr size="1">
HTML

	# Print page content.
	if ($id) 
	{
		if ($id ne "new")
		{
			# Get page content.
			my @content;
			if (-e("$cfg{pagesdir}/$id.txt"))
			{
				sysopen(FH, "$cfg{pagesdir}/$id.txt", O_RDONLY);
				chomp(@content = <FH>);
				close(FH);

				$page_content = html_to_text(@content);
			}
		}
		else
		{
			$page_name = '';
			$page_content = '';
		}

		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table>
<tr>
<td>Title:</td>
<td><input type="text" name="title" size="40" value="$page_name"></td>
</tr>
<tr>
<td>Content:</td>
<td><textarea name="message" cols="40" rows="10">$page_content</textarea></td>
</tr>
<tr>
<td colspan="2">You can include this page anywhere by linking to the following URL:<br>
<i>$cfg{pageurl}/pages.$cfg{ext}?id=$id</i></td>
<tr>
<td colspan="2"><input type="hidden" name="op" value="edit_pages2">
<input type="hidden" name="id" value="$id">
<input type="submit" name="moda" value="$btn{15}">
HTML

		if ($id ne "new") { print qq(<input type="submit" name="moda" value="$btn{16}">); }

		print <<"HTML";
</td>
</tr>
</table>
</form>
HTML
	}

	print_html($user_data{theme}, "Content Admin >>> Edit Pages", 1);
}

# ---------------------------------------------------------------------
# Update a user generated page.
# ---------------------------------------------------------------------
sub edit_pages2
{
	# Get all pages.
	my @pages;
	if (-e("$cfg{pagesdir}/pages.dat"))
	{
		sysopen(FH, "$cfg{pagesdir}/pages.dat", O_RDONLY);
		chomp(@pages = <FH>);
		close(FH);
	}

	# Modify page. 
	if ($moda eq $btn{15}) 
	{
		# Check and format input.
		user_error($err{6}, $user_data{theme}) if (!$title || !$message);

		$message = html_escape($message);

		# Create a new page.
		if ($id eq "new")
		{
			# Get ID of new page.
			opendir (DIR, "$cfg{pagesdir}");
			my @files = readdir(DIR);
			closedir (DIR);

			@files = grep(/\.txt/, @files);
			foreach (@files) { $_ =~s/\.txt//; }
			@files = reverse(sort { $a <=> $b } @files);

			my $post_num = $files[0] || 0;
			$post_num =~ s/\.txt//;
			$id = $post_num + 1;

			# Update page index.
			sysopen(FH, "$cfg{pagesdir}/pages.dat", O_WRONLY | O_APPEND | O_CREAT) or user_error("$err{16} $cfg{pagesdir}/pages.dat. ($!)", $user_data{theme});
			flock(FH, LOCK_EX) if $cfg{use_flock};

			print FH "$id|$title\n";

			close(FH);
		}

		# Modify a page.
		else
		{
			# Update page index.
			sysopen(FH, "$cfg{pagesdir}/pages.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{pagesdir}/pages.dat. ($!)", $user_data{theme});
			flock(FH, LOCK_EX) if $cfg{use_flock};

			foreach (@pages) 
			{
				my @item = split(/\|/, $_);
				if ($id == $item[0]) { print FH "$id|$title\n";	}
				else { print FH "$_\n"; }
			}

			close(FH);	
		}

		# Data integrity check.
		if ($id =~ /^([\w.]+)$/) { $id = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Update/create page content.
		sysopen(FH, "$cfg{pagesdir}/$id.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{pagesdir}/$id.txt. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH $message;

		close(FH);

		print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_pages;id=' . $id);
	}

	# Delete page. 
	if ($moda eq $btn{16}) 
	{
		# Update page index.
		sysopen(FH, "$cfg{pagesdir}/pages.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{pagesdir}/pages.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@pages) 
		{
			my @item = split(/\|/, $_);
			if ($id != $item[0]) { print FH "$_\n";	}
		}

		close(FH);

		# Remove data file.
		unlink("$cfg{pagesdir}/$id.txt");

		print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_pages');
	}
}

# ---------------------------------------------------------------------
# Edit a user generated block.
# ---------------------------------------------------------------------
sub edit_blocks 
{
	# Get all blocks.
	my @blocks;
	my ($block, $block_name, $block_pos, $checked) = '';

	if (-e("$cfg{blocksdir}/blocks.dat"))
	{
		sysopen(FH, "$cfg{blocksdir}/blocks.dat", O_RDONLY);
		chomp(@blocks = <FH>);
		close(FH);

		# Make dropdown menu with all blocks, get position and status of block.
		foreach (@blocks) 
		{
			my @item = split(/\|/, $_);
			if ($id && $id eq $item[0]) 
			{
				$block .= qq(<option value="$item[0]" selected>$item[1]</option>\n); 
				$block_name = $item[1];
				$block_pos = $item[2];
				if ($item[3]) { $checked = " checked"; }
			}
			else 
			{ 
				$block .= qq(<option value="$item[0]">$item[1]</option>\n); 
				$checked = '';
			}
		}
	}

	print_header();
	print_html($user_data{theme}, "Content Admin >>> Edit Blocks");

	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table>
<tr>
<td valign="top">Choose a block to edit: </td>
<td valign="top"><select name="id">
<option value=""></option>
$block</select>
<input type="hidden" name="op" value="edit_blocks">
<input type="submit" value="$btn{14}">
</td>
</tr>
<tr>
<td colspan="2">Or <a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_blocks;id=new">create a new block</a></td>
</tr>
</table>
</form>
<hr size="1">
HTML

	# Print links in selected category.
	if ($id) 
	{
		my @content;
		if ($id ne "new")
		{
			# Get page content.
			if (-e("$cfg{blocksdir}/$id.txt"))
			{
				sysopen(FH, "$cfg{blocksdir}/$id.txt", O_RDONLY);
				chomp(@content = <FH>);
				close(FH);
			}

		}
		else { $block_name = ''; }

		print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table>
<tr>
<td>Position of block:</td>
<td><select name="pos">
HTML

		# Make dropdown menu with possible positions.
		my @pos = ("header", "footer");

		if ($id ne "new")
		{
			foreach (@pos)
			{
				if ($block_pos eq $_) { print qq(<option value="$_" selected>$_</option>\n); }
				else { print qq(<option value="$_">$_</option>\n) }
			}
		}
		else
		{
			foreach (@pos) { print qq(<option value="$_">$_</option>\n); }
		}

		print <<"HTML";
</select>
</td>
<tr>
<td>Title:</td>
<td><input type="text" name="title" size="40" value="$block_name"></td>
</tr>
<tr>
<td>Content:</td>
<td><textarea name="message" cols="40" rows="10">
HTML

		# Print content.
		foreach (@content) { print "$_\n"; }

		print <<"HTML";
</textarea></td>
</tr>
<tr>
<td>Make block active:</td>
<td><input type="checkbox" name="status"$checked></td>
</tr>
<td colspan="2"><input type="hidden" name="op" value="edit_blocks2">
<input type="hidden" name="id" value="$id">
<input type="submit" name="moda" value="$btn{15}">
HTML

		if ($id ne "new") { print qq(<input type="submit" name="moda" value="$btn{16}">); }

		print <<"HTML";
</td>
</tr>
</table>
</form>
HTML
	}

	print_html($user_data{theme}, "Content Admin >>> Edit Blocks", 1);
}

# ---------------------------------------------------------------------
# Update a block.
# ---------------------------------------------------------------------
sub edit_blocks2
{
	# Get all blocks.
	my @blocks;
	if (-e("$cfg{blocksdir}/blocks.dat"))
	{
		sysopen(FH, "$cfg{blocksdir}/blocks.dat", O_RDONLY);
		chomp(@blocks = <FH>);
		close(FH);
	}

	# Update block. 
	if ($moda eq $btn{15}) 
	{
		# Check and format input.
		user_error($err{6}, $user_data{theme}) if (!$title || !$message || !$pos);
		if ($status eq "on" || $status == 1) { $status = 1; }
		else { $status = 0; }

		# Create a new block.
		if ($id eq "new")
		{
			# Get ID of new page.
			opendir(DIR, "$cfg{blocksdir}");
			my @files = readdir(DIR);
			closedir(DIR);

			@files = grep(/\.txt/, @files);
			foreach (@files) { $_ =~s/\.txt//; }
			@files = reverse(sort { $a <=> $b } @files);

			my $post_num = $files[0] || 0;
			$post_num =~ s/\.txt//;
			$id = $post_num + 1;

			# Update page index.
			sysopen(FH, "$cfg{blocksdir}/blocks.dat", O_WRONLY | O_APPEND | O_CREAT) or user_error("$err{16} $cfg{blocksdir}/blocks.dat. ($!)", $user_data{theme});
			flock(FH, LOCK_EX) if $cfg{use_flock};

			print FH "$id|$title|$pos|$status\n";

			close(FH);
		}

		# Modify a block.
		else
		{
			# Update page index.
			sysopen(FH, "$cfg{blocksdir}/blocks.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{blocksdir}/blocks.dat. ($!)", $user_data{theme});
			flock(FH, LOCK_EX) if $cfg{use_flock};

			foreach (@blocks) 
			{
				my @item = split(/\|/, $_);
				if ($id == $item[0]) { print FH "$id|$title|$pos|$status\n";	}
				else { print FH "$_\n"; }
			}

			close(FH);	
		}

		# Data integrity check.
		if ($id =~ /^([\w.]+)$/) { $id = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Update/create block content.
		sysopen(FH, "$cfg{blocksdir}/$id.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{blocksdir}/$id.txt. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH $message;

		close(FH);

		print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_blocks;id=' . $id);
	}

	# Delete page. 
	if ($moda eq $btn{16}) 
	{
		# Update page index.
		sysopen(FH, "$cfg{blocksdir}/blocks.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{blocksdir}/blocks.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach (@blocks) 
		{
			my @item = split(/\|/, $_);
			if ($id != $item[0]) { print FH "$_\n";	}
		}

		close(FH);

		# Data integrity check.
		if ($id =~ /^([\w.]+)$/) { $id = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Remove data file.
		unlink("$cfg{blocksdir}/$id.txt");

		print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_blocks');
	}
}

# ---------------------------------------------------------------------
# Display all quotes.
# ---------------------------------------------------------------------
sub edit_quotes 
{
	# Get all available quotes.
	my @quotes;
	if (-e "$cfg{datadir}/quotes.dat")
	{
		sysopen(FH, "$cfg{datadir}/quotes.dat", O_RDONLY);
		chomp(@quotes = <FH>);
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, "Quotes Admin");

	if (@quotes) 
	{
		my $count = @quotes;

		print <<"HTML";
<table width="100%" class="bg5" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr class="tbl_header">
<td><b>Quote</b></td>
<td><b>Date</b></td>
<td><b>Action</b></td>
HTML

		foreach (@quotes) 
		{
			my @item = split(/\|/, $_);
			print <<"HTML";
<tr class="bg2">
<td>$item[2]: <small>$item[1]</small></td>
<td>$item[4]</td>
<td>[<a href="$cfg{pageurl}/admin.$cfg{ext}?op=edit_quote;id=$item[0]">Edit</a>] [<a href="$cfg{pageurl}/admin.$cfg{ext}?op=delete_quote;id=$item[0]">Delete</a>]</td>
</tr>
HTML
		}

		print <<"HTML";
</table></td>
</tr>
</table>
<p align="right">$count quotes available.
<hr size="1">
HTML
	}

	# Print panel to create a new category.
	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td colspan="2"><b>Add Quote</b></td>
</tr>
<tr>
<td valign="top">Quote:</td>
<td><textarea name="descr" rows="5" cols="40" maxlength="250"></textarea></td>
</tr>
<tr>
<td>By:</td>
<td><input type="text" name="name" maxlength="50"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="add_quote">
<input type="submit" value="Create"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, "Quotes Admin", 1);
}

# ---------------------------------------------------------------------
# Add a quote.
# ---------------------------------------------------------------------
sub add_quote 
{
	user_error($err{21}, $user_data{theme}) unless ($name);
	user_error($err{23}, $user_data{theme}) unless ($descr);

	# Check if quote text isn't too long.
	if (length($descr) > 250) { $descr = substr($descr, 0, 250); }

	# Cut off linebreak, if any.
	chomp($name);
	chomp($descr);

	# Format input.
	$name = html_escape($name);
	$descr = html_escape($descr);

	# Get current date.
	my $date = get_date();

	my @datas;
	if (-e "$cfg{datadir}/quotes.dat")
	{
		sysopen(FH, "$cfg{datadir}/quotes.dat", O_RDONLY);
		@datas = <FH>;
		close(FH);
	}

	# Get ID of new link.
	my $qid = $datas[0];
	$qid = $qid + 1;

	# Add quote to database.
	sysopen(FH, "$cfg{datadir}/quotes.dat", O_WRONLY | O_TRUNC | O_CREAT);  
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$qid|$descr|$name|$user_data{uid}|$date\n";
	for (my $i = 0; $i < @datas; $i++) { print FH $datas[$i]; }

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_quotes');
}

# ---------------------------------------------------------------------
# Delete a quote.
# ---------------------------------------------------------------------
sub delete_quote 
{
	# Get all available quotes.
	my @quotes;
	if (-e "$cfg{datadir}/quotes.dat")
	{
		sysopen(FH, "$cfg{datadir}/quotes.dat", O_RDONLY);
		chomp(@quotes = <FH>);
		close(FH);
	}

	sysopen(FH, "$cfg{datadir}/quotes.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{datadir}/quotes.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	# Update quote database.
	for (my $i = 0; $i < @quotes; $i++) 
	{
		my @item = split(/\|/, $quotes[$i]);
		if ($item[0] != $id) { print FH "$quotes[$i]\n"; }
	}
	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_quotes');
}

# ---------------------------------------------------------------------
# Print formular to edit a quote.
# ---------------------------------------------------------------------
sub edit_quote 
{
	# Get all available quotes.
	my (@quotes, @item);
	if (-e "$cfg{datadir}/quotes.dat")
	{
		sysopen(FH, "$cfg{datadir}/quotes.dat", O_RDONLY);
		chomp(@quotes = <FH>);
		close(FH);
	}

	# Get quote data.
	for (my $i = 0; $i < @quotes; $i++) 
	{
		@item = split(/\|/, $quotes[$i]);
		if ($item[0] == $id) { last; }
	}	

	print_header();
	print_html($user_data{theme}, "Quotes Admin >>> Edit Quote");

	# Print panel to create a new category.
	print <<"HTML";
<form action="$cfg{pageurl}/admin.$cfg{ext}" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
<td valign="top">Quote:</td>
<td><textarea name="descr" rows="5" cols="40" maxlength="250">$item[1]</textarea></td>
</tr>
<tr>
<td>By:</td>
<td><input type="text" name="name" maxlength="50" value="$item[2]"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="edit_quote2">
<input type="hidden" name="id" value="$item[0]">
<input type="submit" value="Update"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, "Quotes Admin >>> Edit Quote", 1);
}

# ---------------------------------------------------------------------
# Update a quote.
# ---------------------------------------------------------------------
sub edit_quote2 
{
	user_error($err{21}, $user_data{theme}) unless ($name);
	user_error($err{23}, $user_data{theme}) unless ($descr);

	# Check if quote text isn't too long.
	if (length($descr) > 250) { $descr = substr($descr, 0, 250); }

	# Cut off linebreak, if any.
	chomp($name);
	chomp($descr);

	# Format input.
	$name = html_escape($name);
	$descr = html_escape($descr);

	# Get all available quotes.
	my @quotes;
	if (-e "$cfg{datadir}/quotes.dat")
	{
		sysopen(FH, "$cfg{datadir}/quotes.dat", O_RDONLY);
		chomp(@quotes = <FH>);
		close(FH);
	}

	sysopen(FH, "$cfg{datadir}/quotes.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{datadir}/quotes.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	# Update quote.
	for (my $i = 0; $i < @quotes; $i++) 
	{
		my ($qid, $q_text, $q_name, $q_poster, $q_date) = split(/\|/, $quotes[$i]);
		if ($qid == $id) { print FH "$qid|$descr|$name|$q_poster|$q_date\n"; }
		else { print FH "$qid|$q_text|$q_name|$q_poster|$q_date\n"; }
	}
	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/admin.' . $cfg{ext} . '?op=edit_quote;id=' . $id);
}
