#!/usr/bin/perl
# AutoResponder 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com

$| = 1;

use Socket;
use Time::Local;

# Directory to store all files
# Eg. /path/to/your/web/server
# CHMOD to 777
$save_dir = "!SAVEDIR!";

# SMTP server (usually set to localhost or leave blank)
$SMTP_SERVER = "!SMTP!";

# Timeout value if mail server does not respond (in seconds)
$time_out = 300;

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

# Entire URL to your arespond.cgi script
# Eg. http://www.yourserver.com/cgi-bin/arespond.cgi
$cgi_url = "http://!SCRIPTURL!";

# Subject for subscription e-mail confirmation
$subject_verify = "Subscription Confirmation";
$message_verify = "Please confirm your subscription by going to:

$cgi_url?area=optin&id=!ID!

";

#################################
# DO NOT EDIT BELOW THIS LINE   #
#################################

if (@ARGV[0] ne "")
 {
 if ($username ne @ARGV[0] or $password ne @ARGV[1])
  {
  print "Invalid username or password.\n";
  exit;
  }

 if (@ARGV[2] eq "" or (not -e "$save_dir\/schedules\/@ARGV[2]"))
  {
  print "Schedule @ARGV[2] does not exist\n";
  exit;
  }

 $username = @ARGV[0];
 $password = @ARGV[1];
 $filename = @ARGV[2];
 &run_schedule(1);
 exit;
 }

&parse_form;

$area = $FORM{'area'};
$name = $FORM{'name'};
$email = $FORM{'email'};
$changeemail = $FORM{'changeemail'};
$background = $FORM{'background'};
$email_verify = $FORM{'email_verify'};
$width = $FORM{'width'};
$id = $FORM{'id'};
$schedule = $FORM{'schedule'};
$day = $FORM{'day'};
$desc = $FORM{'desc'};
$subject = $FORM{'subject'};
$message = $FORM{'message'};
$filename = $FORM{'filename'};
$files = $FORM{'files'};
$delete = $FORM{'delete'};

print "Content-type: text/html\n\n";

if ($area eq "")
 {
 &show_box;
 exit;
 }

if ($area eq "optin")
 {
 &opt_in;
 exit;
 }

if ($area eq "unsubscribe")
 {
 &unsubscribe;
 exit;
 }

