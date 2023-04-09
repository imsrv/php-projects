#!/usr/bin/perl
# Support Center
# Provided By CGI Connection
# http://www.CGIConnection.com

$| = 1;

use Socket;

srand();

# Directory to store all messages
# Eg. /path/to/your/web/server
# CHMOD to 777
$save_dir = "!SAVEDIR!";

# SMTP server (usually set to localhost or leave blank)
$SMTP_SERVER = "!SMTP!";

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

# Entire URL to your support.cgi script
# Eg. http://www.yourserver.com/cgi-bin/support.cgi
$cgi_url = "http://!SCRIPTURL!";

# Size / Color of text message box for user and admin to type in
$background = "CCCCCC";
$cols = 40;
$rows = 5;

# E-mail notification options
# 0 = no e-mail notification / 1 = only send to admin / 2 = only send to user / 3 = send to both
$mode = 3;

# Subject line to send user and admin: \$subject variable gets replaced with actual subject of message
$subject_user = "Confirmation: \$subject";
$subject_admin = "Support request: \$subject";

# Admin e-mail address that will receive support requests
# Don't forget to escape the @ sign by using a backslash before it.
# Eg. your\@address.com
$to_address = "!EMAIL!";

# Admin's real name
$to_name = "Support";

# Should Admin's e-mail be shown on user's web browser? 0 = NO / 1 = YES
$to_show = 0;

# Message to send user confirmation receipt of their request
$message_user = "
This is an automated response to your support request.
Please do not reply to this message.

You can view the status of your request any time at:

$cgi_url?area=status&id=\$id

IP Adddress submitted from: \$ip

Thank you
";

# Message to send admin when new requests for support are made.
$message_admin = "
Date: \$date \$time
ID: \$id
From: \$name (\$from_address)
IP Address: \$ip

\$message
";

#######################################
# DO NOT EDIT BELOW THIS LINE
#######################################
&parse_form;

$area = $FORM{'area'};
$name = $FORM{'name'};
$from_address = $FORM{'from'};
$subject = $FORM{'subject'};
$message = $FORM{'message'};
$id = $FORM{'id'};
$status = $FORM{'status'};

$now_date = time();

print "Content-type: text/html\n\n";

if ($area eq "")
 {
 &show_screen;
 exit;
 }

if ($area eq "status")
 {
 ($status_current, $subdir, $name, $email, $subject) = &get_ticket("$id");

 $status_desc = "Unread" if $status_current eq "N";
 $status_desc = "Opened" if $status_current eq "O";
 $status_desc = "Closed" if $status_current eq "C";

 print "<HTML><TITLE>Support Center [$status_current]</TITLE><BODY>\n";

 if ($status_current eq "")
  {
  print "Ticket #$id does not exist.</BODY></HTML>\n";
  exit;
  }

 print "<CENTER><B>Status:</B> $status_desc</CENTER><BR>\n";

 &choose_status("$id", "$name", "$email", "$subject", "replyuser", "$status_current");
 &show_message("$subdir", "$id");
 
 print "</BODY></HTML>\n";
 exit;
 }

