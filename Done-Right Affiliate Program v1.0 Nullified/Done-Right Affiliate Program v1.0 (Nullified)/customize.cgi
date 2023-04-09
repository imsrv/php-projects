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
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		#$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		#$value =~ s/<([^>]|\n)*>//g;
		$FORM{$name} = $value;
	}
}
###############################################


###############################################
#logics
if ($FORM{'tab'} eq "custpage") { &custpage; }
elsif ($FORM{'tab'} eq "selecthtml") { &selecthtml; }
elsif ($FORM{'tab'} eq "htmlpage") { &htmlpage; }
elsif ($FORM{'tab'} eq "selectemail") { &selectemail; }
else { &customize; }
###############################################


###############################################
#Security Check
sub checklogin {
require "${path}config/config.cgi";

$current_time = time();
$ip = $ENV{'REMOTE_ADDR'};

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
#Main Sub
sub customize {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Templates</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=selecthtml&user=$FORM{'user'}&file=affiliateprogram">Customize HTML Pages</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the html code for various pages.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=selectemail&user=$FORM{'user'}&file=affiliateprogram">Customize Email Pages</a></td>
<td width="65%"><font face="verdana" size="-1">Customize various email message text.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
sub selecthtml {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize HTML Pages</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Signup Pages</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Signup+Page&htmlfile=signup">Signup Page</a></td>
<td width="65%"><font face="verdana" size="-1">Enter contact, site and login information page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Signup+Confirmation&htmlfile=complete">Confirmation Page</a></td>
<td width="65%"><font face="verdana" size="-1">Confirms signup.</font></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Members Pages</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Login+Page&htmlfile=login">Login Page</a></td>
<td width="65%"><font face="verdana" size="-1">Member login Page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Main+Page&htmlfile=members">Main Page</a></td>
<td width="65%"><font face="verdana" size="-1">Members main page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Forgot+Password+Page&htmlfile=forgot">Forgot Password Page</a></td>
<td width="65%"><font face="verdana" size="-1">Forgot password message page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Message+Page&htmlfile=message">Message Page</a></td>
<td width="65%"><font face="verdana" size="-1">Displays message.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Statistics+Page&htmlfile=statistics">Statistics Page</a></td>
<td width="65%"><font face="verdana" size="-1">Members statistics.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Modify+Profile+Page&htmlfile=profile">Profile Page</a></td>
<td width="65%"><font face="verdana" size="-1">Modify profile information.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Search+Code+Page&htmlfile=searchcode">Search Code Page</a></td>
<td width="65%"><font face="verdana" size="-1">Generate affiliate code.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
sub selectemail {
&checklogin;
print "Content-type: text/html\n\n";
&header;
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Email Messages</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Signup+Email&htmlfile=emailsignup">Signup Message</a></td>
<td width="65%"><font face="verdana" size="-1">Message to let user know you received their order.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.cgi?tab=htmlpage&user=$FORM{'user'}&file=affiliateprogram&page=Invoice+Email&htmlfile=emailinvoice">Invoice Email</a></td>
<td width="65%"><font face="verdana" size="-1">Invoice member receives when a check is sent.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
sub htmlpage {
&checklogin;
print "Content-type: text/html\n\n";
&header;
open (FILE, "${path}template/$FORM{'htmlfile'}.txt");
@data = <FILE>;
close (FILE);
$page = $FORM{'page'};
$page =~ tr/+/ /;
if ($FORM{'htmlfile'} eq "login") {
	$tag [0] = "&lt;!-- [error] --&gt;|Display any login error";
	$tag [1] = "&lt;!-- [error2] --&gt;|Display any forgot password error";
} elsif ($FORM{'htmlfile'} eq "members") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [created] --&gt;|Date of when account was created";
	$tag [3] = "&lt;!-- [todaysclicks] --&gt;|Total clicks for given day";
	$tag [4] = "&lt;!-- [todaysearnings] --&gt;|Total earnings for given day";
} elsif ($FORM{'htmlfile'} eq "forgot") {
	$tag [0] = "&lt;!-- [email] --&gt;|Displays the email address that the password was sent to";
} elsif ($FORM{'htmlfile'} eq "message") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [message] --&gt;|Displays action success message";
} elsif ($FORM{'htmlfile'} eq "statistics") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [viewing] --&gt;|The date selected to view";
	$tag [3] = "&lt;!-- [options] --&gt;|Other dates that can be viewed";
	$tag [4] = "&lt;!-- [created] --&gt;|Date of when account was created";
	$tag [5] = "&lt;!-- [amount] --&gt;|Amount made for given time period";
	$tag [6] = "&lt;!-- [viewing3] --&gt;|Displays the date for the statistics currently viewing";
	$tag [7] = "&lt;!-- [datelink] --&gt;|Displays date sort link";
	$tag [8] = "&lt;!-- [clickthroughs] --&gt;|Displays clickthrough sort link";
	$tag [9] = "&lt;!-- [amountmade] --&gt;|Displays amount sort link";
	$tag [10] = "&lt;!-- [listing] --&gt;|Loop to displays stats";
	$tag [11] = "&lt;!-- [statdate] --&gt;|Date of statistic";
	$tag [12] = "&lt;!-- [statclick] --&gt;|Amount of clickthroughs";
	$tag [13] = "&lt;!-- [statmade] --&gt;|Amount of money made";
	$tag [14] = "&lt;!-- [paidowing] --&gt;|Reveals if the amount has been paid or still owed";
	$tag [15] = "&lt;!-- [totalclicks] --&gt;|Total clickthroughs";
	$tag [16] = "&lt;!-- [totalamount] --&gt;|Total amount";
} elsif ($FORM{'htmlfile'} eq "profile") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "[name]|Displays users name";
	$tag [3] = "[checkname]|Displays check payable to";
	$tag [4] = "[email]|Displays users email";
	$tag [5] = "[address1]|Displays users street address";
	$tag [6] = "[address2]|Displays users second address if they have one";
	$tag [7] = "[city]|Displays users city";
	$tag [8] = "[state]|Displays state or province";
	$tag [9] = "[zip]|Displays users zip code";
	$tag [10] = "[country]|Displays users country";
	$tag [11] = "[phone]|Displays users telephone number";
	$tag [12] = "[sitetitle]|Displays users site title";
	$tag [13] = "[siteurl]|Displays users site URL";
	$tag [14] = "[sitecategory]|Displays users site category";
	$tag [15] = "[password]|Displays users member password";
	$tag [16] = "&lt;!-- [error] --&gt;|Displays error message";
} elsif ($FORM{'htmlfile'} eq "searchcode") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "[searchurl]|Displays path to search.cgi";
} elsif ($FORM{'htmlfile'} eq "signup") {
	$tag [0] = "&lt;!-- [error] --&gt;|Displays error message";
} elsif ($FORM{'htmlfile'} eq "emailsignup") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[username]|Members username";
	$tag [2] = "[address]|Members address";
	$tag [3] = "[members]|Members URL";
	$tag [9] = "[company]|Company name taken from the variable configuration section";
	$tag [10] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emailinvoice") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[date]|Time period for check";
	$tag [2] = "[amount]|Check amount";
	$tag [9] = "[company]|Company name taken from the variable configuration section";
	$tag [10] = "[url]|WebSite URL taken from the variable configuration section";
}
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize</U> - <font color=red>$page</font></B></font>
<center><P>

