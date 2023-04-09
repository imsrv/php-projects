#!/usr/local/bin/perl -U
$| = 1;

#Chmod 7755 or 755 before using
#DO NOT MODIFY THIS SCRIPT OR IT MAY NOT WORK

$preconf = 0;

if ("\U$ENV{'REQUEST_METHOD'}\E" ne 'GET' and "\U$ENV{'REQUEST_METHOD'}\E" ne 'POST')
 {
 if (-e "global-vars.lib" and -s "global-vars.lib" > 0)
  {
  $preconf = 1;
  print "Using preconfigured global-vars.lib file...\n\n";
  &get_vars;

  print "What platform is this script running on?\n\n";
  print "[1] Unix\n";
  print "[2] Windows\n\n";
  print "Please make your selection: ";

  $plat = <STDIN>;
  chop($plat);

  if ($plat != 1 and $plat != 2)
   {
   print "\nYou must specify your platform type!\n\n";
   exit;
   }
   else
   {
   $server = $plat - 1;
   }

  &copy_files;
  exit;
  }
  else
  {
  print "You must place this script in your cgi-bin\ndirectory and run it from your browser first\n";
  exit;
  }
 }

&parse_form;
&check_browser;

$server = $FORM{'server'}; # 0 = UNIX / 1 = Windows
$cgidir = $FORM{'cgidir'};
$search = $FORM{'search'};
$archive = $FORM{'archive'};
$unarchive = $FORM{'unarchive'};
$platform = $FORM{'platform'};
$area = $FORM{'area'};

splice(@super_users, 0);

if ($area eq "setup")
 {
 $begin_dir = $FORM{'chat_begindir'};
 $begin_dirhtml = $FORM{'chat_begindirhtml'};
 $cgi_bin_dir = $FORM{'chat_cgibindir'};
 $setupdir = $FORM{'setupdir'};
 $chat_location = $FORM{'chat_locationdir'};
 $gusersdir = $FORM{'chat_gusersdir'};
 $graphicsurl = $FORM{'chat_graphicsurl'};
 $agraphics = $FORM{'chat_agraphics'};
 $sounds_url = $FORM{'chat_sounds'};
 $asounds = $FORM{'chat_asounds'};

 if ($FORM{'telnet'} eq "")
  {
  &copy_files;
  }
  else
  {
  &write_vars;

  print "Content-type: text/html\n\n";
  print "<HTML><BODY>\n";
  print "Your settings have been saved<BR>\n";
  print "You must now login to your web site via telnet and type:<br><BR>";
  print "cd $setupdir<br>\n";
  print "./chatsetup.cgi<br><br>\n";
  print "Be sure you have a copy of <i>chatsetup.cgi</i> in the above directory<br>\n";
  print "Your WebChatter will be installed after that!<br><br>\n";
  print "Thank you for choosing WebChatter by <a href=\"http://www.webpost.net\">The Web Post Network</a>\n";
  print "</BODY></HTML>\n";
  }

 exit;
 }

$version = "7.0";

if ($server == 0)
 {
 $copy_command = "cp -ip"; #For Unix
 }
 else
 {
 $copy_command = "copy"; #For Window
 }

$install_dir = "";
print "Content-type: multipart/mixed;boundary=\"boundary\"\n\n";

if ($browser == 1)
 {
 print "\n--boundary\n";
 print "Content-type: text/html\n\n";
 }

print "<HTML><BODY>\n";

$noerror = 0;

if (not -k "chatsetup.cgi")
 {
 $noerror = 1;
 print "<B>WARNING:</B> (sticky bit not set) You must chmod <i>chatsetup.cgi</i> to 7755<BR>\n";
 }

if (not -u "chatsetup.cgi")
 {
 $noerror = 1;
 print "<B>WARNING:</B> (userid not set) You must chmod <i>chatsetup.cgi</i> to 7755<BR>\n";
 }

if (not -g "chatsetup.cgi")
 {
 $noerror = 1;
 print "<B>WARNING:</B> (groupid not set) You must chmod <i>chatsetup.cgi</i> to 7755<BR>\n";
 }

if ($noerror == 1)
 {
 print "<P><B>Continuing, but setup may fail</B><P>\n";
 }

if ($platform eq "show")
 {
 &platform;
 exit;
 }

if ($platform eq "test")
 {
 &check_realtime;
 print "<P><A HREF=\"$ENV{'SCRIPT_NAME'}\">Back</A>\n";
 exit;
 }

if ($archive eq "")
 {
 &login_screen;
 exit;
 }

$begin_dirhtml = $ENV{'DOCUMENT_ROOT'};

if ($search eq "")
 {
 $idx = rindex($begin_dirhtml, "/");
 $begin_dir = substr($begin_dirhtml, 0, $idx);
 }
 else
 {
 $begin_dir = $search;
 }

if ($cgidir eq "")
 {
 $idx = rindex($ENV{'SCRIPT_FILENAME'}, "/");
 $cgi_bin_dir = substr($ENV{'SCRIPT_FILENAME'}, 0, $idx);
 }
 else
 {
 $cgi_bin_dir = $cgidir;
 }

$tcount = 0;

print "<PRE>";

