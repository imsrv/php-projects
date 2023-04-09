#!/usr/bin/perl
# E-Contact
# Provided By CGI Connection
# http://www.cgiconnection.com
$| = 1;

use Socket;

# Your SMTP server.  Usually set to "localhost" or left blank
$SMTP_SERVER = "!SMTP!";

# Where to store E-contact information
# Eg. /path/to/save/files
$save_dir = "!SAVEDIR!";

# Default username and password
$username = "!USERNAME!";
$password = "!PASSWORD!";

# How many seconds to stop trying to send an e-mail
$timeout = 10;

# Default font
$font = "Arial";


#######################################
# DO NOT EDIT BELOW THIS LINE
#######################################
&parse_form;

$area = $FORM{'area'};
$subject = $FORM{'subject'};
$body = $FORM{'body'};
$name = $FORM{'name'};
$email = $FORM{'email'};
$max = $FORM{'max'};
$recipient = $FORM{'recipient'};
$width = $FORM{'width'};
$height = $FORM{'height'};
$filename = "contactus.txt";

$fcolor = "EEEEEE";
$fcolor = $FORM{'backgroundcolor'} if $FORM{'backgroundcolor'} ne "";


print "Content-type: text/html\n\n";

if ($area eq "")
 {
 ($chosen_num, $to_address) = &read_file;

 if ($chosen_num eq "")
  {
  print "document.write('<B>You have specified an invalid recipient ID</B>');";
  exit;
  }

 &show_email_box;
 }

if ($area eq "login")
 {
 &login_screen;
 }

if ($area eq "login2")
 {
 &check_login;
 &display_file; 
 }

if ($area eq "save")
 {
 &check_login;
 &save_file; 
 &display_file;
 }

if ($area eq "send")
 {
 if ($email !~ /^[A-Z0-9\-_\.]+\@[A-Z0-9\-\.]+\.[A-Z]{2,}$/i or $email eq "")
  {
  print "<SCRIPT>alert('You have supplied an invalid e-mail address');history.back(-1);</SCRIPT>\n";
  exit;
  }

 if ($name eq "" or $subject eq "" or $body eq "")
  {
  print "<SCRIPT>alert('You must fill in all fields');history.back(-1);</SCRIPT>\n";
  exit;
  }

 ($chosen_num, $to_address) = &read_file;
 $from_address = "$email";
 $result = 0;
 $errorno = 0;

 until($result == 1 || $errorno == $timeout)
  {
  $result = &send_mail("$name", "$from_address", "$from_address", "$to_address", $SMTP_SERVER, "$subject", "$body");
 
  if ($result != 1)
   {
   $errorno++;
   sleep 1;
   }
  }

  if ($result == 1)
   {
   print "<SCRIPT>alert('Your message has been sent');history.back(-1);</SCRIPT>\n";
   }
   else
   {
   print "<SCRIPT>alert('Your message could not be sent. Error #$result');history.back(-1);</SCRIPT>\n";
   }
 }

exit;

sub show_email_box
{
$fcolor = "\#$fcolor";

{
$line = "
<FONT FACE=\"$font\">
<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">
<INPUT TYPE=hidden NAME=area VALUE=\"send\">
<INPUT TYPE=hidden NAME=recipient VALUE=\"$recipient\">

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"$width\" HEIGHT=\"$height\">
<TR BGCOLOR=$fcolor><TD><B>Your Name: </B></TD> <TD><INPUT NAME=name SIZE=30></TD></TR>
<TR BGCOLOR=$fcolor><TD><B>Your E-mail: </B></TD> <TD><INPUT NAME=email SIZE=30></TD></TR>
<TR BGCOLOR=$fcolor><TD><B>Subject: </B></TD> <TD><INPUT NAME=subject SIZE=30></TD></TR>
<TR BGCOLOR=$fcolor ALIGN=CENTER><TD COLSPAN=2><B>Enter Message Below</B></TD>
<TR BGCOLOR=$fcolor ALIGN=CENTER><TD COLSPAN=2><TEXTAREA NAME=body COLS=40 ROWS=15></TEXTAREA></TD></TR>
<TR BGCOLOR=$fcolor><TD COLSPAN=2 ALIGN=CENTER><INPUT TYPE=submit NAME=submit VALUE=\"Send\"></TD></TR>
<TR BGCOLOR=$fcolor><TD COLSPAN=2 ALIGN=CENTER><FONT FACE=\"$font\" SIZE=-1><HR><A HREF=\"http://www.cgiconnection.com\">Powered by E-Contact</A></FONT></TD></TR>
</TABLE>
</FONT></FORM>
";
}

$line =~ s/\n/ /gi;
print "document.write('$line');";
}

sub parse_form {

   if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
      # Split the name-value pairs
      @pairs = split(/&/, $ENV{'QUERY_STRING'});
   }
   elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
      # Get the input
      read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
 
      # Split the name-value pairs
      @pairs = split(/&/, $buffer);
   }
   else {
      &error('request_method');
   }

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
 
      $name =~ tr/+/ /;
      $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      # If they try to include server side includes, erase them, so they
      # arent a security risk if the html gets returned.  Another 
      # security hole plugged up.

      $value =~ s/<!--(.|\n)*-->//g;


      # Remove HTML Tags

      $allow_html = 1;
      if ($allow_html == 0)
       {
       $value =~ s/<([^>]|\n)*>//g;
       }
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($FORM{$name} && ($value)) {
          $FORM{$name} = "$FORM{$name}, $value";
	 }
         elsif ($value ne "") {
            $FORM{$name} = $value;

         }
  }
}


