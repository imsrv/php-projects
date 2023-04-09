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
$cgiurl = "$variables{'cgiurl'}";
$mailp = "$variables{'mailp'}";	
$wemail = "$variables{'wemail'}";	
$body = "$variables{'body'}";	
$report = "$variables{'report'}";	
$anticheat = "$variables{'anticheat'}";	
$graphicurl = "$variables{'graphicurl'}";	
$adminpass = "$variables{'adminpass'}";	

$buffer = $ENV{'QUERY_STRING'};
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
($name,$value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/~!/ ~!/g;
$in{$name} = $value;
}
$title = $in{'title'};
$description = $in{'description'};
$url = $in{'url'};
$email = $in{'email'};
$sendreport = $in{'sendreport'};
$password = $in{'password'};
$allstats = $in{'allstats'};
$stats = $in{'stats'};
$viewmembers = $in{'viewmembers'};
$editmember = $in{'editmember'};
$deletemember = $in{'deletemember'};
$editmember2 = $in{'editmember2'};
$deletemember2 = $in{'deletemember2'};
$emailmembers = $in{'emailmembers'};

if($emailmembers ne "") { &emailall; }
if($stats eq "yes") { &stats; }
if($allstats eq "show") { &allstats; }
if($viewmembers eq "yes") { &viewmembers; }
if($editmember ne "") { &editmember; }
if($deletemember ne "") { &deletemember; }
if($editmember2 ne "") { &editmember2; }
if($deletemember2 ne "") { &deletemember2; }

if($password eq "") {
print <<EOF;
$body
<title>Admin Password Needed</title>
<form method="GET" action="admin.cgi">
<div align="center"><center>Admin Password: <input type="password" name="password" size="23"> 
<input type="submit" value="Login" name="submit">
  </center></div>
</form>
EOF
exit;
}
if($password ne $adminpass) {
print <<EOF;
$body
<title>Admin Password Incorrect</title>
That is the wrong password.
EOF
exit;
}

print <<EOF;
$body
<title>Admin Page</title>
<center>
$sitename<br>
<font size=+4>Admin Page</font>
<p>
<form method="GET" action="admin.cgi">
<input type="hidden" name="stats" value="yes" size="23"> 
<input type="submit" value="View Detailed Stats" name="submit">
</form>
<p>
<form method="GET" action="admin.cgi">
<input type="hidden" name="viewmembers" value="yes" size="23"> 
<input type="submit" value="View/Edit/Delete Sites" name="submit">
</form>
<p>

<script><!--
var sdsubmit=1
function validateForm(form) {
if (sdsubmit){
	emailmembersstr = new String()
	emailmembersstr.value = form.emailmembers.value
	form.submit.value = "Please wait..."
	form.submit.blur()
	sdsubmit=0
}
else {return false}
}
//--></script>

<form method="GET" action="admin.cgi" onSubmit="return validateForm(this)" name="f">
Send an e-mail message to all sites:<br>
<textarea rows="8" name="emailmembers" cols="50"></textarea>
<br>
<input type="submit" value="   Send   " name="submit">
<input type="reset" value="Reset" name="reset">
</form>

</center>
EOF

sub stats {
print <<EOF;
<center>
<font size=+3>15 day Stats</font><br>
<small><a href="admin.cgi?allstats=show">Display All</a></small>
</center>
<br>
EOF

open(DATA,"logs.txt");
@logs = <DATA>;
close(DATA);
foreach (@logs) { $lines++; }
$l2go = $lines - 15;

$maxfound = "0";
$counter = "0";
foreach $log(@logs) {
$counter++;
if($counter >= $l2go) {
@logdata = split (/\|/, $log);
if($logdata[0] > $maxfound) { $maxfound = $logdata[0]; }
if($logdata[1] > $maxfound) { $maxfound = $logdata[1]; }
					}
}

$counter = "0";
print "<div align=left><table border=\"0\" cellspacing=\"1\" bgcolor=\"#E4E4E4\"><tr>\n";
print "<td valign=top align=right><font color=000000>$maxfound-<br>-<br>-<br>-<br>-<br>-<br>-<br>-<br>-<br>-</td>";
foreach $log(@logs) {
$counter++;
if($counter >= $l2go) {
@logdata = split (/\|/, $log);
$in = int(200*($logdata[0]/$maxfound));
$out = int(200*($logdata[1]/$maxfound));
print "<td width=\"40\" valign=bottom><center><font color=000000>";
print "<img src=\"$graphicurl/admin_1.gif\" alt=\"IN: $logdata[0]\" width=18 height=$in>";
print "<img src=\"$graphicurl/admin_2.gif\" alt=\"OUT: $logdata[1]\" width=18 height=$out>";
print "<br><small>$logdata[3]\n";
print "</td>\n";
					 }
	}
if($counter < 16) {
while($counter < 16) {
print "<td width=\"40\"></td>";
$counter++;
}
}
print "</tr></table></div>\n";
print <<EOF;
<img src="$graphicurl/admin_1.gif"> = Total In<br>
<img src="$graphicurl/admin_2.gif"> = Total Out<br>
<p>
EOF

$maxfound = "0";
$counter = "0";
foreach $log(@logs) {
$counter++;
if($counter >= $l2go) {
@logdata = split (/\|/, $log);
if($logdata[2] > $maxfound) { $maxfound = $logdata[2]; }
					}
}
$counter = "0";
print "<div align=left><table border=\"0\" cellspacing=\"1\" bgcolor=\"#E4E4E4\"><tr>\n";
print "<td valign=top align=right><font color=000000>$maxfound-<br>-<br>-<br>-<br>-</td>";
foreach $log(@logs) {
$counter++;
if($counter >= $l2go) {
@logdata = split (/\|/, $log);
$active = int(100*($logdata[2]/$maxfound));
print "<td width=\"25\" valign=bottom><center><font color=000000>";
print "<img src=\"$graphicurl/admin_3.gif\" alt=\"$logdata[2]\" width=25 height=$active>";
print "<br><small>$logdata[3]\n";
print "</td>\n";
					 }
	}
if($counter < 16) {
while($counter < 16) {
print "<td width=\"25\"></td>";
$counter++;
}
}
print "</tr></table></div>\n";
print "<img src=\"$graphicurl/admin_3.gif\"> = Total Active* Sites<p>\n";
print "<small>* Active: Sites that have sent at least 1 visitor to you in a day.\n";
exit;
}

