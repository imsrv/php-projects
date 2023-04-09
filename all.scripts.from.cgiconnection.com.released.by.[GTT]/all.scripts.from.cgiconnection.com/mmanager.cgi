#!/usr/bin/perl
#Member Manager 1.0
#Provided by CGI Connection
#http://www.CGIConnection.com

use Socket;

# Your e-mail server (usually set as blank or "localhost")
$SMTP_SERVER = "localhost";

# Location to store users
# CHMOD to 777

#Location to store users
#Eg. /path/to/users/
$user_dir = "!SAVEDIR!/";

#Location to store log files
#Eg. /path/to/logs/
$log_file = "!LOGDIR!/";

# Require a random passcode to be e-mailed to user before they can login?
$email_verify = 1; # 0 = Don't Verify E-mail / 1 = Verify E-mail

# URL to go to once user is a member
# Eg. http://www.yoursite.com
$go_to = "http://!SITEURL!";

# Background color of login screen
$background_color = "#FFFCCC";

# Administrator username
# When you first run Member Manager, the password for the administrator
# will be the same as the username you choose below.
$admin_user = "!USERNAME!";

# Your e-mail address
# Eg. your\@address.com
$from = "!EMAIL!";

# Notify yourself via e-mail of new members?
$notify_me = 1;    # 0 = NO / 1 = YES

# Subject of E-mail Verification (Only if you turn it on)
$subject = "Member Manager Verification";

# Body of E-mail Verification (Only if you turn it on)
# !passcode! !username! and !password! are replaced automatically by script
$message = "Thank you for joining our members area!

Your username is: !username!
Your password is: !password!
Your passcode is: !passcode!

You can verify your account by coming to our web site at
http://!SITEURL! and entering the above passcode
after you login.

Thank you
";

srand();

&parse_form;

if (not -e "$user_dir$admin_user")
 {
 $passcode = "";
 $username = $admin_user;
 $password = $admin_user;
 &save_user;
 }

$area = $FORM{'area'};
$subarea = $FORM{'subarea'};
$username = $FORM{'username'};
$password = $FORM{'password'};
$email = $FORM{'email'};
$first = $FORM{'first'};
$last = $FORM{'last'};
$passcode = $FORM{'passcode'};
$url = $FORM{'url'};

if ($area eq "")
 {
 print "Content-type: text/html\n\n";
 &login_screen;
 exit;
 }

if ($area eq "join")
 {
 print "Content-type: text/html\n\n";
 &join_screen;
 exit;
 }

if ($area eq "passcode")
 {
 &get_user;

 if ($passcode2 eq "")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "$username is already active.\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($passcode eq $passcode2 and $passcode2 ne "" and $passcode ne "")
  {
  $passcode = "";
  $first = $first2;
  $last = $last2;
  $email = $email2;
  $password = $password2;

  &save_user;

  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "Passcode has been verified. <a href=\"$ENV{'SCRIPT_NAME'}\">Click here</a> to login.\n";
  print "</BODY></HTML>\n";
  exit;
  }
  else
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "The passcode you have supplied is incorrect.  Be sure you entered it exactly as it was e-mailed to you.\n";
  print "</BODY></HTML>\n";
  exit;
  }
 }

if ($area eq "admin")
 {
 &get_user;

 if ("\U$password\E" ne "\U$password2\E" or $password eq "" or $username eq "")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "You have supplied and invalid username or password.\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($subarea eq "users")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color><CENTER><TABLE BORDER=0>\n";

  splice(@all_users, 0);
  opendir(USERS, "$user_dir");
  @all_users = readdir(USERS);
  closedir(USERS);

  for ($j = 2; $j < @all_users; $j++)
   {
   $tmploc = rindex(@all_users[$j], "\.");
   $tmpuser = substr(@all_users[$j], 0, $tmploc);

   if (substr(@all_users[$j], $tmploc) eq ".usr")
    {
    print "<TR><TD><a href=\"$ENV{'SCRIPT_NAME'}?area=admin&username=$username&password=$password&subarea=info&getuser=$tmpuser\">$tmpuser</a></TD></TR>\n";
    }
   }

  print "</TABLE></CENTER>";
  &admin_footer;
  print "</BODY></HTML>\n";
  exit;
  }

 if ($subarea eq "info")
  {
  $uold = $username;
  $passold = $password;
  $username = $FORM{'getuser'};
  &get_user;

  print "Content-type: text/html\n\n";
  &join_screen;
  $username = $uold;
  &admin_footer;
  exit;
  }

 if ($subarea eq "save")
  {
  $uold = $username;
  $username = $FORM{'getuser'};

  if ($FORM{'delete'} ne "")
   {
   unlink("$user_dir$username\.usr");
   print "Content-type: text/html\n\n";
   print "<HTML><BODY BGCOLOR=$background_color>\n";
   print "$username has been deleted.\n";
   $username = $uold;
   &admin_footer;
   print "</BODY></HTML>\n";
   exit;
   }

  &get_user;
  $passcode = $passcode2;
  $password = $FORM{'passnew'};
  &save_user;

  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "$username has been updated.\n";
  $username = $uold;
  &admin_footer;
  print "</BODY></HTML>\n";
  exit;
  }
 }

