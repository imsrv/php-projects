#!/usr/bin/perl
# Affiliate Finder 1.1
# Provided by CGI Connection
# http://www.cgiconnection.com
$| = 1;

use IO::Socket;
use LWP::Simple qw($ua getstore);

# Where to store temporary files and engine list
# Eg. /path/to/save/files
$save_dir = "!SAVEDIR!";

# Default WHOIS server
#$whois_server = "whois.opensrs.net";
$whois_server = "whois.geektools.com";

# Background color of main menu
$css_bgcolor = "#CCCFFF";

#################################################
srand();
&parse_form;
$area = $FORM{'area'};
$keywords = $FORM{'keywords'};
$domain = $FORM{'domain'};

$total_count = 0;
$related = 0;
splice(@all_related, 0);

print "Content-type: text/html\n\n";
print "<HTML><TITLE>Super Affiliate Finder</TITLE><BODY><FONT FACE=\"Arial\"><CENTER>\n";

&style_sheet;

if ($area eq "lookup")
 {
 &check_uses($save_dir, 0);
 $result = &look_up($domain, $whois_server);
 print "<BODY BGCOLOR=\"$css_bgcolor\"><H2>Super Affiliate Finder WhoIs</H2></CENTER>\n";
 print "<DIV CLASS=\"body\">\n";
 print "$result";
 print "</DIV></BODY></HTML>\n";
 exit;
 }

if ($area eq "" or $keywords eq "")
 {
 &show_main;
 exit;
 }

&check_uses($save_dir, 0);

$now_time = time();
$log_file = "afinder.log";
open(FILE, ">>$save_dir\/$log_file");
print FILE "$now_time\|$ENV{'REMOTE_ADDR'}\|$ENV{'HTTP_REFERER'}\|$keywords\n";
close(FILE);

for ($j = 0; $j < 100; $j++)
 {
 print "<!-- FORCE OUTPUT-->\n";
 }

$count = 0;
$start_val = 0;
$end_val = 30;

print "<H2>Super Affiliate Finder</H2>\n";
print "Powered by <A HREF=\"http://www.cgiconnection.com\">CGI Connection</A><BR><BR>\n";

for ($j = $start_val; $j < $end_val; $j++)
 {
 $jj = 10 * $j;

 splice(@found_links, 0);
 @found_links = &search_altavista($keywords, $jj, 1);

# 0 gets related search terms, -1 shows related search terms, -2 doesn't show
 if ($related == -1)
  {
  &show_start;
  $related = -2;
  }

 for ($x = 0; $x < @found_links; $x++)
  {
  $url = @found_links[$x];
 
  &status_line("Retrieving contact information for $url");
  ($site, $rank, $links, $email, $phone, $fax, $address) = &get_alexa($url);
  &status_line("");

  $rank = "N/A" if $rank eq "";
  $links = "N/A" if $links eq "";
  $phone = "N/A" if $phone eq "";
  $fax = "N/A" if $fax eq "";

  if ($email eq "")
   {
   $email = "N/A";
   }
   else
   {
   $email = "<A HREF=\"mailto:$email\">$email</A>";
   }

  if ($site)
   {
   &status_line("Getting popularity score for $url");
   $popularity = &get_popularity_altavista($url);
   $popularity = "N/A" if $popularity eq "";
   &status_line("");

   $count = 0 if $count == 2;

   print "</TABLE>\n<TABLE BORDER=1 CELLPADDING=0 CELLSPACING=0 CLASS=\"afindertable\">\n" if $count == 0;
   print "<TR><TD WIDTH=300><B>[<A HREF=\"$ENV{'SCRIPT_NAME'}?area=lookup&domain=$url\" target=_blank>?</A>] <A HREF=\"http://$url\" target=_blank>$url</A></B> (<I>$site</I>)<BR>$address</TD> <TD WIDTH=75>$rank</TD> <TD WIDTH=75>$links</TD> <TD WIDTH=75>$popularity</TD> <TD WIDTH=250>$email</TD> <TD WIDTH=175>PH: $phone<BR>FAX: $fax</TD></TR>\n";
   $count++;
   $total_count++;
   }
  }
 }

print "</TABLE></FONT></CENTER></BODY></HTML>\n";
&status_line("Search complete. $total_count results found");
exit;

open(FILE, "<c:/cgiconnection/sites.txt");

until(eof(FILE))
 {
 $line = <FILE>;
 $line =~ s/\s+//i;

 splice(@all_lines, 0);
 @all_lines = split(/ /, $line);
 ($site, $rank, $links) = &get_alexa(@all_lines[2]);

 if ($site)
  {
  $popularity = &get_popularity_altavista(@all_lines[2]);
  print "@all_lines[2] ($site): Rank: $rank Links: $links Popularity: $popularity\n";
  }
 }

