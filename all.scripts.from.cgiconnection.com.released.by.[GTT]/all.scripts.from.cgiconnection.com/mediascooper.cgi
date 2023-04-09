#!/usr/bin/perl
# Media Scooper
# RSS Reader
# Provided by CGI Connection
# http://www.cgiconnection.com

$| = 1;

use LWP::Simple qw($ua getstore);
use Time::Local;
srand();

# Number of seconds to stop trying to get RSS feed
$timeout = 3;

# Number of minutes to pass before retrieving RSS file from web site again
$exp_mins = 30;

# Where to store RSS feeds
# Eg. /path/to/save/files
$save_dir = "!SAVEDIR!";

# Location where the Media Scooper script resides on your server
# Eg. http://www.yourserver.com/cgi-bin/mediascooper.cgi
$script_url = "http://!CGIURL!/mediascooper.cgi";

# What to display at the bottom of all news feeds
$logo = "Powered by <A HREF=\"http://www.cgiconnection.com\">CGI Connection</A>";

# Default fonts
@fonts =
(
"Verdana, Arial, Sans-serif",
"Times New Roman, Serif",
"Arial, Helvetica, Sans-serif",
"Courier New, Courier, Mono",
"Trebuchet MS, Verdana, Arial",
"Georgia, Serif",
"Geneva, Arial, Sans-serif",
"Tahoma, Verdana",
"Comic Sans MS, Verdana",
"Lucida Console, Verdana"
);

# Default RSS feed URLs
@urls = (
"http://my.abcnews.go.com/rsspublic/2020_rss093.xml",
"http://my.abcnews.go.com/rsspublic/gma_rss093.xml",
"http://my.abcnews.go.com/rsspublic/nightline_rss093.xml",
"http://my.abcnews.go.com/rsspublic/primetime_rss093.xml",
"http://news.bbc.co.uk/rss/newsonline_world_edition/americas/rss091.xml",
"http://news.bbc.co.uk/rss/newsonline_uk_edition/entertainment/music/rss091.xml",
"http://businessknowhow.com/bkh/rss20_newsletter.asp",
"http://www.channelseven.com/channelseven.rdf",
"http://partners.userland.com/nytrss/technology.xml",
"http://partners.userland.com/nytrss/nytHomepage.xml",
"http://rss.pcworld.com/rss/latestnews.rss",
"http://rss.news.yahoo.com/rss/oped",
"http://rss.news.yahoo.com/rss/science",
"http://rss.news.yahoo.com/rss/sports",
"http://rss.news.yahoo.com/rss/politics",
"http://rss.news.yahoo.com/rss/topstories",
"http://rss.news.yahoo.com/rss/tech",
"http://rss.news.yahoo.com/rss/business",
"http://rss.news.yahoo.com/rss/entertainment",
"http://rss.news.yahoo.com/rss/health",
"http://rss.news.yahoo.com/rss/world",
"http://www.popdex.com/rss.xml",
"http://www.variety.com/rss.asp?categoryid=1071",
"http://www.variety.com/rss.asp?categoryid=1023",
"http://www.variety.com/rss.asp?categoryid=1295",
"http://www.variety.com/rss.asp?categoryid=1008",
"http://www.variety.com/rss.asp?categoryid=1075",
"http://www.variety.com/rss.asp?categoryid=1275",
"http://www.wired.com/news_drop/netcenter/netcenter.rdf",
"http://windows.fileoftheday.com/index.rdf",
"http://www.rollingstone.com/rssxml/Album_Reviews.xml",
"http://z.about.com/6/g/websearch/b/index.xml",
"http://www.craigslist.org/about/best/index.xml"
);

# Default RSS feed descriptions
# Should be listed in the same order as URLS above
@url_desc = (
"ABC News: 20/20",
"ABC News: Good Morning America",
"ABC News: Nightline",
"ABC News: Primetime",
"BBC News: Americas",
"BBC News: Entertainment News",
"Business Know-How Newsletter",
"ChannelSeven.com - Marketing",
"New York Times: Technology",
"New York Times: NYT HomePage",
"PCWorld Latest News",
"Yahoo Opinion/Editorial",
"Yahoo Science",
"Yahoo Sports",
"Yahoo Politics",
"Yahoo Top Stories",
"Yahoo Technology",
"Yahoo Business",
"Yahoo Entertainment",
"Yahoo Health",
"Yahoo World News",
"Popdex - the web site popularity index",
"Variety.com - Reality TV",
"Variety.com - DVD Reviews",
"Variety.com - Fall TV Sked",
"Variety.com - Internet Reviews",
"Variety.com - Tune Tracker",
"Variety.com - TV Ratings",
"Wired News",
"Windows File of the Day",
"RollingStone.com: CD Reviews",
"About.com: Web Search",
"Best of Craigslist.com"
);


