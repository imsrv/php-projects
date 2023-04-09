#!/usr/bin/perl
# Check Email
# Non MIME Version

# @Mail library configuration
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
do "$Bin/html/javascript.js";

require 'Common.pm';

use Net::SMTP;
use Mail::Internet;
use Time::CTime;
use Time::ParseDate;

&config;
&javascript;
&compose;
&htmlend;
exit;


sub compose {

if($msgtype || $msgnum) {

if($localmail)  {
require 'localmbox.pm';
$count = newbox("Inbox","$Bin/users/$confdir");
$email = readbox($msgnum);
                }

else    {
use Net::POP3;
&pop3connect;
$count = ($pop3->popstat)[0];
$email = $pop3->get($msgnum);
        }

$message = new Mail::Internet $email;
$head = $message->head();
$subject = parseheader($message->get('Subject'));
$date = parseheader($message->get('Date'));
$emailfrom = parseheader($message->get('From'));
                        }

if($msgtype eq "forward")	{
if($subject !~ /^Fwd:/) { $subject = "Fwd: $subject"; }
} elsif($msgtype eq "reply") {
my $from = $emailfrom;
if($subject !~ /^Re:/) { $subject = "Re: $subject"; }
					}
&htmlheader("Compose Email Message");
#<form method="post" action="sendmail.pl">

print<<_EOF;
<FORM METHOD="POST"  ENCTYPE="multipart/form-data" action="sendmail.pl">

 <input type="hidden" name="username" value="$username">
<input type="hidden" name="pop3host" value="$pop3host">
<table width="100%" border="1" cellspacing="0" cellpadding="2" align="left">
  <tr> 
    <td bgcolor="$primarycolor" height="28" colspan="5">
<font color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><u>Send 
      Email </u></b></font><font color="$headercolor">&nbsp;</font></td>
  </tr>
  <tr> 
    <td bgcolor="$secondarycolor" height="24" width="50">
<font color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Subject:</b></font></td>
    <td bgcolor="$secondarycolor" height="24" colspan="4"> <font color="$headercolor"> 
      <input type="text" name="emailsubject" size="60" value="$subject">
      </font></td>
  </tr>
  <tr bgcolor="$primarycolor"> 
    <td height="23" bgcolor="$primarycolor" width="50">
<font size="-1" color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif"><b>To:</b> 
      </font></td>
    <td height="23" colspan="4"><font color="$headercolor">
_EOF

if($msgtype eq "reply") {
print<<_EOF;
      <input type="text" name="emailto" size="60" value="$emailfrom">
_EOF
} else {
print<<_EOF;
<input type="text" name="emailto" size="60" value="">
_EOF
}

print<<_EOF;
      </font></td>
  </tr>

<input type=hidden name="emailfrom" value="$realname <$username\@$pop3host>">
  <tr bgcolor="$primarycolor"> 

    <td colspan="5"><font color="$headercolor"> <center>
     <textarea name="emailmessage" cols="70" rows="15">
_EOF

if($msgtype eq "forward" || $msgtype eq "reply") {
chomp($emailfrom);
print "$emailfrom wrote:\n";
foreach $line (@{$message->body}) { print ">$line"; }
}


print<<_EOF;
</textarea></center>
      </font></td>
  </tr>

  <tr bgcolor="$secondarycolor">
    <td height="23" bgcolor="$secondarycolor" width="50">
<font size="-1" color="$headercolor" face="Verdana, Arial, Helvetica, sans-serif"><b>Attach File:</b>
      </font></td>  
    <td height="23" colspan="4"><font color="$headercolor">
<INPUT type=file name=fileupload size=30 maxlength=150 value="1">
      </font></td> 
  </tr>  
  <tr bgcolor="$primarycolor"> 
    <td colspan="5"> 
      <input type="submit" name="Submit" value="Send Email">
    </td>
  </tr>
</table>
</form>
<BR><BR>

_EOF

 } 
