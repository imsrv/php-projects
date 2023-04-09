#!/usr/bin/perl

#*********************************************************#
#   Program Name    	: Site Submitter
#   Program Version 	: 2.1
#   Program Author  	: Done Right
#   Home Page       	: http://www.done-right.net/
#   Retail Price    	: $74.99 United States Dollars
#	xCGI Price			: $00.00 United States Dollars
#   Nullified By    	: cHARLIeZ
#*********************************************************#


# If you are running on a NT server please fill in the $path variable below
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/sitesubmitter/"; # With a slash at the end as shown
$path = "";

#### Nothing else needs to be edited ####


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
elsif ($FORM{'tab'} eq "update") { &update; }
elsif ($FORM{'tab'} eq "startupdate") { &startupdate; }
elsif ($FORM{'tab'} eq "setconfig") { &setconfig; }
else { &main; }
###############################################


###############################################
#Security Check
sub checklogin {
require "${path}config/config.cgi";
$images = $config{'image'};

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
		$encryptkey = "drsitesubmitter";
		$p = &Encrypt($p,$encryptkey,'asdfhzxcvnmpoiyk');
		$FORM{'user'} = $p;
	}
} else {
	$p = $FORM{'user'};
	$encryptkey = "drsitesubmitter";
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
					$encryptkey = "drsitesubmitter";
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
if (-e "${path}config/config.cgi") {
print "Content-type: text/html\n\n";
$nolink=1;
&header;
print <<EOF;
<font face="verdana" size="-1"><B>Please enter your Registration Code that you received in your email:</B><P>
<form METHOD="POST" ACTION="admin.cgi?tab=login">
Registration Code:&nbsp;<input type=text name=user size=45><BR>
<input type=submit value="Login" name="formlog">
</form>
</font>
EOF
&footer;
exit;
} else {
$nolink=1;
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
open (FILE, "${path}template/emaillog.txt");
@email = <FILE>;
close (FILE);
$members = $#email;
$members++;
require "${path}template/semod.cgi";
@all = split(/\|/, $semod{'all_engines'});
$engines = $#all;
$engines++;
print <<EOF;
<font face="verdana" size="-1"><B><U>MAIN</U></B></font><P>
<font face="verdana" size="-1">Welcome to your personal admin section for your script.  The admin section lets you easily take control over your script.  Please choose from a link below to begin:<P>
<center>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td><font face="verdana" size="-1"><B>Amount of members:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$members</font></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Amount of Search Engines to Submit to:&nbsp;&nbsp;</B></td>
<td><font face="verdana" size="-1" color="#000099">$engines</font></td>
</tr>
</table><P>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="admin.cgi?tab=config&user=$FORM{'user'}&file=sitesubmitter">Configure Variables</a></td>
<td width="65%"><font face="verdana" size="-1">Set admin password among other variables to run the script.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1">Update</td>
<td width="65%"><font face="verdana" size="-1">Receive automatic installation of updated files with just a click of a button.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1">Download</td>
<td width="65%"><font face="verdana" size="-1">Download the scripts zip file.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1">Support</td>
<td width="65%"><font face="verdana" size="-1">Obtain support for your scripts via your usermanual, email or FAQ.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1">Feedback</td>
<td width="65%"><font face="verdana" size="-1">Send us testimonials about this script and we will put a link to your site on done-right.net</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1">Order Addons</td>
<td width="65%"><font face="verdana" size="-1">Purchase addons for your site submitter such as extra engines.</font></td>
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
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=sitesubmitter">Customize Templates</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the look of your site submitter by editting the html code & customizing an email message.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="email.cgi?user=$FORM{'user'}&file=sitesubmitter">Members</a></td>
<td width="65%"><font face="verdana" size="-1">Email members, view members, delete members and block email addresses.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="engines.cgi?user=$FORM{'user'}&file=sitesubmitter">Manage Search Engines</a></td>
<td width="65%"><font face="verdana" size="-1">Add, Edit or Delete search engines to submit to.</font></td>
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

if ($created == 1) {
	$verified = 1;	
} else {
	&checklogin;
}
print "Content-type: text/html\n\n";
&header;
$unix = "CHECKED";
unless ($created == 1) {
	require "${path}config/config.cgi";
	$user=$config{'user'};
	$semodversion=$config{'semodversion'};
	$image=$config{'image'};
	$adminemail=$config{'adminemail'};
	$mailer=$config{'mailer'};
	if ($config{'server'} eq "nt") { $nt = "CHECKED"; }
	else { $unix = "CHECKED"; }
} else {
	$image = "http://$ENV{'HTTP_HOST'}/images";
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
<form METHOD="POST" ACTION="admin.cgi?tab=setconfig&user=$FORM{'user'}">
<input type=hidden name=created value="$created">
<input type=hidden name=semodversion value="$semodversion">

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
<td width=60%><font face="verdana" size="-1">Location of images folder (without / at end):&nbsp;</td>
<td width=40%><input type=text name=image size=45 value="$image"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Admin email:&nbsp;</td>
<td width=40%><input type=text name=adminemail size=45 value="$adminemail"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Location of servers sendmail (unix) or smtp (nt):&nbsp;<BR><font size="-2">(unix ex. $sendtemp or nt ex. $smtptemp)</font></td>
<td width=40% valign=top><input type=text name=mailer size=45 value="$mailer"></td></tr>
<tr>
<td width=60%><font face="verdana" size="-1">Server Type:&nbsp;</td>
<td width=40%><font face="verdana" size="-1">Unix:<INPUT TYPE="radio" NAME="server" VALUE="unix" $unix>&nbsp;&nbsp;NT:<INPUT TYPE="radio" NAME="server" VALUE="nt" $nt></td></tr>
</table>
</td></tr></table>
</td></tr></table><BR>
<input type=submit value="Set Configuration">
</form><BR>
<center><B>Other Configurations</B><BR>
<font face="verdana" size="-1">
<a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=sitesubmitter">Customize Templates</a>
<P></font>
EOF
&footer;
exit;
}
###############################################


###############################################
#Write to config.cgi
sub setconfig {
if ($FORM{'created'} == 1) {
#Create and chmod directories and files
mkdir("${path}config", 0777) || ($error .= "Create Directory: config<BR>");

unless ($error) {
unless ($FORM{'server'} eq "nt") {
chmod (0777,"config") || ($error .= "Chmod Directory 777: config<BR>");
chmod (0777,"template") || ($error .= "Chmod Directory 777: template<BR>");
}

open (FILE, ">${path}config/config.cgi");
close(FILE);
open (FILE, ">${path}template/emaillog.txt");
close(FILE);
open (FILE, ">${path}template/emailblock.txt");
close(FILE);
open (FILE, ">${path}config/session.txt");
close(FILE);
open (FILE, ">${path}template/email.txt");
print FILE <<EOF;
Thank you for using Our Search Engine Submission Program.

The Following URL was submitted to the top 25 search engines:
[url]
EOF
close(FILE);

unless ($FORM{'server'} eq "nt") {
chmod (0755,"sitesubmitter.cgi") || ($error .= "Chmod File 755: sitesubmitter.cgi<BR>");
chmod (0755,"customize.cgi") || ($error .= "Chmod File 755: customize.cgi<BR>");
chmod (0755,"engines.cgi") || ($error .= "Chmod File 755: engines.cgi<BR>");
chmod (0755,"email.cgi") || ($error .= "Chmod File 755: email.cgi<BR>");
chmod (0777,"config/config.cgi") || ($error .= "Chmod File 777: config/config.cgi<BR>");
chmod (0777,"config/session.txt") || ($error .= "Chmod File 777: config/session.txt<BR>");
chmod (0777,"template/semod.cgi") || ($error .= "Chmod File 777: template/semod.cgi<BR>");
chmod (0777,"template/start.txt") || ($error .= "Chmod File 777: template/start.txt<BR>");
chmod (0777,"template/submit.txt") || ($error .= "Chmod File 777: template/submit.txt<BR>");
chmod (0777,"template/email.txt") || ($error .= "Chmod File 777: template/email.txt<BR>");
chmod (0777,"template/emaillog.txt") || ($error .= "Chmod File 777: template/emaillog.txt<BR>");
chmod (0777,"template/emailblock.txt") || ($error .= "Chmod File 777: template/emailblock.txt<BR>");
}


$FORM{'semodversion'} = "1.7";
$verified=1;

}
} else {
&checklogin;
}

$ademail = $FORM{'adminemail'};
unless ($ademail =~ /\\@/) {
	$ademail =~ s/@/\\@/;
}

open(FILE, ">${path}config/config.cgi");
print FILE <<EOF;

\$config{'user'} = "$FORM{'user2'}";
\$config{'semodversion'} = "$FORM{'semodversion'}";
\$config{'image'} = "$FORM{'image'}";
\$config{'adminemail'} = "$ademail";
\$config{'mailer'} = "$FORM{'mailer'}";
\$config{'server'} = "$FORM{'server'}";
EOF
close (FILE);

print "Content-type: text/html\n\n";
$nolink=1;
&header;
if ($error) {
print <<EOF;
<font face="verdana" size="-1"><B>Error in installation.  Please do the following and run admin.cgi again:</B><P>
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
 <td width="1"><img SRC="$images/place.gif" height=1 width=5></td>
 
 <td><img SRC="$images/place.gif" height=5 width=1></td>
 
 <td width="1"><img SRC="$images/place.gif" height=1 width=5></td> </tr>
 
 <tr>
 <td width="10%"><img SRC="$images/place.gif" height=1 width=5></td>
 
 <td>
 
 <!-- start logo table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=2 WIDTH="100%" BGCOLOR="#000066" >
 <tr>
 <td width="15%">
<img src="$images/smalllogo.gif" ALT="" WIDTH="130" HEIGHT="83">
</td>
 <td valign=bottom><center><img src="$images/adminarea.gif" width=351 height=60></center>
 </td>
 <td width="15%">
<img src="$images/smalllogo.gif" ALT="" ALIGN="RIGHT" WIDTH="130" HEIGHT="83">
</td>
 </tr>
 </center></table>
 <!-- end logo table -->
 
 <!-- start border table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <tr>
 <td><img SRC="$images/place.gif" height=5 width=1></td>
 </tr>
 </center></table>
 <!-- end border table -->

 <!-- start home and date table -->
 <center><table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <tr><td>
EOF
unless ($nolink == 1) {
print <<EOF;
<center><font face="verdana" size="-1"><B><a href="admin.cgi?tab=login&user=$FORM{'user'}&file=sitesubmitter">Main</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=config&user=$FORM{'user'}&file=sitesubmitter">Configure Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
Update&nbsp;&nbsp;|&nbsp;&nbsp;
Download&nbsp;&nbsp;|&nbsp;&nbsp;
Support&nbsp;&nbsp;|&nbsp;&nbsp;
Feedback</font></b>
<BR><font face="verdana" size="-1"><B><a href="customize.cgi?tab=customize&user=$FORM{'user'}&file=sitesubmitter"><font color="#FFFFFF">Customize Templates</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="email.cgi?user=$FORM{'user'}&file=sitesubmitter"><font color="#FFFFFF">Members</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="engines.cgi?user=$FORM{'user'}&file=sitesubmitter"><font color="#FFFFFF">Manage Search Engines</font></a></center></font></b>
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
 <TD><IMG SRC="$images/place.gif" height=5 width=1></TD>
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
 <TD><IMG SRC="$images/place.gif" height=1 width=5></TD>
 </TR>
 
 <TR>
 <TD><IMG SRC="$images/place.gif" height=1 width=5></TD>
 
 <TD>
 <CENTER><TABLE BORDER=0 CELLSPACING=0 ADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#000000" >
 <TR>
 <TD><IMG SRC="$images/place.gif" height=5 width=1></TD>
 </TR>
 </CENTER></TABLE>
 
 <CENTER><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=1 WIDTH="100%" BGCOLOR="#666666" >
 <TR><TD>
 <CENTER>&nbsp;</CENTER>
 </TD>
 <TD align="center"><FONT color="#FFFFFF" FACE=verdana size="-1">www.done-right.net (Nulled By cHARLIeZ)
 </TD>
 </TR>
 </TABLE></CENTER>
 
 <IMG SRC="$images/place.gif" height=5 width=1></TD>
 
 <TD><IMG SRC="$images/place.gif" height=1 width=5></TD>
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
	($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
	$encryptkey = "$encryptkey$dayofyear";
    my ($source,$key,$pub_key) = @_;
    my ($cr,$index,$char,$key_char,$enc_string,$encode,$first,
        $second,$let1,$let2,$encrypted,$escapes) = '';
    $source = &rot13($source); 
    $cr = '·¨ '; 
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
	($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
	$encryptkey = "$encryptkey$dayofyear";
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
    $cr = '·¨ '; 
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