close(FILE);

exit;

sub get_alexa
{
my $site = @_[0];
return if $site eq "";

my $url = "http://xslt.alexa.com/cgi-bin/search_form?term=$site";
my $filename = int(rand(1000000));
my $now_temp = "$save_dir\/$filename";
getstore($url, "$now_temp");

my $lines = "";
my $contact_info;
my @all_contact;
my ($rank, $links, $line, $alexa_site, $email, $phone, $fax, $xx, $address, $xx2);

open(FILEI, "<$now_temp");

until(eof(FILEI))
 {
 $line = <FILEI>;
 $lines .= $line;
 }

close(FILEI);
unlink("$now_temp");

if ($lines =~ /Traffic Rank for (.*?):<\/span>.*?<a href=.*?>(.*?)<\/a>/sigc)
 {
 $alexa_site = $1;
 $rank = $2;
 $rank =~ s/<([^>]|\n)*>//g;
 $alexa_site =~ s/\s|\n|\cM//gi;
 }

if ($lines =~ /Other sites that link to this site.*?<a href=.*?>([\d|,]*)<\/a>/sigc)
 {
 $links = $1;
 }

if ($lines =~ /<div class="titleO">.*?<span class="body">(.*?)<div class="titleO">/sigc)
 {
 $contact_info = $1;
 $contact_info =~ s/\n|\cM/ /gi;
 $contact_info =~ s/<br>|<p>/\n/gi;
 $contact_info =~ s/<([^>]|\n)*>//g;
 $contact_info =~ s/\s+//i;

 @all_contact = split(/\n/, $contact_info);

 $xx = @all_contact;
 my ($found, $tmp_line);

 until($xx < 0 or $found == 1)
  {
  $tmp_line = @all_contact[$xx];
  $tmp_line =~ s/\s+//gi;

  if ($tmp_line ne "")
   {
   $email = @all_contact[$xx];
   $found = 1;
   }

  $xx--;  
  }

 }

$email =~ s/\s+|\n//gi;

if ($email !~ /^[A-Z0-9\-_\.]+\@[A-Z0-9\-\.]+\.[A-Z]{2,}$/i)
 {
 @all_contact[$xx] = $email;
 $email = "";
 }

for ($xx2 = 0; $xx2 < $xx; $xx2++)
 {
 $tmp_line = @all_contact[$xx2];
 $tmp_line =~ s/\s+//gi;
 $address .= "@all_contact[$xx2]\n" if $tmp_line ne "";
 }

($phone, $fax) = split(/,/, @all_contact[$xx]);
$fax =~ s/Fax[:]*//gi;
$phone =~ s/\s+|\n//gi;
$fax =~ s/\s+|\n//gi;

$phone = &format_phone($phone);
$fax = &format_phone($fax);
return($alexa_site, $rank, $links, $email, $phone, $fax, $address);
}

sub get_popularity_teoma
{
my $site = @_[0];
my $url = "http://s.teoma.com/search?q=links%3A$site&qcat=1&qsrc=1";
my $filename = int(rand(1000000));
my $now_temp = "$save_dir\/$filename";
getstore($url, "$now_temp");

my $lines = "";
my $popularity;

open(FILEI, "<$now_temp");

until(eof(FILEI))
 {
 $line = <FILEI>;
 $lines .= $line;
 }

close(FILEI);
unlink("$now_temp");

if ($lines =~ /<span class="bold">Showing.*?of about (.*?):<\/span>/sigc)
 {
 $popularity = $1;
 }

return($popularity);
}

sub get_popularity_alltheweb
{
my $site = @_[0];
my $url = "http://www.alltheweb.com/search?cat=web&cs=utf-8&l=any&q=link:$site";
my $filename = int(rand(1000000));
my $now_temp = "$save_dir\/$filename";
getstore($url, "$now_temp");

my $lines = "";
my $popularity;

open(FILEI, "<$now_temp");

until(eof(FILEI))
 {
 $line = <FILEI>;
 $lines .= $line;
 }

close(FILEI);
unlink("$now_temp");

if ($lines =~ /<span class="ofSoMany">(.*?)<\/span>/sigc)
 {
 $popularity = $1;
 }

return($popularity);
}

sub get_popularity_altavista
{
my $site = @_[0];
my $url = "http://www.altavista.com/web/results?q=link%3A$site&kgs=0&kls=0&avkw=aapt";
my $filename = int(rand(1000000));
my $now_temp = "$save_dir\/$filename";
getstore($url, "$now_temp");

my $lines = "";
my $popularity;

open(FILEI, "<$now_temp");

until(eof(FILEI))
 {
 $line = <FILEI>;
 $lines .= $line;
 }

close(FILEI);
unlink("$now_temp");

if ($lines =~ /AltaVista found (.*?) results<\/a><\/b>/sigc)
 {
 $popularity = $1;
 }

return($popularity);
}

