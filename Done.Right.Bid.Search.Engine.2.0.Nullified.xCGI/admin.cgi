#!c:/Perl/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = "/apache/htdocs/BidSearchEngine/"; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Admin Script
# Version 2.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2002 Done-Right. All rights reserved.
###############################################


###############################################
use vars qw(%config %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value %semod);
use CGI::Carp qw(fatalsToBrowser);
undef %config;
local %config = ();
if (-e "${path}config/config.cgi") {
	do "${path}config/config.cgi";
}

if ($config{'modperl'} == 1) {
	eval("use Apache"); if ($@) { die "The Apache module used for mod_perl appears to not be installed"; }
}

my $file_ext;
if (-e "${path}config/config.cgi") {
	$file_ext = "$config{'extension'}";
	if ($file_ext eq "") { $file_ext = "cgi"; }
	if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
	else { do "${path}functions_text.$file_ext"; }
} else { $file_ext = "cgi"; }
if ($file_ext eq "") { $file_ext = "cgi"; }
do "${path}functions.$file_ext";
&main_functions::checkpath('admin', $path);
###############################################


###############################################
#Read Input
local (%FORM, $inbuffer, $qsbuffer, $buffer, @pairs, $pair, $name, $value);
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		$value =~ s/<([^>]|\n)*>//g;
		if ($config{'data'} eq "mysql") { $value = &database_functions::escape($value); }
		$FORM{$name} = $value;
	}
}

if ($FORM{'tab'} eq "login") { &login(); }
elsif ($FORM{'tab'} eq "config") { &config(); }
elsif ($FORM{'tab'} eq "setconfig") { &setconfig(); }
elsif ($FORM{'tab'} eq "reviewer") { &reviewer(); }
elsif ($FORM{'tab'} eq "addreviewer") { &addreviewer(); }
elsif ($FORM{'tab'} eq "reviewer_login") { &reviewer_login(); }
elsif ($FORM{'tab'} eq "convert") { &convert(); }
elsif ($FORM{'tab'} eq "merchant") { &merchant(); }
elsif ($FORM{'tab'} eq "merchant2") { &merchant2(); }
elsif ($FORM{'tab'} eq "selectmerchant") { &selectmerchant(); }
elsif ($FORM{'tab'} eq "setmerchant") { &setmerchant(); }
elsif ($FORM{'tab'} eq "setmerchant2") { &setmerchant2(); }
elsif ($FORM{'tab'} eq "listings") { &listings(); }
elsif ($FORM{'tab'} eq "pending") { &pending(); }
elsif ($FORM{'tab'} eq "approve") { &approve(); }
elsif ($FORM{'tab'} eq "update") { &update(); }
elsif ($FORM{'tab'} eq "startupdate") { &startupdate(); }
else { &main(); }
###############################################


