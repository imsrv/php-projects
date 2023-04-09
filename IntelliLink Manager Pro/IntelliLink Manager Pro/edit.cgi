#!/usr/bin/perl

##########################################################################
##																		##
##						 IntelliLink Manager Pro						##
##						 -----------------------						##
##					   by Jimmy (wordx@hotmail.com)						##
##						http://www.smartCGIs.com						##
##																		##
##	IntelliLink Pro is not a free script. If you got this from someone  ##
##  please contact me. Visit our site for up to date versions. Most		##
##  CGIs are over $100, sometimes more than $500, this script is much	##
##  less. We can keep this script cheap, as well as a free version on	##
##  our site, if people don't steal it. If you are going to use a		##
##	stolen version, please atleast DO NOT remove any of the copyrights  ##
##	or links to our site, they keep this CGI cheap for everyone.		##
##	Thanks!																##
##																		##
##				  (c) copyright 2000 The Mp3eCom Network				##
##########################################################################

print "Content-type: text/html\n\n";

require "variables.cgi";
$sitename = "$variables{'sitename'}";
$siteurl = "$variables{'siteurl'}";
$bannerurl = "$variables{'bannerurl'}";
$cgiurl = "$variables{'cgiurl'}";
$body = "$variables{'body'}";	
$mailp = "$variables{'mailp'}";	
$wemail = "$variables{'wemail'}";	
$maxtitle = "$variables{'maxtitle'}";	
$maxdescription = "$variables{'maxdescription'}";	
$report = "$variables{'report'}";	
$emailwebmaster = "$variables{'emailwebmaster'}";	
$badchar = "$variables{'badchar'}";	

$buffer = $ENV{'QUERY_STRING'};
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
($name,$value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/~!/ ~!/g;
$in{$name} = $value;
}
$id = $in{'id'};
$title = $in{'title'};
$description = $in{'description'};
$url = $in{'url'};
$email = $in{'email'};
$password = $in{'password'};
$sendreport = $in{'sendreport'};
$doedit = $in{'doedit'};
$forgotid = $in{'forgotid'};
$forgotpass = $in{'forgotpass'};

if($doedit ne "") { &doedit; }
if($forgotid ne "") { &forgotid; }
if($forgotpass ne "") { &forgotpass; }

if($id eq "") {
print <<EOF;
<title>Edit Account at $sitename</title>
$body
<form method="GET" action="edit.cgi">
<div align="center"><center>Log in to edit your account:<p>
<table border="0" width="307">
    <tr>
      <td width="120" align="center"><div align="right"><p>ID Number:</td>
      <td width="223" align="left"><input type="text" name="id" size="23"></td>
    </tr>
      <td width="120" align="right"> Password:</td>
      <td width="223" align="left"><input type="password" name="password" size="23"></td>
    </tr>
  </table>
  <input type="submit" value="Login" name="submit"> <input type="reset" value="Reset" name="reset">
  </center></div>
</form>
<center>
<p><br><br>
<form method="GET" action="edit.cgi">
Forgot your ID number? Enter your site's URL and press submit:<br>
<input type="text" name="forgotid" value="http://" size="23">
  <input type="submit" value="Find" name="submit">
  </form>

  <p>
<form method="GET" action="edit.cgi">
Forgot your password? Enter your ID and it will be e-mail to you:<br>
<input type="text" name="forgotpass" size="23">
  <input type="submit" value="Find" name="submit">
  </form>
EOF
&info;
exit;
}

open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[2] eq $id) {
						&checkpass;
						&editform;
						}
}

sub checkpass {
if($linedata[3] ne $password) {
print <<EOF;
$body
<title>Incorrect Password</title>
The password you entered is incorrect.
EOF
exit;
								}
}