sub allstats {
open(DATA,"logs.txt");
@logs = <DATA>;
close(DATA);
print "$body <title>All Stats</title>\n";
@logs = reverse @logs;
foreach $log(@logs) {
@logdata = split (/\|/, $log);
print <<EOF;
Date: <b>$logdata[3]</b><br>
Active Members: <b>$logdata[2]</b><br>
In: <b>$logdata[0]</b><br>
Out: <b>$logdata[1]</b><p>
EOF
}
exit;
}

sub viewmembers {
print <<EOF;
$body
<title>Members</title>
<center>These are all the sites linking to you</center>
<p><a href="admin.cgi?password=$adminpass">Go back</a>
<hr>
EOF
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
@data = sort {$b <=> $a} @data;

foreach $line(@data) {
chomp($line);
@linedata = split (/\|/, $line);
$totalin = $totalin + $linedata[0];
$totalout = $totalout + $linedata[1];
print <<EOF;
<table width="700"><tr>
<td width=100>In: $linedata[0]</td><td width=100>Out: $linedata[1]</td>
<td width=50><a href="admin.cgi?editmember=$linedata[2]">Edit</a></td><td width=50><a href="admin.cgi?deletemember=$linedata[2]">Delete</a></td>
<td width=200>
EOF
if($linedata[9] ne "") { print "Non Active Days: "; }
if($linedata[9] > 15) { print "<font color=red>"; }
print "$linedata[9]</td><td width=200>";
if($linedata[8] ne "") { print "(Receiving Report)"; }
print <<EOF;
</td></tr>
<tr>
<td width=600 colspan=6>E-mail: <a href="mailto:$linedata[7]">$linedata[7]</a><br><a href="$linedata[6]" target="_blank">$linedata[4]</a><br>$linedata[5]<hr></td>
</tr>
</table>
EOF
}
print "Total In Today: $totalin<br>Total Out Today: $totalout<p><a href=\"admin.cgi?password=$adminpass\">Go back</a>\n";
exit;
}

sub editmember {
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);

foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[2] eq $editmember) { &editform; }
					}
exit;
}

sub editform {
print <<EOF;
$body
<title>Edit info for $linedata[4]</title>
<center>
<big>Admin Edit Account $editmember</big><br>($linedata[4])
<p>

<form method="GET" action="admin.cgi">
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
      <td width="223" align="left"><input type="text" name="password" value="$linedata[3]" size="23"></td>
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
<input type="hidden" name="editmember2" value="$editmember">
  <input type="submit" value="Submit" name="submit"> <input type="reset" value="Reset" name="reset">
</form>
EOF
exit;
}

sub editmember2 {
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);
foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[2] eq $editmember2) {
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
<title>Admin Edit Done</title>
Done. Account $editmember2 has been changed.
<br>
<a href="admin.cgi?viewmembers=yes">Go back</a>
EOF
exit;
}

sub deletemember {
print <<EOF;
$body
<title>Delete User?</title>
<center>
Are you sure you want to delete account $deletemember?
<br>
<form method="GET" action="admin.cgi">
<input type="hidden" name="deletemember2" value="$deletemember" size="23"> 
<input type="submit" value="Yes, Delete It!" name="submit">
</form>
EOF
exit;
}

sub deletemember2 {
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);

foreach $line(@data) {
@linedata = split (/\|/, $line);
if($linedata[2] ne $deletemember2) { push(@newlist,$line); }
}

open(DATA,">data.txt");
flock (DATA,2);
print DATA @newlist;
flock (DATA,8);
close(DATA);

print <<EOF;
$body
<title>Account Deleted</title>
Done. Account $deletemember2 has been deleted.
<br>
<a href="admin.cgi?viewmembers=yes">Go back</a>
EOF
exit;
}

sub emailall {
open(DATA,"data.txt");
flock (DATA,2);
@data = <DATA>;
flock (DATA,8);
close(DATA);

foreach $line(@data) {
chomp($line);
@linedata = split (/\|/, $line);
open(MAIL,"|$mailp -t");
print MAIL "To: $linedata[7]\n";
print MAIL "From: $wemail\n";
print MAIL "Subject: $sitename Link Exchange...\n\n";
print MAIL "$emailmembers\n\n";
close (MAIL);
}
print <<EOF;
$body
<title>E-mails Sent</title>
Done. All Site have been e-mailed.
<br>
<a href="admin.cgi?password=$adminpass">Go back</a>
EOF
exit;
}