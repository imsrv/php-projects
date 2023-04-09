#!/usr/bin/perl
#Provided by CGI Connection
#http://www.CGIConnection.com

$| = 1;

srand();

# Location to store random sites file
# CHMOD to 777
# Eg. /path/to/save/directory/
$site_dir = "!SAVEDIR!/";

# Location to store temporary files
# CHMOD to 777
# Eg. /path/to/temp/directory/
$temp_location = "!TMPDIR!/";

# File to store random URL's
$site_file = "randomsite.txt";

# Default URL to go to if random file does not exist
# Eg. http://www.cgiconnection.com
$default_url = "http://!SITEURL!";

# Administration username and password
$username = "!USERNAME!";
$password = "!PASSWORD!";

# Guest username and password to view statistics
$vusername = "guest";
$vpassword = "guest";

#### The settings below are for using cookies ####

# Your domain name that the script will reside on
# set to your domain name, such as http://www.yourname.com
$my_domain = "!SITEURL!";

# If your server is not using day light savings time, or just happens
# to be an hour ahead or back, set the day_light value to anything
# higher or lower than 0 to make it accurate (set to 0 to disable)
$day_light = 0;

# The number of minutes to send the same URL and not record the impression
# if the user refreshes their browser
$exp_min = 1;

##################################################
&parse_form;
&parse_cookies;

splice(@all_sites, 0);
$scount = 0;

$area = $FORM{'area'};
$urls = $FORM{'urls'};
$id = $FORM{'id'};
$track = $FORM{'track'};

if ($track ne "")
 {
 print "Content-type: text/html\n\n";
 &track_it;
 print "// Traffic Analyzer\n";
 print "// http://www.CGIConnection.com\n";
 exit;
 }

if ($area eq "login")
 {
 print "Content-type: text/html\n\n";
 &login_screen;
 exit;
 }

if ($area eq "login2")
 {
 print "Content-type: text/html\n\n";

 &check_login;
 &show_main;
 exit;
 }

if ($area eq "save")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>\n";

 &check_login;
 
 if ($vuser == 1)
  {
  print "<BR>Sorry, visitors cannot make changes.<BR><BR>\n";
  }
  else
  {
  &save_sites;
  print "<BR>Saved.<BR><BR>\n";
  }

 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Go Back</A>\n";
 print "</BODY></HTML>\n";
 exit;
 }

&get_site;

$more_string = "";

if ($ENV{'QUERY_STRING'} ne "")
 {
 $more_string = "?$ENV{'QUERY_STRING'}";
 }

if ($COOKIE{'rndsite'} eq "")
 {
 $ntv = time();
 $day_light = $day_light * 3600;
 $exp_time = $ntv + (60 * $exp_min) - $day_light;
 $exp_timev = &exp_date($exp_time);

 print "Content-type: text/html\n";
 print "Set-Cookie: rndsite=$rsite; path=/; domain=\.$my_domain; expires=$exp_timev\n\n";
 }
 else
 {
 print "Content-type: text/html\n\n";
 }

print "location.href ='$chosen_site$more_string';";
exit;

sub get_site
{
$scount = 1;
$lock_name = $site_file;
&lock;

open(FILE, "<$site_dir$site_file");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);
 
 if ($line ne "")
  {
  @all_sites[$scount] = $line;
  $scount++;
  }
 }

close(FILE);

if ($scount == 1)
 {
 $chosen_site = $default_url;
 return;
 }

if ($COOKIE{'rndsite'} ne "")
 {
 $rsite = "$COOKIE{'rndsite'}";
 }
 else
 { 
 for ($j = 0; $j < 200; $j++)
  {
  until($rsite > 0)
   {
   $rsite = int(rand($scount));
   }
  }
 }

splice(@site_parts, 0);
@site_parts = split(/ - /, @all_sites[$rsite]);

$chosen_site = @site_parts[0];

if ($COOKIE{'rndsite'} ne "")
 {
 &unlock;
 return;
 }

open(FILE, ">$site_dir$site_file");

