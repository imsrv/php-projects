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
# $Id: login.cgi,v 1.10 2003/01/07 17:44:00 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $username $password $remember
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$username = $query->param('username');
$password = $query->param('password');
$remember = $query->param('remember');

# Get user profile.
%user_data = authenticate();

# Define possible user actions.
%user_action = (
	login2 => \&login2,
	login3 => \&login3,
	logout => \&logout,
	logout2 => \&logout2,
	reminder => \&reminder,
	reminder2 => \&reminder2
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { login(); }

# ---------------------------------------------------------------------
# Display the login page.
# ---------------------------------------------------------------------
sub login
{
	# Check if user is already logged in.
	if ($user_data{uid} ne $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	print_header();
	print_html($user_data{theme}, $nav{12});

	print <<"HTML";
<form method="post" action="$cfg{pageurl}/login.$cfg{ext}">
<table border="0" cellspacing="1">
<tr>
<td>$msg{6}</td>
<td><input type="text" name="username" size="10" maxlength="50"></td>
</tr>
<tr>
<td>$msg{9}</td>
<td><input type="password" name="password" size="10" maxlength="50"></td>
</tr>
<tr>
<td colspan="2"><input type="checkbox" name="remember">&nbsp;$msg{195}</td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="login2"><input type="submit" value="$btn{17}"></td>
</tr>
<tr>
<td colspan="2"><br><a href="$cfg{pageurl}/login.$cfg{ext}?op=reminder">$nav{14}</a></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, $nav{12}, 1);
}

# ---------------------------------------------------------------------
# Log on the user.
# ---------------------------------------------------------------------
sub login2
{
	if (-e "$cfg{memberdir}/$username.dat" && $password) 
	{
		# Get user profile.
		sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY);
		chomp(my @user_data = <FH>);
		close(FH);

		# Encrypt the password.
		my $encrypted_password = crypt($password, substr($username, 0, 2));
		if ($user_data[0] ne $encrypted_password) { user_error($err{2}, $user_data{theme}); }

		# Check if user session should be stored in cookie.
		my $expire = $remember ? $cfg{cookie_expire} : 0;

		# Set the cookie.
		my $cookie_username = $query->cookie(-name=>'yawps_uid', -value=>$username, -path=>'/', -expires=>$expire);
		my $cookie_password = $query->cookie(-name=>'yawps_pwd', -value=>$encrypted_password, -path=>'/', -expires=>$expire);

		# Redirect to the welcome page.
		print $query->redirect(-location=>$cfg{pageurl} . '/login.' . $cfg{ext} . '?op=login3', -cookie=>[$cookie_username, $cookie_password]);
	}
	else { login(); }
}

