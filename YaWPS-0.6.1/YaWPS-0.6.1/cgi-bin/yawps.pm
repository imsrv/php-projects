package yawps;
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
# $Id: yawps.pm,v 1.16 2003/01/18 13:21:21 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use diagnostics;
use Carp;
use CGI qw(:standard);
use Fcntl qw(:DEFAULT :flock);

# Clean up the environment.
delete @ENV { qw(IFS CDPATH ENV BASH_ENV) }; 

# Try to avoid DoS attacks.
$CGI::POST_MAX = 1024 * 100;
$CGI::DISABLE_UPLOADS = 1;

# Kill redundant headers.
$CGI::HEADERS_ONCE = 1;

BEGIN 
{
	# Figure out how to exit.
	use constant IS_MODPERL => $ENV{MOD_PERL};
	use subs qw(exit);
	*exit = IS_MODPERL ? \&Apache::exit : sub { CORE::exit };

	# Catch fatal errors.
	$SIG{__DIE__} = \&fatal_error;

	# Initialize global variables.
	use vars qw(
		$VERSION @ISA @EXPORT 
		%cfg %usr %err %msg %btn %nav %inf %hlp %months %week_days
	);

	# Read YaWPS configuration variables.
	require "yawpsrc.pl";

	# Load the language library.
	my $lang_lib = "$cfg{langdir}/$cfg{lang}.pl";
	if ($lang_lib =~ /^([\w.]+)$/) { $lang_lib = $1; } 
	require "$lang_lib";

	# Export global YaWPS routines and variables.
	require Exporter;
	require AutoLoader;

	$VERSION = 0.61;

	@ISA = qw(Exporter AutoLoader);
	@EXPORT = qw(
		authenticate 
		print_header 
		print_html 
		get_date 
		calc_time_diff
		user_error 
		fatal_error 
		print_ubbc_panel 
		print_ubbc_image_selector
		do_ubbc html_escape 
		html_to_text 
		send_email 
		rdf_export 
		read_forum_log 
		write_forum_log 
		$VERSION %cfg %usr %err %msg %btn %nav %inf %hlp %months %week_days 
		LOCK_EX O_RDONLY O_WRONLY O_RDWR O_CREAT O_EXCL O_APPEND O_TRUNC O_NONBLOCK 
	);
}

# Create a new CGI object.
my $query = new CGI;

# Get user profile.
my %user_data = authenticate();

# Load user theme.
if ($user_data{theme} =~ /^([\w.]+)$/) { $user_data{theme} = $1; } 
require "$cfg{themesdir}/$user_data{theme}/theme.pl";

# Check if the installer has been deleted.
if (-e "$cfg{scriptdir}/installer.$cfg{ext}") { croak "The installer (installer.$cfg{ext}) is still present. YaWPS will not run until this file is removed!"; }

# ---------------------------------------------------------------------
# Check if user is logged on.
# ---------------------------------------------------------------------
sub authenticate
{
	# Check cookie and get status of user.
	my $uid = $query->cookie('yawps_uid') || '';
	my $pwd = $query->cookie('yawps_pwd') || '';

	# If user isn't logged in.
	unless ($uid && $pwd)
	{
		%user_data = (
			uid => $usr{anonuser},
			pwd => "",
			nick => $usr{anonuser},
			email => "",
			website => "",
			website_url => "",
			signature => "",
			forum_posts => "",
			sec_level => "",
			icq => "",
			pic => "",
			joined => "",
			topic_posts => "",
			comments => "",
			theme => "standard"
		);

		# Check bans.
		check_ban($user_data{uid}, '');

		return %user_data;
	}

	# Data integrity check.
	if ($uid =~ /^([\w.]+)$/) { $uid = $1; } 
	else { croak "Unsafe data in $cfg{memberdir}/$uid.dat detected"; }

	# Otherwise get user's data.
	sysopen(FH, "$cfg{memberdir}/$uid.dat", O_RDONLY) or croak "Cannot find userdata for requested account $uid";
	chomp(my @user_data = <FH>);
	close(FH);

	my $sec_level = $user_data[7];
	if ($user_data[7] eq '') { $sec_level = 'user'; }

	%user_data = (
		uid => $uid,
		pwd => $user_data[0],
		nick => $user_data[1],
		email => $user_data[2],
		website => $user_data[3],
		website_url => $user_data[4],
		signature => $user_data[5],
		forum_posts => $user_data[6],
		sec_level => $sec_level,
		icq => $user_data[8],
		pic => $user_data[9],
		joined => $user_data[10],
		topic_posts => $user_data[11],
		comments => $user_data[12],
		theme => $user_data[13]
	);

	# Check password.
	if ($pwd ne $user_data{pwd}) { croak "User data mismatch for account $uid"; }

	# Check bans.
	check_ban($user_data{uid}, $user_data{email});

	return %user_data;
}

# ---------------------------------------------------------------------
# Print the HTTP header.
# ---------------------------------------------------------------------
sub print_header
{
	my $cookie = shift;

	if ($cookie) { print $query->header(-cookie=>$cookie, -expires=>'now', -charset=>$cfg{codepage}); }
	else { print $query->header(-expires=>'now', -charset=>$cfg{codepage}); }
}

# ---------------------------------------------------------------------
# Print the HTML template.
# ---------------------------------------------------------------------
sub print_html
{
	my ($theme, $location, $type) = @_;

	# Header functions.
	if (!$type)
	{
		# Log visitors.
		log_visitors();

		# Build access log.
		access_log();
	}

	# Print the header.
	if (!$type) { theme_top($location); }
	# Print the footer.
	if ($type) { theme_bottom($location); }
}

# ---------------------------------------------------------------------
# Print Main menu and get installed modules.
# ---------------------------------------------------------------------
sub main_menu
{
	my $main_menu = box_header($nav{38});

	$main_menu .= menu_item("$cfg{pageurl}/index.$cfg{ext}", $nav{2});
	$main_menu .= menu_item("$cfg{pageurl}/forum.$cfg{ext}", $nav{3});
	$main_menu .= menu_item("$cfg{pageurl}/topics.$cfg{ext}", $nav{4});
	$main_menu .= menu_item("$cfg{pageurl}/links.$cfg{ext}", $nav{5});
	$main_menu .= menu_item("$cfg{pageurl}/stats.$cfg{ext}", $nav{6});
	$main_menu .= menu_item("$cfg{pageurl}/top10.$cfg{ext}", $nav{7});
	$main_menu .= menu_item("$cfg{pageurl}/recommend.$cfg{ext}", $nav{8});

	# Get list of installed modules.
	opendir(DIR, "$cfg{modulesdir}");
	my @modules = readdir(DIR);
	closedir(DIR);

	foreach (sort @modules) 
	{
		next if m/^\.{1,2}$/;

		my ($module_name, $extension) = split (/\./, $_);
		if (!$extension) { $main_menu .= menu_item("$cfg{modulesurl}/$module_name/index.$cfg{ext}", $module_name); }
	}

	$main_menu .= box_footer();

	return $main_menu;
}