for ($j = 1; $j < @all_sites; $j++)
 {
 if ($j == $rsite)
  {
  splice(@site_parts, 0);
  @site_parts = split(/ - /, @all_sites[$j]);
  
  $times_shown = @site_parts[1];
  $times_shown++;

  $time_now = time();

  print FILE "@site_parts[0] - $times_shown - $time_now - @site_parts[3] - @site_parts[4] - @site_parts[5]\n";
  }
  else
  {
  print FILE "@all_sites[$j]\n";
  }
 }

close(FILE);

&unlock;
}

sub track_it
{
$scount = 0;
splice(@new_sites, 0);

$lock_name = $site_file;
&lock;

open(FILE, "<$site_dir$site_file");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 if ($line ne "")
  {
  splice(@site_parts, 0);
  @site_parts = split(/ - /, $line);
 
  @site_parts[3] =~ s/ //g;

  if (@site_parts[3] eq $track and @site_parts[3] ne "")
   {
   @site_parts[4]++;
   @site_parts[5] = time();
   }

  @new_sites[$scount] = "@site_parts[0] - @site_parts[1] - @site_parts[2] - @site_parts[3] - @site_parts[4] - @site_parts[5]\n";
  $scount++;
  }

 }

close(FILE);
open(FILE, ">$site_dir$site_file");

for ($j = 0; $j < @new_sites; $j++)
 {
 print FILE "@new_sites[$j]\n";
 }

close(FILE);
&unlock;
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

      if ($FORM{$name}) {
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

sub save_sites
{
splice(@new_sites, 0);
splice(@new_ids, 0);
splice(@track_sites, 0);

@new_sites = split(/, /, $FORM{'url'});
@new_ids = split(/, /, $FORM{'id'});

$scount = 0;
$lock_name = $site_file;
&lock;

open(FILE, "<$site_dir$site_file");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);
 
 if ($line ne "")
  {
  $found = 0;

  splice(@oldsite_parts, 0);
  @oldsite_parts = split(/ - /, $line);
  $oldtmp_site = @oldsite_parts[0];

  for ($j = 0; $j < @new_sites; $j++)
   {
   splice(@newsite_parts, 0);
   @newsite_parts = split(/ - /, @new_sites[$j]);
   $newtmp_site = @newsite_parts[0];
   @new_ids[$j] =~ s/ //g;

   if ($newtmp_site eq $oldtmp_site)
    {
    $found = 1;
    @track_sites[$scount] = "@oldsite_parts[0] - @oldsite_parts[1] - @oldsite_parts[2] - @new_ids[$j] - @oldsite_parts[4] - @oldsite_parts[5]";
    @new_sites[$j] = "";
    $scount++;
    }      
   }  

  }
 }

close(FILE);

open(FILE, ">$site_dir$site_file");

for ($j = 0; $j < @track_sites; $j++)
 {
 print FILE "@track_sites[$j]\n";
 }

for ($j = 0; $j < @new_sites; $j++)
 {
 @new_ids[$j] =~ s/ //g;

 if (@new_sites[$j] eq "")
  {
  splice(@new_ids,$j,1);
  }

 if (@new_sites[$j] ne "" and @new_sites[$j] ne "http://")
  {
  print FILE "@new_sites[$j] -  -  - @new_ids[$j]\n";
  }
 }

close(FILE);
&unlock;
}

sub show_main
{

{
print<<END
<HTML><TITLE>Traffic Analyzer</TITLE>
<BODY><CENTER>
<H2>Traffic Analyzer</H2>

<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0>

<TR><TD></TD> <TD><B>URL</B></TD> <TD><B>ID</B></TD> <TD><B>Shown</B></TD> <TD><B>Clicked</B></TD> <TD><B>Click Thru</B></TD> <TD><B>Last Shown</B></TD> <TD><B>Last Clicked</B></TD></TR>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="save">
<INPUT TYPE=hidden NAME=username VALUE="$FORM{'username'}">
<INPUT TYPE=hidden NAME=password VALUE="$FORM{'password'}">
END
}

$shown_total = 0;
$clicked_total = 0;
$scount = 1;
$lock_name = $site_file;
&lock;

open(FILE, "<$site_dir$site_file");

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);
 
 if ($line ne "")
  {
  splice(@site_parts, 0);
  @site_parts = split(/ - /, $line);
  
  $times_shown = @site_parts[1];
  $times_clicked = @site_parts[4];

  $last_shown = @site_parts[2];
  $last_clicked = @site_parts[5];

  if ($last_shown ne "")
   {
   $last_shown = &date_info($last_shown);
   }
   else
   {
   $last_shown = "N/A";
   }

  if ($last_clicked ne "")
   {
   $last_clicked = &date_info($last_clicked);
   }
   else
   {
   $last_clicked = "N/A";
   }

  $perc = 0;
  if ($times_clicked > 0)
   {
   $perc = ($times_clicked / $times_shown) * 100;
   $perc = sprintf "%.2f", $perc;
   }

  $shown_total = $shown_total + $times_shown;
  $clicked_total = $clicked_total + $times_clicked;

  print "<TR><TD><B>URL #$scount:</B></TD> <TD><INPUT NAME=url VALUE=\"@site_parts[0]\" SIZE=40></TD> <TD><INPUT NAME=id VALUE=\" @site_parts[3]\" SIZE=5></TD> <TD>$times_shown</TD> <TD>$times_clicked</TD> <TD>$perc%</TD> <TD>$last_shown</TD> <TD>$last_clicked</TD></TR>\n";
  $scount++;
  }
 }

