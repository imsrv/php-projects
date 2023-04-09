#!/usr/bin/perl
# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/affiliate/"; # With a slash at the end as shown
$path = "";

# Code added by TNO - Naughty people at Done-Right thought they would spy on you by
# calling images from their server, tut tut! These images come with this warez release
# so please specify the full url where you will upload these images to on your server.
# Example:
# $tno = "http://www.yourdomain.com/images"; # Do not add a trailing slash
$tno = "";

#### Nothing else needs to be edited ####

# Affiliate Program by Done-Right Scripts
# Admin Script
# Version 1.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright й 2000 Done-Right. All rights reserved.


###############################################
#Read Input
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
		$FORM{$name} = $value;
	}
}
###############################################


###############################################
if ($FORM{'tab'} eq "login") { &login; }
elsif ($FORM{'tab'} eq "config") { &config; }
elsif ($FORM{'tab'} eq "setconfig") { &setconfig; }
elsif ($FORM{'tab'} eq "statistics") { &statistics; }
else { &main; }
###############################################


###############################################
#Security Check
sub checklogin {
require "${path}config/config.cgi";

$current_time = time();
$ip = $ENV{'REMOTE_ADDR'};

if ($FORM{'formlog'} eq "Login") {
	&expiredsession;
	if ($FORM{'user'} eq $config{'user'}) {
		if (-e "${path}config/session.txt") { open (FILE, ">>${path}config/session.txt"); }
		else { open (FILE, ">${path}config/session.txt"); }
		print FILE "$ip|$current_time";
		close (FILE);
		$verified=1;
		$p = $FORM{'user'};
		$encryptkey = "draffiliate";
		$p = &Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
		$FORM{'user'} = $p;
	}
} else {
	$p = $FORM{'user'};
	$encryptkey = "draffiliate";
	$p = &Decrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
	if ($p eq $config{'user'}) {
		open (FILE, "${path}config/session.txt");
		@session = <FILE>;
		close (FILE);
		$ff=0;
		foreach $line(@session) {
			chomp($line);
			@inner = split(/\|/, $line);
			if ($inner[0] eq $ip) {
				$elapsed = $current_time - $inner[1];
				if ($elapsed > 3600) {
					$logmessage = "Session Expired, Please <a href=admin.cgi>click here</a> to re-login";
					&expiredsession;
					last;
				} else {
					$verified=1;
					open (FILE, "${path}config/session.txt");
					@session = <FILE>;
					close (FILE);
					open (FILE, ">${path}config/session.txt");
					$ss=0;
					foreach $line(@session) {
						chomp($line);
						if ($ff == $ss) {
							@inner = split(/\|/, $line);
							print FILE "$inner[0]|$current_time\n";
						} else { print FILE "$line\n"; }
						$ss++;
					}
					close (FILE);
					$encryptkey = "draffiliate";
					$p = &Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
					$FORM{'user'} = $p;
					last;
				}
			}
			$ff++;
		}
	}
}

unless ($verified) {
	print "Content-type: text/html\n\n";
	$nolink=1;
	&header;
	if ($logmessage) { print $logmessage; }
	else { print "Access Denied. Please <a href=admin.cgi>click here</a> to login"; }
	&footer;
	exit;
}

sub expiredsession {
	open (FILE, "${path}config/session.txt");
	@session = <FILE>;
	close (FILE);
	open (FILE, ">${path}config/session.txt");
	foreach $line(@session) {
		chomp($line);
		@inner = split(/\|/, $line);
		$elapsed = $current_time - $inner[1];
		unless ($elapsed > 3600) {
			print FILE "$line\n";
		}
	}
	close (FILE);
}
}
###############################################


###############################################
#Main
sub main {
$nolink=1;
if (-e "${path}config/config.cgi") {
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B>Please enter your Registration Code that you received in your email:</B><P>
<form METHOD="POST" ACTION="admin.cgi?tab=login">
Registration Code:&nbsp;<input type="text" name="user" size="45"><BR>
<input type="submit" name="formlog" value="Login">
</form>
</font>
EOF
&footer;
exit;
} else {
$created=1;
&config;
}
}
###############################################