# ---------------------------------------------------------------------
# Diplay user's personal page.
# ---------------------------------------------------------------------
sub login3
{
	# Check if user is logged in.
	if ($user_data{uid} eq $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	if (-e "$cfg{memberdir}/$user_data{uid}.dat") 
	{
		# Get user profile.
		sysopen(FH, "$cfg{memberdir}/$user_data{uid}.dat", O_RDONLY);
		chomp(my @user_data = <FH>);
		close(FH);

		print_header();
		print_html($user_data{theme}, $nav{50});
	
		print <<"HTML";
<p class="texttitle">$user_data[1], $msg{163}</p>
<b><u>$msg{164}</u></b><br>
<table>
<td valign="top">
<table>
<tr>
<td><b>$msg{7}</b></td>
<td><a href="mailto:$user_data[2]">$user_data[2]</a></td>
</tr>
<tr>
<td><b>$msg{14}</b></td>
<td><a href="$user_data[4]" target="_blank">$user_data[3]</a></td>
</tr>
<tr>
<td><b>$msg{16}</b></td>
<td>$user_data[8]</td>
</tr>
<tr>
<td><b>$msg{21}</b></td>
<td>$user_data[6]</td>
</tr>
<tr>
<td><b>$msg{22}</b></td>
<td>$user_data[11]</td>
</tr>
<tr>
<td><b>$msg{23}</b></td>
<td>$user_data[12]</td>
</tr>
</table>
</td>
HTML
	if ($user_data[9]) { print "<td><img src=\"$user_data[9]\" alt></td>\n"; }

	print <<"HTML";
</tr>
</table>
<br>
<b><u>$msg{165}</u></b><br>
<table>
<tr>
<td><a href="$cfg{pageurl}/user.$cfg{ext}?op=edit_profile;username=$user_data{uid}">$nav{16}</a><br>
<a href="$cfg{pageurl}/login.$cfg{ext}?op=logout">$nav{34}</a><br></td>
</tr>
</table>
HTML

		print_html($user_data{theme}, $nav{50}, 1);
	}
	else { user_error($err{6}, $user_data{theme}); }
}

# ---------------------------------------------------------------------
# Log off the user.
# ---------------------------------------------------------------------
sub logout
{
	# Empty cookie values.
	my $cookie_username = $query->cookie(-name=>'yawps_uid', -value=>'', -path=>'/', -expires=>'now');
	my $cookie_password = $query->cookie(-name=>'yawps_pwd', -value=>'', -path=>'/', -expires=>'now');

	# Redirect to the logout page.
	print $query->redirect(-location=>$cfg{pageurl} . '/login.' . $cfg{ext} . '?op=logout2', -cookie=>[$cookie_username, $cookie_password]);
}

# ---------------------------------------------------------------------
# Display logout page.
# ---------------------------------------------------------------------
sub logout2
{
	# Check if user is logged in.
	if ($user_data{uid} ne $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	# Print the logout page.
	print_header();
	print_html($user_data{theme}, $nav{34});

	print "$inf{17}<br>\n<a href=\"$cfg{pageurl}/index.$cfg{ext}\">$nav{52}</a>";

	print_html($user_data{theme}, $nav{34}, 1);
}

# ---------------------------------------------------------------------
# Display a formular, where user can reset his password.
# ---------------------------------------------------------------------
sub reminder
{
	# Check if user is already logged in.
	if ($user_data{uid} ne $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	print_header();
	print_html($user_data{theme}, $nav{15});

	print <<"HTML";
<form method="post" action="$cfg{pageurl}/login.$cfg{ext}">
<table border="0" cellspacing="1">
<tr>
<td>$msg{6} <input type="text" name="username"><input type="submit" value="$btn{5}">
<input type="hidden" name="op" value="reminder2"></td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, $nav{15}, 1);
}

# ---------------------------------------------------------------------
# Reset user password.
# ---------------------------------------------------------------------
sub reminder2 
{
	if ($username eq '') { user_error($err{3}, $user_data{theme}); }

	sysopen(FH, "$cfg{memberdir}/$username.dat", O_RDONLY) or user_error($err{10}, $user_data{theme});
	chomp(my @user_profile = <FH>);
	close(FH);

	# Generate a password.
	my $password;
	rand(time ^ $$);
	my @seed = ('a'..'k', 'm'..'n', 'p'..'z', '2'..'9');

	for (my $i = 0; $i < 8; $i++) { $password .= $seed[int(rand($#seed + 1))]; }

	my $enc_password = crypt($password, substr($username, 0, 2));

	# Data integrity check.
	if ($username =~ /^([\w.]+)$/) { $username = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Update user database.
	sysopen(FH, "$cfg{memberdir}/$username.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{memberdir}/$username.dat. ($!)", $user_data{theme});  
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$enc_password\n";
	for (my $i = 1; $i < @user_profile; $i++) { print FH "$user_profile[$i]\n"; }

	close(FH);

	# Generate info email.
	my $subject = $cfg{pagename} . " - " . $msg{10} . $user_profile[1];
	my $message = <<"EOT";
$inf{5} $ENV{REMOTE_ADDR} $inf{6} $username $inf{7}

$msg{6} $username
$msg{9} $password

$msg{11} $user_profile[7]

$inf{8}
EOT

	# Send the email to recipient.
	send_email($cfg{webmaster_email}, $user_profile[2], $subject, $message);

	# Print info page.
	print_header();
	print_html($user_data{theme}, $nav{15});

	print $inf{3} . "<b>$user_profile[2]</b>";

	print_html($user_data{theme}, $nav{15}, 1);
}