if ($area eq "subscribe")
 {
 if ($email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $email !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
  {
  print "<SCRIPT>alert('You have supplied an invalid e-mail address'); history.back(-1);</SCRIPT>";
  exit;
  }

 if ($name eq "")
  {
  print "<SCRIPT>alert('Please enter your name'); history.back(-1);</SCRIPT>";
  exit;
  }

 if (not -e "$save_dir\/verify")
  {
  $backok = mkdir("$save_dir\/verify", 0777);

  if ($backok == 0)
   {
   print "<SCRIPT>alert('$save_dir\/verify could not be created'); history.back(-1);</SCRIPT>";
   exit;
   }
  }

 if (not -w "$save_dir\/verify")
  {
  print "<SCRIPT>alert('Cannot write to $save_dir\/verify'); history.back(-1);</SCRIPT>";
  exit;
  }

 &check_email;
 $new_id = &get_id;

 open(FILE, ">$save_dir\/verify\/$new_id");
 print FILE "$schedule\n";
 print FILE "$name\n";
 print FILE "$email\n";
 close(FILE);

 $message_verify =~ s/\!ID\!/$new_id/ig;
 $message_verify =~ s/\!NAME\!/$name/ig;

 $subject_verify =~ s/\!ID\!/$new_id/ig;
 $subject_verify =~ s/\!NAME\!/$name/ig;

 &lock("$schedule\.sch");
 open(FILE, "<$save_dir\/schedules\/$schedule");
 $email_verify = <FILE>;
 close(FILE);
 &unlock("$schedule\.sch");
 chop($email_verify);

 $found = 0;

 until($found == 1)
  {
  $result = &send_mail("$email_verify", "$email_verify", "$email", $SMTP_SERVER, "$subject_verify", "$message_verify");
   
  if (((time() - $check_time) >= $time_out) or $result == 1)
   {
   $found = 1;
   }
  }

 if ($result == 1)
  {
  print "<SCRIPT>alert('Thank you for subscribing.  Check your e-mail to confirm.'); history.back(-1);</SCRIPT>";
  }
  else
  {
  unlink("$save_dir\/verify\/$new_id");
  print "<SCRIPT>alert('Could not send e-mail. Please try again later.'); history.back(-1);</SCRIPT>";
  }

 exit;
 }

if ($area eq "login")
 {
 &login_screen;
 exit;
 }

if ($area eq "main")
 {
 &check_login;
 &main_screen;
 exit;
 }

if ($area eq "newschedule")
 {
 &check_login;
 &make_schedule;
 exit;
 }

if ($area eq "newmessage")
 {
 &check_login;
 &message_screen("$email_verify");
 exit;
 }

if ($area eq "changesubscribers")
 {
 &check_login;
 &change_subscribers;
 exit;
 }

if ($area eq "editschedule")
 {
 &check_login;

 if ($filename eq "")
  {
  &show_schedules;
  exit;
  }

 &make_schedule;
 exit;
 }

if ($area eq "subscribers")
 {
 &check_login;

 if ($filename eq "")
  {
  &show_subscribers;
  exit;
  }

 &edit_subscribers;
 exit;
 }

if ($area eq "editmessage")
 {
 &check_login;

 if ($filename eq "")
  {
  &show_messages;
  exit;
  }

 ($email, $subject, $desc, $message) = &get_message("$filename");
 &message_screen("$email");
 exit;
 }

if ($area eq "savemessage")
 {
 &check_login;
 &save_message;
 exit;
 }

if ($area eq "saveschedule")
 {
 &check_login;
 &save_schedule;
 exit;
 }

if ($area eq "process")
 {
 &check_login;

 if ($filename eq "")
  {
  &show_schedules;
  exit;
  }

 &run_schedule;
 exit;
 }

exit;

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

sub show_box
{
if ($schedule eq "" or (not -e "$save_dir\/schedules\/$schedule"))
 {
 print "document.write('AutoResponder schedule $schedule does not exist');\n";
 exit;
 }

{
print<<END
document.write('<FORM METHOD=POST ACTION="$cgi_url">');
document.write('<INPUT TYPE=hidden NAME=area VALUE="subscribe">');
document.write('<INPUT TYPE=hidden NAME=schedule VALUE="$schedule">');
document.write('<TABLE BORDER=1 WIDTH=$width>');
document.write('<TR><TD BGCOLOR="$background"><CENTER>');
document.write('<B>Your Name</B><BR>');
document.write('<INPUT NAME=name><BR>');
document.write('<B>E-mail</B><BR>');
document.write('<INPUT NAME=email><BR>');
document.write('<INPUT TYPE=submit NAME=submit VALUE="Subscribe"></CENTER></TD></TR>');
document.write('</TABLE></FORM>');
END
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
   print MAIL "X-Mailer: CGI Connection AutoResponder\n";
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

sub login_screen
{

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$cgi_url">
<INPUT TYPE=hidden NAME=area VALUE="main">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub main_screen
{

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<TABLE BORDER=0>
<TR><TD><A HREF="$cgi_url?area=newschedule&username=$FORM{'username'}&password=$FORM{'password'}">Create new autoresponder schedule</A></TD></TR>
<TR><TD><A HREF="$cgi_url?area=newmessage&username=$FORM{'username'}&password=$FORM{'password'}">Create new message</A></TD></TR>

<TR><TD><BR></TD></TR>

<TR><TD><A HREF="$cgi_url?area=editmessage&username=$FORM{'username'}&password=$FORM{'password'}">Edit message</A></TD></TR>
<TR><TD><A HREF="$cgi_url?area=editschedule&username=$FORM{'username'}&password=$FORM{'password'}">Edit autoresponder schedule</A></TD></TR>

<TR><TD><BR></TD></TR>

<TR><TD><A HREF="$cgi_url?area=subscribers&username=$FORM{'username'}&password=$FORM{'password'}">Show / Edit subscribers</A></TD></TR>
<TR><TD><A HREF="$cgi_url?area=process&username=$FORM{'username'}&password=$FORM{'password'}">Process schedules</A></TD></TR>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub get_message
{
my ($from_email, $subject, $desc, $message);
my ($filename) = @_[0];

if ($filename eq "" or (not -e "$save_dir\/messages\/$filename"))
 {
 print "<SCRIPT>alert('$filename does not exist'); history.back(-1);</SCRIPT>";
 exit;
 }

&lock("$filename\.msg");
open(FILE, "<$save_dir\/messages\/$filename");
$from_email = <FILE>;
$subject = <FILE>;
$desc = <FILE>;

until(eof(FILE))
 {
 $line = <FILE>;
 $message .= $line;
 }

close(FILE);
&unlock("$filename\.msg");

chop($from_email);
chop($subject);
chop($desc);

return($from_email, $subject, $desc, $message);
}

sub save_message
{
if ($filename eq "")
 {
 print "<SCRIPT>alert('You must specify a filename'); history.back(-1);</SCRIPT>";
 exit;
 }

if ($filename =~ /^[a-z0-9 ]+$/i)
 {
 }
 else
 {
 print "<SCRIPT>alert('Filename can only contain alphanumeric characters'); history.back(-1);</SCRIPT>";
 exit;
 }

if ($delete ne "")
 {
 &lock("$filename\.sch");
 unlink("$save_dir\/schedules\/$filename");
 &unlock("$filename\.sch");
 print "$filename has been deleted.<BR><BR>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
 exit;
 }

if (not -e "$save_dir\/messages")
 {
 $backok = mkdir("$save_dir\/messages", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/messages could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if (not -w "$save_dir\/messages")
 {
 print "<SCRIPT>alert('Cannot write to $save_dir\/messages'); history.back(-1);</SCRIPT>";
 exit;
 }

&lock("$filename\.msg");
open(FILE, ">$save_dir\/messages\/$filename");
print FILE "$email\n";
print FILE "$subject\n";
print FILE "$desc\n";
print FILE "$message\n";
close(FILE);
&unlock("$filename\.msg");

print "<A HREF=\"$cgi_url?area=editmessage&username=$FORM{'username'}&password=$FORM{'password'}&filename=$filename\">$filename</A> has been saved.<BR><BR>\n";
print "<A HREF=\"$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
}

sub message_screen
{
my $email = @_[0];

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<A HREF="$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}">Main Menu</A>
<BR><BR>

<FORM METHOD=POST ACTION="$cgi_url">
<INPUT TYPE=HIDDEN NAME=area VALUE="savemessage">
<INPUT TYPE=HIDDEN NAME=username VALUE="$FORM{'username'}">
<INPUT TYPE=HIDDEN NAME=password VALUE="$FORM{'password'}">

<TABLE BORDER=0 WIDTH=75%>
<TR><TD COLSPAN=2>
Enter an autoresponder message that will be sent out to your subscribers.
 Variables that you can use in the body of your message are listed below.

<BR><BR>
<B>!NAME!</B> = Subscriber's name<BR>
<B>!EMAIL!</B> = Subscriber's e-mail address<BR>
<B>!SUBJECT!</B> = Subject of this message<BR>
<B>!UNSUBSCRIBE!</B> = Provides the unsubscribe URL<BR>
<BR>
</TD></TR>
END
}

if ($area eq "editmessage")
 {
 print "<TR><TD VALIGN=TOP><B>Delete?</B></TD> <TD><INPUT TYPE=CHECKBOX NAME=delete VALUE=\"Y\"> <I>Check to delete message</I></TD></TR>\n";
 }

{
print<<END
<TR><TD VALIGN=TOP><B>Save as:</B></TD> <TD><INPUT NAME=filename VALUE="$filename"></TD></TR>
<TR><TD VALIGN=TOP><B>Description:</B></TD> <TD><INPUT NAME=desc VALUE="$desc"></TD></TR>
<TR><TD VALIGN=TOP><B>Return e-mail:</B></TD> <TD><INPUT NAME=email VALUE="$email"></TD></TR>
<TR><TD VALIGN=TOP><B>Subject:</B></TD> <TD><INPUT NAME=subject VALUE="$subject"></TD></TR>
<TR><TD VALIGN=TOP><B>Message:</B></TD> <TD><TEXTAREA NAME=message COLS=40 ROWS=25>$message</TEXTAREA></TD></TR>
<TR><TD><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Save"></TD></TR>
</TABLE>
</FORM>
</CENTER>
</BODY></HTML>
END
}

}

sub show_messages
{

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<A HREF="$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}">Main Menu</A>
<BR><BR>

<TABLE BORDER=0>
<TR><TD COLSPAN=2>Select a message to edit<BR><BR></TD></TR>
<TR><TD><B>Filename</B></TD> <TD><B>Description</B></TD></TR>
END
}

splice(@all_files, 0);
opendir(FILE, "$save_dir\/messages");
@all_files = readdir(FILE);
closedir(FILE);

for ($j = 2; $j < @all_files; $j++)
 {
 &lock("@all_files[$j]\.msg");
 open(FILE, "<$save_dir\/messages\/@all_files[$j]");
 $email = <FILE>;
 $subject = <FILE>;
 $desc = <FILE>;
 close(FILE);
 &unlock("@all_files[$j]\.msg");

 chop($desc);

 print "<TR><TD><A HREF=\"$cgi_url?area=editmessage&username=$FORM{'username'}&password=$FORM{'password'}&filename=@all_files[$j]\">@all_files[$j]</A></TD> <TD>$desc</TD></TR>\n";
 }

print "</TABLE></CENTER></BODY></HTML>\n";
}

sub show_schedules
{

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<A HREF="$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}">Main Menu</A>
<BR><BR>

<TABLE BORDER=0>
END
}

if ($area eq "process")
 {
 print "<TR><TD COLSPAN=2>Select a schedule to process<BR><BR></TD></TR>\n";
 }
 else
 {
 print "<TR><TD COLSPAN=2>Select a schedule to edit<BR><BR></TD></TR>\n";
 }

print "<TR><TD><B>Filename</B></TD> <TD><B>Description</B></TD></TR>\n";

splice(@all_files, 0);
opendir(FILE, "$save_dir\/schedules");
@all_files = readdir(FILE);
closedir(FILE);

for ($j = 2; $j < @all_files; $j++)
 {
 &lock("@all_files[$j]\.sch");
 open(FILE, "<$save_dir\/schedules\/@all_files[$j]");
 $email_verify = <FILE>;
 $desc = <FILE>;
 close(FILE);
 &unlock("@all_files[$j]\.sch");

 chop($desc);
 chop($email_verify);

 print "<TR><TD><A HREF=\"$cgi_url?area=$area&username=$FORM{'username'}&password=$FORM{'password'}&filename=@all_files[$j]\">@all_files[$j]</A></TD> <TD>$desc</TD></TR>\n";
 }

print "</TABLE></CENTER></BODY></HTML>\n";
}

sub show_subscribers
{

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<A HREF="$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}">Main Menu</A>
<BR><BR>

<TABLE BORDER=0>
<TR><TD COLSPAN=2>Select a subscriber schedule to show / edit<BR><BR></TD></TR>
<TR><TD><B>Filename</B></TD> <TD><B>Description</B></TD></TR>
END
}

splice(@all_files, 0);
opendir(FILE, "$save_dir\/subscribers");
@all_files = readdir(FILE);
closedir(FILE);

for ($j = 2; $j < @all_files; $j++)
 {
 &lock("@all_files[$j]\.sch");
 open(FILE, "<$save_dir\/schedules\/@all_files[$j]");
 $email_verify = <FILE>;
 $desc = <FILE>;
 close(FILE);
 &unlock("@all_files[$j]\.sch");

 chop($desc);
 chop($email_verify);

 print "<TR><TD><A HREF=\"$cgi_url?area=subscribers&username=$FORM{'username'}&password=$FORM{'password'}&filename=@all_files[$j]\">@all_files[$j]</A></TD> <TD>$desc</TD></TR>\n";
 }

print "</TABLE></CENTER></BODY></HTML>\n";
}

sub make_schedule
{
if ($area eq "editschedule")
 {
 &lock("$filename\.sch");
 open(FILE, "<$save_dir\/schedules\/$filename");
 $email_verify = <FILE>;
 $schedule_desc = <FILE>;

 until(eof(FILE))
  {
  $line = <FILE>;
  chop($line);

  splice(@all_lines, 0);
  @all_lines = split(/\|/, $line);
  $temp_name = "schedule@all_lines[0]";
  $SNAME{$temp_name} = "@all_lines[1]";
  }

 close(FILE);
 &unlock("$filename\.sch");

 chop($schedule_desc);
 chop($email_verify);
 }

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<A HREF="$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}">Main Menu</A>
<BR><BR>

<FORM METHOD=POST ACTION="$cgi_url">
<TABLE BORDER=0>
<TR><TD COLSPAN=3>Enter the day to run each autoresponder.  Leave any you do not want to run blank.<BR></TD></TR>
<TR><TD><B>Day to Run</B></TD> <TD><B>Filename</B></TD> <TD><B>Description</B></TD></TR>
END
}

splice(@all_files, 0);
opendir(FILE, "$save_dir\/messages");
@all_files = readdir(FILE);
closedir(FILE);

$num_files = @all_files - 2;
print "<INPUT TYPE=HIDDEN NAME=files VALUE=\"$num_files\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"saveschedule\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$FORM{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$FORM{'password'}\">\n";

for ($j = 2; $j < @all_files; $j++)
 {
 &lock("@all_files[$j]\.msg");
 open(FILE, "<$save_dir\/messages\/@all_files[$j]");
 $email = <FILE>;
 $subject = <FILE>;
 $desc = <FILE>;
 close(FILE);
 &unlock("@all_files[$j]\.msg");

 chop($desc);

 $count = $j - 1;

 $temp_name = "schedule@all_files[$j]";
 $temp_day = $SNAME{$temp_name};

 print "<TR><TD><INPUT TYPE=HIDDEN NAME=file$count VALUE=\"@all_files[$j]\"><INPUT NAME=day$count VALUE=\"$temp_day\" SIZE=3></TD> <TD>@all_files[$j]</TD> <TD>$desc</TD></TR>\n";
 }

print "<TR><TD COLSPAN=3><BR><HR></TD></TR>\n";

if ($area eq "editschedule")
 {
 print "<TR><TD><B>Delete?</B></TD> <TD COLSPAN=2><INPUT TYPE=CHECKBOX NAME=delete VALUE=\"Y\"> <I>Check to delete schedule</I></TD></TR>\n";
 }

print "<TR><TD><B>Default e-mail:</B></TD> <TD COLSPAN=2><INPUT NAME=email_verify VALUE=\"$email_verify\" SIZE=40></TD></TR>\n";
print "<TR><TD><B>Description:</B></TD> <TD COLSPAN=2><INPUT NAME=desc VALUE=\"$schedule_desc\" SIZE=40></TD></TR>\n";
print "<TR><TD><B>Save as:</B></TD> <TD COLSPAN=2><INPUT NAME=filename VALUE=\"$filename\"> <INPUT TYPE=submit NAME=submit VALUE=\"Save\"></TD></TR>\n";
print "</TABLE></FORM></CENTER></BODY></HTML>\n";
}

sub save_schedule
{
if ($filename eq "")
 {
 print "<SCRIPT>alert('You must specify a filename'); history.back(-1);</SCRIPT>";
 exit;
 }

if ($filename =~ /^[a-z0-9 ]+$/i)
 {
 }
 else
 {
 print "<SCRIPT>alert('Filename can only contain alphanumeric characters'); history.back(-1);</SCRIPT>";
 exit;
 }

if (not -e "$save_dir\/schedules")
 {
 $backok = mkdir("$save_dir\/schedules", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/schedules could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if ($delete ne "")
 {
 &lock("$filename\.sch");
 unlink("$save_dir\/schedules\/$filename");
 &unlock("$filename\.sch");

 print "$filename has been deleted.<BR><BR>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
 exit;
 }

if (not -w "$save_dir\/schedules")
 {
 print "<SCRIPT>alert('Cannot write to $save_dir\/schedules'); history.back(-1);</SCRIPT>";
 exit;
 }

&lock("$filename\.sch");
open(FILE, ">$save_dir\/schedules\/$filename");
print FILE "$email_verify\n";
print FILE "$desc\n";

for ($j = 1; $j < ($files + 1); $j++)
 {
 $temp_file = "file$j";
 $temp_file2 = $FORM{$temp_file};

 $temp_day = "day$j";
 $temp_day2 = $FORM{$temp_day};

 if ($temp_day2 ne "")
  {
  print FILE "$temp_file2\|$temp_day2\n";
  }
 }

close(FILE);
&unlock("$filename\.sch");

print "<A HREF=\"$cgi_url?area=editschedule&username=$FORM{'username'}&password=$FORM{'password'}&filename=$filename\">$filename</A> has been saved.<BR><BR>\n";
print "<A HREF=\"$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
}

sub opt_in
{
my $time_now = time();

if ($id eq "" or (not -e "$save_dir\/verify\/$id"))
 {
 print "<SCRIPT>alert('Invalid ID'); history.back(-1);</SCRIPT>";
 exit;
 }

open(FILE, "<$save_dir\/verify\/$id");
$schedule = <FILE>;
$name = <FILE>;
$email = <FILE>;
close(FILE);

chop($schedule);
chop($name);
chop($email);

if ($schedule eq "" or (not -e "$save_dir\/schedules\/$schedule"))
 {
 print "document.write('AutoResponder schedule $schedule does not exist');\n";
 exit;
 }

if (not -e "$save_dir\/subscribers")
 {
 $backok = mkdir("$save_dir\/subscribers", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/subscribers could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if (not -w "$save_dir\/subscribers")
 {
 print "<SCRIPT>alert('Cannot write to $save_dir\/subscribers'); history.back(-1);</SCRIPT>";
 exit;
 }

unlink("$save_dir\/verify\/$id");

&lock("$schedule\.sub");
open(FILE, ">>$save_dir\/subscribers\/$schedule");
print FILE "$time_now\|$email\|$name\n";
close(FILE);
&unlock("$schedule\.sub");

print "<SCRIPT>alert('Thank you for subscribing. Your e-mail has been confirmed.'); history.back(-1);</SCRIPT>";
}

sub lock
{
my $lock_name = @_[0];
my $locks = "$save_dir\/";
my $lock_timer = 0;
my $lock_timer_stop = 0;
my $lock_passed = 0;

while ($lock_timer_stop < 1)
 {
 for ($locka = 0; $locka < 10; $locka++)
  {
  if (not -e "$locks$lock_name")
   {
   $lock_timer_stop = 1;
   }
   else
   {
   $lock_timer_stop = 0;
   }
  }

 if ($lock_timer_stop == 1)
  {
  open (LOCKIT, ">$locks$lock_name");
  print LOCKIT "LOCKED\n";
  close (LOCKIT);
  }
  else
  {
  $idle_max = 30;
  splice(@lock_info, 0);
  @lock_info=stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @lock_info;

  $id_time = time() - $lm;

  if ($id_time > $idle_max and $lm > 0)
   {
   $lock_passed = 1;
   unlink ("$locks$lock_name");
   }

  select(undef,undef,undef,0.01);
  $lock_timer++;
  }
 }

}

sub unlock
{
my $locks = "$save_dir\/";
my $lock_name = @_[0];
unlink ("$locks$lock_name");
}

sub edit_subscribers
{

{
print<<END
<HTML>
<TITLE>AutoResponder 1.0</TITLE>
<BODY>
<CENTER>
<H2>AutoResponder 1.0</H2>

<A HREF="$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}">Main Menu</A>
<BR><BR>

<TABLE BORDER=1 WIDTH=50%>
<FORM METHOD=POST ACTION="$cgi_url">
<INPUT TYPE=HIDDEN NAME=username VALUE="$FORM{'username'}">
<INPUT TYPE=HIDDEN NAME=password VALUE="$FORM{'password'}">
<INPUT TYPE=HIDDEN NAME=area VALUE="changesubscribers">
<INPUT TYPE=HIDDEN NAME=schedule VALUE="$filename">

<TR><TD COLSPAN=3>If you want to add a user, enter the information below.</TD></TR>
<TR><TD><B>Name:</B> <TD><INPUT NAME=name></TD></TR>
<TR><TD><B>E-mail:</B> <TD><INPUT NAME=email></TD></TR>
<TR><TD COLSPAN=3><BR><BR></TD></TR>
END
}

print "<TR><TD><B>Delete?</B></TD> <TD><B>Name</B></TD> <TD><B>E-mail</B></TD></TR>\n";

&lock("$filename\.sub");
open(FILE, "<$save_dir\/subscribers\/$filename");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 print "<TR><TD><INPUT TYPE=CHECKBOX NAME=changeemail VALUE=\"@all_lines[1]\"></TD> <TD>@all_lines[2]</TD> <TD>@all_lines[1]</TD></TR>\n";
 }

close(FILE);
&unlock("$filename\.sub");

print "</TABLE><INPUT TYPE=SUBMIT NAME=submit VALUE=\"Update\"></FORM></CENTER></BODY></HTML>\n";
}

sub get_id
{
my $j;
my $rndval;
my $passcode;

for ($j = 0; $j < 15; $j++)
 {
 until(($rndval > 96 and $rndval < 123) or ($rndval > 64 and $rndval < 91))
  {
  $rndval = int(rand(122));
  }

 $passcode .= chr($rndval);
 $rndval = 0;
 }

return("$passcode");
}

sub check_email
{
&lock("$schedule\.sub");
open(FILE, "<$save_dir\/subscribers\/$schedule");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 if ("\L$email\E" eq "\L@all_lines[1]\E")
  {
  close(FILE);
  &unlock("$schedule\.sub");
  print "<SCRIPT>alert('You are already subscribed to this list.'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

close(FILE);
&unlock("$schedule\.sub");
}

sub run_schedule
{
splice(@files, 0);
splice(@days, 0);
my $count = 0;
my $schedule_type = @_[0];
# 0 = from web / 1 = from command line

if ($schedule_type == 0)
 {
 print "<HTML><BODY><TITLE>AutoResponder 1.0</TITLE><CENTER><H2>AutoResponder 1.0</H2>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A></CENTER><BR>\n";
 }

&lock("$filename\.sch");
open(FILE, "<$save_dir\/schedules\/$filename");
$line = <FILE>;
$line = <FILE>;

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);
 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 @files[$count] = @all_lines[0];
 @days[$count] = @all_lines[1];
 $count++;
 }

close(FILE);
&unlock("$filename\.sch");

&lock("$filename\.sub");
link("$save_dir\/subscribers\/$filename", "$save_dir\/$filename\.run");
&unlock("$filename\.sub");

&lock("$filename\.runlock");
open(FILE, "<$save_dir\/$filename\.run");

until(eof(FILE))
 {
 $line = <FILE>;
 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 for ($j = 0; $j < @days; $j++)
  {
  $temp_day = @days[$j];
  $now_time = time();
  $temp_signup = @all_lines[0];

  $temp_info = ($temp_day + 1) * 86400;
  $temp_date = $temp_signup + $temp_info;

  my ($month,$mday,$year,$hour,$min,$sec) = &single_time($temp_date);
  my $rev_time = &reverse_time(0,0,0,$mday,$month,$year);

  my ($month2,$mday2,$year2,$hour2,$min2,$sec2) = &single_time($now_time);
  my $rev_time2 = &reverse_time(0,0,0,$mday2,$month2,$year2);

  if ($rev_time == $rev_time2)
   {
   $email = @all_lines[1];
   $name = @all_lines[2];
   $new_msg = "";

   if ($schedule_type == 0)
    {
    print "<B>Sending:</B> $email <B>(Day @days[$j])</B><BR>\n";
    }

   &lock("@files[$j]\.msg");
   open(INFILE, "<$save_dir\/messages\/@files[$j]");

   $from_email = <INFILE>;
   $subject = <INFILE>;
   $desc = <INFILE>;

   chop($from_email);
   chop($subject);
   chop($desc);
   chop($name);

   $unsubscribe_url = "$cgi_url\?area=unsubscribe\&schedule=$filename\&email=$email";

   until(eof(INFILE))
    {
    $inline = <INFILE>;
    $inline =~ s/\!EMAIL\!/$email/ig;
    $inline =~ s/\!NAME\!/$name/ig;
    $inline =~ s/\!SUBJECT\!/$subject/ig;
    $inline =~ s/\!UNSUBSCRIBE\!/$unsubscribe_url/ig;
    $new_msg .= $inline;
    }

   close(INFILE);
   &unlock("@files[$j]\.msg");

   $found = 0;
   $check_time = time();
   until($found == 1)
    {
    $subject =~ s/\!EMAIL\!/$email/ig;
    $subject =~ s/\!NAME\!/$name/ig;

    $result = &send_mail("$from_email", "$from_email", "$email", $SMTP_SERVER, "$subject", "$new_msg");

    if (((time() - $check_time) >= $time_out) or $result == 1)
     {
     $found = 1;
     }
    }
   
   }
  }
 }

close(FILE);
unlink("$save_dir\/$filename\.run");
&unlock("$filename\.runlock");

if ($schedule_type == 0)
 {
 print "<BR>All Done.</BODY></HTML>\n";
 }
}

sub reverse_time
{
my ($sec, $min, $hours, $mday, $mon, $year) = @_;
my $mon = $mon - 1;
my $revtime = timelocal($sec,$min,$hours,$mday,$mon,$year);
return ($revtime);
}

sub single_time
{
my $pass = $_[0];
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($pass);

   if ($sec < 10) {
   $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   $mon++;
   if ($mon < 10) {
   $month = "0$mon";
   }
   else
   {
   $month = "$mon";
   }

   if ($mday < 10)
   {
   $mday = "0$mday";
   }

return ($month,$mday,$year,$hour,$min,$sec);
}

sub unsubscribe
{
my $foundit = 0;
my $process = $$;

if ($email eq "")
 {
 print "<HTML><BODY>You must specify your e-mail address.</BODY></HTML>\n";
 exit;
 }

if ($schedule eq "" or (not -e "$save_dir\/subscribers\/$schedule"))
 {
 print "<HTML><BODY>Schedule $schedule does not exist.</BODY></HTML>\n";
 exit;
 }

&lock("$schedule\.sub");
open(FILE, "<$save_dir\/subscribers\/$schedule");
open(FILE2, ">$save_dir\/$schedule\.$process");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 if ("\L$email\E" ne "\L@all_lines[1]\E")
  {
  print FILE2 "$line\n";
  }
  else
  {
  $foundit = 1;
  }
 }

close(FILE);
close(FILE2);

if ($foundit == 1)
 {
 unlink("$save_dir\/subscribers\/$schedule");
 rename("$save_dir\/$schedule\.process", "$save_dir\/subscribers\/$schedule");
 print "<HTML><BODY>You are now unsubscribed.</BODY></HTML>\n";
 }
 else
 {
 unlink("$save_dir\/$schedule\.$process");
 print "<HTML><BODY>Your e-mail address is not on file.</BODY></HTML>\n";
 }

&unlock("$schedule\.sub");
}

sub change_subscribers
{
$process = $$;

print "<HTML><BODY><TITLE>AutoResponder 1.0</TITLE><CENTER><H2>AutoResponder 1.0</H2>\n";
print "<A HREF=\"$cgi_url?area=main&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A></CENTER><BR>\n";

splice(@all_emails, 0);
@all_emails = split(/, /, $changeemail);
$total_emails = @all_emails;

&lock("$schedule\.sub");

if ($name ne "" and $email ne "")
 {
 print "<B>Adding:</B> $email<BR>\n";

 $now_time = time();
 open(FILEN, ">>$save_dir\/subscribers\/$schedule"); 
 print FILEN "$now_time\|$email\|$name\n";
 close(FILEN);
 }

if ($total_emails > 0)
{
open(FILE, "<$save_dir\/subscribers\/$schedule");
open(FILE2, ">$save_dir\/$schedule\.$process");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 splice(@all_lines, 0);
 @all_lines = split(/\|/, $line);

 $foundit = 0;
 for ($j = 0; $j < @all_emails; $j++)
  {
  if ("\L@all_emails[$j]\E" eq "\L@all_lines[1]\E")
   {
   $foundit = 1;
   }
  }

 if ($foundit == 0)
  {
  print FILE2 "$line\n";
  }
  else
  {
  print "<B>Deleting:</B> @all_lines[1]<BR>\n";
  $foundit2++;
  }
 }

close(FILE);
close(FILE2);

if ($foundit2 > 0)
 {
 unlink("$save_dir\/subscribers\/$schedule");
 rename("$save_dir\/$schedule\.$process", "$save_dir\/subscribers\/$schedule");
 }
 else
 {
 unlink("$save_dir\/$schedule\.$process");
 }
}

&unlock("$schedule\.sub");
print "<BR>All done.</BODY></HTML>\n";
}