###############################################
#Login Area
sub login {
&checklogin;
print "Content-type: text/html\n\n";
$nolink=1;
&header;

opendir(FILE,"${path}users");
@members = grep { /.txt/ } readdir(FILE);
closedir (FILE);

$currentmem=0;
foreach(@members) {
	unless ($_ eq ".txt") { $currentmem++; }
}

print <<EOF;
<font face="verdana" size="-1"><B><U>MAIN</U></B></font><P>
<font face="verdana" size="-1">Welcome to your personal admin section for your script.  The admin section lets you easily take control over your script.  Please choose from a link below to begin:<P>
<center>
<font face="verdana" size="-1" color="#000099"><B>Currently $currentmem members</B></font><BR>
<font face="verdana" size="-1"><B><a href="signup.cgi" target="new">Signup</a> | <a href="members.cgi" target="new">Members Area</a></B></font>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.cgi?tab=config&user=$FORM{'user'}&file=affiliateprogram">Configure Variables</a></td>
<td width="65%"><font face="verdana" size="-1">Set admin password among other variables to run the script.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><strike>Download</strike></td>
<td width="65%"><font face="verdana" size="-1">Download the scripts zip file.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><strike>Support</strike></td>
<td width="65%"><font face="verdana" size="-1">Obtain support for your scripts via your usermanual, email or FAQ.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><strike>Feedback</strike></td>
<td width="65%"><font face="verdana" size="-1">Send us testimonials about this script and we will put a link to your site on done-right.net</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><strike>Order Addons</strike></td>
<td width="65%"><font face="verdana" size="-1">Purchase related scripts to compliment this one.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
<center><font face="verdana" size="-1"><B>Other Options</B></font>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=affiliateprogram">Customize Templates</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the look of your search enigne by editting the html code & customizing email messages.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.cgi?tab=email&user=$FORM{'user'}&file=affiliateprogram">Email Members</a></td>
<td width="65%"><font face="verdana" size="-1">Email all, processing, active or inactive members all at once.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="view.cgi?user=$FORM{'user'}&file=affiliateprogram">View Members</a></td>
<td width="65%"><font face="verdana" size="-1">View details about your processing, active and inactive members.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.cgi?tab=statistics&user=$FORM{'user'}&file=affiliateprogram">Statistics</a></td>
<td width="65%"><font face="verdana" size="-1">View various statistics about your search engine.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&footer;
}
###############################################


###############################################
#Statistics
sub statistics {
&checklogin;
use DB_File;
opendir(FILE,"${path}users");
@members = grep { /.txt/ } readdir(FILE);
closedir (FILE);

$currentmem=0;
foreach(@members) {
	unless ($_ eq ".txt") { $currentmem++; }
}

opendir(FILE,"${path}stats");
@stats = grep { /.db/ } readdir(FILE);
closedir (FILE);

$inactive=0;
$mon = (localtime)[4]+1;
foreach $line(@stats) {
	chomp($line);
	unless ($line eq ".db") {
		$DBNAME = "${path}stats/$line";
		tie(%click_hash, "DB_File", $DBNAME, O_RDONLY) or die ("Cannot open database $DBNAME: $!");
		if (exists $click_hash{'lastrun'}) { $timeperiod = $mon-$click_hash{'lastrun'}; }
		else { $timeperiod = 0; }
		if ($timeperiod >= 2) { $inactive++; }
		foreach $key (keys %click_hash) {
			if ($key =~ /STAT/ || $key =~ /MON/) {
				if ($config{'pay'} == 3) {
					@sp = split(/\|/, $click_hash{$key});
					$amount += $config{'amount'}*$sp[1];
					$clickthroughs += $sp[0];
				} else {
					$amount += $click_hash{$key}*$config{'amount'};
					$clickthroughs += $click_hash{$key};
				}
			} elsif ($key =~ /PAID/) {
				$amount += $click_hash{$key};
				$paid += $click_hash{$key};
			}
		}		
		untie %click_hash;
	}
}
$active = $currentmem-$inactive;
$owing = $amount-$owing;

$owing = sprintf("%.2f", $owing);
$paid = sprintf("%.2f", $paid);
$amount = sprintf("%.2f", $amount);
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Statistics</U></B></font><P>
<center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="65%" valign=top><font face="verdana" size="-1">Total Amount of Members<BR>
<font color="#000099">Active:</font><BR>
<font color="red">Inactive:</font></td>
<td width="35%"><font face="verdana" size="-1">$currentmem<BR>
$active<BR>
$inactive<BR></font></font></td>
</tr>
<tr>
<td width="65%" valign=top><font face="verdana" size="-1">Total Amount Generated<BR>
<font color="#000099">Amount Paid:</font><BR>
<font color="red">Amount Owing:</font></td>
<td width="35%"><font face="verdana" size="-1">\$$amount<BR>
\$$paid<BR>
\$$owing<BR></font></td>
</tr>
<tr>
<td width="65%" valign=top><font face="verdana" size="-1">Total Click-Throughs/Searches Generated</td>
<td width="35%"><font face="verdana" size="-1">$clickthroughs</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table>
<BR><BR>
</font></B></center>
EOF
&footer;
}
###############################################


