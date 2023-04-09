#!/usr/bin/perl
# Fetch a listing of all messages in users Inbox (remote or local)

use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
do "$Bin/html/javascript.js";

#do "$Bin/localmbox.pl";
require 'localmbox.pm';
require 'Common.pm';

use Net::POP3;
use Mail::Internet;
use Net::SMTP;
use Time::CTime;
use Time::ParseDate;

&config;
&javascript;
&showmail;
&htmlend;
exit;

sub showmail
 {
my $status = $_[0];

$localmail = 1 if($localmbox);

&htmlheader("$username\@$pop3host");

if($localmail)  {
$count = newbox("Inbox","$Bin/users/$confdir") if(!$localmbox);
$count = newbox("$localmbox","$Bin/users/$confdir/mbox") if($localmbox);
                }

else    {
&pop3connect;
$count = ($pop3->popstat)[0];
        }

my @mboxstat = stat("$Bin/users/$confdir/Inbox");
my $size = $mboxstat[7];
#print $size / (1024*1024), " - ", $userquota / (1024*1024), "<BR>";
$size = $userquota - $size;
#print "1) $size<BR>";
$size = $size / (1024 * 1024);
#print "2) $size<BR>";
$size = sprintf("%2.2f", $size);
#print "3) $size<BR>";
$size = "???" if(!$size);

$cgi->delete_all();
$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('getemail',"1");
my $refreshurl = $cgi->self_url;

$refresh = "60" if(!$refresh);

print<<_EOF;
<META HTTP-EQUIV=\"refresh\" CONTENT=$refresh\";URL=$refreshurl\">
<img src="imgs/newemail.gif" height=9 width=13 hspace=3><B>$count</B> new 
messages, $size MB available disk space<BR>
_EOF

print "<img src=\"imgs/alert.gif\" hspace=\"3\">$status<BR>" if($status);
&htmlend if(!$count);

print<<_EOF;
<table border="1" cellspacing="0" cellpadding="1" align="left" width="99%">
<form method="post" action="movemsg.pl">
<input type=hidden name="localmbox" value="$localmbox">
<tr>
<td bgcolor="$primarycolor"><font color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Subject:</b></font></td>
<td bgcolor="$primarycolor"><font color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>From:</b></font></td>
<td bgcolor="$primarycolor"><font color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Date:</b></font></td>
<td bgcolor="$primarycolor"><font color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Move</b></font></td>
</tr>
_EOF

for($i = 1; $i <= $count; $i++)
	{

if($localmail)  {
$email = readbox($i);
           }
else    {
$email = $pop3->top($i,20);
        }

my $message = new Mail::Internet $email;
my $head = $message->head();

$subject = subject_header(parseheader($head->get('Subject')));
$from = from_header(parseheader($head->get('From')));
$date = date_header(parseheader($head->get('Date')));

$bgcolor = ($bgcolor eq "$secondarycolor") ? "$primarycolor" : "$secondarycolor";

$cgi->delete_all();
$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('reademail', $i);
$cgi->param('password', "$password");
$url = $cgi->self_url;

if(!$localmbox) {
print<<_EOF;
<tr> 
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;
<a href="reademail.pl?username=$username&$password&pop3host=$pop3host&msgnum=$i">$subject</a></font></td>
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;$from</font></td>
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;$date</font></td>
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;
<input type="checkbox" name="msgdelete" value="$i"></font></td></tr>
_EOF
                }
else    {
print<<_EOF;
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;
<a href="reademail.pl?password=$password&pop3host=$pop3host&username=$username&localmbox=$localmbox&msgnum=$i">$subject</a></font></td>
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;$from</font></td>
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;$date</font></td>
<td bgcolor="$bgcolor" height="24"><font size="-1">&nbsp;
<input type="checkbox" name="msgdelete" value="$i"></font></td></tr>
_EOF
        }

   }

print<<_EOF;
<tr><td colspan=4>
<select name="folder">
_EOF

opendir(DIR,"$Bin/users/$confdir/mbox");
@folders = readdir(DIR);
foreach $folder (@folders)
	{
next if($folder eq "." || $folder eq ".." || $folder eq "tmp");
print "<option value=\"$folder\">$folder</option>";
	}

print<<_EOF;
</select>
<input type="submit" named="Submit" value="Move Messages"></td></tr>
</form>
</table>
_EOF
 
 }