if ($unarchive eq "YES")
{
print "Searching for a temporary installation directory...\n";

if ($install_dir eq "")
 {
 &traverse($begin_dir);
 }

if ($install_dir eq "")
 {
 print "\n\nCould not find a temporary installation directory!\n";
 print "Try specifying another location.\n";
 exit;
 }

print "\n\nFound: $install_dir\n";

chdir("$install_dir");
$tcount = 0;

print "\nSearching for installation archive ($archive)...\n";

$found_archive = 0;
$look_for = $archive;
&traverse($begin_dir);

if ($found_archive == 0)
 {
 &traverse($begin_dirhtml);
 }

if ($found_archive == 0)
 {
 print "\n\nCould not find installation archive $archive!\n";
 print "Try specifying another archive name or location.\n";
 exit;
 }

print "\n\nFound: $setup_dir\/$look_for\n";
print "\nCopying archive to temporary location...\n";
system("$copy_command $setup_dir\/$look_for $install_dir\/$look_for");

if (substr($look_for, length($look_for) - 2) eq "\Lgz\E")
 {
 print "\nUnzipping archive: $install_dir\/$look_for\n";
 system("gunzip $install_dir\/$look_for");

 $look_for = substr($look_for, 0, length($look_for) - 3);
 }

print "Untarring archive: $install_dir\/$look_for\n\n";
system("tar xfp $install_dir\/$look_for");
unlink("$install_dir\/$look_for");
}

$tcount = 0;
print "Searching for setup programs...\n";
$look_for = "chatadmin.cgi,chat.cgi";

if ($unarchive eq "YES")
 {
 &traverse("$install_dir");
 }
 else
 {
 $found_archive = 1;
 &traverse("$begin_dir");
 }

if ($found_archive != 2)
 {
 print "\n\nCould not find installation files!\n";
 print "Try specifying another location.\n";
 exit;
 }

$setupfiles = $setup_dir;

print "\n\n<B>Location of setup files:</B> $setupfiles\n\n";

print "Searching for appropriate installation directories...\n";

$begin_dirhtml = $ENV{'DOCUMENT_ROOT'};
$idx = rindex($begin_dirhtml, "/");
$abegin_dir = substr($begin_dirhtml, 0, $idx);

if (not -w $abegin_dir)
 {
 $abegin_dir = $begin_dirhtml;
 }

$look_for = "";
$search_num = 10;
$foundcount = 0;
splice(@all_found, 0);

if (-w $abegin_dir)
 {
 $foundcount++;
 $search_num--;
 @all_found[0] = $abegin_dir;
 }

&traverse($abegin_dir);

splice(@all_above, 0);
@all_above = @all_found;
$above_total = $foundcount;

$look_for = "";
$search_num = 10;
$foundcount = 0;
splice(@all_found, 0);
      
if (-w $begin_dirhtml)
 {
 $foundcount++;
 $search_num--;
 @all_found[0] = $begin_dirhtml;
 }

&traverse($begin_dirhtml);

splice(@all_root, 0);
@all_root = @all_found;
$root_total = $foundcount;


#print "When installing, do not select the same directories for both of the above.\n";
#print "If you do not see any directories above, you must create a directory, such as\n";
#print "<I>webchatter</I> under <I>$begin_dirhtml</i> and chmod it to 777.  After you do,\n";
#print "<I>$begin_dirhtml\/webchatter</I> should appear above\n\n";

&setup;

print "</PRE>\n\n";

&print_config;
print "</BODY></HTML>\n";
exit;


