#!/usr/bin/perl
# Random Image Rotator 2.0
# Provided by CGI Connection
# http://www.CGIConnection.com

$| = 1;

# Location where to read data files
# Eg. /path/to/your/data/files/
$rand_loc = "!SAVEDIR!/";

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

#############################################
#DO NOT EDIT BELOW THIS LINE
#############################################

srand();

&parse_form;

$area = $FORM{'area'};
$image_tag = $FORM{'imagetag'};
$rotate_time = $FORM{'rotatetime'};
$filename = $FORM{'filename'};
$max = $FORM{'max'};

splice(@images, 0);
splice(@urls, 0);

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
 &save_file; 
 exit;
 }

if ($image_tag eq "")
 {
 $image_num = int(rand(100000));
 $image_tag = "image$image_num";
 }

if ($rotate_time eq "")
 {
 $rotate_time = 5;
 }

$timenown = "timenow$image_tag";
$counttimern = "counttimer$image_tag";
$timesetn = "timeset$image_tag";
$nimagen = "nimage$image_tag";
$imagesn = "images$image_tag";
$urlsn = "urls$image_tag";
$checktimen = "check_time$image_tag";
$beginimagen = "begin_image$image_tag";
$gourln = "go_url$image_tag";

if (not -e "$rand_loc$filename" or $filename eq "")
 {
 print "alert('$filename does not exist'); history.back(-1);";
 exit;
 }

&read_file;

for ($x = 0; $x < @images; $x++)
 {
 if ($x == 0)
  {
  $all_images .= "'@images[$x]'";
  $all_urls .= "'@urls[$x]'";
  }
  else
  {
  $all_images .= ",'@images[$x]'";
  $all_urls .= ",'@urls[$x]'";
  }
 }

&script;

exit;

sub script
{
print<<END
var $timenown = 0;
var $counttimern = 0;
var $timesetn = $rotate_time;
var $nimagen = new Image;
var $imagesn = new Array($all_images);
var $urlsn = new Array($all_urls);

document.write('<A HREF="javascript:onClick=$gourln\(\);">');
document.write('<IMG NAME="$image_tag" SRC=' + $imagesn\[$counttimern\] + ' BORDER=0>');
document.write('</A>');

function $gourln\(\) {

if ($urlsn\[$counttimern\] != "")
 {
 location.href = $urlsn\[$counttimern\];
 }

}

function $beginimagen\(\) {

if ($counttimern >= ($imagesn.length - 1))
 {
 $counttimern = 0;
 }
 else
 {
 $counttimern++;
 }

$nimagen.src = $imagesn\[$counttimern\];
document.$image_tag.src = $nimagen.src;
}

function $checktimen\(\) {

$timenown++;

if ($timenown > $timesetn)
 {
 $timenown = 0;
 $beginimagen\(\);
 }

setTimeout('$checktimen\(\);', 1000);
}

$checktimen\(\);
END
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
<TITLE>Random Image Rotator 2.0</TITLE>
<BODY>
<CENTER>
<H2>Random Image Rotator 2.0</H2>

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

sub get_files
{
opendir(FILES, "$rand_loc");
@all_files = readdir(FILES);
closedir(FILES);

@all_files = sort(@all_files);

if (@all_files < 3)
 {
 &display_file;
 exit;
 }

print "<HTML><TITLE>Random Image Rotator 2.0</TITLE><BODY>";
print "<CENTER><H2>Choose file to edit</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}\">Create new image file</A><BR><BR>\n";

for ($j = 2; $j < @all_files; $j++)
 {
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}&filename=@all_files[$j]\">@all_files[$j]</A><BR>\n";
 }

print "</CENTER></BODY></HTML>\n";
}

sub read_file
{
my $line_count = 0;
open(IMG, "<$rand_loc$filename");

until(eof(IMG))
 {
 $line = <IMG>;
 chop($line);

 splice(@lines, 0);
 @lines = split(/\|/, $line);

 if ($line ne "")
  {
  @images[$line_count] = @lines[0];
  @urls[$line_count] = @lines[1];
  $line_count++;
  }
 }

close(IMG);
}

sub display_file
{
&read_file;

$max_val = @images + 5;

print "<HTML><TITLE>Random Image Rotator 2.0</TITLE><BODY>\n";
print "<CENTER><H2>Random Image Rotator 2.0</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Show all files</A><BR><BR>\n";

print "<TABLE BORDER=0>\n";
print "<TR><TD><B>Delete?</B></TD> <TD><B>Image URL</B></TD> <TD><B>Link URL</B></TD></TR>\n";

print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"save\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$FORM{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$FORM{'password'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=max VALUE=\"$max_val\">\n";

for ($j = 0; $j < $max_val; $j++)
 {
 $temp_image = @images[$j];
 $temp_url = @urls[$j];

 if ($temp_image eq "")
  {
  $temp_image = "http://";
  }

 if ($temp_url eq "")
  {
  $temp_url = "http://";
  }

 print "<TR><TD><INPUT TYPE=CHECKBOX NAME=del$j VALUE=\"Y\"></TD> <TD><INPUT NAME=image$j VALUE=\"$temp_image\" SIZE=30></TD> <TD><INPUT NAME=url$j VALUE=\"$temp_url\" SIZE=30></TD></TR>\n";
 }

print "<TR><TD COLSPAN=3><B>Filename:</B> <INPUT NAME=filename VALUE=\"$filename\"></TD></TR>\n";
print "<TR><TD COLSPAN=3><INPUT TYPE=submit NAME=submit VALUE=\"Save\"></TD></TR>\n";
print "</FORM></TABLE></CENTER></BODY></HTML>\n";
}

sub save_file
{
if ($filename eq "" or (not -w "$rand_loc$filename"))
 {
 print "<HTML><BODY>Cannot write to $rand_loc$filename</BODY></HTML>\n";
 exit;
 }

open(FILE, ">$rand_loc$filename");

for ($j = 0; $j < $max; $j++)
 {
 $temp_image1 = "image$j";
 $temp_image = $FORM{$temp_image1};

 $temp_url1 = "url$j";
 $temp_url = $FORM{$temp_url1};

 $temp_del1 = "del$j";
 $temp_del = $FORM{$temp_del1};

 if ($temp_image ne "" and "\L$temp_image\E" ne "http://" and $temp_del eq "")
  {
  print FILE "$temp_image\|$temp_url\n";
  }
 }

close(FILE);

print "Saved <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}&filename=$filename\">$filename</A><BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$FORM{'username'}&password=$FORM{'password'}\">Show all files</A><BR>\n";
}