#################################################
# DO NOT EDIT BELOW THIS LINE
#################################################

&parse_form;

$area = $FORM{'area'};
$url = $FORM{'url'};
$blank = $FORM{'blank'};
$font = $FORM{'font'};
$desc = $FORM{'desc'};
$show_author = $FORM{'show_author'};
$dates = $FORM{'dates'};
$text = $FORM{'text'};
$background = $FORM{'background'};
$border = $FORM{'border'};
$width = $FORM{'width'};
$feed = $FORM{'feed'};
$max_articles = $FORM{'max_articles'};
$desc_length = $FORM{'desc_length'};

$ua->timeout($timeout);

print "Content-type: text/html\n\n";

$max_articles = 10 if $max_articles <= 0;
$blank = " target=_blank" if $blank == 1;

if ($url eq "" and $area eq "")
 {
 &show_main;
 exit;
 }

if ($area eq "show")
 {
 $url = $feed if $url eq "" or "\L$url\E" eq "http://";
 $blank2 = 1 if $blank ne "";

 $url2 = $url;
 $url2 =~ s/\?/\%3F/gi;
 $url2 =~ s/\=/\%3D/gi;
 $url2 =~ s/\&/\%26/gi;

 &style_sheet;
 print "<DIV CLASS=\"mediabody\">\n";
 print "<FONT FACE=\"@fonts[0]\"><CENTER>\n";
 print "<A HREF=\"javascript:history.back(-1);\">Get another feed</A><BR><BR>\n";
 print "<B>Copy the below code to your web pages to display the RSS feed</B><BR>\n";
 $full_url = "$script_url?url=$url2&blank=$blank2&desc=$desc&dates=$dates&text=$text&background=$background&border=$border&max_articles=$max_articles&desc_length=$desc_length&show_author=$show_author&width=$width&font=$font";
 $full_url =~ s/\#/\%23/g;
 $full_url =~ s/\s/\+/g;

 print "<FORM><TEXTAREA COLS=60 ROWS=10><SCRIPT SRC=\"$full_url\">\n</SCRIPT>\n</TEXTAREA></FORM>\n";
 print "<BR><B>Here is how your feed will look:</B><BR><BR>\n";
 print "</FONT><SCRIPT>\n";
 }

print "document.write('<FONT FACE=\"$font\">');\n";
print "document.write('<TABLE BORDER=1 WIDTH=$width CELLPADDING=5 BGCOLOR=\"$background\" BORDERCOLOR=\"$border\">');\n";
print "document.write('<TR><TD><FONT SIZE=-1 COLOR=\"$text\">');";
$total_articles = &get_content($url);

if ($total_articles == 1)
 {
 print "document.write('The URL you supplied is either not an RSS feed, or the site is down.<BR><BR>');\n";
 }

print "document.write('<CENTER>$logo</CENTER>');\n";
print "document.write('</FONT></TD></TR>');\n";
print "document.write('</TABLE></FONT>');\n";

if ($area eq "show")
 {
 print "</SCRIPT></DIV></BODY></HTML>\n";
 }

exit;

sub convert_gmt
{
my ($sec,$min,$hours,$mday,$mon,$year) = @_;
my $new_time;

return(-1) if $sec < 0 or $sec > 59;
return(-1) if $min < 0 or $min > 59;
return(-1) if $hours < 0 or $hours > 23;
return(-1) if $mday < 1 or $mday > 31;
return(-1) if $year < 1970 or $year > 2037;

$new_time = timelocal($sec,$min,$hours,$mday,$mon,$year);
return($new_time);
}

sub date_info
{
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(@_[0]);
my ($month);

if ($hour >= 12)
 {
 $hour = $hour - 12 if $hour > 12;
 $tday = "PM";
 }
 else
 {
 $hour = 12 if $hour == 0;
 $tday = "AM";
 }

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

return("$month\-$mday\-$year","$hour\:$min $tday");
}

sub find_month
{
my ($wday) = @_[0];
my $found = 0;
my $count = 0;

my ( @all_months ) = ( "January", "February", "March", "April", "May", "June",
                       "July", "August", "September", "October", "November", "December" );

until($found == 1 or $count == @all_months)
 {
 if (@all_months[$count] =~ /$wday/gi)
  {
  $found = 1;
  }
  else
  {
  $count++;
  }
 }

$count = -1 if $found == 0;
return($count);
}

