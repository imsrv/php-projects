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
if ($FORM{'tab'} eq "modify") { &modify; }
elsif ($FORM{'tab'} eq "add") { &add; }
elsif ($FORM{'tab'} eq "edit") { &edit; }
elsif ($FORM{'tab'} eq "delete") { &delete; }
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
require "${path}template/semod.cgi";
@all = split(/\|/, $semod{'all_engines'});
$engines2 = $#all;
$engines2++;
print <<EOF;
<font face="verdana" size="-1"><B><U>Search Engines</U></B></font><P>
<center>
<font face="verdana" size="-1"><B>Amount of Search Engines to Submit to:&nbsp;&nbsp;</B></font>
<font face="verdana" size="-1" color="#000099">$engines2</font><BR>
<form METHOD="POST" ACTION="engines.cgi?tab=add&user=$FORM{'user'}&file=sitesubmitter">
$message
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1" color="red"><B>Add Engine</B></font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Engine Name:</B></font></td>
<td width="70%"><input type=text name=enginename size="30"></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Engine URL:</B></font></td>
<td width="70%"><input type=text name=engineurl size="50" value="http://www.engineurl.com?url=[url]&email=[email]"></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Success Message (optional):</B></font></td>
<td width="70%"><input type=text name=enginemessage size="50"></td>
</tr>
<tr>
<td colspan=2><input type=submit value="Add"><input type=hidden name=type value="add"></td>
</tr>
<tr>
<td colspan=2>&nbsp;</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>TAGS</B></font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>[email]</B></font></td>
<td width="70%"><font face="verdana" size="-1">Replace the email address in the engine url with this tag (ex. &email=[email])</font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>[url]</B></font></td>
<td width="70%"><font face="verdana" size="-1">Replace the url in the engine url with this tag (ex. &url=[url])</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR>
<form METHOD="POST" ACTION="engines.cgi?tab=edit&user=$FORM{'user'}&file=sitesubmitter">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1" color="red"><B>Edit Engine</B></font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Custom Engine:</B></font></td>
<td width="70%"><SELECT NAME="editcustom" SIZE="1"><OPTION SELECTED value="select">Select Engine To Edit
EOF
require "${path}template/semod.cgi";
$customengs = "$semod{'custom_engines'}";
if ($customengs =~ /\|/) {
@custom = split(/\|/,$customengs);
@sort = sort(@custom);
print "<option>CUSTOM ENGINES";
foreach $line(@sort) {
	chomp($line);
	print "<option>$line";
}
} else { print "<option>$semod{'custom_engines'}"; }
@custom = split(/\|/,$semod{'search_engines'});
print "<option> <option>STANDARD ENGINES";
foreach $line(@custom) {
	chomp($line);
	print "<option>$line";
}
print <<EOF;
</SELECT></td>
</tr>
<tr>
<td colspan=2><input type=submit value="Edit"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR>
<form METHOD="POST" ACTION="engines.cgi?tab=delete&user=$FORM{'user'}&file=sitesubmitter">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1" color="red"><B>Delete Engine</B></font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Custom Engine:</B></font></td>
<td width="70%"><SELECT NAME="deletecustom" SIZE="1"><OPTION SELECTED value="select">Select Engine To Delete
EOF
if ($semod{'custom_engines'} =~ /\|/) {
$customengs = "$semod{'custom_engines'}";
@custom = split(/\|/,$customengs);
@sort = sort(@custom);
print "<option>CUSTOM ENGINES";
foreach $line(@sort) {
	chomp($line);
	print "<option>$line";
}
} else { print "<option>$semod{'custom_engines'}"; }
@custom = split(/\|/,$semod{'search_engines'});
print "<option> <option>STANDARD ENGINES";
foreach $line(@custom) {
	chomp($line);
	print "<option>$line";
}
print <<EOF;
</SELECT></td>
</tr>
<tr>
<td colspan=2><input type=submit value="Delete"></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&footer;
exit;
}
###############################################

###############################################
sub main2 {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<center>
<font face="verdana"><B>$message</B></font><BR>
<font face="verdana" size="-1"><a href="engines.cgi?user=$FORM{'user'}&file=sitesubmitter">Manage Search Engines</a>
<BR><BR>
EOF
&footer;
exit;
}
###############################################