<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<form METHOD="POST" ACTION="customize.cgi?tab=custpage&user=$FORM{'user'}&file=affiliateprogram"><BR>
<center><font face="verdana" size="-1"><TEXTAREA NAME="code" ROWS=40 COLS=100 WRAP="OFF">
EOF

foreach $line(@data) {
	chomp($line);
	$line =~ s/<\/TEXTAREA>/&lt;\/TEXTAREA>/g;
	print "$line\n";
}

print <<EOF;
</TEXTAREA><BR><BR>
<input type=hidden name=file2 value="$FORM{'htmlfile'}">
<input type=submit value="Save">
</form>
<BR>
<table width=90% border="0" cellspacing="2" cellpadding="0">
<tr><td colspan=2><b><font face="verdana" size="-1"><center>The following html tags are used to display a specific item.  Usually the tags look like this &lt;!-- [tag] --&gt; or [tag] and most of them are self explanatory.
</center></td></tr>
EOF
foreach $line(@tag) {
	@inner = split(/\|/, $line);
print <<EOF;
<tr>
<td width="35%"><font face="verdana" size="-1">$inner[0]</td>
<td width="55%"><font face="verdana" size="-1">$inner[1]</td>
</tr>
EOF
}

print <<EOF;
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&footer;
exit;
}
###############################################


###############################################
#Write to Customized Page
sub custpage {
&checklogin;

open (FILE2, ">${path}template/$FORM{'file2'}.txt");
$FORM{'code'} =~ s/\r//g;
$FORM{'code'} =~ s/&lt;\/TEXTAREA>/<\/TEXTAREA>/g;
print FILE2 <<EOF;
$FORM{'code'}
EOF
close (FILE2);
open (FILE, "${path}template/$FORM{'file2'}.txt");
@data = <FILE>;
close (FILE);
open (FILE, ">${path}template/$FORM{'file2'}.txt");
foreach $line(@data) {
	chomp($line);
	print FILE "$line\n";	
}
close (FILE);
$text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Page Customized</B></font></font>";
&customize;
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
<a href="admin.cgi?tab=config&user=$FORM{'user'}&file=affiliateprogram">Configure
Variables</a>&nbsp;&nbsp;|&nbsp;&nbsp;
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