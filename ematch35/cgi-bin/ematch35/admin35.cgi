#!/usr/bin/perl

#################################################
# e_Match admin35.cgi beta

require 'setup35.cgi';
require 'email-lib.pl';

$admin_pass = 'password';

# number of entries per page.

$length = 10;

&get_form_data;

$index = $FORM{'index'};
$FORM{'message'} =~ tr/\r/\n/;

unless(exists($FORM{'password'})) {
	print "Content-type: text/html\n\n";
	print "<html><head></head><body>\n";
	print "<form action=\"$ENV{'SCRIPT_NAME'}\" method=POST>\n";
	print "<input type=password name=password>\n";
	print "<input type=submit><input type=reset>\n";
	print "</form></body></html>\n";
	exit;
}

&return_page("Incorrect password.", "Please use your browser's [Back] button to return to the form.") if $FORM{'password'} ne $admin_pass;

if(exists($FORM{'email'})) {
	print "Content-type: text/html\n\n";
	print "<html>\n";
	print "<head>\n";
	print "<title>Email</title>\n";
	print "</head>\n";
	print "<body>\n";
	print "<h1 align=center>Email Members</h1><hr>\n";
	print "<FORM ACTION=\"$ENV{'SCRIPT_NAME'}\" METHOD=\"post\">\n";
	print "<INPUT TYPE=\"Hidden\" NAME=\"password\" VALUE=\"$FORM{'password'}\">\n";
	print "<INPUT TYPE=\"Hidden\" NAME=\"mode\" VALUE=\"send\">\n";
	print "Subject:<br><INPUT TYPE=\"Text\" NAME=\"subject\" MAXLENGTH=\"100\" SIZE=\"50\"><p>\n";
	print "Message:<br><TEXTAREA NAME=\"message\" ROWS=\"10\" COLS=\"50\" WRAP=\"physical\"></TEXTAREA><p>\n";
	print "<INPUT TYPE=\"Submit\" NAME=\"submit\" VALUE=\"Submit\"><input type=reset>\n";
	print "</FORM>\n";
	print "</body>\n";
	print "</html>\n";
	
	exit;
}

if($FORM{'mode'} eq 'send') {
	open(USERLOG,"$logpath/$log") || &return_page('System Error', "Can't read $log.(50)\n");
	@lines = <USERLOG>;
	close(USERLOG);
	chomp(@lines);
	
	@list = map { /^.+?\t(\w+@\w+\..+?)\t.+?$/ } @lines;

	&email_list(@list);
	
	&return_page("E-mail Sent", "Close this window to return to admin.");

}

$FORM{'sort'} = 'nick' unless exists($FORM{'sort'});

open(USERLOG,"$logpath/$log") || &return_page('System Error', "Can't read $log.(5)\n");
@lines = <USERLOG>;
close(USERLOG);
chomp(@lines);

%USERS = ();

foreach $line (@lines) {
	($user_name, $user_pass, $user_email, $user_time, $user_status) = split(/\t/, $line);
	$USERS{$user_name} = [$user_pass, $user_email, $user_time, $user_status] if $user_status ne 'banned' and $user_status ne 'delete';
}

if(exists($USERS{$FORM{'nickname'}})) {
	$USERS{$FORM{'nickname'}}[3] = 'banned' if $FORM{'action'} eq 'ban';
	$USERS{$FORM{'nickname'}}[3] = 'delete' if $FORM{'action'} eq 'delete';
}

if(exists($FORM{'action'})) {
	open(USERLOG,">$logpath/$log") || &return_page('System Error', "Can't write to $log.(42)\n");
	flock USERLOG, 2 if $lockon eq 'yes';
	seek (USERLOG, 0, 0);

	foreach $key (sort keys %USERS) {
		print USERLOG "$key\t$USERS{$key}[0]\t$USERS{$key}[1]\t$USERS{$key}[2]\t$USERS{$key}[3]\n";
	}

	close(USERLOG);
}

$q_string = "password=$admin_pass";

print "Content-type: text/html\n\n";
print "<html><head></head><body>\n";
print "<h1 align=center>e_Match Administration</h1><hr>\n";
unless($index) {
	print "<CENTER><FORM ACTION=\"$ENV{'SCRIPT_NAME'}\" METHOD=\"post\" TARGET=\"_blank\">\n";
	print "<INPUT TYPE=\"Submit\" NAME=\"email\" VALUE=\"Send Mail to All\"><hr>\n";
	print "<INPUT TYPE=\"Hidden\" NAME=\"password\" VALUE=\"$FORM{'password'}\">\n";
	print "</FORM></CENTER>\n";
}
print "<b><big><center>User Data</center></big></b>\n";

$pindex = $index - $length;