# ---------------------------------------------------------------------
# Display a box with actions, depending on user's permissions.
# ---------------------------------------------------------------------
sub user_panel 
{
	# Get help topic.
	my $script_name = $ENV{SCRIPT_NAME};
	$script_name =~ s(^.*/)();
	my ($topic, $ext) = split (/\./, $script_name);

	my $user_panel = box_header("$msg{160} $cfg{pagename}");

	# Print help link.
	$user_panel .= menu_item("$cfg{pageurl}/help.$cfg{ext}?topic=$topic", $nav{10});

	# Print register link for guests only.
	if ($user_data{uid} eq $usr{anonuser}) { $user_panel .= menu_item("$cfg{pageurl}/register.$cfg{ext}", $nav{11}); }

	# Print special actions.
	if ($user_data{uid} ne $usr{anonuser}) 
	{ 
		$user_panel .= menu_item("$cfg{pageurl}/user.$cfg{ext}?op=edit_profile;username=$user_data{uid}", $nav{16});
		$user_panel .= menu_item("$cfg{pageurl}/memberlist.$cfg{ext}", $nav{19});
		if ($cfg{enable_user_articles} == 1) { $user_panel .= menu_item("$cfg{pageurl}/topics.$cfg{ext}?op=write_news", $nav{23}); }
	}

	# Print admin link if user is authorized.
	if ($user_data{sec_level} eq $usr{admin}) { $user_panel .= menu_item("$cfg{pageurl}/admin.$cfg{ext}", $nav{42}); }

	# Print logout or login link, depending on status.
	if ($user_data{uid} eq $usr{anonuser}) { $user_panel .= menu_item("$cfg{pageurl}/login.$cfg{ext}", $nav{12}); }
	else { $user_panel .= menu_item("$cfg{pageurl}/login.$cfg{ext}?op=logout", $nav{34}); }

	$user_panel .= box_footer();

	return $user_panel;
}

# ---------------------------------------------------------------------
# Display a box with current user status.
# ---------------------------------------------------------------------
sub user_status 
{ 
	my $guests = 0;
	my $users = 0;

	# Get visitor log.
	my @log;
	if (-e "$cfg{datadir}/log.dat")
	{
		sysopen(FH, "$cfg{datadir}/log.dat", O_RDONLY);
		chomp(@log = <FH>);
		close(FH);
	}

	foreach my $i (@log) 
	{
		my ($name, $value) = split(/\|/, $i);
		if ($name =~ /\./) { $guests++ }
		else { $users++ }
	}

	my $user_status = box_header($nav{40});

	# Show login information, depending on user status.
	if ($user_data{uid} ne $usr{anonuser}) 
	{
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_RDONLY);
		chomp(my @user_data = <FH>);
		close(FH);

		# Get number of instant messages.
		my $instant_messages_count = 0;
		if ($user_data{uid} ne $usr{anonuser}) 
		{ 
			my @instant_messages;
			if (-e "$cfg{memberdir}/$user_data{uid}.msg")
			{
				sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_RDONLY);
				chomp(@instant_messages = <FH>); 
				close(FH);

			}

			$instant_messages_count = @instant_messages; 
		}

		$user_status .= <<"HTML";
<tr>
<td class="cat">$msg{2} '$user_data[1]'</td>
</tr>
<tr>
<td class="cat">$msg{3} <a href="$cfg{pageurl}/instant_messenger.$cfg{ext}" class="menu">$instant_messages_count</a></td>
</tr>
HTML
	}

	# Show online users and guests.
	$user_status .= <<"HTML";
<tr>
<td class="cat">$msg{4} $guests<br>
$msg{5} $users</td>
</tr>
HTML

	$user_status .= box_footer();

	return $user_status;
}

# ---------------------------------------------------------------------
# Display a box with current poll.
# ---------------------------------------------------------------------
sub current_poll
{
	# Get all polls.
	my @polls;
	my ($id, $name);
	if (-e "$cfg{datadir}/polls/polls.txt")
	{
		sysopen(FH, "$cfg{datadir}/polls/polls.txt", O_RDONLY);
		chomp(@polls = <FH>);
		close(FH);

		($id, $name) = split(/\|/, $polls[0]);
	}

	my $current_poll = box_header($nav{41});

	if (@polls == 0) { $current_poll .= qq(<tr>\n<td align="center" class="cat">$msg{153}</td>\n</tr>); }
	else 
	{
		$current_poll .= qq(<tr>\n<td class="cat">\n);

		# Get current poll data.
		my $file = $id . "_q.dat";
		sysopen(FH, "$cfg{datadir}/polls/$file", O_RDONLY);
		chomp(my @poll_data = <FH>);
		close(FH);

		$current_poll .= <<"HTML";
<form action="$cfg{pageurl}/polls.$cfg{ext}" method="post">
<table>
<tr>
<td align="center" class="cat">$name</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
HTML
		# Print all possible questions.
		for (my $i = 0; $i < @poll_data; $i++) 
		{
			$current_poll .= <<"HTML";
<tr>
<td valign="top" class="cat"><input type="radio" name="answer" value="$i">$poll_data[$i]</td>
</tr>
HTML
		}

		$current_poll .= <<"HTML";
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center"><input type="hidden" name="op" value="do_vote">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="submitted" value="1">
<input type="submit" value="$btn{2}"><br>
<div class="cat"><a href="$cfg{pageurl}/polls.$cfg{ext}?op=view_poll;id=$id" class="menu">$nav{13}</a></div></td>
</tr>
</table>
</form>
</td>
</tr>
HTML
	}

	$current_poll .= box_footer();

	return $current_poll
}