sub error
{
local($msg) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$msg</H2></CENTER>\n";
exit;
}

sub login_screen
{

{
print<<END
<HTML>
<TITLE>E-Contact Administration</TITLE>
<BODY>
<CENTER>
<FONT FACE="$font">
<H2>E-Contact Administration</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE></FONT>
</CENTER>
</BODY></HTML>
END
}

}

sub read_file
{
my $line_count = 0;
open(FILES, "<$save_dir\/$filename");

until(eof(FILES))
 {
 $line = <FILES>;
 chop($line);

 splice(@lines, 0);
 @lines = split(/\|/, $line);

 if ($line ne "")
  {
  @all_nums[$line_count] = @lines[0];
  @all_email[$line_count] = @lines[1];
  $line_count++;

  if ($recipient eq @lines[0])
   {
   $chosen_num = @lines[0];
   $chosen_email = @lines[1];
   }
  }
 }

close(FILES);
return($chosen_num, $chosen_email);
}

sub display_file
{
&read_file;
$max_val = @all_nums + 5;

print "<HTML><TITLE>E-Contact Administration</TITLE><BODY>\n";
print "<FONT FACE=\"$font\"><CENTER><H2>E-Contact Administration</H2>\n";

print "<TABLE BORDER=0 WIDTH=600>\n";
print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"save\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$FORM{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$FORM{'password'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=max VALUE=\"$max_val\">\n";

print "<TR><TD COLSPAN=2>Enter an e-mail address and a unique ID for each in a box below.  The ID is assigned to the appropriate e-mail so your visitors will never see your e-mail address.<BR></TD></TR>\n";
print "<TR><TD VALIGN=TOP COLSPAN=2><BR><HR><BR></TD></TR>\n";

for ($j = 0; $j < $max_val; $j++)
 {
 $temp_j = $j + 1;
 $temp_num = @all_nums[$j];
 $temp_email = @all_email[$j];

 print "<TR><TD VALIGN=TOP><B>$temp_j\.</B></TD> <TD VALIGN=TOP><INPUT TYPE=CHECKBOX NAME=del$j VALUE=\"Y\"> <B>Check to delete</B></TD></TR>";
 print "<TR><TD VALIGN=TOP><B>ID:</B></TD> <TD VALIGN=TOP><INPUT NAME=num$j VALUE=\"$temp_num\" SIZE=10></TD></TR>\n";
 print "<TR><TD VALIGN=TOP><B>E-mail:</B></TD> <TD VALIGN=TOP><INPUT NAME=email$j VALUE=\"$temp_email\" SIZE=50></TD></TR>\n";
 print "<TR><TD VALIGN=TOP COLSPAN=2><BR><HR><BR></TD></TR>\n";
 }

print "<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE=\"Update\"></TD></TR>\n";
print "</FORM></TABLE></FONT></CENTER></BODY></HTML>\n";
}

sub save_file
{
if (not -e "$save_dir")
 {
 $backok = mkdir("$save_dir", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if ($filename eq "")
 {
 print "<HTML><BODY>You must specify a filename.</BODY></HTML>\n";
 exit;
 }

if (not -w "$save_dir")
 {
 print "<HTML><BODY>Cannot write to $save_dir\/files\/$filename</BODY></HTML>\n";
 exit;
 }

open(FILE, ">$save_dir\/$filename");

for ($j = 0; $j < $max; $j++)
 {
 $temp_num1 = "num$j";
 $temp_num = $FORM{$temp_num1};

 $temp_email1 = "email$j";
 $temp_email = $FORM{$temp_email1};

 $temp_del1 = "del$j";
 $temp_del = $FORM{$temp_del1};

 if ($temp_num ne "" and $temp_email ne "" and $temp_del eq "")
  {
  print FILE "$temp_num\|$temp_email\n";
  }
 }

close(FILE);

#print "<FONT FACE=\"$font\">Saved <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}&filename=$filename\">$filename</A><BR><BR>\n";
#print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Show all files</A><BR></FONT>\n";
}

sub check_login
{
if ($username ne $FORM{'username'})
 {
 print "<HTML><BODY>Invalid Username.</BODY></HTML>\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "<HTML><BODY>Invalid Password.</BODY></HTML>\n";
 exit;
 }
}

sub send_mail  {

    my ($name, $fromaddr, $replyaddr, $to, $smtp, $subject, $message) = @_;

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
   print MAIL "From: $name <$fromaddr>\n";
   print MAIL "Reply-to: $replyaddr\n" if $replyaddr;
   print MAIL "X-Mailer: E-Contact\n";
   print MAIL "Subject: $subject\n";

   if ($type eq "html")
    {
    print MAIL "Content-type: text/html\n\n";
    }
    else
    {
    print MAIL "Content-type: text/plain\n\n";
    }

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