###############################################
#Main
sub main {
if (-e "${path}config/config.cgi") {
	print "Content-type: text/html\n\n";
	my $nolink=1;
	&main_functions::header($nolink, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B>Please enter your Password:</B><P>
<form METHOD="POST" ACTION="admin.$file_ext?tab=login">
Password:&nbsp;<input type=text name=user size=45><BR>
<input type=hidden name=formlog value="Login">
<input type=submit value="Login">
</form>
</font>
EOF
	&main_functions::footer;
	&main_functions::exit;
} else {
	my $created=1;
	&config($created);
}
}
###############################################


###############################################
sub reviewer_login {
print "Content-type: text/html\n\n";
my $nolink=1;
&main_functions::header($nolink, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Reviewer Login</U></B><P>
<form METHOD="POST" ACTION="admin.$file_ext?tab=pending&reviewer=1">
Username:&nbsp;<input type=text name=username size=30><BR>
Password:&nbsp;<input type=password name=password size=30><BR>
<input type=hidden name=formlog value="Login">
<input type=submit value="Login">
</form>
</font>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Login Area
sub login {
$FORM{'user'} = &main_functions::checklogin($FORM{user}, $FORM{formlog});
print "Content-type: text/html\n\n";
my $nolink=1;
my $url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
&main_functions::header($nolink, $FORM{user});
my (@processing, @active, @inactive, @addition, @balanceaddon);
my ($processing, $active, $inactive, $addition, $balanceaddon) = &database_functions::count_members(\@processing, \@active, \@inactive, \@addition, \@balanceaddon);
unless ($active) { $active = "0"; }
unless ($inactive) { $inactive = "0"; }
my $newtime = time();
open (FILE, "${path}config/records.txt");
my $records = <FILE>;
close (FILE);
my @oldtime = split(/\|/, $records);
chomp($oldtime[0]);
my $days = ($newtime-$oldtime[0])/86400;
$days = sprintf("%.0f", $days);

my $regcode = $config{'regcode'};
my $encryptkey = "drbidsearch";
$regcode = &main_functions::Encrypt($regcode,$encryptkey,'asdfhzxcvnmpoiyk');

print <<EOF;
<font face="verdana" size="-1"><B><U>MAIN</U></B></font><P>
<font face="verdana" size="-1">Welcome to your personal admin section for your script.  The admin section lets you easily take control over your script.  Please choose from a link below to begin:<P>
<center>
<font face="verdana" size="-1"><B><font color="#000099">$active</font> active members, &nbsp;<font face="verdana" size="-1" color="#000099">$inactive</font> inactive members&nbsp;&nbsp;</B></font>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><font face="verdana" size="-1"><B>Daily Tasks</B></td>
</tr>
<tr>
<td><font face="verdana" size="-1">1. &nbsp;
EOF
if ($processing > 0) { print "<a href=\"admin.$file_ext?tab=pending&user=$FORM{'user'}&file=bidsearchengine\">Approve <B>$processing</B> New Members</a>"; }
else { print "You have no new members to approve"; }
print <<EOF;
</td></tr>
<tr>
<td><font face="verdana" size="-1">2. &nbsp;
EOF
if ($balanceaddon > 0) { print "<a href=\"admin.$file_ext?tab=pending&user=$FORM{'user'}&file=bidsearchengine\">Process <B>$balanceaddon</B> Balance Updates</a>"; }
else { print "You have no new balance updates to process"; }
print <<EOF;
</td></tr>
<tr>
<td><font face="verdana" size="-1">3. &nbsp;
EOF
if ($addition> 0) { print "<a href=\"admin.$file_ext?tab=pending&user=$FORM{'user'}&file=bidsearchengine\">Approve <B>$addition</B> Accounts Requesting Listing Additions</a>"; }
else { print "You have no new accounts requesting listing additions"; }
print <<EOF;
</td></tr>
<tr>
<td><font face="verdana" size="-1">4. &nbsp;
EOF
if ($days > 30) { print "<a href=\"settings.$file_ext?tab=cache&user=$FORM{'user'}&file=bidsearchengine\">Clear Expired Cache (cleared <B>$days</B> days ago)</a>"; }
else { print "Expired cache was last cleared $days day(s) ago"; }
print <<EOF;
</td></tr>
</table>
</td></tr></table>
</td></tr></table>
<P><BR>
<center><font face="verdana" size="-1"><B>Member Links:</B> <a href="$config{'secureurl'}signup.$file_ext" target="new">Signup</a>, 
<a href="search.$file_ext" target="new">Search</a>, <a href="$config{'secureurl'}members.$file_ext" target="new">Member Admin</a>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Script Operation Links</B></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.$file_ext?tab=config&user=$FORM{'user'}&file=bidsearchengine">Configure Variables</a></td>
<td width="65%"><font face="verdana" size="-1">Set script variables, select 3rd party merchant and add listing reviewers.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.$file_ext?tab=pending&user=$FORM{'user'}&file=bidsearchengine">Pending Members</a></td>
<td width="65%"><font face="verdana" size="-1">Approve/deny members awaiting to be processed.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=customize&user=$FORM{'user'}&file=bidsearchengine">Customize Templates</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the look of your search enigne by editting the html code & customizing email messages.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.$file_ext?tab=email&user=$FORM{'user'}&file=bidsearchengine">Email Members</a></td>
<td width="65%"><font face="verdana" size="-1">Email all, processing, active or inactive members all at once.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.$file_ext?user=$FORM{'user'}&file=bidsearchengine">View Members</a></td>
<td width="65%"><font face="verdana" size="-1">View details about your processing, active and inactive members.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="settings.$file_ext?tab=settings&user=$FORM{'user'}&file=bidsearchengine">Settings</a></td>
<td width="65%"><font face="verdana" size="-1">Set default settings and other configurations.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="addons.$file_ext?tab=tracker&user=$FORM{'user'}&file=bidsearchengine">Statistics</a></td>
<td width="65%"><font face="verdana" size="-1">View various statistics about your search engine.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="addons.$file_ext?tab=bantarget&user=$FORM{'user'}&file=bidsearchengine">Targeted Banner Results</a></td>
<td width="65%"><font face="verdana" size="-1">Display specific banners when certain keywords are used.</font></td>
</tr>
<tr>
<td colspan=2><BR><font face="verdana" size="-1"><B>Script Maintenance Links.N.A</B></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="">Update Engines.N.A</a></td>
<td width="65%"><font face="verdana" size="-1">Sorry...Not Available in this Version...</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="">Download.N.A</a></td>
<td width="65%"><font face="verdana" size="-1">Sorry...Not Available in this Version...</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="">Support.N.A</a></td>
<td width="65%"><font face="verdana" size="-1">Sorry...Not Available in this Version...</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="">Feedback.N.A</a></td>
<td width="65%"><font face="verdana" size="-1">Sorry...Not Available in this Version...</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="">Order Addons.N.A</a></td>
<td width="65%"><font face="verdana" size="-1">Sorry...Not Available in this Version...</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Variable Configuration
sub config {
my ($created, $error) = @_;
unless ($created == 1) { $FORM{'user'} = &main_functions::checklogin($FORM{user}); }

print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my $unix = "CHECKED";
my @sendmail = ('/bin/sendmail', '/usr/sbin/sendmail', '/usr/lib/sendmail');
my ($sendfound, $sendtemp);
for my $sendmail(@sendmail) {
	$sendtemp = $sendmail;
	if (-e $sendmail) {
		$sendfound = 1;
		last;
	}
}
unless ($sendfound) { $sendtemp = "/bin/sendmail"; }
my $smtptemp = "$ENV{'HTTP_HOST'}";
$smtptemp =~ s/www\.//;

my ($user, $company, $websiteurl, $adminurl, $secureurl, $adminemail, $mailer, $pass, $lwpmod, $sockets);
my ($nt, $mysql, $text, $mydatabase, $myhost, $myusername, $mypassword, $disabled, $dotcgi, $dotpl, $modperl, $mpdisabled);
unless ($created == 1) {
	do "${path}config/config.cgi";
	$user=$config{'regcode'};
	$pass=$config{'user'};
	$company=$config{'company'};
	$websiteurl=$config{'websiteurl'};
	$adminurl=$config{'adminurl'};
	$secureurl=$config{'secureurl'};
	$adminemail=$config{'adminemail'};
	$mailer=$config{'sendmail'};
	if ($config{'server'} eq "nt") { $nt = "CHECKED"; }
	else { $unix = "CHECKED"; }
	if ($config{'data'} eq "mysql") { $mysql = "CHECKED"; }
	else { $text = "CHECKED"; }
	if ($config{'data'} eq "mysql") {
		$mydatabase=$config{'database'};
		$myhost=$config{'host'};
		$myusername=$config{'username'};
		$mypassword=$config{'password'};
		$disabled = "ENABLED";
	} else {
		$disabled = "DISABLED";
	}
	if ($config{'extension'} eq "cgi") { $dotcgi = "SELECTED"; }
	else { $dotpl = "SELECTED"; }
	if ($config{'searchmodule'} eq "Sockets") { $sockets = "SELECTED"; }
	else { $lwpmod = "SELECTED"; }
	if ($config{'modperl'} == 1) { $modperl = "CHECKED"; }
	else { $mpdisabled = "DISABLED"; }
} elsif ($FORM{'regcode'} || $FORM{'user2'}) {
	$user = $FORM{'regcode'};
	$pass = $FORM{'user2'};
	$company = $FORM{'company'};
	$websiteurl = $FORM{'websiteurl'};
	$adminurl = $FORM{'adminurl'};
	$adminemail = $FORM{'adminemail'};
	$mailer=$FORM{'mailer'};
	$secureurl = $FORM{'secureurl'};
	if ($FORM{'server'} eq "nt") { $nt = "CHECKED"; }
	else { $unix = "CHECKED"; }
	if ($FORM{'data'} eq "mysql") { $mysql = "CHECKED"; }
	else { $text = "CHECKED"; }
	if ($FORM{'data'} eq "mysql") {
		$mydatabase=$FORM{'mydatabase'};
		$myhost=$FORM{'myhost'};
		$myusername=$FORM{'myusername'};
		$mypassword=$FORM{'mypassword'};
		$disabled = "ENABLED";
	} else {
		$disabled = "DISABLED";
	}
	if ($FORM{'extension'} eq "cgi") { $dotcgi = "SELECTED"; }
	else { $dotpl = "SELECTED"; }
	if ($FORM{'searchmodule'} eq "Sockets") { $sockets = "SELECTED"; }
	else { $lwpmod = "SELECTED"; }
	if ($FORM{'modperl'} == 1) { $modperl = "CHECKED"; }
} else {
	$websiteurl = "http://$ENV{'HTTP_HOST'}/";
	$adminurl = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
	$adminurl =~ s/admin\.${file_ext}$//;
	$secureurl = "https://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
	$secureurl =~ s/admin\.${file_ext}$//;
	$mydatabase = "bidsearchengine";
	$myhost = "localhost";
	$text = "CHECKED";
	$mailer = $sendtemp;
	$disabled = "DISABLED";
	$dotcgi = "SELECTED";
	$lwpmod = "SELECTED";
}

if ($FORM{'data'} eq "mysql") {
	$disabled = "ENABLED";
}

print <<EOF;
<script language="JavaScript">
function fillunix(form) {
	form.mailer.value = "$sendtemp";
}
function fillnt(form) {
	form.mailer.value = "$smtptemp";
}
function enablemysql(form) {
	form.mydatabase.disabled = false;
	form.myhost.disabled = false;
	form.myusername.disabled = false;
	form.mypassword.disabled = false;
}
function disablemysql(form) {
	form.mydatabase.disabled = true;
	form.myhost.disabled = true;
	form.myusername.disabled = true;
	form.mypassword.disabled = true;
}

function openindex() { 
	OpenWindow=window.open("", "newwin", "height=500, width=600,toolbar=no,scrollbars=yes,menubar=no");
	OpenWindow.document.write("<TITLE>Mod_Perl Use</TITLE>")
	OpenWindow.document.write("<B><font face=verdana size=+1>Running the script under mod_perl</font></B><BR><BR>")
	OpenWindow.document.write("<font face=verdana size=-1>If you want to run the script under mod_perl, first make sure that your server supports mod_perl and then follow these steps.<BR><BR>")
	OpenWindow.document.write("<UL><LI>Make sure you have a line similar to the following in your httpd.conf file:<BR><BR>")
	OpenWindow.document.write("PerlModule Apache::StatINC<BR>PerlInitHandler Apache::StatINC<BR>&lt;IfModule mod_perl.c&gt;<BR>")
	OpenWindow.document.write(" &nbsp;Alias /perl/ /home/httpd/perl/<BR> &nbsp;&lt;Location /perl&gt;<BR> &nbsp;&nbsp;&nbsp;SetHandler perl-script<BR>")
	OpenWindow.document.write(" &nbsp;&nbsp;&nbsp;PerlHandler Apache::Registry<BR> &nbsp;&nbsp;&nbsp;    PerlSendHeader On<BR>")
	OpenWindow.document.write(" &nbsp;&nbsp;&nbsp;Options +ExecCGI<BR> &nbsp;&nbsp;&nbsp;PerlInitHandler Apache::StatINC<BR>")
	OpenWindow.document.write(" &nbsp;&nbsp;&nbsp;PerlSetVar StatINCDebug On<BR> &lt;/Location&gt;<BR>&lt;/IfModule&gt;<BR><BR>")
	OpenWindow.document.write("Notice the line that reads 'Alias /perl/ /home/httpd/perl/'.  This means that you must install the script in the 'perl' directory for it to run under mod_perl</LI><BR><BR>")
	OpenWindow.document.write("<LI>Open each .cgi file and fill in the $path variable with the absolute data path to this directory.</LI><BR><BR>")
	OpenWindow.document.write("<LI>Open search.cgi, uncomment the #use lib line and fill in the use lib path.  This is the same path used for the \$path variable except there is no forward slash at the end.</LI><BR><BR>")
	OpenWindow.document.write("<LI>Enable mod_perl from the configure variables section by checking the mod_perl checkbox.</LI><BR><BR></UL>")
	OpenWindow.document.write("If you run into any problems with mod_perl, consult the troubleshooting guide in the support section.")
	OpenWindow.document.write("</BODY></HTML>")
	OpenWindow.document.close()
	self.name="main"
}

</script>
<font face="verdana" size="-1"><B><U>Variable Configuration</U></b><P>
<form METHOD="POST" name="form" ACTION="admin.$file_ext?tab=setconfig&user=$FORM{'user'}">
EOF
if ($created == 1) {
print <<EOF;
<font face="verdana" size="-1">If you are having trouble installing the script, the staff at Done-Right Scripts can do it for you.
<BR><a href="">Sorry...Not Available in this Version...
EOF
	if ($error) {
print <<EOF;
<BR><BR><font face="verdana" size="-1"><B>Error in installation.  Please do the following and re-configure the variables again.<BR>
For more help with this issue, please consult the <a href="" target="new">Sorry...Not Available in this Version...</a>.</B><P>
<font face="verdana" size="-1">$error<BR><BR>
EOF
	}
} else {
print <<EOF;
<BR><font face="verdana" size="-1"><B>Other Configurations:</B> <a href="admin.$file_ext?tab=selectmerchant&user=$FORM{'user'}">3rd Party Merchant (process orders)</a> |
<a href="settings.$file_ext?tab=defaults&user=$FORM{'user'}">Set Defaults</a> | <a href="admin.$file_ext?tab=reviewer&user=$FORM{'user'}">Manage Listing Reviewers</a>
EOF
}
print <<EOF;
<input type=hidden name=created value="$created">

<table width=90% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
   

<tr>
<td width=60%><font face="verdana" size="-1">Registration Code:&nbsp;</td>
<td width=40%><input type=text name=regcode size=45 value="$user"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Admin Password:</font>&nbsp;</td>
<td width=40%><input type=text name=user2 size=30 value="$pass"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Name of Company:&nbsp;</td>
<td width=40%><input type=text name=company size=45 value="$company"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Web Site URL:&nbsp;</td>
<td width=40%><input type=text name=websiteurl size=45 value="$websiteurl"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">URL To BidSearch folder with a '/' at the end:&nbsp;</td>
<td width=40%><input type=text name=adminurl size=45 value="$adminurl"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Secure URL To BidSearch folder with a '/' at the end (optional):&nbsp;<BR><font size="-2">This is used for signup.$file_ext and members.$file_ext</td>
<td width=40%><input type=text name=secureurl size=45 value="$secureurl"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Admin email:&nbsp;</td>
<td width=40%><input type=text name=adminemail size=45 value="$adminemail"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Server Type:&nbsp;</td>
<td width=40%><font face="verdana" size="-1">Unix:<INPUT TYPE="radio" NAME="server" VALUE="unix" $unix OnClick="javascript:fillunix(this.form);">&nbsp;&nbsp;NT:<INPUT TYPE="radio" NAME="server" VALUE="nt" $nt OnClick="javascript:fillnt(this.form);"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Location of severs sendmail (unix) or smtp (nt):&nbsp;<BR><font size="-2">(unix ex. $sendtemp or nt ex. $smtptemp)</font></td>
<td width=40% valign=top><input type=text name=mailer size=45 value="$mailer"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Database Type:&nbsp;</td>
<td width=40%><font face="verdana" size="-1">Text:<INPUT TYPE="radio" NAME="data" VALUE="text" $text OnClick="javascript:disablemysql(this.form);">&nbsp;&nbsp;MySQL:<INPUT TYPE="radio" NAME="data" VALUE="mysql" $mysql OnClick="javascript:enablemysql(this.form);"><BR><font size"-2">(If you select mysql, make sure your server supports it)</font></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Script Extension:&nbsp;<BR><font size="-2">(If your server does not require you to run .pl extensions, leave this as .cgi)</font></td>
<td width=40%><font face="verdana" size="-1"><select name="extension" size="-1"><option $dotcgi>cgi</option><option $dotpl>pl</option></select></td></tr>
<tr>
<td width=60% valign=top><font face="verdana" size="-1">Search Engine Module:&nbsp;<BR><font size="-2">(Used to gather meta results)</font></td>
<td width=40%><font face="verdana" size="-1"><select name="searchmodule" size="-1">
EOF
my ($lwp, $io);
eval("use LWP::UserAgent");
if ($@) { $lwp = "no"; }
eval("use IO::Socket");
if ($@) { $io = "no"; }
if ($lwp eq "no" && $io eq "no") {
print <<EOF;
<option $lwpmod>LWP</option><option $sockets>Sockets</option></select><BR>
It appears that your server is missing both the libwww and IO modules.  You need to have at least one of these modules installed for the script to work.
For information on getting the libwww module installed, visit the <a href="" target="new">support section.Sorry...Not Available in this Version...</a>.
EOF
} elsif ($lwp eq "no") {
print <<EOF;
<option>LWP</option><option SELECTED>Sockets</option></select><BR>
It appears that your server is missing the libwww (LWP) module.  You can choose to use the Sockets module instead, or visit the <a href="" target="new">support section</a> for instructions on installing libwww.Sorry...Not Available in this Version....
EOF
} elsif ($io eq "no") {
	print "<option SELECTED>LWP</option><option>Sockets</option></select><BR>";
} else {
	print "<option $lwpmod>LWP</option><option $sockets>Sockets</option></select><BR>";
}

print <<EOF;
</tr><tr>
<td width=60%><font face="verdana" size="-1">Run script under mod_perl:&nbsp;<BR><font size="-2">(Server must support mod_perl.  <a href="javascript:openindex()">Click here</a> for instructions)</font></td>
<td width=40%><font face="verdana" size="-1"><INPUT TYPE="checkbox" NAME="modperl" VALUE="1" $modperl></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1">&nbsp;</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>MySQL Settings</B> (only fill out the following if you selected mysql above for your database type)</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000099"><B>Before preceding, follow these MySQL setup instructions:</B></font><BR>
<font face="verdana" size="-1">
-Log into telent<BR>
-Navigate to your bidsearch directory through telnet<BR>
-Type in the following command to create the database:<BR>
&nbsp;&nbsp;mysqladmin -u [username] -p[password] create bidsearchengine<BR>
-Type in the following commmand to create the tables for the database:<BR>
&nbsp;&nbsp;mysql -u [username] -p[password] bidsearchengine < mysql.dump<BR>
</td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Name of Database:&nbsp;</td>
<td width=40%><font face="verdana" size="-1"><input type=text name=mydatabase size=30 value="$mydatabase" $disabled></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Host:&nbsp;<BR><font size="-2">(Unless you are planning on running the database from another server, leave this as localhost)</font></td>
<td width=40%><font face="verdana" size="-1"><input type=text name=myhost size=30 value="$myhost" $disabled></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Username:&nbsp;</td>
<td width=40%><font face="verdana" size="-1"><input type=text name=myusername size=30 value="$myusername" $disabled></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Password:&nbsp;</td>
<td width=40%><font face="verdana" size="-1"><input type=text name=mypassword size=30 value="$mypassword" $disabled></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR>
<input type=submit value="Set Configuration">
</form><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write to config.cgi
sub setconfig {
my $error;

sub text_database {
	my ($error) = @_;
	unless (-e "${path}track") { mkdir("${path}track", 0777) || ($error .= "Create Directory: track<BR>"); }
	unless (-e "${path}data") { mkdir("${path}data", 0777) || ($error .= "Create Directory: data<BR>"); }
	unless (-e "${path}data/balance") { mkdir("${path}data/balance", 0777) || ($error .= "Create Directory: data/balance<BR>"); }
	unless (-e "${path}data/search") { mkdir("${path}data/search", 0777) || ($error .= "Create Directory: data/search<BR>"); }
	unless (-e "${path}data/sites") { mkdir("${path}data/sites", 0777) || ($error .= "Create Directory: data/sites<BR>"); }
	unless (-e "${path}data/stats") { mkdir("${path}data/stats", 0777) || ($error .= "Create Directory: data/stats<BR>"); }
	unless (-e "${path}data/users") { mkdir("${path}data/users", 0777) || ($error .= "Create Directory: data/users<BR>"); }

	unless (-e "${path}data/backup") { mkdir("${path}data/backup", 0777) || ($error .= "Create Directory: data/backup<BR>"); }
	unless (-e "${path}data/backup/balance") { mkdir("${path}data/backup/balance", 0777) || ($error .= "Create Directory: data/backup/balance<BR>"); }
	unless (-e "${path}data/backup/sites") { mkdir("${path}data/backup/sites", 0777) || ($error .= "Create Directory: data/backup/sites<BR>"); }
	unless (-e "${path}data/backup/stats") { mkdir("${path}data/backup/stats", 0777) || ($error .= "Create Directory: data/backup/stats<BR>"); }
	unless (-e "${path}data/backup/users") { mkdir("${path}data/backup/users", 0777) || ($error .= "Create Directory: data/backup/users<BR>"); }

	unless ($FORM{'server'} eq "nt") {
		unless (sprintf("%o", (stat "track")[2] & 0777) == "777") { chmod (0777,"track") || ($error .= "Chmod Directory 777: track<BR>"); }
		unless (sprintf("%o", (stat "${path}data")[2] & 0777) == "777") { chmod (0777,"${path}data") || ($error .= "Chmod Directory 777: data<BR>"); }
		unless (sprintf("%o", (stat "${path}data/balance")[2] & 0777) == "777") { chmod (0777,"${path}data/balance") || ($error .= "Chmod Directory 777: data/balance<BR>"); }
		unless (sprintf("%o", (stat "${path}data/search")[2] & 0777) == "777") { chmod (0777,"${path}data/search") || ($error .= "Chmod Directory 777: data/search<BR>"); }
		unless (sprintf("%o", (stat "${path}data/sites")[2] & 0777) == "777") { chmod (0777,"${path}data/sites") || ($error .= "Chmod Directory 777: data/sites<BR>"); }
		unless (sprintf("%o", (stat "${path}data/stats")[2] & 0777) == "777") { chmod (0777,"${path}data/stats") || ($error .= "Chmod Directory 777: data/stats<BR>"); }
		unless (sprintf("%o", (stat "${path}data/users")[2] & 0777) == "777") { chmod (0777,"${path}data/users") || ($error .= "Chmod Directory 777: data/users<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup")[2] & 0777) == "777") { chmod (0777,"${path}data/backup") || ($error .= "Chmod Directory 777: data/backup<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/balance")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/balance") || ($error .= "Chmod Directory 777: data/backup/balance<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/sites")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/sites") || ($error .= "Chmod Directory 777: data/backup/sites<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/stats")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/stats") || ($error .= "Chmod Directory 777: data/backup/stats<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/users")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/users") || ($error .= "Chmod Directory 777: data/backup/users<BR>"); }
	}

	unless (-e "${path}track/cookie.txt") { 
		open (FILE, ">${path}track/cookie.txt");
		close(FILE);
	}
	unless (-e "${path}config/reviewers.txt") { 
		open (FILE, ">${path}config/reviewers.txt");
		close(FILE);
	}
	unless (-e "${path}data/processing.txt") { 
		open (FILE, ">${path}data/processing.txt");
		close(FILE);
	}
	unless (-e "${path}data/active.txt") { 
		open (FILE, ">${path}data/active.txt");
		close(FILE);
	}
	unless (-e "${path}data/inactive.txt") { 
		open (FILE, ">${path}data/inactive.txt");
		close(FILE);
	}
	unless (-e "${path}data/balanceaddon.txt") { 
		open (FILE, ">${path}data/balanceaddon.txt");
		close(FILE);
	}
	unless (-e "${path}data/addition.txt") { 
		open (FILE, ">${path}data/addition.txt");
		close(FILE);
	}
	unless (-e "${path}data/backup/processing.txt") { 
		open (FILE, ">${path}data/backup/processing.txt");
		close(FILE);
	}
	unless (-e "${path}data/backup/active.txt") { 
		open (FILE, ">${path}data/backup/active.txt");
		close(FILE);
	}
	unless (-e "${path}data/backup/inactive.txt") { 
		open (FILE, ">${path}data/backup/inactive.txt");
		close(FILE);
	}
	
	unless ($FORM{'server'} eq "nt") {
		unless (sprintf("%o", (stat "${path}config/reviewers.txt")[2] & 0777) == "777") { chmod (0777,"${path}config/reviewers.txt") || ($error .= "Chmod File 777: config/reviewers.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}track/cookie.txt")[2] & 0777) == "777") { chmod (0777,"${path}track/cookie.txt") || ($error .= "Chmod File 777: track/cookie.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/processing.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/processing.txt") || ($error .= "Chmod File 777: data/processing.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/active.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/active.txt") || ($error .= "Chmod File 777: data/active.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/inactive.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/inactive.txt") || ($error .= "Chmod File 777: data/inactive.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/balanceaddon.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/balanceaddon.txt") || ($error .= "Chmod File 777: data/balanceaddon.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/addition.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/addition.txt") || ($error .= "Chmod File 777: data/addition.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/processing.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/processing.txt") || ($error .= "Chmod File 777: data/backup/processing.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/active.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/active.txt") || ($error .= "Chmod File 777: data/backup/active.txt<BR>"); }
		unless (sprintf("%o", (stat "${path}data/backup/inactive.txt")[2] & 0777) == "777") { chmod (0777,"${path}data/backup/inactive.txt") || ($error .= "Chmod File 777: data/backup/inactive.txt<BR>"); }
	}
	return ($error);
}

if ($FORM{'created'} == 1) {

my $url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
my $search = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
my ($content);
if ($FORM{'searchmodule'} eq "LWP") {
	eval("use LWP::UserAgent"); if ($@) { die "The LWP::UserAgent module used to connect to search engines appears to not be installed"; }
	my $ua = LWP::UserAgent->new();
	my $request = HTTP::Request->new('GET', $search);
	my $response = $ua->request ($request);
	my $response_body = $response->content();	
	$content = $response_body;
} else {
	eval("use IO::Socket"); if ($@) { die "The IO::Socket module used to connect to search engines appears to not be installed"; }
	my @requests;
	push (@requests, $search);
	my %entries = &main_functions::my_forker('30', @requests);
	foreach my $url (keys(%entries)) {
		$content = $entries{"$url"};
	}
}

if ($content =~ /Invalid User/) {
	print "Content-type: text/html\n\n";
	&main_functions::header('1', $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Error</U><BR><BR>
The registration code you supplied ($FORM{'regcode'}), is not registered in our database and therefore the installation will not be completed.
If you feel this is an error, please contact <a href="mailto:admin\@donerightscripts.com">admin\@donerightscripts.com</a>.  In the email, be sure to include your registration code, product purchased and the URL to your admin.cgi file.
EOF
	&main_functions::footer;
	&main_functions::exit;
}

#Create and chmod directories and files
unless (-e "${path}config") { mkdir("${path}config", 0777) || ($error .= "Create Directory: config<BR>"); }
unless (-e "${path}cache") { mkdir("${path}cache", 0777) || ($error .= "Create Directory: cache<BR>"); }
unless (-e "${path}banner") { mkdir("${path}banner", 0777) || ($error .= "Create Directory: banner<BR>"); }

unless ($error) {
unless ($FORM{'server'} eq "nt") {
	unless (sprintf("%o", (stat "${path}config")[2] & 0777) == "777") { chmod (0777,"${path}config") || ($error .= "Chmod Directory 777: config<BR>"); }
	unless (sprintf("%o", (stat "${path}template")[2] & 0777) == "777") { chmod (0777,"${path}template") || ($error .= "Chmod Directory 777: template<BR>"); }
	unless (sprintf("%o", (stat "${path}cache")[2] & 0777) == "777") { chmod (0777,"${path}cache") || ($error .= "Chmod Directory 777: cache<BR>"); }
	unless (sprintf("%o", (stat "${path}banner")[2] & 0777) == "777") { chmod (0777,"${path}banner") || ($error .= "Chmod Directory 777: banner<BR>"); }
}
if ($FORM{'data'} eq "text") { $error .= &text_database($error); }

my $newtime = time();
open (FILE, ">${path}config/records.txt");
print FILE "$newtime|never";
close (FILE);
open (FILE, ">${path}config/config.cgi");
close(FILE);
open (FILE, ">${path}config/session.txt");
close(FILE);
open (FILE, ">${path}config/defaults.txt");
print FILE <<EOF;
CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|||||||
10|2|30|54|5|4|10|0|10|25|3|5||0|0.01|\$||20
CHECKED||CHECKED|CHECKED
|CHECKED||CHECKED
|CHECKED|CHECKED||CHECKED|CHECKED|CHECKED|CHECKED|CHECKED|CHECKED||||CHECKED
EOF
close(FILE);

open (FILE, ">${path}template/categories.txt");
print FILE <<EOF;
Business|Investing|Jobs
Computers|Internet|Software
Entertainment|Movies|Music
Games|Video Games|Roleplaying
News|Newspapers|Weather
Reference|Encyclopedias|Education
Shopping|Automobiles|Clothing
Sports|Football|Hockey
Travel|Food|Recreation
EOF
close (FILE);

unless ($FORM{'server'} eq "nt") {
	unless (sprintf("%o", (stat "${path}signup.cgi")[2] & 0777) == "755") { chmod (0755,"${path}signup.cgi") || ($error .= "Chmod File 755: signup.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}customize.cgi")[2] & 0777) == "755") { chmod (0755,"${path}customize.cgi") || ($error .= "Chmod File 755: customize.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}search.cgi")[2] & 0777) == "755") { chmod (0755,"${path}search.cgi") || ($error .= "Chmod File 755: search.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}view.cgi")[2] & 0777) == "755") { chmod (0755,"${path}view.cgi") || ($error .= "Chmod File 755: view.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}members.cgi")[2] & 0777) == "755") { chmod (0755,"${path}members.cgi") || ($error .= "Chmod File 755: members.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}settings.cgi")[2] & 0777) == "755") { chmod (0755,"${path}settings.cgi") || ($error .= "Chmod File 755: settings.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}addons.cgi")[2] & 0777) == "755") { chmod (0755,"${path}addons.cgi") || ($error .= "Chmod File 755: addons.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}functions.cgi")[2] & 0777) == "755") { chmod (0755,"${path}functions.cgi") || ($error .= "Chmod File 755: functions.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}functions_mysql.cgi")[2] & 0777) == "755") { chmod (0755,"${path}functions_mysql.cgi") || ($error .= "Chmod File 755: functions_mysql.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}functions_text.cgi")[2] & 0777) == "755") { chmod (0755,"${path}functions_text.cgi") || ($error .= "Chmod File 755: functions_text.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}excel.cgi")[2] & 0777) == "755") { chmod (0755,"${path}excel.cgi") || ($error .= "Chmod File 755: excel.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}config/config.cgi")[2] & 0777) == "777") { chmod (0777,"${path}config/config.cgi") || ($error .= "Chmod File 777: config/config.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}config/defaults.txt")[2] & 0777) == "777") { chmod (0777,"${path}config/defaults.txt") || ($error .= "Chmod File 777: config/defaults.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}config/session.txt")[2] & 0777) == "777") { chmod (0777,"${path}config/session.txt") || ($error .= "Chmod File 777: config/session.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}config/records.txt")[2] & 0777) == "777") { chmod (0777,"${path}config/records.txt") || ($error .= "Chmod File 777: config/records.txt<BR>"); }
	
	unless (sprintf("%o", (stat "${path}template/wordfilter.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/wordfilter.txt") || ($error .= "Chmod File 777: template/wordfilter.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/categories.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/categories.txt") || ($error .= "Chmod File 777: template/categories.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/Web.cgi")[2] & 0777) == "777") { chmod (0777,"${path}template/Web.cgi") || ($error .= "Chmod File 777: template/Web.cgi<BR>"); }
	unless (sprintf("%o", (stat "${path}template/searchstart.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/searchstart.txt") || ($error .= "Chmod File 777: template/searchstart.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/searchresults.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/searchresults.txt") || ($error .= "Chmod File 777: template/searchresults.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/add.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/add.txt") || ($error .= "Chmod File 777: template/add.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/balance.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/balance.txt") || ($error .= "Chmod File 777: template/balance.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/bids.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/bids.txt") || ($error .= "Chmod File 777: template/bids.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/bulk.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/bulk.txt") || ($error .= "Chmod File 777: template/bulk.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/checkbid.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/checkbid.txt") || ($error .= "Chmod File 777: template/checkbid.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/delete.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/delete.txt") || ($error .= "Chmod File 777: template/delete.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/edit.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/edit.txt") || ($error .= "Chmod File 777: template/edit.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emailaddonbalance.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emailaddonbalance.txt") || ($error .= "Chmod File 777: template/emailaddonbalance.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emailapprove.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emailapprove.txt") || ($error .= "Chmod File 777: template/emailapprove.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emaildenied.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emaildenied.txt") || ($error .= "Chmod File 777: template/emaildenied.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emailoutbid.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emailoutbid.txt") || ($error .= "Chmod File 777: template/emailoutbid.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emailremove.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emailremove.txt") || ($error .= "Chmod File 777: template/emailremove.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emailsignup.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emailsignup.txt") || ($error .= "Chmod File 777: template/emailsignup.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/emailwarning.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/emailwarning.txt") || ($error .= "Chmod File 777: template/emailwarning.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/forgot.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/forgot.txt") || ($error .= "Chmod File 777: template/forgot.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/login.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/login.txt") || ($error .= "Chmod File 777: template/login.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/manage.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/manage.txt") || ($error .= "Chmod File 777: template/manage.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/members.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/members.txt") || ($error .= "Chmod File 777: template/members.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/message.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/message.txt") || ($error .= "Chmod File 777: template/message.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/nontargeted.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/nontargeted.txt") || ($error .= "Chmod File 777: template/nontargeted.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/profile.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/profile.txt") || ($error .= "Chmod File 777: template/profile.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/signup.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/signup.txt") || ($error .= "Chmod File 777: template/signup.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/signup2.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/signup2.txt") || ($error .= "Chmod File 777: template/signup2.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/signup3.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/signup3.txt") || ($error .= "Chmod File 777: template/signup3.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/signup4.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/signup4.txt") || ($error .= "Chmod File 777: template/signup4.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/statistics.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/statistics.txt") || ($error .= "Chmod File 777: template/statistics.txt<BR>"); }
	unless (sprintf("%o", (stat "${path}template/suggestion.txt")[2] & 0777) == "777") { chmod (0777,"${path}template/suggestion.txt") || ($error .= "Chmod File 777: template/suggestion.txt<BR>"); }
}
}
} else {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	if ($FORM{'data'} eq "text" && $config{'data'} eq "mysql") { $error .= &text_database($error); }
}
my $current_ext;
if ($config{'extension'}) { $current_ext = $config{'extension'}; }
else { $current_ext = "cgi"; }
if ($current_ext ne $FORM{'extension'}) {
	my $current;
	if ($config{'extension'} eq "") { $current = "cgi"; }
	else { $current = $config{'extension'}; }
	rename("${path}addons.$current", "${path}addons.$FORM{'extension'}") || ($error .= "Rename addons.$current to addons.$FORM{'extension'}<BR>");
	rename("${path}admin.$current", "${path}admin.$FORM{'extension'}") || ($error .= "Rename admin.$current to admin.$FORM{'extension'}<BR>");
	rename("${path}customize.$current", "${path}customize.$FORM{'extension'}") || ($error .= "Rename customize.$current to customize.$FORM{'extension'}<BR>");
	rename("${path}excel.$current", "${path}excel.$FORM{'extension'}") || ($error .= "Rename excel.$current to excel.$FORM{'extension'}<BR>");
	rename("${path}functions.$current", "${path}functions.$FORM{'extension'}") || ($error .= "Rename functions.$current to functions.$FORM{'extension'}<BR>");
	rename("${path}functions_mysql.$current", "${path}functions_mysql.$FORM{'extension'}") || ($error .= "Rename functions_mysql.$current to functions_mysql.$FORM{'extension'}<BR>");
	rename("${path}functions_text.$current", "${path}functions_text.$FORM{'extension'}") || ($error .= "Rename functions_text.$current to functions_text.$FORM{'extension'}<BR>");
	rename("${path}members.$current", "${path}members.$FORM{'extension'}") || ($error .= "Rename members.$current to members.$FORM{'extension'}<BR>");
	rename("${path}search.$current", "${path}search.$FORM{'extension'}") || ($error .= "Rename search.$current to search.$FORM{'extension'}<BR>");
	rename("${path}settings.$current", "${path}settings.$FORM{'extension'}") || ($error .= "Rename settings.$current to settings.$FORM{'extension'}<BR>");
	rename("${path}signup.$current", "${path}signup.$FORM{'extension'}") || ($error .= "Rename signup.$current to signup.$FORM{'extension'}<BR>");
	rename("${path}view.$current", "${path}view.$FORM{'extension'}") || ($error .= "Rename view.$current to view.$FORM{'extension'}<BR>");
	$file_ext = $FORM{'extension'};
}
my $ademail = $FORM{'adminemail'};
unless ($ademail =~ /\\@/) {
	$ademail =~ s/@/\\@/;
}

