#!/usr/bin/perl
# Banner Exchanger
# Provided By CGI Connection
# http://www.CGIConnection.com

$| = 1;

use CGI;

$query = new CGI;
$query->import_names();

srand();

# Location to store advertising credits
# Eg. /your/path/bannerex/credits
$credits_dir = "!SAVEDIR!/bannerex/credits";

# Location to store Impressions, Clicks and IP addresses
# Eg. /your/path/bannerex/ici
$ici_dir = "!SAVEDIR!/bannerex/ici";

# Location to store user information
# Eg. /your/path/bannerex/users
$user_dir = "!SAVEDIR!/bannerex/users";

# Temporary directory
# Eg. /your/path/bannerex/tmp
$temp_dir = "!SAVEDIR!/bannerex/tmp";

# Absolute directory where your banners will be stored
# Directory must be placed where your web pages are so
# they are accessible via the web
# Eg. /path/to/your/web/pages/bannerex
$web_dir = "!SAVEDIR!/bannerex/banners";

# URL to the directory above
# Eg. http://www.yourserver.com/bannerex
$web_url = "http://!SITEURL!/bannerex/banners";

# URL where bannerex.cgi script resides
# Eg. http://www.yourserver.com/cgi-bin/bannerex.cgi
$script_location = "http://!CGIURL!/bannerex.cgi";

# Default width and height banners should be displayed as
$width = 468;
$height = 60;

# Maximum banner size in bytes
$max_banner_size = 12288;

# Default administration username
$user_admin = "admin";

# For every x impressions displayed, user will get x impressions
$impressions_displayed = 1;
$impressions_get = 1;

# For every x clicks sent, user will get x clicks
$clicks_sent = 1;
$clicks_get = 1;

# Don't give impression credit until x seconds after last impression
$max_impression_time = 60;

# Don't give click credit until x seconds after last click
$max_click_time = 60;

# Background colors for upload banner section
$first_color = "CCCCCC";
$sec_color = "CCCCCC";
$space_color = "FFFFCC";


#######################################
$area = "\L$Q::area\E";
$username = "\L$Q::username\E";
$searchname = "\L$Q::searchname\E";
$password = "\L$Q::password\E";
$user_admin = "\L$user_admin\E";
$mode = $Q::mode;
$number = $Q::number;
$ip_address = $ENV{'REMOTE_ADDR'};

if ($area eq "click")
 {
 $url = &check_click;
 print "Location: $url\n\n";
 exit;
 }

if ($area ne "")
 {
 print "Content-type: text/html\n\n";
 }
 else
 {
 if ($username eq "" or $number eq "")
  {
  print "Content-type: text/html\n\n";
  print "document.write('You must specify a username and banner number')\n";
  exit;
  }

 ($chose_user, $chose_banner) = &check_credits;

 if ($mode == 1)
  {
  print "Location: $web_url/$chose_user/$chose_banner\n\n";
  }
  else
  {
  print "Content-type: text/html\n\n";
  print "document.write('<A HREF=\"$script_location?area=click&username=$username&number=$number\">');\n";
  print "document.write('<IMG SRC=\"$web_url\/$chose_user\/$chose_banner\" BORDER=\"0\" WIDTH=\"$width\" HEIGHT=\"$height\"></A>');\n";
  }

 exit;
 }

if ($area eq "login")
 {
 &login_screen;
 exit;
 }

if ($area eq "stats")
 {
 &check_login;
 &get_stats("$username");
 exit;
 }

if ($area eq "reset")
 {
 &check_login;
 &reset_stats("$username");
 exit;
 }

if ($area eq "menu")
 {
 &check_login;

 if ($user_admin eq $username)
  {
  &admin_menu_screen;
  exit;
  }
  else
  {
  &menu_screen;
  exit;
  }
 }

if ($area eq "new")
 {
 &new_screen;
 exit;
 }

