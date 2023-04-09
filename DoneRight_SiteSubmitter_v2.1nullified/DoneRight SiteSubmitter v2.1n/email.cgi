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
#logics
if ($FORM{'tab'} eq "sendemail") { &sendemail; }
elsif ($FORM{'tab'} eq "email") { &email; }
elsif ($FORM{'tab'} eq "block") { &block; }
elsif ($FORM{'tab'} eq "blocksubmitter") { &blocksubmitter; }
elsif ($FORM{'tab'} eq "delete") { &delete; }
elsif ($FORM{'tab'} eq "deleteemail") { &deleteemail; }
elsif ($FORM{'tab'} eq "viewemail") { &viewemail; }
else { &main; }
###############################################


###############################################
#Security Check
sub checklogin {
require "${path}config/config.cgi";
$images = $config{'image'};

$current_time = time();
$ip = $ENV{'REMOTE_ADDR'};

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
sub main {
&checklogin;
print "Content-type: text/html\n\n";
&header;
open (FILE, "${path}template/emaillog.txt");
@email = <FILE>;
close (FILE);
$members = $#email;
$members++;
print <<EOF;
<font face="verdana" size="-1"><B><U>Members</U></B></font><P>
<center>
<font face="verdana" size="-1"><B>Amount of members:&nbsp;&nbsp;</B><font color="#000099">$members</font></font>
<P>
$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
  	<tr>
   	<td>
   	<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="email.cgi?tab=email&user=$FORM{'user'}&file=sitesubmitter">Email Members</a></td>
<td width="65%"><font face="verdana" size="-1">Email all submitter members at once or individually.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="email.cgi?tab=viewemail&user=$FORM{'user'}&file=sitesubmitter">View Members/Emails</a></td>
<td width="65%"><font face="verdana" size="-1">View each members actual email address.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="email.cgi?tab=delete&user=$FORM{'user'}&file=sitesubmitter">Delete Member/Email</a></td>
<td width="65%"><font face="verdana" size="-1">Remove a members email address</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="email.cgi?tab=block&user=$FORM{'user'}&file=sitesubmitter">Block Submitters</a></td>
<td width="65%"><font face="verdana" size="-1">Ban submissions from specified email addresses.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub block {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Block Submitters</U></B></font><P>
<center>
<form METHOD="POST" ACTION="email.cgi?tab=blocksubmitter&user=$FORM{'user'}&file=sitesubmitter">
$text
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><font face="verdana" size="-1" color="#000099"><B>Add Blocked Email</B>&nbsp;&nbsp;</td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Email to Block:</B>&nbsp;&nbsp;
<input type=text name=email size="30"></td></tr>
<tr><td><input type=submit name="block" value="Block"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR>
<form METHOD="POST" ACTION="email.cgi?tab=blocksubmitter&user=$FORM{'user'}&file=sitesubmitter">
$text2
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><font face="verdana" size="-1" color="#000099"><B>Remove Blocked Email</B></td>
</tr>
<tr>
<td><font face="verdana" size="-1"><B>Blocked Email to Remove:</B>
<select name="email"><option SELECTED>Select blocked email to remove</option>
EOF
open (FILE, "${path}template/emailblock.txt");
@emails = <FILE>;
close (FILE);
foreach $line(@emails) {
	chomp($line);
	print "<option>$line</option>";
}
print <<EOF;
</select></td></tr>
<tr><td><input type=submit name="block" value="Remove"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub blocksubmitter {
&checklogin;
unless ($FORM{'block'} eq "Remove") {
	open (FILE, ">>${path}template/emailblock.txt");
	print FILE "$FORM{'email'}\n";
	close (FILE);
	$text = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Email Address Blocked</font></B><BR>";
} else {
	open (FILE, "${path}template/emailblock.txt");
	@email = <FILE>;
	close (FILE);
	open (FILE, ">${path}template/emailblock.txt");
	foreach $line(@email) {
		chomp($line);
		unless ($line eq $FORM{'email'}) {
			print FILE "$line\n";
		}
	}
	close (FILE);
	$text2 = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Blocked Email Address Removed</font></B><BR>";
}
&block;
}
###############################################


###############################################
sub delete {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Delete Members</U></B></font><P>
<center>
<form METHOD="POST" ACTION="email.cgi?tab=deleteemail&user=$FORM{'user'}&file=sitesubmitter">
$text
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><BR><center><font face="verdana" size="-1"><B>Email:</B>&nbsp;&nbsp;
<select name="email"><option SELECTED>Select Email</option>
EOF
open (FILE, "${path}template/emaillog.txt");
@email = <FILE>;
close (FILE);
@sort = sort(@email);
foreach $line(@sort) {
	chomp($line);
	print "<option>$line</option>";	
}
print <<EOF;
&nbsp;&nbsp;&nbsp;<input type=submit value="Delete"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub deleteemail {
&checklogin;
open (FILE, "${path}template/emaillog.txt");
@email = <FILE>;
close (FILE);
open (FILE, ">${path}template/emaillog.txt");
foreach $line(@email) {
	chomp($line);
	unless ($line eq $FORM{'email'}) {
		print FILE "$line\n";
	}
}
close (FILE);
$text = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Email Address Removed</font></B><BR>";
&delete;
}
###############################################


###############################################
sub email {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Email Members</U></B></font><P>
<center>
<form METHOD="POST" ACTION="email.cgi?tab=sendemail&user=$FORM{'user'}&file=sitesubmitter">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="20%"><font face="verdana" size="-1"><B>From:</B></font></td>
<td width="80%"><input type=text name=from size="20" value="$config{'adminemail'}"></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1"><B>To:</B></font></td>
<td width="80%"><select name="to"><option SELECTED>All Members
EOF
open (FILE, "${path}template/emaillog.txt");
@emails = <FILE>;
close (FILE);
foreach $line(@emails) {
	chomp($line);
	print "<option>$line";	
}
print <<EOF;
</select>&nbsp;&nbsp;<B><font face="verdana" size="-1"><a href="email.cgi?tab=viewemail&user=$FORM{'user'}&file=sitesubmitter">View Emails</a></font></B></td>
</tr>
<tr>
<td width="20%"><font face="verdana" size="-1"><B>Subject:</B></font></td>
<td width="80%"><input type=text name=subject size="20"></td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Message:</B></font></td>
</tr>
<tr>
<td colspan=2><TEXTAREA NAME="message" ROWS=30 COLS=110 WRAP="ON"></TEXTAREA></td>
</tr>
<tr>
<td colspan=2><input type=submit value="Send"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub sendemail {
&checklogin;
$mailer = $config{'mailer'};
$from = $FORM{'from'};
$to = $FORM{'to'};
$subject = $FORM{'subject'};
$message = $FORM{'message'};

if ($to eq "All Members") {
	open (FILE, "${path}template/emaillog.txt");
	@emails = <FILE>;
	close (FILE);
	foreach $line(@emails) {
		chomp($line);
		$to = $line;
		&sendout;
	}
} else {
	&sendout;	
}

sub sendout {
	if ($config{'server'} eq "nt") {
		eval { use Net::SMTP; };
		$smtp = Net::SMTP->new($mailer);
		$smtp->mail($from);
		$smtp->to($to);

		$smtp->data();
		$smtp->datasend("To: $to\n");
		$smtp->datasend("From: $from\n"); 
		$smtp->datasend("Subject: $subject\n"); 
		$smtp->datasend($message);
		$smtp->dataend();
		$smtp->quit;
	} else {
		open(MAIL,"|$mailer -t");
		print MAIL "Subject: $subject\n";
		print MAIL "To: $to\n";
		print MAIL "From: $from\n";
	}
print MAIL <<EOF;
$message
EOF
	close(MAIL);
}
	

$text = "<font face=\"verdana\" size=\"-1\"><B>Message:</B> <font color=red>Email Message Sent</font></B><BR>";
&main;
}
###############################################


###############################################
sub viewemail {
&checklogin;
print "Content-type: text/html\n\n";
&header;
open (FILE, "${path}template/emaillog.txt");
@email = <FILE>;
close (FILE);
$members = $#email;
$members++;
print <<EOF;
<font face="verdana" size="-1"><B><U>View Emails</U></B></font><P>
<center>
<font face="verdana" size="-1"><B>Amount of members:&nbsp;&nbsp;</B></font>
<font face="verdana" size="-1" color="#000099">$members</font><BR>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
EOF
open (FILE, "${path}template/emaillog.txt");
@emails = <FILE>;
close (FILE);
$counter=0;
foreach $line(@emails) {
	chomp($line);
	if ($counter == 0) { print "<tr>"; }
print <<EOF;
<td width="33%"><font face="verdana" size="-1"><a href="mailto:$line">$line</a></font></td>
EOF
	$counter++;
	if ($counter == 3) {
		print "</tr>";
		$counter = 0;
	}
}
print <<EOF;
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
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
print <<EOF;
<center><font face="verdana" size="-1"><B><a href="admin.cgi?tab=login&user=$FORM{'user'}&file=sitesubmitter">Main</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="admin.cgi?tab=config&user=$FORM{'user'}&file=sitesubmitter">Configure Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
Update&nbsp;&nbsp;|&nbsp;&nbsp;
Download&nbsp;&nbsp;|&nbsp;&nbsp;
Support&nbsp;&nbsp;|&nbsp;&nbsp;
Feedback</font></b>
<BR><font face="verdana" size="-1"><B><a href="customize.cgi?tab=login&user=$FORM{'user'}&file=sitesubmitter"><font color="#FFFFFF">Customize Templates</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="email.cgi?user=$FORM{'user'}&file=sitesubmitter"><font color="#FFFFFF">Members</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="engines.cgi?user=$FORM{'user'}&file=sitesubmitter"><font color="#FFFFFF">Manage Search Engines</font></a></center></font></b>
EOF
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