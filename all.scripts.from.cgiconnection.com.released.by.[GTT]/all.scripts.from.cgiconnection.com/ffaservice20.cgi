#!/usr/bin/perl
# FFA Promoter 2.0
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

use Socket;
&parse_form;

&date_info;

# Location to store tempory file (chmod to 777)
# Eg. /tmp/
$temp_location = "!TMPDIR!/";

# Location to store configuration files
# Eg. /path/to/store/ffa/
$config_dir = "!SAVEDIR!/";

# Absolute path of your FFA page on your server (chmod this page to 777)
# Eg. /path/to/ffa/page/ffa.html
$page = "!SAVEDIR!/ffa.html";

# Absolute URL to your FFA page
# Eg. http://www.yoursite.com/ffa.html
$ffa_page = "http://!EXTENDEDURL!/ffa.html";

# Absolute URL to the ffaservice.cgi script
# http://www.yoursite.com/cgi-bin/ffaservice20.cgi
$ffa_url = "http://!SCRIPTURL!";

# Log file directory (Chmod directory to 777)
# Eg. /path/to/store/ffa/logs/
$log_file = "!LOGDIR!/";

# Username / Password to login to admin functions
$username = "!USERNAME!";
$password = "!PASSWORD!";

# Enter 1 to send e-mail, or 0 to turn off
$sendmails = 1;

# Your mail server (most should be set as localhost or leave blank)
$SMTP_SERVER = "!SMTP!";

# Maximum number of links to place in each category
$max_links = 100;

# Check for duplicate e-mails in log file (0 = NO / 1 = YES)
# If turned on, Max log entries should NOT be set higher
# than a couple thousand or server load will be very high
$edup_check = 1;

# Check for duplicate IP Addresses in log file (0 = NO / 1 = YES)
# If turned on, Max log entries should NOT be set higher
# than a couple thousand or server load will be very high
$idup_check = 1;

# Number of days to keep track of submissions
$max_track = 30;

# Maximum number of entries to store in logs (set to 0 for unlimited)
# All submissions are logged in separate files.  This value is to
# look up whether someone has already submitted and entry or not.
# If you receive many submissions, you may need to adjust this value
$max_log = 1000;

# DO NOT EDIT BELOW HERE
##################################################

$message = "";
$messn = "ffa.txt";
open(MSG, "<$config_dir$messn");

$from_address = <MSG>;
chop($from_address);

$subject = <MSG>;
chop($subject);

until(eof(MSG))
 {
 $line = <MSG>;
 $message .= $line;
 }

close(MSG);

if ($from_address eq "")
 {
 $from_address = "none\@$ENV{'REMOTE_ADDR'}";
 }

if ($FORM{'area'} eq "login")
 {
 print "Content-type: text/html\n\n";
 &login_screen;
 exit;
 }

if ($FORM{'area'} eq "login2")
 {
 print "Content-type: text/html\n\n";
 &check_login;
 exit;
 }

if ($FORM{'area'} eq "saveffa")
 {
 print "Content-type: text/html\n\n";
 &save_ffa;
 exit;
 }

if ($FORM{'area'} eq "emails")
 {
 print "Content-type: text/html\n\n";
 &show_emails;
 exit;
 }

if ($FORM{'area'} eq "newpage")
 {
 &new_ffapage;
 open(NFFA, ">$page");
 close(NFFA);
 &check_ffapage;
 exit;
 }

if ($FORM{'area'} eq "logs")
 {
 &show_logs;
 exit;
 }

if ($FORM{'area'} eq "download")
 {
 &download;
 exit;
 }

if ($FORM{'area'} eq "block")
 {
 &block;
 exit;
 }

if ($FORM{'area'} eq "block2")
 {
 &block2;
 exit;
 }

$message .= "\n\nYou are receiving this message from a submission to our FFA
page by $ENV{'REMOTE_ADDR'}
";

# DO NOT EDIT BELOW THIS LINE
############################################################

$title   = $FORM{'title'};
$url     = $FORM{'url'};
$email   = $FORM{'email'};
$section = $FORM{'section'};
$refer   = $ENV{'HTTP_REFERER'};
$remote  = $ENV{'REMOTE_ADDR'};

&check_ffapage;

if ($url eq "" or $title eq "" or $email eq "" or $section eq "")
 {
 print "Content-type: text/html\n\n";
 print "Required fields not filled in\n";
 exit;
 }

