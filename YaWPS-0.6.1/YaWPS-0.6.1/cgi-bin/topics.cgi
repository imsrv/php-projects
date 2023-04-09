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
# $Id: topics.cgi,v 1.10 2003/01/18 13:20:37 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $cat $id $start $article_subject $article_text $state
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$cat = $query->param('cat');
$id = $query->param('id');
$start = $query->param('start');
$article_subject = $query->param('subject');
$article_text = $query->param('message');
$state = $query->param('state');

# Get user profile.
%user_data = authenticate();

# Define possible user actions.
%user_action = (
	view_cat => \&display_cat,
	view_topic => \&display_topic,
	write_news => \&write_news,
	write_news2 => \&write_news2,
	comment_news => \&comment_news,
	notify => \&notify,
	notify2 => \&notify2,
	print_topic => \&print_topic
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { display_cats(); }

# ---------------------------------------------------------------------
# Display all topic categories.
# ---------------------------------------------------------------------
sub display_cats
{
	# Get data of all categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) || user_error("$err{1} $cfg{topicsdir}/cats.dat", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, $nav{4});

	print <<"HTML";
<table border="0" cellpadding="3" cellspacing="0" width="100%">
<tr>
<td align="center">$msg{45}</td>
</tr>
</table>
<br>
<table border="0" cellpadding="3" cellspacing="0" width="100%">
<tr>
HTML
	# Print categories.
	my $count = 0;
	for (my $i = 0; $i < @cats; $i++) 
	{
		my @item = split (/\|/, $cats[$i]);
		print qq(<td align="center" valign="bottom"><a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_cat;cat=$item[1]"><img src="$cfg{imagesurl}/topics/$item[1].gif" border="0" alt="$item[0]"></a><br>\n<b>$item[0]</b></td>\n);
		$count++;
		if ($count == 3) 
		{
			print "</tr>\n<tr>\n";
			$count = 0;
		}
	}
	print <<"HTML";
<td colspan="3"></td>
</tr>
</table>
HTML
	print_html($user_data{theme}, $nav{4}, 1);
}

# ---------------------------------------------------------------------
# Display a topic category.
# ---------------------------------------------------------------------
sub display_cat 
{
	# Get data of all categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) || user_error("$err{1} $cfg{topicsdir}/cats.dat", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	# Get name of category.
	my $curcatname;
	foreach my $curcat (@cats) 
	{
		my @item = split(/\|/, $curcat);
		if ($cat eq $item[1]) { $curcatname = $item[0]; }
	}

	print_header();
	print_html($user_data{theme}, "$nav{4} >>> $curcatname");

	print <<"HTML";
<table align="center" border="0" cellpadding="3" cellspacing="0">
<tr>
<td align="center"><b>$msg{46} "$curcatname"</b></td>
</tr>
</table>
<br>
HTML
	# Get topics data in this category.
	if (-e("$cfg{topicsdir}/$cat.cat")) 
	{
		sysopen(FH, "$cfg{topicsdir}/$cat.cat", O_RDONLY);
		chomp(my @datas = <FH>);
		close(FH);

		print qq(<table border="0" cellpadding="1" cellspacing="0" width="100%">);

		# Initialize page navigation.
		if (!$start) { $start = 0; }

		# Cycle through category and display all entries.
		my $num_shown = 0;
		for (my $i = $start; $i < @datas; $i++) 
		{
			my ($num, $title, $poster, $user, $email, $date, $comments, $views) = split(/\|/, $datas[$i]);
			
			if (!$views) { $views = 0; }

			# Comments counter format.
			my $comments_count;
			if ($comments == 1) { $comments_count = 1 . " " . $msg{40}; }
			elsif ($comments == -1) { $comments_count = 0 . " " . $msg{41}; }
			else { $comments_count = $comments . " " . $msg{41}; }

			print <<"HTML";
<tr>
<td><img src="$cfg{imagesurl}/urlgo.gif" border="0" alt="">&nbsp;&nbsp;<a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cat;id=$num">$title</a></td>
</tr>
<tr>
<td>$msg{47} $poster $msg{48} $date</td>
</tr>
<tr>
<td>$curcatname ($views $msg{191}, $comments_count)</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
HTML

		$num_shown++;
		if ($num_shown >= $cfg{max_items_per_page}) { $i = @datas; }
		}

		print "</table>";

		# Make jumpbar.
		if ($num_shown >= $cfg{max_items_per_page}) 
		{
			print qq(<hr noshade="noshade" size="1">\n$msg{39} );
			my $num_topics = @datas;
			my $count = 0;

			while (($count * $cfg{max_items_per_page}) < $num_topics) 
			{
				my $viewc = $count + 1;
				my $strt = ($count * $cfg{max_items_per_page});
				if ($start == $strt) { print "[$viewc] "; }
				elsif ($strt == 0) { print qq(<a href="$cfg{pageurl}/topics.$cfg{ext}">$viewc</a> ); }
				else { print qq(<a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_cat;cat=$cat;start=$strt">$viewc</a> ); }
				$count++;
			}
		}
	}

	print qq(<center><a href="$cfg{pageurl}/topics.$cfg{ext}?op=notify;cat=$cat">Subscribe to this category</a></center>);

	print_html($user_data{theme}, "$nav{4} >>> $curcatname", 1);
}

# ---------------------------------------------------------------------
# Display a topic.
# ---------------------------------------------------------------------
sub display_topic
{
	if ($id !~ /^[0-9]+$/) { user_error($err{6}); }

	# Get data of all categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) || user_error("$err{1} $cfg{topicsdir}/cats.dat", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	my (@cat_names, @cat_links, $curcat_name, $curcat_link, $comments_count);
	foreach my $curcat (@cats) 
	{
		my @item = split(/\|/, $curcat);
		push(@cat_names, $item[0]);
		push(@cat_links, $item[1]);
	}

	foreach my $curcat (@cat_links) 
	{
		if (-e("$cfg{topicsdir}/$curcat.cat")) 
		{
			sysopen(FH, "$cfg{topicsdir}/$curcat.cat", O_RDONLY);
			chomp(my @articles = <FH>);
			close(FH);

			# Data integrity check.
			if ($curcat =~ /^([\w.]+)$/) { $curcat = $1; } 
			else { user_error($err{6}, $user_data{theme}); }

			sysopen(FH, "$cfg{topicsdir}/$curcat.cat", O_WRONLY | O_TRUNC | O_CREAT) || user_error("$err{16} $cfg{topicsdir}/$curcat.cat", $user_data{theme});
			flock(FH, LOCK_EX) if $cfg{use_flock};

			# Increment view counter for this topic.
			for (my $i = 0; $i < @articles; $i++) 
			{
				my ($num, $subject, $nick, $poster, $email, $postdate, $comments, $views) = split(/\|/, $articles[$i]);
				if ($id eq $num) 
				{
					$views++;
					print FH "$num|$subject|$nick|$poster|$email|$postdate|$comments|$views\n";
				}
				else { print FH "$num|$subject|$nick|$poster|$email|$postdate|$comments|$views\n"; }
			}

			close(FH);

			# Get refreshed topic data.
			sysopen(FH, "$cfg{topicsdir}/$curcat.cat", O_RDONLY);
			chomp(@articles = <FH>);
			close(FH);

			for (my $i = 0; $i < @articles; $i++) 
			{
				my ($num, $comments, $views);
				($num, undef, undef, undef, undef, undef, $comments, $views) = split(/\|/, $articles[$i]);
				if ($id eq $num) 
				{
					foreach my $topic (@cats) 
					{
						my @item = split(/\|/, $topic);
						if ($curcat eq $item[1]) 
						{ 
							$curcat_name = $item[0]; 
							$curcat_link = $item[1];
						}
					}
					if ($comments == 1) { $comments_count = $comments . " " . $msg{40}; }
					else { $comments_count = $comments . " " . $msg{41}; }
				}
			}
		}
	}

	# Get topic data.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_RDONLY) || user_error("$err{1} $cfg{articledir}/$id.txt");
	chomp(my @topic_data = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{4} >>> $curcat_name");

	my $post_count;
	foreach my $line (@topic_data) { $post_count++; }

	# Print the article.
	for (my $i = 0; $i < 1; $i++) 
	{
		my @item = split (/\|/, $topic_data[$i]);

		my $message = $item[5];
		$message = do_ubbc($message);

		print <<"HTML";
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="texttitle">$item[0]</td>
</tr>
<tr>
<td class="textsmall">$curcat_name: $item[4] $msg{42} <a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$item[2]">$item[1]</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td valign="top"><img src="$cfg{imagesurl}/topics/$curcat_link.gif" border="0" align="right" vspace="5" alt="$curcat_name">
$message</td>
</tr>
</table>
<br>
<div align="right">[<a href="$cfg{pageurl}/topics.$cfg{ext}?op=print_topic;cat=$curcat_link;id=$id" target="_blank">$msg{190}</a>]</div>
HTML
	}
	if ($post_count > 1) 
	{ 
		print qq(<p align="center" class="cat">$msg{158}\n<p>$msg{159});

		# Print the comments.
		for (my $i = 1; $i < @topic_data; $i++) 
		{
			my @item = split (/\|/, $topic_data[$i]);

			my $message = $item[5];
			$message = do_ubbc($message);

			if (@item == 0) { }
			else {
				print <<"HTML";
<hr noshade="noshade" size="1">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="texttitle">$item[0]</td>
</tr>
<tr>
<td class="textsmall">$item[4] $msg{42} <a href="mailto:$item[3]">$item[1]</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td valign="top">$message</td>
</tr>
</table>
HTML
			}
		}
	}
	else { print qq(<p align="center" class="cat">$msg{158}\n<p>$msg{43}); }

	# Print the comment post box.
	if ($user_data{uid} ne $usr{anonuser}) 
	{
		print <<"HTML";
<hr noshade="noshade" size="1">
<form action="$cfg{pageurl}/topics.$cfg{ext}" method="post" name="creator">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" colspan="2" class="cat">$msg{44}</td>
</tr>
<tr>
<td><b>$msg{13}</b></td>
<td>$user_data{uid}<input type="hidden" name="name" value="$user_data{uid}"><input type="hidden" name="email" value="$user_data{email}"></td>
</tr>
<tr>
<td><b>$msg{37}</b></td>
<td><input type="text" name="subject" size="40" maxlength="50"></td>
</tr>
<tr>
<td><b>$msg{38}</b></td>
<td><script language="javascript" type="text/javascript">
<!--
function addCode(anystr) { document.creator.message.value+=anystr; } 
function showColor(color) { document.creator.message.value+="[color="+color+"][/color]"; }
// -->
</script>
<textarea name="message" rows="10" cols="40"></textarea></td>
</tr>
<tr>
<td><b>$msg{'156'}</b></td>
<td valign="top">
HTML

		# Print the UBBC panel.
		my $ubbc_panel = print_ubbc_panel();
		print $ubbc_panel;

		print <<"HTML";
</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="comment_news">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="cat" value="$curcat_link">
<input type="submit" value="$btn{12}">
<input type="reset" value="$btn{9}"></td>
</tr>
</table>
</form>
HTML
	}

	print_html($user_data{theme}, "$nav{4} >>> $curcat_name", 1);
}

# ---------------------------------------------------------------------
# Display a forular to write news.
# ---------------------------------------------------------------------
sub write_news
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser} || $cfg{enable_user_articles} == 0 && $user_data{uid} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	print_header();
	print_html($user_data{theme}, $nav{23});

	print <<"HTML";
<form action="$cfg{pageurl}/topics.$cfg{ext}" method="post" name="creator">
<table border="0" cellspacing="1">
<tr>
<td><b>$msg{13}</b></td>
<td>$user_data{uid}</td>
</tr>
<tr>
<td><b>$msg{7}</b></td>
<td>$user_data{email}</td>
</tr>
<tr>
<td><b>$msg{34}</b></td>
<td><select name="cat">
HTML

	# Get categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY);
	chomp(my @cats = <FH>);
	close(FH);

	# Print list of available categories
	foreach (@cats) 
	{
		my @item = split(/\|/, $_);

		print qq(<option value="$item[1]">$item[0]</option>\n);
	}

	print <<"HTML";
</select></td>
</tr>
<tr>
<td><b>$msg{37}</b></td>
<td><input type="text" name="subject" size="40" maxlength="50"></td>
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
<textarea name="message" rows="10" cols="40"></textarea></td>
</tr>
<tr>
<td><b>$msg{'156'}</b></td>
<td valign="top">
HTML

	# Print the UBBC panel.
	my $ubbc_panel = print_ubbc_panel();
	print $ubbc_panel;

	# Check if news should be verified by admins.
	my $approved = 0;
	if ($user_data{sec_level} eq $usr{admin}) { $approved = 1; }

	print <<"HTML";
</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="write_news2">
<input type="hidden" name="approved" value="$approved">
<input type="submit" value="$btn{8}">
<input type="reset" value="$btn{9}"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, $nav{23}, 1);
}

# ---------------------------------------------------------------------
# Add news.
# ---------------------------------------------------------------------
sub write_news2
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser} || $cfg{enable_user_articles} == 0 && $user_data{uid} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }
	user_error($err{14}, $user_data{theme}) unless ($article_subject);
	user_error($err{15}, $user_data{theme}) unless ($article_text);

	# Get all available articles.
	opendir(DIR, "$cfg{topicsdir}/articles");
	my @files = readdir(DIR);
	closedir(DIR);

	@files = grep(/\.txt/, @files);
	foreach (@files) { $_ =~s/\.txt//; }
	@files = reverse(sort { $a <=> $b } @files);

	# Get ID of new article.
	my $mid = $files[0] || 0;
	if ($mid) { $mid =~ s/\.txt//; }
	$mid++;

	# Format input.
	chomp($article_subject);
	chomp($article_text);
	$article_subject = html_escape($article_subject);
	$article_text = html_escape($article_text);

	# Get date.
	my $date = get_date();

	# Make article viewable to public.
	if ($user_data{sec_level} eq $usr{admin}) 
	{
		my @articles;
		if (-e("$cfg{topicsdir}/$cat.cat"))
		{
			sysopen(FH, "$cfg{topicsdir}/$cat.cat", O_RDONLY);
			@articles = <FH>;
			close (FH);
		}

		# Data integrity check.
		if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		if ($mid =~ /^([\w.]+)$/) { $mid = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Save headline to category database.
		sysopen(FH, "$cfg{topicsdir}/$cat.cat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{1} $cfg{topicsdir}/$cat.cat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH "$mid|$article_subject|$user_data{nick}|$user_data{uid}|$user_data{email}|$date|0|0\n";
		print FH @articles;

		close(FH);

		# Save article text.
		sysopen(FH, "$cfg{articledir}/$mid.txt", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{articledir}/$mid.txt. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH "$article_subject|$user_data{nick}|$user_data{uid}|$user_data{email}|$date|$article_text\n";

		close(FH);

		# Update article count for user.
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
		chomp(my @user_profile = <FH>);
		close(FH);

		$user_profile[11]++;

		# Data integrity check.
		if ($user_data{uid} =~ /^([\w.]+)$/) { $user_data{uid} = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_WRONLY | O_TRUNC);
		flock(FH, LOCK_EX) if $cfg{use_flock};

		for (my $i = 0; $i < @user_profile; $i++) { print FH "$user_profile[$i]\n"; }

		close(FH);

		# Export to RDF-file.
		rdf_export();

		# Notify users, who are watching this category.
		if (-e "$cfg{topicsdir}/$cat.mail") { notify_users($cat, "$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cat;id=$mid"); }
	}
	# Store article in the pending articles database.
	else 
	{
		# Get all available pending articles.
		my @articles;
		my $num = 1;
		if (-e("$cfg{topicsdir}/newarticles.dat"))
		{
			sysopen(FH, "$cfg{topicsdir}/newarticles.dat", O_RDONLY);
			@articles = <FH>;
			close (FH);

			# Get ID for the new article.
			if (@articles) 
			{ 
				($num, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $articles[0]); 
				$num++;
			}
		}

		# Update pending article datavbase.
		sysopen(FH, "$cfg{topicsdir}/newarticles.dat", O_WRONLY | O_TRUNC | O_CREAT);
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH "$num|$cat|$article_subject|$user_data{nick}|$user_data{uid}|$user_data{email}|$date|$article_text\n";
		print FH @articles;

		close(FH);
	}

	# Print success info.
	print_header();
	print_html($user_data{theme}, $nav{4});

	print "<b>" . $nav{27}. "</b><br>\n" . $inf{9};

	print_html($user_data{theme}, $nav{23}, 1);
}

# ---------------------------------------------------------------------
# Add comments.
# ---------------------------------------------------------------------
sub comment_news 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }
	user_error($err{14}, $user_data{theme}) unless ($article_subject);
	user_error($err{15}, $user_data{theme}) unless ($article_text);

	sysopen(FH, "$cfg{topicsdir}/$cat.cat", O_RDONLY) || error("$err{1} $cfg{topicsdir}/$cat.dat", $user_data{theme});
	chomp(my @datas = <FH>);
	close(FH);

	# Format input.
	chomp($article_subject);
	chomp($article_text);
	$article_subject = html_escape($article_subject);
	$article_text = html_escape($article_text);

	# Get date.
	my $date = get_date();

	# Data integrity check.
	if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update category database.
	sysopen(FH, "$cfg{topicsdir}/$cat.cat", O_WRONLY | O_TRUNC | O_CREAT) || error("$err{16} $cfg{topicsdir}/$cat.dat", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @datas; $i++) 
	{
		my ($mid, $subject, $nick, $poster, $email, $postdate, $comments, $views) = split(/\|/, $datas[$i]);

		if ($mid eq $id) 
		{
			$comments++;
			print FH "$mid|$subject|$nick|$poster|$email|$postdate|$comments|$views\n";
		}
		else { print FH "$mid|$subject|$nick|$poster|$email|$postdate|$comments|$views\n"; }
	}

	close(FH);

	# Data integrity check.
	if ($id =~ /^([\w.]+)$/) { $id = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Save comment to article database.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_WRONLY | O_APPEND | O_CREAT) || error("$err{16} $cfg{articledir}/$id.txt", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$article_subject|$user_data{nick}|$user_data{uid}|$user_data{email}|$date|$article_text\n";

	close(FH);

	# Update user's comments count.
	sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
	chomp(my @user_profile= <FH>);
	close(FH);

	$user_profile[12]++;

	# Data integrity check.
	if ($user_data{uid} =~ /^([\w.]+)$/) { $user_data{uid} = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_WRONLY | O_TRUNC);
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @user_profile; $i++) { print FH "$user_profile[$i]\n"; }

	close(FH);
	
	print $query->redirect(-location=>$cfg{pageurl} . '/topics.' . $cfg{ext} . '?op=view_topic;cat=' . $cat . ';id=' . $id);
}

# ---------------------------------------------------------------------
# Print formular to subscribe/unsubscribe to a news category notifier.
# ---------------------------------------------------------------------
sub notify 
{
	# Check if user has permissions to access this area.
	if ($user_data{sec_level} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get list of user's watching this category.
	my (@mails, $subscribed);
	if (-e "$cfg{topicsdir}/$cat.mail")
	{
		sysopen(FH, "$cfg{topicsdir}/$cat.mail", O_RDONLY);
		chomp(@mails = <FH>);
		close(FH);

		# Check if user has subscribed to this thread.
		foreach my $i (@mails) 
		{
			if ($user_data{email} eq $i) { $subscribed = 1; }
			else { $subscribed = 0; }
		}
	}

	# Get data of all categories.
	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY) || user_error("$err{1} $cfg{topicsdir}/cats.dat", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	# Get name of category.
	my $curcatname;
	foreach my $curcat (@cats) 
	{
		my @item = split(/\|/, $curcat);
		if ($cat eq $item[1]) { $curcatname = $item[0]; }
	}

	print_header();
	print_html($user_data{theme}, "$nav{3} >>> $curcatname");

	# Print user actions.
	if ($subscribed) { print qq($msg{155}<br>\n<b><a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_cat;cat=$cat">$nav{47}</a> - <a href="$cfg{pageurl}/topics.$cfg{ext}?op=notify2;cat=$cat;state=0">$nav{48}</a></b>); }
	else { print qq($msg{155}<br>\n<b><a href="$cfg{pageurl}/topics.$cfg{ext}?op=notify2;cat=$cat;state=1">$nav{47}</a> - <a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_cat;cat=$cat">$nav{48}</a></b>); }

	print_html($user_data{theme}, "$nav{3} >>> $curcatname", 1);
}

# ---------------------------------------------------------------------
# Update news notification.
# ---------------------------------------------------------------------
sub notify2 
{
	# Check if user has permissions to access this area.
	if ($user_data{sec_level} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get list of user's watching this category.
	my @mails;
	if (-e "$cfg{topicsdir}/$cat.mail")
	{
		sysopen(FH, "$cfg{topicsdir}/$cat.mail", O_RDONLY);
		chomp(@mails = <FH>);
		close(FH);
	};

	# Data integrity check.
	if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update subscriber list.
	sysopen(FH, "$cfg{topicsdir}/$cat.mail", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{topicsdir}/$cat.mail. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	if ($state) { print FH "$user_data{email}\n"; }
	foreach my $i (@mails) 
	{
		if($user_data{email} ne $i) { print FH "$i\n"; }
	}
	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/topics.' . $cfg{ext} . '?op=view_cat;cat=' . $cat);
}

# ---------------------------------------------------------------------
# Send notification email to subscribed users.
# ---------------------------------------------------------------------
sub notify_users 
{
	my ($watch_cat, $link) = @_;

	# Get list of users watching this topic.
	if (-e "$cfg{topicsdir}/$watch_cat.mail")
	{
		sysopen(FH, "$cfg{topicsdir}/$watch_cat.mail", O_RDONLY);
		chomp(my @mails = <FH>);
		close(FH);

		my $subject = $cfg{pagename} . " " . $msg{196};
		my $message = $inf{20} . $link;

		# Send the email to recipients.
		foreach (@mails) { send_email($cfg{webmaster_email}, $_, $subject, $message); }
	}
}

# ---------------------------------------------------------------------
# Display a printerfriendly version of an article.
# ---------------------------------------------------------------------
sub print_topic 
{
	# Get article data.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_RDONLY) or fatal_error("$err{1} $cfg{articledir}/$id.txt. ($!)", $user_data{theme});
	chomp(my @datas = <FH>);
	close(FH);

	my ($title, $nick, $username, $email, $date, $message) = split(/\|/, $datas[0]);

	# Format text.
	$message = do_ubbc($message);

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
<h3>$title</h3>
<b>$msg{47} $nick ($date)</b><br>
<p>$message</p>
HTML
	if ($datas[1] ne '') { print qq(<p align="center"><b>$msg{158}</b></p>); }

	# Print the comments.
	for (my $i = 1; $i < @datas; $i++) 
	{
		my @item = split (/\|/, $datas[$i]);

		$item[5] = do_ubbc($item[5]);

		print <<"HTML";
<hr size="1" width="100%">
<h3>$item[0]</h3>
<b>$msg{47} $item[1] ($item[4])</b><br>
<p>$item[5]</p>
HTML
	}

	print "</body>\n</html>\n";
}
