#!/usr/bin/perl
# Multimedia Streamer
# Provided By CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Location to save your news file
$save_dir = "!SAVEDIR!";

# Username to login to the administration section
$username = "!USERNAME!";

# Password to login to the administration section
$password = "!PASSWORD!";



################################################
# DO NOT EDIT BELOW THIS LINE
################################################
srand();
&parse_form;

$area = $FORM{'area'};
$filename = $FORM{'filename'};
$width = $FORM{'width'};
$height = $FORM{'height'};
$title = $FORM{'title'};
$bordercolor = $FORM{'bordercolor'};
$backgroundcolor = $FORM{'backgroundcolor'};
$code = $FORM{'code'};
$max = $FORM{'max'};
$font = "Arial";

$width = 250 if $width eq "";
$height = 100 if $height eq "";
$bordercolor = "#000000" if $bordercolor eq "";
$backgroundcolor = "#CCCCCC" if $backgroundcolor eq "";

splice(@descripts, 0);
splice(@urls, 0);
splice(@codes, 0);

if ($code ne "")
 {
 ($chosen_url, $chosen_code) = &read_file;

 $idx = rindex($chosen_url, ".");
 $ext = substr($chosen_url, $idx + 1);
 $temp_rand = int(rand(100000));
 $temp_name = "$chosen_code\-$temp_rand\-$$";

 if ("\L$ext\E" eq "mp3" or "\L$ext\E" eq "m3u")
  {
  print "Content-type: audio/m3u\n";
  print "Content-disposition: inline;filename=StreamMP3\-$temp_name\.m3u\n\n";
  print "$chosen_url\n";
  }
  elsif ("\L$ext\E" eq "mpg" or "\L$ext\E" eq "mpeg" or "\L$ext\E" eq "mp2")
  {
  print "Content-type: video/mpeg\n";
  print "Location: $chosen_url\n\n";
  }
  elsif ("\L$ext\E" eq "avi")
  {
  print "Content-type: video/avi\n";
  print "Location: $chosen_url\n\n";
  }
  elsif ("\L$ext\E" eq "mov" or "\L$ext\E" eq "qt")
  {
  print "Content-type: video/quicktime\n";
  print "Location: $chosen_url\n\n";
  }
  elsif("\L$ext\E" eq "ra" or "\L$ext\E" eq "ram" or "\L$ext\E" eq "rm" or "\L$ext\E" eq "rv")
  {
  print "Content-type: audio/x-pn-realaudio\n";
  print "Content-disposition: inline;filename=StreamRA\-$temp_name\.ram\n\n";
  print "$chosen_url\n";
  }
  elsif ("\L$ext\E" eq "wmv")
  {
  print "Content-type: video/x-ms-wmv\n";
  print "Content-disposition: inline;filename=StreamWMV\-$temp_name\.wmv\n\n";
  print "$chosen_url\n";
  }
  elsif ("\L$ext\E" eq "asf")
  {
  print "Content-type: video/x-ms-asf\n";
  print "Content-disposition: inline;filename=StreamASF\-$temp_name\.asf\n\n";
  print "$chosen_url\n";
  }
  else
  {
  print "Content-type: application/octet-stream\n";
  print "Content-disposition: inline;filename=StreamOTHER\-$temp_name\.$ext\n";
  print "Location: $chosen_url\n\n";
  }

 exit;
 }

print "Content-type: text/html\n\n";

if ($area eq "login")
 {
 &login_screen;
 exit;
 }

if ($area eq "login2")
 {
 &check_login;
 &get_files;
 exit;
 }

if ($area eq "login3")
 {
 &check_login;
 &display_file; 
 exit;
 }

if ($area eq "save")
 {
 &check_login;

 if ($FORM{'delfile'} ne "")
  {
  unlink("$save_dir\/files\/$filename");
  print "$filename has been deleted.<BR><BR>\n";
  print "<HTML><BODY><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Show all files</A></BODY></HTML>\n";
  exit;
  }

 &save_file; 
 exit;
 }