if ($email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $email !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
 {
 print "Content-type: text/html\n\n";
 print "<html><body>\n";
 print "You have supplied an invalid e-mail address!\n";
 print "</body></html>\n";
 exit;
 }

if ($edup_check == 1 or $idup_check == 1)
 {
 $lock_name = "ffalog.lock";
 &lock;
 
 $log_name = "ffa.log";
 open(ILOG, "<$log_file$log_name");

 until(eof(ILOG))
  {
  $line = <ILOG>;
  chop($line);

  splice(@check_line, 0);
  @check_line = split(/ - /, $line);
  
  if ($edup_check == 1 and "\L@check_line[3]\E" eq "\L$email\E")
   {
   print "Content-type: text/html\n\n";
   print "<html><body>\n";
   print "Sorry, your e-mail address is already on file.\n";
   print "</body></html>\n";
  
   close(ILOG);
   &unlock;
   exit;
   }

  if ($idup_check == 1 and "\L@check_line[2]\E" eq "\L$ENV{'REMOTE_ADDR'}\E")
   {
   print "Content-type: text/html\n\n";
   print "<html><body>\n";
   print "Sorry, your IP Address is already on file.\n";
   print "</body></html>\n";
  
   close(ILOG);
   &unlock;
   exit;
   }
  }

 close(ILOG);
 &unlock;
 }

$config_name = "block.ffa";

if (-e "$config_dir$config_name")
 {
 open(CIN, "<$config_dir$config_name");

 until(eof(CIN))
  {
  $line = <CIN>;
  chop($line);

  $line =~ s/\cM//g;

  if ($email =~ /$line/ig and $line ne "")
   {
   print "Content-type: text/html\n\n";
   print "<html><body>\n";
   print "Sorry, submissions are not accepted from this address.\n";
   print "</body></html>\n";
   close(CIN);
   exit;
   }
  }

 close(CIN);
 }

$counter = 0;
$total_links = 0;
$startcounter = 0;

$lock_name = "ffa.lock";
&lock;

open(FFA, "<$page");
@all_lines = <FFA>;
close(FFA);

for ($j = 0; $j < @all_lines; $j++)
 {
 $count_link = 0;
 $line = @all_lines[$j];
 chop($line);

 if ($startcounter == 1 and $line ne "")
  {
  $section_links++; 
  $total_links++;
  }

 $section2 = $FORM{'section'};
 $section2 =~ s/ //g;
 $secp = substr($section2, 0, 4);
 $section_test = "\L<!--$secp-->\E";

 if (substr($line, 0, 13) eq "<!--number-->")
  {
  $numline_val = $counter;
  $counter++;
  $count_link = 1;
  }

 if (substr($line, 0, 11) eq "<!--time-->")
  {
  $timeline_val = $counter;
  $counter++;
  $count_link = 1;
  }

 if ($line eq "" and $startcounter == 1)
  {
  $count_link = 1;
  }

 if ($count_link == 0)
  {
  @all_links[$counter] = "$line";
  $counter++;
  }

 if ($line eq "<ul>")
  {
  $startcounter = 1;
  $start_line = $counter;
  $section_links = 0;
  }

 if ($line eq "</ul>")
  {
  $section_links = $section_links - 2;
  $total_links = $total_links - 2;
  $startcounter = 0;

  if ($section_links >= $max_links and $found_section == 1)
   {
   $newstart = $start_line + $max_links + 1;
   @all_links[$newstart] = "</ul>";
   $counter = $start_line + $max_links + 2;
   $total_links = $total_links - 1;
   }

  $found_section = 0;
  }

 if ($section_test eq $line)
  {
  $found_section = 1;
  @all_links[$counter] = "<a href=\"$FORM{'url'}\">$FORM{'title'}</a><br>\n";
  $counter++;
  $total_links++;
  }
 }

$nowtime = localtime(time());
@all_links[$timeline_val] = "<!--time--><b>Last link added on $nowtime by $ENV{'REMOTE_ADDR'}</b><br><br><hr><br>";
@all_links[$numline_val] = "<!--number--><b>Currently there are <i>$total_links</i> links on this page, <a href=\"#addyours\">click here to add yours</a>!</b><br><br>";

open(FFA, ">$page");

for ($j = 0; $j < $counter; $j++)
 {
 print FFA "@all_links[$j]\n";
 }

close(FFA);

$lock_name = "ffa.lock";
&unlock;

if ($sendmails == 1)
 {
 $count_log = 0;
 $result = &send_mail("$from_address", "$from_address", "$FORM{'email'}", $SMTP_SERVER, "$subject", "$message");
 $tmpname = "ffa\.$$";
 }

$lock_name = "ffalog.lock";
&lock;
 
$log_name = "ffa.log";
open(ILOG, "<$log_file$log_name");
open(OLOG, ">$temp_location$tmpname");
print OLOG "$date_now - $time_now - $ENV{'REMOTE_ADDR'} - $FORM{'email'} - $result\n";
 
until(eof(ILOG) or $count_log == ($max_log - 1))
 {
 $line = <ILOG>;
 print OLOG "$line";
 $count_log++;
 }
 
close(OLOG);
close(ILOG);

$log_name = "ffa.log";
rename("$temp_location$tmpname", "$log_file$log_name");
&unlock;

$lock_name = "$date_now.ffalock";
&lock;

open(OLOG, ">>$log_file$date_now\.ffa");
print OLOG "$date_now - $time_now - $ENV{'REMOTE_ADDR'} - $FORM{'email'} - $result\n";
close(OLOG);

&unlock;

$lock_name = "track.lock";
&lock;

$foundit = 0;
$config_name = "track.ffa"; 
splice(@ffa_date, 0);
splice(@ffa_count, 0);
$ffac = 0;

open(ILOG, "<$config_dir$config_name");

until(eof(ILOG))
 {
 $line = <ILOG>;
 splice(@tmpl, 0);
 @tmpl = split(/ - /, $line);

 if (@tmpl[0] eq $date_now)
  {
  $foundit = 1;
  $tmpcount = @tmpl[1];
  $tmpcount++;
  @tmpl[1] = $tmpcount;
  }

 if ($ffac > ($max_track - 1))
  {
  unlink("$log_file@tmpl[0]\.ffa");
  }
  else
  {
  if (@tmpl[1] > 0)
   {
   @ffa_date[$ffac] = @tmpl[0];
   @ffa_count[$ffac] = @tmpl[1];
   $ffac++;
   }
  }
 }

close(ILOG);
open(OLOG, ">$config_dir$config_name");

if ($foundit == 0)
 {
 print OLOG "$date_now - 1\n";
 }

for ($j = 0; $j < @ffa_date; $j++)
 {
 print OLOG "@ffa_date[$j] - @ffa_count[$j]\n"; 
 }

close(OLOG);
&unlock;

print "Location: $ffa_page\n\n";

exit;

sub new_page
{
$lock_name = "ffa.lock";
&lock;

open(FFA, ">$page");

{
print FFA<<END
<html>
<head>
<title>Welcome To Our Free For All Links Page</title>
</head>

<body bgcolor=white link=0000dd vlink=000077><center><table border=0 width=500><tr><td><br>

<center><b>Welcome To Our Free For All Links Page</b></center><br><br>

<b>Welcome to our Free For All Links page!</b> Below is a free for all list of links in several popular categories, 
and you're welcome to add yours to our ever-growing list. Just be sure to post in the most appropriate 
category, and please don't add links to offensive or adult-related sites. Thanks!<br><br><hr><br>

<!--number-->
<!--time-->

<b>If you'd like, click one of these links to be taken directly to a specific section!</b><br><br>

<center><table width=100% border=0><tr>
<td align=left><a href="#business">Business</a></td>
<td align=center><a href="#computers">Computers</a></td>
<td align=center><a href="#education">Education</a></td>
<td align=center><a href="#entertainment">Entertainment</a></td>
<td align=right><a href="#government">Government</a></td></tr><tr>
<td align=left><a href="#health">Health</a></td>
<td align=center><a href="#miscellaneous">Miscellaneous</a></td>
<td align=center><a href="#personal">Personal</a></td>
<td align=center><a href="#recreation">Recreation</a></td>
<td align=right><a href="#webstuff">Web Stuff</a></td>
</tr></table></center><br><br>


<a name="business"><b>Business</b></a><p>
<ul>
<!--busi-->
</ul>

<a name="computers"><b>Computers</b></a><p>
<ul>
<!--comp-->
</ul>

<a name="education"><b>Education</b></a><p>
<ul>
<!--educ-->
</ul>

<a name="entertainment"><b>Entertainment</b></a><p>
<ul>
<!--ente-->
</ul>

<a name="government"><b>Government</b></a><p>
<ul>
<!--gove-->
</ul>

<a name="health"><b>Health</b></a><p>
<ul>
<!--heal-->
</ul>

<a name="miscellaneous"><b>Miscellaneous</b></a><p>
<ul>
<!--misc-->
</ul>

<a name="personal"><b>Personal</b></a><p>
<ul>
<!--pers-->
</ul>

<a name="recreation"><b>Recreation</b></a><p>
<ul>
<!--recr-->
</ul>

<a name="webstuff"><b>Web Stuff</b></a><p>
<ul>
<!--webs-->
</ul>

<a name="addyours"><br></a>

<br>

<b>Add your link!</b> Your email address is required, but not shown or given out to anyone.<br><br>

<form method=POST action="$ffa_url">

<input type=text name="title" size=60 maxlength=60> <b>Web Site Title</b><br>
<input type=text name="url" size=60 value="http://"> <b>Web Site URL</b><br>
<input type=text name="email" size=60 maxlength=60> <b>Email Address</b><br><br>

<b>Please select an appropriate section for your listing:</b>

<select name="section">
<option>Business</option>
<option>Computers</option>
<option>Education</option>
<option>Entertainment</option>
<option>Government</option>
<option>Health</option>
<option selected>Miscellaneous</option>
<option>Personal</option>
<option>Recreation</option>
<option>Web Stuff</option>
</select><br><br>

<center><input type=submit value="Add My Link"> <input type=reset value="Clear Form"></center></form>

</td></tr></table></center></body></html>
END
}

close(FFA);
&unlock;
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

sub lock
{
$locks = $temp_location;
$lock_timer = 0;
$lock_timer_stop = 0;
$lock_passed = 0;

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
  print LOCKIT "LOCKED";
  close (LOCKIT);
  }
  else
  {
  $idle_max = 30;
  splice(@lock_info, 0);
  @lock_info=stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks)=@lock_info;

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
$locks = $temp_location;
unlink ("$locks$lock_name");
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

    print MAIL "Content-type: text/html\r\n";
    $_ = <MAIL>;

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

sub date_info
{
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time());

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
$date_now = "$month\-$mday\-$year";
$time_now = "$hour\:$min\:$sec";
}

sub login_screen
{

{
print<<END
<HTML><BODY>
<CENTER>
<TITLE>FFA Configuration</TITLE>
<H2>FFA Configuration</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
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

sub check_login
{

if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }


{
print<<END
<HTML><BODY>
<CENTER>
<TITLE>FFA Configuration</TITLE>
<H2>FFA Configuration</H2>

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR BGCOLOR=#CCCCCC><TD COLSPAN=2 ALIGN=CENTER><A HREF="$ENV{'SCRIPT_NAME'}?area=emails&username=$FORM{'username'}&password=$FORM{'password'}">Last 100 Submissions</A></TD></TR>
<TR BGCOLOR=#CCCCCC><TD COLSPAN=2 ALIGN=CENTER><A HREF="$ENV{'SCRIPT_NAME'}?area=logs&username=$FORM{'username'}&password=$FORM{'password'}">Show / Download Log Files</A></TD></TR>
<TR BGCOLOR=#CCCCCC><TD COLSPAN=2 ALIGN=CENTER><A HREF="$ENV{'SCRIPT_NAME'}?area=block&username=$FORM{'username'}&password=$FORM{'password'}">E-mail / Domain Block List</A></TD></TR>
<TR BGCOLOR=#CCCCCC><TD COLSPAN=2 ALIGN=CENTER><A HREF="$ENV{'SCRIPT_NAME'}?area=newpage&username=$FORM{'username'}&password=$FORM{'password'}">Regenerate FFA Page</A></TD></TR>
<TR BGCOLOR=#CCCCCC><TD COLSPAN=2 ALIGN=CENTER><A HREF="$ffa_page" target=_blank>Show FFA Page</A></TD></TR>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="saveffa">
<INPUT TYPE=hidden NAME=username VALUE="$FORM{'username'}">
<INPUT TYPE=hidden NAME=password VALUE="$FORM{'password'}">
<TR><TD COLSPAN=2><HR></TD></TR>
<TR><TD><B>Return Address:</B></TD> <TD><INPUT NAME=raddress VALUE="$from_address" SIZE=30></TD></TR>
<TR><TD><B>Subject:</B></TD> <TD><INPUT NAME=subject VALUE="$subject" SIZE=30></TD></TR>
<TR><TD VALIGN=TOP><B>Body:</B></TD> <TD><TEXTAREA NAME=body ROWS=20 COLS=40>$message</TEXTAREA></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Save"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}


sub save_ffa
{

if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

$messn = "ffa.txt";
open(MSG, ">$config_dir$messn");
print MSG "$FORM{'raddress'}\n";
print MSG "$FORM{'subject'}\n";
print MSG "$FORM{'body'}\n";
close(MSG);

print "Saved!<BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
}

sub show_emails
{

if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

$countm = 0;

print "<HTML><TITLE>FFA Configuration</TITLE><BODY><CENTER><H2>Last 100 Submissions</H2><TABLE BORDER=1>\n";

$lock_name = "ffalog.lock";
&lock;
 
$log_name = "ffa.log";
open(EML, "<$log_file$log_name");

until(eof(EML) or $countm >= 100)
 {
 $line = <EML>;
 chop($line);

 splice(@aline, 0);
 @aline = split(/ - /, $line);
 print "<TR><TD>@aline[0]</TD> <TD>@aline[1]</TD> <TD>@aline[2]</TD> <TD>@aline[3]</TD></TR>\n";
 $countm++;
 }

close(EML);
&unlock;

print "</TABLE><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A></CENTER></BODY></HTML>\n";
}

sub check_ffapage
{
$size = -s "$page";

if ((not -e "$page") or $size == 0)
 {
 &new_page;
 $size = -s "$page";

 if ((not -e "$page") or $size == 0)
  {
  print "Content-type: text/html\n\n";
  print "Could not create FFA page at $page\n";
  exit;
  }
  else
  {
  print "Location: $ffa_page\n\n";
  exit;
  }
 }
}

sub new_ffapage
{
if ($username ne $FORM{'username'})
 {
 print "Content-type: text/html\n\n";
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Content-type: text/html\n\n";
 print "Invalid Password!\n";
 exit;
 }
}

sub download
{
if ($username ne $FORM{'username'})
 {
 print "Content-type: text/html\n\n";
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Content-type: text/html\n\n";
 print "Invalid Password!\n";
 exit;
 }

splice(@fileinfo, 0);

$log_name = "$FORM{'logfile'}\.ffa";
$tempname = "$log_file$log_name";
@fileinfo=stat("$tempname");
($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @fileinfo;

$dl_name = "$FORM{'logfile'}\.ffa";

print "Content-length: $size2\n";
print "Content-type: application/octect-stream\n";
print "Content-disposition: attachment;filename=$dl_name\n\n";

$dl = 0;
$totalread = 0;
$btr = 4096;
open (DL, "<$tempname");

until ($dl == 1)
 {
 $read = "";

 if ($totalread >= $size2)
  {
  $btr = $totalread - $size2;
  $dl = 1;
  }

 sysread (DL, $read, $btr);
 print "$read";

 $totalread = $totalread + $btr;
 }

close(DL);
}

sub block
{
print "Content-type: text/html\n\n";
print "<HTML><BODY><CENTER>\n";
 
if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

$config_name = "block.ffa";

print "<H2>E-mail / Domain Block List</H2>\n";
print "<FORM METHOD=POST ACTION=\"$ffa_url\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$FORM{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$FORM{'password'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"block2\">\n";
print "<TEXTAREA NAME=block ROWS=10 COLS=30>\n";

if (-e "$config_dir$config_name")
 {
 open(CIN, "$config_dir$config_name");

 until(eof(CIN))
  {
  $line = <CIN>;
  chop($line);
  print "$line\n";
  }

 close(CIN);
 }

print "</TEXTAREA><BR><INPUT TYPE=SUBMIT NAME=submit VALUE=\"Submit\"></FORM>\n";
print "<BR><BR><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
print "</CENTER></BODY></HTML>\n";
}

sub block2
{
print "Content-type: text/html\n\n";

if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

$config_name = "block.ffa";

open(CIN, ">$config_dir$config_name");
print CIN "$FORM{'block'}\n";
close(CIN);

print "Saved!<BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
}

sub show_logs
{
if ($username ne $FORM{'username'})
 {
 print "Content-type: text/html\n\n";
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Content-type: text/html\n\n";
 print "Invalid Password!\n";
 exit;
 }

print "Content-type: text/html\n\n";
print "<HTML><BODY><CENTER><H2>Download Log Files</H2>\n";
print "<TABLE BORDER=1>\n";
print "<TR><TD><B>Date</B></TD> <TD><B>Entries</B></TD></TR>\n";

$lock_name = "track.lock";
&lock;

$config_name = "track.ffa"; 
open(ILOG, "<$config_dir$config_name");

until(eof(ILOG))
 {
 $line = <ILOG>;
 chop($line);
 splice(@tmpl, 0);
 @tmpl = split(/ - /, $line);
 
 if (@tmpl[1] > 0)
  { 
  print "<TR><TD><A HREF=\"$ENV{'SCRIPT_NAME'}?area=download&logfile=@tmpl[0]&username=$FORM{'username'}&password=$FORM{'password'}\">@tmpl[0]</A></TD> <TD>@tmpl[1]</TD></TR>\n";
  }
 }

close(ILOG);
&unlock;

print "</TABLE>\n";
print "<BR><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Main Menu</A>\n";
print "</CENTER></BODY></HTML>\n";
}