sub traverse {

    local($dir) = shift;
    local($path);

    unless (opendir(DIR, $dir)) {
	warn "Can't open $dir\n";
	closedir(DIR);
	return;
    }

    foreach (readdir(DIR)) {
	next if $_ eq '.' || $_ eq '..';
        $path = "$dir/$_";

        if (-d $path) {          # a directory

        if ($tcount > 50)
         {
         $tcount = 0;
         print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
         }

        print ".";
        $tcount++;

        if (-w "$path" and $look_for eq "")
         {
         $install_dir =  "$path";

         if ($search_num eq "" or $search_num == 0)
          {
          return;
          }
          else
          {
          if ($foundcount >= $search_num)
           {
           return;
           }

          @all_found[$foundcount] = $install_dir;

          $foundcount++;
          }
         }


            &traverse($path);
	} elsif (-f _) {	# a plain file

           splice(@filename, 0);
           @filename = split(/\//, $path);
           $size = @filename - 1;

           if (@filename[$size] eq $look_for and $look_for ne "" and $found_archive == 0)
            {
            $found_archive = 1;
            splice(@filename, $size, 1);
            $setup_dir = join ("/", @filename);
            return;
            }

           splice(@look_all, 0);
           @look_all = split(/,/, $look_for);

           if ($found_archive == 1)
            {
            for ($tm = 0; $tm < @look_all; $tm++)
             {
             if (@filename[$size] eq @look_all[$tm])
              {
              $outcount++;
              }
             }

            $la = @look_all;

            if ($outcount == $la)
             {
             splice(@filename, $size, 1);
             $setup_dir = join ("/", @filename);
             $found_archive = 2;
             return;
             }
            }

	    # or do something you want to
	}
    }
    closedir(DIR);
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


sub login_screen
{
print <<END
<HTML><BODY BGCOLOR="#FFFCCC">
<CENTER>
<H2>WebChatter Setup $version</H2>
<P>

<A HREF="$ENV{'SCRIPT_NAME'}\?platform=show">View my platform information</A>
<BR>
<A HREF="$ENV{'SCRIPT_NAME'}\?platform=test">Test realtime mode</A>
<P>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<TABLE BORDER=1 WIDTH=400 CELLPADDING=5>
<TR><TD><B>Platform:</B> <INPUT TYPE=RADIO NAME="server" VALUE="0"> Unix <INPUT TYPE=RADIO NAME="server" VALUE="1"> Windows</TD></TR>

<TR><TD><B>Archive Name:</B> <INPUT NAME=archive></TD></TR>
<TR><TD>This is the exact filename you uploaded to your server.  For example, <i>webchatter.tar</i> (Remember that the filename is case sensitive)</TD></TR>

<TR><TD><B>Unarchive files?</B> <INPUT TYPE=checkbox NAME="unarchive" VALUE="YES"></TD></TR>
<TR><TD>If you already unarchived the files in the above archive onto your server (usually only Windows users should do this), leave this box unchecked</TD></TR>

<TR><TD><B>Search:</B> <INPUT NAME=search></TD></TR>
<TR><TD><CENTER>This field is not required</CENTER><P> This field is used if you want to begin searching your server's hard drive at a different location other than what this script chooses.  For example: <i>/var</i> or <i>/usr/bin</i></TD></TR>

<TR><TD><B>CGI-BIN Directory:</B> <INPUT NAME=cgidir></TD></TR>
<TR><TD><CENTER>This field is not required</CENTER><P> By default, this script will guess your cgi-bin directory.  If it guesses incorrectly, you can specify the absolute path here.  For example: <i>/cgi-bin</i> or <i>/cgi-bin/mycgi</i></TD></TR>

</TABLE>
<P>
<input type=submit value="Next">
</CENTER>
</FORM>
</BODY></HTML>
END
}

sub platform
{
print "<PRE>\n";

print "<b>Platform:</b>\n\n";
print "[$^O]\n";
system("uname -a");

print "\n\n<b>Perl Version:</b>\n\n";
system("perl -v");

print "\n\n<b>Perl Libraries:</b>\n\n";
system("ldd `which perl`");

print "\n\n<B>Server Environment Variables:</B>\n\n";
foreach $var (sort(keys(%ENV)))
 {
 $val = $ENV{$var};
 $val =~ s|\n|\\n|g;
 $val =~ s|"|\\"|g;
 print "${var}=\"${val}\"\n";
 }


print "</PRE>\n";

print "<A HREF=\"$ENV{'SCRIPT_NAME'}\">Back</A>\n";
print "</BODY></HTML>\n";

exit;
}

sub check_browser
{
$browser = 0;  #MSIE / AOL
if ($ENV{'HTTP_USER_AGENT'} =~ /Mozilla/i)
 {
 if ($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i and $ENV{'HTTP_USER_AGENT'} !~ /opera/i)
  {
  $browser = 1; #Netscape
  }
 }
}

sub check_realtime
{
print "<HTML><TITLE>WebChatter</TITLE><BODY>\n";
print "Displaying 20 lines in 1 second intervals<P>\n";

$speed = 1;
if ($speed > 10)
 {
 $speed = 10;
 }

for ($j = 0; $j < 50; $j++)
 {
 print "<!-- FORCE OUTPUT -->\n";
 }

$j = 1;
$ctime = time();

until ($j > 20)
 {
 if ((time() - $ctime) == $speed)
  {
  $etime = time() - $ctime;
  print "Test: $j / Processing time: $etime seconds<br>\n";
  $ctime = time();
  $j++;
  }
 }

print "<P>";
print "If each line above appeared in one second intervals (line by line), then<br>";
print "your server should work in realtime (server push) mode.  Otherwise, WebChatter<br>";
print "must be run in refresh mode";
print "</BODY></HTML>\n";
}

sub print_config
{

{
print<<END
<form method=POST action="$ENV{'SCRIPT_NAME'}">
<input type=hidden name=setupdir value="$setupfiles">
<input type=hidden name=area value="setup">

<table border=0>

<tr>
<td><B>Chat Type:</B></td> <td><input type=radio name="chat_type" value="0" $ct_sel1>Real Time <input type=radio name="chat_type" value="1" $ct_sel2>Refresh</td>
</tr>

<tr>
<td><B>Refresh Seconds:</B></td> <td><input type=text name=chat_refresh value="$ChatRefresh" size=5></td>
</tr>

<tr>
<td><B>Max Reload Lines (Refresh Chat):</B></td> <td><input type=text name=chat_maxlines value="$max_lines" size=5></td>
</tr>

<tr>
<td><B>Max Idle Time:</B></td> <td><input type=text name=chat_maxidle value="$idle" size=5></td>
</tr>

<tr>
<td><B>Warn Time When Idle:</B></td> <td><input type=text name=chat_warn value="$warn_time" size=5></td>
</tr>

<tr>
<td><B>Default Room:</B></td> <td><input type=text name=chat_defaultroom value="$default_room" size=15></td>
</tr>

<tr>
<td><B>Keep Alive:</B></td> <td><input type=radio name="chat_keepalive" value="10" $ckeep_sel1>On <input type=radio name="chat_keepalive" value="0" $ckeep_sel2>Off</td>
</tr>

<tr>
<td><B>Log All Chat:</B></td> <td><input type=radio name="chat_keeplog" value="1" $clog_sel1>Yes <input type=radio name="chat_keeplog" value="0" $clog_sel2>No</td>
</tr>

<tr>
<td><B>Ad Type:</B></td> <td><input type=radio name="chat_adtype" value="1" $cad_sel1>Chat Screen <input type=radio name="chat_adtype" value="0" $cad_sel2>Bottom Right</td>
</tr>

<tr>
<td><B>Allow HTML:</B></td> <td><input type=radio name="chat_allhtml" value="1" $chtml_sel1>Yes <input type=radio name="chat_allhtml" value="0" $chtml_sel2>No</td>
</tr>

<tr>
<td><B>Company Name:</B></td> <td><input name=chat_companyname value="$company_name"</td>
</tr>

<tr>
<td><B>Mail Program:</B></td> <td><input name=chat_mailprog value="$mailprog"></td>
</tr>

<tr>
<td><B>Mail Program:</B></td> <td><input name=chat_mailserver value="$mailserver"></td>
</tr>

<tr>
<td colspan=2>
<BR><BR>
The next two questions will determine where WebChatter will be installed<BR>
on your server.  If this setup did not detect any writable directories,<BR>
you can create them using ftp or telnet and change the permissions (chmod) to 777<BR>
<BR><BR>
</td>
</tr>

<tr>
<td valign=top><B>One Above Absolute Root to HTTPD:</B></td> <td><input name=chat_begindir value="$begin_dir">
<BR>
<B>[Found: $above_total]</B>
<BR>
END
}

print "This path should be set to <i>$begin_dir</i><BR>";

if (not -w "$begin_dir")
 {
 print "However, it is not writable.  You should chmod<BR>\n";
 print "it to 777 and use it or your WebChatter<BR>\n";
 print "user files may be visible to unauthorized users.<BR>\n";
 print "Other choices may be below (any will work).<BR><BR>\n";
 }

for ($j = 0; $j < @all_above; $j++)
 {
 if (length(@all_above[$j]) < length($ENV{'DOCUMENT_ROOT'}))
  {
  print "@all_above[$j] <B>(recommended)</B><BR>\n";
  }
  else
  {
  print "@all_above[$j]<BR>\n";
  }
 }

{
print <<END
</td></tr>
<tr>
<td valign=top><B>Absolute Root to HTTPD:</B></td> <td><input name=chat_begindirhtml value="$begin_dirhtml">
<BR>
<B>[Found: $root_total]</B>
<BR>
END
}

print "This path should be set to <i>$ENV{'DOCUMENT_ROOT'}</i><BR>";

if (not -w "$ENV{'DOCUMENT_ROOT'}")
 {
 print "However, it is not writable.  You should chmod<BR>\n";
 print "it to 777 and use it or your WebChatter<BR>\n";
 print "graphics files may not work properly.<BR>\n";
 print "Other choices maybe below (any will work).<BR><BR>\n";
 }

for ($j = 0; $j < @all_root; $j++)
 {
 if (@all_root[$j] eq $ENV{'DOCUMENT_ROOT'})
  {
  print "@all_root[$j] <B>(recommended)</B><BR>\n";
  }
  else
  {
  print "@all_root[$j]<BR>\n";
  }
 }

{
print<<END
</td></tr>

<tr>
<td><B>Absolute Path to Graphics:</B></td> <td><input name=chat_agraphics value="$agraphics"></td>
</tr>

<tr>
<td><B>Absolute Path to Sounds:</B></td> <td><input name=chat_asounds value="$asounds"></td>
</tr>

<tr>
<td><B>Graphics URL:</B></td> <td><input name=chat_graphicsurl value="$graphics_url"></td>
</tr>

<tr>
<td><B>Chat Sounds URL:</B></td> <td><input name=chat_sounds value="$sounds_url"></td>
</tr>

<tr>
<td><B>Absolute Path to cgi-bin:</B></td> <td><input name=chat_cgibindir value="$cgi_bin_dir"></td>
</tr>

<tr>
<td><B>Main Web Site URL:</B></td> <td><input name=chat_mainurl value="$main_url"></td>
</tr>

<tr>
<td><B>Relative cgi-bin:</B></td> <td><input name=chat_maincgi value="$main_cgi"></td>
</tr>

<tr>
<td><B>Secure Web Site URL:</B></td> <td><input name=chat_smainurl value="$smain_url"></td>
</tr>

<tr>
<td><B>Relative Secure cgi-bin:</B></td> <td><input name=chat_smaincgi value="$smain_cgi"></td>
</tr>

<tr>
<td><B>Super Users:</B></td> <td><input name=chat_superusers value="$superusers"></td>
</tr>

<tr>
<td><B>Background Color:</B></td> <td><input name=chat_backgroundcolor value="$background_color"></td>
</tr>

<tr>
<td><B>Users Location:</B></td> <td><input name=chat_gusersdir value="$gusersdir"></td>
</tr>

<tr>
<td><B>Chat Location:</B></td> <td><input name=chat_locationdir value="$chat_location"></td>
</tr>
</table>

<BR><BR>

<input type=checkbox name=telnet value="yes"> Check this box if you want to run this script from the telnet<br>
command line to copy the chat files, otherwise after you click<br>
"Setup", the script will attempt to copy them via your web browser

<BR><BR>

<input type=submit name=submit value="Setup">
</form>
END
}

}


sub get_config
{
open (CONF, "<$setupfiles\/chat.cfg");
$ChatRefresh = <CONF>;
$max_lines = <CONF>;
$chat_type = <CONF>;  #0 = Realtime / 1 = Refresh
$chat_alive = <CONF>; #0 to turn off
$default_room = <CONF>;
$ad_type = <CONF>;
$allow_html = <CONF>;
$idle = <CONF>;
$warn_time = <CONF>;
$keep_log = <CONF>;
$liveusers = <CONF>;
$liveops = <CONF>;
close(CONF);

chomp($ChatRefresh);
chomp($chat_type);
chomp($default_room);
chomp($ad_type);
chomp($allow_html);
chomp($idle);
chomp($allow_type);
chomp($warn_time);
chomp($max_lines);
chomp($keep_log);
chomp($liveusers);
chomp($liveops);
$max_con = $liveusers; # Number of records to store
$max_operators = $liveops; # Number of operators allowed under one account

$f_color = "#ffffff";
$s_color = "#aacddb";

if ($chat_type == 1)
 {
 $ad_type = 0;
 $ct_sel2 = "CHECKED";
 }
 else
 {
 $ct_sel1 = "CHECKED";
 }

if ($keep_log == 1)
 {
 $clog_sel1 = "CHECKED";
 }
 else
 {
 $clog_sel2 = "CHECKED";
 }

if ($chat_alive != 0)
 {
 $ckeep_sel1 = "CHECKED";
 }
 else
 {
 $ckeep_sel2 = "CHECKED";
 }

if ($ad_type == 1)
 {
 $cad_sel1 = "CHECKED";
 }
 else
 {
 $cad_sel2 = "CHECKED";
 }

if ($allow_html == 1)
 {
 $chtml_sel1 = "CHECKED";
 }
 else
 {
 $chtml_sel2 = "CHECKED";
 }
}

sub setup
{
$begin_dirhtml = $ENV{'DOCUMENT_ROOT'};

$idx = rindex($begin_dirhtml, "/");
$begin_dir = substr($begin_dirhtml, 0, $idx);

$main_url = "http://$ENV{'HTTP_HOST'}";
$smain_url = $main_url;

$idx = rindex($ENV{'SCRIPT_FILENAME'}, "/");
$cgi_bin_dir = substr($ENV{'SCRIPT_FILENAME'}, 0, $idx);

$idx = rindex($ENV{'SCRIPT_NAME'}, "/");
$main_cgi = substr($ENV{'SCRIPT_NAME'}, 1, $idx - 1);
$smain_cgi = $main_cgi;

$sounds_url = "$main_url\/sounds";
$asounds = "$begin_dirhtml\/sounds";
$graphics_url = "$main_url\/webchatter_graphics";
$agraphics = "$begin_dirhtml\/webchatter_graphics";

$chat_location = "chat";
$gusersdir = "gusers";
$background_color = "#FFFCCC";
$mailprog = "/usr/lib/sendmail";
$mailserver = "localhost";
$ChatRefresh = 10;
$max_lines = 50;
$chat_type = 0;
$chat_alive = 1;
$default_room = "main";
$ad_type = 0;
$allow_html = 0;
$idle = 1800;
$warn_time = 1500;
$superusers = "admin";

if ($chat_type == 1)
 {
 $ad_type = 0;
 $ct_sel2 = "CHECKED";
 }
 else
 {
 $ct_sel1 = "CHECKED";
 }

if ($keep_log == 1)
 {
 $clog_sel1 = "CHECKED";
 }
 else
 {
 $clog_sel2 = "CHECKED";
 }

if ($chat_alive != 0)
 {
 $ckeep_sel1 = "CHECKED";
 }
 else
 {
 $ckeep_sel2 = "CHECKED";
 }

if ($ad_type == 1)
 {
 $cad_sel1 = "CHECKED";
 }
 else
 {
 $cad_sel2 = "CHECKED";
 }

if ($allow_html == 1)
 {
 $chtml_sel1 = "CHECKED";
 }
 else
 {
 $chtml_sel2 = "CHECKED";
 }
}

sub copy_files
{
print "\nRemoving old files...";

unlink("$cgi_bin_dir/chat.cgi");
unlink("$cgi_bin_dir/chat_upload.cgi");
unlink("$cgi_bin_dir/global-vars.lib");
unlink("$cgi_bin_dir/global-lib.cgi");
unlink("$cgi_bin_dir/chat-lib.cgi");
unlink("$cgi_bin_dir/chatadmin.cgi");
unlink("$cgi_bin_dir/chatgames.cgi");
unlink("$cgi_bin_dir/chatlive.cgi");

if (-e "$cgi_bin_dir/chat.cgi")
 {
 print "FAILED\n";
 }
 else
 {
 print "OK\n";
 }

if ($preconf == 0)
 {
 chdir("$setupdir");
 }

print "Copying required chat files...";

if ($server == 0)
 {
 link("chat.cgi", "$cgi_bin_dir/chat.cgi");
 link("chat_upload.cgi", "$cgi_bin_dir/chat_upload.cgi");
 link("global-vars.lib", "$cgi_bin_dir/global-vars.lib");
 link("global-lib.cgi", "$cgi_bin_dir/global-lib.cgi");
 link("chat-lib.cgi", "$cgi_bin_dir/chat-lib.cgi");
 link("chatadmin.cgi", "$cgi_bin_dir/chatadmin.cgi");
 link("chatgames.cgi", "$cgi_bin_dir/chatgames.cgi");
 link("chatlive.cgi", "$cgi_bin_dir/chatlive.cgi");
 }
 else
 {
 rename("chat.cgi", "$cgi_bin_dir/chat.cgi");
 rename("chat_upload.cgi", "$cgi_bin_dir/chat_upload.cgi");
 rename("global-vars.lib", "$cgi_bin_dir/global-vars.lib");
 rename("global-lib.cgi", "$cgi_bin_dir/global-lib.cgi");
 rename("chat-lib.cgi", "$cgi_bin_dir/chat-lib.cgi");
 rename("chatadmin.cgi", "$cgi_bin_dir/chatadmin.cgi");
 rename("chatgames.cgi", "$cgi_bin_dir/chatgames.cgi");
 rename("chatlive.cgi", "$cgi_bin_dir/chatlive.cgi");
 }

chmod(0755, "$cgi_bin_dir/chat.cgi");
chmod(0755, "$cgi_bin_dir/chat_upload.cgi");
chmod(0777, "$cgi_bin_dir/global-vars.lib");
chmod(0755, "$cgi_bin_dir/global-lib.cgi");
chmod(0755, "$cgi_bin_dir/chat-lib.cgi");
chmod(0755, "$cgi_bin_dir/chatadmin.cgi");
chmod(0755, "$cgi_bin_dir/chatgames.cgi");
chmod(0755, "$cgi_bin_dir/chatlive.cgi");

$efile = "$cgi_bin_dir/chat.cgi";
&check_exist;

if ($estat == 1)
 {
 print "\n";
 print "You must manually copy the following:\n\n";
 print "chat.cgi, chat_upload.cgi, chatadmin.cgi, chatgames.cgi, chatlive.cgi, global-lib.cgi, chat-lib.cgi, and global-vars.lib\n";
 print "from $setupdir to $cgi_bin_dir or chmod $cgi_bin_dir to 777";
 print "\n\n";
 }

print "Creating sounds directory...";

mkdir("$asounds", 0777);
chmod(0777, "$asounds");

$efile = "$asounds";
&check_exist;

print "Copying sound files...";

splice(@all_sounds, 0);
opendir (GR, "sounds");
@all_sounds = readdir(GR);
closedir (GR);

for ($j = 2; $j < @all_sounds; $j++)
 {
 if (@all_sounds[$j] ne "")
  {
  rename("sounds\/@all_sounds[$j]","$asounds\/@all_sounds[$j]");
  chmod(0777, "$asounds\/@all_sounds[$j]");
  }
 }

$efile = "$asounds\/@all_sounds[2]";
&check_exist;

print "Creating graphics directory...";

mkdir("$agraphics", 0777);
chmod(0777, "$agraphics");
mkdir("$agraphics\/avatars", 0777);
chmod(0777, "$agraphics\/avatars");

$efile = "$agraphics\/avatars";
&check_exist;

print "Creating required directories...";

mkdir("$begin_dir/locks", 0777);
mkdir("$begin_dir/$gusersdir", 0777);
mkdir("$begin_dir/profiles", 0777);
mkdir("$begin_dir/$chat_location", 0777);
mkdir("$begin_dir/$chat_location/sessions", 0777);
mkdir("$begin_dir/$chat_location/rooms", 0777);
mkdir("$begin_dir/$chat_location/online", 0777);
mkdir("$begin_dir/$chat_location/messages", 0777);
mkdir("$begin_dir/$chat_location/invite", 0777);
mkdir("$begin_dir/$chat_location/ban", 0777);
mkdir("$begin_dir/$chat_location/owner", 0777);
mkdir("$begin_dir/$chat_location/files", 0777);
mkdir("$begin_dir/$chat_location/ignore", 0777);
mkdir("$begin_dir/$chat_location/buddy", 0777);
mkdir("$begin_dir/$chat_location/buddytrack", 0777);
mkdir("$begin_dir/$chat_location/private", 0777);
mkdir("$begin_dir/$chat_location/status", 0777);
mkdir("$begin_dir/$chat_location/spy", 0777);
mkdir("$begin_dir/$chat_location/topics", 0777);
mkdir("$begin_dir/$chat_location/max", 0777);
mkdir("$begin_dir/$chat_location/reload", 0777);

mkdir("$begin_dir/$chat_location/logs", 0777);
mkdir("$begin_dir/$chat_location/games", 0777);
mkdir("$begin_dir/$chat_location/live", 0777);
mkdir("$begin_dir/$chat_location/live/users", 0777);
mkdir("$begin_dir/$chat_location/live/stats", 0777);
mkdir("$begin_dir/$chat_location/live/rooms", 0777);

chmod(0777, "$begin_dir/$chat_location");
chmod(0777, "$begin_dir/$chat_location/logs");
chmod(0777, "$begin_dir/$chat_location/sessions");
chmod(0777, "$begin_dir/$chat_location/rooms");
chmod(0777, "$begin_dir/$chat_location/online");
chmod(0777, "$begin_dir/$chat_location/messages");
chmod(0777, "$begin_dir/$chat_location/invite");
chmod(0777, "$begin_dir/$chat_location/ban");
chmod(0777, "$begin_dir/$chat_location/owner");
chmod(0777, "$begin_dir/$chat_location/files");
chmod(0777, "$begin_dir/$chat_location/ignore");
chmod(0777, "$begin_dir/$chat_location/buddy");
chmod(0777, "$begin_dir/$chat_location/buddytrack");
chmod(0777, "$begin_dir/$chat_location/private");
chmod(0777, "$begin_dir/$chat_location/status");
chmod(0777, "$begin_dir/$chat_location/spy");
chmod(0777, "$begin_dir/$chat_location/topics");
chmod(0777, "$begin_dir/$chat_location/max");
chmod(0777, "$begin_dir/$chat_location/reload");

chmod(0777, "$begin_dir/$chat_location/games");
chmod(0777, "$begin_dir/$chat_location/live");
chmod(0777, "$begin_dir/$chat_location/live/users");
chmod(0777, "$begin_dir/$chat_location/live/stats");
chmod(0777, "$begin_dir/$chat_location/live/rooms");

chmod(0777, "$begin_dir/locks");
chmod(0777, "$begin_dir/$gusersdir");
chmod(0777, "$begin_dir/profiles");

$efile = "$begin_dir/locks";
&check_exist;

print "Copying game files...";

splice(@all_games, 0);
opendir (GAMES, "games");
@all_games = readdir(GAMES);
closedir (GAMES);

for ($j = 2; $j < @all_games; $j++)
 {
 if (@all_games[$j] ne "")
  {
  if ($server == 0)
   {
   link("games\/@all_games[$j]","$begin_dir/$chat_location/games/@all_games[$j]");
   }
   else
   {
   rename("games\/@all_games[$j]","$begin_dir/$chat_location/games/@all_games[$j]");
   }
  }
 }

$efile = "$begin_dir/$chat_location/games/@all_games[2]";
&check_exist;

print "Copying game graphics files...";

splice(@all_games, 0);
opendir (GAMES, "gamepieces");
@all_games = readdir(GAMES);
closedir (GAMES);

for ($j = 2; $j < @all_games; $j++)
 {
 if (@all_games[$j] ne "")
  {
  if ($server == 0)
   {
   link("gamepieces\/@all_games[$j]","$agraphics\/@all_games[$j]");
   }
   else
   {
   rename("gamepieces\/@all_games[$j]","$agraphics\/@all_games[$j]");
   }
  }
 }

$efile = "$agraphics\/@all_games[2]";
&check_exist;

print "Copying graphics files...";

splice(@all_graphics, 0);
opendir (GR, "graphics");
@all_graphics = readdir(GR);
closedir (GR);

for ($j = 2; $j < @all_graphics; $j++)
 {
 if (@all_graphics[$j] ne "")
  {
  if ($server == 0)
   {
   link("graphics\/@all_graphics[$j]","$agraphics\/@all_graphics[$j]");
   }
   else
   {
   rename("graphics\/@all_graphics[$j]","$agraphics\/@all_graphics[$j]");
   }
  }
 }

splice(@all_avs, 0);
opendir (GR, "avatars");
@all_avs = readdir(GR);
closedir (GR);

for ($j = 2; $j < @all_avs; $j++)
 {
 if (@all_avs[$j] ne "")
  {
  if ($server == 0)
   {
   link("avatars\/@all_avs[$j]","$agraphics\/avatars\/@all_avs[$j]");
   }
   else
   {
   rename("avatars\/@all_avs[$j]","$agraphics\/avatars\/@all_avs[$j]");
   }
  }
 }

splice(@all_skin, 0);
opendir (SKIN, "skin");
@all_skin = readdir(SKIN);
closedir (SKIN);

for ($j = 2; $j < @all_skin; $j++)
 {
 if (@all_skin[$j] ne "")
  {
  rename("skin\/@all_skin[$j]","$agraphics\/@all_skin[$j]");
  }
 }

$efile = "$agraphics\/@all_skin[2]";
&check_exist;

print "Copying configuration files...";

if ($server == 0)
 {
 link("notice.txt", "$begin_dir/$chat_location/notice.txt");
 link("actions.txt", "$begin_dir/$chat_location/actions.txt");
 link("main.scr", "$begin_dir/$chat_location/main.scr");
 link("help.scr", "$begin_dir/$chat_location/help.scr");
 link("commands.scr", "$begin_dir/$chat_location/commands.scr");
 link("news.scr", "$begin_dir/$chat_location/news.scr");
 link("badwords.txt", "$begin_dir/$chat_location/badwords.txt");
 link("chat.cfg", "$begin_dir/$chat_location/chat.cfg");
 link("commands.txt", "$begin_dir/$chat_location/commands.txt");
 link("text.txt", "$begin_dir/$chat_location/text.txt");
 link("colors.txt", "$begin_dir/$chat_location/colors.txt");
 link("countries.txt", "$begin_dir/$chat_location/countries.txt");
 link("states.txt", "$begin_dir/$chat_location/states.txt");
 }
 else
 {
 rename("notice.txt", "$begin_dir/$chat_location/notice.txt");
 rename("actions.txt", "$begin_dir/$chat_location/actions.txt");
 rename("main.scr", "$begin_dir/$chat_location/main.scr");
 rename("help.scr", "$begin_dir/$chat_location/help.scr");
 rename("commands.scr", "$begin_dir/$chat_location/commands.scr");
 rename("news.scr", "$begin_dir/$chat_location/news.scr");
 rename("badwords.txt", "$begin_dir/$chat_location/badwords.txt");
 rename("chat.cfg", "$begin_dir/$chat_location/chat.cfg");
 rename("commands.txt", "$begin_dir/$chat_location/commands.txt");
 rename("text.txt", "$begin_dir/$chat_location/text.txt");
 rename("colors.txt", "$begin_dir/$chat_location/colors.txt");
 rename("countries.txt", "$begin_dir/$chat_location/countries.txt");
 rename("states.txt", "$begin_dir/$chat_location/states.txt");
 }

chmod(0777, "$begin_dir/$chat_location/commands.scr");
chmod(0777, "$begin_dir/$chat_location/news.scr");
chmod(0777, "$begin_dir/$chat_location/help.scr");
chmod(0777, "$begin_dir/$chat_location/main.scr");
chmod(0777, "$begin_dir/$chat_location/notice.txt");
chmod(0777, "$begin_dir/$chat_location/actions.txt");
chmod(0777, "$begin_dir/$chat_location/badwords.txt");
chmod(0777, "$begin_dir/$chat_location/commands.txt");
chmod(0777, "$begin_dir/$chat_location/text.txt");
chmod(0777, "$begin_dir/$chat_location/colors.txt");
chmod(0777, "$begin_dir/$chat_location/chat.cfg");
chmod(0777, "$begin_dir/$chat_location/countries.txt");
chmod(0777, "$begin_dir/$chat_location/states.txt");

$efile = "$begin_dir/$chat_location/notice.txt";
&check_exist;

if ($preconf == 0)
 {
 @super_users = split(/,/, $FORM{'chat_superusers'});

 if (@super_users == 0)
  {
  $gname = $FORM{'chat_superusers'};
  }
  else
  {
  $gname = @super_users[0];
  }

 &create_acct;
 &write_vars;
 }
 else
 {
 $gname = @super_users[0];
 &create_acct;
 }

if ($efailed > 0)
 {
 print "\nSome required files did not copy correctly.\n";
 print "You should run chatsetup.cgi from the telnet\n";
 print "command line, or chmod the directories you chose\n";
 print "to 777 and rerun this setup.\n\n";

 print "To run chatsetup.cgi from telnet, login to your web site via telnet and type:\n\n";
 print "cd $setupdir\n";
 print "./chatsetup.cgi\n\n";
 print "Be sure you have a copy of chatsetup.cgi in the above directory\n";
 print "Your WebChatter will be installed after that!\n";
 }

print "\nAll Done!\n\n";
print "Thank you for choosing WebChatter by the CGI Connection (http://www.CGIConnection.com)\n";

exit;
}

sub create_acct
{                                 
$fillin = "WebChatter By CGIConnection.com";
$password = $gname;

open (FILE, ">$begin_dir/$gusersdir/\.$gname");
print FILE "$gname\n";
print FILE "$password\n";
print FILE "$fillin\n";
print FILE "$fillin\n";
print FILE "your\@emailaddress.com\n";
print FILE "$FORM{'chat_mainurl'}\n";
print FILE "$FORM{'chat_backgroundcolor'}\n";
print FILE "$fillin\n";
print FILE "BLACK\n";
print FILE "BLUE\n";
print FILE "PURPLE\n";
print FILE "$fillin\n";
close (FILE);

chmod(0777, "$begin_dir/$gusersdir/\.$gname");
}

sub get_vars
{
open (GETVARS, "<global-vars.lib");

# Define Main Variables

$gv = <GETVARS>;
chop($gv);
$company_name = $gv;

# Mail Program
$gv = <GETVARS>;
chop($gv);
$mailprog = $gv;

# Absolute Root Path of Server above HTTPD Server Path
$gv = <GETVARS>;
chop($gv);
$begin_dir = $gv;

# Absolute Root Path of HTTPD Server Path
$gv = <GETVARS>;
chop($gv);
$begin_dirhtml = $gv;

# Absolute Path to cgi-bin directory
$gv = <GETVARS>;
chop($gv);
$cgi_bin_dir = $gv;

# Absolute Main Web Site URL
$gv = <GETVARS>;
chop($gv);
$main_url = $gv;

# Absolute Path to Graphics
$gv = <GETVARS>;
chop($gv);
$agraphics = $gv;

# Absolute Path to Sounds
$gv = <GETVARS>;
chop($gv);
$asounds = $gv;

# URL to Graphics
$gv = <GETVARS>;
chop($gv);
$graphics_url = $gv;

#Relative cgi-bin directory
$gv = <GETVARS>;
chop($gv);
$main_cgi = $gv;

# Secure Web Site URL
$gv = <GETVARS>;
chop($gv);
$smain_url = $gv;

$gv = <GETVARS>;
chop($gv);
$smain_cgi = $gv;

$gv = <GETVARS>;
chop($gv);
$sounds_url = $gv;

$gv = <GETVARS>;
chop($gv);
@super_users = split(/,/, $gv);

$gv = <GETVARS>;
chop($gv);
$background_color = $gv;

$gv = <GETVARS>;
chop($gv);
$chat_location = $gv;

$gv = <GETVARS>;
chop($gv);
$gusersdir = $gv;

close(GETVARS);
}

sub check_exist
{
$estat = 0;
if (-e "$efile")
 {
 print "OK\n";
 }
 else
 {
 $estat = 1;
 $efailed++;
 print "FAILED\n";
 }
}

sub write_vars
{
open (FILE, ">$setupdir\/global-vars.lib");
print FILE "$FORM{'chat_companyname'}\n";
print FILE "$FORM{'chat_mailprog'}\n";
print FILE "$FORM{'chat_mailserver'}\n";
print FILE "$FORM{'chat_begindir'}\n";
print FILE "$FORM{'chat_begindirhtml'}\n";
print FILE "$FORM{'chat_cgibindir'}\n";
print FILE "$FORM{'chat_mainurl'}\n";
print FILE "$FORM{'chat_agraphics'}\n";
print FILE "$FORM{'chat_asounds'}\n";
print FILE "$FORM{'chat_graphicsurl'}\n";
print FILE "$FORM{'chat_maincgi'}\n";
print FILE "$FORM{'chat_smainurl'}\n";
print FILE "$FORM{'chat_smaincgi'}\n";
print FILE "$FORM{'chat_sounds'}\n";
print FILE "$FORM{'chat_superusers'}\n";
print FILE "$FORM{'chat_backgroundcolor'}\n";
print FILE "$FORM{'chat_locationdir'}\n";
print FILE "$FORM{'chat_gusersdir'}\n";
close(FILE);
}

