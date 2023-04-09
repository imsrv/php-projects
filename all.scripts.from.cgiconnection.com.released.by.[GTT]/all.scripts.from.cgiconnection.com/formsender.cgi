#!/usr/bin/perl
$| = 1;
#Form Sender 1.0
#Provided by CGI Connection
#http://www.CGIConnection.com

use Socket;

# SMTP server (set to localhost or leave blank)
$SMTP_SERVER = "!SMTP!";

# Subject of e-mail message
$subject = "Form Sender Message";

##################################################
# DO NOT EDIT BELOW THIS LINE
##################################################
$timenow = localtime(time());
splice(@all_pairs1, 0);
splice(@all_pairs2, 0);
$aps = 0;

&parse_form;

if ($FORM{'recipient'} eq "")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>\n";
 print "You must supply the recipient's e-mail address (where you want the e-mail's sent).\n";
 print "</BODY></HTML>\n";
 exit;
 }

$body = "Submitted on $timenow\n";
$body .= "From IP Address: $ENV{'REMOTE_ADDR'}\n\n";

for ($j = 0; $j < @all_pairs1; $j++)
 {
 $body .= "@all_pairs1[$j] \= @all_pairs2[$j]\n\n";
 }

if ($FORM{'from'} ne "")
 {
 $from = $FORM{'from'};
 }

if ($FORM{'subject'} ne "")
 {
 $subject = $FORM{'subject'};
 }

$result = &send_mail("$FORM{'recipient'}", "$FORM{'recipient'}", "$FORM{'recipient'}", $SMTP_SERVER, "$subject", "$body");

if ($result == 1)
 {
 if ($FORM{'returnpage'} ne "")
  {
  print "Location: $FORM{'returnpage'}\n\n";
  }
  else
  {
  print "Content-type: text/html\n\n";
  print "<HTML><BODY>\n";
  print "Thank you for your submission.\n";
  print "</BODY></HTML>\n";
  }

 exit;
 }
 else
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>\n";
 print "Form could not be sent. $result\n";
 print "</BODY></HTML>\n";
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
   print MAIL "X-Mailer: Form Sender\n";
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

  if ($name ne "returnpage" and $name ne "recipient" and $name ne "subject" and $name ne "$from")
   {
   @all_pairs1[$aps] = "$name";
   @all_pairs2[$aps] = $value;
   $aps++;
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