sub find_weekday
{
my ($wday) = @_[0];
my $found = 0;
my $count = 0;

my ( @all_weekday )=( "Monday", "Tuesday", "Wednesday",
                      "Thursday", "Friday", "Saturday", "Sunday" );

until($found == 1 or $count == @all_weekday)
 {
 if (@all_weekday[$count] =~ /$wday/gi)
  {
  $found = 1;
  }
  else
  {
  $count++;
  }
 }

$count = -1 if $found == 0;
return($count);
}



sub string_to_local
{
my ($total_val,$month_num,$wday_num,$sec,$mins,$hour,$month,$year,$wday,$tday,$time,@times);
my ($time_string) = @_[0];
my ($get_month) = 0;

#2004-01-21T19:00:00-08:00
#2003-08-06T09:04+00:00

if ($time_string =~ m/(\d{4})\-(\d{2})\-(\d{2})T(\d{2}\:\d{2}[\:]*\d{0,2})/i)
 {
 $get_month = 1; #Don't search -- already in numeric form
 $wday = "";
 $month_num = $2;
 $day = $3;
 $year = $1;
 $time = $4;
 $tday = "";
 $month_num = $month_num - 1;
 }
elsif ($time_string =~ m/(\d{1,2})\/(\d{1,2})\/(\d{4,4})\s*(\d{1,2}\:\d{1,2}\:\d{1,2})/i)
 {
 $get_month = 1; #Don't search -- already in numeric form
 $wday = "";
 $month_num = $1;
 $day = $2;
 $year = $3;
 $time = $4;
 $tday = "";
 $month_num = $month_num - 1;
 }
 elsif ($time_string =~ m/([\w]*)[,|\s]+([\d]*)[,|\s]+([\w]*)[,|\s]+([\d]*)[,|\s|at]+([\d|\:]*)[,|\s]+[GMT|PST|MTN|EST]+/i)
 {
 $wday = $1;
 $month = $3;
 $day = $2;
 $year = $4;
 $time = $5;
 $tday = "";
 }
 elsif ($time_string =~ m/([\w]*)[\s]+([\d]*)[rd|st|th|nd]*[,|\s]*([\d]*)[,|\s]+([\d|\:]+)([a|\.|p|m]*)/i)
 {
 $wday = "";
 $month = $1;
 $day = $2;
 $year = $3;
 $time = $4;
 $tday = $5;
 }
 elsif ($time_string =~ m/([\w]*)[,|\s]+([\w]*)[,|\s]+([\d]*)[,|\s]+([\d]*)[,|\s]+([\d|\:]*)[,|\s]+([a|.|p|m]*)/i)
 {
 $wday = $1;
 $month = $2;
 $day = $3;
 $year = $4;
 $time = $5;
 $tday = $6;
 }
 elsif ($time_string =~ m/([\w]*)[,|\s]+([\d]*)[,|\s]+([\w]*)[,|\s]+([\d]*)[,|\s|at]+([\d|\:]*)[,|\s]+([a|.|p|m]*)/i)
 {
 $wday = $1;
 $month = $3;
 $day = $2;
 $year = $4;
 $time = $5;
 $tday = $6;
 }

splice(@times, 0);
@times = split(/\:/, $time);
$hour = @times[0];
$mins = @times[1];
$sec = @times[2];

$tday =~ s/\.//gi;
if ("\L$tday\E" eq "pm" and $hour != 12)
 {
 $hour = $hour + 12;
 }

if ("\L$tday\E" eq "am" and $hour == 12)
 {
 $hour = 0;
 }

#$sec = 0;
$month_num = &find_month($month) if $get_month == 0;
$wday_num = &find_weekday($wday);

$total_val = &convert_gmt($sec,$mins,$hour,$day,$month_num,$year);

if ($total_val == -1)
 {
 return(-1);
 }
 else
 {
 return($total_val);
 }
}


