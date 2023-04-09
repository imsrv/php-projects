#!/usr/bin/perl
#E-mail A Page
#Provided by CGI Connection
#http://www.cgiconnection.com

use Socket;
use LWP::Simple qw($ua getstore);
srand();
$rand_num = int(rand(100000));

# Your SMTP (mail) server
$SMTP_SERVER = "!SMTP!";

# How you want the e-mails that are sent out to read
$subject = "Check this out";

# The address you want the e-mail addressed from
# Eg. you\@yoursite.com
$from_address = "!EMAIL!";

# Where to store temporary files and logs
# Eg. /path/to/save/files
$save_dir = "!SAVEDIR!";

# Log file name
$log_name = "epage.log";

# Number of seconds to stop trying to retrieve page
$timeout = 10;

# This is the information that the visitor will see
$newline = "Send this page to a friend<BR><BR>";
$newline .= "<FORM NAME=epage$rand_num METHOD=POST ACTION=$ENV{'SCRIPT_NAME'}>";
$newline .= "<INPUT TYPE=HIDDEN NAME=area VALUE=\"send\">";
$newline .= "<INPUT TYPE=HIDDEN NAME=url VALUE=\"\">";
$newline .= "<B>E-mail:</B> <INPUT NAME=email><BR>";
$newline .= "<INPUT TYPE=submit NAME=submit VALUE=\"Send\">";
$newline .= "</FORM>";

# Default font to use
$font = "Arial";

#########################################
# DO NOT EDIT BELOW THIS LINE
#########################################

&parse_form;

$to_address = $FORM{'email'};
$url = $FORM{'url'};
$area = $FORM{'area'};
$mode = $FORM{'mode'};
$backgroundcolor = $FORM{'background'};
$bordercolor = $FORM{'border'};
$width = $FORM{'width'};
$height = $FORM{'height'};
$ua->timeout($timeout);

$mode = 0 if $mode eq "";
$backgroundcolor = "CCCCCC" if $backgroundcolor eq "";
$bordercolor = "000000" if $bordercolor eq "";
$width = 200 if $width eq "";
$height = 50 if $height eq "";

print "Content-type: text/html\n\n";

if ($area eq "")
 {
 &show_box;
 exit;
 }