if ($area eq "replyuser")
 {
 if ($from_address eq "" or $name eq "" or $subject eq "" or $message eq "")
  {
  print "<SCRIPT>alert('You must fill in all fields'); history.back(-1);</SCRIPT>";
  exit;
  }

 if ($from_address =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $from_address !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
  {
  print "<SCRIPT>alert('You have supplied an invalid e-mail address'); history.back(-1);</SCRIPT>";
  exit;
  }

 &save_reply("$id", "replyuser");

 print "<HTML><BODY>\n";
 print "<CENTER><H2>Support Center</H2></CENTER>\n";
 print "Ticket <A HREF=\"$cgi_url?area=status&id=$id\">$id</A> has been updated</BODY></HTML>\n";
 exit;
 }

if ($area eq "send")
 {
 if (not -e "$save_dir\/new")
  {
  $backok = mkdir("$save_dir\/new", 0777);

  if ($backok == 0)
   {
   print "<SCRIPT>alert('$save_dir\/new could not be created'); history.back(-1);</SCRIPT>";
   exit;
   }
  }

 if ($from_address eq "" or $name eq "" or $subject eq "" or $message eq "")
  {
  print "<SCRIPT>alert('You must fill in all fields'); history.back(-1);</SCRIPT>";
  exit;
  }

 if ($from_address =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $from_address !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
  {
  print "<SCRIPT>alert('You have supplied an invalid e-mail address'); history.back(-1);</SCRIPT>";
  exit;
  }

 $new_id = &get_id;
 &update_status("$new_id", "N", "$now_date", "N/A", "N/A", "$from_address", "$name", "$subject");

 &lock("$new_id");
 open(FILE, ">$save_dir\/new\/$new_id");
 print FILE "<!--BEGINMESSAGE-->\n";
 print FILE "$now_date\n";
 print FILE "$name\n";
 print FILE "$from_address\n";
 print FILE "$subject\n";
 print FILE "$message\n";
 print FILE "<!--ENDMESSAGE-->\n";
 close(FILE);
 &unlock("$new_id");

 &send_user;
 &send_admin;

 print "<SCRIPT>alert('Your message has been sent.'); history.back(-1);</SCRIPT>";
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

if ($area eq "config")
 {
 &check_login;
 &config_screen;
 exit;
 }

if ($area eq "reply")
 {
 &check_login;

 if ($status eq "D")
  {
  ($status, $date_made, $date_opened, $date_changed, $email_old, $name_old, $subject_old) = &get_status("$id");

  $subdir_new = "new" if $status eq "N";
  $subdir_new = "open" if $status eq "O";
  $subdir_new = "closed" if $status eq "C";

  unlink("$save_dir\/$subdir_new\/$id");
  unlink("$save_dir\/status\/$id");

  print "<HTML><BODY>\n";
  print "<CENTER><H2>Support Center</H2></CENTER>\n";
  print "Ticket #$id has been deleted<BR><BR>\n";
  print "<A HREF=\"$cgi_url?area=main&username=$username&password=$password\">Menu</A></BODY></HTML>\n";
  exit;
  }
  else
  {
  if ($from_address eq "" or $name eq "" or $subject eq "" or $message eq "")
   {
   print "<SCRIPT>alert('You must fill in all fields'); history.back(-1);</SCRIPT>";
   exit;
   }

  if ($from_address =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $from_address !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
   {
   print "<SCRIPT>alert('You have supplied an invalid e-mail address'); history.back(-1);</SCRIPT>";
   exit;
   }

  &save_reply("$id", "reply");

  print "<HTML><BODY>\n";
  print "<CENTER><H2>Support Center</H2></CENTER>\n";
  print "Ticket <A HREF=\"$cgi_url?area=read&id=$id&username=$username&password=$password\">$id</A> has been updated<BR><BR>\n";
  print "<A HREF=\"$cgi_url?area=main&username=$username&password=$password\">Menu</A>\n";
  print "</BODY></HTML>\n";
  exit;
  }
 }

if ($area eq "open")
 {
 &check_login;

 print "<HTML><TITLE>Support Center</TITLE><BODY>\n";
 print "<CENTER><H2>Support Center</H2>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$username&password=$password\">Menu</A><BR>\n";
 print "<B>Open Tickets</B></CENTER><BR><BR>\n";
 &show_tickets("open");
 exit;
 }

if ($area eq "closed")
 {
 &check_login;

 print "<HTML><TITLE>Support Center</TITLE><BODY>\n";
 print "<CENTER><H2>Support Center</H2>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$username&password=$password\">Menu</A><BR>\n";
 print "<B>Closed Tickets</B></CENTER><BR><BR>\n";
 &show_tickets("closed");
 exit;
 }

if ($area eq "read")
 {
 &check_login;

 print "<HTML><TITLE>Support Center</TITLE><BODY>\n";
 print "<CENTER><H2>Support Center</H2>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$username&password=$password\">Menu</A></CENTER><BR>\n";

 ($status_current, $subdir, $name, $email, $subject) = &get_ticket("$id");
 &choose_status("$id", "$name", "$email", "$subject", "reply", "$status_current");
 &show_message("$subdir", "$id");
 exit;
 }

if ($area eq "new")
 {
 &check_login;

 print "<HTML><TITLE>Support Center</TITLE><BODY>\n";
 print "<CENTER><H2>Support Center</H2>\n";
 print "<A HREF=\"$cgi_url?area=main&username=$username&password=$password\">Menu</A><BR>\n";
 print "<B>New Unread Tickets</B></CENTER><BR><BR>\n";
 &show_tickets("new");
 exit;
 }

exit;

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
   print MAIL "X-Mailer: Support Center\n";
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

if ($to_address eq "")
 {
 print "document.write('You must supply your return address using the \"to_address\" variable.');";
 exit;
 }

{
print<<END
document.write('<FORM METHOD=POST ACTION="$cgi_url">');
document.write('<INPUT TYPE=hidden NAME=area VALUE="send">');
document.write('<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>');
document.write('<TR><TD BGCOLOR="$background" COLSPAN=2><CENTER><B>Support Center</B><BR>Provided by <A HREF="http://www.cgiconnection.com" target=_blank>CGIConnection.com</A><HR></CENTER></TD></TR>');
document.write('<TR><TD BGCOLOR="$background"><B>Name:</B></TD> <TD BGCOLOR="$background"><INPUT NAME=name VALUE="$name"></TD></TR>');
document.write('<TR><TD BGCOLOR="$background"><B>E-mail:</B></TD> <TD BGCOLOR="$background"><INPUT NAME=from VALUE="$from_address"></TD></TR>');
document.write('<TR><TD BGCOLOR="$background"><B>Subject:</B></TD> <TD BGCOLOR="$background"><INPUT NAME=subject VALUE="$subject"></TD></TR>');
document.write('<TR><TD BGCOLOR="$background" VALIGN=TOP><B>Message:</B></TD> <TD BGCOLOR="$background"><TEXTAREA NAME=message COLS=$cols ROWS=$rows>$message</TEXTAREA></TD></TR>');
document.write('<TR><TD BGCOLOR="$background" COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Send"></TD></TR>');
document.write('</TABLE></FORM>');
END
}

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

sub get_id
{
my ($rndval, $passcode);
$rndval = int(rand(10000000000000));
return("$passcode$rndval");
}

sub update_status
{
my ($this_id, $status, $date_made, $date_opened, $date_changed, $email, $name, $subject) = @_;

if (not -e "$save_dir\/status")
 {
 $backok = mkdir("$save_dir\/status", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/status could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

&lock("$this_id\.status");
open (FILE, ">$save_dir\/status\/$this_id");
print FILE "$status\n";
print FILE "$date_made\n";
print FILE "$date_opened\n";
print FILE "$date_changed\n";
print FILE "$email\n";
print FILE "$name\n";
print FILE "$subject\n";
close(FILE);
&unlock("$this_id\.status");
}

sub get_status
{
my ($this_id) = @_[0];
my ($status, $date_made, $date_opened, $date_changed, $email, $name, $subject);

if (not -e "$save_dir\/status")
 {
 $backok = mkdir("$save_dir\/status", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/status could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if (not -e "$save_dir\/status\/$this_id")
 {
 return(0);
 }

&lock("$this_id\.status");
open (FILE, "<$save_dir\/status\/$this_id");
$status = <FILE>;
$date_made = <FILE>;
$date_opened = <FILE>;
$date_changed = <FILE>;
$email = <FILE>;
$name = <FILE>;
$subject = <FILE>;
close(FILE);
&unlock("$this_id\.status");

chop($status);
chop($date_made);
chop($date_opened);
chop($date_changed);
chop($email);
chop($name);
chop($subject);

return("$status", "$date_made", "$date_opened", "$date_changed", "$email", "$name", "$subject");
}

sub send_admin
{
return if $mode == 0;
return if $mode == 2;

my ($date_now, $time_now) = &date_info($now_date);
$message_admin =~ s/\$date/$date_now/ig;
$message_admin =~ s/\$time/$time_now/ig;
$message_admin =~ s/\$id/$new_id/ig;
$message_admin =~ s/\$ip/$ENV{'REMOTE_ADDR'}/ig;
$message_admin =~ s/\$name/$name/ig;
$message_admin =~ s/\$from_address/$from_address/ig;
$message_admin =~ s/\$message/$message/ig;
$message_admin =~ s/\$subject/$subject/ig;

$subject_admin =~ s/\$subject/$subject/ig;

my $result = &send_mail("$from_address", "$from_address", "$to_address", $SMTP_SERVER, "$subject_admin", "$message_admin");
}

sub send_user
{
return if $mode == 0;
return if $mode == 1;

my ($date_now, $time_now) = &date_info($now_date);
$message_user =~ s/\$date/$date_now/ig;
$message_user =~ s/\$time/$time_now/ig;
$message_user =~ s/\$id/$new_id/ig;
$message_user =~ s/\$name/$name/ig;
$message_user =~ s/\$from_address/$from_address/ig;
$message_user =~ s/\$message/$message/ig;
$message_user =~ s/\$subject/$subject/ig;
$message_user =~ s/\$ip/$ENV{'REMOTE_ADDR'}/ig;

$subject_user =~ s/\$subject/$subject/ig;

my $result = &send_mail("$to_address", "$to_address", "$from_address", $SMTP_SERVER, "$subject_user", "$message_user");
}

sub date_info
{
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(@_[0]);

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

$year += 1900;
my $date_now = "$month\-$mday\-$year";
my $time_now = "$hour\:$min\:$sec";
return("$date_now", "$time_now");
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
<TITLE>Support Center</TITLE>
<BODY>
<CENTER>
<H2>Support Center</H2>

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

my $new_files = &calculate_files("new");
my $open_files = &calculate_files("open");
my $closed_files = &calculate_files("closed");

{
print<<END
<HTML>
<TITLE>Support Center</TITLE>
<BODY>
<CENTER>
<H2>Support Center</H2>

<TABLE BORDER=0>
<TR><TD><A HREF="$cgi_url?area=new&username=$username&password=$password">View New Unread Tickets</A> ($new_files)</TD></TR>
<TR><TD><A HREF="$cgi_url?area=open&username=$username&password=$password">View Open Tickets</A> ($open_files)</TD></TR>
<TR><TD><A HREF="$cgi_url?area=closed&username=$username&password=$password">View Closed Tickets</A> ($closed_files)</TD></TR>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub show_tickets
{
my $subdir = @_[0];
my @all_files;
my ($date_this, $time_this, $datec_this, $timec_this);

splice(@all_files, 0);

opendir(FILES, "$save_dir\/$subdir");
@all_files = readdir(FILES);
closedir(FILES);

print "<CENTER><TABLE BORDER=1>\n";
print "<TR><TD><B>ID</B></TD> <TD><B>Opened</B></TD> <TD><B>Changed</B></TD> <TD><B>Name</B></TD> <TD><B>Subject</B></TD> <TD><B>E-mail</B></TD></TR>\n";

for ($j = 2; $j < @all_files; $j++)
 {
 ($status, $date_made, $date_opened, $date_changed, $email, $name, $subject) = &get_status("@all_files[$j]");
 ($date_this, $time_this) = &date_info($date_opened) if $date_opened ne "N/A";
 ($datec_this, $timec_this) = &date_info($date_changed) if $date_changed ne "N/A";
 print "<TR><TD><A HREF=\"$cgi_url?area=read&id=@all_files[$j]&username=$username&password=$password\">@all_files[$j]</A></TD> <TD>$date_this $time_this</TD> <TD>$datec_this $timec_this</TD> <TD>$name</TD> <TD>$subject</TD> <TD>$email</TD></TR>\n";
 }

print "</TABLE></CENTER>\n";
}

sub get_ticket
{
my ($this_id) = @_[0];
my ($status, $date_made, $date_opened, $date_changed, $email, $name, $subject, $subdir);

($status, $date_made, $date_opened, $date_changed, $email, $name, $subject) = &get_status("$this_id");

if ($status eq "" or not -e "$save_dir\/status\/$this_id")
 {
 print "<HTML><TITLE>Support Center</TITLE><BODY>[$status] Ticket #$this_id does not exist.</BODY></HTML>\n";
 exit;
 }

print "<HTML><TITLE>Support Center</TITLE><BODY>\n";

$subdir = "new" if $status eq "N";
$subdir = "open" if $status eq "O";
$subdir = "closed" if $status eq "C";
return("$status", "$subdir", "$name", "$email", "$subject");
}

sub show_message
{
my ($subdir, $this_id) = @_;

&lock("$this_id");
open(FILE, "<$save_dir\/$subdir\/$this_id");

until(eof(FILE))
 {
 $line = <FILE>;

 if ($line eq "<!--BEGINMESSAGE-->\n")
  {
  $now_date = <FILE>;
  $name = <FILE>;
  $from_address = <FILE>;
  $subject = <FILE>;

  chop($now_date);
  chop($name);
  chop($from_address);
  chop($subject);

  $now_date = localtime($now_date);
  print "<HR>\n";
  print "<B>Date:</B> $now_date<BR>\n";
  print "<B>From:</B> $name ($from_address)<BR>\n";
  print "<B>Subject:</B> $subject<BR><BR>\n";

  $found = 0;
  until(eof(FILE) or $found == 1)
   {
   $line = <FILE>;
   $found = 1 if $line eq "<!--ENDMESSAGE-->\n";
   $line =~ s/\n/<BR>/ig;
   print "$line\n";
   }
  }
 }

close(FILE);
&unlock("$this_id");
}

sub choose_status
{
my ($this_id, $name, $from_address, $subject, $reply_type, $status) = @_;

if ($reply_type eq "replyuser")
 {
 $username = "";
 $password = "";
 }

if ($reply_type eq "replyuser" and $status eq "C")
{
}
else
{
print<<END
<CENTER>
<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
<FORM METHOD=POST ACTION="$cgi_url">
<INPUT TYPE=hidden NAME=username VALUE="$username">
<INPUT TYPE=hidden NAME=password VALUE="$password">
<INPUT TYPE=hidden NAME=area VALUE="$reply_type">
<INPUT TYPE=hidden NAME=id VALUE="$this_id">

<TR><TD BGCOLOR="$background"><B>Name:</B></TD> <TD BGCOLOR="$background"><INPUT NAME=name VALUE="$name" SIZE=50></TD></TR>
<TR><TD BGCOLOR="$background"><B>E-mail:</B></TD> <TD BGCOLOR="$background"><INPUT NAME=from VALUE="$from_address" SIZE=50></TD></TR>
<TR><TD BGCOLOR="$background"><B>Subject:</B></TD> <TD BGCOLOR="$background"><INPUT NAME=subject VALUE="$subject" SIZE=50></TD></TR>
<TR><TD BGCOLOR="$background" COLSPAN=2><B>Message:</B><BR><TEXTAREA NAME=message COLS=$cols ROWS=$rows></TEXTAREA></TD></TR>
END
}

if ($reply_type eq "reply")
{
print<<END
<TR><TD BGCOLOR="$background" COLSPAN=2><INPUT TYPE=radio NAME=status VALUE="N"> New / Unread
 <INPUT TYPE=radio NAME=status VALUE="O" CHECKED> Open
 <INPUT TYPE=radio NAME=status VALUE="C"> Close
 <INPUT TYPE=radio NAME=status VALUE="D"> Delete</TD></TR>
END
}

if ($reply_type eq "replyuser" and $status eq "C")
{
}
else
{
print<<END
<TR><TD BGCOLOR="$background" COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Send"></TD></TR>
</FORM>
</TABLE>
</CENTER>
<BR>
END
}

}

sub save_reply
{
my ($id, $reply_type) = @_;

if (not -e "$save_dir\/open")
 {
 $backok = mkdir("$save_dir\/open", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/open could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if (not -e "$save_dir\/closed")
 {
 $backok = mkdir("$save_dir\/closed", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/closed could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

($status_current, $subdir, $name2, $email2, $subject2) = &get_ticket("$id");

my ($status_old, $date_made, $date_opened, $date_changed, $email_old, $name_old, $subject_old) = &get_status("$id");

if (($date_opened eq "N/A" or $date_opened eq "") and $status_old eq "N")
 {
 $date_opened = $now_date;
 }

if ($reply_type eq "replyuser")
 {
 $status = $status_old;
 }

$subdir_new = "new" if $status eq "N";
$subdir_new = "open" if $status eq "O";
$subdir_new = "closed" if $status eq "C";

&update_status("$id", "$status", "$date_made", "$date_opened", "$now_date", "$from_address", "$name", "$subject");
$from_old = $from_address;

if ($reply_type eq "reply")
 {
 $name = $to_name;
 $from_address = "";
 }

&lock("$id");
open(FILE, ">$save_dir\/$id");
print FILE "<!--BEGINMESSAGE-->\n";
print FILE "$now_date\n";
print FILE "$name\n";
print FILE "$from_address\n";
print FILE "$subject\n";
print FILE "$message\n";
print FILE "<!--ENDMESSAGE-->\n";

open(FILEI, "<$save_dir\/$subdir\/$id");

until(eof(FILEI))
 {
 $line = <FILEI>;
 print FILE "$line";
 }

close(FILEI);
close(FILE);

unlink("$save_dir\/$subdir\/$id");
rename("$save_dir\/$id", "$save_dir\/$subdir_new\/$id");
&unlock("$id");

$new_id = $id;
$from_address = $from_old;
&send_user;
&send_admin;
}

sub calculate_files
{
my ($subdir) = @_[0];
my @all_files;
my $num;

splice (@all_files, 0);

opendir(FILES, "$save_dir\/$subdir");
@all_files = readdir(FILES);
closedir(FILES);

$num = @all_files - 2;
return($num);
}

sub lock
{
my $lock_name = @_[0];
my $locks = "$savedir_dir\/";
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