my $moddata;
if ($FORM{'modperl'} == 1) { $moddata = $FORM{'modperldatapath'}; }
my $olddata = $config{'data'};
open(FILE, ">${path}config/config.cgi");
print FILE <<EOF;

\$config{'regcode'} = "$FORM{'regcode'}";
\$config{'user'} = "$FORM{'user2'}";
\$config{'Webversion'} = "4.1";
\$config{'company'} = "$FORM{'company'}";
\$config{'websiteurl'} = "$FORM{'websiteurl'}";
\$config{'adminurl'} = "$FORM{'adminurl'}";
\$config{'secureurl'} = "$FORM{'secureurl'}";
\$config{'adminemail'} = "$ademail";
\$config{'sendmail'} = "$FORM{'mailer'}";
\$config{'server'} = "$FORM{'server'}";
\$config{'data'} = "$FORM{'data'}";
\$config{'extension'} = "$FORM{'extension'}";
\$config{'searchmodule'} = "$FORM{'searchmodule'}";
\$config{'modperl'} = "$FORM{'modperl'}";
EOF
if ($FORM{'data'} eq "mysql") {
print FILE <<EOF;
\$config{'database'} = "$FORM{'mydatabase'}";
\$config{'host'} = "$FORM{'myhost'}";
\$config{'username'} = "$FORM{'myusername'}";
\$config{'password'} = "$FORM{'mypassword'}";
1;
EOF
} else {
print FILE <<EOF;
\$config{'database'} = "$config{'database'}";
\$config{'host'} = "$config{'host'}";
\$config{'username'} = "$config{'username'}";
\$config{'password'} = "$config{'password'}";
1;
EOF
}
close (FILE);

if ($error) {
	&config('1', $error);
	&main_functions::exit;
}

