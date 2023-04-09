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
# $Id: user.cgi,v 1.12 2002/12/15 11:34:23 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $username $password1 $password2 $nick $email $website $website_url $signature $forum_posts
	$sec_level $icq $member_pic $member_pic_personal $member_pic_personal_check $joined
	$topic_posts $comments $theme $moda
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$username = $query->param('username');
$password1 = $query->param('password1');
$password2 = $query->param('password2');
$nick = $query->param('nick');
$email = $query->param('email');
$website = $query->param('website');
$website_url = $query->param('website_url');
$signature = $query->param('signature');
$forum_posts = $query->param('forum_posts');
$sec_level = $query->param('sec_level');
$icq = $query->param('icq');
$member_pic = $query->param('member_pic');
$member_pic_personal = $query->param('member_pic_personal');
$member_pic_personal_check = $query->param('member_pic_personal_check');
$joined = $query->param('joined') || '';
$topic_posts = $query->param('topic_posts');
$comments = $query->param('comments');
$theme = $query->param('theme');
$moda = $query->param('moda');

# Get user profile.
%user_data = authenticate();

# Define possible user actions.
%user_action = (
	edit_profile => \&edit_profile,
	edit_profile2 => \&edit_profile2
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { view_profile(); }

# ---------------------------------------------------------------------
# Display user's profile.
# ---------------------------------------------------------------------
sub view_profile
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	if ($username =~ /\//) { user_error($err{4}, $user_data{theme}); }
	if ($username =~ /\\/) { user_error($err{4}, $user_data{theme}); }


	sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
	chomp(my @user_profile = <FH>);
	close(FH);

	# User picture.
	my $member_pic;
	if (!$user_profile[9]) { $user_profile[9] = '_nopic.gif'; }
	if ($user_profile[9] =~ /http:\/\//) 
	{
		my ($width, $height);
		if ($cfg{picture_width} != 0) { $width = "width=\"$cfg{picture_width}\""; } 
		else { $width = ""; }

		if ($cfg{picture_height} != 0) { $height = "height=\"$cfg{picture_height}\""; } 
		else { $height = ""; }

		$member_pic = qq(<img src="$user_profile[9]" $width $height border="0" alt=""></a>);
	}
	else { $member_pic = qq(<img src="$cfg{imagesurl}/avatars/$user_profile[9]" border="0" alt=""></a>); }

	# Get member ranks.
	sysopen(FH, "$cfg{memberdir}/membergroups.dat", O_RDONLY);
	my @member_ranks = <FH>;
	close(FH);

	my $member_info = $member_ranks[0];

	my $ranking = $user_profile[6] + $user_profile[11] + $user_profile[12];

	if ($ranking > 25) { $member_info = $member_ranks[1]; }
	if ($ranking > 50) { $member_info = $member_ranks[2]; }
	if ($ranking > 75) { $member_info = $member_ranks[3]; }
	if ($ranking > 100) { $member_info = $member_ranks[4]; }
	if ($ranking > 250) { $member_info = $member_ranks[5]; }
	if ($ranking > 500) { $member_info = $member_ranks[6]; }
	if ($user_profile[7] ne "") { $member_info = $user_profile[7]; }

	print_header();
	print_html($user_data{theme}, $nav{17});

	print <<"HTML";
<table border="0" width="100%" cellspacing="1">
<tr>
<td><div class="texttitle">$user_profile[1]</div> 
HTML

	# Print link to edit profile and link to send IMs.
	if ($username eq $user_data{uid} || $user_data{sec_level} eq $usr{admin}) { print qq([<a href="$cfg{pageurl}/user.$cfg{ext}?op=edit_profile;username=$username">$nav{16}</a>]); }
	if ($username ne $user_data{uid}) { print qq( [<a href="$cfg{pageurl}/instant_messenger.$cfg{ext}?op=send_im;to=$username">$nav{18}</a>]); }

	print <<"HTML";
</td>
</tr>
<tr>
<td>
<table border="0">
<tr>
<td><b>$msg{13}</b></td>
<td>$user_profile[1]</td>
</tr>
<tr>
<td><b>$msg{7}</b></td>
<td><a href="mailto:$user_profile[2]">$user_profile[2]</a></td>
</tr>
<tr>
<td><b>$msg{14}</b></td>
<td><a href="$user_profile[4]" target="_blank">$user_profile[3]</a></td>
</tr>
<tr>
<td><b>$msg{16}</b></td>
<td>$user_profile[8]</td>
</tr>
<tr>
<td><b>$msg{21}</b></td>
<td>$user_profile[6]</td>
</tr>
<tr>
<td><b>$msg{22}</b></td>
<td>$user_profile[11]</td>
</tr>
<tr>
<td><b>$msg{23}</b></td>
<td>$user_profile[12]</td>
</tr>
<tr>
<td><b>$msg{24}</b></td>
<td>$member_info</td>
</tr>
<tr>
<td><b>$msg{27}</b></td>
<td>$user_profile[10]</td>
</tr>
<tr>
<td valign="top"><b>$msg{18}</b></td>
<td>$member_pic</td>
</tr>
</table>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, $nav{29}, 1);
}

# ---------------------------------------------------------------------
# Display formular to edit user's profile.
# ---------------------------------------------------------------------
sub edit_profile 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	if ($username =~ /\//) { user_error($err{4}, $user_data{theme}); }
	if ($username =~ /\\/) { user_error($err{4}, $user_data{theme}); }

	sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
	chomp(my @user_profile = <FH>);
	close(FH);

	# Check if user has permissions to edit other user's profile.
	if ($user_data{uid} ne $username && $user_data{sec_level} ne $usr{admin}) { user_error($err{11}, $user_data{theme}); }

	my $signature = $user_profile[5];
	$signature =~ s/\&\&/\n/g;

	print_header();
	print_html($user_data{theme}, $nav{16});

	print <<"HTML";
<table border="0" cellspacing="1">
<tr>
<td><form action="$cfg{pageurl}/user.$cfg{ext}" method="post" name="creator">
<table border="0">
<tr>
<td><b>$msg{6}</b></td>
<td><input type="hidden" name="username" value="$username">$username</td>
</tr>
<tr>
<td><b>$msg{9}</b></td>
<td><input type="password" name="password1" size="20" value="$user_profile[0]">*</td>
</tr>
<tr>
<td><b>$msg{9}</b></td>
<td><input type="password" name="password2" size="20" value="$user_profile[0]">*</td>
</tr>
<tr>
<td><b>$msg{13}</b></td>
<td><input type="text" name="nick" size="40" value="$user_profile[1]">*</td>
</tr>
<tr>
<td><b>$msg{7}</b></td>
<td><input type="text" name="email" size="40" value="$user_profile[2]">*</td>
</tr>
<tr>
<td><b>$msg{14}</b></td>
<td><input type="text" name="website" size="40" value="$user_profile[3]"></td>
</tr>
<tr>
<td><b>$msg{15}</b></td>
<td><input type="text" name="website_url" size="40" value="$user_profile[4]"></td>
</tr>
<tr>
<td><b>$msg{16}</b></td>
<td><input type="text" name="icq" size="40" value="$user_profile[8]"></td>
</tr>
<tr>
<td valign="top"><b>$msg{17}</b></td>
<td><textarea name="signature" rows="4" cols="35" wrap="virtual">$signature</textarea></td>
</tr>
<tr>
<td valign="top"><b>$msg{161}</b></td>
<td><select name="theme">
HTML

	# Get list of installed themes.
	opendir(DIR, "$cfg{themesdir}");
	my @themes = readdir(DIR);
	closedir(DIR);

	foreach (sort @themes) 
	{
	        next if ($_ eq '.' || $_ eq '..');

		my ($theme_name, $extension) = split (/\./, $_);
		if (!$extension) 
		{ 
			if ($user_profile[13] eq $theme_name) { print qq(<option value="$theme_name" selected>$theme_name</option>\n); }
			else { print qq(<option value="$theme_name">$theme_name</option>\n); }
		}
	}

	print <<"HTML";
</select>
</td>
</tr>
HTML

	# Get available avatars.
	opendir(DIR, "$cfg{imagesdir}/avatars");
	my @contents = readdir(DIR);
	closedir(DIR);

	my ($images, $checked, $pic_name, $pic, $http) = '';
	if ($user_profile[9] eq '') { $user_profile[9] = "_nopic.gif"; }
	foreach (sort @contents) 
	{
		my ($name, $extension) = split (/\./, $_);
		$extension = lc($extension);

		$checked = ($_ eq $user_profile[9]) ? 'selected' : '';
		if ($user_profile[9] =~ m/http:\/\// && $_ eq '') { $checked = " selected"; }
		if ($extension =~ /gif/i || $extension =~ /jpg/i || $extension =~ /jpeg/i || $extension =~ /png/i )
		{
			if ($_ eq "_nopic.gif") { $pic = "_nopic.gif"; $name = "Kein Bild!"; }
			$images .= qq(<option value="$_"$checked>$name</option>\n);
		}
	}
	if ($user_profile[9] =~ m/http:\/\//) 
	{
		$pic = $user_profile[9];
		$checked = " checked";
		$http = $user_profile[9];
	}
	else {
		$pic = $cfg{imagesurl} . "/avatars/" . $user_profile[9];
		$http = "http://";
	}

	print <<"HTML";
<tr>
<td valign="top"><b>$msg{18}</b></td>
<td valign="top">
<table>
<tr>
<td>$msg{12}</td>
</tr>
<tr>
<td><script language="javascript" type="text/javascript">
<!--
function showImage() {
document.images.avatars.src="$cfg{imagesurl}/avatars/"+document.creator.member_pic.options[document.creator.member_pic.selectedIndex].value;
}
// -->
</script>
<select name="member_pic" onChange="showImage()" size="6">
$images</select>
<img src="$pic" name="avatars" border="0" hspace="15"></td>
</tr>
<tr>
<td>$msg{20}</td>
</tr>
<tr>
<td><input type="checkbox" name="member_pic_personal_check"$checked>
<input type="text" name="member_pic_personal" size="40" value="$http"><br>
$msg{19}</td>
</tr>
</table>
</td>
</tr>
HTML

	# Print actions for admins..
	if ($user_data{sec_level} eq $usr{admin}) 
	{
		my $pos = '';
		my @userlevel = ($usr{admin}, $usr{mod}, $usr{user});

		if (!$user_profile[7]) 
		{ 
			foreach my $i (@userlevel[0..1]) 
			{
				if ($user_profile[7] eq $i) { $pos = qq($pos<option value="$i" selected>$i</option>\n); }
				else { $pos = qq($pos<option value="$i">$i</option>\n); }
			}
			$pos = qq($pos<option value="" selected>$userlevel[2]</option>\n); 
		}
		else 
		{
			foreach my $i (@userlevel[0..1]) 
			{
				if ($user_profile[7] eq $i) { $pos = qq($pos<option value="$i" selected>$i</option>\n); }
				else { $pos = qq($pos<option value="$i">$i</option>\n); }
			}
			$pos = qq($pos<option value="">$userlevel[2]</option>\n); 
		}		

		print <<"HTML";
<tr>
<td><b>$msg{21}</b></td>
<td><input type="text" name="forum_posts" size="4" value="$user_profile[6]"></td>
</tr>
<tr>
<td><b>$msg{22}</b></td>
<td><input type="text" name="topic_posts" size="4" value="$user_profile[11]"></td>
</tr>
<tr>
<td><b>$msg{23}</b></td>
<td><input type="text" name="comments" size="4" value="$user_profile[12]"></td>
</tr>
<tr>
<td><b>$msg{24}</b></td>
<td><select name="sec_level">
$pos</select></td>
</tr>
<tr>
<td colspan="2">* $msg{25}</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="joined" value="$user_profile[10]">
HTML
	}
	else 
	{
		print <<"HTML";
<tr>
<td colspan="2">* $msg{25}</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="forum_posts" value="$user_profile[6]">
<input type="hidden" name="joined" value="$user_profile[10]">
<input type="hidden" name="topic_posts" value="$user_profile[11]">
<input type="hidden" name="comments" value="$user_profile[12]">
HTML
	}

	print <<"HTML";
<input type="hidden" name="op" value="edit_profile2">
<input type="submit" name="moda" value="$btn{6}">
<input type="submit" name="moda" value="$btn{7}"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, $nav{16}, 1);
}

# ---------------------------------------------------------------------
# Update user's profile.
# ---------------------------------------------------------------------
sub edit_profile2 
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	if ($username =~ /\//) { user_error($err{4}, $user_data{theme}); }
	if ($username =~ /\\/) { user_error($err{4}, $user_data{theme}); }

	user_error($err{3}, $user_data{theme}) if (!$username);
	user_error($err{4}, $user_data{theme}) if ($username !~ /^[0-9A-Za-z#%+,-\.:=?@^_]+$/ || length($username) < 4 || length($username) > 20 || $username eq "|" || $username =~ " " || $username eq $usr{admin}  || $username eq $usr{mod} || $username eq $usr{user} || $username eq $usr{anonuser});
	user_error($err{11}, $user_data{theme}) if ($user_data{uid} ne $username && $user_data{sec_level} ne $usr{admin});
	user_error($err{11}, $user_data{theme}) if ($user_data{uid} ne 'admin' && $username eq 'admin');

	user_error($err{12}, $user_data{theme}) if ($password1 ne $password2);
	user_error($err{9}, $user_data{theme}) if (!$password1);

	user_error($err{6}, $user_data{theme}) if ($nick !~ /^[0-9A-Za-z#%+,-\.:=?@^_]+$/ || $nick eq "|" || $nick =~ " " || $nick eq $usr{admin} || $nick eq $usr{mod} || $nick eq $usr{user} || $nick eq $usr{anonuser});
	user_error($err{13}, $user_data{theme}) if (!$nick);

	user_error($err{5}, $user_data{theme}) if (!$email);
	user_error($err{6}, $user_data{theme}) if ($email !~ /^[0-9A-Za-z@\._\-]+$/ || $email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(\.$)/ || $email !~ /\A.+@\[?(\w|[-.])+\.[a-zA-Z]{2,4}|[0-9]{1,4}\]?\Z/);

	# Picture validtaion.
	if ($member_pic_personal_check && ($member_pic_personal =~ m/\.gif\Z/i || $member_pic_personal =~ m/\.jpg\Z/i || $member_pic_personal =~ m/\.jpeg\Z/i || $member_pic_personal =~ m/\.png\Z/i)) { $member_pic = $member_pic_personal; }
	if ($member_pic !~ m^\A[0-9a-zA-Z_\.\#\%\-\:\+\?\$\&\~\.\,\@/]+\Z^) { user_error($err{6}, $user_data{theme}); }

	# Get current user profile.
	sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
	chomp(my @user_profile = <FH>);
	close(FH);

	# Password validation.
	my $password;
	if ($password1 eq $user_profile[0]) { $password = $password1; }
	else { $password = crypt($password1, substr($username, 0, 2)); }

	# Check for probably unsafe data.
	if ($username =~ /^([\w.]+)$/) { $username = $1; } 
	else { die "Unsafe data in $cfg{memberdir}/$username.dat detected"; }

	# Update user profile.
	if ($moda eq $btn{6}) 
	{
		if (!$signature) { $signature = $msg{26}; }
		$signature =~ s/\n/\&\&/g;
		$signature =~ s/\r//g;

		if ($member_pic eq "_nopic.gif") { $member_pic = ''; }
		if (!$forum_posts) { $forum_posts = 0; }
		if (!$topic_posts) { $topic_posts = 0; }
		if (!$comments) { $comments = 0; }

		sysopen(FH, "$cfg{memberdir}/$username.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{memberdir}/$username.dat. ($!)", $user_data{theme});
		flock(FH, LOCK_EX) if $cfg{use_flock};

		print FH "$password\n";
		print FH "$nick\n";
		print FH "$email\n";
		print FH "$website\n";
		print FH "$website_url\n";
		print FH "$signature\n";
		print FH "$forum_posts\n";
		print FH "$sec_level\n";
		print FH "$icq\n";
		print FH "$member_pic\n";
		print FH "$joined\n";
		print FH "$topic_posts\n";
		print FH "$comments\n";
		print FH "$theme\n";

		close(FH);

		if ($user_data{uid} eq $username) 
		{
			# Set new cookie.
			my $cookie_username = $query->cookie(-name=>'yawps_uid', -value=>$user_data{uid}, -path=>'/', -expires=>$cfg{cookie_expire});
			my $cookie_password = $query->cookie(-name=>'yawps_pwd', -value=>$password, -path=>'/', -expires=>$cfg{cookie_expire});

			# Redirect to the welcome page.
			print $query->redirect(-location=>$cfg{pageurl} . '/login.' . $cfg{ext} . '?op=login3', -cookie=>[$cookie_username, $cookie_password]);
		}
		else { print $query->redirect(-location=>$cfg{pageurl} . '/user.' . $cfg{ext} . '?op=view_profile;username=' . $username); }
	} 
	# Delete user.
	else 
	{
		unlink("$cfg{memberdir}/$username.dat");
		unlink("$cfg{memberdir}/$username.msg");
		unlink("$cfg{memberdir}/$username.log");

		sysopen(FH, "$cfg{memberdir}/memberlist.dat", O_RDONLY);
		chomp(my @members = <FH>);
		close(FH);

		# Update memberlist.
		sysopen(FH, "$cfg{memberdir}/memberlist.dat", O_WRONLY | O_TRUNC);
		flock(FH, LOCK_EX) if $cfg{use_flock};

		foreach my $i (@members) 
		{
			if ($i ne $username) { print FH "$i\n"; }
		}

		close(FH);

		if ($user_data{uid} eq $username) 
		{ 
			# Empty cookie values.
			my $cookie_username = $query->cookie(-name=>'yawps_uid', -value=>'', -path=>'/', -expires=>'now');
			my $cookie_password = $query->cookie(-name=>'yawps_pwd', -value=>'', -path=>'/', -expires=>'now');

			# Redirect to the logout page.
			print $query->redirect(-location=>$cfg{pageurl} . '/login.' . $cfg{ext} . '?op=logout2', -cookie=>[$cookie_username, $cookie_password]);

		}
		else { print $query->redirect(-location=>$cfg{pageurl} . '/index.' . $cfg{ext}); }
	}
}
