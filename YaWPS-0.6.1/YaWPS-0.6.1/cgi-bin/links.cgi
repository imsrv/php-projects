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
# $Id: links.cgi,v 1.11 2002/12/15 11:34:22 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $cat $id $start $link_title $link_url $link_desc $link_rate
	@votes 
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$cat = $query->param('cat') || '';
$id = $query->param('id');
$start = $query->param('start');
$link_title = $query->param('title');
$link_url = $query->param('url');
$link_desc = $query->param('desc');
$link_rate = $query->param('rate');

# Get user profile.
%user_data = authenticate();

# Check cookie.
@votes = $query->cookie('yawps_link');

# Define possible user actions.
%user_action = (
	view_cat => \&display_cat,
	view_link => \&display_link,
	add_link => \&add_link,
	add_link2 => \&add_link2,
	report_link => \&report_link,
	rate_link => \&rate_link,
	rate_link2 => \&rate_link2,
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { display_cats(); }

# ---------------------------------------------------------------------
# Display all links categories.
# ---------------------------------------------------------------------
sub display_cats
{
	# Get data of all categories.
	my @cats;
	if (-e "$cfg{linksdir}/linkcats.dat")
	{
		sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY);
		chomp(@cats = <FH>);
		close(FH);
	}

	print_header();
	print_html($user_data{theme}, $nav{5});

	print <<"HTML";
<table align="center" border="0" cellpadding="3" cellspacing="0">
<tr>
HTML

	# Cycle through the categories.
	my $total_links_count = 0;
	my $count = 0;

	if (@cats)
	{
		foreach my $curcat (@cats) 
		{
			my @item = split (/\|/, $curcat);
			if (-e "$cfg{linksdir}/$item[1].dat") 
			{
				# Get number of links in category.
				my @links;
				if (-e "$cfg{linksdir}/$item[1].dat")
				{
					sysopen(FH, "$cfg{linksdir}/$item[1].dat", O_RDONLY);
					@links = <FH>;
					close(FH);
				}

				my $links_count = @links;

				print <<"HTML";
<td valign="top" width="50%">
<table>
<tr>
<td colspan="2"><b><a href="$cfg{pageurl}/links.$cfg{ext}?op=view_cat;cat=$item[1]">$item[0]</a></b> <i>($links_count)</i></td>
</tr>
<tr>
<td width="20">&nbsp;</td>
<td>$item[2]</td>
</tr>
</table>
</td>
HTML
				$total_links_count = $total_links_count + $links_count;
			} 
			else 
			{
				print <<"HTML";
<td valign="top" width="50%">
<table>
<tr>
<td colspan="2"><b>$item[0]</b> <i>(0)</i></td>
</tr>
<tr>
<td width="20">&nbsp;</td>
<td>$item[2]</td>
</tr>
</table>
</td>
HTML
			}
			
			$count++;
			if ($count == 2) 
			{
				print "</tr>\n<tr>";
				$count = 0;
			}
		}

		my $message;
		if ($total_links_count == 1) { $message = $msg{84} . " <b>1</b> " . $msg{85}; }
		else { $message = $msg{86} . " <b>" . $total_links_count . "</b> " . $msg{87}; }

		print <<"HTML";
<td></td>
</tr>
</table>
<br>
<table align="center" border="0" cellpadding="3" cellspacing="0">
<tr>
<td align="center">$message</td>
</tr>
<tr>
<td></td>
</tr>
HTML

		if ($user_data{uid} ne $usr{anonuser}) 
		{
			print <<"HTML";
<tr>
<td align="center"><a href="$cfg{pageurl}/links.$cfg{ext}?op=add_link">$nav{30}</a></td>
</tr>
HTML
		}
	}

	print "</table>\n";

	print_html($user_data{theme}, $nav{5}, 1);
}