###############################################
sub edit {
&checklogin;
if ($FORM{'editcustom'} eq "select" || $FORM{'editcustom'} eq "CUSTOM ENGINES" || $FORM{'editcustom'} eq "STANDARD ENGINES" || $FORM{'editcustom'} eq " ") {
	$message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>Please select an engine to edit</font></B><BR>";
	&main;
	exit;
}
$enginename = $FORM{'editcustom'};
require "${path}template/semod.cgi";
@engines = split(/\|/, $semod{'search_engines'});
@custom = split(/\|/, $semod{'custom_engines'});
foreach $engine(@custom) {
	chomp($engine);
	if ($engine eq $enginename) {
		$custstand = "custom";
		last;
	}
}
foreach $engine(@engines) {
	chomp($engine);
	if ($engine eq $enginename) {
		$custstand = "standard";
		last;
	}
}
$urlname = "${enginename}url";
$urlmessage = "${enginename}message";
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Edit Engine</U></B></font><P>
<center>
<form METHOD="POST" ACTION="engines.cgi?tab=modify&user=$FORM{'user'}&file=sitesubmitter">
$message
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1" color="red"><B>Add Engine:</B></font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Engine Name:</B></font></td>
<td width="70%"><font face="verdana" size="-1">$enginename<input type=hidden name=enginename value="$enginename"><input type=hidden name=custstand value="$custstand"></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Engine URL:</B></font></td>
<td width="70%"><input type=text name=engineurl size="50" value="$semod{$urlname}"></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>Success Message (optional):</B></font></td>
<td width="70%"><input type=text name=enginemessage size="50" value="$semod{$urlmessage}"></td>
</tr>
<tr>
<td colspan=2><input type=submit value="Edit"><input type=hidden name=type value="edit"></td>
</tr>
<tr>
<td colspan=2>&nbsp;</td>
</tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>TAGS</B></font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>[email]</B></font></td>
<td width="70%"><font face="verdana" size="-1">Replace the email address in the engine url with this tag (ex. &email=[email])</font></td>
</tr>
<tr>
<td width="30%"><font face="verdana" size="-1"><B>[url]</B></font></td>
<td width="70%"><font face="verdana" size="-1">Replace the url in the engine url with this tag (ex. &url=[url])</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table></form><BR><BR>
EOF
&footer;
}
###############################################


###############################################
sub delete {
&checklogin;
$enginename = $FORM{'deletecustom'};

require "${path}template/semod.cgi";
$custom = $semod{'custom_engines'};
$standard = $semod{'search_engines'};
$all = $semod{'all_engines'};
@custom = split(/\|/, $custom);
@standard = split(/\|/, $standard);
@all = split(/\|/, $all);

foreach $engine(@custom) {
	chomp($engine);
	unless ($engine eq $enginename) {
		if ($p == 0) { $custom2 .= "$engine"; }
		else { $custom2 .= "|$engine"; }
		$p++;
	}
}
$p=0;
foreach $engine(@standard) {
	chomp($engine);
	unless ($engine eq $enginename) {
		if ($p == 0) { $standard2 .= "$engine"; }
		else { $standard2 .= "|$engine"; }
		$p++;
	}
}
$p=0;
foreach $engine(@all) {
	chomp($engine);
	unless ($engine eq $enginename) {
		if ($p == 0) { $all2 .= "$engine"; }
		else { $all2 .= "|$engine"; }
		$p++;
	}
}
$t=0;
open (FILE, "${path}template/semod.cgi");
@semod = <FILE>;
close (FILE);
open (FILE, ">${path}template/semod.cgi");
foreach $line(@semod) {
	chomp($line);
	if ($line eq "# CUSTOM - DO NOT DELETE #" || $line eq "#$enginename" || $g == 1) {
		if ($t == 0) {
			print FILE "# CUSTOM - DO NOT DELETE #\n";
			print FILE "\$semod{'search_engines'}=\"$standard2\"\;\n";
			print FILE "\$semod{'custom_engines'}=\"$custom2\"\;\n";
			print FILE "\$semod{'all_engines'}=\"$all2\"\;\n";
			print FILE "# CUSTOM - DO NOT DELETE #\n";
			$t++;
		} elsif ($t == 2) {
			if ($g == 0) {
				$g++;
			} else {
				if ($line eq "######################################") {
					print FILE "\n";
					$g++;
				}
			}
		} else {
			$t++;	
		}
	} else {
		unless ($t == 1) {
			print FILE "$line\n";
		}
	}
}
close (FILE);
$message .= "<font face=\"verdana\"><B>Message:</B> <font color=red>Engine deleted</font></B><BR>";
&main2;
exit;
}
###############################################