if ($area eq "login")
 {
 if ($username eq "" or $password eq "")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "You must enter your username and password\n";
  print "</BODY></HTML>\n";
  exit;
  }

 &get_user;

 if ("\U$password\E" ne "\U$password2\E")
  {
  $errorv = "INVALID PASSWORD: $password";
  &logit;
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "You have supplied and invalid username or password.\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($passcode2 ne "")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  &passcode_screen;
  print "</BODY></HTML>\n";
  exit;
  }

 if ("\U$admin_user\E" eq "\U$username\E")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  &admin_screen;
  print "</BODY></HTML>\n";
  exit;
  }
  else
  {
  if ($url2 eq "")
   {
   $errorv = "FORWARD TO: $go_to";
   &logit;
   print "Location: $go_to\n\n";
   }
   else
   {
   $errorv = "FORWARD TO: $url2";
   &logit;
   print "Location: $url2\n\n";
   }

  exit;
  }
 }

if ($area eq "save")
 {
 $rndval = 0;
 $passcode = "";

 if ($first eq "" or $last eq "" or $email eq "" or $username eq "" or $password eq "")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "You must fill in all fields\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $email !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "You have supplied and invalid e-mail address\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($username =~ m/[^A-Za-z0-9]/i)
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "Username can only contain alphanumeric characters (letters and numbers)\n";
  print "</BODY></HTML>\n";
  exit;
  }

 $username = "\L$username\E";

 if (-e "$user_dir$username\.usr")
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "$username is already in use.  Please choose another username.\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($email_verify == 1)
  {
  for ($j = 0; $j < 10; $j++)
   {
   until(($rndval > 96 and $rndval < 123) or ($rndval > 64 and $rndval < 91))
    {
    $rndval = int(rand(122));
    }

   $passcode .= chr($rndval);
   $rndval = 0;
   }

  $message =~ s/\!passcode\!/$passcode/gi;
  $message =~ s/\!password\!/$password/gi;
  $message =~ s/\!username\!/$username/gi;

  $result = &send_mail("$from", "$from", "$email", $SMTP_SERVER, "$subject", "$message");

  if ($notify_me == 1)
   {
   $result2 = &send_mail("$from", "$from", "$from", $SMTP_SERVER, "NEW MEMBER", "Username: $username\nPassword: $password\nPasscode: $passcode\n");
   }

  if ($result != 1)
   {
   print "Content-type: text/html\n\n";
   print "<HTML><BODY BGCOLOR=$background_color>\n";
   print "E-mail could not be sent! Please send an e-mail to <a href=\"mailto:$from\">$from</a>\n";
   print "</BODY></HTML>\n";
   exit;
   }

  &save_user;
  print "Content-type: text/html\n\n";
  print "<HTML><BODY BGCOLOR=$background_color>\n";
  print "Your passcode to login has been e-mailed to $email. <a href=\"$ENV{'SCRIPT_NAME'}\">Click here</a> to login.\n";
  print "</BODY></HTML>\n";
  exit;
  }

 &save_user;
 print "Content-type: text/html\n\n";
 print "<HTML><BODY BGCOLOR=$background_color>\n";
 print "Thank you for joining. <a href=\"$ENV{'SCRIPT_NAME'}\">Click here</a> to login.\n";
 print "</BODY></HTML>\n";
 exit;
 }


exit;

sub login_screen
{
print<<END
<CENTER>
<HTML>
<BODY BGCOLOR=$background_color>
<CENTER>
<H2>Member Manager Login</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME="area" VALUE="login">

<TR><TD><B>Username:</B></TD> <TD><INPUT NAME="username"></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME="password"></TD></TR>
<TR><TD></TD> <TD><INPUT TYPE=submit NAME="submit" VALUE="Login"></TD></TR>
<TR><TD COLSPAN=2 ALIGN=CENTER><BR><a href="$ENV{'SCRIPT_NAME'}?area=join">Join Now</a></TD></TR>

</FORM>
</TABLE>
</CENTER>
</BODY>
</HTML>
END
}

sub admin_screen
{
print<<END
<CENTER>
<HTML>
<BODY BGCOLOR=$background_color>
<CENTER>
<H2>Member Manager Administration</H2>

<TABLE BORDER=0>
<TR><TD><a href="$ENV{'SCRIPT_NAME'}?area=admin&username=$username&password=$password&subarea=users">List All Users</a></TD></TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
END
}