sub editform {
print <<EOF;
$body
<title>Edit info for $linedata[4]</title>
<center>
<big>Edit Account for $id</big><br>$linedata[4]
<p>
<table>
<tr><td><div align="right">In Today:</td><td><b>$linedata[0]</td></tr>
<tr><td><div align="right">Out Today:</td><td><b>$linedata[1]</td></tr>
</table>
<br>
<form method="GET" action="edit.cgi">
<table border="0" width="289">
    <tr>
      <td width="111" align="center"><div align="right"><p>Title:</td>
      <td width="223" align="left"><input type="text" name="title" value="$linedata[4]" maxlength="$maxtitle" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right">Description:</td>
      <td width="223" align="left"><input type="text" name="description" value="$linedata[5]" maxlength="$maxdescription" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right">URL:</td>
      <td width="223" align="left"><input type="text" name="url" value="$linedata[6]" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right"> E-mail:</td>
      <td width="223" align="left"><input type="text" name="email" value="$linedata[7]" size="23"></td>
    </tr>
    <tr>
      <td width="111" align="right"> Password:</td>
      <td width="223" align="left"><input type="password" name="password" value="$linedata[3]" size="23"></td>
    </tr>
  </table>
EOF
if($report eq "1") {
if($linedata[8] eq "R") {
print <<EOF;
  <input type="checkbox" name="sendreport" checked value="R">E-mail me a Report
  daily (In/Out stats, etc.)
  <br>
EOF
} else {
print <<EOF;
  <input type="checkbox" name="sendreport" value="R">E-mail me a Report
  daily (In/Out stats, etc.)
  <br>
EOF
		}
					}
print <<EOF;
<input type="hidden" name="doedit" value="$id">
  <input type="submit" value="Submit" name="submit"> <input type="reset" value="Reset" name="reset">
</form>
EOF
&info;
exit;
}

sub doedit {
&checkentry;

open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[2] eq $doedit) {
$linedata[3] = $password;
$linedata[4] = $title;
$linedata[5] = $description;
$linedata[6] = $url;
$linedata[7] = $email;
$linedata[8] = $sendreport;
	$line = join('|',@linedata);
	push(@newlist, $line);
} else {
		push(@newlist, $line);
		}
					}
open(DATA,">data.txt");
flock (DATA,2);
print DATA @newlist;
flock (DATA,8);
close(DATA);
print <<EOF;
$body
<title>Edit Done</title>
Done. Your account information has been changed.
EOF
exit;
}

sub checkentry {
if(($description eq "")||($email eq "")||($url eq "")||($password eq "")) {
print "$body\n";
print "<title>Something Left Blank</title>\n";
print "You left something blank.\n";
exit;
}
if($title =~ /^\||\|/) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You used an invalid character in your title.\n";
exit;
}
if(($description =~ /^'|'/)||($description =~ /^\||\|/)) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You used an invalid character in your description.\n";
exit;
}
@badchar = split(/ /, $badchar);
foreach $bad(@badchar) {
if($title =~ /^$bad|$bad/) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You cannot use \"$bad\" in your title.\n";
exit;
}
if($description =~ /^$bad|$bad/) {
print "$body\n";
print "<title>Bad Character</title>\n";
print "You cannot use \"$bad\"  in your description.\n";
exit;
}
						}
# e-mail is valid?
if(not($email =~ /^\@|\@/)) {
print "$body\n";
print "<title>Invalid E-mail</title>\n";
print "Please provide a valid e-mail address.\n";
exit;
}
}

sub forgotid {
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
print "$body <title>Your ID</title>\n";
foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[6] eq $forgotid) {
print "<li>The ID for $linedata[4] is <b>$linedata[2]</b><br>\n";
$found = "1";
}
}
if($found ne "1") {
					print "No site found with the URL: $forgotid\n";
					}
exit;
}

sub forgotpass {
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
print "$body <title>Your Password</title>\n";
foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[2] eq $forgotpass) {
$found = "1";
open(MAIL,"|$mailp -t");
print MAIL "To: $linedata[7]\n";
print MAIL "From: $wemail\n";
print MAIL "Subject: Your Lost Password\n\n";
print MAIL "Your password for your link exchange with $sitename is: $linedata[3]\n\n";
print MAIL "\n\n";
close (MAIL);
print "Done. Your password has been e-mailed to the address you provided when signing up.\n";
exit;
}
}
if($found ne "1") { print "There is not site with ID number $forgotpass.\n"; }
exit;
}