#!/usr/bin/perl
# Quick Mailer 1.0
# Provided By CGI Connection
# http://www.CGIConnection.com

$| = 1;

use Socket;
use CGI;

$query = new CGI;
$query->import_names();

srand();

# Temporary directory to store mailing list
# Eg. /tmp/
$temp_dir = "!TMPDIR!/";

# SMTP server (set to localhost or leave blank)
$SMTP_SERVER = "!SMTP!";

# Maximum number of e-mails allowed to send (set to 0 for unlimited)
$max_send = 0;

#######################################
$from_address = $Q::from;
$subject = $Q::subject;
$body = $Q::body;

$ok_add = 0;
$invalid_add = 0;
$success_add = 0;
$unsuccess_add = 0;
$count_send = 0;

print "Content-type: multipart/mixed\n\n";

print "<HTML><TITLE>Quick Mailer 1.0</TITLE><BODY>\n";

for ($j = 0; $j < 50; $j++)
 {
 print "<!-- FORCE OUTPUT-->\n";
 }

if ($from_address eq "" or $subject eq "" or $body eq "")
 {
 &show_screen;
 exit;
 }

if ($from_address =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $from_address !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
 {
 print "Invalid return address!\n";
 print "</BODY></HTML>\n";
 exit;
 }

&upload_file;

if ($upsuc == 0)
 {
 print "Mailing list did not upload!\n";
 print "</BODY></HTML>\n";
 exit;
 }

print "<CENTER><H2>Quick Mailer 1.0</H2></CENTER>\n";

open(ML, "<$tempname");

until(eof(ML) or ($count_send == $max_send and $max_send > 0))
 {
 $line = <ML>;
 chop($line);
 $line =~ s/\cM//g;

 $to_address = $line;

 if ($line ne "")
  {
  if ($line =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $line !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
   {
   $invalid_add++;
   print "<B>Invalid e-mail address:</B> $line<BR>\n";
   }
   else
   {
   $ok_add++;
   print "<B>Sending to:</B> $line";
   $result = &send_mail("$from_address", "$from_address", "$to_address", $SMTP_SERVER, "$subject", "$body");

   if ($result == 1)
    {
    $success_add++;
    print " [OK]<BR>\n";
    }
    else
    {
    $unsuccess_add++;
    print " [ERROR: $result]<BR>\n";
    }

   print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";

   if ($max_send > 0)
    {
    $count_send++;
    }
   }
  }
 }

close(ML);
unlink("$tempname");

if ($count_send >= $max_send and $max_send > 0)
 {
 print "<B>Maximum number of $max_send reached.  Stopped reading mailing list.</B><BR><BR>\n";
 }

print "All done!<BR><BR>\n";

print "Valid Addresses: $ok_add<BR>\n";
print "Invalid Addresses: $invalid_add<BR>\n";
print "Successfully Sent: $success_add<BR>\n";
print "Unsuccessfully Sent: $unsuccess_add<BR>\n";

print "<BR><BR><a href=\"$ENV{'SCRIPT_NAME'}\">Back</a>\n";
exit;

sub upload_file
{
$upsuc = 0;
$tempname2 = int(rand(1000000000));

$tempname = "$temp_dir$tempname2\.mail";
open(FILEUP, ">$tempname");

$syllabus = $query->param('uploadname');

while($bytesread=read($syllabus, $buffer, 4096))
 {
 print FILEUP $buffer;
 }

close(FILEUP);

if (-s "$tempname" > 0)
 {
 $upsuc = 1;
 }
 else
 {
 unlink("$tempname");
 }

}


sub send_mail  {

    my ($fromaddr, $replyaddr, $to, $smtp, $subject, $message) = @_;

    $to =~ s/[ \t]+/, /g; # pack spaces and add comma
    $fromaddr =~ s/.*<([^\s]*?)>/$1/; # get from email address
    $replyaddr =~ s/.*<([^\s]*?)>/$1/; # get reply email address
    $replyaddr =~ s/^([^\s]+).*/$1/; # use first address
    $message =~ s/^\./\.\./gm; # handle . as first character
    $message =~ s/\r\n/\n/g; # handle line ending
    $message =~ s/\n/\r\n/g;
    $smtp =~ s/^\s+//g; # remove spaces around $smtp
    $smtp =~ s/\s+$//g;

    if (!$to)
    {
	return(-8);
    }

 if ($SMTP_SERVER ne "")
  {
    my($proto) = (getprotobyname('tcp'))[2];
    my($port) = (getservbyname('smtp', 'tcp'))[2];

    my($smtpaddr) = ($smtp =~
		     /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/)
	? pack('C4',$1,$2,$3,$4)
	    : (gethostbyname($smtp))[4];

    if (!defined($smtpaddr))
    {
	return(-1);
    }

    if (!socket(MAIL, AF_INET, SOCK_STREAM, $proto))
    {
	return(-2);
    }

    if (!connect(MAIL, pack('Sna4x8', AF_INET, $port, $smtpaddr)))
    {
	return(-3);
    }

    my($oldfh) = select(MAIL);
    $| = 1;
    select($oldfh);

    $_ = <MAIL>;
    if (/^[45]/)
    {
	close(MAIL);
	return(-4);
    }

    print MAIL "helo $SMTP_SERVER\r\n";
    $_ = <MAIL>;
    if (/^[45]/)
    {
	close(MAIL);
	return(-5);
    }

    print MAIL "mail from: <$fromaddr>\r\n";
    $_ = <MAIL>;
    if (/^[45]/)
    {
	close(MAIL);
	return(-5);
    }

    foreach (split(/, /, $to))
    {
	print MAIL "rcpt to: <$_>\r\n";
	$_ = <MAIL>;
	if (/^[45]/)
	{
	    close(MAIL);
	    return(-6);
	}
    }

    print MAIL "data\r\n";
    $_ = <MAIL>;
    if (/^[45]/)
    {
	close MAIL;
	return(-5);
    }

   }

  if ($SEND_MAIL ne "")
   {
   open (MAIL,"| $SEND_MAIL");
   }

   print MAIL "To: $to\n";
   print MAIL "From: $fromaddr\n";
   print MAIL "Reply-to: $replyaddr\n" if $replyaddr;
   print MAIL "X-Mailer: FFA Mailer\n";
   print MAIL "Subject: $subject\n";
   print MAIL "Content-type: text/html\n\n";
   print MAIL "$message";
   print MAIL "\n.\n";

 if ($SMTP_SERVER ne "")
  {
    $_ = <MAIL>;
    if (/^[45]/)
    {
	close(MAIL);
	return(-7);
    }

    print MAIL "quit\r\n";
    $_ = <MAIL>;
  }

    close(MAIL);
    return(1);
}


sub show_screen
{

{
print<<END
<CENTER>
<H2>Quick Mailer 1.0</H2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}" enctype="multipart/form-data">
<TABLE BORDER=0>
<TR><TD><B>Return Address:</B></TD> <TD><INPUT NAME=from></TD></TR>
<TR><TD><B>Subject:</B></TD> <TD><INPUT NAME=subject></TD></TR>
<TR><TD VALIGN=TOP><B>Body:</B></TD> <TD><TEXTAREA NAME=body COLS=40 ROWS=20></TEXTAREA></TD></TR>
<TR><TD><B>Mailing List:</B></TD> <TD><INPUT NAME=uploadname TYPE=file></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Send Mail"></TD></TR>
</TABLE>
</FORM>

</CENTER>
</BODY></HTML>
END
}

}