&showscript;

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

sub check_login
{
if ($username ne $FORM{'username'})
 {
 print "<HTML><BODY>Invalid Username.</BODY></HTML>\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "<HTML><BODY>Invalid Password.</BODY></HTML>\n";
 exit;
 }
}

sub login_screen
{

{
print<<END
<HTML>
<TITLE>Multimedia Streamer</TITLE>
<BODY>
<CENTER>
<FONT FACE="$font">
<H2>Multimedia Stream</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE></FONT>
</CENTER>
</BODY></HTML>
END
}

}

sub get_files
{
opendir(FILES, "$save_dir\/files");
@all_files = readdir(FILES);
closedir(FILES);

@all_files = sort(@all_files);

if (@all_files < 3)
 {
 &display_file;
 exit;
 }

print "<HTML><TITLE>Multimedia Streamer</TITLE><BODY><FONT FACE=\"$font\">";
print "<CENTER><H2>Choose file to edit</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}\">Create new file</A><BR><BR>\n";

for ($j = 2; $j < @all_files; $j++)
 {
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}&filename=@all_files[$j]\">@all_files[$j]</A><BR>\n";
 }

print "</CENTER></FONT></BODY></HTML>\n";
}

sub read_file
{
my $line_count = 0;
open(FILES, "<$save_dir\/files\/$filename");

$title = <FILES>;
chop($title);

until(eof(FILES))
 {
 $line = <FILES>;
 chop($line);

 splice(@lines, 0);
 @lines = split(/\|/, $line);

 if ($line ne "")
  {
  @urls[$line_count] = @lines[0];
  @descripts[$line_count] = @lines[1];
  @codes[$line_count] = @lines[2];
  $line_count++;

  if ($code eq @lines[2])
   {
   $chosen_url = @lines[0];
   $chosen_code = @lines[2];
   }
  }
 }

close(FILES);
return($chosen_url, $chosen_code);
}

sub display_file
{
&read_file;

$max_val = @descripts + 5;

print "<HTML><TITLE>Multimedia Streamer</TITLE><BODY>\n";
print "<FONT FACE=\"$font\"><CENTER><H2>Multimedia Streamer</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Show all files</A><BR><BR>\n";

print "<TABLE BORDER=0 WIDTH=600>\n";
print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"save\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$FORM{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$FORM{'password'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=max VALUE=\"$max_val\">\n";

print "<TR><TD COLSPAN=2>You can copy and distribute the link that says <I>Get URL</I> so anyone that clicks on it can automatically stream that file.<BR></TD></TR>\n";
print "<TR><TD VALIGN=TOP><B>Title:</B></TD> <TD VALIGN=TOP><INPUT NAME=title VALUE=\"$title\" SIZE=50></TD></TR>\n";
print "<TR><TD VALIGN=TOP COLSPAN=2><BR><HR><BR></TD></TR>\n";

for ($j = 0; $j < $max_val; $j++)
 {
 $temp_num = $j + 1;
 $temp_desc = @descripts[$j];
 $temp_url = @urls[$j];
 $temp_code = @codes[$j];

 if ($temp_url eq "")
  {
  $temp_url = "http://";
  }

 $extra_line = "";
 $extra_line = "<A HREF=\"$ENV{'SCRIPT_NAME'}?filename=$filename&code=$temp_code\">Get URL</A>" if $temp_code ne "";
 print "<TR><TD VALIGN=TOP><B>$temp_num\.</B></TD> <TD VALIGN=TOP><INPUT TYPE=CHECKBOX NAME=del$j VALUE=\"Y\"> <B>Check to delete</B></TD></TR>";
 print "<TR><TD VALIGN=TOP><B>URL:</B></TD> <TD VALIGN=TOP><INPUT NAME=url$j VALUE=\"$temp_url\" SIZE=50></TD></TR>\n";
 print "<TR><TD VALIGN=TOP><B>Description:</B></TD> <TD VALIGN=TOP><INPUT NAME=desc$j VALUE=\"$temp_desc\" SIZE=50></TD></TR>\n";
 print "<TR><INPUT TYPE=hidden NAME=code$j VALUE=\"$temp_code\"><TD VALIGN=TOP COLSPAN=2>$extra_line<BR><HR><BR></TD></TR>\n";
 }

print "<TR><TD COLSPAN=2><B>Filename:</B> <INPUT NAME=filename VALUE=\"$filename\"></TD></TR>\n";
print "<TR><TD COLSPAN=2><B>Delete $filename?</B> <INPUT TYPE=CHECKBOX NAME=delfile VALUE=\"Y\"></TD></TR>\n";
print "<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE=\"Update\"></TD></TR>\n";
print "</FORM></TABLE></FONT></CENTER></BODY></HTML>\n";
}