###############################################
sub modify {
&checklogin;
$enginename = $FORM{'enginename'};
$engineurl = $FORM{'engineurl'};
$enginemessage = $FORM{'enginemessage'};

if ($engineurl eq "") { $message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>Please specify the engines url</font></B><BR>"; }
elsif ($engineurl !~ /\[url\]/) { $message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>You did not specify the [url] tag for the url</font></B><BR>"; }
$enginename =~ tr/ /_/;

require "${path}template/semod.cgi";
$custom = $semod{'custom_engines'};
$standard = $semod{'search_engines'};
@customeng = split(/\|/, $custom);
@engines = split(/\|/, $semod{'search_engines'});
if ($message) {
	&edit;
	exit;
}
if ($FORM{'custstand'} eq "custom") { $custstand = "custom"; }
else { $custstand = "standard"; }

open (FILE, "${path}template/semod.cgi");
@semod = <FILE>;
close (FILE);
$t=0;
$urlname = "${enginename}url";
$urlmessage = "${enginename}message";
open (FILE, ">${path}template/semod.cgi");
foreach $line(@semod) {
	chomp($line);
	if ($line eq "#$enginename" || $t == 1) {
		if ($t == 0) {
			print FILE "#$enginename\n";
			print FILE "\$semod{'$urlname'} = \"$engineurl\"\;\n";
			print FILE "\$semod{'$urlmessage'} = \"$enginemessage\"\;\n";
			print FILE "######################################\n";
			$t++;
		} else {
			if ($line eq "######################################") {
				$t++;
			}
		}
	} else {
		print FILE "$line\n";
	}
}
close (FILE);
$message .= "<font face=\"verdana\"><B>Message:</B> <font color=red>Engine edited</font></B><BR>";
&main2;
exit;
}
###############################################


###############################################
sub add {
&checklogin;
$enginename = $FORM{'enginename'};
$engineurl = $FORM{'engineurl'};
$enginemessage = $FORM{'enginemessage'};

unless ($enginename) { $message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>Please specify the engines name</font></B><BR>"; }
if ($engineurl eq "") { $message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>Please specify the engines url</font></B><BR>"; }
elsif ($engineurl !~ /\[url\]/) { $message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>You did not specify the [url] tag for the url</font></B><BR>"; }
$enginename =~ tr/ /_/;

require "${path}template/semod.cgi";
$custom = $semod{'custom_engines'};
@customeng = split(/\|/, $custom);
@engines = split(/\|/, $semod{'search_engines'});
foreach $eng(@customeng) {
	chomp($eng);
	if ($enginename eq $eng) {
		$message .= "<font face=\"verdana\" size=\"-1\"><B>Error:</B> <font color=red>Engine name already exists</font></B><BR>";
		last;
	}
}
if ($message) {
	&main;
	exit;
}

if ($custom ne "") { $custom = "$custom|$enginename"; }
else { $custom = "$enginename"; }
$all = "$semod{'all_engines'}|$enginename";
@customeng = split(/\|/, $all);
@sort = sort(@customeng);
foreach $line(@sort) {
	chomp($line);
	if ($p == 0) { $newengines .= "$line"; }
	else { $newengines .= "|$line"; }
	$p++;	
}
open (FILE, "${path}template/semod.cgi");
@semod = <FILE>;
close (FILE);
$t=0;
$urlname = "${enginename}url";
$urlmessage = "${enginename}message";
open (FILE, ">${path}template/semod.cgi");
foreach $line(@semod) {
	chomp($line);
	if ($line eq "# CUSTOM - DO NOT DELETE #") {
		if ($t == 0) {
			print FILE "# CUSTOM - DO NOT DELETE #\n";
			print FILE "\$semod{'search_engines'}=\"$semod{'search_engines'}\"\;\n";
			print FILE "\$semod{'custom_engines'}=\"$custom\"\;\n";
			print FILE "\$semod{'all_engines'}=\"$newengines\"\;\n";
			print FILE "# CUSTOM - DO NOT DELETE #\n";
		} elsif ($t == 2) {
			print FILE "######################################\n";
			print FILE "#$enginename\n";
			print FILE "\$semod{'$urlname'} = \"$engineurl\"\;\n";
			print FILE "\$semod{'$urlmessage'} = \"$enginemessage\"\;\n";
			print FILE "######################################\n\n";
			print FILE "# CUSTOM - DO NOT DELETE #\n";
		}
		$t++;
	} else {
		unless ($t == 1) {
			print FILE "$line\n";
		}
	}
}
close (FILE);
$message .= "<font face=\"verdana\"><B>Message:</B> <font color=red>Engine added</font></B><BR>";
&main2;
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