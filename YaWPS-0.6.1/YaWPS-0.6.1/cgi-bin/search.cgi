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
# $Id: search.cgi,v 1.9 2003/01/18 13:19:22 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$search_term $match $case @what
	%user_data 
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$search_term = $query->param('query');
$match = $query->param('match') || 'OR'; 
$case = $query->param('case') || 'Insensitive';
@what = $query->param('what');

# Get user profile.
%user_data = authenticate();

if (!@what) { @what = ('all'); }

# Check if input is valid.
if (!$search_term || length($search_term) < 3 || length($search_term) > 50) { user_error($err{6}, $user_data{theme}); }

my @search_term = split(/\s+/, $search_term);

my (@matches, @data, @sorted_matches);

# Perform search.
foreach my $what (@what)
{
	if ($what eq 'articles' || $what eq 'all')
	{
		# Search for articles.
		opendir(DIR, "$cfg{topicsdir}");
		my @cats = readdir(DIR);
		closedir(DIR);

		@cats = grep(/\.cat/, @cats);

		# Cycle through the categories.
		foreach my $cat (@cats) 
		{
			sysopen(FH, "$cfg{topicsdir}/$cat", O_RDONLY);
			chomp(my @cat_data = <FH>);
			close(FH);

			$cat =~ s/\.cat//;

			# Build index.
			foreach my $topic (@cat_data)
			{
				my ($id, $subject, $nick, $poster, $email, $postdate, $comments, $views) = split(/\|/, $topic);

				# Get the text for the current article.
				if (-e("$cfg{articledir}/$id.txt"))
				{
					sysopen (FH, "$cfg{articledir}/$id.txt", O_RDONLY);
					chomp(my $text = <FH>);
					close(FH);

					# Search in message title and body.
					my @text = split(/\|/, $text);
					my $string = join(" ", $text[0], $text[5]);

					my $found = do_search($string);

					if ($found) { push(@matches, join("|", $id, $subject, $nick, $poster, $cat, 'articles')); }
				}
			}
		}
	}

	if ($what eq 'forumposts' || $what eq 'all')
	{
		# Search for forumposts.
		opendir(DIR, "$cfg{boardsdir}");
		my @cats = readdir(DIR);
		closedir(DIR);

		@cats = grep(/\.txt/, @cats);

		# Cycle through the categories.
		foreach my $cat (@cats) 
		{
			sysopen(FH, "$cfg{boardsdir}/$cat", O_RDONLY);
			chomp(my @cat_data = <FH>);
			close(FH);

			$cat =~ s/\.txt//;

			# Build index.
			foreach my $topic (@cat_data)
			{
				my ($id, $subject, $nick, $poster, undef, undef, undef, undef, undef, undef, undef) = split(/\|/, $topic);

				# Get the text for the current article.
				if (-e("$cfg{messagedir}/$id.txt"))
				{
					sysopen(FH, "$cfg{messagedir}/$id.txt", O_RDONLY);
					chomp(my $text = <FH>);
					close(FH);

					# Search in message title and body.
					my @text = split(/\|/, $text);
					my $string = join(" ", $text[0], $text[7]);

					my $found = do_search($string);

					if ($found) { push(@matches, join("|", $id, $subject, $nick, $poster, $cat, 'forumposts')); }
				}
			}
		}
	}

	if ($what eq 'links' || $what eq 'all')
	{
		# Search for links.
		opendir(DIR, "$cfg{linksdir}");
		my @cats = readdir(DIR);
		closedir(DIR);

		@cats = grep(/\.dat/, @cats);

		# Cycle through the categories.
		foreach my $cat (@cats) 
		{
			next if ($cat eq 'linkcats.dat');

			sysopen(FH, "$cfg{linksdir}/$cat", O_RDONLY);
			chomp(my @cat_data = <FH>);
			close(FH);

			$cat =~ s/\.dat//;

			# Build index.
			foreach my $topic (@cat_data)
			{
				my ($id, $subject, undef, $desc, undef, $poster, undef) = split(/\|/, $topic);

				# Search in entry's title and body.
				my $string = join(" ", $subject, $desc);

				my $found = do_search($string);

				if ($found) { push(@matches, join("|", $id, $subject, '', $poster, $cat, 'links')); }
			}
		}
	}

	if ($what eq 'pages' || $what eq 'all')
	{
		# Search for pages.
		my @cat_data;
		if (-e("$cfg{pagesdir}/pages.dat"))
		{
			sysopen(FH, "$cfg{pagesdir}/pages.dat", O_RDONLY);
			chomp(@cat_data = <FH>);
			close(FH);
		}

		foreach my $cat (@cat_data)
		{
			my ($id, $subject) = split(/\|/, $cat);

			# Get page content.
			sysopen(FH, "$cfg{pagesdir}/$id.txt", O_RDONLY);
			chomp(my $content = <FH>);
			close(FH);

			# Search in page's title and body.
			my $string = join(" ", $id, $content);

			my $found = do_search($string);

			if ($found) { push(@matches, join("|", $id, $subject, '', $usr{admin}, '', 'pages')); }
		}
	}
}

