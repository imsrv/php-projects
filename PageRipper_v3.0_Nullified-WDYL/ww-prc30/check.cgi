#!/usr/local/bin/perl

##############################################################
#  Installation
##############################################################
#  1. Upload to server in ASCII (text)
#  2. CHMOD script 0755 (rwxr_xr_x)

##############################################################
#  Do NOT change or alter the code below!
##############################################################

$curr_dir = `pwd`;

print "Content-type: text/html\n\n";
print <<HTML;
<html>
<head>
<title>Server Check</title>
</head>

<body bgcolor="#FFFFFF" text="#000080" link="#FFFFFF" vlink="#0000FF" alink="#0000FF">

<center>
<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="600" border="0">
	<tr>
		<th>
		<table bgcolor="#000000" cellpadding="4" cellspacing="1" width="600" border="0">
			<tr>
				<th bgcolor="#000080"><font color="#FFFFFF">
				<a href="http://www.monster-submit.com/servercheck/">
				Server Check</a></th>
			</tr>
			<tr>
				<th bgcolor="#FFFFFF">
				<form>
				<textarea rows="10" cols="80">Current Directory: $curr_dir
HTML

print "Perl Version: $]\n";
print "Perl Path(s):\n";
print "================================\n";
@perlprog = `whereis perl`;
foreach $perl_prog (@perlprog) {
	$perl_prog =~ s/\s+\S+\.\S+//gi;
	$perl_prog =~ s/\s+$//g;
	$perl_prog =~ s/l\s+/l <b>or<\/b> /gi;
	print "$perl_prog\n";
}

print "\nMail Program [SendMail] Path(s):\n";
print "================================\n";
@mailprog = `whereis sendmail`;
foreach $mail_prog (@mailprog) {
	$mail_prog =~ s/\s+\S+\.\S+//gi;
	$mail_prog =~ s/\s+$//g;
	$mail_prog =~ s/l\s+/l <b>or<\/b> /gi;
	print "$mail_prog\n";
}

print "\n";
foreach $item (keys %ENV) { print "$item = $ENV{$item}\n";}

print "\nInstalled Modules:\n";
print "================================\n";

use File::Find;
my (@mod, %done, $dir);

find (\&get_module, grep { -r and -d } @INC);
@mod = grep (!$done{$_}++, @mod);
foreach $dir (sort { length $b <=> length $a } @INC) {
	foreach (@mod) { next if s,^\Q$dir,,; }
	}
foreach (@mod) { s,^/(.*)\.pm$,$1,; s,/,::,g; print "$_\n"; }
print "\nNumber Modules Installed: $#mod";

print <<HTML;
</textarea>
				</form>
				</th>
			</tr>
			<tr>
				<th bgcolor="#000080"><font color="#FFFFFF">
				&copy; Copyright 1999-2000 Virtual Solutions.
				All Rights Reserved.</font></th>
			</tr>
		</table>
		</th>
	</tr>
</table>
</center>

</body>
</html>
HTML

exit;

########################################################
# Get Module
########################################################
sub get_module {

/^.*\.pm$/ && /$ARGV[0]/i && push @mod, $File::Find::name;
}
exit;