# ---------------------------------------------------------------------
# Display a link category.
# ---------------------------------------------------------------------
sub display_cat
{
	# Get data of all categories.
	sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/linkcats.dat. ($!)", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	# Get category name.
	my $linkcat_name;
	for (my $i = 0; $i < @cats; $i++) 
	{
		my ($name, $link, $desc) = split(/\|/, $cats[$i]);
		if ($cat eq $link) { $linkcat_name = $name; }
	}

	# Get data of current category.	
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$cat.dat. ($!)", $user_data{theme});
	my @linkcat = <FH>;
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{5} >>> $linkcat_name");

	print qq(<table border="0" cellpadding="5" cellspacing="0" width="100%">);

	# Initialize page navigation.
	if (!$start) { $start = 0; }

	# Cycle through category and display all entries.
	my $num_shown = 0;
	for (my $i = $start; $i < @linkcat; $i++) 
	{
		my ($lid, $name, $url, $desc, $date, $linkposter, $hits, $votes, $rate) = split(/\|/, $linkcat[$i]);

		my $average_rate = 0;
		if ($votes && $rate) { $average_rate = sprintf("%.2f", ($rate / $votes)); }

		print <<"HTML";
<tr>
<td><img src="$cfg{imagesurl}/urlgo.gif" border="0" alt="">&nbsp;&nbsp;<b><a href="$cfg{pageurl}/links.$cfg{ext}?op=view_link;cat=$cat;id=$lid" target="_blank">$name</a></b><br>
$msg{88} $desc<br>
$msg{89} $date<br>
$msg{192}: $hits, $msg{171}: $votes, $msg{193}: $average_rate<br>
<small><a href="$cfg{pageurl}/links.$cfg{ext}?op=rate_link;cat=$cat;id=$lid">$nav{31}</a> | <a href="$cfg{pageurl}/links.$cfg{ext}?op=report_link;cat=$cat;id=$lid">$nav{32}</a></small></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
HTML
		$num_shown++;
		if ($num_shown >= $cfg{max_items_per_page}) { $i = @linkcat; }
	}

	print "</table>";

	# Make jumpbar.
	if ($num_shown >= $cfg{max_items_per_page}) 
	{
		print qq(<hr noshade="noshade" size="1">\n$msg{39} );
		my $num_links = @linkcat;

		my $count = 0;
		while (($count * $cfg{max_items_per_page}) < $num_links) 
		{
			my $viewc = $count + 1;
			my $strt = ($count * $cfg{max_items_per_page});
			if ($start == $strt) { print "[$viewc] "; }
			elsif ($strt == 0) { print qq(<a href="$cfg{pageurl}/link.$cfg{ext}">$viewc</a> ); }
			else { print qq(<a href="$cfg{pageurl}/links.$cfg{ext}?op=view_cat;cat=$cat;start=$strt">$viewc</a> ); }
			$count++;
		}
	}

	print <<"HTML";
<br>
<table align="center" border="0" cellpadding="3" cellspacing="0">
HTML

	# Print add-link link if user has perms.
	if ($user_data{uid} ne $usr{anonuser}) 
	{
			print <<"HTML";
<tr>
<td align="center">[<a href="$cfg{pageurl}/links.$cfg{ext}">$nav{33}</a>] [<a href="$cfg{pageurl}/links.$cfg{ext}?op=add_link;cat=$cat">$nav{30}</a>]</td>
</tr>
HTML
	}
	else 
	{
		print <<"HTML";
<tr>
<td align="center"><a href="$cfg{pageurl}/links.$cfg{ext}">$nav{33}</a></td>
</tr>
HTML
	}
	print "</table>\n";

	print_html($user_data{theme}, "$nav{5} >>> $linkcat_name", 1);
}

# ---------------------------------------------------------------------
# Redirect to link URL.
# ---------------------------------------------------------------------
sub display_link
{
	# Data integrity check.
	if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Get data of current category.
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$cat.dat. ($!)", $user_data{theme});
	chomp(my @datas = <FH>);
	close(FH);

	# Get URL of selected link and increment hits counter.
	my $location;
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/$cat.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @datas; $i++)
	{
		my ($lid, $name, $url, $desc, $date, $linkposter, $hits, $votes, $rate) = split(/\|/, $datas[$i]);
		if ($lid == $id) 
		{
			$location = $url;
			$hits = $hits + 1;

			print FH "$lid|$name|$url|$desc|$date|$linkposter|$hits|$votes|$rate\n";
		}
		else { print FH "$datas[$i]\n"; }
	}

	close(FH);

	# Redirect to URL.
	print $query->redirect(-location=>$location);
}

