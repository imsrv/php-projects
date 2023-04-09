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
# $Id: index.cgi,v 1.10 2002/12/15 11:34:22 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Get user profile.
my %user_data = authenticate();

# Get the welcome message.
sysopen(FH, "$cfg{datadir}/welcomemsg.txt", O_RDONLY);
chomp(my @welcome_message = <FH>);
close(FH);

# Print start page.
print_header();
print_html($user_data{theme}, $nav{2});
 
# Print welcome message.
print <<"HTML";
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><p class="texttitle">$welcome_message[0]</p>
$welcome_message[1]<br>
<br><br></td>
</tr>
</table>
HTML

my (@articles, @data, @top_news);

# Get article data.
opendir (DIR, "$cfg{topicsdir}");
my @cats = readdir(DIR);
closedir (DIR);

@cats = grep(/\.cat/, @cats);

# Cycle through the categories.
foreach my $cat (@cats) 
{
	sysopen(FH, "$cfg{topicsdir}/$cat", O_RDONLY);
	chomp(my @topic_data = <FH>);
	close(FH);

	for (my $i = 0; $i < @topic_data; $i++) 
	{
		my ($id, $subject, $nick, $poster, $email, $postdate, $comments, $views) = split(/\|/, $topic_data[$i]);
		push (@articles, join ("\|", $id, $subject, $nick, $poster, $email, $postdate, $comments, $views, $cat));
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
for (my $i = 0; $i < @top_news && $i < $cfg{max_news}; $i++) 
{
	my ($id, $subject, $nick, $poster, $email, $postdate, $comments, $views, $cat) = split(/\|/, $top_news[$i]);

	# Get correct category name and link.
	my ($cat_link, undef) =  split(/\./, $cat);

	sysopen(FH, "$cfg{topicsdir}/cats.dat", O_RDONLY);
	chomp(@cats = <FH>);
	close(FH);

	my $cat_name;
	foreach my $j (@cats)
	{
		my ($name, $link) = split(/\|/, $j);
		if ($cat_link eq $link) { $cat_name = $name; }
	}

	# Comments counter format.
	my $comments_count;
	if ($comments == 1) { $comments_count = $comments . " " . $msg{40}; }
	else { $comments_count = $comments . " " . $msg{41}; }

	# Get the text for the current article.
	sysopen(FH, "$cfg{articledir}/$id.txt", O_RDONLY);
	chomp(my $text = <FH>);
	close(FH);

	my @text = split(/\|/, $text);

	# Format text.
	my $message = do_ubbc($text[5]);

	print <<"HTML";
<hr noshade="noshade" size="1">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="texttitle">$subject</td>
</tr>
<tr>
<td class="textsmall">$cat_name: $postdate $msg{42} <a href="$cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$poster">$nick</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td valign="top">
HTML

	# Make a preview of the topic.
	if (length($message) > 250) 
	{
		my $tmp_message = substr($message, 0, 250);
		$tmp_message =~ s/(.*)\s.*/$1/;
		print <<"HTML";
<img src="$cfg{imagesurl}/topics/$cat_link.gif" border="0" align="right" vspace="5" alt="$cat_name">
$tmp_message ...
</td>
</tr>
<tr>
<td align="right">[<a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cat_link;id=$id">$nav{25}</a>] [<a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cat_link;id=$id">$comments_count</a>]</td>
</tr>
</table>
HTML
	}

	# Topic is shorter than 250 bytes.
	else 
	{
		print <<"HTML";
<img src="$cfg{imagesurl}/topics/$cat_link.gif" border="0" align="right" vspace="5" alt="$cat_name">
$message
</td>
</tr>
<tr>
<td align="right">[<a href="$cfg{pageurl}/topics.$cfg{ext}?op=view_topic;cat=$cat_link;id=$id">$comments_count</a>]</td>
</tr>
</table>
HTML
	}
}

print_html($user_data{theme}, $nav{2}, 1);