print "Content-type: text/html\n\n";
my $nolink=1;
&main_functions::header($nolink, $FORM{user});
if ($olddata ne $FORM{'data'} && $FORM{'created'} <=> 1) {
print <<EOF;
<font face="verdana" size="-1"><B>DataBase Change</B><P>
You have indicated that you which to switch your database from $olddata to $FORM{'data'}.  Please select one of the two options below:<BR>
<form METHOD="POST" ACTION="admin.$file_ext?tab=convert">
<INPUT TYPE="radio" NAME="convert" VALUE="yes"> Transfer my members from my $olddata database to my $FORM{'data'} database<BR>
<INPUT TYPE="radio" NAME="convert" VALUE="no"> DO NOT Transfer my members from my $olddata database to my $FORM{'data'} database<BR>
<input type=hidden name=user value="$FORM{'user2'}">
<input type=hidden name=formlog value="Login">
<input type=submit value="Submit">
</form>
EOF
} else {
print <<EOF;
<font face="verdana" size="-1"><B>Variables successfully configured.  Please Re-Login:</B><P>
<form METHOD="POST" ACTION="admin.$file_ext?tab=login">
Password:&nbsp;<input type=text name=user size=45 value="$FORM{'user2'}"><BR>
<input type=hidden name=formlog value="Login">
<input type=submit value="Login">
</form>
</font>
EOF
}
&main_functions::footer;
if ($olddata eq "mysql") { &main_functions::exit; }
}
###############################################


###############################################
sub convert {
$FORM{'user'} = &main_functions::checklogin($FORM{user}, $FORM{formlog});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
if ($FORM{'convert'} eq "yes") {
	if ($config{'data'} eq "mysql") { &convert_to_mysql; }
	else { &convert_to_text; }
} else { &no_conversion; }

sub convert_to_mysql {
	&remove_table('users');
	&remove_table('sites');
	&remove_table('stats');
	&remove_table('balanceaddon');
	&remove_table('edit_sites');
	&remove_table('dailystats');
	&remove_table('searchlog');
	&remove_table('reviewers');
	sub remove_table {
		my ($file) = @_;
		my $statement = "delete from $file";
		my $sth = &database_functions::mySQL($statement);
	}

	do "${path}functions_text.$file_ext";
	open (FILE, "${path}track/daily.txt");
	my @daily = <FILE>;
	close (FILE);
	foreach my $line(@daily) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my $statement = "insert into dailystats(date, searches) values ('$inner[0]', '$inner[1]')";
		my $sth = &database_functions::mySQL($statement);
	}
	
	open (FILE, "${path}track/tracker.txt");
	my @tracker = <FILE>;
	close (FILE);
	foreach my $line(@tracker) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my $statement = "insert into searchlog(term, searches) values ('$inner[1]', '$inner[0]')";
		my $sth = &database_functions::mySQL($statement);
	}
	
	open (FILE, "${path}config/reviewers.txt");
	my @reviewers = <FILE>;
	close (FILE);
	foreach my $line(@reviewers) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my $statement = "insert into reviewers(username, password, date, stats) values ('$inner[0]', '$inner[1]', '$inner[2]', '$inner[3]')";
		my $sth = &database_functions::mySQL($statement);
	}
	
	
	&mysqlconvert_status('active', 'approved');
	&mysqlconvert_status('inactive', 'inactive');
	&mysqlconvert_status('processing', 'new');
print <<EOF;
<font face="verdana" size="-1"><B>Database successfully transferred from text to mysql</B><P>
</font>
EOF
}

sub convert_to_text {
	&remove_data('balance', 'processing');
	&remove_data('search', 'active');
	&remove_data('sites', 'inactive');
	&remove_data('stats', 'balanceaddon');
	&remove_data('users', 'addition');
	sub remove_data {
		my ($file, $status) = @_;
		opendir(FILE,"${path}data/$file");
		my @dat = grep { /.txt/ } readdir(FILE);
		closedir (FILE);
		foreach my $line(@dat) {
			unlink("${path}data/$file/$line.txt");	
		}
		open (FILE, ">${path}data/$status.txt");
		close (FILE);
	}
	open (FILE, ">${path}track/daily.txt");
	close (FILE);
	open (FILE, ">${path}track/tracker.txt");
	close (FILE);
	open (FILE, ">${path}config/reviewers.txt");
	close (FILE);

	do "${path}functions_mysql.$file_ext";
	my $statement = "select term, searches from searchlog order by searches desc";
	my $sth = &database_functions::mySQL($statement);
	open (FILE, ">${path}track/tracker.txt");
	while (my ($term, $searches) = $sth->fetchrow_array) {
		print FILE "$searches|$term\n";
	}
	close (FILE);
	
	$statement = "select date, searches from dailystats order by id desc";
	$sth = &database_functions::mySQL($statement);
	open (FILE, ">${path}track/daily.txt");
	while (my ($date, $searches) = $sth->fetchrow_array) {
		print FILE "$date|$searches\n";
	}
	close (FILE);
	
	$statement = "select username, password, date, stats from reviewers";
	$sth = &database_functions::mySQL($statement);
	open (FILE, ">${path}config/reviewers.txt");
	while (my ($username, $password, $date, $stats) = $sth->fetchrow_array) {
		print FILE "$username|$password|$date|$stats\n";
	}
	close (FILE);
	
	$statement = "select username from users";
	$sth = &database_functions::mySQL($statement);
	my (@processing) = ();
	while (my $data = $sth->fetchrow_array)	{
		push(@processing, $data);
	}
	foreach my $line(@processing) {
		chomp($line);
		my @info = &database_functions::GetUser($line);
		open (FILE, ">${path}data/users/$line.txt");
print FILE <<EOF;
$info[0]
$info[1]
$info[2]
$info[3]
$info[4]
$info[5]
$info[6]
$info[7]
$info[8]
$info[9]
$info[10]
$info[11]
$info[12]
$info[13]
$info[14]
$info[15]
$info[16]
EOF
		close (FILE);
		open (FILE, ">>${path}data/$info[14].txt");
		print FILE "$line\n";
		close (FILE);
		chomp ($info[17]);
		open (FILE, ">${path}data/balance/$line.txt");
		print FILE "$info[17]";
		close (FILE);
		my @sites = &database_functions::GetSites($line);
		open (FILE, ">${path}data/sites/$line.txt");
		foreach my $site(@sites) {
			chomp($site);
			my @inner = split(/\|/, $site);
			print FILE "$inner[0]|$inner[1]|$inner[2]|$inner[3]|$inner[4]||$inner[8]\n";
		}
		close (FILE);
		my @stats = &database_functions::GetStats($line);
		my %hash = ();
		foreach my $stat(@stats) {
			chomp($stat);
			my @inner = split(/\|/, $stat);
			if (exists $hash{$inner[1]}) {
				$hash{$inner[1]} .= "|$inner[2]^$inner[3]^$inner[4]";
			} else {
				$hash{$inner[1]} = "$inner[1]|$inner[2]^$inner[3]^$inner[4]";
			}
		}
		open (FILE, ">${path}data/stats/$line.txt");
		foreach my $test(keys %hash) {
			print FILE "$hash{$test}\n";
		}
		close (FILE);
		if ($info[14] eq "active") {
			foreach my $site(@sites) {
				chomp($site);
				my @inner = split(/\|/, $site);
				if (-e "${path}data/search/$inner[0].txt") { open (FILE, ">>${path}data/search/$inner[0].txt"); }
				else { open (FILE, ">${path}data/search/$inner[0].txt"); }
				print FILE "$inner[1]|$line|$inner[2]|$inner[3]|$inner[4]|$inner[7]|$inner[8]\n";
				close (FILE);
			}
		}
	}
	opendir(FILE,"${path}data/search");
	my @bids = grep { /.txt/ } readdir(FILE);
	close (FILE);
	do "${path}functions_text.$file_ext";
	foreach my $bid(@bids) {
		chomp($bid);
		$bid =~ s/.txt//;
		&database_functions::sortit($bid);
	}	
print <<EOF;
<font face="verdana" size="-1"><B>Database successfully transferred from mysql to text</B><P>
</font>
EOF
}

sub no_conversion {
print <<EOF;
<font face="verdana" size="-1"><B>Database successfully configured.  Your old database was not transferred as indicated.</B><P>
</font>
EOF
}

&main_functions::footer;
&main_functions::exit;
}
###############################################

###############################################
sub mysqlconvert_status {
	my %hash = ();
	my $user_id2;
	my ($status, $type) = @_;
	open (FILE, "${path}data/$status.txt");
	my @member = <FILE>;
	close (FILE);
	foreach my $line(@member) {
		chomp($line);
		unless ($line eq "" || exists $hash{$line}) {
			$hash{$line} = "1";
			$user_id2++;
			&mysqlconvert_user($status, $type, $line);
			&mysqlconvert_sites($status, $type, $line, $user_id2);
			&mysqlconvert_stats($status, $type, $line);
		}
	}
}
###############################################

###############################################
sub mysqlconvert_user {
	my ($status, $type, $line) = @_;
	my @users = &database_functions::GetUser($line);
	my $bal = &database_functions::GetBalance($line);
	my $k=0;
	foreach my $test(@users) {
		chomp($test);
		$users[$k] = &database_functions::escape($test);
		$k++;
	}
	my $statement = "insert into users(name, street1, street2, city, province, zip, country, phone, email, card_holder, card_number,
card_expires, username, password, status, date, card_type, balance) values 
('$users[0]', '$users[1]', '$users[2]', '$users[3]', '$users[4]', '$users[5]', '$users[6]', '$users[7]',
 '$users[8]', '$users[9]', '$users[10]', '$users[11]', '$users[12]', '$users[13]', '$status', '$users[15]', '$users[16]', '$bal')";
	my $sth = &database_functions::mySQL($statement);
}
###############################################

###############################################
sub mysqlconvert_sites {
	my ($status, $type, $line, $user_id2) = @_;
	my $newdate = &main_functions::getdate;
	my @sites = &database_functions::GetSites($line);
	foreach my $line2(@sites) {
		chomp($line2);
		$line2 = &database_functions::escape($line2);
		my @inner = split(/\|/, $line2);
		my $searchterm = $inner[0];
		$searchterm = &database_functions::unescape($searchterm);
		open (FILE, "${path}data/search/$searchterm.txt");
		my @search = <FILE>;
		close (FILE);
		my ($found, $thedate);
		foreach my $se(@search) {
			chomp($se);
			my @inner2 = split(/\|/, $se);
			if ($inner2[1] eq $line) {
				$thedate = $inner2[5];
				$found=1;
				last;
			}
		}
		unless ($found) { undef $thedate; $thedate = $newdate; }
		my $statement = "select id from users where username='$line'";
		my $sth = &database_functions::mySQL($statement);
		my $user_id = $sth->fetchrow_array;
		if ($user_id eq "") { $user_id = $user_id2; }
		$statement = "insert into sites(term, bid, title, url, description, status, user, date) values
		('$inner[0]', '$inner[1]', '$inner[2]', '$inner[3]', '$inner[4]', '$type', '$user_id','$thedate')";
		$sth = &database_functions::mySQL($statement);
	}
}
###############################################

###############################################
sub mysqlconvert_stats {
	my ($status, $type, $line) = @_;
	my @stats = &database_functions::GetStats($line);
	foreach my $line2(@stats) {
		chomp($line2);
		my @inner = split(/\|/, $line2);
		my $t=0;
		my $searchterm;
		foreach my $inn(@inner) {
			chomp($inn);
			$inn = &database_functions::escape($inn);
			if ($t == 0) { $searchterm = $inn; }
			else {
				my @sublet = split(/\^/, $inn);
				my $thedate = $sublet[0];
				my $amt = $sublet[2];
				my $statement = "select id from users where username='$line'";
				my $sth = &database_functions::mySQL($statement);
				my $user_id = $sth->fetchrow_array;
				$statement = "insert into stats(user, term, date, amount, clicks) values ('$user_id', '$searchterm', '$thedate', '$amt', '$sublet[1]')";
				$sth = &database_functions::mySQL($statement);
			}
			$t++;
		}
	}
}
###############################################