sub search_altavista
{
my ($search, $page, $top_level) = @_;

&status_line("Searching...");

$search =~ s/\s/\+/gi;
my $url = "http://www.altavista.com/web/results?q=$search&kgs=0&kls=0&avkw=aapt&stq=$page";
my $filename = int(rand(1000000));
my $now_temp = "$save_dir\/$filename";
getstore($url, "$now_temp");

my $lines = "";
my $tmp_line;
my @all_links;
my $link_count = 0;

open(FILEI, "<$now_temp");

until(eof(FILEI))
 {
 $line = <FILEI>;
 $lines .= $line;
 }

close(FILEI);
unlink("$now_temp");

if ($related == 0)
 {
 $lines =~ /suggested spelling correction" style=.*?>(.*?)<\/a>/si;
 $suggest = $1;
 $suggest =~ s/<([^>]|\n)*>//g;
 
 while ($lines =~ /<a title=".*?href=".*?>(.*?)<\/a>/sig)
  {
  @all_related[$related] = $1;
  $related++;
  }

 $related = -1;
 }

while ($lines =~ /<table  width=70% ><TR><TD class="s">(.*?)<\/td><\/tr><\/table>/sgi)
 {
 $tmp_line = $1;

 if ($tmp_line =~ /<span class=ngrn>(.*?)\&\#8226; <span class="ngrn">/sgi)
  {
  $new_site = $1;
  $new_site =~ s/\s|\n|\cM//gi; 

  if ($new_site !~ /\//gi and $top_level == 1)
   {
   @all_links[$link_count] = $new_site;
   $link_count++;
   }
   elsif ($top_level == 0)
   {
   @all_links[$link_count] = $new_site;
   $link_count++;
   }
  }
 }

&status_line("");
return(@all_links);
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

sub style_sheet
{

print<<END
<STYLE TYPE="text/css">
.afindertable, .afindertable TD, .afindertable TH
{
font-family:Arial;
font-size:9pt;
color:black;
background-color:$css_bgcolor;
}

DIV.body {
 border: solid thin black;
 padding: 10px 5% 10px 5%;
 margin: 10px 7% 10px 7%;
 margin: 10px 10% 10px 10%;
 font: 16px Verdana, Arial, sans-serif;
 font: 12px Verdana, Arial, sans-serif;
 font-size: 1.0em;

/* background-image: url("back.jpg"); */
 background-color: white;
}

</STYLE>
END
}

sub show_main
{
print<<END
<BODY BGCOLOR=$css_bgcolor>
<DIV CLASS="body">

<H2>Super Affiliate Finder</H2>

Building personal relationships in seconds
<BR>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="search">
<B>Keywords to search for</B>: <INPUT NAME=keywords>
<INPUT NAME=submit TYPE=submit VALUE="Find Super Affiliates">
</FORM>

Powered by <A HREF="http://www.cgiconnection.com">CGI Connection</A>
</CENTER>
</DIV></BODY></HTML>
END
}

sub format_phone {
   my $temp_number = @_[0];
   my $l;
   $temp_number =~ s/[\s|\n|\r|\cM|\+]//g;    # strip space and newlines
   $temp_number =~ s/[-|)|(|.]//g;     # strip seperating chars
   $temp_number =~ s/(x|ex|ext\.|ext)(.*)$/­/i;      # Extension

   my $ext = $2;       # save extension

   my $n = '';
   $temp_number =~ s/\W|\D//g;

   $l = length($temp_number);
   if (($l == 12)||($l == 13)) {
       $temp_number =~ m/(\+\d{2}|\d{3})(\d{3})(\d{3})(\d{3,4})/;
       $n .= "$1 $2 $3 $4";
   } elsif ($l == 11) {                # us with leading 1
       $temp_number =~ m/(\d{1})(\d{3})(\d{3})(\d{4})/;
       $n .= "\+$1 ($2) $3-$4";
   } elsif ($l == 10) {                    # us regular
       $temp_number =~ m/(\d{3})(\d{3})(\d{4})/;
       $n .= "($1) $2-$3";
   } else {
       $temp_number =~ s/(\d\d\d)/$1 /g;
       $n .= $temp_number;
   }
   $n .= " Ext. $ext" if $ext;
   return $n;
}

sub status_line
{
print "<SCRIPT LANGUAGE=\"JavaScript\">window.status='@_[0]';</SCRIPT>\n";
}

sub check_browser
{
my $browser = 0;  #MSIE / AOL
if ($ENV{'HTTP_USER_AGENT'} =~ /Mozilla/i)
 {
 if (($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i and $ENV{'HTTP_USER_AGENT'} !~ /opera/i) or $ENV{'HTTP_USER_AGENT'} =~ /mac/i or $ENV{'HTTP_USER_AGENT'} =~ /ppc/i)
  {
  $browser = 1; #Netscape
  }
 }

return($browser);
}

sub fork_program
{
pipe(INPUT, OUTPUT);
$retval = fork();
if ($retval != 0)
 {
 close(INPUT);
 
 $start_val = 0;
 $end_val = 15;
 }
 else
 {
 close(OUTPUT);
 *STDOUT = <INPUT>;
 $start_val = 15;
 $end_val = 30;
 }

}

sub show_start
{
my ($rcount, $tmp_keys);
$rcount = 0;
my $suggest2 = $suggest;
$suggest2 =~ s/ /\+/gi;

if (@all_related > 0)
 {
 print "<TABLE BORDER=0 WIDTH=650 CELLPADDING=0 CELLSPACING=0 CLASS=\"afindertable\">\n";
 print "<TR><TH COLSPAN=3 ALIGN=CENTER><B>Related Search Terms</B><HR></TH></TR>\n";

 for ($r = 0; $r < @all_related; $r = $r + 1)
  {
  $tmp_keys = @all_related[$r];
  $tmp_keys =~ s/ /\+/gi;

  print "<TR>" if $rcount == 0;
  print "<TH ALIGN=CENTER><A HREF=\"$ENV{'SCRIPT_NAME'}?area=search&keywords=$tmp_keys\">@all_related[$r]</A></TH> ";

  $rcount++;
  if ($rcount == 3)
   {
   print "</TR>\n";
   $rcount = 0;
   }
  }

 print "</TABLE><BR>\n";
 }

print "<BR><B>Did you mean: <A HREF=\"$ENV{'SCRIPT_NAME'}?area=search&keywords=$suggest2\"><i>$suggest</i></A></B><BR>\n" if $suggest ne "";

print "<TABLE BORDER=1 CELLPADDING=0 CELLSPACING=0 CLASS=\"afindertable\">\n";
print "<TR><TH COLSPAN=6><B>Searching for:</B> $keywords [ <A HREF=\"$ENV{'SCRIPT_NAME'}\">Start a new search</A> ]<BR></TH></TR>\n";
print "<TR><TH WIDTH=300>Domain</TH> <TH WIDTH=75>Rank</TD> <TH WIDTH=75>Links</TH> <TH WIDTH=75>Popularity</TH> <TH WIDTH=250>E-mail</TH> <TH WIDTH=175>Phone / Fax</TH></TR>\n";
}

sub look_up
{
my ($lookup, $whois_server) = @_;
my ($td1, $td2, $td_total, @temp_domain, @output, $lines);

@temp_domain = split(/\./, $lookup);
$td_total = @temp_domain;

if ($td_total > 2)
 {
 $td1 = @temp_domain[$td_total - 1];
 $td2 = @temp_domain[$td_total - 2];
 $lookup = "$td2\.$td1";
 }

my $socket = IO::Socket::INET->new(Proto=>"tcp", PeerAddr=>"$whois_server",PeerPort=>'43',TimeOut=>4);

if ($socket)
 {
 print $socket "$lookup\n";
 @output = <$socket>;
 close $socket;
 }

$lines = join("<BR>", @output);
$lines =~ s/([\w\d\.\_\-]+)\@([\w\d\_\-\.]+[\w\d\_\-\.]+)/<A HREF="mailto:$1\@$2$3" target=_blank>$1\@$2$3<\/A>/gi;
return($lines);
}

sub check_uses
{
my ($save_dir, $max_attempts) = @_;
my (@uses_info, $temp_name, $now_time, $exp_time, $uses);
$temp_name = $ENV{'REMOTE_ADDR'};
$now_time = time();

return(0) if $max_attempts <= 0;
splice(@uses_info, 0);

if (-e "$save_dir\/$temp_name")
 {
 @uses_info = stat("$save_dir\/$temp_name");
 ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @uses_info;
 $exp_time = $lm + (86400 * 4); 

 if ($lm != 0 && $now_time >= $exp_time)
  {
  unlink("$save_dir\/$temp_name");
  }
  else
  {
  open(FILE, "<$save_dir\/$temp_name");
  $uses = <FILE>;
  close(FILE);
  chop($uses);
  }
 }

if ($uses >= $max_attempts)
 {
 print "Your trial period has expired.  Please visit <A HREF=\"http://www.cgiconnection.com\">CGI Connection</A> to get this software for your own web site.\n";
 exit;
 }

$uses++;
open(FILE, ">$save_dir\/$temp_name");
print FILE "$uses\n";
close(FILE);
}
