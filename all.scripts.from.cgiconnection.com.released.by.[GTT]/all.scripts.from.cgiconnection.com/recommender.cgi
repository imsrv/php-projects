#!/usr/bin/perl
# Site Recommender
# Provided by CGI Connection
# http://www.CGIConnection.com

use Socket;

&parse_form;

# Height, Width and Color of Table Box
$width = 150;
$height = 100;
$bordercolor = "#000000";
$backgroundcolor = "#CCCCCC";

# Box Functions
$box_title = "Recommend This Site";
$box_info = "Enter e-mail addresses separated by a space";
$blink_every = 10;   # Start blinking box every n seconds  (Set to 0 to turn off)
$blink_times = 5;    # Number of times to blink box
$blink_speed = 500;  # Milliseconds between each blink (1000 = 1 second)

# Your e-mail settings and information
$SMTP_SERVER = "!SMTP!";

# Your e-mail address
# Eg. your\@email.com
$from = "!EMAIL!";

$subject = "Site Recommendation";
$message = "A friend has sent this e-mail to you to recommend The
CGI Connection.

Did you know you can receive 50% of every referral you send to
the CGI Connection? You can make hundreds or even thousands of
dollars each month by just linking to them at:

http://www.CGIConnection.com

Go there now and sign up for FREE!
";

#########################################################
# DO NOT EDIT BELOW THIS LINE
#########################################################

print "Content-type: text/html\n\n";

$script = $ENV{'SCRIPT_NAME'};

if ($FORM{'emails'} eq "" and $FORM{'submit'} eq "")
 {
 &showRec;
 }
 else
 {
 splice(@all_emails, 0);
 @all_emails = split(/ /, "$FORM{'emails'}");
 $tot_mails = @all_emails;

 for ($j = 0; $j < @all_emails; $j++)
  {
  $result = &send_mail("$from", "$from", "@all_emails[$j]", $SMTP_SERVER, "$subject", "$message");
  }

 print "<SCRIPT>alert('Sent recommendation to $tot_mails people');history.back(-1);</SCRIPT>\n";
 }

exit;

sub showRec
{

{
print<<END
var blinkEvery = $blink_every;
var blinkTimes = $blink_times;
var blinkSpeed = $blink_speed;
var blinkCount = 0;
var blinkType = 0;
var didVis = 0;
var x = 0;

if (document.layers)
 {
 document.write('<layer name="recommender" z-index="90" left="0" top="0" visibility="hide"></layer>');
 }
 else if (document.all)
 {
 document.write('<div id="recommender" style="z-index:90;position:absolute;top:0;left:0;visibility:hidden;"></div>');
 }
 else if (document.getElementById)
 {
 document.write('<div id="recommender" style="z-index:90;position:absolute;top:0;left:0;visibility:hidden;"></div>');
 }

function pauseNow() {

if (blinkType == 0)
 {
 if (document.layers)
  {
  document.layers.recommender.visibility = 'hide';
  }
  else if (document.all)
  {
  document.all.recommender.style.visibility = 'hidden';
  }
  else if (document.getElementById)
  {
  document.getElementById("recommender").style.visibility = 'hidden';
  }

 blinkType = 1;
 }
 else
 {
 if (document.layers)
  {
  document.layers.recommender.visibility = 'visible';
  }
  else if (document.all)
  {
  document.all.recommender.style.visibility = 'visible';
  }
  else if (document.getElementById)
  {
  document.getElementById("recommender").style.visibility = 'visible';
  }

 blinkType = 0;
 x++;
 }

if (x < blinkTimes)
 {
 setTimeout("pauseNow()", blinkSpeed);
 }
 else
 {
 x = 0;
 }

}

function oneTime() {

if (document.layers)
 {
 document.recommender.document.write('<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><B>$box_title</B><BR><FORM METHOD=POST ACTION="$script"><FONT SIZE=-1>$box_info<BR><INPUT NAME=emails><BR><INPUT TYPE=submit NAME=submit VALUE="Recommend Now"></FONT></CENTER></FORM></td></tr></table>');
 document.recommender.document.close();
 }
 else if (document.all)
 {
 recommender.innerHTML = '<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><B>$box_title</B><BR><FORM METHOD=POST ACTION="$script"><FONT SIZE=-1>$box_info<BR><INPUT NAME=emails><BR><INPUT TYPE=submit NAME=submit VALUE="Recommend Now"></FONT></CENTER></FORM></td></tr></table>';
 }
 else if (document.getElementById)
 {
 var recommenderhtml = '<table width=$width height=$height border=2 bordercolor=$bordercolor cellpadding=0 cellspacing=0><tr valign=top><td bgcolor=$backgroundcolor><center><B>$box_title</B><BR><FORM METHOD=POST ACTION="$script"><FONT SIZE=-1>$box_info<BR><INPUT NAME=emails><BR><INPUT TYPE=submit NAME=submit VALUE="Recommend Now"></FONT></CENTER></FORM></td></tr></table>';
 newlayer = document.getElementById("recommender");
 newlayer.innerHTML = recommenderhtml;
 }
}

function blinkBox() {

if (blinkCount >= blinkEvery)
 {
 blinkCount = 0;
 setTimeout("pauseNow()",100);
 }
 else
 {
 blinkCount++;
 }

setTimeout("blinkBox()",1000);
}

function showRec() {

if (document.layers)
 {
 document.layers.recommender.top = pageYOffset;
 document.recommender.left = window.innerWidth - $width - 50;

 if (didVis == 0)
  {
  document.layers.recommender.visibility = 'visible';
  didVis = 1;
  }
 }
 else if (document.all)
 {
 document.all.recommender.style.posLeft = document.body.clientWidth - $width - 50;
 document.all.recommender.style.top = document.body.scrollTop;

 if (didVis == 0)
  {
  document.all.recommender.style.visibility = 'visible';
  didVis = 1;
  }
 }
 else if (document.getElementById)
 {
 document.getElementById("recommender").style.left = window.innerWidth - $width - 50;
 document.getElementById("recommender").style.top = document.body.scrollTop;

 if (didVis == 0)
  {
  document.getElementById("recommender").style.visibility = 'visible';
  didVis = 1;
  }
 }

setTimeout("showRec()",100);
}

setTimeout("oneTime()",100);
setTimeout("showRec()",1000);

if (blinkEvery > 0)
 {
 setTimeout("blinkBox()",1000);
 }

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

