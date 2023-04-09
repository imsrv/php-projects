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
# $Id$
# =====================================================================

# ---------------------------------------------------------------------
# Print the page header.
# ---------------------------------------------------------------------
sub theme_top
{
	my $location = shift;

	# Include blocks.
	my $meta_tags = get_meta_tags() || '';
	my $date = get_formatted_date();
	my $main_menu = main_menu();
	my $user_panel = user_panel(); 
	my $user_status = user_status();
	my $blocks = show_blocks("header") || '';

	print <<"HTML";
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=$cfg{codepage}">
$meta_tags<meta name="Generator" content="YaWPS $VERSION">
<title>$cfg{pagetitle}</title>
<link rel="stylesheet" href="$cfg{themesurl}/standard/style.css" type="text/css">

</head>

<body bgcolor="#ffffff" text="#000000" link="#660033" alink="#ff9900" vlink="#660033">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>
<table class="bg3" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><img src="$cfg{themesurl}/standard/images/logo.gif" width="194" height="60" alt=""></td>
<td align="right" valign="bottom" class="time">&nbsp;$date&nbsp;</td>
</tr>
</table>
</td>
</tr>
<tr>
<td height="21">
<table class="bg" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="18%" align="center">&nbsp;<a href="$cfg{pageurl}/index.cgi" class="nav">$nav{2}</a>&nbsp;</td>
<td width="16%" align="center">&nbsp;<a href="$cfg{pageurl}/forum.cgi" class="nav">$nav{3}</a>&nbsp;</td>
<td width="18%" align="center">&nbsp;<a href="$cfg{pageurl}/topics.cgi" class="nav">$nav{4}</a>&nbsp;</td>
<td width="16%" align="center">&nbsp;<a href="$cfg{pageurl}/stats.cgi" class="nav">$nav{6}</a>&nbsp;</td>
<td width="16%" align="center">&nbsp;<a href="$cfg{pageurl}/top10.cgi" class="nav">$nav{7}</a>&nbsp;</td>
<td width="16%" align="center">&nbsp;<a href="$cfg{pageurl}/recommend.cgi" class="nav">$nav{8}</a>&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="5" width="100%">
<tr>
<td valign="top" width="150">
<table width="150">
<tr>
<td>
HTML

	# Display the main menu.
	print $main_menu;

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	# Display the searchbox.
	print box_header($nav{39});
	print <<"HTML";
<tr>
<td align="center">
<form action="$cfg{pageurl}/search.cgi" method="post" name="sbox" onSubmit="if (document.sbox.query.value=='') return false">
<input type="text" name="query" size="9" class="text"><br>
<input type="submit" value="$btn{1}">
</form>
</td>
</tr>
HTML
	print box_footer();

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	# Display the user panel.
	print $user_panel;

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	# Display the user status.
	print $user_status;

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	# Display the user blocks.
	print $blocks;

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	print <<"HTML";
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="150">
<tr>
<td align="center">
<table border="0" cellpadding="3" cellspacing="0">
<tr>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td align="center"><a href="http://validator.w3.org/check/referer" target="_blank"><img border="0" src="$cfg{themesurl}/standard/images/valid-html401.gif" alt="Valid HTML 4.01!" height="31" width="88"></a></td>
</tr>
<tr>
<td align="center"><a href="http://jigsaw.w3.org/css-validator" target="_blank"><img width="88"height="31" border="0" src="$cfg{themesurl}/standard/images/vcss.gif" alt="Valid CSS!"></a></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td valign="top" width="100%">
<table width="100%">
<tr>
<td width="100%">
<table class="bg5" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="100%" class="cathdl">&nbsp;$location</td>
</tr>
</table>
<table class="bg2" border="0" cellpadding="1" cellspacing="0" width="100%">
<tr>
<td width="100%">
<table class="bg2" border="0" cellpadding="3" cellspacing="0" width="100%">
<tr>
<td valign="top" width="100%">
HTML
}

# ---------------------------------------------------------------------
# Print the page footer.
# ---------------------------------------------------------------------
sub theme_bottom
{
	my $location = shift;

	# Include blocks.
	my $current_poll = current_poll();
	my $latest_forum_posts = latest_forum_posts();
	my $blocks = show_blocks("footer") || '';
	my $quote = show_quote();
	my $im_alert = check_ims() || '';

	print <<"HTML";
<br><br>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td valign="top" width="150">
<table width="150">
<tr>
<td>
HTML

	# Display the latest forum posts.
	print $latest_forum_posts;

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	# Display the current poll.
	print $current_poll;

	print <<"HTML";
</td>
</tr>
<tr>
<td>
HTML

	# Display the user blocks.
	print $blocks;

	print <<"HTML";
</td>
</tr>
</table>
</td>
</tr>
</table>

<p>&nbsp;
<p align="center">$quote
<p>&nbsp;

<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td align="center" class="copyleft">
This web site was made with <a href="http://yawps.sourceforge.net/" target="_blank">YaWPS</a>, a lightweight web portal system written in Perl by d3m1g0d.<br>
YaWPS is Free Software released under the <a href="http://www.gnu.org/" target="_blank">GNU/GPL license</a>, version 2 or later.<br>
You can syndicate our news using the file <a href="$cfg{yawpsnewsurl}/yawpsnews.xml">yawpsnews.xml</a>.<br>
<br>
<a href="http://yawps.sourceforge.net/" target="_blank"><img alt="Powered by YaWPS!" border="0" height="37" src="$cfg{themesurl}/standard/images/pb_yawps.gif" width="102"></a>
</td>
</tr>
</table>
$im_alert
</body>

</html>
HTML
}

# ---------------------------------------------------------------------
# Print a menu item.
# ---------------------------------------------------------------------
sub menu_item 
{
	my ($page, $title) = @_;
	my $menu_item = <<"HTML";
<tr>
<td class="cat">>>>&nbsp;<a href="$page" class="menu">$title</a></td>
</tr>
HTML

	return $menu_item;
}

# ---------------------------------------------------------------------
# Print the header of a menu box.
# ---------------------------------------------------------------------
sub box_header 
{
        my $title = shift;

	my $box_header = <<"HTML";
<table class="bg5" border="0" cellpadding="0" cellspacing="0" width="150">
<tr>
<td width="100%" class="cathdl">&nbsp;$title</td>
</tr>
</table>
<table class="bg5" border="0" cellpadding="1" cellspacing="0" width="150">
<tr>
<td width="100%">
<table class="bg2" border="0" cellpadding="3" cellspacing="0" width="100%">
HTML

	return $box_header;
}

# ---------------------------------------------------------------------
# Print the footer of a menu box.
# ---------------------------------------------------------------------
sub box_footer 
{
	my $box_footer = <<"HTML";
</table>
</td>
</tr>
</table>
HTML

	return $box_footer;
}

# ---------------------------------------------------------------------
# Get the current date.
# ---------------------------------------------------------------------
sub get_formatted_date 
{
	my ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime(time + 3600 * $cfg{time_offset});

	$year += 1900;
	$time = $week_days{$wday} . ", " . $mday . " " . $months{$mon} . " " . $year;

	return $time;
}

1;