print "<a href=\"$ENV{'SCRIPT_NAME'}?$q_string\&sort=$FORM{'sort'}\&index=$pindex\">...Previous</a><p>\n" if $index;
print "<table border align=center><tr>\n";
print "<th><A HREF=\"$ENV{'SCRIPT_NAME'}?$q_string&sort=nick\">Nickname</A></td>\n";
print "<th><A HREF=\"$ENV{'SCRIPT_NAME'}?$q_string&sort=pass\">Password</A></th>\n";
print "<th><A HREF=\"$ENV{'SCRIPT_NAME'}?$q_string&sort=email\">Email</A></th>\n";
print "<th><A HREF=\"$ENV{'SCRIPT_NAME'}?$q_string&sort=login\">Last Login</A></th>\n";
print "<th><A HREF=\"$ENV{'SCRIPT_NAME'}?$q_string&sort=expiry\">Expires</A></th></tr>\n";

@keys = sort { lc($a) cmp lc($b) } keys %USERS if $FORM{'sort'} eq 'nick';
@keys = sort { lc($USERS{$a}[0]) cmp lc($USERS{$b}[0]) } keys %USERS if $FORM{'sort'} eq 'pass';
@keys = sort { lc($USERS{$a}[1]) cmp lc($USERS{$b}[1]) } keys %USERS if $FORM{'sort'} eq 'email';
@keys = sort { $USERS{$a}[2] <=> $USERS{$b}[2] } keys %USERS if $FORM{'sort'} eq 'login';
@keys = sort { $USERS{$a}[3] <=> $USERS{$b}[3] } keys %USERS if $FORM{'sort'} eq 'expiry';

$q_string .= "\&sort=$FORM{'sort'}";

$next_index = $index + $length-1;
$next_index = $#keys if $next_index > $#keys;

($script_name = $ENV{'SCRIPT_NAME'}) =~ s/admin/index/i;

for ($i=$index;$i<=$next_index;$i++) {
	print "<tr>\n";
	print "<td><A HREF=\"${script_name}?nickname=$keys[$i]&password=$USERS{$keys[$i]}[0]&mode=logon\" target=\"_blank\">$keys[$i]</A></td>";
	print "<td>$USERS{$keys[$i]}[0]</td>";
	print "<td><A HREF=\"mailto:$USERS{$keys[$i]}[1]\">$USERS{$keys[$i]}[1]</A></td>";
	$time = localtime($USERS{$keys[$i]}[2]);
	print "<td>$time</td>";
	$USERS{$keys[$i]}[3] =~ s/1//;
	$USERS{$keys[$i]}[3] .= " pending" if $USERS{$keys[$i]}[3] eq 'delete';
	print "<td>$USERS{$keys[$i]}[3]</td>\n";

	print "<td><a href=\"$ENV{'SCRIPT_NAME'}?$q_string&nickname=$keys[$i]&action=delete\">[Delete]</a></td>\n";
	print "<td><a href=\"$ENV{'SCRIPT_NAME'}?$q_string&nickname=$keys[$i]&action=ban\">[Ban]</a></td>\n";
	print "</tr>\n";
}

print "</table>\n";

$index += $length;

print "<p align=right><a href=\"$ENV{'SCRIPT_NAME'}?$q_string\&index=$index\">Next...</a>\n" if $index <= $#keys;

print "</body></html>\n";

exit;

#################################################
# Read Form

sub get_form_data {
	read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'});
	if ($ENV{'QUERY_STRING'}) {
		$buffer = "$buffer\&$ENV{'QUERY_STRING'}"
	}
	$buffer =~ tr/+/ /;
	$buffer =~ s/%0a//gi;
	$buffer =~ s/([;<>\*\|\`'\$#\[\]\{\}"])/\\$1/g; # extra security
	@pairs = split(/&/,$buffer);
	foreach $pair (@pairs) {
		($name,$value) = split(/=/,$pair);
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C",hex($1))/eg;
		if(exists($FORM{$name})) {
			$FORM{$name} .= "\t$value";
		}else {
			$FORM{$name} = $value;
		}
	}
}

#################################################
# Return HTML

sub return_page {
	my($heading, $message) = @_;
	&print_header($heading);
	print $message;
	&print_footer;
	exit;
}

sub print_header {
	local($title) = @_;
	print "Content-type: text/html\n\n";
	print "<HTML><HEAD>\n";
	print "<TITLE>$title</TITLE>\n";
	print "</HEAD><BODY>\n";
	print "<H1>$title</H1><hr>\n";
}

sub print_footer {
	print "</BODY></HTML>\n";
}

sub email_list {
	@list = @_;
	if($nt eq 'no') {
		$pid = fork();
		&system_error("No Fork/n") unless defined $pid;
		return if($pid);
		close(STDOUT);
	}

	foreach $address (@list){
	
		next if $address !~ /\@/;
		$from = $admin;
		$to = $address;
		$smtp = '';
		$subject = $FORM{'subject'};
		$message = $FORM{'message'};		
		&email($from, $to, $smtp, $subject, $message);	
	}
	
	if($nt eq 'no') {exit};
}