if ($area eq "search")
 {
 &check_login;

 if ($user_admin ne $username)
  {
  print "<HTML><BODY>You do not have access to search.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }
 
 &search_screen;
 exit;
 }

if ($area eq "searchnow")
 {
 &check_login;

 if ($user_admin ne $username)
  {
  print "<HTML><BODY>You do not have access to search.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }
 
 &search_now;
 exit;
 }

if ($area eq "adminedit")
 {
 &check_login;

 if ($user_admin ne $username)
  {
  print "<HTML><BODY>You do not have access to search.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }
 
 &admin_edit_screen;
 &get_stats("$searchname");
 exit;
 }

if ($area eq "adminsave")
 {
 &check_login;

 if ($user_admin ne $username)
  {
  print "<HTML><BODY>You do not have access to save.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }

 $olduser = $username;
 $username = $searchname;
 &get_user;

 $Q::stats1 = $stats1;
 $Q::stats2 = $stats2;
 $Q::stats3 = $stats3;
 $Q::stats4 = $stats4;
 $Q::stats5 = $stats5;

 &save_user;

 &lock("$username\.creditslock");
 open(USER, ">$credits_dir\/$username");
 print USER "$Q::rimp\|$Q::rclick\n";
 close(USER);
 &unlock("$username\.creditslock");

 &reset_stats("$username");

 $username = $olduser;

 print "<HTML><BODY><A HREF=\"$ENV{'SCRIPT_NAME'}?area=adminedit&username=$username&password=$password&searchname=$searchname\">$searchname</A> has been updated.<BR><BR>\n";
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
 print "</BODY></HTML>\n";
 exit;
 }

if ($area eq "edit")
 {
 &check_login;
 &edit_screen;
 exit;
 }

if ($area eq "save")
 {
 &check_login;
 &get_user;

 $Q::stats1 = $stats1;
 $Q::stats2 = $stats2;
 $Q::stats3 = $stats3;
 $Q::stats4 = $stats4;
 $Q::stats5 = $stats5;

 &save_user;

 print "<HTML><BODY>Your profile has been updated.<BR><BR>\n";
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$Q::passwordnew\">Menu</A>\n";
 print "</BODY></HTML>\n";
 exit;
 }

if ($area eq "savenew")
 {
 if ($username eq "" or $password eq "" or $Q::email eq "" or $Q::first eq "" or $Q::last eq "")
  {
  print "<HTML><BODY>You must fill in all fields.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if ($Q::email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ || $Q::email !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
  {
  print "<HTML><BODY>You have supplied and invalid e-mail address.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }

 if (-e "$user_dir\/$username")
  {
  print "<HTML><BODY><B>$username</B> is already in use.<BR><BR>\n";
  print "</BODY></HTML>\n";
  exit;
  }

 &save_new_user;

 print "<HTML><BODY>Thank you for joining.<BR><BR>\n";
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
 print "</BODY></HTML>\n";
 exit;
 }

if ($area eq "upload")
 {
 &check_login;
 &upload_screen;
 exit;
 }

if ($area eq "uploadfile")
 {
 &check_login;
 &upload_file;

 print "All Done.<BR><BR>\n";
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
 print "</BODY></HTML>\n";
 exit;
 }

exit;

sub upload_file
{
print "<HTML><BODY>\n";

for ($j = 1; $j < 6; $j++)
 {
 $tempname2 = int(rand(1000000000));

 $tempname = "$temp_dir$tempname2\.ban";
 $tmpban = "banner$j";

 $urlname1 = "url$j";
 $urlname2 = $query->param($urlname1);

 $delname1 = "del$j";
 $delname2 = $query->param($delname1);

 $banner_name = "";

 if ($query->param($tmpban))
  {
  open(FILEUP, ">$tempname");
  $syllabus = $query->param($tmpban);

  while($bytesread=read($syllabus, $buffer, 4096))
   {
   print FILEUP $buffer;
   }

  close(FILEUP);

  if (-s "$tempname" > 0 and $urlname2 ne "" and "\L$urlname2\E" ne "http://")
   {
   $size = -s "$tempname";
   
   if (not -e "$web_dir\/$username")
    {
    mkdir("$web_dir\/$username", 0777);
    chmod (0777, "$web_dir\/$username");
    }

   $bidx = rindex($syllabus, ".");
   $bext = substr($syllabus, $bidx + 1);
   $bext = "\L$bext\E";

   if ("\U$bext\E" ne "GIF" and "\U$bext\E" ne "JPG" and "\U$bext\E" ne "JPEG")
    {
    unlink("$tempname");
    print "You may only upload GIF or JPG files<BR><BR>\n";
    print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
    print "</BODY></HTML>\n";
    exit;
    }

   if ($size > $max_banner_size)
    {
    unlink("$tempname");
    print "Banners must be $max_banner_size bytes in size or under<BR>\n";
    print "This banner is $size bytes<BR><BR>\n";
    print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
    print "</BODY></HTML>\n";
    exit;
    }

   $banner_name = int(rand(10000000000));
   $banner_name = "\L$banner_name\.$bext\E";
   rename("$tempname","$web_dir\/$username\/$banner_name");
   ($impressions, $clicks, $impression_time, $click_time, $banner_oldname, $banner_url, $chose_banner_number) = &get_banner("$j", "$username");

   if (-e "$web_dir\/$username\/$banner_oldname")
    {
    unlink("$web_dir\/$username\/$banner_oldname");
    }

#   &save_banner("$j", "$banner_name", "$urlname2");
   }
   else
   {
   unlink("$tempname");

   if ($urlname2 eq "" or "\L$urlname2\E" eq "http://")
    {
    print "You must supply the URL for banner #$j<BR>\n";
    }
    else
    {
    print "Banner #$j did not upload<BR>\n";
    }
   }
  }

 if ($urlname2 eq "" or substr("\L$urlname2\E", 0, 7) ne "http://")
  {
  ($impressions, $clicks, $impression_time, $click_time, $banner_oldname, $banner_url, $chose_banner_number) = &get_banner("$j", "$username");
  $now_url = $banner_url;
  print "Invalid URL specified for banner #$j<BR>\n";
  }
  else
  {
  $now_url = $urlname2;
  }

 &save_banner("$j", "$impression_time", "$click_time", "$banner_name", "$now_url", "$delname2");
 }
}

sub login_screen
{

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="menu">
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

sub search_screen
{

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger Search</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="searchnow">
<INPUT TYPE=hidden NAME=username VALUE="$username">
<INPUT TYPE=hidden NAME=password VALUE="$password">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=searchname></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Search"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}


sub menu_screen
{

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>

<TABLE BORDER=0>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=edit&username=$username&password=$password">Edit Profile</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=upload&username=$username&password=$password">Upload Banners</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=stats&username=$username&password=$password">Check Statistics</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=login">Logout</A></TD></TR>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub admin_menu_screen
{

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>

<TABLE BORDER=0>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=edit&username=$username&password=$password">Edit Profile</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=upload&username=$username&password=$password">Upload Banners</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=stats&username=$username&password=$password">Check Statistics</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=search&username=$username&password=$password">Search for User</A></TD></TR>
<TR><TD><A HREF="$ENV{'SCRIPT_NAME'}?area=login">Logout</A></TD></TR>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub edit_screen
{
&get_user;

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME=area VALUE="save">
<INPUT TYPE=HIDDEN NAME=username VALUE="$username">
<INPUT TYPE=HIDDEN NAME=password VALUE="$password">
<TABLE BORDER=0>
<TR><TD><B>First Name:</B></TD> <TD><INPUT NAME=first VALUE="$first2"></TD></TR>
<TR><TD><B>Last Name:</B></TD> <TD><INPUT NAME=last VALUE="$last2"></TD></TR>
<TR><TD><B>E-mail:</B></TD> <TD><INPUT NAME=email VALUE="$email2"></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=passwordnew VALUE="$password2"></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Save"></TD></TR>
</TABLE>
</FORM>

</CENTER>
</BODY></HTML>
END
}

}

sub admin_edit_screen
{
$olduser = $username;
$username = $searchname;
&get_user;
$username = $olduser;

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME=area VALUE="adminsave">
<INPUT TYPE=HIDDEN NAME=username VALUE="$username">
<INPUT TYPE=HIDDEN NAME=password VALUE="$password">
<INPUT TYPE=HIDDEN NAME=searchname VALUE="$searchname">
<TABLE BORDER=0>
<TR><TD><B>Username:</B></TD> <TD>$searchname</TD></TR>
<TR><TD><B>First Name:</B></TD> <TD><INPUT NAME=first VALUE="$first2"></TD></TR>
<TR><TD><B>Last Name:</B></TD> <TD><INPUT NAME=last VALUE="$last2"></TD></TR>
<TR><TD><B>E-mail:</B></TD> <TD><INPUT NAME=email VALUE="$email2"></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT NAME=passwordnew VALUE="$password2"></TD></TR>
</TABLE>

<BR><A HREF="$ENV{'SCRIPT_NAME'}?area=upload&username=$searchname&password=$password2" target=_blank>View Banners</A><BR>
END
}

}

sub new_screen
{

{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME=area VALUE="savenew">
<TABLE BORDER=0>
<TR><TD><B>First Name:</B></TD> <TD><INPUT NAME=first></TD></TR>
<TR><TD><B>Last Name:</B></TD> <TD><INPUT NAME=last></TD></TR>
<TR><TD><B>E-mail:</B></TD> <TD><INPUT NAME=email></TD></TR>
<TR><TD><B>Username:</B></TD> <TD><INPUT TYPE=username NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Join"></TD></TR>
</TABLE>
</FORM>

</CENTER>
</BODY></HTML>
END
}

}


sub upload_screen
{

{
print<<END
<HTML>

<META NAME="Pragma" CONTENT="no-cache">
<META NAME="Cache-Control" CONTENT="no-cache">
<META NAME="Expires" CONTENT="0">

<TITLE>Banner Exchanger Upload</TITLE>
<BODY>
<CENTER>
<H2>Banner Exchanger</H2>
<A HREF="$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password">Menu</A>

<BR><BR>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}" enctype="multipart/form-data">
<INPUT TYPE=HIDDEN NAME=area VALUE="uploadfile">
<INPUT TYPE=HIDDEN NAME=username VALUE="$username">
<INPUT TYPE=HIDDEN NAME=password VALUE="$password">
<TABLE BORDER=1 CELLPADDING=0 CELLSPACING=0>
<TR BGCOLOR="$space_color"><TD COLSPAN=2><BR><BR></TD></TR>
END
}

$color_num = 0;

for ($j = 1; $j < 6; $j++)
 {
 if ($color_num == 0)
  {
  $now_color = $first_color;
  $color_num = 1;
  }
  else
  {
  $now_color = $sec_color;
  $color_num = 0;
  }

 $bext = "";
 print "<TR BGCOLOR=\"$now_color\"><TD><B>BANNER #$j:</B></TD> <TD><INPUT NAME=banner$j TYPE=file></TD></TR>\n";

 ($impressions, $clicks, $impression_time, $click_time, $banner_name, $banner_url, $chose_banner_number) = &get_banner("$j", "$username");

 if ($banner_name ne "")
  {
  print "<TR BGCOLOR=\"$now_color\"><TD COLSPAN=2><IMG SRC=\"$web_url\/$username\/$banner_name\" BORDER=0></TD></TR>\n";
  }

 if ($banner_url eq "")
  {
  $banner_url = "http://";
  }

 print "<TR BGCOLOR=\"$now_color\"><TD><B>URL #$j:</B></TD> <TD><INPUT NAME=url$j VALUE=\"$banner_url\" SIZE=40> <B>Delete?</B> <INPUT TYPE=checkbox NAME=del$j VALUE=\"YES\"></TD></TR>\n";
 print "<TR BGCOLOR=\"$space_color\"><TD COLSPAN=2><BR><BR></TD></TR>\n";
 }

{
print<<END
<TR BGCOLOR=\"$space_color\"><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Upload"></TD></TR>
</TABLE>
</FORM>

</CENTER>
</BODY></HTML>
END
}

}

sub check_login
{
if ($username eq "" or $password eq "")
 {
 print "<HTML><BODY>You must enter a username and password</BODY></HTML>\n";
 exit;
 }

if (not -e "$user_dir\/$user_admin")
 {
 open(USER, ">$user_dir\/$user_admin");
 print USER "Admin\n";
 print USER "Admin\n";
 print USER "your\@email.com\n";
 print USER "$user_admin\n";
 print USER "\n";
 print USER "\n";
 print USER "\n";
 print USER "\n";
 print USER "\n";
 close(USER);

 $password = $user_admin;
 }

if (not -e "$user_dir\/$username")
 {
 print "<HTML><BODY>Invalid Username</BODY></HTML>\n";
 exit;
 }

&get_user;

if ($password2 ne $password)
 {
 print "<HTML><BODY>Invalid Password</BODY></HTML>\n";
 exit;
 }
}

sub lock
{
my $lock_name = @_[0];
my $locks = "$temp_dir\/";
my $lock_timer = 0;
my $lock_timer_stop = 0;
my $lock_passed = 0;

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
  print LOCKIT "LOCKED\n";
  close (LOCKIT);
  }
  else
  {
  $idle_max = 30;
  splice(@lock_info, 0);
  @lock_info=stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @lock_info;

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
my $locks = "$temp_dir\/";
my $lock_name = @_[0];
unlink ("$locks$lock_name");
}

sub get_user
{
&lock("$username\.lock");

open(USER, "<$user_dir\/$username");
$first2 = <USER>;
$last2 = <USER>;
$email2 = <USER>;
$password2 = <USER>;
$stats1 = <USER>;
$stats2 = <USER>;
$stats3 = <USER>;
$stats4 = <USER>;
$stats5 = <USER>;
close(USER);

&unlock("$username\.lock");

chop($first2);
chop($last2);
chop($email2);
chop($password2);
chop($stats1);
chop($stats2);
chop($stats3);
chop($stats4);
chop($stats5);
}

sub save_user
{
&lock("$username\.lock");

open(USER, ">$user_dir\/$username");
print USER "$Q::first\n";
print USER "$Q::last\n";
print USER "$Q::email\n";
print USER "$Q::passwordnew\n";
print USER "$Q::stats1\n";
print USER "$Q::stats2\n";
print USER "$Q::stats3\n";
print USER "$Q::stats4\n";
print USER "$Q::stats5\n";
close(USER);

&unlock("$username\.lock");
}

sub save_new_user
{
if ($username eq "")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>You must fill in all fields</BODY></HTML>\n";
 exit;
 }

if (-e "$user_dir\/$username")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>$username is already taken.</BODY></HTML>\n";
 exit;
 }

&lock("$username\.lock");

open(USER, ">$user_dir\/$username");
print USER "$Q::first\n";
print USER "$Q::last\n";
print USER "$Q::email\n";
print USER "$Q::password\n";
close(USER);

&unlock("$username\.lock");
}

sub save_banner
{
my ($number, $impression_time, $click_time, $banner_name, $banner_url, $del_banner) = @_;
my $x;
my $timenow = time();

splice(@all_banners, 0);

&lock("$username\.lock");

open(USER, "<$user_dir\/$username");
$first2 = <USER>;
$last2 = <USER>;
$email2 = <USER>;
$password2 = <USER>;
$line = <USER>;
chop($line);
@all_banners[1] = $line;
$line = <USER>;
chop($line);
@all_banners[2] = $line;
$line = <USER>;
chop($line);
@all_banners[3] = $line;
$line = <USER>;
chop($line);
@all_banners[4] = $line;
$line = <USER>;
chop($line);
@all_banners[5] = $line;

close(USER);

open(USER, ">$user_dir\/$username");
print USER "$first2";
print USER "$last2";
print USER "$email2";
print USER "$password2";

for ($x = 1; $x < 6; $x++)
 {
 if ($x == $number and $del_banner ne "")
  {
  splice(@all_binfo, 0);
  @all_binfo = split(/\|/, @all_banners[$x]);

  if (-e "$web_dir\/$username\/@all_binfo[4]" and @all_binfo[4] ne "")
   {
   unlink("$web_dir\/$username\/@all_binfo[4]");
   }

  @all_banners[$x] = "";
  $impression_time = "";
  $click_time = "";
  $banner_name = "";
  $banner_url = "";
  }

 if ($x == $number and $banner_name ne "")
  {
  splice(@all_binfo, 0);
  @all_binfo = split(/\|/, @all_banners[$x]);
  print USER "@all_binfo[0]\|@all_binfo[1]\|$impression_time\|$click_time\|$banner_name\|$banner_url\n";
  }
  elsif ($x == $number and $banner_name eq "")
  { 
  splice(@all_binfo, 0);
  @all_binfo = split(/\|/, @all_banners[$x]);
  print USER "@all_binfo[0]\|@all_binfo[1]\|$impression_time\|$click_time\|@all_binfo[4]\|$banner_url\n";
  }
  else
  {
  print USER "@all_banners[$x]\n";
  }
 }

close(USER);
&unlock("$username\.lock");
}

sub get_banner
{
my ($bnumber, $banusername) = @_;
my $count = 1, $found = 0, @all_binfo; $foundt = 0; @all_linfo, @all_banners, @all_bnumbers, $banner_count = 0;

splice(@all_banners, 0);
splice(@all_bnumbers, 0);

&lock("$banusername\.lock");

open(USERB, "<$user_dir\/$banusername");
$first2 = <USERB>;
$last2 = <USERB>;
$email2 = <USERB>;
$password2 = <USERB>;

until(eof(USERB) or $found == 1)
 {
 $line = <USERB>;
 chop($line);

 splice(@all_binfo, 0);
 @all_binfo = split(/\|/, $line);

 if (@all_binfo[4] ne "")
  {
  @all_banners[$banner_count] = $line;
  @all_bnumbers[$banner_count] = $count;
  $banner_count++;
  }

 if ($count == $bnumber)
  {
  $found = 1;
  }

 $count++;
 }

close(USERB);
&unlock("$banusername\.lock");

if ($bnumber eq "" or $bnumber == 0)
 {
 $banner_count = @all_banners;
 $bnumber = int(rand($banner_count));
 splice(@all_binfo, 0);
 $line = @all_banners[$bnumber];
 @all_binfo = split(/\|/, $line);
 $bnumber = @all_bnumbers[$bnumber];
 $found = 1;
 }

if ($found == 0)
 {
 splice(@all_binfo, 0);
 }
 else
 {
 splice(@all_track, 0);
 $tcount = 0;
 $founditem = 0;
 $maxlines = 50;

 $timenow = time();

 #Write trackig information to username that displayed banner
 &lock("$username\.tracklock");
 open(USER, "<$ici_dir\/$username\.track");

 until(eof(USER) or $foundt == 1)
  {
  $line = <USER>;
  chop($line);
  splice(@all_linfo, 0);

  @all_linfo = split(/\|/, $line);

  if (@all_linfo[0] eq "")
   {
   $foundt = 1;
   }
  
  if (@all_linfo[1] eq $ip_address and @all_linfo[3] eq $number)
   {
   @all_linfo[0] = $banusername;
   @all_linfo[2] = $timenow;
   @all_linfo[4] = $bnumber;
   @all_linfo[5] = @all_binfo[5];
   $line2 = join('|', @all_linfo);
   @all_track[$tcount] = $line2;
   $founditem = 1;
   }
   else
   {
   @all_track[$tcount] = $line;
   }

  $tcount++;
  }

 close(USER);

 open(USER, ">$ici_dir\/$username\.track");

 if ($founditem == 0)
  {
  $maxlines--;
  print USER "$banusername\|$ip_address\|$timenow\|$number\|$bnumber\|@all_binfo[5]\n";
  }

 for ($x = 0; $x < $maxlines; $x++)
  {
  print USER "@all_track[$x]\n";
  }

 close(USER);
 &unlock("$username\.tracklock");
 }

return("@all_binfo[0]", "@all_binfo[1]", "@all_binfo[2]", "@all_binfo[3]", "@all_binfo[4]", "@all_binfo[5]", "$bnumber");
}

sub check_credits
{
if (not -e "$credits_dir")
 {
 mkdir("$credits_dir", 0777);
 chmod (0777, "$credits_dir");
 }

splice(@all_users, 0);
opendir(USERSD, "$credits_dir");
@all_users = readdir(USERSD);
closedir(USERSD);
splice(@all_users, 0, 2);

$user_count = @all_users;

if ($user_count <= 0)
 {
 $chose_user = $user_admin;
 }
 else
 {
 $pick_number = $user_count + 1;
 $foundpn = 0;

 until ($pick_number < $user_count or $foundpn == 1)
  {
  $pick_number = int(rand($user_count));

  if (@all_users[$pick_number] eq $username and $user_count > 1)
   {
   $pick_number = $user_count + 1;
   }

  if (@all_users[$pick_number] eq $username and $user_count == 1)
   {
   $pick_number = 0;
   $foundpn = 1;
   }

  if (@all_users[$pick_number] eq $user_admin and $user_count == 1)
   {
   $pick_number = 0;
   $foundpn = 1;
   }
  }

 if ($foundpn == 0)
  {
  $chose_user = @all_users[$pick_number];
  }
  else
  {
  $chose_user = $user_admin;
  }
 }

 ($impressions, $clicks, $impression_time, $click_time, $banner_oldname, $banner_url, $chose_banner_number) = &get_banner(0, "$chose_user");

 if ($banner_oldname ne "")
  {
  $found = 1;
  }

# Add 1 impression received to account that banner was displayed from
$result = &add_impressions("$chose_user", "1", "$chose_banner_number");

#Add 1 impression credit to username that displayed banner

if ($result == 1)
 {
 &apply_credits("$username",1,0);
 &apply_credits("$chose_user",-1,0);
 }

return("$chose_user","$banner_oldname");
}

sub add_impressions
{
my ($chose_name, $impression_count, $banner_number) = @_;
my $found;

if ($chose_name eq "" or not -e "$user_dir\/$chose_name" or $impression_count <= 0)
 {
 return;
 }

splice(@all_imps, 0);
splice(@all_ips, 0);
splice(@all_times, 0);
splice(@get_ips, 0);
splice(@get_times, 0);

&lock("$chose_name\.implock");

open(USER, "<$ici_dir\/$chose_name\.imp");

# Get Impression Counts
$line = <USER>;
chop($line);
@all_imps[1] = $line;
$line = <USER>;
chop($line);
@all_imps[2] = $line;
$line = <USER>;
chop($line);
@all_imps[3] = $line;
$line = <USER>;
chop($line);
@all_imps[4] = $line;
$line = <USER>;
chop($line);
@all_imps[5] = $line;

# Get IP Addresses and Times
$line = <USER>;
chop($line);
@all_ips[1] = $line;
$line = <USER>;
chop($line);
@all_times[1] = $line;
$line = <USER>;
chop($line);
@all_ips[2] = $line;
$line = <USER>;
chop($line);
@all_times[2] = $line;
$line = <USER>;
chop($line);
@all_ips[3] = $line;
$line = <USER>;
chop($line);
@all_times[3] = $line;
$line = <USER>;
chop($line);
@all_ips[4] = $line;
$line = <USER>;
chop($line);
@all_times[4] = $line;
$line = <USER>;
chop($line);
@all_ips[5] = $line;
$line = <USER>;
chop($line);
@all_times[5] = $line;

close(USER);

@get_ips = split(/\|/, @all_ips[$banner_number]);
@get_times = split(/\|/, @all_times[$banner_number]);

$found = 0;
$time_now = time();

$new_ips = "";
$new_times = "";
$last_time = 0;
$last_time_num = 0;

for ($x = 0; $x < 50; $x++)
 {
 if ($last_time >= @get_times[$x] or @get_times[$x] <= 0)
  {
  $last_time = @get_times[$x];
  $last_time_num = $x;
  }

 if ($ip_address eq @get_ips[$x])
  {
  if ((@get_times[$x] + $max_impression_time) > $time_now and @get_times[$x] > 0)
   {
   $found = 1;
   }
   else
   {
   $found = 2;
   @get_ips[$x] = "$ip_address";
   @get_times[$x] = "$time_now";
   }
  }
 }

if ($found == 0)
 {
 @get_ips[$last_time_num] = $ip_address;
 @get_times[$last_time_num] = $time_now;
 }

$ipsjoin = join('|', @get_ips);
$timesjoin = join('|', @get_times);
@all_ips[$banner_number] = $ipsjoin;
@all_times[$banner_number] = $timesjoin;

if ($found == 0 or $found == 2)
 {
 # OK to add impressions
 @all_imps[$banner_number] = @all_imps[$banner_number] + $impression_count;
 $foundstat = 1;
 }
 else
 {
 # Already displayed banner and gave credits, don't give again
 $foundstat = 0;
 }

open(USER, ">$ici_dir\/$chose_name\.imp");

for ($x = 1; $x < 6; $x++)
 {
 print USER "@all_imps[$x]\n";
 }

for ($x = 1; $x < 6; $x++)
 {
 print USER "@all_ips[$x]\n";
 print USER "@all_times[$x]\n";
 }

close(USER);
&unlock("$chose_name\.implock");
return($foundstat);
}

sub add_clicks
{
my ($chose_name, $click_count, $banner_number) = @_;
my $found;

if ($chose_name eq "" or not -e "$user_dir\/$chose_name" or $click_count <= 0)
 {
 return;
 }

splice(@all_clicks, 0);
splice(@all_ips, 0);
splice(@all_times, 0);
splice(@get_ips, 0);
splice(@get_times, 0);

&lock("$chose_name\.clicklock");

open(USER, "<$ici_dir\/$chose_name\.click");

# Get Click Counts
$line = <USER>;
chop($line);
@all_clicks[1] = $line;
$line = <USER>;
chop($line);
@all_clicks[2] = $line;
$line = <USER>;
chop($line);
@all_clicks[3] = $line;
$line = <USER>;
chop($line);
@all_clicks[4] = $line;
$line = <USER>;
chop($line);
@all_clicks[5] = $line;

# Get IP Addresses and Times
$line = <USER>;
chop($line);
@all_ips[1] = $line;
$line = <USER>;
chop($line);
@all_times[1] = $line;
$line = <USER>;
chop($line);
@all_ips[2] = $line;
$line = <USER>;
chop($line);
@all_times[2] = $line;
$line = <USER>;
chop($line);
@all_ips[3] = $line;
$line = <USER>;
chop($line);
@all_times[3] = $line;
$line = <USER>;
chop($line);
@all_ips[4] = $line;
$line = <USER>;
chop($line);
@all_times[4] = $line;
$line = <USER>;
chop($line);
@all_ips[5] = $line;
$line = <USER>;
chop($line);
@all_times[5] = $line;

close(USER);

@get_ips = split(/\|/, @all_ips[$banner_number]);
@get_times = split(/\|/, @all_times[$banner_number]);

$found = 0;
$time_now = time();

$new_ips = "";
$new_times = "";
$last_time = 0;
$last_time_num = 0;

for ($x = 0; $x < 50; $x++)
 {
 if ($last_time >= @get_times[$x] or @get_times[$x] <= 0)
  {
  $last_time = @get_times[$x];
  $last_time_num = $x;
  }

 if ($ip_address eq @get_ips[$x])
  {
  if ((@get_times[$x] + $max_click_time) > $time_now and @get_times[$x] > 0)
   {
   $found = 1;
   }
   else
   {
   $found = 2;
   @get_ips[$x] = "$ip_address";
   @get_times[$x] = "$time_now";
   }
  }
 }

if ($found == 0)
 {
 @get_ips[$last_time_num] = $ip_address;
 @get_times[$last_time_num] = $time_now;
 }

$ipsjoin = join('|', @get_ips);
$timesjoin = join('|', @get_times);
@all_ips[$banner_number] = $ipsjoin;
@all_times[$banner_number] = $timesjoin;

if ($found == 0 or $found == 2)
 {
 # OK to add clicks
 @all_clicks[$banner_number] = @all_clicks[$banner_number] + $click_count;
 $foundstat = 1;
 }
 else
 {
 # Already clicked on banner and gave credits, don't give again
 $foundstat = 0;
 }

open(USER, ">$ici_dir\/$chose_name\.click");

for ($x = 1; $x < 6; $x++)
 {
 print USER "@all_clicks[$x]\n";
 }

for ($x = 1; $x < 6; $x++)
 {
 print USER "@all_ips[$x]\n";
 print USER "@all_times[$x]\n";
 }

close(USER);
&unlock("$chose_name\.clicklock");
return($foundstat);
}

sub apply_credits
{
my ($chose_name, $impressions, $clicks) = @_;
splice(@all_credits, 0);
splice(@all_credits2, 0);
$doit = 0;

if ($chose_name eq "" or not -e "$user_dir\/$chose_name")
 {
 return;
 }

&lock("$chose_name\.creditslock");
open(USER, "<$ici_dir\/$chose_name\.credits");
$line = <USER>;
chop($line);
close(USER);

@all_credits = split(/\|/, $line);

&lock("$chose_name\.creditslock2");
open(USER2, "<$credits_dir\/$chose_name");
$line = <USER2>;
chop($line);
close(USER2);

@all_credits2 = split(/\|/, $line);

# Adjust remaining impressions
if ($area ne "click")
 {
 if ($impressions > 0)
  {
  if (@all_credits[0] >= $impressions_displayed)
   {
   @all_credits2[0] = @all_credits2[0] + $impressions_get;
   @all_credits[0] = 0;
   }
   else
   {
   @all_credits[0]++;
   }
  }
  else
  {
  @all_credits2[0] = @all_credits2[0] - 1;
  }
 }

# Adjust remaining clicks
if ($area eq "click")
 {
 if ($clicks > 0)
  {
  if (@all_credits[1] >= $clicks_sent)
   {
   @all_credits2[1] = @all_credits2[1] + $clicks_get;
   @all_credits[1] = 0;
   }
   else
   {
   @all_credits[1]++;
   }
  }
  else
  {
  @all_credits2[1] = @all_credits2[1] - 1;
  }
 }

if (@all_credits2[0] < 0)
 {
 @all_credits2[0] = 0;
 }

if (@all_credits2[1] < 0)
 {
 @all_credits2[1] = 0;
 }
 
if (@all_credits2[0] > 0 or @all_credits2[1] > 0)
 {
 open(USER2, ">$credits_dir\/$chose_name");
 print USER2 "@all_credits2[0]\|@all_credits2[1]\n";
 close(USER2);
 }
 else
 {
 unlink("$credits_dir\/$chose_name");
 }

open(USER, ">$ici_dir\/$chose_name\.credits");
print USER "@all_credits[0]\|@all_credits[1]\n";
close(USER);

&unlock("$chose_name\.creditslock2");
&unlock("$chose_name\.creditslock");
}

sub check_click
{
my $founditem = 0, $foundt = 0, @all_linfo;

if ($username eq "")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>Invalid username.  The system cannot forward you to the associated web site.</BODY></HTML>\n";
 exit;
 }

&lock("$username\.tracklock");
open(USER, "<$ici_dir\/$username\.track");

until(eof(USER) or $foundt == 1)
 {
 $line = <USER>;
 chop($line);
 splice(@all_linfo, 0);

 @all_linfo = split(/\|/, $line);

 if (@all_linfo[0] eq "")
  {
  $foundt = 1;
  }
  
 if (@all_linfo[1] eq $ip_address and @all_linfo[3] eq $number)
  {
  $foundt = 1;
  $founditem = 1;
  }
 }

close(USER);
&unlock("$username\.tracklock");

if ($founditem == 0)
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>Information is no longer available.  The system cannot forward you to the associated web site.</BODY></HTML>\n";
 exit;
 }

$result = &add_clicks("@all_linfo[0]", "1", "@all_linfo[4]");

if ($result == 1)
 {
 &apply_credits("$username",0,1);
 &apply_credits("@all_linfo[0]",0,-1);
 }

return("@all_linfo[5]");
}

sub get_stats
{
my ($chose_name) = @_[0];
my @all_imps, @all_clicks;

splice(@all_imps, 0);
splice(@all_clicks, 0);

&lock("$chose_name\.implock");

open(USER, "<$ici_dir\/$chose_name\.imp");

# Get Impression Counts
$line = <USER>;
chop($line);
@all_imps[1] = $line;
$line = <USER>;
chop($line);
@all_imps[2] = $line;
$line = <USER>;
chop($line);
@all_imps[3] = $line;
$line = <USER>;
chop($line);
@all_imps[4] = $line;
$line = <USER>;
chop($line);
@all_imps[5] = $line;
close(USER);

&unlock("$chose_name\.implock");
&lock("$chose_name\.clicklock");

open(USER, "<$ici_dir\/$chose_name\.click");

# Get Click Counts
$line = <USER>;
chop($line);
@all_clicks[1] = $line;
$line = <USER>;
chop($line);
@all_clicks[2] = $line;
$line = <USER>;
chop($line);
@all_clicks[3] = $line;
$line = <USER>;
chop($line);
@all_clicks[4] = $line;
$line = <USER>;
chop($line);
@all_clicks[5] = $line;
close(USER);

&unlock("$chose_name\.clicklock");

&lock("$chose_name\.creditslock");

open(USER, "<$credits_dir\/$chose_name");
$line = <USER>;
chop($line);
close(USER);

&unlock("$chose_name\.creditslock");

splice(@all_credits, 0);
@all_credits = split(/\|/, $line);

$impcount = 0;

for ($x = 1; $x < 6; $x++)
 {
 $impcount = $impcount + @all_imps[$x];
 }

$clickcount = 0;
$ratiocount = 0;

for ($x = 1; $x < 6; $x++)
 {
 $clickcount = $clickcount + @all_clicks[$x];

 if (@all_clicks[$x] > 0)
  {
  @all_ratio[$x] = @all_imps[$x] / @all_clicks[$x];
  $ratiocount = $ratiocount + @all_ratio[$x];
  }
 }

$ratiototal = $ratiocount / 5;

if ($area ne "adminedit")
{
print<<END
<HTML>
<TITLE>Banner Exchanger</TITLE>
<BODY>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=HIDDEN NAME=area VALUE="reset">
<INPUT TYPE=HIDDEN NAME=username VALUE="$username">
<INPUT TYPE=HIDDEN NAME=password VALUE="$password">
END
}

{
print<<END
<CENTER>
<TABLE BORDER=1>
<TR BGCOLOR="$first_color"><TD><B>Banner</B></TD> <TD><B>Impressions</B></TD> <TD><B>Clicks</B></TD> <TD><B>IMP to CLICK</B></TD> <TD><B>Reset</B></TD></TR>
<TR><TD>#1</TD> <TD>@all_imps[1]</TD> <TD>@all_clicks[1]</TD> <TD>@all_ratio[1]\%</TD> <TD><INPUT TYPE=CHECKBOX NAME=banreset1 VALUE="YES"></TD></TR>
<TR><TD>#2</TD> <TD>@all_imps[2]</TD> <TD>@all_clicks[2]</TD> <TD>@all_ratio[2]\%</TD> <TD><INPUT TYPE=CHECKBOX NAME=banreset2 VALUE="YES"></TD></TR>
<TR><TD>#3</TD> <TD>@all_imps[3]</TD> <TD>@all_clicks[3]</TD> <TD>@all_ratio[3]\%</TD> <TD><INPUT TYPE=CHECKBOX NAME=banreset3 VALUE="YES"></TD></TR>
<TR><TD>#4</TD> <TD>@all_imps[4]</TD> <TD>@all_clicks[4]</TD> <TD>@all_ratio[4]\%</TD> <TD><INPUT TYPE=CHECKBOX NAME=banreset4 VALUE="YES"></TD></TR>
<TR><TD>#5</TD> <TD>@all_imps[5]</TD> <TD>@all_clicks[5]</TD> <TD>@all_ratio[5]\%</TD> <TD><INPUT TYPE=CHECKBOX NAME=banreset5 VALUE="YES"></TD></TR>
<TR><TD><B>Total:</B></TD> <TD>$impcount</TD> <TD>$clickcount</TD> <TD COLSPAN=2>$ratiototal\%</TD></TR>
END
}

if ($area ne "adminedit")
 {
 print "<TR><TD><B>Remaining:</B></TD> <TD>@all_credits[0]</TD> <TD COLSPAN=3>@all_credits[1]</TD></TR>\n";
 }
 else
 {
 print "<TR><TD><B>Remaining:</B></TD> <TD><INPUT NAME=rimp VALUE=\"@all_credits[0]\" SIZE=4></TD> <TD COLSPAN=3><INPUT NAME=rclick VALUE=\"@all_credits[1]\" SIZE=4></TD></TR>\n";
 }

{
print<<END
</TABLE>

<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Submit">

<BR><BR>
<A HREF="$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password">Menu</A>
</CENTER>

</BODY>
</HTML>
END
}

}

sub reset_stats
{
my ($chose_name) = @_[0];
my $count = 0;

# Reset IMPRESSIONS
splice(@all_imps, 0);
splice(@all_lines, 0);

&lock("$chose_name\.implock");
open(USER, "<$ici_dir\/$chose_name\.imp");

# Get Impression Counts
$line = <USER>;
chop($line);
@all_imps[1] = $line;
$line = <USER>;
chop($line);
@all_imps[2] = $line;
$line = <USER>;
chop($line);
@all_imps[3] = $line;
$line = <USER>;
chop($line);
@all_imps[4] = $line;
$line = <USER>;
chop($line);
@all_imps[5] = $line;

until(eof(USER))
 {
 $line = <USER>;
 chop($line);

 @all_lines[$count] = $line;
 $count++; 
 }

close(USER);
open(USER, ">$ici_dir\/$chose_name\.imp");

for ($x = 1; $x < 6; $x++)
 {
 $tmpname = "banreset$x";
 $tmpname2 = $query->param($tmpname);

 if ($tmpname2 ne "")
  {
  print USER "0\n";
  }
  else
  {
  print USER "@all_imps[$x]\n";
  }
 }

for ($x = 0; $x < @all_lines; $x++)
 {
 print USER "@all_lines[$x]\n";
 }

close(USER);
&unlock("$chose_name\.implock");

# Reset CLICKS
splice(@all_clicks, 0);
splice(@all_lines, 0);
$count = 0;

&lock("$chose_name\.clicklock");
open(USER, "<$ici_dir\/$chose_name\.click");

# Get Click Counts
$line = <USER>;
chop($line);
@all_clicks[1] = $line;
$line = <USER>;
chop($line);
@all_clicks[2] = $line;
$line = <USER>;
chop($line);
@all_clicks[3] = $line;
$line = <USER>;
chop($line);
@all_clicks[4] = $line;
$line = <USER>;
chop($line);
@all_clicks[5] = $line;

until(eof(USER))
 {
 $line = <USER>;
 chop($line);

 @all_lines[$count] = $line;
 $count++; 
 }

close(USER);
open(USER, ">$ici_dir\/$chose_name\.click");

for ($x = 1; $x < 6; $x++)
 {
 $tmpname = "banreset$x";
 $tmpname2 = $query->param($tmpname);

 if ($tmpname2 ne "")
  {
  print USER "0\n";
  }
  else
  {
  print USER "@all_clicks[$x]\n";
  }
 }

for ($x = 0; $x < @all_lines; $x++)
 {
 print USER "@all_lines[$x]\n";
 }

close(USER);
&unlock("$chose_name\.clicklock");

if ($area ne "adminsave")
 {
 print "<HTML><BODY>\n";
 print "All Done.<BR><BR>\n";
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
 print "</BODY></HTML>\n";
 }
}

sub search_now
{
print "<HTML><BODY>\n";
print "<CENTER><H2>Banner Exchanger Search</H2>\n";

splice(@all_users, 0);
opendir(USERSD, "$user_dir");
@all_users = readdir(USERSD);
closedir(USERSD);
splice(@all_users, 0, 2);

$user_count = @all_users;

for ($j = 0; $j < @all_users; $j++)
 {
 if (@all_users[$j] =~ /$searchname/ig)
  {
  print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=adminedit&username=$username&password=$password&searchname=@all_users[$j]\">@all_users[$j]</A><BR>\n";
  }
 }

print "</CENTER><BR>Finished searching.<BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=menu&username=$username&password=$password\">Menu</A>\n";
print "</BODY></HTML>\n";
}