for (0 .. $#matches) 
{
	my @fields = split(/\|/, $matches[$_]);
	for my $i (0 .. $#fields) { $data[$_][$i] = $fields[$i]; }
}

# Sort the matches by category.
my @sorted = sort { $a->[5] cmp $b->[5] } @data;
for (@sorted) 
{ 
	my $sorted_row = join("|", @$_);
	push(@sorted_matches, $sorted_row);
}

print_header();
print_html($user_data{theme}, $nav{39});

print <<"HTML";
<b>$msg{172} $msg{166}:</b><br>
<form action="$cfg{pageurl}/search.$cfg{ext}" method="post" name="sform" onsubmit="if (document.sform.query.value=='') return false">
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
<td valign="top"><table border="0" cellpadding="2" cellspacing="0">
<tr>
<td><b>$msg{173}:</b></td>
<td><input name="query" type="text" size="20" value="" maxlength="256"></td>
</tr>
<tr>
<td><b>$msg{177}:</b></td>
<td><select name="match">
<option value="AND">AND</option>
<option value="OR">OR</option>
</select></td>
</tr>
<tr>
<td><b>$msg{178}:</b></td>
<td><select name="case">
<option value="Insensitive">Insensitive</option>
<option value="Sensitive">Sensitive</option>
</select></td>
</tr>
</table>
</td>
<td valign="top"><table border="0" cellpadding="2" cellspacing="0">
<tr>
<td valign="top"><b>$msg{170}:</b></td>
<td><select name="what" size="4" multiple>
<option value="articles">$nav{4}</option>
<option value="forumposts">$nav{3}</option>
<option value="links">$nav{5}</option>
<option value="pages">$nav{37}</option>
</select></td>
</tr>
</table></td>
</tr>
<tr>
<td><input type="submit" value="$btn{1}"></td>
</tr>
</table>
</form>
<hr size="1">
HTML

# Print the results.
if (!@sorted_matches) { print "<b>$msg{176}</b>"; }
else
{
	my $sorted_matches = @sorted_matches;

	my $result = $sorted_matches . " " . $msg{169};
	if ($sorted_matches == 1) { $result = $sorted_matches . " " . $msg{174}; }

	print <<"HTML";
<table border="0" cellpadding="0" cellspacing="5" width="100%">
<tr>
<td><b>$msg{167} "<i>$search_term</i>".<br>
$msg{168} $result.</b></td>
</tr>
HTML

	for (my $i = 0; $i < @sorted_matches; $i++)
	{
		my ($id, $subject, $nick, $poster, $cat, $type) = split(/\|/, $sorted_matches[$i]);

		print <<"HTML";
<tr>
<td><img src="$cfg{imagesurl}/urlgo.gif" border="0" alt="">&nbsp;&nbsp;
HTML

		if ($type eq 'articles')
		{
			print qq($nav{4}: <b><a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cat;id=$id">$subject</a></b><br>\n);
		}
		if ($type eq 'forumposts')
		{
			print qq($nav{3}: <b><a href="$cfg{pageurl}/forum.$cfg{ext}?op=view_thread;board=$cat;thread=$id">$subject</a></b><br>\n);
		}
		if ($type eq 'links')
		{
			# Get nick of link poster.
			my @user_profile;
			if (-e("$cfg{memberdir}/$poster.dat"))
			{
				sysopen(FH, "$cfg{memberdir}/$poster.dat", O_RDONLY);
				chomp(@user_profile = <FH>);
				close(FH);
			}

			$nick = $user_profile[1];

			print qq($nav{5}: <b><a href="$cfg{pageurl}/links.$cfg{ext}?op=view_link;cat=$cat;id=$id">$subject</a></b><br>\n);
		}
		if ($type eq 'pages') 
		{ 
			$nick = $poster;

			print qq($nav{37}: <b><a href="$cfg{pageurl}/pages.$cfg{ext}?id=$id">$subject</a></b><br>\n); 
		}

		print "<small>" . $msg{47} . " ";

		if ($poster eq $usr{anonuser} || $poster eq $usr{admin}) { print $nick; }
		else { print qq(<a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$poster">$nick</a>); }

		print <<"HTML";
</small></td>
</tr>
HTML
	}

	print "</table>";
}

print_html($user_data{theme}, $nav{39}, 1);

# ---------------------------------------------------------------------
# Perform boolean search in given text string.
# ---------------------------------------------------------------------
sub do_search
{
	my $string = shift;
	my $found = 0;

	if ($match eq 'AND') 
	{
		foreach my $term (@search_term) 
		{
			if ($case eq 'Insensitive') 
			{
				if (!($string =~ /$term/i)) { $found = 0; last; }
				else { $found = 1; }
			}
			if ($case eq 'Sensitive') 
			{
				if (!($string =~ /$term/)) { $found = 0; last; }
				else { $found = 1; }
			}
		}
	}

	if ($match eq 'OR') 
	{
		foreach my $term (@search_term) 
		{
			if ($case eq 'Insensitive') 
			{
				if ($string =~ /$term/i) { $found = 1; last; }
				else { $found = 0; }
			}
			if ($case eq 'Sensitive') 
			{
				if (!($string =~ /$term/)) { $found = 1; last; }
				else { $found = 0; }
			}
		}
	}

	return $found;
}
