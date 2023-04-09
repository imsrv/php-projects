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
# $Id: register.cgi,v 1.9 2003/01/18 13:18:52 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Assign global variables.
use vars qw(
	$query 
	$op $username $email
	%user_data 
	%user_action
);

# Create a new CGI object.
$query = new CGI;

# Get the input.
$op = $query->param('op') || '';
$username = $query->param('username');
$email = $query->param('email');

# Get user profile.
%user_data = authenticate();

# Define possible user actions.
%user_action = (
	register2 => \&register2
);

# Depending on user action, decide what to do.
if ($user_action{$op}) { $user_action{$op}->(); }
else { register(); }

# ---------------------------------------------------------------------
# Display formular o register users.
# ---------------------------------------------------------------------
sub register
{
	# Check if user is already logged in.
	if ($user_data{uid} ne $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	print_header();
	print_html($user_data{theme}, $nav{11});

	print <<"HTML";
<form method="post" action="$cfg{pageurl}/register.$cfg{ext}">
<table border="0" cellspacing="1">
<tr>
<td><b>$msg{6}</b></td>
<td><input type="text" name="username" size="30" maxlength="10"></td>
</tr>
<tr>
<td><b>$msg{7}</b></td>
<td><input type="text" name="email" size="30" maxlength="100"></td>
</tr>
<tr>
<td colspan="2"><input type="hidden" name="op" value="register2"><input type="submit" value="$btn{4}">
</td>
</tr>
</table>
</form>
HTML

	print_html($user_data{theme}, $nav{11}, 1);
}

# ---------------------------------------------------------------------
# Register a new user.
# ---------------------------------------------------------------------
sub register2
{
	# Check if user is already logged in.
	if ($user_data{uid} ne $usr{anonuser}) { user_error($err{6}, $user_data{theme}); }

	user_error($err{3}, $user_data{theme}) if (!$username);
	user_error($err{4}, $user_data{theme}) if ($username !~ /^[0-9A-Za-z#%+,-\.:=?@^_]+$/ || length($username) < 4 || length($username) > 10 || $username eq "|" || $username =~ " " || $username eq $usr{admin}  || $username eq $usr{mod} || $username eq $usr{user} || $username eq $usr{anonuser});
	user_error($err{5}, $user_data{theme}) if (!$email);
	user_error($err{6}, $user_data{theme}) if ($email !~ /^[0-9A-Za-z@\._\-]+$/ || $email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(\.$)/) || ($email !~ /\A.+@\[?(\w|[-.])+\.[a-zA-Z]{2,4}|[0-9]{1,4}\]?\Z/);
	user_error($err{7}, $user_data{theme}) if (-e ("$cfg{memberdir}/$username.dat"));

	# Get censored words.
	my @censored;
	if (-e("$cfg{datadir}/censor.txt"))
	{
		sysopen(FH, "$cfg{datadir}/censor.txt", O_RDONLY);
		chomp(@censored = <FH>);
		close(FH);
	}

	# Check for bad words.
	foreach my $word (@censored) 
	{
		my ($bad_word, $censored) = split(/\=/, $word);
		user_error($err{4}, $user_data{theme}) if ($username eq $bad_word);
	}

	# Generate a password.
	my $password;
	rand(time ^ $$);
	my @seed = ('a'..'k', 'm'..'n', 'p'..'z', '2'..'9');

	for (my $i = 0; $i < 8; $i++) { $password .= $seed[int(rand($#seed + 1))]; }

	my $enc_password = crypt($password, substr($username, 0, 2));

	# Get date.
	my $date = get_date();

	# Data integrity check.
	if ($username =~ /^([\w.]+)$/) { $username = $1; } 
	else { user_error($err{6}, $user_data{theme}); }

	# Add user to database.
	sysopen(FH, "$cfg{memberdir}/$username.dat", O_WRONLY | O_TRUNC | O_CREAT) or user_error("$err{16} $cfg{memberdir}/$username.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	print FH "$enc_password\n";
	print FH "$username\n";
	print FH "$email\n";
	print FH "\n";
	print FH "\n";
	print FH "$msg{26}\n";
	print FH "0\n";
	print FH "\n";
	print FH "\n";
	print FH "\n";
	print FH "$date\n";
	print FH "0\n";
	print FH "0\n";
	print FH "standard\n";

	close(FH);

	# Get current memberlist.
	sysopen(FH, "$cfg{memberdir}/memberlist.dat", O_RDONLY) or user_error("$err{1} $cfg{memberdir}/memberlist.dat. ($!)", $user_data{theme});
	my @members = <FH>;
	close(FH);

	# Update memberlist.
	sysopen(FH, "$cfg{memberdir}/memberlist.dat", O_WRONLY | O_TRUNC) or user_error("$err{16} $cfg{memberdir}/memberlist.dat. ($!)", $user_data{theme});
	flock(FH, LOCK_EX) if $cfg{use_flock};

	foreach my $i (@members) { print FH $i; }
	print FH "$username\n";

	close(FH);

	# Generate info email.
	my $subject = $msg{8} . " " . $cfg{pagename};
	my $message = <<"EOT";
$inf{2}
$msg{6} $username
$msg{9} $password
EOT

	# Send the email to recipient.
	send_email($cfg{webmaster_email}, $email, $subject, $message);

	$subject = $msg{8} . " " . $username;
	$message = $msg{8} . $username . "($cfg{pageurl}/user.$cfg{ext}?op=view_profile;username=$username)";

	# Send info mail to site admin.
	send_email($email, $cfg{webmaster_email}, $subject, $message);
	
	# Print info page.
	print_header();
	print_html($user_data{theme}, $nav{11});

	print <<"HTML";
<table align="center" border="0" cellspacing="1">
<tr>
<td>
$inf{3} <b>$email</b><br>
$inf{4}
</td>
</tr>
</table>
HTML

	print_html($user_data{theme}, $nav{11}, 1);
}