close(FILE);
&unlock;

if ($urls < 1)
 {
 $urls = 1;
 }

for ($j2 = $scount; $j2 < ($scount + $urls); $j2++)
 {
 print "<TR><TD><B>URL #$j2:</B></TD> <TD><INPUT NAME=url VALUE=\"http://\" SIZE=40></TD> <TD><INPUT NAME=id VALUE=\" \" SIZE=5></TD> <TD></TD></TR>\n";
 }

if ($clicked_total > 0)
 {
 $ct_total = ($clicked_total / $shown_total) * 100;
 }

$ct_total = sprintf "%.2f", $ct_total;

{
print<<END
<TR><TD COLSPAN=7><INPUT TYPE=submit NAME=submit value="Save"></TD></TR>
</FORM>
</TABLE>
<BR>

<B>Total Shown:</B> $shown_total<BR>
<B>Total Clicks:</B> $clicked_total<BR>
<B>Total Click Thru:</B> $ct_total%<BR>
</CENTER></BODY>
</HTML>
END
}

}

sub date_info
{
my ($dinfo) = @_;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($dinfo);

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
return("$date_now $time_now");
}

sub login_screen
{

{
print<<END
<HTML><BODY>
<CENTER>
<TITLE>Traffic Analyzer</TITLE>
<H2>Traffic Analyzer</H2>

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
$vuser = 0;

if (("\L$username\E" ne "\L$FORM{'username'}\E") or $FORM{'username'} eq "")
 {
 if ("\L$vusername\E" ne "\L$FORM{'username'}\E")
  {
  print "You have entered an invalid username.\n";
  exit;
  }
  else
  {
  $vuser = 1;
  }
 }

if (("\L$password\E" ne "\L$FORM{'password'}\E") or $FORM{'password'} eq "")
 {
 if ("\L$vpassword\E" ne "\L$FORM{'password'}\E")
  {
  print "You have entered an invalid password.\n";
  exit;
  }
  else
  {
  $vuser = 1;
  }
 }
}

sub parse_cookies {
splice(@pairs, 0);
      @pairs = split(/; /, $ENV{'HTTP_COOKIE'});

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

      if ($COOKIE{$name} && ($value)) {
          $COOKIE{$name} = "$COOKIE{$name}, $value";
	 }
         elsif ($value ne "") {
            $COOKIE{$name} = $value;
         }
  }
}

sub exp_date
{
   local($time)= @_;
   local( $sec, $min, $hour, $mday, $mon, $year,
          $wday, $yday, $isdst )= gmtime( $time );

   $sec = "0$sec" if ($sec < 10);
   $min = "0$min" if ($min < 10);
   $hour = "0$hour" if ($hour < 10);
   $mon = "0$mon" if ($mon < 10);
   $mday = "0$mday" if ($mday < 10);
   $year += 1900;
   local( $month )= ($mon + 1);
   local( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                       "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

   local( @weekday )=( "Monday", "Tuesday", "Wednesday",
              "Thursday", "Friday", "Saturday", "Sunday" );

   return "$weekday[$wday - 1], $mday-$month-$year $hour\:$min\:$sec GMT";
}