# ---------------------------------------------------------------------
# Display formular to add a link.
# ---------------------------------------------------------------------
sub add_link 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get link categories.
	sysopen(FH, "$cfg{linksdir}/linkcats.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/linkcats.dat. ($!)", $user_data{theme});
	chomp(my @cats = <FH>);
	close(FH);

	print_header();
	print_html($user_data{theme}, "$nav{5} >>> $nav{30}");

	print <<"HTML";
<form method="post" action="$cfg{pageurl}/links.$cfg{ext}">
<table border="0" cellpadding="5" cellspacing="0">
<tr>
<td><b>$msg{90}</b></td>
<td><input type="text" name="title" size="40" maxlength="100"></td>
</tr>
<tr>
<td><b>$msg{91}</b></td>
<td><input type="text" name="url" size="40" maxlength="100" value="http://"></td>
</tr>
<tr>
<td><b>$msg{92}</b></td>
<td><select name="cat">
HTML

	# Print available link categories.
	foreach my $curcat (@cats) 
	{
		my @item = split (/\|/, $curcat);

		my $selected = ($cat eq $item[1]) ? 'selected' : '';

		print qq(<option $selected value="$item[1]">$item[0]</option>\n);
	}

	print <<"HTML";
</select><td>
</tr>
<tr>
<td valign="top"><b>$msg{93}</b></td>
<td><textarea name="desc" cols="40" rows="5" maxlength="255"></textarea><br>$msg{94}</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="add_link2">
<input type="submit" value="$btn{13}">
<input type="reset" value="$btn{9}"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, "$nav{5} >>> $nav{30}", 1);
}

# ---------------------------------------------------------------------
# Add a link.
# ---------------------------------------------------------------------
sub add_link2 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	user_error($err{21}, $user_data{theme}) unless ($link_title);
	user_error($err{22}, $user_data{theme}) unless ($link_url);
	user_error($err{23}, $user_data{theme}) unless ($link_desc);

	# Check if description isn't too long.
	if (length($link_desc) > 255) { $link_desc = substr($link_desc, 0, 255); }

	# Cut off last linebreak, if any.
	chomp($link_desc);
	chomp($link_title);
	chomp($link_url);

	# Format input.
	$link_title = html_escape($link_title);
	$link_desc = html_escape($link_desc);

	# Get current date.
	my $date = get_date();

	my @datas;
	if (-e "$cfg{linksdir}/$cat.dat")
	{
		sysopen(FH, "$cfg{linksdir}/$cat.dat", O_RDONLY);
		@datas = <FH>;
		close(FH);
	}

	# Get ID of new link.
	my $lid = @datas;
	$lid = $lid + 1;

	# Data integrity check.
	if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Add link to database.
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_WRONLY | O_TRUNC | O_CREAT);  
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$lid|$link_title|$link_url|$link_desc|$date|$user_data{uid}|0|0|0\n";
	for (my $i = 0; $i < @datas; $i++) { print FH $datas[$i]; }

	close(FH);

	print $query->redirect(-location=>$cfg{pageurl} . '/links.' . $cfg{ext} . '?op=view_cat;cat=' . $cat);
}

# ---------------------------------------------------------------------
# Report a link to site admin.
# ---------------------------------------------------------------------
sub report_link
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	my $subject = "Broken link: ". $cfg{pagename};
	my $message = <<"HTML";
$user_data{nick} $inf{11} $ENV{REMOTE_ADDR} has reported a possible broken link:
$cfg{pageurl}/links.$cfg{ext}?op=view_link;cat=$cat;id=$id
Please take appropriate action.

HTML

	# Send the email to recipient.
	send_email($user_data{email}, $cfg{webmaster_email}, $subject, $message);

	print_header();
	print_html($user_data{theme}, "$nav{5} >>> Report broken link");

	print "Thank you for your submission. It will be verified by the site administrator as soon as possible.";

	print_html($user_data{theme}, "$nav{5} >>> Report broken link", 1);
}