sub save_file
{
if (not -e "$save_dir\/files")
 {
 $backok = mkdir("$save_dir\/files", 0777);

 if ($backok == 0)
  {
  print "<SCRIPT>alert('$save_dir\/files could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if ($filename eq "")
 {
 print "<HTML><BODY>You must specify a filename.</BODY></HTML>\n";
 exit;
 }

if (not -w "$save_dir\/files")
 {
 print "<HTML><BODY>Cannot write to $save_dir\/files\/$filename</BODY></HTML>\n";
 exit;
 }

open(FILE, ">$save_dir\/files\/$filename");

print FILE "$title\n";

for ($j = 0; $j < $max; $j++)
 {
 $temp_desc1 = "desc$j";
 $temp_desc = $FORM{$temp_desc1};

 $temp_code1 = "code$j";
 $temp_code = $FORM{$temp_code1};

 $temp_url1 = "url$j";
 $temp_url = $FORM{$temp_url1};

 $temp_del1 = "del$j";
 $temp_del = $FORM{$temp_del1};

 $temp_desc =~ s/\n//gi;
 $temp_desc =~ s/\cM//gi;

 if ($temp_desc ne "" and $temp_del eq "")
  {
  $temp_code = int(rand(10000000)) if $temp_code eq "";
  print FILE "$temp_url\|$temp_desc\|$temp_code\n";
  }
 }

close(FILE);

print "<FONT FACE=\"$font\">Saved <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}&filename=$filename\">$filename</A><BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Show all files</A><BR></FONT>\n";
}

sub showscript
{
print "document.write('<FONT FACE=\"$font\"><TABLE BORDER=1 WIDTH=$width HEIGHT=$height BGCOLOR=$backgroundcolor BORDERCOLOR=$bordercolor CELLSPACING=0 CELLPADDING=0>');";

open(FILE, "<$save_dir\/files\/$filename");

$title = <FILE>;
chop($title);

$title =~ s/\'/\\\'/g;
print "document.write('<TR ALIGN=CENTER VALIGN=TOP><TD BGCOLOR=$background><B>$title</B></TD></TR>');\n";

until(eof(FILE))
 {
 $line = <FILE>;
 chop($line);

 if ($line ne "")
  {
  ($url, $desc, $code) = split(/\|/, $line);

  $url = &encode_url($url);
  $desc =~ s/\n/<BR>/g;
  $desc =~ s/\cM/<BR>/g;
  $desc =~ s/\'/\\\'/g;

  print "document.write('<TR><TD BGCOLOR=$background><A HREF=\"$ENV{'SCRIPT_NAME'}?filename=$filename&code=$code\">$desc</A></TD></TR>');\n";
  }
 }

close(FILE);
print "document.write('</TABLE></FONT>');\n";
}

sub encode_url 
{
my $theURL = @_[0];
$theURL =~ s/([\W])/"%" . uc(sprintf("%2.2x",ord($1)))/eg;
return ($theURL);
}