if ($area eq "send")
 {
 if ($to_address =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $to_address !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
  {
  $status = "You have entered and invalid e-mail address";
  print "<HTML><BODY><SCRIPT>alert('$status');history.back(-1);</SCRIPT></BODY></HTML>\n";
  exit;
  }

 $now_temp = "$save_dir\/$$";
 getstore($url, "$now_temp") || die("Cannot get $url");

 $body = "";
 open(FILE, "<$now_temp");

 until(eof(FILE))
  {
  $line = <FILE>;
  $body .= $line;
  }

 close(FILE);
 unlink("$now_temp");

 ($date_now, $time_now) = &convert_time(time());

 $result = &send_mail("$from_address", "$from_address", "$to_address", $SMTP_SERVER, "$subject", "$body");

 if ($result == 1)
  {
  $status = "This page has been sent to $to_address";
  }
  else
  {
  $status = "An error occurred: $result";
  }

 open(FILE, ">>$save_dir\/$log_name");
 print FILE "$date_now - $time_now - $to_address - $result - $url\n";
 close(FILE);

 print "<HTML><BODY><SCRIPT>alert('$status');history.back(-1);</SCRIPT></BODY></HTML>\n";
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
   print MAIL "X-Mailer: E-Page Mailer\n";
   print MAIL "Subject: $subject\n";
   print MAIL "Content-type: text/html\n\n";
   print MAIL "<BASE HREF=\"$url\">\n";
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
          $FORM{$name} = "$FORM{$name} \|\| $value";
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
$popwidth = $width + 50;
$popheight = $height + 100;

{
print<<END
var mode = $mode;

if (mode == 1)
 {
 var htmlcode = '<TABLE BORDER=2 WIDTH=$width HEIGHT=$height BORDERCOLOR=#$bordercolor CELLSPACING=0 CELLPADDING=0><TR><TD VALIGN=TOP BGCOLOR=#$backgroundcolor><CENTER><FONT FACE=\"$font\">$newline<BR>[ <a href=javascript:closeWindow();>Close</a> ]</FONT></CENTER></TD></TR></TABLE>';

 if (document.layers)
  {
  document.write('<layer name="allheadings$rand_num" z-index="90" left="0" top="0" visibility="visible"></layer>');
  }                            
  else if (document.all)
  {
  document.write('<div id="allheadings$rand_num" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
  }
  else if (document.getElementById)
  {
  document.write('<div id="allheadings$rand_num" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
  }
 }
 else
 {
 var htmlcode = '<TABLE BORDER=2 WIDTH=$width HEIGHT=$height BORDERCOLOR=#$bordercolor CELLSPACING=0 CELLPADDING=0><TR><TD VALIGN=TOP BGCOLOR=#$backgroundcolor><CENTER><FONT FACE=\"$font\">$newline</FONT></CENTER></TD></TR></TABLE>';
 }

function moveit() {

if (document.layers)
 {
 document.layers.allheadings$rand_num.top = pageYOffset;
 document.allheadings$rand_num.left = window.innerWidth - $width - 20;
 }
 else if (document.all)
 {
 document.all.allheadings$rand_num.style.posLeft = document.body.clientWidth - $width - 20;
 document.all.allheadings$rand_num.style.top = document.body.scrollTop;
 }
 else if (document.getElementById)
 {
 document.getElementById("allheadings$rand_num").style.left = window.innerWidth - $width - 20;
 document.getElementById("allheadings$rand_num").style.top = document.body.scrollTop;
 }

setTimeout("moveit()",100);
}

function closeWindow() {

if (document.layers)
 {
 document.layers.allheadings$rand_num.visibility = "hidden";
 }
 else if (document.all)
 {
 document.all.allheadings$rand_num.style.visibility = "hidden";
 }
 else if (document.getElementById)
 {
 document.getElementById("allheadings$rand_num").style.visibility = "hidden";
 }
}

function oneTime() {

if (document.layers)
 {
 document.allheadings$rand_num.document.write(htmlcode);
 document.allheadings$rand_num.document.close();
 }
 else if (document.all)
 {
 allheadings$rand_num.innerHTML = htmlcode;
 }
 else if (document.getElementById)
 {
 newlayer = document.getElementById("allheadings$rand_num");
 newlayer.innerHTML = htmlcode;
 }

document.epage$rand_num.url.value = window.location;
setTimeout("moveit()",100);
}

if (mode == 2)
{
var yourLocation = window.location;

document.onkeypress = function (evt) {
  var r = '';
  if (document.all) {
    r += event.shiftKey ? 'SHIFT' : '';
    r += event.keyCode;
  }
  else if (document.getElementById) {
    r += evt.shiftKey ? 'SHIFT' : '';
    r += evt.charCode;
  }
  else if (document.layers) {
    r += evt.modifiers & Event.SHIFT_MASK ? 'SHIFT' : '';
    r += evt.which;
  }

  if (r == 'SHIFT69' || r == '69')
   {
   var IWindow;
   EWindow = window.open('',IWindow++,'width=$popwidth,height=$popheight,resizable=yes,scrollbars=no');
   EWindow.document.write('<HTML><TITLE>E-mail A Page</TITLE><BODY><CENTER>');
   EWindow.document.write(htmlcode);
   EWindow.document.write('</CENTER></BODY></HTML>');
   EWindow.document.epage$rand_num.url.value = yourLocation;
   }

  return true;
  }
}

if (mode == 1)
 {
 setTimeout("oneTime()",100);
 }

if (mode == 0)
 {
 document.write(htmlcode);
 document.epage$rand_num.url.value = window.location;
 }
END
}

}


sub convert_time
{
my ($pass) = $_[0];
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

$year += 1900;
$date_now = "$month\-$mday\-$year";
$time_now = "$hour\:$min\:$sec";
return ($date_now,$time_now);
}