sub get_content
{
my $url = @_[0];
my ($dcdate, $pubdate, $new_date, $now_date, $now_time, $author, $tlink, $description, $temp_line, $title, $total, $line, $lines, $last_date, $compare_date, $guid);
my $total = 1;
my $get_new = 0;
my $current_time = time();

#my $rand_num = int(rand(10000000000000));
my $rand_num = $url;
$rand_num =~ s/[^[:alnum:]]//g;

my $now_temp = "$save_dir\/$rand_num\.txt";

if (-e $now_temp)
 {
 my @uses_info = stat("$now_temp");
 ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @uses_info;
 $exp_time = $lm + (60 * $exp_mins); 

 if ($lm != 0 && $current_time >= $exp_time)
  {
  unlink("$now_temp");
  }
  else
  {
  $get_new = 1;
  }
 }

getstore($url, "$now_temp") if $get_new == 0;

open(FILE, "<$now_temp");

until(eof(FILE))
 {
 $line = <FILE>;
 $lines .= $line;
 }

close(FILE);

if (-s $now_temp == 0)
 {
 unlink("$now_temp");
 }

while($lines =~ m/<item.*?>(.*?)<\/item>/gsi and $total <= $max_articles)
 {
 $tlink = "";
 $pubdate = "";
 $title = "";
 $description = "";
 $author = "";
 
 $temp_line = $1;

 while ($temp_line =~ m/<link>(.*?)<\/link>/gsi)
  {
  $tlink = $1;
  $tlink =~ s/\n//gi;
  $tlink =~ s/\cM//gi;
  }

 while ($temp_line =~ m/<guid>(.*?)<\/guid>/gsi)
  {
  $guid = $1;
  $guid =~ s/\n//gi;
  $guid =~ s/\cM//gi;
  }

 while ($temp_line =~ m/<description>(.*?)<\/description>/gsi)
  {
  $description = $1;
  $description =~ s/\n/ /gi;
  $description =~ s/\cM/ /gi;
  }

 while ($temp_line =~ m/<pubdate>(.*?)<\/pubdate>/gsi)
  {
  $pubdate = $1;
  $pubdate =~ s/\n/ /gi;
  $pubdate =~ s/\cM/ /gi;
  }

 while ($temp_line =~ m/<dc:date>(.*?)<\/dc:date>/gsi)
  {
  $dcdate = $1;
  $dcdate =~ s/\n/ /gi;
  $dcdate =~ s/\cM/ /gi;
  }

 while ($temp_line =~ m/<title>(.*?)<\/title>/gsi)
  {
  $title = $1;
  $title =~ s/\n/ /gi;
  $title =~ s/\cM/ /gi;
  }

 while ($temp_line =~ m/<author>(.*?)<\/author>/gsi)
  {
  $author = $1;
  $author =~ s/\n/ /gi;
  $author =~ s/\cM/ /gi;
  }

 $now_date = "";
 $now_time = "";

 $pubdate = $dcdate if $pubdate eq "";
 $new_date = &string_to_local($pubdate);
 $compare_date = $last_date - $new_date;

 print "document.write('<FONT SIZE=-2><I><B>$pubdate</B></I></FONT><BR>');\n" if $new_date == -1 and $pubdate ne "" and $dates == 1;

 if ($new_date != -1 and $new_date != $last_date and $new_date > 0)
  {
  $last_date = $new_date;

  if (($compare_date >= 2 or $total == 1) and $dates == 1)
   {
   ($now_date, $now_time) = &date_info($new_date);
   print "document.write('<FONT SIZE=-2><I><B>$now_date $now_time</B></I></FONT><BR>');\n";
   }
  }

 if ($description =~ /\<\!\[CDATA\[(.*?)\]\]\>/)
  {
  $description = $1;
  }

 $description =~ s/\&lt\;/</gi;
 $description =~ s/\&gt\;/>/gi;

 $description =~ s/\&apos\;/\'/gi;
 $description =~ s/\'/\\\'/gi;
 $description =~ s/\"/\\\"/gi;
 $description =~ s/<([^>]|\n)*>//gi;

 if (length($description) > $desc_length and $desc_length > 0)
  {
  $description = substr($description, 0, $desc_length);
  $description .= "...";
  }

 $title =~ s/\&lt\;/</gi;
 $title =~ s/\&gt\;/>/gi;

 $title =~ s/<([^>]|\n)*>//gi;

 $title =~ s/\&apos\;/\'/gi;
 $title =~ s/\&amp\;/\&/gi;
 $title =~ s/\'/\\\'/gi;
 $title =~ s/\"/\\\"/gi;

 $tlink = $guid if $tlink eq "";

 if ($tlink ne "")
  {
  $title = "<A HREF=\"$tlink\"$blank>$title</A>";
  }

 print "document.write('$title<BR>');\n";
 print "document.write('<I>$author</I><BR>');\n" if $author and $show_author == 1;

 if (($dates == 0 and $desc == 0) or ($dates == 1 and $desc == 0) or $description eq "")
  {
  print "document.write('<BR>');\n";
  }

 print "document.write('$description<BR><BR>');\n" if $description and $desc == 1;
 $total++;
 }

if ($total == 1)
 {
 unlink("$now_temp");
 }

return($total);
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

sub show_main
{
my (@all_urls, $j);

&style_sheet;

{
print<<END
<DIV CLASS="mediabody">
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="show">

<CENTER>
<TABLE CLASS="myborder" BORDER=0 CELLPADDING=10 CELLSPACING=0>
<TR><TD CLASS="myheader" COLSPAN=2><B>Media Scooper</B></TD></TR>
<TR CLASS="mycontent"><TD>Choose Feed:</TD> <TD><SELECT NAME=feed>
END
}

for ($j = 0; $j < @urls; $j++)
 {
 @all_urls[$j] = [@urls[$j], @url_desc[$j]];
 }

@all_urls = sort{$a->[1] cmp $b->[1]} @all_urls;

for ($j = 0; $j < @all_urls; $j++)
 {
 print "<OPTION VALUE=\"@all_urls[$j]->[0]\">@all_urls[$j]->[1]\n"; 
 }

{
print<<END
<TR CLASS="mycontent"><TD>Or enter your own URL:</TD> <TD><INPUT NAME=url SIZE=50 VALUE="http://"></TD></TR>
<TR CLASS="mycontent"><TD COLSPAN=2><HR></TD></TR>
<TR CLASS="mycontent"><TD>Open articles in new page</TD> <TD><INPUT TYPE=CHECKBOX NAME=blank VALUE="1" CHECKED></TD></TR>
<TR CLASS="mycontent"><TD>Show descriptions</TD> <TD><INPUT TYPE=CHECKBOX NAME=desc VALUE="1" CHECKED></TD></TR>
<TR CLASS="mycontent"><TD>Show author</TD> <TD><INPUT TYPE=CHECKBOX NAME=show_author VALUE="1" CHECKED></TD></TR>
<TR CLASS="mycontent"><TD>Show dates</TD> <TD><INPUT TYPE=CHECKBOX NAME=dates VALUE="1" CHECKED></TD></TR>
<TR CLASS="mycontent"><TD>Max. articles to show</TD> <TD><INPUT NAME=max_articles VALUE="5" SIZE=5></TD></TR>
<TR CLASS="mycontent"><TD>Max. description length</TD> <TD><INPUT NAME=desc_length VALUE="0" SIZE=5> characters (0 means no limit)</TD></TR>
<TR CLASS="mycontent"><TD>Background color</TD> <TD><INPUT NAME=background VALUE="#CCCCCC" SIZE=10></TD></TR>
<TR CLASS="mycontent"><TD>Width of box</TD> <TD><INPUT NAME=width VALUE="300" SIZE=10> pixels</TD></TR>
<TR CLASS="mycontent"><TD>Border color</TD> <TD><INPUT NAME=border VALUE="BLUE" SIZE=10></TD></TR>
<TR CLASS="mycontent"><TD>Text color</TD> <TD><INPUT NAME=text VALUE="BLACK" SIZE=10></TD></TR>
<TR CLASS="mycontent"><TD>Text Font</TD> <TD><SELECT NAME=font>
END
}

 foreach $font (@fonts)
  {
  print "<OPTION>$font\n";
  }

{
print<<END
</SELECT></TD></TR>
<TR CLASS="mycontent"><TD COLSPAN=2 ALIGN=CENTER><INPUT TYPE=submit NAME=submit VALUE="Get Feed"></TD></TR>
<TR CLASS="mycontent"><TD COLSPAN=2 ALIGN=CENTER><HR>$logo</TD></TR>
</FORM></TABLE></CENTER></DIV></BODY></HTML>
END
}

}

sub style_sheet
{

{
print<<END
<HTML>
<TITLE>Media Scooper RSS Reader</TITLE>
<BODY BGCOLOR="#A8B6C4">
<STYLE type="text/css">
.mycontent { background: #CCCCCC; color: black; font-family: @fonts[0]; font-size: 8pt; font-weight: bold }
.myheader { background: #A8B6C4; color: white; font-family: @fonts[0]; font-size: 9pt; font-weight: bold }
.myborder { background: #CCCCCC; }

DIV.mediabody {
 border: solid thin black;
 padding: 10px 5% 10px 5%;
 margin: 10px 7% 10px 7%;
 margin: 10px 10% 10px 10%;
 font: 16px @fonts[0];
 font: 12px @fonts[0];
 font-size: 1.0em;
 background-color: white;
}
</STYLE>
END
}

}
