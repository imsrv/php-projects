#!/usr/bin/perl
# Fetch Email

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
require 'localmbox.pm';

use Net::POP3;
use Mail::Internet;
use Net::SMTP;
use Time::CTime;
use Time::ParseDate;

&config;
&javascript;
&reademail;
&htmlend;
exit;

sub reademail
 {


&htmlheader("Readmail");

$cgi->delete_all();
$cgi->param('username', "$username");
$cgi->param('pop3host', "$pop3host");
$cgi->param('getemail',"1");
my $refreshurl = $cgi->self_url;

print "<img src=\"imgs/alert.gif\" hspace=\"3\">$status<BR>" if($status);

$localmail = 1 if($localmbox);

if($localmail)  {
$count = newbox("Inbox","$Bin/users/$confdir") if(!$localmbox);
$count = newbox("$localmbox","$Bin/users/$confdir/mbox") if($localmbox);
$email = readbox($msgnum);
                }

else    {
&pop3connect;
$email = $pop3->get($msgnum);
$count = ($pop3->popstat)[0];
        }

if($mime)       {
use MIME::Parser;               # Load MIME module!
show_mime($email);
                }

else {
my $message = new Mail::Internet $email;
my $head = $message->head();

$subject = parseheader($head->get('Subject'));
$from = from_header(parseheader($head->get('From')),1);
$to = parseheader($head->get('To'));
$date = parseheader($head->get('Date'));
$cc = parseheader($head->get('Cc'));

    print "<table bgcolor=\"$secondarycolor\" cellspacing=0 cellpadding=2 border=0 width=100%>";
    print "<tr><td align=right><b><small>From:</small></b></td><td><small>$from</small></td>";
    print "<td align=right><small>$date</small></td></tr>";
    print "<tr><td align=right valign=top><b><small>Subject:</small></b></td><td width=100% colspan=2><small>$subject</small></td></tr>";
    print "<tr><td align=right valign=top><b><small>To:</small></b></td><td colspan=2><small>$to</small></td></tr>" if ($to ne "<br>");
    print "<tr><td align=right valign=top><b><small>CC:</small></b></td><td colspan=2><small>$cc</small></td></tr>" if ($cc);
    print "</table><p>";
 

# Need a lightwight MIME module here!

foreach $line (@{$message->body})       {
          
$nobr = 1 if($line =~ /Content-Type: text\/html/);

#$line =~ s|&|&amp;|g;
$line =~ s|\n|<br>\n|g if(!$nobr);  
$line =~ s|(https?://[a-z\-0-9/~._,\#=;?&]+[a-z\-0-9/_])|<a href="$1" target=_new><font color=\"$quotecolor\"><tt>$1</tt></font></a>|igm;
$line =~ s|([^/>])(www\.[a-z\-0-9/~._,\#=;?&]+\.[a-z\-0-9/_]+)|$1<a href="http://$2" target=_new><tt>$2</tt></a>|igm;
$line =~ s|<a href="(.+?)&gt"><tt>(.+?)&gt</tt></a>;|<a href="$1" target=_new><font color=\"$quotecolor\"><tt>$2</tt></font></a>&gt;|igm;
$line =~ s|(ftp://[a-z\-0-9/~._,]+[a-z\-0-9/_])|<a href="$1"><font color=\"$quotecolor\"><tt>$1</tt></font></a>|igm;
$line =~ s|([a-z\-0-9._,]+\@[a-z.]+[a-z])|<a href="mailto:$1"><font color=\"$quotecolor\"><tt>$1</tt></font></a>|igm;

$line =~ s/=20//g if ($nobr);
$line =~ s/3D//g if ($nobr);

if($line =~ /^>/) { print "<font color=\"$quotecolor\">$line</font>"; }
else { print "$line"; }
                                                }
        }

print<<_EOF;
<table bgcolor="$secondarycolor" cellspacing=0 cellpadding=2 border=0 width=100%>
<tr><td>
<b><small>
<a href="compose.pl?username=$username&pop3host=$pop3host&password=$password&msgtype=reply&msgnum=$msgnum" 
onMouseOver="MM_displayStatusMsg('Reply to email');return document.MM_returnValue">
Reply</a>&nbsp;
<a href="compose.pl?username=$username&pop3host=$pop3host&password=$password&msgtype=forward&msgnum=$msgnum" onMouseOver="MM_displayStatusMsg('Forward email message');return document.MM_returnValue">
Forward</a>
<a href="addressbook.pl?username=$username&pop3host=$pop3host&password=$password" onMouseOver="MM_displayStatusMsg('Add to addressbook');return document.MM_returnValue">
Add to Addressbook</a>


</td>
<td align=right><small>
<a href="movemsg.pl?username=$username&pop3host=$pop3host&msgdelete=$msgnum&folder=Trash">
<img border=0 src="imgs/trash.gif" width="16" height="16" alt="Delete Message $msgnum"></a>
&nbsp;
<a href="showmail.pl?username=$username&pop3host=$pop3host">
<img alt="Read new email ($count new msgs)" src=\"imgs/newemail.gif\" border=0 height=9 width=13></a>
<B>$count</B> msgs<BR></small></td></tr>
</table><p>
_EOF

 }

# Parse it as a MIME message;
sub show_mime {                      
  my($message) = @_;

  my $parser = new MIME::Parser;
  $parser->output_to_core('NONE');
  $parser->output_dir("$Bin/mime-tmp");
  $parser->parse_nested_messages('REPLACE');
  my $entity = $parser->parse_data($message) or
  print "<h3>Parse error!</h3>Error while paring MIME message.";
  dump_entity($entity);              
}

sub dump_entity {                                                      
  my ($entity, $name) = @_;                                
  my $IO;

#  my($from, $cc, $to, $subject, $date);

  # Get any mail headers         
  $from = $entity->head->get('From');
  $subject = $entity->head->get('Subject');
  $date = $entity->head->get('Date');
  $cc = $entity->head->get('CC');
  $to = $entity->head->get('To');
  
  unless ($from . $subject . $date eq "") {
  
    print "<table bgcolor=\"$secondarycolor\" cellspacing=0 cellpadding=2 border=0 width=100%>";
    print "<tr><td align=right><b><small>From:</small></b></td><td><small>$from</small></td>";
    print "<td align=right><small>$date</small></td></tr>";
    print "<tr><td align=right valign=top><b><small>Subject:</small></b></td><td width=100% 
colspan=2><small>$subject</small></td></tr>";
    print "<tr><td align=right valign=top><b><small>To:</small></b></td><td colspan=2><small>$to</small></td></tr>" if ($to 
ne "<br>");
    print "<tr><td align=right valign=top><b><small>CC:</small></b></td><td colspan=2><small>$cc</small></td></tr>" if ($cc);
    print "</table><p>";
  }

  # Output the body:
  my @parts = $entity->parts;
  if (@parts) {                     # multipart...
    my $i;
    foreach $i (0 .. $#parts) {       # dump each part...
      dump_entity($parts[$i], $name . ", part " . $i);
      print "<p><hr><p>";
    }
  }
  else {                            # single part...

    # Get MIME type, and display accordingly...
    my ($type, $subtype) = split('/', $entity->head->mime_type);
    my $body = $entity->bodyhandle;

    if ($type =~ /^(text|message)$/) {     # text: display it...
      if ($IO = $body->open("r")) {
        my $txt;
        $txt .= $_ while (defined($_ = $IO->getline));

        if ($subtype eq "html") { # hey, HTML
          my $contentbase = $entity->head->get('Content-Base');

          if ($contentbase) {
            $contentbase =~ s|\"||g;
            #$txt = fix_links($txt, $contentbase);
          }

        } else {
          $txt =~ s|&|&amp;|g;
    #      $txt =~ s|<|&lt;|g;
    #      $txt =~ s|>|&gt;|g;
          $txt =~ s|^(&gt;.*)|<font color="#aa0000">$&</font>|gm;
          $txt =~ s|\n|<br>\n|g;
          $txt =~ s|(https?://[a-z\-0-9/~._,\#=;?&]+[a-z\-0-9/_])|<a href="$1" target=_new><tt>$1</tt></a>|igm;
          $txt =~ s|([^/>])(www\.[a-z\-0-9/~._,\#=;?&]+\.[a-z\-0-9/_]+)|$1<a href="http://$2" target=_new><tt>$2</tt></a>|igm;
          $txt =~ s|<a href="(.+?)&gt"><tt>(.+?)&gt</tt></a>;|<a href="$1" target=_new><tt>$2</tt></a>&gt;|igm;
          $txt =~ s|(ftp://[a-z\-0-9/~._,]+[a-z\-0-9/_])|<a href="$1"><tt>$1</tt></a>|igm;
          $txt =~ s|([a-z\-0-9._,]+\@[a-z.]+[a-z])|<a href="mailto:$1"><tt>$1</tt></a>|igm;

if ($txt =~ s|([a-z\-0-9._,]+\@[a-z.]+[a-z])||i) {
$txt =~ s|([a-z\-0-9._,]+\@[a-z.]+[a-z])|<a href="mailto:$1"><tt>$1</tt></a>|igm;
}

if ($txt =~ s|([^\"])(mailto:[a-z\-0-9._,]+@[a-z\-0-9.]+[a-z\-0-9])||i) {

$txt =~ s|([^\"])(mailto:[a-z\-0-9._,]+@[a-z\-0-9.]+[a-z\-0-9])|$1<a href="$2"><tt>$2</tt></a>|igm;

}
        }

        # And finally print it
        print "$txt";
        $IO->close;
        }
      else {       # d'oh!
        print "<h3>MIME Error</h3>MIME entity error - not found, sorry.";
      }
      }
    elsif (($type eq "image") && ($subtype =~ /^(gif|jpeg)$/)) { # image, inline it...
      my $path = $body->path;
      #$path =~ s/$topdir//g;
 my ($mypath,$myname) = split("mime-tmp",$path);
      print "<img src=\"mime-tmp/$myname\">";
    }
    else {                                 # binary: just summarize it...
      my $path = $body->path;
      my $size = ($path ? (-s $path) : '???');
      my $filename = $entity->head->recommended_filename || 'no-name';

    print<<_EOF;
    <table bgcolor=\"#cccccc\" cellspacing=0 cellpadding=2 border=0%>
    <tr><td align=right><b><small>Attachment:</small></b></td><td><a href=\"mime-tmp/$filename\"><small>$filename</small></a><br></td></tr>
    <tr><td align=right><b><small>MIME Type:</small></b></td><td><small>$type/$subtype</small></td></tr>
    <tr><td align=right><b><small>Size:</small></b></td><td><small>$size bytes</small></td></tr>
    </table>
_EOF

    }
  }
}