# ---------------------------------------------------------------------
# Display a box with latest forum posts.
# ---------------------------------------------------------------------
sub latest_forum_posts 
{
	# Get post data.
	my (@cats, @posts, @data, @sorted_posts, $latest_forum_posts);

	if (-e "$cfg{boardsdir}/cats.txt")
	{
		sysopen(FH, "$cfg{boardsdir}/cats.txt", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	}

	# Cycle through the categories.
	foreach my $cat (@cats) 
	{
		my @cat_info;
		if (-e "$cfg{boardsdir}/$cat.cat")
		{
			sysopen(FH, "$cfg{boardsdir}/$cat.cat", O_RDONLY);
			chomp(@cat_info = <FH>);
			close(FH);
		}

		foreach my $board (@cat_info) 
		{
			if ($board ne $cat_info[0]) 
			{
				# Check if board is private.
				next if ($cat_info[1] && $user_data{sec_level} ne $usr{admin} && $user_data{sec_level} ne $cat_info[1]);

				if (-e "$cfg{boardsdir}/$board.txt")
				{
					sysopen(FH, "$cfg{boardsdir}/$board.txt", O_RDONLY);
					chomp(my @messages = <FH>);
					close(FH);

					for (my $i = 0; $i < @messages; $i++) 
					{
						my ($num, $subject, $postdate, $replies);
						($num, $subject, undef, undef, undef, $postdate, $replies, undef, undef, undef, undef) = split(/\|/, $messages[$i]);

						# Format time for sorting.
						my ($date, $time) = split(/ - /, $postdate);
						my ($day, $month, $year) = split(/\//, $date);
						my ($hour, $min, $sec) = split (/:/, $time);
						my $formatted_date = $year . $month . $day . $hour . $min . $sec;

						push (@posts, join ("\|", $num, $board, $subject, $formatted_date, $replies));
					}
				}
			}
		}
	}

	for (0 .. $#posts) 
	{
		my @fields = split(/\|/, $posts[$_]);
		for my $i (0 .. $#fields) { $data[$_][$i] = $fields[$i]; }
	}

	# Sort the posts.
	my @sorted = reverse sort { $a->[3] <=> $b->[3] } @data;
	for (@sorted) 
	{ 
		my $sorted_row = join ("|", @$_);
		push (@sorted_posts, $sorted_row);
	}

	# Get the latest posts.
	$latest_forum_posts = box_header($nav{53});

	if (!@sorted_posts) { $latest_forum_posts .= qq(<tr>\n<td>&nbsp;</td>\n</tr>\n); }
	for (my $i = 0; $i < @sorted_posts && $i < 5; $i++) 
	{
		my ($num, $board, $subject, undef, $replies) = split(/\|/, $sorted_posts[$i]);

		# Get last page's start post in this topic.
		my ($count, $strt) = 0;
		while ($count * $cfg{max_items_per_page} < $replies + 1) 
		{
			$strt = $count * $cfg{max_items_per_page};
			$count++;
		}

		$latest_forum_posts .= menu_item("$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$board;thread=$num;start=$strt#$replies", $subject);
	}

	$latest_forum_posts .= box_footer();

	return $latest_forum_posts;
}

# ---------------------------------------------------------------------
# Print user defined blocks.
# ---------------------------------------------------------------------
sub show_blocks
{
	my $position = shift;

	# Get all available blocks.
	my @blocks;
	if (-e "$cfg{blocksdir}/blocks.dat")
	{
		sysopen(FH, "$cfg{blocksdir}/blocks.dat", O_RDONLY);
		chomp(@blocks = <FH>);
		close(FH);
	}

	# Print links to the pages.
	my $blocks;
	foreach (@blocks)
	{
		my ($id, $name, $type, $active) = split(/\|/, $_);

		# Check which blocks to get.
		if ($position eq $type && $active)
		{
			# Get block data.
			my @block_data;
			if (-e "$cfg{blocksdir}/$id.txt")
			{
				sysopen(FH, "$cfg{blocksdir}/$id.txt", O_RDONLY);
				@block_data = <FH>;
				close(FH);
			}

			# Print block.
			$blocks .= box_header($name);
			foreach my $i (@block_data) { $blocks .=  $i;}
			$blocks .= box_footer();
		}
	}

	return $blocks;
}

# ---------------------------------------------------------------------
# Print a random quote.
# ---------------------------------------------------------------------
sub show_quote
{
	# Get all available quotes.
	my (@quotes, @item);
	my $quote = "&nbsp;";

	if (-e "$cfg{datadir}/quotes.dat")
	{
		sysopen(FH, "$cfg{datadir}/quotes.dat", O_RDONLY);
		chomp(@quotes = <FH>);
		close(FH);

		# Get a random quote id.
		my $count = @quotes || 0;
		srand();
		my $rand = int(rand($count));
		
		if (@quotes)
		{
			# Get quote data.
			for (my $i = 0; $i < @quotes; $i++) 
			{
				@item = split(/\|/, $quotes[$i]);
				if ($i == $rand) { last; }
			}

			$quote = "<i>" . $item[1] . "</i><br>\n<small>" . $item[2] . "</small>";
		}
	}

	return $quote;
}

# ---------------------------------------------------------------------
# Print meta tags to site HTML output.
# ---------------------------------------------------------------------
sub get_meta_tags
{
	my $meta_tags = '';

	if (-e "$cfg{datadir}/meta.txt")
	{
		sysopen(FH, "$cfg{datadir}/meta.txt", O_RDONLY);
		chomp(my @data = <FH>);
		close(FH);

		if ($data[2] == 1)
		{
			$meta_tags = <<"HTML";
<meta name="description" content="$data[0]">
<meta name="keywords" content="$data[1]">
HTML
		}
	}

	return $meta_tags;
}

# ---------------------------------------------------------------------
# Check for new instant messages.
# ---------------------------------------------------------------------
sub check_ims
{
	my $im_alert;

	if (-e "$cfg{memberdir}/$user_data{uid}.msg")
	{
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_RDONLY);
		chomp(my @instant_messages = <FH>); 
		close(FH);

		# Check if there are new IMs.
		for (my $i = 0; $i < @instant_messages; $i++) 
		{
			my @message = split(/\|/, $instant_messages[$i]);
			if ($message[5]) { $im_alert++; }
		}

		if ($im_alert)
		{
		$im_alert = <<"HTML";
<script>
<!--
alert("$inf{19}")
// -->
</script>
HTML
		}

		# Data integrity check.
		if ($user_data{uid} =~ /^([\w.]+)$/) { $user_data{uid} = $1; } 
		else { user_error($err{6}, $user_data{theme}); }

		# Unmark new IMs (only warn the user one time).
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.msg", O_WRONLY | O_TRUNC | O_CREAT);
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach my $i (@instant_messages) 
		{
			my @message = split(/\|/, $i);
			print FH "$message[0]|$message[1]|$message[2]|$message[3]|$message[4]\n";
		}

		close(FH);
	}

	return $im_alert;
}

# ---------------------------------------------------------------------
# Log visitors and users.
# ---------------------------------------------------------------------
sub log_visitors 
{
	# Get current time.
	my $date = get_date();

	# Get online users/visitors.
	my @log;
	if (-e "$cfg{datadir}/log.dat")
	{
		sysopen(FH, "$cfg{datadir}/log.dat", O_RDONLY);
		chomp(@log = <FH>);
		close(FH);
	}

	# Check if user or guest.
	my $logname = $user_data{uid};
	if ($logname eq $usr{anonuser}) { $logname = $ENV{REMOTE_ADDR} || '127.0.0.1'; }

	sysopen(FH, "$cfg{datadir}/log.dat", O_WRONLY | O_TRUNC | O_CREAT);
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$logname|$date\n";

	# Refresh the log.
	foreach my $i (@log) 
	{
		my ($name, $value) = split(/\|/, $i);

		my $result = calc_time_diff($value, $date);

		if ($name ne $logname && $result <= $cfg{ip_time} && $result >= 0) { print FH "$i\n"; }
	}

	close(FH);
}

# ---------------------------------------------------------------------
# Log IP addresses and build access log.
# ---------------------------------------------------------------------
sub access_log 
{
	my @skip_ip = ("127.0.0.1");
	my $check = 0;

	my $host = $ENV{REMOTE_ADDR};
	if ($ENV{REMOTE_HOST}) { $host = $ENV{REMOTE_HOST}; }

	# Skip definded IP addresses.
	if (@skip_ip) 
	{
		foreach my $i (@skip_ip) 
		{
			if ($host =~ /$i/) { $check = 1; last; }
		}
	}

	# Process all other IPs.
	if ($check == 0) 
	{ 
		my $this_time = time();

		my @log;
		if (-e "$cfg{logdir}/ip.log")
		{
			sysopen(FH, "$cfg{logdir}/ip.log", O_RDONLY);
			chomp(@log = <FH>);
			close(FH);
		}

		# Refresh online IPs.
		sysopen(FH, "$cfg{logdir}/ip.log", O_WRONLY | O_TRUNC | O_CREAT);
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach my $i (@log) 
		{
			my ($ip_address, $time_stamp) = split(/\|/, $i);
			if ($this_time < $time_stamp + 60 * $cfg{ip_time}) 
			{
				if ($ip_address eq $host) { $check = 1; }
				else { print FH "$ip_address|$time_stamp\n"; }
			}
		}
		print FH "$host|$this_time\n";

		close(FH);
	}

	# Build access log.
	if ($check == 0) 
	{
		# Get referer.
		my $referer = $ENV{HTTP_REFERER};
		if (!$referer) { $referer = "-"; }

		# Get current date.
		my $date = get_date();

		# Update log file.
		sysopen(FH, "$cfg{logdir}/stats.dat", O_WRONLY | O_APPEND | O_CREAT);
		flock(FH, LOCK_EX) if ($cfg{use_flock});

		print FH "$date - $host - \"$ENV{HTTP_USER_AGENT}\" - \"$referer\"\n";

		close (FH);
	}
}

# ---------------------------------------------------------------------
# Get the current date and time.
# ---------------------------------------------------------------------
sub get_date 
{
	my ($mon_num, $save_hour, $save_year);
	my ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime(time + 3600 * $cfg{time_offset});

	# Start the nasty time formatting.
	$mon_num = $mon + 1;
	$save_hour = $hour;

	$hour = 0 . $hour if ($hour < 10);
	$min = 0 . $min if ($min < 10);
	$sec = 0 . $sec if ($sec < 10);

	$save_year = ($year % 100);
	$year += 1900;
	$mon_num = 0 . $mon_num if ($mon_num < 10);
	$mday = 0 . $mday if ($mday < 10);
	$save_year = 0 . $save_year if ($save_year < 10);

	# Format timestring.
	my $date = $mday . "/" . $mon_num . "/" . $save_year . " - " . $hour . ":" . $min . ":" . $sec;

	return $date;
}

# ---------------------------------------------------------------------
# Calculate difference between two dates.
# ---------------------------------------------------------------------
sub calc_time_diff 
{
	my ($in_date1, $in_date2, $type) = @_;

	my ($date1, $time1) = split(/ - /, $in_date1);
	my ($day1, $month1, $year1) = split(/\//, $date1);
	my ($hour1, $min1, $sec1) = split(/:/, $time1);

	my ($date2, $time2) = split(/ - /, $in_date2);
	my ($day2, $month2, $year2) = split(/\//, $date2);
	my ($hour2, $min2, $sec2) = split(/:/, $time2);

	# 1st date string in days.
	my $timestamp1 = $year1 * 365 + $month1 * 30 + $day1;
	# 2nd date string in days.
	my $timestamp2 = $year2 * 365 + $month2 * 30 + $day2;

	# 1st date string in hours.
	my $timestamp3 = $hour1 * 60 + $min1;
	# 2nd date string in hours.
	my $timestamp4 = $hour2 * 60 + $min2;

	if (!$type)
	{
		# Calculate difference in hours.
		my $result = $timestamp4 - $timestamp3;

		return $result;
	}
	if ($type == 1)
	{
		# Calculate difference in days.
		my $result = $timestamp2 - $timestamp1;

		return $result;
	}
	if ($type == 2)
	{
		# Return all timestamps.
		my @timestamps = ($timestamp1, $timestamp2, $timestamp3, $timestamp4);

		return @timestamps;
	}
}

# ---------------------------------------------------------------------
# Display an error message if user input isn't valid.
# ---------------------------------------------------------------------
sub user_error
{
	my ($error, $theme) = @_;

	$| = 1;
	print_header();

	print_html($theme, $nav{1});

	# Print the error message.
	print $error;

	print_html($theme, $nav{1}, 1);

	exit();
}

# ---------------------------------------------------------------------
# Display fatal errors.
# ---------------------------------------------------------------------
sub fatal_error
{
	my $error = shift;

	my ($msg, $path) = split " at ", $error;

	print_header();
	print $query->start_html(-title=>'YaWPS ' . $VERSION . ' Fatal Error');

	print <<"HTML";
<font face="arial, verdana, helvetica" size="6" color="#333366">YaWPS $VERSION Fatal Error</font>
<hr size="1" color="#000000" noshade>
<font face="arial, verdana, helvetica" size="3" color="#00000">YaWPS has exited with the following error:<br><br>
<b>$msg</b><br><br>This error was reported at: <font color="#000099" face="courier, courier new, arial, verdana, helvetica">$path</font><br><br>
<font size="3" color="#990000"><b>Please inform the webmaster if this error persists.</b></font>
HTML

	print $query->end_html();

	exit();
}

# ---------------------------------------------------------------------
# Print the UBBC panel.
# ---------------------------------------------------------------------
sub print_ubbc_panel
{
	my $panel = <<"HTML";
<a href="javascript:addCode('[b][/b]')"><img src="$cfg{imagesurl}/forum/bold.gif" align="bottom" width="23" height="22" alt="$msg{117}" border="0"></a>
<a href="javascript:addCode('[i][/i]')"><img src="$cfg{imagesurl}/forum/italicize.gif" align="bottom" width="23" height="22" alt="$msg{118}" border="0"></a>
<a href="javascript:addCode('[u][/u]')"><img src="$cfg{imagesurl}/forum/underline.gif" align="bottom" width="23" height="22" alt="$msg{119}" border="0"></a>
<a href="javascript:addCode('[center][/center]')"><img src="$cfg{imagesurl}/forum/center.gif" align="bottom" width="23" height="22" alt="$msg{120}" border="0"></a>
<a href="javascript:addCode('[url][/url]')"><img src="$cfg{imagesurl}/forum/url.gif" align="bottom" width="23" height="22" alt="$msg{121}" border="0"></a>
<a href="javascript:addCode('[email][/email]')"><img src="$cfg{imagesurl}/forum/email2.gif" align="bottom" width="23" height="22" alt="$msg{122}" border="0"></a>
<a href="javascript:addCode('[code][/code]')"><img src="$cfg{imagesurl}/forum/code.gif" align="bottom" width="23" height="22" alt="$msg{123}" border="0"></a>
<a href="javascript:addCode('[quote][/quote]')"><img src="$cfg{imagesurl}/forum/quote2.gif" align="bottom" width="23" height="22" alt="$msg{124}" border="0"></a>
<a href="javascript:addCode('[list][*][*][*][/list]')"><img src="$cfg{imagesurl}/forum/list.gif" align="bottom" width="23" height="22" alt="$msg{125}" border="0"></a>
<a href="javascript:void(0)" onClick="window.open('$cfg{pageurl}/smilies.$cfg{ext}','_blank','scrollbars=yes,toolbar=no,height=270,width=270')"><img src="$cfg{imagesurl}/forum/smilie.gif" align="bottom" width="23" height="22" alt="$msg{126}" border="0"></a><br>
<select name="color" onChange="showColor(this.options[this.selectedIndex].value)">
<option value="Black" selected>$msg{127}</option>
<option value="Red">$msg{128}</option>
<option value="Yellow">$msg{129}</option>
<option value="Pink">$msg{130}</option>
<option value="Green">$msg{131}</option>
<option value="Orange">$msg{132}</option>
<option value="Purple">$msg{133}</option>
<option value="Blue">$msg{134}</option>
<option value="Beige">$msg{135}</option>
<option value="Brown">$msg{136}</option>
<option value="Teal">$msg{137}</option>
<option value="Navy">$msg{138}</option>
<option value="Maroon">$msg{139}</option>
<option value="LimeGreen">$msg{140}</option>
</select>
HTML
	return $panel;
}

# ---------------------------------------------------------------------
# Print the UBBC image selector.
# ---------------------------------------------------------------------
sub print_ubbc_image_selector
{
	my $selected_icon = shift || 'xx';

	# Display the pre selected icon?
	my $pre_selected_icon = '';
	if ($selected_icon && $selected_icon ne 'xx') { $pre_selected_icon = qq(<option value="$selected_icon"></option>\n); }

	my $selector = <<"HTML";
<script language="javascript" type="text/javascript">
<!--
function showImage() {
document.images.icons.src="$cfg{imagesurl}/forum/"+document.creator.icon.options[document.creator.icon.selectedIndex].value+".gif";
}
// -->
</script>
<select name="icon" onChange="showImage()">
$pre_selected_icon<option value="xx">$msg{143}</option>
<option value="thumbup">$msg{144}</option>
<option value="thumbdown">$msg{145}</option>
<option value="exclamation">$msg{146}</option>
<option value="question">$msg{147}</option>
<option value="lamp">$msg{148}</option>
</select>
<img src="$cfg{imagesurl}/forum/$selected_icon.gif" name="icons" width="15" height="15" border="0" hspace="15" alt=""></td>
</tr>
<tr>
<td valign=top><b>$msg{38}</b></td>
<td>
<script language="javascript" type="text/javascript">
<!--
function addCode(anystr) { 
document.creator.message.value+=anystr;
} 
function showColor(color) { 
document.creator.message.value+="[color="+color+"][/color]";
}
// -->
</script>
HTML
	return $selector;
}

# ---------------------------------------------------------------------
# Convert UBBC tags.
# ---------------------------------------------------------------------
sub do_ubbc 
{
	my $message = shift;

	# Make the smilies.
	if ($message =~ /^\#nosmileys/) { $message =~ s/^\#nosmileys//; }
	else { 
		$message =~ s~\[bones\]~<img src="$cfg{imagesurl}/smilies/bones.gif" alt="">~g;
		$message =~ s~\[bounce\]~<img src="$cfg{imagesurl}/smilies/bounce.gif" alt="">~g;
		$message =~ s~\:-\?~<img src="$cfg{imagesurl}/smilies/confused.gif" alt="">~g;
		$message =~ s~\[confused\]~<img src="$cfg{imagesurl}/smilies/confused.gif" alt="">~g;
		$message =~ s~\Q8)\E~<img src="$cfg{imagesurl}/smilies/cool.gif" alt="">~g;
		$message =~ s~\Q8-)\E~<img src="$cfg{imagesurl}/smilies/cool.gif" alt="">~g;
		$message =~ s~\[cool\]~<img src="$cfg{imagesurl}/smilies/cool.gif" alt="">~g;
		$message =~ s~\[cry\]~<img src="$cfg{imagesurl}/smilies/cry.gif" alt="">~g;
		$message =~ s~\:o~<img src="$cfg{imagesurl}/smilies/eek.gif" alt="">~g;
		$message =~ s~\:\-o~<img src="$cfg{imagesurl}/smilies/eek.gif" alt="">~g;
		$message =~ s~\[eek\]~<img src="$cfg{imagesurl}/smilies/eek.gif" alt="">~g;
		$message =~ s~\[evil\]~<img src="$cfg{imagesurl}/smilies/evil.gif" alt="">~g;
		$message =~ s~\:\(~<img src="$cfg{imagesurl}/smilies/frown.gif" alt="">~g;
		$message =~ s~\:-\(~<img src="$cfg{imagesurl}/smilies/frown.gif" alt="">~g;
		$message =~ s~\[frown\]~<img src="$cfg{imagesurl}/smilies.gif" alt="">~g;
		$message =~ s~\:D~<img src="$cfg{imagesurl}/smilies/grin.gif" alt="">~g;
		$message =~ s~\:-D~<img src="$cfg{imagesurl}/smilies/grin.gif" alt="">~g;
		$message =~ s~\[grin\]~<img src="$cfg{imagesurl}/smilies/grin.gif" alt="">~g;
		$message =~ s~\[lol\]~<img src="$cfg{imagesurl}/smilies/lol.gif" alt="">~g;
		$message =~ s~\:x~<img src="$cfg{imagesurl}/smilies/mad.gif" alt="">~g;
		$message =~ s~\:-x~<img src="$cfg{imagesurl}/smilies/mad.gif" alt="">~g;
		$message =~ s~\[mad\]~<img src="$cfg{imagesurl}/smilies/mad.gif" alt="">~g;
		$message =~ s~\[ninja\]~<img src="$cfg{imagesurl}/smilies/ninja.gif" alt="">~g;
		$message =~ s~\[nonsense\]~<img src="$cfg{imagesurl}/smilies/nonsense.gif" alt="">~g;
		$message =~ s~\[oops\]~<img src="$cfg{imagesurl}/smilies/oops.gif" alt="">~g;
		$message =~ s~\[razz\]~<img src="$cfg{imagesurl}/smilies/razz.gif" alt="">~g;
		$message =~ s~\[rolleyes\]~<img src="$cfg{imagesurl}/smilies/rolleyes.gif" alt="">~g;
		$message =~ s~\:\)~<img src="$cfg{imagesurl}/smilies/smile.gif" alt="">~g;
		$message =~ s~\:-\)~<img src="$cfg{imagesurl}/smilies/smile.gif" alt="">~g;
		$message =~ s~\[smile\]~<img src="$cfg{imagesurl}/smilies/smile.gif" alt="">~g;
		$message =~ s~\:P~<img src="$cfg{imagesurl}/smilies/tongue.gif" alt="">~g;
		$message =~ s~\:-P~<img src="$cfg{imagesurl}/smilies/tongue.gif" alt="">~g;
		$message =~ s~\[tongue\]~<img src="$cfg{imagesurl}/smilies/tongue.gif" alt="">~g;
		$message =~ s~\;\)~<img src="$cfg{imagesurl}/smilies/wink.gif" alt="">~g;
		$message =~ s~\;-\)~<img src="$cfg{imagesurl}/smilies/wink.gif" alt="">~g;
		$message =~ s~\[wink\]~<img src="$cfg{imagesurl}/smilies/wink.gif" alt="">~g;
	}

	# Convert the UBBC tags.
	$message =~ s~\[\[~\{\{~g;
	$message =~ s~\]\]~\}\}~g;
	$message =~ s~\n\[~\[~g;
	$message =~ s~\]\n~\]~g;

	$message =~ s~\[hr\]\n~<hr size="1">~g;
	$message =~ s~\[hr\]~<hr size="1">~g;

	$message =~ s~\[b\]~<b>~isg;
	$message =~ s~\[\/b\]~</b>~isg;

	$message =~ s~\[i\]~<i>~isg;
	$message =~ s~\[\/i\]~</i>~isg;

	$message =~ s~\[u\]~<u>~isg;
	$message =~ s~\[\/u\]~</u>~isg;

	$message =~ s~\[move\](.+?)\[/move\]~<marquee>$1</marquee>~isg;
	
	$message =~ s~\[img\](.+?)\[\/img\]~<img src="$1" alt="">~isg;
	$message =~ s~\[img width=(\d+) height=(\d+)\](.+?)\[/img\]~<img src="$3" width="$1" height="$2" alt="">~isg;  
	$message =~ s~\[aright_img\](.+?)\[\/img\]~<img align="right" hspace="5" src="$1" alt="">~isg;
	$message =~ s~\[aleft_img\](.+?)\[\/img\]~<img align="left" hspace="5" src="$1" alt="">~isg;

	$message =~ s~\[iframe\](.+?)\[\/iframe\]~<iframe src="$1" width="480" height="400"></iframe>~isg;
	
	$message =~ s~\[color=([\w#]+)\](.*?)\[/color\]~<font color="$1">$2</font>~isg;
	
	$message =~ s~\[quote\]<br>(.+?)<br>\[\/quote\]~<blockquote><hr>$1<hr></blockquote>~isg;
	$message =~ s~\[quote\](.+?)\[\/quote\]~<blockquote><hr><b>$1</b><hr></blockquote>~isg;

	$message =~ s~\[sup\]~<sup>~isg;
	$message =~ s~\[\/sup\]~</sup>~isg;

	$message =~ s~\[sub\]~<sub>~isg;
	$message =~ s~\[\/sub\]~</sub>~isg;

	$message =~ s~\[center\]~<center>~isg;
	$message =~ s~\[\/center\]~</center>~isg;

	$message =~ s~\[list\]~<ul>~isg;
	$message =~ s~\[\*\]~<li>~isg;
	$message =~ s~\[\/list\]~</ul>~isg;

	$message =~ s~\[pre\]~<pre>~isg;
	$message =~ s~\[\/pre\]~</pre>~isg;

	if ($message =~ m~\[table\]\s*(.+?)\s*\[tr\]~i ) 
	{
		while ($message =~ s~<marquee>(.*?)\[table\](.*?)\[/table\](.*?)</marquee>~<marquee>$1<table>$2</table>$3</marquee>~s) {}
		while ($message =~ s~<marquee>(.*?)\[table\](.*?)</marquee>(.*?)\[/table\]~<marquee>$1\[//table\]$2</marquee>$3\[//table\]~s) {}
		while ($message =~ s~\[table\](.*?)<marquee>(.*?)\[/table\](.*?)</marquee>~\[//table\]$1<marquee>$2\[//table\]$3</marquee>~s) {}
		$message =~ s~\n{0,1}\[table\]\n*(.+?)\n*\[/table\]\n{0,1}~<table>$1</table>~isg;
		while ($message =~ s~\<table\>(.*?)\n*\[tr\]\n*(.*?)\n*\[/tr\]\n*(.*?)\</table\>~<table>$1<tr>$2</tr>$3</table>~is) {}
		while ($message =~ s~\<tr\>(.*?)\n*\[td\]\n{0,1}(.*?)\n{0,1}\[/td\]\n*(.*?)\</tr\>~<tr>$1<td>$2</td>$3</tr>~is) {}
	}

	$message =~ s~\[email\]\s*(\S+?\@\S+?)\s*\[/email\]~<A href="mailto:$1">$1</a>~isg;
	$message =~ s~\[email=\s*(\S+?\@\S+?)\]\s*(.*?)\s*\[/email\]~<a href="mailto:$1">$2</a>~isg;

	$message =~ s~\[url\]www\.\s*(.+?)\s*\[/url\]~<a href="http://www.$1" target="_blank">www.$1</a>~isg;
	$message =~ s~\[url=\s*(\w+\://.+?)\](.+?)\s*\[/url\]~<a href="$1" target="_blank">$2</a>~isg;
	$message =~ s~\[url=\s*(.+?)\]\s*(.+?)\s*\[/url\]~<a href="http://$1" target="_blank">$2</a>~isg;
	$message =~ s~\[url\]\s*(.+?)\s*\[/url\]~<a href="$1" target="_blank">$1</a>~isg;

	$message =~ s~([^\w\"\=\[\]]|[\n\b]|\A)\\*(\w+://[\w\~\.\;\:\,\$\-\+\!\*\?/\=\&\@\#\%]+[\w\~\.\;\:\$\-\+\!\*\?/\=\&\@\#\%])~$1<a href="$2" target="_blank">$2</a>~isg;
	$message =~ s~([^\"\=\[\]/\:\.]|[\n\b]|\A)\\*(www\.[\w\~\.\;\:\,\$\-\+\!\*\?/\=\&\@\#\%]+[\w\~\.\;\:\$\-\+\!\*\?/\=\&\@\#\%])~$1<a href="http://$2" target="_blank">$2</a>~isg;

	$message =~ s~\{\{~\[~g;
	$message =~ s~\}\}~\]~g;

	return $message;
}

# ---------------------------------------------------------------------
# Escape HTML tags.
# ---------------------------------------------------------------------
sub html_escape
{
	my $text = shift;

	$text =~ s/&/&amp;/g;
	$text =~ s/"/&quot;/g;
	$text =~ s/  / \&nbsp;/g;
	$text =~ s/</&lt;/g;
	$text =~ s/>/&gt;/g;
	$text =~ s/\t/ \&nbsp; \&nbsp; \&nbsp;/g;
	$text =~ s/\|/\&#124;/g;
	$text =~ s/\n/<br>/g;
	$text =~ s/\cM//g;

	return $text;
}

# ---------------------------------------------------------------------
# Transform HTML tags.
# Usage: my $html = html_to_text($html);
# ---------------------------------------------------------------------
sub html_to_text
{
	my $html = shift;

	$html =~ s/&amp;/&/g;
	$html =~ s/&quot;/"/g;
	$html =~ s/ \&nbsp;/  /g;
	$html =~ s/&lt;/</g;
	$html =~ s/&gt;/>/g;
	$html =~ s/ \&nbsp; \&nbsp; \&nbsp;/\t/g;
	$html =~ s/\&#124;/\|/g;
	$html =~ s/<br>/\n/g;

	return $html;
}

# ---------------------------------------------------------------------
# Send emails.
# ---------------------------------------------------------------------
sub send_email 
{
	my ($from, $to, $subject, $message) = @_;
	my ($x, $here, $there, $null);

	# Format input.
	$to =~ s/[ \t]+/, /g;
	$from =~ s/.*<([^\s]*?)>/$1/;
	$message =~ s/^\./\.\./gm;
	$message =~ s/\r\n/\n/g;
	$message =~ s/\n/\r\n/g;

	$cfg{smtp_server} =~ s/^\s+//g;
	$cfg{smtp_server} =~ s/\s+$//g;

	# Send email via SMTP.
	if ($cfg{mail_type} == 1) 
	{
		($x, $x, $x, $x, $here) = gethostbyname($null);
		($x, $x, $x, $x, $there) = gethostbyname($cfg{smtp_server});

		my $thisserver = pack('S n a4 x8', 2, 0, $here);
		my $remoteserver = pack('S n a4 x8', 2, 25, $there);

		(!(socket(S, 2, 1, 6))) && (croak "Socket failure. $!");
		(!(bind(S, $thisserver))) && (croak "Bind failure. $!");
		(!(connect(S, $remoteserver))) && (croak "Connection to $cfg{smtp_server} has failed. $!");

		my $oldfh = select(S);
		$| = 1;
		select($oldfh);

		$_ = <S>; 
		($_ !~ /^220/) && (croak "Sending Email: data in Connect error - 220. $!"); 

		print S "HELO $cfg{smtp_server}\r\n";
		$_ = <S>;
		($_ !~ /^250/) && (croak "Sending Email: data in Connect error - 250. $!"); 

		print S "MAIL FROM:<$from>\n";
		$_ = <S>;
		($_ !~ /^250/) && (croak "Sending Email: Sender address '$from' not valid. $!"); 

		print S "RCPT TO:<$to>\n";
		$_ = <S>;
		($_ !~ /^250/) && (croak "Sending Email: Recipient address '$to' not valid. $!"); 

		print S "DATA\n";
		$_ = <S>;
		($_ !~ /^354/) && (croak "Sending Email: Message send failed - 354. $!"); 
	}

	# Send email via NET::SMTP.
	if ($cfg{mail_type} == 2) 
	{
		eval q^
			use Net::SMTP;
			my $smtp = Net::SMTP->new($cfg{smtp_server}, Debug => 0) or croak "Unable to create Net::SMTP object '$cfg{smtp_server}'. $!";

			$smtp->mail($from);
			$smtp->to($to);
			$smtp->data();
			$smtp->datasend("From: $from\n");
			$smtp->datasend("Subject: $subject\n");
			$smtp->datasend("\n");
			$smtp->datasend($message);
			$smtp->dataend();
			$smtp->quit();
		^;
		if ($@) { croak "Net::SMTP fatal error: $@"; }
		return(1);
	}

	# Send email via sendmail.
	$ENV{PATH} = "";
	if ($cfg{mail_type} == 0) { open(S, "| $cfg{mail_program} -t") or croak "Mailprogram error. $!"; }

	print S "To: $to\n";
	print S "From: $from\n";
	print S "Subject: $subject\n\n";
	print S "$message";
	print S "\n\n";

	# Send email via SMTP.
	if ($cfg{mail_type} == 1) 
	{
		$_ = <S>;
		($_ !~ /^250/) && (croak "Sending Email: Message send failed - try again - 250. $!"); 
		print S "QUIT\n";
	}

	close(S);
	return(1);
}

# ---------------------------------------------------------------------
# Export latest news to RDF file.
# ---------------------------------------------------------------------
sub rdf_export 
{
	my (@articles, @data, @top_news, $channel, $item);

	# Get article data.
	opendir(DIR, "$cfg{topicsdir}");
	my @cats = readdir(DIR);
	closedir(DIR);

	@cats = grep(/\.cat/, @cats);

	# Cycle through the categories.
	foreach my $cat (@cats) 
	{
		sysopen(FH, "$cfg{topicsdir}/$cat", O_RDONLY); 
		chomp(my @topic_data = <FH>);
		close(FH);

		for (my $i = 0; $i < @topic_data; $i++) 
		{
			my ($num, $subject, $date);
			($num, $subject, undef, undef, undef, $date, undef, undef) = split(/\|/, $topic_data[$i]);

			push (@articles, join ("\|", $num, $subject));
		}
	}
	
	for (0 .. $#articles) 
	{
		my @fields = split(/\|/, $articles[$_]);
		for my $i (0 .. $#fields) { $data[$_][$i] = $fields[$i]; }
	}

	my @sorted = reverse sort { $a->[0] <=> $b->[0] } @data;

	# Sort them by date.
	for (@sorted) 
	{ 
		my $sorted_row = join ("|", @$_);
		push (@top_news, $sorted_row);
	}

	# Get the latest headlines.
	for (my $i = 0; $i < @top_news && $i < $cfg{max_items_per_page}; $i++) 
	{
		my ($num, $subject) = split(/\|/, $top_news[$i]);

		$channel .= qq(<rdf:li resource="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;id=$num" />\n);
		$item .= <<"RDF";
<item rdf:about="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;id=$num">
<title>$subject</title>
<link>$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;id=$num</link>
</item>
RDF
	}

	# Export data to XML file.
	sysopen(FH, "$cfg{yawpsnewsdir}/yawpsnews.xml", O_WRONLY | O_TRUNC | O_CREAT);
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH <<"RDF";
<?xml version="1.0" encoding="$cfg{codepage}"?>
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/">

<channel rdf:about="$cfg{yawpsnewsurl}/yawpsnews.xml">
<title>$cfg{pagename}</title>
<link>$cfg{pageurl}/index.$cfg{ext}</link>
<description>$cfg{pagetitle}</description>
<items>
<rdf:Seq>
$channel</rdf:Seq>
</items>
</channel>
$item
</rdf:RDF>
RDF

	close(FH);
}

# ---------------------------------------------------------------------
# Get entries from forum log.
# ---------------------------------------------------------------------
sub read_forum_log 
{
	my ($user, $id) = @_;

	if ($user ne $usr{anonuser})
	{
		if (-e "$cfg{memberdir}/$user.log")
		{
			sysopen(FH,"$cfg{memberdir}/$user.log", O_RDONLY);  
			chomp(my @log = <FH>);
			close(FH);

			if (@log)
			{
				foreach (@log) 
				{
					my ($name, $value) = split(/\|/, $_);
					if ($name eq $id) { return $value; }
				}
			}
		}
	}
}

# ---------------------------------------------------------------------
# Log read forum topics.
# ---------------------------------------------------------------------
sub write_forum_log 
{
	my ($user, $id) = @_;

	if ($user ne $usr{anonuser}) 
	{
		my @log;
		if (-e "$cfg{memberdir}/$user.log")
		{
			sysopen(FH,"$cfg{memberdir}/$user.log", O_RDONLY);
			chomp(@log = <FH>);
			close(FH);
		}

		# Get current date.
		my $date = get_date();

		# Data integrity check.
		if ($user =~ /^([\w.]+)$/) { $user = $1; } 
		else { croak "Unsafe data in $cfg{memberdir}/$user.dat detected"; }

		# Write log.
		sysopen(FH, "$cfg{memberdir}/$user.log", O_WRONLY | O_TRUNC | O_CREAT);
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH "$id|$date\n";
		foreach (@log) 
		{
			my ($name, $value) = split(/\|/, $_);
			my $diff = calc_time_diff($value, $date, 1);

			if ($name ne $id && $diff <= $cfg{max_log_days_old}) { print FH "$_\n"; }
		}

		close(FH);
	}
}

# ---------------------------------------------------------------------
# Check for banned users.
# ---------------------------------------------------------------------
sub check_ban
{
	my ($uid, $email) = @_;

	my $host = $ENV{REMOTE_ADDR} || $ENV{REMOTE_HOST} || '';

	if (-e "$cfg{datadir}/ban.txt")
	{
		sysopen(FH, "$cfg{datadir}/ban.txt", O_RDONLY);
		chomp(my @banned = <FH>);
		close(FH);
 
		foreach (@banned)
		{
			# Check for banned usernames, emails and IP addresses.
			if ($uid eq $_ || $email eq $_ || $host eq $_) { croak $err{26}; }
		}
	}
}

1;