# ---------------------------------------------------------------------
# Print formular to rate a link.
# ---------------------------------------------------------------------
sub rate_link
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Get data of current category.
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$cat.dat. ($!)", $user_data{theme});
	chomp(my @datas = <FH>);
	close(FH);

	# Get link data.
	my ($lid, $name, $url, $desc, $date, $linkposter, $hits, $votes, $rate);
	for (my $i = 0; $i < @datas; $i++)
	{
		($lid, $name, $url, $desc, $date, $linkposter, $hits, $votes, $rate) = split(/\|/, $datas[$i]);
		if ($lid == $id) { last; }
	}


	my $average_rate = 0;
	if ($votes && $rate) { $average_rate = sprintf("%.2f", ($rate / $votes)); }

	print_header();
	print_html($user_data{theme}, "$nav{5} >>> $nav{31}");

	print <<"HTML";
<form method="post" action="$cfg{pageurl}/links.$cfg{ext}">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
<td><b>$msg{90}</b></td>
<td>$name</td>
</tr>
<tr>
<td><b>$msg{91}</b></td>
<td><a href="$cfg{pageurl}/links.$cfg{ext}?op=view_link;cat=$cat;id=$lid" target="_blank">$url</a></td>
</tr>
<tr>
<td valign="top"><b>$msg{93}</b></td>
<td>$desc</td>
</tr>
<tr>
<td valign="top"><b>$msg{89}</b></td>
<td>$date</td>
</tr>
<tr>
<td valign="top"><b>$msg{192}</b></td>
<td>$hits</td>
</tr>
<tr>
<td valign="top"><b>$msg{171}:</b></td>
<td>$votes</td>
</tr>
<tr>
<td valign="top"><b>$msg{193}:</b></td>
<td>$average_rate</td>
</tr>
<tr>
<td colspan="2"><hr size="1">
$msg{194}
<select name="rate">
HTML

	# Print rating scale.
	my $i = 10;
	while ($i > 0) { print qq(<option value="$i">$i</option>); $i = $i - 1; }

	print <<"HTML";
</select>
</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="rate_link2">
<input type="hidden" name="cat" value="$cat">
<input type="hidden" name="id" value="$lid">
<input type="submit" value="$btn{18}"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, "$nav{5} >>> $nav{31}", 1);
}

# ---------------------------------------------------------------------
# Rate a link.
# ---------------------------------------------------------------------
sub rate_link2
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{11}, $user_data{theme}); }

	# Data integrity check.
	if ($cat =~ /^([\w.]+)$/) { $cat = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Check if user has already voted.
	my $this_link = $cat . "_" . $id;

	for (0 .. $#votes)
	{
		my @fields = split(/\|/, $votes[$_]);
		foreach (@fields) 
		{ 
			if ($_ eq $this_link) { user_error($err{20}, $user_data{theme}); }
		}
	}

	# If not set the cookie and add rating.
	push(my @new_votes, join ("\|", @votes, $this_link)); 
	my $cookie_link = $query->cookie(-name=>'yawps_link', -value=>@new_votes, -path=>'/', -expires=>$cfg{cookie_expire}); 

	# Get data of current category.
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_RDONLY) or user_error("$err{1} $cfg{linksdir}/$cat.dat. ($!)", $user_data{theme});
	chomp(my @datas = <FH>);
	close(FH);

	# Get URL of selected link and increment hits counter.
	sysopen(FH, "$cfg{linksdir}/$cat.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{linksdir}/$cat.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	for (my $i = 0; $i < @datas; $i++)
	{
		my ($lid, $name, $url, $desc, $date, $linkposter, $hits, $votes, $rate) = split(/\|/, $datas[$i]);
		if ($lid == $id) 
		{
			$votes = $votes + 1;
			$rate = $rate + $link_rate;

			print FH "$lid|$name|$url|$desc|$date|$linkposter|$hits|$votes|$rate\n";
		}
		else { print FH "$datas[$i]\n"; }
	}

	close(FH);

	# Display a success message.
	print_header($cookie_link);
	print_html($user_data{theme}, "$nav{5} >>> $nav{31}");

	print $inf{18};

	print_html($user_data{theme}, "$nav{5} >>> $nav{31}", 1);
}
