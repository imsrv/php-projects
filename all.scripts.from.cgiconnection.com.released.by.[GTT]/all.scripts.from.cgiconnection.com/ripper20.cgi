#!/usr/bin/perl
#URL Ripper 2.0
#Provided by CGI Connection
#http://www.CGIConnection.com
$| = 1;

use LWP::Simple;

# Where to store temporary web page for processing
# Eg. /tmp/
$tempdir = "!TMPDIR!/";

# If above is 1, store all link pages here
# Eg. /path/to/store/links/
$outdir = "!SAVEDIR!/";

# Specify the number of sublinks a user can choose
@max_subs = ("5","10","25","50","75","100");

# Allow unlimited retrieving of sub links
$allow_unlimited = 0;     # 1 = YES / 0 = NO

# DO NOT EDIT BELOW THIS LINE
############################################

srand();
$rand_num = int(rand(1000000));
$tempname = "urlripper\.$rand_num$$";
$mailfile = "$tempname\.mail";
$log = "$tempname\.links";

&parse_form;

$url = $FORM{'url'};
$get_emails = $FORM{'emails'};
$get_links = $FORM{'links'};
$max_links = $FORM{'maxlinks'};

print "Content-type: text/html\n\n";

print "<HTML><BODY><CENTER>\n";
print "<H2>URL Ripper 2.0</H2>\n";
print "Provided by <A HREF=\"http://www.cgiconnection.com\">CGI Connection</A><BR><BR>\n";

if ($url eq "")
 {
 print "<TABLE BORDER=0>";
 print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">";
 print "<TR><TD><B>URL:</B></TD> <TD><INPUT NAME=url VALUE=\"http://\"></TD></TR>\n";
 print "<TR><TD COLSPAN=2><INPUT NAME=links TYPE=CHECKBOX VALUE=\"1\"> Get Sub-Links <INPUT TYPE=CHECKBOX NAME=emails VALUE=\"1\"> Get E-mails</TD></TR>\n";
 print "<TR><TD COLSPAN=2>Max Sub-Links: <SELECT NAME=\"maxlinks\">\n";

 if ($allow_unlimited == 1)
  {
  print "<OPTION>Unlimited\n";
  }

 for ($j = 0; $j < @max_subs; $j++)
  {
  print "<OPTION>@max_subs[$j]\n";
  }

 print "</TD></TR> <TR><TD><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=\"Submit\"></TD></TR>\n";
 print "</FORM>\n";
 print "</TABLE></CENTER></BODY></HTML>\n";
 exit;
 }

sub get_url
{
getstore ($url, "$tempdir$tempname");
$counter = 0;

$url =~ s/http:\/\///gi;
$url =~ s/http://gi;

splice(@alls, 0);
@alls = split(/\//, $url);

$count = 0;
splice(@all_urls, 0);
}

print "Results for $url<BR><BR>\n";
print "Session Name: $tempname<BR>\n";
print "Links Stored In: $tempname\.links<BR>\n";
print "E-mails Stored In: $tempname\.mail<BR>\n";

print "<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 WIDTH=600>\n";

&get_url;

open(LOG, ">$outdir$log");
open(FILE, "<$tempdir$tempname");

until (eof(FILE))
 {
 $lines = <FILE>;
 $line .= $lines;
 }

&check_urls;

if ($get_emails == 1)
 {
 &get_mails;
 }

close(FILE);

if ($get_links == 1 and $counter > 0)
 {
 $get_links = 0;

 for ($j = 0; $j < $counter; $j++)
  {
  $line = "";
  open(FILE, "<$tempdir$tempname$j\.rip");

  until (eof(FILE))
   {
   $lines = <FILE>;
   $line .= $lines;
   }

  &check_urls;

  if ($get_emails == 1)
   {
   &get_mails;
   }

  close(FILE);
  unlink("$tempdir$tempname$j\.rip");
  }
 }

close(LOG);

unlink("$tempdir$tempname");

print "</TABLE><BR>";
print "E-mails Found: $found_mails<BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}\">Back</A>";
print "</CENTER></BODY></HTML>\n";
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

sub check_urls
{
#while ($line =~ m/<[\s]*A[\s]*HREF[\s]*=[\s"^']*([\D\w\d\s][^'">]*)"{1,1}[>]*/gi)

while ($line =~ m/<[\s]*A[\s]*HREF[\s]*=[\s]*["|'|]*([\D\w\d][^'">\s]*)["|'|]*[>]*/gi)
 {
 $noextra = 0;
 $urlnow = $1;

 if (substr("\L$urlnow\E", 0, 7) eq "mailto:")
  {
  $noextra = 1;
  }

 if (substr("\L$urlnow\E", 0, 11) eq "javascript:")
  {
  $noextra = 1;
  }

 if (substr("\L$urlnow\E", 0, 15) eq "javascript:http")
  {
  $noextra = 0;
  }

 if (substr("\L$urlnow\E", 0, 5) ne "http:")
  {
  if (substr($urlnow, 0, 1) eq "/")
   {
   $urlnow = "http://@alls[0]$1";
   }
   else
   {
   $urlnow = "http://$url/$1";
   }
  }

 print LOG "$urlnow\n";

 $newname = "$tempname$counter\.rip";

 if ($get_links == 1)
  {
  if ("\L$max_links\E" eq "unlimited")
   {
   getstore ($urlnow, "$tempdir$newname");
   }
   elsif ($counter < $max_links)
   {
   getstore ($urlnow, "$tempdir$newname");
   }
  }

 if ($noextra == 0)
  {
  @all_urls[$count] = $urlnow;
  $count++;

  $counter++;
  print "<TR><TD><B>$counter</B></TD> <TD><A HREF=\"$urlnow\" target=_blank>$urlnow</A></TD></TR>\n";
  $line_num++;
  
  if ($line_num > 10)
   {
   $line_num = 0;
   print "</TABLE>\n";
   print "<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 WIDTH=600>\n";
   }
  }
 }
}

sub get_mails
{
#Get all e-mail addresses found

open(MAILS, ">>$outdir$mailfile");

while ($line =~ m/([\w\d\.\_\-]*)\@([\w\d\.\_\-]*)/gi)
 {
 if ($1 ne "")
  {
  print MAILS "$1\@$2\n";
  $found_mails++;
  }
 }

close(MAILS);
}