###############################################
#Variable Configuration
sub config {
if ($created == 1) { $verified = 1; }
else { &checklogin; }

print "Content-type: text/html\n\n";
&header;
$unix = "CHECKED";
unless ($created == 1) {
	require "${path}config/config.cgi";
	$user=$config{'user'};
	$company=$config{'company'};
	$websiteurl=$config{'websiteurl'};
	$bidsearchurl=$config{'bidsearchurl'};
	$adminemail=$config{'adminemail'};
	$mailer=$config{'sendmail'};
	$amount=$config{'amount'};
	$sendchecks=$config{'sendchecks'};
	if ($config{'server'} eq "nt") { $nt = "CHECKED"; }
	else { $unix = "CHECKED"; }
	if ($config{'pay'} == 1) { $one = "CHECKED"; }
	elsif ($config{'pay'} == 2) { $two = "CHECKED"; }
	elsif ($config{'pay'} == 3) { $three = "CHECKED"; $amount = $amount * 100; }
} else {
	$websiteurl = "http://$ENV{'HTTP_HOST'}/";
	$bidsearchurl = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
	$bidsearchurl =~ s/affiliate\/admin\.cgi$/search.cgi/i;
	$two = "CHECKED";
}

@sendmail = ('/bin/sendmail', '/usr/sbin/sendmail', '/usr/lib/sendmail');
for $sendmail(@sendmail) {
	$sendtemp = $sendmail;
	if (-e $sendmail) {
		$sendfound = 1;
		last;
	}
}
unless ($sendfound) { $sendtemp = "/bin/sendmail"; }
$smtptemp = "$ENV{'HTTP_HOST'}";
$smtptemp =~ s/www\.//;

print <<EOF;
<font face="verdana" size="-1"><B><U>Variable Configuration</U></b><P>
EOF
if ($created == 1) {
print <<EOF;
<font face="verdana" size="-1">If you are having trouble installing the script, the staff at Done-Right Scripts can do it for you.
<BR><BR><B>This version was supplied by Scoons and Nullified by TNO</B>.
EOF
}
print <<EOF;
<form METHOD="POST" ACTION="admin.cgi?tab=setconfig&user=$FORM{'user'}">
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
<td width=40%><input type=text name=user2 size=45 value="$user"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Name of Company:&nbsp;</td>
<td width=40%><input type=text name=company size=45 value="$company"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Web Site URL:&nbsp;</td>
<td width=40%><input type=text name=websiteurl size=45 value="$websiteurl"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">URL To BidSearch file search.cgi:&nbsp;</td>
<td width=40%><input type=text name=bidsearchurl size=45 value="$bidsearchurl"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Admin email:&nbsp;</td>
<td width=40%><input type=text name=adminemail size=45 value="$adminemail"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Location of severs sendmail (unix) or smtp (nt):&nbsp;<BR><font size="-2">(unix ex. $sendtemp or nt ex. $smtptemp)</font></td>
<td width=40% valign=top><input type=text name=mailer size=45 value="$mailer"></td></tr>
<tr>
<td width=60% valign=top><font face="verdana" size="-1">Pay Affiliate:<BR><font color="#000099"><B>NOTE:</b> Once you select a method and start getting affiliate members, you cannot change your payment method.</font></td>
<td width=40%><font face="verdana" size="-1"><INPUT TYPE="radio" NAME="pay" VALUE="1" $one> Per Search <font size="-2">(everytime a unique search is performed)</font><BR>
<font face="verdana" size="-1"><INPUT TYPE="radio" NAME="pay" VALUE="2" $two> Per Click <font size="-2">(everytime a listing is clicked)</font><BR>
<font face="verdana" size="-1"><INPUT TYPE="radio" NAME="pay" VALUE="3" $three> Percentage of Bid on Click <font size="-2">(everytime a listing is clicked, member receives commission of bid)</font>
</td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Amount:&nbsp;<BR><font size="-2">(Enter a percentage if paying affiliate by commission, otherwise enter value in cents)</font></td>
<td width=40% valign=top><font face="verdana" size="-1"><input type=text name=amount size=10 value="$amount"> (Ex. \$0.05 or 10%)</td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Send out checks when amount owing is equal to or greater than:&nbsp;<BR></td>
<td width=40% valign=top><font face="verdana" size="-1">\$<input type=text name=sendchecks size=10 value="$sendchecks"> (Ex. \$50)</td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Server Type:&nbsp;</td>
<td width=40%><font face="verdana" size="-1">Unix:<INPUT TYPE="radio" NAME="server" VALUE="unix" $unix>&nbsp;&nbsp;NT:<INPUT TYPE="radio" NAME="server" VALUE="nt" $nt></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR>
<input type=submit value="Set Configuration">
</form><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
#Write to config.cgi
sub setconfig {
if ($FORM{'created'} == 1) {
$nolink = 1;
#Create and chmod directories and files
unless (-e "${path}config") { mkdir("${path}config", 0777) || ($error .= "Create Directory: config<BR>"); }
unless (-e "${path}users") { mkdir("${path}users", 0777) || ($error .= "Create Directory: users<BR>"); }
unless (-e "${path}stats") { mkdir("${path}stats", 0777) || ($error .= "Create Directory: stats<BR>"); }
	
unless ($error) {
unless ($FORM{'server'} eq "nt") {
	chmod (0777,"config") || ($error .= "Chmod Directory 777: config<BR>");
	chmod (0777,"template") || ($error .= "Chmod Directory 777: template<BR>");
	chmod (0777,"users") || ($error .= "Chmod Directory 777: users<BR>");
	chmod (0777,"stats") || ($error .= "Chmod Directory 777: stats<BR>");
}

open (FILE, ">${path}config/config.cgi");
close(FILE);
open (FILE, ">${path}config/session.txt");
close(FILE);

unless ($FORM{'server'} eq "nt") {
	chmod (0755,"signup.cgi") || ($error .= "Chmod File 755: signup.cgi<BR>");
	chmod (0755,"customize.cgi") || ($error .= "Chmod File 755: customize.cgi<BR>");
	chmod (0755,"members.cgi") || ($error .= "Chmod File 755: members.cgi<BR>");
	chmod (0755,"view.cgi") || ($error .= "Chmod File 755: view.cgi<BR>");
	chmod (0755,"click.cgi") || ($error .= "Chmod File 755: click.cgi<BR>");
	chmod (0777,"config/config.cgi") || ($error .= "Chmod File 777: config/config.cgi<BR>");
	chmod (0777,"config/session.txt") || ($error .= "Chmod File 777: config/session.txt<BR>");
	chmod (0777,"template/emailsignup.txt") || ($error .= "Chmod File 777: template/emailsignup.txt<BR>");
	chmod (0777,"template/emailinvoice.txt") || ($error .= "Chmod File 777: template/emailinvoice.txt<BR>");
	chmod (0777,"template/forgot.txt") || ($error .= "Chmod File 777: template/forgot.txt<BR>");
	chmod (0777,"template/login.txt") || ($error .= "Chmod File 777: template/login.txt<BR>");
	chmod (0777,"template/searchcode.txt") || ($error .= "Chmod File 777: template/searchcode.txt<BR>");
	chmod (0777,"template/members.txt") || ($error .= "Chmod File 777: template/members.txt<BR>");
	chmod (0777,"template/message.txt") || ($error .= "Chmod File 777: template/message.txt<BR>");
	chmod (0777,"template/profile.txt") || ($error .= "Chmod File 777: template/profile.txt<BR>");
	chmod (0777,"template/signup.txt") || ($error .= "Chmod File 777: template/signup.txt<BR>");
	chmod (0777,"template/statistics.txt") || ($error .= "Chmod File 777: template/statistics.txt<BR>");
	chmod (0777,"template/complete.txt") || ($error .= "Chmod File 777: template/complete.txt<BR>");
}

$verified=1;

}
} else {
&checklogin;
}


$ademail = $FORM{'adminemail'};
unless ($ademail =~ /\\@/) {
	$ademail =~ s/@/\\@/;
}
$FORM{'amount'} =~ s/\$//;
$FORM{'amount'} =~ s/\%//;
$FORM{'sendchecks'} =~ s/\$//;
if ($FORM{'pay'} == 3) { $FORM{'amount'} = $FORM{'amount'} / 100; }
open(FILE, ">${path}config/config.cgi");
print FILE <<EOF;

\$config{'user'} = "$FORM{'user2'}";
\$config{'company'} = "$FORM{'company'}";
\$config{'websiteurl'} = "$FORM{'websiteurl'}";
\$config{'bidsearchurl'} = "$FORM{'bidsearchurl'}";
\$config{'pay'} = "$FORM{'pay'}";
\$config{'amount'} = "$FORM{'amount'}";
\$config{'sendchecks'} = "$FORM{'sendchecks'}";
\$config{'adminemail'} = "$ademail";
\$config{'sendmail'} = "$FORM{'mailer'}";
\$config{'server'} = "$FORM{'server'}";
EOF
close (FILE);

print "Content-type: text/html\n\n";
$nolink=1;
&header;
if ($error) {
print <<EOF;
<font face="verdana" size="-1"><B>Error in installation.  Please do the following and run admin.cgi again.<BR>
For more help with this issue, please consult the Troubleshooting Guide.</B><P>
<font face="verdana" size="-1">$error
EOF
} else {
print <<EOF;
<font face="verdana" size="-1"><B>Variables successfully configured.  Please Re-Login:</B><P>
<form METHOD="POST" ACTION="admin.cgi?tab=login">
Registration Code:&nbsp;<input type=text name=user size=45 value="$FORM{'user2'}"><BR>
<input type=submit value="Login" name="formlog">
</form>
</font>
EOF
}
&footer;
exit;
}
###############################################


###############################################
#Header HTML
sub header {
print <<EOF;
<html>
 <head>
 
 <title>Admin Area</title>
 <style>
 <!--
 BODY      {font-family:verdana;}
 A:link    {text-decoration: underline;  color: #000099}
 A:visited {text-decoration: underline;  color: #000099}
 A:hover   {text-decoration: none;  color: #000099}
 A:active  {text-decoration: underline;  color: #000099}
 -->
 </style> 
 <body text="#000000" bgcolor="#333333" link="#000099" vlink="#000099" alink="#000099">
 
 <!-- start top table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td width="1"><img SRC="$tno/place.gif" height=1 width=5></td>
 
 <td><img SRC="$tno/place.gif" height=5 width=1></td>
 
 <td width="1"><img SRC="$tno/place.gif" height=1 width=5></td> </tr>
 
 <tr>
 <td width="10%"><img SRC="$tno/place.gif" height=1 width=5></td>
 
 <td>
 
 <!-- start logo table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=2 WIDTH="100%" BGCOLOR="#000066" >
 <tr>
 <td width="15%">
<img src="$tno/smalllogo.gif" ALT="Done-Right Scripts" WIDTH="130" HEIGHT="83">
</td>
 <td valign=bottom><center><img src="$tno/adminarea.gif" width=351 height=60></center>
 </td>
 <td width="15%">
<img src="$tno/smalllogo.gif" ALT="Done-Right Scripts" ALIGN="RIGHT" WIDTH="130" HEIGHT="83">
</td>
 </tr>
 </center></table>
 <!-- end logo table -->
 
 <!-- start border table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td><img SRC="$tno/place.gif" height=5 width=1></td>
 </tr>
 </center></table>
 <!-- end border table -->

 <!-- start home and date table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <tr><td>
EOF
$url = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
unless ($nolink == 1) {
print <<EOF;
<center><font face="verdana" size="-1"><B><a href="admin.cgi?tab=login&user=$FORM{'user'}&file=affiliateprogram">Main</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=config&user=$FORM{'user'}&file=affiliateprogram">Configure Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<strike>Download</strike>&nbsp;&nbsp;|&nbsp;&nbsp;
<strike>Support</strike>&nbsp;&nbsp;|&nbsp;&nbsp;
<strike>Feedback</strike></font></b>
<BR><font face="verdana" size="-1"><B><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">Customize</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="view.cgi?user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">View Members</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="view.cgi?tab=email&user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">Email</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=statistics&user=$FORM{'user'}&file=affiliateprogram"><font color="#FFFFFF">Statistics</font></a></center></font></b>
EOF
} else {
	print "&nbsp;";
}
print <<EOF;
 </td>
 </TR>
 </TABLE></CENTER>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="$tno/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=4 COLS=1 WIDTH="100%" BGCOLOR="#FFFFFF" >
 <TR>
 <TD>
<P><BR><center>

EOF
}
###############################################


###############################################
#Footer HTML
sub footer {
print <<EOF;

 </td></tr></table>
 <TD><IMG SRC="$tno/place.gif" height=1 width=5></TD>
 </TR>
 
 <TR>
 <TD><IMG SRC="$tno/place.gif" height=1 width=5></TD>
 
 <TD>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 ADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="$tno/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <TR><TD>
 <CENTER>&nbsp;</CENTER>
 </TD>
 <TD align="center"><FONT color="#000066" FACE=verdana size="-1">www.done-right.net
 </TD>
 </TR>
 </TABLE></CENTER>
 
 <IMG SRC="$tno/place.gif" height=5 width=1></TD>
 
 <TD><IMG SRC="$tno/place.gif" height=1 width=5></TD>
 </TR>
 
 </TABLE></CENTER>
  
 </BODY>
 </HTML>
</body></html>
EOF
}
###############################################


###############################################
sub Encrypt {
	#($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
	#$encryptkey = "$encryptkey$dayofyear";
    my ($source,$key,$pub_key) = @_;
    my ($cr,$index,$char,$key_char,$enc_string,$encode,$first,
        $second,$let1,$let2,$encrypted,$escapes) = '';
    $source = &rot13($source); 
    $cr = '╖иа'; 
    $source =~ s/[\n\f]//g; 
    $source =~ s/[\r]/$cr/g; 
    while ( length($key) < length($source) ) { $key .= $key } 
    $key=substr($key,0,length($source)); 
    while ($index < length($source)) { 
        $char = substr($source,$index,1);
        $key_char = substr($key,$index,1);
        $enc_string .= chr(ord($char) ^ ord($key_char));
        $index++;
    }
    for (0..255) { $escapes{chr($_)} = sprintf("%2x", $_); } 
    $index=0;
    while ($index < length($enc_string)) { 
        $char = substr($enc_string,$index,1);
        $encode = $escapes{$char};
        $first = substr($encode,0,1);
        $second = substr($encode,1,1);
        $let1=substr($pub_key, hex($first),1);
        $let2=substr($pub_key, hex($second),1);
        $encrypted .= "$let1$let2";
        $index++;
    }
    return $encrypted;
}
###############################################


###############################################
sub Decrypt {
	#($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
	#$encryptkey = "$encryptkey$dayofyear";
    my ($encrypted, $key, $pub_key) = @_;
    $encrypted =~ s/[\n\r\t\f]//eg; 
    my ($cr,$index,$decode,$decode2,$char,$key_char,$dec_string,$decrypted) = '';
    while ( length($key) < length($encrypted) ) { $key .= $key }
    $key=substr($key,0,length($encrypted)); 
    while ($index < length($encrypted)) {
        $decode = sprintf("%1x", index($pub_key, substr($encrypted,$index,1)));
        $index++;
        $decode2 = sprintf("%1x", index($pub_key, substr($encrypted,$index,1)));
        $index++;
        $dec_string .= chr(hex("$decode$decode2")); 
    }
    $index=0;
    while( $index < length($dec_string) ) { 
        $char = substr($dec_string,$index,1);
        $key_char = substr($key,$index,1);
        $decrypted .= chr(ord($char) ^ ord($key_char));
        $index++;
    }
    $cr = '╖иа'; 
    $decrypted =~ s/$cr/\r/g;
    return &rot13( $decrypted ); 
}
###############################################


###############################################
sub rot13{ 
    my $source = shift (@_);
    $source =~ tr /[a-m][n-z]/[n-z][a-m]/; 
    $source =~ tr /[A-M][N-Z]/[N-Z][A-M]/;
    $source = reverse($source);
    return $source;
}
###############################################