###############################################
sub reviewer {
my ($message) = @_;
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my $adminurl = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
$adminurl =~ s/admin\.${file_ext}$//;
print <<EOF;
<font face="verdana" size="-1"><B><U>Listing Reviewer</U></B></font><P>
<center><font face="verdana" size="-1">If you would like to assign staff to approve listings, you can do so here by creating a special login which will only give them access to the pending members section.<BR>
Make sure you instruct your reviewers to login here:<BR><a href="admin.$file_ext?tab=reviewer_login" target="new">${adminurl}admin.$file_ext?tab=reviewer_login</a>.
<form METHOD="POST" ACTION="admin.$file_ext?tab=addreviewer&user=$FORM{'user'}">
<font face="verdana" size="-1" color="red"><B>$message</B></font>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><font face="verdana" size="-1" color="#000099"><B>Add Reviewer</td></tr>
<tr><td><font face="verdana" size="-1"><B>Username</B></font></td>
<td><font face="verdana" size="-1"><input type=text name=username size="30"></td></tr>
<tr><td><font face="verdana" size="-1"><B>Password</B></font></td>
<td><font face="verdana" size="-1"><input type=text name=password size="30"></td></tr>
<tr><td colspan=2><input type=hidden name=type value="add"><input type=submit value="Add"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
</form><BR>
<form METHOD="POST" ACTION="admin.$file_ext?tab=addreviewer&user=$FORM{'user'}">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><font face="verdana" size="-1" color="#000099"><B>Delete Reviewer</td></tr>
<tr><td><font face="verdana" size="-1"><B>Reviewer</B></font></td>
<td><font face="verdana" size="-1"><select name=username size="1">
EOF
my @reviewer = &database_functions::get_reviewer;
foreach my $line(@reviewer) {
	chomp($line);
	my @inner = split(/\|/, $line);
	print "<option>$inner[0]</option>\n";
}
print <<EOF;
</select></td></tr>
<tr><td colspan=2><input type=hidden name=type value="delete"><input type=submit value="Delete"></td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR></form>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><font face="verdana" size="-1" color="#000099"><B>Statistics</td></tr>
<tr><td><font face="verdana" size="-1"><B>User</B></font></td>
<td><font face="verdana" size="-1"><B>Date</B></font></td>
<td><font face="verdana" size="-1"><B># of Listings Processed</B></font></td></tr>
EOF
foreach my $line(@reviewer) {
	chomp($line);
	my @inner = split(/\|/, $line);
print <<EOF;
<tr><td><font face="verdana" size="-1">$inner[0]</font></td>
<td><font face="verdana" size="-1">$inner[2]</font></td>
<td><font face="verdana" size="-1">$inner[3]</font></td></tr>
EOF
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub addreviewer {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
if ($FORM{'type'} eq "add") {
	my $message = &database_functions::add_reviewer($FORM{'username'}, $FORM{'password'});
	&reviewer($message);
} elsif ($FORM{'type'} eq "delete") {
	my $message = &database_functions::delete_reviewer($FORM{'username'});
	&reviewer($message);
}
&main_functions::exit;
}
###############################################


###############################################
sub selectmerchant {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Merchant</U></B></font><P>
<center><font face="verdana" size="-1">Please select a 3rd party merchant to process bid search orders:<BR>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td><font face="verdana" size="-1"><B><a href="admin.$file_ext?tab=merchant&user=$FORM{'user'}&file=bidsearchengine&merchant=Authorize.Net">Authorize.Net</a></td>
<td><font face="verdana" size="-1">For the advanced master that will process a large amount of orders.</td></tr>
<tr><td><font face="verdana" size="-1"><B><a href="admin.$file_ext?tab=merchant&user=$FORM{'user'}&file=bidsearchengine&merchant=PayPal">PayPal</a></td>
<td><font face="verdana" size="-1">Very popular merchant based on a member system.</td></tr>
<tr><td><font face="verdana" size="-1"><B><a href="admin.$file_ext?tab=merchant&user=$FORM{'user'}&file=bidsearchengine&merchant=ClickBank">Click Bank</a></td>
<td><font face="verdana" size="-1">Simplistic merchant only recommended if you will be processing a small amount of orders.</td></tr>
<tr><td><font face="verdana" size="-1"><B><a href="admin.$file_ext?tab=merchant&user=$FORM{'user'}&file=bidsearchengine&merchant=2Checkout">2Checkout</a></td>
<td><font face="verdana" size="-1">Great for international owners wishing to process orders in their local currency.</td></tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub merchant {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my $text = $_[0];
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my $adminurl = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
$adminurl =~ s/admin\.${file_ext}$//;
my (@data, $testmode, $link, $step2, $step3, $step4, $step5);
open (FILE, "${path}config/merchant.txt");
my @merchant = <FILE>;
close (FILE);
chomp(@merchant);
if ($FORM{'merchant'} eq "Authorize.Net") {
	if ($merchant[0] eq "authorize.net") {
			@data = @merchant;
	}
	if ($data[2] eq "TRUE") { $testmode = "CHECKED"; }
	$link = "http://www.authorize.net";
	$step2 = "-Make sure you have not entered any referral URLs under Settings->Manage URLs in your authorize.net admin area.<BR>";
	$step2 .= "-Make sure you have not checked any of the required boxes under Settings->Payment Form / Receipt Settings.";
	$step3 = "Please install the following Perl Modules:<BR>";
	$step3 .= "<a href=\"http://www.openssl.org/source/\" target=\"new\">OpenSSL v0.9.1c</a> and <a href=\"http://www.bacus.pt/Net_SSLeay/index.html\" target=\"new\">Net::SSLeay v1.03</a>";
	#$step4 = "Open the file functions.$file_ext and uncomment (remove the #) the line:<BR>use Net::SSLeay qw(post_https make_headers make_form);";
	$step4 = "<!-- inputs --><tr><td width=60%><font face=\"verdana\" size=\"-1\">Enable Authorize.Net:&nbsp;</td>";
	$step4 .= "<td width=40%><INPUT TYPE=\"checkbox\" NAME=\"enable\" CHECKED></td></tr>";
	$step4 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Account ID:&nbsp;</td>";
	$step4 .= "<td width=40%><input type=text name=id size=20 value=\"$data[1]\"></td></tr>";
	$step4 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Enable Test Mode:&nbsp;</td>";
	$step4 .= "<td width=40%><INPUT TYPE=\"checkbox\" NAME=\"testmode\" $testmode></td></tr>";
} elsif ($FORM{'merchant'} eq "PayPal") {
	if ($merchant[0] eq "paypal") {
		@data = @merchant;
	}
	$link = "https://www.paypal.com/affil/pal=VEFV47532GY2J";
	$step2 = "Make sure you have the following modules installed on your server:<BR>";
	$step2 .= "-libwww<BR>-Crypt::SSLeay<BR>These can be downloaded from <a href=\"http://www.cpan.org\" target=new>cpan.org</a>.";
	$step3 = "-After Paypal approves your new account, log into the paypal admin area and click the button 'sell' and then the link 'Single-item purchases'<BR>";
	$step3 .= "-Fill in the item name field with 'Bid Search Engine' and enter a item ID number.  Then click the 'create button now' button.";
	$step4 = "-From the Paypal admin area, click the 'profile' link and then the link that reads 'Instant Payment Notification Preferences' under the Selling Preferences section.<BR>";
	$step4 .= "-Fill in the input box with the following URL and click the save button:<BR>${adminurl}signup.$file_ext?tab=merchant";
	$step5 = "<!-- inputs --><tr><td width=60%><font face=\"verdana\" size=\"-1\">Enable PayPal:&nbsp;</td>";
	$step5 .= "<td width=40%><INPUT TYPE=\"checkbox\" NAME=\"enable\" CHECKED></td></tr>";
	$step5 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Account Username (email address):&nbsp;</td>";
	$step5 .= "<td width=40%><input type=text name=id size=30 value=\"$data[1]\"></td></tr>";
	$step5 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Item Number (set in step2.  Make sure it is in the 3 digit format (ex. 001):&nbsp;</td>";
	$step5 .= "<td width=40%><input type=text name=number size=5 value=\"$data[2]\"></td></tr>";
	$step5 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Item Name:&nbsp;</td>";
	$step5 .= "<td width=40%><input type=text name=itemname size=20 value=\"$data[3]\"></td></tr>";
} elsif ($FORM{'merchant'} eq "ClickBank") {
	if ($merchant[0] eq "clickbank") {
		@data = @merchant;
	}
	$link = "http://zzz.clickbank.net/r/?doneright";
	$step2 = "Now create your thank-you links from the Click Bank admin area by using the URL:<BR>${adminurl}signup.$file_ext?tab=merchant<BR><BR>";
	$step2 .= "From the admin area, you also need to specify a 'secret key'.  The key you choose should also be entered in step 3.";
	$step3 = "<!-- inputs --><tr><td width=60%><font face=\"verdana\" size=\"-1\">Enable PayPal:&nbsp;</td>";
	$step3 .= "<td width=40%><INPUT TYPE=\"checkbox\" NAME=\"enable\" CHECKED></td></tr>";
	$step3 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Account ID:&nbsp;</td>";
	$step3 .= "<td width=40%><input type=text name=id size=20 value=\"$data[1]\"></td></tr>";
	$step3 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Secret Key (Should be the key specified while doing step 2):&nbsp;</td>";
	$step3 .= "<td width=40%><input type=text name=secretkey size=20 value=\"$data[2]\"></td></tr>";
	my $last;
	if (@data) { $last = @data; }
	else { $last = 5; }
	for my $num(1 .. $last) {
		my ($number, $amt) = split(/\|/, $data[$num+2]);
		$step3 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Price for Product \#$num:&nbsp;</td>";
		$step3 .= "<td width=40%><font face=\"verdana\" size=\"-1\">\$<input type=text name=product$num size=10 value=\"$amt\"></td></tr>";
	}
	$step4 = "<a href=\"customize.$file_ext?tab=selecthtml&user=$FORM{'user'}&file=bidsearchengine\">Customize</a> the third signup page and the member update balance page by adding the prices you have setup above to the pull-down menu.  You will also need delete the credit card fields from the template pages.<BR>";
	$step4 .= "Here is an example of the code you need to add to your template pages:<BR>&lt;SELECT NAME=\"balance\" SIZE=\"1\"&gt;&lt;option&gt;10&lt;/option&gt;&lt;/select&gt;.<BR>";
	$step4 .= "After you click the button below, the script will attempt to apply this code to your template pages";
} elsif ($FORM{'merchant'} eq "2Checkout") {
	if ($merchant[0] eq "2checkout") {
		@data = @merchant;
	}
	$link = "http://www.2checkout.com/cgi-bin/aff.2c?affid=23345";
	$step2 = "From the 2checkout admin area, do the following<BR>";
	$step2 .= "-Click 'Account Details->return'.  Scroll down to the 'cartpurchase.2c Shopping Cart Parameters' section.<BR>";
	$step2 .= "-Select yes for 'Return to a routine on your site after credit card processed?'.  For the 'Return URL', type in this URL and click the save button:<BR>${adminurl}signup.$file_ext?tab=merchant<BR>";
	$step2 .= "-Under the 'Account Details->return' page, scroll down to the bottom of the page, set your secret word and click save.  (Make sure the 'Direct Return' remains as 'No')";
	$step3 = "<!-- inputs --><tr><td width=60%><font face=\"verdana\" size=\"-1\">Enable 2checkout:&nbsp;</td>";
	$step3 .= "<td width=40%><INPUT TYPE=\"checkbox\" NAME=\"enable\" CHECKED></td></tr>";
	$step3 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Account ID:&nbsp;</td>";
	$step3 .= "<td width=40%><input type=text name=id size=20 value=\"$data[1]\"></td></tr>";
	$step3 .= "<tr><td width=60%><font face=\"verdana\" size=\"-1\">Secret Key (Should be the key specified while doing step 2):&nbsp;</td>";
	$step3 .= "<td width=40%><input type=text name=secretkey size=20 value=\"$data[2]\"></td></tr>";
	$step4 = "<a href=\"customize.$file_ext?tab=selecthtml&user=$FORM{'user'}&file=bidsearchengine\">Customize</a> the third signup page and the member update balance page by removing the credit detail fields and just leave the balance input box.<BR>";
}
print <<EOF;
<font face="verdana" size="-1"><B><U>$FORM{'merchant'} Configuration</U></b><P>
<font face="verdana" size="-1">
<form METHOD="POST" ACTION="admin.$file_ext?tab=setmerchant&user=$FORM{'user'}&file=bidsearchengine&merchant=$FORM{'merchant'}">
<font face="verdana" size="-1">$text
<table width=90% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000099"><B>Step 1</B></font></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1">The first thing you need to do is sign up for an account from <a href="$link" target=new>$FORM{'merchant'}</a>.  Once you have done that, you can proceed with the steps below.</td></tr>
<tr>
<td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000099"><B>Step 2</B></font></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1">$step2</td></tr>
<tr>
<td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000099"><B>Step 3</B></font></td></tr>
EOF
if ($step3 =~ /<\!-- inputs -->/) {
	print $step3;
} else {
print <<EOF;
<tr>
<td colspan=2><font face="verdana" size="-1">$step3</td></tr>
<tr>
<td colspan=2>&nbsp;</td></tr>
EOF
}
if ($step4) {
	if ($step4 =~ /<\!-- inputs -->/) {
		print $step4;
	} else {
print <<EOF;
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000099"><B>Step 4</B></font></td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1">$step4</td></tr>
<tr>
<td colspan=2>&nbsp;</td></tr>
EOF
	}
}
if ($step5) {
print <<EOF;
<tr>
<td colspan=2><font face="verdana" size="-1" color="#000099"><B>Step 5</B></font></td></tr>
$step5
EOF
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table><BR>
<input type=submit value="Set Configuration">
</form><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub setmerchant {
$FORM{'user'} = &main_functions::checklogin($FORM{user});

unless ($FORM{'id'}) {
	if ($FORM{'enable'} eq "on") {
		my $text = "<font color=red>ERROR: Please specify your account ID</font>";
		&merchant($text);
		&main_functions::exit;
	}
}
if ($FORM{'enable'} eq "on") {
	open (FILE, ">${path}config/merchant.txt");
	if ($FORM{'merchant'} eq "Authorize.Net") {
		print FILE "authorize.net\n";
		print FILE "$FORM{'id'}\n";
		if ($FORM{'testmode'} eq "on") { print FILE "TRUE\n"; }
		else { print FILE "FALSE\n"; }
		close (FILE);
	} elsif ($FORM{'merchant'} eq "PayPal") {
		print FILE "paypal\n";
		print FILE "$FORM{'id'}\n";
		print FILE "$FORM{'number'}\n";
		print FILE "$FORM{'itemname'}\n";
		close (FILE);
	} elsif ($FORM{'merchant'} eq "2Checkout") {
		print FILE "2checkout\n";
		print FILE "$FORM{'id'}\n";
		print FILE "$FORM{'secretkey'}\n";
		close (FILE);
	} elsif ($FORM{'merchant'} eq "ClickBank") {
		print FILE "clickbank\n";
		print FILE "$FORM{'id'}\n";
		print FILE "$FORM{'secretkey'}\n";
		my $num = 1;
		my $product = "product$num";
		while ($FORM{$product}) {
			print FILE "$num|$FORM{$product}\n";
			$num++;
			$product = "product$num";
		}
		close (FILE);
open (FILE, ">${path}template/signup3.txt");
print FILE <<EOF;
<html>
<head>
  <title>Bid Search Engine</title>
</head>

<center>
<font face="verdana"><B>Bid Search Engine</B> - <font color="#000099">Signup Step 3</font></font><P><BR>

<form method="post" action="signup.[ext]?tab=signup4">
<!-- [signup1] -->
<!-- [signup2] -->
<B><font face="verdana" size="-1" color="red"><!-- [error] --></font></B>
<table width=60% border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <center>
      <table border="0" width=100% cellspacing="1" cellpadding="1" bgcolor="#000000">
        <tr>
          <td>
            <table border="0" width=100% cellspacing="0" cellpadding="3" bgcolor=#E0DCC0>
              <tr>
                <td colspan=2>
                  <B><font face="verdana" size="1" color="#000099">Credit Information</font></B>
                </td>
              </tr>
              <tr>
                <td><font face="verdana" size="1">Balance (minimum of <!-- [balance] -->):</font></td>
                <td>
                  <SELECT NAME="balance" SIZE="1">
EOF
$num = 1;
$product = "product$num";
while ($FORM{$product}) {
	print FILE "<option>$FORM{$product}</option>\n";
	$num++;
	$product = "product$num";
}
print FILE <<EOF;
                  </SELECT>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <BR>
      </center><input type=submit value="Submit">
    </td>
  </tr>
</table>

</form>
</center>

</BODY>
</HTML>
EOF
close (FILE);

open (FILE, ">${path}template/balance.txt");
print FILE <<EOF;
<html>
<head>
  <title>Bid Search Engine</title>
</head>

<center>
<font face="verdana"><B>Bid Search Engine</B> - <font color="#000099">Update Balance</font></font><P><BR>

<form method="post" action="members.[ext]?tab=balancesubmit&user=[user]&pass=[pass]">
<font face="verdana" size="-1">
<a href="members.[ext]?tab=login&user=[user]&pass=[pass]">Main</a> | 
<a href="members.[ext]?tab=stats&user=[user]&pass=[pass]">Statistics</a> | 
<a href="members.[ext]?tab=profile&user=[user]&pass=[pass]">Modify Profile</a> | 
<a href="members.[ext]?tab=manage&user=[user]&pass=[pass]">Manage Listings</a> | 
Update Balance | 
<a href="members.[ext]?tab=bids&user=[user]&pass=[pass]">Update Bids</a>
</font></B><BR>
<B><font face="verdana" size="-1" color="red"><!-- [error] --></font></B>
<table width=60% border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <center>
      <table border="0" width=100% cellspacing="1" cellpadding="1" bgcolor="#000000">
        <tr>
          <td>
            <table border="0" width=100% cellspacing="0" cellpadding="3" bgcolor=#E0DCC0>
              <tr>
                <td colspan=2>
                  <B><font face="verdana" size="-1" color="#000099">Ordering Information</font></B>
                </td>
              </tr>
              <tr>
                <td><font face="verdana" size="-1">Current Balance:</font></td>
                <td><font face="verdana" size="-1"><!-- [currentbalance] --></font></td>
              </tr>
              <tr>
                <td><font face="verdana" size="-1">Amount to add to Balance:</font></td>
                <td>
                  <SELECT NAME="balance" SIZE="1">
EOF
$num = 1;
$product = "product$num";
while ($FORM{$product}) {
	print FILE "<option>$FORM{$product}</option>\n";
	$num++;
	$product = "product$num";
}
print FILE <<EOF;
                  </SELECT>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <BR>
      </center><input type=submit value="Submit">
    </td>
  </tr>
</table>

</form>
</center>

</BODY>
</HTML>
EOF
close (FILE);
	}
	unless ($config{'server'} eq "nt") { chmod (0777,"config/merchant.txt"); }
	my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Configuration Set</B></font></font>";
	&merchant($text);
} else {
	unlink("${path}config/merchant.txt");
	my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>$FORM{'merchant'} Disabled</B></font></font>";
	&merchant($text);
}
&main_functions::exit;
}
###############################################


###############################################
sub pending {
my ($loginstring, $nolink);
if ($FORM{'reviewer'}) {
	my $pass = &database_functions::check_reviewerlogin($FORM{username}, $FORM{password}, $FORM{formlog});
	$loginstring = "&username=$FORM{username}&password=$pass&reviewer=1&nolink=1";
	$nolink = 1;
} else {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	$loginstring = "&user=$FORM{'user'}";
}
my $message = $_[0];
print "Content-type: text/html\n\n";
my (@processing, @addition, @balanceaddon, @active, @inactive);
my ($processing, $active, $inactive, $addition, $balanceaddon) = &database_functions::count_members(\@processing, \@addition, \@balanceaddon, \@active, \@inactive);
&main_functions::header($nolink, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Pending Listings</U></b><P>
<center><font face="verdana" size="-1">New Members Waiting to be Processed: <font color="#000099">$processing</font></font><BR>
<font face="verdana" size="-1">Existing Members Waiting for balance addon to be Processed: <font color="#000099">$balanceaddon</font></font><BR>
<font face="verdana" size="-1">Existing Members Waiting for listings to be Processed: <font color="#000099">$addition</font></font>
<form METHOD="POST" ACTION="admin.$file_ext?tab=listings$loginstring">
$message
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<TR><TD><font face="verdana" size="-1"><B>Process New User:</B></TD>
<TD><SELECT NAME="member" SIZE="1"><option SELECTED>Select Member to Process</option>
EOF
for (my $i = 0; $i < @processing; $i++) {
	print "<option>$processing[$i]</option>";
}
print <<EOF;
</select>&nbsp;&nbsp;<input type="hidden" name="process" value="new"><input type="submit" value="Go">
</TD></TR>
<TR><TD></form><form METHOD="POST" ACTION="admin.$file_ext?tab=listings$loginstring"><font face="verdana" size="-1"><B>Process Existing User (Balance Update):</B></TD>
<TD><SELECT NAME="member" SIZE="1"><option SELECTED>Select Member to Process</option>
EOF

if ($config{'data'} eq "text") {
	my @sort = sort(@balanceaddon);
	foreach my $line(@sort) {
		chomp($line);
		my @inner = split(/\|/, $line);
		print "<option>$inner[0]</option>";
	}
} else {
	for (my $i = 0; $i < @balanceaddon; $i++) {
		print "<option>$balanceaddon[$i]</option>";
	}
}
print <<EOF;
</select>&nbsp;&nbsp;<input type="hidden" name="process" value="existing"><input type="submit" value="Go">
</TD></TR>
<TR><TD></form><form METHOD="POST" ACTION="admin.$file_ext?tab=listings$loginstring"><font face="verdana" size="-1"><B>Process Existing User (Listing Addition/Modification):</B></TD>
<TD><SELECT NAME="member" SIZE="1"><option SELECTED>Select Member to Process</option>
EOF

if ($config{'data'} eq "text") {
	my @sort = sort(@addition);
	foreach my $line(@sort) {
		chomp($line);
		my @inner = split(/\|/, $line);
		my @user = &database_functions::GetUser($inner[0]);
		if ($user[14] eq "active") { print "<option>$inner[0]</option>"; }
	}
} else {
	for (my $i = 0; $i < @addition; $i++) {
		print "<option>$addition[$i]</option>"; 
	}
}
print <<EOF;
</select>&nbsp;&nbsp;<input type="hidden" name="process" value="addition"><input type="submit" value="Go">
</TD></TR>
</TABLE>
</TD></TR></TABLE>
</TD></TR></TABLE></form><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub listings {
my ($loginstring);
if ($FORM{'reviewer'}) {
	my $pass = &database_functions::check_reviewerlogin($FORM{username}, $FORM{password});
	$loginstring = "&username=$FORM{username}&password=$pass&reviewer=1&nolink=1";
} else {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	$loginstring = "&user=$FORM{'user'}";
}
print "Content-type: text/html\n\n";
&main_functions::header($FORM{nolink}, $FORM{user});
my $account = $FORM{'member'};
my @user = &database_functions::GetUser($account);
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
my ($personsname, $email, $ccname, $ccnum, $ccexpire, $date, $cctype, $comp) = ($user[0], $user[8], $user[9], $user[10], $user[11], $user[15], $user[16], $user[18]);
my $encryptkey = "drbidsearch";
$ccnum = &main_functions::Decrypt($ccnum,$encryptkey,'asdfhzxcvnmpoiyk');
my $balance = &database_functions::GetBalance($account);
my $type;
if ($FORM{'process'} eq "existing" || $FORM{'process'} eq "addition") {	$type = "Existing"; }
else { $type = "New"; }

my $printaccount = $account;
if ($config{'data'} eq "mysql") { $printaccount = &database_functions::unescape($printaccount); }
print <<EOF;
<font face="verdana" size="-1"><B><U>Process $type Member</U></b><P>
<center>
<form METHOD="POST" ACTION="admin.$file_ext?tab=approve&member=$account$loginstring">
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<TR>
<TD><font face="verdana" size="-1"><B>Account:</B></font></td>
<TD><font face="verdana" size="-1">$printaccount</font></td>
</TR>
<TR>
<TD><font face="verdana" size="-1"><B>Name:</B></font></td>
<TD><font face="verdana" size="-1">$personsname</font></td>
</TR>
EOF
if ($comp) {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Company:</B></font></td>
<TD><font face="verdana" size="-1">$comp</font></td>
</TR>
EOF
}
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Email:</B></font></td>
<TD><font face="verdana" size="-1"><a href="mailto:$email">$email</a></font></td>
</TR>
<TR>
<TD><font face="verdana" size="-1"><B>Date of Signup:</B></font></td>
<TD><font face="verdana" size="-1">$date</font></td>
</TR>
EOF

unless ($FORM{'process'} eq "addition") {
	if ($ccname eq "Free") {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Account Type:</B></font></td>
<TD><font face="verdana" size="-1">Free Signup</font></td>
</TR>
EOF
	} else {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Credit Card Holder's Name:</B></font></td>
<TD><font face="verdana" size="-1">$ccname</font></td>
</TR>
<TR>
<TD><font face="verdana" size="-1"><B>Credit Card Number:</B></font></td>
<TD><font face="verdana" size="-1">$ccnum</font></td>
</TR>
<TR>
<TD><font face="verdana" size="-1"><B>Credit Card Type:</B></font></td>
<TD><font face="verdana" size="-1">$cctype</font></td>
</TR>
<TR>
<TD><font face="verdana" size="-1"><B>Credit Card Expiration Date:</B></font></td>
<TD><font face="verdana" size="-1">$ccexpire</font></td>
</TR>
EOF
	}
}
my $count;
if ($FORM{'process'} eq "existing") {
	my $balance2 = &database_functions::get_balanceaddon($account);
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Current Balance:</B></font></td>
<TD><font face="verdana" size="-1">$adv[15]$balance</font></td>
</TR>
EOF
unless ($ccname eq "Free") {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Amount to add to Balance:</B></font></td>
<TD><font face="verdana" size="-1">$adv[15]$balance2</font></td>
</TR>
EOF
}
print <<EOF;
<TR>
<TD colspan=2>
<input type="hidden" name="process" value="existing"><input type=submit name=approve value="Approve">&nbsp;<input type=submit name=approve value="Deny">
</TD></TR>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
	} elsif ($FORM{'process'} eq "addition") {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Current Balance:</B></font></td>
<TD><font face="verdana" size="-1">$adv[15]$balance</font></td>
</TR>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
EOF
	my @sites = &database_functions::GetSites($account);
	foreach my $line(@sites) {
		my @inner = split(/\|/, $line);
		$count++;
		my $keyword = "keyword$count";
		my $title = "title$count";
		my $description = "description$count";
		my $url = "url$count";
		my $bid = "bid$count";
		my $oldbid = "oldbid$count";
		my $site_id = "id$count";
		my $id;
		if ($config{'data'} eq "mysql") { $id = $inner[8]; }
		else { $id = $inner[6]; }
		my $appden = "appden$count";
		chomp($inner[4]);
		if ($inner[5] eq "new" or $inner[5] eq 'edit' or $inner[5] eq 'add') {
			##if it is in edit mode we need to get the new edited entry	
			if ($inner[5] eq 'edit' && $config{'data'} eq "mysql") {
				$inner[0] = &database_functions::escape($inner[0]);
				my $user_id = &database_functions::mySQLGetUserID($account);
				my $statement = "select edit_sites.term, edit_sites.bid, edit_sites.title, edit_sites.url, edit_sites.description, sites.bid, sites.id from edit_sites, sites where (edit_sites.term='$inner[0]' and edit_sites.user='$user_id') and (sites.term='$inner[0]' and sites.user='$user_id')";
				my $sth = &database_functions::mySQL($statement);
				undef (@inner);
				@inner = $sth->fetchrow_array;
				$sth->finish;
				$id = $inner[6];
			}

print <<EOF;
<TR><TD colspan=2><B><font face=verdana size="-1">Listing #$count</font></B></TD></TR>
<TR>
<TD><font face=verdana size="-1">Keyword:</TD>
<TD><font face=verdana size="-1"><input type="hidden" name="$site_id" value="$id"><input type="hidden" name="old_$keyword" value="$inner[0]"><input type=text name=$keyword value="$inner[0]"></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">Bid:</TD>
<TD><font face=verdana size="-1"><input type=hidden name=$oldbid value="$inner[5]"><input type=text name=$bid value="$inner[1]"></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">Title:</TD>
<TD><font face=verdana size="-1"><input type=text size=40 name=$title value="$inner[2]"></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">Description:</TD>
<TD><font face=verdana size="-1"><TEXTAREA name="$description" maxlength="190" ROWS=3 COLS=54>$inner[4]</TEXTAREA></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">URL:</TD>
<TD><font face=verdana size="-1"><input type=text size=40 name=$url value="$inner[3]"> <a href="$inner[3]" target="new">Verify URL</A></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">&nbsp;</TD>
<TD><font face=verdana size="-1"><input type="radio" name="$appden" value="approve" CHECKED> APPROVE &nbsp;&nbsp; <input type="radio" name="$appden" value="deny"> DENY</TD>
</TR>
<TR><TD colspan=2><B><font face=verdana size="-1">&nbsp;</font></B></TD></TR>
EOF
		} else { $count--; }
	}

print <<EOF;
<TR>
<TD colspan=2><input type=hidden name=count value="$count">
<input type="hidden" name="process" value="addition">
EOF
	if ($count == 0) { print "<input type=submit value=\"Approve\">"; }
	else { print "<input type=submit value=\"Submit\">"; }
print <<EOF;
</TD></TR>
</TABLE>
</TD></TR></TABLE>
</TD></TR></TABLE></form>
<BR>
EOF

	} else {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Balance Ordered:</B></font></td>
<TD><font face="verdana" size="-1">$adv[15]$balance</font></td>
</TR>
EOF
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	if ($adv[13] && $ccname ne "Free") {
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Extra Amount given free from Admin:</B></font></td>
<TD><font face="verdana" size="-1">$adv[15]$adv[13]</font></td>
</TR>
EOF
	}
print <<EOF;
<TR>
<TD><font face="verdana" size="-1"><B>Deny new member (delete member)</B></font></td>
<TD><font face="verdana" size="-1"><input type=submit name=approve value="Deny"></font></td>
</TR>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
	my $count;
	unless ($opt[11] eq "CHECKED") {
print <<EOF;
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
EOF
		my @sites = &database_functions::GetSites($account);
		foreach my $line(@sites) {
			chomp($line);
			my @inner = split(/\|/, $line);
			$count++;
			my $keyword = "keyword$count";
			my $title = "title$count";
			my $description = "description$count";
			my $url = "url$count";
			my $bid = "bid$count";
			my $oldbid = "oldbid$count";
			my $id;
			my $site_id = "id$count";
			if ($config{'data'} eq "mysql") { $id = $inner[8]; }
			else { $id = $inner[6]; }
			my $appden = "appden$count";
			chomp($inner[4]);
print <<EOF;
<TR><TD colspan=2><B><font face=verdana size="-1">Listing #$count</font></B></TD></TR>
<TR>
<TD><font face=verdana size="-1">Keyword:</TD>
<TD><font face=verdana size="-1"><input type="hidden" name="$site_id" value="$id"><input type="hidden" name="old_$keyword" value="$inner[0]"><input type=text name=$keyword value="$inner[0]"></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">Bid:</TD>
<TD><font face=verdana size="-1"><input type=hidden name=$oldbid value="$inner[1]"><input type=text name=$bid value="$inner[1]"></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">Title:</TD>
<TD><font face=verdana size="-1"><input type=text size=40 name=$title value="$inner[2]"></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">Description:</TD>
<TD><font face=verdana size="-1"><TEXTAREA name="$description" maxlength="190" ROWS=3 COLS=54>$inner[4]</TEXTAREA></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">URL:</TD>
<TD><font face=verdana size="-1"><input type=text size=40 name=$url value="$inner[3]"> <a href="$inner[3]" target="new">Verify URL</A></TD>
</TR>
<TR>
<TD><font face=verdana size="-1">&nbsp;</TD>
<TD><font face=verdana size="-1"><input type="radio" name="$appden" value="approve" CHECKED> APPROVE &nbsp;&nbsp; <input type="radio" name="$appden" value="deny"> DENY</TD>
</TR>
<TR><TD colspan=2><B><font face=verdana size="-1">&nbsp;</font></B></TD></TR>
EOF
		}
	} else {
print <<EOF;
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
EOF
	}
print <<EOF;
<TR>
<TD colspan=2><input type=hidden name=count value="$count">
<input type="hidden" name="process" value="new">
EOF
	if ($count == 0) { print "<input type=submit value=\"Approve\">"; }
	else { print "<input type=submit value=\"Submit\">"; }
print <<EOF;
</TD></TR>
</TABLE>
</TD></TR></TABLE>
</TD></TR></TABLE></form>
<BR>
EOF
}
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub approve {
my ($loginstring);
if ($FORM{'reviewer'}) {
	my $pass = &database_functions::check_reviewerlogin($FORM{username}, $FORM{password});
	$loginstring = "&username=$FORM{username}&password=$pass&reviewer=1&nolink=1";
	&database_functions::update_reviewer($FORM{username});
} else {
	$FORM{'user'} = &main_functions::checklogin($FORM{user});
	$loginstring = "&user=$FORM{'user'}";
}
my $account = $FORM{'member'};
my ($company, $websiteurl) = (&main_functions::config_vars())[3,4];
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);

my @user = &database_functions::GetUser($account);
if ($config{'data'} eq "text" && $FORM{'process'} eq "new") {
	&database_functions::remove_status('processing', $account);
}

my $newdate = &main_functions::getdate;
my ($oldstatus, $balance2, $newbalance);
if ($FORM{'approve'} eq "Deny") { &deny(@user); }
else {
	$oldstatus = $user[14];
	unless ($FORM{'process'} eq "addition") {
		&database_functions::change_status('active', $account, '1');
	}
	my $process = $FORM{'process'};
	($balance2, $newbalance) = &$process($oldstatus);
	#Affiliate
	if (-e "${path}affiliate/config/config.cgi" && $info[9] ne "Free") {
		$FORM{'affiliatesignup'} = 1;
		$FORM{'username'} = $account;
		do "${path}affiliate/click.cgi";
		&click_functions::affiliate_signup(%FORM);
		do "${path}config/config.cgi";
		if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
		else { do "${path}functions_text.$file_ext"; }
		do "${path}functions.$file_ext";
	}
}

if ($FORM{'process'} eq "existing") { open (FILE, "${path}template/emailaddonbalance.txt"); }
else { open (FILE, "${path}template/emailapprove.txt"); }
my @emailmess = <FILE>;
close (FILE);
my ($emailtemp, $memurl);
foreach my $emailtemp2(@emailmess) {
	chomp($emailtemp2);
	$emailtemp .= "$emailtemp2\n";
}
unless ($config{'secureurl'} eq "") { $memurl = $config{'secureurl'}; }
else { $memurl = $config{'adminurl'}; }
$emailtemp =~ s/\[balance\]/$adv[15]$balance2/ig;
$emailtemp =~ s/\[totalbalance\]/$adv[15]$newbalance/ig;
$emailtemp =~ s/\[name\]/$user[0]/ig;
$emailtemp =~ s/\[username\]/$user[12]/ig;
my $pass2 = $user[13];
my $encryptkey = "mempassbse";
$pass2 = &main_functions::Decrypt($pass2,$encryptkey,'asdfhzxcvnmpoiyk');
$emailtemp =~ s/\[password\]/$pass2/ig;
$emailtemp =~ s/\[company\]/$company/ig;
$emailtemp =~ s/\[url\]/$websiteurl/ig;
$emailtemp =~ s/\[loginurl\]/${memurl}members.$file_ext/ig;
my ($count, $app, $den, $disapproved, $approved);
for $count(1 .. $FORM{'count'}) {
	my $appden = "appden$count";
	my $keyword = "keyword$count";
	if ($FORM{$appden} eq "deny") {
		$disapproved .= "$FORM{$keyword}\n";
		$den++;
	} else {
		$approved .= "$FORM{$keyword}\n";
		$app++;
	}
}
$emailtemp =~ s/\[listings\]/Your Listings\n-------------\nAPPROVED LISTINGS\n$approved\n\nDISAPPROVED LISTINGS\n$disapproved/ig;
my ($subject, $message);
if ($FORM{'process'} eq "existing") { $subject = "$company - Balance Update Processed"; }
else { $subject = "$company - Listing Online"; }
&main_functions::send_email($config{'adminemail'}, $user[8], $subject, $emailtemp);
if ($FORM{'process'} eq "addition" || $FORM{'process'} eq "new") {
	if ($app == 0 && $den == 0) {
		$message = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Member Successfully Approved</font></B><BR>";
	} else {
		$message = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Listing(s) Successfully Approved ($app), Disapproved ($den)</font></B><BR>";
	}
} else {
	$message = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Balance Update Successfully Processed</font></B><BR>";
}
&pending($message);
&main_functions::exit;
}
###############################################


###############################################
sub new {
	my $account = $FORM{'member'};
	my $oldstatus = $_[0];
	my (@eng, @adv, @opt, $newbalance);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	unless ($opt[11] eq "CHECKED") { &stats; }
	my $balance = &database_functions::GetBalance($account);
	my @info = &database_functions::GetUser($account);
	if ($adv[13] && $info[9] ne "Free") {
		$newbalance = $balance + $adv[13];
		&database_functions::update_balance($account, $newbalance);
	} else { $newbalance = $balance; }
	&status($oldstatus, $account);
	&sites;
	if (($opt[11] ne "CHECKED" || $newbalance > 0) && $config{'data'} eq "text") { &search; }
	if ($newbalance > 0) {
		my $newdate = &main_functions::getdate;
		&database_functions::payment_history($account, $newdate, $newbalance);
	}
}
###############################################


###############################################
sub addition {
	my $account = $FORM{'member'};
	&stats;
	my $newbalance = &database_functions::GetBalance($account);
	&sites;
	if ($config{'data'} eq "text") { &database_functions::remove_status('addition', $account); }
	if ($newbalance > 0 && $config{'data'} eq "text") { &search; }
}
###############################################


###############################################
sub existing {
	my $oldstatus = $_[0];
	my $account = $FORM{'member'};
	my $newbalance = &database_functions::GetBalance($account);
	my $balance2 = &database_functions::get_balanceaddon($account);
	$newbalance = $newbalance + $balance2;
	&database_functions::update_balance($account, $newbalance);
	&database_functions::remove_status('balanceaddon', $account);
	&status($oldstatus, $account);
	if ($newbalance > 0) {
		my $newdate = &main_functions::getdate;
		&database_functions::payment_history($account, $newdate, $balance2);
	}
	if ($oldstatus eq "inactive") {
		my @sites = &database_functions::GetSites($account);
		my $count = 0;
		foreach my $line(@sites) {
			chomp($line);
			my $keyword = "keyword$count";
			my @inner = split(/\|/, $line);
			&database_functions::update_sites($inner[0], 'approved', $account, $inner[1], $inner[2], $inner[3], $inner[4], $FORM{'old_'.$keyword}, $inner[8]);
			if ($config{'data'} eq "text") { &database_functions::sortit($inner[0]); }
			&database_functions::outbidded($inner[0], $inner[1], $account, undef, undef, $FORM{process});
			$count++;
		}
	}
	return ($balance2, $newbalance);	
}
###############################################


###############################################
sub sites {
	my $account = $FORM{'member'};
	my $count = 0;
	my (@eng, @adv, @opt);
	&main_functions::getdefaults(\@eng, \@adv, \@opt);
	unless ($opt[11] eq "CHECKED" && $FORM{'process'} eq "new") {
		my @sites = &database_functions::GetSites($account);
		my $user_id;
		if ($config{'data'} eq "mysql") {
			$user_id = &database_functions::mySQLGetUserID($account);
		} else {
			open (FILE, ">${path}data/sites/$account.txt");
		}
		for $count(1 .. $FORM{'count'}) {
			my $keyword = "keyword$count";
			my $title = "title$count";
			my $description = "description$count";
			my $url = "url$count";
			my $bid = "bid$count";
			my $site_id = "id$count";
			my $oldbid = "oldbid$count";
			my $appden = "appden$count";
			$FORM{$description} =~ s/\t/ /g;
			$FORM{$description} =~ s/\r/ /g;
			$FORM{$description} =~ s/\n/ /g;
			$FORM{$keyword} =~ s/\|/\:/g;
			$FORM{$url} =~ s/\|/\:/g;
			$FORM{$title} =~ s/\|/\:/g;
			$FORM{$description} =~ s/\|/\:/g;
			my @new_data;
			if ($config{'data'} eq "mysql") {
				##check to see if this was an edit or an actual addition
				my $statement = "select original, bid, title, url, description, id from edit_sites where term='$FORM{$keyword}' and user='$user_id'";
				my $sth = &database_functions::mySQL($statement);
				@new_data = $sth->fetchrow_array;
				$sth->finish;
				for (my $i = 0; $i < @new_data; $i++) {
					$new_data[$i] = &database_functions::escape($new_data[$i]);	
				}
			}			
			unless ($FORM{$appden} eq "deny") {
				if ($config{'data'} eq "mysql") {
					$FORM{$title} = &database_functions::escape($FORM{$title});
					$FORM{$description} = &database_functions::escape($FORM{$description});
					##lets check for to see if the site is in  edit mode
					if (@new_data > 0) {
						my $statement = "update sites set status='approved', bid='$FORM{$bid}', title='$FORM{$title}',
						url='$FORM{$url}', description='$FORM{$description}' where id='$new_data[0]'";
						&database_functions::mySQL($statement);
						&database_functions::remove_status('edit_sites', $account);
					} else {
						&database_functions::update_sites($FORM{$keyword}, 'approved', $account, $FORM{$bid}, $FORM{$title}, $FORM{$url}, $FORM{$description}, $FORM{'old_'.$keyword}, $FORM{$site_id});
					}
				} else {
print FILE <<EOF;
$FORM{$keyword}|$FORM{$bid}|$FORM{$title}|$FORM{$url}|$FORM{$description}||$FORM{$site_id}
EOF
				}
				if ($FORM{'process'} eq "addition") {
					if ($config{'data'} eq "mysql") {
						if (@new_data > 0) {
							if ($FORM{$bid} > $FORM{$oldbid}) {
								&database_functions::outbidded($FORM{$keyword}, $FORM{$bid}, $account, undef, $FORM{$oldbid}, $FORM{process});
							}
						} else {
							&database_functions::outbidded($FORM{$keyword}, $FORM{$bid}, $account, undef, $FORM{$oldbid}, $FORM{process});
						}
					}
				} else {
					if ($config{'data'} eq "mysql") {
						my $statement = "select * from sites where term='$FORM{$keyword}'";
						if ($FORM{$site_id}) { $statement .= " and id='$FORM{$site_id}'"; }
						my $sth = &database_functions::mySQL($statement);
						if ($sth->rows > 0) { &database_functions::outbidded($FORM{$keyword}, $FORM{$bid}, $account, undef, undef, $FORM{process}); }
						$sth->finish;
					}
				}
			} else {
				if ($config{'data'} eq "mysql") {
					##is it in edit mode
					if (@new_data > 0) {
						##deny the edit and set the old site active again
						&database_functions::remove_status('edit_sites', $account);
						&database_functions::update_sites($FORM{$keyword}, 'approved', $account);
					} else { ##it is either new or add
						##delete the entry from sites and stats
						my $statement = "delete from sites where term='$FORM{$keyword}' and user='$user_id' and id='$FORM{$site_id}'";
						&database_functions::mySQL($statement);
						$statement = "delete from stats where user='$user_id' and term='$FORM{$keyword}'";
						&database_functions::mySQL($statement);
					}
				} else {
					foreach my $line(@sites) {
						chomp($line);
						my @inner = split(/\|/, $line);
						if ($inner[5] eq "edit" && $inner[0] eq "$FORM{$keyword}" && $inner[6] eq "$FORM{$site_id}") {
print FILE <<EOF;
$inner[7]|$inner[8]|$inner[9]|$inner[10]|$inner[11]
EOF
						}
					}
				}
			}
		}
		if ($FORM{'process'} eq "addition") {
			if ($config{'data'} eq "text") {
				foreach my $line(@sites) {
					chomp($line);
					my @inner = split(/\|/, $line);
					unless ($inner[5] eq "new" || $inner[5] eq "edit") {
						print FILE "$line\n";
					}
				}
			}
		}
		close (FILE);
	}
}
###############################################


###############################################
sub stats {
	my $account = $FORM{'member'};
	my ($user_id, $count, $temp_id);
	if ($config{'data'} eq "mysql") { $user_id = &database_functions::mySQLGetUserID($account); }
	for $count (1 .. $FORM{'count'}) {
		my $keyword = "keyword$count";
		my $appden = "appden$count";
		my $itexists = 0;
		if ($FORM{'process'} eq "addition") {
			if ($config{'data'} eq "mysql") {
				my $statement = "select id from stats where term='$FORM{$keyword}' and user='$user_id'";
				my $sth = &database_functions::mySQL($statement);
				$temp_id = $sth->fetchrow_array;
				if ($temp_id ne '') {
					$itexists = 1;
					last;
				}
			} else {
				my @stats = &database_functions::GetStats($account);
				open (FILE, ">>${path}data/stats/$account.txt");
				foreach my $line2(@stats) {
					chomp($line2);
					my @inner2 = split(/\|/, $line2);
					if ($inner2[0] eq $FORM{$keyword}) { $itexists = 1; last; }
				}
			}
		}
		unless ($itexists || $FORM{$appden} eq "Deny" || $FORM{$appden} eq "deny") {
			my $newdate = &main_functions::getdate;
			if ($config{'data'} eq "mysql") {
				my $statement = "";
				if($temp_id ne '') {
					$statement = "update stats set date='$newdate' where id='$temp_id'";
				} else {
					$statement = "insert into stats(user, term, date) values ('$user_id', '$FORM{$keyword}', '$newdate')";
				}
				&database_functions::mySQL($statement);
			} else {
				if (-e "${path}data/stats/$account.txt") {
					open (FILE, ">>${path}data/stats/$account.txt");
				} else {
					open (FILE, ">${path}data/stats/$account.txt");
				}
print FILE <<EOF;
$FORM{$keyword}|$newdate^0^0
EOF
				close (FILE);
			}
		}
	}
}
###############################################


###############################################
sub status {
	my ($oldstatus, $account) = @_;
	my $status;
	if ($oldstatus eq "processing") { $status = "processing"; }
	elsif ($oldstatus eq "active") { $status = "active"; }
	elsif ($oldstatus eq "inactive") {
		$status = "inactive";
		if ($config{'data'} eq "text") { &database_functions::remove_status('inactive', $account); }
	}
	unless ($status eq "active") {
		&database_functions::change_status('active', $account);
	}
}
###############################################


###############################################
sub search {
	my $account = $FORM{'member'};
	my $newdate = &main_functions::getdate;
	for my $count(1 .. $FORM{'count'}) {
		my $keyword = "keyword$count";
		my $title = "title$count";
		my $description = "description$count";
		my $url = "url$count";
		my $bid = "bid$count";
		my $site_id = "id$count";
		my $appden = "appden$count";
		unless ($FORM{$appden} eq "deny") {
			my ($alreadylisted);
			if (-e "${path}data/search/$FORM{$keyword}.txt") {
				if ($FORM{'process'} eq "addition") {
					open (FILE, "${path}data/search/$FORM{$keyword}.txt");
					my @search = <FILE>;
					close (FILE);
					open (FILE, ">${path}data/search/$FORM{$keyword}.txt");
					foreach my $list(@search) {
						chomp($list);
						my @inn = split(/\|/, $list);
						if ($FORM{$site_id}) {
							if ($inn[1] eq $account && $inn[6] == $FORM{$site_id}) { $alreadylisted = 1; }
							else { print FILE "$list\n"; }
						} else {
							if ($inn[1] eq $account) { $alreadylisted = 1; }
							else { print FILE "$list\n"; }
						}
					}
					close (FILE);
				}
				open (FILE, ">>${path}data/search/$FORM{$keyword}.txt");
			} else {
				open (FILE, ">${path}data/search/$FORM{$keyword}.txt");
			}
			print FILE "$FORM{$bid}|$account|$FORM{$title}|$FORM{$url}|$FORM{$description}|$newdate|$FORM{$site_id}\n";
			close (FILE);
			&database_functions::sortit($FORM{$keyword});
			&database_functions::outbidded($FORM{$keyword}, $FORM{$bid}, $account, $alreadylisted, undef, $FORM{process});
		}
	}
}
###############################################


###############################################
sub deny {
	my (@user) = @_;
	my $account = $FORM{'member'};
	if ($FORM{'process'} eq "new") {
		if ($config{'data'} eq "mysql") {
			&database_functions::delete_member($account);
		} else {
			unlink("${path}data/sites/$account.txt");
			unlink("${path}data/users/$account.txt");
			unlink("${path}data/stats/$account.txt");
			unlink("${path}data/balance/$account.txt");
		}
	} elsif ($FORM{'process'} eq "addition") {
		if ($config{'data'} eq "mysql") {
			my $user_id = &database_functions::mySQLGetUserID($account);
			my @sites = &database_functions::GetSites($account);
			foreach my $site(@sites) {
				chomp($site);
				my @inner = split(/\|/, $site);
				##check to see if this was an edit or an actual addition
				my $statement = "select original, bid, title, url, description, id from edit_sites where term='$inner[0]' and user='$user_id'";
				my $sth = &database_functions::mySQL($statement);
				my @new_data = $sth->fetchrow_array;
			
				for (my $i=0; $i < @new_data; $i++)	{
					$new_data[$i] = &database_functions::escape($new_data[$i]);
				}
				##is it in edit mode
				if (@new_data > 0) {
					##deny the edit and set the old site active again
					my $statement = "delete from edit_sites where id='$new_data[5]'";
					database_functions::mySQL($statement);
					$statement = "update sites set status='approved' where id='$new_data[0]'";
					database_functions::mySQL($statement);
				} else { ##it is either new or add
					##delete the entry from sites and stats
					my $statement = "delete from sites where term='$inner[0]' and user='$user_id'";
					&database_functions::mySQL($statement);
					$statement = "delete from stats where user='$user_id' and term='$inner[0]'";
					&database_functions::mySQL($statement);
				}
			}
		} else {
			&database_functions::remove_status('addition', $account);
			my @sites = &database_functions::GetSites($account);
			open (FILE, ">${path}data/sites/$account.txt");
			foreach my $site(@sites) {
				chomp($site);
				my @inner = split(/\|/, $site);
				if ($inner[5] eq "new") {
					unless ($inner[7] eq "") {
						print FILE "$inner[7]|$inner[8]|$inner[9]|$inner[10]|$inner[11]\n";
					}
				} else {
					print FILE "$site\n";
				}
			}
			close (FILE);
		}
	} else {
		if ($config{'data'} eq "mysql") {
			my $user_id = &database_functions::mySQLGetUserID($account);
			my $statement = "delete from balanceaddon where user='$user_id'";
			&database_functions::mySQL($statement);
		} else {
			&database_functions::remove_status('balanceaddon', $account);
		}
	}
	open (FILE, "${path}template/emaildenied.txt");
	my @emailmess = <FILE>;
	close (FILE);
	my $emailtemp;
	foreach my $emailtemp2(@emailmess) {
		chomp($emailtemp2);
		$emailtemp .= "$emailtemp2\n";
	}
	#my @user = &database_functions::GetUser($account);
	$emailtemp =~ s/\[name\]/$user[0]/ig;
	$emailtemp =~ s/\[company\]/$config{'company'}/ig;
	$emailtemp =~ s/\[url\]/$config{'websiteurl'}/ig;
	my $subject = "$config{'company'} - Order Denied";
	open (FILE, ">test.txt");
	print FILE "$config{'adminemail'}, $user[8], $account, @user";
	close (FILE);
	&main_functions::send_email($config{'adminemail'}, $user[8], $subject, $emailtemp);
	my $message = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Member Successfully Denied</font></B><BR>";
	&pending($message);
	&main_functions::exit;
}
###############################################


###############################################
#Auto-Update
sub update {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
do "${path}config/config.cgi";
my $user=$config{'user'};
my $Webversion=$config{'Webversion'};
my $version = "Webversion";
my $update = $Webversion;
my $result = &getpage($version);
my $p=0;
$version =~ s/version//;
chomp($result);
my $fil = $version;
my $res = $result;
print <<EOF;
<font face="verdana" size="-1"><B><U>Auto-Update</U></b><P>
<form METHOD="POST" ACTION="">
<table width=50% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3">
   
EOF
if ($result > $update) {
print <<EOF;
<tr>
<td WIDTH=\"40%\" bgcolor=\"#CCCCCC\"><font face=\"verdana\" size=\"-1\">$version.cgi</td>
<td WIDTH=\"60%\" bgcolor=\"#CCCCCC\"><B><font face=\"verdana\" size=\"-1\" color=\"red\">Update Available</B><input type=hidden name=$fil value=\"$res\"><BR></td></tr>
EOF
} else {
print <<EOF;
<tr>
<td WIDTH=\"40%\" bgcolor=\"#CCCCCC\"><font face=\"verdana\" size=\"-1\">$version.cgi</td>
<td WIDTH=\"60%\" bgcolor=\"#CCCCCC\"><B><font face=\"verdana\" size=\"-1\">Latest Version Installed</B><input type=hidden name=$fil value=\"$res\"><BR></td></tr>
EOF
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table>
<BR><input type=submit value="Update">
</form>
</font>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Get Updated Data
sub startupdate {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
do "${path}config/config.cgi";
my $res1;
if ($FORM{'Web'} ne "") {
	my $fil = "Web";
	$res1=$FORM{'Web'};
	chomp($res1);
	&updatefile($fil, $res1);
} else {
	$res1 = "$config{'Webversion'}";
	chomp($res1);
}


sub updatefile {
	my ($fil, $res1) = @_;
	my $regcode1 = $config{'regcode'};
	my @reg = split(/\-/,$regcode1);
	my $reg1=$reg[0];
	my $reg2=$reg[1];
	my $reg3=$reg[2];
	my $search = "";
	my ($response_body);
	if ($config{'searchmodule'} eq "LWP") {
		eval("use LWP::UserAgent"); if ($@) { die "The LWP::UserAgent module used to update search engines appears to not be installed"; }
		my $ua = LWP::UserAgent->new();
		my $request = HTTP::Request->new('GET', $search);
		my $response = $ua->request ($request);
		$response_body = $response->content();
	} else {
		eval("use IO::Socket"); if ($@) { die "The IO::Socket module used to update search engines appears to not be installed"; }
		my @requests;
		push (@requests, $search);
		my %entries = &main_functions::my_forker('30', @requests);
		foreach my $url (keys(%entries)) {
			$response_body = $entries{"$url"};
		}
	}
	undef %semod;
	local %semod = ();
	do "${path}template/Web.cgi";
	my $custom = $semod{'custom_engines'};
	chomp($custom);
	if ($response_body =~ /UPDATE ERROR: /) {
		print "Content-type: text/html\n\n";
		&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B>
$response_body
</b></font>
EOF
		&main_functions::footer;
		&main_functions::exit;
	} elsif ($custom) {
		my @custom = split(/\|/, $custom);
		open (FILE, "${path}template/Web.cgi");
		my @semodfile = <FILE>;
		close (FILE);
		my $semodfile;
		foreach my $se(@semodfile) {
			chomp($se);
			$semodfile .= "$se\n";
		}
		my @datasplit = split(/# CUSTOM ENGINES - DO NOT DELETE #\n/, $semodfile);
		open (FILE, ">${path}template/Web.cgi");
print FILE <<EOF;
$response_body
EOF
		close(FILE);
		undef %semod;
		local %semod = ();
		do "${path}template/Web.cgi";
		my $standard = $semod{'search_engines'};
		chomp($standard);
		my (@same_eng);
		foreach my $line(@custom) {
			chomp ($line);
			if ($line =~ /$standard/) {
				$standard =~ s/$line\|//;
				$standard =~ s/$line//;
				push(@same_eng, $line);
			}
		}
		my $all = "$custom|$standard";
		my @all = split(/\|/, $all);
		my $senumber;
		foreach (@all) { $senumber++; }
		my $t;
		open (FILE, "${path}template/Web.cgi");
		my @semod = <FILE>;
		close (FILE);
		my ($c, $noprint);
		open (FILE, ">${path}template/Web.cgi");
		foreach my $line(@semod) {
			chomp($line);
			if ($line eq "#Search Engines - Do Not Delete") {
				if ($t == 0) {
					print FILE "#Search Engines - Do Not Delete\n";
					print FILE "\$semod{'standard_engines'}=\"$standard\"\;\n";
					print FILE "\$semod{'custom_engines'}=\"$custom\"\;\n";
					print FILE "\$semod{'search_engines'}=\"$all\"\;\n";
					print FILE "\$semod{'senumber'}=\"$senumber\"\;\n";
					print FILE "#Search Engines - Do Not Delete\n";
				}
				$t++;
			} elsif ($line eq "# End - Do Not Delete") {
				my $counter;
				my $total = @datasplit-1;
				print FILE "# CUSTOM ENGINES - DO NOT DELETE #\n";
				my @data = split(/\n/, $datasplit[1]);
				foreach my $data(@data) {
					chomp($data);
					print FILE "$data\n";
				}
				print FILE "# CUSTOM ENGINES - DO NOT DELETE #\n";
				print FILE "# End - Do Not Delete\n";
			} elsif (@same_eng && $line eq "######################################") {
				if ($noprint == 1) {
					$noprint = 0;
				} else {
					my $eng_name = $semod[$c+1];
					chomp($eng_name);
					$eng_name =~ s/#//;
					foreach my $eng(@same_eng) {
						if ($eng eq "$eng_name") { $noprint = 1; }
					}
					unless ($noprint) { print FILE "$line\n"; }
				}
			} else {
				unless ($t == 1 || $noprint == 1) {
					print FILE "$line\n";
				}
			}
			$c++;
		}
		close(FILE);
	} else {
		open (FILE, ">${path}template/$fil.cgi");
print FILE <<EOF;
$response_body
EOF
		close(FILE);
	}
}	
do "${path}config/config.cgi";
my $ademail = $config{'adminemail'};
$ademail =~ s/@/\\@/;

if ($res1 =~ /UPDATE ERROR: /) { $res1 = $config{'Webversion'}; }
open (FILE, ">${path}config/config.cgi");
print FILE <<EOF;

\$config{'regcode'} = "$config{'regcode'}";
\$config{'user'} = "$config{'user'}";
\$config{'Webversion'} = "$res1";
\$config{'company'} = "$config{'company'}";
\$config{'websiteurl'} = "$config{'websiteurl'}";
\$config{'adminurl'} = "$config{'adminurl'}";
\$config{'secureurl'} = "$config{'secureurl'}";
\$config{'adminemail'} = "$ademail";
\$config{'sendmail'} = "$config{'sendmail'}";
\$config{'server'} = "$config{'server'}";
\$config{'data'} = "$config{'data'}";
\$config{'extension'} = "$config{'extension'}";
\$config{'searchmodule'} = "$config{'searchmodule'}";
\$config{'modperl'} = "$config{'modperl'}";
\$config{'database'} = "$config{'database'}";
\$config{'host'} = "$config{'host'}";
\$config{'username'} = "$config{'username'}";
\$config{'password'} = "$config{'password'}";
1;
EOF
close(FILE);

print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B>
File Successfully Updated
</b></font>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Check For Updates
sub getpage {
my $version = $_[0];
my $regcode1 = $config{'regcode'};

my @reg = split(/\-/,$regcode1);
my $reg1=$reg[0];
my $reg2=$reg[1];
my $reg3=$reg[2];
my $search = "";
my ($response_body);
if ($config{'searchmodule'} eq "LWP") {
	eval("use LWP::UserAgent"); if ($@) { die "The LWP::UserAgent module used to update search engines appears to not be installed"; }
	my $ua = LWP::UserAgent->new();
	my $request = HTTP::Request->new('GET', $search);
	my $response = $ua->request ($request);
	$response_body = $response->content();
} else {
	eval("use IO::Socket"); if ($@) { die "The IO::Socket module used to update search engines appears to not be installed"; }
	my @requests;
	push (@requests, $search);
	my %entries = &main_functions::my_forker('30', @requests);
	foreach my $url (keys(%entries)) {
		$response_body = $entries{"$url"};
	}
}
return ($response_body);
}
###############################################