sub passcode_screen
{
print<<END
<CENTER>
<HTML>
<BODY BGCOLOR=$background_color>
<CENTER>
<H2>Verify Passcode</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME="area" VALUE="passcode">
<INPUT TYPE=HIDDEN NAME="username" VALUE="$username">

<TR><TD><B>PASSCODE:</B></TD> <TD><INPUT NAME="passcode"></TD></TR>
<TR><TD></TD> <TD><INPUT TYPE=submit NAME="submit" VALUE="Verify"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY>
</HTML>
END
}

sub admin_footer
{
print<<END
<BR><BR>

<CENTER>
<A HREF="$ENV{'SCRIPT_NAME'}?area=login&username=$username&password=$password">Menu</A>
</CENTER>
END
}

sub join_screen
{

{
print<<END
<CENTER>
<HTML>
<BODY BGCOLOR=$background_color>
<CENTER>
<H2>Member Manager</H2>

<TABLE BORDER=0 WIDTH=400>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">

<TR><TD><B>First Name:</B></TD> <TD><INPUT NAME="first" VALUE="$first2"></TD></TR>
<TR><TD><B>Last Name:</B></TD> <TD><INPUT NAME="last" VALUE="$last2"></TD></TR>
<TR><TD><B>E-mail Address:</B></TD> <TD><INPUT NAME="email" VALUE="$email2"></TD></TR>
END
}

if ($area ne "admin")
 {
 print "<INPUT TYPE=HIDDEN NAME=\"area\" VALUE=\"save\">\n";
 print "<TR><TD><B>Choose Username:</B></TD> <TD><INPUT NAME=\"username\" VALUE=\"$username\"></TD></TR>\n";
 print "<TR><TD><B>Choose Password:</B></TD> <TD><INPUT TYPE=password NAME=\"password\" VALUE=\"$password2\"></TD></TR>\n";
 print "<TR><TD></TD> <TD><INPUT TYPE=submit NAME=\"submit\" VALUE=\"Join\"></TD></TR>\n";
 }
 else
 {
 print "<INPUT TYPE=HIDDEN NAME=\"area\" VALUE=\"admin\">\n";
 print "<INPUT TYPE=HIDDEN NAME=\"subarea\" VALUE=\"save\">\n";
 print "<INPUT TYPE=HIDDEN NAME=\"username\" VALUE=\"$uold\">\n";
 print "<INPUT TYPE=HIDDEN NAME=\"password\" VALUE=\"$passold\">\n";
 print "<INPUT TYPE=HIDDEN NAME=\"getuser\" VALUE=\"$username\">\n";

 print "<TR><TD><B>Username:</B></TD> <TD>$username</TD></TR>\n";
 print "<TR><TD><B>Password:</B></TD> <TD><INPUT NAME=\"passnew\" VALUE=\"$password2\"></TD></TR>\n";
 print "<TR><TD COLSPAN=2>If you want this user to go to a different URL, enter it below</TD></TR>\n";
 print "<TR><TD><B>URL:</B></TD> <TD><INPUT NAME=\"url\" VALUE=\"$url2\"></TD></TR>\n";
 print "<TR><TD><B>Delete User?</B></TD> <TD><INPUT TYPE=CHECKBOX NAME=\"delete\" VALUE=\"YES\"></TD></TR>\n";

 print "<TR><TD></TD> <TD><INPUT TYPE=submit NAME=\"submit\" VALUE=\"Update\"></TD></TR>\n";
 }

print "</FORM></TABLE></CENTER>\n";
print "</BODY></HTML>\n";
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

            if ($webchatter == 1)
             {
             @chatter_lines1[$chatter_lines_count] = $name;
             @chatter_lines2[$chatter_lines_count] = $value;
             $chatter_lines_count++;
             }
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

sub save_user
{
open(FILE, ">$user_dir$username\.usr");
print FILE "$passcode\n";
print FILE "$first\n";
print FILE "$last\n";
print FILE "$email\n";
print FILE "$password\n";
print FILE "$url\n";
close(FILE);
}

sub get_user
{
if (-e "$user_dir$username\.usr")
 {
 open(FILE, "<$user_dir$username\.usr");
 $passcode2 = <FILE>;
 $first2 = <FILE>;
 $last2 = <FILE>;
 $email2 = <FILE>;
 $password2 = <FILE>;
 $url2 = <FILE>;
 close(FILE);

 chop($passcode2);
 chop($first2);
 chop($last2);
 chop($email2);
 chop($password2);
 chop($url2);
 }
 else
 {
 $errorv = "INVALID USERNAME: $username";
 &logit;
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
    print MAIL "X-Mailer: Perl Powered Socket Mailer\n";
    print MAIL "Subject: $subject\n\n";
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

sub logit
{
$ltime = time();
open(LOG, ">>$log_file");
print LOG "$ltime - $ENV{'REMOTE_ADDR'} - $errorv\n";
close(LOG);
}

